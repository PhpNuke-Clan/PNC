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
title(_MAPADMIN);
//Show info
OpenTable();
echo "<table width='100%' border='1' cellpadding='4' cellspacing='0'>\n"
	."<tr>\n"
	."<td colspan='2'>\n"
	."<center>[ <a href='".$admin_file.".php?op=mapconfig'>"._MAPSCONFIG."</a> ] - [ <a href='".$admin_file.".php'>"._ADMINMENU."</a> ]</center>"
	."</td>\n"
	."</tr>\n"
	."<tr>\n"
	."<td align='center' valign='top'>\n"
	.""._NEEDTHUMBS." : <br>\n";
$handle = opendir("$mapimagedir");
while ($file = readdir($handle)){
	if ($file != "." && $file != ".."){
		if (strrpos($file, ".")){
			$tlist .= "$file ";
		}
	}
}
closedir($handle);
$tlist = explode(" ", $tlist);
sort($tlist);

$n = 0;
for ($i = 0; $i < sizeof($tlist); $i++){
	if($tlist[$i] != "") {
		if (!file_exists($mapimagedir."/thumb/".$tlist[$i])){
			echo "<strong>$tlist[$i]</strong><br>\n";
			$n++;
		}
	}
}
if ($n > 0){
	echo "<form action='".$admin_file.".php' method='post'>\n"
		."<input type='hidden' name='op' value='thumb_img'>\n"
		."<input type='submit' name='mkthumb' value='"._CREATETHUMBS."'>\n"
		."</form>";
}else{
	echo "<strong>"._NONE."</strong>";
}
echo "</td>\n"
	."<td align='center' valign='top'>\n";
$resultr = $db->sql_query("SELECT * FROM ".$prefix."_maptemp");
$num = $db->sql_numrows($resultr);
echo ""._MAPSWAITING." : $num<br>\n";
while($rowr = $db->sql_fetchrow($resultr)){
	$rid = intval($rowr['rid']);
	$rtitle = stripslashes($rowr['rtitle']);
	$rsubmitter = stripslashes($rowr['rsubmitter']);
	echo "<a href='".$admin_file.".php?op=usermap&amp;rid=$rid'><strong>$rtitle</strong> "._BY." $rsubmitter</a><br>\n";
}
echo "</td>\n
	</tr>
	<tr>
	<td align='center' valign='top'>\n"
//Edit Map Categories
	."<font class='title'>"._EDITMAPCAT."</font>\n"
	."<form action='".$admin_file.".php' method='post'>\n";
$result2 = $db->sql_query("SELECT * FROM ".$prefix."_mapcat ORDER BY 'mainid' ASC, 'title' ASC");
echo "<select name='id'>\n"
	."<option value='' selected>"._SELECTONE."</option>\n";
while($row2 = $db->sql_fetchrow($result2)) {
	$catide = intval($row2['id']);
	$cattitlee = stripslashes($row2['title']);
	$mainide = intval($row2['mainid']);
	if ($mainide != 0) {
		$cattitlee = getparent($mainide, $cattitlee);
	}
	echo "<option value='$catide'>$cattitlee</option>\n";
}
echo "</select><br>\n"
	."<input type='hidden' name='op' value='editmapcat'>\n"
	."<input type='submit' value='"._EDITMAPCAT."'>\n"
	."</form>\n"
	."</td>\n"
	."<td align='center' valign='top'>\n"
//Edit Maps
	."<font class='title'>"._EDITMAP."</font>\n"
	."<form action='".$admin_file.".php' method='post'>\n";
$result = $db->sql_query("SELECT mapid, title from ".$prefix."_mapmap order by 'title'");
echo "<select name='id'>\n"
	."<option value='' selected>"._SELECTONE."</option>\n";
while($row = $db->sql_fetchrow($result)) {
    $mapid = intval($row['mapid']);
	$maptitle = stripslashes($row['title']);
	echo "<option value='$mapid'>$maptitle</option>\n";
}
echo "</select><br>\n"
	."<input type='hidden' name='op' value='editmap'>\n"
	."<input type='submit' value='"._EDITMAP."'>\n"
	."</form>\n"
	."</td>\n"
	."</tr>\n"
	."</table>\n";
