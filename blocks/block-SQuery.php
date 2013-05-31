<?
/************************************************************************/
/*  Squery 4.0.1  PHPNuke Module                                        */
/* =================================================                    */
/*                                                                      */
/* Copyright (c) 2004 Curtis Brown   (webmaster@squery.com)             */
/* http://www.squery.com                        						*/
/*                                  									*/
/*					                                                    */
/* This Module allows users to query from your PHPNuke Website.         */
/* The module is required to be present for the Block to work, however  */
/* It is not necessary that it be active                                */
/* 								                                        */
/************************************************************************/
/* ADMIN SECTION - Sql Integration - Block Modification                 */
/*                                                                      */
/* Author: XenoMorpH ¤TÐI¤ (aarvuijk@hotmail.com)                       */
/* Development Assistance: CrazyCrack (support@phpnuke-clan.com)        */
/* Made for PNC phpnuke-clan.com & SQuery.com                           */
/************************************************************************/

if ( !defined('BLOCK_FILE') )
{
    Header("Location: ../index.php");
    die();
}

global $db,$nukeurl,$prefix;
$mod_active = "";
$view = "";

$content=""; 

$row = $db->sql_fetchrow($db->sql_query("SELECT * FROM ".$prefix."_modules WHERE title='SQuery'")); 
$mod_active = $row['active']; 
$view = $row['view']; 
    
if($mod_active==0 || $view != 0)
{
	$content.="The SQuery module is set to registered users only or is inactive. This block will only work when the module is set to allow access from all users.";
	$content.="$mod_active";
	$content.="$view";
} 
else
{ 
	$libpath="modules/SQuery/lib/";
	// require our main library =)
	require($libpath.'config.php');
	require_once($libpath.'HttpClient.class.php');

	$websiteurl="$nukeurl";

	$resultyy = $db->sql_query("SELECT * FROM ".$prefix."_squery_servers WHERE hideblock=3 ORDER BY weight ASC");
	while ($row = $db->sql_fetchrow($resultyy))
	{
		//$idtt= $row['id']; 
		$ip = $row['staticip'];
		$port = $row['staticport'];
		$qgame = $row['staticgame'];
		$local_game=$qgame;
		$local_game=str_replace(" ","+",$local_game);

		$geturl=$websiteurl."/modules.php?name=SQuery&file=index&ip=".$ip."&port=".$port."&game=".$local_game."&block=1";
		$tempcontent=HttpClient::quickGet($geturl);
		$tempcontent=str_replace("./lib/",$libpath,$tempcontent);
		$tempcontent=str_replace(".\\\\\\lib\\\\\\",".\\\\\\SQuery\\\\\\lib\\\\\\",$tempcontent);
		$content.=$tempcontent;
	}
}
?>