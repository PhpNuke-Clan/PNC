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

@require_once("mainfile.php");


global $userinfo, $theme, $Default_Theme;
getusrinfo($user);
if ($userinfo[theme] != "") {
$ns_theme = $userinfo[theme];
} else {
$ns_theme = $Default_Theme;
}


/****************************************************/
/*                                                  */
/* Controls the Title Images. Leave this on, even   */
/* if you don't have images made. If the script     */
/* does not detect any images, it defaults to off.  */
/*                                                  */
$mod_title = 1;                                     
$mod_title2 = 1;                                    
$mod_title_directory = "images/module_titles";
/*                                                  */
/*                                                  */
/* Setting controls wether you see the 'other'      */
/* search engines when submitting a search. Set     */
/* to 1, and you will see the engines, and set to   */
/* 0, and you will not see them.                    */
/*                                                  */
$show_engines = 0;
/*                                                  */
/****************************************************/



function ns_download_mod_title() {
    global $module_name, $sitename, $ns_theme, $mod_title, $mod_title_directory;
    $alt_title = ereg_replace("_"," ",$module_name);
	if (($mod_title == 1) AND (file_exists("themes/$ns_theme/$mod_title_directory/$module_name.gif"))) {
    OpenTable();
    echo "<center><a href=\"modules.php?name=$module_name\">";
    echo "<img src=\"themes/$ns_theme/$mod_title_directory/$module_name.gif\" title=\"$sitename - $alt_title\" border=\"0\"></a></center>";
    echo "<br>";
    CloseTable();
	} else {
	title("$sitename: "._DOWNLOADS."");
	}
}



function ns_mod_title2($gif_name,$text) {
    global $module_name, $sitename, $ns_theme, $mod_title, $mod_title2, $mod_title_directory;
    $alt_title = ereg_replace("_"," ",$module_name);
    $no_mod_title = ereg_replace("_"," ",$text);
    OpenTable();
    if (($mod_title == 1) AND ($mod_title2 == 1) AND (file_exists("themes/$ns_theme/$mod_title_directory/$module_name/$gif_name.gif"))) {
    echo "<center><a href=\"modules.php?name=$module_name\">";
    echo "<img src=\"themes/$ns_theme/$mod_title_directory/$module_name/$gif_name.gif\" title=\"$sitename - $no_mod_title\" border=\"0\"></a></center>";
    } elseif (($mod_title == 1) AND ($mod_title2 == 0) AND (file_exists("themes/$ns_theme/$mod_title_directory/$module_name.gif"))) {
    echo "<center><a href=\"modules.php?name=$module_name\">";
    echo "<img src=\"themes/$ns_theme/$mod_title_directory/$module_name.gif\" title=\"$sitename - $alt_title\" border=\"0\"></a></center>";
    } else {
    echo "<center><font class=\"title\">$text</font></center>";
    }
    CloseTable();
}



