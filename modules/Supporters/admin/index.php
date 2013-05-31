<?php

/********************************************************/
/* NSN Supporters(TM) Universal                         */
/* By: NukeScripts Network (webmaster@nukescripts.net)  */
/* http://www.nukescripts.net                           */
/* Copyright © 2003 by NukeScripts Network              */
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

if ( !defined('ADMIN_FILE') ) {
	die("Illegal Admin File Access");
}

global $admin_file;

$modname = "Supporters";

@require_once("mainfile.php");
get_lang($modname);
$supporter_config = $db->sql_fetchrow($db->sql_query("SELECT * from ".$prefix."_nsnsp_config"));
$index=1;
$aid = substr("$aid", 0,25);
$row = $db->sql_fetchrow($db->sql_query("SELECT title, admins FROM ".$prefix."_modules WHERE title='$modname'"));
$row2 = $db->sql_fetchrow($db->sql_query("SELECT name, radminsuper FROM ".$prefix."_authors WHERE aid='$aid'"));
$admins = explode(",", $row['admins']);
$auth_user = 0;
for ($i=0; $i < sizeof($admins); $i++) {
    if ($row2['name'] == "$admins[$i]" AND $row['admins'] != "") {
        $auth_user = 1;	
    }
}

if ($row2['radminsuper'] == 1 || $auth_user == 1) {

function spmenu() {
    global $admin_file;
    OpenTable();
    echo "<center>\n<table cellpadding='3' width='70%'>\n";
    echo "<tr>\n";
    echo "<td align='center' valign='top' width='50%'>";
    echo "<a href='".$admin_file.".php?op=Supporters'>"._ADMINMAIN."</a><br>\n";
    echo "<a href='".$admin_file.".php?op=SupportersConfig'>"._CONFIGMAIN."</a><br>";
    echo "<a href='".$admin_file.".php?op=Supportersadd'>"._ADDSUPPORTER."</a><br>";
    echo "</td>\n";
    echo "<td align='center' valign='top' width='50%'>";
    echo "<a href='".$admin_file.".php?op=Supportersactive'>"._ACTIVESITES."</a><br>";
    echo "<a href='".$admin_file.".php?op=Supporterspending'>"._SUBMITTEDSITES."</a><br>";
    echo "<a href='".$admin_file.".php?op=Supportersinactive'>"._INACTIVESITES."</a><br>";
    echo "</td>\n";
    echo "</tr>\n";
    echo "<tr><td align='center' colspan='2'><a href='".$admin_file.".php'><i>"._SITEADMIN."</i></a></td></tr>\n";
    echo "</table>\n</center>\n";
    CloseTable();
}

switch ($op) {

    case "Supporters":
        $pagetitle = _ADMINMAIN;
        @include("header.php");
        title(_ADMINMAIN);
        spmenu();
        @include("footer.php");
    break;

    case "Supportersadd":
        $pagetitle = _ADMINMAIN."/"._ADDSUPPORTER;
        @include("header.php");
        spmenu();
        echo "<br>\n";
        OpenTable();
        title(_ADDSUPPORTER);
        echo "<center><br>"._ALLREQ."<br>\n";
        echo "<table border='0'>\n";
        if ($supporter_config['image_type']==0) { $enctype = ""; } else { $enctype = "enctype='multipart/form-data'"; }
        echo "<form action='".$admin_file.".php?op=Supportersadd_save' method='post'$enctype>\n";
        echo "<input type='hidden' name='user_id' value='$suid'>\n";
        echo "<tr><td><b>"._SITENAME.":</b></td><td><input type='text' name='site_name' size='50'></td></tr>\n";
        echo "<tr><td><b>"._SITEURL.":</b></td><td><input type='text' name='site_url' size='50' value='$surl'></td></tr>\n";
        if ($supporter_config['image_type']==0) { $type = "type='input'"; } else { $type = "type='file'"; }
        echo "<tr><td valign='top'><b>"._SITEIMAGE.":</b></td><td><input $type name='site_image' size='50'><br>";
        echo ""._MUSTBE."</td></tr>\n";
        echo "<tr><td valign='top'><b>"._SITEDESCRIPTION.":</b></td><td><textarea rows='5' cols='80' name='site_description'></textarea></td></tr>\n";
        echo "<tr><td><b>"._SUPPORTERNAME.":</b></td><td><input type='test' name='user_name' size='40'></td></tr>\n";
        echo "<tr><td><b>"._SUPPORTEREMAIL.":</b></td><td><input type='text' name='user_email' size='40'></td></tr>\n";
        echo "<tr><td><b>"._SUPPORTERIP.":</b></td><td><input type='text' name='user_ip' value='0.0.0.0' size='40'></td></tr>\n";
        echo "<tr><td align='center' colspan='2'><input type='submit' value='"._SADDSITE."'></td></tr>\n";
        echo "</form></table></center>\n";
        CloseTable();
        @include("footer.php");
    break;

    case "Supporterspending":
        $pagetitle = _ADMINMAIN."/"._SUBMITTEDSITES;
        @include("header.php");
        spmenu();
        echo "<br>\n";
        OpenTable();
        title(_SUBMITTEDSITES);
        $a = 0;
        $result = $db->sql_query("SELECT * FROM ".$prefix."_nsnsp_sites WHERE site_status='0' ORDER BY site_name");
        $numrows = $db->sql_numrows($result);
        if ($numrows > 0) {
            echo "<table border='0' cellpadding='2' cellspacing='5' width='100%'>";
            while ($site_row = $db->sql_fetchrow($result)) {
                if ($a == 0) { echo "<tr>"; }
                echo "<td width='50%' valign='top'>";
                OpenTable();
                echo "<table border='0' width='100%'>";
                echo "<tr><td width='25%' align='center' valign='top' rowspan='3'>";
                echo "<a href='modules.php?name=$modname&op=go&site_id=".$site_row['site_id']."' target='_blank'><img src='".$site_row['site_image']."' border='0' alt='".$site_row['site_name']."' title='".$site_row['site_name']."' height='31' width='88'></a>";
                echo " <a href='".$admin_file.".php?op=Supportersappv&amp;site_id=".$site_row['site_id']."'><img src='modules/$modname/images/approve.gif' border='0' alt='"._APPROVE."' title='"._APPROVE."'></a>";
                echo " <a href='".$admin_file.".php?op=Supportersedit&amp;site_id=".$site_row['site_id']."'><img src='modules/$modname/images/edit.gif' border='0' alt='"._EDIT."' title='"._EDIT."'></a>";
                echo " <a href='".$admin_file.".php?op=Supportersdelete&amp;site_id=".$site_row['site_id']."'><img src='modules/$modname/images/delete.gif' border='0' alt='"._DELETE."' title='"._DELETE."'></a>";
                echo "</td>\n<td width='75%' valign='top'><b>"._SUPPORTERDATE.":</b> ".$site_row['site_date']."</td></tr>";
                echo "<tr><td valign='top'><b>"._SITEDESCRIPTION."</b>: ".$site_row['site_description']."</td></tr>";
                echo "<tr><td valign='top'><b>"._SITEHITS."</b>: ".$site_row['site_hits']."</td></tr>";
                echo "</table>";
                CloseTable();
                echo "</td>";
                $a++;
                if ($a == 2) { echo "</tr>"; $a = 0; }
            }
            if ($a ==1) { echo "<td width='50%'>&nbsp;</td></tr></table>"; } else { echo "</tr></table>"; }
        } else {
            title(_NOSUBMITTEDSITES);
        }
        CloseTable();
        @include("footer.php");
    break;

    case "Supportersinactive":
        $pagetitle = _ADMINMAIN."/"._INACTIVESITES;
        @include("header.php");
        spmenu();
        echo "<br>\n";
        OpenTable();
        title(_INACTIVESITES);
        $a = 0;
        $result = $db->sql_query("SELECT * FROM ".$prefix."_nsnsp_sites WHERE site_status='-1' ORDER BY site_name");
        $numrows = $db->sql_numrows($result);
        if ($numrows > 0) {
            echo "<table border='0' cellpadding='2' cellspacing='5' width='100%'>";
            while ($site_row = $db->sql_fetchrow($result)) {
                if ($a == 0) { echo "<tr>"; }
                echo "<td width='50%' valign='top'>";
                OpenTable();
                echo "<table border='0' width='100%'>";
                echo "<tr><td width='25%' align='center' valign='top' rowspan='3'>";
                echo "<a href='modules.php?name=$modname&op=go&site_id=".$site_row['site_id']."' target='_blank'><img src='".$site_row['site_image']."' border='0' alt='".$site_row['site_name']."' title='".$site_row['site_name']."' height='31' width='88'></a>";
                echo " <a href='".$admin_file.".php?op=Supportersactivate&amp;site_id=".$site_row['site_id']."'><img src='modules/$modname/images/activate.gif' border='0' alt='"._ACTIVATE."' title='"._ACTIVATE."'></a>";
                echo " <a href='".$admin_file.".php?op=Supportersedit&amp;site_id=".$site_row['site_id']."'><img src='modules/$modname/images/edit.gif' border='0' alt='"._EDIT."' title='"._EDIT."'></a>";
                echo " <a href='".$admin_file.".php?op=Supportersdelete&amp;site_id=".$site_row['site_id']."'><img src='modules/$modname/images/delete.gif' border='0' alt='"._DELETE."' title='"._DELETE."'></a>";
                echo "</td>\n<td width='75%' valign='top'><b>"._SUPPORTERDATE.":</b> ".$site_row['site_date']."</td></tr>";
                echo "<tr><td valign='top'><b>"._SITEDESCRIPTION."</b>: ".$site_row['site_description']."</td></tr>";
                echo "<tr><td valign='top'><b>"._SITEHITS."</b>: ".$site_row['site_hits']."</td></tr>";
                echo "</table>";
                CloseTable();
                echo "</td>";
                $a++;
                if ($a == 2) { echo "</tr>"; $a = 0; }
            }
            if ($a ==1) { echo "<td width='50%'>&nbsp;</td></tr></table>"; } else { echo "</tr></table>"; }
        } else {
            title(_NOINACTIVESITES);
        }
        CloseTable();
        @include("footer.php");
    break;

    case "Supportersactive":
        $pagetitle = _ADMINMAIN."/"._ACTIVESITES;
        @include("header.php");
        spmenu();
        echo "<br>\n";
        OpenTable();
        title(_ACTIVESITES);
        $a = 0;
        $result = $db->sql_query("SELECT * FROM ".$prefix."_nsnsp_sites WHERE site_status='1' ORDER BY site_name");
        $numrows = $db->sql_numrows($result);
        if ($numrows > 0) {
            echo "<table border='0' cellpadding='2' cellspacing='5' width='100%'>";
            while ($site_row = $db->sql_fetchrow($result)) {
                if ($a == 0) { echo "<tr>"; }
                echo "<td width='50%' valign='top'>";
                OpenTable();
                echo "<table border='0' width='100%'>";
                echo "<tr><td width='25%' align='center' valign='top' rowspan='3'>";
                echo "<a href='modules.php?name=$modname&op=go&site_id=".$site_row['site_id']."' target='_blank'><img src='".$site_row['site_image']."' border='0' alt='".$site_row['site_name']."' title='".$site_row['site_name']."' height='31' width='88'></a>";
                echo " <a href='".$admin_file.".php?op=Supportersdeactivate&amp;site_id=".$site_row['site_id']."'><img src='modules/$modname/images/deactivate.gif' border='0' alt='"._DEACTIVATE."' title='"._DEACTIVATE."'></a>";
                echo " <a href='".$admin_file.".php?op=Supportersedit&amp;site_id=".$site_row['site_id']."'><img src='modules/$modname/images/edit.gif' border='0' alt='"._EDIT."' title='"._EDIT."'></a>";
                echo " <a href='".$admin_file.".php?op=Supportersdelete&amp;site_id=".$site_row['site_id']."'><img src='modules/$modname/images/delete.gif' border='0' alt='"._DELETE."' title='"._DELETE."'></a>";
                echo "</td>\n<td width='75%' valign='top'><b>"._SUPPORTERDATE.":</b> ".$site_row['site_date']."</td></tr>";
                echo "<tr><td valign='top'><b>"._SITEDESCRIPTION."</b>: ".$site_row['site_description']."</td></tr>";
                echo "<tr><td valign='top'><b>"._SITEHITS."</b>: ".$site_row['site_hits']."</td></tr>";
                echo "</table>";
                CloseTable();
                echo "</td>";
                $a++;
                if ($a == 2) { echo "</tr>"; $a = 0; }
            }
            if ($a ==1) { echo "<td width='50%'>&nbsp;</td></tr></table>"; } else { echo "</tr></table>"; }
        } else {
            title(_NOACTIVESITES);
        }
        CloseTable();
        @include("footer.php");
    break;

    case "Supportersappv":
        $pagetitle = _ADMINMAIN." - "._ADMINAPV;
        $result = $db->sql_query("select * from ".$prefix."_nsnsp_sites where site_id='$site_id'");
        $site_row = $db->sql_fetchrow($result);
        @include("header.php");
        spmenu();
        echo "<br>\n";
        OpenTable();
        title(_ADMINAPV);
        echo "<center><table border='0'>";
        echo "<form action='".$admin_file.".php?op=Supportersappv_save' method='post' enctype='multipart/form-data'>";
        echo "<input type='hidden' name='site_id' value='".$site_row['site_id']."'>";
        echo "<input type='hidden' name='old_image' value='".$site_row['site_image']."'>";
        echo "<input type='hidden' name='user_id' value='".$site_row['user_id']."'>";
        echo "<tr><td><b>"._SITENAME.":</b></td><td><input type='text' name='site_name' size='30' value='".$site_row['site_name']."'></tr></td>";
        echo "<tr><td><b>"._SITEURL.":</b></td><td><input type='text' name='site_url' size='60' value='".$site_row['site_url']."'></tr></td>";
        echo "<tr><td valign='top'><b>"._SITEIMAGE.":</b></td><td><input type='file' name='new_image' size='30'><br>".$site_row['site_image']."</tr></td>";
        echo "<tr><td><b>"._SUPPORTERDATE.":</b></td><td><input type='text' name='site_date' size='30' value='".$site_row['site_date']."'></tr></td>";
        echo "<tr><td valign='top'><b>"._SITEDESCRIPTION.":</b></td><td><textarea rows='5' cols='50' name='site_description'>".$site_row['site_description']."</textarea></tr></td>";
        echo "<tr><td><b>"._USERNAME.":</b></td><td>".$site_row['user_name']." (".$site_row['user_id'].")</tr></td>";
        echo "<tr><td><b>"._USEREMAIL.":</b></td><td>".$site_row['user_email']."</tr></td>";
        echo "<tr><td><b>"._USERIP."</b></td><td>".$site_row['user_ip']."</tr></td>";
        echo "<tr><td align='center' colspan='2'><input type='submit' value='"._APPROVE."'></td></tr>";
        echo "</form></table></center>";
        CloseTable();
        @include("footer.php");
    break;
    
    case "Supportersappv_save":
        $oid = str_pad($site_id, 6, "0", STR_PAD_LEFT);
        $newimage_name = $_FILES['new_image']['name'];
        $newimage_temp = $_FILES['new_image']['tmp_name'];
        if ($newimage_name != "") {
            $ext = substr($newimage_name, strrpos($newimage_name,'.'), 5);
            if (move_uploaded_file($newimage_temp, "modules/$modname/images/supporters/$oid$ext")) {
                chmod ("modules/$modname/images/supporters/$oid$ext", 0777);
                $imgurl = "modules/$modname/images/supporters/$oid$ext";
            } else {
                echo _NOUPLOAD."<br>\n";
                echo _GOBACK;
                die();
            }
        } else {
            $imgurl = $old_image;
        }
        $result = $db->sql_query("UPDATE ".$prefix."_nsnsp_sites SET site_name='$site_name', site_url='$site_url', site_image='$imgurl', site_status='1', site_hits='$site_hits', site_date='$site_date', site_description='$site_description' where site_id='$site_id'");
        Header("Location: ".$admin_file.".php?op=Supporterspending");
    break;

    case "Supportersdelete":
        $pagetitle = _ADMINMAIN." - "._ADMINDEL;
        $comefrom = $_SERVER['HTTP_REFERER'];
        $result = $db->sql_query("select site_name, site_url from ".$prefix."_nsnsp_sites where site_id='$site_id'");
        list($site_name, $site_url) = $db->sql_fetchrow($result);
        @include("header.php");
        spmenu();
        echo "<br>\n";
        OpenTable();
        title(_ADMINDEL);
        echo "<center>"._YOUDELETE." <a href='$site_url' target='blank'><b>$site_name</b></a><br><br>";
        echo ""._SURE2DEL."<br><br></center>";
        echo "<center><table><tr>\n";
        echo "<form action='".$admin_file.".php?op=Supportersdelete_confirm' method='post'>\n";
        echo "<input type='hidden' name='site_id' value='$site_id'>\n";
        echo "<input type='hidden' name='comefrom' value='$comefrom'>\n";
        echo "<td align='center'><input type='submit' value=' "._YES." '><br>\n";
        echo ""._GOBACK."</td>\n";
        echo "</form>\n";
        echo "</tr></table></center>\n";
        CloseTable();
        @include("footer.php");
    break;

    case "Supportersdelete_confirm":
        $db->sql_query("DELETE FROM ".$prefix."_nsnsp_sites WHERE site_id='$site_id'");
        $db->sql_query("OPTIMIZE TABLE ".$prefix."_nsnsp_sites");
        Header("Location: $comefrom");
    break;

    case "Supportersedit":
        $pagetitle = _ADMINMAIN." - "._ADMINEDT;
        $comefrom = $_SERVER['HTTP_REFERER'];
        $result = $db->sql_query("select * from ".$prefix."_nsnsp_sites where site_id='$site_id'");
        $site_row = $db->sql_fetchrow($result);
        @include("header.php");
        spmenu();
        echo "<br>\n";
        OpenTable();
        title(_ADMINEDT);
        echo "<center><table border='0'>";
        echo "<form action='".$admin_file.".php?op=Supportersedit_save' method='post' enctype='multipart/form-data'>";
        echo "<input type='hidden' name='site_id' value='".$site_row['site_id']."'>";
        echo "<input type='hidden' name='old_image' value='".$site_row['site_image']."'>";
        echo "<input type='hidden' name='user_id' value='".$site_row['user_id']."'>";
        echo "<tr><td><b>"._SITEID.":</b></td><td><b>".$site_row['site_id']."</b></tr></td>";
        echo "<tr><td><b>"._SITENAME.":</b></td><td><input type='text' name='site_name' size='30' value='".$site_row['site_name']."'></tr></td>";
        echo "<tr><td><b>"._SITEURL.":</b></td><td><input type='text' name='site_url' size='60' value='".$site_row['site_url']."'></tr></td>";
        echo "<tr><td valign='top'><b>"._SITEIMAGE.":</b></td><td><input type='file' name='new_image' size='30'><br>".$site_row['site_image']."</tr></td>";
        echo "<tr><td><b>"._SUPPORTERDATE.":</b></td><td><input type='text' name='site_date' size='30' value='".$site_row['site_date']."'></tr></td>";
        echo "<tr><td valign='top'><b>"._SITEDESCRIPTION.":</b></td><td><textarea rows='5' cols='50' name='site_description'>".$site_row['site_description']."</textarea></tr></td>";
        echo "<tr><td><b>"._USERNAME.":</b></td><td><input type='text' name='user_name' size='30' value='".$site_row['user_name']."'></tr></td>";
        echo "<tr><td><b>"._USEREMAIL.":</b></td><td><input type='text' name='user_email' size='30' value='".$site_row['user_email']."'></tr></td>";
        echo "<tr><td><b>"._USERIP."</b></td><td>".$site_row['user_ip']."</tr></td>";
        echo "<input type='hidden' name='comefrom' value='$comefrom'>\n";
        echo "<tr><td align='center' colspan='2'><input type='submit' value='"._EDIT."'></td></tr>";
        echo "</form></table></center>";
        CloseTable();
        @include("footer.php");
    break;
    
    case "Supportersedit_save":
        $oid = str_pad($site_id, 6, "0", STR_PAD_LEFT);
        $newimage_name = $_FILES['new_image']['name'];
        $newimage_temp = $_FILES['new_image']['tmp_name'];
        if ($newimage_name != "") {
            $ext = substr($newimage_name, strrpos($newimage_name,'.'), 5);
            if (move_uploaded_file($newimage_temp, "modules/$modname/images/supporters/$oid$ext")) {
                chmod ("modules/$modname/images/supporters/$oid$ext", 0777);
                $imgurl = "modules/$modname/images/supporters/$oid$ext";
            } else {
                @include("header.php");
                OpenTable();
                echo "<center><b>"._NOUPLOAD."</b></center><br>\n";
                echo "<center>"._GOBACK."</center>";
				echo "modules/$modname/images/supporters/$oid$ext";
                CloseTable();
                @include("footer.php");
                die();
            }
        } else {
            $imgurl = $old_image;
        }
        $result = $db->sql_query("UPDATE ".$prefix."_nsnsp_sites SET site_name='$site_name', site_url='$site_url', site_image='$imgurl', site_date='$site_date', site_description='$site_description', user_name='$user_name', user_email='$user_email' where site_id='$site_id'");
        Header("Location: $comefrom");
    break;

    case "Supportersactivate":
        $comefrom = $_SERVER['HTTP_REFERER'];
        $db->sql_query("UPDATE ".$prefix."_nsnsp_sites SET site_status='1' where site_id='$site_id'");
        $db->sql_query("OPTIMIZE TABLE ".$prefix."_nsnsp_sites");
        Header("Location: $comefrom");
    break;

    case "Supportersdeactivate":
        $comefrom = $_SERVER['HTTP_REFERER'];
        $db->sql_query("UPDATE ".$prefix."_nsnsp_sites SET site_status='-1' where site_id='$site_id'");
        $db->sql_query("OPTIMIZE TABLE ".$prefix."_nsnsp_sites");
        Header("Location: $comefrom");
    break;

    case "Supportersadd_save":
        if (($site_name=="")OR($site_url=="")OR($site_description=="")) {
            @include("header.php");
            OpenTable();
            echo "<center><b>"._MISSINGDATA."</b></center><br>\n";
            echo "<center>"._GOBACK."</center>\n";
            CloseTable();
            @include("footer.php");
            die();
        }
        if ($supporter_config['image_type']==0) {
            $imgurl = $site_image;
        } else {
            list($newest_oid) = $db->sql_fetchrow($db->sql_query("SELECT max(site_id) AS newest_oid FROM ".$prefix."_nsnsp_sites"));
            if ($newest_oid == "-1") { $new_oid = 1; } else { $new_oid = $newest_oid+1; }
            $oid = str_pad($new_oid, 6, "0", STR_PAD_LEFT);
            $imageurl_name = $_FILES['site_image']['name'];
            $imageurl_temp = $_FILES['site_image']['tmp_name'];
            $ext = substr($imageurl_name, strrpos($imageurl_name,'.'), 5);
            if (move_uploaded_file($imageurl_temp, "modules/$modname/images/supporters/$oid$ext")) {
                chmod ("modules/$modname/images/supporters/$oid$ext", 0777);
                $imgurl = "modules/$modname/images/supporters/$oid$ext";
            } else {
                @include("header.php");
                title(_CONFBANN);
                OpenTable();
                echo "<center><b>"._NOUPLOAD."</b></center><br>\n";
                echo "<center>"._GOBACK."</center>";
                CloseTable();
                @include("footer.php");
                die();
            }
        }
        list($user_id) = $db->sql_fetchrow($db->sql_query("SELECT user_id FROM ".$user_prefix."_users WHERE username='$user_name'"));
        $result = $db->sql_query("INSERT INTO ".$prefix."_nsnsp_sites values (NULL, '$site_name', '$site_url', '$imgurl', '1', '0', now(), '$site_description', '$user_id', '$user_name', '$user_email', '$user_ip')");
        if (!$result) {
            @include("header.php");
            OpenTable();
            echo "<center><b>"._DBERROR1."</b></center><br>\n";
            echo "<center>"._GOBACK."</center>\n";
            CloseTable();
            @include("footer.php");
            die();
        }
        Header("Location: ".$admin_file.".php?op=Supporters");
    break;

    case "SupportersConfig":
        $pagetitle = ": "._CONFIGMAIN;
        @include("header.php");
        spmenu();
        echo "<br>\n";
        OpenTable();
        title(_CONFIGMAIN);
        echo "<center><table border='0'>";
        echo "<form action='".$admin_file.".php?op=SupportersConfigSave' method='post'>\n";
        echo "<tr><td align='right'>"._REQUIREUSER."</td><td>";
        $chk1 = $chk2 = $chk3 = $chk4 ="";
        if ($supporter_config['require_user']==0) { $chk1 = " checked"; } else { $chk2 = " checked"; }
        echo "<input type='radio' name='xrequire_user' value='0'$chk1>"._NO." &nbsp;";
        echo "<input type='radio' name='xrequire_user' value='1'$chk2>"._YES."</td></tr>";
        echo "<tr><td align='right'>"._IMAGETYPE."</td><td>";
        if ($supporter_config['image_type']==0) {  $chk3 = " checked"; } else { $chk4 = " checked"; }
        echo "<input type='radio' name='ximage_type' value='0'$chk3>"._LINKED." &nbsp;";
        echo "<input type='radio' name='ximage_type' value='1'$chk4>"._UPLOAD."</td></tr>";
        echo "<tr><td align='center' colspan='2'>";
        echo "<input type='submit' value='"._SAVECHANGES."'></td></tr>";
        echo "</form></table></center>";
        CloseTable();
        @include("footer.php");
    break;

    case "SupportersConfigSave":
        $db->sql_query("UPDATE ".$prefix."_nsnsp_config SET require_user='$xrequire_user', image_type='$ximage_type'");
        Header("Location: ".$admin_file.".php?op=SupportersConfig");
    break;

}
} else {
echo "Access Denined";
}

?>
