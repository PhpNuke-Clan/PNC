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
include("header.php");
$result = $db->sql_query("SELECT `topictext` FROM `".$prefix."_topics` WHERE `topicid`='$topicid'");
if(!$result) {
  header("Location: ".$admin_file.".php?op=NETopicIndex");
} else {
  list($title) = $db->sql_fetchrow($result);
  $title = stripslashes(ne_check_html(ne_convert_text($title), 0));
  $db->sql_freeresult($result);
  $numrows = $db->sql_numrows($db->sql_query("SELECT * FROM `".$prefix."_stories` WHERE `topic`='$topicid'"));
  NE_Admin(_NE_TOPICS." "._NE_ADMIN.": "._NE_TOPICDELETE);
  echo "<br />\n";
  OpenTable();
  echo "<center><b>"._NE_WARNING.":</b> "._NE_THETOPIC." <b>$title</b> "._NE_HAS." <b>$numrows</b> "._NE_STORIESINSIDE."<br />\n";
  echo ""._NE_TOPICDELETEWARN1."<br />\n";
  echo ""._NE_TOPICDELETEWARN2."<br />\n<br />\n";
  echo ""._NE_TOPICDELETEWARN3."<br />\n<br />\n";
  echo "[  <a href='".$admin_file.".php?op=NETopicDeleteConf&amp;topicid=$topicid'>"._NE_YES."</a> | ";
  echo "<a href='".$admin_file.".php?op=NETopicIndex'>"._NE_NO."</a> ]\n";
  echo "<b>[ <a href='".$admin_file.".php?op=NETopicMove&amp;topicid=$topicid'>"._NE_TOPICMOVE."</a> ]</b>\n";
  echo "</center>\n";
  CloseTable();
  ne_copy();
  include("footer.php");
}

?>