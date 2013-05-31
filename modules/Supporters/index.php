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

if ( !defined('MODULE_FILE') )
{
   die("You can't access this file directly...");
}

$module_name = basename(dirname(__FILE__));

require_once("mainfile.php");
get_lang($module_name);

switch ($op) {

    default:
    $pagetitle = _SUPPORTERS;
    $supporteridx = $db->sql_fetchrow($db->sql_query("SELECT * from ".$prefix."_nsnsp_config"));
    include("header.php");
    global $admin_file;
    title(_SUPPORTERS);
    OpenTable();
    echo "<center>";
    if (is_admin($admin)) { echo "[ <a href='".$admin_file.".php?op=Supporters'>"._GOTOADMIN."</a> ]\n"; }
    if ($supporteridx['require_user'] == 0 || is_user($user)) { echo "[ <a href='modules.php?name=$module_name&amp;file=submit'>"._BESUPPORTER."</a> ]\n"; }
    echo "</center>";
    echo "<br>";
    $a = 0;
    $result = $db->sql_query("SELECT site_id, site_name, site_url, site_image, site_date, site_description, site_hits FROM ".$prefix."_nsnsp_sites WHERE site_status='1' ORDER BY site_name");
    $numrows = $db->sql_numrows($result);
    if ($numrows > 0) {
        echo "<table border='0' cellpadding='2' cellspacing='5' width='100%'>";
        while (list($site_id, $site_name, $site_url, $site_image, $site_date, $site_description, $site_hits) = $db->sql_fetchrow($result)) {
            if ($a == 0) { echo "<tr>"; }
            echo "<td width='50%' valign='top'>";
            OpenTable();
            echo "<table border='0' width='100%'>";
            echo "<tr><td width='25%' align='center' valign='top' rowspan='3'>";
            echo "<a href='modules.php?name=$module_name&op=go&site_id=$site_id' target='_blank'><img src='$site_image' border='0' alt='$site_name' title='$site_name' height='31' width='88'></a>";
            if (is_admin($admin)) {
                echo " <a href='".$admin_file.".php?op=Supportersdeactivate&amp;site_id=$site_id'><img src='modules/$module_name/images/deactivate.gif' border='0' alt='"._DEACTIVATE."' title='"._DEACTIVATE."'></a>";
                echo " <a href='".$admin_file.".php?op=Supportersedit&amp;site_id=$site_id'><img src='modules/$module_name/images/edit.gif' border='0' alt='"._EDIT."' title='"._EDIT."'></a>";
                echo " <a href='".$admin_file.".php?op=Supportersdelete&amp;site_id=$site_id'><img src='modules/$module_name/images/delete.gif' border='0' alt='"._DELETE."' title='"._DELETE."'></a>";
            }
            echo "</td>\n<td width='75%' valign='top'><b>"._SUPPORTERDATE.":</b> $site_date</td></tr>";
            echo "<tr><td valign='top'><b>"._SITEDESCRIPTION."</b>: $site_description</td></tr>";
            echo "<tr><td valign='top'><b>"._SITEHITS."</b>: $site_hits</td></tr>";
            echo "</table>";
            CloseTable();
            echo "</td>";
            $a++;
            if ($a == 2) { echo "</tr>"; $a = 0; }
        }
        if ($a ==1) { echo "<td width='50%'>&nbsp;</td></tr></table>"; } else { echo "</tr></table>"; }
    }
    CloseTable();
    include("footer.php");
    break;
    
    case "go":
    $result = $db->sql_query("select site_url, site_status from ".$prefix."_nsnsp_sites where site_id='$site_id'");
    list($url, $status) = $db->sql_fetchrow($result);
    if ($status==1) {
        $db->sql_query("UPDATE ".$prefix."_nsnsp_sites set site_hits=site_hits+1 where site_id='$site_id'");
    }
    Header("Location: $url");
    break;

}

?>