<?php
// filename: check_in.php

if (!defined('ADMIN_FILE')) {
        die ("Access Denied");
}
include ("header.php");

lan_menu();
OpenTable();

global $db, $prefix, $user_prefix, $admin_file;
$row2 = $db->sql_fetchrow($db->sql_query("SELECT * FROM nukelan_config WHERE id='1'"));
if($row2[config_id] == "") { 
	echo""._NLCHECKINNOTSET." <a href='".$admin_file.".php?op=edit_config' target=\"_SELF\">Set Active Party</a>";
	}

$row = $db->sql_fetchrow($db->sql_query("SELECT * FROM nukelan_parties WHERE party_id='$row2[config_id]'"));
$pid = "$row[party_id]";
$schart = "$row[schart]";

if ($chg) foreach ($chg as $user) {
   $status = $db->sql_fetchrow($db->sql_query("SELECT checkin FROM nukelan_signedup WHERE lan_uid='$user' AND lan_id='$pid'"));
   if ($status[checkin] >= '1') $pd = '0';
   else $pd = '1';
   
   if (!$db->sql_query("UPDATE nukelan_signedup SET checkin='$pd', checkin_time=NOW(), lan_paid=2 WHERE lan_uid='$user' AND lan_id='$pid'")) $error .= ""._NLCANNOTCHECKOUTUSER."$user.<br>";
   }
if ($chgpd) foreach ($chgpd as $user) {
   $status = $db->sql_fetchrow($db->sql_query("SELECT lan_paid FROM nukelan_signedup WHERE lan_uid='$user' AND lan_id='$pid'"));
   if ($status[lan_paid] == '2') $pd = '0';
   else $pd = '2';

   if ($status[lan_paid] == '2') $npd = '0';
   else $npd = '1';   
   
   if (!$db->sql_query("UPDATE nukelan_signedup SET lan_paid='$pd' WHERE lan_uid='$user' AND lan_id='$pid'")) $error .= ""._NLCANNOTCHANGEUSERSTATUS."<br>";
   }

if ($delusr) foreach ($delusr as $user) {
   if (!$db->sql_query("DELETE FROM nukelan_signedup WHERE userid='$user' AND lan_id='$pid'")) $error .= ""._NLCANNOTDELETEUSER."$user.";
   }

