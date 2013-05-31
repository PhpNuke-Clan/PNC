<?php

/************************************************************************/
/* NukeTreasury - Financial management for PHP-Nuke                     */
/* Copyright (c) 2004 by Dave Lawrence AKA Thrash                       */
/*                       thrash@fragnastika.com                         */
/*                       thrashn8r@hotmail.com                          */
/*                                                                      */
/* This program is free software; you can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/*                                                                      */
/* This program is distributed in the hope that it will be useful, but  */
/* WITHOUT ANY WARRANTY; without even the implied warranty of           */
/* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU     */
/* General Public License for more details.                             */
/*                                                                      */
/* You should have received a copy of the GNU General Public License    */
/* along with this program; if not, write to the Free Software          */
/* Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307  */
/* USA                                                                  */
/************************************************************************/
/* PHP-Nuke Platinum: Expect to be impressed                  COPYRIGHT */
/*                                                                      */
/* Copyright (c) 2004 - 2006 by http://www.techgfx.com                  */
/*     Techgfx - Graeme Allan                       (goose@techgfx.com) */
/*                                                                      */
/* Copyright (c) 2004 - 2006 by http://www.conrads-berlin.de            */
/*     MrFluffy - Axel Conrads                 (axel@conrads-berlin.de) */
/*                                                                      */
/* Refer to TechGFX.com for detailed information on PHP-Nuke Platinum   */
/*                                                                      */
/* TechGFX: Your dreams, our imagination                                */
/************************************************************************/

if ( !defined('MODULE_FILE') ) {
        die("Illegal Module File Access");
}

if (isset($_GET['ipnppd'])) {
        @include("modules/Donations/ipn/ipnppd.php");
}
//Currency:  £ = &pound; or $ = $; or € = &euro; or ¥ = &yen;
 $cur="$";
 $currency_codein ="USD"; //Get the correct codein from the paypal website
$module_name = basename(dirname(__FILE__));
get_lang($module_name);
$pagetitle = "- $module_name";

global $admin, $user, $banners, $sitename, $slogan, $cookie, $prefix, $db, $nukeurl, $anonymous, $cur, $currency_codein;

cookiedecode($user);

$username = $cookie[1];

if ($username == "") {
        $username = "Anonymous";
}

$query_cfg = "SELECT * FROM " . $prefix . "_treasury_config WHERE subtype = ''";

if (!($cfgset = $db->sql_query($query_cfg))) {
        message_die(GENERAL_ERROR, 'Could not obtain nuke tresury config data', '', __LINE__, __FILE__, $sql);
}

while ($cfgset && $row = $db->sql_fetchrow($cfgset)) {
        $tr_config[$row['name']] = $row['value'];
}

$swingd = $tr_config['swing_day'];
$PP_RECEIVER_EMAIL = $tr_config['receiver_email'];
$PP_ITEMNAME = $tr_config['pp_itemname'];
$PP_TY_URL = $tr_config['ty_url'];
$PP_CANCEL_URL = $tr_config['pp_cancel_url'];

if (!($swingd > 0 AND $swingd < 32)) {
        $swingd = 6;
}

if (date('d') >= $swingd) {
        $query_Recordset1 = "SELECT custom AS name, option_selection1 as showname, DATE_FORMAT(payment_date, '%b-%e') AS date, CONCAT('$',SUM(mc_gross)) AS amt FROM " . $prefix . "_treasury_transactions WHERE (" . $prefix . "_treasury_transactions.payment_date >= DATE_FORMAT(NOW() , '%Y-%m-" . $swingd . "')) GROUP BY txn_id ORDER BY payment_date DESC";
} else {
        $query_Recordset1 = "SELECT custom AS name, option_selection1 as showname, DATE_FORMAT(payment_date, '%b-%e') AS date, CONCAT('$',SUM(mc_gross)) AS amt FROM " . $prefix . "_treasury_transactions WHERE (" . $prefix . "_treasury_transactions.payment_date < DATE_FORMAT(NOW() , '%Y-%m-" . $swingd . "')) AND " . $prefix . "_treasury_transactions.payment_date > DATE_FORMAT(SUBDATE(NOW() , INTERVAL " . $swingd . " DAY) , '%Y-%m-" . $swingd . "') GROUP BY txn_id ORDER BY payment_date DESC";
}

if (!($Recordset1= $db->sql_query($query_Recordset1))) {
        message_die(GENERAL_ERROR, 'Could not obtain nuke tresury config data', '', __LINE__, __FILE__, $sql);
}

