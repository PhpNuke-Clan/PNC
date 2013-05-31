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
if (!isset($_GET['id'])){
	$id = "0";
	$cat = _MAIN;
}else{
	$id = intval($_GET['id']);
	$cat = $_GET['cat'];
}
$cat = check_html(stripslashes(str_replace("_", " ", $cat)), nohtml);
$pagetitle = "- $module_name - $cat";

@include("header.php");
@include("modules/$module_name/functions.php");

nav();

if ($id == 0){
$result = $db->sql_query("SELECT * FROM ".$prefix."_mapcat where mainid='$id' ORDER BY 'title' ASC");
$num = $db->sql_numrows($result);
	$cr1 = $db->sql_query("SELECT mval FROM ".$prefix."_mapconfig where mname='c_img'");
	list($catimagedir) = $db->sql_fetchrow($cr1);
	$cr1a = $db->sql_query("SELECT mval FROM ".$prefix."_mapconfig where mname='c_thumbw'");
	list($cattw) = $db->sql_fetchrow($cr1a);
	$cr1b = $db->sql_query("SELECT mval FROM ".$prefix."_mapconfig where mname='c_thumbh'");
	list($catth) = $db->sql_fetchrow($cr1b);
	OpenTable();
	echo "\n<!--show categorys -->\n\n"
		."<table width='100%' cellpadding='4'>\n";
	while($row = $db->sql_fetchrow($result)) {
		$catid = intval($row['id']);
		$cattitle = stripslashes($row['title']);
		$catdtl = stripslashes(html_entity_decode($row['details'], ENT_QUOTES));
		$catimage = stripslashes($row['image']);
		$mainid = intval($row['mainid']);
		$cattitlett = str_replace(" ", "_", $cattitle);
		$mapincat = $db->sql_numrows($db->sql_query("SELECT * FROM ".$prefix."_mapmap where cat='$catid'"));
		$mapsincat = $db->sql_numrows($mapinscat);
		$numcat = $db->sql_query("SELECT * FROM ".$prefix."_mapcat where mainid='$catid' ORDER BY 'title' ASC");
		$numcats = $db->sql_numrows($numcat);
		
		$show_cat_image = (isurl($catimage)) ? $catimage : $catimagedir."/".$catimage;
		
		echo "<tr bgcolor='$bgcolor2'><td colspan='3'><font class='title'><strong>&raquo; $cattitle</strong></font></td></tr><tr><td valign='top' width='$cattw' rowspan='2' bgcolor='$bgcolor2'>\n"
			."<center>\n"
			."<a href='modules.php?name=$module_name&amp;cat=$cattitlett&amp;id=$catid'>\n"
			."<img src='$show_cat_image' alt='$cattitle' width='$cattw' height='$catth' border='1'></a><br>$mapsincat ";
		if ($mapsincat == 1) {
		echo ""._MAP." ";
			}else{
		echo ""._MAPS." ";
			}
		echo "<br>$numcats ";
		if ($numcats == 1) {
		echo ""._SUBCAT." ";
			}else{
		echo ""._SUBCATS." ";
			}
		echo "</td><td bgcolor='$bgcolor2' height='10' colspan='2'>";
			if ($mapsincat == 0 && $numcats == 0){
				echo ""._NOMAPS."&nbsp;</td></tr>
				      <tr>
				        <td colspan='2'>$catdtl</td>
				      <tr>
				      <tr>
				        <td colspan='3'>&nbsp;</td>
				      </tr>\n";
			}elseif ($numcats == 0){
				echo "&nbsp;</td></tr>
				      <tr>
				        <td colspan='2'>$catdtl</td>
				      <tr>
				      <tr>
				        <td colspan='3'>&nbsp;</td>
				      </tr>\n";
			}else{
				echo "<strong>"._SUBCATS."-</strong>\n</td>
					</tr>
					<tr>
					  <td valign='top' width='20%' bgcolor='$bgcolor2'>";
					  while($subcats = $db->sql_fetchrow($numcat)) {
						  $subcatid = intval($subcats['id']);
						  $subcat = stripslashes($subcats['title']);
						  $subcatname = str_replace(" ", "_", $subcat);
						  $subcatmap = $db->sql_query("SELECT * FROM ".$prefix."_mapmap where cat='$subcatid'");
						  $subcatmaps = $db->sql_numrows($subcatmap);
						  echo "<br>&raquo; <a href='modules.php?name=$module_name&amp;cat=$subcatname&amp;id=$subcatid'><strong>$subcat</strong></a>";
						  if ($subcatmaps == 0){
							  echo "&nbsp;";
						  }else{
							  echo "&nbsp;&nbsp;&nbsp;- $subcatmaps ";
                                                          if ($subcatmaps == 1) {
	                                                  	echo ""._MAP." ";
		                                           	}else{
	                                             	echo ""._MAPS." ";
		                                      	}
						  }
					  }
					  echo "</td><td>$catdtl<br></td></tr>
					       <tr>
					         <td colspan='3'>&nbsp;</td>
						 </tr>\n";
			}
		$i++;
	}
	echo "</table>\n";
	echo "\n<!--end show categorys -->\n\n";
	CloseTable();
}

