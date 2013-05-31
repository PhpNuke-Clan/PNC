<?php
// filename: add_teams.php

if (!defined('ADMIN_FILE')) {
        die ("Access Denied");
}
include ("header.php");

lan_menu();
OpenTable();
 global $db, $prefix, $user_prefix, $editTeam, $admin_file;
if ($delusr) foreach ($delusr as $user) {

$teamd = $db->sql_query("SELECT * FROM nukelan_tournament_teams WHERE captainid='$user' AND id='$teamid'");
$teamsd = $db->sql_fetchrow($teamd);
$iscaptain = $db->sql_numrows($teamd);
$teamd2 = $db->sql_query("SELECT * FROM nukelan_tournament_teams WHERE id='$teamid'");
$teamsd2 = $db->sql_fetchrow($teamd2);
$tname=$teamsd2["name"];

   if ($iscaptain){ echo ""._NLUSERISCAPTAIN."";
   }elseif (!$db->sql_query("DELETE FROM nukelan_tournament_players WHERE userid='$user' AND teamid='$teamid'"))
   {echo ""._NLCANNOTDELETEUSER."$user.";
   }else{ echo "<h2>"._NLCHANGESMADETO." $tname</h2>";}
}
//global $db, $prefix, $user_prefix, $editTeam, $admin_file;
if ($db->sql_numrows($result = $db->sql_query("SELECT id, name FROM nukelan_tournament_teams"))) {
   echo "   <table border=\"0\">\n"
       ."    <tr>\n"
       ."     <td>\n"
       ."      <form action=\"".$admin_file.".php\" method=\"post\" style=\"margin: 0;\">\n"
       ."       <input type=hidden name=op value=add_team>\n"
       ."       <input type=hidden name=lanop value=edit_team>\n"
       ."       <b>"._NLEDITTEAM."&nbsp;&nbsp;</b>\n"
       ."       <select name=editTeam>\n";
   while ($row = $db->sql_fetchrow($result)) {
                if ($row[id]== $editTeam) echo "<option value=\"$row[id]\" SELECTED>$row[name]</option>";
                else echo "        <option value=\"$row[id]\">$row[name]</option>\n";
                }
   echo "       </select>\n"
       ."       <input type=submit value=\""._NLEDIT."\">\n"
       ."      </form>\n"
       ."     </td>\n";
   $result = $db->sql_query("SELECT id, name FROM nukelan_tournament_teams");
   echo "     <td>&nbsp;&nbsp;</td>\n"
       ."     <td>\n"
       ."      <form action=\"".$admin_file.".php\" method=\"post\" style=\"margin: 0;\">\n"
       ."       <input type=hidden name=op value=add_team>\n"
       ."       <input type=hidden name=lanop value=delete_team>\n"
       ."       <b>"._NLDELETETEAM."&nbsp;&nbsp;</b>\n"
       ."       <select name=deleteTeam>\n";
   while ($row = $db->sql_fetchrow($result)) echo "        <option value=\"$row[id]\">$row[name]</option>\n";
   echo "       </select>\n"
       ."       <input type=submit value=\""._NLDELETE."\">\n"
       ."      </form>\n"
       ."     </td>\n"
       ."    </tr>\n"
       ."   </table>\n";
   CloseTable();
   echo "   <br>\n";
   OpenTable();
   }
   
