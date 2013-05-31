<?php
session_start();
//***************************************************************************
/* Author: XenoMorpH ¤TÐI¤ (aarvuijk@hotmail.com)                           */
/* Development Assistance: CrazyCrack (support@phpnuke-clan.com)            */
//***************************************************************************
$step = $_GET['step'];
if($step == "") {
	$step = "";
}
$pncv = "4.5.0";
$pncold = "4.4.0";
define('PNC_UPD', true);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>PNC <?php echo $pncold; ?> to PNC <?php echo $pncv; ?> UPDATE FILE</title></title>
<META NAME="RATING" CONTENT="GENERAL">
<META NAME="GENERATOR" CONTENT="PNC $pncv http://phpnuke-clan.net">
<style type="text/css">
/*<![CDATA[*/
 body.c1 {background-color:#E2E2E2}
 div.c1 {text-align: center}
 input.c1 {width:300px;}
 p.c1 {font-weight: bold}
 span.c1 {font-size:small;}
 span.c2 {color:red;font-weight:bold;}
 span.c3 {color:blue;font-weight:bold;}
 .formbutton{
/*cursor:pointer;*/
border:outset 1px #ccc;
background:#FF0000;
color:#FFFFFF;
font-weight:bold;
padding: 1px 2px;
width:300px;

}
/*]]>*/
</style>
</head>
  <body class="c1">
  <img src="PNC_logo.png" border="0" alt="" />
    <h2>
      PNC&trade; &copy; 2006, 2007, 2008 - PNC<?php echo $pncold; ?> to PNC<?php echo $pncv; ?> MySQL Table Updater
    </h2>
    <span class="c2">Please note that this installer is for those who update from <u>PNC <?php echo $pncold; ?></u> </span>
    <hr />
    <p class="c1">
      <u>MySQL Database Connectivity Test Results</u>
    </p>
<?php
ini_set('display_errors','on');
ini_set('mysql.connect_timeout',120);
$dbCheck = array();
$nukeConfigFile = "../../config.php";
if (!file_exists($nukeConfigFile)) {rnInstallErr(1); die();}
echo '<b>config.php file found!</b><br />';
require_once("../../config.php");
$conn = @mysql_connect($dbhost,$dbuname,$dbpass);
if (!$conn)  {rnInstallErr(2); die();}
echo '<b>Successfully connected to '.$dbhost.' as user '.$dbuname.' and assigned password!</b><br />';
$db = mysql_select_db($dbname);
if (!$db)  {rnInstallErr(3); die();}
echo '<b>Database '.$dbname.' found!</b><br />';
function rnInstallErr($errNum) {
        if ($errNum==1) die('<span style="font-weight:bold;color:red;">It appears that your nuke config.php file is either missing or the permissions are not allowing it to be accessed.  Please verify the config.php is in your root folder where your mainfile.php is located and has permissions of at least 644.  Then try running the Install script again.</span>');
        elseif ($errNum==2) die('<span style="font-weight:bold;color:red;">I was unable to reach your MySQL server using the MySQL connection settings in your nuke config.php file.  The exact error message that your MySQL server reported is <b>'.mysql_error().'</b>.</span>');
        elseif ($errNum==3) die('<span style="font-weight:bold;color:red;">I was able to reach your MySQL server using the MySQL connection settings in your nuke config.php file, but I was unable to reach/locate the database <b>'.$dbname.'</b>. The exact error message that your MySQL server reported is <b>'.mysql_error().'</b>.</span>');
        elseif ($errNum==4) die('<span style="font-weight:bold;color:red;">ERROR!  The exact error message that your MySQL server reported is <b>'.mysql_error().'</b>.</span>');
        elseif ($errNum==90) die('<span style="font-weight:bold;color:red;">You have attempted to crack the Installer Script.  All pertinent information for this session has been saved and will be reviewed by the System Administrator and appropriate action will be taken.</span>');
        elseif ($errNum==91) die('<span style="font-weight:bold;color:red;">It does not appear that there are any tables to be loaded.  Installation stopped.</span>');
        elseif ($errNum==80) die('<span style="font-weight:bold;color:red;">Unable to update AUTHORS table with random password.  MySQL server reported: '.mysql_error().'. Installation stopped.</span>');
        elseif ($errNum==81) die('<span style="font-weight:bold;color:red;">Unable to update NukeSentinel&trade; Admin table with random password.  MySQL server reported: '.mysql_error().'. Installation stopped.</span>');
}
?>
<hr />
    <p>
      The intent of this Installer is to make the table installation as painless as possible, on both Windows and *nix platforms. Hopefully you will not experience any problems, but if you do, please consult the forums at http://phpnuke-clan.net and if the problem has not yet been reported then please post it. <br>
      If you have gotten to this point, then it appears that your database and config.php file have been setup correctly and the database is ready to be populated with the tables that you will need for PNC&trade; Version <?php echo $pncv ; ?>. Make sure you have made a backup of your PNC<?php echo $pncold; ?> database first before using this file!!!! PNC-Team is not responsible for any losses whatsoever.<br>Please continue by stepping through the following instructions, in order.
      We do recommend to get the latest IP2Country version for Sentinel over at: <a href="http://www.nukescripts.net" target="_blank">http://www.nukescripts.net</a>, for better security for your site...
    </p>
    <hr />
    <table>
      <tr>
        <td>
          	<?php if( !$_SESSION['pnc'] ){ ?>
				<form method="post" action="<?=$_SERVER['PHP_SELF'];?>">
					<b>Step 1&nbsp;&nbsp;-</b> <input class="c1" type="submit" name="submit" value="Update PNC <?php echo $pncold; ?> to PNC <?php echo $pncv; ?> Core Tables" />
					&nbsp;&nbsp;<span class="c3"><?=$_SESSION['pnc'];?></span>
					<input type="hidden" name="op" value="pnc" />
				</form>
            <?php }else{?>
				<form method="post" action="<?=$_SERVER['PHP_SELF'];?>">
					<b>Step 1&nbsp;&nbsp;-</b> <input class="formbutton" type="submit" name="submit" disabled="disabled" value="INSTALLED" />
					&nbsp;&nbsp;<span class="c3"><?=$_SESSION['pnc'];?></span>
					<input type="hidden" name="op" value="pnc" />
				</form>
            <?php } ?>

			<?php if( !$_SESSION['nss'] ){ ?>
				<form method="post" action="<?=$_SERVER['PHP_SELF'];?>">
					<b>Step 2&nbsp;&nbsp;-</b> <input class="c1" type="submit" name="submit" value="Install NukeSentinel&trade; Tables" />
					&nbsp;&nbsp;<span class="c3"><?=$_SESSION['nss'];?></span>
					<input type="hidden" name="op" value="nss" />
				</form>
			<?php }else{?>
				<form method="post" action="<?=$_SERVER['PHP_SELF'];?>">
					<b>Step 2&nbsp;&nbsp;-</b> <input class="formbutton" type="submit" name="submit" disabled="disabled" value="INSTALLED" />
					&nbsp;&nbsp;<span class="c3"><?=$_SESSION['nss'];?></span>
					<input type="hidden" name="op" value="nss" />
				</form>
			<?php } ?>

			<?php if( !$_SESSION['nss_1'] ){ ?>
				<form method="post" action="<?=$_SERVER['PHP_SELF'];?>">
					<b>Step 3&nbsp;&nbsp;-</b> <input class="c1" type="submit" name="submit" value="Install IP2Country Part 1; Tables" />
					&nbsp;&nbsp;<span class="c3"><?=$_SESSION['nss_1'];?></span>
					<input type="hidden" name="op" value="nss_1" />
				</form>
			<?php }else{?>
				<form method="post" action="<?=$_SERVER['PHP_SELF'];?>">
					<b>Step 3&nbsp;&nbsp;-</b> <input class="formbutton" type="submit" name="submit" disabled="disabled" value="INSTALLED" />
					&nbsp;&nbsp;<span class="c3"><?=$_SESSION['nss_1'];?></span>
					<input type="hidden" name="op" value="nss_1" />
				</form>
			<?php } ?>

			<?php if( !$_SESSION['nss_2'] ){ ?>
				<form method="post" action="<?=$_SERVER['PHP_SELF'];?>">
					<b>Step 4&nbsp;&nbsp;-</b> <input class="c1" type="submit" name="submit" value="Install IP2Country Part 2; Tables" />
					&nbsp;&nbsp;<span class="c3"><?=$_SESSION['nss_2'];?></span>
					<input type="hidden" name="op" value="nss_2" />
				</form>
			<?php }else{?>
				<form method="post" action="<?=$_SERVER['PHP_SELF'];?>">
					<b>Step 4&nbsp;&nbsp;-</b> <input class="formbutton" type="submit" name="submit" disabled="disabled" value="INSTALLED" />
					&nbsp;&nbsp;<span class="c3"><?=$_SESSION['nss_2'];?></span>
					<input type="hidden" name="op" value="nss_2" />
				</form>
			<?php } ?>

			<?php if( !$_SESSION['nss_3'] ){ ?>
				<form method="post" action="<?=$_SERVER['PHP_SELF'];?>">
					<b>Step 5&nbsp;&nbsp;-</b> <input class="c1" type="submit" name="submit" value="Install IP2Country Part 3; Tables" />
					&nbsp;&nbsp;<span class="c3"><?=$_SESSION['nss_3'];?></span>
					<input type="hidden" name="op" value="nss_3" />
				</form>
			<?php }else{?>
				<form method="post" action="<?=$_SERVER['PHP_SELF'];?>">
					<b>Step 5&nbsp;&nbsp;-</b> <input class="formbutton" type="submit" name="submit" disabled="disabled" value="INSTALLED" />
					&nbsp;&nbsp;<span class="c3"><?=$_SESSION['nss_3'];?></span>
					<input type="hidden" name="op" value="nss_3" />
				</form>
			<?php } ?>

			<?php if( !$_SESSION['nss_4'] ){ ?>
				<form method="post" action="<?=$_SERVER['PHP_SELF'];?>">
					<b>Step 6&nbsp;&nbsp;-</b> <input class="c1" type="submit" name="submit" value="Install IP2Country Part 4; Tables" />
					&nbsp;&nbsp;<span class="c3"><?=$_SESSION['nss_4'];?></span>
					<input type="hidden" name="op" value="nss_4" />
				</form>
			<?php }else{?>
				<form method="post" action="<?=$_SERVER['PHP_SELF'];?>">
					<b>Step 6&nbsp;&nbsp;-</b> <input class="formbutton" type="submit" name="submit" disabled="disabled" value="INSTALLED" />
					&nbsp;&nbsp;<span class="c3"><?=$_SESSION['nss_4'];?></span>
					<input type="hidden" name="op" value="nss_4" />
				</form>
			<?php } ?>

			<?php if( !$_SESSION['nss_5'] ){ ?>
				<form method="post" action="<?=$_SERVER['PHP_SELF'];?>">
					<b>Step 7&nbsp;&nbsp;-</b> <input class="c1" type="submit" name="submit" value="Install IP2Country Part 5; Tables" />
					&nbsp;&nbsp;<span class="c3"><?=$_SESSION['nss_5'];?></span>
					<input type="hidden" name="op" value="nss_5" />
				</form>
			<?php }else{?>
				<form method="post" action="<?=$_SERVER['PHP_SELF'];?>">
					<b>Step 7&nbsp;&nbsp;-</b> <input class="formbutton" type="submit" name="submit" disabled="disabled" value="INSTALLED" />
					&nbsp;&nbsp;<span class="c3"><?=$_SESSION['nss_5'];?></span>
					<input type="hidden" name="op" value="nss_5" />
				</form>
			<?php } ?>

			<?php if( !$_SESSION['nss_6'] ){ ?>
				<form method="post" action="<?=$_SERVER['PHP_SELF'];?>">
					<b>Step 8&nbsp;&nbsp;-</b> <input class="c1" type="submit" name="submit" value="Install IP2Country Part 6; Tables" />
					&nbsp;&nbsp;<span class="c3"><?=$_SESSION['nss_6'];?></span>
					<input type="hidden" name="op" value="nss_6" />
				</form>
			<?php }else{?>
				<form method="post" action="<?=$_SERVER['PHP_SELF'];?>">
					<b>Step 8&nbsp;&nbsp;-</b> <input class="formbutton" type="submit" name="submit" disabled="disabled" value="INSTALLED" />
					&nbsp;&nbsp;<span class="c3"><?=$_SESSION['nss_6'];?></span>
					<input type="hidden" name="op" value="nss_6" />
				</form>
			<?php } ?>

			<?php if( !$_SESSION['nss_7'] ){ ?>
				<form method="post" action="<?=$_SERVER['PHP_SELF'];?>">
					<b>Step 9&nbsp;&nbsp;-</b> <input class="c1" type="submit" name="submit" value="Install IP2Country Part 7; Tables" />
					&nbsp;&nbsp;<span class="c3"><?=$_SESSION['nss_7'];?></span>
					<input type="hidden" name="op" value="nss_7" />
				</form>
			<?php }else{?>
				<form method="post" action="<?=$_SERVER['PHP_SELF'];?>">
					<b>Step 9&nbsp;&nbsp;-</b> <input class="formbutton" type="submit" name="submit" disabled="disabled" value="INSTALLED" />
					&nbsp;&nbsp;<span class="c3"><?=$_SESSION['nss_7'];?></span>
					<input type="hidden" name="op" value="nss_7" />
				</form>
			<?php } ?>

			<?php if( !$_SESSION['nss_8'] ){ ?>
				<form method="post" action="<?=$_SERVER['PHP_SELF'];?>">
					<b>Step 10&nbsp;-</b> <input class="c1" type="submit" name="submit" value="Install IP2Country Part 8; Tables" />
					&nbsp;&nbsp;<span class="c3"><?=$_SESSION['nss_8'];?></span>
					<input type="hidden" name="op" value="nss_8" />
				</form>
			<?php }else{?>
				<form method="post" action="<?=$_SERVER['PHP_SELF'];?>">
					<b>Step 10&nbsp;-</b> <input class="formbutton" type="submit" name="submit" disabled="disabled" value="INSTALLED" />
					&nbsp;&nbsp;<span class="c3"><?=$_SESSION['nss_8'];?></span>
					<input type="hidden" name="op" value="nss_8" />
				</form>
			<?php } ?>

			<?php if( !$_SESSION['nss_9'] ){ ?>
				<form method="post" action="<?=$_SERVER['PHP_SELF'];?>">
					<b>Step 11&nbsp;-</b> <input class="c1" type="submit" name="submit" value="Install IP2Country Part 9; Tables" />
					&nbsp;&nbsp;<span class="c3"><?=$_SESSION['nss_9'];?></span>
					<input type="hidden" name="op" value="nss_9" />
				</form>
			<?php }else{?>
				<form method="post" action="<?=$_SERVER['PHP_SELF'];?>">
					<b>Step 11&nbsp;-</b> <input class="formbutton" type="submit" name="submit" disabled="disabled" value="INSTALLED" />
					&nbsp;&nbsp;<span class="c3"><?=$_SESSION['nss_9'];?></span>
					<input type="hidden" name="op" value="nss_9" />
				</form>
			<?php } ?>
		</td>
	  </tr>
	</table>

<? if ($_GET['setup']) {echo "<br /><span style=\"color:red;font-weight:bold;font-size:14pt;\">You have successfully upgraded to PNC ".$pncv.".  You are now ready to proceed to the Setup/Configuration step. Please select <a href=\"setup.php?ready=1\">Setup</a> to proceed to the next setup step.</span><br /><br />";

global $prefix,$db,$user_prefix;
function mysql_table_exists($table) {
   $exists = mysql_query("SELECT 1 FROM `$table` LIMIT 0");
   if ($exists) return true;
   return false;
   }
}//end if

?>
    <hr />
    <div class="c1">
      Copyright 2005, 2006 &copy;Raven Web Services<span class="c1"><sup>&trade;</sup></span>, LLC -- All Rights reserved --<br />
      No portion of this document/code may be copied, changed, redistributed, nor reproduced without the written permission of Raven Web Services<span class="c1"><sup>&trade;</sup></span>, LLC
    </div>
    <hr />

<?
// Validate $_POST Data

$isValidOp = FALSE;
$validOp = array('pnc','nss', 'nss_1', 'nss_2', 'nss_3', 'nss_4', 'nss_5', 'nss_6', 'nss_7', 'nss_8', 'nss_9');

if (strlen($_POST['op'])>0 AND (strlen($_POST['op'])==3 OR strlen($_POST['op'])==5)) {
        if (in_array($_POST['op'],$validOp)) {
                $isValidOp = TRUE;
        }
        else {
                rnInstallErr(90);
                die();
        }
}
if (strlen($_POST['submit'])>0 AND $isValidOp) {
        if ($_POST['op']=='pnc') {
                $totalCnt = 0;
                $mtime = microtime();
                $mtime = explode(" ",$mtime);
                $mtime = $mtime[1] + $mtime[0];
                $start_time = $mtime;
                $pncfile = "sql/update45.php";
                if (!file_exists($pncfile)) {rnInstallErr(5); die();}
                include("$pncfile");
                $mtime = microtime();
                $mtime = explode(" ",$mtime);
                $mtime = $mtime[1] + $mtime[0];
                $endtime = $mtime;
                $total_time = round(($endtime - $start_time), 4);
                }
        elseif ($_POST['op']=='nss'){
                $totalCnt = 0;
                $mtime = microtime();
                $mtime = explode(" ",$mtime);
                $mtime = $mtime[1] + $mtime[0];
                $start_time = $mtime;
                $pncfile = "sql/pnc4sentinel.php";
                if (!file_exists($pncfile)) {rnInstallErr(5); die();}
				include("$pncfile");
                $mtime = microtime();
                $mtime = explode(" ",$mtime);
                $mtime = $mtime[1] + $mtime[0];
                $endtime = $mtime;
                $total_time = round(($endtime - $start_time), 4);
                }
        elseif ($_POST['op']=='nss_1'){
                $totalCnt = 0;
                $mtime = microtime();
                $mtime = explode(" ",$mtime);
                $mtime = $mtime[1] + $mtime[0];
                $start_time = $mtime;
                $pncfile = "ip2country/ip2country_01.php";
                if (!file_exists($pncfile)) {rnInstallErr(5); die();}
				include("$pncfile");
                $mtime = microtime();
                $mtime = explode(" ",$mtime);
                $mtime = $mtime[1] + $mtime[0];
                $endtime = $mtime;
                $total_time = round(($endtime - $start_time), 4);
				$pncfile = "ip2country/data/ip2country_1.data";
                }
        elseif ($_POST['op']=='nss_2'){
                        $totalCnt = 0;
                $mtime = microtime();
                $mtime = explode(" ",$mtime);
                $mtime = $mtime[1] + $mtime[0];
                $start_time = $mtime;
                $pncfile = "ip2country/ip2country_02.php";
                if (!file_exists($pncfile)) {rnInstallErr(5); die();}
				include("$pncfile");
                $mtime = microtime();
                $mtime = explode(" ",$mtime);
                $mtime = $mtime[1] + $mtime[0];
                $endtime = $mtime;
                $total_time = round(($endtime - $start_time), 4);
				$pncfile = "ip2country/data/ip2country_2.data";
                }
        elseif ($_POST['op']=='nss_3'){
                $totalCnt = 0;
                $mtime = microtime();
                $mtime = explode(" ",$mtime);
                $mtime = $mtime[1] + $mtime[0];
                $start_time = $mtime;
                $pncfile = "ip2country/ip2country_03.php";
                if (!file_exists($pncfile)) {rnInstallErr(5); die();}
				include("$pncfile");
                $mtime = microtime();
                $mtime = explode(" ",$mtime);
                $mtime = $mtime[1] + $mtime[0];
                $endtime = $mtime;
                $total_time = round(($endtime - $start_time), 4);
				$pncfile = "ip2country/data/ip2country_3.data";
                }
        elseif ($_POST['op']=='nss_4'){
                $totalCnt = 0;
                $mtime = microtime();
                $mtime = explode(" ",$mtime);
                $mtime = $mtime[1] + $mtime[0];
                $start_time = $mtime;
                $pncfile = "ip2country/ip2country_04.php";
                if (!file_exists($pncfile)) {rnInstallErr(5); die();}
				include("$pncfile");
                $mtime = microtime();
                $mtime = explode(" ",$mtime);
                $mtime = $mtime[1] + $mtime[0];
                $endtime = $mtime;
                $total_time = round(($endtime - $start_time), 4);
				$pncfile = "ip2country/data/ip2country_4.data";
                }
        elseif ($_POST['op']=='nss_5'){
                $totalCnt = 0;
                $mtime = microtime();
                $mtime = explode(" ",$mtime);
                $mtime = $mtime[1] + $mtime[0];
                $start_time = $mtime;
                $pncfile = "ip2country/ip2country_05.php";
                if (!file_exists($pncfile)) {rnInstallErr(5); die();}
				include("$pncfile");
                $mtime = microtime();
                $mtime = explode(" ",$mtime);
                $mtime = $mtime[1] + $mtime[0];
                $endtime = $mtime;
                $total_time = round(($endtime - $start_time), 4);
				$pncfile = "ip2country/data/ip2country_5.data";
                }
        elseif ($_POST['op']=='nss_6'){
                $totalCnt = 0;
                $mtime = microtime();
                $mtime = explode(" ",$mtime);
                $mtime = $mtime[1] + $mtime[0];
                $start_time = $mtime;
                $pncfile = "ip2country/ip2country_06.php";
                if (!file_exists($pncfile)) {rnInstallErr(5); die();}
				include("$pncfile");
                $mtime = microtime();
                $mtime = explode(" ",$mtime);
                $mtime = $mtime[1] + $mtime[0];
                $endtime = $mtime;
                $total_time = round(($endtime - $start_time), 4);
				$pncfile = "ip2country/data/ip2country_6.data";
                }
        elseif ($_POST['op']=='nss_7'){
                $totalCnt = 0;
                $mtime = microtime();
                $mtime = explode(" ",$mtime);
                $mtime = $mtime[1] + $mtime[0];
                $start_time = $mtime;
                $pncfile = "ip2country/ip2country_07.php";
                if (!file_exists($pncfile)) {rnInstallErr(5); die();}
				include("$pncfile");
                $mtime = microtime();
                $mtime = explode(" ",$mtime);
                $mtime = $mtime[1] + $mtime[0];
                $endtime = $mtime;
                $total_time = round(($endtime - $start_time), 4);
				$pncfile = "ip2country/data/ip2country_7.data";
                }
        elseif ($_POST['op']=='nss_8'){
                $totalCnt = 0;
                $mtime = microtime();
                $mtime = explode(" ",$mtime);
                $mtime = $mtime[1] + $mtime[0];
                $start_time = $mtime;
                $pncfile = "ip2country/ip2country_08.php";
                if (!file_exists($pncfile)) {rnInstallErr(5); die();}
				include("$pncfile");
                $mtime = microtime();
                $mtime = explode(" ",$mtime);
                $mtime = $mtime[1] + $mtime[0];
                $endtime = $mtime;
                $total_time = round(($endtime - $start_time), 4);
				$pncfile = "ip2country/data/ip2country_8.data";
                }
        elseif ($_POST['op']=='nss_9'){
                $totalCnt = 0;
                $mtime = microtime();
                $mtime = explode(" ",$mtime);
                $mtime = $mtime[1] + $mtime[0];
                $start_time = $mtime;
                $pncfile = "ip2country/ip2country_09.php";
                if (!file_exists($pncfile)) {rnInstallErr(5); die();}
				include("$pncfile");
                $mtime = microtime();
                $mtime = explode(" ",$mtime);
                $mtime = $mtime[1] + $mtime[0];
                $endtime = $mtime;
                $total_time = round(($endtime - $start_time), 4);
				$pncfile = "ip2country/data/ip2country_9.data";
                }
else {rnInstallErr(91); die();}

        // MysQL dump comment types
        $comment[0]="#";
        $comment[1]="--";
        $comment[2]="-- ";
        $comment[3]="---";
        $comment[4]="--- ";

        $lines = file (''.$pncfile.'');
        $num_lines = count ($lines);

		if ($isValidOp) {
                if ($_POST['op']=='pnc') {
                        $_SESSION['pnc']='Installed!!! '.$num_lines.' Lines read and added to the database in '. $total_time .'s';
				}
                if ($_POST['op']=='nss') {
                        $_SESSION['nss']='Installed!!! '.$num_lines.' Lines read and added to the database in '. $total_time .'s';
				}
				if ($_POST['op']=='nss_1') {
                        $_SESSION['nss_1']='Installed!!! '.$num_lines.' Lines read and added to the database in '. $total_time .'s';
				}
				if ($_POST['op']=='nss_2') {
                        $_SESSION['nss_2']='Installed!!! '.$num_lines.' Lines read and added to the database in '. $total_time .'s';
				}
				if ($_POST['op']=='nss_3') {
                        $_SESSION['nss_3']='Installed!!! '.$num_lines.' Lines read and added to the database in '. $total_time .'s';
				}
				if ($_POST['op']=='nss_4') {
                        $_SESSION['nss_4']='Installed!!! '.$num_lines.' Lines read and added to the database in '. $total_time .'s';
				}
				if ($_POST['op']=='nss_5') {
                        $_SESSION['nss_5']='Installed!!! '.$num_lines.' Lines read and added to the database in '. $total_time .'s';
				}
				if ($_POST['op']=='nss_6') {
                        $_SESSION['nss_6']='Installed!!! '.$num_lines.' Lines read and added to the database in '. $total_time .'s';
				}
				if ($_POST['op']=='nss_7') {
                        $_SESSION['nss_7']='Installed!!! '.$num_lines.' Lines read and added to the database in '. $total_time .'s';
				}
				if ($_POST['op']=='nss_8') {
                        $_SESSION['nss_8']='Installed!!! '.$num_lines.' Lines read and added to the database in '. $total_time .'s';
				}
				if ($_POST['op']=='nss_9') {
                        $_SESSION['nss_9']='Installed!!! '.$num_lines.' Lines read and added to the database in '. $total_time .'s';
						$setup = true;
				}
                echo "<script>window.location.href = \"".$_SERVER['PHP_SELF']."?setup=$setup\"</script>";
        }
}
?>
</body>
</html>