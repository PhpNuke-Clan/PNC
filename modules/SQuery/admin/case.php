<?php

//***************************************************************************
/* SQUERY 4.0.1                                                             */
/* Version: 4.0.1                                                           */
/* Author: XenoMorpH ¤TÐI¤ (aarvuijk@hotmail.com)                           */
/* Development Assistance: CrazyCrack (support@phpnuke-clan.net)            */
/* Made for PNC phpnuke-clan.net & SQuery.com                               */
//***************************************************************************

if (!defined('ADMIN_FILE')) {
        die ("Access Denied");
}
//if (!eregi("admin.php", $_SERVER['PHP_SELF'])) { die ("Access Denied"); }
$module_name = "SQuery";
//include_once("modules/$module_name/admin/language/lang-".$currentlang.".php");//used for v3

switch($op)
{
	case "activateBlock":
	case "activateServer":
	case "addserver":
    case "deletesquery":
	case "editsquery":
    case "ServerOrder":
	case "squery":
	case "squeryoptions":
	case "squerytips":
    include("modules/$module_name/admin/index.php");
    break;
}
?>