<?php

/********************************************************/
/* NSN GR Downloads                                     */
/* By: NukeScripts Network (webmaster@nukescripts.net)  */
/* http://www.nukescripts.net                           */
/* Copyright © 2000-2005 by NukeScripts Network         */
/********************************************************/
/* Based on Journey Links Hack                          */
/* Copyright (c) 2000 by James Knickelbein              */
/* Journey Milwaukee (http://www.journeymilwaukee.com)  */
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

if ( !defined('ADMIN_FILE') )
{
	die("Illegal File Access");
}

global $admin_file;
if (!stristr($_SERVER['SCRIPT_NAME'], "".$admin_file.".php")) {
    die ("Access Denied");
}

$module_name = "Downloads";
get_lang($module_name);

switch ($op) {

    case "DLMain":
    case "DLConfig":
    case "DLConfigSave":
    case "Categories":
    case "CategoryActivate":
    case "CategoryAdd":
    case "CategoryAddSave":
    case "CategoryDeactivate":
    case "CategoryDelete":
    case "CategoryDeleteSave":
    case "CategoryModify":
    case "CategoryModifySave":
    case "CategoryTransfer":
    case "DownloadActivate":
    case "DownloadAdd":
    case "DownloadAddSave":
    case "DownloadBroken":
    case "DownloadBrokenDelete":
    case "DownloadBrokenIgnore":
    case "DownloadCheck":
    case "DownloadDeactivate":
    case "DownloadDelete":
    case "DownloadModify":
    case "DownloadModifyRequests":
    case "DownloadModifyRequestsAccept":
    case "DownloadModifyRequestsIgnore":
    case "DownloadModifySave":
    case "DownloadNew":
    case "DownloadNewDelete":
    case "Downloads":
    case "DownloadTransfer":
    case "DownloadValidate":
    case "ExtensionAdd":
    case "ExtensionAddSave":
    case "ExtensionDelete":
    case "ExtensionModify":
    case "ExtensionModifySave":
    case "Extensions":
    case "FilesizeCheck":
    case "FilesizeValidate":
    include("modules/$module_name/admin/index.php");
    break;

}

?>
