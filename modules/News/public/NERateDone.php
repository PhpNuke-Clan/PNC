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
if($neconfig['allow_polls'] == 1) {
  include("header.php");
  title("$sitename: "._NE_ARTICLERATING."");
  OpenTable();
  if($rated == 0) {
    echo "<center>"._NE_THANKSVOTEARTICLE."<br><br>";
  } elseif($rated == 1) {
    echo "<center>"._NE_ALREADYVOTED."<br><br>";
  }
  echo "[ <a href='".$module_link."op=NEArticle&amp;sid=$sid'>"._NE_BACKTOARTICLEPAGE."</a> ]</center>";
  CloseTable();
  include("footer.php");
} else {
  header("Location: ".$modlink."op=NERateDone&sid=$sid$r_options");
}

?>