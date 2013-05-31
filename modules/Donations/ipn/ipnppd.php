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

if ( !defined('MODULE_FILE') ) {
	die("Illegal Module File Access");
}

global $prefix, $db;

$query_cfg = "SELECT * FROM " . $prefix . "_treasury_config WHERE subtype = ''";

if (!($cfgset = $db->sql_query($query_cfg))) {
	message_die(GENERAL_ERROR, 'Could not obtain nuke tresury config data', '', __LINE__, __FILE__, $sql);
}

while ($cfgset && $row = $db->sql_fetchrow($cfgset)) {
	$tr_config[$row['name']] = $row['value'];
}

$ERR = 0;
$log = "";
$loglvl = $tr_config[ipn_dbg_lvl];
define(_ERR, 1);
define(_INF, 2);

if (isset($_GET['dbg'])) {
	$dbg = 1;
} else {
	$dbg = 0;
}

if ($dbg) {
	dprt("Debug mode activated", _INF);
	echo "<br>PHP-Nuke Treasury mod<br><br>PayPal Instant Payment Notification script<br><br>See below for status:<br>";
	echo "----------------------------------------------------------------<br>";
	$receiver_email = $tr_config['receiver_email'];
}

$req = "cmd=_notify-validate";

foreach ($_POST as $key => $value) {
	$value = urlencode(stripslashes($value));
	$req .= "&$key=$value";
}

$header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
$item_name = $_POST['item_name'];
$item_number = $_POST['item_number'];
$payment_status = $_POST['payment_status'];
$payment_amount = $_POST['mc_gross'];
$payment_currency = $_POST['mc_currency'];
$txn_id = $_POST['txn_id'];
$txn_type = $_POST['txn_type'];
$receiver_email = $_POST['receiver_email'];
$payer_email = $_POST['payer_email'];

dprt("Opening connection and validating request with PayPal...", _INF);

$fp = fsockopen ('www.paypal.com', 80, $errno, $errstr, 30);

if (!$fp) {
	dprt("FAILED to connect to PayPAl", _ERR);
	die();
}

dprt("OK!", _INF);

fputs ($fp, $header . $req);

if (!$dbg && strcasecmp($_POST['business'], $tr_config['receiver_email']) != 0) {
	dprt("Incorrect receiver email: $receiver_email , aborting", _ERR) ;
	$ERR = 1;
}

$insertSQL = "";

if ($txn_id) {
	$sql = "SELECT * FROM " . $prefix . "_treasury_transactions WHERE txn_id = '$txn_id'";

	if (!($Recordset1 = $db->sql_query($sql))) {
		message_die(GENERAL_ERROR, 'Could not obtain data from nuke tresury transactions', '', __LINE__, __FILE__, $sql);
	}

	$row_Recordset1 = $db->sql_fetchrow($Recordset1);
	$NumDups = $db->sql_numrows($Recordset1);
}

