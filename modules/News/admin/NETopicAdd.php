<?php

/********************************************************/
/* NSN News                                             */
/* By: NukeScripts Network (webmaster@nukescripts.net)  */
/* http://www.nukescripts.net                           */
/* Copyright © 2000-2005 by NukeScripts Network         */
/********************************************************/
/* Based on: Threaded Discussion                        */
/* Copyright (C) 2000  Thatware Development Team        */
/* http://atthat.com/                                   */
/********************************************************/

if(!defined('NSNNE_ADMIN')) { die("Illegal File Access Detected!!"); }
include("header.php");
echo "<SCRIPT type='text/javascript'>\n";
echo "<!--\n";
echo "function neshowimage() {\n";
echo "if(!document.images)\n";
echo "return\n";
echo "document.images.topic.src=\n";
echo "'$nukeurl/images/topics/' + document.topicadmin.topicimage.options[document.topicadmin.topicimage.selectedIndex].value\n";
echo "}\n";
echo "//-->\n";
echo "</SCRIPT>\n\n";
NE_Admin(_NE_TOPICS." "._NE_ADMIN.": "._NE_TOPICADD);
echo "<br />\n";
OpenTable();
echo "<table align='center' border='0' cellpadding='2' cellspacing='2'>\n";
echo "<form name='topicadmin' action='".$admin_file.".php' method='post'>\n";
echo "<input type='hidden' name='op' value='NETopicAddSave'>\n";
echo "<tr><td bgcolor='$bgcolor2' valign='top'><b>"._NE_TOPICNAME.":</b></td><td><input type='text' name='topicname' size='20' maxlength='20'><br />\n";
echo "<font class='tiny'>"._NE_TOPICNAME1."<br />"._NE_TOPICNAME2."</font></td></tr>\n";
echo "<tr><td bgcolor='$bgcolor2' valign='top'><b>"._NE_TOPICTEXT.":</b></td><td><input type='text' name='topictext' size='40' maxlength='40'><br />\n";
echo "<font class='tiny'>"._NE_TOPICTEXT1."<br />"._NE_TOPICTEXT2."</font></td></tr>\n";
echo "<tr><td bgcolor='$bgcolor2' valign='top'><b>"._NE_TOPICIMAGE.":</b></td><td><select name='topicimage' onChange='neshowimage()'>\n";
$handle=opendir($tipath);
while($file = readdir($handle)) { if(ereg(".gif|.png|.jpg",$file) AND !stristr($file, "alltopics")) { $tlist[] = $file; } }
closedir($handle);
sort($tlist);
$timage = $tlist[0];
for($i=0; $i < sizeof($tlist); $i++) {
  echo "<option name='topicimage' value='$tlist[$i]'>$tlist[$i]</option>\n";
}
echo "</select>&nbsp;&nbsp;<img src='".$tipath."$timage' align='top' name='topic' width='32' height='32' alt=''></td></tr>\n";
echo "<tr><td align='center' colspan='2'><input type='submit' value='"._NE_TOPICADD."'></td></tr>\n";
echo "</form>\n";
echo "</table>\n";
CloseTable();
ne_copy();
include("footer.php");

?>