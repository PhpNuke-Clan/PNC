<?php
// filename: index.php
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
 global $db, $prefix, $user_prefix, $user_prefix, $editTeam, $admin_file,$bgcolor1;

$index = $lanconfig['index'];

include ("header.php");

$parties = $db->sql_query("SELECT * FROM nukelan_parties ORDER BY date");
$num_lans = $db->sql_numrows($parties);

        global $db, $prefix, $user_prefix, $uname, $uid;
        $user = base64_decode($user);
        $user = explode(":", $user);
        $uid = "$user[0]";
        $uname = "$user[1]";
        $pwd = "$user[2]";
        
function ListParties($parties) {
   global $db, $prefix, $user_prefix, $bgcolor1, $bgcolor2, $bgcolor3, $bgcolor4, $textcolor1, $textcolor2, $ModName, $sitename;
        OpenTable();
   echo "   <h2>"._NLPARTYLIST." $sitename:</h2>\n"
       ."   <table border=0 cellpadding=3 cellspacing=1 bgcolor=\"$bgcolor1\" width=\"100%\">\n"
       ."    <tr style=\"background-color: $bgcolor2; color: $textcolor1; font-weight: bold;\">\n"
       ."     <td width=\"25%\">"._NLPARTYNAME."</td>\n"
       ."     <td width=\"45%\">"._NLDATE."</td>\n"
       ."     <td width=\"10%\" align=center>"._NLATTD."</td>\n"
       ."     <td width=\"10%\" align=center>"._NLCHARGE."</td>\n"
       ."     <td width=\"10%\" align=center>"._NLSTATUS."</td>\n"
       ."    </tr>\n";
   $bc = $bgcolor3;
   while($lan = $db->sql_fetchrow($parties)) {
      if ($bc == $bgcolor3) $bc = $bgcolor4;
      else $bc = $bgcolor3;
      echo "    <tr bgcolor=\"$bc\">\n"
          ."     <td><a href=\"modules.php?name=$ModName&amp;file=index&amp;lanop=show_party&amp;party_id=$lan[party_id]\">$lan[keyword]</a></td>\n"
          ."     <td>";
      echo date ("l, M j, Y - g:ia",strtotime("$lan[date]"));
      echo "</td>\n"
          ."     <td align=center>";
      echo mysql_num_rows(mysql_query("SELECT lan_uid FROM nukelan_signedup WHERE lan_id='$lan[party_id]'"));
      if ($lan['max']) echo "/$lan[max]";
      echo "</td>\n"
          ."     <td align=center>\$$lan[charge_a]</td>\n"
          ."     <td align=center>";
      if ($lan['stop']) echo "<font color=red size=2><B>"._NLCLOSED."</B></font>";
      else echo "<font color=green size=2><B>"._NLOPEN."</B></font>";
      echo "</td>\n"
          ."    </tr>\n";
      }
   echo "   </table>\n";
        CloseTable();
   }

function ShowParty2($lan) {
   global $db, $prefix, $user_prefix, $dbi, $bgcolor1, $bgcolor2, $bgcolor3, $bgcolor4, $textcolor1, $textcolor2, $ModName, $cookie, $num_coming;
        OpenTable();
   $party = GetPartyStuff($lan['host'], $lan['loc'], $lan['paypal'], $usr_id, $lan['party_id']);
   $users = $db->sql_query("SELECT l.*, u.user_id, u.femail, u.user_email, u.user_viewemail, u.username, u.name, u.user_website FROM nukelan_signedup AS l LEFT JOIN ".$user_prefix."_users AS u ON (l.lan_uid=u.user_id) WHERE l.lan_id='$lan[party_id]' GROUP BY l.lan_date ASC ORDER BY l.lan_paid DESC, l.lan_date ASC");
    
        if ($users != "") {
        $num_coming = $db->sql_numrows($users);
        while($usr = $db->sql_fetchrow($users)) {
                if ($usr['lan_sys']>0) $num_systems += 1;
                if ($usr['lan_mon']>0) $num_monitors += 1;
        }
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

echo "<br>";

        @mysql_data_seek($users, 0);
        echo "<h3 style=\"margin: 4px 1px 4px 1px;\">$lan[keyword] "._NLLANPARTY."</h3>\n"
                ."<p style=\"margin: 0px 0px 4px 10px;\">\n"
                ."    <b>"._NLSTART." ".date ("l, M j, Y - g:ia",strtotime("$lan[date]"))."</b><br>\n"
                        ."    <b>"._NLEND." ".date ("l, M j, Y - g:ia",strtotime("$lan[enddate]"))."</b><br><br>\n"
                ."    <b>".$party['host']['fname']." "._NLISHOST."</b><br>\n"
                ."    "._NLEMAIL." <a href=\"mailto:".$party['host']['email']."\">".$party['host']['email']."</a>\n";

        if ($party['host']['phone']) echo "<br>"._NLPHONE." ".$party['host']['phone'];
                echo "    <br><br>\n"
                ."    <b>"._NLLOCATION."</b><br>\n"
                ."    ".$party['loc']['addr']."<br>\n"
                ."    ".$party['loc']['city'].", ".$party['loc']['state']." ".$party['loc']['zip']."<br>\n"
                ."    [<a href=\"http://www.mapquest.com/maps/map.adp?country=".$party['loc']['state']."&addtohistory=&address=".$party['loc']['addr']."&city=".$party['loc']['city']."&zipcode=".$party['loc']['zip']."&homesubmit=Get+Map\" target=\_blank\">"._NLMAP."</a>]\n"
                        ."    [<a href=\"http://www.mapquest.com/directions/main.adp?go=1&do=nw&ct=NA&1y=".$party['loc']['state']."&1a=&1p=&1c=&1s=&1z=&1ah=&2y=".$party['loc']['state']."&2a=".$party['loc']['addr']."&2p=&2c=".$party['loc']['city']."&2z=".$party['loc']['zip']."&2ah=&lr=2&x=64&y=11\" target=\"_blank\">"._NLDIRECTIONS."</a>]\n"
                        ."   </p>\n"
                ."<br>\n";
        if ($lan['disclaimer']) echo "   <p style=\"margin: 0px 0px 4px 10px;\"><b>"._NLINFORMATION."</b><br>$lan[disclaimer]</p><br>\n";
      CloseTable();
          ShowButtons($lan,$party);
          
}  
                    
        else {
        }

        }
