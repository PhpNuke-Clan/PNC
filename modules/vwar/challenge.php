<?php
/* #####################################################################################
 *
 * $Id: challenge.php,v 1.51 2004/09/08 17:54:30 mabu Exp $
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

// check if disabled
if ($challengeenabled == 0)
{
	$vwartpl->cache ( "message_functiondisabled" );
	include ( $vwar_root . "includes/get_header.php" );
	eval ("\$vwartpl->output(\"" . $vwartpl->get("message_functiondisabled") . "\");");
	include ( $vwar_root . "includes/get_footer.php" );
	exit();
}

// do the quickjump
doQuickjump($GPC['quickjumptarget']);

// ################################### challenge form  #################################
if ($GPC['action'] == "" || !isset($GPC['action']))
{

	$warlocation = $GPC['warlocation'];

	if ($GPC['add'] || $GPC['add_x'])
	{

		$vwartpl->cache("message_mail_challenge,message_confirmation");

		$locations = implode("||",$warlocation);

		if ($GPC['contacthomepage'])
		{
			$contacthomepage = checkUrlFormat($GPC['contacthomepage']);
		}

		list ($hour,$minute) = split("[:]", $GPC['wartime']);
		$dateline = mktime( $hour, $minute, 0, $GPC['month'], $GPC['day'], $GPC['year']);

		$vwardb->query("
			INSERT INTO vwar".$n."_challenge
			(matchtypeid,teamname,teamnameshort,gameid,gametypeid,contactname,contactemail,contacticq,contactaim,contactyim,contactmsn,
			contactircnetwork,contactircchannel,contacthomepage,playerperteam,locations,challengeinfo,dateline)
			VALUES
			('".$GPC['matchtypeid']."',  '".$GPC['teamname']."',  '".$GPC['teamnameshort']."', '".$GPC['gameid']."',
			'".$GPC['gametypeid']."', '".$GPC['contactname']."', '".$GPC['contactemail']."',
			'".$GPC['contacticq']."', '".$GPC['contactaim']."', '".$GPC['contactyim']."', '".$GPC['contactmsn']."',
			'".$GPC['contactircnetwork']."', '".$GPC['contactircchannel']."', '$contacthomepage', '".$GPC['playerperteam']."',
			'$locations', '".$GPC['warinfo']."', '$dateline')
		");

		// db transaction is done, we can strip the slashes
		strip_slashes ($GPC);

		$result = $vwardb->query_first("SELECT gamename FROM vwar".$n."_games WHERE gameid = '".$GPC['gameid']."'");
		$gamename = $result['gamename'];

		$result = $vwardb->query_first("SELECT gametypename FROM vwar".$n."_gametype WHERE gametypeid = '".$GPC['gametypeid']."'");
		$gametype = $result['gametypename'];

		$result = $vwardb->query_first("SELECT matchtypename FROM vwar".$n."_matchtype WHERE matchtypeid = '".$GPC['matchtypeid']."'");
		$matchtype = $result['matchtypename'];

		$date = formatdatetime($dateline);

		eval("\$content = \"".$vwartpl->get("message_mail_challenge")."\";");

		$result = $vwardb->query("
			SELECT name, email
			FROM vwar".$n."_member, vwar".$n."_accessgroup
			WHERE ismember = '1'
			AND (canaddwar = '1' OR isadmin = '1')
			AND vwar".$n."_member.accessgroupid = vwar".$n."_accessgroup.accessgroupid
		");
		while ($row = $vwardb->fetch_array($result))
		{
			dbSelect($row);
			sendMail($content, $row['email'], $row['name'], "", "", "Virtual War Challenge", 0);
		}

		$vwartpl->cache ( "message_confirmation" );
		include ( $vwar_root . "includes/get_header.php" );
		$redirecturl = "modules.php?name=$vwarmod";
		eval ("\$vwartpl->output(\"" . $vwartpl->get("message_confirmation") . "\");");
		include ( $vwar_root . "includes/get_footer.php" );
		exit();

	}
	else
	{

		//template-cache, standard-templates will be added by script:
		$vwartpllist = "quickjump,message_mail_challenge,selectbitdefault,gameselectbit2,gameselectbit,";
		$vwartpllist.= "gametypeselectbit,gametypeselectbit2,matchtypeselectbit,matchtypeselectbit2,locationselectbit,";
		$vwartpllist.= "locationselectbit2,locationselect,challenge,smiliesoff,smilieson,htmlcodeon,htmlcodeoff,bbcodeon,";
		$vwartpllist.= "bbcodeoff,bbcode_language,bbcode_javascript,bbcode";
		$vwartpl->cache($vwartpllist);

		$quickjump = loadQuickjump($GPC["PURE_PHP_SELF"]);

		$monthselected[$GPC['month']] = ifelse(isset($GPC['month']), "selected");
		$dayselected[$GPC['day']] 		= ifelse(isset($GPC['day']), "selected");

		eval ("\$gameselectbit = \"".$vwartpl->get("selectbitdefault")."\";");
		$result = $vwardb->query("
			SELECT * FROM vwar".$n."_games WHERE deleted = '0'
			ORDER BY gamename ASC
		");
		while ($game = $vwardb->fetch_array($result))
		{

			$gameid		=	$game['gameid'];
			$gamename	=	$game['gamename'];

			$num			=	$vwardb->query_first("
				SELECT COUNT(locationid) AS numloc FROM vwar".$n."_locations
				WHERE gameid = '".$game['gameid']."'
			");
			if ($num['numloc'] > 0)
			{
				eval("\$gameselectbit .= \"".$vwartpl->get(ifelse($gameid == $GPC['gameid'], "gameselectbit2", "gameselectbit"))."\";");
			}
		}

		eval ("\$gametypeselectbit = \"".$vwartpl->get("selectbitdefault")."\";");
		$result = $vwardb->query("
			SELECT gametypeid, gametypename
			FROM vwar".$n."_gametype
			WHERE deleted = '0'
			ORDER BY gametypename ASC
		 ");
		while ($row = $vwardb->fetch_array($result))
		{

			$gametypeid		=	$row['gametypeid'];
			$gametypename	=	$row['gametypename'];

			eval("\$gametypeselectbit .= \"".$vwartpl->get(ifelse($GPC['gametypeid'] == $gametypeid, "gametypeselectbit2", "gametypeselectbit"))."\";");
		}

		eval ("\$matchtypeselectbit = \"".$vwartpl->get("selectbitdefault")."\";");
		$result=$vwardb->query("
			SELECT matchtypeid, matchtypename
			FROM vwar".$n."_matchtype
			WHERE deleted = '0'
			" . getPublicMatchtypes(1,0,2) . "
			ORDER BY matchtypename ASC
		");
		while ($row = $vwardb->fetch_array($result)) {

			$matchtypeid		=	$row['matchtypeid'];
			$matchtypename	=	$row['matchtypename'];

			eval("\$matchtypeselectbit .= \"".$vwartpl->get(ifelse($GPC['matchtypeid'] == $matchtypeid, "matchtypeselectbit2", "matchtypeselectbit"))."\";");
		}

		// do location select
		for ($i = 0; $i <= sizeof($locationid); $i++)
		{

			$locationnumber = $i+1;

			eval ("\$locationselectbit = \"".$vwartpl->get("selectbitdefault")."\";");
			$result = $vwardb->query("
				SELECT * FROM vwar".$n."_locations
				WHERE deleted = '0'
				AND gameid = '".$GPC['gameid']."'
				ORDER by locationname ASC
			");
			while ($row = $vwardb->fetch_array($result))
			{
				eval("\$locationselectbit .= \"".$vwartpl->get(ifelse($warlocation[$locationnumber] == $row['locationid'], "locationselectbit2", "locationselectbit"))."\";");

				if ($warlocation[$locationnumber] != "")
				{
					$locationid[$locationnumber] = $locationid;
				}
			}

			if ($warlocation[$locationnumber] != "" || $locationnumber == 1 || $warlocation[$locationnumber-1] != "")
			{
				switchColors();
				eval("\$locationselect .= \"".$vwartpl->get("locationselect")."\";");
			}
		}

		getTextRestrictions("vwarform","warinfo","{firstaltcolor}",1);

		include ( $vwar_root . "includes/get_header.php" );
		eval("\$vwartpl->output(\"".$vwartpl->get("challenge")."\");");
	}
}

include ($vwar_root . "includes/get_footer.php");
?>