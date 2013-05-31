<?php
//$index=1;
define('INDEX_FILE', true);
global $prefix, $db, $admin_file;
include("header.php");
$module_name = basename(dirname(__FILE__));
title("Submit XFire");

?>
<meta http-equiv="REFRESH" content="3;url=modules.php?name=XFire">
<?php
OpenTable();
echo "<center>Processing...<br><br><b>Thank You</b><br>Your XFire has been posted.</center>";
CloseTable();

$Name=$_POST['Name'];
$XFire=$_POST['XFire'];

$query = "INSERT INTO ".$prefix."_xfire VALUES ('','$Name','$XFire')";
mysql_query($query);

include("by.php");
include("footer.php");
?>