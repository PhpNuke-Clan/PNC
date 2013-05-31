<?php

/********************************************************/
/* NukeSentinel(tm)                                     */
/* By: NukeScripts(tm) (http://www.nukescripts.net)     */
/* Copyright © 2000-2008 by NukeScripts(tm)             */
/* See CREDITS.txt for ALL contributors                 */
/********************************************************/

if(!defined('NUKESENTINEL_ADMIN')) { header("Location: ../../../".$admin_file.".php"); }
$pagetitle = _AB_NUKESENTINEL.": "._AB_VIEWTEMPLATE;
if(empty($template)) { $template = "abuse_default.tpl"; }
$filename = "abuse/".$template;
if(!file_exists($filename)) { $filename = "abuse/abuse_default.tpl"; }
include("header.php");
OpenTable();
OpenMenu(_AB_VIEWTEMPLATE);
mastermenu();
CarryMenu();
templatemenu();
CloseMenu();
CloseTable();
echo '<br />'."\n";
OpenTable();
echo '<center class="title">'._AB_SOURCEOF.' '.$template.'<br /></center>'."\n";
echo '<center class="content"><strong>'._AB_NOTEDITOR.'</strong></center><br />'."\n";
$handle = @fopen($filename, "r");
$templatefile = fread($handle, filesize($filename));
@fclose($handle);
echo '<center><textarea rows="30" cols="70" readonly="readonly">'.htmlentities($templatefile, ENT_QUOTES).'</textarea></center>'."\n";
CloseTable();
include("footer.php");

?>