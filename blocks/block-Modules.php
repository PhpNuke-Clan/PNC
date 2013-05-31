<?php

/************************************************************************/
/* PHP-NUKE: Web Portal System                                          */
/* ===========================                                          */
/*                                                                      */
/* Copyright (c) 2002 by Francisco Burzi                                */
/* http://phpnuke.org                                                   */
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
/* Tweaked by ArtificialIntel                                           */
/* Tweak Copyright (c) 2003 by ArtificialIntel                          */
/* Web Site: http://the-sci-factor.kicks-ass.net                        */
/* Updated For PHPNuke 7.5 by SPCDATA http://www.nextnet.se             */
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

if ( !defined('BLOCK_FILE') ) {
	Header("Location: ../index.php");
	die();
}

global $prefix, $db, $admin, $user;

    $ThemeSel = get_theme();
    if (file_exists("themes/$ThemeSel/module.php")) {
        include("themes/$ThemeSel/module.php");
        if (is_active("$default_module") AND file_exists("modules/$default_module/index.php")) {
            $def_module = $default_module;
        } else {
            $def_module = "";
        }
    }

    $sql = "SELECT main_module FROM ".$prefix."_main";
    $result = $db->sql_query($sql);
    $row = $db->sql_fetchrow($result);
    $main_module = $row[main_module];

    /* If the module doesn't exist, it will be removed from the database automaticaly */

    $sql = "SELECT title FROM ".$prefix."_modules";
    $result = $db->sql_query($sql);
    while ($row = $db->sql_fetchrow($result)) {
        $title = $row[title];
        $a = 0;
        $handle=opendir('modules');
        while ($file = readdir($handle)) {
                if ($file == $title) {
                $a = 1;
            }
        }
        closedir($handle);
        if ($a == 0) {
            $db->sql_query("DELETE FROM ".$prefix."_modules WHERE title='$title'");
        }
    }

    /* Now we make the Modules block with the correspondent links */

    $content .= "<strong><big>&middot;</big></strong>&nbsp;<a href=\"index.php\">"._HOME."</a><br>\n";

    $sql = "SELECT mcid, mcname FROM ".$prefix."_modules_categories WHERE visible='1' ORDER BY mcid ASC";
    $result2 = $db->sql_query($sql);
    while ($row = $db->sql_fetchrow($result2)) {
    $mcid = $row[mcid];
    $mcname = $row[mcname];
    $content .="<br><b>".$mcname."</b><br>\n";
/*****************************************************/
/* Module - NSN Groups v.1.6.3                 START */
/*****************************************************/
    $result3 = $db->sql_query("SELECT * FROM " . $prefix . "_modules WHERE active='1' AND title!='$def_module' AND inmenu='1' AND mcid='$mcid' ORDER BY custom_title ASC");
    while ($row3 = $db->sql_fetchrow($result3)) {
    $groups = $row3['groups'];
    $m_title = stripslashes($row3['title']);
/*****************************************************/
/* Module - NSN Groups v.1.6.3                   END */
/*****************************************************/
        $custom_title = $row[custom_title];
        $view = $row[view];
        $m_title2 = ereg_replace("_", " ", $m_title);
        if ($custom_title != "") {
            $m_title2 = $custom_title;
        }
/*****************************************************/
/* Module - NSN Groups v.1.6.3                 START */
/*****************************************************/
            if ($m_title != $main_module) {
                    if ($view == 0) {
                        $content .= "<strong><big>&middot;</big></strong>&nbsp;<a href=\"modules.php?name=$m_title\">$m_title2</a><br>\n";
                    } elseif ($view == 1 AND is_user($user)) {
                        $content .= "<strong><big>&middot;</big></strong>&nbsp;<a href=\"modules.php?name=$m_title\">$m_title2</a><br>\n";
                    } elseif ($view == 2 AND is_admin($admin)) {
                        $content .= "<strong><big>&middot;</big></strong>&nbsp;<a href=\"modules.php?name=$m_title\">$m_title2</a><br>\n";
                    } elseif ($view == 3 AND paid()) {
                        $content .= "<strong><big>&middot;</big></strong>&nbsp;<a href=\"modules.php?name=$m_title\">$m_title2</a><br>\n";
                    } elseif ($view > 3 AND in_groups($groups)) {
                $content .= "<strong><big>&middot;</big></strong>&nbsp;<a href=\"modules.php?name=$m_title\">$m_title2</a><br>\n";
                }
/*****************************************************/
/* Module - NSN Groups v.1.6.3                   END */
/*****************************************************/
            }
        }
    }

    /* If you're Admin you and only you can see Inactive modules and test it */
    /* If you copied a new module is the /modules/ directory, it will be added to the database */

    if (is_admin($admin)) {
        $handle=opendir('modules');
        while ($file = readdir($handle)) {
            if ( (!ereg("[.]",$file)) ) {
                $modlist .= "$file ";
            }
        }
            $content .= "<br><center><b>Invisible Categories</b></center><br>";
            $sql = "SELECT mcid, mcname FROM ".$prefix."_modules_categories WHERE visible='0' ORDER BY mcid ASC";
            $result2 = $db->sql_query($sql);
            while ($row = $db->sql_fetchrow($result2)) {
            $mcid = $row[mcid];
            $mcname = $row[mcname];
            $content .="<br><b>".$mcname."</b><br>\n";
            $sql = "SELECT title, custom_title, view FROM ".$prefix."_modules WHERE active='1' AND title!='$def_module' AND inmenu='1' AND mcid='$mcid' ORDER BY custom_title ASC";
            $result = $db->sql_query($sql);
            while ($row = $db->sql_fetchrow($result)) {
                $m_title = $row[title];
                $custom_title = $row[custom_title];
                $view = $row[view];
                $m_title2 = ereg_replace("_", " ", $m_title);
                if ($custom_title != "") {
                    $m_title2 = $custom_title;
                }
                if ($m_title != $main_module) {
                    if ((is_admin($admin) AND $view == 2) OR $view != 2) {
                        $content .= "<strong><big>&middot;</big></strong>&nbsp;<a href=\"modules.php?name=$m_title\">$m_title2</a><br>\n";
                    }
                }
            }
        }
        closedir($handle);
        $modlist = explode(" ", $modlist);
        sort($modlist);
        for ($i=0; $i < sizeof($modlist); $i++) {
            if($modlist[$i] != "") {
                $sql = "SELECT mid FROM ".$prefix."_modules WHERE title='$modlist[$i]'";
                $result = $db->sql_query($sql);
                $row = $db->sql_fetchrow($result);
                $mid = $row[mid];
                if ($mid == "") {
/*****************************************************/
/* Module - NSN Groups v.1.6.3                 START */
/*****************************************************/
                    //$db->sql_query("INSERT INTO ".$prefix."_modules VALUES (NULL, '$modlist[$i]', '$mod_uname', '0', '0', '1', '0', '0', '')");
                    $db->sql_query("INSERT INTO ".$prefix."_modules values (NULL, '$modlist[$i]', '$modlist[$i]', '0', '0', '', '1', '0', '1', '')");
/*****************************************************/
/* Module - NSN Groups v.1.6.3                   END */
/*****************************************************/
                }
            }
        }
        $content .= "<br><center><b>"._INVISIBLEMODULES."</b><br>";
        $content .= "<font class=\"tiny\">"._ACTIVEBUTNOTSEE."</font></center><br>";
        $sql = "SELECT title, custom_title FROM ".$prefix."_modules WHERE active='1' AND inmenu='0' ORDER BY title ASC";
        $result = $db->sql_query($sql);
        while ($row = $db->sql_fetchrow($result)) {
            $mn_title = $row[title];
            $custom_title = $row[custom_title];
            $mn_title2 = ereg_replace("_", " ", $mn_title);
            if ($custom_title != "") {
                $mn_title2 = $custom_title;
            }
            if ($mn_title2 != "") {
                $content .= "<strong><big>&middot;</big></strong>&nbsp;<a href=\"modules.php?name=$mn_title\">$mn_title2</a><br>\n";
                $dummy = 1;
            } else {
                $a = 1;
            }
        }
        if ($a == 1 AND $dummy != 1) {
                $content .= "<strong><big>&middot;</big></strong>&nbsp;<i>"._NONE."</i><br>\n";
        }
        $content .= "<br><center><b>"._NOACTIVEMODULES."</b><br>";
        $content .= "<font class=\"tiny\">"._FORADMINTESTS."</font></center><br>";
        //@RJR-Pwmg@Rncvkpwo@-@Eqratkijv@(e)@VgejIHZ.eqo
        $sql = "SELECT title, custom_title FROM ".$prefix."_modules WHERE active='0' ORDER BY title ASC";
        $result = $db->sql_query($sql);
        while ($row = $db->sql_fetchrow($result)) {
            $mn_title = $row[title];
            $custom_title = $row[custom_title];
            $mn_title2 = ereg_replace("_", " ", $mn_title);
            if ($custom_title != "") {
                $mn_title2 = $custom_title;
            }
            if ($mn_title2 != "") {
                $content .= "<strong><big>&middot;</big></strong>&nbsp;<a href=\"modules.php?name=$mn_title\">$mn_title2</a><br>\n";
                $dummy = 1;
            } else {
                $a = 1;
            }
        }
        if ($a == 1 AND $dummy != 1) {
                $content .= "<strong><big>&middot;</big></strong>&nbsp;<i>"._NONE."</i><br>\n";
        }
    }

?>