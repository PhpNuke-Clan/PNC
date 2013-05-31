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
$maptitilee = addslashes(htmlentities(stripslashes($_POST['maptitlee']), ENT_QUOTES));
$mapdtle = addslashes(htmlentities(stripslashes($_POST['mapdtle']), ENT_QUOTES));
$mapauthe = addslashes(htmlentities(stripslashes($_POST['mapauthe']), ENT_QUOTES));
$mapauthee = addslashes(htmlentities(stripslashes($_POST['mapauthee']), ENT_QUOTES));
$maprecpe = intval($_POST['maprecpe']);


if ($_FILES['mapupimg']['size'] == 0 AND empty($_POST['mapimagelinke'])){
        echo ""._ENTERMAPIMAGE."<br>"._GOBACK."";
        CloseTable();
        include("footer.php");
}

if ($_FILES['mapupfile']['size'] == 0 AND empty($_POST['mapfilelinke'])){
        echo ""._ENTERMAPFILE."<br>"._GOBACK."";
        CloseTable();
        include("footer.php");
}

if ($_FILES['mapupimg']['size'] != 0){
        $mapimagee = upfile($mapimagedir, "mapupimg");
        include ("modules/$module_name/admin/incs/thumb.php");
        thumb_img($mapimagee, "");
}else{
        $mapimagee = $_POST['mapimagelinke'];
}
if ($_FILES['mapupfile']['size'] != 0){
        $mapfilee = upfile($mapfiledir, "mapupfile");
        $filesize = filesize($mapfiledir."/".$mapfilee);
}else{
        $mapfilee = $_POST['mapfilelinke'];
        if (file_exists($mapfiledir."/".$mapfilee)){
                $filesize = filesize($mapfiledir."/".$mapfilee);
        }else{
                $filesize = "0";
        }
}

if ($_POST['delimg'] && file_exists($mapimagedir."/".$_POST['oldimg'])){
        if (@unlink($mapimagedir."/".$_POST['oldimg']) && @unlink($mapimagedir."/thumb/".$_POST['oldimg'])){
                echo _IMAGEDELETED." <strong>".$_POST['oldimg']."</strong><br>";
        }
}

if ($_POST['delfile'] && file_exists($mapfiledir."/".$_POST['oldfile'])){
        if (@unlink($mapfiledir."/".$_POST['oldfile'])){
                echo _FILEDELETED." <strong>".$_POST['oldfile']."</strong><br>";
        }
}

$mapimagee = htmlentities($mapimagee, ENT_QUOTES);
$mapfilee = htmlentities($mapfilee, ENT_QUOTES);

$result = $db->sql_query("UPDATE ".$prefix."_mapmap SET cat='$mapcate', title='$maptitlee', details='$mapdtle', author='$mapauthe', authemail='$mapauthee', recplayers='$maprecpe', image='$mapimagee', mapfile='$mapfilee', filesize='$filesize' WHERE mapid='$mapid'");

if ($result){
        echo "$maptitlee "._MAPUPTD."<br>";
}else{
        echo "$maptitle "._MAPNOTUPTD."<br>";
}
echo "<br> [ <a href='".$admin_file.".php?op=mapmain'>"._MAPADMIN."</a> ] "
        ."</center>";
CloseTable();
include("footer.php");
?>
