<?php


require_once("mainfile.php");


// read the post from PayPal system and add 'cmd'
$req = 'cmd=_notify-validate';

foreach ($_POST as $key => $value) {
	$value = urlencode(stripslashes($value));
	$req .= "&$key=$value";
}

// post back to PayPal system to validate
$header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
$fp = fsockopen ('www.paypal.com', 80, $errno, $errstr, 30);

// assign posted variables to local variables
$item_name = $_POST['item_name'];
$item_number = $_POST['item_number'];
$payment_status = $_POST['payment_status'];
$payment_amount = $_POST['mc_gross'];
$payment_currency = $_POST['mc_currency'];
/*
echo "test<P>";
$sql = "SELECT * FROM ".$user_prefix."_users WHERE user_id='18'";
$result = $db->sql_query($sql);
$row = $db->sql_fetchrow($result);
$sender_handle = $row[username];
echo "$sender_handle, $item_number";
*/
fputs ($fp, $header . $req);
while (!feof($fp)) {
	$res = fgets ($fp, 1024);
	if (strcmp ($res, "VERIFIED") == 0) {
		preg_match("/(.+)-(.*)/i", "$item_name]", $row2);
		$user_id = $row2[1];
		$lan_id = $row2[2];
		
		$sql3 = "UPDATE nukelan_signedup SET lan_paid='2' WHERE lan_uid='$user_id' AND lan_id='$lan_id'";
		$result3 = $db->sql_query($sql3);
	}
}


fclose ($fp);



?>