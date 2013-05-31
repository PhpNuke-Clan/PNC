<?php
// filename: sponsors.php
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
if (!$pid) die("You can't access this file directly...");
$index = $lanconfig['index'];

include ("header.php");
OpenTable();
$lan = $db->sql_fetchrow($db->sql_query("SELECT * FROM nukelan_parties WHERE party_id='$pid'"));
echo "<center> :: <a href=\"modules.php?op=modload&name=$ModName&amp;file=index&amp;lanop=show_party&amp;party_id=$pid\">"._NLEVENTINFO."</a> :";
// if tournaments for this LAN
if ($db->sql_numrows($db->sql_query("SELECT * FROM nukelan_tournaments WHERE config_id='$lan[party_id]'"))) {
echo ": <a href=\"modules.php?op=modload&name=$ModName&amp;file=tourneys&amp;lanop=show_list&amp;pid=$pid\">"._NLTOURNAMENTS."</a> :";
}
// if Prizes for this LAN
if ($db->sql_numrows($db->sql_query("SELECT * FROM nukelan_prizes WHERE config_id='$lan[party_id]'"))) {
echo ": <a href=\"modules.php?op=modload&name=$ModName&amp;file=prizes&amp;lanop=show_prizes&amp;party=$pid\">"._NLPRIZES."</a> :";
}
// if lodgin for this LAN
if ($db->sql_numrows($db->sql_query("SELECT * FROM nukelan_lodging WHERE config_id='$lan[party_id]'"))) {
echo ": <a href=\"modules.php?op=modload&name=$ModName&amp;file=lodging&amp;lanop=show_lodges&amp;pid=$pid\">"._NLLODGING."</a> :";
}
// if Seating Chart for this LAN
if ($lan['schart'] > 0) {
echo ": <a href=\"modules.php?op=modload&name=$ModName&amp;file=seating_chart&amp;seat=showChart&amp;pid=$pid\">"._NLSEATINGCHART."</a> :";
}
// if LAN has sponsors
if ($db->sql_numrows($db->sql_query("SELECT * FROM nukelan_sponsors_parties WHERE party_id='$pid'"))) {
echo ": <a href=\"modules.php?op=modload&name=$ModName&amp;file=sponsors&amp;pid=$pid\">"._NLPARTYSPONSORS."</a> :";
}
echo ": <a href=\"modules.php?op=modload&name=$ModName&amp;file=profile&amp;pid=$pid\">"._NLPROFILE."</a>  ::</center>";
CloseTable();
echo "<br>";
OpenTable();

global $db, $prefix, $bgcolor1, $bgcolor2, $bgcolor3, $bgcolor4, $textcolor1, $textcolor2, $ModName, $sitename;
   echo "   <h2 align=center>Sponsors for $lan[keyword]:</h2>\n"
       ."   <table border=0 align=center cellpadding=3 cellspacing=1 bgcolor=\"$bgcolor1\" width=\"60%\">\n"
       ."    <tr style=\"background-color: $bgcolor4; color: $textcolor1; font-weight: bold;\">\n"
           ."     <td width=\"75%\" align=center>Banner</td>\n"
           ."     <td width=\"25%\">Sponsor Name</td>\n"
       ."    </tr>\n";
   $bc = $bgcolor3;
$result = $db->sql_query("SELECT * FROM nukelan_sponsors_parties WHERE party_id='$pid'");
while ($row_sponsors = $db->sql_fetchrow($result)) {
        $row = $db->sql_fetchrow($db->sql_query("SELECT * FROM nukelan_sponsors_banners WHERE active='1' AND type='0' AND cid='$row_sponsors[sponsor_id]'"));
        $spons = $db->sql_query("SELECT * FROM nukelan_sponsors WHERE id='$row_sponsors[sponsor_id]'");
        $spon = $db->sql_fetchrow($spons);
        if (!is_admin($admin)) {
                $db->sql_query("UPDATE nukelan_sponsors_banners SET impmade=impmade+1 WHERE bid='$row[bid]'");
        }
        if ($bc == $bgcolor4) $bc = $bgcolor3;
        else $bc = $bgcolor4;
        echo "  <tr bgcolor=\"$bc\">\n";
        $imageurl = $row['imageurl'];
        $count_url = strlen($imageurl);
        $image_check = substr($imageurl, $count_url-3);
        if ($image_check == 'swf') {
        $size = getimagesize($imageurl);
        echo "<td onClick=\"location.href='lansponsors.php?op=click&amp;bid=$row[bid]'\">&nbsp;<br>&nbsp;<br>\n";
        echo "<object classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=4,0,2,0\" width=\"$size[0]\" height=\"$size[1]\">";
        echo "<param name=\"movie\" value=\"$imageurl\">";
        echo "<param name=quality value=high>";
        echo "<embed src=\"$imageurl\" quality=high pluginspage=\"http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash\" type=\"application/x-shockwave-flash\" width=\"100%\" height=\"100%\">";
        echo "</embed></object>";
        echo "&nbsp;<br>&nbsp;<br></td>\n";
        echo "<td><a href=\"lansponsors.php?op=click&amp;bid=$row[bid]\" target=\"_blank\">$spon[sponsor_name]</a>";
        echo "</td>\n";
        } else {
        echo "<td>\n";
        echo "<center><br><br><a href=\"lansponsors.php?op=click&amp;bid=$row[bid]\" target=\"_blank\"><img src=\"$row[imageurl]\" border=\"1\" alt=\"$row[alttext]\" title='$row[alttext]'></a><br><br></center>";
        echo "</td>\n";
        echo "<td><a href=\"lansponsors.php?op=click&amp;bid=$row[bid]\" target=\"_blank\">$spon[sponsor_name]</a>";
        echo "</td>\n";
        }
        echo "</tr>\n";

// check impressions total
if (($imptotal <= $impmade) AND ($imptotal != 0)) {
$db->sql_query("UPDATE nukelan_sponsors_banner SET active='0' WHERE bid='$row[bid]'");
}
}
echo "</table>";
CloseTable();
echo "<br>";
include ("footer.php");
?>
