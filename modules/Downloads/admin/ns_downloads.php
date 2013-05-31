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

if ( !defined('ADMIN_FILE') ) {
	die("Illegal Admin File Access");
}

global $prefix, $db, $admin_file;

$aid = substr("$aid", 0,25);
$row = $db->sql_fetchrow($db->sql_query("SELECT title, admins FROM ".$prefix."_modules WHERE title='Downloads'"));
$row2 = $db->sql_fetchrow($db->sql_query("SELECT name, radminsuper FROM ".$prefix."_authors WHERE aid='$aid'"));
$admins = explode(",", $row['admins']);
$auth_user = 0;
for ($i=0; $i < sizeof($admins); $i++) {
    if ($row2['name'] == "$admins[$i]" AND $row['admins'] != "") {
        $auth_user = 1;	
    }
}

if ($row2['radminsuper'] == 1 || $auth_user == 1) {

//@include("admin/modules/NukeStyles/EDL/ns_edl_language.php");

function ns_downloads_configure() {
    global $prefix, $db, $admin_file;
    @include("header.php");
    GraphicAdmin();

    $result = $db->sql_query("SELECT ns_dl_allow_html, ns_dl_affiliate_links, ns_dl_show_sub_cats, ns_download_image, ns_download_image_pos, ns_dl_feature, ns_dl_feature_info, ns_dl_feature_one_name, ns_dl_feature_one_link, ns_dl_feature_one_info, ns_dl_feature_two_name, ns_dl_feature_two_link, ns_dl_feature_two_info, ns_dl_feature_three_name, ns_dl_feature_three_link, ns_dl_feature_three_info, ns_dl_feature_four_name, ns_dl_feature_four_link, ns_dl_feature_four_info, ns_dl_num_per_page, ns_dl_num_results, ns_dl_num_new_one, ns_dl_num_new_two, ns_dl_num_new_three, ns_dl_num_top, ns_dl_num_top_num, ns_dl_num_top_per, ns_dl_num_pop, ns_dl_num_pop_num, ns_dl_num_pop_per, ns_dl_num_pop_image, ns_dl_add, ns_dl_anon_add, ns_dl_add_email, ns_dl_add_filesize, ns_dl_mod, ns_dl_mod_anon, ns_dl_show_num, ns_dl_show_full, ns_dl_outside_vote, ns_dl_foot_button, ns_dl_anon_wait_days, ns_dl_outside_wait_days, ns_dl_anon_weight, ns_dl_outside_weight, ns_dl_main_dec, ns_dl_detail_dec, ns_dl_add_compat, ns_dl_des_img, ns_dl_des_img_pos, ns_dl_des_img_width, ns_dl_des_img_height, ns_dl_pop_win, ns_dl_pop_win_width, ns_dl_pop_win_height, ns_dl_popimage_on, ns_dl_newimage_on, ns_dl_new_one, ns_dl_new_two, ns_dl_new_three, ns_dl_auto_add, ns_dl_reg_down, ns_dl_fetch_down, ns_dl_fetch_col from ".$prefix."_ns_downloads");

    list($ns_dl_allow_html, $ns_dl_affiliate_links, $ns_dl_show_sub_cats, $ns_download_image, $ns_download_image_pos, $ns_dl_feature, $ns_dl_feature_info, $ns_dl_feature_one_name, $ns_dl_feature_one_link, $ns_dl_feature_one_info, $ns_dl_feature_two_name, $ns_dl_feature_two_link, $ns_dl_feature_two_info, $ns_dl_feature_three_name, $ns_dl_feature_three_link, $ns_dl_feature_three_info, $ns_dl_feature_four_name, $ns_dl_feature_four_link, $ns_dl_feature_four_info, $ns_dl_num_per_page, $ns_dl_num_results, $ns_dl_num_new_one, $ns_dl_num_new_two, $ns_dl_num_new_three, $ns_dl_num_top, $ns_dl_num_top_num, $ns_dl_num_top_per, $ns_dl_num_pop, $ns_dl_num_pop_num, $ns_dl_num_pop_per, $ns_dl_num_pop_image, $ns_dl_add, $ns_dl_anon_add, $ns_dl_add_email, $ns_dl_add_filesize, $ns_dl_mod, $ns_dl_mod_anon, $ns_dl_show_num, $ns_dl_show_full, $ns_dl_outside_vote, $ns_dl_foot_button, $ns_dl_anon_wait_days, $ns_dl_outside_wait_days, $ns_dl_anon_weight, $ns_dl_outside_weight, $ns_dl_main_dec, $ns_dl_detail_dec, $ns_dl_add_compat, $ns_dl_des_img, $ns_dl_des_img_pos, $ns_dl_des_img_width, $ns_dl_des_img_height, $ns_dl_pop_win, $ns_dl_pop_win_width, $ns_dl_pop_win_height, $ns_dl_popimage_on, $ns_dl_newimage_on, $ns_dl_new_one, $ns_dl_new_two, $ns_dl_new_three, $ns_dl_auto_add, $ns_dl_reg_down, $ns_dl_fetch_down, $ns_dl_fetch_col) = $db->sql_fetchrow($result);

    echo "<form action='".$admin_file.".php' method='post'>";
    echo "<a name=\"start\">";
    OpenTable();
    OpenTable2();
    echo "<center><font class=\"title\">"._NSDLSETTINGS."</font></center>";
    CloseTable2();
    CloseTable();
    OpenTable();
    echo "<br>";
    echo "<br><table align=\"center\" cellpadding=\"4\" cellspacing=\"0\" border=\"0\">";

    echo "<tr><td align=\"right\" width=\"50%\">"._NSDLSHOWNUMFULLDL."</td><td align=\"left\" width=\"50%\">";
    if ($ns_dl_show_full == 1) {
	echo "<input type='radio' name='xns_dl_show_full' value='1' checked>"._NSYES." &nbsp;
	<input type='radio' name='xns_dl_show_full' value='0'>"._NSNO."";
    } else {
	echo "<input type='radio' name='xns_dl_show_full' value='1'>"._NSYES." &nbsp;
	<input type='radio' name='xns_dl_show_full' value='0' checked>"._NSNO."";
    }
    echo "</td></tr>";
    echo "<tr><td align=\"right\" width=\"50%\">"._NSDLSHOWSUBCATS."</td><td align=\"left\" width=\"50%\">";
    if ($ns_dl_show_sub_cats == 1) {
	echo "<input type='radio' name='xns_dl_show_sub_cats' value='1' checked>"._NSYES." &nbsp;
	<input type='radio' name='xns_dl_show_sub_cats' value='0'>"._NSNO."";
    } else {
	echo "<input type='radio' name='xns_dl_show_sub_cats' value='1'>"._NSYES." &nbsp;
	<input type='radio' name='xns_dl_show_sub_cats' value='0' checked>"._NSNO."";
    }
    echo "</td></tr>";
    echo "<tr><td align=\"right\" width=\"50%\">"._NSDLSHOWNUMDL."</td><td align=\"left\" width=\"50%\">";
    if ($ns_dl_show_num == 1) {
	echo "<input type='radio' name='xns_dl_show_num' value='1' checked>"._NSYES." &nbsp;
	<input type='radio' name='xns_dl_show_num' value='0'>"._NSNO."";
    } else {
	echo "<input type='radio' name='xns_dl_show_num' value='1'>"._NSYES." &nbsp;
	<input type='radio' name='xns_dl_show_num' value='0' checked>"._NSNO."";
    }
    echo "</td></tr>";
    echo "<tr><td align=\"right\" width=\"50%\">"._NSDLFOOTBUTTON."</td><td align=\"left\" width=\"50%\">";
    if ($ns_dl_foot_button == 1) {
	echo "<input type='radio' name='xns_dl_foot_button' value='1' checked>"._NSYES." &nbsp;
	<input type='radio' name='xns_dl_foot_button' value='0'>"._NSNO."";
    } else {
	echo "<input type='radio' name='xns_dl_foot_button' value='1'>"._NSYES." &nbsp;
	<input type='radio' name='xns_dl_foot_button' value='0' checked>"._NSNO."";
    }
    echo "</td></tr>";
    echo "<tr><td align=\"right\"><b>"._NSDLFORCEREG.":</b></td>";
    echo "<td align=\"left\" width=\"30%\">";
    if ($ns_dl_reg_down == 1) {
                echo "<input type='radio' name='xns_dl_reg_down' value='1' checked> "._NSYES." &nbsp;";
                echo "<input type='radio' name='xns_dl_reg_down' value='0'> "._NSNO."";
    } else {
                echo "<input type='radio' name='xns_dl_reg_down' value='1'> "._NSYES." &nbsp;";
                echo "<input type='radio' name='xns_dl_reg_down' value='0' checked> "._NSNO."";
    }
    echo "</td></tr>";

    echo "<tr><td>&nbsp;</td></tr>";

    echo "<tr><td align=\"center\" colspan=\"2\"><font class=\"title\">";
    echo ""._NSDLTITLEIMAGE."</font><br>";
    echo "</td></tr>";
    echo "<tr>";
    echo "<td align=\"left\" colspan=\"2\">"._NSDLLINKIMAGE2.":</td>";
    echo "</td></tr>";
    echo "<tr>";
    echo "<td align=\"right\" width=\"50%\">"._NSDLLINKIMAGE.":</td><td align=\"left\" width=\"50%\">";
    echo "<input type='text' name='xns_download_image' value='$ns_download_image' size='40' maxlength='100'>";
    echo "</td></tr>";
    echo "<tr>";
    echo "<td align=\"right\" width=\"50%\">"._NSDLLINKIMAGEPOS.":</td>";
    echo "<td align=\"left\" width=\"50%\"><select name=\"xns_download_image_pos\">";
    echo "<option value=\"$ns_download_image_pos\">$ns_download_image_pos</option>";
/*
    echo "<option value=\"-30\">-30</option>";
    echo "<option value=\"-29\">-29</option>";
    echo "<option value=\"-28\">-28</option>";
    echo "<option value=\"-27\">-27</option>";
    echo "<option value=\"-26\">-26</option>";
    echo "<option value=\"-25\">-25</option>";
    echo "<option value=\"-24\">-24</option>";
    echo "<option value=\"-23\">-23</option>";
    echo "<option value=\"-22\">-22</option>";
    echo "<option value=\"-21\">-21</option>";
*/
    echo "<option value=\"-20\">-20</option>";
    echo "<option value=\"-19\">-19</option>";
    echo "<option value=\"-18\">-18</option>";
    echo "<option value=\"-17\">-17</option>";
    echo "<option value=\"-16\">-16</option>"; 
    echo "<option value=\"-15\">-15</option>";
    echo "<option value=\"-14\">-14</option>";
    echo "<option value=\"-13\">-13</option>";
    echo "<option value=\"-12\">-12</option>";
    echo "<option value=\"-11\">-11</option>";
    echo "<option value=\"-10\">-10</option>";
    echo "<option value=\"-9\">-9</option>";
    echo "<option value=\"-8\">-8</option>";
    echo "<option value=\"-7\">-7</option>";
    echo "<option value=\"-6\">-6</option>";
    echo "<option value=\"-5\">-5</option>";
    echo "<option value=\"-4\">-4</option>";
    echo "<option value=\"-3\">-3</option>";
    echo "<option value=\"-2\">-2</option>";
    echo "<option value=\"-1\">-1</option>";
    echo "<option value=\"-0\">0</option>";
    echo "<option value=\"-1\">1</option>";
    echo "<option value=\"-2\">2</option>";
    echo "<option value=\"-3\">3</option>";
    echo "<option value=\"-4\">4</option>";
    echo "<option value=\"-5\">5</option>";
    echo "<option value=\"-6\">6</option>";
    echo "<option value=\"-7\">7</option>";
    echo "<option value=\"-8\">8</option>";
    echo "<option value=\"-9\">9</option>";
    echo "<option value=\"-10\">10</option>";
    echo "<option value=\"-11\">11</option>";
    echo "<option value=\"-12\">12</option>";
    echo "<option value=\"-13\">13</option>";
    echo "<option value=\"-14\">14</option>";
    echo "<option value=\"-15\">15</option>";
    echo "<option value=\"-16\">16</option>";
    echo "<option value=\"-17\">17</option>";
    echo "<option value=\"-18\">18</option>";
    echo "<option value=\"-19\">19</option>";
    echo "<option value=\"-20\">20</option>";
/*
    echo "<option value=\"-21\">21</option>";
    echo "<option value=\"-22\">22</option>";
    echo "<option value=\"-23\">23</option>";
    echo "<option value=\"-24\">24</option>";
    echo "<option value=\"-25\">25</option>";
    echo "<option value=\"-26\">26</option>";
    echo "<option value=\"-27\">27</option>";
    echo "<option value=\"-28\">28</option>";
    echo "<option value=\"-29\">29</option>";
    echo "<option value=\"-30\">30</option>";";
*/
    echo "</select>";
    echo "</td></tr>";
    echo "<tr><td>&nbsp;</td></tr>";
    echo "<tr><td align=\"center\" colspan=\"2\"><font class=\"title\">";
    echo ""._NSDLDESIMAGE."</font><br>";
    echo "</td></tr>";
    echo "<tr>";
    echo "<td align=\"left\" colspan=\"2\">"._NSDLDESIMAGE1."</td>";
    echo "</td></tr>";
    echo "<tr><td>&nbsp;</td></tr>";
    echo "<tr>";
    echo "<td align=\"right\" width=\"50%\">"._NSDLDESIMAGE2."</td><td align=\"left\" width=\"50%\">";
    if ($ns_dl_des_img == 1) {
	echo "<input type='radio' name='xns_dl_des_img' value='1' checked>"._NSON." &nbsp;
	<input type='radio' name='xns_dl_des_img' value='0'>"._NSOFF."";
    } else {
	echo "<input type='radio' name='xns_dl_des_img' value='1'>"._NSON." &nbsp;
	<input type='radio' name='xns_dl_des_img' value='0' checked>"._NSOFF."";
    }
    echo "</td></tr>";
    echo "<tr><td align=\"center\" colspan=\"2\"><font class=\"tiny\">";
    echo ""._NSDLDESIMAGE3."</font><br>";
    echo "</td></tr>";
    echo "<tr><td>&nbsp;</td></tr>";
    if ($ns_dl_des_img_pos == "l") {
	$sel1 = "selected";
	$sel2 = "";
    } elseif ($ns_dl_des_img_pos == "r") {
	$sel1 = "";
	$sel2 = "selected";
    }
    echo "<tr>";
    echo "<td align=\"right\" width=\"50%\">"._NSDLDESIMGPOSITION.":</td>";
    echo "<td align=\"left\" width=\"50%\"><select name=\"xns_dl_des_img_pos\">";
    echo "<option name=\"ns_dl_des_img_pos\" value=\"l\" $sel1>"._NSDLLEFT."</option>";
    echo "<option name=\"ns_dl_des_img_pos\" value=\"r\" $sel2>"._NDSLRIGHT."</option>";
    echo "</select>";
    echo "</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td align=\"right\" width=\"50%\">"._NSDLDESIMAGEWID.":</td><td align=\"left\" width=\"50%\">";
    echo "<input type='text' name='xns_dl_des_img_width' value='$ns_dl_des_img_width' size='5' maxlength='3'>";
    echo "</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td align=\"right\" width=\"50%\">"._NSDLDESIMAGEHEI.":</td><td align=\"left\" width=\"50%\">";
    echo "<input type='text' name='xns_dl_des_img_height' value='$ns_dl_des_img_height' size='5' maxlength='3'>";
    echo "</td>";
    echo "</tr>";
    echo "<tr><td>&nbsp;</td></tr>";
    echo "<td align=\"right\" width=\"50%\">"._NSDLPOPWIN."</td><td align=\"left\" width=\"50%\">";
    if ($ns_dl_pop_win == 1) {
	echo "<input type='radio' name='xns_dl_pop_win' value='1' checked>"._NSON." &nbsp;
	<input type='radio' name='xns_dl_pop_win' value='0'>"._NSOFF."";
    } else {
	echo "<input type='radio' name='xns_dl_pop_win' value='1'>"._NSON." &nbsp;
	<input type='radio' name='xns_dl_pop_win' value='0' checked>"._NSOFF."";
    }
    echo "</td></tr>";
    echo "<tr>";
    echo "<td align=\"right\" width=\"50%\">"._NSDLPOPWINWID.":</td><td align=\"left\" width=\"50%\">";
    echo "<input type='text' name='xns_dl_pop_win_width' value='$ns_dl_pop_win_width' size='5' maxlength='4'>";
    echo "</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td align=\"right\" width=\"50%\">"._NSDLPOPWINHEI.":</td><td align=\"left\" width=\"50%\">";
    echo "<input type='text' name='xns_dl_pop_win_height' value='$ns_dl_pop_win_height' size='5' maxlength='4'>";
    echo "</td>";
    echo "</tr>";

    echo "<tr><td>&nbsp;</td></tr>";

//  Settings for the Security Code
    echo "<tr><td align=\"center\" colspan=\"2\"><font class=\"title\">";
    echo ""._NSDLFETCHSETTINGS."</font><br>";
    echo "</td></tr>";
    echo "<tr><td align=\"right\" width=\"50%\">"._NSDLUSEFETCH."</td><td align=\"left\" width=\"50%\">";
    if ($ns_dl_fetch_down == 1) {
	echo "<input type='radio' name='xns_dl_fetch_down' value='1' checked>"._NSYES." &nbsp;
	<input type='radio' name='xns_dl_fetch_down' value='0'>"._NSNO."";
    } else {
	echo "<input type='radio' name='xns_dl_fetch_down' value='1'>"._NSYES." &nbsp;
	<input type='radio' name='xns_dl_fetch_down' value='0' checked>"._NSNO."";
    }

//  Settings for the Security Code text color
    echo "<tr><td align=\"right\" width=\"50%\">"._NSDLFETCHPASSCLR."</td><td align=\"left\" width=\"50%\">";
    echo "<input type=\"text\" name=\"xns_dl_fetch_col\" value=\"$ns_dl_fetch_col\" size=\"8\" maxlength=\"6\">&nbsp;";

    echo "<tr>";
    echo "</td></tr>";
    echo "</table><br><br>";
    echo "<div align=\"left\">";
    echo "<a title=\"Top of Page\" class=\"small\" href=\"#start\">";
    echo "<img src=\"images/custom/topofpage.gif\" border=\"0\"></a>";
    echo "<a title=\"Top of Page\" class=\"small\" href=\"#start\">";
    echo ""._NSTOP."</a></div><br>";
    CloseTable();
    OpenTable();
    echo "<br><div align=\"center\"><font class=\"title\">"._NSDLFEATURE."</font></div>";
    echo "<br><table cellpadding=\"4\" cellspacing=\"0\" border=\"0\" width=\"95%\">";
    echo "<tr><td align=\"right\" width=\"40%\">"._NSDLFEATURELINKS."</td><td align=\"left\" width=\"60%\">";
    if ($ns_dl_feature == 1) {
	echo "<input type='radio' name='xns_dl_feature' value='1' checked>"._NSON." &nbsp;
	<input type='radio' name='xns_dl_feature' value='0'>"._NSOFF."";
    } else {
	echo "<input type='radio' name='xns_dl_feature' value='1'>"._NSON." &nbsp;
	<input type='radio' name='xns_dl_feature' value='0' checked>"._NSOFF."";
    }
    echo "</td></tr>";
    echo "<tr><td align=\"right\" width=\"40%\">";
    echo ""._NSDLFEATUREINFO.":</td><td align=\"left\" width=\"70%\"><textarea name=\"xns_dl_feature_info\" cols=\"50\" rows=\"6\">".stripslashes($ns_dl_feature_info)."</textarea>";
    echo "</td></tr></table><br><br><br>";
    OpenTable2();
    echo "<table cellpadding=\"4\" cellspacing=\"0\" border=\"0\" width=\"95%\">";
    echo "<tr>";
    echo "<td align=\"right\" width=\"40%\">"._NSDLFEATURE1NAME.":</td><td align=\"left\" width=\"70%\">";
    echo "<input type='text' name='xns_dl_feature_one_name' value='$ns_dl_feature_one_name' size='40' maxlength='200'>";
    echo "</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td align=\"right\" width=\"40%\">"._NSDLFEATURE1LINK.":</td><td align=\"left\" width=\"60%\">";
    echo "<input type='text' name='xns_dl_feature_one_link' value='$ns_dl_feature_one_link' size='80' maxlength='100'>";
    echo "</td></tr>";
    echo "<tr><td align=\"right\" width=\"40%\">";
    echo ""._NSDLFEATURE1INFO.":</td><td align=\"left\" width=\"70%\"><textarea name=\"xns_dl_feature_one_info\" cols=\"70\" rows=\"10\">".stripslashes($ns_dl_feature_one_info)."</textarea>";
    echo "</td></tr></table>";
    CloseTable2();
    OpenTable2();
    echo "<table cellpadding=\"4\" cellspacing=\"0\" border=\"0\" width=\"95%\">";
    echo "<tr>";
    echo "<td align=\"right\" width=\"40%\">"._NSDLFEATURE2NAME.":</td><td align=\"left\" width=\"70%\">";
    echo "<input type='text' name='xns_dl_feature_two_name' value='$ns_dl_feature_two_name' size='40' maxlength='200'>";
    echo "</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td align=\"right\" width=\"40%\">"._NSDLFEATURE2LINK.":</td><td align=\"left\" width=\"60%\">";
    echo "<input type='text' name='xns_dl_feature_two_link' value='$ns_dl_feature_two_link' size='80' maxlength='100'>";
    echo "</td></tr>";
    echo "<tr><td align=\"right\" width=\"40%\">";
    echo ""._NSDLFEATURE2INFO.":</td><td align=\"left\" width=\"70%\"><textarea name=\"xns_dl_feature_two_info\" cols=\"70\" rows=\"10\">".stripslashes($ns_dl_feature_two_info)."</textarea>";
    echo "</td></tr></table>";
    CloseTable2();
    OpenTable2();
    echo "<table cellpadding=\"4\" cellspacing=\"0\" border=\"0\" width=\"95%\">";
    echo "<tr>";
    echo "<td align=\"right\" width=\"40%\">"._NSDLFEATURE3NAME.":</td><td align=\"left\" width=\"70%\">";
    echo "<input type='text' name='xns_dl_feature_three_name' value='$ns_dl_feature_three_name' size='40' maxlength='200'>";
    echo "</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td align=\"right\" width=\"40%\">"._NSDLFEATURE3LINK.":</td><td align=\"left\" width=\"60%\">";
    echo "<input type='text' name='xns_dl_feature_three_link' value='$ns_dl_feature_three_link' size='80' maxlength='100'>";
    echo "</td></tr>";
    echo "<tr><td align=\"right\" width=\"40%\">";
    echo ""._NSDLFEATURE3INFO.":</td><td align=\"left\" width=\"70%\"><textarea name=\"xns_dl_feature_three_info\" cols=\"70\" rows=\"10\">".stripslashes($ns_dl_feature_three_info)."</textarea>";
    echo "</td></tr></table>";
    CloseTable2();
    OpenTable2();
    echo "<table cellpadding=\"4\" cellspacing=\"0\" border=\"0\" width=\"95%\">";
    echo "<tr>";
    echo "<td align=\"right\" width=\"40%\">"._NSDLFEATURE4NAME.":</td><td align=\"left\" width=\"70%\">";
    echo "<input type='text' name='xns_dl_feature_four_name' value='$ns_dl_feature_four_name' size='40' maxlength='200'>";
    echo "</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td align=\"right\" width=\"40%\">"._NSDLFEATURE4LINK.":</td><td align=\"left\" width=\"60%\">";
    echo "<input type='text' name='xns_dl_feature_four_link' value='$ns_dl_feature_four_link' size='80' maxlength='100'>";
    echo "</td></tr>";
    echo "<tr><td align=\"right\" width=\"40%\">";
    echo ""._NSDLFEATURE4INFO.":</td><td align=\"left\" width=\"70%\"><textarea name=\"xns_dl_feature_four_info\" cols=\"70\" rows=\"10\">".stripslashes($ns_dl_feature_four_info)."</textarea>";
    echo "</td></tr>";
    echo "</table><br><br>";
    CloseTable2();
    echo "<br>";
    echo "<div align=\"left\">";
    echo "<a title=\"Top of Page\" class=\"small\" href=\"#start\">";
    echo "<img src=\"images/custom/topofpage.gif\" border=\"0\"></a>"; 
    echo "<a title=\"Top of Page\" class=\"small\" href=\"#start\">";
    echo ""._NSTOP."</a></div><br>";
    CloseTable();
    OpenTable();
    OpenTable2();
    echo "<center><font class=\"title\">"._NSDLMORESETTINGS."</font></center>";
    CloseTable2();
    CloseTable();
    OpenTable();
    echo "<br>";
    echo "<div align=\"center\"><font class=\"title\">"._NSDLPAGE."</font></div>";
    echo "<br><table align=\"center\" cellpadding=\"4\" cellspacing=\"0\" border=\"0\">";
    echo "<tr><td align=\"right\" width=\"50%\">"._NSDLPERPAGE."</td><td align=\"left\" width=\"50%\">";
    echo "<input type='text' name='xns_dl_num_per_page' value='$ns_dl_num_per_page' size='3' maxlength='2'> <font class='tiny'>"._DEFAULTIS." 10</font>";
    echo "</td></tr>";
    echo "<tr><td align=\"right\" width=\"50%\">"._NSDLSEARCHPERPAGE."</td><td align=\"left\" width=\"50%\">";
    echo "<input type='text' name='xns_dl_num_results' value='$ns_dl_num_results' size='3' maxlength='2'> <font class='tiny'>"._DEFAULTIS." 10</font>";
    echo "</td></tr></table><br>";
    echo "<div align=\"left\">";
    echo "<a title=\"Top of Page\" class=\"small\" href=\"#start\">";
    echo "<img src=\"images/custom/topofpage.gif\" border=\"0\"></a>";
    echo "<a title=\"Top of Page\" class=\"small\" href=\"#start\">";
    echo ""._NSTOP."</a></div><br>";
    CloseTable();
    OpenTable();
    echo "<br>";
    echo "<div align=\"center\"><font class=\"title\">"._NSDLNEW."</font></div><br>";
    echo "<div align=\"justify\">"._NSDLNEWPERPAGE."</div>";
    echo "<br><table align=\"center\" cellpadding=\"4\" cellspacing=\"0\" border=\"0\">";
    echo "<tr><td align=\"right\" width=\"50%\">"._NSDLNEWPERPAGE1."</td><td align=\"left\" width=\"50%\">";
    echo "<input type='text' name='xns_dl_num_new_one' value='$ns_dl_num_new_one' size='3' maxlength='2'> <font class='tiny'>"._DEFAULTIS." 7</font>";
    echo "</td></tr>";
    echo "<tr><td align=\"right\" width=\"50%\">"._NSDLNEWPERPAGE2."</td><td align=\"left\" width=\"50%\">";
    echo "<input type='text' name='xns_dl_num_new_two' value='$ns_dl_num_new_two' size='3' maxlength='2'> <font class='tiny'>"._DEFAULTIS." 14</font>";
    echo "</td></tr>";
    echo "<tr><td align=\"right\" width=\"50%\">"._NSDLNEWPERPAGE3."</td><td align=\"left\" width=\"50%\">";
    echo "<input type='text' name='xns_dl_num_new_three' value='$ns_dl_num_new_three' size='3' maxlength='2'> <font class='tiny'>"._DEFAULTIS." 30</font>";
    echo "</td></tr>";

    echo "<tr><td colspan=\"2\">&nbsp;</td></tr>";
    echo "<tr><td align=\"right\" width=\"50%\">"._NSDLNEWIMAGEON."</td><td align=\"left\" width=\"50%\">";
    if ($ns_dl_newimage_on == 1) {
	echo "<input type='radio' name='xns_dl_newimage_on' value='1' checked>"._NSON." &nbsp;
	<input type='radio' name='xns_dl_newimage_on' value='0'>"._NSOFF."";
    } else {
	echo "<input type='radio' name='xns_dl_newimage_on' value='1'>"._NSON." &nbsp;
	<input type='radio' name='xns_dl_newimage_on' value='0' checked>"._NSOFF."";
    }
    echo "</td></tr>";
    echo "<tr><td align=\"right\" width=\"50%\">"._NSDLNEWIMAGE1."</td><td align=\"left\" width=\"50%\">";
    echo "<input type='text' name='xns_dl_new_one' value='$ns_dl_new_one' size='3' maxlength='2'> <font class='tiny'>"._DEFAULTIS." 1</font>";
    echo "</td></tr>";
    echo "<tr><td align=\"right\" width=\"50%\">"._NSDLNEWIMAGE2."</td><td align=\"left\" width=\"50%\">";
    echo "<input type='text' name='xns_dl_new_two' value='$ns_dl_new_two' size='3' maxlength='2'> <font class='tiny'>"._DEFAULTIS." 3</font>";
    echo "</td></tr>";
    echo "<tr><td align=\"right\" width=\"50%\">"._NSDLNEWIMAGE3."</td><td align=\"left\" width=\"50%\">";
    echo "<input type='text' name='xns_dl_new_three' value='$ns_dl_new_three' size='3' maxlength='2'> <font class='tiny'>"._DEFAULTIS." 7</font>";
    echo "</td></tr>";
    echo "</table><br>";
    echo "<div align=\"left\">";
    echo "<a title=\"Top of Page\" class=\"small\" href=\"#start\">";
    echo "<img src=\"images/custom/topofpage.gif\" border=\"0\"></a>"; 
    echo "<a title=\"Top of Page\" class=\"small\" href=\"#start\">";
    echo ""._NSTOP."</a></div><br>";
    CloseTable();
    OpenTable();
    echo "<br>";
    echo "<div align=\"center\"><font class=\"title\">"._NSDLPOPPERPAGE."</font></div>";
    echo "<br><table align=\"center\" cellpadding=\"4\" cellspacing=\"0\" border=\"0\">";
    echo "<tr><td align=\"right\" width=\"50%\">"._NSDLPOPPERPAGE1."</td><td align=\"left\" width=\"50%\">";
    echo "<input type='text' name='xns_dl_num_pop' value='$ns_dl_num_pop' size='4' maxlength='4'> <font class='tiny'>"._DEFAULTIS." 200</font>";
    echo "</td></tr>";
    echo "<tr><td align=\"right\" width=\"50%\">"._NSDLPOPPERPAGE2."</td><td align=\"left\" width=\"50%\">";
    echo "<input type='text' name='xns_dl_num_pop_num' value='$ns_dl_num_pop_num' size='3' maxlength='2'> <font class='tiny'>"._DEFAULTIS." 10</font>";
    echo "</td></tr>";
    echo "<tr><td align=\"right\" width=\"50%\">"._NSDLPOPPERPAGE3."</td><td align=\"left\" width=\"50%\">";
    if ($ns_dl_num_pop_per == 1) {
	echo "<input type='radio' name='xns_dl_num_pop_per' value='1' checked>"._NSYES." &nbsp;
	<input type='radio' name='xns_dl_num_pop_per' value='0'>"._NSNO."";
    } else {
	echo "<input type='radio' name='xns_dl_num_pop_per' value='1'>"._NSYES." &nbsp;
	<input type='radio' name='xns_dl_num_pop_per' value='0' checked>"._NSNO."";
    }
    echo "</td></tr>";
    echo "<tr><td colspan=\"2\">&nbsp;</td></tr>";

    //@RJR-Pwmg@Rncvkpwo@-@Eqratkijv@(e)@VgejIHZ.eqo
    echo "<tr><td align=\"right\" width=\"50%\">"._NSDLPOPIMAGEON."</td><td align=\"left\" width=\"50%\">";
    if ($ns_dl_popimage_on == 1) {
	echo "<input type='radio' name='xns_dl_popimage_on' value='1' checked>"._NSON." &nbsp;
	<input type='radio' name='xns_dl_popimage_on' value='0'>"._NSOFF."";
    } else {
	echo "<input type='radio' name='xns_dl_popimage_on' value='1'>"._NSON." &nbsp;
	<input type='radio' name='xns_dl_popimage_on' value='0' checked>"._NSOFF."";
    }
    echo "</td></tr>";
    echo "<tr>";
    echo "<td align=\"right\" width=\"40%\">"._NSDLPOPIMAGE.":</td><td align=\"left\" width=\"60%\">";
    echo "<input type='text' name='xns_dl_num_pop_image' value='$ns_dl_num_pop_image' size='40' maxlength='100'>";
    echo "</td></tr>";
    echo "<tr>";
    echo "<td width=\"40%\">&nbsp;</td><td align=\"left\" width=\"60%\">";
    echo "<font class=\"tiny\">"._NSDLPOPIMAGE2."</font></td></tr>";
    echo "</table><br>";
    echo "<div align=\"left\">";
    echo "<a title=\"Top of Page\" class=\"small\" href=\"#start\">";
    echo "<img src=\"images/custom/topofpage.gif\" border=\"0\"></a>"; 
    echo "<a title=\"Top of Page\" class=\"small\" href=\"#start\">";
    echo ""._NSTOP."</a></div><br>";
    CloseTable();
    OpenTable();
    echo "<br>";
    echo "<div align=\"center\"><font class=\"title\">"._NSDLTOPPERPAGE."</font></div>";
    echo "<br><table align=\"center\" cellpadding=\"4\" cellspacing=\"0\" border=\"0\">";
    echo "<tr><td align=\"right\" width=\"50%\">"._NSDLTOPPERPAGE1."</td><td align=\"left\" width=\"50%\">";
    echo "<input type='text' name='xns_dl_num_top' value='$ns_dl_num_top' size='4' maxlength='4'> <font class='tiny'>"._DEFAULTIS." 25</font>";
    echo "</td></tr>";
    echo "<tr><td align=\"right\" width=\"50%\">"._NSDLTOPPERPAGE2."</td><td align=\"left\" width=\"50%\">";
    echo "<input type='text' name='xns_dl_num_top_num' value='$ns_dl_num_top_num' size='3' maxlength='2'> <font class='tiny'>"._DEFAULTIS." 10</font>";
    echo "</td></tr>";
    echo "<tr><td align=\"right\" width=\"50%\">"._NSDLTOPPERPAGE3."</td><td align=\"left\" width=\"50%\">";
    if ($ns_dl_num_top_per == 1) {
	echo "<input type='radio' name='xns_dl_num_top_per' value='1' checked>"._NSYES." &nbsp;
	<input type='radio' name='xns_dl_num_top_per' value='0'>"._NSNO."";
    } else {
	echo "<input type='radio' name='xns_dl_num_top_per' value='1'>"._NSYES." &nbsp;
	<input type='radio' name='xns_dl_num_top_per' value='0' checked>"._NSNO."";
    }
    echo "</td></tr>";
    echo "</table><br>";
    echo "<div align=\"left\">";
    echo "<a title=\"Top of Page\" class=\"small\" href=\"#start\">";
    echo "<img src=\"images/custom/topofpage.gif\" border=\"0\"></a>"; 
    echo "<a title=\"Top of Page\" class=\"small\" href=\"#start\">";
    echo ""._NSTOP."</a></div><br>";
    CloseTable();
    OpenTable();
    echo "<br>";
    echo "<div align=\"center\"><font class=\"title\">"._NSDLADD."</font></div>";
    echo "<br><table align=\"center\" cellpadding=\"4\" cellspacing=\"0\" border=\"0\">";
    echo "<tr><td align=\"left\" colspan=\"2\">";
    echo ""._NSDLADDDOWNLOAD2."<br><br>";
    echo "</td></tr>";
    echo "<tr>";
    echo "<td align=\"right\" width=\"50%\">"._NSDLADDDOWNLOAD."</td><td align=\"left\" width=\"60%\">";
    if ($ns_dl_add == 1) {
	echo "<input type='radio' name='xns_dl_add' value='1' checked>"._NSYES." &nbsp;
	<input type='radio' name='xns_dl_add' value='0'>"._NSNO."";
    } else {
	echo "<input type='radio' name='xns_dl_add' value='1'>"._NSYES." &nbsp;
	<input type='radio' name='xns_dl_add' value='0' checked>"._NSNO."";
    }
    echo "</td></tr>";
    echo "<tr>";
    echo "<td align=\"right\" width=\"50%\">"._NSDLANONADDDOWNLOAD."</td><td align=\"left\" width=\"60%\">";
    if (($ns_dl_add == 1) AND ($ns_dl_anon_add == 1)) {
	echo "<input type='radio' name='xns_dl_anon_add' value='1' checked>"._NSYES." &nbsp;
	<input type='radio' name='xns_dl_anon_add' value='0'>"._NSNO."";
    } elseif (($ns_dl_add == 0) AND ($ns_dl_anon_add == 1)) {
	echo "<input type='radio' name='xns_dl_anon_add' value='1'>"._NSYES." &nbsp;
	<input type='radio' name='xns_dl_anon_add' value='0' checked>"._NSNO."";
    } else {
	echo "<input type='radio' name='xns_dl_anon_add' value='1'>"._NSYES." &nbsp;
	<input type='radio' name='xns_dl_anon_add' value='0' checked>"._NSNO."";
    }
    echo "</td></tr>";



    echo "<tr>";
    echo "<td align=\"right\" width=\"50%\">"._NSDLAUTOADDDOWNLOAD."</td><td align=\"left\" width=\"60%\">";
    if ($ns_dl_auto_add == 1) {
	echo "<input type='radio' name='xns_dl_auto_add' value='1' checked>"._NSYES." &nbsp;
	<input type='radio' name='xns_dl_auto_add' value='0'>"._NSNO."";
    } else {
	echo "<input type='radio' name='xns_dl_auto_add' value='1'>"._NSYES." &nbsp;
	<input type='radio' name='xns_dl_auto_add' value='0' checked>"._NSNO."";
    }
    echo "</td></tr>";   
    
    
    
    echo "<tr><td colspan=\"2\">&nbsp;</td></tr>";


    
    echo "<tr>";
    echo "<td align=\"right\" width=\"50%\">"._NSDLADDDOWNLOADCOMPAT."</td><td align=\"left\" width=\"60%\">";
    if ($ns_dl_add_compat == 1) {
	echo "<input type='radio' name='xns_dl_add_compat' value='1' checked>"._NSYES." &nbsp;
	<input type='radio' name='xns_dl_add_compat' value='0'>"._NSNO."";
    } else {
	echo "<input type='radio' name='xns_dl_add_compat' value='1'>"._NSYES." &nbsp;
	<input type='radio' name='xns_dl_add_compat' value='0' checked>"._NSNO."";
    }
    echo "</td></tr>";
    echo "<tr>";
    echo "<td align=\"right\" width=\"50%\">"._NSDLADDDOWNLOADEMAIL."</td><td align=\"left\" width=\"60%\">";
    if ($ns_dl_add_email == 1) {
	echo "<input type='radio' name='xns_dl_add_email' value='1' checked>"._NSYES." &nbsp;
	<input type='radio' name='xns_dl_add_email' value='0'>"._NSNO."";
    } else {
	echo "<input type='radio' name='xns_dl_add_email' value='1'>"._NSYES." &nbsp;
	<input type='radio' name='xns_dl_add_email' value='0' checked>"._NSNO."";
    }
    echo "</td></tr>";
    echo "<tr>";
    echo "<td align=\"right\" width=\"50%\">"._NSDLADDDOWNLOADFILE."</td><td align=\"left\" width=\"60%\">";
    if ($ns_dl_add_filesize == 1) {
	echo "<input type='radio' name='xns_dl_add_filesize' value='1' checked>"._NSYES." &nbsp;
	<input type='radio' name='xns_dl_add_filesize' value='0'>"._NSNO."";
    } else {
	echo "<input type='radio' name='xns_dl_add_filesize' value='1'>"._NSYES." &nbsp;
	<input type='radio' name='xns_dl_add_filesize' value='0' checked>"._NSNO."";
    }
    echo "</td></tr>";
    echo "<tr>";
    echo "<td align=\"right\" width=\"50%\">"._NSDLALLOWHTML."</td><td align=\"left\" width=\"50%\">";
    if ($ns_dl_allow_html == 1) {
	echo "<input type='radio' name='xns_dl_allow_html' value='1' checked>"._NSYES." &nbsp;
	<input type='radio' name='xns_dl_allow_html' value='0'>"._NSNO."";
    } else {
	echo "<input type='radio' name='xns_dl_allow_html' value='1'>"._NSYES." &nbsp;
	<input type='radio' name='xns_dl_allow_html' value='0' checked>"._NSNO."";
    }
    echo "</td></tr>";
    echo "<tr><td align=\"right\" width=\"50%\">"._NSDLAFFILIATELINKS."</td><td align=\"left\" width=\"50%\">";
    if ($ns_dl_affiliate_links == 1) {
	echo "<input type='radio' name='xns_dl_affiliate_links' value='1' checked>"._NSYES." &nbsp;
	<input type='radio' name='xns_dl_affiliate_links' value='0'>"._NSNO."";
    } else {
	echo "<input type='radio' name='xns_dl_affiliate_links' value='1'>"._NSYES." &nbsp;
	<input type='radio' name='xns_dl_affiliate_links' value='0' checked>"._NSNO."";
    }
    echo "</td></tr>";
    echo "<tr><td colspan=\"2\">&nbsp;</td></tr>";
    echo "<tr>";
    echo "<td align=\"right\" width=\"50%\">"._NSDLMODDOWNLOAD."</td><td align=\"left\" width=\"60%\">";
    if ($ns_dl_mod == 1) {
	echo "<input type='radio' name='xns_dl_mod' value='1' checked>"._NSYES." &nbsp;
	<input type='radio' name='xns_dl_mod' value='0'>"._NSNO."";
    } else {
	echo "<input type='radio' name='xns_dl_mod' value='1'>"._NSYES." &nbsp;
	<input type='radio' name='xns_dl_mod' value='0' checked>"._NSNO."";
    }
    echo "</td></tr>";
    echo "<tr>";
    echo "<td align=\"right\" width=\"50%\">"._NSDLANONMODDOWNLOAD."</td><td align=\"left\" width=\"60%\">";
    if ($ns_dl_mod_anon == 1) {
	echo "<input type='radio' name='xns_dl_mod_anon' value='1' checked>"._NSYES." &nbsp;
	<input type='radio' name='xns_dl_mod_anon' value='0'>"._NSNO."";
    } else {
	echo "<input type='radio' name='xns_dl_mod_anon' value='1'>"._NSYES." &nbsp;
	<input type='radio' name='xns_dl_mod_anon' value='0' checked>"._NSNO."";
    }
    echo "</td></tr></table><br>";
    echo "<div align=\"left\">";
    echo "<a title=\"Top of Page\" class=\"small\" href=\"#start\">";
    echo "<img src=\"images/custom/topofpage.gif\" border=\"0\"></a>"; 
    echo "<a title=\"Top of Page\" class=\"small\" href=\"#start\">";
    echo ""._NSTOP."</a></div><br>";
    CloseTable();
    OpenTable();
    echo "<br>";
    echo "<div align=\"center\"><font class=\"title\">"._NSDLVOTE."</font></div>";
    echo "<br><table align=\"center\" cellpadding=\"4\" cellspacing=\"0\" border=\"0\">";
    echo "<tr><td align=\"left\" colspan=\"2\">";
    echo ""._NSDLVOTE2."<br><br>";
    echo "</td></tr>";
    echo "<tr><td align=\"right\" width=\"50%\">"._NSDLOUTVOTE."</td><td align=\"left\" width=\"50%\">";
    if ($ns_dl_outside_vote == 1) {
	echo "<input type='radio' name='xns_dl_outside_vote' value='1' checked>"._NSYES." &nbsp;
	<input type='radio' name='xns_dl_outside_vote' value='0'>"._NSNO."";
    } else {
	echo "<input type='radio' name='xns_dl_outside_vote' value='1'>"._NSYES." &nbsp;
	<input type='radio' name='xns_dl_outside_vote' value='0' checked>"._NSNO."";
    }
    echo "</td></tr>";
        if ($ns_dl_anon_wait_days == "1") {
	$sel1 = "selected";
	$sel2 = "";
	$sel3 = "";
	$sel4 = "";
	$sel5 = "";
	$sel6 = "";
	$sel7 = "";
	$sel8 = "";
    } elseif ($ns_dl_anon_wait_days == "2") {
	$sel1 = "";
	$sel2 = "selected";
	$sel3 = "";
	$sel4 = "";
	$sel5 = "";
	$sel6 = "";
	$sel7 = "";
	$sel8 = "";
    } elseif ($ns_dl_anon_wait_days == "3") {
	$sel1 = "";
	$sel2 = "";
	$sel3 = "selected";
	$sel4 = "";
	$sel5 = "";
	$sel6 = "";
	$sel7 = "";
	$sel8 = "";
    } elseif ($ns_dl_anon_wait_days == "4") {
	$sel1 = "";
	$sel2 = "";
	$sel3 = "";
	$sel4 = "selected";
	$sel5 = "";
	$sel6 = "";
	$sel7 = "";
	$sel8 = "";
    } elseif ($ns_dl_anon_wait_days == "5") {
	$sel1 = "";
	$sel2 = "";
	$sel3 = "";
	$sel4 = "";
	$sel5 = "selected";
	$sel6 = "";
	$sel7 = "";
	$sel8 = "";
    } elseif ($ns_dl_anon_wait_days == "6") {
	$sel1 = "";
	$sel2 = "";
	$sel3 = "";
	$sel4 = "";
	$sel5 = "";
	$sel6 = "selected";
	$sel7 = "";
	$sel8 = "";
    } elseif ($ns_dl_anon_wait_days == "7") {
	$sel1 = "";
	$sel2 = "";
	$sel3 = "";
	$sel4 = "";
	$sel5 = "";
	$sel6 = "";
	$sel7 = "selected";
	$sel8 = "";
    } elseif ($ns_dl_anon_wait_days == "8") {
	$sel1 = "";
	$sel2 = "";
	$sel3 = "";
	$sel4 = "";
	$sel5 = "";
	$sel6 = "";
	$sel7 = "";
	$sel8 = "selected";
    }
    echo "<tr><td align=\"right\" width=\"50%\">"._NSDLVOTEANWAIT."</td>";
    echo "<td align=\"left\" width=\"50%\"><select name=\"xns_dl_anon_wait_days\">";
    echo "<option value=\"1\" $sel1>1 "._NSDLVDAYS."</option>";
    echo "<option value=\"2\" $sel2>2 "._NSDLVDAYS1."</option>";
    echo "<option value=\"3\" $sel3>3 "._NSDLVDAYS1."</option>";
    echo "<option value=\"4\" $sel4>4 "._NSDLVDAYS1."</option>";
    echo "<option value=\"5\" $sel5>5 "._NSDLVDAYS1."</option>";
    echo "<option value=\"6\" $sel6>6 "._NSDLVDAYS1."</option>";
    echo "<option value=\"\">-----------</option>";
    echo "<option value=\"7\" $sel7>1 "._NSDLVDAYS4."</option>";
    echo "<option value=\"14\" $sel8>2 "._NSDLVDAYS5."</option>";
    echo "</select>";
    echo "</td></tr>";
           if ($ns_dl_outside_wait_days == "1") {
	$sel1 = "selected";
	$sel2 = "";
	$sel3 = "";
	$sel4 = "";
	$sel5 = "";
	$sel6 = "";
	$sel7 = "";
	$sel8 = "";
    } elseif ($ns_dl_outside_wait_days == "2") {
	$sel1 = "";
	$sel2 = "selected";
	$sel3 = "";
	$sel4 = "";
	$sel5 = "";
	$sel6 = "";
	$sel7 = "";
	$sel8 = "";
    } elseif ($ns_dl_outside_wait_days == "3") {
	$sel1 = "";
	$sel2 = "";
	$sel3 = "selected";
	$sel4 = "";
	$sel5 = "";
	$sel6 = "";
	$sel7 = "";
	$sel8 = "";
    } elseif ($ns_dl_outside_wait_days == "4") {
	$sel1 = "";
	$sel2 = "";
	$sel3 = "";
	$sel4 = "selected";
	$sel5 = "";
	$sel6 = "";
	$sel7 = "";
	$sel8 = "";
    } elseif ($ns_dl_outside_wait_days == "5") {
	$sel1 = "";
	$sel2 = "";
	$sel3 = "";
	$sel4 = "";
	$sel5 = "selected";
	$sel6 = "";
	$sel7 = "";
	$sel8 = "";
    } elseif ($ns_dl_outside_wait_days == "6") {
	$sel1 = "";
	$sel2 = "";
	$sel3 = "";
	$sel4 = "";
	$sel5 = "";
	$sel6 = "selected";
	$sel7 = "";
	$sel8 = "";
    } elseif ($ns_dl_outside_wait_days == "7") {
	$sel1 = "";
	$sel2 = "";
	$sel3 = "";
	$sel4 = "";
	$sel5 = "";
	$sel6 = "";
	$sel7 = "selected";
	$sel8 = "";
    } elseif ($ns_dl_outside_wait_days == "8") {
	$sel1 = "";
	$sel2 = "";
	$sel3 = "";
	$sel4 = "";
	$sel5 = "";
	$sel6 = "";
	$sel7 = "";
	$sel8 = "selected";
    } 
    echo "<tr><td align=\"right\" width=\"50%\">"._NSDLVOTEOUTWAIT."</td>";
    echo "<td align=\"left\" width=\"50%\"><select name=\"xns_dl_outside_wait_days\">";
    echo "<option value=\"1\" $sel1>1 "._NSDLVDAYS."</option>";
    echo "<option value=\"2\" $sel2>2 "._NSDLVDAYS1."</option>";
    echo "<option value=\"3\" $sel3>3 "._NSDLVDAYS1."</option>";
    echo "<option value=\"4\" $sel4>4 "._NSDLVDAYS1."</option>";
    echo "<option value=\"5\" $sel5>5 "._NSDLVDAYS1."</option>";
    echo "<option value=\"6\" $sel6>6 "._NSDLVDAYS1."</option>";
    echo "<option value=\"\">-----------</option>";
    echo "<option value=\"7\" $sel7>1 "._NSDLVDAYS4."</option>";
    echo "<option value=\"14\" $sel8>2 "._NSDLVDAYS5."</option>";
    echo "</select>";
    echo "</td></tr>";
    echo "<tr><td align=\"right\" width=\"50%\">"._NSDLVOTEANWEIGHT."</td>";
    echo "<td align=\"left\" width=\"50%\"><select name=\"xns_dl_anon_weight\">";
    echo "<option value=\"$ns_dl_anon_weight\">$ns_dl_anon_weight</option>"; 
    echo "<option value=\"1\">1</option>";
    echo "<option value=\"2\">2</option>";
    echo "<option value=\"3\">3</option>";
    echo "<option value=\"4\">4</option>";
    echo "<option value=\"5\">5</option>";
    echo "<option value=\"6\">6</option>";
    echo "<option value=\"7\">7</option>";
    echo "<option value=\"8\">8</option>";
    echo "<option value=\"9\">9</option>";
    echo "<option value=\"10\">10</option>";
    echo "<option value=\"11\">11</option>";
    echo "<option value=\"12\">12</option>";
    echo "<option value=\"13\">13</option>";
    echo "<option value=\"14\">14</option>";
    echo "<option value=\"15\">15</option>";
    echo "<option value=\"16\">16</option>";
    echo "<option value=\"17\">17</option>";
    echo "<option value=\"18\">18</option>";
    echo "<option value=\"19\">19</option>";
    echo "<option value=\"20\">20</option>";
    echo "</select>";
    echo "</td></tr>";
    echo "<tr><td align=\"right\" width=\"50%\">"._NSDLVOTEOUTWEIGHT."</td>";
    echo "<td align=\"left\" width=\"50%\"><select name=\"xns_dl_outside_weight\">";
    echo "<option value=\"$ns_dl_outside_weight\">$ns_dl_outside_weight</option>"; 
    echo "<option value=\"1\">1</option>";
    echo "<option value=\"2\">2</option>";
    echo "<option value=\"3\">3</option>";
    echo "<option value=\"4\">4</option>";
    echo "<option value=\"5\">5</option>";
    echo "<option value=\"6\">6</option>";
    echo "<option value=\"7\">7</option>";
    echo "<option value=\"8\">8</option>";
    echo "<option value=\"9\">9</option>";
    echo "<option value=\"10\">10</option>";
    echo "<option value=\"11\">11</option>";
    echo "<option value=\"12\">12</option>";
    echo "<option value=\"13\">13</option>";
    echo "<option value=\"14\">14</option>";
    echo "<option value=\"15\">15</option>";
    echo "<option value=\"16\">16</option>";
    echo "<option value=\"17\">17</option>";
    echo "<option value=\"18\">18</option>";
    echo "<option value=\"19\">19</option>";
    echo "<option value=\"20\">20</option>";
    echo "<option value=\"21\">21</option>";
    echo "<option value=\"22\">22</option>";
    echo "<option value=\"23\">23</option>";
    echo "<option value=\"24\">24</option>";
    echo "<option value=\"25\">25</option>";
    echo "<option value=\"26\">26</option>";
    echo "<option value=\"27\">27</option>";
    echo "<option value=\"28\">28</option>";
    echo "<option value=\"29\">29</option>";
    echo "<option value=\"30\">30</option>";
    echo "<option value=\"31\">31</option>";
    echo "<option value=\"32\">32</option>";
    echo "<option value=\"33\">33</option>";
    echo "<option value=\"34\">34</option>";
    echo "<option value=\"35\">35</option>";
    echo "<option value=\"36\">36</option>";
    echo "<option value=\"37\">37</option>";
    echo "<option value=\"38\">38</option>";
    echo "<option value=\"39\">39</option>";
    echo "<option value=\"40\">40</option>";
    echo "</select>";
    echo "</td></tr>";
    echo "<tr><td align=\"right\" width=\"50%\">"._NSDLVOTEMAINDEC."</td>";
    echo "<td align=\"left\" width=\"50%\"><select name=\"xns_dl_main_dec\">";
    echo "<option value=\"$ns_dl_main_dec\">$ns_dl_main_dec</option>"; 
    echo "<option value=\"1\">1</option>";
    echo "<option value=\"2\">2</option>";
    echo "<option value=\"3\">3</option>";
    echo "<option value=\"4\">4</option>";
    echo "</select>";
    echo "</td></tr>";
    echo "<tr><td align=\"right\" width=\"50%\">"._NSDLVOTEADDDEC."</td>";
    echo "<td align=\"left\" width=\"50%\"><select name=\"xns_dl_detail_dec\">";
    echo "<option value=\"$ns_dl_detail_dec\">$ns_dl_detail_dec</option>"; 
    echo "<option value=\"1\">1</option>";
    echo "<option value=\"2\">2</option>";
    echo "<option value=\"3\">3</option>";
    echo "<option value=\"4\">4</option>";
    echo "<option value=\"5\">5</option>";
    echo "<option value=\"6\">6</option>";
    echo "</select>";
    echo "</td></tr>";
    echo "</table><br>";
    echo "<div align=\"left\">";
    echo "<a title=\"Top of Page\" class=\"small\" href=\"#start\">";
    echo "<img src=\"images/custom/topofpage.gif\" border=\"0\"></a>"; 
    echo "<a title=\"Top of Page\" class=\"small\" href=\"#start\">";
    echo ""._NSTOP."</a></div><br>";
    CloseTable();
    OpenTable();
    echo "<br><input type='hidden' name='op' value='ns_downloads_configsave'>";
    echo "<center><input type='submit' name=\"submit\" value='Save Changes'></center>";
    echo "<br>";
    CloseTable();
    echo "</form>";
    @include("footer.php");
}



function ns_downloads_configsave ($xns_dl_allow_html, $xns_dl_affiliate_links, $xns_dl_show_sub_cats, $xns_download_image, $xns_download_image_pos, $xns_dl_feature, $xns_dl_feature_info, $xns_dl_feature_one_name, $xns_dl_feature_one_link, $xns_dl_feature_one_info, $xns_dl_feature_two_name, $xns_dl_feature_two_link, $xns_dl_feature_two_info, $xns_dl_feature_three_name, $xns_dl_feature_three_link, $xns_dl_feature_three_info, $xns_dl_feature_four_name, $xns_dl_feature_four_link, $xns_dl_feature_four_info, $xns_dl_num_per_page, $xns_dl_num_results, $xns_dl_num_new_one, $xns_dl_num_new_two, $xns_dl_num_new_three, $xns_dl_num_top, $xns_dl_num_top_num, $xns_dl_num_top_per, $xns_dl_num_pop, $xns_dl_num_pop_num, $xns_dl_num_pop_per, $xns_dl_num_pop_image, $xns_dl_add, $xns_dl_anon_add, $xns_dl_add_email, $xns_dl_add_filesize, $xns_dl_mod, $xns_dl_mod_anon, $xns_dl_show_num, $xns_dl_show_full, $xns_dl_outside_vote, $xns_dl_foot_button, $xns_dl_anon_wait_days, $xns_dl_outside_wait_days, $xns_dl_anon_weight, $xns_dl_outside_weight, $xns_dl_main_dec, $xns_dl_detail_dec, $xns_dl_add_compat, $xns_dl_des_img, $xns_dl_des_img_pos, $xns_dl_des_img_width, $xns_dl_des_img_height, $xns_dl_pop_win, $xns_dl_pop_win_width, $xns_dl_pop_win_height, $xns_dl_popimage_on, $xns_dl_newimage_on, $xns_dl_new_one, $xns_dl_new_two, $xns_dl_new_three, $xns_dl_auto_add, $xns_dl_reg_down, $xns_dl_fetch_down, $xns_dl_fetch_col) {


    global $prefix, $db, $admin_file;
    $db->sql_query("UPDATE ".$prefix."_ns_downloads SET ns_dl_allow_html='$xns_dl_allow_html', ns_dl_affiliate_links='$xns_dl_affiliate_links', ns_dl_show_sub_cats='$xns_dl_show_sub_cats', ns_download_image='$xns_download_image', ns_download_image_pos='$xns_download_image_pos', ns_dl_feature='$xns_dl_feature', ns_dl_feature_info='$xns_dl_feature_info', ns_dl_feature_one_name='$xns_dl_feature_one_name', ns_dl_feature_one_link='$xns_dl_feature_one_link', ns_dl_feature_one_info='$xns_dl_feature_one_info', ns_dl_feature_two_name='$xns_dl_feature_two_name', ns_dl_feature_two_link='$xns_dl_feature_two_link', ns_dl_feature_two_info='$xns_dl_feature_two_info', ns_dl_feature_three_name='$xns_dl_feature_three_name', ns_dl_feature_three_link='$xns_dl_feature_three_link', ns_dl_feature_three_info='$xns_dl_feature_three_info', ns_dl_feature_four_name='$xns_dl_feature_four_name', ns_dl_feature_four_link='$xns_dl_feature_four_link', ns_dl_feature_four_info='$xns_dl_feature_four_info', ns_dl_num_per_page='$xns_dl_num_per_page', ns_dl_num_results='$xns_dl_num_results', ns_dl_num_new_one='$xns_dl_num_new_one', ns_dl_num_new_two='$xns_dl_num_new_two', ns_dl_num_new_three='$xns_dl_num_new_three', ns_dl_num_top='$xns_dl_num_top', ns_dl_num_top_num='$xns_dl_num_top_num', ns_dl_num_top_per='$xns_dl_num_top_per', ns_dl_num_pop='$xns_dl_num_pop', ns_dl_num_pop_num='$xns_dl_num_pop_num', ns_dl_num_pop_per='$xns_dl_num_pop_per', ns_dl_num_pop_image='$xns_dl_num_pop_image', ns_dl_add='$xns_dl_add', ns_dl_anon_add='$xns_dl_anon_add', ns_dl_add_email='$xns_dl_add_email', ns_dl_add_filesize='$xns_dl_add_filesize', ns_dl_mod='$xns_dl_mod', ns_dl_mod_anon='$xns_dl_mod_anon', ns_dl_show_num='$xns_dl_show_num', ns_dl_show_full='$xns_dl_show_full', ns_dl_outside_vote='$xns_dl_outside_vote', ns_dl_foot_button='$xns_dl_foot_button', ns_dl_anon_wait_days='$xns_dl_anon_wait_days', ns_dl_outside_wait_days='$xns_dl_outside_wait_days', ns_dl_anon_weight='$xns_dl_anon_weight', ns_dl_outside_weight='$xns_dl_outside_weight', ns_dl_main_dec='$xns_dl_main_dec', ns_dl_detail_dec='$xns_dl_detail_dec', ns_dl_add_compat='$xns_dl_add_compat', ns_dl_des_img='$xns_dl_des_img', ns_dl_des_img_pos='$xns_dl_des_img_pos', ns_dl_des_img_width='$xns_dl_des_img_width', ns_dl_des_img_height='$xns_dl_des_img_height', ns_dl_pop_win='$xns_dl_pop_win', ns_dl_pop_win_width='$xns_dl_pop_win_width', ns_dl_pop_win_height='$xns_dl_pop_win_height', ns_dl_popimage_on='$xns_dl_popimage_on', ns_dl_newimage_on='$xns_dl_newimage_on', ns_dl_new_one='$xns_dl_new_one', ns_dl_new_two='$xns_dl_new_two', ns_dl_new_three='$xns_dl_new_three', ns_dl_auto_add='$xns_dl_auto_add', ns_dl_reg_down='$xns_dl_reg_down', ns_dl_fetch_down='$xns_dl_fetch_down', ns_dl_fetch_col='$xns_dl_fetch_col'");
    Header("Location: ".$admin_file.".php?op=ns_downloads_configure#start");
}

switch($op) {

    case "ns_downloads_configure":
    ns_downloads_configure();
    break;

    case "ns_downloads_configsave":
    ns_downloads_configsave ($xns_dl_allow_html, $xns_dl_affiliate_links, $xns_dl_show_sub_cats, $xns_download_image, $xns_download_image_pos, $xns_dl_feature, $xns_dl_feature_info, $xns_dl_feature_one_name, $xns_dl_feature_one_link, $xns_dl_feature_one_info, $xns_dl_feature_two_name, $xns_dl_feature_two_link, $xns_dl_feature_two_info, $xns_dl_feature_three_name, $xns_dl_feature_three_link, $xns_dl_feature_three_info, $xns_dl_feature_four_name, $xns_dl_feature_four_link, $xns_dl_feature_four_info, $xns_dl_num_per_page, $xns_dl_num_results, $xns_dl_num_new_one, $xns_dl_num_new_two, $xns_dl_num_new_three, $xns_dl_num_top, $xns_dl_num_top_num, $xns_dl_num_top_per, $xns_dl_num_pop, $xns_dl_num_pop_num, $xns_dl_num_pop_per, $xns_dl_num_pop_image, $xns_dl_add, $xns_dl_anon_add, $xns_dl_add_email, $xns_dl_add_filesize, $xns_dl_mod, $xns_dl_mod_anon, $xns_dl_show_num, $xns_dl_show_full, $xns_dl_outside_vote, $xns_dl_foot_button, $xns_dl_anon_wait_days, $xns_dl_outside_wait_days, $xns_dl_anon_weight, $xns_dl_outside_weight, $xns_dl_main_dec, $xns_dl_detail_dec, $xns_dl_add_compat, $xns_dl_des_img, $xns_dl_des_img_pos, $xns_dl_des_img_width, $xns_dl_des_img_height, $xns_dl_pop_win, $xns_dl_pop_win_width, $xns_dl_pop_win_height, $xns_dl_popimage_on, $xns_dl_newimage_on, $xns_dl_new_one, $xns_dl_new_two, $xns_dl_new_three, $xns_dl_auto_add, $xns_dl_reg_down, $xns_dl_fetch_down, $xns_dl_fetch_col);
    break;

}

} else {
	@include("header.php");
	GraphicAdmin();
	OpenTable();
	echo "<center><b>"._ERROR."</b><br><br>You do not have administration permission for module \"$module_name\"</center>";
	CloseTable();
	@include("footer.php");
}

?>