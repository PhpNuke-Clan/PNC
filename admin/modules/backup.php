<?php

/************************************************************************/
/* PHP-NUKE: Advanced Content Management System                         */
/* ============================================                         */
/*                                                                      */
/* Copyright (c) 2002 by Francisco Burzi                                */
/* http://phpnuke.org                                                   */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/**********************************************************************************************/
/* PNC 3.0.0: PHOENIX Edition                                 COPYRIGHT                       */
/*                                                                                            */
/* Copyright (c) 2005 - 2006 by http://phpnuke-clan.com                                       */
/*  PHPNUKE-CLAN - SUPPORT                (support@phpnuke-clan.com)                          */
/*  PNC 3.0.0  Online Installation Guide - http://www.phpnuke-clan.com/guide/3.0.0/index.htm  */
/**********************************************************************************************/
/* PHP-Nuke Platinum: Expect to be impressed                  COPYRIGHT */ 
/*                                                                      */ 
/* Copyright (c) 2004 - 2006 by http://www.techgfx.com                  */ 
/*     Techgfx - Graeme Allan                       (goose@techgfx.com) */ 
/*                                                                      */ 
/* Copyright (c) 2004 - 2006 by http://www.conrads-berlin.de            */ 
/*     MrFluffy - Axel Conrads                 (axel@conrads-berlin.de) */ 
/*                                                                      */
/* Copyright (c) 2004 - 2006 by http://www.nukeplanet.com               */
/*     Loki / Teknerd - Scott Partee           (loki@nukeplanet.com)    */
/*                                                                      */
/* Refer to Nukeplanet.com for detailed information on PHP-Nuke Platinum*/
/*                                                                      */
/* TechGFX: Your dreams, our imagination                                */ 
/************************************************************************/

if ( !defined('ADMIN_FILE') ) {
	die("Illegal Admin File Access");
}

