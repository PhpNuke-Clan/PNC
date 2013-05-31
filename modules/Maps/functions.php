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

$module_name = basename(dirname(__FILE__));
get_lang($module_name);

function nav(){
	global $db, $prefix, $module_name;
	$cr1 = $db->sql_query("SELECT mval FROM ".$prefix."_mapconfig where mname='a_submit'");
		list($allowuseradd) = $db->sql_fetchrow($cr1);
	$cr1 = $db->sql_query("SELECT mval FROM ".$prefix."_mapconfig where mname='a_group'");
		list($allowgroupdl) = $db->sql_fetchrow($cr1);
	$cr2 = $db->sql_query("SELECT mval FROM ".$prefix."_mapconfig where mname='a_anon'");
	list($allowanon) = $db->sql_fetchrow($cr2);

		OpenTable();
	echo "\n<!--Maps Nav Bar-->\n\n"
		."<center>\n"
		."	[ <a href='modules.php?name=$module_name'>"._MAIN."</a> ]\n";
	if ($allowuseradd){
		echo "	 - [ <a href='modules.php?name=$module_name&amp;file=addmap'>"._SUBMITMAP."</a> ]\n";
	}
	if ($allowgroupdl) {
		if (is_user($user) or ($allowanon == 1)){
		echo "	 - [ <a href='modules.php?name=$module_name&amp;file=group'>"._GROUPDOWNLOAD."</a> ]\n";
		}
	}
	echo "	 - [ <a href='modules.php?name=Maps&amp;file=mapsearch'>"._SEARCH."</a> ]";
	echo "</center>\n"
		."\n<!--End Maps Nav Bar-->\n\n";
	CloseTable();
	echo "<br>";
}

function ratingimg($rating){
	global $module_name;
    if((($rating >= 0)or($rating == 0)) && ($rating <= 0.50)){
        //echo "<img src='modules/$module_name/images/ratings/0-0-5.gif' title='$rating "._OUTOF." 5'>\n";
		echo "<strong>"._NOTYETRATED."</strong>\n";
    }
    if((($rating >= 0.50)or($rating == 0.50)) && ($rating <= .99)){
        echo "<img src='modules/$module_name/images/ratings/0-5-5.gif' title='$rating "._OUTOF." 5'>\n";
    }
    if((($rating >= 1.00)or($rating == 1.50)) && ($rating <= 1.49)){
        echo "<img src='modules/$module_name/images/ratings/1-0-5.gif' title='$rating "._OUTOF." 5'>\n";
    }
    if((($rating >= 1.50)or($rating == 1.50)) && ($rating <= 1.99)){
        echo "<img src='modules/$module_name/images/ratings/1-5-5.gif' title='$rating "._OUTOF." 5'>\n";
    }
    if((($rating >= 2.00)or($rating == 2.00)) && ($rating <= 2.49)){
        echo "<img src='modules/$module_name/images/ratings/2-0-5.gif' title='$rating "._OUTOF." 5'>\n";
    }

    if((($rating >= 2.50)or($rating == 2.50)) && ($rating <= 2.99)){
        echo "<img src='modules/$module_name/images/ratings/2-5-5.gif' title='$rating "._OUTOF." 5'>\n";
    }

    if((($rating >= 3.00)or($rating == 3.00)) && ($rating <= 3.49)){
        echo "<img src='modules/$module_name/images/ratings/3-0-5.gif' title='$rating "._OUTOF." 5'>\n";
    }

    if((($rating >= 3.50)or($rating == 3.50)) && ($rating <= 3.99)){
        echo "<img src='modules/$module_name/images/ratings/3-5-5.gif' title='$rating "._OUTOF." 5'>\n";
    }
    if((($rating >= 4.00)or($rating == 4.00)) && ($rating <= 4.49)){
        echo "<img src='modules/$module_name/images/ratings/4-0-5.gif' title='$rating "._OUTOF." 5'>\n";
    }
    if((($rating >= 4.50)or($rating == 4.50)) && ($rating <= 4.99)){
        echo "<img src='modules/$module_name/images/ratings/4-5-5.gif' title='$rating "._OUTOF." 5'>\n";
    }
    if($rating == 5.0){
        echo "<img src='modules/$module_name/images/ratings/5-0-5.gif' title='$rating "._OUTOF." 5'>\n";
    }
}

function isurl($url){
	if (eregi("^((http|https|ftp)://)([[:alnum:]-])+(\.)([[:alnum:]-]){2,4}([[:alnum:]/+=%&_.~?-]*)$", $url)){
		return TRUE;
	}else{
		return FALSE;
	}
}

