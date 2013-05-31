<?
/**
Written and solely owned by Raven Web Services, LLC
Not for distribution other than by Raven Web Services, LLC
Copyright 2005,2006
Modified to install PNC4.0 by PNC team
**/
$debug = FALSE;
Header("Cache-control: private, no-cache");

$ready = $_GET['ready'];
if( !isset( $_GET['ready'] ))
{
$ready = "";
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>PNC&trade; Setup/Configuration Tool</title>
<META NAME="RATING" CONTENT="GENERAL">
<META NAME="GENERATOR" CONTENT="By http://www.phpnuke-clan.com">
<script type="text/javascript">
	function validateInput(formName) {
		formName.bbconfig_server_name.value=formName.config_nukeurl.value.replace('http://','');
		if (!emptyCheck(formName)) return false;
		var myVar = '';
		for(i=0; i<formName.elements.length; i++) {
			myVar += (formName.elements[i].name + " = " + formName.elements[i].value + "\n");
		}
		<? if ($debug) echo "alert(myVar);"; ?>
		// Email format check
		if (!emailCheck (formName.config_adminmail.value)) return false;
		if (!emailCheck (formName.nsnst_config_admin_contact.value)) return false;
		if (!emailCheck (formName.users_user_email.value)) return false;
		if (!emailCheck (formName.bbconfig_board_email.value)) return false;
		// Password length enforced to 8 or 4
		var minPwdLength=4;
		if (!lengthCheck('*God* Admin Password',formName.authors_pwd.value,minPwdLength)) return false;
		if (!lengthCheck('Member User Password',formName.users_user_password.value,minPwdLength)) return false;
		if (!lengthCheck('NukeSentinel(tm) Admin Password',formName.nsnst_admins_password.value,minPwdLength)) return false;
		return true;
	}
</script>

<script type="text/javascript">
<!-- Begin
function lengthCheck (varPseudoName,varName,varLength) {
	if (varName.length<varLength) {
		alert('The length of '+varPseudoName+' must be at least '+varLength+' long');
		return false;
	}
	return true;
}

function emptyCheck2 (formName) {
	for(i=0; i<formName.elements.length; i++) {
		if (formName.elements[i].value.length < 1) {
			alert('All fields must be filled in.');
			return false;
		}
	}
	return true;
}

/*function emptyCheck(formName) {
   if ((formName.value.length==0) ||
   (formName.value==null)) {
      return true;
   }
   else { return false; }
}*/


function emailCheck (emailStr) {
<!-- This script and many more are available free online at -->
<!-- The JavaScript Source!! http://javascript.internet.com -->

<!-- V1.1.3: Sandeep V. Tamhankar (stamhankar@hotmail.com) -->
<!-- Original:  Sandeep V. Tamhankar (stamhankar@hotmail.com) -->
<!-- Changes:
/* 1.1.4: Fixed a bug where upper ASCII characters (i.e. accented letters
international characters) were allowed. */

/* The following variable tells the rest of the function whether or not
to verify that the address ends in a two-letter country or well-known
TLD.  1 means check it, 0 means don't. */

var checkTLD=1;

/* The following is the list of known TLDs that an e-mail address must end with. */

var knownDomsPat=/^(com|net|org|edu|int|mil|gov|arpa|biz|aero|name|coop|info|pro|museum)$/;

/* The following pattern is used to check if the entered e-mail address
fits the user@domain format.  It also is used to separate the username
from the domain. */

var emailPat=/^(.+)@(.+)$/;

/* The following string represents the pattern for matching all special
characters.  We don't want to allow special characters in the address.
These characters include ( ) < > @ , ; : \ " . [ ] */

var specialChars="\\(\\)><@,;:\\\\\\\"\\.\\[\\]";

/* The following string represents the range of characters allowed in a
username or domainname.  It really states which chars aren't allowed.*/

var validChars="\[^\\s" + specialChars + "\]";

/* The following pattern applies if the "user" is a quoted string (in
which case, there are no rules about which characters are allowed
and which aren't; anything goes).  E.g. "jiminy cricket"@disney.com
is a legal e-mail address. */

var quotedUser="(\"[^\"]*\")";

/* The following pattern applies for domains that are IP addresses,
rather than symbolic names.  E.g. joe@[123.124.233.4] is a legal
e-mail address. NOTE: The square brackets are required. */

var ipDomainPat=/^\[(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})\]$/;

/* The following string represents an atom (basically a series of non-special characters.) */

var atom=validChars + '+';

/* The following string represents one word in the typical username.
For example, in john.doe@somewhere.com, john and doe are words.
Basically, a word is either an atom or quoted string. */

var word="(" + atom + "|" + quotedUser + ")";

// The following pattern describes the structure of the user

var userPat=new RegExp("^" + word + "(\\." + word + ")*$");

/* The following pattern describes the structure of a normal symbolic
domain, as opposed to ipDomainPat, shown above. */

var domainPat=new RegExp("^" + atom + "(\\." + atom +")*$");

/* Finally, let's start trying to figure out if the supplied address is valid. */

/* Begin with the coarse pattern to simply break up user@domain into
different pieces that are easy to analyze. */

var matchArray=emailStr.match(emailPat);

if (matchArray==null) {

/* Too many/few @'s or something; basically, this address doesn't
even fit the general mould of a valid e-mail address. */

alert("Email address seems incorrect (check @ and .'s)");
return false;
}
var user=matchArray[1];
var domain=matchArray[2];

// Start by checking that only basic ASCII characters are in the strings (0-127).

for (i=0; i<user.length; i++) {
if (user.charCodeAt(i)>127) {
alert("Ths username contains invalid characters.");
return false;
   }
}
for (i=0; i<domain.length; i++) {
if (domain.charCodeAt(i)>127) {
alert("Ths domain name contains invalid characters.");
return false;
   }
}

// See if "user" is valid

if (user.match(userPat)==null) {

// user is not valid

alert("The username doesn't seem to be valid.");
return false;
}

/* if the e-mail address is at an IP address (as opposed to a symbolic
host name) make sure the IP address is valid. */

var IPArray=domain.match(ipDomainPat);
if (IPArray!=null) {

// this is an IP address

for (var i=1;i<=4;i++) {
if (IPArray[i]>255) {
alert("Destination IP address is invalid!");
return false;
   }
}
return true;
}

// Domain is symbolic name.  Check if it's valid.

var atomPat=new RegExp("^" + atom + "$");
var domArr=domain.split(".");
var len=domArr.length;
for (i=0;i<len;i++) {
if (domArr[i].search(atomPat)==-1) {
alert("The domain name does not seem to be valid.");
return false;
   }
}

/* domain name seems valid, but now make sure that it ends in a
known top-level domain (like com, edu, gov) or a two-letter word,
representing country (uk, nl), and that there's a hostname preceding
the domain or country. */

if (checkTLD && domArr[domArr.length-1].length!=2 &&
domArr[domArr.length-1].search(knownDomsPat)==-1) {
alert("The address must end in a well-known domain or two letter " + "country.");
return false;
}

// Make sure there's a host name preceding the domain.

if (len<2) {
alert("This address is missing a hostname!");
return false;
}

// If we've gotten this far, everything's valid!
return true;
}

