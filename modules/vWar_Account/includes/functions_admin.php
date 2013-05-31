<?php
/* #####################################################################################
 *
 * $Id: functions_admin.php,v 1.67 2004/07/08 10:08:00 rob Exp $
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
 * includes/functions_admin.php
 * ------------------------------------------------------------------------------------
 * functions used in the admin control panel (back-end)
*/

## -------------------------------------------------------------------------------------------------------------- ##
// beware of cross-site-scripting attacks
if (VWAR_COMMON_INCLUDED != 1)
{
	die("<p style=\"FONT-FAMILY:verdana,tahoma,arial,sans-serif;FONT-SIZE:13px;\">Hacking attempt!</p>\n");
}
$vwar_root = "modules/vWar_Account/";

## -------------------------------------------------------------------------------------------------------------- ##

$vwartpladmin   = 1;
$admintemplates = 1;

## -------------------------------------------------------------------------------------------------------------- ##

// define some important language vars
$languages = array(
	"danish"   => "Danish",
	"dutch"    => "Dutch",
	"english"  => "English",
	"french"   => "French",
	"german"   => "German",
	"italian" => "Italian",
	"portuguese" => "Portuguese",
	"spanish"  => "Spanish",
	"hungarian" => "Hungarian"
);

$monthnames = array(
	"1" => "January",
	"2" => "February",
	"3" => "March",
	"4" => "April",
	"5" => "May",
	"6" => "June",
	"7" => "July",
	"8" => "August",
	"9" => "September",
	"10" => "October",
	"11" => "November",
	"12" => "December"
);

$weekdaynames = array(
	"Su",
	"Mo",
	"Tu",
	"Wed",
	"Thu",
	"Fri",
	"Sa"
);

## -------------------------------------------------------------------------------------------------------------- ##

// set shutdown function for proper backup
//if ($ab_enabled)
//{
//	register_shutdown_function("doAutoBackup");
//}

## -------------------------------------------------------------------------------------------------------------- ##

// get upload class
if (!class_exists("upload"))
{
	require($vwar_root ."/includes/classes/class_upload.php");
	$upload = new upload;

	// allowed extensions for the image uploads
	// important: at the moment (01/03/2004), php only supports jp(e)g, png and gif!
	$upload->ext_array = array(".jpg",".jpeg",".png",".gif");
}

