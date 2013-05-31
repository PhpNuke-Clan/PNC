<?php

/********************************************************/
/* NukeSentinel(tm)                                     */
/* By: NukeScripts(tm) (http://www.nukescripts.net)     */
/* Copyright � 2000-2008 by NukeScripts(tm)             */
/* See CREDITS.txt for ALL contributors                 */
/********************************************************/

if(!defined('MODULE_FILE')) { header("Location: ../../index.php"); }
define('NUKESENTINEL_PUBLIC', true);
$module_name = basename(dirname(__FILE__));
require_once('mainfile.php');
$index = 1;
define('INDEX_FILE', TRUE);
$ab_config = abget_configs();
$checkrow = $db->sql_numrows($db->sql_query('SELECT * FROM `'.$prefix.'_nsnst_ip2country` LIMIT 0,1'));
if($checkrow > 0) { $tableexist = 1; } else { $tableexist = 0; }
if (!isset($op)) $op='';
if($op == 'STIP2C' AND $tableexist != 1) { $op = 'STIndex'; }
if(!$op) { $op = 'STIndex'; }
include_once('modules/'.$module_name.'/public/functions.php');
switch($op) {

  case 'STIndex':include('modules/'.$module_name.'/public/STIndex.php');break;
  case 'STIPS':include('modules/'.$module_name.'/public/STIPS.php');break;
  case 'STRanges':include('modules/'.$module_name.'/public/STRanges.php');break;
  case 'STReferers':include('modules/'.$module_name.'/public/STReferers.php');break;
  case 'STIP2C':include('modules/'.$module_name.'/public/STIP2C.php');break;

}

?>