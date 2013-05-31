<?php
// filename: tourneys.php
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
$moddir = "modules/$ModName/";  

$index = $lanconfig['index'];
include ("header.php");

        global $db, $prefix, $user_prefix, $uname, $uid, $pid;
        $user = base64_decode($user);
        $user = explode(":", $user);
        $uid = "$user[0]";
        $uname = "$user[1]";
        $pwd = "$user[2]";
        
$tourneys = $db->sql_query("SELECT * FROM nukelan_tournaments ORDER BY tourneyid");
$num_tourneys = $db->sql_numrows($tourneys);
$parties = $db->sql_query("SELECT * FROM nukelan_parties");
$num_parties = $db->sql_numrows($parties);
global $db, $prefix, $user_prefix, $pid;
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


if ($delusr) foreach ($delusr as $user) {
$iscaptain = $db->sql_numrows($db->sql_query("SELECT * FROM nukelan_tournament_teams WHERE captainid='$user' AND id='$teamid'"));
   if ($iscaptain) echo ""._NLUSERISCAPTAIN.""; 
   elseif (!$db->sql_query("DELETE FROM nukelan_tournament_players WHERE userid='$user' AND teamid='$teamid'")) echo ""._NLCOULDNOTDELETEUSER."$user.";
   }
function PickParty($parties) {
   global $db, $prefix, $user_prefix, $bgcolor1, $bgcolor2, $bgcolor3, $bgcolor4, $textcolor1, $textcolor2, $ModName, $sitename;
   echo "<center><h2>"._NLPICKAPARTYTOVIEW."</h2></center>\n"
       ."<table align=center border=0 cellpadding=3 cellspacing=1 bgcolor=\"$bgcolor1\" width=\"75%\">\n"
           ."<tr style=\"background-color: $bgcolor2; color: $textcolor1; font-weight: bold;\">\n"
           ."<td width=\"100%\">"._NLPARTYNAME."</td>\n"
           ."</tr>\n";
           $bc = $bgcolor3;
   while($lan = $db->sql_fetchrow($parties)) {
      if ($bc == $bgcolor3) $bc = $bgcolor4;
      else $bc = $bgcolor3;
      echo "    <tr bgcolor=\"$bc\">\n"
              ."<td>\n"
                  ."<a href=\"modules.php?op=modload&name=$ModName&amp;file=tourneys&amp;lanop=show_list&amp;pid=$lan[party_id]\">$lan[keyword]</a></td>\n"
                  ." </tr>\n";
                  }
        echo "</table>\n";
}

function ShowNothing($lan) {
global $db, $prefix, $user_prefix, $ModName;
echo "<center><font size=2 color=green><b>"._NLSUCCESS."  <a href=\"modules.php?name=$ModName&file=tourneys\">"._NLCLICKHERE."</a> "._NLTORETURNTOMODULE."</b></font></center>\n";
}

function ListTourneys($tourneys, $pid) {
global $db, $prefix;
$row = $db->sql_fetchrow($db->sql_query("SELECT * FROM nukelan_parties WHERE party_id='$pid'"));
   global $db, $prefix, $user_prefix, $bgcolor1, $bgcolor2, $bgcolor3, $bgcolor4, $textcolor1, $textcolor2, $ModName, $sitename;
   echo "   <center><h2>"._NLTOURNAMENTSAT." $row[keyword]:</h2></center>\n"
       ."   <table align=center border=0 cellpadding=3 cellspacing=1 bgcolor=\"$bgcolor1\" width=\"75%\">\n"
       ."<br><br><font size=1><b>"._NLINFO."</b>  $row[tinfo]\n"
           ."    <tr style=\"background-color: $bgcolor2; color: $textcolor1; font-weight: bold;\">\n"
       ."     <td width=\"85%\">"._NLTOURNEYNAME."</td>\n"
           ."<td width=\"15%\">"._NLNUMBER."<br>"._NLOFTEAMS."</td>\n"
       ."    </tr>\n";
   $bc = $bgcolor3;
   while($lan = $db->sql_fetchrow($tourneys)) {
   $num_team = $db->sql_query("SELECT * FROM nukelan_tournament_teams WHERE tourneyid='$lan[tourneyid]'");
   $numteams = $db->sql_numrows($num_team);
      if ($bc == $bgcolor3) $bc = $bgcolor4;
      else $bc = $bgcolor3;
      echo "    <tr bgcolor=\"$bc\">\n"
              ."     <td><a href=\"modules.php?op=modload&name=$ModName&amp;file=tourneys&amp;lanop=show_tourney&amp;tourneyid=$lan[tourneyid]&amp;pid=$pid\">$lan[name]</a></td>\n"
          ."<td><font size=1 color=green><b>$numteams</b></font></td>\n"
                  ."    </tr>\n";
      }
   echo "   </table>\n";
   }

