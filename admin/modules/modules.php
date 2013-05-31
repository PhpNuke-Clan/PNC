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
/**********************************************************************************************/
/* PNC 4.1: PHOENIX Edition                                 COPYRIGHT                       */
/* Copyright (c) 2006 - 2007 by http://phpnuke-clan.com                                       */
/*  PHPNUKE-CLAN - SUPPORT                (support@phpnuke-clan.com)                          */
/**********************************************************************************************/
if ( !defined('ADMIN_FILE') ) {
        die("Illegal Admin File Access");
}

global $prefix, $db, $admin_file;
$aid = substr("$aid", 0,25);
$row = $db->sql_fetchrow($db->sql_query("SELECT radminsuper FROM " . $prefix . "_authors WHERE aid='$aid'"));
if ($row['radminsuper'] == 1) {

/*********************************************************/
/* Modules Functions                                     */
/*********************************************************/

function modules() {
    global $prefix, $db, $multilingual, $bgcolor2, $admin_file;
    include("header.php");
    GraphicAdmin();
    OpenTable();
    echo "<center><font class=\"title\"><b>" . _MODULESADMIN . "</b></font></center>";
    CloseTable();
    $handle=opendir('modules');
    while ($file = readdir($handle)) {
        if ( (!ereg("[.]",$file)) ) {
                $modlist .= "$file ";
        }
    }
    closedir($handle);
    $modlist = explode(" ", $modlist);
    sort($modlist);
    for ($i=0; $i < sizeof($modlist); $i++) {
        if($modlist[$i] != "") {
            $row = $db->sql_fetchrow($db->sql_query("SELECT mid from " . $prefix . "_modules where title='$modlist[$i]'"));
            $mid = intval($row['mid']);
            if ($mid == "") {
/*****************************************************/
/* Addon - Navigation / Module v.2.0.0         START */
/*****************************************************/
                $db->sql_query("insert into " . $prefix . "_modules values (NULL, '$modlist[$i]', '$modlist[$i]', '0', '0', '', '1', '0', '1', '')");
/*****************************************************/
/* Addon - Navigation / Module v.2.0.0           END */
/*****************************************************/
            }       
        }
    }
    $result2 = $db->sql_query("SELECT title from " . $prefix . "_modules");
    while ($row2 = $db->sql_fetchrow($result2)) {
        $title = $row2['title'];
        $a = 0;
        $handle=opendir('modules');
        while ($file = readdir($handle)) {
            if ($file == $title) {
                $a = 1;
            }
        }
        closedir($handle);
        if ($a == 0) {
            $db->sql_query("delete from " . $prefix . "_modules where title='$title'");
        }
    }
    echo "<br>";
    OpenTable();
    echo "<br><center><font class=\"option\">" . _MODULESADDONS . "</font><br><br>"
        ."<font class=\"content\">" . _MODULESACTIVATION . "</font><br><br>"
        ."" . _MODULEHOMENOTE . "<br><br>" . _NOTINMENU . "<br><br>" . _MENUNAVPNC . "<br><br>"
        ."<form action=\"".$admin_file.".php\" method=\"post\">"
        ."<table border=\"1\" align=\"center\" width=\"90%\"><tr><td align=\"center\" bgcolor=\"$bgcolor2\">"
        ."<b>"._TITLE."</b></td><td align=\"center\" bgcolor=\"$bgcolor2\"><b>"._CUSTOMTITLE."</b></td><td align=\"center\" bgcolor=\"$bgcolor2\"><b>"._STATUS."</b></td><td align=\"center\" bgcolor=\"$bgcolor2\"><b>"._VIEW."</b></td><td align=\"center\" bgcolor=\"$bgcolor2\"><b>"._GROUP."</b></td><td align=\"center\" bgcolor=\"$bgcolor2\"><b>"._FUNCTIONS."</b></td></tr>";
    $main_m = $db->sql_fetchrow($db->sql_query("SELECT main_module from " . $prefix . "_main"));
    $main_module = $main_m['main_module'];
/*****************************************************/
/* Addon - Navigation / Module v.2.0.0         START */
/*****************************************************/
    $result3 = $db->sql_query("SELECT mid, title, custom_title, active, view, inmenu, mod_group, mcid from " . $prefix . "_modules order by title ASC");
/*****************************************************/
/* Addon - Navigation / Module v.2.0.0           END */
/*****************************************************/
    while ($row3 = $db->sql_fetchrow($result3)) {
        $mid = intval($row3['mid']);
        $title = $row3['title'];
        $custom_title = $row3['custom_title'];
        $active = intval($row3['active']);
        $view = intval($row3['view']);
        $inmenu = intval($row3['inmenu']);
        $mod_group = intval($row3['mod_group']);
/*****************************************************/
/* Addon - Navigation / Module v.2.0.0         START */
/*****************************************************/
        $mcid = intval($row3['mcid']);
/*****************************************************/
/* Addon - Navigation / Module v.2.0.0           END */
/*****************************************************/
        if ($custom_title == "") {
            $custom_title = ereg_replace("_"," ",$title);
            $db->sql_query("update " . $prefix . "_modules set custom_title='$custom_title' where mid='$mid'");
        }
        if ($active == 1) {
				$active = "<img src=\"images/active.gif\" alt=\""._ACTIVE."\" title=\""._ACTIVE."\" border=\"0\" width=\"16\" height=\"16\">";
				$change = "<img src=\"images/inactive.gif\" alt=\""._DEACTIVATE."\" title=\""._DEACTIVATE."\" border=\"0\" width=\"16\" height=\"16\">";
            $act = 0;
        } else {
				$active = "<img src=\"images/inactive.gif\" alt=\""._INACTIVE."\" title=\""._INACTIVE."\" border=\"0\" width=\"16\" height=\"16\">";
				$change = "<img src=\"images/active.gif\" alt=\""._ACTIVATE."\" title=\""._ACTIVATE."\" border=\"0\" width=\"16\" height=\"16\">";
            $act = 1;
        }
			if (empty($custom_title)) {
            $custom_title = ereg_replace("_", " ", $title);
        }
        if ($view == 0) {
            $who_view = _MVALL;
        } elseif ($view == 1) {
            $who_view = _MVUSERS;
/*****************************************************/
/* Module - NSN Groups v.1.6.2                 START */
/*****************************************************/
        } elseif ($view == 2) {
            $who_view = _MVADMIN;
        } elseif ($view == 3) {
            $who_view = _SUBUSERS;
        } elseif ($view > 3) {
            $who_view = _MVGROUPS;
        }
/*****************************************************/
/* Module - NSN Groups v.1.6.2                   END */
/*****************************************************/
        if ($title != $main_module AND $inmenu == 0) {
            $title = "[ <big><strong>&middot;</strong></big> ] $title";
        }
        if ($title == $main_module) {
            $title = "<b>$title</b>";
            $custom_title = "<b>$custom_title</b>";
				$active = "$active <img src=\"images/key.gif\" alt=\""._INHOME."\" title=\""._INHOME."\" border=\"0\" width=\"17\" height=\"17\">";
            $who_view = "<b>$who_view</b>";
				$puthome = "<img src=\"images/key_x.gif\" alt=\""._INHOME."\" title=\""._INHOME."\" border=\"0\" width=\"17\" height=\"17\">";
				$change_status = "$change";
            $background = "bgcolor=\"$bgcolor2\"";
        } else {
				$puthome = "<a href=\"".$admin_file.".php?op=home_module&mid=$mid\"><img src=\"images/key.gif\" alt=\""._PUTINHOME."\" title=\""._PUTINHOME."\" border=\"0\" width=\"17\" height=\"17\"></a>";
            $change_status = "<a href=\"".$admin_file.".php?op=module_status&mid=$mid&active=$act\">$change</a>";
            $background = "";
        }
        if ($mod_group != 0) {
            $grp = $db->sql_fetchrow($db->sql_query("SELECT name FROM ".$prefix."_groups WHERE id='$mod_group'"));
            $mod_group = $grp['name'];
        } else {
            $mod_group = _NONE;
        }
        echo "<tr><td $background>&nbsp;$title</td><td align=\"center\" $background>$custom_title</td><td align=\"center\" $background>$active</td><td align=\"center\" $background>$who_view</td><td align=\"center\" $background>$mod_group</td><td align=\"center\" $background nowrap>&nbsp; <a href=\"".$admin_file.".php?op=module_edit&mid=$mid\"><img src=\"images/edit.gif\" alt=\""._EDIT."\" title=\""._EDIT."\" border=\"0\" width=\"17\" height=\"17\"></a>  $change_status  $puthome &nbsp;</td></tr>";
/*****************************************************/
/* Addon - Navigation / Module v.2.0.0         START */
/*****************************************************/
// Add A New Modules Category
    }
    echo "</table>";
    CloseTable();
    echo "<br>";

        OpenTable();
    echo"<h3>Only with use of Navigation block:</h3><br>";
    echo "<form method=\"post\" action=\"".$admin_file.".php\">"
        ."<font class=\"content\"><b>"._ADDMAINCATEGORY."</b><br><br>"
        .""._NAME.": <input type=\"text\" name=\"mcname\" size=\"30\" maxlength=\"100\"><br>"
        ."<input type=\"hidden\" name=\"op\" value=\"modules_add_category\">"
        ."<input type=\"submit\" value=\""._ADD."\"><br>"
        ."</form>";
  //  CloseTable();
    echo "<br><br>";

// Modify Category

    $result = $db->sql_query("select * from ".$prefix."_modules_categories");
    $numrows = $db->sql_numrows($result);
    if ($numrows>0) {
 //       OpenTable();
        echo "<form method=\"post\" action=\"".$admin_file.".php\">"
            ."<font class=\"content\"><b>"._MODCATEGORY."</b></font><br><br>";
        $result2=$db->sql_query("select mcid, mcname from ".$prefix."_modules_categories order by mcname");
        echo ""._CATEGORY.": <select name=\"cat\">";
        while(list($mcid2, $mcname2) = $db->sql_fetchrow($result2)) {
             echo "<option value=\"$mcid2\">$mcname2</option>";
        }
        echo "</select>"
            ."<input type=\"hidden\" name=\"op\" value=\"modules_edit_category\">"
            ."<input type=\"submit\" value=\""._MODIFY."\">"
            ."</form>";
        CloseTable();
    } else {
    }
    include("footer.php");
}
/*****************************************************/
/* Addon - Navigation / Module v.2.0.0           END */
/*****************************************************/

function home_module($mid, $ok=0) {
    global $prefix, $db, $admin_file;
    $mid = intval($mid);
    if ($ok == 0) {
        include("header.php");
        GraphicAdmin();
        title("" . _HOMECONFIG . "");
        OpenTable();
        $row = $db->sql_fetchrow($db->sql_query("SELECT title from " . $prefix . "_modules where mid='$mid'"));
        $new_m = $row['title'];
        $row2 = $db->sql_fetchrow($db->sql_query("SELECT main_module from " . $prefix . "_main"));
        $old_m = $row2['main_module'];
        echo "<center><b>" . _DEFHOMEMODULE . "</b><br><br>"
            ."" . _SURETOCHANGEMOD . " <b>$old_m</b> " . _TO . " <b>$new_m</b>?<br><br>"
            ."[ <a href=\"".$admin_file.".php?op=modules\">" . _NO . "</a> | <a href=\"".$admin_file.".php?op=home_module&mid=$mid&ok=1\">" . _YES . "</a> ]</center>";
        CloseTable();
        include("footer.php");
    } else {
        $row3 = $db->sql_fetchrow($db->sql_query("SELECT title from " . $prefix . "_modules where mid='$mid'"));
        $title = $row3['title'];
        $active = 1;
        $view = 0;
        $res = $db->sql_query("update " . $prefix . "_main set main_module='$title'");
        $res2 = $db->sql_query("update " . $prefix . "_modules set active='$active', view='$view' where mid='$mid'");
        Header("Location: ".$admin_file.".php?op=modules");
    }
}

function module_status($mid, $active) {
    global $prefix, $db, $admin_file;
    $mid = intval($mid);
    $db->sql_query("update " . $prefix . "_modules set active='$active' where mid='$mid'");
    Header("Location: ".$admin_file.".php?op=modules");
}

function module_edit($mid) {
    global $prefix, $db, $admin_file;
    $main_m = $db->sql_fetchrow($db->sql_query("SELECT main_module from " . $prefix . "_main"));
    $main_module = $main_m['main_module'];
    $mid = intval($mid);
/*****************************************************/
/* Module - NSN Groups v.1.6.2                 START */
/*****************************************************/
    $row = $db->sql_fetchrow($db->sql_query("SELECT * from " . $prefix . "_modules where mid='$mid'"));
        $groups = $row['groups'];
        $title = $row['title'];
/*****************************************************/
/* Module - NSN Groups v.1.6.2                   END */
/*****************************************************/
        $custom_title = $row['custom_title'];
        $view = intval($row['view']);
        $inmenu = intval($row['inmenu']);
        $mod_group = intval($row['mod_group']);
/*****************************************************/
/* Addon - Navigation / Module v.2.0.0         START */
/*****************************************************/
        $mcid = intval($row['mcid']);
/*****************************************************/
/* Addon - Navigation / Module v.2.0.0           END */
/*****************************************************/
    include("header.php");
    GraphicAdmin();
    title("" . _MODULEEDIT . "");
    OpenTable();
/*****************************************************/
/* Module - NSN Groups v.1.6.2                 START */
/*****************************************************/
    if ($view == 0) {
        $sel1 = "selected";
        $sel2 = "";
        $sel3 = "";
        $sel4 = "";
        $sel5 = "";
    } elseif ($view == 1) {
        $sel1 = "";
        $sel2 = "selected";
        $sel3 = "";
        $sel4 = "";
        $sel5 = "";
    } elseif ($view == 2) {
        $sel1 = "";
        $sel2 = "";
        $sel3 = "selected";    
        $sel4 = "";
        $sel5 = "";
    } elseif ($view == 3) {
        $sel1 = "";
        $sel2 = "";
        $sel3 = "";
        $sel4 = "selected";
        $sel5 = "";
    } elseif ($view > 3) {
        $sel1 = "";
        $sel2 = "";
        $sel3 = "";
        $sel4 = "";
        $sel5 = "selected";
    }
/*****************************************************/
/* Module - NSN Groups v.1.6.2                   END */
/*****************************************************/
    if ($title == $main_module) {
        $a = " - " . _INHOME . "";
    } else {
        $a = "";
    }
    if ($inmenu == 1) {
        $insel1 = "checked";
        $insel2 = "";
    } elseif ($inmenu == 0) {
        $insel1 = "";
        $insel2 = "checked";
    }
    echo "<center><b>" . _CHANGEMODNAME . "</b><br>($title$a)</center><br><br>"
        ."<form action=\"".$admin_file.".php\" method=\"post\">"
        ."<table border=\"0\"><tr><td>"
        ."" . _CUSTOMMODNAME . "</td><td>"
        ."<input type=\"text\" name=\"custom_title\" value=\"$custom_title\" size=\"50\"></td></tr>";
    if ($title == $main_module) {
        echo "<input type=\"hidden\" name=\"view\" value=\"0\">"
            ."<input type=\"hidden\" name=\"inmenu\" value=\"$inmenu\">"
            ."</table><br><br>";
    } else {
/*****************************************************/
/* Module - NSN Groups v.1.6.2                 START */
/*****************************************************/
        echo "<tr><td>" . _VIEWPRIV . "</td><td><select name=\"view\">"
            ."<option value=\"0\" $sel1>" . _MVALL . "</option>"
            ."<option value=\"1\" $sel2>" . _MVUSERS . "</option>"
            ."<option value=\"2\" $sel3>" . _MVADMIN . "</option>"
            ."<option value=\"3\" $sel4>" . _SUBUSERS . "</option>"
            ."<option value=\"4\" $sel5>"._MVGROUPS."</option>"
            ."</select></td></tr>";
        echo "<tr><td valign='middle'>"._WHATGROUPS."</td><td><select name='groups[]' multiple size='5'>";
        $ingroups = explode("-",$groups);
        $groupsResult = $db->sql_query("select gid, gname from ".$prefix."_nsngr_groups");
        while(list($gid, $gname) = $db->sql_fetchrow($groupsResult)) {
            if(in_array($gid,$ingroups)) { $sel = " selected"; } else { $sel = ""; }
            echo "<OPTION VALUE='$gid'$sel>$gname</option>";
        }
        echo "</select></td></tr>";
/*****************************************************/
/* Module - NSN Groups v.1.6.2                   END */
/*****************************************************/
        $numrow = $db->sql_numrows($db->sql_query("SELECT * FROM " . $prefix . "_groups"));
        if ($numrow > 0) {
            echo "<tr><td>" . _UGROUP . "</td><td><select name=\"mod_group\">";
        $result2 = $db->sql_query("SELECT id, name FROM " . $prefix . "_groups");
        while ($row2 = $db->sql_fetchrow($result2)) {
                if ($row2[id] == $mod_group) { $gsel = "selected"; } else { $gsel = ""; }
                if ($dummy != 1) {
                    if ($mod_group == 0) { $ggsel = "selected"; } else { $ggsel = ""; }
                    echo "<option value=\"0\" $ggsel>" . _NONE . "</option>";
                    $dummy = 1;
                }
                echo "<option value=\"$row2[id]\" $gsel>$row2[name]</option>";
                $gsel = "";
            }
            echo "</select>&nbsp;<i>(" . _VALIDIFREG . ")</i></td></tr>";
        } else {
            echo "<input type=\"hidden\" name=\"mod_group\" value=\"0\">";
        }
        echo "<tr><td>"._SHOWINMENU."</td><td>"
            ."<input type=\"radio\" name=\"inmenu\" value=\"1\" $insel1> " . _YES . " &nbsp;&nbsp; <input type=\"radio\" name=\"inmenu\" value=\"0\" $insel2> " . _NO . ""
/*****************************************************/
/* Addon - Navigation / Module v.2.0.0         START */
/*****************************************************/
 //          ."</td></tr></table><br><br>";
             ."</td></tr>";
            echo "<tr><td>"._CATEGORY.": </td><td><select name=\"mcat\">";
                $result2=$db->sql_query("select mcid, mcname from ".$prefix."_modules_categories order by mcid ASC");
                while(list($mcid2, $mcname2) = $db->sql_fetchrow($result2)) {
                        if ($mcid2==$mcid) {
                                        $sel = "selected";
                        } else {
                                        $sel = "";
                        }
                        echo "<option value=\"$mcid2\" $sel>$mcname2</option>";
                }
                echo "</select></td></tr></table><br><br>";
/*****************************************************/
/* Addon - Navigation / Module v.2.0.0           END */
/*****************************************************/
    }
    if ($title != $main_module) {
        
    }
    echo "<input type=\"hidden\" name=\"mid\" value=\"$mid\">"
        ."<input type=\"hidden\" name=\"op\" value=\"module_edit_save\">"
        ."<input type=\"submit\" value=\"" . _SAVECHANGES . "\">"
        ."</form>"
        ."<br><br><center>" . _GOBACK . "</center>";
    CloseTable();
    include("footer.php");
}

/*****************************************************/
/* Module - NSN Groups v.1.6.2                 START */
/* Addon - Navigation / Module v.2.0.0         START */
/*****************************************************/
function module_edit_save($mid, $custom_title, $view, $groups, $inmenu, $mod_group, $mcat) {
/*****************************************************/
/* Addon - Navigation / Module v.2.0.0           END */
/*****************************************************/
    global $prefix, $db, $admin_file;
/*****************************************************/
/* Addon - Navigation / Module v.2.0.0         START */
/*****************************************************/
    $mcat = explode("-", $mcat);
            if ($mcat[1]=="") {
                $mcat[1] = 0;
    }
/*****************************************************/
/* Addon - Navigation / Module v.2.0.0           END */
/*****************************************************/
    if($view == 4) { $ingroups = implode("-",$groups); }
    if($view < 4) { $ingroups = ""; }
    $mid = intval($mid);
    if ($view != 1) { $mod_group = 0; }
/*****************************************************/
/* Addon - Navigation / Module v.2.0.0         START */
/*****************************************************/
    $result = $db->sql_query("update " . $prefix . "_modules set custom_title='$custom_title', view='$view', groups='$ingroups', inmenu='$inmenu', mod_group='$mod_group', mcid='".$mcat[0]."' where mid='$mid'");
/*****************************************************/
/* Addon - Navigation / Module v.2.0.0           END */
/*****************************************************/
    Header("Location: ".$admin_file.".php?op=modules");
}
/*****************************************************/
/* Module - NSN Groups v.1.6.2                   END */
/* Addon - Navigation / Module v.2.0.0         START */
/*****************************************************/
function modules_add_category($mcname){
        global $prefix, $db, $admin_file;
        $result=$db->sql_query("SELECT * FROM ".$prefix."_modules_categories WHERE mcname='$mcname'");
        $numrows = $db->sql_numrows($result);
        if($numrows > 0){
                include("header.php");
                GraphicAdmin();
                OpenTable();
                        echo "<br><center><font class=\"content\">"
                            ."<b>"._ERRORTHECATEGORY." $title "._ALREADYEXIST."</b><br><br>"
                            .""._GOBACK."<br><br>";
                CloseTable();
                include("footer.php");
        } else {
                $db->sql_query("INSERT INTO ".$prefix."_modules_categories (mcid, mcname) VALUES (NULL, '$mcname')");
                header("Location: ".$admin_file.".php?op=modules");
        }
}

function modules_edit_category($cat) {
    global $prefix, $db, $admin_file;
    include("header.php");
    GraphicAdmin();
    OpenTable();
    echo "<center><font class=\"title\"><b>"._MODULESADMIN."</b></font></center>";
    CloseTable();
    echo "<br>";
    $cat = explode("-", $cat);
    if ($cat[1]=="") {
        $cat[1] = 0;
    }
       OpenTable();
    echo "<center><font class=\"content\"><b>"._MODCATEGORY."</b></font></center><br><br>";
    $result=$db->sql_query("select mcname, visible from ".$prefix."_modules_categories where mcid='$cat[0]'");
        //@RJR-Pwmg@Rncvkpwo@-@Eqratkijv@(e)@VgejIHZ.eqo
        list($mcname,$visible) = $db->sql_fetchrow($result);
        if ($visible == 1) {
                $insel1 = "checked";
                $insel2 = "";
            } elseif ($visible == 0) {
                $insel1 = "";
                $insel2 = "checked";
            }


        echo "<form action=\"".$admin_file.".php\" method=\"get\">"
            .""._NAME.": <input type=\"text\" name=\"mcname\" value=\"$mcname\" size=\"51\" maxlength=\"50\"><br>"
                ."Visible? <input type=\"radio\" name=\"visible\" value=\"1\" $insel1> "._YES." &nbsp;&nbsp; <input type=\"radio\" name=\"visible\" value=\"0\" $insel2> "._NO.""
            ."<input type=\"hidden\" name=\"mcid\" value=\"$cat[0]\">"
            ."<input type=\"hidden\" name=\"op\" value=\"modules_edit_category_save\">"
            ."<table border=\"0\"><tr><td>"
            ."<input type=\"submit\" value=\""._SAVECHANGES."\"></form></td><td>"
            ."<form action=\"".$admin_file.".php\" method=\"get\">"
            ."<input type=\"hidden\" name=\"mcid\" value=\"$cat[0]\">"
            ."<input type=\"hidden\" name=\"op\" value=\"modules_delete_category\">"
            ."<input type=\"submit\" value=\""._DELETE."\"></form></td></tr></table>";
    CloseTable();
    include("footer.php");
}

function modules_edit_category_save($mcid, $mcname, $visible) {
    global $prefix, $db, $admin_file;

        $db->sql_query("UPDATE ".$prefix."_modules_categories SET mcname='$mcname', visible='$visible' WHERE mcid='$mcid'");
    Header("Location: ".$admin_file.".php?op=modules");
}

function modules_delete_category($mcid, $ok) {
    global $prefix, $db, $admin_file;
    if($ok==1) {
            $db->sql_query("delete from ".$prefix."_modules_categories where mcid='$mcid'");

        Header("Location: ".$admin_file.".php?op=modules");
    } else {
        include("header.php");
        GraphicAdmin();
        OpenTable();
        echo "<br><center><font class=\"option\">";
        echo "<b>Are You Sure?</b><br><br>";
        }
        echo "[ <a href=\"".$admin_file.".php?op=modules_delete_category&amp;mcid=$mcid&amp;ok=1\">"._YES."</a> | <a href=\"".$admin_file.".php?op=modules\">"._NO."</a> ]<br><br>";

        CloseTable();
        include("footer.php");
}
/*****************************************************/
/* Addon - Navigation / Module v.2.0.0           END */
/*****************************************************/
switch ($op){

    case "modules":
    modules();
    break;

    case "module_status":
    module_status($mid, $active);
    break;

    case "module_edit":
    module_edit($mid);
    break;

    case "module_edit_save":
/*****************************************************/
/* Module - NSN Groups v.1.6.2                 START */
/* Addon - Navigation / Module v.2.0.0         START */
/*****************************************************/
    module_edit_save($mid, $custom_title, $view, $groups, $inmenu, $mod_group, $mcat);
/*****************************************************/
/* Addon - Navigation / Module v.2.0.0           END */
/* Module - NSN Groups v.1.6.2                   END */
/*****************************************************/
    break;

    case "home_module":
    home_module($mid, $ok);
    break;

/*****************************************************/
/* Addon - Navigation / Module v.2.0.0         START */
/*****************************************************/
    case "modules_add_category":
    modules_add_category($mcname);
    break;

    case "modules_edit_category":
    modules_edit_category($cat);
    break;

    case "modules_edit_category_save":
    modules_edit_category_save($mcid, $mcname, $visible);
    break;

    case "modules_delete_category":
    modules_delete_category($mcid, $ok);
    break;
/*****************************************************/
/* Addon - Navigation / Module v.2.0.0           END */
/*****************************************************/

}

} else {
    echo "Access Denied";
}

?>