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
$topicid = intval($topicid);
$result = $db->sql_query("SELECT `topictext` FROM `".$prefix."_topics` WHERE `topicid`='$topicid'");
if(!$result) {
  header("Location: ".$admin_file.".php?op=NETopicIndex");
} else {
  list($title) = $db->sql_fetchrow($result);
  $db->sql_freeresult($result);
  include("header.php");
  NE_Admin(_NE_TOPICS." "._NE_ADMIN.": "._NE_TOPICMOVE);
  echo "<br />\n";
  OpenTable();
  echo "<center>"._NE_ALLSTORIESUNDER." <b>$title</b> "._NE_WILLBEMOVED."<br />\n<br />\n";
  echo "<form action='".$admin_file.".php' method='post'>\n";
  echo "<input type='hidden' name='topicid' value='$topicid'>\n";
  echo "<input type='hidden' name='op' value='NETopicMoveConf'>\n";
  echo "<b>"._NE_TOPICSELECT.":</b> <select name='newtop'>\n";
  $seltop = $db->sql_query("SELECT `topicid`, `topictext` FROM `".$prefix."_topics` ORDER BY `topictext`");
  while(list($newtop, $title) = $db->sql_fetchrow($seltop)) {
    $newtop = intval($newtop);
    $title = stripslashes(ne_check_html(ne_convert_text($title), 0));
    if($topicid != $newtop) { echo "<option value='$newtop'>$title</option>\n"; }
  }
  $db->sql_freeresult($seltop);
  echo "</select> <input type='submit' value='"._NE_MOVETHEM."'>\n";
  echo "</form>\n";
  echo "</center>\n";
  CloseTable();
  ne_copy();
  include("footer.php");
}

?>