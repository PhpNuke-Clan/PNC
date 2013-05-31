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
if(!isset($sid) && !isset($tid)) { header("Location: $form_link"); }
$result = $db->sql_query("SELECT * FROM `".$prefix."_stories` WHERE `sid`='$sid'");
if($numrows = $db->sql_numrows($result) < 1) {
  header("Location: $nukeurl");
  die();
}
$row = $db->sql_fetchrow($result);
if(empty($row['aid'])) { header("Location: $form_link"); }
$associated = $row['associated'];
$catid = intval($row['catid']);
$aid = ne_check_html(ne_convert_text($row['aid']), 0);
$time = $row['time'];
$title = stripslashes(ne_check_html(ne_convert_text($row['title']), 0));
$hometext = stripslashes(ne_check_html(ne_convert_text($row['hometext']), 1));
$bodytext = stripslashes(ne_check_html(ne_convert_text($row['bodytext']), 1));
$notes = stripslashes(ne_check_html(ne_convert_text($row['notes']), 1));
$topic = intval($row['topic']);
$informant = ne_check_html(ne_convert_text($row['informant']), 0);
$acomm = intval($row['acomm']);
$haspoll = intval($row['haspoll']);
$pollID = intval($row['pollID']);
$score = intval($row['score']);
$ratings = intval($row['ratings']);
$counter = intval($row['counter']);
$counter++;
$db->sql_freeresult($result);
$db->sql_query("UPDATE `".$prefix."_stories` SET `counter`='$counter' WHERE `sid`='$sid'");

$artpage = 1;
$pagetitle = "- $title";
require("header.php");
$artpage = 0;

formatTimestamp($time);

if(!empty($notes)) { $notes = "<br><br><b>"._NE_NOTE.":</b> <i>$notes</i>"; } else { $notes = ""; }
if(empty($bodytext)) { $articletext = "$hometext".$notes; } else { $articletext = $hometext."<br><br>".$bodytext.$notes; }
if(empty($informant)) { $informant = $anonymous; }
getTopics($sid);
if($catid != 0) {
  $result2 = $db->sql_query("SELECT `title` FROM `".$prefix."_stories_cat` WHERE `catid`='$catid'");
  $row2 = $db->sql_fetchrow($result2);
  $db->sql_freeresult($result2);
  $title1 = stripslashes(ne_check_html(ne_convert_text($row2['title']), 0));
  $title = "<a href=\"".$module_link."op=NECategoryList&amp;catid=$catid\"><span class=\"storycat\">$title1</span></a>: $title";
}
if($neconfig['allow_rating'] == 1 OR $neconfig['allow_related'] == 1 OR ($neconfig['allow_polls'] == 1 AND $haspoll ==1)) {
  echo "<table width=\"100%\" border=\"0\"><tr><td valign=\"top\" width=\"100%\">\n";
}
themearticle($aid, $informant, $datetime, $title, $articletext, $topic, $topicname, $topicimage, $topictext);
echo "";
OpenTable();
echo "<center class='title'>"._NE_OPTIONS."<br></center>\n";
echo "<center>&nbsp;<a href=\"".$module_link."op=NEPrint&amp;sid=$sid\" target='_blank'><img src='modules/$module_name/images/print.png' border='0' alt='"._NE_PRINTER."' title='"._NE_PRINTER."' vspace='5'></a>&nbsp;";
echo "&nbsp;<a href=\"".$module_link."op=NEPortable&amp;sid=$sid\" target='_blank'><img src='modules/$module_name/images/pdf.png' border='0' alt='"._NE_PDF."' title='"._NE_PDF."' vspace='5'></a>&nbsp;";
if(is_user($user)) {
  echo "&nbsp;<a href=\"".$module_link."op=NEFriend&amp;sid=$sid\" target='_blank'><img src='modules/$module_name/images/friend.png' border='0' alt='"._NE_FRIENDSEND."' title='"._NE_FRIENDSEND."' vspace='5'></a>&nbsp;";
}
if(is_admin($admin)) {
  echo "&nbsp;<a href=\"".$admin_file.".php?op=adminStory\"><img src='modules/$module_name/images/add.png' border='0' alt='"._NE_ADD."' title='"._NE_ADD."' vspace='5'></a>&nbsp;";
  echo "&nbsp;<a href=\"".$admin_file.".php?op=EditStory&sid=$sid\"><img src='modules/$module_name/images/edit.png' border='0' alt='"._NE_EDIT."' title='"._NE_EDIT."' vspace='5'></a>&nbsp;";
  echo "&nbsp;<a href=\"".$admin_file.".php?op=RemoveStory&sid=$sid\"><img src='modules/$module_name/images/delete.png' border='0' alt='"._NE_DELETE."' title='"._NE_DELETE."' vspace='5'></a>&nbsp;";
}
echo "</center>\n";
CloseTable();
echo "<br>\n";
if($neconfig['allow_rating'] == 1 OR $neconfig['allow_related'] == 1 OR ($neconfig['allow_polls'] == 1 AND $haspoll ==1)) {
  echo "</td><td>&nbsp;</td><td valign=\"top\">\n";
}