function upfile($updir, $fname){
	global $db, $prefix, $admin;
	$cr1 = $db->sql_query("SELECT mval FROM ".$prefix."_mapconfig where mname='a_ftypes'");
		list($allowftypes) = $db->sql_fetchrow($cr1);
	if (is_uploaded_file($_FILES["$fname"]['tmp_name']) && ($_FILES["$fname"]["size"]  >= 0)){
		$upfilename = preg_replace('/[^a-z0-9_\-\.]/i', '_', $_FILES["$fname"]['name']);
		$ext = substr(strrchr("$upfilename", '.'), 1);
		$ech = explode(", ", $allowftypes);
		
		if (in_array($ext, $ech)){
			if (is_admin($admin)){
				if (file_exists($updir."/".$upfilename)){
					$rand = "copy-";
				}
			}else{
				$rand = substr(md5(uniqid(rand(), 1)), 1, 5)."-";
			}
			if (move_uploaded_file($_FILES["$fname"]['tmp_name'], $updir."/".$rand.$upfilename)){
			}else{
				echo _ERROROCCURED." - 001 <br>"._GOBACK;
				CloseTable();
				@include("footer.php");
			}
		}else{
			echo "<b>".$_FILES["$fname"]['name']."</b> "._BADFILETYPE."<br><br>"._GOBACK;
			CloseTable();
			@include("footer.php");
		}
	}else{
		echo _ERROROCCURED." - 002 <br>"._GOBACK;
		CloseTable();
		@include("footer.php");
	}
	
	if (file_exists($updir."/".$rand.$upfilename)){
		echo "<b>".$_FILES["$fname"]['name']."</b> "._FILEUPLOADED."<br>";
	} else {
		echo "<b>".$_FILES["$fname"]['name']."</b> "._FILENOTUPLOADED."<br>"._GOBACK;
		CloseTable();
		@include("footer.php");
	}
	return $rand.$upfilename;
}

function getfilesize($bytes) {
	if ($bytes >= 1048576) {
		$return = round($bytes / 1024 / 1024, 2);
		$suffix = "MB";
	} elseif ($bytes >= 1024) {
		$return = round($bytes / 1024, 2);
		$suffix = "KB";
	} elseif ($bytes == 0) {
		$return = _UNKNOWN;
	} else {
		$return = $bytes;
		$suffix = "Bytes";
	}
	
	return $return." ".$suffix;
}

function getparent($mainid, $title) {
	global $prefix, $db;
	$mainid = intval(trim($mainid));
	$row = $db->sql_fetchrow($db->sql_query("SELECT * from " . $prefix . "_mapcat where id='$mainid'"));
	$catid = intval($row['id']);
	$ptitle = $row['title'];
	$mmainid = intval($row['mainid']);
	if ($ptitle == "$title") {
		$title = $title;
    }else{
		if($ptitle != "") {
			$title = $ptitle." / ".$title;
		}
		if ($mmainid != 0) {
			$title = getparent($mmainid, $title);
		}
	}
	return $title;
}

function getparentlink($mainid,$title) {
	global $prefix, $db, $module_name;
	$mainid = intval($mainid);
	$row = $db->sql_fetchrow($db->sql_query("SELECT * from " . $prefix . "_mapcat where id='$mainid'"));
	$catid = intval($row['id']);
	$ptitle = $row['title'];
	$mmainid = intval($row['mainid']);
	if ($ptitle == "$title") $title = $title; 
	elseif ($ptitle != "") $title = "<a href=modules.php?name=$module_name&amp;cat=".ereg_replace(" ", "_", $ptitle)."&amp;id=$catid>$ptitle</a>--&gt;".$title;
	if ($mmainid != 0) {
		$title = getparentlink($mmainid, $title);
	}
	return $title;
}

if ($_POST['addshot']){
	$ssdir = "modules/$module_name/ss";
	$mapid = intval($_POST['mapid']);
	include("header.php");
	nav();
	OpenTable();

	if (!is_dir("$ssdir/$mapid")){
		mkdir("$ssdir/$mapid");
		chmod("$ssdir/$mapid", 0777);
		mkdir("$ssdir/$mapid/text");
		chmod("$ssdir/$mapid/text", 0777);
	}
	if ($_FILES['ssfile']['name'] != ""){
		$shot = upfile("$ssdir/$mapid", "ssfile");
	}else{
		echo ""._DIDNT_UP."";
	}
	
	$ext = substr(strrchr("$shot", '.'), 0);
	$txtfile = ereg_replace($ext, "", $shot);
	
	if ($_POST['notes']){
		
		$handle = fopen("$ssdir/$mapid/text/$txtfile.txt", 'a');
		fwrite($handle, $_POST['notes']);
		fclose($handle);
	}
	CloseTable();
	include("footer.php");
}

?>