//  End -->
</script>

<style type="text/css">
/*<![CDATA[*/
 body.c1 {background-color:#E2E2E2}
 div.c1 {text-align: center}
 input.c1 {width:300px;}
 input.c2 {}
 p.c1 {font-weight: bold}
 span.c1 {font-size:small;}
 span.c2 {color:red;font-weight:bold;}
 span.c3 {color:blue;font-weight:bold;}
/*]]>*/
</style>
</head>
  <body class="c1">

    <img src="PNC_logo.png" border="0" />
    <h2>
      PNC&trade; &copy; 2006, 2007 - PNC&trade; Setup/Configuration Tool
    </h2>
    <span class="c2">Please note that this Tool will setup your basic Configuration settings, but not all of them.  You will still want/need to look over all of the various configurations in your application. </span>
    <hr />
    <p class="c1">
      <u>MySQL Database Connectivity Test Results</u>
    </p>
<?
ini_set('display_errors','on');
ini_set('mysql.connect_timeout',120);
$dbCheck = array();
$nukeConfigFile = "../config.php";
if (!file_exists($nukeConfigFile)) {rnInstallErr(1); die();}
echo '<b>config.php file found!</b><br />';
require_once("../config.php");
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
	elseif ($errNum==82) die('<script type=\'text/javascript\'>alert(\'Not all fileds were filled in, please make sure every filed has a value!!\');</script>');
	elseif ($errNum==83) die('<br><br><center><a href=\"http://www.phpnuke-clan.net\" title=\"PHPNUKE CLAN Edition\"><img src=\"PNC_logo.png\" border=\"0\" /></a><br><br><table width=\"75%\" border=\"1\"><tr><td align=\"center\" style=\"color:blue;font-weight:bold;\">Not all fileds were filled in, please make sure every filed has a value!!</td></tr></table></center>');
	elseif ($errNum==84) echo('<script type=\'text/javascript\'>alert(\'This script has already been run. OR there is already an admin account created. You can not run this script any longer. \');</script>');
	elseif ($errNum==85) die('<br><br><center><br><br><table width=\'75%\' border=\'1\'><tr><td align=\'center\' style=\'color:blue;font-weight:bold;\'>Installation Completed:<br />Please delete the INSTALLATION folder.<br /><br />Install vWar:<br />If you are wish to do a clean install of vWar go <a href=\'../install_vwar.php\' target=\'_blank\'>here</a>.<br /><font color=red>Remember to delete install_vwar.php when vWar is installed.</font><br />If you are updating your site please make sure you are running the most current version of vWar.  The latest version of vWar can be found <a href=\'http://www.phpnuke-clan.net/modules.php?name=Downloads&d_op=viewdownload&cid=11#cat\' target=\'_blank\'>here</a><br /><br />Once all the above is completed you can view your site <a href=\'../index.php\'>here</a>.</td></tr></table></center>');

}
if($ready == 1){

echo '<script type=\'text/javascript\'>alert(\'Congratulations! Configuration has been completed. Please continue with the next step the Guide.\');</script>';
	rnInstallErr(85); 
die();
	}

