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
include("header.php");
NE_Admin(_NE_PROGRAMED." "._NE_ADMIN.": "._NE_COMMENTDELETE);
echo "<br />\n";
if($radminarticle == 1 OR $radminsuper == 1) {
  OpenTable();
  echo "<center>"._NE_COMMENTDELETE." $tid<br />\n<br />\n";
  echo _NE_COMMENTSURE2DELETE."<br />\n";
  echo "[ <a href='".$admin_file.".php?op=NECommentDeleteConf&amp;tid=$tid&amp;sid=$sid'>"._NE_YES."</a> ]</center>\n";
  CloseTable();
} else {
  OpenTable();
  echo "<center class='title'><b>"._NE_NOTAUTHORIZED."</b></center>\n";
  CloseTable();
}
ne_copy();
include("footer.php");

?>