CloseTable();
echo "<br>";
OpenTable();
	$result = $db->sql_query("SELECT * FROM ".$prefix."_mapreviews WHERE rapprove='0'");
	$results = $db->sql_numrows($result);
		echo "<table width='100%'>
		<tr>
		<td align='center' colspan='6'><font class='title'>"._REVAPP."</font></td>
		</tr>
		<tr bgcolor='$bgcolor2'>
		  <td>"._USERID."</td><td>"._REVIEWER."</td><td>"._USERIP."</td><td>"._REVIEWDATE."</td><td>"._REVIEW."</td><td>"._APPROVE."</td>
		</tr>";
		if ($results == 0){
			echo "<tr>
			        <td colspan='6'>"._NOREVIEWS."</td>
			      </tr>";
		}else{
			while($row = $db->sql_fetchrow($result)) {
				$rid = intval($row['rid']);
				$ruserid = stripslashes($row['ruserid']);
				$ruserip = stripslashes($row['ruserip']);
				$rdate = $row['rdate'];
				$review = $row['review'];
					$result2 = $db->sql_query("SELECT * FROM ".$prefix."_users WHERE user_id='$ruserid'");
					$user = $db->sql_fetchrow($result2);
					$ruser = $user['username'];
					echo "<form action='$admin_file.php' method='post'><tr>
					<td>$rid</td><td>$ruser</td><td>$ruserip</td><td>$rdate</td><td><textarea name='review' cols='60' rows='2' wrap='virtual'>$review</textarea></td>
					<td><input type='hidden' name='op' value='approve'>
					<input type='hidden' name='rid' value='$rid'>
					<input type='submit' value='"._APPROVE."'></td>
					</tr>
					</form>";
			}
		}
echo "</table>";
CloseTable();
echo "<br>";
OpenTable();
//Add Map Categories
echo "<form action='".$admin_file.".php' method='post' enctype='multipart/form-data'>\n"
	."<table width='100%' cellspacing='2' cellpadding='4'>\n"
	."<tr bgcolor='$bgcolor2'>\n"
	."<td colspan='2' align='center'>\n"
	."<font class='title'>"._ADDMAPCAT."</font>\n"
	."</td>\n"
	."</tr>\n"
	."<tr>\n"
	."<td valign='top' bgcolor='$bgcolor2'>\n"
	."<strong>"._MAPCATTITLE." :</strong>\n"
	."</td>\n"
	."<td>\n"
	."<input type='text' name='cattitle2' size='30' maxlength='100'>\n"
	."</td>\n"
	."</tr>\n"
	."<tr>\n"
	."<td valign='top' bgcolor='$bgcolor2'>\n"
	."<strong>"._MAPTYPECAT." :</strong>\n"
	."</td>\n"
	."<td>\n"
	."<select name='catid2'>\n"
	."<option value='0' selected>"._PUTINMAIN."</option>\n";
	
$result = $db->sql_query("SELECT * FROM ".$prefix."_mapcat ORDER BY 'mainid' ASC, 'title' ASC");
while($row = $db->sql_fetchrow($result)) {
	$catid = intval($row['id']);
	$cattitle = stripslashes($row['title']);
	$mainid = intval($row['mainid']);
	if ($mainid!=0) {
		$cattitle=getparent($mainid,$cattitle);
	}
	echo "<option value='$catid'>$cattitle</option>\n";
}

echo "</select>\n"
	."</td>\n"
	."</tr>\n"
	."<tr>\n"
	."<td valign='top' bgcolor='$bgcolor2'>\n"
	."<strong>"._MAPCAT." "._DETAILS." :</strong>\n"
	."</td>\n"
	."<td>\n"
	."<textarea name='catdtl2' cols='50' rows='10' wrap='virtual'></textarea>\n"
	."</td>\n"
	."</tr>\n"
	."<tr>\n"
	."<td valign='top' bgcolor='$bgcolor2'>\n"
	."<strong>"._MAPCAT." "._IMAGE." :</strong>\n"
	."</td>\n"
	."<td>\n"
	.""._UPFILE." : <input type='file' name='upfile'><br> "._OR." <br>\n"
	.""._ENTERURL." : <input type='text' name='catimagelink2' value='' size='40' maxlength='200'>\n"
	."</td>\n"
	."</tr>\n"
	."<tr>\n"
	."<td colspan='2' align='center'>\n"
	."<input type='hidden' name='op' value='addmapcat'>\n"
	."<input type='submit' value='"._ADDMAPCAT."'>\n"
	."</td>\n"
	."</tr>\n"
	."</table>\n"
	."</form>\n";
