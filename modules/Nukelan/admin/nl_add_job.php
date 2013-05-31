<?php
// filename: add_job.php

if (!defined('ADMIN_FILE')) {
        die ("Access Denied");
}
//if (!authorised(0, 'LANParty::', '::', ACCESS_ADMIN)) die ('Access Denied: No permissions');

include ("header.php");

lan_menu();
OpenTable();
//$pntable = pnDBGetTables();
global $db, $prefix, $user_prefix, $editJob, $deleteJob, $admin_file;
// output an edit/delete box for current parties
if ($db->sql_numrows($result = $db->sql_query("SELECT jobid, name FROM nukelan_jobs ORDER BY name"))) {
   echo "   <table border=0>\n"
       ."    <tr>\n"
       ."     <td>\n"
       ."      <form action=\"".$admin_file.".php\" method=\"post\" style=\"margin: 0;\">\n"
       ."       <input type=hidden name=op value=add_jobs>\n"
       ."       <input type=hidden name=lanop value=edit_job>\n"
       ."       <b>"._NLEDITJOB."&nbsp;&nbsp;</b>\n"
       ."       <select name=editJob>\n";
   while ($row = $db->sql_fetchrow($result)) {
                if ($row[jobid]== $editJob) echo "<option value=\"$row[jobid]\" SELECTED>$row[name]</option>";
                else echo "        <option value=\"$row[jobid]\">$row[name]</option>\n";
                }
   echo "       </select>\n"
       ."       <input type=submit value=\""._NLEDIT."\">\n"
       ."      </form>\n"
       ."     </td>\n";
   $result = $db->sql_query("SELECT jobid, name FROM nukelan_jobs");
   echo "     <td>&nbsp;&nbsp;</td>\n"
       ."     <td>\n"
       ."      <form action=\"".$admin_file.".php\" method=\"post\" style=\"margin: 0;\">\n"
       ."       <input type=hidden name=op value=add_jobs>\n"
       ."       <input type=hidden name=lanop value=delete_job>\n"
       ."       <b>"._NLDELETEJOB."&nbsp;&nbsp;</b>\n"
       ."       <select name=deleteJob>\n";
   while ($row = $db->sql_fetchrow($result)) {
                if ($row[jobid]== $deleteJob) echo "<option value=\"$row[jobid]\" SELECTED>$row[name]</option>";
                else echo "        <option value=\"$row[jobid]\">$row[name]</option>\n";
                }
   echo "       </select>\n"
       ."       <input type=submit value=\""._NLDELETE."\">\n"
       ."      </form>\n"
       ."     </td>\n"
       ."    </tr>\n"
       ."   </table>\n";
   CloseTable();
   echo "   <br>\n";
   OpenTable();
   }

// shows form to add a party/also is where we redirect unfinnished forms
function showAddForm($name, $super, $max, $notes, $error) {
   global $db, $prefix, $user_prefix, $ModName, $pntable, $admin_file;
$result = $db->sql_query("SELECT user_id, username FROM ".$user_prefix."_users ORDER BY username");
   echo "   <form action=\"".$admin_file.".php\" method=\"post\">\n"
       ."   <input type=hidden name=op value=\"add_jobs\">\n"
       ."   <input type=hidden name=lanop value=\"add_new\">\n"
       ."   <center>\n"
       ."    <h3>"._NLADDJOB."</h3>\n";
   if ($error) echo "   $error<br>\n";
   echo "   </center>\n"
       ."   "._NLJOBTITLE."<br>\n"
       ."   <input type=text size=40 maxlength=40 name=name value=\"$name\"><br>\n"
           ."   "._NLJOBSUPER."<br>\n"
           ."   <select name=super>\n";
         while ($row = $db->sql_fetchrow($result)) { echo "<option value=\"$row[user_id]\">$row[username]</option>\n";
         }
   echo "</select><br>\n"
       ."   "._NLJOBNUMBER."<br>\n"
       ."   <input type=text size=4 maxlength=4 name=max value=\"$max\"><br>\n"
       ."   "._NLJOBNOTES."<br>\n"
       ."   <textarea name=notes style=\"width: 75%; height: 100px;\">$notes</textarea><br>\n"
       ."   <br>\n"
       ."   <br>\n"
       ."   <input type=submit value=\""._NLADDJOB."\">\n"
       ."   </form>\n";
   }

// adds party to database
function addJob($name, $super, $max, $notes) {
   global $db, $prefix, $user_prefix, $pntable, $admin_file;

   if (!$name || !$max || !$notes) showAddForm($name, $super, $max, $notes, ""._NLREQUIREDFIELDS."");
   //if (!$keyword || !$month || !$day || !$year || !$time || !$loc || !$host) showAddForm($keyword, $month, $day, $year, $time, $loc, $host, $max, $charge, $max_sys, $chg_sys, $max_mon, $chg_mon, $paypal, $mail, $disclaimer, $stop, "Please make sure you fill in all required fields");
   elseif ($db->sql_numrows($db->sql_query("SELECT jobid FROM nukelan_jobs WHERE name='$name'"))) showAddForm($name, $super, $max, $notes, $stop, ""._NLJOBNAMEINUSE."");
   elseif (!$db->sql_query("INSERT INTO nukelan_jobs SET name='$name', super='$super', max='$max', notes='$notes'")) die (""._NLCANNOTINSERT."");
   else {
      echo "   <center>\n"
          ."    <h2>$keyword "._NLJOBADDED."</h2>\n"
          ."   </center>";
          Header("Refresh: 0;url=".$admin_file.".php?op=add_jobs");
      }
   }

