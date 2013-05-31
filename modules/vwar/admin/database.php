<?php
/* #####################################################################################
 *
 * $Id: database.php,v 1.47 2004/05/31 10:08:21 mabu Exp $
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
require($vwar_root . "includes/classes/class_backup.php");

if (!checkCookie())
{
	header("Location: index.php");
}

checkPermission("isadmin");

$tables = $vwardb->gettables();

// #################################### optimize database ###########################################
if ($GPC['action'] == "optimize")
{
	if ($GPC['add'] || $GPC['add_x'])
	{
		//template-cache, standard-templates will be added by script:
		$vwartpllist="admin_db_optimizationbit_nogain,admin_db_optimizationbit,admin_db_optimizationreport";
		$vwartpl->cache($vwartpllist);

		eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");

		//optimization-procedure, using mysql tool 'optimize', we only fetch official tables(!)
		$result = $vwardb->query ("SHOW TABLE STATUS FROM `" . $sql['database'] . "`");
		while ( $row = $vwardb->fetch_array($result) )
		{
			switchColors();

			$tablename = $row["Name"];

			// only optimize official tables!
			if ( !in_array($tablename, $tables) )
			{
				continue;
			}

			$total       = round ( (($row['Data_length'] + $row['Index_length']) / 1024), 3 );
			$gain        = $row['Data_free'] / 1024;
			$total_gain += $gain;
			$total_used += $total;

			$vwardb->query ("OPTIMIZE TABLE `" . $tablename . "`");

			$gain = round($gain, 3);

			eval("\$optimizationbit .= \"".$vwartpl->get(ifelse($gain == 0, "admin_db_optimizationbit_nogain", "admin_db_optimizationbit"))."\";");
		}
		$total_gain = round($total_gain,3);
		$total_used = round($total_used,3);

		eval("\$vwartpl->output(\"".$vwartpl->get("admin_db_optimizationreport")."\");");
		exit;
	}
	$vwartpl->cache("admin_db_optimize");
	eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
	eval("\$vwartpl->output(\"".$vwartpl->get("admin_db_optimize")."\");");
}
// #################################### import sql data ############################################
if ($GPC['action'] == "import")
{
	eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");

	if ($GPC['add'] || $GPC['add_x'])
	{
		 $backup = new backup(array("output_mode"=>"u","tables"=>$tables,"post_files"=>$HTTP_POST_FILES));
		 $backup->doRestore();

		 eval("\$vwartpl->output(\"".$vwartpl->get("admin_db_import_success")."\");");
		 exit;
	}
	$vwartpl->cache("admin_db_import");
	eval("\$vwartpl->output(\"".$vwartpl->get("admin_db_import")."\");");
}
// #################################### export sql data #############################################
if ($GPC['action'] == "export")
{
	if ($GPC['add'] || $GPC['add_x'])
	{
		 $backup = new backup(array("tables"=>$tables,"output_mode"=>"s"));
		 $backup->doBackup();
		 exit;
	}
	$vwartpl->cache("admin_db_export");
	eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
	eval("\$vwartpl->output(\"".$vwartpl->get("admin_db_export")."\");");
}
// #################################### backup timeframe config #############################################
if ($GPC['action'] == "abtimeframe")
{
	if ($GPC['add'] || $GPC['add_x'])
	{
		 $ab_days = "";
			 foreach($GPC["days"] as $number => $value)
		 {
				 if($value == "1") $ab_days .= $number;
			 }
			 $vwardb->query("UPDATE vwar".$n."_settings SET ab_days = '".$ab_days."'");
		}

	$_days = explode("|",chunk_split($ab_days,1,"|"));
	unset($_days[(sizeof($_days)-1)]);
		for($i = 0; $i < 7; $i++)
		{
				$value = in_array($i,$_days) ? 1 : 0;
				$days[$i] = makeyesnocode("days[$i]",$value);
		}
	eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
	eval("\$vwartpl->output(\"".$vwartpl->get("admin_autobackup_timeframe")."\");");
}
// #################################### backup user config #############################################
if ($GPC['action'] == "abaccess")
{
	if ($GPC['add'] || $GPC['add_x'])
	{
				require($vwar_root."includes/classes/class_htaccess.php");
				$ht = new htaccess($vwar_root."backup/.htpasswd");
				$ht->loadUser();
				foreach($GPC["member"] as $memberid => $value)
				{
					$excludes[] = $memberid;
					if($value == "1")
					{
							if(empty($ht->users[$memberid]))
							{
									$password = "";
									$password = createRandomPassword();
									$ht->addUser($memberid,$password);
									$mailpass[$memberid] = $password;
									$mailuser[] = $memberid;
							}
							$tmp[] = $memberid;
					}
					else if ($value == "0")
					{
						$ht->deleteUser($memberid);
					}
				}
				$ht->flushUsers($excludes);
				$ht->commitUserChanges();

				// send mail
				eval("\$text = \"".$vwartpl->get("admin_message_mail_backuppassword")."\";");
		$replacement = array(
		 "ownname" => $ownname, "ownnameshort" => $ownnameshort, "ownhomepage" => $ownhomepage,
		 "acpurl" => checkPath(checkUrlFormat($urltovwar))."admin/index.php",
		 "backupurl" => checkPath(checkUrlFormat($urltovwar))."backup/");

				if(!is_array($mailuser)) $mailuser = array();
				if(!is_array($tmp)) $tmp = array();
				foreach($mailuser as $memberid)
				{
						$replacement["password"] = $mailpass[$memberid];
						$replacement["name"] = $memberid;
						sendMemberMail("member",$text,array($memberid),$replacement,"text",$ownname." VWar: Password for Backup Folder","",1);
				}

				$vwardb->query("UPDATE vwar".$n."_settings SET ab_user = '".implode("|",$tmp)."'");
				$ab_user = implode("|",$tmp);
		}


		$vwartpl->cache("admin_email_memberlistbit,admin_autobackup_accessconfig");
		$result = $vwardb->query("
				SELECT DISTINCT
						memberid,name,hidemember
				FROM
						vwar".$n."_member m,vwar".$n."_accessgroup a
				WHERE
						canaccessbackup = '1' AND m.accessgroupid = a.accessgroupid");
		$usertmp = explode("|",$ab_user);
		while($row = $vwardb->fetch_array($result))
		{
				$member = makeyesnocode("member[".$row['memberid']."]",(in_array($row['memberid'],$usertmp) ? 1 : 0));
				$statusimg = $row['hidemember'] ? makeimgtag($vwar_root . "images/hidden.gif","Hidden Member") : "";

				dbSelect($row);
				switchColors();

				eval("\$selectcontent .= \"".$vwartpl->get("admin_email_memberlistbit")."\";");
	}

	eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
	eval("\$vwartpl->output(\"".$vwartpl->get("admin_autobackup_accessconfig")."\");");
}
?>