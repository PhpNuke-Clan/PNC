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
$sid = intval($sid);
$counter = intval($counter);
list($aaid) = $db->sql_fetchrow($db->sql_query("SELECT `aid` FROM `".$prefix."_stories` WHERE `sid`='$sid'"));
$aaid = substr("$aaid", 0,25);
if(($radminarticle == 1) AND ($aaid == $aid) OR ($radminsuper == 1)) {
  $counter--;
  $db->sql_query("DELETE FROM `".$prefix."_stories` WHERE `sid`='$sid'");
  $db->sql_query("OPTIMIZE TABLE `".$prefix."_stories`");
  $db->sql_query("DELETE FROM `".$prefix."_comments` WHERE `sid`='$sid'");
  $db->sql_query("OPTIMIZE TABLE `".$prefix."_comments`");
  $db->sql_query("UPDATE `".$prefix."_poll_desc` SET `artid`='0' WHERE `artid`='$sid'");
  $db->sql_query("UPDATE `".$prefix."_authors` SET `counter`='$counter' WHERE `aid`='$aid'");
  if($ultramode) { ultramode(); }
  header("Location: ".$admin_file.".php?op=NEStoryIndex");
} else {
  include("header.php");
  NE_Admin(_NE_STORY." "._NE_ADMIN);
  echo "<br />\n";
  OpenTable();
  echo "<center class='title'><b>"._NE_NOTAUTHORIZED."</b></center><br />\n";
  echo "<center>"._GOBACK."</center>\n";
  CloseTable();
  ne_copy();
  include("footer.php");
}

?>