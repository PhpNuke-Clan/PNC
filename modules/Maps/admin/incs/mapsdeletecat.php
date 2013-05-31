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
if ($_POST['delete']){
	$result = $db->sql_query("SELECT * FROM ".$prefix."_mapcat WHERE id='".intval($_POST['catid'])."'");
	$row = $db->sql_fetchrow($result);
	$id = intval($row['id']);
	$catimage = $row['image'];
	if ($_POST['delcatimg'] && !isurl($catimage)){
		if (file_exists($catimagedir."/".$catimage)){
			if (@unlink($catimagedir."/".$catimage)){
				echo _IMAGEDELETED." <strong>$catimage</strong><br>";
			}
		}
	}

	$del = $db->sql_query("DELETE FROM ".$prefix."_mapcat WHERE id='$id'");
	if ($del){
		echo _MAPCATDELETED."<br>\n"
			."<br>[ <a href='".$admin_file.".php?op=mapmain'>"._MAPADMIN."</a> ]\n";
	}
}else{
	//$result = $db->sql_query("SELECT image FROM ".$prefix."_mapcat where id='".intval($_POST['catid'])."'");
	//$row = $db->sql_fetchrow($result);
	//$mapimage = $row['image'];
	echo ""._AREYOUSURE." "._MAPCAT."<br>"
		."<form action='".$admin_file.".php' method='post'>"
		."<input type='hidden' name='catid' value='".intval($_POST['catid'])."'>"
		._DELETECATIMAGE." <input type='checkbox' name='delcatimg'><br>"
		."<input type='hidden' name='op' value='delmapcat'>"
		."<input type='submit' name='delete' value='"._DELETE."'>"
		."</form><br><br> [ <a href='".$admin_file.".php?op=mapmain'>"._MAPADMIN."</a> ] ";
}
echo "</center>";
CloseTable();
include("footer.php");
?>