<?php
/* #####################################################################################
 *
 * $Id: functions_common.php,v 1.75 2004/09/09 15:52:33 rob Exp $
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

/*
 * ------------------------------------------------------------------------------------
 * includes/functions_common.php
 * ------------------------------------------------------------------------------------
 * common functions
*/

## -------------------------------------------------------------------------------------------------------------- ##
if(eregi("functions_common.php", $_SERVER["PHP_SELF"]) || eregi("functions_common.php", $HTTP_SERVER_VARS["PHP_SELF"])) die("Access denied!");
if( !defined('VWAR_INCLUDE')){
die("Access denied!");
}
// set the constant...
define ("VWAR_COMMON_INCLUDED", 1);
// start time for buildup-report:
if ( !isset ($startrendertime) )
{
	$startrendertime = microtime();
}

// set error reporting
error_reporting(E_ALL & ~E_NOTICE);

// we don't need them
set_magic_quotes_runtime(0);

// developement modus
$devmode = 0;

## -------------------------------------------------------------------------------------------------------------- ##

// get php version
$phpversion_array = phpversion();
$phpversion_nr    = $phpversion_array[0] . "." . $phpversion_array[2] . "." . $phpversion_array[4];

## -------------------------------------------------------------------------------------------------------------- ##

// get config


include($vwar_root2 . "includes/_config.inc.php");


## -------------------------------------------------------------------------------------------------------------- ##

// get db class and connect to database
if (!class_exists("vwardb"))
{
	include_once($vwar_root . "includes/classes/class_db.php");
	$vwardb = new vwardb($sql['hostname'], $sql['username'], $sql['password'], $sql['database']);
}

## -------------------------------------------------------------------------------------------------------------- ##

// get template class
if (!class_exists("vwartpl"))
{
	include_once($vwar_root . "includes/classes/class_template.php");
	$vwartpl = new vwartpl;
}

## -------------------------------------------------------------------------------------------------------------- ##

// read configuration data
$row = $vwardb->query_first("SELECT * FROM vwar".$n."_settings");
while (list($key,$value) = each($row))
{
    $$key = dbSelect ($value, 0, 0);
}
$textwon   = rehtmlspecialchars ($textwon);
$textlost  = rehtmlspecialchars ($textlost);
$textdraw  = rehtmlspecialchars ($textdraw);
$urltovwar = checkPath ($urltovwar);

## -------------------------------------------------------------------------------------------------------------- ##

