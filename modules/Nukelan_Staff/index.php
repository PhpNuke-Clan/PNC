<?php
// filename: index.php
// ---------------------------------------------------------------------
// Nukelan Modules pack
// version 2.0
// by: Artemis
//
// artemis@nukelan.com
// http://www.nukelan.com
// =====================================================================
// Special thanks to:
// Contra - for integrating the Multipay and IPN option into Nukelan.
// you the man
// =====================================================================
// LICENSE
//
// This program is free software; you can redistribute it and/or
// modify it under the terms of the GNU General Public License (GPL)
// as published by the Free Software Foundation; either version 2
// of the License, or (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// To read the license please visit http://www.gnu.org/copyleft/gpl.html
// ----------------------------------------------------------------------

if(!defined('MODULE_FILE')) {
die('You can\'t access this file directly...');
}
$ModName = basename( dirname( __FILE__ ) );
$index = $lanconfig['index'];
include ("header.php");
require_once("mainfile.php");
OpenTable();

global $db, $prefix, $uname, $uid;
        $user = base64_decode($user);
        $user = explode(":", $user);
        $uid = "$user[0]";
        $uname = "$user[1]";
        $pwd = "$user[2]";
$jobs = $db->sql_query("SELECT * FROM nukelan_jobs ORDER BY name");
$num_jobs = $db->sql_numrows($jobs);
function ListJobs($jobs) {
   global $db, $prefix, $bgcolor1, $bgcolor2, $bgcolor3, $bgcolor4, $textcolor1, $textcolor2, $ModName, $sitename;
 echo "      <table align=center border=0 cellpadding=3 cellspacing=1 bgcolor=\"$bgcolor1\" width=\"60%\">\n"
       ."<h3>Lan Positions Available:</h3>\n"
           ."    <tr style=\"background-color: $bgcolor2; color: $textcolor1; font-weight: bold;\">\n"
           ."    <td width=\"5%\">#</td>\n"
       ."     <td width=\"60%\">Job Title</td>\n"
       ."     <td width=\"35%\"># Filled</td>\n"
       ."    </tr>\n";
   $bc = $bgcolor3;
   while($job2 = $db->sql_fetchrow($jobs)) {
    $count_rows += 1;
$num_fill = $db->sql_numrows($db->sql_query("SELECT * FROM nukelan_staff WHERE approve >= 1 AND jobid='$job2[jobid]'"));
      if ($bc == $bgcolor3) $bc = $bgcolor4;
      else $bc = $bgcolor3;
      echo "    <tr bgcolor=\"$bc\">\n"
          ."<td>".$count_rows."</td>\n"
          ."   <td><a href=\"modules.php?name=$ModName&file=index&lanop=show_job&job_id=$job2[jobid]\">";
          echo "$job2[name]</a>";
      echo "     <td><font color=green><b>$num_fill / $job2[max]</b></font></td>\n";
          echo "    </tr>\n";
      }
   echo "   </table>\n";
   CloseTable();
   OpenTable();
   showbuttons($job);
   ListFilled();
   }


function ListFilled() {
   global $db, $prefix, $user_prefix, $bgcolor1, $bgcolor2, $bgcolor3, $bgcolor4, $textcolor1, $textcolor2, $ModName, $sitename;
$jobs2 = $db->sql_query("SELECT * FROM nukelan_staff WHERE approve >= 1 ORDER BY userid");
 echo "   <table align=center border=0 cellpadding=3 cellspacing=1 bgcolor=\"$bgcolor1\" width=\"60%\">\n"
       ."   <h3>Lan Positions Filled:</h3>\n"
           ."    <tr style=\"background-color: $bgcolor2; color: $textcolor1; font-weight: bold;\">\n"
           ."    <td width=\"5%\">#</td>\n"
       ."     <td width=\"50%\">Job Title</td>\n"
       ."     <td width=\"45%\">User</td>\n"
       ."    </tr>\n";
   $bc = $bgcolor3;
   while($job = $db->sql_fetchrow($jobs2)) {
   $count_rows += 1;
$juser = $db->sql_fetchrow($db->sql_query("SELECT username FROM ".$user_prefix."_users WHERE user_id='$job[userid]'"));
$jname = $db->sql_fetchrow($db->sql_query("SELECT name FROM nukelan_jobs WHERE jobid='$job[jobid]'"));
      if ($bc == $bgcolor3) $bc = $bgcolor4;
      else $bc = $bgcolor3;
      echo "    <tr bgcolor=\"$bc\">\n"
          ."<td>".$count_rows."</td>\n"
          ."     <td><b>$jname[name]</td>\n"
          ."     <td><b>$juser[username]</b></td>\n"
              ."    </tr>\n";
      }
   echo "   </table>\n";
   CloseTable();
   OpenTable();
   }

