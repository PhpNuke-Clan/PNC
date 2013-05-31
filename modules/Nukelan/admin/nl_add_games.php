<?php
// filename: add_games.php

if (!defined('ADMIN_FILE')) {
        die ("Access Denied");
}

include ("header.php");

lan_menu();
OpenTable();
global $db, $prefix,  $editGame, $deleteGame, $admin_file;
// output an edit/delete box for current parties
if ($db->sql_numrows($result = $db->sql_query("SELECT * FROM nukelan_games ORDER BY name"))) {
   echo "   <table border=0>\n"
       ."    <tr>\n"
       ."     <td>\n"
       ."      <form action=\"".$admin_file.".php\" method=\"post\" style=\"margin: 0;\">\n"
       ."       <input type=hidden name=op value=add_games>\n"
       ."       <input type=hidden name=lanop value=edit_game>\n"
       ."       <b>"._NLEDITGAME."&nbsp;&nbsp;</b>\n"
       ."       <select name=editGame>\n";
   while ($row = $db->sql_fetchrow($result)) {
                if ($row['gameid']== $editGame) echo "<option value=\"$row[gameid]\" SELECTED>$row[name]</option>";
                else echo "        <option value=\"$row[gameid]\">$row[name]</option>\n";
                }
   echo "       </select>\n"
       ."       <input type=submit value=\""._NLEDIT."\">\n"
       ."      </form>\n"
       ."     </td>\n";
   $result = $db->sql_query("SELECT * FROM nukelan_games ORDER BY name");
   echo "     <td>&nbsp;&nbsp;</td>\n"
       ."     <td>\n"
       ."      <form action=\"".$admin_file.".php\" method=\"post\" style=\"margin: 0;\">\n"
       ."       <input type=hidden name=op value=add_games>\n"
       ."       <input type=hidden name=lanop value=delete_game>\n"
       ."       <b>"._NLDELETEGAME."&nbsp;&nbsp;</b>\n"
       ."       <select name=deleteGame>\n";
   while ($row = $db->sql_fetchrow($result)) {
                if ($row['gameid']== $deleteGame) echo "<option value=\"$row[gameid]\" SELECTED>$row[name]</option>";
                else echo "        <option value=\"$row[gameid]\">$row[name]</option>\n";
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
function showAddForm($name, $current_ver, $error) {
   global $db, $prefix,  $ModName, $pntable, $admin_file;
   echo "   <form action=\"".$admin_file.".php\" method=\"post\">\n"
       ."   <input type=hidden name=op value=\"add_games\">\n"
       ."   <input type=hidden name=lanop value=\"add_new\">\n"
       ."   <center>\n"
       ."    <h3>"._NLADDGAME."</h3>\n";
   if ($error) echo "   $error<br>\n";
   echo "   </center>\n"
       ."   "._NLGAMENAME."<br>\n"
       ."   <input type=text size=40 maxlength=255 name=name value=\"$name\"><br>\n"
           ."   "._NLVERSION."<br>\n"
           ."   <input type=text size=10 maxlength=10 name=current_ver value=\"$current_ver\"><br>\n"
       ."   <br>\n"
       ."   <input type=submit value=\""._NLADDGAME."\">\n"
       ."   </form>\n";
   }

// adds party to database
function addJob($name, $current_ver) {
   global $db, $prefix,  $pntable, $admin_file;

   if (!$name) showAddForm($name, $current_ver, ""._NLSUPPLYGAMENAME."");
   elseif ($db->sql_numrows($db->sql_query("SELECT * FROM nukelan_games WHERE name='$name'"))) showAddForm($name, $current_ver, ""._NLGAMENAMEINUSE."");
   elseif (!$db->sql_query("INSERT INTO nukelan_games (name, version) Values ('$name', '$current_ver')")) showAddForm($name, $current_ver, ""._NLCANNOTUPDATEGAME."");
   else {
      echo "   <center>\n"
          ."    <h2>$name "._NLGAMEADDED."</h2>\n"
          ."   </center>";
          header( "refresh: 1; url=".$admin_file.".php?op=add_games" );
      }
   }

// edits a party
function editGame($editGame, $error) {
   global $db, $prefix,  $pntable, $admin_file;
$row = $db->sql_fetchrow($db->sql_query("SELECT * FROM nukelan_games WHERE gameid='$editGame'"));
   echo "   <form action=\"".$admin_file.".php\" method=\"post\">\n"
       ."   <input type=hidden name=op value=\"add_games\">\n"
       ."   <input type=hidden name=lanop value=\"update\">\n"
           ."   <input type=hidden name=editGame value=$editGame>\n"
       ."   <center>\n"
       ."    <h3>"._NLEDITGAME."</h3>\n";
   if ($error) echo "   $error<br>\n";
   echo "   </center>\n"
       ."   "._NLGAMENAME."<br>\n"
       ."   <input type=text size=40 maxlength=255 name=name value=\"$row[name]\"><br>\n"
           ."   "._NLVERSION."<br>\n"
           ."   <input type=text size=10 maxlength=10 name=current_ver value=\"$row[version]\"><br>\n"
       ."   <br>\n"
       ."   <input type=submit value=\""._NLEDITGAME."\">\n"
       ."   </form>\n";
   }
// updates database
//function updateGame($editGame, $name, $current_ver, $url_updates, $url_maps) {
function updateGame($editGame, $name, $current_ver) {
   global $db, $prefix,  $ModName, $pntable, $admin_file;
   if (!$name) editGame($editGame, ""._NLSUPPLYGAMENAME."");
   elseif (!$db->sql_query("UPDATE nukelan_games SET name='$name',version='$current_ver' WHERE gameid='$editGame'")) editGame($editGame, ""._NLCANNOTUPDATEGAME."");
   else {
      echo "   <center>\n"
          ."    <h2>"._NLGAMEUPDATED."</h2>\n"
          ."   </center><br><br>\n"
          ."   Game_ID =".$editGame."<br>"
          ."   "._NLGAMENAME." =".$name."<br>"
          ."   editGame =".$editGame."<br>"
          ."   "._NLVERSION."=".$current_ver."<br>";
        header( "refresh: 1; url=".$admin_file.".php?op=add_games" );
            }
   }
function deleteGame($deleteGame) {
   global $db, $prefix,  $ModName, $pntable, $admin_file;
   if (!$db->sql_query("DELETE FROM nukelan_games WHERE gameid='$deleteGame'")) $error .= ""._NLCANNOTDELETEGAME."";
   if ($error) echo $error;
   else echo "<center><h2>"._NLGAMEDELETED."</h2></center>";
             header( "refresh: 1; url=".$admin_file.".php?op=add_games" );
   }

switch ($lanop) {
   case 'add_new':
      addJob($name, $current_ver);
      break;
   case 'edit_game':
      editGame($editGame, '');
      break;
   case 'update':
      updateGame($editGame, $name, $current_ver);
      break;
   case 'delete_game':
      deleteGame($deleteGame);
      break;
   default:
      showAddForm($name, $current_ver, $error);
      break;
   }
CloseTable();
include ("footer.php");
?>
