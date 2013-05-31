<?php
// filename: seating_chart.php (admin)

if (!defined('ADMIN_FILE')) {
        die ("Access Denied");
}
include ("header.php");
lan_menu();
OpenTable();
global $db, $prefix, $user_prefix, $admin_file, $editRoom;
$num_rooms = $db->sql_numrows($db->sql_query("SELECT * FROM nukelan_seat_rooms"));

if ($db->sql_numrows($result = $db->sql_query("SELECT * FROM nukelan_seat_rooms"))) {
   echo "   <br><br><table border=0>\n"
       ."    <tr>\n"
       ."     <td>\n"
       ."      <form action=\"".$admin_file.".php\" method=\"post\" style=\"margin: 0;\">\n"
       ."       <input type=hidden name=op value=add_seating>\n"
       ."       <input type=hidden name=lanop value=edit_room>\n"
       ."       <b>"._NLEDITROOM."&nbsp;&nbsp;</b>\n"
           ."       <select name=editRoom>\n";
   while ($row = $db->sql_fetchrow($result)) {
                if ($row['id'] == $editRoom) echo "<option value=\"$row[id]\" SELECTED>$row[name]</option>\n";
                else echo "        <option value=\"$row[id]\">$row[name]</option>\n";
   }
   echo "       </select>\n"
       ."       <input type=submit value=\""._NLEDIT."\">\n"
       ."      </form>\n"
       ."     </td>\n";
   $result = $db->sql_query("SELECT * FROM nukelan_seat_rooms");
   echo "     <td>&nbsp;&nbsp;</td>\n"
       ."     <td>\n"
       ."      <form action=\"".$admin_file.".php\" method=\"post\" style=\"margin: 0;\">\n"
       ."       <input type=hidden name=op value=add_seating>\n"
       ."       <input type=hidden name=lanop value=delete_room>\n"
           ."           <input type=hidden name=editRoom value=$editRoom>\n"
       ."       <b>"._NLDELETEROOM."&nbsp;&nbsp;</b>\n"
           ."       <select name=deleteRoom>\n";
   while ($row = $db->sql_fetchrow($result)) echo "        <option value=\"$row[id]\">$row[name]</option>\n";
   echo "       </select>\n"
       ."       <input type=submit value=\""._NLDELETE."\">\n"
       ."      </form>\n"
       ."     </td>\n"
       ."    </tr>\n"
       ."   </table>\n";
  // CloseTable();
   echo "   <br>\n";
 //  OpenTable();
   }

// shows form to add a party/also is where we redirect unfinnished forms
function showAddRoom($name, $des, $rwidth, $rheight, $error) {
   global $db, $prefix, $user_prefix, $ModName, $pntable, $admin_file;
     echo "   <br><br><table border=0>\n";
   echo "   <form action=\"".$admin_file.".php\" method=\"post\">\n"
       ."   <input type=hidden name=op value=\"add_seating\">\n"
       ."   <input type=hidden name=lanop value=\"add_room\">\n"
       ."   <center>\n"
       ."    <tr>\n"
       ."     <td COLSPAN=\"2\">\n"
       ."    <h3>"._NLADDROOM."</h3>\n";
           if ($error) echo "   $error<br>\n";
   echo "    </td></tr>\n";
   echo "    <tr><td>\n";
   echo "   </center>\n"
       ."   "._NLROOMNAME."</td><td>\n"
       ."   <input type=text size=40 maxlength=255 name=name value=\"$name\"></td></tr>\n"
       ."   <tr><td>"._NLROOMDESC."</td><td>\n"
       ."   <input type=text size=40 maxlength=255 name=des value=\"$des\"></td></tr>\n"
       ."   <tr><td>"._NLROOMDIM."</td></tr>\n"
       ."   <tr><td>"._NLROOMWIDTH."</td><td>\n"
       ."   <input type=text size=10 maxlength=11 name=rwidth value=\"$rwidth\"></td></tr>\n"
       ."   <tr><td>"._NLROOMHEIGHT."</td><td>\n"
       ."   <input type=text size=10 maxlength=11 name=rheight value=\"$rheight\"></td></tr>\n"
       ."   <br>\n"
       ."   <tr><td align=\"middle\"><input type=submit value=\""._NLADDROOM."\"></td></tr>\n"
       ."   </form>\n"
       ."     </td>\n"
       ."    </tr>\n"
       ."   </table>\n";
   }

