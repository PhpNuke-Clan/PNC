<?php
// this is the new version of the old _functions.php.  
// MAKE SURE YOU DELETE /_functions.php when you use the script.
// LEAVE include/_functions.php INTACT!  Thanks!

// This is the edited version of the original ALP _config.php - Artemis

//include ("./../config.php");

require_once("mainfile.php");
global $db;

$link = mysql_connect($dbhost, $dbuname, $dbpass)
        or die("Could not connect : " . mysql_error());
  //  print "Connected successfully";
    mysql_select_db($dbname) or die("Could not select database");

$party = $db->sql_fetchrow(mysql_query("SELECT * FROM nukelan_config WHERE id='1'"));
$row = $db->sql_fetchrow(mysql_query("SELECT * FROM nukelan_parties WHERE party_id='$party[config_id]'"));
$hostrow = $db->sql_fetchrow(mysql_query("SELECT * FROM nukelan_hosts WHERE host_id='$row[host]'"));
$host = "$hostrow[fname] $hostrow[lname]";

preg_match("/(.+)-(.+)-(.+) (.+):(.+):(.*)/i", "$row[date]", $matches);
  $syear = $matches[1];
  $smonth = $matches[2];
  $sday = $matches[3];
  $shour = $matches[4];
  $smin = $matches[5];
  $ssec = $matches[6];
    preg_match("/(.+)-(.+)-(.+) (.+):(.+):(.*)/i", "$row[enddate]", $matches);
  $eyear = $matches[1];
  $emonth = $matches[2];
  $eday = $matches[3];
  $ehour = $matches[4];
  $emin = $matches[5];
  $esec = $matches[6];
  
  $starttime = "$shour:$smin";
  $endtime = "$ehour:$emin";
  $startdate = "$smonth/$sday/$syear";
  $enddate = "$emonth/$eday/$eyear";

// name of your lan party.
$lan["name"] = "$row[keyword]";


// name of the gaming group hosting the party.
$lan["group"] = "$host";

// maximum registrants your facility can support.
$lan["max"] = "$row[max]";

// super administrator account name.  the main account (probably your username, since you are setting this up).
$lan["admin"] = "$row[alp_admin]";

// input your mysql server connection information here.
$database["user"] = "$dbuname";
$database["passwd"] = "$dbpass";
$database["database"] = "$dbname";

// don't change this unless the mysql server resides on a different computer than the web server.
$database["server"] = "$dbhost";

// starting and ending of your lan party (time is in 24 hour format, year accepts 2 or 4 digit years).
// you _must_ use similar punctuation, with the : for time seperators and / for date seperators.
//$lan["timestart"] = "21:00";
//$lan["timeend"] = "12:00";
//$lan["datestart"] = "4/23/2004";
//$lan["dateend"] = "4/25/2004";

$lan["timestart"] = "$starttime";
$lan["timeend"] = "$endtime";
$lan["datestart"] = "$startdate";
$lan["dateend"] = "$enddate";


// the code for the default language you wish to use. (available languages are: en)
$language = "en";
?>
