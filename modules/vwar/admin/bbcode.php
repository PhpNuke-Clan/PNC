<?php
/* #####################################################################################
 *
 * $Id: bbcode.php,v 1.44 2004/09/12 12:58:09 mabu Exp $
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

checkPermission("isadmin");

// #### FUNCTIONS ####
// some useful functions to handle the replacements in the codes
function handle_replacement_insert ( $num )
{
 global $GPC;

	if ( !empty($GPC["usefunction"]) )
	{
		return "{VWAR_BBCODE_FUNCTION_#$num}";
	}
	else
	{
		if ( $GPC["simplecode"] == 0 AND $GPC["params"] <= 1 )
		{
			return "\\\\$num";
		}
		else
		{
			return "\\\\" . ($num + 1);
		}
	}
}
function handle_replacement_select ( $num )
{
 global $row;

	if ( !empty($row["usefunction"]) )
	{
		return "\{$num}";
	}
	else
	{
		if ( $row["simplecode"] == 0 AND $row["params"] <= 1 )
		{
			return "\{$num}";
		}
		else
		{
			return "{" . ($num - 1) . "}";
		}
	}
}

// ####################################### bbcodelist ####################################
if ($GPC['action'] == "viewbbcode")
{
	//template-cache, standard-templates will be added by script:
	$vwartpllist="admin_bbcode_listbit,admin_bbcode_list";
	$vwartpl->cache($vwartpllist);

	eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");

	$result = $vwardb->query_first("SELECT COUNT(bbcodeid) AS num FROM vwar".$n."_bbcode");
	$numcodes = $result['num'];

	$result = $vwardb->query("
		SELECT code, displayorder, deleted, params, simplecode, bbcodeid
		FROM vwar".$n."_bbcode
		ORDER BY displayorder ASC, code ASC
		" . getLimitClause()
	);
	while ($row = $vwardb->fetch_array($result))
	{
		dbSelect($row);
		switchColors();

		$active = getActiveTag($row['deleted'], "BB Code");

		$tmp = "";
		if ( $row["params"] > 1 OR ($row["simplecode"] == 1 AND $row["params"] > 0) )
		{
			$tmp = "=<b> ... </b>";
			$startvalue = ($row["simplecode"] == 1) ? 2 : 3;
			for ($i = $startvalue; $i <= $row["params"]; $i++)
			{
				$tmp .= ",<b> ... </b>";
			}
		}
		if ( $row["simplecode"] == 0 )
		{
			$bbcode = "[" . $row["code"] . $tmp . "]<b> ... </b>[/" . $row['code'] . "]";
		}
		else
		{
			$bbcode = "[" . $row["code"] . $tmp . "]";
		}

		eval ("\$admin_bbcode_listbit .= \"".$vwartpl->get("admin_bbcode_listbit")."\";");
	}
	$pagelinks = makepagelinks($numcodes,$perpage,"action=viewbbcode");

	eval("\$vwartpl->output(\"".$vwartpl->get("admin_bbcode_list")."\");");
}

// #################################### add bbcode ###########################################
if ($GPC['action'] == "addbbcode")
{
	if ($GPC['add'] || $GPC['add_x'])
	{
		// check for wrong data
		if ( empty($GPC["tag"]) OR empty($GPC["replacement"]) OR !is_numeric($GPC["params"]) OR empty($GPC["example"]) )
		{
			$vwartpl->cache("admin_message_error_missingdata");
			eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
			eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_error_missingdata")."\");");
			exit;
		}

		$replacement = preg_replace ( "#\{(\d)+\}#esiU",
			"handle_replacement_insert('\\1')",
			$GPC["replacement"] );

		$vwardb->query("
			INSERT INTO vwar".$n."_bbcode
			( code, replacement, usefunction, simplecode, params, help, displayorder )
			VALUES (
				'" . trim ( $GPC["tag"] ) . "',
				'" . trim ( $replacement ) . "',
				'" . $GPC["usefunction"] . "',
				'" . $GPC["simplecode"] . "',
				'" . $GPC["params"] . "',
				'" . $GPC["example"] . "',
				'" . $GPC["displayorder"] . "'
			)
		");
		header("Location: bbcode.php?action=viewbbcode");
	}

	$vwartpl->cache("admin_addbbcode");
	eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
	eval("\$vwartpl->output(\"".$vwartpl->get("admin_addbbcode")."\");");
}

// ####################################### edit bbcode ####################################
if ($GPC['action'] == "editbbcode")
{
	if ($GPC['add'] || $GPC['add_x'])
	{
		// check for wrong data
		if ( empty($GPC["tag"]) OR empty($GPC["replacement"]) OR !is_numeric($GPC["params"]) OR empty($GPC["example"]) )
		{
			$vwartpl->cache("admin_message_error_missingdata");
			eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
			eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_error_missingdata")."\");");
			exit;
		}

		$replacement = preg_replace ( "#\{(\d)+\}#esiU",
			"handle_replacement_insert('\\1')",
			$GPC["replacement"] );

		$vwardb->query("
			UPDATE vwar".$n."_bbcode
			SET
			code         = '" . trim( $GPC["tag"] ) . "',
			replacement  = '" . trim ( $replacement ) . "',
			usefunction  = '" . $GPC["usefunction"] . "',
			params       = '" . $GPC["params"] . "',
			help         = '" . $GPC["example"] . "',
			displayorder = '" . $GPC["displayorder"] . "',
			simplecode   = '" . $GPC["simplecode"] . "',
			deleted      = '" . $GPC["deleted"] . "'
			WHERE bbcodeid = '" . $GPC["bbcodeid"] . "'
		");

		header("Location: bbcode.php?action=viewbbcode");
	}

	eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");

	$row = $vwardb->query_first("SELECT * FROM vwar".$n."_bbcode WHERE bbcodeid = '".$GPC['bbcodeid']."'");

	dbSelectForm($row);
	$deleted = makeyesnocode ("deleted", $row['deleted']);

	$replacement = preg_replace (
		"!(\{)*(\\\\|VWAR_BBCODE_FUNCTION_#)+?(\d)+?(\})*!esi",
		"handle_replacement_select('\\3')",
		$row["replacement"]
	);

	if ( $row["simplecode"] == 1 )
	{
		$selected = "selected";
	}

	$vwartpl->cache("admin_editbbcode");
	eval("\$vwartpl->output(\"".$vwartpl->get("admin_editbbcode")."\");");
}

// ##################################### delete bbcode ####################################
if ($GPC['action'] == "deletebbcode")
{
	if ($delete)
	{
		$vwardb->query("DELETE FROM vwar".$n."_bbcode WHERE bbcodeid = '".$GPC['bbcodeid']."'");
		header("Location: bbcode.php?action=viewbbcode");
	}
	$vwartpl->cache("admin_message_delete");
	eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
	eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_delete")."\");");
}

// ####################################### censor ######################################
if ($GPC['action'] == "censor")
{
	$example = "e.g.\r\n{ass=bottom}\r\n{fuck}\r\nidiot=not so intelligent\r\nshit";

	if ($GPC['add'] || $GPC['add_x'])
	{
		if ($words == $example)
		{
			$words = strchr($words,"{ass=bottom}");
		}

		$vwardb->query("
			UPDATE vwar".$n."_settings
			SET
			censor = '$censorselect',
			censorformembers = '$censorformembersselect',
			censorsign = '$censorsignselect',
			censorwords = '$words'
		");
		header("Location: bbcode.php?action=censor");
	}

	if ($censorwords == "")
	{
		$censorwords = $example;
	}
	$censorselect = makeyesnocode("censorselect",$censor);
	$censorformembersselect = makeyesnocode("censorformembersselect",$censorformembers);

	$vwartpl->cache("admin_censor");
	eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
	eval("\$vwartpl->output(\"".$vwartpl->get("admin_censor")."\");");
}
?>