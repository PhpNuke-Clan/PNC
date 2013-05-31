<?php
if( !defined('PNC_UPD')){
die("Access denied!");
}
//***************************************************************************
/* Author: XenoMorpH ¤TÐI¤ (aarvuijk@hotmail.com)                           */
/* Development Assistance: CrazyCrack (support@phpnuke-clan.com)            */
//***************************************************************************

function mysql_table_exists($table) {
   $exists = mysql_query("SELECT 1 FROM `$table` LIMIT 0");
   if ($exists) return true;
   return false;
}

         $query1 = mysql_query("SHOW COLUMNS FROM ".$prefix."_authors LIKE 'radminblocker'") or print(mysql_error());

        if (mysql_num_rows($query1) == 0) {echo 'Column <b>radminblocker</b> does not exist in table '.$prefix.'_authors, that is ok :)<br>';}
        else {mysql_query("ALTER TABLE ".$prefix."_authors DROP radminblocker")or print('MySQL said: '.mysql_error());
                echo"Column<b> radminblocker</b> is deleted from table ".$prefix."_authors.<br>";}

                 $query2 = mysql_query("SHOW COLUMNS FROM ".$prefix."_bbauth_access LIKE 'auth_globalannounce'") or print(mysql_error());
                 if (mysql_num_rows($query2) == 0) {echo 'Column <b>auth_globalannounce</b> does not exist in table '.$prefix.'_bbauth_access, that is ok :)<br>';}else {mysql_query("ALTER TABLE ".$prefix."_bbauth_access DROP auth_globalannounce")or print('MySQL said: '.mysql_error());
                echo"Column<b> auth_globalannounce</b> is deleted<br>";}
                 $query2b = mysql_query("SHOW COLUMNS FROM ".$prefix."_bbauth_access LIKE 'auth_download'") or print(mysql_error());
                 if (mysql_num_rows($query2b) == 0) {echo 'Column <b>auth_download</b> does not exist in table '.$prefix.'_auth_download, that is ok :)<br>';}else {mysql_query("ALTER TABLE ".$prefix."_bbauth_access DROP auth_download")or print('MySQL said: '.mysql_error());
                echo"Column<b> auth_globalannounce</b> is deleted<br>";}
                 $query2c = mysql_query("SHOW COLUMNS FROM ".$prefix."_bbauth_access LIKE 'auth_news'") or print(mysql_error());
                 if (mysql_num_rows($query2c) == 0) {echo 'Column <b>auth_news</b> does not exist in table '.$prefix.'_bbauth_access, that is ok :)<br>';}else {mysql_query("ALTER TABLE ".$prefix."_bbauth_access DROP auth_news")or print('MySQL said: '.mysql_error());
                echo"Column<b> auth_news</b> is deleted<br>";}

        mysql_query("INSERT INTO `".$prefix."_bbconfig` VALUES ('allow_autologin', '1')");
        mysql_query("INSERT INTO `".$prefix."_bbconfig` VALUES ('allow_avatar_remote', '0')");
        mysql_query("INSERT INTO `".$prefix."_bbconfig` VALUES ('allow_avatar_upload', '0')");
        mysql_query("INSERT INTO `".$prefix."_bbconfig` VALUES ('allow_html_tags', 'b,i,u,pre')");
        mysql_query("INSERT INTO `".$prefix."_bbconfig` VALUES ('allow_theme_create', '')");
        mysql_query("INSERT INTO `".$prefix."_bbconfig` VALUES ('avatar_max_height', '80')");
        mysql_query("INSERT INTO `".$prefix."_bbconfig` VALUES ('avatar_max_width', '80')");
        mysql_query("INSERT INTO `".$prefix."_bbconfig` VALUES ('login_reset_time', '30')");
        mysql_query("INSERT INTO `".$prefix."_bbconfig` VALUES ('max_autologin_time', '0')");
        mysql_query("INSERT INTO `".$prefix."_bbconfig` VALUES ('max_login_attempts', '5')");
        mysql_query("INSERT INTO `".$prefix."_bbconfig` VALUES ('rand_seed', '2498fc0ea1f5908a140f54b68eac0d3d')");
        mysql_query("INSERT INTO `".$prefix."_bbconfig` VALUES ('search_flood_interval', '15')");
        mysql_query("INSERT INTO `".$prefix."_bbconfig` VALUES ('search_min_chars', '3')");
        mysql_query("INSERT INTO `".$prefix."_bbconfig` VALUES ('session_length', '3600')");
        mysql_query("INSERT INTO `".$prefix."_bbconfig` VALUES ('sitename', 'PNC 4.0')");
        mysql_query("INSERT INTO `".$prefix."_bbconfig` VALUES ('site_desc', '')");
        mysql_query("INSERT INTO `".$prefix."_bbconfig` VALUES ('smilies_path', 'modules/Forums/images/smiles')");
        mysql_query("INSERT INTO `".$prefix."_bbconfig` VALUES ('smtp_delivery', '1')");
        mysql_query("INSERT INTO `".$prefix."_bbconfig` VALUES ('smtp_host', '')");
        mysql_query("INSERT INTO `".$prefix."_bbconfig` VALUES ('smtp_password', '')");
        mysql_query("INSERT INTO `".$prefix."_bbconfig` VALUES ('smtp_username', '')");
        mysql_query("INSERT INTO `".$prefix."_bbconfig` VALUES ('topics_per_page', '50')");
        mysql_query("UPDATE ".$prefix."_bbconfig SET config_value='.0.23' where config_name='version'");

                 $query3 = mysql_query("SHOW COLUMNS FROM ".$prefix."_bbforums LIKE 'auth_globalannounce'") or print(mysql_error());
                 if (mysql_num_rows($query3) == 0) {echo 'Column <b>auth_globalannounce</b> does not exist in table '.$prefix.'_bbforums, that is ok :)<br>';}else {mysql_query("ALTER TABLE ".$prefix."_bbforums DROP auth_globalannounce")or print('MySQL said: '.mysql_error());
                echo"Column<b> auth_globalannounce</b> is deleted<br>";}
                 $query3b = mysql_query("SHOW COLUMNS FROM ".$prefix."_bbforums LIKE 'auth_download'") or print(mysql_error());
                 if (mysql_num_rows($query3b) == 0) {echo 'Column <b>auth_download</b> does not exit in table, that is ok :)<br>';}else {mysql_query("ALTER TABLE ".$prefix."_bbforums DROP auth_download")or print('MySQL said: '.mysql_error());
                echo"Column<b> auth_download</b> is deleted<br>";}
                 $query3c = mysql_query("SHOW COLUMNS FROM ".$prefix."_bbforums LIKE 'auth_news'") or print(mysql_error());
                 if (mysql_num_rows($query3c) == 0) {echo 'Column <b>auth_news</b> does not exist in table '.$prefix.'_bbforums, that is ok :)<br>';}else {mysql_query("ALTER TABLE ".$prefix."_bbforums DROP auth_news")or print('MySQL said: '.mysql_error());
                echo"Column<b> auth_news</b> is deleted<br>";}

                $query4 = mysql_query("SHOW COLUMNS FROM ".$prefix."_bbgroups LIKE 'canned_footer_plain'") or print(mysql_error());
                 if (mysql_num_rows($query4) == 0) {echo 'Column <b>canned_footer_plain</b> does not exist in table '.$prefix.'_bbgroups, that is ok :)<br>';}else {mysql_query("ALTER TABLE ".$prefix."_bbgroups DROP canned_footer_plain")or print('MySQL said: '.mysql_error());
                echo"Column<b> canned_footer_plain</b> is deleted<br>";}
                 $query4a = mysql_query("SHOW COLUMNS FROM ".$prefix."_bbgroups LIKE 'canned_footer_bbcode'") or print(mysql_error());
                 if (mysql_num_rows($query4a) == 0) {echo 'Column <b>canned_footer_bbcode</b> does not exist in table '.$prefix.'_bbgroups, that is ok :)<br>';}else {mysql_query("ALTER TABLE ".$prefix."_bbgroups DROP canned_footer_bbcode")or print('MySQL said: '.mysql_error());
                echo"Column<b> canned_footer_bbcode</b> is deleted<br>";}
                 $query4b = mysql_query("SHOW COLUMNS FROM ".$prefix."_bbgroups LIKE 'canned_custom_count'") or print(mysql_error());
                 if (mysql_num_rows($query4b) == 0) {echo 'Column <b>canned_custom_count</b> does not exist in table '.$prefix.'_bbgroups, that is ok :)<br>';}else {mysql_query("ALTER TABLE ".$prefix."_bbgroups DROP canned_custom_count")or print('MySQL said: '.mysql_error());
                echo"Column<b> canned_custom_count</b> is deleted<br>";}

                 $query5 = mysql_query("SHOW COLUMNS FROM ".$prefix."_bbposts LIKE 'post_attachment'") or print(mysql_error());
                 if (mysql_num_rows($query5) == 0) {echo 'Column <b>post_attachment</b> does not exist in table '.$prefix.'_bbposts, that is ok :)<br>';}else {mysql_query("ALTER TABLE ".$prefix."_bbposts DROP post_attachment")or print('MySQL said: '.mysql_error());
                echo"Column<b> post_attachment</b> is deleted<br>";}

                 $query6 = mysql_query("SHOW COLUMNS FROM ".$prefix."_bbprivmsgs LIKE 'privmsgs_attachment'") or print(mysql_error());
                 if (mysql_num_rows($query6) == 0) {echo 'Column <b>privmsgs_attachment</b> does not exist in table '.$prefix.'_bbprivmsgs, that is ok :)<br>';}else {mysql_query("ALTER TABLE ".$prefix."_bbprivmsgs DROP privmsgs_attachment")or print('MySQL said: '.mysql_error());
                echo"Column<b> privmsgs_attachment</b> is deleted<br>";}

         $query7 = mysql_query("SHOW COLUMNS FROM ".$prefix."_bbsearch_results LIKE 'search_time'") or print(mysql_error());
                 if (!mysql_num_rows($query7) == 0) {echo 'Column <b>search_time</b> does already exist in table '.$prefix.'_bbsearch_results, that is ok :)<br>';}
                 else {mysql_query("ALTER TABLE ".$prefix."_bbsearch_results ADD search_time int(11) DEFAULT '0' NOT NULL AFTER search_array")
                 or print('MySQL said: '.mysql_error());
        echo"Column search_time is added to table <b>".$prefix."_bbsearch_results</b><br>";}

                $query8= mysql_query("SHOW COLUMNS FROM ".$prefix."_bbsessions LIKE 'session_admin'") or print(mysql_error());
                 if (!mysql_num_rows($query8) == 0) {echo 'Column <b>session_admin</b> does already exist in table '.$prefix.'_bbsessions, that is ok :)<br>';}else {mysql_query("ALTER TABLE ".$prefix."_bbsessions ADD session_admin tinyint(2)  default '0' NOT NULL AFTER session_logged_in")or print('MySQL said: '.mysql_error());
        echo"Column session_admin is added to table <b>".$prefix."_bbsessions</b><br>";}

                 $query9 = mysql_query("SHOW COLUMNS FROM ".$prefix."_bbsmilies LIKE 'smile_stat'") or print(mysql_error());
                 if (mysql_num_rows($query9) == 0) {echo 'Column <b>smile_stat</b> does not exist in table '.$prefix.'_bbsmilies, that is ok :)<br>';}else {mysql_query("ALTER TABLE ".$prefix."_bbsmilies DROP smile_stat")or print('MySQL said: '.mysql_error());
                echo"Column<b> smile_stat</b> is deleted from table ".$prefix."_bbsmilies <br>";}

 $query10 = mysql_query("SHOW COLUMNS FROM ".$prefix."_bbthemes LIKE 'online_color'") or print(mysql_error());
                 if (mysql_num_rows($query10) == 0) {echo 'Column <b>online_color</b> does not exist in table '.$prefix.'_bbthemes, that is ok :)<br>';}else {mysql_query("ALTER TABLE ".$prefix."_bbthemes DROP online_color")or print('MySQL said: '.mysql_error());
                echo"Column<b> online_color</b> is deleted from table ".$prefix."_bbthemes <br>";}

 $query10b = mysql_query("SHOW COLUMNS FROM ".$prefix."_bbthemes LIKE 'offline_color'") or print(mysql_error());
                 if (mysql_num_rows($query10b) == 0) {echo 'Column <b>offline_color</b> does not exist in table '.$prefix.'_bbthemes, that is ok :)<br>';}else {mysql_query("ALTER TABLE ".$prefix."_bbthemes DROP offline_color")or print('MySQL said: '.mysql_error());
                echo"Column<b> offline_color</b> is deleted from table ".$prefix."_bbthemes <br>";}

 $query10c = mysql_query("SHOW COLUMNS FROM ".$prefix."_bbthemes LIKE 'hidden_color'") or print(mysql_error());
                 if (mysql_num_rows($query10c) == 0) {echo 'Column <b>hidden_color</b> does not exist in table '.$prefix.'_bbthemes, that is ok :)<br>';}else {mysql_query("ALTER TABLE ".$prefix."_bbthemes DROP hidden_color")or print('MySQL said: '.mysql_error());
                echo"Column<b> hidden_color</b> is deleted from table ".$prefix."_bbthemes <br>";}

