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
$field_r = "\"gname\", \"username\"";
$field_d = "\""._GR_GROUPNAME."\", \""._GR_USERNAME."\"";
grformcheck($field_r, $field_d);
title("$pagetitle");
NSNGroupsAdmin();
echo "<br>\n";
OpenTable();
  $field_r = "\"gid\"";
  $field_d = "\""._GR_ADDUSRTO."\"";
  grformcheck($field_r, $field_d);
  echo "<center><table border='0' cellpadding='0' cellspacing='2'>\n";
  echo "<form method='post' name='post' action='".$admin_file.".php?op=NSNGroupsSingleUserAddSave' onsubmit='return formCheck(this);'>\n";
  echo "<tr>\n";
  echo "<td align='center'>"._GR_ADDUSRTO."<br>";
  echo "<SELECT NAME='gid' size='5'>\n";
  $result3 = $db->sql_query("SELECT `gid`, `gname` FROM `".$prefix."_nsngr_groups` ORDER BY `gname`");
  while(list($thisGID, $thisGNAME) = $db->sql_fetchrow($result3)) { echo "<option value='$thisGID'>$thisGNAME</option><br>\n"; }
  echo "</SELECT><br>";
  echo "<td><b>"._GR_USERNAME.":</b></td>";
echo "<td><input type='text' class='post' name='username' size='30' maxlength='25'> &nbsp; <input type='submit' name='usersubmit' value='"._FIND_USERNAME."' onClick=\"window.open('modules.php?name=Forums&file=search&mode=searchuser&popup=1&menu=1', '_phpbbsearch', 'HEIGHT=250,resizable=yes,WIDTH=400');return false; \" /></td>\n";
  echo "</tr>\n";
  echo "<tr>\n";
   echo "<td colspan='3' align='center'><input type='submit' value='"._GR_SUBMIT."'></td>\n";
   echo "</tr>\n";
  echo "</form>\n";
  echo "</table></center>\n";
CloseTable();
@include("footer.php");

?>