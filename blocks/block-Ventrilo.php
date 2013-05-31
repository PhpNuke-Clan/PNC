<?php
####################################################################
#  This file is Copyright (c)2006 PNC phpnuke-clan.net             #
#  info@phpnuke-clan.net                                           #
#  Please keep ALL copyright information in here....			   #
####################################################################
# 	Orignial code by: http://www.ventriloservers.biz               #
####################################################################
//If using normal:
if ( !defined('BLOCK_FILE') ) {
    Header("Location: ../index.php");
    die();
}
$module_name ="Ventrilo";
define("VENT_BL", true);
$content = "";
#############################################################################################
#below you can activate or disable the images next to the channels,server name, and clients #
#############################################################################################

//Display Server:
ob_start();
	include("modules/$module_name/blockfile.php");
	$output = ob_get_contents();
	ob_end_clean();
	$content .= $output;

?>