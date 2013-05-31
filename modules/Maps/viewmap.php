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
$title = check_html(stripslashes(ereg_replace("_", " ", $title)), 'nohtml');
$pagetitle = "- "._MAPS." - $title";

$id = intval($_GET['id']);
@include("header.php");
@include("modules/$module_name/functions.php");

$cr = $db->sql_query("SELECT mval FROM ".$prefix."_mapconfig where mname='m_img'");
	list($mapimagedir) = $db->sql_fetchrow($cr);
$cra = $db->sql_query("SELECT mval FROM ".$prefix."_mapconfig where mname='m_thumbw'");
	list($maptw) = $db->sql_fetchrow($cra);
$crb = $db->sql_query("SELECT mval FROM ".$prefix."_mapconfig where mname='m_thumbh'");
	list($mapth) = $db->sql_fetchrow($crb);
$crc = $db->sql_query("SELECT mval FROM ".$prefix."_mapconfig where mname='a_rate'");
	list($allowratings) = $db->sql_fetchrow($crc);

nav();
OpenTable();

echo "\n<!--view map-->\n\n";
$result = $db->sql_query("SELECT * FROM ".$prefix."_mapmap where mapid='$id'");
$row = $db->sql_fetchrow($result);
	$mapid = intval($row['mapid']);
	$mapcat = intval($row['cat']);
	$maptitle = stripslashes($row['title']);
	$mapdtl = stripslashes(html_entity_decode($row['details'], ENT_QUOTES));
	$mapauth = stripslashes($row['author']);
	$mapauthe = stripslashes($row['authemail']);
	$maprec = stripslashes($row['recplayers']);
	$mapimage = stripslashes($row['image']);
	$mapfile = stripslashes($row['mapfile']);
	$maphits = intval($row['hits']);
	$filesize = getfilesize(intval($row['filesize']));
if (empty($mapdtl)){
	$mapdtl = "&nbsp;";
}

$result = $db->sql_query("SELECT * FROM ".$prefix."_mapvotes where mapid='$mapid'");
$row = $db->sql_fetchrow($result);
$rating = $row['rating'];
$totalvotes = $row['totalvotes'];
$catheadtitle = getparentlink($mapcat, $cat);
echo "<table width='100%' cellpadding='4' cellspacing='2' border='0'>\n"
	."<tr><td colspan='3' bgcolor='$bgcolor2'><strong><a href='modules.php?name=$module_name'>"._MAIN."</a>--&gt;$catheadtitle</strong>&nbsp;</td></tr>"
	."<tr>\n"
	."<td rowspan='2' width='20%' align='center' valign='top' bgcolor='$bgcolor2'>\n";
if (!isurl($mapimage)){
	echo "<a href='#' title='$maptitle' onClick=\"pop=window.open('$mapimagedir/$mapimage','pop','width=800,height=600,top=50,left=50,status,scrollbars,resizable');\">\n"
		."<img src='$mapimagedir/thumb/$mapimage' alt='$maptitle' width='$maptw' height='$mapth' border='1'></a>\n";
}else{
	echo "<a href='#' title='$maptitle' onClick=\"pop=window.open('$mapimage','pop','width=800,height=600,top=50,left=50,status,scrollbars,resizable');\">\n"
		."<img src='$mapimage' alt='$maptitle' width='$maptw' height='$mapth' border='1'></a>\n";
}

echo "</td>\n"
	."<td colspan='2' height='10%' valign='top'>\n"
	."<font class='title'>&raquo; $maptitle</font>\n"
	."</td>\n"
	."</tr>\n"
        ."<tr>\n"
	."<td valign='top'>"
	."<blockquote>\n"
	."<font class='content'>".ereg_replace("\n", "<br>", $mapdtl)."</font>"
	."</blockquote>\n"
	."</td><td rowspan='2'>";
	if (is_admin($admin)){
		echo "<form action='modules.php?name=$module_name&amp;file=functions' method='post' enctype='multipart/form-data'>\n";
		echo "<table width='100%' cellspacing='2' cellpadding='4' border='0'>\n"
			."<tr><td colspan='2' bgcolor='$bgcolor2'>"._UPLOADADD."</td></tr>"
			."<tr>\n"
			."<td valign='top'>\n"
			."<b>"._IMAGE." :*</b>\n"
			."</td>\n"
			."<td>\n"
			."<input type='file' size='25' name='ssfile'>\n"
			."</td>\n"
			."</tr>\n"
			."<tr>\n"
			."<td valign='top'>\n"
			."<b>"._DETAILS." :</b>\n"
			."</td>\n"
			."<td>\n"
			."<textarea name='notes' cols='35' rows='6' wrap='virtual'></textarea>\n"
			."</td>\n"
			."</tr>\n"
			."<tr>\n"
			."<td>\n"
			."&nbsp;\n"
			."</td>\n"
			."<td>\n"
			."<input type='hidden' name='mapid' value='$mapid'>\n"
			."<input type='submit' name='addshot' value='"._ADD."'>"
			."</td>\n"
			."</tr>\n"
			."</table>\n"
			."</form>\n";
	}else{
		echo "&nbsp;";
	}

	echo "</td>\n"
	."</tr>\n"
	."<tr>\n"
	."<td align='center' valign='top'>\n";
