<?php
/* #####################################################################################
 *
 * $Id: cash.php,v 1.35 2004/09/12 12:58:09 mabu Exp $
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

// ################################### cashlist ########################################
if ($GPC['action'] == "cashlist" || $GPC['action'] == "")
{
	//checkPermission("canaddcash-caneditcash-candeletecash");
	//template-cache, standard-templates will be added by script:
	$vwartpllist = "admin_cashlistbit,admin_cashlist";
	$vwartpl->cache($vwartpllist);

	eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");

	$result = $vwardb->query_first("SELECT COUNT(cashid) AS numcash FROM vwar".$n."_cash WHERE deleted = '0'");
	$numcash = $result['numcash'];

	$result = $vwardb->query_first("
		SELECT SUM(amount) AS sum
		FROM vwar".$n."_cash
		WHERE deleted = '0'
		AND (MONTH(bookingdate) = MONTH(NOW()))
		AND (YEAR(bookingdate) = YEAR(NOW()))
	");
	$thismonthcash = $result['sum'];

	if (empty($thismonthcash)) $thismonthcash = 0;

	$result = $vwardb->query_first("SELECT SUM(amount) AS sum FROM vwar".$n."_cash WHERE deleted = '0'");
	$totalcash = $result['sum'];

	if (empty($totalcash)) $totalcash = 0;

	if ($page <> "All" || $page > 1)
	{
		$tmp_amount = 0;
		if(!isset($s)) $s = 0;

		$result = $vwardb->query("SELECT amount FROM vwar".$n."_cash WHERE deleted = '0' ORDER BY bookingdate DESC LIMIT $s,$numcash");
		while ($row = $vwardb->fetch_array($result))
		{
			$tmp_amount += $row['amount'];
		}
		$current_amount = $tmp_amount;
	}
	else
	{
		$current_amount = $totalcash;
	}

	$result = $vwardb->query("
		SELECT  vwar".$n."_cash.*, catname
		FROM vwar".$n."_cash
		LEFT JOIN vwar".$n."_cashcat ON (vwar".$n."_cash.catid = vwar".$n."_cashcat.catid)
		ORDER  BY bookingdate DESC
		" . getLimitClause()
	);
	while ($row = $vwardb->fetch_array($result))
	{
		dbSelect($row);
		switchColors();

		if($row['amount'] < 0)
		{
			$color = "#800000";
		}

		if($row['amount'] > 0)
		{
			$sign = "+";
			$color = "#008000";
		}

		$bookingdate = split("[-]",$row['bookingdate']);
		$row['bookingdate'] = $bookingdate[2] . "." . $bookingdate[1] . "." . $bookingdate[0];

				if(!empty($row["catid"])) $row["purpose"] = $row["catname"];

		$active = getActiveTag($row['deleted'], "Cash Entry");

		// round values
		$row['amount'] = round($row['amount'],2);
		$current_amount = round($current_amount,2);
		$thismonthcash = round($thismonthcash,2);
		$totalcash = round($totalcash,2);

		eval ("\$admin_cashlistbit .= \"".$vwartpl->get("admin_cashlistbit")."\";");

		if($row['deleted'] == 0) $current_amount -= $row['amount'];
	}
	$pagelinks = makepagelinks($numcash,$perpage,"action=cashlist");

	eval("\$vwartpl->output(\"".$vwartpl->get("admin_cashlist")."\");");
}

// ################################### add cash ########################################
if ($GPC['action'] == "addcash")
{
	checkPermission("canaddcash");

	if ($GPC['add'] || $GPC['add_x'])
	{
		// check for wrong data
		if ($GPC["month"] == "-1" || $GPC["day"] == "-1" || $GPC["year"] == "" || $GPC["amount"] == ""
						|| ($GPC["purpose"] == "" && $GPC["catid"] == ""))
		{
			$vwartpl->cache("admin_message_error_missingdata");
			eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
			eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_error_missingdata")."\");");
			exit;
		}
		$bookingdate = $GPC["year"] . "-" . $GPC["month"] . "-" . $GPC["day"];
		$amount = $sign . round($GPC["amount"],2);

				if(!empty($GPC["purpose"]) && !empty($GPC["catid"]))
				{
						$GPC["catid"] = 0;
				}

		$vwardb->query("
			INSERT INTO vwar".$n."_cash
			(amount,purpose,catid,bookingdate)
			VALUES (
			'$amount',
			'".$GPC["purpose"]."',
			'".$GPC["catid"]."',
			'".$bookingdate."')
		");

		header("Location: cash.php?action=cashlist");
	}
	else
	{
		//template-cache, standard-templates will be added by script:
		$vwartpllist = "admin_dateselect,admin_addcash,news_catselectbit,admin_selectbitdefault";
		$vwartpl->cache($vwartpllist);

				eval("\$catselectbit .= \"".$vwartpl->get("admin_selectbitdefault")."\";");
				$result = $vwardb->query("
						SELECT catid,catname
						FROM vwar".$n."_cashcat
						ORDER BY catname ASC
				");
				while ($row = $vwardb->fetch_array($result))
				{
						$catid = $row["catid"];
						$catname = dbSelectForm($row["catname"]);

						eval("\$catselectbit .= \"".$vwartpl->get("news_catselectbit")."\";");
				}

		eval ("\$dateselect = \"".$vwartpl->get("admin_dateselect")."\";");
		eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
		eval("\$vwartpl->output(\"".$vwartpl->get("admin_addcash")."\");");
	}
}

// ################################### edit cash #######################################
if ($GPC['action'] == "editcash")
{
	checkPermission("caneditcash");

	if ($GPC['add'] || $GPC['add_x'])
	{
		// check for wrong data
		if ($GPC["month"] == "-1" || $GPC["day"] == "-1" || $GPC["year"] == "" || $GPC["amount"] == ""
						|| ($GPC["purpose"] == "" && $GPC["catid"] == ""))
		{
			$vwartpl->cache("admin_message_error_missingdata");
			eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
			eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_error_missingdata")."\");");
			exit;
		}
		$bookingdate = $GPC["year"] . "-" . $GPC["month"] . "-" . $GPC["day"];
		$amount = $sign . round($GPC["amount"],2);

				if(!empty($GPC["purpose"]) && !empty($GPC["catid"]))
				{
						$GPC["catid"] = 0;
				}

		$vwardb->query("
			UPDATE vwar".$n."_cash
			SET
			amount = '".$amount."',
			purpose = '".$GPC["purpose"]."',
			bookingdate = '".$bookingdate."',
			catid = '".$GPC["catid"]."',
			deleted = '".$GPC["deleted"]."'
			WHERE cashid = '".$GPC['cashid']."'
		");

		header("Location: cash.php?action=cashlist");
	}

	//template-cache, standard-templates will be added by script:
	$vwartpllist = "admin_dateselect,admin_editcash,news_catselectbit,admin_selectbitdefault";
	$vwartpl->cache($vwartpllist);

	eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");

	$row = $vwardb->query_first("SELECT * FROM vwar".$n."_cash WHERE cashid = '".$GPC['cashid']."'");
	dbSelectForm($row);

	if ($row['bookingdate'] == '0000-00-00')
	{
		$daydefaultselected = "selected";
		$monthdefaultselected = "selected";
	}
	else
	{
		$bookingdate = split("-",$row['bookingdate']);
		$year = $bookingdate[0];
		$month = $bookingdate[1];
		$day = $bookingdate[2];

		$monthselected[$month] = "selected";
		$dayselected[$day] = "selected";
		$yearselected[$year] = "selected";
	}

	$deleted = makeyesnocode("deleted",$row['deleted']);

	if ($row['amount'] >= 0)
	{
		$selected['positive'] = "selected";
	}
	else if ($row['amount'] < 0)
	{
		$selected['negative'] = "selected";
	}

	$row["amount"] = abs(round($row['amount'],2));

	// save temp data
	$old_row = $row;
	unset($row);

	eval("\$catselectbit .= \"".$vwartpl->get("admin_selectbitdefault")."\";");
	$result = $vwardb->query("
		SELECT catid,catname
		FROM vwar".$n."_cashcat
		ORDER BY catname ASC
	");
	while ($row = $vwardb->fetch_array($result))
	{
		$catid = $row["catid"];
		$catname = dbSelectForm($row["catname"]);
		$selected = ($old_row["catid"] == $row["catid"]) ? "selected" : "";

		eval("\$catselectbit .= \"".$vwartpl->get("news_catselectbit")."\";");
	}
	$vwardb->free_result($result);

	// restore temp data
	unset($row);
	$row = $old_row;

	eval ("\$dateselect = \"".$vwartpl->get("admin_dateselect")."\";");
	eval("\$vwartpl->output(\"".$vwartpl->get("admin_editcash")."\");");
}

// ################################### delete cash #####################################
if ($GPC['action'] == "deletecash")
{
	checkPermission("candeletecash");

	if ($delete)
	{
		$vwardb->query("DELETE FROM vwar".$n."_cash WHERE cashid = '".$GPC['cashid']."'");
		header("Location: cash.php?action=cashlist");
	}
	$vwartpl->cache("admin_message_delete");

	eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
	eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_delete")."\");");
}

// ################################### view categories #################################
if ($GPC["action"] == "viewcategories")
{
	checkPermission ("canaddcashcategory-caneditcashcategory-candeletecashcategory");
	$vwartpl->cache("admin_cashcategorylistbit,admin_categorylist");
	eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");

	$result = $vwardb->query("SELECT catid, catname FROM vwar".$n."_cashcat ORDER BY catname ASC");
	while ($row = $vwardb->fetch_array($result))
	{
		switchColors();
		dbSelect($row);

		eval("\$admin_categorylistbit .= \"".$vwartpl->get("admin_cashcategorylistbit")."\";");
	}

	eval("\$vwartpl->output(\"".$vwartpl->get("admin_categorylist")."\");");
}

// ################################### add category ########################################
if ($GPC['action'] == "addcategory")
{
	checkPermission("canaddcashcategory");

	if ($GPC['add'] || $GPC['add_x'])
	{
		// check for wrong data
		if ($GPC["catname"] == "")
		{
			$vwartpl->cache("admin_message_error_missingdata");
			eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
			eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_error_missingdata")."\");");
			exit;
		}

		$vwardb->query("INSERT INTO vwar".$n."_cashcat (catname) VALUES ('".$GPC["catname"]."')");

		header("Location: cash.php?action=viewcategories");
	}
	else
	{
		//template-cache, standard-templates will be added by script:
		$vwartpllist = "admin_addcashcategory";
		$vwartpl->cache($vwartpllist);

		eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
		eval("\$vwartpl->output(\"".$vwartpl->get("admin_addcashcategory")."\");");
	}
}

// ################################### edit category ###################################
if ($GPC["action"] == "editcategory")
{
	checkPermission("caneditcashcategory");

	if ($GPC["add"] || $GPC["add_x"])
	{
		// check for wrong data
		if ($GPC["catname"] == "")
		{
			$vwartpl->cache("admin_message_error_missingdata");
			eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
			eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_error_missingdata")."\");");
			exit;
		}

		$vwardb->query("UPDATE vwar".$n."_cashcat
		SET
			catname = '".$GPC["catname"]."'
		WHERE catid = '".$GPC["catid"]."'");

		header("Location: cash.php?action=viewcategories");
	}
	else
	{
		$vwartpl->cache("admin_editcashcategory");
		$row = $vwardb->query_first("
			SELECT catname
			FROM vwar".$n."_cashcat
			WHERE catid = '".$GPC["catid"]."'
		");
		dbSelectForm($row);

		eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
		eval("\$vwartpl->output(\"".$vwartpl->get("admin_editcashcategory")."\");");
	}
}

// ################################### delete category #################################
if ($GPC["action"] == "deletecategory")
{
	checkPermission("candeletecashcategory");

	if ($GPC['delete'])
	{
				// update entries
				$data = $vwardb->query_first("SELECT catname FROM vwar".$n."_cashcat WHERE catid = '".$GPC["catid"]."'");
				$vwardb->query("UPDATE vwar".$n."_cash SET catid = '0', purpose = '".$data["catname"]."' WHERE catid = '".$GPC["catid"]."'");

		$vwardb->query("DELETE FROM vwar".$n."_cashcat WHERE catid = '".$GPC["catid"]."'");
		header("Location: cash.php?action=viewcategories");
	}

	$vwartpl->cache("admin_message_delete");
	eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
	eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_delete")."\");");
}
?>