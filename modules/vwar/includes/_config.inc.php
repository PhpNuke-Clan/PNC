<?php
if(eregi("_config.inc.php", $_SERVER["PHP_SELF"]) || eregi("_config.inc.php", $HTTP_SERVER_VARS["PHP_SELF"])) die("Access denied!");
/* #####################################################################################
 *
 * $Id: automatically generated file by install at 04/21/2009, 00:41:19 am $
 *
 * This notice must remain untouched at all times.
 *
 * Modifications to the script, except the official addons or hacks,
 * without the owners permission are prohibited.
 * All rights reserved to their proper authors.
 *
 * ---------------------------------------------
 * http://www.vwar.de || Copyright (C) 2001-2004
 * ---------------------------------------------
 *
 * #####################################################################################
 */
include_once('config.php');
// ################################### DATABASE SETTINGS  ##############################
$sql["hostname"] = $dbhost; // Hostname of the MySQL-Database
$sql["username"] = $dbuname; // MySQL Username
$sql["password"] = $dbpass; // MySQL Password
$sql["database"] = $dbname; // MySQL Database Name

//	With this option you can install more than one VWar.
// 	Number of VWar (if you update from max. v1.2.2 delete the 1.
// 	$n = "";
//
//  example: (don't use "" if $n is set to a value)
//	--------
// 	$n = 2;
$n = "";

?>