<?php
/* #####################################################################################
 *
 * $Id: calendar_include.php,v 1.44 2004/07/27 18:04:20 rob Exp $
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

// ####################################### CONFIGURATION  ###############################

// path to your main vwar-directory (with final ' / ')
// -> from the site, where this extra is included!
// -> use absolute path if you have it included in files with different directories!
//          (e.g. /home/www/htdocs/mysite.com/vwar/)
// -> if included in your _header.php/_footer.php, it is normally: './'
// -> if not, use: './../'
$vwar_xroot = "./../";
include ($vwar_xroot . "modname.php");


// include header- & footer-information (1=enabled / 0=disabled)
$include    = 0;

// months
$monthnames = array(
	"1" => "January",
	"2" => "February",
	"3" => "March",
	"4" => "April",
	"5" => "May",
	"6" => "June",
	"7" => "July",
	"8" => "August",
	"9" => "September",
	"10" => "October",
	"11" => "November",
	"12" => "December"
);

// weekdays
$weekdaynames = array(
	"Su",
	"Mo",
	"Tu",
	"We",
	"Th",
	"Fr",
	"Sa"
);

//########################### start calendar ###########################################

// check, if we need to get some global vars or if we need to include them
if (!defined ("VWAR_COMMON_INCLUDED"))
{
	$vwar_root = $vwar_xroot;
	require_once ($vwar_root . "includes/functions_common.php");
}

if ($include == 1)
{
	include_once ($vwar_root . "_header.php");
}

include_once($vwar_root . "includes/functions_calendar.php");

$result = $vwardb->query_first("SELECT replaceword FROM vwar".$n."_replacement WHERE findword = '{highlightcolor}'");
$highlightcolor = $result['replaceword'];

?>


<table border="0 cellpadding="4" cellspacing="1" align="center">
<form action="modules.php?name=<?php echo"$vwarmod"; ?>&amp;file=calendar" method="post">
	<tr>
		<td align="center" colSpan="7"><b>Calendar</b></td>
	</tr>
<?php

// redefine weekdays and start week at selected day
$weekdays = array();

for ($countup = 1; $countup <= (7 - $startofweek); $countup++)
{
	if($countup == 7)
	{
		$weekdays[0] = $weekdaynames[$startofweek + $countup - 1];
	}
	else
	{
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
		}
		else
		{
			$weekdays[$countdown] = $weekdaynames[0];
		}
	}
	else
	{
		if ($countdown == 7)
		{
			$weekdays[0] = $weekdaynames[$countdown - 1 - (7 - $startofweek)];
		}
		else
		{
			$weekdays[$countdown] = $weekdaynames[$countdown - 1 - (7 - $startofweek)];
		}
	}
}
$weekdaynames = $weekdays;

// start calendar precalculations
$current_day 		= date("j", time() + $timezoneoffset * 3600);
$current_month 	= date("n", time() + $timezoneoffset * 3600);
$current_year 	= date("Y", time() + $timezoneoffset * 3600);

$month = $GPC["month"];
$year  = $GPC["year"];

if (empty($month)) $month = $current_month;
if (empty($year)) $year = $current_year;

$numdays = date("t", mktime ( 0, 0, 0, $month + 1, 0, $year));

$calendar_headline = $monthnames[$month] . "&nbsp;" . $year;
if ($month < 10)
{
	$searchmonth = "0" . $month;
} else {
	$searchmonth = $month;
}


// do calendar output
$displayday = $startofweek;
$lastday 		= $startofweek + 6;

if ($lastday > 6)
{
	$lastday = $lastday - 7;
}

$end = false;
$counter = 1;

if ($month == 1)
{
	$prev_month = 12;
	$prev_year 	= $year - 1;
} else {
	$prev_month = $month - 1;
	$prev_year 	= $year;
}
if ($month == 12)
{
	$next_month = 1;
	$next_year 	= $year + 1;
}	else {
	$next_month = $month + 1;
	$next_year 	= $year;
}
	?>
				<tr>
					<td colSpan="7" vAlign="middle" align="center"><center><a href="modules.php?name=<?php echo $vwarmod; ?>&file=calendar&month=<?php echo $month; ?>&amp;year=<?php echo $year; ?>"><b><?php echo $monthnames[$month]; ?>&nbsp; <?php echo $year; ?></b></a></center></td>
					</tr>
				<tr>
					<td width="14%" vAlign="middle" align="center"><b><?php echo $weekdaynames[1]; ?></b></td>
					<td width="14%" vAlign="middle" align="center"><b><?php echo $weekdaynames[2]; ?></b></td>
					<td width="14%" vAlign="middle" align="center"><b><?php echo $weekdaynames[3]; ?></b></td>
					<td width="14%" vAlign="middle" align="center"><b><?php echo $weekdaynames[4]; ?></b></td>
					<td width="14%" vAlign="middle" align="center"><b><?php echo $weekdaynames[5]; ?></b></td>
					<td width="14%" vAlign="middle" align="center"><b><?php echo $weekdaynames[6]; ?></b></td>
					<td width="14%" vAlign="middle" align="center"><b><?php echo $weekdaynames[0]; ?></b></td>
				<tr>

	<?php

// get birthdays
$birthdays = array();
$result = $vwardb->query("SELECT memberid, birthday FROM vwar".$n."_member ORDER BY name ASC");
while ($row = $vwardb->fetch_array($result))
{
	$birthdays[$row["memberid"]] = $row;
}

// get wars
$wars = array();

$result = $vwardb->query("
	SELECT warid, dateline, repeat_number, repeat_mod
	FROM vwar".$n."
	" . getPublicMatchtypes(0) . "
	ORDER BY dateline ASC
");
while ($row = $vwardb->fetch_array($result))
{
	$wars[$row["warid"]] = $row;
}
unset($wherematchtype);

// get events
$events = array();

$result = $vwardb->query("
	SELECT eventid, eventdate, enddate
	FROM vwar".$n."_calendarevents WHERE deleted = '0'
");
while ($row = $vwardb->fetch_array($result))
{
	$events[$row["eventid"]] = dbSelect($row);
}

while (!$end)
{
	for ($i = 0; $i < 7; $i++)
	{

		// get number of wars
		$dateline_low 	= mktime( 0, 0, 0, $month, $counter, $year);
		$dateline_high 	= mktime( 23, 59, 59, $month, $counter, $year);
		$numwars	 			= count(getWars($wars, $dateline_low, $dateline_high));

		// get number of birthdays
		$searchday 			= ifelse($counter < 10, "0" . $counter, $counter);
		$searchstring 	= $searchmonth . "-" . $searchday;
		$numbirthdays		= count(getBirthdays($birthdays, $searchstring));;

		// get number of events
		$numevents 			= count(getEvents($events, $dateline_low,$dateline_high));

		// calculate total number of events
		$numtotal 			= $numwars + $numbirthdays + $numevents;

		$today = mktime ( 0, 0, 0, $month, $counter, $year);

		if (date("w", $today) == $displayday && $month == date("n", $today))
		{
			// check if we need to highlight the current day
			if ($counter == $current_day && $month == $current_month && $year == $current_year)
			{
				$font1	= "<font color=\"$highlightcolor\">";
				$font2 	= "</font>";
			}
			else
			{
				$font1	= "";
				$font2 	= "";
			}

			if ($numtotal > 0)
			{
				echo "<td align=\"middle\">" . $font1 . date("d", mktime( 0, 0, 0, $month, $counter, $year)) . $font2 . "<br>" .
					makelink("modules.php?name=$vwarmod&file=calendar&action=day&amp;day=" . $counter . "&amp;month=" . $month . "&amp;year=" . $year, $numtotal) . "</td>\n";
			}
			else
			{
				echo "<td align=\"middle\">" . $font1 . date("d", mktime( 0, 0, 0, $month, $counter, $year)) . $font2 . "<br>0</td>\n";
			}
			$counter++;

			if (date("w", $today) == $lastday)
			{
				echo "</tr>\n";
				if ($counter < $numdays) echo "<tr>\n";
			}
		}
		else
		{
			if (date("w", mktime( 0, 0, 0, $month, $counter, $year)) != $startofweek)
			{
				echo "<td align=\"middle\">&nbsp;</td>\n";
			}
			if ($counter > 1)	$end = true;
		}
		$displayday++;

		if ($displayday > 6)
		{
			$displayday = 0;
		}

		unset($daylink);
		unset($numevents);
	}
}

$calendarbits  .= "</tr>\n";
$monthselected 	= "month" . $month . "selected";
$$monthselected = "selected";
$min_year 			= $current_year;
$count 					= 1;

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
?>
	<tr>
		<td colSpan="7" vAlign="middle" align="center" nowrap>
		<select name="month">
				<option value="1" <?php echo $month1selected; ?>><?php echo $monthnames[1]; ?></option>
				<option value="2" <?php echo $month2selected; ?>><?php echo $monthnames[2]; ?></option>
				<option value="3" <?php echo $month3selected; ?>><?php echo $monthnames[3]; ?></option>
				<option value="4" <?php echo $month4selected; ?>><?php echo $monthnames[4]; ?></option>
				<option value="5" <?php echo $month5selected; ?>><?php echo $monthnames[5]; ?></option>
				<option value="6" <?php echo $month6selected; ?>><?php echo $monthnames[6]; ?></option>
				<option value="7" <?php echo $month7selected; ?>><?php echo $monthnames[7]; ?></option>
				<option value="8" <?php echo $month8selected; ?>><?php echo $monthnames[8]; ?></option>
				<option value="9" <?php echo $month9selected; ?>><?php echo $monthnames[9]; ?></option>
				<option value="10" <?php echo $month10selected; ?>><?php echo $monthnames[10]; ?></option>
				<option value="11" <?php echo $month11selected; ?>><?php echo $monthnames[11]; ?></option>
				<option value="12" <?php echo $month12selected; ?>><?php echo $monthnames[12]; ?></option>
			</select><br>
			<select name="year">
				<option value="<?php echo $yearvalue[1]; ?>" <?php echo $year1selected; ?>><?php echo $yearvalue[1]; ?></option>
				<option value="<?php echo $yearvalue[2]; ?>" <?php echo $year2selected; ?>><?php echo $yearvalue[2]; ?></option>
				<option value="<?php echo $yearvalue[3]; ?>" <?php echo $year3selected; ?>><?php echo $yearvalue[3]; ?></option>
				<option value="<?php echo $yearvalue[4]; ?>" <?php echo $year4selected; ?>><?php echo $yearvalue[4]; ?></option>
				<option value="<?php echo $yearvalue[5]; ?>">------</option>
				<option value="<?php echo $yearvalue[5]; ?>" <?php echo $year5selected; ?>><?php echo $yearvalue[5]; ?></option>
				<option value="<?php echo $yearvalue[5]; ?>">------</option>
				<option value="<?php echo $yearvalue[6]; ?>" <?php echo $year6selected; ?>><?php echo $yearvalue[6]; ?></option>
				<option value="<?php echo $yearvalue[7]; ?>" <?php echo $year7selected; ?>><?php echo $yearvalue[7]; ?></option>
				<option value="<?php echo $yearvalue[8]; ?>" <?php echo $year8selected; ?>><?php echo $yearvalue[8]; ?></option>
				<option value="<?php echo $yearvalue[9]; ?>" <?php echo $year9selected; ?>><?php echo $yearvalue[9]; ?></option>
			</select>
			<center><input name="image" type="image" src="modules/<?php echo $vwarmod; ?>/images/button_go.gif" align="absmiddle" border="0"></center>
		</td>
	</tr>
</form> 
</table>
<?php
if ($include == 1)
{
	include_once ($vwar_root . "_footer.php");
}
?>