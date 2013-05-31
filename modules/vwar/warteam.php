<?php


// get functions
$module_name = basename(dirname(__FILE__));
$vwar_root = "modules/" . basename(dirname(__FILE__)) ."/";
$vwar_file = "warteam";
require($vwar_root . "modname.php");

###############################
##          Setting          ##
##                           ##
   $nummatchwheregame = "10";
##                           ##
###############################

require ($vwar_root . "includes/functions_common.php");
require ($vwar_root . "includes/functions_front.php");

// do the quickjump
doQuickjump($GPC['quickjumptarget']);

################################################################################ wars by teams
if ($GPC["action"] == "")
{
$quickjump = loadQuickjump($GPC["PURE_PHP_SELF"]);
     $vwartpllist = "warteam2_table,war_listbit,warteam2_list";
     $vwartpl->cache($vwartpllist);
     include ( $vwar_root . "includes/get_header.php" );

$result = $vwardb->query_first("
        SELECT COUNT(warid) AS numwars
        FROM vwar".$n."
        WHERE status = '1'
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
		$result1 = $vwardb->query("
			SELECT warid, resultbylocations
			FROM vwar".$n.", vwar".$n."_matchtype
			WHERE vwar".$n.".matchtypeid = vwar".$n."_matchtype.matchtypeid
			AND status = '1'");
		while ($row = $vwardb->fetch_array($result1))
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
		$vwardb->free_result($result1);


   $result = $vwardb->query("SELECT * FROM vwar".$n."_games WHERE deleted = '0'");
        while ($game = $vwardb->fetch_array($result))
        {

      $result0 = $vwardb->query("
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
			vwar".$n."_opponents.oppid,oppname,oppnameshort,oppcountry
			FROM vwar".$n."
			LEFT JOIN vwar".$n."_opponents ON (vwar".$n.".oppid = vwar".$n."_opponents.oppid)
			LEFT JOIN vwar".$n."_matchtype ON (vwar".$n.".matchtypeid = vwar".$n."_matchtype.matchtypeid)
			LEFT JOIN vwar".$n."_gametype ON (vwar".$n.".gametypeid = vwar".$n."_gametype.gametypeid)
			WHERE status = '1' and gameid = " . $game["gameid"] . " ORDER BY vwar".$n.".dateline DESC
	 LIMIT 0, $nummatchwheregame");
while ($row = $vwardb->fetch_array($result0))
        {
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
			$gamenameteam = "<normalfont>". $game["gamename"]."</normalfont>";
			$gamepicture	=		$game["gameicon"];
			if ($game["gameicon"]==""){
			$gameiconbit = $gamenameteam;
			}
			else{
			$gameiconbit = "<img src=\"modules/$vwarmod/images/gameicons/$gamepicture\">";
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



     $gamematch = $vwardb->query_first("SELECT COUNT(warid) AS nummatch  FROM vwar".$n."

        WHERE status = '1' and gameid = '".$game['gameid']."'");
        $matchgames = $gamematch['nummatch'];

       eval ("\$warteam2_table .= \"".$vwartpl->get("warteam2_table")."\";");
     	unset($war_listbit);





  }
    eval("\$vwartpl->output(\"".$vwartpl->get("warteam2_list")."\");");


}
include ($vwar_root . "includes/get_footer.php");
?>