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
$name = stripslashes(ne_check_html(ne_convert_text($name), 0));
$url = stripslashes(ne_check_html(ne_convert_text($url), 0));
$db->sql_query("UPDATE `".$prefix."_related` SET `name`='$name', `url`='$url' WHERE `rid`='$rid'");
header("Location: ".$admin_file.".php?op=NETopicEdit&topicid=$tid");

?>