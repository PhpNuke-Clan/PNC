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
$pagetitle = " - "._HoS_HALLOFSHAME.": "._HoS_DELETECATEGORY;
@include("header.php");
adminheader(_HoS_HALLOFSHAME.": "._HoS_DELETECATEGORY);
echo "<br>\n";
OpenTable();
$catinfo = $db->sql_fetchrow($db->sql_query("SELECT * from ".$prefix."_hos_reasons where rid = '$rid'"));
echo "<table border='0' cellpadding='0' cellspacing='0' width='100%'>\n";
echo "<form action='".$admin_file.".php' method='POST'>\n";
echo "<input type='hidden' name='rid' value='".$catinfo['rid']."'>\n";
echo "<input type='hidden' name='op' value='HoSReasonCat_Delete_Save'>\n";
echo "<tr><td align='center'><h2>"._HoS_DELETECATEGORY.": ".stripslashes($catinfo['title'])."</h2></td></tr>\n";
echo "<tr><td align='center'>"._HoS_DELCATMESS1."</td></tr>\n";
echo "<tr><td>&nbsp;</td></tr>\n";
echo "<tr><td align='center'>"._HoS_DELCATMESS2."</td></tr>\n";
echo "<tr><td>&nbsp;</td></tr>\n";
echo "<tr><td align='center'><select name='rrid'>\n";
echo "<option value='0' selected>"._HoS_NOCATEGORY."</option>\n";
$request = $db->sql_query("SELECT * from ".$prefix."_hos_reasons WHERE rid!='".$catinfo['rid']."' AND rpid='0'");
while($catinfo2 = $db->sql_fetchrow($request)) {
  echo "<option value='".$catinfo2['rid']."'>".stripslashes($catinfo2['title'])."</option>\n";
}
echo "</select></td></tr>\n";
echo "<tr><td>&nbsp;</td></tr>\n";
echo "<tr><td align='center'><input type='submit' value='"._HoS_DELETECATEGORY."'></td></tr>\n";
echo "</form>\n";
echo "</table>\n";
CloseTable();
@include("footer.php");

?>