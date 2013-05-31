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
$pagetitle = ": "._NE_STORIESARCHIVE.": "._NE_ALLSTORIES;
$perpage = 50;
if(!isset($min) || intval($min) <= 0) {
  $min = 0;
} else {
  $min = intval($min);
}
if(!isset($max)) { $max = $min + $perpage; }
include("header.php");
title(_NE_STORIESARCHIVE.": "._NE_ALLSTORIES);
if(is_user($user)) { getusrinfo($user); }
OpenTable();
echo "<center>[ <a href='".$module_link."op=NEArchive'>"._NE_ARCHIVESINDEX."</a> ]</center><br>";
$numrows = $db->sql_numrows($db->sql_query("SELECT * FROM `".$prefix."_stories`"));
echo "<table border='0' bgcolor='$bgcolor2' cellpadding='2' cellspacing='2' width='100%'><tr>";
echo "<td bgcolor='$bgcolor2' align='left'><b>"._NE_ARTICLES."</b></td>";
echo "<td bgcolor='$bgcolor2' align='center'><b>"._NE_COMMENTS."</b></td>";
echo "<td bgcolor='$bgcolor2' align='center'><b>"._NE_READS."</b></td>";
echo "<td bgcolor='$bgcolor2' align='center'><b>"._NE_SCORE."</b></td>";
echo "<td bgcolor='$bgcolor2' align='center'><b>"._NE_DATE."</b></td>";
echo "<td bgcolor='$bgcolor2' align='center'><b>"._NE_ACTIONS."</b></td></tr>";
$result = $db->sql_query("SELECT * FROM `".$prefix."_stories` ORDER BY `sid` DESC LIMIT $min,$perpage");
while($row = $db->sql_fetchrow($result)) {
  $sid = intval($row['sid']);
  $catid = intval($row['catid']);
  $title = ne_check_html(ne_convert_text($row['title']), 0);
  $time = $row['time'];
  $comments = intval($row['comments']);
  $counter = intval($row['counter']);
  $topic = intval($row['topic']);
  $alanguage = $row['alanguage'];
  $score = intval($row['score']);
  $ratings = intval($row['ratings']);
  $time = explode(" ", $time);
  $actions  = "<a href='".$module_link."op=NEArticle&amp;sid=$sid' target='_blank'><img src='modules/$module_name/images/read.png' border=0 alt='"._NE_READARTICLE."' title='"._NE_READARTICLE."' width='15' height='16'></a>";
  $actions .= "&nbsp;<a href='".$module_link."op=NEPrint&amp;sid=$sid' target='_blank'><img src='modules/$module_name/images/print.png' border=0 alt='"._NE_PRINTER."' title='"._NE_PRINTER."' width='16' height='16'></a>";
  $actions .= "&nbsp;<a href='".$module_link."op=NEPortable&amp;sid=$sid' target='_blank'><img src='modules/$module_name/images/pdf.png' border=0 alt='"._NE_PDF."' title='"._NE_PDF."' width='16' height='16'></a>";
  $actions .= "&nbsp;<a href='".$module_link."op=NEFriend&amp;sid=$sid' target='_blank'><img src='modules/$module_name/images/friend.png' border=0 alt='"._NE_FRIENDSEND."' title='"._NE_FRIENDSEND."' width='16' height='16'></a>";
  if($score != 0) {
    $rated = substr($score / $ratings, 0, 4);
  } else {
    $rated = 0;
  }
  if($catid == 0) {
    $title = $title;
  } elseif($catid != 0) {
    $row_res = $db->sql_fetchrow($db->sql_query("SELECT title from ".$prefix."_stories_cat where catid='$catid'"));
    $cat_title = stripslashes($row_res['title']);
    $title = "<a href='".$module_link."op=NECategoryList&amp;catid=$catid'><i>$cat_title</i></a>: $title";
  }
  if($multilingual == 1) {
    if(empty($alanguage)) { $alanguage = $language; }
    $alt_language = ucfirst($alanguage);
    $lang_img = "<img src='modules/$module_name/images/flags/".$alanguage.".png' border='0' hspace='2' alt='$alt_language' title='$alt_language'>";
  } else {
    $lang_img = "<strong><big><b>&middot;</b></big></strong>";
  }
  echo "<tr bgcolor='$bgcolor1' onmouseover=\"this.style.backgroundColor='$bgcolor2'\" onmouseout=\"this.style.backgroundColor='$bgcolor1'\">";
  echo "<td align='left'>$lang_img $title</td>";
  echo "<td align='center'>$comments</td>";
  echo "<td align='center'>$counter</td>";
  echo "<td align='center'>$rated</td>";
  echo "<td align='center'>$time[0]</td>";
  echo "<td align='center'>$actions</td></tr>";
}
$db->sql_freeresult($result);
echo "</table>\n";
echo "\n<!-- PAGING -->\n";
$articlepagesint = ($numrows / $perpage);
$articlepageremain = ($numrows % $perpage);
if($articlepageremain != 0) {
  $articlepages = ceil($articlepagesint);
  if($numrows < $perpage) { $articlepageremain = 0; }
} else {
  $articlepages = $articlepagesint;
}
if($articlepages > 1) {
  echo "<br>\n";
  $counter = 1;
  $currentpage = ($max / $perpage);
  echo "<table align='center' border='0' cellpadding='2' cellspacing='2' width='100%'>\n<tr>\n";
  echo "<form action='".$module_link."op=NEAll' method='post'>\n";
  echo "<input type='hidden' name='min' value='".($min - $perpage)."'>\n";
  echo "<td width='25%'>";
  if($currentpage <= 1) {
    echo "&nbsp;";
  } else {
    echo "<input type='submit' value='"._NE_PREVPAGE."'>";
  }
  echo "</td>\n";
  echo "</form>\n";
  echo "<form action='".$module_link."op=NEAll' method='post'>\n";
  echo "<td align='center' width='50%'><nobr><b>"._NE_SELECT."</b> <select name='min'>\n";
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
  echo "</select><b> "._NE_OF." $articlepages "._NE_PAGES.".</b> <input type='submit' value='"._NE_GO."'></nobr></td>\n";
  echo "</form>\n";
  echo "<form action='".$module_link."op=NEAll' method='post'>\n";
  echo "<input type='hidden' name='min' value='".($min + $perpage)."'>\n";
  echo "<td align='right' width='50%'>";
  if($currentpage >= $articlepages) {
    echo "&nbsp;";
  } else {
    echo "<input type='submit' value='"._NE_NEXTPAGE."'>";
  }
  echo "</td>\n";
  echo "</form>\n";
  echo "</tr>\n</table>\n";
}
echo "<!-- CLOSE PAGING -->\n";
CloseTable();
include("footer.php");

?>