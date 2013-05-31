<?php
//***************************************************************************
/* Teamspeak database               */
/* Version: 1.00                         */
/* Author: XenoMorpH ¤TÐI¤ (aarvuijk@hotmail.com)  */
/* Made for PNC phpnuke-clan.net	*/
//***************************************************************************
if ( !defined('ADMIN_FILE') ) {
	die("Access Denied");
}
$module_name = "Teamspeak";
//include_once("modules/$module_name/admin/language/lang-".$currentlang.".php");//used for v3

switch($op) {

    case "teamspeak":
    case "update":
    case "deleter":


    include("modules/$module_name/admin/index.php");
    break;

}

?>