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

if(!defined('BLOCK_FILE')) { die("Illegal File Access Detected!!"); }
global $neconfig, $locale, $storynum, $cookie, $categories, $cat, $prefix, $multilingual, $currentlang, $db, $new_topic, $user_news;
list($main_module) = $db->sql_fetchrow($db->sql_query("SELECT `main_module` FROM `".$prefix."_main`"));
if($main_module == "News") {
  $art_link = "index.php?";
} else {
  $art_link = "modules.php?name=News&amp;";
}
include_once("includes/nsnne_func.php");
$neconfig = ne_get_configs();
$querylang = "";
if($multilingual == 1) {
  if($categories == 1) {
    $querylang = "WHERE `catid`='$cat' AND (`alanguage`='$currentlang' OR `alanguage`='')";
  } else {
    $querylang = "WHERE (`alanguage`='$currentlang' OR `alanguage`='')";
    if($new_topic != 0) { $querylang .= " AND `topic`='$new_topic'"; }
  }
} else {
  if($categories == 1) {
    $querylang = "WHERE `catid`='$cat'";
  } else {
    if($new_topic != 0) { $querylang = "WHERE `topic`='$new_topic'"; }
  }
}
if(isset($cookie[3]) AND $user_news == 1) {
  $storynum = $cookie[3];
} else {
  $storynum = $neconfig['homenumber'];
}
$boxstuff = "<table border=\"0\" width=\"100%\">";
$boxTitle = _PASTARTICLES;
$result = $db->sql_query("SELECT * FROM `".$prefix."_stories` $querylang ORDER BY `time` DESC LIMIT $storynum, ".$neconfig['oldnumber']."");
$vari = 0;
while($row = $db->sql_fetchrow($result)) {
  $sid = intval($row['sid']);
  $title = stripslashes(ne_check_html(ne_convert_text($row['title']), 0));
  $time = $row['time'];
  $comments = intval($row['comments']);
  $see = 1;
  setlocale(LC_TIME, $locale);
  ereg ("([0-9]{4})-([0-9]{1,2})-([0-9]{1,2}) ([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2})", $time, $datetime2);
  $datetime2 = strftime(""._DATESTRING2."", mktime($datetime2[4],$datetime2[5],$datetime2[6],$datetime2[2],$datetime2[3],$datetime2[1]));
  $datetime2 = ucfirst($datetime2);
  if($articlecomm == 1) { $comments = "($comments)"; } else { $comments = ""; }
  if($time2==$datetime2) {
    $boxstuff .= "<tr><td valign=\"top\"><strong><big>&middot;</big></strong></td><td> <a href=\"".$art_link."op=NEArticle&amp;sid=$sid\">$title</a> $comments</td></tr>\n";
  } else {
    if($a=="") {
      $boxstuff .= "<tr><td colspan=\"2\"><b>$datetime2</b></td></tr><tr><td valign=\"top\"><strong><big>&middot;</big></strong></td><td> <a href=\"".$art_link."op=NEArticle&amp;sid=$sid\">$title</a> $comments</td></tr>\n";
      $time2 = $datetime2;
      $a = 1;
    } else {
      $boxstuff .= "<tr><td colspan=\"2\"><b>$datetime2</b></td></tr><tr><td valign=\"top\"><strong><big>&middot;</big></strong></td><td> <a href=\"".$art_link."op=NEArticle&amp;sid=$sid\">$title</a> $comments</td></tr>\n";
      $time2 = $datetime2;
    }
  }
  $vari++;
  if($vari == $neconfig['oldnumber']) { $dummy = 1; }
}
$boxstuff .= "</table>";
if($dummy == 1) {
  $boxstuff .= "<br><a href=\"".$art_link."op=NEArchive\"><b>"._OLDERARTICLES."</b></a>\n";
}
if($see == 1) { $content = $boxstuff; }
$db->sql_freeresult($result);

?>