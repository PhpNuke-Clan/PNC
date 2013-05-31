<?php
/* #####################################################################################
 *
 * $Id: screenshot.php,v 1.36 2004/03/18 11:02:27 mabu Exp $
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

checkPermission("canfinishwar");

$row = $vwardb->query_first("
	SELECT oppnameshort, dateline
	FROM vwar".$n.",vwar".$n."_opponents
	WHERE vwar".$n.".oppid = vwar".$n."_opponents.oppid
	AND warid = '".$GPC['warid']."'
");
$oppnameshort = $row['oppnameshort'];
$wardate = date($shortdateformat, $row['dateline']);

// ################################### list screenshots #################################
if ($GPC['action'] == "viewscreenshots")
{
	eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");

	$result=$vwardb->query("
		SELECT vwar".$n."_scores.scoreid, vwar".$n."_locations.locationname, screenid
		FROM vwar".$n."_scores
		LEFT JOIN vwar".$n."_locations ON (vwar".$n."_scores.locationid = vwar".$n."_locations.locationid)
		WHERE vwar".$n."_scores.warid = '".$GPC['warid']."'
	");
	while ($row = $vwardb->fetch_array($result))
	{
		dbSelect($row);
		switchColors();

		$screenshot = makeimgtag($vwar_root . "images/" . ifelse($row['screenid'], "check", "uncheck") . ".gif");

		eval ("\$admin_screenlistbit .= \"".$vwartpl->get("admin_screenlistbit")."\";");
	}
	eval("\$vwartpl->output(\"".$vwartpl->get("admin_screenlist")."\");");
}

// ################################### modify screenshot ###############################
if ($GPC['action'] == "editscreenshot")
{

	//template-cache, standard-templates will be added by script:
	$vwartpllist="admin_screenlistbit,admin_screenlist";
	$vwartpl->cache($vwartpllist);

	if ($GPC['add'] || $GPC['add_x'])
	{
		// set upload path
		$uploadpath = $vwar_root . "images/screen/";

		$count = 1;

		$result = $vwardb->query_first("SELECT locationid FROM vwar".$n."_scores WHERE scoreid = '".$scoreid."'");
		$locationid = $result['locationid'];

		$row = $vwardb->query_first("SELECT filename FROM vwar".$n."_screen WHERE warid = '".$GPC['warid']."' AND scoreid = '$scoreid'");
		$picture = $row['filename'];

		if ($GPC['screendeleted'] == 1 && $picture )
		{
			$vwardb->query("UPDATE vwar".$n."_scores SET screenid='0' WHERE warid = '".$GPC['warid']."' AND scoreid = '".$GPC['scoreid']."'");
			$vwardb->query("DELETE FROM vwar".$n."_screen WHERE warid = '".$GPC['warid']."' AND scoreid = '".$GPC['scoreid']."'");

			@unlink($uploadpath . $picture);
			@unlink($uploadpath . "th_". $picture);

		}
		if ($HTTP_POST_FILES['userfile']['name'] != $picture && !empty($HTTP_POST_FILES['userfile']['name']))
		{
			if ($HTTP_POST_FILES['userfile']['name'])
			{
				$HTTP_POST_FILES['userfile']['name'] = $warid . "-" . $locationid . "_" . $GPC['scoreid']
					. strtolower(strrchr($HTTP_POST_FILES['userfile']['name'],"."));

				$vwardb->query("DELETE FROM vwar".$n."_screen WHERE warid = '".$GPC['warid']."' AND scoreid = '".$GPC['scoreid']."'");

				@unlink($uploadpath . $picture);
				@unlink($uploadpath . "th_". $picture);
			}

			if ($upload->doUpload($HTTP_POST_FILES['userfile'], $uploadpath, 1, $GPC['autoresize']))
			{
				$vwardb->query("
					INSERT INTO vwar".$n."_screen
					(locationid,warid,scoreid,filename)
					VALUES (
					'$locationid',
					'".$GPC['warid']."',
					'".$GPC['scoreid']."',
					'".$HTTP_POST_FILES['userfile']['name']."')
				");
				$screenid = $vwardb->insert_id();

				$vwardb->query("UPDATE vwar".$n."_scores SET screenid = '$screenid' WHERE scoreid = '".$GPC['scoreid']."'");
			}
		}
		header("Location: screenshot.php?action=viewscreenshots&warid=".$GPC['warid']);
	}
	else
	{
		// set image path
		$imagepath = $vwar_root . "images/screen/";

		$row = $vwardb->query_first("
			SELECT vwar".$n."_scores.scoreid, vwar".$n."_screen.screenid, filename, vwar".$n."_locations.locationname
			FROM vwar".$n."_scores
			LEFT JOIN vwar".$n."_screen ON (vwar".$n."_screen.scoreid = vwar".$n."_scores.scoreid)
			LEFT JOIN vwar".$n."_locations ON (vwar".$n."_scores.locationid = vwar".$n."_locations.locationid)
			WHERE vwar".$n."_scores.scoreid = '".$GPC['scoreid']."'
		");

		if ($row['screenid'])
		{
			if (@file_exists($imagepath . "th_" . $row['filename']))
			{
				$screenshot=makeimgtag($imagepath . "th_" . $row['filename'], $row['locationname']);
			} else if (@file_exists($imagepath . $row['filename'])) {
				$screenshot=makeimgtag($imagepath . $row['filename'], $row['locationname'],"");
			} else {
				$screenshot = "no screenshot available";
			}
		}	else {
			$screenshot = "-";
		}

		$autoresize = makeyesnocode("autoresize",0);
		$screendeleted = makeyesnocode("screendeleted",0);

		eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
		eval("\$vwartpl->output(\"".$vwartpl->get("admin_editscreenshot")."\");");
	}
}
?>