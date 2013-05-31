<?php
/* #####################################################################################
 *
 * $Id: get_header.php,v 1.2 2004/03/17 19:38:04 mabu Exp $
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

/*
 * ------------------------------------------------------------------------------------
 * includes/_header.php
 * ------------------------------------------------------------------------------------
 * starts the html output
 * ... we need it in the global var space
*/
// beware of cross-site-scripting attacks
if (VWAR_COMMON_INCLUDED != 1)
{
	die("<p style=\"FONT-FAMILY:verdana,tahoma,arial,sans-serif;FONT-SIZE:13px;\">Hacking attempt!</p>\n");
}

$module_name = basename(dirname(__FILE__));
// enable compression
if ($gzip == 1)
{
	ob_start("ob_gzhandler");
}

// include individual header design
// use this file to fill it with your own header design
include ($vwar_root . "_header.php" );

// include vwar design if necessary
eval ("\$vwartpl->output(\"".$vwartpl->get("header")."\");");

// set up the timezone information
eval("\$timezone = \"".$vwartpl->get("timezone")."\";");
?>