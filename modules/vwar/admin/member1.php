<?php
/* #####################################################################################
 *
 * $Id: member.php,v 1.114 2004/02/23 17:45:56 mabu Exp $
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

require($vwar_root . "includes/functions_common.php");
require($vwar_root . "includes/functions_admin.php");

if (!checkCookie())
{
	header("Location: index.php?".$GPC['QUERY_STRING']."");
}

// get default language
$result = $vwardb->query_first("SELECT vwarlanguage FROM vwar".$n."_settings");
$vwarlanguage = $result['vwarlanguage'];

// ################################### view member #####################################
if ($GPC['action'] == "viewmember")
{
	//template-cache, standard-templates will be added by script:
	$vwartpllist="admin_member_listbitnew,admin_memberlistnew";
	$vwartpl->cache($vwartpllist);

	eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");

	if (isset($GPC['accessgroupid']))
	{
		$display = "AND accessgroupid='" . $GPC['accessgroupid'] . "' ";
	}
	$result = $vwardb->query("
		SELECT * FROM vwar".$n."_member,vwar".$n."_memberstatus
		WHERE vwar".$n."_member.status = vwar".$n."_memberstatus.statusid $display
		ORDER BY displayorder ASC, name ASC
	");
	while ($row = $vwardb->fetch_array($result))
	{
		dbSelect($row);
		$memberstatus = $row['statusname'];
		$row['customstatus'] = ifelse($row['customstatus'], "(" . $row['customstatus'] . ")");
		$hidden = ifelse($row['hidemember'] == 1, makeimgtag($vwar_root . "images/hidden.gif","Hidden Member"), "");
		$nomember = ifelse($row['ismember'] == 0, makeimgtag($vwar_root . "images/nomember.gif","No Member"), "");
		$altcolor = ifelse($GPC['vwarid'] == $row['memberid'], "highlight", switchColors());

		eval ("\$admin_member_listbitnew .= \"".$vwartpl->get("admin_member_listbitnew")."\";");
	}
	eval("\$vwartpl->output(\"".$vwartpl->get("admin_memberlistnew")."\");");
}

// ################################### add member ######################################
if ($GPC['action'] == "addmember")
{
	checkPermission("canaddmember");

	if ($GPC['add'] || $GPC['add_x'])
	{
		$vwartpl->cache("admin_message_error_missingdata");

		// check for wrong data
		$emailcheck = $vwardb->query_first("SELECT email FROM vwar".$n."_member WHERE email = '$email'");
		if ($name == "" || $status=="" || $email=="" || $emailcheck['email']!="")
		{
			eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
			eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_error_missingdata")."\");");
			exit;
		}

		if (isset($joinid))
		{
			$vwardb->query("DELETE FROM vwar".$n."_join WHERE joinid = '".$joinid."'");
		}

		// blank password, use random
		if (empty($password))
		{
						$password .= createRandomPassword(7,"abcdefghijklmnopqrstuvwxyz");
		}

		$vwardb->query("
			INSERT INTO vwar".$n."_member
			(name, realname, birthday, location, country, email, homepage, icq, aim, yim, msn, password, customstatus, status, language)
			VALUES (
			'".$name."',
			'".$realname."',
			'$year-$month-$day',
			'$location',
			'$country',
			'$email',
			'".checkUrlFormat($homepage)."',
			'$icq',
			'$aim',
			'$yim',
			'$msn',
			'".md5($password)."',
			'".$customstatus."',
			'$status',
			'$language')
		");
		$memberid = $vwardb->insert_id();

		$result = $vwardb->query("SELECT * FROM vwar".$n."_games");
		while ($row = $vwardb->fetch_array($result))
		{
			$membergame = "game" . $row['gameid'];
			if ($$membergame == 1)
			{
				$vwardb->query("INSERT INTO vwar".$n."_membergames (gameid, memberid) VALUES ('$row[gameid]', '$memberid')");
			}
		}

		if (sizeof($field) > 0)
		{
			while (list($fieldid, $fieldvalue) = each($field))
			{

				// limit field length
				$result = $vwardb->query_first("SELECT fieldlength FROM vwar".$n."_profilefield WHERE profilefieldid = '$fieldid'");
				$fieldvalue = substr($fieldvalue, 0, $result['fieldlength']);

				// only insert non empty fields
				if ($fieldvalue != "")
				{
					$vwardb->query("
						INSERT INTO vwar".$n."_memberprofilefield
						(memberid, profilefieldid, fieldvalue)
						VALUES
						('$memberid', '$fieldid', '".$fieldvalue."')
					");
				}
			}
		}

		// send mail
		$replacement = array(
		 "ownname" => $ownname, "ownnameshort" => $ownnameshort, "ownhomepage" => $ownhomepage,
		 "password" => $password, "acpurl" => checkPath(checkUrlFormat($urltovwar))."admin/index.php");
		eval("\$text = \"".$vwartpl->get("message_mail_newmember")."\";");
		sendMemberMail("member",$text,array($memberid),$replacement,"text","Welcome to $ownname!","",1);

		header("Location: member.php?action=viewmember");
	}

	//template-cache, standard-templates will be added by script:
	$vwartpllist = "admin_selectbitdefault,languageselectbit,admin_addmember_memberstatusselect,admin_editmember_field";
	$vwartpllist .= "admin_member_gamebitnew,admin_editmember_publicfieldbit,admin_editmember_nonpublicfieldbit,admin_dateselect,admin_addmember";
	$vwartpl->cache($vwartpllist);

	eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");

	// if added from join, get vars here
	if (isset($GPC['joinid']) && !empty($GPC['joinid']))
	{
		$joininfo = $vwardb->query_first("SELECT * FROM vwar".$n."_join WHERE joinid='".$joinid."'");
		dbSelectForm($joininfo);
		$joingameid 		= $joininfo['gameid'];
		$joingametypeid = $joininfo['gametypeid'];
		$name 					= $joininfo['contactname'];
		$icq 						= $joininfo['contacticq'];
		$aim 						= $joininfo['contactaim'];
		$yim 						= $joininfo['contactyim'];
		$msn 						= $joininfo['contactmsn'];
		$email 					= $joininfo['contactemail'];
		$location 			= $joininfo['contactlocation'];
		$birthday 			= $joininfo['contactbirthday'];
		$country 				= $joininfo['contactcountry'];
	}

	// language
	$defaultlanguage = $languages[$vwarlanguage];
	eval ("\$languageselectbit = \"".$vwartpl->get("admin_selectbitdefault")."\";");
	while (list($languagekey,$languageval) = each($languages))
	{
		eval("\$languageselectbit .= \"".$vwartpl->get("languageselectbit")."\";");
	}

	// memberstatus
	eval ("\$admin_addmember_memberstatusselect = \"".$vwartpl->get("admin_selectbitdefault")."\";");
	$result = $vwardb->query("SELECT * FROM vwar".$n."_memberstatus WHERE deleted = '0'");
	while ($status = $vwardb->fetch_array($result))
	{
		$key = $status['statusid'];
		$val = $status['statusname'];
		eval ("\$admin_addmember_memberstatusselect .= \"".$vwartpl->get("admin_addmember_memberstatusselect")."\";");
	}

	// membergames
	$result = $vwardb->query("SELECT * FROM vwar".$n."_games WHERE deleted = '0' ORDER BY gamename ASC");
	$linecounter = 0;
	$admin_member_gamebitnew = "";
	while ($game = $vwardb->fetch_array($result))
	{
		$linecounter++;
		$linecheck = $linecounter % 2;
		$admin_member_gamebitnew .= ifelse($linecheck==1 || $linecounter == 1, "\t\t\t\t\t\t\t\t<tr>");
		switchColors(1);
		if(isset($joingameid) && $joingameid==$game['gameid']) $membergameselect = makeyesnocode("game".$game['gameid'],1);
		else $membergameselect=makeyesnocode("game".$game['gameid'],0);
		eval ("\$admin_member_gamebitnew .= \"".$vwartpl->get("admin_member_gamebitnew")."\";");
		$admin_member_gamebitnew .= ifelse($linecheck == 0 || $linecounter == 2, "</tr>\n");
	}

	// get profile fields

	$right = checkPermission("canaddmember+caneditmember+candeletemember",$vwarid,1);

	$result = $vwardb->query("
		SELECT * FROM vwar".$n."_pfield_cat
		ORDER BY displayorder ASC, catname ASC
	");
	while ($cat = $vwardb->fetch_array($result))
	{
		dbSelect($cat);

		$result2 = $vwardb->query("
			SELECT profilefieldid, fieldname, fieldlength, vwar".$n."_profilefield.description, public, adminonly
			FROM vwar".$n."_profilefield
			WHERE cat_id = '".$cat['pcat_id']."'
			ORDER BY public ASC, displayorder ASC, fieldname ASC
		");
		unset($colourcounter);
		while ($field = $vwardb->fetch_array($result2))
		{
			switchColors();
			dbSelect($field);

			$fieldid = $field['profilefieldid'];
			$fieldname = $field['fieldname'];
			$fielddescription = $field['description'];
			$fieldlength = $field['fieldlength'];

			eval("\$admin_editmember_fieldbits .= \"".$vwartpl->get(ifelse($field['public'] == 1,"admin_editmember_publicfieldbit","admin_editmember_nonpublicfieldbit"))."\";");
		}
		eval ("\$admin_editmember_fields .= \"".$vwartpl->get("admin_editmember_field")."\";");
		unset($admin_editmember_fieldbits);
	}

	if ($row['birthday'] == '0000-00-00')
	{
		$daydefaultselected = "selected";
		$monthdefaultselected = "selected";
	}
	else
	{
		$birthday = split("-",$birthday);
		$year = $birthday[0];
		$month = $birthday[1];
		$day = $birthday[2];

		$monthselected[$month] = "selected";
		$dayselected[$day] = "selected";
		$yearselected[$year] = "selected";
	}
	eval ("\$birthdayselect = \"".$vwartpl->get("admin_dateselect")."\";");

	$countryselectbit = ifelse(isset($country), doCountrySelect($country), doCountrySelect());

	eval("\$vwartpl->output(\"".$vwartpl->get("admin_addmember")."\");");
}
// ################################### delete member ###################################
if ($GPC['action']=="deletemember")
{
	checkPermission("candeletemember");

	if ($delete)
	{
		$vwardb->query("DELETE FROM vwar".$n."_member WHERE memberid = '".$GPC['memberid']."'");
		$vwardb->query("DELETE FROM vwar".$n."_membergames WHERE memberid = '".$GPC['memberid']."'");
		$vwardb->query("DELETE FROM vwar".$n."_memberprofilefield WHERE memberid = '".$GPC['memberid']."'");
		$vwardb->query("DELETE FROM vwar".$n."_memberlocation WHERE memberid = '".$GPC['memberid']."'");
		$vwardb->query("DELETE FROM vwar".$n."_participants WHERE memberid = '".$GPC['memberid']."'");
		$vwardb->query("DELETE FROM vwar".$n."_teammember WHERE memberid = '".$GPC['memberid']."'");
		header("Location: member.php?action=viewmember");
	}

	$vwartpl->cache("admin_message_delete,admin_message_delete_entries");

	// check for other entries with this one
	$checkentries  = $vwardb->query_first("SELECT COUNT(warid) AS numwars  FROM vwar".$n."
		WHERE addedby = '".$GPC['memberid']."'");
	$checkentries2 = $vwardb->query_first("SELECT COUNT(commentid) AS numcom FROM vwar".$n."_comments
		WHERE memberid = '".$GPC['memberid']."'");
	$checkentries3 = $vwardb->query_first("SELECT COUNT(newsid) AS numnews  FROM vwar".$n."_news
		WHERE memberid = '".$GPC['memberid']."'");
	if (0 < $checkentries['numwars'] || $checkentries2['numcom'] || $checkentries3['numnews'])
	{
		$numentries = $checkentries['numwars'] + $checkentries2['numcom'] + $checkentries3['numnews'];
		eval("\$admin_message_delete_entries .= \"".$vwartpl->get("admin_message_delete_entries")."\";");
	}

	eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
	eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_delete")."\");");
}

// ################################### edit picture ###################################
if ($GPC['action']=="editpicture") {
	checkPermission("caneditmember",$GPC['memberid']);

	if ($GPC['add'] || $GPC['add_x'])
	{
		$uploadpath = $vwar_root . "images/member/";

		$pre = $GPC['memberid']."_";

		$result = $vwardb->query_first("SELECT picture FROM vwar".$n."_member WHERE memberid = '".$GPC['memberid']."'");
		$picture = $result['picture'];

		if ($picturedeleted == 1 || $HTTP_POST_FILES['userfile']['name'])
		{
			$vwardb->query("UPDATE vwar".$n."_member SET picture = '' WHERE memberid = '".$GPC['memberid']."'");
			if (@is_file($uploadpath . $picture) && @file_exists($uploadpath . $picture))
			{
				@unlink($uploadpath . $picture);
			}
			if (@is_file($uploadpath . "th_". $picture) &&  @file_exists($uploadpath . "th_". $picture))
			{
				@unlink($uploadpath .  "th_" . $picture);
			}
		}

		if ($HTTP_POST_FILES['userfile']['name'])
		{
			$upload_check = $upload->doUpload($HTTP_POST_FILES['userfile'], $uploadpath, 1, 0, $pre);
			$vwardb->query("
				UPDATE vwar".$n."_member SET picture = '".$pre . strtolower($HTTP_POST_FILES['userfile']['name'])."'
				WHERE memberid='".$GPC['memberid']."'
			");
		}
		header("Location: member.php?action=editmember&memberid=".$GPC['memberid']."");
	}
	else
	{
		$vwartpl->cache("admin_editpicture");

		$imagepath = $vwar_root . "images/member/";

		$result = $vwardb->query_first("SELECT name,picture FROM vwar".$n."_member WHERE memberid = '".$GPC['memberid']."'");
		if ($result['picture'])
		{
			if (@file_exists($imagepath . "th_". $result['picture']))
			{
				$memberpicture = makeimgtag($imagepath . "th_". $result['picture'])."<br>";
			} else {
				//$memberpicture=makeimgtag($imagepath . $result['picture'],"","",$thumbnailwidth,$thumbnailheight)."<br>";
				$memberpicture=makeimgtag($imagepath . $result['picture'])."<br>";
			}
		}
		else
		{
			$memberpicture = "";
		}

		$picturedeleted = makeyesnocode("picturedeleted",0);
		$membername = dbSelect($result['name']);

		eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
		eval("\$vwartpl->output(\"".$vwartpl->get("admin_editpicture")."\");");
	}
}

// ################################### edit member ####################################
if ($GPC['action'] == "editmember")
{
	checkPermission("caneditmember",$GPC['memberid']);

	// INFORMATION:
	// This part isn't as solved as it should be
	if ($GPC['add'] || $GPC['add_x'] || $modifypicture)
	{
		// check for wrong data
		$emailcheck = $vwardb->query_first("
			SELECT email
			FROM vwar".$n."_member
			WHERE email = '$email'
				AND memberid != '" . $GPC['memberid'] . "'
		");
		if ($name == "" || $status=="" || $emailcheck["email"]!="")
		{
			$vwartpl->cache("admin_message_error_missingdata");
			eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
			eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_error_missingdata")."\");");
			exit;
		}
		if ($GPC['memberid'] == $GPC['vwarid'])
		{
			if ($language != $GPC['vwarlanguage'])
			{
				SetVWarCookie("vwarlanguage", $language);
			}
		}
		$vwardb->query("
			UPDATE vwar".$n."_member SET
			name = '".$name."',
			realname = '".$realname."',
			birthday = '$year-$month-$day',
			location = '$location',
			country = '$country',
			email = '$email',
			homepage = '".checkUrlFormat($homepage)."',
			icq = '$icq',
			aim = '$aim',
			yim = '$yim',
			msn = '$msn',
			customstatus = '".$customstatus."',
			status = '$status',
			language = '$language',
			signature = '".trim(substr($GPC["signature"],0,2000))."'
			WHERE memberid = '".$GPC['memberid']."'
		");
		$vwardb->query("DELETE FROM vwar".$n."_membergames WHERE memberid = '".$GPC['memberid']."'");

		// update access pw
		$result = $vwardb->query_first("
			SELECT canaccessbackup FROM vwar".$n."_member m,vwar".$n."_accessgroup a
			WHERE m.accessgroupid = a.accessgroupid
		");
		if (!empty($GPC["backuppw"]) && $result["canaccessbackup"] == "1")
		{
			require($vwar_root . "includes/classes/class_htaccess.php");
			$ht = new htaccess($vwar_root . "backup/.htpasswd");

			$ht->modifyUser($GPC["memberid"],$backuppw);
			$ht->commitUserChanges();
			unset($ht);
		}

		$result = $vwardb->query("SELECT * FROM vwar".$n."_games");
		while ($row=$vwardb->fetch_array($result))
		{
			$membergame = "game" . $row['gameid'];
			if ($$membergame == 1)
			{
				$vwardb->query("INSERT INTO vwar".$n."_membergames (gameid, memberid) VALUES ('$row[gameid]', '$GPC[memberid]')");
			}
		}

		if (sizeof($field) > 0)
		{
			while (list($fieldid, $fieldvalue) = each($field))
			{
				$result = $vwardb->query_first("SELECT fieldlength FROM vwar".$n."_profilefield WHERE profilefieldid = '$fieldid'");
				$fieldvalue = substr($fieldvalue, 0, $result['fieldlength']);

				$result = $vwardb->query_first("
					SELECT memberprofilefieldid FROM vwar".$n."_memberprofilefield
					WHERE profilefieldid = '$fieldid' AND memberid = '".$GPC['memberid']."'
				");
				if ($result['memberprofilefieldid'] == 0)
				{
					$vwardb->query("
						INSERT INTO vwar".$n."_memberprofilefield
						(memberid, profilefieldid, fieldvalue)
						VALUES
						('".$GPC['memberid']."', '$fieldid', '".ifelse($fieldvalue!="n/a",$fieldvalue,"")."')
					");
				}
				else
				{
					$vwardb->query("UPDATE vwar".$n."_memberprofilefield SET fieldvalue='".$fieldvalue."' WHERE memberid='".$GPC['memberid']."' AND profilefieldid='".$fieldid."'");
				}
			}
		}
		header("Location: member.php?action=" . ifelse($modifypicture == "Modify Picture", "editpicture&memberid=" . $GPC['memberid'], "viewmember"));
	}

	//template-cache, standard-templates will be added by script:
	$vwartpllist = "admin_dateselect,languageselectbit,admin_addmember_memberstatusselect2,admin_editmember_publicfieldbit,";
	$vwartpllist .= "admin_addmember_memberstatusselect,admin_memberlocationpic,admin_member_gamebitnew,";
	$vwartpllist .= "admin_editmember_nonpublicfieldbit,admin_editmembernew,admin_editmember_field";
	$vwartpllist .= "admin_editmember_nonpublicfieldbitadminonly,admin_editmember_publicfieldbitadminonly";
	$vwartpl->cache($vwartpllist);

	include($vwar_root . "includes/language/english.inc.php");

	$result = $vwardb->query_first("
	SELECT isadmin,canaccessbackup
	FROM vwar".$n."_member,vwar".$n."_accessgroup
	WHERE vwar".$n."_member.accessgroupid = vwar".$n."_accessgroup.accessgroupid AND memberid = '".$GPC['vwarid']."'");
	$isadmin = $result['isadmin'];
	$canaccessbackup = $result['canaccessbackup'];

	$row = $vwardb->query_first("
		SELECT * FROM vwar".$n."_member,vwar".$n."_memberstatus
		WHERE memberid = '".$GPC['memberid']."' AND status = statusid
	");
	dbSelectForm($row);

	$color_first = "secondalt";
	$color_second = "firstalt";

		$usertmp = explode("|",$ab_user);
		if (in_array($row['memberid'],$usertmp) && $canaccessbackup == "1")
		{
				eval ("\$accesspw = \"".$vwartpl->get("admin_editmember_accesspw")."\";");
				$color_first = "firstalt";
				$color_second = "secondalt";
		}

	if ($row['birthday'] == '0000-00-00')
	{
		$daydefaultselected = "selected";
		$monthdefaultselected = "selected";
	}
	else
	{
		$birthday = split("-",$row['birthday']);
		$year = $birthday[0];
		$month = $birthday[1];
		$day = $birthday[2];

		$monthselected[$month] = "selected";
		$dayselected[$day] = "selected";
		$yearselected[$year] = "selected";
	}
	eval ("\$birthdayselect = \"".$vwartpl->get("admin_dateselect")."\";");

	$imagepath = $vwar_root . "images/member/";

	if ($row['picture'])
	{
		$memberpicture = ifelse(@file_exists($imagepath . "th_". $row['picture']), makeimgtag($imagepath . "th_". $row['picture']), makeimgtag($imagepath . $row['picture']))."<br>";
	} else {
		$memberpicture = "<b>No picture uploaded!</b>";
	}

	$memberstatus = $row['statusname'];
	if($row['icq'] == 0) $row['icq'] = "";


	// language
	if (!$row['language'])
	{
		$languagesel[$vwarlanguage] = "selected";
	} else {
		$languagesel[$row['language']] = "selected";
	}
	$defaultlanguage = $languages[$vwarlanguage];

	while (list($languagekey,$languageval) = each($languages))
	{
		eval("\$languageselectbit .= \"".$vwartpl->get("languageselectbit")."\";");
	}

	// memberstatus
	$result = $vwardb->query("SELECT * FROM vwar".$n."_memberstatus WHERE deleted = '0'");
	while ($status = $vwardb->fetch_array($result))
	{
		$key = $status['statusid'];
		$val = $status['statusname'];

		if($row['status'] == $key)
		{
			eval ("\$admin_addmember_memberstatusselect .= \"".$vwartpl->get("admin_addmember_memberstatusselect2")."\";");
		}
		else if ($isadmin == 1)
		{
			eval ("\$admin_addmember_memberstatusselect .= \"".$vwartpl->get("admin_addmember_memberstatusselect")."\";");
		}
	}

	// membergames
	$result = $vwardb->query("SELECT * FROM vwar".$n."_games WHERE deleted = '0' ORDER BY gamename ASC");
	$linecounter = 0;
	$admin_member_gamebitnew = "";
	while ($game = $vwardb->fetch_array($result))
	{
		$linecounter++;
		$linecheck = $linecounter % 2;
		$admin_member_gamebitnew .= ifelse($linecheck==1 || $linecounter == 1, "\t\t\t\t\t\t\t\t<tr>");
		switchColors(1);

		$result2 = $vwardb->query_first("
			SELECT COUNT(membergamesid) AS numgames FROM vwar".$n."_membergames
			WHERE memberid = '".$GPC['memberid']."' AND gameid = '".$game['gameid']."'
		");
		$membergameselect = makeyesnocode("game".$game['gameid'], $result2['numgames']);

		//favmedalorite medals
		if ($result2['numgames'] == 1)
		{
			$favmedalcount = $vwardb->query_first("
				SELECT COUNT(membermedalid) AS nummembermedals FROM vwar".$n."_membermedal
				WHERE memberid = '".$GPC['memberid']."' AND membergameid = '".$game['gameid']."'
			");
			$medalcount = $vwardb->query_first("
				SELECT COUNT(medalid) AS nummedals FROM vwar".$n."_medals
				WHERE gameid = '".$game['gameid']."'
			");

			if ($medalcount['nummedals']<=0)
			{
				$addfavmedal = "<br><small>&raquo;&nbsp;No medals available for this game!</small>";
			}
			else if ($favmedalcount['nummembermedals'] < $favmedalpermember && $medalcount['nummedals'] > 0)
			{
				$addfavmedal = "<br>[&nbsp;" . makelink("member1.php?action=addmembermedal&amp;memberid=" . $row[memberid] . "&amp;gameid=" . $game[gameid],"Add medal")."&nbsp;]";
			}
			else if ($favmedalcount['nummembermedals'] >= $favmedalpermember && $medalcount['nummedals'] > 0)
			{
				$addfavmedal = "<br><small>&raquo;&nbsp;Maximum of $favmedalpermember medals reached!</small>";
			}

			if ($favmedalcount['nummembermedals'] > 0 && $medalcount['nummedals'] > 0)
			{
				$result2 = $vwardb->query("
					SELECT membermedalid,medalname
					FROM vwar".$n."_membermedal,vwar".$n."_medals
					WHERE vwar".$n."_membermedal.membergameid='".$game['gameid']."'
					AND vwar".$n."_medals.medalid=vwar".$n."_membermedal.medalid
					AND vwar".$n."_membermedal.memberid='".$GPC['memberid']."'
					AND deleted='0'
					ORDER BY medalname
				");
				while ($row2=$vwardb->fetch_array($result2))
				{
					$row2['medalnamepic'] = strtolower($row2['medalname']);
					eval ("\$admin_membermedalpic .= \"".$vwartpl->get("admin_membermedalpic")."\";");
				}
			}
		}
		eval ("\$admin_member_gamebitnew .= \"".$vwartpl->get("admin_member_gamebitnew")."\";");
		$admin_member_gamebitnew .= ifelse($linecheck == 0 || $linecounter == 2, "</tr>\n");
		unset($checked, $admin_membermedalpic, $addfavmedal);
	}

	// get profile fields
	$right = checkPermission("canaddmember+caneditmember+candeletemember",$vwarid,1);

	$result = $vwardb->query("
		SELECT * FROM vwar".$n."_pfield_cat
		ORDER BY displayorder ASC, catname ASC
	");
	while ($cat = $vwardb->fetch_array($result))
	{
		dbSelect($cat);

		$result2 = $vwardb->query("
			SELECT profilefieldid, fieldname, fieldlength, vwar".$n."_profilefield.description, public, adminonly
			FROM vwar".$n."_profilefield
			WHERE cat_id = '".$cat['pcat_id']."'
			ORDER BY public ASC, displayorder ASC, fieldname ASC
		");
		unset($colourcounter);
		while ($field = $vwardb->fetch_array($result2))
		{
			switchColors();
			dbSelect($field);

			$fieldid = $field['profilefieldid'];
			$fieldname = $field['fieldname'];
			$fielddescription = $field['description'];
			$fieldlength = $field['fieldlength'];

			$result3 = $vwardb->query_first("
				SELECT fieldvalue FROM vwar".$n."_memberprofilefield
				WHERE memberid = '".$GPC['memberid']."' AND profilefieldid='".$fieldid."'
			");
			$fieldvalue = dbSelectForm($result3['fieldvalue']);

			if ($field['adminonly'] == 1 && $right != 1)
			{
				if (empty($fieldvalue))
				{
					$fieldvalue = "n/a";
				}
				eval("\$admin_editmember_fieldbits .= \"".$vwartpl->get(ifelse($field['public']==1,"admin_editmember_publicfieldbitadminonly","admin_editmember_nonpublicfieldbitadminonly"))."\";");
			}
			else
			{
				eval("\$admin_editmember_fieldbits .= \"".$vwartpl->get(ifelse($field['public']==1,"admin_editmember_publicfieldbit","admin_editmember_nonpublicfieldbit"))."\";");
			}
		}
		eval ("\$admin_editmember_fields .= \"".$vwartpl->get("admin_editmember_field")."\";");
		unset($admin_editmember_fieldbits);
	}

	$countryselectbit = ifelse($row['country'] == "", doCountrySelect(), doCountrySelect($row['country']));

	getTextRestrictions("member","signature");

	eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
	eval("\$vwartpl->output(\"".$vwartpl->get("admin_editmembernew")."\");");
}

// #################################### edit password ##################################
if ($GPC['action'] == "editpw")
{
	checkPermission("caneditmember",$GPC['memberid']);

	if ($GPC['add'] || $GPC['add_x'])
	{
		$currentpw = $vwardb->query_first("SELECT password FROM vwar".$n."_member WHERE memberid = '".$GPC['memberid']."'");

		if ($newpw1 != $newpw2 || (md5($oldpw) != $currentpw['password'] && (!checkPermission("caneditmember","",1)
			&& !checkPermission("isadmin","",1) || $GPC['memberid']==$GPC['vwarid'])))
		{
			$vwartpl->cache("admin_message_error_missingdata");
			eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
			eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_error_missingdata")."\");");
			exit;
		}
		$vwardb->query("UPDATE vwar".$n."_member SET password = '".md5($newpw1)."' WHERE memberid = '".$GPC['memberid']."'");

		if ($GPC['memberid'] == $GPC['vwarid'])
		{
			if(md5($newpw1)!=$GPC['vwarpassword'])
			{
				SetVWarCookie("vwarpassword", md5($newpw1));
			}
		}
		header("Location: member.php?action=editmember&memberid=".$GPC['memberid']."");
	}

	$vwartpl->cache("admin_editmemberpw");
	eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");

	$memberid = $GPC['memberid'];
	if (!checkPermission("caneditmember","",1) && !checkPermission("isadmin","",1) || $memberid==$GPC['vwarid'])
	{
		eval ("\$oldpw = \"".$vwartpl->get("admin_editmemberpw_oldpw")."\";");
	}

	eval("\$vwartpl->output(\"".$vwartpl->get("admin_editmemberpw")."\");");
}

// ################################### edit permissions ################################
if ($GPC['action'] == "editaccess")
{
	checkPermission("caneditmemberpermission");

	if ($GPC['add'] || $GPC['add_x'])
	{
		if(!checkPermission("isadmin","",1))
		{
			$checkadmin = $vwardb->query_first("
				SELECT isadmin
				FROM vwar".$n."_accessgroup
				WHERE accessgroupid = '$accessgroupid'
			");
			if ($checkadmin['isadmin'] == 1)
			{
				header("Locatin: member.php?action=editaccess");
			}
		}
		$vwardb->query("
			UPDATE vwar".$n."_member
			SET
			accessgroupid = '$accessgroupid',
			ismember='$ismember',
			hidemember='$hidemember'
			WHERE memberid = '".$GPC['memberid']."'
		");
		header("Location: member.php?action=viewmember");
	}

	$vwartpl->cache("admin_selectbitdefault,admin_accessgroup_selectbit,admin_editaccess");
	eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");

	$row = $vwardb->query_first("
		SELECT accessgroupid, name, ismember,hidemember FROM vwar".$n."_member
		WHERE memberid = '".$GPC['memberid']."'
	");
	$ismember = makeyesnocode("ismember",$row['ismember']);
	$hidemember = makeyesnocode("hidemember",$row['hidemember']);

	eval ("\$admin_accessgroup_selectbit = \"".$vwartpl->get("admin_selectbitdefault")."\";");
	if (!checkPermission("isadmin","",1))
	{
		$where = "WHERE isadmin = '0'";
	}
	$result = $vwardb->query("SELECT accessgroupid, accessgroupname FROM vwar".$n."_accessgroup $where ORDER BY accessgroupname ASC");
	while ($accessgroup = $vwardb->fetch_array($result))
	{
		if ($row['accessgroupid'] == $accessgroup['accessgroupid'])
		{
			$selected="selected";
		}
		eval("\$admin_accessgroup_selectbit .= \"".$vwartpl->get("admin_accessgroup_selectbit")."\";");
		unset($selected);
	}
	eval("\$vwartpl->output(\"".$vwartpl->get("admin_editaccess")."\");");
}

// ################################### view memberstatuslist ###########################
if ($GPC['action'] == "viewstatuslist")
{
	checkPermission("canaddstatus-caneditstatus-candeletestatus");
	$vwartpl->cache("admin_memberstatus_listbit,admin_memberstatus_list");
	eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");

	$result = $vwardb->query("SELECT * FROM vwar".$n."_memberstatus ORDER BY displayorder ASC, statusname ASC");
	while ($row = $vwardb->fetch_array($result))
	{
		switchColors();

		eval("\$admin_memberstatus_listbit .= \"".$vwartpl->get("admin_memberstatus_listbit")."\";");
	}
	$vwardb->free_result($result);

	eval("\$vwartpl->output(\"".$vwartpl->get("admin_memberstatus_list")."\");");
}

// ################################### add memberstatus ################################
if ($GPC['action'] == "addmemberstatus")
{
	checkPermission("canaddstatus");

	if ($GPC['add'] || $GPC['add_x'])
	{
		// check for wrong data
		if ($statusname == "")
		{
			$vwartpl->cache("admin_message_error_missingdata");
			eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
			eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_error_missingdata")."\");");
			exit;
		}
		$vwardb->query("INSERT INTO vwar".$n."_memberstatus (statusname,displayorder) VALUES ('".$statusname."','$displayorder')");
		header("Location: member.php?action=viewstatuslist");
	}
	else
	{
		$vwartpl->cache("admin_addmemberstatus");
		eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
		eval("\$vwartpl->output(\"".$vwartpl->get("admin_addmemberstatus")."\");");
	}
}

// ################################### edit memberstatus ###############################
if ($GPC['action'] == "editmemberstatus")
{
	checkPermission("caneditstatus");

	if ($GPC['add'] || $GPC['add_x'])
	{
		// check for wrong data
		if ($statusname == "")
		{
			$vwartpl->cache("admin_message_error_missingdata");
			eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
			eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_error_missingdata")."\");");
			exit;
		}
		$vwardb->query("
			UPDATE vwar".$n."_memberstatus
			SET statusname = '$statusname', displayorder = '$displayorder' WHERE statusid = '".$GPC['statusid']."'
		");
		header("Location: member.php?action=viewstatuslist");
	}

	$vwartpl->cache("admin_editmemberstatus");
	eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");

	$row = $vwardb->query_first("SELECT * FROM vwar".$n."_memberstatus WHERE statusid = '".$GPC['statusid']."'");

	$checked = ifelse($row['deleted'] == 1, "checked");

	eval("\$vwartpl->output(\"".$vwartpl->get("admin_editmemberstatus")."\");");
}

// ################################### delete memberstatus #############################
if ($GPC['action'] == "deletememberstatus")
{
	checkPermission("candeletestatus");

	if ($delete)
	{
		$vwardb->query("DELETE FROM vwar".$n."_memberstatus WHERE statusid = '".$GPC['statusid']."'");
		header("Location: member.php?action=viewstatuslist");
	}

	$vwartpl->cache("admin_message_error_nodelete,admin_message_delete");
	eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");

	$result = $vwardb->query_first("SELECT COUNT(memberid) AS nummembers FROM vwar".$n."_member WHERE status = '".$GPC['statusid']."'");
	$nummember = $result['nummembers'];

	eval("\$vwartpl->output(\"".$vwartpl->get(ifelse($nummember > 0, "admin_message_error_nodelete", "admin_message_delete"))."\");");
}

// ################################### view joinrequests ###############################
if ($GPC['action'] == "viewjoin")
{
	checkPermission("canaddmember");
	//template-cache, standard-templates will be added by script:
	$vwartpllist="admin_joinlistbit,admin_joinlist";
	$vwartpl->cache($vwartpllist);

	$result = $vwardb->query("
		SELECT joinid, contactname, dateline, vwar".$n."_games.gamename
		FROM vwar".$n."_join
		LEFT JOIN vwar".$n."_games ON (vwar".$n."_join.gameid = vwar".$n."_games.gameid)
		ORDER BY dateline DESC
	");
	while ($row = $vwardb->fetch_array($result))
	{
		switchColors();
		$dateline = formatdatetime($row['dateline'],$longdateformat);
		eval("\$admin_joinlistbit .= \"".$vwartpl->get("admin_joinlistbit")."\";");
	}

	eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
	eval("\$vwartpl->output(\"".$vwartpl->get("admin_joinlist")."\");");
}
// ################################### view joindetails ################################
if ($GPC['action'] == "joindetails")
{
	checkPermission ("canaddmember");

	if ($GPC['add'] || $GPC['add_x'])
	{
		if ($contacthomepage == $notavailable) unset($contacthomepage);
		if ($contacticq == $notavailable) unset($contacticq);
		header("Location: member.php?action=addmember&joinid=".$joinid."");
	}

	//template-cache, standard-templates will be added by script:
	$vwartpllist="admin_joindetails";
	$vwartpl->cache($vwartpllist);

	$row = $vwardb->query_first("
		SELECT vwar".$n."_join.*, vwar".$n."_games.*, vwar".$n."_gametype.*
		FROM vwar".$n."_join
		LEFT JOIN vwar".$n."_games ON (vwar".$n."_join.gameid = vwar".$n."_games.gameid)
		LEFT JOIN vwar".$n."_gametype ON (vwar".$n."_join.gametypeid = vwar".$n."_gametype.gametypeid)
		WHERE joinid = '".$GPC['joinid']."'
	");
	dbSelect($row);

	$notavailable = "-";

	$row['contacticq'] = ifelse($row['contacticq'], $row['contacticq'], "-");
	$row['contactaim'] = ifelse($row['contactaim'], $row['contactaim'], "-");
	$row['contactyim'] = ifelse($row['contactyim'], $row['contactyim'], "-");
	$row['contactmsn'] = ifelse($row['contactmsn'], $row['contactmsn'], "-");
	$row['contactircnetwork'] = ifelse($row['contactircnetwork'], $row['contactircnetwork'], "-");
	$row['contactircchannel'] = ifelse($row['contactircchannel'], $row['contactircchannel'], "-");
	$row['contactlocation'] = ifelse($row['contactlocation'], $row['contactlocation'], "-");

	$row['contactemail'] = makelink("mailto:" . $row['contactemail'] . "?subject=" . $ownname . " - Join Request&amp;body=Hi " . $row['contactname'] . ",", $row['contactemail']);

	if ($row['contactcountry'] && file_exists($vwar_root . "images/flags/" . $row['contactcountry'] . ".gif"))
	{
		$row['contactcountry'] = makeimgtag($vwar_root . "images/flags/" . $row['contactcountry'] . ".gif");
	}
	else
	{
		$row['contactcountry'] = makeimgtag($vwar_root . "images/flags/nocountry.gif");
	}

	// calculate age (don't uses unix timestamp!!!)
	$birthdayarray = split("-", $row['contactbirthday']);
	$birthday = $birthdayarray[2] . "." . $birthdayarray[1] . "." . $birthdayarray[0];
	$age = date("Y") - $birthdayarray[0];

	if (($birthdayarray[1] > date("m")) || (($birthdayarray[1] == date("m")) && ($birthdayarray[2] > date("d"))))
	{
		$age--;
	}

	$dateline = formatdatetime($row['dateline'], $longdateformat);

	$joininfo = ifelse($row['joininfo'], (parseText($row['joininfo'],0)), $notavailable);

	eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
	eval("\$vwartpl->output(\"".$vwartpl->get("admin_joindetails")."\");");
}

// ################################### delete join #####################################
if ($GPC['action'] == "deletejoin")
{
	checkPermission("candeletemember");

	if ($delete)
	{
		$vwardb->query("DELETE FROM vwar".$n."_join WHERE joinid = '".$GPC['joinid']."'");
		header("Location: member.php?action=viewjoin");
	}
	$vwartpl->cache("admin_message_delete");

	eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
	eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_delete")."\");");
}

// ################################### add medal to member #############################
if ($GPC['action'] == "addmembermedal")
{
	checkPermission("caneditmember",$GPC['vwarid']);

	if ($GPC['add'] || $GPC['add_x'])
	{
		// check for wrong data
		if ($GPC['medalid'] == "")
		{
			$vwartpl->cache("admin_message_error_missingdata");
			eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
			eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_error_missingdata")."\");");
			exit;
		}
		$vwardb->query("
			INSERT INTO vwar".$n."_membermedal (memberid, medalid, membergameid, comment)
			VALUES ('".$GPC['memberid']."', '".$GPC['medalid']."', '".$GPC['gameid']."', '".$GPC['comment']."')
		");
		header("location: member1.php?action=editmember&memberid=".$GPC['memberid']."");
	}
	$vwartpl->cache("medalselectbit,admin_membermedalselect,admin_addmedaltomember");

	eval ("\$medalselectbit = \"".$vwartpl->get("admin_selectbitdefault")."\";");

	$idlist = getMembermedals($GPC['gameid'],$GPC['memberid']);
	$result = $vwardb->query("
		SELECT medalid, medalname, medalpic FROM vwar".$n."_medals
		WHERE deleted = '0'
		AND gameid = '".$GPC['gameid']."'
		AND medalid NOT IN ('$idlist')
		ORDER by medalname ASC
	");
	while ($row = $vwardb->fetch_array($result))
	{
		eval("\$medalselectbit .= \"".$vwartpl->get("medalselectbit")."\";");
	}
	eval("\$medalselect .= \"".$vwartpl->get("admin_membermedalselect")."\";");
	eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
	eval("\$vwartpl->output(\"".$vwartpl->get("admin_addmedaltomember")."\");");
}

// ################################### edit membermedal ################################
if ($GPC['action'] == "editmembermedal")
{
	checkPermission("caneditmember",$GPC['vwarid']);

	if ($GPC['add'] || $GPC['add_x'])
	{
		// check for wrong data
		if ($GPC['medalid'] == "")
		{
			$vwartpl->cache("admin_message_error_missingdata");
			eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
			eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_error_missingdata")."\");");
			exit;
		}
		$vwardb->query("
			UPDATE vwar".$n."_membermedal SET
			medalid = '".$GPC['medalid']."', comment = '".$GPC['comment']."'
			WHERE membermedalid = '".$GPC['membermedalid']."'
		");
		header("location: member1.php?action=editmember&memberid=".$GPC['memberid']."");
	}

	//template-cache, standard-templates will be added by script:
	$vwartpllist = "admin_selectbitdefault,medalselectbit2,medalselectbit,";
	$vwartpllist .= "admin_membermedalselect,admin_editmembermedal";
	$vwartpl->cache($vwartpllist);

	$favmedal = $vwardb->query_first("
		SELECT medalid, comment FROM vwar".$n."_membermedal
		WHERE membermedalid = '".$GPC['membermedalid']."'
	");
	$comment = dbSelectForm($favmedal['comment']);
	$idlist = getMembermedals($GPC['gameid'],$GPC['memberid'],$GPC['membermedalid']);
	eval ("\$medalselectbit = \"".$vwartpl->get("admin_selectbitdefault")."\";");

	$result = $vwardb->query("
		SELECT medalid, medalname, medalpic FROM vwar".$n."_medals
		WHERE deleted = '0'
		AND gameid = '".$GPC['gameid']."'
		AND medalid NOT IN ('$idlist')
		ORDER by medalname ASC
	");
	while ($row = $vwardb->fetch_array($result))
	{
		eval("\$medalselectbit .= \"".$vwartpl->get(ifelse($row['medalid'] == $favmedal['medalid'],"medalselectbit2","medalselectbit"))."\";");
	}
	eval("\$medalselect .= \"".$vwartpl->get("admin_membermedalselect")."\";");
	eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
	eval("\$vwartpl->output(\"".$vwartpl->get("admin_editmembermedal")."\");");
}

// ############################# delete medal from member ##############################
if ($GPC['action'] == "deletemembermedal")
{
	checkPermission("caneditmember",$GPC['vwarid']);

	if ($delete)
	{
		$vwardb->query("DELETE FROM vwar".$n."_membermedal WHERE membermedalid='".$GPC['membermedalid']."'");
		header("location: member1.php?action=editmember&memberid=".$GPC['memberid']."");
	}

	$vwartpl->cache("admin_message_delete");
	eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
	eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_delete")."\");");
}
?>