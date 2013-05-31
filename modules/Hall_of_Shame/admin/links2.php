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

$platinum_loc = "../..";
$platinum_mod = "Hall_of_Shame";
$platinum_url = "modules/$platinum_mod/images/admin";
$platinum_img = "$platinum_loc/$platinum_url/HoS.gif";
get_lang($platinum_mod);

global $admin_file;
adminmenu("".$admin_file.".php?op=HoSAdmin", ""._HoS_HALLOFSHAME."", "$platinum_img");

?>