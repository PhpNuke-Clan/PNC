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
  $notes = "";
  $author = $aid;
  $subject = stripslashes(ne_check_html(ne_convert_text($subject), 0));
  $hometext = stripslashes(ne_check_html(ne_convert_text($hometext), 1));
  $bodytext = stripslashes(ne_check_html(ne_convert_text($bodytext), 1));
  if(!get_magic_quotes_runtime()) {
    $subject = addslashes($subject);
    $hometext = addslashes($hometext);
    $bodytext = addslashes($bodytext);
    $author = addslashes($author);
  }
  $result = $db->sql_query("INSERT INTO `".$prefix."_autonews` VALUES (NULL, '$catid', '$aid', '$subject', '$date', '$hometext', '$bodytext', '$topic', '$author', '$notes', '$ihome', '$alanguage', '$acomm', '$associated')");
  if(!$result) {
    include("header.php");
    NE_Admin(_NE_PROGRAMED." "._NE_ADMIN);
    echo "<br />\n";
    OpenTable();
    echo "<center class='title'><b>"._NE_DBERROR."</b></center>\n";
    CloseTable();
    ne_copy();
    include("footer.php");
  } else {
    $db->sql_freeresult($result);
    $result = $db->sql_query("UPDATE `".$prefix."_authors` SET `counter`=counter+1 WHERE `aid`='$aid'");
    $db->sql_freeresult($result);
    header("Location: ".$admin_file.".php?op=NEProgramedIndex");
  }
} else {
  $subject = stripslashes(ne_check_html(ne_convert_text($subject), 0));
  $hometext = stripslashes(ne_check_html(ne_convert_text($hometext), 1));
  $bodytext = stripslashes(ne_check_html(ne_convert_text($bodytext), 1));
  if(($pollTitle != "") AND (!empty($optionText[1])) AND (!empty($optionText[2])) AND $neconfig['allow_polls'] == 1) {
    $haspoll = 1;
    $timeStamp = time();
    $pollTitle = stripslashes(ne_check_html(ne_convert_text($pollTitle), 0));
    if(!$db->sql_query("INSERT INTO `".$prefix."_poll_desc` (`pollTitle`, `timeStamp`, `planguage`) VALUES ('$pollTitle', '$timeStamp', '$alanguage')")) {
      echo "<center class='title'><b>"._NE_DBERROR."</b></center>\n";
    }
    $object = $db->sql_fetchrow($db->sql_query("SELECT `pollID` FROM `".$prefix."_poll_desc` WHERE `pollTitle`='$pollTitle'"));
    $id = $object['pollID'];
    $id = intval($id);
    for($i = 1; $i <= sizeof($optionText); $i++) {
      if(!empty($optionText[$i])) {
        $optionText[$i] = stripslashes(ne_check_html(ne_convert_text($optionText[$i]), 0));
      }
      if(!$db->sql_query("INSERT INTO `".$prefix."_poll_data` (`pollID`, `optionText`, `optionCount`, `voteID`) VALUES ('$id', '$optionText[$i]', '0', '$i')")) {
        echo "<center class='title'><b>"._NE_DBERROR."</b></center>\n";
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
    $xaid = addslashes($xaid);
  }
  $sql  = "INSERT INTO `".$prefix."_stories` (`catid`, `aid`, `title`, `time`, `hometext`, `bodytext`, `topic`, `informant`, `notes`, `ihome`, `alanguage`, `acomm`, `haspoll`, `pollID`, `associated`)";
  $sql .= " VALUES ('$catid', '$xaid', '$subject', now(), '$hometext', '$bodytext', '$topic', '$xaid', '$notes', '$ihome', '$alanguage', '$acomm', '$haspoll', '$id', '$associated')";
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
    list($artid) = $db->sql_fetchrow($db->sql_query("SELECT `sid` FROM `".$prefix."_stories` WHERE `title`='$subject' ORDER BY `time` DESC limit 0,1"));
    $artid = intval($artid);
    $db->sql_query("UPDATE `".$prefix."_poll_desc` SET `artid`='$artid' WHERE `pollID`='$id'");
    $result = $db->sql_query("UPDATE `".$prefix."_authors` SET `counter`=`counter`+1 WHERE `aid`='$aid'");
    if($ultramode) { ultramode(); }
    header("Location: ".$admin_file.".php?op=NEStoryIndex");
  }
}

?>