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

if ( !defined('ADMIN_FILE') )
{
	die("Illegal File Access");
}

//if (!stristr($_SERVER['PHP_SELF'], "".$admin_file.".php")) { die ("Access Denied"); }

$module_name = "Maps";
@include_once("modules/$module_name/admin/language/lang-".$currentlang.".php");


switch($op) {

	case "mapmain":
	case "addmapcat":
	case "editmapcat":
	case "updmapcat":
	case "delmapcat":
	case "addmap":
	case "editmap":
	case "updmap":
	case "delmap":
	case "usermap":
	case "addusermap":
	case "delusermap":
	case "upfile":
	case "thumb_img":
	case "mapconfig":
	case "approve":
    @include("modules/$module_name/admin/index.php");
    break;

}

?>