$query11 = mysql_query("SHOW COLUMNS FROM ".$prefix."_bbtopics LIKE 'topic_attachment'") or print(mysql_error());
                 if (mysql_num_rows($query11) == 0) {echo 'Column <b>topic_attachment</b> does not exist in table '.$prefix.'_bbtopics, that is ok :)<br>';}else {mysql_query("ALTER TABLE ".$prefix."_bbtopics DROP topic_attachment")or print('MySQL said: '.mysql_error());
                echo"Column<b> topic_attachment</b> is deleted from table ".$prefix."_bbtopics <br>";}

 $query11b = mysql_query("SHOW COLUMNS FROM ".$prefix."_bbtopics LIKE 'news_id'") or print(mysql_error());
                 if (mysql_num_rows($query11b) == 0) {echo 'Column <b>news_id</b> does not exist in table '.$prefix.'_bbtopics, that is ok :)<br>';}else {mysql_query("ALTER TABLE ".$prefix."_bbtopics DROP news_id")or print('MySQL said: '.mysql_error());
                echo"Column<b> news_id</b> is deleted from table ".$prefix."_bbtopics <br>";}

$query12 = mysql_query("SHOW COLUMNS FROM ".$prefix."_bbvote_voters LIKE 'vote_cast'") or print(mysql_error());
                 if (mysql_num_rows($query12) == 0) {echo 'Column <b>vote_cast</b> does not exist in table '.$prefix.'_bbvote_voters, that is ok :)<br>';}else {mysql_query("ALTER TABLE ".$prefix."_bbvote_voters DROP vote_cast")or print('MySQL said: '.mysql_error());
                echo"Column<b> vote_cast</b> is deleted from table ".$prefix."_bbvote_voters <br>";}

