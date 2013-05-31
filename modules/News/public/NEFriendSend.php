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

if(!defined('NSNNE_PUBLIC')) { die("Illegal File Access Detected!!"); }
$fname = ne_check_html(ne_convert_text($fname), 0);
$fmail = ne_check_html(ne_convert_text($fmail), 0);
$yname = ne_check_html(ne_convert_text($yname), 0);
$ymail = ne_check_html(ne_convert_text($ymail), 0);
$sid = intval($sid);
$result = $db->sql_query("SELECT `title`, `time`, `topic` FROM `".$prefix."_stories` WHERE `sid`='$sid'");
$row = $db->sql_fetchrow($result);
$db->sql_freeresult($result);
$title = ne_check_html(ne_convert_text($row['title']), 0);
$time = $row['time'];
$topic = intval($row['topic']);
$result = $db->sql_query("SELECT `topictext` FROM `".$prefix."_topics` WHERE `topicid`='$topic'");
$row = $db->sql_fetchrow($result);
$db->sql_freeresult($result);
$topictext = ne_check_html(ne_convert_text($row['topictext']), 0);
$subject = _NE_INTERESTING." $sitename";
$message = _NE_HELLO." $fname:\n\n"._NE_YOURFRIEND." $yname "._NE_CONSIDERED."\n\n\n$title\n"._NE_DATE.": $time\n"._NE_TOPIC.": $topictext\n\n"._NE_URL.": $nukeurl/".$module_link."op=NEArticle&sid=$sid\n\n"._NE_YOUCANREAD." $sitename\n$nukeurl";
mail($fmail, $subject, $message, "From: \"$yname\" <$ymail>\nX-Mailer: PHP/" . phpversion());
update_points(6);
$title = urlencode($title);
$fname = urlencode($fname);
header("Location: ".$module_link."op=NEFriendSent&sid=$sid");

?>