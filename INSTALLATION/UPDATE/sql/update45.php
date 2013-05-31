<?php
if( !defined('PNC_UPD')){
	die("Access denied!");
}
//***************************************************************************
/* Author: XenoMorpH ¤TÐI¤ (aarvuijk@hotmail.com)                           */
/* Development Assistance: CrazyCrack (support@phpnuke-clan.com)            */
//***************************************************************************

//UPDATE PHPBB VERSION
	mysql_query("UPDATE ".$prefix."_bbconfig SET config_value='.0.23' where config_name='version'") or die('MySQL said: '.mysql_error());

	echo'<font color=#009900>success</font>
			</td>
		</tr>
		<tr>
			<td>'.$prefix.'_pnc_technology</td>
			<td>';

//UPDATE PNC VERSION
$exists = mysql_query("SELECT 1 FROM ".$prefix."_pnc_technology LIMIT 0");
if(!$exists) {
	echo"<font color=#FF0000>Table ".$prefix."_pnc_technology doesn't exist. ARE YOU SURE YOU ARE UPGRADING FROM A VERSION OF PNC???.</font>";
} else {
	mysql_query("UPDATE ".$prefix."_pnc_technology SET  value='".$pncv."' WHERE name='versioncheck'") or die('MySQL said: '.mysql_error());
	mysql_query("UPDATE ".$prefix."_config SET Version_Num='".$pncv."'") or die('MySQL said: '.mysql_error());
	mysql_query("UPDATE ".$prefix."_config SET  copyright='PHP-Nuke Copyright &copy; 2007 by Francisco Burzi. This is free software, and you may redistribute it under the <a href=\"http://phpnuke.org/files/gpl.txt\"><font class=\"footmsg_l\">GPL</font></a>.<br>Protected by <a href=\"http://www.nukescripts.net\" target=\"_blank\"><img src=\"http://www.nukescripts.net/images/powered/nukesentinel.png\" border=\"0\"><font class=\"footmsg_l\"><b></b></font></a>|Powered by <a href=\"http://www.phpnuke-clan.net\" target=\"_blank\"><img src=\"images/powered/pnctechnology.gif\" border=\"0\"></a><font class=\"footmsg_l\"><b>|PNC ".$pncv. "</b></font></a><br>'");

	echo'<font color=#009900>success</font>';
}

echo '		</td>
		</tr>';

echo '	<tr>
			<td>'.$prefix.'_lgsl</td>
			<td>';

//Install LGSL
	mysql_query("DROP TABLE IF EXISTS ".$prefix."_lgsl;") or die('MySQL said: '.mysql_error());
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
	) TYPE=MyISAM CHARSET=utf8 COLLATE=utf8_unicode_ci;") or die('MySQL said: '.mysql_error());

	echo'<font color=#009900>success</font>
				</td>
			</tr>';


	echo '	<tr>
				<td>Update Forum Template</td>
			<td>';

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

echo'<font color=#009900>success</font>
			</td>
		</tr>';


	echo '	<tr>
				<td>Alter bbgroups Table</td>
			<td>';

$bbgroupSQL1 = "SELECT INDEX_NAME FROM INFORMATION_SCHEMA.STATISTICS
WHERE TABLE_NAME = 'pnc_bbuser_group' AND COLUMN_NAME = 'user_id' ";
$bbgroupSQL2 = "SELECT INDEX_NAME FROM INFORMATION_SCHEMA.STATISTICS
WHERE TABLE_NAME = 'pnc_bbuser_group' AND COLUMN_NAME = 'group_id' ";
$bbgroupSQL3 = "SELECT INDEX_NAME FROM INFORMATION_SCHEMA.STATISTICS
WHERE TABLE_NAME = 'pnc_bbuser_group' AND COLUMN_NAME = 'user_id' ";
$bbgroupROW1 = mysql_fetch_row(mysql_query($bbgroupSQL1));
$BBgroupRESULT1 = $bbgroupROW1[0];
if(!$BBgroupRESULT1 == "PRIMARY"){
mysql_query("ALTER TABLE ".$prefix."_bbuser_group DROP INDEX user_id")or die('MySQL said: '.mysql_error());
}
$bbgroupROW2 = mysql_fetch_row(mysql_query($bbgroupSQL2));
$BBgroupRESULT2 = $bbgroupROW2[0];
if(!$BBgroupRESULT2 == "PRIMARY"){
mysql_query("ALTER TABLE ".$prefix."_bbuser_group DROP INDEX group_id")or die('MySQL said: '.mysql_error());
}
$bbgroupROW3 = mysql_fetch_row(mysql_query($bbgroupSQL3));
$BBgroupRESULT3 = $bbgroupROW3[0];
if(!$BBgroupRESULT3== "PRIMARY"){
mysql_query("ALTER TABLE ".$prefix."_bbuser_group ADD PRIMARY KEY (group_id, user_id)")or die('MySQL said: '.mysql_error());
}

	echo'<font color=#009900>success</font>
			</td>
		</tr>';


