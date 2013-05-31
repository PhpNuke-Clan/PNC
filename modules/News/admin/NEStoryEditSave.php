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
//for($i=0; $i<sizeof($assotop); $i++) { $associated .= "$assotop[$i]-"; }
if(is_array($assotop)) {
  $associated = implode("-", $assotop);
} else {
  $associated = $assotop;
}
$sid = intval($sid);
$result = $db->sql_query("SELECT `aid` FROM `".$prefix."_stories` WHERE `sid`='$sid'");
list($aaid) = $db->sql_fetchrow($result);
$db->sql_freeresult($result);
$aaid = substr("$aaid", 0,25);
if(($radminarticle == 1) AND ($aaid == $aid) OR ($radminsuper == 1)) {
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
  $result = $db->sql_query("UPDATE `".$prefix."_stories` SET `catid`='$catid', `title`='$title', `hometext`='$hometext', `bodytext`='$bodytext', `topic`='$topic', `notes`='$notes', `ihome`='$ihome', `alanguage`='$alanguage', `acomm`='$acomm', `associated`='$associated' WHERE `sid`='$sid'");
  if(!$result) {
    include("header.php");
    NE_Admin(_NE_STORY." "._NE_ADMIN);
    echo "<br />\n";
    OpenTable();
    echo "<center class='title'><b>"._NE_DBERROR."</b></center>\n";
    CloseTable();
    ne_copy();
    include("footer.php");
  } else {
    $db->sql_freeresult($result);
    if($ultramode) { ultramode(); }
    header("Location: ".$admin_file.".php?op=NEStoryIndex");
  }
} else {
  include("header.php");
  NE_Admin(_NE_STORY." "._NE_ADMIN);
  echo "<br />\n";
  OpenTable();
  echo "<center class='title'><b>"._NE_NOTAUTHORIZED."</b></center><br />\n";
  CloseTable();
  ne_copy();
  include("footer.php");
}

?>