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
include("header.php");
NE_Admin(_NE_PROGRAMED." "._NE_ADMIN.": "._NE_COMMENTEDIT);
echo "<br />\n";
if($radminarticle == 1 OR $radminsuper == 1) {
  $result = $db->sql_query("select * from ".$prefix."_comments where tid='$tid'");
  $tinfo = $db->sql_fetchrow($result);
  $db->sql_freeresult($result);
  $subject = stripslashes(ne_check_html(ne_convert_text($tinfo['subject']), 0));
  $comment = stripslashes(ne_check_html(ne_convert_text($tinfo['comment']), 1));
  OpenTable();
  OpenTable();
  echo $comment."\n";
  CloseTable();
  echo "<br />\n";
  echo "<form action='".$admin_file.".php' method='post'>\n";
  echo "<br /><br /><b>"._NE_SUBJECT."</b><br />\n";
  echo "<input type='text' name='subject' size='50' maxlength='85' value=\"$subject\"><br />\n<br />\n";
  echo "<b>"._NE_COMMENT."</b><br />\n";
  echo "<textarea wrap='virtual' cols='75' rows='15' name='comment'>".str_replace("<br />", "\r\n", $comment)."</textarea><br />\n<br />\n";
  echo "<input type='hidden' name='tid' value='$tid'>\n";
  echo "<input type='hidden' name='op' value='NECommentEditSave'>\n";
  echo "<input type='submit' value='"._NE_SAVECHANGES."'>\n";
  echo "</form>\n";
  CloseTable();
} else {
  OpenTable();
  echo "<center class='title'><b>"._NE_NOTAUTHORIZED."</b></center><br />\n";
  echo "<center>"._GOBACK."</center>\n";
  CloseTable();
}
ne_copy();
include("footer.php");

?>