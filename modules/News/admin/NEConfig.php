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
$pagetitle = ": "._NE_NEWSCONFIG;
include("header.php");
NE_Admin(_NE_NEWSCONFIG);
echo "<br />\n";
OpenTable();
echo "<form action='".$admin_file.".php?op=NEConfigSave' method='post'>\n";
echo "<center>\n<table border='0' cellpadding='2' cellspacing='2'>\n";
echo "<tr><td align='center' bgcolor='$bgcolor2' colspan='2'><b>"._NE_GENERALSETTINGS."</b></td></tr>\n";
$assel1 = $assel2 = "";
if($ne_config['anonymous_submit'] == 1) { $apsel2 = " selected"; }
else { $apsel1 = " selected"; }
echo "<tr><td bgcolor='$bgcolor2'><b>"._NE_ANONYMOUSCANSUBMIT.":</b></td>\n<td><select name='xanonymous_submit'>\n";
echo "<option value='0'$assel1>"._NE_NO."</option>\n";
echo "<option value='1'$assel2>"._NE_YES."</option>\n";
echo "</select></td></tr>\n";
echo "<tr><td bgcolor='$bgcolor2' valign='top'><b>"._NE_ALLOWEDHTML.":</b></td><td>";
echo "<textarea name='xallowed_tags' rows='5' cols='20'>".$ne_config['allowed_tags']."</textarea></td></tr>\n";
echo "<tr>\n<td bgcolor='$bgcolor2'><b>"._NE_DISPLAYTYPE.":</b></td>\n<td><select name='xcolumns'>";
if($ne_config['columns'] == 0) { $ck1 = " selected"; $ck2 = ""; } else { $ck1 = ""; $ck2 = " selected"; }
echo "<option value='0'$ck1>"._NE_SINGLE."</option>\n<option value='1'$ck2>"._NE_DUAL."</option>\n</select></td>\n</tr>\n";
echo "<tr>\n<td bgcolor='$bgcolor2'><b>"._NE_READLINK.":</b></td>\n<td><select name='xreadmore'>";
if($ne_config['readmore'] == 0) { $ck1 = " selected"; $ck2 = ""; } else { $ck1 = ""; $ck2 = " selected"; }
echo "<option value='0'$ck1>"._NE_PAGE."</option>\n<option value='1'$ck2>"._NE_POPUP."</option>\n</select></td>\n</tr>\n";
echo "<tr>\n<td bgcolor='$bgcolor2'><b>"._NE_TEXTTYPE.":</b></td>\n<td><select name='xtexttype'>";
if($ne_config['texttype'] == 0) { $ck1 = " selected"; $ck2 = ""; } else { $ck1 = ""; $ck2 = " selected"; }
echo "<option value='0'$ck1>"._NE_COMPLETE."</option>\n<option value='1'$ck2>"._NE_TRUNCATE."</option>\n</select></td>\n</tr>\n";
echo "<tr>\n<td bgcolor='$bgcolor2' valign='top'><b>"._NE_NOTIFYAUTH.":</b></td>\n<td><select name='xnotifyauth'>";
if($ne_config['notifyauth'] == 0) { $ck1 = " selected"; $ck2 = ""; } else { $ck1 = ""; $ck2 = " selected"; }
echo "<option value='0'$ck1>"._NE_NO."</option>\n<option value='1'$ck2>"._NE_YES."</option>\n</select><br />\n("._NE_NOTIFYAUTHNOTE.")</td>\n</tr>\n";
echo "<tr>\n<td bgcolor='$bgcolor2'><b>"._NE_HOMETOPIC.":</b></td>\n<td><select name='xhometopic'>";
echo "<option value='0'";
if($ne_config['hometopic'] == 0) { echo " selected"; }
echo ">"._NE_ALLTOPICS."</option>\n";
$result = $db->sql_query("SELECT `topicid`, `topictext` FROM `".$prefix."_topics` ORDER BY `topictext`");
while(list($topicid, $topicname) = $db->sql_fetchrow($result)) {
  $topicid = intval($topicid);
  $topicname = ne_check_html(ne_convert_text($topicname), 0);
  echo "<option value='$topicid'";
  if($ne_config['hometopic'] == $topicid) { echo " selected"; }
  echo">$topicname</option>\n";
}
echo "</select></td>\n</tr>\n";
$db->sql_freeresult($result);
echo "<tr>\n<td bgcolor='$bgcolor2' valign='top'><b>"._NE_HOMENUMBER.":</b></td>\n<td><select name='xhomenumber'>\n";
$i = 1;
while($i <= 20) {
  echo "<option value='$i'";
  if($ne_config['homenumber'] == $i) { echo " selected"; }
  echo">$i ";
  if($i == 1) { echo _NE_ARTICLE; } else { echo _NE_ARTICLES; }
  echo "</option>\n";
  $i++;
}
echo "</select><br />\n("._NE_HOMENUMNOTE.")</td>\n</tr>\n";
echo "<tr>\n<td bgcolor='$bgcolor2' valign='top'><b>"._NE_OLDNUMBER.":</b></td>\n<td><select name='xoldnumber'>\n";
$i = 11;
while($i <= 40) {
  echo "<option value='$i'";
  if($ne_config['oldnumber'] == $i) { echo " selected"; }
  echo">$i ";
  if($i == 0) { echo _NE_ARTICLE; } else { echo _NE_ARTICLES; }
  echo "</option>\n";
  $i++;
}
echo "</select><br />\n("._NE_OLDNUMNOTE.")</td>\n</tr>\n";

