<?php
// filename: seating_chart.php
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
     die("You can't access this file directly...");
}
require_once("mainfile.php");
global $db, $uname, $prefix, $uid;
$ModName = basename( dirname( __FILE__ ) );
define('NUKELAN_FILE', true);

get_lang($ModName);
$moddir = "modules/$ModName/";

$index = $lanconfig['index'];
include ("header.php");
include ("modules/$ModName/include/_universal.php");

global $dbi, $uid, $db;   //$db->sql_fetchfield

        $user = base64_decode($user);
        $user = explode(":", $user);
        $uid = "$user[0]";
        $uname = "$user[1]";
        $pwd = "$user[2]";

OpenTable();
$lan = @mysql_fetch_array(mysql_query("SELECT * FROM nukelan_parties WHERE party_id='$pid'"));
//echo"$lan[party_id]";
        echo "<center> :: <a href=\"modules.php?op=modload&name=$ModName&amp;file=index&amp;lanop=show_party&amp;party_id=$lan[party_id]\">"._NLEVENTINFO."</a> :";
        // if tournaments for this LAN
        if (mysql_num_rows(mysql_query("SELECT * FROM nukelan_tournaments WHERE config_id='$lan[party_id]'"))) {
        echo ": <a href=\"modules.php?op=modload&name=$ModName&amp;file=tourneys&amp;lanop=show_list&amp;pid=$lan[party_id]\">"._NLTOURNAMENTS."</a> :";
        }
        // if Prizes for this LAN
        if (mysql_num_rows(mysql_query("SELECT * FROM nukelan_prizes WHERE config_id='$lan[party_id]'"))) {
        echo ": <a href=\"modules.php?op=modload&name=$ModName&amp;file=prizes&amp;lanop=show_prizes&amp;party=$lan[party_id]\">"._NLPRIZES."</a> :";
        }
        // if lodgin for this LAN
        if (mysql_num_rows(mysql_query("SELECT * FROM nukelan_lodging WHERE config_id='$lan[party_id]'"))) {
        echo ": <a href=\"modules.php?op=modload&name=$ModName&amp;file=lodging&amp;lanop=show_lodges&amp;pid=$lan[party_id]\">"._NLLODGING."</a> :";
        }
        // if Seating Chart for this LAN
        if ($lan['schart'] > 0) {
        echo ": <a href=\"modules.php?op=modload&name=$ModName&amp;file=seating_chart&amp;seat=showChart&amp;pid=$lan[party_id]\">"._NLSEATINGCHART."</a> :";
        }
        // if LAN has sponsors
        if (mysql_num_rows(mysql_query("SELECT * FROM nukelan_sponsors_parties WHERE party_id='$lan[party_id]'"))) {
        echo ": <a href=\"modules.php?op=modload&name=$ModName&amp;file=sponsors&amp;pid=$lan[party_id]\">"._NLPARTYSPONSORS."</a> :";
        }
        echo ": <a href=\"modules.php?op=modload&name=$ModName&amp;file=profile&amp;pid=$lan[party_id]\">"._NLPROFILE."</a>  ::</center>";
CloseTable();
echo "<br>";
OpenTable();

function object_exists($tableID) {
        if(@mysql_num_rows(@mysql_query("SELECT * FROM nukelan_seat_objects WHERE id=" . $tableID))) return 1;
        else return 0;
}

$row = @mysql_fetch_array(@mysql_query("SELECT * FROM nukelan_signedup WHERE lan_uid='" . $_COOKIE["userid"] . "' AND lan_id='$pid'"));
$party = @mysql_fetch_array(@mysql_query("SELECT * FROM nukelan_parties WHERE party_id='$pid'"));
$roomid = "$party[schart]";

