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
$sid = intval($sid);
list($aaid) = $db->sql_fetchrow($db->sql_query("SELECT `aid` FROM `".$prefix."_stories` WHERE `sid`='$sid'"));
$aaid = substr("$aaid", 0,25);
include("header.php");
NE_Admin(_NE_STORY." "._NE_ADMIN.": "._NE_STORYEDIT);
echo "<br />\n";
if(($radminarticle == 1) AND ($aaid == $aid) OR ($radminsuper == 1)) {
  $result = $db->sql_query("SELECT * FROM `".$prefix."_stories` WHERE `sid`='$sid'");
  $row = $db->sql_fetchrow($result);
  $db->sql_freeresult($result);
  $catid = intval($row['catid']);
  $title = stripslashes(ne_check_html(ne_convert_text($row['title']), 0));
  $hometext = stripslashes(ne_check_html(ne_convert_text($row['hometext']), 1));
  $bodytext = stripslashes(ne_check_html(ne_convert_text($row['bodytext']), 1));
  $notes = stripslashes(ne_check_html(ne_convert_text($row['notes']), 1));
  $informant = stripslashes(ne_check_html(ne_convert_text($row['informant']), 0));
  $alanguage = $row['alanguage'];
  $associated = $row['associated'];
  $ihome = intval($row['ihome']);
  $acomm = intval($row['acomm']);
  $topic = intval($row['topic']);
  $thetext = $hometext;
  if(!empty($bodytext)) { $thetext = $thetext."<br /><br />".$bodytext; }
  $thetext = stripslashes($thetext);
  $timedate = date("D M d, Y g:i a");
  $result=$db->sql_query("SELECT * FROM `".$prefix."_topics` WHERE `topicid`='$topic'");
  $tinfo = $db->sql_fetchrow($result);
  $db->sql_freeresult($result);
  $tinfo['topicname'] = ne_check_html(ne_convert_text($tinfo['topicname']), 0);
  $tinfo['topicimage'] = ne_check_html(ne_convert_text($tinfo['topicimage']), 0);
  $tinfo['topictext'] = ne_check_html(ne_convert_text($tinfo['topictext']), 0);
  OpenTable();
  themeindex($aid, $informant, $timedate, $title, 0, $topic, $thetext, $notes, $morelink, $tinfo['topicname'], $tinfo['topicimage'], $tinfo['topictext']);
  echo "<table align='center' border='0' cellpadding='2' cellspacing='2'>\n";
  echo "<form action='".$admin_file.".php' method='post'>\n";
  echo "<tr><td bgcolor='$bgcolor2'><b>"._NE_TITLE.":</b></td>\n";
  echo "<td><input type='text' name='title' size='50' value=\"$title\"></td></tr>\n";
  echo "<tr><td bgcolor='$bgcolor2'><b>"._TOPIC.":</b></td><td><select name='topic'>\n";
  $toplist = $db->sql_query("SELECT `topicid`, `topictext` FROM `".$prefix."_topics` ORDER BY `topictext`");
  echo "<option value=''>"._NE_ALLTOPICS."</option>\n";
  while(list($topicid, $topics) = $db->sql_fetchrow($toplist)) {
    $topicid = intval($topicid);
    $topictext = ne_check_html(ne_convert_text($topictext), 0);
    if($topicid==$topic) { $sel = "selected "; }
    echo "<option $sel value='$topicid'>$topics</option>\n";
    $sel = "";
  }
  echo "</select></td></tr>\n";
  $db->sql_freeresult($toplist);
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
  $selcat = $db->sql_query("SELECT `catid`, `title` FROM `".$prefix."_stories_cat` ORDER BY `title`");
  $a = 1;
  echo "<tr><td bgcolor='$bgcolor2'><b>"._NE_CATEGORY.":</b></td><td><select name='catid'>\n";
  $sel = "";
  if($cat == 0) { $sel = "selected"; }
  echo "<option name='catid' value='0' $sel>"._NE_ARTICLES."</option>\n";
  while(list($catid, $title) = $db->sql_fetchrow($selcat)) {
    $catid = intval($catid);
    $title = ne_check_html(ne_convert_text($title), 0);
    $sel = "";
    if($catid == $cat) { $sel = "selected"; }
    echo "<option name='catid' value='$catid' $sel>$title</option>\n";
    $a++;
  }
  echo "</select></td></tr>\n";
  $db->sql_freeresult($selcat);
  echo "<tr><td bgcolor='$bgcolor2'><b>"._NE_PUBLISHINHOME."</b></td><td>";
  $sel1 = $sel2 = "";
  if(($ihome == 0) OR ($ihome == "")) { $sel1 = "checked"; }
  if($ihome == 1) { $sel2 = "checked"; }
  echo "<input type='radio' name='ihome' value='0' $sel1>"._NE_YES."&nbsp;";
  echo "<input type='radio' name='ihome' value='1' $sel2>"._NE_NO."<br />";
  echo "<span class='content'>[ "._NE_ONLYIFCATSELECTED." ]</span></td></tr>\n";
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
        echo "<option name='alanguage' value='$languageslist[$i]' ";
        if($languageslist[$i]==$alanguage) echo "selected";
        echo ">".ucfirst($languageslist[$i])."\n</option>\n";
      }
    }
    if($alanguage == "") { $sellang = "selected"; } else { $sellang = ""; }
    echo "<option value='' $sellang>"._NE_ALL."</option></select></td></tr>\n";
  } else {
    echo "<input type='hidden' name='alanguage' value=''>\n";
  }
  echo "<tr><td bgcolor='$bgcolor2'><b>"._NE_ALLOWEDHTML.":</b></td><td>";
  while(list($key,) = each($allowed_tags)) echo " &lt;".$key."&gt;";
  echo "</td></tr>\n";
  echo "<tr><td bgcolor='$bgcolor2' valign='top'><b>"._NE_LEADTEXT.":</b></td>\n";
  echo "<td><textarea wrap='virtual' cols='75' rows='15' name='hometext'>".str_replace("<br>", "\n", $hometext)."</textarea></td></tr>\n";
  echo "<tr><td bgcolor='$bgcolor2' valign='top'><b>"._NE_BODYTEXT.":</b></td>\n";
  echo "<td><textarea wrap='virtual' cols='75' rows='15' name='bodytext'>".str_replace("<br>", "\n", $bodytext)."</textarea></td></tr>\n";
  if($informant != $aaid) {
    echo "<tr><td bgcolor='$bgcolor2' valign='top'><b>"._NE_NOTES.":</b></td>\n";
    echo "<td><textarea wrap='virtual' cols='75' rows='15' name='notes'>".str_replace("<br>", "\n", $notes)."</textarea></td></tr>\n";
  }
  echo "<input type='hidden' NAME='sid' size='50' value='$sid'>\n";
  echo "<input type='hidden' name='op' value='NEStoryEditSave'>\n";
  echo "<tr><td align='center' colspan='2'><input type='submit' value='"._NE_SAVECHANGES."'></td></tr>\n";
  echo "</form>\n";
  echo "</table>\n";
  CloseTable();
} else {
  OpenTable();
  echo "<center class='title'><b>"._NE_NOTAUTHORIZED."</b></center><br />\n";
  CloseTable();
}
ne_copy();
include("footer.php");

?>