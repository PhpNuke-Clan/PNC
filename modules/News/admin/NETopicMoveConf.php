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
$newtop = intval($newtop);
if($ne_config['hometopic'] == $topicid) { ne_save_config("hometopic", "$newtop"); }
$db->sql_query("UPDATE `".$prefix."_stories` SET `topic`='$newtop' WHERE `topic`='$topicid'");
$db->sql_query("UPDATE `".$prefix."_autonews` SET `topic`='$newtop' WHERE `topic`='$topicid'");
$db->sql_query("DELETE FROM `".$prefix."_topics` WHERE `topicid`='$topicid'");
$db->sql_query("OPTIMIZE TABLE `".$prefix."_topics`");
$db->sql_query("DELETE FROM `".$prefix."_related` WHERE `tid`='$topicid'");
$db->sql_query("OPTIMIZE TABLE `".$prefix."_related`");
header("Location: ".$admin_file.".php?op=NETopicIndex");

?>