function showseats($pid,$row,$party,$roomid) {

global $uid, $ModName, $db;
$colors["background"] = "#000000";
$colors["primary"] = "#00ff00";
$colors["secondary"] = "#009900";
$colors["border"] = "#00ff00";
$colors["cell_title"] = "#111111";
$colors["cell_background"] = "#000000";
$colors["cell_alternate"] = "#000000";
$colors["text"] = "#ffffff";
$colors["blended_text"] = "#444444";
$colors["graphs"] = $colors["primary"];
$uresult = mysql_query("SELECT * FROM nukelan_signedup WHERE lan_uid='$uid' AND lan_id='$pid'");
$urow = mysql_fetch_array($uresult);
$tresult = mysql_query("SELECT * FROM nukelan_seat_objects WHERE id='$urow[room_loc]' AND room_id='$roomid'");
$useat = mysql_fetch_array($tresult);
if(@mysql_num_rows(@mysql_query("SELECT * FROM nukelan_seat_rooms WHERE id='$roomid'"))) {

                echo "<b>"._NLCLICKBELOW." "._NLPUTMOUSE."</b><br>";
                if ($useat) echo "<b>"._NLHAVESEAT."  <font size=2 color=green>$useat[name]</font></b><br>";
                else echo "<b>"._NLNOSEATRESERVED."</b><br>";

 ?>
                <table border="0" cellpadding="1" cellspacing="0" width="100%">
                        <tr><td align="center" colspan="2" bgcolor="<?=$colors["cell_title"]?>"><?php
                        //if($_POST["act"] != "admindeleteallrooms") { ?>
                                <img src="modules.php?name=<? echo "$ModName"; ?>&file=seating_image&c=<?php print ($_GET["c"] ? $_GET["c"] : "0") ?>&grid=<?php print ($_GET["grid"] == 1 ? "1" : "0") ?>&roomid=<?php print "$roomid" ?>" name="seat" onClick="clicky((window.event.x - findPosX(document.seat)) / 5, (window.event.y - findPosY(document.seat)) / 5)" onMouseOver="coords((window.event.x - findPosX(document.seat)) / 5, (window.event.y - findPosY(document.seat)) / 5)" usemap="#seatmap" border="0" ismap GALLERYIMG="no">
                                <?php require_once("modules/Nukelan/seating_map.php");
                        //}
                        ?>
                        </td></tr><?php

                        //if($_POST["act"] != "admindeleteallrooms"&&current_security_level()==1) { ?>
<?php           echo "<tr><td><br><b>"._NLCLICKABOVE."  "._NLPUTMOUSE."</b><br><br></td></tr>";
                                //}


                        if($_GET["c"] && object_exists($_GET["c"]) && $_POST["act"] != "admindeleteallrooms") {
                                $thisobj = @mysql_fetch_array(mysql_query("SELECT * FROM nukelan_seat_objects WHERE id=" . $_GET["c"]));
                                $numUsersHere = @mysql_result(mysql_query("SELECT COUNT(*) FROM nukelan_signedup WHERE lan_id='$pid' AND room_loc=" . $thisobj["id"]), 0); ?>
                                <tr><td align="left" valign="top">
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                        <tr><td colspan="2" bgcolor="<?=$colors["cell_title"]?>">&nbsp;<font color="<?=$colors["primary"]?>"><b>current table:  <?php print $thisobj['name'] ?></b></font></td></tr>
                                        <tr>
                                        <td valign="top" align="left" width="50%">
                                                <table border="0" cellpadding="0" cellspacing="0"><?php
                                                if($thisobj["type"] == "table") { ?>
                                                        <tr><td><b>&nbsp;users here:</b>&nbsp;<?php print $numUsersHere ?>/<?php print $thisobj["capacity"] ?></td></tr>
                                                        <tr><td><?php
                                                        if($numUsersHere > 0) {
                                                                //$usersHere = mysql_query("SELECT * FROM nukelan_signedup WHERE lan_id='$pid' AND room_loc=" . $thisobj["id"]);
                                                                $usersHere = mysql_query("SELECT l.*, u.* FROM nuke_users AS l LEFT JOIN nukelan_signedup AS u ON (l.user_id=u.lan_uid) WHERE u.lan_id='$pid' AND room_loc=" . $thisobj["id"] . " ORDER BY l.username");
                                                                while($userHere = @mysql_fetch_array($usersHere)) {
                                                                        ?>&nbsp;&nbsp;<?php print $userHere["username"] ?><br><?php
                                                                }
                                                        }
                                                        else {
                                                                echo "&nbsp;&nbsp;"._NLSMALLNONE."";
                                                        } ?></td></tr><?php
                                                } else {
                                                        echo "<tr><td>&nbsp;&nbsp;"._NLNOTATABLE."</td></tr>";
                                                } ?>
                                                </table>
                                        </td>
                                        <td width="50%" valign="middle">
                                        <?php
                                        if ($party[active]) {
                                        echo "<font color=red><b>"._NLSORRYSHUTDOWN."</b></font>";
                                        } else {
                                        ShowButtons($pid,$thisobj);
                                        }
                                        ?>
                                        </td>
                                        </tr>
                                        </table>
                                </td></tr>

                        <?php
                        } // end if(get[c])
        } else {
                echo ""._NLSORRYNOCHART."";
        }
        }
