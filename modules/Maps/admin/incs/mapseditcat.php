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

title(_EDITMAPCAT);
if ($id != 0){
	
    $result = $db->sql_query("SELECT * FROM ".$prefix."_mapcat WHERE id='$id'");
    $row = $db->sql_fetchrow($result);
    $catid = intval($row['id']);
    $cattitle = stripslashes($row['title']);
    $catdtl = stripslashes($row['details']);
    $mainid = intval($row['mainid']);
    $catimage = stripslashes($row['image']);
    OpenTable();
    echo "\n\n<!-- Edit Map Categories -->\n"
        ."<form action='".$admin_file.".php' method='post' enctype='multipart/form-data'>\n"
        ."<table width='100%' cellspacing='2' cellpadding='4'>\n"
        ."<tr bgcolor='$bgcolor2'>\n"
        ."<td valign='top'>\n"
        ."<strong>"._MAPCATTITLE." : </strong>\n"
        ."</td>\n"
        ."<td valign='top'>\n"
        ."<input type='text' name='cattitlee' value='$cattitle' size='30' maxlength='100'>\n"
        ."</td>\n"
        ."</tr>\n"
        ."<tr>\n"
        ."<td valign='top'>\n"
        ."<strong>"._MAPTYPECAT." : </strong>\n"
        ."</td>\n"
        ."<td>\n";
    $result2 = $db->sql_query("SELECT * FROM ".$prefix."_mapcat ORDER BY 'mainid' ASC, 'title' ASC");
    echo "<select name='catide'>\n"
        ."<option value='0'>"._PUTINMAIN."</option>\n";
    while($row2 = $db->sql_fetchrow($result2)) {
        $catid2 = intval($row2['id']);
        $cattitle2 = stripslashes($row2['title']);
        $mainid2 = intval($row2['mainid']);
        if ($mainid2!=0) {
            $cattitle2=getparent($mainid2,$cattitle2);
        }
        if ($id == $catid2){
            $s = "selected";
        }else{
            $s = "";
        }
        echo "<option value='$catid2' $s>$cattitle2</option>\n";
    }
    echo "</select>\n"
        ."</td>\n"
        ."</tr>\n"
        ."<tr bgcolor='$bgcolor2'>\n"
        ."<td valign='top'>\n"
        ."<strong>"._MAPTYPECAT." "._DETAILS." : </strong>\n"
        ."</td>\n"
        ."<td valign='top'>\n"
        ."<textarea name='catdtle' cols='50' rows='10' wrap='virtual'>$catdtl</textarea>\n"
        ."</td>\n"
        ."</tr>\n"
        ."<tr>\n"
        ."<td valign='top'>\n"
        ."<strong>"._MAPCAT." "._IMAGE." : </strong>\n"
        ."</td>\n"
        ."<td valign='top'>\n"
        .""._UPFILE." : <input type='file' name='upfile'><br> "._OR." <br>\n"
        .""._ENTERURL." : <input type='text' name='catimagelinke' value='$catimage' size='40' maxlength='200'><br>\n"
		.""._DELOLDIMG." : <input type='checkbox' name='delimg'>\n"
		."<input type='hidden' name='oldimg' value='$catimage'>"
        ."</td>\n"
        ."</tr>\n"
        ."</table>\n"
        ."<center>"
        ."<input type='hidden' name='catid' value='$catid'>\n"
        ."<input type='hidden' name='mainid' value='$mainid'>\n"
        ."<input type='hidden' name='op' value='updmapcat'>\n"
        ."<input type='submit' value='"._UPDATE."'>\n"
        ."</form>\n"
        ."<br><br>\n"
        ."<form action='".$admin_file.".php' method='post'>\n"
        ."<input type='hidden' name='catid' value='$catid'>\n"
        ."<input type='hidden' name='op' value='delmapcat'>\n"
        ."<input type='submit' value='"._DELETE."'>\n"
        ."</form>\n"
        ."</center>\n"
        ."<!-- Edit Map Categories -->\n\n";
    CloseTable();
}else{
    OpenTable();
    echo "<center>"._YOUMUSTSELECTCAT."<br><br>"._GOBACK."</center>";
    CloseTable();
}
include("footer.php");
?>