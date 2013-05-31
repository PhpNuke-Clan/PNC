<?php
/* #####################################################################################
 *
 * $Id: calendar.php,v 1.80 2004/09/08 20:29:50 mabu Exp $
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

require($vwar_root . "modname.php");
require($vwar_root . "includes/functions_common.php");
require($vwar_root . "includes/functions_front.php");
require($vwar_root . "includes/functions_calendar.php");

// do the quickjump
doQuickjump($GPC['quickjumptarget']);

//########################### start calendar ###########################################
if ($GPC['action'] == "" || !isset($GPC['action']))
{
	//template-cache, standard-templates will be added by script:
	$vwartpllist="calendarbit,calendarbit_today,calendar,quickjump";
	$vwartpl->cache($vwartpllist);
	include ( $vwar_root . "includes/get_header.php" );

	$quickjump = loadQuickjump($GPC["PURE_PHP_SELF"]);

	// redefine weekdays and start week at selected day
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

	for ($countdown = 7; $countdown > (7 - $startofweek);$countdown--)
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
		} else {
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
	$current_day 		= date("j",time() + $timezoneoffset * 3600);
	$current_month 	= date("n",time() + $timezoneoffset * 3600);
	$current_year 	= date("Y",time() + $timezoneoffset * 3600);
	$month 					= $GPC['month'];
	$year 					= $GPC['year'];

	if (empty($month))
	{
		$month = $current_month;
	}
	if (empty($year))
	{
		$year = $current_year;
	}

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

	// get birthdays
	$birthdays = array();
	$result = $vwardb->query("
		SELECT memberid, name, birthday
		FROM vwar".$n."_member
		WHERE hidemember = '0' AND ismember = '1'
		ORDER BY name ASC
	");
	while ($row = $vwardb->fetch_array($result))
	{
		$birthdays[$row["memberid"]] = dbSelect($row);
	}


	// get wars
	$wars = array();

	$result = $vwardb->query("
	 SELECT warid, gamename, gameicon, oppnameshort, status, dateline, vwar".$n.".gameid, repeat_number, repeat_mod
	 FROM vwar".$n."
	 LEFT JOIN vwar".$n."_opponents ON (vwar".$n.".oppid = vwar".$n."_opponents.oppid)
	 LEFT JOIN vwar".$n."_games ON (vwar".$n."_games.gameid = vwar".$n.".gameid)
	 " . getPublicMatchtypes(0) . "
	 ORDER BY dateline ASC");
	while ($row = $vwardb->fetch_array($result))
	{
		$wars[$row["warid"]] = dbSelect($row);
	}

	// get events
	$events = array();
	$result = $vwardb->query("SELECT * FROM vwar".$n."_calendarevents WHERE deleted = '0'");
	while ($row = $vwardb->fetch_array($result))
	{
		$events[$row["eventid"]] = dbSelect($row);
	}

	// do the calendar
	while (!$end)
	{
		// 'walk thru' the week
		for ($i = 0; $i < 7; $i++)
		{
			// get events
			// birthdays, wars and single events
			$dateline_low = mktime( 0, 0, 0, $month, $counter, $year);
			$dateline_high = mktime( 23, 59, 59, $month, $counter, $year);

			$tmp = getWars($wars, $dateline_low, $dateline_high);

			foreach ($tmp as $warid => $data)
			{
				if ($showgameicons == 1)
				{
					$gameiconbit = ifelse($data['gameicon'] != "" && @file_exists($vwar_root . "images/gameicons/".$data['gameicon']),
													makeimgtag($vwar_root . "images/gameicons/" . $data['gameicon'],$data['gamename']) . "&nbsp;");
				}

				$eventtime = formatdatetime($data['dateline'],"H:i",1);

				if ($data['status'] == 1)
				{
					$link = makelink($GPC['PHP_SELF']."?name=$vwarmod&file=war&action=details&amp;warid=" . $warid . "", $eventtime . "&nbsp;" . $data['oppnameshort']);
				}
				else
				{
					if ($data["dateline"] > time())
					{
						$link = makelink($GPC['PHP_SELF']."?name=$vwarmod&file=war&action=nextaction&amp;formgame=" . $data['gameid'] . "#" . $warid . "", $eventtime . "&nbsp;" . $data['oppnameshort']);
					}
					else
					{
						$link = $eventtime . "&nbsp;" . $data['oppnameshort'];
					}
				}

				$eventline[] = $gameiconbit . $link;
			}
			unset($tmp);

			$searchday = ifelse($counter < 10, "0" . $counter, $counter);
			$searchstring = $searchmonth . "-" . $searchday;

			// birthdays
			$tmp = getBirthdays($birthdays,$searchstring);
			foreach ($tmp as $memberid => $data)
			{
				$splitdate = split("-", $data['birthday']);
				$age = $year - $splitdate[0];

				$profilelink = makelink($GPC['PHP_SELF']."?name=$vwarmod&file=member&action=profile&amp;memberid=" . $memberid, $data['name'] . "&nbsp;(" . $age . ")");
				$eventline[] = makeimgtag($vwar_root . "images/button_birthday.gif", $data['name'] . "'s&nbsp;" . $str['BIRTHDAY'] . "&nbsp;(" . $age . ")", "top") . "&nbsp;" . $profilelink;
			}
			unset($tmp);

			// events
			$tmp = getEvents($events,$dateline_low,$dateline_high);

			foreach ($tmp as $eventid => $data)
			{

				$eventimage = makeimgtag($vwar_root . "images/button_" . ifelse($data['eventdate'] != $data['enddate'], "repeat.gif", "event.gif"),
												substr($data['eventdetails'], 0, 100) . "...", "top") . "&nbsp;";

				$eventline[] = $eventimage . makelink($GPC['PHP_SELF']."?name=$vwarmod&file=calendar&action=details&amp;eventid=" . $eventid . "", $data['event']);
			}
			unset($tmp);

			$today = mktime ( 0, 0, 0, $month, $counter, $year);

			if (date("w", $today) == $displayday && $month == date("n", $today))
			{
				for($z = 0; $z < count($eventline); $z++)
				{
					$eventlink .= $eventline[$z] . "<br>";
				}

				$daylink = makelink($GPC['PHP_SELF']."?name=$vwarmod&file=calendar&action=day&amp;month=".$month."&amp;year=".$year."&amp;day=".$counter, date("d", mktime(0,0,0,$month,$counter,$year)));

				// get day and highlight today
				eval("\$calendarbits .= \"".$vwartpl->get(ifelse($counter == $current_day && $month == $current_month && $year == $current_year, "calendarbit_today", "calendarbit"))."\";");

				$counter++;

				if (date("w", $today) == $lastday)
				{
					$calendarbits .= "</tr>\n";
					$calendarbits .= ifelse($counter < $numdays, "<tr>\n");
				}

			}
			else
			{
				$calendarbits .= ifelse(date("w", mktime(0,0,0,$month,$counter,$year)) != $startofweek, "<td height=\"75\" width=\"14%\" bgcolor=\"{firstaltcolor}\" valign=top>&nbsp;</td>\n");
				if ($counter > 1)
				{
					$end = true;
				}
			}

			$displayday++;
			if ($displayday > 6)
			{
				$displayday = 0;
			}

			unset($daylink, $eventlink, $eventline, $gameiconbit);
		}
	}

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
			$$yearselected = "selected";
		}
		$count++;
	}

	$jumptocurrentmonth = ifelse($month == $current_month && $year == $current_year, "", makelink("?name=$vwarmod&file=calendar","&raquo;&nbsp;" . $str['JUMPTOCURRENTMONTH']));

	// generate prev, next month links
	if ($month != 1)
	{
		$previousmonthlink = makelink($GPC['PHP_SELF'] . "?name=$vwarmod&file=calendar&month=" . ($month - 1) . "&amp;year=" . $year, "&laquo;&nbsp;" . $monthnames[date("n", mktime( 0, 0, 0, $month - 1, 1, $year))] . "&nbsp;" . $year);
	}	else {
		$previousmonthlink = makelink($GPC['PHP_SELF'] . "?name=$vwarmod&file=calendar&month=12&amp;year=" . ($year - 1), "&laquo;&nbsp;" . $monthnames[date("n", mktime( 0, 0, 0, $month - 1, 1, $year - 1))] . "&nbsp;" . ($year - 1));
	}

	if ($month != 12)
	{
		$nextmonthlink = makelink($GPC['PHP_SELF'] . "?name=$vwarmod&file=calendar&month=" . ($month + 1) . "&amp;year=" . $year, $monthnames[date("n", mktime( 0, 0, 0, $month + 1, 1, $year))] . "&nbsp;" . $year . "&nbsp;&raquo;");
	} else {
		$nextmonthlink = makelink($GPC['PHP_SELF'] . "?name=$vwarmod&file=calendar&month=1&amp;year=" . ($year + 1), $monthnames[date("n", mktime( 0, 0, 0, $month + 1, 1, $year + 1))] . "&nbsp;" . ($year + 1) . "&nbsp;&raquo;");
	}

	eval("\$vwartpl->output(\"".$vwartpl->get("calendar")."\");");
}

//######################### do calendar list and calendar day #####################################
if ($GPC['action'] == "list" || $GPC['action'] == "day")
{
	//template-cache, standard-templates will be added by script:
	$vwartpllist="quickjump,calendar_listbit_today,calendar_listbit,calendar_list_noevents,calendar_list_options,";
	$vwartpllist.="calendar_list_select,calendar_day_select,calendar_list";
	$vwartpl->cache($vwartpllist);
	include ( $vwar_root . "includes/get_header.php" );

	$quickjump = loadQuickjump($GPC["PURE_PHP_SELF"]);

	$numevents = 0;

	//different precalculations for 'list' and 'day'
	if ($GPC['action'] == "list")
	{
		// start calendar precalculations
		$current_day = date("j", time() + $timezoneoffset * 3600);
		$current_month = date("n", time() + $timezoneoffset * 3600);
		$current_year = date("Y", time() + $timezoneoffset * 3600);

		$month = $GPC['month'];
		$year = $GPC['year'];
		if (empty($month)) $month = $current_month;
		if (empty($year)) $year = $current_year;

		$numdays = date("t", mktime ( 0, 0, 0, $month + 1, 0, $year));

		$start = 1;
	}
	else if ($GPC['action'] == "day")
	{
		//start day precalculations
		$start 		= $GPC['day'];
		$numdays 	= $GPC['day'];
		$month 		= $GPC['month'];
		$year 		= $GPC['year'];
	}

	// get birthdays
	$birthdays = array();
	$result = $vwardb->query("
		SELECT memberid, name, birthday
		FROM vwar".$n."_member
		WHERE hidemember = '0' AND ismember = '1'
		ORDER BY name ASC
	");
	while ($row = $vwardb->fetch_array($result))
	{
		$birthdays[$row["memberid"]] = dbSelect($row);
	}

	// get wars
	$wars = array();

	$result = $vwardb->query("
	 SELECT warid, gamename, gameicon, oppnameshort, status, dateline, vwar".$n.".gameid, repeat_number, repeat_mod
	 FROM vwar".$n."
	 LEFT JOIN vwar".$n."_opponents ON (vwar".$n.".oppid = vwar".$n."_opponents.oppid)
	 LEFT JOIN vwar".$n."_games ON (vwar".$n."_games.gameid = vwar".$n.".gameid)
	 " . getPublicMatchtypes(0) . "
	 ORDER BY dateline ASC");
	while ($row = $vwardb->fetch_array($result))
	{
		$wars[$row["warid"]] = dbSelect($row);
	}

	// get events
	$events = array();
	$result = $vwardb->query("SELECT * FROM vwar".$n."_calendarevents WHERE deleted = '0'");
	while ($row = $vwardb->fetch_array($result))
	{
		$events[$row["eventid"]] = dbSelect($row);
	}

	//common precalculations
	$calendar_headline = $monthnames[$month] . "&nbsp;" . $year;
	$searchmonth = ifelse($month < 10, "0" . $month, $month);

	for ($day = $start; $day <= $numdays; $day++)
	{
		if ($GPC['action'] == "list")
		{
			$daylink = makelink($GPC['PHP_SELF'] . "?name=$vwarmod&file=calendar&action=day&amp;month=" . $month . "&amp;year=" . $year . "&amp;day=" . $day . "&amp;from=list", date("d", mktime( 0, 0, 0, $month, $day, $year)));
		}
		else if ($GPC['action'] == "day")
		{
			$daylink = date("d", mktime( 0, 0, 0, $month, $day, $year));
		}

		// get events
		// birthdays, wars and single events

		$dateline_low = mktime( 0, 0, 0, $month, $day, $year);
		$dateline_high = mktime( 23, 59, 59, $month, $day, $year);

		$tmp = getWars($wars,$dateline_low,$dateline_high);
		foreach($tmp as $warid => $data)
		{
			if ($showgameicons == 1)
			{
				$gameiconbit = ifelse($data['gameicon'] != "" && @file_exists($vwar_root . "images/gameicons/".$data['gameicon']),
												makeimgtag($vwar_root . "images/gameicons/" . $data['gameicon'],$data['gamename']) . "&nbsp;");
			}

			$eventtime = formatdatetime($data['dateline'],"H:i",1);

			$eventline[] = $gameiconbit . ifelse($data['status'] == 1,
											makelink($GPC['PHP_SELF']."?name=$vwarmod&file=war&action=details&amp;warid=" . $warid . "", $eventtime . "&nbsp;" . $data['oppnameshort']),
											makelink($GPC['PHP_SELF']."?name=$vwarmod&file=war&action=nextaction&amp;formgame=" . $data['gameid'] . "#" . $warid . "", $eventtime . "&nbsp;" . $data['oppnameshort']));
		}
		unset($tmp);

		// add 0 to days < 10
		$searchday = ifelse($day < 10, "0" . $day, $day);

		$searchstring = $searchmonth . "-" . $searchday;

		// birthdays
		$tmp = getBirthdays($birthdays,$searchstring);
		foreach ($tmp as $memberid => $data)
		{
			$splitdate = split("-", $data['birthday']);
			$age = $year - $splitdate[0];

			$profilelink = makelink($GPC['PHP_SELF']."?name=$vwarmod&file=member&action=profile&amp;memberid=" . $memberid, $data['name'] . "&nbsp;(" . $age . ")");
			$eventline[] = makeimgtag($vwar_root . "images/button_birthday.gif", $data['name'] . "'s&nbsp;" . $str['BIRTHDAY'] . "&nbsp;(" . $age . ")", "top") . "&nbsp;" . $profilelink;
		}
		unset($tmp);

		// events
		$tmp = getEvents($events,$dateline_low,$dateline_high);
		foreach ($tmp as $eventid => $data)
		{
				$eventimage = makeimgtag($vwar_root . "images/button_" . ifelse($data['eventdate'] != $data['enddate'], "repeat.gif", "event.gif"),
												substr($data['eventdetails'], 0, 100) . "...", "top") . "&nbsp;";

				$eventline[] = $eventimage . makelink($GPC['PHP_SELF']."?name=$vwarmod&file=calendar&action=details&amp;eventid=" . $eventid . "", $data['event']);
		}
		unset($tmp);

		for ($z = 0; $z < count($eventline); $z++)
		{
			$eventlink .= $eventline[$z]."<br>";
		}

		$today = mktime ( 0, 0, 0, $month, $day, $year);
		$weekday = date("w", $today);

		//list output
		if (!empty($eventlink) && $GPC['action'] == "list")
		{
			$numevents++;

			// get day and highlight today
			eval("\$calendarbits .= \"".$vwartpl->get(ifelse($counter == $current_day && $month==$current_month && $year == $current_year, "calendar_listbit_today", "calendar_listbit"))."\";");

		}
		else if (empty($eventlink) && $GPC['action'] == "list")
		{
			$calendarbits .= "";
			//day output
		}
		else if (!empty($eventlink) && $GPC['action'] == "day")
		{
			eval ("\$calendarbits = \"".$vwartpl->get("calendar_listbit")."\";");
		}
		else if (empty($eventlink) && $GPC['action'] == "day")
		{
			$eventlink = $str['NOENTRY'];
			eval ("\$calendarbits = \"".$vwartpl->get("calendar_listbit")."\";");
		}

		unset($daylink, $eventlink, $eventline, $gameiconbit);
	} // end for

	if ($numevents == 0 && $GPC['action'] == "list")
	{
		eval ("\$calendarbits = \"".$vwartpl->get("calendar_list_noevents")."\";");
	}

	//list select
	if ($GPC['action'] == "list")
	{
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
				$$yearselected = "selected";
			}
			$count++;
		}

		$jumptocurrentmonth = ifelse($month == $current_month && $year == $current_year, "", makelink($GPC['PHP_SELF']."?name=$vwarmod&file=calendar&action=list", "&raquo;&nbsp;" . $str['JUMPTOCURRENTMONTH']));

		// generate prev, next month links
		if ($month != 1)
		{
			$previousmonthlink = makelink($GPC['PHP_SELF'] . "?name=$vwarmod&file=calendar&action=list&amp;month=" . ($month - 1) . "&amp;year=" . $year,"&laquo;&nbsp;" . $monthnames[date("n", mktime( 0, 0, 0, $month - 1, 1, $year))] . "&nbsp;" . $year);
		} else {
			$previousmonthlink = makelink($GPC['PHP_SELF'] . "?name=$vwarmod&file=calendar&action=list&amp;month=12&amp;year=" . ($year - 1), "&laquo;&nbsp;" . $monthnames[date("n", mktime( 0, 0, 0, $month - 1, 1, $year-1))] . "&nbsp;" . ($year - 1));
		}

		if ($month != 12)
		{
			$nextmonthlink = makelink($GPC['PHP_SELF'] . "?name=$vwarmod&file=calendar&action=list&amp;month=" . ($month + 1) . "&amp;year=" . $year, $monthnames[date("n", mktime( 0, 0, 0, $month + 1, 1, $year))] . "&nbsp;" . $year . "&nbsp;&raquo;");
		} else {
			$nextmonthlink = makelink($GPC['PHP_SELF'] . "?name=$vwarmod&file=calendar&action=list&amp;month=1&amp;year=" . ($year + 1), $monthnames[date("n", mktime( 0, 0, 0, $month + 1, 1, $year + 1))] . "&nbsp;" . ($year + 1) . "&nbsp;&raquo;");
		}

		eval ("\$calendar_options = \"".$vwartpl->get("calendar_list_options")."\";");
		eval ("\$calendar_select = \"".$vwartpl->get("calendar_list_select")."\";");
	}
	else
	{
		//day select
		$from 			= "&amp;from=".$GPC['from'];
		$prev 			= mktime( 0, 0, 0, $month, $day, $year) - 86401;
		$next 			= mktime( 0, 0, 0, $month, $day, $year);
		$prevday 		= date("j", $prev);
		$prevmonth 	= date("n", $prev);
		$prevyear 	= date("Y", $prev);
		$nextday 		= date("j", $next);
		$nextmonth 	= date("n", $next);
		$nextyear 	= date("Y", $next);

		$previousdaylink = makelink($GPC['PHP_SELF'] . "?name=$vwarmod&file=calendar&action=day" . $from . "&amp;day=" . $prevday . "&amp;month=" . $prevmonth . "&amp;year=" . $prevyear,"&laquo;&nbsp;" . $prevday . ".&nbsp;" . $monthnames[$prevmonth] . "&nbsp;" . $prevyear);
		$nextdaylink = makelink($GPC['PHP_SELF'] . "?name=$vwarmod&file=calendar&action=day" . $from . "&amp;day=" . $nextday . "&amp;month=" . $nextmonth . "&amp;year=" . $nextyear, $nextday . ".&nbsp;" . $monthnames[$nextmonth] . "&nbsp;" . $nextyear . "&nbsp;&raquo;");

		eval ("\$calendar_select = \"".$vwartpl->get("calendar_day_select")."\";");
	}
	eval("\$vwartpl->output(\"".$vwartpl->get("calendar_list")."\");");
}

//################################ show eventdetails ########################################
if ($GPC['action'] == "details")
{
	//template-cache, standard-templates will be added by script:
	$vwartpllist="calendar_eventdetails";
	$vwartpl->cache($vwartpllist);
	include ( $vwar_root . "includes/get_header.php" );

	$quickjump = loadQuickjump($GPC["PURE_PHP_SELF"]);

	$row = $vwardb->query_first("
		SELECT event, eventdate, enddate, eventdetails, eventadded, name, vwar".$n."_calendarevents.memberid
		FROM vwar".$n."_calendarevents, vwar".$n."_member
		WHERE eventid = '".$GPC['eventid']."'
		AND vwar".$n."_calendarevents.memberid = vwar".$n."_member.memberid
	");
	dbSelect($row);

	$eventimage = makeimgtag($vwar_root . "images/button_" . ifelse($row['eventdate'] != $row['enddate'], "repeat.gif", "event.gif"), "", "top");

	$numcomments = countComments($GPC['eventid'],"calendar");
	$year                = date("Y", $row['eventdate']);
	$month               = date("n", $row['eventdate']);
	$row['eventdetails'] = parseText($row['eventdetails'],1);
	$row['eventadded']   = formatdatetime($row['eventadded'],$longdateformat);
	$row['eventdate']    = formatdatetime($row['eventdate'],$longdateformat);
	$row['enddate']      = formatdatetime($row['enddate'],$longdateformat);

	$row['eventdetails'] = ifelse($row['eventdetails'] == "",  $str['NOTAVAILABLE'], $row['eventdetails']);

	eval("\$vwartpl->output(\"".$vwartpl->get("calendar_eventdetails")."\");");
}

//################################## event comments ##########################################
if ($GPC['action'] == "comment")
{
	// create vars (only if comment-action != delete)
	if ($GPC['cmd'] != "delete" && $command != "delete")
	{
		$row = $vwardb->query_first("
			SELECT event, eventdate, enddate
			FROM vwar".$n."_calendarevents
			WHERE eventid = '".$GPC['eventid']."'
		");
		$start = formatdatetime($row['eventdate'], $longdateformat);
		$end   = formatdatetime($row['enddate'], $longdateformat);

		eval("\$commenttitle = \"".$vwartpl->get("comment_display_commenttitle_calendar")."\";");

		$returntitle = $str['EVENTDETAILS'];
		$returnurl   = "modules.php?name=$vwarmod&file=calendar&action=details&amp;eventid=".$GPC['eventid'];
	}

	// params
	$comments = array (
		"sourceid"	=> $GPC['eventid'],
		"frompage"	=> "calendar",
		"title"		=> $str['CALENDAR'],
		"commenttitle"	=> $commenttitle,
		"returntitle"	=> $returntitle,
		"returnurl"	=> $returnurl
	);
	// load engine
	include("includes/functions_comments.php");
}

include ($vwar_root . "includes/get_footer.php");
?>