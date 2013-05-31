<?php
// filename: add_alp_tourney.php

if (!defined('ADMIN_FILE')) {
        die ("Access Denied");
}
include ("header.php");
$module_name = "Nukelan";
lan_menu();
OpenTable();
// Tourney DropDown menu
global $db, $prefix, $user_prefix, $editTourney, $deleteTourney, $admin_file;
if ($db->sql_numrows($result = $db->sql_query("SELECT tourneyid, name FROM nukelan_tournaments"))) {
   echo "   <table border=0>\n"
       ."    <tr>\n"
       ."     <td>\n"
       ."      <form action=\"".$admin_file.".php\" method=\"post\" style=\"margin: 0;\">\n"
       ."       <input type=hidden name=op value=add_tournament>\n"
       ."       <input type=hidden name=lanop value=edit_tourney>\n"
       ."       <b>"._NLEDITTOURNEY."&nbsp;&nbsp;</b>\n"
       ."       <select name=editTourney>\n";
   while ($row = $db->sql_fetchrow($result)) {
                if ($row[tourneyid]== $editTourney){
                echo "<option value=\"$row[tourneyid]\" SELECTED>$row[name]</option>";
                }else{ echo "        <option value=\"$row[tourneyid]\">$row[name]</option>\n";
                        }
                }
   echo "       </select>\n"
       ."       <input type=submit value=\""._NLEDIT."\">\n"
       ."      </form>\n"
       ."     </td>\n";
   $result = $db->sql_query("SELECT tourneyid, name FROM nukelan_tournaments");
   echo "     <td>&nbsp;&nbsp;</td>\n"
       ."     <td>\n"
       ."      <form action=\"".$admin_file.".php\" method=\"post\" style=\"margin: 0;\">\n"
       ."       <input type=hidden name=op value=add_tournament>\n"
       ."       <input type=hidden name=lanop value=delete_tourney>\n"
       ."       <b>"._NLDELETETOURNEY."&nbsp;&nbsp;</b>\n"
       ."       <select name=deleteTourney>\n";
   while ($row = $db->sql_fetchrow($result)) {
                if ($row[tourneyid]== $deleteTourney) echo "<option value=\"$row[tourneyid]\" SELECTED>$row[name]</option>";
                else echo "        <option value=\"$row[tourneyid]\">$row[name]</option>\n";
                }
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
//End Tourney DropDown menu

// shows form to add a location/also is where we redirect unfinnished forms
function showAddForm($namer, $pid, $game, $ttype, $tmod, $rteam, $perteam, $tyear, $tmonth, $tday, $thour, $tmin, $tsec, $url_stats, $lockjoin, $lockteams, $rules) {
   global $db, $prefix, $user_prefix, $admin_file, $module_name;
   include ("modules/$module_name/admin/incl/tournament_types.php");
   include ("modules/$module_name/admin/incl/datetime.php");
$games = $db->sql_query("SELECT gameid, name FROM nukelan_games ORDER BY name");
$gmods = $db->sql_query("SELECT * FROM ".$user_prefix."_users ORDER BY username");
$parties = $db->sql_query("SELECT * FROM nukelan_parties ORDER BY keyword");

   echo "   <form action=\"".$admin_file.".php\" method=\"post\">\n"
       ."   <input type=hidden name=op value=\"add_tournament\">\n"
       ."   <input type=hidden name=lanop value=\"add_new\">\n"
       ."   <center>\n"
       ."    <h3>"._NLADDTOURNEY."</h3>\n";
  // if ($error) echo "   $error<br>\n";
   echo "   </center>\n"
       ."   <b>"._NLTOURNEYINFO."</b><br>\n"
       ."   &nbsp;&nbsp;&nbsp;"._NLTOURNEYTYPE."<br>\n"
       ."   &nbsp;&nbsp;&nbsp;<input type=text size=50 maxlength=255 name=namer value=\"$namer\"><br>\n"
           ."   &nbsp;&nbsp;&nbsp;"._NLTOURNEYLAN."<br>\n"
           ."   &nbsp;&nbsp;&nbsp;<select name=pid>\n";
   while ($lan = $db->sql_fetchrow($parties)) echo "<option value=\"$lan[party_id]\">$lan[keyword]</option>\n";
   echo "   &nbsp;&nbsp;&nbsp;</select><br>\n"
       ."   &nbsp;&nbsp;&nbsp;"._NLTOURNEYGAME."<br>\n"
       ."   &nbsp;&nbsp;&nbsp;<select name=game>\n";
   while ($games2 = $db->sql_fetchrow($games))   {
        if($games2["gameid"]==$game) {
        echo "<option value=\"$games2[gameid]\" SELECTED>$games2[name]</option>\n";}
        else{echo "<option value=\"$games2[gameid]\">$games2[name]</option>\n";
                   }
                }
   echo "   </select>\n";
   echo "   <br>\n"
           ."   &nbsp;&nbsp;&nbsp;"._NLTOURNEYTYPE."<br>\n"
       ."   &nbsp;&nbsp;&nbsp;<select name=ttype>\n";
   foreach ($tournament_types as $num => $text) {
      if ($ttype == $num) echo "   <option value=\"$num\" SELECTED>$text</option>\n";
          else echo "   <option value=\"$num\">$text</option>\n";
          }
   echo "  </select><br>\n"
       ."   &nbsp;&nbsp;&nbsp;"._NLTOURNEYMOD."<br>\n"
       ."   &nbsp;&nbsp;&nbsp;<select name=tmod>\n";

   while ($gmod = $db->sql_fetchrow($gmods)) {
                  if($gmod[user_id]==$tmod) {
           echo "    <option value=\"$gmod[user_id]\" SELECTED>$gmod[username]</option>\n";
        }else{
           echo "    <option value=\"$gmod[user_id]\">$gmod[username]</option>\n";}
   }
   if($rteam== 1){$ck1 = "checked"; $ck0 = ""; } else { $ck1 = ""; $ck0 = "checked"; }  
   echo "   </select><br>\n"
       ."  &nbsp;&nbsp;&nbsp;"._NLTOURNEYRANDOM."<br>\n"
           ."  &nbsp;&nbsp;&nbsp;<input type=radio name=rteam value='0' $ck0><b>"._NLNO."</b>\n"
           ."  &nbsp;&nbsp;&nbsp;<input type=radio name=rteam value='1' $ck1><b>"._NLYES."</b><br>\n"
           ."  &nbsp;&nbsp;&nbsp;"._NLTOURNEYMAX."<br>\n"
           ."  &nbsp;&nbsp;&nbsp;<input type=text size=10 maxlength=10 name=perteam value='$perteam'><br>\n"
           // this will just have to suffice... - Artemis
           ."  &nbsp;&nbsp;&nbsp;"._NLTOURNEYDATE."<br>\n"
           ."  &nbsp;&nbsp;&nbsp;<select name=tyear>\n";
   foreach ($years as $num => $text) {
      if (date ("Y") == $num) echo "   <option value=\"$num\" SELECTED>$text</option>\n";
          else echo "   <option value=\"$num\">$text</option>\n";
          }
   echo "</select>\n"
       ."  <b>/</b>\n"
       ."  <select name=tmonth>\n";
   foreach ($months as $num => $text) {
      if (date ("F") == $num) echo "  <option value=\"$num\" SELECTED>$text</option>\n";
          else echo "   <option value=\"$num\">$text</option>\n";
          }
   echo "  </select>\n"
       ."  <b>/</b>\n"
           ."  <select name=tday>\n";
   foreach ($days as $num => $text) {
      if ($tday == $num) echo "  <option value=\"$num\" SELECTED>$text</option>\n";
          else echo "   <option value=\"$num\">$text</option>\n";
          }
   echo "  </select>\n"
        ."  &nbsp;&nbsp;&nbsp;<select name=thour>\n";
   foreach ($hours as $num => $text) {
      if ($thour == $num) echo "  <option value=\"$num\" SELECTED>$text</option>\n";
          else echo "   <option value=\"$num\">$text</option>\n";
          }
   echo "  </select>\n"
       ."  <b>:</b>\n"
           ."  <select name=tmin>\n";
   foreach ($minutes as $num => $text) {
      if ($tmin == $num) echo "  <option value=\"$num\" SELECTED>$text</option>\n";
          else echo "   <option value=\"$num\">$text</option>\n";
          }
   echo "  </select>\n"
       ."  <b>:</b>\n"
           ."  <select name=tsec>\n";
   foreach ($minutes as $num => $text) {
      if ($tsec == $num) echo "  <option value=\"$num\" SELECTED>$text</option>\n";
          else echo "   <option value=\"$num\">$text</option>\n";
          }
   echo "  </select><br>\n"
           ."  &nbsp;&nbsp;&nbsp;"._NLTOURNEYURL."<br>\n"
       ."  &nbsp;&nbsp;&nbsp;<input type=text size=50 maxlength=255 name=url_stats value=\"$url_stats\"><br>\n"
           ."  &nbsp;&nbsp;&nbsp;"._NLTOURNEYLOCK1."<br>\n";
        if($lockjoin == 1){$ck1 = "checked"; $ck0 = ""; } else { $ck1 = ""; $ck0 = "checked"; }  
   echo"  &nbsp;&nbsp;&nbsp;<input type=radio name=lockjoin value='0' $ck0><b>"._NLNO."  </b>\n"
           ."  &nbsp;&nbsp;&nbsp;<input type=radio name=lockjoin value='1'$ck1><b>"._NLYES."  </b><br>\n"
           ."  &nbsp;&nbsp;&nbsp;"._NLTOURNEYLOCK2."<br>\n";
        if($lockteams == 1){$ck1 = "checked"; $ck0 = ""; } else { $ck1 = ""; $ck0 = "checked"; }  
   echo"  &nbsp;&nbsp;&nbsp;<input type=radio name=lockteams value='0' $ck0><b>"._NLNO."  </b>\n"
           ."  &nbsp;&nbsp;&nbsp;<input type=radio name=lockteams value='1'$ck1><b>"._NLYES."  </b><br>\n"
           ."  &nbsp;&nbsp;&nbsp;"._NLTOURNEYRULES."<br>\n"
           ."  &nbsp;&nbsp;&nbsp;<textarea name=rules style=\"width: 75%; height: 100px;\">$rules</textarea><br>\n"
       ."   <br>\n"
       ."  &nbsp;&nbsp;&nbsp; <input type=submit value=\""._NLADDTOURNEY."\">\n"
       ."   </form>";
   }

// this allows us to edit a tournament
function editTourney($editTourney) {
        global $db, $prefix, $user_prefix, $admin_file, $module_name;
   include ("modules/$module_name/admin/incl/tournament_types.php");
   include ("modules/$module_name/admin/incl/datetime.php");
$games = $db->sql_query("SELECT gameid, name FROM nukelan_games ORDER BY name");
//$gmods = $db->sql_query("SELECT l.*, u.* FROM nukelan_signedup AS l LEFT JOIN ".$user_prefix."_users AS u ON (l.lan_uid=u.user_id) ORDER BY u.username");
$gmods = $db->sql_query("SELECT * FROM ".$user_prefix."_users ORDER BY username");
$parties = $db->sql_query("SELECT * FROM nukelan_parties ORDER BY keyword");
   $loc = $db->sql_fetchrow($db->sql_query("SELECT * FROM nukelan_tournaments WHERE tourneyid='$editTourney'"));
  preg_match("/(.+)-(.+)-(.+) (.+):(.+):(.*)/i", "$loc[itemtime]", $matches);
  $tyear = $matches[1];
  $tmonth = $matches[2];
  $tday = $matches[3];
  $thour = $matches[4];
  $tminute = $matches[5];
  $tsec = $matches[6];
   echo "   <form action=\"".$admin_file.".php\" method=\"post\">\n"
       ."   <input type=hidden name=op value=\"add_tournament\">\n"
       ."   <input type=hidden name=lanop value=\"update_tourney\">\n"
       ."   <input type=hidden name=tourneyid value=\"$editTourney\">\n"
       ."   <input type=hidden name=namer value=\"$loc[name]\">\n"
       ."   <center>\n"
       ."    <h3>"._NLEDITTOURNEY." $loc[name]</h3>\n"
       ."   </center>\n"
       ."   <b>"._NLTOURNEYINFO."</b><br>\n"
           ."   &nbsp;&nbsp;&nbsp;"._NLTOURNEYNAME."<br>\n"
       ."   &nbsp;&nbsp;&nbsp;<input type=text size=50 maxlength=255 name=namer value=\"$loc[name]\"><br>\n"
           ."   &nbsp;&nbsp;&nbsp;"._NLTOURNEYLAN."<br>\n"
           ."   &nbsp;&nbsp;&nbsp;<select name=pid>\n";
   while ($lan = $db->sql_fetchrow($parties)) {
     if ($loc[config_id] == $lan[party_id]) echo "<option value=\"$lan[party_id]\" SELECTED>$lan[keyword]</option>\n";
         else echo "<option value=\"$lan[party_id]\">$lan[keyword]</option>\n";
         }
   echo "   &nbsp;&nbsp;&nbsp;</select><br>\n"
       ."   &nbsp;&nbsp;&nbsp;"._NLTOURNEYGAME."<br>\n"
       ."   &nbsp;&nbsp;&nbsp;<select name=game>\n";
   while ($games2 = $db->sql_fetchrow($games)) {
     if ($loc[gameid] == $games2[gameid]) echo " <option value=\"$games2[gameid]\" SELECTED>$games2[name]</option>\n";
         else echo "<option value=\"$games2[gameid]\">$games2[name]</option>\n";
         }
   echo "   </select><br>\n"
           ."   &nbsp;&nbsp;&nbsp;"._NLTOURNEYTYPE."<br>\n"
       ."   &nbsp;&nbsp;&nbsp;<select name=ttype>\n";
   foreach ($tournament_types as $num => $text) {
      if ($loc[ttype] == $num) echo "   <option value=\"$num\" SELECTED>$text</option>\n";
          else echo "   <option value=\"$num\">$text</option>\n";
          }
   echo "  </select><br>\n"
       ."   &nbsp;&nbsp;&nbsp;"._NLTOURNEYMOD."<br>\n"
       ."   &nbsp;&nbsp;&nbsp;<select name=tmod>\n";
   while ($gmod = $db->sql_fetchrow($gmods)) {
     if ($loc[moderatorid] == $gmod[user_id]) echo "    <option value=\"$gmod[user_id]\" SELECTED>$gmod[username]</option>\n";
         else echo "<option value=\"$gmod[user_id]\">$gmod[username]</option>\n";
         }
   echo "   </select><br>\n"
       ."  &nbsp;&nbsp;&nbsp;"._NLTOURNEYDATE."<br>\n"
           ."  &nbsp;&nbsp;&nbsp;<select name=tyear>\n";
   foreach ($years as $num => $text) {
      if ($tyear == $num) echo "   <option value=\"$num\" SELECTED>$text</option>\n";
          else echo "   <option value=\"$num\">$text</option>\n";
          }
   echo "</select>\n"
       ."  <b>/</b>\n"
       ."  <select name=tmonth>\n";
   foreach ($months as $num => $text) {
      if ($tmonth == $num) echo "  <option value=\"$num\" SELECTED>$text</option>\n";
          else echo "   <option value=\"$num\">$text</option>\n";
          }
   echo "  </select>\n"
       ."  <b>/</b>\n"
           ."  <select name=tday>\n";
   foreach ($days as $num => $text) {
      if ($tday == $num) echo "  <option value=\"$num\" SELECTED>$text</option>\n";
          else echo "   <option value=\"$num\">$text</option>\n";
          }
   echo "  </select>\n"
        ."  &nbsp;&nbsp;&nbsp;<select name=thour>\n";
   foreach ($hours as $num => $text) {
      if ($thour == $num) echo "  <option value=\"$num\" SELECTED>$text</option>\n";
          else echo "   <option value=\"$num\">$text</option>\n";
          }
   echo "  </select>\n"
       ."  <b>:</b>\n"
           ."  <select name=tmin>\n";
   foreach ($minutes as $num => $text) {
      if ($tminute == $num) echo "  <option value=\"$num\" SELECTED>$text</option>\n";
          else echo "   <option value=\"$num\">$text</option>\n";
          }
   echo "  </select>\n"
       ."  <b>:</b>\n"
           ."  <select name=tsec>\n";
   foreach ($minutes as $num => $text) {
      if ($tsec == $num) echo "  <option value=\"$num\" SELECTED>$text</option>\n";
          else echo "   <option value=\"$num\">$text</option>\n";
          }
   echo "  </select><br>\n"
           ."  &nbsp;&nbsp;&nbsp;"._NLTOURNEYURL."<br>\n"
       ."  &nbsp;&nbsp;&nbsp;<input type=text size=50 maxlength=255 name=url_stats value='$loc[url_stats]'><br>\n"
           ."  &nbsp;&nbsp;&nbsp;"._NLTOURNEYLOCK1."<br>\n"
           ."  &nbsp;&nbsp;&nbsp;<input type=radio name=lockjoin value='0' CHECKED><b>"._NLNO."  </b>\n"
           ."  &nbsp;&nbsp;&nbsp;<input type=radio name=lockjoin value='1'><b>"._NLYES."  </b><br>\n"
           ."  &nbsp;&nbsp;&nbsp;"._NLTOURNEYLOCK2."<br>\n"
           ."  &nbsp;&nbsp;&nbsp;<input type=radio name=lockteams value='0' CHECKED><b>"._NLNO."  </b>\n"
           ."  &nbsp;&nbsp;&nbsp;<input type=radio name=lockteams value='1'><b>"._NLYES."  </b><br>\n"
           ."  &nbsp;&nbsp;&nbsp;"._NLTOURNEYRULES."<br>\n"
           ."  &nbsp;&nbsp;&nbsp;<textarea name=rules style=\"width: 75%; height: 100px;\">$loc[notes]</textarea><br>\n"
       ."   <br>\n"
       ."   <input type=submit value=\""._NLEDITTOURNEY2."\">\n"
       ."   </form>\n";
   }

// adds the location to database
function addTournament($namer, $pid, $game, $ttype, $tmod, $rteam, $perteam, $tyear, $tmonth, $tday, $thour, $tmin, $tsec, $url_stats, $lockjoin, $lockteams, $rules) {
   global $db, $prefix, $user_prefix, $admin_file, $module_name;
   if ($tyear && $tmonth && $tday && $thour && $tmin && $tsec) {
           $date = "$tyear-$tmonth-$tday $thour:$tmin:$tsec";
   } else {
           echo "NO";
   }
   if (!$namer || !$game || !$ttype || !$tmod || !$perteam)/* showAddForm($namer, $pid, $game, $ttype, $tmod, $rteam, $perteam, $url_stats, $lockjoin, $lockteams, $rules);*/
   {echo ""._NLREQUIREDFIELDS."";
   showAddForm($namer, $pid, $game, $ttype, $tmod, $rteam, $perteam, $tyear, $tmonth, $tday, $thour, $tmin, $tsec, $url_stats, $lockjoin, $lockteams, $rules);}
   elseif ($db->sql_numrows($db->sql_query("SELECT tourneyid FROM nukelan_tournaments WHERE name='$namer'"))) /*showAddForm($namer, $game, $ttype, $tmod, $rteam, $perteam, $url_stats, $lockjoin, $lockteams, $rules, ""._NLKEYWORDINUSE."");*/
  // {echo""._NLREQUIREDFIELDS."";}
 {echo ""._NLKEYWORDINUSE."";  showAddForm($namer, $pid, $game, $ttype, $tmod, $rteam, $perteam, $tyear, $tmonth, $tday, $thour, $tmin, $tsec, $url_stats, $lockjoin, $lockteams, $rules);}
   elseif (!$db->sql_query("INSERT INTO nukelan_tournaments SET name='$namer', itemtime='$date', gameid='$game', ttype='$ttype', moderatorid='$tmod', random='$rteam', per_team='$perteam', url_stats='$url_stats', lockjoin='$lockjoin', lockteams='$lockteams', notes='$rules', config_id='$pid'")) die (""._NLCANNOTINSERT."");
   else {
      echo "   <center>\n"
          ."    <h2>"._NLTOURNEYADDED."</h2>\n"
          ."   </center>";
                    header( "refresh: 1; url=".$admin_file.".php?op=add_tournament" );
      }
   }

// updates a location
function updateTournament($tourneyid, $namer, $pid, $game, $ttype, $tmod, $rteam, $perteam, $tyear, $tmonth, $tday, $thour, $tmin, $tsec, $url_stats, $lockjoin, $lockteams, $rules) {
   global $db, $prefix, $user_prefix, $admin_file, $module_name;
   if ($tyear && $tmonth && $tday && $thour && $tmin && $tsec) $date = "$tyear-$tmonth-$tday $thour:$tmin:$tsec";
   if (!$namer || !$game || !$ttype || !$tmod) {echo ""._NLREQUIREDFIELDS."";
   editTourney($tourneyid);
      }
   elseif (!$db->sql_query("UPDATE nukelan_tournaments SET name='$namer', gameid='$game', ttype='$ttype', moderatorid='$tmod', itemtime='$date', url_stats='$url_stats', lockjoin='$lockjoin', lockteams='$lockteams', notes='$rules', config_id='$pid' WHERE tourneyid='$tourneyid'")) die (""._NLCANNOTUPDATE."");
   elseif (!$db->sql_query("UPDATE nukelan_tournament_teams SET config_id='$pid' WHERE tourneyid='$tourneyid'")) echo ""._NLTOURNEYERROR1."";
   elseif (!$db->sql_query("UPDATE nukelan_tournament_players SET config_id='$pid' WHERE tourneyid='$tourneyid'")) echo ""._NLTOURNEYERROR2."";
   else {
      echo "   <center>\n"
          ."    <h2>"._NLTOURNEYUPDATED."</h2>\n"
          ."   </center>";
                              header( "refresh: 1; url=".$admin_file.".php?op=add_tournament" );
      }
   }

function deleteTourney($deleteTourney) {
   global $db, $prefix, $user_prefix, $admin_file, $module_name;
   if (!$db->sql_query("DELETE FROM nukelan_tournaments WHERE tourneyid='$deleteTourney'")) $error .= ""._NLCANNOTDELETETOURNEY."<br>";
   elseif (!$db->sql_query("DELETE FROM nukelan_tournament_teams WHERE tourneyid='$deleteTourney'")) $error .= ""._NLCANNOTDELETETOURNEYTEAMS."<br>";
   elseif (!$db->sql_query("DELETE FROM nukelan_tournament_players WHERE tourneyid='$deleteTourney'")) $error .= ""._NLCANNOTDELETETOURNEYPLAYERS."<br>";
   else echo "<center><h2>"._NLTOURNEYDELETED."</h2></center>";
   echo $error;
header( "refresh: 1; url=".$admin_file.".php?op=add_tournament" );
   }

function addTournament2($namer, $pid, $game, $ttype, $tmod, $rteam, $perteam, $tyear, $tmonth, $tday, $thour, $tmin, $tsec, $url_stats, $lockjoin, $lockteams, $rules, $error) {
   global $db, $prefix, $user_prefix, $admin_file, $module_name;
   echo"name: $namer<br>,pid: $pid,<br>game: $game,<br>ttype: $ttype,<br>tmod: $tmod,<br>trteam: $rteam,perteam: <br>$perteam,<br>tyear: $tyear, <br>tmonth: $tmonth,<br>tday: $tday,<br>thour: $thour,<br>tmin: $tmin,<br>tsec: $tsec,<br>urlstats: $url_stats,<br>lockjoin: $lockjoin,<br>lockteams: $lockteams,<br>rules: $rules,<br>error: $error";
   echo $error;
   }
function eRRor() {
   global $db, $prefix, $user_prefix, $admin_file, $module_name;
   //echo"error: mooi klote";
   echo $error;
   }

switch ($lanop) {
   case "add_new":
  // echo"name: $namer<br>,pid: $pid,<br>game: $game,<br>ttype: $ttype,<br>tmod: $tmod,<br>trteam: $rteam,perteam: <br>$perteam,<br>tyear: $tyear, <br>tmonth: $tmonth,<br>tday: $tday,<br>thour: $thour,<br>tmin: $tmin, <br>tsec: $tsec,<br>urlstats: $url_stats,<br>lockjoin: $lockjoin,<br>lockteams: $lockteams,<br>rules: $rules,<br>error: $error";
  //           addTournament2($namer, $pid, $game, $ttype, $tmod, $rteam, $perteam, $tyear, $tmonth, $tday, $thour, $tmin, $tsec, $url_stats, $lockjoin, $lockteams, $rules, $error);
      addTournament($namer, $pid, $game, $ttype, $tmod, $rteam, $perteam, $tyear, $tmonth, $tday, $thour, $tmin, $tsec, $url_stats, $lockjoin, $lockteams, $rules, $error);
      break;
   case "update_tourney":
      updateTournament($tourneyid, $namer, $pid, $game, $ttype, $tmod, $rteam, $perteam, $tyear, $tmonth, $tday, $thour, $tmin, $tsec, $url_stats, $lockjoin, $lockteams, $rules);
      break;
   case "edit_tourney":
      editTourney($editTourney);
      break;
   case "delete_tourney":
      deleteTourney($deleteTourney);
      break;
   default:
      showAddForm('', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
      break;
   }

CloseTable();
include ("footer.php");

?>