// shows form to add a location/also is where we redirect unfinnished forms
function showAddForm($name, $captain, $sig, $sigplace, $tourneyid, $error) {
global $db, $prefix, $user_prefix, $admin_file;
$tourneys = $db->sql_query("SELECT tourneyid, name FROM nukelan_tournaments ORDER BY name");
$caps = $db->sql_query("SELECT DISTINCT l.lan_uid, u.* FROM nukelan_signedup AS l LEFT JOIN ".$user_prefix."_users AS u ON (l.lan_uid=u.user_id) ORDER BY u.username");

   echo "   <form action=\"".$admin_file.".php\" method=\"post\">\n"
       ."   <input type=hidden name=op value=\"add_team\">\n"
       ."   <input type=hidden name=lanop value=\"add_new\">\n"
       ."    <h3>"._NLADDTEAM."</h3>\n";
   if ($error) echo "   $error<br>\n";
   echo "   <b>Team Info:</b><br>\n"
       ."   &nbsp;&nbsp;&nbsp;"._NLTEAMNAME."<br>\n"
       ."   &nbsp;&nbsp;&nbsp;<input type=text size=50 maxlength=255 name=name value=\"$name\"><br>\n"
       ."   &nbsp;&nbsp;&nbsp;"._NLTEAMCAP."<br>\n"
       ."   &nbsp;&nbsp;&nbsp;<select name=captain>\n";
   while ($caps2 = $db->sql_fetchrow($caps)) echo "<option value=\"$caps2[user_id]\">$caps2[username]</option>\n";
   echo "   </select><br>\n"
           ."   &nbsp;&nbsp;&nbsp;"._NLTEAMTOURNEY."<br>\n"
       ."   &nbsp;&nbsp;&nbsp;<select name=tourneyid>\n";
   while ($tid = $db->sql_fetchrow($tourneys)) echo " <option value=\"$tid[tourneyid]\">$tid[name]</option>\n";
   echo "  </select><br>\n"
       ."   &nbsp;&nbsp;&nbsp;"._NLTEAMSIG."<br>\n"
       ."   &nbsp;&nbsp;&nbsp;<input type=text size=10 maxlength=255 name=sig value=\"$sig\"><br>\n"
       ."  &nbsp;&nbsp;&nbsp;"._NLTEAMSIGPLACE."<br>\n"
           ."  &nbsp;&nbsp;&nbsp;<input type=radio name=sigplace value='1' CHECKED>"._NLPREFIX."\n"
           ."  &nbsp;&nbsp;&nbsp;<input type=radio name=sigplace value='2'>"._NLSUFFIX."<br>\n"
           ."  &nbsp;&nbsp;&nbsp;<input type=submit value=\""._NLADDTEAM."\">\n"
       ."   </form>";
   }

