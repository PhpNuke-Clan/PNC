<?php
// filename: nl_add_party.php

if (!defined('ADMIN_FILE')) {
        die ("Access Denied");
}
//if (!authorised(0, 'LANParty::', '::', ACCESS_ADMIN)) die ('Access Denied: No permissions');

include ("header.php");
$module_name = "Nukelan";
lan_menu();
OpenTable();
//$pntable = pnDBGetTables();
global $db, $prefix, $user_prefix, $admin_file, $editParty;
// output an edit/delete box for current parties
if ($db->sql_numrows($result = $db->sql_query("SELECT party_id, keyword FROM nukelan_parties ORDER BY keyword"))) {
   echo "   <table border=0>\n"
       ."    <tr>\n"
       ."     <td>\n"
       ."      <form action=\"".$admin_file.".php\" method=\"post\" style=\"margin: 0;\">\n"
       ."       <input type=hidden name=op value=add_party_lans>\n"
       ."       <input type=hidden name=lanop value=edit_party>\n"
       ."       <b>"._NLEDITPARTY."&nbsp;&nbsp;</b>\n"
       ."       <select name=editParty>\n";
   while ($row = $db->sql_fetchrow($result)) {
   if ($row['party_id'] == $editParty) echo "<option value=\"$row[party_id]\" SELECTED>$row[keyword]</option>\n";
   else echo "<option value=\"$row[party_id]\">$row[keyword]</option>\n";
   }
   echo "       </select>\n"
       ."       <input type=submit value=\""._NLEDIT."\">\n"
       ."      </form>\n"
       ."     </td>\n";
   $result = $db->sql_query("SELECT party_id, keyword FROM nukelan_parties");
   echo "     <td>&nbsp;&nbsp;</td>\n"
       ."     <td>\n"
       ."      <form action=\"".$admin_file.".php\" method=\"post\" style=\"margin: 0;\">\n"
       ."       <input type=hidden name=op value=add_party_lans>\n"
       ."       <input type=hidden name=lanop value=delete_party>\n"
       ."       <b>"._NLDELETEPARTY."&nbsp;&nbsp;</b>\n"
       ."       <select name=deleteParty>\n";
   while ($row = $db->sql_fetchrow($result)) echo "        <option value=\"$row[party_id]\">$row[keyword]</option>\n";
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
function showAddForm($keyword, $month, $day, $year, $time, $emonth, $eday, $eyear, $etime, $loc2, $host, $max, $charge_a, $charge_b, $charge_c, $charge_d, $charge_e, $name_a, $name_b, $name_c, $name_d, $name_e, $paypal, $disclaimer, $tinfo, $stop, $activechart, $prepay, $error) {
   global $db, $prefix, $user_prefix, $pntable, $admin_file, $module_name;
   include ("modules/$module_name/admin/incl/states.php");
   include ("modules/$module_name/admin/incl/months.php");
   include ("modules/$module_name/admin/incl/times.php");
   echo "   <form action=\"".$admin_file.".php\" method=\"post\">\n"
       ."   <input type=hidden name=op value=\"add_party_lans\">\n"
       ."   <input type=hidden name=lanop value=\"add_new\">\n"
       ."   <center>\n"
       ."    <h3>"._NLADDPARTY."</h3>\n";
   if ($error) echo "   $error<br>\n";
   echo "   </center>\n"
       ."   "._NLPARTYNAME."<br>\n"
       ."   <input type=text size=40 maxlength=40 name=keyword value=\"$keyword\"><br>\n"
       ."   "._NLPARTYSTART."<br>\n"
       ."   <select name=month>\n";
   foreach ($months as $num => $text) {
      if ($month == $num) echo "    <option value=\"$num\" SELECTED>$text</option>\n";
      else echo "    <option value=\"$num\">$text</option>\n";
      }
   echo "   </select>\n"
       ."   <select name=day>\n";
   for ($i = 1; $i <= 31; $i++) {
      if ($i == $day) echo "    <option value=\"$i\" SELECTED>$i</option>\n";
      else echo "    <option value=\"$i\">$i</option>\n";
      }
   echo "   </select>\n"
       ."   <input type=text size=4 maxlength=4 name=year value=\"$year\"><br>\n"
           ."   "._NLPARTYSTIME."<br>\n"
       ."   <select name=time>\n";
   foreach ($times as $unix => $formatted) {
      if ($time == $unix) echo "    <option value=\"$unix\" SELECTED>$formatted</option>\n";
      else echo "    <option value=\"$unix\">$formatted</option>\n";
      }
   echo "   </select><br>\n"
       ."   "._NLPARTYEND."<br>\n"
           ."   <select name=emonth>\n";
   foreach ($months as $num => $text) {
      if ($emonth == $num) echo "<option value=\"$num\" SELECTED>$text</option>\n";
          else echo "<option value=\"$num\">$text</option>\n";
          }
   echo "   </select>\n"
       ."   <select name=eday>\n";
         for ($i = 1; $i <= 31; $i++) {
           if ($i == $eday) echo " <option value=\"$i\" SELECTED>$i</option>\n";
           else echo " <option value=\"$i\">$i</option>\n";
           }
   echo " </select>\n"
       ."   <input type=text size=4 maxlength=4 name=eyear value=\"$eyear\"><br>\n"
           ."   "._NLPARTYETIME."<br>\n"
       ."   <select name=etime>\n";
   foreach ($times as $unix => $formatted) {
      if ($time == $unix) echo "    <option value=\"$unix\" SELECTED>$formatted</option>\n";
      else echo "    <option value=\"$unix\">$formatted</option>\n";
      }
           echo "</select><br>\n"
           ."   "._NLSELECTHOST."<br>\n"
       ."   <select name=host>\n";
   $result = $db->sql_query("SELECT host_id, fname FROM nukelan_hosts");
   while ($row = $db->sql_fetchrow($result)) {
      if ($host == $row['host_id']) {
         echo "    <option value=\"$row[host_id]\" SELECTED>";
         echo "$row[fname]";
         echo "</option>\n";
         }
      else {
         echo "    <option value=\"$row[host_id]\">";
         echo "$row[fname]";
         echo "</option>\n";
         }
      }
   echo "   </select><br>\n"
       ."   "._NLSELECTLOCATION."<br>\n"
       ."   <select name=loc2>\n";
   $result = $db->sql_query("SELECT loc_id, keyword FROM nukelan_locations");
   while ($row = $db->sql_fetchrow($result)) {
      if ($loc2 == $row['loc_id']) echo "    <option value=\"$row[loc_id]\" SELECTED>$row[keyword]</option>\n";
      else echo "    <option value=\"$row[loc_id]\">$row[keyword]</option>\n";
      }
   echo "   </select><br>\n"
       ."   "._NLSELECTPAYPAL."<br>\n"
       ."   <select name=paypal>\n"
       ."    <option value=\"0\">"._NLDONOTUSEPAYPAL."</option>\n";
   $result = $db->sql_query("SELECT paypal_id, keyword FROM nukelan_paypal");
   while ($row = $db->sql_fetchrow($result)) {
      if ($paypal == $row['paypal_id']) echo "    <option value=\"$row[paypal_id]\" SELECTED>$row[keyword]</option>\n";
      else echo "    <option value=\"$row[paypal_id]\">$row[keyword]</option>\n";
      }
   echo "   </select><br>\n"
           ."   "._NLPREPAY." <input type=checkbox name=prepay";
           if ($prepay) echo " CHECKED";
           echo "><br>\n"
       ."   "._NLSELECTSEATING."<br>\n"
       ."   <select name=schart>\n"
       ."    <option value=\"0\">"._NLDONOTUSESEATING."</option>\n";
   $result = $db->sql_query("SELECT id, name FROM nukelan_seat_rooms ORDER BY name");
   while ($row = $db->sql_fetchrow($result)) {
      if ($schart == $row['id']) echo "    <option value=\"$row[id]\" SELECTED>$row[name]</option>\n";
      else echo "    <option value=\"$row[id]\">$row[name]</option>\n";
      }
   echo "   </select><br>\n"
       ."   "._NLMAXUSERS."<br>\n"
       ."   <input type=text size=4 maxlength=4 name=max value=\"$lan[max]\"><br><br>"._NLGROUPFREE."<br>"
           ."   "._NLPRICEGROUP1."<br>"
           ."   <input type=text size=15 maxlength=35 name=name_a value=\"$name_a\">&nbsp;&nbsp;&nbsp;$<input type=text size=6 maxlength=6 name=charge_a value=\"$charge_a\"><br>\n"
           ."   "._NLPRICEGROUP2."<br>"
           ."   <input type=text size=15 maxlength=35 name=name_b value=\"$name_b\">&nbsp;&nbsp;&nbsp;$<input type=text size=6 maxlength=6 name=charge_b value=\"$charge_b\"><br>\n"
           ."   "._NLPRICEGROUP3."<br>"
           ."   <input type=text size=15 maxlength=35 name=name_c value=\"$name_c\">&nbsp;&nbsp;&nbsp;$<input type=text size=6 maxlength=6 name=charge_c value=\"$charge_c\"><br>\n"
           ."   "._NLPRICEGROUP4."<br>"
           ."   <input type=text size=15 maxlength=35 name=name_d value=\"$name_d\">&nbsp;&nbsp;&nbsp;$<input type=text size=6 maxlength=6 name=charge_d value=\"$charge_d\"><br>\n"
           ."   "._NLPRICEGROUP5."<br>"
           ."   <input type=text size=15 maxlength=35 name=name_e value=\"$name_e\">&nbsp;&nbsp;&nbsp;$<input type=text size=6 maxlength=6 name=charge_e value=\"$charge_e\"><br>\n"
           ."   "._NLEVENTINFO."<br>\n"
       ."   <textarea name=disclaimer style=\"width: 75%; height: 100px;\">$disclaimer</textarea><br>\n"
           ."   "._NLTOURNEYINFO."<br>\n"
       ."   <textarea name=tinfo style=\"width: 75%; height: 100px;\">$tinfo</textarea><br>\n"
           ."   "._NLSTOPSIGNUP." <input type=checkbox name=stop";
   if ($stop) echo " CHECKED";
   echo "><br>\n"
       ."   "._NLSTOPSEATING." <input type=checkbox name=activechart value='1'";
   if ($activechart) echo " CHECKED";
   echo ">\n"
       ."   <br>\n"
       ."   <br>\n"
       ."   <input type=submit value=\""._NLADDPARTY2."\">\n"
       ."   </form>\n";
   }

// adds party to database
function addParty($keyword, $month, $day, $year, $time, $emonth, $eday, $eyear, $etime, $loc2, $host, $max, $charge_a, $charge_b, $charge_c, $charge_d, $charge_e, $name_a, $name_b, $name_c, $name_d, $name_e, $paypal, $schart, $disclaimer, $tinfo, $stop, $activechart, $prepay) {
   global $db, $prefix, $user_prefix, $pntable, $admin_file;
   
   if($month && $day && $year && $time) $nl_date = "$year-$month-$day $time";
   if($emonth && $day && $eyear && $etime) $date2 = "$eyear-$emonth-$eday $etime";
   if($stop) $stop = '1';
   else $stop = '0';
   if($prepay) $prepay='1';
   else $prepay = '0';

   if (!$keyword || !$month || !$day || !$year || !$time ) showAddForm($keyword, $month, $day, $year, $time, $emonth, $eday, $eyear, $etime, $loc2, $host, $max, $charge_a, $charge_b, $charge_c, $charge_d, $charge_e, $name_a, $name_b, $name_c, $name_d, $name_e, $paypal, $schart, $disclaimer, $tinfo, $stop, $activechart, "Please make sure you fill in all required fields");
   elseif ($db->sql_numrows($db->sql_query("SELECT party_id FROM nukelan_parties WHERE keyword='$keyword'"))) showAddForm($keyword, $month, $day, $year, $time, $emonth, $eday, $eyear, $etime, $loc2, $host, $max, $charge_a, $charge_b, $charge_c, $charge_d, $charge_e, $name_a, $name_b, $name_c, $name_d, $name_e, $paypal, $schart, $disclaimer, $tinfo, $stop, $activechart, "That keyword is already in the database, please try another.");
   elseif (!$db->sql_query("INSERT INTO nukelan_parties SET keyword='$keyword', date='$nl_date', loc='$loc2', host='$host', max='$max', charge_a='$charge_a', charge_b='$charge_b', charge_c='$charge_c', charge_d='$charge_d', charge_e='$charge_e', name_a='$name_a', name_b='$name_b', name_c='$name_c', name_d='$name_d', name_e='$name_e', paypal='$paypal', disclaimer='$disclaimer', stop='$stop', enddate='$date2', schart='$schart', tinfo='$tinfo', active='$activechart', prepay='$prepay'")) die (""._NLCANNOTINSERT."");
   else {
      echo "   <center>\n"
          ."    <h2>$keyword "._NLPARTYADDED."</h2>\n"
          ."   </center>";
		         Header("Refresh: 0;url=".$admin_file.".php?op=add_party_lans");
      }
   }

// edits a party
function editParty($editParty, $error) {
   global $db, $prefix, $user_prefix, $pntable, $admin_file, $module_name;
   include ("modules/$module_name/admin/incl/states.php");
   include ("modules/$module_name/admin/incl/months.php");
   include ("modules/$module_name/admin/incl/times.php");
   $lan = $db->sql_fetchrow($db->sql_query("SELECT * FROM nukelan_parties WHERE party_id='$editParty'"));
   preg_match("/(.+)-(.+)-(.+) (.*)/i", "$lan[date]", $matches);
   $lan[year]  = $matches[1];
   $lan[month] = $matches[2];
   $lan[day]   = $matches[3];
   $lan[time]  = $matches[4];
   preg_match("/(.+)-(.+)-(.+) (.*)/i", "$lan[enddate]", $matches);
   $lan[eyear]  = $matches[1];
   $lan[emonth] = $matches[2];
   $lan[eday]   = $matches[3];
   $lan[etime]  = $matches[4];
   echo "   <form action=\"".$admin_file.".php\" method=\"post\">\n"
       ."   <input type=hidden name=op value=\"add_party_lans\">\n"
       ."   <input type=hidden name=lanop value=\"update\">\n"
       ."   <input type=hidden name=party_id value=\"$lan[party_id]\">\n"
       ."   <center>\n"
       ."    <h3>"._NLEDITPARTY."</h3>\n";
   if ($error) echo "   $error<br>\n";
   echo "<b>$lan[keyword]</b><br>";
      echo "   </center>\n"
           ."   "._NLPARTYNAME."<br>\n"
       ."   <input type=text size=40 maxlength=40 name=keyword value=\"$lan[keyword]\"><br>\n"
       ."   "._NLPARTYSTART."<br>\n"
       ."   <select name=month>\n";
   foreach ($months as $num => $text) {
      if ($lan['month'] == $num) echo "    <option value=\"$num\" SELECTED>$text</option>\n";
      else echo "    <option value=\"$num\">$text</option>\n";
      }
   echo "   </select>\n"
       ."   <select name=day>\n";
   for ($i = 1; $i <= 31; $i++) {
      if ($i == $lan['day']) echo "    <option value=\"$i\" SELECTED>$i</option>\n";
      else echo "    <option value=\"$i\">$i</option>\n";
      }
   echo "   </select>\n"
       ."   <input type=text size=4 maxlength=4 name=year value=\"$lan[year]\"><br>\n"
       ."   "._NLPARTYSTIME."<br>\n"
       ."   <select name=time>\n";
   foreach ($times as $unix => $formatted) {
      if ($lan['time'] == $unix) echo "    <option value=\"$unix\" SELECTED>$formatted</option>\n";
      else echo "    <option value=\"$unix\">$formatted</option>\n";
      }
   echo "   </select><br>\n"
   ."   "._NLPARTYEND."<br>\n"
       ."   <select name=emonth>\n";
   foreach ($months as $num => $text) {
      if ($lan['emonth'] == $num) echo "    <option value=\"$num\" SELECTED>$text</option>\n";
      else echo "    <option value=\"$num\">$text</option>\n";
      }
   echo "   </select>\n"
       ."   <select name=eday>\n";
   for ($i = 1; $i <= 31; $i++) {
      if ($i == $lan['eday']) echo "    <option value=\"$i\" SELECTED>$i</option>\n";
      else echo "    <option value=\"$i\">$i</option>\n";
      }
   echo "   </select>\n"
       ."   <input type=text size=4 maxlength=4 name=eyear value=\"$lan[eyear]\"><br>\n"
       ."  "._NLPARTYETIME."<br>\n"
       ."   <select name=etime>\n";
   foreach ($times as $unix => $formatted) {
      if ($lan[etime] == $unix) echo "    <option value=\"$unix\" SELECTED>$formatted</option>\n";
      else echo "    <option value=\"$unix\">$formatted</option>\n";
      }
   echo "   </select><br>\n"
       ."   "._NLSELECTHOST."<br>\n"
       ."   <select name=host>\n";
   $result = $db->sql_query("SELECT host_id, fname FROM nukelan_hosts");
   while ($row = $db->sql_fetchrow($result)) {
      if ($lan['host'] == $row['host_id']) {
         echo "    <option value=\"$row[host_id]\" SELECTED>";
         echo "$row[fname]";
         echo "</option>\n";
         }
      else {
         echo "    <option value=\"$row[host_id]\">";
         echo "$row[fname]";
         echo "</option>\n";
         }
      }
   echo "   </select><br>\n"
       ."   "._NLSELECTLOCATION."<br>\n"
       ."   <select name=loc2>\n";
   $result = $db->sql_query("SELECT loc_id, keyword FROM nukelan_locations");
   while ($row = $db->sql_fetchrow($result)) {
      if ($lan['loc'] == $row['loc_id']) echo "    <option value=\"$row[loc_id]\" SELECTED>$row[keyword]</option>\n";
      else echo "    <option value=\"$row[loc_id]\">$row[keyword]</option>\n";
      }
   echo "   </select><br>\n"
       ."   "._NLSELECTPAYPAL."<br>\n"
       ."   <select name=paypal>\n"
       ."    <option value=\"0\">"._NLDONOTUSEPAYPAL."</option>\n";
   $result = $db->sql_query("SELECT paypal_id, keyword FROM nukelan_paypal");
   while ($row = $db->sql_fetchrow($result)) {
      if ($lan[paypal] == $row[paypal_id]) echo "    <option value=\"$row[paypal_id]\" SELECTED>$row[keyword]</option>\n";
      else echo "    <option value=\"$row[paypal_id]\">$row[keyword]</option>\n";
      }
   echo "   </select><br>\n"
           ."   "._NLPREPAY." <input type=checkbox name=prepay";
           if ($lan['prepay']) echo " CHECKED";
           echo "><br>\n"
       ."   "._NLSELECTMAIL."<br>\n"
       ."   <select name=mail>\n"
       ."    <option value=\"0\">"._NLDONOTUSEMAIL."</option>\n";
   $result = $db->sql_query("SELECT mail_id, keyword FROM nukelan_mailorder");
   while ($row = $db->sql_fetchrow($result)) {
      if ($lan['mail'] == $row['mail_id']) echo "    <option value=\"$row[mail_id]\" SELECTED>$row[keyword]</option>\n";
      else echo "    <option value=\"$row[mail_id]\">$row[keyword]</option>\n";
      }
   echo "   </select><br>\n"
   ."   "._NLSELECTSEATING."<br>\n"
       ."   <select name=schart>\n"
       ."    <option value=\"0\">"._NLDONOTUSESEATING."</option>\n";
   $result = $db->sql_query("SELECT id, name FROM nukelan_seat_rooms ORDER BY name");
   while ($row = $db->sql_fetchrow($result)) {
      if ($lan['schart'] == $row['id']) echo "    <option value=\"$row[id]\" SELECTED>$row[name]</option>\n";
      else echo "    <option value=\"$row[id]\">$row[name]</option>\n";
      }
   echo "   </select><br>\n"
       ."   "._NLMAXUSERS."<br>\n"
       ."   <input type=text size=4 maxlength=4 name=max value=\"$lan[max]\"><br><br>"._NLGROUPFREE."<br>"
           ."   "._NLPRICEGROUP1."<br>"
           ."   <input type=text size=15 maxlength=35 name=name_a value=\"$lan[name_a]\">&nbsp;&nbsp;&nbsp;$<input type=text size=6 maxlength=6 name=charge_a value=\"$lan[charge_a]\"><br>\n"
           ."   "._NLPRICEGROUP2."<br>"
           ."   <input type=text size=15 maxlength=35 name=name_b value=\"$lan[name_b]\">&nbsp;&nbsp;&nbsp;$<input type=text size=6 maxlength=6 name=charge_b value=\"$lan[charge_b]\"><br>\n"
           ."   "._NLPRICEGROUP3."<br>"
           ."   <input type=text size=15 maxlength=35 name=name_c value=\"$lan[name_c]\">&nbsp;&nbsp;&nbsp;$<input type=text size=6 maxlength=6 name=charge_c value=\"$lan[charge_c]\"><br>\n"
           ."   "._NLPRICEGROUP4."<br>"
           ."   <input type=text size=15 maxlength=35 name=name_d value=\"$lan[name_d]\">&nbsp;&nbsp;&nbsp;$<input type=text size=6 maxlength=6 name=charge_d value=\"$lan[charge_d]\"><br>\n"
           ."   "._NLPRICEGROUP5."<br>"
           ."   <input type=text size=15 maxlength=35 name=name_e value=\"$lan[name_e]\">&nbsp;&nbsp;&nbsp;$<input type=text size=6 maxlength=6 name=charge_e value=\"$lan[charge_e]\"><br>\n"
           ."   "._NLEVENTINFO."<br>\n"
       ."   <textarea name=disclaimer style=\"width: 75%; height: 100px;\">$lan[disclaimer]</textarea><br>\n"
           ."   "._NLTOURNEYINFO."<br>\n"
       ."   <textarea name=tinfo style=\"width: 75%; height: 100px;\">$lan[tinfo]</textarea><br>\n"
           ."   "._NLSTOPSIGNUP." <input type=checkbox name=stop";
   if ($lan['stop']) echo " CHECKED";
   echo "><br>\n"
       ."   "._NLSTOPSEATING." <input type=checkbox name=activechart value='1'";
   if ($lan['active']) echo " CHECKED";
   echo ">\n"
       ."   <br>\n"
       ."   <br>\n"
       ."   <input type=submit value=\""._NLEDITPARTY2."\">\n"
       ."   </form>\n";
   }

// updates database
function updateParty($party_id, $keyword, $month, $day, $year, $time, $emonth, $eday, $eyear, $etime, $loc2, $host, $max, $charge_a, $charge_b, $charge_c, $charge_d, $charge_e, $name_a, $name_b, $name_c, $name_d, $name_e, $paypal, $schart, $disclaimer, $tinfo, $stop, $activechart, $prepay) {
global $db, $prefix, $user_prefix, $admin_file, $editParty;

   //global $pntable;
$row2 = $db->sql_fetchrow($db->sql_query("SELECT * FROM nukelan_seat_rooms WHERE id='$schart'"));
   
   if($month && $day && $year && $time) $nl_date = "$year-$month-$day $time";
   if($emonth && $day && $eyear && $etime) $date2 = "$eyear-$emonth-$eday $etime";
   if($stop) $stop = '1';
   else $stop = '0';
   if($activechart) $activechart = '1';
   else $activechart = '0';
   if($prepay) $prepay = '1';
   else $prepay = '0';

   if (!$keyword || !$month || !$day || !$year || !$time || !$emonth || !$emonth || !$eday || !$etime ) editParty($editParty, "Please make sure you fill in all required fields");
   elseif (!$name_a) {echo "<center>Make sure "._NLPRICEGROUP1." field is filled in!!"; echo "<br><form>
			<input type=\"button\" value=\""._NLGOBACK."\" onclick=\"history.back()\" />
			</form></center>";
			}
   elseif (!$db->sql_query("UPDATE nukelan_parties SET keyword='$keyword', date='$nl_date', loc='$loc2', host='$host', max='$max', charge_a='$charge_a', charge_b='$charge_b', charge_c='$charge_c', charge_d='$charge_d', charge_e='$charge_e', name_a='$name_a', name_b='$name_b', name_c='$name_c', name_d='$name_d', name_e='$name_e', paypal='$paypal', disclaimer='$disclaimer', stop='$stop', enddate='$date2', schart='$schart', tinfo='$tinfo', active='$activechart', prepay='$prepay' WHERE party_id='$party_id'")) die (""._NLCANNOTUPDATE."");
   // update charge to users that haven't paid
   // regtype a
   elseif (!$db->sql_query("UPDATE nukelan_signedup SET charge='$charge_a' WHERE lan_id='$party_id' AND regtype='a' AND lan_paid='0'"));
   // regtype b
   elseif (!$db->sql_query("UPDATE nukelan_signedup SET charge='$charge_b' WHERE lan_id='$party_id' AND regtype='b' AND lan_paid='0'"));
   // regtype c
   elseif (!$db->sql_query("UPDATE nukelan_signedup SET charge='$charge_c' WHERE lan_id='$party_id' AND regtype='c' AND lan_paid='0'"));
   // regtype d
   elseif (!$db->sql_query("UPDATE nukelan_signedup SET charge='$charge_d' WHERE lan_id='$party_id' AND regtype='d' AND lan_paid='0'"));
   // regtype e
   elseif (!$db->sql_query("UPDATE nukelan_signedup SET charge='$charge_e' WHERE lan_id='$party_id' AND regtype='e' AND lan_paid='0'"));
   else {
      echo "   <center>\n"
          ."    <h2>$keyword Party Updated!</h2>\n"
          ."   </center><br><br>\n"
          ."   Party_ID =".$party_id."<br>"
          ."   Keyword =".$keyword."<br>"
          ."   Start Month =".$month."<br>"
          ."   Start Day =".$day."<br>"
          ."   Start Year =".$year."<br>"
          ."   Start Time =".$time."<br>"
                  ."   End Month =".$emonth."<br>"
                  ."   End Day = ".$eday."<br>"
                  ."   End Year = ".$eyear."<br>"
                  ."   End Time = ".$etime."<br>"
          ."   Location =".$loc2."<br>"
          ."   Host =".$host."<br>"
          ."   Max =".$max."<br>"
              ."   Charge 1 =".$name_a." :: \$".$charge_a."<br>"
              ."   Charge 2 =".$name_b." :: \$".$charge_b."<br>"
              ."   Charge 3 =".$name_c." :: \$".$charge_c."<br>"
              ."   Charge 4 =".$name_d." :: \$".$charge_d."<br>"
              ."   Charge 5 =".$name_e." :: \$".$charge_e."<br>"
          ."   PayPal =".$paypal."<br>"
                  ."   Prepay =".$prepay."<br>"
                  ."   Seating Chart =".$row2[name]."<br>"
          ."   Event Info =".$disclaimer."<br>"
                  ."   Tournament Info =".$tinfo."<br>"
              ."   Stop =".$stop."<br>"
           ."   Shutdown Public Seating Chart =".$activechart."<br>";
                    Header("Refresh: 0;url=".$admin_file.".php?op=add_party_lans");
      }
   }
function deleteParty($deleteParty) {
global $db, $prefix, $user_prefix, $admin_file, $editParty;
   //global $pntable;
   if (!$db->sql_query("DELETE FROM nukelan_parties WHERE party_id='$deleteParty'")) $error .= "Could not delete party.";
   elseif (!$db->sql_query("DELETE FROM nukelan_signedup WHERE lan_id='$deleteParty'")) $error .= "Could not delete users who have signed up.";
   elseif (!$db->sql_query("DELETE FROM nukelan_sponsors_parties WHERE party_id='$deleteParty'")) $error .= "Could not delete party sponsorships.";
   elseif (!$db->sql_query("DELETE FROM nukelan_config WHERE config_id='$deleteParty'")) $error .= "Could not delete party from active config table.";
   if ($error) echo $error;
   else echo "<center><h2>"._NLPARTYDELETED."</h2></center>";
   }

switch ($lanop) {
   case 'add_new':
      addParty($keyword, $month, $day, $year, $time, $emonth, $eday, $eyear, $etime, $loc2, $host, $max, $charge_a, $charge_b, $charge_c, $charge_d, $charge_e, $name_a, $name_b, $name_c, $name_d, $name_e, $paypal, $schart, $disclaimer, $tinfo, $stop, $activechart, $prepay);
      break;
   case 'edit_party':
      editParty($editParty, '');
      break;
   case 'update':
      updateParty($party_id, $keyword, $month, $day, $year, $time, $emonth, $eday, $eyear, $etime, $loc2, $host, $max, $charge_a, $charge_b, $charge_c, $charge_d, $charge_e, $name_a, $name_b, $name_c, $name_d, $name_e, $paypal, $schart, $disclaimer, $tinfo, $stop, $activehart, $prepay);
      break;
   case 'delete_party':
      deleteParty($deleteParty);
      break;
   default:
      if (!$db->sql_numrows($db->sql_query("SELECT host_id FROM nukelan_hosts"))) echo "You need to define a host before setting up a LAN Party.";
      elseif (!$db->sql_numrows($db->sql_query("SELECT loc_id FROM nukelan_locations"))) echo "You need to define a location for your LAN Party before setting up a LAN Party.";
      else showAddForm($keyword, $month, $day, $year, $time, $emonth, $eday, $eyear, $etime, $loc2, $host, $max, $charge_a, $charge_b, $charge_c, $charge_d, $charge_e, $name_a, $name_b, $name_c, $name_d, $name_e, $paypal, $schart, $disclaimer, $tinfo, $stop, $activechart, $prepay, $error);
      break;
   }
CloseTable();
include ("footer.php");
?>
