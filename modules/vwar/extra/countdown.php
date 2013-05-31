<?php
/* #####################################################################################
 *
 * $Id: countdown.php,v 1.29 2004/09/09 15:52:33 rob Exp $
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

## NOTE:
## This extra uses own header and body tags.
## There can be complications if you include it into a non framed site!
## To prevent this, enable '$definitions' in this settings and
## include the following into your <body> - tag:
## onLoad="getTime()"
## e.g. <body onLoad="getVWarTime()">

// path to your main vwar-directory (with final ' / ')
// -> from the site, where this extra is included!
// -> use absolute path if you have it included in files with different directories!
//          (e.g. /home/www/htdocs/mysite.com/vwar/)
// -> if included in your _header.php/_footer.php, it is normally: './'
// -> if not, use: './../'
$vwar_xroot  = "./../";

include ($vwar_xroot . "modname.php");
// 0 = don't use the body-definitions / 1 = use them
$definitions = 1;

// include header- & footer-information (1=enabled / 0=disabled)
$include     = 0;

// ######################################################################################


// ################################### display countdown  ##############################

// check, if we need to get some global vars or if we need to include them
if( !defined ("VWAR_COMMON_INCLUDED") )
{
	$vwar_root = $vwar_xroot;
	require_once ( $vwar_root . "includes/functions_common.php" );
}

if ( $include == 1 )
{
	include_once ( $vwar_root . "_header.php" );
}

updateRepeatingDatelines("vwar".$n, "warid", "dateline", 1, $waroverlap);

$dateline = (time() - ($waroverlap * 60)) + ($timezoneoffset * 3600);

$result2 = $vwardb->query_first("
		SELECT *
		FROM vwar".$n."_settings
		");
	$ownnameshort = $result2['ownnameshort'];



if (!defined("VWAR_WARS_FROMNOW"))
{
	define("VWAR_WARS_FROMNOW", 1);
	$result = $vwardb->query_first("
		SELECT COUNT(warid) AS numwars
		FROM vwar".$n."
		WHERE status = '0'
		AND dateline > '$dateline'
		" . getPublicMatchtypes(1)
	);
	$num_nextwars = $result['numwars'];
}

if ($num_nextwars > 0)
{
	$row = $vwardb->query_first("
		SELECT vwar".$n.".warid, dateline, oppnameshort, vwar".$n.".oppid,vwar".$n.".gameid, gameicon
		FROM vwar".$n.", vwar".$n."_opponents,vwar".$n."_games
		WHERE vwar".$n.".oppid = vwar".$n."_opponents.oppid
		AND vwar".$n.".gameid = vwar".$n."_games.gameid
		AND status='0'
		AND dateline > '$dateline'
		" . getPublicMatchtypes(1) . "
		ORDER BY dateline ASC
		LIMIT 0,1
	");

	dbSelect ($row);

	if ($row['gameicon'] != "" && file_exists($vwar_root . "images/gameicons/" . $row['gameicon']))
	{
		$gameicon = makeimgtag($urltovwar . "images/gameicons/".$row['gameicon'], $row['gamename']);
	}
	else
	{
		$gameicon="";
	}

	$date = date("M d Y H:i:00",$row['dateline']);

	if ($definitions == 1)
	{
		echo '<html>
<head>';
	}

	echo '
	<script language="JavaScript">
		<!--
			function getVWarTime() {
				now          = new Date();
				y2k          = new Date("' . $date . '");
				days         = (y2k - now) / 1000 / 60 / 60 / 24;
				daysRound    = Math.floor(days);
				hours        = (y2k - now) / 1000 / 60 / 60 - (24 * daysRound);
				hoursRound   = Math.floor(hours);
				minutes      = (y2k - now) / 1000 /60 - (24 * 60 * daysRound) - (60 * hoursRound);
				minutesRound = Math.floor(minutes);
				seconds      = (y2k - now) / 1000 - (24 * 60 * 60 * daysRound) - (60 * 60 * hoursRound) - (60 * minutesRound);
				secondsRound = Math.round(seconds);
				sec = "s";
				min = "m, ";
				hr  = "h, ";
				dy  = "d, ";
				document.vwarcform.vwarcfield.value = daysRound  + dy + hoursRound + hr + minutesRound + min + secondsRound + sec;
				newtime = window.setTimeout("getVWarTime();", 1000);
			}
		// -->
	</script>
';

	if ( $definitions == 1 )
	{
		echo '</head>
<body onLoad="getVWarTime()">
';
	}
?>

<form name="vwarcform">
<table border="0" cellpadding="0" cellspacing="0" align="center">
	<tr>
		<td align="center"><b>Match Countdown</b></td>
	</tr>
	<tr>
		<td align="center" width="100%">
			<?php echo $gameicon; ?><br><a href="modules.php?name=<?php echo $vwarmod; ?>&file=war&action=nextaction&amp;formgame=<?php echo $row['gameid']; ?>#<?php echo $row['warid']; ?>"><?php echo $ownnameshort; ?> vs. <?php echo $row['oppnameshort']; ?></a><br>
			<input value="" type="text" name="vwarcfield" size="17">
		</td>
	</tr>
	<tr>
		<td align="center">until Match</td>
	</tr>
</table>
</form>
<?php
	if ( $definitions == 1 )
	{
		echo '
</body>
</html>';
	}
}
else
{
?>
<table border="0" cellpadding="0" cellspacing="0" align="center">
	<tr>
		<td align="center"><b>Match Countdown</b></td>
	</tr>
	<tr>
		<td align="center">No upcoming Match</td>
	</tr>
</table>
<?php
}
if ( $include == 1 )
{
	include_once ( $vwar_root . "_footer.php" );
}
?>