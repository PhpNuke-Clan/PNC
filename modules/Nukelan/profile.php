<?php
// filename: profile.php
// ---------------------------------------------------------------------
// PNC version Module
// version 2.1
// by: XenoMorpH
// webmaster@tdi-hq.com
// http://www.phpnuke-clan.net
// =====================================================================
// Nukelan Modules pack
// version 2.0
// by: Artemis
//
// artemis@nukelan.com
// http://www.nukelan.com
// =====================================================================
// Special thanks to:
// Contra - for integrating the Multipay and IPN option into Nukelan.
// you the man
// =====================================================================
//
// LICENSE
//
// This program is free software; you can redistribute it and/or
// modify it under the terms of the GNU General Public License (GPL)
// as published by the Free Software Foundation; either version 2
// of the License, or (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// To read the license please visit http://www.gnu.org/copyleft/gpl.html
// ----------------------------------------------------------------------
 if ( !defined('MODULE_FILE') )
{
        die ("You can't access this file directly...");
}

require_once("mainfile.php");
$ModName = basename( dirname( __FILE__ ) );
get_lang($ModName);

if (is_user($_COOKIE['user'])) {
    $CONF['logged_in'] = true;
    $cookie    = $_COOKIE['user'];
    $cookie    = base64_decode($cookie);
    $cookie    = explode(":", $cookie);
    $username  = $cookie[1];
    $uid       = $cookie[0];
}

$index = $lanconfig['index'];

include ("header.php");
if (is_user($_COOKIE['user'])) {
        global $prefix, $db,  $uname, $uid, $pid;
        $user = base64_decode($user);
        $user = explode(":", $user);
        $uid = "$user[0]";
        $uname = "$user[1]";
        $pwd = "$user[2]";
   }else{
  OpenTable();
       echo"<center>You must be registered to view this page!!</center>";
   CloseTable();
   include ("footer.php");
   }
OpenTable();
$lan = $db->sql_fetchrow($db->sql_query("SELECT * FROM nukelan_parties WHERE party_id='$pid'"));
        echo "<center> :: <a href=\"modules.php?op=modload&name=$ModName&amp;file=index&amp;lanop=show_party&amp;party_id=$lan[party_id]\">"._NLEVENTINFO."</a> :";
        // if tournaments for this LAN
        if ($db->sql_numrows($db->sql_query("SELECT * FROM nukelan_tournaments WHERE config_id='$lan[party_id]'"))) {
        echo ": <a href=\"modules.php?op=modload&name=$ModName&amp;file=tourneys&amp;lanop=show_list&amp;pid=$lan[party_id]\">"._NLTOURNAMENTS."</a> :";
        }
        // if Prizes for this LAN
        if ($db->sql_numrows($db->sql_query("SELECT * FROM nukelan_prizes WHERE config_id='$lan[party_id]'"))) {
        echo ": <a href=\"modules.php?op=modload&name=$ModName&amp;file=prizes&amp;lanop=show_prizes&amp;party=$lan[party_id]\">"._NLPRIZES."</a> :";
        }
        // if lodgin for this LAN
        if ($db->sql_numrows($db->sql_query("SELECT * FROM nukelan_lodging WHERE config_id='$lan[party_id]'"))) {
        echo ": <a href=\"modules.php?op=modload&name=$ModName&amp;file=lodging&amp;lanop=show_lodges&amp;pid=$lan[party_id]\">"._NLLODGING."</a> :";
        }
        // if Seating Chart for this LAN
        if ($lan['schart'] > 0) {
        echo ": <a href=\"modules.php?op=modload&name=$ModName&amp;file=seating_chart&amp;seat=showChart&amp;pid=$lan[party_id]\">"._NLSEATINGCHART."</a> :";
        }
        // if LAN has sponsors
        if ($db->sql_numrows($db->sql_query("SELECT * FROM nukelan_sponsors_parties WHERE party_id='$lan[party_id]'"))) {
        echo ": <a href=\"modules.php?op=modload&name=$ModName&amp;file=sponsors&amp;pid=$lan[party_id]\">"._NLPARTYSPONSORS."</a> :";
        }
        echo ": <a href=\"modules.php?op=modload&name=$ModName&amp;file=profile&amp;pid=$lan[party_id]\">"._NLPROFILE."</a>  ::</center>";                      