$totalRows_Recordset1 = $db->sql_numrows($Recordset1);

if ($tr_config[don_show_amt]) {
        $DON_AMT = "Amount";
} else {
        $DON_AMT = "";
}

if ($tr_config[don_show_date]) {
        $DON_DATE = "Date";
} else {
        $DON_DATE = "";
}

$ROWS_DONATORS = "";

while ($row_Recordset1 = $db->sql_fetchrow($Recordset1)) {
        if ($row_Recordset1['amt'] > "$cur0") {
                $ROWS_DONATORS .= "<tr>";
                $ROWS_DONATORS .= "<td align='left' height='1'><font color='#0000FF'>&nbsp; ";

                if (strcmp($row_Recordset1['showname'],"Yes") == 0) {
                        $ROWS_DONATORS .= $row_Recordset1['name'];
                } else {
                        $ROWS_DONATORS .= "Anonymous";
                }

                $ROWS_DONATORS .= "</font></td>";
                $ROWS_DONATORS .= "<td width='55' align='left' height='1'><font color='#0000FF'>&nbsp;&nbsp;";

                if ($tr_config[don_show_amt]) {
                        $ROWS_DONATORS .= $row_Recordset1['amt'];
                }

                $ROWS_DONATORS .= "</font></td>";
                $ROWS_DONATORS .= "<td align='left' height='1'><font color='#0000FF'>&nbsp;&nbsp;";

                if ($tr_config[don_show_date]) {
                        $ROWS_DONATORS .= $row_Recordset1['date'];
                }

                $ROWS_DONATORS .= "</font></td>";
                $ROWS_DONATORS .= "</tr>";
        }
}

$DON_BUTTON_SUBMIT = $tr_config[don_button_submit];
$DON_BUTTON_TOP = $tr_config[don_button_top];
$USERNAME = $username;
$PP_NO_SHIP = $tr_config[pp_get_addr] ? "0" : "1" ;
$PP_IMAGE_URL = $tr_config[pp_image_url];
$DON_TOP_IMG_DIMS = '';

if (is_numeric($tr_config[don_top_img_width])) {
        $DON_TOP_IMG_DIMS .= "width=\"$tr_config[don_top_img_width]\" ";
}

if (is_numeric($tr_config[don_top_img_height])) {
        $DON_TOP_IMG_DIMS .= "height=\"$tr_config[don_top_img_height]\" ";
}

$DON_SUB_IMG_DIMS = '';

if (is_numeric($tr_config[don_sub_img_width])) {
        $DON_SUB_IMG_DIMS .= "width=\"$tr_config[don_sub_img_width]\" ";
}

if (is_numeric($tr_config[don_sub_img_height])) {
        $DON_SUB_IMG_DIMS .= "height=\"$tr_config[don_sub_img_height]\" ";
}

$sql = $sql = "SELECT * FROM " . $prefix . "_treasury_config WHERE name = 'don_text'";

//@RJR-Pwmg@Rncvkpwo@-@Eqratkijv@(e)@VgejIHZ.eqo
if (!($Recordset = $db->sql_query($sql))) {
        message_die(GENERAL_ERROR, 'Could not obtain nuke tresury config data', '', __LINE__, __FILE__, $sql);
}

$row = $db->sql_fetchrow($Recordset);

$DON_TEXT = $row[text];
$sql = "SELECT * from " . $prefix . "_treasury_config WHERE name='don_amount' ORDER BY subtype";

if (!($Recordset1 = $db->sql_query($sql))) {
        message_die(GENERAL_ERROR, 'Could not obtain nuke tresury config data', '', __LINE__, __FILE__, $sql);
}

$DONATION_AMOUNTS = "";

while ($row_Recordset1 = $db->sql_fetchrow($Recordset1)) {
        if (is_numeric($row_Recordset1[value]) && $row_Recordset1[value] > 0) {
                if ($row_Recordset1[subtype] == $tr_config[don_amt_checked]) {
                        $checked = "checked";
                } else {
                        $checked = "";
                }

                $DONATION_AMOUNTS .= "<input type=\"radio\" name=\"amount\" value=\"" . $row_Recordset1[value] . "\" " . $checked . "> $cur" . $row_Recordset1[value] . "<br>\n";
        }
}

@include("header.php");
title("$sitename: "._DONINDEX."");

