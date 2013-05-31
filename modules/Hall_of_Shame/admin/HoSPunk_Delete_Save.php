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


$pid = intval($pid);
$punkinfo = $db->sql_fetchrow($db->sql_query("SELECT * FROM ".$prefix."_hos_punks WHERE pid='$pid'"));
@unlink($punkinfo['punkss']);
@unlink($punkinfo['punkdemo']);
$db->sql_query("DELETE FROM ".$prefix."_hos_punks WHERE pid='$pid'");
$db->sql_query("OPTIMIZE TABLE ".$prefix."_hos_punks");
Header("Location: ".$admin_file.".php?op=HoSPunk_List");

?>