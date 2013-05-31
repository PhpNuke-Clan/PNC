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
NE_Admin(_NE_SUBMISSIONS." "._NE_ADMIN);
echo "<br />\n";
OpenTable();
$totalselected = $db->sql_numrows($db->sql_query("SELECT * FROM `".$prefix."_queue`"));
if($totalselected == 0) {
  echo "<center class='title'><b>"._NE_NOSUBMISSIONS."</b></center>\n";
} else {
  echo "<table border='0' bgcolor='$bgcolor2' cellpadding='2' cellspacing='2' width='100%'>\n";
  echo "<tr>\n";
  echo "<td><b>&nbsp;"._NE_SUBMISSION."&nbsp;</b></td>\n";
  if($multilingual == 1) { echo "<td align='center'><b>&nbsp;"._NE_LANGUAGE."&nbsp;</b></td>\n"; }
  echo "<td align='center'><b>&nbsp;"._NE_INFORMANT."&nbsp;</b></td>\n";
  echo "<td align='center'><b>&nbsp;"._NE_DATE."&nbsp;</b></td>\n";
  echo "<td align='center'><b>&nbsp;"._NE_FUNCTIONS."&nbsp;</b></td>\n";
  echo "</tr>\n";
  $result = $db->sql_query("SELECT * FROM `".$prefix."_queue` ORDER BY `timestamp` DESC LIMIT $min, $perpage");
  while($qinfo = $db->sql_fetchrow($result)) {
    $qinfo['qid'] = intval($qinfo['qid']);
    $qinfo['uid'] = intval($qinfo['uid']);
    $qinfo['subject'] = stripslashes(ne_check_html(ne_convert_text($qinfo['subject']), 0));
    $qinfo['uname'] = stripslashes(ne_check_html(ne_convert_text($qinfo['uname']), 0));
    echo "<tr bgcolor='$bgcolor1' onmouseover=\"this.style.backgroundColor='$bgcolor2'\" onmouseout=\"this.style.backgroundColor='$bgcolor1'\">\n";
    if($qinfo['subject'] == "") { $qinfo['subject'] = _NE_NOSUBJECT; }
    echo "<td width='100%'>&nbsp;".$qinfo['subject']."&nbsp;</td>\n";
    if($multilingual == 1) {
      if($qinfo['alanguage'] == "") { $qinfo['alanguage'] = _NE_ALL; }
      echo "<td align='center'>&nbsp;".$qinfo['alanguage']."&nbsp;</td>\n";
    }
    if($qinfo['uname'] != $anonymous) { $qinfo['uname'] = "<a href='modules.php?name=Your_Account&op=userinfo&username=".$qinfo['uname']."'>".$qinfo['uname']."</a>"; }
    echo "<td align='center' nowrap>&nbsp;".$qinfo['uname']."&nbsp;</td>\n";
    $timestamp = explode(" ", $qinfo['timestamp']);
    echo "<td align='center' nowrap>&nbsp;$timestamp[0]&nbsp;</td>\n";
    echo "<td align='center'>&nbsp;";
    echo "<a href='".$admin_file.".php?op=NESubmissionDisplay&amp;qid=".$qinfo['qid']."'><img src='modules/$modname/images/edit.png' border='0' height='16' width='16' alt='"._NE_EDIT." "._NE_SUBMISSION."' title='"._NE_EDIT." "._NE_SUBMISSION."'></a>";
    echo "&nbsp;<a href='".$admin_file.".php?op=NESubmissionDelete&amp;qid=".$qinfo['qid']."'><img src='modules/$modname/images/delete.png' border='0' height='16' width='16' alt='"._NE_DELETE." "._NE_SUBMISSION."' title='"._NE_DELETE." "._NE_SUBMISSION."'></a>";
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