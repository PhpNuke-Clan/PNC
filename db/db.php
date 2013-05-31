<?php
/***************************************************************************
 *                                 db.php
 *                            -------------------
 *   begin                : Saturday, Feb 13, 2001
 *   copyright            : (C) 2001 The phpBB Group
 *   email                : support@phpbb.com
 *
 *   $Id: db.php,v 1.10.2.3 2005/10/30 15:17:14 acydburn Exp $
 *
 *
 ***************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/

if (stristr($_SERVER['PHP_SELF'], "db.php")) {
    Header("Location: index.php");
    die();
}

if (defined('FORUM_ADMIN')) {
    $the_include = "../../../db";
} elseif (defined('INSIDE_MOD')) {
    $the_include = "../../db";
} else {
    $the_include = "db";
}

switch($dbtype) {

        case 'MySQL':
                include("".$the_include."/mysql.php");
                break;

        case 'mysql4':
                include("".$the_include."/mysql4.php");
                break;

        case 'sqlite':
                include("".$the_include."/sqlite.php");
                break;
        case 'postgres':
                include("".$the_include."/postgres7.php");
                break;

        case 'mssql':
                include("".$the_include."/mssql.php");
                break;

        case 'oracle':
                include("".$the_include."/oracle.php");
                break;

        case 'msaccess':
                include("".$the_include."/msaccess.php");
                break;

        case 'mssql-odbc':
                include("".$the_include."/mssql-odbc.php");
                break;
        
        case 'db2':
                include("".$the_include."/db2.php");
                break;
}

// Make the database connection.
$db = new sql_db($dbhost, $dbuname, $dbpass, $dbname, false);
if(!$db->db_connect_id)
{    die("<br><br><center><img src=images/logo.gif><br><br><b>There seems to be a problem with the $dbtype server, sorry for the inconvenience.<br><br>We should be back shortly.</center></b>");
        //message_die(CRITICAL_ERROR, "Could not connect to the database");
}
if($db->db_connect_id)
$exists = $db->sql_query("SELECT 1 FROM `".$prefix."_authors` LIMIT 0");
   if (!$exists)
{    die("<br><br><center><img src=images/logo.gif><br><br><b>There seems to be a problem with the $dbtype server, sorry for the inconvenience.<br><br>We should be back shortly.</center></b>");
        //message_die(CRITICAL_ERROR, "Could not connect to the database");
}

?>
