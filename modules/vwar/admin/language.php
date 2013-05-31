<?php
/* #####################################################################################
 *
 * $Id: language.php,v 1.4 2004/03/18 11:02:27 mabu Exp $
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

// get functions
$vwar_root = "./../";
require($vwar_root . "modname.php");
require($vwar_root . "includes/functions_common.php");
require($vwar_root . "includes/functions_admin.php");
require($vwar_root . "includes/functions_customize.php");

if (!checkCookie())
{
	header("Location: index.php");
}

checkPermission("isadmin");

// ################################### list language items ######################################
if ($GPC["action"] == "")
{
	$vwartpllist = "admin_languagelist,admin_languagelistbit";
	$vwartpl->cache($vwartpllist);

	eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");

	$result = $vwardb->query("
		SELECT languageid, languagetitle
		FROM vwar".$n."_customlanguage
		ORDER BY languagetitle ASC
	");

	while($row = $vwardb->fetch_array($result))
	{
		switchColors();
	
		eval("\$admin_languagelistbit .= \"".$vwartpl->get("admin_languagelistbit")."\";");
	}

	eval("\$vwartpl->output(\"".$vwartpl->get("admin_languagelist")."\");");
}

// ################################### delete language item #####################################
if ($GPC['action'] == "delete")
{
	if ($delete)
	{
		deleteLanguageVars($GPC["languageid"],1);
		header("Location: ".$GPC['PHP_SELF']);
		exit();
	}
	
	eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
	eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_delete")."\");");
}
?>