$result = $db->sql_query("SELECT * FROM ".$prefix."_mapcat where id='$id'");
$num = $db->sql_numrows($result);
if ($num > 0) {
	$cr1 = $db->sql_query("SELECT mval FROM ".$prefix."_mapconfig where mname='c_img'");
	list($catimagedir) = $db->sql_fetchrow($cr1);
	$cr1a = $db->sql_query("SELECT mval FROM ".$prefix."_mapconfig where mname='c_thumbw'");
	list($cattw) = $db->sql_fetchrow($cr1a);
	$cr1b = $db->sql_query("SELECT mval FROM ".$prefix."_mapconfig where mname='c_thumbh'");
	list($catth) = $db->sql_fetchrow($cr1b);
	OpenTable();
	echo "\n<!--show categorys -->\n\n"
		."<table width='100%' cellpadding='4'>\n";
	while($row = $db->sql_fetchrow($result)) {
		$catid = intval($row['id']);
		$cattitle = stripslashes($row['title']);
		$catdtl = stripslashes(html_entity_decode($row['details'], ENT_QUOTES));
		$catimage = stripslashes($row['image']);
		$mainid = intval($row['mainid']);
		$cattitlett = str_replace(" ", "_", $cattitle);
		$mapincat = $db->sql_numrows($db->sql_query("SELECT * FROM ".$prefix."_mapmap where cat='$catid'"));
		$mapsincat = $db->sql_numrows($mapinscat);
		$numcat = $db->sql_query("SELECT * FROM ".$prefix."_mapcat where mainid='$catid' ORDER BY 'title' ASC");
		$numcats = $db->sql_numrows($numcat);
		echo "<tr bgcolor='$bgcolor2'><td colspan='3'><strong>&raquo;&nbsp;<a href='modules.php?name=$module_name'>"._MAIN."</a>&nbsp;--&gt;";
	        $catheadtitle = getparentlink($catid, $cattitle);
                
                $show_cat_image = (isurl($catimage)) ? $catimage : $catimagedir."/".$catimage;

                echo "$catheadtitle</strong></td></tr><tr><td valign='top' width='$cattw' rowspan='2' bgcolor='$bgcolor2'>\n"
			."<center>\n"
			."<a href='modules.php?name=$module_name&amp;cat=$cattitlett&amp;id=$catid'>\n"
			."<img src='$show_cat_image' alt='$cattitle' width='$cattw' height='$catth' border='1'></a><br>$mapsincat ";
		if ($mapsincat == 1) {
		echo ""._MAP." ";
			}else{
		echo ""._MAPS." ";
			}
		echo "<br>$numcats ";
		if ($numcats == 1) {
		echo ""._SUBCAT." ";
			}else{
		echo ""._SUBCATS." ";
			}
		echo "</td><td bgcolor='$bgcolor2' height='10' colspan='2'>";
			if ($numcats == 0){
				echo "&nbsp;</td></tr>
				      <tr>
				        <td colspan='2'>$catdtl</td>
				      <tr>
				      <tr>
				        <td colspan='3'>&nbsp;</td>
				      </tr>\n";
			}else{
				echo "<strong>"._SUBCATS."-</strong>\n</td>
					</tr>
					<tr>
					  <td valign='top' width='20%' bgcolor='$bgcolor2'>";
					  while($subcats = $db->sql_fetchrow($numcat)) {
						  $subcatid = intval($subcats['id']);
						  $subcat = stripslashes($subcats['title']);
						  $subcatname = str_replace(" ", "_", $subcat);
						  $subcatmap = $db->sql_query("SELECT * FROM ".$prefix."_mapmap where cat='$subcatid'");
						  $subcatmaps = $db->sql_numrows($subcatmap);
						  echo "<br>&raquo; <a href='modules.php?name=$module_name&amp;cat=$subcatname&amp;id=$subcatid'>$subcat</a>";
						  if ($subcatmaps == 0){
							  echo "&nbsp;";
						  }else{
							  echo "- $subcatmaps ";
                                                          if ($subcatmaps == 1) {
	                                                  	echo ""._MAP." ";
		                                           	}else{
	                                             	        echo ""._MAPS." ";
	                                              		}
						  }
					  }
					  echo "</td><td>$catdtl<br></td></tr>
					       <tr>
					         <td colspan='3'>&nbsp;</td>
						 </tr>\n";
			}
		$i++;
	}
	echo "</table>\n";
	echo "\n<!--end show categorys -->\n\n";
	CloseTable();
	echo "<br>";
}



