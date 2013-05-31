<?php

/***************************************/
/* Maps Manager by gotcha  version 2.0 */
/* Copyright 2006 http://nukecoder.com */
/* You MAY NOT copy in whole or in part*/
/* or redistribute map manager without */
/* written consent from the author.    */
/* Contact and support can be found at */
/* http://nukecoder.com                */
/***************************************/

if ( !defined('MODULE_FILE') )
{
	die("You can't access this file directly...");
}

/* if(!stristr($_SERVER['PHP_SELF'], "modules.php") && !stristr($_SERVER['SCRIPT_NAME'], "modules.php")) {
	die ("You can't access this file directly...");
} */

@require_once("mainfile.php");
$module_name = basename(dirname(__FILE__));
get_lang($module_name);
@include("modules/$module_name/functions.php");

$cr1 = $db->sql_query("SELECT mval FROM ".$prefix."_mapconfig where mname='m_file'");
	list($mapfiledir) = $db->sql_fetchrow($cr1);
$cr2 = $db->sql_query("SELECT mval FROM ".$prefix."_mapconfig where mname='a_anon'");
	list($allowanon) = $db->sql_fetchrow($cr2);

$id = intval($_POST['id']);
$result = $db->sql_query("SELECT mapfile FROM ".$prefix."_mapmap where mapid='$id'");
$row = $db->sql_fetchrow($result);
$mapfile = $row['mapfile'];

if (!isurl($mapfile)){
	if (is_user($user) or ($allowanon == 1)){
		if (file_exists($mapfiledir."/".$mapfile)){
			$result2 = $db->sql_query("UPDATE ".$prefix."_mapmap SET hits=hits+1 where mapid='$id'");
			Header("Location: $mapfiledir/$mapfile");
		}else{
			@include("header.php");
			OpenTable();
			echo _ERRGETFILE;
			CloseTable();
			@include("footer.php");
		}
	}else{
	@include("header.php");
	nav();
	OpenTable();
	echo "<center>"._MUSTBEREGISTEREDDL."</center>";
	CloseTable();
	@include("footer.php");
	}

}else{
	$result = $db->sql_query("UPDATE ".$prefix."_mapmap SET hits=hits+1 where mapid='$id'");
	Header("Location: $mapfile");
}
?>