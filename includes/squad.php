<?php
/************************************************************************/
/* By XenoMorpH ¤TÐI¤ (aarvuijk@hotmail.com) AND CrazyCrack
/* http://phpnuke-clan.net TEAM
/*
/*
/************************************************************************/
if ( !defined('NUKE_FILE') )
{
        die("You can't access this file directly...");
}
include_once("mainfile.php");
global $n, $db, $vwarmodname, $numnextactions;
// Select Which of the Folowwing color u want to use.
// (it reads the colorsetting you configured in vwar admin)
/* headcolor */ 		//	$bgc ="5";
/*firstaltcolor*/ 	//	$bgc="6";
/*secondaltcolor */ 	//	$bgc="7";
/*bordercolor */			//$bgc="8";
/*highlightcolor */	//	$bgc="15";
/*bodybgcolor */			$bgc="16";
/*categorycolor */	//	$bgc="17";
/*linkcolor */		//	$bgc="18";
/*hovercolor */		//	$bgc="19";

//5,6,7,8,15,16,17,18,19
$sql2 = $db->sql_query("SELECT findword,replaceword FROM vwar".$n."_replacement WHERE replacementid =".$bgc."", $dbi);
$result2 = $db->sql_fetchrow($sql2);

$statuscolor = $result2[replaceword];
/*echo"<A name= \"scrollingCode\"></A>";
echo"<MARQUEE behavior= \"scroll\" align= \"center\" direction= \"up\" height=\"76\" scrollamount= \"2\" scrolldelay= \"15\" onmouseover='this.stop()' onmouseout='this.start()'>";
*/

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
echo"<br><b>".$statusrow[statusname]."</b><br>";
$result2 = $db->sql_query("SELECT memberid, name, country, sex, status, customstatus, wartag
					FROM vwar".$n."_member
					WHERE hidemember = '0' AND ismember = '1' AND status = '".$statusrow['statusid']."'
					ORDER BY joindate ASC
				");
		while ($row = $db->sql_fetchrow($result2)) {
		if($row[country] == "")	{$country ="int";} else{ $country = $row[country];}
echo"<a href='modules.php?name=$vwar_modulename&file=member&action=profile&memberid=".$row[memberid]."'>".$row[name]."</a>";
echo"<a href=\"modules.php?name=$vwar_modulename&file=member&action=mail&memberid=".$row[memberid]."\">&nbsp;<img src='modules/vwar/images/flags/$country.gif' border=0>&nbsp;<img src=\"modules/vwar/images/emailsend.gif\" border=\"0\"></a><br>";	
//membergames
	$sql3= "SELECT * FROM vwar".$n."_membergames WHERE memberid=".$row[memberid]."";
	$result3 = $db->sql_query($sql3);
    	while ($row3 = $db->sql_fetchrow($result3)) {
	$sql4 = $db->sql_query("SELECT * FROM vwar".$n."_games WHERE gameid = ".$row3['gameid']."");
  	$result4 = $db->sql_fetchrow($sql4, $dbi);
echo"<img src=\"modules/$vwar_modulename/images/gameicons/".$result4[gameicon]."\" alt=\"".$result4[gamename]."\">";

}

	

		}
	}
}
//echo"</MARQUEE>"; 
?>