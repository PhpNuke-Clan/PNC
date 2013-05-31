<?php

$module_name = basename(dirname(__FILE__));
$mod_name = "Map Manager";
$author_email = "";
$author_homepage = "http://www.nukecoder.com";
$author_homepage2 = "";
$author_name = "<a href='$author_homepage' target='new'>NukeCoder.com</a>";
$license = "Copyright &copy; 2000-2006 gotcha NukeCoder.com";
$download_location = "http://nukecoder.com";
$module_version = "2.1";
$release_date = "Nov. 20, 2006";
$module_description = "Advanced Map Manager with rating system, user submitted maps, automatic thumbnail generation, and more.";

echo "<html>\n";
echo "<head>\n";
echo "<title>$mod_name: Copyright Information</title>\n";
echo "</head>\n";
echo "<body bgcolor=\"#FFFFFF\" link=\"#000000\" alink=\"#000000\" vlink=\"#000000\">\n";
echo "<center><b>Module Copyright &copy; Information</b><br>";
echo "$mod_name module</center>\n<hr>\n";
echo "<b>Module's Name:</b> $mod_name<br>\n";
if ($module_version != "") { echo "<b>Module's Version:</b> $module_version<br>\n"; }
if ($release_date != "") { echo "<img src=\"images/arrow.png\" border=\"0\">&nbsp;<b>Release Date:</b> $release_date<br>\n"; }
if ($mod_cost != "") { echo "<b>Module's Cost:</b> $mod_cost<br>\n"; }
if ($license != "") { echo "<b>License:</b> $license<br>\n"; }
if ($author_name != "") { echo "<b>Author's Name:</b> $author_name<br>\n"; }
if ($author_email != "") { echo "<b>Author's Email:</b> $author_email<br>\n"; }
if ($module_description != "") { echo "<b>Module's Description:</b> $module_description<br>\n"; }
if ($download_location != "") { echo "<b>Module's Download:</b> <a href=\"$download_location\" target=\"new\">Download</a><br>\n"; }
echo "<hr>\n";
echo "<center>[<a href=\"#\" onClick=javascript:self.close()>Close Window</a>]</center>\n";
echo "</body>\n";
echo "</html>";

?>