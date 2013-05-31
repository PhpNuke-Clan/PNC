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
if(empty($title)) { header("Location: ".$admin_file.".php?op=NECategoryEdit&catid=$catid"); }
$title = stripslashes(ne_check_html(ne_convert_text($title), 0));
$catid = intval($catid);
$result = $db->sql_query("SELECT `catid` FROM `".$prefix."_stories_cat` WHERE `title`='$title'");
$numrows = $db->sql_numrows($result);
$db->sql_freeresult($result);
if($numrows > 0) {
  include("header.php");
  NE_Admin(_NE_CATEGORIES." "._NE_ADMIN.": "._NE_CATEGORYEDIT);
  echo "<br />\n";
  OpenTable();
  echo "<center class='title'><b>"._NE_CATEGORYEXISTS."</b></center>\n";
  CloseTable();
  ne_copy();
  include("footer.php");
  $db->sql_freeresult($result);
} else {
  if(!get_magic_quotes_runtime()) { $title = addslashes($title); }
  $result = $db->sql_query("UPDATE `".$prefix."_stories_cat` SET `title`='$title' WHERE `catid`='$catid'");
  if(!$result) {
    include("header.php");
    NE_Admin(_NE_CATEGORIES." "._NE_ADMIN.": "._NE_CATEGORYEDIT);
    echo "<br />\n";
    OpenTable();
    echo "<center class='title'><b>"._NE_DBERROR."</b></center>\n";
    CloseTable();
    ne_copy();
    include("footer.php");
  } else {
    $db->sql_freeresult($result);
    header("Location: ".$admin_file.".php?op=NECategoryIndex");
  }
}

?>