function ShowTourney($lan) {
   global $db, $prefix, $user_prefix, $dbi, $bgcolor1, $bgcolor2, $bgcolor3, $bgcolor4, $textcolor1, $textcolor2, $ModName, $cookie;

$teams = $db->sql_query("SELECT l.*, u.* FROM ".$user_prefix."_users AS l LEFT JOIN nukelan_tournament_teams AS u ON (l.user_id=u.captainid) WHERE u.tourneyid='$lan[tourneyid]' ORDER BY u.id");
$mod = $db->sql_query("SELECT * FROM ".$user_prefix."_users WHERE user_id='$lan[moderatorid]'");
$mod2 = $db->sql_fetchrow($mod);
$party = $db->sql_fetchrow($db->sql_query("SELECT * FROM nukelan_parties WHERE party_id='$lan[config_id]'"));
$game_name = $db->sql_fetchrow($db->sql_query("SELECT * FROM nukelan_games WHERE gameid='$lan[gameid]'"));
if ($lan[ttype] == '1') $type=""._NLSINGLEELIM."";
elseif ($lan[ttype] == '4') $type=""._NLCONSOLATION."";
elseif ($lan[ttype] == '5') $type=""._NLDOUBLEELIM."";
elseif ($lan[ttype] == '10') $type=""._NLROUNDROBIN."";
//elseif ($lan[ttype] == '5') $type="Double Elimination";
        echo "<h3 align=center style=\"margin: 4px 1px 4px 1px;\">$lan[name]</h3><br>\n"
        ."<center><font size=2><b>"._NLTOURNEYTYPE."  </font><font size=2 color=red>$type</b></font><br><br>\n"
        ."<font size=2><b>"._NLGAME."  </font><font size=2 color=red>$game_name[name]</b></font><br><br>\n"
    ."<font size=2><b>"._NLMODERATEDBY."  </font><font size=2 color=red>$mod2[username]</b></font><br><br>\n"
        ."<font size=2><b>"._NLINFORMATION."  </b></font><br><font size=1>$lan[notes]</font></center><br><br>\n";
        //."<font size=2><b>More Information:  </b></font><font size=1>$teaminfo</font><br><br>\n";
        
        echo "   <table align=center border=0 cellpadding=3 cellspacing=1 bgcolor=\"$bgcolor1\" width=\"75%\">\n"
        ."\n"
       ."    <tr style=\"background-color: $bgcolor2; color: $textcolor1; font-weight: bold;\">\n"
       ."     <td width=\"5%\">#</td>\n"
       ."     <td width=\"60%\">"._NLTEAMNAME."</td>\n"
       ."     <td width=\"20%\">"._NLTEAMCAPTAIN."</td>\n"
       ."    </tr>\n";

        $bc = $bgcolor3;
                while($team = $db->sql_fetchrow($teams)) {
                $count_rows += 1;
        if ($bc == $bgcolor3) $bc = $bgcolor4;
        else $bc = $bgcolor3;
        echo "  <tr bgcolor=\"$bc\">\n"
          ."<td>".$count_rows."</td>\n"
        ."<td><a href=\"modules.php?op=modload&name=$ModName&amp;file=tourneys&amp;lanop=show_team&amp;pid=$lan[config_id]&amp;id=$team[id]\">\n";  
                echo "$team[name]\n";
        echo "</td>\n"
          ."   <td>";
        echo "<font size=2 color=green><b>$team[username]</b></font>\n"
                ."</td>\n"
                ."  </tr>\n";
        }
        echo "   </table>\n";
        echo "   <table align=center border=0 width=\"60%\">\n"
          ."    <tr>\n";
        if ($lan['random']) {
        echo "<font align=center color=red><b>"._NLTEAMSWILLBERANDOM."</b></font></tr></table>";
        }
        elseif ($lan['lockteams'] && !$lan['lockjoin']) {
        echo "<font align=center color=red><b>"._NLLOCKEDCREATION."</b></font></tr></table>";
        ShowJoin($lan, $pid);
        }
        elseif ($lan['lockjoin'] && !$lan['lockteams']) {
        echo "<font align=center color=red><b>"._NLLOCKEDJOIN."</b></font></tr></table>";
        ShowButtons($lan, $pid);
        }
        elseif ($lan['lockteams'] && $lan['lockjoin']) {
        echo "<font align=center color=red><b>"._NLTOURNEYLOCKED."</b></font></tr></table>";
        } else {
        echo "</tr></table>";
        ShowButtons($lan, $pid);
        ShowJoin($lan, $pid);
   }
   }
