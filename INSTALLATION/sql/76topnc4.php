<?php
# ========================================================
#
# pnc4 SQL Tables
# phpnuke-clan.net
#
# ========================================================

if( !defined('PNC_76TOPNC4')){
die("Access denied!");
}
function mysql_table_exists($table) {
   $exists = mysql_query("SELECT 1 FROM `$table` LIMIT 0");
   if ($exists) return true;
   return false;
}

# --------------------------------------------------------
#
# Dumping data for table '".$prefix."_bbconfig'
#
mysql_query("INSERT INTO ".$prefix."_bbconfig VALUES ('allow_autologin', '1');");
mysql_query("INSERT INTO ".$prefix."_bbconfig VALUES ('login_reset_time', '30');");
mysql_query("INSERT INTO ".$prefix."_bbconfig VALUES ('max_autologin_time', '0');");
mysql_query("INSERT INTO ".$prefix."_bbconfig VALUES ('max_login_attempts', '5');");
mysql_query("INSERT INTO ".$prefix."_bbconfig VALUES ('rand_seed', '2498fc0ea1f5908a140f54b68eac0d3d');");
mysql_query("INSERT INTO ".$prefix."_bbconfig VALUES ('search_flood_interval', '15');");
mysql_query("INSERT INTO ".$prefix."_bbconfig VALUES ('search_min_chars', '3');");
mysql_query("UPDATE ".$prefix."_bbconfig SET config_value='.0.23' where config_name='version'");



# --------------------------------------------------------
#
# Table structure for table '".$prefix."_bbgroups'
#
/*
mysql_query("DROP TABLE IF EXISTS ".$prefix."_bbgroups;");
mysql_query("CREATE TABLE ".$prefix."_bbgroups (
   `group_id` mediumint(8) NOT NULL auto_increment,
   `group_type` tinyint(4) DEFAULT '1' NOT NULL,
   `group_name` varchar(40) NOT NULL,
   `group_description` varchar(255) NOT NULL,
   `group_moderator` mediumint(8) DEFAULT '0' NOT NULL,
   `group_single_user` tinyint(1) DEFAULT '1' NOT NULL,
   PRIMARY KEY (group_id),
   KEY group_single_user (group_single_user)
);");

#
# Dumping data for table '".$prefix."_bbgroups'
#

// 76 // INSERT INTO nuke_bbgroups VALUES (1, 1, 'Anonymous', 'Personal User', 0, 1);
// 76 // INSERT INTO nuke_bbgroups VALUES (3, 2, 'Moderators', 'Moderators of this Forum', 5, 0);
mysql_query("INSERT INTO ".$prefix."_bbgroups VALUES ('1', '1', 'Anonymous', 'Personal User', '0', '1');");
mysql_query("INSERT INTO ".$prefix."_bbgroups VALUES ('2', '2', 'Moderators', 'Moderators of this forum.', '2', '0');");
mysql_query("INSERT INTO ".$prefix."_bbgroups VALUES ('3', '1', '', 'Personal User', '0', '1');");
*/

#
# Table structure for table '".$prefix."_bbsearch_results'
#
$query1 = mysql_query("SHOW COLUMNS FROM ".$prefix."_bbsearch_results LIKE 'search_time'") or die(mysql_error());
         if (mysql_num_rows($query1) == 0) {
         mysql_query("ALTER TABLE ".$prefix."_bbsearch_results ADD search_time int(11) DEFAULT '0' NOT NULL")or die('MySQL said: '.mysql_error());
         echo"Column<b> search_time</b> is added.<br>";}
         else { echo"Column<b> search_time</b> Already exists.<br>";}
/*
mysql_query("DROP TABLE IF EXISTS ".$prefix."_bbsearch_results;");
mysql_query("CREATE TABLE ".$prefix."_bbsearch_results (
   `search_id` int(11) unsigned DEFAULT '0' NOT NULL,
   `session_id` varchar(32) NOT NULL,
   `search_array` text NOT NULL,
   `search_time` int(11) DEFAULT '0' NOT NULL,  ( toevoegen)
   PRIMARY KEY (search_id),
   KEY session_id (session_id)
);");
*/
#
# Dumping data for table '".$prefix."_bbsearch_results'
#


# --------------------------------------------------------
#
# Table structure for table '".$prefix."_bbsessions'
#
 $query1 = mysql_query("SHOW COLUMNS FROM ".$prefix."_bbsessions LIKE 'session_admin'") or die(mysql_error());
         if (mysql_num_rows($query1) == 0) {
         mysql_query("ALTER TABLE ".$prefix."_bbsessions ADD `session_admin` tinyint(2) DEFAULT '0' NOT NULL")or die('MySQL said: '.mysql_error());
         echo"Column<b> session_admin</b> is added.<br>";}
         else { echo"Column<b> session_admin</b> Already exists.<br>";}
/*
mysql_query("DROP TABLE IF EXISTS ".$prefix."_bbsessions;");
mysql_query("CREATE TABLE ".$prefix."_bbsessions (
   `session_id` char(32) NOT NULL,
   `session_user_id` mediumint(8) DEFAULT '0' NOT NULL,
   `session_start` int(11) DEFAULT '0' NOT NULL,
   `session_time` int(11) DEFAULT '0' NOT NULL,
   `session_ip` char(8) DEFAULT '0' NOT NULL,
   `session_page` int(11) DEFAULT '0' NOT NULL,
   `session_logged_in` tinyint(1) DEFAULT '0' NOT NULL,
   `session_admin` tinyint(2) DEFAULT '0' NOT NULL,        (toevoegen)
   PRIMARY KEY (session_id),
   KEY session_user_id (session_user_id),
   KEY session_id_ip_user_id (session_id, session_ip, session_user_id)
);");
 */
# --------------------------------------------------------
#
# Table structure for table '".$prefix."_bbsessions_keys' (helemaal toevoegen)
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_bbsessions_keys;");
mysql_query("CREATE TABLE ".$prefix."_bbsessions_keys (
   `key_id` varchar(32) DEFAULT '0' NOT NULL,
   `user_id` mediumint(8) DEFAULT '0' NOT NULL,
   `last_ip` varchar(8) DEFAULT '0' NOT NULL,
   `last_login` int(11) DEFAULT '0' NOT NULL,
   PRIMARY KEY (key_id, user_id),
   KEY last_login (last_login)
);");

#
# Dumping data for table '".$prefix."_bbsessions_keys'
#


# --------------------------------------------------------
#
# Table structure for table '".$prefix."_bbtopics_watch'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_bbtopics_watch;");
mysql_query("CREATE TABLE ".$prefix."_bbtopics_watch (
   `topic_id` mediumint(8) unsigned DEFAULT '0' NOT NULL,
   `user_id` mediumint(8) DEFAULT '0' NOT NULL,
   `notify_status` tinyint(1) DEFAULT '0' NOT NULL,
   KEY topic_id (topic_id),
   KEY user_id (user_id),
   KEY notify_status (notify_status)
);");

#
# Dumping data for table '".$prefix."_bbtopics_watch'
#


# --------------------------------------------------------
#
# Table structure for table '".$prefix."_bbuser_group'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_bbuser_group;");
mysql_query("CREATE TABLE ".$prefix."_bbuser_group (
   `group_id` mediumint(8) DEFAULT '0' NOT NULL,
   `user_id` mediumint(8) DEFAULT '0' NOT NULL,
   `user_pending` tinyint(1),
   KEY group_id (group_id),
   KEY user_id (user_id)
);");

#
# Dumping data for table '".$prefix."_bbuser_group'
#
//76// INSERT INTO nuke_bbuser_group VALUES (1, -1, 0);
//76// INSERT INTO nuke_bbuser_group VALUES (3, 5, 0);
mysql_query("INSERT INTO ".$prefix."_bbuser_group VALUES ('1', '-1', 0);");
mysql_query("INSERT INTO ".$prefix."_bbuser_group VALUES ('2', '2', 0);");
mysql_query("INSERT INTO ".$prefix."_bbuser_group VALUES ('3', '2', 0);");

# --------------------------------------------------------
#
# Table structure for table '".$prefix."_blocks'
#
$query1 = mysql_query("SHOW COLUMNS FROM ".$prefix."_blocks LIKE 'groups'") or die(mysql_error());
         if (mysql_num_rows($query1) == 0) {
         mysql_query("ALTER TABLE ".$prefix."_blocks ADD `groups` text NOT NULL AFTER view")or die('MySQL said: '.mysql_error());
         echo"Column<b> groups</b> is added.<br>";}
         else { echo"Column<b> subscription</b> Already exists.<br>";}
 $query1 = mysql_query("SHOW COLUMNS FROM ".$prefix."_blocks LIKE 'subscription'") or die(mysql_error());
         if (mysql_num_rows($query1) == 0) {
         mysql_query("ALTER TABLE ".$prefix."_blocks ADD `subscription` int(1) DEFAULT '0' NOT NULL")or die('MySQL said: '.mysql_error());
         echo"Column<b> subscription</b> is added.<br>";}
         else { echo"Column<b> subscription</b> Already exists.<br>";}
 $query1 = mysql_query("SHOW COLUMNS FROM ".$prefix."_blocks LIKE 'display'") or die(mysql_error());
         if (mysql_num_rows($query1) == 0) {
         mysql_query("ALTER TABLE ".$prefix."_blocks ADD `display` varchar(255) DEFAULT 'All' NOT NULL")or die('MySQL said: '.mysql_error());
         echo"Column<b> display</b> is added.<br>";}
         else { echo"Column<b> display</b> Already exists.<br>";}

#
# Dumping data for table '".$prefix."_blocks'
#
# --------------------------------------------------------
#
# Table structure for table '".$prefix."_cnbya_config'
#

if (mysql_table_exists("".$prefix."_cnbya_config")) {
echo"Table <b>".$prefix."_cnbya_config </b> already exists<br>";}
else{
mysql_query("CREATE TABLE ".$prefix."_cnbya_config (
   `config_name` varchar(255) NOT NULL,
   `config_value` longtext,
   UNIQUE config_name (config_name)
);");

#
# Dumping data for table '".$prefix."_cnbya_config'
#

mysql_query("INSERT INTO ".$prefix."_cnbya_config VALUES ('allowmailchange', '0');");
mysql_query("INSERT INTO ".$prefix."_cnbya_config VALUES ('allowuserdelete', '0');");
mysql_query("INSERT INTO ".$prefix."_cnbya_config VALUES ('allowuserreg', '0');");
mysql_query("INSERT INTO ".$prefix."_cnbya_config VALUES ('allowusertheme', '0');");
mysql_query("INSERT INTO ".$prefix."_cnbya_config VALUES ('autosuspend', '0');");
mysql_query("INSERT INTO ".$prefix."_cnbya_config VALUES ('autosuspendmain', '0');");
mysql_query("INSERT INTO ".$prefix."_cnbya_config VALUES ('bad_mail', 'mysite.com\r\nyoursite.com');");
mysql_query("INSERT INTO ".$prefix."_cnbya_config VALUES ('bad_nick', 'adm\r\nadmin\r\nan?imo\r\nanonimo\r\nanonymous\r\ngod\r\nlinux\r\nnobody\r\noperator\r\nroot\r\nstaff\r\nwebmaster');");
mysql_query("INSERT INTO ".$prefix."_cnbya_config VALUES ('codesize', '0');");
mysql_query("INSERT INTO ".$prefix."_cnbya_config VALUES ('cookiecheck', '0');");
mysql_query("INSERT INTO ".$prefix."_cnbya_config VALUES ('cookiecleaner', '1');");
mysql_query("INSERT INTO ".$prefix."_cnbya_config VALUES ('cookieinactivity', '-');");
mysql_query("INSERT INTO ".$prefix."_cnbya_config VALUES ('cookiepath', '');");
mysql_query("INSERT INTO ".$prefix."_cnbya_config VALUES ('cookietimelife', '2592000');");
mysql_query("INSERT INTO ".$prefix."_cnbya_config VALUES ('coppa', '0');");
mysql_query("INSERT INTO ".$prefix."_cnbya_config VALUES ('doublecheckemail', '1');");
mysql_query("INSERT INTO ".$prefix."_cnbya_config VALUES ('emailvalidate', '1');");
mysql_query("INSERT INTO ".$prefix."_cnbya_config VALUES ('expiring', '86400');");
mysql_query("INSERT INTO ".$prefix."_cnbya_config VALUES ('nick_max', '20');");
mysql_query("INSERT INTO ".$prefix."_cnbya_config VALUES ('nick_min', '4');");
mysql_query("INSERT INTO ".$prefix."_cnbya_config VALUES ('pass_max', '20');");
mysql_query("INSERT INTO ".$prefix."_cnbya_config VALUES ('pass_min', '4');");
mysql_query("INSERT INTO ".$prefix."_cnbya_config VALUES ('perpage', '100');");
mysql_query("INSERT INTO ".$prefix."_cnbya_config VALUES ('requireadmin', '0');");
mysql_query("INSERT INTO ".$prefix."_cnbya_config VALUES ('sendaddmail', '0');");
mysql_query("INSERT INTO ".$prefix."_cnbya_config VALUES ('senddeletemail', '0');");
mysql_query("INSERT INTO ".$prefix."_cnbya_config VALUES ('servermail', '1');");
mysql_query("INSERT INTO ".$prefix."_cnbya_config VALUES ('tos', '0');");
mysql_query("INSERT INTO ".$prefix."_cnbya_config VALUES ('tosall', '1');");
mysql_query("INSERT INTO ".$prefix."_cnbya_config VALUES ('useactivate', '0');");
mysql_query("INSERT INTO ".$prefix."_cnbya_config VALUES ('usegfxcheck', '0');");
mysql_query("INSERT INTO ".$prefix."_cnbya_config VALUES ('version', '4.4.2');");
echo"tables for<b>_cnbya_config</b> is added.<br>";
}

# --------------------------------------------------------
#
# Table structure for table '".$prefix."_cnbya_field'
#

if (mysql_table_exists("".$prefix."_cnbya_field")) {
echo"Table <b>".$prefix."_cnbya_field </b> already exists<br>";}
else{
mysql_query("CREATE TABLE ".$prefix."_cnbya_field (
   `fid` int(10) NOT NULL auto_increment,
   `name` varchar(255) DEFAULT 'field' NOT NULL,
   `value` varchar(255),
   `size` int(3),
   `need` int(1) DEFAULT '1' NOT NULL,
   `pos` int(3),
   `public` int(1) DEFAULT '1' NOT NULL,
   PRIMARY KEY (fid),
   KEY fid (fid)
);");
echo"tables for<b>_cnbya_field</b> is added.<br>";
}

#
# Dumping data for table '".$prefix."_cnbya_field'
#


# --------------------------------------------------------
#
# Table structure for table '".$prefix."_cnbya_value'
#

if (mysql_table_exists("".$prefix."_cnbya_value")) {
echo"Table <b>".$prefix."_cnbya_value </b> already exists<br>";}
else{
mysql_query("CREATE TABLE ".$prefix."_cnbya_value (
   `vid` int(10) NOT NULL auto_increment,
   `uid` int(10) DEFAULT '0' NOT NULL,
   `fid` int(10) DEFAULT '0' NOT NULL,
   `value` varchar(255),
   PRIMARY KEY (vid),
   KEY vid (vid)
);");
 echo"tables for<b>_cnbya_value</b> is added.<br>";
}
#
# Dumping data for table '".$prefix."_cnbya_value'
#


# --------------------------------------------------------
#
# Table structure for table '".$prefix."_cnbya_value_temp'
#

if (mysql_table_exists("".$prefix."_cnbya_value_temp")) {
echo"Table <b>".$prefix."_cnbya_value_temp </b> already exists<br>";}
else{
mysql_query("CREATE TABLE ".$prefix."_cnbya_value_temp (
   `vid` int(10) NOT NULL auto_increment,
   `uid` int(10) DEFAULT '0' NOT NULL,
   `fid` int(10) DEFAULT '0' NOT NULL,
   `value` varchar(255),
   PRIMARY KEY (vid),
   KEY vid (vid)
);");
 echo"tables for<b>_cnbya_value_temp</b> is added.<br>";
}
#
# Dumping data for table '".$prefix."_cnbya_value_temp'
#
$query1 = mysql_query("SHOW COLUMNS FROM ".$prefix."_config LIKE 'displayerror'") or die(mysql_error());
         if (mysql_num_rows($query1) == 0) {
         mysql_query("ALTER TABLE ".$prefix."_config ADD `displayerror` tinyint(1) DEFAULT '0' NOT NULL")or die('MySQL said: '.mysql_error());
         echo"Column<b> displayerror</b> is added.<br>";}
         else { echo"Column<b> displayerror</b> Already exists.<br>";}

mysql_query("UPDATE ".$prefix."_config SET  copyright='PHP-Nuke Copyright &copy; 2007 by Francisco Burzi. This is free software, and you may redistribute it under the <a href=\"http://phpnuke.org/files/gpl.txt\"><font class=\"footmsg_l\">GPL</font></a>.<br>Protected by <a href=\"http://www.nukescripts.net\" target=\"_blank\"><img src=\"http://www.nukescripts.net/images/powered/nukesentinel.png\" border=\"0\"><font class=\"footmsg_l\"><b></b></font></a>|Powered by <a href=\"http://www.phpnuke-clan.net\" target=\"_blank\"><img src=\"images/powered/pnctechnology.gif\" border=\"0\"></a><font class=\"footmsg_l\"><b>|PNC ".$pncv. "</b></font></a><br>'");
        mysql_query("UPDATE ".$prefix."_config SET  Version_Num='PNC ".$pncv."'");
# --------------------------------------------------------
#
# Table structure for table '".$prefix."_confirm'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_confirm;");
mysql_query("CREATE TABLE ".$prefix."_confirm (
   `confirm_id` char(32) NOT NULL,
   `session_id` char(32) NOT NULL,
   `code` char(6) NOT NULL,
   PRIMARY KEY (session_id, confirm_id)
);");

#
# Dumping data for table '".$prefix."_confirm'
#


# --------------------------------------------------------
#
# Table structure for table '".$prefix."_counter'
#

if (mysql_table_exists("".$prefix."_counter")) {
echo"Table <b>".$prefix."_counter </b> already exists<br>";}
else{
mysql_query("CREATE TABLE ".$prefix."_counter (
   `type` varchar(80) NOT NULL,
   `var` varchar(80) NOT NULL,
   `count` int(10) unsigned DEFAULT '0' NOT NULL
);");
 echo"tables for<b>counter</b> is added.<br>";
}
#
# Dumping data for table '".$prefix."_counter'
#
mysql_query("INSERT INTO ".$prefix."_headlines VALUES ('35', '--- PHPNUKE-CLAN.NET ---', 'http://www.phpnuke-clan.net/backend.php');");


