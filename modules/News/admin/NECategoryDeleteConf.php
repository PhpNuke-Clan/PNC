<?php

/********************************************************/
/* NSN News                                             */
/* By: NukeScripts Network (webmaster@nukescripts.net)  */
/* http://www.nukescripts.net                           */
/* Copyright © 2000-2005 by NukeScripts Network         */
/********************************************************/
/* Based on: Threaded Discussion                        */
/* Copyright (C) 2000  Thatware Development Team        */
/* http://atthat.com/                                   */
/********************************************************/

if(!defined('NSNNE_ADMIN')) { die("Illegal File Access Detected!!"); }
$catid = intval($catid);
$db->sql_query("DELETE FROM `".$prefix."_stories_cat` WHERE `catid`='$catid'");
$db->sql_query("OPTIMIZE TABLE `".$prefix."_stories_cat`");
$result = $db->sql_query("SELECT `sid` FROM `".$prefix."_stories` WHERE `catid`='$catid'");
while(list($sid) = $db->sql_fetchrow($result)) {
  $db->sql_query("DELETE FROM `".$prefix."_stories` WHERE `sid`='$sid'");
  $db->sql_query("DELETE FROM `".$prefix."_comments` WHERE `sid`='$sid'");
}
$db->sql_freeresult($result);
$db->sql_query("OPTIMIZE TABLE `".$prefix."_stories`");
$db->sql_query("OPTIMIZE TABLE `".$prefix."_comments`");
header("Location: ".$admin_file.".php?op=NECategoryIndex");

?>