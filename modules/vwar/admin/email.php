<?php
ob_start();
/* #####################################################################################
 *
 * $Id: email.php,v 1.42 2004/09/12 12:58:09 mabu Exp $
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
if ($GPC['action'] == "" || $GPC['action'] == "viewgroups")
{
	checkPermission("canaddmailgroup-caneditmailgroup-candeletemailgroup");
	// template-cache, standard-templates will be added by script:
	$vwartpllist = "admin_email_list,admin_email_listbit";
	$vwartpl->cache($vwartpllist);

	eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");

	// list groups
	$result = $vwardb->query("
		SELECT vwar".$n."_emailgroup.*, COUNT(vwar".$n."_emailgroupmember.groupmemberid) AS groups
		FROM vwar".$n."_emailgroup
		LEFT JOIN vwar".$n."_emailgroupmember ON (vwar".$n."_emailgroup.groupid = vwar".$n."_emailgroupmember.groupid)
		GROUP BY vwar".$n."_emailgroup.groupid
	");
	while ($row = $vwardb->fetch_array($result))
	{
		dbSelect($row);
		switchColors();

		eval("\$admin_email_listbit .= \"".$vwartpl->get("admin_email_listbit")."\";");
	}
	eval("\$vwartpl->output(\"".$vwartpl->get("admin_email_list")."\");");
}

// ################################### add group #####################################
if ($GPC['action'] == "addgroup")
{
	checkPermission("canaddmailgroup");

	if ($GPC['add'] || $GPC['add_x'])
	{
		// check for wrong data
		if (empty($groupname))
		{
			$vwartpl->cache("admin_message_error_missingdata");
			eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
			eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_error_missingdata")."\");");
			exit();
		}

		$result = $vwardb->query_first("
			SELECT COUNT(groupid) AS numgroups
			FROM vwar".$n."_emailgroup
			WHERE groupname = '".$groupname."'
		");
		$groupcheck = $result['numgroups'];

		if (!$groupcheck)
		{
			$vwardb->query("INSERT INTO vwar".$n."_emailgroup (groupname) VALUES ('".$groupname."')");
			$lastinsertid = $vwardb->insert_id();

			while (list($teamid,$value) = each($team))
			{
				if ($value)
				{
					$vwardb->query("INSERT INTO vwar".$n."_emailgroupmember (groupid,teamid) VALUES ('".$lastinsertid."','".$teamid."')");
				}
			}
		}
		header("Location: ".$GPC['PHP_SELF']."?action=viewgroups");
		exit();
	}

	// template-cache, standard-templates will be added by script:
	$vwartpllist = "admin_email_add,admin_email_teamlistbit";
	$vwartpl->cache($vwartpllist);

	eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");

	// get teams
	$result = $vwardb->query("SELECT teamid, teamname, invisible FROM vwar".$n."_team ORDER BY teamid ASC, teamname ASC");
	while ($row = $vwardb->fetch_array($result))
	{
		$teammember = makeyesnocode("team[".$row['teamid']."]",0);
		$statusimg = $row['invisible'] ? makeimgtag($vwar_root . "images/hiddenteam.gif","Hidden Team") : "";

		dbSelect($row);
		switchColors();

		eval("\$admin_email_teamlistbit .= \"".$vwartpl->get("admin_email_teamlistbit")."\";");
	}
	eval("\$vwartpl->output(\"".$vwartpl->get("admin_email_add")."\");");
}

// ################################### edit group #####################################
if ($GPC['action'] == "editgroup")
{
	checkPermission("caneditmailgroup");

	if ($GPC['add'] || $GPC['add_x'])
	{
		// check for wrong data
		if (empty($groupname))
		{
			$vwartpl->cache("admin_message_error_missingdata");
			eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
			eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_error_missingdata")."\");");
			exit();
		}

		$vwardb->query("UPDATE vwar".$n."_emailgroup SET groupname = '".$groupname."' WHERE groupid = '".$groupid."'");

		while (list($teamid,$value) = each($team))
		{
			$result = $vwardb->query_first("
				SELECT COUNT(groupmemberid) AS groubmembers
				FROM vwar".$n."_emailgroupmember
				WHERE teamid = '".$teamid."'
				AND groupid = '".$groupid."'
			");
			$teamcheck = $result['groubmembers'];

			if (!$teamcheck && $value == 1)
			{
				$vwardb->query("INSERT INTO vwar".$n."_emailgroupmember (groupid,teamid) VALUES ('".$groupid."','".$teamid."')");
			}
			else if ($teamcheck && $value == 0)
			{
				$vwardb->query("DELETE FROM vwar".$n."_emailgroupmember WHERE teamid = '".$teamid."' AND groupid = '".$groupid."'");
			}
		}
		header("Location: ".$GPC['PHP_SELF']."?action=viewgroups");
		exit();
	}

	// template-cache, standard-templates will be added by script:
	$vwartpllist = "admin_email_edit,admin_email_teamlistbit";
	$vwartpl->cache($vwartpllist);

	eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");

	// get group infos
	$result = $vwardb->query_first("SELECT groupname FROM vwar".$n."_emailgroup WHERE groupid = '".$groupid."'");
	$groupname = $result['groupname'];

	// get teams
	$result = $vwardb->query("
		SELECT vwar".$n."_team.teamname, vwar".$n."_team.teamid, vwar".$n."_team.invisible,
		vwar".$n."_emailgroupmember.teamid AS gteamid
		FROM vwar".$n."_team
		LEFT JOIN vwar".$n."_emailgroupmember ON (vwar".$n."_team.teamid = vwar".$n."_emailgroupmember.teamid AND vwar".$n."_emailgroupmember.groupid = ".$groupid.")
		ORDER BY vwar".$n."_team.teamid ASC, vwar".$n."_team.teamname ASC
	");
	while ($row = $vwardb->fetch_array($result))
	{
		$teammember = makeyesnocode("team[".$row['teamid']."]",ifelse($row['teamid'] == $row['gteamid'],1,0));
		$statusimg = $row['invisible'] ? makeimgtag($vwar_root . "images/hiddenteam.gif","Hidden Team") : "";

		dbSelect($row);
		switchColors();

		eval("\$admin_email_teamlistbit .= \"".$vwartpl->get("admin_email_teamlistbit")."\";");
	}
	eval("\$vwartpl->output(\"".$vwartpl->get("admin_email_edit")."\");");
}

// ################################### delete group #####################################
if ($GPC['action'] == "deletegroup")
{
	checkPermission("candeletemailgroup");

	if ($delete)
	{
		$vwardb->query("DELETE FROM vwar".$n."_emailgroup WHERE groupid = '".$groupid."'");
		$vwardb->query("DELETE FROM vwar".$n."_emailgroupmember WHERE groupid = '".$groupid."'");

		header("Location: ".$GPC['PHP_SELF']."?action=viewgroups");
		exit();
	}
	$vwartpl->cache("admin_message_delete");

	eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
	eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_delete")."\");");
}

// ################################### send mail #####################################
if ($GPC['action'] == "mail")
{
	checkPermission("cansendmembermail");

	$oldtext = $mailtext;

	if($send || $send_x)
	{
		// check for wrong data
		if (empty($sendas) || empty($priority) || empty($selectmode) || empty($subject) || empty($mailtext))
		{
			$vwartpl->cache("admin_message_error_missingdata");
			eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
			eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_error_missingdata")."\");");
			exit();
		}

		if (empty($ownmail)) $ownmail = "admin@yourdomain.com";
		if ($sendas == "html")
		{
						$mailtext = parseText($mailtext,0,0,1,1);
			if ($bbcode) $mailtext = strip_slashes($mailtext);
		}

		// selection mode
		$tempgroups = array();

		if ($selectmode == "member")
		{
			while (list($memberid,$value) = each($member))
			{
				if($value) array_push($tempgroups,$memberid);
			}
			$sendtype = "member";
		}
		else if ($selectmode == "group")
		{
			while (list($groupid,$value) = each($group))
			{
				if($value) array_push($tempgroups,$groupid);
			}
			$sendtype = "group";
		}
		else if ($selectmode == "allmembers")
		{
			$sendtype = "allmembers";
		}

		// send mail
		if (sendMemberMail($sendtype,$mailtext,$tempgroups,"",$sendas,$subject,"",$priority))
		{
			$vwartpl->cache("admin_email_membermailconfirm");
			eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
			eval("\$vwartpl->output(\"".$vwartpl->get("admin_email_membermailconfirm",1)."\");");
			exit;
		}
		else
		{
			$vwartpl->cache("admin_email_membermailfailed");
			$moreerrors = "<li>An error accrued during the mail process</li>";
						eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
			eval("\$vwartpl->output(\"".$vwartpl->get("admin_email_membermailfailed",1)."\");");
			exit;
		}
	}

	// template-cache, standard-templates will be added by script:
	$vwartpllist  = "admin_email_membermail,admin_selectbitdefault,admin_bbcodeoff,";
	$vwartpllist .= "admin_email_memberlistbit,admin_email_membermailselectpart,admin_email_grouplistbit,";
	$vwartpllist .= "admin_smilieson,admin_smiliesoff,admin_htmlcodeon,admin_htmlcodeoff,admin_bbcodeon";
	$vwartpllist .= "admin_bbcode,admin_bbcode_language,bbcode_javascript";
	$vwartpl->cache($vwartpllist);

	eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");

	$mailtext = dbSelectForm($oldtext);
	$subject = dbSelectForm($subject);

	unset($oldtext);

	eval("\$standardoption = \"".$vwartpl->get("admin_selectbitdefault")."\";");

	if (empty($sendas)) $sendas = "text";
	if (empty($priority)) $priority = 3;

	$selected[$selectmode] = "selected";
	$selected[$priority] = "selected";
	$selected[$sendas] = "selected";

	if($selectmode == "group")
	{
		$selecttitle = "Groups";
		$show = true;

		if (is_array($group))
		{
			foreach($group as $groupid => $value)
			{
				$groupstatus[$groupid] = $value;
			}
		}

		// get groups
		$result = $vwardb->query("SELECT groupname,groupid FROM vwar".$n."_emailgroup ORDER BY groupid ASC, groupname ASC");
		while ($row = $vwardb->fetch_array($result))
		{
			$group = makeyesnocode("group[".$row['groupid']."]",$groupstatus[$row['groupid']]);

			dbSelect($row);
			switchColors();

			eval("\$selectcontent .= \"".$vwartpl->get("admin_email_grouplistbit")."\";");
		}
	}
	else if ($selectmode == "member")
	{
		$selecttitle = "Members";
		$show = true;

		if (is_array($member))
		{
			foreach($member as $memberid => $value)
			{
				$memberstatus[$memberid] = $value;
			}
		}

		// get members
		$result = $vwardb->query("
			SELECT
			name, memberid, hidemember
			FROM vwar".$n."_member
			WHERE memberid != ".$GPC["vwarid"]."
			ORDER BY memberid ASC, name ASC
		");
		while ($row = $vwardb->fetch_array($result))
		{
			$member = makeyesnocode("member[".$row['memberid']."]",$memberstatus[$row['memberid']]);
			$statusimg = $row['hidemember'] ? makeimgtag($vwar_root . "images/hidden.gif","Hidden Member") : "";

			dbSelect($row);
			switchColors();

			eval("\$selectcontent .= \"".$vwartpl->get("admin_email_memberlistbit")."\";");
		}
	}

	if ($show) eval("\$smode = \"".$vwartpl->get("admin_email_membermailselectpart")."\";");

	if ($sendas != "html")
	{
		$nextcolor[1] = "secondalt";
	}
	else
	{
		getTextRestrictions("mailform","mailtext","secondalt",1);
	}

	eval("\$vwartpl->output(\"".$vwartpl->get("admin_email_membermail",1)."\");");
}
ob_end_flush();
?>