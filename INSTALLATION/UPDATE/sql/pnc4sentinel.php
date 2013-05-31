<?php
/********************************************************/
/* NukeSentinel(tm)                                     */
/* By: NukeScripts(tm) (http://www.nukescripts.net)     */
/* Copyright © 2000-2008 by NukeScripts(tm)             */
/* See CREDITS.txt for ALL contributors                 */
/********************************************************/

if( !defined('PNC_INST')){
	if( !defined('PNC_UPD')){
		die("Access denied!");
	}
}
@ini_set('display_errors', 1);
$mess1 = '<font color="#AA0000"><strong>FAILED</strong></font><br />'."\n";
$mess2 = '<font color="#00AA00"><strong>OK</strong></font><br />'."\n";

// DROP TABLE nsnst_admins
echo 'Drop '.$prefix.'_nsnst_admins: ';
$result = mysql_query("DROP TABLE IF EXISTS `".$prefix."_nsnst_admins`");
if(!$result) { echo $mess1; } else { echo $mess2; }
// CREATE TABLE nsnst_admins
echo 'Create '.$prefix.'_nsnst_admins: ';
$result = mysql_query("CREATE TABLE `".$prefix."_nsnst_admins` (`aid` varchar(25) NOT NULL default '', `login` varchar(25) NOT NULL default '', `password` varchar(40) NOT NULL default '', `password_md5` varchar(60) NOT NULL default '', `password_crypt` varchar(60) NOT NULL default '', `protected` tinyint(2) NOT NULL default '0', PRIMARY KEY (`aid`))");
if(!$result) { echo $mess1; } else { echo $mess2; }
// POPULATE TABLE nsnst_admins
/*$admnmess = $mess2;
echo 'Populate '.$prefix.'_nsnst_admins: ';
$importad = mysql_query("SELECT `aid`, `name` FROM `".$prefix."_authors`");
while(list($a_aid, $a_name) = $db->sql_fetchrow($importad)) {
  if(strtolower($a_name) == "god") { $is_god = 1; } else { $is_god = 0; }
  $result = mysql_query("INSERT INTO `".$prefix."_nsnst_admins` VALUES ('$a_aid', '$a_aid', '', '', '', '$is_god')");
  if(!$result) { $admnmess = $mess1; }
}
echo $admnmess;*/

// DROP TABLE nsnst_blocked_ips
echo 'Drop '.$prefix.'_nsnst_blocked_ips: ';
$result = mysql_query("DROP TABLE IF EXISTS `".$prefix."_nsnst_blocked_ips`");
if(!$result) { echo $mess1; } else { echo $mess2; }
// CREATE TABLE nsnst_blocked_ips
echo 'Create '.$prefix.'_nsnst_blocked_ips: ';
$result = mysql_query("CREATE TABLE `".$prefix."_nsnst_blocked_ips` (`ip_addr` varchar(15) NOT NULL default '', `ip_long` INT(10) unsigned NOT NULL default '0', `user_id` int(11) NOT NULL default '1', `username` varchar(60) NOT NULL default '', `user_agent` text NOT NULL, `date` int(20) NOT NULL default '0', `notes` text NOT NULL, `reason` tinyint(1) NOT NULL default '0', `query_string` text NOT NULL, `get_string` text NOT NULL, `post_string` text NOT NULL, `x_forward_for` varchar(32) NOT NULL default '', `client_ip` varchar(32) NOT NULL default '', `remote_addr` varchar(32) NOT NULL default '', `remote_port` varchar(11) NOT NULL default '', `request_method` varchar(10) NOT NULL default '', `expires` int(20) NOT NULL default '0', `c2c` char(2) NOT NULL default '00', PRIMARY KEY (`ip_addr`), KEY (`ip_long`), KEY `c2c` (`c2c`), KEY `date` (`date`), KEY `expires` (`expires`), KEY `reason` (`reason`))");
if(!$result) { echo $mess1; } else { echo $mess2; }