function ShowTeam ($pid, $team) {
   global $db, $prefix, $user_prefix, $dbi, $bgcolor1, $bgcolor2, $bgcolor3, $bgcolor4, $textcolor1, $textcolor2, $ModName, $cookie;
   
$tplayer = $db->sql_query("SELECT l.*, u.* FROM ".$user_prefix."_users AS l LEFT JOIN nukelan_tournament_players AS u ON (l.user_id=u.userid) WHERE u.teamid='$team[id]' ORDER BY l.username");
$num_play = $db->sql_numrows($tplayer);
$tid = $db->sql_fetchrow($db->sql_query("SELECT * FROM nukelan_tournaments WHERE tourneyid='$team[tourneyid]'"));
$pid = $tid[config_id];
        echo "<h3 align=center style=\"margin: 4px 1px 4px 1px;\">"._NLTEAM." $team[name]</h3><br>\n"
            ."<center><font size=2><b>"._NLTAG."   $team[sig]</b></font></center><br><br>\n";
        echo "   <table align=center border=0 cellpadding=3 cellspacing=1 bgcolor=\"$bgcolor1\" width=\"75%\">\n"
       ."    <tr style=\"background-color: $bgcolor2; color: $textcolor1; font-weight: bold;\">\n"
       ."     <td width=\"5%\">#</td>\n"
       ."     <td width=\"30%\">"._NLTEAMMEMBERS."</td>\n"
           ."     <td width=\"50%\">"._NLTEAMQUOTE."</td>\n"
       ."     <td width=\"10%\">"._NLTEAMPROFICIENCY."</td>\n"
       ."    </tr>\n";
        $bc = $bgcolor3;

        while($player = $db->sql_fetchrow($tplayer)) {
        $play = $db->sql_fetchrow($db->sql_query("SELECT * FROM nukelan_gamer_profiles WHERE user_id='$player[user_id]'"));
if ($play['proficiency'] == '1') $rating="10%";
elseif ($play['proficiency'] == '2') $rating="20%";
elseif ($play['proficiency'] == '3') $rating="30%";
elseif ($play['proficiency'] == '4') $rating="40%";
elseif ($play['proficiency'] == '5') $rating="50%";
elseif ($play['proficiency'] == '6') $rating="60%";
elseif ($play['proficiency'] == '7') $rating="70%";
elseif ($play['proficiency'] == '8') $rating="80%";
elseif ($play['proficiency'] == '9') $rating="90%";
elseif ($play['proficiency'] == '10') $rating="100%";
                $count_rows += 1;
        if ($bc == $bgcolor3) $bc = $bgcolor4;
        else $bc = $bgcolor3;
        echo "  <tr bgcolor=\"$bc\">\n"
          ."<td>".$count_rows."</td>\n"
          ."   <td><a href=\"modules.php?name=Forums&file=profile&mode=viewprofile&u=$player[user_id]\">";
                echo "$player[username]</a>";
        echo "</td>\n";
                echo "<td>'$play[quote]'";
                echo "</td>\n"
          ."   <td>";
        echo "<font size=2 color=green><b>$rating</b></font>\n"
                ."</td>\n"
                ."  </tr>\n";
        }
        while($count_rows < $tid[per_team]) {
        $count_rows += 1;
        if ($bc == $bgcolor3) $bc = $bgcolor4;
        else $bc = $bgcolor3;
        echo "  <tr bgcolor=\"$bc\">\n"
                 ."<td>".$count_rows."</td>\n"
                 ."<td>"._NLNOPLAYERYET."</td>\n"
                 ."<td>n/a</td>\n"
                 ."<td>n/a</td>\n"
                 ."</tr>\n";
                 }
        echo "   </table>\n";
    echo "   <table align=center border=0 width=\"60%\">\n"
          ."    <tr>\n";
        if ($tid['random']) {
        echo "<font align=center color=red><b>"._NLTEAMSWILLBERANDOM."</b></font></tr></table>";
        }
        elseif ($tid['lockteams'] && !$tid['lockjoin']) {
        echo "<font align=center color=red><b>"._NLLOCKEDCREATION."</b></font></tr></table>";
        ShowJoin($lan, $pid);
        }
        elseif ($tid['lockjoin'] && !$tid['lockteams']) {
        echo "<font align=center color=red><b>"._NLLOCKEDJOIN."</b></font></tr></table>";
        ShowButtons($lan, $pid);
        }
        elseif ($tid['lockteams'] && $tid['lockjoin']) {
        echo "<font align=center color=red><b>"._NLTOURNEYLOCKED."</b></font></tr></table>";
        } else {
        echo "</tr></table>";
        ShowButtons($lan, $pid);
        ShowJoin($lan, $pid);
   }
}
function ShowButtons($lan, $pid) {
 global $db, $prefix, $user_prefix, $cookie, $user, $uid, $ModName;
$signedup = $db->sql_numrows($db->sql_query("SELECT * FROM nukelan_signedup WHERE lan_uid='$uid' AND lan_id='$lan[config_id]'"));
$captain = $db->sql_numrows($db->sql_query("SELECT * FROM nukelan_tournament_teams WHERE captainid='$uid'"));
         echo "   <table align=center border=0>\n"
                          ."    <tr>\n";
                          if ($signedup)
                          echo "<td>\n"
                                 ."      <form action=\"modules.php\" method=\"post\" style=\"margin: 0;\">\n"
                                   ."      <input type=hidden name=op value=modload>\n"
                                   ."      <input type=hidden name=name value=$ModName>\n"
                                   ."      <input type=hidden name=file value=tourneys>\n"
                                   ."      <input type=hidden name=lanop value=do_form>\n"
                                   ."      <input type=hidden name=pid value='$pid'>\n"
                                   ."      <input type=submit name=create value=\""._NLCREATEATEAM."\" style=\"width: 120px;\">\n"
                                   ."      </form>\n"
                                   ."     </td>\n";
                
                if ($captain >= 1)                 
                         echo "<td>\n"
                                ."<form action=\"modules.php\" method=\"post\" style=\"margin:0;\">\n"
                                ."<input type=hidden name=op value=modload>\n"
                                ."<input type=hidden name=name value=$ModName>\n"
                                ."<input type=hidden name=file value=tourneys>\n"
                                ."<input type=hidden name=lanop value=kill_team>\n"
                                ."<input type=hidden name=uid value=".$uid.">\n"
                                ."<input type=hidden name=pid value='$pid'>\n"
                                ."<input type=submit value=\""._NLDELETEYOURTEAM."\" style=\"width: 120px;\">\n"
                                ."</form>\n"
                                ."</td>\n";
                if ($captain >= 1)
                         echo "<td>\n"
                                ."<form action=\"modules.php\" method=\"post\" style=\"margin:0;\">\n"
                                ."<input type=hidden name=op value=modload>\n"
                                ."<input type=hidden name=name value=$ModName>\n"
                                ."<input type=hidden name=file value=tourneys>\n"
                                ."<input type=hidden name=lanop value=edit_team>\n"
                                ."<input type=hidden name=uid value=".$uid.">\n"
                                ."<input type=hidden name=pid value='$pid'>\n"
                                ."<input type=submit value=\""._NLEDITYOURTEAM."\" style=\"width:120px;\">\n"
                                ."</form>\n"
                                ."</td>\n";
                        echo "</tr></table>";                   
}
function ShowButtons2($uid, $pid) {
 global $db, $prefix, $user_prefix, $cookie, $user, $ModName;
 
$result = $db->sql_query("SELECT * FROM nukelan_tournament_teams WHERE captainid='$uid'");
 echo "   <table border=0>\n"
          ."    <tr>\n";
            echo "<td>\n"
                    ."<h2>Delete a team:</h2><br>\n"
                        ."<form action=\"modules.php\" method=\"post\" style=\"margin:0;\">\n"
                        ."<input type=hidden name=op value=modload>\n"
                        ."<input type=hidden name=name value=$ModName>\n"
            ."<input type=hidden name=file value=tourneys>\n"
                        ."<input type=hidden name=lanop value=kill_team2>\n"
                        ."<input type=hidden name=uid value=".$uid.">\n"
                        ."<input type=hidden name=pid value='$pid'>\n"
                        ."<font size=2><b>"._NLSELECTTEAMTODELETE."</b></font><br>\n"
                        ."<select name=kteam>\n";
            while ($row = $db->sql_fetchrow($result)) { $row2 = $db->sql_fetchrow($db->sql_query("SELECT * FROM nukelan_tournaments WHERE tourneyid='$row[tourneyid]'")); echo "<option value=\"$row[id]\">$row[name] : $row2[name]</option>\n";
            }
            echo "</select><br>\n"
                        ."<input type=submit value=\""._NLCONFIRMDELETE."\" style=\"width: 120px;\">\n"
                        ."</form>\n"
                        ."</td>\n";
                echo "</tr></table>";   
}
function ShowButtons3($row, $pid) {
   global $db, $prefix, $user_prefix, $cookie, $user, $ModName;
  
$result = $db->sql_query("SELECT * FROM nukelan_tournaments ORDER BY name");
         echo "   <table border=0>\n"
          ."    <tr>\n"; 
                 echo"<td>\n"
                 ."<h2>"._NLCREATEATEAMTOP."</h2><br>\n"
                           ."<form action=\"modules.php\" method=\"post\" style=\"margin: 0;\">\n"
                           ."<input type=hidden name=op value=modload>\n"
               ."<input type=hidden name=name value=$ModName>\n"
               ."<input type=hidden name=file value=tourneys>\n"
                           ."<input type=hidden name=lanop value=make_team>\n"
                           ."<input type=hidden name=uid value=".$uid.">\n"
                           ."<input type=hidden name=pid value='$pid'>\n"
               ."<font size=1><b>"._NLTEAMNAME2."</b></font><br>\n"
                           ."<input type=text name=team_name maxlength=100 style=\"width: 200px;\"><br><br>\n"
                           ."<font size=1><b>"._NLTEAMSIG2."</b></font><br>\n"
                           ."<input type=text name=team_sig maxlength=20 style=\"width: 120px;\"><br><br>\n"
                           ."<font size=1><b>"._NLWHERETOPUTSIG."</b></font><br>\n"
                           ."<input type=radio name=team_sig_place value=1 CHECKED><font size=1><b>"._NLPREFIXBEFORE."</b></font><br>\n"
                           ."<input type=radio name=team_sig_place value=2><font size=1><b>"._NLSUFFIXAFTER."</b></font><br><br>\n"
                           ."<font size=1><b>"._NLWHATTOURNEY."</b>  "._NLTOURNEYPARTY."</font><br>\n"
                           ."<select name=tour>\n";
                while ($row = $db->sql_fetchrow($result)) { $party = $db->sql_fetchrow($db->sql_query("SELECT * FROM nukelan_parties WHERE party_id='$row[config_id]'")); echo "<option value=\"$row[tourneyid]\">$row[name] : $party[keyword]</option>\n";
                           }
                echo "</select><br>\n"   
                           ."<br><input type=submit value=\""._NLSUBMITTEAM."\" style=\"width: 120px;\">\n"
               ."</form>\n"
               ."</td>\n";
                echo "</tr></table>";
}
function ShowButtons4($uid, $pid) {
 global $db, $prefix, $user_prefix, $cookie, $user, $ModName;

$result = $db->sql_query("SELECT * FROM nukelan_tournament_teams WHERE captainid='$uid'");
 echo "   <table border=0>\n"
          ."    <tr>\n";
            echo "<td>\n"
                    ."<h2>"._NLEDITATEAMTOP."</h2><br>\n"
                        ."<form action=\"modules.php\" method=\"post\" style=\"margin:0;\">\n"
                        ."<input type=hidden name=op value=modload>\n"
                        ."<input type=hidden name=name value=$ModName>\n"
            ."<input type=hidden name=file value=tourneys>\n"
                        ."<input type=hidden name=lanop value=edit_team2>\n"
                        ."<input type=hidden name=uid value=".$uid.">\n"
                        ."<input type=hidden name=pid value=".$pid.">\n"
                        ."<font size=2><b>"._NLSELECTTEAMTOEDIT."</b></font><br>\n"
                        ."<select name=cteamid>\n";
            while ($row = $db->sql_fetchrow($result)) { $row2 = $db->sql_fetchrow($db->sql_query("SELECT * FROM nukelan_tournaments WHERE tourneyid='$row[tourneyid]'"));echo "<option value=\"$row[id]\">$row[name] : $row2[name]</option>\n";
            }
            echo "</select><br>\n"
                        ."<input type=submit value=\""._NLCONTINUE."\" style=\"width: 120px;\">\n"
                        ."</form>\n"
                        ."</td>\n";     
                echo "</tr></table>";
}
function ShowButtons5($uid, $cteamid, $pid) {
   global $db, $prefix, $user_prefix, $cookie, $user, $ModName;
     
$team = $db->sql_fetchrow($db->sql_query("SELECT * FROM nukelan_tournament_teams WHERE id='$cteamid'"));
$checked1 = '';
$checked2 = '';
if ($team['sigplace'] == 1) $checked1 = 'checked';
if ($team['sigplace'] == 2) $checked2 = 'checked';
$players = $db->sql_query("SELECT l.*, u.* FROM nukelan_tournament_players AS l LEFT JOIN ".$user_prefix."_users AS u ON (l.userid = u.user_id) WHERE l.teamid='$cteamid'");
if ($result = $db->sql_query("SELECT * FROM nukelan_tournaments ORDER BY name")) {
         echo "   <table border=0>\n"
          ."    <tr>\n"; 
                 echo"<td>\n"
                 ."<h2>"._NLEDITATEAMTOP."</h2><br>\n"
                           ."<form action=\"modules.php\" method=\"post\" style=\"margin: 0;\">\n"
                           ."<input type=hidden name=op value=modload>\n"
               ."<input type=hidden name=name value=$ModName>\n"
               ."<input type=hidden name=file value=tourneys>\n"
                           ."<input type=hidden name=lanop value=edit_team3>\n"
                           ."<input type=hidden name=uid value=".$uid.">\n"
                           ."<input type=hidden name=teamid value=\"$cteamid\">\n"
                           ."<input type=hidden name=pid value=\"$pid\">\n"
               ."<font size=1><b>"._NLTEAMNAME2."</b></font><br>\n"
                           ."<input type=text name=team_name maxlength=100 style=\"width: 200px;\" value=\"$team[name]\"><br><br>\n"
                           ."<font size=1><b>"._NLTEAMSIG2."</b></font><br>\n"
                           ."<input type=text name=team_sig maxlength=20 style=\"width: 120px;\" value=\"$team[sig]\"><br><br>\n"
                           ."<font size=1><b>"._NLWHERETOPUTSIG."</b></font><br>\n"
                           ."<input type=radio name=team_sig_place value=1 $checked1><font size=1><b>"._NLPREFIXBEFORE."</b></font><br>\n"
                           ."<input type=radio name=team_sig_place value=2 $checked2><font size=1><b>"._NLSUFFIXAFTER."</b></font><br><br>\n"
                           ."<font size=1><b>"._NLWHATTOURNEY."</b></font>  "._NLTOURNEYPARTY."<br>\n"
                           ."<select name=tour>\n";
                while ($row = $db->sql_fetchrow($result, MYSQL_ASSOC)) {
                $party = $db->sql_fetchrow($db->sql_query("SELECT * FROM nukelan_parties WHERE party_id='$row[config_id]'"));
                if ($team[tourneyid] == $row[tourneyid]) echo "<option value=\"$row[tourneyid]\" SELECTED>$row[name] : $party[keyword]</option>\n";
                else echo "<option value=\"$row[tourneyid]\">$row[name] : $party[keyword]</option>\n";
                           }
                        echo"</select><br>\n"   
                           ."<br><input type=submit value=\""._NLSUBMITCHANGES."\" style=\"width: 120px;\">\n"
               ."</form>\n"
               ."</td>\n";
                }       
                $num = $db->sql_fetchrow($db->sql_query("SELECT * FROM nukelan_tournaments WHERE tourneyid='$team[tourneyid]'"));
echo " "._NLEDITPLAYERS." $team[name]\n";
echo " <form action=\"modules.php\" method=\"post\">\n"
    ."<input type=hidden name=op value=modload>\n"
        ."<input type=hidden name=name value=$ModName>\n"
    ."<input type=hidden name=file value=tourneys>\n"
        ."<input type=hidden name=teamid value=\"$team[id]\">\n"
        ."<input type=hidden name=pid value=\"$pid\">\n"
    ." <table align=center border=0 cellpadding=3 cellspacing=1 bgcolor=\"$bgcolor1\" width=\"75%\">\n"
    ."  <tr style=\"background-color: $bgcolor2; color: $textcolor1; font-weight: bold;\">\n"
        ."<td width=\"5%\">#</td>\n"
        ."   <td width=\"70%\">"._NLUSERNAME."</td>\n"
        ."   <td width=\"20%\">"._NLTEAMPROFICIENCY."</td>\n"
    ."   <td width=\"5%\" align=center>"._NLDEL."</td>\n".$pntable[lanparty]
    ."  </tr>\n";
        $bc = $bgcolor3;
        while($usr = $db->sql_fetchrow($players)) {
                $profic = $db->sql_fetchrow($db->sql_query("SELECT * FROM nukelan_gamer_profiles WHERE user_id='$usr[user_id]'"));
        $count_rows += 1;
        if ($bc == $bgcolor3) $bc = $bgcolor4;
        else $bc = $bgcolor3;
        echo "  <tr bgcolor=\"$bc\">\n"
          ."<td>".$count_rows."</td>\n"
                  ."<td>$usr[username]</td>\n"
                  ."<td>$profic[proficiency]</td>\n"
                  ."<td align=center><input type=checkbox name=delusr[] value=$usr[user_id]></td>\n"
                  ."  </tr>\n";
      }
        while ($count_rows < $num['per_team']) {
        $count_rows += 1;
        if ($bc == $bgcolor3) $bc = $bgcolor4;
        else $bc = $bgcolor3;
        echo "  <tr bgcolor=\"$bc\">\n"
                ."<td>".$count_rows."</td>\n"
                ."   <td>"._NLNOPLAYERYET."</td>\n"
                ."   <td>???</td>\n"
                ."   <td align=center>n/a</td>\n"
                ."</tr>";
        }  
echo " </table>\n"
    ." <br>\n"
    ."  <input type=submit value=\""._NLDELETEPLAYERS."\">\n"
    ." </form>\n";                 
}
function ShowJoin($lan, $pid){
        global $db, $prefix, $user_prefix, $cookie, $user, $uid, $ModName;
        
$signedup = $db->sql_numrows($db->sql_query("SELECT * FROM nukelan_signedup WHERE lan_uid='$uid' AND lan_id='$lan[config_id]'"));
$ont = $db->sql_numrows($db->sql_query("SELECT * FROM nukelan_tournament_players WHERE userid='$uid' AND config_id='$lan[config_id]'"));
          echo "   <table align=center border=0>\n"
          ."    <tr>\n";
        if ($signedup)
                  echo "<td>\n"
             
                           ."      <form action=\"modules.php\" method=\"post\" style=\"margin: 0;\">\n"
                           ."      <input type=hidden name=op value=modload>\n"
               ."      <input type=hidden name=name value=$ModName>\n"
               ."      <input type=hidden name=file value=tourneys>\n"
                           ."      <input type=hidden name=lanop value=do_form2>\n"
                           ."      <input type=hidden name=pid value=\"$lan[config_id]\">\n"
               ."      <input type=submit value=\""._NLJOINTEAM."\" style=\"width: 120px;\">\n"
               ."      </form>\n"
               ."     </td>\n";
        
        if ($ont >= 1)             
                echo "<td>\n"
                
                           ."<form action=\"modules.php\" method=\"post\" style=\"margin: 0;\">\n"
                           ."<input type=hidden name=op value=modload>\n"
               ."<input type=hidden name=name value=$ModName>\n"
               ."<input type=hidden name=file value=tourneys>\n"
                           ."<input type=hidden name=lanop value=do_form3>\n"
                           ."<input type=hidden name=uid value=".$uid.">\n"
                           ."<input type=hidden name=pid value=\"$lan[config_id]\">\n"
                           ."<input type=submit value=\""._NLQUITTEAM."\" style=\"width: 120px;\">\n"
               ."</form>\n"
               ."</td>\n";
                echo "</tr></table>";
                          }

