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
if (empty($_POST['cattitle2'])){
	echo ""._ENTERCATTITLE."<br>"._GOBACK."";
	CloseTable();
	include("footer.php");
}

if ($_FILES['upfile']['size'] == 0 AND empty($_POST['catimagelink2'])){
	echo ""._ENTERCATIMAGE."<br>"._GOBACK."";
	CloseTable();
	include("footer.php");
}

if ($_FILES['upfile']['size'] != 0){
	$catimage2 = upfile($catimagedir, "upfile");
}else{
	$catimage2 = $_POST['catimagelink2'];
}

$cattitle2 = addslashes(htmlentities(stripslashes($_POST['cattitle2']), ENT_QUOTES));
$catid2 = intval($_POST['catid2']);
$catdtl2 = addslashes(htmlentities(stripslashes($_POST['catdtl2']), ENT_QUOTES));
$catimage2 = htmlentities($catimage2, ENT_QUOTES);

$result = $db->sql_query("INSERT INTO ".$prefix."_mapcat VALUES (NULL, '$cattitle2', '$catdtl2', '$catid2', '$catimage2')");
if ($result){
	echo "$cattitle2 "._MAPCATADDED."<br>";
}else{
	echo "$cattitle2 "._MAPCATNOTADDED."<br>";
}
echo "<br> [ <a href='".$admin_file.".php?op=mapmain'>"._MAPADMIN."</a> ] "
	."</center>";
CloseTable();
include("footer.php");
?>