// edits a party
function editJob($editJob, $error) {
   global $db, $prefix, $user_prefix, $pntable, $ModName, $admin_file;
   $result = $db->sql_query("SELECT user_id, username FROM ".$user_prefix."_users ORDER BY username");
   $lan = $db->sql_fetchrow($db->sql_query("SELECT * FROM nukelan_jobs WHERE jobid='$editJob'"));
   echo "   <form action=\"".$admin_file.".php\" method=\"post\">\n"
       ."   <input type=hidden name=op value=\"add_jobs\">\n"
       ."   <input type=hidden name=lanop value=\"update\">\n"
       ."   <input type=hidden name=jobid value=\"$lan[jobid]\">\n"
       //."   <input type=hidden name=name value=\"$lan[name]\">\n"
       ."   <center>\n"
       ."    <h3>"._NLEDITJOB."</h3>\n";
   if ($error) echo "   $error<br>\n";
   echo "   </center>\n"
       ."   "._NLJOBTITLE."<br>\n"
       ."   <input type=text size=40 maxlength=40 name=name value=\"$lan[name]\"><br>\n"
           ."   "._NLJOBSUPER."<br>\n"
           ."   <select name=super>\n";
         while ($row = $db->sql_fetchrow($result)) {
            if ($lan[super] == $row[user_id]) echo "<option value=\"$row[user_id]\" SELECTED>$row[username]</option>\n";
            else echo "<option value=\"$row[user_id]\">$row[username]</option>\n";
         }
   echo "</select><br>\n"
       ."   "._NLJOBNUMBER."<br>\n"
       ."   <input type=text size=4 maxlength=4 name=max value=\"$lan[max]\"><br>\n"
       ."   "._NLJOBNOTES."<br>\n"
       ."   <textarea name=notes style=\"width: 75%; height: 100px;\">$lan[notes]</textarea><br>\n"
       ."   <br>\n"
       ."   <br>\n"
       ."   <input type=submit value=\""._NLEDITJOB."\">\n"
       ."   </form>\n";
   }

// updates database
function updateJob($jobid, $name, $super, $max, $notes) {
   global $db, $prefix, $user_prefix, $pntable, $admin_file;

   if (!$name || !$max || !$notes) editJob($editJob, ""._NLREQUIREDFIELDS."");
   //if (!$keyword || !$month || !$day || !$year || !$time || !$loc || !$host) editParty($editParty, "Please make sure you fill in all required fields");
   elseif (!$db->sql_query("UPDATE nukelan_jobs SET name='$name', super='$super', max='$max', notes='$notes'  WHERE jobid='$jobid'")) die (""._NLCANNOTUPDATE."");
   else {
      echo "   <center>\n"
          ."    <h2>$name "._NLJOBUPDATED."</h2>\n"
          ."   </center><br><br>\n"
          ."   Job_ID =".$jobid."<br>"
          ."   "._NLJOBTITLE." =".$name."<br>"
                  ."   "._NLJOBSUPER."=".$super."<br>"
          ."   "._NLJOBNUMBER." =".$max."<br>"
          ."   "._NLJOBNOTES." =".$notes."<br>";
          Header("Refresh: 0;url=".$admin_file.".php?op=add_jobs");
            }
   }
function deleteJob($deleteJob) {
   global $db, $prefix, $user_prefix, $pntable, $admin_file;
   if (!$db->sql_query("DELETE FROM nukelan_jobs WHERE jobid='$deleteJob'")) $error .= ""._NLCANNOTDELETEJOB."";
   //elseif (!$db->sql_query("DELETE FROM lan_wait WHERE jobid='$deleteJob'")) $error .= "Could not delete users who are waiting on a response.";
   elseif (!$db->sql_query("DELETE FROM nukelan_staff WHERE jobid='$deleteJob'")) $error .= ""._NLCANNOTDELETESTAFF."";
   if ($error) echo $error;
   else echo "<center><h2>"._NLJOBDELETED."</h2></center>";
    Header("Refresh: 0;url=".$admin_file.".php?op=add_jobs");
   }

switch ($lanop) {
   case 'add_new':
      addJob($name, $super, $max, $notes);
      break;
   case 'edit_job':
      editJob($editJob, '');
      break;
   case 'update':
      updateJob($jobid, $name, $super, $max, $notes);
      break;
   case 'delete_job':
      deleteJob($deleteJob);
      break;
   default:
      if (!$db->sql_numrows($db->sql_query("SELECT party_id FROM nukelan_parties"))) echo ""._NLJOBDEFINEPARTY."";
      //elseif (!$db->sql_numrows($db->sql_query("SELECT loc_id FROM nuke_lanparty_locations"))) echo "You need to define a location for your LAN Party before setting up a LAN Party.";
      else showAddForm($name, $super, $max, $notes, $error);
      break;
   }
CloseTable();
include ("footer.php");
?>
