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
NE_Admin(_NE_COMMENTS." "._NE_ADMIN);
echo "<br />\n";
OpenTable();
$totalselected = $db->sql_numrows($db->sql_query("SELECT * FROM `".$prefix."_comments`"));
if($totalselected == 0) {
  echo "<center class='title'><b>"._NE_NOCOMMENTS."</b></center>\n";
} else {
  nepagenums($op, $totalselected, $perpage, $max);
  echo "<table border='0' bgcolor='$bgcolor2' cellpadding='2' cellspacing='2' width='100%'>\n";
  echo "<tr>\n";
  echo "<td><b>&nbsp;"._NE_COMMENT."&nbsp;</b></td>\n";
  echo "<td align='center'><b>&nbsp;"._NE_REPLIES."&nbsp;</b></td>\n";
  echo "<td align='center'><b>&nbsp;"._NE_AUTHOR."&nbsp;</b></td>\n";
  echo "<td align='center'><b>&nbsp;"._NE_DATE."&nbsp;</b></td>\n";
  echo "<td align='center'><b>&nbsp;"._NE_FUNCTIONS."&nbsp;</b></td>\n";
  echo "</tr>\n";
  $result = $db->sql_query("SELECT * FROM `".$prefix."_comments` ORDER BY `date` DESC LIMIT $min, $perpage");
  while($cinfo = $db->sql_fetchrow($result)) {
    $cinfo['tid'] = intval($cinfo['tid']);
    $cinfo['sid'] = intval($cinfo['sid']);
    $cinfo['name'] = stripslashes(ne_check_html(ne_convert_text($cinfo['name']), 0));
    $cinfo['subject'] = stripslashes(ne_check_html(ne_convert_text($cinfo['subject']), 0));
    echo "<tr bgcolor='$bgcolor1' onmouseover=\"this.style.backgroundColor='$bgcolor2'\" onmouseout=\"this.style.backgroundColor='$bgcolor1'\">\n";
    if(empty($cinfo['subject'])) { $cinfo['subject'] = _NE_NOSUBJECT; }
    echo "<td width='100%'>&nbsp;".$cinfo['subject']."</td>\n";

    $replies = $db->sql_numrows($db->sql_query("SELECT * FROM `".$prefix."_comments` WHERE `pid`='".$cinfo['tid']."'"));
    echo "<td align='center' nowrap>&nbsp;$replies&nbsp;</td>\n";

    $cinfo['name'] = "<a href='modules.php?name=Your_Account&amp;op=userinfo&amp;username=".$cinfo['name']."' target='_blank'>".$cinfo['name']."</a>";
    echo "<td align='center' nowrap>&nbsp;".$cinfo['name']."&nbsp;</td>\n";
    $timestamp = explode(" ", $cinfo['date']);
    echo "<td align='right' nowrap>&nbsp;$timestamp[0]&nbsp;</td>\n";
    echo "<td align='center'>&nbsp;";
    if($radminarticle == 1 OR $radminsuper == 1) {
      echo "<a href='".$admin_file.".php?op=NECommentEdit&amp;tid=".$cinfo['tid']."'><img src='modules/$modname/images/edit.png' border='0' height='16' width='16' alt='"._NE_EDIT." "._NE_COMMENT."' title='"._NE_EDIT." "._NE_COMMENT."'></a>";
      echo "&nbsp;<a href='".$admin_file.".php?op=NECommentDelete&amp;tid=".$cinfo['tid']."&amp;sid=".$cinfo['sid']."'><img src='modules/$modname/images/delete.png' border='0' height='16' width='16' alt='"._NE_DELETE." "._NE_COMMENT."' title='"._NE_DELETE." "._NE_COMMENT."'></a>";
    } else {
      echo "<img src='modules/$modname/images/blank.png' border='0' height='16' width='16' alt='' title=''>";
      echo "&nbsp;<img src='modules/$modname/images/blank.png' border='0' height='16' width='16' alt='' title=''>";
    }
    echo "&nbsp;</td>\n";
    echo "</tr>\n";
  }
  echo "</table>\n";
  nepagenums($op, $totalselected, $perpage, $max);
  $db->sql_freeresult($result);
}
CloseTable();
ne_copy();
include("footer.php");

?>