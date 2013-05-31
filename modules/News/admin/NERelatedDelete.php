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
$rid = intval($rid);
$db->sql_query("DELETE FROM `".$prefix."_related` WHERE `rid`='$rid'");
$db->sql_query("OPTIMIZE TABLE `".$prefix."_related`");
header("Location: ".$admin_file.".php?op=NETopicEdit&topicid=$tid");

?>