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


hossave_config("date_format",$date_format);
hossave_config("punkssheight",$punkssheight);
hossave_config("punksswidth",$punksswidth);
hossave_config("punksspath",$punksspath);
hossave_config("punkdemopath",$punkdemopath);
hossave_config("maxdemo",$maxdemo);
hossave_config("pperpage",$pperpage);
hossave_config("perrow",$perrow);
hossave_config("search",$search);
hossave_config("demoextallow",$demoextallow);
hossave_config("ssextallow",$ssextallow);
hossave_config("maxss",$maxss);
hossave_config("demoheight",$demoheight);
hossave_config("demowidth",$demowidth);
hossave_config("mid",$mid);
hossave_config("membertable",$membertable);
hossave_config("membername",$membername);
hossave_config("memberstatus",$memberstatus);
hossave_config("memberstatusdivider",$memberstatusdivider);
hossave_config("memberstatusoperator",$memberstatusoperator);
hossave_config("admsort",$admsort);
hossave_config("admsortasc",$admsortasc);
hossave_config("pubsort",$pubsort);
hossave_config("pubsortasc",$pubsortasc);
hossave_config("rightblocks",$rblocks);
$db->sql_query("OPTIMIZE TABLE ".$prefix."_hos_config");
Header("Location: ".$admin_file.".php?op=HoSConfigure");

?>
