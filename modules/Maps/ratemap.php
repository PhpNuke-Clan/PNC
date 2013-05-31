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
$pagetitle = "- $module_name - "._RATE." "._MAP;

$cr1 = $db->sql_query("SELECT mval FROM ".$prefix."_mapconfig where mname='a_rate'");
	list($allowratings) = $db->sql_fetchrow($cr1);

if (is_user($user)){
	if ($allowratings){
		if (isset($_POST['submit'])){
			$mapid = intval($_POST['mapid']);
			//$mapttitle = $_POST['maptitle'];
			$rated = intval($_POST['rated']);
			$cattitle = $_POST['cattitle'];
			$catid = $_POST['catid'];
			$cookie = cookiedecode($user);
			$voter = $cookie[1];
			$result = $db->sql_query("SELECT * FROM ".$prefix."_mapvoters where mapid='$mapid' AND user='$voter'");
			if ($db->sql_numrows($result) > 0){
				@include("header.php");
				OpenTable();
				echo "<center>"._CANTVOTETWICE."<br>"._GOBACK."</center>";
				CloseTable();
				@include("footer.php");
			}else{
				
				$result = $db->sql_query("SELECT * FROM ".$prefix."_mapvotes where mapid='$mapid'");
				$numrows = $db->sql_numrows($result);
				if ($numrows <= 0){
					$db->sql_query("INSERT INTO ".$prefix."_mapvotes VALUES (NULL, '$mapid', '0', '0', '0')");
				}
				$result1 = $db->sql_query("SELECT rating, totalvotes FROM ".$prefix."_mapvotes WHERE mapid='$mapid'");
				while(list($rating, $totalvotes) = $db->sql_fetchrow($result1)){
					$new_rating = (($rated + ($rating * $totalvotes)) / ($totalvotes + 1));
					$new_rating2 = number_format($new_rating, 2, '.', '');
					$result2 = $db->sql_query("UPDATE ".$prefix."_mapvotes SET rating='$new_rating2', totalvotes=totalvotes+1 WHERE mapid='$mapid'");
					$result3 = $db->sql_query("INSERT INTO ".$prefix."_mapvoters VALUES (NULL, '$mapid', '$voter')");
				}
				@include("header.php");
				@include("modules/$module_name/functions.php");
				nav();
				OpenTable();
				if ($result2 && $result3){
					echo ""._VOTEENTERED."<br>"._GOBACK."";
				}else{
					echo ""._VOTENOTENTERED."<br>"._GOBACK."";
				}
				CloseTable();
				@include("footer.php");
			}
		}
	}
}else{
	OpenTable();
	echo "<center>"._MUSTBEREGISTERED."<META http-equiv='refresh' content='3;url=modules.php?name=$module_name'></center>";
	CloseTable();
}
?>