// we save all incoming $HTTP_*_VARS or $_* in the $GPC array
// 'magic_quotes_gpc = off' is overwritten for all vars
if ( !defined("VWAR_GLOBALS_GRABBED") )
{
	$GPC = array();

	// only do it once!
	define("VWAR_GLOBALS_GRABBED", 1);

	$magic_quotes = get_magic_quotes_gpc();

	function checkValue ($arg)
	{
		global $magic_quotes;

		if (is_string($arg))
		{

			$arg = ( $magic_quotes ) ? $arg : addslashes($arg);
			$arg = rehtmlspecialchars(htmlspecialchars($arg));

		}
		else
		{
			foreach ($arg AS $key => $value)
			{
				$arg[$key] = checkValue($value);
			}
		}
		return $arg;
	}

function regGlobals ($array, &$target_array)
{
 reset($array);

 // get the vars out of the get-, post- or cookie-arrays
 foreach ($array AS $key => $value)
 {
  global ${$key};

  if ($key != "vwar_root2" && $key != "userlanguage"){
   // we don't register arrays with more than one dimension,
   // we only add slashes if required and use rehtmlspecialchars()
   $value              = checkValue($value);
   ${$key}             = $value;
   $target_array[$key] = $value;
  }
 }
 return true;
}
/* Old
	function regGlobals ($array, &$target_array)
	{
		reset($array);

		// get the vars out of the get-, post- or cookie-arrays
		foreach ($array AS $key => $value)
		{
			global ${$key};

			// we don't register arrays with more than one dimension,
			// we only add slashes if required and use rehtmlspecialchars()
			$value              = checkValue($value);
			${$key}             = $value;
			$target_array[$key] = $value;
		}
		return true;
	}
	*/

	if (!empty($_GET)) {
		regGlobals($_GET, $GPC);
	} else if (!empty($HTTP_GET_VARS)) {
		regGlobals($HTTP_GET_VARS, $GPC);
	}

	if (!empty($_POST)) {
		regGlobals($_POST, $GPC);
	} else if (!empty($HTTP_POST_VARS)) {
		regGlobals($HTTP_POST_VARS, $GPC);
	}

	if (!empty($_COOKIE)) {
		regGlobals($_COOKIE, $GPC);
	} else if (!empty($HTTP_COOKIE_VARS)) {
		regGlobals($HTTP_COOKIE_VARS, $GPC);
	}

	if (!empty($_SERVER)) {
		$GPC["PHP_SELF"] = $_SERVER["PHP_SELF"];
		$GPC["PURE_PHP_SELF"] = basename($_SERVER["PHP_SELF"]);
		$GPC["QUERY_STRING"] = $_SERVER["QUERY_STRING"];
		$GPC["HTTP_USER_AGENT"] = $_SERVER["HTTP_USER_AGENT"];
		$GPC["HTTP_ACCEPT_ENCODING"] = $_SERVER["HTTP_ACCEPT_ENCODING"];
	} else if (!empty($HTTP_SERVER_VARS)) {
		$GPC["PHP_SELF"] = $HTTP_SERVER_VARS["PHP_SELF"];
		$GPC["PURE_PHP_SELF"] = basename($HTTP_SERVER_VARS["PHP_SELF"]);
		$GPC["QUERY_STRING"] = $HTTP_SERVER_VARS["QUERY_STRING"];
		$GPC["HTTP_USER_AGENT"] = $HTTP_SERVER_VARS["HTTP_USER_AGENT"];
		$GPC["HTTP_ACCEPT_ENCODING"] = $HTTP_SERVER_VARS["HTTP_ACCEPT_ENCODING"];
	}
}

// set cookie values to their real values
$GPC['vwarid']          = $GPC[$n . 'vwarid'];
$GPC['vwarpassword'] 	= $GPC[$n . 'vwarpassword'];
$GPC['vwarlanguage'] 	= $GPC[$n . 'vwarlanguage'];

## -------------------------------------------------------------------------------------------------------------- ##

// last activity
if ($whoisonline == 1 && !empty($GPC['vwarid']) && !defined("VWAR_LAST_ACTIVITY"))
{
	define("VWAR_LAST_ACTIVITY", 1);
	$vwardb->query("UPDATE vwar".$n."_member SET lastactivity = '".time()."' WHERE memberid = '".$GPC['vwarid']."'");
}