// this allows us to edit a team
function editTeam($editTeam) {
global $db, $prefix, $user_prefix, $admin_file;
$tourneys = $db->sql_query("SELECT tourneyid, name FROM nukelan_tournaments ORDER BY name");
$players = $db->sql_query("SELECT * FROM nukelan_tournament_players WHERE teamid='$editTeam'");
$caps = $db->sql_query("SELECT DISTINCT l.lan_uid, u.* FROM nukelan_signedup AS l LEFT JOIN ".$user_prefix."_users AS u ON (l.lan_uid=u.user_id) ORDER BY u.username");
$team = $db->sql_fetchrow($db->sql_query("SELECT * FROM nukelan_tournament_teams WHERE id='$editTeam'"));
   echo "   <table width=\"100%\" border=\"0\">\n"
          ."   <tr><td colspan=\"2\" align=\"middle\"><big.<h3>"._NLEDITTEAM." $editTeam "._NLEDITTEAMSECTION."</h3></big></td></tr>\n"
          ."   <tr><td width=\"40%\">\n";
   echo "   <form action=\"".$admin_file.".php\" method=\"post\">\n"
       ."   <input type=hidden name=op value=\"add_team\">\n"
       ."   <input type=hidden name=lanop value=\"update_team\">\n"
           ."<input type=hidden name=teamid value=\"$editTeam\">\n"
       ."    <h3>"._NLEDITTEAM."</h3>\n";
   if ($error) echo "   $error<br>\n";
   echo "   <b>Team Info:</b><br>\n"
       ."   &nbsp;&nbsp;&nbsp;"._NLTEAMNAME."<br>\n"
       ."   &nbsp;&nbsp;&nbsp;<input type=text size=25 maxlength=255 name=name value=\"$team[name]\"><br>\n"
       ."   &nbsp;&nbsp;&nbsp;"._NLTEAMCAP."<br>\n"
       ."   &nbsp;&nbsp;&nbsp;<select name=captain>\n";
   while ($caps2 = $db->sql_fetchrow($caps)) {
   if ($team[captainid] == $caps2[user_id]) echo " <option value=\"$caps2[user_id]\" SELECTED>$caps2[username]</option>\n";
   else echo "<option value=\"$caps2[user_id]\">$caps2[username]</option>\n";
   }
   echo "   </select><br>\n"
           ."   &nbsp;&nbsp;&nbsp;"._NLTEAMTOURNEY."<br>\n"
       ."   &nbsp;&nbsp;&nbsp;<select name=tourneyid>\n";
   while ($tid = $db->sql_fetchrow($tourneys)) {
   if ($team[tourneyid] == $tid[tourneyid]) echo " <option value=\"$tid[tourneyid]\" SELECTED>$tid[name]</option>\n";
   else echo "<option value=\"$tip[tourneyid]\">$tid[name]</option>n";
   }
   echo "  </select><br>\n"
       ."   &nbsp;&nbsp;&nbsp;"._NLTEAMSIG."<br>\n"
       ."   &nbsp;&nbsp;&nbsp;<input type=text size=10 maxlength=255 name=sig value=\"$team[sig]\"><br>\n"
       ."  &nbsp;&nbsp;&nbsp;"._NLTEAMSIGPLACE."<br>\n"
           ."  &nbsp;&nbsp;&nbsp;<input type=radio name=sigplace value='1' CHECKED>"._NLPREFIX."\n"
           ."  &nbsp;&nbsp;&nbsp;<input type=radio name=sigplace value='2'>"._NLSUFFIX."<br>\n"
           ."  &nbsp;&nbsp;&nbsp;<input type=submit value=\""._NLUPDATETEAM."\">\n"
       ."   </form>";
   echo "  </td><td width=\"60%\">\n";

 /*  echo "   <form action=\"".$admin_file.".php\" method=\"post\">\n"
       ."   <input type=hidden name=op value=\"add_team\">\n"
       ."   <input type=hidden name=lanop value=\"edit_players\">\n"
           ."<input type=hidden name=teamid value=\"$editTeam\">\n"
           ."<input type=submit value=\""._NLEDITPLAYERS."\">\n"
           ."</form>";
 */
             $teamid=$editTeam;
           editPlayers($teamid, $error);
    echo "  </td></tr></table>\n";
   }