//START ShowParty   function
function ShowParty($lan) {
   global $db, $prefix, $user_prefix, $dbi, $bgcolor1, $bgcolor2, $bgcolor3, $bgcolor4, $textcolor1, $textcolor2, $ModName, $cookie, $num_coming, $uid, $uname;
  OpenTable();
   $party = GetPartyStuff($lan['host'], $lan['loc'], $lan['paypal'], $usr_id, $lan['party_id']);
   $users = $db->sql_query("SELECT l.*, u.user_id, u.femail, u.user_viewemail, u.user_email, u.username, u.name, u.user_website FROM nukelan_signedup AS l LEFT JOIN ".$user_prefix."_users AS u ON (l.lan_uid=u.user_id) WHERE l.lan_id='$lan[party_id]' GROUP BY l.lan_date ASC ORDER BY l.lan_paid DESC, l.lan_date ASC");
   $users2 = $db->sql_query("SELECT l.*, u.user_id, u.femail, u.user_viewemail, u.user_email, u.username, u.name, u.user_website FROM nukelan_signedup AS l LEFT JOIN ".$user_prefix."_users AS u ON (l.lan_uid=u.user_id) WHERE l.lan_id='$lan[party_id]' GROUP BY l.lan_date ASC ORDER BY l.lan_paid DESC, l.lan_date ASC");

   if ($users != "") {
        $num_coming = $db->sql_numrows($users);
        while($usr = $db->sql_fetchrow($users)) {
                if ($usr['lan_sys']>0) $num_systems += 1;
                if ($usr['lan_mon']>0) $num_monitors += 1;
        }
        //Start Top menu
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
include ("modules/$ModName/admin/incl/countries.inc.php");
        //Stop Top menu
        //Display LAN information
        @mysql_data_seek($users, 0);
        echo "<h3 style=\"margin: 4px 1px 4px 1px;\">$lan[keyword] "._NLLANPARTY."</h3>\n"
                ."<p style=\"margin: 0px 0px 4px 10px;\">\n"
                ."    <b>"._NLSTART." ".date ("l, M j, Y - g:ia",strtotime("$lan[date]"))."</b><br>\n"
                        ."    <b>"._NLEND." ".date ("l, M j, Y - g:ia",strtotime("$lan[enddate]"))."</b><br><br>\n"
                ."    <b>".$party['host']['fname']." "._NLISHOST."</b><br>\n"
                ."    "._NLEMAIL." <a href=\"mailto:".$party['host']['email']."\">".$party['host']['email']."</a>\n";

        if ($party['host']['phone']) echo "<br>"._NLPHONE." ".$party['host']['phone'];
                echo "    <br><br>\n"
                ."    <b>"._NLLOCATION."</b><br>\n"
                ."    ".$party['loc']['addr']."<br>\n"
                ."    ".$party['loc']['city'].", ";
				
		   foreach ($country_array as $abrv => $long) {
		   		if ($party['loc']['state'] == $abrv){ $country = $long;

					echo"$country";
					}
		   }
			echo " (".$party['loc']['state'].") ".$party['loc']['zip']."<br>\n"
			
                ."    [<a href=\"http://www.mapquest.com/maps/map.adp?country=".$party['loc']['state']."&addtohistory=&address=".$party['loc']['addr']."&city=".$party['loc']['city']."&zipcode=".$party['loc']['zip']."&homesubmit=Get+Map\" target=\_blank\">"._NLMAP."</a>]\n"
                        ."    [<a href=\"http://www.mapquest.com/directions/main.adp?go=1&do=nw&ct=NA&1y=".$party['loc']['state']."&1a=&1p=&1c=&1s=&1z=&1ah=&2y=".$party['loc']['state']."&2a=".$party['loc']['addr']."&2p=&2c=".$party['loc']['city']."&2z=".$party['loc']['zip']."&2ah=&lr=2&x=64&y=11\" target=\"_blank\">"._NLDIRECTIONS."</a>]\n"
                        ."   </p>\n"
                ."<br>\n";
        if ($lan['disclaimer']) echo "   <p style=\"margin: 0px 0px 4px 10px;\"><b>"._NLINFORMATION."</b><br>$lan[disclaimer]</p><br>\n";
     
          ShowButtons($lan,$party);
          CloseTable();
        //END Display LAN information

                        if ($lan['prepay'] == 1) {
                         OpenTable();
                          // STARTING CONFIRMED LIST
                                echo "   <CENTER><B>"._NLCONFIRMEDLIST."</B></CENTER>";
                                echo "   <table border=0 cellpadding=3 cellspacing=1 bgcolor=\"\" width=\"100%\">\n"
                                   ."    <tr style=\"background-color: ; color: $textcolor1; font-weight: bold;\">\n"
                                   ."     <td width=\"5%\">#</td>\n"
                                   ."     <td width=\"20%\">"._NLUSERNAME."</td>\n"
                                   ."     <td width=\"30%\">"._NLREGDATE."</td>\n"
                                   ."     <td width=\"15%\">"._NLREGTYPE."</td>\n"
                                   ."     <td width=\"10%\" align=center>"._NLLOCAL."</td>\n"
                                   ."     <td width=\"10%\" align=center>"._NLTOTALDUE."</td>\n"
                                   ."     <td width=\"10%\" align=center>"._NLSTATUS."</td>\n"
                                   ."    </tr>\n";
                                $bc = $bgcolor3;
                                while($usr = $db->sql_fetchrow($users)) {
                                if ($usr['lan_paid'] == '2'){   
                                        $usr_profile = $db->sql_fetchrow($db->sql_query("SELECT * FROM nukelan_gamer_profiles WHERE user_id='$usr[user_id]'"));
                                        $count_rows += 1;
                                        if ($bc == $bgcolor3) $bc = $bgcolor4;
                                        else $bc = $bgcolor3;
                                        echo "  <tr bgcolor=\"$bc\">\n"
                                          ."<td>".$count_rows."</td>\n"
                                          ."   <td><a href=\"modules.php?name=$ModName&file=profile&lanop=show_profile&profile_id=$usr[user_id]&pid=$lan[party_id]\">";
                                        if ($uid == $usr['user_id']) echo "<b>$usr[username]</b></a>";
                                        else echo "$usr[username]</a>";
                    if ($usr['femail']) echo " <a href=\"mailto:$usr[femail]&subject=$lan[keyword]'s LAN Party\"><img src=\"modules/$ModName/images/email.gif\"></a>";
                                        
                                         echo "</td>\n"
                                          ."   <td>";
                                        echo date ("l, M j, Y - g:ia",strtotime("$usr[lan_date]"));
                                        echo "</td>\n";
                                        echo "<td>";
                                        $lan_user_type = $usr['regtype'];
                                        if ($lan_user_type == 'a') echo "$lan[name_a]";
                                        if ($lan_user_type == 'b') echo "$lan[name_b]";
                                        if ($lan_user_type == 'c') echo "$lan[name_c]";
                                        if ($lan_user_type == 'd') echo "$lan[name_d]";
                                        if ($lan_user_type == 'e') echo "$lan[name_e]";
                                        echo "</td>\n"
                                        ."   <td align=center>"
                                        ."$usr_profile[local]"
                                        ."</td>\n"
                                        ."   <td align=center>";
                                        echo "$usr[charge]";
                                        echo "</td>\n"
                                                ."   <td align=center>";
                                        echo "<font color=green size=2><B>"._NLPAID."</B></font>";
                                        echo "</td>\n"
                                                ."  </tr>\n";
                                        }
                                        }
                                                        if ($count_rows != $lan['max']) {
                                                $spaces_left = $lan['max'] - $count_rows;
                                                $count_rows += 1;
                                                if ($bc == $bgcolor3) $bc = $bgcolor4;
                                                else $bc = $bgcolor3;
                                                echo "  <tr bgcolor=\"$bc\">\n"
                                                        ."<td>".$count_rows."</td>\n"
                                                        ."   <td>".$spaces_left." Seats Left</td>\n"
                                                        ."   <td>&nbsp;</td>\n"
                                                        ."   <td align=center>&nbsp;</td>\n"
                                                        ."   <td align=center>&nbsp;</td>\n"
                                                        ."   <td align=center>&nbsp;</td>\n"
                                                        ."   <td align=center>&nbsp;</td>\n"
                                                        ."</tr>";
                                        }
                                echo "   </table>\n";

                          // STARTING UNCONFIRMED LIST
               echo "   <BR><P><CENTER><B>"._NLUNCONFIRMEDLIST."</B></CENTER>";
               echo "   <table border=0 cellpadding=3 cellspacing=1 bgcolor=\"\" width=\"100%\">\n"
                   ."    <tr style=\"background-color: ; color: $textcolor1; font-weight: bold;\">\n"
                                   ."     <td width=\"5%\">#</td>\n"
                                   ."     <td width=\"20%\">"._NLUSERNAME."</td>\n"
                                   ."     <td width=\"30%\">"._NLREGDATE."</td>\n"
                                   ."     <td width=\"15%\">"._NLREGTYPE."</td>\n"
                                   ."     <td width=\"10%\" align=center>"._NLLOCAL."</td>\n"
                                   ."     <td width=\"10%\" align=center>"._NLTOTALDUE."</td>\n"
                                   ."     <td width=\"10%\" align=center>"._NLSTATUS."</td>\n"
                                   ."    </tr>\n";
                                $bc = $bgcolor3;
                while($usr2 = $db->sql_fetchrow($users2)) {
                                if ($usr2['lan_paid'] == '0'){
                $usr_profile = $db->sql_fetchrow($db->sql_query("SELECT * FROM nukelan_gamer_profiles WHERE user_id='$usr2[user_id]'"));
                                        $count_rows2 += 1;
                                        if ($bc == $bgcolor3) $bc = $bgcolor4;
                                        else $bc = $bgcolor3;
                                        echo "  <tr bgcolor=\"$bc\">\n"
                                          ."<td>".$count_rows2."</td>\n"
                                          ."   <td><a href=\"modules.php?name=$ModName&file=profile&lanop=show_profile&profile_id=$usr2[user_id]&pid=$lan[party_id]\">";
                                        if ($uid == $usr2['user_id']) echo "<b>$usr2[username]</b></a>";
                                        else echo "$usr2[username]</a>";
                   if ($usr['femail']) echo " <a href=\"mailto:$usr2[femail]&subject=$lan[keyword]'s LAN Party\"><img src=\"modules/$ModName/images/email.gif\"></a>";
                                        
                                         echo "</td>\n"
                                          ."   <td>";
                                        echo date ("l, M j, Y - g:ia",strtotime("$usr2[lan_date]"));
                                        echo "</td>\n";
                                        echo "<td>";
                                        $lan_user_type = $usr2['regtype'];
                                        if ($lan_user_type == 'a') echo "$lan[name_a]";
                                        if ($lan_user_type == 'b') echo "$lan[name_b]";
                                        if ($lan_user_type == 'c') echo "$lan[name_c]";
                                        if ($lan_user_type == 'd') echo "$lan[name_d]";
                                        if ($lan_user_type == 'e') echo "$lan[name_e]";
                                        echo "</td>\n"
                                        ."   <td align=center>"
                                        ."$usr_profile[local]"
                                        ."</td>\n"
                                        ."   <td align=center>";
                                        echo "$usr2[charge]";
                                        echo "</td>\n"
                                                ."";
                                        $pal_tot = ($usr2['charge'] + $party['paypal']['add_chg']);
$content="<center>";
$content  .= "<form action=\"https://www.paypal.com/cgi-bin/webscr\" method=\"post\" target=\"_blank\">";
$content  .= "<td align=\"justify\" >";
$content  .= "<input type=\"hidden\" name=\"cmd\" value=\"_xclick\">";
$content  .= "<input type=\"hidden\" name=\"business\" value=\"".$party['paypal']['account']."\">";
$content  .= "<input type=\"hidden\" name=\"item_name\" value=\"".$usr2['username']." for ".$lan['keyword']." on ".date ("l, M j, Y - g:ia",strtotime("$lan[date]"))."\">";
$content  .= "<input type=\"hidden\" name=\"amount\" value=\"".$usr2['charge']."\">";
$content  .= "<input type=\"hidden\" name=\"no_note\" value=\"0\">";
$content  .= "<input type=\"hidden\" name=\"currency_code\" value=\"EUR\">";
$content  .= "<input type=\"hidden\" name=\"notify_url\" value=\"".$party['paypal']['notify']."\">";
$content  .= "<input type=\"hidden\" name=\"tax\" value=\"0\">";
if($uname!=$usr2['username']){
$content  .= "<input type=\"image\" src=\"https://www.paypal.com/images/x-click-but06.gif\" border=\"0\" name=\"submit\" alt=\"Paypal!\" DISABLED></form></center>";
}else{
$content  .= "<input type=\"image\" src=\"https://www.paypal.com/images/x-click-but06.gif\" border=\"0\" name=\"submit\" alt=\"Paypal!\"></form></center>";
}
echo"$content";
/*
                                        echo "<a href=\"#\" onclick=\"window.open('https://www.paypal.com/xclick/business=".$party['paypal']['account']
                                                ."&item_name=".$usr2['lan_uid']."-".$usr2['lan_id']
                                                ."&amount=$pal_tot&currency_code=USD&notify_url=".$party['paypal']['notify']
                                                ."','cartwin','width=600,height=400,scrollbars,location=no,resizable,status');\">PAYPAL ff</a>\n";
*/
                                        echo "</td>\n"
                                                ."  </tr>\n";
                                        }
                                        }
                                echo "   </table>\n";
                         CloseTable();
                        } elseif ($lan['prepay'] == 0){
                         OpenTable();
               echo "   <table border=0 cellpadding=3 cellspacing=1 bgcolor=\"\" width=\"100%\">\n"
                   ."    <tr style=\"background-color: ; color: $textcolor1; font-weight: bold;\">\n"
                                   ."     <td width=\"5%\">#</td>\n"
                                   ."     <td width=\"20%\">"._NLUSERNAME."</td>\n"
                                   ."     <td width=\"30%\">"._NLREGDATE."</td>\n"
                                   ."     <td width=\"15%\">"._NLREGTYPE."</td>\n"
                                   ."     <td width=\"10%\" align=center>"._NLLOCAL."</td>\n"
                                   ."     <td width=\"10%\" align=center>"._NLTOTALDUE."</td>\n"
                                   ."     <td width=\"10%\" align=center>"._NLSTATUS."</td>\n"
                                   ."    </tr>\n";
                                $bc = $bgcolor3;
                 while($usr = $db->sql_fetchrow($users)) {
                 $usr_profile = $db->sql_fetchrow($db->sql_query("SELECT * FROM nukelan_gamer_profiles WHERE user_id='$usr[user_id]'"));
                                        $count_rows += 1;
                                        if ($bc == $bgcolor3) $bc = $bgcolor4;
                                        else $bc = $bgcolor3;
                                        echo "  <tr bgcolor=\"$bc\">\n"
                                          ."<td>".$count_rows."</td>\n"
                                          ."   <td><a href=\"modules.php?name=$ModName&file=profile&lanop=show_profile&profile_id=$usr[user_id]&pid=$lan[party_id]\">";
                                        if ($uid == $usr['user_id']) echo "<b>$usr[username]</b></a>";
                                        else echo "$usr[username]</a>";
                    if ($usr['femail']) echo " <a href=\"mailto:$usr[femail]&subject=$lan[keyword]'s LAN Party\"><img src=\"modules/$ModName/images/email.gif\"></a>";
                                        
                                         echo "</td>\n"
                                          ."   <td>";
                                        echo date ("l, M j, Y - g:ia",strtotime("$usr[lan_date]"));
                                        echo "</td>\n";
                                        echo "<td>";
                                        $lan_user_type = $usr['regtype'];
                                        if ($lan_user_type == 'a') echo "$lan[name_a]";
                                        if ($lan_user_type == 'b') echo "$lan[name_b]";
                                        if ($lan_user_type == 'c') echo "$lan[name_c]";
                                        if ($lan_user_type == 'd') echo "$lan[name_d]";
                                        if ($lan_user_type == 'e') echo "$lan[name_e]";
                                        echo "</td>\n"
                                        ."   <td align=center>"
                                        ."$usr_profile[local]"
                                        ."</td>\n"
                                        ."   <td align=center>";
                                        echo "$usr[charge]";
                                        echo "</td>\n"
                                                ."";
                                        if ($usr['lan_paid'] == '2'):
                                                echo"<td align=\"justify\" >";
                                                echo "<font color=green size=2><B>"._NLPAID."</B></font>";
                                        elseif ($usr['lan_paid'] == '1'):
                                                echo"<td align=\"justify\" >";
                                                echo "<font color=red>"._NLUNCONFIRMED."</font>";
                                        else:
                                                $pal_tot = ($usr['charge'] + $party['paypal']['add_chg']);

                                       $content="<center>";
$content  .= "<form action=\"https://www.paypal.com/cgi-bin/webscr\" method=\"post\" target=\"_blank\">";
$content  .= "<td align=\"justify\" >";
$content  .= "<input type=\"hidden\" name=\"cmd\" value=\"_xclick\">";
$content  .= "<input type=\"hidden\" name=\"business\" value=\"".$party['paypal']['account']."\">";
$content  .= "<input type=\"hidden\" name=\"item_name\" value=\"".$usr['username']." for ".$lan['keyword']." on ".date ("l, M j, Y - g:ia",strtotime("$lan[date]"))."\">";
$content  .= "<input type=\"hidden\" name=\"amount\" value=\"$usr[charge]\">";
$content  .= "<input type=\"hidden\" name=\"no_note\" value=\"0\">";
$content  .= "<input type=\"hidden\" name=\"currency_code\" value=\"EUR\">";
$content  .= "<input type=\"hidden\" name=\"notify_url\" value=\"".$party['paypal']['notify']."\">";
$content  .= "<input type=\"hidden\" name=\"tax\" value=\"0\">";
if($uname!=$usr['username']){
$content  .= "<input type=\"image\" src=\"https://www.paypal.com/images/x-click-but06.gif\" border=\"0\" name=\"submit\" alt=\"Paypal!\" DISABLED></form></center>";
}else{
$content  .= "<input type=\"image\" src=\"https://www.paypal.com/images/x-click-but06.gif\" border=\"0\" name=\"submit\" alt=\"Paypal!\"></form></center>";
}
echo"$content";
 /*
echo "<a href=\"#\" onclick=\"window.open('https://www.paypal.com/cgi-bin/webscr/business=".$party['paypal']['account']
                                                ."&item_name=".$usr[lan_uid]."-".$usr[lan_id]
                                                ."&amount=$pal_tot&currency_code=USD&notify_url=".$party['paypal']['notify']
                                                ."','cartwin','width=600,height=400,scrollbars,location=no,resizable,status');\">PAYPAL</a>\n";
*/
                                        endif;
                                        echo "</td>\n"
                                                ."  </tr>\n";
                                        }
                                while ($count_rows < $lan['max']) {
                                        $count_rows += 1;
                                        if ($bc == $bgcolor3) $bc = $bgcolor4;
                                        else $bc = $bgcolor3;
                                        echo "  <tr bgcolor=\"$bc\">\n"
                                                ."<td>".$count_rows."</td>\n"
                                                ."   <td>"._NLUNRESERVED."</td>\n"
                                                ."   <td>&nbsp;</td>\n"
                                                ."   <td align=center>n/a</td>\n"
                                                ."   <td align=center>n/a</td>\n"
                                                ."   <td align=center>n/a</td>\n"
                                                ."   <td align=center>n/a</td>\n"
                                                ."</tr>";
                                        }
                                echo "   </table>\n";
                                 CloseTable();
                                if ($lan['max'] >= 30) ShowButtons($lan,$party);
                                }
                        
                        }
        // .......................CASE if NO ONE REGISTERED ........................

        else {
        OpenTable();
        echo "NOBODY";
        echo "<h3 style=\"margin: 4px 1px 4px 1px;\">$lan[keyword] "._NLLANPARTY."</h3>\n"
                ."<p style=\"margin: 0px 0px 4px 10px;\">\n"
                ."    <b>"._NLSTART." ".date ("l, M j, Y - g:ia",strtotime("$lan[date]"))."</b><br>\n"
                        ."    <b>"._NLEND." ".date ("l, M j, Y - g:ia",strtotime("$lan[enddate]"))."</b><br><br>\n"
                ."    <b>".$party['host']['fname']." "._NLISHOST."</b><br>\n"
                ."    "._NLEMAIL." <a href=\"mailto:".$party['host']['email']."\">".$party['host']['email']."</a>\n";

        if ($party['host']['phone']) echo "<br>"._NLPHONE." ".$party['host']['phone'];
                echo "    <br><br>\n"
                ."    <b>"._NLLOCATION."</b><br>\n"
                ."    ".$party['loc']['addr']."<br>\n"
                ."    ".$party['loc']['city']." ".$party['loc']['state'].", ".$party['loc']['zip']."<br>\n"
                ."    [<a href=\"http://www.mapquest.com/maps/map.adp?country=".$party['loc']['state']."&addtohistory=&address=".$party['loc']['addr']."&city=".$party['loc']['city']."&state=".$party['loc']['state']."&zipcode=".$party['loc']['zip']."&homesubmit=Get+Map\" target=\_blank\">"._NLMAP."</a>]\n"
                        ."    [<a href=\"http://www.mapquest.com/directions/main.adp?go=1&do=nw&ct=NA&1y=".$party['loc']['state']."&1a=&1p=&1c=&1s=&1z=&1ah=&2a=".$party['loc']['addr']."&2p=&2c=".$party['loc']['city']."&2z=".$party['loc']['zip']."&2ah=&lr=2&x=64&y=11\" target=\"_blank\">"._NLDIRECTIONS."</a>]\n"
                        ."   </p>\n"
                ."<br>\n";
        if ($lan['disclaimer']) echo "   <p style=\"margin: 0px 0px 4px 10px;\"><b>"._NLINFORMATION."</b><br>$lan[disclaimer]</p><br>\n";
        ShowButtons($lan,$party);
        
        $bc = $bgcolor3;
             CloseTable();
        }

}
 //end ShowParty
