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
  title(_NE_PREVIEWREPLYTOCOMMENT);
  OpenTable();
  cookiedecode($user);
  $subject = ne_check_html(ne_convert_text($subject), 0);
  $comment = ne_check_html(ne_convert_text($comment), 1);
  if(!isset($pid) || !isset($sid)) { exit(_NE_NOTRIGHT); }
  echo "<b>$subject</b>";
  echo "<br>"._NE_BY." ";
  if(is_user($user)) { echo "$cookie[1]"; } else { echo "$anonymous"; }
  echo " "._NE_ONN." ".strftime(_NE_DATESTRING)."<br><br>";
  echo $comment;
  CloseTable();
  echo "<br>";
  OpenTable();
  echo "<form action=\"$form_link\" method=\"post\">\n";
  echo "<b>"._NE_YOURNAME.":</b> ";
  if(is_user($user)) {
    echo "<a href=\"modules.php?name=Your_Account\">$cookie[1]</a> [ <a href=\"modules.php?name=Your_Account&amp;op=logout\">"._LOGOUT."</a> ]<br><br>";
  } else {
    echo "$anonymous<br><br>";
  }
  echo "<b>"._NE_SUBJECT.":</b><br>";
  echo "<input type=\"text\" name=\"subject\" size=\"50\" maxlength=\"85\" value=\"$subject\"><br><br>";
  echo "<b>"._NE_COMMENT.":</b><br>";
  echo "<textarea wrap=\"virtual\" cols=\"50\" rows=\"10\" name=\"comment\">$comment</textarea><br>";
  echo ""._NE_ALLOWEDHTML."<br>";
  while(list($key,) = each($allowed_tags)) echo " &lt;".$key."&gt;";
  echo "<br>";
  if(($xanonpost) AND ($neconfig['anonymous_post'] == 1)){
    echo "<input type=\"checkbox\" name=\"xanonpost\" checked> "._NE_POSTANON."<br>";
  } elseif((is_user($user)) AND ($neconfig['anonymous_post'] == 1)) {
    echo "<input type=\"checkbox\" name=\"xanonpost\"> "._NE_POSTANON."<br>";
  }
  echo "<input type=\"hidden\" name=\"pid\" value=\"$pid\">";
  echo "<input type=\"hidden\" name=\"sid\" value=\"$sid\">";
  echo "<input type=\"hidden\" name=\"mode\" value=\"$mode\">";
  echo "<input type=\"hidden\" name=\"order\" value=\"$order\">";
  echo "<input type=\"hidden\" name=\"thold\" value=\"$thold\">";
  echo "<select name=\"op\">\n";
  echo "<option value=\"NEReplyPreview\">"._NE_PREVIEWREPLY."</option>\n";
  echo "<option value=\"NEReplyPost\">"._NE_POSTREPLY."</option>\n";
  echo "</select>\n";
  echo "<input type=\"submit\" value=\""._NE_OK."\">\n";
  echo "</form>";
  CloseTable();
}
include("footer.php");

?>