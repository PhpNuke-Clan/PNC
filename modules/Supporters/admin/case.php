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
get_lang($modname);

switch ($op) {

    case "Supporters":
    case "Supportersadd":
    case "Supporterspending":
    case "Supportersinactive":
    case "Supportersactive":
    case "Supportersappv":
    case "Supportersappv_save":
    case "Supportersdelete":
    case "Supportersdelete_confirm":
    case "Supportersedit":
    case "Supportersedit_save":
    case "Supportersactivate":
    case "Supportersdeactivate":
    case "Supportersadd_save":
    case "SupportersConfig":
    case "SupportersConfigSave":
    @include("modules/$modname/admin/index.php");
    break;

}

?>