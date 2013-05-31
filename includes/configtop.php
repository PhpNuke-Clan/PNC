<?php
if ( !defined('NUKE_FILE') )
{
        die("You can't access this file directly...");
}
$numnextactions =        "2"; // limit display to x next actions
$numlastactions =        "3"; // limit display to x last actions

include("config.php");
global $vwarmodname, $prefix, $db, $dbi, $sitename, $n, $nukeurl, $bgcolor1, $bgcolor2,$bgcolor3, $bgcolor4;
if (file_exists("modules/".$vwarmodname."/includes/_config.inc.php")) {
require("modules/".$vwarmodname."/includes/_config.inc.php");
}
$result = $db->sql_query("SELECT ownnameshort,ownhomepage,waroverlap,longdateformat FROM vwar".$n."_settings");
$ownnameshort=$result[0];
echo"<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" align=\"center\">";
$numnextwars=$db->sql_numrows($db->sql_query("SELECT * FROM vwar".$n." WHERE status='0' AND dateline > '".time()."'"));
?>
