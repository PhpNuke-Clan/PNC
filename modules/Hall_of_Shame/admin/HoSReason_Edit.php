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


$rid = intval($rid);
$pagetitle = " - "._HoS_HALLOFSHAME.": "._HoS_EDITREASON;
@include("header.php");
adminheader(_HoS_HALLOFSHAME.": "._HoS_EDITREASON);
echo "<br>\n";
OpenTable();
$catinfo = $db->sql_fetchrow($db->sql_query("SELECT * from ".$prefix."_hos_reasons where rid='$rid'"));
echo "<table align='center' border='0' cellpadding='2' cellspacing='2'>\n";
echo "<form action='".$admin_file.".php' method='POST'>\n";
echo "<input type='hidden' name='rid' value='".$catinfo['rid']."'>\n";
echo "<input type='hidden' name='op' value='HoSReason_Edit_Save'>\n";
echo "<tr><td bgcolor='$bgcolor2'><b>"._HoS_SELECTCATEGORY.":</b></td>\n";
echo "<td><select name='newrpid'>\n<option value='0'>"._HoS_NOCATEGORY."</option>\n";
$catq = $db->sql_query("SELECT rid, title from ".$prefix."_hos_reasons where rpid='0'");
while(list($rid, $title) = $db->sql_fetchrow($catq)) {
  if ($rid == $catinfo['rpid']) { $sel1 = " selected"; }
  echo "<option value='$rid'$sel1>".stripslashes($title)."</option>\n";
  $sel1 = "";
}
echo "</select><em>"._HoS_MUSTSELECTCATEGORY."</em></td></tr>\n";
echo "<tr><td bgcolor='$bgcolor2'><b>"._HoS_TITLE.":</b></td>\n";
echo "<td><input type='text' name='newtitle' size='54' maxlength='120' value='".stripslashes($catinfo['title'])."'></td></tr>\n";
echo "<tr><td bgcolor='$bgcolor2' valign='top'><b>"._HoS_DESCRIPTION.":</b></td><td><textarea rows='7' name='newrdesc' cols='52'>".stripslashes($catinfo[rdesc])."</textarea></td></tr>\n";
echo "<tr><td align='center' colspan='2'><input type='submit' value='"._HoS_EDITREASON."'></td></tr>\n";
echo "</table>\n";
echo "</form>\n";
CloseTable();
@include("footer.php");

?>