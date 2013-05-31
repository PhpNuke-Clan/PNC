<?php
/* #####################################################################################
 *
 * $Id: today.php,v 1.32 2004/09/09 15:52:33 rob Exp $
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
$vwar_xroot  = "./../";
include ($vwar_xroot . "modname.php");

// 0 = show wars &  events / 1 = show only events / 2 = show only wars
$whattoshow   = 0;

// how many entries are displayed (set '0' to display them all!)
$showactions  = 6;

// set 1 to display a link to your vwar-calendar
// if more events are fetched than you want to display
$calendarlink = 0;

// include header- & footer-information (1=enabled / 0=disabled)
$include      = 0;

// ######################################################################################


// ################################### display events  #################################

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

switch ($whattoshow)
{
	case 0:
		$title = "Ocassions";
		break;
	case 1:
		$title = "Events";
		break;
	case 2;
		$title = "Wars";
		break;
}

$tocalendar = "more " . $title . " in the Calendar!";
$time = "H:i";

$current_date = getdate();
$current_day = $current_date['mday'];
$current_month = $current_date['mon'];
$current_year = $current_date['year'];

if ($current_month < 10)
{
	$searchmonth = "0" . $current_month;
} else {
	$searchmonth = $current_month;
}
if ($current_day < 10)
{
	$searchday = "0" . $current_day;
} else {
	$searchday = $current_day;
}

$searchstring 	= $searchmonth . "-" . $searchday;
$dateline_low 	= mktime( 0, 0, 0, $searchmonth, $searchday, $current_year);
$dateline_high 	= mktime( 23, 59, 59, $searchmonth, $searchday, $current_year);
?>
<table border="0" cellpadding="0" cellspacing="0" align="center">
	<tr>
		<td align="center"><b><?php echo $title ?> on <?php echo $current_day; ?>.<?php echo $searchmonth; ?>.<?php echo $current_year; ?></b></td>
	</tr>
<?php
if ($whattoshow == 0 || $whattoshow == 1)
{
	$events = $vwardb->query("
		SELECT eventid, event
		FROM vwar".$n."_calendarevents
		WHERE ( (eventdate >= $dateline_low AND eventdate <= $dateline_high)
		OR (eventdate <= $dateline_high AND $dateline_high <= enddate)
		OR (enddate >= $dateline_low AND enddate <= $dateline_high) )
		AND deleted = '0'
	");
	$numevents = $vwardb->num_rows($events);

	$birthdays = $vwardb->query("
		SELECT memberid,name,birthday FROM vwar".$n."_member
		WHERE birthday LIKE '%$searchstring%' ORDER BY name ASC");
	$numbirthdays = $vwardb->num_rows($birthdays);
}

if($whattoshow == 0 || $whattoshow == 2)
{
	$wars = $vwardb->query("
		SELECT warid, status, dateline, oppnameshort
		FROM vwar".$n."
		LEFT JOIN vwar".$n."_opponents ON (vwar".$n.".oppid = vwar".$n."_opponents.oppid)
		WHERE dateline >= '$dateline_low' AND dateline <= '$dateline_high'
		" . getPublicMatchtypes(1) . "
		ORDER BY dateline ASC
	");
$numwars = $vwardb->num_rows($wars);
}
$numactions = $numwars + $numbirthdays + $numevents;

if ($numactions == 0)
{
	$handler = 0;
}
else if ($numactions <= $showactions || $showactions == 0)
{
	$handler = 1;
	$todisplay = $numactions;
}
else if ($showactions == 1 && $calendarlink == 1)
{
	$handler = 2;
	$todisplay = 1;
}
else if ($calendarlink == 1 && $numactions > $showactions)
{
	$handler = 2;
	$todisplay = $showactions - 1;
}
else if ($calendarlink != 1 && $numactions > $showactions)
{
	$handler = 3;
	$todisplay = $showactions;
}

//display
if ($handler)
{
	$display_this = 0;

	//events
	if ($numevents > 0)
	{
		while ($display_this < $todisplay && $event = $vwardb->fetch_array($events))
		{
			dbSelect ($event);

			$display_this++;
			?>
			<tr>
				<td align="left">&raquo; <a href="modules.php?name=<?php echo $vwarmod; ?>&file=calendar&action=details&amp;eventid=<?php echo $event['eventid']; ?>"><?php echo $event['event']; ?></a></td>
			</tr>
			<?php
		}
	}

	//birthdays
	if ($numbirthdays > 0)
	{
		while ($display_this < $todisplay && $birthday = $vwardb->fetch_array($birthdays))
		{
			dbSelect ($birthday);

			$display_this++;
			$birthdayarray = split("-", $birthday['birthday']);
			$age = $current_year - $birthdayarray[0];

			if (($birthdayarray[1] > date("m")) || (($birthdayarray[1] == date("m")) && ($birthdayarray[2] > date("d"))))
			{
				$age--;
			}
			?>
			<tr>
				<td align="left">&raquo; <a href="modules.php?name=<?php echo $vwarmod; ?>&file=member&action=profile&memberid=1<?php echo $birthday['memberid']; ?>"><?php echo $birthday['name']; ?>'s Birthday (<?php echo $age; ?>)</a></td>
			</tr>
			<?php
		}
	}

	//wars
	if ($numwars > 0)
	{
		while ($display_this < $todisplay && $war = $vwardb->fetch_array($wars))
		{
			dbSelect ($war);

			$display_this++;
			$wartime = date($time, $war['dateline']);

			if ($war['status'] == 1)
			{
			?>
			<tr>
				<td align"left">&raquo; <a href="modules.php?name=<?php echo $vwarmod; ?>&file=war&action=details&amp;warid=<?php echo $war['warid'] ?>">War vs. <?php echo $war['oppnameshort'] ?></a> at <?php echo $wartime ?></td>
			</tr>
			<?php
			}
			else
			{
			?>
			<tr>
				<td align"left">&raquo; <a href="modules.php?name=<?php echo $vwarmod; ?>&file=war&action=nextaction&display=today#<?php echo $war['warid'] ?>">War vs. <?php echo $war['oppnameshort'] ?></a> at <?php echo $wartime ?></td>
			</tr>
			<?php
			}
		}
	}
	if ($handler == 2)
	{
	?>
	<tr>
		<td align="left">&raquo; <a href="modules.php?name=<?php echo $vwarmod; ?>&file=calendar&action=day&amp;month=<?php echo $current_month; ?>&amp;year=<?php echo $current_year ?>&amp;day=<?php echo $current_day; ?>"><?php echo $tocalendar ?></a></td>
	</tr>
	<?php
	}
}
//no actions at all
else
{
	?>
	<tr>
		<td align="center">No <?php echo $title ?> today!</td>
	</tr>
	<?php
}
?>
</table>
<?php
if ( $include == 1 )
{
	include_once ( $vwar_root . "_footer.php" );
}
?>