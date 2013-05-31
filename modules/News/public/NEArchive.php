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
$pagetitle = ": "._NE_STORIESARCHIVE;
include("header.php");
title(_NE_STORIESARCHIVE);
OpenTable();
echo "<center><b>"._NE_SELECTMONTH2VIEW."</b></center>";
echo "<center>[ <a href='".$module_link."op=NEAll'>"._NE_SHOWALLSTORIES."</a> ]</center><br>";
$result = $db->sql_query("SELECT `time` FROM `".$prefix."_stories` ORDER BY `time` DESC");
echo "<ul>";
$thismonth = "";
while(list($time) = $db->sql_fetchrow($result)) {
  ereg ("([0-9]{4})-([0-9]{1,2})-([0-9]{1,2}) ([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2})", $time, $getdate);
  if($getdate[2] == "01") { $month = _NE_JANUARY; } elseif($getdate[2] == "02") { $month = _NE_FEBRUARY; } elseif($getdate[2] == "03") { $month = _NE_MARCH; } elseif($getdate[2] == "04") { $month = _NE_APRIL; } elseif($getdate[2] == "05") { $month = _NE_MAY; } elseif($getdate[2] == "06") { $month = _NE_JUNE; } elseif($getdate[2] == "07") { $month = _NE_JULY; } elseif($getdate[2] == "08") { $month = _NE_AUGUST; } elseif($getdate[2] == "09") { $month = _NE_SEPTEMBER; } elseif($getdate[2] == "10") { $month = _NE_OCTOBER; } elseif($getdate[2] == "11") { $month = _NE_NOVEMBER; } elseif($getdate[2] == "12") { $month = _NE_DECEMBER; }
  if($month != $thismonth) {
    $year = $getdate[1];
    $tarts = $db->sql_numrows($db->sql_query("SELECT `sid` FROM `".$prefix."_stories` WHERE `time` LIKE '".$year."-".$getdate[2]."-%'"));
    echo "<li><a href='".$module_link."op=NEMonth&amp;year=$year&amp;month=$getdate[2]'>$month, $year</a> ($tarts)</li>";
    $thismonth = $month;
  }
}
$db->sql_freeresult($result);
echo "</ul>";
CloseTable();
include("footer.php");

?>