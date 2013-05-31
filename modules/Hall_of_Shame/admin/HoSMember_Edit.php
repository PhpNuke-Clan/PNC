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


$memid = intval($memid);
$pagetitle = " - "._HoS_HALLOFSHAME.": "._HoS_EDITMEMBER;
@include("header.php");
adminheader(_HoS_HALLOFSHAME.": "._HoS_EDITMEMBER);
echo "<br>\n";
OpenTable();
$meminfo = $db->sql_fetchrow($db->sql_query("SELECT * from ".$prefix."_hos_members where memberid='$memid'"));
echo "<table align='center' border='0' cellpadding='2' cellspacing='2'>\n";
echo "<form action='".$admin_file.".php' method='POST'>\n";
echo "<input type='hidden' name='memid' value='".$meminfo['memberid']."'>\n";
echo "<input type='hidden' name='op' value='HoSMember_Edit_Save'>\n";
echo "<tr><td bgcolor='$bgcolor2'><b>"._HoS_MEMBERNAME.":</b></td>\n";
echo "<td><input type='text' name='newname' size='54' maxlength='120' value='".stripslashes($meminfo['membername'])."'></td></tr>\n";
echo "<tr><td align='center' colspan='2'><input type='submit' value='"._HoS_EDITMEMBER."'></td></tr>\n";
echo "</table>\n";
echo "</form>\n";
CloseTable();
@include("footer.php");

?>