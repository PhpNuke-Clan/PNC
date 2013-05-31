<?php
/* #####################################################################################
 *
 * $Id: access.php,v 1.22 2004/03/18 11:02:27 mabu Exp $
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

// ################################### list groups #####################################
if ($GPC['action'] == "")
{
	checkPermission("canaddpermission-caneditpermission-candeletepermission");

	//template-cache, standard-templates will be added by script:
	$vwartpllist="admin_accessgroup_listbit,admin_accessgroup_list";
	$vwartpl->cache($vwartpllist);

	eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");

	$result = $vwardb->query("
		SELECT accessgroupname, vwar".$n."_accessgroup.accessgroupid, COUNT(memberid) AS nummember
		FROM vwar".$n."_accessgroup
		LEFT JOIN vwar".$n."_member ON (vwar".$n."_member.accessgroupid = vwar".$n."_accessgroup.accessgroupid)
		GROUP BY vwar".$n."_accessgroup.accessgroupid
		ORDER BY accessgroupname ASC
	");
	while ($row = $vwardb->fetch_array($result))
	{
		dbSelect($row);
		switchColors();

		eval("\$admin_accessgroup_listbit .= \"".$vwartpl->get("admin_accessgroup_listbit")."\";");
	}
	eval("\$vwartpl->output(\"".$vwartpl->get("admin_accessgroup_list")."\");");
}

// ################################### modify group ####################################
if ($GPC['action'] == "modifygroup")
{
	checkPermission("caneditpermission");

	if ($GPC['add'] || $GPC['add_x'])
	{
		// check for wrong data
		if ($accessgroupname == "")
		{
			$vwartpl->cache("admin_message_error_missingdata");
			eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
			eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_error_missingdata")."\");");
			exit;
		}

		while (list($settingname, $settingvalue) = each($permission))
		{
			$updatestring .= $settingname."='".$settingvalue."',";
		}
		$updatestring = substr($updatestring,0,strlen($updatestring) - 1);

		$vwardb->query("UPDATE vwar".$n."_accessgroup SET ".$updatestring." WHERE accessgroupid = '".$GPC['accessgroupid']."'");
		$vwardb->query("UPDATE vwar".$n."_accessgroup SET accessgroupname = '".$accessgroupname."' WHERE accessgroupid = '".$GPC['accessgroupid']."'");

		header("Location: access.php");
	}
	else
	{
		eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");

		$row = $vwardb->query_first("SELECT * FROM vwar".$n."_accessgroup WHERE accessgroupid = '".$GPC['accessgroupid']."'");
		while (list($key,$val) = each($row))
		{
			$permissionname = $key;
			$permissionvalue[$permissionname] = dbSelectForm($row[$permissionname]);

			if ($permissionname != "accessgroupid" && $permissionname != "accessgroupname")
			{
				$$permissionname = makeyesnocode("permission[$permissionname]",$permissionvalue[$permissionname]);
			}
		}
		$vwartpl->cache("admin_accessgroup_edit");
		eval("\$vwartpl->output(\"".$vwartpl->get("admin_accessgroup_edit")."\");");
	}
}

// ################################### add group #######################################
if ($GPC['action'] == "addgroup")
{
	checkPermission("canaddpermission");

	if ($GPC['add'] || $GPC['add_x'])
	{
		// check for wrong data
		if ($accessgroupname == "")
		{
			$vwartpl->cache("admin_message_error_missingdata");
			eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
			eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_error_missingdata")."\");");
			exit;
		}

		$vwardb->query("INSERT INTO vwar".$n."_accessgroup (accessgroupname) VALUES ('".$accessgroupname."')");
		$lastinsertid = $vwardb->insert_id();

		while (list($settingname, $settingvalue) = each($permission))
		{
			$updatestring .= $settingname."='".$settingvalue."',";
		}
		$updatestring = substr($updatestring,0,strlen($updatestring)-1);

		$vwardb->query("UPDATE vwar".$n."_accessgroup SET ".$updatestring." WHERE accessgroupid = '".$lastinsertid."'");

		header("Location: access.php");
	}
	else
	{
		$vwartpl->cache("admin_accessgroup_add");
		eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
		eval("\$vwartpl->output(\"".$vwartpl->get("admin_accessgroup_add")."\");");
	}
}

// ################################### delete group ####################################
if ($GPC['action'] == "deletegroup")
{
	checkPermission("candeletepermission");

	if ($delete)
	{
		$vwardb->query("DELETE FROM vwar".$n."_accessgroup WHERE accessgroupid = '".$GPC['accessgroupid']."'");
		header("Location: access.php");
	}
	else
	{
		//template-cache, standard-templates will be added by script:
		$vwartpllist="admin_message_error_nodelete,admin_message_delete";
		$vwartpl->cache($vwartpllist);

		eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");

		$result = $vwardb->query_first("
			SELECT COUNT(memberid) AS nummembers
			FROM vwar".$n."_member
			WHERE accessgroupid = '".$GPC['accessgroupid']."'
		");
		$nummember = $result['nummembers'];

		eval("\$vwartpl->output(\"".$vwartpl->get(ifelse($nummember > 0, "admin_message_error_nodelete", "admin_message_delete"))."\");");
	}
}
?>