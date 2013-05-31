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

$module_name = basename(dirname(__FILE__));
$mod_name = "Hall of Shame";
$author_email = "WhomKnows@hotmail.com";
$author_homepage = "http://mrc.clanservers.com";
$author_homepage2 = "http://www.sundatavisual.com";
$author_name = "<a href=\"$author_homepage\" target=\"new\">Master Rifle Clan</a>";
$original_by = "<a href='$author_homepage2'>Troy Moore</a>";
$license = "Copyright &copy; 2006-2011 JesStep Enterprises";
$download_location = "";
$module_version = "1.2.0";
$release_date = "";
$module_description = "";
$mod_cost = "";
if ($mod_name == "") { $mod_name = eregi_replace("_", " ", $module_name); }

echo "<html>\n";
echo "<head>\n";
echo "<title>$mod_name: Copyright Information</title>\n";
echo "<style type=\"text/css\">\n";
echo "<!--\n";
echo "body{\n";
echo "FONT-FAMILY:Verdana,Helvetica; FONT-SIZE:11px;\n";
echo "SCROLLBAR-3DLIGHT-COLOR:#000000;\n";
echo "SCROLLBAR-ARROW-COLOR:#e7e7e7;\n";
echo "SCROLLBAR-FACE-COLOR:#414141;\n";
echo "SCROLLBAR-DARKSHADOW-COLOR:#000000;\n";
echo "SCROLLBAR-HIGHLIGHT-COLOR:#9d9d9d;\n";
echo "SCROLLBAR-SHADOW-COLOR:#9d9d9d;\n";
echo "SCROLLBAR-TRACK-COLOR:#e7e7e7;\n";
echo "}\n";
echo "-->\n";
echo "</style>\n";
echo "</head>\n";
echo "<body bgcolor=\"#FFFFFF\" link=\"#000000\" alink=\"#000000\" vlink=\"#000000\">\n";
echo "<center><b>Module Copyright &copy; Information</b><br>";
echo "$mod_name module</center>\n<hr>\n";
echo "<img src=\"images/arrow.png\" border=\"0\">&nbsp;<b>Module's Name:</b> $mod_name<br>\n";
if ($module_version != "") { echo "<img src=\"images/arrow.png\" border=\"0\">&nbsp;<b>Module's Version:</b> $module_version<br>\n"; }
if ($release_date != "") { echo "<img src=\"images/arrow.png\" border=\"0\">&nbsp;<b>Release Date:</b> $release_date<br>\n"; }
if ($mod_cost != "") { echo "<img src=\"images/arrow.png\" border=\"0\">&nbsp;<b>Module's Cost:</b> $mod_cost<br>\n"; }
if ($license != "") { echo "<img src=\"images/arrow.png\" border=\"0\">&nbsp;<b>License:</b> $license<br>\n"; }
if ($author_name != "") { echo "<img src=\"images/arrow.png\" border=\"0\">&nbsp;<b>Author's Name:</b> $author_name<br>\n"; }
if ($original_by != "") { echo "<img src=\"images/arrow.png\" border=\"0\">&nbsp;<b>Original By:</b> $original_by<br>\n"; }
if ($author_email != "") { echo "<img src=\"images/arrow.png\" border=\"0\">&nbsp;<b>Author's Email:</b> $author_email<br>\n"; }
if ($module_description != "") { echo "<img src=\"images/arrow.png\" border=\"0\">&nbsp;<b>Module's Description:</b> $module_description<br>\n"; }
if ($download_location != "") { echo "<img src=\"images/arrow.png\" border=\"0\">&nbsp;<b>Module's Download:</b> <a href=\"$download_location\" target=\"new\">Download</a><br>\n"; }
echo "<hr>\n";
echo "<center>[<a href=\"#\" onClick=javascript:self.close()>Close Window</a>]</center>\n";
echo "</body>\n";
echo "</html>";

?>
