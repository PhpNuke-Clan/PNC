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
      PNC&trade; &copy; 2006, 2007 - PNC 4.0
    </h2>
<?php

//require_once("mainfile.php");
//include("header.php");
include("../config.php");
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
echo"<center>This file will Delete your forum shop tables, updates your PNC versionnumber and will delete the Review tables, cuz they aren't of any use in PNC 3.0.1 <br><br><a href=\"$PHP_SELF?step=2\">PATCH</a><br></center>";
}
if($step == 2){
//$table ="nuke_shopitems";


//mysql_query("DROP TABLE IF EXISTS nuke_shopitems");


function mysql_table_exists($table) {
   $exists = mysql_query("SELECT 1 FROM `$table` LIMIT 0");
   if ($exists) return true;
   return false;
}
	if (!mysql_table_exists('nuke_shopitems')) {
   	echo"Tabel <b>nuke_shopitems</b> does not exist, that's ok :)<br>";} 
	else{mysql_query('DROP TABLE nuke_shopitems') or die('MySQL said: '.mysql_error());
	echo"Table <b>nuke_shopitems</b> is deleted<br>";}
//*************************************************

	if (!mysql_table_exists('nuke_shops')) {
 	echo"Tabel <b>nuke_shops </b> did not exist, that's ok :)<br>";} 
	else{mysql_query('DROP TABLE nuke_shops') or die('MySQL said: '.mysql_error());
	echo"Table <b>nuke_shops</b> is deleted<br>";}
//*************************************************

	 $query1 = mysql_query("SHOW COLUMNS FROM ".$user_prefix."_users LIKE 'user_effects'") or die(mysql_error());
	 $query2 = mysql_query("SHOW COLUMNS FROM ".$user_prefix."_users LIKE 'user_privs'") or die(mysql_error());
	 $query3 = mysql_query("SHOW COLUMNS FROM ".$user_prefix."_users LIKE 'user_custitle'") or die(mysql_error());
	 $query4 = mysql_query("SHOW COLUMNS FROM ".$user_prefix."_users LIKE 'user_specmsg'") or die(mysql_error());
	 $query5 = mysql_query("SHOW COLUMNS FROM ".$user_prefix."_users LIKE 'user_items'") or die(mysql_error());
	 $query6 = mysql_query("SHOW COLUMNS FROM ".$user_prefix."_users LIKE 'user_trade'") or die(mysql_error());
	 $query7 = mysql_query("SHOW COLUMNS FROM ".$user_prefix."_users LIKE 'user_usd'") or die(mysql_error());
	 
	if (mysql_num_rows($query1) == 0) {echo 'Column <b>user_effect</b> does not exist, that is ok :)<br>';} else {mysql_query("ALTER TABLE ".$user_prefix."_users DROP user_effects")or die('MySQL said: '.mysql_error());	
	echo"Column<b> user_effects</b> is deleted<br>";} 
	if (mysql_num_rows($query2) == 0) {echo 'Column <b>user_privs</b> does not exist, that is ok :)<br>';} else {mysql_query("ALTER TABLE ".$user_prefix."_users DROP user_privs")or die('MySQL said: '.mysql_error());	
	echo"Column<b> user_privs</b> is deleted<br>";}
	if (mysql_num_rows($query3) == 0) {echo 'Column <b>user_custitle</b> does not exist, that is ok :)<br>';} else {mysql_query("ALTER TABLE ".$user_prefix."_users DROP user_custitle")or die('MySQL said: '.mysql_error());	
	echo"Column<b> user_custitle</b> is deleted<br>";}
	if (mysql_num_rows($query4) == 0) {echo 'Column <b>user_specmsg</b> does not exist, that is ok :)<br>';} else {mysql_query("ALTER TABLE ".$user_prefix."_users DROP user_specmsg")or die('MySQL said: '.mysql_error());	
	echo"Column<b> user_specmsg</b> is deleted<br>";}
	if (mysql_num_rows($query5) == 0) {echo 'Column <b>user_items</b> does not exist, that is ok :)<br>';} else {mysql_query("ALTER TABLE ".$user_prefix."_users DROP user_items")or die('MySQL said: '.mysql_error()); 
	echo"Column<b> user_items</b> is deleted<br>";}
	if (mysql_num_rows($query6) == 0) {echo 'Column <b>user_trade</b> does not exist, that is ok :)<br>';} else {mysql_query("ALTER TABLE ".$user_prefix."_users DROP user_trade")or die('MySQL said: '.mysql_error());	
	echo"Column<b> user_trade</b> is deleted<br>";}
	if (mysql_num_rows($query7) == 0) {echo 'Column <b>user_usd</b> does not exist, that is ok :)<br>';} else {mysql_query("ALTER TABLE ".$user_prefix."_users DROP user_usd")or die('MySQL said: '.mysql_error());	
	echo"Column<b> user_usd</b> is deleted<br><br>";} 
	
//######################################################################################
	if (!mysql_table_exists("".$prefix."_platinum_technology")) {
   	echo"Table <b>".$prefix."_platinum_technology</b> changed to";} 
	else{ mysql_query("RENAME TABLE ".$prefix."_platinum_technology TO ".$prefix."_pnc_technology")
		
	      or die('MySQL said: '.mysql_error());
	echo"Renamed table <b>".$prefix."_platinum_technology</b> to <b>".$prefix."_pnc_technology</b><br>";}
	
if (!mysql_table_exists("".$prefix."_pnc_technology")) {} 
	else{mysql_query("UPDATE ".$prefix."_pnc_technology SET  value='3.0.1' WHERE name='versioncheck'") or die('MySQL said: '.mysql_error()); echo" <b>".$prefix."_pnc_technology</b><br>";}
	
//######################################################################################	
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
	//DROP TABLE IF EXISTS nuke_bbcustom_canned;
	
		if (!mysql_table_exists("".$prefix."_bbcustom_canned")) {mysql_query("CREATE TABLE ".$prefix."_bbcustom_canned (
   `custom_canned_id` mediumint(8) unsigned NOT NULL auto_increment,
   `group_id` mediumint(8) DEFAULT '0' NOT NULL,
   `user_id` mediumint(8) DEFAULT '0' NOT NULL,
   `custom_canned_title` varchar(100) NOT NULL,
   `custom_canned_message` text NOT NULL,
   `sortorder` smallint(4) DEFAULT '0' NOT NULL,
   PRIMARY KEY (custom_canned_id),
   KEY user_id (user_id),
   KEY group_id (group_id))") or die('MySQL said: '.mysql_error());
	echo"Table <b>".$prefix."_bbcustom_canned</b> is added to the database<br><br>";
   } 
	else{echo"Tabel <b>".$prefix."_bbcustom_canned</b> already exists<br>";}
	
	$sql6="SELECT * FROM ".$prefix."_pnc_technology WHERE  name='versioncheck'";
$res6 = mysql_query($sql6);

while($row = mysql_fetch_array($res6)){
$versioncheck = $row["value"];
}
echo"<br>Your new version is: $versioncheck!!<br><br>";
echo"<center>PNC 3.0.1 has Sentinel pre-installed.<br>
	If you already have Sentinel installed, you can skip this step.<br><a href=\"$PHP_SELF?step=4\">Install Sentinel NOW!!</a><br>";
echo"</center>";

}

if($step ==4 ){
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