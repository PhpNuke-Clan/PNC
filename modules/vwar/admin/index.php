<?php
/* #####################################################################################
 *
 * $Id: index.php,v 1.62 2004/07/22 09:03:58 mabu Exp $
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

// get functions
$vwar_root = "./../";
require($vwar_root . "modname.php");
require($vwar_root . "includes/functions_common.php");
require($vwar_root . "includes/functions_admin.php");

// ################################### start login  ####################################
if ($GPC['action'] == "login" || !isset($GPC['action']))
{
	if (isset($HTTP_POST_VARS['login']))
	{
		$row = $vwardb->query_first("
			SELECT memberid, ismember
			FROM vwar".$n."_member
			WHERE name = '".$GPC['username']."'
			AND password = '".md5(trim($GPC['userpassword']))."'
			AND status <> '0'
		");

		if ($row['memberid'] && $row['ismember'] == 1)
		{
			SetVWarCookie("vwarid", $row['memberid']);
			SetVWarCookie("vwarpassword", md5(md5($GPC['userpassword']))); 

			eval("\$vwartpl->output(\"".$vwartpl->get("admin_frameset")."\",1);");
		}
		else
		{
			header("Location: index.php?login=1");
		}
	}
	else
	{
		if (checkCookie() && $HTTP_GET_VARS['login'] != 1)
		{
			eval("\$vwartpl->output(\"".$vwartpl->get("admin_frameset")."\",1);");
		}
		else
		{
			// template-cache, standard-templates will be added by script:
			$vwartpllist = "admin_login_userselect,admin_login";
			$vwartpl->cache($vwartpllist);

			eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\",1);");

			$result = $vwardb->query("
				SELECT name, password
				FROM vwar".$n."_member
				WHERE ismember = '1'
				AND status <> '0'
				ORDER BY name ASC
			");
			while ($row = $vwardb->fetch_array($result))
			{
				eval ("\$admin_login_userselect .= \"".$vwartpl->get("admin_login_userselect")."\";");
			}
			eval("\$vwartpl->output(\"".$vwartpl->get("admin_login")."\");");
		}
		eval("\$vwartpl->output(\"".$vwartpl->get("admin_copyright")."\");");
	}
}

// ################################### welcome message #################################
if ($GPC['action'] == "welcome")
{
	// check general permission
	if (!checkCookie())
	{
		header("Location: index.php");
		exit;
	}
	//template-cache, standard-templates will be added by script:
	$vwartpllist="admin_welcome,admin_update";
	$vwartpl->cache($vwartpllist);

	// check for update
	/*$url = "http://web8.bmbnet.com/update.dat";
	$handle = @fopen($url,"rb");
	if ($handle)
	{
		// read content
		$content = trim(fread($handle,10240));
		
		//Hi-Wire check
		$vwarversion = ereg_replace('Hi-Wire','', $vwarversion);
		//$vwarversion = ereg_replace('1.5 ','1.5.0.', $vwarversion);
		//end Hi-Wire check
		
		// extract
		if (preg_match("/<update version=\"(.*)\">(?:.*)<\/update>/isU",$content,$upmatch))
		{
			if ($upmatch[1] > $vwarversion.'.R'.VWAR_RELEASE)
			{
				// get version
				$info['version'] = $upmatch[1];

				// get title
				if (preg_match("/<title>(.*)<\/title>/isU",$upmatch[0],$tmp))
				{
					$info['title'] = $tmp[1];
					unset($tmp);
				}

				// get text
				if (preg_match("/<text>(.*)<\/text>/isU",$upmatch[0],$tmp))
				{
					$info['text'] = nl2br(parseText($tmp[1],$GPC['vwarid'],1,0,1,1));
					unset($tmp);
				}

				eval("\$updateinfo .= \"".$vwartpl->get("admin_update")."\";");
			}
		}
	}
*/

	// check for update Hi-Wire
	$url = "http://phpnuke-clan.com/version/update.dat";
	$handle = @fopen($url,"rb");
	if ($handle)
	{
		// read content
		$content = trim(fread($handle,10240));
		
		//Hi-Wire check
		$vwarversion = ereg_replace('Hi-Wire','', $vwarversion);
		//$vwarversion = ereg_replace('1.5 ','1.5.0.', $vwarversion);
		//end Hi-Wire check
		
		// extract
		if (preg_match("/<update version=\"(.*)\">(?:.*)<\/update>/isU",$content,$upmatch))
		{
			if ($upmatch[1] > $vwarversion.'.R'.VWAR_RELEASE)
			{
				// get version
				$info['version'] = $upmatch[1];

				// get title
				if (preg_match("/<title>(.*)<\/title>/isU",$upmatch[0],$tmp))
				{
					$info['title'] = $tmp[1];
					unset($tmp);
				}

				// get text
				if (preg_match("/<text>(.*)<\/text>/isU",$upmatch[0],$tmp))
				{
					$info['text'] = nl2br(parseText($tmp[1],$GPC['vwarid'],1,0,1,1));
					unset($tmp);
				}

				eval("\$updateinfo .= \"".$vwartpl->get("admin_update")."\";");
			}
		}
	}


	// get the quick infos
	$result = $vwardb->query_first("SELECT COUNT(joinid) AS pending_joins FROM vwar".$n."_join");
	$pending_joins = ifelse($result['pending_joins'] > 0, makelink("member.php?action=viewjoin", $result['pending_joins']), "NO");

	$result = $vwardb->query_first("SELECT COUNT(challengeid) AS pending_challenges FROM vwar".$n."_challenge");
	$pending_challenges = ifelse($result['pending_challenges'] > 0, makelink("admin.php?action=viewchallenges", $result['pending_challenges']), "NO");

	eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
	eval("\$vwartpl->output(\"".$vwartpl->get("admin_welcome")."\");");
}

