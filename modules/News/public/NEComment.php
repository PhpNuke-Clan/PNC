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

if(!defined('NSNNE_PUBLIC')) { die("Illegal File Access Detected!!"); }
include("header.php");
$row = $db->sql_fetchrow($db->sql_query("SELECT date, name, email, subject, comment, score, reason FROM ".$prefix."_comments WHERE tid='$tid'"));
$date = $row['date'];
$name = stripslashes($row['name']);
$email = stripslashes($row['email']);
$subject = stripslashes(check_html($row['subject'], "nohtml"));
$comment = stripslashes($row['comment']);
$score = intval($row['score']);
$reason = intval($row['reason']);
if($name == "") { $name = $anonymous; }
if($subject == "") { $subject = "["._NE_NOSUBJECT."]"; }
OpenTable();
echo "<table width=\"100%\" border=\"0\"><tr bgcolor=\"$bgcolor1\"><td>";
formatTimestamp($date);
if($email) {
  echo "<b>$subject</b> ("._NE_SCORE.": $score)<br>\n";
  echo _NE_BY." <a href=\"mailto:$email\">$name</a> <i>($email)</i> "._NE_ON." $datetime";
} else {
  echo "<b>$subject</b> ("._NE_SCORE.": $score)<br>\n"._NE_BY." $name "._NE_ON." $datetime";
}
if(is_admin($admin)) {
  $row3 = $db->sql_fetchrow($db->sql_query("SELECT host_name FROM ".$prefix."_comments WHERE tid='$tid'"));
  $host_name = $row3['host_name'];
  echo "<br>\n(IP: $host_name)";
}
echo "</td></tr><tr><td>$comment</td></tr></table><br>";
echo "<font class=content> [ ";
if($neconfig['anonymous_post']==1 OR is_user($user)) {
  echo "<a href=\"modules.php?name=$module_name&amp;op=NEReply&amp;pid=$tid&amp;sid=$sid&amp;mode=$mode&amp;order=$order&amp;thold=$thold\">"._NE_REPLYTOTHIS."</a>";
} else {
  echo ""._NE_REPLYTOTHIS."";
}
if(is_admin($admin)) {
  echo " | <a href=\"".$admin_file.".php?op=NECommentDelete&amp;tid=$tid&amp;sid=$sid\">"._DELETE."</a>";
  echo " | <a href=\"".$admin_file.".php?op=NECommentEdit&amp;tid=$tid\">"._EDIT."</a>";
}
echo " ]</font>";
CloseTable();
include("footer.php");

?>