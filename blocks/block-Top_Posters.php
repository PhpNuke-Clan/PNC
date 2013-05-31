<?php

/************************************************************************/
/* PHP-NUKE: Web Portal System                                          */
/* ===========================                                          */
/*                                                                      */
/* Copyright (c) 2002 by Francisco Burzi (fbc@mandrakesoft.com)         */
/* http://phpnuke.org                                                   */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/**********************************************************************************************/
/* PNC 3.0.0: PHOENIX Edition                                 COPYRIGHT                       */
/*                                                                                            */
/* Copyright (c) 2005 - 2006 by http://phpnuke-clan.com                                       */
/*  PHPNUKE-CLAN - SUPPORT                (support@phpnuke-clan.com)                          */
/*  PNC 3.0.0  Online Installation Guide - http://www.phpnuke-clan.com/guide/3.0.0/index.htm  */
/**********************************************************************************************/
/************************************************************************/
/* block-Top_Posters.php                                                */
/* ===========================                                          */
/*                                                                      */
/* Copyright (c) 2003 by chatserv (chatserv@nukeresources.com)          */
/* http://nukeresources.com                                             */
/************************************************************************/
/* Cosmetic changes by dvsDave at webmaster@controlbooth.com            */
/* http://controlbooth.com                                              */
/************************************************************************/

if (eregi("block-Top_Posters.php", $_SERVER['PHP_SELF'])) {
    Header("Location: index.php");
    die();
}
$a = 1;
    global $user, $cookie, $sitename, $prefix, $user_prefix, $dbi, $admin, $module_name;
    $result=sql_query("SELECT user_id, username, user_posts, user_avatar FROM ".$user_prefix."_users ORDER BY user_posts DESC LIMIT 0,5", $dbi);
    while(list($user_id, $username, $user_posts, $user_avatar) = sql_fetch_row($result, $dbi)) {
$content .= "<div align=\"left\"><table class=\"outer\" cellpadding=\"0\" style=\"border-collapse: collapse\" bordercolor=\"#111111\" cellspacing=\"1\" border=\"0\">";
$content .= "<tr class=\"even\" vAlign=\"middle\">";
$content .= "<td align=\"middle\">";
if ($user_avatar=="") {
$content .= "&nbsp;&nbsp;<a href=\"modules.php?name=Forums&file=profile&mode=viewprofile&u=$user_id\"><img alt src=\"modules/Forums/images/avatars/noimage.gif\" border =\"0\" width=\"32\"></a></td>";
}
else
if (eregi("http://", $user_avatar)) {
$content .= "&nbsp;&nbsp;<a href=\"modules.php?name=Forums&amp;file=profile&amp;mode=viewprofile&amp;u=$user_id\"><img alt src=\"$user_avatar\" border =\"0\" width=\"32\"></a></td>";
}
else
$content .= "&nbsp;&nbsp;<a href=\"modules.php?name=Forums&amp;file=profile&amp;mode=viewprofile&amp;u=$user_id\"><img alt src=\"modules/Forums/images/avatars/$user_avatar\" border =\"0\" width=\"32\"></a></td>";
$content .= "<td align=\"middle\">&nbsp;<a href=\"modules.php?name=Forums&amp;file=profile&amp;mode=viewprofile&amp;u=$user_id\"><b>$username</b></a>&nbsp;<br>&nbsp;<a href=\"modules.php?name=Forums&amp;file=search&amp;search_author=$username\">Posts:</a>&nbsp;<br>";
$content .= "&nbsp;<a href=\"modules.php?name=Forums&amp;file=search&amp;search_author=$username\">$user_posts</a>&nbsp;</td>";
$content .= "</tr>";
$content .= "</table></div><hr>";
}

?>