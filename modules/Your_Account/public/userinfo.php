<?php
/*********************************************************************************/
/* CNB Your Account: An Advanced User Management System for phpnuke     		*/
/* ============================================                         		*/
/*                                                                      		*/
/* Copyright (c) 2004 by Comunidade PHP Nuke Brasil                     		*/
/* http://dev.phpnuke.org.br & http://www.phpnuke.org.br                		*/
/*                                                                      		*/
/* Contact author: escudero@phpnuke.org.br                              		*/
/* International Support Forum: http://ravenphpscripts.com/forum76.html 		*/
/*                                                                      		*/
/* This program is free software. You can redistribute it and/or modify 		*/
/* it under the terms of the GNU General Public License as published by 		*/
/* the Free Software Foundation; either version 2 of the License.       		*/
/*                                                                      		*/
/*********************************************************************************/
/* CNB Your Account it the official successor of NSN Your Account by Bob Marion	*/
/*********************************************************************************/

if (!eregi("modules.php", $_SERVER['SCRIPT_NAME'])) {
    header("Location: ../../../index.php");
    die ();
}
//vwar
$vwar_modulename="vwar";
include("modules/$vwar_modulename/includes/_config.inc.php");
//vwar
if (!defined('CNBYA')) { echo "CNBYA protection"; exit; }
$resultbc = $db->sql_query("SELECT * FROM ".$prefix."_bbconfig"); 

include("./includes/bbstuff.php");

while($rowbc = $db->sql_fetchrow($resultbc)) { 
    $board_config[$rowbc[config_name]] = $rowbc[config_value]; 
}

$result  = $db->sql_query("SELECT * FROM ".$user_prefix."_users WHERE username='$username'");
$num     = $db->sql_numrows($result);
$usrinfo = $db->sql_fetchrow($result);

$result = $db->sql_query("SELECT * FROM ".$user_prefix."_cnbya_field");
while ($sqlvalue = $db->sql_fetchrow($result)) {
  list($value) = $db->sql_fetchrow( $db->sql_query("SELECT value FROM ".$user_prefix."_cnbya_value WHERE fid ='$sqlvalue[fid]' AND uid = '$usrinfo[user_id]'"));
  $usrinfo[$sqlvalue[name]] = $value;
}

if(!$bypass) cookiedecode($user);
include("header.php");