$page = $_GET['page'];
if(!isset($page)){
	$page = 1;
}
$cr2 = $db->sql_query("SELECT mval FROM ".$prefix."_mapconfig where mname='m_page'");
	list($maps_page) = $db->sql_fetchrow($cr2);
$page = intval($page);
$maps_page = trim($maps_page);
$from = intval(($page * $maps_page) - $maps_page);
$result2 = $db->sql_query("SELECT * FROM ".$prefix."_mapmap where cat='$id' ORDER BY 'title' ASC LIMIT $from, $maps_page");
$num2 = $db->sql_numrows($result2);
if ($num2 > 0) {
	$cr3 = $db->sql_query("SELECT mval FROM ".$prefix."_mapconfig where mname='m_img'");
	list($mapimagedir) = $db->sql_fetchrow($cr3);
	$cr3a = $db->sql_query("SELECT mval FROM ".$prefix."_mapconfig where mname='m_thumbw'");
	list($maptw) = $db->sql_fetchrow($cr3a);
	$cr3b = $db->sql_query("SELECT mval FROM ".$prefix."_mapconfig where mname='m_thumbh'");
	list($mapth) = $db->sql_fetchrow($cr3b);
	$cr3c = $db->sql_query("SELECT mval FROM ".$prefix."_mapconfig where mname='a_rate'");
	list($allowratings) = $db->sql_fetchrow($cr3c);
	$cr3d = $db->sql_query("SELECT mval FROM ".$prefix."_mapconfig where mname='d_limit'");
	list($desclimit) = $db->sql_fetchrow($cr3d);
	OpenTable();
	echo "<!--show maps-->\n";
	echo "<table width='100%' cellpadding='4'>\n";
	$n = 0;
	while ($row2 = $db->sql_fetchrow($result2)){
		$mapid = intval($row2['mapid']);
		$maptitle = stripslashes($row2['title']);
		$mapdtl = stripslashes(html_entity_decode($row2['details'], ENT_QUOTES));
		$mapimage = stripslashes($row2['image']);
		$mapfile = stripslashes($row2['mapfile']);
		$maphits = intval($row2['hits']);
		$filesize = getfilesize(intval($row2['filesize']));
		$maptitlett = str_replace(" ", "_", $maptitle);
		if (strlen($mapdtl) > $desclimit){
			$mapdtls = substr($mapdtl, 0, $desclimit)."<br>... ( <a href='modules.php?name=$module_name&amp;file=viewmap&amp;title=$maptitlett&amp;id=$mapid'>"._MORE."</a> )\n";
		}else{
			$mapdtls = "$mapdtl";
		}
		if ($mapdtls == ""){
			$mapdtls = "&nbsp;";
		}
		$result = $db->sql_query("SELECT * FROM ".$prefix."_mapvotes where mapid='$mapid'");
		$row = $db->sql_fetchrow($result);
		$rating = $row['rating'];
		$totalvotes = $row['totalvotes'];
		if ($n == 0) {
			echo "<tr>\n";
		}
		echo "<td valign='top' width='50%'>\n";
		echo "<table width='100%' cellpadding='4' cellspacing='2'>\n"
			."<tr>\n"
			."<td rowspan='2' width='25%' align='center' valign='top' bgcolor='$bgcolor2'>\n";
		if (!isurl($mapimage)){
			echo "<a href='#' title='$maptitle' onClick=\"winname=window.open('$mapimagedir/$mapimage','winname','width=800,height=600,top=50,left=50,status,scrollbars,resizable');\">\n"
				."<img src='$mapimagedir/thumb/$mapimage' alt='$maptitle' width='$maptw' height='$mapth' border='1'></a>\n";
		}else{
			echo "<a href='#' title='$maptitle' onClick=\"winname=window.open('$mapimage','winname','width=800,height=600,top=50,left=50,status,scrollbars,resizable');\">\n"
				."	<img src='$mapimage' alt='$maptitle' width='$maptw' height='$mapth' border='1'></a>\n";
		}
		echo "</td>\n"
			."<td colspan='2' width='75%' height='10%' valign='top' bgcolor='$bgcolor2'>\n"
			."<font class='title'>&raquo;</font> <a href='modules.php?name=$module_name&amp;file=viewmap&amp;title=$maptitlett&amp;id=$mapid' title='"._VIEW." $maptitle'><font class='title'>$maptitle</font></a>\n"
			."</td>\n"
			."</tr>\n"
			."<tr>\n"
			."<td colspan='2' width='75%' valign='top'>"
			."<blockquote>\n"
			."<font class='content'>".str_replace("\n", "<br>", $mapdtls)."</font>\n"
			."</blockquote>\n"
			."</td>\n"
			."</tr>\n"
			."<tr>\n"
			."<td width='25%' align='center' valign='top'>\n";
		if ($allowratings == 1){
			ratingimg($rating);
			if ($totalvotes > 0){
				echo "<br>"._TOTALVOTES." -&raquo; <strong>$totalvotes</strong>";
			}
		}else{
			echo "&nbsp;";
		}
		echo "</td>\n"
			."<td valign='top'>\n"
			.""._FILESIZE." -&raquo; <b>$filesize</b><br>\n"
			.""._DOWNLOADS." -&raquo; <b>$maphits</b>\n"
			."</td>\n"
			."<td width='40%'>\n";
		if (is_admin($admin)){
			echo "<form action='".$admin_file.".php' method='post'>\n"
				."<input type='hidden' name='op' value='editmap'>\n"
				."<input type='hidden' name='id' value='$mapid'>\n"
				."<input type='image' src='modules/$module_name/images/minimap.gif' title='"._EDIT." $maptitle' border='0'>\n"
				."</form>\n";
		}else{
			echo "&nbsp;";
		}
		echo "</td>\n"
			."</tr>\n"
			."</table>\n"
			."<form action='modules.php?name=$module_name&amp;file=downloadmap' method='post'>\n"
			."<input type='hidden' name='id' value='$mapid'>\n"
			."<center><input type='submit' value='"._DOWNLOAD." $maptitle'></center>\n"
			."<br>\n"
			."</form>\n"
			."</td>\n";
			$n++;
			if ($n == 2) {
				echo "</tr>\n";
				$n = 0;
			}
	}
  	if ($n == 1) {
		echo "<td>&nbsp;</td>\n"
		."</tr>\n";
	}
   echo "</table>\n";

   echo "<!--end show maps-->\n\n";	
        $result = $db->sql_query("SELECT * FROM ".$prefix."_mapmap where cat='$id'");
	$total_results = $db->sql_numrows($result);
	$total_pages = ceil($total_results / $maps_page);
	if ($total_pages != 1){
		echo "<!--page numbering-->\n\n";
		echo "<table align='center'>\n"
			."<tr>\n";
		if($page > 1){
			$prev = ($page - 1);
			echo "<td valign='top'>\n"
				."<a href='modules.php?name=$module_name&amp;cat=".str_replace(" ", "_", $cat)."&amp;id=$id&amp;page=$prev'>\n"
				."<img src='modules/$module_name/images/left.gif' alt='"._PREV."' border='0'></a>&nbsp;&nbsp;\n"
				."</td>\n";
		}

		for($i = 1; $i <= $total_pages; $i++){
			if(($page) == $i){
				echo "<td valign='top'>\n"
					."<b><i>$i</i></b>\n"
					."</td>\n";
			}else{
				echo "<td valign='top'>\n"
					."<a href='modules.php?name=$module_name&amp;cat=".str_replace(" ", "_", $cat)."&amp;id=$id&amp;page=$i'><b>$i</b> </a>\n"
					."</td>\n";
			}
		}
		if($page < $total_pages){
			$next = ($page + 1);
			echo "<td valign='top'>&nbsp;&nbsp;\n"
				."<a href='modules.php?name=$module_name&amp;cat=".str_replace(" ", "_", $cat)."&amp;id=$id&amp;page=$next'>\n"
				."<img src='modules/$module_name/images/right.gif' alt='"._NEXT."' border='0'></a>\n"
				."</td>\n";
		}
		echo "</tr>\n"
			."</table>\n"
			."<!--end page numbering-->\n\n";
	}
	CloseTable();
}

if ($id == 0){
	echo " ";
}elseif ($num == 0 && $num2 == 0){
	OpenTable();
	echo "<center>"._NOCATDATA."<br><br>"._GOBACK."<center>\n";
	CloseTable();
}
@include("footer.php");
?>