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
if(!isset($sid) && !isset($tid)) { header("Location: $nukeurl"); }
include_once("includes/counter.php");
$sid=intval($sid); 
$result = $db->sql_query("SELECT * FROM `".$prefix."_stories` WHERE `sid`='$sid'");
if($numrows = $db->sql_numrows($result) < 1) {
    header("Location: ".$form_link);
    die();
}
$row = $db->sql_fetchrow($result);
$db->sql_freeresult($result);
if(empty($row['aid'])) { header("Location: ".$form_link); }
$catid = intval($row['catid']);
$aid = ne_check_html(ne_convert_text($row['aid']), 0);
$time = $row['time'];
$title = ne_check_html(ne_convert_text($row['title']), 0);
$hometext = ne_check_html(ne_convert_text($row['hometext']), 1);
$bodytext = ne_check_html(ne_convert_text($row['bodytext']), 1);
$topic = intval($row['topic']);
$informant = ne_check_html(ne_convert_text($row['informant']), 0);
$notes = ne_check_html(ne_convert_text($row['notes']), 1);
$acomm = intval($row['acomm']);
$haspoll = intval($row['haspoll']);
$pollID = intval($row['pollID']);
$score = intval($row['score']);
$ratings = intval($row['ratings']);
$counter = intval($row['counter']);
$counter++;
$db->sql_query("UPDATE `".$prefix."_stories` SET `counter`='$counter' WHERE `sid`='$sid'");
$artpage = 1;
$Theme_Sel = get_theme();
echo "<html>\n";
echo "<head>\n";
require_once("themes/$Theme_Sel/theme.php");
echo "<style type=\"text/css\">\n";
echo "<!--\n";
require_once("themes/$Theme_Sel/style/style.css");
echo "-->\n";
echo "</style>\n";
echo "<title>$title</title>\n";
echo "<base target='parent'>\n";
echo "</head>\n";
echo "<body>\n";
$artpage = 0;
formatTimestamp($time);
$title = stripslashes($title);
$hometext = stripslashes($hometext);
$bodytext = stripslashes($bodytext);
$notes = stripslashes($notes);
if(!empty($notes)) { $notes = "<br><br><b>"._NE_NOTE.":</b> <i>$notes</i>"; } else { $notes = ""; }
if(!empty($bodytext)) { $articletext = "$hometext".$notes; } else { $articletext = "$hometext<br><br>$bodytext".$notes; }
if(empty($informant)) { $informant = $anonymous; }
getTopics($sid);
if($catid != 0) {
  $result = $db->sql_query("SELECT `title` FROM `".$prefix."_stories_cat` WHERE `catid`='$catid'");
  $row = $db->sql_fetchrow($result);
  $db->sql_freeresult($result);
  $title1 = ne_check_html(ne_convert_text($row['title']), 0);
  $title = "<a href=\"".$module_link."op=NECategoryList&amp;catid=$catid\"><font class=\"storycat\">$title1</font></a>: $title";
}

echo "<table border=\"0\"><tr><td valign=\"top\" width=\"100%\">\n";
themearticle($aid, $informant, $datetime, $title, $articletext, $topic, $topicname, $topicimage, $topictext);
echo "</td></tr></table>\n";

echo "</body>\n";
echo "</html>\n";
die();

?>