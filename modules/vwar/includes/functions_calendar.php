<?php
/* #####################################################################################
 *
 * $Id: functions_calendar.php,v 1.4 2004/03/15 21:06:32 mabu Exp $
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
 * includes/functions_calendar.php
 * ------------------------------------------------------------------------------------
 * functions used in calendar.php
*/

function getBirthdays($array,$date)
{
	$tmp = array();

	foreach ($array as $memberid => $data)
	{
		if (strpos($data["birthday"],$date))
		{
			$tmp[$memberid] = $data;
		}
	}

	return $tmp;
}
## -------------------------------------------------------------------------------------------------------------- ##
function checkRepeatedDates ( $repeat_mod, $repeat_number, $dateline, $date_low, $date_high )
{
	$checked = FALSE;
	if ( $repeat_mod != "date" )
	{
		switch ( $repeat_mod )
		{
			case "hours":	$factor = 1;
					break;
			case "days":	$factor = 24;
					break;
			case "weeks":	$factor = 168;
					break;
			case "months":	$factor = 672;
					break;
			case "years":	$factor = 8736;
					break;
			default:	$factor = 168;
		}
		$plus = 3600 * $factor * $repeat_number;

		$stop = FALSE;
		while ( !$stop )
		{
			$dateline += $plus;
			if ( $dateline >= $date_low AND $dateline <= $date_high )
			{
				$checked = TRUE;
				break;
			}
			else if ( $dateline > $date_high )
			{
				break;
			}
		}
	}
	else
	{
		$war_min   = date("i", $dateline);
		$war_hour  = date("G", $dateline);
		$war_day   = date("j", $dateline);
		$war_month = date("n", $dateline);
		$war_year  = date("Y", $dateline);

		$stop = FALSE;
		while ( !$stop )
		{
			$war_month += $repeat_number;
			if ( $war_month > 12 )
			{
				$war_year++;
				$war_month = $war_month - 12;
			}
			$newtime = mktime ($war_hour, $war_min, 0, $war_month, $war_day, $war_year);

			if ( $newtime >= $date_low AND $newtime <= $date_high )
			{
				$checked = TRUE;
				break;
			}
			else if ( $newtime > $date_high )
			{
				break;
			}
		}
	}

	return $checked;
}
## -------------------------------------------------------------------------------------------------------------- ##
function getWars($array,$date_low,$date_high)
{
	$tmp = array();

	foreach ($array as $warid => $data)
	{
		$repeated_date = FALSE;
		if (!empty ($data["repeat_mod"]) AND is_numeric($data["repeat_number"]) AND $date_high > $data["dateline"])
		{
			$repeated_date = checkRepeatedDates ($data["repeat_mod"], $data["repeat_number"], $data["dateline"], $date_low, $date_high);
		}

		if (($data["dateline"] >= $date_low AND $data["dateline"] <= $date_high) OR $repeated_date)
		{
			$tmp[$warid] = $data;
		}
	}

	return $tmp;
}
## -------------------------------------------------------------------------------------------------------------- ##
function getEvents($array,$date_low,$date_high)
{
	$tmp = array();

	foreach ($array as $eventid => $data)
	{
		if ((($data["eventdate"] >= $date_low && $data["eventdate"] <= $date_high)
					|| ($data["eventdate"] <= $date_high && $date_high <= $data["enddate"])
					|| ($data["enddate"] >= $date_low && $data["enddate"] <= $date_high)))
		{
			$tmp[$eventid] = $data;
		}
	}

	return $tmp;
}
?>