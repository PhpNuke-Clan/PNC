<?php
/* #####################################################################################
 *
 * $Id: stats.php,v 1.52 2004/09/09 15:52:33 rob Exp $
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

// do the quickjump
doQuickjump($GPC['quickjumptarget']);

//template-cache, standard-templates will be added by script:
$vwartpllist="quickjump,statistics_generalstatbit,statistics_stattable,statistics_gamestatbit,";
$vwartpllist.="statistics_statbit,statistics";
$vwartpl->cache($vwartpllist);

include ( $vwar_root . "includes/get_header.php" );

$quickjump = loadQuickjump($GPC["PURE_PHP_SELF"]);

// unset vars to prevent sql-injections
$wherematchtype	= "";
$show						= "";

//public matchtype
$wherematchtype = getPublicMatchtypes(1);

// get gameselectbit
if (empty($GPC['showgame']) || $GPC['showgame'] == $str['ALL'])
{
	$show = "";
} else {
	$show = " AND vwar".$n.".gameid = '".$GPC['showgame']."'";
}

$result = $vwardb->query("
	SELECT DISTINCT(vwar".$n."_games.gameid),gamename
	FROM vwar".$n.", vwar".$n."_games
	WHERE vwar".$n.".gameid = vwar".$n."_games.gameid
		AND status = '1'
	ORDER BY gamename ASC
");
while ($row = $vwardb->fetch_array($result))
{
	dbSelect($row);

	$gameid = $row['gameid'];
	$gamename = $row['gamename'];

	eval("\$gameselectbit .= \"".$vwartpl->get(ifelse($GPC['showgame'] == $gameid, "gameselectbit2", "gameselectbit"))."\";");
}
$vwardb->free_result($result);

// get num of wars
$result = $vwardb->query_first("SELECT COUNT(warid) AS numwars FROM vwar".$n." WHERE status='1' $wherematchtype $show");
$numwars = $result['numwars'];

$totalwars = $numwars;
if ($numwars == 0)
{
	$numwars = 1; // must be set to 1, to prevent "division by zero error"
}

// get number of locations
$result = $vwardb->query_first("
	SELECT COUNT(scoreid) AS numloc
	FROM vwar".$n."_scores, vwar".$n."
	WHERE vwar".$n.".status = '1'
		AND vwar".$n.".warid = vwar".$n."_scores.warid
		$wherematchtype
		$show
");
$numlocations = $result['numloc'];
if ($numlocations == 0)
{
	$numlocations = 1; // must be set to 1, to prevent "division by zero error"
}
$totallocations = $numlocations;

// ################################### general stats ###################################

$ownscoretotal = 0;
$oppscoretotal = 0;

$result = $vwardb->query("
	SELECT ownscore, oppscore
	FROM vwar".$n.", vwar".$n."_scores
	WHERE vwar".$n.".warid = vwar".$n."_scores.warid
		AND vwar".$n.".status = '1'
		$wherematchtype
		$show
");
while ($row = $vwardb->fetch_array($result))
{
	$ownscoretotal = $ownscoretotal + $row['ownscore'];
	$oppscoretotal = $oppscoretotal + $row['oppscore'];
}
$ownaveragescoremap = round(($ownscoretotal / $numlocations), 1);
$oppaveragescoremap = round(($oppscoretotal / $numlocations), 1);
$ownaveragescorewar = round(($ownscoretotal / $numwars), 1);
$oppaveragescorewar = round(($oppscoretotal / $numwars), 1);
$numlocationsaverage = round(($totallocations / $numwars), 1);
$vwardb->free_result($result);

$tablename = $str['GENERAL'];

eval("\$statistics_statbit = \"".$vwartpl->get("statistics_generalstatbit")."\";");
eval("\$statistics_stattable = \"".$vwartpl->get("statistics_stattable")."\";");

unset($statistics_statbit);

// ################################### score stats ######################################

$ownscoretotal = 0;
$oppscoretotal = 0;

// stats by score
$result = $vwardb->query("
	SELECT warid, resultbylocations, vwar".$n.".oppid, oppname
	FROM vwar".$n.", vwar".$n."_opponents
	WHERE status = '1'
		AND vwar".$n.".oppid = vwar".$n."_opponents.oppid
		$wherematchtype
		$show
");
while ($row = $vwardb->fetch_array($result))
{

	// create score cache
	if (empty($scorecache))
	{
		$scorecache = createScoreCache();
	}

	if ($row['resultbylocations'] == 0)
	{
		$ownscoretotal = $scorecache[$row['warid']]["sownscoretotal"];
		$oppscoretotal = $scorecache[$row['warid']]["soppscoretotal"];
	}
	else if ($row['resultbylocations'] == 1)
	{
				$oppscoretotal = $scorecache[$row['warid']]["loppscoretotal"];
				$ownscoretotal = $scorecache[$row['warid']]["lownscoretotal"];
	}

	$element = $row["oppid"] . "||-VWAR-||" . $row["oppname"];

	if ($ownscoretotal < $oppscoretotal)
	{
		$totallostscore++;
		$opp_lost[$element] = (!isset($opp_lost[$element])) ? 1 : ($opp_lost[$element] + 1);
	}
	else if ($ownscoretotal > $oppscoretotal)
	{
		$totalwonscore++;
		$opp_won[$element] = (!isset($opp_won[$element])) ? 1 : ($opp_won[$element] + 1);
	}
	else if ($ownscoretotal == $oppscoretotal)
	{
		$totaldrawscore++;
		$opp_draw[$element] = (!isset($opp_draw[$element])) ? 1 : ($opp_draw[$element] + 1);
	}

	unset($ownscoretotal);
	unset($oppscoretotal);
}
$vwardb->free_result($result);

$imgwonheight = round(($totalwonscore / $numwars) * 100, 2);
$imgdrawheight = round(($totaldrawscore / $numwars) * 100, 2);
$imglostheight = round(($totallostscore / $numwars) * 100, 2);
$percentwonscore = $imgwonheight . "%";
$percentdrawscore = $imgdrawheight . "%";
$percentlostscore = $imglostheight . "%";
$statimgwonscore = makeimgtag($vwar_root . "images/stat_v.gif", $totalwonscore . "&nbsp;Wars", "", 30, $imgwonheight);
$statimglostscore = makeimgtag($vwar_root . "images/stat_v.gif", $totallostscore . "&nbsp;Wars", "", 30, $imglostheight);
$statimgdrawscore = makeimgtag($vwar_root . "images/stat_v.gif", $totaldrawscore . "&nbsp;Wars", "", 30, $imgdrawheight);

// create stats per opponent
$opp_won  = createQuickStats ( $opp_won, $str["OPPONENT"], $textwon, '<a href="modules.php?name='.$vwarmod.'&file=war&action=oppinfo&amp;oppid={id}">{name}</a>' );
$opp_lost = createQuickStats ( $opp_lost, $str["OPPONENT"], $textlost, '<a href="modules.php?name='.$vwarmod.'&file=war&action=oppinfo&amp;oppid={id}">{name}</a>' );
$opp_draw = createQuickStats ( $opp_draw, $str["OPPONENT"], $textdraw, '<a href="modules.php?name='.$vwarmod.'&file=war&action=oppinfo&amp;oppid={id}">{name}</a>' );

$tablename = $str['SCORE'] . " & " . $str["OPPONENT"] . " <smallfont>(" . $textwon . "/" . $textlost . "/" . $textdraw . ")</smallfont>";

eval("\$statistics_statbit .= \"".$vwartpl->get("statistics_scorestatbit")."\";");
eval("\$statistics_stattable .= \"".$vwartpl->get("statistics_stattable")."\";");

unset($statistics_statbit);

// ################################### location stats ##################################

// stats by locations
$result = $vwardb->query("
	SELECT oppscore, ownscore, vwar".$n."_scores.locationid, locationname
	FROM vwar".$n.", vwar".$n."_scores, vwar".$n."_locations
	WHERE vwar".$n.".status = '1'
		AND vwar".$n.".warid = vwar".$n."_scores.warid
		AND vwar".$n."_scores.locationid = vwar".$n."_locations.locationid
		$wherematchtype
	$show
");
while ($row = $vwardb->fetch_array($result))
{

	$element = $row["locationid"] . "||-VWAR-||" . $row["locationname"];
	if ($row['ownscore'] < $row['oppscore'])
	{
		$totallostlocations++;
		$loc_lost[$element] = (!isset($loc_lost[$element])) ? 1 : ($loc_lost[$element] + 1);
	}
	else if ($row['ownscore'] > $row['oppscore'])
	{
		$totalwonlocations++;
		$loc_won[$element] = (!isset($loc_won[$element])) ? 1 : ($loc_won[$element] + 1);
	}
	else if ($row['ownscore'] == $row['oppscore'])
	{
		$totaldrawlocations++;
		$loc_draw[$element] = (!isset($opp_draw[$element])) ? 1 : ($loc_draw[$element] + 1);
	}
}
$vwardb->free_result($result);

$imgwonheight = round(($totalwonlocations / $totallocations) * 100, 2);
$imgdrawheight = round(($totaldrawlocations / $totallocations) * 100, 2);
$imglostheight = round(($totallostlocations / $totallocations) * 100, 2);
$percentwonlocations = $imgwonheight . "%";
$percentdrawlocations = $imgdrawheight . "%";
$percentlostlocations = $imglostheight . "%";
$statimgwonlocations = makeimgtag($vwar_root . "images/stat_v.gif", $totalwonlocations . "&nbsp;" . $str['LOCATIONS'], "", 30, $imgwonheight);
$statimglostlocations = makeimgtag($vwar_root . "images/stat_v.gif", $totallostlocations . "&nbsp;" . $str['LOCATIONS'], "", 30, $imglostheight);
$statimgdrawlocations = makeimgtag($vwar_root . "images/stat_v.gif", $totaldrawlocations . "&nbsp;" . $str['LOCATIONS'], "", 30, $imgdrawheight);

$tablename = $str["LOCATIONS"] . " <smallfont>(" . $textwon . "/" . $textlost . "/" . $textdraw . ")</smallfont>";

// create stats per location
$loc_won  = createQuickStats ( $loc_won, $str["LOCATION"], $textwon );
$loc_lost = createQuickStats ( $loc_lost, $str["LOCATION"], $textlost );
$loc_draw = createQuickStats ( $loc_draw, $str["LOCATION"], $textdraw );

eval("\$statistics_statbit .= \"".$vwartpl->get("statistics_locationstatbit")."\";");
eval("\$statistics_stattable .= \"".$vwartpl->get("statistics_stattable")."\";");

unset($statistics_statbit);

// ################################### location stats ##################################
$place = 0;
$last  = 0;
$result = $vwardb->query("
	SELECT locationname, gameicon, gamenameshort, COUNT(vwar".$n."_scores.locationid) AS total
	FROM vwar".$n."_locations, vwar".$n."_scores, vwar".$n.", vwar".$n."_games
	WHERE vwar".$n."_locations.locationid = vwar".$n."_scores.locationid
		AND vwar".$n."_games.gameid = vwar".$n.".gameid
		AND vwar".$n.".warid = vwar".$n."_scores.warid
		AND vwar".$n.".status = '1'
		$wherematchtype
		$show
	GROUP BY vwar".$n."_locations.locationid
	ORDER BY total DESC, locationname
	LIMIT 0,10
");
while ($row = $vwardb->fetch_array($result))
{
	switchColors();

	if ( $row["total"] != $last )
	{
		$place++;
	}

	// get gameiconbit
	if ($row['gameicon'] != "" && file_exists($vwar_root . "images/gameicons/".$row['gameicon']))
	{
		eval("\$gameiconbit = \"".$vwartpl->get("gameiconbit")."\";");
	}
	else
	{
		eval("\$gameiconbit = \"".$vwartpl->get("gameiconbit_nopic")."\";");
	}

	$percent = round(($row['total'] / $totallocations) * 100, 2) . "%";
	$statname = "<b>" . $place . ".</b> " . $gameiconbit . $row['locationname'];
	$total = $row['total'] . "/" . $totallocations;
	$statimg = makeimgtag($vwar_root . "images/stat_h.gif", $row['total'] . "&nbsp;" . $str['GAMESPLAYED'], "", $percent, 12);

	$last = $row["total"];

	eval("\$statistics_statbit .= \"".$vwartpl->get("statistics_statbit")."\";");
}
$vwardb->free_result($result);
unset($total);

$tablename = $str['LOCATIONS'] . " Top10 <smallfont>(" . $str['GAMESPLAYED'] . ")</smallfont>";

eval("\$statistics_stattable .= \"".$vwartpl->get("statistics_stattable")."\";");
unset($statistics_statbit);

// ################################### opponent stats ##################################
$place = 0;
$lastnumwars = 0;
$result = $vwardb->query("
	SELECT oppname,oppcountry, vwar".$n."_opponents.oppid, COUNT(warid) AS numwars
	FROM vwar".$n."_opponents
	LEFT JOIN vwar".$n." ON (vwar".$n.".oppid = vwar".$n."_opponents.oppid)
	WHERE vwar".$n.".status = '1'
		$wherematchtype
		$show
	GROUP BY oppname
	ORDER BY numwars DESC
	LIMIT 0,10
");
while ($row = $vwardb->fetch_array($result))
{
	if (($row['numwars'] != $lastnumwars))
	{
		$place++;
	}

	$total = $row['numwars'] . "/" . $totalwars;
	$percent = round(($row['numwars'] / $totalwars) * 100, 2) . "%";

	$statname = "<b>" . $place . ".</b> ";

	$statname .= makeimgtag($vwar_root . "images/flags/" .
		ifelse($row['oppcountry'] != "", $row['oppcountry'], "nocountry") . ".gif",
		ifelse($row['oppcountry'] != "", $country_array[$row['oppcountry']], $str['NOTAVAILABLE'])) . "&nbsp;";

	$statname .= makelink("modules.php?name=$vwarmod&file=war&action=oppinfo&amp;oppid=" . $row['oppid'] . "", dbSelect($row['oppname']));
	$statimg = makeimgtag($vwar_root . "images/stat_h.gif", $row['numwars'] . "&nbsp;" . $str['GAMESPLAYED'], "", $percent, 12);

	switchColors();

	eval("\$statistics_statbit .= \"".$vwartpl->get("statistics_statbit")."\";");

	$lastnumwars = $row['numwars'];
}
unset($total);
$vwardb->free_result($result);

$tablename = $str['OPPONENT'] . " Top10 <smallfont>(" . $str['GAMESPLAYED'] . ")</smallfont>";

eval("\$statistics_stattable .= \"".$vwartpl->get("statistics_stattable")."\";");
unset($statistics_statbit);


// ################################### gametype stats ##################################
$result = $vwardb->query("
	SELECT vwar".$n."_gametype.gametypename, COUNT(vwar".$n.".warid) AS total
	FROM vwar".$n."_gametype
	LEFT JOIN vwar".$n." ON (vwar".$n."_gametype.gametypeid = vwar".$n.".gametypeid)
	WHERE vwar".$n."_gametype.deleted = '0'
		AND vwar".$n.".status = '1'
		$wherematchtype
		$show
	GROUP BY gametypename
	ORDER BY total DESC
");
while ($row = $vwardb->fetch_array($result))
{
	switchColors();

	$percent = round(($row['total'] / $numwars) * 100, 2) . "%";
	$statname = $row['gametypename'];
	$total = $row['total'] . "/" . $totalwars;
	$statimg = makeimgtag($vwar_root . "images/stat_h.gif", $row['total'] . "&nbsp;" . $str['GAMESPLAYED'], "", $percent, 12);

	eval("\$statistics_statbit .= \"".$vwartpl->get("statistics_statbit")."\";");
}
$vwardb->free_result($result);
unset($total);

$tablename = $str['GAMETYPE'] . "&nbsp;<smallfont>(" . $str['GAMESPLAYED'] . ")</smallfont>";

eval("\$statistics_stattable .= \"".$vwartpl->get("statistics_stattable")."\";");
unset($statistics_statbit);

// ################################### matchtype stats #################################
$result = $vwardb->query("
	SELECT vwar".$n."_matchtype.*, COUNT(vwar".$n.".warid) AS total
	FROM vwar".$n."_matchtype
	LEFT JOIN vwar".$n." ON (vwar".$n."_matchtype.matchtypeid = vwar".$n.".matchtypeid)
	WHERE vwar".$n."_matchtype.deleted = '0'
		AND vwar".$n.".status = '1'
		$wherematchtype
		$show
	GROUP BY matchtypename
	ORDER BY total DESC
");
while ($row = $vwardb->fetch_array($result))
{
	switchColors();

	$percent = round(($row['total'] / $numwars) * 100, 2) . "%";
	$statname = ifelse($row['matchtypeurl'], makelink($row['matchtypeurl'], $row['matchtypename'], "", "_blank"), $row['matchtypename']);
	$total = $row['total'] . "/" . $totalwars;
	$statimg = makeimgtag($vwar_root . "images/stat_h.gif", $row['total'] . "&nbsp;"  . $str['GAMESPLAYED'], "", $percent, 12);

	eval("\$statistics_statbit .= \"".$vwartpl->get("statistics_statbit")."\";");
}
$vwardb->free_result($result);

$tablename = $str['MATCHTYPE'] . "&nbsp;<smallfont>(" . $str['GAMESPLAYED'] . ")</smallfont>";

eval("\$statistics_stattable .= \"".$vwartpl->get("statistics_stattable")."\";");
eval("\$vwartpl->output(\"".$vwartpl->get("statistics")."\");");

include ($vwar_root . "includes/get_footer.php");
?>