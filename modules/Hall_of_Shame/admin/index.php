<?php

/********************************************************/
/* Hall of Shame                                     	*/
/* By: Troy Moore (Duck@mrc.clanservers.com)			*/
/* http://mrc.clanservers.com                           */
/* Copyright © 2006-2011 by JesStep Enterprises         */
/********************************************************/
/* Hall of Shame                                        */
/* For PHP-Nuke 6.5+                                    */
/* By Troy Moore - http://mrc.clanservers.com        	*/
/********************************************************/


if ( !defined('ADMIN_FILE') ) {
	die("Illegal Admin File Access");
}

$modname = "Hall_of_Shame";
@require_once("mainfile.php");
get_lang($modname);
$pagetitle = " - "._HoS_HALLOFSHAME;
$aid = substr("$aid", 0,25);
$row = $db->sql_fetchrow($db->sql_query("SELECT title, admins FROM ".$prefix."_modules WHERE title='$modname'"));
$row2 = $db->sql_fetchrow($db->sql_query("SELECT name, radminsuper FROM ".$prefix."_authors WHERE aid='$aid'"));
$admins = explode(",", $row['admins']);
$auth_user = 0;
for ($i=0; $i < sizeof($admins); $i++) { if ($row2['name'] == "$admins[$i]" AND $row['admins'] != "") { $auth_user = 1; } }
if ($row2['radminsuper'] == 1 || $auth_user == 1) {
  @include_once("includes/hos_func.php");
  $hos_config = hosget_configs();
  $index = intval($hos_config['rightblocks']);
  switch($op) {
    case "HoSAdmin":@include("modules/$modname/admin/HoSAdmin.php");break;
    case "HoSReason_Add":@include("modules/$modname/admin/HoSReason_Add.php");break;
    case "HoSReason_Add_Save":@include("modules/$modname/admin/HoSReason_Add_Save.php");break;
    case "HoSReason_Delete":@include("modules/$modname/admin/HoSReason_Delete.php");break;
    case "HoSReason_Delete_Save":@include("modules/$modname/admin/HoSReason_Delete_Save.php");break;
    case "HoSReason_Edit":@include("modules/$modname/admin/HoSReason_Edit.php");break;
    case "HoSReason_Edit_Save":@include("modules/$modname/admin/HoSReason_Edit_Save.php");break;
    case "HoSReason_List":@include("modules/$modname/admin/HoSReason_List.php");break;
    case "HoSReasonCat_Add":@include("modules/$modname/admin/HoSReasonCat_Add.php");break;
	case "HoSReasonCat_Add_Save":@include("modules/$modname/admin/HoSReasonCat_Add_Save.php");break;
	case "HoSReasonCat_Delete":@include("modules/$modname/admin/HoSReasonCat_Delete.php");break;
	case "HoSReasonCat_Delete_Save":@include("modules/$modname/admin/HoSReasonCat_Delete_Save.php");break;
	case "HoSReasonCat_Edit":@include("modules/$modname/admin/HoSReasonCat_Edit.php");break;
	case "HoSReasonCat_Edit_Save":@include("modules/$modname/admin/HoSReasonCat_Edit_Save.php");break;
    case "HoSReasonCat_List":@include("modules/$modname/admin/HoSReasonCat_List.php");break;
    case "HoSConfigure":@include("modules/$modname/admin/HoSConfigure.php");break;
    case "HoSConfigure_Save":@include("modules/$modname/admin/HoSConfigure_Save.php");break;
    case "HoSPunk_Add":@include("modules/$modname/admin/HoSPunk_Add.php");break;
    case "HoSPunk_Add_Save":@include("modules/$modname/admin/HoSPunk_Add_Save.php");break;
    case "HoSPunk_Delete":@include("modules/$modname/admin/HoSPunk_Delete.php");break;
    case "HoSPunk_Delete_Save":@include("modules/$modname/admin/HoSPunk_Delete_Save.php");break;
    case "HoSPunk_Edit":@include("modules/$modname/admin/HoSPunk_Edit.php");break;
    case "HoSPunk_Edit_Save":@include("modules/$modname/admin/HoSPunk_Edit_Save.php");break;
    case "HoSPunk_List":@include("modules/$modname/admin/HoSPunk_List.php");break;
    case "HoSMember_Add":@include("modules/$modname/admin/HoSMember_Add.php");break;
	case "HoSMember_Add_Save":@include("modules/$modname/admin/HoSMember_Add_Save.php");break;
	case "HoSMember_Delete":@include("modules/$modname/admin/HoSMember_Delete.php");break;
	case "HoSMember_Delete_Save":@include("modules/$modname/admin/HoSMember_Delete_Save.php");break;
	case "HoSMember_Edit":@include("modules/$modname/admin/HoSMember_Edit.php");break;
	case "HoSMember_Edit_Save":@include("modules/$modname/admin/HoSMember_Edit_Save.php");break;
    case "HoSMember_List":@include("modules/$modname/admin/HoSMember_List.php");break;
    case "HoSHelp":@include("modules/$modname/admin/HoSHelp.php");break;
  }
}

?>