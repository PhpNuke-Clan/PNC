<?php

 /* #####################################################################################
  *
  * $Id: scarbook.php,v 1.11 2004/02/21 22:49:59 frag Exp $
  * ScarBook v1.2 - Convertor for vBook 2.0
  *
  * This notice must remain untouched at all times.
  *
  * Modifications to the script, except the official addons or hacks,
  * without the owners permission are prohibited.
  * All rights reserved to their proper authors.
  *
  * Get the latest version at http://www.vwar.de - Copyright (C) 2001-2003
  *
  * #####################################################################################
  */

// ############################### GLOBAL VARS #########################################
$reqvbookversion = "2.0";
$program = "vBook 2.0";
$source = "ScarBook v1.2 (SQL-Version)";
$string = $source." to ".$program." Conversion";
$updatemode = 2;

// ############################### GET FUNCTIONS #######################################
$vwar_root = "./";
require($vwar_root."includes/functions_install.php");

// ############################### DEFINE TABLES #######################################
$tables = array(
    "vwar".$n."_gbentries",
    "vwar".$n."_comments");

// ############################### CREATE DB OBJECT ####################################
$vwardb = new vwardb($sql["hostname"],$sql["username"],$sql["password"],$sql["database"]);

// ############################### VERSION CHECK #######################################
$result = $vwardb->query_first("SELECT version FROM vwar".$n."_gbsettings");
if ($result["version"] < $reqvbookversion)
{
	printHeader($string,$updatemode);
	?>
    <table border="0" align="center" width="100%" cellpadding="5" cellspacing="0" class="tblborder">
		<tr>
			<td class="tblhead">Error</td>
		</tr>
		<tr>
			<td class="firstalt" align="center"><br />
			   <b>This Convertor only runs with Version <?php echo $reqvbookversion; ?> or higher of vBook installed!<br><br><font color="red">Installation Aborted!</font></b><br><br>
			</td>
		</tr>
	</table>
    <?php
	exit;
}

// ############################### TABLE CHECK #########################################
$result = mysql_list_tables($sql["database"]);
for($i = 0; $i < mysql_num_rows($result); $i++)
{
    if(inarray(mysql_tablename($result, $i), $tables))
    {
        $check = 1;
        break;
    }
}

if($check == 0 || !isset($check))
{
    printHeader($string,$updatemode);
    ?>
	<table border="0" align="center" width="100%" cellpadding="5" cellspacing="0" class="tblborder">
		<tr>
			<td class="tblhead">Error</td>
		</tr>
		<tr>
			<td class="firstalt" align="center"><br /><br />
				<b>One or more required tables cannot be found.<br><br><font color="red">Installation Aborted!</font></b><br><br>
			</td>
		</tr>
	</table>
    <?php
    exit;
}

// ############################### STEPS ###############################################
$step = $GPC["step"];

if (!isset($step))
{
    printHeader($string,$updatemode);
	?>
	<form action="<?php echo $GPC["PHP_SELF"]; ?>?step=1" method="post">
	<table border="0" align="center" width="100%" cellpadding="5" cellspacing="0" class="tblborder">
		<tr>
			<td class="tblhead" colSpan="2"><b>Settings</b></td>
		</tr>
		<tr>
			<td class="sectionhead" colSpan="2"><b>Database from <?php echo $source; ?></b></td>
		</tr>
		<tr>
			<td class="firstalt" width="30%"><b>Server</b></td>
			<td class="firstalt"><input type="text" name="settings[hostname]" size="20" value="<?php echo $sql["hostname"]; ?>" class="input"></td>
		</tr>
		<tr>
			<td class="secondalt"><b>Database</b></td>
			<td class="secondalt"><input type="text" name="settings[database]" size="20" value="<?php echo $sql["database"]; ?>" class="input"></td>
		</tr>
		<tr>
			<td class="firstalt"><b>Username</b></td>
			<td class="firstalt"><input type="text" name="settings[username]" size="20" value="<?php echo $sql["username"]; ?>" class="input"></td>
		</tr>
		<tr>
			<td class="secondalt"><font color="red"><b>Password</b></font><br /><small>please enter the password</small></td>
			<td class="secondalt"><input type="password" name="settings[password]" size="20" class="input"></td>
		</tr>
		<tr>
			<td class="sectionhead" colSpan="3"><b>Tables from <?php echo $source; ?></b></td>
		</tr>
		<tr>
			<td class="firstalt" width="30%"><b>Table (Entries)</b><br /><small>default value inserted</small></td>
			<td class="firstalt"><input type="text" name="settings[tableentries]" size="20" value="scarbook_msg" class="input"></td>
		</tr>
		<tr>
			<td class="sectionhead" colSpan="3"><b>Convertor Settings</b></td>
		</tr>
		<tr>
			<td class="firstalt" width="30%"><b>Clear vBook</b><br /><small>this will delete all existing posts before converting</small></td>
			<td class="firstalt"><select name="settings[clear]" class="input"><option value="1">Yes</option><option value="0" selected>No</option></select></td>
		</tr>
		<tr>
			<td class="secondalt" width="30%"><b>Import Comments</b></td>
			<td class="secondalt"><select name="settings[comments]" class="input"><option value="1" selected>Yes</option><option value="0">No</option></select></td>
		</tr>
		<tr>
			<td class="firstalt" width="30%"><b>Name for Comments</b><br /><small>this name will be used for the comments<br />because <?php echo $source; ?> dont save a name</small></td>
			<td class="firstalt"><input type="text" name="settings[commentname]" size="20" value="[converted]" class="input"></td>
		</tr>
		<tr>
			<td class="secondalt" width="30%"><b>Convert Smilies</b></td>
			<td class="secondalt"><select name="settings[smilies]" class="input"><option value="1" selected>Yes</option><option value="0">No</option></select></td>
		</tr>
		<tr>
			<td class="formsubmit" align="center" colspan="2">
                <input type="submit" name="save" value="Start Conversion" class="inputbutton">&nbsp;<input type="reset" value="Reset" class="inputbutton"></td>
			</td>
		</tr>
	</table>
	</form>
<?php
}

