<?php

/********************************************************/
/* NSN GR Downloads                                     */
/* By: NukeScripts Network (webmaster@nukescripts.net)  */
/* http://www.nukescripts.net                           */
/* Copyright � 2000-2005 by NukeScripts Network         */
/************************************************************************/
/* PHP-Nuke Platinum: Expect to be impressed                  COPYRIGHT */
/*                                                                      */
/* Copyright (c) 2004 - 2006 by http://www.techgfx.com                  */
/*     Techgfx - Graeme Allan                       (goose@techgfx.com) */
/*                                                                      */
/* Copyright (c) 2004 - 2006 by http://www.conrads-berlin.de            */
/*     MrFluffy - Axel Conrads                 (axel@conrads-berlin.de) */
/*                                                                      */
/* Refer to TechGFX.com for detailed information on PHP-Nuke Platinum   */
/*                                                                      */
/* TechGFX: Your dreams, our imagination                                */
/************************************************************************/

$lid = intval($lid);
if(is_user($user)) {
  cookiedecode($user);
  $ratinguser = $cookie[1];
} else {
  $ratinguser = $anonymous;
}
$sub_ip = $_SERVER['REMOTE_ADDR'];
$db->sql_query("INSERT INTO ".$prefix."_nsngd_mods VALUES (NULL, $lid, 0, 0, '', '', '', '$ratinguser', '$sub_ip', 1, '', '', '', '', '')");
include("header.php");
menu(1);
echo "<br>\n";
OpenTable();
echo "<br><center>"._THANKSFORINFO."<br><br>"._LOOKTOREQUEST."</center><br>\n";
CloseTable();
include("footer.php");

?>