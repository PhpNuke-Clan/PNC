<?php
/* #####################################################################################
 *
 * $Id: functions_install.php,v 1.18 2004/03/10 20:17:44 frag Exp $
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
 * includes/functions_install.php
 * ------------------------------------------------------------------------------------
 * install functions
 * functions used during the update and install process
*/

## -------------------------------------------------------------------------------------------------------------- ##

if(eregi("functions_install.php", $_SERVER["PHP_SELF"]) || eregi("functions_install.php", $HTTP_SERVER_VARS["PHP_SELF"])) die("Access denied!");

// set error reporting
error_reporting(E_ALL & ~E_NOTICE);

// we only handle data from files, so magic quotes runtime is very helpful
@set_magic_quotes_runtime(1);

require($vwar_root . "includes/_config.inc.php");
require($vwar_root . "includes/classes/class_db.php");

// we save all incoming $HTTP_*_VARS or $_* in the $GPC array
$magic_quotes = get_magic_quotes_gpc();

## -------------------------------------------------------------------------------------------------------------- ##
function checkValue ($arg, $magic_quotes=false)
{
	global $magic_quotes;

	if(is_string($arg))
	{
		$arg = ( $magic_quotes ) ? $arg : addslashes($arg);
	} else {
		while (list($key, $value) = each($arg))
		{
			if(is_array($value))
			{
				$arg[$key] = checkValue($value);
			} else {
				$arg[$key] = checkValue($value);
			}
		}
	}
	return $arg;
}

## -------------------------------------------------------------------------------------------------------------- ##
function regGlobals ($array, &$target_array, $magic_quotes = false)
{
	global $magic_quotes;

	reset($array);
	// get the vars out of the get-, post- or cookie-arrays
	while (list($key, $value) = each($array))
	{
		global ${$key};

		// we don't register arrays with more than one dimension,
		// we only add slashes if required and use rehtmlspecialchars()
		$value = checkValue($value, $magic_quotes);
		${$key} = $value;
		$target_array[$key] = $value;
	}
	return true;
}

if (!empty($_GET))
{
  regGlobals($_GET, $GPC, $magic_quotes);
}
else if (!empty($HTTP_GET_VARS))
{
  regGlobals($HTTP_GET_VARS, $GPC, $magic_quotes);
}

if (!empty($_POST))
{
  regGlobals($_POST, $GPC, $magic_quotes);
}
else if (!empty($HTTP_POST_VARS))
{
  regGlobals($HTTP_POST_VARS, $GPC, $magic_quotes);
}

if (!empty($_SERVER))
{
  $GPC["PHP_SELF"] = $_SERVER['PHP_SELF'];
}
else if (!empty($HTTP_SERVER_VARS))
{
  $GPC["PHP_SELF"] = $HTTP_SERVER_VARS['PHP_SELF'];
}

## -------------------------------------------------------------------------------------------------------------- ##
if(!function_exists("inarray"))
{
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
}
## -------------------------------------------------------------------------------------------------------------- ##
function ifelse ($expression,$returntrue,$returnfalse) {
  if (!$expression) return $returnfalse;
  else return $returntrue;
}

## -------------------------------------------------------------------------------------------------------------- ##
function makeimgtag($path,$alt="",$align="middle",$width="",$height="")
{
	if (!$width && @file_exists($path))
	{
		$size = getimagesize($path);
		$width = $size[0];
		$height = $size[1];
	}
	return "<img src=\"$path\" ".ifelse($alt,"alt=\"".$alt."\" ","alt=\"\" ")."".ifelse($align,"align=\"".$align."\" ","")."".ifelse($width,"width=\"".$width."\" ","")."".ifelse($height,"height=\"".$height."\" ","")."border=\"0\">";
}

