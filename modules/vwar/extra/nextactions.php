<?php
/* #####################################################################################
 *
 * $Id: nextactions.php,v 1.49 2004/09/14 15:12:49 mabu Exp $
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
$vwar_xroot				= "./../";
include ($vwar_xroot . "modname.php");

// limit display to x next actions
$numnextactions		= 3;

// shows the needed and signed up participants for the match
// (1=enabled / 0=disabled)
$showparticipants = 1;

// shows the irc information of a opponent
// (1=enabled / 0=disabled)
$showirc          = 1;

// include header- & footer-information (1=enabled / 0=disabled)
$include          = 0;

// ######################################################################################


// ################################### display nextactions  #############################

// check, if we need to get some global vars or if we need to include them
if( !defined ("VWAR_COMMON_INCLUDED") )
{
	$vwar_root = $vwar_xroot;
	require_once ($vwar_root . "includes/functions_common.php");
}

if ( $include == 1 )
{
	include_once ($vwar_root . "_header.php");
}

//update repeating wars
updateRepeatingDatelines("vwar".$n, "warid", "dateline", 1, $waroverlap);
?>
<table border="0" cellpadding="0" cellspacing="0" align="center">
<?php

$dateline = (time() - ($waroverlap * 60)) + ($timezoneoffset * 3600);

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
	$result=$vwardb->query("
		SELECT vwar".$n.".warid, vwar".$n.".gameid, vwar".$n.".gametypeid, vwar".$n.".matchtypeid, status, vwar".$n.".dateline,
			oppnameshort, oppircnetwork, oppircchannel, playerperteam, vwar".$n.".oppid, matchtypename, gametypename,
			gameicon,gamenameshort
		FROM vwar".$n.", vwar".$n."_matchtype, vwar".$n."_gametype, vwar".$n."_opponents, vwar".$n."_games
		WHERE vwar".$n.".oppid = vwar".$n."_opponents.oppid
			AND vwar".$n.".gametypeid = vwar".$n."_gametype.gametypeid
			AND vwar".$n."_matchtype.matchtypeid = vwar".$n.".matchtypeid
			AND status = '0' AND vwar".$n.".dateline > '$dateline'
			AND vwar".$n.".gameid = vwar".$n."_games.gameid
			" . getPublicMatchtypes(1) . "
		GROUP BY vwar".$n.".warid
		ORDER BY dateline ASC
		LIMIT 0, $numnextactions
	");

	while ($row = $vwardb->fetch_array($result))
	{
		dbSelect ($row);

		if ($row['gameicon'] != "" && file_exists($vwar_root . "images/gameicons/".$row['gameicon']))
		{
			$gameicon = makeimgtag($urltovwar . "images/gameicons/".$row['gameicon'], $row['gamename']);
		}
		else
		{
			$gameicon = "";
		}
		?>
		<tr>
			<td align="center">
				<?php echo $gameicon; ?>
				<!-- gamenameshort start
				<?php echo $row['gamenameshort']; ?>:
				gamenameshort end -->
				<a href="<?php echo $ownhomepage; ?>" target="_blank">
				<?php echo $ownnameshort; ?></a> vs. <a href="modules.php?name=<?php echo $vwarmod; ?>&file=war&action=oppinfo&amp;oppid=<?php echo $row['oppid']; ?>"><?php echo $row['oppnameshort']; ?></a>
			</td>
		</tr>
		<tr>
			<td>&raquo; <?php echo date($longdateformat, $row['dateline']); ?></td>
		</tr>
		<!-- details start
		<tr>
			<td>&raquo; <?php echo $row['matchtypename']; ?></td>
		</tr>
		<tr>
			<td>&raquo; <?php echo $row['gametypename']; ?></td>
		</tr>
		details end -->
			<?php
		if ($showirc == 1 && !empty($row['oppircnetwork']) && !empty($row['oppircchannel']))
		{
			?>
		<tr>
			<td>&raquo; IRC: <a href="irc://<?php echo $row['oppircnetwork']; ?>/<?php echo $row['oppircchannel']; ?>"><?php echo $row['oppircchannel']; ?></a></td>
		</tr>
			<?php
		}
		if ($showparticipants == 1)
		{
			$result2 = $vwardb->query_first("
				SELECT COUNT(partid) AS parts
				FROM vwar".$n."_participants
				WHERE available = '1'
					AND warid = '" . $row['warid'] . "'
			");
			$parts = $result2['parts'];
			?>
			<tr>
				<td>&raquo; Participants: <font color="<?php echo ($parts >= $row['playerperteam']) ? "green" : "red"; ?>"><?php echo $parts." / ".$row['playerperteam']; ?></font></td>
			</tr>
			<?php
		}
		?>
		<tr>
			<td>&raquo; <a href="modules.php?name=<?php echo $vwarmod; ?>&file=war&action=nextaction&amp;formgame=<?php echo $row['gameid']."#".$row['warid']; ?>">details</a><br><br></td>
		</tr>
		<?php
	}
	$vwardb->free_result($result);
	}
	else
	{
	?>
	<tr>
		<td align="center">No Next Actions</td>
	</tr>
<?php
}
?>
</table>
<?php
if ($include == 1)
{
	include_once ($vwar_root . "_footer.php");
}
?>