CloseTable();
echo "<br>";
OpenTable();


function show_profile($profile_id) {
        global $prefix, $db,  $uid, $bgcolor1, $bgcolor2, $bgcolor3, $bgcolor4, $textcolor1, $textcolor2, $pid, $ModName;

$user_info = $db->sql_fetchrow($db->sql_query("SELECT * FROM ".$prefix."_users WHERE user_id='$profile_id'"));
$user_profile = $db->sql_fetchrow($db->sql_query("SELECT * FROM nukelan_gamer_profiles WHERE user_id='$profile_id'"));
$user_rig = $db->sql_fetchrow($db->sql_query("SELECT * FROM nukelan_gamer_rigs WHERE user_id='$profile_id'"));

        echo "<h3 style=\"margin: 4px 1px 4px 1px;\">$user_info[username]</h3><br>"
                ."<table width=400 border=0 cellspacing=1 cellpadding=3 align=middle>"
                ."<tr><td colspan=2 align=left><font size=2><b>"._NLPERSONALINFO."</b></font></td></tr>"
                ."<tr bgcolor=\"$bgcolor3\"><td width=250 align=right><b>"._NLALIAS3."</b></td>"
                ."<td align=left>";
                        if ($user_profile['alias']) echo "$user_profile[alias]</td></tr>";
                        else echo "$user_info[username]";
        echo "<tr bgcolor=\"$bgcolor4\"><td width=250 align=right><b>"._NLCLANORGROUP."</b></td>"
                ."<td align=left>$user_profile[gaming_group]</td></tr>"
                ."<tr bgcolor=\"$bgcolor3\"><td width=250 align=right><b>"._NLGENDER2."</b></td>"
                ."<td align=left>$user_profile[gender]</td></tr>"
                ."<tr bgcolor=\"$bgcolor4\"><td width=250 align=right><b>"._NLLOCALTOAREA."</b></td>"
                ."<td align=left>$user_profile[local]</td></tr>"
                ."<tr bgcolor=\"$bgcolor3\"><td width=250 align=right><b>"._NLPROFICIENCY2."</b></td>"
                ."<td align=left>$user_profile[proficiency]</td></tr>"
                ."<tr bgcolor=\"$bgcolor4\"><td width=250 align=right><b>"._NLSHOWQUOTE."</b></td>"
                ."<td align=left>$user_profile[quote]</td></tr>"
                ."<tr><td colspan=2>&nbsp;</td></tr>"
                ."<tr><td colspan=2 align=left><font size=2><b>"._NLHARDWARE."</b></font></td></tr>"
                ."<tr bgcolor=\"$bgcolor3\"><td width=250 align=right><b>"._NLMOTHERBOARD."</b></td>"
                ."<td align=left>$user_rig[mobo]</td></tr>"
                ."<tr bgcolor=\"$bgcolor4\"><td width=250 align=right><b>"._NLPROCESSOR2."</b></td>"
                ."<td align=left>$user_rig[processor]</td></tr>"
                ."<tr bgcolor=\"$bgcolor3\"><td width=250 align=right><b>"._NLMEMORY2."</b></td>"
                ."<td align=left>$user_rig[memory]</td></tr>"
                ."<tr bgcolor=\"$bgcolor4\"><td width=250 align=right><b>"._NLVIDEOCARD2."</b></td>"
                ."<td align=left>$user_rig[video]</td></tr>"
                ."<tr bgcolor=\"$bgcolor3\"><td width=250 align=right><b>"._NLSOUNDCARD2."</b></td>"
                ."<td align=left>$user_rig[sound]</td></tr>"
                ."<tr bgcolor=\"$bgcolor4\"><td width=250 align=right><b>"._NLHEADPHONES2."</b></td>"
                ."<td align=left>$user_rig[headphones]</td></tr>"
                ."<tr bgcolor=\"$bgcolor3\"><td width=250 align=right><b>"._NLMONITOR2."</b></td>"
                ."<td align=left>$user_rig[monitor]</td></tr>"
                ."<tr bgcolor=\"$bgcolor4\"><td width=250 align=right><b>"._NLMOUSE2."</b></td>"
                ."<td align=left>$user_rig[mouse]</td></tr>"
                ."<tr bgcolor=\"$bgcolor3\"><td width=250 align=right><b>"._NLMOUSEPAD2."</b></td>"
                ."<td align=left>$user_rig[mousepad]</td></tr>"
                ."<tr bgcolor=\"$bgcolor4\"><td width=250 align=right><b>"._NLKEYBOARD2."</b></td>"
                ."<td align=left>$user_rig[keyboard]</td></tr>"
                ."</table>";
}

