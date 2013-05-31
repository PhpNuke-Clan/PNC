<?php
/* #####################################################################################
*
* $Id: functions_comments.php,v 1.18 2004/07/23 11:56:54 mabu Exp $
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

/*
 * ------------------------------------------------------------------------------------
 * includes/functions_comments.php
 * ------------------------------------------------------------------------------------
 * Comment Engine
 * Handles any aspect of the comment engine
 *
 * if you want to use it in your script
 * ------------------------------------
 * define an array with the following allowed arguments:
 *
 * $comments = array (
 *	sourceid     = the id of the entry the comments are for (e.g. the warid or newsid)
 *	frompage     = to seperate the comments in the database (always use the same for the same use !!!)
 *	title        = main title of the comments (e.g. War Comments)
 *	commenttitle = title of the comments (e.g. War against =O= (26.09.2003))
 *	returnttitle = title of the return link (e.g. Back to Wardetails)
 *	returnurl    = url of the return link (e.g. war.php?action=details&warid=211)
 *
 *  optional:
 *  ---------
 *	allowadd     = detects if it is allowed to add new comments (1=allowed / anything else=forbidden)
 *	command      = execute this command: add comment -> add, edit comment -> edit, delete comment -> del,
 *                       show ip -> showip, display -> leave empty
 * )
 *
 * all you have to do now, is to include this file:
 * include("includes/functions_comments.php");
 *
*/

// beware of cross-site-scripting attacks
if (VWAR_COMMON_INCLUDED != 1)
{
	die("<p style=\"FONT-FAMILY:verdana,tahoma,arial,sans-serif;FONT-SIZE:13px;\">Hacking attempt!</p>\n");
}

## -------------------------------------------------------------------------------------------------------------- ##

// prepare the params...
foreach ($comments AS $name => $val)
{
	$$name = (!empty($val)) ? $val : "";
}
if (empty($allowadd)) $allowadd = 1;

// prepare query string
$searcharray  = array( "/(&|&amp;)?page=[^&]*/" , "/(&|&amp;)?s=[^&]*/" , "/(&|&amp;)?quote=[^&]*/" );

if (($GPC['cmd'] != "del" && $command != "del") || isset($GPC['delete']))
{
	$searcharray[] = "/(&|&amp;)?cmd=[^&]*/";
	$searcharray[] = "/(&|&amp;)?cid=[^&]*/";
}

$GPC['QUERY_STRING'] = preg_replace($searcharray,"",$GPC['QUERY_STRING']);

if(substr($GPC['QUERY_STRING'],0,1) == "&")
{
	$GPC['QUERY_STRING'] = substr_replace($GPC['QUERY_STRING'],"",0,1);
}

## -------------------------------------------------------------------------------------------------------------- ##