mysql_query("DROP TABLE IF EXISTS ".$prefix."_confirm;");
mysql_query("CREATE TABLE ".$prefix."_confirm (
   `confirm_id` char(32) NOT NULL,
   `session_id` char(32) NOT NULL,
   `code` char(6) NOT NULL,
   PRIMARY KEY (session_id, confirm_id)
);");

mysql_query("UPDATE ".$prefix."_config SET  copyright='PHP-Nuke Copyright &copy; 2007 by Francisco Burzi. This is free software, and you may redistribute it under the <a href=\"http://phpnuke.org/files/gpl.txt\"><font class=\"footmsg_l\">GPL</font></a>.<br>Protected by <a href=\"http://www.nukescripts.net\" target=\"_blank\"><img src=\"http://www.nukescripts.net/images/powered/nukesentinel.png\" border=\"0\"><font class=\"footmsg_l\"><b></b></font></a> | Supercharged with <a href=\"http://www.phpnuke-clan.net\" target=\"_blank\"><img src=\"images/powered/pnctechnology.png\" border=\"0\"></a><font class=\"footmsg_l\"><b>|PNC ".$pncv."</b></font></a><br>'");
mysql_query("UPDATE ".$prefix."_config SET  Version_Num='PNC ".$pncv."'");

if (!mysql_table_exists("".$prefix."_pnc_technology")) {echo" <b>".$prefix."_pnc_technology does not exist!!!! </b><br>";}
        else{mysql_query("UPDATE ".$prefix."_pnc_technology SET  value='".$pncv."' WHERE name='versioncheck'") or print('MySQL said: '.mysql_error()); echo" <b>New version is set in table ".$prefix."_pnc_technology</b>: ".$pncv."<br>";}