?>
<hr />
    <p>
      The intent of this Configuration Tool is to make your System setup and configuration as painless as possible, on both Windows and *nix platforms. Hopefully you will not experience any problems, but if you do, please consult the forums at http://www.phpnuke-clan.net and if the problem has not yet been reported then please post it.  <b>Please fill in all fields on this panel.  They can be changed later. For convenience, some fields will be pre-populated based on other field values but can be over-written.</b> <span "style="color:red;font-weight:bold;">All passwords must be at least 4 long.</span>
    </p>
    <hr />
    <table>
      <tr>
        <td>
          <form onSubmit="return validateInput(configform)" name="configform" method="post" action="<?=$_SERVER['PHP_SELF'];?>">
            <h4>Configuration Settings For PNC4.0&trade; Core Functionality</h4>
            <table>
            	<tr>
            		<td>Site Name:</td><td><input onChange="configform.bbconfig_sitename.value=this.value" class="c2" size="60" name="config_sitename" value="<?=$_POST['config_sitename']?>" /></td>
            	</tr>
            	<tr>
            		<td>Site URL (With http://):</td><td><input class="c2" size="60" name="config_nukeurl" value="<?$_POST['config_nukeurl'] = (empty($_POST['config_nukeurl'])?'http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']:$_POST['config_nukeurl']);echo str_replace('/INSTALLATION/setup.php','',$_POST['config_nukeurl']);?>" /></td>
            	</tr>
            	<tr>
            		<td>Site Slogan:</td><td><input class="c2" size="60" name="config_slogan" value="<?=$_POST['config_slogan']?>" /></td>
            	</tr>
            	<tr>
            		<td>Site Start Date (Freeform):</td><td><input class="c2" size="60" name="config_startdate" value="<?=$_POST['config_startdate'] = (empty($_POST['config_startdate'])?date('F d, Y'):$_POST['config_startdate']);?>" /></td>
            	</tr>
            	<tr>
            		<td>Administrator Email:</td><td><input onChange="configform.bbconfig_board_email.value=this.value;configform.authors_email.value=this.value;configform.nsnst_config_admin_contact.value=this.value;configform.users_user_email.value=this.value" class="c2" size="60" name="config_adminmail" value="<?=$_POST['config_adminmail']?>" /></td>
            	</tr>
            	<tr>
            		<td>*GOD* Administrator UserName:</td><td><input onChange="configform.nsnst_admins_login.value=this.value;configform.users_username.value=this.value;configform.nsnst_admins_aid.value=this.value" class="c2" size="60" name="authors_aid" value="<?=$_POST['authors_aid']?>" /></td>
            	</tr>
            	<tr>
            		<td>*GOD* Administrator Password:</td><td><input class="c2" size="60" name="authors_pwd" value="<?=$_POST['authors_pwd']?>" /></td>
            	</tr>
            	<tr>
            		<td>Your Regular Member UserName:</td><td><input class="c2" size="60" name="users_username" value="<?=$_POST['users_username']?>" /></td>
            	</tr>
            	<tr>
            		<td>Your Regular Member Password:</td><td><input class="c2" size="60" name="users_user_password" value="<?=$_POST['users_user_password']?>" /></td>
            	</tr>
            	<tr>
            		<td>Your Regular Member Email:</td><td><input class="c2" size="60" name="users_user_email" value="<?=$_POST['users_user_email']?>" /></td>
            	</tr>
				</table>
				<hr />
            <h4>Configuration Settings For NukeSentinel&trade; Core Functionality</h4>
            <b>Note that the admin name/password can be the same as the Core Admin name/password but for better security you should change them.</b>
            <table>
            	<tr>
            		<td>Administrator Email:</td><td><input class="c2" size="60" name="nsnst_config_admin_contact" value="<?=$_POST['nsnst_config_admin_contact']?>" /></td>
            	</tr>
            	<tr>
            		<td>*GOD* Administrator NukeSentinel&trade; UserName:</td><td><input class="c2" size="60" name="nsnst_admins_login" value="<?=$_POST['nsnst_admins_login']?>" /></td>
            	</tr>
            	<tr>
            		<td>*GOD* Administrator NukeSentinel&trade; Password:</td><td><input class="c2" size="60" name="nsnst_admins_password" value="<?=$_POST['nsnst_admins_password']?>" /></td>
            	</tr>
				</table>
				<!-- nuke_authors begin -->
				<input type="hidden" name="authors_email" value="<?=$_POST['authors_email']?>" />
				<input type="hidden" name="authors_radminsuper" value='1' />
				<!-- nuke_authors end   -->
				<!-- nuke_bbconfig begin -->
				<input type="hidden" name="bbconfig_server_name" value="<?=$_POST['bbconfig_server_name']?>" />
				<input type="hidden" name="bbconfig_sitename" value="<?=$_POST['bbconfig_sitename']?>" />
				<input type="hidden" name="bbconfig_board_email" value="<?=$_POST['bbconfig_board_email']?>" />
				<input type="hidden" name="bbconfig_board_email_sig" value="Thanks, <?=$_POST['bbconfig_board_email_sig']?>" />
				<!-- nuke_bbconfig end   -->
				<!-- nuke_nsnst_admins begin -->
				<input type="hidden" name="nsnst_admins_protected" value='1' />
				<input type="hidden" name="nsnst_admins_aid" value="<?=$_POST['nsnst_admins_aid']?>" />
				<!-- nuke_nsnst_admins end   -->
				<!-- nuke_nsnst_config begin -->
				<!-- nuke_nsnst_config end   -->
				<!-- nuke_users begin -->
				<input type="hidden" name="users_user_avatar" value='blank.gif' />
				<input type="hidden" name="users_user_regdate" value="<?=date('M d, Y');?>" />
				<input type="hidden" name="freshinst" value="1" />
				<!-- nuke_users end   -->
				<hr /><br />
				<input type="submit" name="updateconfig" value="Update" />
          </form>
        </td>
      </tr>

    </table>
    <hr />
    <div class="c1">
      Copyright 2005, 2006 &copy;Raven Web Services<span class="c1"><sup>&trade;</sup></span>, LLC -- All Rights reserved --<br />
      No portion of this document/code may be copied, changed, redistributed, nor reproduced without the written permission of Raven Web Services<span class="c1"><sup>&trade;</sup></span>, LLC
    </div>
    <hr />

<?
global $prefix;
// Validate $_POST Data
if (isset($_POST['updateconfig']) AND $_POST['updateconfig']=='Update') {
	extract($_POST);
	if ($debug) echo '<script type=\'text/javascript\'>alert(\'Submitting Form\');</script>';
if ($config_sitename == "" || $config_nukeurl == ""|| $config_slogan == "" || $config_startdate == "" || $config_adminmail == ""
|| $authors_aid == "" || $authors_pwd == "" || $users_username == "" || $users_user_password == "" || $users_user_email == ""
|| $nsnst_config_admin_contact == "" || $nsnst_admins_login == "" || $nsnst_admins_password == "")
{rnInstallErr(82); die();
}	

$the_first = mysql_num_rows(mysql_query("SELECT * FROM ".$prefix."_authors"));
if ($the_first > 0) {rnInstallErr(84); die();}
	// Posting data to nuke_config table
	$sql = "UPDATE ".$prefix."_config set sitename='".mysql_escape_string($config_sitename)."', nukeurl='$config_nukeurl', slogan='".mysql_escape_string($config_slogan)."', startdate='$config_startdate', adminmail='$config_adminmail'";
	$rc = @mysql_query($sql);
	if (!$rc) die('Unable to Update '.$prefix.'_config table. MySQL reported: '.mysql_error()."<br />$sql");
	if ($debug) echo '<script type=\'text/javascript\'>alert(\''.$prefix.'_config table updated\');</script>';

	// Posting data to nuke_authors table
	$sql = 'TRUNCATE TABLE '.$prefix.'_authors';
	$rc = @mysql_query($sql);
	if (!$rc) die('Unable to truncate '.$prefix.'_authors table. MySQL reported: '.mysql_error());
	if ($debug) echo '<script type=\'text/javascript\'>alert(\''.$prefix.'_authors table truncated\');</script>';
	$sql = "INSERT INTO ".$prefix."_authors (name,aid,pwd,email,radminsuper) values('God','$authors_aid','".md5($authors_pwd)."','$authors_email','$authors_radminsuper')";
	$rc = @mysql_query($sql);
	if (!$rc) die('Unable to Insert into '.$prefix.'_authors table. MySQL reported: '.mysql_error()."<br />$sql");
	if ($debug) echo '<script type=\'text/javascript\'>alert(\''.$prefix.'_authors table updated\');</script>';

	// Posting data to nuke_bbconfig table
	$sql = "UPDATE ".$prefix."_bbconfig set config_value='".mysql_escape_string($bbconfig_server_name)."' WHERE config_name='server_name'";
	$rc = @mysql_query($sql);
	if (!$rc) die('Unable to Update '.$prefix.'_bbconfig table (server_name). MySQL reported: '.mysql_error()."<br />$sql");
	$sql = "UPDATE ".$prefix."_bbconfig set config_value='".mysql_escape_string($bbconfig_sitename)."' WHERE config_name='sitename'";
	$rc = @mysql_query($sql);
	if (!$rc) die('Unable to Update '.$prefix.'_bbconfig table (sitename). MySQL reported: '.mysql_error()."<br />$sql");
	$sql = "UPDATE ".$prefix."_bbconfig set config_value='".mysql_escape_string($bbconfig_board_email)."' WHERE config_name='board_email'";
	$rc = @mysql_query($sql);
	if (!$rc) die('Unable to Update '.$prefix.'_bbconfig table (board_email). MySQL reported: '.mysql_error()."<br />$sql");
	if ($debug) echo '<script type=\'text/javascript\'>alert(\''.$prefix.'_bbconfig table updated\');</script>';

	// Posting data to nuke_nsnst_config table
	$sql = "UPDATE ".$prefix."_nsnst_config set config_value='".mysql_escape_string($nsnst_config_admin_contact)."' WHERE config_name='admin_contact'";
	$rc = @mysql_query($sql);
	if (!$rc) die('Unable to Update '.$prefix.'_nsnst_config table. MySQL reported: '.mysql_error()."<br />$sql");
	if ($debug) echo '<script type=\'text/javascript\'>alert(\''.$prefix.'_nsnst_config table updated\');</script>';

	// Posting data to nuke_nsnst_admins table
	$sql = 'TRUNCATE TABLE '.$prefix.'_nsnst_admins';
	$rc = @mysql_query($sql);
	if (!$rc) die('Unable to truncate '.$prefix.'_nsnst_admins table. MySQL reported: '.mysql_error());
	if ($debug) echo '<script type=\'text/javascript\'>alert(\''.$prefix.'_nsnst_admins table truncated\');</script>';
	$sql = "INSERT INTO ".$prefix."_nsnst_admins (login, password, protected, aid, password_md5, password_crypt) values('$nsnst_admins_login','$nsnst_admins_password','$nsnst_admins_protected','$nsnst_admins_aid','".md5($nsnst_admins_password)."', '".crypt($nsnst_admins_password)."')";
	$rc = @mysql_query($sql);
	if (!$rc) die('Unable to Insert into '.$prefix.'_nsnst_admins table. MySQL reported: '.mysql_error()."<br />$sql");
	if ($debug) echo '<script type=\'text/javascript\'>alert(\''.$prefix.'_nsnst_admins table updated\');</script>';

	// Posting data to nuke_users table
	$sql = "INSERT INTO ".$user_prefix."_users (user_avatar, user_regdate, username, user_email, user_password) values('$users_user_avatar', '$users_user_regdate', '".mysql_escape_string($users_username)."','$users_user_email','".md5($users_user_password)."')";
	
	$rc = @mysql_query($sql);
	if (!$rc) die('Unable to Insert into '.$prefix.'_users table. MySQL reported: '.mysql_error()."<br />$sql");
	if ($debug) echo '<script type=\'text/javascript\'>alert(\''.$prefix.'_users table updated\');</script>';
	
	if($freshinst == 1){
	echo "<script>window.location.href = \"".$_SERVER['PHP_SELF']."?ready=1\"</script>";	
	}
}
?>
</body>
</html>
