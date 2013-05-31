<?php

/********************************************************/
/* NSN Supporters(TM) Universal                         */
/* By: NukeScripts Network (webmaster@nukescripts.net)  */
/* http://www.nukescripts.net                           */
/* Copyright © 2000-2005 by NukeScripts Network         */
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

@require_once("mainfile.php");
get_lang($module_name);
$supportersub = $db->sql_fetchrow($db->sql_query("SELECT * from ".$prefix."_nsnsp_config"));

if ($supportersub['require_user'] == 0 || is_user($user)) {
switch ($op) {

    default:
    $pagetitle = _ADDSUPPORTER;
    $comefrom = $_SERVER['HTTP_REFERER'];
    $sip = $_SERVER['REMOTE_ADDR'];
    if(!is_array($user)) {
        $member = base64_decode($user);
        $member = explode(":", $member);
        $memname = "$member[1]";
    } else {
        $memname = "$user[1]";
    }
    list($suid, $sname, $semail, $surl) = $db->sql_fetchrow($db->sql_query("select user_id, username, user_email, user_website from ".$user_prefix."_users where username='$memname'"));
    @include("header.php");
    title(_ADDSUPPORTER);
    OpenTable();
    echo "<center><b>"._ADDSUPPORTER."</b><br>"._ALLREQ."<br>\n";
    if (is_admin($admin)) {
        echo "<center>[ <a href='modules.php?name=$module_name&amp;file=admin'>"._GOTOADMIN."</a> ]\n";
    }
    echo "<table border='0'>\n";
    if ($supportersub['image_type']==0) { $enctype = ""; } else { $enctype = " enctype='multipart/form-data'"; }
    echo "<form action='modules.php?name=$module_name' method='post'$enctype>\n";
    echo "<input type='hidden' name='file' value='submit'>\n";
    echo "<input type='hidden' name='op' value='add_save'>\n";
    echo "<input type='hidden' name='user_id' value='$suid'>\n";
    echo "<tr><td><b>"._SITENAME.":</b></td><td><input type='text' name='site_name' size='50'></td></tr>\n";
    echo "<tr><td><b>"._SITEURL.":</b></td><td><input type='text' name='site_url' size='50' value='$surl'></td></tr>\n";
    if ($supportersub['image_type']==0) { $type = "type='input'"; } else { $type = "type='file'"; }
    echo "<tr><td valign='top'><b>"._SITEIMAGE.":</b></td><td><input $type name='site_image' size='50'>";
    echo "<br>"._MUSTBE;
    if ($supportersub['image_type']==0) { echo "<br>"._IMAGETYPE0; } else { echo "<br>"._IMAGETYPE1; }
    echo "</td></tr>\n";
    echo "<tr><td valign='top'><b>"._SITEDESCRIPTION.":</b></td><td><textarea rows='5' cols='50' name='site_description'></textarea></td></tr>\n";
    echo "<tr><td><b>"._SUPPORTERNAME.":</b></td><td><input type='test' name='user_name' value='$sname' size='40'></td></tr>\n";
    echo "<tr><td><b>"._SUPPORTEREMAIL.":</b></td><td><input type='text' name='user_email' value='$semail' size='40'></td></tr>\n";
    echo "<tr><td><b>"._SUPPORTERIP.":</b></td><td>$sip</td></tr>\n";
    echo "<input type='hidden' name='user_ip' value='$sip'>\n";
    echo "<input type='hidden' name='comefrom' value='$comefrom'>\n";
    echo "<tr><td align='center' colspan='2'><input type='submit' value='"._SADDSITE."'></td></tr>\n";
    echo "</form></table></center>\n";
    CloseTable();
    @include("footer.php");
    break;

    case "add_save":
        if (($site_name=="")OR($site_url=="")OR($site_description=="")) {
            @include("header.php");
            OpenTable();
            echo "<center><b>"._MISSINGDATA."</b></center><br>\n";
            echo "<center>"._GOBACK."</center>\n";
            CloseTable();
            @include("footer.php");
            die();
        }
        if ($supportersub['image_type']==0) {
            $imgurl = $site_image;
        } else {
            list($newest_oid) = $db->sql_fetchrow($db->sql_query("SELECT max(site_id) AS newest_oid FROM ".$prefix."_nsnsp_sites"));
            if ($newest_oid == "-1") { $new_oid = 1; } else { $new_oid = $newest_oid+1; }
            $oid = str_pad($new_oid, 6, "0", STR_PAD_LEFT);
            $imageurl_name = $_FILES['site_image']['name'];
            $imageurl_temp = $_FILES['site_image']['tmp_name'];
            $ext = substr($imageurl_name, strrpos($imageurl_name,'.'), 5);
            if (move_uploaded_file($imageurl_temp, "modules/$module_name/images/supporters/$oid$ext")) {
                chmod ("modules/$module_name/images/supporters/$oid$ext", 0777);
                $imgurl = "modules/$module_name/images/supporters/$oid$ext";
            } else {
                @include("header.php");
                title(_CONFBANN);
                OpenTable();
                echo "<center><b>"._NOUPLOAD."</b></center><br>\n";
                echo "<center>"._GOBACK."</center>\n";
                CloseTable();
                @include("footer.php");
                die();
            }
        }
        $result = $db->sql_query("INSERT INTO ".$prefix."_nsnsp_sites values (NULL, '$site_name', '$site_url', '$imgurl', '0', '0', now(), '$site_description', '$user_id', '$user_name', '$user_email', '$user_ip')");
        if (!$result) {
            @include("header.php");
            OpenTable();
            echo "<center><b>"._DBERROR1."</b></center><br>\n";
            echo "<center>"._GOBACK."</center>\n";
            CloseTable();
            @include("footer.php");
            die();
        } else {
            $msg = "$sitename "._SUPPORTERDATE."\n\n";
            $msg .= _SITENAME.": $site_name\n";
            $msg .= _SITEURL.": $site_url\n";
            $msg .= _SITEIMAGE.": $imgurl\n";
            $msg .= _SITEDESCRIPTION.": $site_description\n";
            $msg .= _SUPPORTERID2.": $user_id\n";
            $msg .= _SUPPORTERNAME2.": $user_name\n";
            $msg .= _SUPPORTEREMAIL2.": $user_email\n";
            $msg .= _SUPPORTERIP2.": $user_ip\n";
            $to = $adminmail;
            $subject = "$sitename - "._SUPPORTERDATE;
            $mailheaders = "From: $adminmail\r\n";
            $mailheaders .= "Reply-To: $adminmail\r\n";
            $mailheaders .= "Return-Path: $adminmail\r\n";
            mail($to, $subject, $msg, $mailheaders);
        }
        Header("Location: $comefrom");
    break;

}
} else {
    Header("Location: index.php");
}

?>
