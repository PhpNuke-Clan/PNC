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


$rid = intval($rid);
$newrpid = intval($newrpid);
$newtitle = addslashes(stripslashes($newtitle));
$newrdesc = addslashes(stripslashes($newrdesc));
if (!$newrdesc) {$newrdesc = _HoS_NODESCRIPTION;}
if ($newrpid == 0 ){@include("header.php");
  	OpenTable();
  	echo "<center class='title'>"._HoS_YOUMUSTADDCATEGORY."</center><br>\n";
  	echo "<center>"._GOBACK."</center>\n";
  	CloseTable();
  	@include("footer.php");
  	die();}
 if ($newtitle == "" ){@include("header.php");
	  	OpenTable();
	  	echo "<center class='title'>"._HoS_YOUMAYNOTENTERBLANKREASON."</center><br>\n";
	  	echo "<center>"._GOBACK."</center>\n";
	  	CloseTable();
	  	@include("footer.php");
  	die();}
$db->sql_query("UPDATE ".$prefix."_hos_reasons SET title = '$newtitle', rdesc = '$newrdesc', rpid = '$newrpid' WHERE rid = '$rid'");
$db->sql_query("OPTIMIZE TABLE ".$prefix."_hos_reasons");
Header("Location: ".$admin_file.".php?op=HoSReason_List");

?>