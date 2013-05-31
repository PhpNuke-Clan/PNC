<?php
// filename: nukelan_menu.php
function lan_menu() {
   global  $db, $prefix, $op, $ops, $sop, $sops, $aop, $aops, $aid;
$row = $db->sql_fetchrow($db->sql_query("SELECT * FROM ".$prefix."_authors WHERE aid='$aid'"));
$row2 = $db->sql_fetchrow($db->sql_query("SELECT * FROM nukelan_admins WHERE aid='$aid'"));
$radminlan_parties = $row2['parties'];
$radminlan_checkin = $row2['check_in'];
$radminlan_access = $row2['accessories'];
$radminlan_staff = $row2['staff'];
$radminlan_tourneymod = $row2['tourney_mod'];
$radminlan_editadmins = $row2['edit_admins'];
$radminsuper = $row['radminsuper'];

   $ops = array(
   'admin_show_lans'.$GLOBALS[$ModName]    => 'Show Parties',
   'add_party_lans'.$GLOBALS[$ModName]     => 'Add/Edit LAN Parties',
   'add_location_lans'.$GLOBALS[$ModName]  => 'Locations',
   'add_host_lans'.$GLOBALS[$ModName]      => 'Hosts',
   'add_paypal_lans'.$GLOBALS[$ModName]    => 'PayPal Accounts',
   'add_seating'.$GLOBALS[$ModName]        => 'Seating Chart',
   'edit_config'.$GLOBALS[$ModName]        => 'Set Active Party',
   'nl_admin'.$GLOBALS[$ModName]           => 'Edit NL Admins',
   );
   $sops = array(
   'admin_show_jobs'.$GLOBALS[$ModName]   => 'Show Jobs / Approve Users',
   'add_jobs'.$GLOBALS[$ModName]          => 'Add / Edit Jobs',
   );
   $aops = array(
   'add_tournament'.$GLOBALS[$ModName]    => 'Add/Edit Tournaments',
   'add_team'.$GLOBALS[$ModName]          => 'Add/Edit Teams',
   'add_prize'.$GLOBALS[$ModName]         => 'Add/Edit Prizes',
   'add_hotel'.$GLOBALS[$ModName]         => 'Add/Edit Hotels',
   'add_sponsor'.$GLOBALS[$ModName]       => 'Add/Edit Sponsors',
   'add_games'.$GLOBALS[$ModName]         => 'Add/Edit Games'
   );
   OpenTable();
   echo "<table width=\"98%\">\n"
       ."<tr>\n";
   // menu for party administration
   if (($radminlan_parties==1) OR ($radminsuper==1)) {
   echo "<td>";
   echo "   <form action=\"admin.php\" method=\"get\" style=\"margin: 0;\">\n"
       ."    <b>NUKELAN ADMIN MENU:</b><br>&nbsp;&nbsp;\n"
       ."    <select name=op>\n";
   foreach ($ops as $key => $label) {
      if ($key == $op) echo "     <option value=\"$key\" SELECTED>$label</option>\n";
      else echo "     <option value=\"$key\">$label</option>\n";
      }
   echo "    </select>\n"
       ."    <input type=submit value=\"Jump\">\n"
       ."   </form>\n";
	echo "</td>";
   }
   // menu for party staff administration
   if (($radminlan_staff==1) OR ($radminsuper==1)) {
   echo "<td>";
   echo "   <form action=\"admin.php\" method=\"get\" style=\"margin: 0;\">\n"
       ."    <b>STAFF MENU:</b><br>&nbsp;&nbsp;\n"
       ."    <select name=op>\n";
   foreach ($sops as $key => $label) {
      if ($key == $op) echo "     <option value=\"$key\" SELECTED>$label</option>\n";
      else echo "     <option value=\"$key\">$label</option>\n";
      }
   echo "    </select>\n"
       ."    <input type=submit value=\"Jump\">\n"
       ."   </form>\n";
	echo "</td>";
   }
   // menu for party accessories
   if (($radminlan_access==1) OR ($radminsuper==1)) {
   echo "<td>";
   echo "   <form action=\"admin.php\" method=\"get\" style=\"margin: 0;\">\n"
       ."    <b>ACCESSORY MENU:</b><br>&nbsp;&nbsp;\n"
       ."    <select name=op>\n";
   foreach ($aops as $key => $label) {
      if ($key == $op) echo "     <option value=\"$key\" SELECTED><font size=1>$label</font></option>\n";
      else echo "     <option value=\"$key\">$label</option>\n";
      }
   echo "    </select>\n"
       ."    <input type=submit value=\"Jump\">\n"
       ."   </form>\n";
	echo "</td>";
   }
   // Link for checkin module
   if (($radminlan_checkin==1) OR ($radminsuper==1)) {
   echo "<td>";
   echo "<a href=\"admin.php?op=admin_checkin\">CHECK-IN MODULE</a>";
   echo "</td>";
   }
   echo "<td>\n"
   	   ."<a href=\"admin.php\">ADMIN HOME</a>\n"
	   ."</td></tr></table>";
   CloseTable();
   echo "   <br>\n";
   
   }

?>
