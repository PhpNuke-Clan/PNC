<?php

/********************************************************/
/* NSN Groups                                           */
/* By: NukeScripts Network (webmaster@nukescripts.net)  */
/* http://www.nukescripts.net                           */
/* Copyright © 2000-2005 by NukeScripts Network         */
/********************************************************/

global $admin_file;
$mname = stripslashes(strip_tags($username, "<b><i><u>"));
$mname = stripslashes(strip_tags($username));
$gid = intval($gid);
if($mname == "" || intval($gid) == 0) {
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
list($muid) = $db->sql_fetchrow($db->sql_query("SELECT user_id FROM ".$user_prefix."_users WHERE username='$mname'"));
list($phpBB) = $db->sql_fetchrow($db->sql_query("SELECT phpBB FROM ".$prefix."_nsngr_groups WHERE gid='$gid'"));
$db->sql_query("INSERT INTO ".$prefix."_bbuser_group VALUES ('$phpBB', '$muid', '0')");
$stime = time();
$db->sql_query("INSERT INTO ".$prefix."_nsngr_users VALUES ('$gid', '$muid', '$mname' , '0', '0', '$stime', '0')");
Header("Location: ".$admin_file.".php?op=NSNGroupsUsersView");

?>