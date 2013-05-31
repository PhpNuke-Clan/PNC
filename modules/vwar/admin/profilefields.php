<?php
/* #####################################################################################
 *
 * $Id: profilefields.php,v 1.15 2004/09/12 12:58:09 mabu Exp $
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
$adminquery		= "";

if (!checkCookie())
{
	header("Location: index.php");
}

// ################################### view profile fields #############################
if ($GPC['action'] == "viewprofilefields")
{
	checkPermission("canaddprofilefield-candeleteprofilefield-caneditprofilefield");
	//template-cache, standard-templates will be added by script:
	$vwartpllist="admin_profilefield_listbit,admin_profilefield_list";
	$vwartpl->cache($vwartpllist);

	eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");

	// first select cats
	$result = $vwardb->query("SELECT * FROM vwar".$n."_pfield_cat ORDER BY displayorder ASC, catname ASC");
	while ($row = $vwardb->fetch_array($result))
	{
		dbSelect($row);

		$fieldname = $row['catname'];
		$fielddisplayorder = $row['displayorder'];
		$pcat_id = $row['pcat_id'];

		eval("\$admin_profilefield_listbit .= \"".$vwartpl->get("admin_profilefield_catlistbit")."\";");

		// get the fields below the cat
		$result2 = $vwardb->query("
			SELECT * FROM vwar".$n."_profilefield
			WHERE cat_id = '".$row['pcat_id']."'
			ORDER BY displayorder ASC, fieldname ASC
		");
		while ($field = $vwardb->fetch_array($result2))
		{
			dbSelect($field);

			$pfield_id = $field['profilefieldid'];
			$fieldname = $field['fieldname'];
			$fieldpublic = ($field['public'] == 1 ? "Public" : "Not public");
			$fieldlocked = ($field['adminonly'] == 1 ? "Locked" : "Not Locked");
			$fielddisplayorder = $field['displayorder'];

			eval("\$admin_profilefield_listbit .= \"".$vwartpl->get("admin_profilefield_listbit")."\";");
		}
	}

	eval("\$vwartpl->output(\"".$vwartpl->get("admin_profilefield_list")."\");");
}
// ################################### add profile field ###############################
if ($GPC['action'] == "addprofilefield")
{
	checkPermission("canaddprofilefield");

	if ($GPC['add'] || $GPC['add_x'])
	{
		// check for wrong data
		if ($fieldname == "" || $description == "" || $pcat_id == "")
		{
			$vwartpl->cache("admin_message_error_missingdata");
			eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
			eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_error_missingdata")."\");");
			exit;
		}
		$vwardb->query("INSERT INTO vwar".$n."_profilefield (
			fieldname, description, public, displayorder, adminonly, smiliecode, htmlcode, bbcode, allowimages, fieldlength, cat_id
			) VALUES (
			'".$fieldname."',
			'".$description."',
			'$public',
			'$displayorder',
			'$adminonly',
			'$smiliecode',
			'$htmlcode',
			'$bbcode',
			'$allowimages',
			'$fieldlength',
			'$pcat_id')
		");
		header("Location: profilefields.php?action=viewprofilefields");
	}
	else
	{
		$vwartpl->cache("admin_addprofilefield");

		$result = $vwardb->query("SELECT pcat_id, catname FROM vwar".$n."_pfield_cat ORDER BY catname ASC");
		while ($cat = $vwardb->fetch_array($result))
		{
			dbSelectForm($row);

			$selectvalue = $cat['pcat_id'];
			$selectname = $cat['catname'];
			$selected[$selectvalue] == "";

			eval("\$catselect .= \"".$vwartpl->get("admin_catselectbit")."\";");
		}

		$public = makeyesnocode("public");
		$adminonly = makeyesnocode("adminonly",0);
		$smiliecode = makeyesnocode("smiliecode",0);
		$htmlcode = makeyesnocode("htmlcode",0);
		$bbcode = makeyesnocode("bbcode",0);
		$allowimages = makeyesnocode("allowimages",0);

		eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
		eval("\$vwartpl->output(\"".$vwartpl->get("admin_addprofilefield")."\");");
	}
}
// ################################### edit profile field ##############################
if ($GPC['action'] == "editprofilefield")
{
	checkPermission("caneditprofilefield");

	if($GPC['add'] || $GPC['add_x'])
	{
		// check for wrong data
		if ($fieldname == "" || $description == "" || $pcat_id == "")
		{
			$vwartpl->cache("admin_message_error_missingdata");
			eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
			eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_error_missingdata")."\");");
			exit;
		}

		$adminquery = ifelse(checkPermission("isadmin","",1), "adminonly = '$adminonly',");
		$vwardb->query("
			UPDATE vwar".$n."_profilefield SET
			fieldname = '".$fieldname."',
			description = '".$description."',
			public = '$public',
			displayorder = '$displayorder',
			smiliecode = '$smiliecode',
			htmlcode = '$htmlcode',
			bbcode = '$bbcode',
			allowimages = '$allowimages',
			fieldlength = '$fieldlength',
			$adminquery
			cat_id = '$pcat_id'
			WHERE profilefieldid = '$profilefieldid'
		");
		header("Location: profilefields.php?action=viewprofilefields");
	}
	else
	{
		$row = $vwardb->query_first("SELECT * FROM vwar".$n."_profilefield WHERE profilefieldid = '".$GPC['profilefieldid']."'");

		dbSelectForm($row);
		$public = makeyesnocode("public", $row['public']);
		$adminonly = makeyesnocode("adminonly", $row['adminonly']);
		$smiliecode = makeyesnocode("smiliecode", $row['smiliecode']);
		$htmlcode = makeyesnocode("htmlcode", $row['htmlcode']);
		$bbcode = makeyesnocode("bbcode", $row['bbcode']);
		$allowimages = makeyesnocode("allowimages", $row['allowimages']);

		$result = $vwardb->query("SELECT pcat_id, catname FROM vwar".$n."_pfield_cat ORDER BY catname ASC");
		while ($cat = $vwardb->fetch_array($result))
		{
			dbSelectForm($cat);

			$selectvalue = $cat['pcat_id'];
			$selectname = $cat['catname'];
			$selected[$row['cat_id']] = ifelse($selectvalue == $row['cat_id'], "selected");

			eval("\$catselect .= \"".$vwartpl->get("admin_catselectbit")."\";");
		}
		$vwartpl->cache("admin_editprofilefield");
		eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
		eval("\$vwartpl->output(\"".$vwartpl->get("admin_editprofilefield")."\");");
	}
}

// ################################### delete profile field ############################
if ($GPC['action'] == "deleteprofilefield")
{
	checkPermission("candeleteprofilefield");

	if($delete)
	{
		$vwardb->query("DELETE FROM vwar".$n."_profilefield WHERE profilefieldid = '$profilefieldid'");
		$vwardb->query("DELETE FROM vwar".$n."_memberprofilefield WHERE profilefieldid = '$profilefieldid'");
		header("Location: profilefields.php?action=viewprofilefields");
	}
	else
	{
		$vwartpl->cache("admin_message_delete,admin_message_delete_entries");

		// check for other entries linked with this one
		$checkentries = $vwardb->query_first("
			SELECT COUNT(memberprofilefieldid) AS numfields
			FROM vwar".$n."_memberprofilefield
			WHERE profilefieldid = '".$GPC['profilefieldid']."'
		");
		if ($checkentries['numfields'] > 0)
		{
			$numentries = $checkentries['numfields'];
			eval("\$admin_message_delete_entries .= \"".$vwartpl->get("admin_message_delete_entries")."\";");
		}
		eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
		eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_delete")."\");");
	}
}

// ################################# add profile field category ########################
if ($GPC['action']=="addprofilefieldcat")
{
	checkPermission("canaddprofilefield");

	if ($GPC['add'] || $GPC['add_x'])
	{
		// check for wrong data
		if ($catname == "")
		{
			$vwartpl->cache("admin_message_error_missingdata");
			eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
			eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_error_missingdata")."\");");
			exit;
		}
		$vwardb->query("
			INSERT INTO vwar".$n."_pfield_cat
			(catname, description, displayorder) VALUES (
			'".$catname."',
			'".$description."',
			'$displayorder')
		");

		header("Location: profilefields.php?action=viewprofilefields");
	}
	else
	{
		$vwartpl->cache("admin_addprofilefield");

		eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
		eval("\$vwartpl->output(\"".$vwartpl->get("admin_addprofilefieldcat")."\");");
	}
}

// ################################# edit profile field category #######################
if ($GPC['action'] == "editprofilefieldcat")
{
	checkPermission("caneditprofilefield");

	if ($GPC['add'] || $GPC['add_x'])
	{
		// check for wrong data
		if ($catname == "")
		{
			$vwartpl->cache("admin_message_error_missingdata");
			eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
			eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_error_missingdata")."\");");
			exit;
		}
		$vwardb->query("
			UPDATE vwar".$n."_pfield_cat SET
			catname = '".$catname."',
			description = '".$description."',
			displayorder = '$displayorder'
			WHERE pcat_id = '$pcat_id'
		");
		header("Location: profilefields.php?action=viewprofilefields");
	}
	else
	{
		$row = $vwardb->query_first("SELECT * FROM vwar".$n."_pfield_cat WHERE pcat_id='".$GPC['pcat_id']."'");
		dbSelectForm($row);

		$vwartpl->cache("admin_editprofilefieldcat");

		eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
		eval("\$vwartpl->output(\"".$vwartpl->get("admin_editprofilefieldcat")."\");");
	}
}

// ################################# delete profile field cat ##########################
if ($GPC['action'] == "deleteprofilefieldcat")
{
	checkPermission("candeleteprofilefield");

	if ($delete)
	{
		// delete profilefield cat
		$vwardb->query("DELETE FROM vwar".$n."_pfield_cat WHERE pcat_id = '$pcat_id'");

		// delete profilefields from members
		$result = $vwardb->query("SELECT profilefieldid FROM vwar".$n."_profilefield WHERE cat_id = '$pcat_id'");
		while ($row = $vwardb->fetch_array($result))
		{
			$vwardb->query("DELETE FROM vwar".$n."_memberprofilefield WHERE profilefieldid = '".$row['profilefieldid']."'");
		}

		// delete profilefields
		$vwardb->query("DELETE FROM vwar".$n."_profilefield WHERE cat_id = '$pcat_id'");

		header("Location: profilefields.php?action=viewprofilefields");
	}
	else
	{
		$vwartpl->cache("admin_message_delete,admin_message_delete_entries");

		// check for other entries linked with this one
		$checkentries = $vwardb->query_first("
			SELECT COUNT(cat_id) AS numfields
			FROM vwar".$n."_profilefield
			WHERE cat_id = '".$GPC['pcat_id']."'
		");
		if ($checkentries['numfields'] > 0)
		{
			$numentries = $checkentries['numfields'];
			eval("\$admin_message_delete_entries .= \"".$vwartpl->get("admin_message_delete_entries")."\";");
		}
		eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
		eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_delete")."\");");
	}
}
?>