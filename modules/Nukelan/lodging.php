<?php
// filename: lodging.php
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


$activeconfig = $db->sql_fetchrow($db->sql_query("SELECT * FROM nukelan_config"));
$active = "$activeconfig[activeid]";
$hotels = $db->sql_query("SELECT * FROM nukelan_lodging ORDER BY name");
$num_hotels = $db->sql_numrows($hotels);
$parties = $db->sql_query("SELECT * FROM nukelan_parties ORDER BY keyword");
$num_parties = $db->sql_numrows($parties);

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
                
function ListHotels($hotels) {
   global $db, $prefix, $bgcolor1, $bgcolor2, $bgcolor3, $bgcolor4, $textcolor1, $textcolor2, $ModName, $sitename;
   echo "<center><h2>"._NLLOCALLODGING."</h2></center>\n"
       ."<table align=center border=0 cellpadding=3 cellspacing=1 bgcolor=\"$bgcolor1\" width=\"75%\">\n"
       ."<br><br><font size=1><b>"._NLFACILITYINFO."</b><br>\n"
           ."<tr style=\"background-color: $bgcolor2; color: $textcolor1; font-weight: bold;\">\n"
       ."<td width=\"20%\">"._NLBUSINESSNAME."</td>\n"
           ."<td width=\"20%\">"._NLLODGEADDRESS."</td>\n"
           ."<td width=\"20%\">"._NLLODGEPHONE."</td>\n"
           ."<td width=\"20%\">"._NLCOSTPERNIGHT."<br>"._NLINDOLLARS."</td>\n"
           ."<td width=\"20%\">"._NLTRAVELTIME."<br>"._NLTRAVELTIME2."</td>\n"
       ."</tr>\n";
   $bc = $bgcolor3;
   while($hotel = $db->sql_fetchrow($hotels)) {
      if ($bc == $bgcolor3) $bc = $bgcolor4;
      else $bc = $bgcolor3;
      echo "    <tr bgcolor=\"$bc\">\n"
              ."<td>$hotel[name]</td>\n"
                  ."<td>$hotel[address]</td>\n"
                  ."<td>$hotel[phone]</td>\n"
                  ."<td>$hotel[costpernight].00</td>\n"
                  ."<td>$hotel[traveltime] minutes</td>\n"
                  ."    </tr>\n";
      }
   echo "   </table>\n";
   }
function PickParty($parties) {
   global $db, $prefix, $bgcolor1, $bgcolor2, $bgcolor3, $bgcolor4, $textcolor1, $textcolor2, $ModName, $sitename;
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
                  ."<a href=\"modules.php?op=modload&name=$ModName&amp;file=lodging&amp;lanop=show_lodges&amp;pid=$lan[party_id]\">$lan[keyword]</a></td>\n"
                  ." </tr>\n";
                  }
        echo "</table>\n";
}
   
switch ($lanop) {
   case 'show_lodges':
   $hotels = $db->sql_query("SELECT * FROM nukelan_lodging WHERE config_id='$pid'");
   $num_hotels2 = $db->sql_numrows($hotels);
   if ($num_hotels2 >= 1) {
           ListHotels($hotels);
          }
      else echo "<table border=0 width=100%><tr height=500px valign=center><td align=center><h2>"._NLNOLODGINGFORPARTY."</h2></td></tr></table>";
      break;
   default:
      if ($num_parties == 1) ListHotels($hotels);
          elseif ($num_parties >= 2) PickParty($parties);
      else echo "<table border=0 width=100%><tr height=500px valign=center><td align=center><h2>"._NLNOLODGING."</h2></td></tr></table>";
      break;
   }
CloseTable();
include ("footer.php");
?>
