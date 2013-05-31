<?php
//*************************************************************************************************
// http://www.tdi-hq.com       aarvuij@hotmail.com                                                *
// =================================================											  *
// Adapted for PHPNUKE-CLAN.COM (PNC 3.0.1)														  *
// http://www.phpnuke-clan.net  support@phpnuke-clan.net            							  *
//*************************************************************************************************
if ( !defined('BLOCK_FILE') ) {
    Header("Location: ../index.php");
    die();
}

global $prefix, $db, $dbi, $sitename, $nukeurl, $n, $vwarnm;


$vwar_modulename = "vwar";
$vwarsiteurl ="$nukeurl";

if($nukeurl == 'http://yoursite.com'){
$content.="Please set your <a href=\"admin.php?op=Configure\">Site url</a>!";	
}
else{
//$ddd = ini_get('allow_url_fopen');
if(ini_get('allow_url_fopen') == 1){
	ob_start();
	include("$nukeurl/modules/$vwar_modulename/extra/countdown.php");
	$output = ob_get_contents();
	ob_end_clean();
	$content .= $output;
	}else{
	$content .="<b>allow_url_fopen</b> is set to <b>off</b> in your php.ini.<br>You can not use this block, or you have to ask your host to activate allow_url_fopen.";
	}
}
// Please leave the copyright, although it wasn't hard to make give a little credit //
//-----------COPYRIGHT START----------->
//-Please dont't remove this copyright->

if (!isset($vwarnm)) {
$content .= "<A HREF='javascript:PopupCentrer(\"blocks/copyright/vwar_count.html\",400,300,\"menubar=no,scrollbars=no,statusbar=no\")'><div align=\"right\">&copy;</div></A>\n"; 
}

//-----------COPYRIGHT END------------->
?>
