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
if($topic == 0 OR $topic == "") { header("Location: ".$module_link); }
$topic = intval($topic);
$perpage = 100;
if(!isset($min)) { $min = 0; }
if(!isset($max)) { $max = $min + $perpage; }
$result = $db->sql_query("SELECT * FROM ".$prefix."_topics WHERE topicid='$topic'");
$row = $db->sql_fetchrow($result);
$db->sql_freeresult($result);
$row['topicid'] = intval($row['topicid']);
$row['topicname'] = ne_check_html(ne_convert_text($row['topicname']), 0);
$row['topicimage'] = ne_check_html(ne_convert_text($row['topicimage']), 0);
$row['topictext'] = ne_check_html(ne_convert_text($row['topictext']), 0);
$pagetitle = "- "._TOPIC.": ".$row['topictext'];
include("header.php");
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
title(_TOPIC.": ".$row['topictext']);
$result = $db->sql_query("SELECT * FROM `".$prefix."_stories` WHERE `topic`='".$row['topicid']."'");
$totalarticles = $db->sql_numrows($result);
$db->sql_freeresult($result);
$result2 = $db->sql_query("SELECT * FROM `".$prefix."_stories` WHERE `topic`='".$row['topicid']."' ORDER BY `sid` DESC LIMIT $min, $perpage");
$num2 = $db->sql_numrows($result2);
if($num2 > 0) {
  OpenTable();
  echo "<center><a href='".$module_link."op=NETopicMain'>"._NE_TOPICSMAIN."</a></center>\n";
  echo "<table border='0' align='center' cellpadding='2' cellspacing='2'>\n";
  echo "<tr>\n";
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
    echo "<strong><big><b>&middot;</b></big></strong>&nbsp;$cat_link<a href='".$module_link."op=NEArticle&sid=".$row2['sid']."'>".$row2['title']."</a><br>";
  }
  $db->sql_freeresult($result2);
  echo "</td></tr></table>";
  CloseTable();
  echo "\n<!-- PAGING -->\n";
  $articlepagesint = ($totalarticles / $perpage);
  $articlepageremain = ($totalarticles % $perpage);
  if($articlepageremain != 0) {
    $articlepages = ceil($articlepagesint);
    if($totalarticles < $perpage) { $articlepageremain = 0; }
  } else {
    $articlepages = $articlepagesint;
  }
  if($articlepages!=1 && $articlepages!=0) {
    echo "<br>\n";
    OpenTable();
    $counter = 1;
    $currentpage = ($max / $perpage);
    echo "<table align='center' border='0' cellpadding='2' cellspacing='2' width='100%'>\n<tr>\n";
    echo "<form action='".$module_link."op=NETopics' method='post'>\n";
    echo "<input type='hidden' name='topic' value='$topic'>\n";
    echo "<input type='hidden' name='min' value='".($min - $perpage)."'>\n";
    echo "<td width='33%'>";
    if($currentpage <= 1) {
      echo "&nbsp;";
    } else {
      echo "<input type='submit' value='"._NE_PREVPAGE."'>";
    }
    echo "</td>\n";
    echo "</form>\n";
    echo "<form action='".$module_link."op=NETopics' method='post'>\n";
    echo "<input type='hidden' name='topic' value='$topic'>\n";
    echo "<td align='center' width='34%'><b>"._NE_SELECTPAGE." </b><select name='min'>\n";
    while($counter <= $articlepages ) {
      $cpage = $counter;
      $mintemp = ($perpage * $counter) - $perpage;
      if($counter == $currentpage) {
        echo "<option selected>$counter</option>\n";
      } else {
        echo "<option value='$mintemp'>$counter</option>\n";
      }
      $counter++;
    }
    echo "</select><b> "._NE_OF." $articlepages "._NE_PAGES.".</b> <input type='submit' value='"._NE_GO."'></td>\n";
    echo "</form>\n";
    echo "<form action='".$module_link."op=NETopics' method='post'>\n";
    echo "<input type='hidden' name='topic' value='$topic'>\n";
    echo "<input type='hidden' name='min' value='".($min + $perpage)."'>\n";
    echo "<td align='right' width='33%'>";
    if($currentpage >= $articlepages) {
      echo "&nbsp;";
    } else {
      echo "<input type='submit' value='"._NE_NEXTPAGE."'>";
    }
    echo "</td>\n";
    echo "</form>\n";
    echo "</tr>\n</table>\n";
    CloseTable();
  }
  echo "<!-- CLOSE PAGING -->\n";
}
include("footer.php");

?>