# -------- Hall OF shame -------
?>
<table>         <tr>
<td><?php echo"".$prefix."_hos_config"; ?></td>
                <td>
<?php if(@mysql_query("CREATE TABLE IF NOT EXISTS ".$prefix."_hos_config (
                               `config_name` varchar(50) NOT NULL default '',
                               `config_value` text NOT NULL,
                                PRIMARY KEY  (`config_name`)
                                )TYPE=MyISAM;")) {
        mysql_query("INSERT INTO ".$prefix."_hos_config VALUES ('date_format', 'Y-m-d H:i:s');");
        mysql_query("INSERT INTO ".$prefix."_hos_config VALUES ('punkssheight', '400');");
        mysql_query("INSERT INTO ".$prefix."_hos_config VALUES ('punksswidth', '400');");
        mysql_query("INSERT INTO ".$prefix."_hos_config VALUES ('punksspath', 'modules/Hall_of_Shame/punkss/');");
        mysql_query("INSERT INTO ".$prefix."_hos_config VALUES ('punkdemopath', 'modules/Hall_of_Shame/punkdemo/');");
        mysql_query("INSERT INTO ".$prefix."_hos_config VALUES ('maxdemo', '500000');");
        mysql_query("INSERT INTO ".$prefix."_hos_config VALUES ('pperpage', '15');");
        mysql_query("INSERT INTO ".$prefix."_hos_config VALUES ('perrow', '5');");
        mysql_query("INSERT INTO ".$prefix."_hos_config VALUES ('search', '30');");
        mysql_query("INSERT INTO ".$prefix."_hos_config VALUES ('maxss', '100000');");
        mysql_query("INSERT INTO ".$prefix."_hos_config VALUES ('ssextallow', '.jpg, .gif');");
        mysql_query("INSERT INTO ".$prefix."_hos_config VALUES ('demoextallow', '.wmv');");
        mysql_query("INSERT INTO ".$prefix."_hos_config VALUES ('version_number', '1.3.1');");
        mysql_query("INSERT INTO ".$prefix."_hos_config VALUES ('mid', 'memberid');");
        mysql_query("INSERT INTO ".$prefix."_hos_config VALUES ('membertable', 'pnc_hos_members');");
        mysql_query("INSERT INTO ".$prefix."_hos_config VALUES ('membername', 'membername');");
        mysql_query("INSERT INTO ".$prefix."_hos_config VALUES ('memberstatus', 'memberstatus');");
        mysql_query("INSERT INTO ".$prefix."_hos_config VALUES ('memberstatusdivider', '0');");
        mysql_query("INSERT INTO ".$prefix."_hos_config VALUES ('memberstatusoperator', '>=');");
        mysql_query("INSERT INTO ".$prefix."_hos_config VALUES ('demoheight', '380');");
        mysql_query("INSERT INTO ".$prefix."_hos_config VALUES ('demowidth', '380');");
        mysql_query("INSERT INTO ".$prefix."_hos_config VALUES ('admsort', 'date_add');");
        mysql_query("INSERT INTO ".$prefix."_hos_config VALUES ('pubsort', 'date_add');");
        mysql_query("INSERT INTO ".$prefix."_hos_config VALUES ('admsortasc', 'DESC');");
        mysql_query("INSERT INTO ".$prefix."_hos_config VALUES ('pubsortasc', 'DESC');");
        mysql_query("INSERT INTO ".$prefix."_hos_config VALUES ('rightblocks', '1');");
                                        echo "<font color=#009900>success</font>";

                                 } else { echo "<font color=#ff0000>Failed</font>"; $allgood = false; }
                        ?>
                </td>
        </tr>
        <tr>
<td><?php echo"".$prefix."_hos_members"; ?></td>
                <td>
  <?php if(@mysql_query("CREATE TABLE IF NOT EXISTS `".$prefix."_hos_members` (
  `memberid` int(11) NOT NULL auto_increment,
  `membername` varchar(120) NOT NULL default '',
  `memberstatus` int(11) NOT NULL default '0',
  PRIMARY KEY  (`memberid`)
);")) {
                                        echo "<font color=#009900>success</font>";

                                 } else { echo "<font color=#ff0000>Failed</font>"; $allgood = false; }
                        ?>
                </td>
        </tr>
        <tr>
<td><?php echo"".$prefix."_hos_punks"; ?></td>
                <td>
  <?php if(@mysql_query("CREATE TABLE IF NOT EXISTS `".$prefix."_hos_punks` (
  `pid` int(11) NOT NULL auto_increment,
  `punkname` varchar(120) NOT NULL default '',
  `punkguid` varchar(120) NOT NULL default '',
  `punkip` varchar(120) NOT NULL default '',
  `punkreason` int(11) NOT NULL default '0',
  `punkbannedby` int(11) NOT NULL default '0',
  `punksslabel` varchar(255) NOT NULL default '',
  `punkss` varchar(255) NOT NULL default '',
  `punkdemolabel` varchar(255) NOT NULL default '',
  `punkdemo` varchar(255) NOT NULL default '',
  `punknotes` varchar(255) NOT NULL default '',
  `date_add` int(20) NOT NULL default '0',
  `date_edit` int(20) NOT NULL default '0',
  PRIMARY KEY  (`pid`)
);")) {
                                        echo "<font color=#009900>success</font>";

                                 } else { echo "<font color=#ff0000>Failed</font>"; $allgood = false; }
                        ?>


        <tr>
<td><?php echo"".$prefix."_hos_reasons"; ?></td>
                <td>
  <?php if(mysql_query("CREATE TABLE IF NOT EXISTS `".$prefix."_hos_reasons` (
  `rid` int(11) NOT NULL auto_increment,
  `title` varchar(120) NOT NULL default '',
  `rdesc` varchar(255) NOT NULL default '',
  `rpid` int(11) NOT NULL default '0',
  PRIMARY KEY  (`rid`)
);")) {
                                        echo "<font color=#009900>success</font>";

                                 } else { echo "<font color=#ff0000>Failed</font>"; $allgood = false; }
   ?>
    </td></tr> <table>
<?php
# --------------------------------------------------------
#
# Table structure for table '".$prefix."_mapcat'
#


if (mysql_table_exists("".$prefix."_mapcat")) {
        echo"Table <b>".$prefix."_mapcat </b> already exists<br>";}
        else{mysql_query("CREATE TABLE ".$prefix."_mapcat (
   `id` int(11) NOT NULL auto_increment,
   `title` varchar(100) NOT NULL,
   `details` text NOT NULL,
   `mainid` int(11) DEFAULT '0' NOT NULL,
   `image` varchar(100) NOT NULL,
   PRIMARY KEY (id))")          or die('MySQL said: '.mysql_error());
        echo"Table <b>".$prefix."_mapcat</b> has been created.<br>";}

#
# Dumping data for table '".$prefix."_mapcat'
#


# --------------------------------------------------------
#
# Table structure for table '".$prefix."_mapconfig'
#

if (mysql_table_exists("".$prefix."_mapconfig")) {
        echo"Table <b>".$prefix."_mapconfig </b> already exists<br>";}
        else{mysql_query("CREATE TABLE ".$prefix."_mapconfig (
   `mname` varchar(20) NOT NULL,
   `mval` varchar(100) NOT NULL)") or die('MySQL said: '.mysql_error());


#
# Dumping data for table '".$prefix."_mapconfig'
#

mysql_query("INSERT INTO ".$prefix."_mapconfig VALUES ('a_submit', '1');");
mysql_query("INSERT INTO ".$prefix."_mapconfig VALUES ('a_upload', '1');");
mysql_query("INSERT INTO ".$prefix."_mapconfig VALUES ('a_group', '1');");
mysql_query("INSERT INTO ".$prefix."_mapconfig VALUES ('a_rate', '1');");
mysql_query("INSERT INTO ".$prefix."_mapconfig VALUES ('a_anon', '1');");
mysql_query("INSERT INTO ".$prefix."_mapconfig VALUES ('a_review', '1');");
mysql_query("INSERT INTO ".$prefix."_mapconfig VALUES ('c_img', 'modules/Maps/images/cat');");
mysql_query("INSERT INTO ".$prefix."_mapconfig VALUES ('m_img', 'modules/Maps/images/maps');");
mysql_query("INSERT INTO ".$prefix."_mapconfig VALUES ('m_file', 'modules/Maps/maps');");
mysql_query("INSERT INTO ".$prefix."_mapconfig VALUES ('temp', 'modules/Maps/temp');");
mysql_query("INSERT INTO ".$prefix."_mapconfig VALUES ('a_ftypes', 'jpg, png, gif, zip, rar');");
mysql_query("INSERT INTO ".$prefix."_mapconfig VALUES ('m_page', '10');");
mysql_query("INSERT INTO ".$prefix."_mapconfig VALUES ('d_limit', '100');");
mysql_query("INSERT INTO ".$prefix."_mapconfig VALUES ('s_limit', '10');");
mysql_query("INSERT INTO ".$prefix."_mapconfig VALUES ('c_thumbw', '120');");
mysql_query("INSERT INTO ".$prefix."_mapconfig VALUES ('c_thumbh', '90');");
mysql_query("INSERT INTO ".$prefix."_mapconfig VALUES ('m_thumbw', '120');");
mysql_query("INSERT INTO ".$prefix."_mapconfig VALUES ('m_thumbh', '90');");
mysql_query("INSERT INTO ".$prefix."_mapconfig VALUES ('g_thumbw', '120');");
mysql_query("INSERT INTO ".$prefix."_mapconfig VALUES ('g_thumbh', '90');");
mysql_query("INSERT INTO ".$prefix."_mapconfig VALUES ('a_submit', '1');");
mysql_query("INSERT INTO ".$prefix."_mapconfig VALUES ('a_upload', '1');");
mysql_query("INSERT INTO ".$prefix."_mapconfig VALUES ('a_group', '1');");
mysql_query("INSERT INTO ".$prefix."_mapconfig VALUES ('a_rate', '1');");
mysql_query("INSERT INTO ".$prefix."_mapconfig VALUES ('a_anon', '1');");
mysql_query("INSERT INTO ".$prefix."_mapconfig VALUES ('a_review', '1');");
mysql_query("INSERT INTO ".$prefix."_mapconfig VALUES ('c_img', 'modules/Maps/images/cat');");
mysql_query("INSERT INTO ".$prefix."_mapconfig VALUES ('m_img', 'modules/Maps/images/maps');");
mysql_query("INSERT INTO ".$prefix."_mapconfig VALUES ('m_file', 'modules/Maps/maps');");
mysql_query("INSERT INTO ".$prefix."_mapconfig VALUES ('temp', 'modules/Maps/temp');");
mysql_query("INSERT INTO ".$prefix."_mapconfig VALUES ('a_ftypes', 'jpg, png, gif, zip, rar');");
mysql_query("INSERT INTO ".$prefix."_mapconfig VALUES ('m_page', '10');");
mysql_query("INSERT INTO ".$prefix."_mapconfig VALUES ('d_limit', '100');");
mysql_query("INSERT INTO ".$prefix."_mapconfig VALUES ('s_limit', '10');");
mysql_query("INSERT INTO ".$prefix."_mapconfig VALUES ('c_thumbw', '120');");
mysql_query("INSERT INTO ".$prefix."_mapconfig VALUES ('c_thumbh', '90');");
mysql_query("INSERT INTO ".$prefix."_mapconfig VALUES ('m_thumbw', '120');");
mysql_query("INSERT INTO ".$prefix."_mapconfig VALUES ('m_thumbh', '90');");
mysql_query("INSERT INTO ".$prefix."_mapconfig VALUES ('g_thumbw', '120');");
mysql_query("INSERT INTO ".$prefix."_mapconfig VALUES ('g_thumbh', '90');");
mysql_query("INSERT INTO ".$prefix."_mapconfig VALUES ('a_submit', '1');");
mysql_query("INSERT INTO ".$prefix."_mapconfig VALUES ('a_upload', '1');");
mysql_query("INSERT INTO ".$prefix."_mapconfig VALUES ('a_group', '1');");
mysql_query("INSERT INTO ".$prefix."_mapconfig VALUES ('a_rate', '1');");
mysql_query("INSERT INTO ".$prefix."_mapconfig VALUES ('a_anon', '0');");
mysql_query("INSERT INTO ".$prefix."_mapconfig VALUES ('a_review', '1');");
mysql_query("INSERT INTO ".$prefix."_mapconfig VALUES ('c_img', 'modules/Maps/images/cat');");
mysql_query("INSERT INTO ".$prefix."_mapconfig VALUES ('m_img', 'modules/Maps/images/maps');");
mysql_query("INSERT INTO ".$prefix."_mapconfig VALUES ('m_file', 'modules/Maps/maps');");
mysql_query("INSERT INTO ".$prefix."_mapconfig VALUES ('temp', 'modules/Maps/temp');");
mysql_query("INSERT INTO ".$prefix."_mapconfig VALUES ('a_ftypes', 'jpg, png, gif, zip, rar');");
mysql_query("INSERT INTO ".$prefix."_mapconfig VALUES ('m_page', '2');");
mysql_query("INSERT INTO ".$prefix."_mapconfig VALUES ('d_limit', '100');");
mysql_query("INSERT INTO ".$prefix."_mapconfig VALUES ('s_limit', '10');");
mysql_query("INSERT INTO ".$prefix."_mapconfig VALUES ('c_thumbw', '120');");
mysql_query("INSERT INTO ".$prefix."_mapconfig VALUES ('c_thumbh', '90');");
mysql_query("INSERT INTO ".$prefix."_mapconfig VALUES ('m_thumbw', '120');");
mysql_query("INSERT INTO ".$prefix."_mapconfig VALUES ('m_thumbh', '90');");
mysql_query("INSERT INTO ".$prefix."_mapconfig VALUES ('g_thumbw', '120');");
mysql_query("INSERT INTO ".$prefix."_mapconfig VALUES ('g_thumbh', '90');");

echo"Table <b>".$prefix."_mapcat</b> has been created.<br>";}
# --------------------------------------------------------
#
# Table structure for table '".$prefix."_mapmap'
#

if (mysql_table_exists("".$prefix."_mapmap")) {
        echo"Table <b>".$prefix."_mapmap </b> already exists<br>";}
        else{mysql_query("CREATE TABLE ".$prefix."_mapmap (
   `mapid` int(11) NOT NULL auto_increment,
   `cat` int(11) DEFAULT '0' NOT NULL,
   `title` varchar(100) NOT NULL,
   `details` text NOT NULL,
   `author` varchar(30) NOT NULL,
   `authemail` varchar(60) NOT NULL,
   `recplayers` varchar(10) NOT NULL,
   `image` varchar(100) NOT NULL,
   `mapfile` varchar(255) NOT NULL,
   `hits` int(11) DEFAULT '0' NOT NULL,
   `filesize` int(20) DEFAULT '0' NOT NULL,
   PRIMARY KEY (mapid),
   KEY mapid (mapid),
   KEY cat (cat))") or die('MySQL said: '.mysql_error());
echo"Table <b>".$prefix."_mapmap</b> has been created.<br>";}
#
# Dumping data for table '".$prefix."_mapmap'
#


# --------------------------------------------------------
#
# Table structure for table '".$prefix."_mapreviews'
#

if (mysql_table_exists("".$prefix."_mapreviews")) {
        echo"Table <b>".$prefix."_mapreviews </b> already exists<br>";}
        else{mysql_query("CREATE TABLE ".$prefix."_mapreviews (
   `rid` int(11) NOT NULL auto_increment,
   `rmapid` int(11) DEFAULT '0' NOT NULL,
   `ruserid` int(11) DEFAULT '0' NOT NULL,
   `ruserip` varchar(15) NOT NULL,
   `rdate` varchar(20) NOT NULL,
   `review` text NOT NULL,
   `rapprove` int(1) DEFAULT '0' NOT NULL,
   PRIMARY KEY (rid)
)") or die('MySQL said: '.mysql_error());
echo"Table <b>".$prefix."_mapreviews</b> has been created.<br>";}

#
# Dumping data for table '".$prefix."_mapreviews'
#


# --------------------------------------------------------
#
# Table structure for table '".$prefix."_maptemp'
#

if (mysql_table_exists("".$prefix."_maptemp")) {
        echo"Table <b>".$prefix."_maptemp </b> already exists<br>";}
        else{mysql_query("CREATE TABLE ".$prefix."_maptemp (
   `rid` int(11) NOT NULL auto_increment,
   `rcat` int(11) DEFAULT '0' NOT NULL,
   `rtitle` varchar(100) NOT NULL,
   `rdetails` text NOT NULL,
   `rauthor` varchar(30) NOT NULL,
   `rauthore` varchar(60) NOT NULL,
   `rrecplay` varchar(10) NOT NULL,
   `rimage` varchar(100) NOT NULL,
   `rmapfile` varchar(100) NOT NULL,
   `rsubmitter` varchar(40) NOT NULL,
   `rsubmitterip` varchar(40) NOT NULL,
   `rdate` int(20) DEFAULT '0' NOT NULL,
   PRIMARY KEY (rid)
)") or die('MySQL said: '.mysql_error());
echo"Table <b>".$prefix."_maptemp</b> has been created.<br>";}

#
# Dumping data for table '".$prefix."_maptemp'
#


# --------------------------------------------------------
#
# Table structure for table '".$prefix."_mapvoters'
#

if (mysql_table_exists("".$prefix."_mapvoters")) {
        echo"Table <b>".$prefix."_mapvoters </b> already exists<br>";}
        else{mysql_query("CREATE TABLE ".$prefix."_mapvoters (
   `id` int(11) NOT NULL auto_increment,
   `mapid` int(11) DEFAULT '0' NOT NULL,
   `user` varchar(60) NOT NULL,
   PRIMARY KEY (id)
)") or die('MySQL said: '.mysql_error());
echo"Table <b>".$prefix."_mapvoters</b> has been created.<br>";}

#
# Dumping data for table '".$prefix."_mapvoters'
#


# --------------------------------------------------------
#
# Table structure for table '".$prefix."_mapvotes'
#

