<?php
/* #####################################################################################
 *
 * $Id: login.php,v 1.40 2004/02/24 21:07:24 rob Exp $
 *
 * This notice must remain untouched at all times.
 *
 * Modifications to the script, except the official addons or hacks,
 * without the owners permission are prohibited.
 * All rights reserved to their proper authors.
 *
 * ---------------------------------------------
 * http://www.vwar.de || Copyright (C) 2001-2004
 * ---------------------------------------------
 *
 * #####################################################################################
 */

###################################### CONFIGURATION ###################################

// all paths with final ' / ' !

// path to your main vwar-directory (with final ' / ')
// -> from the site, where this extra is included!
// -> use absolute path if you have it included in files with different directories!
//          (e.g. /home/www/htdocs/mysite.com/vwar/)
// -> if included in your _header.php/_footer.php, it is normally: './'
// -> if not, use: './../'
$vwar_xroot  = "./../";

// relative or absolut path from this file to your main vwar directory
$svwar_root  =	"./../";

// relative or absolute path to redirect a user after login. to return back to the site,
// where the login/logout was, insert 'back' (e.g. http://www.mysite.com/vwar/calendar.php)
$pathtosite  =	"back";

// relative or absolute path from the site, the panel is included, to the extra/ directory.
// use absolute path if you have the panel included in 2 or more files! (e.g. /html/vwar/extra/)
$pathtoextra =	"extra/";

// include header- & footer-information (1=enabled / 0=disabled)
$include     = 0;

// ## CONTROL CENTER (this is only displayed to logged in members, use html to display what you want!)
// ---------------------------------------------------------------------------------------------------
// variables you can use:
// $member[name]	= member's name
// $urltovwar		= url to vwar
// $GPC[vwarid]		= member's id of vwar (e.g. important for a "modify your profile"-link)
// NOTE: strings like $xyz, $xyz[xyz] or {$xyz} will be replaced by this script!
$controlcenter = '
<table cellpadding="0" cellspacing="0" border="0" align="center">
	<tr>
		<td>
			&raquo;&nbsp; Logged in as: $member[name]
		</td>
	</tr>
	<tr>
		<td>
			&raquo;&nbsp;<a href="{$urltovwar}admin/member.php?action=editmember&memberid={$GPC[vwarid]}" target="_blank">Own VWar Profile</a>
		</td>
	</tr>
	<tr>
		<td>&raquo;&nbsp;<a href="{$urltovwar}admin/index.php">Admin Control Panel</a></td>
	</tr>
	<tr>
		<td	align="center">
			[ <a href="{$urltovwar}war.php?action=logout">Logout</a> ]
		</td>
	</tr>
</table>
';

// ############################################################################################


// ########################################### start ##########################################

if ( $HTTP_GET_VARS["action"] == "login" )
{
	$vwar_root = $svwar_root;
}

// check, if we need to get some global vars or if we need to include them
if( !defined ("VWAR_COMMON_INCLUDED") )
{
	$vwar_root = $vwar_xroot;
	require_once ( $vwar_root . "includes/functions_common.php" );
}

if ( $include == 1 )
{
	include_once ( $vwar_root . "_header.php" );
}

// ####################################	make login / logout ###################################

//function to return to	the site, where	the user came from
if ( !function_exists("goback") )
{
	function goback()
	{
		global $pathtosite, $GPC;

		if(isset($GPC['from']))
		{
			if($pathtosite == "back")
			{
				$pathtosite = $GPC["from"];
			}
		}

		header("Cache-Control: no-cache, must-revalidate");
		header("Pragma: no-cache");
		header("Location: " . $pathtosite);
	}
}

//login
if ($GPC["action"] == "login")
{
	$result = $vwardb->query_first("
		SELECT memberid, name, password FROM vwar".$n."_member
		WHERE password = '".md5($GPC["loginpassword"])."'
		AND memberid = '".$GPC["memberid"]."'
	");

	if ($result["memberid"] && $result["name"])
	{
		SetVWarCookie("vwarid", $result["memberid"]);
		//SetVWarCookie("vwarpassword", md5($GPC["loginpassword"]));
		SetVWarCookie("vwarpassword", md5(md5($GPC["loginpassword"]))); 
	}

	// disappear....
	goback();
}

// ################################ controlcenter / loginpanel	##############################

?>
<table cellpadding="0" cellspacing="0" border="0" align="center">
	<tr>
		<td>
	<?php

if( checkCookie() )
{
	$member = $vwardb->query_first ("
		SELECT name
		FROM vwar".$n."_member
		WHERE memberid = '" . $GPC["vwarid"] . "'
	");
	dbSelect ($member);
	eval("\$controlcenter = \"" . addslashes($controlcenter) . "\";");
	echo $controlcenter;

} else {

	$result = $vwardb->query("
		SELECT memberid,name FROM vwar".$n."_member
		WHERE ismember = 1
		ORDER BY memberid ASC
	");
	while($row = $vwardb->fetch_array($result))
	{
		dbSelectForm ($row);
		$memberlist .= "<option value=\"".$row["memberid"]."\">".$row["name"]."</option>\n";
	}

	?>
			<table cellpadding="0" cellspacing="0" border="0">
			<form action="<?php echo $pathtoextra."login.php?action=login"; ?>" method="post" target="_self">
			<input type="hidden" name="from" value="<?php echo $GPC["PHP_SELF"] . "?" . $GPC["QUERY_STRING"]; ?>">
				<tr>
					<td>Name:&nbsp;</td>
					<td><select size="1" name="memberid"><?php echo $memberlist; ?></select></td>
				</tr>
				<tr>
					<td>Password:&nbsp;</td>
					<td><input type="password" size="10" maxLength="50" name="loginpassword"></td>
				</tr>
				<tr align="center" valign="bottom">
					<td colspan="2"	height="30"><input type="submit" name="action" value="login"></td>
				</tr>
			</form>
			</table>
	<?php
}
?>
		</td>
	</tr>
</table>
<?php
if ( $include == 1 )
{
	include_once ( $vwar_root . "_footer.php" );
}
?>