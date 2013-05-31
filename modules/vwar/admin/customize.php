<?php
/* #####################################################################################
 *
 * $Id: customize.php,v 1.12 2004/03/18 11:02:27 mabu Exp $
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
require($vwar_root . "includes/functions_customize.php");

if (!checkCookie())
{
	header("Location: index.php");
}

checkPermission("isadmin");

// ################################### list menu groups ######################################
if ($GPC['action'] == "viewmenu")
{
	$vwartpllist = "admin_acpmenulist,admin_acpmenulistbit";
	$vwartpl->cache($vwartpllist);

	eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");

	$result = $vwardb->query("
		SELECT amg.groupid,amg.grouptitle,amg.displayorder,COUNT(ami.itemid) as numitems
		FROM vwar".$n."_acpmenugroups amg
		LEFT JOIN vwar".$n."_acpmenuitems ami ON (amg.groupid = ami.groupid)
		GROUP BY amg.groupid
		ORDER BY amg.displayorder,amg.grouptitle ASC
	");

	while ($row = $vwardb->fetch_array($result))
	{
		switchColors();

		eval("\$admin_acpmenulistbit .= \"".$vwartpl->get("admin_acpmenulistbit")."\";");
	}
	eval("\$vwartpl->output(\"".$vwartpl->get("admin_acpmenulist")."\");");
}

// ################################### add menu group #####################################
if ($GPC['action'] == "addmenu")
{
	if ($GPC['add'] || $GPC['add_x'])
	{
		// check for wrong data
		if (empty($GPC['grouptitle']) || empty($GPC['groupname']))
		{
			$vwartpl->cache("admin_message_error_missingdata");
			eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
			eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_error_missingdata")."\");");
			exit();
		}

		// create rights string
		$tmp = explode("\r\n",$GPC["cond"]);
		foreach ($tmp AS $right)
		{
			if(!empty($right))
			{
				$rights .= str_replace(";","",$right).";";
			}
		}
		unset($right);
		unset($tmp);

		$vwardb->query("
			INSERT INTO vwar".$n."_acpmenugroups (
                `grouptitle`,`groupname`,`cond`,`condtype`,`displayorder`
            )    VALUES (
                '".$GPC['grouptitle']."',
                '".$GPC['groupname']."',
                '".substr($rights,0,(strlen($rights)-1))."',
                '".$GPC['condtype']."',
                '".$GPC['displayorder']."'
            )");

		header("Location: " . $GPC['PHP_SELF'] . "?action=viewmenu");
		exit();
	}

	// template-cache, standard-templates will be added by script:
	$vwartpl->cache("admin_acpmenuadd");

	eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
	eval("\$vwartpl->output(\"".$vwartpl->get("admin_acpmenuadd")."\");");
}

// ################################### edit menu group #####################################
if ($GPC['action'] == "editmenu")
{
	if ($GPC['add'] || $GPC['add_x'])
	{
		// check for wrong data
		if (empty($GPC['grouptitle']) || empty($GPC['groupname']))
		{
			$vwartpl->cache("admin_message_error_missingdata");
			eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
			eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_error_missingdata")."\");");
			exit();
		}

		// create rights string
        $tmp = explode("\r\n",$GPC["cond"]);
		foreach ($tmp AS $right)
		{
			if(!empty($right))
			{
				$rights .= str_replace(";","",$right).";";
			}
		}
		unset($right);
		unset($tmp);

		$vwardb->query("
			UPDATE vwar".$n."_acpmenugroups
			SET
				`grouptitle` = '".$GPC['grouptitle']."',
				`groupname` = '".$GPC['groupname']."',
				`cond` = '".substr($rights,0,(strlen($rights)-1))."',
				`condtype` = '".$GPC['conditiontype']."',
				`displayorder` = '".$GPC['displayorder']."'
			WHERE groupid = '".$GPC['groupid']."'");

		header("Location: " . $GPC['PHP_SELF'] . "?action=viewmenu");
		exit();
	}

	$row = $vwardb->query_first("
		SELECT *
		FROM vwar".$n."_acpmenugroups
		WHERE groupid = '".$GPC['groupid']."'");

	// prepare
    $selected[$row["condtype"]] = "selected";
    $row["cond"] = str_replace(";","\n",$row["cond"]);

	// template-cache, standard-templates will be added by script:
	$vwartpl->cache("admin_acpmenuedit");

	eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
	eval("\$vwartpl->output(\"".$vwartpl->get("admin_acpmenuedit")."\");");
}

// ################################### delete menu group #####################################
if ($GPC['action'] == "deletemenu")
{
	if ($delete)
	{
		$vwardb->query("DELETE FROM vwar".$n."_acpmenugroups WHERE groupid = '".$GPC["groupid"]."'");
		$vwardb->query("DELETE FROM vwar".$n."_acpmenuitems WHERE groupid = '".$GPC["groupid"]."'");

		header("Location: ".$GPC['PHP_SELF']."?action=viewmenu");
		exit();
	}

	// check for other entries with this one
	$checkentries = $vwardb->query_first("
		SELECT COUNT(itemid) AS numitems FROM vwar".$n."_acpmenuitems
		WHERE groupid = '" . $GPC['groupid'] . "'
	");

	if ($checkentries['numitems'] > 0)
	{
		$numentries = $checkentries['numitems'];
		eval("\$admin_message_delete_entries = \"".$vwartpl->get("admin_message_delete_entries")."\";");
	}

	eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
	eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_delete")."\");");
}

// ################################### list menu items ######################################
if ($GPC['action'] == "viewmenuitems")
{
	$vwartpllist = "admin_acpmenu_itemlist,admin_acpmenu_itemlistbit";
	$vwartpl->cache($vwartpllist);

	eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");

	$result = $vwardb->query_first("
		SELECT grouptitle
		FROM vwar".$n."_acpmenugroups
		WHERE groupid = '".$GPC["groupid"]."'
	");
	$grouptitle = $result["grouptitle"];
	unset($result);

	$result = $vwardb->query("
		SELECT itemid,itemtitle,displayorder,itemtype,groupid
		FROM vwar".$n."_acpmenuitems
		WHERE groupid = '".$GPC["groupid"]."'
		ORDER BY displayorder,itemtitle ASC
	");

	while ($row = $vwardb->fetch_array($result))
	{
		switchColors();

		if ($row["itemtype"] == "BREAK")
		{
			$row["itemtitle"] = '<font color="red">[break line]</font>';
		}

		eval("\$admin_acpmenu_itemlistbit .= \"".$vwartpl->get("admin_acpmenu_itemlistbit")."\";");
	}
	eval("\$vwartpl->output(\"".$vwartpl->get("admin_acpmenu_itemlist")."\");");
}

// ################################### add menu item #####################################
if ($GPC['action'] == "addmenuitem")
{
	if ($GPC['add'] || $GPC['add_x'])
	{
		// check for wrong data
		if (($GPC['itemtype'] == "LINE" &&
			(empty($GPC['itemtitle']) || empty($GPC['destination'])))
			|| empty($GPC["groupid"]))
		{
			$vwartpl->cache("admin_message_error_missingdata");
			eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
			eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_error_missingdata")."\");");
			exit();
		}

		if ($GPC["itemtype"] == "LINE")
		{
            // create rights string
            $tmp = explode("\r\n",$GPC["cond"]);
            foreach ($tmp AS $right)
            {
                if (!empty($right))
                {
                    $rights .= str_replace(";","",$right).";";
                }
            }
            $rights = substr($rights,0,(strlen($rights)-1));

            unset($right);
            unset($tmp);
        }
        else if ($GPC["itemtype"] == "BREAK")
        {
            unset($GPC["itemtitle"]);
            unset($GPC["destination"]);
            unset($GPC["cond"]);
            unset($GPC["condtype"]);
        }

        $vwardb->query("
            INSERT INTO vwar".$n."_acpmenuitems
                (`groupid`,`itemtype`,`displayorder`,`itemtitle`,`destination`,`cond`,`condtype`)
            VALUES
				('".$GPC['groupid']."','".$GPC['itemtype']."','".$GPC['displayorder']."',
				'".$GPC['itemtitle']."','".$GPC['destination']."','".$rights."',
                '".$GPC['condtype']."')
			");

		header("Location: " . $GPC['PHP_SELF'] . "?action=viewmenuitems&groupid=".$GPC["groupid"]);
		exit();
	}

	// prepare
	$grouplist = createMenuDropdown("groupid");

	// template-cache, standard-templates will be added by script:
	$vwartpl->cache("admin_acpmenu_itemadd");

	eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
	eval("\$vwartpl->output(\"".$vwartpl->get("admin_acpmenu_itemadd")."\");");
}

// ################################### edit menu item #####################################
if ($GPC['action'] == "editmenuitem")
{
	if ($GPC['add'] || $GPC['add_x'])
	{
		// check for wrong data
		if ((($GPC['isbreak'] == 0 || $GPC['itemtype'] == "LINE") &&
				(empty($GPC['itemtitle']) || empty($GPC['destination'])))
				|| empty($GPC["groupid_new"]))
		{
			$vwartpl->cache("admin_message_error_missingdata");
			eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
			eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_error_missingdata")."\");");
			exit();
		}

		if ($GPC["itemtype"] == "LINE")
		{
			// create rights string
            $tmp = explode("\r\n",$GPC["cond"]);
            foreach ($tmp AS $right)
            {
                if (!empty($right))
                {
                    $rights .= str_replace(";","",$right).";";
                }
            }
            $rights = substr($rights,0,(strlen($rights)-1));

            unset($right);
            unset($tmp);
        }
        else if ($GPC["itemtype"] == "BREAK")
        {
            unset($GPC["itemtitle"]);
            unset($GPC["destination"]);
            unset($GPC["cond"]);
            unset($GPC["condtype"]);
        }

        $vwardb->query("
            UPDATE vwar".$n."_acpmenuitems
            SET
                `groupid` = '".$GPC['groupid_new']."',
				`itemtype` = '".$GPC['itemtype']."',
				`displayorder` = '".$GPC['displayorder']."',
				`itemtitle` = '".$GPC['itemtitle']."',
				`destination` ='".$GPC['destination']."',
				`cond` = '".$rights."',
				`condtype` = '".$GPC['conditiontype']."'
            WHERE itemid = '".$GPC['itemid']."'
        ");

        header("Location: " . $GPC['PHP_SELF'] . "?action=viewmenuitems&groupid=".$GPC["groupid"]);
        exit();
    }

    $row = $vwardb->query_first("
        SELECT *
        FROM vwar".$n."_acpmenuitems
        WHERE itemid = '".$GPC['itemid']."'");

	// prepare
    $selectedtype[$row["itemtype"]]     = "selected";
    $selected[$row["condtype"]]     	= "selected";
    $row["cond"]                              		= str_replace(";","\n",$row["cond"]);
    $grouplist                                             = createMenuDropdown("groupid_new",$row["groupid"]);

    if ($row["itemtype"] == "BREAK")
    {
        $isbreak         = TRUE;
        $itemtitle     = '<font color="red">[break line]</font>';
        $info              = '(Item is a break line.      Title, Destination and Security will be ignored!</font>)</font>';
    }
    else
	{
		$itemtitle = $row["itemtitle"];
	}

	// template-cache, standard-templates will be added by script:
	$vwartpl->cache("admin_acpmenu_itemedit");

	eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
	eval("\$vwartpl->output(\"".$vwartpl->get("admin_acpmenu_itemedit")."\");");
}

// ################################### delete menu item #####################################
if ($GPC['action'] == "deletemenuitem")
{
	if ($delete)
	{
		$vwardb->query("DELETE FROM vwar".$n."_acpmenuitems WHERE itemid = '".$GPC["itemid"]."'");

		header("Location: ".$GPC['PHP_SELF']."?action=viewmenuitems&groupid=".$GPC["groupid"]);
		exit();
	}

	eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
	eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_delete")."\");");
}

// ################################### view quickjump ######################################
if ($GPC['action'] == "viewjumps")
{
	checkPermission("isadmin");
	require($vwar_root . "includes/language/english.inc.php");

	//template-cache, standard-templates will be added by script:
	$vwartpllist="admin_quickjumplist,admin_quickjumplistbit";
	$vwartpl->cache($vwartpllist);

	eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");

	$result = $vwardb->query("SELECT * FROM vwar".$n."_quickjump ORDER BY displayorder ASC, title ASC");
	while ($row = $vwardb->fetch_array($result))
	{
		dbSelect($row);
		switchColors();

		$oldtitle = $row['title'];

		eval('$row["title"] = "' . $row['title'] . '";');

		if (empty($row['title']))
		{
			$row['title'] = "<font color=\"red\">Missing data for &quot;" . $oldtitle . "&quot;</font>";
		}

		$active = getActiveTag(!$row['activated']);
		eval("\$admin_quickjumplistbit .= \"".$vwartpl->get("admin_quickjumplistbit")."\";");
	}

	eval("\$vwartpl->output(\"".$vwartpl->get("admin_quickjumplist")."\");");
}

// ################################### add quickjump ########################################
if ($GPC['action'] == "addjump")
{
	checkPermission("isadmin");

	if ($GPC['add'] || $GPC['add_x'])
	{
		// check for wrong data
		if($GPC['title'] == "" || $GPC['redirectto'] == "")
		{
			$vwartpl->cache("admin_message_error_missingdata");
			eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
			eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_error_missingdata")."\");");
			exit;
		}

		addQuickJump($GPC['title'],$GPC['redirectto'],$GPC['displayorder'],$GPC['activated']);

		header("Location: " . $GPC['PHP_SELF'] . "?action=viewjumps");
	}

	$activated = makeyesnocode("activated",1);

	$vwartpl->cache("admin_addquickjump");
	eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
	eval("\$vwartpl->output(\"".$vwartpl->get("admin_addquickjump")."\");");
}

// ################################### edit quickjump #######################################
if ($GPC['action'] == "editjump")
{
	checkPermission("isadmin");

	if ($GPC['add'] || $GPC['add_x'])
	{
		// check for wrong data
		if($GPC['title'] == "" || $GPC['redirectto'] == "")
		{
			$vwartpl->cache("admin_message_error_missingdata");
			eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
			eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_error_missingdata")."\");");
			exit;
		}

		$vwardb->query("
			UPDATE vwar".$n."_quickjump
			SET
			title 				= '" . $GPC['title'] . "',
			redirectto 		= '" . $GPC['redirectto'] . "',
			activated 		= '" . $GPC['activated'] . "',
			displayorder 	= '" . $GPC['displayorder'] . "'
			WHERE quickjumpid = '" . $GPC['jumpid'] . "'
		");

		header("Location: " . $GPC['PHP_SELF'] . "?action=viewjumps");
	}

	$row = $vwardb->query_first("SELECT * FROM vwar".$n."_quickjump WHERE quickjumpid = '" . $GPC['jumpid'] . "'");
	dbSelect($row);
	$activated = makeyesnocode("activated",$row['activated']);

	eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
	eval("\$vwartpl->output(\"".$vwartpl->get("admin_editquickjump")."\");");
}

// ################################### delete quickjump #####################################
if ($GPC['action'] == "deletejump")
{
	checkPermission("isadmin");

	if ($delete)
	{
		deleteQuickJump($GPC['jumpid']);
		header("Location: " . $GPC['PHP_SELF'] . "?action=viewjumps");
	}

	$vwartpl->cache("admin_message_delete");
	eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
	eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_delete")."\");");
}

// ################################### list language items ######################################
if ($GPC['action'] == "viewlanguage")
{
	$vwartpllist = "admin_languagelist,admin_languagelistbit";
	$vwartpl->cache($vwartpllist);

	eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");

	$result = $vwardb->query("
		SELECT languageid, languagetitle
		FROM vwar".$n."_customlanguage
		ORDER BY languagetitle ASC
	");

	while($row = $vwardb->fetch_array($result))
	{
		switchColors();

		eval("\$admin_languagelistbit .= \"".$vwartpl->get("admin_languagelistbit")."\";");
	}
	eval("\$vwartpl->output(\"".$vwartpl->get("admin_languagelist")."\");");
}

// ################################### add language item ######################################
if ($GPC['action'] == "addlanguage")
{
	if ($GPC['add'] || $GPC['add_x'])
	{
		$langfile = $vwar_root . "upload/" . $GPC['datafile'];

		// check for wrong data
		if (($transfer == "local" && ($GPC['datafile'] == ""
			|| !@file_exists($langfile))) || ($transfer=="upload" && (!$HTTP_POST_FILES['filename']['name']
			|| !$HTTP_POST_FILES['filename']['tmp_name'])))
		{
			$vwartpl->cache("admin_message_error_missingdata");
			eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
			eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_error_missingdata")."\");");
			exit;
		}

		if (!checkLanguageFiles($vwar_root."includes/language/"))
		{
			$errormsg = "No language file is writable!<br />Set all language files to chmod 777!";

			eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
			eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_error_generalerror")."\");");
			exit;
		}

		if ($transfer == "local")
		{
			addLanguageVars($langfile);
		}
		else if ($transfer == "upload")
		{
			// create a unique filename
			$langfile = $vwar_root . "upload/".createRandomPassword(8,"abcdefghijklmnopqrstuvwxyz") . ".vwar";

			// using own upload code, because class_upload is for images
			if (!ini_get("file_uploads"))
			{
				$errormsg = "File uploads are disabled in your php.ini!";
			}
			elseif(@file_exists($langfile))
			{
				$errormsg = "There's already existing a file with the same name you're trying to upload!";
			}
			elseif(!is_uploaded_file($HTTP_POST_FILES['filename']['tmp_name']))
			{
				$errormsg = "File couldn't be uploaded!";
			}
			elseif(!move_uploaded_file($HTTP_POST_FILES['filename']['tmp_name'], $langfile))
			{
				$errormsg = "File couldn't be moved out of the servers temp folder!";
			}

			if (!empty($errormsg))
			{
				eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
				eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_error_uploaderror")."\");");
				exit;
			}
			else
			{
				addLanguageVars($langfile);

				@unlink($langfile);
			}
		}

		header("Location: " . $GPC['PHP_SELF'] . "?action=viewlanguage");
		exit;
	}

	$vwartpllist = "admin_addlanguage,languageselectbit";
	$vwartpl->cache($vwartpllist);

	while (list($languagekey,$languageval) = each($languages))
	{
		$languagesel[$languagekey] = ($languagekey == $vwarlanguage) ? "selected" : "";

		eval("\$languageselectbit .= \"".$vwartpl->get("languageselectbit")."\";");
	}
	eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
	eval("\$vwartpl->output(\"".$vwartpl->get("admin_addlanguage")."\");");
}

// ################################### delete language item #####################################
if ($GPC['action'] == "deletelanguage")
{
	if ($delete)
	{
		deleteLanguageVars($GPC['languageid'],1);

		header("Location: ".$GPC['PHP_SELF']."?action=viewlanguage");
		exit();
	}

	eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
	eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_delete")."\");");
}
// ################################### restore menu ######################################
if ($GPC['action'] == "restoremenu")
{
		if(!function_exists("base64_decode") || !function_exists("gzuncompress"))
		{
				$diemessage .= '<p style="FONT-FAMILY:verdana,tahoma,arial,sans-serif;FONT-SIZE:13px;">';
				$diemessage .= '<b>The functions &quot;base64_decode&quot; and &quot;gzuncompress&quot; aren\'t available!</b></p>';
				die($diemessage);
		}

	if ($GPC['delete'] || $GPC['delete_x'])
	{
				$data =
"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";

				$vwardb->query("TRUNCATE TABLE vwar".$n."_acpmenugroups");
				$vwardb->query("TRUNCATE TABLE vwar".$n."_acpmenuitems");

				$vwardb->query("INSERT INTO vwar".$n."_acpmenugroups VALUES (1, 'war', 'War Admin', 'canaddwar;caneditwar;candeletewar;canfinishwar;canaddserver;caneditserver;candeleteserver;canaddlocation;caneditlocation;candeletelocation;canaddmatchtype;caneditmatchtype;candeletematchtype;canaddgametype;caneditgametype;candeletegametype;canaddgame;caneditgame;candeletegame', 'OR', 0)");
				$vwardb->query("INSERT INTO vwar".$n."_acpmenugroups VALUES (2, 'member', 'Member Admin', 'canaddmember;caneditmember;candeletemember;canaddstatus;caneditstatus;candeletestatus;canaddprofilefield;caneditprofilefield;candeleteprofilefield;canaddpermission;caneditpermission;candeletepermission;canaddteam;caneditteam;candeleteteam;canaddmailgroup;caneditmailgroup;candeletemailgroup;cansendmembermail', 'OR', 1)");
				$vwardb->query("INSERT INTO vwar".$n."_acpmenugroups VALUES (3, 'calendar', 'Calendar Admin', 'canaddevent;caneditevent;candeleteevent', 'OR', 2)");
				$vwardb->query("INSERT INTO vwar".$n."_acpmenugroups VALUES (4, 'cash', 'Cash Admin', '', 'OR', 3)");
				$vwardb->query("INSERT INTO vwar".$n."_acpmenugroups VALUES (5, 'news', 'News Admin', 'canaddnews;caneditnews;candeletenews;canaddcategory;caneditcategory;candeletecategory;isadmin', 'OR', 4)");
				$vwardb->query("INSERT INTO vwar".$n."_acpmenugroups VALUES (6, 'admin', 'Settings / Admin', 'isadmin', 'OR', 5)");

				$vwardb->query(gzuncompress(base64_decode($data),strlen($data)));

				$diemessage .= '<p style="FONT-FAMILY:verdana,tahoma,arial,sans-serif;FONT-SIZE:13px;">';
				$diemessage .= '<b>Please reload the Administrator Control Panel!</b></p>';
				die($diemessage);
		}

	eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
	eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_restorewarning")."\");");
}
?>