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
include("header.php");
$result = $db->sql_query("SELECT `title` FROM `".$prefix."_stories_cat` WHERE `catid`='$catid'");
if(!$result) {
  header("Location: ".$admin_file.".php?op=NECategoryIndex");
} else {
  list($title) = $db->sql_fetchrow($result);
  $title = stripslashes(ne_check_html(ne_convert_text($title), 0));
  $numrows = $db->sql_numrows($db->sql_query("SELECT * FROM `".$prefix."_stories` WHERE `catid`='$catid'"));
  NE_Admin(_NE_CATEGORIES." "._NE_ADMIN.": "._NE_CATEGORYDELETE);
  echo "<br />\n";
  OpenTable();
  echo "<center><b>"._NE_WARNING.":</b> "._NE_THECATEGORY." <b>$title</b> "._NE_HAS." <b>$numrows</b> "._NE_STORIESINSIDE."<br />\n";
  echo ""._NE_CATEGORYDELETEWARN1."<br />\n";
  echo ""._NE_CATEGORYDELETEWARN2."<br />\n<br />\n";
  echo ""._NE_CATEGORYDELETEWARN3."<br />\n<br />\n";
  echo "<b>[ <a href='".$admin_file.".php?op=NECategoryDeleteConf&amp;catid=$catid'>"._NE_YES."</a> | ";
  echo "<a href='".$admin_file.".php?op=NECategoryIndex'>"._NE_NO."</a> ]</b><br />\n";
  echo "<b>[ <a href='".$admin_file.".php?op=NECategoryMove&amp;catid=$catid'>"._NE_CATEGORYMOVE."</a> ]</b>\n";
  echo "</center>\n";
  CloseTable();
  ne_copy();
  include("footer.php");
  $db->sql_freeresult($result);
}

?>