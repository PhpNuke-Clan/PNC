<?
if ( !defined('ADMIN_FILE') )
{
        die ("Access Denied");
}
//if (!eregi("admin.php", $_SERVER['SCRIPT_NAME'])) { die ("Access Denied"); }

global $prefix, $db, $admin_file;
$aid = substr("$aid", 0,25);
$row = $db->sql_fetchrow($db->sql_query("SELECT title, admins FROM ".$prefix."_modules WHERE title='XFire'"));
$row2 = $db->sql_fetchrow($db->sql_query("SELECT name, radminsuper FROM ".$prefix."_authors WHERE aid='$aid'"));
$admins = explode(",", $row['admins']);
$auth_user = 0;
for ($i=0; $i < sizeof($admins); $i++) {
    if ($row2['name'] == "$admins[$i]" AND $row['admins'] != "") {
        $auth_user = 1; 
    }
}

if ($row2['radminsuper'] == 1 || $auth_user == 1) {





require_once("mainfile.php");
include("header.php");
//$index=1;
global $prefix, $db, $admin_file;
//define('INDEX_FILE', true);
title("XFire Admin");
OpenTable();
echo"<center><a href=\"".$admin_file.".php\">Back to Main Administration Area</a></center>";
CloseTable();

OpenTable();
$cfg = $db->sql_query("SELECT * from ".$prefix."_xfirecfg");
while($r=$db->sql_fetchrow($cfg))
{
   $perpage=$r["Perpage"];
   $style=$r["Style"];
   $size=$r["Size"];
   $sort=$r["Sort"];
   $id=$r["id"];


echo "<form action=\"".$admin_file.".php?op=XFireOptions&cmd=change&id=$id\" method=post>
<table align=center width=98%>
<td align=center valign=top><b>Theme</b>
<select name='Style'>
<option value='$style' ></option>
<option value='bg' >XFire</option>
<option value='os' >Fantasy</option>
<option value='sf' >Sci-Fi</option>
<option value='co' >Combat</option>
</select>
</td>
<td align=center valign=top><b>Size</b>
<select name='Size'>
<option value=$size ></option>
<option value=0 >Classic</option>
<option value=1 >Compact</option>
<option value=2 >Short & Wide</option>
<option value=3 >Tiny</option>
</select>
</td>
<td align=center valign=top><b>Sort</b>
<select name='Sort'>
<option value='$sort' ></option>
<option value='id' >ID</option>
<option value='Name' >Name</option>
<option value='XFire' >XFire</option>
</select><br><br>
</td>
<td align=center valign=top><b>Perpage</b>
<select name='Perpage'>
<option value='$perpage' ></option>
<option value='5' >5</option>
<option value='10' >10</option>
<option value='15' >15</option>
<option value='25' >25</option>
<option value='50' >50</option>
<option value='100' >100</option>
</select>
</td>
<td align=center valign=bottom>
<input type=Submit value=Change>
</td></table>
</form>";
}
CloseTable();


if(!isset($start)) $start = 0;

$query = "SELECT count(*) as count FROM ".$prefix."_xfire";
$result = $db->sql_query($query);
$row = $db->sql_fetchrow($result);
$numrows = $row['count'];

if($start > 0){
echo "<center>";
echo "<-<a href=\"" . $PHP_SELF . "?name=XFire_Admin&start=" . ($start - $perpage) .
"\">Prev</a>";
echo " - ";
} else {
echo "<center>";
echo "Prev";
echo " - ";
}

if($numrows > ($start + $perpage)){
echo "<a href=\"" . $PHP_SELF . "?name=XFire_Admin&start=" . ($start + $perpage) .
"\">Next</a>->";
echo "</center>";
} else {
echo "Next";
echo "</center>";
}

OpenTable();

$sql = "SELECT id, Name, XFire FROM ".$prefix."_xfire ORDER BY $sort LIMIT " . $start . ", $perpage";
$result = $db->sql_query($sql);
$num=$db->sql_numrows($result);

$i=0;
while ($i < $num) {
$Name=mysql_result($result,$i,"Name");
$XFire=mysql_result($result,$i,"XFire");
$id=mysql_result($result,$i,"id");

echo "<form action=\"".$admin_file.".php?op=XFireUpdate&cmd=update&id=$id\" method=post>
<table align=center>
<td align=left valign=top>
<b>$id</b>
</td>
<td align=center valign=top>
Name: <input type=text name=Name value=$Name>
</td>
<td align=center valign=top>
XFire: <input type=text name=XFire value=$XFire>
</td>
<td align=center valign=top>
<img src=http://miniprofile.xfire.com/bg/$style/type/3/$XFire.png border=0>
</td>
<td align=center valign=bottom>
<input type=Submit value=Update><br>
<a href=".$admin_file.".php?op=XFireDelete&cmd=delete&id=$id>Delete</a>
</td></table>
</form>";

$i++;
}

CloseTable();

$query = "SELECT count(*) as count FROM ".$prefix."_xfire";
$result = $db->sql_query($query);
$row = $db->sql_fetchrow($result);
$numrows = $row['count'];

if($start > 0){
echo "<center>";
echo "<-<a href=\"" . $PHP_SELF . "?name=XFire_Admin&start=" . ($start - $perpage) .
"\">Prev</a>";
echo " - ";
} else {
echo "<center>";
echo "Prev";
echo " - ";
}

if($numrows > ($start + $perpage)){
echo "<a href=\"" . $PHP_SELF . "?name=XFire_Admin&start=" . ($start + $perpage) .
"\">Next</a>->";
echo "</center>";
} else {
echo "Next";
echo "</center>";
}

include("bug.php");
include("footer.php");
} else {
    echo "Access Denied";
}
?>