function GetPartyStuff($host_id, $loc_id, $paypal_id, $usr_id, $lan_id) {
global $db, $prefix, $user_prefix, $cookie, $user, $uid, $ModName;
   $results['host']   = $db->sql_fetchrow($db->sql_query("SELECT * FROM nukelan_hosts WHERE host_id='$host_id'"));
   $results['loc']    = $db->sql_fetchrow($db->sql_query("SELECT * FROM nukelan_locations WHERE loc_id='$loc_id'"));
   $results['paypal'] = $db->sql_fetchrow($db->sql_query("SELECT * FROM nukelan_paypal WHERE paypal_id='$paypal_id'"));
   $results['signedup'] = $db->sql_fetchrow($db->sql_query("SELECT * FROM nukelan_signedup WHERE lan_uid='$usr_id' AND lan_id='$lan_id'"));
   return $results;
   }

function ShowButtons($lan,$party) {
   global $db, $prefix, $user_prefix, $cookie, $user, $uid, $ModName;
 //
$num_coming = $db->sql_numrows($db->sql_query("SELECT * FROM nukelan_signedup WHERE lan_id='$lan[party_id]'"));
$signedup = $db->sql_numrows($db->sql_query("SELECT * FROM nukelan_signedup WHERE lan_uid='$uid' AND lan_id='$lan[party_id]'"));
$total_charges = 0;
if ($lan['charge_a'] > 0) {
        $total_charges++;
        $charge_name = 'charge_a';
}if ($lan['charge_b'] > 0) {
        $total_charges++;
        $charge_name = 'charge_b';
}if ($lan['charge_c'] > 0) {
        $total_charges++;
        $charge_name = 'charge_c';
}if ($lan['charge_d'] > 0) {
        $total_charges++;
        $charge_name = 'charge_d';
}if ($lan['charge_e'] > 0) {
        $total_charges++;
        $charge_name = 'charge_e';
}
   if ($party['signedup']['lan_uid'] > 0) {
      $pal_tot = ($lan['charge'] + $party['paypal']['add_chg']);
      $mail_tot = ($lan['charge'] + $party['mail']['add_chg']);
   }
   if (!$lan['stop'] && ($party['signedup']['lan_paid'] < 1)) {
      echo "   <table border=0>\n"
          ."    <tr>\n";
      if (($num_coming < $lan['max']) && ($party['signedup']['lan_uid'] < 1) && !$signedup)
           if (!isset($_POST['regstart'])) {              
                  echo "<td>\n"
             
               ."      <form action=\"modules.php?name=$ModName\" method=\"post\" style=\"margin: 0;\">\n"
           //  ."      <input type=hidden name=op value=modload>\n"
               ."      <input type=hidden name=file value=index>\n";
                if (!$db->sql_numrows($db->sql_query("SELECT * FROM nukelan_gamer_profiles WHERE user_id='$uid'"))) {
                        echo"      <input type=hidden name=lanop value=sign_up>\n";
                }
                else
                {
                        echo"      <input type=hidden name=lanop value=submit_signup2>\n";
                }
                        echo"      <input type=hidden name=uid value=".$uid.">\n"
               ."      <input type=hidden name=pid value=$lan[party_id]>\n"
                           ."      <input type=hidden name=email value=$usr[user_email]>\n"
                           ."      <input type=hidden name=showemail value=$usr[user_viewemail]>\n"
               ."      <input type=submit name=regstart value=\""._NLSIGNUP."\" style=\"width: 120px;\">\n"
               ."      </form>\n"
                ."     </td>\n"
             ."    </tr>\n"
             ."   </table>\n";

                }
                           
           if (!$party['signedup']['lan_uid'] && $signedup > 0)
         echo "     <td>\n"
             ."<form action=\"modules.php?name=$ModName\" method=\"post\" style=\"margin: 0;\">\n"
                         ."       <input type=hidden name=op value=modload>\n"
         //    ."       <input type=hidden name=name value='$ModName'>\n"
             ."       <input type=hidden name=file value=index>\n"
             ."       <input type=hidden name=lanop value=drop_me>\n"
             ."       <input type=hidden name=uid value=".$uid.">\n"
             ."       <input type=hidden name=pid value=".$lan['party_id'].">\n"
             ."       <input type=submit value="._NLUNREG." style=\"width: 85px;\">\n"
             ."      </form>\n"
             ."     </td>\n"
             ."    </tr>\n"
             ."   </table>\n";
                         
          if (isset($_POST['regstart'])) 
                if (!$db->sql_numrows($db->sql_query("SELECT * FROM nukelan_gamer_profiles WHERE user_id='$uid'"))) {
                        OpenTable();
                echo "<table border=0 cellpadding=4 cellspacing=4 style=\"width: 400px;\" align=center><tr><td>\n"
                        ."<form action=\"modules.php?name=$ModName\" method=\"post\" style=\"margin: 0;\">\n"
                        ."<input type=hidden name=op value=modload>\n"
                    //    ."<input type=hidden name=name value=$ModName>\n"
                        ."<input type=hidden name=file value=index>\n"
                        ."<input type=hidden name=lanop value=submit_signup>\n"
                        ."<input type=hidden name=uid value=".$uid.">\n"
            ."<input type=hidden name=pid value=$lan[party_id]>\n"
                        ."<BR><font size=1><b>"._NLPAYMENTOPTIONS.":</b><br></font>\n"
                        ."<input type=radio name=charge value=".$lan['charge_a']." CHECKED><font size=1><b>\$".$lan['charge_a']." :: ".$lan['name_a']."</b></font><br>\n";
                        if ($lan['name_b']) {
                        echo "<input type=radio name=charge value=".$lan['charge_b']."><font size=1><b>\$".$lan['charge_b']." :: ".$lan['name_b']."</b></font><br>\n";
                        }
                        if ($lan['name_c']) {
                        echo "<input type=radio name=charge value=".$lan['charge_c']."><font size=1><b>\$".$lan['charge_c']." :: ".$lan['name_c']."</b></font><br>\n";
                        }
                        if ($lan['name_d']) {
                        echo "<input type=radio name=charge value=".$lan['charge_d']."><font size=1><b>\$".$lan['charge_d']." :: ".$lan['name_d']."</b></font><br>\n";
                        }
                        if ($lan['name_e']) {
                        echo "<input type=radio name=charge value=".$lan['charge_e']."><font size=1><b>\$".$lan['charge_e']." :: ".$lan['name_e']."</b></font><br>\n";
                        }
                echo "<br><br><font size=1><b>Gamer Profile:</b><br></font>\n"
                        ."<font size=1><b>Please fill out the following information for our records.</b></font>\n"
                        ."<font size=2><b><br><br>Personal Info:</b><br></font>\n"
                        ."<font size=1><br><b>"._NLREALNAME."</b> "._NLREALNAME2."<br></font>\n"
                        ."<input type=text name=realname maxlength=30 style=\"width: 240px;\"><br>\n"
                        ."<font size=1><b>"._NLALIAS."</b> "._NLALIAS2."<br></font>\n"
                        ."<input type=text name=alias maxlength=30 style=\"width: 240px;\"><br>\n"
                        ."<font size=1><b>"._NLGROUP."</b> "._NLGROUP2."<br></font>\n"
                        ."<input type=text name=gaming_group maxlength=20 style=\"width: 120px;\"><br>\n"
                        ."<font size=1><b>"._NLAGE."</b><br></font>\n"
                        ."<input type=text name=age maxlength=2 style=\"width: 120px;\"><br>\n"
                        ."<font size=1><b>"._NLGENDER."</b><br></font>\n"
                        ."<select name=gender>\n"
                        ."<option value="._NLMALE.">"._NLMALE."</option>\n"
                        ."<option value="._NLFEMALE.">"._NLFEMALE."</option>\n"
                        ."</select><br>\n"
                        ."<br>\n"
                        ."<font size=1><b>"._NLAREYOULOCAL."</b><br></font>\n"
                        ."<select name=local>\n"
                        ."<option value=yes>yes</option>\n"
                        ."<option value=no>no</option>\n"
                        ."</select><br>\n"
                        ."<br>\n"
                        ."<font size=1><b>"._NLPROFICIENCY."</b><br></font>\n"
                        ."<select name=proficiency>\n"
                        ."<option value=1>1 - </option>\n"
                        ."<option value=2>2 - </option>\n"
                        ."<option value=3>3 - </option>\n"
                        ."<option value=4>4 - </option>\n"
                        ."<option value=5>5 - </option>\n"
                        ."<option value=6>6 - </option>\n"
                        ."<option value=7>7 - </option>\n"
                        ."<option value=8>8 - </option>\n"
                        ."<option value=9>9 - </option>\n"
                        ."<option value=10>10 - </option>\n"
                        ."</select><br>\n"
                        ."<br>\n"
                        ."<font size=1><b>"._NLQUOTE."</b> "._NLQUOTE2."<br></font>\n"
                        ."<input type=text name=quote maxlength=30 style=\"width: 240px;\"><br>\n"
                        ."<font size=2><br><br><b>"._NLHARDWARE."</b> "._NLQUOTE2."</font><br><br>\n"
                        ."<font size=1><b>"._NLMOBO."</b><br></font>\n"
                        ."<input type=text name=mobo maxlength=30 style=\"width: 240px;\"><br>\n"
                        ."<font size=1><b>"._NLPROCESSOR."</b><br></font>\n"
                        ."<input type=text name=processor maxlength=30 style=\"width: 240px;\"><br>\n"
                        ."<font size=1><b>"._NLMEMORY."</b><br></font>\n"
                        ."<input type=text name=memory maxlength=30 style=\"width: 240px;\"><br>\n"
                        ."<font size=1><b>"._NLVIDEOCARD."</b><br></font>\n"
                        ."<input type=text name=video maxlength=30 style=\"width: 240px;\"><br>\n"
                        ."<font size=1><b>"._NLSOUNDCARD."</b><br></font>\n"
                        ."<input type=text name=sound maxlength=30 style=\"width: 240px;\"><br>\n"
                        ."<font size=1><b>"._NLHEADPHONES."</b><br></font>\n"
                        ."<input type=text name=headphones maxlength=30 style=\"width: 240px;\"><br>\n"
                        ."<font size=1><b>"._NLMONITOR."</b><br></font>\n"
                        ."<input type=text name=monitor maxlength=30 style=\"width: 240px;\"><br>\n"
                        ."<font size=1><b>"._NLMOUSE."</b><br></font>\n"
                        ."<input type=text name=mouse maxlength=30 style=\"width: 240px;\"><br>\n"
                        ."<font size=1><b>"._NLMOUSEPAD."</b><br></font>\n"
                        ."<input type=text name=mousepad maxlength=30 style=\"width: 240px;\"><br>\n"
                        ."<font size=1><b>"._NLKEYBOARD."</b><br></font>\n"
                        ."<input type=text name=keyboard maxlength=30 style=\"width: 240px;\"><br>\n"
                        ."<div align=right><input type=submit value=\""._NLREGISTER."\" style=\"width: 160px;\"></div>\n"
                        ."</form>\n"
                        ."</td></tr></table>\n"
                        ." \n";
                        CloseTable();
                } elseif ($total_charges == 1) {
                // if there is only one type of charge
                $charge = $lan[$charge_name];
              //  signup3($uid, $lan['party_id'], $charge);
			  /**/
			   OpenTable();
                        echo "<table border=0 cellpadding=4 cellspacing=4 style=\"width: 400px;\" align=center><tr><td>\n"
                        ."<form action=\"modules.php?name=$ModName\" method=\"post\" style=\"margin: 0;\">\n"
                        ."<input type=hidden name=op value=modload>\n"
                      //  ."<input type=hidden name=name value=$ModName>\n"
                        ."<input type=hidden name=file value=index>\n"
                        ."<input type=hidden name=lanop value=submit_signup3>\n"
                        ."<input type=hidden name=uid value=".$uid.">\n"
            ."<input type=hidden name=pid value=$lan[party_id]>\n"
                        ."<br>\n"
                        ."<BR><font size=1><b>"._NLPAYMENTOPTIONS.":</b><br></font>\n";
						if ($lan['name_a']) {
                        echo"<input type=radio name=charge value=".$lan['charge_a']." CHECKED><font size=1><b>\$".$lan['charge_a']." :: ".$lan['name_a']."</b></font><br>\n";
						}
                        if ($lan['name_b']) {
                        echo "<input type=radio name=charge value=".$lan['charge_b']."><font size=1><b>\$".$lan['charge_b']." :: ".$lan['name_b']."</b></font><br>\n";
                        }
                        if ($lan['name_c']) {
                        echo "<input type=radio name=charge value=".$lan['charge_c']."><font size=1><b>\$".$lan['charge_c']." :: ".$lan['name_c']."</b></font><br>\n";
                        }
                        if ($lan['name_d']) {
                        echo "<input type=radio name=charge value=".$lan['charge_d']."><font size=1><b>\$".$lan['charge_d']." :: ".$lan['name_d']."</b></font><br>\n";
                        }
                        if ($lan['name_e']) {
                        echo "<input type=radio name=charge value=".$lan['charge_e']."><font size=1><b>\$".$lan['charge_e']." :: ".$lan['name_e']."</b></font><br>\n";
                        }
                        echo "<div align=right><input type=submit value=\""._NLPAYMENAM."\" style=\"width: 160px;\"></div>\n"
                        ."</form>\n"
                        ."</td></tr></table>\n"
                        ."     \n";

                        CloseTable();
			  /**/
                //Header("Location: modules.php?op=modload&name=$ModName&lanop=submit_signup3&uid=$uid&pid=$lan[party_id]&charge=$charge");
                /*echo "<form action=\"modules.php\" method=\"post\" style=\"margin: 0;\" id=\"signupform\">\n"
                        ."<input type=hidden name=op value=modload>\n"
                        ."<input type=hidden name=name value=$ModName>\n"
                        ."<input type=hidden name=file value=index>\n"
                        ."<input type=hidden name=lanop value=submit_signup3>\n"
                        ."<input type=hidden name=uid value=".$uid.">\n"
            ."<input type=hidden name=pid value=$lan[party_id]>\n"
                        ."<input type=hidden name=charge value=$charge>\n"
                        ."<form>";
                */
        echo "</td></tr></table>";
                } else {
                OpenTable();
                        echo "<table border=0 cellpadding=4 cellspacing=4 style=\"width: 400px;\" align=center><tr><td>\n"
                        ."<form action=\"modules.php?name=$ModName\" method=\"post\" style=\"margin: 0;\">\n"
                        ."<input type=hidden name=op value=modload>\n"
                      //  ."<input type=hidden name=name value=$ModName>\n"
                        ."<input type=hidden name=file value=index>\n"
                        ."<input type=hidden name=lanop value=submit_signup3>\n"
                        ."<input type=hidden name=uid value=".$uid.">\n"
            ."<input type=hidden name=pid value=$lan[party_id]>\n"
                        ."<br>\n"
                        ."<BR><font size=1><b>"._NLPAYMENTOPTIONS.":</b><br></font>\n"
                        ."<input type=radio name=charge value=".$lan['charge_a']." CHECKED><font size=1><b>\$".$lan['charge_a']." :: ".$lan['name_a']."</b></font><br>\n";
                        if ($lan['name_b']) {
                        echo "<input type=radio name=charge value=".$lan['charge_b']."><font size=1><b>\$".$lan['charge_b']." :: ".$lan['name_b']."</b></font><br>\n";
                        }
                        if ($lan['name_c']) {
                        echo "<input type=radio name=charge value=".$lan['charge_c']."><font size=1><b>\$".$lan['charge_c']." :: ".$lan['name_c']."</b></font><br>\n";
                        }
                        if ($lan['name_d']) {
                        echo "<input type=radio name=charge value=".$lan['charge_d']."><font size=1><b>\$".$lan['charge_d']." :: ".$lan['name_d']."</b></font><br>\n";
                        }
                        if ($lan['name_e']) {
                        echo "<input type=radio name=charge value=".$lan['charge_e']."><font size=1><b>\$".$lan['charge_e']." :: ".$lan['name_e']."</b></font><br>\n";
                        }
                        echo "<div align=right><input type=submit value=\""._NLPAYMENAM."\" style=\"width: 160px;\"></div>\n"
                        ."</form>\n"
                        ."</td></tr></table>\n"
                        ."     \n";

                        CloseTable();
                        }
       }
     //
   }

