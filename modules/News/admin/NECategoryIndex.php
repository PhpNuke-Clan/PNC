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
NE_Admin(_NE_CATEGORIES." "._NE_ADMIN);
echo "<br />\n";
OpenTable();
$totalselected = $db->sql_numrows($db->sql_query("SELECT * FROM `".$prefix."_stories_cat`"));
if($totalselected == 0) {
  echo "<center class='title'><b>"._NE_NOCATEGORIES."</b></center>\n";
} else {
  nepagenums($op, $totalselected, $perpage, $max);
  echo "<table border='0' bgcolor='$bgcolor2' cellpadding='2' cellspacing='2' width='100%'>\n";
  echo "<tr>\n";
  echo "<td><b>&nbsp;"._NE_CATEGORY."&nbsp;</b></td>\n";
  echo "<td align='center'><b>&nbsp;"._NE_FUNCTIONS."&nbsp;</b></td>\n";
  echo "</tr>\n";
  $result = $db->sql_query("SELECT * FROM ".$prefix."_stories_cat order by title LIMIT $min, $perpage");
  while($cinfo = $db->sql_fetchrow($result)) {
    $cinfo['catid'] = intval($cinfo['catid']);
    $cinfo['title'] = stripslashes(ne_check_html(ne_convert_text($cinfo['title']), 0));
    echo "<tr bgcolor='$bgcolor1' onmouseover=\"this.style.backgroundColor='$bgcolor2'\" onmouseout=\"this.style.backgroundColor='$bgcolor1'\">\n";
    echo "<td width='100%'>&nbsp;".$cinfo['title']."&nbsp;</td>\n";
    echo "<td align='center'>&nbsp;";
    echo "<a href='".$admin_file.".php?op=NECategoryEdit&amp;catid=".$cinfo['catid']."'><img src='modules/$modname/images/edit.png' border='0' height='16' width='16' alt='"._NE_EDIT." "._NE_CATEGORY."' title='"._NE_EDIT." "._NE_CATEGORY."'></a>";
    echo "&nbsp;<a href='".$admin_file.".php?op=NECategoryDelete&amp;catid=".$cinfo['catid']."'><img src='modules/$modname/images/delete.png' border='0' height='16' width='16' alt='"._NE_DELETE." "._NE_CATEGORY."' title='"._NE_DELETE." "._NE_CATEGORY."'></a>";
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