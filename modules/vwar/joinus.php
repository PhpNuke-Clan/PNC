<?php
/* #####################################################################################
 *
 * $Id: joinus.php,v 1.45 2004/02/21 18:17:54 mabu Exp $
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

// check if disabled
if ($joinenabled == 0)
{
	$vwartpl->cache ( "message_functiondisabled" );
	include ( $vwar_root . "includes/get_header.php" );
	eval ("\$vwartpl->output(\"" . $vwartpl->get("message_functiondisabled") . "\");");
	include ( $vwar_root . "includes/get_footer.php" );
	exit();
}

// ################################### join form  ######################################
if ($GPC['action']=="" || !isset($GPC['action']))
{
	if ($GPC['add'] || $GPC['add_x'])
	{
	//start join limit age
	 $joinagelimit = date("Y") - $age_limit; 
  
  if ($joinagelimit < $GPC['year']){
 	include ( $vwar_root . "includes/get_header.php" ); 
	eval ("\$vwartpl->output(\"" . $vwartpl->get("message_joinusagelimit") . "\");");
	include ( $vwar_root . "includes/get_footer.php" );
	exit();  
  }
  //end limit age
  global $user;
cookiedecode($user);
$nukename = $cookie[1];	
if(!$cookie[1]){ $nukename = "Guest";}
		$vwartpl->cache("message_mail_joinus,message_confirmation");

		$vwardb->query("
			INSERT INTO vwar".$n."_join
			(gameid, gametypeid, contactname, contactemail, contacticq, contactaim, contactyim, contactmsn, contactxfire,
			 contactircnetwork, contactircchannel, contactlocation, contactcountry, contactbirthday, joininfo, 
			 dateline, nukename, ip)
			VALUES
			('".$GPC['gameid']."', '".$GPC['gametypeid']."', '".$GPC['contactname']."', '".$GPC['contactemail']."',
			 '".$GPC['contacticq']."', '".$GPC['contactaim']."', '".$GPC['contactyim']."', '".$GPC['contactmsn']."', '".$GPC['contactxfire']."',
			 '".$GPC['contactircnetwork']."', '".$GPC['contactircchannel']."', '".$GPC['contactlocation']."',
			 '".$GPC['contactcountry']."', '".$GPC['year']."-".$GPC['month']."-".$GPC['day']."', '".$GPC['warinfo']."',
			 '".time()."','".$nukename."','".$_SERVER["REMOTE_ADDR"]."')
		");

		// db transaction is done, we can strip the slashes
		strip_slashes ($GPC);

		$result = $vwardb->query_first("SELECT gamename FROM vwar".$n."_games WHERE gameid = '".$GPC['gameid']."'");
		$gamename = $result['gamename'];

		$result = $vwardb->query_first("SELECT gametypename FROM vwar".$n."_gametype WHERE gametypeid = '".$GPC['gametypeid']."'");
		$gametype = $result['gametypename'];

		$birthday = mktime(0,0,0,$GPC['month'],$GPC['day'],$GPC['year']);
		$birthday = formatdatetime($birthday,$shortdateformat,1);
		$contactcountry = $country_array[$GPC['contactcountry']];

		eval("\$content = \"".$vwartpl->get("message_mail_joinus")."\";");

		$result = $vwardb->query("
			SELECT name, email
			FROM vwar".$n."_member, vwar".$n."_accessgroup
			WHERE ismember = '1'
			AND (canaddmember = '1' OR isadmin = '1')
			AND vwar".$n."_member.accessgroupid = vwar".$n."_accessgroup.accessgroupid
		");
		while ($row = $vwardb->fetch_array($result))
		{
			dbSelect($row);
			sendMail($content, $row['email'], $row['name'], "", "", "Virtual War JoinUs", 0);
		}
		$vwardb->free_result($result);

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
		$vwartpllist="quickjump,message_mail_joinus,selectbitdefault,gametypeselectbit,gameselectbit,";
		$vwartpllist.="countryselectbit,smilieson,smiliesoff,htmlcodeon,htmlcodeoff,bbcodeoff,";
		$vwartpllist.="bbcodeon,joinus,bbcode_language,bbcode_javascript,bbcode";
		$vwartpl->cache($vwartpllist);

		$quickjump = loadQuickjump($GPC["PURE_PHP_SELF"]);

		eval ("\$gameselectbit = \"".$vwartpl->get("selectbitdefault")."\";");
		$result = $vwardb->query("SELECT * FROM vwar".$n."_games WHERE deleted = '0' ORDER BY gamename ASC");
		while ($game = $vwardb->fetch_array($result))
		{
			$gameid = $game['gameid'];
			$gamename = $game['gamename'];
			eval("\$gameselectbit .= \"".$vwartpl->get("gameselectbit")."\";");
		}

		eval ("\$gametypeselectbit = \"".$vwartpl->get("selectbitdefault")."\";");
		$result = $vwardb->query("
			SELECT gametypeid,gametypename FROM vwar".$n."_gametype
			WHERE deleted = '0' ORDER BY gametypename ASC
		");
		while ($row = $vwardb->fetch_array($result))
		{
			$gametypeid = $row['gametypeid'];
			$gametypename = $row['gametypename'];
			eval ("\$gametypeselectbit .= \"".$vwartpl->get("gametypeselectbit")."\";");
		}

		eval ("\$countryselectbits = \"".$vwartpl->get("selectbitdefault")."\";");
		while (list($countrycode, $countryname) = each($country_array))
		{
			eval ("\$countryselectbits .= \"".$vwartpl->get("countryselectbit")."\";");
		}

		getTextRestrictions("vwarform","warinfo","{firstaltcolor}",1);

		include ( $vwar_root . "includes/get_header.php" );
		eval("\$vwartpl->output(\"".$vwartpl->get("joinus")."\");");
	}
}

include ($vwar_root . "includes/get_footer.php");
?>