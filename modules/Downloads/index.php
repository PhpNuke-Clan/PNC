<?php

/********************************************************/
/* NSN GR Downloads                                     */
/* By: NukeScripts Network (webmaster@nukescripts.net)  */
/* http://www.nukescripts.net                           */
/* Copyright � 2000-2005 by NukeScripts Network         */
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

if (!stristr($_SERVER['SCRIPT_NAME'], "modules.php")) {
    die ("You can't access this file directly...");
}

$module_name = basename(dirname(__FILE__));
require_once("mainfile.php");
get_lang($module_name);
$pagetitle = _DOWNLOADS;
include("modules/$module_name/includes/functions.php");
$result1 = $db->sql_query("SELECT * FROM ".$prefix."_nsngd_config");
$dl_config = gdget_configs();
if (!$dl_config OR $dl_config=="") {
    include("header.php");
    title(_DL_DBCONFIG);
    include("footer.php");
    die();
}
$index = 1;

if(isset($d_op)) { $op = $d_op; unset($d_op); }
if(op == "viewdownload") { $op = "getit"; }
if(op == "viewdownloaddetails") { $op = "getit"; }

switch($op) {

    default:
    case "index":include("modules/$module_name/public/index.php");break;

    case "NewDownloads":include("modules/$module_name/public/NewDownloads.php");break;
    case "NewDownloadsDate":include("modules/$module_name/public/NewDownloadsDate.php");break;
    case "MostPopular":include("modules/$module_name/public/MostPopular.php");break;
    case "brokendownload":include("modules/$module_name/public/brokendownload.php");break;
    case "brokendownloadS":include("modules/$module_name/public/brokendownloadS.php");break;
    case "modifydownloadrequest":include("modules/$module_name/public/modifydownloadrequest.php");break;
    case "modifydownloadrequestS":include("modules/$module_name/public/modifydownloadrequestS.php");break;
    case "getit":include("modules/$module_name/public/getit.php");break;
    case "go":include("modules/$module_name/public/go.php");break;
    case "search":include("modules/$module_name/public/search.php");break;
    case "gfx":include("modules/$module_name/public/gfx.php");break;

}

?>