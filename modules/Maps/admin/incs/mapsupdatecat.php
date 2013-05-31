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

$catide = intval($_POST['catide']);
$catid = intval($_POST['catid']);
$mainid = intval($_POST['mainid']);
$cattitlee = addslashes(htmlentities(stripslashes($_POST['cattitlee']), ENT_QUOTES));
$catdtle = addslashes(htmlentities(stripslashes($_POST['catdtle']), ENT_QUOTES));

if ($catide != $catid){
	$mainid = $catide;
}

if ($_FILES['upfile']['size'] == 0 AND empty($_POST['catimagelinke'])){
	echo _ENTERCATIMAGE."<br>"._GOBACK;
	CloseTable();
	include("footer.php");
	die();
}
if ($_FILES['upfile']['size'] != 0){
	$catimagee = upfile($catimagedir, "upfile");
} else {
	$catimagee = $_POST['catimagelinke'];
}

if ($_POST['delimg'] && file_exists($catimagedir."/".$_POST['oldimg'])){
	if (@unlink($catimagedir."/".$_POST['oldimg'])){
		echo _IMAGEDELETED." <strong>".$_POST['oldimg']."</strong><br>";
	}
}

$catimagee = htmlentities($catimagee, ENT_QUOTES);

$result = $db->sql_query("UPDATE ".$prefix."_mapcat SET title='$cattitlee', details='$catdtle', mainid='$mainid', image='$catimagee' WHERE id='$catid'");

if ($result){
	echo $cattitlee." "._MAPCATUPTD."<br>";
}else{
	echo $cattitlee." "._MAPCATNOTUPTD."<br>";
}
echo "<br> [ <a href='".$admin_file.".php?op=mapmain'>"._MAPADMIN."</a> ] "
	."</center>";
CloseTable();
include("footer.php");
?>