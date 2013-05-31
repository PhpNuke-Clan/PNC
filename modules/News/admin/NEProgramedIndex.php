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
NE_Admin(_NE_PROGRAMED." "._NE_ADMIN);
echo "<br />\n";
OpenTable();
$result = $db->sql_query("SELECT * FROM `".$prefix."_autonews`");
$totalselected = $db->sql_numrows($result);
$db->sql_freeresult($result);
if($totalselected == 0) {
  echo "<center class='title'><b>"._NE_NOPROGRAMED."</b></center>\n";
} else {
  nepagenums($op, $totalselected, $perpage, $max);
  echo "<table border='0' bgcolor='$bgcolor2' cellpadding='2' cellspacing='2' width='100%'>\n";
  echo "<tr>\n";
  echo "<td><b>&nbsp;"._NE_PROGRAMED."&nbsp;</b></td>\n";
  if($multilingual == 1) { echo "<td align='center'><b>&nbsp;"._NE_LANGUAGE."&nbsp;</b></td>\n"; }
  echo "<td align='center'><b>&nbsp;"._NE_AUTHOR."&nbsp;</b></td>\n";
  echo "<td align='center'><b>&nbsp;"._NE_INFORMANT."&nbsp;</b></td>\n";
  echo "<td align='center'><b>&nbsp;"._NE_DATE."&nbsp;</b></td>\n";
  echo "<td align='center'><b>&nbsp;"._NE_FUNCTIONS."&nbsp;</b></td>\n";
  echo "</tr>\n";
  $result = $db->sql_query("SELECT * FROM `".$prefix."_autonews` ORDER BY `time` DESC LIMIT $min, $perpage");
  while($pinfo = $db->sql_fetchrow($result)) {
    $pinfo['anid'] = intval($pinfo['anid']);
    $pinfo['title'] = stripslashes(ne_check_html(ne_convert_text($pinfo['title']), 0));
    $pinfo['aid'] = stripslashes(ne_check_html(ne_convert_text($pinfo['aid']), 0));
    $pinfo['informant'] = stripslashes(ne_check_html(ne_convert_text($pinfo['informant']), 0));
    echo "<tr bgcolor='$bgcolor1' onmouseover=\"this.style.backgroundColor='$bgcolor2'\" onmouseout=\"this.style.backgroundColor='$bgcolor1'\">\n";
    if(empty($pinfo['title'])) { $pinfo['title'] = _NE_NOSUBJECT; }
    echo "<td width='100%'>&nbsp;<a href='".$admin_file.".php?op=NEProgramedEdit&amp;anid=".$pinfo['anid']."'>".$pinfo['title']."</a></td>\n";
    if($multilingual == 1) {
      if(empty($pinfo['alanguage'])) { $pinfo['alanguage'] = _NE_ALL; }
      echo "<td align='center'>&nbsp;".$pinfo['alanguage']."&nbsp;</td>\n";
    }
    echo "<td align='center' nowrap>&nbsp;".$pinfo['aid']."&nbsp;</td>\n";
    echo "<td align='center' nowrap>&nbsp;".$pinfo['informant']."&nbsp;</td>\n";
    $timestamp = explode(" ", $pinfo['time']);
    echo "<td align='right' nowrap>&nbsp;$timestamp[0]&nbsp;</td>\n";
    echo "<td align='center'>&nbsp;";
    if(($radminarticle == 1 AND strtolower($pinfo['aid']) == strtolower($aid)) OR $radminsuper == 1) {
      echo "<a href='".$admin_file.".php?op=NEProgramedEdit&amp;anid=".$pinfo['anid']."'><img src='modules/$modname/images/edit.png' border='0' height='16' width='16' alt='"._NE_EDIT." "._NE_PROGRAMED."' title='"._NE_EDIT." "._NE_PROGRAMED."'></a>";
      echo "&nbsp;<a href='".$admin_file.".php?op=NEProgramedDelete&amp;anid=".$pinfo['anid']."'><img src='modules/$modname/images/delete.png' border='0' height='16' width='16' alt='"._NE_DELETE." "._NE_PROGRAMED."' title='"._NE_DELETE." "._NE_PROGRAMED."'></a>";
    } else {
      echo "<img src='modules/$modname/images/blank.png' border='0' height='16' width='16' alt='' title=''>";
      echo "&nbsp;<img src='modules/$modname/images/blank.png' border='0' height='16' width='16' alt='' title=''>";
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