function getCommentPermission ($permissionarea="canmanagecomments")
{
	global $vwardb,$n,$GPC,$vwarmod;

	$admin = $vwardb->query_first("
		SELECT ".$permissionarea."
		FROM vwar".$n."_accessgroup,vwar".$n."_member
		WHERE memberid = '".$GPC['vwarid']."'
		AND vwar".$n."_accessgroup.accessgroupid = vwar".$n."_member.accessgroupid
	");
	if ($admin['canmanagecomments'] == 1)
	{
		return true;
	} else {
		return false;
	}
}

## -------------------------------------------------------------------------------------------------------------- ##

function getShortMemberProfile ($memberid)
{
	global $vwardb,$n,$membercache,$vwar_root,$vwarmod;

	if (!count($membercache[$memberid]))
	{
		$getmember = $vwardb->query_first("
			SELECT *
			FROM vwar".$n."_member,vwar".$n."_memberstatus,vwar".$n."_accessgroup
			WHERE memberid = '".$memberid."'
			AND vwar".$n."_member.status = vwar".$n."_memberstatus.statusid
		");
		$membercache[$memberid] = $getmember;
	}

	return $membercache[$memberid];
}

## -------------------------------------------------------------------------------------------------------------- ##

// ##################### add ############################
if ($GPC['cmd'] == "add" || $command == "add")
{
	if ($allowadd != 1)
	{
		header ("Location: ".$GPC['PHP_SELF']."?".$GPC['QUERY_STRING']);
	}

	if ($guestcomments == 0 && !checkCookie())
	{
		// guestcomments not allowed
		$vwartpl->cache("message_error_nopermission");
		include ( $vwar_root . "includes/get_header.php" );
		eval("\$vwartpl->output(\"".$vwartpl->get("message_error_nopermission")."\");");
		include ( $vwar_root . "includes/get_footer.php" );
		exit();
	}

	if($GPC['add'])
	{
		// check for wrong or registered data
		if(	( !checkCookie()
				&& ( empty($GPC['guestname']) || empty($GPC['guestemail'])
					|| !( $registered = checkRegistered($GPC['guestname'], $GPC['guestemail']) )
				)
			)
			|| empty($GPC['comment'])
		)
		{
			if (!$registered && isset($registered))
			{
				eval("\$registered = \"".$vwartpl->get("message_error_registered")."\";");
			}
			$vwartpl->cache ( "message_error_commentadd" );
			include ( $vwar_root . "includes/get_header.php" );
			eval ("\$vwartpl->output(\"" . $vwartpl->get("message_error_commentadd") . "\");");
			include ( $vwar_root . "includes/get_footer.php" );
			exit();
		}

		$ip = getenv("REMOTE_ADDR");
		// guest adds comment
		if (!checkCookie())
		{
			$vwardb->query("
				INSERT INTO vwar".$n."_comments
				(frompage,sourceid,guestname,guesticq,guesthomepage,guestemail,ip,title,comment,iconid,dateline,guestyim,
				 guestaim,guestmsn,guestxfire)
				VALUES
				(
					'$frompage' , '$sourceid' , '".$GPC['guestname']."' , '".$GPC['guesticq']."' ,
					'".$GPC['guesthomepage']."' , '".$GPC['guestemail']."' , '$ip' ,
					'".$GPC['title']."' , '".$GPC['comment']."' ,
					'".$GPC['iconid']."' , '".time()."' , '".$GPC['guestyim']."' ,
					'".$GPC['guestaim']."' , '".$GPC['guestmsn']."', '".$GPC['guestxfire']."'
				)
			");
		}
		// member adds comment
		else
		{
			$vwardb->query("
				INSERT INTO vwar".$n."_comments
				(frompage,sourceid,memberid,comment,title,iconid,dateline,ip)
				VALUES
				(
					'$frompage' , '$sourceid' , '".$GPC['vwarid']."' , '".$GPC['comment']."' ,
					'".$GPC['title']."' , '".$GPC['iconid']."' , '".time()."' , '$ip'
				)
			");
		}

		// save guest data and redirect
		$fields = array(
						"guestname" => "guestname","guestemail" => "guestemail","guesthomepage" => "guesthomepage",
						"guesticq" => "guesticq","guestaim" => "guestaim","guestmsn" => "guestmsn",
						"guestyim" => "guestyim");
		guestData($GPC,$fields,1);

		header("Location: ".$GPC['PHP_SELF']."?".$GPC['QUERY_STRING']);
	}

	// template-cache, standard-templates will be added by script:
	$vwartpllist  = "smiliesoff,smilieson,htmlcodeon,htmlcodeoff,bbcodeon,bbcodeoff,bbcode_language,bbcode_javascript,";
	$vwartpllist .= "bbcode,comment_display_commtitle,comment_preview,comment_add_quote,comment_add_quote_title,";
	$vwartpllist .= "comment_add_guest,comment_add_member";
	$vwartpl->cache($vwartpllist);

	include ( $vwar_root . "includes/get_header.php" );
	getTextRestrictions("vwarform","comment","{firstaltcolor}",1);
	$clickable_icons = getIcons($GPC['iconid']);

	// preview
	if($GPC['preview'])
	{

		if($GPC['title'])
		{
			$commtitle = $GPC['title'];
			eval("\$comment_display_commtitle = \"".$vwartpl->get("comment_display_commtitle")."\";");
		}
		else
		{
			$comment_display_commtitle = "";
		}
		$previewcomment = $GPC['comment'];
		$previewcomment = parseText(dbSelect($previewcomment, 1), $GPC['vwarid']);
		eval("\$comment_preview = \"".$vwartpl->get("comment_preview")."\";");
	}

	// quote
	if(!$GPC['preview'] && is_numeric($GPC['quote']))
	{
		$quote = $vwardb->query_first("
			SELECT guestname,comment,title,dateline,memberid
			FROM vwar".$n."_comments
			WHERE commentid = '".$GPC['quote']."'
		");
		if($quote)
		{
			if($quote['memberid'])
			{
				$member = $vwardb->query_first("
					SELECT name
					FROM vwar".$n."_member
					WHERE memberid = '".$quote['memberid']."'
				");
			}
			$postername = ($quote['memberid']) ? $member['name'] : $quote['guestname'];
			$quote['dateline'] = formatdatetime($quote['dateline'],$longdateformat);
			eval("\$comment_add_quote = \"".$vwartpl->get("comment_add_quote")."\";");
		}
	}

	dbSelectForm($GPC, 1);

	if(!checkCookie())
	{
		$fields = array(
						"guestname" => "guestname","guestemail" => "guestemail","guesthomepage" => "guesthomepage",
						"guesticq" => "guesticq","guestaim" => "guestaim","guestmsn" => "guestmsn",
						"guestyim" => "guestyim");
				guestData($GPC,$fields,0);
		eval("\$vwartpl->output(\"".$vwartpl->get("comment_add_guest")."\");");
	}
	else
	{
		$row = $vwardb->query_first("
			SELECT name
			FROM vwar".$n."_member
			WHERE memberid = '".$GPC['vwarid']."'
		");
		$row['member'] = dbSelect($row['member']);

		eval("\$vwartpl->output(\"".$vwartpl->get("comment_add_member")."\");");
	}
	$vwardb->free_result($result);
}

## -------------------------------------------------------------------------------------------------------------- ##

// ##################### edit #####################
elseif($GPC['cmd'] == "edit" || $command == "edit")
{

	if(!getCommentPermission())
	{
		$vwartpl->cache("message_error_nopermission");
		include ( $vwar_root . "includes/get_header.php" );
		eval("\$vwartpl->output(\"".$vwartpl->get("message_error_nopermission")."\");");
		include ( $vwar_root . "includes/get_footer.php" );
		exit();
	}

	if($GPC['add'])
	{
		// check for wrong or registered data
		if (( !isset($GPC['memberid'])
				&& ( empty($GPC['guestname']) || empty($GPC['guestemail'])
					|| !($registered = checkRegistered($GPC['guestname'], $GPC['guestemail']))
				))	|| empty($GPC['comment']))
		{
			$str["NEWCOMMENT"] = $str['EDITCOMMENT'];
				
			if (!$registered && isset($registered))
			{
				eval("\$registered = \"".$vwartpl->get("message_error_registered")."\";");
			}
			$vwartpl->cache ( "message_error_commentadd" );
			include ( $vwar_root . "includes/get_header.php" );
			eval ("\$vwartpl->output(\"" . $vwartpl->get("message_error_commentadd") . "\");");
			include ( $vwar_root . "includes/get_footer.php" );
			exit();
		}

		// update guest comment
		if (!isset($GPC['memberid']))
		{
			$vwardb->query("
				UPDATE vwar".$n."_comments
				SET
					guestname     = '".$GPC['guestname']."',
					guestemail    = '".$GPC['guestemail']."',
					guesthomepage = '".$GPC['guesthomepage']."',
					guesticq      = '".$GPC['guesticq']."',
					guestyim      = '".$GPC['guestyim']."',
					guestaim      = '".$GPC['guestaim']."',
					guestmsn      = '".$GPC['guestmsn']."',
					iconid        = '".$GPC['iconid']."',
					title         = '".$GPC['title']."',
					comment       = '".$GPC['comment']."',
					editdateline  = '".time()."',
					editmemberid  = '".$GPC["vwarid"]."'
				WHERE commentid = '".$GPC['cid']."'
			");
		}
		// update member comment
		else
		{
			$vwardb->query("
				UPDATE vwar".$n."_comments
				SET
					comment = '".$GPC['comment']."',
					title = '".$GPC['title']."',
					iconid = '".$GPC['iconid']."',
					editdateline = '".time()."',
					editmemberid = '".$GPC["vwarid"]."'
				WHERE commentid = '".$GPC['cid']."'
			");
		}
		header("Location: ".$GPC['PHP_SELF']."?".$GPC['QUERY_STRING']);
	}

	// template-cache, standard-templates will be added by script:
	$vwartpllist  = "smiliesoff,smilieson,htmlcodeon,htmlcodeoff,bbcodeon,bbcodeoff,bbcode_language,bbcode_javascript,";
	$vwartpllist .= "bbcode,comment_display_commtitle,comment_preview,comment_edit_guest,comment_edit_member";
	$vwartpl->cache($vwartpllist);

	include ( $vwar_root . "includes/get_header.php" );
	getTextRestrictions("vwarform","comment","{firstaltcolor}",1);

	// preview
	if($GPC['preview'])
	{
		if($GPC['title'])
		{
			$title = $GPC['title'];
			eval("\$comment_display_commtitle = \"".$vwartpl->get("comment_display_commtitle")."\";");
		}
		$previewcomment = $GPC['comment'];
		$previewcomment = parseText(dbSelect($previewcomment, 1), $GPC['vwarid']);
		eval("\$comment_preview = \"".$vwartpl->get("comment_preview")."\";");

		// change other vars
		if (!$GPC['memberid'])
		{
			while (list($key, $val) = each($GPC))
			{
				$row[$key] = dbSelectForm ($GPC[$key], 1);
			}
		} else {
			$row['comment'] = dbSelectForm($GPC['comment'], 1);
			$row['title']   = dbSelectForm($GPC['title'], 1);
			$row['iconid']  = $GPC['iconid'];
		}

	} else {

		$row = $vwardb->query_first("
			SELECT *
			FROM vwar".$n."_comments
			WHERE commentid = '".$GPC['cid']."'
		");
		dbSelectForm($row);
	}

	$clickable_icons = getIcons($row['iconid']);

	//guest
	if (!$row['memberid'] && !$GPC['memberid'])
	{
		if ($row['guesticq'] == 0)
		{
			$row['guesticq'] = "";
		}
		eval("\$vwartpl->output(\"".$vwartpl->get("comment_edit_guest")."\");");
	}
	//member
	else
	{
		$memberid = (isset($GPC['memberid'])) ? $GPC['memberid'] : $row['memberid'];
		$member = $vwardb->query_first("
			SELECT name
			FROM vwar".$n."_member
			WHERE memberid = '".$memberid."'
		");
		dbSelect($member['name']);

		eval("\$vwartpl->output(\"".$vwartpl->get("comment_edit_member")."\");");
	}
	$vwardb->free_result($result);
}

## -------------------------------------------------------------------------------------------------------------- ##

// ##################### delete #####################
elseif($GPC['cmd'] == "del" || $command == "del")
{
	if($GPC['delete'] && getCommentPermission())
	{
		$vwardb->query("
			DELETE FROM vwar".$n."_comments
			WHERE commentid='".$GPC['cid']."'
		");
		header("Location: ".$GPC['PHP_SELF']."?".$GPC['QUERY_STRING']);
	}
	else
	{
		// template-cache, standard-templates will be added by script:
		$vwartpllist="message_delete,message_error_nopermission";
		$vwartpl->cache($vwartpllist);
		include ( $vwar_root . "includes/get_header.php" );

		if(getCommentPermission())
		{
			eval("\$vwartpl->output(\"".$vwartpl->get("message_delete")."\");");
		} else {
			eval("\$vwartpl->output(\"".$vwartpl->get("message_error_nopermission")."\");");
		}
	}
}

## -------------------------------------------------------------------------------------------------------------- ##

// ##################### show ip #####################
else if($GPC['cmd'] == "showip" || $command == "showip")
{
	// get ip
	$result = $vwardb->query_first("
		SELECT ip
		FROM vwar".$n."_comments
		WHERE commentid  = '".$GPC['cid']."'
	");

	if(getCommentPermission())
	{
		$vwartpl->cache("comment_display_showip");
		include ( $vwar_root . "includes/get_header.php" );
		$ip = $result['ip'];
		eval("\$vwartpl->output(\"".$vwartpl->get("comment_display_showip")."\");");
		include ( $vwar_root . "includes/get_footer.php" );
	} else {
		$vwartpl->cache("message_error_nopermission");
		include ( $vwar_root . "includes/get_header.php" );
		eval("\$vwartpl->output(\"".$vwartpl->get("message_error_nopermission")."\");");
		include ( $vwar_root . "includes/get_footer.php" );
		exit();
	}
}

## -------------------------------------------------------------------------------------------------------------- ##

// ##################### display #####################
else
{

	// template-cache, standard-templates will be added by script:
	$vwartpllist  = "comment_display_toplink,comment_display_commtitle,member_homepagebit2,";
	$vwartpllist .= "comment_display_admin,comment_display_bit,comment_display,comment_display_icon,";
	$vwartpllist .= "member_mailbit,member_icqbit2,member_aimbit2,member_msnbit2,member_yimbit2,";
	$vwartpllist .= "comment_edited,signature";
	$vwartpl->cache($vwartpllist);
	include ( $vwar_root . "includes/get_header.php" );

	$commentpermission = getCommentPermission();

	// get comments
	$result = $vwardb->query_first("
		SELECT COUNT(commentid) AS numcomments
		FROM vwar".$n."_comments
		WHERE sourceid = '$sourceid'
		AND frompage = '$frompage'
	");
	$numcomments = $result['numcomments'];

	// is adding comments allowed?
	if ($allowadd == 1)
	{
		eval("\$comment_display_addcomment = \"".$vwartpl->get("comment_display_addcomment")."\";");
	}

	$limit = getSortClauses ();

	$commcount = $numcomments-$s;
	if ($numcomments > 0)
	{
		$pagelinks = makepagelinks($numcomments,$perpage,$GPC['QUERY_STRING']);
	}

	if (!$pagelinks)
	{
		$noentry = $str['NOENTRY'];
	}

	$result = $vwardb->query("
		SELECT *
		FROM vwar".$n."_comments
		WHERE sourceid = '$sourceid'
		AND frompage = '$frompage'
		ORDER BY dateline DESC
		" . $limit["limit"]
	);
	while ($row = $vwardb->fetch_array($result))
	{
		switchColors();

		// convert vars - ugly ...
		if ($row['memberid'])
		{
			$member       = getShortMemberProfile ($row['memberid']);
			$row['email'] = $member['email'];
			$row['aim']   = $member['aim'];
			$row['yim']   = $member['yim'];
			$row['msn']   = $member['msn'];
			$row['icq']   = $member['icq'];
			$row['xfire'] = $member['xfire'];
			$homepage     = $member['homepage'];
			$postertitle  = $member['statusname'];

			if(!empty($member["name"]))
			{
				$namelink = makelink("modules.php?name=vwar&file=member&action=profile&amp;memberid=" . $member['memberid'], dbSelect($member['name']));
				$name     = dbSelect($member['name']);
			}
			else
			{
				$name        = "[".$row["memberid"].":missingdata]";
				$namelink    = $name;
				$postertitle = $str["GUEST"];
			}
		}
		else
		{
			$namelink     = dbSelect($row['guestname']);
			$name         = dbSelect($row['guestname']);
			$row['email'] = $row['guestemail'];
			$homepage     = $row['guesthomepage'];
			$row['icq']   = $row['guesticq'];
			$row['aim']   = $row['guestaim'];
			$row['yim']   = $row['guestyim'];
			$row['msn']   = $row['guestmsn'];
			$row['xfire'] = $row['guestxfire'];
			$postertitle  = $str['GUEST'];

		}

		if ($row['email'] && checkMail($row['email']))
		{
			eval("\$comment_display_emailbit = encodeMail(\"".$vwartpl->get("member_mailbit")."\");");
		}	else {
			$comment_display_emailbit = "";
		}

		if ($row['icq'])
		{
			eval("\$comment_display_icqbit = \"".$vwartpl->get("member_icqbit2")."\";");
		} else {
			$comment_display_icqbit = "";
		}

		if ($row['aim'])
		{
			eval("\$comment_display_aimbit = \"".$vwartpl->get("member_aimbit2")."\";");
		} else {
			$comment_display_aimbit = "";
		}

		if ($row['yim'])
		{
			eval("\$comment_display_yimbit = \"".$vwartpl->get("member_yimbit2")."\";");
		}	else {
			$comment_display_yimbit = "";
		}

		if ($row['msn'])
		{
			eval("\$comment_display_msnbit = \"".$vwartpl->get("member_msnbit2")."\";");
		}	else {
			$comment_display_msnbit = "";
		}
		if ($row['xfire'])
		{
			eval("\$comment_display_xfirebit = \"".$vwartpl->get("member_xfirebit2")."\";");
		}	else {
			$comment_display_xfirebit = "";
		}
		if ($homepage)
		{
			$homepage = checkUrlFormat($homepage);
			eval("\$comment_display_homepagebit = \"".$vwartpl->get("member_homepagebit2")."\";");
		} else {
			$comment_display_homepagebit = "";
		}

		if ($row['iconid'])
		{
			$smilie = $vwardb->query_first("
				SELECT filename, title
				FROM vwar".$n."_smilie
				WHERE smilieid = '".$row['iconid']."'
			");
			if ($smilie && @file_exists($vwar_root . "images/smilies".$row['filename']))
			{
				eval("\$comment_display_icon = \"".$vwartpl->get("comment_display_icon")."\";");
			}
		}
		else
		{
			$comment_display_icon = "";
		}

		if ($row['title'])
		{
			$row['title'] = dbSelect($row['title']);
			eval("\$comment_display_commtitle = \"".$vwartpl->get("comment_display_commtitle")."\";");
		} else {
			$comment_display_commtitle = "";
		}

		if ($commentpermission == true)
		{
			eval("\$comment_display_admin = \"".$vwartpl->get("comment_display_admin")."\";");
		}

		$commentdate = formatdatetime($row['dateline'],$longdateformat);
		$row['comment'] = parseText(dbSelect($row['comment']),$row['memberid']);

		if (!empty($row["editdateline"]))
		{
			if (empty($memcache))
			{
				$tmp = $vwardb->query("SELECT memberid, name FROM vwar".$n."_member");
				while ($data = $vwardb->fetch_array($tmp))
				{
					$memcache[$data["memberid"]] = $data["name"];
				}
				unset($data);
			}
			unset($editname);
			unset($edittime);

			if (empty($memcache[$row["editmemberid"]]))
			{
				$editname = "[" . $row["editmemberid"] . ":missingdata]";
			}
			else
			{
				$editname = $memcache[$row["editmemberid"]];
			}

			$edittime = formatdatetime($row['editdateline'], $longdateformat);
			eval("\$row[\"comment\"] .= \"".$vwartpl->get("comment_edited")."\";");
		}

		if (trim($member["signature"]) != "" && $showsignature == 1)
		{
			$signature = parseText(dbSelect($member["signature"]),$row['memberid']);
			eval("\$row[\"comment\"] .= \"".$vwartpl->get("signature")."\";");
		}	else {
			$signature = "";
		}

		eval("\$comment_display_bit .= \"".$vwartpl->get("comment_display_bit")."\";");
		$commcount--;

		// unset member vars
		unset($member);
	}
	$vwardb->free_result($result);

	eval("\$comment_display_toplink = \"".$vwartpl->get("comment_display_toplink")."\";");
	eval("\$vwartpl->output(\"".$vwartpl->get("comment_display")."\");");
}
?>