## -------------------------------------------------------------------------------------------------------------- ##
function checkPermission($permissionarea,$memberid="",$continue=0)
{
	global $vwardb,$vwartpl,$n,$GPC,$vwarmod;

	$permission  = false;

	if (strpos($permissionarea,"+"))
	{
		$and         = true;
		$permissions = explode("+", $permissionarea);
		$perquery    = join(",", $permissions);
	}
	else
	{
		$and         = false;
		$permissions = explode("-", $permissionarea);
		$perquery    = join(",", $permissions);
	}

	$row = $vwardb->query_first("
		SELECT $perquery
		FROM vwar".$n."_member, vwar".$n."_accessgroup
		WHERE vwar".$n."_member.accessgroupid = vwar".$n."_accessgroup.accessgroupid
		AND ismember = '1'
		AND memberid = '".$GPC["vwarid"]."'",MYSQL_NUM);

	for ($i = 0; $i < count($permissions); $i++)
	{
		if ($and === true)
		{
			if ($row[$i] == 1)
			{
				$permission = true;
			} else {
				$permission = false;
				break;
			}
		}
		else
		{
			if ($row[$i] == 1)
			{
				$permission = true;
				break;
			} else {
				$permission = false;
			}
		}
	}

	if ($GPC["vwarid"] == $memberid && $permissionarea == "caneditmember")
	{
		$permission = true;
	}

	if ($permission == true)
	{
		return true;
	}
	else if($continue == 1)
	{
		return false;
	}
	else
	{
		global $vwartpl,$vwarmod;

		$contactsavailable 	= 0;
		$contactline 				= "";

		$result = $vwardb->query("
			SELECT name,email,icq
			FROM vwar".$n."_member,vwar".$n."_accessgroup
			WHERE vwar".$n."_member.accessgroupid = vwar".$n."_accessgroup.accessgroupid
			AND vwar".$n."_accessgroup.isadmin = '1'
			AND ismember = '1'
		");
		while ($contact = $vwardb->fetch_array($result))
		{

		$contactline .= "<b>" . $contact["name"] . "</b>";

		if ($contact["email"] != "")
		{
			$contactline .= "<br><small>eMail: " . makelink("mailto:" . $contact["email"],"<small>" . $contact["email"] . "</small>");
		}
		if ($contact["icq"] && $contact["icq"]!=0)
		{
			$contactline .= "<br>ICQ: " . $contact["icq"] . "</small>";
		}
		$contactline.="<br><br>\n";

		}
		if ($vwardb->num_rows($result) == 0)
		{
			$contactline = "<font color=\"#FF0000\"><b>No contacts available!</b></font>";
		}

		
	echo"<table cellpadding=\"5\" cellspacing=\"0\" border=\"0\" width=\"100%\" align=\"center\" class=\"tblborder\">
	<tr>
	<td class=\"tblheaderror\" width=\"100%\"><Big><font size=\"36\" color=\"FF0000\">VWar Error Message</font></BIG></td>
		</tr>
	<tr>
		<td class=\"firstalt\" width=\"100%\" align=\"center\">
			<br /><b>No Permission to access the requested page!</b><hr width=\"30%\">
			To get access you can contact any of the following persons:<br /><br />$contactline
		</td>
	</tr>
</table>";
		//eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_error_nopermission")."\");");
		CloseTable();
		include("footer.php");
		die();
	}
}
## -------------------------------------------------------------------------------------------------------------- ##
function splitfonttag($tag,$name)
{
	global $font;

	$tag = str_replace("&gt;","",$tag);
	$tag = str_replace("&lt;","",$tag);
	$tag = str_replace("&quot;","",$tag);
	$tag = explode("font ",$tag);

	// make style
	$style = split("style=",strtolower($tag[1]));
	$font["style"] = str_replace("style=","",$style[1]);

	// make class
	$class = explode("class=",strtolower($tag[1]));
	$font["class"] = str_replace("class=","",$class[1]);

	// make color
	$color = explode("color=",strtolower($tag[1]));
	$font["color"] = trim($color[1]);

	// make size
	$size = explode("size=",strtolower($color[0]));
	$font["size"] = trim($size[1]);

	// make face
	$face = explode("face=",strtolower($size[0]));
	$font["face"] = trim($face[1]);

 return $font;
}
## -------------------------------------------------------------------------------------------------------------- ##
function getLimitClause ( )
{

 // global vars
 global $GPC;

	// limit ...
	if ( strtolower($GPC["page"]) == "all" )
	{
		$limit = "";
	}
	else
	{
	 global $perpage;

		$s     = ( !empty($GPC["s"]) ) ? $GPC["s"] : 0;
		$limit = "LIMIT " . $s . ", " . $perpage;
	}

 // return
 return $limit;

}
## -------------------------------------------------------------------------------------------------------------- ##
function dofonttag($fontarray)
{
	global $fonttag;

	if ($fontarray["style"]=="" || $fontarray["class"] == "")
	{
		$fonttag="<font face=\"$fontarray[face]\" size=\"$fontarray[size]\" color=\"$fontarray[color]\">";
	}

	if ($fontarray["style"] != "" && $fontarray["class"] == "")
	{
		$fonttag = "<font style=\"$fontarray[style]\">";
	}
	else if ($fontarray["class"]!="")
	{
		$fonttag = "<font class=\"$fontarray[class]\">";
	}

	return htmlspecialchars($fonttag);
}
## -------------------------------------------------------------------------------------------------------------- ##
function switchColors($start=1)
{
	global $altcolor;
	static $colourcounter;

	$altcolor = ($colourcounter++ % 2 != $start ? "firstalt" : "secondalt");

	return $altcolor;
}
## -------------------------------------------------------------------------------------------------------------- ##
function makeyesnocode($name,$value=1,$type=1)
{
	if ($type==0)
	{
		$code = "<p><input type='radio' name='$name' value='1' "
			. ifelse($value == 1,"checked","") . "> <b>Yes</b> <input type='radio' name='$name' value='0' "
			. ifelse($value == 0,"checked","") . "> <b>No</b>"
			. "</p>";
	}
	else if ($type == 1)
	{
		$code= "<select class='input3' name='$name'><option value='1' "
				. ifelse($value == 1,"selected","") . ">Yes&nbsp;&nbsp;&nbsp;&nbsp;</option><option value='0' "
				. ifelse($value == 0,"selected","") . ">No&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>"
				. "</select>";
	}
	else if ($type == 2)
	{
		$code = "<input type='checkbox' name='$name' value='1' " . ifelse($value == 1,"checked","") . ">";
	}

	return $code;
}
## -------------------------------------------------------------------------------------------------------------- ##
function clickable_smilies ($formname="vwarform",$textfieldname="warinfo",$num_per_row=5,$maxsmilies=10)
{
	global $vwartpl,$vwardb,$n,$str,$vwar_root,$vwarmod;

	$result = $vwardb->query_first("SELECT COUNT(smilieid) AS numsmilies FROM vwar".$n."_smilie WHERE deleted = '0'");
	$totalsmilies = $result['numsmilies'];
	$count = 0;
	$result = $vwardb->query("SELECT * FROM vwar".$n."_smilie	WHERE deleted = '0' AND smilie = '1' LIMIT $maxsmilies");
	while ($row = $vwardb->fetch_array($result))
	{
		$count++;
		$smiliesbit .= ifelse($count % 1 OR $count == 1, "\t\t\t\t\t\t\t\t\t\t<tr>\r\n");
		$current_smilie = makeimgtag($vwar_root ."/images/smilies/".$row["filename"]."", $row['title']);

		eval("\$smiliesbit .= \"".$vwartpl->get("admin_smilies_clickablebit")."\r\n\";");

		if ($count == ($num_per_row))
		{
			$count = 0;
			$smiliesbit .= "\t\t\t\t\t\t\t\t\t\t</tr>\n";
		}
	}
	$morelink = popupwin("../../../modules.php?name=vwar&file=popup&action=smilies&amp;form=$formname&amp;field=$textfieldname", "more");

	eval("\$smilies = \"".$vwartpl->get("admin_smilies_clickable")."\";");

	return $smilies;
}
## -------------------------------------------------------------------------------------------------------------- ##
function clickable_bbcode($formname,$textfieldname,$bgcolor="firstalt")
{
	global $vwartpl, $modus, $vwar_root,$vwarmod;

	if (isset($modus))
	{
		$modechecked[$modus] = "checked";
	}	else {
		$modechecked[0] = "checked";
	}

	eval("\$bbcode_language = \"".$vwartpl->get("admin_bbcode_language")."\";");
	eval("\$bbcode_javascript = \"".$vwartpl->get("bbcode_javascript")."\";");

	$bbcode_help = popupwin("../../../modules.php?name=vwar&file=popup&action=bbcode&amp;form=$formname&amp;field=$textfieldname", makeimgtag($vwar_root ."/images/bbcode/help.gif",$str["BBCODE"]." ".$str["HELP"]));

	eval("\$bbcode = \"".$vwartpl->get("admin_bbcode")."\";");

	return $bbcode;
}
## -------------------------------------------------------------------------------------------------------------- ##
function makepagelinks($numentries,$perpage,$arg="")
{
	global $s_prev,$s_next,$s_last,$page_prev,$page_next,$vwartpl,$GPC,$page,$s;

	$page = $GPC['page'];
	$s = $GPC['s'];

	$numpages = ceil($numentries / $perpage);
	if ($numpages == 0) $numpages = 1;

	if (!isset($page) || empty($page)) $page = 1;
	if (!empty($arg)) $arg = "&".$arg;

	if($page > 1 && $numpages > 1 && $page != "All")
	{
		$s_prev = $s - $perpage;
		$page_prev = $page - 1;
		eval("\$pagenav .= \"".$vwartpl->get("admin_pagenav_prevlinks")."\";");
	}

	if ($page == 1)
	{
		$pagenav .= "&nbsp;";
	}
	if ($numpages > 1 && $page != "All")
	{
		$pagenav .= "<a class=\"small\" href=\"" . $GPC['PHP_SELF'] . "?s=0&amp;page=All" . $arg . "\" title=\"Show All\">All</a>&nbsp;";
	}
	else if ($page == "All")
	{
		$pagenav .= "&nbsp;(<b>All</b>)&nbsp;";
	}

	if ($page > 5 && $numpages > 10) $start = $page - 5;
	else $start = 1;

	if ($numpages > 10 && (($start + 9) < $numpages)) $end = $start + 9;
	else $end = $numpages;

	for ($i = $start; $i <= $end; $i++)
	{
		$min = ($i * $perpage) - $perpage;

		if ($page == $i || $numpages == 1) $pagenav .= "[<b>".$i."</b>]&nbsp;";
		else
		{
			$pagenav .= "<a class=\"small\" href=\"".$GPC['PHP_SELF']."?s=".$min."&amp;page=".$i.$arg."\" title=\"\">".$i."</a>";

			if ($i < $numpages) $pagenav .= "&nbsp;";
		}
	}
	if ($page < $numpages && $page != "All")
	{
		$s_next = $s + $perpage;
		$page_next = $page + 1;
		$s_last = ($numpages - 1) * $perpage;
		eval("\$pagenav .= \"".$vwartpl->get("admin_pagenav_nextlinks")."\";");
	}
	if ($page == "All") $pagenav .= "&nbsp;";

	eval("\$pagelinks = \"".$vwartpl->get("admin_pagenav")."\";");

	return $pagelinks;
}

## -------------------------------------------------------------------------------------------------------------- ##
function doCountrySelect($selected="")
{
	global $vwar_root;

	include($vwar_root ."/includes/language/english.inc.php");

	$countryselect = "<option value=\"\">Please choose</option>\n";
	$countryselect .= "<option value=\"\">-------------------------</option>\n";

	asort($country_array);
	reset($country_array);

	while (list($countrycode,$countryname) = each($country_array))
	{
		$countryselect .= "<option value=\"".$countrycode."\" " . ifelse($selected == $countrycode, "selected") . ">" . $countryname . "</option>\n";
	}
	return $countryselect;
}

function doSexSelect($selected="")
{
	global $vwar_root;

	include($vwar_root ."/includes/language/english.inc.php");

	$secselect = "<option value=\"\">Please choose</option>\n";
	$sexselect .= "<option value=\"\">-------------------------</option>\n";

	asort($sex_array);
	reset($sex_array);

	while (list($sexcode,$sexname) = each($sex_array))
	{
		$sexselect .= "<option value=\"".$sexcode."\" " . ifelse($selected == $sexcode, "selected") . ">" . $sexname . "</option>\n";
	}
	return $sexselect;
}
## -------------------------------------------------------------------------------------------------------------- ##
function sendMemberMail($targetgroup,$text,$groups,$replacement="",$type="text",$subject="",$from="",$priority=3)
{
	global $vwardb,$n,$ownmail,$ownname,$vwarversion,$vwarid,$allowmails,$vwarmod;

	if($allowmails != "1") return false;

	// check and replacement
	if (!is_array($groups) || empty($targetgroup) || empty($type) || empty($text))
	{
		return false;
	}
	if (!empty($replacement) && is_array($replacement))
	{
		foreach ($replacement as $search => $replace)
		{
			$text = str_replace("[".$search."]", (($type=="text") ? rehtmlspecialchars($replace) : $replace), $text);
		}
	}

	// get mail addresses
	$targetgroup = strtolower($targetgroup);
	if ($targetgroup == "group" || $targetgroup == "allgroups")
	{
		// select type
		if ($targetgroup == "group" && sizeof($groups) > 0)
		{
		$templist = implode("','",$groups);
			$result = $vwardb->query("SELECT teamid FROM vwar".$n."_emailgroupmember WHERE groupid IN ('$templist')");
			if ($vwardb->num_rows($result) == 0)
			{
				return false;
			}
			while ($row = $vwardb->fetch_array($result))
			{
				$teamlist .= $row["teamid"] . "','";
			}

			$vwardb->free_result($result);
			unset($row);
		}
		else if ($targetgroup == "allgroups")
		{
			$result = $vwardb->query("SELECT teamid FROM vwar".$n."_emailgroupmember");
			if ($vwardb->num_rows($result) == 0)
			{
				return false;
			}
			while($row = $vwardb->fetch_array($result))
			{
				$teamlist .= $row["teamid"] . "','";
			}

			$vwardb->free_result($result);
			unset($row);
		}
		else
		{
			return false;
		}

		$teamlist = substr($teamlist,0,strlen($teamlist)-3);
		$result = $vwardb->query("
			SELECT vwar".$n."_member.memberid,name,email
			FROM vwar".$n."_teammember
			LEFT JOIN  vwar".$n."_member ON (vwar".$n."_teammember.memberid = vwar".$n."_member.memberid)
			WHERE vwar".$n."_teammember.teamid IN ('".$teamlist."')");
			if ($vwardb->num_rows($result) == 0)
			{
				return false;
			}
		}
		else if ($targetgroup == "member")
		{
			$templist = implode("','",$groups);
			$result = $vwardb->query("SELECT memberid,name,email FROM vwar".$n."_member WHERE memberid IN ('$templist')");
			if ($vwardb->num_rows($result) == 0)
			{
				return false;
			}
		}
		else if ($targetgroup == "allmembers")
		{
			$result = $vwardb->query("SELECT memberid,name,email FROM vwar".$n."_member");
			if ($vwardb->num_rows($result) == 0)
			{
				return false;
			}
		}
		else
		{
			return false;
		}

		// mail header
		/* BUG: problems if $ownname contains slashes, quotes, etc., no solution so far... 2004-05-08
		$from 		= empty($from) ? "\"" . addslashes($ownname) . " VWar\" <$ownmail>" : $from;
		*/
		$from           = empty($from) ? $ownmail : $from;
		$subject	= empty($subject) ? $ownname . " Virtual War - Mail" : $subject;
		$html		= strtolower($type) == "html" ? "MIME-Version: 1.0\r\nContent-Type: text/html; charset=iso-8859-1\r\n" : "";

		$header   = "From: " . $from . "\r\n" . $html;
		$header  .= "X-Priority: " . $priority . "\r\n";
		$header  .= "X-Mailer: VWar v" . $vwarversion . " (PHP v" . phpversion() . ")\r\n";
		$header  .= "X-Comment: mail (automatically) generated at " . date("m/d/Y, H:i:s a",time()) . "\r\n";

		// send mail
		while ($row = $vwardb->fetch_array($result))
		{
			$temptext = str_replace("[target_user]",$row["name"],$text);
			if (checkMail($row["email"]))
			{
				/* BUG: problems if $row["name"] contains slashes, quotes, etc.,
				   no solution so far... 2004-05-08
				mail("\"" . addslashes($row["name"]) . "\" <" . $row["email"] . ">",$subject,$temptext,$header);
				*/
				mail($row["email"],$subject,$temptext,$header);
			}
		}

		return true;
}
## -------------------------------------------------------------------------------------------------------------- ##
function createWarMail($groups,$warid,$type)
{
	global $vwardb,$n,$vwartpl,$ownname,$ownnameshort,$ownhomepage,$urltovwar,
					$warmailhtml,$warmailsubjectnew,$warmailsubjectchanged,$warmailpriority,$vwarid,$vwarmod;

	if (!is_array($groups) || empty($warid) || empty($type))
	{
		return;
	}

	// get details
	$data = $vwardb->query_first("
		SELECT
		vwar".$n.".playerperteam, info, serverpassword, dateline,
		vwar".$n."_matchtype.matchtypename,
		vwar".$n."_gametype.gametypename,
		vwar".$n."_games.gamename,
		vwar".$n."_member.name,
		vwar".$n."_server.servername,serverip,
		vwar".$n."_opponents.oppname,oppnameshort,opphomepage
		FROM vwar".$n."
		LEFT JOIN vwar".$n."_matchtype ON (vwar".$n."_matchtype.matchtypeid = vwar".$n.".matchtypeid)
		LEFT JOIN vwar".$n."_gametype ON (vwar".$n."_gametype.gametypeid = vwar".$n.".gametypeid)
		LEFT JOIN vwar".$n."_games ON (vwar".$n."_games.gameid = vwar".$n.".gameid)
		LEFT JOIN vwar".$n."_member ON (vwar".$n."_member.memberid = '$vwarid')
		LEFT JOIN vwar".$n."_server ON (vwar".$n."_server.serverid = vwar".$n.".serverid)
		LEFT JOIN vwar".$n."_opponents ON (vwar".$n."_opponents.oppid = vwar".$n.".oppid)
		WHERE vwar".$n.".warid = '$warid'
	");
	foreach($data as $field => $content)
	{
		if($field != "name" || $field != "dateline")
		{
			$tempreplace[$field] = $content;
		}
	}

	// fetch maps
	$result = $vwardb->query("
		SELECT
		vwar".$n."_scores.locationid,
		vwar".$n."_locations.locationname
		FROM vwar".$n."_scores
		LEFT JOIN vwar".$n."_locations ON (vwar".$n."_scores.locationid = vwar".$n."_locations.locationid)
		WHERE vwar".$n."_scores.warid = '$warid'
	");
	while ($row = $vwardb->fetch_array($result))
	{
		$maps .= $row["locationname"].", ";
	}
	$maps = substr($maps,0,strlen($maps)-2);
	$vwardb->free_result($result);

	// add/check replacments
	$tempreplace["ownname"] = $ownname;
	$tempreplace["ownnameshort"] = $ownnameshort;
	$tempreplace["ownhomepage"] = $ownhomepage;
	$tempreplace["added_by"] = $data["name"];
	$tempreplace["updated_by"] = $data["name"];
	$tempreplace["maps"] = $maps;
	$tempreplace["opphomepage"] = ifelse(empty($tempreplace["opphomepage"]) || $tempreplace["opphomepage"] == "http://","n/a",$tempreplace["opphomepage"]);
	$tempreplace["servername"] = ifelse(empty($tempreplace["servername"]),"n/a",$tempreplace["servername"]);
	$tempreplace["serverip"] = ifelse(empty($tempreplace["serverip"]),"n/a",$tempreplace["serverip"]);
	$tempreplace["info"] = ifelse(empty($tempreplace["info"]),"n/a",$tempreplace["info"]);
	$tempreplace["join_link"] = checkPath(checkUrlFormat($urltovwar))."war.php?action=nextaction#".$warid;
	$tempreplace["day"] = date("d",$data["dateline"]);
	$tempreplace["day_extend"] = date("jS",$data["dateline"]);
	$tempreplace["month"] = date("m",$data["dateline"]);
	$tempreplace["year"] = date("Y",$data["dateline"]);
	$tempreplace["hour"] = date("H",$data["dateline"]);
	$tempreplace["minute"] = date("i",$data["dateline"]);
	$tempreplace["weekday"] = date("l",$data["dateline"]);
	$tempreplace["month_name"] = date("F",$data["dateline"]);
	unset($maps);
	unset($data);

	// get template
	$type = strtolower($type);
	if ($type == "new")
	{
		eval("\$text = \"".$vwartpl->get("message_mail_newwar")."\";");
		$subject = $warmailsubjectnew;
	}
	else if ($type == "changed")
	{
		eval("\$text = \"".$vwartpl->get("message_mail_changedwar")."\";");
		$subject = $warmailsubjectchanged;
	}
	else
	{
		return;
	}

	// execute mail process
	if ($groups[0] == "allmembers")
	{
		$grouptype = "allmembers";
	}
	else if ($groups[0] == "allgroups")
	{
		$grouptype = "allgroups";
	}
	else
	{
		$grouptype = "group";
	}

	if ($warmailhtml == 1)
	{
		$sendtype = "html";
		$text = nl2br($text);
	}	else {
		$sendtype = "text";
	}

	sendMemberMail($grouptype,$text,$groups,$tempreplace,$sendtype,$subject,"",$warmailpriority);
}
## -------------------------------------------------------------------------------------------------------------- ##
function fileReader($path,$getheader=0,$mode="rb")
{
 global $vwartpl,$vwarmod;

	$file = @fopen($path, $mode);

	if (!$file)
	{
		if ($getheader)
		{
			eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
		}
		eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_error_fileupload")."\");");
		exit;
	}
	$content = fread($file,filesize($path));
	fclose($file);

 return $content;
}
## -------------------------------------------------------------------------------------------------------------- ##
function getFileContent($path,$header=0,$mode="rb")
{
 global $vwartpl,$vwarmod;

	$obd     = "";
	$obd     = @ini_get('open_basedir');
	
	if (empty($obd))
	{
		$obd = @get_cfg_var('open_basedir');
	}

	if (!empty($obd))
	{
		if(defined("PHP_OS") && eregi("win", PHP_OS)) {
			$tmp = '.\\tmp\\';
		} else {
			$tmp = './tmp/';
		}
		
		if(!is_writeable($tmp))
		{
			$content = fileReader($path);
		}
		else
		{
			$new_path = $tmp . basename($path);
			move_uploaded_file($path, $new_path);
			$content = fileReader($new_path);
			unlink($new_path);
		}
	}
	else
	{
		$content = fileReader($path,$mode);
	}

 return $content;
}
## -------------------------------------------------------------------------------------------------------------- ##
function getSendHeader($filename)
{

 global $GPC,$vwarmod;

	$mime_type = (ereg("MSIE ([0-9].[0-9]{1,2})", $GPC["HTTP_USER_AGENT"]) || ereg("Opera(/| )([0-9].[0-9]{1,2})", $GPC["HTTP_USER_AGENT"]))
									? 'application/octetstream'
									: 'application/octet-stream';
	$now = gmdate('D, d M Y H:i:s') . ' GMT';
	header('Content-Type: '.$mime_type);
	header('Expires: '.$now);
	if (ereg("MSIE ([0-9].[0-9]{1,2})", $GPC["HTTP_USER_AGENT"]))
	{
		header('Content-Disposition: inline; filename="'.$filename.'"');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
	} else {
		header('Content-Disposition: attachment; filename="'.$filename.'"');
		header('Pragma: no-cache');
	}

}
## -------------------------------------------------------------------------------------------------------------- ##
function getTextRestrictions ($form="vwarform",$textfield="warinfo",$bgcolor="firstalt",$afterbbcode=1, $createclicks=1, $pre="") {

	if ( !empty($pre) )
	{
		$allowsmilies2 = $pre . "allowsmilies";
		$allowhtml2    = $pre . "allowhtml";
		$allowbbcode2  = $pre . "allowbbcode";
	}
	else
	{
		$allowsmilies2 = "allowsmilies";
		$allowhtml2    = "allowhtml";
		$allowbbcode2  = "allowbbcode";
	}

	global $vwartpl,$smiliecode,$htmlcode,$bbcode,${$allowsmilies2},${$allowhtml2},${$allowbbcode2},$clickable_bbcode,
		$clickable_smilies,$nextcolor,$vwarmod;

	//smilie
	if ($smiliecode == 1)
	{
		if ( $createclicks == 1 )
		{
			$clickable_smilies = clickable_smilies($form, $textfield, 3, 9);
		}
		eval("\${\$allowsmilies2} = \"<tr>
		<td><small><A HREF='#'   onClick=window.open('modules.php?name=$vwarmod&file=popup&action=smilies&amp;form=$form&amp;field=$textfield','_blank','width=520,height=520,screenX=100,screenY=100,resizable=yes,menubar=no,locationbar=no,scrollbars=yes')>Smilies</a> are: <b>On</b></small></td>
</tr>\";");
	}
	else
	{
		eval("\${\$allowsmilies2} = \"<tr>
		<td><small><A HREF='#'   onClick=window.open('modules.php?name=$vwarmod&file=popup&action=smilies&amp;form=$form&amp;field=$textfield','_blank','width=520,height=520,screenX=100,screenY=100,resizable=yes,menubar=no,locationbar=no,scrollbars=yes')>Smilies</a> are: <b>Off</b></small></td>
</tr>\";");
	}

	//html
	if ($htmlcode == 1)
	{
		eval("\${\$allowhtml2} = \"<tr>
		<td><small>HTML is: <b>On</b></small></td>
</tr>\";");
	}
	else
	{
		eval("\${\$allowhtml2} = \"<tr>
		<td><small>HTML is: <b>Off</b></small></td>
</tr>\";");
	}

	//bbcode
	if ($bbcode == 1)
	{
		if ($createclicks == 1)
		{
			$clickable_bbcode = clickable_bbcode($form,$textfield,$bgcolor);
			for ($i = 1; $i <= $afterbbcode; $i++)
			{
				$nextcolor[$i] = ($bgcolor == "firstalt") ? "secondalt" : "firstalt";
				$bgcolor = $nextcolor[$i];
			}
		}
		eval("\${\$allowbbcode2} = \"<tr>
		<td><small><A HREF='#'   onClick=window.open('modules.php?name=$vwarmod&file=popup&action=bbcode&amp;form=vwarform&amp;field=comment','_blank','width=520,height=520,screenX=100,screenY=100,resizable=yes,menubar=no,locationbar=no,scrollbars=yes')>bbCode</a> is: <b>On</b></small></td>
</tr>\";");
	}
	else
	{
		if ($createclicks == 1)
		{
			$nextcolor[1] = $bgcolor;
			for ($i = 2; $i <= $afterbbcode; $i++)
			{
				$nextcolor[$i] = ($bgcolor == "firstalt") ? "secondalt" : "firstalt";
				$bgcolor = $nextcolor[$i];
			}
		}
		eval("\${\$allowbbcode2} = \"<tr>
		<td><small><A HREF='#'   onClick=window.open('modules.php?name=$vwarmod&file=popup&action=bbcode&amp;form=vwarform&amp;field=comment','_blank','width=520,height=520,screenX=100,screenY=100,resizable=yes,menubar=no,locationbar=no,scrollbars=yes')>bbCode</a> is: <b>Off</b></small></td>
</tr>\";");
		
	}
}
## -------------------------------------------------------------------------------------------------------------- ##
function getActiveTag ($arg, $returnname="This item", $activetext=" is active", $inactivetext=" is inactive")
{
	global $vwar_root;

	$active = makeimgtag($vwar_root ."/images/" .
		ifelse($arg == 1, "uncheck.gif", "check.gif"),
		ifelse($arg == 1, $returnname . $inactivetext, $returnname . $activetext));

	return $active;
}
## -------------------------------------------------------------------------------------------------------------- ##
function getMemberLocations($gameid,$memberid,$memberlocationid=0)
{
	global $vwardb,$n,$vwarmod,$vwarmod;

	if($memberlocationid)
	{
		$memberlocation = "AND memberlocationid != '$memberlocationid'";
	}
	$result = $vwardb->query("SELECT locationid FROM vwar".$n."_memberlocation
		WHERE memberid = '".$memberid."'
		AND membergameid = '".$gameid."'
		$memberlocation");
	while ($row = $vwardb->fetch_array($result))
	{
		$idlist .= $row['locationid'].",";
	}
	$vwardb->free_result($result);
	$idlist = str_replace(",", "','", substr($idlist,0,-1));

	return $idlist;
}
## -------------------------------------------------------------------------------------------------------------- ##
function deleteFiles ($expression,$folder)
{
	// if you want to use this function add "&&" at the end
	// of your expression string!

	$dir_handle = dir($folder);
	while($file = $dir_handle->read())
	{
		$file = trim(strtolower($file));
		eval("if($expression\$file != \".htaccess\" && \$file != \".htpasswd\" && !is_dir(\$folder.\$file))
		{
			unlink(\$folder.\$file);
		}");
	}
	$dir_handle->close();
}
## -------------------------------------------------------------------------------------------------------------- ##
/*function doAutoBackup ()
{
	global $vwardb,$n,$HTTP_SERVER_VARS,$vwarmod;

	// get settings
	$settings = $vwardb->query_first("
		SELECT
		ab_tables AS tables2,
		ab_deloldfiles AS deleteold,
		ab_days AS days,
		ab_fallback AS fallback,
		longdateformat
		FROM vwar".$n."_settings
	");

	$root 				= $HTTP_SERVER_VARS['DOCUMENT_ROOT'];
	$script_name	= $HTTP_SERVER_VARS['SCRIPT_NAME'];

	/*
	$self 				= dirname($HTTP_SERVER_VARS['PHP_SELF']);
	$backup_folder  = (substr($root, (strlen($root)-1), 1) != "/") ? $root . "/" : $root;
	$backup_folder .= (substr($self,0,1) == "/") ? substr($self,1) : $self;
	$backup_folder  = (substr($backup_folder, (strlen($backup_folder)-1), 1) != "/") ? $backup_folder . "/" : $backup_folder;
	*/

	// build the path in order to work with open_basedir restrictions
	// we need the depth of the vwar folder	relative to the document root
/*
	$tmp 				= split("/", $script_name);
	$depth			= count($tmp) - (count($tmp) - 2);

	$vwar_root 	= $vwar_root ."/";

	for ($x = 0; $x < (count($tmp) - $depth); $x++)
	{
		$vwar_root .= $tmp[$x] . "/";
	}

	$backup_folder 	= $vwar_root ."/backup/";

	// check settings and create backup object
	if (strlen(trim($settings["days"])) == 0) return;

	if (!class_exists("backup"))
	{
		require ($vwar_root ."/includes/classes/class_backup.php");
	}

	if (function_exists("gzencode"))
	{
		$file_ext = ".sql.gz";
	} else {
		$file_ext = ".sql";
	}

	// create a temporary function
	$createName = create_function('$timestamp,$file_ext','
				$data = array(date("W",$timestamp),date("w",$timestamp),date("d",$timestamp),
								date("m",$timestamp),date("Y",$timestamp));
				return "backup_".$data[0]."_".$data[1]."_".$data[2].$data[3].$data[4].$file_ext;');

		// split up days
	$days = explode("|", chunk_split($settings["days"],1,"|"));
	unset($days[(sizeof($days)-1)]);

	// set vars
	$do_backup         = FALSE;
	$longdateformat    = $settings["longdateformat"];
	$current_day       = date("w");
	$file_name         = $backup_folder . $createName(time(), $file_ext);

	// do backup,
	// but before check for an already existing one
	if (inarray($current_day,$days))
	{
		if (!file_exists($file_name))
		{
			$do_backup = TRUE;
		}
	}
	else
	{
		// check for past days
		// there is maybe a better way to check this
		$current_time = mktime(0,0,0,date("m"),date("d"),date("Y"));
		for ($hour = 1; $hour < ($settings["fallback"] + 1); $hour++)
		{
			$current_time -= 3600;
			$day = date("w", $current_time);

			if (inarray($day,$days))
			{
				$file_name = $backup_folder . $createName($current_time,$file_ext);

				if (!file_exists($file_name))
				{
					$do_backup = TRUE;
					$old_backup_done = TRUE;
				}
				else
				{
					$do_backup = FALSE;
				}

				break;
			}
			else
			{
				// override current day and create a new timestamp
				$oldtime = $current_time;
				$current_time = mktime(0,0,0,date("m",$current_time),date("d",$current_time),date("Y",$current_time));
				$hour += floor(($oldtime - $current_time) / 3600);

				if($hour > $settings["fallback"]) break;
			}
		} // end for
	} // end else

	// now do the real backup
	if ($do_backup)
	{
		$tables = ($settings["tables2"] == "v") ? $vwardb->gettables() : backup::getTables("a");
		$backup = new backup(array("file_name"=>$file_name,"output_mode"=>"f","tables"=>$tables));
		$backup->doBackup();

		if (function_exists("gzencode") && file_exists($file_name))
		{
			$content = fileReader($file_name, 0, "rb", 0);
			$file_handle = fopen($file_name, "w");
			fwrite($file_handle,gzencode($content));
			fclose($file_handle);
		}

		// !! this will delete all old files which are not from this month/week !!
		// !! possible backup data loss. copy files regularly !!
		if (is_writable($backup_folder) && file_exists($file_name) && filesize($file_name) > 0)
		{
			if ($settings["deleteold"])
			{
				$search_for = basename($file_name);
			}
			else
			{
				$search_for = "backup_" . date("W") . "_";
			}

			if (!$old_backup_done)
			{
				$exp = 'strpos($file,"'.$search_for.'") === FALSE &&';
			}
			else
			{
				$exp  = 'strpos($file,"'.$search_for.'") === FALSE &&';
				$exp .= 'strpos($file,"'.basename($file_name).'") === FALSE &&';
			}

			deleteFiles($exp,$backup_folder);
		}
	}
}
*/
## -------------------------------------------------------------------------------------------------------------- ##
function getRemoteFilesize ($url,$override=0)
{
	global $vwartpl,$vwarmod;

	// get host data
	$data = parse_url($url);
	if (empty($data["port"])) $data["port"] = 80;

	// send request to server
	$handle = @fsockopen($data["host"],$data["port"], $errno, $errstr, 10);
	if (!$handle)
	{
		if($override == 1)
		{
			return 32767;
		}
		else
		{
			$file = $url;

			$vwartpl->cache("admin_message_error_remotefile");
			eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
			eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_error_remotefile")."\");");
			exit;
		}
	}
	else
	{
		fputs($handle, "HEAD " . $data["path"] . " HTTP/1.1\r\n");
		fputs($handle, "HOST: " . $data["host"] . "\r\n");
		fputs($handle, "Connection: close\r\n\r\n");

		while (!feof($handle))
		{
			$content = sprintf("%s%s", $content, fgets($handle,1024));
			$tmp = explode("Content-Length: ", $content);
			$size = $tmp[1];
		}
	}

	fclose($handle);
	return abs($size);
}
## -------------------------------------------------------------------------------------------------------------- ##
function checkRights (&$required,&$rights,$mode="OR")
{
	global $GPC,$vwarmod;

	$required = trim($required);
	if (strtolower($GPC["PURE_PHP_SELF"]) != "index.php") return FALSE;

	// split rights and check
	$ok = FALSE;
	$tmp = split(";", $required);

	foreach ($tmp as $req)
	{
		if ($mode == "OR" && (int)$rights[$req] == 1)
		{
			$ok = TRUE;
			break;
		}
		else if ($mode == "AND")
		{
			if ((int)$rights[$req] != 1)
			{
				$ok = FALSE;
				break;
			}
			else
			{
				$ok = TRUE;
			}
		}
	}

	return $ok;
}
## -------------------------------------------------------------------------------------------------------------- ##
function createMenuDropdown ($name,$select="")
{
		global $vwardb,$vwartpl,$n,$vwarmod,$vwarmod;

		$tmp = '<select name="'.$name.'">';
		eval("\$tmp .= \"".$vwartpl->get("admin_selectbitdefault")."\";");

		// get all menu groups
		$result = $vwardb->query("
				SELECT groupid,grouptitle
				FROM vwar".$n."_acpmenugroups
				ORDER BY displayorder,grouptitle ASC");
		while($row = $vwardb->fetch_array($result))
		{
				$tmp .= '<option value="'.$row["groupid"].'"'.($row["groupid"] == $select ? " selected" : "");
				$tmp .= '>'.$row["grouptitle"].'</option>';
		}
		$vwardb->free_result($result);

		return $tmp.'</select>';
}
?>
