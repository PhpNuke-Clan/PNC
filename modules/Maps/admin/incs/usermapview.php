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
title(_USERSUBMAP);
OpenTable();

$rid = intval($_GET['rid']);

$result = $db->sql_query("SELECT * FROM ".$prefix."_maptemp WHERE rid='$rid'");
$row = $db->sql_fetchrow($result);
	$rid = intval($row['rid']);
	$rcat = intval($row['rcat']);
	$rtitle = stripslashes($row['rtitle']);
	$rdetails = stripslashes($row['rdetails']);
	$rauthor = stripslashes($row['rauthor']);
	$rauthore = stripslashes($row['rauthore']);
	$rrecplay = stripslashes($row['rrecplay']);
	$rimage = stripslashes($row['rimage']);
	$rmapfile = stripslashes($row['rmapfile']);
	$rsubmitter = stripslashes($row['rsubmitter']);
	$rsubmitterip = stripslashes($row['rsubmitterip']);
	$rdate = stripslashes($row['rdate']);

echo "\n<!--Add User Map-->\n\n"
	."<form action='".$admin_file.".php' method='post' enctype='multipart/form-data'>\n"
	."<table width='100%' cellspacing='2' cellpadding='4'>\n"
	."<tr bgcolor='$bgcolor2'>\n"
	."<td valign='top'>\n"
	."<strong>"._MAPTITLE." :</strong>\n"
	."</td>\n"
	."<td>\n"
	."<input type='text' name='rtitle' value='$rtitle' size='30' maxlength='100'>\n"
	."</td>\n"
	."</tr>\n"
	."<tr>\n"
	."<td valign='top'>\n"
	."<strong>"._MAPCAT." :</strong>\n"
	."</td>\n"
	."<td>\n"
	."<select name='rcat'>\n";
	
$result = $db->sql_query("SELECT * FROM ".$prefix."_mapcat ORDER BY 'mainid' ASC, 'title' ASC");
while($row = $db->sql_fetchrow($result)) {
	$catid = intval($row['id']);
	$cattitle = stripslashes($row['title']);
	$mainid = intval($row['mainid']);
	if ($mainid != 0) {
		$cattitle = getparent($mainid, $cattitle);
	}
	if ($rcat == $catid){
		$s = "selected";
	}else{
		$s = "";
	}
	echo "<option value='$catid' $s>$cattitle</option>\n";
}

echo "</select>\n"
	."</td>\n"
	."</tr>\n"
	."<tr bgcolor='$bgcolor2'>\n"
	."<td valign='top'>\n"
	."<strong>"._MAP." "._IMAGE." :</strong>\n"
	."</td>\n"
	."<td>\n"
	.""._ENTERURL." : <input type='text' name='rimage' value='$rimage' size='40' maxlength='200'>\n";
if (!isurl($rimage)){
	echo "[ <a href='$tempdir/$rimage' target='_blank'>"._CHECK."</a> ]\n";
}else{
	echo "[ <a href='$rimage' target='_blank'>"._CHECK."</a> ]\n"
		."[ "._COPYTOSERVER."<input type='checkbox' name='copyimage'> ]\n";
}
echo "</td>\n"
	."</tr>\n"
	."<tr>\n"
	."<td valign='top'>\n"
	."<strong>"._MAP." "._DETAILS." :</strong>\n"
	."</td>\n"
	."<td>\n"
	."<textarea name='rdetails' cols='50' rows='10' wrap='virtual'>$rdetails</textarea>\n"
	."</td>\n"
	."</tr>\n"
	."<tr bgcolor='$bgcolor2'>\n"
	."<td valign='top'>\n"
	."<strong>"._AUTHOR." :</strong>\n"
	."</td>\n"
	."<td>\n"
	."<input type='text' name='rauthor' value='$rauthor' size='30' maxlength='100'>\n"
	."</td>\n"
	."</tr>\n"
	."<tr bgcolor='$bgcolor2'>\n"
	."<td valign='top'>\n"
	."<strong>"._AUTHORE." :</strong>\n"
	."</td>\n"
	."<td>\n"
	."<input type='text' name='rauthore' value='$rauthore' size='30' maxlength='100'>\n"
	."</td>\n"
	."</tr>\n"
	."<tr bgcolor='$bgcolor2'>\n"
	."<td valign='top'>\n"
	."<strong>"._RECPLAYERS." :</strong>\n"
	."</td>\n"
	."<td>\n"
	."<input type='text' name='rrecplay' value='$rrecplay' size='30' maxlength='100'>\n"
	."</td>\n"
	."</tr>\n"
	."<tr bgcolor='$bgcolor2'>\n"
	."<td valign='top'>\n"
	."<strong>"._MAP." "._FILE." :</strong>\n"
	."</td>\n"
	."<td>\n"
	.""._ENTERURL." : <input type='text' name='rmapfile' value='$rmapfile' size='40' maxlength='200'>\n";
if (!isurl($rmapfile)){
	echo "[ <a href='$tempdir/$rmapfile' target='_blank'>"._CHECK."</a> ]\n";
}else{
	echo "[ <a href='$rmapfile' target='_blank'>"._CHECK."</a> ]\n"
		."[ "._COPYTOSERVER."<input type='checkbox' name='copyfile'> ]\n";
}
echo "</td>\n"
	."</tr>\n"
	."</table>\n"
	."<center>\n"
	."<input type='hidden' name='reqsubmitter' value='$submitter'>\n"
	."<input type='hidden' name='reqsubmitterip' value='$submitterip'>\n"
	."<input type='hidden' name='rid' value='$rid'>"
	."<input type='hidden' name='op' value='addusermap'>\n"
	."<input type='submit' name='submit' value='"._ADDMAP."'>\n"
	."</form>\n"
	."<br><br>\n"
	."<form action='".$admin_file.".php' method='post'>\n"
	."<input type='hidden' name='rid' value='$rid'>\n"
	."<input type='hidden' name='op' value='delusermap'>\n"
	."<input type='submit' value='"._DELETE." "._MAP."'>\n"
	."</form>\n"
	."</center>\n"
	."<!--End Add User Map-->\n\n";
CloseTable();
include("footer.php");
?>