echo "<tr><td align='center' colspan='2'>&nbsp;</td></tr>\n";
echo "<tr><td align='center' bgcolor='$bgcolor2' colspan='2'><b>"._NE_ARTICLEPAGESETTINGS."</b></td></tr>\n";
$apsel1 = $apsel2 = "";
if($ne_config['allow_polls'] == 1) { $apsel2 = " selected"; }
else { $acsel1 = " selected"; }
echo "<tr><td bgcolor='$bgcolor2'><b>"._NE_ALLOWPOLLS.":</b></td>\n<td><select name='xallow_polls'>\n";
echo "<option value='0'$apsel1>"._NE_NO."</option>\n";
echo "<option value='1'$apsel2>"._NE_YES."</option>\n";
echo "</select></td></tr>\n";
$arsel1 = $arsel2 = "";
if($ne_config['allow_rating'] == 1) { $arsel2 = " selected"; }
else { $acsel1 = " selected"; }
echo "<tr><td bgcolor='$bgcolor2'><b>"._NE_ALLOWRATING.":</b></td>\n<td><select name='xallow_rating'>\n";
echo "<option value='0'$arsel1>"._NE_NO."</option>\n";
echo "<option value='1'$arsel2>"._NE_YES."</option>\n";
echo "</select></td></tr>\n";
$alsel1 = $alsel2 = "";
if($ne_config['allow_related'] == 1) { $alsel2 = " selected"; }
else { $acsel1 = " selected"; }
echo "<tr><td bgcolor='$bgcolor2'><b>"._NE_ALLOWRELATED.":</b></td>\n<td><select name='xallow_related'>\n";
echo "<option value='0'$alsel1>"._NE_NO."</option>\n";
echo "<option value='1'$alsel2>"._NE_YES."</option>\n";
echo "</select></td></tr>\n";