/* Determine if the article has attached a poll */
if($haspoll == 1 AND $neconfig['allow_polls'] == 1) {
    $boxTitle = _NE_ARTICLEPOLL;
    $url = sprintf("modules.php?name=Surveys&amp;op=results&amp;pollID=%d", $pollID);
    $boxContent = "<form action=\"modules.php?name=Surveys\" method=\"post\">";
    $boxContent .= "<input type=\"hidden\" name=\"pollID\" value=\"".$pollID."\">";
    $boxContent .= "<input type=\"hidden\" name=\"forwarder\" value=\"".$url."\">";
    $result3 = $db->sql_query("SELECT `pollTitle`, `voters` FROM `".$prefix."_poll_desc` WHERE `pollID`='$pollID'");
    $row3 = $db->sql_fetchrow($result3);
    $db->sql_freeresult($result3);
    $pollTitle = ne_check_html(ne_convert_text($row3['pollTitle']), 0);
    $voters = $row3['voters'];
    $boxContent .= "<b>$pollTitle</b><br><br>\n";
    $boxContent .= "<table border=\"0\" width=\"100%\">";
    for($i = 1; $i <= 12; $i++) {
      $result4 = $db->sql_query("SELECT `pollID`, `optionText`, `optionCount`, `voteID` FROM `".$prefix."_poll_data` WHERE (`pollID`='$pollID') AND (`voteID`='$i')");
      $row4 = $db->sql_fetchrow($result4);
      $numrows = $db->sql_numrows($result4);
      $db->sql_freeresult($result4);
      if($numrows != 0) {
        if(!empty($row4['optionText'])) {
          $boxContent .= "<tr><td valign=\"top\"><input type=\"radio\" name=\"voteID\" value=\"".$i."\"></td><td width=\"100%\">".$row4['optionText']."</td></tr>\n";
        }
      }
    }
    $boxContent .= "</table><br><center><input type=\"submit\" value=\""._VOTE."\"><br>";
    if(is_user($user)) {
        cookiedecode($user);
    }
    for($i = 0; $i < 12; $i++) {
      $result5 = $db->sql_query("SELECT `optionCount` FROM `".$prefix."_poll_data` WHERE (`pollID`='$pollID') AND (`voteID`='$i')");
      $row5 = $db->sql_fetchrow($result5);
      $db->sql_freeresult($result5);
      $optionCount = $row5['optionCount'];
      $sum = (int)$sum+$optionCount;
    }
    $boxContent .= "[ <a href=\"modules.php?name=Surveys&amp;op=results&amp;pollID=$pollID&amp;mode=$cookie[4]&amp;order=$cookie[5]&amp;thold=$cookie[6]\"><b>"._RESULTS."</b></a> | <a href=\"modules.php?name=Surveys\"><b>"._POLLS."</b></a> ]<br>";

    if($pollcomm) {
      $result6 = $db->sql_query("SELECT * FROM `".$prefix."_pollcomments` WHERE `pollID`='$pollID'");
      $numcom = $db->sql_numrows($result6);
      $db->sql_freeresult($result6);
      $boxContent .= "<br>"._VOTES.": <b>$sum</b><br>"._PCOMMENTS." <b>$numcom</b>\n\n";
    } else {
      $boxContent .= "<br>"._VOTES." <b>$sum</b>\n\n";
    }
    $boxContent .= "</center></form>\n\n";
    themesidebox($boxTitle, $boxContent);
}

