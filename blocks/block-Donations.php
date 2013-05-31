<?php
/************************************************************************/
/* NukeTreasury - Financial management for PHP-Nuke                      */
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

if ( !defined('BLOCK_FILE') ) {
        die("Illegal Block File Access");
}
//Currency:  £ = &pound; or $ = $; or € = &euro; or ¥ = &yen;
 $cur="&euro;";
 $currency_codein ="GBP"; //Get the correct codein from the paypal website


global $user, $cookie, $prefix, $db, $user_prefix, $prefix;

$query_cfg = "SELECT * FROM " . $prefix . "_treasury_config WHERE subtype = ''";

if (!($cfgset = $db->sql_query($query_cfg))) {
        echo mysql_error();
//      message_die(GENERAL_ERROR, 'Could not obtain nuke treasury config data', '', __LINE__, __FILE__, $sql);
}

while ($cfgset && $row = $db->sql_fetchrow($cfgset)) {
        $tr_config[$row['name']] = $row['value'];
}

$swingd = $tr_config[swing_day];

if (!($swingd > 0 AND $swingd < 32)) {
        $swingd = 6;
}

$dmshowdate = $tr_config[dm_show_date];
$dmshowamt = $tr_config[dm_show_amt];
$DM_TITLE = $tr_config[dm_title];

if (!$DM_TITLE) {
        $DM_TITLE = "Help keep us going!";
}

if (is_numeric($tr_config[dm_num_don]) && $tr_config[dm_num_don] > 0) {
        $dmlen = $tr_config[dm_num_don];
} else if (is_numeric($dmlen) && $dmlen ==0) {
        $dmlen = -1;
} else {
        $dmlen = 10;
}

if (date('d') >= $swingd) {
        $query_Recordset1 = "SELECT business, COUNT(mc_gross) AS count, SUM(mc_gross) AS gross, SUM(mc_gross - mc_fee) AS net, DATE_FORMAT(NOW() , \"%M\") AS mon, DATE_FORMAT(SUBDATE(DATE_FORMAT(ADDDATE(NOW() , INTERVAL 1 MONTH) , \"%Y-%c-1\") , INTERVAL 1 DAY) , \" %b %e\") AS due_by, DATE_FORMAT(NOW() , \"%b\") AS mon_short FROM " . $prefix . "_treasury_transactions WHERE (" . $prefix . "_treasury_transactions.payment_date >= DATE_FORMAT(NOW() , \"%Y-%m-" . $swingd . "\")) GROUP BY business";
        $query_Recordset3 = "SELECT custom AS name, option_selection1 as showname, DATE_FORMAT(payment_date, \"%b-%e\") AS date, CONCAT(\"$\",SUM(mc_gross)) AS amt FROM " . $prefix . "_treasury_transactions WHERE (" . $prefix . "_treasury_transactions.payment_date >= DATE_FORMAT(NOW() , \"%Y-%m-" . $swingd . "\")) GROUP BY txn_id ORDER BY payment_date DESC";
} else {
        $query_Recordset1 = "SELECT business, COUNT(mc_gross) AS count, SUM(mc_gross) AS gross, SUM(mc_gross - mc_fee) AS net, DATE_FORMAT(SUBDATE(NOW() , INTERVAL " . $swingd . " DAY) , \"%M\") AS mon, \"Now!\" AS due_by, DATE_FORMAT(SUBDATE(NOW() , INTERVAL " . $swingd . " DAY) , \"%b\") AS mon_short FROM " . $prefix . "_treasury_transactions WHERE (" . $prefix . "_treasury_transactions.payment_date < DATE_FORMAT(NOW() , \"%Y-%m-" . $swingd . "\")) AND " . $prefix . "_treasury_transactions.payment_date > DATE_FORMAT(SUBDATE(NOW() , INTERVAL " . $swingd . " DAY) , \"%Y-%m-" . $swingd . "\") GROUP BY business ";
        $query_Recordset3 = "SELECT custom AS name, option_selection1 as showname, DATE_FORMAT(payment_date, \"%b-%e\") AS date, CONCAT(\"$\",SUM(mc_gross)) AS amt FROM " . $prefix . "_treasury_transactions WHERE (" . $prefix . "_treasury_transactions.payment_date < DATE_FORMAT(NOW() , \"%Y-%m-" . $swingd . "\")) AND " . $prefix . "_treasury_transactions.payment_date > DATE_FORMAT(SUBDATE(NOW() , INTERVAL " . $swingd . " DAY) , \"%Y-%m-" . $swingd . "\") GROUP BY txn_id ORDER BY payment_date DESC";
}

if (!($Recordset1= $db->sql_query($query_Recordset1))) {
        echo mysql_error();
//      message_die(GENERAL_ERROR, 'Could not obtain nuke treasury config data', '', __LINE__, __FILE__, $sql);
}

$row_Recordset1 = $db->sql_fetchrow($Recordset1);

if (!$row_Recordset1) {
        $query_Recordset1 = "SELECT '' AS business, '0' AS count, '0' AS gross, '0' AS net, DATE_FORMAT(NOW() , '%M') AS mon, DATE_FORMAT(SUBDATE(DATE_FORMAT(ADDDATE(NOW() , INTERVAL 1 MONTH) , '%Y-%c-1') , INTERVAL 1 DAY) , ' %b %e') AS due_by, DATE_FORMAT(NOW() , '%b') AS mon_short";

        if (!($Recordset1= $db->sql_query($query_Recordset1))) {
                echo mysql_error();
//              message_die(GENERAL_ERROR, 'Could not obtain nuke tresury data', '', __LINE__, __FILE__, $sql);
        }

        $row_Recordset1 = $db->sql_fetchrow($Recordset1);
}

