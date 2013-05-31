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

$pagetitle = _DOWNLOADSADMIN.": "._DUSERREPBROKEN;
include ("header.php");
$result = $db->sql_query("SELECT * FROM ".$prefix."_nsngd_mods WHERE brokendownload='1' ORDER BY rid");
$totalbroken = $db->sql_numrows($result);
title("$pagetitle ($totalbroken)");
dladminmain();
echo "<br>\n";
OpenTable();
echo "<center>"._DIGNOREINFO."<br>\n"._DDELETEINFO."</center><br>\n";
echo "<table align='center' width='80%' cellpadding='2' cellspacing='0'>";
if ($totalbroken==0) {
  echo "<tr><td align='center'><b>"._DNOREPORTEDBROKEN."<b></td></tr>\n";
} else {
  $colorswitch = $bgcolor2;
  echo "<tr>\n";
  echo "<td><b>"._DOWNLOAD."</b></td>\n";
  echo "<td><b>"._SUBMITTER."</b></td>\n";
  echo "<td><b>"._DOWNLOADOWNER."</b></td>\n";
  echo "<td><b>"._IGNORE."</b></td>\n";
  echo "<td><b>"._DL_DELETE."</b></td>\n";
  echo "<td><b>"._DL_EDIT."</b></td>\n";
  echo "</tr>\n";
  while($ridinfo = $db->sql_fetchrow($result)) {
    $lidinfo = $db->sql_fetchrow($db->sql_query("SELECT * FROM ".$prefix."_nsngd_downloads WHERE lid='".$ridinfo['lid']."'"));
    list($memail) = $db->sql_fetchrow($db->sql_query("SELECT user_email FROM ".$user_prefix."_users WHERE username='".$ridinfo['modifier']."'"));
    list($oemail) = $db->sql_fetchrow($db->sql_query("SELECT user_email FROM ".$user_prefix."_users WHERE username='".$lidinfo['name']."'"));
    echo "<tr>\n";
    echo "<td bgcolor='$colorswitch'><a href='".$lidinfo['url']."'>".$lidinfo['title']."</a></td>\n";
    echo "<td bgcolor='$colorswitch'>";
    if ($memail=='') { echo $ridinfo['modifier']; } else { echo "<a href='mailto:$memail'>".$ridinfo['modifier']."</a>"; }
    echo "</td>\n";
    echo "<td bgcolor='$colorswitch'>";
    if ($oemail=='') { echo $lidinfo['name']; } else { echo "<a href='mailto:$oemail'>".$lidinfo['name']."</a>"; }
    echo "</td>\n";
    echo "<td bgcolor='$colorswitch' align='center'><a href='".$admin_file.".php?op=DownloadBrokenIgnore&amp;lid=".$ridinfo['lid']."'>X</a></td>\n";
    echo "<td bgcolor='$colorswitch' align='center'><a href='".$admin_file.".php?op=DownloadBrokenDelete&amp;lid=".$ridinfo['lid']."'>X</a></td>\n";
    echo "<td bgcolor='$colorswitch' align='center'><a href='".$admin_file.".php?op=DownloadModify&amp;lid=".$ridinfo['lid']."'>X</a></td>\n";
    echo "</tr>\n";
    if ($colorswitch == $bgcolor2) { $colorswitch = $bgcolor1; } else { $colorswitch = $bgcolor2; }
  }
}
echo "</table>\n";
CloseTable();
include ("footer.php");

?>