function ShowJob($job_id) {
   global $db, $prefix, $user_prefix, $bgcolor1, $bgcolor2, $bgcolor3, $bgcolor4, $textcolor1, $textcolor2, $ModName, $sitename;
$row = $db->sql_fetchrow($db->sql_query("SELECT * FROM nukelan_jobs WHERE jobid='$job_id'"));
$emps = $db->sql_query("SELECT l.*, u.* FROM nukelan_staff AS l LEFT JOIN ".$user_prefix."_users AS u ON (l.userid=u.user_id) WHERE l.jobid='$job_id' AND l.approve >= 1");
$sups = $db->sql_query("SELECT username FROM ".$user_prefix."_users WHERE user_id='$row[super]'");
$sup = $db->sql_fetchrow($sups);
   echo "   <h3>$row[name]:</h3>\n"
       ."  <b>Supervised By:  </b><font size=2 color=red><b>$sup[username]</b></font><br><br>\n"
           ."  <b>Requirements & Duties:</b><br>\n"
           ."  <font>$row[notes]</font><br><br><br>\n"
       ."   <table border=0 cellpadding=3 cellspacing=1 bgcolor=\"$bgcolor1\" width=\"50%\">\n"
       ."    <tr style=\"background-color: $bgcolor2; color: $textcolor1; font-weight: bold;\">\n"
           ."    <td width=\"5%\">#</td>\n"
       ."     <td width=\"95%\">User</td>\n"
       ."    </tr>\n";
   $bc = $bgcolor3;
   while($emp = $db->sql_fetchrow($emps)) {
   $count_rows += 1;
      if ($bc == $bgcolor3) $bc = $bgcolor4;
      else $bc = $bgcolor3;
      echo "    <tr bgcolor=\"$bc\">\n"
          ."<td>".$count_rows."</td>\n"
          ."     <td><font color=green><b>$emp[username]</b></font></td>\n"
              ."    </tr>\n";
      }
   while($count_rows < $row['max']) {
   $count_rows += 1;
      if ($bc == $bgcolor3) $bc = $bgcolor4;
      else $bc = $bgcolor3;
      echo "    <tr bgcolor=\"$bc\">\n"
          ."<td>".$count_rows."</td>\n"
          ."     <td><b>Not Filled Yet</b></td>\n"
              ."    </tr>\n";
   }
   echo "   </table>\n";
   CloseTable();
   OpenTable();
   }

function showbuttons($job) {
global $db, $prefix, $cookie, $user, $ModName;
$result = $db->sql_query("SELECT jobid, name FROM nukelan_jobs ORDER BY name");
                echo ""
             
            ."      <form action=\"modules.php\" method=\"post\" style=\"margin: 0;\">\n"
                        ."      <input type=hidden name=op value=modload>\n"
            ."      <input type=hidden name=name value=$ModName>\n"
            ."      <input type=hidden name=file value=index>\n"
            ."      <input type=hidden name=lanop value=apply>\n"
                        ."      <input type=hidden name=uid value=".$uid.">\n"
                        ."<h3>Apply for a position:</h3><br>\n"
                        ."    <b>What position would you like to apply for?</b><br>\n"
                    ."  <select name=pos>\n";
        while ($row = $db->sql_fetchrow($result)) { echo "<option value=\"$row[jobid]\">$row[name]</option>\n";
        }
            echo "</select><br><br>\n"
                        ."<b>Why are you applying for this position?</b><br>\n"
                        ."<textarea name=unotes style=\"width: 75%; height: 100px;\"></textarea><br><br>\n"
            ."      <input type=submit value=\"Apply Now\" style=\"width: 120px;\">\n"
            ."      </form>\n"
            ."     </td>\n";
                        CloseTable();
                        OpenTable();
}
function ApplyJob ($uid,$pos,$unotes,$apply) {
global $db, $prefix, $cookie, $user, $ModName;
 if ($uid <= 1) die ("You must be registered to apply for a job.");
        $applied = $db->sql_numrows($db->sql_query("SELECT * FROM nukelan_staff WHERE userid='$uid' AND jobid='$pos'"));

 switch ($apply) {
   default:
     if (!$unotes) echo "<font size=2 color=red><b>Please make sure you explain why you would like to have this position</b></font>";
         elseif ($applied) echo "<font size=2 color=red><b>You have already applied for this job!  We will process your request soon.</b></font>";
         elseif (!$db->sql_query("INSERT INTO nukelan_staff SET userid='$uid', jobid='$pos', unotes='$unotes'")) echo "<b>Couldn't apply for this job! DB-Error";
         else echo"<font size=2 color=green><b>Your application has been received and will be reviewed soon.  Thank you.</b></font>";
         break;
        }
}
  switch ($lanop) {
   case 'show_job':
      ShowJob($job_id);
          break;
   case 'apply':
      ApplyJob ($uid,$pos,$unotes,'');
          ListJobs($jobs);
          break;
          
   default:
      if ($num_jobs > 0) ListJobs($jobs);
      else echo "<table border=0 width=100%><tr height=500px valign=center><td align=center><h2>There are currently no JOBS to apply for.</h2></td></tr></table>";
      break;
   }

CloseTable();
echo "<br>";
include ("footer.php");
?>
