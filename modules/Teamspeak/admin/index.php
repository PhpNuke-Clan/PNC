<?php
//***************************************************************************
/* Teamspeak database               */
/* Version: 1.00                         */
/* Author: XenoMorpH �T�I� (aarvuijk@hotmail.com)  */
/* Made for PNC phpnuke-clan.net        */
//***************************************************************************
if ( !defined('ADMIN_FILE') )
{
        die ("Access Denied");
}
global $prefix, $db, $admin_file;

$aid = substr("$aid", 0,25);
$row = $db->sql_fetchrow($db->sql_query("SELECT title, admins FROM ".$prefix."_modules WHERE title='Teamspeak'"));
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

                $db->sql_query("CREATE TABLE IF NOT EXISTS $prefix"._teamspeak." 
                (tsip varchar(100) NOT NULL default '', 
                tsport varchar(100) NOT NULL default '', 
                tsqport varchar(50) NOT NULL default '',  
                adminname varchar(255) NOT NULL default '', 
                tsaway varchar(50) NOT NULL default '',
                tsrule1 varchar(255) NOT NULL default '', 
                tsrule2 varchar(255) NOT NULL default '', 
                tsrule3 varchar(255) NOT NULL default ''
        ) TYPE=MyISAM;");


$sql9 = "SELECT * FROM ".$prefix."_teamspeak";
$bla = $db->sql_query($sql9); 
if($db->sql_numrows($bla)==0) 
{
$sql2 = "INSERT INTO $prefix"._teamspeak." VALUES ('IP/url', '8767', '51234', 'Server Adminname','Away','Server Rule 1','Server Rule 2','Server Rule 3')";

if(!$db->sql_query($sql2)){  //voer query uit
echo "Can't run Query!!!";
}else{
//$id = mysql_insert_id(); 
  print "Teamspeak tables have been added to the database.";
        }
}

if($idup==1 && $setTeamspeak){
$sql = "UPDATE ".$prefix."_teamspeak SET tsip='$tsipv', tsport='$tsportv', tsqport='$tsqportv', adminname='$adminnamev', tsaway='$tsawayv',tsrule1='$tsrule1v', tsrule2='$tsrule2v', tsrule3='$tsrule3v'";

 if(!$db->sql_query($sql)){  //voer query uit
echo "Can't run Query!!!";
}else{
$updated= "Teamspeak server is inserted!!!!";
//$new_id = mysql_insert_id(); 
//  print "New id: $new_id\n";
Header("Location: $admin_file.php?op=teamspeak&updated=$updated"); 
}


}


else{
OpenTable();
//$datum1= date("Y-m-j H:i:s"); 
$datum1= time();
 //ADD FUNCTION//       
$row = $db->sql_fetchrow($db->sql_query("SELECT * FROM ".$prefix."_teamspeak"));
$tsip =  $row['tsip'];  // tsrilo Server hostname/IP.
$tsport = $row['tsport'];  // Port to be statused.
$tsqport = $row['tsqport']; // Status password if necessary.
$adminname = $row['adminname']; // Name of your vent server no spaces. ie "MY-VENT-SERVER"
$tsaway = $row['tsaway'];
$tsrule1 = $row['tsrule1']; 
$tsrule2 = $row['tsrule2']; 
$tsrule3 = $row['tsrule3']; 
// Enable the connect to link//
$enable_link = $row['enablelink'];  // "0" off "1" on//
echo"$updated";
echo"<form method=\"post\" action=\"$admin_file.php?op=teamspeak\">";
echo"<table border =1>"
."<tr><td>Teamspeak Server IP/url: </td><td><input type=\"text\" name=\"tsipv\" value=\"$tsip\">&nbsp;(Can be either an IP or url)</td></tr>"
."<tr><td>Teamspeak ServerUDPPort: </td><td><input type=\"text\" name=\"tsportv\" value=\"$tsport\">&nbsp;(default 8767)</td></tr>"
."<tr><td>Teamspeak serverQueryPort: </td><td><input type=\"text\" name=\"tsqportv\" value=\"$tsqport\">&nbsp;(default 51234, must be accessible and usable. check server.ini)</td></tr>\n"
."<tr><td>Teamspeak Server Adminname: </td><td><input type=\"text\" name=\"adminnamev\" value=\"$adminname\">&nbsp;(TeamSpeak Admin name)</td></tr>\n"
."<tr><td>Teamspeak Away Channel: </td><td><input type=\"text\" name=\"tsawayv\" value=\"$tsaway\">&nbsp;(If you have a channel that is used for users that are away from there keyboard. If not leave blank.)</td></tr>\n"
."<tr><td>Server Rule 1: </td><td><input type=\"text\" name=\"tsrule1v\" value=\"$tsrule1\">&nbsp;(Rule 1 of your teamspeak. If not leave blank.)</td></tr>\n"
."<tr><td>Server Rule 2: </td><td><input type=\"text\" name=\"tsrule2v\" value=\"$tsrule2\">&nbsp;(Rule 2 of your teamspeak. If not leave blank.)</td></tr>\n"
."<tr><td>Server Rule 3: </td><td><input type=\"text\" name=\"tsrule3v\" value=\"$tsrule3\">&nbsp;(Rule 3 of your teamspeak. If not leave blank.)</td></tr>\n";
echo "<input type=\"hidden\" name=\"idup\" value=\"1\">";
echo"</table>\n"
."<input style=\"font-family : tahoma, verdana;font-size : 8pt;\" type=\"submit\" name=\"setTeamspeak\" value=\"Edit\">"
."</form><br><br>";
//FORM END
        }
                echo"<table width=\"100%\"><tr><td align=right><a href=\"http://www.phpnuke-clan.net\" target=_blank>&copy;PNC</a></td></tr></table>"; 
CloseTable();
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
