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

if(!defined('NSNNE_PUBLIC')) { die("Illegal File Access Detected!!"); }
if($neconfig['allow_polls'] == 1) {
  $score = intval($score);
  $sid = intval($sid);
  $modlink = str_replace("&amp;", "&", $module_link);
  if($score) {
    if($score > 5) { $score = 5; }
    if($score < 1) { $score = 1; }
    if($score != 1 AND $score != 2 AND $score != 3 AND $score != 4 AND $score != 5) {
      header("Location: $nukeurl");
      die();
    }
    if(isset($ratecookie)) {
      $rcookie = base64_decode($ratecookie);
      $rcookie = addslashes($rcookie);
      $r_cookie = explode(":", $rcookie);
    }
    for($i=0; $i < sizeof($r_cookie); $i++) {
      if($r_cookie[$i] == $sid) { $a = 1; }
    }
    if($a == 1) {
      header("Location: ".$modlink."op=NERateDone&sid=$sid&rated=1");
    } else {
      $result = $db->sql_query("UPDATE `".$prefix."_stories` SET `score`=`score`+$score, `ratings`=`ratings`+1 WHERE `sid`='$sid'");
      $info = base64_encode("$rcookie$sid:");
      setcookie("ratecookie","$info",time()+3600);
      update_points(7);
      header("Location: ".$modlink."op=NERateDone&sid=$sid$r_options");
    }
  } else {
    include("header.php");
    title("$sitename: "._NE_ARTICLERATING."");
    OpenTable();
    echo "<center class='title'>"._NE_DIDNTRATE."</center><br>\n";
    echo "<center>"._GOBACK."</center>\n";
    CloseTable();
    include("footer.php");
  }
} else {
  header("Location: ".$modlink."op=NERateDone&sid=$sid$r_options");
}

?>