function ShowButtons($pid,$thisobj){
global $user, $uid, $ModName;
$sitting = mysql_num_rows(mysql_query("SELECT * FROM nukelan_signedup WHERE lan_uid='$uid' AND lan_id='$pid' AND room_loc >= '1'"));
          echo "   <table border=0>\n"
          ."    <tr>\n";
     if ($thisobj >= 1)
                   echo "<td>\n"
                   ."      <form action=\"modules.php\" method=\"post\" style=\"margin: 0;\">\n"
                           ."      <input type=hidden name=op value=modload>\n"
               ."      <input type=hidden name=name value=$ModName>\n"
               ."      <input type=hidden name=file value=seating_chart>\n"
               ."      <input type=hidden name=lanop value=userSit>\n"
                           ."      <input type=hidden name=uid value=".$uid.">\n"
                           ."      <input type=hidden name=rloc value=".$thisobj['id'].">\n"
                           ."      <input type=hidden name=pid value='$pid'>\n"
               ."      <input type=submit value=\""._NLSITDOWNHERE."\" style=\"width: 120px;\">\n"
               ."      </form>\n"
               ."     </td>\n";
        if ($sitting==1)
                    echo "<td>\n"
                           ."<form action=\"modules.php\" method=\"post\" style=\"margin: 0;\">\n"
                           ."      <input type=hidden name=op value=modload>\n"
               ."      <input type=hidden name=name value=$ModName>\n"
               ."      <input type=hidden name=file value=seating_chart>\n"
               ."      <input type=hidden name=lanop value=userStand>\n"
                           ."      <input type=hidden name=uid value=".$uid.">\n"
                           ."      <input type=hidden name=pid value='$pid'>\n"
               ."      <input type=submit value=\""._NLSTANDUP."\" style=\"width: 120px;\">\n"
               ."      </form>\n"
               ."     </td>\n";

        echo "</tr></table>\n";
}
function sitting($pid,$uid,$rloc,$action) {
if ($uid <= 1) {echo"<center>"._NLREGISTERFORSEAT."<br><FORM><INPUT type=\"button\" value=\"Click here to go back\" onClick=\"history.back()\"></FORM></center>";
    CloseTable();
    include ("footer.php");

   }
else{
        $result = mysql_query("SELECT * FROM nukelan_seat_objects WHERE id='$rloc'");
        $row = mysql_fetch_array($result);
        $num_here = mysql_num_rows(mysql_query("SELECT * FROM nukelan_signedup WHERE lan_id='$pid' AND room_loc='$rloc'"));

        switch ($action) {
        case 'stand':
        if (!mysql_query("UPDATE nukelan_signedup SET room_loc=NULL WHERE lan_uid='$uid' AND lan_id='$pid'")) echo "font size=2 color=red><b>"._NLCANNOTSTANDUP."</b></font>";
        //else echo"<h2>You do not have a reserved seat</h2>";
        break;
        default:
        if ($num_here >= $row['capacity']) echo "<font size=2 color=red><b>"._NLTABLEFULL."</b></font>";
        elseif (!mysql_query("UPDATE nukelan_signedup SET room_loc='$rloc' WHERE lan_uid='$uid' AND lan_id='$pid'")) echo "<font size=2 color=red><b>"._NLCANNOTSITHERE."</b></font>";
        //else echo "<h2>You have reserved a seat at table: $row[name]</h2>";
        break;
        }
   }
}

  switch ($lanop) {
    case 'userSit':
          sitting($pid,$uid,$rloc, '');
          mysql_query("DELETE FROM nukelan_map_temp WHERE uid='$uid'");
         mysql_query("INSERT INTO nukelan_map_temp SET uid='$uid', room_id='$roomid'");
          showseats($pid,$row,$party,$roomid);
        break;
        case 'userStand':
          sitting($pid,$uid,$rloc,'stand');
          mysql_query("DELETE FROM nukelan_map_temp WHERE uid='$uid'");
         mysql_query("INSERT INTO nukelan_map_temp SET uid='$uid', room_id='$roomid'");
          showseats($pid,$row,$party,$roomid);
        break;
    case 'showChart':
         mysql_query("DELETE FROM nukelan_map_temp WHERE uid='$uid'");
         mysql_query("INSERT INTO nukelan_map_temp SET uid='$uid', room_id='$roomid'");
     showseats($pid,$row,$party,$roomid);
         break;
  default:
     mysql_query("DELETE FROM nukelan_map_temp WHERE uid='$uid'");
         mysql_query("INSERT INTO nukelan_map_temp SET uid='$uid', room_id='$roomid'");
     showseats($pid,$row,$party,$roomid);
     break;
   }
   echo "</table>";

CloseTable();
include ("footer.php");
?>