echo "<tr><td align='center' colspan='2'>&nbsp;</td></tr>\n";
echo "<tr><td align='center' bgcolor='$bgcolor2' colspan='2'><b>"._NE_COMMENTDISPLAYSETTINGS."</b></td></tr>\n";
$apsel1 = $apsel2 = "";
if($ne_config['anonymous_post'] == 1) { $apsel2 = " selected"; }
else { $apsel1 = " selected"; }
echo "<tr><td bgcolor='$bgcolor2'><b>"._NE_ANONYMOUSCANPOST.":</b></td>\n<td><select name='xanonymous_post'>\n";
echo "<option value='0'$apsel1>"._NE_NO."</option>\n";
echo "<option value='1'$apsel2>"._NE_YES."</option>\n";
echo "</select></td></tr>\n";
$acsel1 = $acsel2 = "";
if($ne_config['allow_comments'] == 1) { $acsel2 = " selected"; }
else { $acsel1 = " selected"; }
echo "<tr><td bgcolor='$bgcolor2'><b>"._NE_ALLOWCOMMENTS.":</b></td>\n<td><select name='xallow_comments'>\n";
echo "<option value='0'$acsel1>"._NE_NO."</option>\n";
echo "<option value='1'$acsel2>"._NE_YES."</option>\n";
echo "</select></td></tr>\n";
$clsel1 = $clsel2 = $clsel3 = $clsel4 = $clsel5 = $clsel6 = $clsel7 = "";
if($ne_config['comment_limit'] == 2048) { $clsel1 = " selected"; }
elseif($ne_config['comment_limit'] == 3072) { $clsel2 = " selected"; }
elseif($ne_config['comment_limit'] == 4096) { $clsel3 = " selected"; }
elseif($ne_config['comment_limit'] == 5120) { $clsel4 = " selected"; }
elseif($ne_config['comment_limit'] == 6144) { $clsel5 = " selected"; }
elseif($ne_config['comment_limit'] == 7168) { $clsel6 = " selected"; }
elseif($ne_config['comment_limit'] == 8192) { $clsel7 = " selected"; }
echo "<tr><td bgcolor='$bgcolor2'><b>"._NE_COMMENTLIMIT.":</b></td>\n<td><select name='xcomment_limit'>\n";
echo "<option value='2048'$clsel1>2,048 "._NE_BYTES."</option>\n";
echo "<option value='3072'$clsel2>3,072 "._NE_BYTES."</option>\n";
echo "<option value='4096'$clsel3>4,096 "._NE_BYTES."</option>\n";
echo "<option value='5120'$clsel4>5,120 "._NE_BYTES."</option>\n";
echo "<option value='6144'$clsel5>6,144 "._NE_BYTES."</option>\n";
echo "<option value='7168'$clsel6>7,168 "._NE_BYTES."</option>\n";
echo "<option value='8192'$clsel7>8,192 "._NE_BYTES."</option>\n";
echo "</select></td></tr>\n";
$tsel1 = $tsel2 = $tsel3 = $tsel4 = $tsel5 = $tsel6 = $tsel7 = "";
if($ne_config['default_thold'] == -1) { $tsel1 = " selected"; }
elseif($ne_config['default_thold'] == 0) { $tsel2 = " selected"; }
elseif($ne_config['default_thold'] == 1) { $tsel3 = " selected"; }
elseif($ne_config['default_thold'] == 2) { $tsel4 = " selected"; }
elseif($ne_config['default_thold'] == 3) { $tsel5 = " selected"; }
elseif($ne_config['default_thold'] == 4) { $tsel6 = " selected"; }
elseif($ne_config['default_thold'] == 5) { $tsel7 = " selected"; }
echo "<tr><td bgcolor='$bgcolor2'><b>"._NE_THRESHOLD.":</b></td>\n<td><select name='xdefault_thold'>\n";
echo "<option value='-1'$tsel1>-1</option>\n";
echo "<option value='0'$tsel2>0</option>\n";
echo "<option value='1'$tsel3>1</option>\n";
echo "<option value='2'$tsel4>2</option>\n";
echo "<option value='3'$tsel5>3</option>\n";
echo "<option value='4'$tsel6>4</option>\n";
echo "<option value='5'$tsel7>5</option>\n";
echo "</select></td></tr>\n";
$msel1 = $msel2 = $msel3 = $msel4 = "";
if($ne_config['default_mode'] == 'nocomments') { $msel1 = " selected"; }
elseif($ne_config['default_mode'] == 'nested') { $msel2 = " selected"; }
elseif($ne_config['default_mode'] == 'flat') { $msel3 = " selected"; }
elseif($ne_config['default_mode'] == 'thread') { $msel4 = " selected"; }
echo "<tr><td bgcolor='$bgcolor2'><b>"._NE_MODE.":</b></td>\n<td><select name='xdefault_mode'>";
echo "<option value='nocomments'$msel1>"._NE_NOCOMMENTS."</option>\n";
echo "<option value='nested'$msel2>"._NE_NESTED."</option>\n";
echo "<option value='flat'$msel3>"._NE_FLAT."</option>\n";
echo "<option value='thread'$msel4>"._NE_THREAD."</option>\n";
echo "</select></td></tr>\n";
$osel1 = $osel2 = $osel3 = "";
if($ne_config['default_order'] == 0) { $osel1 = " selected"; }
elseif($ne_config['default_order'] == 1) { $osel2 = " selected"; }
elseif($ne_config['default_order'] == 2) { $osel3 = " selected"; }
echo "<tr><td bgcolor='$bgcolor2'><b>"._NE_ORDER.":</b></td>\n<td><select name='xdefault_order'>";
echo "<option value='0'$osel1>"._NE_OLDEST."</option>\n";
echo "<option value='1'$osel2>"._NE_NEWEST."</option>\n";
echo "<option value='2'$osel3>"._NE_HIGHEST."</option>\n";
echo "</select></td></tr>\n";

