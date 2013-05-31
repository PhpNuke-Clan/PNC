<?php

/********************************************************/
/* NSN Groups                                           */
/* By: NukeScripts Network (webmaster@nukescripts.net)  */
/* http://www.nukescripts.net                           */
/* Copyright © 2000-2005 by NukeScripts Network         */
/********************************************************/

$gdesc = html_entity_decode($gdesc, ENT_QUOTES);
$gname = stripslashes(strip_tags($gname, "<b><i><u>"));
$gdesc = stripslashes(strip_tags($gdesc, "<br><b><i><u>"));
$gname = stripslashes(strip_tags($gname));
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
list($phpBB) = $db->sql_fetchrow($db->sql_query("SELECT phpBB FROM ".$prefix."_nsngr_groups WHERE gid='$gid'"));
list($muid) = $db->sql_fetchrow($db->sql_query("SELECT user_id FROM ".$user_prefix."_users WHERE username='$mname'"));
$db->sql_query("UPDATE ".$prefix."_nsngr_groups SET gname='$gname', gdesc='$gdesc', gpublic='$gpublic', glimit='$glimit', muid='$muid' WHERE gid='$gid'");
$db->sql_query("UPDATE ".$prefix."_bbgroups SET group_name='$gname', group_type='$gpublic', group_description='$gdesc', group_moderator='$muid' WHERE group_id='$phpBB'");
$db->sql_query("OPTIMIZE TABLE ".$prefix."_nsngr_groups");
$db->sql_query("OPTIMIZE TABLE ".$prefix."_bbgroups");
if($muid <> $old_muid) {
  $stime = time();
  $db->sql_query("DELETE FROM ".$prefix."_nsngr_users WHERE gid='$gid' AND uid='$old_muid'");
  $db->sql_query("DELETE FROM ".$prefix."_bbuser_group WHERE group_id='$phpBB' AND user_id='$old_muid'");
  $gidnum = $db->sql_numrows($db->sql_query("SELECT uid FROM ".$prefix."_nsngr_users WHERE gid='$gid' AND uid='$muid'"));
  $phpnum = $db->sql_numrows($db->sql_query("SELECT user_id FROM ".$prefix."_bbuser_group WHERE group_id='$phpBB' AND user_id='$muid'"));
  if(!$gidnum || $gidnum == 0) {$db->sql_query("INSERT INTO ".$prefix."_nsngr_users VALUES ('$gid', '$muid', '$mname' , '0', '0', '$stime', '0')"); }
  if(!$phpnum || $phpnum == 0) {$db->sql_query("INSERT INTO ".$prefix."_bbuser_group VALUES ('$phpBB', '$muid', '0')"); }
  $db->sql_query("OPTIMIZE TABLE ".$prefix."_nsngr_users");
  $db->sql_query("OPTIMIZE TABLE ".$prefix."_bbuser_group");
}
global $admin_file;
Header("Location: ".$admin_file.".php?op=NSNGroupsView");

?>