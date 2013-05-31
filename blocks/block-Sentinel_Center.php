<?php

/********************************************************/
/* NukeSentinel(tm)                                     */
/* By: NukeScripts(tm) (http://www.nukescripts.net)     */
/* Copyright © 2000-2008 by NukeScripts(tm)             */
/* See CREDITS.txt for ALL contributors                 */
/********************************************************/

if(!defined('NUKE_FILE') && !defined('BLOCK_FILE')) { header("Location: ../index.php"); }
global $db, $prefix, $ab_config;
$total_ips = $db->sql_numrows($db->sql_query('SELECT * FROM `'.$prefix.'_nsnst_blocked_ips`'));
if(!$total_ips) { $total_ips = 0; }
$content  = '<center><img src="images/nukesentinel/nukesentinel_large.png" alt="'._AB_WARNED.'" title="'._AB_WARNED.'" /><br />'._AB_HAVECAUGHT.' '.intval($total_ips).' '._AB_SHAMEFULHACKERS.'</center>'."\n";
$content .= '<hr /><center><a href="http://www.nukescripts.net" target="_blank">'._AB_NUKESENTINEL.'</a></center>'."\n";

?>