<?php
/* #####################################################################################
 *
 * $Id: member.php,v 1.150 2004/09/08 20:29:50 mabu Exp $
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

// init vars
$display 					= $GPC['display'];
$memberstatuslist = array();

// unset vars to prevent sql-injections
$clause 					= "";
$andclause				= "";

// ################################### display member ##################################
if ($GPC['action'] == "" && $display != "mail")
{
	//template-cache, standard-templates will be added by script:
	if ($display != "gallery" && $display != "contact")
	{
		$vwartpllist = "gameiconbit,gameiconbit2,member_listbit,war_list_legend,gameselectbit,gameselectbit2";
	}
	else if ($display == "gallery")
	{
		$vwartpllist = "member_gallery,member_gallery_list,member_gallery_listbit,member_gallery_nopicture";
	}
	else if ($display == "contact")
	{
		$vwartpllist = "member_icqbit2,member_aimbit2,member_yimbit2,member_msnbit2,member_mailbit,member_contact_listbit,";
		$vwartpllist .= "member_contact_list";
	}
	$vwartpllist .= "quickjump,member_listtable,member_list";
	$vwartpl->cache($vwartpllist);

	include ( $vwar_root . "includes/get_header.php" );

	$quickjump = loadQuickjump($GPC["PURE_PHP_SELF"]);

	// unset var $memberlist
	$memberlist = "";

	// display by memberstatus
	if ($display == "status" || $display == "")
	{
		$select['status'] = "selected";

		// get games
		$result = $vwardb->query("
			SELECT
			vwar".$n."_games.gamename, gameicon, gamenameshort,
			vwar".$n."_membergames.memberid
			FROM vwar".$n."_membergames
			LEFT JOIN vwar".$n."_games ON (vwar".$n."_games.gameid = vwar".$n."_membergames.gameid)
			ORDER BY vwar".$n."_games.gamename ASC
		");
		while ($game = $vwardb->fetch_array($result))
		{
			if ($game['gameicon'] != "" && file_exists($vwar_root . "images/gameicons/" . $game['gameicon']))
			{
				$row['gamename'] = $game['gamename'];
				$row['gameicon'] = $game['gameicon'];

				eval("\$membergames[\$game[\"memberid\"]] = \$membergames[\$game[\"memberid\"]] . \"".$vwartpl->get("gameiconbit")."\";");
			}
			else
			{
				$row['gamenameshort'] = $game['gamenameshort'];

				eval("\$membergames[\$game[\"memberid\"]] = \$membergames[\$game[\"memberid\"]] . \"".$vwartpl->get("gameiconbit_nopic")."\";");
			}
		}

		// get memberstatus
		if (!empty($GPC["id"]))
		{
			$clause = "WHERE vwar".$n."_memberstatus.statusid='" . str_replace ("-", "' OR vwar".$n."_memberstatus.statusid='", $GPC["id"]) . "'";
		}
		$result = $vwardb->query("
			SELECT *, COUNT(vwar".$n."_member.memberid) AS membercount
			FROM vwar".$n."_memberstatus
			LEFT JOIN vwar".$n."_member ON (vwar".$n."_member.status = vwar".$n."_memberstatus.statusid AND vwar".$n."_member.hidemember = '0' AND vwar".$n."_member.ismember = '1')
			$clause
			GROUP BY vwar".$n."_memberstatus.statusid
			ORDER BY vwar".$n."_memberstatus.displayorder ASC
		");
		while ($statusrow = $vwardb->fetch_array($result))
		{
			$memberstatuslist[$statusrow['statusid']] = array($statusrow['statusname'], $statusrow['membercount']);

			if ($statusrow['membercount'] > 0)
			{
				// get members
				$result2 = $vwardb->query("
					SELECT memberid, name, country, sex, status, customstatus, wartag
					FROM vwar".$n."_member
					WHERE hidemember = '0' AND ismember = '1' AND status = '".$statusrow['statusid']."'
					ORDER BY name ASC
				");
				while ($row = $vwardb->fetch_array($result2))
				{
					switchColors();
					dbSelect($row);
					
				// ################################### profilehits hack by tHecAsE  ####################################
				$memberwebsite = "<a href=\"modules.php?name=$vwarmod&file=member&action=profilehits&memberid=$row[memberid]\">$row[name]</a>";
				//profilehit hack
				//wartaghack
				$wartagbit = "$row[wartag]";
				//wartaghack
					$memberstatus = $memberstatuslist[$statusrow['statusid']][0];
					$row['customstatus'] = ifelse($row['customstatus'], "(" . $row['customstatus'] . ")");

					$countrybit = makeimgtag($vwar_root . "images/flags/" .
						ifelse($row['country'], $row['country'], "nocountry") . ".gif",
						ifelse($row['country'], $country_array[$row['country']], $str['NOTAVAILABLE']));

					$sexbit = makeimgtag($vwar_root . "images/" .
					ifelse($row['sex'], $row['sex'], "no") . ".gif",
					ifelse($row['sex'], $sex_array[$row['sex']], $str['NOTAVAILABLE']));
					// add member

					$gameiconbit = $membergames[$row['memberid']];

					eval("\$memberlist[\$statusrow[\"statusid\"]] = \$memberlist[\$statusrow[\"statusid\"]] . \"".$vwartpl->get("member_listbit")."\";");

					unset($gameiconbit);
				}
				$vwardb->free_result($result2);

				unset($colourcounter);
			}
		}
		$vwardb->free_result($result);

		// create tables
		foreach ($memberstatuslist AS $statusid => $statusdata)
		{
			$nummembers = $statusdata[1];
			$memberstatusname = $statusdata[0];
			$member_info = "<br><smallfont>" . $str['CURRENTLY'] . "&nbsp;" . $nummembers . "&nbsp;" . $memberstatusname . "</smallfont>";

			if ($nummembers > 0)
			{
				// create memberlist
				$memberstats .= "<b>" . $memberstatusname . ":</b>&nbsp;" . $nummembers."&nbsp;&nbsp;";
				$memberstatusname = makelink("modules.php?name=$vwarmod&file=member&display=status&amp;id=" . $statusid, $memberstatusname);
				$member_listbit .= $memberlist[$statusid];

				eval("\$member_listtable .= \"".$vwartpl->get("member_listtable")."\";");
			}
			unset($member_listbit);
		}
	}

	// display by teams
	if ($display == "teams")
	{
		$select['teams'] = "selected";

		// get games
		$result = $vwardb->query("
			SELECT vwar".$n."_games.gamename, gameicon, gamenameshort, vwar".$n."_membergames.memberid
			FROM vwar".$n."_membergames
			LEFT JOIN vwar".$n."_games ON (vwar".$n."_games.gameid = vwar".$n."_membergames.gameid)
			ORDER BY vwar".$n."_games.gamename ASC
		");
		while ($game = $vwardb->fetch_array($result))
		{
			if ($game['gameicon'] != "" && @file_exists($vwar_root . "images/gameicons/" . $game['gameicon']))
			{
				$row['gamename'] = $game['gamename'];
				$row['gameicon'] = $game['gameicon'];

				eval("\$membergames[\$game[\"memberid\"]] = \$membergames[\$game[\"memberid\"]] . \"".$vwartpl->get("gameiconbit")."\";");
			}
			else
			{
				$row['gamenameshort'] = $game['gamenameshort'];

				eval("\$membergames[\$game[\"memberid\"]] = \$membergames[\$game[\"memberid\"]] . \"".$vwartpl->get("gameiconbit_nopic")."\";");
			}
		}
		$vwardb->free_result($result);

		$result = $vwardb->query("
			SELECT *
			FROM vwar".$n."_memberstatus
			$clause
			GROUP BY statusid
			ORDER BY displayorder ASC
		");
		while ($statusrow = $vwardb->fetch_array($result))
		{
			$memberstatuslist[$statusrow['statusid']] = array($statusrow['statusname'], $statusrow['membercount']);
		}
		$vwardb->free_result($result);

		// get teams
		if (!empty($GPC["id"]))
		{
			$clause = "AND vwar".$n."_team.teamid='" . str_replace ("-", "' OR vwar".$n."_team.teamid='", $GPC["id"]) . "'";
		}
		$result = $vwardb->query("
			SELECT vwar".$n."_team.teamid, teamname, COUNT(vwar".$n."_member.memberid) AS membercount
			FROM vwar".$n."_teammember
			LEFT JOIN vwar".$n."_team ON (vwar".$n."_teammember.teamid = vwar".$n."_team.teamid)
			LEFT JOIN vwar".$n."_member ON (vwar".$n."_member.memberid = vwar".$n."_teammember.memberid AND vwar".$n."_member.ismember = '1' AND vwar".$n."_member.hidemember = '0')
			WHERE vwar".$n."_team.invisible = '0'
			AND vwar".$n."_team.deleted = '0'
			$clause
			GROUP BY vwar".$n."_teammember.teamid
			ORDER BY vwar".$n."_team.displayorder ASC, vwar".$n."_team.teamname ASC
		");
		while ($row = $vwardb->fetch_array($result))
		{
			$teammembercount[$row['teamid']] = $row['membercount'];
			$teamlist[$row['teamid']] = $row['teamname'];
		}
		$vwardb->free_result($result);

		if (sizeof($teamlist) > 0)
		{
			// cache data
			$tmp = $vwardb->query("
				SELECT vwar".$n."_member.memberid, name, country, status, customstatus, wartag, vwar".$n."_teammember.teamid
				FROM vwar".$n."_teammember,vwar".$n."_member,vwar".$n."_team
				WHERE vwar".$n."_member.memberid = vwar".$n."_teammember.memberid
				AND ismember = '1'
				AND hidemember = '0'
				$clause
				GROUP BY vwar".$n."_teammember.teammemberid
				ORDER BY name ASC
			");

			while ($tmp2 = $vwardb->fetch_array($tmp))
			{
				$datacache[$tmp2["teamid"]][] = $tmp2;
			}
			unset($tmp2);

			while (list($key,$teamname) = each($teamlist))
			{
				if ($teammembercount[$key] > 0)
				{
					for ($i = 0; $i < count($datacache[$key]); $i++)
					{
						$row = $datacache[$key][$i];

						dbSelect($row);
						switchColors();

						$memberstatus = $memberstatuslist[$row['status']];
				// ################################### profilehits hack by tHecAsE  ####################################
				$memberwebsite = "<a href=\"modules.php?name=$vwarmod&file=member&action=profilehits&memberid=$row[memberid]\">$row[name]</a>";
				//profilehit hack
				//wartaghack
				$wartagbit = "$row[wartag]";
				//wartaghack
						$memberstatusname = makelink("modules.php?name=$vwarmod&file=member&display=teams&amp;id=" . $key, $teamname);
						$memberstatus = $memberstatuslist[$row['status']][0];

						$row['customstatus'] = ifelse($row['customstatus'], "(" . $row['customstatus'] . ")");

						$countrybit = makeimgtag($vwar_root . "images/flags/" .
							ifelse($row['country'], $row['country'], "nocountry") . ".gif",
							ifelse($row['country'], $country_array[$row['country']], $str['NOTAVAILABLE']));

						$gameiconbit = $membergames[$row['memberid']];

						eval("\$member_listbit .= \"".$vwartpl->get("member_listbit")."\";");

						unset($gameiconbit);
						unset($countrybit);
					}
					unset($row);
					unset($i);

					$memberstats .= "<b>" . $teamname . ":</b>&nbsp;" . $teammembercount[$key]."&nbsp;&nbsp;";

				eval("\$member_listtable .= \"".$vwartpl->get("member_listtable")."\";");

					unset($colourcounter);
					unset($member_listbit);
				}
			}
		}
		else
		{
			eval("\$member_listtable = \"".$vwartpl->get("nextaction_noactions")."\";");
		}
	}

	// display by games
	if ($display == "games")
	{
		$select['games'] = "selected";

		// get membergames
		$result = $vwardb->query("
			SELECT
			vwar".$n."_games.gameid, gamename, gameicon, gamenameshort,
			vwar".$n."_membergames.memberid
			FROM vwar".$n."_membergames
			LEFT JOIN vwar".$n."_games ON (vwar".$n."_games.gameid = vwar".$n."_membergames.gameid)
			ORDER BY vwar".$n."_games.gamename ASC
		");
		while ($game = $vwardb->fetch_array($result))
		{
			$gamemembercount[$game['gameid']]++;

			if ($game['gameicon'] != "" && file_exists($vwar_root . "images/gameicons/" . $game['gameicon']))
			{
				$row['gamename'] = $game['gamename'];
				$row['gameicon'] = $game['gameicon'];

				eval("\$membergames[\$game[\"memberid\"]] = \$membergames[\$game[\"memberid\"]] . \"".$vwartpl->get("gameiconbit")."\";");
			}
			else
			{
				$row['gamenameshort'] = $game['gamenameshort'];

				eval("\$membergames[\$game[\"memberid\"]] = \$membergames[\$game[\"memberid\"]] . \"".$vwartpl->get("gameiconbit_nopic")."\";");
			}
		}
		$vwardb->free_result($result);

		// get status
		$result = $vwardb->query("
			SELECT *
			FROM vwar".$n."_memberstatus
			ORDER BY displayorder ASC
		");
		while ($statusrow = $vwardb->fetch_array($result))
		{
			$memberstatuslist[$statusrow['statusid']] = array($statusrow['statusname'], $statusrow['membercount']);
		}

		// get games
		if (!empty($GPC["id"]))
		{
			$clause = "AND (gameid = '" . str_replace ("-", "' OR gameid='", $GPC["id"]) . "')";
		}
		$result = $vwardb->query("
			SELECT gameid, gamename
			FROM vwar".$n."_games
			WHERE deleted = '0'
			$clause
			ORDER BY gamename ASC
		");
		while ($row = $vwardb->fetch_array($result))
		{
			dbSelect($row['gamename']);

			$gamelist[$row['gameid']] = $row['gamename'];
		}

		if (sizeof($gamelist) > 0)
		{
			// cache data
			$tmp = $vwardb->query("
				SELECT vwar".$n."_member.memberid, name, country, status, customstatus, wartag, vwar".$n."_membergames.gameid
				FROM vwar".$n."_membergames
				LEFT JOIN vwar".$n."_member ON (vwar".$n."_membergames.memberid = vwar".$n."_member.memberid)
				WHERE ismember = '1'
				AND hidemember = '0'
				GROUP BY vwar".$n."_membergames.membergamesid
				ORDER BY name ASC");
			while($tmp2 = $vwardb->fetch_array($tmp))
			{
				$gamecache[$tmp2["gameid"]][] = $tmp2;
			}
			unset($tmp2);

			while (list($gameid,$gamename) = each($gamelist))
			{
				if ($gamemembercount[$gameid] > 0)
				{
					$memberstatusname = makelink("modules.php?name=$vwarmod&file=member&display=games&amp;id=" . $gameid, $gamename);
			
					for ($i = 0; $i < count($gamecache[$gameid]); $i++)
					{
						$row = $gamecache[$gameid][$i];
						dbSelect($row);
						switchColors();

						$memberstatus = $memberstatuslist[$row['status']][0];

						$row['customstatus'] = ifelse($row['customstatus'], "(" . $row['customstatus'] . ")");
						//wartaghack
						$wartagbit = "$row[wartag]";
						//wartaghack
						$countrybit = makeimgtag($vwar_root . "images/flags/" .
							ifelse($row['country'], $row['country'], "nocountry") . ".gif",
							ifelse($row['country'], $country_array[$row['country']], $str['NOTAVAILABLE']));

						$gameiconbit = $membergames[$row['memberid']];
				// ################################### profilehits hack by tHecAsE  ####################################
				$memberwebsite = "<a href=\"modules.php?name=$vwarmod&file=member&action=profilehits&memberid=$row[memberid]\">$row[name]</a>";
				//profilehit hack
						eval("\$member_listbit .= \"".$vwartpl->get("member_listbit")."\";");

						unset($gameiconbit);
						unset($countrybit);
					}
					unset($i);
					unset($row);

					$memberstats .= "<b>" . $gamename.":</b>&nbsp;" . $gamemembercount[$gameid] . "&nbsp;&nbsp;";

					eval("\$member_listtable .= \"".$vwartpl->get("member_listtable")."\";");

					unset($gameiconbit);
					unset($colourcounter);
					unset($member_listbit);
				}
			}
		}
	}

	//display gallery
	if ($display == "gallery")
	{
		$select['gallery'] = "selected";

		$showlegend = 0;

		if (!empty($GPC["id"]))
		{
			$clause = "WHERE statusid = '" . str_replace ("-", "' OR statusid='", $GPC["id"]) . "'";
		}

		$result = $vwardb->query("SELECT * FROM vwar".$n."_memberstatus $clause ORDER BY displayorder ASC");
		while ($row = $vwardb->fetch_array($result))
		{
			$memberstatuslist[$row['statusid']] = $row['statusname'];
		}

		// cache data
			$tmp = $vwardb->query("
				SELECT picture, memberid, name, customstatus, status, wartag
				FROM vwar".$n."_member
				WHERE hidemember = '0'
				AND ismember = '1'
				ORDER BY name ASC
			");
			while($tmp2 = $vwardb->fetch_array($tmp))
			{
				$piccache[$tmp2["status"]][] = $tmp2;
			}

		while (list($key, $memberstatusname) = each($memberstatuslist))
		{
			$nummembers = count($piccache[$key]);

			$counter = 0;

			if ($nummembers == 0) continue;

			for($i = 0; $i < count($piccache[$key]); $i++)
			{
				$row2 = $piccache[$key][$i];
				$counter++;

				$imagepath = $vwar_root . "images/member/";

				if ($row2['picture'])
				{
					if (@file_exists($imagepath . "th_". $row2['picture']))
					{
						$memberpicture = makeimgtag($imagepath . "th_". $row2['picture'], $row2['name']);
						$memberpicture .= "<br>" . makeimgtag($vwar_root . "images/button_enlarge.gif", $str['ENLARGE']) . "&nbsp;";
						$memberpicture .= popupwin("modules.php?name=$vwarmod&file=popup&action=memberpic&amp;memberid=" . $row2['memberid'], "<small>" . $str['ENLARGE'] . "</small>");
					}
					else if (@file_exists($imagepath . $row2['picture']))
					{
						$memberpicture = makeimgtag($imagepath . $row2['picture'],$row2['name']); //,$thumbnailwidth,$thumbnailheight);
					}
				}
				else if (@file_exists($vwar_root . "images/" . $nomemberpic) && !empty($nomemberpic))
				{
					$memberpicture = makeimgtag($vwar_root . "images/" . $nomemberpic, $str['NOTAVAILABLE']);
				}
				else
				{
					eval("\$memberpicture = \"".$vwartpl->get("member_gallery_nopicture")."\";");
				}

				$membercustomstatus = ifelse($row2['customstatus'], $row2['customstatus']);

				if ($counter % 2 == 0 && $counter <= $nummembers)
				{
					eval("\$member_gallery_listbit .= \"".$vwartpl->get("member_gallery_listbit")."\";");

					$member_gallery_listbit .= "</tr>";
				}
				else if ($counter % 2 == 1 && $counter == $nummembers)
				{
					$member_gallery_listbit .= "<tr vAlign=\"top\">";

				 eval("\$member_gallery_listbit .= \"".$vwartpl->get("member_gallery_listbit")."\";");

					$member_gallery_listbit .= "<td width=\"0%\"></td></tr>";
				}
				else if ($counter % 2 == 1 && $counter < $nummembers)
				{
					$member_gallery_listbit .= "<tr vAlign=\"top\">";

					eval("\$member_gallery_listbit .= \"".$vwartpl->get("member_gallery_listbit")."\";");
				}
			}
			unset($i);
			unset($row2);

			if ($nummembers > 0)
			{
				$memberstats .= "<b>" . $memberstatusname . ":</b>&nbsp;" . $nummembers . "&nbsp;&nbsp;";
			}
			$memberstatusname = makelink("modules.php?name=$vwarmod&file=member&display=gallery&amp;id=" . $key, $memberstatusname);

			eval("\$member_listtable .= \"".$vwartpl->get("member_gallery_list")."\";");

			unset($member_gallery_listbit);
		}
	}

	//display contact
	if ($display == "contact")
	{
		$select['contact'] = "selected";
		$showlegend = 0;

		// get memberstatus
		if (!empty($GPC["id"]))
		{
			$clause = "AND vwar".$n."_memberstatus.statusid='" . str_replace ("-", "' OR vwar".$n."_memberstatus.statusid='", $GPC["id"]) . "'";
		}
		$result = $vwardb->query("
			SELECT statusid, statusname, COUNT(vwar".$n."_member.memberid)
			FROM vwar".$n."_memberstatus, vwar".$n."_member
			WHERE vwar".$n."_memberstatus.statusid = vwar".$n."_member.status AND ismember = '1' AND hidemember = '0' $clause
			GROUP BY statusid
			ORDER BY displayorder ASC");
		while ($row = $vwardb->fetch_array($result))
		{
			$memberstatuslist[$row['statusid']] = $row['statusname'];
		}
		$vwardb->free_result($result);

		// cache data
			$tmp = $vwardb->query("
				SELECT memberid, name, customstatus, status, email, aim, yim, msn, icq, country, sex, wartag
				FROM vwar".$n."_member
				WHERE hidemember = '0'
				AND ismember = '1'
				ORDER BY name ASC
			");
			while($tmp2 = $vwardb->fetch_array($tmp))
			{
				$contactcache[$tmp2["status"]][] = $tmp2;
			}

		while (list($key,$memberstatusname) = each($memberstatuslist))
		{
			for ($i = 0; $i < count($contactcache[$key]); $i++)
			{
				$row = $contactcache[$key][$i];
				dbSelect($row);
				switchColors();

				$name = $row['name'];

				$memberstatus = $memberstatuslist[$row['status']];

				$row['customstatus'] = ifelse($row['customstatus'], "(" . $row['customstatus'] . ")");

				$countrybit = makeimgtag($vwar_root . "images/flags/" .
					ifelse($row['country'], $row['country'], "nocountry") . ".gif",
					ifelse($row['country'], $country_array[$row['country']], $str['NOTAVAILABLE']));
				
				$sexbit = makeimgtag($vwar_root . "images/" .
					ifelse($row['sex'], $row['sex'], "no") . ".gif",
					ifelse($row['sex'], $sex_array[$row['sex']], $str['NOTAVAILABLE']));
				
				if ($row['email'] && $formmailer == 1)
				{
					$maillink = "modules.php?name=$vwarmod&file=member&action=mail&memberid=" . $row["memberid"];
					eval("\$mailbit = \"".$vwartpl->get("member_mailbit_formmailer")."\";");
				}
				else if ($row["email"])
				{
					$row['email'] = encodeMail($row['email']);
					eval("\$mailbit = \"".$vwartpl->get("member_mailbit")."\";");
					$maillink = "mailto:" . $row["email"];
				}
				else
				{
					$mailbit = $str['NOTAVAILABLE'];
				}

				if ($row['icq'])
				{
					$icq = $row['icq'];
					eval("\$contactbit = \"".$vwartpl->get("member_icqbit2")."\";");
				}
				if ($row['aim']) eval("\$contactbit .= \"".$vwartpl->get("member_aimbit2")."&nbsp;\";");
				if ($row['yim']) eval("\$contactbit .= \"".$vwartpl->get("member_yimbit2")."&nbsp;\";");
				if ($row['msn']) eval("\$contactbit .= \"".$vwartpl->get("member_msnbit2")."&nbsp;\";");
				if (!$contactbit) $contactbit = $str['NOTAVAILABLESHORT'];

				eval("\$member_listbit .= \"".$vwartpl->get("member_contact_listbit")."\";");

				unset($contactbit);
			}

			$nummembers = count($contactcache[$key]);

			$member_info = "<br><smallfont>" . $str['CURRENTLY'] . "&nbsp;" . $nummembers . "&nbsp;" . $memberstatusname . "</smallfont>";

			if($nummembers > 0)
			{
				$memberstats .= "<b>" . $memberstatusname . ":</b>&nbsp;" . $nummembers . "&nbsp;&nbsp;";
				$memberstatusname = makelink("modules.php?name=$vwarmod&file=member&display=contact&amp;id=" . $key, $memberstatusname);

				eval("\$member_listtable .= \"".$vwartpl->get("member_contact_list")."\";");
			}
			unset($colourcounter);
			unset($member_listbit);
		}
	}

	if ($showlegend==1 && $display != "gallery" && $display != "contact")
	{
		$result = $vwardb->query("
			SELECT DISTINCT(vwar".$n."_games.gameid), gamename, gameicon, gamenameshort
			FROM vwar".$n."_games, vwar".$n."_membergames
			WHERE vwar".$n."_membergames.gameid = vwar".$n."_games.gameid
			AND deleted = '0'
			ORDER BY gamename ASC
		");
		if ( $vwardb->num_rows($result) > 0 )
		{
			while ($row = $vwardb->fetch_array($result))
			{
				if($row['gameicon'] != "" && file_exists($vwar_root . "images/gameicons/".$row['gameicon']))
				{
					eval("\$gameiconbit2 .= \"".$vwartpl->get("gameiconbit2")."\";");
				} else {
					eval("\$gameiconbit2 .= \"".$vwartpl->get("gameiconbit2_nopic")."\";");
				}
			}
			$vwardb->free_result($result);

			eval("\$war_list_legend = \"".$vwartpl->get("war_list_legend")."\";");
		}
	}

	if ($formmailer == 1) eval("\$mailoption = \"".$vwartpl->get("member_list_mailoption")."\";");

	eval("\$vwartpl->output(\"".$vwartpl->get("member_list")."\");");

	$vwardb->free_result($result);
}

// ####################################### display member profile #################################
if ($GPC['action'] == "profile")
{
	//template-cache, standard-templates will be added by script:
	$vwartpllist  = "member_icqbit,member_mailbit,member_aimbit,member_yimbit,member_msnbit,member_homepagebit,";
	$vwartpllist .= "member_profile_fieldbit,member_profile_nonpublicfields,member_profile_storybit,gameiconbit,";
	$vwartpllist .= "member_profile_memberlocationcomment,member_profile_memberlocationpic,gameiconbit2,";
	$vwartpllist .= "member_profile_memberlocationnopic,war_list_legend,member_profile_memberlocationnone,member_profile";
	$vwartpl->cache($vwartpllist);

	include ( $vwar_root . "includes/get_header.php" );

	$row = $vwardb->query_first("
		SELECT * FROM
		vwar".$n."_member, vwar".$n."_memberstatus
		WHERE vwar".$n."_member.memberid = '".$GPC['memberid']."'
		AND status = statusid
	");
	dbSelect($row);

	$name = $row['name'];

	$member_mailbit = ifelse(strlen($row['email']) > 5, makelink("mailto:".encodeMail($row['email']), encodeMail($row['email'])), $str['NOTAVAILABLE']);
	$member_icqbit = ifelse($row['icq'], makelink("http://web.icq.com/whitepages/add_me/1,,,00.icq?uin=" . $row['icq'] . "&action=add", $row['icq']), $str['NOTAVAILABLE']);
	$member_aimbit = ifelse($row['aim'], makelink("aim:goim?screenname=" . $row['aim'] . "&message=Hello+Are+you+there?", $row['aim']), $str['NOTAVAILABLE']);
	$member_yimbit = ifelse($row['yim'], makelink("http://edit.yahoo.com/config/send_webmesg?.target=".$row['yim']."&.src=pg", $row['yim']), $str['NOTAVAILABLE']);
	$member_msnbit = ifelse($row['msn'], $row['msn'], $str['NOTAVAILABLE']);
	$member_xfirebit = ifelse($row['xfire'], $row['xfire'], $str['NOTAVAILABLE']);
	$member_xfirepicture = ifelse($row['xfire'], "<br />". makeimgtag("http://miniprofile.xfire.com/bg/co/type/0/".$row['xfire'].".png", $row['xfire']), "");
	
	if ((checkCookie() || (!checkCookie() && $formmailer == 1)) && (strlen($row['email']) > 5))
	{
		eval("\$member_formmailerbit = \"".$vwartpl->get("member_formmailerbit")."\";");
	}
	else
	{
		$member_formmailerbit = "";
	}

	$member_homepagebit = ifelse($row['homepage'] && $row['homepage'] != "http://", makelink(checkUrlFormat($row['homepage']), checkUrlFormat($row['homepage'])), $str['NOTAVAILABLE']);

	$memberstatus = $row['statusname'];
	$membername = $row['name'];
	$memberhits = $row['profilehits'];
	$realname = ifelse($row['realname'] != "", $row['realname'], $str['NOTAVAILABLE']);
	$location = ifelse($row['location'] !="", $row['location'], $str['NOTAVAILABLE']);
	$countrybit = ifelse($row['country'], makeimgtag($vwar_root . "images/flags/" . $row['country'] . ".gif", $country_array[$row['country']])."&nbsp;" . $country_array[$row['country']], $str['NOTAVAILABLE']);
	$sexbit = ifelse($row['sex'], makeimgtag($vwar_root . "images/" . $row['sex'] . ".gif", $sex_array[$row['sex']])."&nbsp;" . $sex_array[$row['sex']], $str['NOTAVAILABLE']);
	$wartagbit = ifelse($row['wartag'] != "", $row['wartag'], $str['NOTAVAILABLE']);
	###### code by kranker / wer user zuletzt online war
if($row["lastactivity"]==0){
$ShowLastOnline = "n/a";
}else{
$ShowLastOnline = formatdatetime($row["lastactivity"]);
}
###### code by kranker / wer user zuletzt online war ende  
	
	$birthdayarray = split("-", $row['birthday']);

	// german timeformat
	if ($row['birthday'] == '0000-00-00')
	{
		$birthday = $str['NOTAVAILABLE'];
		$age = "-";
	}
	else
	{
		$birthday = $birthdayarray[2] . "." . $birthdayarray[1] . "." . $birthdayarray[0];

		// calculate age (don't uses unix timestamp!!!)
		$age = date("Y") - $birthdayarray[0];

		if (($birthdayarray[1] > date("m")) || (($birthdayarray[1] == date("m")) && ($birthdayarray[2] > date("d")))) $age--;
	}
	$joindatearray = split("-", $row['joindate']);

        // german timeformat
        if ($row['joindate'] == '0000-00-00')
        {
                $joindate = $str['NOTAVAILABLE'];

        }
        else
        {
                $joindate = $joindatearray[2] . "." . $joindatearray[1] . "." . $joindatearray[0];
        }

	// set image path
	$imagepath = $vwar_root . "images/member/";

	if ($row['picture'])
	{
		if (@file_exists($imagepath . "th_". $row['picture']))
		{
			$memberpicture = makeimgtag($imagepath . "th_". $row['picture'], $row['name']);
			$memberpicture .= "<br>".makeimgtag($vwar_root . "images/button_enlarge.gif", $str['ENLARGE'])." ";
			$memberpicture .= popupwin("modules.php?name=$vwarmod&file=popup&action=memberpic&amp;memberid=" . $row['memberid'], "<small>" . $str['ENLARGE'] . "</small>");
		}
		else if (@file_exists($imagepath . $row['picture']))
		{
			$memberpicture = makeimgtag($imagepath . $row['picture'],$row['name'],""); //,$thumbnailwidth,$thumbnailheight);
		}
	}
	else if (@file_exists($vwar_root . "images/".$nomemberpic) && !empty($nomemberpic))
	{
		$memberpicture = makeimgtag($vwar_root . "images/" . $nomemberpic, $str['NOTAVAILABLE']);
	}
	else
	{
		$memberpicture = $str['PICTURE'] . "&nbsp;" . $str['NOTAVAILABLE'];
	}

	$row['customstatus'] = ifelse($row['customstatus'], "(" . $row['customstatus'] . ")");


	## --- do profile fields --- ##

	$cats = $vwardb->query("SELECT pcat_id, catname FROM vwar".$n."_pfield_cat ORDER BY displayorder ASC, catname ASC");

	// cache data
	$tmp = $vwardb->query("
		 SELECT fieldname, fieldvalue, smiliecode, htmlcode, bbcode, allowimages, public, cat_id, vwar".$n."_memberprofilefield.*
		 FROM vwar".$n."_profilefield
		 LEFT JOIN vwar".$n."_memberprofilefield
		 ON (vwar".$n."_profilefield.profilefieldid = vwar".$n."_memberprofilefield.profilefieldid
		 AND vwar".$n."_memberprofilefield.memberid = '".$GPC['memberid']."')
		 ORDER BY displayorder ASC, fieldname ASC");
		while($tmp2 = $vwardb->fetch_array($tmp))
		{
				$profilecache[$tmp2["cat_id"]][] = $tmp2;
		}
		$vwardb->free_result($tmp);
		unset($tmp2);

	while ($cat = $vwardb->fetch_array($cats))
	{
			$catid = $cat['pcat_id'];

			for($i = 0; $i < count($profilecache[$catid]); $i++)
			{
				$field = dbSelect($profilecache[$catid][$i]);
				switchColors();

				if ( $field["htmlcode"] == 1 )
				{
					$field["fieldvalue"] = rehtmlspecialchars($field["fieldvalue"]);
				}

				$fieldvalue = (!empty($field['fieldvalue']))
					? parseText($field['fieldvalue'], 1, $field["smiliecode"], 1, $field["bbcode"], 1, 0, $field["allowimages"])
					: $str['NOTAVAILABLE'];
				$fieldname  = $field['fieldname'];

				if ($field['public'] == 1 || ($field['public'] == 0 && checkCookie()))
				{
					eval("\$member_profile_fieldbits .= \"".$vwartpl->get("member_profile_fieldbit")."\";");
				}	else {
					$member_profile_fieldbits .= "";
				}
			}
			unset($i);
			unset($field);

		eval("\$member_profile_fieldtable .= \"".$vwartpl->get("member_profile_fieldtable")."\";");
		unset($member_profile_fieldbits);
	}
	$vwardb->free_result($fields);

	// ### do member statistics ###

	// get comments stats
	$result = $vwardb->query_first("
		SELECT COUNT(commentid) AS numcomments
		FROM vwar".$n."_comments
		WHERE frompage = 'war'
	");
	$totalcomments = $result['numcomments'];

	$result = $vwardb->query_first("
		SELECT COUNT(commentid) AS numcomments
		FROM vwar".$n."_comments
		WHERE frompage = 'war'
		AND memberid = '".$GPC['memberid']."'
	");
	$membercomments = $result['numcomments'];

	if ($totalcomments > 0 && $membercomments)
	{
		$membercomments_percent = round(($membercomments / $totalcomments) * 100,2);
	} else {
		$membercomments_percent = 0;
	}

	if ($membercomments > 0)
	{
		$result = $vwardb->query_first("
			SELECT vwar".$n."_comments.sourceid, vwar".$n."_comments.dateline, oppname
			FROM vwar".$n."_comments, vwar".$n.",vwar".$n."_opponents
			WHERE vwar".$n."_comments.sourceid = vwar".$n.".warid
			AND frompage='war'
			AND vwar".$n.".oppid = vwar".$n."_opponents.oppid
			AND vwar".$n."_comments.memberid = ".$GPC['memberid']."
			ORDER BY vwar".$n."_comments.dateline DESC
			LIMIT 0,1
		");
		$lastcomment = makelink("modules.php?name=$vwarmod&file=war&action=comment&amp;warid=" . $result['sourceid'] . "",$ownname . "&nbsp;vs.&nbsp;" . $result['oppname']);
		$lastdateline_comment = formatdatetime($result['dateline'], $longdateformat);

		$commentbar_width = ($membercomments / $totalcomments) * 100;
		$commentbar = makeimgtag($vwar_root . "images/bar_blue.gif", "", "", $commentbar_width, 5);
	}

	// get participant stats

	$result = $vwardb->query_first("
		SELECT COUNT(warid) AS numwars
		FROM vwar".$n."
	");
	$normalwars = $result['numwars'];
	$totalwars  = $normalwars + $deletedwars;

	$result = $vwardb->query_first("
		SELECT COUNT(partid) AS parts
		FROM vwar".$n."_participants
		WHERE memberid = '".$GPC['memberid']."'
	");
	$membersignups = $result['parts'];

	if ($totalwars > 0 && $membersignups)
	{
		$membersignups_percent = round(($membersignups/$totalwars) * 100,2);
	} else {
		$membersignups_percent = 0;
	}

	if ($membersignups > 0)
	{
		$result = $vwardb->query_first("
			SELECT vwar".$n."_participants.warid, vwar".$n."_participants.dateline, oppname, vwar".$n.".dateline AS wardateline
			FROM vwar".$n."_participants, vwar".$n.",vwar".$n."_opponents
			WHERE vwar".$n."_participants.warid = vwar".$n.".warid
			AND vwar".$n.".oppid = vwar".$n."_opponents.oppid
			AND vwar".$n."_participants.memberid = '".$GPC['memberid']."'
			ORDER BY vwar".$n."_participants.dateline DESC
			LIMIT 0,1
		");

		if ($result['wardateline'] > time() && $result['wardateline'])
		{
         $lastsignup = makelink("modules.php?name=$vwarmod&file=war&action=nextaction&formgame=#" . $result['warid'], $ownname . "&nbsp;vs.&nbsp;" . $result['oppname']);
      }
      else if ($result['wardateline'])
      {
         $lastsignup=makelink("modules.php?name=$vwarmod&file=war&action=details&amp;warid=" . $result['warid'], $ownname . "&nbsp;vs.&nbsp;" . $result['oppname']);
      }
		else if (!$result['wardateline'])
		{
			$lastsignup = "(" . $str['CANCELLED'] . ")";
		}
		$lastdateline_signup = formatdatetime($result['dateline'], $longdateformat);

		$signupbar_width = ($membersignups / $totalwars) * 100;
		$signupbar = makeimgtag($vwar_root . "images/bar_red.gif", "", "", $signupbar_width, 5);
	}

	// get comments stats
	$result = $vwardb->query_first("
		SELECT COUNT(commentid) AS numcomments
		FROM vwar".$n."_comments
		WHERE frompage = 'news'
	");
	$newstotalcomments = $result['numcomments'];

	$result = $vwardb->query_first("
		SELECT COUNT(commentid) AS numcomments
		FROM vwar".$n."_comments
		WHERE frompage = 'news'
		AND memberid = '".$GPC['memberid']."'
	");
	$newsmembercomments = $result['numcomments'];

	if ($newstotalcomments > 0 && $newsmembercomments)
	{
		$newsmembercomments_percent = round(($newsmembercomments/$newstotalcomments) * 100, 2);
	} else {
		$newsmembercomments_percent = 0;
	}

	if ($newsmembercomments > 0)
	{
		$result = $vwardb->query_first("
			SELECT
			vwar".$n."_comments.dateline,
			vwar".$n."_news.newsid, vwar".$n."_news.title
			FROM vwar".$n."_comments
			LEFT JOIN vwar".$n."_news ON (vwar".$n."_news.newsid = vwar".$n."_comments.sourceid)
			WHERE vwar".$n."_comments.frompage = 'news'
			AND vwar".$n."_comments.memberid = '".$GPC['memberid']."'
			ORDER BY vwar".$n."_comments.dateline DESC
		");
		$newslastcomment = makelink("modules.php?name=$vwarmod&action=comment&amp;newsid=" . $result['newsid'], $result['title']);
		$newslastdateline_comment = formatdatetime($result['dateline'], $longdateformat);

		$newscommentbar_width = ($newsmembercomments / $newstotalcomments) * 100;
		$newscommentbar = makeimgtag($vwar_root . "images/bar_blue.gif", "", "", $newscommentbar_width, 5);
	}

	// do legend, membergames and favorited locations

	$result = $vwardb->query_first("SELECT COUNT(membergamesid) AS numgames FROM vwar".$n."_membergames WHERE memberid='".$GPC['memberid']."'");
	$totalmembergames = $result['numgames'];
	$vwardb->free_result($result);

	// cache favorite locations...
	$result = $vwardb->query("
		SELECT locationname, locationpic, comment, gameid
		FROM vwar".$n."_locations, vwar".$n."_memberlocation
		WHERE vwar".$n."_memberlocation.locationid = vwar".$n."_locations.locationid
			AND memberid = '".$GPC['memberid']."'
			AND deleted = '0'
		ORDER BY locationname
	");
	while ( $row = $vwardb->fetch_array($result) )
	{
		$favlocations[$row["gameid"]][] = $row;
	}

	if ($totalmembergames > 0)
	{
		$result = $vwardb->query("
			SELECT gameicon, gamename, gamenameshort, vwar".$n."_games.gameid
			FROM vwar".$n."_membergames, vwar".$n."_games
			WHERE vwar".$n."_membergames.memberid = '".$GPC['memberid']."'
			AND vwar".$n."_membergames.gameid = vwar".$n."_games.gameid
			AND deleted = '0'
			ORDER BY gamename ASC
		");
		while ($row = $vwardb->fetch_array($result))
		{
			if ($row['gameicon'] != "" && file_exists($vwar_root . "images/gameicons/".$row['gameicon']))
			{
				eval("\$games .= \"".$vwartpl->get("gameiconbit")."\";");
				eval("\$gameiconbit2 .= \"".$vwartpl->get("gameiconbit2")."\";");
				eval("\$games5 = \"".$vwartpl->get("gameiconbit")."\";");
			}
			else
			{
				eval("\$games .= \"".$vwartpl->get("gameiconbit_nopic")."\";");
				eval("\$gameiconbit2 .= \"".$vwartpl->get("gameiconbit2_nopic")."\";");
				eval("\$games5 = \"".$vwartpl->get("gameiconbit_nopic")."\";");
			}

			if (count($favlocations[$row["gameid"]]) > 0)
			{
				//there are some favorited locations for this game, so we display them:
				$favs = true;

				switchColors();

				$linecounter = 0;
				$member_profile_memberlocationpic = "";

				foreach ( $favlocations[$row["gameid"]] AS $gameid => $row2 )
				{
					$linecounter++;
					$linecheck = $linecounter % $favperline;

					$member_profile_memberlocationpic .= ifelse($linecheck==1 || $linecounter == 1, "\t\t\t\t<tr>");

					$locationname = $row2['locationname'];

					if ($row2['comment'] != "")
					{
						$comment = parseText($row2['comment'],1);

						eval ("\$locationname .= \"".$vwartpl->get("member_profile_memberlocationcomment")."\";");
					}

					if (!empty($row2['locationpic']) && @file_exists($vwar_root . "images/locations/" . $row2['locationpic']))
					{
						eval ("\$member_profile_memberlocationpic .= \"".$vwartpl->get("member_profile_memberlocationpic")."\";");
					}
					else if (@file_exists($vwar_root . "images/locations/" . $row2['locationname']))
					{
						$row2['locationpic'] = $row2['locationname'];

						eval ("\$member_profile_memberlocationpic .= \"".$vwartpl->get("member_profile_memberlocationpic")."\";");
					}
					else
					{
						eval ("\$member_profile_memberlocationpic .= \"".$vwartpl->get("member_profile_memberlocationnopic")."\";");
					}

					$member_profile_memberlocationpic .= ifelse($linecheck == 0 || $linecounter == $numfavs, "</tr>\n");
				}

				eval ("\$member_profile_memberlocation .= \"".$vwartpl->get("member_profile_memberlocation")."\";");

				unset($member_profile_memberlocationpic);
			}
			$vwardb->free_result($result2);
		}
		$vwardb->free_result($result);

		if ($showlegend == 1) eval("\$legend = \"".$vwartpl->get("war_list_legend")."\";");
	}
	else
	{
		$games = $str['NOTAVAILABLE'];
	}

	//favorited locations: if there are no membergames or no fav. locations, we display the n/a-message
	if ($games == $strNotavailable || !$favs)
	{
		eval ("\$member_profile_memberlocation = \"".$vwartpl->get("member_profile_memberlocationnone")."\";");
	}

	eval("\$vwartpl->output(\"".$vwartpl->get("member_profile")."\");");
}

// #################################### member guestbook ################################
if ($GPC['action'] == "gb")
{
	// create vars (only if comment-action != delete)
	if ($GPC['cmd'] != "delete" && $command != "delete")
	{
		$result = $vwardb->query_first("
			SELECT name
			FROM vwar".$n."_member
			WHERE memberid = '".$GPC['memberid']."'
		");
		$membername = dbSelect($result['name']);

		eval("\$commenttitle = \"".$vwartpl->get("comment_display_commenttitle_member")."\";");

		$returntitle = $str['PROFILEOF'] . "&nbsp;" . $membername;
		$returnurl   = "modules.php?name=$vwarmod&file=member&action=profile&amp;memberid=" . $GPC['memberid'];
	}

	// params
	$comments = array (
		"sourceid"	=> $GPC['memberid'],
		"frompage"	=> "member",
		"title"		=> "Member",
		"commenttitle"	=> $commenttitle,
		"returntitle"	=> $returntitle,
		"returnurl"	=> $returnurl
	);
	// load engine
	include("includes/functions_comments.php");
}

// ####################################### formmailer ###################################
if (($GPC['action'] == "mail" || $display == "mail"))
{
	if (!checkCookie() && $formmailer == 0)
	{
		$vwartpl->cache ( "message_error_formmailer" );
		include ( $vwar_root . "includes/get_header.php" );
		eval ("\$vwartpl->output(\"" . $vwartpl->get("message_error_nopermission") . "\");");
		include ( $vwar_root . "includes/get_footer.php" );
		exit();
	}

	if ($GPC['add'] || $GPC['add_x'])
	{
		// check for wrong data
		if (!is_numeric($to) || (!($ismember = checkCookie()) && !checkMail($frommail)) || empty($mailtext))
		{
			$vwartpl->cache ( "message_error_formmailer" );
			include ( $vwar_root . "includes/get_header.php" );
			eval ("\$vwartpl->output(\"" . $vwartpl->get("message_error_formmailer") . "\");");
			include ( $vwar_root . "includes/get_footer.php" );
			exit();
		}

		//member sends mail
		if( $ismember == true)
		{
			$member = $vwardb->query_first("
				SELECT email,name
				FROM vwar".$n."_member
				WHERE memberid = '".$GPC['vwarid']."'
			");
			dbSelect($member);

			$fromname = $member['name'];
			$frommail = $member['email'];
		}

		$member = $vwardb->query_first("SELECT name,email FROM vwar".$n."_member WHERE memberid = '$to'");
		dbSelect($member, 0, 0, 0);

		$fromname = (!$GPC["fromname"]) ? $GPC["frommail"] : strip_slashes($GPC["fromname"]);

		sendMail(strip_slashes($mailtext), $member['email'], $member['name'], $frommail, $fromname, strip_slashes($subject), $format, $priority);

		$vwartpl->cache ( "message_confirmation" );
		include ( $vwar_root . "includes/get_header.php" );
		$redirecturl = "modules.php?name=$vwarmod&file=member";
		eval ("\$vwartpl->output(\"" . $vwartpl->get("message_confirmation") . "\");");
		include ( $vwar_root . "includes/get_footer.php" );
		exit();
	}

	//template-cache, standard-templates will be added by script:
	$vwartpllist="quickjump,member_formmailer_select,member_formmailer,member_formmailer_guest,member_formmailer_member,";
	$vwartpllist.="smiliesoff,smilieson,htmlcodeon,htmlcodeoff,bbcodeon,bbcodeoff,bbcode_language,bbcode_javascript,bbcode";
	$vwartpl->cache($vwartpllist);

	include ( $vwar_root . "includes/get_header.php" );

	$quickjump = loadQuickjump($GPC["PURE_PHP_SELF"]);

	//memberselect
	$result = $vwardb->query("SELECT statusid FROM vwar".$n."_memberstatus ORDER BY displayorder ASC");
	while ($row = $vwardb->fetch_array($result))
	{
		$i++;

		$memberstatuslist[$i] = $row['statusid'];
	}
	$vwardb->free_result($result);

	while (list($key,$id) = each($memberstatuslist))
	{
		$result = $vwardb->query("
			SELECT name, memberid
			FROM vwar".$n."_member
			WHERE status = '$id'
				AND email != ''
				AND hidemember != '1'
				AND ismember = '1'
			$andclause
			ORDER BY name
		");

		if ($vwardb->num_rows($result) == 0) continue;

		$member_select .= ifelse($run != 0, "\t\t\t\t<option value=\"0\">-----------------</option>\r\n");

		$run=1;

		while ($row = $vwardb->fetch_array($result))
		{
			$nummember = true;

			$selected['member'] = ifelse(($GPC['memberid'] == $row['memberid'] && !$GPC['to']) || $GPC['to'] == $row['memberid'], "selected");

			eval ("\$member_select .= \"".$vwartpl->get("member_formmailer_select")."\r\n\";");

			unset($selected);
		}
		$vwardb->free_result($result);
	}

	// strip slashes
	if (isset($GPC['format']))
	{
		dbSelectForm($GPC, 1);
	}

	//priority
	$priority = ( isset($GPC["priority"]) ) ? $GPC["priority"] : 3;
	$selected[$priority] = "selected";

	//format
	if ($GPC['format'] == "html")
	{
		$selected['format'] = "selected";
		getTextRestrictions("mailform","mailtext","{secondaltcolor}",1);
	}
	else
	{
		$nextcolor[1] = "{secondaltcolor}";
	}

	//member or guest
	if (checkCookie())
	{
		$member = $vwardb->query_first("
			SELECT email, name
			FROM vwar".$n."_member
			WHERE memberid = '".$GPC['vwarid']."'
		");

		eval("\$senderoption = \"".$vwartpl->get("member_formmailer_member")."\";");
	}
	else
	{
		eval("\$senderoption = \"".$vwartpl->get("member_formmailer_guest")."\";");
	}

	//output
	$select['mail'] = "selected";

	if ($formmailer == 1) eval("\$mailoption = \"".$vwartpl->get("member_list_mailoption")."\";");

	eval("\$vwartpl->output(\"".$vwartpl->get("member_formmailer")."\");");
}

// ################################### profilehits hack by tHecAsE  ####################################
if ($GPC['action'] == "profilehits")
{

    // Update Hits counter
    $result=$vwardb->query("
        UPDATE vwar".$n."_member
        SET
        profilehits  = profilehits  + 1
        WHERE memberid = '".$GPC["memberid"]."'
    ");
    $vwardb->free_result($result);

  Header("Location: modules.php?name=$vwarmod&file=member&action=profile&memberid=".$GPC["memberid"]);
}
//profilehit hack

include ($vwar_root . "includes/get_footer.php");
?>
