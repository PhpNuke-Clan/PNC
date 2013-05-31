<?php
if ( !defined('ADMIN_FILE') )
{
	die ("Access Denied");
}
//if (!eregi("admin.php", $_SERVER['SCRIPT_NAME'])) { die ("Access Denied"); }

global $prefix, $db, $admin_file;
if (!eregi("".$admin_file.".php", $_SERVER['PHP_SELF'])) { die ("Access Denied"); }
$aid = substr("$aid", 0,25);
$row = $db->sql_fetchrow($db->sql_query("SELECT title, admins FROM ".$prefix."_modules WHERE title='4nLan'"));
$row2 = $db->sql_fetchrow($db->sql_query("SELECT name, radminsuper FROM ".$prefix."_authors WHERE aid='$aid'"));
$admins = explode(",", $row['admins']);
$auth_user = 0;
for ($i=0; $i < sizeof($admins); $i++) {
    if ($row2['name'] == "$admins[$i]" AND $row['admins'] != "") {
        $auth_user = 1;	
    }
}

if ($row2['radminsuper'] == 1 || $auth_user == 1) {

include("config.php");
include("header.php");
//$index=1;
define('INDEX_FILE', true);
global $prefix, $db, $admin_file;
//OpenTable();
title("XFireAdmin");
//CloseTable();
OpenTable();


echo"<meta http-equiv=\"REFRESH\" content=\"2;url=".$admin_file.".php?op=XFireAdmin\">";


$id = $_GET["id"];
$perpage = $_POST["Perpage"];
$style = $_POST["Style"];
$size = $_POST["Size"];
$sort = $_POST["Sort"];
$cmd = $_GET["cmd"];

if(!isset($cmd))
{
$result = $db->sql_query("select id, Perpage, Style, Size, Sort from ".$prefix."_xfirecfg");
while($row=$db->sql_fetch_array($result))
 {
$id=$row["id"];
$perpage=$row["Perpage"];
$style=$row["Style"];
$size=$row["Size"];
$sort=$row["Sort"];
 }
}

if($_GET["cmd"]=="change")
{/*
$serverid = mysql_connect($dbhost, $dbuname, $dbpass) or die ("Cannot connect to database!");
if (!mysql_select_db($dbname)) {
    echo mysql_error($serverid);
}
*/
$query = "UPDATE ".$prefix."_xfirecfg SET Perpage = '$perpage', Style = '$style', Size = '$size', Sort = '$sort' WHERE id='$id'";
$sql = $db->sql_query($query) or die('Could not delete: '.$db->sql_error());
echo "<center><b>Options</b><br>have been changed!</center>";
}

CloseTable();
include("footer.php");
} else {
    echo "Access Denied";
}
?>