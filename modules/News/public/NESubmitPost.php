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
if(is_user($user)) {
  cookiedecode($user);
  $uid = $cookie[0];
  $uname = $cookie[1];
} else {
  $uid = 1;
  $uname = "$anonymous";
}
$uname = ne_check_html(ne_convert_text($uname), 0);
$subject = ne_check_html(ne_convert_text($subject), 0);
$story = ne_check_html(ne_convert_text($story), 1);
$storyext = ne_check_html(ne_convert_text($storyext), 1);
if(!get_magic_quotes_runtime()) {
  $uname = addslashes($uname);
  $subject = addslashes($subject);
  $story = addslashes($story);
  $storyext = addslashes($storyext);
}
$pagetitle = ": "._NE_SUBMITNEWS;
include('header.php');
OpenTable();
if($neconfig['anonymous_submit'] == 1 OR is_user($user)) {
  if(in_array(stripslashes($uname), $approved_users)) {
    $sql  = "INSERT INTO `".$prefix."_stories` (`aid`, `informant`, `title`, `hometext`, `bodytext`, `time`, `topic`, `alanguage`)";
    $sql .= " VALUES ('".$neconfig['posting_admin']."', '$uname', '$subject', '$story', '$storyext', now(), '$topic', '$alanguage')";
    $result = $db->sql_query($sql);
    if(!$result) {
      echo "<center class='title>"._NE_ERROR."</center>\n";
    } else {
      if($neconfig['notifyauth']) {
        $message = _NE_NOTIFYPOSTED."\n========================================================\n".$subject."\n\n".$story."\n\n".$storyext."\n\n".$uname;
        @mail($adminmail, _NE_ARTICLEPOSTED, stripslashes($message), "From: $adminmail\r\nX-Mailer: NSN-News");
      }
      echo "<center class='title'><b>"._NE_ARTICLEHASPOSTED."</b></center><br>\n";
      echo "<center><b>"._NE_THANKSSUB."</b></center>\n";
      $db->sql_freeresult($result);
    }
  } else {
    $sql  = "INSERT INTO `".$prefix."_queue` (`uid`, `uname`, `subject`, `story`, `storyext`, `timestamp`, `topic`, `alanguage`)";
    $sql .= " VALUES ('$uid', '$uname', '$subject', '$story', '$storyext', now(), '$topic', '$alanguage')";
    $result = $db->sql_query($sql);
    if(!$result) {
      echo "<center class='title>"._NE_ERROR."</center>\n";
    } else {
      if($neconfig['notifyauth']) {
        $message = _NE_NOTIFYSUBMITTED."\n========================================================\n".$subject."\n\n".$story."\n\n".$storyext."\n\n".$uname;
        @mail($adminmail, _NE_ARTICLESUBMITTED, stripslashes($message), "From: $adminmail\r\nX-Mailer: NSN-News");
      }
      echo "<center class='title'><b>"._NE_ARTICLEHASRECIEVED."</b></center><br>\n";
      echo "<center><b>"._NE_THANKSSUB."</b></center><br>\n";
      echo "<center>"._NE_WILLCHECK."</center>\n";
      $db->sql_freeresult($result);
    }
  }
} else{
  echo "<center class='title'>"._NE_ONLYREGISTERED."</center>\n";
}
CloseTable();
include('footer.php');

?>