$lan = $db->sql_fetchrow($db->sql_query("SELECT * FROM nukelan_parties WHERE party_id='$pid' ORDER BY keyword"));
function showcheckin($lan, $pid) {
 global $db, $prefix, $user_prefix, $bgcolor1, $bgcolor2, $bgcolor3, $bgcolor4, $textcolor1, $textcolor2, $ModName, $sitename, $admin_file;
echo " <h3>$lan[keyword] "._NLCHECKINOUT."</h3>\n"
    ." $error\n";
ShowQuick($lan);        
echo " <form action=\"".$admin_file.".php\" method=\"post\">\n"
    ."  <input type=hidden name=op value=admin_checkin>\n"
    ." <table border=0 cellpadding=3 cellspacing=1 bgcolor=\"$bgcolor1\" width=\"100%\">\n"
    ."  <tr style=\"background-color: $bgcolor2; color: $textcolor1; font-weight: bold;\">\n"
    ."   <td width=\"15%\">"._NLREALNAME."</td>\n"
        ."   <td width=\"15%\">"._NLUSERNAME."</td>\n"
    ."   <td width=\"20%\">"._NLDATE."</td>\n"
        ."   <td width=\"10%\" align=center>"._NLTABLE."</td>\n"
        ."   <td width=\"10%\" align=center>"._NLUSERCHARGE."</td>\n"
    ."   <td width=\"10%\" align=center>"._NLCHECKPAID."</td>\n"
        ."   <td width=\"5%\" align=center>"._NLPAY."</td>\n"
    ."   <td width=\"10%\" align=center>"._NLSTATUS."</td>\n"
    ."   <td width=\"5%\" align=center>"._NLCHG."</td>\n".$pntable[lanparty]
    ."  </tr>\n";

$result = $db->sql_query("SELECT l.*, u.* FROM nukelan_signedup AS l LEFT JOIN nukelan_gamer_profiles AS u ON (l.lan_uid=u.user_id) WHERE l.lan_uid >='1' AND l.lan_id='$pid' ORDER BY u.name");
if(!$db->sql_numrows($result)) echo "<tr><td colspan=3 align=center>"._NLNOUSERSSIGNEDUP."</td></tr>";
else {
   $bc = $bgcolor3;
   while($usr = $db->sql_fetchrow($result)) {
   $table = $db->sql_query("SELECT name FROM nukelan_seat_objects WHERE id='$usr[room_loc]'");
   $usr2 = $db->sql_fetchrow($db->sql_query("SELECT * FROM ".$user_prefix."_users WHERE user_id='$usr[user_id]'"));
   
      if ($usr[checkin] == '1') $bc2 = "#009900";
      else $bc2 = "#CC0000";
      if ($bc == $bgcolor3) $bc = $bgcolor4;
          else $bc = $bgcolor3;
          echo "  <tr bgcolor=\"$bc\">\n";
          echo "<td bgcolor=\"$bc2\"><a href=\"".$admin_file.".php?op=admin_checkin&amp;lanop=clicked&amp;check=$usr[user_id]$amp;pid='$pid'\" style=\"color:#000000;\">\n"
      ."<font color=\"#000000\"><b>$usr[name]</b></font></td>\n";
          echo "   <td>";
          echo "$usr2[username]";
      echo "</td>\n"
          ."   <td>";
		  if($usr[checkin_time] == "0000-00-00 00:00:00"){
		  echo""._NLCHECKNOT." "._NLCHECKUSRNOTSEL."";
		  }else{
      	  echo date ("l, M j, Y - g:ia",strtotime("$usr[checkin_time]"));
	  	  }
      echo "</td>\n"
              ."<td align=center>";
          while($tab = $db->sql_fetchrow($table)) { echo "<font color=green><b>$tab[name]</b></font>";
          }
          echo "</td>\n";
          echo "<td align=center>";
          echo "$".$usr['charge']."";
          echo "</td>";
          echo "   <td align=center>";
          
      if ($usr[lan_paid] == '2') echo "<font color=green><b>"._NLPAID."</b></font>";
      elseif ($usr[lan_paid] == '1') echo "<font color=orange><b>"._NLUNCONFIRMED."</b></font";
      else echo "<font color=red><b>"._NLUNPAID."</b></font>";
      echo "</td>\n"
          ."   <td align=center><input type=checkbox name=chgpd[] value=$usr[user_id]></td>\n"
                  ."<td align=center>";
          if ($usr[checkin] == '1') echo "<font color=green><b>"._NLIN."</b></font>";
          else echo "<font color=red><b>"._NLOUT."</b></font>";
          echo "</td>\n"
          ."   <td align=center><input type=checkbox name=chg[] value=$usr[user_id]></td>\n"
          ."  </tr>\n";
      }
   }
echo " </table>\n"
    ." <br>\n"
    ."  <input type=submit value=\""._NLSUBMITCHANGES."\">\n"
    ." </form>\n";
CloseTable();
echo " <br>\n";
}

function ShowQuick($lan) {
global $db, $prefix, $user_prefix, $admin_file;
 echo "   <table border=0>\n"
          ."    <tr>\n";
                  echo "     <td>\n"
             ."<form action=\"".$admin_file.".php\" method=\"post\" style=\"margin: 0;\">\n"
                         ."       <input type=hidden name=op value=admin_checkin>\n"
             ."       <input type=hidden name=lanop value=quick>\n"
             ."       <input type=submit value=\""._NLCHECKADDNUKE."\" style=\"width: 130px;\">\n"
             ."      </form>\n"
             ."     </td>\n";
         echo "<td>\n"
                     ."<form action=\"".$admin_file.".php\" method=\"post\" style=\"margin: 0;\">\n"
                         ."<input type=hidden name=op value=admin_checkin>\n"
                         ."<input type=hidden name=lanop value=new_user>\n"
                         ."<input type=submit value=\""._NLCHECKADDUSER."\" style=\"width: 120px;\">\n"
                         ."</form>\n"
                         ."</td>\n";
                 echo "<td>\n"
                     ."<form action=\"".$admin_file.".php\" method=\"post\" style=\"margin: 0;\">\n"
                         ."<input type=hidden name=op value=admin_checkin>\n"
                         ."<input type=hidden name=lanop value=pick_seat>\n"
                         ."<input type=submit value=\""._NLCHECKASSIGNSEAT."\" style=\"width: 120px;\">\n"
                         ."</form>\n"
                         ."</td>\n"
                         ."    </tr>\n"
             ."   </table>\n";
                }