function new_profile($realname, $alias, $gaming_group, $age, $gender, $local, $proficiency, $quote, $mobo, $processor, $memory, $video, $sound, $headphones, $monitor, $mouse, $mousepad, $keyboard, $error) {
        global $prefix, $db,  $uid, $bgcolor1, $bgcolor2, $bgcolor3, $bgcolor4, $textcolor1, $textcolor2, $pid, $ModName;

$user_info = $db->sql_fetchrow($db->sql_query("SELECT * FROM ".$prefix."_users WHERE user_id='$uid'"));

$genders = array('male' => 'male', 'female' => 'female');
$locals = array('yes' => 'yes', 'no' => 'no');
$proficiencies = array('1' => '1 -', '2' => '2 -', '3' => '3 -', '4' => '4 -', '5' => '5 -', '6' => '6 -', '7' => '7 -', '8' => '8 -', '9' => '9 -', '10' => '10 -');

        echo "<h3 style=\"margin: 4px 1px 4px 1px;\">"._NLNEWPROFILE."</h3>&nbsp;<font size=2><b>$user_info[username]</b></font><br>"
                ."<form action=\"modules.php\" method=\"post\">"
                ."<input type=hidden name=op value=modload>"
                ."<input type=hidden name=name value=$ModName>"
                ."<input type=hidden name=file value=profile>"
                ."<input type=hidden name=lanop value=add>"
                ."<input type=hidden name=uid value=".$uid.">"
                ."<input type=hidden name=pid value=".$pid.">"
                ."<table width=400 border=0 cellspacing=1 cellpadding=3>"
                ."<tr bgcolor=\"$bgcolor3\"><td width=250 align=right><b>"._NLREALNAME."</b> "._NLREALNAME2."(required for ID at LAN)</td>"
                ."<td><input type=text name=realname maxlength=30 style=\"width: 240px;\" value=$realname></td></tr>"
                ."<tr bgcolor=\"$bgcolor4\"><td width=250 align=right><b>"._NLALIAS."</b> "._NLALIAS2."</td>"
                ."<td><input type=text name=alias maxlength=30 style=\"width: 240px;\" value=$alias></td></tr>"
                ."<tr bgcolor=\"$bgcolor3\"><td width=250 align=right><b>"._NLGROUP."</b> "._NLGROUP2."</td>"
                ."<td><input type=text name=gaming_group maxlength=30 style=\"width: 240px;\" value=$gaming_group></td></tr>"
                ."<tr bgcolor=\"$bgcolor4\"><td width=250 align=right><b>"._NLAGE."</b></td>"
                ."<td><input type=text name=age maxlength=2 style=\"width: 120px;\" value=$age></td></tr>"
                ."<tr bgcolor=\"$bgcolor3\"><td width=250 align=right><b>"._NLGENDER."</b></td>"
                ."<td><select name=gender>";
        foreach ($genders as $value => $name) {
                if ($gender == $value) echo "<option value=$value SELECTED>$name</option>";
                else echo "<option value=$value>$name</option>";
        }               
        echo "</select></td></tr>"
                ."<tr bgcolor=\"$bgcolor4\"><td width=250 align=right><b>"._NLAREYOULOCAL."</b></td>"
                ."<td><select name=local>";
        foreach ($locals as $value => $name) {
                if ($local == $value) echo "<option value=$value SELECTED>$name</option>";
                else echo "<option value=$value>$name</option>";
        }
        echo "</select></td></tr>"
                ."<tr bgcolor=\"$bgcolor3\"><td width=250 align=right><b>"._NLPROFICIENCY."</b></td>"
                ."<td><select name=proficiency>";
        foreach ($proficiencies as $num => $text) {
                if ($proficiency == $num) echo "<option value=$num SELECTED>$text</option>";
                else echo "<option value=$num>$text</option>";
        }
        echo "</td></tr>"
                ."<tr bgcolor=\"$bgcolor4\"><td width=250 align=right><b>"._NLQUOTE."</b> "._NLQUOTE2."</td>"
                ."<td><input type=text name=quote maxlength=30 style=\"width: 240px;\" value=$quote></td></tr>"
                ."<tr><td colspan=2>&nbsp;</td></tr>"
                ."<tr><td colspan=2><font size=2><b>"._NLHARDWARE."</b></font></td></tr>"
                ."<tr bgcolor=\"$bgcolor3\"><td width=250 align=right><b>"._NLMOBO."</b></td>"
                ."<td><input type=text name=mobo maxlength=30 style=\"width: 240px;\" value=$mobo></td></tr>"
                ."<tr bgcolor=\"$bgcolor4\"><td width=250 align=right><b>"._NLPROCESSOR."</b></td>"
                ."<td><input type=text name=processor maxlength=30 style=\"width: 240px;\" value=$processor></td></tr>"
                ."<tr bgcolor=\"$bgcolor3\"><td width=250 align=right><b>"._NLMEMORY."</b></td>"
                ."<td><input type=text name=memory maxlength=30 style=\"width: 240px;\" value=$memory></td></tr>"
                ."<tr bgcolor=\"$bgcolor4\"><td width=250 align=right><b>"._NLVIDEOCARD."</b></td>"
                ."<td><input type=text name=video maxlength=30 style=\"width: 240px;\" value=$video></td></tr>"
                ."<tr bgcolor=\"$bgcolor3\"><td width=250 align=right><b>"._NLSOUNDCARD."</b></td>"
                ."<td><input type=text name=sound maxlength=30 style=\"width: 240px;\" value=$sound></td></tr>"
                ."<tr bgcolor=\"$bgcolor4\"><td width=250 align=right><b>"._NLHEADPHONES."</b></td>"
                ."<td><input type=text name=headphones maxlength=30 style=\"width: 240px;\" value=$headphones></td></tr>"
                ."<tr bgcolor=\"$bgcolor3\"><td width=250 align=right><b>"._NLMONITOR."</b></td>"
                ."<td><input type=text name=monitor maxlength=30 style=\"width: 240px;\" value=$monitor></td></tr>"
                ."<tr bgcolor=\"$bgcolor4\"><td width=250 align=right><b>"._NLMOUSE."</b></td>"
                ."<td><input type=text name=mouse maxlength=30 style=\"width: 240px;\" value=$mouse></td></tr>"
                ."<tr bgcolor=\"$bgcolor3\"><td width=250 align=right><b>"._NLMOUSEPAD."</b></td>"
                ."<td><input type=text name=mousepad maxlength=30 style=\"width: 240px;\" value=$mousepad></td></tr>"
                ."<tr bgcolor=\"$bgcolor4\"><td width=250 align=right><b>"._NLKEYBOARD."</b></td>"
                ."<td><input type=text name=keyboard maxlength=30 style=\"width: 240px;\" value=$keyboard></td></tr>"
                ."<tr><td colspan=2 align=right><input type=submit value=\""._NLSUBMIT."\" style=\"width: 160px;\"></td></tr>"
                ."</table>"
                ."</form>";
}

