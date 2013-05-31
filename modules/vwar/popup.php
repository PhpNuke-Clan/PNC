<?php
/* #####################################################################################
 *
 * $Id: popup.php,v 1.24 2004/02/21 18:17:54 mabu Exp $
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
$module_name = basename(dirname(__FILE__));
$vwar_root = "modules/" . basename(dirname(__FILE__)) ."/";
$vwarmod = $module_name;
require($vwar_root . "modname.php");
require($vwar_root . "includes/functions_common.php"); 
require($vwar_root . "includes/functions_front.php"); 

// ####################################### smilies #####################################
if ($GPC['action'] == "smilies")
{
	//template-cache:
	$vwartpllist="smilie_header,smilie_smiliebit,smilie";
	$vwartpl->cache($vwartpllist);

	eval("\$vwartpl->output(\"".$vwartpl->get("smilie_header")."\");");

	$result = $vwardb->query("SELECT * FROM vwar".$n."_smilie WHERE deleted = '0'");
	while ($row = $vwardb->fetch_array($result))
	{
		switchColors();

		eval ("\$smilie_bit .= \"<tr>".$vwartpl->get("smilie_smiliebit")."\";");

		$row = $vwardb->fetch_array($result);

		eval ("\$smilie_bit .= \"".$vwartpl->get("smilie_smiliebit")."</tr>\";");
	}
	$vwardb->free_result($result);

	eval("\$vwartpl->output(\"".$vwartpl->get("smilie")."\");");
	eval("\$vwartpl->output(\"".$vwartpl->get("copyright")."\");");
}
// ######################################## bbcode #####################################
if ($GPC['action'] == "bbcode")
{
	//template-cache:
	$vwartpllist="bbcode_help,bbcode_helpbit,bbcode_help_images";
	$vwartpl->cache($vwartpllist);

	$result = $vwardb->query("
		SELECT code, params, help, simplecode
		FROM vwar".$n."_bbcode
		WHERE deleted = '0'
		ORDER BY displayorder
	");
	while ( $row = $vwardb->fetch_array($result) )
	{
		// set html code temporarily to 1,
		// for correct display of the special chars
		$htmlcode = 1;

		$parsedtext = parseText ($row['help'], "", 0);

		$row["help"] = htmlspecialchars($row["help"]);

		// set code
		$tmp = "";
		if ( $row["params"] > 1 OR ($row["simplecode"] == 1 AND $row["params"] > 0) )
		{
			$tmp = "=...";
			$startvalue = ($row["simplecode"] == 1) ? 2 : 3;
			for($i=$startvalue; $i<=$row["params"]; $i++)
			{
				$tmp .= ",...";
			}
		}
		if ( $row["simplecode"] == 0 )
		{
			$setcode = "[" . $row["code"] . $tmp . "]...[/" . $row['code'] . "]";
		}
		else
		{
			$setcode = "[" . $row["code"] . $tmp . "]";
		}

		eval ("\$bit .= \"".$vwartpl->get("bbcode_helpbit")."\";");
	}

	eval("\$vwartpl->output(\"".$vwartpl->get("bbcode_help")."\");");
	eval("\$vwartpl->output(\"".$vwartpl->get("copyright")."\");");
}
// ####################################### memberpic ###################################
if ($GPC['action'] == "memberpic")
{
	$result = $vwardb->query_first("SELECT name, picture FROM vwar".$n."_member WHERE memberid = '".$GPC['memberid']."'");
	$name = $result['name'];
	$memberpicture = makeimgtag($vwar_root . "images/member/".$result['picture'],$name);

	eval("\$vwartpl->output(\"".$vwartpl->get("header")."\");");
	eval("\$vwartpl->output(\"".$vwartpl->get("member_viewpicture")."\");");
	eval("\$vwartpl->output(\"".$vwartpl->get("copyright")."\");");
}
// ####################################### print news ###################################
if ($GPC['action'] == "printnews")
{
	$row = $vwardb->query_first("
		SELECT vwar".$n."_news.*, vwar".$n."_member.email, vwar".$n."_member.name, vwar".$n."_newscat.catname
		FROM vwar".$n."_news
		LEFT JOIN vwar".$n."_member ON (vwar".$n."_news.memberid = vwar".$n."_member.memberid
			OR vwar".$n."_news.submitinfo = vwar".$n."_member.memberid)
		LEFT JOIN vwar".$n."_newscat ON (vwar".$n."_news.catid = vwar".$n."_newscat.catid)
		WHERE activated = '1'
		AND newsid = '".$GPC['newsid']."'
	");
	dbSelect($row);

	$row['dateline'] = formatdatetime($row['dateline']);
	$row['content']  = parseText($row['content'],1,$row['convertsmilies'],1,1,$row['converturls']);
	$newslink        = checkUrlFormat(checkPath($ownhomepage))."modules.php?name=$module_name&file=news&newsid=".$GPC['newsid'];
	$pagelink        = checkUrlFormat($ownhomepage);

	if ($row['memberid'] == 0)
	{
		$issubmitted = $str['SUBMITTED'];
		if (empty($row['email']))
		{
			$row['name'] = $row['submitname'];
			$row['email'] = $row['submitinfo'];
		}
	}

	$result2 = $vwardb->query("
		SELECT title, url, target
		FROM vwar".$n."_newslink
		WHERE newsid = '".$row['newsid']."'
	");
	$numlinks = $vwardb->num_rows($result2);

	if ($numlinks > 0)
	{
		while ($link = $vwardb->fetch_array($result2))
		{
			eval ("\$linkbit .= \"".$vwartpl->get("news_printlinkbit")."\";");
		}
		eval ("\$links = \"".$vwartpl->get("news_printlinks")."\";");
	}

	eval("\$vwartpl->output(\"".$vwartpl->get("news_printnews")."\");");
}
?>