function ChangeStatus($uid,$pid,$status) {
global $db, $prefix, $user_prefix, $cookie, $user, $uid, $ModName;
   if ($uid <= 1) die (""._NLMUSTBEREGISTERED."");
   $party = $db->sql_fetchrow($db->sql_query("SELECT * FROM nukelan_parties WHERE party_id='$pid'"));
   $signedup = $db->sql_numrows($db->sql_query("SELECT * FROM nukelan_signedup WHERE lan_uid='$uid' AND lan_id='$pid'"));
 
   switch ($status) {
      case 'drop':
         if (!$signedup) echo "<font color=\"#FF0000\" size=3><b>"._NLNOTSIGNEDUP."<br></b></font><br>";
         elseif (!$db->sql_query("DELETE FROM nukelan_signedup WHERE lan_uid='$uid' AND lan_id='$pid'")) echo ""._NLCANNOTDELETE."<br>";
         break;
      case 'paid':
	  				if ($charge == 0){$lan_paid = 2; echo"".$lan_paid.""; exit;}	
         if (!signedup) echo "<font color=\"#FF0000\" size=3><b>"._NLNOTSIGNEDUP."<br></b></font><br>";
         elseif (!$db->sql_query("UPDATE nukelan_signedup SET lan_paid='1' WHERE lan_uid='$uid' AND lan_id='$pid'")) echo ""._NLCANNOTUPDATE."<br>";
         if (!$sys) break;
         elseif (!$db->sql_query("UPDATE nukelan_signedup SET lan_sys='2' WHERE lan_uid='$uid' AND lan_id='$pid'")) echo ""._NLCANNOTUPDATE."<br>";
         break;
      default:
         if ($signedup) echo "<font color=\"#FF0000\" size=3><b>"._NLALREADYREGISTERED."</b></font><br>";
//      elseif (!$db->sql_query("INSERT INTO nukelan_signedup SET lan_uid='$uid', lan_id='$pid', lan_date=NOW(), charge='$charge'")) echo ""._NLCANNOTINSERT."<br>";
                 else {  
//             echo ""._NLREGISTRATIONSUCCESSFUL."<br>";        
               }
         break;
      }
}

