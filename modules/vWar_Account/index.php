<?php
/************************************************************************
 * PHP-NUKE: Web Portal System
 * ===========================
 *
 * Copyright (c) 2002 by Francisco Burzi
 * http://phpnuke.org
 *
 * This program is free software. You can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License.
 *
 * $Id: member.php,v 1.125 2004/09/12 12:58:09 mabu Exp $
 * This notice must remain untouched at all times.
 *
 * Modifications to the script, except the official addons or hacks,
 * without the owners permission are prohibited.
 * All rights reserved to their proper authors.
 * ---------------------------------------------
 * http://www.vwar.de || Copyright (C) 2001-2005
 * ---------------------------------------------
 * Modded to fit as a module for use with phpnuke by:
 * XenoMorpH ¤TÐI¤, http://www.tdi-hq.com for:
 * ---------------------------------------------
 * http://www.phpnuke-clan.net || Copyright (C) 2005-2006
 * ---------------------------------------------
 *
 * #####################################################################################
 */
if ( !defined('MODULE_FILE') )
{
	die("You can't access this file directly...");
}


// SETTINGS
//Right blocks: 0=off / 1=on
$index=0;
// what is your vwar folder name?
$vwarfolder = "vwar";
// User can change their Joindate: Set TRUE of YES and FALSE for NO
$chjdate = FALSE;



//END SETTINGS


// get functions
global $username, $nukeurl, $db;
define('VWAR_INCLUDE', true);
$module_name = basename(dirname(__FILE__));
$vwar_root2 = "modules/$vwarfolder/";
$vwar_root = "modules/$module_name/";
$vwar_root3 = $vwar_root;
require($vwar_root2 . "modname.php");
require($vwar_root . "includes/functions_common.php");
require($vwar_root . "includes/functions_admin.php");
require($vwar_root2 . "includes/_config.inc.php");

if (!checkCookie())
{
	header("Location: index.php");
}
//include ( $vwar_root . "includes/get_header.php" );
require ("header.php");

global $user,$vwarmod;
cookiedecode($user);
$uname = $cookie[1];

if (is_user($user)) {
   @include("modules/Your_Account/navbar.php");
   OpenTable();
   nav();
   CloseTable();
   echo "<br>";
  }
  else{
     OpenTable();
   echo "<br><br><center>You are allowed to view this page, because you are a vWar Member but did not login to the site.<br>
   Please login: <a href=\"modules.php?name=Your_Account\">HERE</a><center><br><br><br>";
   CloseTable();
   echo "";
   echo"</body>
</html>";
require ("footer.php");
   exit();
   }
OpenTable();

//$result = $vwardb->query("SELECT memberid, ismember, password FROM vwar".$n."_member WHERE userid = '$uname'");
//$row = mysql_fetch_assoc($result);
//$row = $db->sql_fetchrow($result);

$resid = $vwardb->query_first("SELECT memberid, ismember, password FROM vwar".$n."_member WHERE userid = '$uname'");

// get default language
$result = $vwardb->query_first("SELECT vwarlanguage FROM vwar".$n."_settings");
$vwarlanguage = $result['vwarlanguage'];