// ################################### head navigation #################################
if ($GPC['action'] == "headnav")
{
	// check general permission
	if (!checkCookie())
	{
		header("Location: index.php");
		exit;
	}
	$name = $vwardb->query_first("SELECT name FROM vwar".$n."_member WHERE memberid = '".$GPC['vwarid']."'");
	eval("\$vwartpl->output(\"".$vwartpl->get("admin_headnav")."\");");
}

// ################################### do adminmenu  ###################################
if ($GPC['action'] == "adminmenu")
{

	// check general permission
	if (!checkCookie())
	{
		header("Location: index.php");
		exit;
	}
	else
	{
		// Check for permissions
		$rights = $vwardb->query_first("
			SELECT vwar".$n."_accessgroup.*
			FROM vwar".$n."_member, vwar".$n."_accessgroup
			WHERE vwar".$n."_member.accessgroupid = vwar".$n."_accessgroup.accessgroupid
			AND memberid = '".$GPC['vwarid']."'");

		if ($GPC['do'] == "expand")
		{
			$GPC['show'] = "";
			$result = $vwardb->query("SELECT groupname FROM vwar".$n."_acpmenugroups");
			while ($row = $vwardb->fetch_array($result))
			{
				$GPC['show'] .= $row['groupname'];
			}
			unset($row);
		}
		elseif ($GPC['do'] == "reduce")
		{
			$GPC['show'] = "";
		}

		$GPC['QUERY_STRING'] = "show=" . $GPC['show'];

		eval("\$vwartpl->output(\"".$vwartpl->get("admin_adminmenu_header")."\");");

		// create menu
		$group_result = $vwardb->query("
			SELECT *
			FROM vwar".$n."_acpmenugroups
			ORDER BY displayorder ASC, grouptitle ASC
		");

		while ($group = $vwardb->fetch_array($group_result))
		{
			// check rights
            $group['cond'] = trim($group['cond']);
            if (checkRights($group['cond'], $rights,$group['condtype']) || empty($group['cond']))
			{
				if (substr_count($GPC['show'], $group['groupname']) > 0)
				{
					unset($tmp);
					$tmp = str_replace($group['groupname'], "", $GPC['QUERY_STRING']);

					echo '
					<table cellpadding="2" cellspacing="1" border="0" width="95%" align="center" class="tblborder">
						<tr>
							<td class="headline" align="center" nowrap="nowrap"><a name="'.$group['groupname'].'" href="index.php?action=adminmenu&amp;'.$tmp.'">'.$group['grouptitle'].'</a></td>
						</tr>';

					// get items
					$dataposted = FALSE;
					unset($item);
					unset($printbreak);

					$item_result = $vwardb->query("
						SELECT *
						FROM vwar".$n."_acpmenuitems
						WHERE groupid = '".$group['groupid']."'
						ORDER BY displayorder ASC, itemtitle ASC
					");
					while ($item = $vwardb->fetch_array($item_result))
					{
						// break or normal line
						if ($item['itemtype'] == "BREAK")
						{
							if ($dataposted)
							{
								$printbreak = TRUE;
								$dataposted = FALSE;
							}
						}
						else if ($item['itemtype'] == "LINE")
						{
                            $item['cond'] = trim($item['cond']);

                            if (checkRights($item['cond'],$rights,$item['condtype']) || empty($item['cond']))
							{
								if ($printbreak)
								{
									echo "<tr><td class=\"secondalt\">" . makeimgtag($vwar_root . "images/spacer.gif") . "</td></tr>\n";
									$printbreak = FALSE;
								}

								echo "<tr><td class=\"firstalt\"><a href=\"".$item['destination']."\" target=\"main\">".$item['itemtitle']."</a></td></tr>\n";

								$break = "";
								$dataposted = TRUE;
							}
						}
					}

					echo '
					</table><br />';
				}
				else
				{
					echo '
					<table cellpadding="2" cellspacing="1" border="0" width="95%" align="center" class="tblborder">
						<tr>
							<td class="headline" align="center" nowrap="nowrap">
								<a href="index.php?action=adminmenu&amp;' . $GPC['QUERY_STRING'] . $group['groupname'] . '#' . $group['groupname'] . '">' . $group['grouptitle'] . '</a>
							</td>
						</tr>
					</table><br />';
				}
			}
		}

		eval("\$vwartpl->output(\"".$vwartpl->get("admin_adminmenu_footer")."\");");
	}
}
?>