function signup($uid, $pid, $realname, $alias, $gaming_group, $age, $gender, $local, $proficiency, $quote, $mobo, $processor, $memory, $video, $sound, $headphones, $monitor, $mouse, $mousepad, $keyboard, $charge) {
global $db, $prefix, $user_prefix, $cookie, $user, $uid, $ModName;
        if ($db->sql_numrows($db->sql_query("SELECT * FROM nukelan_signedup WHERE lan_uid='$uid' AND lan_id='$pid'"))) {
			OpenTable();
			echo "<font color=\"#FF0000\" size=3><b>"._NLALREADYREGISTERED."</b></font><br>";
			echo "<form>
			<input type=\"button\" value=\""._NLGOBACK."\" onclick=\"history.back()\" />
			</form>";			
			CloseTable();
			exit; }
        if (!$db->sql_query("INSERT INTO nukelan_gamer_profiles (user_id, name, alias, gaming_group, age, gender, local, proficiency, quote) VALUES ('$uid', '$realname', '$alias', '$gaming_group', '$age', '$gender', '$local', '$proficiency', '$quote')")) echo ""._NLCANNOTINSERTPROFILE."<br>";
        elseif (!$db->sql_query("INSERT INTO nukelan_gamer_rigs (user_id, mobo, processor, memory, video, sound, headphones, monitor, mouse, mousepad, keyboard) VALUES ('$uid', '$mobo', '$processor', '$memory', '$video', '$sound', '$headphones', '$monitor', '$mouse', '$mousepad', '$keyboard')")) {
                echo ""._NLCANNOTINSERTRIG."<br>";
                $not_ok = 1;
        } elseif (!$not_ok) {
                $lan2 = $db->sql_fetchrow($db->sql_query("SELECT * FROM nukelan_parties WHERE party_id='$pid'"));
        $charge_a = $lan2['charge_a'];
                $name_a = $lan2['name_a'];
                $charge_b = $lan2['charge_b'];
                $name_b = $lan2['name_b'];
                $charge_c = $lan2['charge_c'];
                $name_c = $lan2['name_c'];
                $charge_d = $lan2['charge_d'];
                $name_d = $lan2['name_d'];
                $charge_e = $lan2['charge_e'];
                $name_e = $lan2['name_e'];
                if ($charge == $charge_a) {
                        $charge_type = 'a';
                } elseif ($charge == $charge_b) {
                        $charge_type = 'b';
                } elseif ($charge == $charge_c) {
                        $charge_type = 'c';
                } elseif ($charge == $charge_d) {
                        $charge_type = 'd';
                } elseif ($charge == $charge_e) {
                        $charge_type = 'e';
                }
			if ($charge == 0){$lan_paid = 2; /*echo"".$lan_paid.""; exit;*/}					
			//if (!$db->sql_query("INSERT INTO nukelan_signedup SET lan_uid='$uid', lan_id='$pid', lan_date=NOW(), charge='$charge', regtype='$charge_type'")) {
            if (!$db->sql_query("INSERT INTO nukelan_signedup SET lan_uid='$uid', lan_id='$pid', lan_paid='$lan_paid', lan_date=NOW(), charge='$charge', regtype='$charge_type'")) {
                //if (!$db->sql_query("UPDATE nukelan_signedup SET charge='$charge', regtype='$charge_type' WHERE lan_uid='$uid' AND lan_id='$pid'")) {
                echo ""._NLCANNOTUPDATE."<br>";
                }
        
        } else {
                echo ""._NLPROFILECREATED."<br>";
                

        }
}

