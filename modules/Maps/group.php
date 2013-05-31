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
$pagetitle = "- $module_name - "._GROUPDOWNLOAD;

$cr1 = $db->sql_query("SELECT mval FROM ".$prefix."_mapconfig where mname='a_group'");
	list($allowgroupdl) = $db->sql_fetchrow($cr1);
$cr2 = $db->sql_query("SELECT mval FROM ".$prefix."_mapconfig where mname='s_limit'");
	list($selectlimit) = $db->sql_fetchrow($cr2);
$cr3 = $db->sql_query("SELECT mval FROM ".$prefix."_mapconfig where mname='temp'");
	list($tempdir) = $db->sql_fetchrow($cr3);
$cr4 = $db->sql_query("SELECT mval FROM ".$prefix."_mapconfig where mname='m_file'");
	list($mapfiledir) = $db->sql_fetchrow($cr4);
$cr5 = $db->sql_query("SELECT mval FROM ".$prefix."_mapconfig where mname='a_rate'");
	list($allowratings) = $db->sql_fetchrow($cr5);
$cr6 = $db->sql_query("SELECT mval FROM ".$prefix."_mapconfig where mname='a_anon'");
	list($allowanon) = $db->sql_fetchrow($cr6);

if ($allowgroupdl == 0){
	@include("header.php");
	OpenTable();
	echo _GROUPDLDISABLED;
	CloseTable();
	@include("footer.php");
} elseif (is_user($user) or ($allowanon == 1)){
	if ($_POST['submit']){
		if (count($group) > 0){
			if(count($group) <= $selectlimit){
				foreach ($group as $key => $value){
					$result = $db->sql_query("SELECT mapfile FROM ".$prefix."_mapmap where mapid='$value'");
					$row = $db->sql_fetchrow($result);
					$mapfile .= $row['mapfile']." ";
				}
				$time = time();
				@system("tar -czf $tempdir/$time-group.tar.gz --directory $mapfiledir $mapfile");
				Header ("Location: $tempdir/$time-group.tar.gz");
			}else{
				@include("header.php");
				OpenTable();
				echo "<center>"._TOOMANYFILES." $selectlimit<br><br>"._GOBACK."</center>";
				CloseTable();
				@include("footer.php");
			}
		}else{
			@include("header.php");
			OpenTable();
			echo "<center>"._NOSELFILES."<br><br>"._GOBACK."</center>";
			CloseTable();
			@include("footer.php");
		}	
	}else{
		@include("header.php");
		@include("modules/$module_name/functions.php");
		
		$now = time();
		$handle = @opendir("./$tempdir");
		while ($file = @readdir($handle)){
			if ($file != "." && $file != ".."){
				if (strrpos($file, ".")){
					$tlist .= "$file ";
				}
			}
		}
		@closedir($handle);
		$tlist = explode(" ", $tlist);
		sort($tlist);
		for ($i = 0; $i < sizeof($tlist); $i++){
			if ($tlist[$i] != "") {
				$ftime = str_replace("-group.tar.gz", "", $tlist[$i]);
				if (($now - 600) >= $ftime){
					@unlink($tempdir."/".$tlist[$i]);
				}
			}
		}
		nav();
		OpenTable();
		$result = $db->sql_query("SELECT * FROM ".$prefix."_mapmap ORDER BY 'cat' ASC, 'title' ASC");
		echo "<form action='modules.php?name=$module_name&amp;file=group' method='post'>\n"
			."<table width='100%' border='1' cellpadding='2' cellspacing='1'>\n"
			."<tr>\n"
			."<td>\n"
			."&nbsp;\n"
			."</td>\n"
			."<td>\n"
			."<strong>"._MAPTITLE."</strong>\n"
			."</td>\n"
			."<td>\n"
			."<strong>"._MAPCAT."</strong>\n"
			."</td>\n";
		if ($allowratings == 1){
			echo "<td>\n"
				."<strong>"._RATING."</strong>\n"
				."</td>\n";
		}
		echo "</tr>\n";
			$i = 0;
		while($row = $db->sql_fetchrow($result)){
			$mapid = intval($row['mapid']);
			$mapcat = intval($row['cat']);
			$maptitle = stripslashes($row['title']);
			$mapdtl = stripslashes($row['details']);
			$maptitlett = ereg_replace(" ", "_", $maptitle);
			$mapfile = $row['mapfile'];
			$cattitle = getparentlink($mapcat, "");
			if ($cattitle == ""){
				$cattitle = _MAIN;
			}else{
				$cattitle = substr($cattitle, 0, -2);
			}
			$bg = ($i % 2) ? "" : "bgcolor='$bgcolor2'";

			if (!isurl($mapfile)){
				echo "<tr $bg>\n"
					."<td width='5%'>\n"
					."<input type='checkbox' name='group[]' value='$mapid'>\n"
					."</td>\n"
					."<td width='35%' valign='top'>\n"
					."<a href='modules.php?name=$module_name&amp;file=viewmap&amp;title=$maptitlett&amp;id=$mapid'>$maptitle</a>\n"
					."</td>\n"
					."<td width='35%' valign='top'>\n"
					."$cattitle\n"
					."</td>\n";
				if ($allowratings == 1){
					echo "<td width='25%' valign='top'>\n";
					$result2 = $db->sql_query("SELECT * FROM ".$prefix."_mapvotes where mapid='$mapid'");
					$row2 = $db->sql_fetchrow($result2);
					$rating = $row2['rating'];
					ratingimg($rating);
					echo "</td>\n";
				}
				echo "</tr>\n";
				$i++;
			}
		}
		echo "</table><br>\n"
			."<center><input type='submit' name='submit' value='Download Selected'></center>\n"
			."</form>\n\n";
		CloseTable();
		@include("footer.php");
	}
} else {
	@include("header.php");
	OpenTable();
	echo _MUSTBEREGISTERED;
	CloseTable();
	@include("footer.php");
}
?>