<?php

/********************************************************/
/* NSN Center Blocks                                    */
/* By: NukeScripts Network (webmaster@nukescripts.net)  */
/* http://www.nukescripts.net                           */
/* Copyright © 2000-2005 by NukeScripts Network         */
/********************************************************/
/* Original by: Richard Benfield                        */
/* http://www.benfield.ws                               */
/********************************************************/

global $admin_file;
if(!isset($admin_file)) { $admin_file = "admin"; }
if(!defined('ADMIN_FILE')) {
    Header("Location: ../../".$admin_file.".php");
    die();
}
switch($op) {
  case "CenterBlocksAdmin":
  case "CenterBlocksLoadError":
  case "CenterBlocksSave1":
  case "CenterBlocksSave2":
  case "CenterBlocksSave3":
  case "CenterBlocksSave4":
  case "CenterBlocksSet1":
  case "CenterBlocksSet2":
  case "CenterBlocksSet3":
  case "CenterBlocksSet4":
  include("admin/modules/cblocks.php");
  break;
}

?>