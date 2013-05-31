<?php
// filename: add_prizes.php

if (!defined('ADMIN_FILE')) {
        die ("Access Denied");
}
include ("header.php");

lan_menu();
OpenTable();
global $db, $prefix, $user_prefix, $editPrize, $admin_file;
if ($db->sql_numrows($result = $db->sql_query("SELECT prizeid, prizename FROM nukelan_prizes ORDER BY prizename"))) {
   echo "   <table border=0>\n"
       ."    <tr>\n"
       ."     <td>\n"
       ."      <form action=\"".$admin_file.".php\" method=\"post\" style=\"margin: 0;\">\n"
       ."       <input type=hidden name=op value=add_prize>\n"
       ."       <input type=hidden name=lanop value=edit_prize>\n"
       ."       <b>"._NLEDITPRIZE."&nbsp;&nbsp;</b>\n"
       ."       <select name=editPrize>\n";
   while ($row = $db->sql_fetchrow($result)) {
                if ($row[prizeid]== $editPrize) echo "<option value=\"$row[prizeid]\" SELECTED>$row[prizename]</option>";
                else echo "        <option value=\"$row[prizeid]\">$row[prizename]</option>\n";
                }
   echo "       </select>\n"
       ."       <input type=submit value=\""._NLEDIT."\">\n"
       ."      </form>\n"
       ."     </td>\n";
   $result = $db->sql_query("SELECT prizeid, prizename FROM nukelan_prizes");
   echo "     <td>&nbsp;&nbsp;</td>\n"
       ."     <td>\n"
       ."      <form action=\"".$admin_file.".php\" method=\"post\" style=\"margin: 0;\">\n"
       ."       <input type=hidden name=op value=add_prize>\n"
       ."       <input type=hidden name=lanop value=delete_prize>\n"
       ."       <b>"._NLDELETEPRIZE."&nbsp;&nbsp;</b>\n"
       ."       <select name=deletePrize>\n";
   while ($row = $db->sql_fetchrow($result)) echo "        <option value=\"$row[prizeid]\">$row[prizename]</option>\n";
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
function showAddForm($prizename, $prizevalue, $prizequantity,  $prizepicture, $tourneyid, $tourneyplace, $partyid, $error) {
global $db, $prefix, $user_prefix, $admin_file;
$tourney = $db->sql_query("SELECT tourneyid, name FROM nukelan_tournaments ORDER BY name");
$parties = $db->sql_query("SELECT party_id, keyword FROM nukelan_parties ORDER BY keyword");
  
   echo "   <form action=\"".$admin_file.".php\" method=\"post\">\n"
       ."   <input type=hidden name=op value=\"add_prize\">\n"
       ."   <input type=hidden name=lanop value=\"add_new\">\n"
       ."   <center>\n"
       ."    <h3>"._NLADDPRIZE."</h3>\n";
   if ($error) echo "   $error<br>\n";
   echo "   </center>\n"
       ."   <b>"._NLPRIZEINFO."</b><br>\n"
       ."   &nbsp;&nbsp;&nbsp;"._NLPRIZENAME."<br>\n"
       ."   &nbsp;&nbsp;&nbsp;<input type=text size=50 maxlength=255 name=prizename value=\"$prizename\"><br>\n"
       ."   &nbsp;&nbsp;&nbsp;"._NLPRIZEVALUE."<br>\n"
       ."   &nbsp;&nbsp;&nbsp;<input type=text size=50 maxlength=10 name=prizevalue value=\"$prizevalue\"><br>\n"
           ."   &nbsp;&nbsp;&nbsp;"._NLPRIZEQUANTITY."<br>\n"
           ."   &nbsp;&nbsp;&nbsp;<input type=text size=50 maxlength=20 name=prizequantity value=\"$prizequantity\"><br>\n"
           ."   &nbsp;&nbsp;&nbsp;"._NLPRIZEIMAGE."<br>\n"
           ."   &nbsp;&nbsp;&nbsp;<input type=text size=50 maxlength=255 name=prizepicture value=\"$prizepicture\"><br>\n"
           ."   &nbsp;&nbsp;&nbsp;"._NLPRIZETOURNEY."<br>\n"
       ."   &nbsp;&nbsp;&nbsp;<select name=tourneyid>\n"
           ."   &nbsp;&nbsp;&nbsp;<option value=0>"._NLPRIZENOTINTOURNEY."</option>\n";
   while ($row = $db->sql_fetchrow($tourney)) echo " <option value=\"$row[tourneyid]\">$row[name]</option>\n";
   echo "  </select><br>\n"
       ."   &nbsp;&nbsp;&nbsp;"._NLPRIZETOURNEYPLACE."<br>\n"
       ."   &nbsp;&nbsp;&nbsp;<select name=tourneyplace>\n"
           ."   &nbsp;&nbsp;&nbsp;<option value=0>"._NLPRIZENOTINTOURNEY."</option>\n"
           ."   &nbsp;&nbsp;&nbsp;<option value=1>"._NLPRIZEPLACE1."</option>\n"
           ."   &nbsp;&nbsp;&nbsp;<option value=2>"._NLPRIZEPLACE2."</option>\n"
           ."   &nbsp;&nbsp;&nbsp;<option value=3>"._NLPRIZEPLACE3."</option>\n"
           ."   &nbsp;&nbsp;&nbsp;<option value=4>"._NLPRIZEPLACE4."</option>\n"
           ."   &nbsp;&nbsp;&nbsp;</select><br>\n"
           ."   &nbsp;&nbsp;&nbsp;"._NLPRIZEPICKLAN."<br>\n"
           ."   &nbsp;&nbsp;&nbsp;<select name=partyid>\n";
   while ($row = $db->sql_fetchrow($parties)) echo "<option value=\"$row[party_id]\">$row[keyword]</option>\n";
   echo " </select><br>\n"
       ."  &nbsp;&nbsp;&nbsp; <input type=submit value=\""._NLADDPRIZE."\">\n"
       ."   </form>";
   }

// this allows us to edit a prize
function editPrize($editPrize) {
global $db, $prefix, $user_prefix, $admin_file;
$tourney = $db->sql_query("SELECT tourneyid, name FROM nukelan_tournaments ORDER BY name");
$parties = $db->sql_query("SELECT party_id, keyword FROM nukelan_parties ORDER BY keyword");
   if (!$loc = $db->sql_fetchrow($db->sql_query("SELECT * FROM nukelan_prizes WHERE prizeid='$editPrize'"))) die (""._NLCANNOTACCESSPRIZE."");
if ($loc[tourneyplace] == 1) {
$chk1 = 'selected';
$chk2 = '';
$chk3 = '';
$chk4 = '';
}
elseif ($loc[tourneyplace] == 2) {
$chk1 = '';
$chk2 = 'selected';
$chk3 = '';
$chk4 = '';
}
elseif ($loc[tourneyplace] == 3) {
$chk1 = '';
$chk2 = '';
$chk3 = 'selected';
$chk4 = '';
}
elseif ($loc[tourneyplace] == 4) {
$chk1 = '';
$chk2 = '';
$chk3 = '';
$chk4 = 'selected';
}
   
   echo "   <form action=\"".$admin_file.".php\" method=\"post\">\n"
       ."   <input type=hidden name=op value=\"add_prize\">\n"
       ."   <input type=hidden name=lanop value=\"update_prize\">\n"
       ."   <input type=hidden name=prizeid value=\"$editPrize\">\n"
       ."   <center>\n"
       ."    <h3>"._NLEDITPRIZE." $loc[prizename]</h3>\n"
       ."   </center>\n"
       ."   &nbsp;&nbsp;&nbsp;<b>"._NLPRIZEINFO."</b><br><br>\n"
           ."   &nbsp;&nbsp;&nbsp;"._NLPRIZENAME."<br>\n"
       ."   &nbsp;&nbsp;&nbsp;<input type=text size=50 maxlength=255 name=prizename value=\"$loc[prizename]\"><br>\n"
       ."   &nbsp;&nbsp;&nbsp;"._NLPRIZEVALUE."<br>\n"
       ."   &nbsp;&nbsp;&nbsp;<input type=text size=50 maxlength=10 name=prizevalue value=\"$loc[prizevalue]\"><br>\n"
           ."   &nbsp;&nbsp;&nbsp;"._NLPRIZEQUANTITY."<br>\n"
           ."   &nbsp;&nbsp;&nbsp;<input type=text size=50 maxlength=20 name=prizequantity value=\"$loc[prizequantity]\"><br>\n"
           ."   &nbsp;&nbsp;&nbsp;"._NLPRIZEIMAGE."<br>\n"
           ."   &nbsp;&nbsp;&nbsp;<input type=text size=50 maxlength=255 name=prizepicture value=\"$loc[prizepicture]\"><br>\n"
           ."   &nbsp;&nbsp;&nbsp;"._NLPRIZETOURNEY."<br>\n"
       ."   &nbsp;&nbsp;&nbsp;<select name=tourneyid>\n"
           ."   &nbsp;&nbsp;&nbsp;<option value=0>"._NLPRIZENOTINTOURNEY."</option>\n";
   while ($row = $db->sql_fetchrow($tourney)) {
      if ($loc[tourneyid] == $row[tourneyid]) echo " <option value=\"$row[tourneyid]\" SELECTED>$row[name]</option>\n";
          else echo "<option value=\"$row[tourneyid]\">$row[name]</option>";
          }
   echo "  </select><br>\n"
       ."   &nbsp;&nbsp;&nbsp;"._NLPRIZETOURNEYPLACE."<br>\n"
       ."   &nbsp;&nbsp;&nbsp;<select name=tourneyplace>\n"
           ."   &nbsp;&nbsp;&nbsp;<option value=0>"._NLPRIZENOTINTOURNEY."</option>\n"
           ."   &nbsp;&nbsp;&nbsp;<option value=1 $chk1>"._NLPRIZEPLACE1."</option>\n"
           ."   &nbsp;&nbsp;&nbsp;<option value=2 $chk2>"._NLPRIZEPLACE2."</option>\n"
           ."   &nbsp;&nbsp;&nbsp;<option value=3 $chk3>"._NLPRIZEPLACE3."</option>\n"
           ."   &nbsp;&nbsp;&nbsp;<option value=4 $chk4>"._NLPRIZEPLACE4."</option>\n"
           ."   &nbsp;&nbsp;&nbsp;</select><br>\n"
           ."   &nbsp;&nbsp;&nbsp;"._NLPRIZEPICKLAN."<br>\n"
       ."   &nbsp;&nbsp;&nbsp;<select name=partyid>\n";
   while ($row = $db->sql_fetchrow($parties)) {
      if ($loc[config_id] == $row[party_id]) echo " <option value=\"$row[party_id]\" SELECTED>$row[keyword]</option>\n";
          else echo "<option value=\"$row[party_id]\">$row[keyword]</option>";
          }
        echo "</select><br>\n"   
           ."   &nbsp;&nbsp;&nbsp;\n"
       ."  &nbsp;&nbsp;&nbsp; <input type=submit value=\""._NLUPDATEPRIZE."\">\n"
       ."   </form>";

}
// adds the location to database
function addPrize($prizename, $prizevalue, $prizequantity,  $prizepicture, $tourneyid, $tourneyplace, $partyid) {
global $db, $prefix, $user_prefix, $editPrize, $admin_file;
$party = $db->sql_fetchrow($db->sql_query("SELECT * FROM nukelan_tournaments WHERE tourneyid='$tourneyid'"));
if ($tourneyid < 1) $pid = "$partyid";
else $pid = "$party[config_id]";
        if (!$prizename) showAddForm($prizename, $prizevalue, $prizequantity,  $prizepicture, $tourneyid, $tourneyplace, $partyid, ""._NLREQUIREDFIELDS."");
   if (!$db->sql_query("INSERT INTO nukelan_prizes SET prizename='$prizename', prizevalue='$prizevalue', prizepicture='$prizepicture', prizequantity='$prizequantity', tourneyid='$tourneyid', tourneyplace='$tourneyplace', config_id='$pid'")) die (""._NLCANNOTINSERT."");
   else {
      echo "   <center>\n"
          ."    <h2>"._NLPRIZEADDED."</h2>\n"
          ."   </center>";
       Header("Refresh: 0;url=".$admin_file.".php?op=add_prize");
      }
   }

// updates a location
function updatePrize($prizeid, $prizename, $prizevalue, $prizequantity,  $prizepicture, $tourneyid, $tourneyplace, $partyid) {
global $db, $prefix, $user_prefix, $editPrize, $admin_file;
$party = $db->sql_fetchrow($db->sql_query("SELECT * FROM nukelan_tournaments WHERE tourneyid='$tourneyid'"));
if ($tourneyid < 1) $pid = "$partyid";
else $pid = "$party[config_id]";
   if (!$db->sql_query("UPDATE nukelan_prizes SET prizename='$prizename', prizevalue='$prizevalue', prizepicture='$prizepicture', prizequantity='$prizequantity', tourneyid='$tourneyid', tourneyplace='$tourneyplace', config_id='$pid' WHERE prizeid='$prizeid'")) die (""._NLCANNOTUPDATE."");
   else {
      echo "   <center>\n"
          ."    <h2>"._NLPRIZEUPDATED."</h2>\n"
          ."   </center>";
         Header("Refresh: 0;url=".$admin_file.".php?op=add_prize");
      }
   }

function deletePrize($deletePrize) {
global $db, $prefix, $user_prefix, $editPrize, $admin_file;
   if (!$db->sql_query("DELETE FROM nukelan_prizes WHERE prizeid='$deletePrize'")) $error .= ""._NLCANNOTDELETEPRIZE."<br>";
   else echo "<center><h2>"._NLPRIZEDELETED."</h2></center>";
   echo $error;
   }

switch ($lanop) {
   case "add_new":
      addPrize($prizename, $prizevalue, $prizequantity,  $prizepicture, $tourneyid, $tourneyplace, $partyid);
      break;
   case "update_prize":
      updatePrize($prizeid, $prizename, $prizevalue, $prizequantity, $prizepicture, $tourneyid, $tourneyplace, $partyid);
      break;
   case "edit_prize":
      editPrize($editPrize);
      break;
   case "delete_prize":
      deletePrize($deletePrize);
      break;
   default:
      showAddForm('', '', '', '', '', '', '', '');
      break;
   }

CloseTable();
include ("footer.php");

?>
