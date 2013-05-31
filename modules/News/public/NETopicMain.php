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
$pagetitle = "- "._NE_ACTIVETOPICS;
include("header.php");
OpenTable();
echo "<center class='title'><b>"._NE_ACTIVETOPICS."</b></center>\n";
CloseTable();
$result = $db->sql_query("SELECT * FROM `".$prefix."_topics` ORDER BY `topictext`");
if($db->sql_numrows($result) > 0) {
  while($row = $db->sql_fetchrow($result)) {
    $row['topicid'] = intval($row['topicid']);
    $row['topicname'] = ne_check_html(ne_convert_text($row['topicname']), 0);
    $row['topicimage'] = ne_check_html(ne_convert_text($row['topicimage']), 0);
    $row['topictext'] = ne_check_html(ne_convert_text($row['topictext']), 0);
    $ThemeSel = get_theme();
    $t_image = "$tipath".$row['topicimage']."";
    if(@file_exists("themes/$ThemeSel/images/topics/".$row['topicimage']."")) {
      $t_image = "themes/$ThemeSel/images/topics/".$row['topicimage']."";
    }
    $res = $db->sql_query("SELECT `counter` FROM `".$prefix."_stories` WHERE `topic`='".$row['topicid']."'");
    $numrows = $db->sql_numrows($res);
    $reads = 0;
    while($counting = $db->sql_fetchrow($res)) {
      $ccounter = $counting[counter];
      $reads = $reads+$ccounter;
    }
    $db->sql_freeresult($res);
    $result2 = $db->sql_query("SELECT * FROM `".$prefix."_stories` WHERE `topic`='".$row['topicid']."' ORDER BY `sid` DESC LIMIT 0,10");
    $num2 = $db->sql_numrows($result2);
    if($num2 > 0) {
      echo "<br>\n";
      OpenTable();
      echo "<table border='0' width='100%' align='center' cellpadding='2' cellspacing='2'>\n";
      echo "<tr><td align='center' colspan='2' class='title'><b>".$row['topictext']."</b></td></tr>\n";
      echo "<tr><td valign='top' width='25%' align='center'>\n";
      echo "<a href='".$module_link."op=NETopics&amp;topic=".$row['topicid']."'><img src='$t_image' border='0' alt='".$row['topictext']."' title='".$row['topictext']."' hspace='5' vspace='5'></a><br>\n";
      echo "<font class='content'>\n";
      echo "<big><strong>&middot;</strong></big>&nbsp;<b>"._NE_TOTALARTICLES.":</b> $numrows<br>\n";
      echo "<big><strong>&middot;</strong></big>&nbsp;<b>"._NE_TOTALREADS.":</b> $reads</font>\n";
      echo "</td>\n";
      echo "<td valign='top'>";
      while($row2 = $db->sql_fetchrow($result2)) {
        $row2['sid'] = intval($row2['sid']);
        $row2['catid'] = intval($row2['catid']);
        $row2['title'] = ne_check_html(ne_convert_text($row2['title']), 0);
        $row3 = $db->sql_fetchrow($db->sql_query("SELECT `title` FROM `".$prefix."_stories_cat` WHERE `catid`='".$row2['catid']."'"));
        $row3['title'] = ne_check_html(ne_convert_text($row3['title']), 0);
        $cat_link = "";
        if($catid > 0) {
          $cat_link = "<a href='".$module_link."op=NECategoryList&amp;catid=$catid'><b>".$row3['title']."</b></a>: ";
        }
        echo "<img src='modules/$module_name/images/arw.png' border='0' alt='' title=''>&nbsp;&nbsp;$cat_link<a href='".$module_link."op=NEArticle&sid=".$row2['sid']."'>".$row2['title']."</a><br>";
      }
      $db->sql_freeresult($result2);
      echo "</td></tr></table>";
      CloseTable();
    }
  }
  $db->sql_freeresult($result);
}
include("footer.php");

?>