<?php

/************************************************************************/
/* PHP-NUKE: Advanced Content Management System                         */
/* ============================================                         */
/*                                                                      */
/* Copyright (c) 2002 by Francisco Burzi                                */
/* http://phpnuke.org                                                   */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/

if (stristr(htmlentities($_SERVER['PHP_SELF']), "header.php")) {
    Header("Location: index.php");
    die();
}

define('NUKE_HEADER', true);
require_once("mainfile.php");

##################################################
# Include some common header for HTML generation #
##################################################


function head() {
    global $slogan, $sitename, $banners, $nukeurl, $Version_Num, $artpage, $topic, $hlpfile, $user, $hr, $theme, $cookie, $bgcolor1, $bgcolor2, $bgcolor3, $bgcolor4, $textcolor1, $textcolor2, $forumpage, $adminpage, $userpage, $pagetitle;
    $ThemeSel = get_theme();
    echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">\n";
    echo "<html>\n";
    echo "<head>\n";
    echo "<title>$sitename $pagetitle</title>\n";
    include("includes/meta.php");
    include("includes/javascript.php");
    if (file_exists("themes/$ThemeSel/images/favicon.ico")) {
	echo "<link REL=\"shortcut icon\" HREF=\"themes/$ThemeSel/images/favicon.ico\" TYPE=\"image/x-icon\">\n";
    }
    echo "<link rel=\"alternate\" type=\"application/rss+xml\" title=\"RSS\" href=\"backend.php\">\n";
    echo "<LINK REL=\"StyleSheet\" HREF=\"themes/$ThemeSel/style/style.css\" TYPE=\"text/css\">\n\n\n";
    if (file_exists("includes/custom_files/custom_head.php")) {
	  include_once("includes/custom_files/custom_head.php");
    }

    if (file_exists("includes/custom_files/custom_header.php")) {
	  include_once("includes/custom_files/custom_header.php");
    }
    echo "</head>\n";
    include_once("themes/$ThemeSel/theme.php");
	global $ab_config;
    if($ab_config['site_switch'] == 1 && is_admin($_COOKIE['admin'])) {
      echo '<center><img src="images/nukesentinel/disabled.png" alt="'._AB_SITEDISABLED.'" title="'._AB_SITEDISABLED.'" border="0" /></center><br />'."\n";
    }
    if($ab_config['disable_switch'] == 1 && is_admin($_COOKIE['admin'])) {
      echo '<center><img src="images/nukesentinel/inactive.png" alt="'._AB_NSDISABLED.'" title="'._AB_NSDISABLED.'" border="0" /></center><br />'."\n";
    }
    if($ab_config['test_switch'] == 1 && is_admin($_COOKIE['admin'])) {
      echo '<center><img src="images/nukesentinel/testmode.png" alt="'._AB_TESTMODE.'" title="'._AB_TESTMODE.'" border="0" /></center><br />'."\n";
    }

	themeheader();
}

online();
head();
include("includes/counter.php");
/*****************************************************/
/* Addon - Center Blocks v.2.1.1               START */
/* Addon - Conditional Blocks v.1.1.1          START */
/*****************************************************/
if(defined('HOME_FILE')) {
	message_box();
	blocks("Center");
include("includes/cblocks1.php"); // if you want this on all pages, place it above if ($home == 1) {
/*} else {
    include("includes/cblocks2.php"); // if you want this on all pages, place it above if ($home == 1) {
*/}
/*****************************************************/
/* Addon - Conditional Blocks v.1.1.1            END */
/* Addon - Center Blocks v.2.1.1                 END */
/*****************************************************/
?>