CloseTable();
echo "<br>";
//Add Maps
OpenTable();
echo "<form action='".$admin_file.".php' method='post' enctype='multipart/form-data'>\n"
	."<table width='100%' cellspacing='2' cellpadding='4'>\n"
	."<tr>\n"
	."<td colspan='2' align='center' bgcolor='$bgcolor2'>\n"
	."<font class='title'>"._ADDMAP."</font>\n"
	."</td>\n"
	."</tr>"
	."<tr>\n"
	."<td valign='top' bgcolor='$bgcolor2'>\n"
	."<strong>"._MAPTITLE." :</strong>\n"
	."</td>\n"
	."<td>\n"
	."<input type='text' name='maptitle2' size='30' maxlength='100'>\n"
	."</td>\n"
	."</tr>\n"
	."<tr>\n"
	."<td valign='top' bgcolor='$bgcolor2'>\n"
	."<strong>"._MAPCAT." :</strong>\n"
	."</td>\n"
	."<td>\n"
	."<select name='mapcat2'>\n"
	."<option value='' selected>"._PUTINMAIN."</option>\n";
$result = $db->sql_query("SELECT * FROM ".$prefix."_mapcat ORDER BY 'mainid' ASC, 'title' ASC");
while($row = $db->sql_fetchrow($result)) {
	$catid = intval($row['id']);
	$cattitle = stripslashes($row['title']);
	$mainid = intval($row['mainid']);
	if ($mainid != 0) {
		$cattitle = getparent($mainid, $cattitle);
	}
	echo "<option value='$catid'>$cattitle</option>\n";
}

echo "</select>\n"
	."</td>\n"
	."</tr>\n"
	."<tr>\n"
	."<td valign='top' bgcolor='$bgcolor2'>\n"
	."<strong>"._MAP." "._IMAGE." :</strong>\n"
	."</td>\n"
	."<td>\n"
	.""._UPFILE." : <input type='file' name='upfile'><br> "._OR." <br>\n"
	.""._ENTERURL." : <input type='text' name='mapimagelink' size='40' maxlength='200'>\n"
	."</td>\n"
	."</tr>\n"
	."<tr>\n"
	."<td valign='top' bgcolor='$bgcolor2'>\n"
	."<strong>"._MAP." "._DETAILS." :</strong>\n"
	."</td>\n"
	."<td>\n"
	."<textarea name='mapdtl2' cols='50' rows='10' wrap='virtual'></textarea>\n"
	."</td>\n"
	."</tr>\n"
	."<tr>\n"
	."<td valign='top' bgcolor='$bgcolor2'>\n"
	."<b>"._MAPAUTHOR." :*</b>\n"
	."</td>\n"
	."<td>\n"
	."<input type='text' name='mapauth2' size='30' maxlength='100'>\n"
	."</td>\n"
	."</tr>\n"
	."<tr>\n"
	."<td valign='top' bgcolor='$bgcolor2'>\n"
	."<b>"._MAPAUTHORE." :*</b>\n"
	."</td>\n"
	."<td>\n"
	."<input type='text' name='mapauthe2' size='30' maxlength='100'>\n"
	."</td>\n"
	."</tr>\n"
	."<tr>\n"
	."<td valign='top' bgcolor='$bgcolor2'>\n"
	."<b>"._RECPLAYERS." :*</b>\n"
	."</td>\n"
	."<td>\n"
	."<input type='text' name='maprecp2' size='30' maxlength='100'>\n"
	."</td>\n"
	."</tr>\n"
	."<tr>\n"
	."<td valign='top' bgcolor='$bgcolor2'>\n"
	."<strong>"._MAP." "._FILE." :</strong>\n"
	."</td>\n"
	."<td>\n"
	.""._UPFILE." : <input type='file' name='upfile2'><br> "._OR." <br>\n"
	.""._ENTERURL." : <input type='text' name='mapfilelink' value='' size='40' maxlength='200'>\n"
	."</td>\n"
	."</tr>\n"
	."<tr>\n"
	."<td colspan='2' align='center'>\n"
	."<input type='hidden' name='op' value='addmap'>\n"
	."<input type='submit' name='submit' value='"._ADDMAP."'>\n"
	."</td>\n"
	."</tr>\n"
	."</table>\n"
	."</form>\n";
CloseTable();
echo "<br>";
include("footer.php");
?>