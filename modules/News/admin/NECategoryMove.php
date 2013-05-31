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
$catid = intval($catid);
$result = $db->sql_query("SELECT `title` FROM `".$prefix."_stories_cat` WHERE `catid`='$catid'");
if(!$result) {
  header("Location: ".$admin_file.".php?op=NECategoryIndex");
} else {
  list($title) = $db->sql_fetchrow($result);
  $db->sql_freeresult($result);
  $title = stripslashes(ne_check_html(ne_convert_text($title), 0));
  include("header.php");
  NE_Admin(_NE_CATEGORIES." "._NE_ADMIN.": "._NE_CATEGORYMOVE);
  echo "<br />\n";
  OpenTable();
  echo "<center>"._NE_ALLSTORIESUNDER." <b>$title</b> "._NE_WILLBEMOVED."<br />\n<br />\n";
  echo "<form action='".$admin_file.".php' method='post'>\n";
  echo "<input type='hidden' name='catid' value='$catid'>\n";
  echo "<input type='hidden' name='op' value='NECategoryMoveConf'>\n";
  echo "<b>"._NE_SELECTCATEGORY.":</b> <select name='newcat'>\n";
  echo "<option value='0'>"._NE_ARTICLES."</option>\n";
  $selcat = $db->sql_query("SELECT `catid`, `title` FROM `".$prefix."_stories_cat` WHERE `catid`!='$catid' ORDER BY `title`");
  while(list($newcat, $title) = $db->sql_fetchrow($selcat)) {
    echo "<option value='$newcat'>$title</option>\n";
  }
  $db->sql_freeresult($selcat);
  echo "</select> <input type='submit' value='"._NE_MOVETHEM."'>\n";
  echo "</form>\n";
  echo "</center>\n";
  CloseTable();
  ne_copy();
  include("footer.php");
}

?>