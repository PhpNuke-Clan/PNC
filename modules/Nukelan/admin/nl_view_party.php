<?php
// filename: nl_view_party.php

if (!defined('ADMIN_FILE')) {
        die ("Access Denied");
}
include ("header.php");

global $db, $prefix,$admin_file;
lan_menu();
OpenTable();

if ($chgpd){
   /*           if(is_array($chgpd)){
      echo"$chgpd abd $delusr";exit;
      }else{echo"no";          exit;} */
        foreach ($chgpd as $user) {

   $status = $db->sql_fetchrow($db->sql_query("SELECT lan_paid FROM nukelan_signedup WHERE lan_uid='$user' AND lan_id='$lan_id'"));
   if ($status[lan_paid] == '2') {$pd = '0';}
   else {$pd = '2';}
   if (!$db->sql_query("UPDATE nukelan_signedup SET lan_paid='$pd' WHERE lan_uid='$user' AND lan_id='$lan_id'")) $error .= ""._NLCANNOTCHANGEUSERSTATUS."<br>";
   }
}
if ($delusr) foreach ($delusr as $user) {
   $status = $db->sql_fetchrow($db->sql_query("SELECT lan_paid FROM nukelan_signedup WHERE lan_uid='$user' AND lan_id='$lan_id'"));
   if ($status[lan_paid]) $error .= ""._NLUSERISPAID."";
   elseif (!$db->sql_query("DELETE FROM nukelan_signedup WHERE lan_uid='$user' AND lan_id='$lan_id'")) $error .= ""._NLCANNOTDELETEUSER."$user.";
   }


if ($lan_add_user_by_id) {
if ($add_user_charge == 0){$lan_paid = 2; /*echo"".$lan_paid.""; exit;*/}	
$charge_x = "charge_".$add_user_charge."";
$name_x = $add_user_charge;
$party_row = $db->sql_fetchrow($db->sql_query("SELECT * FROM nukelan_parties WHERE party_id='$lan_id'"));
$hasprofile = $db->sql_numrows($db->sql_query("SELECT * FROM nukelan_gamer_profiles WHERE user_id='$lan_add_user_by_id'"));
   if ($db->sql_numrows($db->sql_query("SELECT lan_uid FROM nukelan_signedup WHERE lan_uid='$lan_add_user_by_id' AND lan_id='$lan_id'"))) $error .= ""._NLALREADYSIGNEDUP."";
   elseif (!$db->sql_query("INSERT INTO nukelan_signedup SET lan_uid='$lan_add_user_by_id', lan_id='$lan_id', lan_paid='$lan_paid', lan_date=NOW(), charge='$party_row[$charge_x]', regtype='$name_x'")) $error .= ""._NLQUERYFAILED."$lan_add_user_by_id";
        //gamer profile stuff
   if (!$hasprofile) {
                if (!$db->sql_query("INSERT INTO nukelan_gamer_profiles SET user_id='$lan_add_user_by_id', name='$realname', local='$local'")) echo "<font color=red size=2><b>"._NLCHECKERROR2."</b></font>";
                elseif (!$db->sql_query("INSERT INTO nukelan_gamer_rigs SET user_id='$lan_add_user_by_id'")) echo "<font color=red size=2><b>"._NLCHECKERROR2."</b></font>";
        }
}

if ($lan_add_user_by_uname) {
if ($add_user_charge == 0){$lan_paid = 2; /*echo"".$lan_paid.""; exit;*/}	
$charge_x = "charge_".$add_user_charge."";
$name_x = $add_user_charge;
$usr = $db->sql_fetchrow($db->sql_query("SELECT user_id, username, name FROM ".$user_prefix."_users WHERE username='$lan_add_user_by_uname'"));
$party_row = $db->sql_fetchrow($db->sql_query("SELECT * FROM nukelan_parties WHERE party_id='$lan_id'"));
$hasprofile = $db->sql_numrows($db->sql_query("SELECT * FROM nukelan_gamer_profiles WHERE user_id='$usr[user_id]'"));
   if ($db->sql_numrows($db->sql_query("SELECT lan_uid FROM nukelan_signedup WHERE lan_uid='$usr[user_id]' AND lan_id='$lan_id'"))) $error .= ""._NLALREADYSIGNEDUP."";
   elseif (!$db->sql_query("INSERT INTO nukelan_signedup SET lan_uid='$usr[user_id]', lan_id='$lan_id', lan_paid='$lan_paid', lan_date=NOW(), charge='$party_row[$charge_x]', regtype='$name_x'")) $error .= ""._NLQUERYFAILED." $usr[user_id]";
        //gamer profile stuff
   if (!$hasprofile) {
                if (!$db->sql_query("INSERT INTO nukelan_gamer_profiles SET user_id='$usr[user_id]', name='$lan_add_user_realname', local='$local'")) echo "<font color=red size=2><b>"._NLCHECKERROR2."</b></font>";
                elseif (!$db->sql_query("INSERT INTO nukelan_gamer_rigs SET user_id='$usr[user_id]'")) echo "<font color=red size=2><b>"._NLCHECKERROR2."</b></font>";
        }
}