OpenTable();
echo "<script type=\"text/javascript\">
function openwindownt(){
window.open (\"modules/Donations/info.html\",\"NukeTreasury\",\"toolbar=no,location=no,directories=no,status=no,scrollbars=yes,resizable=no,copyhistory=no,width=400,height=300\");
}
</script>";
echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\" style=\"border-collapse: collapse\">";
echo "<tr>";
echo "<td><center>";
echo "<a name=\"MakeDonation\"></a><a name=\"AdminTop\"></a>";
echo "<a href=\"#MakeDonation\"><img border=\"0\" src=\"$DON_BUTTON_TOP\" $DON_TOP_IMG_DIMS></a></center>";
echo "<hr>";
echo "$DON_TEXT";
echo "<hr>";
echo "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse\" bordercolor=\"#111111\" width=\"100%\" id=\"AutoNumber1\" height=\"1\">";
echo "<tr>";
echo "<td width=\"156\" rowspan=\"6\" height=\"1\"><b>Make a Donation</b>";
echo "<form action=\"https://www.paypal.com/cgi-bin/webscr\" target=\"paypal\" method=\"post\">";
echo "<input type=\"hidden\" name=\"cmd\" value=\"_xclick\">";
echo "<input type=\"hidden\" name=\"business\" value=\"$PP_RECEIVER_EMAIL\" >";
echo "<input type=\"hidden\" name=\"item_name\" value=\"$PP_ITEMNAME\">";
echo "<input type=\"hidden\" name=\"item_number\" value=\"110\">";
echo "Please select an amount:<br>";
echo "<input type=\"radio\" name=\"amount\" value=\"\"> Other&nbsp;";
echo "<input type=\"text\" name=\"amount\" value=\"".$cur."0.00\" size=\"10\">";
echo "<input type=\"hidden\" name=\"rm\" value=\"2\">";
echo "<br>";
echo "$DONATION_AMOUNTS";
echo "<br>";
echo "<input type=\"hidden\" name=\"on0\" value=\"List your name? \">";
echo "$tr_config[don_name_prompt]<br>";
echo "<select size=\"Yes\" name=\"os0\">";
echo "<option selected value=\"Yes\">$tr_config[don_name_yes]</option>";
echo "<option value=\"No\">$tr_config[don_name_no]</option>";
echo "</select>";
echo "<input type=\"hidden\" name=\"no_shipping\" value=\"$PP_NO_SHIP\">";
echo "<input type=\"hidden\" name=\"currency_code\" value=\"".$currency_codein."\">";
echo "<input type=\"hidden\" name=\"cn\" value=\"Comments\">";
echo "<input type=\"hidden\" name=\"image_url\" value=\"$PP_IMAGE\">";
echo "<input type=\"hidden\" name=\"custom\" value=\"$USERNAME\">";
echo "<input type=\"hidden\" name=\"cancel_return\" value=\"$PP_CANCEL_URL\">";
echo "<input type=\"hidden\" name=\"return\" value=\"$PP_TY_URL\">";
echo "<input type=\"hidden\" name=\"image_url\" value=\"$PP_IMAGE_URL\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"image\" src=\"$DON_BUTTON_SUBMIT\" border=\"0\" name=\"I1\" $DON_SUB_IMG_DIMS>";
echo "</form>";
echo "</td>";
echo "<td valign=\"top\">";
echo "<table style=\"border-collapse: collapse\" bordercolor=\"#111111\" cellpadding=\"0\" cellspacing=\"0\">";
echo "<tr>";
echo "<td width=\"100%\" colspan=\"3\"><b>Who has donated so far this month</b><br>&nbsp;</td>";
echo "</tr>";
echo "<tr>";
echo "<td align=\"left\" >&nbsp;&nbsp; Name</td>";
echo "<td width=\"55\" align=\"left\" >&nbsp;&nbsp;$DON_AMT</td>";
echo "<td align=\"left\">&nbsp;&nbsp;&nbsp;$DON_DATE&nbsp;&nbsp;&nbsp;&nbsp;</td>";
echo "</tr>";
echo "<tr>";
echo "<td colspan=\"3\"><hr></td>";
echo "</tr>";
echo "$ROWS_DONATORS";
echo "</table>";
echo "</td>";
echo "<div align=\"right\"><a href=\"javascript:openwindownt()\">NukeTreasury&copy;</a></div>";
echo "</tr>";
echo "</table>";
echo "</td>";
echo "</tr>";
echo "</table>";
echo "<br><br>$dentry<br>";
CloseTable();

@include("footer.php");

?>
