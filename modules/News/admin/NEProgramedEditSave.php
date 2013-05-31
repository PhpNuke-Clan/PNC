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
list($taid) = $db->sql_fetchrow($result);
$db->sql_freeresult($result);
$taid = substr("$taid", 0,25);
if(($radminarticle == 1) AND ($taid == $aid) OR ($radminsuper == 1)) {
  if($day < 10) { $day = "0$day"; }
  if($month < 10) { $month = "0$month"; }
  $sec = "00";
  $date = "$year-$month-$day $hour:$min:$sec";
  $title = stripslashes(ne_check_html(ne_convert_text($title), 0));
  $hometext = stripslashes(ne_check_html(ne_convert_text($hometext), 1));
  $bodytext = stripslashes(ne_check_html(ne_convert_text($bodytext), 1));
  $notes = stripslashes(ne_check_html(ne_convert_text($notes), 1));
  if(!get_magic_quotes_runtime()) {
    $title = addslashes($title);
    $hometext = addslashes($hometext);
    $bodytext = addslashes($bodytext);
    $notes = addslashes($notes);
  }
  $result = $db->sql_query("UPDATE `".$prefix."_autonews` SET `catid`='$catid', `title`='$title', `time`='$date', `hometext`='$hometext', `bodytext`='$bodytext', `topic`='$topic', `notes`='$notes', `ihome`='$ihome', `alanguage`='$alanguage', `acomm`='$acomm' WHERE `anid`='$anid'");
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
    header("Location: ".$admin_file.".php?op=NEProgramedIndex");
  }
} else {
  include("header.php");
  NE_Admin(_NE_PROGRAMED." "._NE_ADMIN);
  echo "<br />\n";
  OpenTable();
  echo "<center><b>"._NE_NOTAUTHORIZED."</b></center>\n";
  CloseTable();
  ne_copy();
  include("footer.php");
}

?>