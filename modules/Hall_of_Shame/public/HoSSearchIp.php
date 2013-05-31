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

$pagetitle = " - "._HoS_HALLOFSHAME.": "._HoS_SEARCHIP;
@include("header.php");
mainheader(7, _HoS_HALLOFSHAME.": "._HoS_SEARCHIP, _HoS_INDEXMESS1);
$memid = stripslashes($hos_config['mid']);
$memtbl = stripslashes($hos_config['membertable']);
$memname = stripslashes($hos_config['membername']);
echo "<br>\n";
OpenTable();
$result = $db->sql_query("SELECT * FROM ".$prefix."_hos_punks WHERE punkip LIKE '%$query%' OR punknotes LIKE '%$query%' ORDER BY punkip DESC LIMIT 0, ".$hos_config['search']);
if ($db->sql_numrows($result) > 0) {
  echo "<center class='title'>"._HoS_RESULTSFOR.": <i>$query</i> = ".$db->sql_numrows($result)."</center>\n";
  echo "<hr>\n";
    echo "<table border='1' cellpadding='2' cellspacing='2' width='99%'>\n";
     echo "  <tr>\n";
     echo "    <th><b>"._HoS_PUNK."</b></th>\n";
     echo "    <th><b>"._HoS_IP."</b></th>\n";
     echo "    <th><b>"._HoS_REASON."</b></th>\n";
     echo "    <th><b>"._HoS_BANNEDBY."</b></th>\n";
     echo "    <th><b>"._HoS_SCREENSHOT."</b></th>\n";
     echo "    <th><b>"._HoS_DEMO."</b></th>\n";
     echo "    <th><b>"._HoS_DATEBANNED."</b></th>\n";
     echo "  </tr>\n";
     while($punkinfo = $db->sql_fetchrow($result)) {
       $pid = $punkinfo['pid'];
       $punkname = stripslashes($punkinfo['punkname']);
       $punkip = stripslashes($punkinfo['punkip']);
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
       echo "<td align='center'>$punkip</td>\n";
       echo "<td align='center'>$reason_title</td>\n";
       echo "<td align='center'>$bannedby_title</td>\n";
       echo "<td align='center'>$punkssdisplay</td>\n";
       echo "<td align='center'>$punkdemodisplay</td>\n";
       echo "<td align='center'>$punkdatebanned</td>\n";
     echo "</tr>\n";

  }
  echo "</table><br>\n";

  } else {
    echo "<center class='title'>"._HoS_NORESULTS.": <i>$query</i></center>\n";
}
CloseTable();
@include("footer.php");
?>