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
$mapid = intval($_POST['mapid']);

function dir_del($target) {
	
	$exceptions = array(".", "..");
	$sourcedir = opendir($target);
	while(false !== ($filename = readdir($sourcedir))) {
		if(!in_array($filename, $exceptions)) {
			if(is_dir($target."/".$filename)) {
				dir_del($target."/".$filename);
			} else if(is_file($target."/".$filename)) {
				unlink($target."/".$filename);
			}
		}
	}
	closedir($sourcedir);
	if(rmdir($target)) {
		return true; 
	} else {
		return false;
	}
}

if ($_POST['delete']){
	$result1 = $db->sql_query("SELECT image, mapfile FROM ".$prefix."_mapmap WHERE mapid='$mapid'");
	$row = $db->sql_fetchrow($result1);
	$mid = $row['id'];
	$image = $row['image'];
	$mapfile = $row['mapfile'];		
	if ($_POST['delmapimg'] && !isurl($image)){
		if (@unlink($mapimagedir."/thumb/".$image) && @unlink($mapimagedir."/".$image)){
			echo _IMAGEDELETED." <strong>$image</strong><br>";
		}
	}
	if ($_POST['delmapfile'] && !isurl($mapfile)){
		if (@unlink($mapfiledir."/".$mapfile)){
			echo _FILEDELETED." <strong>$mapfile</strong><br>";
		}
	}
	if ($_POST['delss']){
		$ssdir = "modules/$module_name/ss/$mapid";
		//if (is_dir("$ssdir/$mapid")){
		dir_del($ssdir);
	}	
	$result2 = $db->sql_query("DELETE FROM ".$prefix."_mapmap WHERE mapid='".$mapid."'");
	if ($result2){
		echo _MAPDELETED."<br><br> [ <a href='".$admin_file.".php?op=mapmain'>"._MAPADMIN."</a> ] ";
	}else{
		echo _MAPNOTDELETED."<br><br> [ <a href='".$admin_file.".php?op=mapmain'>"._MAPADMIN."</a> ] ";
	}

}else{
	echo ""._AREYOUSURE." "._MAP." ?"
		."<form action='".$admin_file.".php' method='post'>"
		."<input type='hidden' name='mapid' value='$mapid'>"
		._DELETEMAPIMG."<input type='checkbox' name='delmapimg'><br>"
		._DELETEMAPFILE."<input type='checkbox' name='delmapfile'><br>"
		._DELSS."<input type='checkbox' name='delss'><br><br>"
		."<input type='hidden' name='op' value='delmap'>"
		."<input type='submit' name='delete' value='"._DELETE."'>"
		."</form> [ <a href='".$admin_file.".php?op=mapmain'>"._MAPADMIN."</a> ] ";
}
echo "</center>";
CloseTable();
include("footer.php");
?>