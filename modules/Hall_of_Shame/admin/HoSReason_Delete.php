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
$pagetitle = " - "._HoS_HALLOFSHAME.": "._HoS_DELETEREASON;
@include("header.php");
adminheader(_HoS_HALLOFSHAME.": "._HoS_DELETEREASON);
echo "<br>\n";
OpenTable();
$catinfo = $db->sql_fetchrow($db->sql_query("SELECT * from ".$prefix."_hos_reasons where rid = '$rid'"));
echo "<table border='0' cellpadding='0' cellspacing='0' width='100%'>\n";
echo "<form action='".$admin_file.".php' method='POST'>\n";
echo "<input type='hidden' name='rid' value='".$catinfo['rid']."'>\n";
echo "<input type='hidden' name='op' value='HoSReason_Delete_Save'>\n";
echo "<tr><td align='center'><h2>"._HoS_DELETEREASON.": ".stripslashes($catinfo['title'])."</h2></td></tr>\n";
echo "<tr><td align='center'>"._HoS_DELRESMESS1."</td></tr>\n";
echo "<tr><td>&nbsp;</td></tr>\n";
echo "<tr><td align='center'>"._HoS_DELRESMESS2."</td></tr>\n";
echo "<tr><td>&nbsp;</td></tr>\n";
echo "<tr><td align='center'><select name='rrid'>\n";
echo "<option value='0' selected>No Reason</option>\n";
$request = $db->sql_query("SELECT * from ".$prefix."_hos_reasons WHERE  rpid > 0 AND rid!='".$catinfo['rid']."'");
while($catinfo2 = $db->sql_fetchrow($request)) {
  echo "<option value='".$catinfo2['rid']."'>".stripslashes($catinfo2['title'])."</option>\n";
}
echo "</select></td></tr>\n";
echo "<tr><td>&nbsp;</td></tr>\n";
echo "<tr><td align='center'><input type='submit' value='"._HoS_DELETEREASON."'></td></tr>\n";
echo "</form>\n";
echo "</table>\n";
CloseTable();
@include("footer.php");

?>