function ns_dl_feature_box() {
global $module_name, $sitename, $ns_theme, $prefix, $db, $mod_title, $mod_title2, $mod_title_directory;
    $result = $db->sql_query("SELECT ns_download_image, ns_dl_feature, ns_dl_feature_info, ns_dl_feature_one_name, ns_dl_feature_one_link, ns_dl_feature_one_info, ns_dl_feature_two_name, ns_dl_feature_two_link, ns_dl_feature_two_info, ns_dl_feature_three_name, ns_dl_feature_three_link, ns_dl_feature_three_info, ns_dl_feature_four_name, ns_dl_feature_four_link, ns_dl_feature_four_info from ".$prefix."_ns_downloads");
    list($ns_download_image, $ns_dl_feature, $ns_dl_feature_info, $ns_dl_feature_one_name, $ns_dl_feature_one_link, $ns_dl_feature_one_info, $ns_dl_feature_two_name, $ns_dl_feature_two_link, $ns_dl_feature_two_info, $ns_dl_feature_three_name, $ns_dl_feature_three_link, $ns_dl_feature_three_info, $ns_dl_feature_four_name, $ns_dl_feature_four_link, $ns_dl_feature_four_info) = $db->sql_fetchrow($result);
        if ($ns_dl_feature == 1) {
    OpenTable();
    OpenTable2();
	if (($mod_title == 1) AND (file_exists("themes/$ns_theme/$mod_title_directory/$module_name/featured_downloads.gif"))) {
    echo "<center><img src=\"themes/$ns_theme/$mod_title_directory/$module_name/featured_downloads.gif\" title=\"$sitename - "._FEATUREDDOWNLOADS."\" border=\"0\"></a></center>";
	} else {
    echo "<center><font class=\"title\">"._FEATUREDDOWNLOADS."</font></center>";
	}
    CloseTable2();
echo "<br><table align=\"center\" width=\"100%\" cellpadding=\"3\" cellspacing=\"0\" border=\"0\">";
echo "<tr><td align=\"center\"><font class=\"title\">$ns_dl_feature_info</font>";
echo "</td></tr></table><br>";
echo "<table align=\"center\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">";
    if ($ns_dl_feature_one_name != "") {
	echo "<tr><td>";
        ns_dl_image();
	echo "</td>";
	echo "<td><a href=\"$ns_dl_feature_one_link\">$ns_dl_feature_one_name</a>";
	echo "</td></tr><tr><td>&nbsp;</td><td>";
	echo "<div align=\"justify\">$ns_dl_feature_one_info</div>";
	echo "</td></tr>";
    }
    if ($ns_dl_feature_two_name != "") {
	echo "<tr><td>";
        ns_dl_image();
	echo "</td>";
	echo "<td><a href=\"$ns_dl_feature_two_link\">$ns_dl_feature_two_name</a>";
	echo "</td></tr><tr><td>&nbsp;</td><td>";
	echo "<div align=\"justify\">$ns_dl_feature_two_info</div>";
	echo "</td></tr>";
	}
    if ($ns_dl_feature_three_name != "") {
	echo "<tr><td>";
        ns_dl_image();
	echo "</td>";
	echo "<td><a href=\"$ns_dl_feature_three_link\">$ns_dl_feature_three_name</a>";
	echo "</td></tr><tr><td>&nbsp;</td><td>";
	echo "<div align=\"justify\">$ns_dl_feature_three_info</div>";
	echo "</td></tr>";
    }
    if ($ns_dl_feature_four_name != "") {
	echo "<tr><td>";
        ns_dl_image();
	echo "</td>";
	echo "<td><a href=\"$ns_dl_feature_four_link\">$ns_dl_feature_four_name</a>";
	echo "</td></tr><tr><td>&nbsp;</td><td>";
	echo "<div align=\"justify\">$ns_dl_feature_four_info</div>";
	echo "</td></tr>";
    }
	echo "</table><br>";
CloseTable();
    }
}



function ns_dl_image() {
global $prefix, $db, $ns_theme, $sitename;
    $result = $db->sql_query("SELECT ns_download_image, ns_download_image_pos from ".$prefix."_ns_downloads");
    list($ns_download_image, $ns_download_image_pos) = $db->sql_fetchrow($result);
    if ($ns_download_image == "") {
	$dl_link_image = "";
    } else {
	$dl_link_image = "<span style=\"vertical-align=$ns_download_image_pos\">
	<img src=\"themes/$ns_theme/images/$ns_download_image\" border=\"0\"
	title=\"$sitename Downloads\"></span>&nbsp;&nbsp;";
    }
echo "$dl_link_image";
}



function ns_dl_get_rate_info() {
global $prefix, $db;
    $result_gi = $db->sql_query("SELECT ns_dl_anon_wait_days, ns_dl_outside_wait_days, ns_dl_anon_weight, ns_dl_outside_weight, ns_dl_main_dec, ns_dl_detail_dec from ".$prefix."_ns_downloads");
    list($ns_dl_anon_wait_days, $ns_dl_outside_wait_days, $ns_dl_anon_weight, $ns_dl_outside_weight, $ns_dl_main_dec, $ns_dl_detail_dec) = $db->sql_fetchrow($result_gi);
}



function ns_dl_popup() {
global $prefix, $db;
    $result_pu = $db->sql_query("SELECT ns_dl_pop_win_width, ns_dl_pop_win_height from ".$prefix."_ns_downloads");
    list($ns_dl_pop_win_width, $ns_dl_pop_win_height) = $db->sql_fetchrow($result_pu);
    echo "<script type=\"text/javascript\">\n";
    echo "function pop(page) {\n";
    echo "OpenWin = this.open(page, \"CtrlWindow\", \"toolbar=no,menubar=no,location=no,scrollbars=no,resize=yes,width=$ns_dl_pop_win_width,height=$ns_dl_pop_win_height,screenX=500,screenY=500,top=25,left=200\");\n";
    echo "}\n";
    echo "</script>\n";
}



function ns_download_image() {
    global $prefix, $db, $module_name;
    $result_pp = $db->sql_query("SELECT ns_dl_pop_win from ".$prefix."_ns_downloads");
    list($ns_dl_pop_win) = $db->sql_fetchrow($result_pp);
    if ($ns_dl_pop_win == 1) {
    ns_dl_popup();
    }
}



