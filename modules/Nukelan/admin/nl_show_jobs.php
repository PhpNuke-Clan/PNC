<?php
// filename: show_jobs.php

if (!defined('ADMIN_FILE')) {
	die ("Access Denied");
}
include ("header.php");
global $db, $prefix, $admin_file;
lan_menu();
OpenTable();
echo " <table border=0 cellpadding=3 cellspacing=1 bgcolor=\"$bgcolor1\" width=\"100%\">\n"
    ."  <tr style=\"background-color: $bgcolor2; color: $textcolor1; font-weight: bold;\">\n"
    ."   <td width=\"25%\">"._NLJOB."</td>\n"
    ."   <td width=\"5%\" align=center>"._NLVIEW."</td>\n"
    ."   <td width=\"5%\" align=center>"._NLEDIT."</td>\n"
	."   <td width=\"5%\" align=center>"._NLNUMBERAPPS."</td>\n"
    ."   <td width=\"10%\" align=center>"._NLNUMBERAPPROVED."</td>\n"
    ."   <td width=\"10%\" align=center>"._NLSTATUS."</td>\n"
    ."  </tr>\n";

$result = $db->sql_query("SELECT * FROM nukelan_jobs GROUP BY jobid");
$bc = $bgcolor3;
while($lan = $db->sql_fetchrow($result)) {
   if ($bc == $bgcolor3) $bc = $bgcolor4;
   else $bc = $bgcolor3;
   echo "  <tr bgcolor=\"$bc\">\n"
       ."   <td><a href=\"".$admin_file.".php?op=usr_status_jobs&amp;job_id=$lan[jobid]&amp;job_name=$lan[name]&amp;superid=$lan[super]\">$lan[name]</a></td>\n"
       ."   <td align=center><a href=\"".$admin_file.".php?op=usr_status_jobs&amp;job_id=$lan[jobid]&amp;job_name=$lan[name]&amp;superid=$lan[super]\"><img src=\"modules/Nukelan_Staff/images/admin_show.gif\" alt=\"Approve\Deny Applicants\" border=0></a></td>\n"
       ."   <td align=center><a href=\"".$admin_file.".php?op=add_jobs&amp;lanop=edit_job&amp;editJob=$lan[jobid]\"><img src=\"modules/Nukelan_Staff/images/admin_edit.gif\" alt=\"Edit job details.\" border=0></a></td>\n"
       ."	<td align=center>";
   echo $db->sql_numrows($db->sql_query("SELECT userid FROM nukelan_staff WHERE jobid='$lan[jobid]' AND approve <> 1"));   
   echo "</td>\n"
	   ."   <td align=center>";
   echo $db->sql_numrows($db->sql_query("SELECT userid FROM nukelan_staff WHERE jobid='$lan[jobid]' AND approve >= 1"));
   if ($lan[max]) echo "/$lan[max]";
   echo "</td>\n"
       ."   <td align=center>";
$num_apply = $db->sql_numrows($db->sql_query("SELECT * FROM nukelan_staff WHERE jobid='$lan[jobid]' AND approve >= 1"));
   if ($lan[stop] >= '2') echo "<font color=red>"._NLSTOPPED."</font>";
   elseif ($num_apply == $lan[max]) echo "<font color=red>"._NLFULL."</font>";
   else echo "<font color=green>"._NLNORMAL."</font>";
   echo "</td>\n"
       ."  </tr>";
   }
if (!$db->sql_numrows($result)) echo "  <tr><td colspan=5 align=center>"._NLNOJOBSSETUP."</td></tr>\n";
echo " </table>\n";
CloseTable();
include ("footer.php");
?>
