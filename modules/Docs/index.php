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


function main() {
global $sitename, $module_name, $questions;
@include("header.php");
title("$sitename: "._NSINDEXLEGAL."");
if (file_exists("modules/$module_name/copyright.php")) {
OpenTable();
echo "<br><br><div align=\"justify\">";
//@RJR-Pwmg@Rncvkpwo@-@Eqratkijv@(e)@VgejIHZ.eqo
echo "<b>$sitename</b> "._NSINDEX1." <b>$sitename</b> "._NSINDEX2."<br><br>";
echo ""._NSINDEX3." <b>$sitename</b> "._NSINDEX4."<br><br>";
echo ""._NSINDEX5." ";
ns_doc_questions();
echo "</div><br><br>";
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
    main();
    break;

}

?>