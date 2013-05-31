<?php

/********************************************************/
/* NSN Groups                                           */
/* By: NukeScripts Network (webmaster@nukescripts.net)  */
/* http://www.nukescripts.net                           */
/* Copyright © 2000-2005 by NukeScripts Network         */
/********************************************************/

$pagetitle = _GR_ADMIN." ".$gr_config['version_number'].": "._GR_GROUPSADD;
global $admin_file;
@include("header.php");
$field_r = "\"gname\", \"mname\"";
$field_d = "\""._GR_GROUPNAME."\", \""._GR_BBMODERATOR."\"";
grformcheck($field_r, $field_d);
title("$pagetitle");
NSNGroupsAdmin();
echo "<br>\n";
OpenTable();
echo "<center><table border='0' cellpadding='0' cellspacing='2'>\n";
echo "<form method='post' name='post' action='".$admin_file.".php' onsubmit='return formCheck(this);'>\n";
echo "<input type='hidden' name='op' value='NSNGroupsAddSave'>\n";
echo "<tr><td bgcolor='$bgcolor2'><b>"._GR_GROUPNAME.":</b></td>";
echo "<td><input type='text' name='gname' size='40' maxlength='32'></td></tr>\n";
echo "<tr><td bgcolor='$bgcolor2'><b>"._GR_BBMODERATOR.":</b></td>";
echo "<td><input type='text' class='post' name='username' size='30' maxlength='25'> &nbsp; <input type='submit' name='usersubmit' value='"._FIND_USERNAME."' onClick=\"window.open('modules.php?name=Forums&file=search&mode=searchuser&popup=1&menu=1', '_phpbbsearch', 'HEIGHT=250,resizable=yes,WIDTH=400');return false; \" /></td></tr>\n";
echo "<tr><td bgcolor='$bgcolor2' valign='top'><b>"._GR_DESCRIPTION.":</b></td>";
echo "<td><textarea name='gdesc' cols='40' rows='10'></textarea></td></tr>\n";
echo "<tr><td bgcolor='$bgcolor2' valign='top'><b>"._GR_PUBLIC.":</b></td>";
echo "<td><select name='gpublic'><option value='0'>"._OPEN."</option>";
echo "<option value='1'>"._CLOSED."</option><option value='2'>"._HIDDEN."</option></select><br>"._GR_PUBLICNOTE."</td></tr>\n";
echo "<tr><td bgcolor='$bgcolor2' valign='top'><b>"._GR_LIMIT.":</b></td>";
echo "<td><input type='text' name='glimit' size='4' maxlength='4' value='0'><br>"._GR_LIMITNOTE."</td></tr>\n";
echo "<tr><td align='center' colspan='2'><input type='submit' value='"._GR_ADDGRP."'></td></tr>\n";
echo "</form>\n";
echo "</table></center>\n";
CloseTable();
@include("footer.php");

?>