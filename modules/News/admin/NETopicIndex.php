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
NE_Admin(_NE_TOPICS." "._NE_ADMIN);
echo "<br />\n";
OpenTable();
$totalselected = $db->sql_numrows($db->sql_query("SELECT * FROM `".$prefix."_topics`"));
if($totalselected == 0) {
  echo "<center class='title'><b>"._NE_NOTOPICS."</b></center>\n";
} else {
  nepagenums($op, $totalselected, $perpage, $max);
  echo "<table border='0' bgcolor='$bgcolor2' cellpadding='2' cellspacing='2' width='100%'>\n";
  echo "<tr>\n";
  echo "<td><b>&nbsp;</b></td>\n";
  echo "<td><b>&nbsp;"._NE_TOPIC."&nbsp;</b></td>\n";
  echo "<td align='center'><b>&nbsp;"._NE_FUNCTIONS."&nbsp;</b></td>\n";
  echo "</tr>\n";
  $result = $db->sql_query("SELECT * FROM `".$prefix."_topics` ORDER BY `topictext` LIMIT $min, $perpage");
  while($tinfo = $db->sql_fetchrow($result)) {
    $tinfo['topicid'] = intval($tinfo['topicid']);
    $tinfo['topictext'] = stripslashes(ne_check_html(ne_convert_text($tinfo['topictext']), 0));
    echo "<tr bgcolor='$bgcolor1' onmouseover=\"this.style.backgroundColor='$bgcolor2'\" onmouseout=\"this.style.backgroundColor='$bgcolor1'\">\n";
    echo "<td><img src='$tipath".$tinfo['topicimage']."' height='20' width='20'></td>\n";
    echo "<td width='100%'>&nbsp;".$tinfo['topictext']."&nbsp;</td>\n";
    echo "<td align='center'><nobr>&nbsp;";
    echo "<a href='".$admin_file.".php?op=NETopicEdit&amp;topicid=".$tinfo['topicid']."'><img src='modules/$modname/images/edit.png' border='0' height='16' width='16' alt='"._NE_EDIT." "._NE_TOPIC."' title='"._NE_EDIT." "._NE_TOPIC."'></a>";
    echo "&nbsp;<a href='".$admin_file.".php?op=NETopicDelete&amp;topicid=".$tinfo['topicid']."'><img src='modules/$modname/images/delete.png' border='0' height='16' width='16' alt='"._NE_DELETE." "._NE_TOPIC."' title='"._NE_DELETE." "._NE_TOPIC."'></a>";
    echo "&nbsp;</nobr></td>\n";
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