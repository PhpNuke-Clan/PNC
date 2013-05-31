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

if ( !defined('MODULE_FILE') )
{
   die("You can't access this file directly...");
}


if ($query == "" or strstr($query, ";")){@include("header.php");
  	OpenTable();
  	echo "<center class='title'>"._HoS_INVALIDQUERY."</center><br>\n";
  	echo "<center>"._GOBACK."</center>\n";
  	CloseTable();
  	@include("footer.php");
  	die();}

switch($searchtype) {


  case "0":@include("modules/$module_name/public/HoSSearchName.php");break;
  case "1":@include("modules/$module_name/public/HoSSearchGuid.php");break;
  case "2":@include("modules/$module_name/public/HoSSearchIp.php");break;


}
?>



