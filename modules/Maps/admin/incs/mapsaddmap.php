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

include("header.php");
OpenTable();
echo "<center>";
if (empty($_POST['maptitle2'])){
	echo _NOMAPTITLE."<br>"._GOBACK."";
	CloseTable();
	include("footer.php");
}

if ($_FILES['upfile']['size'] == 0 AND empty($_POST['mapimagelink'])){
	echo _ENTERMAPIMAGE."<br>"._GOBACK."";
	CloseTable();
	include("footer.php");
}

if ($_FILES['upfile2']['size'] == 0 AND empty($_POST['mapfilelink'])){
	echo _ENTERMAPFILE."<br>"._GOBACK."";
	CloseTable();
	include("footer.php");
}

if ($_FILES['upfile']['size'] != 0){
	$mapimage2 = upfile($mapimagedir, "upfile");
	include ("modules/$module_name/admin/incs/thumb.php");
	thumb_img($mapimage2, "");
}else{
	$mapimage2 = $_POST['mapimagelink'];
}
if ($_FILES['upfile2']['size'] != 0){
	$mapfile2 = upfile($mapfiledir, "upfile2");
	$filesize = filesize($mapfiledir."/".$mapfile2);
}else{
	$mapfile2 = $_POST['mapfilelink'];
	if (file_exists($mapfiledir."/".$mapfile2)){
		$filesize = filesize($mapfiledir."/".$mapfile2);
	}else{
		$filesize = 0;
	}
}

$mapcat2 = intval($_POST['mapcat2']);
$maptitle2 = addslashes(htmlentities(stripslashes($_POST['maptitle2']), ENT_QUOTES));
$mapdtl2 = addslashes(htmlentities(stripslashes($_POST['mapdtl2']), ENT_QUOTES));
$mapauth2 = addslashes(htmlentities(stripslashes($_POST['mapauth2']), ENT_QUOTES));
$mapauthe2 = addslashes(htmlentities(stripslashes($_POST['mapauthe2']), ENT_QUOTES));
$maprecp2 = addslashes(htmlentities(stripslashes($_POST['maprecp2']), ENT_QUOTES));

$result = $db->sql_query("INSERT INTO ".$prefix."_mapmap VALUES (NULL, '$mapcat2', '$maptitle2', '$mapdtl2', '$mapauth2', '$mapauthe2', '$maprecp2', '$mapimage2', '$mapfile2', '0', '$filesize')");

if($result){
	echo "<strong>$maptitle2</strong> "._MAPADDEDTODB."<br>";
}else{
	echo "<strong>$maptitle2</strong> "._MAPNOTADDEDTODB."<br>";
}
echo "<br> [ <a href='admin.php?op=mapmain'>"._MAPADMIN."</a> ] </center>";
CloseTable();
include("footer.php");
?>