$query13 = mysql_query("SHOW COLUMNS FROM ".$prefix."_links_categories LIKE 'ldescription'") or print(mysql_error());
                 if (mysql_num_rows($query13) == 0) {echo 'Column <b>ldescription</b> does not exist in table '.$prefix.'_links_categories, that is ok :)<br>';}else {mysql_query("ALTER TABLE ".$prefix."_links_categories DROP ldescription")or print('MySQL said: '.mysql_error());
                echo"Column<b> ldescription</b> is deleted from table ".$prefix."_links_categories <br>";}



if (mysql_table_exists("".$prefix."_mapcat")) {
        echo"Tabel <b>".$prefix."_mapcat </b> already exists<br>";}
        else{mysql_query("CREATE TABLE ".$prefix."_mapcat (
   `id` int(11) NOT NULL auto_increment,
   `title` varchar(100) NOT NULL,
   `details` text NOT NULL,
   `mainid` int(11) DEFAULT '0' NOT NULL,
   `image` varchar(100) NOT NULL,
   PRIMARY KEY (id))")          or print('MySQL said: '.mysql_error());
        echo"Table <b>".$prefix."_mapcat</b> has been created.<br>";}

#
# Dumping data for table '".$prefix."_mapcat'
#


# --------------------------------------------------------
#
# Table structure for table '".$prefix."_mapconfig'
#

