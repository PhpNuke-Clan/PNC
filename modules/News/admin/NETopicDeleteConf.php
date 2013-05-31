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
$topicid = intval($topicid);
$result = $db->sql_query("SELECT * FROM `".$prefix."_stories` WHERE `topic`='$topicid'");
while($row = $db->sql_fetchrow($result)) {
  $row['sid'] = intval($row['sid']);
  $db->sql_query("DELETE FROM `".$prefix."_comments` WHERE `sid`='".$row['sid']."'");
}
$db->sql_query("OPTIMIZE TABLE `".$prefix."_comments`");
if($ne_config['hometopic'] == $topicid) { ne_save_config("hometopic", "0"); }
$db->sql_query("DELETE FROM `".$prefix."_stories` WHERE `topic`='$topicid'");
$db->sql_query("OPTIMIZE TABLE `".$prefix."_stories`");
$db->sql_query("DELETE FROM `".$prefix."_autonews` WHERE `topic`='$topicid'");
$db->sql_query("OPTIMIZE TABLE `".$prefix."_autonews`");
$db->sql_query("DELETE FROM `".$prefix."_topics` WHERE `topicid`='$topicid'");
$db->sql_query("OPTIMIZE TABLE `".$prefix."_topics`");
$db->sql_query("DELETE FROM `".$prefix."_related` WHERE `tid`='$topicid'");
$db->sql_query("OPTIMIZE TABLE `".$prefix."_related`");
header("Location: ".$admin_file.".php?op=NETopicIndex");

?>