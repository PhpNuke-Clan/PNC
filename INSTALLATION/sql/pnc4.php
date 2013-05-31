<?php
# ========================================================
#
# pnc4 SQL tabels
# phpnuke-clan.net
#
# ========================================================
if( !defined('PNC_INST')){
die("Access denied!");
}
# --------------------------------------------------------
#
# Table structure for table '".$prefix."_authors'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_authors;");
mysql_query("CREATE TABLE ".$prefix."_authors (
   `aid` varchar(25) NOT NULL,
   `name` varchar(50),
   `url` varchar(255) NOT NULL,
   `email` varchar(255) NOT NULL,
   `pwd` varchar(40),
   `counter` int(11) DEFAULT '0' NOT NULL,
   `radminsuper` tinyint(1) DEFAULT '1' NOT NULL,
   `admlanguage` varchar(30) NOT NULL,
   PRIMARY KEY (aid),
   KEY aid (aid)
);");

#
# Dumping data for table '".$prefix."_authors'
#

# --------------------------------------------------------
#
# Table structure for table '".$prefix."_autonews'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_autonews;");
mysql_query("CREATE TABLE ".$prefix."_autonews (
   `anid` int(11) NOT NULL auto_increment,
   `catid` int(11) DEFAULT '0' NOT NULL,
   `aid` varchar(25) NOT NULL,
   `title` varchar(80) NOT NULL,
   `time` varchar(19) NOT NULL,
   `hometext` text NOT NULL,
   `bodytext` text NOT NULL,
   `topic` int(3) DEFAULT '1' NOT NULL,
   `informant` varchar(25) NOT NULL,
   `notes` text NOT NULL,
   `ihome` int(1) DEFAULT '0' NOT NULL,
   `alanguage` varchar(30) NOT NULL,
   `acomm` int(1) DEFAULT '0' NOT NULL,
   `associated` text NOT NULL,
   PRIMARY KEY (anid),
   KEY anid (anid)
);");

#
# Dumping data for table '".$prefix."_autonews'
#


# --------------------------------------------------------
#
# Table structure for table '".$prefix."_banner'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_banner;");
mysql_query("CREATE TABLE ".$prefix."_banner (
   `bid` int(11) NOT NULL auto_increment,
   `cid` int(11) DEFAULT '0' NOT NULL,
   `imptotal` int(11) DEFAULT '0' NOT NULL,
   `impmade` int(11) DEFAULT '0' NOT NULL,
   `clicks` int(11) DEFAULT '0' NOT NULL,
   `imageurl` varchar(100) NOT NULL,
   `clickurl` varchar(200) NOT NULL,
   `alttext` varchar(255) NOT NULL,
   `date` datetime,
   `dateend` datetime,
   `type` tinyint(1) DEFAULT '0' NOT NULL,
   `active` tinyint(1) DEFAULT '1' NOT NULL,
   PRIMARY KEY (bid),
   KEY bid (bid),
   KEY cid (cid)
);");

#
# Dumping data for table '".$prefix."_banner'
#


# --------------------------------------------------------
#
# Table structure for table '".$prefix."_bannerclient'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_bannerclient;");
mysql_query("CREATE TABLE ".$prefix."_bannerclient (
   `cid` int(11) NOT NULL auto_increment,
   `name` varchar(60) NOT NULL,
   `contact` varchar(60) NOT NULL,
   `email` varchar(60) NOT NULL,
   `login` varchar(10) NOT NULL,
   `passwd` varchar(10) NOT NULL,
   `extrainfo` text NOT NULL,
   PRIMARY KEY (cid),
   KEY cid (cid)
);");

#
# Dumping data for table '".$prefix."_bannerclient'
#


# --------------------------------------------------------
#
# Table structure for table '".$prefix."_bbauth_access'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_bbauth_access;");
mysql_query("CREATE TABLE ".$prefix."_bbauth_access (
   `group_id` mediumint(8) DEFAULT '0' NOT NULL,
   `forum_id` smallint(5) unsigned DEFAULT '0' NOT NULL,
   `auth_view` tinyint(1) DEFAULT '0' NOT NULL,
   `auth_read` tinyint(1) DEFAULT '0' NOT NULL,
   `auth_post` tinyint(1) DEFAULT '0' NOT NULL,
   `auth_reply` tinyint(1) DEFAULT '0' NOT NULL,
   `auth_edit` tinyint(1) DEFAULT '0' NOT NULL,
   `auth_delete` tinyint(1) DEFAULT '0' NOT NULL,
   `auth_sticky` tinyint(1) DEFAULT '0' NOT NULL,
   `auth_announce` tinyint(1) DEFAULT '0' NOT NULL,
   `auth_vote` tinyint(1) DEFAULT '0' NOT NULL,
   `auth_pollcreate` tinyint(1) DEFAULT '0' NOT NULL,
   `auth_attachments` tinyint(1) DEFAULT '0' NOT NULL,
   `auth_mod` tinyint(1) DEFAULT '0' NOT NULL,
   KEY group_id (group_id),
   KEY forum_id (forum_id)
);");

#
# Dumping data for table '".$prefix."_bbauth_access'
#


# --------------------------------------------------------
#
# Table structure for table '".$prefix."_bbbanlist'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_bbbanlist;");
mysql_query("CREATE TABLE ".$prefix."_bbbanlist (
   `ban_id` mediumint(8) unsigned NOT NULL auto_increment,
   `ban_userid` mediumint(8) DEFAULT '0' NOT NULL,
   `ban_ip` varchar(8) NOT NULL,
   `ban_email` varchar(255),
   `ban_time` int(11),
   `ban_expire_time` int(11),
   `ban_by_userid` mediumint(8),
   `ban_priv_reason` text,
   `ban_pub_reason_mode` tinyint(1),
   `ban_pub_reason` text,
   PRIMARY KEY (ban_id),
   KEY ban_ip_user_id (ban_ip, ban_userid)
);");

#
# Dumping data for table '".$prefix."_bbbanlist'
#


# --------------------------------------------------------
#
# Table structure for table '".$prefix."_bbcategories'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_bbcategories;");
mysql_query("CREATE TABLE ".$prefix."_bbcategories (
   `cat_id` mediumint(8) unsigned NOT NULL auto_increment,
   `cat_title` varchar(100),
   `cat_order` mediumint(8) unsigned DEFAULT '0' NOT NULL,
   PRIMARY KEY (cat_id),
   KEY cat_order (cat_order)
);");

#
# Dumping data for table '".$prefix."_bbcategories'
#


# --------------------------------------------------------
#
# Table structure for table '".$prefix."_bbconfig'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_bbconfig;");
mysql_query("CREATE TABLE ".$prefix."_bbconfig (
   `config_name` varchar(255) NOT NULL,
   `config_value` varchar(255) NOT NULL,
   PRIMARY KEY (config_name)
);");

#
# Dumping data for table '".$prefix."_bbconfig'
#
$cookiesite = $_SERVER['SERVER_NAME'];
mysql_query("INSERT INTO ".$prefix."_bbconfig VALUES ('allow_autologin', '1');");
mysql_query("INSERT INTO ".$prefix."_bbconfig VALUES ('allow_avatar_local', '1');");
mysql_query("INSERT INTO ".$prefix."_bbconfig VALUES ('allow_avatar_remote', '0');");
mysql_query("INSERT INTO ".$prefix."_bbconfig VALUES ('allow_avatar_upload', '0');");
mysql_query("INSERT INTO ".$prefix."_bbconfig VALUES ('allow_bbcode', '1');");
mysql_query("INSERT INTO ".$prefix."_bbconfig VALUES ('allow_html', '1');");
mysql_query("INSERT INTO ".$prefix."_bbconfig VALUES ('allow_html_tags', 'b,i,u,pre');");
mysql_query("INSERT INTO ".$prefix."_bbconfig VALUES ('allow_namechange', '0');");
mysql_query("INSERT INTO ".$prefix."_bbconfig VALUES ('allow_sig', '1');");
mysql_query("INSERT INTO ".$prefix."_bbconfig VALUES ('allow_smilies', '1');");
mysql_query("INSERT INTO ".$prefix."_bbconfig VALUES ('allow_theme_create', '');");
mysql_query("INSERT INTO ".$prefix."_bbconfig VALUES ('avatar_filesize', '6144');");
mysql_query("INSERT INTO ".$prefix."_bbconfig VALUES ('avatar_gallery_path', 'modules/Forums/images/avatars');");
mysql_query("INSERT INTO ".$prefix."_bbconfig VALUES ('avatar_max_height', '80');");
mysql_query("INSERT INTO ".$prefix."_bbconfig VALUES ('avatar_max_width', '80');");
mysql_query("INSERT INTO ".$prefix."_bbconfig VALUES ('avatar_path', 'modules/Forums/images/avatars');");
mysql_query("INSERT INTO ".$prefix."_bbconfig VALUES ('board_disable', '0');");
mysql_query("INSERT INTO ".$prefix."_bbconfig VALUES ('board_email', 'Webmaster@MySite.com');");
mysql_query("INSERT INTO ".$prefix."_bbconfig VALUES ('board_email_form', '0');");
mysql_query("INSERT INTO ".$prefix."_bbconfig VALUES ('board_email_sig', 'Thanks, Webmaster@MySite.com');");
mysql_query("INSERT INTO ".$prefix."_bbconfig VALUES ('board_startdate', '1013908210');");
mysql_query("INSERT INTO ".$prefix."_bbconfig VALUES ('board_timezone', '10');");
mysql_query("INSERT INTO ".$prefix."_bbconfig VALUES ('config_id', '1');");
mysql_query("INSERT INTO ".$prefix."_bbconfig VALUES ('cookie_domain', '$cookiesite');");
mysql_query("INSERT INTO ".$prefix."_bbconfig VALUES ('cookie_name', 'pnc4phpbb');");
mysql_query("INSERT INTO ".$prefix."_bbconfig VALUES ('cookie_path', '/');");
mysql_query("INSERT INTO ".$prefix."_bbconfig VALUES ('cookie_secure', '0');");
mysql_query("INSERT INTO ".$prefix."_bbconfig VALUES ('coppa_fax', '');");
mysql_query("INSERT INTO ".$prefix."_bbconfig VALUES ('coppa_mail', '');");
mysql_query("INSERT INTO ".$prefix."_bbconfig VALUES ('default_dateformat', 'D M d, Y g:i a');");
mysql_query("INSERT INTO ".$prefix."_bbconfig VALUES ('default_lang', 'english');");
mysql_query("INSERT INTO ".$prefix."_bbconfig VALUES ('default_style', '1');");
mysql_query("INSERT INTO ".$prefix."_bbconfig VALUES ('enable_confirm', '0');");
mysql_query("INSERT INTO ".$prefix."_bbconfig VALUES ('flood_interval', '15');");
mysql_query("INSERT INTO ".$prefix."_bbconfig VALUES ('gzip_compress', '0');");
mysql_query("INSERT INTO ".$prefix."_bbconfig VALUES ('hot_threshold', '25');");
mysql_query("INSERT INTO ".$prefix."_bbconfig VALUES ('login_reset_time', '30');");
mysql_query("INSERT INTO ".$prefix."_bbconfig VALUES ('max_autologin_time', '0');");
mysql_query("INSERT INTO ".$prefix."_bbconfig VALUES ('max_inbox_privmsgs', '100');");
mysql_query("INSERT INTO ".$prefix."_bbconfig VALUES ('max_login_attempts', '5');");
mysql_query("INSERT INTO ".$prefix."_bbconfig VALUES ('max_poll_options', '10');");
mysql_query("INSERT INTO ".$prefix."_bbconfig VALUES ('max_savebox_privmsgs', '100');");
mysql_query("INSERT INTO ".$prefix."_bbconfig VALUES ('max_sentbox_privmsgs', '100');");
mysql_query("INSERT INTO ".$prefix."_bbconfig VALUES ('max_sig_chars', '255');");
mysql_query("INSERT INTO ".$prefix."_bbconfig VALUES ('override_user_style', '1');");
mysql_query("INSERT INTO ".$prefix."_bbconfig VALUES ('posts_per_page', '15');");
mysql_query("INSERT INTO ".$prefix."_bbconfig VALUES ('privmsg_disable', '0');");
mysql_query("INSERT INTO ".$prefix."_bbconfig VALUES ('prune_enable', '0');");
mysql_query("INSERT INTO ".$prefix."_bbconfig VALUES ('rand_seed', '2498fc0ea1f5908a140f54b68eac0d3d');");
mysql_query("INSERT INTO ".$prefix."_bbconfig VALUES ('record_online_date', '1034668530');");
mysql_query("INSERT INTO ".$prefix."_bbconfig VALUES ('record_online_users', '2');");
mysql_query("INSERT INTO ".$prefix."_bbconfig VALUES ('require_activation', '0');");
mysql_query("INSERT INTO ".$prefix."_bbconfig VALUES ('script_path', '/modules/Forums/');");
mysql_query("INSERT INTO ".$prefix."_bbconfig VALUES ('search_flood_interval', '15');");
mysql_query("INSERT INTO ".$prefix."_bbconfig VALUES ('search_min_chars', '3');");
mysql_query("INSERT INTO ".$prefix."_bbconfig VALUES ('sendmail_fix', '');");
mysql_query("INSERT INTO ".$prefix."_bbconfig VALUES ('server_name', 'yoursute.com');");
mysql_query("INSERT INTO ".$prefix."_bbconfig VALUES ('server_port', '80');");
mysql_query("INSERT INTO ".$prefix."_bbconfig VALUES ('session_length', '3600');");
mysql_query("INSERT INTO ".$prefix."_bbconfig VALUES ('sitename', 'MySite.com');");
mysql_query("INSERT INTO ".$prefix."_bbconfig VALUES ('site_desc', '');");
mysql_query("INSERT INTO ".$prefix."_bbconfig VALUES ('smilies_path', 'modules/Forums/images/smiles');");
mysql_query("INSERT INTO ".$prefix."_bbconfig VALUES ('smtp_delivery', '0');");
mysql_query("INSERT INTO ".$prefix."_bbconfig VALUES ('smtp_host', '');");
mysql_query("INSERT INTO ".$prefix."_bbconfig VALUES ('smtp_password', '');");
mysql_query("INSERT INTO ".$prefix."_bbconfig VALUES ('smtp_username', '');");
mysql_query("INSERT INTO ".$prefix."_bbconfig VALUES ('topics_per_page', '50');");
mysql_query("INSERT INTO ".$prefix."_bbconfig VALUES ('version', '.0.23');");

# --------------------------------------------------------
#
# Table structure for table '".$prefix."_bbdisallow'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_bbdisallow;");
mysql_query("CREATE TABLE ".$prefix."_bbdisallow (
   `disallow_id` mediumint(8) unsigned NOT NULL auto_increment,
   `disallow_username` varchar(25),
   PRIMARY KEY (disallow_id)
);");

#
# Dumping data for table '".$prefix."_bbdisallow'
#


# --------------------------------------------------------
#
# Table structure for table '".$prefix."_bbforum_prune'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_bbforum_prune;");
mysql_query("CREATE TABLE ".$prefix."_bbforum_prune (
   `prune_id` mediumint(8) unsigned NOT NULL auto_increment,
   `forum_id` smallint(5) unsigned DEFAULT '0' NOT NULL,
   `prune_days` tinyint(4) unsigned DEFAULT '0' NOT NULL,
   `prune_freq` tinyint(4) unsigned DEFAULT '0' NOT NULL,
   PRIMARY KEY (prune_id),
   KEY forum_id (forum_id)
);");

#
# Dumping data for table '".$prefix."_bbforum_prune'
#


