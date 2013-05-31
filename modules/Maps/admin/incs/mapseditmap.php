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
$id = intval($_POST['id']);

title(_EDITMAP);
if ($id != 0){
	
	$result = $db->sql_query("SELECT * FROM ".$prefix."_mapmap WHERE mapid='$id'");
	$row = $db->sql_fetchrow($result);
	$mapid = intval($row['mapid']);
	$mapcat = intval($row['cat']);
	$maptitle = stripslashes($row['title']);
	$mapdtl = stripslashes($row['details']);
	$mapauth = stripslashes($row['author']);
	$mapauthe = stripslashes($row['authemail']);
	$maprecp = stripslashes($row['recplayers']);
	$mapimage = stripslashes($row['image']);
	$mapfile = stripslashes($row['mapfile']);
	OpenTable();
	echo "\n\n<!-- Edit Map -->\n"
		."<form action='".$admin_file.".php' method='post' enctype='multipart/form-data'>\n"
		."<table width='100%' cellspacing='2' cellpadding='4'>\n"
		."<tr>\n"
		."<td valign='top' bgcolor='$bgcolor2'>\n"
		."<strong>"._MAPTITLE." : </strong>\n"
		."</td>\n"
		."<td valign='top'>\n"			
		."<input type='text' name='maptitlee' value='$maptitle' size='30' maxlength='100'>\n"
		."</td>\n"
		."</tr>\n"
		."<tr>\n"
		."<td valign='top' bgcolor='$bgcolor2'>\n"
		."<strong>"._MAPCAT." : </strong>\n"
		."</td>\n"
		."<td>\n";
	$result2 = $db->sql_query("SELECT * FROM ".$prefix."_mapcat ORDER BY 'mainid' ASC, 'title' ASC");
	echo "<select name='mapcate'>\n"
		."<option value='0'>"._PUTINMAIN."</option>\n";
	while($row2 = $db->sql_fetchrow($result2)) {
		$catid2 = intval($row2['id']);
		$cattitle2 = stripslashes($row2['title']);
		$mainid2 = intval($row2['mainid']);
		if ($mainid2!=0) {
			$cattitle2=getparent($mainid2,$cattitle2);
		}
		if ($mapcat == $catid2){
			$s = "selected";
		}else{
			$s = "";
		}
		echo "<option value='$catid2' $s>$cattitle2</option>\n";
	}
	echo "</select>\n"
		."</td>\n"
		."</tr>\n"
		."<tr>\n"
		."<td valign='top' bgcolor='$bgcolor2'>\n"
		."<strong>"._MAP." "._IMAGE." :</strong>\n"
		."</td>\n"
		."<td valign='top'>\n"
		.""._UPFILE." : <input type='file' name='mapupimg'><br> "._OR." <br>\n"
		.""._ENTERURL." : <input type='text' name='mapimagelinke' value='$mapimage' size='40' maxlength='200'><br>\n"
		.""._DELOLDIMG." : <input type='checkbox' name='delimg'>\n"
		."<input type='hidden' name='oldimg' value='$mapimage'>\n"
		."</td>\n"
		."</tr>\n"
		."<tr>\n"
		."<td valign='top' bgcolor='$bgcolor2'>\n"
		."<strong>"._MAP." "._DETAILS." : </strong>\n"
		."</td>\n"
		."<td valign='top'>\n"
		."<textarea name='mapdtle' cols='50' rows='10' wrap='virtual'>$mapdtl</textarea>\n"
		."</td>\n"
		."</tr>\n"
		."<tr>\n"
		."<td valign='top' bgcolor='$bgcolor2'>\n"
		."<strong>"._MAP." "._AUTHOR." : </strong>\n"
		."</td>\n"
		."<td valign='top'>\n"
		."<input type='text' name='mapauthe' size='30' value='$mapauth'>\n"
		."</td>\n"
		."</tr>\n"
		."<tr>\n"
		."<td valign='top' bgcolor='$bgcolor2'>\n"
		."<strong>"._MAP." "._AUTHORE." : </strong>\n"
		."</td>\n"
		."<td valign='top'>\n"
		."<input type='text' name='mapauthee' size='30' value='$mapauthe'>\n"
		."</td>\n"
		."</tr>\n"
		."<tr>\n"
		."<td valign='top' bgcolor='$bgcolor2'>\n"
		."<strong>"._MAP." "._RECPLAYERS." : </strong>\n"
		."</td>\n"
		."<td valign='top'>\n"
		."<input type='text' name='maprecpe' size='30' value='$maprecp'>\n"
		."</td>\n"
		."</tr>\n"
		."<tr>\n"
		."<td valign='top' bgcolor='$bgcolor2'>\n"
		."<strong>"._MAP." "._FILE." :</strong>\n"
		."</td>\n"
		."<td valign='top'>\n"
		.""._UPFILE." : <input type='file' name='mapupfile'><br> "._OR." <br>\n"
		.""._ENTERURL." : <input type='text' name='mapfilelinke' value='$mapfile' size='40' maxlength='200'><br>\n"
		.""._DELOLDFILE." : <input type='checkbox' name='delfile'>\n"
		."<input type='hidden' name='oldfile' value='$mapfile'>\n"
		."</td>\n"
		."</tr>\n"
		."</table>\n"
		."<center>\n"
		."<input type='hidden' name='mapid' value='$mapid'>\n"
		."<input type='hidden' name='op' value='updmap'>\n"
		."<input type='submit' value='"._UPDATE."'>\n"
		."</form>\n"
		."<br><br>\n"
		."<form action='".$admin_file.".php' method='post'>\n"
		."<input type='hidden' name='mapid' value='$mapid'>\n"
		."<input type='hidden' name='op' value='delmap'>\n"
		."<input type='submit' value='"._DELETE."'>\n"
		."</form>\n"
		."</center>\n"
		."<!-- Edit Map -->\n\n";
	CloseTable();
}else{
	OpenTable();
	echo "<center>"._YOUMUSTSELECTMAP."<br><br>"._GOBACK."</center>\n";
	CloseTable();
}
include("footer.php");
?>