if (mysql_table_exists("".$prefix."_mapconfig")) {
        echo"Tabel <b>".$prefix."_mapconfig </b> already exists<br>";}
        else{mysql_query("CREATE TABLE ".$prefix."_mapconfig (
   `mname` varchar(20) NOT NULL,
   `mval` varchar(100) NOT NULL)") or print('MySQL said: '.mysql_error());


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
        echo"Tabel <b>".$prefix."_mapmap </b> already exists<br>";}
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
   KEY cat (cat))") or print('MySQL said: '.mysql_error());
echo"Table <b>".$prefix."_mapmap</b> has been created.<br>";}
#
# Dumping data for table '".$prefix."_mapmap'
#

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
# Table structure for table '".$prefix."_mapreviews'
#

if (mysql_table_exists("".$prefix."_mapreviews")) {
        echo"Tabel <b>".$prefix."_mapreviews </b> already exists<br>";}
        else{mysql_query("CREATE TABLE ".$prefix."_mapreviews (
   `rid` int(11) NOT NULL auto_increment,
   `rmapid` int(11) DEFAULT '0' NOT NULL,
   `ruserid` int(11) DEFAULT '0' NOT NULL,
   `ruserip` varchar(15) NOT NULL,
   `rdate` varchar(20) NOT NULL,
   `review` text NOT NULL,
   `rapprove` int(1) DEFAULT '0' NOT NULL,
   PRIMARY KEY (rid)
)") or print('MySQL said: '.mysql_error());
echo"Table <b>".$prefix."_mapreviews</b> has been created.<br>";}

#
# Dumping data for table '".$prefix."_mapreviews'
#


# --------------------------------------------------------
#
# Table structure for table '".$prefix."_maptemp'
#

if (mysql_table_exists("".$prefix."_maptemp")) {
        echo"Tabel <b>".$prefix."_maptemp </b> already exists<br>";}
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
)") or print('MySQL said: '.mysql_error());
echo"Table <b>".$prefix."_maptemp</b> has been created.<br>";}

#
# Dumping data for table '".$prefix."_maptemp'
#


# --------------------------------------------------------
#
# Table structure for table '".$prefix."_mapvoters'
#