# --------------------------------------------------------
#
# Table structure for table '".$prefix."_bbforums'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_bbforums;");
mysql_query("CREATE TABLE ".$prefix."_bbforums (
   `forum_id` smallint(5) unsigned NOT NULL auto_increment,
   `cat_id` mediumint(8) unsigned DEFAULT '0' NOT NULL,
   `forum_name` varchar(150),
   `forum_desc` text,
   `forum_status` tinyint(4) DEFAULT '0' NOT NULL,
   `forum_order` mediumint(8) unsigned DEFAULT '1' NOT NULL,
   `forum_posts` mediumint(8) unsigned DEFAULT '0' NOT NULL,
   `forum_topics` mediumint(8) unsigned DEFAULT '0' NOT NULL,
   `forum_last_post_id` mediumint(8) unsigned DEFAULT '0' NOT NULL,
   `prune_next` int(11),
   `prune_enable` tinyint(1) DEFAULT '1' NOT NULL,
   `auth_view` tinyint(2) DEFAULT '0' NOT NULL,
   `auth_read` tinyint(2) DEFAULT '0' NOT NULL,
   `auth_post` tinyint(2) DEFAULT '0' NOT NULL,
   `auth_reply` tinyint(2) DEFAULT '0' NOT NULL,
   `auth_edit` tinyint(2) DEFAULT '0' NOT NULL,
   `auth_delete` tinyint(2) DEFAULT '0' NOT NULL,
   `auth_sticky` tinyint(2) DEFAULT '0' NOT NULL,
   `auth_announce` tinyint(2) DEFAULT '0' NOT NULL,
   `auth_vote` tinyint(2) DEFAULT '0' NOT NULL,
   `auth_pollcreate` tinyint(2) DEFAULT '0' NOT NULL,
   `auth_attachments` tinyint(2) DEFAULT '0' NOT NULL,
   PRIMARY KEY (forum_id),
   KEY forums_order (forum_order),
   KEY cat_id (cat_id),
   KEY forum_last_post_id (forum_last_post_id)
);");

#
# Dumping data for table '".$prefix."_bbforums'
#


# --------------------------------------------------------
#
# Table structure for table '".$prefix."_bbgroups'
#

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

mysql_query("INSERT INTO ".$prefix."_bbgroups VALUES ('1', '1', 'Anonymous', 'Personal User', '0', '1');");
mysql_query("INSERT INTO ".$prefix."_bbgroups VALUES ('2', '2', 'Moderators', 'Moderators of this forum.', '2', '0');");
mysql_query("INSERT INTO ".$prefix."_bbgroups VALUES ('3', '1', '', 'Personal User', '0', '1');");


# --------------------------------------------------------
#
# Table structure for table '".$prefix."_bbposts'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_bbposts;");
mysql_query("CREATE TABLE ".$prefix."_bbposts (
   `post_id` mediumint(8) unsigned NOT NULL auto_increment,
   `topic_id` mediumint(8) unsigned DEFAULT '0' NOT NULL,
   `forum_id` smallint(5) unsigned DEFAULT '0' NOT NULL,
   `poster_id` mediumint(8) DEFAULT '0' NOT NULL,
   `post_time` int(11) DEFAULT '0' NOT NULL,
   `poster_ip` varchar(8) NOT NULL,
   `post_username` varchar(25),
   `enable_bbcode` tinyint(1) DEFAULT '1' NOT NULL,
   `enable_html` tinyint(1) DEFAULT '0' NOT NULL,
   `enable_smilies` tinyint(1) DEFAULT '1' NOT NULL,
   `enable_sig` tinyint(1) DEFAULT '1' NOT NULL,
   `post_edit_time` int(11),
   `post_edit_count` smallint(5) unsigned DEFAULT '0' NOT NULL,
   PRIMARY KEY (post_id),
   KEY forum_id (forum_id),
   KEY topic_id (topic_id),
   KEY poster_id (poster_id),
   KEY post_time (post_time)
);");

#
# Dumping data for table '".$prefix."_bbposts'
#


# --------------------------------------------------------
#
# Table structure for table '".$prefix."_bbposts_text'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_bbposts_text;");
mysql_query("CREATE TABLE ".$prefix."_bbposts_text (
   `post_id` mediumint(8) unsigned DEFAULT '0' NOT NULL,
   `bbcode_uid` varchar(10) NOT NULL,
   `post_subject` varchar(60),
   `post_text` text,
   PRIMARY KEY (post_id)
);");

#
# Dumping data for table '".$prefix."_bbposts_text'
#


# --------------------------------------------------------
#
# Table structure for table '".$prefix."_bbprivmsgs'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_bbprivmsgs;");
mysql_query("CREATE TABLE ".$prefix."_bbprivmsgs (
   `privmsgs_id` mediumint(8) unsigned NOT NULL auto_increment,
   `privmsgs_type` tinyint(4) DEFAULT '0' NOT NULL,
   `privmsgs_subject` varchar(255) DEFAULT '0' NOT NULL,
   `privmsgs_from_userid` mediumint(8) DEFAULT '0' NOT NULL,
   `privmsgs_to_userid` mediumint(8) DEFAULT '0' NOT NULL,
   `privmsgs_date` int(11) DEFAULT '0' NOT NULL,
   `privmsgs_ip` varchar(8) NOT NULL,
   `privmsgs_enable_bbcode` tinyint(1) DEFAULT '1' NOT NULL,
   `privmsgs_enable_html` tinyint(1) DEFAULT '0' NOT NULL,
   `privmsgs_enable_smilies` tinyint(1) DEFAULT '1' NOT NULL,
   `privmsgs_attach_sig` tinyint(1) DEFAULT '1' NOT NULL,
   PRIMARY KEY (privmsgs_id),
   KEY privmsgs_from_userid (privmsgs_from_userid),
   KEY privmsgs_to_userid (privmsgs_to_userid)
);");

#
# Dumping data for table '".$prefix."_bbprivmsgs'
#


# --------------------------------------------------------
#
# Table structure for table '".$prefix."_bbprivmsgs_text'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_bbprivmsgs_text;");
mysql_query("CREATE TABLE ".$prefix."_bbprivmsgs_text (
   `privmsgs_text_id` mediumint(8) unsigned DEFAULT '0' NOT NULL,
   `privmsgs_bbcode_uid` varchar(10) DEFAULT '0' NOT NULL,
   `privmsgs_text` text,
   PRIMARY KEY (privmsgs_text_id)
);");

#
# Dumping data for table '".$prefix."_bbprivmsgs_text'
#


# --------------------------------------------------------
#
# Table structure for table '".$prefix."_bbranks'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_bbranks;");
mysql_query("CREATE TABLE ".$prefix."_bbranks (
   `rank_id` smallint(5) unsigned NOT NULL auto_increment,
   `rank_title` varchar(50) NOT NULL,
   `rank_min` mediumint(8) DEFAULT '0' NOT NULL,
   `rank_max` mediumint(8) DEFAULT '0' NOT NULL,
   `rank_special` tinyint(1) DEFAULT '0',
   `rank_image` varchar(255),
   PRIMARY KEY (rank_id)
);");

#
# Dumping data for table '".$prefix."_bbranks'
#

mysql_query("INSERT INTO ".$prefix."_bbranks VALUES ('1', 'Site Admin', '-1', '-1', '1', 'modules/Forums/images/ranks/6stars.gif');");
mysql_query("INSERT INTO ".$prefix."_bbranks VALUES ('2', 'Newbie', '1', '0', '0', 'modules/Forums/images/ranks/1star.gif');");

# --------------------------------------------------------
#
# Table structure for table '".$prefix."_bbsearch_results'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_bbsearch_results;");
mysql_query("CREATE TABLE ".$prefix."_bbsearch_results (
   `search_id` int(11) unsigned DEFAULT '0' NOT NULL,
   `session_id` varchar(32) NOT NULL,
   `search_array` text NOT NULL,
   `search_time` int(11) DEFAULT '0' NOT NULL,
   PRIMARY KEY (search_id),
   KEY session_id (session_id)
);");

#
# Dumping data for table '".$prefix."_bbsearch_results'
#


# --------------------------------------------------------
#
# Table structure for table '".$prefix."_bbsearch_wordlist'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_bbsearch_wordlist;");
mysql_query("CREATE TABLE ".$prefix."_bbsearch_wordlist (
   `word_text` varchar(50) NOT NULL,
   `word_id` mediumint(8) unsigned NOT NULL auto_increment,
   `word_common` tinyint(1) unsigned DEFAULT '0' NOT NULL,
   PRIMARY KEY (word_text),
   KEY word_id (word_id)
);");


# --------------------------------------------------------
#
# Table structure for table '".$prefix."_bbsearch_wordmatch'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_bbsearch_wordmatch;");
mysql_query("CREATE TABLE ".$prefix."_bbsearch_wordmatch (
   `post_id` mediumint(8) unsigned DEFAULT '0' NOT NULL,
   `word_id` mediumint(8) unsigned DEFAULT '0' NOT NULL,
   `title_match` tinyint(1) DEFAULT '0' NOT NULL,
   KEY word_id (word_id)
);");


# --------------------------------------------------------
#
# Table structure for table '".$prefix."_bbsessions'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_bbsessions;");
mysql_query("CREATE TABLE ".$prefix."_bbsessions (
   `session_id` char(32) NOT NULL,
   `session_user_id` mediumint(8) DEFAULT '0' NOT NULL,
   `session_start` int(11) DEFAULT '0' NOT NULL,
   `session_time` int(11) DEFAULT '0' NOT NULL,
   `session_ip` char(8) DEFAULT '0' NOT NULL,
   `session_page` int(11) DEFAULT '0' NOT NULL,
   `session_logged_in` tinyint(1) DEFAULT '0' NOT NULL,
   `session_admin` tinyint(2) DEFAULT '0' NOT NULL,
   PRIMARY KEY (session_id),
   KEY session_user_id (session_user_id),
   KEY session_id_ip_user_id (session_id, session_ip, session_user_id)
);");

# --------------------------------------------------------
#
# Table structure for table '".$prefix."_bbsessions_keys'
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
# Table structure for table '".$prefix."_bbsmilies'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_bbsmilies;");
mysql_query("CREATE TABLE ".$prefix."_bbsmilies (
   `smilies_id` smallint(5) unsigned NOT NULL auto_increment,
   `code` varchar(50),
   `smile_url` varchar(100),
   `emoticon` varchar(75),
   PRIMARY KEY (smilies_id)
);");

#
# Dumping data for table '".$prefix."_bbsmilies'
#

mysql_query("INSERT INTO ".$prefix."_bbsmilies VALUES ('1', ':D', 'icon_biggrin.gif', 'Very Happy');");
mysql_query("INSERT INTO ".$prefix."_bbsmilies VALUES ('2', ':-D', 'icon_biggrin.gif', 'Very Happy');");
mysql_query("INSERT INTO ".$prefix."_bbsmilies VALUES ('3', ':grin:', 'icon_biggrin.gif', 'Very Happy');");
mysql_query("INSERT INTO ".$prefix."_bbsmilies VALUES ('4', ':)', 'icon_smile.gif', 'Smile');");
mysql_query("INSERT INTO ".$prefix."_bbsmilies VALUES ('5', ':-)', 'icon_smile.gif', 'Smile');");
mysql_query("INSERT INTO ".$prefix."_bbsmilies VALUES ('6', ':smile:', 'icon_smile.gif', 'Smile');");
mysql_query("INSERT INTO ".$prefix."_bbsmilies VALUES ('7', ':(', 'icon_sad.gif', 'Sad');");
mysql_query("INSERT INTO ".$prefix."_bbsmilies VALUES ('8', ':-(', 'icon_sad.gif', 'Sad');");
mysql_query("INSERT INTO ".$prefix."_bbsmilies VALUES ('9', ':sad:', 'icon_sad.gif', 'Sad');");
mysql_query("INSERT INTO ".$prefix."_bbsmilies VALUES ('10', ':o', 'icon_surprised.gif', 'Surprised');");
mysql_query("INSERT INTO ".$prefix."_bbsmilies VALUES ('11', ':-o', 'icon_surprised.gif', 'Surprised');");
mysql_query("INSERT INTO ".$prefix."_bbsmilies VALUES ('12', ':eek:', 'icon_surprised.gif', 'Surprised');");
mysql_query("INSERT INTO ".$prefix."_bbsmilies VALUES ('13', '8O', 'icon_eek.gif', 'Shocked');");
mysql_query("INSERT INTO ".$prefix."_bbsmilies VALUES ('14', '8-O', 'icon_eek.gif', 'Shocked');");
mysql_query("INSERT INTO ".$prefix."_bbsmilies VALUES ('15', ':shock:', 'icon_eek.gif', 'Shocked');");
mysql_query("INSERT INTO ".$prefix."_bbsmilies VALUES ('16', ':?', 'icon_confused.gif', 'Confused');");
mysql_query("INSERT INTO ".$prefix."_bbsmilies VALUES ('17', ':-?', 'icon_confused.gif', 'Confused');");
mysql_query("INSERT INTO ".$prefix."_bbsmilies VALUES ('18', ':???:', 'icon_confused.gif', 'Confused');");
mysql_query("INSERT INTO ".$prefix."_bbsmilies VALUES ('19', '8)', 'icon_cool.gif', 'Cool');");
mysql_query("INSERT INTO ".$prefix."_bbsmilies VALUES ('20', '8-)', 'icon_cool.gif', 'Cool');");
mysql_query("INSERT INTO ".$prefix."_bbsmilies VALUES ('21', ':cool:', 'icon_cool.gif', 'Cool');");
mysql_query("INSERT INTO ".$prefix."_bbsmilies VALUES ('22', ':lol:', 'icon_lol.gif', 'Laughing');");
mysql_query("INSERT INTO ".$prefix."_bbsmilies VALUES ('23', ':x', 'icon_mad.gif', 'Mad');");
mysql_query("INSERT INTO ".$prefix."_bbsmilies VALUES ('24', ':-x', 'icon_mad.gif', 'Mad');");
mysql_query("INSERT INTO ".$prefix."_bbsmilies VALUES ('25', ':mad:', 'icon_mad.gif', 'Mad');");
mysql_query("INSERT INTO ".$prefix."_bbsmilies VALUES ('26', ':P', 'icon_razz.gif', 'Razz');");
mysql_query("INSERT INTO ".$prefix."_bbsmilies VALUES ('27', ':-P', 'icon_razz.gif', 'Razz');");
mysql_query("INSERT INTO ".$prefix."_bbsmilies VALUES ('28', ':razz:', 'icon_razz.gif', 'Razz');");
mysql_query("INSERT INTO ".$prefix."_bbsmilies VALUES ('29', ':oops:', 'icon_redface.gif', 'Embarassed');");
mysql_query("INSERT INTO ".$prefix."_bbsmilies VALUES ('30', ':cry:', 'icon_cry.gif', 'Crying or Very sad');");
mysql_query("INSERT INTO ".$prefix."_bbsmilies VALUES ('31', ':evil:', 'icon_evil.gif', 'Evil or Very Mad');");
mysql_query("INSERT INTO ".$prefix."_bbsmilies VALUES ('32', ':twisted:', 'icon_twisted.gif', 'Twisted Evil');");
mysql_query("INSERT INTO ".$prefix."_bbsmilies VALUES ('33', ':roll:', 'icon_rolleyes.gif', 'Rolling Eyes');");
mysql_query("INSERT INTO ".$prefix."_bbsmilies VALUES ('34', ':wink:', 'icon_wink.gif', 'Wink');");
mysql_query("INSERT INTO ".$prefix."_bbsmilies VALUES ('35', ';)', 'icon_wink.gif', 'Wink');");
mysql_query("INSERT INTO ".$prefix."_bbsmilies VALUES ('36', ';-)', 'icon_wink.gif', 'Wink');");
mysql_query("INSERT INTO ".$prefix."_bbsmilies VALUES ('37', ':!:', 'icon_exclaim.gif', 'Exclamation');");
mysql_query("INSERT INTO ".$prefix."_bbsmilies VALUES ('38', ':?:', 'icon_question.gif', 'Question');");
mysql_query("INSERT INTO ".$prefix."_bbsmilies VALUES ('39', ':idea:', 'icon_idea.gif', 'Idea');");
mysql_query("INSERT INTO ".$prefix."_bbsmilies VALUES ('40', ':arrow:', 'icon_arrow.gif', 'Arrow');");
mysql_query("INSERT INTO ".$prefix."_bbsmilies VALUES ('41', ':|', 'icon_neutral.gif', 'Neutral');");
mysql_query("INSERT INTO ".$prefix."_bbsmilies VALUES ('42', ':-|', 'icon_neutral.gif', 'Neutral');");
mysql_query("INSERT INTO ".$prefix."_bbsmilies VALUES ('43', ':neutral:', 'icon_neutral.gif', 'Neutral');");
mysql_query("INSERT INTO ".$prefix."_bbsmilies VALUES ('44', ':mrgreen:', 'icon_mrgreen.gif', 'Mr. Green');");

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
# Table structure for table '".$prefix."_bbthemes_name'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_bbthemes_name;");
mysql_query("CREATE TABLE ".$prefix."_bbthemes_name (
   `themes_id` smallint(5) unsigned DEFAULT '0' NOT NULL,
   `tr_color1_name` char(50),
   `tr_color2_name` char(50),
   `tr_color3_name` char(50),
   `tr_class1_name` char(50),
   `tr_class2_name` char(50),
   `tr_class3_name` char(50),
   `th_color1_name` char(50),
   `th_color2_name` char(50),
   `th_color3_name` char(50),
   `th_class1_name` char(50),
   `th_class2_name` char(50),
   `th_class3_name` char(50),
   `td_color1_name` char(50),
   `td_color2_name` char(50),
   `td_color3_name` char(50),
   `td_class1_name` char(50),
   `td_class2_name` char(50),
   `td_class3_name` char(50),
   `fontface1_name` char(50),
   `fontface2_name` char(50),
   `fontface3_name` char(50),
   `fontsize1_name` char(50),
   `fontsize2_name` char(50),
   `fontsize3_name` char(50),
   `fontcolor1_name` char(50),
   `fontcolor2_name` char(50),
   `fontcolor3_name` char(50),
   `span_class1_name` char(50),
   `span_class2_name` char(50),
   `span_class3_name` char(50),
   PRIMARY KEY (themes_id)
);");

