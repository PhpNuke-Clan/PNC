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

require_once("mainfile.php");
list($main_module) = $db->sql_fetchrow($db->sql_query("SELECT main_module FROM ".$prefix."_main"));
if($main_module == "News") {
  header("Location: index.php?op=NEArchive");
} else {
  header("Location: modules.php?name=News&op=NEArchive");
}

?>