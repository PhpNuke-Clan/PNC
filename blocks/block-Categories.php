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
global $cat, $language, $prefix, $multilingual, $currentlang, $db;
list($main_module) = $db->sql_fetchrow($db->sql_query("SELECT `main_module` FROM `".$prefix."_main`"));
if($main_module == "News") {
  $art_link = "index.php?";
  $art_form = "index.php";
} else {
  $art_link = "modules.php?name=News&amp;";
  $art_form = "modules.php?name=News";
}
include_once("includes/nsnne_func.php");
$neconfig = ne_get_configs();
if ($multilingual == 1) {
  $querylang = "AND (`alanguage`='$currentlang' OR `alanguage`='')";
} else {
  $querylang = "";
}
$result = $db->sql_query("SELECT * FROM `".$prefix."_stories_cat` ORDER BY `title`");
if($db->sql_numrows($result) == 0) {
  return;
} else {
  $boxstuff = "<span class=\"content\">";
  while($row = $db->sql_fetchrow($result)) {
    $catid = intval($row['catid']);
    $title = stripslashes(ne_check_html(ne_convert_text($row['title']), 0));
    $numrows = $db->sql_numrows($db->sql_query("SELECT * FROM `".$prefix."_stories` WHERE `catid`='$catid' $querylang LIMIT 1"));
    if($numrows > 0) {
      if($cat == 0 AND !$a) {
        $boxstuff .= "<strong><big>&middot;</big></strong>&nbsp;<b>"._ALLCATEGORIES."</b><br>";
        $a = 1;
      } elseif($cat != 0 AND !$a) {
        $boxstuff .= "<strong><big>&middot;</big></strong>&nbsp;<a href='".$art_form."'>"._ALLCATEGORIES."</a><br>";
        $a = 1;
      }
      if($cat == $catid) {
        $boxstuff .= "<strong><big>&middot;</big></strong>&nbsp;<b>$title</b><br>";
      } else {
        $boxstuff .= "<strong><big>&middot;</big></strong>&nbsp;<a href='".$art_link."op=NECategoryList&amp;catid=$catid'>$title</a><br>";
      }
    }
  }
  $boxstuff .= "</span>";
  $content = $boxstuff;
}
$db->sql_freeresult($result);

?>