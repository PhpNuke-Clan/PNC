<?php

/************************************************************************/
/* PHP-NUKE: Web Portal System                                          */
/* ===========================                                          */
/*                                                                      */
/* Copyright (c) 2002 by Francisco Burzi (fbc@mandrakesoft.com)         */
/* http://phpnuke.org                                                   */
/*                                                                      */
/* This is a 2 min hack of the old forum block to work with the phpBB2  */
/* port.                                                                */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/
/*         Additional security & Abstraction layer conversion           */
/*                           2003 chatserv                              */
/*      http://www.nukefixes.com -- http://www.nukeresources.com        */
/************************************************************************/

if ( !defined('BLOCK_FILE') ) {
    Header("Location: ../index.php");
    die();
}

global $prefix, $db, $sitename;

$sql = "SELECT t.forum_id, topic_id, topic_title, auth_view, auth_read FROM ".$prefix."_bbtopics AS t, ".$prefix."_bbforums AS f WHERE f.forum_id=t.forum_id ORDER BY topic_time DESC LIMIT 10";
$result = $db->sql_query($sql);
$content = "<br>";
while (list($forum_id, $topic_id, $topic_title, $auth_view, $auth_read) = $db->sql_fetchrow($result)) {
    if (($auth_view < 2) OR ($auth_read < 2)) {
        $content .= "<img src=\"images/arrow.gif\" border=\"0\" alt=\"\" title=\"\" width=\"9\" height=\"9\"> <a href=\"modules.php?name=Forums&amp;file=viewtopic&amp;t=$topic_id\">$topic_title</a><br>";
    }
}

$content .= "<br><center><a href=\"modules.php?name=Forums\"><b>$sitename Forums</b></a><br><br></center>";

$db->sql_freeresult($result);

?>