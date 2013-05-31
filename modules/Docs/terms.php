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

function terms() {
global $sitename, $module_name, $adminmail;
@include("header.php");
title("$sitename: "._NSTERMS."");
if (file_exists("modules/$module_name/copyright.php")) {
OpenTable();
echo "<br><table width=\"95%\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\" align=\"center\">";
echo "<tr><td valign=\"top\">";
echo "<div align=\"justify\"><font class=\"content\">";
echo "<b>"._NSTERMSUSE1."</b><br>";
echo ""._NSTERMSUSE1a." ";
echo "<a href=\"modules.php?name=$module_name&amp;file=privacy\" target=\"_blank\">";
echo ""._NSPRIVACY."</a>, "._NSTERMSUSE1b.""; 
echo "<br><br>";
echo "<b>"._NSTERMSUSE2."</b><br>";
echo ""._NSTERMSUSE2a."";
echo "<br><br>";
echo "<b>"._NSTERMSUSE3."</b><br>";
echo ""._NSTERMSUSE3a."";
echo "<br><br>";
echo "<b>"._NSTERMSUSE4."</b><br>";
echo ""._NSTERMSUSE4a." ";
echo "<a href=\"modules.php?name=$module_name&amp;file=privacy\" target=\"_blank\">";
echo ""._NSPRIVACY."</a>.";
echo "<br><br>";
echo "<b>"._NSTERMSUSE5."</b><br>";
echo ""._NSTERMSUSE5a."";
echo "<br><br>";
echo "<b>"._NSTERMSUSE6."</b><br>";
echo ""._NSTERMSUSE6a."";
echo "<br><br>";
echo ""._NSTERMSUSE6b."";
echo "<br><br>";
echo ""._NSTERMSUSE6c."";
echo "<br>";
echo ""._NSTERMSUSE6d."";
echo "<br>";
echo ""._NSTERMSUSE6e."";
echo "<br>";
echo ""._NSTERMSUSE6f."";
echo "<br>";
echo ""._NSTERMSUSE6g."";
echo "<br><br>";
echo "<b>"._NSTERMSUSE7."</b><br>";
echo ""._NSTERMSUSE7a."<br>";
echo ""._NSTERMSUSE7b."";
echo "<br>";
echo ""._NSTERMSUSE7c."";
echo "<br>";
echo ""._NSTERMSUSE7d."";
echo "<br><br>";
echo "<b>"._NSTERMSUSE8."</b><br>";
echo ""._NSTERMSUSE8a."";
echo "<br><br>";
echo "<b>"._NSTERMSUSE9."</b><br>";
echo ""._NSTERMSUSE9a."";
echo "<br><br>";
echo "<b>"._NSTERMSUSE10."</b><br>";
echo ""._NSTERMSUSE10a."";
echo "<br><br>";
echo ""._NSTERMSUSE10b."";
echo "<br><br>";
//@RJR-Pwmg@Rncvkpwo@-@Eqratkijv@(e)@VgejIHZ.eqo
echo ""._NSTERMSUSE10c."";
echo "<br><br>";
echo "<b>"._NSTERMSUSE11."</b><br>";
echo ""._NSTERMSUSE11a."";
echo "<br><br>";
echo ""._NSTERMSUSE11b."";
echo "<br><br>";
echo "<b>"._NSTERMSUSE12."</b><br>";
echo ""._NSTERMSUSE12a."";
echo "<br><br>";
echo "<b>"._NSTERMSUSE13."</b><br>";
echo ""._NSTERMSUSE13a."";
echo "<br><br>";
echo "<b>"._NSTERMSUSE14."</b><br>";
echo ""._NSTERMSUSE14a."";
echo "<br>";
echo ""._NSTERMSUSE14b."";
echo "<br>";
echo ""._NSTERMSUSE14c."";
echo "<br>";
echo ""._NSTERMSUSE14d."";
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
    terms();
    break;

}

?>