function ns_download_image_pop($lid, $ns_des_img, $description, $title) {
    global $prefix, $db, $module_name;
    $result_di = $db->sql_query("SELECT ns_dl_des_img, ns_dl_des_img_pos, ns_dl_des_img_width, ns_dl_des_img_height, ns_dl_pop_win from ".$prefix."_ns_downloads");
    list($ns_dl_des_img, $ns_dl_des_img_pos, $ns_dl_des_img_width, $ns_dl_des_img_height, $ns_dl_pop_win) = $db->sql_fetchrow($result_di);
    if (file_exists("modules/$module_name/copyright.php")) {
    echo "<br><br>";
    echo "<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" align=\"center\">";
    echo "<tr><td valign=\"top\"><div align=\"justify\">";
	if ($ns_dl_des_img == 1) {
	    if ($ns_dl_des_img_pos == "l") {
		$pos = "left";
	    } elseif ($ns_dl_des_img_pos == "r") {
		$pos = "right";
	    }
		if (($ns_dl_pop_win == 1) AND ($ns_des_img != "")) {
    echo "<a href=\"javascript:pop('$ns_des_img')\">";
    echo "<img src=\"$ns_des_img\" border=\"0\" align=\"$pos\" width=\"$ns_dl_des_img_width\" height=\"$ns_dl_des_img_height\" hspace=\"10\" title=\""._NSCLICKVIEW."\">";
    echo "</a>";
		} elseif ($ns_des_img != "") {
    echo "<img src=\"$ns_des_img\" border=\"0\" align=\"$pos\" width=\"$ns_dl_des_img_width\" height=\"$ns_dl_des_img_height\" hspace=\"10\" title=\""._NSDLIMAGEVIEW."\">";
		}
    echo "$description";
	} else {
    echo "$description";
	}
    echo "</div></td></tr></table><br><br>";
    echo "<center><img src=\"images/right.gif\" border=\"0\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    echo "<input type=\"button\" value=\""._DOWNLOADNOW."\" title=\"Download $title Now!\" onClick=\"window.location = 'modules.php?name=$module_name&d_op=getit&amp;lid=$lid'\">";
echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src=\"images/left.gif\" border=\"0\"></center><br>";
    } else {
    echo "<br>";
    echo "<br><center><b>Well, this is the last message.<br><br>Some people just don't appreciate Hard Work.</b></center><br>";
    die();
    }
}



function ns_download_image_adpop($ns_des_img, $description) {
    global $prefix, $db, $module_name;
    $result_di = $db->sql_query("SELECT ns_dl_des_img, ns_dl_des_img_pos, ns_dl_des_img_width, ns_dl_des_img_height, ns_dl_pop_win from ".$prefix."_ns_downloads");
    list($ns_dl_des_img, $ns_dl_des_img_pos, $ns_dl_des_img_width, $ns_dl_des_img_height, $ns_dl_pop_win) = $db->sql_fetchrow($result_di);
    echo "<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" align=\"center\">";
    echo "<tr><td valign=\"top\"><div align=\"justify\">";
	if ($ns_dl_des_img == 1) {
	    if ($ns_dl_des_img_pos == "l") {
		$pos = "left";
	    } elseif ($ns_dl_des_img_pos == "r") {
		$pos = "right";
	    }
		if (($ns_dl_pop_win == 1) AND ($ns_des_img != "")) {
		    echo "<a href=\"javascript:pop('$ns_des_img')\">";
		    echo "<img src=\"$ns_des_img\" border=\"0\" align=\"$pos\" ";
		    echo "width=\"$ns_dl_des_img_width\" height=\"$ns_dl_des_img_height\" ";
		    echo "hspace=\"10\" title=\""._NSCLICKVIEW."\">";
		    echo "</a>";
		} elseif ($ns_des_img != "") {
    		    echo "<img src=\"$ns_des_img\" border=\"0\" align=\"$pos\" ";
    		    echo "width=\"$ns_dl_des_img_width\" height=\"$ns_dl_des_img_height\" ";
    		    echo "hspace=\"10\" title=\""._NSDLIMAGEVIEW."\">";
		}
	echo "$description";
	} else {
	echo "$description";
	}
    echo "</div></td></tr></table><br><br>";
}



function ns_dl_foot_img($dlgif) {
    global $ns_theme, $module_name;
    if (file_exists("themes/$ns_theme/images/downloads/$dlgif")) {
    $ns_dl_foot_img = "themes/$ns_theme/images/downloads/$dlgif";
    } else {
    $ns_dl_foot_img = "modules/$module_name/images/downloads/$dlgif";
    }
    return($ns_dl_foot_img);
}


