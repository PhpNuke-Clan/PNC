<?php
/************************************************************************/
/* vWar vWarbirthday BLOCK v1.0
/* Please keep ALL copyright information in here....
/* No changes/modifications to this script are allowed without the 
/* aproval of the creator of this block: 
/* XenoMorpH ¤TÐI¤ (aarvuijk@hotmail.com)
/* http://www.tdi-hq.com
/************************************************************************/
if ( eregi( "block-Nextwars.php", $_SERVER['PHP_SELF'] ) )
{
    Header("Location: index.php");
    die();
}
global $prefix, $db, $sitename, $n;
// path you your config file of vwar
$vwar_modulename = "vwar";

include_once("modules/$vwar_modulename/includes/_config.inc.php");

$content ="";
global $n, $db;

  $today =(date ("m-d")); 
  
  $sql = "SELECT memberid,name,birthday FROM vwar".$n."_member WHERE birthday LIKE '%$today%' ORDER BY name ASC";
  
  $numbd=$db->sql_numrows($db->sql_query($sql));

if($numbd > 0){
   $result = $db->sql_query($sql);
	while ($row = $db->sql_fetchrow( $result ))
    { 
		$bddate= $row["birthday"];
		$bdname= $row["name"];	
	  	
		list($year, $month, $day) = split('[/.-]', $bddate);
	   	$age =(date ("Y")-$year);

		$content .="<center><img src='images/blocks/happy_birthday.gif' border='0' >&nbsp;<br>";	
		$content .="<a href=\"modules.php?name=".$vwar_modulename."&amp;file=member&nbsp;action=mail&nbsp;memberid=".$row["memberid"]."\">".$bdname."&nbsp;(".$age.")</a><br></center>";
	}
}
else{ $content .="<center />No Birthdays today!!</center />";
}
if (!isset($vwarnm)) {
$content .= "<A HREF='javascript:PopupCentrer(\"blocks/copyright/vwar_next.html\",400,300,\"menubar=no,scrollbars=no,statusbar=no\")'><div align=\"right\">&copy;</div></A>\n"; 
}


?>