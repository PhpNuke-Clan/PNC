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
$rrid = intval($rrid);
if ($rrid == 0 ){@include("header.php");
  	OpenTable();
  	echo "<center class='title'>"._HoS_YOUMUSTADDREPLACEMENTCATEGORY."</center><br>\n";
  	echo "<center>"._GOBACK."</center>\n";
  	CloseTable();
  	@include("footer.php");
  	die();}
$db->sql_query("UPDATE ".$prefix."_hos_reasons SET rpid='$rrid' where rpid='$rid'");
$db->sql_query("OPTIMIZE TABLE ".$prefix."_hos_reasons");
$db->sql_query("DELETE from ".$prefix."_hos_reasons where rid='$rid'");
$db->sql_query("OPTIMIZE TABLE ".$prefix."_hos_reasons");
Header("Location: ".$admin_file.".php?op=HoSReasonCat_List");

?>