function editRoom($editRoom, $error) {
global $db, $prefix, $user_prefix, $admin_file;
   $lan = $db->sql_fetchrow($db->sql_query("SELECT * FROM nukelan_seat_rooms WHERE id='$editRoom'"));
   echo "   <form action=\"".$admin_file.".php\" method=\"post\">\n"
       ."   <input type=hidden name=op value=\"add_seating\">\n"
       ."   <input type=hidden name=lanop value=\"update_room\">\n"
           ."   <input type=hidden name=room_id value=".$lan['id'].">\n"
           ."   <input type=hidden name=editRoom value=$editRoom>\n"
       ."   <center>\n"
       ."    <h3>"._NLEDITROOM2."</h3>\n";
           if ($error) echo "   $error<br>\n";
   echo "   </center>\n"
       ."   "._NLROOMNAME."<br>\n"
       ."   <input type=text size=40 maxlength=255 name=name value=\"$lan[name]\"><br>\n"
       ."   "._NLROOMDESC."<br>\n"
       ."   <input type=text size=40 maxlength=255 name=des value=\"$lan[description]\"><br><br>\n"
       ."   "._NLROOMDIM."<br>\n"
           ."   "._NLROOMWIDTH."<br>\n"
       ."   <input type=text size=10 maxlength=11 name=rwidth value=\"$lan[width]\"><br>\n"
       ."   "._NLROOMHEIGHT."<br>\n"
       ."   <input type=text size=10 maxlength=11 name=rheight value=\"$lan[height]\"><br>\n"
       ."   <br>\n"
       ."   <input type=submit value=\""._NLEDITROOM2."\">\n"
       ."   </form>\n";
           
        echo "$editRoom<br>";
        echo "$room_id<br>";
        echo "end<br>";
}

// adds room to database
function addRoom($name, $des, $rwidth, $rheight) {
        global $db, $prefix, $user_prefix, $admin_file;
   if (!$name || !$rwidth || !$rheight) showAddRoom($name, $des, $rwidth, $rheight, ""._NLROOMFIELDS."");
   elseif ($rwidth > 200) showAddRoom($name, $des, $rwidth, $rheight, ""._NLADJUSTWIDTH."");
   elseif ($rheight > 200) showAddRoom($name, $des, $rwidth, $rheight, ""._NLADJUSTHEIGHT."");
   elseif (!$db->sql_query("INSERT INTO nukelan_seat_rooms SET id ='NULL', name='$name', description='$des', width='$rwidth', height='$rheight'")) die (""._NLCANNOTINSERT."");
   else {
      echo "   <center>\n"
          ."    <h2>$name "._NLROOMADDED."</h2>\n"
          ."   </center>";
          header( "refresh: 1; url=".$admin_file.".php?op=add_seating" );
      }
   }
function updateRoom($room_id, $name, $des, $rwidth, $rheight) {
        global $db, $prefix, $user_prefix, $admin_file;
   if (!$name || !$rwidth || !$rheight) editRoom($roomid, ""._NLROOMFIELDS."");
   elseif ($rwidth > 200) editRoom($roomid, ""._NLADJUSTWIDTH."");
   elseif ($rheight > 200) editRoom($roomid, ""._NLADJUSTHEIGHT."");
   elseif (!$db->sql_query("UPDATE nukelan_seat_rooms SET name='$name', description='$des', width='$rwidth', height='$rheight' WHERE id='$room_id'")) die (""._NLCANNOTUPDATE."");
   else {
      echo "   <center>\n"
          ."    <h2>$name "._NLROOMUPDATED."</h2>\n"
          ."   </center>";
            header( "refresh: 1; url=".$admin_file.".php?op=add_seating&lanop=edit_room&editRoom=$room_id" );
      }
   }

