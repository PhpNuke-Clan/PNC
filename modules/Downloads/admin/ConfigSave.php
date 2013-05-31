<?php

/********************************************************/
/* NSN GR Downloads                                     */
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

gdsave_config("admperpage",$xadmperpage);
gdsave_config("blockunregmodify",$xblockunregmodify);
gdsave_config("dateformat",$xdateformat);
gdsave_config("mostpopular",$xmostpopular);
gdsave_config("mostpopulartrig",$xmostpopulartrig);
gdsave_config("perpage",$xperpage);
gdsave_config("popular",$xpopular);
gdsave_config("results",$xresults);
gdsave_config("show_download",$xshow_download);
gdsave_config("show_links_num",$xshow_links_num);
gdsave_config("usegfxcheck",$xusegfxcheck);
Header("Location: ".$admin_file.".php?op=DLConfig");

?>