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
$topicid = intval($topicid);
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
NE_Admin(_NE_TOPICS." "._NE_ADMIN.": "._NE_TOPICEDIT);
echo "<br />\n";
OpenTable();
$topicid = intval($topicid);
$result = $db->sql_query("SELECT * FROM `".$prefix."_topics` WHERE `topicid`='$topicid'");
$row = $db->sql_fetchrow($result);
$db->sql_freeresult($result);
$topicid = intval($row['topicid']);
$topicname = stripslashes(ne_check_html(ne_convert_text($row['topicname']), 0));
$topicimage = ne_check_html(ne_convert_text($row['topicimage']), 0);
$topictext = stripslashes(ne_check_html(ne_convert_text($row['topictext']), 0));
echo "<table align='center' border='0' cellpadding='2' cellspacing='2'>\n";
echo "<form name='topicadmin' action='".$admin_file.".php' method='post'>\n";
echo "<input type='hidden' name='topicid' value='$topicid'>\n";
echo "<input type='hidden' name='op' value='NETopicEditSave'>\n";
echo "<tr><td bgcolor='$bgcolor2'><b>"._NE_TOPICNAME.":</b><br /><font class='tiny'>"._NE_TOPICNAME1."<br />\n";
echo ""._NE_TOPICNAME2."</font></td>\n";
echo "<td valign='top'><input type='text' name='topicname' size='20' maxlength='20' value='$topicname'></td></tr>\n";
echo "<tr><td bgcolor='$bgcolor2'><b>"._NE_TOPICTEXT.":</b><br /><font class='tiny'>"._NE_TOPICTEXT1."<br />\n";
echo ""._NE_TOPICTEXT2."</font></td>\n";
echo "<td valign='top'><input type='text' name='topictext' size='40' maxlength='40' value='$topictext'></td></tr>\n";
echo "<tr><td bgcolor='$bgcolor2' valign='top'><b>"._NE_TOPICIMAGE.":</b></td>\n";
echo "<td valign='top'><select name='topicimage' onChange='neshowimage()'>\n";
$handle=opendir($tipath);
while($file = readdir($handle)) { if(ereg(".gif|.png|.jpg",$file) AND !stristr($file, "alltopics")) { $tlist[] = $file; } }
closedir($handle);
sort($tlist);
for($i=0; $i < sizeof($tlist); $i++) {
  if($tlist[$i]!="") {
    $sel = "";
    if($topicimage == $tlist[$i]) { $sel = "selected"; }
    echo "<option name='topicimage' value='$tlist[$i]' $sel>$tlist[$i]</option>\n";
  }
}
echo "</select>&nbsp;&nbsp;<img src='".$tipath."$topicimage' align='top' name='topic' width='32' height='32' alt=''></td></tr>\n";
echo "<tr><td colspan='2'>&nbsp;</td></tr>\n";
echo "<tr><td bgcolor='$bgcolor2' colspan='2'><b>"._NE_RELATEDADD.":</b></td></tr>\n";
echo "<tr><td bgcolor='$bgcolor2'><b>"._NE_SITENAME.":</b></td><td><input type='text' name='rname' size='30' maxlength='30'></td></tr>\n";
echo "<tr><td bgcolor='$bgcolor2'><b>"._NE_URL.":</b></td><td><input type='text' name='rurl' value='http://' size='50' maxlength='200'></td></tr>\n";
echo "<tr><td colspan='2'>&nbsp;</td></tr>\n";
echo "<tr><td bgcolor='$bgcolor2' colspan='2'><b>"._NE_ACTIVERELATEDLINKS.":</b></td></tr>\n";
$res = $db->sql_query("SELECT * FROM `".$prefix."_related` WHERE `tid`='$topicid'");
if($db->sql_numrows($res) == 0) {
  echo "<tr><td align='center' colspan='2'><font class='tiny'>"._NE_NORELATED."</font></td></tr>\n";
} else {
  while($row2 = $db->sql_fetchrow($res)) {
    $rid = intval($row2['rid']);
    $rname = ne_check_html(ne_convert_text($row2['name']), 0);
    $url = ne_check_html(ne_convert_text($row2['url']), 0);
    echo "<tr><td align='center' colspan='2'><a href='$url' target='_blank'>$rname</a>&nbsp;<strong><big>&middot;</big></strong>&nbsp;";
    echo "<a href='$url' target='_blank'>$url</a>&nbsp;<strong><big>&middot;</big></strong>&nbsp;<a href='".$admin_file.".php?op=NERelatedEdit&amp;tid=$topicid&amp;rid=$rid'><img src='modules/$modname/images/edit.png' border='0' height='16' width='16' alt='"._NE_EDIT." "._NE_RELATED."' title='"._NE_EDIT." "._NE_RELATED."'></a>";
    echo "&nbsp;<a href='".$admin_file.".php?op=NERelatedDelete&amp;tid=$topicid&amp;rid=$rid'><img src='modules/$modname/images/delete.png' border='0' height='16' width='16' alt='"._NE_DELETE." "._NE_RELATED."' title='"._NE_DELETE." "._NE_RELATED."'></a></td></tr>";
  }
}
$db->sql_freeresult($res);
echo "<tr><td align='center' colspan='2'><INPUT type='submit' value='"._NE_SAVECHANGES."'></td></tr>\n";
echo "</form>";
echo "</table>";
CloseTable();
ne_copy();
include("footer.php");

?>