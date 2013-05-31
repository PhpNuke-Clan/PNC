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
  $art_form = "index.php";
} else {
  $art_link = "modules.php?name=News&amp;";
  $art_form = "modules.php?name=News";
}
include_once("includes/nsnne_func.php");
$neconfig = ne_get_configs();
if($multilingual == 1) {
  $querylang = "WHERE (`alanguage`='$currentlang' OR `alanguage`='')";
} else {
  $querylang = "";
}
$content = "<table width=\"100%\" border=\"0\">";
$result = $db->sql_query("SELECT * FROM `".$prefix."_stories` $querylang ORDER BY `sid` DESC LIMIT 0,5");
while($row = $db->sql_fetchrow($result)) {
  $sid = intval($row['sid']);
  $title = stripslashes(ne_check_html(ne_convert_text($row['title']), 0));
  $comtotal = intval($row['comments']);
  $counter = intval($row['counter']);
  $content .= "<tr><td align=\"left\"><strong><big>&middot;</big></strong>&nbsp;<a href=\"".$art_link."op=NEArticle&amp;sid=$sid\">$title</a></td><td align=\"right\">[ $comtotal "._COMMENTS." - $counter "._READS." ]</td></tr>";
}
$content .= "</table>";
$content .= "<br><center>[ <a href=\"".$art_form."\">"._MORENEWS."</a> ]</center>";
$db->sql_freeresult($result);

?>