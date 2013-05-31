<?php
/* #####################################################################################
 *
 * $Id: settings.php,v 1.39 2004/09/15 15:51:45 mabu Exp $
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

// unset vars to prevent sql-injections
$updatestring	= "";

if (!checkCookie())
{
	header("Location: index.php");
}

checkPermission("isadmin");

if ($GPC['add'] || $GPC['add_x'])
{
	foreach ($GPC['setting'] as $settingname => $settingvalue)
	{
		if ($settingname == "longdateformat") $longdateformat_old = $settingvalue;

		$updatestring .= $settingname . "='" . $settingvalue . "',";
	}
	$updatestring = substr($updatestring, 0, strlen($updatestring) - 1);

	$vwardb->query("UPDATE vwar".$n."_settings SET " . $updatestring);

	header("Location: settings.php");
}

//template-cache, standard-templates will be added by script:
$vwartpl->cache("admin_settings");

eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");

$row = $vwardb->query_first("SELECT * FROM vwar".$n."_settings");
dbSelectForm($row);

while (list($key,) = each($row))
{
	if ($key == "vwarversion") continue;

	$settingname 									= $key;
	$settingsvalue[$settingname] 	= $row[$key];

	if ($settingname=="smiliecode" || "guestcomments" || "htmlcode" || "bbcode"
		|| "showlegend" || "showquickjump" || "showwarnav" || "showrealresults" || "showcoloredresults"
		|| "deleteparticipants" || "showcountry" || "showreport" || "sendwarmail" || "allowimages" || "formmailer"
		|| "challengeenabled" || "joinenabled" || "ab_enabled" || "ab_deloldfiles" || "allowmails")
	{
		$$settingname = makeyesnocode("setting[$settingname]", $settingsvalue[$settingname]);
	}

	if ($settingname == "warmailpriority") $selectedmailpriority[$settingsvalue['warmailpriority']] = "selected";
	if ($settingname == "warmailhtml") $selectedwarmailhtml[$settingsvalue['warmailhtml']] = "selected";
	if ($settingname == "ab_tables") $selectedabtables[$settingsvalue['ab_tables']] = "selected";
	if ($settingname == "timeformat") $selectedtimeformat[$settingsvalue['timeformat']] = "selected";
	if ($settingname == "startofweek") $selectedstartofweek[$settingsvalue[$settingname]] = "selected";

	if ($settingname == "vwarlanguage") $languagesel[$settingsvalue['vwarlanguage']] = "selected";

	if ($settingname == "timezoneoffset")
	{
		$timezone = abs($settingsvalue['timezoneoffset'] * 10);

		if ($settingsvalue['timezoneoffset'] < 0) $timezone = "n" . $timezone;
		$selected[$timezone] = "selected";
	}

	if ($settingname == "timezoneoffsetuser")
	{
		$timezone = abs($settingsvalue['timezoneoffsetuser'] * 10);

		if ($settingsvalue['timezoneoffsetuser'] < 0) $timezone = "n" . $timezone;
		$selecteduser[$timezone] = "selected";
	}

	if ($settingname == "vwarlanguage")
	{
		while (list($languagekey,$languageval) = each($languages))
		{
			eval("\$languageselectbit .= \"".$vwartpl->get("languageselectbit")."\";");
		}
	}
}
eval("\$vwartpl->output(\"".$vwartpl->get("admin_settings")."\");");
?>