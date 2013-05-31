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
$anid = intval($anid);
$result = $db->sql_query("SELECT `aid` FROM `".$prefix."_autonews` WHERE `anid`='$anid'");
list($aaid) = $db->sql_fetchrow($result);
$db->sql_freeresult($result);
$aaid = substr("$aaid", 0,25);
include("header.php");
NE_Admin(_NE_PROGRAMED." "._NE_ADMIN);
echo "<br />\n";
if(($radminarticle == 1) AND ($aaid == $aid) OR ($radminsuper == 1)) {
  OpenTable();
  echo "<center>"._NE_REMOVEPROGRAMED." $anid<br />\n<br />\n";
  echo "[ <a href='".$admin_file.".php?op=NEProgramedDeleteConf&amp;anid=$anid'>"._NE_YES."</a> ]</center>\n";
  CloseTable();
} else {
  OpenTable();
  echo "<center class='title'><b>"._NE_NOTAUTHORIZED."</b></center>\n";
  CloseTable();
}
ne_copy();
include("footer.php");

?>