echo " <h3>$lan_name "._NLSHOWLANPARTY."</h3>\n"
    ." $error\n"
    ." <form action=\"".$admin_file.".php\" method=\"post\">\n"
    ."  <input type=hidden name=op value=usr_status_lans>\n"
    ."  <input type=hidden name=lan_id value=\"$lan_id\">\n"
    ."  <input type=hidden name=lan_name value=\"$lan_name\">\n"
    ." <table border=0 cellpadding=3 cellspacing=1 bgcolor=\"$bgcolor1\" width=\"100%\">\n"
    ."  <tr style=\"background-color: $bgcolor2; color: $textcolor1; font-weight: bold;\">\n"
    ."   <td width=\"30%\">"._NLUSERNAME."</td>\n"
    ."   <td width=\"50%\">"._NLDATE."</td>\n"
    ."   <td width=\"10%\" align=center>"._NLSTATUS."</td>\n"
    ."   <td width=\"5%\" align=center>"._NLCHG."</td>\n"
    ."   <td width=\"5%\" align=center>"._NLDEL."</td>\n".$pntable[lanparty]
    ."  </tr>\n";

$result = $db->sql_query("SELECT l.*, u.* FROM nukelan_signedup AS l LEFT JOIN ".$user_prefix."_users AS u ON (l.lan_uid=u.user_id) WHERE l.lan_id='$lan_id' ORDER BY l.lan_paid DESC, l.lan_date ASC");
if(!$db->sql_numrows($result)) echo "<tr><td colspan=3 align=center>"._NLNOUSERSSIGNEDUP."</td></tr>";
else {
   $bc = $bgcolor3;
   while($usr = $db->sql_fetchrow($result)) {
      if ($bc == $bgcolor3) $bc = $bgcolor4;
      else $bc = $bgcolor3;
      echo "  <tr bgcolor=\"$bc\">\n"
          ."   <td>";
      echo "<a href=\"modules.php?name=Forums&file=profile&mode=viewprofile&u=$usr[user_id]\">$usr[username]</a>";
      echo " [<a href=\"mailto:$usr[user_email]?subject=$lan_name's "._NLSHOWLANPARTY."\"><img src=\"modules/Nukelan/images/email.gif\" border=0></a>]";
      echo "</td>\n"
          ."   <td>";
      echo date ("l, M j, Y - g:ia",strtotime("$usr[lan_date]"));
      echo "</td>\n"
          ."   <td align=center>";
      if ($usr[lan_paid] == '2') echo "<font color=green>"._NLPAID."</font>";
      elseif ($usr[lan_paid] == '1') echo "<font color=orange>"._NLUNCONFIRMED."</font";
      else echo "<font color=red>"._NLUNPAID."</font>";
      echo "</td>\n"
          ."   <td align=center><input type=checkbox name=chgpd[] value=$usr[user_id]></td>\n"
          ."   <td align=center><input type=checkbox name=delusr[] value=$usr[user_id]></td>\n"
          ."  </tr>\n";
      }
   }
echo " </table>\n"
    ." <br>\n"
    ."  <input type=submit value=\""._NLSUBMITCHANGES."\">\n"
    ." </form>\n";
CloseTable();
echo " <br>\n";
OpenTable();
echo " <form action=\"".$admin_file.".php\" method=\"post\">\n"
    ."  <input type=hidden name=op value=usr_status_lans>\n"
    ."  <input type=hidden name=lan_id value=\"$lan_id\">\n"
    ."  <input type=hidden name=lan_name value=\"$lan_name\">\n"
    ."  <b>"._NLADDUSERMANUALLY."</b><br>\n"
    ."  &nbsp;&nbsp;&nbsp;"._NLADDBYID."&nbsp;<input type=text name=lan_add_user_by_id size=11 maxlength=11><br>\n"
    ."  &nbsp;&nbsp;&nbsp;"._NLADDBYNAME."&nbsp;<input type=text name=lan_add_user_by_uname size=11 maxlength=25><br><br>\n"
        ."  &nbsp;&nbsp;&nbsp;"._NLCHECKREALNAME."&nbsp;<input type=text name=lan_add_user_realname size=20 maxlength=30><br><br>\n"
        ."  &nbsp;&nbsp;&nbsp;"._NLCHECKLOCAL."&nbsp;<br>\n"
        ."  &nbsp;&nbsp;&nbsp;<input type=radio name=local value='no' CHECKED>"._NLNO."<br>\n"
        ."  &nbsp;&nbsp;&nbsp;<input type=radio name=local value='yes'>"._NLYES."<br><br>\n"
        ."  &nbsp;&nbsp;&nbsp;"._NLCHECKCHARGE."&nbsp;\n"
        ."<select name=add_user_charge>";
$chargerow = $db->sql_fetchrow($db->sql_query("SELECT * FROM nukelan_parties WHERE party_id='$lan_id'"));
        if (($chargerow['charge_a'] >= 0) && ($chargerow['name_a'] != '')) echo "<option value='a'>$chargerow[name_a] : $chargerow[charge_a]</option>";
        if (($chargerow['charge_b'] >= 0) && ($chargerow['name_b'] != '')) echo "<option value='b'>$chargerow[name_b] : $chargerow[charge_b]</option>";
        if (($chargerow['charge_c'] >= 0) && ($chargerow['name_c'] != '')) echo "<option value='c'>$chargerow[name_c] : $chargerow[charge_c]</option>";
        if (($chargerow['charge_d'] >= 0) && ($chargerow['name_d'] != '')) echo "<option value='d'>$chargerow[name_d] : $chargerow[charge_d]</option>";
        if (($chargerow['charge_e'] >= 0) && ($chargerow['name_e'] != '')) echo "<option value='e'>$chargerow[name_e] : $chargerow[charge_e]</option>";
echo "</select><br><br>\n"
    ."  &nbsp;&nbsp;&nbsp;<input type=submit value=\""._NLADDUSER."\">\n"
    ." </form>\n";
CloseTable();
include ("footer.php");
?>