//edits players on a team
function editPlayers($teamid, $error) {
 global $db, $prefix, $user_prefix, $bgcolor1, $bgcolor2, $bgcolor3, $bgcolor4, $textcolor1, $textcolor2, $ModName, $sitename, $admin_file;
$team = $db->sql_fetchrow($db->sql_query("SELECT * FROM nukelan_tournament_teams WHERE id='$teamid'"));
$num = $db->sql_fetchrow($db->sql_query("SELECT * FROM nukelan_tournaments WHERE tourneyid='$team[tourneyid]'"));
$players = $db->sql_query("SELECT l.*, u.* FROM ".$user_prefix."_users AS l LEFT JOIN nukelan_tournament_players AS u ON (l.user_id=u.userid) WHERE u.teamid='$teamid' ORDER BY l.username");
$num_players = $db->sql_numrows($players);

echo " <center><h3>"._NLEDITPLAYERS2." $team[name]</h3>\n"
    ." $error</center>\n";
echo " <form action=\"".$admin_file.".php\" method=\"post\">\n"
    ."  <input type=hidden name=op value=add_team>\n"
    ."<input type=hidden name=teamid value=\"$team[id]\">\n"
    ." <table align=center border=0 cellpadding=3 cellspacing=1 bgcolor=\"$bgcolor1\" width=\"100%\">\n"
    ."  <tr style=\"background-color: $bgcolor2; color: $textcolor1; font-weight: bold;\">\n"
        ."<td width=\"5%\">#</td>\n"
        ."   <td width=\"70%\">"._NLTEAMUSERNAME."</td>\n"
        ."   <td width=\"20%\">"._NLTEAMPROFICIENCY."</td>\n"
    ."   <td width=\"5%\" align=center>"._NLDEL."</td>\n".$pntable[lanparty]
    ."  </tr>\n";
        $bc = $bgcolor3;
        while($usr = $db->sql_fetchrow($players)) {
        $count_rows += 1;
        if ($bc == $bgcolor3) $bc = $bgcolor4;
        else $bc = $bgcolor3;
        echo "  <tr bgcolor=\"$bc\">\n"
          ."<td>".$count_rows."</td>\n"
                  ."<td>$usr[username]</td>\n"
                  ."<td>$usr[proficiency]</td>\n"
                  ."<td align=center><input type=checkbox name=delusr[] value=$usr[userid]></td>\n"
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
    ." <br><center>\n"
    ."  <input type=submit value=\""._NLSUBMITCHANGES."\"></center>\n"
    ." </form>\n";

if ($num_players < $num['per_team'])
        
echo "<form action=\"".$admin_file.".php\" method=\"post\">\n"
    ."<input type=hidden name=op value=add_team>\n"
        ."<input type=hidden name=lanop value=add_new_player>\n"
        ."<input type=hidden name=teamid value=\"$teamid\">\n"
        ."<input type=hidden name=tourneyid value=\"$team[tourneyid]\">\n"
        ."<center><input type=submit value=\""._NLADDNEWPLAYER."\"></center>\n"
        ."</form>";
}
// selects a player to add to team
function addPlayer($teamid, $tourneyid) {
global $db, $prefix, $user_prefix, $admin_file;
//$users = $db->sql_query("SELECT userid, username FROM users ORDER BY username");
$team = $db->sql_fetchrow($db->sql_query("SELECT * FROM nukelan_tournament_teams WHERE id='$teamid'"));
$users = $db->sql_query("SELECT l.*, u.* FROM ".$user_prefix."_users AS l LEFT JOIN nukelan_signedup AS u ON (l.user_id=u.lan_uid) WHERE u.lan_id='$team[config_id]' ORDER BY l.username");

echo "<form action=\"".$admin_file.".php\" method=\"post\">\n"
    ."<input type=hidden name=op value=add_team>\n"
        ."<input type=hidden name=lanop value=update_players>\n"
        ."<input type=hidden name=teamid value=\"$teamid\">\n"
        ."<input type=hidden name=tourneyid value=\"$tourneyid\">\n"
        ."<h2>"._NLADDPLAYERTOTEAM." $team[name]</h2>\n"
        ."<br><br>"._NLCHOOSEUSER."<br>\n"
        ."<select name=addme>\n";
while ($usr = $db->sql_fetchrow($users)) echo "<option value=\"$usr[user_id]\">$usr[username]</option>\n";
echo "</select><br>\n"
   ."<input type=submit value=\""._NLADDPLAYER."\">\n"
   ."</form>";

}
// adds player to database
function updatePlayers($teamid, $tourneyid, $addme) {
global $db, $prefix, $user_prefix, $editTeam, $admin_file;
$party = $db->sql_fetchrow($db->sql_query("SELECT * FROM nukelan_tournaments WHERE tourneyid='$tourneyid'"));
$pid = "$party[config_id]";
$intourney = $db->sql_numrows($db->sql_query("SELECT * FROM nukelan_tournament_players WHERE userid='$addme' AND tourneyid='$tourneyid'"));
   if ($intourney){ echo "<center><font color=red size=2><b>"._NLUSERALREADYINTOURNEY."</b><br><br>";
   echo"<form><input type=button value=\"Back\" onCLick=\"history.back()\"></form></font></center>";
//Header("Refresh: 0;url=history.back()");
        }elseif (!$db->sql_query("INSERT INTO nukelan_tournament_players SET id='NULL', teamid='$teamid', tourneyid='$tourneyid', userid='$addme', config_id='$pid'"))
   {echo ""._NLCANNOTINSERT."";
   }else {
   echo "<h2>Player Added!</h2>\n";
     Header("Refresh: ;url=".$admin_file.".php?op=add_team&lanop=edit_team&editTeam=$teamid");
     }

}

// adds the location to database
function addTeam($name, $captain, $sig, $sigplace, $tourneyid,$addnew) {
global $db, $prefix, $user_prefix, $editTeam, $admin_file;
$team = $db->sql_fetchrow($db->sql_query("SELECT id FROM nukelan_tournament_teams WHERE captainid='$captain' AND tourneyid='$tourneyid'"));
$party = $db->sql_fetchrow($db->sql_query("SELECT * FROM nukelan_tournaments WHERE tourneyid='$tourneyid'"));
$pid = "$party[config_id]";
switch ($addnew) {
  case 'cap':
   if (!$db->sql_query("INSERT INTO nukelan_tournament_players SET id='NULL', tourneyid='$tourneyid', userid='$captain', teamid='$team[id]', config_id='$pid'")) die (""._NLCANNOTINSERT."");
   break;
  default:
   if (!$name || !$captain) showAddForm($name, $captain, $sig, $sigplace, $tourneyid, ""._NLREQUIREDFIELDS."");
   elseif (!$db->sql_query("INSERT INTO nukelan_tournament_teams SET id='NULL', tourneyid='$tourneyid', name='$name', captainid='$captain', sig='$sig', sigplace='$sigplace', config_id='$pid'")) die (""._NLCANNOTINSERT."");
   else {
      echo "   <center>\n"
          ."    <h2>"._NLTEAMADDED." '$name'</h2>\n"
          ."   </center>";
          Header("Refresh: 0;url=".$admin_file.".php?op=add_team");
      }
   break;
   }
   }

// updates a location
function updateTeam($teamid, $name, $captain, $sig, $sigplace, $tourneyid) {
global $db, $prefix, $user_prefix, $editTeam, $admin_file;
$party = $db->sql_fetchrow($db->sql_query("SELECT * FROM nukelan_tournaments WHERE tourneyid='$tourneyid'"));
$pid = "$party[config_id]";

   if (!$name || !$captain) {echo ""._NLREQUIREDFIELDS.""; 
   editTeam($teamid);
      }
   elseif (!$db->sql_query("UPDATE nukelan_tournament_teams SET name='$name', captainid='$captain', sig='$sig', tourneyid='$tourneyid', sigplace='$sigplace', config_id='$pid' WHERE id='$teamid'")) die (""._NLCANNOTUPDATE."");
   else {
      echo "   <center>\n"
          ."    <h2>"._NLTEAMUPDATED." $name</h2>\n"
          ."   </center>";
          Header("Refresh: 0;url=".$admin_file.".php?op=add_team");
      }
   }

function deleteTeam($deleteTeam) {
global $db, $prefix, $user_prefix, $editTeam, $admin_file;
   if (!$db->sql_query("DELETE FROM nukelan_tournament_teams WHERE id='$deleteTeam'")) $error .= ""._NLCANNOTDELETETEAM."<br>";
   elseif (!$db->sql_query("DELETE FROM nukelan_tournament_players WHERE teamid='$deleteTeam'")) $error .= ""._NLCANNOTDELETEPLAYERS."<br>";
   else echo "<center><h2>"._NLTEAMDELETED."</h2></center>";
   if (!$error){ Header("Refresh: 0;url=".$admin_file.".php?op=add_team");
   }else{
   echo $error;
        }
   }

switch ($lanop) {
   case "add_new":
      addTeam($name, $captain, $sig, $sigplace, $tourneyid,'');
          addTeam($name, $captain, $sig, $sigplace, $tourneyid,'cap');
      break;
   case "update_team":
      updateTeam($teamid, $name, $captain, $sig, $sigplace, $tourneyid);
      break;
   case "edit_team":
      editTeam($editTeam);
      break;
   case "delete_team":
      deleteTeam($deleteTeam);
      break;
   case "edit_players":
      editPlayers($teamid, $error);
          break;
   case "add_new_player":
      addPlayer($teamid, $tourneyid);
          break;
   case "update_players":
      updatePlayers($teamid, $tourneyid, $addme);
          break;
   default:
      showAddForm('','','','','','');
      break;
   }
CloseTable();
include ("footer.php");

?>
