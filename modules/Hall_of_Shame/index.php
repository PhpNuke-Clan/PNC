<?php

/********************************************************/
/* Hall of Shame                                     	*/
/* By: Troy Moore (Duck@mrc.clanservers.com)			*/
/* http://mrc.clanservers.com                           */
/* Copyright © 2006-2011 by JesStep Enterprises         */
/********************************************************/
/* Hall of Shame                                        */
/* For PHP-Nuke 6.5+                                    */
/* By Troy Moore - http://mrc.clanservers.com        	*/
/********************************************************/



if ( !defined('MODULE_FILE') ) {
	die("Illegal Module File Access");
}

if(!isset($op)) { $op = "HoSIndexCat"; }
$module_name = basename(dirname(__FILE__));
@require_once("mainfile.php");
get_lang($module_name);
@include_once("includes/hos_func.php");
$hos_config = hosget_configs();
$index = intval($hos_config['rightblocks']);
switch($op) {

  case "HoSReasons":@include("modules/$module_name/public/HoSReasons.php");break;
  case "HoSDetails":@include("modules/$module_name/public/HoSDetails.php");break;
  case "HoSSearchName":@include("modules/$module_name/public/HoSSearchName.php");break;
  case "HoSSearchGuid":@include("modules/$module_name/public/HoSSearchGuid.php");break;
  case "HoSIndexRes":@include("modules/$module_name/public/HoSIndexRes.php");break;
  case "HoSIndexCat":@include("modules/$module_name/public/HoSIndexCat.php");break;
  case "HoSSearchIp":@include("modules/$module_name/public/HoSSearchIp.php");break;
  case "HoSSearchBannedby":@include("modules/$module_name/public/HoSSearchBannedby.php");break;
  case "HoSSearchProcess":@include("modules/$module_name/public/HoSSearchProcess.php");break;
  case "HoSSearch":@include("modules/$module_name/public/HoSSearch.php");break;
  case "HoSScreenshots":@include("modules/$module_name/public/HoSScreenshots.php");break;
  case "HoSDemo":@include("modules/$module_name/public/HoSDemo.php");break;
  case "HoSReasonsCat":@include("modules/$module_name/public/HoSReasonsCat.php");break;

}

?>