function ns_download_foot($homepage, $lid, $transfertitle, $totalcomments) {
    global $prefix, $db, $module_name, $ns_theme, $dlgif;
$dl_foot_img = 1;
if (($dl_foot_img == 1) AND (file_exists("themes/$ns_theme/images/downloads/$dlgif")) OR (file_exists("modules/$module_name/images/downloads/$dlgif"))) {
        if (($homepage == "") OR ($homepage == "http://") OR ($homepage == "http:///")) {
    echo "<br>";
        } else {
    $ns_dl_foot_img = ns_dl_foot_img("home.gif");
    echo "<br>";
    echo "<a href=\"$homepage\" target=\"_blank\">";
    echo "<img src=\"$ns_dl_foot_img\" border=\"0\" title=\""._HOMEPAGE."\"></a>";
    echo "&nbsp;&nbsp;";
        }
    $ns_dl_foot_img = ns_dl_foot_img("rate.gif");
    echo "<a href=\"modules.php?name=$module_name&d_op=ratedownload&amp;";
    echo "lid=$lid&amp;ttitle=$transfertitle#rate\">";
    echo "<img src=\"$ns_dl_foot_img\" border=\"0\" title=\""._RATERESOURCE."\"></a>";
    echo "&nbsp;&nbsp;";
    $ns_dl_foot_img = ns_dl_foot_img("broken.gif");
    echo "<a href=\"modules.php?name=$module_name&d_op=brokendownload&amp;";
    echo "lid=$lid#reportbroken\">";
    echo "<img src=\"$ns_dl_foot_img\" border=\"0\" title=\""._REPORTBROKEN."\"></a>";
    echo "&nbsp;&nbsp;";
    $ns_dl_foot_img = ns_dl_foot_img("details.gif");
    echo "<a href=\"modules.php?name=$module_name&d_op=viewdownloaddetails&amp;";
    echo "lid=$lid&amp;ttitle=$transfertitle#dldetails\">";
    echo "<img src=\"$ns_dl_foot_img\" border=\"0\" title=\""._DETAILS."\"></a>";
    echo "&nbsp;&nbsp;";
    if ($totalcomments != 0) {
    $ns_dl_foot_img = ns_dl_foot_img("comments.gif");
	if ($totalcomments != 1) {
    $ns_cnum = ""._SCOMMENTS."";
	} else {
    $ns_cnum = ""._NSCOMMENT."";
	}
    echo "<a href=\"modules.php?name=$module_name&d_op=viewdownloadcomments&amp;";
    echo "lid=$lid&amp;ttitle=$transfertitle#dlcom\">";
    echo "<img src=\"$ns_dl_foot_img\" border=\"0\" title=\"$totalcomments $ns_cnum\"></a>";
    echo "&nbsp;&nbsp;";
    }
} else {
    if (($homepage == "") OR ($homepage == "http://") OR ($homepage == "http:///")) {
    echo "<br>";
    } else {
    echo "<br>[ <a href=\"$homepage\" target=\"_blank\">"._HOMEPAGE."</a> ] - ";
    }
    echo "[ <a href=\"modules.php?name=$module_name&d_op=ratedownload&amp;";
    echo "lid=$lid&amp;ttitle=$transfertitle#rate\">"._RATERESOURCE."</a> ]";
    echo " - [ <a href=\"modules.php?name=$module_name&d_op=brokendownload&amp;";
    echo "lid=$lid#reportbroken\">"._REPORTBROKEN."</a> ]";
    echo " - [ <a href=\"modules.php?name=$module_name&d_op=viewdownloaddetails&amp;";
    echo "lid=$lid&amp;ttitle=$transfertitle#dldetails\">"._DETAILS."</a> ]";
    if ($totalcomments != 0) {
    echo " - [ <a href=\"modules.php?name=$module_name&d_op=viewdownloadcomments&amp;";
    echo "lid=$lid&amp;ttitle=$transfertitle#dlcom\">$totalcomments ";
	if ($totalcomments != 1) {
    echo ""._SCOMMENTS."</a> ]";
	} else {
    echo ""._NSCOMMENT."</a> ]"; }
	}
    }

}


function ns_dl_admin($lid, $admin) {
    global $admin, $admin_file;
    if (is_admin($admin)) {
    echo "<br><br><div align=\"left\">";
    echo "<b>"._ADMINOPTIONS.":</b> ";
    echo "<a href=\"".$admin_file.".php?op=DownloadsModDownload&amp;lid=$lid\">"._EDIT."</a>";
    echo "</div><br>";
    }
}

?>