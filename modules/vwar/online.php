<?php
/* #####################################################################################
 *
 * $Id: online.php,v 1.26 2004/02/24 21:07:24 rob Exp $
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

// ####################################### CONFIGURATION  ###############################

// path to your main vwar-directory (with final ' / ')
// -> from the site, where this extra is included!
// -> use absolute path if you have it included in files with different directories!
//          (e.g. /home/www/htdocs/mysite.com/vwar/)
// -> if included in your _header.php/_footer.php, it is normally: './'
// -> if not, use: './../'
$vwar_root = "modules/" . basename(dirname(__FILE__)) ."/";
require($vwar_root . "modname.php");
// define how long a member will be shown after his last activity (in minutes)
$onlinetime = 10;

// include header- & footer-information (1=enabled / 0=disabled)
$include    = 0;

// ######################################################################################


// ################################### display members  ################################

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

if(!defined("VWAR_LAST_ACTIVITY") && $whoisonline == 1 && !empty($GPC['vwarid']))
{
	define("VWAR_LAST_ACTIVITY", 1);
	$vwardb->query("UPDATE vwar".$n."_member SET lastactivity = '".time()."' WHERE memberid = '".$GPC['vwarid']."'");
}
?>
<table border="0" cellpadding="0" cellspacing="0" align="center">
	<tr>
		<td align="center" colspan="2"><b>Activities in the last <?php echo $onlinetime; ?> minutes</b></td>
	</tr>
<?php
$query = $vwardb->query("
	SELECT memberid, name, lastactivity
	FROM vwar".$n."_member WHERE lastactivity > ".(time() - $onlinetime * 60)."
");
if ($vwardb->num_rows($query) == 0)
{
?>
	<tr>
		<td align="center" width="100%">Nobody online right now</td>
	</tr>
<?php
}
else
{
	while ($row = $vwardb->fetch_array($query))
	{
		dbSelect ($row);
	?>
	<tr>
		<td align="left" width="70%">&raquo; <a href="<?php echo $urltovwar; ?>member.php?action=profile&amp;memberid=<?php echo $row['memberid']; ?>"><?php echo $row['name']; ?></a></td>
		<td align="right" width="30%"><?php echo date("H:i",$row['lastactivity']); ?></td>
	</tr>
	<?php
	}
}
$vwardb->free_result($query);
?>
</table>
<?php
if ( $include == 1 )
{
//	include_once ( $vwar_root . "_footer.php" );
}
?>