<?php

/*********************************************************************************/
/* CNB Your Account: An Advanced User Management System for phpnuke     		*/
/* ============================================                         		*/
/*                                                                      		*/
/* Copyright (c) 2004 by Comunidade PHP Nuke Brasil                     		*/
/* http://dev.phpnuke.org.br & http://www.phpnuke.org.br                		*/
/*                                                                      		*/
/* Contact author: escudero@phpnuke.org.br                              		*/
/* International Support Forum: http://ravenphpscripts.com/forum76.html 		*/
/*                                                                      		*/
/* This program is free software. You can redistribute it and/or modify 		*/
/* it under the terms of the GNU General Public License as published by 		*/
/* the Free Software Foundation; either version 2 of the License.       		*/
/*                                                                      		*/
/*********************************************************************************/
/* CNB Your Account it the official successor of NSN Your Account by Bob Marion	*/
/*********************************************************************************/

if (!defined('YA_ADMIN')) { echo "CNBYA admin protection"; exit; }
if (!eregi("modules.php", $_SERVER['SCRIPT_NAME'])) {
    header("Location: ../../../index.php");
    die ();
}
if (!defined('CNBYA')) { echo "CNBYA protection"; exit; }
if (($radminsuper==1) OR ($radminuser==1)) {

    list($email) = $db->sql_fetchrow($db->sql_query("SELECT user_email FROM ".$user_prefix."_users_temp WHERE user_id='$dny_uid'"));
    if ($ya_config['servermail'] == 0) {
        $message = _SORRYTO." $sitename "._HASDENY;
        if ($denyreason > "") {
            $denyreason = stripslashes($denyreason);
            $message .= "\r\n\r\n"._DENYREASON."\r\n$denyreason";
        }
        $subject = _ACCTDENY;
        $from  = "From: $adminmail\r\n";
        $from .= "Reply-To: $adminmail\r\n";
        $from .= "Return-Path: $adminmail\r\n";
        mail($email, $subject, $message, $from);
    }
    $db->sql_query("DELETE FROM ".$user_prefix."_users_temp WHERE user_id='$dny_uid'");
    $db->sql_query("DELETE FROM ".$user_prefix."_cnbya_value_temp WHERE uid='$dny_uid'");
	$db->sql_query("OPTIMIZE TABLE ".$user_prefix."_users_temp");
    $db->sql_query("OPTIMIZE TABLE ".$user_prefix."_cnbya_value_temp");
	$pagetitle = ": "._USERADMIN." - "._ACCTDENY;
    include("header.php");
    amain();
    echo "<br>\n";
    OpenTable();
    echo "<center><table align='center' border='0' cellpadding='2' cellspacing='2'>\n";
    echo "<form action='modules.php?name=$module_name&file=admin' method='post'>\n";
    if (isset($query)) { echo "<input type='hidden' name='query' value='$query'>\n"; }
    if (isset($min)) { echo "<input type='hidden' name='min' value='$min'>\n"; }
    if (isset($xop)) { echo "<input type='hidden' name='op' value='$xop'>\n"; }
    echo "<tr><td align='center'><b>"._ACCTDENY."</b></td></tr>\n";
    echo "<tr><td align='center'><input type='submit' value='"._RETURN2."'></td></tr>\n";
    echo "</form>\n";
    echo "</table></center>\n";
    CloseTable();
    include("footer.php");

}

?>