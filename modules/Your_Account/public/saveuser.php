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
if (!defined('CNBYA')) { echo "CNBYA protection"; exit; }

include("./includes/bbcode.php");

$board_html_config = array();
$board_html_config = $db->sql_fetchrow($db->sql_query("SELECT config_value FROM ".$prefix."_bbconfig WHERE config_name = 'allow_html_tags'"));

$allow_html_tags = array();
$allow_html_tags = explode(",", $board_html_config['config_value']);
$allow_html_tags = array_flip($allow_html_tags);

foreach ($allow_html_tags as &$value) {
    $value = 1;
}
unset($value);

function dss_rand()
{
	global $db, $prefix, $dss_seeded;

	$board_seed = array();
	$board_seed = $db->sql_fetchrow($db->sql_query("SELECT config_value FROM ".$prefix."_bbconfig WHERE config_name = 'randseed'"));
		
	$val = $board_seed['config_value'] . microtime();
	$val = md5($val);
	$board_seed['config_value'] = md5($board_seed['config_value'] . $val . 'a');

	if($dss_seeded !== true)
	{
		$sql = "UPDATE ".$prefix."_bbconfig SET
			config_value = '" . $board_seed['config_value'] . "'
			WHERE config_name = 'rand_seed'";

		if( !$db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, "Unable to reseed PRNG", "", __LINE__, __FILE__, $sql);
		}

		$dss_seeded = true;
	}

	return substr($val, 4, 16);
}

    $stop = "";
    cookiedecode($user);
    $check = $cookie[1];
    $check2 = $cookie[2];
    $result = $db->sql_query("SELECT user_id, user_password, user_email FROM ".$user_prefix."_users WHERE username='$check'");
    $row = $db->sql_fetchrow($result);
    $vuid = $row['user_id'];
    $ccpass = $row['user_password'];
    $tuemail = strtolower($row['user_email']);
    //$user_sig = ya_fixtext($user_sig);
	$user_sig = check_html($user_sig, $allow_html_tags);
	$user_sig_bbcode_uid = make_bbcode_uid();
	$user_sig = bbencode_first_pass($user_sig, $user_sig_bbcode_uid);
	//$user_sig = str_replace("<br>", "\r\n", $user_sig);
    $user_email = strtolower($user_email);
    $user_email = ya_fixtext($user_email);
    $femail = ya_fixtext($femail);
    $user_website = ya_fixtext($user_website);
    $bio = ya_fixtext($bio);
    $user_icq = ya_fixtext($user_icq);
    $user_aim = ya_fixtext($user_aim);
    $user_yim = ya_fixtext($user_yim);
    $user_msnm = ya_fixtext($user_msnm);
    $user_occ = ya_fixtext($user_occ);
    $user_from = ya_fixtext($user_from);
    $user_interests = ya_fixtext($user_interests);
    $realname = ya_fixtext($realname);
    $user_dateformat = ya_fixtext($user_dateformat);
    $newsletter = intval($newsletter);
    $user_viewemail = intval($user_viewemail);
    $user_allow_viewonline = intval($user_allow_viewonline);
    $user_timezone = intval($user_timezone);
    if ($ya_config['allowmailchange'] < 1) {
        if ($tuemail != $user_email) { ya_mailCheck($user_email); }
    }
    if ($user_password > "" OR $vpass > "") { ya_passCheck($user_password, $vpass); }

	    $result = $db->sql_query("SELECT * FROM ".$user_prefix."_cnbya_field WHERE need = '3' ORDER BY pos");
	    while ($sqlvalue = $db->sql_fetchrow($result)) {
	      $t = $sqlvalue[fid];
          if ($nfield[$t] == "") {
	        include("header.php");
		    opentable();
			if (substr($sqlvalue[name],0,1)=='_') eval( "\$name_exit = $sqlvalue[name];"); else $name_exit = $sqlvalue[name];
            echo "<center><font class='title'><b>"._ERRORREG."</b></font><br><br>";
            echo "<font class='content'>"._YA_FILEDNEED1."$name_exit"._YA_FILEDNEED2."<br><br>"._GOBACK."</font></center>";
            closetable();
            include("footer.php");
            die();
		  };
	    }

    if (($stop == "") AND ($user_id == $vuid) AND ($check2 == $ccpass)) {
        if (!eregi("http://", $user_website) AND $user_website != "") {
            $user_website = "http://$user_website";
        }
        if ($bio) { filter_text($bio); $bio = $EditedMessage; $bio = FixQuotes($bio); }
        if ($user_password != "") {
            cookiedecode($user);
            $db->sql_query("LOCK TABLES ".$user_prefix."_users, ".$user_prefix."_cnbya_value WRITE");
            $user_password = md5($user_password);
            
			if ( ($ya_config['emailvalidate'] == '0') OR ($tuemail == $user_email) ) {
				$db->sql_query("UPDATE ".$user_prefix."_users SET name='$realname', user_email='$user_email', femail='$femail', user_website='$user_website', user_password='$user_password', bio='$bio', user_icq='$user_icq', user_occ='$user_occ', user_from='$user_from', user_interests='$user_interests', user_sig='$user_sig', user_aim='$user_aim', user_yim='$user_yim', user_msnm='$user_msnm', newsletter='$newsletter', user_viewemail='$user_viewemail', user_allow_viewonline='$user_allow_viewonline', user_notify='$user_notify', user_notify_pm='$user_notify_pm', user_popup_pm='$user_popup_pm', user_attachsig='$user_attachsig', user_allowbbcode='$user_allowbbcode', user_allowhtml='$user_allowhtml', user_allowsmile='$user_allowsmile', user_timezone='$user_timezone', user_dateformat='$user_dateformat' WHERE user_id='$user_id'");
			} else {
				$db->sql_query("UPDATE ".$user_prefix."_users SET name='$realname', femail='$femail', user_website='$user_website', user_password='$user_password', bio='$bio', user_icq='$user_icq', user_occ='$user_occ', user_from='$user_from', user_interests='$user_interests', user_sig='$user_sig', user_aim='$user_aim', user_yim='$user_yim', user_msnm='$user_msnm', newsletter='$newsletter', user_viewemail='$user_viewemail', user_allow_viewonline='$user_allow_viewonline', user_notify='$user_notify', user_notify_pm='$user_notify_pm', user_popup_pm='$user_popup_pm', user_attachsig='$user_attachsig', user_allowbbcode='$user_allowbbcode', user_allowhtml='$user_allowhtml', user_allowsmile='$user_allowsmile', user_timezone='$user_timezone', user_dateformat='$user_dateformat' WHERE user_id='$user_id'");
        		$datekey = date("F Y");
				$check_num = substr(md5(hexdec($datekey) * hexdec($cookie[2]) * hexdec($sitekey) * hexdec($user_email) * hexdec($tuemail)), 2, 10);
				$finishlink = "$nukeurl/modules.php?name=$module_name&op=changemail&id=$user_id&mail=$user_email&check_num=$check_num";
                $message .= _CHANGEMAIL1." $tuemail "._CHANGEMAIL2." $user_email"._CHANGEMAIL3." $sitename.\r\n\r\n";
                $message .= _CHANGEMAILFIN."\r\n\r\n$finishlink\r\n\r\n";
                $subject = _CHANGEMAILSUB;
				ya_mail($user_email, $subject, $message, '');
			}
			
			if (count($nfield) > 0) {
              foreach ($nfield as $key => $var) { 
			      if (($db->sql_numrows($db->sql_query("SELECT * FROM ".$user_prefix."_cnbya_value WHERE fid='$key' AND uid = '$user_id'"))) == 0) {
				  $sql = "INSERT INTO ".$user_prefix."_cnbya_value (uid, fid, value) VALUES ('$user_id', '$key','$nfield[$key]')";
				  $db->sql_query($sql);				
			    }
			    else {
			    $db->sql_query("UPDATE ".$user_prefix."_cnbya_value SET value='$nfield[$key]' WHERE fid='$key' AND uid = '$user_id'");
				}
			  }
			}

            $sql = "SELECT * FROM ".$user_prefix."_users WHERE username='$username' AND user_password='$user_password'";
            $result = $db->sql_query($sql);
            if ($db->sql_numrows($result) == 1) {
                $userinfo = $db->sql_fetchrow($result);
                yacookie($userinfo[user_id],$userinfo[username],$userinfo[user_password],$userinfo[storynum],$userinfo[umode],$userinfo[uorder],$userinfo[thold],$userinfo[noscore],$userinfo[ublockon],$userinfo[theme],$userinfo[commentmax]);
            } else {
                echo "<center>"._SOMETHINGWRONG."</center><br>";
            }
            $db->sql_query("UNLOCK TABLES");
        } else {
            $db->sql_query("LOCK TABLES ".$user_prefix."_users,".$user_prefix."_cnbya_value WRITE");
            
			if ( ($ya_config['emailvalidate'] == '0') OR ($tuemail == $user_email) ) {
            	$db->sql_query("UPDATE ".$user_prefix."_users SET name='$realname', user_email='$user_email', femail='$femail', user_website='$user_website', bio='$bio', user_icq='$user_icq', user_occ='$user_occ', user_from='$user_from', user_interests='$user_interests', user_sig='$user_sig', user_aim='$user_aim', user_yim='$user_yim', user_msnm='$user_msnm', newsletter='$newsletter', user_viewemail='$user_viewemail', user_allow_viewonline='$user_allow_viewonline', user_notify='$user_notify', user_notify_pm='$user_notify_pm', user_popup_pm='$user_popup_pm', user_attachsig='$user_attachsig', user_allowbbcode='$user_allowbbcode', user_allowhtml='$user_allowhtml', user_allowsmile='$user_allowsmile', user_sig_bbcode_uid='$user_sig_bbcode_uid', user_timezone='$user_timezone', user_dateformat='$user_dateformat' WHERE user_id='$user_id'");
            } else {
            	$db->sql_query("UPDATE ".$user_prefix."_users SET name='$realname', femail='$femail', user_website='$user_website', bio='$bio', user_icq='$user_icq', user_occ='$user_occ', user_from='$user_from', user_interests='$user_interests', user_sig='$user_sig', user_aim='$user_aim', user_yim='$user_yim', user_msnm='$user_msnm', newsletter='$newsletter', user_viewemail='$user_viewemail', user_allow_viewonline='$user_allow_viewonline', user_notify='$user_notify', user_notify_pm='$user_notify_pm', user_popup_pm='$user_popup_pm', user_attachsig='$user_attachsig', user_allowbbcode='$user_allowbbcode', user_allowhtml='$user_allowhtml', user_allowsmile='$user_allowsmile', user_sig_bbcode_uid='$user_sig_bbcode_uid', user_timezone='$user_timezone', user_dateformat='$user_dateformat' WHERE user_id='$user_id'");
        		$datekey = date("F Y");
				$check_num = substr(md5(hexdec($datekey) * hexdec($cookie[2]) * hexdec($sitekey) * hexdec($user_email) * hexdec($tuemail)), 2, 10);
				
				$finishlink = "$nukeurl/modules.php?name=$module_name&op=changemail&id=$user_id&mail=$user_email&check_num=$check_num";
                $message .= _CHANGEMAIL1." $tuemail "._CHANGEMAIL2." $user_email"._CHANGEMAIL3." $sitename.\r\n\r\n";
                $message .= _CHANGEMAILFIN."\r\n\r\n$finishlink\r\n\r\n";
                $subject = _CHANGEMAILSUB;
				ya_mail($user_email, $subject, $message, '');
			}
			
			if (count($nfield) > 0) {
            	 foreach ($nfield as $key => $var) { 
			      if (($db->sql_numrows($db->sql_query("SELECT * FROM ".$user_prefix."_cnbya_value WHERE fid='$key' AND uid = '$user_id'"))) == 0) {
				  	$sql = "INSERT INTO ".$user_prefix."_cnbya_value (uid, fid, value) VALUES ('$user_id', '$key','$nfield[$key]')";
				  	$db->sql_query($sql);				
			      }
			      else {
			      $db->sql_query("UPDATE ".$user_prefix."_cnbya_value SET value='$nfield[$key]' WHERE fid='$key' AND uid = '$user_id'");
				  }
			  }
			}
			
			$db->sql_query("UNLOCK TABLES");
        }
        Header("Location: modules.php?name=$module_name");
    } else {
        include("header.php");
        OpenTable();
        echo "<center><font class='title'><b>"._ERRORREG."</b></font><br><br>";
        echo "<font class='content'>$stop<br><br>"._GOBACK."</font></center>";
        CloseTable();
        include("footer.php");
    }
?>