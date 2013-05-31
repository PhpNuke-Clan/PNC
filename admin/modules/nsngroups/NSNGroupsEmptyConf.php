<?php

/********************************************************/
/* NSN Groups                                           */
/* By: NukeScripts Network (webmaster@nukescripts.net)  */
/* http://www.nukescripts.net                           */
/* Copyright © 2000-2005 by NukeScripts Network         */
/********************************************************/
//echo $gid;
$getrow = $db->sql_fetchrow($db->sql_query("SELECT phpBB, muid FROM ".$prefix."_nsngr_groups WHERE gid='$gid'"));
$bbid = intval($getrow['phpBB']);
$bbmid = intval($getrow['muid']);
$db->sql_query("DELETE FROM ".$prefix."_nsngr_users WHERE gid ='$gid' AND uid !='$bbmid'");
$db->sql_query("OPTIMIZE TABLE ".$prefix."_nsngr_users");
$db->sql_query("DELETE FROM ".$prefix."_bbuser_group WHERE group_id ='$bbid' AND user_id !='$bbmid'");
$db->sql_query("OPTIMIZE TABLE ".$prefix."_bbuser_group");
Header("Location: ".$admin_file.".php?op=NSNGroupsView");

?>