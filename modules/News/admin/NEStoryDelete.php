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
include("header.php");
NE_Admin(_NE_STORY." "._NE_ADMIN);
echo "<br />\n";
if(($radminarticle == 1) AND ($aaid == $aid) OR ($radminsuper == 1)) {
  OpenTable();
  echo "<center>"._NE_REMOVESTORY." $sid "._NE_ANDCOMMENTS."<br />\n<br />\n";
  echo "[ <a href='".$admin_file.".php?op=NEStoryDeleteConf&amp;sid=$sid'>"._NE_YES."</a> ]</center>\n";
  CloseTable();
} else {
  OpenTable();
  echo "<center class='title'><b>"._NE_NOTAUTHORIZED."</b></center><br />\n";
  CloseTable();
}
ne_copy();
include("footer.php");

?>