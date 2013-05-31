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


$membername = addslashes(stripslashes($membername));
if (!$membername) {@include("header.php");
  	OpenTable();
  	echo "<center class='title'>"._HoS_YOUMAYNOTENTERBLANKMEMBER."</center><br>\n";
  	echo "<center>"._GOBACK."</center>\n";
  	CloseTable();
  	@include("footer.php");
  	die();}
$db->sql_query("INSERT INTO ".$prefix."_hos_members VALUES ('NULL', '$membername', '0')");
if($another == 1) {
  Header("Location: ".$admin_file.".php?op=HoSMember_Add");
}else {
  Header("Location: ".$admin_file.".php?op=HoSMember_List");
}


?>