#
# Dumping data for table '".$prefix."_bbthemes_name'
#

mysql_query("INSERT INTO ".$prefix."_bbthemes_name VALUES ('1', 'The lightest row colour', 'The medium row color', 'The darkest row colour', '', '', '', 'Border round the whole page', 'Outer table border', 'Inner table border', 'Silver gradient picture', 'Blue gradient picture', 'Fade-out gradient on index', 'Background for quote boxes', 'All white areas', '', 'Background for topic posts', '2nd background for topic posts', '', 'Main fonts', 'Additional topic title font', 'Form fonts', 'Smallest font size', 'Medium font size', 'Normal font size (post body etc)', 'Quote & copyright text', 'Code text colour', 'Main table header text colour', '', '', '');");

# --------------------------------------------------------
#
# Table structure for table '".$prefix."_bbtopics'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_bbtopics;");
mysql_query("CREATE TABLE ".$prefix."_bbtopics (
   `topic_id` mediumint(8) unsigned NOT NULL auto_increment,
   `forum_id` smallint(8) unsigned DEFAULT '0' NOT NULL,
   `topic_title` char(60) NOT NULL,
   `topic_poster` mediumint(8) DEFAULT '0' NOT NULL,
   `topic_time` int(11) DEFAULT '0' NOT NULL,
   `topic_views` mediumint(8) unsigned DEFAULT '0' NOT NULL,
   `topic_replies` mediumint(8) unsigned DEFAULT '0' NOT NULL,
   `topic_status` tinyint(3) DEFAULT '0' NOT NULL,
   `topic_vote` tinyint(1) DEFAULT '0' NOT NULL,
   `topic_type` tinyint(3) DEFAULT '0' NOT NULL,
   `topic_last_post_id` mediumint(8) unsigned DEFAULT '0' NOT NULL,
   `topic_first_post_id` mediumint(8) unsigned DEFAULT '0' NOT NULL,
   `topic_moved_id` mediumint(8) unsigned DEFAULT '0' NOT NULL,
   PRIMARY KEY (topic_id),
   KEY forum_id (forum_id),
   KEY topic_moved_id (topic_moved_id),
   KEY topic_status (topic_status),
   KEY topic_type (topic_type)
);");

#
# Dumping data for table '".$prefix."_bbtopics'
#

mysql_query("INSERT INTO ".$prefix."_bbtopics VALUES ('1', '1', 'test', '2', '1143050910', '2', '0', '0', '0', '0', '1', '1', '0');");

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
  PRIMARY KEY (group_id, user_id),
   KEY user_pending(user_pending)
);");

#
# Dumping data for table '".$prefix."_bbuser_group'
#

mysql_query("INSERT INTO ".$prefix."_bbuser_group VALUES ('1', '-1', 0);");
mysql_query("INSERT INTO ".$prefix."_bbuser_group VALUES ('2', '2', 0);");
mysql_query("INSERT INTO ".$prefix."_bbuser_group VALUES ('3', '2', 0);");

# --------------------------------------------------------
#
# Table structure for table '".$prefix."_bbvote_desc'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_bbvote_desc;");
mysql_query("CREATE TABLE ".$prefix."_bbvote_desc (
   `vote_id` mediumint(8) unsigned NOT NULL auto_increment,
   `topic_id` mediumint(8) unsigned DEFAULT '0' NOT NULL,
   `vote_text` text NOT NULL,
   `vote_start` int(11) DEFAULT '0' NOT NULL,
   `vote_length` int(11) DEFAULT '0' NOT NULL,
   PRIMARY KEY (vote_id),
   KEY topic_id (topic_id)
);");

#
# Dumping data for table '".$prefix."_bbvote_desc'
#


# --------------------------------------------------------
#
# Table structure for table '".$prefix."_bbvote_results'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_bbvote_results;");
mysql_query("CREATE TABLE ".$prefix."_bbvote_results (
   `vote_id` mediumint(8) unsigned DEFAULT '0' NOT NULL,
   `vote_option_id` tinyint(4) unsigned DEFAULT '0' NOT NULL,
   `vote_option_text` varchar(255) NOT NULL,
   `vote_result` int(11) DEFAULT '0' NOT NULL,
   KEY vote_option_id (vote_option_id),
   KEY vote_id (vote_id)
);");

#
# Dumping data for table '".$prefix."_bbvote_results'
#


# --------------------------------------------------------
#
# Table structure for table '".$prefix."_bbvote_voters'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_bbvote_voters;");
mysql_query("CREATE TABLE ".$prefix."_bbvote_voters (
   `vote_id` mediumint(8) unsigned DEFAULT '0' NOT NULL,
   `vote_user_id` mediumint(8) DEFAULT '0' NOT NULL,
   `vote_user_ip` char(8) NOT NULL,
   KEY vote_id (vote_id),
   KEY vote_user_id (vote_user_id),
   KEY vote_user_ip (vote_user_ip)
);");

#
# Dumping data for table '".$prefix."_bbvote_voters'
#


# --------------------------------------------------------
#
# Table structure for table '".$prefix."_bbwords'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_bbwords;");
mysql_query("CREATE TABLE ".$prefix."_bbwords (
   `word_id` mediumint(8) unsigned NOT NULL auto_increment,
   `word` char(100) NOT NULL,
   `replacement` char(100) NOT NULL,
   PRIMARY KEY (word_id)
);");

#
# Dumping data for table '".$prefix."_bbwords'
#


# --------------------------------------------------------
#
# Table structure for table '".$prefix."_blocks'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_blocks;");
mysql_query("CREATE TABLE ".$prefix."_blocks (
   `bid` int(10) NOT NULL auto_increment,
   `bkey` varchar(15) NOT NULL,
   `title` varchar(60) NOT NULL,
   `content` text NOT NULL,
   `url` varchar(200) NOT NULL,
   `bposition` char(1) NOT NULL,
   `weight` int(10) DEFAULT '1' NOT NULL,
   `active` int(1) DEFAULT '1' NOT NULL,
   `refresh` int(10) DEFAULT '0' NOT NULL,
   `time` varchar(14) DEFAULT '0' NOT NULL,
   `blanguage` varchar(30) NOT NULL,
   `blockfile` varchar(255) NOT NULL,
   `view` int(1) DEFAULT '0' NOT NULL,
   `groups` text NOT NULL,
   `expire` varchar(14) DEFAULT '0' NOT NULL,
   `action` char(1) NOT NULL,
   `subscription` int(1) DEFAULT '0' NOT NULL,
   `display` varchar(255) DEFAULT 'All' NOT NULL,
   PRIMARY KEY (bid),
   KEY bid (bid),
   KEY title (title)
);");

#
# Dumping data for table '".$prefix."_blocks'
#

mysql_query("INSERT INTO ".$prefix."_blocks VALUES ('1', '', 'MENU', '', '', 'l', '3', '1', '0', '', '', 'block-Sommaire.php', '0', '', '0', 'd', '0', 'All');");
mysql_query("INSERT INTO ".$prefix."_blocks VALUES ('2', '', 'Administration', '', '', 'l', '5', '1', '1800', '', '', 'block-Admin.php', '2', '', '0', 'd', '1', 'All');");
mysql_query("INSERT INTO ".$prefix."_blocks VALUES ('4', '', 'Survey', '', '', 'r', '1', '1', '0', '', '', 'block-Survey.php', '0', '', '0', 'd', '0', 'All');");
mysql_query("INSERT INTO ".$prefix."_blocks VALUES ('5', '', 'User Info', '', '', 'r', '5', '1', '0', '', '', 'block-User_Info_login.php', '0', '', '0', 'd', '0', 'All');");
mysql_query("INSERT INTO ".$prefix."_blocks VALUES ('9', '', 'Shout Box', '', '', 'l', '9', '0', '0', '', '', 'block-Shout_Box.php', '0', '', '0', 'd', '0', 'All');");
//mysql_query("INSERT INTO ".$prefix."_blocks VALUES ('12', '', 'PNC 4.0 installed!', '', '', 'c', '1', '1', '0', '', '', 'block-Install.php', '0', '', '0', 'd', '0', 'All');");
mysql_query("INSERT INTO ".$prefix."_blocks VALUES ('13', '', 'Supporters', '', '', 'c', '2', '1', '0', '', '', 'block-Supporters_Up.php', '0', '', '0', 'd', '0', 'All');");
mysql_query("INSERT INTO ".$prefix."_blocks VALUES ('15', 'userbox', 'User\'s Custom Box', '', '', 'r', '2', '0', '0', '', '', '', '1', '', '0', 'd', '0', 'All');");
mysql_query("INSERT INTO ".$prefix."_blocks VALUES ('18', '', 'Next LAN', '', '', 'l', '10', '0', '3600', '', 'english', 'block-4nLan.php', '0', '', '0', 'd', '0', 'All');");
mysql_query("INSERT INTO ".$prefix."_blocks VALUES ('24', '', 'Top Posters', '', '', 'r', '3', '0', '3600', '', 'english', 'block-Top_Posters.php', '0', '', '0', 'd', '0', 'All');");
mysql_query("INSERT INTO ".$prefix."_blocks VALUES ('25', '', 'CLAN MENU', '', '', 'l', '2', '1', '0', '', 'english', 'block-vWar.php', '0', '', '0', 'd', '0', 'All');");
mysql_query("INSERT INTO ".$prefix."_blocks VALUES ('26', '', 'Clan Members', '', '', 'l', '11', '0', '3600', '', 'english', 'block-vWarsquadlist-scroll.php', '0', '', '0', 'd', '0', 'All');");
mysql_query("INSERT INTO ".$prefix."_blocks VALUES ('27', '', 'Calendar', '', '', 'l', '8', '0', '3600', '', 'english', 'block-vWarCalendar.php', '0', '', '0', 'd', '0', 'All');");
mysql_query("INSERT INTO ".$prefix."_blocks VALUES ('28', '', 'CountDown', '', '', 'l', '12', '0', '3600', '', 'english', 'block-vWarCount.php', '0', '', '0', 'd', '0', 'All');");
mysql_query("INSERT INTO ".$prefix."_blocks VALUES ('29', '', 'Clan Members', '', '', 'l', '13', '0', '3600', '', 'english', 'block-vWarsquadlist.php', '0', '', '0', 'd', '0', 'All');");
mysql_query("INSERT INTO ".$prefix."_blocks VALUES ('30', '', 'Last Action', '', '', 'l', '14', '0', '3600', '', 'english', 'block-vWarLast.php', '0', '', '0', 'd', '0', 'All');");
mysql_query("INSERT INTO ".$prefix."_blocks VALUES ('31', '', 'Next Action', '', '', 'l', '15', '0', '3600', '', 'english', 'block-vWarNext.php', '0', '', '0', 'd', '0', 'All');");
mysql_query("INSERT INTO ".$prefix."_blocks VALUES ('32', '', 'MENU', '', '', 'l', '4', '0', '3600', '', 'english', 'block-Navigation.php', '0', '', '0', 'd', '0', 'All');");
mysql_query("INSERT INTO ".$prefix."_blocks VALUES ('33', '', 'TeamSpeak', '', '', 'l', '7', '0', '0', '', 'english', 'block-Team_SpeakV2-1(side).php', '0', '', '0', 'd', '0', 'All');");
mysql_query("INSERT INTO ".$prefix."_blocks VALUES ('34', '', 'Teamspeak2', '', '', 'c', '3', '0', '0', '', 'english', 'block-Team_SpeakV2-1.php', '0', '', '0', 'd', '0', 'All');");
mysql_query("INSERT INTO ".$prefix."_blocks VALUES ('35', '', 'Who is Where', '', '', 'l', '16', '0', '3600', '', 'english', 'block-Who-is-Where.php', '0', '', '0', 'd', '0', 'All');");
mysql_query("INSERT INTO ".$prefix."_blocks VALUES ('36', '', 'Squery BIG', '', '', 'c', '4', '0', '0', '', 'english', 'block-SQuery.php', '0', '', '0', 'd', '0', 'All');");
mysql_query("INSERT INTO ".$prefix."_blocks VALUES ('40', '', 'SQuery tiny', '', '', 'l', '17', '0', '3600', '', 'english', 'block-SQuery_tiny.php', '0', '', '0', 'd', '0', 'All');");
//mysql_query("INSERT INTO ".$prefix."_blocks VALUES (48, '', 'PHPNUKE-CLAN.NET', '', 'http://www.phpnuke-clan.net/backend.php', 'r', 6, 1, 3600, '1166318178', 'english', '', 0, '', '0', 'd', 0, 'All');");


# --------------------------------------------------------
#
# Table structure for table '".$prefix."_cnbya_config'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_cnbya_config;");
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

# --------------------------------------------------------
#
# Table structure for table '".$prefix."_cnbya_field'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_cnbya_field;");
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

#
# Dumping data for table '".$prefix."_cnbya_field'
#


# --------------------------------------------------------
#
# Table structure for table '".$prefix."_cnbya_value'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_cnbya_value;");
mysql_query("CREATE TABLE ".$prefix."_cnbya_value (
   `vid` int(10) NOT NULL auto_increment,
   `uid` int(10) DEFAULT '0' NOT NULL,
   `fid` int(10) DEFAULT '0' NOT NULL,
   `value` varchar(255),
   PRIMARY KEY (vid),
   KEY vid (vid)
);");

#
# Dumping data for table '".$prefix."_cnbya_value'
#


# --------------------------------------------------------
#
# Table structure for table '".$prefix."_cnbya_value_temp'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_cnbya_value_temp;");
mysql_query("CREATE TABLE ".$prefix."_cnbya_value_temp (
   `vid` int(10) NOT NULL auto_increment,
   `uid` int(10) DEFAULT '0' NOT NULL,
   `fid` int(10) DEFAULT '0' NOT NULL,
   `value` varchar(255),
   PRIMARY KEY (vid),
   KEY vid (vid)
);");

#
# Dumping data for table '".$prefix."_cnbya_value_temp'
#