function signup3($uid, $pid, $charge) {
global $db, $prefix, $user_prefix, $cookie, $user, $uid, $ModName;
        if ($db->sql_numrows($db->sql_query("SELECT * FROM nukelan_signedup WHERE lan_uid='$uid' AND lan_id='$pid'"))) {
			OpenTable();
			echo "<font color=\"#FF0000\" size=3><b>"._NLALREADYREGISTERED."</b></font><br><br>";
			echo "<form>
			<input type=\"button\" value=\""._NLGOBACK."\" onclick=\"history.back()\" />
			</form>";
			CloseTable();
			exit; }
          $lan2 = $db->sql_fetchrow($db->sql_query("SELECT * FROM nukelan_parties WHERE party_id='$pid'"));
        $charge_a = $lan2['charge_a'];
                $name_a = $lan2['name_a'];
                $charge_b = $lan2['charge_b'];
                $name_b = $lan2['name_b'];
                $charge_c = $lan2['charge_c'];
                $name_c = $lan2['name_c'];
                $charge_d = $lan2['charge_d'];
                $name_d = $lan2['name_d'];
                $charge_e = $lan2['charge_e'];
                $name_e = $lan2['name_e'];
                if ($charge == $charge_a) {
                        $charge_type = 'a';
                } elseif ($charge == $charge_b) {
                        $charge_type = 'b';
                } elseif ($charge == $charge_c) {
                        $charge_type = 'c';
                } elseif ($charge == $charge_d) {
                        $charge_type = 'd';
                } elseif ($charge == $charge_e) {
                        $charge_type = 'e';
                }
				if ($charge == 0){$lan_paid	= 2;}			
                if (!$db->sql_query("INSERT INTO nukelan_signedup SET lan_uid='$uid', lan_id='$pid', lan_paid='$lan_paid' , lan_date=NOW(), charge='$charge'")) {
                        echo ""._NLCANNOTINSERT."<br>";
                } elseif (!$db->sql_query("UPDATE nukelan_signedup SET charge='$charge', regtype='$charge_type' WHERE lan_uid='$uid' AND lan_id='$pid'")) {
                                echo ""._NLCANNOTUPDATE."<br>";
                
                } else {
                OpenTable();
                echo "<b><center>"._NLREGISTRATIONSUCCESSFUL."</center></b><br>";
                Header("Location: modules.php?name=$ModName&lanop=show_party&party_id=".$pid."");
                CloseTable();
                }
}

  switch ($lanop) {
   case 'show_party':
      $party = $db->sql_fetchrow($db->sql_query("SELECT * FROM nukelan_parties WHERE party_id='$party_id'"));
      ShowParty($party);
      break;
   case 'sign_up':
     if ($uid < 2) {
     OpenTable();
         echo ""._NLCANNOTSIGNUP."  <a href=\"modules.php?name=Your_Account\">"._NLCLICKHERE."</a> "._NLTOREGISTER."";
     CloseTable();    
         } else {
      $party = $db->sql_fetchrow($db->sql_query("SELECT * FROM nukelan_parties WHERE party_id='$pid'"));
          ShowParty2($party);
          }
      break;
   case 'submit_signup':
         ChangeStatus($uid,$pid,$charge);
          signup($uid, $pid, $realname, $alias, $gaming_group, $age, $gender, $local, $proficiency, $quote, $mobo, $processor, $memory, $video, $sound, $headphones, $monitor, $mouse, $mousepad, $keyboard, $charge);
      $party = $db->sql_fetchrow($db->sql_query("SELECT * FROM nukelan_parties WHERE party_id='$pid'"));
          ShowParty($party);
      break;
    case 'submit_signup2':
      ChangeStatus($uid,$pid,'');
          $party = $db->sql_fetchrow($db->sql_query("SELECT * FROM nukelan_parties WHERE party_id='$pid'"));
          ShowParty2($party);
          break;
   case 'submit_signup3':
   //   ChangeStatus($uid,$pid,'');
          signup3($uid, $pid, $charge);
      $party = $db->sql_fetchrow($db->sql_query("SELECT * FROM nukelan_parties WHERE party_id='$pid'"));
//          ShowParty($party);
      break;
   case 'drop_me':
      ChangeStatus($uid,$pid,'drop');
      $party = $db->sql_fetchrow($db->sql_query("SELECT * FROM nukelan_parties WHERE party_id='$pid'"));
      ShowParty($party);
      break;
   case 'paid':
      ChangeStatus($uid,$pid,'paid');
      $party = $db->sql_fetchrow($db->sql_query("SELECT * FROM nukelan_parties WHERE party_id='$pid'"));
      ShowParty($party);
     break;
   default:

      if ($num_lans > 1) ListParties($parties);
      elseif ($num_lans == 1) {
         $lan = $db->sql_fetchrow($parties);
         ShowParty($lan);
         }

      else{
       OpenTable();
      echo "<table border=0 width=100%><tr height=500px valign=center><td align=center><h2>"._NLNOLANSRUNNING."</h2></td></tr></table>";
      CloseTable();
      break;
	  }
   }


echo "<br>";
include ("footer.php");

?>
