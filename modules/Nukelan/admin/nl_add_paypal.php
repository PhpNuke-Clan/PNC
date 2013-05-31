<?php
// filename: add_paypal.php

if (!defined('ADMIN_FILE')) {
        die ("Access Denied");
}
include ("header.php");
$module_name = "Nukelan";
lan_menu();
OpenTable();

// output an edit/delete box for current locations
global $db, $prefix, $editPaypal, $admin_file;
if ($db->sql_numrows($result = $db->sql_query("SELECT paypal_id, keyword FROM nukelan_paypal ORDER BY keyword"))) {
   echo "   <table border=0>\n"
       ."    <tr>\n"
       ."     <td>\n"
       ."      <form action=\"".$admin_file.".php\" method=\"post\" style=\"margin: 0;\">\n"
       ."       <input type=hidden name=op value=add_paypal_lans>\n"
       ."       <input type=hidden name=lanop value=edit_paypal>\n"
       ."       <b>"._NLEDITPAYPAL."&nbsp;&nbsp;</b>\n"
       ."       <select name=editPaypal>\n";
   while ($row = $db->sql_fetchrow($result)) {
                if ($row[paypal_id]==$editPaypal) echo "<option value=\"$row[paypal_id]\" SELECTED>$row[keyword]</option>";
                else echo "        <option value=\"$row[paypal_id]\">$row[keyword]</option>\n";
                }
   echo "       </select>\n"
       ."       <input type=submit value=\""._NLEDIT."\">\n"
       ."      </form>\n"
       ."     </td>\n";
   $result = $db->sql_query("SELECT paypal_id, keyword FROM nukelan_paypal");
   echo "     <td>&nbsp;&nbsp;</td>\n"
       ."     <td>\n"
       ."      <form action=\"".$admin_file.".php\" method=\"post\" style=\"margin: 0;\">\n"
       ."       <input type=hidden name=op value=add_paypal_lans>\n"
       ."       <input type=hidden name=lanop value=delete_paypal>\n"
       ."       <b>"._NLDELETEPAYPAL."&nbsp;&nbsp;</b>\n"
       ."       <select name=deletePaypal>\n";
   while ($row = $db->sql_fetchrow($result)) echo "        <option value=\"$row[paypal_id]\">$row[keyword]</option>\n";
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

// shows form to add a paypal account/also is where we redirect unfinnished forms
function showAddForm($keyword, $account, $pmttitle, $add_chg, $notify_addy, $currency, $error) {
   global $db, $prefix, $admin_file, $module_name;
   include"modules/$module_name/admin/incl/currency.php";
include"modules/$module_name/admin/incl/states.php";
   echo "   <form action=\"".$admin_file.".php\" method=\"post\">\n"
       ."   <input type=hidden name=op value=\"add_paypal_lans\">\n"
       ."   <input type=hidden name=lanop value=\"add_new\">\n"
       ."   <center>\n"
       ."    <h3>"._NLADDPAYPAL."</h3>\n";
   if ($error) echo "   $error<br>\n";
   echo "   </center>\n"
       ."   <b>"._NLACCOUNTINFO."</b><br>\n"
       ."   &nbsp;&nbsp;&nbsp;"._NLPAYPALNAME."<br>\n"
       ."   &nbsp;&nbsp;&nbsp;<input type=text size=40 maxlength=40 name=keyword value=\"$keyword\"><br>\n"
       ."   &nbsp;&nbsp;&nbsp;"._NLPAYPALEMAIL."<br>\n"
       ."   &nbsp;&nbsp;&nbsp;<input type=text size=40 maxlength=40 name=account value=\"$account\"><br>\n"
       ."   &nbsp;&nbsp;&nbsp;"._NLPAYPALTITLE."<br>\n"
       ."   &nbsp;&nbsp;&nbsp;<input type=text size=40 maxlength=100 name=pmttitle value=\"$pmttitle\"><br>\n"
       ."   &nbsp;&nbsp;&nbsp;"._NLPAYPALADJUST."<br>\n"
       ."   &nbsp;&nbsp;&nbsp;<input type=text size=6 maxlength=6 name=add_chg value=\"$act[add_chg]\">&nbsp;&nbsp;\n"
       ."   &nbsp;&nbsp;&nbsp;<select name=currency>\n";
          foreach ($currency as $curr => $long) {
      if ($act[currency] == $curr) echo "    <option value=\"$curr\" SELECTED>$long</option>\n";
      else echo "    <option value=\"$curr\">$long</option>\n";
      }
   echo "   </select><br>\n"
       ."   &nbsp;&nbsp;&nbsp;"._NLPAYPALNOTIFY."<br>\n"
       ."   &nbsp;&nbsp;&nbsp;<input type=text size=40 maxlength=150 name=notify_addy value=\"$notify_addy\"><br>\n"
           ."   <br>\n"
       ."   <input type=submit value=\""._NLADDACCOUNT."\">\n";
   }

// this allows us to edit an account
function editAccount($editPaypal) {
   global $db, $prefix, $pntable, $admin_file, $module_name;
      include"modules/$module_name/admin/incl/currency.php";
include"modules/$module_name/admin/incl/states.php";
   if (!$act = $db->sql_fetchrow($db->sql_query("SELECT * FROM nukelan_paypal WHERE paypal_id='$editPaypal'"))) die (""._NLCANNOTACCESSPAYPAL."");
   echo "   <form action=\"".$admin_file.".php\" method=\"post\">\n"
       ."   <input type=hidden name=op value=\"add_paypal_lans\">\n"
       ."   <input type=hidden name=lanop value=\"update_paypal\">\n"
       ."   <input type=hidden name=paypal_id value=\"$editPaypal\">\n"
       ."   <input type=hidden name=keyword value=\"$act[keyword]\"><br>\n"
       ."   <center>\n"
       ."    <h3>"._NLEDITPAYPALACCOUNT." $act[keyword]</h3>\n"
       ."   </center>\n"
       ."   <b>"._NLACCOUNTINFO."</b><br>\n"
       ."   &nbsp;&nbsp;&nbsp;<input type=text size=40 maxlength=40 name=keyword value=\"$act[keyword]\"><br>\n"	   
       ."   &nbsp;&nbsp;&nbsp;"._NLPAYPALEMAIL."<br>\n"
       ."   &nbsp;&nbsp;&nbsp;<input type=text size=40 maxlength=40 name=account value=\"$act[account]\"><br>\n"
       ."   &nbsp;&nbsp;&nbsp;"._NLPAYPALTITLE."<br>\n"
       ."   &nbsp;&nbsp;&nbsp;<input type=text size=40 maxlength=100 name=pmttitle value=\"$act[pmttitle]\"><br>\n"
       ."   &nbsp;&nbsp;&nbsp;"._NLPAYPALADJUST."<br>\n"
       ."   &nbsp;&nbsp;&nbsp;<input type=text size=6 maxlength=6 name=add_chg value=\"$act[add_chg]\">&nbsp;&nbsp;\n"
       ."   &nbsp;&nbsp;&nbsp;<select name=currency>\n";
          foreach ($currency as $curr => $long) {
      if ($act[currency] == $curr) echo "    <option value=\"$curr\" SELECTED>$long</option>\n";
      else echo "    <option value=\"$curr\">$long</option>\n";
      }
   echo "   </select><br>\n"
       ."   &nbsp;&nbsp;&nbsp;"._NLPAYPALNOTIFY."<br>\n"
       ."   &nbsp;&nbsp;&nbsp;<input type=text size=40 maxlength=150 name=notify_addy value=\"$act[notify]\"><br>\n"
       ."   <br>\n"
       ."   <br>\n"
       ."   <input type=submit value=\""._NLEDITACCOUNT."\">\n"
       ."   </form>\n";
   }

// adds the account to database
function addAccount($keyword, $account, $pmttitle, $add_chg, $notify_addy, $currency) {
   global $db, $prefix, $pntable,$admin_file;
   if (!$keyword || !$account || !$pmttitle || !$add_chg) showAddForm($keyword, $account, $pmttitle, $add_chg, $notify_addy, $currency, ""._NLREQUIREDFIELDS."");
   elseif ($db->sql_numrows($db->sql_query("SELECT paypal_id FROM nukelan_paypal WHERE keyword='$keyword'"))) showAddForm($keyword, $account, $pmttitle, $add_chg, $notify, ""._NLKEYWORDTAKEN."");
   elseif (!$db->sql_query("INSERT INTO nukelan_paypal SET keyword='$keyword', account='$account', pmttitle='$pmttitle', add_chg='$add_chg', notify='$notify_addy', currency='$currency'")) die (""._NLCANNOTINSERT." keyword='$keyword', account='$account', pmttitle='$pmttitle', add_chg='$add_chg', notify='$notify_addy', currency='$currency'");
   else {
      echo "   <center>\n"
          ."    <h2>"._NLPAYPALADDED."</h2>\n"
          ."   </center>";
    Header("Refresh: 0;url=".$admin_file.".php?op=add_paypal_lans");
      }
   }

// updates an account
function updateAccount($paypal_id, $keyword, $account, $pmttitle, $add_chg, $notify_addy, $currency) {
   global $db, $prefix, $pntable,$admin_file;
   if (!$keyword || !$account || !$pmttitle || !$add_chg || !$currency) {
      echo ""._NLREQUIREDFIELDS."<BR>$paypal_id, $keyword, $account, $pmttitle, $add_chg, $notify, $currency";
      editAccount($paypal_id);
      }
   elseif (!$db->sql_query("UPDATE nukelan_paypal SET keyword='$keyword', account='$account', pmttitle='$pmttitle', add_chg='$add_chg', notify='$notify_addy', currency='$currency' WHERE paypal_id='$paypal_id'")) die ("".$currency."");
   else {
      echo "   <center>\n"
          ."    <h2>"._NLPAYPALUPDATED."</h2><BR>$paypal_id, $keyword, $account, $pmttitle, $add_chg, $notify_addy\n"
          ."   </center>";
    Header("Refresh: 0;url=".$admin_file.".php?op=add_paypal_lans");
      }
   }

function deletePaypal($deletePaypal) {
   global $db, $prefix, $pntable,$admin_file;
   $result = $db->sql_query("SELECT keyword FROM nukelan_parties WHERE paypal='$deletePaypal'");
   if ($db->sql_numrows($result)) while ($name = $db->sql_fetchrow($result)) {
      $error .= "$name[keyword] "._NLLANUSINGPAYPAL."<br>";
      }
   elseif (!$db->sql_query("DELETE FROM nukelan_paypal WHERE paypal_id='$deletePaypal'")) $error .= ""._NLCANNOTDELETEPAYPAL."<br>";
   else echo "<center><h2>"._NLPAYPALDELETED."</h2></center>";
   echo $error;
       Header("Refresh: 0;url=".$admin_file.".php?op=add_paypal_lans");
   }

switch ($lanop) {
   case "add_new":
      addAccount($keyword, $account, $pmttitle, $add_chg, $notify_addy, $currency);
      break;
   case "update_paypal":
      updateAccount($paypal_id, $keyword, $account, $pmttitle, $add_chg, $notify_addy, $currency);
      break;
   case "edit_paypal":
      editAccount($editPaypal);
      break;
   case "delete_paypal":
      deletePaypal($deletePaypal);
      break;
   default:
      showAddForm('','','','','','','');
      break;
   }

CloseTable();
include ("footer.php");

?>