function ShowJoin2($row, $pid) {
   global $db, $prefix, $user_prefix, $cookie, $user, $ModName;

  $result = $db->sql_query("SELECT * FROM nukelan_tournament_teams WHERE config_id='$pid' ORDER BY name");
          echo "   <table border=0>\n"
          ."    <tr>\n";
                  
                  echo "<td>\n"
                ."<h2>"._NLJOINTEAM."</h2><br>\n"
                           ."      <form action=\"modules.php\" method=\"post\" style=\"margin: 0;\">\n"
                           ."      <input type=hidden name=op value=modload>\n"
               ."      <input type=hidden name=name value=$ModName>\n"
               ."      <input type=hidden name=file value=tourneys>\n"
                           ."      <input type=hidden name=lanop value=join_team>\n"
                           ."      <input type=hidden name=uid value=".$uid.">\n"
                           ."      <input type=hidden name=pid value=\"$pid\">\n"
                           ."<font size=2><b>"._NLCONFIRMJOIN."</b></font><br>\n"
                           ."<select name=wteam>\n";
                while ($row2 = $db->sql_fetchrow($row)) { echo "<option value=\"$row2[id]\">$row2[name]</option>\n";
                           }
                           echo "</select><br>\n"
                           ."      <input type=submit name=create value=\""._NLCONFIRMJOIN."\" style=\"width: 120px;\">\n"
               ."      </form>\n"
               ."     </td></table>\n";
}
function ShowJoin3($uid, $pid) {
   global $db, $prefix, $user_prefix, $cookie, $user, $ModName;

$result3 = $db->sql_query("SELECT * FROM nukelan_tournament_teams ORDER BY name");
$result = $db->sql_query("SELECT l.*, u.* FROM nukelan_tournament_teams AS l LEFT JOIN nukelan_tournament_players AS u ON (l.id=u.teamid) WHERE u.userid='$uid' ORDER BY name");
         echo "   <table border=0>\n"
          ."    <tr>\n";
                  
                  echo "<td>\n"
                ."<h2>"._NLQUITTEAM."</h2><br>\n"
                           ."      <form action=\"modules.php\" method=\"post\" style=\"margin: 0;\">\n"
                           ."      <input type=hidden name=op value=modload>\n"
               ."      <input type=hidden name=name value=$ModName>\n"
               ."      <input type=hidden name=file value=tourneys>\n"
                           ."      <input type=hidden name=lanop value=quit_team>\n"
                           ."      <input type=hidden name=uid value=".$uid.">\n"
                           ."<input type=hidden name=pid value=\"$pid\">\n"
                           ."<font size=2><b>"._NLWHICHTEAMTOQUIT."</b></font><br>\n"
                           ."<select name=qteam>\n";
           while ($row = $db->sql_fetchrow($result)) { echo "<option value=\"$row[teamid]\">$row[name]</option>\n";
                           }
                   echo "</select><br>\n"
                           ."<input type=submit name=create value=\""._NLCONFIRMQUIT."\" style=\"width: 120px;\">\n"
               ."      </form>\n"
               ."     </td>\n";
                echo "</tr></table>";
}
function JoinTeam($lan,$uid,$wteam,$qteam,$joint) {
global $db, $prefix;
$wtour = $db->sql_fetchrow($db->sql_query("SELECT * FROM nukelan_tournament_teams WHERE id='$wteam'"));
$onteam = $db->sql_numrows($db->sql_query("SELECT * FROM nukelan_tournament_players WHERE userid='$uid' AND tourneyid='$wtour[tourneyid]'"));
$onteam2 = $db->sql_numrows($db->sql_query("SELECT * FROM nukelan_tournament_players WHERE teamid='$wteam'"));
$cap = $db->sql_numrows($db->sql_query("SELECT * FROM nukelan_tournament_teams WHERE captainid='$uid' AND id='$qteam'"));
$pid = $lan['config_id'];

if ($uid <= 1) die ("You must be registered to join a team.");

    switch ($joint) {
         case 'drop':
             //if (!$onteam2) echo "<font color=\"#FF0000\" size=3><b>You are not a member of this team!</b></font><br>";
                 if ($cap) echo "<font color=\"#FF0000\" size=3><b>"._NLYOUARECAPTAIN."</b></font><br>";
                 elseif (!$db->sql_query("DELETE FROM nukelan_tournament_players WHERE userid='$uid' AND teamid='$qteam'")) echo ""._NLCANNOTDELETETEAM."<br>";
                 else ShowNothing($lan);
                 break;

        default:
         if ($onteam2 == $lan[perteam]) echo "<font color=\"#FF0000\" size=3><b>"._NLTEAMISFULL."</b></font><br>";
                 elseif ($onteam) echo "<font color=\"#FF0000\" size=3><b>"._NLALREADYPLAYER."</b></font><br>";
             elseif (!$db->sql_query("INSERT INTO nukelan_tournament_players (userid, teamid, tourneyid, config_id) Values ('$uid', '$wteam', '$wtour[tourneyid]', '$wtour[config_id]')")) echo ""._NLPROBABLYJOINEDTEAM."<br>";
         else ShowNothing($lan);
                 break;
}
}
                           
