<?php

/********************************************************/
/* NSN News                                             */
/* By: NukeScripts Network (webmaster@nukescripts.net)  */
/* http://www.nukescripts.net                           */
/* Copyright © 2000-2005 by NukeScripts Network         */
/********************************************************/
/* Based on: Threaded Discussion                        */
/* Copyright (C) 2000  Thatware Development Team        */
/* http://atthat.com/                                   */
/********************************************************/

global $admin_file;
if(!$admin_file OR $admin_file == "") { $admin_file = "admin"; }
if(!defined('ADMIN_FILE')) { die("Illegal File Access Detected!!"); }
$modname = basename(str_replace("/admin", "", dirname(__FILE__)));
get_lang($modname);
adminmenu("".$admin_file.".php?op=NEStoryIndex", _NEWS, "news.png");
//adminmenu("".$admin_file.".php?op=NEMain", _NE_NSNNEWS, "news.png");

?>