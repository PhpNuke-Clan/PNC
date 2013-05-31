<?php

/************************************************************************/
/* PHP-NUKE: Web Portal System                                          */
/* ===========================                                          */
/*                                                                      */
/* Copyright (c) 2002 by Francisco Burzi                                */
/* http://phpnuke.org                                                   */
/*                                                                      */
/* Enhanced Downloads Module - Version 1.7a                             */
/* Copyright (c) 2002 by Shawn Archer                                   */
/* http://www.NukeStyles.com                                            */
/*                                                                      */
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

if ( !defined('MODULE_FILE') ) {
	die("Illegal Module File Access");
}

$module_name = basename(dirname(__FILE__));
@require_once("modules/$module_name/ns_downloads_file.php");  
@require_once("mainfile.php");

function ns_dl_add_error($title, $url, $cat, $description, $email, $ns_compat, $filesize, $blocknow) {
    global $prefix, $db;
    $result_ad = $db->sql_query("SELECT ns_dl_add_email, ns_dl_add_filesize, ns_dl_add_compat from ".$prefix."_ns_downloads");
    list($ns_dl_add_email, $ns_dl_add_filesize, $ns_dl_add_compat) = $db->sql_fetchrow($result_ad);

// Check if Title exist
    if ($title=="") {
        $blocknow = 1;
	@include("header.php");
	menu(1);
	echo "<br>";
	echo "<a name=\"nssubmit\">";
	ns_mod_title2("download_error",""._NSDLERROR."");
	OpenTable();
	OpenTable2();
	echo "<br><br><center><b>"._DOWNLOADNOTITLE."</b><br><br><br>"
	    .""._NSDLBACK."</center><br><br>";
	CloseTable2();
	CloseTable();
	@include("footer.php");
    }

// Check if URL exist
    if ($url == "") {
        $blocknow = 1;
	@include("header.php");
	menu(1);
	echo "<br>";
	echo "<a name=\"nssubmit\">";
	ns_mod_title2("download_error",""._NSDLERROR."");
	OpenTable();
	OpenTable2();
	echo "<br><br><center><b>"._DOWNLOADNOURL."</b><br><br><br>"
	    .""._NSDLBACK."</center><br><br>";
	CloseTable2();
	CloseTable();
	@include("footer.php");
    }

// Check if Category exist - NukeStyles
    if ($cat == "") {
        $blocknow = 1;
	@include("header.php");
	menu(1);
	echo "<br>";
	echo "<a name=\"nssubmit\">";
	ns_mod_title2("download_error",""._NSDLERROR."");
	OpenTable();
	OpenTable2();
	echo "<br><br><center><b>"._NSDLNOCAT."</b><br><br><br>"
	    .""._NSDLBACK."</center><br><br>";
	CloseTable2();
	CloseTable();
	@include("footer.php");
    }

// Check if Description exist
    if ($description=="") {
        $blocknow = 1;
	@include("header.php");
	menu(1);
	echo "<br>";
	echo "<a name=\"nssubmit\">";
	ns_mod_title2("download_error",""._NSDLERROR."");
	OpenTable();
	OpenTable2();
	echo "<br><br><center><b>"._DOWNLOADNODESC."</b><br><br><br>"
	    .""._NSDLBACK."</center><br><br>";
	CloseTable2();
	CloseTable();
	@include("footer.php");
    }

// Check if email exsists @ if exists, make sure it's valid - NukeStyles
    if ($ns_dl_add_email == 1) {
	if ($email == "") {
        $blocknow = 1;
	@include("header.php");
	menu(1);
	echo "<br>";
	echo "<a name=\"nssubmit\">";
	ns_mod_title2("download_error",""._NSDLERROR."");
	OpenTable();
	OpenTable2();
	echo"<br><br><center><b>"._NSENTEREMAIL."</b><br><br><br>"; 
	echo""._NSDLBACK."</center><br><br>";
	CloseTable2();
	CloseTable();
	@include("footer.php");
	} else if (($email != "") AND (!eregi ("^([a-z0-9_]|\\-|\\.)+@(([a-z0-9_]|\\-)+\\.)+[a-z]{2,4}$", $email))) {
        $blocknow = 1;
	@include("header.php");
	menu(1);
	echo "<br>";
	echo "<a name=\"nssubmit\">";
	ns_mod_title2("download_error",""._NSDLERROR."");
	OpenTable();
	OpenTable2();
	echo"<br><br><center>"._NSEMAILNOVALID." <font color=\"#CC0000\"><b>$email</b></font> ";
	echo""._NSEMAILNOVALID2."<br><br><br>"; 
	echo""._NSDLBACK."</center><br><br>";
	CloseTable2();
	CloseTable();
	@include("footer.php");
        }
    }

// Check if Compatibility exsists - NukeStyles
    if ($ns_dl_add_compat == 1) {
	if ($ns_compat == "") {
        $blocknow = 1;
	@include("header.php");
	menu(1);
	echo "<br>";
	echo "<a name=\"nssubmit\">";
	ns_mod_title2("download_error",""._NSDLERROR."");
	OpenTable();
	OpenTable2();
	echo"<br><br><center><b>"._NSENTERCOMPAT."</b><br><br><br>";
	echo""._NSDLBACK."</center><br><br>";
	CloseTable2();
	CloseTable();
	@include("footer.php");
	die();
	}
    }

// Check if FileSize exsists - NukeStyles
    if ($ns_dl_add_filesize == 1) {
	if ($filesize == "") {
        $blocknow = 1;
	@include("header.php");
	menu(1);
	echo "<br>";
	echo "<a name=\"nssubmit\">";
	ns_mod_title2("download_error",""._NSDLERROR."");
	OpenTable();
	OpenTable2();
	echo"<br><br><center><b>"._NSENTERFILE."</b><br><br><br>"; 
	echo""._NSDLBACK."</center><br><br>";
	CloseTable2();
	CloseTable();
	@include("footer.php");
	}
    }
}


ns_dl_add_error($title, $url, $cat, $description, $email, $ns_compat, $filesize, $blocknow);



?>
