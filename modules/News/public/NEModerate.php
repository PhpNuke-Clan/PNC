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
if((is_admin($admin)) || ($moderate == 2)) {
  while(list($tdw, $emp) = each($HTTP_POST_VARS)) {
    if(eregi("dkn",$tdw)) {
      $emp = explode(":", $emp);
      if($emp[1] != 0) {
        $tdw = ereg_replace("dkn", "", $tdw);
        $emp[0] = intval($emp[0]);
        $emp[1] = intval($emp[1]);
        $tdw = intval($tdw);
        $q = "UPDATE `".$prefix."_comments` SET";
        if(($emp[1] == 9) && ($emp[0]>=0)) { # Overrated
          $q .= " `score`=`score`-1 WHERE `tid`='$tdw'";
        } elseif(($emp[1] == 10) && ($emp[0]<=4)) { # Underrated
          $q .= " `score`=`score`+1 WHERE `tid`='$tdw'";
        } elseif(($emp[1] > 4) && ($emp[0]<=4)) {
          $q .= " `score`=`score`+1, `reason`='$emp[1]' WHERE `tid`='$tdw'";
        } elseif(($emp[1] < 5) && ($emp[0] > -1)) {
          $q .= " `score`=`score`-1, `reason`='$emp[1]' WHERE `tid`='$tdw'";
        } elseif(($emp[0] == -1) || ($emp[0] == 5)) {
          $q .= " `reason`=$emp[1] WHERE `tid`='$tdw'";
        }
        if(stristr($q, "where")) $db->sql_query($q);
      }
    }
  }
}
header("Location: ".$module_link."op=NEArticle&sid=$sid");

?>