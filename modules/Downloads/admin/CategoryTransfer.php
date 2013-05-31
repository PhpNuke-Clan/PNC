<?php

/********************************************************/
/* NSN GR Downloads                                     */
/* By: NukeScripts Network (webmaster@nukescripts.net)  */
/* http://www.nukescripts.net                           */
/* Copyright © 2000-2005 by NukeScripts Network         */
/************************************************************************/
/* PHP-Nuke Platinum: Expect to be impressed                  COPYRIGHT */
/*                                                                      */
/* Copyright (c) 2004 - 2006 by http://www.techgfx.com                  */
/*     Techgfx - Graeme Allan                       (goose@techgfx.com) */
/*                                                                      */
/* Copyright (c) 2004 - 2006 by http://www.conrads-berlin.de            */
/*     MrFluffy - Axel Conrads                 (axel@conrads-berlin.de) */
/*                                                                      */
/* Refer to TechGFX.com for detailed information on PHP-Nuke Platinum   */
/*                                                                      */
/* TechGFX: Your dreams, our imagination                                */
/************************************************************************/

$pagetitle = _CATEGORIESADMIN.": "._CATTRANS;
include("header.php");
title($pagetitle);
dladminmain();
echo "<br>\n";
$numrows = $db->sql_numrows($db->sql_query("SELECT * FROM ".$prefix."_nsngd_downloads"));
OpenTable();
if ($numrows>0) {
  echo "<table align='center' cellpadding='2' cellspacing='2' border='0'>\n";
  echo "<form method='post' action='".$admin_file.".php'>\n";
  echo "<tr><td align='center' colspan='2'><b>"._EZTRANSFERDOWNLOADS."</b></td></tr>\n";
  echo "<tr><td bgcolor='$bgcolor2'>"._FROM.":</td><td><select name='cidfrom'>\n";
  echo "<option value='0'>"._DL_NONE."</option>\n";
  $result2 = $db->sql_query("SELECT * FROM ".$prefix."_nsngd_categories WHERE parentid='0' ORDER BY title");
  while($cidinfo = $db->sql_fetchrow($result2)) {
    $crawled = array($cidinfo['cid']);
    CrawlLevel($cidinfo['cid']);
    $x=0;
    while ($x <= (sizeof($crawled)-1)) {
      list($title,$parentid) = $db->sql_fetchrow($db->sql_query("SELECT title, parentid FROM ".$prefix."_nsngd_categories WHERE cid='$crawled[$x]'"));
      if ($x > 0) { $title = getparent($parentid,$title); }
      echo "<option value='$crawled[$x]'>$title</option>\n";
      $x++;
    }
  }
  echo "</select></td></tr>\n";
  echo "<tr><td bgcolor='$bgcolor2'>"._TO.":</td><td><select name='cidto'>\n";
  echo "<option value='0'>"._DL_NONE."</option>\n";
  $result2 = $db->sql_query("SELECT cid, title, parentid FROM ".$prefix."_nsngd_categories WHERE parentid='0' ORDER BY title");
  while($cidinfo = $db->sql_fetchrow($result2)) {
    $crawled = array($cidinfo['cid']);
    CrawlLevel($cidinfo['cid']);
    $x=0;
    while ($x <= (sizeof($crawled)-1)) {
      list($title,$parentid) = $db->sql_fetchrow($db->sql_query("SELECT title, parentid FROM ".$prefix."_nsngd_categories WHERE cid='$crawled[$x]'"));
      if ($x > 0) { $title = getparent($parentid,$title); }
      echo "<option value='$crawled[$x]'>$title</option>\n";
      $x++;
    }
  }
  echo "</select></td></tr>\n";
  echo "<input type='hidden' name='op' value='DownloadTransfer'>\n";
  echo "<tr><td align='center' colspan='2'><input type='submit' value='"._EZTRANSFER."'></td></tr>\n";
  echo "</form>\n</table>\n";
} else {
  echo "<center><b>"._NOCATTRANS."</b></center>\n";
}
CloseTable();
include("footer.php");

?>