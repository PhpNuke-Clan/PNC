<?php

/********************************************************/
/* Hall of Shame                                     	*/
/* By: Troy Moore (Duck@mrc.clanservers.com)			*/
/* http://mrc.clanservers.com                           */
/* Copyright © 2006-2011 by JesStep Enterprises         */
/********************************************************/
/* Hall of Shame                                        */
/* For PHP-Nuke 6.5+                                    */
/* By Troy Moore - http://mrc.clanservers.com        	*/
/********************************************************/


if ( !defined('ADMIN_FILE') ) {
	die("Illegal Admin File Access");
}


$pagetitle = " - "._HoS_HALLOFSHAME.": "._HoS_CATEGORYLIST;
@include("header.php");
$pperpage = $hos_config['pperpage'];
adminheader(_HoS_HALLOFSHAME.": "._HoS_CATEGORYLIST);
echo "<br>\n";
OpenTable();
$total = $db->sql_numrows($db->sql_query("SELECT * from ".$prefix."_hos_reasons WHERE rpid='0' ORDER BY title"));
if ($total>$pperpage) {
  $pages=ceil($total/$pperpage);
  if ($page > $pages) { $page = $pages; }
  if (!$page) { $page=1; }
  $offset=($page-1)*$pperpage;
} else {
  $offset=0;
  $pages=1;
  $page=1;
}
$result = $db->sql_query("SELECT * from ".$prefix."_hos_reasons WHERE rpid='0' ORDER BY title LIMIT $offset, $pperpage");
if($db->sql_numrows($result) > 0) {
  echo "<table align='center' border='0' cellpadding='2' cellspacing='2' width='50%'>\n";
  echo "<tr><th align='left' width='50%'><b>"._HoS_TITLE."</b></th><th align='right' width='50%'><b>"._HoS_FUNCTIONS."<b></th></tr>\n";
  echo "<tr><td colspan='2'></td></tr>\n";
  echo "<tr><td colspan='2'></td></tr>\n";
  while($resinfo = $db->sql_fetchrow($result)) {
    echo "<tr bgcolor='$bgcolor1'>\n";
    echo "<td align='left' width='50%'>".stripslashes($resinfo['title'])."</td>\n";
    echo "<form action='".$admin_file.".php' method='POST'>\n";
    echo "<input type='hidden' name='rid' value='".$resinfo['rid']."'>\n";
    echo "<td align='right' width='50%'><select name='op'>\n";
    echo "<option value='HoSReasonCat_Edit'>"._HoS_EDIT."</option>\n";
    echo "<option value='HoSReasonCat_Delete'>"._HoS_DELETE."</option>\n";
    echo "</select> <input type='submit' value='"._HoS_GO."'></td>\n";
    echo "</form>\n";
    echo "</tr>\n";
  }
echo "<tr><td colspan='2'></td></tr>\n";
echo "<tr><td colspan='2'></td></tr>\n";
  if ($pages > 1) {
    $pcnt=1;
    echo "<tr><td colspan='2'>\n";
    echo "<table cellpadding='0' cellspacing='0' border='0' width='100%'><tr>\n";
    if ($page > 1) { $dis_prev = ""; } else { $dis_prev = " disabled"; }
    echo "<form action='".$admin_file.".php?op=HoSReasonCat_List' method='post'>\n";
    echo "<input type='hidden' name='page' value='".($page-1)."'>\n";
    echo "<td align='left' width='20%'><input type='submit' value='"._HoS_PREVPAGE."'$dis_prev>&nbsp;</td>\n";
    echo "</form>\n";

    echo "<form action='".$admin_file.".php?op=HoSReasonCat_List' method='post'>\n";
    echo "<td align='center'><b>&nbsp;"._HoS_PAGE."&nbsp;</b><select name='page'>\n";
    while($pcnt <= $pages) {
      if($page == $pcnt) { $pag_sele = " selected"; } else { $pag_sele = ""; }
      echo " <option value='$pcnt'$pag_sele>$pcnt</option>\n";
      $pcnt++;
    }
    echo "</select><b>&nbsp;"._HoS_OF."&nbsp;$pages&nbsp;"._HoS_PAGES."&nbsp;</b><input type='submit' value='"._HoS_GO."'>&nbsp;</td>\n";
    echo "</form>\n";

    if ($page < $pages) { $dis_next = ""; } else { $dis_next = " disabled"; }
    echo "<form action='".$admin_file.".php?op=HoSReasonCat_List' method='post'>\n";
    echo "<input type='hidden' name='page' value='".($page+1)."'>\n";
    echo "<td align='right' width='20%'>&nbsp;<input type='submit' value='"._HoS_NEXTPAGE."'$dis_next></td>\n";
    echo "</form>\n";
    echo "</tr></table>\n";
    echo "</td></tr>\n";
  }

  echo "</table>\n";
} else {
  echo "<center class='title'>"._HoS_NOCATEGORIESINDATABASE."</center>";
}
CloseTable();
@include("footer.php");

?>