# --------------------------------------------------------
#
# Table structure for table '".$prefix."_comments'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_comments;");
mysql_query("CREATE TABLE ".$prefix."_comments (
   `tid` int(11) NOT NULL auto_increment,
   `pid` int(11) DEFAULT '0' NOT NULL,
   `sid` int(11) DEFAULT '0' NOT NULL,
   `date` datetime,
   `name` varchar(60) NOT NULL,
   `email` varchar(60),
   `url` varchar(60),
   `host_name` varchar(60),
   `subject` varchar(85) NOT NULL,
   `comment` text NOT NULL,
   `score` tinyint(4) DEFAULT '0' NOT NULL,
   `reason` tinyint(4) DEFAULT '0' NOT NULL,
   PRIMARY KEY (tid),
   KEY tid (tid),
   KEY pid (pid),
   KEY sid (sid)
);");

#
# Dumping data for table '".$prefix."_comments'
#


# --------------------------------------------------------
#
# Table structure for table '".$prefix."_config'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_config;");
mysql_query("CREATE TABLE ".$prefix."_config (
   `sitename` varchar(255) NOT NULL,
   `nukeurl` varchar(255) NOT NULL,
   `site_logo` varchar(255) NOT NULL,
   `slogan` varchar(255) NOT NULL,
   `startdate` varchar(50) NOT NULL,
   `adminmail` varchar(255) NOT NULL,
   `anonpost` tinyint(1) DEFAULT '0' NOT NULL,
   `Default_Theme` varchar(255) NOT NULL,
   `foot1` text NOT NULL,
   `foot2` text NOT NULL,
   `foot3` text NOT NULL,
   `commentlimit` int(9) DEFAULT '4096' NOT NULL,
   `anonymous` varchar(255) NOT NULL,
   `minpass` tinyint(1) DEFAULT '5' NOT NULL,
   `pollcomm` tinyint(1) DEFAULT '1' NOT NULL,
   `articlecomm` tinyint(1) DEFAULT '1' NOT NULL,
   `broadcast_msg` tinyint(1) DEFAULT '1' NOT NULL,
   `my_headlines` tinyint(1) DEFAULT '1' NOT NULL,
   `top` int(3) DEFAULT '10' NOT NULL,
   `storyhome` int(2) DEFAULT '10' NOT NULL,
   `user_news` tinyint(1) DEFAULT '1' NOT NULL,
   `oldnum` int(2) DEFAULT '30' NOT NULL,
   `ultramode` tinyint(1) DEFAULT '0' NOT NULL,
   `banners` tinyint(1) DEFAULT '1' NOT NULL,
   `backend_title` varchar(255) NOT NULL,
   `backend_language` varchar(10) NOT NULL,
   `language` varchar(100) NOT NULL,
   `locale` varchar(10) NOT NULL,
   `multilingual` tinyint(1) DEFAULT '0' NOT NULL,
   `useflags` tinyint(1) DEFAULT '0' NOT NULL,
   `notify` tinyint(1) DEFAULT '0' NOT NULL,
   `notify_email` varchar(255) NOT NULL,
   `notify_subject` varchar(255) NOT NULL,
   `notify_message` varchar(255) NOT NULL,
   `notify_from` varchar(255) NOT NULL,
   `moderate` tinyint(1) DEFAULT '0' NOT NULL,
   `admingraphic` tinyint(1) DEFAULT '1' NOT NULL,
   `httpref` tinyint(1) DEFAULT '1' NOT NULL,
   `httprefmax` int(5) DEFAULT '1000' NOT NULL,
   `CensorMode` tinyint(1) DEFAULT '3' NOT NULL,
   `CensorReplace` varchar(10) NOT NULL,
   `copyright` text NOT NULL,
   `Version_Num` varchar(10) NOT NULL,
   `displayerror` tinyint(1) DEFAULT '0' NOT NULL,
   PRIMARY KEY (sitename)
);");

#
# Dumping data for table '".$prefix."_config'
#

mysql_query("INSERT INTO ".$prefix."_config VALUES ('".$pncv."', 'http://yoursite.com', 'logo.gif', '', 'November 2006', 'me@clanmail.com', '0', 'Lexus-Blue', '', '', '', '4096', 'Anonymous', '5', '1', '1', '1', '1', '10', '10', '1', '30', '1', '1', 'PNC ".$pncv."', 'en-us', 'english', 'en_US', '1', '1', '0', 'me@yoursite.com', 'NEWS for my site', 'Hey! You got a new submission for your site.', 'webmaster', '1', '1', '1', '1000', '3', '*****', 'PHP-Nuke Copyright &copy; 2007 by Francisco Burzi. This is free software, and you may redistribute it under the <a href=\"http://phpnuke.org/files/gpl.txt\"><font class=\"footmsg_l\">GPL</font></a>.<br>Protected by <a href=\"http://www.nukescripts.net\" target=\"_blank\"><img src=\"http://www.nukescripts.net/images/powered/nukesentinel.png\" border=\"0\"><font class=\"footmsg_l\"><b></b></font></a>|Powered by <a href=\"http://www.phpnuke-clan.net\" target=\"_blank\"><img src=\"images/powered/pnctechnology.gif\" border=\"0\"></a><font class=\"footmsg_l\"><b>|PNC ".$pncv."</b></font></a><br>', 'PNC ".$pncv."', '1');");

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

mysql_query("DROP TABLE IF EXISTS ".$prefix."_counter;");
mysql_query("CREATE TABLE ".$prefix."_counter (
   `type` varchar(80) NOT NULL,
   `var` varchar(80) NOT NULL,
   `count` int(10) unsigned DEFAULT '0' NOT NULL
);");

mysql_query("INSERT INTO ".$prefix."_counter VALUES ('total', 'hits', '0');");
mysql_query("INSERT INTO ".$prefix."_counter VALUES ('browser', 'FireFox', '0');");
mysql_query("INSERT INTO ".$prefix."_counter VALUES ('browser', 'Lynx', '0');");
mysql_query("INSERT INTO ".$prefix."_counter VALUES ('browser', 'MSIE', '0');");
mysql_query("INSERT INTO ".$prefix."_counter VALUES ('browser', 'Opera', '0');");
mysql_query("INSERT INTO ".$prefix."_counter VALUES ('browser', 'Konqueror', '0');");
mysql_query("INSERT INTO ".$prefix."_counter VALUES ('browser', 'Netscape', '0');");
mysql_query("INSERT INTO ".$prefix."_counter VALUES ('browser', 'Bot', '0');");
mysql_query("INSERT INTO ".$prefix."_counter VALUES ('browser', 'Other', '0');");
mysql_query("INSERT INTO ".$prefix."_counter VALUES ('os', 'Windows', '0');");
mysql_query("INSERT INTO ".$prefix."_counter VALUES ('os', 'Linux', '0');");
mysql_query("INSERT INTO ".$prefix."_counter VALUES ('os', 'Mac', '0');");
mysql_query("INSERT INTO ".$prefix."_counter VALUES ('os', 'FreeBSD', '0');");
mysql_query("INSERT INTO ".$prefix."_counter VALUES ('os', 'SunOS', '0');");
mysql_query("INSERT INTO ".$prefix."_counter VALUES ('os', 'IRIX', '0');");
mysql_query("INSERT INTO ".$prefix."_counter VALUES ('os', 'BeOS', '0');");
mysql_query("INSERT INTO ".$prefix."_counter VALUES ('os', 'OS/2', '0');");
mysql_query("INSERT INTO ".$prefix."_counter VALUES ('os', 'AIX', '0');");
mysql_query("INSERT INTO ".$prefix."_counter VALUES ('os', 'Other', '0');");



# --------------------------------------------------------
#
# Table structure for table '".$prefix."_encyclopedia'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_encyclopedia;");
mysql_query("CREATE TABLE ".$prefix."_encyclopedia (
   `eid` int(10) NOT NULL auto_increment,
   `title` varchar(255) NOT NULL,
   `description` text NOT NULL,
   `elanguage` varchar(30) NOT NULL,
   `active` int(1) DEFAULT '0' NOT NULL,
   PRIMARY KEY (eid),
   KEY eid (eid)
);");

#
# Dumping data for table '".$prefix."_encyclopedia'
#


# --------------------------------------------------------
#
# Table structure for table '".$prefix."_encyclopedia_text'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_encyclopedia_text;");
mysql_query("CREATE TABLE ".$prefix."_encyclopedia_text (
   `tid` int(10) NOT NULL auto_increment,
   `eid` int(10) DEFAULT '0' NOT NULL,
   `title` varchar(255) NOT NULL,
   `text` text NOT NULL,
   `counter` int(10) DEFAULT '0' NOT NULL,
   PRIMARY KEY (tid),
   KEY tid (tid),
   KEY eid (eid),
   KEY title (title)
);");

#
# Dumping data for table '".$prefix."_encyclopedia_text'
#


# --------------------------------------------------------
#
# Table structure for table '".$prefix."_faqanswer'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_faqanswer;");
mysql_query("CREATE TABLE ".$prefix."_faqanswer (
   `id` tinyint(4) NOT NULL auto_increment,
   `id_cat` tinyint(4) DEFAULT '0' NOT NULL,
   `question` varchar(255),
   `answer` text,
   PRIMARY KEY (id),
   KEY id (id),
   KEY id_cat (id_cat)
);");

#
# Dumping data for table '".$prefix."_faqanswer'
#


# --------------------------------------------------------
#
# Table structure for table '".$prefix."_faqcategories'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_faqcategories;");
mysql_query("CREATE TABLE ".$prefix."_faqcategories (
   `id_cat` tinyint(3) NOT NULL auto_increment,
   `categories` varchar(255),
   `flanguage` varchar(30) NOT NULL,
   PRIMARY KEY (id_cat),
   KEY id_cat (id_cat)
);");

#
# Dumping data for table '".$prefix."_faqcategories'
#


# --------------------------------------------------------
#
# Table structure for table '".$prefix."_groups'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_groups;");
mysql_query("CREATE TABLE ".$prefix."_groups (
   `id` int(10) NOT NULL auto_increment,
   `name` varchar(255) NOT NULL,
   `description` text NOT NULL,
   `points` int(10) DEFAULT '0' NOT NULL,
   KEY id (id)
);");

#
# Dumping data for table '".$prefix."_groups'
#

mysql_query("INSERT INTO ".$prefix."_groups VALUES ('1', 'test', '', '0');");

# --------------------------------------------------------
#
# Table structure for table '".$prefix."_groups_points'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_groups_points;");
mysql_query("CREATE TABLE ".$prefix."_groups_points (
   `id` int(10) NOT NULL auto_increment,
   `points` int(10) DEFAULT '0' NOT NULL,
   PRIMARY KEY (id)
);");

#
# Dumping data for table '".$prefix."_groups_points'
#

mysql_query("INSERT INTO ".$prefix."_groups_points VALUES ('1', '0');");
mysql_query("INSERT INTO ".$prefix."_groups_points VALUES ('2', '0');");
mysql_query("INSERT INTO ".$prefix."_groups_points VALUES ('3', '0');");
mysql_query("INSERT INTO ".$prefix."_groups_points VALUES ('4', '0');");
mysql_query("INSERT INTO ".$prefix."_groups_points VALUES ('5', '0');");
mysql_query("INSERT INTO ".$prefix."_groups_points VALUES ('6', '0');");
mysql_query("INSERT INTO ".$prefix."_groups_points VALUES ('7', '0');");
mysql_query("INSERT INTO ".$prefix."_groups_points VALUES ('8', '0');");
mysql_query("INSERT INTO ".$prefix."_groups_points VALUES ('9', '0');");
mysql_query("INSERT INTO ".$prefix."_groups_points VALUES ('10', '0');");
mysql_query("INSERT INTO ".$prefix."_groups_points VALUES ('11', '0');");
mysql_query("INSERT INTO ".$prefix."_groups_points VALUES ('12', '0');");
mysql_query("INSERT INTO ".$prefix."_groups_points VALUES ('13', '0');");
mysql_query("INSERT INTO ".$prefix."_groups_points VALUES ('14', '0');");
mysql_query("INSERT INTO ".$prefix."_groups_points VALUES ('15', '0');");
mysql_query("INSERT INTO ".$prefix."_groups_points VALUES ('16', '0');");
mysql_query("INSERT INTO ".$prefix."_groups_points VALUES ('17', '0');");
mysql_query("INSERT INTO ".$prefix."_groups_points VALUES ('18', '0');");
mysql_query("INSERT INTO ".$prefix."_groups_points VALUES ('19', '0');");
mysql_query("INSERT INTO ".$prefix."_groups_points VALUES ('20', '0');");
mysql_query("INSERT INTO ".$prefix."_groups_points VALUES ('21', '0');");

# --------------------------------------------------------
#
# Table structure for table '".$prefix."_headlines'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_headlines;");
mysql_query("CREATE TABLE ".$prefix."_headlines (
   `hid` int(11) NOT NULL auto_increment,
   `sitename` varchar(30) NOT NULL,
   `headlinesurl` varchar(200) NOT NULL,
   PRIMARY KEY (hid)
);");

#
# Dumping data for table '".$prefix."_headlines'
#

mysql_query("INSERT INTO ".$prefix."_headlines VALUES ('1', 'AbsoluteGames', 'http://files.gameaholic.com/agfa.rdf');");
mysql_query("INSERT INTO ".$prefix."_headlines VALUES ('2', 'BSDToday', 'http://www.bsdtoday.com/backend/bt.rdf');");
mysql_query("INSERT INTO ".$prefix."_headlines VALUES ('3', 'BrunchingShuttlecocks', 'http://www.brunching.com/brunching.rdf');");
mysql_query("INSERT INTO ".$prefix."_headlines VALUES ('4', 'DailyDaemonNews', 'http://daily.daemonnews.org/ddn.rdf.php3');");
mysql_query("INSERT INTO ".$prefix."_headlines VALUES ('5', 'DigitalTheatre', 'http://www.dtheatre.com/backend.php3?xml=yes');");
mysql_query("INSERT INTO ".$prefix."_headlines VALUES ('6', 'DotKDE', 'http://dot.kde.org/rdf');");
mysql_query("INSERT INTO ".$prefix."_headlines VALUES ('7', 'FreeDOS', 'http://www.freedos.org/channels/rss.cgi');");
mysql_query("INSERT INTO ".$prefix."_headlines VALUES ('8', 'Freshmeat', 'http://freshmeat.net/backend/fm.rdf');");
mysql_query("INSERT INTO ".$prefix."_headlines VALUES ('9', 'Gnome Desktop', 'http://www.gnomedesktop.org/backend.php');");
mysql_query("INSERT INTO ".$prefix."_headlines VALUES ('10', 'HappyPenguin', 'http://happypenguin.org/html/news.rdf');");
mysql_query("INSERT INTO ".$prefix."_headlines VALUES ('11', 'HollywoodBitchslap', 'http://hollywoodbitchslap.com/hbs.rdf');");
mysql_query("INSERT INTO ".$prefix."_headlines VALUES ('12', 'Learning Linux', 'http://www.learninglinux.com/backend.php');");
mysql_query("INSERT INTO ".$prefix."_headlines VALUES ('13', 'LinuxCentral', 'http://linuxcentral.com/backend/lcnew.rdf');");
mysql_query("INSERT INTO ".$prefix."_headlines VALUES ('14', 'LinuxJournal', 'http://www.linuxjournal.com/news.rss');");
mysql_query("INSERT INTO ".$prefix."_headlines VALUES ('15', 'LinuxWeelyNews', 'http://lwn.net/headlines/rss');");
mysql_query("INSERT INTO ".$prefix."_headlines VALUES ('16', 'Listology', 'http://listology.com/recent.rdf');");
mysql_query("INSERT INTO ".$prefix."_headlines VALUES ('17', 'MozillaNewsBot', 'http://www.mozilla.org/newsbot/newsbot.rdf');");
mysql_query("INSERT INTO ".$prefix."_headlines VALUES ('18', 'NewsForge', 'http://www.newsforge.com/newsforge.rdf');");
mysql_query("INSERT INTO ".$prefix."_headlines VALUES ('19', 'NukeResources', 'http://www.nukeresources.com/backend.php');");
mysql_query("INSERT INTO ".$prefix."_headlines VALUES ('20', 'NukeScripts', 'http://www.nukescripts.net/backend.php');");
mysql_query("INSERT INTO ".$prefix."_headlines VALUES ('21', 'PDABuzz', 'http://www.pdabuzz.com/netscape.txt');");
mysql_query("INSERT INTO ".$prefix."_headlines VALUES ('22', 'PHP-Nuke', 'http://phpnuke.org/backend.php');");
mysql_query("INSERT INTO ".$prefix."_headlines VALUES ('23', '--- PHPNUKE-CLAN.NET ---', 'http://www.phpnuke-clan.net/backend.php');");
mysql_query("INSERT INTO ".$prefix."_headlines VALUES ('24', 'PHP.net', 'http://www.php.net/news.rss');");
mysql_query("INSERT INTO ".$prefix."_headlines VALUES ('25', 'PHPBuilder', 'http://phpbuilder.com/rss_feed.php');");
mysql_query("INSERT INTO ".$prefix."_headlines VALUES ('26', 'PerlMonks', 'http://www.perlmonks.org/headlines.rdf');");
mysql_query("INSERT INTO ".$prefix."_headlines VALUES ('27', 'TheNextLevel', 'http://www.the-nextlevel.com/rdf/tnl.rdf');");
mysql_query("INSERT INTO ".$prefix."_headlines VALUES ('28', 'WebReference', 'http://webreference.com/webreference.rdf');");

