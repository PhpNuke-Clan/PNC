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
if(!isset($min)) $min=0;
if(!isset($max)) $max=$min+$perpage;
NE_Admin(_NE_STORY." "._NE_ADMIN);
echo "<br />\n";
OpenTable();
$result = $db->sql_query("SELECT * FROM `".$prefix."_stories`");
$totalselected = $db->sql_numrows($result);
$db->sql_freeresult($result);
if($totalselected == 0) {
  echo "<center class='title'><b>"._NE_NOSTORIES."</b></center>\n";
} else {
  nepagenums($op, $totalselected, $perpage, $max);
  echo "<table border='0' bgcolor='$bgcolor2' cellpadding='2' cellspacing='2' width='100%'>\n";
  echo "<tr>\n";
  echo "<td><b>&nbsp;"._NE_STORY."&nbsp;</b></td>\n";
  if($multilingual == 1) { echo "<td align='center'><b>&nbsp;"._NE_LANGUAGE."&nbsp;</b></td>\n"; }
  echo "<td align='center'><b>&nbsp;"._NE_AUTHOR."&nbsp;</b></td>\n";
  echo "<td align='center'><b>&nbsp;"._NE_INFORMANT."&nbsp;</b></td>\n";
  echo "<td align='center'><b>&nbsp;"._NE_DATE."&nbsp;</b></td>\n";
  echo "<td align='center'><b>&nbsp;"._NE_FUNCTIONS."&nbsp;</b></td>\n";
  echo "</tr>\n";
  $result = $db->sql_query("SELECT * FROM ".$prefix."_stories ORDER BY time DESC LIMIT $min, $perpage");
  while($sinfo = $db->sql_fetchrow($result)) {
    $sinfo['sid'] = intval($sinfo['sid']);
    $sinfo['aid'] = trim($sinfo['aid']);
    $sinfo['title'] = stripslashes(ne_check_html(ne_convert_text($sinfo['title']), 0));
    echo "<tr bgcolor='$bgcolor1' onmouseover=\"this.style.backgroundColor='$bgcolor2'\" onmouseout=\"this.style.backgroundColor='$bgcolor1'\">\n";
    if(empty($sinfo['title'])) { $sinfo['title'] = _NE_NOSUBJECT; }
    echo "<td width='100%'>&nbsp;".$sinfo['title']."</td>\n";
    if($multilingual == 1) {
      if(empty($alanguage)) { $alanguage = _NE_ALL; }
      echo "<td align='center'>&nbsp;$alanguage&nbsp;</td>\n";
    }
    echo "<td align='center' nowrap>&nbsp;".$sinfo['aid']."&nbsp;</td>\n";
    echo "<td align='center' nowrap>&nbsp;".$sinfo['informant']."&nbsp;</td>\n";
    $timestamp = explode(" ", $sinfo['time']);
    echo "<td align='right' nowrap>&nbsp;$timestamp[0]&nbsp;</td>\n";
    echo "<td align='center'>&nbsp;";
    if(($radminarticle == 1 AND strtolower($sinfo['aid']) == strtolower($aid)) OR $radminsuper == 1) {
      echo "<a href='".$admin_file.".php?op=NEStoryEdit&amp;sid=".$sinfo['sid']."'><img src='modules/$modname/images/edit.png' border='0' height='16' width='16' alt='"._NE_EDIT." "._NE_STORY."' title='"._NE_EDIT." "._NE_STORY."'></a>";
      echo "&nbsp;<a href='".$admin_file.".php?op=NEStoryDelete&amp;sid=".$sinfo['sid']."'><img src='modules/$modname/images/delete.png' border='0' height='16' width='16' alt='"._NE_DELETE." "._NE_STORY."' title='"._NE_DELETE." "._NE_STORY."'></a>";
    } else {
      echo "<img src='modules/$modname/images/blank.png' border='0' height='16' width='16' alt='' title=''></a>";
      echo "&nbsp;<img src='modules/$modname/images/blank.png' border='0' height='16' width='16' alt='' title=''></a>";
    }
    echo "&nbsp;</td>\n";
    echo "</tr>\n";
  }
  $db->sql_freeresult($result);
  echo "</table>\n";
  nepagenums($op, $totalselected, $perpage, $max);
}
CloseTable();
ne_copy();
include("footer.php");

?>