// DROP TABLE nsnst_blocked_ranges
echo 'Drop '.$prefix.'_nsnst_blocked_ranges: ';
$result = mysql_query("DROP TABLE IF EXISTS `".$prefix."_nsnst_blocked_ranges`");
if(!$result) { echo $mess1; } else { echo $mess2; }
// CREATE TABLE nsnst_blocked_ranges
echo 'Create '.$prefix.'_nsnst_blocked_ranges: ';
$result = mysql_query("CREATE TABLE `".$prefix."_nsnst_blocked_ranges` (`ip_lo` int(10) unsigned NOT NULL default '0', `ip_hi` int(10) unsigned NOT NULL default '0', `date` int(20) NOT NULL default '0', `notes` text NOT NULL, `reason` tinyint(1) NOT NULL default '0', `expires` int(20) NOT NULL default '0', `c2c` char(2) NOT NULL default '00', PRIMARY KEY (`ip_lo`,`ip_hi`), KEY `c2c` (`c2c`), KEY `date` (`date`), KEY `expires` (`expires`), KEY `reason` (`reason`))");
if(!$result) { echo $mess1; } else { echo $mess2; }

// DROP TABLE nsnst_blockers
echo 'Drop '.$prefix.'_nsnst_blockers: ';
$result = mysql_query("DROP TABLE IF EXISTS `".$prefix."_nsnst_blockers`");
if(!$result) { echo $mess1; } else { echo $mess2; }
// CREATE TABLE nsnst_blockers
echo 'Create '.$prefix.'_nsnst_blockers: ';
$result = mysql_query("CREATE TABLE `".$prefix."_nsnst_blockers` (`blocker` int(4) NOT NULL default '0', `block_name` varchar(20) NOT NULL default '', `activate` int(4) NOT NULL default '0', `block_type` int(4) NOT NULL default '0', `email_lookup` int(4) NOT NULL default '0', `forward` varchar(255) NOT NULL default '', `reason` varchar(20) NOT NULL default '', `template` varchar(255) NOT NULL default '', `duration` int(20) NOT NULL default '0', `htaccess` int(4) NOT NULL default '0', `list` longtext NOT NULL, PRIMARY KEY (`blocker`))");
if(!$result) { echo $mess1; } else { echo $mess2; }
// INSERT INTO TABLE nsnst_blockers
echo 'Populate '.$prefix.'_nsnst_blockers: ';
$mess = $mess2;
$wfilename = "sql/data/blockers.data";
if(file_exists($wfilename)) {
  $wfread = fopen($wfilename, 'r');
  $linecount = 0;
  while (!feof($wfread)) {
    $DataRead = fgets($wfread, 1024);
    $DataRead = ereg_replace ("\r", "", $DataRead);
    $DataRead = ereg_replace ("\n", "", $DataRead);
    $data = explode ("||", $DataRead);
    if($data[0] > "") {
      for($i=0; $i<count($data); $i++) {
        if(!get_magic_quotes_runtime()) { $data[$i] = addslashes($data[$i]); } 
      }
      $datainserted = False;
      $datainserted = mysql_query("INSERT INTO `".$prefix."_nsnst_blockers` VALUES (".$data[0].", '".$data[1]."', ".$data[2].", ".$data[3].", ".$data[4].", '', '".$data[6]."', '".$data[7]."', ".$data[8].", ".$data[9].", '')");
      if(!$datainserted) { $mess = $mess1; }
    }
  }
  fclose($wfread);
} else {
  $mess = $mess1;
}
echo $mess;

