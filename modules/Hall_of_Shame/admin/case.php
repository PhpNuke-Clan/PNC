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
get_lang($modname);

switch($op) {

        case "HoSAdmin":
        case "HoSReason_Add":
        case "HoSReason_Add_Save":
        case "HoSReason_Delete":
        case "HoSReason_Delete_Save":
        case "HoSReason_Edit":
        case "HoSReason_Edit_Save":
        case "HoSReason_List":
        case "HoSReasonCat_Add":
		case "HoSReasonCat_Add_Save":
		case "HoSReasonCat_Delete":
		case "HoSReasonCat_Delete_Save":
		case "HoSReasonCat_Edit":
		case "HoSReasonCat_Edit_Save":
        case "HoSReasonCat_List":
        case "HoSConfigure":
        case "HoSConfigure_Save":
        case "HoSPunk_Add":
        case "HoSPunk_Add_Save":
        case "HoSPunk_Delete":
        case "HoSPunk_Delete_Save":
        case "HoSPunk_Edit":
        case "HoSPunk_Edit_Save":
        case "HoSPunk_List":
        case "HoSMember_Add":
		case "HoSMember_Add_Save":
		case "HoSMember_Delete":
		case "HoSMember_Delete_Save":
		case "HoSMember_Edit":
		case "HoSMember_Edit_Save":
        case "HoSMember_List":
        case "HoSHelp":
        @include("modules/$modname/admin/index.php");
        break;

}

?>