global $prefix, $db, $admin_file;
$aid = substr("$aid", 0,25);
$row = $db->sql_fetchrow($db->sql_query("SELECT radminsuper FROM " . $prefix . "_authors WHERE aid='$aid'"));
if ($row['radminsuper'] == 1) {

$gzipsupport = false;
$phpver = phpversion();
if ($phpver >= "4.0") {
    if (extension_loaded("zlib")) {
        $gzipsupport = true;
    }
}

switch($op) {
    
    case "BackupDB":
        set_time_limit(1200);
        $crlf="\n";

        // English Text
        $strNoTablesFound = "No tables found in database.";
        $strDatabase = "Database ";
        $strTableStructure = "Table structure for table";
        $strDumpingData = "Dumping data for table";
        $strError = "Error";
        $strSQLQuery = "SQL-query";
        $strMySQLSaid = "MySQL said: ";
        $strBack = "Back";
        $strDone = "On";
        $strat = "at";
        $strby = "by";
        $date_jour = date ("m-d-Y");
        
        $filename = $dbname."_".$date_jour.".sql";
/*
        header("Content-disposition: filename=$filename");
        header("Content-type: application/octetstream");
        header("Pragma: no-cache");
        header("Expires: 0");
*/
        global $gzip;
        $do_gzip_compress = ($gzip && $gzipsupport);
        if ($do_gzip_compress) {
            ob_end_clean();
            ob_start();
            ob_implicit_flush(0);
            header("Content-Type: application/x-gzip; name=\"$filename.gz\"");
            header("Content-disposition: attachment; filename=$filename.gz");
        }
        else {
            header("Content-Type: text/x-delimtext; name=\"$filename\"");
            header("Content-disposition: attachment; filename=$filename");
        }
        
        // doing some DOS-CRLF magic...
        $client = $_SERVER["HTTP_USER_AGENT"];
        if(ereg('[^(]*\((.*)\)[^)]*',$client,$regs)) {
            $os = $regs[1];
            // this looks better under WinX
            if (eregi("Win",$os)) $crlf="\r\n";
        }

        function gzip_PrintFourChars($Val) {
            for ($i = 0; $i < 4; $i ++) {
                $return .= chr($Val % 256);
                $Val = floor($Val / 256);
            }
            return $return;
        }

        // Get the content of $table as a series of INSERT statements.
        function get_table_content($db, $table)
        {
            global $crlf, $db;
            $result = $db->sql_query("SELECT * FROM $table") or mysql_die();
            $fieldcount = @mysql_num_fields($result);
            $fields = "";
            if(isset($GLOBALS["showcolumns"])) {
                $fields = "(";
                for($j=0; $j<$fieldcount;$j++) {
                    if ($j>0) $fields .= ", ";
                    $fields .= @mysql_field_name($result,$j);
                }
                $fields .= ") ";
            }
            while($row = $db->sql_fetchrow($result)) {
                $str = "INSERT INTO $table $fields";
                $str .= "VALUES (";
                for($j=0; $j<$fieldcount;$j++) {
                    if ($j>0) $str .= ", ";
                    if(!isset($row[$j])) { $str .= "NULL"; }
                    elseif($row[$j] != "") { $str .= "'".addcslashes(addslashes($row[$j]), "\n\r")."'"; }
                    else { $str .= "''"; }
                }
                $str .= ");$crlf";
                echo $str;
//                echo utf8_encode($str);
            }
            $db->sql_freeresult($result);
            return true;
        }
        
        // Return $table's CREATE definition
        // Returns a string containing the CREATE statement on success
        function get_table_def($db, $table, $crlf)
        {
            $schema_create = "";
            global $drop;
            if ($drop == 1) {
                $schema_create .= "DROP TABLE IF EXISTS $table;$crlf";
            }
            $schema_create .= "CREATE TABLE $table ($crlf";
        
            $result = @mysql_db_query($db, "SHOW FIELDS FROM $table") or mysql_die();
            while($row = @mysql_fetch_array($result)) {
                $schema_create .= "   `$row[Field]` $row[Type]";        
                if(isset($row["Default"]) && (!empty($row["Default"]) || $row["Default"] == "0"))
                    $schema_create .= " DEFAULT '$row[Default]'";
                if($row["Null"] != "YES")
                    $schema_create .= " NOT NULL";
                if($row["Extra"] != "")
                    $schema_create .= " $row[Extra]";
                $schema_create .= ",$crlf";
            }
            $schema_create = ereg_replace(",".$crlf."$", "", $schema_create);
            $result = @mysql_db_query($db, "SHOW KEYS FROM $table") or mysql_die();
            //@RJR-Pwmg@Rncvkpwo@-@Eqratkijv@(e)@VgejIHZ.eqo
            while($row = @mysql_fetch_array($result)) {
                $kname=$row['Key_name'];
                if (($kname != "PRIMARY") && ($row['Non_unique'] == 0))
                    $kname="UNIQUE|$kname";
                if ($row['Index_type'] == "FULLTEXT")
                    $kname="FULLTEXT|$kname";
                if (!isset($index[$kname]))
                     $index[$kname] = array();
                 $index[$kname][] = $row['Column_name'];
            }
        
            while(list($x, $columns) = @each($index)) {
                 $schema_create .= ",$crlf";
                 if($x == "PRIMARY")
                     $schema_create .= "   PRIMARY KEY (" . implode($columns, ", ") . ")";
                 elseif (substr($x,0,6) == "UNIQUE")
                    $schema_create .= "   UNIQUE ".substr($x,7)." (" . implode($columns, ", ") . ")";
                 elseif (substr($x,0,8) == "FULLTEXT")
                    $schema_create .= "   FULLTEXT ".substr($x,9)." (" . implode($columns, ", ") . ")";
                 else
                    $schema_create .= "   KEY $x (" . implode($columns, ", ") . ")";
            }
        
            $schema_create .= "$crlf)";
            return (stripslashes($schema_create));
        }
        
        function mysql_die($error = "")
        {
            echo "<b> $strError </b><p>";
            if(isset($sql_query) && !empty($sql_query)) {
                echo "$strSQLQuery: <pre>$sql_query</pre><p>";
            }
            if(empty($error))
                echo $strMySQLSaid.@mysql_error();
            else
                echo $strMySQLSaid.$error;
            echo "<br><a href=\"javascript:history.go(-1)\">$strBack</a>";
            exit;
        }
        
        global $dbhost, $dbuname, $dbpass, $dbname, $tablelist;
        @mysql_pconnect($dbhost, $dbuname, $dbpass);
        @mysql_select_db("$dbname") or die ("Unable to select database");

        if (is_array($tablelist) && count($tablelist) > 0) {
            $tables = $tablelist;
            $num_tables = count($tablelist);
        } else {
            $tablelist = @mysql_list_tables($dbname);
            $num_tables = @mysql_numrows($tablelist);
            if($num_tables > 0) for ($i = 0; $i < $num_tables; $i++) {
                $tables[] = @mysql_tablename($tablelist, $i);
            }
        }
        
        if($num_tables == 0) {
            echo $strNoTablesFound;
        }
        else {
            $i = 0;
            $heure_jour = date ("H:i");
            print "# ========================================================$crlf"
            ."#$crlf"
            ."# $strDatabase : $dbname$crlf"
            ."# $strDone $date_jour $strat $heure_jour $strby $name !$crlf"
            ."#$crlf"
            ."# ========================================================$crlf"
            ."$crlf";
            
            foreach($tables AS $table) {
                print $crlf."# --------------------------------------------------------$crlf"
                ."#$crlf"
                ."# $strTableStructure '$table'$crlf"
                ."#$crlf$crlf";

                echo get_table_def($dbname, $table, $crlf).";$crlf$crlf";
                
                print "#$crlf"
                ."# $strDumpingData '$table'$crlf"
                ."#$crlf$crlf";

                set_time_limit(1200);
                get_table_content($dbname, $table);
            }
        }
        //Header("Location: ".$admin_file.".php?op=adminMain");

        if($do_gzip_compress) {
            $Size = ob_get_length();
            $Crc = crc32(ob_get_contents());
            $contents = gzcompress(ob_get_contents());
            ob_end_clean();
            echo "\x1f\x8b\x08\x00\x00\x00\x00\x00".substr($contents, 0, strlen($contents) - 4).gzip_PrintFourChars($Crc).gzip_PrintFourChars($Size);
        }

        exit;
        break;
        
    case "database":
        include("header.php");
        GraphicAdmin("General");
        OpenTable();
        echo "<center><font class=\"title\"><b>"._SAVEDATABASE."</b></font></center>";
        CloseTable();
        echo "<br>";
        OpenTable();
        echo '<form method="post" name="backup" action="".$admin_file.".php">'
            .'<table><tr>';

        echo '<td><SELECT NAME="tablelist[]" size="20" multiple>';
        $tables = @mysql_list_tables($dbname);
        for ($i = 0; $i < @mysql_num_rows($tables); $i++) {
            $table = @mysql_tablename($tables, $i);
            echo "<OPTION VALUE=\"$table\">$table</OPTION>";
        }
        @mysql_free_result($result);
        echo "</SELECT></td>";

        echo '<td>Action:<br><SELECT NAME="op">'
            .'<OPTION VALUE="BackupDB">'._SAVEDATABASE.'</OPTION>'
            .'<OPTION VALUE="OptimizeDB">Optimize</OPTION>'
            .'<OPTION VALUE="CheckDB">Check</OPTION>'
            .'<OPTION VALUE="AnalyzeDB">Analyze</OPTION>'
            .'<OPTION VALUE="RepairDB">Repair</OPTION>'
            .'<OPTION VALUE="StatusDB">Status</OPTION>'
            .'</SELECT>'
            .'<br><br>For backup only:<br><input type="checkbox" value="1" NAME="drop">Include drop statement<br>';
//        if ($gzipsupport) {
//            echo '<input type="checkbox" value="1" NAME="gzip">Use compression<br><br>';
//        } else {
//            echo 'Compression not supported<br><br>';
//        }
        echo '<input type="submit" value="'._GO.'"></td><td width="50%">';

        OpenTable2();
        echo '<b>OPTIMIZE</b><br>should be used if you have deleted a large part of a table or if you have made many changes to a table with variable-length rows (tables that have VARCHAR, BLOB, or TEXT columns). Deleted records are maintained in a linked list and subsequent INSERT operations reuse old record positions. You can use OPTIMIZE to reclaim the unused space and to defragment the datafile.<br>
In most setups you don\'t have to run OPTIMIZE at all. Even if you do a lot of updates to variable length rows it\'s not likely that you need to do this more than once a month/week and only on certain tables.<br>
OPTIMIZE works the following way:<ul>
<li>If the table has deleted or split rows, repair the table.
<li>If the index pages are not sorted, sort them.
<li>If the statistics are not up to date (and the repair couldn\'t be done by sorting the index), update them.
</ul>Note that the table is locked during the time OPTIMIZE is running!';
        CloseTable2();

        echo '</td></tr></table></form>';
        CloseTable();
        
        echo "<br>";
        
        OpenTable();
        echo '<form ENCTYPE="multipart/form-data" method="post" action="".$admin_file.".php" name="restore">
        Select a SQL/GZip file to restore/add into the database<br>
        <input type="file" name="sqlfile" size=80>&nbsp;&nbsp;<input type="hidden" name="op" value="RestoreDB"><input type="submit" value="Start SQL">
        </form>';
        CloseTable();

        include("footer.php");
        break;

    case "OptimizeDB":
    case "CheckDB":
    case "AnalyzeDB":
    case "RepairDB":
    case "StatusDB":
        $type = strtoupper(substr($op,0,-2));
        include("header.php");
        GraphicAdmin("General");
        OpenTable();
        echo "<center><font class=\"title\"><b>$type "._DATABASE."</b></font></center>";
        CloseTable();
        echo "<br>";
        OpenTable();
        global $dbhost, $dbuname, $dbpass, $dbname, $tablelist;
        @mysql_pconnect($dbhost, $dbuname, $dbpass);
        @mysql_select_db("$dbname") or die ("Unable to select database");

        if (is_array($tablelist) && count($tablelist) > 0) {
            $tables = $tablelist;
            $num_tables = count($tablelist);
        } else {
            $tablelist = @mysql_list_tables($dbname);
            $num_tables = @mysql_numrows($tablelist);
            if($num_tables > 0) for ($i = 0; $i < $num_tables; $i++) {
                $tables[] = @mysql_tablename($tablelist, $i);
            }
        }

        if ($num_tables > 0) {
            if ($type == "STATUS") {
                $query = 'SHOW TABLE STATUS FROM '.$dbname;
            } else {
                $query = "$type TABLE ";
                foreach($tables AS $table) {
                    if ($query != "$type TABLE ") $query .= ", ";
                    $query .= $table;
                }
            }

            $result = @mysql_query($query);

            $numfields = @mysql_num_fields($result);
            echo '<table border="1"><tr>';
            for($j=0; $j<$numfields;$j++) {
                echo '<td align="center"><b>'.@mysql_field_name($result,$j).'</b></td>';
            }
            echo '</tr>';
            while($row = @mysql_fetch_row($result)) {
                echo '<tr>';
                for($j=0; $j<$numfields;$j++) {
                    echo '<td>'.$row[$j].'</td>';
                }
                echo '</tr>';
            }
            echo '</table>';
        }
        CloseTable();
		        include("footer.php");
        break;
            
    case "RestoreDB":
        include("header.php");
        include("includes/sql_parse.php");

        $sqlfile_tmpname = $HTTP_POST_FILES['sqlfile']['tmp_name'];
        $sqlfile_name = $HTTP_POST_FILES['sqlfile']['name'];
        $sqlfile_type = (!empty($HTTP_POST_FILES['sqlfile']['type'])) ? $HTTP_POST_FILES['sqlfile']['type'] : "";
//$_FILES
        if ($sqlfile_tmpname == '' || $sqlfile_name == '') die("ERROR no file specified!");

        if( preg_match("/^(text\/[a-zA-Z]+)|(application\/(x\-)?gzip(\-compressed)?)|(application\/octet-stream)$/is", $sqlfile_type) ) {
            if( preg_match("/\.gz$/is",$sqlfile_name) ) {
                if($gzipsupport) {
                    $gz_ptr = gzopen($sqlfile_tmpname, 'rb');
                    $sql_query = "";
                    while( !gzeof($gz_ptr) ) {
                        $sql_query .= gzgets($gz_ptr, 100000);
                    }
                } else {
                    die("ERROR Can't decompress file");
                }
            } else {
                $sql_query = fread(fopen($sqlfile_tmpname, 'r'), filesize($sqlfile_tmpname));
            }
        } else {
            die("ERROR filename incorrect $sqlfile_type $sqlfile_name");
        }

        GraphicAdmin("General");
        OpenTable();
        if($sql_query != "") {
            $sql_query = remove_remarks($sql_query);
            $pieces = split_sql_file($sql_query, ";\n");

            foreach($pieces AS $query) {
                set_time_limit(1200);
                $db->sql_query($query);
//                echo "$query<br>";
            }
            echo "<h2 align=\"center\">Finnished adding $sqlfile_name to the database</h2>";
        }
        CloseTable();
        include("footer.php");
        break;
}

} else {
    echo "Access Denied";
}

?>
