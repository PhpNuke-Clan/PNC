<?php
session_start();
//***************************************************************************

/* Author: XenoMorpH ¤TÐI¤ (aarvuijk@hotmail.com)                           */

//***************************************************************************
$step = $_GET['step'];
if($step == "") {
$step = "";
}
$pncv = "4.2.0";
define('PNC_UPD', true);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>PNC 2.1.1/3.0.x to PNC <?php echo $pncv; ?> UPDATE FILE</title></title>
<META NAME="RATING" CONTENT="GENERAL">
<META NAME="GENERATOR" CONTENT="PNC 4.0 http://phpnuke-clan.net">
<style type="text/css">
/*<![CDATA[*/
 body.c1 {background-color:#E2E2E2}
 div.c1 {text-align: center}
 input.c1 {width:300px;}
 p.c1 {font-weight: bold}
 span.c1 {font-size:small;}
 span.c2 {color:red;font-weight:bold;}
 span.c3 {color:blue;font-weight:bold;}
/*]]>*/
</style>
</head>
  <body class="c1">
  <img src="PNC_logo.png" border="0" alt="" />
    <h2>
      PNC&trade; &copy; 2006, 2007 - PNC <?php echo $pncv; ?>
    </h2>
<?php
//require_once("mainfile.php");
//include("header.php");
require("../config.php");
if(!mysql_select_db($dbname, mysql_connect($dbhost, $dbuname, $dbpass)))
{echo"Couldn't connect to database";                                                        
exit();
}
$step = $_GET['step'];
if($step == "") {
$step = "1";
}
global $prefix,$db,$user_prefix;
//OpenTable();
if($step == "1"){
echo"<center>This file will update your PNC 2.1.1 to PNC3.0.1<br><br>
<a href=$PHP_SELF?step=2>Update</a><br></center>";
}
function mysql_table_exists($table) {
   $exists = mysql_query("SELECT 1 FROM `$table` LIMIT 0");
   if ($exists) return true;
   return false;
}

if($step == "2"){
	if (!mysql_table_exists("".$prefix."_calendar_categories")) {
   	echo"Tabel <b>".$prefix."_calendar_categories</b> does not exist, that's ok :)<br>";} 
	else{mysql_query("DROP TABLE ".$prefix."_calendar_categories") or die('MySQL said: '.mysql_error());
	echo"Table <b>".$prefix."_calendar_categories</b> is deleted<br>";}
	//######
	if (!mysql_table_exists("".$prefix."_calendar_events")) {
   	echo"Tabel <b>".$prefix."_calendar_events</b> does not exist, that's ok :)<br>";} 
	else{mysql_query("DROP TABLE ".$prefix."_calendar_events") or die('MySQL said: '.mysql_error());
	echo"Table <b>".$prefix."_calendar_events</b> is deleted<br>";}
	//######
	if (!mysql_table_exists("".$prefix."_calendar_options")) {
   	echo"Tabel <b>".$prefix."_calendar_options</b> does not exist, that's ok :)<br>";} 
	else{mysql_query("DROP TABLE ".$prefix."_calendar_options") or die('MySQL said: '.mysql_error());
	echo"Table <b>".$prefix."_calendar_options</b> is deleted<br><br>";}
	//######
	//_downloads
	//############################################################################
	if (!mysql_table_exists("".$prefix."_downloads_categories")) {
   	echo"Tabel <b>".$prefix."_downloads_categories</b> does not exist, that's ok :)<br>";} 
	else{mysql_query("DROP TABLE ".$prefix."_downloads_categories") or die('MySQL said: '.mysql_error());
	echo"Table <b>".$prefix."_downloads_categories</b> is deleted<br>";}
	//######	
	if (!mysql_table_exists("".$prefix."_downloads_downloads")) {
   	echo"Tabel <b>".$prefix."_downloads_downloads</b> does not exist, that's ok :)<br>";} 
	else{mysql_query("DROP TABLE ".$prefix."_downloads_downloads") or die('MySQL said: '.mysql_error());
	echo"Table <b>".$prefix."_calendar_downloads</b> is deleted<br>";}
	//######	
	if (!mysql_table_exists("".$prefix."_downloads_editorials")) {
   	echo"Tabel <b>".$prefix."_downloads_editorials</b> does not exist, that's ok :)<br>";} 
	else{mysql_query("DROP TABLE ".$prefix."_downloads_editorials") or die('MySQL said: '.mysql_error());
	echo"Table <b>".$prefix."_calendar_editorials</b> is deleted<br>";}
	//######	
	if (!mysql_table_exists("".$prefix."_downloads_modrequest")) {
   	echo"Tabel <b>".$prefix."_downloads_modrequest</b> does not exist, that's ok :)<br>";} 
	else{mysql_query("DROP TABLE ".$prefix."_downloads_modrequest") or die('MySQL said: '.mysql_error());
	echo"Table <b>".$prefix."_calendar_modrequest</b> is deleted<br>";}
	//######	
	if (!mysql_table_exists("".$prefix."_downloads_newdownload")) {
   	echo"Tabel <b>".$prefix."_downloads_newdownload</b> does not exist, that's ok :)<br>";} 
	else{mysql_query("DROP TABLE ".$prefix."_downloads_newdownload") or die('MySQL said: '.mysql_error());
	echo"Table <b>".$prefix."_calendar_newdownload</b> is deleted<br>";}
	//######	
	if (!mysql_table_exists("".$prefix."_downloads_votedata")) {
   	echo"Tabel <b>".$prefix."_downloads_votedata</b> does not exist, that's ok :)<br>";} 
	else{mysql_query("DROP TABLE ".$prefix."_downloads_votedata") or die('MySQL said: '.mysql_error());
	echo"Table <b>".$prefix."_calendar_votedata</b> is deleted<br><br>";}
	//######	
	//_hosting
	//############################################################################	
	if (!mysql_table_exists("".$prefix."_hosting")) {
   	echo"Tabel <b>".$prefix."_hosting</b> does not exist, that's ok :)<br>";} 
	else{mysql_query("DROP TABLE ".$prefix."_hosting") or die('MySQL said: '.mysql_error());
	echo"Table <b>".$prefix."_hosting</b> is deleted<br>";}
	//######	
	if (!mysql_table_exists("".$prefix."_hosting_config")) {
   	echo"Tabel <b>".$prefix."_hosting_config</b> does not exist, that's ok :)<br>";} 
	else{mysql_query("DROP TABLE ".$prefix."_hosting_config") or die('MySQL said: '.mysql_error());
	echo"Table <b>".$prefix."_hosting_config</b> is deleted<br><br>";}
	//######	
	//_nc_contact
	//############################################################################
	if (!mysql_table_exists("".$prefix."_ns_contact_add")) {
   	echo"Tabel <b>".$prefix."_ns_contact_add</b> does not exist, that's ok :)<br>";} 
	else{mysql_query("DROP TABLE ".$prefix."_ns_contact_add") or die('MySQL said: '.mysql_error());
	echo"Table <b>".$prefix."_ns_contact_add</b> is deleted<br>";}
	//######	
	if (!mysql_table_exists("".$prefix."_ns_contact_dept")) {
   	echo"Tabel <b>".$prefix."_ns_contact_dept</b> does not exist, that's ok :)<br>";} 
	else{mysql_query("DROP TABLE ".$prefix."_ns_contact_dept") or die('MySQL said: '.mysql_error());
	echo"Table <b>".$prefix."_ns_contact_dept</b> is deleted<br>";}
	//######		
	if (!mysql_table_exists("".$prefix."_ns_contact_phone")) {
   	echo"Tabel <b>".$prefix."_ns_contact_phone</b> does not exist, that's ok :)<br>";} 
	else{mysql_query("DROP TABLE ".$prefix."_ns_contact_phone") or die('MySQL said: '.mysql_error());
	echo"Table <b>".$prefix."_ns_contact_phone</b> is deleted<br>";}
	//######	
	if (!mysql_table_exists("".$prefix."_ns_contact_show")) {
   	echo"Tabel <b>".$prefix."_ns_contact_show</b> does not exist, that's ok :)<br>";} 
	else{mysql_query("DROP TABLE ".$prefix."_ns_contact_show") or die('MySQL said: '.mysql_error());
	echo"Table <b>".$prefix."_ns_contact_show</b> is deleted<br><br><br>";}
	//######		
	//############################################################################	
	// _nsnba_banners
	//############################################################################
	if (!mysql_table_exists("".$prefix."_nsnba_banners")) {
   	echo"Tabel <b>".$prefix."_nsnba_banners<</b> does not exist, that's ok :)<br>";} 
	else{mysql_query("DROP TABLE ".$prefix."_nsnba_banners") or die('MySQL said: '.mysql_error());
	echo"Table <b>".$prefix."_nsnba_banners</b> is deleted<br>";}
	//######	
	if (!mysql_table_exists("".$prefix."_nsnba_clients")) {
   	echo"Tabel <b>".$prefix."_nsnba_clients</b> does not exist, that's ok :)<br>";} 
	else{mysql_query("DROP TABLE ".$prefix."_nsnba_clients") or die('MySQL said: '.mysql_error());
	echo"Table <b>".$prefix."_nsnba_clients</b> is deleted<br>";}
	//######		
	if (!mysql_table_exists("".$prefix."_nsnba_config")) {
   	echo"Tabel <b>".$prefix."_nsnba_config</b> does not exist, that's ok :)<br>";} 
	else{mysql_query("DROP TABLE ".$prefix."_nsnba_config") or die('MySQL said: '.mysql_error());
	echo"Table <b>".$prefix."_nsnba_config</b> is deleted<br>";}
	//######	
	if (!mysql_table_exists("".$prefix."_nsnba_extinctions")) {
   	echo"Tabel <b>".$prefix."_nsnba_extinctions</b> does not exist, that's ok :)<br>";} 
	else{mysql_query("DROP TABLE ".$prefix."_nsnba_extinctions") or die('MySQL said: '.mysql_error());
	echo"Table <b>".$prefix."_nsnba_extinctions</b> is deleted<br><br>";}
	//######		
	//Nukec_
	//############################################################################		
	if (!mysql_table_exists("".$prefix."_nukec_ads_ads")) {
   	echo"Tabel <b>".$prefix."_nukec_ads_ads</b> does not exist, that's ok :)<br>";} 
	else{mysql_query("DROP TABLE ".$prefix."_nukec_ads_ads") or die('MySQL said: '.mysql_error());
	echo"Table <b>".$prefix."_nukec_ads_ads</b> is deleted<br>";}
	//######	
	if (!mysql_table_exists("".$prefix."_nukec_ads_box")) {
   	echo"Tabel <b>".$prefix."_nukec_ads_box</b> does not exist, that's ok :)<br>";} 
	else{mysql_query("DROP TABLE ".$prefix."_nukec_ads_box") or die('MySQL said: '.mysql_error());
	echo"Table <b>".$prefix."_nukec_ads_box</b> is deleted<br>";}
	//######	
	if (!mysql_table_exists("".$prefix."_nukec_ads_catg")) {
   	echo"Tabel <b>".$prefix."_nukec_ads_catg</b> does not exist, that's ok :)<br>";} 
	else{mysql_query("DROP TABLE ".$prefix."_nukec_ads_catg") or die('MySQL said: '.mysql_error());
	echo"Table <b>".$prefix."_nukec_ads_catg</b> is deleted<br>";}
	//######		
	if (!mysql_table_exists("".$prefix."_nukec_ads_comments")) {
   	echo"Tabel <b>".$prefix."_nukec_ads_comments</b> does not exist, that's ok :)<br>";} 
	else{mysql_query("DROP TABLE ".$prefix."_nukec_ads_comments") or die('MySQL said: '.mysql_error());
	echo"Table <b>".$prefix."_nukec_ads_comments</b> is deleted<br>";}
	//######	
	if (!mysql_table_exists("".$prefix."_nukec_ads_config")) {
   	echo"Tabel <b>".$prefix."_nukec_ads_config</b> does not exist, that's ok :)<br>";} 
	else{mysql_query("DROP TABLE ".$prefix."_nukec_ads_config") or die('MySQL said: '.mysql_error());
	echo"Table <b>".$prefix."_nukec_ads_config</b> is deleted<br>";}
	//######	
	if (!mysql_table_exists("".$prefix."_nukec_ads_currency")) {
   	echo"Tabel <b>".$prefix."_nukec_ads_currency</b> does not exist, that's ok :)<br>";} 
	else{mysql_query("DROP TABLE ".$prefix."_nukec_ads_currency") or die('MySQL said: '.mysql_error());
	echo"Table <b>".$prefix."_nukec_ads_currency</b> is deleted<br>";}
	//######	
	if (!mysql_table_exists("".$prefix."_nukec_ads_custom")) {
   	echo"Tabel <b>".$prefix."_nukec_ads_custom</b> does not exist, that's ok :)<br>";} 
	else{mysql_query("DROP TABLE ".$prefix."_nukec_ads_custom") or die('MySQL said: '.mysql_error());
	echo"Table <b>".$prefix."_nukec_ads_custom</b> is deleted<br>";}
	//######	
	if (!mysql_table_exists("".$prefix."_nukec_ads_disclaimer")) {
   	echo"Tabel <b>".$prefix."_nukec_ads_disclaimer</b> does not exist, that's ok :)<br>";} 
	else{mysql_query("DROP TABLE ".$prefix."_nukec_ads_disclaimer") or die('MySQL said: '.mysql_error());
	echo"Table <b>".$prefix."_nukec_ads_disclaimer</b> is deleted<br>";}
	//######	
	if (!mysql_table_exists("".$prefix."_nukec_ads_duration")) {
   	echo"Tabel <b>".$prefix."_nukec_ads_duration</b> does not exist, that's ok :)<br>";} 
	else{mysql_query("DROP TABLE ".$prefix."_nukec_ads_duration") or die('MySQL said: '.mysql_error());
	echo"Table <b>".$prefix."_nukec_ads_duration</b> is deleted<br>";}
	//######	
	if (!mysql_table_exists("".$prefix."_nukec_ads_filter")) {
   	echo"Tabel <b>".$prefix."_nukec_ads_filter</b> does not exist, that's ok :)<br>";} 
	else{mysql_query("DROP TABLE ".$prefix."_nukec_ads_filter") or die('MySQL said: '.mysql_error());
	echo"Table <b>".$prefix."_nukec_ads_filter</b> is deleted<br>";}
	//######	
	if (!mysql_table_exists("".$prefix."_nukec_ads_imgtype")) {
   	echo"Tabel <b>".$prefix."_nukec_ads_imgtype</b> does not exist, that's ok :)<br>";} 
	else{mysql_query("DROP TABLE ".$prefix."_nukec_ads_imgtype") or die('MySQL said: '.mysql_error());
	echo"Table <b>".$prefix."_nukec_ads_imgtype</b> is deleted<br><br>";}
	//######	
	//############################################################################			
	// _ofxviewer
	//######	
	if (!mysql_table_exists("".$prefix."_ofxviewer_columns")) {
   	echo"Tabel <b>".$prefix."_ofxviewer_columns</b> does not exist, that's ok :)<br>";} 
	else{mysql_query("DROP TABLE ".$prefix."_ofxviewer_columns") or die('MySQL said: '.mysql_error());
	echo"Table <b>".$prefix."_ofxviewer_columns</b> is deleted<br>";}
	//######	
	if (!mysql_table_exists("".$prefix."_ofxviewer_config")) {
   	echo"Tabel <b>".$prefix."_ofxviewer_config</b> does not exist, that's ok :)<br>";} 
	else{mysql_query("DROP TABLE ".$prefix."_ofxviewer_config") or die('MySQL said: '.mysql_error());
	echo"Table <b>".$prefix."_ofxviewer_config</b> is deleted<br>";}
	//######	
	if (!mysql_table_exists("".$prefix."_ofxviewer_gameservers")) {
   	echo"Tabel <b>".$prefix."_ofxviewer_gameservers</b> does not exist, that's ok :)<br>";} 
	else{mysql_query("DROP TABLE ".$prefix."_ofxviewer_gameservers") or die('MySQL said: '.mysql_error());
	echo"Table <b>".$prefix."_ofxviewer_gameservers</b> is deleted<br>";}
	//######	
	if (!mysql_table_exists("".$prefix."_ofxviewer_plugin")) {
   	echo"Tabel <b>".$prefix."_ofxviewer_plugin</b> does not exist, that's ok :)<br>";} 
	else{mysql_query("DROP TABLE ".$prefix."_ofxviewer_plugin") or die('MySQL said: '.mysql_error());
	echo"Table <b>".$prefix."_ofxviewer_plugin</b> is deleted<br>";}
	//######	
	if (!mysql_table_exists("".$prefix."_ofxviewer_serverscategories")) {
   	echo"Tabel <b>".$prefix."_ofxviewer_serverscategories</b> does not exist, that's ok :)<br>";} 
	else{mysql_query("DROP TABLE ".$prefix."_ofxviewer_serverscategories") or die('MySQL said: '.mysql_error());
	echo"Table <b>".$prefix."_ofxviewer_serverscategories</b> is deleted<br><br>";}
	//######
	//############################################################################			
	//_reviews
	if (!mysql_table_exists("".$prefix."_reviews")) {
   	echo"Tabel <b>".$prefix."_reviews</b> does not exist, that's ok :)<br>";} 
	else{mysql_query("DROP TABLE ".$prefix."_reviews") or die('MySQL said: '.mysql_error());
	echo"Table <b>".$prefix."_reviews</b> is deleted<br>";}
	//######	
	if (!mysql_table_exists("".$prefix."_reviews_cats")) {
   	echo"Tabel <b>".$prefix."_reviews_cats</b> does not exist, that's ok :)<br>";} 
	else{mysql_query("DROP TABLE ".$prefix."_reviews_cats") or die('MySQL said: '.mysql_error());
	echo"Table <b>".$prefix."_reviews_cats</b> is deleted<br>";}
	//######	
	if (!mysql_table_exists("".$prefix."_reviews_comments")) {
   	echo"Tabel <b>".$prefix."_reviews_comments</b> does not exist, that's ok :)<br>";} 
	else{mysql_query("DROP TABLE ".$prefix."_reviews_comments") or die('MySQL said: '.mysql_error());
	echo"Table <b>".$prefix."_reviews_comments</b> is deleted<br>";}
	//######	
	if (!mysql_table_exists("".$prefix."_reviews_conf")) {
   	echo"Tabel <b>".$prefix."_reviews_conf</b> does not exist, that's ok :)<br>";} 
	else{mysql_query("DROP TABLE ".$prefix."_reviews_conf") or die('MySQL said: '.mysql_error());
	echo"Table <b>".$prefix."_reviews_conf</b> is deleted<br>";}
	//######	
	if (!mysql_table_exists("".$prefix."_reviews_pend")) {
   	echo"Tabel <b>".$prefix."_reviews_pend</b> does not exist, that's ok :)<br>";} 
	else{mysql_query("DROP TABLE ".$prefix."_reviews_pend") or die('MySQL said: '.mysql_error());
	echo"Table <b>".$prefix."_reviews_pend</b> is deleted<br>";}
	//######	
	if (!mysql_table_exists("".$prefix."_reviews_sub_cats")) {
   	echo"Tabel <b>".$prefix."_reviews_sub_cats</b> does not exist, that's ok :)<br>";} 
	else{mysql_query("DROP TABLE ".$prefix."_reviews_sub_cats") or die('MySQL said: '.mysql_error());
	echo"Table <b>".$prefix."_reviews_sub_cats</b> is deleted<br><br>";}
	//######
	//_staff
	//############################################################################			
	

	if (!mysql_table_exists("".$prefix."_staff")) {
   	echo"Tabel <b>".$prefix."_staff</b> does not exist, that's ok :)<br>";} 
	else{mysql_query("DROP TABLE ".$prefix."_staff") or die('MySQL said: '.mysql_error());
	echo"Table <b>".$prefix."_staff</b> is deleted<br>";}
	//######
	if (!mysql_table_exists("".$prefix."_staff_cat")) {
   	echo"Tabel <b>".$prefix."_staff_cat</b> does not exist, that's ok :)<br>";} 
	else{mysql_query("DROP TABLE ".$prefix."_staff_cat") or die('MySQL said: '.mysql_error());
	echo"Table <b>".$prefix."_staff_cat</b> is deleted<br>";}
	//######
	if (!mysql_table_exists("".$prefix."_staff_config")) {
   	echo"Tabel <b>".$prefix."_staff_config</b> does not exist, that's ok :)<br>";} 
	else{mysql_query("DROP TABLE ".$prefix."_staff_config") or die('MySQL said: '.mysql_error());
	echo"Table <b>".$prefix."_staff_config</b> is deleted<br><br>";}
	//######		
	//_top_sites
	//############################################################################			

	if (!mysql_table_exists("".$prefix."_top_sites")) {
   	echo"Tabel <b>".$prefix."_staff</b> does not exist, that's ok :)<br>";} 
	else{mysql_query("DROP TABLE ".$prefix."_top_sites") or die('MySQL said: '.mysql_error());
	echo"Table <b>".$prefix."_top_sites</b> is deleted<br>";}
	//######
	if (!mysql_table_exists("".$prefix."_top_sites_categories")) {
   	echo"Tabel <b>".$prefix."_top_sites_categories</b> does not exist, that's ok :)<br>";} 
	else{mysql_query("DROP TABLE ".$prefix."_top_sites_categories") or die('MySQL said: '.mysql_error());
	echo"Table <b>".$prefix."_top_sites_categories</b> is deleted<br>";}
	//######
	if (!mysql_table_exists("".$prefix."_top_sites_config")) {
   	echo"Tabel <b>".$prefix."_top_sites_config</b> does not exist, that's ok :)<br>";} 
	else{mysql_query("DROP TABLE ".$prefix."_top_sites_config") or die('MySQL said: '.mysql_error());
	echo"Table <b>".$prefix."_top_sites_config</b> is deleted<br>";}
	//######
	if (!mysql_table_exists("".$prefix."_top_sites_votedata")) {
   	echo"Tabel <b>".$prefix."_top_sites_votedata</b> does not exist, that's ok :)<br>";} 
	else{mysql_query("DROP TABLE ".$prefix."_top_sites_votedata") or die('MySQL said: '.mysql_error());
	echo"Table <b>".$prefix."_top_sites_votedata</b> is deleted<br><br>";}
	//######
	//_universal
	//############################################################################				
	if (!mysql_table_exists("".$prefix."_universal_categories")) {
   	echo"Tabel <b>".$prefix."_universal_categories</b> does not exist, that's ok :)<br>";} 
	else{mysql_query("DROP TABLE ".$prefix."_universal_categories") or die('MySQL said: '.mysql_error());
	echo"Table <b>".$prefix."_universal_categories</b> is deleted<br>";}
	//######
		if (!mysql_table_exists("".$prefix."_universal_cfg")) {
   	echo"Tabel <b>".$prefix."_universal_cfg</b> does not exist, that's ok :)<br>";} 
	else{mysql_query("DROP TABLE ".$prefix."_universal_cfg") or die('MySQL said: '.mysql_error());
	echo"Table <b>".$prefix."_universal_cfg</b> is deleted<br>";}
	//######
		if (!mysql_table_exists("".$prefix."_universal_comments")) {
   	echo"Tabel <b>".$prefix."_universal_comments</b> does not exist, that's ok :)<br>";} 
	else{mysql_query("DROP TABLE ".$prefix."_universal_comments") or die('MySQL said: '.mysql_error());
	echo"Table <b>".$prefix."_universal_comments</b> is deleted<br>";}
	//######
		if (!mysql_table_exists("".$prefix."_universal_items")) {
   	echo"Tabel <b>".$prefix."_universal_items</b> does not exist, that's ok :)<br>";} 
	else{mysql_query("DROP TABLE ".$prefix."_universal_items") or die('MySQL said: '.mysql_error());
	echo"Table <b>".$prefix."_universal_items</b> is deleted<br>";}
	//######
		if (!mysql_table_exists("".$prefix."_universal_modify")) {
   	echo"Tabel <b>".$prefix."_universal_modify</b> does not exist, that's ok :)<br>";} 
	else{mysql_query("DROP TABLE ".$prefix."_universal_modify") or die('MySQL said: '.mysql_error());
	echo"Table <b>".$prefix."_universal_modify</b> is deleted<br>";}
	//######
		if (!mysql_table_exists("".$prefix."_universal_queue")) {
   	echo"Tabel <b>".$prefix."_universal_queue</b> does not exist, that's ok :)<br>";} 
	else{mysql_query("DROP TABLE ".$prefix."_universal_queue") or die('MySQL said: '.mysql_error());
	echo"Table <b>".$prefix."_universal_queue</b> is deleted<br>";}
	//######
		if (!mysql_table_exists("".$prefix."_universal_related")) {
   	echo"Tabel <b>".$prefix."_universal_related</b> does not exist, that's ok :)<br>";} 
	else{mysql_query("DROP TABLE ".$prefix."_universal_related") or die('MySQL said: '.mysql_error());
	echo"Table <b>".$prefix."_universal_related</b> is deleted<br>";}
	//######
		if (!mysql_table_exists("".$prefix."_universal_requests")) {
   	echo"Tabel <b>".$prefix."_universal_requests</b> does not exist, that's ok :)<br>";} 
	else{mysql_query("DROP TABLE ".$prefix."_universal_requests") or die('MySQL said: '.mysql_error());
	echo"Table <b>".$prefix."_universal_requests</b> is deleted<br><br>";}
	//######
		if (!mysql_table_exists("".$prefix."_pnc_technology")) {
	mysql_query("CREATE TABLE `".$prefix."_pnc_technology` (
  	`name` varchar(20) NOT NULL default '',
	`value` text NOT NULL) TYPE=MyISAM;") or die('MySQL said: '.mysql_error());
	mysql_query("INSERT INTO `".$prefix."_pnc_technology` VALUES ('versioncheck', '3.0.1');");
	mysql_query("INSERT INTO `".$prefix."_pnc_technology` VALUES ('lastupdatecheck', '1116781442');");
	echo"Table <b>".$prefix."_pnc_technology</b> is added to the database<br><br>";
   	}else{echo"Tabel <b>".$prefix."_pnc_technology</b> already exists<br>";}
	//######
	mysql_query("ALTER TABLE `".$prefix."_config` ADD displayerror tinyint(1) NOT NULL default '0' AFTER Version_Num;");
	echo"displayerro has been added to table: <b>".$prefix."_config</b> After Version_Num<br><br>";
	mysql_query("UPDATE `".$prefix."_config` SET Version_Num = '301';");
	
	
	mysql_query("ALTER TABLE `".$prefix."_users` MODIFY user_color_gi text");
	
	mysql_query("ALTER TABLE `".$prefix."_bbgroups` ADD `canned_footer_plain` text NOT NULL AFTER group_single_user;");
  	mysql_query("ALTER TABLE `".$prefix."_bbgroups` ADD `canned_footer_bbcode` text NOT NULL AFTER canned_footer_plain;");
  	mysql_query("ALTER TABLE `".$prefix."_bbgroups` ADD `canned_custom_count` mediumint(8) unsigned NOT NULL default '0' AFTER canned_footer_bbcode;");
		echo"canned_footer_plain, canned_footer_bbcode, canned_custom_count, have been added!!<br>";
	echo"<center><br><br>
<a href=\"$PHP_SELF?step=3\">Add the New tables</a><br></center>";
}



if($step == 3){
mysql_query("CREATE TABLE `".$prefix."_bbcash` (
  `cash_id` smallint(6) NOT NULL auto_increment,
  `cash_order` smallint(6) NOT NULL default '0',
  `cash_settings` smallint(4) NOT NULL default '3313',
  `cash_dbfield` varchar(64) NOT NULL default 'user_cash',
  `cash_name` varchar(64) NOT NULL default 'cash',
  `cash_default` int(11) NOT NULL default '0',
  `cash_decimals` tinyint(2) NOT NULL default '0',
  `cash_imageurl` varchar(255) NOT NULL default '',
  `cash_exchange` int(11) NOT NULL default '1',
  `cash_perpost` int(11) NOT NULL default '25',
  `cash_postbonus` int(11) NOT NULL default '2',
  `cash_perreply` int(11) NOT NULL default '25',
  `cash_maxearn` int(11) NOT NULL default '75',
  `cash_perpm` int(11) NOT NULL default '0',
  `cash_perchar` int(11) NOT NULL default '20',
  `cash_allowance` tinyint(1) NOT NULL default '0',
  `cash_allowanceamount` int(11) NOT NULL default '0',
  `cash_allowancetime` tinyint(2) NOT NULL default '2',
  `cash_allowancenext` int(11) NOT NULL default '0',
  `cash_forumlist` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`cash_id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;");

// 
// Dumping data for table `".$prefix."_bbcash`
//

// 
// Table structure for table `".$prefix."_bbcash_events`
// 

mysql_query("CREATE TABLE `".$prefix."_bbcash_events` (
  `event_name` varchar(32) NOT NULL default '',
  `event_data` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`event_name`)
) TYPE=MyISAM;");

// 
// Dumping data for table `".$prefix."_bbcash_events`
//

// 
// Table structure for table `".$prefix."_bbcash_exchange`
// 

mysql_query("CREATE TABLE `".$prefix."_bbcash_exchange` (
  `ex_cash_id1` int(11) NOT NULL default '0',
  `ex_cash_id2` int(11) NOT NULL default '0',
  `ex_cash_enabled` int(1) NOT NULL default '0',
  PRIMARY KEY  (`ex_cash_id1`,`ex_cash_id2`)
) TYPE=MyISAM;");

// 
// Dumping data for table `".$prefix."_bbcash_exchange`
//

// 
// Table structure for table `".$prefix."_bbcash_groups`
// 

mysql_query("CREATE TABLE `".$prefix."_bbcash_groups` (
  `group_id` mediumint(6) NOT NULL default '0',
  `group_type` tinyint(2) NOT NULL default '0',
  `cash_id` smallint(6) NOT NULL default '0',
  `cash_perpost` int(11) NOT NULL default '0',
  `cash_postbonus` int(11) NOT NULL default '0',
  `cash_perreply` int(11) NOT NULL default '0',
  `cash_perchar` int(11) NOT NULL default '0',
  `cash_maxearn` int(11) NOT NULL default '0',
  `cash_perpm` int(11) NOT NULL default '0',
  `cash_allowance` tinyint(1) NOT NULL default '0',
  `cash_allowanceamount` int(11) NOT NULL default '0',
  `cash_allowancetime` tinyint(2) NOT NULL default '2',
  `cash_allowancenext` int(11) NOT NULL default '0',
  PRIMARY KEY  (`group_id`,`group_type`,`cash_id`)
) TYPE=MyISAM;");

// 
// Dumping data for table `".$prefix."_bbcash_groups`
//

// 
// Table structure for table `".$prefix."_bbcash_log`
// 

mysql_query("CREATE TABLE `".$prefix."_bbcash_log` (
  `log_id` int(11) NOT NULL auto_increment,
  `log_time` int(11) NOT NULL default '0',
  `log_type` smallint(6) NOT NULL default '0',
  `log_action` varchar(255) NOT NULL default '',
  `log_text` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`log_id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;");



mysql_query("CREATE TABLE `".$prefix."_bbcanned` (
  `canned_id` mediumint(8) unsigned NOT NULL auto_increment,
  `group_id` mediumint(8) unsigned NOT NULL default '0',
  `canned_title` varchar(100) NOT NULL default '',
  `canned_message` text NOT NULL,
  `canned_enable_bbcode` tinyint(1) NOT NULL default '0',
  `canned_move_after_post` tinyint(1) NOT NULL default '0',
  `canned_lock_after_post` tinyint(1) NOT NULL default '0',
  `sortorder` smallint(4) NOT NULL default '0',
  PRIMARY KEY  (`canned_id`),
  KEY `group_id` (`group_id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;");

mysql_query("CREATE TABLE `".$prefix."_bbcustom_canned` (
   `custom_canned_id` mediumint(8) unsigned NOT NULL auto_increment,
   `group_id` mediumint(8) DEFAULT '0' NOT NULL,
   `user_id` mediumint(8) DEFAULT '0' NOT NULL,
   `custom_canned_title` varchar(100) NOT NULL,
   `custom_canned_message` text NOT NULL,
   `sortorder` smallint(4) DEFAULT '0' NOT NULL,
   PRIMARY KEY (custom_canned_id),
   KEY user_id (user_id),
   KEY group_id (group_id)
)TYPE=MyISAM AUTO_INCREMENT=1 ;");

mysql_query("CREATE TABLE `".$prefix."_bblogs` (
  `id_log` mediumint(10) NOT NULL auto_increment,
  `mode` varchar(50) default NULL,
  `topic_id` mediumint(10) default '0',
  `user_id` mediumint(8) default '0',
  `username` varchar(255) default NULL,
  `user_ip` varchar(8) NOT NULL default '0',
  `time` int(11) default '0',
  PRIMARY KEY  (`id_log`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;");

mysql_query("CREATE TABLE `".$prefix."_bblogs_config` (
  `config_name` varchar(255) NOT NULL default '',
  `config_value` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`config_name`)
) TYPE=MyISAM;");

mysql_query("CREATE TABLE `".$prefix."_nsnne_config` (
  `config_name` varchar(255) NOT NULL default '',
  `config_value` longtext NOT NULL,
  UNIQUE KEY `config_name` (`config_name`)
) TYPE=MyISAM;");

// 
// Dumping data for table `".$prefix."_nsnne_config`
// 

mysql_query("INSERT INTO `".$prefix."_nsnne_config` VALUES ('allowed_tags', 'b=>1\r\ni=>1\r\na=>2\r\nem=>1\r\nbr=>1\r\nstrong=>1\r\nblockquote=>1\r\ntt=>1\r\nli=>1\r\nol=>1\r\nul=>1\r\np=>1\r\nhr=>1');");
mysql_query("INSERT INTO `".$prefix."_nsnne_config` VALUES ('allow_comments', '1');");
mysql_query("INSERT INTO `".$prefix."_nsnne_config` VALUES ('allow_polls', '1');");
mysql_query("INSERT INTO `".$prefix."_nsnne_config` VALUES ('allow_rating', '1');");
mysql_query("INSERT INTO `".$prefix."_nsnne_config` VALUES ('allow_related', '1');");
mysql_query("INSERT INTO `".$prefix."_nsnne_config` VALUES ('anonymous_post', '1');");
mysql_query("INSERT INTO `".$prefix."_nsnne_config` VALUES ('approved_users', '');");
mysql_query("INSERT INTO `".$prefix."_nsnne_config` VALUES ('censor_list', 'motherfucking\r\nmotherfucker\r\nmotherfuking\r\nmotherfuker\r\ncocksucking\r\ncocksucker\r\ncocksuking\r\ncocksuker\r\nbastard\r\nfucking\r\nsucking\r\nfucker\r\nsucker\r\nfuking\r\nsuking\r\nfuker\r\nsuker\r\nbitch\r\npenis\r\npussy\r\ndick\r\nfuck\r\nsuck\r\ncunt\r\ncock\r\nc0ck\r\ntwat\r\nclit\r\ncum\r\nfuk');");
mysql_query("INSERT INTO `".$prefix."_nsnne_config` VALUES ('censor_mode', '1');");
mysql_query("INSERT INTO `".$prefix."_nsnne_config` VALUES ('censor_replace', '*');");
mysql_query("INSERT INTO `".$prefix."_nsnne_config` VALUES ('columns', '1');");
mysql_query("INSERT INTO `".$prefix."_nsnne_config` VALUES ('comment_limit', '4096');");
mysql_query("INSERT INTO `".$prefix."_nsnne_config` VALUES ('default_mode', 'nested');");
mysql_query("INSERT INTO `".$prefix."_nsnne_config` VALUES ('default_order', '1');");
mysql_query("INSERT INTO `".$prefix."_nsnne_config` VALUES ('default_thold', '0');");
mysql_query("INSERT INTO `".$prefix."_nsnne_config` VALUES ('homenumber', '10');");
mysql_query("INSERT INTO `".$prefix."_nsnne_config` VALUES ('hometopic', '0');");
mysql_query("INSERT INTO `".$prefix."_nsnne_config` VALUES ('notifyauth', '1');");
mysql_query("INSERT INTO `".$prefix."_nsnne_config` VALUES ('notify_admin', '1');");
mysql_query("INSERT INTO `".$prefix."_nsnne_config` VALUES ('notify_commenter', '1');");
mysql_query("INSERT INTO `".$prefix."_nsnne_config` VALUES ('notify_informant', '1');");
mysql_query("INSERT INTO `".$prefix."_nsnne_config` VALUES ('notify_poster', '1');");
mysql_query("INSERT INTO `".$prefix."_nsnne_config` VALUES ('oldnumber', '20');");
mysql_query("INSERT INTO `".$prefix."_nsnne_config` VALUES ('posting_admin', '');");
mysql_query("INSERT INTO `".$prefix."_nsnne_config` VALUES ('readmore', '0');");
mysql_query("INSERT INTO `".$prefix."_nsnne_config` VALUES ('texttype', '0');");
mysql_query("INSERT INTO `".$prefix."_nsnne_config` VALUES ('version_number', '2.0.0');");



mysql_query("CREATE TABLE `".$prefix."_nsnts_categories` (
  `cid` int(11) NOT NULL auto_increment,
  `title` varchar(120) NOT NULL default '',
  PRIMARY KEY  (`cid`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;");

// 
// Dumping data for table `".$prefix."_nsnts_categories`
//

// 
// Table structure for table `".$prefix."_nsnts_compatible`
// 

mysql_query("CREATE TABLE `".$prefix."_nsnts_compatible` (
  `cid` int(11) NOT NULL auto_increment,
  `title` varchar(120) NOT NULL default '',
  PRIMARY KEY  (`cid`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;");

// 
// Dumping data for table `".$prefix."_nsnts_compatible`
//

// 
// Table structure for table `".$prefix."_nsnts_config`
// 

mysql_query("CREATE TABLE `".$prefix."_nsnts_config` (
  `config_name` varchar(50) NOT NULL default '',
  `config_value` text NOT NULL,
  PRIMARY KEY  (`config_name`)
) TYPE=MyISAM;");

// 
// Dumping data for table `".$prefix."_nsnts_config`
// 

mysql_query("INSERT INTO `".$prefix."_nsnts_config` VALUES ('date_format', 'Y-m-d H:i:s');");
mysql_query("INSERT INTO `".$prefix."_nsnts_config` VALUES ('downloadpath', 'modules/Theme_System/images/downloads/');");
mysql_query("INSERT INTO `".$prefix."_nsnts_config` VALUES ('imageheight', '450');");
mysql_query("INSERT INTO `".$prefix."_nsnts_config` VALUES ('imagewidth', '600');");
mysql_query("INSERT INTO `".$prefix."_nsnts_config` VALUES ('imagepath', 'modules/Theme_System/images/pictures/');");
mysql_query("INSERT INTO `".$prefix."_nsnts_config` VALUES ('new', '20');");
mysql_query("INSERT INTO `".$prefix."_nsnts_config` VALUES ('perpage', '20');");
mysql_query("INSERT INTO `".$prefix."_nsnts_config` VALUES ('perrow', '5');");
mysql_query("INSERT INTO `".$prefix."_nsnts_config` VALUES ('popular', '20');");
mysql_query("INSERT INTO `".$prefix."_nsnts_config` VALUES ('search', '20');");
mysql_query("INSERT INTO `".$prefix."_nsnts_config` VALUES ('thumbheight', '75');");
mysql_query("INSERT INTO `".$prefix."_nsnts_config` VALUES ('thumbwidth', '100');");
mysql_query("INSERT INTO `".$prefix."_nsnts_config` VALUES ('thumbpath', 'modules/Theme_System/images/thumbnails/');");
mysql_query("INSERT INTO `".$prefix."_nsnts_config` VALUES ('version_number', '1.0.1');");


mysql_query("CREATE TABLE `".$prefix."_nsnts_themes` (
  `tid` int(11) NOT NULL auto_increment,
  `category` int(11) NOT NULL default '0',
  `title` varchar(120) NOT NULL default '',
  `image` varchar(255) NOT NULL default '',
  `thumb` varchar(255) NOT NULL default '',
  `compatible` int(11) NOT NULL default '0',
  `description` text NOT NULL,
  `url` varchar(255) NOT NULL default '',
  `hits` int(11) NOT NULL default '0',
  `date_add` int(20) NOT NULL default '0',
  `date_edit` int(20) NOT NULL default '0',
  `author` varchar(150) NOT NULL default '',
  `homepage` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`tid`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;");


mysql_query("CREATE TABLE `".$prefix."_nsnwp_config` (
  `config_name` varchar(255) NOT NULL default '',
  `config_value` text NOT NULL
) TYPE=MyISAM;");

// 
// Dumping data for table `".$prefix."_nsnwp_config`
// 

mysql_query("INSERT INTO `".$prefix."_nsnwp_config` VALUES ('admin_report_email', 'webmaster@yoursite.com');");
mysql_query("INSERT INTO `".$prefix."_nsnwp_config` VALUES ('notify_report_admin', '0');");
mysql_query("INSERT INTO `".$prefix."_nsnwp_config` VALUES ('notify_report_submitter', '0');");
mysql_query("INSERT INTO `".$prefix."_nsnwp_config` VALUES ('new_report_status', '1');");
mysql_query("INSERT INTO `".$prefix."_nsnwp_config` VALUES ('new_report_type', '1');");
mysql_query("INSERT INTO `".$prefix."_nsnwp_config` VALUES ('report_date_format', 'Y-m-d H:i:s');");
mysql_query("INSERT INTO `".$prefix."_nsnwp_config` VALUES ('version_number', '1.2.2');");



// 
// Table structure for table `".$prefix."_nsnwp_reports`
// 

mysql_query("CREATE TABLE `".$prefix."_nsnwp_reports` (
  `report_id` int(11) NOT NULL auto_increment,
  `project_id` int(11) NOT NULL default '0',
  `type_id` int(11) NOT NULL default '0',
  `status_id` int(11) NOT NULL default '0',
  `report_name` varchar(255) NOT NULL default '',
  `report_description` text NOT NULL,
  `submitter_name` varchar(32) NOT NULL default '',
  `submitter_email` varchar(255) NOT NULL default '',
  `submitter_ip` varchar(20) NOT NULL default '0.0.0.0',
  `date_submitted` int(14) NOT NULL default '0',
  `date_commented` int(14) NOT NULL default '0',
  `date_modified` int(14) NOT NULL default '0',
  PRIMARY KEY  (`report_id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;");

// 
// Dumping data for table `".$prefix."_nsnwp_reports`
//


// 
// Table structure for table `".$prefix."_nsnwp_reports_comments`
// 

mysql_query("CREATE TABLE `".$prefix."_nsnwp_reports_comments` (
  `comment_id` int(11) NOT NULL auto_increment,
  `report_id` int(11) NOT NULL default '0',
  `commenter_name` varchar(32) NOT NULL default '',
  `commenter_email` varchar(255) NOT NULL default '',
  `commenter_ip` varchar(20) NOT NULL default '0.0.0.0',
  `comment_description` text NOT NULL,
  `date_commented` int(14) NOT NULL default '0',
  PRIMARY KEY  (`comment_id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;");

// 
// Dumping data for table `".$prefix."_nsnwp_reports_comments`
//

// 
// Table structure for table `".$prefix."_nsnwp_reports_members`
// 

mysql_query("CREATE TABLE `".$prefix."_nsnwp_reports_members` (
  `report_id` int(11) NOT NULL default '0',
  `member_id` int(11) NOT NULL default '0'
) TYPE=MyISAM;");

// 
// Dumping data for table `".$prefix."_nsnwp_reports_members`
//

// 
// Table structure for table `".$prefix."_nsnwp_reports_status`
// 

mysql_query("CREATE TABLE `".$prefix."_nsnwp_reports_status` (
  `status_id` int(11) NOT NULL auto_increment,
  `status_name` varchar(255) NOT NULL default '',
  `status_description` text NOT NULL,
  PRIMARY KEY  (`status_id`)
) TYPE=MyISAM AUTO_INCREMENT=7 ;");

// 
// Dumping data for table `".$prefix."_nsnwp_reports_status`
// 

mysql_query("INSERT INTO `".$prefix."_nsnwp_reports_status` VALUES (1, 'Open', 'This report is open.');");
mysql_query("INSERT INTO `".$prefix."_nsnwp_reports_status` VALUES (2, 'Closed', 'This report is closed.');");
mysql_query("INSERT INTO `".$prefix."_nsnwp_reports_status` VALUES (3, 'Bogus', 'This report is bogus.');");
mysql_query("INSERT INTO `".$prefix."_nsnwp_reports_status` VALUES (4, 'Duplicate', 'This report is reported as a duplicate.');");
mysql_query("INSERT INTO `".$prefix."_nsnwp_reports_status` VALUES (5, 'Feedback', 'This report requires/has feedback.');");
mysql_query("INSERT INTO `".$prefix."_nsnwp_reports_status` VALUES (6, 'Assigned', 'Bug has been assigned for researching.');");



// 
// Table structure for table `".$prefix."_nsnwp_reports_types`
// 

mysql_query("CREATE TABLE `".$prefix."_nsnwp_reports_types` (
  `type_id` int(11) NOT NULL auto_increment,
  `type_name` varchar(255) NOT NULL default '',
  `type_description` text NOT NULL,
  PRIMARY KEY  (`type_id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;");


mysql_query("CREATE TABLE `".$prefix."_nsnwr_config` (
  `config_name` varchar(255) NOT NULL default '',
  `config_value` text NOT NULL
) TYPE=MyISAM;");

// 
// Dumping data for table `".$prefix."_nsnwr_config`
// 

mysql_query("INSERT INTO `".$prefix."_nsnwr_config` VALUES ('admin_request_email', 'webmaster@yoursite.com');");
mysql_query("INSERT INTO `".$prefix."_nsnwr_config` VALUES ('notify_request_admin', '0');");
mysql_query("INSERT INTO `".$prefix."_nsnwr_config` VALUES ('notify_request_submitter', '0');");
mysql_query("INSERT INTO `".$prefix."_nsnwr_config` VALUES ('new_request_status', '1');");
mysql_query("INSERT INTO `".$prefix."_nsnwr_config` VALUES ('new_request_type', '1');");
mysql_query("INSERT INTO `".$prefix."_nsnwr_config` VALUES ('request_date_format', 'Y-m-d H:i:s');");
mysql_query("INSERT INTO `".$prefix."_nsnwr_config` VALUES ('version_number', '1.2.2');");



// 
// Table structure for table `".$prefix."_nsnwr_requests`
// 

mysql_query("CREATE TABLE `".$prefix."_nsnwr_requests` (
  `request_id` int(11) NOT NULL auto_increment,
  `project_id` int(11) NOT NULL default '0',
  `type_id` int(11) NOT NULL default '0',
  `status_id` int(11) NOT NULL default '0',
  `request_name` varchar(255) NOT NULL default '',
  `request_description` text NOT NULL,
  `submitter_name` varchar(32) NOT NULL default '',
  `submitter_email` varchar(255) NOT NULL default '',
  `submitter_ip` varchar(20) NOT NULL default '0.0.0.0',
  `date_submitted` int(14) NOT NULL default '0',
  `date_commented` int(14) NOT NULL default '0',
  `date_modified` int(14) NOT NULL default '0',
  PRIMARY KEY  (`request_id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;");

// 
// Dumping data for table `".$prefix."_nsnwr_requests`
//

// 
// Table structure for table `".$prefix."_nsnwr_requests_comments`
// 

mysql_query("CREATE TABLE `".$prefix."_nsnwr_requests_comments` (
  `comment_id` int(11) NOT NULL auto_increment,
  `request_id` int(11) NOT NULL default '0',
  `commenter_name` varchar(32) NOT NULL default '',
  `commenter_email` varchar(255) NOT NULL default '',
  `commenter_ip` varchar(20) NOT NULL default '0.0.0.0',
  `comment_description` text NOT NULL,
  `date_commented` int(14) NOT NULL default '0',
  PRIMARY KEY  (`comment_id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;");

// 
// Dumping data for table `".$prefix."_nsnwr_requests_comments`
//

// 
// Table structure for table `".$prefix."_nsnwr_requests_members`
// 

mysql_query("CREATE TABLE `".$prefix."_nsnwr_requests_members` (
  `request_id` int(11) NOT NULL default '0',
  `member_id` int(11) NOT NULL default '0'
) TYPE=MyISAM;");

// 
// Dumping data for table `".$prefix."_nsnwr_requests_members`
//

// 
// Table structure for table `".$prefix."_nsnwr_requests_status`
// 

mysql_query("CREATE TABLE `".$prefix."_nsnwr_requests_status` (
  `status_id` int(11) NOT NULL auto_increment,
  `status_name` varchar(255) NOT NULL default '',
  `status_description` text NOT NULL,
  PRIMARY KEY  (`status_id`)
) TYPE=MyISAM AUTO_INCREMENT=7 ;");



mysql_query("INSERT INTO `".$prefix."_nsnwr_requests_status` VALUES (1, 'Open', 'This request is open.');");
mysql_query("INSERT INTO `".$prefix."_nsnwr_requests_status` VALUES (2, 'Closed', 'This request is closed.');");
mysql_query("INSERT INTO `".$prefix."_nsnwr_requests_status` VALUES (3, 'Inclusion', 'This request is set for inclusion.');");
mysql_query("INSERT INTO `".$prefix."_nsnwr_requests_status` VALUES (4, 'Duplicate', 'This request is a duplicate.');");
mysql_query("INSERT INTO `".$prefix."_nsnwr_requests_status` VALUES (5, 'Feedback', 'This request requires/has feedback.');");
mysql_query("INSERT INTO `".$prefix."_nsnwr_requests_status` VALUES (6, 'Assigned', 'Request has been assigned for possible inclusion.');");


mysql_query("CREATE TABLE `".$prefix."_nsnwr_requests_types` (
  `type_id` int(11) NOT NULL auto_increment,
  `type_name` varchar(255) NOT NULL default '',
  `type_description` text NOT NULL,
  PRIMARY KEY  (`type_id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;");

mysql_query("CREATE TABLE `".$prefix."_whoiswhere` (
  `username` varchar(25) NOT NULL default '',
  `time` varchar(14) NOT NULL default '',
  `host_addr` varchar(48) NOT NULL default '',
  `guest` int(1) NOT NULL default '0',
  `module` varchar(30) NOT NULL default '',
  `url` varchar(255) NOT NULL default ''
) TYPE=MyISAM;");

mysql_query("INSERT INTO `".$prefix."_whoiswhere` VALUES ('24.201.35.243', '1133236093', '24.201.35.243', 1, 'News', '/');");

mysql_query("ALTER TABLE `".$prefix."_sommaire` ADD `date_debut` bigint(20) unsigned NOT NULL default '0' AFTER dynamic;");
mysql_query("ALTER TABLE `".$prefix."_sommaire` ADD `date_fin` bigint(20) unsigned NOT NULL default '0' AFTER date_debut;");
mysql_query("ALTER TABLE `".$prefix."_sommaire` ADD `days` varchar(8) default NULL  AFTER date_fin;");

mysql_query("ALTER TABLE `".$prefix."_sommaire_categories` ADD `sublevel` tinyint(3) NOT NULL default '0';");
mysql_query("ALTER TABLE `".$prefix."_sommaire_categories` ADD  `date_debut` bigint(20) unsigned NOT NULL default '0';");
mysql_query("ALTER TABLE `".$prefix."_sommaire_categories` ADD  `date_fin` bigint(20) unsigned NOT NULL default '0';");
mysql_query("ALTER TABLE `".$prefix."_sommaire_categories` ADD  `days` varchar(8) default NULL;");

echo"<center>All new tables have been added!!.<br><br>";
echo"<center>PNC 3.0.1 has a new version of the shoutbox.<br>
	All old shoutbox table will be deleted.<br><a href=\"$PHP_SELF?step=4\">Run now!!!</a><br>If you already updated your shoutbox, nothing will be changed...</center>";

}
// shoutbox
if($step == 4){

// delete previous tables:
	if (!mysql_table_exists("".$prefix."_shoutbox")) {
   	echo"Tabel <b>".$prefix."_shoutbox</b> does not exist, that's ok :)<br>";} 
	else{mysql_query("DROP TABLE ".$prefix."_shoutbox") or die('MySQL said: '.mysql_error());
	echo"Table <b>".$prefix."_shoutbox</b> is deleted<br>";}
	//######	
	if (!mysql_table_exists("".$prefix."_shoutbox_censor")) {
   	echo"Tabel <b>".$prefix."_shoutbox_censor</b> does not exist, that's ok :)<br>";} 
	else{mysql_query("DROP TABLE ".$prefix."_shoutbox_censor") or die('MySQL said: '.mysql_error());
	echo"Table <b>".$prefix."_shoutbox_censor</b> is deleted<br>";}
	//######	
	if (!mysql_table_exists("".$prefix."_shoutbox_conf")) {
   	echo"Tabel <b>".$prefix."_shoutbox_conf</b> does not exist, that's ok :)<br>";} 
	else{mysql_query("DROP TABLE ".$prefix."_shoutbox_conf") or die('MySQL said: '.mysql_error());
	echo"Table <b>".$prefix."_shoutbox_conf</b> is deleted<br>";}
	//######	
	if (!mysql_table_exists("".$prefix."_shoutbox_date")) {
   	echo"Tabel <b>".$prefix."_shoutbox_date</b> does not exist, that's ok :)<br>";} 
	else{mysql_query("DROP TABLE ".$prefix."_shoutbox_date") or die('MySQL said: '.mysql_error());
	echo"Table <b>".$prefix."_shoutbox_date</b> is deleted<br>";}
	//######	
	if (!mysql_table_exists("".$prefix."_shoutbox_emoticons")) {
   	echo"Tabel <b>".$prefix."_shoutbox_emoticons</b> does not exist, that's ok :)<br>";} 
	else{mysql_query("DROP TABLE ".$prefix."_shoutbox_emoticons") or die('MySQL said: '.mysql_error());
	echo"Table <b>".$prefix."_shoutbox_emoticons</b> is deleted<br>";}
	//######	
	if (!mysql_table_exists("".$prefix."_shoutbox_ipblock")) {
   	echo"Tabel <b>".$prefix."_shoutbox_ipblock</b> does not exist, that's ok :)<br>";} 
	else{mysql_query("DROP TABLE ".$prefix."_shoutbox_ipblock") or die('MySQL said: '.mysql_error());
	echo"Table <b>".$prefix."_shoutbox_ipblock</b> is deleted<br>";}
	//######	
	if (!mysql_table_exists("".$prefix."_shoutbox_nameblock")) {
   	echo"Tabel <b>".$prefix."_shoutbox_nameblock</b> does not exist, that's ok :)<br>";} 
	else{mysql_query("DROP TABLE ".$prefix."_shoutbox_nameblock") or die('MySQL said: '.mysql_error());
	echo"Table <b>".$prefix."_shoutbox_nameblock</b> is deleted<br>";}
	//######	
	if (!mysql_table_exists("".$prefix."_shoutbox_sticky")) {
   	echo"Tabel <b>".$prefix."_shoutbox_sticky</b> does not exist, that's ok :)<br>";} 
	else{mysql_query("DROP TABLE ".$prefix."_shoutbox_sticky") or die('MySQL said: '.mysql_error());
	echo"Table <b>".$prefix."_shoutbox_sticky</b> is deleted<br>";}
	//######	
	if (!mysql_table_exists("".$prefix."_shoutbox_theme_images")) {
   	echo"Tabel <b>".$prefix."_shoutbox_theme_images</b> does not exist, that's ok :)<br>";} 
	else{mysql_query("DROP TABLE ".$prefix."_shoutbox_theme_images") or die('MySQL said: '.mysql_error());
	echo"Table <b>".$prefix."_shoutbox_theme_images</b> is deleted<br>";}
	//######	
	if (!mysql_table_exists("".$prefix."_shoutbox_themes")) {
   	echo"Tabel <b>".$prefix."_shoutbox_themes</b> does not exist, that's ok :)<br>";} 
	else{mysql_query("DROP TABLE ".$prefix."_shoutbox_themes") or die('MySQL said: '.mysql_error());
	echo"Table <b>".$prefix."_shoutbox_themes</b> is deleted<br>";}
	//######	
	if (!mysql_table_exists("".$prefix."_shoutbox_version")) {
   	echo"Tabel <b>".$prefix."_shoutbox_version</b> does not exist, that's ok :)<br>";} 
	else{mysql_query("DROP TABLE ".$prefix."_shoutbox_version") or die('MySQL said: '.mysql_error());
	echo"Table <b>".$prefix."_shoutbox_version</b> is deleted<br>";}
//end delete tables

mysql_query("CREATE TABLE `".$prefix."_shoutbox_censor` (
  `id` int(9) NOT NULL auto_increment,
  `text` varchar(30) NOT NULL default '',
  `replacement` varchar(30) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=140 ;");

// 
// Dumping data for table `".$prefix."_shoutbox_censor`
// 

mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (1, '@$$', 'butt');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (2, 'a$$', 'butt');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (3, 'anton', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (4, 'arse', 'butt');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (5, 'arsehole', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (6, 'ass', 'butt');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (7, 'ass muncher', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (8, 'asshole', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (9, 'asstooling', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (10, 'asswipe', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (11, 'b!tch', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (12, 'b17ch', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (13, 'b1tch', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (14, 'bastard', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (15, 'beefcurtins', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (16, 'bi7ch', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (17, 'bitch', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (18, 'bitchy', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (19, 'boiolas', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (20, 'bollocks', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (21, 'breasts', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (22, 'brown nose', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (23, 'bugger', 'damn');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (24, 'butt pirate', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (25, 'c0ck', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (26, 'cawk', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (27, 'chink', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (28, 'clitsaq', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (29, 'cock', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (30, 'cockbite', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (31, 'cockgobbler', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (32, 'cocksucker', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (33, 'cum', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (34, 'cunt', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (35, 'dago', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (36, 'daygo', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (37, 'dego', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (38, 'dick', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (39, 'dick wad', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (40, 'dickhead', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (41, 'dickweed', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (42, 'douchebag', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (43, 'dziwka', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (44, 'ekto', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (45, 'enculer', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (46, 'faen', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (47, 'fag', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (48, 'faggot', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (49, 'fart', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (50, 'fatass', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (51, 'feg', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (52, 'felch', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (53, 'ficken', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (54, 'fitta', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (55, 'fitte', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (56, 'flikker', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (57, 'fok', '$#%!');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (58, 'fuck', '$#%!');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (59, 'fu(k', '$#%!');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (60, 'fucker', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (61, 'fucking', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (62, 'fuckwit', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (63, 'fuk', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (64, 'fuking', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (65, 'futkretzn', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (66, 'fux0r', '$#%!');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (67, 'gook', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (68, 'h0r', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (69, 'handjob', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (70, 'helvete', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (71, 'honkey', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (72, 'hore', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (73, 'hump', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (74, 'injun', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (75, 'kawk', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (76, 'kike', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (77, 'knulle', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (78, 'kraut', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (79, 'kuk', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (80, 'kuksuger', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (81, 'kurac', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (82, 'kurwa', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (83, 'langer', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (84, 'masturbation', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (85, 'merd', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (86, 'motherfucker', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (87, 'motherfuckingcocksucker', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (88, 'mutherfucker', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (89, 'nepesaurio', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (90, 'nigga', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (91, 'nigger', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (92, 'nonce', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (93, 'nutsack', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (94, 'one-eyed-trouser-snake', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (95, 'penis', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (96, 'picka', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (97, 'pissant', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (98, 'pizda', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (99, 'politician', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (100, 'prick', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (101, 'puckface', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (102, 'pule', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (103, 'pussy', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (104, 'puta', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (105, 'puto', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (106, 'rimjob', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (107, 'rubber', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (108, 'scheisse', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (109, 'schlampe', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (110, 'schlong', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (111, 'screw', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (112, 'shit', '****');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (113, 'shiteater', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (114, 'shiz', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (115, 'skribz', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (116, 'skurwysyn', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (117, 'slut', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (118, 'spermburper', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (119, 'spic', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (120, 'spierdalaj', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (121, 'splooge', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (122, 'spunk', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (123, 'tatas', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (124, 'tits', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (125, 'toss the salad', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (126, 'twat', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (127, 'unclefucker', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (128, 'vagina', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (129, 'vittu', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (130, 'votze', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (131, 'wank', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (132, 'wanka', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (133, 'wanker', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (134, 'wankers', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (135, 'wankstain', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (136, 'whore', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (137, 'wichser', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (138, 'wop', '[censored]');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_censor` VALUES (139, 'yed', '[censored]');");



// 
// Table structure for table `".$prefix."_shoutbox_conf`
// 

mysql_query("CREATE TABLE `".$prefix."_shoutbox_conf` (
  `id` int(9) NOT NULL default '0',
  `color1` varchar(20) NOT NULL default '',
  `color2` varchar(20) NOT NULL default '',
  `date` varchar(5) NOT NULL default '',
  `time` varchar(5) NOT NULL default '',
  `number` varchar(5) NOT NULL default '',
  `ipblock` varchar(5) NOT NULL default '',
  `nameblock` varchar(5) NOT NULL default '',
  `censor` varchar(5) NOT NULL default '',
  `tablewidth` char(3) NOT NULL default '',
  `urlonoff` varchar(5) NOT NULL default '',
  `delyourlastpost` varchar(5) NOT NULL default '',
  `anonymouspost` varchar(5) NOT NULL default '',
  `height` varchar(5) NOT NULL default '',
  `themecolors` varchar(5) NOT NULL default '',
  `textWidth` varchar(4) NOT NULL default '',
  `nameWidth` varchar(4) NOT NULL default '',
  `smiliesPerRow` varchar(4) NOT NULL default '',
  `reversePosts` varchar(4) NOT NULL default '',
  `timeOffset` varchar(10) NOT NULL default '',
  `urlanononoff` varchar(10) NOT NULL default '',
  `pointspershout` varchar(5) NOT NULL default '',
  `shoutsperpage` varchar(5) NOT NULL default '',
  `serverTimezone` varchar(5) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;");

// 
// Dumping data for table `".$prefix."_shoutbox_conf`
// 

mysql_query("INSERT INTO `".$prefix."_shoutbox_conf` VALUES (1, '#EBEBEB', '#FFFFFF', 'yes', 'yes', '10', 'yes', 'yes', 'yes', '150', 'yes', 'yes', 'yes', '150', 'no', '20', '10', '7', 'no', '0', 'no', '0', '25', '-6');");



// 
// Table structure for table `".$prefix."_shoutbox_date`
// 

mysql_query("CREATE TABLE `".$prefix."_shoutbox_date` (
  `id` int(5) NOT NULL default '0',
  `date` varchar(10) NOT NULL default '',
  `time` varchar(10) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;");

// 
// Dumping data for table `".$prefix."_shoutbox_date`
// 

mysql_query("INSERT INTO `".$prefix."_shoutbox_date` VALUES (1, 'd-m-Y', 'g:i:a');");



// 
// Table structure for table `".$prefix."_shoutbox_emoticons`
// 

mysql_query("CREATE TABLE `".$prefix."_shoutbox_emoticons` (
  `id` int(9) NOT NULL auto_increment,
  `text` varchar(20) NOT NULL default '',
  `image` varchar(70) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=45 ;");

// 
// Dumping data for table `".$prefix."_shoutbox_emoticons`
// 

mysql_query("INSERT INTO `".$prefix."_shoutbox_emoticons` VALUES (1, ':confused:', '<img src=images/blocks/shout_box/confused.gif>');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_emoticons` VALUES (2, ':sigh:', '<img src=images/blocks/shout_box/sigh.gif>');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_emoticons` VALUES (3, ':sleep:', '<img src=images/blocks/shout_box/sleep.gif>');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_emoticons` VALUES (4, ':upset:', '<img src=images/blocks/shout_box/upset.gif>');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_emoticons` VALUES (5, ':none:', '<img src=images/blocks/shout_box/none.gif>');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_emoticons` VALUES (6, ':eek:', '<img src=images/blocks/shout_box/bigeek.gif>');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_emoticons` VALUES (7, ':rolleyes:', '<img src=images/blocks/shout_box/rolleyes.gif>');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_emoticons` VALUES (8, ':mad:', '<img src=images/blocks/shout_box/mad.gif>');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_emoticons` VALUES (9, ':yes:', '<img src=images/blocks/shout_box/yes.gif>');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_emoticons` VALUES (10, ':no:', '<img src=images/blocks/shout_box/no.gif>');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_emoticons` VALUES (11, ':shy:', '<img src=images/blocks/shout_box/shy.gif>');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_emoticons` VALUES (12, ':laugh:', '<img src=images/blocks/shout_box/laugh.gif>');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_emoticons` VALUES (13, ':dead:', '<img src=images/blocks/shout_box/dead.gif>');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_emoticons` VALUES (14, ':cry:', '<img src=images/blocks/shout_box/cry.gif>');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_emoticons` VALUES (15, ':)', '<img src=images/blocks/shout_box/smile.gif>');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_emoticons` VALUES (16, ':(', '<img src=images/blocks/shout_box/sad.gif>');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_emoticons` VALUES (17, ';)', '<img src=images/blocks/shout_box/smilewinkgrin.gif>');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_emoticons` VALUES (18, ':|', '<img src=images/blocks/shout_box/none.gif>');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_emoticons` VALUES (19, ':-)', '<img src=images/blocks/shout_box/smile.gif>');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_emoticons` VALUES (20, ':-(', '<img src=images/blocks/shout_box/sad.gif>');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_emoticons` VALUES (21, ';-)', '<img src=images/blocks/shout_box/smilewinkgrin.gif>');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_emoticons` VALUES (22, ':-|', '<img src=images/blocks/shout_box/none.gif>');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_emoticons` VALUES (23, ':0', '<img src=images/blocks/shout_box/bigeek.gif>');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_emoticons` VALUES (24, 'B)', '<img src=images/blocks/shout_box/cool.gif>');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_emoticons` VALUES (25, ':D', '<img src=images/blocks/shout_box/biggrin.gif>');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_emoticons` VALUES (26, ':P', '<img src=images/blocks/shout_box/bigrazz.gif>');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_emoticons` VALUES (27, ':B', '<img src=images/blocks/shout_box/bigrazz.gif>');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_emoticons` VALUES (28, 'B-)', '<img src=images/blocks/shout_box/cool.gif>');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_emoticons` VALUES (29, ':-D', '<img src=images/blocks/shout_box/biggrin.gif>');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_emoticons` VALUES (30, ':-P', '<img src=images/blocks/shout_box/bigrazz.gif>');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_emoticons` VALUES (31, ':O', '<img src=images/blocks/shout_box/bigeek.gif>');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_emoticons` VALUES (32, 'b)', '<img src=images/blocks/shout_box/cool.gif>');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_emoticons` VALUES (33, ':d', '<img src=images/blocks/shout_box/biggrin.gif>');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_emoticons` VALUES (34, ':p', '<img src=images/blocks/shout_box/bigrazz.gif>');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_emoticons` VALUES (35, ':b', '<img src=images/blocks/shout_box/bigrazz.gif>');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_emoticons` VALUES (36, 'b-)', '<img src=images/blocks/shout_box/cool.gif>');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_emoticons` VALUES (37, ':-d', '<img src=images/blocks/shout_box/biggrin.gif>');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_emoticons` VALUES (38, ':-p', '<img src=images/blocks/shout_box/bigrazz.gif>');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_emoticons` VALUES (39, ':-b', '<img src=images/blocks/shout_box/bigrazz.gif>');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_emoticons` VALUES (40, ':o', '<img src=images/blocks/shout_box/bigeek.gif>');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_emoticons` VALUES (41, 'o_O', '<img src=images/blocks/shout_box/bigeek.gif>');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_emoticons` VALUES (42, 'O_o', '<img src=images/blocks/shout_box/bigeek.gif>');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_emoticons` VALUES (43, 'o_o', '<img src=images/blocks/shout_box/bigeek.gif>');");
mysql_query("INSERT INTO `".$prefix."_shoutbox_emoticons` VALUES (44, 'O_O', '<img src=images/blocks/shout_box/bigeek.gif>');");



// 
// Table structure for table `".$prefix."_shoutbox_ipblock`
// 

mysql_query("CREATE TABLE `".$prefix."_shoutbox_ipblock` (
  `id` int(9) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;");

// 
// Dumping data for table `".$prefix."_shoutbox_ipblock`
//

// 
// Table structure for table `".$prefix."_shoutbox_manage_count`
// 

mysql_query("CREATE TABLE `".$prefix."_shoutbox_manage_count` (
  `id` int(9) NOT NULL auto_increment,
  `admin` varchar(25) NOT NULL default '',
  `aCount` varchar(5) NOT NULL default '10',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=2 ;");

// 
// Dumping data for table `".$prefix."_shoutbox_manage_count`
// 

mysql_query("INSERT INTO `".$prefix."_shoutbox_manage_count` VALUES (1, 'Ghostspirit', '10');");



// 
// Table structure for table `".$prefix."_shoutbox_nameblock`
// 

mysql_query("CREATE TABLE `".$prefix."_shoutbox_nameblock` (
  `id` int(9) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;");

// 
// Dumping data for table `".$prefix."_shoutbox_nameblock`
//

// 
// Table structure for table `".$prefix."_shoutbox_shouts`
// 

mysql_query("CREATE TABLE `".$prefix."_shoutbox_shouts` (
  `id` int(9) NOT NULL auto_increment,
  `name` varchar(20) NOT NULL default '',
  `comment` text NOT NULL,
  `date` varchar(10) NOT NULL default '',
  `time` varchar(10) NOT NULL default '',
  `ip` varchar(39) default NULL,
  `timestamp` varchar(20) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;");

// 
// Dumping data for table `".$prefix."_shoutbox_shouts`
// 




// 
// Table structure for table `".$prefix."_shoutbox_sticky`
// 

mysql_query("CREATE TABLE `".$prefix."_shoutbox_sticky` (
  `id` int(9) NOT NULL auto_increment,
  `name` varchar(20) NOT NULL default '',
  `comment` text NOT NULL,
  `timestamp` varchar(20) NOT NULL default '',
  `stickySlot` varchar(5) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;");

// 
// Dumping data for table `".$prefix."_shoutbox_sticky`
//

// 
// Table structure for table `".$prefix."_shoutbox_theme_images`
// 

mysql_query("CREATE TABLE `".$prefix."_shoutbox_theme_images` (
  `id` int(9) NOT NULL auto_increment,
  `themeName` varchar(50) default NULL,
  `blockArrowColor` varchar(50) NOT NULL default '',
  `blockBackgroundImage` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=2 ;");

// 
// Dumping data for table `".$prefix."_shoutbox_theme_images`
// 

mysql_query("INSERT INTO `".$prefix."_shoutbox_theme_images` VALUES (1, 'Phoenix', 'Black.gif', 'BlueLCD.jpg');");



// 
// Table structure for table `".$prefix."_shoutbox_themes`
// 

mysql_query("CREATE TABLE `".$prefix."_shoutbox_themes` (
  `id` int(9) NOT NULL auto_increment,
  `themeName` varchar(50) default NULL,
  `blockColor1` varchar(20) default NULL,
  `blockColor2` varchar(20) default NULL,
  `border` varchar(20) default NULL,
  `menuColor1` varchar(20) default NULL,
  `menuColor2` varchar(20) default NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=2 ;");

// 
// Dumping data for table `".$prefix."_shoutbox_themes`
// 

mysql_query("INSERT INTO `".$prefix."_shoutbox_themes` VALUES (1, 'Phoenix', '#EBEBEB', '#FFFFFF', '#000000', '#6D6D6D', '#A4A4A4');");



// 
// Table structure for table `".$prefix."_shoutbox_version`
// 

mysql_query("CREATE TABLE `".$prefix."_shoutbox_version` (
  `id` int(5) NOT NULL default '0',
  `version` varchar(10) NOT NULL default '',
  `datechecked` char(2) NOT NULL default '',
  `versionreported` varchar(10) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;");

// 
// Dumping data for table `".$prefix."_shoutbox_version`
// 

mysql_query("INSERT INTO `".$prefix."_shoutbox_version` VALUES (1, '8.0', '0', '0');");




// 
// Dumping data for table `".$prefix."_shoutbox_version`
// 

mysql_query("INSERT INTO `".$prefix."_shoutbox_version` VALUES (1, '8.0', '0', '0');");
echo"<center>PNC 3.0.1 has Sentinel pre-installed.<br>
	<br><a href=\"$PHP_SELF?step=5\">Install Sentinel NOW!!</a><br></center>";
}
// shoutbox
if($step == 5 ){
//################################### Sentinel #####################################
//Start Sentinel

mysql_query("CREATE TABLE `".$prefix."_nsnst_admins` (
  `aid` varchar(25) NOT NULL default '',
  `login` varchar(25) NOT NULL default '',
  `password` varchar(40) NOT NULL default '',
  `password_md5` varchar(60) NOT NULL default '',
  `password_crypt` varchar(60) NOT NULL default '',
  `protected` tinyint(2) NOT NULL default '0',
  PRIMARY KEY  (`aid`)
) ENGINE=MyISAM;");

//INSERT INTO `".$prefix."_nsnst_admins` VALUES ('XenoMorpH', 'XenoMorpH', '', '', '', 1);

mysql_query("CREATE TABLE `".$prefix."_nsnst_blocked_ips` (
  `ip_addr` varchar(15) NOT NULL default '',
  `user_id` int(11) NOT NULL default '1',
  `username` varchar(60) NOT NULL default '',
  `user_agent` text NOT NULL,
  `date` int(20) NOT NULL default '0',
  `notes` text NOT NULL,
  `reason` tinyint(1) NOT NULL default '0',
  `query_string` text NOT NULL,
  `get_string` text NOT NULL,
  `post_string` text NOT NULL,
  `x_forward_for` varchar(32) NOT NULL default '',
  `client_ip` varchar(32) NOT NULL default '',
  `remote_addr` varchar(32) NOT NULL default '',
  `remote_port` varchar(11) NOT NULL default '',
  `request_method` varchar(10) NOT NULL default '',
  `expires` int(20) NOT NULL default '0',
  `c2c` char(2) NOT NULL default '00',
  PRIMARY KEY  (`ip_addr`),
  KEY `c2c` (`c2c`),
  KEY `date` (`date`),
  KEY `expires` (`expires`),
  KEY `reason` (`reason`)
) ENGINE=MyISAM;");


mysql_query("CREATE TABLE `".$prefix."_nsnst_blocked_ranges` (
  `ip_lo` int(10) unsigned NOT NULL default '0',
  `ip_hi` int(10) unsigned NOT NULL default '0',
  `date` int(20) NOT NULL default '0',
  `notes` text NOT NULL,
  `reason` tinyint(1) NOT NULL default '0',
  `expires` int(20) NOT NULL default '0',
  `c2c` char(2) NOT NULL default '00',
  PRIMARY KEY  (`ip_lo`,`ip_hi`),
  KEY `c2c` (`c2c`),
  KEY `date` (`date`),
  KEY `expires` (`expires`),
  KEY `reason` (`reason`)
) ENGINE=MyISAM;");


mysql_query("CREATE TABLE `".$prefix."_nsnst_blockers` (
  `blocker` int(4) NOT NULL default '0',
  `block_name` varchar(20) NOT NULL default '',
  `activate` int(4) NOT NULL default '0',
  `block_type` int(4) NOT NULL default '0',
  `email_lookup` int(4) NOT NULL default '0',
  `forward` varchar(255) NOT NULL default '',
  `reason` varchar(20) NOT NULL default '',
  `template` varchar(255) NOT NULL default '',
  `duration` int(20) NOT NULL default '0',
  `htaccess` int(4) NOT NULL default '0',
  `list` longtext NOT NULL,
  PRIMARY KEY  (`blocker`)
) ENGINE=MyISAM;");


mysql_query("INSERT INTO `".$prefix."_nsnst_blockers` VALUES (0, 'other', 0, 0, 0, '', 'Abuse-Other', 'abuse_default.tpl', 0, 0, '');");
mysql_query("INSERT INTO `".$prefix."_nsnst_blockers` VALUES (1, 'union', 1, 0, 0, '', 'Abuse-Union', 'abuse_union.tpl', 0, 0, '');");
mysql_query("INSERT INTO `".$prefix."_nsnst_blockers` VALUES (2, 'clike', 1, 0, 0, '', 'Abuse-CLike', 'abuse_clike.tpl', 0, 0, '');");
mysql_query("INSERT INTO `".$prefix."_nsnst_blockers` VALUES (3, 'harvester', 0, 0, 0, '', 'Abuse-Harvest', 'abuse_harvester.tpl', 0, 0, '@yahoo.com\r\nalexibot\r\nalligator\r\nanonymiz\r\nasterias\r\nbackdoorbot\r\nblack hole\r\nblackwidow\r\nblowfish\r\nbotalot\r\nbuiltbottough\r\nbullseye\r\nbunnyslippers\r\ncatch\r\ncegbfeieh\r\ncharon\r\ncheesebot\r\ncherrypicker\r\nchinaclaw\r\ncombine\r\ncopyrightcheck\r\ncosmos\r\ncrescent\r\ncurl\r\ndbrowse\r\ndisco\r\ndittospyder\r\ndlman\r\ndnloadmage\r\ndownload\r\ndreampassport\r\ndts agent\r\necatch\r\neirgrabber\r\nerocrawler\r\nexpress webpictures\r\nextractorpro\r\neyenetie\r\nfantombrowser\r\nfantomcrew browser\r\nfileheap\r\nfilehound\r\nflashget\r\nfoobot\r\nfranklin locator\r\nfreshdownload\r\nfscrawler\r\ngamespy_arcade\r\ngetbot\r\ngetright\r\ngetweb\r\ngo!zilla\r\ngo-ahead-got-it\r\ngrab\r\ngrafula\r\ngsa-crawler\r\nharvest\r\nhloader\r\nhmview\r\nhttplib\r\nhttpresume\r\nhttrack\r\nhumanlinks\r\nigetter\r\nimage stripper\r\nimage sucker\r\nindustry program\r\nindy library\r\ninfonavirobot\r\ninstallshield digitalwizard\r\ninterget\r\niria\r\nirvine\r\niupui research bot\r\njbh agent\r\njennybot\r\njetcar\r\njobo\r\njoc\r\nkapere\r\nkenjin spider\r\nkeyword density\r\nlarbin\r\nleechftp\r\nleechget\r\nlexibot\r\nlibweb/clshttp\r\nlibwww-perl\r\nlightningdownload\r\nlincoln state web browser\r\nlinkextractorpro\r\nlinkscan/8.1a.unix\r\nlinkwalker\r\nlwp-trivial\r\nlwp::simple\r\nmac finder\r\nmata hari\r\nmediasearch\r\nmetaproducts\r\nmicrosoft url control\r\nmidown tool\r\nmiixpc\r\nmissauga locate\r\nmissouri college browse\r\nmister pix\r\nmoget\r\nmozilla.*newt\r\nmozilla/3.0 (compatible)\r\nmozilla/3.mozilla/2.01\r\nmsie 4.0 (win95)\r\nmultiblocker browser\r\nmydaemon\r\nmygetright\r\nnabot\r\nnavroad\r\nnearsite\r\nnet vampire\r\nnetants\r\nnetmechanic\r\nnetpumper\r\nnetspider\r\nnewsearchengine\r\nnicerspro\r\nninja\r\nnitro downloader\r\nnpbot\r\noctopus\r\noffline explorer\r\noffline navigator\r\nopenfind\r\npagegrabber\r\npapa foto\r\npavuk\r\npbrowse\r\npcbrowser\r\npeval\r\npompos/\r\nprogram shareware\r\npropowerbot\r\nprowebwalker\r\npsurf\r\npuf\r\npuxarapido\r\nqueryn metasearch\r\nrealdownload\r\nreget\r\nrepomonkey\r\nrsurf\r\nrumours-agent\r\nsakura\r\nscan4mail\r\nsemanticdiscovery\r\nsitesnagger\r\nslysearch\r\nspankbot\r\nspanner \r\nspiderzilla\r\nsq webscanner\r\nstamina\r\nstar downloader\r\nsteeler\r\nsteeler\r\nstrip\r\nsuperbot\r\nsuperhttp\r\nsurfbot\r\nsuzuran\r\nswbot\r\nszukacz\r\ntakeout\r\nteleport\r\ntelesoft\r\ntest spider\r\nthe intraformant\r\nthenomad\r\ntighttwatbot\r\ntitan\r\ntocrawl/urldispatcher\r\ntrue_robot\r\ntsurf\r\nturing machine\r\nturingos\r\nurlblaze\r\nurlgetfile\r\nurly warning\r\nutilmind\r\nvci\r\nvoideye\r\nweb image collector\r\nweb sucker\r\nwebauto\r\nwebbandit\r\nwebcapture\r\nwebcollage\r\nwebcopier\r\nwebenhancer\r\nwebfetch\r\nwebgo\r\nwebleacher\r\nwebmasterworldforumbot\r\nwebql\r\nwebreaper\r\nwebsite extractor\r\nwebsite quester\r\nwebster\r\nwebstripper\r\nwebwhacker\r\nwep search\r\nwget\r\nwhizbang\r\nwidow\r\nwildsoft surfer\r\nwww-collector-e\r\nwww.netwu.com\r\nwwwoffle\r\nxaldon\r\nxenu\r\nzeus\r\nziggy\r\nzippy');");
mysql_query("INSERT INTO `".$prefix."_nsnst_blockers` VALUES (4, 'script', 1, 0, 0, '', 'Abuse-Script', 'abuse_script.tpl', 0, 0, '');");
mysql_query("INSERT INTO `".$prefix."_nsnst_blockers` VALUES (5, 'author', 1, 0, 0, '', 'Abuse-Author', 'abuse_author.tpl', 0, 0, '');");
mysql_query("INSERT INTO `".$prefix."_nsnst_blockers` VALUES (6, 'referer', 0, 0, 0, '', 'Abuse-Referer', 'abuse_referer.tpl', 0, 0, '121hr.com\r\n1st-call.net\r\n1stcool.com\r\n5000n.com\r\n69-xxx.com\r\n9irl.com\r\n9uy.com\r\na-day-at-the-party.com\r\naccessthepeace.com\r\nadult-model-nude-pictures.com\r\nadult-sex-toys-free-porn.com\r\nagnitum.com\r\nalfonssackpfeiffe.com\r\nalongwayfrommars.com\r\nanime-sex-1.com\r\nanorex-sf-stimulant-free.com\r\nantibot.net\r\nantique-tokiwa.com\r\napotheke-heute.com\r\narmada31.com\r\nartark.com\r\nartlilei.com\r\nascendbtg.com\r\naschalaecheck.com\r\nasian-sex-free-sex.com\r\naslowspeeker.com\r\nassasinatedfrogs.com\r\nathirst-for-tranquillity.net\r\naubonpanier.com\r\navalonumc.com\r\nayingba.com\r\nbayofnoreturn.com\r\nbbw4phonesex.com\r\nbeersarenotfree.com\r\nbierikiuetsch.com\r\nbilingualannouncements.com\r\nblack-pussy-toon-clip-anal-lover-single.com\r\nblownapart.com\r\nblueroutes.com\r\nboasex.com\r\nbooksandpages.com\r\nbootyquake.com\r\nbossyhunter.com\r\nboyz-sex.com\r\nbrokersaandpokers.com\r\nbrowserwindowcleaner.com\r\nbudobytes.com\r\nbusiness2fun.com\r\nbuymyshitz.com\r\nbyuntaesex.com\r\ncaniputsomeloveintoyou.com\r\ncartoons.net.ru\r\ncaverunsailing.com\r\ncertainhealth.com\r\nclantea.com\r\nclose-protection-services.com\r\nclubcanino.com\r\nclubstic.com\r\ncobrakai-skf.com\r\ncollegefucktour.co.uk\r\ncommanderspank.com\r\ncoolenabled.com\r\ncrusecountryart.com\r\ncrusingforsex.co.uk\r\ncunt-twat-pussy-juice-clit-licking.com\r\ncustomerhandshaker.com\r\ncyborgrama.com\r\ndarkprofits.co.uk\r\ndatingforme.co.uk\r\ndatingmind.com\r\ndegree.org.ru\r\ndelorentos.com\r\ndiggydigger.com\r\ndinkydonkyaussie.com\r\ndjpritchard.com\r\ndjtop.com\r\ndraufgeschissen.com\r\ndreamerteens.co.uk\r\nebonyarchives.co.uk\r\nebonyplaya.co.uk\r\necobuilder2000.com\r\nemailandemail.com\r\nemedici.net\r\nengine-on-fire.com\r\nerocity.co.uk\r\nesport3.com\r\neteenbabes.com\r\neurofreepages.com\r\neurotexans.com\r\nevolucionweb.com\r\nfakoli.com\r\nfe4ba.com\r\nferienschweden.com\r\nfindly.com\r\nfirsttimeteadrinker.com\r\nfishing.net.ru\r\nflatwonkers.com\r\nflowershopentertainment.com\r\nflymario.com\r\nfree-xxx-pictures-porno-gallery.com\r\nfreebestporn.com\r\nfreefuckingmovies.co.uk\r\nfreexxxstuff.co.uk\r\nfruitologist.net\r\nfruitsandbolts.com\r\nfuck-cumshots-free-midget-movie-clips.com\r\nfuck-michaelmoore.com\r\nfundacep.com\r\ngadless.com\r\ngallapagosrangers.com\r\ngalleries4free.co.uk\r\ngalofu.com\r\ngaypixpost.co.uk\r\ngeomasti.com\r\ngirltime.co.uk\r\nglassrope.com\r\ngodjustblessyouall.com\r\ngoldenageresort.com\r\ngonnabedaddies.com\r\ngranadasexi.com\r\ngranadasexi.com\r\nguardingtheangels.com\r\nguyprofiles.co.uk\r\nhappy1225.com\r\nhappychappywacky.com\r\nhealth.org.ru\r\nhexplas.com\r\nhighheelsmodels4fun.com\r\nhillsweb.com\r\nhiptuner.com\r\nhistoryintospace.com\r\nhoa-tuoi.com\r\nhomebuyinginatlanta.com\r\nhorizonultra.com\r\nhorseminiature.net\r\nhotkiss.co.uk\r\nhotlivegirls.co.uk\r\nhotmatchup.co.uk\r\nhusler.co.uk\r\niaentertainment.com\r\niamnotsomeone.com\r\niconsofcorruption.com\r\nihavenotrustinyou.com\r\ninformat-systems.com\r\ninteriorproshop.com\r\nintersoftnetworks.com\r\ninthecrib.com\r\ninvestment4cashiers.com\r\niti-trailers.com\r\njackpot-hacker.com\r\njacks-world.com\r\njamesthesailorbasher.com\r\njesuislemonds.com\r\njustanotherdomainname.com\r\nkampelicka.com\r\nkanalrattenarsch.com\r\nkatzasher.com\r\nkerosinjunkie.com\r\nkillasvideo.com\r\nkoenigspisser.com\r\nkontorpara.com\r\nl8t.com\r\nlaestacion101.com\r\nlambuschlamppen.com\r\nlankasex.co.uk\r\nlaser-creations.com\r\nle-tour-du-monde.com\r\nlecraft.com\r\nledo-design.com\r\nleftregistration.com\r\nlekkikoomastas.com\r\nlepommeau.com\r\nlibr-animal.com\r\nlibraries.org.ru\r\nlikewaterlikewind.com\r\nlimbojumpers.com\r\nlink.ru\r\nlockportlinks.com\r\nloiproject.com\r\nlongtermalternatives.com\r\nlottoeco.com\r\nlucalozzi.com\r\nmaki-e-pens.com\r\nmalepayperview.co.uk\r\nmangaxoxo.com\r\nmaps.org.ru\r\nmarcofields.com\r\nmasterofcheese.com\r\nmasteroftheblasterhill.com\r\nmastheadwankers.com\r\nmegafrontier.com\r\nmeinschuppen.com\r\nmercurybar.com\r\nmetapannas.com\r\nmicelebre.com\r\nmidnightlaundries.com\r\nmikeapartment.co.uk\r\nmillenniumchorus.com\r\nmimundial2002.com\r\nminiaturegallerymm.com\r\nmixtaperadio.com\r\nmondialcoral.com\r\nmonja-wakamatsu.com\r\nmonstermonkey.net\r\nmouthfreshners.com\r\nmullensholiday.com\r\nmusilo.com\r\nmyhollowlog.com\r\nmyhomephonenumber.com\r\nmykeyboardisbroken.com\r\nmysofia.net\r\nnaked-cheaters.com\r\nnaked-old-women.com\r\nnastygirls.co.uk\r\nnationclan.net\r\nnatterratter.com\r\nnaughtyadam.com\r\nnestbeschmutzer.com\r\nnetwu.com\r\nnewrealeaseonline.com\r\nnewrealeasesonline.com\r\nnextfrontiersonline.com\r\nnikostaxi.com\r\nnotorious7.com\r\nnrecruiter.com\r\nnursingdepot.com\r\nnustramosse.com\r\nnuturalhicks.com\r\noccaz-auto49.com\r\nocean-db.net\r\noilburnerservice.net\r\nomburo.com\r\noneoz.com\r\nonepageahead.net\r\nonlinewithaline.com\r\norganizate.net\r\nourownweddingsong.com\r\nowen-music.com\r\np-partners.com\r\npaginadeautor.com\r\npakistandutyfree.com\r\npamanderson.co.uk\r\nparentsense.net\r\nparticlewave.net\r\npay-clic.com\r\npay4link.net\r\npcisp.com\r\npersist-pharma.com\r\npeteband.com\r\npetplusindia.com\r\npickabbw.co.uk\r\npicture-oral-position-lesbian.com\r\npl8again.com\r\nplaneting.net\r\npopusky.com\r\nporn-expert.com\r\npromoblitza.com\r\nproproducts-usa.com\r\nptcgzone.com\r\nptporn.com\r\npublishmybong.com\r\nputtingtogether.com\r\nqualifiedcancelations.com\r\nrahost.com\r\nrainbow21.com\r\nrakkashakka.com\r\nrandomfeeding.com\r\nrape-art.com\r\nrd-brains.com\r\nrealestateonthehill.net\r\nrebuscadobot\r\nrequested-stuff.com\r\nretrotrasher.com\r\nricopositive.com\r\nrisorseinrete.com\r\nrotatingcunts.com\r\nrunawayclicks.com\r\nrutalibre.com\r\ns-marche.com\r\nsabrosojazz.com\r\nsamuraidojo.com\r\nsanaldarbe.com\r\nsasseminars.com\r\nschlampenbruzzler.com\r\nsearchmybong.com\r\nseckur.com\r\nsex-asian-porn-interracial-photo.com\r\nsex-porn-fuck-hardcore-movie.com\r\nsexa3.net\r\nsexer.com\r\nsexintention.com\r\nsexnet24.tv\r\nsexomundo.com\r\nsharks.com.ru\r\nshells.com.ru\r\nshop-ecosafe.com\r\nshop-toon-hardcore-fuck-cum-pics.com\r\nsilverfussions.com\r\nsin-city-sex.net\r\nsluisvan.com\r\nsmutshots.com\r\nsnagglersmaggler.com\r\nsomethingtoforgetit.com\r\nsophiesplace.net\r\nsoursushi.com\r\nsouthernxstables.com\r\nspeed467.com\r\nspeedpal4you.com\r\nsporty.org.ru\r\nstopdriving.net\r\nstw.org.ru\r\nsufficientlife.com\r\nsussexboats.net\r\nswinger-party-free-dating-porn-sluts.com\r\nsydneyhay.com\r\nszmjht.com\r\nteninchtrout.com\r\nthebalancedfruits.com\r\ntheendofthesummit.com\r\nthiswillbeit.com\r\nthosethosethose.com\r\nticyclesofindia.com\r\ntits-gay-fagot-black-tits-bigtits-amateur.com\r\ntonius.com\r\ntoohsoft.com\r\ntoolvalley.com\r\ntooporno.net\r\ntoosexual.com\r\ntorngat.com\r\ntour.org.ru\r\ntowneluxury.com\r\ntrafficmogger.com\r\ntriacoach.net\r\ntrottinbob.com\r\ntttframes.com\r\ntvjukebox.net\r\nundercvr.com\r\nunfinished-desires.com\r\nunicornonero.com\r\nunionvillefire.com\r\nupsandowns.com\r\nupthehillanddown.com\r\nvallartavideo.com\r\nvietnamdatingservices.com\r\nvinegarlemonshots.com\r\nvizy.net.ru\r\nvnladiesdatingservices.com\r\nvomitandbusted.com\r\nwalkingthewalking.com\r\nwell-I-am-the-type-of-boy.com\r\nwhales.com.ru\r\nwhincer.net\r\nwhitpagesrippers.com\r\nwhois.sc\r\nwipperrippers.com\r\nwordfilebooklets.com\r\nworld-sexs.com\r\nxsay.com\r\nxxxchyangel.com\r\nxxxx:\r\nxxxzips.com\r\nyouarelostintransit.com\r\nyuppieslovestocks.com\r\nyuzhouhuagong.com\r\nzhaori-food.com\r\nzwiebelbacke.com');");
mysql_query("INSERT INTO `".$prefix."_nsnst_blockers` VALUES (7, 'filter', 1, 0, 0, '', 'Abuse-Filter', 'abuse_filter.tpl', 0, 0, '');");
mysql_query("INSERT INTO `".$prefix."_nsnst_blockers` VALUES (8, 'request', 0, 0, 0, '', 'Abuse-Request', 'abuse_request.tpl', 0, 0, '');");
mysql_query("INSERT INTO `".$prefix."_nsnst_blockers` VALUES (9, 'string', 0, 0, 0, '', 'Abuse-String', 'abuse_string.tpl', 0, 0, '');");
mysql_query("INSERT INTO `".$prefix."_nsnst_blockers` VALUES (10, 'admin', 1, 0, 0, '', 'Abuse-Admin', 'abuse_admin.tpl', 0, 0, '');");
mysql_query("INSERT INTO `".$prefix."_nsnst_blockers` VALUES (11, 'flood', 0, 0, 0, '', 'Abuse-Flood', 'abuse_flood.tpl', 0, 0, '');");


mysql_query("CREATE TABLE `".$prefix."_nsnst_cidrs` (
  `cidr` int(2) NOT NULL default '0',
  `hosts` int(10) NOT NULL default '0',
  `mask` varchar(15) NOT NULL default '',
  PRIMARY KEY  (`cidr`)
) ENGINE=MyISAM;");


mysql_query("INSERT INTO `".$prefix."_nsnst_cidrs` VALUES (1, 2147483647, '127.255.255.255');");
mysql_query("INSERT INTO `".$prefix."_nsnst_cidrs` VALUES (2, 1073741824, '63.255.255.255');");
mysql_query("INSERT INTO `".$prefix."_nsnst_cidrs` VALUES (3, 536870912, '31.255.255.255');");
mysql_query("INSERT INTO `".$prefix."_nsnst_cidrs` VALUES (4, 268435456, '15.255.255.255');");
mysql_query("INSERT INTO `".$prefix."_nsnst_cidrs` VALUES (5, 134217728, '7.255.255.255');");
mysql_query("INSERT INTO `".$prefix."_nsnst_cidrs` VALUES (6, 67108864, '3.255.255.255');");
mysql_query("INSERT INTO `".$prefix."_nsnst_cidrs` VALUES (7, 33554432, '1.255.255.255');");
mysql_query("INSERT INTO `".$prefix."_nsnst_cidrs` VALUES (8, 16777216, '0.255.255.255');");
mysql_query("INSERT INTO `".$prefix."_nsnst_cidrs` VALUES (9, 8388608, '0.127.255.255');");
mysql_query("INSERT INTO `".$prefix."_nsnst_cidrs` VALUES (10, 4194304, '0.63.255.255');");
mysql_query("INSERT INTO `".$prefix."_nsnst_cidrs` VALUES (11, 2097152, '0.31.255.255');");
mysql_query("INSERT INTO `".$prefix."_nsnst_cidrs` VALUES (12, 1048576, '0.15.255.255');");
mysql_query("INSERT INTO `".$prefix."_nsnst_cidrs` VALUES (13, 524288, '0.7.255.255');");
mysql_query("INSERT INTO `".$prefix."_nsnst_cidrs` VALUES (14, 262144, '0.3.255.255');");
mysql_query("INSERT INTO `".$prefix."_nsnst_cidrs` VALUES (15, 131072, '0.1.255.255');");
mysql_query("INSERT INTO `".$prefix."_nsnst_cidrs` VALUES (16, 65536, '0.0.255.255');");
mysql_query("INSERT INTO `".$prefix."_nsnst_cidrs` VALUES (17, 32768, '0.0.127.255');");
mysql_query("INSERT INTO `".$prefix."_nsnst_cidrs` VALUES (18, 16384, '0.0.63.255');");
mysql_query("INSERT INTO `".$prefix."_nsnst_cidrs` VALUES (19, 8192, '0.0.31.255');");
mysql_query("INSERT INTO `".$prefix."_nsnst_cidrs` VALUES (20, 4096, '0.0.15.255');");
mysql_query("INSERT INTO `".$prefix."_nsnst_cidrs` VALUES (21, 2048, '0.0.7.255');");
mysql_query("INSERT INTO `".$prefix."_nsnst_cidrs` VALUES (22, 1024, '0.0.3.255');");
mysql_query("INSERT INTO `".$prefix."_nsnst_cidrs` VALUES (23, 512, '0.0.1.255');");
mysql_query("INSERT INTO `".$prefix."_nsnst_cidrs` VALUES (24, 256, '0.0.0.255');");
mysql_query("INSERT INTO `".$prefix."_nsnst_cidrs` VALUES (25, 128, '0.0.0.127');");
mysql_query("INSERT INTO `".$prefix."_nsnst_cidrs` VALUES (26, 64, '0.0.0.63');");
mysql_query("INSERT INTO `".$prefix."_nsnst_cidrs` VALUES (27, 32, '0.0.0.31');");
mysql_query("INSERT INTO `".$prefix."_nsnst_cidrs` VALUES (28, 16, '0.0.0.15');");
mysql_query("INSERT INTO `".$prefix."_nsnst_cidrs` VALUES (29, 8, '0.0.0.7');");
mysql_query("INSERT INTO `".$prefix."_nsnst_cidrs` VALUES (30, 4, '0.0.0.3');");
mysql_query("INSERT INTO `".$prefix."_nsnst_cidrs` VALUES (31, 2, '0.0.0.1');");
mysql_query("INSERT INTO `".$prefix."_nsnst_cidrs` VALUES (32, 1, '0.0.0.0');");


mysql_query("CREATE TABLE `".$prefix."_nsnst_config` (
  `config_name` varchar(255) NOT NULL default '',
  `config_value` longtext NOT NULL,
  PRIMARY KEY  (`config_name`)
) ENGINE=MyISAM;");

mysql_query("INSERT INTO `".$prefix."_nsnst_config` VALUES ('admin_contact', 'webmaster@yoursite.com');");
mysql_query("INSERT INTO `".$prefix."_nsnst_config` VALUES ('block_perpage', '50');");
mysql_query("INSERT INTO `".$prefix."_nsnst_config` VALUES ('block_sort_column', 'date');");
mysql_query("INSERT INTO `".$prefix."_nsnst_config` VALUES ('block_sort_direction', 'desc');");
mysql_query("INSERT INTO `".$prefix."_nsnst_config` VALUES ('crypt_salt', 'N$');");
mysql_query("INSERT INTO `".$prefix."_nsnst_config` VALUES ('display_link', '3');");
mysql_query("INSERT INTO `".$prefix."_nsnst_config` VALUES ('display_reason', '3');");
mysql_query("INSERT INTO `".$prefix."_nsnst_config` VALUES ('force_nukeurl', '0');");
mysql_query("INSERT INTO `".$prefix."_nsnst_config` VALUES ('flood_delay_post', '5');");
mysql_query("INSERT INTO `".$prefix."_nsnst_config` VALUES ('flood_delay_get', '3');");
mysql_query("INSERT INTO `".$prefix."_nsnst_config` VALUES ('help_switch', '1');");
mysql_query("INSERT INTO `".$prefix."_nsnst_config` VALUES ('htaccess_path', '');");
mysql_query("INSERT INTO `".$prefix."_nsnst_config` VALUES ('http_auth', '0');");
mysql_query("INSERT INTO `".$prefix."_nsnst_config` VALUES ('lookup_link', 'http://www.DNSstuff.com/tools/whois.ch?ip=');");
mysql_query("INSERT INTO `".$prefix."_nsnst_config` VALUES ('page_delay', '5');");
mysql_query("INSERT INTO `".$prefix."_nsnst_config` VALUES ('prevent_dos', '0');");
mysql_query("INSERT INTO `".$prefix."_nsnst_config` VALUES ('proxy_reason', 'admin_proxy_reason.tpl');");
mysql_query("INSERT INTO `".$prefix."_nsnst_config` VALUES ('proxy_switch', '0');");
mysql_query("INSERT INTO `".$prefix."_nsnst_config` VALUES ('santy_protection', '1');");
mysql_query("INSERT INTO `".$prefix."_nsnst_config` VALUES ('self_expire', '0');");
mysql_query("INSERT INTO `".$prefix."_nsnst_config` VALUES ('site_reason', 'admin_site_reason.tpl');");
mysql_query("INSERT INTO `".$prefix."_nsnst_config` VALUES ('site_switch', '0');");
mysql_query("INSERT INTO `".$prefix."_nsnst_config` VALUES ('staccess_path', '');");
mysql_query("INSERT INTO `".$prefix."_nsnst_config` VALUES ('track_active', '0');");
mysql_query("INSERT INTO `".$prefix."_nsnst_config` VALUES ('track_max', '604800');");
mysql_query("INSERT INTO `".$prefix."_nsnst_config` VALUES ('track_perpage', '50');");
mysql_query("INSERT INTO `".$prefix."_nsnst_config` VALUES ('track_sort_column', '6');");
mysql_query("INSERT INTO `".$prefix."_nsnst_config` VALUES ('track_sort_direction', 'desc');");
mysql_query("INSERT INTO `".$prefix."_nsnst_config` VALUES ('version_number', '2.4.2pl3');");


mysql_query("CREATE TABLE `".$prefix."_nsnst_countries` (
  `c2c` char(2) NOT NULL default '',
  `country` varchar(60) NOT NULL default '',
  PRIMARY KEY  (`c2c`)
) ENGINE=MyISAM;");


mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('af', 'Afghanistan');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('al', 'Albania');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('dz', 'Algeria');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('ad', 'Andorra');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('ao', 'Angola');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('ai', 'Anguilla');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('aq', 'Antartica');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('ag', 'Antigua And Barbuda');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('ar', 'Argentina');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('am', 'Armenia');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('aw', 'Aruba');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('au', 'Australia');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('at', 'Austria');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('az', 'Azerbaijan');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('bs', 'Bahamas');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('bh', 'Bahrain');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('bd', 'Bangladesh');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('bb', 'Barbados');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('by', 'Belarus');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('be', 'Belgium');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('bz', 'Belize');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('bj', 'Benin');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('bm', 'Bermuda');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('bt', 'Bhutan');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('bo', 'Bolivia');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('ba', 'Bosnia And Herzegovina');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('bw', 'Botswana');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('bv', 'Bouvet Island');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('br', 'Brazil');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('io', 'British Indian Ocean Territory');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('bn', 'Brunei Darussalam');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('bg', 'Bulgaria');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('bf', 'Burkina Faso');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('bi', 'Burundi');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('kh', 'Cambodia');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('cm', 'Cameroon');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('ca', 'Canada');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('cv', 'Cape Verde');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('ky', 'Cayman Islands');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('cf', 'Central African Republic');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('td', 'Chad');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('cl', 'Chile');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('cn', 'China');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('cx', 'Christmas Island');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('cc', 'Cocos Islands');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('co', 'Colombia');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('km', 'Comoros');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('cd', 'Congo, Democratic Republic Of The');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('cg', 'Congo, People''s Republic Of The');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('ck', 'Cook Islands');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('cr', 'Costa Rica');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('ci', 'Cote D''ivoire');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('hr', 'Croatia');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('cu', 'Cuba');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('cy', 'Cyprus');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('cz', 'Czech Republic');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('dk', 'Denmark');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('dj', 'Djibouti');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('dm', 'Dominica');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('do', 'Dominican Republic');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('ec', 'Ecuador');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('eg', 'Egypt');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('sv', 'El Salvador');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('xe', 'England');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('gq', 'Equatorial Guinea');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('er', 'Eritrea');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('ee', 'Estonia');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('et', 'Ethiopia');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('eu', 'European Union');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('fk', 'Falkland Islands');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('fo', 'Faroe Islands');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('fj', 'Fiji');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('fi', 'Finland');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('fr', 'France');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('fx', 'France, Metropolitan');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('gf', 'French Guiana');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('pf', 'French Polynesia');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('tf', 'French Southern Territories');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('ga', 'Gabon');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('gm', 'Gambia');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('ge', 'Georgia');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('de', 'Germany');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('gh', 'Ghana');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('gi', 'Gibraltar');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('gr', 'Greece');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('gl', 'Greenland');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('gd', 'Grenada');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('gp', 'Guadeloupe');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('gu', 'Guam');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('gt', 'Guatemala');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('gn', 'Guinea');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('gw', 'Guinea-Bissau');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('gy', 'Guyana');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('ht', 'Haiti');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('hm', 'Heard and Mc Donald Islands');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('hn', 'Honduras');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('hk', 'Hong Kong');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('hu', 'Hungary');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('01', 'IANA Reserved');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('is', 'Iceland');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('in', 'India');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('id', 'Indonesia');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('ir', 'Iran');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('iq', 'Iraq');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('ie', 'Ireland');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('il', 'Israel');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('it', 'Italy');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('jm', 'Jamaica');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('jp', 'Japan');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('jo', 'Jordan');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('kz', 'Kazakhstan');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('ke', 'Kenya');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('ki', 'Kiribati');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('kp', 'Korea, North');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('kr', 'Korea, South');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('kw', 'Kuwait');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('kg', 'Kyrgyzstan');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('la', 'Laos');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('lv', 'Latvia');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('lb', 'Lebanon');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('ls', 'Lesotho');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('lr', 'Liberia');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('ly', 'Libya');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('li', 'Liechtenstein');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('lt', 'Lithuania');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('lu', 'Luxembourg');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('mo', 'Macau');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('mk', 'Macedonia');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('mg', 'Madagascar');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('mw', 'Malawi');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('my', 'Malaysia');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('mv', 'Maldives');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('ml', 'Mali');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('mt', 'Malta');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('mh', 'Marshall Islands');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('mq', 'Martinique');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('mr', 'Mauritania');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('mu', 'Mauritius');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('yt', 'Mayotte');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('mx', 'Mexico');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('fm', 'Micronesia');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('md', 'Moldova');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('mc', 'Monaco');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('mn', 'Mongolia');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('ms', 'Montserrat');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('ma', 'Morocco');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('mz', 'Mozambique');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('mm', 'Myanmar');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('na', 'Namibia');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('nr', 'Nauru');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('np', 'Nepal');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('nl', 'Netherlands');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('an', 'Netherlands Antilles');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('nc', 'New Caledonia');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('nz', 'New Zealand');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('ni', 'Nicaragua');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('ne', 'Niger');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('ng', 'Nigeria');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('nu', 'Niue');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('nf', 'Norfork Island');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('mp', 'Northern Mariana Islands');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('no', 'Norway');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('om', 'Oman');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('pk', 'Pakistan');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('pw', 'Palau');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('ps', 'Palestine');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('pa', 'Panama');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('pg', 'Papua New Guinea');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('py', 'Paraguay');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('pe', 'Peru');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('ph', 'Philippines');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('pn', 'Pitcairn');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('pl', 'Poland');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('pt', 'Portugal');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('pr', 'Puerto Rico');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('qa', 'Qatar');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('re', 'Reunion');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('ro', 'Romania');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('ru', 'Russia');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('rw', 'Rwanda');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('sh', 'Saint Helena');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('kn', 'Saint Kitts And Nevis');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('lc', 'Saint Lucia');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('pm', 'Saint Pierre and Miquelon');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('vc', 'Saint Vincent And The Grenadines');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('ws', 'Samoa');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('as', 'Samoa, American');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('sm', 'San Marino');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('st', 'Sao Tome And Principe');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('sa', 'Saudi Arabia');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('xs', 'Scotland');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('sn', 'Senegal');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('cs', 'Serbia And Montenegro');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('sc', 'Seychelles');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('sl', 'Sierra Leone');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('sg', 'Singapore');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('sk', 'Slovakia');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('si', 'Slovenia');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('sb', 'Solomon Islands');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('so', 'Somalia');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('za', 'South Africa');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('gs', 'South Georgia and The South Sandwich Islands');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('es', 'Spain');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('lk', 'Sri Lanka');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('sd', 'Sudan');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('sr', 'Suriname');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('sj', 'Svalbard and Jan Mayen Islands');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('sz', 'Swaziland');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('se', 'Sweden');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('ch', 'Switzerland');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('sy', 'Syria');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('tw', 'Taiwan');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('tj', 'Tajikistan');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('tz', 'Tanzania');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('th', 'Thailand');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('tl', 'Timor-leste');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('tg', 'Togo');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('tk', 'Tokelau');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('to', 'Tonga');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('tt', 'Trinidad And Tobago');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('tn', 'Tunisia');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('tr', 'Turkey');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('tm', 'Turkmenistan');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('tc', 'Turks And Caicos Islands');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('tv', 'Tuvalu');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('ug', 'Uganda');");

mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('ua', 'Ukraine');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('ae', 'United Arab Emirates');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('gb', 'United Kingdom');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('un', 'United Nations');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('us', 'United States');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('um', 'United States Minor Outlying Islands');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('00', 'Unknown');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('uy', 'Uruguay');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('uz', 'Uzbekistan');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('vu', 'Vanuatu');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('va', 'Vatican City State');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('ve', 'Venezuela');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('vn', 'Viet Nam');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('vi', 'Virgin Islands, American');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('vg', 'Virgin Islands, British');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('xw', 'Wales');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('wf', 'Wallis and Futuna Islands');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('eh', 'Western Sahara');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('ye', 'Yemen');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('yu', 'Yugoslavia');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('zm', 'Zambia');");
mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('zw', 'Zimbabwe');");


mysql_query("CREATE TABLE `".$prefix."_nsnst_excluded_ranges` (
  `ip_lo` int(10) unsigned NOT NULL default '0',
  `ip_hi` int(10) unsigned NOT NULL default '0',
  `date` int(20) NOT NULL default '0',
  `notes` text NOT NULL,
  `c2c` char(2) NOT NULL default '00',
  PRIMARY KEY  (`ip_lo`,`ip_hi`),
  KEY `c2c` (`c2c`),
  KEY `date` (`date`)
) ENGINE=MyISAM;");


mysql_query("CREATE TABLE `".$prefix."_nsnst_flood` (
  `ip` varchar(15) NOT NULL default '0.0.0.0',
  `lastpost` int(20) NOT NULL default '0',
  PRIMARY KEY  (`ip`)
) ENGINE=MyISAM;");

mysql_query("CREATE TABLE `".$prefix."_nsnst_ip2country` (
  `ip_lo` int(10) unsigned NOT NULL default '0',
  `ip_hi` int(10) unsigned NOT NULL default '0',
  `date` int(20) NOT NULL default '0',
  `c2c` char(2) NOT NULL default '',
  `country` varchar(60) NOT NULL default '',
  PRIMARY KEY  (`ip_lo`,`ip_hi`),
  KEY `c2c` (`c2c`),
  KEY `date` (`date`)
) ENGINE=MyISAM;");


mysql_query("CREATE TABLE `".$prefix."_nsnst_protected_ranges` (
  `ip_lo` int(10) unsigned NOT NULL default '0',
  `ip_hi` int(10) unsigned NOT NULL default '0',
  `date` int(20) NOT NULL default '0',
  `notes` text NOT NULL,
  `c2c` char(2) NOT NULL default '00',
  PRIMARY KEY  (`ip_lo`,`ip_hi`),
  KEY `c2c` (`c2c`),
  KEY `date` (`date`)
) ENGINE=MyISAM;");


mysql_query("CREATE TABLE `".$prefix."_nsnst_tracked_ips` (
  `tid` int(10) NOT NULL auto_increment,
  `ip_addr` varchar(15) NOT NULL default '',
  `hostname` varchar(100) NOT NULL default '',
  `user_id` int(11) NOT NULL default '1',
  `username` varchar(60) NOT NULL default '',
  `user_agent` text NOT NULL,
  `date` int(20) NOT NULL default '0',
  `page` text NOT NULL,
  `x_forward_for` varchar(32) NOT NULL default '',
  `client_ip` varchar(32) NOT NULL default '',
  `remote_addr` varchar(32) NOT NULL default '',
  `remote_port` varchar(11) NOT NULL default '',
  `request_method` varchar(10) NOT NULL default '',
  `c2c` char(2) NOT NULL default '00',
  PRIMARY KEY  (`tid`),
  KEY `c2c` (`c2c`),
  KEY `ip_addr` (`ip_addr`),
  KEY `user_id` (`user_id`),
  KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=1 ;");
echo"<center>Sentinel has been installed.";
echo "<br>Go to the main installation <a href=\"index.php\">file</a>, and run the 3.0.1 to 3.0.2 update.<b></b>!</font></center>";
}
//CloseTable();
//include("footer.php");
?>