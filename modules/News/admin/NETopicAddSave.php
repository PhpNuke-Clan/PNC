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
$topicname = stripslashes(ne_check_html(ne_convert_text($topicname), 0));
$topicimage = ne_check_html(ne_convert_text($topicimage), 0);
$topictext = stripslashes(ne_check_html(ne_convert_text($topictext), 0));
if(!get_magic_quotes_runtime()) {
  $topicname = addslashes($topicname);
  $topicimage = addslashes($topicimage);
  $topictext = addslashes($topictext);
}
$result = $db->sql_query("INSERT INTO `".$prefix."_topics` (`topicname`, `topicimage`, `topictext`) VALUES ('$topicname', '$topicimage', '$topictext')");
if(!$result) {
  include("header.php");
  NE_Admin(_NE_TOPICS." "._NE_ADMIN);
  echo "<br />\n";
  OpenTable();
  echo "<center class='title'><b>"._NE_DBERROR."</b></font></center>\n";
  CloseTable();
  ne_copy();
  include("footer.php");
} else {
  $db->sql_freeresult($result);
  header("Location: ".$admin_file.".php?op=NETopicIndex");
}

?>