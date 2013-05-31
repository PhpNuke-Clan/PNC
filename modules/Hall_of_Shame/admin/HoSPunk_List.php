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


$pagetitle = " - "._HoS_HALLOFSHAME.": "._HoS_PUNKLIST;
$sort = $hos_config['admsort'];
$sortasc = $hos_config['admsortasc'];
if(!isset($sort)) { $sort = "date_add"; }
if(!isset($sortasc)) { $sortasc = "DESC"; }
@include("header.php");
$pperpage = $hos_config['pperpage'];
adminheader(_HoS_HALLOFSHAME.": "._HoS_PUNKLIST);
$memid = stripslashes($hos_config['mid']);
$memtbl = stripslashes($hos_config['membertable']);
$memname = stripslashes($hos_config['membername']);
echo "<br>\n";
OpenTable();
$total = $db->sql_numrows($db->sql_query("SELECT * from ".$prefix."_hos_punks ORDER BY punkname"));
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
$result = $db->sql_query("SELECT * from ".$prefix."_hos_punks ORDER BY $sort $sortasc LIMIT $offset, $pperpage");
if($db->sql_numrows($result) > 0) {
  echo "<table border='0' cellpadding='2' cellspacing='2' width='100%'>\n";
  echo "  <tr bgcolor='$bgcolor2'>\n";
  echo "    <th align='left'><b>"._HoS_PUNK."</b></th>\n";
  echo "    <th align='center'><b>"._HoS_GUID."</b></th>\n";
  echo "    <th align='center'><b>"._HoS_REASON."</b></th>\n";
  echo "    <th align='center'><b>"._HoS_BANNEDBY."</b></th>\n";
  echo "    <th align='right'><b>"._HoS_FUNCTIONS."</b></th>\n";
  echo "  </tr>\n";
  echo "<tr><td colspan='5'></td></tr>\n";
  echo "<tr><td colspan='5'></td></tr>\n";
  while($punkinfo = $db->sql_fetchrow($result)) {
    $punkname = stripslashes($punkname);
    if ($punkinfo['punkreason'] == 0) {
      $reason_title = _HoS_NOTSET;
    } else {
      list($reason_title) = $db->sql_fetchrow($db->sql_query("SELECT title from ".$prefix."_hos_reasons where rid='".$punkinfo['punkreason']."'"));
      $reason_title = stripslashes($reason_title);
    }
    if ($punkinfo['punkbannedby'] == 0) {
      $bannedby_title = _HoS_NOTSET;
    } else {
      list($bannedby_title) = $db->sql_fetchrow($db->sql_query("SELECT $memname from $memtbl where $memid ='".$punkinfo['punkbannedby']."'"));
      $banned_title = stripslashes($bannedby_title);
    }
    $guid = $punkinfo['punkguid'];
    echo "<tr bgcolor='$bgcolor1'>\n";
    echo "<td align='left'>".$punkinfo['punkname']."</td>\n";
    echo "<td align='center'>$guid</td>\n";
    echo "<td align='center'>$reason_title</td>\n";
    echo "<td align='center'>$bannedby_title</td>\n";
    echo "<form action='".$admin_file.".php' method='POST'>\n";
    echo "<input type='hidden' name='pid' value='".$punkinfo['pid']."'>\n";
    echo "<td align='right'><select name='op'>\n";
    echo "<option value='HoSPunk_Edit'>"._HoS_EDIT."</option>\n";
    echo "<option value='HoSPunk_Delete'>"._HoS_DELETE."</option>\n";
    echo "</select> <input type='submit' value='"._HoS_GO."'></td>\n";
    echo "</form>\n";
    echo "</tr>\n";
  }
  echo "<tr><td colspan='5'></td></tr>\n";
  echo "<tr><td colspan='5'></td></tr>\n";

  if ($pages > 1) {
    $pcnt=1;
    echo "<tr><td colspan='5'>\n";
    echo "<table cellpadding='0' cellspacing='0' border='0' width='100%'><tr>\n";
    if ($page > 1) { $dis_prev = ""; } else { $dis_prev = " disabled"; }
    echo "<form action='".$admin_file.".php?op=HoSPunk_List' method='post'>\n";
    echo "<input type='hidden' name='page' value='".($page-1)."'>\n";
    echo "<td align='left' width='20%'><input type='submit' value='"._HoS_PREVPAGE."'$dis_prev>&nbsp;</td>\n";
    echo "</form>\n";

    echo "<form action='".$admin_file.".php?op=HoSPunk_List' method='post'>\n";
    echo "<td align='center'><b>&nbsp;"._HoS_PAGE."&nbsp;</b><select name='page'>\n";
    while($pcnt <= $pages) {
      if($page == $pcnt) { $pag_sele = " selected"; } else { $pag_sele = ""; }
      echo " <option value='$pcnt'$pag_sele>$pcnt</option>\n";
      $pcnt++;
    }
    echo "</select><b>&nbsp;"._HoS_OF."&nbsp;$pages&nbsp;"._HoS_PAGES."&nbsp;</b><input type='submit' value='"._HoS_GO."'>&nbsp;</td>\n";
    echo "</form>\n";

    if ($page < $pages) { $dis_next = ""; } else { $dis_next = " disabled"; }
    echo "<form action='".$admin_file.".php?op=HoSPunk_List' method='post'>\n";
    echo "<input type='hidden' name='page' value='".($page+1)."'>\n";
    echo "<td align='right' width='20%'>&nbsp;<input type='submit' value='"._HoS_NEXTPAGE."'$dis_next></td>\n";
    echo "</form>\n";
    echo "</tr></table>\n";
    echo "</td></tr>\n";
  }

  echo "</table>\n";
} else {
  echo "<center class='title'>"._HoS_NOPUNKSINDATABASE."</center>";
}
CloseTable();
@include("footer.php");

?>