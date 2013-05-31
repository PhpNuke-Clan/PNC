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
if($topic<1) { $topic = 1; }
NE_Admin(_NE_STORY." "._NE_ADMIN.": "._NE_STORYPREVIEW);
echo "<br />\n";
$tday = date("d");
$tmonth = date("F");
$ttmon = date("m");
$tyear = date("Y");
$thour = date("H");
$tmin = date("i");
$tsec = date("s");
$date = "$tmonth $tday, $tyear @ $thour:$tmin:$tsec";
$subject = stripslashes(ne_check_html(ne_convert_text($subject), 0));
$hometext = stripslashes(ne_check_html(ne_convert_text($hometext), 1));
$bodytext = stripslashes(ne_check_html(ne_convert_text($bodytext), 1));
$thetext = $hometext;
if(!empty($bodytext)) { $thetext = $thetext."<br /><br />".$bodytext; }
$thetext = stripslashes($thetext);
$datetime = date("D M d, Y g:i a");
OpenTable();
$result = $db->sql_query("SELECT * FROM `".$prefix."_topics` WHERE `topicid`='$topic'");
$tinfo = $db->sql_fetchrow($result);
$db->sql_freeresult($result);
$tinfo['topicname'] = ne_check_html(ne_convert_text($tinfo['topicname']), 0);
$tinfo['topicimage'] = ne_check_html(ne_convert_text($tinfo['topicimage']), 0);
$tinfo['topictext'] = ne_check_html(ne_convert_text($tinfo['topictext']), 0);
themeindex($aid, $aid, $datetime, $subject, 0, $topic, $thetext, $notes, $morelink, $tinfo['topicname'], $tinfo['topicimage'], $tinfo['topictext']);
echo "<br />\n";
echo "<form action='".$admin_file.".php' method='post'>\n";
echo "<table align='center' border='0' cellpadding='2' cellspacing='2'>\n";
echo "<input type='hidden' name='catid' value='$catid'>\n";
echo "<tr><td bgcolor='$bgcolor2'><b>"._NE_TITLE.":</b></td>\n";
echo "<td><input type='text' name='subject' size='50' value=\"$subject\"></td></tr>\n";
echo "<tr><td bgcolor='$bgcolor2'><b>"._NE_TOPIC.":</b></td><td><select name='topic'>\n";
$toplist = $db->sql_query("select topicid, topictext from ".$prefix."_topics order by topictext");
echo "<option value=''>"._NE_ALLTOPICS."</option>\n";
while(list($topicid, $topics) = $db->sql_fetchrow($toplist)) {
  $topicid = intval($topicid);
  if($topicid==$topic) { $sel = "selected "; }
  echo "<option $sel value='$topicid'>$topics</option>\n";
  $sel = "";
}
echo "</select></td></tr>\n";
//for($i=0; $i<sizeof($assotop); $i++) { $associated .= "$assotop[$i]-"; }
if(is_array($assotop)) {
  $associated = implode("-", $assotop);
} else {
  $associated = $assotop;
}
$asso_t = explode("-", $associated);
echo "<tr><td bgcolor='$bgcolor2' valign='top'><b>"._ASSOTOPIC.":</b></td><td><select name='assotop[]' size='5' multiple>\n";
$result = $db->sql_query("SELECT `topicid`, `topictext` FROM `".$prefix."_topics` ORDER BY `topictext`");
while($row = $db->sql_fetchrow($result)) {
  $row['topicid'] = intval($row['topicid']);
  $row['topictext'] = ne_check_html(ne_convert_text($row['topictext']), 0);
  if(in_array($row['topicid'], $asso_t)) { $sel = " selected"; }
  echo "<option value='".$row['topicid']."'$sel>".$row['topictext']."</option>\n";
  $sel = "";
}
echo "</select>\n</td></tr>\n";
$db->sql_freeresult($result);
$cat = $catid;
$selcat = $db->sql_query("select catid, title from ".$prefix."_stories_cat order by title");
$a = 1;
echo "<tr><td bgcolor='$bgcolor2'><b>"._NE_CATEGORY.":</b></td><td><select name='catid'>\n";
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
echo "<input type='radio' name='ihome' value='1' $sel2>"._NE_NO."<br />\n";
echo "&nbsp;&nbsp;<span class='content'>[ "._NE_ONLYIFCATSELECTED." ]</span></td></tr>\n";
echo "<tr><td bgcolor='$bgcolor2'><b>"._NE_ACTIVATECOMMENTS."</b></td><td>";
$sel1 = $sel2 = "";
if(($acomm == 0) OR ($acomm == "")) { $sel1 = "checked"; }
if($acomm == 1) { $sel2 = "checked"; }
echo "<input type='radio' name='acomm' value='0' $sel1>"._NE_YES."&nbsp;";
echo "<input type='radio' name='acomm' value='1' $sel2>"._NE_NO."</font></td></tr>\n";
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
  if($alanguage == "") { $sellang = "selected"; } else { $sellang = ""; }
  echo "<option value='' $sellang>"._NE_ALL."</option></select></td></tr>\n";
} else {
  echo "<input type='hidden' name='alanguage' value='$language'>\n";
}
echo "<tr><td bgcolor='$bgcolor2'><b>"._NE_ALLOWEDHTML.":</b></td><td>";
while(list($key,) = each($allowed_tags)) echo " &lt;".$key."&gt;";
echo "</td></tr>\n";
echo "<tr><td bgcolor='$bgcolor2' valign='top'><b>"._NE_LEADTEXT.":</b></td>\n";
echo "<td><textarea wrap='virtual' cols='75' rows='15' name='hometext'>".str_replace("<br>", "\n", $hometext)."</textarea></td></tr>\n";
echo "<tr><td bgcolor='$bgcolor2' valign='top'><b>"._NE_BODYTEXT.":</b></td>\n";
echo "<td><textarea wrap='virtual' cols='75' rows='15' name='bodytext'>".str_replace("<br>", "\n", $bodytext)."</textarea></td></tr>\n";
$sel1 = $sel2 = "";
if($automated == 1) { $sel1 = "checked"; } else { $sel2 = "checked"; }
echo "<tr><td bgcolor='$bgcolor2'><b>"._NE_PROGRAMSTORY."</b></td><td>";
echo "<input type='radio' name='automated' value='1' $sel1>"._NE_YES." &nbsp;&nbsp;";
echo "<input type='radio' name='automated' value='0' $sel2>"._NE_NO."</td></tr>\n";
echo "<tr><td bgcolor='$bgcolor2'><b>"._NE_THEDATEIS.":</b></td><td>$date</td></tr>\n";
echo "<tr><td bgcolor='$bgcolor2'><b>"._NE_STARTDATE.":</b></td><td>";
$xday = 1;
echo ""._NE_DAY.": <select name='day'>\n";
while($xday <= 31) {
  $sel = "";
  if($xday == $day) { $sel = "selected"; }
  echo "<option $sel>$xday</option>\n";
  $xday++;
}
echo "</select> "._NE_MONTH.": <select name='month'>\n";
$xmonth = 1;
while($xmonth <= 12) {
  $sel = "";
  if($xmonth == $month) { $sel = "selected"; }
  echo "<option $sel>$xmonth</option>\n";
  $xmonth++;
}
echo "</select> "._NE_YEAR.": <input type='text' name='year' value='$year' size='5' maxlength='4'>";
echo " "._NE_HOUR.": <select name='hour'>\n";
$xhour = 0;
while($xhour <= 23) {
  $dummy = $xhour;
  if($xhour < 10) { $xhour = "0$xhour"; }
  $sel = "";
  if($xhour == $hour) { $sel = "selected"; }
  echo "<option $sel>$xhour</option>\n";
  $xhour = $dummy;
  $xhour++;
}
echo "</select> : <select name='min'>\n";
$xmin = 0;
while($xmin <= 59) {
  $dummy = $xmin;
  if($xmin < 10) { $xmin = "0$xmin"; }
  $sel = "";
  if($xmin == $min) { $sel = "selected"; }
  echo "<option $sel>$xmin</option>\n";
  $xmin = $dummy;
  $xmin++;
}
echo "</select> : 00</td></tr>\n";
echo "<tr><td align='center' colspan='2'><select name='op'>\n";
echo "<option value='NEStoryPreview' selected>"._NE_PREVIEWSTORY."</option>\n";
echo "<option value='NEStoryPost'>"._NE_POSTSTORY."</option>\n";
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