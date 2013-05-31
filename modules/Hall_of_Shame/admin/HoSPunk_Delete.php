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
$pagetitle = " - "._HoS_HALLOFSHAME.": "._HoS_DELETEPUNK;
@include("header.php");
$sql = $db->sql_query("SELECT * from ".$prefix."_hos_punks where pid='$pid'");
$row = $db->sql_fetchrow($sql);
$punkname = $row[punkname];
adminheader(_HoS_HALLOFSHAME.": "._HoS_DELETEPUNK);
echo "<br>\n";
OpenTable();
echo "<table align='center' border='0' cellpadding='0' cellspacing='0'>\n";
echo "<tr><td align='center'><h2>"._HoS_DELETEPUNKCONFIRM.": <i>$punkname</i></h2></td></tr>\n";
echo "<tr><td align='center'><b>("._HoS_WARNING.")</b></td></tr>\n";
echo "<tr><td width='100%'>&nbsp;</td></tr>\n";
echo "<form action='".$admin_file.".php' method='POST'>\n";
echo "<input type='hidden' name='pid' value='$pid'>\n";
echo "<input type='hidden' name='op' value='HoSPunk_Delete_Save'>\n";
echo "<tr><td align='center'><input type='submit' value='"._HoS_DELETEPUNK."'></td></tr>\n";
echo "</form>\n";
echo "</table>\n";
CloseTable();
@include("footer.php");

?>