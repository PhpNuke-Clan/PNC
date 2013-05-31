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
//for($i=0; $i<sizeof($assotop); $i++) { $associated .= "$assotop[$i]-"; }
if(is_array($assotop)) {
  $associated = implode("-", $assotop);
} else {
  $associated = $assotop;
}
if($automated == 1) {
  if($day < 10) { $day = "0$day"; }
  if($month < 10) { $month = "0$month"; }
  $sec = "00";
  $date = "$year-$month-$day $hour:$min:$sec";
  if($uid == 1) $author = "";
  if($hometext == $bodytext) $bodytext = "";
  $subject = stripslashes(ne_check_html(ne_convert_text($subject), 0));
  $hometext = stripslashes(ne_check_html(ne_convert_text($hometext), 1));
  $bodytext = stripslashes(ne_check_html(ne_convert_text($bodytext), 1));
  $notes = stripslashes(ne_check_html(ne_convert_text($notes), 1));
  if(!get_magic_quotes_runtime()) {
    $subject = addslashes($subject);
    $hometext = addslashes($hometext);
    $bodytext = addslashes($bodytext);
    $notes = addslashes($notes);
    $author = addslashes($author);
  }
  $result = $db->sql_query("insert into ".$prefix."_autonews values (NULL, '$catid', '$aid', '$subject', '$date', '$hometext', '$bodytext', '$topic', '$author', '$notes', '$ihome', '$alanguage', '$acomm', '$associated')");
  if(!$result) { return; }
  $result = $db->sql_query("select sid from ".$prefix."_stories WHERE title='$subject' order by time DESC limit 0,1");
  list($artid) = $db->sql_fetchrow($result);
  $artid = intval($artid);
  if($uid != 1) {
    $db->sql_query("update ".$user_prefix."_users set counter=counter+1 where user_id='$uid'");
    // Copyright (c) 2000-2005 by NukeScripts Network
    if($ne_config['notifyauth'] == 1) {
      $urow = $db->sql_fetchrow($db->sql_query("SELECT username, user_email FROM ".$user_prefix."_users WHERE user_id='$uid'"));
      $Mto = $urow['username']." <".$urow['user_email'].">";
      $Msubject = _NE_ARTPUB;
      $Mbody = _NE_HASPUB."\n$nukeurl/modules.php?name=News&op=NEArticle&sid=$artid";
      $Mheaders  = "From: ".$sitename." <$adminmail>\r\n";
      $Mheaders .= "Reply-To: $adminmail\r\n";
      $Mheaders .= "Return-Path: $adminmail\r\n";
      $Mheaders .= "Organization: $sitename\r\n";
      $Mheaders .= "MIME-Version: 1.0\r\n";
      $Mheaders .= "Content-Type: text/plain\r\n";
      $Mheaders .= "Content-Transfer-Encoding: 8bit\r\n";
      $Mheaders .= "X-MSMail-Priority: High\r\n";
      $Mheaders .= "X-Mailer: NSN News";
      @mail($Mto, $Msubject, $Mbody, $Mheaders);
    }
    // Copyright (c) 2000-2005 by NukeScripts Network
    $row = $db->sql_fetchrow($db->sql_query("SELECT points FROM ".$prefix."_groups_points WHERE id='4'"));
    $db->sql_query("UPDATE ".$user_prefix."_users SET points=points+$row[points] where user_id='$uid'");
  }
  $db->sql_query("update ".$prefix."_authors set counter=counter+1 where aid='$aid'");
  if($ultramode) { ultramode(); }
  $qid = intval($qid);
  $db->sql_query("delete from ".$prefix."_queue where qid='$qid'");
  header("Location: ".$admin_file.".php?op=submissions");
} else {
  if($uid == 1) $author = "";
  if($hometext == $bodytext) $bodytext = "";
  $subject = stripslashes(ne_check_html(ne_convert_text($subject), 0));
  $hometext = stripslashes(ne_check_html(ne_convert_text($hometext), 1));
  $bodytext = stripslashes(ne_check_html(ne_convert_text($bodytext), 1));
  $notes = stripslashes(ne_check_html(ne_convert_text($notes), 1));
  if(($pollTitle != "") AND (!empty($optionText[1])) AND (!empty($optionText[2])) AND $neconfig['allow_polls'] == 1) {
    $haspoll = 1;
    $timeStamp = time();
    $pollTitle = stripslashes(ne_check_html(ne_convert_text($pollTitle), 0));
    if(!$db->sql_query("INSERT INTO ".$prefix."_poll_desc VALUES (NULL, '$pollTitle', '$timeStamp', '0', '$alanguage', '0')")) {
      return;
    }
    $object = $db->sql_fetchrow($db->sql_query("SELECT pollID FROM ".$prefix."_poll_desc WHERE pollTitle='$pollTitle'"));
    $id = $object['pollID'];
    $id = intval($id);
    for($i = 1; $i <= sizeof($optionText); $i++) {
      if($optionText[$i] != "") {
        $optionText[$i] = stripslashes(ne_check_html(ne_convert_text($optionText[$i]), 0));
      }
      if(!$db->sql_query("INSERT INTO ".$prefix."_poll_data (pollID, optionText, optionCount, voteID) VALUES ('$id', '$optionText[$i]', '0', '$i')")) {
        return;
      }
    }
  } else {
    $haspoll = 0;
    $id = 0;
  }
  $xaid = $aid;
  if(!get_magic_quotes_runtime()) {
    $subject = addslashes($subject);
    $hometext = addslashes($hometext);
    $bodytext = addslashes($bodytext);
    $notes = addslashes($notes);
    $author = addslashes($author);
    $xaid = addslashes($xaid);
  }
  $sql  = "INSERT INTO `".$prefix."_stories` (`catid`, `aid`, `title`, `time`, `hometext`, `bodytext`, `topic`, `informant`, `notes`, `ihome`, `alanguage`, `acomm`, `haspoll`, `pollID`, `associated`)";
  $sql .= " VALUES ('$catid', '$xaid', '$subject', now(), '$hometext', '$bodytext', '$topic', '$author', '$notes', '$ihome', '$alanguage', '$acomm', '$haspoll', '$id', '$associated')";
  $result = $db->sql_query($sql);
  if(!$result) {
    include("header.php");
    NE_Admin(_NE_STORY." "._NE_ADMIN);
    echo "<br />\n";
    OpenTable();
    echo "<center class='title'><b>"._NE_DBERROR."</b></center>\n";
    CloseTable();
    ne_copy();
    include("footer.php");
  } else {
    list($artid) = $db->sql_fetchrow($db->sql_query("select sid from ".$prefix."_stories WHERE title='$subject' order by time DESC limit 0,1"));
    $artid = intval($artid);
    $db->sql_query("UPDATE ".$prefix."_poll_desc SET artid='$artid' WHERE pollID='$id'");
    if(!$result) { return; }
    if($uid != 1) {
      $db->sql_query("update ".$user_prefix."_users set counter=counter+1 where user_id='$uid'");
      // Copyright (c) 2000-2005 by NukeScripts Network
      if($ne_config['notifyauth'] == 1) {
        $urow = $db->sql_fetchrow($db->sql_query("SELECT username, user_email FROM ".$user_prefix."_users WHERE user_id='$uid'"));
        $Mto = $urow['username']." <".$urow['user_email'].">";
        $Msubject = _NE_ARTPUB;
        $Mbody = _NE_HASPUB."\n$nukeurl/modules.php?name=News&op=NEArticle&sid=$artid";
        $Mheaders  = "From: ".$sitename." <$adminmail>\r\n";
        $Mheaders .= "Reply-To: $adminmail\r\n";
        $Mheaders .= "Return-Path: $adminmail\r\n";
        $Mheaders .= "Organization: $sitename\r\n";
        $Mheaders .= "MIME-Version: 1.0\r\n";
        $Mheaders .= "Content-Type: text/plain\r\n";
        $Mheaders .= "Content-Transfer-Encoding: 8bit\r\n";
        $Mheaders .= "X-MSMail-Priority: High\r\n";
        $Mheaders .= "X-Mailer: NSN News";
        @mail($Mto, $Msubject, $Mbody, $Mheaders);
      }
      // Copyright (c) 2000-2005 by NukeScripts Network
      $row = $db->sql_fetchrow($db->sql_query("SELECT points FROM ".$prefix."_groups_points WHERE id='4'"));
      $db->sql_query("UPDATE ".$user_prefix."_users SET points=points+$row[points] where user_id='$uid'");
      $db->sql_query("update ".$user_prefix."_users set counter=counter+1 where user_id='$uid'");
    }
    $db->sql_query("update ".$prefix."_authors set counter=counter+1 where aid='$aid'");
    if($ultramode) { ultramode(); }
    header("Location: ".$admin_file.".php?op=NESubmissionDelete&qid=$qid");
  }
}

?>