function edit_profile($error) {
        global $prefix, $db,  $uid, $bgcolor1, $bgcolor2, $bgcolor3, $bgcolor4, $textcolor1, $textcolor2, $pid, $ModName;

$user_info = $db->sql_fetchrow($db->sql_query("SELECT * FROM ".$prefix."_users WHERE user_id='$uid'"));
$user_profile = $db->sql_fetchrow($db->sql_query("SELECT * FROM nukelan_gamer_profiles WHERE user_id='$uid'"));
$user_rig = $db->sql_fetchrow($db->sql_query("SELECT * FROM nukelan_gamer_rigs WHERE user_id='$uid'"));


$genders = array('male' => 'male', 'female' => 'female');
$locals = array('yes' => 'yes', 'no' => 'no');
$proficiencies = array('1' => '1 -', '2' => '2 -', '3' => '3 -', '4' => '4 -', '5' => '5 -', '6' => '6 -', '7' => '7 -', '8' => '8 -', '9' => '9 -', '10' => '10 -');

        echo "<h3 style=\"margin: 4px 1px 4px 1px;\">"._NLEDITPROFILE."</h3>&nbsp;<font size=2><b>$user_info[username]</b></font><br>"
                ."<form action=\"modules.php\" method=\"post\" style=\"margin: 0;\">\n"
                ."<input type=hidden name=op value=modload>\n"
                ."<input type=hidden name=name value=$ModName>\n"
                ."<input type=hidden name=file value=profile>\n"
                ."<input type=hidden name=lanop value=update>\n"
                ."<input type=hidden name=uid value=".$uid.">"
                ."<input type=hidden name=pid value=".$pid.">";
        if ($error) echo "$error<br>";  
        echo "<table width=400 border=0 cellspacing=1 cellpadding=3 align=middle>"
                ."<tr bgcolor=\"$bgcolor3\"><td width=250 align=right><b>"._NLREALNAME."</b> "._NLREALNAME2."</td>"
                ."<td><input type=text name=realname2 maxlength=30 style=\"width: 240px;\" value=\"$user_profile[name]\" ></td></tr>"
                ."<tr bgcolor=\"$bgcolor4\"><td width=250 align=right><b>"._NLALIAS."</b> "._NLALIAS2."</td>"
                ."<td><input type=text name=alias maxlength=30 style=\"width: 240px;\" value=\"$user_profile[alias]\"></td></tr>"
                ."<tr bgcolor=\"$bgcolor3\"><td width=250 align=right><b>"._NLGROUP."</b> "._NLGROUP2."</td>"
                ."<td><input type=text name=gaming_group maxlength=30 style=\"width: 240px;\" value=\"$user_profile[gaming_group]\"></td></tr>"
                ."<tr bgcolor=\"$bgcolor4\"><td width=250 align=right><b>"._NLAGE."</b></td>"
                ."<td><input type=text name=age maxlength=2 style=\"width: 120px;\" value=\"$user_profile[age]\"></td></tr>"
                ."<tr bgcolor=\"$bgcolor3\"><td width=250 align=right><b>"._NLGENDER."</b></td>"
                ."<td><select name=gender>";
        foreach ($genders as $value => $name) {
                if ($user_profile['gender'] == $value) echo "<option value=$value SELECTED>$name</option>";
                else echo "<option value=$value>$name</option>";
        }               
        echo "</select></td></tr>"
                ."<tr bgcolor=\"$bgcolor4\"><td width=250 align=right><b>"._NLAREYOULOCAL."</b></td>"
                ."<td><select name=local>";
        foreach ($locals as $value => $name) {
                if ($user_profile['local'] == $value) echo "<option value=$value SELECTED>$name</option>";
                else echo "<option value=$value>$name</option>";
        }
        echo "</select></td></tr>"
                ."<tr bgcolor=\"$bgcolor3\"><td width=250 align=right><b>"._NLPROFICIENCY."</b></td>"
                ."<td><select name=proficiency>";
        foreach ($proficiencies as $num => $text) {
                if ($user_profile['proficiency'] == $num) echo "<option value=$num SELECTED>$text</option>";
                else echo "<option value=$num>$text</option>";
        }
        echo "</td></tr>"
                ."<tr bgcolor=\"$bgcolor4\"><td width=250 align=right><b>"._NLQUOTE."</b> "._NLQUOTE2."</td>"
                ."<td><input type=text name=quote maxlength=30 style=\"width: 240px;\" value=\"$user_profile[quote]\"></td></tr>"
                ."<tr><td colspan=2>&nbsp;</td></tr>"
                ."<tr><td colspan=2><font size=2><b>"._NLHARDWARE."</b></font></td></tr>"
                ."<tr bgcolor=\"$bgcolor3\"><td width=250 align=right><b>"._NLMOBO."</b></td>"
                ."<td><input type=text name=mobo maxlength=30 style=\"width: 240px;\" value=\"$user_rig[mobo]\"></td></tr>"
                ."<tr bgcolor=\"$bgcolor4\"><td width=250 align=right><b>"._NLPROCESSOR."</b></td>"
                ."<td><input type=text name=processor maxlength=30 style=\"width: 240px;\" value=\"$user_rig[processor]\"></td></tr>"
                ."<tr bgcolor=\"$bgcolor3\"><td width=250 align=right><b>"._NLMEMORY."</b></td>"
                ."<td><input type=text name=memory maxlength=30 style=\"width: 240px;\" value=\"$user_rig[memory]\"></td></tr>"
                ."<tr bgcolor=\"$bgcolor4\"><td width=250 align=right><b>"._NLVIDEOCARD."</b></td>"
                ."<td><input type=text name=video maxlength=30 style=\"width: 240px;\" value=\"$user_rig[video]\"></td></tr>"
                ."<tr bgcolor=\"$bgcolor3\"><td width=250 align=right><b>"._NLSOUNDCARD."</b></td>"
                ."<td><input type=text name=sound maxlength=30 style=\"width: 240px;\" value=\"$user_rig[sound]\"></td></tr>"
                ."<tr bgcolor=\"$bgcolor4\"><td width=250 align=right><b>"._NLHEADPHONES."</b></td>"
                ."<td><input type=text name=headphones maxlength=30 style=\"width: 240px;\" value=\"$user_rig[headphones]\"></td></tr>"
                ."<tr bgcolor=\"$bgcolor3\"><td width=250 align=right><b>"._NLMONITOR."</b></td>"
                ."<td><input type=text name=monitor maxlength=30 style=\"width: 240px;\" value=\"$user_rig[monitor]\"></td></tr>"
                ."<tr bgcolor=\"$bgcolor4\"><td width=250 align=right><b>"._NLMOUSE."</b></td>"
                ."<td><input type=text name=mouse maxlength=30 style=\"width: 240px;\" value=\"$user_rig[mouse]\"></td></tr>"
                ."<tr bgcolor=\"$bgcolor3\"><td width=250 align=right><b>"._NLMOUSEPAD."</b></td>"
                ."<td><input type=text name=mousepad maxlength=30 style=\"width: 240px;\" value=\"$user_rig[mousepad]\"></td></tr>"
                ."<tr bgcolor=\"$bgcolor4\"><td width=250 align=right><b>"._NLKEYBOARD."</b></td>"
                ."<td><input type=text name=keyboard maxlength=30 style=\"width: 240px;\" value=\"$user_rig[keyboard]\"></td></tr>"
                ."<tr><td colspan=2 align=right><input type=submit value=\""._NLSUBMIT."\" style=\"width: 160px;\"></td></tr>"
                ."</table>"
                ."</form>";

}

