<?php
// filename: add_hotels.php

if (!defined('ADMIN_FILE')) {
        die ("Access Denied");
}
include ("header.php");

lan_menu();
OpenTable();
global $db, $prefix, $admin_file;

if ($db->sql_numrows($result = $db->sql_query("SELECT itemid, name FROM nukelan_lodging"))) {
   echo "   <table border=0>\n"
       ."    <tr>\n"
       ."     <td>\n"
       ."      <form action=\"".$admin_file.".php\" method=\"post\" style=\"margin: 0;\">\n"
       ."       <input type=hidden name=op value=add_hotel>\n"
       ."       <input type=hidden name=lanop value=edit_hotel>\n"
       ."       <b>"._NLEDITHOTEL."&nbsp;&nbsp;</b>\n"
       ."       <select name=editHotel>\n";
   while ($row = $db->sql_fetchrow($result)) echo "        <option value=\"$row[itemid]\">$row[name]</option>\n";
   echo "       </select>\n"
       ."       <input type=submit value=\""._NLEDIT."\">\n"
       ."      </form>\n"
       ."     </td>\n";
   $result = $db->sql_query("SELECT itemid, name FROM nukelan_lodging");
   echo "     <td>&nbsp;&nbsp;</td>\n"
       ."     <td>\n"
       ."      <form action=\"".$admin_file.".php\" method=\"post\" style=\"margin: 0;\">\n"
       ."       <input type=hidden name=op value=add_hotel>\n"
       ."       <input type=hidden name=lanop value=delete_hotel>\n"
       ."       <b>"._NLDELETEHOTEL."&nbsp;&nbsp;</b>\n"
       ."       <select name=deleteHotel>\n";
   while ($row = $db->sql_fetchrow($result)) echo "        <option value=\"$row[itemid]\">$row[name]</option>\n";
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
   
// shows form to add a location/also is where we redirect unfinnished forms
function showAddForm($name, $address, $phone,  $costpernight, $traveltime, $pid, $error) {
global $db, $prefix, $user_prefix, $db, $bgcolor2, $banners, $admin_file;
$parties = $db->sql_query("SELECT * FROM nukelan_parties ORDER BY keyword");  
global $db, $prefix, $admin_file;
   echo "   <form action=\"".$admin_file.".php\" method=\"post\">\n"
       ."   <input type=hidden name=op value=\"add_hotel\">\n"
       ."   <input type=hidden name=lanop value=\"add_new\">\n"
       ."   <center>\n"
       ."    <h3>"._NLADDHOTEL."</h3>\n";
   if ($error) echo "   $error<br>\n";
   echo "   </center>\n"
       ."   <b>"._NLLODGINGINFORMATION."</b><br>\n"
       ."   &nbsp;&nbsp;&nbsp;"._NLHOTELNAME."<br>\n"
       ."   &nbsp;&nbsp;&nbsp;<input type=text size=50 maxlength=255 name=name value=\"$name\"><br>\n"
       ."   &nbsp;&nbsp;&nbsp;"._NLHOTELADDRESS."<br>\n"
       ."   &nbsp;&nbsp;&nbsp;<input type=text size=50 maxlength=255 name=address value=\"$address\"><br>\n"
           ."   &nbsp;&nbsp;&nbsp;"._NLHOTELPHONE."<br>\n"
           ."   &nbsp;&nbsp;&nbsp;<input type=text size=50 maxlength=20 name=phone value=\"$phone\"><br>\n"
           ."   &nbsp;&nbsp;&nbsp;"._NLHOTELCOST."<br>\n"
           ."   &nbsp;&nbsp;&nbsp;<input type=text size=50 maxlength=20 name=costpernight value=\"$costpernight\"><br>\n"
           ."   &nbsp;&nbsp;&nbsp;"._NLHOTELTRAVEL."<br>\n"
       ."   &nbsp;&nbsp;&nbsp;<input type=text size=50 maxlength=100 name=traveltime value=\"$traveltime\"><br>\n"
           ."   &nbsp;&nbsp;&nbsp;"._NLHOTELPARTY."<br>\n"
           ."   &nbsp;&nbsp;&nbsp;<select name=pid>\n";
   while ($row = $db->sql_fetchrow($parties)) {
     if ($pid == $row[party_id]) echo "<option value=\"$row[party_id]\" SELECTED>$row[keyword]</option>\n";      
         else echo "<option value=\"$row[party_id]\">$row[keyword]</option>\n";
         }
           echo "   &nbsp;&nbsp;&nbsp;</select><br>\n"
       ."   &nbsp;&nbsp;&nbsp; <input type=submit value=\""._NLADDHOTEL."\">\n"
       ."   </form>";
   }

// this allows us to edit a tournament
function editHotel($editHotel) {
global $db, $prefix,$user_prefix, $admin_file;
$parties = $db->sql_query("SELECT * FROM nukelan_parties ORDER BY keyword");  
   if (!$loc = $db->sql_fetchrow($db->sql_query("SELECT * FROM nukelan_lodging WHERE itemid='$editHotel'"))) die (""._NLCANNOTACCESSHOTEL."");
   
   echo "   <form action=\"".$admin_file.".php\" method=\"post\">\n"
       ."   <input type=hidden name=op value=\"add_hotel\">\n"
       ."   <input type=hidden name=lanop value=\"update_hotel\">\n"
       ."   <input type=hidden name=itemid value=\"$editHotel\">\n"
       //."   <input type=hidden name=prizename value=\"$loc[prizename]\">\n"
       ."   <center>\n"
       ."    <h3>"._NLEDITHOTEL2." $loc[name]</h3>\n"
       ."   </center>\n"
       ."   &nbsp;&nbsp;&nbsp;<b>"._NLLODGINGINFORMATION."</b><br><br>\n"
           ."   &nbsp;&nbsp;&nbsp;"._NLHOTELNAME."<br>\n"
       ."   &nbsp;&nbsp;&nbsp;<input type=text size=50 maxlength=255 name=name value=\"$loc[name]\"><br>\n"
       ."   &nbsp;&nbsp;&nbsp;"._NLHOTELADDRESS."<br>\n"
       ."   &nbsp;&nbsp;&nbsp;<input type=text size=50 maxlength=255 name=address value=\"$loc[address]\"><br>\n"
           ."   &nbsp;&nbsp;&nbsp;"._NLHOTELPHONE."<br>\n"
           ."   &nbsp;&nbsp;&nbsp;<input type=text size=50 maxlength=20 name=phone value=\"$loc[phone]\"><br>\n"
           ."   &nbsp;&nbsp;&nbsp;"._NLHOTELCOST."<br>\n"
           ."   &nbsp;&nbsp;&nbsp;<input type=text size=50 maxlength=20 name=costpernight value=\"$loc[costpernight]\"><br>\n"
           ."   &nbsp;&nbsp;&nbsp;"._NLHOTELTRAVEL."<br>\n"
       ."   &nbsp;&nbsp;&nbsp;<input type=text size=50 maxlength=100 name=traveltime value=\"$loc[traveltime]\"><br>\n"
       ."   &nbsp;&nbsp;&nbsp;"._NLHOTELPARTY."<br>\n"
           ."   &nbsp;&nbsp;&nbsp;<select name=pid>\n";
   while ($row = $db->sql_fetchrow($parties)) {
     if ($loc[config_id] == $row[party_id]) echo "<option value=\"$row[party_id]\" SELECTED>$row[keyword]</option>\n";   
         else echo "<option value=\"$row[party_id]\">$row[keyword]</option>\n";
         }
           echo "   &nbsp;&nbsp;&nbsp;</select><br>\n"
       ."   &nbsp;&nbsp;&nbsp; <input type=submit value=\""._NLUPDATEHOTEL."\">\n"
       ."   </form>";
}
// adds the location to database
function addHotel($name, $address, $phone,  $costpernight, $traveltime, $pid) {
global $db, $prefix,$user_prefix, $admin_file;
   if (!$name) showAddForm($name, $address, $phone,  $costpernight, $traveltime, $pid, ""._NLREQUIREDFIELDS."");
   //if ($db->sql_numrows($db->sql_query("SELECT prizeid FROM prizes WHERE prizename='$prizename'"))) showAddForm($prizename, $prizevalue, $prizequantity,  $prizepicture, $tourneyid, $tourneyplace) echo "<font color=red><b>sorry, there was an error because you are dumb</b></font><br>";
   if (!$db->sql_query("INSERT INTO nukelan_lodging SET name='$name', address='$address', phone='$phone', costpernight='$costpernight', traveltime='$traveltime', config_id='$pid'")) die (""._NLCANNOTINSERT."");
   else {
      echo "   <center>\n"
          ."    <h2>"._NLHOTELADDED."</h2>\n"
          ."   </center>";
         Header("Refresh: 0;url=".$admin_file.".php?op=add_hotel");
      }
   }

// updates a location
function updateHotel($itemid, $name, $address, $phone,  $costpernight, $traveltime, $pid) {
global $db, $prefix,$user_prefix, $admin_file;
   //global $db, $prefix, $pntable;
   //if ($tyear && $tmonth && $tday && $thour && $tmin && $tsec) $date = "$tyear-$tmonth-$tday $thour:$tmin:$tsec";
   if (!$name || !$address) {echo ""._NLREQUIREDFIELDS."<br>"; 
   editHotel($itemid);
      }
   elseif (!$db->sql_query("UPDATE nukelan_lodging SET name='$name', address='$address', phone='$phone', costpernight='$costpernight', traveltime='$traveltime', config_id='$pid' WHERE itemid='$itemid'")) die (""._NLCANNOTUPDATE."");
   else {
      echo "   <center>\n"
          ."    <h2>"._NLHOTELUPDATED."</h2>\n"
          ."   </center>";
         Header("Refresh: 0;url=".$admin_file.".php?op=add_hotel");       
      }
   }

function deleteHotel($deleteHotel) {
global $db, $prefix,$user_prefix, $admin_file;
   //global $db, $prefix, $pntable;
   if (!$db->sql_query("DELETE FROM nukelan_lodging WHERE itemid='$deleteHotel'")) $error .= ""._NLCANNOTDELETEHOTEL."<br>";
   else echo "<center><h2>"._NLHOTELDELETED."</h2></center>";
   echo $error;
   }

switch ($lanop) {
   case "add_new":
      addHotel($name, $address, $phone,  $costpernight, $traveltime, $pid);
      break;
   case "update_hotel":
      updateHotel($itemid, $name, $address, $phone,  $costpernight, $traveltime, $pid);
      break;
   case "edit_hotel":
      editHotel($editHotel);
      break;
   case "delete_hotel":
      deleteHotel($deleteHotel);
      break;
   default:
      showAddForm('', '', '', '', '', '', '');
      break;
   }

CloseTable();
include ("footer.php");

?>