function addTable($editRoom,$tname,$startx,$starty,$width,$height,$type,$capacity,$error) {
//OpenTable();
   global $db, $prefix, $user_prefix, $dbi, $aid, $admin_file;
   $row = $db->sql_fetchrow($db->sql_query("SELECT * FROM nuke_authors WHERE aid='$aid'"));
   $db->sql_query("DELETE FROM nukelan_map_temp WHERE aid='$aid'");
   $db->sql_query("INSERT INTO nukelan_map_temp SET aid='$row[aid]', room_id='$editRoom'");
   showTables($editRoom);
      //  administrationGrid
             echo "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">";
             echo"<tr><td colspan=\"4\" bgcolor=\"".$colors["cell_title"]."\">&nbsp;<font color=\"".$colors["primary"]."\">
             <b>administrator</b>: toggle grid</font></td></tr>";
             echo"<tr><td>";
             ?>
             <form action="<?php print $_SERVER["PHP_SELF"]; ?>?op=add_seating&lanop=edit_room&editRoom=<? print "$editRoom"?>&c=<?php print ($_GET["c"] ? $_GET["c"] : "0") ?>&grid=<?php print ($_GET["grid"] == 1 ? "0" : "1") ?>&roomid=<?php print "$editRoom" ?>" method="post">
             <br><input type="submit" value="<? echo""._NLTOGGLEGRID.""; ?>"><br>
             </form>
             </td></tr>
             </table>
              <?php
      //  End administrationGrid
   echo "   <center>\n"
       ."    <h3>"._NLADDOBJECT."</h3>\n";
   echo "<table border=\"1\" cellpadding=\"5\" cellspacing=\"0\" align ==\"middle\" bgcolor=\"000000\" width=\"100%\"><tr><td width=\"50%\">";
   echo "   <form action=\"".$admin_file.".php\" method=\"post\">\n"
       ."   <input type=hidden name=op value=\"add_seating\">\n"
       ."   <input type=hidden name=lanop value=\"add_object\">\n"
           ."   <input type=hidden name=editRoom value=$editRoom>\n";
           if ($error) echo "   $error<br>\n";
   echo "   </center>\n"
       ."   "._NLOBJECTNAME."<br>\n"
       ."   <input type=text size=40 maxlength=255 name=tname value=\"$tname\"><br>\n"
       ."   "._NLSTARTX."<br>\n"
       ."   <input type=text size=10 maxlength=11 name=startx value=\"$startx\"><br>\n"
           ."   "._NLSTARTY."<br>\n"
       ."   <input type=text size=10 maxlength=11 name=starty value=\"$starty\"><br><br>\n"
       ."   "._NLOBJECTWIDTH."<br>\n"
       ."   <input type=text size=10 maxlength=11 name=width value=\"$width\"><br>\n"
           ."   "._NLOBJECTHEIGHT."<br>\n"
       ."   <input type=text size=10 maxlength=11 name=height value=\"$height\"><br>\n"
           ."   "._NLOBJECTTYPE."<br>\n"
           ."   <select name=type>\n"
           ."   <option value=table SELECTED>"._NLOBTABLE."</option>\n"
           ."   <option value=void>"._NLOBVOID."</option>\n"
           ."   </select><br>\n"
       ."   "._NLMAXSEATS."<br>\n"
       ."   <input type=text size=10 maxlength=11 name=capacity value=\"$capacity\"><br>\n"
           ."   <input type=hidden name=room_id value='$editRoom'>\n"
       ."   <br>\n"
       ."   <input type=submit value=\""._NLADDOBJECT."\">\n"
       ."   </form>\n";
    echo"   </td>";
    echo"   <td valign=\"top\" width=\"10\">&nbsp;</td>";
    echo"   <td valign=\"top\" width=\"50%\">";

         // Show Objects for this room
               echo "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">";
               echo"<tr><td COLSPAN=\"4\" align=\"middle\"><h3>"._NLOBJECTLIST."</h3></td>";
              echo"<tr>";
              $result = $db->sql_query( "SELECT * FROM nukelan_seat_objects WHERE room_id='$editRoom'" );
                while ($rowlan = $db->sql_fetchrow( $result ) ){
                //id,type, userid,name,description,startx,starty,width,height,capacity,room_id
                $objectname = $rowlan['name'];
                $objectid = $rowlan['id'];
              echo "   <form action=\"".$admin_file.".php\" method=\"post\">\n"
                ."   <input type=hidden name=op value=\"add_seating\">\n"
                ."   <input type=hidden name=lanop value=\"edit_object\">\n";
               echo"   <input type=hidden name=editObject value=$objectid>\n";
               echo"<tr><td>"._NLOBJECTNAME."</td><td colspan=\"\">".$rowlan['name']."</td>";
               echo"   <td width=\"20\"><input type=submit value=\""._NLEDITOBJECTLIST."\"></td>\n"
                ."   </form>\n";
                //Delete Object
                echo "<form action=\"".$admin_file.".php\" method=\"post\">\n"
                ."<input type=hidden name=op value=\"add_seating\">\n"
                ."<input type=hidden name=lanop value=\"delete_object\">\n"
                ."<input type=hidden name=deleteObject  value=$objectid\">\n"
                ."<input type=hidden name=editRoom value=$editRoom>\n"
                ."<td> <input type=submit value=\""._NLOBJECTDELETELIST."\">\n"
                ."</form></td>\n"
                //End Delete Object
                ."   </tr>\n";
              }
               echo"";
               echo "</table>";
      echo"   </td></tr>";
      echo"   </table>";
         // End Show Objects for this room
         // Edit Room
        $lan = $db->sql_fetchrow($db->sql_query("SELECT * FROM nukelan_seat_rooms WHERE id='$editRoom'"));
      echo "   <table border=\"0\" align=\"middle\">\n"
       ."    <tr>\n"
       ."     <td COLSPAN=\"2\">\n";
   echo "   <form action=\"".$admin_file.".php\" method=\"post\">\n"
       ."   <input type=hidden name=op value=\"add_seating\">\n"
       ."   <input type=hidden name=lanop value=\"update_room\">\n"
           ."   <input type=hidden name=room_id value='$editRoom'>\n"
       ."   <center>\n"
       ."    <h3>"._NLEDITROOM2."</h3>\n";
           if ($error) echo "   $error<br>\n";
   echo "       </td>\n"
        ."    </tr>\n";
   echo "   </center>\n"
       ."    <tr>\n"
       ."     <td>\n"
       ."   "._NLROOMNAME."</td><td>\n"
       ."   <input type=text size=40 maxlength=255 name=name value=\"$lan[name]\"></td>\n"
        ."    </tr><tr><td>\n"
       ."   "._NLROOMDESC."</td><td>\n"
       ."   <input type=text size=40 maxlength=255 name=des value=\"$lan[description]\"></td>\n"
        ."    </tr>\n"
       ."    <tr>\n"
       ."     <td COLSPAN=\"2\">\n"
       ."   "._NLROOMDIM."\n"
       ."       </td>\n"
        ."    </tr>\n"
        ."    <tr>\n"
       ."     <td>\n"
       ."   "._NLROOMWIDTH."</td><td>\n"
       ."   <input type=text size=10 maxlength=11 name=rwidth value=\"$lan[width]\"></td>\n"
        ."    </tr>\n"
        ."    <tr>\n"
        ."    <td>\n"
       ."   "._NLROOMHEIGHT."</td><td>\n"
       ."   <input type=text size=10 maxlength=11 name=rheight value=\"$lan[height]\"></td>\n"
       ."   </tr><tr><td COLSPAN=\"2\" align = \"middle\">\n"
       ."   <input type=submit value=\""._NLEDITROOM2."\">\n"
       ."   </form>\n"
       ."   </td></tr></table>\n";

       //end edit room
}

