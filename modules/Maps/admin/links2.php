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

//if (!stristr($_SERVER['PHP_SELF'], $admin_file.".php")) { die ("Access Denied"); }

$module_name = "Maps";
get_lang($module_name);

adminmenu($admin_file.".php?op=mapmain", ""._MAPS."", "maps.gif");

?>