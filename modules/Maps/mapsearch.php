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
$pagetitle = "- $module_name - "._SEARCH_MAP."";

@include("modules/$module_name/functions.php");

if ($_POST['search_now']){
	$query = $_POST['text'];
	$query = htmlentities(stripslashes(check_html($query, "nohtml")), ENT_QUOTES);
	if ($_POST['intitle']){
		$place = "title LIKE '%$query%'";
	}elseif ($_POST['indetails']){
		$place = "details LIKE '%$query%'";
	}else{
		$place = "title LIKE '%$query%' OR details LIKE '%$query%'";
	}
	$q1 = $db->sql_query("SELECT * FROM ".$prefix."_mapmap WHERE ($place)");
	$num = $db->sql_numrows($q1);
	@include("header.php");
	nav();
	OpenTable();
	echo "<table width='100%'>
	        <tr>
		  <td colspan='3'><center><font class='title'>"._MAPRESULTS.":&nbsp;&nbsp;<em>$query</em></font></center></td>\n
		</tr>
		<tr bgcolor='$bgcolor2'>
		  <td>"._RESULT."</td><td>"._MAP."</td><td>"._CAT."</td>
		</tr>";
		if ($num > 0){
		$i=0;
		while($r1 = $db->sql_fetchrow($q1)){
			$i++;
			$mapid = intval($r1['mapid']);
			$maptitle = stripslashes($r1['title']);
			$catid = intval($r1['cat']);
			$q2 = $db->sql_query("SELECT * FROM ".$prefix."_mapcat WHERE id='$catid'");
			$row = $db->sql_fetchrow($q2);
			$cattitle = $row['title'];
			echo "<tr>
			        <td bgcolor='$bgcolor2' width='10%'> $i: </td><td><a href='modules.php?name=$module_name&amp;file=viewmap&amp;title=". ereg_replace(" ", "_", $maptitle)."&amp;id=$mapid' title=''>$maptitle</a><br></td><td><a href='modules.php?name=$module_name&amp;cat=$cattitle&amp;id=$catid'>$cattitle</td>
			      </tr>";
		}
	}else{
		echo _MAPNORESULTS;
	}
	echo "</table>";
	CloseTable();
	@include("footer.php");

}else{
	@include("header.php");
	nav();
	OpenTable();

	echo "<table width='90%' align='center'>
	        <tr>
	          <td align='center' bgcolor='$bgcolor2'><font class='title'>"._SEARCH_MAP."</font>
		  </td>
	        </tr>
	        <tr>
	          <td align='center'>
		  <form action='modules.php?name=$module_name&amp;file=mapsearch' method='post'>
		  "._SEARCHONLYTITLE."<input type='checkbox' name='intitle'><br>
		  "._SEARCHONLYDETAILS."<input type='checkbox' name='indetails'><br>
		  <input type='text' name='text' size='40' maxlength='100'><br><br>
		  <input type='submit' name='search_now' value='"._SEARCH."'>
		  </form>
		  </td>
		</tr>
	      </table>";

	CloseTable();
	@include("footer.php");

}
?>