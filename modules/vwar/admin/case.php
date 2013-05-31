<?php


if ( !defined('ADMIN_FILE') ) {
	die("Access Denied");
}
$module_name = "vWar";
//include_once("modules/$module_name/admin/language/lang-".$currentlang.".php");//used for v3

switch($op) {

    case "vwar":
    header("Location: modules/vwar/admin/");
    break;
 
}

?>