<?php
/* #####################################################################################
 *
 * $Id: functions_front.php,v 1.67 2004/08/12 12:10:07 frag Exp $
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
 * includes/functions_front.php
 * ------------------------------------------------------------------------------------
 * functions used in the front-end
*/

// beware of cross-site-scripting attacks
if (VWAR_COMMON_INCLUDED != 1)
{
	die("<p style=\"FONT-FAMILY:verdana,tahoma,arial,sans-serif;FONT-SIZE:13px;\">Hacking attempt!</p>\n");
}

## -------------------------------------------------------------------------------------------------------------- ##

$vwartpladmin   = 0;
$admintemplates = 0;

## -------------------------------------------------------------------------------------------------------------- ##

// include language files
if (isset($userlanguage))
{
	if (@file_exists($vwar_root . "includes/language/" . $userlanguage . ".inc.php"))
	{
		require($vwar_root . "includes/language/" . $userlanguage . ".inc.php");
	} else {
		die("Error: File ".$vwar_root . "'includes/language/<b>" . $userlanguage . ".inc.php</b>' is missing!");
	}
}
else if(!empty($GPC['vwarlanguage']))
{
	if (@file_exists($vwar_root . "includes/language/" . $GPC['vwarlanguage'] . ".inc.php"))
	{
		//require("./includes/language/".$GPC['vwarlanguage'].".inc.php");
		require($vwar_root . "includes/language/".$GPC['vwarlanguage'].".inc.php");
	}	else {
		die("Error: File ".$vwar_root . "'includes/language/<b>" . $GPC['vwarlanguage'] . ".inc.php</b>' is missing!");
	}
}
else
{
	if (@file_exists($vwar_root . "includes/language/" . $vwarlanguage . ".inc.php"))
	{
		require($vwar_root . "includes/language/" . $vwarlanguage . ".inc.php");
	}	else {
		die("Error: File ".$vwar_root . "'includes/language/<b>" . $vwarlanguage . ".inc.php</b>' is missing!");
	}
}

## -------------------------------------------------------------------------------------------------------------- ##

// do time vars
$timediff = '';
if ($timezoneoffset!=0)
{
	$timediff = " " . $timezoneoffsetuser . "h";
}

// calculate timezoneoffset from server's timezoneoffset and user's timezoneoffset
$timezoneoffset = $timezoneoffsetuser - $timezoneoffset;

if ($timeformat == 0)
{
	$timenow = formatdatetime(time(), "h:i"."a");
} else {
	$timenow = formatdatetime(time(), "H:i");
}

