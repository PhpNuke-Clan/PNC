<?php
// filename: seating_map.php (client)
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
        die ("You can't access this file directly...");
}

$ModName = basename( dirname( __FILE__ ) );
require_once("mainfile.php");
        global $db, $prefix, $user_prefix, $uname, $user, $uid;	   //$db->sql_fetchfield


// 
$row = $db->sql_fetchrow($db->sql_query("SELECT * FROM nukelan_map_temp WHERE uid='$uid'"));
$roomid1 = $row["room_id"];
//echo " $uid <br>$roomid1 <br>$db<br>$uname , $uid , $pwd";
$room = $db->sql_fetchrow($db->sql_query("SELECT * FROM nukelan_seat_rooms WHERE id='$roomid1'"));
$objects = $db->sql_query("SELECT * FROM nukelan_seat_objects WHERE room_id='$roomid1'");
function scale($value, $dim = 5) { return $value * $dim; }
?>
<map name="seatmap">
<?php
while($thisobj = $db->sql_fetchrow($objects)) {
        $numusersobj = $db->sql_fetchrow($db->sql_query("SELECT COUNT(*) FROM nukelan_signedup WHERE (lan_id='$pid' AND room_loc=" . $thisobj['id'].") "), 0);
        $thisobj["numusers"] = $numusersobj; 
$userList = "";
        if($thisobj["numusers"] > 0) {
                $usersHere = $db->sql_query("SELECT l.*, u.* FROM nuke_users AS l LEFT JOIN nukelan_signedup AS u ON (l.user_id=u.lan_uid) WHERE (u.room_loc=" . $thisobj["id"] . " AND lan_id='$pid') ORDER BY l.username", $dbi);
                while($u = $db->sql_fetchrow($usersHere)) $userList .= "\n" . $u["username"];
        }
        $alt = $thisobj["name"];
        if($thisobj["type"] == "table") {
                if($thisobj["numusers"] > 0) {
                        $alt .= $userList;
                }
                else $alt .= "\n"._NLNOBODYHERE."";
// Below is where each table gets it's hyperlink value
        } ?>
        <area shape="rect" href="<?php print $PHP_SELF ?>?name=<? echo"$ModName";?>&file=seating_chart&c=<?php print $thisobj["id"] ?>&grid=<?php print ($_GET["grid"] == 1 ? "1" : "0") ?>&pid=<?php print "$pid" ?>" coords="<?php print scale($thisobj["startx"]) . "," . scale($thisobj["starty"]) . "," . scale($thisobj["startx"] + $thisobj["width"]) . "," . scale($thisobj["starty"] + $thisobj["height"]); ?>" alt="<?php print $alt ?>">
<?php } ?>
<!-- <area shape="default" href="seating_new.php"> -->
<area shape="rect" coords="0,0,<?php print scale($room["width"]) ?>,<?php print scale($room["height"]) ?>">
</map>