if (mysql_table_exists("".$prefix."_mapvotes")) {
        echo"Table <b>".$prefix."_mapvotes </b> already exists<br>";}
        else{
mysql_query("CREATE TABLE ".$prefix."_mapvotes (
   `vid` int(11) NOT NULL auto_increment,
   `mapid` int(11) DEFAULT '0' NOT NULL,
   `rating` float DEFAULT '0' NOT NULL,
   `totalvotes` int(11) DEFAULT '0' NOT NULL,
   `empty` varchar(111) NOT NULL,
   PRIMARY KEY (vid),
   KEY mapid (mapid)
)") or die('MySQL said: '.mysql_error());
echo"Table <b>".$prefix."_mapvotes</b> has been created.<br>";}


# --------------------------------------------------------
#
# Table structure for table '".$prefix."_message'
#
  $query1 = mysql_query("SHOW COLUMNS FROM ".$prefix."_message LIKE 'groups'") or die(mysql_error());
         if (mysql_num_rows($query1) == 0) {
         mysql_query("ALTER TABLE ".$prefix."_message ADD `groups` text NOT NULL AFTER view")or die('MySQL said: '.mysql_error());}
         else { echo"Column<b> groups</b> Already exists.<br>";}
# --------------------------------------------------------
#
#-- Table structure for table '".$prefix."_modules'
#
  $query1 = mysql_query("SHOW COLUMNS FROM ".$prefix."_modules LIKE 'groups'") or die(mysql_error());
         if (mysql_num_rows($query1) == 0) {
         mysql_query("ALTER TABLE ".$prefix."_modules ADD `groups` text NOT NULL AFTER view")or die('MySQL said: '.mysql_error());}
         else { echo"Column<b> groups</b> Already exists.<br>";}
  $query1 = mysql_query("SHOW COLUMNS FROM ".$prefix."_modules LIKE 'mcid'") or die(mysql_error());
         if (mysql_num_rows($query1) == 0) {
         mysql_query("ALTER TABLE ".$prefix."_modules ADD `mcid` int(11) DEFAULT '1' NOT NULL AFTER mod_group")or die('MySQL said: '.mysql_error());}
         else { echo"Column<b> mcid</b> Already exists.<br>";}
# --------------------------------------------------------
#
# Table structure for table '".$prefix."_modules_categories'
#

  if (mysql_table_exists("".$prefix."_modules_categories")) {
echo"Table <b>".$prefix."_modules_categories </b> already exists, that's ok :)<br>";}
else{
mysql_query("CREATE TABLE ".$prefix."_modules_categories (
   `mcid` int(11) NOT NULL auto_increment,
   `mcname` varchar(60) NOT NULL,
   `visible` int(1) DEFAULT '1' NOT NULL,
   PRIMARY KEY (mcid),
   KEY mcid (mcid),
   KEY mcname (mcname)
);");

#
# Dumping data for table '".$prefix."_modules_categories'
#

mysql_query("INSERT INTO ".$prefix."_modules_categories VALUES ('1', 'General', '1');");
mysql_query("INSERT INTO ".$prefix."_modules_categories VALUES ('2', 'Community', '1');");
mysql_query("INSERT INTO ".$prefix."_modules_categories VALUES ('3', 'Members', '1');");
  }
# --------------------------------------------------------
#
# Table structure for table '".$prefix."_nsncb_blocks'
#

  if (mysql_table_exists("".$prefix."_nsncb_blocks")) {
echo"Table <b>".$prefix."_nsncb_blocks </b> already exists, that's ok :)<br>";}
else{
mysql_query("CREATE TABLE ".$prefix."_nsncb_blocks (
   `rid` tinyint(2) DEFAULT '0' NOT NULL,
   `cgid` tinyint(2) DEFAULT '0' NOT NULL,
   `cbid` tinyint(2) DEFAULT '0' NOT NULL,
   `title` varchar(60) NOT NULL,
   `filename` varchar(255) NOT NULL,
   `content` text NOT NULL,
   `wtype` tinyint(1) DEFAULT '0' NOT NULL,
   `width` smallint(6) DEFAULT '0' NOT NULL,
   PRIMARY KEY (rid),
   UNIQUE rid (rid)
);");

#
# Dumping data for table '".$prefix."_nsncb_blocks'
#

mysql_query("INSERT INTO ".$prefix."_nsncb_blocks VALUES ('1', '1', '1', 'Place Holder', '', 'This is only a place holder', '1', '25');");
mysql_query("INSERT INTO ".$prefix."_nsncb_blocks VALUES ('2', '1', '2', 'Place Holder', '', 'This is only a place holder', '1', '25');");
mysql_query("INSERT INTO ".$prefix."_nsncb_blocks VALUES ('3', '1', '3', 'Place Holder', '', 'This is only a place holder', '1', '25');");
mysql_query("INSERT INTO ".$prefix."_nsncb_blocks VALUES ('4', '1', '4', 'Place Holder', '', 'This is only a place holder', '1', '25');");
mysql_query("INSERT INTO ".$prefix."_nsncb_blocks VALUES ('5', '2', '1', 'Squery tiny', '', '', '1', '25');");
mysql_query("INSERT INTO ".$prefix."_nsncb_blocks VALUES ('6', '2', '2', 'Login', '', '', '1', '25');");
mysql_query("INSERT INTO ".$prefix."_nsncb_blocks VALUES ('7', '2', '3', 'Place Holder', '', 'This is only a place holder', '1', '25');");
mysql_query("INSERT INTO ".$prefix."_nsncb_blocks VALUES ('8', '2', '4', 'Place Holder', '', 'This is only a place holder', '1', '25');");
mysql_query("INSERT INTO ".$prefix."_nsncb_blocks VALUES ('9', '3', '1', 'Place Holder', '', 'This is only a place holder', '1', '25');");
mysql_query("INSERT INTO ".$prefix."_nsncb_blocks VALUES ('10', '3', '2', 'Place Holder', '', 'This is only a place holder', '1', '25');");
mysql_query("INSERT INTO ".$prefix."_nsncb_blocks VALUES ('11', '3', '3', 'Place Holder', '', 'This is only a place holder', '1', '25');");
mysql_query("INSERT INTO ".$prefix."_nsncb_blocks VALUES ('12', '3', '4', 'Place Holder', '', 'This is only a place holder', '1', '25');");
mysql_query("INSERT INTO ".$prefix."_nsncb_blocks VALUES ('13', '4', '1', 'Place Holder', '', 'This is only a place holder', '1', '25');");
mysql_query("INSERT INTO ".$prefix."_nsncb_blocks VALUES ('14', '4', '2', 'Place Holder', '', 'This is only a place holder', '1', '25');");
mysql_query("INSERT INTO ".$prefix."_nsncb_blocks VALUES ('15', '4', '3', 'Place Holder', '', 'This is only a place holder', '1', '25');");
mysql_query("INSERT INTO ".$prefix."_nsncb_blocks VALUES ('16', '4', '4', 'Place Holder', '', 'This is only a place holder', '1', '25');");
}
# --------------------------------------------------------
#
# Table structure for table '".$prefix."_nsncb_config'
#

  if (mysql_table_exists("".$prefix."_nsncb_config")) {
echo"Table <b>".$prefix."_nsncb_config </b> already exists, that's ok :)<br>";}
else{
mysql_query("CREATE TABLE ".$prefix."_nsncb_config (
   `cgid` tinyint(1) DEFAULT '0' NOT NULL,
   `enabled` tinyint(1) DEFAULT '0' NOT NULL,
   `height` smallint(6) DEFAULT '0' NOT NULL,
   `count` tinyint(1) DEFAULT '0' NOT NULL,
   PRIMARY KEY (cgid),
   UNIQUE cfgid (cgid)
);");

#
# Dumping data for table '".$prefix."_nsncb_config'
#

mysql_query("INSERT INTO ".$prefix."_nsncb_config VALUES ('1', '1', '0', '2');");
mysql_query("INSERT INTO ".$prefix."_nsncb_config VALUES ('2', '0', '0', '1');");
mysql_query("INSERT INTO ".$prefix."_nsncb_config VALUES ('3', '0', '0', '0');");
mysql_query("INSERT INTO ".$prefix."_nsncb_config VALUES ('4', '0', '0', '0');");
}
# --------------------------------------------------------
#
# Table structure for table '".$prefix."_nsngd_accesses'
#

  if (mysql_table_exists("".$prefix."_nsngd_accesses")) {
echo"Table <b>".$prefix."_nsngd_accesses </b> already exists, that's ok :)<br>";}
else{
mysql_query("CREATE TABLE ".$prefix."_nsngd_accesses (
   `username` varchar(60) NOT NULL,
   `downloads` int(11) DEFAULT '0' NOT NULL,
   `uploads` int(11) DEFAULT '0' NOT NULL,
   PRIMARY KEY (username)
);");
   }
#
# Dumping data for table '".$prefix."_nsngd_accesses'
#


# --------------------------------------------------------
#
# Table structure for table '".$prefix."_nsngd_categories'
#

  if (mysql_table_exists("".$prefix."_nsngd_categories")) {
echo"Table <b>".$prefix."_nsngd_categories </b> already exists, that's ok :)<br>";}
else{
mysql_query("CREATE TABLE ".$prefix."_nsngd_categories (
   `cid` int(11) NOT NULL auto_increment,
   `title` varchar(50) NOT NULL,
   `cdescription` text NOT NULL,
   `parentid` int(11) DEFAULT '0' NOT NULL,
   `whoadd` tinyint(2) DEFAULT '0' NOT NULL,
   `uploaddir` varchar(255) NOT NULL,
   `canupload` tinyint(2) DEFAULT '0' NOT NULL,
   `active` tinyint(2) DEFAULT '1' NOT NULL,
   PRIMARY KEY (cid),
   KEY cid (cid),
   KEY title (title)
);");
 }
#
# Dumping data for table '".$prefix."_nsngd_categories'
#


# --------------------------------------------------------
#
# Table structure for table '".$prefix."_nsngd_config'
#

  if (mysql_table_exists("".$prefix."_nsngd_config")) {
echo"Table <b>".$prefix."_nsngd_config</b> already exists, that's ok :)<br>";}
else{
mysql_query("CREATE TABLE ".$prefix."_nsngd_config (
   `config_name` varchar(255) NOT NULL,
   `config_value` text NOT NULL,
   PRIMARY KEY (config_name)
);");

#
# Dumping data for table '".$prefix."_nsngd_config'
#

mysql_query("INSERT INTO ".$prefix."_nsngd_config VALUES ('admperpage', '50');");
mysql_query("INSERT INTO ".$prefix."_nsngd_config VALUES ('blockunregmodify', '0');");
mysql_query("INSERT INTO ".$prefix."_nsngd_config VALUES ('dateformat', 'D M j G:i:s T Y');");
mysql_query("INSERT INTO ".$prefix."_nsngd_config VALUES ('mostpopular', '25');");
mysql_query("INSERT INTO ".$prefix."_nsngd_config VALUES ('mostpopulartrig', '0');");
mysql_query("INSERT INTO ".$prefix."_nsngd_config VALUES ('perpage', '10');");
mysql_query("INSERT INTO ".$prefix."_nsngd_config VALUES ('popular', '500');");
mysql_query("INSERT INTO ".$prefix."_nsngd_config VALUES ('results', '10');");
mysql_query("INSERT INTO ".$prefix."_nsngd_config VALUES ('show_download', '0');");
mysql_query("INSERT INTO ".$prefix."_nsngd_config VALUES ('show_links_num', '0');");
mysql_query("INSERT INTO ".$prefix."_nsngd_config VALUES ('usegfxcheck', '0');");
mysql_query("INSERT INTO ".$prefix."_nsngd_config VALUES ('version_number', '1.0.0');");
  }
# --------------------------------------------------------
#
# Table structure for table '".$prefix."_nsngd_downloads'
#

  if (mysql_table_exists("".$prefix."_nsngd_downloads")) {
echo"Table <b>".$prefix."_nsngd_downloads</b> already exists, that's ok :)<br>";}
else{
mysql_query("CREATE TABLE ".$prefix."_nsngd_downloads (
   `lid` int(11) NOT NULL auto_increment,
   `cid` int(11) DEFAULT '0' NOT NULL,
   `sid` int(11) DEFAULT '0' NOT NULL,
   `title` varchar(100) NOT NULL,
   `url` varchar(255) NOT NULL,
   `description` text NOT NULL,
   `date` datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
   `name` varchar(100) NOT NULL,
   `email` varchar(100) NOT NULL,
   `hits` int(11) DEFAULT '0' NOT NULL,
   `submitter` varchar(60) NOT NULL,
   `sub_ip` varchar(16) DEFAULT '0.0.0.0' NOT NULL,
   `filesize` bigint(20) DEFAULT '0' NOT NULL,
   `version` varchar(20) NOT NULL,
   `homepage` varchar(255) NOT NULL,
   `active` tinyint(2) DEFAULT '1' NOT NULL,
   PRIMARY KEY (lid),
   KEY lid (lid),
   KEY cid (cid),
   KEY sid (sid),
   KEY title (title)
);");
 }
#
# Dumping data for table '".$prefix."_nsngd_downloads'
#


# --------------------------------------------------------
#
# Table structure for table '".$prefix."_nsngd_extensions'
#

  if (mysql_table_exists("".$prefix."_nsngd_extensions")) {
echo"Table <b>".$prefix."_nsngd_extensions</b> already exists, that's ok :)<br>";}
else{
mysql_query("CREATE TABLE ".$prefix."_nsngd_extensions (
   `eid` int(11) NOT NULL auto_increment,
   `ext` varchar(6) NOT NULL,
   `file` tinyint(1) DEFAULT '0' NOT NULL,
   `image` tinyint(1) DEFAULT '0' NOT NULL,
   PRIMARY KEY (eid),
   KEY ext (eid)
);");

#
# Dumping data for table '".$prefix."_nsngd_extensions'
#

mysql_query("INSERT INTO ".$prefix."_nsngd_extensions VALUES ('1', '.ace', '1', '0');");
mysql_query("INSERT INTO ".$prefix."_nsngd_extensions VALUES ('2', '.arj', '1', '0');");
mysql_query("INSERT INTO ".$prefix."_nsngd_extensions VALUES ('3', '.bz', '1', '0');");
mysql_query("INSERT INTO ".$prefix."_nsngd_extensions VALUES ('4', '.bz2', '1', '0');");
mysql_query("INSERT INTO ".$prefix."_nsngd_extensions VALUES ('5', '.cab', '1', '0');");
mysql_query("INSERT INTO ".$prefix."_nsngd_extensions VALUES ('6', '.exe', '1', '0');");
mysql_query("INSERT INTO ".$prefix."_nsngd_extensions VALUES ('7', '.gif', '0', '1');");
mysql_query("INSERT INTO ".$prefix."_nsngd_extensions VALUES ('8', '.gz', '1', '0');");
mysql_query("INSERT INTO ".$prefix."_nsngd_extensions VALUES ('9', '.iso', '1', '0');");
mysql_query("INSERT INTO ".$prefix."_nsngd_extensions VALUES ('10', '.jpeg', '0', '1');");
mysql_query("INSERT INTO ".$prefix."_nsngd_extensions VALUES ('11', '.jpg', '0', '1');");
mysql_query("INSERT INTO ".$prefix."_nsngd_extensions VALUES ('12', '.lha', '1', '0');");
mysql_query("INSERT INTO ".$prefix."_nsngd_extensions VALUES ('13', '.lzh', '1', '0');");
mysql_query("INSERT INTO ".$prefix."_nsngd_extensions VALUES ('14', '.png', '0', '1');");
mysql_query("INSERT INTO ".$prefix."_nsngd_extensions VALUES ('15', '.rar', '1', '0');");
mysql_query("INSERT INTO ".$prefix."_nsngd_extensions VALUES ('16', '.tar', '1', '0');");
mysql_query("INSERT INTO ".$prefix."_nsngd_extensions VALUES ('17', '.tgz', '1', '0');");
mysql_query("INSERT INTO ".$prefix."_nsngd_extensions VALUES ('18', '.uue', '1', '0');");
mysql_query("INSERT INTO ".$prefix."_nsngd_extensions VALUES ('19', '.zip', '1', '0');");
mysql_query("INSERT INTO ".$prefix."_nsngd_extensions VALUES ('20', '.zoo', '1', '0');");
}

# --------------------------------------------------------
#
# Table structure for table '".$prefix."_bbthemes'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_bbthemes;");
mysql_query("CREATE TABLE ".$prefix."_bbthemes (
   `themes_id` mediumint(8) unsigned NOT NULL auto_increment,
   `template_name` varchar(30) NOT NULL,
   `style_name` varchar(30) NOT NULL,
   `head_stylesheet` varchar(100),
   `body_background` varchar(100),
   `body_bgcolor` varchar(6),
   `body_text` varchar(6),
   `body_link` varchar(6),
   `body_vlink` varchar(6),
   `body_alink` varchar(6),
   `body_hlink` varchar(6),
   `tr_color1` varchar(6),
   `tr_color2` varchar(6),
   `tr_color3` varchar(6),
   `tr_class1` varchar(25),
   `tr_class2` varchar(25),
   `tr_class3` varchar(25),
   `th_color1` varchar(6),
   `th_color2` varchar(6),
   `th_color3` varchar(6),
   `th_class1` varchar(25),
   `th_class2` varchar(25),
   `th_class3` varchar(25),
   `td_color1` varchar(6),
   `td_color2` varchar(6),
   `td_color3` varchar(6),
   `td_class1` varchar(25),
   `td_class2` varchar(25),
   `td_class3` varchar(25),
   `fontface1` varchar(50),
   `fontface2` varchar(50),
   `fontface3` varchar(50),
   `fontsize1` tinyint(4),
   `fontsize2` tinyint(4),
   `fontsize3` tinyint(4),
   `fontcolor1` varchar(6),
   `fontcolor2` varchar(6),
   `fontcolor3` varchar(6),
   `span_class1` varchar(25),
   `span_class2` varchar(25),
   `span_class3` varchar(25),
   `img_size_poll` smallint(5) unsigned,
   `img_size_privmsg` smallint(5) unsigned,
   PRIMARY KEY (themes_id)
);");

#
# Dumping data for table '".$prefix."_bbthemes'
#

mysql_query("INSERT INTO ".$prefix."_bbthemes VALUES (1, 'subSilver', 'subSilver', 'subSilver.css', '', 'f0f907', '000000', 'ab3603', '1a6503', '', 'DD6900', 'd8d8d8', 'b0afaf', 'D1D7DC', '03f820', '03f820', '03f820', '96a1a6', '000000', 'FFFFFF', 'cellpic1.gif', 'cellpic3.gif', 'cellpic2.jpg', 'FAFAFA', 'FFFFFF', '03f820', 'row1', 'row2', 'row3', 'Verdana, Arial, Helvetica, sans-serif', 'Trebuchet MS', 'Courier, ''Courier New'', sans-serif', 10, 11, 12, '444444', '006600', 'ffa303', 'cattitle', 'cattitle', 'cattitle', NULL, NULL);");