# --------------------------------------------------------
#
# Table structure for table '".$prefix."_hos_config'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_hos_config;");
mysql_query("CREATE TABLE ".$prefix."_hos_config (
  `config_name` varchar(50) default '0' NOT NULL ,
  `config_value` text NOT NULL,
  PRIMARY KEY  (config_name)
);");


## Dumping data for table  `".$prefix."_hos_config`

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



## --------------------------------------------------------

mysql_query("DROP TABLE IF EXISTS ".$prefix."_hos_members;");
mysql_query("CREATE TABLE ".$prefix."_hos_members (
  `memberid` int(11) NOT NULL auto_increment,
  `membername` varchar(120) NOT NULL default '0',
  `memberstatus` int(11) NOT NULL default '0',
  PRIMARY KEY  (memberid)
);");

# --------------------------------------------------------
#
mysql_query("DROP TABLE IF EXISTS ".$prefix."_hos_punks;");
mysql_query("CREATE TABLE ".$prefix."_hos_punks (
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
  PRIMARY KEY  (pid)
);");

# Gegevens worden uitgevoerd voor tabel `pnc_hos_punks`

# --------------------------------------------------------

# Tabel structuur voor tabel `pnc_hos_reasons`

mysql_query("CREATE TABLE ".$prefix."_hos_reasons (
  `rid` int(11) NOT NULL auto_increment,
  `title` varchar(120) NOT NULL default '',
  `rdesc` varchar(255) NOT NULL default '',
  `rpid` int(11) NOT NULL default '0',
  PRIMARY KEY  (rid)
);");


#
# Table structure for table '".$prefix."_links_categories'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_links_categories;");
mysql_query("CREATE TABLE ".$prefix."_links_categories (
   `cid` int(11) NOT NULL auto_increment,
   `title` varchar(50) NOT NULL,
   `cdescription` text NOT NULL,
   `parentid` int(11) DEFAULT '0' NOT NULL,
   PRIMARY KEY (cid)
);");

#
# Dumping data for table '".$prefix."_links_categories'
#


# --------------------------------------------------------
#
# Table structure for table '".$prefix."_links_editorials'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_links_editorials;");
mysql_query("CREATE TABLE ".$prefix."_links_editorials (
   `linkid` int(11) DEFAULT '0' NOT NULL,
   `adminid` varchar(60) NOT NULL,
   `editorialtimestamp` datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
   `editorialtext` text NOT NULL,
   `editorialtitle` varchar(100) NOT NULL,
   PRIMARY KEY (linkid)
);");

#
# Dumping data for table '".$prefix."_links_editorials'
#


# --------------------------------------------------------
#
# Table structure for table '".$prefix."_links_links'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_links_links;");
mysql_query("CREATE TABLE ".$prefix."_links_links (
   `lid` int(11) NOT NULL auto_increment,
   `cid` int(11) DEFAULT '0' NOT NULL,
   `sid` int(11) DEFAULT '0' NOT NULL,
   `title` varchar(100) NOT NULL,
   `url` varchar(100) NOT NULL,
   `description` text NOT NULL,
   `date` datetime,
   `name` varchar(100) NOT NULL,
   `email` varchar(100) NOT NULL,
   `hits` int(11) DEFAULT '0' NOT NULL,
   `submitter` varchar(60) NOT NULL,
   `linkratingsummary` double(6,4) DEFAULT '0.0000' NOT NULL,
   `totalvotes` int(11) DEFAULT '0' NOT NULL,
   `totalcomments` int(11) DEFAULT '0' NOT NULL,
   PRIMARY KEY (lid),
   KEY cid (cid),
   KEY sid (sid)
);");

#
# Dumping data for table '".$prefix."_links_links'
#


# --------------------------------------------------------
#
# Table structure for table '".$prefix."_links_modrequest'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_links_modrequest;");
mysql_query("CREATE TABLE ".$prefix."_links_modrequest (
   `requestid` int(11) NOT NULL auto_increment,
   `lid` int(11) DEFAULT '0' NOT NULL,
   `cid` int(11) DEFAULT '0' NOT NULL,
   `sid` int(11) DEFAULT '0' NOT NULL,
   `title` varchar(100) NOT NULL,
   `url` varchar(100) NOT NULL,
   `description` text NOT NULL,
   `modifysubmitter` varchar(60) NOT NULL,
   `brokenlink` int(3) DEFAULT '0' NOT NULL,
   PRIMARY KEY (requestid),
   UNIQUE requestid (requestid)
);");

#
# Dumping data for table '".$prefix."_links_modrequest'
#


# --------------------------------------------------------
#
# Table structure for table '".$prefix."_links_newlink'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_links_newlink;");
mysql_query("CREATE TABLE ".$prefix."_links_newlink (
   `lid` int(11) NOT NULL auto_increment,
   `cid` int(11) DEFAULT '0' NOT NULL,
   `sid` int(11) DEFAULT '0' NOT NULL,
   `title` varchar(100) NOT NULL,
   `url` varchar(100) NOT NULL,
   `description` text NOT NULL,
   `name` varchar(100) NOT NULL,
   `email` varchar(100) NOT NULL,
   `submitter` varchar(60) NOT NULL,
   PRIMARY KEY (lid),
   KEY cid (cid),
   KEY sid (sid)
);");

#
# Dumping data for table '".$prefix."_links_newlink'
#


# --------------------------------------------------------
#
# Table structure for table '".$prefix."_links_votedata'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_links_votedata;");
mysql_query("CREATE TABLE ".$prefix."_links_votedata (
   `ratingdbid` int(11) NOT NULL auto_increment,
   `ratinglid` int(11) DEFAULT '0' NOT NULL,
   `ratinguser` varchar(60) NOT NULL,
   `rating` int(11) DEFAULT '0' NOT NULL,
   `ratinghostname` varchar(60) NOT NULL,
   `ratingcomments` text NOT NULL,
   `ratingtimestamp` datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
   PRIMARY KEY (ratingdbid)
);");

#
# Dumping data for table '".$prefix."_links_votedata'
#


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


# --------------------------------------------------------
#
# Table structure for table '".$prefix."_main'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_main;");
mysql_query("CREATE TABLE ".$prefix."_main (
   `main_module` varchar(255) NOT NULL
);");

#
# Dumping data for table '".$prefix."_main'
#

mysql_query("INSERT INTO ".$prefix."_main VALUES ('News');");

# --------------------------------------------------------
#
# Table structure for table '".$prefix."_mapcat'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_mapcat;");
mysql_query("CREATE TABLE ".$prefix."_mapcat (
   `id` int(11) NOT NULL auto_increment,
   `title` varchar(100) NOT NULL,
   `details` text NOT NULL,
   `mainid` int(11) DEFAULT '0' NOT NULL,
   `image` varchar(100) NOT NULL,
   PRIMARY KEY (id)
);");

#
# Dumping data for table '".$prefix."_mapcat'
#


# --------------------------------------------------------
#
# Table structure for table '".$prefix."_mapconfig'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_mapconfig;");
mysql_query("CREATE TABLE ".$prefix."_mapconfig (
   `mname` varchar(20) NOT NULL,
   `mval` varchar(100) NOT NULL
);");

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

# --------------------------------------------------------
#
# Table structure for table '".$prefix."_mapmap'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_mapmap;");
mysql_query("CREATE TABLE ".$prefix."_mapmap (
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
   KEY cat (cat)
);");

#
# Dumping data for table '".$prefix."_mapmap'
#


# --------------------------------------------------------
#
# Table structure for table '".$prefix."_mapreviews'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_mapreviews;");
mysql_query("CREATE TABLE ".$prefix."_mapreviews (
   `rid` int(11) NOT NULL auto_increment,
   `rmapid` int(11) DEFAULT '0' NOT NULL,
   `ruserid` int(11) DEFAULT '0' NOT NULL,
   `ruserip` varchar(15) NOT NULL,
   `rdate` varchar(20) NOT NULL,
   `review` text NOT NULL,
   `rapprove` int(1) DEFAULT '0' NOT NULL,
   PRIMARY KEY (rid)
);");

#
# Dumping data for table '".$prefix."_mapreviews'
#


# --------------------------------------------------------
#
# Table structure for table '".$prefix."_maptemp'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_maptemp;");
mysql_query("CREATE TABLE ".$prefix."_maptemp (
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
);");

#
# Dumping data for table '".$prefix."_maptemp'
#


# --------------------------------------------------------
#
# Table structure for table '".$prefix."_mapvoters'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_mapvoters;");
mysql_query("CREATE TABLE ".$prefix."_mapvoters (
   `id` int(11) NOT NULL auto_increment,
   `mapid` int(11) DEFAULT '0' NOT NULL,
   `user` varchar(60) NOT NULL,
   PRIMARY KEY (id)
);");

#
# Dumping data for table '".$prefix."_mapvoters'
#


# --------------------------------------------------------
#
# Table structure for table '".$prefix."_mapvotes'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_mapvotes;");
mysql_query("CREATE TABLE ".$prefix."_mapvotes (
   `vid` int(11) NOT NULL auto_increment,
   `mapid` int(11) DEFAULT '0' NOT NULL,
   `rating` float DEFAULT '0' NOT NULL,
   `totalvotes` int(11) DEFAULT '0' NOT NULL,
   `empty` varchar(111) NOT NULL,
   PRIMARY KEY (vid),
   KEY mapid (mapid)
);");

#
# Dumping data for table '".$prefix."_mapvotes'
#


# --------------------------------------------------------
#
# Table structure for table '".$prefix."_message'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_message;");
mysql_query("CREATE TABLE ".$prefix."_message (
   `mid` int(11) NOT NULL auto_increment,
   `title` varchar(100) NOT NULL,
   `content` text NOT NULL,
   `date` varchar(14) NOT NULL,
   `expire` int(7) DEFAULT '0' NOT NULL,
   `active` int(1) DEFAULT '1' NOT NULL,
   `view` int(1) DEFAULT '1' NOT NULL,
   `groups` text NOT NULL,
   `mlanguage` varchar(30) NOT NULL,
   PRIMARY KEY (mid)
);");

#
# Dumping data for table '".$prefix."_message'
#

mysql_query("INSERT INTO ".$prefix."_message VALUES ('1', 'Welcome to PNC 4.5.0!', '<center><img src=images/logo2.gif></img></center><br /><center><b>Congratulations, you have successfully installed PNC 4.5.0 <br /><br /><br /><br /><b>Once you have created your admin account and setup your vWar,<br />you need to remove files:<br><font color=yellow>-INSTALLATION/<br />- install_vwar.php<br>- update_vwar.php</font><hr>Thank you for using PNC 4.5.0<br \>You can make a donation to support us!<br><a href=http://phpnuke-clan.net/modules.php?name=Donations target=_blank><img src=images/donations/paydonate.gif width=62 height=31 border=0></a></b></center>', '993373194', '0', '1', '1', '', '');");

# --------------------------------------------------------
#
# Table structure for table '".$prefix."_modules'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_modules;");
mysql_query("CREATE TABLE ".$prefix."_modules (
   `mid` int(10) NOT NULL auto_increment,
   `title` varchar(255) NOT NULL,
   `custom_title` varchar(255) NOT NULL,
   `active` int(1) DEFAULT '0' NOT NULL,
   `view` int(1) DEFAULT '0' NOT NULL,
   `groups` text NOT NULL,
   `inmenu` tinyint(1) DEFAULT '1' NOT NULL,
   `mod_group` int(10) DEFAULT '0',
   `mcid` int(11) DEFAULT '1' NOT NULL,
   `admins` varchar(255) NOT NULL,
   PRIMARY KEY (mid),
   KEY title (title),
   KEY custom_title (custom_title)
);");

#
# Dumping data for table '".$prefix."_modules'
#

mysql_query("INSERT INTO ".$prefix."_modules VALUES ('81', 'Content', 'Content', '0', '0', '', '1', '0', '1', '');");
mysql_query("INSERT INTO ".$prefix."_modules VALUES ('82', 'Docs', 'Docs', '0', '0', '', '1', '0', '1', '');");
mysql_query("INSERT INTO ".$prefix."_modules VALUES ('83', 'Donations', 'Donations', '0', '0', '', '1', '0', '1', '');");
mysql_query("INSERT INTO ".$prefix."_modules VALUES ('84', 'Downloads', 'Downloads', '0', '0', '', '1', '0', '1', '');");
mysql_query("INSERT INTO ".$prefix."_modules VALUES ('85', 'FAQ', 'FAQ', '0', '0', '', '1', '0', '1', '');");
mysql_query("INSERT INTO ".$prefix."_modules VALUES ('86', 'Forums', 'Forums', '1', '0', '', '1', '0', '1', '');");
mysql_query("INSERT INTO ".$prefix."_modules VALUES ('87', 'Groups', 'Groups', '1', '0', '', '1', '0', '1', '');");
mysql_query("INSERT INTO ".$prefix."_modules VALUES ('88', 'Members_List', 'Members_List', '1', '0', '', '1', '0', '1', '');");
mysql_query("INSERT INTO ".$prefix."_modules VALUES ('90', 'NukeSentinel', 'NukeSentinel', '1', '0', '', '1', '0', '1', '');");
mysql_query("INSERT INTO ".$prefix."_modules VALUES ('91', 'Private_Messages', 'Private_Messages', '1', '0', '', '1', '0', '1', '');");
mysql_query("INSERT INTO ".$prefix."_modules VALUES ('92', 'Recommend_Us', 'Recommend_Us', '0', '0', '', '1', '0', '1', '');");
mysql_query("INSERT INTO ".$prefix."_modules VALUES ('116', 'SQuery', 'SQuery', '0', '0', '', '1', '0', '1', '');");
mysql_query("INSERT INTO ".$prefix."_modules VALUES ('96', 'Search', 'Search', '1', '0', '', '1', '0', '1', '');");
mysql_query("INSERT INTO ".$prefix."_modules VALUES ('97', 'Statistics', 'Statistics', '1', '0', '', '1', '0', '1', '');");
mysql_query("INSERT INTO ".$prefix."_modules VALUES ('98', 'Stories_Archive', 'Stories_Archive', '1', '0', '', '1', '0', '1', '');");
mysql_query("INSERT INTO ".$prefix."_modules VALUES ('99', 'Submit_News', 'Submit_News', '1', '0', '', '1', '0', '1', '');");
mysql_query("INSERT INTO ".$prefix."_modules VALUES ('100', 'Supporters', 'Supporters', '1', '0', '', '1', '0', '1', '');");
mysql_query("INSERT INTO ".$prefix."_modules VALUES ('101', 'Surveys', 'Surveys', '1', '0', '', '1', '0', '1', '');");
mysql_query("INSERT INTO ".$prefix."_modules VALUES ('118', 'Teamspeak', 'Teamspeak', '0', '0', '', '1', '0', '1', '');");
mysql_query("INSERT INTO ".$prefix."_modules VALUES ('103', 'Top', 'Top', '0', '0', '', '1', '0', '1', '');");
mysql_query("INSERT INTO ".$prefix."_modules VALUES ('104', 'Topics', 'Topics', '0', '0', '', '1', '0', '1', '');");
mysql_query("INSERT INTO ".$prefix."_modules VALUES ('105', 'Ventrilo', 'Ventrilo', '0', '0', '', '1', '0', '1', '');");
mysql_query("INSERT INTO ".$prefix."_modules VALUES ('106', 'Web_Links', 'Web_Links', '1', '0', '', '1', '0', '1', '');");
mysql_query("INSERT INTO ".$prefix."_modules VALUES ('107', 'Who-is-Where', 'Who-is-Where', '1', '0', '', '1', '0', '1', '');");
mysql_query("INSERT INTO ".$prefix."_modules VALUES ('108', 'XFire', 'XFire', '1', '0', '', '1', '0', '1', '');");
mysql_query("INSERT INTO ".$prefix."_modules VALUES ('109', 'XFire_Submit', 'XFire_Submit', '1', '0', '', '1', '0', '1', '');");
mysql_query("INSERT INTO ".$prefix."_modules VALUES ('110', 'Your_Account', 'Your_Account', '1', '0', '', '1', '0', '1', '');");
mysql_query("INSERT INTO ".$prefix."_modules VALUES ('111', 'vWar_Account', 'vWar_Account', '1', '0', '', '1', '0', '1', '');");
mysql_query("INSERT INTO ".$prefix."_modules VALUES ('112', 'vwar', 'vwar', '0', '1', '', '1', '0', '1', '');");
mysql_query("INSERT INTO ".$prefix."_modules VALUES ('113', 'News', 'News', '1', '1', '', '1', '0', '1', '');");
mysql_query("INSERT INTO ".$prefix."_modules VALUES ('114', 'Shout_Box', 'Shout_Box', '1', '0', '', '1', '0', '1', '');");
mysql_query("INSERT INTO ".$prefix."_modules VALUES ('115', 'Submit_Downloads', 'Submit_Downloads', '0', '0', '', '1', '0', '1', '');");
mysql_query("INSERT INTO ".$prefix."_modules VALUES ('119', '4nLan', '4nLan', '1', '0', '', '1', '0', '1', '');");
mysql_query("INSERT INTO ".$prefix."_modules VALUES ('120', 'vWar_Sig', 'vWar_Sig', '0', '0', '', '1', '0', '1', '');");
mysql_query("INSERT INTO ".$prefix."_modules VALUES ('121', 'Maps', 'Maps', '0', '0', '', '1', '0', '1', '');");

