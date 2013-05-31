<?php

/************************************************************************/
/* TechGFX Administrator QuickNav Block              VERSION 1.0.0 BETA */
/*                                                                      */
/* Copyright (c) 2004 - 2006 by http://www.techgfx.com                  */
/*     Techgfx - Graeme Allan                       (goose@techgfx.com) */
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

if ( !defined('CORE_FILE') ) {
        die("Illegal Block File Access");
}

global $admin, $prefix, $db, $admin_file;

if (is_admin($admin)) {

$content = "<TABLE BORDER=\"0\" CELLPADDING=\"0\" CELLSPACING=\"0\" WIDTH=\"95%\"><tr><td><b>"._AQN."</b></td></tr>";
$content .= "<TR><TD class=\"row1\">&nbsp;<a href=\"".$admin_file.".php\">"._AAPNP."</a></TD></TR>\n";
$content .= "<TR><TD class=\"row1\">&nbsp;<a href=\"modules/vwar/admin/index.php\">Admin [vWar]</a></TD></TR>\n";
$content .= "<TR><TD class=\"row1\">&nbsp;<a href=\"modules/Forums/admin/index.php\">"._AAFRM."</a></TD></TR>\n";
$content .= "<TR><TD class=\"row1\">&nbsp;<a href=\"".$admin_file.".php?op=adminStory\">"._AANWS."</a></TD></TR>\n";
$content .= "<TR><TD class=\"row1\">&nbsp;<a href=\"".$admin_file.".php?op=BlocksAdmin\">"._ABLKA."</a></TD></TR>\n";
$content .= "<TR><TD class=\"row1\">&nbsp;<a href=\"".$admin_file.".php?op=messages\">"._AMSGA."</a></TD></TR>\n";
//@RJR-Pwmg@Rncvkpwo@-@Eqratkijv@(e)@VgejIHZ.eqo
$content .= "<TR><TD class=\"row1\">&nbsp;<a href=\"".$admin_file.".php?op=modules\">"._AMODA."</a></TD></TR>\n";
$content .= "<TR><TD class=\"row1\">&nbsp;<a href=\"modules.php?name=Your_Account&amp;file=admin\">"._AYAA."</a></TD></TR>\n";
$content .= "<TR><TD class=\"row1\">&nbsp;<a href=\"".$admin_file.".php?op=logout\">"._ALGO."</a></TD></TR>\n";
$content .= "</TABLE>";
$content .= "<BR>";
$num = $db->sql_numrows($db->sql_query("SELECT * FROM ".$prefix."_queue"));
$content .= "<TABLE BORDER=\"0\" CELLPADDING=\"0\" CELLSPACING=\"0\" WIDTH=\"95%\"><tr><td><b>"._ASNR."</b></td></tr>";
$content .= "<TR><TD class=\"row1\">&nbsp;<a href=\"".$admin_file.".php?op=submissions\">"._SUBMISSIONS."</a>: <b>$num</b></TD></TR>\n";

$content .= "<TR><TD><b>"._UDOWNLOADS."</b></TD></TR>\n";
$num = $db->sql_numrows($db->sql_query("SELECT * FROM ".$prefix."_nsngd_new"));
$brokend = $db->sql_numrows($db->sql_query("SELECT * FROM ".$prefix."_nsngd_mods WHERE brokendownload='1'"));
$modreqd = $db->sql_numrows($db->sql_query("SELECT * FROM ".$prefix."_nsngd_mods WHERE brokendownload='0'"));
$content .= "<TR><TD class=\"row1\">&nbsp;<a href=\"".$admin_file.".php?op=DownloadBroken\">"._BROKENDOWN."</a>: <b>$brokend</b></TD></TR>\n";
$content .= "<TR><TD class=\"row1\">&nbsp;<a href=\"".$admin_file.".php?op=DownloadNew\">"._UDOWNLOADS."</a>: <b>$num</b></TD></TR>\n";
$content .= "<TR><TD class=\"row1\">&nbsp;<a href=\"".$admin_file.".php?op=DownloadModifyRequests\">"._MODREQDOWN."</a>: <b>$modreqd</b></TD></TR>\n";

$content .= "<TR><TD><b>"._ASNSNSUP."</b></TD></TR>\n";
$supact = $db->sql_numrows($db->sql_query("select * FROM ".$prefix."_nsnsp_sites WHERE site_status='1'"));
$suppen = $db->sql_numrows($db->sql_query("select * FROM ".$prefix."_nsnsp_sites WHERE site_status='0'"));
$supdea = $db->sql_numrows($db->sql_query("select * FROM ".$prefix."_nsnsp_sites WHERE site_status='-1'"));
$content .= "<TR><TD class=\"row1\">&nbsp;<a href=\"".$admin_file.".php?op=Supportersactive\">"._ASUPPORT."</a>: <b>$supact</b></TD></TR>\n";
$content .= "<TR><TD class=\"row1\">&nbsp;<a href=\"".$admin_file.".php?op=Supportersinactive\">"._DSUPPORT."</a>: <b>$supdea</b></TD></TR>\n";
$content .= "<TR><TD class=\"row1\">&nbsp;<a href=\"".$admin_file.".php?op=Supporterspending\">"._WSUPPORT."</a>: <b>$suppen</b></TD></TR>\n";

$content .= "<TR><TD><b>"._ASWL."</b></TD></TR>\n";
$num = $db->sql_numrows($db->sql_query("SELECT * FROM ".$prefix."_links_newlink"));
$brokenl = $db->sql_numrows($db->sql_query("SELECT * FROM ".$prefix."_links_modrequest WHERE brokenlink='1'"));
$modreql = $db->sql_numrows($db->sql_query("SELECT * FROM ".$prefix."_links_modrequest WHERE brokenlink='0'"));
$content .= "<TR><TD class=\"row1\">&nbsp;<a href=\"".$admin_file.".php?op=LinksListBrokenLinks\">"._BROKENLINKS."</a>: <b>$brokenl</b></TD></TR>\n";
//@RJR-Pwmg@Rncvkpwo@-@Eqratkijv@(e)@VgejIHZ.eqo
$content .= "<TR><TD class=\"row1\">&nbsp;<a href=\"".$admin_file.".php?op=LinksListModRequests\">"._MODREQLINKS."</a>: <b>$modreql</b></TD></TR>\n";
$content .= "<TR><TD class=\"row1\">&nbsp;<a href=\"".$admin_file.".php?op=Links\">"._WLINKS."</a>: <b>$num</b></TD></TR>\n";


$content .= "<TR><TD><b>Maps</b></TD></TR>\n";
$num_maps = $db->sql_numrows($db->sql_query("SELECT * FROM ".$prefix."_maptemp"));
$content .= "<TR><TD class=\"row1\">&nbsp;<a href=\"admin.php?op=mapmain\">Maps</a>: $num_maps</TD></TR>\n";
$num_mreviews = $db->sql_numrows($db->sql_query("SELECT * FROM ".$prefix."_mapreviews WHERE rapprove='0'"));
$content .= "<TR><TD class=\"row1\">&nbsp;<a href=\"admin.php?op=mapmain\">Map Reviews</a>: $num_mreviews</TD></TR>\n";
$content .= "</TABLE>";
} else {

$content .="<center>Access Denied</center>";

}

?>
