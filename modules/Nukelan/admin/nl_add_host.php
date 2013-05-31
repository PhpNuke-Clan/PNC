<?php
// filename: nl_add_host.php

if (!defined('ADMIN_FILE')) {
        die ("Access Denied");
}//if (!authorised(0, 'LANParty::', '::', ACCESS_ADMIN)) die ('Access Denied: No permissions');

include ("header.php");
lan_menu();
OpenTable();
// output an edit/delete box for current hosts
global $db, $prefix, $editHost, $admin_file;
if ($db->sql_numrows($result = $db->sql_query("SELECT host_id, fname FROM nukelan_hosts ORDER BY fname"))) {
   echo "   <table border=0>\n"
       ."    <tr>\n"
       ."     <td>\n"
       ."      <form action=\"".$admin_file.".php\" method=\"post\" style=\"margin: 0;\">\n"
       ."       <input type=hidden name=op value=add_host_lans>\n"
       ."       <input type=hidden name=lanop value=edit_host>\n"
       ."       <b>"._NLEDITHOST."&nbsp;&nbsp;</b>\n"
       ."       <select name=editHost>\n";
   while ($row = $db->sql_fetchrow($result)) {
   if ($row[host_id]== $editHost) {
      echo "        <option value=\"$row[host_id]\" SELECTED>";
      echo "$row[fname]";
      echo "</option>\n";
        } else {
          echo "        <option value=\"$row[host_id]\">";
      echo "$row[fname]";
      echo "</option>\n";
          }
      }
   echo "       </select>\n"
       ."       <input type=submit value=\""._NLEDIT."\">\n"
       ."      </form>\n"
       ."     </td>\n";
   $result = $db->sql_query("SELECT host_id, fname FROM nukelan_hosts");
   echo "     <td>&nbsp;&nbsp;</td>\n"
       ."     <td>\n"
       ."      <form action=\"".$admin_file.".php\" method=\"post\" style=\"margin: 0;\">\n"
       ."       <input type=hidden name=op value=add_host_lans>\n"
       ."       <input type=hidden name=lanop value=delete_host>\n"
       ."       <b>"._NLDELETEHOST."&nbsp;&nbsp;</b>\n"
       ."       <select name=deleteHost>\n";
   while ($row = $db->sql_fetchrow($result)) {
      echo "        <option value=\"$row[host_id]\">\n";
      echo "$row[fname]";
      echo "</option>\n";
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

// shows form to add a host/also is where we redirect unfinnished forms
function showAddForm($fname, $email, $phone, $error) {
   global $db, $prefix, $ModName, $admin_file;
   echo "   <form action=\"".$admin_file.".php\" method=\"post\">\n"
       ."   <input type=hidden name=op value=\"add_host_lans\">\n"
       ."   <input type=hidden name=lanop value=\"add_new\">\n"
       ."   <center>\n"
       ."    <h3>"._NLADDHOST."</h3>\n";
   if ($error) echo "   $error<br>\n";
   echo "   </center>\n"
       ."   <b>"._NLADDHOST."</b><br>\n"
       ."   &nbsp;&nbsp;&nbsp;"._NLFIRSTLASTNAME."<br>\n"
       ."   &nbsp;&nbsp;&nbsp;<input type=text size=40 maxlength=40 name=fname value=\"$fname\"><br>\n"
       ."   &nbsp;&nbsp;&nbsp;"._NLHOSTEMAIL."<br>\n"
       ."   &nbsp;&nbsp;&nbsp;<input type=text size=40 maxlength=40 name=email value=\"$email\"><br>\n"
       ."   &nbsp;&nbsp;&nbsp;"._NLHOSTPHONE."<br>\n"
       ."   &nbsp;&nbsp;&nbsp;<input type=text size=30 maxlength=30 name=phone value=\"$phone\">\n"
       ."   <br>\n"
       ."   <br>\n"
       ."   <input type=submit value=\""._NLADDHOST."\">\n"
       ."   </form>\n";
   }

// this allows us to edit a host
function editHost($editHost) {
   global $db, $prefix, $pntable, $admin_file;
   if (!$host = $db->sql_fetchrow($db->sql_query("SELECT * FROM nukelan_hosts WHERE host_id='$editHost'"))) die (""._NLCANNOTACCESSHOST."");
   echo "   <form action=\"".$admin_file.".php\" method=\"post\">\n"
       ."   <input type=hidden name=op value=\"add_host_lans\">\n"
       ."   <input type=hidden name=lanop value=\"update_host\">\n"
       ."   <input type=hidden name=host_id value=\"$editHost\">\n"
       ."   <center>\n"
       ."   <h3>"._NLEDITHOST."\n"
           ."   $host[fname]</h3>\n"
       ."   </center>\n"
       ."   &nbsp;&nbsp;&nbsp;"._NLFIRSTLASTNAME."<br>\n"
       ."   &nbsp;&nbsp;&nbsp;<input type=text size=40 maxlength=40 name=fname value=\"$host[fname]\"><br>\n"
       ."   &nbsp;&nbsp;&nbsp;"._NLHOSTEMAIL."<br>\n"
       ."   &nbsp;&nbsp;&nbsp;<input type=text size=40 maxlength=40 name=email value=\"$host[email]\"><br>\n"
       ."   &nbsp;&nbsp;&nbsp;"._NLHOSTPHONE."<br>\n"
       ."   &nbsp;&nbsp;&nbsp;<input type=text size=30 maxlength=30 name=phone value=\"$host[phone]\">\n"
       ."   <br>\n"
       ."   <br>\n"
       ."   <input type=submit value=\""._NLEDITHOST."\">\n"
       ."   </form>\n";
   }

// adds the host to database
function addHost($fname, $email, $phone) {
   global $db, $prefix, $pntable, $admin_file;
   if (!$fname || !$email) showAddForm($fname, $email, $phone, ""._NLNAMEANDEMAILFILLEDIN."");
   elseif ($db->sql_numrows($db->sql_query("SELECT host_id FROM nukelan_hosts WHERE fname='$fname'"))) showAddForm($fname, $email, $phone, ""._NLHOSTNAMEINUSE."");
   elseif (!$db->sql_query("INSERT INTO nukelan_hosts SET fname='$fname', email='$email', phone='$phone'")) die (""._NLCANNOTINSERT."");
   else {
      echo "   <center>\n"
          ."    <h2>"._NLHOSTADDED."</h2>\n"
          ."   </center>";
                Header("Refresh: 1;url=".$admin_file.".php?op=add_host_lans");
      }
   }

// updates a host
function updateHost($host_id, $fname, $email, $phone) {
   global $db, $prefix, $pntable, $admin_file;
   if (!email) {
      echo ""._NLEMAILFILLEDIN."";
      editHost($host_id);
      }
   elseif (!$db->sql_query("UPDATE nukelan_hosts SET fname='$fname', email='$email', phone='$phone' WHERE host_id='$host_id'")) die (""._NLCANNOTUPDATE."");
   else {
      echo "   <center>\n"
          ."    <h2>"._NLHOSTEDITED."</h2>\n"
          ."   </center>";
                Header("Refresh: 1;url=".$admin_file.".php?op=add_host_lans");
      }
   }

function deleteHosts($deleteHost) {
   global $db, $prefix, $pntable, $admin_file;
   $result = $db->sql_query("SELECT keyword FROM nukelan_parties WHERE host='$deleteHost'");
   if ($db->sql_numrows($result)) while ($name = $db->sql_fetchrow($result)) {
      $error .= "$name[keyword] "._NLLANPARTYUSINGHOST."<br>";
      }
   elseif (!$db->sql_query("DELETE FROM nukelan_hosts WHERE host_id='$deleteHost'")) $error .= ""._NLCANNOTDELETEHOST."<br>";
   else echo "<h2>"._NLHOSTDELETED."</h2>";
   echo $error;
   Header("Refresh: 1;url=".$admin_file.".php?op=add_host_lans");
   }

switch ($lanop) {
   case "add_new":
      addHost($fname, $email, $phone);
      break;
   case "update_host":
      updateHost($host_id, $fname, $email, $phone);
      break;
   case "edit_host":
      editHost($editHost);
      break;
   case "delete_host":
      deleteHosts($deleteHost);
      break;
   default:
      showAddForm('','','','','');
      break;
   }

CloseTable();
include ("footer.php");
?>
