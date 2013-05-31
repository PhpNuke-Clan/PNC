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

if(!defined('BLOCK_FILE')) { die("Illegal File Access Detected!!"); }
global $prefix, $multilingual, $currentlang, $db;
list($main_module) = $db->sql_fetchrow($db->sql_query("SELECT `main_module` FROM `".$prefix."_main`"));
if($main_module == "News") {
  $art_link = "index.php?";
} else {
  $art_link = "modules.php?name=News&amp;";
}
include_once("includes/nsnne_func.php");
$neconfig = ne_get_configs();
if ($multilingual == 1) {
  $querylang = "AND (`alanguage`='$currentlang' OR `alanguage`='')";
} else {
  $querylang = "";
}
$tdate = date("Y-m-d");
$row = $db->sql_fetchrow($db->sql_query("SELECT * FROM `".$prefix."_stories` WHERE (`time` LIKE '%$tdate%') $querylang ORDER BY `counter` DESC LIMIT 0,1"));
$fsid = intval($row['sid']);
$ftitle = stripslashes(ne_check_html(ne_convert_text($row['title']), 0));
$content = "<span class=\"content\">";
if ((!$fsid) AND (!$ftitle)) {
  $content .= _NOBIGSTORY;
} else {
  $content .= _BIGSTORY."<br><br>";
  $content .= "<a href=\"".$art_link."op=NEArticle&amp;sid=$fsid\">$ftitle</a>";
}
$content .= "</span>\n";

?>