// ################################### view member #####################################
if ($GPC['action'] == "viewmember")
{
echo"<table cellpadding=\"5\" cellspacing=\"0\" border=\"0\" align=\"center\" width=\"100%\" class=\"tblborder\">
	<tr>
			<td class=\"tblhead\" colSpan=\"5\">Modify Members</td>
	</tr>
	<tr>
			<td class=\"sectionhead\" width=\"50%\">Membername</td>
			<td class=\"sectionhead\" width=\"50%\">Memberstatus (Customstatus)</td>";
	/*echo"<td class=\"sectionhead\" width=\"50%\">Details</td>
			<td class=\"sectionhead\" width=\"50%\">Access</td>
			<td class=\"sectionhead\" width=\"50%\">Delete</td>
	</tr>";
	*/

	if (isset($GPC['accessgroupid']))
	{
		$display = "AND accessgroupid='" . $GPC['accessgroupid'] . "' ";
	}
	$result = $vwardb->query("
		SELECT * FROM vwar".$n."_member,vwar".$n."_memberstatus
		WHERE vwar".$n."_member.status = vwar".$n."_memberstatus.statusid $display
		ORDER BY displayorder ASC, name ASC
	");
	while ($row = $vwardb->fetch_array($result))
	{
		dbSelect($row);
		$memberstatus = $row['statusname'];
		$row['customstatus'] = ifelse($row['customstatus'], "(" . $row['customstatus'] . ")");
		$hidden = ifelse($row['hidemember'] == 1, makeimgtag($vwar_root . "images/hidden.gif","Hidden Member"), "");
		$nomember = ifelse($row['ismember'] == 0, makeimgtag($vwar_root . "images/nomember.gif","No Member"), "");
		$altcolor = ifelse($GPC['vwarid'] == $row['memberid'], "highlight", switchColors());

echo  "<tr>
	<td class=\"$altcolor\"><b>$row[name]</b> $hidden$nomember</td>
	<td class=\"$altcolor\">$memberstatus $row[customstatus]</td>";
	/*	echo  "<td class=\"$altcolor\" align=\"center\"><a href=\"modules.php?name=$module_name&action=editmember&amp;memberid=$row[memberid]\">Modify</a></td>
	<td class=\"$altcolor\" align=\"center\"><a href=\"modules.php?name=$module_name&action=editaccess&amp;memberid=$row[memberid]\">Modify</a></td>
	<td class=\"$altcolor\" align=\"center\"><a href=\"modules.php?name=$module_name&action=deletemember&amp;memberid=$row[memberid]\">Delete</a></td>
</tr>";
	*/
	}
echo"</table>";

}
// ################################### edit picture ###################################
if ($GPC['action'] == "editpicture") {
	checkPermission("caneditmember",$GPC['memberid']);

	if ($GPC['add'] || $GPC['add_x'])
	{
		$uploadpath = $vwar_root2 . "images/member/";

		$pre = $GPC['memberid']."_";

		$result = $vwardb->query_first("SELECT picture FROM vwar".$n."_member WHERE memberid = '".$GPC['memberid']."'");
		$picture = $result['picture'];

		if ($picturedeleted == 1 || $HTTP_POST_FILES['userfile']['name'])
		{
			$vwardb->query("UPDATE vwar".$n."_member SET picture = '' WHERE memberid = '".$GPC['memberid']."'");
			if (@is_file($uploadpath . $picture) && @file_exists($uploadpath . $picture))
			{
				@unlink($uploadpath . $picture);
			}
			if (@is_file($uploadpath . "th_". $picture) &&  @file_exists($uploadpath . "th_". $picture))
			{
				@unlink($uploadpath .  "th_" . $picture);
			}
		}

		if ($HTTP_POST_FILES['userfile']['name'])
		{
			$upload_check = $upload->doUpload($HTTP_POST_FILES['userfile'], $uploadpath, 1, 0, $pre);
			$vwardb->query("
				UPDATE vwar".$n."_member SET picture = '".$pre . strtolower($HTTP_POST_FILES['userfile']['name'])."'
				WHERE memberid='".$GPC['memberid']."'
			");
		}
		header("Location: modules.php?name=$module_name&action=editmember&memberid=".$GPC['memberid']."");
	}
	else
	{
		$imagepath = $vwar_root2 . "images/member/";

		$result = $vwardb->query_first("SELECT name,picture FROM vwar".$n."_member WHERE memberid = '".$GPC['memberid']."'");
		if ($result['picture'])
		{
			if (@file_exists($imagepath . "th_". $result['picture']))
			{
				$memberpicture = makeimgtag($imagepath . "th_". $result['picture'])."<br>";
			} else {
				//$memberpicture=makeimgtag($imagepath . $result['picture'],"","",$thumbnailwidth,$thumbnailheight)."<br>";
				$memberpicture=makeimgtag($imagepath . $result['picture'])."<br>";
			}
		}
		else
		{
			$memberpicture = "";
		}

		$picturedeleted = makeyesnocode("picturedeleted",0);
		$membername = dbSelect($result['name']);


echo"<form action=\"modules.php?name=$module_name&amp;action=editpicture&amp;memberid=$memberid\" method=\"post\" enctype=\"multipart/form-data\">
<table cellpadding=\"5\" cellspacing=\"0\" border=\"0\" align=\"center\" width=\"100%\" class=\"tblborder\">
	<tr>
			<td class=\"tblhead\" colSpan=\"2\">Modify Picture of ".$membername." </td>
	</tr>
	<tr>
			<td class=\"firstalt\" valign=\"top\" width=\"15%\"><b>Picture</b><br /><br /><small><b>Upload picture:</b><br />point to the local file and<br />click 'modify picture'</small></td>
			<td class=\"firstalt\" nowrap width=\"85%\" valign=\"middle\">$memberpicture<input class=\"input\" name=\"userfile\" type=\"file\"></td>
	</tr>
	<tr>
			<td class=\"secondalt\"><b>Delete</b><br /><small>select 'yes' to delete the current picture</small></td>
			<td class=\"secondalt\">$picturedeleted</td>
	</tr>
	<tr>
			<td class=\"formsubmit\" colSpan=\"2\" align=\"center\"><input type=\"submit\" name=\"add\" value=\"Modify Picture\"></td>
	</tr>
</table>
</form>";

	}
}

// ################################### edit member ####################################
	$requesturl = $_SERVER['REQUEST_URI'];
	$scripturl = $_SERVER["PHP_SELF"];
	if($resid["memberid"] ==''){echo"<center>Your PHPNuke Name is not set to get this module work right. change it <a href=\"modules/vwar/admin\">HERE</a></center>";
	CloseTable ();
	 exit();}
	if($requesturl == "$scripturl?name=$module_name"){
	header("Location: modules.php?name=$module_name&action=editmember&memberid=".$resid["memberid"]."");
	}
	else{
if ($GPC['action'] == "editmember")
{
	checkPermission("caneditmember",$GPC['memberid']);
	// INFORMATION:
	// This part isn't as solved as it should be
	if ($GPC['add'] || $GPC['add_x'] || $modifypicture)
	{
		// check for wrong data
		$emailcheck = $vwardb->query_first("
			SELECT email
			FROM vwar".$n."_member
			WHERE email = '$email'
			AND memberid != '" . $GPC['memberid'] . "'
		");
		if ($name == "" || $userid == "" || $status == "" || $emailcheck["email"] != "")

		{
			echo"<table cellpadding=\"5\" cellspacing=\"0\" border=\"0\" width=\"100%\" align=\"center\" class=\"tblborder\">
	<tr>
		<td class=\"tblheaderror\" width=\"100%\">VWar Error Message</td>
	</tr>
	<tr>
		<td class=\"firstalt\" width=\"100%\" align=\"center\">
			<br /><b>Not all required fields were filled correctly!</b><br />
			Please verify the entered data!<br /><br />
			<a href=\"javascript:history.go(-1)\">Click here to go back</a><br /><br />
		</td>
	</tr>
</table>";
			exit;
		}
		if ($GPC['memberid'] == $GPC['vwarid'])
		{
			if ($language != $GPC['vwarlanguage'])
			{
				SetVWarCookie("vwarlanguage", $language);
			}
		}
		$vwardb->query("
			UPDATE vwar".$n."_member SET
			name = '".$vwarname."',
			realname = '".$realname."',
			birthday = '$year-$month-$day',
			location = '$location',
			country = '$country',
			sex ='$sex',
			email = '$email',
			homepage = '".checkUrlFormat($homepage)."',
			icq = '$icq',
			aim = '$aim',
			yim = '$yim',
			msn = '$msn',
			xfire = '$xfire',
			customstatus = '".$customstatus."',
			status = '$status',
			language = '$language',
			joindate = '$joinyear-$joinmonth-$joinday',
			userid = '$userid',
			wartag = '$wartag',
			signature = '".trim(substr($GPC["signature"],0,2000))."'
			WHERE memberid = '".$GPC['memberid']."'
		");
		$vwardb->query("DELETE FROM vwar".$n."_membergames WHERE memberid = '".$GPC['memberid']."'");

		// update access pw
		$result = $vwardb->query_first("
			SELECT canaccessbackup FROM vwar".$n."_member m,vwar".$n."_accessgroup a
			WHERE m.accessgroupid = a.accessgroupid
		");
		if (!empty($GPC["backuppw"]) && $result["canaccessbackup"] == "1")
		{
			require($vwar_root . "includes/classes/class_htaccess.php");
			$ht = new htaccess($vwar_root . "backup/.htpasswd");

			$ht->modifyUser($GPC["memberid"],$backuppw);
			$ht->commitUserChanges();
			unset($ht);
		}

		$result = $vwardb->query("SELECT * FROM vwar".$n."_games");
		while ($row = $vwardb->fetch_array($result))
		{
			$membergame = "game" . $row['gameid'];
			if ($$membergame == 1)
			{
				$vwardb->query("INSERT INTO vwar".$n."_membergames (gameid, memberid) VALUES ('$row[gameid]', '$GPC[memberid]')");
			}
		}

		if (sizeof($field) > 0)
		{
			while (list($fieldid, $fieldvalue) = each($field))
			{
				$result = $vwardb->query_first("SELECT fieldlength FROM vwar".$n."_profilefield WHERE profilefieldid = '$fieldid'");
				$fieldvalue = substr($fieldvalue, 0, $result['fieldlength']);

				$result = $vwardb->query_first("
					SELECT memberprofilefieldid FROM vwar".$n."_memberprofilefield
					WHERE profilefieldid = '$fieldid' AND memberid = '".$GPC['memberid']."'
				");
				if ($result['memberprofilefieldid'] == 0)
				{
					$vwardb->query("
						INSERT INTO vwar".$n."_memberprofilefield
						(memberid, profilefieldid, fieldvalue)
						VALUES
						('".$GPC['memberid']."', '$fieldid', '".ifelse($fieldvalue != "n/a",$fieldvalue,"")."')
					");
				}
				else
				{
					$vwardb->query("UPDATE vwar".$n."_memberprofilefield SET fieldvalue='".$fieldvalue."' WHERE memberid='".$GPC['memberid']."' AND profilefieldid='".$fieldid."'");
				}
			}
		}
		header("Location: modules.php?name=$module_name&action=" . ifelse(isset($GPC["modifypicture"]), "editpicture&memberid=" . $GPC['memberid'], "editmember&memberid=" . $GPC['memberid']));
	}

	//template-cache, standard-templates will be added by script:
	include($vwar_root2 . "includes/language/english.inc.php");

	$result = $vwardb->query_first("
		SELECT isadmin,canaccessbackup,canaddstatus,caneditstatus,candeletestatus,caneditmember
		FROM vwar".$n."_member,vwar".$n."_accessgroup
		WHERE vwar".$n."_member.accessgroupid = vwar".$n."_accessgroup.accessgroupid
		AND memberid = '".$GPC['vwarid']."'
	");
	$isadmin 					= $result['isadmin'];
	$canaddstatus 		= $result['canaddstatus'];
	$caneditstatus 		= $result['caneditstatus'];
	$candeletestatus 	= $result['candeletestatus'];
	$caneditmember 		= $result['caneditmember'];
	$canaccessbackup 	= $result['canaccessbackup'];

	$row = $vwardb->query_first("
		SELECT * FROM vwar".$n."_member,vwar".$n."_memberstatus
		WHERE memberid = '".$GPC['memberid']."' AND status = statusid
	");
	dbSelectForm($row);

	$color_first = "secondalt";
	$color_second = "firstalt";

		$usertmp = explode("|",$ab_user);
		if (in_array($row['memberid'],$usertmp) && $canaccessbackup == "1")
		{
			$accesspw = "<tr>
		<td class=\"secondalt\"><b>Backup Password</b><br /><small>password for the backup folder.<br />leave blank for current password</small></td>
		<td class=\"secondalt\" valign=\"top\"><input class=\"input\" type=\"password\" name=\"backuppw\"></td>
	</tr>";
			$color_first = "firstalt";
			$color_second = "secondalt";
		}

	getTextRestrictions("member","signature","firstalt",1,1,"sign");

	if ($row['birthday'] == '0000-00-00')
	{
		$daydefaultselected = "selected";
		$monthdefaultselected = "selected";
	}
	else
	{
		$birthday = split("-",$row['birthday']);
		$year = $birthday[0];
		$month = $birthday[1];
		$day = $birthday[2];

		$monthselected[$month] = "selected";
		$dayselected[$day] = "selected";
		$yearselected[$year] = "selected";
	}

	$birthdayselect = "<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
													<tr>
															<td align=\"center\"><small><b>Month</b></small></td>
															<td align=\"center\"><small><b>Day</b></small></td>
															<td align=\"center\"><small><b>Year</b></small></td>
													</tr>
													<tr>
													<td><select name=\"month\">
															<option value=\"-1\" $monthdefaultselected></option>
															<option value=\"01\" $monthselected[01]>January</option>
															<option value=\"02\" $monthselected[02]>February</option>
															<option value=\"03\" $monthselected[03]>March</option>
															<option value=\"04\" $monthselected[04]>April</option>
															<option value=\"05\" $monthselected[05]>May</option>
															<option value=\"06\" $monthselected[06]>June</option>
															<option value=\"07\" $monthselected[07]>July</option>
															<option value=\"08\" $monthselected[08]>August</option>
															<option value=\"09\" $monthselected[09]>September</option>
															<option value=\"10\" $monthselected[10]>October</option>
															<option value=\"11\" $monthselected[11]>November</option>
															<option value=\"12\" $monthselected[12]>December</option>
													</select>
													</td>
													<td><select name=\"day\">
															<option value=\"-1\" $daydefaultselected></option>
															<option value=\"1\" $dayselected[01]>1</option>
															<option value=\"2\" $dayselected[02]>2</option>
															<option value=\"3\" $dayselected[03]>3</option>
															<option value=\"4\" $dayselected[04]>4</option>
															<option value=\"5\" $dayselected[05]>5</option>
															<option value=\"6\" $dayselected[06]>6</option>
															<option value=\"7\" $dayselected[07]>7</option>
															<option value=\"8\" $dayselected[08]>8</option>
															<option value=\"9\" $dayselected[09]>9</option>
															<option value=\"10\" $dayselected[10]>10</option>
															<option value=\"11\" $dayselected[11]>11</option>
															<option value=\"12\" $dayselected[12]>12</option>
															<option value=\"13\" $dayselected[13]>13</option>
															<option value=\"14\" $dayselected[14]>14</option>
															<option value=\"15\" $dayselected[15]>15</option>
															<option value=\"16\" $dayselected[16]>16</option>
															<option value=\"17\" $dayselected[17]>17</option>
															<option value=\"18\" $dayselected[18]>18</option>
															<option value=\"19\" $dayselected[19]>19</option>
															<option value=\"20\" $dayselected[20]>20</option>
															<option value=\"21\" $dayselected[21]>21</option>
															<option value=\"22\" $dayselected[22]>22</option>
															<option value=\"23\" $dayselected[23]>23</option>
															<option value=\"24\" $dayselected[24]>24</option>
															<option value=\"25\" $dayselected[25]>25</option>
															<option value=\"26\" $dayselected[26]>26</option>
															<option value=\"27\" $dayselected[27]>27</option>
															<option value=\"28\" $dayselected[28]>28</option>
															<option value=\"29\" $dayselected[29]>29</option>
															<option value=\"30\" $dayselected[30]>30</option>
															<option value=\"31\" $dayselected[31]>31</option>
													</select></td>
													<td><small><input type=\"text\" name=\"year\" size=\"4\" maxlength=\"4\" value=\"$year\" $disabled></small></td>
													</tr>
												</table>";


	if ($row['joindate'] == '0000-00-00')
        {
                $joindaydefaultselected = "selected";
                $joinmonthdefaultselected = "selected";
        }
        else
        {
                $joindate = split("-",$row['joindate']);
                $joinyear = $joindate[0];
                $joinmonth = $joindate[1];
                $joinday = $joindate[2];

                $joinmonthselected[$joinmonth] = "selected";
                $joindayselected[$joinday] = "selected";
                $joinyearselected[$joinyear] = "selected";
        }

        if ($isadmin == 1 OR $caneditmember == 1)
                {
                $joinselect ="<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
 <tr>
  <td align=\"center\"><small><b>Month</b></small></td>
  <td align=\"center\"><small><b>Day</b></small></td>
  <td align=\"center\"><small><b>Year</b></small></td>
</tr>
<tr>
  <td><select name=\"joinmonth\">
        <option value=\"-1\" $joinmonthdefaultselected></option>
    <option value=\"01\" $joinmonthselected[01]>January</option>
        <option value=\"02\" $joinmonthselected[02]>February</option>
        <option value=\"03\" $joinmonthselected[03]>March</option>
        <option value=\"04\" $joinmonthselected[04]>April</option>
        <option value=\"05\" $joinmonthselected[05]>May</option>
        <option value=\"06\" $joinmonthselected[06]>June</option>
        <option value=\"07\" $joinmonthselected[07]>July</option>
        <option value=\"08\" $joinmonthselected[08]>August</option>
        <option value=\"09\" $joinmonthselected[09]>September</option>
        <option value=\"10\" $joinmonthselected[10]>October</option>
        <option value=\"11\" $joinmonthselected[11]>November</option>
        <option value=\"12\" $joinmonthselected[12]>December</option>
        </select>
   </td>
   <td><select name=\"joinday\">
        <option value=\"-1\" $joindaydefaultselected></option>
        <option value=\"1\" $joindayselected[01]>1</option>
        <option value=\"2\" $joindayselected[02]>2</option>
        <option value=\"3\" $joindayselected[03]>3</option>
        <option value=\"4\" $joindayselected[04]>4</option>
        <option value=\"5\" $joindayselected[05]>5</option>
        <option value=\"6\" $joindayselected[06]>6</option>
        <option value=\"7\" $joindayselected[07]>7</option>
        <option value=\"8\" $joindayselected[08]>8</option>
        <option value=\"9\" $joindayselected[09]>9</option>
        <option value=\"10\" $joindayselected[10]>10</option>
        <option value=\"11\" $joindayselected[11]>11</option>
        <option value=\"12\" $joindayselected[12]>12</option>
        <option value=\"13\" $joindayselected[13]>13</option>
        <option value=\"14\" $joindayselected[14]>14</option>
        <option value=\"15\" $joindayselected[15]>15</option>
        <option value=\"16\" $joindayselected[16]>16</option>
        <option value=\"17\" $joindayselected[17]>17</option>
        <option value=\"18\" $joindayselected[18]>18</option>
        <option value=\"19\" $joindayselected[19]>19</option>
        <option value=\"20\" $joindayselected[20]>20</option>
        <option value=\"21\" $joindayselected[21]>21</option>
        <option value=\"22\" $joindayselected[22]>22</option>
        <option value=\"23\" $joindayselected[23]>23</option>
        <option value=\"24\" $joindayselected[24]>24</option>
        <option value=\"25\" $joindayselected[25]>25</option>
        <option value=\"26\" $joindayselected[26]>26</option>
        <option value=\"27\" $joindayselected[27]>27</option>
        <option value=\"28\" $joindayselected[28]>28</option>
        <option value=\"29\" $joindayselected[29]>29</option>
        <option value=\"30\" $joindayselected[30]>30</option>
        <option value=\"31\" $joindayselected[31]>31</option>
        </select></td>
        <td><small>
    <input type=\"text\" name=\"joinyear\" size=\"4\" maxlength=\"4\" value=\"$joinyear\"></small></td>
  </tr>
</table>";
                }
                else
                {
if(!$chjdate){$disabled = "DISABLED"; $mess = "You are not allowed to change your joindate";}
                $joinselect ="<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
 <tr>
  <td align=\"center\"><small><b>Month</b></small></td>
  <td align=\"center\"><small><b>Day</b></small></td>
  <td align=\"center\"><small><b>Year</b></small></td>
  <td align=\"center\"></td>
</tr>
<tr>
  <td><select name=\"joinmonth\" $disabled>
        <option value=\"-1\" $joinmonthdefaultselected></option>
    <option value=\"01\" $joinmonthselected[01]>January</option>
        <option value=\"02\" $joinmonthselected[02]>February</option>
        <option value=\"03\" $joinmonthselected[03]>March</option>
        <option value=\"04\" $joinmonthselected[04]>April</option>
        <option value=\"05\" $joinmonthselected[05]>May</option>
        <option value=\"06\" $joinmonthselected[06]>June</option>
        <option value=\"07\" $joinmonthselected[07]>July</option>
        <option value=\"08\" $joinmonthselected[08]>August</option>
        <option value=\"09\" $joinmonthselected[09]>September</option>
        <option value=\"10\" $joinmonthselected[10]>October</option>
        <option value=\"11\" $joinmonthselected[11]>November</option>
        <option value=\"12\" $joinmonthselected[12]>December</option>
        </select>
   </td>
   <td><select name=\"joinday\" $disabled>
        <option value=\"-1\" $joindaydefaultselected></option>
        <option value=\"1\" $joindayselected[01]>1</option>
        <option value=\"2\" $joindayselected[02]>2</option>
        <option value=\"3\" $joindayselected[03]>3</option>
        <option value=\"4\" $joindayselected[04]>4</option>
        <option value=\"5\" $joindayselected[05]>5</option>
        <option value=\"6\" $joindayselected[06]>6</option>
        <option value=\"7\" $joindayselected[07]>7</option>
        <option value=\"8\" $joindayselected[08]>8</option>
        <option value=\"9\" $joindayselected[09]>9</option>
        <option value=\"10\" $joindayselected[10]>10</option>
        <option value=\"11\" $joindayselected[11]>11</option>
        <option value=\"12\" $joindayselected[12]>12</option>
        <option value=\"13\" $joindayselected[13]>13</option>
        <option value=\"14\" $joindayselected[14]>14</option>
        <option value=\"15\" $joindayselected[15]>15</option>
        <option value=\"16\" $joindayselected[16]>16</option>
        <option value=\"17\" $joindayselected[17]>17</option>
        <option value=\"18\" $joindayselected[18]>18</option>
        <option value=\"19\" $joindayselected[19]>19</option>
        <option value=\"20\" $joindayselected[20]>20</option>
        <option value=\"21\" $joindayselected[21]>21</option>
        <option value=\"22\" $joindayselected[22]>22</option>
        <option value=\"23\" $joindayselected[23]>23</option>
        <option value=\"24\" $joindayselected[24]>24</option>
        <option value=\"25\" $joindayselected[25]>25</option>
        <option value=\"26\" $joindayselected[26]>26</option>
        <option value=\"27\" $joindayselected[27]>27</option>
        <option value=\"28\" $joindayselected[28]>28</option>
        <option value=\"29\" $joindayselected[29]>29</option>
        <option value=\"30\" $joindayselected[30]>30</option>
        <option value=\"31\" $joindayselected[31]>31</option>
        </select></td>
        <td><small>
    <input type=\"text\" name=\"joinyear\" size=\"4\" maxlength=\"4\" value=\"$joinyear\" $disabled></small></td>
	<td>&nbsp;&nbsp;$mess</td>
  </tr>
</table>";
                }

	$imagepath = $vwar_root2 . "images/member/";

	if ($row['picture'])
	{
		$memberpicture = ifelse(@file_exists($imagepath . "th_". $row['picture']), makeimgtag($imagepath . "th_". $row['picture']), makeimgtag($imagepath . $row['picture']))."<br>";
	} else {
		$memberpicture = "<b>No picture uploaded!</b>";
	}

	$memberstatus = $row['statusname'];

	if ($row['icq'] == 0) $row['icq'] = "";


	// language
	if (!$row['language'])
	{
		$languagesel[$vwarlanguage] = "selected";
	} else {
		$languagesel[$row['language']] = "selected";
	}
	$defaultlanguage = $languages[$vwarlanguage];

	while (list($languagekey,$languageval) = each($languages))
	{
		$languageselectbit.="<option value=\"$languagekey\" $languagesel[$languagekey]>$languageval</option>";
	}

	// memberstatus
	$result = $vwardb->query("SELECT * FROM vwar".$n."_memberstatus WHERE deleted = '0'");
	while ($status = $vwardb->fetch_array($result))
	{
		$key = $status['statusid'];
		$val = $status['statusname'];

		if ($row['status'] == $key)
		{
			$admin_addmember_memberstatusselect .="<option value=\"$key\" selected>$val</option>";
		}
		else if ($isadmin == 1 OR ($canaddstatus == 1 AND $caneditstatus == 1 AND $candeletestatus == 1) OR $caneditmember == 1)
		{
			$admin_addmember_memberstatusselect .= "<option value=\"$key\">$val</option>";
		}
	}


	// membergames
	$result = $vwardb->query("SELECT * FROM vwar".$n."_games WHERE deleted = '0' ORDER BY gamename ASC");
	$linecounter = 0;
	$admin_member_gamebit = "";
	while ($game = $vwardb->fetch_array($result))
	{
		$linecounter++;
		$linecheck = $linecounter % 2;
		$admin_member_gamebit .= ifelse($linecheck==1 || $linecounter == 1, "\t\t\t\t\t\t\t\t<tr>");
		switchColors(1);

		$result2 = $vwardb->query_first("
			SELECT COUNT(membergamesid) AS numgames FROM vwar".$n."_membergames
			WHERE memberid = '".$GPC['memberid']."' AND gameid = '".$game['gameid']."'
		");
		$membergameselect = makeyesnocode("game".$game['gameid'], $result2['numgames']);

		//favorite locations
		if ($result2['numgames'] == 1)
		{
			$favcount = $vwardb->query_first("
				SELECT COUNT(memberlocationid) AS nummemberlocs FROM vwar".$n."_memberlocation
				WHERE memberid = '".$GPC['memberid']."' AND membergameid = '".$game['gameid']."'
			");
			$locationcount = $vwardb->query_first("
				SELECT COUNT(locationid) AS numlocs FROM vwar".$n."_locations
				WHERE gameid = '".$game['gameid']."'
			");

			if ($locationcount['numlocs']<=0)
			{
				$addfav = "<br><small>&raquo;&nbsp;No locations available for this game!</small>";
			}
			else if ($favcount['nummemberlocs'] < $favpermember && $locationcount['numlocs'] > 0)
			{
				$addfav = "<br>[&nbsp;" . makelink("modules.php?name=$module_name&action=addmemberlocation&amp;memberid=" . $row[memberid] . "&amp;gameid=" . $game[gameid],"Add a favorite location")."&nbsp;]";
			}
			else if ($favcount['nummemberlocs'] >= $favpermember && $locationcount['numlocs'] > 0)
			{
				$addfav = "<br><small>&raquo;&nbsp;Maximum of $favpermember Locations reached!</small>";
			}

			if ($favcount['nummemberlocs'] > 0 && $locationcount['numlocs'] > 0)
			{
				$result2 = $vwardb->query("
					SELECT memberlocationid, locationname
					FROM vwar".$n."_memberlocation, vwar".$n."_locations
					WHERE vwar".$n."_memberlocation.membergameid = '".$game['gameid']."'
					AND vwar".$n."_locations.locationid = vwar".$n."_memberlocation.locationid
					AND vwar".$n."_memberlocation.memberid = '".$GPC['memberid']."'
					AND deleted = '0'
					ORDER BY locationname
				");
				while ($row2 = $vwardb->fetch_array($result2))
				{
					$row2['locationnamepic'] = strtolower($row2['locationname']);
					$admin_memberlocationpic .="<li>$row2[locationname]  [&nbsp;<a href=\"modules.php?name=$module_name&action=editmemberlocation&memberlocationid=$row2[memberlocationid]&amp;gameid=$game[gameid]&amp;memberid=$row[memberid]\">Modify</a>&nbsp;]&nbsp;&nbsp;[&nbsp;<a href=\"modules.php?name=$module_name&action=deletememberlocation&memberid=$memberid&amp;memberlocationid=$row2[memberlocationid]\">Delete</a>&nbsp;]</li>";
				}
			}
		}
		$admin_member_gamebit .="<td class=\"firstalt\" valign=\"top\" width=\"20%\" nowrap><b>$game[gamename]</b>$addfav</td>
		<td class=\"secondalt\" width=\"30%\" nowrap>$membergameselect<br />
		<ul style=\"list-style: square; \">
		$admin_memberlocationpic
		</ul></td>";
		$admin_member_gamebit .= ifelse($linecheck == 0 || $linecounter == 2, "</tr>\n");
		unset($checked, $admin_memberlocationpic, $addfav);
	}

	// get profile fields

	$right = checkPermission("caneditmember", "", 1);

	$result = $vwardb->query("
		SELECT * FROM vwar".$n."_pfield_cat
		ORDER BY displayorder ASC, catname ASC
	");
	while ($cat = $vwardb->fetch_array($result))
	{
		dbSelect($cat);

		$result2 = $vwardb->query("
			SELECT profilefieldid, fieldname, fieldlength, vwar".$n."_profilefield.description,
				public, adminonly, smiliecode, htmlcode, bbcode
			FROM vwar".$n."_profilefield
			WHERE cat_id = '".$cat['pcat_id']."'
			ORDER BY displayorder ASC, public ASC, fieldname ASC
		");
		unset($colourcounter);
		while ($field = $vwardb->fetch_array($result2))
		{
			switchColors();
			dbSelect($field);

			$bbcode     = $field["bbcode"];
			$htmlcode   = $field["htmlcode"];
			$smiliecode = $field["smiliecode"];

			getTextRestrictions (0, 0, 0, 0, 0);

			$fieldid 					= $field['profilefieldid'];
			$fieldname 				= $field['fieldname'];
			$fielddescription = $field['description'];
			$fieldlength 			= $field['fieldlength'];

			$result3 = $vwardb->query_first("
				SELECT fieldvalue FROM vwar".$n."_memberprofilefield
				WHERE memberid = '".$GPC['memberid']."' AND profilefieldid = '".$fieldid."'
			");
			$fieldvalue = dbSelectForm($result3['fieldvalue']);

			if ($field['adminonly'] == 1 && $right != 1)
			{
				if (empty($fieldvalue))
				{
					$fieldvalue = "n/a";
				}
				eval("\$admin_editmember_fieldbits .= \"".$vwartpl->get(ifelse($field['public']==1,"admin_editmember_publicfieldbitadminonly","admin_editmember_nonpublicfieldbitadminonly"))."\";");
			}
			else
			{
				eval("\$admin_editmember_fieldbits .= \"".$vwartpl->get(ifelse($field['public']==1,"admin_editmember_publicfieldbit","admin_editmember_nonpublicfieldbit"))."\";");
			}
		}

		// display only non-empty categories
		if ($fieldid)
		{
			//eval ("\$admin_editmember_fields .= \"".$vwartpl->get("admin_editmember_field")."\";");
			$admin_editmember_fields .="<tr>
	<td class=\"sectionhead\" colspan=\"2\">$cat[catname]<br /><small>$cat[description]</small></td>
</tr>
$admin_editmember_fieldbits";
		}

		unset($admin_editmember_fieldbits);
	}

	$countryselectbit = ifelse($row['country'] == "", doCountrySelect(), doCountrySelect($row['country']));
	$sexselectbit = ifelse($row['sex'] == "", doSexSelect(), doSexSelect($row['sex']));


echo"<form name=\"member\" action=\"modules.php?name=$module_name&action=editmember&memberid=$GPC[memberid]\" method=\"post\">
<table cellpadding=\"5\" cellspacing=\"0\" border=\"0\" align=\"center\" width=\"100%\" class=\"tblborder\">
	<tr>
		<td class=\"tblhead\" colSpan=\"2\">Modify Member: $row[name]</td>
	</tr>
	<tr>
		<td class=\"firstalt\" colSpan=\"2\">
			<ul>
			<li><a href=\"#details\">Memberdetails</a></li>
			<li><a href=\"#pfields\">Custom Profilefields</a></li>
			<li><a href=\"#games\">Membergames</a></li>
			</ul>
		</td>
	</tr>
	<tr>
		<td class=\"sectionhead\" colSpan=\"2\"><a name=\"details\"></a>Memberdetails</td>
	</tr>
	<tr>
		<td class=\"firstalt\" width=\"25%\"><b>Nick Name</b> </td>
		<td class=\"firstalt\" width=\"75%\"><input class=\"input\" type=\"text\" name=\"vwarname\" value=\"$row[name]\"></td>
	</tr>
	<tr>
		<td class=\"secondalt\"><b>Real Name</b></td>
		<td class=\"secondalt\"><input class=\"input\" type=\"text\" name=\"realname\" value=\"$row[realname]\"></td>
	</tr>
	<tr>
		<td class=\"firstalt\"><b>War Tag</b></td>
		<td class=\"firstalt\"><input class=\"input\" type=\"text\" name=\"wartag\" value=\"$row[wartag]\"></td>
	</tr>
		<tr>
		<td class=\"secondalt\"><b>PHPnuke Name</b><font color=\"red\">*</font><br><small>Don't change this, you may not be able to login vwar then.</small></td>
		<td class=\"secondalt\"><input class=\"input\" type=\"text\" name=\"userid\" value=\"$row[userid]\"></td>
	</tr>
	<tr>
		<td class=\"firstalt\"><b>Password</b> <font color=\"red\">*</font></td>
		<td class=\"firstalt\"><a href=\"modules.php?name=$module_name&action=editpw&amp;memberid=$memberid\">Change Password</a></td>
	</tr>
	$accesspw
	<tr>
		<td class=\"$color_first\"><b>ICQ-UIN</b></td>
		<td class=\"$color_first\"><input class=\"input\" type=\"text\" name=\"icq\" value=\"$row[icq]\"></td>
	</tr>
	<tr>
		<td class=\"$color_second\"><img src=\"$vwar_root2/images/button_aim.gif\"> <b>AIM</b></td>
		<td class=\"$color_second\"><input class=\"input\" type=\"text\" name=\"aim\" value=\"$row[aim]\"></td>
	</tr>
	<tr>
		<td class=\"$color_first\"><img src=\"$vwar_root2/images/button_yim.gif\"> <b>YIM</b></td>
		<td class=\"$color_first\"><input class=\"input\" type=\"text\" name=\"yim\" value=\"$row[yim]\"></td>
	</tr>
	<tr>
		<td class=\"$color_second\"><img src=\"$vwar_root2/images/button_msn.gif\"> <b>MSN</b></td>
		<td class=\"$color_second\"><input class=\"input\" type=\"text\" name=\"msn\" value=\"$row[msn]\"></td>
	</tr>
	<tr>
		<td class=\"$color_first\"><img src=\"$vwar_root2/images/button_xfire.gif\"> <b>Xfire</b></td>
		<td class=\"$color_first\"><input class=\"input\" type=\"text\" name=\"xfire\" value=\"$row[xfire]\"></td>
	</tr>
	<tr>
		<td class=\"$color_second\"><img src=\"$vwar_root2/images/button_email.gif\"> <b>Email</b><br /><small>may not exist twice!</small></td>
		<td class=\"$color_second\"><input class=\"input\" type=\"text\" name=\"email\" value=\"$row[email]\"></td>
	</tr>
	<tr>
		<td class=\"$color_first\"><img src=\"$vwar_root2/images/button_homepage.gif\"> <b>Homepage</b></td>
		<td class=\"$color_first\"><input class=\"input\" type=\"text\" name=\"homepage\" value=\"$row[homepage]\"></td>
	</tr>
	<tr>
		<td class=\"$color_second\"><img src=\"$vwar_root2/images/button_birthday.gif\"> <b>Birthday</b></td>


		<td class=\"$color_second\">$birthdayselect</td>
	</tr>
	<tr>
		<td class=\"$color_first\"><b>Location</b></td>
		<td class=\"$color_first\"><input class=\"input\" type=\"text\" name=\"location\" value=\"$row[location]\"></td>
	</tr>
	<tr>
		<td class=\"$color_second\"><b>Country</b></td>
		<td class=\"$color_second\"><select class=\"input\" name=\"country\">$countryselectbit</select></td>
	</tr>
	<tr>
		<td class=\"$color_firs\"><b>Sex</b></td>
		<td class=\"$color_firs\"><select class=\"input\" name=\"sex\">$sexselectbit</select></td>
	</tr>
	<tr>
		<td class=\"sectionhead\" colspan=\"2\">Memberpicture</td>
	</tr>
	<tr>
		<td class=\"firstalt\" valign=\"top\"><b>Picture</b><br /><small>upload, delete or modify your picture</small></td>
		<td class=\"firstalt\" nowrap valign=\"middle\">$memberpicture   <p><input type=\"submit\" name=\"modifypicture\" value=\"Modify Picture\"></td>
	</tr>
	<tr>
		<td class=\"sectionhead\" colspan=\"2\">Language</td>
	</tr>
	<tr>
		<td class=\"firstalt\" valign=\"top\"><b>Script Language</b><br /><small>if no language is selected,<br />default language will be used<br /><br />default is: <b>$defaultlanguage</b></small></td>
		<td class=\"firstalt\" valign=\"middle\"><select class=\"input\" name=\"language\">
			$languageselectbit
			</select>
		</td>
	</tr>
	<tr>
		<td class=\"sectionhead\" colspan=\"2\">Memberstatus</td>
	</tr>
	<tr>
		<td class=\"firstalt\" width=\"25%\"><b>Memberstatus</b> <font color=\"red\">*</font><br /><small>can only be changed by an admin</small></td>
		<td class=\"firstalt\" width=\"75%\"><select class=\"input\" name=\"status\">$admin_addmember_memberstatusselect</select></td>
	</tr>
	<tr>
		<td class=\"secondalt\"><b>Custom Memberstatus</b></td>
		<td class=\"secondalt\"><input class=\"input\" type=\"text\" name=\"customstatus\" value=\"$row[customstatus]\"></td>
	</tr>
<tr>
                <td class=\"firstalt\"><b>Joindate</b></td>
                <td class=\"firstalt\">$joinselect</td>
        </tr>
	<tr>
		<td class=\"sectionhead\" colspan=\"2\">Signature</td>
	</tr>";
	//include($vwar_root."bbcode.js");
		//echo"$clickable_bbcode";
		//echo"$bbcode";
	/**
	echo"<tr bgcolor=\"$bgcolor\">
	<td valign=\"top\"><normalfont><b>BB Code:</b></normalfont></td>
	<td valign=\"top\">$bbcode_javascript
		<table>
			<tr>
				<td valign=\"middle\" colSpan=\"2\" nowrap>

					<input type=\"radio\" name=\"mode\" value=\"0\" title=\"$str[SIMPLEMODE] (Alt+N)\" accesskey=\"n\" onclick=\"setmode(this.value)\" $modechecked[0]> $str[SIMPLEMODE]
					<input type=\"radio\" name=\"mode\" value=\"1\" title=\"$str[ADVANCEDMODE] (Alt+E)\" accesskey=\"e\" onclick=\"setmode(this.value)\" $modechecked[1]> $str[ADVANCEDMODE]
					</smallfont>
				</td>
			</tr>
			<tr>
				<td valign=\"middle\" colSpan=\"2\" nowrap>
					<select id=\"sizeselect\" <smallfont>onchange=\"fontformat(this.form,this.options[this.selectedIndex].value,'size')\">
					<option value=\"0\">$str[SIZE]</option>
					<option value=\"1\">$str[SMALL]</option>
					<option value=\"2\">$str[NORMAL]</option>
					<option value=\"3\">$str[BIG]</option>
					<option value=\"4\">$str[HUGE]</option>
					</select>
					<select id=\"fontselect\" onchange=\"fontformat(this.form,this.options[this.selectedIndex].value,'font')\">
					<option value=\"0\">$str[FONT]</option>
					<option value=\"arial\">Arial</option>
					<option value=\"comic sans ms\">Comic</option>
					<option value=\"courier\">Courier</option>
					<option value=\"courier new\">Courier New</option>
					<option value=\"tahoma\">Tahoma</option>
					<option value=\"times new roman\">Times New Roman</option>
					<option value=\"verdana\">Verdana</option>
					</select>
					<select id=\"colorselect\" onchange=\"fontformat(this.form,this.options[this.selectedIndex].value,'color')\">
					<option value=\"0\">$str[COLOR]</option>
					<option value=\"skyblue\" style=\"color:skyblue\">sky blue</option>
					<option value=\"royalblue\" style=\"color:royalblue\">royal blue</option>
					<option value=\"blue\" style=\"color:blue\">blue</option>
					<option value=\"darkblue\" style=\"color:darkblue\">dark-blue</option>
					<option value=\"orange\" style=\"color:orange\">orange</option>
					<option value=\"orangered\" style=\"color:orangered\">orange-red</option>
					<option value=\"crimson\" style=\"color:crimson\">crimson</option>
					<option value=\"red\" style=\"color:red\">red</option>
					<option value=\"firebrick\" style=\"color:firebrick\">firebrick</option>
					<option value=\"darkred\" style=\"color:darkred\">dark red</option>
					<option value=\"green\" style=\"color:green\">green</option>
					<option value=\"limegreen\" style=\"color:limegreen\">limegreen</option>
					<option value=\"seagreen\" style=\"color:seagreen\">sea-green</option>
					<option value=\"deeppink\" style=\"color:deeppink\">deeppink</option>
					<option value=\"tomato\" style=\"color:tomato\">tomato</option>
					<option value=\"coral\" style=\"color:coral\">coral</option>
					<option value=\"purple\" style=\"color:purple\">purple</option>
					<option value=\"indigo\" style=\"color:indigo\">indigo</option>
					<option value=\"burlywood\" style=\"color:burlywood\">burlywood</option>
					<option value=\"sandybrown\" style=\"color:sandybrown\">sandy brown</option>
					<option value=\"sienna\" style=\"color:sienna\">sienna</option>
					<option value=\"chocolate\" style=\"color:chocolate\">chocolate</option>
					<option value=\"teal\" style=\"color:teal\">teal</option>
					<option value=\"silver\" style=\"color:silver\">silver</option>
					</select>
				</td>
				<td valign=\"middle\" nowrap rowSpan=\"2\">
					<smallfont>
					<input type=\"button\" value=\" x \" accesskey=\"c\" title=\"$str[CLOSECURRENTTAG] (Alt+C)\" style=\"color:red; font-weight:bold\" onclick=\"closetag(this.form)\"> $str[CLOSECURRENTTAG]<br />
					<input type=\"button\" value=\" x \" accesskey=\"x\" title=\"$str[CLOSEALLTAGS] (Alt+X)\" style=\"color:red; font-weight:bold\" onclick=\"closeall(this.form)\"> $str[CLOSEALLTAGS]
					</smallfont>
				</td>
			</tr>
			<tr>
				<td valign=\"middle\" nowrap>
					<img src=\"modules/$module_name/images/bbcode/bold.gif\" alt=\"$str[BOLDTEXT]\" border=\"0\" align=\"middle\" onclick=\"bbcode(document.$formname,'B','')\" width=\"23\" height=\"22\">
					<img src=\"modules/$module_name/images/bbcode/italic.gif\" alt=\"$str[ITALICTEXT]\" border=\"0\" align=\"middle\" onclick=\"bbcode(document.$formname,'I','')\" width=\"23\" height=\"22\">
					<img src=\"modules/$module_name/images/bbcode/underline.gif\" alt=\"$str[UNDERLINEDTEXT]\" border=\"0\" align=\"middle\" onclick=\"bbcode(document.$formname,'U','')\" width=\"23\" height=\"22\">
					<img src=\"modules/$module_name/images/bbcode/center.gif\" alt=\"$str[CENTER]\" border=\"0\" align=\"middle\" onclick=\"bbcode(document.$formname,'CENTER','')\" width=\"23\" height=\"22\">
					<img src=\"modules/$module_name/images/bbcode/list.gif\" alt=\"$str[CREATELIST]\" border=\"0\" align=\"middle\" onclick=\"dolist(document.$formname)\" width=\"23\" height=\"22\">
					<img src=\"modules/$module_name/images/bbcode/url.gif\" alt=\"$str[INSERTHYPERLINK]\" border=\"0\" align=\"middle\" onclick=\"namedlink(document.$formname,'URL')\" width=\"23\" height=\"22\">
					<img src=\"modules/$module_name/images/bbcode/email.gif\" alt=\"$str[INSERTMAIL]\" border=\"0\" align=\"middle\" onclick=\"namedlink(document.$formname,'EMAIL')\" width=\"23\" height=\"22\">
					<img src=\"modules/$module_name/images/bbcode/image.gif\" alt=\"$str[INSERTIMAGE]\" border=\"0\" align=\"middle\" onclick=\"bbcode(document.$formname,'IMG','http://')\" width=\"23\" height=\"22\">
					<img src=\"modules/$module_name/images/bbcode/code.gif\" alt=\"$str[INSERTCODE]\" border=\"0\" align=\"middle\" onclick=\"bbcode(document.$formname,'CODE','')\" width=\"23\" height=\"22\">
					<img src=\"modules/$module_name/images/bbcode/quote.gif\" alt=\"$str[INSERTQUOTE]\" border=\"0\" align=\"middle\" onclick=\"bbcode(document.$formname,'QUOTE','')\" width=\"23\" height=\"22\">
				</td>
				<td valign=\"middle\" align=\"right\" nowrap>$bbcode_help</td>
			</tr>
		</table>
	</td>
</tr>";
/**/
	echo"<tr>
		<td class=\"$nextcolor[1]\" valign=\"top\"><b>Content</b><br /><br />
			<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">

				<tr>
					<td><br /><small><b>Chars allowed:</b> 2000</small></td>
				</tr>
				<tr>
					<td><br /></td>
				</tr>
			</table>
		</td>
		<td class=\"$nextcolor[1]\" valign=\"top\">
			<textarea class=\"input\" name=\"signature\" rows=\"20\" wrap=\"soft\" COLS=\"80\">$row[signature]</textarea><br />
		</td>
	</tr>
	<tr>
		<td class=\"formsubmit\" colSpan=\"2\" align=\"center\"><input type=\"submit\" name=\"add\" value=\"Modify this Member\"></td>
	</tr>
</table><br />
<table cellpadding=\"5\" cellspacing=\"0\" border=\"0\" align=\"center\" width=\"100%\" class=\"tblborder\">
	<tr>
		<td class=\"tblhead\" colspan=\"2\"><a name=\"pfields\"></a>Custom Profilefields</td>
	</tr>
	$admin_editmember_fields
	<tr>
		<td class=\"formsubmit\" colSpan=\"2\" align=\"center\"><input type=\"submit\" name=\"add\" value=\"Modify this Member\"></td>
	</tr>
</table><br />
<table cellpadding=\"5\" cellspacing=\"0\" border=\"0\" align=\"center\" width=\"100%\" class=\"tblborder\">
	<tr>
		<td class=\"tblhead\" colspan=\"4\"><a name=\"games\"></a>Membergames</td>
	</tr>
	<tr>
		<td class=\"sectionhead\" colspan=\"4\">Select 'yes' or 'no' whether a member plays the respective game or not</td>
	</tr>
	$admin_member_gamebit
	<tr>
		<td class=\"formsubmit\" colSpan=\"4\" align=\"center\"><input type=\"submit\" name=\"add\" value=\"Modify this Member\"></td>
	</tr>
</table>
</form>";

}
}
// #################################### edit password ##################################
if ($GPC['action'] == "editpw")
{
	checkPermission("caneditmember",$GPC['memberid']);

	if ($GPC['add'] || $GPC['add_x'])
	{
		$currentpw = $vwardb->query_first("SELECT password FROM vwar".$n."_member WHERE memberid = '".$GPC['memberid']."'");

		if ($newpw1 != $newpw2 || (md5($oldpw) != $currentpw['password'] && (!checkPermission("caneditmember","",1)
			&& !checkPermission("isadmin","",1) || $GPC['memberid']==$GPC['vwarid'])))
		{
			echo"
			<table cellpadding=\"5\" cellspacing=\"0\" border=\"0\" width=\"100%\" align=\"center\" class=\"tblborder\">
	<tr>
		<td class=\"tblheaderror\" width=\"100%\">VWar Error Message</td>
	</tr>
	<tr>
		<td class=\"firstalt\" width=\"100%\" align=\"center\">
			<br /><b>Not all required fields were filled correctly!</b><br />
			Please verify the entered data!<br /><br />
			<a href=\"javascript:history.go(-1)\">Click here to go back</a><br /><br />
		</td>
	</tr>
</table>";
			exit;
		}
		$vwardb->query("UPDATE vwar".$n."_member SET password = '".md5($newpw1)."' WHERE memberid = '".$GPC['memberid']."'");

		if ($GPC['memberid'] == $GPC['vwarid'])
		{
			if(md5($newpw1)!=$GPC['vwarpassword'])
			{
				//SetVWarCookie("vwarpassword", md5($newpw1));
				SetVWarCookie("vwarpassword", md5(md5($newpw1)));
			}
		}
		header("Location: modules.php?name=$module_name&action=editmember&memberid=".$GPC['memberid']."");
	}

	$memberid = $GPC['memberid'];
	if (!checkPermission("caneditmember","",1) && !checkPermission("isadmin","",1) || $memberid==$GPC['vwarid'])
	{
		$oldpw="<tr>
		<td class=\"firstalt\" width=\"25%\" valign=\"top\"><b>Old Password</b> <font color=\"red\">*</font></td>
		<td class=\"firstalt\" width=\"75%\"><input class=\"input\" type=\"password\" maxLength=\"50\" value=\"\" name=\"oldpw\"><br /><a href=\"modules.php?name=$vwarmod&file=war&action=forgotpw\" target=\"_blank\"><small>Forgot Password?</small></a></td>
		</tr>";

	}

echo"	<form action=\"modules.php?name=$module_name&action=editpw&memberid=$memberid\" method=\"post\">
<table cellpadding=\"5\" cellspacing=\"0\" border=\"0\" align=\"center\" width=\"100%\" class=\"tblborder\">
	<tr>
		<td class=\"tblhead\" colSpan=\"2\">Modify Member / Change Password</td>
	</tr>
	$oldpw
	<tr>
		<td class=\"secondalt\" width=\"25%\" valign=\"top\"><b>New Password</b> <font color=\"red\">*</font></td>
		<td class=\"secondalt\" width=\"75%\"><input class=\"input\" type=\"password\" maxLength=\"50\" value=\"\" name=\"newpw1\"></td>
	</tr>
	<tr>
		<td class=\"secondalt\" width=\"25%\" valign=\"top\"><b>Confirm New Password</b> <font color=\"red\">*</font></td>
		<td class=\"secondalt\" width=\"75%\"><input class=\"input\" type=\"password\" maxLength=\"50\" value=\"\" name=\"newpw2\"></td>
	</tr>
	<tr>
		<td class=\"formsubmit\" colSpan=\"2\" align=\"center\"><input type=\"submit\" name=\"add\" value=\"Change Password\"></td>
	</tr>
</table>
</form>";
}
// ################################### add location to member #############################
if ($GPC['action'] == "addmemberlocation")
{
	checkPermission("caneditmember",$GPC['vwarid']);

	if ($GPC['add'] || $GPC['add_x'])
	{
		// check for wrong data
		if ($GPC['locationid'] == "")
		{
			echo"
			<table cellpadding=\"5\" cellspacing=\"0\" border=\"0\" width=\"100%\" align=\"center\" class=\"tblborder\">
	<tr>
		<td class=\"tblheaderror\" width=\"100%\">VWar Error Message</td>
	</tr>
	<tr>
		<td class=\"firstalt\" width=\"100%\" align=\"center\">
			<br /><b>Not all required fields were filled correctly!</b><br />
			Please verify the entered data!<br /><br />
			<a href=\"javascript:history.go(-1)\">Click here to go back</a><br /><br />
		</td>
	</tr>
</table>";
			exit;
		}
		$vwardb->query("
			INSERT INTO vwar".$n."_memberlocation (memberid, locationid, membergameid, comment)
			VALUES ('".$GPC['memberid']."', '".$GPC['locationid']."', '".$GPC['gameid']."', '".$GPC['comment']."')
		");
		header("Location: modules.php?name=$module_name&action=editmember&memberid=".$GPC['memberid']."");
	}

	$locationselectbit="<option value=\"\">Please Choose</option><option value=\"\">-------------------------</option>";


	$idlist = getMemberLocations($GPC['gameid'],$GPC['memberid']);
	$result = $vwardb->query("
		SELECT locationid, locationname, locationpic FROM vwar".$n."_locations
		WHERE deleted = '0'
		AND gameid = '".$GPC['gameid']."'
		AND locationid NOT IN ('$idlist')
		ORDER by locationname ASC
	");
	while ($row = $vwardb->fetch_array($result))
	{
		$locationselectbit .="<option value=\"$row[locationid]\">$row[locationname]</option>";
	}
	echo"<form action=\"modules.php?name=$module_name&$GPC[QUERY_STRING]\" method=\"post\">
<table cellpadding=\"5\" cellspacing=\"0\" border=\"0\" align=\"center\" width=\"100%\" class=\"tblborder\">
	<tr>
		<td class=\"tblhead\" colSpan=\"2\">Modify Member / Add Favorited Location</td>
	</tr>
	<tr>
		<td class=\"firstalt\" width=\"25%\" valign=\"top\"><b>Location</b> <font color=\"red\">*</font><br /><small>Please select a map as your<br />favorited location of this game!</small></td>
		<td class=\"firstalt\" width=\"75%\">
			<select class=\"input\" name=\"locationid\">
			$locationselectbit
			</select>
		</td>
	</tr>
	<tr>
		<td class=\"secondalt\" width=\"25%\" valign=\"top\"><b>Comment</b><br /><small>a short comment about the location</small></td>
		<td class=\"secondalt\" width=\"75%\">
			<input class=\"input\" type=\"text\" maxLength=\"100\" value=\"$comment\" name=\"comment\">
		</td>
	</tr>
	<tr>
		<td class=\"formsubmit\" colSpan=\"2\" align=\"center\"><input type=\"submit\" name=\"add\" value=\"Add this Location\"></td>
	</tr>
</table>
</form>";


}

// ################################### edit memberlocation ################################
if ($GPC['action'] == "editmemberlocation")
{
	checkPermission("caneditmember",$GPC['vwarid']);

	if ($GPC['add'] || $GPC['add_x'])
	{
		// check for wrong data
		if ($GPC['locationid'] == "")
		{
		echo"
			<table cellpadding=\"5\" cellspacing=\"0\" border=\"0\" width=\"100%\" align=\"center\" class=\"tblborder\">
	<tr>
		<td class=\"tblheaderror\" width=\"100%\">VWar Error Message</td>
	</tr>
	<tr>
		<td class=\"firstalt\" width=\"100%\" align=\"center\">
			<br /><b>Not all required fields were filled correctly!</b><br />
			Please verify the entered data!<br /><br />
			<a href=\"javascript:history.go(-1)\">Click here to go back</a><br /><br />
		</td>
	</tr>
</table>";

			exit;
		}
		$vwardb->query("
			UPDATE vwar".$n."_memberlocation SET
			locationid = '".$GPC['locationid']."', comment = '".$GPC['comment']."'
			WHERE memberlocationid = '".$GPC['memberlocationid']."'
		");
		header("Location: modules.php?name=$module_name&action=editmember&memberid=".$GPC['memberid']."");
	}

	//template-cache, standard-templates will be added by script:
		$fav = $vwardb->query_first("
		SELECT locationid, comment FROM vwar".$n."_memberlocation
		WHERE memberlocationid = '".$GPC['memberlocationid']."'
	");
	$comment = dbSelectForm($fav['comment']);
	$idlist = getMemberLocations($GPC['gameid'],$GPC['memberid'],$GPC['memberlocationid']);
	$locationselectbit="<option value=\"\">Please Choose</option><option value=\"\">-------------------------</option>";
	$result = $vwardb->query("
		SELECT locationid, locationname, locationpic FROM vwar".$n."_locations
		WHERE deleted = '0'
		AND gameid = '".$GPC['gameid']."'
		AND locationid NOT IN ('$idlist')
		ORDER by locationname ASC
	");
	while ($row = $vwardb->fetch_array($result))
	{
		eval("\$locationselectbit .= \"".$vwartpl->get(ifelse($row['locationid'] == $fav['locationid'],"locationselectbit2","locationselectbit"))."\";");
			$locationselectbit .="<option value=\"$row[locationid]\">$row[locationname]</option>";
	}

	echo"<form action=\"modules.php?name=$module_name&action=editmemberlocation&amp;memberid=$memberid&amp;memberlocationid=$memberlocationid\" method=\"post\">
<table cellpadding=\"5\" cellspacing=\"0\" border=\"0\" align=\"center\" width=\"100%\" class=\"tblborder\">
	<tr>
		<td class=\"tblhead\" colSpan=\"2\">Modify Member / Modify Favorited Location</td>
	</tr>
	<tr>
		<td class=\"firstalt\" width=\"25%\" valign=\"top\"><b>Location</b> <font color=\"red\">*</font><br /><small>Please select a map as your<br />favorited location of this game!</small></td>
		<td class=\"firstalt\" width=\"75%\"><select class=\"input\" name=\"locationid\">
			$locationselectbit
			</select>
		</td>
	</tr>
	<tr>
		<td class=\"secondalt\" width=\"25%\" valign=\"top\"><b>Comment</b><br /><small>a short comment about the location</small></td>
		<td class=\"secondalt\" width=\"75%\"><input class=\"input\" type=\"text\" maxLength=\"100\" value=\"$comment\" name=\"comment\"></td>
	</tr>
	<tr>
		<td class=\"formsubmit\" colSpan=\"2\" align=\"center\"><input type=\"submit\" name=\"add\" value=\"Modify this Location\"></td>
	</tr>
</table>
</form>";

}

// ############################# delete location from member ##############################
if ($GPC['action'] == "deletememberlocation")
{
	checkPermission("caneditmember",$GPC['vwarid']);

	if ($delete)
	{
		$vwardb->query("DELETE FROM vwar".$n."_memberlocation WHERE memberlocationid='".$GPC['memberlocationid']."'");
		header("Location: modules.php?name=$module_name&action=editmember&memberid=".$GPC['memberid']."");
	}

	echo"<form action=\"$GPC[PHP_SELF]?$GPC[QUERY_STRING]\" method=\"post\">
<table cellpadding=\"5\" cellspacing=\"0\" border=\"0\" align=\"center\" width=\"100%\" class=\"tblborder\">
	<tr>
		<td class=\"tblheaderror\">Delete</td>
	</tr>
	<tr>
		<td align=\"center\" class=\"firstalt\">
			$admin_message_delete_entries
			<font color=\"#F00000\"><b>NOTE:</b></font> Deleting is destructive, while set an entry to status 'inactive' is non-destructive!<br /><br />
			<table cellpadding=\"3\" cellspacing=\"0\" border=\"0\" align=\"center\" class=\"tblborder\">
				<tr>
					<td class=\"secondalt\"><b>Are you sure you want delete the selected item ?</b></td>
					<td class=\"secondalt\"><input type=\"submit\" name=\"delete\" value=\"Yes\"></td>
				</tr>
			</table><br />
		</td>
	</tr>
</table>
</form>";
}
//include ($vwar_root . "includes/get_footer.php");
echo"</body>
</html>";
CloseTable ();

require ("footer.php");
?>