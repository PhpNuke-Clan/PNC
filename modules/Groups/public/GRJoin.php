<?php

/********************************************************/
/* NSN Groups                                           */
/* By: NukeScripts Network (webmaster@nukescripts.net)  */
/* http://www.nukescripts.net                           */
/* Copyright © 2000-2005 by NukeScripts Network         */
/********************************************************/

if(!defined('MODULE_FILE')) { die("Illegal Access Detected!!!"); }
include("header.php");
$result = $db->sql_query("SELECT `glimit`, `gpublic`, `phpBB` FROM `".$prefix."_nsngr_groups` WHERE `gid`='$gid'");
list($glimit, $gpublic, $phpBB) = $db->sql_fetchrow($result);
$numusers = $db->sql_numrows($db->sql_query("SELECT `uid` FROM `".$prefix."_nsngr_users` WHERE `gid`='$gid'"));
cookiedecode($user);
$uid = $cookie[0];
$uname = $cookie[1];
$gid = intval($gid);
title(_GR_GROUPJOIN);
OpenTable();
if(is_ingroup($uid,$gid)) {
  echo "<center><b>"._GR_INGROUP."</b></center><br>\n";
  echo "<center>"._GOBACK."</center>\n";
} elseif($gpublic == 1 || $gpublic == 2) {
  echo "<center><b>"._GR_NOTPUBLIC."</b></center><br>\n";
  echo "<center>"._GOBACK."</center>\n";
} elseif($glimit <= $numusers AND $glimit != 0) {
  echo "<center><b>"._GR_GROUPFILLED."</b></center><br>\n";
  echo "<center>"._GOBACK."</center>\n";
} elseif($uid > 0) {
  $xdate = time();
  $db->sql_query("INSERT INTO `".$prefix."_nsngr_users` (`gid`, `uid`, `uname`, `sdate`) VALUES ('$gid', '$uid', '$uname', '$xdate')");
  $db->sql_query("INSERT INTO `".$prefix."_bbuser_group` (`group_id`, `user_id`, user_pending) VALUES ('$phpBB', '$uid', '0')");
  echo "<center><b>"._GR_ADDGROUP."</b></center><br>\n";
  echo "<center>"._GOBACK."</center>\n";
} else {
  echo "<center><b>"._GR_MUSTBEUSER."</b></center><br>\n";
  echo "<center>"._GOBACK."</center>\n";
}
CloseTable();
include("footer.php");

?>