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
$tid = intval($tid);
$sid = intval($sid);
if($radminarticle == 1 OR $radminsuper == 1) {
  NECommentDeleteSub($tid, $sid);
  $db->sql_query("OPTIMIZE TABLE `".$prefix."_comments`");
  if($ultramode) { ultramode(); }
  header("Location: ".$admin_file.".php?op=NECommentIndex");
} else {
  include("header.php");
  NE_Admin(_NE_PROGRAMED." "._NE_ADMIN.": "._NE_COMMENTDELETE);
  echo "<br />\n";
  OpenTable();
  echo "<center class='title'><b>"._NE_NOTAUTHORIZED."</b></center><br />\n";
  echo "<center>"._GOBACK."</center>\n";
  CloseTable();
  ne_copy();
  include("footer.php");
}

function NECommentDeleteSub($tid, $sid) {
  global $prefix, $db;
  $tid = intval($tid);
  $sid = intval($sid);
  $result = $db->sql_query("SELECT `tid` FROM `".$prefix."_comments` WHERE `pid`='$tid'");
  $numrows = $db->sql_numrows($result);
  if($numrows>0) {
    while($row = $db->sql_fetchrow($result)) {
      $stid = intval($row['tid']);
      NECommentDeleteSub($stid, $sid);
      $stid = intval($stid);
      $db->sql_query("DELETE FROM `".$prefix."_comments` WHERE `tid`='$stid'");
    }
  }
  //$db->sql_freeresult($result);
  $db->sql_query("DELETE FROM ".$prefix."_comments WHERE tid='$tid'");
  $db->sql_query("UPDATE ".$prefix."_stories SET comments=comments-1 WHERE sid='$sid'");
}

?>