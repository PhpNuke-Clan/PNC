<?php
/* #####################################################################################
 *
 * $Id: template.php,v 1.44 2004/09/12 12:58:09 mabu Exp $
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

// ################################### view ############################################
if ($GPC['action'] == "" || !isset($GPC['action']))
{
	//template-cache, standard-templates will be added by script:
	$vwartpllist = "admin_templatebit,admin_templatelist,admin_templatelist_specialpart";
	$vwartpl->cache($vwartpllist);

	$result = $vwardb->query_first("
		SELECT count(templateid) AS numtemplates
		FROM vwar".$n."_template
		WHERE templatename NOT LIKE 'admin%'
		AND templatename <> 'copyright'
	");
	$numtemplates = $result['numtemplates'];

	$result = $vwardb->query("
		SELECT * FROM vwar".$n."_template
		WHERE templatename NOT LIKE 'admin%'
		AND templatename <> 'copyright'
		AND isspecial = '1'
		ORDER BY templatename ASC
	");
	while ($row = $vwardb->fetch_array($result))
	{
		switchColors();

		$active = getActiveTag($row['isinactive'], "Template");

		eval("\$admin_specialtemplatebit .= \"".$vwartpl->get("admin_templatebit")."\";");

		unset($isinactive);
	}
	eval("\$admin_templatelist_specialpart .= \"".$vwartpl->get("admin_templatelist_specialpart")."\";");

	$result = $vwardb->query("
		SELECT * FROM vwar".$n."_template
		WHERE templatename NOT LIKE 'admin%'
		AND templatename <> 'copyright'
		AND isspecial = '0'
		ORDER BY templatename ASC
		" . getLimitClause()
	);
	while ($row = $vwardb->fetch_array($result))
	{
		switchColors();

		$active = getActiveTag($row['isinactive'], "Template");

		eval("\$admin_templatebit .= \"".$vwartpl->get("admin_templatebit")."\";");

		unset($isinactive);
	}

	$pagelinks = makepagelinks($numtemplates,$perpage);

	eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
	eval("\$vwartpl->output(\"".$vwartpl->get("admin_templatelist")."\");");
}

// ################################### add #############################################
if ($GPC['action'] == "add")
{
	if ($GPC['add'] || $GPC['add_x'])
	{
		// check for wrong data
		if ($tplname == "" || $tpl == "")
		{
			$vwartpl->cache("admin_message_error_missingdata");
			eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
			eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_error_missingdata")."\");");
			exit;
		}
		$vwardb->query("
			INSERT INTO vwar".$n."_template
			(templatename,template,isspecial)
			VALUES
			('".$tplname."','".$tpl."','".$isspecial."')
		");

		header("Location: template.php");
	}

	$vwartpl->cache("admin_templateadd");

	$isspecial = makeyesnocode("isspecial",0);

	eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
	eval("\$vwartpl->output(\"".$vwartpl->get("admin_templateadd")."\");");
}

// ################################### modify ##########################################
if ($GPC['action'] == "edit")
{
	if ($GPC['add'] || $GPC['add_x'])
	{
		// check for wrong data
		if ($tplname=="" || ($tpl=="" && $restore != 1))
		{
			$vwartpl->cache("admin_message_error_missingdata");
			eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
			eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_error_missingdata")."\");");
			exit;
		}

		//restore the template to the original
		if($restore == 1)
		{
			$content = fileReader("../install/vwar_complete.style",1);

			eregi("~~~$tplname~~~([^~~~]*)~~~", $content, $oldtemplate);

			$tpl = addslashes ($oldtemplate[1]);

			if (!$tpl)
			{
				$vwartpl->cache("admin_template_restoreerror");
				eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
				eval("\$vwartpl->output(\"".$vwartpl->get("admin_template_restoreerror")."\");");
				exit;
			}
		}

		$vwardb->query("
			UPDATE vwar".$n."_template
			SET
			templatename	= '$tplname',
			template			= '" . trim($tpl) . "',
			isinactive		= '$isinactive',
			isspecial			= '$isspecial'
			WHERE templateid = '".$GPC['templateid']."'
		");

		header("Location: template.php");
	}
	$vwartpl->cache("admin_templateedit");
	eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");

	$row = $vwardb->query_first("SELECT * FROM vwar".$n."_template WHERE templateid = '".$GPC['templateid']."'");
	$row['template'] = dbSelectForm($row['template']);

	$isinactive = makeyesnocode("isinactive", $row['isinactive']);
	$isspecial 	= makeyesnocode("isspecial", $row['isspecial']);
	$restore 		= makeyesnocode("restore", 0);

	eval("\$vwartpl->output(\"".$vwartpl->get("admin_templateedit")."\",1);");
}
// ################################### delete ##########################################
if ($GPC['action'] == "delete")
{
	if ($delete)
	{
		$vwardb->query("DELETE FROM vwar".$n."_template WHERE templateid='".$GPC['templateid']."'");
		header("Location: template.php?s=$s&page=$page");
	}
	$vwartpl->cache("admin_message_delete");
	eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
	eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_delete")."\");");
}
// ################################### search ##########################################
if ($GPC['action'] == "search")
{
	//template-cache, standard-templates will be added by script:
	$vwartpllist = "admin_templatebit,admin_templatelist";
	$vwartpl->cache($vwartpllist);

	$result = $vwardb->query_first("
		SELECT count(templateid) AS numtemplates
		FROM vwar".$n."_template
		WHERE templatename NOT LIKE 'admin%'
		AND templatename <> 'copyright'
		AND templatename LIKE '%$searchtemplate%'
	");
	$numtemplates = $result['numtemplates'];

	$result = $vwardb->query("
		SELECT * FROM vwar".$n."_template
		WHERE templatename NOT LIKE 'admin%'
		AND templatename <> 'copyright'
		AND templatename LIKE '%$searchtemplate%'
		ORDER BY templatename ASC
		" . getLimitClause()
	);
	while ($row = $vwardb->fetch_array($result))
	{
		switchColors();

		//highlith searchstring
		$row['templatename'] = preg_replace("=".preg_quote($searchtemplate,'=')."=i","<font color=\"#F00000\"><b>$0</b></font>",$row['templatename']);

		$active = makeimgtag($vwar_root . "images/" .
			ifelse($row['isinactive'] == 1, "uncheck.gif", "check.gif"),
			ifelse($row['isinactive'] == 1, "Template is not active", "Template is active"));

		eval("\$admin_templatebit .= \"".$vwartpl->get("admin_templatebit")."\";");
	}

	$pagelinks = makepagelinks($numtemplates,$perpage,"action=search&amp;searchtemplate=$searchtemplate");

	eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
	eval("\$vwartpl->output(\"".$vwartpl->get("admin_templatelist")."\");");
}
?>