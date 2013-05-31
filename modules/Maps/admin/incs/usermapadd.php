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
$rcat = intval($_POST['rcat']);
$rtitle = addslashes(htmlentities(stripslashes($_POST['rtitle']), ENT_QUOTES));
$rdetails = addslashes(htmlentities(stripslashes($_POST['rdetails']), ENT_QUOTES));
$rauthor = addslashes(htmlentities(stripslashes($_POST['rauthor']), ENT_QUOTES));
$rauthore = addslashes(htmlentities(stripslashes($_POST['rauthore']), ENT_QUOTES));
$rrecplay = intval($_POST['rrecplay']);

$rimage = htmlentities($_POST['rimage'], ENT_QUOTES);
$rmapfile = htmlentities($_POST['rmapfile'], ENT_QUOTES);

if (!isurl($rimage)){
	@rename($tempdir."/".$rimage, $mapimagedir."/".$rimage);
	include ("modules/$module_name/admin/incs/thumb.php");
	thumb_img($rimage, "");
}else{
	if ($_POST['copyimage']){
		$rimagec = substr(strrchr("$rimage", '/'), 1);
		@copy($rimage, $mapimagedir."/".$rimagec);
		$rimage = "$rimagec";
		include ("modules/$module_name/admin/incs/thumb.php");
		thumb_img($rimage, "");
	}
}

if (!isurl($rmapfile)){
	@rename($tempdir."/".$rmapfile, $mapfiledir."/".$rmapfile);
	$filesize = filesize($mapfiledir."/".$rmapfile);
}else{
	if ($_POST['copyfile']){
		$rmapfilec = substr(strrchr("$rmapfile", '/'), 1);
		@copy($rmapfile, $mapfiledir."/".$rmapfilec);
		$rmapfile = "$rmapfilec";
		$filesize = filesize($mapfiledir."/".$rmapfile);
	}
}

$result = $db->sql_query("INSERT INTO ".$prefix."_mapmap VALUES (NULL, '$rcat', '$rtitle', '$rdetails', '$rauthor', '$rauthore', '$rrecplay', '$rimage', '$rmapfile', '0', '$filesize')");
if ($result){
	echo "$rtitle "._MAPADDEDTODB."<br>";
	$db->sql_query("DELETE FROM ".$prefix."_maptemp where rid='$rid'");
}else{
	echo "$rtitle "._MAPNOTADDEDTODB."<br>";
}
echo "<br> [ <a href='".$admin_file.".php?op=mapmain'>"._MAPADMIN."</a> ] </center>";
CloseTable();
include("footer.php");
?>