// DROP TABLE nsnst_cidrs
echo 'Drop '.$prefix.'_nsnst_cidrs: ';
$result = mysql_query("DROP TABLE IF EXISTS `".$prefix."_nsnst_cidrs`");
if(!$result) { echo $mess1; } else { echo $mess2; }
// CREATE TABLE nsnst_cidrs
echo 'Create '.$prefix.'_nsnst_cidrs: ';
$result = mysql_query("CREATE TABLE `".$prefix."_nsnst_cidrs` (`cidr` int(2) NOT NULL default '0', `hosts` int(10) NOT NULL default '0', `mask` varchar(15) NOT NULL default '', PRIMARY KEY (`cidr`))");
if(!$result) { echo $mess1; } else { echo $mess2; }
// INSERT INTO TABLE nsnst_cidrs
echo 'Populate '.$prefix.'_nsnst_cidrs: ';
$mess = $mess2;
$wfilename = "sql/data/cidrs.data";
if(file_exists($wfilename)) {
  $wfread = fopen($wfilename, 'r');
  $linecount = 0;
  while (!feof($wfread)) {
    $DataRead = fgets($wfread, 1024);
    $DataRead = ereg_replace ("\r", "", $DataRead);
    $DataRead = ereg_replace ("\n", "", $DataRead);
    $data = explode ("||", $DataRead);
    if($data[0] > "") {
      for($i=0; $i<count($data); $i++) {
        if(!get_magic_quotes_runtime()) { $data[$i] = addslashes($data[$i]); }
      }
      $datainserted = False;
      $datainserted = mysql_query("INSERT INTO `".$prefix."_nsnst_cidrs` VALUES (".$data[0].", ".$data[1].", '".$data[2]."')");
      if(!$datainserted) { $mess = $mess1; }
    }
  }
  fclose($wfread);
} else {
  $mess = $mess1;
}
echo $mess;

// DROP TABLE snst_config
echo 'Drop '.$prefix.'_nsnst_config: ';
$result = mysql_query("DROP TABLE IF EXISTS `".$prefix."_nsnst_config`");
if(!$result) { echo $mess1; } else { echo $mess2; }
// CREATE TABLE nsnst_config
echo 'Create '.$prefix.'_nsnst_config: ';
$result = mysql_query("CREATE TABLE `".$prefix."_nsnst_config` (`config_name` varchar(255) NOT NULL default '', `config_value` longtext NOT NULL, PRIMARY KEY (`config_name`))");
if(!$result) { echo $mess1; } else { echo $mess2; }
// INSERT INTO TABLE nsnst_config
echo 'Populate '.$prefix.'_nsnst_config: ';
$mess = $mess2;
$wfilename = "sql/data/config.data";
if(file_exists($wfilename)) {
  $wfread = fopen($wfilename, 'r');
  $linecount = 0;
  while (!feof($wfread)) {
    $DataRead = fgets($wfread, 1024);
    $DataRead = ereg_replace ("\r", "", $DataRead);
    $DataRead = ereg_replace ("\n", "", $DataRead);
    $data = explode ("||", $DataRead);
    if($data[0] > "") {
      for($i=0; $i<count($data); $i++) {
        if(!get_magic_quotes_runtime()) { $data[$i] = addslashes($data[$i]); }
      }
      $datainserted = False;
      $datainserted = mysql_query("INSERT INTO `".$prefix."_nsnst_config` VALUES ('".$data[0]."', '".$data[1]."')");
      if(!$datainserted) { $mess = $mess1; }
    }
  }
  fclose($wfread);
} else {
  $mess = $mess1;
}
echo $mess;

