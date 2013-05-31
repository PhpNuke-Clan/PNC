<?php 
//***************************************************************************
/* Teamspeak database               */
/* Version: 1.00                         */
/* Author: XenoMorpH ¤TÐI¤ (aarvuijk@hotmail.com)  */
/* Made for PNC phpnuke-clan.net	*/
//***************************************************************************
if ( !defined('MODULE_FILE') )
{
	die("You can't access this file directly...");
}
//Right blocks to show? Set to TRUE:
define('INDEX_FILE', true);

include("header.php");
OpenTable();
echo"There is no module.....only configuration in admin area!!!";
CloseTable();
include("footer.php"); 
?>