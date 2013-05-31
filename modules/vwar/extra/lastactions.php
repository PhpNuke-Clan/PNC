<?php
/* #####################################################################################
 *
 * $Id: lastactions.php,v 1.48 2004/09/09 15:52:33 rob Exp $
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

$vwar_xroot			= "././../";
include ($vwar_xroot . "modname.php");

// define number of lastactions
// limits display to x last actions
$numlastactions = 3;

// include header- & footer-information (1=enabled / 0=disabled)
$include				= 0;

// ######################################################################################


// ################################### display lastactions  ############################

// check, if we need to get some global vars or if we need to include them
if (!defined ("VWAR_COMMON_INCLUDED"))
{
	$vwar_root = $vwar_xroot;
	require_once ($vwar_root . "includes/functions_common.php");
}

if ($include == 1)
{
	include_once($vwar_root . "_header.php");
}
echo"<div align='center' class='style1'>____________________
  <br></div>";
echo"<center><b>Results</b></center>";
?>

<table border="0" cellpadding="0" cellspacing="0" align="center">

<?php

$result = $vwardb->query_first("
	SELECT COUNT(warid) AS numwars
	FROM vwar".$n."
	WHERE status = '1'
	" . getPublicMatchtypes(1)
);
$numlastwars = $result['numwars'];

if ($numlastwars > 0)
{
		// cache scores
		if(!isset($scorecache))
		{
			$scorecache = createScoreCache();
		}

	$result = $vwardb->query("
		SELECT vwar".$n.".warid, resultbylocations, dateline,
			vwar".$n.".oppid,	oppircchannel, oppircnetwork, oppnameshort, gameicon, gamename
		FROM vwar".$n.", vwar".$n."_matchtype, vwar".$n."_gametype, vwar".$n."_opponents, vwar".$n."_games
		WHERE vwar".$n.".oppid = vwar".$n."_opponents.oppid
		AND vwar".$n.".gametypeid = vwar".$n."_gametype.gametypeid
			AND vwar".$n."_matchtype.matchtypeid = vwar".$n.".matchtypeid
			AND status = '1'
			AND vwar".$n.".gameid = vwar".$n."_games.gameid
			" . getPublicMatchtypes(1) . "
		GROUP BY warid
		ORDER BY dateline DESC
		LIMIT 0, $numlastactions
	");
	while ($row = $vwardb->fetch_array($result))
	{
		dbSelect($row);

		if (!isset($commentcache))
		{
			// get number of comments
			$commentcache = array();
			$result2 = $vwardb->query("
				SELECT sourceid, COUNT(commentid) AS numcomments
				FROM vwar".$n."_comments
				WHERE frompage = 'war'
				GROUP BY sourceid");
			while($tmp = $vwardb->fetch_array($result2))
			{
				$commentcache[$tmp["sourceid"]] = $tmp["numcomments"];
			}
			$vwardb->free_result($result2);
			unset($tmp);
		}
		$row['numcomments'] = $commentcache[$row["warid"]];
		$row['numcomments'] = empty($row['numcomments']) ? 0 : $row['numcomments'];

		$ownscoretotal = 0;
		$oppscoretotal = 0;
		$ownscoretotalbylocations = 0;
		$oppscoretotalbylocations = 0;

		$numcomments = $row['numcomments'];

		if ($row['gameicon'] != "" && file_exists($vwar_root . "images/gameicons/" . $row['gameicon']))
		{
			$gameicon = makeimgtag($urltovwar . "images/gameicons/" . $row['gameicon'], $row['gamename']);
		} else {
			$gameicon="";
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
		<?php
		$ownscoretotal = $scorecache[$row["warid"]]['sownscoretotal'];
		$oppscoretotal = $scorecache[$row["warid"]]['soppscoretotal'];

		if($showcoloredresults == 1)
		{
			if ($ownscoretotal < $oppscoretotal) $scorecolor = $colorlost;
			else if ($ownscoretotal > $oppscoretotal) $scorecolor = $colorwon;
			else if ($ownscoretotal == $oppscoretotal) $scorecolor = $colordraw;
		}

		if ($row['resultbylocations'] == 1)
		{
						$oppscoretotalbylocations = $scorecache[$row["warid"]]['loppscoretotal'];
						$ownscoretotalbylocations = $scorecache[$row["warid"]]['lownscoretotal'];

			if ($showcoloredresults == 1)
			{
				if ($ownscoretotalbylocations < $oppscoretotalbylocations)
								{
										$scorecolor = $colorlost;
										$matchstatus = makeimgtag($urltovwar . "images/lost.gif");
								}
				else if ($ownscoretotalbylocations > $oppscoretotalbylocations)
								{
										$scorecolor = $colorwon;
										$matchstatus = makeimgtag($urltovwar . "images/won.gif");
								}
				else if ($ownscoretotalbylocations == $oppscoretotalbylocations)
								{
										$scorecolor = $colordraw;
										$matchstatus = makeimgtag($urltovwar . "images/draw.gif");
								}
			}

			if ($showrealresults == 0)
			{
				$ownscoretotal = $ownscoretotalbylocations;
				$oppscoretotal = $oppscoretotalbylocations;
			}
		}
		if ($ownscoretotal > $oppscoretotal) $matchstatus = makeimgtag($urltovwar . "images/won.gif");
		else if ($ownscoretotal < $oppscoretotal) $matchstatus = makeimgtag($urltovwar . "images/lost.gif");
		else if ($ownscoretotal == $oppscoretotal) $matchstatus = makeimgtag($urltovwar . "images/draw.gif");
		?>
		<tr>
			<td align="center">
				<font color="<?php echo $scorecolor; ?>"><?php echo $ownscoretotal; ?>&nbsp;:&nbsp;<?php echo $oppscoretotal; ?>&nbsp;</font>
				<?php echo $matchstatus; ?>
				<br />
			</td>
		</tr>
		<tr>
			<td align="left">&raquo; <?php echo date($longdateformat,$row['dateline']); ?></td>
		</tr>
		<tr>
			<td align="left">
				&raquo; <a href="modules.php?name=<?php echo $vwarmod; ?>&file=war&action=details&amp;warid=<?php echo $row['warid']; ?>">details</a>
				[<?php echo $numcomments; ?> <a href="modules.php?name=<?php echo $vwarmod; ?>&file=war&action=comment&amp;warid=<?php echo $row['warid']; ?>"><img src="<?php echo $urltovwar; ?>images/comment.gif" align="middle" border="0" alt=""></a>]<br /><br />
			</td>
		</tr>
	<?php
	}
	$vwardb->free_result($result);
}
else
{
	?>
	<tr>
		<td align="center">No Last Actions</td>
	</tr>
<?php
}
?>
</table>
<?php
if ($include == 1)
{
	include_once($vwar_root . "_footer.php");
}
?>



