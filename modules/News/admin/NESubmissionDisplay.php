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
include("header.php");
NE_Admin(_NE_SUBMISSIONS." "._NE_ADMIN);
echo "<br />\n";
$tday = date("d");
$tmonth = date("F");
$ttmon = date("m");
$tyear = date("Y");
$thour = date("H");
$tmin = date("i");
$tsec = date("s");
$date = "$tmonth $tday, $tyear @ $thour:$tmin:$tsec";
$qid = intval($qid);
$result = $db->sql_query("SELECT qid, uid, uname, subject, story, storyext, topic, alanguage FROM ".$prefix."_queue where qid='$qid'");
list($qid, $uid, $uname, $subject, $story, $storyext, $topic, $alanguage) = $db->sql_fetchrow($result);
$qid = intval($qid);
$uid = intval($uid);
$subject = stripslashes(ne_check_html(ne_convert_text($subject), 0));
$story = stripslashes(ne_check_html(ne_convert_text($story), 1));
$storyext = stripslashes(ne_check_html(ne_convert_text($storyext), 1));
$thetext = $story;
if(!empty($storyext)) { $thetext .= "<br /><br />".$storyext; }
$thetext = stripslashes($thetext);
$datetime = date("D M d, Y g:i a");
OpenTable();
themeindex($aid, $uname, $datetime, $subject, 0, $topic, $thetext, $notes, $morelink, $tinfo['topicname'], $tinfo['topicimage'], $tinfo['topictext']);
echo "<br />\n";
echo "<form action='".$admin_file.".php' method='post'>\n";
echo "<table align='center' border='0' cellpadding='2' cellspacing='2'>\n";
echo "<tr><td bgcolor='$bgcolor2'><b>"._NE_NAME."</b></td><td><input type='text' NAME='author' size='25' value=\"$uname\">\n";
if($uname != $anonymous) {
  $res = $db->sql_query("select user_email from ".$user_prefix."_users where username='$uname'");
  list($email) = $db->sql_fetchrow($res);
  echo "&nbsp;&nbsp;[ <a href='mailto:$email?Subject=Re: $subject'>"._NE_EMAILUSER."</a> | <a href='modules.php?name=Your_Account&op=userinfo&username=$uname'>"._NE_USERPROFILE."</a> | <a href='modules.php?name=Private_Messages&amp;mode=post&amp;u=$uid'>"._NE_SENDAPM."</a> ]\n";
}
echo "</td></tr>\n";
echo "<tr><td bgcolor='$bgcolor2'><b>"._NE_TITLE."</b></td><td>\n";
echo "<input type='text' name='subject' size='50' value=\"$subject\"></td></tr>\n";
if($topic=="") { $topic = 1; }
$result = $db->sql_query("select * from ".$prefix."_topics where topicid='$topic'");
$tinfo = $db->sql_fetchrow($result);
echo "<tr><td bgcolor='$bgcolor2'><b>"._TOPIC."</b></td><td><select name='topic'>\n";
$toplist = $db->sql_query("select topicid, topictext from ".$prefix."_topics order by topictext");
echo "<option value=''>"._NE_SELECTTOPIC."</option>\n";
while(list($topicid, $topics) = $db->sql_fetchrow($toplist)) {
  $topicid = intval($topicid);
  if($topicid==$topic) { $sel = "selected "; }
  echo "<option $sel value='$topicid'>$topics</option>\n";
  $sel = "";
}
echo "</select><br />\n</td></tr>\n";
echo "<tr><td bgcolor='$bgcolor2'><b>"._ASSOTOPIC."</b></td><td><select name='assotop[]' size='5' multiple>\n";
$result = $db->sql_query("SELECT `topicid`, `topictext` FROM `".$prefix."_topics` ORDER BY `topictext`");
while($row = $db->sql_fetchrow($result)) {
  $row['topicid'] = intval($row['topicid']);
  $row['topictext'] = ne_check_html(ne_convert_text($row['topictext']), 0);
  if(in_array($row['topicid'], $asso_t)) { $sel = " selected"; }
  echo "<option value='".$row['topicid']."'$sel>".$row['topictext']."</option>\n";
  $sel = "";
}
echo "</select>\n</td></tr>\n";
$selcat = $db->sql_query("select catid, title from ".$prefix."_stories_cat order by title");
$a = 1;
echo "<tr><td bgcolor='$bgcolor2'><b>"._NE_CATEGORY."</b></td><td><select name='catid'>\n";
$sel = "";
if($cat == 0) { $sel = "selected"; }
echo "<option name='catid' value='0' $sel>"._NE_ARTICLES."</option>\n";
while(list($catid, $title) = $db->sql_fetchrow($selcat)) {
  $catid = intval($catid);
  $sel = "";
  if($catid == $cat) { $sel = "selected"; }
  echo "<option name='catid' value='$catid' $sel>$title</option>\n";
  $a++;
}
echo "</select></td></tr>\n";
echo "<tr><td bgcolor='$bgcolor2' valign='top'><b>"._NE_PUBLISHINHOME."</b></td><td>";
$sel1 = $sel2 = "";
if(($ihome == 0) OR ($ihome == "")) { $sel1 = "checked"; }
if($ihome == 1) { $sel2 = "checked"; }
echo "<input type='radio' name='ihome' value='0' $sel1>"._NE_YES."&nbsp;";
echo "<input type='radio' name='ihome' value='1' $sel2>"._NE_NO."";
echo "<br>[ "._NE_ONLYIFCATSELECTED." ]</td></tr>\n";
echo "<tr><td bgcolor='$bgcolor2'><b>"._NE_ACTIVATECOMMENTS."</b></td><td>";
$sel1 = $sel2 = "";
if(($acomm == 0) OR ($acomm == "")) { $sel1 = "checked"; }
if($acomm == 1) { $sel2 = "checked"; }
echo "<input type='radio' name='acomm' value='0' $sel1>"._NE_YES."&nbsp;";
echo "<input type='radio' name='acomm' value='1' $sel2>"._NE_NO."</td></tr>\n";
if($multilingual == 1) {
  echo "<tr><td bgcolor='$bgcolor2'><b>"._NE_LANGUAGE.":</b></td><td><select name='alanguage'>\n";
  $handle=opendir('language');
  while($file = readdir($handle)) {
    if(preg_match("/^lang\-(.+)\.php/", $file, $matches)) {
      $langFound = $matches[1];
      $languageslist .= "$langFound ";
    }
  }
  closedir($handle);
  $languageslist = explode(" ", $languageslist);
  sort($languageslist);
  for($i=0; $i < sizeof($languageslist); $i++) {
    if($languageslist[$i]!="") {
      echo "<option value='$languageslist[$i]' ";
      if($languageslist[$i]==$alanguage) echo "selected";
      echo ">".ucfirst($languageslist[$i])."</option>\n";
    }
  }
  $sellang = "";
  if($alanguage == "") { $sellang = "selected"; }
  echo "<option value='' $sellang>"._NE_ALL."</option>\n</select></td></tr>\n";
} else {
  echo "<input type='hidden' name='alanguage' value=''>\n";
}
echo "<tr><td bgcolor='$bgcolor2'><b>"._NE_ALLOWEDHTML.":</b></td><td>";
while(list($key,) = each($allowed_tags)) echo " &lt;".$key."&gt;";
echo "</td></tr>\n";
echo "<tr><td bgcolor='$bgcolor2' valign='top'><b>"._NE_LEADTEXT."</b></td>\n";
echo "<td><textarea wrap='virtual' cols='75' rows='15' name='hometext'>".str_replace("<br>", "\n", $story)."</textarea></td></tr>\n";
echo "<tr><td bgcolor='$bgcolor2' valign='top'><b>"._NE_BODYTEXT."</b></td>\n";
echo "<td><textarea wrap='virtual' cols='75' rows='15' name='bodytext'>".str_replace("<br>", "\n", $storyext)."</textarea></td></tr>\n";
echo "<tr><td bgcolor='$bgcolor2' valign='top'><b>"._NE_NOTES."</b></td>\n";
echo "<td><textarea wrap='virtual' cols='75' rows='15' name='notes'></textarea></td></tr>\n";
echo "<input type='hidden' NAME='qid' value='$qid'>\n";
echo "<input type='hidden' NAME='uid' value='$uid'>\n";
echo "<tr><td bgcolor='$bgcolor2'><b>"._NE_PROGRAMSTORY."</b></td><td>";
echo "<input type='radio' name='automated' value='1'>"._NE_YES." &nbsp;&nbsp;";
echo "<input type='radio' name='automated' value='0' checked>"._NE_NO."</td></tr>\n";
echo "<tr><td bgcolor='$bgcolor2'><b>"._NE_THEDATEIS.":</b></td><td>$date</td></tr>\n";
$day = 1;
echo "<tr><td bgcolor='$bgcolor2'><b>"._NE_STARTDATE.":</b></td><td>";
echo ""._NE_DAY.": <select name='day'>\n";
while($day <= 31) {
  $sel = "";
  if($tday==$day) { $sel = "selected"; }
  echo "<option $sel>$day</option>\n";
  $day++;
}
echo "</select> "._NE_MONTH.": <select name='month'>\n";
$month = 1;
while($month <= 12) {
  $sel = "";
  if($ttmon==$month) { $sel = "selected"; }
  echo "<option $sel>$month</option>\n";
  $month++;
}
echo "</select> "._NE_YEAR.": <input type='text' name='year' value='$tyear' size='5' maxlength='4'>";
echo " "._NE_HOUR.": <select name='hour'>\n";
$hour = 0;
while($hour <= 23) {
  $dummy = $hour;
  if($hour < 10) { $hour = "0$hour"; }
  echo "<option>$hour</option>\n";
  $hour = $dummy;
  $hour++;
}
echo "</select> : <select name='min'>\n";
$min = 0;
while($min <= 59) {
  $dummy = $min;
  if($min < 10) { $min = "0$min"; }
  echo "<option>$min</option>\n";
  $min = $dummy;
  $min++;
}
echo "</select> : 00</td></tr>\n";
echo "<tr><td align='center' colspan='2'><select name='op'>\n";
echo "<option value='NESubmissionDelete'>"._NE_DELETESTORY."</option>\n";
echo "<option value='NESubmissionPreview' selected>"._NE_PREVIEWSUBMISSION."</option>\n";
echo "<option value='NESubmissionPost'>"._NE_POSTSUBMISSION."</option>\n";
echo "</select>\n";
echo "<input type='submit' value='"._NE_OK."'></td></tr>\n";
echo "</table>\n";
CloseTable();
if($neconfig['allow_polls'] == 1) {
  echo "<br />\n";
  OpenTable();
  echo "<center><font class='title'><b>"._NE_ATTACHAPOLL."</b></font><br />\n";
  echo "<font class='tiny'>"._NE_LEAVEBLANKTONOTATTACH."</font><br />\n";
  echo "<br /><br />"._NE_POLLTITLE.": <input type='text' name='pollTitle' size='50' maxlength='100' value=\"$pollTitle\"><br />\n<br />\n";
  echo "<font class='content'>"._NE_POLLEACHFIELD."<br />\n";
  echo "<table border='0'>\n";
  for($i = 1; $i <= 12; $i++) {
    echo "<tr><td>"._NE_OPTION." $i:</td><td><input type='text' name='optionText[$i]' size='50' maxlength='50' value=\"$optionText[$i]\"></td></tr>\n";
  }
  echo "</table>\n";
  CloseTable();
}
echo "</form>\n";
ne_copy();
include("footer.php");

?>