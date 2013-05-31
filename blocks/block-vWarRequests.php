<?php
/************************************************************************/
/* vWar vWarRequests BLOCK v1.0
/* By XenoMorpH ¤TÐI¤ (aarvuijk@hotmail.com)
/* http://www.tdi-hq.com
/* Please keep ALL copyright information in here....
/*
/*
/************************************************************************/
if ( !defined('BLOCK_FILE') ) {
    Header("Location: ../index.php");
    die();
}
global $prefix, $db, $dbi, $sitename, $nukeurl, $n, $vwarnm;
// path you your config file of vwar
$vwar_modulename = "vwar";

include("modules/$vwar_modulename/includes/_config.inc.php");
$content="";
//$result20=$db->sql_query("SELECT * FROM vwar".$n." WHERE oppid='".$row['oppid']."' AND dateline='$dateline'");
	
$joiners=$db->sql_numrows($db->sql_query("SELECT * FROM vwar".$n."_join"));
$content.="There are ";
	$result = $db->sql_query("SELECT * FROM vwar".$n."_join ORDER BY joinid ASC");
$var1= 1;
	while ($row = $db->sql_fetchrow( $result ))
    { 
	$jid = $row["joinid"];
/*
 joinid
 contactname
 gameid
 contactemail
 contactcountry 
 contactbirthday  	
*/
	if($joiners > 0){
	$content1.="<tr><td>".$var1.":</td>";
	$content1.="<td align=\"left\" colspan=\"\" border=\"0\" background=\"#000000\"><a href= \"modules/vwar/admin/member.php?action=joindetails&amp;joinid=". $row["joinid"]."\" target=\"_blank\">". $row["contactname"]."</a></td>";
	$content1.="<td align=\"left\" colspan=\"\" border=\"0\" background=\"#000000\"><img src=\"modules/$vwar_modulename/images/flags/". $row["contactcountry"].".gif\"></td>";
	$content1.="</tr>";
	
	}
	else{$content1.="NO Joinrequests";}
$var1++;
}
$content.="<span style=\"font-weight: bold; color: white; border:0px solid #7B869A; background-color: ; cursor: pointer\" onclick=\"var div=document.getElementById('YourCodeListingDivIdj$jid');if(div.style.display=='none'){div.style.display='block';this.innerHTML='$joiners Close List';}else{div.style.display='none';this.innerHTML='$joiners Joinrequests';}\">$joiners Joinrequests</span><center><strong></strong></center><div id=\"YourCodeListingDivIdj$jid\" style=\"display:none\">";
$content .= "<table width=\"100%\" border=\"0\"   bgcolor=\"\">";
$content .= "$content1";
$content .= "</table></DIV>";
$content .= "";



	//$pending_joins = ifelse($result['pending_joins'] > 0, makelink("member.php?action=viewjoin", $result['pending_joins']), "NO");
	
$challenges=$db->sql_numrows($db->sql_query("SELECT * FROM vwar".$n."_challenge"));
	$result = $db->sql_query("SELECT * FROM vwar".$n."_challenge ORDER BY challengeid ASC");
	$content.="There are ";
		
  $var1= 1;
	while ($row = $db->sql_fetchrow( $result ))
    { 
	$chid = $row["challengeid"];
/*
challengeid
gameid
gametypeid
matchtypeid
teamname
teamnameshort
contactname
contactemail
contacticq
contactaim
contactyim
contactmsn
contacthomepage
contactircnetwork
contactircchannel
playerperteam
locations
challengeinfo
dateline
deleted
*/
 $icon = $db->sql_fetchrow($db->sql_query("SELECT gameicon FROM vwar".$n."_games WHERE gameid = ". $row["gameid"].""));
	if($challenges > 0){
	$content2.="<tr><td>".$var1.":</td>";
	$content2.="<td align=\"left\" colspan=\"\" border=\"0\" background=\"#000000\"><a href= \"modules/vwar/admin/admin.php?action=challengedetails&amp;challengeid=". $row["challengeid"]."\" target=\"_blank\">". $row["teamnameshort"]."</a></td>";
	if($row["contacthomepage"]!=''){$vlink="<a href= \"". $row["contacthomepage"]."\" target=\"_blank\"><img src=\"modules/$vwar_modulename/images/button_homepage.gif\" border=\"0\" ></a>";}else{$vlink="";}
	$content2.="<td align=\"left\" colspan=\"\" border=\"0\" background=\"#000000\">$vlink</td>";
	$content2.="<td align=\"left\" colspan=\"\" border=\"0\" background=\"#000000\"><img src=\"modules/$vwar_modulename/images/gameicons/$icon[0]\"></td>";
	$content2.="</tr>";
	
	}
	else{$content2.="NO Challenges";}
$var1++;
}
$content.="<span style=\"font-weight: bold; color: white; border:0px solid #7B869A; background-color: ; cursor: pointer\" onclick=\"var div=document.getElementById('YourCodeListingDivId$chid');if(div.style.display=='none'){div.style.display='block';this.innerHTML='$challenges Close List';}else{div.style.display='none';this.innerHTML='$challenges  Challenges';}\">$challenges Challenges</span><center><strong></strong></center><div id=\"YourCodeListingDivId$chid\" style=\"display:none\">";
$content .= "<table width=\"100%\" border=\"0\"   bgcolor=\"\">";
$content .= "$content2";
$content .= "</table></DIV>";
$content .= "";
//$result = $db->sql_query( $query );



             

?>