## -------------------------------------------------------------------------------------------------------------- ##
##	FUNCTIONS
## -------------------------------------------------------------------------------------------------------------- ##
function checkCookie()
{
	global $vwardb, $n, $GPC, $vwar_memberinfo;

	$check_id   = $n . "vwarid";
	$check_pass = $n . "vwarpassword";

	if ( !isset($vwar_memberinfo) )
	{
		$result = $vwardb->query("
			SELECT memberid, ismember, password
			FROM vwar".$n."_member
			WHERE memberid = '".$GPC[$check_id]."'
		");
		$vwar_memberinfo = $vwardb->fetch_array($result);
	}

	//return ifelse($vwar_memberinfo['memberid'] && $vwar_memberinfo['ismember'] == 1 && $vwar_memberinfo['password'] == $GPC[$check_pass], true, false);
	return ifelse($vwar_memberinfo['memberid'] && $vwar_memberinfo['ismember'] == 1 && md5($vwar_memberinfo['password']) == $GPC[$check_pass], true, false);
}
## -------------------------------------------------------------------------------------------------------------- ##
function SetVWarCookie($name, $value, $delete = 0)
{
	global $cookiedomain, $n, $cookiepath;

	// cookie expires in 1 year
	if ($delete == 1)
	{
		$expire = time() - (3600 * 24 * 365);
	} else {
		$expire = time() + (3600 * 24 * 365);
	}

	// set global cookie, if path is empty
	if (empty($cookiepath))
	{
		$cookiepath = "/";
	}

	// set the cookie
	SetCookie( $n . $name, $value, $expire, $cookiepath,  $cookiedomain );

	return;
}
## -------------------------------------------------------------------------------------------------------------- ##
function formatdatetime($time,$dateformat="",$dontconvert=0)
{
	global $longdateformat,$timezoneoffset,$timeformat;

	if (!is_numeric($timezoneoffset)) $timezoneoffset = 0;
		if (!$dateformat)
	{
		$dateformat = $longdateformat;
	}

	if ($dontconvert == 0)
	{
		if ($timeformat == "0" && $dateformat == $longdateformat)
		{
			$dateformat = str_replace("H","h",$dateformat);
			return date($dateformat . "a", $time + ($timezoneoffset * 3600));
		}	else {
			return date($dateformat, $time + ($timezoneoffset * 3600));
		}
	}
	else
	{
		return date($dateformat,$time);
	}
}
## -------------------------------------------------------------------------------------------------------------- ##
function checkMail($mail)
{
	global $checked;

	if ($mail)
	{
		//if (eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$",$mail))
		$checked = ifelse(eregi("^[_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,}$",$mail), true, false);
	}
	else
	{
		$checked = false;
	}
	return $checked;
}
## -------------------------------------------------------------------------------------------------------------- ##
function ifelse ($expression,$returntrue,$returnfalse="")
{
	if (!$expression)
	{
		return $returnfalse;
	}
	else
	{
		return $returntrue;
	}
}
## -------------------------------------------------------------------------------------------------------------- ##
function makeimgtag($path,$alt="",$align="middle",$width="",$height="")
{
	if (!$width && ($size = @getimagesize($path)))
	{
		$width = $size[0];
		$height = $size[1];
	}
	return "<img src=\"{$path}\" " .
		ifelse($alt, 'alt="' . $alt . '" ', '') .
		ifelse($align, 'align="' . $align . '" ', '')    .
		ifelse($width, 'width="' . $width . '" ', '')    .
		ifelse($height, 'height="' . $height . '" ', '') .
		'border="0">';
}
## -------------------------------------------------------------------------------------------------------------- ##
function makelink($link,$name,$title="",$target="",$completeurl=0,$cutname=0,$maxwidth=60,$startwidth=40,$endwidth=-15)
{
	if (!trim($name))
	{
		$name = $link;
	}
	if ($completeurl == 1)
	{
		$link = checkUrlFormat($link);
	}
	if (strlen($name) > $maxwidth && $cutname == 1)
	{
		$name = substr($name, 0, $startwidth) . "..." . substr($name, $endwidth);
	}
	$link	=	"<a href=\"" . $link . "\" target=\"" .$target . "\" title=\"" . $title . "\">" . $name . "</a>";

	return $link;
}
## -------------------------------------------------------------------------------------------------------------- ##
function popupwin($target, $name, $class="",$scrollbar=true,$x=520, $y=520, $href="#",$resizable=true,$menubar=false,$locationbar=false)
{
	$scroll 	= ($scrollbar ? "yes":"no");  // nb. scrollbars=no produces an unusable scroll ghost, none at all inserts them when necessary
	$resize		= ($resizable ? "yes":"no");
	$menu			=	($menubar ? "yes":"no");
	$location	=	($locationbar ? "yes":"no");

	$class 		= ifelse($class != "", "class='$class'");

	$originX 	= 100;
	$originY 	= 100;                // applies to NS only
	$result 	= "<a href='#' $class onClick=\"window.open('$target','_blank','width=$x,height=$y,screenX=$originX,screenY=$originY,resizable=$resize,menubar=$menu,locationbar=$location,scrollbars=$scroll')\">$name</a>";

	return $result;
}
## -------------------------------------------------------------------------------------------------------------- ##
function checkUrlFormat($url)
{
	if ( empty($url) )
	{
		return "";
	}

	if (substr($url,0,7) != "http://" AND substr($url,0,6) != "ftp://")
	{
		$url = "http://" . $url;
	}
	return $url;
}
## -------------------------------------------------------------------------------------------------------------- ##
function checkPath($path)
{
	return (substr($path,(strlen($path)-1),1) != "/") ? $path . "/" : $path;
}
## -------------------------------------------------------------------------------------------------------------- ##
function encodeMail($mailstring)
{
	if (preg_match_all('#([_\.0-9a-z-]+@[0-9a-z][0-9a-z-]+\.+[a-z]{2,})#i',$mailstring,$matches))
	{
		for ($matchcount = 0; $matchcount < (sizeof($matches)); $matchcount++)
		{
			for ($pos = 0; $pos < (strlen($matches[1][$matchcount])); $pos++)
			{
				$tmp .= "&#".ord(substr($matches[1][$matchcount],$pos,1)).";";
			}

			$mailstring = str_replace($matches[1][$matchcount],$tmp,$mailstring);
			$tmp = "";
		}
	}

	return $mailstring;
}
## -------------------------------------------------------------------------------------------------------------- ##
function parseText($text, $ismember=0, $dosmilies=1, $docensor=1, $dobbcode=1, $dourlsearch=1, $external=0, $noimage=0)
{

 global $vwar_root;

	// this is the main function to parse a text with bbcode, smilies and censor protection

	// include the functions to parse the text
	include_once ( $vwar_root . "includes/functions_textparser.php" );

	// call the main function
	$text = parse ( $text, $ismember, $dosmilies, $docensor, $dobbcode, $dourlsearch, $external, $noimage);

 return $text;

}
## -------------------------------------------------------------------------------------------------------------- ##
function dbSelect ( &$arg, $stripslashes=0, $donl2br=1, $dohtml = 1 )
{
	global $htmlcode;

	if (is_string($arg))
	{
		// <script> is never allowed!
		if($htmlcode != 1  && $dohtml == 1)
		{
			$arg = htmlspecialchars ($arg);
		}
		else
		{
			$arg = preg_replace ("/<(script|\/script)([^>]*)>/i","&lt;\\1\\2&gt;", $arg);
		}

		if ($stripslashes == 1)
		{
			$arg = strip_slashes ($arg);
		}

		// $arg ment for output -> nl2br()
		if ($donl2br == 1)
		{
			$arg = nl2br ($arg);
		}
	}
	else
	{
		$arg = dbSelectArray ($arg, $htmlcode, $donl2br, $stripslashes, $dohtml);
	}

	return $arg;
}
## -------------------------------------------------------------------------------------------------------------- ##
function dbSelectArray ($arg, $htmlcode=0, $nl2br=1, $stripslashes=0, $dohtml=1)
{
	if (!empty($arg))
	{
		while (list($key,$val) = each($arg))
		{
			if (is_string($val))
			{
				if ($stripslashes == 1)
				{
					$val = strip_slashes( $val);
				}

				// <script> is never allowed!
				if ($htmlcode != 1  && $dohtml == 1)
				{
					$val = htmlspecialchars($val);
				}
				else
				{
					$val = preg_replace ("/<(script|\/script)([^>]*)>/i","&lt;\\1\\2&gt;", $val);
				}

				if ($nl2br == 1)
				{
					$val = nl2br($val);
				}
				$arg[$key] = $val;
			}
			else if (is_array($val))
			{
				$arg[$key] = dbSelectArray ($val);
			}
		}
	}
	return $arg;
}
## -------------------------------------------------------------------------------------------------------------- ##
function dbSelectForm (&$arg, $stripslashes=0)
{
	global $htmlcode;

	if (is_string($arg))
	{
		// if $arg is ment for a form (especially textareas),
		// we always have to use htmlspecialchars()
		$arg = htmlspecialchars ($arg);

		if ($stripslashes == 1)
		{
			$arg = strip_slashes ($arg);
		}
	}
	else
	{
		$arg = dbSelectArray ($arg, 0, 0, $stripslashes);
	}
	return $arg;
}
## -------------------------------------------------------------------------------------------------------------- ##
function strip_slashes (&$arg)
{
	if (is_string($arg))
	{
		return stripslashes($arg);
	}
	else
	{
		$arg = dbSelectArray ($arg, 1, 0, 1, 0);
		return $arg;
	}
}
## -------------------------------------------------------------------------------------------------------------- ##
function rehtmlspecialchars($arg)
{
	$arg = str_replace ("&lt;", "<", $arg);
	$arg = str_replace ("&gt;", ">", $arg);
	$arg = str_replace ("&quot;", "\"", $arg);
	$arg = str_replace ("&amp;", "&", $arg);

	return $arg;
}
## -------------------------------------------------------------------------------------------------------------- ##
// function stripos() is already exists in versions > php5
if (version_compare(PHP_VERSION, "5.0.0", ">=") && !function_exists('stripos'))
//if ($phpversion_nr >= "5.0.0" || !function_exists('stripos'))
{
	function stripos($haystack, $needle, $offset = 0)
	{
		// same as strpos, but non-case sensitive
		$foundstring = stristr(substr($haystack, $offset), $needle);
		return ($foundstring === false) ? false : strlen($haystack) - strlen($foundstring);
	}
}
## -------------------------------------------------------------------------------------------------------------- ##
function lcfirst ( $str )
{
	$str[0] = strtolower ( strtr( $str[0], "ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÑÒÓÔÕÖØÙÚÛÜÝ", "àáâãäåçèéêëìíîïñòóôõöøùúûüý" ) );
	return $str;
}
## -------------------------------------------------------------------------------------------------------------- ##
function updateRepeatingDatelines($table, $id_field, $time_field, $deleteparts=0, $overlap=0)
{
	global $vwardb,$n,$waroverlap;

	if ( defined("VWAR_REPEATED_DATELINES_UPDATED") )
	{
		return;
	}
	else
	{
		define ("VWAR_REPEATED_DATELINES_UPDATED", 1);
	}

	$result = $vwardb->query("
		SELECT repeat_mod, repeat_number, repeat_saveas, $id_field, $time_field
		FROM $table
		WHERE $time_field < ".(time()-$overlap)."
			AND repeat_mod != ''
			AND repeat_number != ''
	");
	while ($row = $vwardb->fetch_array($result))
	{
		// dates or intervalls?
		if ($row['repeat_mod'] == "date")
		{
			// some date precalculations
			$war_min   = date("i", $row[$time_field]);
			$war_hour  = date("G", $row[$time_field]);
			$war_day   = date("j", $row[$time_field]);
			$war_month = date("n", $row[$time_field]);
			$war_year  = date("Y", $row[$time_field]);

			$cur_day   = date("j");
			$cur_month = date("n");
			$cur_year  = date("Y");

			$cur_time  = time() - $overlap;

				$calc_war_month = $war_month;
				$calc_war_year  = $war_year;

			$stop = FALSE;
			while ( !$stop )
			{
				$calc_war_month += $row["repeat_number"];
				if ( $calc_war_month > 12 )
				{
					$calc_war_year++;
					$calc_war_month = $calc_war_month - 12;
				}
				$newtime = mktime ($war_hour, $war_min, 0, $calc_war_month, $war_day, $calc_war_year);

				if ( $newtime >= $cur_time )
				{
					$stop = TRUE;
				}
			}
		}
		else
		{
			switch ( $row['repeat_mod'] )
			{
				case "hours":	$factor = 1;
						break;
				case "days":	$factor = 24;
						break;
				case "weeks":	$factor = 168;
						break;
				case "months":	$factor = 672;
						break;
				case "years":	$factor = 8736;
						break;
				default:	$factor = 168;
			}

			if ( (time() - $row[$time_field]) <= 3600 * $factor * $row['repeat_number'] )
			{
				$newtime = $row[$time_field] + (3600 * $factor * $row['repeat_number']);
				$plus    = 1;
			}
			else
			{
				// how many times more do we have to add up our old dateline?
				$plus    = floor((time() - $row[$time_field]) / (3600 * $factor * $row['repeat_number'])) + 1;
				$add     = $plus * 3600 * $factor * $row['repeat_number'];
				$newtime = $row[$time_field] + $add;
			}
		}

		// check how to save the entry
		if ( $row["repeat_saveas"] == 1 )
		{
			// oh no, we have to add some entries, let's begin the hard work ;)
			$data = $vwardb->query_first("
				SELECT *
				FROM $table
				WHERE $id_field = '" . $row[$id_field] . "'
			");
			$data[$id_field] = "";
			$repeat_mod      = $data["repeat_mod"];

			$vwardb->query ("
				UPDATE $table
				SET repeat_mod = ''
				WHERE $id_field = '" . $row[$id_field] . "'
			");

			if ( $row["repeat_mod"] != "date" )
			{
				for ( $i=1; $i<=$plus; $i++ )
				{
					$newtime  = $i * 3600 * $factor * $row['repeat_number'];
					$newtime += $row[$time_field];

					$data["repeat_mod"] = ( $i < $plus ) ? "" : $repeat_mod;

					$data[$time_field] = $newtime;
					$vwardb->query ("
						INSERT INTO $table
						VALUES ( '" . implode ("', '", $data) . "' )
					");
				}
			}
			else
			{
				$stop = FALSE;
				while ( !$stop )
				{
					$war_month += $row["repeat_number"];
					if ( $war_month > 12 )
					{
						$war_year++;
						$war_month = $war_month - 12;
					}
					$newtime = mktime ($war_hour, $war_min, 0, $war_month, $war_day, $war_year);

					if ( $newtime >= $cur_time )
					{
						$stop			= TRUE;
						$data["repeat_mod"]	= $repeat_mod;
					}
					else
					{
						$data["repeat_mod"] = "";
					}

					$data[$time_field] = $newtime;
					$vwardb->query ("
						INSERT INTO $table
						VALUES ( '" . implode ("', '", $data) . "' )
					");
				}
			}
		}
		else
		{
			$vwardb->query ("
				UPDATE $table
				SET $time_field = '$newtime'
				WHERE $id_field = '" . $row[$id_field] . "'
			");
		}

		// do we need to delete any participants?
		if ($row['dateline'] != $newtime AND $deleteparts == 1)
		{
			$vwardb->query("DELETE FROM vwar".$n."_participants WHERE warid = '".$row['warid']."'");
		}
	}
	$vwardb->free_result($result);
}
## -------------------------------------------------------------------------------------------------------------- ##
function createRandomPassword ($passlen=15,$chars="")
{
    $chars = trim($chars);
	if(empty($chars)) $chars = "aAb0Bc\$CdD1eEfF2gGh%3HiIj§J4kKl5Lm6MnNo7&OpPqQrR6sStTuUvV9wWxXyYzZ§$%&";

	$charlen = strlen($chars);
	for ($i = 0; $i < $passlen; $i++)
	{
		mt_srand(date("s", time() + $i * 4567));
		$password .= substr($chars,mt_rand(1,$charlen),1);
	}

	return $password;
}
## -------------------------------------------------------------------------------------------------------------- ##
function createScoreCache ($own1="",$own2="")
{
	global $n,$vwardb;

	$wherematchtype = getPublicMatchtypes (1);

	// score
	$result = $vwardb->query((!empty($own1) ? $own1 : "SELECT
		vwar".$n."_scores.warid, gameid, SUM(ownscore) AS ownscoretotal, SUM(oppscore) AS oppscoretotal
		FROM vwar".$n."_scores
		LEFT JOIN vwar".$n." ON (vwar".$n.".warid = vwar".$n."_scores.warid)
		WHERE vwar".$n.".status = '1'
		$wherematchtype
		GROUP BY warid"));
	while ($row = $vwardb->fetch_array($result))
	{
		$scores[$row['warid']]['sownscoretotal'] = $row['ownscoretotal'];
		$scores[$row['warid']]['soppscoretotal'] = $row['oppscoretotal'];
		$scores[$row['warid']]['gameid']         = $row['gameid'];
	}
	$vwardb->free_result($result);
	unset($row);

	// location
	$result = $vwardb->query((!empty($own2) ? $own2 : "SELECT warid, ownscore, oppscore FROM vwar".$n."_scores"));
	while ($row = $vwardb->fetch_array($result))
	{
		// reset values to zero first
		if(!isset($scores[$row['warid']]['loppscoretotal']))
		{
			$scores[$row['warid']]['loppscoretotal'] = 0;
		}
		if(!isset($scores[$row['warid']]['lownscoretotal']))
		{
			$scores[$row['warid']]['lownscoretotal'] = 0;
		}

		if ($row['ownscore'] < $row['oppscore'])
		{
			$scores[$row['warid']]['loppscoretotal']++;
		}
		else if ($row['ownscore'] > $row['oppscore'])
		{
			$scores[$row['warid']]['lownscoretotal']++;
		}
	}

	// dev purposes only...
	//print_r($scores); die();

	$vwardb->free_result($result);

	return $scores;
}
## -------------------------------------------------------------------------------------------------------------- ##
function inarray($search, $array)
{
    for ($i = 0; $i<count($array); $i++)
    {
        if ($search == $array[$i])
        {
            return true;
            break;
        }
    }
}
## -------------------------------------------------------------------------------------------------------------- ##
function getPublicMatchTypes ($and=1, $relividate=0, $table_to_use=1)
{

	global $vwardb, $n, $vwar_wherematchtype_vwar, $vwar_wherematchype_match;

	$matchtypearray  = array();

	if (!checkCookie())
	{
		if (!isset($vwar_wherematchtype) OR $relividate == 1)
		{
			$result = $vwardb->query("
				SELECT matchtypeid
				FROM vwar".$n."_matchtype
				WHERE public = '1'
			");
			while ($row = $vwardb->fetch_array($result))
			{
				$matchtypearray[] = $row['matchtypeid'];
			}

			$vwar_wherematchtype_vwar  = "WHERE ";
			$vwar_wherematchtype_match = "WHERE ";
			if (count($matchtypearray) > 0)
			{
				if ($and == 1)
				{
					$vwar_wherematchtype_vwar  = "AND ";
					$vwar_wherematchtype_match = "AND ";
				}

				$vwar_wherematchtype_vwar .= "vwar".$n.".matchtypeid ";
				$vwar_wherematchtype_match .= "vwar".$n."_matchtype.matchtypeid ";

				$vwar_wherematchtype_vwar  .= "IN ('" . join("','", $matchtypearray) . "')";
				$vwar_wherematchtype_match .= "IN ('" . join("','", $matchtypearray) . "')";
			}
		}
	}
	else
	{
		$vwar_wherematchtype_vwar  = "";
		$vwar_wherematchtype_match = "";
	}

	if($table_to_use == 1)
	{
		return $vwar_wherematchtype_vwar;
	}
	else if ($table_to_use == 2)
	{
		return $vwar_wherematchtype_match;
	}
}
?>