if (mysql_table_exists("".$prefix."_mapvoters")) {
        echo"Tabel <b>".$prefix."_mapvoters </b> already exists<br>";}
        else{mysql_query("CREATE TABLE ".$prefix."_mapvoters (
   `id` int(11) NOT NULL auto_increment,
   `mapid` int(11) DEFAULT '0' NOT NULL,
   `user` varchar(60) NOT NULL,
   PRIMARY KEY (id)
)") or print('MySQL said: '.mysql_error());
echo"Table <b>".$prefix."_mapvoters</b> has been created.<br>";}

#
# Dumping data for table '".$prefix."_mapvoters'
#


# --------------------------------------------------------
#
# Table structure for table '".$prefix."_mapvotes'
#

if (mysql_table_exists("".$prefix."_mapvotes")) {
        echo"Tabel <b>".$prefix."_mapvotes </b> already exists<br>";}
        else{
mysql_query("CREATE TABLE ".$prefix."_mapvotes (
   `vid` int(11) NOT NULL auto_increment,
   `mapid` int(11) DEFAULT '0' NOT NULL,
   `rating` float DEFAULT '0' NOT NULL,
   `totalvotes` int(11) DEFAULT '0' NOT NULL,
   `empty` varchar(111) NOT NULL,
   PRIMARY KEY (vid),
   KEY mapid (mapid)
)") or print('MySQL said: '.mysql_error());
echo"Table <b>".$prefix."_mapvotes</b> has been created.<br>";}

$query14= mysql_query("SHOW COLUMNS FROM ".$prefix."_shoutbox_conf LIKE 'blockxxx'") or print(mysql_error());
                 if (mysql_num_rows($query14) != 0) {echo 'Column <b>blockxxx</b> does already exist in table '.$prefix.'_shoutbox_conf, that is ok :)<br>';}else {mysql_query("ALTER TABLE ".$prefix."_shoutbox_conf ADD blockxxx varchar(5)  DEFAULT '' NOT NULL AFTER serverTimezone")or print('MySQL said: '.mysql_error());
        echo"Column blockxxx is added to table <b>".$prefix."_shoutbox_conf</b><br>";}