# --------------------------------------------------------
#
# Table structure for table '".$prefix."_nsngd_mods'
#

  if (mysql_table_exists("".$prefix."_nsngd_mods")) {
echo"Table <b>".$prefix."_nsngd_mods</b> already exists, that's ok :)<br>";}
else{
mysql_query("CREATE TABLE ".$prefix."_nsngd_mods (
   `rid` int(11) NOT NULL auto_increment,
   `lid` int(11) DEFAULT '0' NOT NULL,
   `cid` int(11) DEFAULT '0' NOT NULL,
   `sid` int(11) DEFAULT '0' NOT NULL,
   `title` varchar(100) NOT NULL,
   `url` varchar(255) NOT NULL,
   `description` text NOT NULL,
   `modifier` varchar(60) NOT NULL,
   `sub_ip` varchar(16) DEFAULT '0.0.0.0' NOT NULL,
   `brokendownload` int(3) DEFAULT '0' NOT NULL,
   `name` varchar(100) NOT NULL,
   `email` varchar(100) NOT NULL,
   `filesize` bigint(20) DEFAULT '0' NOT NULL,
   `version` varchar(20) NOT NULL,
   `homepage` varchar(255) NOT NULL,
   PRIMARY KEY (rid),
   UNIQUE rid (rid)
);");
  }
#
# Dumping data for table '".$prefix."_nsngd_mods'
#

# --------------------------------------------------------
#
# Table structure for table '".$prefix."_nsngd_new'
#

  if (mysql_table_exists("".$prefix."_nsngr_new")) {
echo"Table <b>".$prefix."_nsngr_new</b> already exists, that's ok :)<br>";}
else{
mysql_query("CREATE TABLE ".$prefix."_nsngd_new (
   `lid` int(11) NOT NULL auto_increment,
   `cid` int(11) DEFAULT '0' NOT NULL,
   `sid` int(11) DEFAULT '0' NOT NULL,
   `title` varchar(100) NOT NULL,
   `url` varchar(255) NOT NULL,
   `description` text NOT NULL,
   `date` datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
   `name` varchar(100) NOT NULL,
   `email` varchar(100) NOT NULL,
   `submitter` varchar(60) NOT NULL,
   `sub_ip` varchar(16) DEFAULT '0.0.0.0' NOT NULL,
   `filesize` bigint(20) DEFAULT '0' NOT NULL,
   `version` varchar(20) NOT NULL,
   `homepage` varchar(255) NOT NULL,
   PRIMARY KEY (lid),
   KEY lid (lid),
   KEY cid (cid),
   KEY sid (sid),
   KEY title (title)
);");
}
#
# Dumping data for table '".$prefix."_nsngd_new'
#


# --------------------------------------------------------
#
# Table structure for table '".$prefix."_nsngr_config'
#

  if (mysql_table_exists("".$prefix."_nsngr_config")) {
echo"Table <b>".$prefix."_nsngr_config</b> already exists, that's ok :)<br>";}
else{
mysql_query("CREATE TABLE ".$prefix."_nsngr_config (
   `config_name` varchar(255) NOT NULL,
   `config_value` text NOT NULL,
   PRIMARY KEY (config_name)
);");

#
# Dumping data for table '".$prefix."_nsngr_config'
#

mysql_query("INSERT INTO ".$prefix."_nsngr_config VALUES ('date_format', 'Y-m-d');");
mysql_query("INSERT INTO ".$prefix."_nsngr_config VALUES ('perpage', '50');");
mysql_query("INSERT INTO ".$prefix."_nsngr_config VALUES ('send_notice', '1');");
mysql_query("INSERT INTO ".$prefix."_nsngr_config VALUES ('version_number', '1.7.1');");
}
# --------------------------------------------------------
#
# Table structure for table '".$prefix."_nsngr_groups'
#

  if (mysql_table_exists("".$prefix."_nsngr_groups")) {
echo"Table <b>".$prefix."_nsngr_groups</b> already exists, that's ok :)<br>";}
else{
mysql_query("CREATE TABLE ".$prefix."_nsngr_groups (
   `gid` int(11) NOT NULL auto_increment,
   `gname` varchar(32) NOT NULL,
   `gdesc` text NOT NULL,
   `gpublic` tinyint(1) DEFAULT '0' NOT NULL,
   `glimit` int(11) DEFAULT '0' NOT NULL,
   `phpBB` int(11) DEFAULT '0' NOT NULL,
   `muid` int(11) DEFAULT '0' NOT NULL,
   PRIMARY KEY (gid)
);");

#
# Dumping data for table '".$prefix."_nsngr_groups'
#

mysql_query("INSERT INTO ".$prefix."_nsngr_groups VALUES ('1', 'Moderators', 'Moderators of this Forum', '0', '0', '2', '5');");
}

# --------------------------------------------------------
#
# Table structure for table '".$prefix."_nsngr_users'
#

  if (mysql_table_exists("".$prefix."_nsngr_users")) {
echo"Table <b>".$prefix."_nsngr_users</b> already exists, that's ok :)<br>";}
else{
mysql_query("CREATE TABLE ".$prefix."_nsngr_users (
   `gid` int(11) DEFAULT '0' NOT NULL,
   `uid` int(11) DEFAULT '0' NOT NULL,
   `uname` varchar(25) NOT NULL,
   `trial` tinyint(1) DEFAULT '0' NOT NULL,
   `notice` tinyint(1) DEFAULT '0' NOT NULL,
   `sdate` int(14) DEFAULT '0' NOT NULL,
   `edate` int(14) DEFAULT '0' NOT NULL,
   PRIMARY KEY (gid, uid)
);");

#
# Dumping data for table '".$prefix."_nsngr_users'
#

mysql_query("INSERT INTO ".$prefix."_nsngr_users VALUES ('1', '5', '', '0', '0', '2006', '0');");
}

# --------------------------------------------------------
#
# Table structure for table '".$prefix."_nsnne_config'
#

  if (mysql_table_exists("".$prefix."_nsnne_config")) {
echo"Table <b>".$prefix."_nsnne_config</b> already exists, that's ok :)<br>";}
else{
mysql_query("CREATE TABLE ".$prefix."_nsnne_config (
   `config_name` varchar(255) NOT NULL,
   `config_value` longtext NOT NULL,
   UNIQUE config_name (config_name)
);");

#
# Dumping data for table '".$prefix."_nsnne_config'
#

mysql_query("INSERT INTO ".$prefix."_nsnne_config VALUES ('allowed_tags', 'b=>1\r\ni=>1\r\na=>2\r\nem=>1\r\nbr=>1\r\nstrong=>1\r\nblockquote=>1\r\ntt=>1\r\nli=>1\r\nol=>1\r\nul=>1\r\np=>1\r\nhr=>1');");
mysql_query("INSERT INTO ".$prefix."_nsnne_config VALUES ('allow_comments', '0');");
mysql_query("INSERT INTO ".$prefix."_nsnne_config VALUES ('allow_polls', '0');");
mysql_query("INSERT INTO ".$prefix."_nsnne_config VALUES ('allow_rating', '0');");
mysql_query("INSERT INTO ".$prefix."_nsnne_config VALUES ('allow_related', '0');");
mysql_query("INSERT INTO ".$prefix."_nsnne_config VALUES ('anonymous_post', '0');");
mysql_query("INSERT INTO ".$prefix."_nsnne_config VALUES ('anonymous_submit', '0');");
mysql_query("INSERT INTO ".$prefix."_nsnne_config VALUES ('approved_users', '');");
mysql_query("INSERT INTO ".$prefix."_nsnne_config VALUES ('censor_list', 'motherfucking\r\nmotherfucker\r\nmotherfuking\r\nmotherfuker\r\ncocksucking\r\ncocksucker\r\ncocksuking\r\ncocksuker\r\nbastard\r\nfucking\r\nsucking\r\nfucker\r\nsucker\r\nfuking\r\nsuking\r\nfuker\r\nsuker\r\nbitch\r\npenis\r\npussy\r\ndick\r\nfuck\r\nsuck\r\ncunt\r\ncock\r\nc0ck\r\ntwat\r\nclit\r\ncum\r\nfuk');");
mysql_query("INSERT INTO ".$prefix."_nsnne_config VALUES ('censor_mode', '1');");
mysql_query("INSERT INTO ".$prefix."_nsnne_config VALUES ('censor_replace', '*');");
mysql_query("INSERT INTO ".$prefix."_nsnne_config VALUES ('columns', '0');");
mysql_query("INSERT INTO ".$prefix."_nsnne_config VALUES ('comment_limit', '4096');");
mysql_query("INSERT INTO ".$prefix."_nsnne_config VALUES ('default_mode', 'nested');");
mysql_query("INSERT INTO ".$prefix."_nsnne_config VALUES ('default_order', '0');");
mysql_query("INSERT INTO ".$prefix."_nsnne_config VALUES ('default_thold', '0');");
mysql_query("INSERT INTO ".$prefix."_nsnne_config VALUES ('homenumber', '1');");
mysql_query("INSERT INTO ".$prefix."_nsnne_config VALUES ('hometopic', '0');");
mysql_query("INSERT INTO ".$prefix."_nsnne_config VALUES ('notifyauth', '0');");
mysql_query("INSERT INTO ".$prefix."_nsnne_config VALUES ('notify_admin', '1');");
mysql_query("INSERT INTO ".$prefix."_nsnne_config VALUES ('notify_commenter', '1');");
mysql_query("INSERT INTO ".$prefix."_nsnne_config VALUES ('notify_informant', '1');");
mysql_query("INSERT INTO ".$prefix."_nsnne_config VALUES ('notify_poster', '1');");
mysql_query("INSERT INTO ".$prefix."_nsnne_config VALUES ('oldnumber', '20');");
mysql_query("INSERT INTO ".$prefix."_nsnne_config VALUES ('posting_admin', '');");
mysql_query("INSERT INTO ".$prefix."_nsnne_config VALUES ('readmore', '0');");
mysql_query("INSERT INTO ".$prefix."_nsnne_config VALUES ('texttype', '0');");
mysql_query("INSERT INTO ".$prefix."_nsnne_config VALUES ('version_number', '2.0.0');");
 }
# --------------------------------------------------------
#
# Table structure for table '".$prefix."_nsnsp_config'
#

  if (mysql_table_exists("".$prefix."_nsnsp_config")) {
echo"Table <b>".$prefix."_nsnsp_config</b> already exists, that's ok :)<br>";}
else{
mysql_query("CREATE TABLE ".$prefix."_nsnsp_config (
   `require_user` int(1) DEFAULT '1' NOT NULL,
   `image_type` int(1) DEFAULT '0' NOT NULL,
   PRIMARY KEY (require_user),
   KEY require_user (require_user)
);");

#
# Dumping data for table '".$prefix."_nsnsp_config'
#

mysql_query("INSERT INTO ".$prefix."_nsnsp_config VALUES ('1', '0');");
}
# --------------------------------------------------------
#
# Table structure for table '".$prefix."_nsnsp_sites'
#

  if (mysql_table_exists("".$prefix."_nsnsp_sites")) {
echo"Table <b>".$prefix."_nsnsp_sites</b> already exists, that's ok :)<br>";}
else{
mysql_query("CREATE TABLE ".$prefix."_nsnsp_sites (
   `site_id` int(11) NOT NULL auto_increment,
   `site_name` varchar(60) NOT NULL,
   `site_url` varchar(255) NOT NULL,
   `site_image` varchar(255) NOT NULL,
   `site_status` int(1) DEFAULT '0' NOT NULL,
   `site_hits` int(10) DEFAULT '0' NOT NULL,
   `site_date` date DEFAULT '0000-00-00' NOT NULL,
   `site_description` text NOT NULL,
   `user_id` int(11) DEFAULT '0' NOT NULL,
   `user_name` varchar(60) NOT NULL,
   `user_email` varchar(60) NOT NULL,
   `user_ip` varchar(20) NOT NULL,
   PRIMARY KEY (site_id),
   KEY site_id (site_id)
);");

#
# Dumping data for table '".$prefix."_nsnsp_sites'
#

mysql_query("INSERT INTO ".$prefix."_nsnsp_sites VALUES ('4', 'The PNC project', 'http://www.phpnuke-clan.net', 'http://www.phpnuke-clan.net/banner_88x31.gif', '1', '0', '2005-09-08', 'Home of the vWar nuke port, the PNC project - the best Clan ressource on the net!', '2', 'PNC', 'info@phpnuke-clan.net', '0.0.0.0');");
mysql_query("INSERT INTO ".$prefix."_nsnsp_sites VALUES ('5', 'Clans Server', 'http://www.clanservers.com/?ref=1583221', 'http://www.phpnuke-clan.net/modules/Supporters/images/supporters/000018.gif', '1', '3', '2005-11-01', 'Our goal is to offer the highest possible gaming experience with great technical support. Our technical support staff is ready to help you with your game server 24 hours a day 7 days a week. We are so sure you\'ll enjoy having a game server on the clanservers.com network that we offer an unconditional 5 day money back guarantee.', '0', 'Admin', 'info@phpnuke-clan.net', '0.0.0.0');");
mysql_query("INSERT INTO ".$prefix."_nsnsp_sites VALUES ('6', 'Host Gator', 'https://secure.hostgator.com/cgi-bin/affiliates/clickthru.cgi?id=pratcom', 'http://www.phpnuke-clan.net/images/supporter/88x31.gif', '1', '2', '2005-11-18', 'Web Hosting Services!\r\nStart at 6.95$/month!', '0', 'Admin', 'Admin', '0.0.0.0');");
mysql_query("INSERT INTO ".$prefix."_nsnsp_sites VALUES (7, 'Gamer Themes', 'http://www.gamerthemes.com', 'modules/Supporters/images/supporters/000008.gif', 1, 0, '2006-12-17', 'Great graphics and templates for PHPNUKE and PNC', 0, 'Admin', 'Admin', '0.0.0.0');");
mysql_query("INSERT INTO ".$prefix."_nsnsp_sites VALUES (8, 'Are You Served?', 'http://www.areyouserved.com/index.php?aid=pra42493', 'modules/Supporters/images/supporters/000009.gif', 1, 0, '2006-12-17', 'Web & Game hosting. The best hosting solution for your clan!', 0, '', '', '0.0.0.0');");
 }
# --------------------------------------------------------
#
# Table structure for table '".$prefix."_optimize_gain'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_optimize_gain;");
mysql_query("CREATE TABLE ".$prefix."_optimize_gain (
   `gain` decimal(10,3)
);");

#
# Dumping data for table '".$prefix."_optimize_gain'
#

mysql_query("INSERT INTO ".$prefix."_optimize_gain VALUES ('0.000');");
mysql_query("INSERT INTO ".$prefix."_optimize_gain VALUES ('0.414');");

# --------------------------------------------------------
#
# Table structure for table '".$prefix."_pages'
#


#
# Dumping data for table '".$prefix."_pages_categories'
#


# --------------------------------------------------------
#
# Table structure for table '".$prefix."_pnc_technology'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_pnc_technology;");
mysql_query("CREATE TABLE ".$prefix."_pnc_technology (
   `name` varchar(20) NOT NULL,
   `value` text NOT NULL
);");

#
# Dumping data for table '".$prefix."_pnc_technology'
#

mysql_query("INSERT INTO ".$prefix."_pnc_technology VALUES ('versioncheck', '".$pncv."');");
mysql_query("INSERT INTO ".$prefix."_pnc_technology VALUES ('lastupdatecheck', '1116781442');");

# --------------------------------------------------------
#
# Table structure for table '".$prefix."_poll_check'

#


