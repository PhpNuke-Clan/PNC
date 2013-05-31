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
if(!isset($sid)) { header("Location: $nukeurl"); }
$sid = intval($sid);
$row = $db->sql_fetchrow($db->sql_query("SELECT * FROM `".$prefix."_stories` WHERE `sid`='$sid'"));
$title = ne_check_html(ne_convert_text($row['title']), 0);
$time = $row['time'];
$hometext = ne_check_html(ne_convert_text($row['hometext']), 1);
$bodytext = ne_check_html(ne_convert_text($row['bodytext']), 1);
$topic = intval($row['topic']);
$notes = ne_check_html(ne_convert_text($row['notes']), 1);
$counter = intval($row['counter']);
$counter++;
$db->sql_query("UPDATE `".$prefix."_stories` SET `counter`='$counter' WHERE `sid`='$sid'");
$row2 = $db->sql_fetchrow($db->sql_query("SELECT `topictext` FROM `".$prefix."_topics` WHERE `topicid`='$topic'"));
$topictext = ne_check_html(ne_convert_text($row2['topictext']), 0);
//formatTimestamp($time);
$timedate = strtotime($time);
$datetime = strftime(_NE_DATESTRING, $timedate);
echo "<html>";
echo "<head>";
echo "<title>$sitename - $title</title>";
echo "<base target=\"_blank\">";
echo "</head>";
echo "<body bgcolor=\"#ffffff\" text=\"#000000\">";
echo "<table border=\"0\" align=\"center\"><tr><td>";
echo "<table border=\"0\" width=\"640\" cellpadding=\"0\" cellspacing=\"1\" bgcolor=\"#000000\"><tr><td>";
echo "<table border=\"0\" width=\"640\" cellpadding=\"20\" cellspacing=\"1\" bgcolor=\"#ffffff\"><tr><td>";
echo "<center>";
echo "<span class=\"content\"><b>$title</b></span><br>";
echo "<span class=tiny><b>"._NE_DATE.":</b> $datetime<br><b>"._NE_TOPIC.":</b> $topictext</span><br><br>";
echo "</center>";
echo "<span class=\"content\">$hometext";
if(!empty($bodytext)) { echo "<br><br>$bodytext"; }
if(!empty($notes)) { echo "<br><br>$notes"; }
echo "</span>";
echo "</td></tr></table>";
echo "</td></tr></table>";
echo "<br><br><center>";
echo "<span class=\"content\">"._NE_COMESFROM." $sitename<br>";
echo "<a href=\"$nukeurl\">$nukeurl</a><br><br>";
echo ""._NE_THEURL."<br>";
echo "<a href=\"$nukeurl/".$module_link."op=NEArticle&amp;sid=$sid\">$nukeurl/".$module_link."op=NEArticle&amp;sid=$sid</a>";
echo "</span>";
echo "</td></tr></table>";
echo "</body>";
echo "</html>";

?>