function ShowQuick2($schart, $lan) {
global $db, $prefix, $user_prefix, $admin_file;
$row = $db->sql_fetchrow($db->sql_query("SELECT * FROM nukelan_config WHERE id='1'"));
$pid2 = "$row[config_id]";
$party2 = $db->sql_fetchrow($db->sql_query("SELECT * FROM nukelan_parties WHERE party_id='$pid2'"));
$atparty2 = $db->sql_numrows($db->sql_query("SELECT * FROM nukelan_signedup WHERE lan_id='$pid2'"));
$tables = $db->sql_query("SELECT * FROM nukelan_seat_objects WHERE type='table' AND room_id='$schart' ORDER BY name");
if ($party2[max] <= $atparty2) {
echo "<h2>"._NLCHECKPARTYFULL."</h2>";
} else {
 echo "   <table border=0>\n"
          ."    <tr>\n";
                  echo "     <td>\n"
             ."<form action=\"".$admin_file.".php\" method=\"post\" style=\"margin: 0;\">\n"
                         ."<input type=hidden name=op value=admin_checkin>\n"
             ."<input type=hidden name=lanop value=quick_add>\n"
                         ."<font size=2><b>"._NLCHECKUSERNAME."</b></font><br>\n"
                         ."<input type=text name=username maxlength=34 style=\"width:240px;\"><br>\n"
                         ."<font size=2><b>"._NLCHECKPASSWORD."</b></font><br>\n"
                         ."<input type=password name=passwd maxlength=34 style=\"width: 240px;\"><br>\n"
                         ."<font size=2><b>"._NLCHECKEMAIL."</b></font><br>\n"
                         ."<input type=text name=email maxlength=60 style=\"width: 240px;\"><br><br>\n"
                         ."<font size=2><b>"._NLCHECKREALNAME."</b></font><br>\n"
                         ."<input type=text name=realname maxlength=30 style=\"width: 240px;\"><br>\n"
                         ."<font size=2><b>"._NLCHECKGENDER."</b></font><br>\n"
                         ."<select name=gender>\n"
                         ."<option value=male>"._NLMALE."</option>\n"
                         ."<option value=female>"._NLFEMALE."</option>\n"
                         ."</select><br>\n"
                         ."<font size=2><b>"._NLCHECKPICKLAN."</b></font><br>\n"
                         ."<select name=pid>\n"
                         ."<option value=\"$lan[party_id]\">$lan[keyword]</option>\n";
                 echo "</select><br>\n"
                     .""._NLCHECKLOCAL."<br>\n"
                         ."<input type=radio name=local value='no' CHECKED>"._NLNO."<br>\n"
                         ."<input type=radio name=local value='yes'>"._NLYES."<br><br>\n"
                         .""._NLCHECKCHARGE."<br>\n"
                         ."<select name=charge_type>\n";
                if ($party2['charge_a'] > 0) echo "<option value='a'>$party2[name_a] : $party2[charge_a]</option>";
                if ($party2['charge_b'] > 0) echo "<option value='b'>$party2[name_b] : $party2[charge_b]</option>";
                if ($party2['charge_c'] > 0) echo "<option value='c'>$party2[name_c] : $party2[charge_c]</option>";
                if ($party2['charge_d'] > 0) echo "<option value='d'>$party2[name_d] : $party2[charge_d]</option>";
                if ($party2['charge_e'] > 0) echo "<option value='e'>$party2[name_e] : $party2[charge_e]</option>";
                 echo "</select><br><br>\n"
                         ."<input type=submit value=\""._NLCHECKSUBMIT."\" style=\"width: 85px;\">\n"
             ."</form>\n"
             ."</td>\n"
             ."</tr>\n"
             ."</table>\n";
                         }
}
function ShowQuick3($schart, $lan) {
global $db, $prefix, $user_prefix, $admin_file;
$row = $db->sql_fetchrow($db->sql_query("SELECT * FROM nukelan_config WHERE id='1'"));
$pid2 = $row['config_id'];
$party2 = $db->sql_fetchrow($db->sql_query("SELECT * FROM nukelan_parties WHERE party_id='$pid2'"));
$party3 = $db->sql_query("SELECT lan_uid FROM nukelan_signedup WHERE lan_id='$pid2'");
        $party_list = "1";
while ($party3row = $db->sql_fetchrow($party3)) {
        $party_list .= ",$party3row[lan_uid]";
}

$result = $db->sql_query("SELECT * FROM ".$user_prefix."_users WHERE user_id NOT IN ($party_list) ORDER BY username");
$tables = $db->sql_query("SELECT * FROM nukelan_seat_objects WHERE type='table' AND room_id='$schart' ORDER BY name");
$events = $db->sql_query("SELECT * FROM nukelan_parties ORDER BY keyword");

if ($party2[max] <= $atparty2) {
echo "<h2>"._NLCHECKPARTYFULL."</h2>";
} else {
echo "<table border=0>\n"
    ."<tr>\n";
        echo "<td>\n"
            ."<form action=\"".$admin_file.".php\" method=\"post\" style=\"margin: 0;\">\n"
                ."<input type=hidden name=op value=admin_checkin>\n"
                ."<input type=hidden name=lanop value=quick_nuke>\n"
                ."<h3>"._NLCHECKSELECTNUKEUSER."</h3>\n"
                .""._NLCHECKUSERS."<br>\n"
                ."<select name=nuser>\n";
        while ($nuke = $db->sql_fetchrow($result)) { echo "<option value=\"$nuke[user_id]\">$nuke[username]</option>\n";
        }
        echo "</select><br><br>\n"
            .""._NLCHECKREALNAME."<br>\n"
                ."<input type=text size=30 maxlength=30 name=realname><br>\n"
                .""._NLCHECKPICKLAN."<br>\n"
                ."<select name=pid>\n"
                ."<option value=\"$lan[party_id]\">$lan[keyword]</option>\n";
        echo "</select><br>\n"
            .""._NLCHECKLOCAL."<br>\n"
                ."<input type=radio name=local value='no' CHECKED>"._NLNO."<br>\n"
                ."<input type=radio name=local value='yes'>"._NLYES."<br><br>\n"
                .""._NLCHECKCHARGE."<br>\n"
                ."<select name=charge_type>\n";
        if ($party2['charge_a'] > 0) echo "<option value='a'>$party2[name_a] : $party2[charge_a]</option>";
        if ($party2['charge_b'] > 0) echo "<option value='b'>$party2[name_b] : $party2[charge_b]</option>";
        if ($party2['charge_c'] > 0) echo "<option value='c'>$party2[name_c] : $party2[charge_c]</option>";
        if ($party2['charge_d'] > 0) echo "<option value='d'>$party2[name_d] : $party2[charge_d]</option>";
        if ($party2['charge_e'] > 0) echo "<option value='e'>$party2[name_e] : $party2[charge_e]</option>";
        echo "</select><br><br>\n"
            ."<input type=submit value=\""._NLCHECKSUBMITNUKE."\">\n"
                ."</form>\n"
                ."</tr>\n"
                ."</table>\n";
                }
}
function showpickseat($pid, $schart, $lan) {
global $db, $prefix, $user_prefix, $admin_file;
$users2 = $db->sql_query("SELECT l.*, u.* FROM ".$user_prefix."_users AS l LEFT JOIN nukelan_signedup AS u ON (l.user_id=u.lan_uid) WHERE u.lan_id='$pid' ORDER BY l.username");
$tables = $db->sql_query("SELECT * FROM nukelan_seat_objects WHERE type='table' AND room_id='$schart' ORDER BY id");
echo "<table border=0>\n"
    ."<tr>\n";
        echo "<td>\n"
            ."<form action=\"".$admin_file.".php\" method=\"post\" style=\"margin: 0;\">\n"
                ."<input type=hidden name=op value=admin_checkin>\n"
                ."<input type=hidden name=lanop value=pick_seat2>\n"
                ."<h3>"._NLCHECKSELECTSEAT."</h3>\n"
                .""._NLCHECKSELECTUSER."<br>\n"
                ."<select name=suser>\n";
        while ($nuke = $db->sql_fetchrow($users2)) { $sat = $db->sql_fetchrow($db->sql_query("SELECT name FROM nukelan_seat_objects WHERE id='$nuke[room_loc]'")); echo "<option value=\"$nuke[user_id]\">$nuke[username] ::: $sat[name]</option>\n";
        }
mysql_free_result($users2);
        echo "</select><br><br>\n"
            .""._NLCHECKPICKTABLE."<br>\n"
                ."<select name=astable>\n";
        while ($tab = $db->sql_fetchrow($tables)) { $numhere = $db->sql_numrows($db->sql_query("SELECT lan_uid FROM nukelan_signedup WHERE room_loc='$tab[id]'")); $avail = ($tab['capacity'] - $numhere);  echo "<option value=\"$tab[id]\">$tab[name] : $avail</option>\n";
        }
        echo "</select><br><br>\n"
            ."<input type=hidden name=pid value='$pid'>\n"
            ."<input type=submit value=\""._NLSUBMIT."\">\n"
                ."</form>\n"
                ."</tr>\n"
                ."</table>\n";
}
function pickseat($suser, $astable, $pid) {
global $db, $prefix, $user_prefix, $admin_file;
$result = $db->sql_query("SELECT * FROM nukelan_signedup WHERE room_loc='$astable' AND lan_id='$pid'");
$table = $db->sql_fetchrow($db->sql_query("SELECT * FROM nukelan_seat_objects WHERE id='$astable'"));
$numthere = $db->sql_numrows($result);
   if ($numthere >= $table[capacity]) echo "<font color=red size=2><b>"._NLCHECKTABLEFULL."</b></font>";
   elseif (!$db->sql_query("UPDATE nukelan_signedup SET room_loc='$astable' WHERE lan_uid='$suser' AND lan_id='$pid'")) echo "<font color=red size=2><b>"._NLCANNOTASSIGNSEAT."</b></font>";
   else echo "<b>"._NLSEATASSIGNED."</b>";
}
function addme($username, $passwd, $email, $realname, $gender, $pid, $local, $charge_type, $doit) {
global $db, $prefix, $user_prefix, $admin_file;
$nukeuser = $db->sql_query("SELECT * FROM ".$user_prefix."_users WHERE user_email='$email'");
$nuker = $db->sql_numrows($nukeuser);
$row = $db->sql_numrows($db->sql_query("SELECT * FROM ".$user_prefix."_users WHERE username='$username'"));
$nid = $db->sql_fetchrow($nukeuser);
$signedup = $db->sql_numrows($db->sql_query("SELECT * FROM nukelan_signedup WHERE lan_uid='$nid[user_id]' AND lan_id='$pid'"));
$party = $db->sql_fetchrow($db->sql_query("SELECT * FROM nukelan_parties WHERE party_id='$pid'"));
$charge_x = "charge_".$charge_type."";
$name_x = $charge_type;
switch($doit) {
  case 'signup':
  $hasprofile = $db->sql_numrows($db->sql_query("SELECT * FROM nukelan_gamer_profiles WHERE user_id='$nid[user_id]'"));
  if (!$nuker) echo "<font color=red size=2><b>"._NLEMAILNOTINUSE."</b></font>";
  elseif ($signedup) echo "<font color=red size=2><b>"._NLUSERALREADYREGISTERED."</b></font>\n";
  elseif (!$db->sql_query("INSERT INTO nukelan_signedup SET lan_uid='$nid[user_id]', lan_id='$pid', lan_paid='2', lan_date=NOW(), checkin='1', checkin_time=NOW(), charge='$party[$charge_x]', regtype='$name_x'")) echo ""._NLCHECKERROR."<br>";
  
  //gamer profile stuff
  elseif (!$hasprofile) {
        if (!$db->sql_query("INSERT INTO nukelan_gamer_profiles SET user_id='$nid[user_id]', name='$realname', local='$local', gender='$gender'")) echo "<font color=red size=2><b>"._NLCHECKERROR2."</b></font>";
        elseif (!$db->sql_query("INSERT INTO nukelan_gamer_rigs SET user_id='$nid[user_id]'")) echo "<font color=red size=2><b>"._NLCHECKERROR2."</b></font>";
  }
  break;
  
  default:
  if (!$username || !$passwd || !$email) echo "<font color=red size=2><b>"._NLREQUIREDFIELDS."</b></font>";
  elseif ($row) echo "<font color=red size=2><b>"._NLUSERNAMEINUSE."</b></font>";
  elseif (!$db->sql_query("INSERT INTO ".$user_prefix."_users (user_id, username, user_email, user_password, user_avatar, user_regdate, user_lang) VALUES (NULL, '$username', '$email', '".md5($passwd)."', 'gallery/blank.gif', '".date("m/d/Y H:i:s")."', 'english')")) echo "<font color=red size=2><b>this line is ghey</b></font>";
  break;
}
}
function addfromnuke($nuser, $realname, $pid, $local, $charge_type) {
global $db, $prefix, $user_prefix, $admin_file;
$party = $db->sql_fetchrow($db->sql_query("SELECT * FROM nukelan_parties WHERE party_id='$pid'"));
$usr = $db->sql_fetchrow($db->sql_query("SELECT * FROM ".$user_prefix."_users WHERE user_id='$nuser'"));
$signedup = $db->sql_numrows($db->sql_query("SELECT * FROM nukelan_signedup WHERE lan_uid='$nuser'"));
$hasprofile = $db->sql_numrows($db->sql_query("SELECT * FROM nukelan_gamer_profiles WHERE user_id='$nuser'"));
$result = $db->sql_query("SELECT * FROM nukelan_signedup WHERE room_loc='$ntable'");
$numthere = $db->sql_numrows($result);
$charge_x = "charge_".$charge_type."";
$name_x = $charge_type;

   if ($signedup) echo "<font color=red size=2><b>"._NLUSERALREADYREGISTERED."</b></font>";
   elseif (!$db->sql_query("INSERT INTO nukelan_signedup SET lan_uid='$usr[user_id]', lan_id='$pid', charge='$party[$charge_x]', lan_paid='2', lan_date=NOW(), checkin='1', checkin_time=NOW(), regtype='$name_x'")) echo "<font color=red size=2><b>"._NLCHECKERROR2."</b></font>";
   
   //gamer profile stuff
   if (!$hasprofile) {
                if (!$db->sql_query("INSERT INTO nukelan_gamer_profiles SET user_id='$usr[user_id]', name='$realname', local='$local'")) echo "<font color=red size=2><b>"._NLCHECKERROR2."</b></font>";
                elseif (!$db->sql_query("INSERT INTO nukelan_gamer_rigs SET user_id='$usr[user_id]'")) echo "<font color=red size=2><b>"._NLCHECKERROR2."</b></font>";
        }

}
function clickme($pid,$check,$sit) {
global $db, $prefix, $user_prefix, $admin_file;
$status = $db->sql_fetchrow($db->sql_query("SELECT checkin FROM nukelan_signedup WHERE lan_uid='$check' AND lan_id='$pid'"));
if ($status[checkin] == '1') $chk = '0';
else $chk = '1';

switch ($sit) {
   default:
     if (!$db->sql_query("UPDATE nukelan_signedup SET checkin='$chk', checkin_time=NOW(), lan_paid='2' WHERE lan_uid='$check' AND lan_id='$pid'")) echo "<font color=red><b>"._NLCANNOTCHECKINUSER."'$check'</b></font>";
         break;
}
}
switch ($lanop) {
  case 'clicked':
    clickme($pid,$check,'');
        showcheckin($lan, $pid);
        break;
  case 'quick':
    ShowQuick3($schart, $lan);
        break;  
  case 'new_user':
    ShowQuick2($schart, $lan);
        break;
  case 'quick_add':
    addme($username, $passwd, $email, $realname, $gender, $pid, $local, $charge_type, '');
        addme($username, $passwd, $email, $realname, $gender, $pid, $local, $charge_type, 'signup');
        showcheckin($lan, $pid);
        break;          
  case 'quick_nuke':
    addfromnuke($nuser, $realname, $pid, $local, $charge_type);
        showcheckin($lan, $pid);
        break;
  case 'pick_seat':
    showpickseat($pid, $schart, $lan);
        break;
  case 'pick_seat2':
    pickseat($suser, $astable, $pid);
        showcheckin($lan, $pid);
        break;
  default:
  showcheckin($lan, $pid);
  break;
}
CloseTable();
include ("footer.php");
?>
