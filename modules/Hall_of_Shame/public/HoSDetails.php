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


$pagetitle = " - "._HoS_HALLOFSHAME.": "._HoS_PUNKDETAILS;
@include("header.php");
mainheader(6, _HoS_HALLOFSHAME.": "._HoS_PUNKDETAILS, _HoS_INDEXMESS1);
$demoheight = intval($hos_config['demoheight']);
$demowidth = intval($hos_config['demowidth']);
$memid = stripslashes($hos_config['mid']);
$memtbl = stripslashes($hos_config['membertable']);
$memname = stripslashes($hos_config['membername']);

$result = $db->sql_query("SELECT * from ".$prefix."_hos_punks WHERE pid = '$pid'");

if (!mysql_num_rows($result) == 1) {
   //there are no topics, so say so
   echo "<P><em>Sorry there is an error</em></p>";
} else {

while ($punkinfo = $db->sql_fetchrow($result)) {

	$punkname = $punkinfo['punkname'];
      	$punkguid = $punkinfo['punkguid'];
      	$punkip = $punkinfo['punkip'];
      	$punkss = $punkinfo['punkss'];
      	$punkdemo = $punkinfo['punkdemo'];
      	$new_size = hossize_image($punkinfo['punkss'], $hos_config['punksswidth'], $hos_config['punkssheight']);
      	if ($punkinfo['punksslabel'] == "No") {
			   	          $punkssdisplay = "<img src=\"modules/Hall_of_Shame/images/noss.gif\">";
			   	        } else {
	   	      $punkssdisplay = "<a href='".$punkinfo['punkss']."' target='_blank'><img border='0' src='".$punkinfo['punkss']."' width='".$new_size['width']."' height='".$new_size['height']."'></a><BR>"._HoS_CLICKTOOPEN;}
      	if ($punkinfo['punkdemolabel'] == "No") {
			   	  	          $punkdemodisplay = "<img src=\"modules/Hall_of_Shame/images/nodemo.gif\">";
			   	  	    } else {
	      $punkdemodisplay = " <!-- begin embedded WindowsMedia file... -->
      <table border='0' cellpadding='0' align='center'>
      <tr><td>
      <OBJECT id='mediaPlayer' width=$demowidth height=$demoheight
      classid='CLSID:22d6f312-b0f6-11d0-94ab-0080c74c7e95'
      codebase='http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=5,1,52,701'
      standby='Loading Microsoft Windows Media Player components...' type='application/x-oleobject'>
      <param name='fileName' value='".$punkdemo."'>
      <param name='animationatStart' value='true'>
      <param name='transparentatStart' value='true'>
      <param name='autoStart' value='true'>
      <param name='showControls' value='true'>
      <param name='loop' value='false'>
      <EMBED type='application/x-mplayer2'
        pluginspage='http://microsoft.com/windows/mediaplayer/en/download/'
        id='mediaPlayer' name='mediaPlayer' displaysize='4' autosize='-1'
        bgcolor='darkblue' showcontrols='true' showtracker='-1'
        showdisplay='0' showstatusbar='-1' videoborder3d='-1' width=$demowidth height=$demoheight
        src='".$punkdemo."' autostart='true' designtimesp='5311' loop='false'>
      </EMBED>
      </OBJECT>
      </td></tr>
      <!-- ...end embedded WindowsMedia file -->
    <!-- begin link to launch external media player... -->
        <tr><td align='center'>
        <a href='".$punkdemo."' style='font-size: 85%;' target='_blank'>"._HoS_LAUNCH."</a>
        <!-- ...end link to launch external media player... -->
        </td></tr>
      </table>";}
      	 if ($punkinfo['punkreason'] == 0) {
		      $punkreason = _HoS_NOTSET;
		    } else {
		      list($punkreason) = $db->sql_fetchrow($db->sql_query("SELECT title from ".$prefix."_hos_reasons where rid='".$punkinfo['punkreason']."'"));
		      $punkreason = stripslashes($punkreason);
		    }
		    if ($punkinfo['punkbannedby'] == 0) {
		      $punkbannedby = _HoS_NOTSET;
		    } else {
		      list($punkbannedby) = $db->sql_fetchrow($db->sql_query("SELECT $memname from $memtbl where $memid ='".$punkinfo['punkbannedby']."'"));
		      $punkbannedby = stripslashes($punkbannedby);
    }

      	$punknotes = $punkinfo['punknotes'];
      	$punkdatebanned = date($hos_config['date_format'], $punkinfo['date_add']);

      			$Tpunkguid = _HoS_GUID;
		      	$Tpunkip = _HoS_IP;
		      	$Tpunkss = _HoS_SCREENSHOT;
		      	$Tpunkdemo = _HoS_DEMO;
		      	$Tpunkreason = _HoS_REASON;
		      	$Tpunkbannedby = _HoS_BANNEDBY;
		      	$Tpunknotes = _HoS_NOTES;
      			$Tpunkdatebanned = _HoS_DATEBANNED;
      			$Tscreenshot = _HoS_SCREENSHOT;
      			$Tdemo = _HoS_DEMO;
      			$Tdetailsfor = _HoS_DETAILSFOR;



      	//create the display blocks
	   $display_block1 = "

	     <table width=\"100%\" border=\"1\">
	       <tr>
	         <th width=\"20%\">$Tpunkguid</td>
	         <th width=\"20%\">$Tpunkip</th>
	         <th width=\"20%\">$Tpunkreason</th>
	         <th width=\"20%\">$Tpunkbannedby</th>
	         <th width=\"20%\">$Tpunkdatebanned</th>
	       </tr>
	       <tr>
	         <td>$punkguid</td>
	         <td>$punkip</td>
	         <td>$punkreason</td>
	         <td>$punkbannedby</td>
	         <td>$punkdatebanned</td>
	       </tr>
	     </table>
<br><br><br><br>
	<table align=\"center\" width=\"60%\" border=\"1\">
	       <tr>
	         <th align=\"center\">$Tpunknotes</th>
	       </tr>
	       <tr>
	         <td height=\"80\">$punknotes</td>
	       </tr>
	     </table>
	     <br><br><br><br>
	     <table align=\"center\" width=\"80%\" border=\"1\">
	       <tr>
	         <th align=\"center\" colspan=\"2\">$Tscreenshot</th>
	       </tr>
	       <tr>
	         <td width=\"100%\" align=\"center\">$punkssdisplay</td>
	       </tr>
	 </table>
	   <br><br><br><br>
	     <table align=\"center\" width=\"80%\" border=\"1\">
	       <tr>
	         <th align=\"center\" colspan=\"2\">$Tdemo</th>
	       </tr>
	       <tr>
	        <td width=\"100%\" align=\"center\">$punkdemodisplay</td>
	       </tr>
	 </table>";
	}

	OpenTable();

	echo"<h1 align=\"center\">$Tdetailsfor$punkname</h1>";
	print $display_block1;
	echo"</ br>";
	CloseTable();


}

	@include("footer.php");
?>