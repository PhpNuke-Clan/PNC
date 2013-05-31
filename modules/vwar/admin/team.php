<?php
/* #####################################################################################
 *
 * $Id: team.php,v 1.27 2004/03/18 11:02:27 mabu Exp $
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

// ################################### view teams ######################################
if ($GPC['action'] == "viewteams")
{
	checkPermission("canaddteam-caneditteam-candeleteteam");
	//template-cache, standard-templates will be added by script:
	$vwartpllist="admin_teamlistbit,admin_teamlist";
	$vwartpl->cache($vwartpllist);

	eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");

	$result = $vwardb->query("SELECT * FROM vwar".$n."_team ORDER BY displayorder ASC, teamname ASC");
	while ($row = $vwardb->fetch_array($result))
	{
		dbSelect($row);
		switchColors();

		$statusimg = $row['invisible'] ? makeimgtag($vwar_root . "images/hiddenteam.gif", "Hidden Team") : "";

		eval ("\$admin_teamlistbit .= \"".$vwartpl->get("admin_teamlistbit")."\";");
	}

	eval("\$vwartpl->output(\"".$vwartpl->get("admin_teamlist")."\");");
}
// ################################### add team ########################################
if ($GPC['action'] == "addteam")
{
	checkPermission("canaddteam");

	if ($GPC['add'] || $GPC['add_x'])
	{
		// check for wrong data
		if ($teamname == "")
		{
			$vwartpl->cache("admin_message_error_missingdata");
			eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
			eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_error_missingdata")."\");");
			exit;
		}
		$vwardb->query("
			INSERT INTO vwar".$n."_team
			(teamname, invisible, displayorder)
			VALUES
			('".$teamname."', '$hide', '$displayorder')
		");
		header("Location: team.php?action=viewteams");
	}
	$hideteam = makeyesnocode("hide",0);

	$vwartpl->cache("admin_addteam");
	eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
	eval("\$vwartpl->output(\"".$vwartpl->get("admin_addteam")."\");");
}

// ################################### edit team #######################################
if ($GPC['action'] == "editteam")
{
	checkPermission("caneditteam");

	if ($GPC['add'] || $GPC['add_x'])
	{
		// check for wrong data
		if ($teamname == "")
		{
			$vwartpl->cache("admin_message_error_missingdata");
			eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
			eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_error_missingdata")."\");");
			exit;
		}

		$vwardb->query("
			UPDATE vwar".$n."_team
			SET
			teamname = '".$teamname."',
			invisible = '$hide',
			displayorder = '$displayorder'
			WHERE teamid = '".$GPC['teamid']."'
		");

		while (list($memberid) = each($teammember))
		{
			$result = $vwardb->query_first("
				SELECT COUNT(teammemberid) AS numteams
				FROM vwar".$n."_teammember
				WHERE memberid = '$memberid'
				AND teamid = '$teamid'
			");
			$membercheck = $result['numteams'];

			if (!$membercheck && $teammember[$memberid] == 1)
			{
				$vwardb->query("INSERT INTO vwar".$n."_teammember (memberid,teamid) VALUES ('$memberid', '$teamid')");
			}
			else if ($membercheck && $teammember[$memberid] == 0)
			{
				$vwardb->query("DELETE FROM vwar".$n."_teammember WHERE memberid = '$memberid' AND teamid = '$teamid'");
			}
		}
		header("Location: team.php?action=viewteams");
	}

	$row = $vwardb->query_first("SELECT * FROM vwar".$n."_team WHERE teamid = '".$GPC['teamid']."'");
	dbSelectForm($row);

	$teamname = $row['teamname'];
	$displayorder = $row['displayorder'];
	$hideteam = makeyesnocode("hide",$row['invisible']);

	$result = $vwardb->query("
		SELECT vwar".$n."_member.memberid, name, teammemberid, teamid
		FROM vwar".$n."_member
		LEFT JOIN vwar".$n."_teammember ON (vwar".$n."_member.memberid = vwar".$n."_teammember.memberid AND vwar".$n."_teammember.teamid = '".$GPC['teamid']."')
		WHERE ismember = '1'
		AND status <> '0'
		AND hidemember = '0'
		ORDER BY name ASC
	");
	while ($row = $vwardb->fetch_array($result))
	{
		dbSelect($row);
		switchColors();

		$isteammember = ifelse($row['teammemberid'] && $row['teamid'] == $teamid, 1, 0);
		$teammember = makeyesnocode("teammember[$row[memberid]]", $isteammember);

		eval ("\$admin_editteam_teammemberlistbit .= \"".$vwartpl->get("admin_editteam_teammemberlistbit")."\";");

		unset($teammember);
	}

	$vwartpl->cache("admin_editteam_teammemberlistbit,admin_editteam");
	eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
	eval("\$vwartpl->output(\"".$vwartpl->get("admin_editteam")."\");");
}

// ################################### delete team #####################################
if ($GPC['action'] == "deleteteam")
{
	checkPermission("candeleteteam");

	if ($delete)
	{
		$vwardb->query("DELETE FROM vwar".$n."_team WHERE teamid = '".$GPC['teamid']."'");
		$vwardb->query("DELETE FROM vwar".$n."_teammember WHERE teamid = '".$GPC['teamid']."'");
		$vwardb->query("DELETE FROM vwar".$n."_emailgroupmember WHERE teamid = '".$GPC['teamid']."'");

		header("Location: team.php?action=viewteams");
	}

	$vwartpl->cache("admin_message_delete");
	eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
	eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_delete")."\");");
}
?>