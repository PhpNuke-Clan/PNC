<?php

/********************************************************/
/* NSN Groups                                           */
/* By: NukeScripts Network (webmaster@nukescripts.net)  */
/* http://www.nukescripts.net                           */
/* Copyright © 2000-2005 by NukeScripts Network         */
/********************************************************/

$pagetitle = _GR_ADMIN." ".$gr_config['version_number'].": "._GR_GROUPSEDIT;
global $admin_file;
@include("header.php");
title("$pagetitle");
NSNGroupsAdmin();
echo "<br>\n";
OpenTable();
echo "<center><table border='0' cellpadding='0' cellspacing='2'>\n";
echo "<form method='post' name='post' action='".$admin_file.".php'>\n";
echo "<input type='hidden' name='op' value='NSNGroupsEditSave'>\n";
echo "<input type='hidden' name='gid' value='$gid'>\n";
$grow = $db->sql_fetchrow($db->sql_query("SELECT * FROM ".$prefix."_nsngr_groups WHERE gid='$gid'"));
echo "<input type='hidden' name='old_muid' value='".$grow['muid']."'>\n";
echo "<tr><td bgcolor='$bgcolor2'><b>"._GR_GROUP.":</b></td>";
echo "<td><input type='text' name='gname' size='40' maxlength='32' value=\"".$grow['gname']."\"></td></tr>\n";
$mrow = $db->sql_fetchrow($db->sql_query("SELECT * FROM ".$user_prefix."_users WHERE user_id='".$grow['muid']."'"));
echo "<tr><td bgcolor='$bgcolor2'><b>"._GR_BBMODERATOR.":</b></td>";
echo "<td><input type='text' class='post' name='username' size='30' maxlength='25' value=\"".$mrow['username']."\"> &nbsp; <input type='submit' name='usersubmit' value='"._FIND_USERNAME."' onClick=\"window.open('modules.php?name=Forums&file=search&mode=searchuser&popup=1&menu=1', '_phpbbsearch', 'HEIGHT=250,resizable=yes,WIDTH=400');return false; \" /></td></tr>\n";
echo "<tr><td bgcolor='$bgcolor2' valign='top'><b>"._GR_DESCRIPTION.":</b></td>";
echo "<td><textarea name='gdesc' cols='40' rows='10'>".$grow['gdesc']."</textarea></td></tr>\n";
$sel1 = $sel2 = $sel3 = "";
if ($grow['gpublic'] == 0) { $sel1 = " selected"; } elseif ($grow['gpublic'] == 1) { $sel2 = " selected"; } else { $sel3 = " selected"; }
echo "<tr><td bgcolor='$bgcolor2' valign='top'><b>"._GR_PUBLIC.":</b></td>";
echo "<td><select name='gpublic'><option value='0'$sel1>"._OPEN."</option>";
echo "<option value='1'$sel2>"._CLOSED."</option><option value='2'$sel3>"._HIDDEN."</option></select><br>"._GR_PUBLICNOTE."</td></tr>\n";
echo "<tr><td bgcolor='$bgcolor2' valign='top'><b>"._GR_LIMIT.":</b></td>";
echo "<td><input type='text' name='glimit' size='4' maxlength='4' value='".$grow['glimit']."'><br>"._GR_LIMITNOTE."</td></tr>\n";
echo "<tr><td align='center' colspan='2'><input type='submit' value='"._GR_EDITGRP."'></td></tr>\n";
echo "</form>\n";
echo "</table></center>\n";
CloseTable();
@include("footer.php");

?>