// DROP TABLE nsnst_countries
echo 'Drop '.$prefix.'_nsnst_config: ';
$result = mysql_query("DROP TABLE IF EXISTS `".$prefix."_nsnst_countries`");
if(!$result) { echo $mess1; } else { echo $mess2; }
// CREATE TABLE nsnst_countries
echo 'Create '.$prefix.'_nsnst_countries: ';
$result = mysql_query("CREATE TABLE `".$prefix."_nsnst_countries` (`c2c` char(2) NOT NULL default '', `country` varchar(60) NOT NULL default '', PRIMARY KEY `c2c` (`c2c`))");
if(!$result) { echo $mess1; } else { echo $mess2; }
// INSERT INTO TABLE nsnst_countries
echo 'Populate '.$prefix.'_nsnst_countries: ';
$mess = $mess2;
$wfilename = "sql/data/countries.data";
if(file_exists($wfilename)) {
  $wfread = fopen($wfilename, 'r');
  $linecount = 0;
  while (!feof($wfread)) {
    $DataRead = fgets($wfread, 1024);
    $DataRead = ereg_replace ("\r", "", $DataRead);
    $DataRead = ereg_replace ("\n", "", $DataRead);
    $data = explode ("||", $DataRead);
    if($data[0] > "") {
      for($i=0; $i<count($data); $i++) {
        if(!get_magic_quotes_runtime()) { $data[$i] = addslashes($data[$i]); }
      }
      $datainserted = False;
      $datainserted = mysql_query("INSERT INTO `".$prefix."_nsnst_countries` VALUES ('".$data[0]."', '".$data[1]."')");
      if(!$datainserted) { $mess = $mess1; }
    }
  }
  fclose($wfread);
} else {
  $mess = $mess1;
}
echo $mess;

// DROP TABLE nsnst_excluded_ranges
echo 'Drop '.$prefix.'_nsnst_excluded_ranges: ';
$result = mysql_query("DROP TABLE IF EXISTS `".$prefix."_nsnst_excluded_ranges`");
if(!$result) { echo $mess1; } else { echo $mess2; }
// CREATE TABLE nsnst_excluded_ranges
echo 'Create '.$prefix.'_nsnst_excluded_ranges: ';
$result = mysql_query("CREATE TABLE `".$prefix."_nsnst_excluded_ranges` (`ip_lo` int(10) unsigned NOT NULL default '0', `ip_hi` int(10) unsigned NOT NULL default '0', `date` int(20) NOT NULL default '0', `notes` text NOT NULL, `c2c` char(2) NOT NULL default '00', PRIMARY KEY (`ip_lo`,`ip_hi`), KEY `c2c` (`c2c`), KEY `date` (`date`))");
if(!$result) { echo $mess1; } else { echo $mess2; }
// Add current admin ip to excluded table
$admin_ip = sprintf("%u", ip2long($nsnst_const['remote_ip']));
echo 'Populate '.$prefix.'_nsnst_excluded_ranges: ';
$result = mysql_query("INSERT INTO `".$prefix."_nsnst_excluded_ranges` VALUES ('$admin_ip', '$admin_ip', '".$nsnst_const['ban_time']."', 'Admin\'s personal ip', '00')");
if(!$result) { echo $mess1; } else { echo $mess2; }

// DROP TABLE nsnst_harvesters
echo 'Drop '.$prefix.'_nsnst_harvesters: ';
$result = mysql_query("DROP TABLE IF EXISTS `".$prefix."_nsnst_harvesters`");
if(!$result) { echo $mess1; } else { echo $mess2; }
// CREATE TABLE nsnst_harvesters
echo 'Create '.$prefix.'_nsnst_harvesters: ';
$result = mysql_query("CREATE TABLE `".$prefix."_nsnst_harvesters` (`hid` int(2) NOT NULL auto_increment, `harvester` varchar(255) NOT NULL default '', PRIMARY KEY (`harvester`), KEY `hid` (`hid`))");
if(!$result) { echo $mess1; } else { echo $mess2; }
// INSERT INTO TABLE nsnst_harvesters
echo 'Populate '.$prefix.'_nsnst_harvesters: ';
$mess = $mess2;
$wfilename = "sql/data/harvesters.data";
$list_harvester = "";
if(file_exists($wfilename)) {
  $wfread = fopen($wfilename, 'r');
  $linecount = 0;
  while (!feof($wfread)) {
    $DataRead = fgets($wfread, 1024);
    $DataRead = ereg_replace ("\r", "", $DataRead);
    $DataRead = ereg_replace ("\n", "", $DataRead);
    $data = explode ("||", $DataRead);
    if($data[0] > "") {
      for($i=0; $i<count($data); $i++) {
        if(!get_magic_quotes_runtime()) { $data[$i] = addslashes($data[$i]); }
      }
      if($list_harvester == "") { $list_harvester = $data[1]; } else { $list_harvester .= "\r\n".$data[1]; }
      $datainserted = False;
      $datainserted = mysql_query("INSERT INTO `".$prefix."_nsnst_harvesters` VALUES (".$data[0].", '".$data[1]."')");
      if(!$datainserted) { $mess = $mess1; }
    }
  }
  fclose($wfread);
} else {
  $mess = $mess1;
}
echo $mess;
mysql_query("UPDATE `".$prefix."_nsnst_config` SET `config_value`='$list_harvester' WHERE `config_name`='list_harvester'");