function SubmitTeam($uid,$team_name,$team_sig,$team_sig_place,$tour,$kteam,$create) {
global $db, $prefix;
$caps = $db->sql_query("SELECT * FROM nukelan_tournament_teams WHERE captainid='$uid' AND tourneyid='$tour'");
$caps2 = $db->sql_fetchrow($caps);
$team_id = "$caps2[id]";
$cap = $db->sql_numrows($caps);
$cap2 = $db->sql_numrows($db->sql_query("SELECT * FROM nukelan_tournament_teams WHERE captainid='$uid' AND id='$kteam'"));
$onteam = $db->sql_numrows($db->sql_query("SELECT * FROM nukelan_tournament_players WHERE userid='$uid' AND tourneyid='$tour'"));
$party = $db->sql_fetchrow($db->sql_query("SELECT * FROM nukelan_tournaments WHERE tourneyid='$tour'"));
$pid = "$party[config_id]";

if ($uid <= 1) die (""._NLMUSTBEREGISTEREDTODOTHIS."");
    switch ($create) {
         case 'player':
             if ($onteam) echo "<font color=\"#FF0000\" size=3><b>"._NLALREADYPLAYER."</b></font><br>";
                 elseif (!$db->sql_query("INSERT INTO nukelan_tournament_players (tourneyid, userid, teamid, config_id) Values ('$tour', '$uid', '$teamid', '$pid')")) echo ""._NLCANNOTJOINTEAM."<br>";
                 else ShowNothing($lan);
                 break;
         case 'captain':
             if (!$cap) echo "<font color=\"FF0000\" size=3><b>"._NLYOUARENOTACAPTAIN."</b></font><br>";
                 elseif ($onteam) echo "<font color=\"#FF0000\" size=3><b>"._NLALREADYPLAYER."</b></font><br>";
                 elseif (!$db->sql_query("INSERT INTO nukelan_tournament_players (tourneyid, userid, teamid, config_id) Values ('$tour', '$uid', '$team_id', '$pid')")) echo ""._NLYOUARENOTACAPTAIN."<br>";
                 else ShowNothing($lan);
                 break;
        case 'drop_team':
                 if (!$cap2) echo "<font color=\"#FF0000\" size=3><b>"._NLYOUCANNOTDELETETEAM."</b></font><br>";
                 elseif (!$db->sql_query("DELETE FROM nukelan_tournament_teams WHERE id='$kteam'")) echo ""._NLCANNOTDELETETEAM." - drop_team<br>";
                 else ShowNothing($lan);
                 break;                  
        case 'drop_players':
                 if (!cap2) echo "<font color=\"#FF0000\" size=3><b>"._NLYOUCANNOTDELETEPLAYERS."</b></font><br>";
                 elseif (!$db->sql_query("DELETE FROM nukelan_tournament_players WHERE teamid='$kteam'")) echo ""._NLCANNOTDELETETEAMMEMBERS." - drop_players<br>";
                 else ShowNothing($lan);
                 break;
         default:
         if ($cap) echo "<font color=\"#FF0000\" size=3><b>"._NLALREADYHAVETEAM."</b></font><br>";
                 elseif ($onteam) echo "<font color=\"#FF0000\" size=3><b>"._NLALREADYPLAYER."</b></font><br>";
             elseif (!$db->sql_query("INSERT INTO nukelan_tournament_teams (tourneyid, name, captainid, sig, sigplace, config_id) Values ('$tour', '$team_name', '$uid', '$team_sig', '$team_sig_place', '$pid')")) echo ""._NLALREADYCREATEDTEAM."<br>";
         else ShowNothing($lan);
                 break;
}
}
function UpdateTeam($teamid,$teamid, $team_name, $team_sig, $team_sig_place, $tour) {
global $db, $prefix, $user_prefix, $ModName;
        if (!$db->sql_query("UPDATE nukelan_tournament_teams SET name='$team_name', sig='$team_sig', sigplace='$team_sig_place', tourneyid='$tour' WHERE id='$teamid'")) echo "<b>"._NLSUCKEDHARD."</b>";
        else echo "<h3>"._NLTEAMUPDATED."</h3><br><center><font size=2 color=green><b>"._NLSUCCESS."  <a href=\"modules.php?name=$ModName&file=tourneys\">"._NLCLICKHERE." ddd</a> "._NLTORETURNTOMODULE."</b></font></center>";
        }