if ($allowratings == 1){
	ratingimg($rating);
	if ($totalvotes > 0){
		echo "<br>"._TOTALVOTES." -&raquo; <strong>$totalvotes</strong>";
	}
}else{
	echo "&nbsp;";
}

echo "<br><br>";

if (is_user($user) && $allowratings == 1){
$result2 = $db->sql_query("SELECT * FROM ".$prefix."_mapcat where id='$mapcat'");
$row = $db->sql_fetchrow($result2);
	$cattitle = stripslashes($row['title']);
	$catid = intval($row['id']);
	echo "<form action='modules.php?name=$module_name&amp;file=ratemap' method='post'>\n"
		."<font class='content'>"._RATEMAP."</font><br>\n"
		."<select name='rated'>\n"
		."<option value='5.0' selected>5</option>\n"
		."<option value='4.0'>4</option>\n"
		."<option value='3.0'>3</option>\n"
		."<option value='2.0'>2</option>\n"
		."<option value='1.0'>1</option>\n"
		."<option value='0.0'>0</option>\n"
		."</select>\n"
		."<input type='hidden' name='cattitle' value='$cattitle'>\n"
		."<input type='hidden' name='catid' value='$catid'>\n"
		."<input type='hidden' name='maptitle' value='$maptitle'>\n"
		."<input type='hidden' name='mapcat' value='$mapcat'>\n"
		."<input type='hidden' name='mapid' value='$mapid'>\n"
		."<input type='submit' name='submit' value='Vote'>\n"
		."</form>\n";
}else{
	echo "&nbsp;";
}
	echo "</td>\n"
	."<td valign='top'>\n"
	.""._FILESIZE." -&raquo; <strong>$filesize</strong><br>\n"
	.""._DOWNLOADS." -&raquo; <strong>$maphits</strong><br>\n";
	if (!empty($mapauth)){
		echo ""._AUTHOR." -&raquo; <strong>$mapauth</strong><br>\n";
	}
	if (!empty($mapauthe)){
		echo ""._AUTHORE." -&raquo; <strong>$mapauthe</strong><br>\n";
	}
	if (!empty($maprec)){
		echo ""._RECPLAYERS." -&raquo; <strong>$maprec</strong><br><br>\n";
	}
	echo "</td>\n"
	."\n"
	."</tr>\n"
	."</table><hr>\n"
	."<form action='modules.php?name=$module_name&amp;file=downloadmap' method='post'>\n"
	."<input type='hidden' name='id' value='$mapid'>\n"
	."<center><input type='submit' value='"._DOWNLOAD." $maptitle'></center>\n"
	."</form>\n"
	."<!--end view map-->\n\n";
Closetable();
echo "<br />";

