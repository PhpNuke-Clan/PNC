<?php

/********************************************************/
/* NSN Groups                                           */
/* By: NukeScripts Network (webmaster@nukescripts.net)  */
/* http://www.nukescripts.net                           */
/* Copyright © 2000-2005 by NukeScripts Network         */
/********************************************************/

global $admin_file;
$gdesc = html_entity_decode($gdesc, ENT_QUOTES);
$gname = stripslashes(strip_tags($gname, "<b><i><u>"));
$gdesc = stripslashes(strip_tags($gdesc, "<br><b><i><u>"));
$gname = stripslashes(strip_tags($gname));
$gpublic = intval($gpublic);
$mname = $username;
if($gname == "" || $mname == "") {
  @include("header.php");
  OpenTable();
  echo "<center><b>"._GR_MISSINGDATA."</b></center><br>\n";
  echo "<center>"._GOBACK."</center>\n";
  CloseTable();
  @include("footer.php");
}
$sql = "SELECT user_id FROM ".$user_prefix."_users WHERE username='$mname' ";
if(!($result = $db->sql_fetchrow($db->sql_query($sql)))){
  @include("header.php");
  OpenTable();
  echo "<center><b>"._GR_INVLALIDUSERNAME."</b></center><br>\n";
  echo "<center>"._GOBACK."</center>\n";
  CloseTable();
  @include("footer.php");
  }
if (!get_magic_quotes_gpc()) { $gname = addslashes($gname); $gdesc = addslashes($gdesc); }
list($muid) = $db->sql_fetchrow($db->sql_query("SELECT user_id FROM ".$user_prefix."_users WHERE username='$mname'"));
$db->sql_query("INSERT INTO ".$prefix."_bbgroups VALUES (NULL, '$gpublic', '$gname', '$gdesc', '$muid', '0')");
$phpBB = $db->sql_nextid();
$db->sql_query("INSERT INTO ".$prefix."_bbuser_group VALUES ('$phpBB', '$muid', '0')");
list($phpBB) = $db->sql_fetchrow($db->sql_query("SELECT group_id FROM ".$prefix."_bbgroups WHERE group_name='$gname'"));
$db->sql_query("INSERT INTO ".$prefix."_nsngr_groups VALUES (NULL, '$gname', '$gdesc' , '$gpublic', '$glimit', '$phpBB', '$muid')");
$gid = $db->sql_nextid();
$stime = time();
$db->sql_query("INSERT INTO ".$prefix."_nsngr_users VALUES ('$gid', '$muid', '$mname' , '0', '0', '$stime', '0')");
Header("Location: ".$admin_file.".php?op=NSNGroupsView");

?>