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

if ( !defined('ADMIN_FILE') )
{
	die ("Access Denied");
}

switch($op) {

    case "modules":
    case "module_status":
    case "module_edit":
    case "module_edit_save":
    case "home_module":
    case "modules_add_category":
    case "modules_edit_category":
    case "modules_edit_category_save":
    case "modules_delete_category":
    include("admin/modules/modules.php");
    break;

}

?>