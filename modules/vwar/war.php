<?php
/* #####################################################################################
 *
 * $Id: war.php,v 1.191 2004/09/09 15:52:33 rob Exp $
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
$vwar_file = "war";
require($vwar_root . "modname.php");
require ($vwar_root . "includes/functions_common.php");
require ($vwar_root . "includes/functions_front.php");

if (isset($userlanguage))
{
	SetVWarCookie("vwarlanguage",$userlanguage);
}

// do the quickjump
doQuickjump($GPC['quickjumptarget']);

// update repeating datelines
updateRepeatingDatelines("vwar".$n, "warid", "dateline", 1, $waroverlap);

// unset vars to prevent sql-injections
$show							= "";
$wheretime 				= "";
$wheremembergame1 = "";
$wheremembergame2 = "";
$wheregame				= "";
$showtypes				= "";

// ################################### display wars  ###################################
if ($GPC['action'] == "" || !isset($GPC['action']) || $GPC['action'] == "wars")
{

	// verify login
	if (isset($GPC['login']))
	{
			$result = $vwardb->query_first("
				SELECT memberid, ismember, name, password, language
				FROM vwar".$n."_member
				WHERE name = '".$GPC['loginname']."'
				AND password = '".md5(trim($GPC['loginpassword']))."'
				AND status <> '0'
			");

			if ($result['memberid'] && $result['ismember'] == 1)
			{
					SetVWarCookie("vwarid", $result['memberid']);
					//SetVWarCookie("vwarpassword", md5($GPC["loginpassword"]));
					SetVWarCookie("vwarpassword", md5(md5($GPC["loginpassword"])));
					SetVWarCookie("vwarlanguage", $result["language"]);
					// IIS needs this redirection...
					header("Cache-Control: no-cache, must-revalidate");
					header("Pragma: no-cache");
					$vwartpl->cache ( "message_confirmation" );
					include ( $vwar_root . "includes/get_header.php" );
					$redirecturl = "modules.php?name=$vwarmod&file=war";
					eval ("\$vwartpl->output(\"" . $vwartpl->get("message_confirmation") . "\");");
					include ( $vwar_root . "includes/get_footer.php" );
			}
			else
			{
				//template-cache, standard-templates will be added by script:
				$vwartpllist = "message_error_loginerror";
				$vwartpl->cache($vwartpllist);
				include ( $vwar_root . "includes/get_header.php" );
				eval("\$vwartpl->output(\"".$vwartpl->get("message_error_loginerror")."\");");
			}
	}
	else
	{
		//template-cache, standard-templates will be added by script:
		$vwartpllist = "gameiconbit,gameiconbit2,war_listbit,warlistnav,gameselectbit,gameselectbit2,matchtypeselectbit,";
		$vwartpllist .= "matchtypeselectbit2,gametypeselectbit,gametypeselectbit2,languageselectbit,";
		$vwartpllist .= "languageselectfield,loginfield2,loginfield,war_list";
		$vwartpl->cache($vwartpllist);
		include ( $vwar_root . "includes/get_header.php" );
		$quickjump = loadQuickjump($GPC["PURE_PHP_SELF"]);

		//public matchtype
		$wherematchtype = getPublicMatchtypes (1);

		$show = "";
		if (!empty($showgame)) 		$show = " AND vwar".$n.".gameid = '$showgame'";
		if (!empty($showmatchtype))	$show .= " AND vwar".$n.".matchtypeid = '$showmatchtype'";
		if (!empty($showgametype)) 	$show .= " AND vwar".$n.".gametypeid = '$showgametype'";
		if (!isset($s)) $s = 0;

		$result = $vwardb->query_first("
			SELECT COUNT(warid) AS numwars
			FROM vwar".$n."
			WHERE status = '1'
			$show
			$wherematchtype
		");
		$numwars = $result['numwars'];

		// cache scores
		if (!isset($scorecache))
		{
			$scorecache = createScoreCache();
		}

		$numlost = 0;
		$numwon = 0;
		$numdraw = 0;
		$ownscoretotal = 0;
		$oppscoretotal = 0;
		$result = $vwardb->query("
			SELECT warid, resultbylocations
			FROM vwar".$n.", vwar".$n."_matchtype
			WHERE vwar".$n.".matchtypeid = vwar".$n."_matchtype.matchtypeid
			AND status = '1'
			$show
			$wherematchtype
		");
		while ($row = $vwardb->fetch_array($result))
		{
			if ($row['resultbylocations'] == 0)
			{
				$ownscoretotal = $scorecache[$row['warid']]['sownscoretotal'];
				$oppscoretotal = $scorecache[$row['warid']]['soppscoretotal'];
			}
			else if ($row['resultbylocations'] == 1)
			{
				$oppscoretotal = $scorecache[$row['warid']]['loppscoretotal'];
				$ownscoretotal = $scorecache[$row['warid']]['lownscoretotal'];
			}

			if ($ownscoretotal < $oppscoretotal)
			{
				$numlost++;
			}
			else if ($ownscoretotal > $oppscoretotal)
			{
				$numwon++;
			}
			else if ($ownscoretotal == $oppscoretotal)
			{
				$numdraw++;
			}

			unset($ownscoretotal);
			unset($oppscoretotal);
		}
		$vwardb->free_result($result);

		// do precalculations for sorting
		$clauses = getSortClauses ();

		// init vars
		$gameids 				= array();

		$result = $vwardb->query("
			SELECT
			vwar".$n.".warid,
			vwar".$n.".gametypeid,
			vwar".$n.".matchtypeid,
			vwar".$n.".gameid,
			vwar".$n.".dateline,
			vwar".$n.".resultbylocations,
			vwar".$n."_matchtype.matchtypeid,
			vwar".$n."_matchtype.matchtypename,
			vwar".$n."_matchtype.matchtypeurl,
			vwar".$n."_gametype.gametypeid,
			vwar".$n."_gametype.gametypename,
			vwar".$n."_games.gamename,
			vwar".$n."_games.gamenameshort,
			vwar".$n."_games.gameicon,
			vwar".$n."_opponents.oppid,oppname,oppnameshort,oppcountry
			FROM vwar".$n."
			LEFT JOIN vwar".$n."_opponents ON (vwar".$n.".oppid = vwar".$n."_opponents.oppid)
			LEFT JOIN vwar".$n."_matchtype ON (vwar".$n.".matchtypeid = vwar".$n."_matchtype.matchtypeid)
			LEFT JOIN vwar".$n."_gametype ON (vwar".$n.".gametypeid = vwar".$n."_gametype.gametypeid)
			LEFT JOIN vwar".$n."_games ON (vwar".$n.".gameid = vwar".$n."_games.gameid)
			WHERE status = '1'
			$show
			$wherematchtype
			GROUP BY vwar".$n.".warid
			" . $clauses["sort"] . "
			" . $clauses["limit"]
		);
		while ($row = $vwardb->fetch_array($result))
		{
			dbSelect($row);
			switchColors();

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

			$dateline = formatdatetime($row['dateline'],$shortdateformat,1);

			$mt_link = makelink($row['matchtypeurl'], $row['matchtypename'], $row['matchtypename'], "_blank");
			$row['matchtypename'] = ifelse($row['matchtypeurl'], $mt_link, $row['matchtypename']);

			$ownscoretotal = 0;
			$oppscoretotal = 0;
			$ownscoretotalbylocations = 0;
			$oppscoretotalbylocations = 0;

			$ownscoretotal = $scorecache[$row['warid']]['sownscoretotal'];
			$oppscoretotal = $scorecache[$row['warid']]['soppscoretotal'];

			if($ownscoretotal < $oppscoretotal)
			{
								$scorecolor = $colorlost;
				$warstatus = $textlost;
			}
			else if ($ownscoretotal > $oppscoretotal)
			{
				$scorecolor = $colorwon;
				$warstatus = $textwon;
			}
			else if ($ownscoretotal == $oppscoretotal)
			{
				$scorecolor = $colordraw;
				$warstatus = $textdraw;
			}

			if ($row['resultbylocations'] == 1)
			{
				$oppscoretotalbylocations = $scorecache[$row['warid']]['loppscoretotal'];
				$ownscoretotalbylocations = $scorecache[$row['warid']]['lownscoretotal'];

				if($ownscoretotalbylocations < $oppscoretotalbylocations)
				{
					$scorecolor = $colorlost;
					$warstatus = $textlost;
				}
				else if ($ownscoretotalbylocations > $oppscoretotalbylocations)
				{
					$scorecolor = $colorwon;
					$warstatus = $textwon;
				}
				else if ($ownscoretotalbylocations == $oppscoretotalbylocations)
				{
					$scorecolor = $colordraw;
					$warstatus = $textdraw;
				}

				if ($showrealresults == 0)
				{
					$ownscoretotal = $ownscoretotalbylocations;
					$oppscoretotal = $oppscoretotalbylocations;
				}
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

			if (!in_array($row['gameid'],$gameids) && $row['gameicon'] != "" && file_exists($vwar_root . "images/gameicons/".$row['gameicon']))
			{
				eval("\$gameiconbit2 .= \"".$vwartpl->get("gameiconbit2")."\";");
				$gameids[] = $row['gameid'];
			}
			else if (!in_array($row['gameid'],$gameids))
			{
				eval("\$gameiconbit2 .= \"".$vwartpl->get("gameiconbit2_nopic")."\";");
				$gameids[] = $row['gameid'];
			}

			// get countrybit
			if ($showcountry == 1 && $row['oppcountry']!="")
			{
				$countrybit = makeimgtag($vwar_root . "images/flags/" . $row['oppcountry'] . ".gif",$country_array[$row['oppcountry']])."&nbsp;";
			}
			else if ($showcountry == 1)
			{
				$countrybit = makeimgtag($vwar_root . "images/flags/nocountry.gif",$str['NOTAVAILABLE'])."&nbsp;";
			}
			else
			{
				$countrybit = "";
			}

			if ($showcoloredresults == 1)
			{
				$ownscoretotal = "<font color=\"$scorecolor\">".$ownscoretotal;
				$oppscoretotal .= "</font>";
			}
			eval("\$war_listbit .= \"".$vwartpl->get("war_listbit")."\";");

			unset($ownscoretotal);
			unset($oppscoretotal);
			unset($ownscoretotalbylocations);
			unset($oppscoretotalbylocations);

		} // end while
		$vwardb->free_result($result);
///
$pagelinks = makepagelinks($numwars,$perpage,"showgame=$showgame&amp;showgametype=$showgametype&amp;showmatchtype=$showmatchtype&amp;sortby=$sortby&amp;sortorder=$sortorder");

		if (isset($GPC['showgame']) && !empty($GPC['showgame'])) $showtypes = " AND vwar".$n.".gameid = ".$showgame."";

		// get the war list navigation

		$result = $vwardb->query("
			SELECT DISTINCT(vwar".$n."_games.gameid), gamename, status
			FROM vwar".$n.",vwar".$n."_games
			WHERE vwar".$n.".gameid = vwar".$n."_games.gameid
			AND status = '1'
			$wherematchtype
			ORDER BY gamename ASC
		");
		while($row = $vwardb->fetch_array($result))
		{
			$gameid		=	$row['gameid'];
			$gamename	=	$row['gamename'];

			if ($GPC['showgame'] == $gameid || $GPC['showgame'] == $gameid)
			{
				eval("\$warlistnav_gameselectbit .= \"".$vwartpl->get("gameselectbit2")."\";");
			}
			else
			{
				eval("\$warlistnav_gameselectbit .= \"".$vwartpl->get("gameselectbit")."\";");
			}
		}

		$result = $vwardb->query("
			SELECT DISTINCT(vwar".$n."_matchtype.matchtypeid), matchtypename, status
			FROM vwar".$n.",vwar".$n."_matchtype
			WHERE vwar".$n."_matchtype.matchtypeid = vwar".$n.".matchtypeid
			AND status = '1'
			$showtypes
			$wherematchtype
			ORDER BY matchtypename
		");
		while ($row = $vwardb->fetch_array($result))
		{
			$matchtypeid		=	$row['matchtypeid'];
			$matchtypename	=	$row['matchtypename'];

			if ($GPC['showmatchtype'] == $matchtypeid || $GPC['showmatchtype'] == $matchtypeid)
			{
				eval("\$warlistnav_matchtypeselectbit .= \"".$vwartpl->get("matchtypeselectbit2")."\";");
			}
			else
			{
				eval("\$warlistnav_matchtypeselectbit .= \"".$vwartpl->get("matchtypeselectbit")."\";");
			}
		}

		$result = $vwardb->query("
			SELECT DISTINCT(vwar".$n."_gametype.gametypeid), gametypename, status
			FROM vwar".$n.",vwar".$n."_gametype
			WHERE vwar".$n."_gametype.gametypeid = vwar".$n.".gametypeid
			AND status = '1'
			$showtypes
			$wherematchtype
			ORDER BY gametypename
		");
		while ($row = $vwardb->fetch_array($result))
		{
			$gametypeid		=	$row['gametypeid'];
			$gametypename	=	$row['gametypename'];

			if ($GPC['showgametype'] == $gametypeid || $GPC['showgametype'] == $gametypeid)
			{
				eval("\$warlistnav_gametypeselectbit .= \"".$vwartpl->get("gametypeselectbit2")."\";");
			}
			else
			{
				eval("\$warlistnav_gametypeselectbit .= \"".$vwartpl->get("gametypeselectbit")."\";");
			}
		}

	if ($showlegend == 1 && $numwars > 1)
		{
			eval("\$war_list_legend = \"".$vwartpl->get("war_list_legend")."\";");
		}

		if ($showwarnav == 1)
		{
		eval("\$warlistnav = \"".$vwartpl->get("warlistnav")."\";");
		}

		$sortnav = getSortNav ( array("gamename", "dateline", "oppname", "matchtypename", "gametypename") );
  $result=$vwardb->query("SELECT name,password FROM vwar".$n."_member WHERE ismember='1' AND status <> '0' ORDER BY name ASC");
  while($row=$vwardb->fetch_array($result)){eval("\$login_userselect .= \"".$vwartpl->get("login_userselect")."\";");}
		if (!checkCookie())
		{
			if (isset($userlanguage))
			{
				$languagesel[$userlanguage] = "selected";
			}
			else if (isset($GPC['vwarlanguage']))
			{
				$languagesel[$GPC['vwarlanguage']] = "selected";
			}
			else
			{
				$languagesel[$vwarlanguage] = "selected";
			}

			while (list($languagekey,$languageval) = each($languages))
			{
				eval("\$languageselectbit .= \"".$vwartpl->get("languageselectbit")."\";");
			}

			eval("\$languageselect = \"".$vwartpl->get("languageselectfield")."\";");
			eval("\$loginfield = \"".$vwartpl->get("loginfield2")."\";");
		}
		else
		{
			$result = $vwardb->query_first("SELECT name FROM vwar".$n."_member WHERE memberid = '".$GPC['vwarid']."'");
			$loginname = $result['name'];
			eval("\$loginfield = \"".$vwartpl->get("loginfield")."\";");
		}

		eval("\$vwartpl->output(\"".$vwartpl->get("war_list")."\");");
	}
}

// ################################### war details  ####################################
if ($GPC['action'] == "details")
{

	//template-cache, standard-templates will be added by script:
	$quickjump = loadQuickjump();

	$vwartpllist = "war_details_screenbit,war_details_scorebit,gameiconbit,war_details2,war_details,";
	$vwartpllist .= "war_listbit2,war_details_more";
	$vwartpl->cache($vwartpllist);
	include ( $vwar_root . "includes/get_header.php" );


	$row = $vwardb->query_first("
		SELECT
		vwar".$n.".*,
		vwar".$n."_matchtype.*,
		vwar".$n."_gametype.*,
		vwar".$n."_games.*,
		vwar".$n."_opponents.oppname,
		vwar".$n."_opponents.oppnameshort
		FROM vwar".$n."
		LEFT JOIN vwar".$n."_opponents ON (vwar".$n.".oppid = vwar".$n."_opponents.oppid)
		LEFT JOIN vwar".$n."_matchtype ON (vwar".$n.".matchtypeid = vwar".$n."_matchtype.matchtypeid)
		LEFT JOIN vwar".$n."_gametype ON (vwar".$n.".gametypeid = vwar".$n."_gametype.gametypeid)
		LEFT JOIN vwar".$n."_games ON (vwar".$n.".gameid = vwar".$n."_games.gameid)
		WHERE warid = '".$GPC['warid']."'
		" . getPublicMatchtypes(1) . "
	");
	dbSelect($row);

	$oppid = $row['oppid'];
	$oppname = $row['oppname'];
	$oppnameshort = $row['oppnameshort'];
	$opplayers = ifelse($row['opplayers'],$row['opplayers'],"-");
	$ownplayers = ifelse($row['ownplayers'],$row['ownplayers'],"-");

	/* display members in columns
	if ($opplayers <> "-")
	{
		$opplayers_tmp = split(",", $row['opplayers']);

		$opplayers = join("<br />", $opplayers_tmp);
	}
	if ($ownplayers <> "-")
	{
		$ownlayers_tmp = split(",", $ownplayers);

		$ownplayers = join("<br />", $ownlayers_tmp);
	}
	*/

	if (!$row['report'] || ($row['publicreport'] == 0 && !checkCookie())) $row['report'] = $str['NOTAVAILABLE'];

	$locationnumber = 0;
	$ownscoretotal = 0;
	$oppscoretotal = 0;
	$result = $vwardb->query("
		SELECT *
		FROM vwar".$n."_scores, vwar".$n."_locations
		WHERE warid = '".$GPC['warid']."'
		AND vwar".$n."_scores.locationid = vwar".$n."_locations.locationid
		ORDER BY vwar".$n."_scores.scoreid ASC
	");
	while ($scores = $vwardb->fetch_array($result))
	{
		switchColors();

		$locationnumber++;
		$locationname = $scores['locationname'];

		if($scores['locationpic'] != "" AND @file_exists($vwar_root . "images/locations/".$scores['locationpic']))
		{
			$locationpic = makeimgtag($vwar_root . "images/locations/".$scores['locationpic'],$scores['locationname']);
		} else {
			$locationpic = $str['PICTURE']."&nbsp;".$str['NOTAVAILABLE'];
		}
		eval("\$war_locationbits .= \"".$vwartpl->get("war_locationbit")."\";");

		//$maps[] .= $scores['locationname'];

		if ($scores['ownscore'] < $scores['oppscore'])
		{
			$ownscorecolor = $colorlost;
			$oppscorecolor = $colorwon;
		}
		else if ($scores['ownscore'] > $scores['oppscore'])
		{
			$ownscorecolor = $colorwon;
			$oppscorecolor = $colorlost;
		}
		else if ($scores['ownscore'] == $scores['oppscore'])
		{
			$ownscorecolor = $colordraw;
			$oppscorecolor = $colordraw;
		}

		if ($row['resultbylocations'] == 0)
		{
			$ownscoretotal = $ownscoretotal+$scores['ownscore'];
			$oppscoretotal = $oppscoretotal+$scores['oppscore'];
		}
		else if ($row['resultbylocations'] == 1)
		{
			$ownscoretotalbyscore = $ownscoretotalbyscore+$scores['ownscore'];
			$oppscoretotalbyscore = $oppscoretotalbyscore+$scores['oppscore'];

			if ($scores['ownscore'] > $scores['oppscore']) $ownscoretotal = $ownscoretotal + 1;
			else if ($scores['ownscore'] < $scores['oppscore']) $oppscoretotal = $oppscoretotal + 1;
		}

		if ($scores['screenid'] && $scores['screenid'] != 0)
		{
			$screennumber = "Screenshot";
			eval("\$war_details_screenbit = \"".$vwartpl->get("war_details_screenbit")."\";");
		}
		else
		{
			$war_details_screenbit = "";
		}
		#unset($war_details_screenbit);
		eval("\$war_details_scorebit .= \"".$vwartpl->get("war_details_scorebit")."\";");
	}
	$vwardb->free_result($result);

	$numcomments = countComments($warid,"war");

	//if (!empty($maps)) $maps = implode(", ",$maps);

	$dateline = formatdatetime($row['dateline'],$longdateformat,1);

	$row['report'] = parseText($row['report'],1);

	if ($ownscoretotal > $oppscoretotal)
	{
		$scorecolorowntotal = $colorwon;
		$scorecoloropptotal = $colorlost;
	}
	else if ($ownscoretotal < $oppscoretotal)
	{
		$scorecolorowntotal = $colorlost;
		$scorecoloropptotal = $colorwon;
	}
	else if ($ownscoretotal == $oppscoretotal)
	{
		$scorecolorowntotal = $colordraw;
		$scorecoloropptotal = $colordraw;
	}

	if ($row['resultbylocations'] == 1)
	{
		$totalbyscoreown = "<smallfont>(".$ownscoretotalbyscore.")</smallfont>";
		$totalbyscoreopp = "<smallfont>(".$oppscoretotalbyscore.")</smallfont>";
	}

	if ($row['gameicon'] != "" && file_exists($vwar_root . "images/gameicons/".$row['gameicon']))
	{
		eval("\$gameiconbit = \"".$vwartpl->get("gameiconbit")."\";");
	}

	$result = $vwardb->query_first("
		SELECT COUNT(warid) AS numwars
		FROM vwar".$n."
		WHERE status = '1'
		AND oppid = '$oppid'
		AND warid <> '$warid'
		" . getPublicMatchtypes(1) . "
	");
	$num = $result['numwars'];

	if ($num == 0) eval("\$vwartpl->output(\"".$vwartpl->get("war_details2")."\");");
	if ($num > 0) eval("\$vwartpl->output(\"".$vwartpl->get("war_details")."\");");

	unset($ownscoretotal);
	unset($oppscoretotal);

	// display all other matches against this opponent

	unset($colourcounter);

	if ($num > 0)
	{
		//public matchtype
		if (!checkCookie())
		{
			$wherepublic = "AND public = '1'";
		}

		$result = $vwardb->query("
			SELECT
			COUNT(vwar".$n."_comments.commentid) AS numcomments,
			vwar".$n.".*,
			vwar".$n."_matchtype.*,
			vwar".$n."_gametype.*,
			vwar".$n."_games.*,
			vwar".$n."_opponents.oppname,
			vwar".$n."_opponents.oppnameshort
			FROM vwar".$n."
			LEFT JOIN vwar".$n."_opponents ON (vwar".$n.".oppid = vwar".$n."_opponents.oppid)
			LEFT JOIN vwar".$n."_matchtype ON (vwar".$n.".matchtypeid = vwar".$n."_matchtype.matchtypeid)
			LEFT JOIN vwar".$n."_gametype ON (vwar".$n.".gametypeid = vwar".$n."_gametype.gametypeid)
			LEFT JOIN vwar".$n."_games ON (vwar".$n.".gameid = vwar".$n."_games.gameid)
			LEFT JOIN vwar".$n."_comments ON (vwar".$n.".warid = vwar".$n."_comments.sourceid AND vwar".$n."_comments.frompage = 'war')
			WHERE status = '1'
			AND vwar".$n."_opponents.oppid = '$oppid'
			AND vwar".$n.".warid <> '$warid'
			" . getPublicMatchtypes(1) . "
			GROUP BY vwar".$n.".warid
			ORDER BY vwar".$n.".dateline DESC
		");
		while ($row = $vwardb->fetch_array($result))
		{
			dbSelect($row);
			switchColors();

			$dateline = formatdatetime($row['dateline'],$shortdateformat);
			$row['matchtypename'] = ifelse($row['matchtypeurl'], makelink($row['matchtypeurl'], $row['matchtypename']), $row['matchtypename']);

			$ownscoretotal = 0;
			$oppscoretotal = 0;

			if ($row['resultbylocations'] == 0)
			{
				$scores = $vwardb->query_first("
					SELECT
					SUM(ownscore) AS ownscoretotal,
					SUM(oppscore) AS oppscoretotal
					FROM vwar".$n."_scores
					WHERE warid = '".$row['warid']."'
				");
				$ownscoretotal = $scores['ownscoretotal'];
				$oppscoretotal = $scores['oppscoretotal'];
				$vwardb->free_result($scores);
			}
			else if ($row['resultbylocations'] == 1)
			{
				$result2 = $vwardb->query("SELECT ownscore, oppscore from vwar".$n."_scores WHERE warid = '".$row['warid']."'");
				while ($scores = $vwardb->fetch_array($result2))
				{
					if ($scores['ownscore'] < $scores['oppscore']) $oppscoretotal = $oppscoretotal + 1;
					else if ($scores['ownscore'] > $scores['oppscore']) $ownscoretotal = $ownscoretotal + 1;
				}
				$vwardb->free_result($result2);
			}

			if ($ownscoretotal < $oppscoretotal)
			{
				$scorecolor = $colorlost;
				$warstatus = $textlost;
			}
			else if ($ownscoretotal > $oppscoretotal)
			{
				$scorecolor = $colorwon;
				$warstatus = $textwon;
			}
			else if ($ownscoretotal == $oppscoretotal)
			{
				$scorecolor = $colordraw;
				$warstatus = $textdraw;
			}
			$vwardb->free_result($result2);

			if($row['gameicon'] != "" && file_exists($vwar_root . "images/gameicons/".$row['gameicon']))
			eval("\$gameiconbit = \"".$vwartpl->get("gameiconbit")."\";");

			if ($showcoloredresults == 1)
			{
				$ownscoretotal = "<font color=\"$scorecolor\">".$ownscoretotal;
				$oppscoretotal .= "</font>";
			}
			eval("\$war_listbit .= \"".$vwartpl->get("war_listbit2")."\";");
		}
		$vwardb->free_result($result);
		eval("\$vwartpl->output(\"".$vwartpl->get("war_details_more")."\");");
	}
}
// ################################### show screen #####################################
if ($GPC['action'] == "screen")
{
	//template-cache, standard-templates will be added by script:
	$vwartpllist = "war_screen";
	$vwartpl->cache($vwartpllist);
	include ($vwar_root . "includes/get_header.php");

	$quickjump = loadQuickjump();

	$row = $vwardb->query_first("
		SELECT
		vwar".$n."_screen.filename,
		vwar".$n.".warid,
		vwar".$n.".dateline,
		vwar".$n."_locations.locationname,
		oppnameshort
		FROM vwar".$n."_screen
		LEFT JOIN vwar".$n." ON (vwar".$n."_screen.warid = vwar".$n.".warid)
		LEFT JOIN vwar".$n."_locations ON (vwar".$n."_screen.locationid = vwar".$n."_locations.locationid)
		LEFT JOIN vwar".$n."_opponents ON (vwar".$n.".oppid = vwar".$n."_opponents.oppid)
		WHERE vwar".$n."_screen.screenid = '".$GPC['screenid']."'
		" . getPublicMatchtypes(1) . "
	");
	$dateline = formatdatetime($row['dateline'],$shortdateformat,1);
	$oppnameshort = $row['oppnameshort'];

	if ($row['warid'])
	{
		eval("\$vwartpl->output(\"".$vwartpl->get("war_screen")."\");");
	}
	else
	{
		header("modules.php?name=$vwarmod&file=war");
	}
}

// ################################### display nextactions #############################
if ($GPC['action'] == "nextaction")
{

	//display all nextactions with game-, membergames- & today-clause
	if ($display != "status")
	{
		//template-cache, standard-templates will be added by script:
		$vwartpllist = "gameiconbit,nextaction_detailbit,nextaction_noactions,nextaction_partbit,nextaction,nextaction_nav";
		$vwartpl->cache($vwartpllist);
		include ( $vwar_root . "includes/get_header.php" );

		//today-clause
		if ($display == "today")
		{
			$todaychecked = "selected";
			$daytime = date('H')*3600+date('i')*60+date('s');
			$unixtime = time();

			//timezoneoffset
			$daybegin = ($unixtime - $daytime) + ($timezoneoffset * 3600);
			$dayend = ($unixtime + 86400 - $daytime) + ($timezoneoffset * 3600);

			$wheretime = "dateline > '".$daybegin."' AND dateline < '".$dayend."'";
		}
		else
		{
			$wheretime = "dateline > '".((time() + ($timezoneoffset * 3600)) - ($waroverlap * 60))."'";
			$allchecked = "selected";
		}

		//game-clause
		$wheregame = "";
		if ($formgame != "own" && !empty($formgame))
		{
			$wheregame = "AND vwar".$n.".gameid = '".$formgame."'";
		}

		//membergames-clause
		if ($formgame == "own")
		{
			$wheremembergame1 = ",vwar".$n."_membergames";
			$wheremembergame2 = "AND vwar".$n.".gameid = vwar".$n."_membergames.gameid AND vwar".$n."_membergames.memberid = '".$GPC['vwarid']."'";
			$ownchecked = "selected";
		}

		$result = $vwardb->query("
			SELECT vwar".$n.".*,
			matchtypename,
			gametypename,
			vwar".$n."_games.*,
			vwar".$n."_opponents.oppid,
			vwar".$n."_opponents.oppname,
			vwar".$n."_opponents.oppnameshort,
			vwar".$n."_server.*
			FROM vwar".$n." $wheremembergame1
			LEFT JOIN vwar".$n."_opponents ON (vwar".$n.".oppid = vwar".$n."_opponents.oppid)
			LEFT JOIN vwar".$n."_matchtype ON (vwar".$n.".matchtypeid = vwar".$n."_matchtype.matchtypeid)
			LEFT JOIN vwar".$n."_gametype ON (vwar".$n.".gametypeid = vwar".$n."_gametype.gametypeid)
			LEFT JOIN vwar".$n."_games ON (vwar".$n.".gameid = vwar".$n."_games.gameid)
			LEFT JOIN vwar".$n."_server ON (vwar".$n.".serverid = vwar".$n."_server.serverid)
			WHERE $wheretime
			AND status = '0'
			$wheregame
			$wheremembergame2
			" . getPublicMatchtypes(1) . "
			ORDER BY dateline ASC
		");
		$countwars = $vwardb->num_rows($result);

		if ($countwars > 0)
		{
			while ($row = $vwardb->fetch_array($result))
			{
				dbSelect($row);

				if ($row['info'] == "" || ($row['publicinfo'] == 0 && !checkCookie())) $row['info'] = $str['NOTAVAILABLE'];

				if ($row['servername'] == "") $row['servername'] = $str['NOTAVAILABLESHORT'];
				else $row['servername'] = makeimgtag($vwar_root . "images/button_server.gif",$row['servername'],"top") . "&nbsp;" . $row['servername'];

				if ($row['serverip'] == "") $row['serverip'] = $str['NOTAVAILABLESHORT'];

				$row['info'] = parseText($row['info'],1);

				$weekday = $weekdaynames[date("w",$row['dateline'])];
				$wardate = date($shortdateformat,$row['dateline']);
				$wartime = date("H:i",$row['dateline']);

				if ($row['gameicon'] != "" && file_exists($vwar_root . "images/gameicons/".$row['gameicon']))
				{
					eval("\$gameiconbit = \"".$vwartpl->get("gameiconbit")."\";");
				}
				$playerperteam = $row['playerperteam'];

				$numavailable 	= 0;
				$is_signed_up 	= 0;
				$is_signed 	= 0;

				$result2 = $vwardb->query("
					SELECT vwar".$n."_member.memberid, partid, name, comment, available, dateline
					FROM vwar".$n."_member, vwar".$n."_participants
					WHERE vwar".$n."_member.memberid = vwar".$n."_participants.memberid
					AND warid = ".$row['warid']."
					ORDER BY name ASC
				");
				while ($member = $vwardb->fetch_array($result2))
				{
					if ($member['partid'])
					{

						if ($member['memberid'] == $GPC['vwarid']) {

							if ($member['available'] == 1)
							{
								$is_signed_up = 1;
							}
							$is_signed = 1;
							eval("\$nextaction_signedoptions = \"".$vwartpl->get("nextaction_signedoptions")."\";");
						}
						else
						{
							$nextaction_signedoptions = "";
						}

						$membercomment = parseText(dbSelect($member['comment']),1);
						$membername = $member['name'];

						if ($member['available'] == 1)
						{
							$numavailable++;
							$available = makeimgtag($vwar_root . "images/button_check.gif", $str['YES'], "top");
						}
						else if ($member['available'] == 0)
						{
							$available = makeimgtag($vwar_root . "images/button_uncheck.gif", $str['NO'], "top");
						}
						else if ($member['available'] == 2)
						{
							$available = makeimgtag($vwar_root . "images/button_unsure.gif", $str['YES'] . "/" . $str['NO'], "top");
						}

						$dateline = formatdatetime($member['dateline'],$longdateformat);
						eval("\$nextaction_partbit .= \"".$vwartpl->get("nextaction_partbit")."\";");
					}
				}
				$vwardb->free_result($result2);

				// get members only stuff
				if (checkCookie())
				{
					// server password
					if ($is_signed_up == 1)
					{
						$serverpassword = (empty($row["serverpassword"])) ? $str["NOTAVAILABLESHORT"] : $row["serverpassword"];
						$serverpassword = "<br />" . $str['PASSWORD'] . ":<b>&nbsp;" . $serverpassword . "</b>";
					}
					else
					{
						$serverpassword = "";
					}

					// sign options
					if ($is_signed != 1)
					{
						eval("\$nextaction_signoptions .= \"".$vwartpl->get("nextaction_signoptions")."\";");
					}
				}
				else
				{
					$serverpassword           = "";
					$nextaction_signoptions   = "";
					$nextaction_signedoptions = "";
				}

				$numrequired = $playerperteam - $numavailable;
				if ($numrequired <= 0) $numrequired = 0;
				$partcolor = ($numrequired == 0) ? "" : "{highlightcolor}";

				$locationnumber = 0;
				$result3 = $vwardb->query("
					SELECT locationname, locationpic
					FROM vwar".$n."_locations, vwar".$n."_scores
					WHERE vwar".$n."_scores.locationid = vwar".$n."_locations.locationid
					AND warid = '".$row['warid']."'
				");
				while ($location = $vwardb->fetch_array($result3))
				{
					switchColors();

					$locationnumber++;
					$locationname = $location['locationname'];

					if($location['locationpic'] != "" AND @file_exists($vwar_root . "images/locations/".$location['locationpic']))
					{
						$locationpic = makeimgtag($vwar_root . "images/locations/".$location['locationpic'],$location['locationname']);
					} else {
						$locationpic = $str['PICTURE']."&nbsp;".$str['NOTAVAILABLE'];
					}
					eval("\$war_locationbits .= \"".$vwartpl->get("war_locationbit")."\";");
				}

				if ($locationnumber == 0) eval("\$war_locationbits = \"".$vwartpl->get("war_locationbit_nolocations")."\";");

				eval("\$nextaction_detailbit .= \"".$vwartpl->get("nextaction_detailbit")."\";");

				unset($war_locationbits, $nextaction_partbit, $nextaction_signoptions, $serverpassword, $gameiconbit);
			}
			$vwardb->free_result($result);
		}
		else
		{
			eval("\$nextaction_detailbit = \"".$vwartpl->get("nextaction_noactions")."\";");
		}
	}
	//display nextactions without status
	else
	{
		$statuschecked = "selected";
		if (!checkCookie())
		{
			$vwartpl->cache("message_error_nopermission");
			include ( $vwar_root . "includes/get_header.php" );
			eval("\$vwartpl->output(\"".$vwartpl->get("message_error_nopermission")."\");");
			include ( $vwar_root . "includes/get_footer.php" );
			exit();
		}
		else
		{
			//template-cache, standard-templates will be added by script:
			$vwartpllist = "nextaction_noactions,nextaction_status_noactions,nextaction_status_actionbit,";
			$vwartpllist .= "nextaction_status_nostatus,nextaction_status_actionheader,nextaction_status_game,";
			$vwartpllist .= "gameselectbit2,gameselectbit,nextaction_nav,nextaction";
			$vwartpl->cache($vwartpllist);

			include ( $vwar_root . "includes/get_header.php" );

			//public matchtype
			if (!checkCookie())
			{
				$result = $vwardb->query("SELECT matchtypeid FROM vwar".$n."_matchtype WHERE public = '1'");
				while ($row = $vwardb->fetch_array($result))
				{
					$matchtypearray[] = $row['matchtypeid'];
				}
				$wherematchtype = "AND vwar".$n.".matchtypeid IN ('".join("','", $matchtypearray)."')";
				$vwardb->free_result($result);
			}

			if ($formgame == "own")
			{
				$query = "
					SELECT
					vwar".$n."_games.gameid, gamename, gameicon
					FROM vwar".$n."_membergames, vwar".$n."_games
					WHERE vwar".$n."_membergames.gameid = vwar".$n."_games.gameid
					AND memberid = '".$GPC['vwarid']."'
					ORDER BY gamename
				";
				$ownchecked = "selected";
			}
			else
			{
				if (!empty($formgame)) $wheregame = "AND vwar".$n."_games.gameid = '".$formgame."'";
				$query = "
					SELECT
					DISTINCT(vwar".$n."_games.gameid), gamename, gameicon
					FROM vwar".$n.", vwar".$n."_games
					WHERE vwar".$n.".gameid = vwar".$n."_games.gameid
					$wheregame
					ORDER BY gamename
				";
			}
			$result = $vwardb->query($query);
			if ($vwardb->num_rows($result) == 0) eval("\$nextaction_detailbit = \"".$vwartpl->get("nextaction_noactions")."\";");
			while ($game = $vwardb->fetch_array($result))
			{
				$result2 = $vwardb->query("
					SELECT warid, dateline, playerperteam, oppname, oppnameshort, vwar".$n."_opponents.oppid, oppcountry
					FROM vwar".$n."
					LEFT JOIN vwar".$n."_opponents ON (vwar".$n.".oppid = vwar".$n."_opponents.oppid)
					WHERE dateline > '".time()."'
					AND status = '0'
					AND gameid = '".$game['gameid']."'
					ORDER BY dateline ASC
				");
				if ($vwardb->num_rows($result2) == 0)
				{
					eval("\$nextaction_statusbit = \"".$vwartpl->get("nextaction_status_noactions")."\";");
				}
				else
				{
					while ($row = $vwardb->fetch_array($result2))
					{
						$checkstatus = $vwardb->query_first("
							SELECT COUNT(partid) AS numparts
							FROM vwar".$n."_participants
							WHERE warid = '".$row['warid']."'
							AND memberid = '".$GPC['vwarid']."'
						");
						if ($checkstatus['numparts'] == 0)
						{
							$somestatus = true;
							$weekday = $weekdaynames[date("w",$row['dateline'])];
							$wardate = date($shortdateformat,$row['dateline']);
							$wartime = date("H:i",$row['dateline']);

							if ($showcountry == 1 && $row['oppcountry'] != "")
							{
								$countrybit = makeimgtag($vwar_root . "images/flags/".$row['oppcountry'].".gif",$country_array[$row['oppcountry']])." ";
							}
							else
							{
								$countrybit = makeimgtag($vwar_root . "images/flags/nocountry.gif",$str['NOTAVAILABLE']);
							}

							$parts2 = $vwardb->query_first("
								SELECT COUNT(partid) AS numparts
								FROM vwar".$n."_participants
								WHERE warid = '".$row['warid']."'
								AND available = '1'
							");
							$available = $parts2['numparts'];
							$partcolor = ($available >= $row['playerperteam']) ? "" : "{highlightcolor}";
							switchColors();
							eval("\$nextaction_statusbit .= \"".$vwartpl->get("nextaction_status_actionbit")."\";");
						}
					}
					if (!$somestatus)
					{
						eval("\$nextaction_statusbit = \"".$vwartpl->get("nextaction_status_nostatus")."\";");
					}
					else
					{
						eval("\$nextaction_actionheader = \"".$vwartpl->get("nextaction_status_actionheader")."\";");
					}
				}

				if ($game['gameicon'] != "" && file_exists($vwar_root . "images/gameicons/".$game['gameicon']))
				{
					$gameiconbit=makeimgtag($vwar_root . "images/gameicons/".$game['gameicon'])." ";
				}

				eval("\$nextaction_detailbit .= \"".$vwartpl->get("nextaction_status_game")."\";");

				unset($nextaction_actionheader);
				unset($nextaction_statusbit);
				unset($somestatus);
				unset($colourcounter);
				unset($gameiconbit);
			}
			$vwardb->free_result($result);
		}
	}

	//make nextaction navigation
	$result = $vwardb->query("
		SELECT DISTINCT(vwar".$n."_games.gameid), gamename
		FROM vwar".$n.", vwar".$n."_games
		WHERE vwar".$n.".gameid = vwar".$n."_games.gameid
		$wherematchtype
		ORDER BY gamename
	");
	while ($row = $vwardb->fetch_array($result))
	{
		$gamecount = true;
		$gameid = $row['gameid'];
		$gamename = $row['gamename'];

		if ($formgame == $gameid)
		{
			eval("\$nextactionnav_gameselectbit .= \"".$vwartpl->get("gameselectbit2")."\";");
		}
		else
		{
			eval("\$nextactionnav_gameselectbit .= \"".$vwartpl->get("gameselectbit")."\";");
		}
	}
	$vwardb->free_result($result);

	$result = $vwardb->query_first("SELECT COUNT(membergamesid) AS numgames FROM vwar".$n."_membergames WHERE memberid = '".$GPC['vwarid']."'");
	if ($result['numgames'] != 0)
	{
		$nextactionnav_membergames = "<option value=\"own\" $ownchecked>".$str['OWNGAMES']."</option>";

		if ($gamecount)
		{
			$nextactionnav_membergames .= "<option value=\"\">-----------------</option>";
		}
	}
	eval("\$nextactionnav .= \"".$vwartpl->get("nextaction_nav")."\";");

	$quickjump = loadQuickjump($GPC["PURE_PHP_SELF"]."?name=$vwarmod&action=nextaction");

	//do output nextactions
	eval("\$vwartpl->output(\"".$vwartpl->get("nextaction")."\");");
}
// ################################### war signup ######################################
if ($GPC['action'] == "signup")
{
	if (!checkCookie())
	{
		$vwartpl->cache("message_error_nopermission");
		include ( $vwar_root . "includes/get_header.php" );
		eval("\$vwartpl->output(\"".$vwartpl->get("message_error_nopermission")."\");");
		include ( $vwar_root . "includes/get_footer.php" );
		exit();
	}

	// check if war isn't finished
	$row = $vwardb->query_first("SELECT status FROM vwar".$n." WHERE warid = '".$GPC['warid']."'");
	if ($row['status'] == 0)
	{

		if ($GPC['add'] || $GPC['add_x'])
		{
			$vwardb->query("
				INSERT INTO vwar".$n."_participants (memberid, warid, comment, available, dateline)
				VALUES ('".$GPC['vwarid']."', '".$GPC['warid']."', '".$comment."', '$available', '".time()."')
			");
			header("Location: modules.php?name=$vwarmod&file=war&action=nextaction#".$GPC['warid']);
		}
		else
		{
			//template-cache, standard-templates will be added by script:
			$vwartpllist = "message_error_signedupyet,nextaction_signup";
			$vwartpl->cache($vwartpllist);
			include ( $vwar_root . "includes/get_header.php" );

			$result = $vwardb->query_first("
				SELECT COUNT(partid) AS numparts
				FROM vwar".$n."_participants
				WHERE memberid = '".$GPC['vwarid']."'
				AND vwar".$n."_participants.warid = '".$GPC['warid']."'
			");
			$num = $result['numparts'];

			if ($num > 0)
			{
				eval("\$vwartpl->output(\"".$vwartpl->get("message_error_signedupyet")."\");");
			}
			else
			{
				$row = $vwardb->query_first("
					SELECT oppnameshort, dateline
					FROM vwar".$n.", vwar".$n."_opponents
					WHERE vwar".$n.".oppid = vwar".$n."_opponents.oppid
					AND warid = '".$GPC['warid']."'
				");
				dbSelect($row);
				$wardate = date($longdateformat,$row['dateline']);
				eval("\$vwartpl->output(\"".$vwartpl->get("nextaction_signup")."\");");
				$vwardb->free_result($result);
			}
		}
	}
	else
	{
		// war is finished
		$vwartpl->cache("message_error_nopermission");
		include ( $vwar_root . "includes/get_header.php" );
		eval("\$vwartpl->output(\"".$vwartpl->get("message_error_nopermission")."\");");
		include ( $vwar_root . "includes/get_footer.php" );
		exit();
	}
}
// ################################# edit war signup ###################################
if ($GPC['action'] == "editsigned")
{
	if (!checkCookie())
	{
		$vwartpl->cache("message_error_nopermission");
		include ( $vwar_root . "includes/get_header.php" );
		eval("\$vwartpl->output(\"".$vwartpl->get("message_error_nopermission")."\");");
		include ( $vwar_root . "includes/get_footer.php" );
		exit();
	}

	if ($GPC['add'] || $GPC['add_x'])
	{
		$vwardb->query("
			UPDATE vwar".$n."_participants
			SET
			comment   		= '".$GPC['comment']."',
			available 		= '".$GPC['available']."',
			dateline  		= '".time()."'
			WHERE warid 	= '".$GPC['warid']."'
			AND memberid 	= '".$GPC['vwarid']."'
		");
		header("Location: modules.php?name=$vwarmod&file=war&action=nextaction#".$GPC['warid']);
	}

	//template-cache, standard-templates will be added by script:
	$vwartpllist = "nextaction_editsigned";
	$vwartpl->cache($vwartpllist);

	include ($vwar_root . "includes/get_header.php");

	$row = $vwardb->query_first("
		SELECT oppnameshort, dateline
		FROM vwar".$n.", vwar".$n."_opponents
		WHERE vwar".$n.".oppid = vwar".$n."_opponents.oppid
		AND warid = '".$GPC['warid']."'
	");
	$oppnameshort 				= dbSelect ($row['oppnameshort']);
	$wardate      				= date ($longdateformat, $row['dateline']);

	$row = $vwardb->query_first("
		SELECT comment, available, dateline
		FROM vwar".$n."_participants
		WHERE warid = '".$GPC['warid']."'
		AND memberid = '".$GPC['vwarid']."'
	");
	$comment                     = dbSelectForm ($row['comment']);
	$selected[$row['available']] = "selected";
	$signedupdate                = date ($longdateformat, $row['dateline']);

	eval("\$vwartpl->output(\"".$vwartpl->get("nextaction_editsigned")."\");");
}
// ################################### war signoff #####################################
if ($GPC['action'] == "signoff")
{
	if (!checkCookie())
	{
		$vwartpl->cache("message_error_nopermission");
		include ( $vwar_root . "includes/get_header.php" );
		eval("\$vwartpl->output(\"".$vwartpl->get("message_error_nopermission")."\");");
		include ( $vwar_root . "includes/get_footer.php" );
		exit();
	}
	else
	{
		$vwardb->query("
			DELETE FROM vwar".$n."_participants
			WHERE memberid = '".$GPC['vwarid']."'
			AND warid = '".$GPC['warid']."'
		");
		header("Location: modules.php?name=$vwarmod&file=war&action=nextaction#".$GPC['warid']);
	}
}

// ##################################### war comments ##################################
if ($GPC['action'] == "comment")
{
	// create vars (only if comment-action != delete)
	if ($GPC['cmd'] != "delete" && $command != "delete")
	{
		$row = $vwardb->query_first("
			SELECT oppnameshort, dateline
			FROM vwar".$n.", vwar".$n."_opponents
			WHERE vwar".$n.".oppid = vwar".$n."_opponents.oppid AND warid = '".$GPC['warid']."'
		");
		$row['oppnameshort'] = dbSelect($row['oppnameshort']);
		$wardate             = formatdatetime($row['dateline'], $longdateformat, 1);
		eval("\$commenttitle = \"".$vwartpl->get("comment_display_commenttitle_war")."\";");

		$returntitle = $str['BACKTOWARDETAILS'];
		$returnurl   = "modules.php?name=$vwarmod&file=war&action=details&amp;warid=" . $GPC['warid'];
	}

	// params
	$comments = array (
		"sourceid"			=> $GPC["warid"],
		"frompage"			=> "war",
		"title"					=> "War",
		"commenttitle"	=> $commenttitle,
		"returntitle"		=> $returntitle,
		"returnurl"			=> $returnurl
	);
	// load engine
	include ($vwar_root . "includes/functions_comments.php");
}

// ################################### logout ##########################################
if ($GPC['action'] == "logout")
{
	SetVWarCookie("vwarid", "", 1);
	SetVWarCookie("vwarpassword", "", 1);
	SetVWarCookie("vwarlanguage", "", 1);
	// IIS needs this redirection...
	header("Cache-Control: no-cache, must-revalidate");
	header("Pragma: no-cache");
	$vwartpl->cache ( "message_confirmation" );
	include ( $vwar_root . "includes/get_header.php" );
	$redirecturl = "modules.php?name=$vwarmod&file=war";
	eval ("\$vwartpl->output(\"" . $vwartpl->get("message_confirmation") . "\");");
	include ( $vwar_root . "includes/get_footer.php" );
}
// ################################## forgot password ##################################
if ($GPC['action'] == "forgotpw")
{
	//user got the email, he wants the new password:
	if (isset($GPC['c']) && isset($GPC['id']))
	{
		//check input
		$askedtime = $vwardb->query_first("
			SELECT forgotpw
			FROM vwar".$n."_member
			WHERE password = '".$GPC['c']."'
			AND memberid = '".$GPC['id']."'
		");
				$checklink = $vwardb->query_first("
			SELECT COUNT(memberid) AS nummembers
			FROM vwar".$n."_member
			WHERE password = '".$GPC['c']."'
			AND memberid = '".$GPC['id']."'
		");
		if (!$checklink['nummembers'] || time() - $askedtime['forgotpw'] > 84600)
		{
			$vwartpl->cache("message_error_forgotpw_mail");
			include ( $vwar_root . "includes/get_header.php" );
			eval("\$vwartpl->output(\"".$vwartpl->get("message_error_forgotpw_mail")."\");");
		}
		else
		{
			$vwartpl->cache("message_mail_forgotpw_pw,message_forgotpw_mail");
			include ( $vwar_root . "includes/get_header.php" );

			//create pw
			$newpw = createRandomPassword(7,"abcdefghijklmnopqrstuvwxyz");

			//update pw
			$vwardb->query("
				UPDATE vwar".$n."_member
				SET forgotpw = '0', password = '".md5($newpw)."'
				WHERE password = '".$GPC['c']."'
				AND memberid = '".$GPC['id']."'
			");

			//create mail
			$result = $vwardb->query_first("
				SELECT name, email
				FROM vwar".$n."_member
				WHERE password = '".md5($newpw)."'
				AND memberid = '".$GPC['id']."'
			");
			eval("\$content = \"".$vwartpl->get("message_mail_forgotpw_pw")."\";");

			//mail
			sendMail($content, $result['email'], $result["name"], "", "", "Virtual War Forgot Password");

			eval("\$vwartpl->output(\"".$vwartpl->get("message_forgotpw_mail")."\");");
			include ($vwar_root . "includes/get_footer.php");
		}
		exit;
	}

	//user has filled the forgot password-form:
	if ($GPC['add'] || $GPC['add_x'])
	{
		//check mails
			$countemails = $vwardb->query_first("
			SELECT COUNT(memberid) AS nummembers
			FROM vwar".$n."_member
			WHERE email = '".$GPC['email']."'
		");
		if ($countemails['nummembers'] == 0 || $countemails['nummembers'] > 1)
		{
			$vwartpl->cache("message_error_forgotpw_form");
			include ( $vwar_root . "includes/get_header.php" );
			eval("\$vwartpl->output(\"".$vwartpl->get("message_error_forgotpw_form")."\");");
			include ($vwar_root . "includes/get_footer.php");
		}
		else
		{
			$vwartpl->cache("message_mail_forgotpw_link,message_forgotpw_form");
			include ( $vwar_root . "includes/get_header.php" );

			//set timer
			$vwardb->query("
				UPDATE vwar".$n."_member
				SET forgotpw = '".time()."'
				WHERE email = '".$GPC['email']."'
			");

			//create mail
			$link   = checkUrlFormat(checkPath($ownhomepage));
			$result = $vwardb->query_first("
				SELECT memberid, name, password
				FROM vwar".$n."_member
				WHERE email = '".$GPC['email']."'
			");
			eval("\$content = \"".$vwartpl->get("message_mail_forgotpw_link")."\";");

			// send mail
			sendMail($content, $GPC['email'], $GPC["name"], "", "", "Virtual War Forgot Password");

			eval("\$vwartpl->output(\"".$vwartpl->get("message_forgotpw_form")."\");");
			include ($vwar_root . "includes/get_footer.php");
		}
		exit;
	}

	//normal form: user asks for his password
	$vwartpl->cache("member_forgotpw");
	$quickjump = loadQuickjump();
	include ( $vwar_root . "includes/get_header.php" );
	eval("\$vwartpl->output(\"".$vwartpl->get("member_forgotpw")."\");");
}
// ################################### opponentinfo ####################################
if ($GPC['action'] == "oppinfo")
{
	//template-cache, standard-templates will be added by script:
	$vwartpllist = "member_icqbit,member_aimbit,member_yimbit,member_msnbit,war_opponentinfo";
	$vwartpl->cache($vwartpllist);

	include ( $vwar_root . "includes/get_header.php" );

//	$row = $vwardb->query_first("SELECT * FROM vwar".$n."_opponents WHERE oppid = ".$GPC['oppid']."");
	$row = $vwardb->query_first("SELECT * FROM vwar".$n."_opponents WHERE oppid = '".$GPC['oppid']."'");
	dbSelect($row);

	if ($row['oppcountry'] != "")
	{
		$countryimage = makeimgtag($vwar_root . "images/flags/" . $row['oppcountry'] . ".gif",$country_array[$row['oppcountry']])."&nbsp;";
		$countryname = $country_array[$row['oppcountry']];
	}
	else
	{
		$countryimage = makeimgtag($vwar_root . "images/flags/nocountry.gif",$str['NOTAVAILABLE'])."&nbsp;";
		$countryname = $str['NOTAVAILABLE'];
	}

	if ($row['opphomepage'] != "" AND $row['opphomepage'] != "http://")
	{
		$row['opphomepage'] = makelink($row['opphomepage'],$row['opphomepage'],"","_blank");
	}
	else
	{
		$row['opphomepage'] = $str['NOTAVAILABLE'];
	}

	if ($row['oppcontacticq'])
	{
		$row['icq'] = $row['oppcontacticq'];
		eval("\$icqbit = \"".$vwartpl->get("member_icqbit")."\";");
	}
	else
	{
		$icqbit = $str['NOTAVAILABLE'];
	}

	if ($row['oppcontactaim'])
	{
		$row['aim'] = $row['oppcontactaim'];
		eval("\$aimbit = \"".$vwartpl->get("member_aimbit")."\";");
	}
	else
	{
		$aimbit = $str['NOTAVAILABLE'];
	}

	if ($row['oppcontactyim'])
	{
	 $row['yim'] = $row['oppcontactyim'];
	 eval("\$yimbit = \"".$vwartpl->get("member_yimbit")."\";");
	}
	else
	{
		$yimbit = $str['NOTAVAILABLE'];
	}

	if ($row['oppcontactmsn'])
	{
		$row['msn'] = $row['oppcontactmsn'];
		eval("\$msnbit = \"".$vwartpl->get("member_msnbit")."\";");
	}
	else
	{
		$msnbit = $str['NOTAVAILABLE'];
	}

	if ($row['oppcontactmail'])
	{
		$mailbit = encodeMail(makelink("mailto:".$row['oppcontactmail'],makeimgtag($vwar_root . "images/button_email.gif") . "&nbsp;" . $row['oppcontactmail']));
	}
	else
	{
		$mailbit = $str['NOTAVAILABLE'];
	}

	if ($row['oppcontactname'])
	{
		$namebit = $row['oppcontactname'];
	}
	else
	{
		$namebit = $str['NOTAVAILABLE'];
	}

	if ($row['oppircchannel'] == "") $row['oppircchannel'] = $str['NOTAVAILABLE'];
	if ($row['oppircnetwork'] == "")	$row['oppircnetwork'] = $str['NOTAVAILABLE'];

	eval("\$vwartpl->output(\"".$vwartpl->get("war_opponentinfo")."\");");
	$vwardb->free_result($result);
}
// ################################### opponentlist ####################################
if ($GPC['action'] == "opplist")
{
	//template-cache, standard-templates will be added by script:
	$vwartpllist = "war_opponentlist_bit,war_opponentlist";
	$vwartpl->cache($vwartpllist);

	include ( $vwar_root . "includes/get_header.php" );

	$result = $vwardb->query_first("SELECT COUNT(oppid) AS numopponents FROM vwar".$n."_opponents WHERE deleted = '0'");
	$numopponents = $result['numopponents'];

	$clauses = getSortClauses ("oppname");

	$pagelinks = makepagelinks($numopponents,$perpage,"action=opplist&amp;sortby=$sortby&amp;sortorder=$sortorder");

	$result = $vwardb->query("
		SELECT oppid, oppnameshort, oppname, opphomepage, oppcountry
		FROM vwar".$n."_opponents
		WHERE deleted = '0'
		" . $clauses["sort"] . "
		". $clauses["limit"]
	);
	while($row = $vwardb->fetch_array($result))
	{
		dbSelect($row);
		switchColors();

		if ($row['oppcountry'] != "")
		{
			$countryimage = makeimgtag($vwar_root . "images/flags/" . $row['oppcountry'] . ".gif",$country_array[$row['oppcountry']]) . "&nbsp;";
			$countryname = $country_array[$row['oppcountry']];
		}
		else
		{
			$countryimage = makeimgtag($vwar_root . "images/flags/nocountry.gif",$str['NOTAVAILABLE']) . "&nbsp;";
			$countryname = $str['NOTAVAILABLE'];
		}

		if ($row['opphomepage'] != "" && $row['opphomepage'] != "http://")
		{
			$homepagebit = makelink(checkUrlFormat($row['opphomepage']),$row['opphomepage'],"","_blank");
		}
		else
		{
			$homepagebit = $str['NOTAVAILABLE'];
		}

		eval("\$oppbit .= \"".$vwartpl->get("war_opponentlist_bit")."\";");
		unset($homepagebit);
		unset($countrybit);
	}
	$vwardb->free_result($result);

	$sortnav = getSortNav ( array("oppname", "oppnameshort", "oppcountry", "opphomepage"), "oppname" );

	eval("\$vwartpl->output(\"".$vwartpl->get("war_opponentlist")."\");");
}

include ($vwar_root . "includes/get_footer.php");
?>
