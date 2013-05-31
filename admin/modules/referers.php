<?php

/************************************************************************/
/* PHP-NUKE: Web Portal System                                          */
/* ===========================                                          */
/*                                                                      */
/* Copyright (c) 2002 by Francisco Burzi                                */
/* http://phpnuke.org                                                   */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/*                                                                      */
/************************************************************************/
/*         Additional security & Abstraction layer conversion           */
/*                           2003 chatserv                              */
/*      http://www.nukefixes.com -- http://www.nukeresources.com        */
/************************************************************************/

if ( !defined('ADMIN_FILE') )
{
	die ("Access Denied");
}
global $prefix, $db, $admin_file;
$aid = substr("$aid", 0,25);
$row = $db->sql_fetchrow($db->sql_query("SELECT radminsuper FROM " . $prefix . "_authors WHERE aid='$aid'"));
if ($row['radminsuper'] == 1) {

/*********************************************************/
/* Referer Functions to know who links us                */
/*********************************************************/

function hreferer() {
    global $bgcolor2, $prefix, $db, $admin_file;
    include("header.php");
    GraphicAdmin();
    OpenTable();
    echo "<center><font class=\"title\"><b>" . _HTTPREFERERS . "</b></font></center>";
    CloseTable();
    echo "<br>";
    OpenTable();
    echo "<center><b>" . _WHOLINKS . "</b></center><br><br>"
	."<table border=\"0\" width=\"100%\">";
    $result = $db->sql_query("SELECT rid, url from " . $prefix . "_referer");
    while ($row = $db->sql_fetchrow($result)) {
	$rid = intval($row['rid']);
	$url = $row['url'];
	echo "<tr><td bgcolor=\"$bgcolor2\"><font class=\"content\">$rid</td>"
	    ."<td bgcolor=\"$bgcolor2\"><font class=\"content\"><a href=\"index.php?url=$url\" target=\"_blank\">$url</a></td></tr>";
    }
    echo "</table>"
	."<form action=\"".$admin_file.".php\" method=\"post\">"
	."<input type=\"hidden\" name=\"op\" value=\"delreferer\">"
	."<center><input type=\"submit\" value=\"" . _DELETEREFERERS . "\"></center>";
    CloseTable();
    include("footer.php");
}

function delreferer() {
    global $prefix, $db, $admin_file;
    $db->sql_query("delete from " . $prefix . "_referer");
    Header("Location: ".$admin_file.".php?op=adminMain");
}

switch($op) {

    case "hreferer":
    hreferer();
    break;

    case "delreferer":
    delreferer();
    break;

}

} else {
    echo "Access Denied";
}
?>