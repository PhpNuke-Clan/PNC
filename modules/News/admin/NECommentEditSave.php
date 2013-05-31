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
if($radminarticle == 1 OR $radminsuper == 1) {
  $subject = stripslashes(ne_check_html(ne_convert_text($subject), 0));
  $comment = stripslashes(ne_check_html(ne_convert_text($comment), 1));
  if(!get_magic_quotes_runtime()) {
    $subject = addslashes($subject);
    $comment = addslashes($comment);
  }
  $result = $db->sql_query("UPDATE `".$prefix."_comments` SET `subject`='$subject', `comment`='$comment' WHERE `tid`='$tid'");
  if(!$result) {
    include("header.php");
    NE_Admin(_NE_PROGRAMED." "._NE_ADMIN.": "._NE_COMMENTEDIT);
    echo "<br />\n";
    OpenTable();
    echo "<center class='title'><b>"._NE_DBERROR."</b></center>\n";
    CloseTable();
    ne_copy();
    include("footer.php");
  } else {
    $db->sql_freeresult($result);
    header("Location: ".$admin_file.".php?op=NECommentIndex");
  }
} else {
  include("header.php");
  NE_Admin(_NE_PROGRAMED." "._NE_ADMIN.": "._NE_COMMENTEDIT);
  echo "<br />\n";
  OpenTable();
  echo "<center><b>"._NE_NOTAUTHORIZED."</b></center><br />\n";
  echo "<center>"._GOBACK."</center>\n";
  CloseTable();
  ne_copy();
  include("footer.php");
}

?>