function addObject($tname,$startx,$starty,$width,$height,$type,$capacity,$room_id) {
        global $db, $prefix, $user_prefix, $admin_file;
   if (!$startx || !$starty || !$width || !$height) addTable($room_id,$tname,$startx,$starty,$width,$height,$type,$capacity, ""._NLREQUIREDFIELDS."");
   elseif (!$db->sql_query("INSERT INTO nukelan_seat_objects SET id='NULL', type='$type', name='$tname', description='$tname', startx='$startx', starty='$starty', width='$width', height='$height', capacity='$capacity', room_id='$room_id'")) die (""._NLCANNOTINSERT."");
   else {
      echo "   <center>\n"
          ."    <h2>"._NLOBJECTADDED."</h2>\n"
          ."   </center>";
          header( "refresh: 1; url=".$admin_file.".php?op=add_seating&lanop=edit_room&editRoom=$room_id" );
      }
   }

// edits seat objects
function editObject($editObject, $error) {
global $db, $prefix, $user_prefix, $admin_file;
   $lan = $db->sql_fetchrow($db->sql_query("SELECT * FROM nukelan_seat_objects WHERE id='$editObject'"));
   $editRoom = "$lan[room_id]";
   showTables($editRoom);
   echo "   <form action=\"".$admin_file.".php\" method=\"post\">\n"
       ."   <input type=hidden name=op value=\"add_seating\">\n"
       ."   <input type=hidden name=lanop value=\"update_object\">\n"
       ."   <input type=hidden name=id value=\"$lan[id]\">\n"
       ."   <center>\n"
       ."    <h3>"._NLEDITOBJECT."</h3>\n";
   if ($error) echo "   $error<br>\n";
   echo "   </center>\n"
       ."   "._NLOBJECTNAME."<br>\n"
       ."   <input type=text size=40 maxlength=255 name=tname value=\"$lan[name]\"><br>\n"
       ."   "._NLSTARTX."<br>\n"
       ."   <input type=text size=10 maxlength=11 name=startx value=\"$lan[startx]\"><br>\n"
           ."   "._NLSTARTY."<br>\n"
       ."   <input type=text size=10 maxlength=11 name=starty value=\"$lan[starty]\"><br><br>\n"
       ."   "._NLOBJECTWIDTH."<br>\n"
       ."   <input type=text size=10 maxlength=11 name=width value=\"$lan[width]\"><br>\n"
           ."   "._NLOBJECTHEIGHT."<br>\n"
       ."   <input type=text size=10 maxlength=11 name=height value=\"$lan[height]\"><br>\n"
           ."   "._NLOBJECTTYPE."<br>\n"
           ."   <select name=type>\n";
           if( $lan["type"] == "table"){$t = "SELECTED"; $v = "";}
           else{$t = ""; $v = "SELECTED";}
   echo "   <option value=table ".$t.">"._NLOBTABLE."</option>\n"
       ."   <option value=void ".$v.">"._NLOBVOID."</option>\n"
       ."   </select><br>\n"
       ."   "._NLMAXSEATS."<br>\n"
       ."   <input type=text size=10 maxlength=11 name=capacity value=\"$lan[capacity]\"><br>\n"
       ."   <br>\n"
        ."<input type=hidden name=editRoom value=$editRoom>\n"
       ."   <input type=submit value=\""._NLEDITOBJECT."\">\n"
       ."   </form>\n";
   echo "<form action=\"".$admin_file.".php\" method=\"post\">\n"
       ."<input type=hidden name=op value=\"add_seating\">\n"
           ."<input type=hidden name=lanop value=\"delete_object\">\n"
           ."<input type=hidden name=deleteObject value=\"$lan[id]\">\n"
           ."<input type=hidden name=editRoom value=$editRoom>\n"
           ."<input type=submit value=\""._NLDELETEOBJECT."\">\n"
           ."</form>\n";
                     //    echo" <tr><td valign=\"top\">";
              ?>

                                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                        <tr><td colspan="4" bgcolor="<?=$colors["cell_title"]?>">&nbsp;<font color="<?=$colors["primary"]?>"><b>administrator</b>: toggle grid</font></td></tr>
                                        <tr><td>
                                        <form action="<?php print $_SERVER["PHP_SELF"]; ?>?op=add_seating&lanop=edit_object&editObject=<?php print "$lan[id]"?>&c=<?php print ($_GET["c"] ? $_GET["c"] : "0") ?>&grid=<?php print ($_GET["grid"] == 1 ? "0" : "1") ?>&roomid=<?php print "$editRoom" ?>" method="post">
                                        <br><input type="submit" value="<? echo""._NLTOGGLEGRID.""; ?>"><br>
                                        </form>
                                        </td></tr>
                                        </table>
                <?php
                // echo "</td>\n"
                // ."    </tr>\n";


   }