switch ($lanop) {
   case 'show_tourney':
      $tourney = $db->sql_fetchrow($db->sql_query("SELECT * FROM nukelan_tournaments WHERE tourneyid='$tourneyid'"));
          ShowTourney($tourney);
      break;
   case 'show_team':
      $teamd = $db->sql_fetchrow($db->sql_query("SELECT * FROM nukelan_tournament_teams WHERE id='$id'"));
      ShowTeam($pid, $teamd);
      break;
   case 'do_form':
      $row = $db->sql_query("SELECT * FROM nukelan_tournaments WHERE config_id='$pid'");
      //ShowForm($tourney);
          ShowButtons3($row, $pid);
          break;   
   case 'do_form2':
      $row = $db->sql_query("SELECT * FROM nukelan_tournament_teams WHERE config_id='$pid'");
          //ShowForm2($teamd);
          ShowJoin2($row, $pid);
          break;
   case 'do_form3':
      $teamd = $db->sql_fetchrow($db->sql_query("SELECT * FROM nukelan_tournament_teams WHERE id='$id'"));
          //ShowForm3($teamd);
          ShowJoin3($uid, $pid);
          break;
   case 'do_form4':
      $teamd = $db->sql_fetchrow($db->sql_query("SELECT * FROM nukelan_tournament_teams WHERE id='$id'"));
          ShowForm4($teamd);
          break;
   case 'make_team':
          SubmitTeam($uid,$team_name,$team_sig,$team_sig_place,$tour,$kteam,'');
          SubmitTeam($uid,$team_name,$team_sig,$team_sig_place,$tour,$kteam,'captain');
          break;
   case 'kill_team':
          $teamd = $db->sql_fetchrow($db->sql_query("SELECT * FROM nukelan_tournament_teams WHERE id='$id'"));
          //ShowForm4('','');
          ShowButtons2($uid, $pid);
          break;  
   case 'kill_team2':
      SubmitTeam($uid,$team_name,$team_sig,$team_sig_place,$tour,$kteam,'drop_team');
          SubmitTeam($uid,$team_name,$team_sig,$team_sig_place,$tour,$kteam,'drop_players');
          break;
   case 'join_team':
      JoinTeam($lan,$uid,$wteam,$qteam,'');
          break;
   case 'quit_team':
     JoinTeam($lan,$uid,$wteam,$qteam,'drop');
          break;   
   case 'edit_team':
     ShowButtons4($uid, $pid);
         break;
   case 'edit_team2':
     ShowButtons5($uid, $cteamid, $pid);
         break; 
   case 'edit_team3':
     UpdateTeam($teamid,$teamid, $team_name, $team_sig, $team_sig_place, $tour);
         break;
   case 'show_list':
   $tourneys = $db->sql_query("SELECT * FROM nukelan_tournaments WHERE config_id='$pid' ORDER BY name");
   $num_tourneys = $db->sql_numrows($tourneys);
   if ($num_tourneys >= 1) {
           ListTourneys($tourneys, $pid);
          }
      else echo "<table border=0 width=100%><tr height=500px valign=center><td align=center><h2>"._NLNOTOURNEYSFORPARTY."</h2></td></tr></table>";
      break;
         break;
   default:
      if ($num_tourneys) PickParty($parties);
      else echo "<table border=0 width=100%><tr height=500px valign=center><td align=center><h2>"._NLNOTOURNEYS."</h2></td></tr></table>";
      break;
   }
CloseTable();
echo "<br>";
include ("footer.php");
?>