#
# --------------------------------------------------------
#
# Table structure for table '".$prefix."_shoutbox_censor'
#

  if (mysql_table_exists("".$prefix."_shoutbox_censor")) {
echo"Table <b>".$prefix."_shoutbox_censor</b> already exists, that's ok :)<br>";}
else{
mysql_query("CREATE TABLE ".$prefix."_shoutbox_censor (
   `id` int(9) NOT NULL auto_increment,
   `text` varchar(30) NOT NULL,
   `replacement` varchar(30) NOT NULL,
   PRIMARY KEY (id)
);");

#
# Dumping data for table '".$prefix."_shoutbox_censor'
#

mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('1', '@$$', 'butt');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('2', 'a$$', 'butt');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('3', 'anton', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('4', 'arse', 'butt');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('5', 'arsehole', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('6', 'ass', 'butt');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('7', 'ass muncher', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('8', 'asshole', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('9', 'asstooling', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('10', 'asswipe', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('11', 'b!tch', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('12', 'b17ch', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('13', 'b1tch', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('14', 'bastard', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('15', 'beefcurtins', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('16', 'bi7ch', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('17', 'bitch', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('18', 'bitchy', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('19', 'boiolas', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('20', 'bollocks', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('21', 'breasts', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('22', 'brown nose', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('23', 'bugger', ' damn');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('24', 'butt pirate', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('25', 'c0ck', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('26', 'cawk', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('27', 'chink', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('28', 'clitsaq', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('29', 'cock', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('30', 'cockbite', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('31', 'cockgobbler', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('32', 'cocksucker', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('33', 'cum', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('34', 'cunt', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('35', 'dago', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('36', 'daygo', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('37', 'dego', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('38', 'dick', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('39', 'dick wad', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('40', 'dickhead', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('41', 'dickweed', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('42', 'douchebag', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('43', 'dziwka', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('44', 'ekto', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('45', 'enculer', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('46', 'faen', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('47', 'fag', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('48', 'faggot', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('49', 'fart', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('50', 'fatass', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('51', 'feg', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('52', 'felch', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('53', 'ficken', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('54', 'fitta', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('55', 'fitte', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('56', 'flikker', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('57', 'fok', '$#%!');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('58', 'fuck', '$#%!');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('59', 'fu(k', '$#%!');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('60', 'fucker', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('61', 'fucking', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('62', 'fuckwit', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('63', 'fuk', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('64', 'fuking', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('65', 'futkretzn', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('66', 'fux0r', '$#%!');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('67', 'gook', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('68', 'h0r', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('69', 'handjob', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('70', 'helvete', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('71', 'honkey', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('72', 'hore', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('73', 'hump', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('74', 'injun', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('75', 'kawk', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('76', 'kike', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('77', 'knulle', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('78', 'kraut', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('79', 'kuk', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('80', 'kuksuger', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('81', 'kurac', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('82', 'kurwa', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('83', 'langer', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('84', 'masturbation', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('85', 'merd', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('86', 'motherfucker', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('87', 'motherfuckingcocksucker', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('88', 'mutherfucker', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('89', 'nepesaurio', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('90', 'nigga', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('91', 'nigger', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('92', 'nonce', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('93', 'nutsack', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('94', 'one-eyed-trouser-snake', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('95', 'penis', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('96', 'picka', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('97', 'pissant', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('98', 'pizda', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('99', 'politician', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('100', 'prick', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('101', 'puckface', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('102', 'pule', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('103', 'pussy', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('104', 'puta', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('105', 'puto', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('106', 'rimjob', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('107', 'rubber', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('108', 'scheisse', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('109', 'schlampe', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('110', 'schlong', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('111', 'screw', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('112', 'shit', '****');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('113', 'shiteater', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('114', 'shiz', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('115', 'skribz', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('116', 'skurwysyn', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('117', 'slut', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('118', 'spermburper', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('119', 'spic', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('120', 'spierdalaj', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('121', 'splooge', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('122', 'spunk', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('123', 'tatas', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('124', 'tits', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('125', 'toss the salad', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('126', 'twat', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('127', 'unclefucker', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('128', 'vagina', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('129', 'vittu', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('130', 'votze', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('131', 'wank', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('132', 'wanka', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('133', 'wanker', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('134', 'wankers', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('135', 'wankstain', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('136', 'whore', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('137', 'wichser', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('138', 'wop', '[censored]');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_censor VALUES ('139', 'yed', '[censored]');");
}
# --------------------------------------------------------
#
# Table structure for table '".$prefix."_shoutbox_conf'
#

  if (mysql_table_exists("".$prefix."_shoutbox_conf")) {
echo"Table <b>".$prefix."_shoutbox_conf</b> already exists, that's ok :)<br>";}
else{
mysql_query("CREATE TABLE ".$prefix."_shoutbox_conf (
   `id` int(9) DEFAULT '0' NOT NULL,
   `color1` varchar(20) NOT NULL,
   `color2` varchar(20) NOT NULL,
   `date` varchar(5) NOT NULL,
   `time` varchar(5) NOT NULL,
   `number` varchar(5) NOT NULL,
   `ipblock` varchar(5) NOT NULL,
   `nameblock` varchar(5) NOT NULL,
   `censor` varchar(5) NOT NULL,
   `tablewidth` char(3) NOT NULL,
   `urlonoff` varchar(5) NOT NULL,
   `delyourlastpost` varchar(5) NOT NULL,
   `anonymouspost` varchar(5) NOT NULL,
   `height` varchar(5) NOT NULL,
   `themecolors` varchar(5) NOT NULL,
   `textWidth` varchar(4) NOT NULL,
   `nameWidth` varchar(4) NOT NULL,
   `smiliesPerRow` varchar(4) NOT NULL,
   `reversePosts` varchar(4) NOT NULL,
   `timeOffset` varchar(10) NOT NULL,
   `urlanononoff` varchar(10) NOT NULL,
   `pointspershout` varchar(5) NOT NULL,
   `shoutsperpage` varchar(5) NOT NULL,
   `serverTimezone` varchar(5) NOT NULL,
   `blockxxx` varchar(5) NOT NULL,
   PRIMARY KEY (id)
);");

#
# Dumping data for table '".$prefix."_shoutbox_conf'
#

mysql_query("INSERT INTO ".$prefix."_shoutbox_conf VALUES ('1', '#EBEBEB', '#FFFFFF', 'yes', 'yes', '10', 'yes', 'yes', 'yes', '150', 'yes', 'yes', 'yes', '150', 'no', '20', '10', '7', 'no', '0', 'no', '0', '25', '-6', 'yes');");
 }
# --------------------------------------------------------
#
# Table structure for table '".$prefix."_shoutbox_date'
#

  if (mysql_table_exists("".$prefix."_shoutbox_date")) {
echo"Table <b>".$prefix."_shoutbox_date</b> already exists, that's ok :)<br>";}
else{
mysql_query("CREATE TABLE ".$prefix."_shoutbox_date (
   `id` int(5) DEFAULT '0' NOT NULL,
   `date` varchar(10) NOT NULL,
   `time` varchar(10) NOT NULL,
   PRIMARY KEY (id)
);");

#
# Dumping data for table '".$prefix."_shoutbox_date'
#

mysql_query("INSERT INTO ".$prefix."_shoutbox_date VALUES ('1', 'd-m-Y', 'g:i:a');");
}
# --------------------------------------------------------
#
# Table structure for table '".$prefix."_shoutbox_emoticons'
#

  if (mysql_table_exists("".$prefix."_shoutbox_emoticons")) {
echo"Table <b>".$prefix."_shoutbox_emoticons</b> already exists, that's ok :)<br>";}
else{
mysql_query("CREATE TABLE ".$prefix."_shoutbox_emoticons (
   `id` int(9) NOT NULL auto_increment,
   `text` varchar(20) NOT NULL,
   `image` varchar(70) NOT NULL,
   PRIMARY KEY (id)
);");

#
# Dumping data for table '".$prefix."_shoutbox_emoticons'
#

mysql_query("INSERT INTO ".$prefix."_shoutbox_emoticons VALUES ('1', ':confused:', '<img src=images/blocks/shout_box/confused.gif>');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_emoticons VALUES ('2', ':sigh:', '<img src=images/blocks/shout_box/sigh.gif>');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_emoticons VALUES ('3', ':sleep:', '<img src=images/blocks/shout_box/sleep.gif>');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_emoticons VALUES ('4', ':upset:', '<img src=images/blocks/shout_box/upset.gif>');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_emoticons VALUES ('5', ':none:', '<img src=images/blocks/shout_box/none.gif>');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_emoticons VALUES ('6', ':eek:', '<img src=images/blocks/shout_box/bigeek.gif>');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_emoticons VALUES ('7', ':rolleyes:', '<img src=images/blocks/shout_box/rolleyes.gif>');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_emoticons VALUES ('8', ':mad:', '<img src=images/blocks/shout_box/mad.gif>');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_emoticons VALUES ('9', ':yes:', '<img src=images/blocks/shout_box/yes.gif>');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_emoticons VALUES ('10', ':no:', '<img src=images/blocks/shout_box/no.gif>');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_emoticons VALUES ('11', ':shy:', '<img src=images/blocks/shout_box/shy.gif>');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_emoticons VALUES ('12', ':laugh:', '<img src=images/blocks/shout_box/laugh.gif>');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_emoticons VALUES ('13', ':dead:', '<img src=images/blocks/shout_box/dead.gif>');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_emoticons VALUES ('14', ':cry:', '<img src=images/blocks/shout_box/cry.gif>');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_emoticons VALUES ('15', ':)', '<img src=images/blocks/shout_box/smile.gif>');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_emoticons VALUES ('16', ':(', '<img src=images/blocks/shout_box/sad.gif>');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_emoticons VALUES ('17', ';)', '<img src=images/blocks/shout_box/smilewinkgrin.gif>');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_emoticons VALUES ('18', ':|', '<img src=images/blocks/shout_box/none.gif>');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_emoticons VALUES ('19', ':-)', '<img src=images/blocks/shout_box/smile.gif>');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_emoticons VALUES ('20', ':-(', '<img src=images/blocks/shout_box/sad.gif>');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_emoticons VALUES ('21', ';-)', '<img src=images/blocks/shout_box/smilewinkgrin.gif>');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_emoticons VALUES ('22', ':-|', '<img src=images/blocks/shout_box/none.gif>');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_emoticons VALUES ('23', ':0', '<img src=images/blocks/shout_box/bigeek.gif>');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_emoticons VALUES ('24', 'B)', '<img src=images/blocks/shout_box/cool.gif>');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_emoticons VALUES ('25', ':D', '<img src=images/blocks/shout_box/biggrin.gif>');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_emoticons VALUES ('26', ':P', '<img src=images/blocks/shout_box/bigrazz.gif>');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_emoticons VALUES ('27', ':B', '<img src=images/blocks/shout_box/bigrazz.gif>');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_emoticons VALUES ('28', 'B-)', '<img src=images/blocks/shout_box/cool.gif>');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_emoticons VALUES ('29', ':-D', '<img src=images/blocks/shout_box/biggrin.gif>');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_emoticons VALUES ('30', ':-P', '<img src=images/blocks/shout_box/bigrazz.gif>');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_emoticons VALUES ('31', ':O', '<img src=images/blocks/shout_box/bigeek.gif>');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_emoticons VALUES ('32', 'b)', '<img src=images/blocks/shout_box/cool.gif>');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_emoticons VALUES ('33', ':d', '<img src=images/blocks/shout_box/biggrin.gif>');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_emoticons VALUES ('34', ':p', '<img src=images/blocks/shout_box/bigrazz.gif>');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_emoticons VALUES ('35', ':b', '<img src=images/blocks/shout_box/bigrazz.gif>');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_emoticons VALUES ('36', 'b-)', '<img src=images/blocks/shout_box/cool.gif>');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_emoticons VALUES ('37', ':-d', '<img src=images/blocks/shout_box/biggrin.gif>');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_emoticons VALUES ('38', ':-p', '<img src=images/blocks/shout_box/bigrazz.gif>');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_emoticons VALUES ('39', ':-b', '<img src=images/blocks/shout_box/bigrazz.gif>');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_emoticons VALUES ('40', ':o', '<img src=images/blocks/shout_box/bigeek.gif>');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_emoticons VALUES ('41', 'o_O', '<img src=images/blocks/shout_box/bigeek.gif>');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_emoticons VALUES ('42', 'O_o', '<img src=images/blocks/shout_box/bigeek.gif>');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_emoticons VALUES ('43', 'o_o', '<img src=images/blocks/shout_box/bigeek.gif>');");
mysql_query("INSERT INTO ".$prefix."_shoutbox_emoticons VALUES ('44', 'O_O', '<img src=images/blocks/shout_box/bigeek.gif>');");
 }
# --------------------------------------------------------
#
# Table structure for table '".$prefix."_shoutbox_ipblock'
#

  if (mysql_table_exists("".$prefix."_shoutbox_ipblock")) {
echo"Table <b>".$prefix."_shoutbox_ipblock</b> already exists, that's ok :)<br>";}
else{
mysql_query("CREATE TABLE ".$prefix."_shoutbox_ipblock (
   `id` int(9) NOT NULL auto_increment,
   `name` varchar(50) NOT NULL,
   PRIMARY KEY (id)
);");
}
#
# Dumping data for table '".$prefix."_shoutbox_ipblock'
#


# --------------------------------------------------------
#
# Table structure for table '".$prefix."_shoutbox_manage_count'
#

  if (mysql_table_exists("".$prefix."_shoutbox_manage_count")) {
echo"Table <b>".$prefix."_shoutbox_manage_count</b> already exists, that's ok :)<br>";}
else{
mysql_query("CREATE TABLE ".$prefix."_shoutbox_manage_count (
   `id` int(9) NOT NULL auto_increment,
   `admin` varchar(25) NOT NULL,
   `aCount` varchar(5) DEFAULT '10' NOT NULL,
   PRIMARY KEY (id)
);");

#
# Dumping data for table '".$prefix."_shoutbox_manage_count'
#

mysql_query("INSERT INTO ".$prefix."_shoutbox_manage_count VALUES ('1', 'pncadmin', '10');");
}
# --------------------------------------------------------
#
# Table structure for table '".$prefix."_shoutbox_nameblock'
#

  if (mysql_table_exists("".$prefix."_shoutbox_nameblock")) {
echo"Table <b>".$prefix."_shoutbox_nameblock</b> already exists, that's ok :)<br>";}
else{
mysql_query("CREATE TABLE ".$prefix."_shoutbox_nameblock (
   `id` int(9) NOT NULL auto_increment,
   `name` varchar(50) NOT NULL,
   PRIMARY KEY (id)
);");
}
#
# Dumping data for table '".$prefix."_shoutbox_nameblock'
#


# --------------------------------------------------------
#
# Table structure for table '".$prefix."_shoutbox_shouts'
#

  if (mysql_table_exists("".$prefix."_shoutbox_shouts")) {
echo"Table <b>".$prefix."_shoutbox_shouts</b> already exists, that's ok :)<br>";}
else{
mysql_query("CREATE TABLE ".$prefix."_shoutbox_shouts (
   `id` int(9) NOT NULL auto_increment,
   `name` varchar(20) NOT NULL,
   `comment` text NOT NULL,
   `date` varchar(10) NOT NULL,
   `time` varchar(10) NOT NULL,
   `ip` varchar(39),
   `timestamp` varchar(20) NOT NULL,
   PRIMARY KEY (id)
);");

#
# Dumping data for table '".$prefix."_shoutbox_shouts'
#

mysql_query("INSERT INTO ".$prefix."_shoutbox_shouts VALUES ('1', 'OurScripts.net', 'Thank You for trying this out!', '2-1-05', '24:00', 'noip', '1102320000');");
}
# --------------------------------------------------------
#
# Table structure for table '".$prefix."_shoutbox_sticky'
#

  if (mysql_table_exists("".$prefix."_shoutbox_sticky")) {
echo"Table <b>".$prefix."_shoutbox_sticky</b> already exists, that's ok :)<br>";}
else{
mysql_query("CREATE TABLE ".$prefix."_shoutbox_sticky (
   `id` int(9) NOT NULL auto_increment,
   `name` varchar(20) NOT NULL,
   `comment` text NOT NULL,
   `timestamp` varchar(20) NOT NULL,
   `stickySlot` varchar(5) NOT NULL,
   PRIMARY KEY (id)
);");
}
#
# Dumping data for table '".$prefix."_shoutbox_sticky'
#


# --------------------------------------------------------
#
# Table structure for table '".$prefix."_shoutbox_theme_images'
#

  if (mysql_table_exists("".$prefix."_shoutbox_themes_images")) {
echo"Table <b>".$prefix."_shoutbox_themes_images</b> already exists, that's ok :)<br>";}
else{
mysql_query("CREATE TABLE ".$prefix."_shoutbox_theme_images (
   `id` int(9) NOT NULL auto_increment,
   `themeName` varchar(50),
   `blockArrowColor` varchar(50) NOT NULL,
   `blockBackgroundImage` varchar(50) NOT NULL,
   PRIMARY KEY (id)
);");
}
#
# Dumping data for table '".$prefix."_shoutbox_theme_images'
#


# --------------------------------------------------------
#
# Table structure for table '".$prefix."_shoutbox_themes'
#

  if (mysql_table_exists("".$prefix."_shoutbox_themes")) {
echo"Table <b>".$prefix."_shoutbox_themes</b> already exists, that's ok :)<br>";}
else{
mysql_query("CREATE TABLE ".$prefix."_shoutbox_themes (
   `id` int(9) NOT NULL auto_increment,
   `themeName` varchar(50),
   `blockColor1` varchar(20),
   `blockColor2` varchar(20),
   `border` varchar(20),
   `menuColor1` varchar(20),
   `menuColor2` varchar(20),
   PRIMARY KEY (id)
);");

#
# Dumping data for table '".$prefix."_shoutbox_themes'
#

mysql_query("INSERT INTO ".$prefix."_shoutbox_themes VALUES ('1', 'Lexus-Blue', '#303030', '#303030', '#262626', '#262626', '#262626');");
}
# --------------------------------------------------------
#
# Table structure for table '".$prefix."_shoutbox_version'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_shoutbox_version;");
mysql_query("CREATE TABLE ".$prefix."_shoutbox_version (
   `id` int(5) DEFAULT '0' NOT NULL,
   `version` varchar(10) NOT NULL,
   `datechecked` char(2) NOT NULL,
   `versionreported` varchar(10) NOT NULL,
   PRIMARY KEY (id)
);");

#
# Dumping data for table '".$prefix."_shoutbox_version'
#

mysql_query("INSERT INTO ".$prefix."_shoutbox_version VALUES ('1', '8.5', '0', '0');");


# --------------------------------------------------------
#
  if (mysql_table_exists("".$prefix."_sommaire")) {
echo"Table <b>".$prefix."_sommaire</b> already exists, that's ok :)<br>";}
else{
mysql_query("CREATE TABLE `".$prefix."_sommaire` (
  `groupmenu` int(2) NOT NULL default '0',
  `name` varchar(200) default NULL,
  `image` varchar(99) default NULL,
  `lien` text,
  `hr` char(2) default NULL,
  `center` char(2) default NULL,
  `bgcolor` tinytext,
  `invisible` int(1) default NULL,
  `class` tinytext,
  `bold` char(2) default NULL,
  `new` char(2) default NULL,
  `listbox` char(2) default NULL,
  `dynamic` char(2) default NULL,
  `date_debut` bigint(20) unsigned NOT NULL default '0',
  `date_fin` bigint(20) unsigned NOT NULL default '0',
  `days` varchar(8) default NULL,
  PRIMARY KEY  (`groupmenu`)
) TYPE=MyISAM;");

//
// Dumping data for table `".$prefix."_sommaire`
//

mysql_query("INSERT INTO `".$prefix."_sommaire` VALUES (0, 'Home', 'bullet_blue.gif', 'index.php', 'on', 'on', '', 4, '', '', '', '', 'on', 0, 0, '');");
mysql_query("INSERT INTO `".$prefix."_sommaire` VALUES (99, '', NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, '', 0, 0, NULL);");
}


//
// Table structure for table `".$prefix."_sommaire_categories`
//
  if (mysql_table_exists("".$prefix."_sommaire_categories")) {
echo"Table <b>".$prefix."_sommaire_categories</b> already exists, that's ok :)<br>";}
else{
mysql_query("CREATE TABLE `".$prefix."_sommaire_categories` (
  `id` int(11) NOT NULL auto_increment,
  `groupmenu` int(2) NOT NULL default '0',
  `module` varchar(50) NOT NULL default '',
  `url` text NOT NULL,
  `url_text` text NOT NULL,
  `image` varchar(50) NOT NULL default '',
  `new` char(2) default NULL,
  `new_days` tinyint(4) NOT NULL default '-1',
  `class` varchar(20) NOT NULL default '',
  `bold` char(2) default NULL,
  `sublevel` tinyint(3) NOT NULL default '0',
  `date_debut` bigint(20) unsigned NOT NULL default '0',
  `date_fin` bigint(20) unsigned NOT NULL default '0',
  `days` varchar(8) default NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=268 ;");

//
// Dumping data for table `".$prefix."_sommaire_categories`
//

mysql_query("INSERT INTO `".$prefix."_sommaire_categories` VALUES (259, 0, 'Downloads', '', '', 'tree-T.gif', '', 0, '', '', 0, 0, 0, '');");
mysql_query("INSERT INTO `".$prefix."_sommaire_categories` VALUES (260, 0, 'Forums', '', '', 'tree-T.gif', '', 0, '', '', 0, 0, 0, '');");
mysql_query("INSERT INTO `".$prefix."_sommaire_categories` VALUES (261, 0, 'News', '', '', 'tree-L.gif', '', 0, '', '', 0, 0, 0, '');");
mysql_query("INSERT INTO `".$prefix."_sommaire_categories` VALUES (262, 0, 'SOMMAIRE_HR', '', '', '', '', 0, '', '', 0, 0, 0, '');");
mysql_query("INSERT INTO `".$prefix."_sommaire_categories` VALUES (263, 0, 'Lien externe', '/modules.php?name=vwar&file=war', 'Wars', 'bullet_dots.gif', '', 0, '', '', 0, 0, 0, '');");
mysql_query("INSERT INTO `".$prefix."_sommaire_categories` VALUES (264, 0, 'Lien externe', '/modules.php?name=vwar&file=member', 'Members', 'bullet_dots.gif', '', 0, '', '', 0, 0, 0, '');");
mysql_query("INSERT INTO `".$prefix."_sommaire_categories` VALUES (265, 0, 'Lien externe', '/modules.php?name=vwar&file=calendar', 'Calendar', 'bullet_dots.gif', '', 0, '', '', 0, 0, 0, '');");
mysql_query("INSERT INTO `".$prefix."_sommaire_categories` VALUES (266, 0, 'Lien externe', '/modules.php?name=vwar&file=stats', 'War Stats', 'bullet_dots.gif', '', 0, '', '', 0, 0, 0, '');");
mysql_query("INSERT INTO `".$prefix."_sommaire_categories` VALUES (267, 0, 'Lien externe', '/modules.php?name=Ventrilo', 'Ventrilo', 'bullet_dots.gif', '', 0, '', 'on', 0, 0, 0, '');");
}
# --------------------------------------------------------
#
# Table structure for table '".$prefix."_themeconsole'
#

if (mysql_table_exists("".$prefix."_themeconsole")) {
echo"Table <b>".$prefix."_themeconsole</b> already exists, that's ok :)<br>";}
else{
mysql_query("CREATE TABLE ".$prefix."_themeconsole (
   `marq1` varchar(255) DEFAULT 'This is line 1 from ThemeConsole mod so you can change and edit' NOT NULL,
   `marq2` varchar(255) DEFAULT 'This is line 2 from ThemeConsole mod so you can change and edit' NOT NULL,
   `marq3` varchar(255) DEFAULT 'This is line 2 from ThemeConsole mod so you can change and edit' NOT NULL,
   `marq4` varchar(255) DEFAULT 'This is line 4 from ThemeConsole mod so you can change and edit' NOT NULL,
   `marq5` varchar(255) DEFAULT 'This is line 5 from ThemeConsole mod so you can change and edit' NOT NULL,
   `marqstyle` int(2) DEFAULT '99' NOT NULL,
   `hlink1` varchar(255) DEFAULT 'Home' NOT NULL,
   `hlinkurl1` varchar(255) DEFAULT 'index.php' NOT NULL,
   `hlink2` varchar(255) DEFAULT 'Downloads' NOT NULL,
   `hlinkurl2` varchar(255) DEFAULT 'modules.php?name=Downloads' NOT NULL,
   `hlink3` varchar(255) DEFAULT 'Forums' NOT NULL,
   `hlinkurl3` varchar(255) DEFAULT 'modules.php?name=Forums' NOT NULL,
   `hlink4` varchar(255) DEFAULT 'Statistics' NOT NULL,
   `hlinkurl4` varchar(255) DEFAULT 'modules.php?name=Statistics' NOT NULL,
   `hlink5` varchar(255) DEFAULT 'Web Links' NOT NULL,
   `hlinkurl5` varchar(255) DEFAULT 'modules.php?name=Web_Links' NOT NULL,
   `searchbox` int(1) DEFAULT '1' NOT NULL,
   `flashswitch` int(1) DEFAULT '1' NOT NULL,
   `disrightclick` int(1) DEFAULT '1' NOT NULL,
   `adminright` int(1) DEFAULT '0' NOT NULL,
   `disselectall` int(1) DEFAULT '1' NOT NULL,
   `adminselect` int(1) DEFAULT '0' NOT NULL,
   `themename` varchar(255) NOT NULL,
   `encrypt` int(1) DEFAULT '1' NOT NULL,
   `pubbox` varchar(10) DEFAULT '#5B5C70' NOT NULL,
   `pubboxtext` varchar(7) NOT NULL,
   KEY themename (themename)
);");

#
# Dumping data for table '".$prefix."_themeconsole'
#

mysql_query("INSERT INTO ".$prefix."_themeconsole VALUES ('This is line 1 from ThemeConsole, you can change and edit this message through admin with minimal effort.', 'This is line 2 from ThemeConsole, you can change and edit this message through admin with minimal effort.', 'This is line 3 from ThemeConsole, you can change and edit this message through admin with minimal effort.', 'This is line 4 from ThemeConsole, you can change and edit this message through admin with minimal effort.', 'This is line 5 from ThemeConsole, you can change and edit this message through admin with minimal effort.', '2', 'Home', 'index.php', 'Downloads', 'modules.php?name=Downloads', 'Forums', 'modules.php?name=Forums', 'Supporters', 'modules.php?name=Supporters', 'Account', 'modules.php?name=Your_Account', '1', '0', '1', '0', '0', '0', 'XHalo', '1', '1', '');");
mysql_query("INSERT INTO ".$prefix."_themeconsole VALUES ('This is line 1 from ThemeConsole mod so you can change and edit this message with simplicity.', 'This is line 2 from ThemeConsole mod so you can change and edit this message with simplicity.', 'This is line 2 from ThemeConsole mod so you can change and edit this message with simplicity.', 'This is line 4 from ThemeConsole mod so you can change and edit this message with simplicity.', 'This is line 5 from ThemeConsole mod so you can change and edit this message with simplicity.', '99', 'Home', 'index.php', 'Downloads', 'modules.php?name=Downloads', 'Forums', 'modules.php?name=Forums', 'Statistics', 'modules.php?name=Statistics', 'Web Links', 'modules.php?name=Web_Links', '0', '0', '0', '0', '0', '0', 'Phoenix', '0', '0', '');");
}
# --------------------------------------------------------
#
# Table structure for table '".$prefix."_topics'
#

# --------------------------------------------------------
#
# Table structure for table '".$prefix."_treasury_config'
#

if (mysql_table_exists("".$prefix."_treasury_config")) {
echo"Table <b>".$prefix."_treasury_config</b> already exists, that's ok :)<br>";}
else{
mysql_query("CREATE TABLE ".$prefix."_treasury_config (
   `name` varchar(25) NOT NULL,
   `subtype` varchar(20) NOT NULL,
   `value` varchar(200) DEFAULT '0' NOT NULL,
   `text` text NOT NULL
);");

#
# Dumping data for table '".$prefix."_treasury_config'
#

mysql_query("INSERT INTO ".$prefix."_treasury_config VALUES ('receiver_email', '', 'paypal@pratcom.com', '!!!!!!VERY IMPORTANT!!!!!!!\r\nThis is the email address registered\r\nin your PayPal account that you receive\r\nmoney on.  NOTE: Create an email address\r\nspecifically and only for receiving\r\ndonations, i.e. donations@yoursite.com.\r\nThe Donatometer will list any payments\r\nto the email you list here, whether they\r\ncome from this module or not.\r\n');");
mysql_query("INSERT INTO ".$prefix."_treasury_config VALUES ('goal', 'Jan', '150', 'Enter the dollar amounts for each month\'s\r\ndonation goal.');");
mysql_query("INSERT INTO ".$prefix."_treasury_config VALUES ('goal', 'Feb', '150', '');");
mysql_query("INSERT INTO ".$prefix."_treasury_config VALUES ('goal', 'Mar', '150', '');");
mysql_query("INSERT INTO ".$prefix."_treasury_config VALUES ('goal', 'Apr', '150', '');");
mysql_query("INSERT INTO ".$prefix."_treasury_config VALUES ('goal', 'May', '150', '');");
mysql_query("INSERT INTO ".$prefix."_treasury_config VALUES ('goal', 'Jun', '150', '');");
mysql_query("INSERT INTO ".$prefix."_treasury_config VALUES ('goal', 'Jul', '150', '');");
mysql_query("INSERT INTO ".$prefix."_treasury_config VALUES ('goal', 'Aug', '150', '');");
mysql_query("INSERT INTO ".$prefix."_treasury_config VALUES ('goal', 'Sep', '150', '');");
mysql_query("INSERT INTO ".$prefix."_treasury_config VALUES ('goal', 'Oct', '150', '');");
mysql_query("INSERT INTO ".$prefix."_treasury_config VALUES ('goal', 'Nov', '150', '');");
mysql_query("INSERT INTO ".$prefix."_treasury_config VALUES ('goal', 'Dec', '150', '');");
mysql_query("INSERT INTO ".$prefix."_treasury_config VALUES ('swing_day', '', '6', 'The Swing Day determines when the\r\nDonatometer will switch to show the\r\nnext month.  The previous month\'s\r\nstats will no longer be displayed.');");
mysql_query("INSERT INTO ".$prefix."_treasury_config VALUES ('dm_title', '', '<b>HELP KEEP OUR SERVERS ONLINE!</b>', 'Enter a customized title for your\r\nDonatometer.  NOTE: This is not the\r\nNuke Block title.  You can change that\r\nin the Nuke Blocks Admin.');");
mysql_query("INSERT INTO ".$prefix."_treasury_config VALUES ('ty_url', '', 'http://www.phpnuke-clan.net', 'You can enter a URL here for a web page\r\nthat users will be taken to when they\r\ncomplete a donation.  This is useful for\r\ntaking the user back to your site and\r\ndisplaying a Thank You.  NOTE: PayPal\r\nwill use this link for cancelled payments\r\nas well. If you use the feature, also\r\ncreate a second web page with appropriate\r\ntext for a cancelled payment.  TIP: Use\r\nNukeWrap to bring your users back into the\r\nNuke site.');");
mysql_query("INSERT INTO ".$prefix."_treasury_config VALUES ('pp_itemname', '', 'Donation', 'Enter the IPN item name used for your\r\ndonations. This feature is currently\r\nnot used.');");
mysql_query("INSERT INTO ".$prefix."_treasury_config VALUES ('dm_num_don', '', '10', 'Enter the number of donators that\r\nshould be listed in the Donatometer.\r\n-1 = Don\'t list any\r\n 0 = Unlimited\r\n # = The max number to list\r\nDonators are always listed from newest\r\nto oldest from the top down.\r\n');");
mysql_query("INSERT INTO ".$prefix."_treasury_config VALUES ('dm_show_amt', '', '1', 'Should the Donatometer display the\r\nAmount of each donation?');");
mysql_query("INSERT INTO ".$prefix."_treasury_config VALUES ('dm_show_date', '', '1', 'Should the Donatometer display the\r\ndate that each donation was made?');");
mysql_query("INSERT INTO ".$prefix."_treasury_config VALUES ('dm_button', '', 'https://www.paypal.com/en_US/i/btn/x-click-but21.gif', 'Enter a complete URL for the image used\r\nin the Donatometer block');");
mysql_query("INSERT INTO ".$prefix."_treasury_config VALUES ('don_button_submit', '', 'https://www.paypal.com/en_US/i/btn/x-click-but04.gif', 'Enter a complete URL for the image to use\r\nfor at the bottom of the Donations module\r\nto submit a donation.');");
mysql_query("INSERT INTO ".$prefix."_treasury_config VALUES ('don_button_top', '', 'https://www.paypal.com/en_US/i/btn/x-click-but21.gif', 'Enter a complete URL for the image to use\r\nfor at the top of the Donations module.');");
mysql_query("INSERT INTO ".$prefix."_treasury_config VALUES ('pp_image_url', '', 'http://phpnuke-clan.net/images/banners/banner_pnc.jpg', 'You can have a custom image displayed at\r\nthe top of the PayPal screen when your\r\nusers are donating.  Enter the URL for\r\nthe image to display here.  NOTE: You\r\nshould not enter a non HTTPS:// URL. If\r\nyou enter a URL from a non-secure server\r\nyour users will continually be warned that\r\nthey are about to display secure and\r\nnon-secure information.');");
mysql_query("INSERT INTO ".$prefix."_treasury_config VALUES ('pp_cancel_url', '', 'http://www.phpnuke-clan.net', 'Enter a URL here for a web page that users\r\nwill be taken to when they cancel their\r\npayment.  You should use this feature if\r\nyou have filled in a Thank You URL.\r\nTIP: Use NukeWrap to bring your users back\r\ninto the Nuke site.');");
mysql_query("INSERT INTO ".$prefix."_treasury_config VALUES ('pp_get_addr', '', '0', 'Would you like PayPal to gather the user\'s\r\nshipping address?  Users can opt out of\r\nthis.  This could be useful if you wanted\r\nto send them holiday cards or something.');");
mysql_query("INSERT INTO ".$prefix."_treasury_config VALUES ('don_amount', '1', '5', 'The Donations module provides a list\r\nof suggested donations amounts.  You\r\ncan customize this list below.  ');");
mysql_query("INSERT INTO ".$prefix."_treasury_config VALUES ('don_amount', '2', '10', '');");
mysql_query("INSERT INTO ".$prefix."_treasury_config VALUES ('don_amount', '3', '15', '');");
mysql_query("INSERT INTO ".$prefix."_treasury_config VALUES ('don_amount', '5', '25', '');");
mysql_query("INSERT INTO ".$prefix."_treasury_config VALUES ('don_amount', '4', '20', '');");
mysql_query("INSERT INTO ".$prefix."_treasury_config VALUES ('don_amount', '6', '50', '');");
mysql_query("INSERT INTO ".$prefix."_treasury_config VALUES ('don_amount', '8', '100', '');");
mysql_query("INSERT INTO ".$prefix."_treasury_config VALUES ('don_amt_checked', '', '1', 'The Donations module provides a list\r\nof suggested donations amounts.  You\r\ncan customize this list below.  In this\r\nbox, specify which of the amounts listed\r\nbelow should be checked by default.');");
mysql_query("INSERT INTO ".$prefix."_treasury_config VALUES ('pp_item_num', '', '110', 'Enter the IPN item number used for your\r\ndonations. This feature is currently\r\nnot used.');");
mysql_query("INSERT INTO ".$prefix."_treasury_config VALUES ('dm_img_width', '', '', 'Restrict the dimensions for the above\r\nimage.  To use the image\'s native size\r\nleave both boxes blank.');");
mysql_query("INSERT INTO ".$prefix."_treasury_config VALUES ('dm_img_height', '', '', '');");
mysql_query("INSERT INTO ".$prefix."_treasury_config VALUES ('don_top_img_width', '', '', 'Restrict the dimensions for the above\r\nimage.  To use the image\'s native size\r\nleave both boxes blank.');");
mysql_query("INSERT INTO ".$prefix."_treasury_config VALUES ('don_top_img_height', '', '', '');");
mysql_query("INSERT INTO ".$prefix."_treasury_config VALUES ('don_sub_img_width', '', '', 'Restrict the dimensions for the above\r\nimage.  To use the image\'s native size\r\nleave both boxes blank.');");
mysql_query("INSERT INTO ".$prefix."_treasury_config VALUES ('don_sub_img_height', '', '', '');");
mysql_query("INSERT INTO ".$prefix."_treasury_config VALUES ('don_text', 'rawtext', '0', 'We are a non-profit organization completely supported by you, the members.  Many organizations have web sites, servers and Internet bandwidth donated by it\'s members.  We pride ourselves on being run and owned as a community, and not by a few power-hungry members.  This means that we need you to be a part of that community.  We encourage every member to contribute to the community in any way that they can.  Since we do not have our servers or bandwidth donated, we have pay our bills every month to keep things going.  For those of you who can, we ask that you make a monetary contribution in whatever denomination you\'d like.  Every little bit counts.<br>');");
mysql_query("INSERT INTO ".$prefix."_treasury_config VALUES ('don_show_amt', '', '1', 'Should the Donations module reveal the\r\namount of each donation?');");
mysql_query("INSERT INTO ".$prefix."_treasury_config VALUES ('don_show_date', '', '1', 'Should the Donations module reveal the\r\ndate of each donation?');");
mysql_query("INSERT INTO ".$prefix."_treasury_config VALUES ('don_name_prompt', '', 'Do you want your username revealed with your donation?', 'Enter the text for the prompt asking a\r\nuser if they want their name revealed.');");
mysql_query("INSERT INTO ".$prefix."_treasury_config VALUES ('don_name_yes', '', 'Yes! - Tell the world I gave my hard-earned cash!', 'Enter the text for a (YES) selection');");
mysql_query("INSERT INTO ".$prefix."_treasury_config VALUES ('don_name_no', '', 'No - List my donation as Anonymous', 'Enter the text for a (NO) selection');");
mysql_query("INSERT INTO ".$prefix."_treasury_config VALUES ('ipn_dbg_lvl', '', '2', 'There is an IPN logging feature which has\r\nthree log levels:\r\n1) OFF\r\n2) Log only Errors\r\n3) Log everything\r\nThis log is stored in the (translog) table.');");
mysql_query("INSERT INTO ".$prefix."_treasury_config VALUES ('ipn_log_entries', '', '20', '\r\nEnter the maximum number of log entries to\r\nkeep in the log table.');");
 }
# --------------------------------------------------------
#
# Table structure for table '".$prefix."_treasury_financial'
#

if (mysql_table_exists("".$prefix."_treasury_financial")) {
echo"Table <b>".$prefix."_treasury_financial</b> already exists, that's ok :)<br>";}
else{
mysql_query("CREATE TABLE ".$prefix."_treasury_financial (
   `id` int(11) NOT NULL auto_increment,
   `date` datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
   `num` varchar(16) NOT NULL,
   `name` varchar(128) NOT NULL,
   `descr` varchar(128) NOT NULL,
   `amount` varchar(10) NOT NULL,
   PRIMARY KEY (id)
);");
  }
#
# Dumping data for table '".$prefix."_treasury_financial'
#


# --------------------------------------------------------
#
# Table structure for table '".$prefix."_treasury_transactions'
#

if (mysql_table_exists("".$prefix."_treasury_transactions")) {
echo"Table <b>".$prefix."_treasury_transactions</b> already exists, that's ok :)<br>";}
else{
mysql_query("CREATE TABLE ".$prefix."_treasury_transactions (
   `id` int(8) unsigned NOT NULL auto_increment,
   `business` varchar(50) NOT NULL,
   `txn_id` varchar(20) NOT NULL,
   `item_name` varchar(60) NOT NULL,
   `item_number` varchar(40) NOT NULL,
   `quantity` varchar(6) NOT NULL,
   `invoice` varchar(40) NOT NULL,
   `custom` varchar(127) NOT NULL,
   `tax` varchar(10) NOT NULL,
   `option_name1` varchar(60) NOT NULL,
   `option_selection1` varchar(127) NOT NULL,
   `option_name2` varchar(60) NOT NULL,
   `option_selection2` varchar(127) NOT NULL,
   `memo` text NOT NULL,
   `payment_status` varchar(15) NOT NULL,
   `payment_date` datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
   `txn_type` varchar(15) NOT NULL,
   `mc_gross` varchar(10) NOT NULL,
   `mc_fee` varchar(10) NOT NULL,
   `mc_currency` varchar(5) NOT NULL,
   `settle_amount` varchar(12) NOT NULL,
   `exchange_rate` varchar(10) NOT NULL,
   `first_name` varchar(127) NOT NULL,
   `last_name` varchar(127) NOT NULL,
   `address_street` varchar(127) NOT NULL,
   `address_city` varchar(127) NOT NULL,
   `address_state` varchar(127) NOT NULL,
   `address_zip` varchar(20) NOT NULL,
   `address_country` varchar(127) NOT NULL,
   `address_status` varchar(15) NOT NULL,
   `payer_email` varchar(127) NOT NULL,
   `payer_status` varchar(15) NOT NULL,
   PRIMARY KEY (id)
);");

#
# Dumping data for table '".$prefix."_treasury_transactions'
#

  }
# --------------------------------------------------------
#
# Table structure for table '".$prefix."_treasury_translog'
#

if (mysql_table_exists("".$prefix."_treasury_translog")) {
echo"Table <b>".$prefix."_treasury_translog</b> already exists, that's ok :)<br>";}
else{
mysql_query("CREATE TABLE ".$prefix."_treasury_translog (
   `id` int(11) NOT NULL auto_increment,
   `log_date` datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
   `payment_date` datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
   `logentry` text NOT NULL,
   PRIMARY KEY (id)
);");

#
# Dumping data for table '".$prefix."_treasury_translog'
#
 }

# --------------------------------------------------------
#
# Table structure for table '".$prefix."_users'
#
  /*
mysql_query("CREATE TABLE ".$user_prefix."_users (
   `user_id` int(11) NOT NULL auto_increment,
   `name` varchar(60) NOT NULL,
   `username` varchar(25) NOT NULL,
   `user_email` varchar(255) NOT NULL,
   `femail` varchar(255) NOT NULL,
   `user_website` varchar(255) NOT NULL,
   `user_avatar` varchar(255) NOT NULL,
   `user_regdate` varchar(20) NOT NULL,
   `user_icq` varchar(15),
   `user_occ` varchar(100),
   `user_from` varchar(100),
   `user_interests` varchar(150) NOT NULL,
   `user_sig` varchar(255),
   `user_viewemail` tinyint(2),
   `user_theme` int(3),
   `user_aim` varchar(18),
   `user_yim` varchar(25),
   `user_msnm` varchar(25),
   `user_password` varchar(40) NOT NULL,
   `storynum` tinyint(4) DEFAULT '10' NOT NULL,
   `umode` varchar(10) NOT NULL,
   `uorder` tinyint(1) DEFAULT '0' NOT NULL,
   `thold` tinyint(1) DEFAULT '0' NOT NULL,
   `noscore` tinyint(1) DEFAULT '0' NOT NULL,
   `bio` tinytext NOT NULL,
   `ublockon` tinyint(1) DEFAULT '0' NOT NULL,
   `ublock` tinytext NOT NULL,
   `theme` varchar(255) NOT NULL,
   `commentmax` int(11) DEFAULT '4096' NOT NULL,
   `counter` int(11) DEFAULT '0' NOT NULL,
   `newsletter` int(1) DEFAULT '0' NOT NULL,
   `user_posts` int(10) DEFAULT '0' NOT NULL,
   `user_attachsig` int(2) DEFAULT '0' NOT NULL,
   `user_rank` int(10) DEFAULT '0' NOT NULL,
   `user_level` int(10) DEFAULT '1' NOT NULL,
   `broadcast` tinyint(1) DEFAULT '1' NOT NULL,
   `popmeson` tinyint(1) DEFAULT '0' NOT NULL,
   `user_active` tinyint(1) DEFAULT '1',
   `user_session_time` int(11) DEFAULT '0' NOT NULL,
   `user_session_page` smallint(5) DEFAULT '0' NOT NULL,
   `user_lastvisit` int(11) DEFAULT '0' NOT NULL,
   `user_timezone` tinyint(4) DEFAULT '10' NOT NULL,
   `user_style` tinyint(4),
   `user_lang` varchar(255) DEFAULT 'english' NOT NULL,
   `user_dateformat` varchar(14) DEFAULT 'D M d, Y g:i a' NOT NULL,
   `user_new_privmsg` smallint(5) unsigned DEFAULT '0' NOT NULL,
   `user_unread_privmsg` smallint(5) unsigned DEFAULT '0' NOT NULL,
   `user_last_privmsg` int(11) DEFAULT '0' NOT NULL,
   `user_emailtime` int(11),
   `user_allowhtml` tinyint(1) DEFAULT '1',
   `user_allowbbcode` tinyint(1) DEFAULT '1',
   `user_allowsmile` tinyint(1) DEFAULT '1',
   `user_allowavatar` tinyint(1) DEFAULT '1' NOT NULL,
   `user_allow_pm` tinyint(1) DEFAULT '1' NOT NULL,
   `user_allow_viewonline` tinyint(1) DEFAULT '1' NOT NULL,
   `user_notify` tinyint(1) DEFAULT '0' NOT NULL,
   `user_notify_pm` tinyint(1) DEFAULT '0' NOT NULL,
   `user_popup_pm` tinyint(1) DEFAULT '0' NOT NULL,
   `user_avatar_type` tinyint(4) DEFAULT '3' NOT NULL,
   `user_sig_bbcode_uid` varchar(10),
   `user_actkey` varchar(32),
   `user_newpasswd` varchar(32),
   `points` int(10) DEFAULT '0',
   `last_ip` varchar(15) DEFAULT '0' NOT NULL,
   `agreedtos` tinyint(1) DEFAULT '0' NOT NULL,          (toevoegen)
   PRIMARY KEY (user_id),
   KEY uid (user_id),
   KEY uname (username),
   KEY user_session_time (user_session_time)
);");
*/
  $query1 = mysql_query("SHOW COLUMNS FROM ".$user_prefix."_users LIKE 'agreedtos'") or die(mysql_error());
         if (mysql_num_rows($query1) == 0) {
         mysql_query("ALTER TABLE ".$user_prefix."_users ADD `agreedtos` tinyint(1) DEFAULT '0' NOT NULL")or die('MySQL said: '.mysql_error());}
         else { echo"Column<b> agreedtos</b> Already exists.<br>";}

#




# --------------------------------------------------------
#
# Table structure for table '".$prefix."_users_temp'
#

if (mysql_table_exists("".$prefix."_users_temp")) {
echo"Table <b>".$prefix."_users_temp</b> already exists, that's ok :)<br>";}
else{
mysql_query("CREATE TABLE ".$user_prefix."_users_temp (
   `user_id` int(10) NOT NULL auto_increment,
   `username` varchar(25) NOT NULL,
   `realname` varchar(255) NOT NULL, (toevoegen)
   `user_email` varchar(255) NOT NULL,
   `user_password` varchar(40) NOT NULL,
   `user_regdate` varchar(20) NOT NULL,
   `check_num` varchar(50) NOT NULL,
   `time` varchar(14) NOT NULL,
   PRIMARY KEY (user_id)
);");
 }

# --------------------------------------------------------
#
# Table structure for table '".$prefix."_whoiswhere'
#

if (mysql_table_exists("".$prefix."_whoiswhere")) {
echo"Table <b>".$prefix."_whoiswhere</b> already exists, that's ok :)<br>";}
else{
mysql_query("CREATE TABLE ".$prefix."_whoiswhere (
   `username` varchar(25) NOT NULL,
   `time` varchar(14) NOT NULL,
   `host_addr` varchar(48) NOT NULL,
   `guest` int(1) DEFAULT '0' NOT NULL,
   `module` varchar(30) NOT NULL,
   `url` varchar(255) NOT NULL
);");
    }
#
# Dumping data for table '".$prefix."_whoiswhere'
#



# --------------------------------------------------------
#
# Table structure for table '".$prefix."_xfire'
#

if (mysql_table_exists("".$prefix."_xfire")) {
echo"Table <b>".$prefix."_xfire</b> already exists, that's ok :)<br>";}
else{
mysql_query("CREATE TABLE ".$prefix."_xfire (
   `id` int(11) NOT NULL auto_increment,
   `Name` varchar(25) NOT NULL,
   `XFire` varchar(25) NOT NULL,
   UNIQUE id (id)
);");

#
# Dumping data for table '".$prefix."_xfire'
#

mysql_query("INSERT INTO ".$prefix."_xfire VALUES ('2', 'MP', 'dmemp');");
 }
# --------------------------------------------------------
#
# Table structure for table '".$prefix."_xfirecfg'
#

if (mysql_table_exists("".$prefix."_xfirecfg")) {
echo"Table <b>".$prefix."_xfirecfg</b> already exists, that's ok :)<br>";}
else{
mysql_query("CREATE TABLE ".$prefix."_xfirecfg (
   `id` int(11) NOT NULL auto_increment,
   `Perpage` int(11) DEFAULT '0' NOT NULL,
   `Style` varchar(10) NOT NULL,
   `Size` varchar(10) NOT NULL,
   `Sort` varchar(10) NOT NULL,
   UNIQUE id (id)
);");

#
# Dumping data for table '".$prefix."_xfirecfg'
#

mysql_query("INSERT INTO ".$prefix."_xfirecfg VALUES ('1', '15', 'bg', '0', 'Name');");
  }


# --------------------------------------------------------
#
# Table structure for table '".$prefix."_lgsl'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_lgsl;");
mysql_query("CREATE TABLE ".$prefix."_lgsl (
	`id`           int     (11)  NOT NULL auto_increment,
	`status`       tinyint (1)   NOT NULL default '0',
	`ip`           varchar (255) NOT NULL default '',
	`q_port`       varchar (5)   NOT NULL default '0',
	`c_port`       varchar (5)   NOT NULL default '0',
	`s_port`       varchar (5)   NOT NULL default '0',
	`type`         varchar (50)  NOT NULL default '',
	`cache`        text          NOT NULL,
	`cache_time`   text          NOT NULL,
	`zone`         tinyint (1)   NOT NULL default '0',
	`disabled`     tinyint (1)   NOT NULL default '0',
	PRIMARY KEY (`id`)
) TYPE=MyISAM CHARSET=utf8 COLLATE=utf8_unicode_ci;");


#
# Dumping data for table '".$prefix."_lgsl'
#


#
# Require files needed for vWar number "$n"
#
require_once("../modules/vwar/includes/_config.inc.php");


#
# Altering "vwar".$n."_acpmenugroups'
#

if (!mysql_table_exists("vwar".$n."_acpmenugroups")) {
	echo"Table <b>vwar".$n."_acpmenugroups</b> doesn't exist, that's ok :)<br>";
}
else {
	mysql_query("ALTER TABLE vwar".$n."_acpmenugroups CHANGE condition cond text NOT NULL");
	mysql_query("ALTER TABLE vwar".$n."_acpmenugroups CHANGE conditiontype condtype  enum('OR','AND') NOT NULL default 'OR'");
}


#
# Altering "vwar".$n."_acpmenuitems'
#

if (!mysql_table_exists("vwar".$n."_acpmenuitems")) {
	echo"Table <b>vwar".$n."_acpmenuitems</b> doesn't exist, that's ok :)<br>";
}
else {
	mysql_query("ALTER TABLE vwar".$n."_acpmenuitems CHANGE condition cond text NOT NULL");
	mysql_query("ALTER TABLE vwar".$n."_acpmenuitems CHANGE conditiontype condtype  enum('OR','AND') NOT NULL default 'OR'");
}

?>

<table>
<tr>
                <td>New Table: nukelan_admins</td>
                <td>
                        <?php if(@mysql_query("CREATE TABLE IF NOT EXISTS `nukelan_admins` (
                                                                          `aid` varchar(255) NOT NULL default '',
                                                                          `parties` tinyint(1) NOT NULL default '0',
                                                                          `staff` tinyint(1) NOT NULL default '0',
                                                                          `accessories` tinyint(1) NOT NULL default '0',
                                                                          `check_in` tinyint(1) NOT NULL default '0',
                                                                          `tourney_mod` tinyint(1) NOT NULL default '0',
                                                                          `edit_admins` tinyint(1) NOT NULL default '0',
                                                                          PRIMARY KEY  (`aid`)
                                                                        ) TYPE=MyISAM;")) {
                                        echo "<font color=#009900>success</font>";
                                } else { echo "<font color=#ff0000>Failed</font>"; $allgood = false; }
                        ?>
                </td>
        </tr>
        <tr>
                <td>New Table: nukelan_config&nbsp;&nbsp;</td>
                <td><?php if(@mysql_query("CREATE TABLE IF NOT EXISTS `nukelan_config`
                 (
                             `id` INTEGER (11) NOT NULL  DEFAULT 0,
                     `config_id` INTEGER (11) NOT NULL  DEFAULT 0,
                             `notes` varchar (50),
                                 PRIMARY KEY (id)
                                 ) TYPE=MyISAM")) {
                                        echo "<font color=#009900>success</font>";
                                } else { echo "<font color=#ff0000>Failed</font>"; $allgood = false; } ?></td>
        </tr>
        <tr>
                <td>New Table: nukelan_gamer_profiles&nbsp;&nbsp;</td>
                <td><?php if (@mysql_query("CREATE TABLE IF NOT EXISTS `nukelan_gamer_profiles` (
                                                                          `user_id` int(11) NOT NULL default '0',
                                                                          `name` varchar(255) NOT NULL default '',
                                                                          `alias` varchar(255) NOT NULL default '',
                                                                          `gaming_group` varchar(255) default NULL,
                                                                          `age` tinyint(1) default NULL,
                                                                          `gender` varchar(255) NOT NULL default '',
                                                                          `local` varchar(255) NOT NULL default 'yes',
                                                                          `proficiency` tinyint(4) NOT NULL default '0',
                                                                          `quote` varchar(255) default NULL,
                                                                          PRIMARY KEY  (`user_id`)
                                                                        ) TYPE=MyISAM")) {
                                                echo "<font color=#009900>success</font>";
                                        } else { echo "<font color=#ff0000>Failed</font>"; $allgood = false; } ?>
                </td>
        </tr>
        <tr>
                <td>New Table: nukelan_gamer_rigs&nbsp;&nbsp;</td>
                <td><?php if (@mysql_query("CREATE TABLE IF NOT EXISTS `nukelan_gamer_rigs` (
                                                                          `user_id` int(11) NOT NULL default '0',
                                                                          `mobo` varchar(255) default NULL,
                                                                          `processor` varchar(255) default NULL,
                                                                          `memory` varchar(255) default NULL,
                                                                          `video` varchar(255) default NULL,
                                                                          `sound` varchar(255) default NULL,
                                                                          `headphones` varchar(255) default NULL,
                                                                          `monitor` varchar(255) default NULL,
                                                                          `mouse` varchar(255) default NULL,
                                                                          `mousepad` varchar(255) default NULL,
                                                                          `keyboard` varchar(255) default NULL,
                                                                          PRIMARY KEY  (`user_id`)
                                                                        ) TYPE=MyISAM")) {
                                                echo "<font color=#009900>success</font>";
                                        } else { echo "<font color=#ff0000>Failed</font>"; $allgood = false; } ?>
                </td>
        </tr>
        <tr>
                <td>New Table: nukelan_games&nbsp;&nbsp;</td>
                <td><?php if (@mysql_query("CREATE TABLE IF NOT EXISTS `nukelan_games` (
                                                                          `gameid` int(11) NOT NULL auto_increment,
                                                                          `name` varchar(255) NOT NULL default '',
                                                                          `version` varchar(255) default NULL,
                                                                          PRIMARY KEY  (`gameid`)
                                                                        ) TYPE=MyISAM")) {
                                                echo "<font color=#009900>success</font>";
                                        } else { echo "<font color=#ff0000>Failed</font>"; $allgood = false; } ?>
                </td>
        </tr>
        <tr>
        <td>New Table: nukelan_hosts&nbsp;&nbsp;
        </td>
            <td><?php if (@mysql_query("CREATE TABLE IF NOT EXISTS `nukelan_hosts`
                                        (
                                        `host_id` INTEGER (3) NOT NULL  AUTO_INCREMENT ,
                                        `fname` varchar (40) NOT NULL ,
                                        `email` varchar (40) NOT NULL ,
                                        `phone` varchar (30) NOT NULL ,
                                        `config_id` tinyint (4) NOT NULL  DEFAULT 0,
                                        PRIMARY KEY (host_id)
                                        ) TYPE=MyISAM")) {
                                        echo "<font color=#009900>success</font>";
                                } else { echo "<font color=#ff0000>Failed</font>"; $allgood = false; } ?>
        </td>
        </tr>
        <tr>
        <td>New Table: nukelan_jobs&nbsp;&nbsp;
        </td>
            <td><?php if (@mysql_query("CREATE TABLE IF NOT EXISTS `nukelan_jobs`
                                        (
                                        `jobid` INTEGER (11) NOT NULL  AUTO_INCREMENT ,
                                        `name` varchar (50) NOT NULL ,
                                        `notes` blob NOT NULL ,
                                        `max` INTEGER (6) NOT NULL  DEFAULT 0,
                                        `super` INTEGER (11),
                                        `config_id` tinyint (4) NOT NULL  DEFAULT 0,
                                        PRIMARY KEY (jobid)
                                        ) TYPE=MyISAM")) {
                                        echo "<font color=#009900>success</font>";
                                } else { echo "<font color=#ff0000>Failed</font>"; $allgood = false; } ?>
        </td>
        </tr>
        <tr>
        <td>New Table: nukelan_locations&nbsp;&nbsp;
        </td>
            <td><?php if (@mysql_query("CREATE TABLE IF NOT EXISTS `nukelan_locations`
                                (
                                `loc_id` INTEGER (3) NOT NULL  AUTO_INCREMENT ,
                                `keyword` varchar (40) NOT NULL ,
                                `addr` varchar (255) NOT NULL ,
                                `city` varchar (50) NOT NULL ,
                                `state` CHAR (2) NOT NULL ,
                                `zip` varchar (10) NOT NULL ,
                                PRIMARY KEY (loc_id)
                                ) TYPE=MyISAM")) {
                                echo "<font color=#009900>success</font>";
                                } else { echo "<font color=#ff0000>Failed</font>"; $allgood = false; } ?>
        </td>
        </tr>
        <tr>
        <td>New Table: nukelan_lodging&nbsp;&nbsp;
        </td>
            <td><?php if (@mysql_query("CREATE TABLE IF NOT EXISTS `nukelan_lodging`
                                (
                                `itemid` bigint (20) NOT NULL  AUTO_INCREMENT ,
                                `name` varchar (255),
                                `address` varchar (255),
                                `phone` varchar (20),
                                `costpernight` bigint (20) NOT NULL  DEFAULT 0,
                                `traveltime` varchar (100),
                                `config_id` tinyint (4) NOT NULL  DEFAULT 0,
                                PRIMARY KEY (itemid)
                                ) TYPE=MyISAM")) {
                                echo "<font color=#009900>success</font>";
                                } else { echo "<font color=#ff0000>Failed</font>"; $allgood = false; } ?>
        </td>
        </tr>
        <tr>
        <td>New Table: nukelan_map_temp&nbsp;&nbsp;
        </td>
            <td><?php if (@mysql_query("CREATE TABLE IF NOT EXISTS `nukelan_map_temp`
                                (
                                `uid` INTEGER (11),
                                `room_id` INTEGER (11) NOT NULL  DEFAULT 0,
                                `aid` varchar (50)
                                ) TYPE=MyISAM")) {
                                echo "<font color=#009900>success</font>";
                                } else { echo "<font color=#ff0000>Failed</font>"; $allgood = false; } ?>
        </td>
        </tr>
        <tr>
        <td>New Table: nukelan_parties&nbsp;&nbsp;
        </td>
            <td><?php if (@mysql_query("CREATE TABLE IF NOT EXISTS `nukelan_parties` (
                                                                          `party_id` int(3) NOT NULL auto_increment,
                                                                          `keyword` varchar(40) NOT NULL default '',
                                                                          `date` datetime NOT NULL default '0000-00-00 00:00:00',
                                                                          `loc` int(3) NOT NULL default '0',
                                                                          `host` int(3) NOT NULL default '0',
                                                                          `max` int(4) NOT NULL default '0',
                                                                          `stop` int(1) NOT NULL default '1',
                                                                          `name_a` varchar(255) NOT NULL default '',
                                                                          `name_b` varchar(255) NOT NULL default '',
                                                                          `name_c` varchar(255) NOT NULL default '',
                                                                          `name_d` varchar(255) NOT NULL default '',
                                                                          `name_e` varchar(255) NOT NULL default '',
                                                                          `charge_a` float(5,2) NOT NULL default '0.00',
                                                                          `charge_b` float(5,2) NOT NULL default '0.00',
                                                                          `charge_c` float(5,2) NOT NULL default '0.00',
                                                                          `charge_d` float(5,2) NOT NULL default '0.00',
                                                                          `charge_e` float(5,2) NOT NULL default '0.00',
                                                                          `paypal` int(3) NOT NULL default '0',
                                                                          `disclaimer` text,
                                                                          `enddate` datetime NOT NULL default '0000-00-00 00:00:00',
                                                                          `active` int(1) NOT NULL default '1',
                                                                          `schart` int(11) NOT NULL default '0',
                                                                          `tinfo` text,
                                                                          `prepay` char(1) NOT NULL default '0',
                                                                          PRIMARY KEY  (`party_id`)
                                                                        ) TYPE=MyISAM")) {
                                echo "<font color=#009900>success</font>";
                                } else { echo "<font color=#ff0000>Failed</font>"; $allgood = false; } ?>
        </td>
        </tr>
        <tr>
        <td>New Table: nukelan_paypal&nbsp;&nbsp;
        </td>
            <td><?php if (@mysql_query("CREATE TABLE IF NOT EXISTS `nukelan_paypal` (
                                                                          `paypal_id` int(3) NOT NULL auto_increment,
                                                                          `keyword` varchar(40) NOT NULL default '',
                                                                          `account` varchar(40) NOT NULL default '',
                                                                          `pmttitle` varchar(100) NOT NULL default '',
                                                                          `add_chg` float(5,2) NOT NULL default '0.00',
                                                                          `notify` varchar(150) NOT NULL default '',
																		  `currency` varchar(3) NOT NULL default '',
                                                                          PRIMARY KEY  (`paypal_id`)
                                                                        ) TYPE=MyISAM")) {
                                echo "<font color=#009900>success</font>";
                                } else { echo "<font color=#ff0000>Failed</font>"; $allgood = false; } ?>
        </td>
        </tr>
        <tr>
        <td>New Table: nukelan_prizes&nbsp;&nbsp;
        </td>
            <td><?php if (@mysql_query("CREATE TABLE IF NOT EXISTS `nukelan_prizes` (
                                                                          `prizeid` bigint(20) NOT NULL auto_increment,
                                                                          `prizename` varchar(255) default NULL,
                                                                          `prizevalue` decimal(10,2) NOT NULL default '0.00',
                                                                          `prizepicture` varchar(255) default NULL,
                                                                          `prizequantity` bigint(20) NOT NULL default '0',
                                                                          `tourneyid` bigint(20) NOT NULL default '0',
                                                                          `tourneyplace` bigint(20) NOT NULL default '0',
                                                                          `config_id` tinyint(4) NOT NULL default '0',
                                                                          `win_uid` int(11) NOT NULL default '0',
                                                                          PRIMARY KEY  (`prizeid`)
                                                                        ) TYPE=MyISAM")) {
                                echo "<font color=#009900>success</font>";
                                } else { echo "<font color=#ff0000>Failed</font>"; $allgood = false; } ?>
        </td>
        </tr>
        <tr>
        <td>New Table: nukelan_seat_objects&nbsp;&nbsp;
        </td>
            <td><?php if (@mysql_query("CREATE TABLE IF NOT EXISTS `nukelan_seat_objects`
                                (
                                `id` bigint (20) NOT NULL  AUTO_INCREMENT ,
                                `type` varchar (255) NOT NULL ,
                                `userid` bigint (20) NOT NULL  DEFAULT 0,
                                `name` varchar (255) NOT NULL ,
                                `description` varchar (255),
                                `startx` INTEGER (11) NOT NULL  DEFAULT 0,
                                `starty` INTEGER (11) NOT NULL  DEFAULT 0,
                                `width` INTEGER (11) NOT NULL  DEFAULT 0,
                                `height` INTEGER (11) NOT NULL  DEFAULT 0,
                                `capacity` INTEGER (11),
                                `room_id` INTEGER (11) NOT NULL  DEFAULT 0,
                                PRIMARY KEY (id)
                                ) TYPE=MyISAM")) {
                                echo "<font color=#009900>success</font>";
                                } else { echo "<font color=#ff0000>Failed</font>"; $allgood = false; } ?>
        </td>
        </tr>
        <tr>
        <td>New Table: nukelan_seat_rooms&nbsp;&nbsp;
        </td>
            <td><?php if (@mysql_query("CREATE TABLE IF NOT EXISTS `nukelan_seat_rooms`
                                (
                                `id` bigint (20) NOT NULL  AUTO_INCREMENT ,
                                `name` varchar (255),
                                `description` varchar (255),
                                `width` INTEGER (11) NOT NULL  DEFAULT 0,
                                `height` INTEGER (11) NOT NULL  DEFAULT 0,
                                PRIMARY KEY (id)
                                ) TYPE=MyISAM")) {
                                echo "<font color=#009900>success</font>";
                                } else { echo "<font color=#ff0000>Failed</font>"; $allgood = false; } ?>
                </td>
        </tr>
        <tr>
        <td>New Table: nukelan_signedup&nbsp;&nbsp;
        </td>
            <td><?php if (@mysql_query("CREATE TABLE IF NOT EXISTS `nukelan_signedup` (
                                                                          `lan_uid` int(11) NOT NULL default '0',
                                                                          `lan_id` int(11) NOT NULL default '0',
                                                                          `lan_paid` tinyint(1) default '0',
                                                                          `lan_date` datetime NOT NULL default '0000-00-00 00:00:00',
                                                                          `checkin` tinyint(1) NOT NULL default '0',
                                                                          `checkin_time` datetime NOT NULL default '0000-00-00 00:00:00',
                                                                          `room_loc` int(11) default NULL,
                                                                          `charge` float(5,2) NOT NULL default '0.00',
                                                                          `regtype` varchar(1) NOT NULL default 'a'
                                                                        ) TYPE=MyISAM")) {
                                echo "<font color=#009900>success</font>";
                                } else { echo "<font color=#ff0000>Failed</font>"; $allgood = false; } ?>
                </td>
        </tr>
        <tr>
        <td>New Table: nukelan_sponsors&nbsp;&nbsp;
        </td>
            <td><?php if (@mysql_query("CREATE TABLE IF NOT EXISTS `nukelan_sponsors` (
                                  `id` int(11) NOT NULL auto_increment,
                                  `sponsor_name` varchar(60) NOT NULL default '',
                                  `contact` varchar(60) NOT NULL default '',
                                  `email` varchar(60) NOT NULL default '',
                                  `login` varchar(10) NOT NULL default '',
                                  `passwd` varchar(10) NOT NULL default '',
                                  `moreinfo` blob NOT NULL,
                                  PRIMARY KEY  (`id`),
                                  KEY `id` (`id`)
                                ) TYPE=MyISAM")) {
                                echo "<font color=#009900>success</font>";
                                } else { echo "<font color=#ff0000>Failed</font>"; $allgood = false; } ?>
                </td>
        </tr>
        <tr>
        <td>New Table: nukelan_sponsors_banners&nbsp;&nbsp;
        </td>
            <td><?php if (@mysql_query("CREATE TABLE IF NOT EXISTS `nukelan_sponsors_banners` (
                                  `bid` int(11) NOT NULL auto_increment,
                                  `cid` int(11) NOT NULL default '0',
                                  `imptotal` int(11) NOT NULL default '0',
                                  `impmade` int(11) NOT NULL default '0',
                                  `clicks` int(11) NOT NULL default '0',
                                  `imageurl` varchar(100) NOT NULL default '',
                                  `clickurl` varchar(200) NOT NULL default '',
                                  `alttext` varchar(255) NOT NULL default '',
                                  `date` datetime default NULL,
                                  `dateend` datetime default NULL,
                                  `type` tinyint(1) NOT NULL default '0',
                                  `active` tinyint(1) NOT NULL default '1',
                                  PRIMARY KEY  (`bid`),
                                  KEY `bid` (`bid`),
                                  KEY `cid` (`cid`)
                                ) TYPE=MyISAM")) {
                                echo "<font color=#009900>success</font>";
                                } else { echo "<font color=#ff0000>Failed</font>"; $allgood = false; } ?>
                </td>
        </tr>
        <tr>
        <td>New Table: nukelan_sponsors_parties&nbsp;&nbsp;
        </td>
            <td><?php if (@mysql_query("CREATE TABLE IF NOT EXISTS `nukelan_sponsors_parties` (
                                  `party_id` int(11) NOT NULL default '0',
                                  `sponsor_id` int(11) NOT NULL default '0'
                                ) TYPE=MyISAM")) {
                                echo "<font color=#009900>success</font>";
                                } else { echo "<font color=#ff0000>Failed</font>"; $allgood = false; } ?>
                </td>
        </tr>
        <tr>
        <td>New Table: nukelan_staff&nbsp;&nbsp;
        </td>
            <td><?php if (@mysql_query("CREATE TABLE IF NOT EXISTS `nukelan_staff`
                                (
                                `id` INTEGER (11) NOT NULL  AUTO_INCREMENT ,
                                `userid` INTEGER (11),
                                `jobid` INTEGER (11),
                                `approve` INTEGER (1) NOT NULL  DEFAULT 0,
                                `unotes` blob,
                                PRIMARY KEY (id)
                                ) TYPE=MyISAM")) {
                                echo "<font color=#009900>success</font>";
                                } else { echo "<font color=#ff0000>Failed</font>"; $allgood = false; } ?>
        </td>
        </tr>
        <tr>
        <td>New Table: nukelan_tournament_players&nbsp;&nbsp;
        </td>
            <td><?php if (@mysql_query("CREATE TABLE IF NOT EXISTS `nukelan_tournament_players`
                                (
                                `id` bigint (20) NOT NULL  AUTO_INCREMENT ,
                                `tourneyid` bigint (20) NOT NULL  DEFAULT 0,
                                `userid` bigint (20) NOT NULL  DEFAULT 0,
                                `teamid` bigint (20),
                                `ranking` bigint (20) NOT NULL  DEFAULT 0,
                                `config_id` tinyint (4) NOT NULL  DEFAULT 0,
                                PRIMARY KEY (id)
                                ) TYPE=MyISAM")) {
                                echo "<font color=#009900>success</font>";
                                } else { echo "<font color=#ff0000>Failed</font>"; $allgood = false; } ?>
        </td>
        </tr>
        <tr>
        <td>New Table: nukelan_tournament_teams&nbsp;&nbsp;
        </td>
            <td><?php if (@mysql_query("CREATE TABLE IF NOT EXISTS `nukelan_tournament_teams`
                                (
                                `id` bigint (20) NOT NULL  AUTO_INCREMENT ,
                                `tourneyid` bigint (20) NOT NULL  DEFAULT 0,
                                `name` varchar (100),
                                `captainid` bigint (20) NOT NULL  DEFAULT 0,
                                `sig` varchar (20),
                                `sigplace` tinyint (1) NOT NULL  DEFAULT 0,
                                `ranking` bigint (20) NOT NULL  DEFAULT 0,
                                `config_id` tinyint (4) NOT NULL  DEFAULT 0,
                                PRIMARY KEY (id)
                                ) TYPE=MyISAM")) {
                                echo "<font color=#009900>success</font>";
                                } else { echo "<font color=#ff0000>Failed</font>"; $allgood = false; } ?>
        </td>
        </tr>
        <tr>
        <td>New Table: nukelan_tournaments&nbsp;&nbsp;
        </td>
            <td><?php if (@mysql_query("CREATE TABLE IF NOT EXISTS `nukelan_tournaments`
                                (
                                `tourneyid` bigint (20) NOT NULL  AUTO_INCREMENT ,
                                `name` varchar (255),
                                `ttype` bigint (20) NOT NULL  DEFAULT 0,
                                `itemtime` datetime,
                                `url_stats` varchar (255) NOT NULL ,
                                `gameid` bigint (20) NOT NULL  DEFAULT 0,
                                `random` tinyint (1),
                                `per_team` INTEGER (10),
                                `ffa` tinyint (1) NOT NULL  DEFAULT 0,
                                `marathon` tinyint (1) NOT NULL  DEFAULT 0,
                                `lockteams` tinyint (1),
                                `lockjoin` tinyint (1),
                                `lockstart` tinyint (1) NOT NULL  DEFAULT 0,
                                `lockfinish` tinyint (1) NOT NULL  DEFAULT 0,
                                `teamcolors` bigint (20) NOT NULL  DEFAULT 0,
                                `playforthird` tinyint (1) NOT NULL  DEFAULT 0,
                                `doublefinal` tinyint (1) NOT NULL  DEFAULT 0,
                                `switchover` INTEGER (4) NOT NULL  DEFAULT 0,
                                `rrsplit` INTEGER (4) NOT NULL  DEFAULT 0,
                                `timelimit` datetime,
                                `moderatorid` bigint (20) NOT NULL  DEFAULT 0,
                                `notes` blob,
                                `settings` blob,
                                `config_id` tinyint (4) NOT NULL  DEFAULT 0,
                                PRIMARY KEY (tourneyid)
                                ) TYPE=MyISAM")) {
                                echo "<font color=#009900>success</font>";
                                } else { echo "<font color=#ff0000>Failed</font>"; $allgood = false; } ?>
        </td>
</tr>
        <tr>
                <td>Set Default Values: nukelan_games</td>
                <td>
                        <?php
                                if (@mysql_query("insert  into nukelan_games values
                                                                (NULL, 'Halo', NULL),
                                                                (NULL, 'Unreal Tournament 2004', NULL),
                                                                (NULL, 'Unreal Tournament 2003', NULL),
                                                                (NULL, 'Halo 2', NULL),
                                                                (NULL, 'Command and Conquer: Generals', NULL),
                                                                (NULL, 'Black Hawk Down', NULL),
                                                                (NULL, 'Delta Force', NULL),
                                                                (NULL, 'Battlefield: 1942', NULL),
                                                                (NULL, 'Battlefield: Vietnam', NULL),
                                                                (NULL, 'FarCry', NULL),
                                                                (NULL, 'Counter-Strike', NULL),
                                                                (NULL, 'Half-Life', NULL),
                                                                (NULL, 'Half-Life 2', NULL),
                                                                (NULL, 'Doom 3', NULL),
                                                                (NULL, 'Painkiller', NULL),
                                                                (NULL, 'Quake I', NULL),
                                                                (NULL, 'Quake II', NULL),
                                                                (NULL, 'Quake 3 Arena', NULL)")) {
                                echo "<font color=#009900>success</font>";
                                } else { echo "<font color=#ff0000>Failed</font>"; $allgood = false; }
                        ?>
                </td>
        </tr>
        <tr>
        <td><b>Installer Results:</b></td>
        <td><?php	if ($allgood = false) {
						echo "<font color=#ff0000>Something screwed up.  Review the list of errors above.</font>";
					} else {
					//	echo '<script type=\'text/javascript\'>alert(\'If there have been no errors, then everything seemed to be installed correctly. Please continue with the next step the Guide.\');</script>';
					}
                ?></td>
        </tr>
        </table>

<?php

    echo"<center><big><font color=\"#FF0000\">DONE.</font></big></center>";
    //echo '<script type=\'text/javascript\'>alert(\'If there have been no errors, then everything seemed to be installed correctly. Please continue with the next step the Guide.\');</script>';
?>