## -------------------------------------------------------------------------------------------------------------- ##
##	FUNCTIONS
## -------------------------------------------------------------------------------------------------------------- ##
// alternate colors to separate rows of long lists
function switchColors($start=1)
{
	global $n,$vwardb,$altcolor,$firstaltcolor,$secondaltcolor,$colourcounter,$vwarmod;

	if (!isset($colourcounter))
	{
		$colourcounter = 1;
	}
	if (!isset($firstaltcolor))
	{
		$result = $vwardb->query_first("SELECT replaceword FROM vwar".$n."_replacement WHERE findword = '{firstaltcolor}'");
		$firstaltcolor = $result['replaceword'];
	}
	if (!isset($secondaltcolor))
	{
		$result = $vwardb->query_first("SELECT replaceword FROM vwar".$n."_replacement WHERE findword = '{secondaltcolor}'");
		$secondaltcolor = $result['replaceword'];
	}
	$altcolor = ($colourcounter++ % 2 != $start ? $secondaltcolor : $firstaltcolor);

	return $altcolor;
}
## -------------------------------------------------------------------------------------------------------------- ##
function sendMail( $mailtext, $tomail, $toname="", $frommail="", $fromname="", $subject="", $type="text",
	$priority=3, $smilies=1, $url=1, $isslashed=0 )
{

 global $vwartpl, $vwarversion, $ownhomepage, $ownname, $ownnameshort,$vwarmod;

	// check vars
	if ($frommail == "")
	{
	 global $ownmail,$vwarmod;
		$frommail = $ownmail;
	}
	/* ...
	if ($fromname == "")
	{
		$fromname = rehtmlspecialchars($ownname);
	}
	*/
	if ($subject == "")
	{
		$subject  = rehtmlspecialchars($owname) . " Virtual War - Mail";
	}
	/* BUG: problems if $toname contains slashes, quotes, etc.,
	   no solution so far... 2004-05-08
	$to = ( $toname != "" )	? "\"" . addslashes($toname) . "\" <" . $tomail . ">"
				: $tomail;
	*/
	$to = $tomail;

	// mailtext
	// we get back html. if the mail is sent as html, htmlspecialchars() is used later
	// like that we can be sure, everyhting is fine when the mail is sent as normal text
	if ($isslashed == 1)
	{
		strip_slashes($mailtext);
	}
	eval("\$footer = \"".$vwartpl->get("message_mail_footer")."\";");
	$footer   = rehtmlspecialchars ($footer);
	$mailtext = rehtmlspecialchars ($mailtext);

	// create header
	// $from   = "\"" . addslashes($fromname) . "\" <" . $frommail . ">";
	$from   = $frommail;
	$header = "From: " . $from."\r\n";
	if ((strtolower($type) == "html") || $type == 1)
	{
		$header  .= "MIME-Version: 1.0\r\n";
		$header  .= "Content-Type: text/html; charset=iso-8859-1\r\n";
		$mailtext = parseText (dbSelect($mailtext), "", $smilies, 0, 1, $url, 1);
		$footer   = dbSelect ($footer);
	}
	$header .= "X-Priority: " . $priority . "\r\n";
	$header .= "X-Mailer: VWar v" . $vwarversion . " www.vwar.de (PHP v" . phpversion() . ")\r\n";
	$header .= "X-Comment: mail generated at " . date ("m/d/Y, H:i:s a", time()) . "\r\n";

	// add footer
	$mailtext .= $footer;

	// send mail
	if ( checkMail($tomail) )
	{
		if ( @mail($to, $subject, $mailtext, $header) )
		{
			$return = true;
		} else {
			$return = false;
		}
	}
	else
	{
		$return = false;
	}

 return $return;

}
## -------------------------------------------------------------------------------------------------------------- ##
function clickable_smilies ($formname,$textfieldname,$num_per_row=5,$maxsmilies=10)
{
	global $vwartpl,$vwardb,$vwar_root,$n,$str,$vwarmod;

	$result = $vwardb->query_first("SELECT COUNT(smilieid) AS numsmilies FROM vwar".$n."_smilie WHERE deleted = '0'");
	$totalsmilies = $result['numsmilies'];
	$count = 0;

	$result = $vwardb->query("SELECT * FROM vwar".$n."_smilie WHERE deleted = '0' AND smilie = '1' LIMIT $maxsmilies");
	while ($row = $vwardb->fetch_array($result))
	{
		$count++;

		if ($count % 1 OR $count == 1)
		{
			$smiliesbit .= "\t\t\t\t\t\t\t\t\t\t<tr>\r\n";
		}

		$current_smilie = makeimgtag($vwar_root . "images/smilies/" . $row['filename'] . "", $row['title']);
		eval("\$smiliesbit .= \"".$vwartpl->get("smilies_clickablebit")."\r\n\";");

		if ($count == ($num_per_row))
		{
			$count = 0;
			$smiliesbit .= "\t\t\t\t\t\t\t\t\t\t</tr>\n";
		}
	}
$module_name = basename(dirname(__FILE__));
	$morelink = popupwin("modules.php?name=$vwarmod&file=popup&action=smilies&amp;form=$formname&amp;field=$textfieldname", $str['MORE']);
	eval("\$smilies = \"".$vwartpl->get("smilies_clickable")."\";");

	return $smilies;
}
## -------------------------------------------------------------------------------------------------------------- ##
function clickable_bbcode($formname,$textfieldname,$bgcolor="{firstaltcolor}")
{
	global $vwartpl, $vwar_root, $mode, $str,$vwarmod;

	$strSize = strtoupper($str['SIZE']);
	$strFont = strtoupper($str['FONT']);
	$strColor = strtoupper($str['COLOR']);
	if (isset($mode))
	{
		$modechecked[$mode] = "checked";
	} else {
		$modechecked[0] = "checked";
	}
	eval("\$bbcode_language = \"".$vwartpl->get("bbcode_language")."\";");
	eval("\$bbcode_javascript = \"".$vwartpl->get("bbcode_javascript")."\";");

	$bbcode_help = popupwin("modules.php?name=$vwarmod&file=popup&action=bbcode&amp;form=$formname&amp;field=$textfieldname",
									makeimgtag($vwar_root . "images/bbcode/help.gif",$str['BBCODE'] . "&nbsp;" . $str['HELP']));

	eval("\$bbcode = \"".$vwartpl->get("bbcode")."\";");

	return $bbcode;
}
## -------------------------------------------------------------------------------------------------------------- ##
function makepagelinks($numentries,$perpage,$arg="")
{
	global $s_prev,$s_next,$s_last,$page_prev,$page_next,$vwartpl,$str,$GPC,$s,$page,$vwarmod,$vwar_file;

	$page = $GPC['page'];

	$numpages = ceil($numentries / $perpage);

	if ($numpages == 0)
	{
		$numpages = 1;
	}
	if (!isset($page) || empty($page))
	{
		$page = 1;
	}
	if (!empty($arg))
	{
		$arg = "&amp;" . $arg;
	}

	if ($page > 1 && $numpages > 1 && $page != "all")
	{
		$s_prev = $s - $perpage;
		$page_prev = $page - 1;
		eval("\$pagenav .= \"".$vwartpl->get("pagenav_prevlinks")."\";");
	}

	$pagenav .= ifelse($page == 1, "&nbsp;");

	if ($numpages > 1 && $page != "all")
	{
		$pagenav .= makelink($GPC['PHP_SELF']."?name=$vwarmod&file=$vwar_file&amp;s=0&amp;page=all" . $arg, $str['ALL'] , $str['SHOWALL'])."&nbsp;";
	}
	else if ($page == "all")
	{
		$pagenav .= "<b>&nbsp;[" . $str['ALL'] . "]&nbsp;</b>";
	}

	$start = ifelse($page > 5 && $numpages > 10, $page - 5, 1);
	$end = ifelse($numpages > 10 && (($start + 9) < $numpages), $start + 9, $numpages);

	for ($i = $start; $i <= $end; $i++)
	{
		$min = ($i * $perpage) - $perpage;

		if ($page == $i || $numpages == 1)
		{
			$pagenav .= "<b>[" . $i . "]</b>&nbsp;";
		}
		else
		{
			$pagenav .= makelink($GPC['PHP_SELF'] . "?name=$vwarmod&file=$vwar_file&s=" . $min . "&amp;page=" . $i . $arg, $i);

			if ($i < $numpages)
			{
				$pagenav .= "&nbsp;";
			}
		}
	}

	if ($page < $numpages && $page != "all")
	{
		$s_next = $s + $perpage;
		$page_next = $page + 1;
		$s_last = ($numpages - 1) * $perpage;
		eval("\$pagenav .= \"".$vwartpl->get("pagenav_nextlinks")."\";");
	}

	$pagenav .= ifelse($page == "all", "&nbsp;");

	eval("\$pagelinks = \"".$vwartpl->get("pagenav")."\";");

	return $pagelinks;
}
## -------------------------------------------------------------------------------------------------------------- ##
function doQuickjump($quickjumptarget)
{
global $vwarmod;
	if(!empty($quickjumptarget))
	{
        header("Location: ".$quickjumptarget);
        exit();
	}
}
## -------------------------------------------------------------------------------------------------------------- ##
function loadQuickjump($selectthis="")
{
	global $vwardb,$n,$vwartpl,$showquickjump,$str,$GPC,$vwarmod,$vwarmod;

	// load quickjump form database
	    if(!empty($selectthis))
	    {
	        $qselected[$selectthis] = "selected";
	    }

	$result = $vwardb->query("
        SELECT title,redirectto
        FROM vwar".$n."_quickjump
        WHERE activated = '1'
        ORDER BY displayorder ASC, title ASC");
    while($row = $vwardb->fetch_array($result))
    {
        if($showquickjump == 1)
        {
            $url = $row["redirectto"];
            eval("\$row[\"title\"] = \"".addslashes($row["title"])."\";");
            eval("\$quickjumpbits .= \"".$vwartpl->get("quickjump_bit")."\";");
        }
    }

	if ($showquickjump == 1)
	{
		eval("\$quickjump = \"".$vwartpl->get("quickjump")."\";");
	}

	return $quickjump;
}

## -------------------------------------------------------------------------------------------------------------- ##
function getSortClauses ( $stdorder="dateline" )
{

 // global vars
 global $GPC,$vwarmod;

	// limit ...
	if ( strtolower($GPC["page"]) == "all" )
	{
		$limit = "";
	}
	else
	{
	 global $perpage,$vwarmod;

		$s     = ( !empty($GPC["s"]) ) ? $GPC["s"] : 0;
		$limit = "LIMIT " . $s . ", " . $perpage;
	}

	// sort by ...
	if ( !empty ($GPC["sortby"]) )
	{
		$sortby = ( !empty($overwrite) AND $GPC["sortby"] == $overwrite )
			? $replacewith
			: urldecode ($GPC["sortby"]);
		$sortby = "ORDER BY " . $sortby;
	}
	else
	{
		$sortby = "ORDER BY " . $stdorder;
	}

	// sort order ...
	if ( !preg_match ("#(\s)*(desc|asc)$#siU", $sortby) )
	{
		if ( !empty ($GPC["sortorder"]) )
		{
			$sortorder = $GPC["sortorder"];
		}
		else
		{
			$sortorder = "desc";
		}
	}

	$sort = $sortby . " " . $sortorder;

 // return
 return array ("limit" => $limit, "sort" => $sort);
}
## -------------------------------------------------------------------------------------------------------------- ##
function getSortNav ( $fields, $stdfield="dateline" )
{

 // global vars
 global $vwartpl, $GPC, $str,$vwarmod;

	$sortby = ( isset($GPC["sortby"]) ) ? urldecode($GPC["sortby"]) : $stdfield;

	if ( preg_match ("#(vwar)?(.*)(_)?([^\.])?(\.)?(.*)(\s)*(desc|asc)*$#siU", $sortby, $tmp) )
	{
		$sortby = $tmp[6];
	}

	while ( list(, $field) = each ($fields) )
	{
		$query  = preg_replace ("#(&amp;|&)(sortby|sortorder)=([^&])*#si", "", $GPC["QUERY_STRING"]);

		if ( $sortby == $field )
		{
			if ( $GPC["sortorder"] == "asc" )
			{
				eval("\$sortnav[" . $field . "] = \"".$vwartpl->get("sortnav_checked_asc")."\";");
				$sortnav["link_" . $field] = '<a href="' . $GPC["PHP_SELF"] . '?name=$vwarmod&' . $query . '&amp;sortby=' . $field . '&amp;sortorder=desc">';
			}
			else
			{
				eval("\$sortnav[" . $field . "] = \"".$vwartpl->get("sortnav_checked_desc")."\";");
				$sortnav["link_" . $field] = '<a href="' . $GPC["PHP_SELF"] . '?name=$vwarmod&' . $query . '&amp;sortby=' . $field . '&amp;sortorder=asc">';
			}
		}
		else
		{
			eval("\$sortnav[" . $field . "] = \"".$vwartpl->get("sortnav_unchecked")."\";");
			$sortnav["link_" . $field] = '<a href="' . $GPC["PHP_SELF"] . '?name=$vwarmod&' . $query . '&amp;sortby=' . $field . '&amp;sortorder=desc">';
		}
	}

 // return
 return $sortnav;

}
## -------------------------------------------------------------------------------------------------------------- ##
function createQuickStats ( $array, $column_main, $column_num, $mask="{name}", $numstats=5, $sortfunction="arsort", $sortflag=SORT_REGULAR, $delimeter="||-VWAR-||" )
{

  // global vars
  global $vwartpl, $altcolor, $colourcounter,$vwarmod;

	$numentries = count ( $array );
	if ( $numentries == 0 )
	{
		return "";
	}
	else if ( $numentries < $numstats )
	{
		$numstats = $numentries;
	}

	$sortfunction ( $array, $sort );

	$quickstats_bit = "";

	$colourcounter = 0;

	$rank  = 0;
	$last  = 0;
	$count = 0;
	foreach ( $array as $details => $num )
	{
		switchColors();

		$count++;

		if ( $num != $last )
		{
			$rank++;
		}

		$details = explode ($delimeter, $details);
		$name    = $details[1];
		$id      = $details[0];

		$details = str_replace ( "{name}", $name, $mask );
		$details = str_replace ( "{id}", $id, $details );

		eval("\$quickstats_bit .= \"" . $vwartpl->get("statistics_quickstatsbit") . "\";");

		if ( $count == $numstats )
		{
			break;
		}
		$last = $num;
	}

	eval("\$quickstats = \"" . $vwartpl->get("statistics_quickstats") . "\";");

  // return
  return $quickstats;

}
## -------------------------------------------------------------------------------------------------------------- ##
function getTextRestrictions ($form="vwarform",$textfield="warinfo",$bgcolor="{firstaltcolor}",$afterbbcode=1)
{
	global $vwartpl,$vwarmod;
	global $smiliecode,$htmlcode,$bbcode,$vwarmod;
	global $allowsmilies,$allowhtml,$allowbbcode,$clickable_bbcode,$clickable_smilies,$nextcolor,$vwarmod;
	global $str,$vwarmod;

	//smilie
	if ($smiliecode == 1)
	{
		$clickable_smilies = clickable_smilies($form,$textfield,3,9);
		eval("\$allowsmilies = \"".$vwartpl->get("smilieson")."\";");
	} else {
		eval("\$allowsmilies = \"".$vwartpl->get("smiliesoff")."\";");
	}

	//html
	if ($htmlcode == 1)
	{
		eval("\$allowhtml = \"".$vwartpl->get("htmlcodeon")."\";");
	} else {
		eval("\$allowhtml = \"".$vwartpl->get("htmlcodeoff")."\";");
	}

	//bbcode
	if ($bbcode == 1)
	{
		$clickable_bbcode = clickable_bbcode($form,$textfield,$bgcolor);

		for ($i = 1; $i <= $afterbbcode; $i++)
		{
			$nextcolor[$i] = ($bgcolor == "{firstaltcolor}") ? "{secondaltcolor}" : "{firstaltcolor}";
			$bgcolor = $nextcolor[$i];
		}
		eval("\$allowbbcode = \"".$vwartpl->get("bbcodeon")."\";");

	} else {
		$nextcolor[1] = $bgcolor;

		for ($i = 2; $i <= $afterbbcode; $i++)
		{
			$nextcolor[$i] = ($bgcolor == "{firstaltcolor}") ? "{secondaltcolor}" : "{firstaltcolor}";
			$bgcolor = $nextcolor[$i];
		}
		eval("\$allowbbcode = \"".$vwartpl->get("bbcodeoff")."\";");

	}
}
## -------------------------------------------------------------------------------------------------------------- ##
function getIcons ($checkedicon="",$background="{firstaltcolor}",$iconsperline=7,$formfieldname="iconid")
{
global $vwardb,$n,$vwartpl,$str,$vwarmod;

	$result = $vwardb->query("
		SELECT filename,smilieid
		FROM vwar".$n."_smilie
		WHERE icon = '1' AND deleted = '0'
	");
	$numicons = $vwardb->num_rows($result);
	if ($numicons > 0)
	{
		$linecounter = 0;
		while ($row = $vwardb->fetch_array($result))
		{
			$linecounter++;
			$linecheck = $linecounter % $iconsperline;
			if ($linecheck == 1 || $linecounter == 1)
			{
				$iconbits .= "<tr><td>";
			} else {
				$iconbits .= "    ";
			}
			if($row['smilieid'] == $checkedicon)
			{
				$checked = "checked";
				$onechecked = true;
			} else {
				$checked = "";
			}
			eval("\$iconbits .= \"".$vwartpl->get("comment_icons_iconbit")."\";");
			if ($linecheck == 0 || $linecounter == $numicons)
			{
				$iconbits .= "</td></tr>";
			}
		}
	} else {
		$iconbits = "<normalfont>".$str['NOTAVAILABLE']."</normalfont>";
	}

	if (!$onechecked)
	{
		$nochecked = "checked";
	}

	eval("\$clickable_icons = \"".$vwartpl->get("comment_icons")."\";");

	return $clickable_icons;
}
## -------------------------------------------------------------------------------------------------------------- ##
function checkRegistered ($name="", $mail="")
{
	global $vwardb,$n,$vwarmod;

	if ( $name == "" )
	{
		return true;
	}
	
	if ( trim($mail) != "" )
	{
		$mailpart = " OR email = '" . $mail . "'";
	}

	$get = $vwardb->query_first("
		SELECT COUNT(memberid) AS nummembers
		FROM vwar".$n."_member
		WHERE name = '". $name ."'" . $mailpart
	);

	if ($get['nummembers'] == 0)
	{
		return true;
	}
	else
	{
		return false;
	}
}
## -------------------------------------------------------------------------------------------------------------- ##
function countComments($sourceid,$frompage)
{
	global $vwardb,$n,$vwarmod;

	$numcomments = $vwardb->query_first("
		SELECT COUNT(commentid) AS num
		FROM vwar".$n."_comments
		WHERE frompage = '$frompage'
		AND sourceid = '$sourceid'
	");

	return $numcomments['num'];
}
## -------------------------------------------------------------------------------------------------------------- ##
function convertSearchString($arg, $fields, $exact=0, $highlight=1) {

	// check for exact / partial
	if ($exact == 1)
	{
		$start_not = " != '";
		$start     = " = '";
		$end       = "'";
	} else {
		$start_not = " NOT LIKE '%";
		$start     = " LIKE '%";
		$end       = "%'";
	}

	// get the quoted parts
	$quoted = explode('\\"', $arg);

	for ($i = 0; $i < count($quoted); $i++)
	{
		if ($i == 0 && !$quoted[$i])
		{
			$begin = true;
			$i++;
		} /* end if */

		// part is quoted, we insert it as a phrase
		if ($begin == true)
		{

			$words[] = $quoted[$i];

			// part isn't quoted, we insert it word for word
		} else {

			$phrase = explode (" ", $quoted[$i]);

			for ($z = 0; $z < count($phrase); $z++)
			{

				if (!empty($phrase[$z]))
				{
					$words[] = $phrase[$z];
				} /* end if */

			} /* end for */

		} /* end else */

		// set $begin to opposite of its value
		$begin = !$begin;

	} /* end for */

	// get the words
	for ($i = 0; $i < count($words); $i++)
	{

		if (!empty($words[$i]))
		{

			if ($words[$i] == "AND" || $words[$i] == "OR" || $words[$i] == "NOT")
			{

				if ($words[$i] == "NOT")
				{

					$i++;
					for ($z = 0; $z < count($fields); $z++)
					{

						$inlinecount1++;
						$out .= ($inlinecount1 == 1) ? " AND (" : " OR ";
						$out .= $fields[$z] . $start_not . str_replace("*", "%", $words[$i]) . $end;

					} /* end for */
					$out         .= ")";
					$inlinecount1 = 0;

				}
				else if ($i > 0)
				{

					$out  .= " " . $words[$i] . " ";

					$check = true;

				} /* end else if */

			}
			else
			{

				// highlite
				if ($highlight == 1)
				{
					$theword    = "/" . preg_quote($words[$i], "/") . "/i";
					$highlite[] = str_replace("\*","(.)?",$theword);
				}

				for ($z = 0; $z < count($fields); $z++)
				{

					$inlinecount2++;

					if (!$check && $inlinecount2 == 1)
					{
						$out .= " AND ";
					}
					$out .= ($inlinecount2 == 1) ? "(" : " OR ";
					$out .= $fields[$z] . $start.str_replace("*", "%", $words[$i]) . $end;

					$check = false;

				} /* end for */

				$out         .= ")";
				$inlinecount2 = 0;

			} /* end else */

		} /* end if */

	} /* end for */

	// get words to highlite
	if ($highlight == 1)
	{
		$output[] = join("|||", $highlite);
		$output[] = $out;
	} else {
		$output   = $out;
	} /* end else */

	return $output;
}
## -------------------------------------------------------------------------------------------------------------- ##
function guestData(&$array,$fields="",$set=0)
{
    global $GPC,$vwarmod;
    if(!is_array($array) || !is_array($fields) || !function_exists("base64_encode") || !function_exists("base64_decode")) return;

    // get/set guest data
    if($set == 1)
    {
        foreach($fields as $id => $name)
        {
            $array[$name] = str_replace("~~~","~",$array[$name]);
        }

        // create string
        $string = base64_encode(
            $array[$fields["guestname"]]."~~~".$array[$fields["guestemail"]]."~~~".
            $array[$fields["guesthomepage"]]."~~~".$array[$fields["guestaim"]]."~~~".
            $array[$fields["guestyim"]]."~~~".$array[$fields["guesticq"]]."~~~".
            $array[$fields["guestmsn"]]);

        // set cookie
        SetVWarCookie("vwarguestdata",$string,0);
    }
    elseif($set == 0)
    {
        $string = explode("~~~",base64_decode($GPC["vwarguestdata"]));
        $array[$fields["guestname"]] = $string[0];
        $array[$fields["guestemail"]] = $string[1];
        $array[$fields["guesthomepage"]] = $string[2];
        $array[$fields["guestaim"]] = $string[3];
        $array[$fields["guestyim"]] = $string[4];
        $array[$fields["guesticq"]] = $string[5];
        $array[$fields["guestmsn"]] = $string[6];
    }
}
?>