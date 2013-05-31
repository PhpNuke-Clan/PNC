<?php
/* #####################################################################################
 *
 * $Id: news.php,v 1.48 2004/09/12 12:58:09 mabu Exp $
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
$nomember			= "";
$updatestring	= "";

if (!checkCookie())
{
	header("Location: index.php");
}

// ################################### view news #######################################
if ($GPC['action'] == "" || !isset($GPC['action']))
{
	checkPermission ("canaddnews-caneditnews-candeletenews");

	//template-cache, standard-templates will be added by script:
	$vwartpllist = "admin_newslistbit,admin_newslist";
	$vwartpl->cache($vwartpllist);
	eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");

	$result = $vwardb->query_first("SELECT COUNT(newsid) AS numnews FROM vwar".$n."_news");
	$numnews = $result['numnews'];

	$result = $vwardb->query("
		SELECT submitinfo, vwar".$n."_news.newsid, submitname, dateline, activated, vwar".$n."_news.title,
			vwar".$n."_member.name, COUNT(linkid) AS totallinks, vwar".$n."_news.memberid
		FROM vwar".$n."_news
		LEFT JOIN vwar".$n."_member ON (vwar".$n."_news.memberid = vwar".$n."_member.memberid)
		LEFT JOIN vwar".$n."_newslink ON (vwar".$n."_news.newsid = vwar".$n."_newslink.newsid)
		WHERE vwar".$n."_news.memberid != '0'
		GROUP BY vwar".$n."_news.newsid
		ORDER BY dateline DESC
		" . getLimitClause()
	);
	while ($row = $vwardb->fetch_array($result))
	{
		dbSelect ($row);
		switchColors();

		$totallinks = $row['totallinks'];
		$newsdate = formatdatetime($row['dateline']);
		$active = getActiveTag(!$row['activated'], "BB Code");

		eval ("\$admin_newslistbit .= \"".$vwartpl->get("admin_newslistbit")."\";");
		unset($submitted);
	}
	$vwardb->free_result($result);

	$pagelinks = makepagelinks($numnews,$perpage);
	eval("\$vwartpl->output(\"".$vwartpl->get("admin_newslist")."\");");
}
// ################################### add news ########################################
if ($GPC['action'] == "add")
{
	checkPermission("canaddnews");

	if ($GPC['add'] || $GPC['add_x'])
	{
		// check for wrong data
		if ($GPC['title'] == "" || $GPC['catid'] == "" || $GPC['warinfo'] == "")
		{
			$vwartpl->cache("admin_message_error_missingdata");
			eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
			eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_error_missingdata")."\");");
			exit;
		}

		if ($GPC['submitid'])
		{
			$data = $vwardb->query_first("SELECT submitinfo FROM vwar".$n."_news WHERE newsid = '".$GPC['submitid']."'");
			$nomember = is_numeric($data['submitinfo'])
				? ", submitname = '', submitinfo = '', memberid = '".$data['submitinfo']."'"
				: ", memberid = '" . $GPC["vwarid"] . "'";

			$vwardb->query("
				UPDATE vwar".$n."_news
				SET
				title 					= '".$GPC['title']."',
				catid 					= '".$GPC['catid']."',
				content 				= '".$GPC['warinfo']."',
				converturls 		= '".$GPC['url']."',
				convertsmilies 	= '".$GPC['smilies']."',
				allowcomments 	= '".$GPC['comments']."',
				activated 			= '".$GPC['activated']."'
				{$nomember}
				WHERE newsid = '".$GPC['submitid']."'
				");
		}
		else
		{
			$vwardb->query("
				INSERT INTO vwar".$n."_news
				(catid, title, memberid, content, converturls, convertsmilies, allowcomments, activated, dateline)
				VALUES
				('".$GPC['catid']."' , '".$GPC['title']."' , '".$GPC['vwarid']."' ,
				'".$GPC['warinfo']."' , '".$GPC['url']."' , '".$GPC['smilies']."' ,
				'".$GPC['comments']."' , '".$GPC['activated']."' , '".time()."')
				");
		}
		header("Location: news.php");
	}

	//template-cache, standard-templates will be added by script:
	$vwartpllist = "admin_message_error_missingdata,admin_htmlcodeon,admin_htmlcodeoff,admin_smilieson,admin_smiliesoff,";
	$vwartpllist = "admin_bbcodeon,admin_bbcodeoff,news_catselectbit,admin_addnews,bbcode_javascript,admin_bbcode,";
	$vwartpllist = "admin_bbcode_language";
	$vwartpl->cache($vwartpllist);
	eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");

	getTextRestrictions();

	if (isset($GPC['submitid']) && is_numeric($GPC['submitid']))
	{
		$submit = $vwardb->query_first("
			SELECT title, catid, content, converturls, convertsmilies
			FROM vwar".$n."_news
			WHERE newsid = '".$GPC['submitid']."'");
	}

	$result = $vwardb->query("
		SELECT catid, catname
		FROM vwar".$n."_newscat
		ORDER BY catname ASC
	");
	while ($row = $vwardb->fetch_array($result))
	{
		$catid = $row['catid'];
		$catname = dbSelectForm($row['catname']);
		$selected = ($row['catid'] == $submit['catid']) ? "selected" : "";

		eval("\$catselectbit .= \"".$vwartpl->get("news_catselectbit")."\";");
	}

	$result = $vwardb->query_first("SELECT usemore, moresign FROM vwar".$n."_newssettings");
	dbSelect($result);

	if (($result['usemore'] == 1) && !empty($result['moresign']))
	{
		eval("\$moreinfo = \"".$vwartpl->get("admin_news_moreinfo")."\";");
	}

	$activated = makeyesnocode ( "activated" );
	$comments  = makeyesnocode ( "comments" );
	$urlsearch = makeyesnocode ( "url", ((isset($submit)) ? $submit['converturls'] : 1), 2 );
	$smilies   = makeyesnocode ( "smilies", ((isset($submit)) ? $submit['convertsmilies'] : 1), 2 );

	eval("\$vwartpl->output(\"".$vwartpl->get("admin_addnews")."\");");
}
// ################################### delete news #####################################
if ($GPC['action']=="delete")
{
	checkPermission("candeletenews");

	if ($delete)
	{
		$vwardb->query("DELETE FROM vwar".$n."_news WHERE newsid = '".$GPC['newsid']."'");
		$vwardb->query("DELETE FROM vwar".$n."_newslink WHERE newsid = '".$GPC['newsid']."'");

		$headerpage = ifelse($GPC['submits'] == 1, "news.php?action=viewsubmits", "news.php");
		header("Location: " . $headerpage);
	}

	$vwartpl->cache("admin_message_delete");
	eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
	eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_delete")."\");");
}
// ################################### edit news #######################################
if ($GPC['action'] == "edit")
{
	checkPermission("caneditnews");

	if ($GPC['add'] || $GPC['add_x'])
	{
		// check for wrong data
		if ($title == "" || $catid == "" || $comment == "")
		{
			$vwartpl->cache("admin_message_error_missingdata");
			eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
			eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_error_missingdata")."\");");
			exit;
		}

		$vwardb->query("
			UPDATE vwar".$n."_news
			SET
			catid          = '".$GPC['catid']."',
			title          = '".$GPC['title']."',
			content        = '".$GPC['comment']."',
			converturls    = '".$GPC['url']."',
			convertsmilies = '".$GPC['smilies']."',
			allowcomments  = '".$GPC['comments']."',
			activated      = '".$GPC['activated']."'
			WHERE newsid = '".$GPC['newsid']."'
		");
		header("Location: news.php");
	}

	//template-cache, standard-templates will be added by script:
	$vwartpllist = "admin_message_error_missingdata,admin_htmlcodeon,admin_htmlcodeoff,admin_smilieson,admin_smiliesoff,";
	$vwartpllist = "admin_bbcodeon,admin_bbcodeoff,news_catselectbit,admin_addnews,bbcode_javascript,admin_bbcode,";
	$vwartpllist = "admin_bbcode_language";
	$vwartpl->cache($vwartpllist);
	eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");

	$row = $vwardb->query_first("
		SELECT vwar".$n."_news.*, vwar".$n."_newscat.catid
		FROM vwar".$n."_news
		LEFT JOIN vwar".$n."_newscat ON (vwar".$n."_newscat.catid = vwar".$n."_news.catid)
		WHERE newsid = '".$GPC['newsid']."'
	");

	dbSelectForm($row);
	getTextRestrictions("vwarform","comment");

	$result = $vwardb->query("SELECT catid, catname FROM vwar".$n."_newscat ORDER BY catname ASC");
	while ($cat = $vwardb->fetch_array($result))
	{
		dbSelectForm($cat);
		$catid = $cat['catid'];
		$catname = $cat['catname'];
		$selected = ifelse ($catid == $row['catid'], "selected");

		eval("\$catselectbit .= \"".$vwartpl->get("news_catselectbit")."\";");
	}

	$result = $vwardb->query_first("SELECT usemore, moresign FROM vwar".$n."_newssettings");
	dbSelect($result);

	if (($result['usemore'] == 1) && !empty($result['moresign']))
	{
		eval("\$moreinfo = \"".$vwartpl->get("admin_news_moreinfo")."\";");
	}

	$activated = makeyesnocode("activated",$row['activated']);
	$comments  = makeyesnocode("comments",$row['allowcomments']);
	$urlsearch = makeyesnocode("url",$row['converturls'],2);
	$smilies   = makeyesnocode("smilies",$row['convertsmilies'],2);

	eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
	eval("\$vwartpl->output(\"".$vwartpl->get("admin_editnews")."\");");
}
// ################################### view categories #################################
if ($GPC['action'] == "viewcategories")
{
	checkPermission ("canaddcategory-caneditcategory-candeletecategory");
	$vwartpl->cache("admin_categorylistbit,admin_categorylist");
	eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");

	$result = $vwardb->query("SELECT catid, catname FROM vwar".$n."_newscat ORDER BY catname ASC");
	while ($row = $vwardb->fetch_array($result))
	{
		switchColors();
		dbSelect($row);

		eval("\$admin_categorylistbit .= \"".$vwartpl->get("admin_categorylistbit")."\";");
	}

	eval("\$vwartpl->output(\"".$vwartpl->get("admin_categorylist")."\");");
}
// ################################### add category ####################################
if ($GPC['action'] == "addcategory")
{
	checkPermission("canaddcategory");
	if ($add)
	{
		// check for wrong data
		if ($catname == "" || ($transfer == "local" && ($image == "" || !@file_exists($vwar_root . "images/newsicons/" . $image)))
			|| ($transfer == "upload" && (!$HTTP_POST_FILES['filename']['name'] || !$HTTP_POST_FILES['filename']['tmp_name'])))
		{
			eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
			eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_error_missingdata")."\");");
			exit;
		}

		if ($transfer == "local")
		{
			$vwardb->query("
				INSERT INTO vwar".$n."_newscat
				(catname , caticon , intern)
				VALUES
				('".$catname."' , '".$image."' , '$intern')
			");
		}
		else if ($transfer == "upload")
		{
			$vwardb->query("INSERT INTO vwar".$n."_newscat (catname,intern) VALUES ('".$catname."','$intern')");
			$insertid = $vwardb->insert_id();

			$filename = $insertid . "_" . strtolower($HTTP_POST_FILES['filename']['name']);

			$upload->doUpload($HTTP_POST_FILES['filename'], $vwar_root . "images/newsicons/", 0, 0, $insertid . "_");

			$vwardb->query("UPDATE vwar".$n."_newscat SET caticon='$filename' WHERE catid = '$insertid'");
		}
		header("Location: news.php?action=viewcategories");
	}
	else
	{
		$vwartpl->cache("admin_addcategory");
		eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
		eval("\$vwartpl->output(\"".$vwartpl->get("admin_addcategory")."\");");
	}
}
// ################################### edit category ###################################
if ($GPC['action'] == "editcategory")
{
	checkPermission("caneditcategory");

	if ($GPC['add'] || $GPC['add_x'])
	{
		// check for wrong data
		if ($catname=="" || ($filepath=="" && !@file_exists($vwar_root . "images/newsicons/".$filepath) && empty($filename))
			|| (!empty($filename) && (!$HTTP_POST_FILES['filename']['name'] || !$HTTP_POST_FILES['filename']['tmp_name'])))
		{
			$vwartpl->cache("admin_message_error_missingdata");
			eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
			eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_error_missingdata")."\");");
			exit;
		}

		$catid = $GPC['catid'];
		$result = $vwardb->query_first("SELECT caticon FROM vwar".$n."_newscat WHERE catid = '$catid'");
		$oldicon = $result['caticon'];

		if (!empty($filename))
		{
			$filepath = $catid . "_".strtolower($HTTP_POST_FILES['filename']['name']);

			if ($oldicon != "")
			{
				@unlink($vwar_root . "images/newsicons/$oldicon");
			}

			$upload->doUpload($HTTP_POST_FILES['filename'], $vwar_root . "images/newsicons/", 0, 0, $catid . "_");
		}
		else if ($oldicon != $filepath && $oldicon != "")
		{
			@unlink($vwar_root . "images/newsicons/$oldicon");
		}

		$vwardb->query("UPDATE vwar".$n."_newscat
		SET
			catname = '".$catname."',
			caticon = '".$filepath."',
			intern  = '$hide'
		WHERE catid = '$catid'");

		header("Location: news.php?action=viewcategories");
	}
	else
	{
		$vwartpl->cache("admin_editcategory");
		$row = $vwardb->query_first("
			SELECT catname, caticon, intern
			FROM vwar".$n."_newscat
			WHERE catid = '".$GPC['catid']."'
		");
		dbSelectForm($row);

		$hide    = makeyesnocode("hide", $row['intern']);
		$caticon = makeimgtag($vwar_root . "images/newsicons/" . $row['caticon'], $row['catname']);

		eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
		eval("\$vwartpl->output(\"".$vwartpl->get("admin_editcategory")."\");");
	}
}
// ################################### delete category #################################
if ($GPC['action'] == "deletecategory")
{
	checkPermission("candeletecategory");

	if ($delete)
	{
		$vwartpl->cache("admin_message_filesystem");
		eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
		eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_filesystem")."\");");
		exit;
	}

	if ($filesystem)
	{
		if ($filesystem == "Yes")
		{
			$result=$vwardb->query_first("
				SELECT caticon
				FROM vwar".$n."_newscat
				WHERE catid = '".$GPC['catid']."'
			");
			$icon = $result['caticon'];

			@unlink($vwar_root . "images/newsicons/".$icon);
		}

		$vwardb->query("DELETE FROM vwar".$n."_newscat WHERE catid = '".$GPC['catid']."'");

		header("Location: news.php?action=viewcategories");
	}

	$vwartpl->cache("admin_message_delete,admin_message_delete_entries");

	// check for other entries with this one
	$checkentries = $vwardb->query_first("SELECT COUNT(newsid) AS numnews FROM vwar".$n."_news WHERE catid = '".$GPC['catid']."'");

	if ($checkentries['numnews'] > 0)
	{
		$numentries = $checkentries['numnews'];
		eval("\$admin_message_delete_entries = \"".$vwartpl->get("admin_message_delete_entries")."\";");
	}

	eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
	eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_delete")."\");");
}
// ################################### view links ######################################
if ($GPC['action'] == "viewlinks")
{
	checkPermission ("canaddnews-caneditnews-candeletenews");

	$vwartpl->cache("admin_linklistbit,admin_linklist");

	$result = $vwardb->query("SELECT * FROM vwar".$n."_newslink WHERE newsid = '".$GPC['newsid']."' ORDER BY title ASC");
	while ($row = $vwardb->fetch_array($result))
	{
		dbSelect($row);
		switchColors();

		eval("\$admin_linklistbit .= \"".$vwartpl->get("admin_linklistbit")."\";");
	}

	eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
	eval("\$vwartpl->output(\"".$vwartpl->get("admin_linklist")."\");");
}
// ################################### add link ########################################
if ($GPC['action'] == "addlink")
{
	checkPermission("canaddnews");

	if ($add)
	{
		// check for wrong data
		if ($title == "" || $url == "")
		{
			$vwartpl->cache("admin_message_error_missingdata");
			eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
			eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_error_missingdata")."\");");
			exit;
		}

		$url = ($check == 1) ? checkUrlFormat($url) : $url;

		$vwardb->query("
			INSERT INTO vwar".$n."_newslink
			(newsid,title,url,target)
			VALUES (
			'".$GPC['newsid']."',
			'".$title."',
			'".$url."',
			'".$target."')
		");

		header("Location: news.php");
	}
	else
	{
		$vwartpl->cache("admin_addlink");
		eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
		eval("\$vwartpl->output(\"".$vwartpl->get("admin_addlink")."\");");
	}
}
// ################################### edit link #######################################
if ($GPC['action'] == "editlink")
{
	checkPermission("caneditnews");

	if ($add)
	{
		// check for wrong data
		if ($title == "" || $url == "")
		{
			$vwartpl->cache("admin_message_error_missingdata");
			eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
			eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_error_missingdata")."\");");
			exit;
		}

		$url = ($check == 1) ? checkUrlFormat($url) : $url;

		$vwardb->query("
			UPDATE vwar".$n."_newslink
			SET
			title = '".$title."',
			url = '".$url."',
			target = '".$target."'
			WHERE linkid = '".$GPC['linkid']."'
		");

		header("Location: news.php?action=viewlinks&newsid=".$GPC['newsid']."");
	}
	else
	{
		$vwartpl->cache("admin_editlink");

		$row = $vwardb->query_first("SELECT * FROM vwar".$n."_newslink WHERE linkid = '".$GPC['linkid']."'");
		dbSelectForm($row);

		$selected[$row['target']] = "selected";

		eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
		eval("\$vwartpl->output(\"".$vwartpl->get("admin_editlink")."\");");
	}
}
// #################################### delete link ####################################
if ($GPC['action'] == "deletelink")
{
	checkPermission("candeletenews");

	if ($delete)
	{
		$vwardb->query("DELETE FROM vwar".$n."_newslink WHERE linkid = '".$GPC['linkid']."'");

		header("Location: news.php?action=viewlinks&newsid = ".$GPC['newsid']."");
	}
	else
	{
		eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
		eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_delete")."\");");
	}
}
// ################################### view submitted ##################################
if ($GPC['action'] == "viewsubmits")
{
	checkPermission ("canaddnews");

	//template-cache, standard-templates will be added by script:
	$vwartpllist = "admin_news_submitlistbit,admin_news_submitlist";
	$vwartpl->cache($vwartpllist);
	eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");

	$result = $vwardb->query_first("
		SELECT COUNT(newsid) AS numnews
		FROM vwar".$n."_news
		WHERE memberid = '0'
	");
	$numnews = $result['numnews'];

	$result = $vwardb->query("
		SELECT dateline, vwar".$n."_news.newsid, vwar".$n."_news.title, submitinfo, submitname, catname
		FROM vwar".$n."_news
		LEFT JOIN vwar".$n."_newscat ON (vwar".$n."_news.catid = vwar".$n."_newscat.catid)
		WHERE memberid = '0'
		" . getLimitClause()
	);
	while ($row = $vwardb->fetch_array($result))
	{
		dbSelect ($row);
		switchColors();

		$row['name'] = ifelse(is_numeric($row['submitinfo']), $row['submitname'] . " (Member)", makelink ("mailto:" . $row['submitinfo'] . "?subject=Virtual War Submit News", $row['submitname']));
		$newsdate = formatdatetime($row['dateline']);

		eval ("\$admin_newslistbit .= \"".$vwartpl->get("admin_news_submitlistbit")."\";");
	}

	$pagelinks = makepagelinks($numnews, $perpage);
	eval("\$vwartpl->output(\"".$vwartpl->get("admin_news_submitlist")."\");");
}
// ################################### submit details ####################################
if ($GPC['action'] == "submitdetails")
{
	checkPermission ("canaddnews");

	//template-cache, standard-templates will be added by script:
	$vwartpllist = "admin_news_submitdetails,admin_news_submitdetails_linkbit";
	$vwartpl->cache($vwartpllist);
	eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");

	$row = $vwardb->query_first ("
		SELECT dateline, submitname, content, convertsmilies, converturls,
			vwar".$n."_news.newsid, vwar".$n."_news.title, submitinfo, catname, COUNT(linkid) AS totallinks
		FROM vwar".$n."_news
		LEFT JOIN vwar".$n."_newslink ON (vwar".$n."_news.newsid = vwar".$n."_newslink.newsid)
		LEFT JOIN vwar".$n."_newscat ON (vwar".$n."_news.catid = vwar".$n."_newscat.catid)
		WHERE memberid = '0'
		AND vwar".$n."_news.newsid = '".$GPC['newsid']."'
		GROUP BY vwar".$n."_news.newsid
	");
	dbSelect($row);

	$newsdate = formatdatetime ($row['dateline']);

	$row['content'] = parseText($row['content'], 1, $row['convertsmilies'], 1, 1, $row['converturls']);

	$row['name'] = ifelse(is_numeric ($row['submitinfo']), $row['submitname'] . " (Member)", makelink ("mailto:" . $row['submitinfo'] . "?subject=Virtual War Submit News", $row['submitname']));

	eval("\$vwartpl->output(\"".$vwartpl->get("admin_news_submitdetails")."\");");
}
// ################################### news settings #####################################
if ($GPC['action'] == "settings")
{
	checkPermission("isadmin");

	if ($GPC['add'] || $GPC['add_x'])
	{
		while (list($settingname, $settingvalue) = each($setting))
		{
			$updatestring .= $settingname . "='" . $settingvalue . "',";
		}

		$updatestring .= "newsstatusmessage = '".$newsstatusmessage."'";

		$vwardb->query("UPDATE vwar".$n."_newssettings SET ".$updatestring);

		header("Location: news.php?action=settings");
	}

	//template-cache, standard-templates will be added by script:
	$vwartpllist="admin_newssettings";
	$vwartpl->cache($vwartpllist);

	eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");

	$row = $vwardb->query_first("SELECT * FROM vwar".$n."_newssettings");
	while (list($key,) = each($row))
	{
		$settingname = $key;
		$settingsvalue[$settingname]=$row[$settingname];

		if ($settingname == "usemore" || "allowsendafriend" || "allowsubmit" || "showticker")
		{
			$$settingname=makeyesnocode("setting[$settingname]",$settingsvalue[$settingname]);
		}

		if ($settingname == "newsstatus")
		{
			$checked[$settingsvalue[$settingname]] = "selected";
		}

		// get categories
		if ($settingname == "standardcatintern")
		{
			$result2 = $vwardb->query("SELECT catid, catname FROM vwar".$n."_newscat ORDER BY catname ASC");
			while ($category = $vwardb->fetch_array($result2))
			{
				$catid = $category['catid'];
				$catname = dbSelectForm($category['catname']);

				eval("\$catselectbit_intern .= \"".$vwartpl->get(ifelse($catid == $settingsvalue[$settingname], "news_catselectbit2", "news_catselectbit"))."\";");
			}
		}

		if ($settingname == "standardcatpublic")
		{
			$result2 = $vwardb->query("
				SELECT catid,catname
				FROM vwar".$n."_newscat
				WHERE intern != '1'
				ORDER BY catname ASC
			");
			while($category = $vwardb->fetch_array($result2))
			{
				$catid = $category['catid'];
				$catname = dbSelectForm($category['catname']);

				eval("\$catselectbit_public .= \"".$vwartpl->get(ifelse($catid == $settingsvalue[$settingname], "news_catselectbit2", "news_catselectbit"))."\";");
			}
		}
	}

	getTextRestrictions("vwarform","newsstatusmessage","secondalt");

	eval("\$vwartpl->output(\"".$vwartpl->get("admin_newssettings")."\");");
}
?>