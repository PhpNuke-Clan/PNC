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
if($neconfig['anonymous_post'] == 0 AND !is_user($user)) {
  include("header.php");
  title(_NE_REPLYTOCOMMENT);
  OpenTable();
  echo "<center>"._NE_NOANONCOMMENTS."</center><br>\n";
  echo "<center>"._GOBACK."</center>\n";
  CloseTable();
  include("footer.php");
} else {
  cookiedecode($user);
  $author = ne_check_html(ne_convert_text($author), 0);
  $subject = ne_check_html(ne_convert_text($subject), 0);
  $comment = ne_check_html(ne_convert_text($comment), 1);
  if(is_user($user) && !$xanonpost) {
    getusrinfo($user);
    $name = $userinfo['username'];
    $email = $userinfo['femail'];
    $url = $userinfo['user_website'];
    $score = 1;
  } else {
    $name = $email = $url = "";
    $score = 0;
  }
  $ip = $nsnst_const['remote_ip'];
  if(empty($ip)) { $ip = $_SERVER["REMOTE_ADDR"]; }
  $fake = $db->sql_numrows($db->sql_query("SELECT * FROM `".$prefix."_stories` WHERE `sid`='$sid'"));
  $acomm = intval($fake['acomm']);
  $comment = trim($comment);
  if(($fake == 1) AND ($neconfig['allow_comments'] == 1)) {
    if(((($neconfig['anonymous_post'] == 0) AND (is_user($user))) OR ($neconfig['anonymous_post'] == 1)) AND $acomm == 0) {
      if(!get_magic_quotes_runtime()) {
        $name = addslashes($name);
        $email = addslashes($email);
        $url = addslashes($url);
        $subject = addslashes($subject);
        $comment = addslashes($comment);
      }
      $sql  = "INSERT INTO ".$prefix."_comments (`pid`, `sid`, `date`, `name`, `email`, `url`, `host_name`, `subject`, `comment`, `score`)";
      $sql .= " VALUES ('$pid', '$sid', now(), '$name', '$email', '$url', '$ip', '$subject', '$comment', '$score')";
      $result = $db->sql_query($sql);
      if(!$result) {
        include("header.php");
        OpenTable();
        echo "<center class='title>"._NE_DBERROR."</center>\n";
        CloseTable();
        include("footer.php");
        die();
      } else {
        $db->sql_freeresult($result);
        $db->sql_query("UPDATE `".$prefix."_stories` SET `comments`=`comments`+1 WHERE `sid`='$sid'");
        update_points(5);

        /********** BEGIN Raven's hack to notify those who have replied to this article ***********/
        $row = $db->sql_fetchrow($db->sql_query("SELECT max(tid) as tid FROM `".$prefix."_comments` WHERE `sid`='$sid'"));
        $tid = $row['tid'];
        $row = $db->sql_fetchrow($db->sql_query("SELECT `aid`, `informant`, `title` FROM `".$prefix."_stories` WHERE `sid`='$sid'"));
        $aid = $row['aid'];
        $title = $row['title'];
        $informant = $row['informant'];
        $row = $db->sql_fetchrowset($db->sql_query("SELECT `name` FROM `".$prefix."_comments` WHERE `sid`='$sid'"));
        $comment = str_replace("<br>", "\n", $comment);
        $comment = str_replace("<br />", "\n", $comment);
        $comment = stripslashes($comment);
        $msg  = $name.""._NE_REPLYPRETEXT."".$title.""._NE_REPLYPOSTTEXT."".$comment;
        $msg .= "\n\n"._NE_VIEWTHEARTICLE."\n$nukeurl/".$module_link."op=NEArticle&sid=$sid#$tid";
        if($pid>0)
        $msg .= "\n\n"._NE_VIEWTHECOMMENT."\n$nukeurl/".$module_link."op=NECommentShow&tid=$tid&sid=$sid&pid=$pid";
        while(strstr($msg,"''")) { $msg = str_replace("''","'",$msg); }
        $notify = Array();
        if($neconfig['notify_admin']) { $notify[] = $adminmail; }
        for($i=0;$i<count($row);$i++) {
          if($i==0) {
            if($neconfig['notify_poster']) {
              $row1 = $db->sql_fetchrow($db->sql_query("SELECT `username`, `user_email` FROM `".$user_prefix."_users` WHERE `username`='$aid'"));
              if(!$neconfig['notify_commenter']) if(strtolower($name)==strtolower($row1['username'])) continue;
              if(in_array($row1['user_email'],$notify)) continue;
              if(strstr($row1['user_email'],'@') && strstr($row1['user_email'],'.')) $notify[] = addslashes($row1['user_email']);
            }
            if($neconfig['notify_informanter']) {
              $row1 = $db->sql_fetchrow($db->sql_query("SELECT `username`, `user_email` FROM `".$user_prefix."_users` WHERE `username`='$informant'"));
              if(!$neconfig['notify_commenter']) if(strtolower($name)==strtolower($row1['username'])) continue;
              if(in_array($row1['user_email'],$notify)) continue;
              if(strstr($row1['user_email'],'@') && strstr($row1['user_email'],'.')) $notify[] = addslashes($row1['user_email']);
            }
          }
          $sql = "SELECT `username`, `user_email` FROM `".$user_prefix."_users` WHERE `username`='".$row[$i][0]."'";
          $result = $db->sql_query($sql);
          $row1 = $db->sql_fetchrow($result);
          $db->sql_freeresult($result);
          if(!$neconfig['notify_commenter']) if(strtolower($name)==strtolower($row1['username'])) continue;
          if(in_array($row1['user_email'],$notify)) continue;
          if(strstr($row1['user_email'],'@')&&strstr($row1['user_email'],'.')) $notify[] = addslashes($row1['user_email']);
        }
        for($i=0;$i<count($notify);$i++) {
          $to = $notify[$i];
          $headers  = "From: $sitename <$to>\r\n";
          $headers .= "Reply-To: $to\r\n";
          $headers .= "Return-Path: $to\r\n";
          $headers .= "X-Priority: 1\r\n";
          $headers .= "X-MSMail-Priority: High\r\n";
          $headers .= "X-Mailer: $sitename";
          @mail($to, _NE_REPLYNOTIFICATION.$title, stripslashes($msg), $headers);
        }
        /********** END   Raven's hack to notify those who have replied to this article ***********/

        if($ultramode) { ultramode(); }
      }
    } else {
      die("Illegal Operation Attempted!");
    }
  } else {
    include("header.php");
    OpenTable();
    echo "<center class='title>"._NE_ARTICLEREPLY."</center>\n";
    CloseTable();
    include("footer.php");
    die();
  }
  header("Location: modules.php?name=$module_name&op=NEArticle&sid=$sid");
}
?>