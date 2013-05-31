<?php

/********************************************************/
/* NSN Center Blocks(TM) Universal                      */
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

function cb_blocks($rid) {
    global $prefix, $db, $admin, $user;
    $sql = "SELECT * FROM ".$prefix."_nsncb_blocks WHERE rid='$rid'";
    $result = $db->sql_query($sql);
    while($row = $db->sql_fetchrow($result)) {
        $title = $row['title'];
        $filename = $row['filename'];
        $content = $row['content'];
        if ($filename == "" AND $content > "") {
            themecenterbox($title, $content);
        } elseif ($filename > "" AND $content == "") {
            $file = @file("blocks/$filename");
            if (!$file) {
                $content = _BLOCKPROBLEM;
            } else {
                include("blocks/$filename");
            }
            if ($content == "") { $content = _BLOCKPROBLEM2; }
            themecenterbox($title, $content);
        } elseif ($filename == "" AND $content == "") {
            $content = _BLOCKPROBLEM2;
            themecenterbox($title, $content);
        }
    }
}

?>