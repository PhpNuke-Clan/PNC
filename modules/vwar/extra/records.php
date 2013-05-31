<?php
/* #####################################################################################
 *
 * $Id: records.php,v 1.22 2004/09/09 15:52:33 rob Exp $
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

// include header- & footer-information (1=enabled / 0=disabled)
$include    = 0;

// ######################################################################################


// ################################### display records  ################################

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

$result = $vwardb->query_first("
	SELECT COUNT(warid) AS numwars
	FROM vwar".$n."
	WHERE status = '1'
	" . getPublicMatchtypes(1)
);
$numwars = $result['numwars'];

if ($numwars > 0)
{
	?>
	<table border="0" cellpadding="4" cellspacing="1" align="center">
		<tr>
			<td colSpan="6"><b><?php echo $ownnameshort; ?> Records</b></td>
		</tr>
		<tr>
			<td><b>Game</b></td>
			<td align="center"><b>W/L/D</b></td>
		</tr>
	<?php
	$result = $vwardb->query("
		SELECT vwar".$n.".warid, resultbylocations
		FROM vwar".$n."_scores, vwar".$n."
		WHERE vwar".$n.".warid = vwar".$n."_scores.warid
		" . getPublicMatchtypes(1) . "
		GROUP BY vwar".$n.".warid
	");
	while($row = $vwardb->fetch_array($result))
	{
		$index[$row["warid"]] = $row;
	}
	unset($row);

	if (!isset($scorecache))
	{
		$scorecache = createScoreCache();
	}

	$totallost 	= 0;
	$totaldraw 	= 0;
	$totalwon 	= 0;

	$result = $vwardb->query("SELECT gameid, gamename, gameicon FROM vwar".$n."_games WHERE deleted = '0' ORDER BY gamename ASC");
	while ($game = $vwardb->fetch_array($result))
	{
		$numlost 				= 0;
		$numwon 				= 0;
		$numdraw 				= 0;
		$ownscoretotal 	= 0;
		$oppscoretotal 	= 0;

		foreach ($scorecache AS $warid => $data)
		{
			if ($data['gameid'] != $game['gameid'])
			{
				continue;
			}

			$resultbylocations = $index[$warid]["resultbylocations"];
			if ($resultbylocations == 0)
			{
				$ownscoretotal = $data['sownscoretotal'];
				$oppscoretotal = $data['soppscoretotal'];
			}
			else if ($resultbylocations == 1)
			{
				$ownscoretotal = $data['lownscoretotal'];
				$oppscoretotal = $data['loppscoretotal'];
			}
			if ($ownscoretotal < $oppscoretotal)
			{
				$numlost++;
				$totallost++;
			}
			else if ($ownscoretotal > $oppscoretotal)
			{
				$numwon++;
				$totalwon++;
			}
			else if ($ownscoretotal == $oppscoretotal)
			{
				$numdraw++;
				$totaldraw++;
			}
			unset($ownscoretotal);
			unset($oppscoretotal);
		}
		unset($scores);

		if ($numwon > 0 || $numlost > 0 || $numdraw > 0)
		{
			if ($game['gameicon'] != "" && file_exists($vwar_root . "images/gameicons/" . $row['gameicon']))
			{
				$gameicon = makeimgtag($urltovwar . "images/gameicons/".$game['gameicon'], $game['gamename']);
			}
			else
			{
				$gameicon = "";
			}
		?>
			<tr>
				<td align="left" nowrap><?php echo $gameicon; ?>&nbsp;<a href="<?php echo $nukefolder; ?>/modules.php?name=vwar&file=stats&action=showgame=<?php echo $game['gameid']; ?>"><?php echo $game['gamename']; ?></a></td>
				<td align="center">
					<table cellPadding="0" cellSpacing="0" border="0">
						<tr>
							<td align="center" width="30%"><font color="<?php echo $colorwon; ?>"><?php echo $numwon; ?></font></td>
							<td align="center" width="5%">&nbsp;|&nbsp;</td>
							<td align="center" width="30%"><font color="<?php echo $colorlost; ?>"><?php echo $numlost; ?></font></td>
							<td align="center" width="5%">&nbsp;|&nbsp;</td>
							<td align="center" width="30%"><font color="<?php echo $colordraw; ?>"><?php echo $numdraw; ?></font></td>
						</tr>
					</table>
				</td>
			</tr>
		<?php
		}
	}
	?>
			<tr>
				<td align="left" nowrap><b>Overall</b></td>
				<td align="center">
					<table cellPadding="0" cellSpacing="0" border="0">
						<tr>
							<td align="center" width="30%"><font color="<?php echo $colorwon; ?>"><?php echo $totalwon; ?></font></td>
							<td align="center" width="5%">&nbsp;|&nbsp;</td>
							<td align="center" width="30%"><font color="<?php echo $colorlost; ?>"><?php echo $totallost; ?></font></td>
							<td align="center" width="5%">&nbsp;|&nbsp;</td>
							<td align="center" width="30%"><font color="<?php echo $colordraw; ?>"><?php echo $totaldraw; ?></font></td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	<?php
}
else
{
	?>
	<p align="center">No entries!</p>
	<?php
}
if ($include == 1)
{
	include_once ($vwar_root . "_footer.php");
}
?>