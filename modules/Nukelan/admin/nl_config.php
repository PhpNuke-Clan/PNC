<?php
// filename: alp_config.php

if (!defined('ADMIN_FILE')) {
        die ("Access Denied");
}
include ("header.php");

lan_menu();
OpenTable();
global $db, $prefix, $admin_file;
$result = $db->sql_query("SELECT * FROM nukelan_config WHERE id='1'");
$isconfig = $db->sql_numrows($result);
$parties = $db->sql_query("SELECT * FROM nukelan_parties ORDER BY keyword");
$num_parties = $db->sql_numrows($parties);

function showcurrent($result, $parties) {
global $db, $prefix, $admin_file, $isconfig;
$row = $db->sql_fetchrow($result);
$lan = $db->sql_fetchrow($db->sql_query("SELECT * FROM nukelan_parties WHERE party_id='$row[config_id]'"));
   echo " <center>"._NLCONFIGCURRENT." <b>$lan[keyword]</b> "._NLCONFIGISACTIVE."</center><br>\n";
   echo " <center><i>"._NLCONFIGCHECKIN."</i></center><br>";
   echo "   <table border=0>\n"
       ."    <tr>\n";
   echo "     <td>&nbsp;&nbsp;</td>\n"
       ."     <td>\n"
       ."      <form action=\"".$admin_file.".php\" method=\"post\" style=\"margin: 0;\">\n"
       ."       <input type=hidden name=op value=edit_config>\n";
if (!$isconfig) echo "<input type=hidden name=lanop value=choose_config>\n";
else                    echo "<input type=hidden name=lanop value=choose_config2>\n";
   echo "       <b>"._NLSELECTDIFFERENTPARTY."&nbsp;&nbsp;</b><br>\n"
           ."       <select name=chooseConfig>\n";
   while ($lan = $db->sql_fetchrow($parties)) echo "<option value=\"$lan[party_id]\">$lan[keyword]</option>\n";
   echo "       </select><br>\n"           
       ."       <input type=submit value=\""._NLSELECTPARTY."\">\n"
       ."      </form>\n"
       ."     </td>\n";
   echo "   <table border=0>\n"
       ."    <tr>\n";
   echo "     <td>&nbsp;&nbsp;</td>\n"
       ."     <td>\n"
       ."      <form action=\"".$admin_file.".php\" method=\"post\" style=\"margin: 0;\">\n"
       ."       <input type=hidden name=op value=edit_config>\n"
       ."       <input type=hidden name=lanop value=clear_config>\n"
       ."       <b>Deactivate current party:&nbsp;&nbsp;</b><br>\n"
           ."       <input type=hidden name=clearConfig value='1'>\n"
           ."       <input type=submit value=\""._NLDEACTIVATEPARTY."\">\n"
       ."      </form>\n"
       ."     </td>\n"
           
       ."    </tr>\n"
       ."   </table>\n";

   }
   
// shows form to add a location/also is where we redirect unfinnished forms
function showAddForm($parties) {
global $db, $prefix, $admin_file;
   echo " <center><i>"._NLCONFIGCHECKIN."</i></center><br>";
echo "   <table border=0>\n"
       ."    <tr>\n";
   echo "     <td>&nbsp;&nbsp;</td>\n"
       ."     <td>\n"
       ."      <form action=\"".$admin_file.".php\" method=\"post\" style=\"margin: 0;\">\n"
       ."       <input type=hidden name=op value=edit_config>\n"
       ."       <input type=hidden name=lanop value=choose_config>\n"
       ."       <b>"._NLSELECTAPARTY."&nbsp;&nbsp;</b><br>\n"
           ."       <select name=chooseConfig>\n";
   while ($lan = $db->sql_fetchrow($parties)) echo "<option value=\"$lan[party_id]\">$lan[keyword]</option>\n";
   echo "       </select><br>\n"           
       ."       <input type=submit value=\""._NLSELECTPARTY."\">\n"
       ."      </form>\n"
       ."     </td>\n"
       ."    </tr>\n"
       ."   </table>\n";
  }

// adds the config to database
function addConfig($chooseConfig) {
        global $db, $prefix, $admin_file;
   if (!$db->sql_query("INSERT INTO nukelan_config (id, config_id) Values (1, '$chooseConfig')")) echo ""._NLCANNOTINSERT."";
   else {
      echo "   <center>\n"
          ."    <h2>"._NLCONFIGACTIVATED."</h2>\n"
          ."   </center>";
  		     header( "refresh: 1; url=".$admin_file.".php?op=edit_config" ); 
      }
   }

function addConfig2($chooseConfig) {
        global $db, $prefix, $admin_file;
        if (!$db->sql_query("UPDATE nukelan_config SET config_id='$chooseConfig' WHERE id='1'")) echo ""._NLCANNOTUPDATECONFIG."";
        else {
      echo "   <center>\n"
          ."    <h2>"._NLACTIVECONFIGUPDATED."</h2>\n"
          ."   </center>";
		     header( "refresh: 1; url=".$admin_file.".php?op=edit_config" ); 
      }
}
function clearconfig($clearConfig) {
        global $db, $prefix, $admin_file; 
        if (!$db->sql_query("DELETE FROM nukelan_config WHERE id='1'")) echo ""._NLCANNOTREMOVECONFIG."";
        else {
      echo "   <center>\n"
          ."    <h2>"._NLCONFIGCLEARED."</h2>\n"
          ."   </center>";
  		     header( "refresh: 1; url=".$admin_file.".php?op=edit_config" );		  
      }
}
switch ($lanop) {
   case "choose_config":
      addConfig($chooseConfig);
      break;
   case "choose_config2":
      addConfig2($chooseConfig);
          break;
   case "clear_config":
      clearconfig($clearConfig);
          break;
   default:
      if (!$isconfig) { 
             showAddForm($parties);
                 }
          else {
            showcurrent($result, $parties);
                }
         break;
   }

CloseTable();
include ("footer.php");

?>
