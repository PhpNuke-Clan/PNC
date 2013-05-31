<?php
/************************************************************************/
/* PHP-NUKE: Web Portal System                                          */
/* ===========================                                          */
/*                                                                      */
/* Copyright (c) 2002 by Francisco Burzi                                */
/* http://phpnuke.org                                                   */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/
if ( !defined('ADMIN_FILE') ) {
	die("Access Denied");
}

switch($op) {

    case "XFireAdmin":
    include("modules/XFire/admin/index.php");
    case "XFireUpdate":
    include("modules/XFire/admin/update-xfire.php");
    case "XFireDelete":
    include("modules/XFire/admin/update-xfire.php");
    case "XFireOptions":
    include("modules/XFire/admin/options-xfire.php");
    break;

}

?>