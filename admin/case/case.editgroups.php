<?php
/********************************************************/
/* NSN Groups                                           */
/* By: NukeScripts Network (webmaster@nukescripts.net)  */
/* http://www.nukescripts.net                           */
/* Copyright © 2000-2005 by NukeScripts Network         */
/********************************************************/
global $admin_file;
if (!isset($admin_file)) {
	$admin_file = 'admin';
}
if (!defined('ADMIN_FILE')) {
	die('Illegal Access Detected!!!');
}
switch ($op) {
	case 'NSNGroups':
	case 'NSNGroupsAdd':
	case 'NSNGroupsAddSave':
	case 'NSNGroupsSingleUserAdd':
	case 'NSNGroupsSingleUserAddSave':
	case 'NSNGroupsConfig':
	case 'NSNGroupsConfigSave':
	case 'NSNGroupsDelete':
	case 'NSNGroupsDeleteConf':
	case 'NSNGroupsEdit':
	case 'NSNGroupsEditSave':
	case 'NSNGroupsEmpty':
	case 'NSNGroupsEmptyConf':
	case 'NSNGroupsLoadError':
	case 'NSNGroupsUsersAdd':
	case 'NSNGroupsUsersAddSave':
	case 'NSNGroupsUsersDelete':
	case 'NSNGroupsUsersDeleteConf':
	case 'NSNGroupsUsersEmail':
	case 'NSNGroupsUsersEmailSend':
	case 'NSNGroupsUsersExpire':
	case 'NSNGroupsUsersExpireDone':
	case 'NSNGroupsUsersExpireSave':
	case 'NSNGroupsUsersMove':
	case 'NSNGroupsUsersMoveSave':
	case 'NSNGroupsUsersUpdate':
	case 'NSNGroupsUsersUpdateSave':
	case 'NSNGroupsUsersView':
	case 'NSNGroupsView':
		include_once('admin/modules/editgroups.php');
		break;
}
?>