// updates database
function updateObject($id,$tname,$startx,$starty,$width,$height,$type,$capacity) {
        global $db, $prefix, $user_prefix, $admin_file, $editRoom;
   if (!$startx || !$starty || !$width || !$height) editObject($editObject, ""._NLREQUIREDFIELDS."");
   elseif (!$db->sql_query("UPDATE nukelan_seat_objects SET type='$type', userid='0', name='$tname', description='$tname', startx='$startx', starty='$starty', width='$width', height='$height', capacity='$capacity'  WHERE id='$id'")) die (""._NLCANNOTUPDATE."");
   else {
      echo "   <center>\n"
          ."    <h2>$tname "._NLOBJECTUPDATED."</h2>\n"
          ."   </center><br><br>\n"
          ."   ID =".$id."<br>"
          ."   Name =".$tname."<br>"
          ."   Start X =".$startx."<br>"
          ."   Start Y =".$starty."<br>"
          ."   Width =".$width."<br>"
          ."   Height =".$height."<br>"
          ."   Object Type =".$type."<br>"
          ."   Max_Users =".$capacity."<br>";
   header( "refresh: 1; url=".$admin_file.".php?op=add_seating&lanop=edit_room&editRoom=$editRoom" );
      }
   }
function deleteRoom($deleteRoom) {
        global $db, $prefix, $user_prefix, $admin_file;
if (!$db->sql_query("DELETE FROM nukelan_seat_rooms WHERE id='$deleteRoom'")) $error .= ""._NLCANNOTDELETEROOM."";
elseif (!$db->sql_query("DELETE FROM nukelan_seat_objects WHERE room_id='$deleteRoom'")) $error .= ""._NLCANNOTDELETEOBJECTS."";

if ($error) echo $error;
else echo "<center><h2>"._NLROOMDELETED."</h2></center>";
}
function deleteObject($deleteObject) {
        global $db, $prefix, $user_prefix, $admin_file;
   if (!$db->sql_query("DELETE FROM nukelan_seat_objects WHERE id='$deleteObject'")){ $error .= ""._NLCANNOTDELETEOBJECT."";
   }
   if ($error) echo $error;
   else echo "<center><h2>"._NLOBJECTDELETED."</h2></center>";
   header( "refresh: 1; url=".$admin_file.".php?op=add_seating&lanop=edit_room&editRoom=$room_id" );    
   }

