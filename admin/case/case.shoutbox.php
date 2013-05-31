<?php
// ==========================================
// PHP-NUKE: Shout Box
// ==========================
//
// Copyright (c) 2004 by Aric Bolf (SuperCat)
// http://www.OurScripts.net
//
// This program is free software. You can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation
// ===========================================
if ( !defined('ADMIN_FILE') )
{
	die ("Access Denied");
}
global $admin_file;
if ($admin_file == '') { $admin_file = 'admin'; }
if (!eregi("".$admin_file.".php", $_SERVER['PHP_SELF'])) { die ("Access Denied"); }

switch($op) {

	case "shout":
	include("admin/modules/shoutbox.php");
	break;

}

?>
