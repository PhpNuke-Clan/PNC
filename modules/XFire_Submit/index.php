<?
if(!defined('MODULE_FILE')) { die("Illegal Access Detected!!!"); } 
//$index=1;
define('INDEX_FILE', true);
global $prefix, $db, $admin_file;
include("header.php");
$module_name = basename(dirname(__FILE__));
title("Submit XFire");

OpenTable();

echo "<center>";

?>
Submit Your XFire
<form action="modules.php?name=<?echo "$module_name";?>&file=submit" method="post">
Name: <input type="text" maxlength=25 name="Name" value="Your Name">
XFire:  <input type="text" maxlength=25 name="XFire" value="XFire Name"><br>
<input type="Submit"  value="Submit">
</form>
<?

echo "</center>";

CloseTable();

include("by.php");
include("footer.php");
?>
