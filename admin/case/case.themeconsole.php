<?php
/************************************************************************/
/* PHP-Nuke ThemeConsole v.1                                  COPYRIGHT */
/*                                                                      */
/* Copyright (c) 2004 by http://www.techgfx.com                         */
/*     Techgfx  (goose@techgfx.com)                                     */
/* Copyright (c) 2004 by http://www.portedmods.com                      */
/*     Anor     (anor@portedmods.com)                                   */
/*     Mighty_Y (mighty_y@portedmods.com)                               */
/*                                                                      */
/* TechGFX: Your dreams, Our imagination                                */
/************************************************************************/
if ( !defined('ADMIN_FILE') )
{
	die ("Access Denied");
}
//if (!eregi("admin.php", $_SERVER['PHP_SELF'])) { die ("Access Denied"); }

switch($op) {

    case "themeconsole":
    case "themeconsolemake":
    case "themeconsolesave":
    case "tccopyright":
    include("admin/modules/themeconsole.php");
    break;

}

?>