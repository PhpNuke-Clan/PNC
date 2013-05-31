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

if(!defined('NSNNE_ADMIN')) { die("Illegal File Access Detected!!"); }
$catid = intval($catid);
$newcat = intval($newcat);
$db->sql_query("UPDATE `".$prefix."_stories` SET `catid`='$newcat' WHERE `catid`='$catid'");
$db->sql_query("DELETE FROM `".$prefix."_stories_cat` WHERE `catid`='$catid'");
$db->sql_query("OPTIMIZE TABLE `".$prefix."_stories_cat`");
header("Location: ".$admin_file.".php?op=NECategoryIndex");

?>