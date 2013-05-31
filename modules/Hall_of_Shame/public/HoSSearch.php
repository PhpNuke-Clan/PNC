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

if ( !defined('MODULE_FILE') )
{
   die("You can't access this file directly...");
}

$pagetitle = " - "._HoS_HALLOFSHAME.": "._HoS_SEARCH;
@include("header.php");
mainheader(1, _HoS_HALLOFSHAME.": "._HoS_SEARCH, _HoS_INDEXMESS1);
OpenTable();
  echo "<center><form action=\"modules.php?name=$module_name&op=HoSSearchProcess\" method=\"post\">";
  echo "<BR>"._HoS_SEARCHINDEX."<BR><BR>";
  echo "<input type=\"text\" size=\"35\" name=\"query\"> <input type=\"submit\" value=\"Search\"<BR>";
   echo "<BR>"._HoS_SEARCHMESS."<BR>";
  echo "<table width=\"30%\" align=\"center\"><tr> ";
  echo "<td align=\"center\"><input type=\"radio\" name=\"searchtype\" value=\"0\" checked>"._HoS_NAME."</td>";
  echo "<td align=\"center\"><input type=\"radio\" name=\"searchtype\" value=\"1\">"._HoS_GUID."</td>";
  echo "<td align=\"center\"><input type=\"radio\" name=\"searchtype\" value=\"2\">"._HoS_IP."</td>";
  echo "</tr></table></form></center>";
  CloseTable();
  @include("footer.php");

?>