// DROP TABLE nsnst_ip2country
echo 'Drop '.$prefix.'_nsnst_ip2country: ';
$result = mysql_query("DROP TABLE IF EXISTS `".$prefix."_nsnst_ip2country`");
if(!$result) { echo $mess1; } else { echo $mess2; }
// CREATE TABLE nsnst_ip2country
echo 'Create '.$prefix.'_nsnst_ip2country: ';
$result = mysql_query("CREATE TABLE `".$prefix."_nsnst_ip2country` (`ip_lo` int(10) unsigned NOT NULL default '0', `ip_hi` int(10) unsigned NOT NULL default '0', `date` int(20) NOT NULL default '0', `c2c` char(2) NOT NULL default '', PRIMARY KEY (`ip_lo`,`ip_hi`), KEY `c2c` (`c2c`), KEY `date` (`date`))");
if(!$result) { echo $mess1; } else { echo $mess2; }

// DROP TABLE nsnst_protected_ranges
echo 'Drop '.$prefix.'_nsnst_protected_ranges: ';
$result = mysql_query("DROP TABLE IF EXISTS `".$prefix."_nsnst_protected_ranges`");
if(!$result) { echo $mess1; } else { echo $mess2; }
// CREATE TABLE nsnst_protected_ranges
echo 'Create '.$prefix.'_nsnst_protected_ranges: ';
$result = mysql_query("CREATE TABLE `".$prefix."_nsnst_protected_ranges` (`ip_lo` int(10) unsigned NOT NULL default '0', `ip_hi` int(10) unsigned NOT NULL default '0', `date` int(20) NOT NULL default '0', `notes` text NOT NULL, `c2c` char(2) NOT NULL default '00', PRIMARY KEY (`ip_lo`,`ip_hi`), KEY `c2c` (`c2c`), KEY `date` (`date`))");
if(!$result) { echo $mess1; } else { echo $mess2; }
// Add current admin ip to protected table
echo 'Populate '.$prefix.'_nsnst_protected_ranges: ';
$admin_ip = sprintf("%u", ip2long($nsnst_const['remote_ip']));
$result = mysql_query("INSERT INTO `".$prefix."_nsnst_protected_ranges` VALUES ('$admin_ip', '$admin_ip', '".$nsnst_const['ban_time']."', 'Admin\'s personal ip', '00')");
if(!$result) { echo $mess1; } else { echo $mess2; }

