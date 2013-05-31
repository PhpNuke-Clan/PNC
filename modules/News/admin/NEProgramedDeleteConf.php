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
if(($radminarticle == 1) AND ($aaid == $aid) OR ($radminsuper == 1)) {
  $result = $db->sql_query("DELETE FROM `".$prefix."_autonews` WHERE `anid`='$anid'");
  if(!$result) {
    include("header.php");
    NE_Admin(_NE_PROGRAMED." "._NE_ADMIN);
    echo "<br />\n";
    OpenTable();
    echo "<center class='title'><b>"._NE_DBERROR."</b></center>\n";
    CloseTable();
    ne_copy();
    include("footer.php");
  } else {
    $db->sql_freeresult($result);
    $db->sql_query("OPTIMIZE TABLE `".$prefix."_autonews`");
    header("Location: ".$admin_file.".php?op=NEProgramedIndex");
  }
} else {
  include("header.php");
  NE_Admin(_NE_PROGRAMED." "._NE_ADMIN);
  echo "<br />\n";
  OpenTable();
  echo "<center class='title'><b>"._NE_NOTAUTHORIZED."</b></center>\n";
  CloseTable();
  ne_copy();
  include("footer.php");
}

?>