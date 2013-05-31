<?php
// filename: prizes.php
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


$index = $lanconfig['index'];

global $prefix, $db,  $bgcolor3, $bgcolor4;

include ("header.php");
OpenTable();

$data = $db->sql_query("SELECT * FROM nukelan_prizes ORDER BY prizevalue DESC WHERE tourneyid='0' AND tourneyplace='0'");
$prizes = $db->sql_query("SELECT * FROM nukelan_prizes WHERE tourneyid >= 1 AND tourneyplace >= 1");
$parties = $db->sql_query("SELECT * FROM nukelan_parties");
$num_parties = $db->sql_numrows($parties);

function ShowPrizes($data, $prizes, $party) {
global $prefix, $db,  $bgcolor3, $bgcolor4, $ModName;
$lan = $db->sql_fetchrow($db->sql_query("SELECT * FROM nukelan_parties WHERE party_id='$party'"));
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

echo "<table align=center border=0 cellpadding=3 cellspacing=1 bgcolor=\"$bgcolor1\" width=\"80%\">\n"
       ."    <tr style=\"background-color: $bgcolor2; color: $textcolor1;\">\n"
       ."     <td width=\"100%\" align=center><b>"._NLTOURNEYPRIZES."</b></td>\n"
       ."    </tr></table>\n";
echo "   <table align=center border=0 cellpadding=3 cellspacing=1 bgcolor=\"$bgcolor1\" width=\"80%\">\n"
       ."    <tr style=\"background-color: $bgcolor2; color: $textcolor1; font-weight: bold;\">\n"
       ."     <td width=\"5%\">#</td>\n"
       ."     <td width=\"20%\">"._NLPRIZENAME."</td>\n"
       ."     <td align=center width=\"10%\">"._NLPICTURE."</td>\n"
       ."     <td width=\"10%\" align=center>"._NLPRIZEVALUE."</td>\n"
       ."     <td width=\"30%\" align=center>"._NLPRIZETOURNAMENT."</td>\n"
           ."     <td width=\"10%\" align=center>"._NLPRIZEPLACE."</td>\n"
       ."    </tr>\n";
   if(!$db->sql_numrows($prizes)) echo "<tr><td colspan=7 align=center>"._NLNOPRIZES."</td></tr>";
        else {          
        while($prz = $db->sql_fetchrow($prizes)) {
        
        $count_rows += 1;
$tourney2 = $db->sql_query("SELECT * FROM nukelan_tournaments WHERE tourneyid='$prz[tourneyid]'");
$tname2 = $db->sql_fetchrow($tourney2);

if ($prz[tourneyplace] == '1') $place = "1st Place";
elseif ($prz[tourneyplace] == '2') $place = "2nd Place";
elseif ($prz[tourneyplace] == '3') $place = "3rd Place";
elseif ($prz[tourneyplace] == '4') $place = "4th Place";

        if ($bc == $bgcolor3) $bc = $bgcolor4;
        else $bc = $bgcolor3;
        echo "  <tr bgcolor=\"$bc\">\n"
        ."<td>".$count_rows."</td>\n"
        ."<td>\n";
                echo "$prz[prizename]"
        ."</td>\n"
                ."<td align=center>\n";
                if ($prz['prizepicture']) {
                echo "<a href=\"$prz[prizepicture]\">";
                echo ""._NLPICTURE2."</a>";
                } else {
                echo ""._NLNOPICTURE."\n";
                }
                echo "</td>\n"
                ."<td align=center>";
        echo "$prz[prizevalue]";
        echo "</td>\n"
                ."   <td align=center>";
        echo "$tname2[name]";
        echo "</td>\n"
                ."   <td align=center>";
        print "<font color=green size=1><b>$place</b></font>";
                echo "</td>\n"
                ."  </tr>\n";
                        }
                        }
echo "   </table>\n";
echo "<br><br><br>";

echo "<table align=center border=0 cellpadding=3 cellspacing=1 bgcolor=\"$bgcolor1\" width=\"80%\"\n"
        ."<tr style=\"background-color: $bgcolor2; color: $textcolor1;\">\n"
        ."<td width=\"100%\" align=center><b>"._NLNONTOURNEYPRIZES."</b></td>\n"
    ."</tr>\n";
echo "<table align=center border=0 cellpadding=3 cellspacing=1 bgcolor=\"$bgcolor1\" width=\"80%\"\n"
        ."<tr style=\"background-color: $bgcolor2; color: $textcolor1;\">\n"
        ."<td width=\"5%\"><b>#</b></td>\n"
    ."<td width=\"65%\"><b>"._NLPRIZENAME."</b></td>\n"
    ."<td align=center width=\"20%\"><b>"._NLPICTURE."</b></td>\n"
        //."<td align=center width=\"20%\"><b>"._NLWINNER."</b></td>\n"
        //."<td align=center width=\"10%\"><b>"._NLCLAIMED."</b></td>\n"
        ."<td width=\"10%\" align=center><b>"._NLPRIZEVALUE."</b></td>\n"
    ."</tr>\n";
   if(!$db->sql_numrows($data)) echo "<tr><td colspan=5 align=center>"._NLNOPRIZES."</td></tr>";
        else {          
        $bc = $bgcolor3;
        $tot_prz_val = 0;
        while($prz2 = $db->sql_fetchrow($data)) {
                $prizevalue = $prz2['prizevalue'];
                if ($prz2['quantity'] > 1) {
                $prizevalue = $prz2['prizevalue'] * $prz2['quantity'];
                }
                $tot_prz_val = $prizevalue+$tot_prz_val;
                $count_rows += 1;
        if ($bc == $bgcolor3) $bc = $bgcolor4;
        else $bc = $bgcolor3;
        echo "  <tr bgcolor=\"$bc\">\n"
        ."<td>".$count_rows."</td>\n"
        ."<td>\n";
                echo "$prz2[prizename]"
        ."</td>\n"
                ."<td align=center>\n";
                if ($prz2[prizepicture]) {
                echo "<a href=\"$prz2[prizepicture]\">";
                echo "["._NLPICTURE2."]</a>";
                } else {
                echo ""._NLNOPICTURE."\n";
                }
                echo "</td>\n"
                /*."<td align=center>";
        if ($prz2[win_uid] > 0) {
                $row = $db->sql_fetchrow($db->sql_query("SELECT * FROM ".$prefix."_users WHERE user_id='$prz2[win_uid]'"));
                echo "$row[username]";
        } else {
                echo ""._NLNOTAWARDED."";
        }
                echo "</td>\n"
                        ."<td align=center>";
        if ($prz2['claimed'] == 1) {
        $pickedup = ""._NLCLAIMED."";
        } else { 
        $pickedup = ""._NLUNCLAIMED."";
        }
                echo "$pickedup";
                echo "</td>\n"*/
                ."<td align=center>";
        echo "$prz2[prizevalue]";
        echo "</td>\n"
                
                ."  </tr>\n";
                        }
                
                }
echo "<tr><td colspan=3 align=right><b>"._NLPRIZETOTAL."</b></td><td align=center>$tot_prz_val</td></tr>";
echo "</table>\n";
}

