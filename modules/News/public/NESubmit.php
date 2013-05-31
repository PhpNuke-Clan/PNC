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
$pagetitle = ": "._NE_SUBMITNEWS;
include('header.php');
title(_NE_SUBMITNEWS);
OpenTable();
if($neconfig['anonymous_submit'] == 1 OR is_user($user)) {
  echo "<table align='center' border='0' cellpadding='2' cellspacing='2'>\n";
  echo "<tr><td align='center' colspan='2'><b>"._NE_SUBMITADVICE."</b></td></tr>\n";
  echo "<form action='$form_link' method='post'>\n";
  echo "<tr><td bgcolor='$bgcolor2'><b>"._NE_YOURNAME.":</b></td>\n";
  if(is_user($user)) {
    cookiedecode($user);
    echo "<td><a href='modules.php?name=Your_Account' target='_blank'>$cookie[1]</a>\n";
    echo " [ <a href='modules.php?name=Your_Account&amp;op=logout'>"._NE_LOGOUT."</a> ]</td></tr>\n";
    echo "<input type='hidden' name='author' value='$cookie[1]'>\n";
  } else {
    echo "<td>$anonymous [ <a href='modules.php?name=Your_Account'>"._NE_LOGIN."</a>\n";
    echo " | <a href='modules.php?name=Your_Account&amp;op=new_user'>"._NE_REGISTER."</a> ]</td></tr>\n";
    echo "<input type='hidden' name='author' value='$anonymous'>\n";
  }
  echo "<tr><td bgcolor='$bgcolor2'><b>"._NE_TITLE.":</b></td><td><input type='text' name='subject' size='50' maxlength='80'></td></tr>\n";
  echo "<tr><td bgcolor='$bgcolor2'><b>"._NE_TOPIC.":</b></td><td><select name='topic'>\n";
  $result = $db->sql_query("SELECT `topicid`, `topictext` FROM `".$prefix."_topics` ORDER BY `topictext`");
  echo "<option value=''>"._NE_SELECTTOPIC."</option>\n";
  while($row = $db->sql_fetchrow($result)) {
    $topicid = intval($row['topicid']);
    $topics = ne_check_html(ne_convert_text($row['topictext']), 0);
    if($topicid == $topic) { $sel = "selected "; }
    echo "<option $sel value='$topicid'>$topics</option>\n";
    $sel = "";
  }
  $db->sql_freeresult($result);
  echo "</select></td></tr>\n";
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
        if($languageslist[$i]==$currentlang) { $sellan = "selected"; }
        echo "<option value='$languageslist[$i]'$sellan>".ucfirst($languageslist[$i])."</option>\n";
        $sellan = "";
      }
    }
    echo "</select></td></tr>\n";
  } else {
    echo "<input type='hidden' name='alanguage' value='$language'>\n";
  }
  echo "<tr><td bgcolor='$bgcolor2'><b>"._NE_ALLOWEDHTML.":</b></td><td>";
  while(list($key,) = each($allowed_tags)) echo " &lt;".$key."&gt;";
  echo "</td></tr>\n";
  echo "<tr><td bgcolor='$bgcolor2' valign='top'><b>"._NE_LEADTEXT.":</b></td>\n";
  echo "<td><textarea cols='75' rows='15' name='story'></textarea><br>("._NE_HTMLISFINE.")</td></tr>\n";
  echo "<tr><td bgcolor='$bgcolor2' valign='top'><b>"._NE_BODYTEXT.":</b></td>\n";
  echo "<td><textarea cols='75' rows='15' name='storyext'></textarea><br>("._NE_INCLUDEURL.")</td></tr>\n";
  echo "<tr><td align='center' colspan='2'><select name='op'>\n";
  echo "<option value='NESubmitPreview' selected>"._NE_PREVIEWSUBMISSION."</option>\n";
  echo "</select>\n";
  echo "<input type='submit' value='"._NE_OK."'></td></tr>\n";
  echo "</form>\n";
  echo "</table>\n";
} else{
  echo "<center class='title'>"._NE_ONLYREGISTERED."</center>\n";
}
CloseTable();
include('footer.php');

?>