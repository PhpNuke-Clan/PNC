<?php

/********************************************************/
/* NSN Groups                                           */
/* By: NukeScripts Network (webmaster@nukescripts.net)  */
/* http://www.nukescripts.net                           */
/* Copyright © 2000-2005 by NukeScripts Network         */
/********************************************************/

$pagetitle = _GR_ADMIN." ".$gr_config['version_number'].": "._GR_GROUPSUSERSUPDATE;
include("header.php");
title("$pagetitle");
NSNGroupsAdmin();
echo "<br>\n";
OpenTable();
list($uemail) = $db->sql_fetchrow($db->sql_query("SELECT `user_email` FROM `".$user_prefix."_users` WHERE `user_id`='$chng_uid'"));
list($uname, $edate) = $db->sql_fetchrow($db->sql_query("SELECT `uname`, `edate` FROM `".$prefix."_nsngr_users` WHERE `uid`='$chng_uid' AND `gid`='$gid'"));
echo "<center><table border='0' cellpadding='2' cellspacing='2'>\n";
echo "<form action='".$admin_file.".php' method='post'>\n";
echo "<input type='hidden' name='op' value='NSNGroupsUsersUpdateSave'>\n";
echo "<input type='hidden' name='gid' value='$gid'>\n";
echo "<input type='hidden' name='chng_uid' value='$chng_uid'>\n";
echo "<tr><td bgcolor='$bgcolor2'>"._GR_USRNAME.":</td><td bgcolor='$bgcolor1'><b>$uname</b></td></tr>\n";
echo "<tr><td bgcolor='$bgcolor2'>"._GR_USRMAIL.":</td><td bgcolor='$bgcolor1'><b>$uemail</b></td></tr>\n";
if($edate > 0) {
  $fday = date("j",$edate);
  $fmon = date("n",$edate);
  $fyear = date("Y",$edate);
  $fhour = date("G",$edate);
  $fmin = date("i",$edate);
} else {
  $fday = "00";
  $fmon = "00";
  $fyear = "0000";
  $fhour = "00";
  $fmin = "00";
}
echo "<tr><td bgcolor='$bgcolor2' valign='top'>"._GR_EXPIRES.":</td><td bgcolor='$bgcolor1'><select name='newmonth'>\n<option value='00'>--</option>\n";
for($i = 1; $i <= 12; $i++){
  if($i == $fmon){ $sel = "SELECTed"; } else { $sel = ""; }
  if($i < 10) { $r = "0".$i; } else { $r = $i; }
  echo "<option value='$r' $sel>$i</option>\n";
}
echo "</select><b>/</b><select name='newday'>\n<option value='00'>--</option>\n";
for($i = 1; $i <= 31; $i++){
  if($i == $fday){ $sel = "SELECTed"; } else { $sel = ""; }
  if($i < 10) { $r = "0".$i; } else { $r = $i; }
  echo "<option value='$r' $sel>$i</option>\n";
}
echo "</select><b>/</b><select name='newyear'>\n<option value='0000'>----</option>\n";
for($i = date("Y"); $i <= date("Y")+5; $i++){
  if($i == $fyear){ $sel = "SELECTed"; } else { $sel = ""; }
  if($i < 10) { $r = "0".$i; } else { $r = $i; }
  echo "<option value='$r' $sel>$i</option>\n";
}
echo "</select> <select name='newhour'>\n<option value='00'>--</option>\n";
for($i = 0; $i <= 23; $i++){
  if($i == $fhour AND $fhour > 0){ $sel = "SELECTed"; } else { $sel = ""; }
  if($i < 10) { $r = "0".$i; } else { $r = $i; }
  echo "<option value='$r' $sel>$i</option>\n";
}
echo "</select><b>:</b><select name='newmin'>\n<option value='00'>--</option>\n";
for($i = 0; $i <= 59; $i++){
  if($i == $fmin AND $fmin > 0){ $sel = "SELECTed"; } else { $sel = ""; }
  if($i < 10) { $r = "0".$i; } else { $r = $i; }
  echo "<option value='$r' $sel>$i</option>\n";
}
echo "</select><b>:00</b><br>"._GR_EXPIRENOTE."</td></tr>\n";
echo "<tr><td align='center' bgcolor='$bgcolor1' colspan='2'><input type='submit' value='"._GR_UPDATE." &quot;$uname&quot;'></td></tr>\n";
echo "</form></table></center>\n";
echo "<center>"._GOBACK."</center>\n";
CloseTable();
include("footer.php");

?>