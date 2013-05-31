<?php
//***************************************************************************

/* Author: XenoMorpH ¤TÐI¤ (aarvuijk@hotmail.com)                           */

//***************************************************************************
$step = $_GET['step'];
if($step == "") {
$step = "";
}
$pncv = "4.2.0";
define('PNC_UPD', true);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>PNC 2.1.1/3.0.x to PNC <?php echo $pncv; ?> UPDATE FILE</title></title>
<META NAME="RATING" CONTENT="GENERAL">
<META NAME="GENERATOR" CONTENT="PNC 4.0 http://phpnuke-clan.net">
<style type="text/css">
/*<![CDATA[*/
 body.c1 {background-color:#E2E2E2}
 div.c1 {text-align: center}
 input.c1 {width:300px;}
 p.c1 {font-weight: bold}
 span.c1 {font-size:small;}
 span.c2 {color:red;font-weight:bold;}
 span.c3 {color:blue;font-weight:bold;}
/*]]>*/
</style>
</head>
  <body class="c1">
  <img src="PNC_logo.png" border="0" alt="" />
    <h2>
      PNC&trade; &copy; 2006, 2007 - PNC <?php echo $pncv; ?>
    </h2>
<?php
echo"<title>PNC 3.0.1 to PNC 3.0.2 UPDATE FILE</title>";
//error_reporting(E_ALL);
//require_once("mainfile.php");
//include("header.php");
include("../config.php");
if(!mysql_select_db($dbname, mysql_connect($dbhost, $dbuname, $dbpass)))
{echo"Couldn't connect to database";                                                        
exit();
}
$step = $_GET['step'];
if($step == "") {
$step = "1";
}
global $prefix,$db,$user_prefix;
function mysql_table_exists($table) {
   $exists = mysql_query("SELECT 1 FROM `$table` LIMIT 0");
   if ($exists) return true;
   return false;
   }
//OpenTable();
if($step == "1"){
echo"<center>This file will update your PNC versionnumber to PNC 3.0.2 <br><br><a href=\"$PHP_SELF?step=2\">PATCH</a><br></center>";

}

if($step == "2"){	
if (!mysql_table_exists("".$prefix."_pnc_technology")) {} 
	else{mysql_query("UPDATE ".$prefix."_pnc_technology SET  value='3.0.2' WHERE name='versioncheck'") or die('MySQL said: '.mysql_error()); echo" <b>".$prefix."_pnc_technology</b><br>";}
	
$sql6="SELECT * FROM ".$prefix."_pnc_technology WHERE  name='versioncheck'";
$res6 = mysql_query($sql6);

while($row = mysql_fetch_array($res6)){
$versioncheck = $row["value"];
}
echo"<br><br><br>";
echo"<center>Your new version is: $versioncheck!!.<br>";
echo "<br>Go to the main installation <a href=\"index.php\">file</a>, and run the 3.0.2 to 4.0 update.<b></b>!</font></center>";


}
//CloseTable();
//include("footer.php");
?>