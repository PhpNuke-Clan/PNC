<?php
####################################################################
#  This file is Copyright (c)2007 PNC phpnuke-clan.net             #
#  info@phpnuke-clan.net                                           #
#  Please keep ALL copyright information in here....			   #
####################################################################
# 	Orignial code by: http://www.ventriloservers.biz               #
####################################################################
	if ( !defined('VENT_BL') ) {
        die("You can't access this file directly...");
}
$module_name = "Ventrilo";
require_once("mainfile.php");
define('ADMIN_FILE', true);
define('MODULE_FILE', true);
require_once("modules/".$module_name."/vent-include.php");

global $user, $cookie, $prefix, $db, $user_prefix;

cookiedecode($user);
if (is_user($user))
{
    $uname = $cookie[1];
    $guest = 0;
}


//define('INDEX_FILE', true);// true=show right blocks, false=hide right blocks (only if u use patched 3.1)
$stat = new CVentriloStatus;
global $cookie, $prefix, $multilingual, $currentlang, $db;

$row = $db->sql_fetchrow($db->sql_query("SELECT * FROM ".$prefix."_ventrilo"));

$ventip =  $row['ventip'];  // Ventrilo Server hostname/IP.
$ventport = $row['ventport'];  // Port to be statused.
$ventpass = $row['ventpass']; // Status password if necessary.
$servername = $row['servername']; // Name of your vent server no spaces. ie "MY-VENT-SERVER"
//Enable the connect to link and login
$enable_link = $row['enablelink'];  // // 1 = Show connection Link, 0 = Do not show connection link.
$enable_login = $row['enablelogin'];  // 1 = Show Login Area, 0 = Do not show Login area.
//Enable comments in the ventrilo block.
$enable_comm1 = $row['enablecomm1'];  // 1 = Show Comments in the Module, 0 = Do not show comments in the Module.
//Enable Download Location
$download_path = $row['download'];  // Show Download and Location.
$server = $row['server'];  // 1 = Server1, 2 = server2, 3 = server3
//Change here only
//***************************************************************************************************************
//***************************************************************************************************************
$stat->m_cmdcode   = "2";         // Detail mode. 1=General, 2=Detailed
$stat->m_cmdhost   = "$ventip";           // Hostname or IP address of target machine running the Ventrilo server.
$stat->m_cmdport   = "$ventport";      // Port to be statused.
$stat->m_cmdpass   = "$ventpass";           // Server password if necessary.
$stat->m_name       = "$servername";   // Server name.
$connectoption = "$enable_link";      // 1 = Show connection Link, 0 = Do not show connection link.
$blockoption = "$enable_comm1";        // 1 = Show Comments in Block, 0 = Do not show comments in Block.
$moduleoption = 0;         // 1 = Show Comments in the Module, 0 = Do not show comments in the Module.
$comment_check = 1;        // switch
$srvdb = $server;
//***************************************************************************************************************
//***************************************************************************************************************

$rc = $stat->Request();
if ( $rc )
{
		//echo "<table width=\"100%\" border=\"0\"><tr><td align=\"center\" valign=\"center\" bgcolor=\"#FF8888\">";
		//echo "<br>CVentriloStatus->Request() failed. <strong>$stat->m_error</strong><br><br>\n";
		echo "<table width=\"100%\" border=\"0\"><tr><td align=\"center\" valign=\"center\">";
                echo "<div align=\"center\"><img src=\"modules/".$module_name."/images/offline.gif\" width=\"100\" height=\"22\" border=\"0\" align=\"middle\"></div>\n";
                echo "</td></tr></table>";
}

if ( !$rc )
{
echo "<br>\n";
echo "<center><table width=\"100%\" border=\"0\">\n";
echo "<tr><td><div align=\"center\"><img src=\"modules/".$module_name."/images/online.gif\" width=\"100\" height=\"22\" border=\"0\" align=\"middle\"></div></td></tr>\n";

if (!$stat->m_cmdpass) {
$weblink = "ventrilo://$stat->m_cmdhost:$stat->m_cmdport/servername=$stat->m_name";
} else {
$weblink = "ventrilo://$stat->m_cmdhost:$stat->m_cmdport/servername=$stat->m_name&serverpassword=$stat->m_cmdpass";
}
//echo"<tr><td><div align=\"center\"><img src=\"modules/".$module_name."/images/ventrilo.gif\" alt=\"Ventrilo\" border=\"0\"></div></td></tr>\n";
if ($connectoption == 1) {
//echo"<tr><td><div align=\"center\"><a href=\"$weblink\">Connect</a></div></td></tr>\n";
echo"<tr><td align=\"center\"><div><form method=\"post\" action=\"$weblink\">\n"
."<input style=\"font-family : tahoma, verdana;font-size : 8pt;\" type=\"submit\" name=\"setventrilo\" value=\" Connect \">\n"
."</td></tr></form>\n";
}
echo "<tr><td><div align=\"center\"><a href=\"modules.php?name=".$module_name."\">Details</a></div></td></tr>\n";
if ( $download_path != "")
   echo "<tr><td><div align=\"center\"><a href=\"http://".$download_path."\" target=\"_blank\">Download</a></div></td></tr>\n";
$name2 = "$stat->m_name";

VentriloDisplayEX3( $stat, $name2, 0, 0, $blockoption, $moduleoption, $comment_check);

echo "</table></center>\n";

//Display Login:
if ( $enable_login != "0" )
{
   echo "<hr><center><table width=\"100%\" border=\"0\">";
   VentriloInfoEX5( $stat, $weblink );
   echo "</table></center>";
}
}
//COPYRIGHT Won't show when logged as a member..it will only show the copyright to guests
if($uname==""){
vent_blcopy();
}
?>