$query_Recordset2 = $sql = "SELECT * FROM " . $prefix . "_treasury_config WHERE name='goal' AND subtype='" . $row_Recordset1['mon_short'] . "'";

if (!($Recordset2= $db->sql_query($query_Recordset2))) {
        echo mysql_error();
//      message_die(GENERAL_ERROR, 'Could not obtain nuke tresury config data', '', __LINE__, __FILE__, $sql);
}

$row_Recordset2 = $db->sql_fetchrow($Recordset2);
$DM_MON = $row_Recordset1[mon];
$DM_GOAL = sprintf(''.$cur.'%.02f', $row_Recordset2['value']);
$DM_DUE = $row_Recordset1['due_by'];
$DM_NUM = $row_Recordset1['count'];
$DM_GROSS = sprintf(''.$cur.'%.02f',$row_Recordset1['gross']);
$DM_NET = sprintf(''.$cur.'%.02f',$row_Recordset1['net']);
$DM_LEFT = sprintf(''.$cur.'%.02f', $row_Recordset2['value'] - $row_Recordset1['net']);
$DM_BUTTON = $tr_config[dm_button];
$DM_BUTT_DIMS = '';

if (is_numeric($tr_config[dm_img_width])) {
        $DM_BUTT_DIMS .= "width=\"$tr_config[dm_img_width]\" ";
}

if (is_numeric($tr_config[dm_img_height])) {
        $DM_BUTT_DIMS .= "height=\"$tr_config[dm_img_height]\" ";
}

$content .= "<script type=\"text/javascript\">
<!-- asdfasdf -->
function openwindownt(){
window.open (\"modules/Donations/info.html\",\"NukeTreasury\",\"toolbar=no,location=no,directories=no,status=no,scrollbars=no,resizable=no,copyhistory=no,width=440,height=330\");
}
</script>";
$content .= "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">";
$content .= "<tr>";
$content .= "<td width=\"100%\" colspan=\"2\" align=\"center\">$DM_TITLE</td>";
$content .= "</tr>";
$content .= "<tr>";
$content .= "<td width=\"100%\" colspan=\"2\" align=\"center\"><a href=\"modules.php?name=Donations\"><img src=\"$DM_BUTTON\" border=\"0\" alt=\"Make donations with PayPal!\" $DM_BUTT_DIMS align=\"center\"></a></td>";
$content .= "</tr>";
$content .= "<tr>";
$content .= "<td width=\"100%\" align=\"center\" colspan=\"2\"><u><b>Donat-o-Meter Stats</b></u></td>";
$content .= "</tr>";
$content .= "<tr>";
$content .= "<td width=\"105\" align=\"right\">$DM_MON&acute;s Goal:</td>";
$content .= "<td align=\"left\">$DM_GOAL</td>";
$content .= "</tr>";
$content .= "<tr>";
$content .= "<td width=\"105\" align=\"right\">Due Date:</td>";
$content .= "<td align=\"left\">&nbsp;$DM_DUE</td>";
$content .= "</tr>";
$content .= "<tr>";
$content .= "<td width=\"105\" align=\"right\">Gross Amount:</td>";
$content .= "<td align=\"left\">$DM_GROSS</td>";
$content .= "</tr>";
$content .= "<tr>";
$content .= "<td width=\"105\" align=\"right\">Net Balance:</td>";
$content .= "<td align=\"left\">$DM_NET</td>";
$content .= "</tr>";
$content .= "<tr>";
$content .= "<td width=\"105\" align=\"right\"><b>Left to go:</b></td>";
$content .= "<td align=\"left\"> <b>$DM_LEFT</b></td>";
$content .= "</tr>";
$content .= "</table>";

if (is_numeric($dmlen) && $dmlen >= 0) {
        if (!($Recordset3 = $db->sql_query($query_Recordset3))) {
                echo mysql_error();
//              message_die(GENERAL_ERROR, 'Could not obtain nuke treasury config data', '', __LINE__, __FILE__, $sql);
        }

        $content .= "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">";
    //@RJR-Pwmg@Rncvkpwo@-@Eqratkijv@(e)@VgejIHZ.eqo
        $content .= "<tr><td width=\"100%\"><hr></td></tr>";
        $content .= "<tr><td align=\"center\"><b><u><a href=\"javascript:openwindownt()\">Donations &copy;</a></u></b></td></tr>";

        $i = 0;

        while (($row_Recordset3 = $db->sql_fetchrow($Recordset3)) && ($i != $tr_config[dm_num_don])) {
                if ($row_Recordset3['amt'] > "$0") {
                        if (strcmp($row_Recordset3['showname'],"Yes") == 0) {
                                $name = $row_Recordset3['name'];
                        } else {
                                $name = "Anonymous";
                        }

                        if (!$dmshowamt && !$dmshowdate) {
                                $dmalign = "center";
                        } else {
                                $dmalign = "right";
                        }

                        $content .= "<tr><td width=\"100%\" align=\"$dmalign\">";
                        $content .= $name;

                        if ($dmshowamt) {
                                $content .= " $row_Recordset3[amt]";
                        }

                        if ($dmshowdate) {
                                $content .= " $row_Recordset3[date]";
                        }

                        $content .= "</td></tr>";
                }

                $i++;
        }

        $content .= "</table>";
}

?>