if ($num > 0) {
    if ($usrinfo[user_level] > 0) {
        OpenTable();
        echo "<center>";
        if ((strtolower($usrinfo['username']) == strtolower($cookie[1])) AND ($usrinfo['user_password'] == $cookie[2])) {
            echo "<font class=\"option\">$username, "._WELCOMETO." $sitename!</font><br><br>";
            echo "<font class=\"content\">"._THISISYOURPAGE."</font></center><br>";
            nav(1);
            echo "<br>";
			///*=======================================================================================================================================
global $n,$vwar_modulename;
$vwarider = $_COOKIE[$n . "vwarid"];
$vwarpassworder = $_COOKIE[$n . "vwarpassword"];
cookiedecode($user);
$urname = $cookie[1];	
//echo"vwarider = $vwarider<br>vwarpassworder = $vwarpassworder<br><hr><br>";
if (($username == $cookie[1]) AND ($userinfo[user_password] == $cookie[2])) 
{//3 if start

//x.x.x.x.x.x.x.x.x.x
	if($vwarider !="")//if cookie is NOT empty
	{//4 if start check
	//1.1.1.1.1.1.1.1.1.1.1.1
	global $n,$vwar_modulename;
	$result40 = $db->sql_query("
			SELECT memberid,accessgroupid,name,realname,birthday,location,country,sex,email,homepage,icq,aim,yim,msn,xfire,password,forgotpw,customstatus,
			status,language,picture,ismember,hidemember,signature,lastactivity,userid,wartag,profilehits,joindate
			FROM vwar".$n."_member
			WHERE memberid = '$vwarider'
		");
		//$row40 = mysql_fetch_assoc($result40);
		$row40 = $db->sql_fetchrow($result40); 
		$password=$row40['password'];		$vwnukeuserid = $row40['userid'];		$vwarname = $row40['name'];
			if($row40['sex']== me){$genderpic ="<img src=\"modules/".$vwar_modulename."/images/".$row40['sex'].".gif\" align=\"middle\" border=\"0\" alt=\"".$gend."\" title=\"".$gend."\">"; $gend="Male";}
			elseif($row40['sex']== wo){$genderpic ="<img src=\"modules/".$vwar_modulename."/images/".$row40['sex'].".gif\" align=\"middle\" border=\"0\" alt=\"".$gend."\" title=\"".$gend."\">"; $gend="Female";}
			else{$genderpic ="N/A";}
			//+++++++++++++++=
			if($row40['country']== ""){$countrypic ="nocountry"; $country="".$row40['country']."";}
			else{$countrypic ="".$row40['country'].""; $country="".$row40['country']."";}
			//++++++++++++++++
			if($row40['picture'] != ""){$vwpicture ="<img src=\"modules/".$vwar_modulename."/images/member/".$row40['picture']."\">";}
			else{$vwpicture ="N/A";}	

		if(strtolower($vwnukeuserid)== strtolower($urname))
		{//5 if start
		//$controlp.= "hier komt de controle paneel";
		$controlp="";
		$cellstyle        = "style=\"border-left-width: 1; border-right-width: 1; border-top-width: 1; border-bottom-style: dotted; border-bottom-width: 1\"";
	$controlp.="<table width=\"100%\"  border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
	$controlp.= "<tr><td align=\"center\">";
	$controlp.="<span style=\"font-weight: bold; color: white; border:0px solid #7B869A; background-color: ; cursor: pointer\" onclick=\"var div=document.getElementById('YourCodeListingDivId$waridrl');if(div.style.display=='none'){div.style.display='block';this.innerHTML='Close List';}else{div.style.display='none';this.innerHTML='Click here to view your vwar info';}\" >Click <big>HERE</b> to view your vwar info</span><center><strong></strong></center><div id=\"YourCodeListingDivId$waridrl\" style=\"display:none\">";

$controlp.="
<table border=\"\" bordercolor=\"$bgcolor1\" cellpadding=\"0\" cellspacing=\"1\" width=\"100%\" align=\"center\" bgcolor=\"000000\" width=\"100%\">
<tr bgcolor=\"\">
 <td colspan=\"2\">
  <table border=\"0\" width=\"100%\" cellpadding=\"0\" cellspacing=\"1\" bgcolor=\"000000\">
   <tr>
    <td align=\"center\" ><headfont><b>".$row40['name']."</b></headfont></td>
   </tr>
  </table>
 </td>
</tr>

<tr>
 <td bgcolor=\"\" valign=\"middle\" align=\"center\" width=\"20%\"><normalfont>".$vwpicture."</normalfont></td>
 <td valign=\"top\" width=\"80%\" bgcolor=\"\">
<table border=\"0\" width=\"100%\" cellpadding=\"3\" cellspacing=\"1\" align=\"center\">
<tr bgcolor=\"\">
    <td width=\"15%\"><normalfont><b>War Tag:</b></normalfont></td>
    <td width=\"85%\"><normalfont>".$row40['wartag']."</normalfont></td>
   </tr>   
<tr bgcolor=\"\">
    <td width=\"15%\"><normalfont><b>Realname:</b></normalfont></td>
    <td width=\"85%\"><normalfont>".$row40['realname']."</normalfont></td>
   </tr>
   <tr bgcolor=\"\">
    <td width=\"15%\"><normalfont><b>Email:</b></normalfont></td>
    <td width=\"85%\"><normalfont>".$row40['email']."</normalfont></td>
   </tr>
   <tr bgcolor=\"\">
    <td width=\"15%\"><normalfont><b>ICQ:</b></normalfont></td>
    <td width=\"85%\"><normalfont>&nbsp;&nbsp;".$row40['icq']."</normalfont></td>
   </tr>
   <tr bgcolor=\"\">
    <td width=\"15%\"><normalfont><b>AIM:</b></normalfont></td>
    <td width=\"85%\"><normalfont><img src=\"modules/".$vwar_modulename."/images/button_aim.gif\" align=\"middle\" border=\"0\" alt=\"".$row40['aim']."\">&nbsp;&nbsp;".$row40['aim']."</normalfont></td>
   </tr>
   <tr bgcolor=\"\">
    <td width=\"15%\"><normalfont><b>YIM:</b></normalfont></td>
    <td width=\"85%\"><normalfont><img src=\"modules/".$vwar_modulename."/images/button_yim.gif\" align=\"middle\" border=\"0\" alt=\"".$row40['yim']."\">&nbsp;&nbsp;".$row40['yim']."</normalfont></td>
   </tr>
   <tr bgcolor=\"\">
    <td width=\"15%\"><normalfont><b>MSN:</b></normalfont></td>
    <td width=\"85%\"><img src=\"modules/".$vwar_modulename."/images/button_msn.gif\" align=\"middle\" border=\"0\" alt=\"".$row40['msn']."\"><normalfont>&nbsp;&nbsp;".$row40['msn']."</normalfont> 
</td>
	<tr bgcolor=\"\">
	<td width=\"15%\"><normalfont><b>Xfire:</b></normalfont></td>
	<td width=\"85%\"><img src=\"modules/".$vwar_modulename."/images/button_xfire.gif\" align=\"middle\" border=\"0\" alt=\"".$row40['xfire']."\" title=\"$row[xfire]\"><normalfont>&nbsp;&nbsp;".$row40['xfire']."</normalfont></td>
	</tr>

   </tr>
   <tr bgcolor=\"\">
    <td width=\"15%\"><normalfont><b>Homepage:</b></normalfont></td>
    <td width=\"85%\"><normalfont>".$row40['homepage']."</normalfont></td>
   </tr>
   <tr bgcolor=\"\">
    <td width=\"15%\"><normalfont><b>location:</b></normalfont></td>
    <td width=\"85%\"><normalfont>".$row40['location']."</normalfont></td>
   </tr>
   <tr bgcolor=\"\">
    <td width=\"15%\"><normalfont><b>Country:</b></normalfont></td>
    <td width=\"85%\"><normalfont><img src=\"modules/".$vwar_modulename."/images/flags/".$countrypic.".gif\" align=\"middle\" border=\"0\" alt=\"".$countrypic."\" title=\"".$row40['country']."\"></normalfont></td>
   </tr>
   <tr bgcolor=\"\">
	<td width=\"15%\"><normalfont><b>Gender:</b></normalfont></td>
	<td width=\"85%\"><normalfont>".$genderpic."</normalfont></td>
	</tr>
   <tr bgcolor=\"\">
    <td width=\"15%\"><normalfont><b>Birthday:</b></normalfont></td>
    <td width=\"85%\"><normalfont>".$row40['birthday']."</normalfont></td>
   </tr>
   <tr bgcolor=\"\">
    <td width=\"15%\"><normalfont><b>Join Date:</b></normalfont></td>
    <td width=\"85%\"><normalfont>".$row40['joindate']."</normalfont></td>
   </tr>
   <tr bgcolor=\"\">
    <td width=\"15%\"><normalfont><b>Profile Hits:</b></normalfont></td>
    <td width=\"85%\"><normalfont>".$row40['profilehits']."</normalfont></td>
   </tr>
   <tr bgcolor=\"\">
<td width=\"15%\"><normalfont><b>Last login:</b></normalfont></td>
<td width=\"85%\"><normalfont>".date('d-M-Y H:i:s',$row40['lastactivity'])."</normalfont></td>
	</tr>

  </table>
 </td>
</tr>
</table>";


	$controlp.="</td></tr>";
	$controlp.= "</table>";
		// define and make controlepanel
		}//5 if end
		else
		{//5 else start
		$controlp.= "...";
		}//5 else end
	//1.1.1.1.1.1.1.1.1.1.1.1			
	}//4 if end
	else 
	{//4 else start if $vwarider = ""; IS empty
	$resultvw = $db->sql_query("SELECT memberid, ismember, password FROM vwar".$n."_member WHERE userid = '$urname'");
	//$rowvw = mysql_fetch_assoc($resultvw);
	$rowvw = $db->sql_fetchrow($resultvw); 

	
			if ($urname != "")
			{//6 if start
			$controlp.="urname is username = $urname and n=$n this should be empty!!";
			}//6 if end
	 		else 
			{//6 else start
			$controlp.= "urname is empty";
			}//6 else end
	
	}//4 else end
//x.x.x.x.x.x.x.x.x.x
}////3 if end
// End the control panel part
//======= //  next script shows the controlpanel or sets the cookie part  \\

$result = $db->sql_query("SELECT memberid, ismember, password FROM vwar".$n."_member WHERE userid = '$username'"); 
//$row = mysql_fetch_assoc($result); 
$row = $db->sql_fetchrow($result); 

global $vwar_modulename;

if ($row['ismember'] == 1)
   {
	if($vwarider ==$row['memberid'] && $vwarpassworder == md5($row['password']))
	{
	echo"<center><a href=\"modules.php?name=vWar_Account\";><img src=\"modules/vWar_Account/images/vwar.gif\" border=\"0\"><br>Edit your vWar Info</a><br />or<br /><center>";
	echo"$controlp<br />";
	}
	else
	{//set vwar cookie
	
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
	
	
	
					SetVWarCookie("vwarid", $row['memberid']);
					SetVWarCookie("vwarpassword", md5($row['password'])); 
			header("Location: ".$_SERVER['PHP_SELF']."?name=$module_name");
			
			echo"htth<br>vwnukeuserid=$vwnukeuserid<br>
			n= $n<br>
			row[password] ".md5($row['password'])."!!!<br>
			username = $username<br>
			ismember = ".$row['ismember']."<br>
			You are not allowed to view the controle panel<br>
			$vwar_modulename<br>
			".$row["loginpassword"]."<br>
			";
	}
			
   }
   else
   {//

   }
//======= 

//=======================================================================================================================================		
//*/
        } else {
            echo "<font class=\"title\">"._PERSONALINFO.": ".$usrinfo['username']."</font></center><br>";
        }
        if($num == 1) {
            echo "<center>\n";
            echo "<table bgcolor='$bgcolor4' border='0' cellpadding='2' cellspacing='1' class='content' width='60%'>\n";
            echo "<tr>\n<td align='center' bgcolor='$bgcolor2' class='title' colspan='2' width='100%'>";
            if ($usrinfo[user_avatar_type] == 1) {		// Type 1
                $user_avatar = $board_config[avatar_path]."/".$usrinfo[user_avatar]; 
            } elseif($usrinfo[user_avatar_type] == 2) {	// Type 2
                echo "<img src='$usrinfo[user_avatar]'>";
            } elseif($usrinfo[user_avatar] == "") {		// Type 3
                echo "<img src='".$board_config[avatar_gallery_path]."/gallery/blank.gif'>";
            } else {
                echo "<img src='".$board_config[avatar_gallery_path]."/".$usrinfo[user_avatar]."'>";
            }
            echo "</td>\n</tr>\n";
            $usrinfo[user_website] = strtolower($usrinfo[user_website]);
            $usrinfo[user_website] = str_replace("http://", "", $usrinfo[user_website]);
            if ($usrinfo[user_website] == "") {
                $userwebsite = _YA_NA;
            } else {
                $userwebsite = "<a href=\"http://$usrinfo[user_website]\" target=\"new\">$usrinfo[user_website]</a>";
            }
            if (is_admin($admin) || $usrinfo['user_viewemail'] == 1) {
                $user_email = "<a href='mailto:$usrinfo[user_email]'>$usrinfo[user_email]</a>"; 
            } else {
                $user_email = _YA_NA;
            }
			
			//$usrinfo[user_sig] = nl2br($usrinfo[user_sig]);
			$signature = parseMessage( $usrinfo[user_sig], $usrinfo[user_sig_bbcode_uid] );
            $usrinfo[user_bio] = nl2br($usrinfo[user_bio]);
            $usrinfo[user_lastvisit] = date("D M j H:i:s T Y", $usrinfo[user_lastvisit]);
			
            echo "<tr>\n<td width='30%' bgcolor='$bgcolor1'>"._USERNAME."</td>\n<td width='70%' bgcolor='$bgcolor1'><b>$usrinfo[username]</b></td>\n</tr>\n";
            echo "<tr>\n<td width='30%' bgcolor='$bgcolor1'>"._REALNAME."</td>\n<td width='70%' bgcolor='$bgcolor1'><b>$usrinfo[name]</b></td>\n</tr>\n";
            echo "<tr>\n<td width='30%' bgcolor='$bgcolor1'>"._EMAIL."</td>\n<td width='70%' bgcolor='$bgcolor1'><b>$user_email</b></td>\n</tr>\n";
            echo "<tr>\n<td width='30%' bgcolor='$bgcolor1'>"._WEBSITE."</td>\n<td width='70%' bgcolor='$bgcolor1'><b>$userwebsite</b></td>\n</tr>\n";

		if(is_admin($admin) OR is_user($user) AND $usrinfo[username] == $username) {
                    $result = $db->sql_query("SELECT * FROM ".$user_prefix."_cnbya_field WHERE need <> '0' ORDER BY pos");
		} else {
			$result = $db->sql_query("SELECT * FROM ".$user_prefix."_cnbya_field WHERE need <> '0' AND public='1' ORDER BY pos");
		}
		while ($sqlvalue = $db->sql_fetchrow($result)) {
			if (substr($sqlvalue[name],0,1)=='_') eval( "\$name_exit = $sqlvalue[name];"); else $name_exit = $sqlvalue[name];
			echo "<tr><td width='30%' bgcolor='$bgcolor1'>$name_exit</td><td width='70%' bgcolor='$bgcolor1'>".$usrinfo[$sqlvalue[name]]."</td></tr>\n";
		}
			
            echo "<tr>\n<td width='30%' bgcolor='$bgcolor1'>"._ICQ."</td>\n<td width='70%' bgcolor='$bgcolor1'><b>$usrinfo[user_icq]</b></td>\n</tr>\n";
            echo "<tr>\n<td width='30%' bgcolor='$bgcolor1'>"._AIM."</td>\n<td width='70%' bgcolor='$bgcolor1'><b>$usrinfo[user_aim]</b></td>\n</tr>\n";
            echo "<tr>\n<td width='30%' bgcolor='$bgcolor1'>"._YIM."</td>\n<td width='70%' bgcolor='$bgcolor1'><b>$usrinfo[user_yim]</b></td>\n</tr>\n";
            echo "<tr>\n<td width='30%' bgcolor='$bgcolor1'>"._MSNM."</td>\n<td width='70%' bgcolor='$bgcolor1'><b>$usrinfo[user_msnm]</b></td>\n</tr>\n";
            echo "<tr>\n<td width='30%' bgcolor='$bgcolor1'>"._LOCATION."</td>\n<td width='70%' bgcolor='$bgcolor1'><b>$usrinfo[user_from]</b></td>\n</tr>\n";
            echo "<tr>\n<td width='30%' bgcolor='$bgcolor1'>"._REGDATE."</td>\n<td width='70%' bgcolor='$bgcolor1'><b>$usrinfo[user_regdate]</b></td>\n</tr>\n";
            echo "<tr>\n<td width='30%' bgcolor='$bgcolor1'>"._OCCUPATION."</td>\n<td width='70%' bgcolor='$bgcolor1'><b>$usrinfo[user_occ]</b></td>\n</tr>\n";
            echo "<tr>\n<td width='30%' bgcolor='$bgcolor1'>"._INTERESTS."</td>\n<td width='70%' bgcolor='$bgcolor1'><b>$usrinfo[user_interests]</b></td>\n</tr>\n";
            echo "<tr>\n<td width='30%' bgcolor='$bgcolor1'>"._SIGNATURE."</td>\n<td width='70%' bgcolor='$bgcolor1'><b>$signature</b></td>\n</tr>\n";
            echo "<tr>\n<td width='30%' bgcolor='$bgcolor1'>"._EXTRAINFO."</td>\n<td width='70%' bgcolor='$bgcolor1'><b>$usrinfo[bio]</b></td>\n</tr>\n";
            echo "<tr>\n<td width='30%' bgcolor='$bgcolor1'>"._YA_LASTVISIT."</td>\n<td width='70%' bgcolor='$bgcolor1'><b>$usrinfo[user_lastvisit]</b></td>\n</tr>\n";
            $sql2 = "SELECT uname FROM ".$prefix."_session WHERE uname='$username'";
            $result2 = $db->sql_query($sql2);
            $row2 = $db->sql_fetchrow($result2);
            $username_pm = $username;
            $active_username = $row2[uname]; // Edited PSL 12-9-04 was killing $username
            if ($active_username == "") { $online = _OFFLINE; } else { $online = _ONLINE; } 
            echo "<tr>\n<td width='30%' bgcolor='$bgcolor1'>"._USERSTATUS."</td>\n<td width='70%' bgcolor='$bgcolor1'><b>$online</b></td>\n</tr>\n";
            //if ($Version_Num > 6.9) {
                if (is_user($user) AND $cookie[1] == "$username" OR is_admin($admin)) {
                    echo "<tr>\n<td width='30%' bgcolor='$bgcolor1'>"._YA_POINTS."</td>\n<td width='70%' bgcolor='$bgcolor1'><b>$usrinfo[points]</b></td>\n</tr>\n";
                }
            //}
            if (($usrinfo[newsletter] == 1) AND ($username == $cookie[1]) AND ($usrinfo[user_password] == $cookie[2]) OR (is_admin($admin) AND ($usrinfo[newsletter] == 1))) {
                echo "<tr>\n<td width='30%' bgcolor='$bgcolor1'>"._NEWSLETTER."</td>\n<td width='70%' bgcolor='$bgcolor1'><b>"._SUBSCRIBED."</b></td>\n</tr>\n";
            } elseif (($usrinfo[newsletter] == 0) AND ($username == $cookie[1]) AND ($usrinfo[user_password] == $cookie[2]) OR (is_admin($admin) AND ($usrinfo[newsletter] == 0))) {
                echo "<tr>\n<td width='30%' bgcolor='$bgcolor1'>"._NEWSLETTER."</td>\n<td width='70%' bgcolor='$bgcolor1'><b>"._NOTSUBSCRIBED."</b></td>\n</tr>\n";
            }
            echo "</table>\n";
            echo "</center><br>\n<center>\n";
            if (is_active("Journal") AND $cookie[1] != $username) {
                $sql3 = "SELECT jid FROM ".$prefix."_journal WHERE aid='$username' AND status='yes' ORDER BY pdate,jid DESC LIMIT 0,1";
                $result3 = $db->sql_query($sq3);
                $row3 = $db->sql_fetchrow($result3);
                $jid = $row3[jid];
                if ($jid != "" AND isset($jid)) {
                    echo "[ <a href=\"modules.php?name=Journal&file=search&bywhat=aid&forwhat=$username\">"._READMYJOURNAL."</a> ]<br>";
                }
            }
            if (is_admin($admin)) {
            	global $nsnst_const;
				  if(!defined("NUKESENTINEL_IS_LOADED")) {
						$host_name = $_SERVER['REMOTE_ADDR'];
				} else {
					$host_name = $nsnst_const['remote_ip'];
				}
				if ($host_name != 0) {
                echo "<center>"._LASTIP." <b>$userinfo[last_ip]</b><br>";
                echo "[ <a href='".$admin_file.".php?op=ABBlockedIPAdd&tip=".$host_name."'>"._BANTHIS."</a> ]<br>";
                } 
                echo "[ <a href=\"modules.php?name=$module_name&file=admin&op=modifyUser&chng_uid=$usrinfo[user_id]\">"._EDITUSER."</a> ] ";
                echo "[ <a href=\"modules.php?name=$module_name&file=admin&op=suspendUser&chng_uid=$usrinfo[user_id]\">"._SUSPENDUSER."</a> ] ";
                echo "[ <a href=\"modules.php?name=$module_name&file=admin&op=deleteUser&chng_uid=$usrinfo[user_id]\">"._DELETEUSER."</a> ]<br>";
            }
            if (((is_user($user) AND $cookie[1] != $username) OR is_admin($admin)) AND is_active("Private_Messages")) { echo "<br>[ <a href=\"modules.php?name=Private_Messages&mode=post&u=$usrinfo[user_id]\">"._USENDPRIVATEMSG." $usrinfo[username]</a> ]<br>\n"; }
            echo "</center></font>";
        } else {
            echo "<center>"._NOINFOFOR." $username</center>";
        }
        CloseTable();

        $incsdir = dir("modules/$module_name/includes");
        while($func=$incsdir->read()) {
            if(substr($func, 0, 3) == "ui-") {
                $incslist .= "$func ";
            }
        }
        closedir($incsdir->handle);
        $incslist = explode(" ", $incslist);
        sort($incslist);
        for ($i=0; $i < sizeof($incslist); $i++) {
            if($incslist[$i]!="") {
                $counter = 0;
                include($incsdir->path."/$incslist[$i]");
            }
        }

    } else {
        OpenTable();
        echo "<center><b>"._NOINFOFOR." <i>".$usrinfo['username']."</i></b></center>";
        if($usrinfo[user_level] == 0) { echo "<br><center><b>"._ACCSUSPENDED."</b></center>"; }
        if($usrinfo[user_level] == -1) { echo "<br><center><b>"._ACCDELETED."</b></center>"; }
        CloseTable();
    }
} else {
    OpenTable();
    echo "<center><b>"._NOINFOFOR." <i>".$usrinfo['username']."</i></b></center>";
    echo "<br><center><b>"._YA_ACCNOFIND."</b></center>";
    CloseTable();
}
include("footer.php");
?>