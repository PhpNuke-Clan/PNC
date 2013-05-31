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
$sid = intval($sid);
if(!isset($sid)) { header("Location: $form_link"); }
include("header.php");
$result = $db->sql_query("SELECT `title` FROM `".$prefix."_stories` WHERE `sid`='$sid'");
$row = $db->sql_fetchrow($result);
$db->sql_freeresult($result);
$title = ne_check_html(ne_convert_text($row['title']), 0);
title(_NE_FRIENDSEND);
OpenTable();
echo "<center class=\"content\"><b>"._NE_FRIENDSEND."</b></center><br><br>";
echo ""._NE_YOUSENDSTORY." <b>$title</b> "._NE_TOAFRIEND."<br><br>";
echo "<form action=\"$form_link\" method=\"post\">";
echo "<input type=\"hidden\" name=\"sid\" value=\"$sid\">";
if(is_user($user)) {
  $result = $db->sql_query("SELECT `name`, `username`, `user_email` FROM `".$user_prefix."_users` WHERE `username`='$cookie[1]'");
  $row2 = $db->sql_fetchrow($result);
  $db->sql_freeresult($result);
  if($row2['name'] == "") {
    $yn = ne_check_html(ne_convert_text($row2['username']), 0);
  } else {
    $yn = ne_check_html(ne_convert_text($row2['name']), 0);
  }
  $ye = ne_check_html(ne_convert_text($row2['user_email']), 0);
}
echo "<b>"._NE_YOURNAME.": </b> $yn <input type=\"hidden\" name=\"yname\" value=\"$yn\"><br><br>\n";
echo "<b>"._NE_YOUREMAIL.": </b> $ye <input type=\"hidden\" name=\"ymail\" value=\"$ye\"><br><br><br>\n";
echo "<b>"._NE_FRIENDNAME.": </b> <input type=\"text\" name=\"fname\"><br><br>\n";
echo "<b>"._NE_FRIENDEMAIL.": </b> <input type=\"text\" name=\"fmail\"><br><br>\n";
echo "<input type=\"hidden\" name=\"op\" value=\"NEFriendSend\">\n";
echo "<input type=\"submit\" value="._NE_FRIENDSEND.">\n";
echo "</form>\n";
CloseTable();
include('footer.php');

?>