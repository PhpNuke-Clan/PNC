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

if ( !defined('MODULE_FILE') )
{
   die("You can't access this file directly...");
}

$pagetitle = " - "._HoS_HALLOFSHAME.": "._HoS_BROWSEPUNKS;
$sort = $hos_config['pubsort'];
$sortasc = $hos_config['pubsortasc'];
if(!isset($sort)) { $sort = "date_add"; }
if(!isset($sortasc)) { $sortasc = "DESC"; }
if(isset($rid)) { $rid = intval($rid); } else { $rid = 0; }
$catid = $rid;
$pperpage = $hos_config['pperpage'];
@include("header.php");
if($catid > 0) { $hdr = 1; } else { $hdr = 2; }
mainheader($hdr, _HoS_HALLOFSHAME.": "._HoS_BROWSEPUNKS, _HoS_INDEXMESS1);
$memid = stripslashes($hos_config['mid']);
$memtbl = stripslashes($hos_config['membertable']);
$memname = stripslashes($hos_config['membername']);

if($catid > 0) { $result = $db->sql_query("SELECT * FROM ".$prefix."_hos_reasons where rpid = $catid");
	if($db->sql_numrows($result) > 0) {
		while($resinfo = $db->sql_fetchrow($result)) {
		$rid = intval($resinfo['rid']);
		$where .= " or punkreason='$rid'";
		}
	}
}
$where = " WHERE punkreason = '$catid'".$where;
$result = $db->sql_query("SELECT count(*) FROM ".$prefix."_hos_punks$where");
list($total) =  $db->sql_fetchrow($result);
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
echo "<br>\n";
OpenTable();
$result = $db->sql_query("SELECT * FROM ".$prefix."_hos_punks$where ORDER BY $sort $sortasc LIMIT $offset,$pperpage");
if($db->sql_numrows($result) > 0) {
  if($catid != "0") {
    list($res_title) = $db->sql_fetchrow($db->sql_query("SELECT title from ".$prefix."_hos_reasons where rid = '$catid'"));
    $res_title = stripslashes($res_title);
    $rtitle = _HoS_BROWSECATEGORY.": $res_title";
  } else {
    $rtitle = _HoS_BROWSEALLPUNKS;
  }
  echo "<center class='title'>$rtitle</center>\n";
  echo "<hr>\n";
   echo "<table border='1' cellpadding='2' cellspacing='2' width='99%'>\n";
    echo "  <tr>\n";
    echo "    <th><b>"._HoS_PUNK."</b></th>\n";
    echo "    <th><b>"._HoS_REASON."</b></th>\n";
    echo "    <th><b>"._HoS_BANNEDBY."</b></th>\n";
    echo "    <th><b>"._HoS_SCREENSHOT."</b></th>\n";
    echo "    <th><b>"._HoS_DEMO."</b></th>\n";
    echo "    <th><b>"._HoS_DATEBANNED."</b></th>\n";
    echo "  </tr>\n";
    while($punkinfo = $db->sql_fetchrow($result)) {
      $pid = $punkinfo['pid'];
      $punkname = stripslashes($punkinfo['punkname']);
      $punksslabel = $punkinfo['punksslabel'];
      $punkss = $punkinfo['punkss'];
      $punkdemolabel = $punkinfo['punkdemolabel'];
      $punkdemo = $punkinfo['punkdemo'];
      if ($punkinfo['punksslabel'] == "No") {
	          $punkssdisplay = "No";
	        } else {
	      $punkssdisplay = "<a href='$punkss' target='_blank'>$punksslabel</a>";}
	  if ($punkinfo['punkdemolabel'] == "No") {
	  	          $punkdemodisplay = "No";
	  	    } else {
	      $punkdemodisplay = "<a href='$punkdemo' target='_blank'>$punkdemolabel</a>";}

    $punkdatebanned = date($hos_config['date_format'], $punkinfo['date_add']);
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
      echo "<tr>\n";
      echo "<td><a href='modules.php?name=$module_name&amp;op=HoSDetails&amp;pid=$pid'>$punkname</a></td>\n";
      echo "<td align='center'>$reason_title</td>\n";
      echo "<td align='center'>$bannedby_title</td>\n";
      echo "<td align='center'>$punkssdisplay</td>\n";
      echo "<td align='center'>$punkdemodisplay</td>\n";
      echo "<td align='center'>$punkdatebanned</td>\n";
    echo "</tr>\n";

  }
  echo "</table><br>\n";
  if ($pages > 1) {
    $pcnt=1;
    echo "<table cellpadding='0' cellspacing='0' border='0' width='100%'><tr>\n";
    if ($page > 1) { $dis_prev = ""; } else { $dis_prev = " disabled"; }
    echo "<form action='modules.php?name=$module_name&op=HoSReasonsCat&amp;rid=$catid' method='post'>\n";
    echo "<input type='hidden' name='page' value='".($page-1)."'>\n";
    echo "<td align='center' width='20%'><input type='submit' value='"._HoS_PREVPAGE."'$dis_prev>&nbsp;</td>\n";
    echo "</form>\n";

    echo "<form action='modules.php?name=$module_name&op=HoSReasonsCat&amp;rid=$catid' method='post'>\n";
    echo "<td align='center'><b>&nbsp;"._HoS_PAGE."&nbsp;</b><select name='page'>\n";
    while($pcnt <= $pages) {
      if($page == $pcnt) { $pag_sele = " selected"; } else { $pag_sele = ""; }
      echo " <option value='$pcnt'$pag_sele>$pcnt</option>\n";
      $pcnt++;
    }
    echo "</select><b>&nbsp;"._HoS_OF."&nbsp;$pages&nbsp;"._HoS_PAGES."&nbsp;</b><input type='submit' value='"._HoS_GO."'>&nbsp;</td>\n";
    echo "</form>\n";

    if ($page < $pages) { $dis_next = ""; } else { $dis_next = " disabled"; }
    echo "<form action='modules.php?name=$module_name&op=HoSReasonsCat&amp;rid=$catid' method='post'>\n";
    echo "<input type='hidden' name='page' value='".($page+1)."'>\n";
    echo "<td align='center' width='20%'>&nbsp;<input type='submit' value='"._HoS_NEXTPAGE."'$dis_next></td>\n";
    echo "</form>\n";
    echo "</tr></table>\n";
  }
} else {
  if($rid > 0) {
    echo "<center class='title'>"._HoS_NOPUNKSBANNEDFORCATEGORY."</center>\n";
  } else {
    echo "<center class='title'>"._HoS_NOPUNKSINDATABASE."</center>\n";
  }
}
CloseTable();
@include("footer.php");

?>