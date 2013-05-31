<?php

/********************************************************/
/* NSN Center Blocks(TM) Universal                      */
/* By: NukeScripts Network (webmaster@nukescripts.net)  */
/* http://www.nukescripts.net                           */
/* Copyright © 2000-2005 by NukeScripts Network         */
/********************************************************/
/* Original by: Richard Benfield                        */
/* http://www.benfield.ws                               */
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

if (stristr($_SERVER['SCRIPT_NAME'], "cblocks2.php")) {
    Header("Location: ../index.php");
    die();
}

global $bgcolor1, $bgcolor2;
$cbinfo = $db->sql_fetchrow($db->sql_query("select * from ".$prefix."_nsncb_config where cgid='2'"));
if ($cbinfo['enabled'] == '1') {
    if ($cbinfo['height'] <> "") { $cheight = "height='".$cbinfo['height']."' "; } else { $cheight = ""; }
    echo "<table width='100%' ".$cheight."border='0' cellspacing='1' cellpadding='0'><tr><td valign='top'>\n";
    echo "<table width='100%' ".$cheight."border='0' cellspacing='1' cellpadding='4'><tr>";
    $result3 = $db->sql_query("SELECT * FROM ".$prefix."_nsncb_blocks WHERE cgid='2' ORDER BY cbid");
    while($cbidinfo = $db->sql_fetchrow($result3)) {
        if ($cbidinfo['cbid'] <= $cbinfo['count']) {
            if ($cbidinfo['wtype'] == '0') {
                echo "<td width='".$cbidinfo['width']."' valign='top' align='center'>\n";
            } else {
                echo "<td width='".$cbidinfo['width']."%' valign='top' align='center'>\n";
            }
            cb_blocks($cbidinfo['rid']);
            echo "</td>\n";
        }
    }
    echo "</tr></table>\n";
    echo "</td></tr></table>\n";
    echo "<br>";
}

?>