function add_profile($uid, $pid, $realname, $alias, $gaming_group, $age, $gender, $local, $proficiency, $quote, $mobo, $processor, $memory, $video, $sound, $headphones, $monitor, $mouse, $mousepad, $keyboard) {
global $prefix, $db;
        if (!$realname || !$age) {
        $error .= "<font color=red><b>"._NLREALNAMEREQUIRED."</b></font><br>";
        new_profile($realname, $alias, $gaming_group, $age, $gender, $local, $proficiency, $quote, $mobo, $processor, $memory, $video, $sound, $headphones, $monitor, $mouse, $mousepad, $keyboard, $error);
        }
        elseif (!$db->sql_query("INSERT INTO nukelan_gamer_profiles (user_id, name, alias, gaming_group, age, gender, local, proficiency, quote) VALUES ('$uid', '$realname', '$alias', '$gaming_group', '$age', '$gender', '$local', '$proficiency', '$quote')")) {
        $error .= "<font color=red><b>"._NLCANNOTINSERTPROFILE."</b></font><br>";
        new_profile($realname, $alias, $gaming_group, $age, $gender, $local, $proficiency, $quote, $mobo, $processor, $memory, $video, $sound, $headphones, $monitor, $mouse, $mousepad, $keyboard, $error);
        }
        elseif (!$db->sql_query("INSERT INTO nukelan_gamer_rigs (user_id, mobo, processor, memory, video, sound, headphones, monitor, mouse, mousepad, keyboard) VALUES ('$uid', '$mobo', '$processor', '$memory', '$video', '$sound', '$headphones', '$monitor', '$mouse', '$mousepad', '$keyboard')")) {
        $error .= "<font color=red><b>"._NLCANNOTINSERTRIG."</b></font><br>";
        new_profile($realname, $alias, $gaming_group, $age, $gender, $local, $proficiency, $quote, $mobo, $processor, $memory, $video, $sound, $headphones, $monitor, $mouse, $mousepad, $keyboard, $error);
        }
        else show_profile($uid);
}