if($neconfig['allow_related'] == 1) {
  $boxtitle = ""._NE_RELATEDLINKS."";
  $boxstuff = "";
  $result8 = $db->sql_query("SELECT `name`, `url` FROM `".$prefix."_related` WHERE `tid`='$topic'");
  while($row8 = $db->sql_fetchrow($result8)) {
    $row8['name'] = ne_check_html(ne_convert_text($row8['name']), 0);
    $row8['url'] = ne_check_html(ne_convert_text($row8['url']), 0);
    $boxstuff .= "<strong><big>&middot;</big></strong>&nbsp;<a href=\"".$row8['url']."\" target=\"new\">".$row8['name']."</a><br>\n";
  }
  $db->sql_freeresult($result8);
  $boxstuff .= "<strong><big>&middot;</big></strong>&nbsp;<a href=\"modules.php?name=Search&amp;topic=$topic\">"._NE_MOREABOUT." $topictext</a><br>\n";
  $boxstuff .= "<strong><big>&middot;</big></strong>&nbsp;<a href=\"modules.php?name=Search&amp;author=$aid\">"._NE_NEWSBY." $aid</a>\n";
  $boxstuff .= "<br><hr noshade width=\"95%\" size=\"1\"><center><b>"._NE_MOSTREAD." $topictext:</b><br>\n";

  global $multilingual, $currentlang, $user;
  $querylang = "";
  if($multilingual == 1) { $querylang = "AND (`alanguage`='$currentlang' OR `alanguage`='')"; }
  $result9 = $db->sql_query("SELECT `sid`, `title` FROM `".$prefix."_stories` WHERE `topic`='$topic' $querylang ORDER BY `counter` DESC LIMIT 0,1");
  $row9 = $db->sql_fetchrow($result9);
  $db->sql_freeresult($result9);
  $topstory = intval($row9['sid']);
  $ttitle = ne_check_html(ne_convert_text($row9['title']), 0);

  $boxstuff .= "<a href=\"".$module_link."op=NEArticle&amp;sid=$topstory\">$ttitle</a></center><br>\n";
  themesidebox($boxtitle, $boxstuff);
}

