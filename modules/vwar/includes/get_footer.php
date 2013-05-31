<?php
/* #####################################################################################
 *
 * $Id: get_footer.php,v 1.3 2004/02/22 12:24:59 mabu Exp $
 *
 * This notice must remain untouched at all times.
 *
 * Modifications to the script, except the official addons or hacks,
 * without the owners permission are prohibited.
 * All rights reserved to their proper authors.
 *
 * ---------------------------------------------
 * http://www.vwar.de || Copyright (C) 2001-2004
 * ---------------------------------------------
 *
 * #####################################################################################
 */

/*
 * ------------------------------------------------------------------------------------
 * includes/_footer.php
 * ------------------------------------------------------------------------------------
 * ends the html output
 * ... we need it in the global var space
*/

// beware of cross-site-scripting attacks
if (VWAR_COMMON_INCLUDED != 1)
{
	die("<p style=\"FONT-FAMILY:verdana,tahoma,arial,sans-serif;FONT-SIZE:13px;\">Hacking attempt!</p>\n");
}

// include our copyright
// ... of course this is an easy way to remove it, but - hey! - we spent a long time
// scripting VWar and such a little notice at the bottome doesn't bother that much, does it?!?
eval("\$vwartpl->output(\"".$vwartpl->get("copyright")."\");");

// include individual footer design
// use this file to fill it with your own footer design
include ( $vwar_root . "_footer.php" );

// and out...
exit ();

?>