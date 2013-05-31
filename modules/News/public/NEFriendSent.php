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

if(!defined('NSNNE_PUBLIC')) { die("Illegal File Access Detected!!"); }
include("header.php");
$title = urldecode(ne_check_html(ne_convert_text($title), 0));
$fname = urldecode(ne_check_html(ne_convert_text($fname), 0));
OpenTable();
echo "<center class='content'>"._NE_STORY.": <b>$title</b> "._NE_HASSENT." $fname... "._NE_THANKS."</center>";
CloseTable();
include("footer.php");

?>