if($neconfig['allow_rating'] == 1) {
  if($ratings != 0) {
    $rate = substr($score / $ratings, 0, 4);
    $r_image = round($rate);
    if($r_image == 1) {
      $the_image = "<br><br><img src=\"modules/$module_name/images/rating/stars-1.png\" border=\"1\"></center><br>";
    } elseif($r_image == 2) {
      $the_image = "<br><br><img src=\"modules/$module_name/images/rating/stars-2.png\" border=\"1\"></center><br>";
    } elseif($r_image == 3) {
      $the_image = "<br><br><img src=\"modules/$module_name/images/rating/stars-3.png\" border=\"1\"></center><br>";
    } elseif($r_image == 4) {
      $the_image = "<br><br><img src=\"modules/$module_name/images/rating/stars-4.png\" border=\"1\"></center><br>";
    } elseif($r_image == 5) {
      $the_image = "<br><br><img src=\"modules/$module_name/images/rating/stars-5.png\" border=\"1\"></center><br>";
    }
  } else {
    $rate = 0;
    $the_image = "<br><br><img src=\"modules/$module_name/images/rating/stars-0.png\" border=\"1\"></center><br>";
  }
  $ratetitle = ""._NE_ARTICLERATING."";
  $ratecontent = "<center>"._NE_AVERAGESCORE.": <b>$rate</b><br>"._VOTES.": <b>$ratings</b>$the_image";
  $ratecontent .= "<form action=\"$form_link\" method=\"post\"><center>"._NE_RATETHISARTICLE."</center><br>";
  $ratecontent .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\">";
  $ratecontent .= "<input type=\"hidden\" name=\"op\" value=\"NERate\">";
  $ratecontent .= "<input type=\"radio\" name=\"score\" value=\"5\"> <img src=\"modules/$module_name/images/rating/stars-5.png\" border=\"0\" alt=\""._NE_EXCELLENT."\" title=\""._NE_EXCELLENT."\"><br>";
  $ratecontent .= "<input type=\"radio\" name=\"score\" value=\"4\"> <img src=\"modules/$module_name/images/rating/stars-4.png\" border=\"0\" alt=\""._NE_VERYGOOD."\" title=\""._NE_VERYGOOD."\"><br>";
  $ratecontent .= "<input type=\"radio\" name=\"score\" value=\"3\"> <img src=\"modules/$module_name/images/rating/stars-3.png\" border=\"0\" alt=\""._NE_GOOD."\" title=\""._NE_GOOD."\"><br>";
  $ratecontent .= "<input type=\"radio\" name=\"score\" value=\"2\"> <img src=\"modules/$module_name/images/rating/stars-2.png\" border=\"0\" alt=\""._NE_REGULAR."\" title=\""._NE_REGULAR."\"><br>";
  $ratecontent .= "<input type=\"radio\" name=\"score\" value=\"1\"> <img src=\"modules/$module_name/images/rating/stars-1.png\" border=\"0\" alt=\""._NE_BAD."\" title=\""._NE_BAD."\"><br>";
  $ratecontent .= "<input type=\"radio\" name=\"score\" value=\"0\"> <img src=\"modules/$module_name/images/rating/stars-0.png\" border=\"0\" alt=\""._NE_VERYBAD."\" title=\""._NE_VERYBAD."\"><br><br>";
  $ratecontent .= "<center><input type=\"submit\" value=\""._NE_CASTMYVOTE."\"></center></form>";
  themesidebox($ratetitle, $ratecontent);
}
if($neconfig['allow_rating'] == 1 OR $neconfig['allow_related'] == 1 OR ($neconfig['allow_polls'] == 1 AND $haspoll ==1)) {
  echo "</td></tr></table>\n";
}
cookiedecode($user); // WHY IS THIS HERE?

if(!empty($associated)) {
    OpenTable();
    echo "<center><b>"._ASSOTOPIC."</b><br><br>";
    $asso_t = explode("-",$arow[associated]);
    for($i=0; $i<sizeof($asso_t); $i++) {
	if($asso_t[$i] != "") {
	    $aresult = $db->sql_query("SELECT `topicimage`, `topictext` FROM `".$prefix."_topics` WHERE `topicid`='$asso_t[$i]'");
	    $atop = $db->sql_fetchrow($aresult);
	    $db->sql_freeresult($aresult);
	    echo "<a href=\"".$module_link."new_topic=$asso_t[$i]\"><img src=\"$tipath$atop[topicimage]\" border=\"0\" hspace=\"10\" alt=\"$atop[topictext]\" title=\"$atop[topictext]\"></a>";
	}
    }
    echo "</center>";
    CloseTable();
    echo "<br>";
}

if(($mode != "nocomments" OR $acomm == 0) OR $neconfig['allow_comments'] == 1) { include("modules/News/public/NECommentShow.php"); }
include("footer.php");

?>