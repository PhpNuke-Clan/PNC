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
global $admin_file;
if ($radminsuper==1) {
    adminmenu("".$admin_file.".php?op=themeconsole", "ThemeConsole", "themeconsole.gif");
}	

?>