## -------------------------------------------------------------------------------------------------------------- ##
function printHeader($title,$type=1)
{
	global $vwar_root;

	if ($type == 1)
	{
		$title_img = "<img src=\"" . $vwar_root . "images/title_install.jpg\" align=\"absleft\" alt=\"\">";
	} else if ($type == 2 || !isSet($type)){
		$title_img = "<img src=\"" . $vwar_root . "images/title_update.jpg\" align=\"absleft\" alt=\"\">";
	}

	echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">
	<html>
	<head>
	<meta http-equiv=\"content-type\" content=\"text/html; charset=ISO-8859-1\">
	<title>Virtual War ".$title."</title>
	<style type=\"text/css\">
	<!--
	body { background-color: #D0D5DA; margin-left: 5px; margin-top: 3px; margin-right: 5px; margin-bottom: 3px;}



	tr, td { font-family: Arial, Verdana, Helvetica, Sans-Serif; }

	.tblhead { font-size: 18px; color: #151535; font-weight: bold; letter-spacing:-1px; background-image: url(" . $vwar_root . "images/cellpic2.gif); border-bottom:1px solid #808A98; border-right:1px solid #808A98; border-top:1px solid #E5E5E5; border-left:1px solid #E5E5E5; }
	.tblheaderror { font-size: 18px; color: #EF4542; font-weight: bold; letter-spacing:-1px; background-image: url(" . $vwar_root . "images/cellpic2.gif); border-bottom:1px solid #808A98; border-right:1px solid #808A98; border-top:1px solid #E5E5E5; border-left:1px solid #E5E5E5; }

	.innertblhead a:link, .innertblhead a:visited, .innertblhead a:active { font-size: 11px; }
	.innertblhead a:hover { font-size: 11px; color: #000000; text-decoration: none; }
	.innertblhead { font-size: 11px; color: #151535; font-weight: bold; background-image: url(" . $vwar_root . "images/cellpic2.gif); border-bottom:1px solid #808A98; border-right:1px solid #808A98; border-top:1px solid #E5E5E5; border-left:1px solid #E5E5E5;}

	.sectionhead { font-size: 12px; background-color: #858FBF; font-weight: bold; color: #FFFFFF; border-bottom:1px solid #EFEFEF; border-right:1px solid #808A98; border-top:1px solid #EFEFEF; border-left:1px solid #E5E5E5; }
	.sectionhead a:link, .sectionhead a:visited, .sectionhead a:active { color: #103590; }

	.formsubmit { background-color: #C6CFFF; border-bottom:1px solid #EFEFEF; border-right:1px solid #808A98; border-top:1px solid #EFEFEF; border-left:1px solid #E5E5E5; }
	.formsubmit input { background-color: #FAFAFF; font-size: 12px; font-family: Arial, Helvetica, Sans-Serif; font-weight: bold; border:1px solid #808A98; }

	textarea, select, input { font-family: Verdana, Arial, Helvetica, Sans-Serif; color: #000000; font-size: 11px; }
	input, select { vertical-align: middle; }
	.input, textarea { width: 90%; }
	.input2 { width: 30%; }
	.input3 { width: 9%; }

	.firstalt { font-size: 12px; color: #000000; background-color: #E7EBEF; border-bottom:1px solid #808A98; border-right:1px solid #808A98; border-top:1px solid #E5E5E5; border-left:1px solid #E5E5E5; }
	.secondalt { font-size: 12px; color: #000000; background-color: #D6DBDE; border-bottom:1px solid #808A98; border-right:1px solid #808A98; border-top:1px solid #E5E5E5; border-left:1px solid #E5E5E5; }
	.highlight { font-size: 12px; background-color: #FF8030; border-bottom:1px solid #808A98; border-right:1px solid #808A98; border-top:1px solid #E5E5E5; border-left:1px solid #E5E5E5; }
	.tblborder { border: 1px solid #000000;}

	.bgfont { font-family: arial,verdana,helvetica,sans-serif; font-size: 11px; color: #000000; }
	small { font-size: 11px; font-weight: normal; }
	hr { height: 1px; }
	.headbg {	background-image: url(" . $vwar_root . "images/titleback.jpg); background-repeat: repeat-x;	}
	-->
	</style>
	</head>
	<body>
	</head>
	<body marginheight=\"0\" marginwidth=\"0\" leftmargin=\"10\" topmargin=\"10\" link=\"#050550\" vlink=\"#050550\" text=\"#000000\">
	<table cellspacing=\"1\" cellpadding=\"0\" width=\"100%\" align=\"center\" border=\"0\" class=\"tblborder\">
		<tr>
			<td class=\"headbg\" align=\"left\">".$title_img."</td>
		</tr>
	</table><br>";
}

## -------------------------------------------------------------------------------------------------------------- ##
function getDirContents($dir)
{
	// open dir
	$handle = opendir($dir);

	while (false !== ($file = readdir ($handle)))
	{
		// exclude . and ..
		if ($file != "." && $file != "..")
		{
			$contents[] = $file;
		}
	}
	return $contents;
}

## -------------------------------------------------------------------------------------------------------------- ##
function dbSelect (&$arg, $stripslashes=0, $donl2br=1, $dohtml = 1)
{
	global $htmlcode;

	if (is_string($arg))
	{
		$arg = trim ($arg);

		// <script> is never allowed!
		// we always use htmlspecialchars() for data without new lines
		if(($htmlcode != 1 || !strpos($arg, "\n")) && $dohtml == 1)
		{
			$arg = htmlspecialchars ($arg);
		} else {
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
				$val = trim($val);

				if ($stripslashes == 1)
				{
					$val = strip_slashes($val);
				}

				// <script> is never allowed!
				// we always use htmlspecialchars() for data without new lines
				if (($htmlcode != 1) || !strpos($val, "\n") && $dohtml == 1)
				{
					$val = htmlspecialchars($val);
				} else {
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
?>
