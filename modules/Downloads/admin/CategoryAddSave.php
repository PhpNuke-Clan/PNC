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

$numrows = $db->sql_numrows($db->sql_query("SELECT * FROM ".$prefix."_nsngd_categories WHERE title='$title' AND parentid='$cid'"));
if ($numrows>0) {
  $pagetitle = _CATEGORIESADMIN.": "._DL_ERROR;
  include("header.php");
  title($pagetitle);
  dladminmain();
  echo "<br>\n";
  OpenTable();
  echo "<center><b>"._ERRORTHESUBCATEGORY." $title "._ALREADYEXIST."</b></center><br>\n";
  echo "<center>"._GOBACK."</center>\n";
  CloseTable();
  include("footer.php");
} else {
  $db->sql_query("INSERT INTO ".$prefix."_nsngd_categories VALUES (NULL, '$title', '$cdescription', '$cid', '$whoadd', '$uploaddir', '$canupload', 1)");
  Header("Location: ".$admin_file.".php?op=Categories");
}

?>