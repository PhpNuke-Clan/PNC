<?php

/********************************************************/
/* NSN GR Downloads                                     */
/* By: NukeScripts Network (webmaster@nukescripts.net)  */
/* http://www.nukescripts.net                           */
/* Copyright � 2000-2005 by NukeScripts Network         */
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

$pagetitle = _DOWNLOADSADMIN.": "._FILESIZEVALIDATION;
include ("header.php");
title($pagetitle);
dladminmain();
echo "<br>\n";
OpenTable();
echo "<table align='center' width='100%' cellpadding='2' cellspacing='2' border='0'>\n";
echo "<tr><td align='center'><a href='".$admin_file.".php?op=FilesizeValidate&amp;cid=0'>"._CHECKALLDOWNLOADS."</a><br><br></td></tr>\n";
echo "<tr><td align='center'><b>"._CHECKCATEGORIES."</b><br>"._INCLUDESUBCATEGORIES."<br><br></td></tr>\n";
$result = $db->sql_query("SELECT * FROM ".$prefix."_nsngd_categories ORDER BY parentid,title");
while($cidinfo = $db->sql_fetchrow($result)) {
  if ($cidinfo['parentid'] != 0) { $cidinfo['title'] = getparent($cidinfo['parentid'],$cidinfo['title']); }
  $transfertitle = str_replace (" ", "_", $cidinfo['title']);
  echo "<tr><td align='center'><a href='".$admin_file.".php?op=FilesizeValidate&amp;cid=".$cidinfo['cid']."&amp;ttitle=$transfertitle'>".$cidinfo['title']."</a></td></tr>\n";
}
echo "</table>\n";
CloseTable();
include ("footer.php");

?>