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


$title = addslashes(stripslashes($title));
$rdesc = addslashes(stripslashes($rdesc));
$rpid = intval($category);
if (!$rdesc) {$rdesc =_HoS_NODESCRIPTION;}
if ($rpid == 0 ){@include("header.php");
  	OpenTable();
  	echo "<center class='title'>"._HoS_YOUMUSTADDCATEGORY."</center><br>\n";
  	echo "<center>"._GOBACK."</center>\n";
  	CloseTable();
  	@include("footer.php");
  	die();}
if ($title == "" ){@include("header.php");
  	OpenTable();
  	echo "<center class='title'>"._HoS_YOUMAYNOTENTERBLANKREASON."</center><br>\n";
  	echo "<center>"._GOBACK."</center>\n";
  	CloseTable();
  	@include("footer.php");
  	die();}
$db->sql_query("INSERT INTO ".$prefix."_hos_reasons VALUES ('NULL', '$title', '$rdesc', '$rpid')");
if($another == 1) {
  Header("Location: ".$admin_file.".php?op=HoSReason_Add");
}else {
  Header("Location: ".$admin_file.".php?op=HoSReason_List");
}

?>