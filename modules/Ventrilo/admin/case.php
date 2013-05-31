<?php

/* Maps Management Module                */
/* Version: 2.75                         */
/* Author: gotcha(ztgotcha@hotmail.com)  */
if (!defined('ADMIN_FILE')) {
        die ("Access Denied");
}
//if (!eregi("admin.php", $_SERVER['PHP_SELF'])) { die ("Access Denied"); }
$module_name = "Ventrilo";
//include_once("modules/$module_name/admin/language/lang-".$currentlang.".php");//used for v3

switch($op) {

    case "ventrilo":
    case "update":
    case "deleter":


    include("modules/$module_name/admin/index.php");
    break;

}

?>