#
# Require files needed for vWar number "$n"
#
require_once("../modules/vwar/includes/_config.inc.php");

#
# Altering "vwar".$n."_acpmenugroups"
#
echo '	<tr>
			<td>vwar'.$n.'_acpmenugroups</td>
			<td>';

$exists = mysql_query("SELECT 1 FROM vwar".$n."_acpmenugroups LIMIT 0");
if(!$exists)
{
	echo"Table <b>vwar".$n."_acpmenugroups</b> doesn't exist, that's ok :)<br \>";
}
else {

$vWarSQL1 = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMS
WHERE TABLE_NAME = vwar".$n."_acpmenugroups AND COLUMN_NAME = 'condition' ";
$vWarResult1 = mysql_num_rows(mysql_query($vWarSQL1));
if($vWarResult1 > 0){
	mysql_query("ALTER TABLE vwar".$n."_acpmenugroups CHANGE `condition` cond text NOT NULL")or die('MySQL said: '.mysql_error());
}

$vWarSQL2 = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMS
WHERE TABLE_NAME = vwar".$n."_acpmenugroups AND COLUMN_NAME = 'conditiontype' ";
$vWarResult2 = mysql_num_rows(mysql_query($vWarSQL2));
if($vWarResult2 > 0){
	mysql_query("ALTER TABLE vwar".$n."_acpmenugroups CHANGE `conditiontype` condtype  enum('OR','AND') NOT NULL default 'OR'")or die('MySQL said: '.mysql_error());
}

}
	echo'<font color=#009900>success</font>
			</td>
		</tr>';

#
# Altering "vwar".$n."_acpmenuitems"
#
echo '	<tr>
			<td>vwar'.$n.'_acpmenuitems</td>
			<td>';

$exists = mysql_query("SELECT 1 FROM vwar".$n."_acpmenuitems LIMIT 0");
if(!$exists)
{
	echo"Table <b>vwar".$n."_acpmenuitems</b> doesn't exist, that's ok :)<br \>";
}
else {
	$vWarSQL1 = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMS
	WHERE TABLE_NAME = vwar".$n."_acpmenuitems AND COLUMN_NAME = 'condition' ";
	$vWarResult1 = mysql_num_rows(mysql_query($vWarSQL1));
	if($vWarResult1 > 0){
		mysql_query("ALTER TABLE vwar".$n."_acpmenuitems CHANGE `condition` cond text NOT NULL")or die('MySQL said: '.mysql_error());
	}

	$vWarSQL2 = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMS
	WHERE TABLE_NAME = vwar".$n."_acpmenuitems AND COLUMN_NAME = 'conditiontype' ";
	$vWarResult2 = mysql_num_rows(mysql_query($vWarSQL2));
	if($vWarResult2 > 0){
		mysql_query("ALTER TABLE vwar".$n."_acpmenuitems CHANGE `conditiontype` condtype  enum('OR','AND') NOT NULL default 'OR'")or die('MySQL said: '.mysql_error());
	}

	}
		echo'<font color=#009900>success</font>
				</td>
			</tr>';

echo '	<tr>
			<td><b>Installer Results:</b></td>
			<td>';
if ($allgood = false) {
	echo '<font color=#ff0000>Something screwed up.  Review the list of errors above.</font>';
} else {
	echo '<font color=#009900>Successful.  For your security you should delete the UPDATE folder and all files in it now.</font>';
}

echo '		</td>
        </tr>
      </table>';
?>