function update_profile($uid, $pid, $alias, $gaming_group, $age, $gender, $local, $proficiency, $quote, $mobo, $processor, $memory, $video, $sound, $headphones, $monitor, $mouse, $mousepad, $keyboard) {
global $prefix, $db;
        if (!$age) {
        $error = "<font color=red><b>"._NLAGEREQUIRED."</b></font><br>";
        edit_profile($error);
        }
        elseif (!$db->sql_query("UPDATE nukelan_gamer_profiles SET alias='$alias', gaming_group='$gaming_group', age='$age', gender='$gender', local='$local', proficiency='$proficiency', quote='$quote' WHERE user_id='$uid'")) {
        $error = "<font color=red><b>"._NLCANNOTUPDATEPROFILE."</b></font><br>";
        edit_profile($error);
        }
        elseif (!$db->sql_query("UPDATE nukelan_gamer_rigs SET mobo='$mobo', processor='$processor', memory='$memory', video='$video', sound='$sound', headphones='$headphones', monitor='$monitor', mouse='$mouse', mousepad='$mousepad', keyboard='$keyboard' WHERE user_id='$uid'")) {
        $error = "<font color=red><b>"._NLCANNOTUPDATERIG."</b></font><br>";
        edit_profile($error);
        }
        else show_profile($uid);
}

switch ($lanop) {
        case 'edit':
                edit_profile('');
                break;
        case 'show_profile':
                show_profile($profile_id);
                break;
        case 'update':
                update_profile($uid, $pid, $alias, $gaming_group, $age, $gender, $local, $proficiency, $quote, $mobo, $processor, $memory, $video, $sound, $headphones, $monitor, $mouse, $mousepad, $keyboard);
                break;
        case 'add':
                add_profile($uid, $pid, $realname, $alias, $gaming_group, $age, $gender, $local, $proficiency, $quote, $mobo, $processor, $memory, $video, $sound, $headphones, $monitor, $mouse, $mousepad, $keyboard);
                break;
        case 'new':
                new_profile('', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
                break;
        default:
                if (!$db->sql_numrows($db->sql_query("SELECT * FROM nukelan_gamer_profiles WHERE user_id='$uid'"))) new_profile('', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
                else edit_profile('');
                break;
}

CloseTable();
include ("footer.php");

?>
