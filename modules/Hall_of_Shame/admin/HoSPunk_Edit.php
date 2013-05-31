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


$pid = intval($pid);
$pagetitle = " - "._HoS_HALLOFSHAME.": "._HoS_EDITPUNK;
@include("header.php");
adminheader(_HoS_HALLOFSHAME.": "._HoS_EDITPUNK);
$memid = stripslashes($hos_config['mid']);
$memtbl = stripslashes($hos_config['membertable']);
$memname = stripslashes($hos_config['membername']);
$memstatus = stripslashes($hos_config['memberstatus']);
$memstatdiv = intval($hos_config['memberstatusdivider']);
$memstatop = stripslashes($hos_config['memberstatusoperator']);
echo "<br>\n";
$punkinfo = $db->sql_fetchrow($db->sql_query("SELECT * FROM ".$prefix."_hos_punks WHERE pid = '$pid'"));
OpenTable();
echo "<p align='center'>"._HoS_UPLOADNOTE."</p>\n";
echo "<table align='center' border='0' cellpadding='2' cellspacing='2'>\n";
echo "<form action='".$admin_file.".php' method='POST' enctype='multipart/form-data'>\n";
echo "<input type='hidden' name='pid' value='$pid'>\n";
echo "<input type='hidden' name='op' value='HoSPunk_Edit_Save'>\n";
echo "<tr><td bgcolor='$bgcolor2'><b>"._HoS_PUNKNAME.":</b></td>\n";
echo "<td><input type='text' name='punkname' size='30' maxlength='120' value=\"".stripslashes($punkinfo['punkname'])."\"></td></tr>\n";
echo "<tr><td bgcolor='$bgcolor2'><b>"._HoS_PUNKGUID.":</b></td>\n";
echo "<td><input type='text' name='punkguid' size='30' maxlength='120' value=\"".stripslashes($punkinfo['punkguid'])."\"></td></tr>\n";
echo "<tr><td bgcolor='$bgcolor2'><b>"._HoS_PUNKIP.":</b></td>\n";
echo "<td><input type='text' name='punkip' size='30' maxlength='120' value=\"".stripslashes($punkinfo['punkip'])."\"></td></tr>\n";
echo "<tr><td bgcolor='$bgcolor2'><b>"._HoS_PUNKREASON.":</b></td>\n";
echo "<td><select name='punkreason'>\n<option value='0'>"._HoS_NOREASON."</option>\n";
$catq = $db->sql_query("SELECT rid, title from ".$prefix."_hos_reasons where rpid > 0");
while(list($rid, $title) = $db->sql_fetchrow($catq)) {
  if ($rid == $punkinfo['punkreason']) { $sel1 = " selected"; }
  echo "<option value='$rid'$sel1>".stripslashes($title)."</option>\n";
  $sel1 = "";
}
echo "</select></td></tr>\n";
echo "<tr><td bgcolor='$bgcolor2'><b>"._HoS_BANNEDBY.":</b></td>\n";
echo "<td><select name='punkbannedby'>\n<option value='0'>"._HoS_BANNEDBY."</option>\n";
$comq = $db->sql_query("SELECT $memid, $memname from $memtbl WHERE $memstatus $memstatop $memstatdiv");
while(list($id, $name) = $db->sql_fetchrow($comq)) {
  if ($id == $punkinfo['punkbannedby']) { $sel2 = " selected"; }
  echo "<option value='$id'$sel2>".stripslashes($name)."</option>\n";
  $sel2 = "";
}
echo "</select></td></tr>\n";
echo "<tr><td bgcolor='$bgcolor2'><b>"._HoS_SCREENSHOT.":</b></td>\n";
echo "<td><input type='file' name='fpunkss' size='40'><br>"._HoS_CURRENT.": ".$punkinfo['punkss']."</td></tr>\n";
echo "<input type='hidden' name='old_punkss' value='".$punkinfo['punkss']."'>\n";
echo "<input type='hidden' name='old_punksslabel' value='".$punkinfo['punksslabel']."'>\n";
echo "<tr><td bgcolor='$bgcolor2'><b>"._HoS_PUNKDEMO.":</b></td>\n";
echo "<td><input type='file' name='fpunkdemo' size='40'><br>"._HoS_CURRENT.": ".$punkinfo['punkdemo']."</td></tr>\n";
echo "<input type='hidden' name='old_punkdemo' value='".$punkinfo['punkdemo']."'>\n";
echo "<input type='hidden' name='old_punkdemolabel' value='".$punkinfo['punkdemolabel']."'>\n";
echo "<tr><td bgcolor='$bgcolor2' valign='top'><b>"._HoS_PUNKNOTES.":</b></td>\n";
echo "<td><textarea rows='7' name='punknotes' cols='50'>".stripslashes($punkinfo['punknotes'])."</textarea></td></tr>\n";
echo "<tr><td align='center' colspan='2'><input type='submit' value='"._HoS_SAVEPUNK."'></td></tr>\n";
echo "</form>\n";
echo "</table>\n";
CloseTable();
@include("footer.php");

?>