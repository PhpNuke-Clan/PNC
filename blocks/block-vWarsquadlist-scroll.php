<?php

/************************************************************************/
/* vWar SQUADLIST BLOCK v1.0
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


$vwarfolder = "vwar";
global $prefix, $db, $dbi, $sitename, $n, $vwarnm;
include("modules/$vwarfolder/includes/_config.inc.php");

$sql = "SELECT * FROM vwar".$n."_member WHERE ismember = 1 ORDER BY ismember ASC";
$result = $db->sql_query($sql);
$content = "<A name= \"scrollingCode\"></A>";
$content .="<MARQUEE behavior= \"scroll\" align= \"center\" direction= \"up\" height=\"125\" scrollamount= \"2\" scrolldelay= \"25\" onmouseover='this.stop()' onmouseout='this.start()'>";

$content .="<table CELLSPACING='0' CELLPADDING='0'>"; 


while ($row = $db->sql_fetchrow($result)) {
    $id = $row[memberid];
    $name = $row[name];
	if($row[country] == "")
	{$country ="int";}
	else{ $country = $row[country];}

 $sql2 = sql_query("SELECT * FROM vwar".$n."_membergames WHERE memberid = $id", $dbi);
    $result2 = $db->sql_fetchrow($sql2, $dbi);
    $membergamesid= $result2[membergamesid];
    $gameid1 = $result2[gameid];
$content .= "<tr>";
$content .= "<td >";

$content .= "<img src='modules/$vwarfolder/images/flags/$country.gif'>";
$content .= "</td>";
$content .= "<td><a href='/modules.php?name=$vwarfolder&file=member&action=profile&memberid=$id'>&nbsp;&nbsp;$name</a>";
$content .= "</td>";
$content .= "</tr>";
$content .= "<tr>";
$content .= "<td colSpan='2' align='center'>";
$sql3= "SELECT * FROM vwar".$n."_membergames WHERE memberid=$id";
$result3 = $db->sql_query($sql3);
    while ($row3 = $db->sql_fetchrow($result3)) {
    $gameid2 = $row3["gameid"];
    //$gamename= $row3[gamename];
  


 $sql4 = $db->sql_query("SELECT * FROM vwar".$n."_games WHERE gameid = $gameid2", $dbi);
    $result4 = $db->sql_fetchrow($sql4, $dbi);
    $gameicon = $result4[gameicon];
  $gamename= $result4[gamename];

$content .= "<img src='modules/$vwarfolder/images/gameicons/$gameicon' alt='$gamename'>";

}
}
$content .= "</td>";
$content .= "</tr>";
$content .="</table></MARQUEE>"; 


//KEEP THIS COPYRIGHT IN PLACE!!!!!!!
if (!isset($vwarnm)) {
$content .= "<A HREF='javascript:PopupCentrer(\"blocks/copyright/vwar_sds.html\",450,300,\"menubar=no,scrollbars=no,statusbar=no\")'><div align=\"right\">&copy;</div></A>\n"; 
}

?>