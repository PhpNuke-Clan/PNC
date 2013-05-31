<?php

/********************************************************/
/* NSN Groups                                           */
/* By: NukeScripts Network (webmaster@nukescripts.net)  */
/* http://www.nukescripts.net                           */
/* Copyright © 2000-2005 by NukeScripts Network         */
/********************************************************/

if(!defined('MODULE_FILE')) { die("Illegal Access Detected!!!"); }
$module_name = basename(dirname(__FILE__));
$index = 1;
require_once("mainfile.php");
get_lang($module_name);
if(!isset($op)) { $op = "GRDefault"; }
switch ($op) {
  case "GRDefault":include("modules/$module_name/public/GRDefault.php");break;
  case "GRInfo":include("modules/$module_name/public/GRInfo.php");break;
  case "GRJoin":include("modules/$module_name/public/GRJoin.php");break;
}

?>