# --------------------------------------------------------
#
# Table structure for table '".$prefix."_modules_categories'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_modules_categories;");
mysql_query("CREATE TABLE ".$prefix."_modules_categories (
   `mcid` int(11) NOT NULL auto_increment,
   `mcname` varchar(60) NOT NULL,
   `visible` int(1) DEFAULT '1' NOT NULL,
   PRIMARY KEY (mcid),
   KEY mcname (mcname)
);");

#
# Dumping data for table '".$prefix."_modules_categories'
#

mysql_query("INSERT INTO ".$prefix."_modules_categories VALUES ('1', 'General', '1');");
mysql_query("INSERT INTO ".$prefix."_modules_categories VALUES ('2', 'Community', '1');");
mysql_query("INSERT INTO ".$prefix."_modules_categories VALUES ('3', 'Members', '1');");

# --------------------------------------------------------
#
# Table structure for table '".$prefix."_nsncb_blocks'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_nsncb_blocks;");
mysql_query("CREATE TABLE ".$prefix."_nsncb_blocks (
   `rid` tinyint(2) DEFAULT '0' NOT NULL,
   `cgid` tinyint(2) DEFAULT '0' NOT NULL,
   `cbid` tinyint(2) DEFAULT '0' NOT NULL,
   `title` varchar(60) NOT NULL,
   `filename` varchar(255) NOT NULL,
   `content` text NOT NULL,
   `wtype` tinyint(1) DEFAULT '0' NOT NULL,
   `width` smallint(6) DEFAULT '0' NOT NULL,
   PRIMARY KEY (rid)
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

# --------------------------------------------------------
#
# Table structure for table '".$prefix."_nsncb_config'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_nsncb_config;");
mysql_query("CREATE TABLE ".$prefix."_nsncb_config (
   `cgid` tinyint(1) DEFAULT '0' NOT NULL,
   `enabled` tinyint(1) DEFAULT '0' NOT NULL,
   `height` smallint(6) DEFAULT '0' NOT NULL,
   `count` tinyint(1) DEFAULT '0' NOT NULL,
   PRIMARY KEY (cgid)
);");

#
# Dumping data for table '".$prefix."_nsncb_config'
#

mysql_query("INSERT INTO ".$prefix."_nsncb_config VALUES ('1', '1', '0', '2');");
mysql_query("INSERT INTO ".$prefix."_nsncb_config VALUES ('2', '0', '0', '1');");
mysql_query("INSERT INTO ".$prefix."_nsncb_config VALUES ('3', '0', '0', '0');");
mysql_query("INSERT INTO ".$prefix."_nsncb_config VALUES ('4', '0', '0', '0');");

# --------------------------------------------------------
#
# Table structure for table '".$prefix."_nsngd_accesses'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_nsngd_accesses;");
mysql_query("CREATE TABLE ".$prefix."_nsngd_accesses (
   `username` varchar(60) NOT NULL,
   `downloads` int(11) DEFAULT '0' NOT NULL,
   `uploads` int(11) DEFAULT '0' NOT NULL,
   PRIMARY KEY (username)
);");

#
# Dumping data for table '".$prefix."_nsngd_accesses'
#


# --------------------------------------------------------
#
# Table structure for table '".$prefix."_nsngd_categories'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_nsngd_categories;");
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
   KEY title (title)
);");

#
# Dumping data for table '".$prefix."_nsngd_categories'
#


# --------------------------------------------------------
#
# Table structure for table '".$prefix."_nsngd_config'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_nsngd_config;");
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

# --------------------------------------------------------
#
# Table structure for table '".$prefix."_nsngd_downloads'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_nsngd_downloads;");
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
   KEY cid (cid),
   KEY sid (sid),
   KEY title (title)
);");

#
# Dumping data for table '".$prefix."_nsngd_downloads'
#


# --------------------------------------------------------
#
# Table structure for table '".$prefix."_nsngd_extensions'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_nsngd_extensions;");
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

# --------------------------------------------------------
#
# Table structure for table '".$prefix."_nsngd_mods'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_nsngd_mods;");
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
);");

#
# Dumping data for table '".$prefix."_nsngd_mods'
#


# --------------------------------------------------------
#
# Table structure for table '".$prefix."_nsngd_new'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_nsngd_new;");
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
   KEY cid (cid),
   KEY sid (sid),
   KEY title (title)
);");

#
# Dumping data for table '".$prefix."_nsngd_new'
#


# --------------------------------------------------------
#
# Table structure for table '".$prefix."_nsngr_config'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_nsngr_config;");
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

# --------------------------------------------------------
#
# Table structure for table '".$prefix."_nsngr_groups'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_nsngr_groups;");
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


# --------------------------------------------------------
#
# Table structure for table '".$prefix."_nsngr_users'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_nsngr_users;");
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


# --------------------------------------------------------
#
# Table structure for table '".$prefix."_nsnne_config'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_nsnne_config;");
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

# --------------------------------------------------------
#
# Table structure for table '".$prefix."_nsnsp_config'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_nsnsp_config;");
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

# --------------------------------------------------------
#
# Table structure for table '".$prefix."_nsnsp_sites'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_nsnsp_sites;");
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

mysql_query("DROP TABLE IF EXISTS ".$prefix."_pages;");
mysql_query("CREATE TABLE ".$prefix."_pages (
   `pid` int(10) NOT NULL auto_increment,
   `cid` int(10) DEFAULT '0' NOT NULL,
   `title` varchar(255) NOT NULL,
   `subtitle` varchar(255) NOT NULL,
   `active` int(1) DEFAULT '0' NOT NULL,
   `page_header` text NOT NULL,
   `text` text NOT NULL,
   `page_footer` text NOT NULL,
   `signature` text NOT NULL,
   `date` datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
   `counter` int(10) DEFAULT '0' NOT NULL,
   `clanguage` varchar(30) NOT NULL,
   PRIMARY KEY (pid),
   KEY pid (pid),
   KEY cid (cid)
);");

#
# Dumping data for table '".$prefix."_pages'
#


# --------------------------------------------------------
#
# Table structure for table '".$prefix."_pages_categories'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_pages_categories;");
mysql_query("CREATE TABLE ".$prefix."_pages_categories (
   `cid` int(10) NOT NULL auto_increment,
   `title` varchar(255) NOT NULL,
   `description` text NOT NULL,
   PRIMARY KEY (cid),
   KEY cid (cid)
);");

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

mysql_query("DROP TABLE IF EXISTS ".$prefix."_poll_check;");
mysql_query("CREATE TABLE ".$prefix."_poll_check (
   `ip` varchar(20) NOT NULL,
   `time` varchar(14) NOT NULL,
   `pollID` int(10) DEFAULT '0' NOT NULL
);");

#
# Dumping data for table '".$prefix."_poll_check'
#


# --------------------------------------------------------
#
# Table structure for table '".$prefix."_poll_data'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_poll_data;");
mysql_query("CREATE TABLE ".$prefix."_poll_data (
   `pollID` int(11) DEFAULT '0' NOT NULL,
   `optionText` char(50) NOT NULL,
   `optionCount` int(11) DEFAULT '0' NOT NULL,
   `voteID` int(11) DEFAULT '0' NOT NULL
);");

#
# Dumping data for table '".$prefix."_poll_data'
#

mysql_query("INSERT INTO ".$prefix."_poll_data VALUES ('1', 'Ummmm, not bad', '0', '1');");
mysql_query("INSERT INTO ".$prefix."_poll_data VALUES ('1', 'Cool', '0', '2');");
mysql_query("INSERT INTO ".$prefix."_poll_data VALUES ('1', 'Terrific', '0', '3');");
mysql_query("INSERT INTO ".$prefix."_poll_data VALUES ('1', 'The best one!', '0', '4');");
mysql_query("INSERT INTO ".$prefix."_poll_data VALUES ('1', 'what the hell is this?', '0', '5');");
mysql_query("INSERT INTO ".$prefix."_poll_data VALUES ('1', '', '0', '6');");
mysql_query("INSERT INTO ".$prefix."_poll_data VALUES ('1', '', '0', '7');");
mysql_query("INSERT INTO ".$prefix."_poll_data VALUES ('1', '', '0', '8');");
mysql_query("INSERT INTO ".$prefix."_poll_data VALUES ('1', '', '0', '9');");
mysql_query("INSERT INTO ".$prefix."_poll_data VALUES ('1', '', '0', '10');");
mysql_query("INSERT INTO ".$prefix."_poll_data VALUES ('1', '', '0', '11');");
mysql_query("INSERT INTO ".$prefix."_poll_data VALUES ('1', '', '0', '12');");

# --------------------------------------------------------
#
# Table structure for table '".$prefix."_poll_desc'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_poll_desc;");
mysql_query("CREATE TABLE ".$prefix."_poll_desc (
   `pollID` int(11) NOT NULL auto_increment,
   `pollTitle` varchar(100) NOT NULL,
   `timeStamp` int(11) DEFAULT '0' NOT NULL,
   `voters` mediumint(9) DEFAULT '0' NOT NULL,
   `planguage` varchar(30) NOT NULL,
   `artid` int(10) DEFAULT '0' NOT NULL,
   PRIMARY KEY (pollID),
   KEY pollID (pollID)
);");

#
# Dumping data for table '".$prefix."_poll_desc'
#

mysql_query("INSERT INTO ".$prefix."_poll_desc VALUES ('1', 'What do you think about this site?', '961405160', '0', 'english', '0');");

# --------------------------------------------------------
#
# Table structure for table '".$prefix."_pollcomments'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_pollcomments;");
mysql_query("CREATE TABLE ".$prefix."_pollcomments (
   `tid` int(11) NOT NULL auto_increment,
   `pid` int(11) DEFAULT '0' NOT NULL,
   `pollID` int(11) DEFAULT '0' NOT NULL,
   `date` datetime,
   `name` varchar(60) NOT NULL,
   `email` varchar(60),
   `url` varchar(60),
   `host_name` varchar(60),
   `subject` varchar(60) NOT NULL,
   `comment` text NOT NULL,
   `score` tinyint(4) DEFAULT '0' NOT NULL,
   `reason` tinyint(4) DEFAULT '0' NOT NULL,
   PRIMARY KEY (tid),
   KEY tid (tid),
   KEY pid (pid),
   KEY pollID (pollID)
);");

#
# Dumping data for table '".$prefix."_pollcomments'
#


# --------------------------------------------------------
#
# Table structure for table '".$prefix."_public_messages'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_public_messages;");
mysql_query("CREATE TABLE ".$prefix."_public_messages (
   `mid` int(10) NOT NULL auto_increment,
   `content` varchar(255) NOT NULL,
   `date` varchar(14),
   `who` varchar(25) NOT NULL,
   PRIMARY KEY (mid),
   KEY mid (mid)
);");

#
# Dumping data for table '".$prefix."_public_messages'
#


# --------------------------------------------------------
#
# Table structure for table '".$prefix."_queue'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_queue;");
mysql_query("CREATE TABLE ".$prefix."_queue (
   `qid` smallint(5) unsigned NOT NULL auto_increment,
   `uid` mediumint(9) DEFAULT '0' NOT NULL,
   `uname` varchar(40) NOT NULL,
   `subject` varchar(100) NOT NULL,
   `story` text,
   `storyext` text NOT NULL,
   `timestamp` datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
   `topic` varchar(20) NOT NULL,
   `alanguage` varchar(30) NOT NULL,
   PRIMARY KEY (qid),
   KEY qid (qid),
   KEY uid (uid),
   KEY uname (uname)
);");

#
# Dumping data for table '".$prefix."_queue'
#


# --------------------------------------------------------
#
# Table structure for table '".$prefix."_quotes'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_quotes;");
mysql_query("CREATE TABLE ".$prefix."_quotes (
   `qid` int(10) unsigned NOT NULL auto_increment,
   `quote` text,
   PRIMARY KEY (qid),
   KEY qid (qid)
);");

#
# Dumping data for table '".$prefix."_quotes'
#

mysql_query("INSERT INTO ".$prefix."_quotes VALUES ('1', 'Nos morituri te salutamus - CBHS');");

# --------------------------------------------------------
#
# Table structure for table '".$prefix."_referer'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_referer;");
mysql_query("CREATE TABLE ".$prefix."_referer (
   `rid` int(11) NOT NULL auto_increment,
   `url` varchar(100) NOT NULL,
   PRIMARY KEY (rid),
   KEY rid (rid)
);");

#
# Dumping data for table '".$prefix."_referer'
#
# --------------------------------------------------------
#
# Table structure for table '".$prefix."_related'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_related;");
mysql_query("CREATE TABLE ".$prefix."_related (
   `rid` int(11) NOT NULL auto_increment,
   `tid` int(11) DEFAULT '0' NOT NULL,
   `name` varchar(30) NOT NULL,
   `url` varchar(200) NOT NULL,
   PRIMARY KEY (rid),
   KEY rid (rid),
   KEY tid (tid)
);");

#
# Dumping data for table '".$prefix."_related'
#


# --------------------------------------------------------
#
# Table structure for table '".$prefix."_session'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_session;");
mysql_query("CREATE TABLE ".$prefix."_session (
   `uname` varchar(25) NOT NULL,
   `time` varchar(14) NOT NULL,
   `host_addr` varchar(48) NOT NULL,
   `guest` int(1) DEFAULT '0' NOT NULL,
   KEY time (time),
   KEY guest (guest)
);");

#
# Dumping data for table '".$prefix."_session'
#


# --------------------------------------------------------
#
# Table structure for table '".$prefix."_shoutbox_censor'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_shoutbox_censor;");
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

