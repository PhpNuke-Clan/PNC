<?php
/* #####################################################################################
 *
 * $Id: _header.php,v 1.9 2004/03/07 14:53:09 mabu Exp $
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

// place your header site content in here
// include("what/ever/you/want");
// if you include styles here, you MUST edit the header template !!!
require ("header.php");
$index=1;
OpenTable();
//$vwar_root
global $user,$vwarmod;
cookiedecode($user);
$uname = $cookie[1];		
$result = $vwardb->query("SELECT memberid, ismember, password FROM vwar".$n."_member WHERE userid = '$uname'");
$row = mysql_fetch_assoc($result);
if ($uname == "")
{
} else {
		
		if ($row['memberid'] && $row['ismember'] == 1)
		{
		//echo "<a href=\"modules/vwar/admin/\" target=\"_self\">Admin Control Panel/Edit Profile</a>";
			SetVWarCookie("vwarid", $row['memberid']);
			SetVWarCookie("vwarpassword", md5($row['password']));

			eval("\$vwartpl->output(\"".$vwartpl->get("admin_frameset")."\",1);");
		}
		else
		{

		}
}
//echo"$uname";
?>