$ssdir = "modules/$module_name/ss";
if (is_dir("$ssdir/$mapid")){
	OpenTable();
	$handle = opendir("$ssdir/$mapid");
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
	
	echo "<table width='100%' cellspacing='4' cellpadding='4'><tr bgcolor='$bgcolor2'><td colspan='2'><font class='title'>"._ADDITIONAL." $maptitle "._SCREEN."</font></td></tr>
	        <tr>\n";
	
	$n = 0;
	for ($i = 0; $i < sizeof($tlist); $i++){
		if($tlist[$i] != "") {
			$ext = substr(strrchr($tlist[$i], '.'), 0);
			$txtfile = ereg_replace($ext, "", $tlist[$i]);
			if (file_exists("$ssdir/$mapid/text/$txtfile.txt")){
				$handle = fopen("$ssdir/$mapid/text/$txtfile.txt", "r");
				$txt[$i] = fread($handle, filesize("$ssdir/$mapid/text/$txtfile.txt"));
				fclose($handle);
			
			}
			if ($n == 3){ echo "</tr><tr>\n"; $n = 0;}
			echo "<td width='33%' align='center' valign='top'>\n"
			."<a href='#' title='".$tlist[$i]."' onClick=\"winname=window.open('$ssdir/$mapid/".$tlist[$i]."','winname','width=800,height=600,top=50,left=50,status,scrollbars,resizable');\">\n"
			."<img src='$ssdir/$mapid/".$tlist[$i]."' alt='' width='120' height='90' border='0'></a><br>\n"
			.ereg_replace("\n", "<br>", $txt[$i])
			."</td>\n";
			$n++;
		}
	}
	echo "</tr></table>\n";
	CloseTable();
	echo "<br />";
}

OpenTable();
$reviews = $_GET['reviews'];
if(!isset($reviews)){
	$reviews = 1;
}
$reviews = intval($reviews);
$from = intval(($reviews * 5) - 5);
echo "
<table width='100%'>
<tr>
<td colspan='2'><font class='title'>"._MAPREVIEWS."</font></td><td>";
$crd = $db->sql_query("SELECT mval FROM ".$prefix."_mapconfig where mname='a_review'");
list($allowreview) = $db->sql_fetchrow($crd);
if(is_user($user) && $allowreview == 1){
	echo "<a href='modules.php?name=$module_name&amp;file=reviewmap&amp;id=$id'>"._WRITEREVIEW."</a></td>";
}else{
	echo "&nbsp;";
}
echo "</tr>
<tr bgcolor='$bgcolor2'>
<td width='10%'>"._REVIEWER."</td><td width='10%'>"._REVIEWDATE."</td><td width='80%'>"._REVIEW."</td>
</tr>";
$result = $db->sql_query("SELECT * FROM ".$prefix."_mapreviews WHERE rapprove='1' AND rmapid='$id' LIMIT $from, 5");
$results = $db->sql_numrows($result);
if ($results > 0) {
	while ($row = $db->sql_fetchrow($result)){
		$ruser = $row['ruserid'];
		$rdate = $row['rdate'];
		$review = $row['review'];
		$approved = $row['rapprove'];
		$result2 = $db->sql_query("SELECT * FROM ".$prefix."_users WHERE user_id='$ruser'");
		$user = $db->sql_fetchrow($result2);
		$username = $user['username'];
		echo "<tr>
	     		<td>$username</td><td>$rdate</td><td>$review</td>";
		      echo "</tr>";
	} 
}

$links = $db->sql_query("SELECT * FROM ".$prefix."_mapreviews where rmapid='$id'");
$total_results = $db->sql_numrows($links);
$total_pages = ceil($total_results / 5);
if ($total_pages != 1){
	echo "<!--page numbering-->\n\n";
	echo "\n<tr><td colspan='3'><center>\n";
	if($reviews > 1){
		$prev = ($reviews - 1);
		echo "<a href='modules.php?name=$module_name&amp;file=viewmap&amp;title=$maptitle&amp;id=$id&amp;reviews=$prev'>\n"
			."<img src='modules/$module_name/images/left.gif' alt='"._PREV."' border='0'></a>&nbsp;&nbsp;\n";
	}

	for($i = 1; $i <= $total_pages; $i++){
		if(($reviews) == $i){
			echo "<b><i>$i</i></b>\n";
		}else{
			echo "<a href='modules.php?name=$module_name&amp;file=viewmap&amp;title=$maptitle&amp;id=$id&amp;reviews=$i'><b>$i</b> </a>\n";
		}
	}
	if($reviews < $total_pages){
		$next = ($reviews + 1);
		echo "<a href='modules.php?name=$module_name&amp;file=viewmap&amp;title=$maptitle&amp;id=$id&amp;reviews=$next'>\n"
			."<img src='modules/$module_name/images/right.gif' alt='"._NEXT."' border='0'></a>\n";
	}
	echo "</center></td></tr>\n"
		."<!--end page numbering-->\n\n";
}

echo "</table>";
CloseTable();

@include("footer.php");
?>