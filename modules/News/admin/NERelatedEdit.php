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
include("header.php");
NE_Admin(_NE_TOPICS." "._NE_ADMIN);
echo "<br />\n";
$rid = intval($rid);
$tid = intval($tid);
$result = $db->sql_query("SELECT * FROM `".$prefix."_related` WHERE `rid`='$rid'");
$row = $db->sql_fetchrow($result);
$name = stripslashes(ne_check_html(ne_convert_text($row['name']), 0));
$url = stripslashes(ne_check_html(ne_convert_text($row['url']), 0));
$db->sql_freeresult($result);
$result = $db->sql_query("SELECT * FROM `".$prefix."_topics` WHERE `topicid`='$tid'");
$row2 = $db->sql_fetchrow($result);
$topictext = stripslashes(ne_check_html(ne_convert_text($row2['topictext']), 0));
$topicimage = stripslashes(ne_check_html(ne_convert_text($row2['topicimage']), 0));
$db->sql_freeresult($result);
OpenTable();
echo "<center>";
echo "<img src='".$tipath."$topicimage' border='0' alt='$topictext' align='right'>";
echo "<font class='option'><b>"._NE_EDITRELATED."</b></font><br />";
echo "<b>"._TOPIC.":</b> $topictext</center>";
echo "<form action='".$admin_file.".php' method='post'>";
echo ""._NE_SITENAME.": <input type='text' name='name' value='$name' size='30' maxlength='30'><br /><br />";
echo ""._NE_URL.": <input type='text' name='url' value='$url' size='60' maxlength='200'><br /><br />";
echo "<input type='hidden' name='op' value='NERelatedSave'>";
echo "<input type='hidden' name='tid' value='$tid'>";
echo "<input type='hidden' name='rid' value='$rid'>";
echo "<input type='submit' value='"._NE_SAVECHANGES."'> "._GOBACK."";
echo "</form>";
CloseTable();
ne_copy();
include("footer.php");

?>