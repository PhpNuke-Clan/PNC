<?php
// filename: seating_map.php (admin)

global $dbi, $aid, $db, $prefix;
$row = @$db->sql_fetchrow($db->sql_query("SELECT * FROM nukelan_map_temp WHERE aid='$aid'", $dbi));
//$room = @$db->sql_fetchrow($db->sql_query("SELECT * FROM nukelan_seat_rooms WHERE id=1"));
//$objects = @$db->sql_query("SELECT * FROM nukelan_seat_objects");
$room = @$db->sql_fetchrow($db->sql_query("SELECT * FROM nukelan_seat_rooms WHERE id='$row[room_id]'"));
$objects = @$db->sql_query("SELECT * FROM nukelan_seat_objects WHERE room_id='$row[room_id]'");

function scale($value, $dim = 5) { return $value * $dim; }
?>
<map name="seatmap">
<?php
while($thisobj = @$db->sql_fetchrow($objects)) {
        //$thisobj["numusers"] = $db->sql_query($db->sql_query("SELECT COUNT(*) FROM nukelan_signedup WHERE room_loc=" . $thisobj["id"]), 0);
        $thisobj["numusers"] = mysql_result($db->sql_query("SELECT COUNT(*) FROM nukelan_signedup WHERE room_loc=" . $thisobj["id"]), 0);
        $userList = "";
        if($thisobj["numusers"] > 0) {
                //$usersHere = $db->sql_query("SELECT * FROM users WHERE room_loc=" . $thisobj["id"] . " ORDER BY username");
                $usersHere = $db->sql_query("SELECT l.*, u.* FROM nukelan_signedup AS l LEFT JOIN nuke_users AS u ON (l.lan_uid=u.user_id) WHERE l.room_loc=" . $thisobj["id"] . " ORDER BY u.username");
                while($u = $db->sql_fetchrow($usersHere)) $userList .= "\n" . $u["username"];
        }
        $alt = $thisobj["name"];
        if($thisobj["type"] == "table") {

// Below is where each table gets it's hyperlink value
        } ?>
        <area shape="rect" href="<?php print $PHP_SELF ?>?op=add_seating&lanop=edit_object&editObject=<?php print $thisobj["id"] ?>&editRoom=<?php print $row['room_id']?>" coords="<?php print scale($thisobj["startx"]) . "," . scale($thisobj["starty"]) . "," . scale($thisobj["startx"] + $thisobj["width"]) . "," . scale($thisobj["starty"] + $thisobj["height"]); ?>" alt="<?php print $alt ?>">
<?php } ?>
<!-- <area shape="default" href="seating_new.php"> -->
<area shape="rect" coords="0,0,<?php print scale($room["width"]) ?>,<?php print scale($room["height"]) ?>">
</map>
