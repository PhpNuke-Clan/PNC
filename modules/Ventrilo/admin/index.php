<?php
//***************************************************************************
/* Ventrilo database               */
/* Version: 2.00                         */
/* Author: XenoMorpH ¤TÐI¤ (aarvuijk@hotmail.com)  */
/* Made for PNC phpnuke-clan.com	*/
//***************************************************************************
global $prefix, $db, $admin_file;
if (!defined('ADMIN_FILE')) { die ("Access Denied"); }
$module_name ="Ventrilo";
$aid = substr("$aid", 0,25);
$row = $db->sql_fetchrow($db->sql_query("SELECT title, admins FROM ".$prefix."_modules WHERE title='Ventrilo'"));
$row2 = $db->sql_fetchrow($db->sql_query("SELECT name, radminsuper FROM ".$prefix."_authors WHERE aid='$aid'"));
$admins = explode(",", $row['admins']);
$auth_user = 0;
for ($i=0; $i < sizeof($admins); $i++) {
    if ($row2['name'] == "$admins[$i]" AND $row['admins'] != "") {
        $auth_user = 1;
    }
}

if ($row2['radminsuper'] == 1 || $auth_user == 1) {

include("header.php");

	GraphicAdmin();

		sql_query("CREATE TABLE IF NOT EXISTS $prefix"._ventrilo."
		(ventip varchar(100) NOT NULL default '',
		ventport varchar(100) NOT NULL default '',
		ventpass varchar(50) NOT NULL default '',
		servername varchar(255) NOT NULL default '',
		enablelink int(1) NOT NULL default '0',
		enablelogin int(1) NOT NULL default '0',
        enablecomm1 int(1) NOT NULL default '0',
		enablecomm2 int(1) NOT NULL default '0',
		download varchar(255) NOT NULL default '',
		server char(1) NOT NULL default '1'
	) TYPE=MyISAM;", $dbi);



$sql9 = "SELECT * FROM ".$prefix."_ventrilo";
$bla = $db->sql_query($sql9);
if($db->sql_numrows($bla)==0)
{
$sql2 = "INSERT INTO $prefix"._ventrilo." VALUES ('', '', '', '','1','0','0','1','www.ventrilo.com/download.php','1')";

if(!mysql_query($sql2)){  //voer query uit
echo "Can't run Query!!!";
}else{
$id = mysql_insert_id();
  OpenTable();
  echo "<table width=\"100%\" border=\"0\"><tr><td align=\"center\" valign=\"middle\">VENTRILO TABLES HAVE BEEN ADDED TO THE DATABASE.</td></tr></table>";
  CloseTable();
	}
}

if($idup==1 && $setventrilo){
$sql = "UPDATE ".$prefix."_ventrilo SET ventip='$ventipv', ventport='$ventportv', ventpass='$ventpassv', servername='$servernamev', enablelink='$enablelinkv', enablelogin='$enableloginv', enablecomm1='$enablecomm1v', enablecomm2='$enablecomm2v', download='$downloadv', server='$serverv'";

 if(!mysql_query($sql)){  //voer query uit
     OpenTable();
     echo "<table width=\"100%\" border=\"0\"><tr><td align=\"center\" valign=\"middle\">CAN'T RUN QUERY!!!</td></tr></table>";
     CloseTable();
  }
     else{
        $new_id = mysql_insert_id();
      //print "New id: $new_id\n";

        Header("Location: $admin_file.php?op=ventrilo");
     }
}

else{
define('ADMIN_FILE', true);
require_once("modules/".$module_name."/vent-include.php");

OpenTable();
$stat = new CVentriloStatus;
global $cookie, $prefix, $multilingual, $currentlang, $db;
//$datum1= date("Y-m-j H:i:s");
$datum1= time();

//ADD FUNCTION//

$row = $db->sql_fetchrow($db->sql_query("SELECT * FROM ".$prefix."_ventrilo"));

$ventip =  $row['ventip'];  // Ventrilo Server hostname/IP.
$ventport = $row['ventport'];  // Port to be statused.
$ventpass = $row['ventpass']; // Status password if necessary.
$servername = $row['servername']; // Name of your vent server no spaces. ie "MY-VENT-SERVER"
//Enable the connect to link and login
$enable_link = $row['enablelink'];  // 1 = Show connection Link, 0 = Do not show connection link.
$enable_login = $row['enablelogin'];  // 1 = Show Login Area, 0 = Do not show Login area.
//Enable Comments in Blocks and Module
$enable_comm1 = $row['enablecomm1'];  // 1 = Show Comments in Block, 0 = Do not show comments in Block.
$enable_comm2 = $row['enablecomm2'];  // 1 = Show Comments in Module, 0 = Do not show comments in Module.
//Enable Download Location
$download_path = $row['download'];  // Show Download and Location.
$server = $row['server'];  // 1 = Server1, 2 = server2, 3 = server3

//***************************************************************************************************************
//***************************************************************************************************************
$stat->m_cmdcode   = "2";         // Detail mode. 1=General, 2=Detailed
$stat->m_cmdhost   = "$ventip";           // Hostname or IP address of target machine running the Ventrilo server.
$stat->m_cmdport   = "$ventport";      // Port to be statused.
$stat->m_cmdpass   = "$ventpass";           // Server password if necessary.
$stat->m_name       = "$servername";   // Server name.
$connectoption = "$enable_link";      // 1 = Show Connection Link, 0 = Do not show connection link.
$loginoption = "$enable_login";      // 1 = Show Login Area, 0 = Do not show Login area.
$blockoption = "$enable_comm1";        // 1 = Show Comments in Block, 0 = Do not show comments in Block.
$moduleoption = "$enable_comm2";        // 1 = Show Comments in Module, 0 = Do not show comments in Module.
$downloadoption = "$download_path";    // Location of Ventrilo download.
$comment_check = 2;        // switch
$srvdb = $server;

//***************************************************************************************************************
//***************************************************************************************************************

//start script
echo"<center>This module <font color = red>requires</font> that your web server and hosting company allow outbound TCP requests to a destination port of <font color = red><b>5100!!!</b></font></center><br>"
."<form method=\"post\" action=\"$admin_file.php?op=ventrilo\">"
."<center><table border =0><tr><td><table border =1 width=\"100%\">"
."<colgroup span=1>"
."<col width=105></col>"
."</colgroup>"
."<tr><td><strong>Ventrilo Server IP/url:</strong></td><td><input type=\"text\" name=\"ventipv\" value=\"$ventip\">&nbsp;(Can be either an IP or url.)</td></tr>"
."<tr><td><strong>Ventrilo Server Port:</strong></td><td><input type=\"text\" name=\"ventportv\" value=\"$ventport\">&nbsp;(Default is 3784.)</td></tr>"
."<tr><td><strong>Ventrilo Password:</strong></td><td><input type=\"text\" name=\"ventpassv\" value=\"$ventpass\">&nbsp;(Leave blank if not needed.)</td></tr>"
."<tr><td><strong>Ventrilo Servername:</strong></td><td><input type=\"text\" name=\"servernamev\" value=\"$servername\">&nbsp;(Optional)</td></tr>"
."</table>";

echo"<br><table border =1 width=\"100%\"><colgroup span=1><col width=105></col></colgroup><tr><td><strong>Ventrilo Check Server:</strong></td><td>";
if($server ==0 ){$ck1 = "SELECTED"; $ck2 = ""; $ck3 = "";}
elseif($server == 1 ) { $ck1 = ""; $ck2 = "SELECTED"; $ck3 = "";}
else { $ck1 = ""; $ck2 = ""; $ck3 = "SELECTED"; }
       echo "<select name=serverv>\n"
			."<option value=\"0\" $ck1>Vetrilo-Server 1</option>"
			."<option value=\"1\" $ck2>Vetrilo-Server 2</option>\n"
			."<option value=\"2\" $ck3>Vetrilo-Server 3</option>\n"
			."</select>\n"
			."(Choose which server you want the script to use to check the status.)</td></tr></table>";

echo "<br><table border =1 width=\"100%\"><colgroup span=1><col width=105></col></colgroup><tr><td><strong>Download Path:</strong></td><td><input type=\"text\" name=\"downloadv\" value=\"$download_path\">&nbsp;(Leave blank to disable. ex. www.example.com)</td></tr>\n"
."</table>";

if($enable_link == 1){$ck1 = "checked"; $ck2 = ""; } else { $ck1 = ""; $ck2 = "checked"; }
echo"<br><table border =1 width=\"100%\"><colgroup span=1><col width=105></col></colgroup><tr><td><strong>Enable Join Link:</strong></td><td>
        <label><input type=\"radio\" name=\"enablelinkv\" value=\"1\" ".$ck1.">yes</label>
        <label><input type=\"radio\" name=\"enablelinkv\" value=\"0\" ".$ck2.">no</label>
        (Choose whether you want to enable join now link.)</td></tr>";

if($enable_login == 1 ){$ck1 = "checked"; $ck2 = ""; } else { $ck1 = ""; $ck2 = "checked"; }
echo"<tr><td><strong>Enable Login:</strong></td><td>
        <label><input type=\"radio\" name=\"enableloginv\" value=\"1\" ".$ck1.">yes</label>
        <label><input type=\"radio\" name=\"enableloginv\" value=\"0\" ".$ck2.">no</label>
        (Choose whether you want to enable the user login option.)</td></tr></table>";

if($enable_comm1 == 1 ){$ck1 = "checked"; $ck2 = ""; } else { $ck1 = ""; $ck2 = "checked"; }
echo"<br><table border =1 width=\"100%\"><colgroup span=1><col width=105></col></colgroup><tr><td><strong>Block Comments:</strong></td><td>
        <label><input type=\"radio\" name=\"enablecomm1v\" value=\"1\" ".$ck1.">yes</label>
        <label><input type=\"radio\" name=\"enablecomm1v\" value=\"0\" ".$ck2.">no</label>
        (Choose whether you want to enable the user comments in the ventrilo block.)</td></tr>";

if($enable_comm2 == 1 ){$ck1 = "checked"; $ck2 = ""; } else { $ck1 = ""; $ck2 = "checked"; }
echo"<tr><td><strong>Module Comments:</strong></td><td>
        <label><input type=\"radio\" name=\"enablecomm2v\" value=\"1\" ".$ck1.">yes</label>
        <label><input type=\"radio\" name=\"enablecomm2v\" value=\"0\" ".$ck2.">no</label>
        (Choose whether you want to enable the user comments in the ventrilo module.)</td></tr>";

echo "<input type=\"hidden\" name=\"idup\" value=\"1\">";
//	echo"<tr><td></td><td><input style=\"font-family : tahoma, verdana;font-size : 8pt;\" type=\"submit\" name=\"setventrilo\" value=\"Edit\"></td></tr>\n";
echo"</table></table></center><br>"
."<center><input style=\"font-family : tahoma, verdana;font-size : 8pt;\" type=\"submit\" name=\"setventrilo\" value=\"  Save Changes  \"></center>"
."</form>";
//FORM END


	}

//Server Check:
$rc = $stat->Request();
if ( $rc )
{
	echo "<table width=\"100%\" border=\"0\"><tr><td align=\"center\" valign=\"middle\" bgcolor=\"#FF8888\">
	      <br>CVentriloStatus->Request() failed. <strong>$stat->m_error</strong><BR><BR>
              <tr><td align=\"center\" valign=\"middle\">Check your setting above and make sure your Web Host "
              ."allows outbond TCP request to a destination port of 5100.  If they ask for a destination IPs give them these "
              ."status1.ventrilo.com = 70.87.75.147, status2.ventrilo.com = 69.93.187.82, status3.ventrilo.com = 69.93.169.58."
              ."</font></td></tr><BR><BR>
              </td></tr></table><BR><BR><BR><BR>";
}

if ( !$rc )
{
//Display Users:
echo "<br>\n";
echo "<center><table width=\"80%\" border=\"1\">\n";
VentriloInfoEX4( $stat );
echo "</table></center><br>";

//Display Server Info:
echo "<br>\n";
echo "<center><table width=\"60%\" border=\"1\">\n";
VentriloInfoEX1( $stat, $name, 0, 0 );
echo "</table></center><br>";

//Display Channels and People Online:
//echo "<br>\n";
echo "<center><table width=\"95%\" border=\"0\">";
if (!$stat->m_cmdpass) {
$weblink = "ventrilo://$stat->m_cmdhost:$stat->m_cmdport/servername=$stat->m_name";
} else {
$weblink = "ventrilo://$stat->m_cmdhost:$stat->m_cmdport/servername=$stat->m_name&serverpassword=$stat->m_cmdpass";
}
//echo"<tr><td><div align=\"center\"><img src=\"modules/".$module_name."/images/ventrilo.gif\" alt=\"Ventrilo Servers by VentriloServers.biz\" border=\"0\"></div></td></tr>\n";
if ($connectoption == 1) {
//echo"<tr><td><div align=\"center\"><a href=\"$weblink\">[Connect to this server]</a></div></td></tr>\n";
echo"<tr><td><div align=\"center\"><form method=\"post\" action=\"$weblink\">";
echo"\n<br>"
."<center><input style=\"font-family : tahoma, verdana;font-size : 8pt;\" type=\"submit\" name=\"setventrilo\" value=\"  Connect to Server  \"></center>"
."</form>";
}
$name2 = "$stat->m_name";

VentriloDisplayEX3( $stat, $name2, 0, 0, $blockoption, $moduleoption, $comment_check);
echo "</td>";
echo "</tr>";
echo "</table>";

echo "</div></td></tr></table></center>\n";
}
CloseTable();
	vent_copy();
include("footer.php");
}





//=================================================================================================


//}
 else {
	include("header.php");
	GraphicAdmin();
	OpenTable();
	echo "<center><b>"._ERROR."</b><br><br>You do not have administration permission for module \"$module_name\"</center>";
	CloseTable();
	include("footer.php");
}

?>