// ############################### CONVERT #############################################
if ($step == 1)
{
    $settings = $GPC["settings"];
    if((empty($settings["hostname"]) || empty($settings["username"]) || empty($settings["database"]) || empty($settings["tableentries"]))
        || empty($settings["commentname"]))
    {
        printHeader($string,$updatemode);
        ?>
	<table border="0" align="center" width="100%" cellpadding="5" cellspacing="0" class="tblborder">
		<tr>
			<td class="tblhead">Error</td>
		</tr>
		<tr>
			<td class="firstalt" align="center"><br />
                <font color="red"><b>Not all required fields were filled correctly!</b></font><br />
                Please verify the entered data!<br /><br />
                <a href="javascript:history.go(-1)">Click here to go back</a><br /><br />
            </td>
		</tr>
	</table>
        <?php
        exit;
    }
	
    // create database object for source
    $sourcedb = new vwardb($settings["hostname"],$settings["username"],$settings["password"],$settings["database"]);

    // get data from source
    $result = $sourcedb->query("
        SELECT name,email,hp,icq,icon,text,ip,time,kommentar
        FROM ".$settings["tableentries"]);

    $amount = $sourcedb->num_rows($result);
    $entry = 0;
    while($row = $sourcedb->fetch_array($result))
    {
        $cache[$entry] = $row;
        $entry++;
    }

    // close connection
    mysql_close($sourcedb->link_id);
    unset($sourcedb);

    // convert smilies
    $icons = array(
        ":top:" => 72, ":icon_pfeil:" => 0, ":icon_smile:" => 1, ":icon_txt:" => 0,
        ":icon_zunge:" => 6, ":icon_zwinker:" => 5, ":icon_achtung:" => 71, ":flop:" => 73,
        ":icon_frage:" => 70, ":icon_biggrin:" => 4, ":icon_boese:" => 9, ":icon_cool:" => 7,
        ":icon_oh:" => 10, ":icon_angst:" => 2);

    if($settings["smilies"] == 1)
    {
        $smilies = array(
            "?(" => ":confused:", "8)" => ":cool:", ";(" => ":(", ":devoius:" => "", "8o" => ":eek:", ":))" => ":D",
            "X(" => ":mad:", ":O" => ":o", ":-)" => ":)", ":p" => ":P");

        for($i = 0; $i < count($cache); $i++)
        {
            foreach($smilies as $search => $replace)
            {
                $cache[$i]["text"] = str_replace($search,$replace,$cache[$i]["text"]);
            }
        }
        unset($i);
    }

    // insert entries
    $commentname = empty($settings["commentname"]) ? "[converted]" : $settings["commentname"];
    for($i = 0; $i < count($cache); $i++)
    {
        $icon = $icons[$cache[$i]["icon"]];
        $vwardb->query("
            INSERT INTO vwar".$n."_gbentries (ip,dateline,guesthomepage,guestemail,guesticq,guestname,text,iconid) VALUES
                ('".$cache[$i]["ip"]."','".$cache[$i]["time"]."',
                '".$cache[$i]["hp"]."','".$cache[$i]["email"]."',
                '".$cache[$i]["icq"]."','".$cache[$i]["name"]."',
                '".$cache[$i]["text"]."','".$icons[$cache[$i]["icon"]]."')");

        if($settings["comments"] == 1 && !empty($cache[$i]["kommentar"]))
        {
            $lastid = $vwardb->insert_id();

            // import comments
            if($settings["smilies"] == 1)
            {
                foreach($smilies as $search => $replace)
                {
                    $cache[$i]["kommentar"] = str_replace($search,$replace,$cache[$i]["kommentar"]);
                }
            }

            $vwardb->query("
                INSERT INTO vwar".$n."_comments (sourceid,frompage,dateline,ip,guestname,comment) VALUES
                    ('".$lastid."','gb','".$cache[$i]["time"]."','[converted]',
                    '".$commentname."','".$cache[$i]["kommentar"]."')");

            unset($lastid);
        }
        
        unset($icon);
    }

    printHeader($string,$updatemode);
    ?>
	<table border="0" align="center" width="100%" cellpadding="5" cellspacing="0" class="tblborder">
		<tr>
			<td class="tblhead">Finished</td>
		</tr>
		<tr>
			<td class="firstalt" align="center">
                <br /><br />All entries are converted!<br /><br /><font color="red"><b>Delete this file!</b></font><br /><br />
			</td>
		</tr>
	</table>
    <?php
}

?>
