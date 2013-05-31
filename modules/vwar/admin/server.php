<?php
/* #####################################################################################
 *
 * $Id: server.php,v 1.30 2004/03/18 11:02:27 mabu Exp $
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

if (!checkCookie())
{
	header("Location: index.php");
}

// ################################### serverlist ######################################
if ($GPC['action'] == "serverlist" || $GPC['action'] == "")
{
	checkPermission("canaddserver-caneditserver-candeleteserver");
	//template-cache, standard-templates will be added by script:
	$vwartpllist="admin_serverlistbit,admin_serverlist";
	$vwartpl->cache($vwartpllist);

	eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");

	$result = $vwardb->query_first("SELECT count(serverid) AS numservers FROM vwar".$n."_server");
	$numserver = $result['numservers'];

	$result = $vwardb->query("
		SELECT *
		FROM vwar".$n."_server
		ORDER BY servername ASC
		" . getLimitClause()
	);
	while ($row = $vwardb->fetch_array($result))
	{
		dbSelect($row);
		switchColors();

		$active = getActiveTag($row['deleted'], "Server");

		eval ("\$admin_serverlistbit .= \"".$vwartpl->get("admin_serverlistbit")."\";");
	}

	$pagelinks = makepagelinks($numserver,$perpage,"action=serverlist");

	eval("\$vwartpl->output(\"".$vwartpl->get("admin_serverlist")."\");");
}

// ################################### edit server #####################################
if ($GPC['action'] == "editserver")
{
	checkPermission("caneditserver");

	if ($GPC['add'] || $GPC['add_x'])
	{
		// check for wrong data
		if ($servername == "" || $serverip == "")
		{
			$vwartpl->cache("admin_message_error_missingdata");
			eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
			eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_error_missingdata")."\");");
			exit;
		}

		$vwardb->query("
			UPDATE vwar".$n."_server
			SET
			servername = '".$servername."',
			serverip = '$serverip',
			deleted = '$deleted'
			WHERE serverid = '".$GPC['serverid']."'
		");

		header("Location: server.php?action=serverlist");
	}

	$row = $vwardb->query_first("SELECT * FROM vwar".$n."_server WHERE serverid = '".$GPC['serverid']."'");
	dbSelectForm($row);

	$deleted = makeyesnocode("deleted",$row['deleted']);
	$checked = ifelse($row['deleted'] == 1, "checked");

	$vwartpl->cache("admin_editserver");
	eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
	eval("\$vwartpl->output(\"".$vwartpl->get("admin_editserver")."\");");
}

// ################################### add server ######################################
if ($GPC['action'] == "addserver")
{
	checkPermission("canaddserver");

	if ($GPC['add'] || $GPC['add_x'])
	{
		// check for wrong data
		if ($servername == "" || $serverip == "")
		{
			$vwartpl->cache("admin_message_error_missingdata");
			eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
			eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_error_missingdata")."\");");
			exit;
		}

		$vwardb->query("INSERT INTO vwar".$n."_server (servername,serverip) VALUES ('".$servername."','$serverip')");

		header("Location: server.php?action=serverlist");
	}
	else
	{
		$vwartpl->cache("admin_addserver");
		eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
		eval("\$vwartpl->output(\"".$vwartpl->get("admin_addserver")."\");");
	}
}

// ################################### delete server ###################################
if ($GPC['action'] == "deleteserver")
{
	checkPermission("candeleteserver");

	if ($delete)
	{
		$vwardb->query("DELETE FROM vwar".$n."_server WHERE serverid = '".$GPC['serverid']."'");

		header("Location: server.php?action=serverlist&page=$page&s=$s");
	}

	$vwartpl->cache("admin_message_delete,admin_message_delete_entries");

	// check for other entries with this one
	$checkentries = $vwardb->query_first("SELECT COUNT(warid) AS numwars FROM vwar".$n." WHERE serverid = '".$GPC['serverid']."'");

	if ($checkentries['numwars'] > 0)
	{
		$numentries = $checkentries['numwars'];

		eval("\$admin_message_delete_entries .= \"".$vwartpl->get("admin_message_delete_entries")."\";");
	}
	eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
	eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_delete")."\");");
}
?>