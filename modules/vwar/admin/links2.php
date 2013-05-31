<?php

if ( !defined('ADMIN_FILE') ) {
	die("Access Denied");
}
global $prefix, $db, $admin_file;
adminmenu("".$admin_file.".php?op=vwar", "vWar Admin", "vwar_logo.gif");

?>