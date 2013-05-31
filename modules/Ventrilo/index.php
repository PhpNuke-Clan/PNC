<?php
####################################################################
#  This file is Copyright (c)2006 PNC phpnuke-clan.net             #
#  info@phpnuke-clan.net                                           #
#  Please keep ALL copyright information in here....			   #
####################################################################
# 	Orignial code by: http://www.ventriloservers.biz               #
####################################################################

if ( !defined('MODULE_FILE') )
{
        die("You can't access this file directly...");
}
$module_name = basename(dirname(__FILE__));
require_once("mainfile.php");
require_once("modules/".$module_name."/vent-include.php");

$index = 1;

//define('INDEX_FILE', true);// true=show right blocks, false=hide right blocks (only if u use patched 3.1)
$stat = new CVentriloStatus;
global $cookie, $prefix, $multilingual, $currentlang, $db;

$row = $db->sql_fetchrow($db->sql_query("SELECT * FROM ".$prefix."_ventrilo"));

$ventip =  $row['ventip'];  // Ventrilo Server hostname/IP.
$ventport = $row['ventport'];  // Port to be statused.
$ventpass = $row['ventpass']; // Status password if necessary.
$servername = $row['servername']; // Name of your vent server no spaces. ie "MY-VENT-SERVER"
// Enable the connect to link//
$enable_link = $row['enablelink'];  // 1 = Show connection Link, 0 = Do not show connection link.
//Enable comments in ventrilo Module.
$enable_comm2 = $row['enablecomm2'];  /// 1 = Show Comments in Module, 0 = Do not show comments in Module.
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
$blockoption = 0;        // 1 = Show Comments in Block, 0 = Do not show comments in Block.
$moduleoption = "$enable_comm2";        // 1 = Show Comments in Module, 0 = Do not show comments in Module.
$comment_check = 0;        // switch
$srvdb = $server;
//***************************************************************************************************************
//***************************************************************************************************************


include('header.php');
OpenTable();
echo "<table width=\"100%\" border=\"0\">\n";
echo "<tr><td><div align=\"center\"><img src=\"modules/".$module_name."/images/vent_banner.gif\" alt=\"www.ventrilo.com\" border=\"0\"></div></td></tr>\n";
echo "</table>";
$rc = $stat->Request();
if ( $rc )
{
		echo "<table width=\"100%\" border=\"0\"><tr><td align=\"center\" valign=\"center\" bgcolor=\"#FF8888\">";
		echo "<br>CVentriloStatus->Request() failed. <strong>$stat->m_error</strong><br><br>\n";
		echo "</td></tr></table>";
}

//Display Server Info:
echo "<br>\n";
echo "<center><table width=\"60%\" border=\"1\">\n";

VentriloInfoEX1( $stat, $name, 0, 0 );

echo "</table></center><br>";

//Display Channels and People Online:
//echo "<br>\n";
echo "<center><table width=\"95%\" border=\"0\">\n";
if (!$stat->m_cmdpass) {
$weblink = "ventrilo://$stat->m_cmdhost:$stat->m_cmdport/servername=$stat->m_name";
} else {
$weblink = "ventrilo://$stat->m_cmdhost:$stat->m_cmdport/servername=$stat->m_name&serverpassword=$stat->m_cmdpass";
}
//echo"<tr><td><div align=\"center\"><img src=\"modules/".$module_name."/images/ventrilo.gif\" alt=\"Ventrilo Servers by VentriloServers.biz\" border=\"0\"></div></td></tr>\n";
if ($connectoption == 1) {
//echo"<tr><td><div align=\"center\"><a href=\"$weblink\">[Connect to this server]</a></div></td></tr>\n";
echo"<tr><td><div align=\"center\"><form method=\"post\" action=\"$weblink\">"
."\n<br>"
."<center><input style=\"font-family : tahoma, verdana;font-size : 8pt;\" type=\"submit\" name=\"setventrilo\" value=\"  Connect to Server  \"></center>"
."</form>";
}
$name2 = "$stat->m_name";

VentriloDisplayEX3( $stat, $name2, 0, 0, $blockoption, $moduleoption, $comment_check);
echo "</td>";
echo "</tr>";
echo "</table>";

echo"<tr><td><div align=\"center\"></div></td></tr>\n";
echo "</table></center>\n";
CloseTable();
include('footer.php');
?>