echo "<tr><td align='center' colspan='2'>&nbsp;</td></tr>\n";
echo "<tr><td align='center' bgcolor='$bgcolor2' colspan='2'><b>"._NE_COMMENTNOTIFYSETTINGS."</b></td></tr>\n";
$asel1 = $asel2 = "";
if($ne_config['notify_admin'] == 1) { $asel2 = " selected"; }
else { $asel1 = " selected"; }
echo "<tr><td bgcolor='$bgcolor2'><b>"._NE_NOTIFYADMIN.":</b></td>\n<td><select name='xnotify_admin'>\n";
echo "<option value='0'$asel1>"._NE_NO."</option>\n";
echo "<option value='1'$asel2>"._NE_YES."</option>\n";
echo "</select></td></tr>\n";
$psel1 = $psel2 = "";
if($ne_config['notify_poster'] == 1) { $psel2 = " selected"; }
else { $psel1 = " selected"; }
echo "<tr><td bgcolor='$bgcolor2'><b>"._NE_NOTIFYPOSTER.":</b></td>\n<td><select name='xnotify_poster'>\n";
echo "<option value='0'$psel1>"._NE_NO."</option>\n";
echo "<option value='1'$psel2>"._NE_YES."</option>\n";
echo "</select></td></tr>\n";
$isel1 = $isel2 = "";
if($ne_config['notify_informant'] == 1) { $isel2 = " selected"; }
else { $isel1 = " selected"; }
echo "<tr><td bgcolor='$bgcolor2'><b>"._NE_NOTIFYINFORMANT.":</b></td>\n<td><select name='xnotify_informant'>\n";
echo "<option value='0'$isel1>"._NE_NO."</option>\n";
echo "<option value='1'$isel2>"._NE_YES."</option>\n";
echo "</select></td></tr>\n";
$csel1 = $csel2 = "";
if($ne_config['notify_commenter'] == 1) { $csel2 = " selected"; }
else { $csel1 = " selected"; }
echo "<tr><td bgcolor='$bgcolor2'><b>"._NE_NOTIFYCOMMENTER.":</b></td>\n<td><select name='xnotify_commenter'>\n";
echo "<option value='0'$csel1>"._NE_NO."</option>\n";
echo "<option value='1'$csel2>"._NE_YES."</option>\n";
echo "</select></td></tr>\n";

echo "<tr><td align='center' colspan='2'>&nbsp;</td></tr>\n";
echo "<tr><td align='center' bgcolor='$bgcolor2' colspan='2'><b>"._NE_CENSOROPTIONS."</b></td></tr>\n";
echo "<tr><td bgcolor='$bgcolor2'><b>"._NE_CENSORMODE.":</b></td><td>";
$sel0 = $sel1 = "";
if($ne_config['censor_mode'] == 0) {
  $sel0 = "selected";
} elseif($ne_config['censor_mode'] == 1) {
  $sel1 = "selected";
}
echo "<select name='xcensor_mode'>";
echo "<option name='xcensor_mode' value='0' $sel0>"._NE_NOFILTERING."</option>";
echo "<option name='xcensor_mode' value='1' $sel1>"._NE_MATCHANY."</option>";
echo "</select></td></tr>\n";
echo "<tr><td bgcolor='$bgcolor2'><b>"._NE_CENSORREPLACE.":</b></td><td>";
echo "<input type='text' name='xcensor_replace' value='".$ne_config['censor_replace']."' size='5' maxlength='4'></td></tr>\n";
echo "<tr><td bgcolor='$bgcolor2' valign='top'><b>"._NE_CENSORLIST.":</b><br />"._NE_CENSORLISTNOTE."</td>\n";
echo "<td><textarea name='xcensor_list' rows='5' cols='20'>".$ne_config['censor_list']."</textarea></td></tr>\n";

if($radminsuper == 1) {
  echo "<tr><td align='center' colspan='2'>&nbsp;</td></tr>\n";
  echo "<tr><td align='center' bgcolor='$bgcolor2' colspan='2'><b>"._NE_PREAPPROVEDUSERS."</b><br />"._NE_ARTFROM."</td></tr>\n";
  echo "<tr><td bgcolor='$bgcolor2' valign='top'><b>"._NE_APPROVEDUSERS.":</b><br />"._NE_APPROVEDUSERSNOTE."</td>\n";
  echo "<td><textarea name='xapproved_users' rows='5' cols='20'>".$ne_config['approved_users']."</textarea></td></tr>\n";
  echo "<tr><td bgcolor='$bgcolor2'><b>"._NE_POSTINGADMIN.":</b></td>\n<td><select name='xposting_admin'>";
  echo "<option value=''>"._NE_SELECTONE."</option>\n";
  $result = $db->sql_query("SELECT * FROM `".$prefix."_authors` ORDER BY `aid`");
  while($ainfo = $db->sql_fetchrow($result)) {
    if($ainfo['aid'] == $ne_config['posting_admin']) { $pasel = " selected"; } else { $pasel = ""; }
    echo "<option value='".$ainfo['aid']."'$pasel>".$ainfo['aid']."</option>\n";
  }
  echo "</select></td></tr>\n";
  $db->sql_freeresult($result);
}

echo "<tr><td align='center' colspan='2'><input type='submit' value='"._NE_SAVECHANGES."'></td></tr>\n";
echo "</table>\n</center>\n</form>\n";
CloseTable();
ne_copy();
include("footer.php");

?>