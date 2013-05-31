<?php

/************************************************************************/
/* vWar SQUADLIST BLOCK v1.2
/* By XenoMorpH ¤TÐI¤ (aarvuijk@hotmail.com)
/* http://www.tdi-hq.com
/* Please keep ALL copyright information in here....
/*
/* Release:  09/feb/2006
/************************************************************************/

if ( !defined('BLOCK_FILE') ) {
    Header("Location: ../index.php");
    die();
}
$vwarfolder = "vwar";
global $prefix, $db, $dbi, $sitename, $n, $nukeurl, $bgcolor1, $bgcolor2,$bgcolor3, $bgcolor4, $vwarnm;
include("modules/$vwarfolder/includes/_config.inc.php");


// Select Which of the Folowwing color u want to use.
// (it reads the colorsetting you configured in vwar admin)
/* headcolor */ 		//	$bgc ="5";
/*firstaltcolor*/ 	//	$bgc="6";
/*secondaltcolor */ 	//	$bgc="7";
/*bordercolor */			$bgc="8";
/*highlightcolor */	//	$bgc="15";
/*bodybgcolor */		//	$bgc="16";
/*categorycolor */	//	$bgc="17";
/*linkcolor */		//	$bgc="18";
/*hovercolor */		//	$bgc="19";

//5,6,7,8,15,16,17,18,19
$sql2 = $db->sql_query("SELECT findword,replaceword FROM vwar".$n."_replacement WHERE replacementid =".$bgc."", $dbi);
$result2 = $db->sql_fetchrow($sql2);

$statuscolor = $result2[replaceword];
$content="";



$content .= "<A name= \"scrollingCode\"></A>";
$content .="<MARQUEE behavior= \"scroll\" align= \"center\" direction= \"up\" height=\"160\" scrollamount= \"2\" scrolldelay= \"25\" onmouseover='this.stop()' onmouseout='this.start()'>";

$content .="<table CELLSPACING='0' CELLPADDING='2' border=0 bordercolor=$statuscolor WIDTH=\"100%\">"; 

$sql="SELECT *, COUNT(vwar".$n."_member.memberid) AS membercount
			FROM vwar".$n."_memberstatus
			LEFT JOIN vwar".$n."_member ON (vwar".$n."_member.status = vwar".$n."_memberstatus.statusid AND vwar".$n."_member.hidemember = '0' AND vwar".$n."_member.ismember = '1')
			GROUP BY vwar".$n."_memberstatus.statusid
			ORDER BY vwar".$n."_memberstatus.displayorder ASC";

$result = $db->sql_query($sql);
while ($statusrow = $db->sql_fetchrow($result)) {
//while ($statusrow = mysql_fetch_array($result)) {
    	$id = $statusrow[memberid];
    	$namer = $statusrow[name];
	$accessgroupid = $rowstatus[accessgroupid];

if($statusrow[membercount] > 0){
$content .= "<tr>";
$content .= "<td colspan=2 align='center' bgcolor=\"$statuscolor\" width=100%><b>".$statusrow[statusname]."</b><br>";
$content .= "</td>";
$content .= "</tr>";
$result2 = $db->sql_query("SELECT memberid, name, country, sex, status, customstatus, wartag
					FROM vwar".$n."_member
					WHERE hidemember = '0' AND ismember = '1' AND status = '".$statusrow['statusid']."'
					ORDER BY joindate ASC
				");
		while ($row = $db->sql_fetchrow($result2)) {
		if($row[country] == "")	{$country ="int";} else{ $country = $row[country];}
$content .= "<tr><td height=12 >";
$content .= "<a href='modules.php?name=$vwarfolder&file=member&action=profile&memberid=".$row[memberid]."'>".$row[name]."</a>";
$content .= "</td><td width=43><a href=\"modules.php?name=$vwarfolder&file=member&action=mail&memberid=".$row[memberid]."\"><img src='modules/$vwarfolder/images/flags/$country.gif' border=0><img src=\"modules/$vwarfolder/images/emailsend.gif\" border=\"0\"></a></td></tr>";
$content .= "<tr><td height=15 colspan=2>";	
//membergames
	$sql3= "SELECT * FROM vwar".$n."_membergames WHERE memberid=".$row[memberid]."";
	$result3 = $db->sql_query($sql3);
    	while ($row3 = $db->sql_fetchrow($result3)) {
	$sql4 = $db->sql_query("SELECT * FROM vwar".$n."_games WHERE gameid = ".$row3['gameid']."");
  	$result4 = $db->sql_fetchrow($sql4, $dbi);
$content .= "<img src=\"modules/$vwarfolder/images/gameicons/".$result4[gameicon]."\" alt=\"".$result4[gamename]."\">";

}

	
$content .= "</td></tr>";

		}
	}
}
$content .= "</table>";
$content .= "</MARQUEE>"; 


//KEEP THIS COPYRIGHT IN PLACE!!!!!!!YOU DID NOT CREATE THIS BLOCK!!
//AFTER MODIFYING THE BLOCK WON'T GIVE YOU THE RIGHT TO CHANGE THIS COPYRIGHT ALSO!!!!
$content .= "<A HREF='javascript:PopupCentrer(\"blocks/copyright/vwar_sds.html\",450,300,\"menubar=no,scrollbars=no,statusbar=no\")'><div align=\"right\">&copy;</div></A>\n"; 


?>