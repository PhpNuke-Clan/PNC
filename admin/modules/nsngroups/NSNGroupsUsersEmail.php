<?php

/********************************************************/
/* NSN Groups                                           */
/* By: NukeScripts Network (webmaster@nukescripts.net)  */
/* http://www.nukescripts.net                           */
/* Copyright © 2000-2005 by NukeScripts Network         */
/********************************************************/

$pagetitle = _GR_ADMIN." ".$gr_config['version_number'].": "._GR_GROUPSEMAIL;
include("header.php");
title("$pagetitle");
NSNGroupsAdmin();
echo "<br>\n";
OpenTable();
echo "<center><form method='post' action='".$admin_file.".php'>\n";
echo "<b>"._GR_TYPE.":</b> <select name='etype'>\n";
echo "<option value='0'>"._GR_TEXT."</option>\n<option value='1'>"._GR_HTML."</option>\n";
echo "</select><br><br>\n";
echo "<b>"._GR_FROMA.":</b> $aname<br><br>\n";
echo "<b>"._GR_TO.":</b> <select name='gid'>\n";
echo "<option value='0'>"._GR_ALLGR."</option>\n";
$result = $db->sql_query("SELECT `gid`, `gname` FROM `".$prefix."_nsngr_groups` ORDER BY `gname`");
while (list($gid, $gname) = $db->sql_fetchrow($result)) { echo "<option value='$gid'>$gname</option>\n"; }
echo "</select><br><br>\n";
echo "<b>"._GR_SUB.":</b> <input type='text' name='gsubject' size='50'><br><br>\n";
echo "<b>"._GR_MES.":</b><br><textarea name='gcontent' $textrowcol></textarea><br><br>\n";
echo "<input type='hidden' name='aname' value='$aname'>\n";
echo "<input type='hidden' name='amail' value='$amail'>\n";
echo "<input type='hidden' name='op' value='NSNGroupsUsersEmailSend'>\n";
echo "<input type='submit' value='"._GR_SEND."'>\n";
echo "</form>";
CloseTable();
include("footer.php");

?>