function showTables($editRoom) {
        global $db, $prefix, $user_prefix, $admin_file;
?>
                <table border="0" cellpadding="1" cellspacing="0" width="100%">
                        <tr><td align="center" colspan="2" bgcolor="<?=$bgcolor?>"><?php
                        //if($_POST["act"] != "admindeleteallrooms") {
                        ?>
                                <img src="modules.php?name=<? echo "Nukelan"; ?>&file=seating_image&c=<?php print ($_GET["c"] ? $_GET["c"] : "0") ?>&grid=<?php print ($_GET["grid"] == 1 ? "1" : "0") ?>&roomid=<?php print "$editRoom" ?>" name="seat" usemap="#seatmap" border="0" ismap>
                                <?php require_once("modules/Nukelan/admin/incl/seating_map.php");
                        //}
                        ?>
                        </td></tr>
                        </table>
                        <?php

}

switch ($lanop) {
   case 'add_room':
      addRoom($name, $des, $rwidth, $rheight);
      break;
   case 'edit_room':
      addTable($editRoom,'','','','','','','','');
      break;
   case 'update_room':
      updateRoom($room_id, $name, $des, $rwidth, $rheight);
      break;
   case 'delete_room':
      deleteRoom($deleteRoom);
      break;
   case 'add_object':
      addObject($tname,$startx,$starty,$width,$height,$type,$capacity,$room_id);
          break;
   case 'edit_object':
      editObject($editObject, $error);
          break;
   case 'delete_object':
      deleteObject($deleteObject);
          break;
   case 'update_object':
      updateObject($id,$tname,$startx,$starty,$width,$height,$type,$capacity);
          break;
   default:
          showAddRoom('','','','','');
      break;
   }
CloseTable();
include ("footer.php");
?>
