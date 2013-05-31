<?php

/********************************************************/
/* NSN Groups                                           */
/* By: NukeScripts Network (webmaster@nukescripts.net)  */
/* http://www.nukescripts.net                           */
/* Copyright © 2000-2005 by NukeScripts Network         */
/********************************************************/

global $admin_file, $adveditor;
$adveditor = 0;
if(!isset($admin_file)) { $admin_file = "admin"; }
if(!defined('ADMIN_FILE')) { die("Illegal Access Detected!!!"); }
if(defined("NSNGROUPS_IS_LOADED")) $grconfig = grget_configs();
else $op = 'NSNGroupsLoadError';
$textrowcol = "rows='10' cols='50'";
if($Version_Num > "7.6") { $textrowcol = "rows='15' cols='75'"; }
$result = $db->sql_query("SELECT `aid`, `email`, `radminsuper` FROM `".$prefix."_authors` WHERE `aid`='$aid'");
list($aname, $amail, $radminsuper) = $db->sql_fetchrow($result);
if($radminsuper==1) {
  switch($op) {
    case "NSNGroups":include("admin/modules/nsngroups/NSNGroups.php");break;
    case "NSNGroupsAdd":include("admin/modules/nsngroups/NSNGroupsAdd.php");break;
    case "NSNGroupsAddSave":include("admin/modules/nsngroups/NSNGroupsAddSave.php");break;
    case "NSNGroupsConfig":include("admin/modules/nsngroups/NSNGroupsConfig.php");break;
    case "NSNGroupsConfigSave":include("admin/modules/nsngroups/NSNGroupsConfigSave.php");break;
    case "NSNGroupsDelete":include("admin/modules/nsngroups/NSNGroupsDelete.php");break;
    case "NSNGroupsDeleteConf":include("admin/modules/nsngroups/NSNGroupsDeleteConf.php");break;
    case "NSNGroupsEdit":include("admin/modules/nsngroups/NSNGroupsEdit.php");break;
    case "NSNGroupsEditSave":include("admin/modules/nsngroups/NSNGroupsEditSave.php");break;
    case "NSNGroupsEmpty":include("admin/modules/nsngroups/NSNGroupsEmpty.php");break;
    case "NSNGroupsEmptyConf":include("admin/modules/nsngroups/NSNGroupsEmptyConf.php");break;
    case "NSNGroupsLoadError":include("admin/modules/nsngroups/NSNGroupsLoadError.php");break;
    case "NSNGroupsUsersAdd":include("admin/modules/nsngroups/NSNGroupsUsersAdd.php");break;
    case "NSNGroupsUsersAddSave":include("admin/modules/nsngroups/NSNGroupsUsersAddSave.php");break;
    case "NSNGroupsUsersDelete":include("admin/modules/nsngroups/NSNGroupsUsersDelete.php");break;
    case "NSNGroupsUsersDeleteConf":include("admin/modules/nsngroups/NSNGroupsUsersDeleteConf.php");break;
    case "NSNGroupsUsersDeleteSave":include("admin/modules/nsngroups/NSNGroupsUsersDeleteSave.php");break;
    case "NSNGroupsUsersEmail":include("admin/modules/nsngroups/NSNGroupsUsersEmail.php");break;
    case "NSNGroupsUsersEmailSend":include("admin/modules/nsngroups/NSNGroupsUsersEmailSend.php");break;
    case "NSNGroupsUsersExpire":include("admin/modules/nsngroups/NSNGroupsUsersExpire.php");break;
    case "NSNGroupsUsersExpireDone":include("admin/modules/nsngroups/NSNGroupsUsersExpireDone.php");break;
    case "NSNGroupsUsersExpireSave":include("admin/modules/nsngroups/NSNGroupsUsersExpireSave.php");break;
    case "NSNGroupsUsersMove":include("admin/modules/nsngroups/NSNGroupsUsersMove.php");break;
    case "NSNGroupsUsersMoveSave":include("admin/modules/nsngroups/NSNGroupsUsersMoveSave.php");break;
    case "NSNGroupsUsersUpdate":include("admin/modules/nsngroups/NSNGroupsUsersUpdate.php");break;
    case "NSNGroupsUsersUpdateSave":include("admin/modules/nsngroups/NSNGroupsUsersUpdateSave.php");break;
    case "NSNGroupsSingleUserAdd":include("admin/modules/nsngroups/NSNGroupsSingleUserAdd.php");break;
    case "NSNGroupsSingleUserAddSave":include("admin/modules/nsngroups/NSNGroupsSingleUserAddSave.php");break;
    case "NSNGroupsUsersView":include("admin/modules/nsngroups/NSNGroupsUsersView.php");break;
    case "NSNGroupsView":include("admin/modules/nsngroups/NSNGroupsView.php");break;
  }
} else {
    echo "Access Denied";
}

?>