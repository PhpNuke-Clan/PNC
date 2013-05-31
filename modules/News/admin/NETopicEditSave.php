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
$topicname = stripslashes(ne_check_html(ne_convert_text($topicname), 0));
$topicimage = ne_check_html(ne_convert_text($topicimage), 0);
$topictext = stripslashes(ne_check_html(ne_convert_text($topictext), 0));
$rname = stripslashes(ne_check_html(ne_convert_text($rname), 0));
$rurl = ne_check_html(ne_convert_text($rurl), 0);
if(!get_magic_quotes_runtime()) {
  $topicname = addslashes($topicname);
  $topicimage = addslashes($topicimage);
  $topictext = addslashes($topictext);
  $rname = addslashes($rname);
  $rurl = addslashes($rurl);
}
$db->sql_query("UPDATE `".$prefix."_topics` SET `topicname`='$topicname', `topicimage`='$topicimage', `topictext`='$topictext' WHERE `topicid`='$topicid'");
if($rname > "") { $db->sql_query("INSERT INTO `".$prefix."_related` (`tid`, `name`, `url`) VALUES ('$topicid', '$rname', '$rurl')"); }
header("Location: ".$admin_file.".php?op=NETopicIndex");

?>