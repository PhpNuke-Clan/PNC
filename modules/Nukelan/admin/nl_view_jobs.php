<?php
// filename: view_jobs.php

if (!defined('ADMIN_FILE')) {
	die ("Access Denied");
}
include ("header.php");

lan_menu();
OpenTable();
global $db, $prefix, $admin_file;
if ($chg) foreach ($chg as $user) {
   $status = $db->sql_fetchrow($db->sql_query("SELECT approve FROM nukelan_staff WHERE userid='$user' AND jobid='$job_id'"));
   if ($status[approve] >= '1') $pd = '0';
   else $pd = '1';
   
   if (!$db->sql_query("UPDATE nukelan_staff SET approve='$pd' WHERE userid='$user' AND jobid='$job_id'")) $error .= ""._NLCANNOTUPDATEUSER."$user status.<br>";
   }

if ($delusr) foreach ($delusr as $user) {
   if (!$db->sql_query("DELETE FROM nukelan_staff WHERE userid='$user' AND jobid='$job_id'")) $error .= ""._NLCANNOTDELETEUSER."$user.";
   }
if ($lan_add_user_by_id) {
   $anote = ""._NLADDEDBYADMIN."";
   if ($db->sql_numrows($db->sql_query("SELECT userid FROM nukelan_staff WHERE userid='$lan_add_user_by_id' AND jobid='$job_id'"))) $error .= ""._NLUSERALREADYAPPLIED."";
   elseif (!$db->sql_query("INSERT INTO nukelan_staff SET userid='$lan_add_user_by_id', jobid='$job_id', approve='1', unotes='$anote'")) $error .= ""._NLQUERYFAILED."";
   }

if ($lan_add_user_by_uname) {
   $usr = $db->sql_fetchrow($db->sql_query("SELECT user_id FROM nuke_users WHERE username='$lan_add_user_by_uname'"));
   $anote = ""._NLADDEDBYADMIN."";
   if (!$usr) $error .= ""._NLUSERNAMENOTEXIST."";
   elseif ($db->sql_numrows($db->sql_query("SELECT userid FROM nukelan_staff WHERE userid='$usr[user_id]' AND jobid='$job_id'"))) $error .= ""._NLUSERALREADYAPPLIED."";
   elseif (!$db->sql_query("INSERT INTO nukelan_staff SET userid='$usr[user_id]', jobid='$job_id', approve='1', unotes='$anote'")) $error .= ""._NLQUERYFAILED."";
   }

echo " <h3>$job_name - "._NLPOSITION."</h3>\n"
    ." $error\n"
    ." <form action=\"".$admin_file.".php\" method=\"post\">\n"
    ."  <input type=hidden name=op value=usr_status_jobs>\n"
    ."  <input type=hidden name=job_id value=\"$job_id\">\n"
    ."  <input type=hidden name=job_name value=\"$job_name\">\n"
    ." <table border=0 cellpadding=3 cellspacing=1 bgcolor=\"$bgcolor1\" width=\"100%\">\n"
    ."  <tr style=\"background-color: $bgcolor2; color: $textcolor1; font-weight: bold;\">\n"
    ."   <td width=\"30%\">"._NLUSERNAME."</td>\n"
    ."   <td width=\"50%\">"._NLNOTES."</td>\n"
    ."   <td width=\"10%\" align=center>"._NLSTATUS."</td>\n"
    ."   <td width=\"5%\" align=center>"._NLCHG."</td>\n"
    ."   <td width=\"5%\" align=center>"._NLDEL."</td>\n".$pntable[lanparty]
    ."  </tr>\n";

$result = $db->sql_query("SELECT l.*, u.* FROM nukelan_staff AS l LEFT JOIN nuke_users AS u ON (l.userid=u.user_id) WHERE l.jobid='$job_id' ORDER BY u.username");
if(!$db->sql_numrows($result)) echo "<tr><td colspan=3 align=center>"._NLNOAPPLICANTS."</td></tr>";
else {
   $bc = $bgcolor3;
   while($usr = $db->sql_fetchrow($result)) {
      if ($bc == $bgcolor3) $bc = $bgcolor4;
      else $bc = $bgcolor3;
      echo "  <tr bgcolor=\"$bc\">\n"
          ."   <td>";
      echo "<a href=\"modules.php?name=Forums&file=profile&mode=viewprofile&u=$usr[user_id]\">$usr[username]</a>";
      echo " [<a href=\"mailto:$usr[user_email]\">"._NLEMAIL4."</a>]";
      echo "</td>\n"
          ."   <td>";
      echo "$usr[unotes]\n";
      echo "</td>\n"
          ."   <td align=center>";
      if ($usr[approve] == '1') echo "<font color=green>"._NLAPPROVED."</font";
      else echo "<font color=red>"._NLPENDING."</font>";
      echo "</td>\n"
          ."   <td align=center><input type=checkbox name=chg[] value=$usr[userid]></td>\n"
          ."   <td align=center><input type=checkbox name=delusr[] value=$usr[userid]></td>\n"
          ."  </tr>\n";
      }
   }
echo " </table>\n"
    ." <br>\n"
    ."  <input type=submit value=\""._NLSUBMITCHANGES."\">\n"
    ." </form>\n";
CloseTable();
echo " <br>\n";
OpenTable();
echo " <form action=\"".$admin_file.".php\" method=\"post\">\n"
    ."  <input type=hidden name=op value=usr_status_jobs>\n"
    ."  <input type=hidden name=job_id value=\"$job_id\">\n"
    ."  <input type=hidden name=job_name value=\"$job_name\">\n"
    ."  <b>"._NLADDUSERMANUALLY."</b><br>\n"
    ."  &nbsp;&nbsp;&nbsp;"._NLADDBYID."&nbsp;<input type=text name=lan_add_user_by_id size=11 maxlength=11><br>\n"
    ."  &nbsp;&nbsp;&nbsp;"._NLADDBYNAME."&nbsp;<input type=text name=lan_add_user_by_uname size=11 maxlength=25><br><br>\n"
    ."  &nbsp;&nbsp;&nbsp;<input type=submit value=\""._NLADDUSER."\">\n"
    ." </form>\n";
CloseTable();
include ("footer.php");
?>
