<?php
// filename: nl_add_location.php

if (!defined('ADMIN_FILE')) {
        die ("Access Denied");
}
//if (!authorised(0, 'LANParty::', '::', ACCESS_ADMIN)) die ('Access Denied: No permissions');
$module_name = "Nukelan";
include ("header.php");
lan_menu();
OpenTable();
global $db, $prefix, $editLoc, $admin_file;
// output an edit/delete box for current locations
if ($db->sql_numrows($result = $db->sql_query("SELECT loc_id, keyword FROM nukelan_locations ORDER BY keyword"))) {
   echo "   <table border=0>\n"
       ."    <tr>\n"
       ."     <td>\n"
       ."      <form action=\"".$admin_file.".php\" method=\"post\" style=\"margin: 0;\">\n"
       ."       <input type=hidden name=op value=add_location_lans>\n"
       ."       <input type=hidden name=lanop value=edit_loc>\n"
       ."       <b>"._NLEDITLOCATION."&nbsp;&nbsp;</b>\n"
       ."       <select name=editLoc>\n";
   while ($row = $db->sql_fetchrow($result)) {
                if ($row[loc_id]==$editLoc) echo "<option value=\"$row[loc_id]\" SELECTED>$row[keyword]</option>";
                else echo "        <option value=\"$row[loc_id]\">$row[keyword]</option>\n";
                }
   echo "       </select>\n"
       ."       <input type=submit value=\""._NLEDIT."\">\n"
       ."      </form>\n"
       ."     </td>\n";
   $result = $db->sql_query("SELECT loc_id, keyword FROM nukelan_locations");
   echo "     <td>&nbsp;&nbsp;</td>\n"
       ."     <td>\n"
       ."      <form action=\"".$admin_file.".php\" method=\"post\" style=\"margin: 0;\">\n"
       ."       <input type=hidden name=op value=add_location_lans>\n"
       ."       <input type=hidden name=lanop value=delete_loc>\n"
       ."       <b>"._NLDELETELOCATION."&nbsp;&nbsp;</b>\n"
       ."       <select name=deleteLoc>\n";
   while ($row = $db->sql_fetchrow($result)) echo "        <option value=\"$row[loc_id]\">$row[keyword]</option>\n";
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
function showAddForm($keyword, $addr, $city, $state, $zip, $xzip, $error) {
   global $db, $prefix, $admin_file, $module_name;
   //include ("modules/$module_name/admin/incl/states.php");
   include ("modules/$module_name/admin/incl/countries.inc.php");
   echo "   <form action=\"".$admin_file.".php\" method=\"post\">\n"
       ."   <input type=hidden name=op value=\"add_location_lans\">\n"
       ."   <input type=hidden name=lanop value=\"add_new\">\n"
       ."   <center>\n"
       ."    <h3>"._NLADDLOCATION."</h3>\n";
   if ($error) echo "   $error<br>\n";
   echo "   </center>\n"
       ."   <b>"._NLLOCATIONINFO."</b><br>\n"
       ."   &nbsp;&nbsp;&nbsp;"._NLLOCATIONNAME."<br>\n"
       ."   &nbsp;&nbsp;&nbsp;<input type=text size=40 maxlength=40 name=keyword value=\"$keyword\"><br>\n"
       ."   &nbsp;&nbsp;&nbsp;"._NLLOCATIONADDRESS."<br>\n"
       ."   &nbsp;&nbsp;&nbsp;<input type=text size=40 maxlength=255 name=addr value=\"$addr\"><br>\n"
       ."   &nbsp;&nbsp;&nbsp;"._NLLOCATIONADDRESS2."<br>\n"
       ."   &nbsp;&nbsp;&nbsp;<input type=text size=20 maxlength=50 name=city value=\"$city\">\n";
   echo "   <select name=state>\n";
   foreach ($country_array as $abrv => $long) {
      if ($country_array == $abrv) echo "    <option value=\"$abrv\" SELECTED>$long</option>\n";
      else echo "    <option value=\"$abrv\">$long</option>\n";
      }
 //*  echo "   &nbsp;&nbsp;&nbsp;<input type=text size=20 maxlength=50 name=state value=\"$abrv\">\n"
   echo "   </select>\n"
       ."   <input type=text size=6 maxlength=6 name=zip value=\"$zip\">-<input type=text size=4 maxlength=4 name=xzip value=\"$xzip\"><br>\n"
       ."   <br>\n"
       ."   <input type=submit value=\""._NLADDLOCATION."\">\n"
       ."   </form>\n";
   }

// this allows us to edit a location
function editLocation($editLoc) {
   global $db, $prefix, $pntable, $admin_file, $module_name;
   //include ("modules/$module_name/admin/incl/states.php");
   include ("modules/$module_name/admin/incl/countries.inc.php");
   if (!$loc = $db->sql_fetchrow($db->sql_query("SELECT * FROM nukelan_locations WHERE loc_id='$editLoc'"))) die (""._NLCANNOTACCESSLOCATION."");
   $zip = explode("-", $loc[zip]);
   echo "   <form action=\"".$admin_file.".php\" method=\"post\">\n"
       ."   <input type=hidden name=op value=\"add_location_lans\">\n"
       ."   <input type=hidden name=lanop value=\"update_loc\">\n"
       ."   <input type=hidden name=loc_id value=\"$editLoc\">\n"
       ."   <center>\n"
       ."    <h3>"._NLEDITLOCATION." $loc[keyword]</h3>\n"
       ."   </center>\n"
       ."   <b>"._NLLOCATIONINFO."</b><br>\n"
       ."   &nbsp;&nbsp;&nbsp;"._NLLOCATIONNAME."<br>\n"
       ."   &nbsp;&nbsp;&nbsp;<input type=text size=40 maxlength=40 name=keyword value=\"$loc[keyword]\"><br>\n"
           ."   &nbsp;&nbsp;&nbsp;"._NLLOCATIONADDRESS."<br>\n"
       ."   &nbsp;&nbsp;&nbsp;<input type=text size=40 maxlength=255 name=addr value=\"$loc[addr]\"><br>\n"
       ."   &nbsp;&nbsp;&nbsp;"._NLLOCATIONADDRESS2."<br>\n"
       ."   &nbsp;&nbsp;&nbsp;<input type=text size=20 maxlength=50 name=city value=\"$loc[city]\">\n";
   echo "   <select name=state>\n";
   foreach ($country_array as $abrv => $long) {
      if ($loc[state] == $abrv) echo "    <option value=\"$abrv\" SELECTED>$long</option>\n";
      else echo "    <option value=\"$abrv\">$long</option>\n";
      }
   //*echo "   &nbsp;&nbsp;&nbsp;<input type=text size=20 maxlength=50 name=state value=\"$loc[state]\">\n"
   echo "   </select>\n"
       ."   <input type=text size=6 maxlength=6 name=zip value=\"$zip[0]\">-<input type=text size=4 maxlength=4 name=xzip value=\"$zip[1]\"><br>\n"
       ."   <br>\n"
       ."   <input type=submit value=\""._NLEDITLOCATION2."\">\n"
       ."   </form>\n";
       
   }

// adds the location to database
function addLocation($keyword, $addr, $city, $state, $zip, $xzip) {
    global $db, $prefix, $admin_file;
   if ($zip && $xzip) $zip .= '-'.$xzip;
   if (!$keyword || !$addr || !$city || !$state || !$zip) showAddForm($keyword, $addr, $city, $state, $zip, $xzip, ""._NLREQUIREDFIELDS."");
   elseif ($db->sql_numrows($db->sql_query("SELECT loc_id FROM nukelan_locations WHERE keyword='$keyword'"))) showAddForm($keyword, $addr, $city, $state, $zip, $xzip, ""._NLKEYWORDINUSE."");
   elseif (!$db->sql_query("INSERT INTO nukelan_locations SET keyword='$keyword', addr='$addr', city='$city', state='$state', zip='$zip'")) die (""._NLCANNOTINSERT."");
   else {
      echo "   <center>\n"
          ."    <h2>"._NLLOCATIONADDED."</h2>\n"
          ."   </center>";
          header( "refresh: 1; url=".$admin_file.".php?op=add_location_lans" );
      }
   }

// updates a location
function updateLocation($loc_id, $keyword, $addr, $city, $state, $zip, $xzip) {
    global $db, $prefix, $admin_file;
   if ($zip && $xzip) $zip .= '-'.$xzip;
   if (!$keyword || !$addr || !$city || !$state || !$zip) {
      echo ""._NLREQUIREDFIELDS."";
      editLocation($loc_id);
      }
   elseif (!$db->sql_query("UPDATE nukelan_locations SET keyword='$keyword', addr='$addr', city='$city', state='$state', zip='$zip' WHERE loc_id='$loc_id'")) die (""._NLCANNOTUPDATE."");
   else {
      echo "   <center>\n"
          ."    <h2>"._NLLOCATIONUPDATED."</h2>\n"
          ."   </center>";
        header( "refresh: 1; url=".$admin_file.".php?op=add_location_lans" );
      }
   }

function deleteLocation($deleteLoc) {
    global $db, $prefix, $admin_file;
   $result = $db->sql_query("SELECT keyword FROM nukelan_parties WHERE loc='$deleteLoc'");
   if ($db->sql_numrows($result)) while ($name = $db->sql_fetchrow($result)) {
      $error .= "$name[keyword] "._NLLANUSINGLOCATION."<br>";
      }
   elseif (!$db->sql_query("DELETE FROM nukelan_locations WHERE loc_id='$deleteLoc'")) $error .= ""._NLCANNOTDELETELOCATION."<br>";
   else echo "<h2>"._NLLOCATIONDELETED."</h2>";
   echo $error;
   }

switch ($lanop) {
   case "add_new":
      addLocation($keyword, $addr, $city, $state, $zip, $xzip);
      break;
   case "update_loc":
      updateLocation($loc_id, $keyword, $addr, $city, $state, $zip, $xzip);
      break;
   case "edit_loc":
      editLocation($editLoc);
      break;
   case "delete_loc":
      deleteLocation($deleteLoc);
      break;
   default:
      showAddForm('','','','','','','');
      break;
   }

CloseTable();
include ("footer.php");

?>
