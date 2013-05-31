<?php

/********************************************************/
/* Hall of Shame                                     	*/
/* By: Troy Moore (Duck@mrc.clanservers.com)			*/
/* http://mrc.clanservers.com                           */
/* Copyright © 2006-2011 by JesStep Enterprises         */
/********************************************************/
/* Hall of Shame                                        */
/* For PHP-Nuke 6.5+                                    */
/* By Troy Moore - http://mrc.clanservers.com        	*/
/********************************************************/


if ( !defined('ADMIN_FILE') ) {
	die("Illegal Admin File Access");
}


$pagetitle = " - "._HoS_HALLOFSHAME.": "._HoS_ADDPUNK;
@include("header.php");
adminheader(_HoS_HALLOFSHAME.": "._HoS_ADDPUNK);
$memid = stripslashes($hos_config['mid']);
$memtbl = stripslashes($hos_config['membertable']);
$memname = stripslashes($hos_config['membername']);
$memstatus = stripslashes($hos_config['memberstatus']);
$memstatdiv = intval($hos_config['memberstatusdivider']);
$memstatop = stripslashes($hos_config['memberstatusoperator']);
echo "<br>\n";
OpenTable();
echo "<table border='0' cellpadding='0' cellspacing='0' width='100%'>\n";
echo "<tr><td align='center' width='100%'>"._HoS_UPLOADNOTE."</td></tr>\n";
echo "<tr><td width='100%'>&nbsp;</td></tr>\n";
echo "</table>\n";
echo "<form action='".$admin_file.".php' method='POST' enctype='multipart/form-data'>\n";
echo "<input type='hidden' name='op' value='HoSPunk_Add_Save'>\n";
echo "<table align='center' border='0' cellpadding='2' cellspacing='2'>\n";
echo "<tr><td bgcolor='$bgcolor2'><b>"._HoS_PUNKNAME.":</b></td><td><input type='text' name='punkname' size='30' maxlength='120'></td></tr>\n";
echo "<tr><td bgcolor='$bgcolor2'><b>"._HoS_PUNKGUID.":</b></td><td><input type='text' name='punkguid' size='30' maxlength='120'></td></tr>\n";
echo "<tr><td bgcolor='$bgcolor2'><b>"._HoS_PUNKIP.":</b></td><td><input type='text' name='punkip' size='30' maxlength='120'></td></tr>\n";
echo "<tr><td bgcolor='$bgcolor2'><b>"._HoS_REASONFORBAN.":</b></td>\n";
echo "<td><select name='punkreason'>\n<option value='0' selected>"._HoS_NOREASON."</option>\n";
$catq = $db->sql_query("SELECT rid, title from ".$prefix."_hos_reasons where rpid > 0");
while(list($rid, $title) = $db->sql_fetchrow($catq)) { echo "<option value='$rid'>".stripslashes($title)."</option>\n"; }
echo "</select></td></tr>\n";
echo "<tr><td bgcolor='$bgcolor2'><b>"._HoS_BANNEDBY.":</b></td>\n";
echo "<td><select name='punkbannedby'>\n<option value='0' selected>"._HoS_ADMIN."</option>\n";
$comq = $db->sql_query("SELECT $memid, $memname, $memstatus from $memtbl WHERE $memstatus $memstatop '$memstatdiv'");
while(list($memberid, $name) = $db->sql_fetchrow($comq)) { echo "<option value='$memberid'>".stripslashes($name)."</option>\n"; }
echo "</select></td></tr>\n";
echo "<tr><td bgcolor='$bgcolor2'><b>"._HoS_SCREENSHOT.":</b></td><td><input type='file' name='fpunkss' size='40'></td></tr>\n";
echo "<tr><td bgcolor='$bgcolor2'><b>"._HoS_DEMO.":</b></td><td><input type='file' name='fpunkdemo' size='40'></td></tr>\n";
echo "<tr><td bgcolor='$bgcolor2' valign='top'><b>"._HoS_NOTES.":</b></td><td><textarea rows='7' name='punknotes' cols='50'></textarea></td></tr>\n";
echo "<tr><td align='center' colspan='2'><input type='checkbox' name='another' value='1' >"._HoS_ADDANOTHERPUNK."</td></tr>\n";
echo "<tr><td align='center' colspan='2' valign='top' width='100%'><input type='submit' value='"._HoS_ADDPUNK."'></td></tr>\n";
echo "</table>\n";
echo "</form>\n";
CloseTable();
@include("footer.php");

?>