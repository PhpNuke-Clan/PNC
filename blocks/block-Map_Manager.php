<?php

/***************************************/
/* Random Map Block for Map Manager    */
/* Map Manager by gotcha  version 2.0  */
/* Copyright 2005 http://nukecoder.com */
/* You MAY NOT copy in whole or in part*/
/* or redistribute map manager without */
/* written consent from the author.    */
/* Contact and support can be found at */
/* http://nukecoder.com                */
/***************************************/
/* If you want to hide any line,        */
/* simply put // in front of the        */
/* corresponding $content variable.     */
/****************************************/


if ( !defined('BLOCK_FILE') ) {
    Header("Location: ../index.php");
    die();
}


global $prefix, $db, $sitename, $admin, $bgcolor1, $bgcolor2;

//Change this value to match the name of the Map Manager module, for the links to work.
$module_name = "Maps";
$block_name = "Our Maps";

$content .= "
<table width='100%' border='0'>
<tr>
<td colspan='2' bgcolor='$bgcolor1'><center><font class='title'><a href='modules.php?name=$module_name'>$block_name</a>&nbsp;</font></center></td>
</tr>
<tr>
<td><center>Categories</center></td><td>Maps</td>
</tr>";
$maincats = $db->sql_query("SELECT * FROM ".$prefix."_mapcat where mainid='0' ORDER BY 'title' ASC");
$nummain = $db->sql_numrows($maincats);
//$content .= "<tr><td>$maincats</td></tr>";
while($maincat = $db->sql_fetchrow($maincats)) {
	$catid = $maincat['id'];
	$catname = $maincat['title'];
	$catname2 = ereg_replace(" ", "_", $catname);
	$nummap = $db->sql_query("SELECT * FROM ".$prefix."_mapmap where cat='$catid'");
	$nummaps = $db->sql_numrows($nummap);
	$content .= "
	<tr>
	<td bgcolor='$bgcolor1' onclick='\"window.location.href='modules.php?name=$module_name&amp;cat=$catname2&amp;id=$catid'\">&raquo; <a href='modules.php?name=$module_name&amp;cat=$catname&amp;id=$catid'><strong>$catname</strong></a><br></td><td bgcolor='$bgcolor1'>$nummaps&nbsp;</td></tr>";
	$subcats = $db->sql_query("SELECT * FROM ".$prefix."_mapcat where mainid=$catid ORDER BY 'title' ASC");
	$numsub = $db->sql_numrows($subcats);
		while($subcat = $db->sql_fetchrow($subcats)) {
			$subcatid = $subcat['id'];
			$subcatname = $subcat['title'];
			$subcatname2 = ereg_replace(" ", "_", $subcatname);
			$submap = $db->sql_query("SELECT * FROM ".$prefix."_mapmap where cat='$subcatid'");
			$submaps = $db->sql_numrows($submap);
			$content .= "<tr><td>&nbsp;&nbsp;&nbsp;<a href='modules.php?name=$module_name&amp;cat=$subcatname2&amp;id=$subcatid'>$subcatname</a><br></td><td>$submaps&nbsp;</td></tr>";
		}
	$content .= "<tr><td colspan='2'>&nbsp;</td></tr>";
	
}

$content .= "</table>";
?>