// DROP TABLE nsnst_referers
echo 'Drop '.$prefix.'_nsnst_referers: ';
$result = mysql_query("DROP TABLE IF EXISTS `".$prefix."_nsnst_referers`");
if(!$result) { echo $mess1; } else { echo $mess2; }
// CREATE TABLE nsnst_referers
echo 'Create '.$prefix.'_nsnst_referers: ';
$result = mysql_query("CREATE TABLE `".$prefix."_nsnst_referers` (`rid` int(2) NOT NULL auto_increment, `referer` varchar(255) NOT NULL default '', PRIMARY KEY (`referer`), KEY `rid` (`rid`))");
if(!$result) { echo $mess1; } else { echo $mess2; }
// INSERT INTO TABLE nsnst_referers
echo 'Populate '.$prefix.'_nsnst_referers: ';
$mess = $mess2;
$wfilename = "sql/data/referers.data";
$list_referer = "";
if(file_exists($wfilename)) {
  $wfread = fopen($wfilename, 'r');
  $linecount = 0;
  while (!feof($wfread)) {
    $DataRead = fgets($wfread, 1024);
    $DataRead = ereg_replace ("\r", "", $DataRead);
    $DataRead = ereg_replace ("\n", "", $DataRead);
    $data = explode ("||", $DataRead);
    if($data[0] > "") {
      for($i=0; $i<count($data); $i++) {
        if(!get_magic_quotes_runtime()) { $data[$i] = addslashes($data[$i]); }
      }
      if($list_referer == "") { $list_referer = $data[1]; } else { $list_referer .= "\r\n".$data[1]; }
      $datainserted = False;
      $datainserted = mysql_query("INSERT INTO `".$prefix."_nsnst_referers` VALUES (".$data[0].", '".$data[1]."')");
      if(!$datainserted) { $mess = $mess1; }
    }
  }
  fclose($wfread);
} else {
  $mess = $mess1;
}
echo $mess;
mysql_query("UPDATE `".$prefix."_nsnst_config` SET `config_value`='$list_referer' WHERE `config_name`='list_referer'");

// DROP TABLE nsnst_strings
echo 'Drop '.$prefix.'_nsnst_strings: ';
$result = mysql_query("DROP TABLE IF EXISTS `".$prefix."_nsnst_strings`");
if(!$result) { echo $mess1; } else { echo $mess2; }
// CREATE TABLE nsnst_strings
echo 'Create '.$prefix.'_nsnst_strings: ';
$result = mysql_query("CREATE TABLE `".$prefix."_nsnst_strings` (`sid` int(2) NOT NULL auto_increment, `string` varchar(255) NOT NULL default '', PRIMARY KEY (`string`), KEY `sid` (`sid`))");
if(!$result) { echo $mess1; } else { echo $mess2; }

// DROP TABLE nsnst_tracked_ips
echo 'Drop '.$prefix.'_nsnst_tracked_ips: ';
$result = mysql_query("DROP TABLE IF EXISTS `".$prefix."_nsnst_tracked_ips`");
if(!$result) { echo $mess1; } else { echo $mess2; }
// CREATE TABLE nsnst_tracked_ips
echo 'Create '.$prefix.'_nsnst_tracked_ips: ';
$result = mysql_query("CREATE TABLE `".$prefix."_nsnst_tracked_ips` (`tid` int(10) NOT NULL auto_increment, `ip_addr` varchar(15) NOT NULL default '', `ip_long` INT(10) unsigned NOT NULL default '0', `user_id` int(11) NOT NULL default '1', `username` varchar(60) NOT NULL default '', `user_agent` text NOT NULL, `refered_from` TEXT NOT NULL, `date` int(20) NOT NULL default '0', `page` text NOT NULL, `x_forward_for` varchar(32) NOT NULL default '', `client_ip` varchar(32) NOT NULL default '', `remote_addr` varchar(32) NOT NULL default '', `remote_port` varchar(11) NOT NULL default '', `request_method` varchar(10) NOT NULL default '', `c2c` char(2) NOT NULL default '00', PRIMARY KEY  (`tid`), KEY `ip_addr` (`ip_addr`), KEY `ip_long` (`ip_long`), KEY `user_id` (`user_id`), KEY `username` (`username`), KEY `user_agent` (`user_agent`(255)), KEY `refered_from` (`refered_from`(255)), KEY `date` (`date`), KEY `page` (`page`(255)), KEY `c2c` (`c2c`))");
if(!$result) { echo $mess1; } else { echo $mess2; }
?>