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

if ( !defined('CORE_FILE') ) {
	die("Illegal Block File Access");
}

get_lang("Supporters");
global $prefix, $db, $user, $admin;
$supporterdn = $db->sql_fetchrow($db->sql_query("SELECT * from ".$prefix."_nsnsp_config"));
$content = "<center>Supported by<br><br>";
$content .= "<MARQUEE behavior='scroll' direction='down' height='150' scrollamount='3' scrolldelay='90' width='100' onmouseover='this.stop()' onmouseout='this.start()'><center>\n";
$result = $db->sql_query("SELECT site_id, site_name, site_image FROM $prefix"._nsnsp_sites." WHERE site_status>'0' ORDER BY site_name DESC");
while (list($site_id, $site_name, $site_image) = $db->sql_fetchrow($result)) {
    $content .= "<a href='modules.php?name=Supporters&op=go&site_id=$site_id'><img src='$site_image' height='31' width='88' title='$site_name' border='0'></a><br><br>\n";
}
$content .="</center></MARQUEE></center>\n";
if ($supporterdn['require_user'] == 0 || is_user($user)) { $content .= "[ <a href='modules.php?name=Supporters&amp;file=submit'>"._BESUPPORTER."</a> ]<br>\n"; }
if (is_admin($admin)) { $content .= "[ <a href='modules.php?name=Supporters&amp;file=admin'>"._GOTOADMIN."</a> ]<br>\n"; }
$content .= "[ <a href='modules.php?name=Supporters'>"._SUPPORTERS."</a> ]</center>\n";

?>
