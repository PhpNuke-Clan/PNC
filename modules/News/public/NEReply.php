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
if($neconfig['anonymous_post'] == 0 AND !is_user($user)) {
  title(_NE_REPLYTOCOMMENT);
  OpenTable();
  echo "<center>"._NE_NOANONCOMMENTS."</center><br>\n";
  CloseTable();
} else {
  if($pid != 0) {
    $row = $db->sql_fetchrow($db->sql_query("SELECT * FROM `".$prefix."_comments` WHERE `tid`='$pid'"));
    $date = $row['date'];
    $row['name'] = ne_check_html(ne_convert_text($row['name']), 0);
    $row['email'] = ne_check_html(ne_convert_text($row['email']), 0);
    $row['subject'] = ne_check_html(ne_convert_text($row['subject']), 0);
    $row['comment'] = ne_check_html(ne_convert_text($row['comment']), 1);
    $score = intval($row['score']);
  } else {
    $row2 = $db->sql_fetchrow($db->sql_query("SELECT time, title, hometext, bodytext, informant, notes FROM ".$prefix."_stories WHERE sid='$sid'"));
    $date = $row2['time'];
    $row['subject'] = ne_check_html(ne_convert_text($row2['title']), 0);
    $comment1 = ne_check_html(ne_convert_text($row2['hometext']), 1);
    $comment2 = ne_check_html(ne_convert_text($row2['bodytext']), 1);
    $row['name'] = ne_check_html(ne_convert_text($row2['informant']), 0);
    $row['notes'] = ne_check_html(ne_convert_text($row2['notes']), 1);
  }
  if(empty($row['comment'])) { $row['comment'] = "$comment1<br><br>$comment2"; }
  title(_NE_REPLYTOCOMMENT);
  OpenTable();
  if(empty($row['name'])) { $row['name'] = $anonymous; }
  if(empty($row['subject'])) { $row['subject'] = "["._NE_NOSUBJECT."]"; }
  formatTimestamp($date);
  echo "<b>".$row['subject']."</b> ";
  if(!$temp_comment) echo"("._NE_SCORE.": $score)";
  if($row['email']) {
    echo "<br>"._NE_BY." <a href=\"mailto:".$row['email']."\">".$row['name']."</a> <b>(".$row['email'].")</b> "._NE_ON." $datetime";
  } else {
    echo "<br>"._NE_BY." ".$row['name']." "._NE_ON." $datetime";
  }
  echo "<br><br>".$row['comment']."<br><br>";
  if($pid == 0) {
    if($row['notes'] != "") { echo "<b>"._NE_NOTE."</b> <i>".$row['notes']."</i><br><br>"; }
  }
  if(!isset($pid) || !isset($sid)) { exit(_NE_PROBLEM); }
  if($pid == 0) {
    $result = $db->sql_query("SELECT `title` FROM `".$prefix."_stories` WHERE `sid`='$sid'");
    $row3 = $db->sql_fetchrow($result);
    $db->sql_freeresult($result);
    $subject = ne_check_html(ne_convert_text($row3['title']), 0);
  } else {
    $result = $db->sql_query("SELECT `subject` FROM `".$prefix."_comments` WHERE `tid`='$pid'");
    $row4 = $db->sql_fetchrow($result);
    $db->sql_freeresult($result);
    $subject = ne_check_html(ne_convert_text($row4['subject']), 0);
  }
  CloseTable();
  echo "<br>";
  OpenTable();
  echo "<form action=\"$form_link\" method=\"post\">";
  echo "<b>"._NE_YOURNAME.":</b> ";
  if(is_user($user)) {
    cookiedecode($user);
    echo "<a href=\"modules.php?name=Your_Account\">$cookie[1]</a> [ <a href=\"modules.php?name=Your_Account&amp;op=logout\">"._LOGOUT."</a> ]<br><br>";
  } else {
    echo "$anonymous [ <a href=\"modules.php?name=Your_Account\">"._NE_NEWUSER."</a> ]<br><br>";
  }
  echo "<b>"._NE_SUBJECT.":</b><br>";
  if(!eregi("Re:",$subject)) $subject = "Re: ".substr($subject,0,81);
  echo "<input type=\"text\" name=\"subject\" size=\"50\" maxlength=\"85\" value=\"$subject\"><br><br>";
  echo "<b>"._NE_COMMENT.":</b><br>";
  echo "<textarea wrap=\"virtual\" rows=\"10\" cols=\"50\" name=\"comment\"></textarea><br>";
  echo ""._NE_ALLOWEDHTML."<br>";
  while(list($key,)= each($allowed_tags)) echo " &lt;".$key."&gt;";
  echo "<br>";
  if(is_user($user) AND ($neconfig['anonymous_post'] == 1)) { echo "<input type=\"checkbox\" name=\"xanonpost\"> "._NE_POSTANON."<br>"; }
  echo "<input type=\"hidden\" name=\"pid\" value=\"$pid\">\n";
  echo "<input type=\"hidden\" name=\"sid\" value=\"$sid\">\n";
  echo "<input type=\"hidden\" name=\"mode\" value=\"$mode\">\n";
  echo "<input type=\"hidden\" name=\"order\" value=\"$order\">\n";
  echo "<input type=\"hidden\" name=\"thold\" value=\"$thold\">\n";
  echo "<select name=\"op\">\n";
  echo "<option value=\"NEReplyPreview\">"._NE_PREVIEWREPLY."</option>\n";
  echo "<option value=\"NEReplyPost\">"._NE_POSTREPLY."</option>\n";
  echo "</select>\n";
  echo "<input type=\"submit\" value=\""._NE_OK."\">\n";
  echo "</form>\n";
  CloseTable();
}
include("footer.php");

?>