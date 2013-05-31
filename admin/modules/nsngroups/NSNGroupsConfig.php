<?php

/********************************************************/
/* NSN Groups                                           */
/* By: NukeScripts Network (webmaster@nukescripts.net)  */
/* http://www.nukescripts.net                           */
/* Copyright © 2000-2005 by NukeScripts Network         */
/********************************************************/

$pagetitle = " - "._GR_GROUPSCONFIG." ".$gr_config['version_number'];
include("header.php");
title(_GR_GROUPSCONFIG." ".$gr_config['version_number']);
NSNGroupsAdmin();
echo "<br>\n";
OpenTable();
echo "<table align='center' border='0' cellpadding='2' cellspacing='2'>\n";
echo "<form action='".$admin_file.".php' method='post'>\n";
echo "<input type='hidden' name='file' value='admin'>\n";
echo "<tr><td bgcolor='$bgcolor2'>"._GR_SENDNOTICE."</td><td><select name='xsend_notice'>\n";
echo "<option value='0'";
if($gr_config['send_notice'] == 0) { echo " selected"; }
echo "> "._GR_NO." </option>\n<option value='1'";
if($gr_config['send_notice'] == 1) { echo " selected"; }
echo "> "._GR_YES." </option>\n";
echo "</select></td></tr>\n";
echo "<tr><td bgcolor='$bgcolor2'>"._GR_PERPAGE."</td><td><select name='xperpage'>\n";
echo "<option value='".$gr_config['perpage']."' selected> ".$gr_config['perpage']." </option>\n";
for($i=1; $i <= 5; $i++) { $j = $i * 10; echo "<option value='$j'> $j </option>\n"; }
echo "</select></td></tr>\n";
echo "<tr><td bgcolor='$bgcolor2'>"._GR_DATEFORMAT.":</td><td>";
echo "<input size='30' maxlength='60' type='text' name='xdate_format' value='".$gr_config['date_format']."'><br>"._GR_DATEFORMATMSG."</td></tr>\n";
echo "<input type='hidden' name='op' value='NSNGroupsConfigSave'>\n";
echo "<tr><td align='center' colspan='2'><input type='submit' value='"._GR_SAVECHANGES."'></td></tr>\n";
echo "</form>\n";
echo "</table>\n";
CloseTable();
include("footer.php");

?>