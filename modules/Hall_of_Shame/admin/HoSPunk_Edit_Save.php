<?php

/********************************************************/
/* Hall of Shame                                     	*/
/* By: Troy Moore (Duck@mrc.clanservers.com)			*/
/* http://mrc.clanservers.com                           */
/* Copyright © 2006-2011 by JesStep Enterprises         */
/********************************************************/
/* Hall of Shame                                        */
/* For PHP-Nuke 6.5+                                    */
/* By Troy Moore - http://mrc.clanservers.com        	*/
/********************************************************/


if ( !defined('ADMIN_FILE') ) {
	die("Illegal Admin File Access");
}


$pid = intval($pid);
$filenames = str_pad($pid, 11, "0", STR_PAD_LEFT);
$punkreason = intval($punkreason);
$punkbannedby = intval($punkbannedby);
if (!$punknotes) {$punknotes = _HoS_NONOTES;}
$punknotes = addslashes(stripslashes($punknotes));
$punkname = addslashes(stripslashes($punkname));
if (!$punkguid) {$punkguid = _HoS_NOTSET;}
$punkguid = addslashes(stripslashes($punkguid));
if (!$punkip) {$punkip = _HoS_NOTSET;}
$punkip = addslashes(stripslashes($punkip));
$ssextallow = $hos_config['ssextallow'];
$demoextallow = $hos_config['demoextallow'];
$now = time();
// Punk Screenshot
$image_name = $_FILES['fpunkss']['name'];
$image_temp = $_FILES['fpunkss']['tmp_name'];
$image_size = $_FILES['fpunkss']['size'];
if ($image_size > $hos_config['maxss']){@include("header.php");
  	OpenTable();
  	echo "<center class='title'>"._HoS_SSFILESIZETOOBIG."</center><br>\n";
  	echo "<center>"._GOBACK."</center>\n";
  	CloseTable();
  	@include("footer.php");
  	die();}
  	else {
if ($image_name != "") {
  $ext = substr($image_name, strrpos($image_name,'.'), 5);
  if (!extcheck($ssextallow, $ext)) {@include("header.php");
    	OpenTable();
    	echo "<center class='title'>"._HoS_SSEXTENSIONNOTALLOWED."</center><br>\n";
    	echo "<center>"._GOBACK."</center>\n";
    	CloseTable();
    	@include("footer.php");
  	die();}
  $new_file = $hos_config['punksspath'].$filenames."_im".$ext;
  @unlink($old_punkss);
  if (move_uploaded_file($image_temp, $new_file)) {
    chmod ($new_file, 0777);
    $punkss = $new_file;
    $punksslabel = "Yes";
  } else {
    echo "<center class='title'>"._HoS_NOSCREENSHOTUPLOAD."</center><br>\n";
    echo "<center>"._GOBACK."</center>\n";
    die();
  }
} else {
  $punkss = $old_punkss;
  $punksslabel = $old_punksslabel;
}
}
// Punk Demo
$punkdemo_name = $_FILES['fpunkdemo']['name'];
$punkdemo_temp = $_FILES['fpunkdemo']['tmp_name'];
$punkdemo_size = $_FILES['fpunkdemo']['size'];
if ($punkdemo_size > $hos_config['maxdemo']){@include("header.php");
  	OpenTable();
  	echo "<center class='title'>"._HoS_DEMOFILESIZETOOBIG."</center><br>\n";
  	echo "<center>"._GOBACK."</center>\n";
  	CloseTable();
  	@include("footer.php");
  	die();}
  	else {
if ($punkdemo_name != "") {
  $ext = substr($punkdemo_name, strrpos($punkdemo_name,'.'), 5);
  if (!extcheck($demoextallow, $ext)) {@include("header.php");
  	  	OpenTable();
  	  	echo "<center class='title'>"._HoS_DEMOEXTENSIONNOTALLOWED."</center><br>\n";
  	  	echo "<center>"._GOBACK."</center>\n";
  	  	CloseTable();
  	  	@include("footer.php");
  	die();}
  $new_file = $hos_config['punkdemopath'].$filenames."_dm".$ext;
  @unlink($old_punkdemo);
  if (move_uploaded_file($punkdemo_temp, $new_file)) {
    chmod ($new_file, 0777);
    $punkdemo = $new_file;
    $punkdemolabel = "Yes";
  } else {
    echo "<center class='title'>"._HoS_DEMOUPLOAD."</center><br>\n";
    echo "<center>"._GOBACK."</center>\n";
    die();
  }
} else {
  $punkdemo = $old_punkdemo;
  $punkdemolabel = $old_punkdemolabel;
}
}

$db->sql_query("UPDATE ".$prefix."_hos_punks SET punkreason='$punkreason', punkname='$punkname', punkguid='$punkguid', punkip='$punkip', punksslabel='$punksslabel', punkss='$punkss', punkdemolabel='$punkdemolabel', punkdemo='$punkdemo', punkbannedby='$punkbannedby', punknotes='$punknotes', date_edit='$now' where pid='$pid'");
$db->sql_query("OPTIMIZE TABLE ".$prefix."_hos_punks");
Header("Location: ".$admin_file.".php?op=HoSPunk_List");

?>