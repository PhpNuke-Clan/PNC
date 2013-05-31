<?php
if(!defined('MODULE_FILE')) { die("Illegal Access Detected!!!"); }
//$index=1;
define('INDEX_FILE', true);
include("header.php");
global $prefix, $db, $admin_file;
$module_name = basename(dirname(__FILE__));
title("$module_name");

$cfg = $db->sql_query("SELECT * from ".$prefix."_xfirecfg");
while($r=$db->sql_fetchrow($cfg))
{
   $perpage=$r["Perpage"];
   $style=$r["Style"];
   $size=$r["Size"];
   $sort=$r["Sort"];
   $id=$r["id"];

if(!isset($start)) $start = 0;

$query = "SELECT count(*) as count FROM ".$prefix."_xfire";
$result = $db->sql_query($query);
$row = $db->sql_fetchrow($result);
$numrows = $row['count'];

if($start > 0){
echo "<center>";
echo "<-<a href=\"" . $PHP_SELF . "?name=$module_name&start=" . ($start - $perpage) .
"\">Prev</a>";
echo " - ";
} else {
echo "<center>";
echo "Prev";
echo " - ";
}

if($numrows > ($start + $perpage)){
echo "<a href=\"" . $PHP_SELF . "?name=$module_name&start=" . ($start + $perpage) .
"\">Next</a>->";
echo "</center>";
} else {
echo "Next";
echo "</center>";
}

OpenTable();

$sql = "SELECT Name, XFire FROM ".$prefix."_xfire ORDER BY $sort LIMIT " . $start . ", $perpage";
$result = $db->sql_query($sql);
$num=$db->sql_numrows($result);

$i=0;
while ($i < $num) {

$Name=mysql_result($result,$i,"Name");
$XFire=mysql_result($result,$i,"XFire");

echo "<center><b>$Name</b><br><a href=http://profile.xfire.com/$XFire target=_blank><img src=http://miniprofile.xfire.com/bg/$style/type/$size/$XFire.png border=0></a><br><br>";

$i++;
}
CloseTable();

$query = "SELECT count(*) as count FROM xfire";
$result = $db->sql_query($query);
$row = $db->sql_fetchrow($result);
$numrows = $row['count'];

if($start > 0){
echo "<center>";
echo "<-<a href=\"" . $PHP_SELF . "?name=$module_name&start=" . ($start - $perpage) .
"\">Prev</a>";
echo " - ";
} else {
echo "<center>";
echo "Prev";
echo " - ";
}

if($numrows > ($start + $perpage)){
echo "<a href=\"" . $PHP_SELF . "?name=$module_name&start=" . ($start + $perpage) .
"\">Next</a>->";
echo "</center>";
} else {
echo "Next";
echo "</center>";
}

 }

echo "<br><center><hr width=250><a href=modules.php?name=XFire_Submit>Click Here to Submit your XFire</a><hr width=250></center>";

include("by.php");
include("footer.php");
?>