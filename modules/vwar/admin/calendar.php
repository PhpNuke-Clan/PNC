<?php
/* #####################################################################################
 *
 * $Id: calendar.php,v 1.50 2004/09/12 12:58:09 mabu Exp $
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

// ################################### modify calendar #################################
if ($GPC['action'] == "modifycalendar" || $GPC['action'] == "")
{
	checkPermission("canaddevent-caneditevent");
	//template-cache, standard-templates will be added by script:
	$vwartpllist="admin_calendar_calendarbit_today,admin_calendar_calendarbit,admin_calendar";
	$vwartpl->cache($vwartpllist);

	eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");

	// ### redefine weekdays and start week at selected day ###
	$weekdays = array();

	for ($countup = 1; $countup <= (7 - $startofweek); $countup++)
	{
		if ($countup == 7)
		{
			$weekdays[0] = $weekdaynames[$startofweek + $countup - 1];
		} else {
			$weekdays[$countup] = $weekdaynames[$startofweek + $countup - 1];
		}
	}

	for ($countdown = 7; $countdown > (7 - $startofweek); $countdown--)
	{
		// check if it's the last available day
		if (($countdown - 1 - (7 - $startofweek)) == 0)
		{
			if ($countdown == 7)
			{
				$weekdays[0] = $weekdaynames[0];
			} else {
				$weekdays[$countdown]=$weekdaynames[0];
			}
		}
		else
		{
			if ($countdown == 7)
			{
				$weekdays[0] = $weekdaynames[$countdown - 1 - (7 - $startofweek)];
			} else {
				$weekdays[$countdown] = $weekdaynames[$countdown - 1 - (7 - $startofweek)];
			}
		}
	}
	$weekdaynames = $weekdays;

	// start calendar precalculations
	$current_day = date("j",time() + $timezoneoffset * 3600);
	$current_month = date("n",time() + $timezoneoffset * 3600);
	$current_year = date("Y",time() + $timezoneoffset * 3600);


	if (!isset($month)) $month = $current_month;
	if (!isset($year)) $year = $current_year;

	$numdays = date("t", mktime ( 0, 0, 0, $month + 1, 0, $year));

	$calendar_headline = $monthnames[$month] . "&nbsp;" . $year;

	$searchmonth = ifelse($month < 10, "0" . $month, $month);

	// do calendar output
	$displayday = $startofweek;
	$lastday = $startofweek + 6;

	if ($lastday > 6)
	{
		$lastday = $lastday - 7;
	}

	$end = false;
	$counter = 1;

	$calendarbits = "<tr>\n";

	while (!$end)
	{
		for ($i = 0; $i < 7; $i++)
		{

			// get events
			$searchday = ifelse($counter < 10, "0" . $counte, $counter);

			$dateline_low = mktime( 0, 0, 0, $month, $counter, $year);
			$dateline_high = mktime( 23, 59, 59, $month, $counter, $year);

			$result = $vwardb->query("
				SELECT * FROM vwar".$n."_calendarevents
				WHERE ( (eventdate >= $dateline_low AND eventdate <= $dateline_high)
				OR (eventdate <= $dateline_high AND $dateline_high <= enddate)
				OR (enddate >= $dateline_low AND enddate <= $dateline_high) )
				AND deleted = '0'
			");
			while ($row = $vwardb->fetch_array($result))
			{
				dbSelect($row);

				$eventimage = makeimgtag($vwar_root . "images/button_" .
											ifelse($row['eventdate'] != $row['enddate'], "repeat", "event") .
											".gif", substr($row['eventdetails'],0,100) . "...","top") . "&nbsp;";

				$eventline[] = $eventimage . makelink("calendar.php?action=editevent&amp;eventid=$row[eventid]",$row['event']);
			}

			$today = mktime( 0, 0, 0, $month, $counter, $year);

			if (date("w", $today) == $displayday AND $month == date("n", $today))
			{
				for ($z = 0; $z < count($eventline); $z++)
				{
					$eventlink .= $eventline[$z] . "<br>";
				}
				$daylink = date("d", mktime( 0, 0, 0, $month, $counter, $year));


				// do days and highlight today
				eval("\$calendarbits .= \"".$vwartpl->get(
					ifelse($counter == $current_day && $month == $current_month && $year == $current_year,
						"admin_calendar_calendarbit_today","admin_calendar_calendarbit"))."\";");

				$counter++;

				if (date("w", $today) == $lastday)
				{
					$calendarbits .= "</tr>\n";

					if($counter < $numdays) $calendarbits .= "<tr>\n";
				}
			}
			else
			{
				if (date("w", mktime( 0, 0, 0, $month, $counter, $year)) != $startofweek)
				{
					$calendarbits .= "<td height=\"75\" width=\"14%\" class=\"firstalt\" valign=top>&nbsp;</td>\n";
				}

				if ($counter > 1) $end = true;
			}
			$displayday++;

			if ($displayday > 6) $displayday = 0;

			unset($daylink);
			unset($eventlink);
			unset($eventline);
		}
	}

	$calendarbits .= "</tr>\n";

	$monthselected = "month" . $month . "selected";
	$$monthselected = "selected";

	$min_year = $current_year;
	$count = 1;

	for ($selectyear = $min_year - 4; $selectyear < ($min_year + 5); $selectyear++)
	{
		$yearvalue[$count] = $selectyear;

		if ($year == $selectyear)
		{
			$yearselected = "year" . $count . "selected";
			$$yearselected="selected";
		}
		$count++;
	}

	$jumptocurrentmonth = ifelse($month == $current_month && $year == $current_year, "", makelink($GPC['PHP_SELF'],"&raquo;&nbsp;jump to current month"));

	// generate prev, next month links
	if ($month != 1)
	{
		$previousmonthlink = makelink($GPC['PHP_SELF'] . "?month=" . ($month - 1) . "&amp;year=" . $year,"&laquo;&nbsp;" . $monthnames[date("n", mktime( 0, 0, 0, $month - 1, 1, $year))] . "&nbsp;" . $year);
	} else {
		$previousmonthlink = makelink($GPC['PHP_SELF'] . "?month=12&amp;year=" . ($year - 1),"&laquo;&nbsp;".$monthnames[date("n", mktime( 0, 0, 0, $month - 1, 1, $year - 1))] . "&nbsp;" . ($year - 1));
	}

	if ($month != 12)
	{
		$nextmonthlink = makelink($GPC['PHP_SELF'] . "?month=" . ($month + 1) . "&amp;year=" . $year,$monthnames[date("n", mktime( 0, 0, 0, $month + 1, 1, $year))] . "&nbsp;" . $year."&nbsp;&raquo;");
	} else {
		$nextmonthlink = makelink($GPC['PHP_SELF'] . "?month=1&amp;year=" . ($year+1),$monthnames[date("n", mktime( 0, 0, 0, $month + 1, 1, $year + 1))] . "&nbsp;" . ($year + 1) . "&nbsp;&raquo;");
	}

	eval("\$vwartpl->output(\"".$vwartpl->get("admin_calendar")."\");");
}

// ################################### add event #######################################
if ($GPC['action'] == "addevent")
{
	checkPermission("canaddevent");

	if ($GPC['add'] || $GPC['add_x'])
	{
		// make timestamp
		list ($hour, $minute) = split("[:]", $eventtime);
		$dateline = mktime( $hour, $minute, 0, $month, $day, $year);

		if ($dateline < 0 ) $dateline = 0;

		list ($endhour, $endminute) = split("[:]", $endtime);
		$enddateline = mktime( $endhour, $endminute, 0, $endmonth, $endday, $endyear);

		if($enddateline < 0 ) $enddateline = 0;

		// check for wrong data
		if (!$enddateline || !$dateline || !($enddateline >= 0) || !($enddateline >= 0) || $enddateline < $dateline || $event == "")
		{
			$vwartpl->cache("admin_message_error_missingdata");
			eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
			eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_error_missingdata")."\");");
			exit;
		}

		$vwardb->query("
			INSERT INTO vwar".$n."_calendarevents
			(memberid,event,eventdetails,eventdate,enddate,eventadded)
			VALUES (
			'".$GPC['vwarid']."',
			'".$event."',
			'".$warinfo."',
			'$dateline',
			'$enddateline',
			'".time()."')
		");

		header("Location: calendar.php?month=".date("m",$dateline)."&year=".date("Y",$dateline)."");
	}
	else
	{
		//template-cache, standard-templates will be added by script:
		$vwartpllist="admin_dateselect,admin_calendar_addevent";
		$vwartpl->cache($vwartpllist);

		getTextRestrictions("vwarform","warinfo","secondalt",1);

		eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
		eval("\$dateselect = \"".$vwartpl->get("admin_dateselect")."\";");
		eval("\$vwartpl->output(\"".$vwartpl->get("admin_calendar_addevent")."\");");
	}
}

// ################################### edit event ######################################
if ($GPC['action'] == "editevent")
{
	checkPermission("caneditevent");

	if ($GPC['add'] || $GPC['add_x'])
	{
		//delete
		if ($deleteevent == 1)
		{
			$vwartpl->cache("admin_message_delete");

			$GPC['QUERY_STRING'] = "action=deleteevent&amp;eventid=" . $GPC['eventid']."&amp;month=" . abs($month) . "&amp;year=" . $year;

			eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
			eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_delete")."\");");
			exit;
		}

		// make timestamp
		list ($hour, $minute) = split("[:]", $eventtime);
		$dateline = mktime( $hour, $minute, 0, $month, $day, $year);

		if($dateline < 0 ) $dateline = 0;

		list ($endhour, $endminute) = split("[:]", $endtime);
		$enddateline = mktime( $endhour, $endminute, 0, $endmonth, $endday, $endyear);

		if($enddateline < 0 ) $enddateline = 0;

		// check for wrong data
		if (!$enddateline || !$dateline || !($enddateline >= 0) || !($enddateline >= 0) || $enddateline < $dateline || $event == "")
		{
			$vwartpl->cache("admin_message_error_missingdata");
			eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
			eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_error_missingdata")."\");");
			exit;
		}

		$vwardb->query("
			UPDATE vwar".$n."_calendarevents
			SET
			event = '".$event."',
			eventdetails = '".$warinfo."',
			eventdate = '$dateline',
			enddate = '$enddateline'
			WHERE eventid = '".$GPC['eventid']."'
		");

		header("Location: calendar.php?month=" . date("m",$dateline) . "&year=" . date("Y", $dateline) . "");
	}

	//template-cache, standard-templates will be added by script:
	$vwartpllist="admin_dateselect,admin_calendar_editevent";
	$vwartpl->cache($vwartpllist);

	eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");

	$row = $vwardb->query_first("SELECT * FROM vwar".$n."_calendarevents WHERE eventid = '".$GPC['eventid']."'");
	dbSelectForm($row);

	if (!isset($eventdate)) $eventdate = date("d.m.Y", $row['eventdate']);
	if (!isset($eventtime)) $eventtime = date("H:i", $row['eventdate']);

	list ($day, $month, $year) = split("[/.-]", $eventdate);

	$monthselected[$month] = "selected";
	$dayselected[$day] = "selected";
	$yearselected[$year] = "selected";

	eval("\$dateselect = \"".$vwartpl->get("admin_dateselect")."\";");

	if (!isset($enddate)) $enddate = date("d.m.Y", $row['enddate']);
	if (!isset($endtime)) $endtime = date("H:i", $row['enddate']);

	list ($endday, $endmonth, $endyear) = split("[/.-]", $enddate);

	$endmonthselected[$endmonth] = "selected";
	$enddayselected[$endday] = "selected";
	$endyearselected[$endyear] = "selected";

	$deleteevent = makeyesnocode("deleteevent",0);

	getTextRestrictions("vwarform","warinfo","secondalt",2);

	eval("\$dateselect = \"".$vwartpl->get("admin_dateselect")."\";");
	eval("\$vwartpl->output(\"".$vwartpl->get("admin_calendar_editevent")."\");");
}

// ################################## delete event ####################################
if ($GPC['action'] == "deleteevent")
{
	checkPermission("caneditevent");

	if ($delete)
	{
		$vwardb->query("DELETE FROM vwar".$n."_calendarevents WHERE eventid = '".$GPC['eventid']."'");
		header("Location: calendar.php?month=" . abs($month) . "&year=" . $year . "");
	}
}
?>