# --------------------------------------------------------
#
# Table structure for table '".$prefix."_shoutbox_conf'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_shoutbox_conf;");
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

# --------------------------------------------------------
#
# Table structure for table '".$prefix."_shoutbox_date'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_shoutbox_date;");
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

# --------------------------------------------------------
#
# Table structure for table '".$prefix."_shoutbox_emoticons'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_shoutbox_emoticons;");
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

# --------------------------------------------------------
#
# Table structure for table '".$prefix."_shoutbox_ipblock'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_shoutbox_ipblock;");
mysql_query("CREATE TABLE ".$prefix."_shoutbox_ipblock (
   `id` int(9) NOT NULL auto_increment,
   `name` varchar(50) NOT NULL,
   PRIMARY KEY (id)
);");

#
# Dumping data for table '".$prefix."_shoutbox_ipblock'
#


# --------------------------------------------------------
#
# Table structure for table '".$prefix."_shoutbox_manage_count'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_shoutbox_manage_count;");
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

# --------------------------------------------------------
#
# Table structure for table '".$prefix."_shoutbox_nameblock'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_shoutbox_nameblock;");
mysql_query("CREATE TABLE ".$prefix."_shoutbox_nameblock (
   `id` int(9) NOT NULL auto_increment,
   `name` varchar(50) NOT NULL,
   PRIMARY KEY (id)
);");

#
# Dumping data for table '".$prefix."_shoutbox_nameblock'
#


# --------------------------------------------------------
#
# Table structure for table '".$prefix."_shoutbox_shouts'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_shoutbox_shouts;");
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

# --------------------------------------------------------
#
# Table structure for table '".$prefix."_shoutbox_sticky'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_shoutbox_sticky;");
mysql_query("CREATE TABLE ".$prefix."_shoutbox_sticky (
   `id` int(9) NOT NULL auto_increment,
   `name` varchar(20) NOT NULL,
   `comment` text NOT NULL,
   `timestamp` varchar(20) NOT NULL,
   `stickySlot` varchar(5) NOT NULL,
   PRIMARY KEY (id)
);");

#
# Dumping data for table '".$prefix."_shoutbox_sticky'
#


# --------------------------------------------------------
#
# Table structure for table '".$prefix."_shoutbox_theme_images'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_shoutbox_theme_images;");
mysql_query("CREATE TABLE ".$prefix."_shoutbox_theme_images (
   `id` int(9) NOT NULL auto_increment,
   `themeName` varchar(50),
   `blockArrowColor` varchar(50) NOT NULL,
   `blockBackgroundImage` varchar(50) NOT NULL,
   PRIMARY KEY (id)
);");

#
# Dumping data for table '".$prefix."_shoutbox_theme_images'
#


# --------------------------------------------------------
#
# Table structure for table '".$prefix."_shoutbox_themes'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_shoutbox_themes;");
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
# Table structure for table '".$prefix."_squery_games'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_squery_games;");
/*mysql_query("CREATE TABLE ".$prefix."_squery_games (
   `id` bigint(20) unsigned NOT NULL auto_increment,
   `gamename` varchar(255) NOT NULL,
   KEY id (id)
);");

#
# Dumping data for table '".$prefix."_squery_games'
#

mysql_query("INSERT INTO ".$prefix."_squery_games VALUES ('1', 'Americas Army');");
mysql_query("INSERT INTO ".$prefix."_squery_games VALUES ('2', 'BField:1942');");
mysql_query("INSERT INTO ".$prefix."_squery_games VALUES ('3', 'BField:Vietnam');");
mysql_query("INSERT INTO ".$prefix."_squery_games VALUES ('4', 'Battlefield 2');");
mysql_query("INSERT INTO ".$prefix."_squery_games VALUES ('5', 'Call of Duty');");
mysql_query("INSERT INTO ".$prefix."_squery_games VALUES ('6', 'CoD:United Offensive');");
mysql_query("INSERT INTO ".$prefix."_squery_games VALUES ('7', 'Call of Duty 2');");
mysql_query("INSERT INTO ".$prefix."_squery_games VALUES ('8', 'Chaser');");
mysql_query("INSERT INTO ".$prefix."_squery_games VALUES ('9', 'Chrome');");
mysql_query("INSERT INTO ".$prefix."_squery_games VALUES ('10', 'Counterstrike');");
mysql_query("INSERT INTO ".$prefix."_squery_games VALUES ('11', 'Cstrike:Source');");
mysql_query("INSERT INTO ".$prefix."_squery_games VALUES ('12', 'CnC Renegade');");
mysql_query("INSERT INTO ".$prefix."_squery_games VALUES ('13', 'Descent 3');");
mysql_query("INSERT INTO ".$prefix."_squery_games VALUES ('14', 'DoD:Source');");
mysql_query("INSERT INTO ".$prefix."_squery_games VALUES ('15', 'Doom3');");
mysql_query("INSERT INTO ".$prefix."_squery_games VALUES ('16', 'Devastation');");
mysql_query("INSERT INTO ".$prefix."_squery_games VALUES ('17', 'FarCry');");
mysql_query("INSERT INTO ".$prefix."_squery_games VALUES ('18', 'Global Ops');");
mysql_query("INSERT INTO ".$prefix."_squery_games VALUES ('19', 'Gore');");
mysql_query("INSERT INTO ".$prefix."_squery_games VALUES ('20', 'Halo');");
mysql_query("INSERT INTO ".$prefix."_squery_games VALUES ('21', 'Heretic 2');");
mysql_query("INSERT INTO ".$prefix."_squery_games VALUES ('22', 'Half-Life');");
mysql_query("INSERT INTO ".$prefix."_squery_games VALUES ('23', 'Half-Life 2');");
mysql_query("INSERT INTO ".$prefix."_squery_games VALUES ('24', 'HLife:CndZero');");
mysql_query("INSERT INTO ".$prefix."_squery_games VALUES ('25', 'HLife:Cstrike');");
mysql_query("INSERT INTO ".$prefix."_squery_games VALUES ('26', 'HLife:DMC');");
mysql_query("INSERT INTO ".$prefix."_squery_games VALUES ('27', 'HLife:DOD');");
mysql_query("INSERT INTO ".$prefix."_squery_games VALUES ('28', 'HLife:N.S.');");
mysql_query("INSERT INTO ".$prefix."_squery_games VALUES ('29', 'HLife:O.F.');");
mysql_query("INSERT INTO ".$prefix."_squery_games VALUES ('30', 'HLife:TFC');");
mysql_query("INSERT INTO ".$prefix."_squery_games VALUES ('31', 'IL-2 Sturmovik');");
mysql_query("INSERT INTO ".$prefix."_squery_games VALUES ('32', 'IGI2');");
mysql_query("INSERT INTO ".$prefix."_squery_games VALUES ('33', 'Jedi Knight 2');");
mysql_query("INSERT INTO ".$prefix."_squery_games VALUES ('34', 'Jedi Knight 3');");
mysql_query("INSERT INTO ".$prefix."_squery_games VALUES ('35', 'MOH:AA');");
mysql_query("INSERT INTO ".$prefix."_squery_games VALUES ('36', 'MOH:BT');");
mysql_query("INSERT INTO ".$prefix."_squery_games VALUES ('37', 'MOH:PA');");
mysql_query("INSERT INTO ".$prefix."_squery_games VALUES ('38', 'MOH:SH');");
mysql_query("INSERT INTO ".$prefix."_squery_games VALUES ('39', 'MTA(GTA3)');");
mysql_query("INSERT INTO ".$prefix."_squery_games VALUES ('40', 'NASCAR SimRacer');");
mysql_query("INSERT INTO ".$prefix."_squery_games VALUES ('41', 'NetPanzer');");
mysql_query("INSERT INTO ".$prefix."_squery_games VALUES ('42', 'NOLF');");
mysql_query("INSERT INTO ".$prefix."_squery_games VALUES ('43', 'NOLF 2');");
mysql_query("INSERT INTO ".$prefix."_squery_games VALUES ('44', 'Op. Flshpnt');");
mysql_query("INSERT INTO ".$prefix."_squery_games VALUES ('45', 'Painkiller');");
mysql_query("INSERT INTO ".$prefix."_squery_games VALUES ('46', 'Postal 2');");
mysql_query("INSERT INTO ".$prefix."_squery_games VALUES ('47', 'Purge Jihad');");
mysql_query("INSERT INTO ".$prefix."_squery_games VALUES ('48', 'Quake 2');");
mysql_query("INSERT INTO ".$prefix."_squery_games VALUES ('49', 'Quake 3');");
mysql_query("INSERT INTO ".$prefix."_squery_games VALUES ('50', 'Quake 4');");
mysql_query("INSERT INTO ".$prefix."_squery_games VALUES ('51', 'Quake 3:UT');");
mysql_query("INSERT INTO ".$prefix."_squery_games VALUES ('52', 'QuakeWorld');");
mysql_query("INSERT INTO ".$prefix."_squery_games VALUES ('53', 'Rally Masters');");
mysql_query("INSERT INTO ".$prefix."_squery_games VALUES ('54', 'RavenShield');");
mysql_query("INSERT INTO ".$prefix."_squery_games VALUES ('55', 'RTCW');");
mysql_query("INSERT INTO ".$prefix."_squery_games VALUES ('56', 'RTCW:ET');");
mysql_query("INSERT INTO ".$prefix."_squery_games VALUES ('57', 'Rune');");
mysql_query("INSERT INTO ".$prefix."_squery_games VALUES ('58', 'Savage');");
mysql_query("INSERT INTO ".$prefix."_squery_games VALUES ('59', 'Serious Sam');");
mysql_query("INSERT INTO ".$prefix."_squery_games VALUES ('60', 'Serious Sam 2');");
mysql_query("INSERT INTO ".$prefix."_squery_games VALUES ('61', 'Sin');");
mysql_query("INSERT INTO ".$prefix."_squery_games VALUES ('62', 'SOF');");
mysql_query("INSERT INTO ".$prefix."_squery_games VALUES ('63', 'SOF II');");
mysql_query("INSERT INTO ".$prefix."_squery_games VALUES ('64', 'Soldat');");
mysql_query("INSERT INTO ".$prefix."_squery_games VALUES ('65', 'ST:Elite Force');");
mysql_query("INSERT INTO ".$prefix."_squery_games VALUES ('66', 'ST:Elite Force 2');");
mysql_query("INSERT INTO ".$prefix."_squery_games VALUES ('67', 'SW:Battlefront');");
mysql_query("INSERT INTO ".$prefix."_squery_games VALUES ('68', 'Tactical Ops');");
mysql_query("INSERT INTO ".$prefix."_squery_games VALUES ('69', 'Unreal');");
mysql_query("INSERT INTO ".$prefix."_squery_games VALUES ('70', 'Unreal 2 XMP');");
mysql_query("INSERT INTO ".$prefix."_squery_games VALUES ('71', 'UT');");
mysql_query("INSERT INTO ".$prefix."_squery_games VALUES ('72', 'UT2003');");
mysql_query("INSERT INTO ".$prefix."_squery_games VALUES ('73', 'UT2004');");
mysql_query("INSERT INTO ".$prefix."_squery_games VALUES ('74', 'VietCong');");*/

# --------------------------------------------------------
#
# Table structure for table '".$prefix."_squery_servers'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_squery_servers;");
/*mysql_query("CREATE TABLE ".$prefix."_squery_servers (
   `id` varchar(100) NOT NULL,
   `staticip` varchar(100) NOT NULL,
   `staticport` varchar(50) NOT NULL,
   `staticgame` varchar(255) NOT NULL,
   `servername` varchar(255) NOT NULL,
   `hideserver` varchar(255) NOT NULL,
   `hideblock` varchar(255) NOT NULL,
   KEY id (id)
);");

#
# Dumping data for table '".$prefix."_squery_servers'
#

mysql_query("INSERT INTO ".$prefix."_squery_servers VALUES ('1', '67.18.175.110', '16567', 'Battlefield 2', '=SK= BF2 Clanzunited.com', '1', '1');");
mysql_query("INSERT INTO ".$prefix."_squery_servers VALUES ('2', '72.20.12.139', '27015', 'Cstrike:Source', '=SK= Source', '1', '1');");
mysql_query("INSERT INTO ".$prefix."_squery_servers VALUES ('3', '64.34.164.46', '20100', 'SOF II', 'TEAMFN SoF2', '1', '1');");
mysql_query("INSERT INTO ".$prefix."_squery_servers VALUES ('4', '83.142.49.162', '28950', 'CoD:United Offensive', '{TLS} T*D*M Server', '1', '1');");
mysql_query("INSERT INTO ".$prefix."_squery_servers VALUES ('5', '67.18.175.110', '16567', 'Battlefield 2', '=SK= BF2 Clanzunited.com', '1', '1');");
mysql_query("INSERT INTO ".$prefix."_squery_servers VALUES ('6', '', '', '', '', '0', '0');");
mysql_query("INSERT INTO ".$prefix."_squery_servers VALUES ('7', '', '', '', '', '0', '0');");
mysql_query("INSERT INTO ".$prefix."_squery_servers VALUES ('8', '', '', '', '', '0', '0');");
mysql_query("INSERT INTO ".$prefix."_squery_servers VALUES ('9', '', '', '', '', '0', '0');");
mysql_query("INSERT INTO ".$prefix."_squery_servers VALUES ('10', '', '', '', '', '0', '0');");
*/
# --------------------------------------------------------
#
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



//
// Table structure for table `".$prefix."_sommaire_categories`
//

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

# Table structure for table '".$prefix."_stats_date'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_stats_date;");
mysql_query("CREATE TABLE ".$prefix."_stats_date (
   `year` smallint(6) DEFAULT '0' NOT NULL,
   `month` tinyint(4) DEFAULT '0' NOT NULL,
   `date` tinyint(4) DEFAULT '0' NOT NULL,
   `hits` bigint(20) DEFAULT '0' NOT NULL
);");

#
# Dumping data for table '".$prefix."_stats_date'
#

# --------------------------------------------------------
#
# Table structure for table '".$prefix."_stats_hour'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_stats_hour;");
mysql_query("CREATE TABLE ".$prefix."_stats_hour (
   `year` smallint(6) DEFAULT '0' NOT NULL,
   `month` tinyint(4) DEFAULT '0' NOT NULL,
   `date` tinyint(4) DEFAULT '0' NOT NULL,
   `hour` tinyint(4) DEFAULT '0' NOT NULL,
   `hits` int(11) DEFAULT '0' NOT NULL
);");

#
# Dumping data for table '".$prefix."_stats_hour'
#

# --------------------------------------------------------
#
# Table structure for table '".$prefix."_stats_month'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_stats_month;");
mysql_query("CREATE TABLE ".$prefix."_stats_month (
   `year` smallint(6) DEFAULT '0' NOT NULL,
   `month` tinyint(4) DEFAULT '0' NOT NULL,
   `hits` bigint(20) DEFAULT '0' NOT NULL
);");

#
# Dumping data for table '".$prefix."_stats_month'
#

# --------------------------------------------------------
#
# Table structure for table '".$prefix."_stats_year'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_stats_year;");
mysql_query("CREATE TABLE ".$prefix."_stats_year (
   `year` smallint(6) DEFAULT '0' NOT NULL,
   `hits` bigint(20) DEFAULT '0' NOT NULL
);");

#
# Dumping data for table '".$prefix."_stats_year'
#


# --------------------------------------------------------
#
# Table structure for table '".$prefix."_stories'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_stories;");
mysql_query("CREATE TABLE ".$prefix."_stories (
   `sid` int(11) NOT NULL auto_increment,
   `catid` int(11) DEFAULT '0' NOT NULL,
   `aid` varchar(25) NOT NULL,
   `title` varchar(80),
   `time` datetime,
   `hometext` text,
   `bodytext` text NOT NULL,
   `comments` int(11) DEFAULT '0',
   `counter` mediumint(8) unsigned,
   `topic` int(3) DEFAULT '1' NOT NULL,
   `informant` varchar(25) NOT NULL,
   `notes` text NOT NULL,
   `ihome` int(1) DEFAULT '0' NOT NULL,
   `alanguage` varchar(30) NOT NULL,
   `acomm` int(1) DEFAULT '0' NOT NULL,
   `haspoll` int(1) DEFAULT '0' NOT NULL,
   `pollID` int(10) DEFAULT '0' NOT NULL,
   `score` int(10) DEFAULT '0' NOT NULL,
   `ratings` int(10) DEFAULT '0' NOT NULL,
   `associated` text NOT NULL,
   PRIMARY KEY (sid),
   KEY sid (sid),
   KEY catid (catid),
   KEY counter (counter),
   KEY topic (topic)
);");

