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
$pagetitle = " - "._HoS_HALLOFSHAME.": "._HoS_DELETEMEMBER;
@include("header.php");
adminheader(_HoS_HALLOFSHAME.": "._HoS_DELETEMEMBER);
echo "<br>\n";
OpenTable();
$meminfo = $db->sql_fetchrow($db->sql_query("SELECT * from ".$prefix."_hos_members where memberid = $memid"));
echo "<table border='0' cellpadding='0' cellspacing='0' width='100%'>\n";
echo "<form action='".$admin_file.".php' method='POST'>\n";
echo "<input type='hidden' name='memid' value='".$meminfo['memberid']."'>\n";
echo "<input type='hidden' name='op' value='HoSMember_Delete_Save'>\n";
echo "<tr><td align='center'><h2>"._HoS_DELETEMEMBER.": ".stripslashes($meminfo['membername'])."</h2></td></tr>\n";
echo "<tr><td align='center'>"._HoS_DELMEMMESS1."</td></tr>\n";
echo "<tr><td>&nbsp;</td></tr>\n";
echo "<tr><td align='center'>"._HoS_DELMEMMESS2."</td></tr>\n";
echo "<tr><td>&nbsp;</td></tr>\n";
echo "<tr><td align='center'><select name='rmemid'>\n";
echo "<option value='0' selected>"._HoS_NOMEMBER."</option>\n";
$request = $db->sql_query("SELECT * from ".$prefix."_hos_members WHERE memberid!=".$meminfo['memberid']);
while($meminfo2 = $db->sql_fetchrow($request)) {
  echo "<option value='".$meminfo2['memberid']."'>".stripslashes($meminfo2['membername'])."</option>\n";
}
echo "</select></td></tr>\n";
echo "<tr><td>&nbsp;</td></tr>\n";
echo "<tr><td align='center'><input type='submit' value='"._HoS_DELETEMEMBER."'></td></tr>\n";
echo "</form>\n";
echo "</table>\n";
CloseTable();
@include("footer.php");

?>