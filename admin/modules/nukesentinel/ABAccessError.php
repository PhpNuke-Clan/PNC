<?php

/********************************************************/
/* NukeSentinel(tm)                                     */
/* By: NukeScripts(tm) (http://www.nukescripts.net)     */
/* Copyright © 2000-2008 by NukeScripts(tm)             */
/* See CREDITS.txt for ALL contributors                 */
/********************************************************/

if(!defined('NUKESENTINEL_ADMIN')) { header("Location: ../../../".$admin_file.".php"); }
$pagetitle = "- "._AB_NUKESENTINEL." ".$ab_config['version_number'].": Error Accessing Functions";
include("header.php");
title(_AB_NUKESENTINEL." ".$ab_config['version_number'].": Error Accessing Functions");
OpenTable();
echo '<center>'._AB_NOTAUTHORIZED.'</center>'."\n";
CloseTable();
include("footer.php");

?>