function PickParty($parties) {
   global $prefix, $db, $bgcolor1, $bgcolor2, $bgcolor3, $bgcolor4, $textcolor1, $textcolor2, $ModName, $sitename;
   echo "<center><h2>"._NLPICKALAN."</h2></center>\n"
       ."<table align=center border=0 cellpadding=3 cellspacing=1 bgcolor=\"$bgcolor1\" width=\"75%\">\n"
           ."<tr style=\"background-color: $bgcolor2; color: $textcolor1; font-weight: bold;\">\n"
           ."<td width=\"100%\">"._NLLANPARTYNAME."</td>\n"
           ."</tr>\n";
           $bc = $bgcolor3;
   while($lan = $db->sql_fetchrow($parties)) {
      if ($bc == $bgcolor3) $bc = $bgcolor4;
      else $bc = $bgcolor3;
      echo "    <tr bgcolor=\"$bc\">\n"
              ."<td>\n"
                  ."<a href=\"modules.php?op=modload&name=$ModName&amp;file=prizes&amp;lanop=show_prizes&amp;party=$lan[party_id]\">$lan[keyword]</a></td>\n"
                  ." </tr>\n";
                  }
        echo "</table>\n";
}

switch ($lanop) {
  case 'show_prizes':
    $data = $db->sql_query("SELECT * FROM nukelan_prizes WHERE tourneyid=0 AND tourneyplace=0 AND config_id='$party' ORDER BY prizevalue DESC");
    $prizes = $db->sql_query("SELECT * FROM nukelan_prizes WHERE tourneyid >= 1 AND tourneyplace >=1 AND config_id='$party'");
        ShowPrizes($data, $prizes, $party);
        break;
  default:
    if ($num_parties == 1) ShowPrizes($data,$prizes,$party);
        elseif ($num_parties >= 2) PickParty($parties);
    else echo "<table border=0 width=100%><tr height=500px valign=center><td align=center><h2>"._NLNOPARTIESSETUP."</h2></td></tr></table>";
        break;
}
CloseTable();
echo "<br>";
include ("footer.php");
?>
