<?php
// filename: seating_image.php
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
require_once("config.php");
require_once("mainfile.php");
//$link = mysql_connect($dbhost, $dbuname, $dbpass)
 //       or die("Could not connect : " . mysql_error());
  //  print "Connected successfully";
 //   mysql_select_db($dbname) or die("Could not select database");
$ModName = basename( dirname( __FILE__ ) );
$page = getenv ("HTTP_HOST");
//@require_once("http://$page/modules/$ModName/include/_functions.php");

function scale($value, $dim = 5) { return $value * $dim; }
function grabcolors($hexval) {
        $hex = substr($hexval, 1);
        $ret["r"] = hexdec(substr($hex, 0, 2));
        $ret["g"] = hexdec(substr($hex, 2, 2));
        $ret["b"] = hexdec(substr($hex, 4, 2));
        return $ret;
}
global $db, $prefix;
$roomid = $_SERVER['QUERY_STRING'];
$roomidloc = strpos("".$_SERVER['QUERY_STRING']."", 'roomid=');
$roomid = substr("".$_SERVER['QUERY_STRING']."", $roomidloc+7);
$ModName = basename( dirname( __FILE__ ) );
//$room = @mysql_fetch_array(@mysql_query("SELECT * FROM nukelan_seat_rooms WHERE id='$roomid'"));
//$roomresult = $db->sql_query("SELECT * FROM nukelan_seat_rooms WHERE id='$roomid'");
//$room["width"] = mysql_result($roomresult,0,"width");
$room = $db->sql_fetchrow($db->sql_query("SELECT * FROM nukelan_seat_rooms WHERE id='$roomid'"));
$room["width"] = $room["width"];

//print mysql_result($roomresult,0,"width");
//$room["height"] = mysql_result($roomresult,0,"height");
//print mysql_result($roomresult,0,"height");
$room["height"] = $room["height"];
//$db->sql_free_result($room);

$objects = $db->sql_query("SELECT * FROM nukelan_seat_objects WHERE id > '0' AND room_id='$roomid'");
$img = imagecreate($room["width"] * 5, $room["height"] * 5)
        or die("cannot initialize new GD image stream.<br>administrator: please verify that the GD library is included in your PHP build.");
$seat["background"] = "#000000";
$seat["border"] = "#FFFFFF";
$seat["tablecolor"] = "#009900";
$seat["tableborder"] = "#00ff00";
$seat["voidcolor"] = "#000000";
$seat["voidborder"] = "#ffffff";
$seat["gridcolor"] = "#CCCCCC";
$seat["gridmidcolor"] = "#0000FF";
$seat["gridlitecolor"] = "#FFFFFF";
$seat["currentcolor"] = "#00ff00";

$c = grabcolors($seat["tablecolor"]);
$color["tablecolor"] = imagecolorallocate($img, $c["r"], $c["g"], $c["b"]);
$c = grabcolors($seat["tableborder"]);
$color["tableborder"] = imagecolorallocate($img, $c["r"], $c["g"], $c["b"]);
$c = grabcolors($seat["voidcolor"]);
$color["voidcolor"] = imagecolorallocate($img, $c["r"], $c["g"], $c["b"]);
$c = grabcolors($seat["voidborder"]);
$color["voidborder"] = imagecolorallocate($img, $c["r"], $c["g"], $c["b"]);
$c = grabcolors($seat["gridcolor"]);
$color["grid"] = imagecolorallocate($img, $c["r"], $c["g"], $c["b"]);
$c = grabcolors($seat["gridmidcolor"]);
$color["gridmid"] = imagecolorallocate($img, $c["r"], $c["g"], $c["b"]);
$c = grabcolors($seat["gridlitecolor"]);
$color["gridlite"] = imagecolorallocate($img, $c["r"], $c["g"], $c["b"]);
$c = grabcolors($seat["currentcolor"]);
$color["current"] = imagecolorallocate($img, $c["r"], $c["g"], $c["b"]);
$c = grabcolors($seat["background"]);
$color["bg"] = imagecolorallocate($img, $c["r"], $c["g"], $c["b"]);
$c = grabcolors($seat["border"]);
$color["border"] = imagecolorallocate($img, $c["r"], $c["g"], $c["b"]);
imagefill($img, 0, 0, $color["bg"]);
imagerectangle($img, 0, 0, scale($room["width"]) - 1, scale($room["height"]) - 1, $color["border"]);
while($thisobj = $db->sql_fetchrow($objects)) {

        imagefilledrectangle($img, scale($thisobj["startx"]), scale($thisobj["starty"]), scale($thisobj["startx"] + $thisobj["width"]), scale($thisobj["starty"] + $thisobj["height"]), ($_GET["c"] == $thisobj["id"] ? $color["tablecolor"] : ($thisobj["type"] == "table" ? $color["tablecolor"] : $color["tablecolor"])));
        imagerectangle($img, scale($thisobj["startx"]), scale($thisobj["starty"]), scale($thisobj["startx"] + $thisobj["width"]), scale($thisobj["starty"] + $thisobj["height"]), ($thisobj["type"] == "table" ? $color["tableborder"] : $color["tableborder"]));
}
if($_GET["grid"] == 1) {
        for($i = 0; $i < $room["width"]; $i++) {
                if($i % 10 == 0) imageline($img, scale($i), 0, scale($i), scale($room["height"]), $color["gridlite"]);
                elseif($i % 5 == 0) imageline($img, scale($i), 0, scale($i), scale($room["height"]), $color["gridmid"]);
                else imageline($img, scale($i), 0, scale($i), scale($room["height"]), $color["grid"]);
        }
        for($i = 0; $i < $room["height"]; $i++) {
                if($i % 10 == 0) imageline($img, 0, scale($i), scale($room["width"]), scale($i), $color["gridlite"]);
                elseif($i % 5 == 0) imageline($img, 0, scale($i), scale($room["width"]), scale($i), $color["gridmid"]);
                else imageline($img, 0, scale($i), scale($room["width"]), scale($i), $color["grid"]);
        }
}
if (imagetypes() & IMG_GIF) {
    header ("Content-type: image/gif");
    imagegif ($img);
}
elseif(imagetypes() & IMG_PNG) {
        header("Content-type: image/png");
        imagepng($img);
}
elseif (imagetypes() & IMG_JPG) {
        header("Content-type: image/jpeg");
        imagejpeg($img, "", 100);
}
elseif(imagetypes() & IMG_WBMP) {
        header("Content-type: image/vnd.wap.wbmp");
        imagebmp($img);
}
else die("No image support in this PHP server");
//imagepng($img); // change to gif !
//imagedestroy($img);

?>
