<?php
/********************************************************/
/* NukeSentinel(tm)                                     */
/* By: NukeScripts(tm) (http://www.nukescripts.net)     */
/* Copyright © 2000-2008 by NukeScripts(tm)             */
/* See CREDITS.txt for ALL contributors                 */
/********************************************************/

if( !defined('PNC_INST')){
	if( !defined('PNC_UPD')){
		die("Access denied!");
	}
}
@set_time_limit(600);

$wfilename = "ip2country/data/ip2country_3.data";
if(file_exists($wfilename)) {
  $wfread = fopen($wfilename, 'r');
  $linecount = 0;
  while (!feof($wfread)) {
    $DataRead = fgets($wfread, 1024);
    list ($ip_lo, $ip_hi, $ip_date, $ip_c2c) = explode ("||", $DataRead);
    $ip_c2c = ereg_replace ("\r", "", $ip_c2c);
    $ip_c2c = ereg_replace ("\n", "", $ip_c2c);
    if($ip_lo > "") {
      $datainserted = False;
      $datainserted = mysql_query("INSERT INTO `".$prefix."_nsnst_ip2country` (`ip_lo`, `ip_hi`, `date`, `c2c`) VALUES ('$ip_lo', '$ip_hi', '$ip_date', '$ip_c2c')");
      if($datainserted) {
        echo long2ip($ip_lo).' - '.long2ip($ip_hi).': <font color="#00AA00"><strong>OK</strong></font><br />'."\n";
      } else {
        echo long2ip($ip_lo).' - '.long2ip($ip_hi).': <font color="#AA0000"><strong>FAILED</strong></font><br />'."\n";
      }
    }
  }
  fclose($wfread);
} else {
  echo '<font color="#AA0000">IP2Country file read <strong>FAILED</strong></font><br />'."\n";
}
?>