mysql_query("DROP TABLE IF EXISTS ".$prefix."_banreq;");
mysql_query("DROP TABLE IF EXISTS ".$prefix."_bbacronyms;");
mysql_query("DROP TABLE IF EXISTS ".$prefix."_bbadmin_nav_module;");
mysql_query("DROP TABLE IF EXISTS ".$prefix."_bbadvanced_username_color;");
mysql_query("DROP TABLE IF EXISTS ".$prefix."_bbarcade;");
mysql_query("DROP TABLE IF EXISTS ".$prefix."_bbarcade_categories;");
mysql_query("DROP TABLE IF EXISTS ".$prefix."_bbarcade_comments;");
mysql_query("DROP TABLE IF EXISTS ".$prefix."_bbarcade_comments;");
mysql_query("DROP TABLE IF EXISTS ".$prefix."_bbarcade_fav;");
mysql_query("DROP TABLE IF EXISTS ".$prefix."_bbattach_quota;");
mysql_query("DROP TABLE IF EXISTS ".$prefix."_bbattachments;");
mysql_query("DROP TABLE IF EXISTS ".$prefix."_bbattachments_config;");
mysql_query("DROP TABLE IF EXISTS ".$prefix."_bbattachments_config;");
mysql_query("DROP TABLE IF EXISTS ".$prefix."_bbattachments_desc;");
mysql_query("DROP TABLE IF EXISTS ".$prefix."_bbauth_arcade_access;");
mysql_query("DROP TABLE IF EXISTS ".$prefix."_bbbuddies;");
mysql_query("DROP TABLE IF EXISTS ".$prefix."_bbcanned;");
mysql_query("DROP TABLE IF EXISTS ".$prefix."_bbcash;");
mysql_query("DROP TABLE IF EXISTS ".$prefix."_bbcash_events;");
mysql_query("DROP TABLE IF EXISTS ".$prefix."_bbcash_exchange;");
mysql_query("DROP TABLE IF EXISTS ".$prefix."_bbcash_exchange;");
mysql_query("DROP TABLE IF EXISTS ".$prefix."_bbcash_groups;");
mysql_query("DROP TABLE IF EXISTS ".$prefix."_bbcash_log;");
mysql_query("DROP TABLE IF EXISTS ".$prefix."_bbconfirm;");
mysql_query("DROP TABLE IF EXISTS ".$prefix."_bbcustom_canned;");
mysql_query("DROP TABLE IF EXISTS ".$prefix."_bbextension_groups;");
mysql_query("DROP TABLE IF EXISTS ".$prefix."_bbextensions;");
mysql_query("DROP TABLE IF EXISTS ".$prefix."_bbforbidden_extensions;");
mysql_query("DROP TABLE IF EXISTS ".$prefix."_bbgamehash;");
mysql_query("DROP TABLE IF EXISTS ".$prefix."_bbgames;");
mysql_query("DROP TABLE IF EXISTS ".$prefix."_bbhackgame;");
mysql_query("DROP TABLE IF EXISTS ".$prefix."_bblogs_config;");
mysql_query("DROP TABLE IF EXISTS ".$prefix."_bbprivmsgs_archive;");
mysql_query("DROP TABLE IF EXISTS ".$prefix."_bbquota_limits;");
mysql_query("DROP TABLE IF EXISTS ".$prefix."_bbreport;");
mysql_query("DROP TABLE IF EXISTS ".$prefix."_bbreport_cat;");
mysql_query("DROP TABLE IF EXISTS ".$prefix."_bbreport_config;");
mysql_query("DROP TABLE IF EXISTS ".$prefix."_bbscores;");
mysql_query("DROP TABLE IF EXISTS ".$prefix."_bbthread_kicker;");
mysql_query("DROP TABLE IF EXISTS ".$prefix."_blocked;");
mysql_query("DROP TABLE IF EXISTS ".$prefix."_blocked_agent;");
mysql_query("DROP TABLE IF EXISTS ".$prefix."_blocked_config;");
mysql_query("DROP TABLE IF EXISTS ".$prefix."_blocked_denymod;");
mysql_query("DROP TABLE IF EXISTS ".$prefix."_blocked_hammer;");
mysql_query("DROP TABLE IF EXISTS ".$prefix."_blocked_iplist;");
mysql_query("DROP TABLE IF EXISTS ".$prefix."_blocked_iptoc;");
mysql_query("DROP TABLE IF EXISTS ".$prefix."nuke_blocked_notes;");
mysql_query("DROP TABLE IF EXISTS ".$prefix."_blocked_pagetracker;");
mysql_query("DROP TABLE IF EXISTS ".$prefix."_blocked_promod;");
mysql_query("DROP TABLE IF EXISTS ".$prefix."_blocked_promodip;");
mysql_query("DROP TABLE IF EXISTS ".$prefix."_blocked_protected;");
mysql_query("DROP TABLE IF EXISTS ".$prefix."_blocked_ref;");
mysql_query("DROP TABLE IF EXISTS ".$prefix."_blocked_reflist;");
mysql_query("DROP TABLE IF EXISTS ".$prefix."_blocked_robot;");
mysql_query("DROP TABLE IF EXISTS ".$prefix."_blocked_settings;");
mysql_query("DROP TABLE IF EXISTS ".$prefix."_shopitems;");
mysql_query("DROP TABLE IF EXISTS ".$prefix."_shops;");


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

<table>         <tr>
<td><?php echo"".$prefix."_hos_config"; ?></td>
                <td>
<?php if(@mysql_query("CREATE TABLE IF NOT EXISTS ".$prefix."_hos_config (
                               `config_name` varchar(50) NOT NULL default '',
                               `config_value` text NOT NULL,
                                PRIMARY KEY  (`config_name`)
                                )TYPE=MyISAM;")) {
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
        <td><?php if ($allgood = false) {
                echo "<font color=#ff0000>Something screwed up.  Review the list of errors above.</font>";
                } else { echo "<br /><span style=\"color:red;font-weight:bold;font-size:14pt;\">You have upgraded to PNC 4.1 successfully. <br /> Don't forget to get the latest version of Sentinel!!! If u did not update to that version before running this file..."; }
                ?></td>
        </tr>
        </table>