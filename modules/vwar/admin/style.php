<?php
/* #####################################################################################
 *
 * $Id: style.php,v 1.32 2004/09/12 12:58:09 mabu Exp $
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

if (!checkCookie())
{
	header("Location: index.php");
}

// ################################### edit ############################################
if ($GPC['action'] == "edit")
{
	checkPermission("isadmin");

	if ($GPC['add'] || $GPC['add_x'])
	{
		while (list($colorname) = each($colornames))
		{
			$vwardb->query("
				UPDATE vwar".$n."_replacement
				SET
				replaceword = '".$colornames[$colorname]."'
				WHERE findword = '{".$colorname."}'
			");
		}

		$result = $vwardb->query("SELECT * FROM vwar".$n."_replacement WHERE findword like '%font%' AND replaceword NOT like '%/%'");
		while ($row = $vwardb->fetch_array($result))
		{
			$arr = ucfirst(ereg_replace("[\</\>\{\}]","", $row['findword']));

			dofonttag($$arr);

			$vwardb->query("
				UPDATE vwar".$n."_replacement
				SET
				replaceword = '".addslashes($fonttag)."'
				WHERE findword = '".$row['findword']."'
			");
		}
	}

	//template-cache, standard-templates will be added by script:
	$vwartpllist = "admin_style_editbit_font,admin_style_edit";
	$vwartpl->cache($vwartpllist);

	eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");

	$result = $vwardb->query("SELECT * FROM vwar".$n."_replacement WHERE findword like '%color%'");
	while ($row = $vwardb->fetch_array($result))
	{
		$row['findword'] = ereg_replace("[\</\>\{\}]","", $row['findword']);
		$colorsettings[$row['findword']] = $row['replaceword'];
	}

	$result = $vwardb->query("SELECT * FROM vwar".$n."_replacement WHERE findword like '%font%' AND replaceword NOT like '%/%'");
	while ($row = $vwardb->fetch_array($result))
	{
		switchColors();

		$row['findword']    = ereg_replace("[\</\>\{\}]","",$row['findword']);
		$row['findword']    = ucfirst($row['findword']);
		$row['replaceword'] = htmlspecialchars($row['replaceword']);

		splitfonttag($row['replaceword'], strtolower($row['findword']));

		eval("\$admin_style_editbit .= \"".$vwartpl->get("admin_style_editbit_font")."\";");
	}

	eval("\$vwartpl->output(\"".$vwartpl->get("admin_style_edit")."\");");
}

// ################################### export stylefile ################################
if ($GPC['action'] == "export")
{
	checkPermission("isadmin");

	@set_time_limit(600);

	if ($GPC['add'] || $GPC['add_x'])
	{
		// check for wrong data
		if ($exporttemplates == 0 && $exportfontscolors == 0)
		{
			$vwartpl->cache("admin_message_error_missingdata");
			eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
			eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_error_missingdata")."\");");
			exit;
		}

		$count = 1;

		unset($stylestring);

		$search = array('\n','\r','\t','\0');
		$replace = array('\\\n','\\\r','\\\t','\\\0');

		// export fonts & colors
		if ($exportfontscolors == 1)
		{
			$result = $vwardb->query("SELECT * FROM vwar".$n."_replacement");
			while ($row = $vwardb->fetch_array($result))
			{
				if (!empty($row['findword']) && !empty($row['replaceword']))
				{
					$stylestring .= $count . "~~~" . stripslashes($row['findword']) . "~~~"
								. str_replace($search,$replace,stripslashes($row['replaceword'])) . "~~~";

					$count++;
				}
			}
		}

		// export templates
		if ($exporttemplates == 1)
		{
			if ($exportfontscolors == 0) $stylestring .= "~~~";

			$result = $vwardb->query("SELECT * FROM vwar".$n."_template ORDER BY templatename ASC");
			while ($row = $vwardb->fetch_array($result))
			{
				if (!empty($row['templatename']) && !empty($row['template']))
				{
					$stylestring .= "~~~" . stripslashes($row['templatename']) . "~~~"
							. str_replace($search,$replace,stripslashes($row['template']));
				}
			}
		}

		// generate file name
		if ($stylefilename == "")
		{
			if ($exporttemplates == 1 && $exportfontscolors == 0)
			{
				$stylefilename = "vwar_templates.style";
			}
			else if ($exporttemplates == 0 && $exportfontscolors == 1)
			{
				$stylefilename = "vwar_fontscolors.style";
			}
			else
			{
				$stylefilename = "vwar_complete.style";
			}
		}

		getSendHeader($stylefilename);
		echo $stylestring;
	}
	else
	{
		$vwartpl->cache("admin_styleexport");

		eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");

		$exporttemplates = makeyesnocode("exporttemplates");
		$exportfontscolors = makeyesnocode("exportfontscolors");

		eval("\$vwartpl->output(\"".$vwartpl->get("admin_styleexport")."\");");
	}
}

// ################################### import stylefile ################################
if ($GPC['action'] == "import")
{
	checkPermission("isadmin");

	$stylefile = $HTTP_POST_FILES['stylefile']['tmp_name'];

	// set time limit to 10 mins.
	@set_time_limit(600);

	if ($GPC['add'] || $GPC['add_x'])
	{
		$uploadfile = getFileContent($stylefile);
		$style 			= explode("~~~~~~", $uploadfile);
		$replace 		= explode("~~~", $style[0]);

		for ($i = 0; $i < count($replace) / 3; $i++)
		{
			$result = $vwardb->query_first("
				SELECT COUNT(replacementid) AS replaces
				FROM vwar".$n."_replacement
				WHERE findword = '".addslashes($replace[$i*3+1])."'
			");
			$num = $result['replaces'];

			if ($num != 0)
			{
				if (addslashes($replace[$i*3+2]) != "")
				{
					$vwardb->query("
						UPDATE vwar".$n."_replacement
						SET
						replaceword = '".addslashes($replace[$i*3+2])."'
						WHERE findword = '".addslashes($replace[$i*3+1])."'
					");
				}
			}
			else
			{
				if (addslashes($replace[$i * 3 + 1]) != "" AND addslashes($replace[$i * 3 + 2]) != "")
				{
					$vwardb->query("
						INSERT INTO vwar".$n."_replacement
						(replacementid, findword, replaceword)
						VALUES (
						'".addslashes($replace[$i*3])."',
						'".addslashes($replace[$i*3+1])."',
						'".addslashes($replace[$i*3+2])."')
					");
				}
			}
		}

		if (!empty($style[1]))
		{
			$vwartpls = explode("~~~",$style[1]);

			for ($i = 0; $i < count($vwartpls) / 2;$i++)
			{
				$result = $vwardb->query_first("
					SELECT COUNT(templateid) AS templates
					FROM vwar".$n."_template
					WHERE templatename = '".addslashes($vwartpls[$i*2])."'
				");
				$num = $result['templates'];

				if ($num != 0)
				{
					$vwardb->query("
						UPDATE vwar".$n."_template
						SET template = '".addslashes($vwartpls[$i*2+1])."'
						WHERE templatename = '".addslashes($vwartpls[$i*2])."'
					");
				} else {
					$vwardb->query("
						INSERT INTO vwar".$n."_template
						VALUES (
						NULL,
						'".addslashes($vwartpls[$i*2])."',
						'".addslashes($vwartpls[$i*2+1])."',
						'0',
						'0')
					");
				}
			}
		}

		$vwartpl->cache("admin_styleimport_success");
		eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
		eval("\$vwartpl->output(\"".$vwartpl->get("admin_styleimport_success")."\");");
	}
	else
	{
		$vwartpl->cache("admin_styleimport");
		eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
		eval("\$vwartpl->output(\"".$vwartpl->get("admin_styleimport")."\");");
	}
}
?>