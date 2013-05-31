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

if ( !defined('MODULE_FILE') )
{
	die("You can't access this file directly...");
}

/* if(!stristr($_SERVER['PHP_SELF'], "modules.php") && !stristr($_SERVER['SCRIPT_NAME'], "modules.php")) {
	die ("You can't access this file directly...");
} */

@require_once("mainfile.php");
$module_name = basename(dirname(__FILE__));
get_lang($module_name);
$pagetitle = "- $module_name - "._SUBMITMAP;

@include("header.php");
@include("modules/$module_name/functions.php");

$cr1 = $db->sql_query("SELECT mval FROM ".$prefix."_mapconfig where mname='a_submit'");
	list($allowuseradd) = $db->sql_fetchrow($cr1);
$cr2 = $db->sql_query("SELECT mval FROM ".$prefix."_mapconfig where mname='temp'");
	list($tempdir) = $db->sql_fetchrow($cr2);
$cr3 = $db->sql_query("SELECT mval FROM ".$prefix."_mapconfig where mname='a_upload'");
	list($allowupload) = $db->sql_fetchrow($cr3);
$cr4 = $db->sql_query("SELECT mval FROM ".$prefix."_mapconfig where mname='a_ftypes'");
	list($allowftypes) = $db->sql_fetchrow($cr4);