while (!$dbg && !$ERR && !feof($fp)) {
	$res = fgets ($fp, 1024);

	if (strcmp ($res, "VERIFIED") == 0) {
		dprt("PayPal Verified", _INF);

		if (strcmp($payment_status, "Refunded") == 0) {
			dprt("Transaction is a Refund", _INF);

			if (($NumDups == 0) || strcmp($row_Recordset1[payment_status], "Completed") || (strcmp($row_Recordset1[txn_type], "web_accept") != 0 && strcmp($row_Recordset1[txn_type], "send_money") != 0)) {
				dprt("IPN Error: Received refund but missing prior completed transaction", _ERR);

				foreach($_POST as $key => $val) {
					dprt("$key => $val", $_ERR);
				}
				break;
			}
			if ($NumDups != 1)
			{
				dprt("IPN Error: Received refund but multiple prior txn_id's encountered, aborting", _ERR);

				foreach($_POST as $key => $val) {
					dprt("$key => $val", $_ERR);
				}
				break;
			}

			$mc_gross = -$_POST['mc_gross'];
			$mc_fee = -$_POST['mc_fee'];
			$insertSQL = sprintf("INSERT INTO " . $prefix . "_treasury_transactions (`txn_id`,`business`,`item_name`, `item_number`, `quantity`, `invoice`, `custom`, `memo`, `tax`, `option_name1`, `option_selection1`, `option_name2`, `option_selection2`, `payment_status`, `payment_date`, `txn_type`, `mc_gross`, `mc_fee`, `mc_currency`, `settle_amount`, `exchange_rate`, `first_name`, `last_name`, `address_street`, `address_city`, `address_state`, `address_zip`, `address_country`, `address_status`, `payer_email`, `payer_status`) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')", $_POST['txn_id'],$_POST['business'],$_POST['item_name'],$_POST['item_number'],$_POST['quantity'],$_POST['invoice'],$_POST['custom'],$_POST['memo'],$_POST['tax'],$_POST['option_name1'],$_POST['option_selection1'],$_POST['option_name2'],$_POST['option_selection2'],$_POST['payment_status'],strftime('%Y-%m-%d %H:%M:%S',strtotime($_POST['payment_date'])),$_POST['txn_type'],$mc_gross,$mc_fee,$_POST['mc_currency'],$_POST['settle_amount'],$_POST['exchange_rate'],$_POST['first_name'],$_POST['last_name'],$_POST['address_street'],$_POST['address_city'],$_POST['address_state'],$_POST['address_zip'],$_POST['address_country'],$_POST['address_status'],$_POST['payer_email'],$_POST['payer_status']);

			dprt($insertSQL, _INF);

			if (!($Result1 = $db->sql_query($insertSQL))) {
				message_die(GENERAL_ERROR, 'Could not insert data into nuke tresury transactions', '', __LINE__, __FILE__, $sql);
			}

			dprt("SQL result = " . $Result1, _INF);
			break;
		} else if ((strcmp($payment_status, "Completed") == 0) && ((strcmp($txn_type, "web_accept")== 0) || (strcmp($txn_type, "send_money")== 0))) {
			dprt("Normal transaction", _INF);

			if ($lp) {
				fputs($lp, $payer_email . " " . $payment_status . " " . $_POST['payment_date'] . "\n");
			}

			if ($NumDups != 0) {
				dprt("Valid IPN, but DUPLICATE txn_id! aborting", _ERR);

				foreach($_POST as $key => $val) {
					dprt("$key => $val", $_ERR);
				}
				break;
			}

            //@RJR-Pwmg@Rncvkpwo@-@Eqratkijv@(e)@VgejIHZ.eqo
			$insertSQL = sprintf("INSERT INTO " . $prefix . "_treasury_transactions (`txn_id`,`business`,`item_name`, `item_number`, `quantity`, `invoice`, `custom`, `memo`, `tax`, `option_name1`, `option_selection1`, `option_name2`, `option_selection2`, `payment_status`, `payment_date`, `txn_type`, `mc_gross`, `mc_fee`, `mc_currency`, `settle_amount`, `exchange_rate`, `first_name`, `last_name`, `address_street`, `address_city`, `address_state`, `address_zip`, `address_country`, `address_status`, `payer_email`, `payer_status`) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')", $_POST['txn_id'],$_POST['business'],$_POST['item_name'],$_POST['item_number'],$_POST['quantity'],$_POST['invoice'],$_POST['custom'],$_POST['memo'],$_POST['tax'],$_POST['option_name1'],$_POST['option_selection1'],$_POST['option_name2'],$_POST['option_selection2'],$_POST['payment_status'],strftime('%Y-%m-%d %H:%M:%S',strtotime($_POST['payment_date'])),$_POST['txn_type'],$_POST['mc_gross'],$_POST['mc_fee'],$_POST['mc_currency'],$_POST['settle_amount'],$_POST['exchange_rate'],$_POST['first_name'],$_POST['last_name'],$_POST['address_street'],$_POST['address_city'],$_POST['address_state'],$_POST['address_zip'],$_POST['address_country'],$_POST['address_status'],$_POST['payer_email'],$_POST['payer_status']);
			dprt($insertSQL, _INF);

			if (!($Result1 = $db->sql_query($insertSQL))) {
				message_die(GENERAL_ERROR, 'Could not insert data into nuke tresury transactions', '', __LINE__, __FILE__, $sql);
			}

			dprt("SQL result = " . $Result1, _INF);
			break;
		} else {
			dprt("Valid IPN, but not interested in this transaction", _ERR);

			foreach($_POST as $key => $val) {
				dprt("$key => $val", $_ERR);
			}
			break;
		}
	} else if (strcmp ($res, "INVALID") == 0) {
		dprt("Invalid IPN transaction, this is an abnormal condition", _ERR);

		foreach($_POST as $key => $val) {
			dprt("$key => $val", $_ERR);
		}
		break;
	}
}

if ($dbg) {
	$sql = "SELECT * FROM " . $prefix . "_treasury_transactions LIMIT 10";

	echo "Executing test query...";

	if (!($Result1 = $db->sql_query($sql))) {
		message_die(GENERAL_ERROR, 'Could not obtain data from nuke tresury transtransactions', '', __LINE__, __FILE__, $sql);
	}

	if ($Result1) {
		echo "PASSED!<br>";
	} else {
		echo "<b>FAILED</b><br>";
	}

	echo "PayPal Receiver Email: $tr_config[receiver_email]" ;
}

if ($log) {
	dprt("Logging events<br>\n", _INF);

	$sql = "INSERT INTO " . $prefix . "_treasury_translog VALUES ('','" . strftime('%Y-%m-%d %H:%M:%S',mktime()) . "', '" . strftime('%Y-%m-%d %H:%M:%S',strtotime($_POST['payment_date'])) . "','" . addslashes($log) . "')";

	if (!($Result1 = $db->sql_query($sql))) {
		message_die(GENERAL_ERROR, 'Could not insert data into nuke tresury translog', '', __LINE__, __FILE__, $sql);
	}

	$sql = "SELECT id as lowid FROM " . $prefix . "_treasury_translog ORDER BY id DESC LIMIT " . $tr_config[ipn_log_entries];

	if (!($Result1 = $db->sql_query($sql))) {
		message_die(GENERAL_ERROR, 'Could not obtain nuke tresury translog', '', __LINE__, __FILE__, $sql);
	}

	while($recordSet = $db->sql_fetchrow($Result1)) {
		$lowid = $recordSet[lowid];
	}

	$sql = "DELETE FROM " . $prefix . "_treasury_translog WHERE id < '" . $lowid . "'";

	if (!($Result1 = $db->sql_query($sql))) {
		message_die(GENERAL_ERROR, 'Could not delete nuke tresury translog', '', __LINE__, __FILE__, $sql);
	}
}

fclose ($fp);

if ($lp) {
	fputs($lp,"Exiting\n");
}

if ($lp) {
	fclose ($lp);
}

if ($dbg) {
	echo "<br>----------------------------------------------------------------<br>";
	echo "If you don't see any error messages, you should be good to go!<br>";
}

function dprt($str, $clvl) {
	global $dbg, $lp, $log, $loglvl;

	if ($lp) {
		fputs($lp, $str . "\n");
	}

	if ($dbg) {
		echo $str . "<br>";
	}

	if ($clvl <= $loglvl) {
		$log .= $str . "\n";
	}
}

die();

?>