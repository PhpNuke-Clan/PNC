<?php

if (!defined('ADMIN_FILE')) {
	die ("Access Denied");
}
global $prefix, $db, $admin_file;
$aid = substr("$aid", 0,25);
$row = $db->sql_fetchrow($db->sql_query("SELECT radminsuper FROM " . $prefix . "_authors WHERE aid='$aid'"));
$row2 = $db->sql_fetchrow($db->sql_query("SELECT * FROM nukelan_admins WHERE aid='$aid'"));
if (($row['radminsuper'] == 1) OR ($row2['edit_admins'] == 1)) {
include("header.php");
lan_menu();

function displayadmins($error) {
    global $admin, $prefix, $db, $language, $multilingual, $admin_file;
    OpenTable();
    echo "<center><font class=\"title\"><b>" . _NLADMINSEC . "</b></font></center>";
	if ($error) {
	echo "<center><font color=red><b>$error</b></font></center>";
	}
    CloseTable();
    echo "<br>";
    OpenTable();
    echo "<center><font class=\"option\"><b>" . _EDITADMINS . "</b></font></center><br>"
	."<table border=\"1\" align=\"center\">";
    $result = $db->sql_query("SELECT * FROM nukelan_admins ORDER BY aid");
    while ($row = $db->sql_fetchrow($result)) {
	$a_aid = $row['aid'];
        $a_aid = substr("$a_aid", 0,25);
        echo "<tr><td align=\"center\">$a_aid</td>";
	    echo "<td align=\"center\">&nbsp;</td>";
    	echo "<td><a href=\"".$admin_file.".php?op=nl_admin&amp;aop=modify_nl_admin&amp;chng_aid=$a_aid\">" . _MODIFYINFO . "</a></td>";
		$num_god = $db->sql_numrows($db->sql_query("SELECT * FROM ".$prefix."_authors WHERE aid='$row[aid]' AND name='God'"));
		if($num_god) {
			echo "<td>" . _MAINACCOUNT . "</td></tr>";
		} else {
			echo "<td><a href=\"".$admin_file.".php?op=nl_admin&amp;aop=del_nl_admin&amp;del_aid=$a_aid\">" . _DELAUTHOR . "</a></td></tr>";
		}
    }
    echo "</table><br><center><font class=\"tiny\">" . _GODNOTDEL . "</font></center>";
    CloseTable();
    echo "<br>";
    OpenTable();
    echo "<center><font class=\"option\"><b>" . _ADDAUTHOR . "</b></font></center>"
	."<form action=\"".$admin_file.".php\" method=\"post\">"
	."<table border=\"0\">"
	."<tr><td>" . _NLCHOOSEADMIN . "</td>"
	."<td colspan=\"3\"><select name=add_aid>"
	."<option value=456asdf123>". _NLMAKESELECTION ."</option>";
	$adminquery = $db->sql_query("SELECT * FROM ".$prefix."_authors LEFT JOIN nukelan_admins ON ".$prefix."_authors.aid=nukelan_admins.aid WHERE nukelan_admins.aid IS NULL");
	while ($row = mysql_fetch_array($adminquery)) {
	echo "<option value='".$row[0]."'>".$row[0]."</option>";
	}
	echo "</select></td></tr>";	
    echo "<tr><td>" . _PERMISSIONS . ":</td>"
	."<td><input type=\"checkbox\" name=\"add_parties\" value=\"1\"> " . _NLADDPARTIES . "</td>"
	."<td><input type=\"checkbox\" name=\"add_staff\" value=\"1\"> " . _NLADDSTAFF . "</td>"
	."<td><input type=\"checkbox\" name=\"add_accessories\" value=\"1\"> " . _NLADDACCESSORIES . "</td>"
	."</tr><tr><td>&nbsp;</td>"
	."<td><input type=\"checkbox\" name=\"add_checkin\" value=\"1\"> " . _NLADDCHECKIN . "</td>"
	."<td><input type=\"checkbox\" name=\"add_tourneymod\" value=\"1\"> " . _NLADDTOURNEYMOD . "</td>"
	."<td><input type=\"checkbox\" name=\"add_editadmins\" value=\"1\"><b> " . _NLADDEDITADMINS . "</b></td>"
	."</tr>"
	."<tr><td>&nbsp;</td><td colspan=\"3\"><font class=\"tiny\"><i>" . _NLADDEDITWARNING . "</i></font></td></tr>"
	."<input type=\"hidden\" name=\"op\" value=\"nl_admin\">"
	."<input type=\"hidden\" name=\"aop\" value=\"add_nl_admin\">"
	."<tr><td><input type=\"submit\" value=\"" . _NLADDADMIN . "\"></td></tr>"
	."</table></form>";
    CloseTable();
    include("footer.php");
}

function modifyadmin($chng_aid) {
    global $prefix, $db, $multilingual, $admin_file;
    OpenTable();
    echo "<center><font class=\"title\"><b>" . _NLADMINSEC . "</b></font></center>";
    CloseTable();
    echo "<br>";
    OpenTable();
    echo "<center><font class=\"option\"><b>" . _MODIFYINFO . "</b></font></center><br><br>";
    $adm_aid = $chng_aid;
    $adm_aid = trim($adm_aid);
    $row = $db->sql_fetchrow($db->sql_query("SELECT * FROM nukelan_admins WHERE aid='$chng_aid'"));
    $chng_aid = $row['aid'];
    $chng_addparties = intval($row['parties']);
    $chng_addstaff = intval($row['staff']);
	$chng_addaccessories = intval($row['accessories']);
	$chng_addcheckin = intval($row['check_in']);
    $chng_addtourneymod = intval($row['tourney_mod']);
    $chng_addeditadmins = intval($row['edit_admins']);
    $chng_aid = substr("$chng_aid", 0,25);
    $aid = $chng_aid;
    echo "<form action=\"".$admin_file.".php\" method=\"post\">"
	."<table border=\"0\">";
	echo "<tr><td><b>$chng_aid</b></td></tr>";
	echo "<tr><td>" . _PERMISSIONS . ":</td>";
    if ($chng_addparties == 1) {
	$sel1 = "checked";
    } else {
	$sel1 = "";
    }
    if ($chng_addstaff == 1) {
	$sel2 = "checked";
    } else {
	$sel2 = "";
    }
    if ($chng_addaccessories == 1) {
	$sel3 = "checked";
    } else {
	$sel3 = "";
    }
    if ($chng_addcheckin == 1) {
	$sel4 = "checked";
    } else {
	$sel4 = "";
    }
    if ($chng_addtourneymod == 1) {
	$sel5 = "checked";
    } else {
	$sel5 = "";
    }
    if ($chng_addeditadmins == 1) {
	$sel6 = "checked";
    } else {
	$sel6 = "";
    }
    echo "<td><input type=\"checkbox\" name=\"chng_parties\" value=\"1\" $sel1> " . _NLADDPARTIES . "</td>"
	."<td><input type=\"checkbox\" name=\"chng_staff\" value=\"1\" $sel2> " . _NLADDSTAFF . "</td>"
	."<td><input type=\"checkbox\" name=\"chng_accessories\" value=\"1\" $sel3> " . _NLADDACCESSORIES . "</td>"
	."</tr><tr><td>&nbsp;</td>"
	."<td><input type=\"checkbox\" name=\"chng_checkin\" value=\"1\" $sel4> " . _NLADDCHECKIN . "</td>"
	."<td><input type=\"checkbox\" name=\"chng_tourneymod\" value=\"1\" $sel5> " . _NLADDTOURNEYMOD . "</td>"
	."<td><input type=\"checkbox\" name=\"chng_editadmins\" value=\"1\" $sel6> <b>" . _NLADDEDITADMINS . "</b></td>"
	."</tr><tr><td>&nbsp;</td>"
	."<td colspan=\"3\"><font class=\"tiny\"><i>" . _SUPERWARNING . "</i></font></td></tr>"
	."<input type=\"hidden\" name=\"op\" value=\"nl_admin\">"
	."<input type=\"hidden\" name=\"aop\" value=\"update_nl_admin\">"
	."<input type=\"hidden\" name=\"chng_aid\" value='$chng_aid'>"
	."<tr><td><input type=\"submit\" value=\"" . _SAVE . "\"> " . _GOBACK . ""
	."</td></tr></table></form>";
    CloseTable();
    include("footer.php");
}

switch ($aop) {

    case "mod_nl_admin":
    displayadmins('');
    break;

    case "modify_nl_admin":
    modifyadmin($chng_aid);
    break;

    case "update_nl_admin":
		$db->sql_query("UPDATE nukelan_admins SET parties='$chng_parties', staff='$chng_staff', accessories='$chng_accessories', check_in='$chng_checkin', tourney_mod='$chng_tourneymod', edit_admins='$chng_editadmins' WHERE aid='$chng_aid'");
		Header("Location: ".$admin_file.".php?op=nl_admin");
    break;

    case "add_nl_admin":
	if ($add_aid == '456asdf123') displayadmins(""._NLNOTAVALIDADMIN."");
    $add_aid = substr("$add_aid", 0,25);
    $result = $db->sql_query("insert into nukelan_admins values ('$add_aid', '$add_parties', '$add_staff', '$add_accessories', '$add_checkin', '$add_tourneymod', '$add_editadmins')");
    if (!$result) {
	return;
    }
    Header("Location: ".$admin_file.".php?op=nl_admin");
    break;

    case "del_nl_admin":
   		$db->sql_query("DELETE FROM nukelan_admins WHERE aid='$del_aid'");
		Header("Location: ".$admin_file.".php?op=nl_admin");
	break;
	default:
	displayadmins('');
	break;

}

} else {
    echo "Access Denied";
}

?>