if (is_user($user)){
	if ($allowuseradd){
		if (isset($_POST['submit'])){
			nav();
			OpenTable();
			echo "<center>\n";
			if (empty($_POST['reqmaptitle'])){
				echo _NOMAPTITLE."<br>"._GOBACK;
				CloseTable();
				@include("footer.php");
			}

			if (!isset($_POST['reqmapcat'])){
				echo _SELECTCAT."<br>"._GOBACK;
				CloseTable();
				@include("footer.php");
			}

			if ($_FILES['reqimgfile']['size'] == 0 AND empty($_POST['reqmapimagelink'])){
				echo _ENTERMAPIMAGE."<br>"._GOBACK;
				CloseTable();
				@include("footer.php");
			}

			if ($_FILES['reqmapfile']['size'] == 0 AND empty($_POST['reqmapfilelink'])){
				echo _ENTERMAPFILE."<br>"._GOBACK;
				CloseTable();
				@include("footer.php");
			}

			if ($_FILES['reqimgfile']['size'] != 0){
				$reqmapimage = upfile($tempdir, "reqimgfile");
			}else{
				if (isurl($_POST['reqmapimagelink'])){
					$reqmapimage = stripslashes($_POST['reqmapimagelink']);
				}else{
					echo _INVALIDURL." "._MAP." "._IMAGE."<br>"._GOBACK;
					CloseTable();
					@include("footer.php");
				}
			}

			if ($_FILES['reqmapfile']['size'] != 0){
				$reqmapfile = upfile($tempdir, "reqmapfile");
			}else{
				if (isurl($_POST['reqmapfilelink'])){
					$reqmapfile =  stripslashes($_POST['reqmapfilelink']);
				}else{
					echo _INVALIDURL." "._MAP." "._FILE."<br>"._GOBACK;
					CloseTable();
					@include("footer.php");
				}
			}

			$reqmapcat = intval($_POST['reqmapcat']);
			$reqmaptitle = check_html($_POST['reqmaptitle'], 'nohtml');
			$reqmaptitle = htmlentities($reqmaptitle, ENT_QUOTES);
			$reqmapdtl = check_html($_POST['reqmapdtl'], 'nohtml');
			$reqmapdtl = htmlentities($reqmapdtl, ENT_QUOTES);
			$reqmapauth = check_html($_POST['reqmapauth'], 'nohtml');
			$reqmapauthe = check_html($_POST['reqmapauthe'], 'nohtml');
      $reqmapauthe = htmlentities($reqmapauthe, ENT_QUOTES);
			$reqmaprecp = intval($_POST['reqmaprecp']);
			$reqmapimage = htmlentities($reqmapimage, ENT_QUOTES);
			$reqmapfile = htmlentities($reqmapfile, ENT_QUOTES);
			$reqsubmitter = check_html($_POST['reqsubmitter'], nohtml);
      $cookie = cookiedecode($user);
			$reqsubmitter = $cookie[1];
			$reqsubmitterip = $_SERVER['REMOTE_ADDR'];
			$reqdate = time();
			if (!get_magic_quotes_gpc()) {
				$reqmaptitle = addslashes($reqmaptitle);
				$reqmapdtl = addslashes($reqmapdtl);
				$reqmapauth = addslashes($reqmapauth);
				$reqmapauthe = addslashes($reqmapauthe);
				$reqmapimage = addslashes($reqmapimage);
				$reqmapfile = addslashes($reqmapfile);
				
			}
			$result = $db->sql_query("INSERT INTO ".$prefix."_maptemp VALUES (NULL, '$reqmapcat', '$reqmaptitle', '$reqmapdtl', '$reqmapauth', '$reqmapauthe', '$reqmaprecp', '$reqmapimage', '$reqmapfile', '$reqsubmitter', '$reqsubmitterip', '$reqdate')");

			if($result){
				echo "$reqmaptitle "._MAPSUBMITTED."<br>\n";
			}else{
				echo "$reqmaptitle "._MAPNOTSUBMITTED."<br>\n";
			}
			echo "<br>[ <a href=\"modules.php?name=$module_name\">"._MAPS." "._MAIN."</a> ]\n"
				."</center>\n";
			CloseTable();
		}else{
			nav();
			
			$maxupsize = @ini_get("upload_max_filesize");
			title(_SUBMITMAP);
			OpenTable();
			echo "\n<!--Add Map Rules-->\n\n"
				."-&raquo; "._MAXUPFILESIZE." $maxupsize<br>\n"
				."-&raquo; "._CHECKSIZE." $maxupsize<br>\n"
				."-&raquo; "._ALLOWFTYPES." $allowftypes<br>\n"
				."-&raquo; "._SHOTSIZE." <br>\n"
				."-&raquo; "._PRESSONCE."\n\n";
			CloseTable();
			echo "<br>";
			OpenTable();
			echo "\n<!--Add Map-->\n\n";
			if ($allowupload){
				echo "<form action='modules.php?name=$module_name&amp;file=addmap' method='post' enctype='multipart/form-data'>\n";
			}else{
				echo "<form action='modules.php?name=$module_name&amp;file=addmap' method='post'>\n";
			}
			echo "<table width='100%' cellspacing='2' cellpadding='4'>\n"
				."<tr>\n"
				."<td valign='top' bgcolor='$bgcolor2'>\n"
				."<b>"._MAPTITLE." :*</b>\n"
				."</td>\n"
				."<td>\n"
				."<input type='text' name='reqmaptitle' size='30' maxlength='100'>\n"
				."</td>\n"
				."</tr>\n"
				."<tr>\n"
				."<td valign='top' bgcolor='$bgcolor2'>\n"
				."<b>"._MAPCAT." :*</b>\n"
				."</td>\n"
				."<td>\n"
				."<select name='reqmapcat'>\n"
				."<option value='' selected>"._SELECTCAT."</option>\n";
			$result = $db->sql_query("SELECT * FROM ".$prefix."_mapcat ORDER BY 'mainid' ASC, 'title' ASC");
			while($row = $db->sql_fetchrow($result)) {
				$catid = intval($row['id']);
				$cattitle = $row['title'];
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
				."<b>"._MAP." "._IMAGE." :*</b>\n"
				."</td>\n"
				."<td>\n";
			if ($allowupload){
				echo ""._UPFILE." : <input type='file' name='reqimgfile'>\n"
					."<br> "._OR." <br>\n";
			}
			echo ""._ENTERURL." : <input type='text' name='reqmapimagelink' size='40' maxlength='200'>\n"
				."</td>\n"
				."</tr>\n"
				."<tr>\n"
				."<td valign='top' bgcolor='$bgcolor2'>\n"
				."<b>"._MAP." "._DETAILS." :</b>\n"
				."</td>\n"
				."<td>\n"
				."<textarea name='reqmapdtl' cols='50' rows='10' wrap='virtual'></textarea>\n"
				."</td>\n"
				."</tr>\n"
				."<tr>\n"
				."<td valign='top' bgcolor='$bgcolor2'>\n"
				."<b>"._MAPAUTHOR." :*</b>\n"
				."</td>\n"
				."<td>\n"
				."<input type='text' name='reqmapauth' size='30' maxlength='100'>\n"
				."</td>\n"
				."</tr>\n"
				."<tr>\n"
				."<td valign='top' bgcolor='$bgcolor2'>\n"
				."<b>"._MAPAUTHORE." :*</b>\n"
				."</td>\n"
				."<td>\n"
				."<input type='text' name='reqmapauthe' size='30' maxlength='100'>\n"
				."</td>\n"
				."</tr>\n"
				."<tr>\n"
				."<td valign='top' bgcolor='$bgcolor2'>\n"
				."<b>"._RECPLAYERS." :*</b>\n"
				."</td>\n"
				."<td>\n"
				."<input type='text' name='reqmaprecp' size='30' maxlength='100'>\n"
				."</td>\n"
				."</tr>\n"
				."<tr>\n"
				."<td valign='top' bgcolor='$bgcolor2'>\n"
				."<b>"._MAP." "._FILE." :*</b>\n"
				."</td>\n"
				."<td>\n";
			if ($allowupload){
				echo ""._UPFILE." : <input type='file' name='reqmapfile'>\n"
					."<br> "._OR." <br>\n";
			}
			echo ""._ENTERURL." : <input type='text' name='reqmapfilelink' value='' size='40' maxlength='200'>\n"
				."</td>\n"
				."</tr>\n"
				."<tr>\n"
				."<td colspan='2' align='center'>\n"
				."<input type='hidden' name='op' value='addmap'>\n"
				."<input type='submit' name='submit' value='"._SUBMITMAP."'>\n"
				."</td>\n"
				."</tr>\n"
				."</table>\n"
				."</form>\n"
				."<!--End Add Map-->\n\n";
			CloseTable();
		}
	}
}else{
	nav();
	OpenTable();
	echo "<center>"._MUSTBEREGISTERED."</center>";
	CloseTable();
	}
@include("footer.php");
?>