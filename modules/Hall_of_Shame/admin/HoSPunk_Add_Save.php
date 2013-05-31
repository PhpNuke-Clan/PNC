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


list($newest_pid) = $db->sql_fetchrow($db->sql_query("SELECT max(pid) AS newest_pid FROM ".$prefix."_hos_punks"));
if ($newest_pid == "-1") { $new_pid = 1; $newest_pid = 1; } else { $new_pid = $newest_pid+1; }
$filenames = str_pad($new_pid, 11, "0", STR_PAD_LEFT);
$punkreason = intval($punkreason);
$punkbannedby = intval($punkbannedby);
if (!$punknotes) {$punknotes = _HoS_NONOTES;}
$punknotes = addslashes(stripslashes($punknotes));
$punkname = addslashes(stripslashes($punkname));
if (!$punkguid) {$punkguid = _HoS_NOTSET;}
$punkguid = addslashes(stripslashes($punkguid));
if (!$punkip) {$punkip = _HoS_NOTSET;}
$punkip = addslashes(stripslashes($punkip));
$punksslabel = "No";
$punkss = "modules/Hall_of_Shame/images/noss.gif";
$punkdemolabel = "No";
$punkdemo = "modules/Hall_of_Shame/images/nodemo.gif";
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
if ($image_name != ""){
	$ext = substr($image_name, strrpos($image_name,'.'));
	if (!extcheck($ssextallow, $ext)) {@include("header.php");
  	OpenTable();
  	echo "<center class='title'>"._HoS_SSEXTENSIONNOTALLOWED."</center><br>\n";
  	echo "<center>"._GOBACK."</center>\n";
  	CloseTable();
  	@include("footer.php");
  	die();}
	$new_file = $hos_config['punksspath'].$filenames."_im".$ext;
	@unlink($new_file);
		if (move_uploaded_file($image_temp, $new_file)) {
  		@chmod ($new_file, 0777);
  		$punkss = $new_file;
  		$punksslabel = "Yes";
		} else {
  	@include("header.php");
  	OpenTable();
  	echo "<center class='title'>"._HoS_SCREENSHOTUPLOADFAILED."</center><br>\n";
  	echo "<center>"._GOBACK."</center>\n";
  	CloseTable();
  	@include("footer.php");
  	die();
	}

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
if ($punkdemo_name != ""){
	$ext = substr($punkdemo_name, strrpos($punkdemo_name,'.'));
	if (!extcheck($demoextallow, $ext)) {@include("header.php");
	  	OpenTable();
	  	echo "<center class='title'>"._HoS_DEMOEXTENSIONNOTALLOWED."</center><br>\n";
	  	echo "<center>"._GOBACK."</center>\n";
	  	CloseTable();
	  	@include("footer.php");
  	die();}
	$new_file = $hos_config['punkdemopath'].$filenames."_dm".$ext;
	@unlink($new_file);
		if (move_uploaded_file($punkdemo_temp, $new_file)) {
  		@chmod ($new_file, 0777);
  		$punkdemo = $new_file;
  		$punkdemolabel = "Yes";
		} else {
  	@include("header.php");
  	OpenTable();
  	echo "<center class='title'>"._HoS_NODEMOUPLOAD."</center><br>\n";
  	echo "<center>"._GOBACK."</center>\n";
 	CloseTable();
  	@include("footer.php");
  	die();
	}

}
}
$db->sql_query("INSERT INTO ".$prefix."_hos_punks VALUES ('$new_pid', '$punkname', '$punkguid', '$punkip', '$punkreason', '$punkbannedby', '$punksslabel', '$punkss', '$punkdemolabel', '$punkdemo', '$punknotes', '$now', '$now')");
$db->sql_query("OPTIMIZE TABLE ".$prefix."_hos_punks");
if($another == 1) {
  Header("Location: ".$admin_file.".php?op=HoSPunk_Add");
}else {
  Header("Location: ".$admin_file.".php?op=HoSPunk_List");
}

?>