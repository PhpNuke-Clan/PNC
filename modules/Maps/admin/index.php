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

if ( !defined('ADMIN_FILE') )
{
	die("Illegal File Access");
}

//if (!stristr($_SERVER['PHP_SELF'], "".$admin_file.".php")) { die ("Access Denied"); }

global $prefix, $db;
$aid = substr("$aid", 0,25);
$row = $db->sql_fetchrow($db->sql_query("SELECT title, admins FROM ".$prefix."_modules WHERE title='Maps'"));
$row2 = $db->sql_fetchrow($db->sql_query("SELECT name, radminsuper FROM ".$prefix."_authors WHERE aid='$aid'"));
$admins = explode(",", $row['admins']);
$auth_user = 0;
for ($i=0; $i < sizeof($admins); $i++) {
    if ($row2['name'] == $admins[$i] AND $row['admins'] != "") {
        $auth_user = 1;	
    }
}


if ($row2['radminsuper'] == 1 || $auth_user == 1) {
	include ("modules/$module_name/functions.php");

	$cr1 = $db->sql_query("SELECT mval FROM ".$prefix."_mapconfig where mname='c_img'");
		list($catimagedir) = $db->sql_fetchrow($cr1);
	$cr2 = $db->sql_query("SELECT mval FROM ".$prefix."_mapconfig where mname='m_img'");
		list($mapimagedir) = $db->sql_fetchrow($cr2);
	$cr3 = $db->sql_query("SELECT mval FROM ".$prefix."_mapconfig where mname='m_file'");
		list($mapfiledir) = $db->sql_fetchrow($cr3);
	$cr4 = $db->sql_query("SELECT mval FROM ".$prefix."_mapconfig where mname='temp'");
		list($tempdir) = $db->sql_fetchrow($cr4);



switch ($op) {

	case "mapmain":
	include ("modules/$module_name/admin/incs/maps.php");
	break;

	case "addmapcat":
	include ("modules/$module_name/admin/incs/mapsaddcat.php");
	break;

	case "editmapcat":
	include ("modules/$module_name/admin/incs/mapseditcat.php");
	break;

	case "updmapcat":
	include ("modules/$module_name/admin/incs/mapsupdatecat.php");
	break;

	case "delmapcat":
	include ("modules/$module_name/admin/incs/mapsdeletecat.php");
	break;

	case "addmap":
	include ("modules/$module_name/admin/incs/mapsaddmap.php");
	break;

	case "editmap":
	include ("modules/$module_name/admin/incs/mapseditmap.php");
	break;

	case "updmap":
	include ("modules/$module_name/admin/incs/mapsupdatemap.php");
	break;

	case "delmap":
	include ("modules/$module_name/admin/incs/mapsdeletemap.php");
	break;

	case "usermap":
	include ("modules/$module_name/admin/incs/usermapview.php");
	break;

	case "addusermap":
	include ("modules/$module_name/admin/incs/usermapadd.php");
	break;

	case "delusermap":
	include ("modules/$module_name/admin/incs/usermapdelete.php");
	break;

	case "thumb_img":
	include ("modules/$module_name/admin/incs/thumb.php");
	thumb_img($mapimage, $mkthumb);
	break;

	case "mapconfig":
	include ("modules/$module_name/admin/incs/config.php");
	break;

	case "approve":
	include ("modules/$module_name/admin/incs/revapprove.php");
	break;
}

} else {
	include("header.php");
	GraphicAdmin();
	OpenTable();
	echo "<center><b>"._ERROR."</b><br><br>You do not have administration permission for module \"$module_name\"</center>";
	CloseTable();
	include("footer.php");
}

?>