#
# Dumping data for table '".$prefix."_stories'
#


# --------------------------------------------------------
#
# Table structure for table '".$prefix."_stories_cat'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_stories_cat;");
mysql_query("CREATE TABLE ".$prefix."_stories_cat (
   `catid` int(11) NOT NULL auto_increment,
   `title` varchar(20) NOT NULL,
   `counter` int(11) DEFAULT '0' NOT NULL,
   PRIMARY KEY (catid),
   KEY catid (catid)
);");

#
# Dumping data for table '".$prefix."_stories_cat'
#


# --------------------------------------------------------
#
# Table structure for table '".$prefix."_subscriptions'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_subscriptions;");
mysql_query("CREATE TABLE ".$prefix."_subscriptions (
   `id` int(10) NOT NULL auto_increment,
   `userid` int(10) DEFAULT '0',
   `subscription_expire` varchar(50) NOT NULL,
   KEY id (id, userid)
);");

#
# Dumping data for table '".$prefix."_subscriptions'
#


# --------------------------------------------------------
#
# Table structure for table '".$prefix."_teamspeak'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_teamspeak;");
/*mysql_query("CREATE TABLE ".$prefix."_teamspeak (
   `tsip` varchar(100) NOT NULL,
   `tsport` varchar(100) NOT NULL,
   `tsqport` varchar(50) NOT NULL,
   `adminname` varchar(255) NOT NULL,
   `tsaway` varchar(50) NOT NULL,
   `tsrule1` varchar(255) NOT NULL,
   `tsrule2` varchar(255) NOT NULL,
   `tsrule3` varchar(255) NOT NULL
);");

#
# Dumping data for table '".$prefix."_teamspeak'
#

mysql_query("INSERT INTO ".$prefix."_teamspeak VALUES ('IP/url', '8767', '51234', 'Server Adminname', 'Away', 'Server Rule 1', 'Server Rule 2', 'Server Rule 3');");
*/
# --------------------------------------------------------
#
# Table structure for table '".$prefix."_themeconsole'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_themeconsole;");
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

# --------------------------------------------------------
#
# Table structure for table '".$prefix."_topics'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_topics;");
mysql_query("CREATE TABLE ".$prefix."_topics (
   `topicid` int(3) NOT NULL auto_increment,
   `topicname` varchar(20),
   `topicimage` varchar(20),
   `topictext` varchar(40),
   `counter` int(11) DEFAULT '0' NOT NULL,
   PRIMARY KEY (topicid),
   KEY topicid (topicid)
);");

#
# Dumping data for table '".$prefix."_topics'
#

mysql_query("INSERT INTO ".$prefix."_topics VALUES ('1', 'phpnuke', 'phpnuke.gif', 'PHP-Nuke', '0');");

# --------------------------------------------------------
#
# Table structure for table '".$prefix."_treasury_config'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_treasury_config;");
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

# --------------------------------------------------------
#
# Table structure for table '".$prefix."_treasury_financial'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_treasury_financial;");
mysql_query("CREATE TABLE ".$prefix."_treasury_financial (
   `id` int(11) NOT NULL auto_increment,
   `date` datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
   `num` varchar(16) NOT NULL,
   `name` varchar(128) NOT NULL,
   `descr` varchar(128) NOT NULL,
   `amount` varchar(10) NOT NULL,
   PRIMARY KEY (id)
);");

#
# Dumping data for table '".$prefix."_treasury_financial'
#


# --------------------------------------------------------
#
# Table structure for table '".$prefix."_treasury_transactions'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_treasury_transactions;");
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


# --------------------------------------------------------
#
# Table structure for table '".$prefix."_treasury_translog'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_treasury_translog;");
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


# --------------------------------------------------------
#
# Table structure for table '".$prefix."_users'
#

mysql_query("DROP TABLE IF EXISTS ".$user_prefix."_users;");
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
   `agreedtos` tinyint(1) DEFAULT '0' NOT NULL,
   PRIMARY KEY (user_id),
   KEY uid (user_id),
   KEY uname (username),
   KEY user_session_time (user_session_time)
);");

#
# Dumping data for table '".$prefix."_users'
#

mysql_query("INSERT INTO ".$user_prefix."_users VALUES ('1', '', 'Anonymous', '', '', '', 'blank.gif', 'Nov 10, 2000', '', '', '', '', '', '0', '0', '', '', '', '', '10', '', '0', '0', '0', '', '0', '', '', '4096', '0', '0', '0', '0', '0', '1', '0', '0', '1', '0', '0', '0', '10', NULL, 'english', 'D M d, Y g:i a', '0', '0', '0', NULL, '1', '1', '1', '1', '1', '1', '1', '1', '0', '3', NULL, NULL, NULL, '0', '', '0');");


# --------------------------------------------------------
#
# Table structure for table '".$prefix."_users_temp'
#

mysql_query("DROP TABLE IF EXISTS ".$user_prefix."_users_temp;");
mysql_query("CREATE TABLE ".$user_prefix."_users_temp (
   `user_id` int(10) NOT NULL auto_increment,
   `username` varchar(25) NOT NULL,
   `realname` varchar(255) NOT NULL,
   `user_email` varchar(255) NOT NULL,
   `user_password` varchar(40) NOT NULL,
   `user_regdate` varchar(20) NOT NULL,
   `check_num` varchar(50) NOT NULL,
   `time` varchar(14) NOT NULL,
   PRIMARY KEY (user_id)
);");

#
# Dumping data for table '".$prefix."_users_temp'
#


# --------------------------------------------------------
#
# Table structure for table '".$prefix."_ventrilo'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_ventrilo;");
/*mysql_query("CREATE TABLE ".$prefix."_ventrilo (
   `ventip` varchar(100) NOT NULL,
   `ventport` varchar(100) NOT NULL,
   `ventpass` varchar(50) NOT NULL,
   `servername` varchar(255) NOT NULL,
   `enablelink` int(1) DEFAULT '0' NOT NULL
);");

#
# Dumping data for table '".$prefix."_ventrilo'
#

mysql_query("INSERT INTO ".$prefix."_ventrilo VALUES ('81.19.223.42', '3784', '', '', '0');");
*/
# --------------------------------------------------------
#
# Table structure for table '".$prefix."_whoiswhere'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_whoiswhere;");
mysql_query("CREATE TABLE ".$prefix."_whoiswhere (
   `username` varchar(25) NOT NULL,
   `time` varchar(14) NOT NULL,
   `host_addr` varchar(48) NOT NULL,
   `guest` int(1) DEFAULT '0' NOT NULL,
   `module` varchar(30) NOT NULL,
   `url` varchar(255) NOT NULL
);");

#
# Dumping data for table '".$prefix."_whoiswhere'
#



# --------------------------------------------------------
#
# Table structure for table '".$prefix."_xfire'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_xfire;");
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

# --------------------------------------------------------
#
# Table structure for table '".$prefix."_xfirecfg'
#

mysql_query("DROP TABLE IF EXISTS ".$prefix."_xfirecfg;");
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


// NukeLan Tables
mysql_query("CREATE TABLE IF NOT EXISTS `nukelan_admins` (
                   `aid` varchar(255) NOT NULL default '',
                   `parties` tinyint(1) NOT NULL default '0',
                   `staff` tinyint(1) NOT NULL default '0',
                   `accessories` tinyint(1) NOT NULL default '0',
                   `check_in` tinyint(1) NOT NULL default '0',
                   `tourney_mod` tinyint(1) NOT NULL default '0',
                   `edit_admins` tinyint(1) NOT NULL default '0',
                   PRIMARY KEY  (`aid`)
                   ) TYPE=MyISAM;");

mysql_query("CREATE TABLE IF NOT EXISTS `nukelan_config` (
                    `id` INTEGER (11) NOT NULL  DEFAULT 0,
                    `config_id` INTEGER (11) NOT NULL  DEFAULT 0,
                    `notes` varchar (50),
                    PRIMARY KEY (id)
                    ) TYPE=MyISAM;");

mysql_query("CREATE TABLE IF NOT EXISTS `nukelan_gamer_profiles` (
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
                    ) TYPE=MyISAM;");

mysql_query("CREATE TABLE IF NOT EXISTS `nukelan_gamer_rigs` (
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
                    ) TYPE=MyISAM;");

mysql_query("CREATE TABLE IF NOT EXISTS `nukelan_games` (
                    `gameid` int(11) NOT NULL auto_increment,
                    `name` varchar(255) NOT NULL default '',
                    `version` varchar(255) default NULL,
                    PRIMARY KEY  (`gameid`)
                    ) TYPE=MyISAM;");

mysql_query("CREATE TABLE IF NOT EXISTS `nukelan_hosts` (
                    `host_id` INTEGER (3) NOT NULL  AUTO_INCREMENT ,
                    `fname` varchar (40) NOT NULL ,
                    `email` varchar (40) NOT NULL ,
                    `phone` varchar (30) NOT NULL ,
                    `config_id` tinyint (4) NOT NULL  DEFAULT 0,
                    PRIMARY KEY (host_id)
                    ) TYPE=MyISAM;");

mysql_query("CREATE TABLE IF NOT EXISTS `nukelan_jobs` (
                    `jobid` INTEGER (11) NOT NULL  AUTO_INCREMENT ,
                    `name` varchar (50) NOT NULL ,
                    `notes` blob NOT NULL ,
                    `max` INTEGER (6) NOT NULL  DEFAULT 0,
                    `super` INTEGER (11),
                    `config_id` tinyint (4) NOT NULL  DEFAULT 0,
                     PRIMARY KEY (jobid)
                     ) TYPE=MyISAM;");

mysql_query("CREATE TABLE IF NOT EXISTS `nukelan_locations` (
                    `loc_id` INTEGER (3) NOT NULL  AUTO_INCREMENT ,
                    `keyword` varchar (40) NOT NULL ,
                    `addr` varchar (255) NOT NULL ,
                    `city` varchar (50) NOT NULL ,
                    `state` CHAR (2) NOT NULL ,
                    `zip` varchar (10) NOT NULL ,
                    PRIMARY KEY (loc_id)
                    ) TYPE=MyISAM;");

mysql_query("CREATE TABLE IF NOT EXISTS `nukelan_lodging` (
                    `itemid` bigint (20) NOT NULL  AUTO_INCREMENT ,
                    `name` varchar (255),
                    `address` varchar (255),
                    `phone` varchar (20),
                    `costpernight` bigint (20) NOT NULL  DEFAULT 0,
                    `traveltime` varchar (100),
                    `config_id` tinyint (4) NOT NULL  DEFAULT 0,
                    PRIMARY KEY (itemid)
                    ) TYPE=MyISAM;");

mysql_query("CREATE TABLE IF NOT EXISTS `nukelan_map_temp`
                                (
                                `uid` INTEGER (11),
                                `room_id` INTEGER (11) NOT NULL  DEFAULT 0,
                                `aid` varchar (50)
                                ) TYPE=MyISAM;");

mysql_query("CREATE TABLE IF NOT EXISTS `nukelan_parties` (
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
                    ) TYPE=MyISAM;");

mysql_query("CREATE TABLE IF NOT EXISTS `nukelan_paypal` (
                    `paypal_id` int(3) NOT NULL auto_increment,
                    `keyword` varchar(40) NOT NULL default '',
                    `account` varchar(40) NOT NULL default '',
                    `pmttitle` varchar(100) NOT NULL default '',
                    `add_chg` float(5,2) NOT NULL default '0.00',
                    `notify` varchar(150) NOT NULL default '',
					`currency` varchar(3) NOT NULL default '',
                    PRIMARY KEY  (`paypal_id`)
                    ) TYPE=MyISAM;");

mysql_query("CREATE TABLE IF NOT EXISTS `nukelan_prizes` (
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
                    ) TYPE=MyISAM;");

mysql_query("CREATE TABLE IF NOT EXISTS `nukelan_seat_objects` (
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
                    ) TYPE=MyISAM;");

mysql_query("CREATE TABLE IF NOT EXISTS `nukelan_seat_rooms` (
                    `id` bigint (20) NOT NULL  AUTO_INCREMENT ,
                    `name` varchar (255),
                    `description` varchar (255),
                    `width` INTEGER (11) NOT NULL  DEFAULT 0,
                    `height` INTEGER (11) NOT NULL  DEFAULT 0,
                    PRIMARY KEY (id)
                    ) TYPE=MyISAM;");

mysql_query("CREATE TABLE IF NOT EXISTS `nukelan_signedup` (
                    `lan_uid` int(11) NOT NULL default '0',
                    `lan_id` int(11) NOT NULL default '0',
                    `lan_paid` tinyint(1) default '0',
                    `lan_date` datetime NOT NULL default '0000-00-00 00:00:00',
                    `checkin` tinyint(1) NOT NULL default '0',
                    `checkin_time` datetime NOT NULL default '0000-00-00 00:00:00',
					`room_loc` int(11) default NULL,
                    `charge` float(5,2) NOT NULL default '0.00',
                    `regtype` varchar(1) NOT NULL default 'a'
                    ) TYPE=MyISAM;");

mysql_query("CREATE TABLE IF NOT EXISTS `nukelan_sponsors` (
                                  `id` int(11) NOT NULL auto_increment,
                                  `sponsor_name` varchar(60) NOT NULL default '',
                                  `contact` varchar(60) NOT NULL default '',
                                  `email` varchar(60) NOT NULL default '',
                                  `login` varchar(10) NOT NULL default '',
                                  `passwd` varchar(10) NOT NULL default '',
                                  `moreinfo` blob NOT NULL,
                                  PRIMARY KEY  (`id`),
                                  KEY `id` (`id`)
                                ) TYPE=MyISAM;");

mysql_query("CREATE TABLE IF NOT EXISTS `nukelan_sponsors_banners` (
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
                                ) TYPE=MyISAM;");

mysql_query("CREATE TABLE IF NOT EXISTS `nukelan_sponsors_parties` (
                                 `party_id` int(11) NOT NULL default '0',
                                 `sponsor_id` int(11) NOT NULL default '0'
                                ) TYPE=MyISAM;");

mysql_query("CREATE TABLE IF NOT EXISTS `nukelan_staff`
                                (
                                `id` INTEGER (11) NOT NULL  AUTO_INCREMENT ,
                                `userid` INTEGER (11),
                                `jobid` INTEGER (11),
                                `approve` INTEGER (1) NOT NULL  DEFAULT 0,
                                `unotes` blob,
                                PRIMARY KEY (id)
                                ) TYPE=MyISAM;");

mysql_query("CREATE TABLE IF NOT EXISTS `nukelan_tournament_players`
                                (
                                `id` bigint (20) NOT NULL  AUTO_INCREMENT ,
                                `tourneyid` bigint (20) NOT NULL  DEFAULT 0,
                                `userid` bigint (20) NOT NULL  DEFAULT 0,
                                `teamid` bigint (20),
                                `ranking` bigint (20) NOT NULL  DEFAULT 0,
                                `config_id` tinyint (4) NOT NULL  DEFAULT 0,
                                PRIMARY KEY (id)
                                ) TYPE=MyISAM;");

mysql_query("CREATE TABLE IF NOT EXISTS `nukelan_tournament_teams`
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
                                ) TYPE=MyISAM;");

mysql_query("CREATE TABLE IF NOT EXISTS `nukelan_tournaments`
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
                                ) TYPE=MyISAM;");

mysql_query("insert  into nukelan_games values
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
                               (NULL, 'Quake 3 Arena', NULL);");

//exit();
?>