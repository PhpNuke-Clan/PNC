<?php

/***************************************/
/* Maps Manager by gotcha  version 2.0 */
/* Copyright 2006 http://nukecoder.com */
/* You MAY NOT copy in whole or in part*/
/* or redistribute map manager without */
/* written consent from the author.    */
/* Contact and support can be found at */
/* http://nukecoder.com                */
/***************************************/
global $module_name;
include("header.php");
OpenTable();
echo "<center>";

$rid = intval($_POST['rid']);
$review = addslashes(htmlentities(stripslashes($_POST['review']), ENT_QUOTES));

$result = $db->sql_query("UPDATE ".$user_prefix."_mapreviews SET review='$review', rapprove='1' WHERE rid='$rid'");
if ($result){
	echo ""._REVAPPED."<br><META http-equiv='refresh' content='0;url=$admin_file.php?op=mapmain'><br>";
}else{
	echo "$rid $review Not OK!<br>";// needs language def
}
echo "<br> [ <a href='".$admin_file.".php?op=mapmain'>"._MAPADMIN."</a> ] </center>";
CloseTable();
include("footer.php");
?>