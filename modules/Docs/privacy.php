<?php

/************************************************************************/
/* PHP-NUKE: Web Portal System                                          */
/* ===========================                                          */
/*                                                                      */
/* Copyright (c) 2002 by Francisco Burzi                                */
/* http://phpnuke.org                                                   */
/*                                                                      */
/* Website Document Mod V1.0                                            */
/* Copyright (c) 2002 by Shawn Archer                                   */
/* http://www.NukeStyles.com                                            */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/**********************************************************************************************/
/* PNC 3.0.0: PHOENIX Edition                                 COPYRIGHT                       */
/*                                                                                            */
/* Copyright (c) 2005 - 2006 by http://phpnuke-clan.com                                       */
/*  PHPNUKE-CLAN - SUPPORT                (support@phpnuke-clan.com)                          */
/*  PNC 3.0.0  Online Installation Guide - http://www.phpnuke-clan.com/guide/3.0.0/index.htm  */
/**********************************************************************************************/
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

if ( !defined('MODULE_FILE') ) {
	die("Illegal Module File Access");
}

@require_once("mainfile.php");
$module_name = basename(dirname(__FILE__));
get_lang($module_name);
@include("modules/$module_name/doc_config.php");
$index = 1;

function privacy() {
global $sitename, $adminmail, $module_name;
@include("header.php");
title("$sitename: "._NSPRIVACY."");
if (file_exists("modules/$module_name/copyright.php")) { 
OpenTable(); 
echo"<br><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\" align=\"center\">";
echo"<tr><td valign=\"top\">";
echo "<div align=\"justify\">"._NSPRIVACY1." <b>$sitename</b>. "._NSPRIVACY2."</div>";
echo "<br><br><div align=\"justify\"><font class=\"content\">";
echo"<b><u>"._NSPRIVACY3."</u></b></font><br>";
echo"<font class=\"content\"><b>$sitename</b> "._NSPRIVACY4."";
echo "<br><br>";
echo "<b><u>"._NSPRIVACY5."</u></b><br>";
echo ""._NSPRIVACY6." <b>$sitename</b> "._NSPRIVACY7.", <b>$sitename</b> "._NSPRIVACY8."";
echo "<br><br>";
echo "<b><u>"._NSPRIVACY9."</u></b><br>";
echo "<b>$sitename</b> "._NSPRIVACY10."";
echo "<br><br>";
echo "<b><u>"._NSPRIVACY11."</u></b><br>";
echo ""._NSPRIVACY12." <b>$sitename</b> "._NSPRIVACY13."";
echo "<br><br>";
echo "<b><u>"._NSPRIVACY14."</u></b><br>";
echo ""._NSPRIVACY15." <b>$sitename</b> "._NSPRIVACY16." <b>$sitename</b>. "._NSPRIVACY17." ";
echo "<b>$sitename</b> "._NSPRIVACY18." <b>$sitename</b>.";
echo "<br><br>";
echo "<b><u>"._NSPRIVACY19."</u></b><br>";
echo ""._NSPRIVACY20." <b>$sitename</b> "._NSPRIVACY21."";
echo "<br><br>";
echo "<b><u>"._NSPRIVACY22."</u></b><br>";
echo ""._NSPRIVACY23."";
echo "<br><br>";
echo "<b><u>"._NSPRIVACY24."</u></b><br>";
echo ""._NSPRIVACY25." <b>$sitename</b> "._NSPRIVACY26." <b>$sitename</b> "._NSPRIVACY27."";
echo "<br><br>";
echo "<b><u>"._NSPRIVACY28."</u></b><br>";
echo ""._NSPRIVACY29."";
echo "<br><br>";
echo "</font></div>";
ns_doc_questions();
echo "<br></td></tr></table>";
ns_doc_links();
CloseTable(); 
} else {
OpenTable();	
echo ""._NSNOCOPY."";
CloseTable();
} 
@include("footer.php");
}


switch ($op) {

    default:
    privacy();
    break;

}

?>