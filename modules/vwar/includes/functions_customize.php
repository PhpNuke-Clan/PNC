<?php
/* #####################################################################################
 *
 * $Id: functions_customize.php,v 1.9 2004/03/17 20:01:23 mabu Exp $
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

/*
 * ------------------------------------------------------------------------------------
 * includes/functions_customize.php
 * ------------------------------------------------------------------------------------
 * Customize Your VWar
 * Includes all function for adding quickjump and language data
 *
 */

## -------------------------------------------------------------------------------------------------------------- ##
function addLanguageVars ($file,$defaultlang="")
{
	global $vwarlanguage,$vwar_root,$vwardb,$n,$vwarmod;

	// init
	if (!@file_exists($file)) return FALSE;

	$dir = $vwar_root . "includes/language/";
	if (!is_writable($dir)) return FALSE;

	// open file and get content
	$source = @fopen($file,"rb");
	if (!$source) return FALSE;
	$langdata = fread($source, filesize($file));
	@fclose($source);

	// get settings from file
	$pattern["code"] = "/<languagecode=\"(.*)\">(.*)<\/languagecode>/isU";
	if (preg_match($pattern["code"],$langdata,$tmp))
	{
		$languagecode = strtoupper($tmp[1]);
		$languagename = $tmp[2];
		unset($tmp);
	}
	else
	{
		return FALSE;
	}

	$pattern["default"] = "/<default>(.*)<\/default>/isU";
	if (preg_match($pattern["default"],$langdata,$tmp))
	{
		$languagedefault = $tmp[1];
		unset($tmp);
	}
	else
	{
		return FALSE;
	}

	$pattern["type"] = "/<type>(.*)<\/type>/isU";
	if (preg_match($pattern["type"],$langdata,$tmp))
	{
		if (strtolower($tmp[1]) == "update")
		{
			$isupdate = TRUE;
		}

		unset($tmp);
	}

	// check language
	if (empty($defaultlang))
	{
		if (empty($vwarlanguage))
		{
			$tmp = $vwardb->query_first("SELECT vwarlanguage FROM vwar".$n."_settings");
			$vwarlanguage = $tmp["vwarlanguage"];

			unset($tmp);
		}
		$defaultlang = $vwarlanguage;
	}

	$pattern["language_check"] = "/<language=\"".$defaultlang."\">(?:.*)<\/language>/isU";
	if (!preg_match($pattern["language_check"],$langdata,$tmp))
	{
		$defaultlang = $languagedefault;
	}
	unset($tmp);

	// get default language data
	$pattern["language_default"] = "/<language=\"{$defaultlang}\">(.*)<\/language>/isU";
	if (!preg_match($pattern["language_default"],$langdata,$defaultdata))
	{
		return FALSE;
	}

	// open all language files
	$pattern["custom"] = "/## ---- START CUSTOM PART ---- ##(.*)## ---- END CUSTOM PART ---- ##/isU";
	$pattern["part"] = "/## ---- START \"".$languagecode."\" ---- ##(?:.*)## ---- END \"".$languagecode."\" ---- ##/isU";

	$dirhandle = dir($dir);
	while ($currentfile = $dirhandle->read())
	{
		$filename = $dir.$currentfile;

		if (is_dir($filename) || !is_writable($filename))
		{
			continue;
		}

		// open file and get content
		$current = @fopen($filename,"rb");
		if (!$current)
		{
			continue;
		}

		$content = fread($current,filesize($filename));
		@fclose($current);

		if (!preg_match($pattern["custom"],$content,$customdata))
		{
			continue;
		}

		// get first part of filename
		$language = strtolower(substr($currentfile,0,strpos($currentfile,".")));

		// get language data
		$pattern["language"] = "/<language=\"{$language}\">(.*)<\/language>/isU";
		if (!preg_match($pattern["language"],$langdata,$currentdata))
		{
			$currentdata = $defaultdata;
		}

		// main
		$pattern["data"] = "/<data name=\"(.*)\">(.*)<\/data>/isU";
		if ($isupdate)
		{
			// get the first available part. skip if not found.
			// language files without the needed part will be skipped too.
			// files with more than one part are erroneous!
			$pattern["update"] = "/## ---- START \"".$languagecode."\" ---- ##(.*)## ---- END \"".$languagecode."\" ---- ##/isU";
			if (!preg_match($pattern["update"],$customdata[1],$usedata))
			{
				continue;
			}

			// delete all parts
			$customdata[1] = preg_replace($pattern["update"],"",$customdata[1]);

			// now add or update the language vars
			preg_match_all($pattern["data"],$currentdata[1],$data_matches);
			for ($data = 0; $data < sizeof($data_matches[0]); $data++)
			{
				// match the line
				$pattern["str"] = '/\$str\["'.$data_matches[1][$data].'"\] = "(.*)";/isU';
				if (preg_match($pattern["str"],$usedata[1],$updatematch))
				{
					if (empty($data_matches[2][$data]))
					{
						$usedata[1] = str_replace($updatematch[0],"",$usedata[1]);
					}
					else
					{
						$replace = '$str["'.$data_matches[1][$data].'"] = "'.addslashes($data_matches[2][$data]).'";';
						$usedata[1] = str_replace($updatematch[0],$replace,$usedata[1]);

						unset($replace);
					}
					unset($updatematch);
				}
				else
				{
					$usedata[1] .= '$str["'.$data_matches[1][$data].'"] = "'.addslashes($data_matches[2][$data]).'";'."\r\n";
				}
			}

			// optimize
			optimizeContent($usedata[1],1);

			// add additional information
			$usedata[1]  = "## ---- START \"".$languagecode."\" ---- ##\r\n".trim($usedata[1]);
			$usedata[1] .= "\r\n## ---- END \"".$languagecode."\" ---- ##\r\n";
			$customdata[1]  = "## ---- START CUSTOM PART ---- ##".((trim($customdata[1]) == "") ? "\r\n" : "\r\n".trim($customdata[1])."\r\n");
			$customdata[1] .= $usedata[1]."## ---- END CUSTOM PART ---- ##";

			// replace old with new
			$content = str_replace($customdata[0],$customdata[1],$content);
		}
		else
		{
			// add new data and replace old
			if (preg_match($pattern["part"],$customdata[1],$tmp2))
			{
				$customdata[1] = preg_replace($pattern["part"],NULL,$customdata[1]);
				unset($tmp2);
			}

			$tmp  = "## ---- START CUSTOM PART ---- ##";
			$tmp .= (trim($customdata[1]) == "") ? "\r\n" : "\r\n".trim($customdata[1])."\r\n";
			$tmp .= "## ---- START \"".$languagecode."\" ---- ##\r\n";

			preg_match_all($pattern["data"],$currentdata[1],$data_matches);
			for ($data = 0; $data < sizeof($data_matches[0]); $data++)
			{
				if (!empty($data_matches[2][$data]))
				{
					$tmp .= '$str["'.$data_matches[1][$data].'"] = "'.addslashes($data_matches[2][$data]).'";'."\r\n";
				}
			}

			$tmp .= "## ---- END \"".$languagecode."\" ---- ##\r\n";
			$tmp .= "## ---- END CUSTOM PART ---- ##";
			$content = str_replace($customdata[0],$tmp,$content);
		}

		// write new content to file
		$current = @fopen($filename,"wb");
		if ($current)
		{
			// optimize and write
			optimizeContent($content);
			fwrite($current,$content,strlen($content));

			$set = TRUE;
		}
		@fclose($current);

		unset($usedata);
		unset($customdata);
		unset($data_matches);
		unset($content);
		unset($tmp);
		unset($data);
		unset($filename);
	}

	// add language to database
	if ($set && !$isupdate)
	{
		$result = $vwardb->query("SELECT languagename FROM vwar".$n."_customlanguage WHERE languagename = '".$languagecode."'");
		if ($vwardb->num_rows($result) == 0)
		{
			$vwardb->query("
				INSERT INTO vwar".$n."_customlanguage (languagename, languagetitle)
				VALUES ('".$languagecode."','".$languagename."')");
		}
	}

	return ($set == TRUE) ? TRUE : FALSE;
}
## -------------------------------------------------------------------------------------------------------------- ##
function deleteLanguageVars ($id,$sqldelete=1)
{
	global $vwar_root,$n,$vwardb,$vwarmod;

	if (empty($id))
	{
		return;
	}

	// get language name
	$data = $vwardb->query_first("
		SELECT UCASE(languagename) AS languagename
		FROM vwar".$n."_customlanguage
		WHERE languageid = '".$id."'
	");

	// define pattern
	$pattern["part"] = '/## ---- START "'.$data["languagename"].'" ---- ##(.*)## ---- END "'.$data["languagename"].'" ---- ##/isU';
	unset($data);

	// open each language file and remove the selected language part
	$dir = "./../includes/language/";
	$handle = dir($dir);
	while ($file = $handle->read())
	{
		$filename = $dir.$file;

		if (!is_dir($filename))
		{
			$content = trim(fileReader($filename,1));
			$content = preg_replace($pattern["part"],"",$content);

			// optimize
			optimizeContent($content);

			$fp = @fopen($filename,"wb");
			if (!$fp)
			{
				return FALSE;
			}

			fwrite($fp,$content,strlen($content));
			@fclose($fp);

			unset($content);
		}
	}
	$handle->close();

	if ((int)$sqldelete == 1)
	{
		$vwardb->query("DELETE FROM vwar".$n."_customlanguage WHERE languageid = '".$id."'");
	}
}
## -------------------------------------------------------------------------------------------------------------- ##
function optimizeContent (&$content,$internal=0)
{
	if ($internal == 0)
	{
		// normal mode
		$pattern["one"] = "/## ---- START CUSTOM PART ---- ##(.*)## ---- END CUSTOM PART ---- ##/isU";
		$pattern["two"] = '/## ---- START "(?:.*)" ---- ##(?:.*)## ---- END "(?:.*)" ---- ##/isU';

		if (!preg_match($pattern["one"],$content,$match))
		{
			return;
		}
		$tmp = "## ---- START CUSTOM PART ---- ##\r\n";
	}
	elseif ($internal == 1)
	{
		// internal mode
		$pattern["two"] = '/\$str\["(?:.*)"\] = "(?:.*)";/isU';

		if (!preg_match($pattern["two"],$content,$match))
		{
			return;
		}
		unset($match);

		$match[1] = $content;
	}
	else
	{
		// invalid mode, return
		return;
	}

	// optimize content as best as possible
	preg_match_all($pattern["two"],$match[1],$matches);
	for ($data = 0; $data < sizeof($matches[0]); $data++)
	{
		$tmp .= trim($matches[0][$data])."\r\n";
	}

	// add additional information
	if ($internal == 0)
	{
		$tmp .= "## ---- END CUSTOM PART ---- ##";
		$content = str_replace($match[0],$tmp,$content);
	}
	else if ($internal == 1)
	{
		$content = $tmp;
	}
}
## -------------------------------------------------------------------------------------------------------------- ##
function addQuickJump ($title,$url,$displayorder,$active=1)
{
	global $n,$vwardb,$vwarmod;

	if (empty($title) || empty($url) || empty($active))
	{
		return FALSE;
	}

	// add entry
	if (empty($displayorder) || !is_numeric($displayorder))
	{
		$result = $vwardb->query_first("
			SELECT displayorder
			FROM vwar".$n."_quickjump
			ORDER BY displayorder DESC LIMIT 0,1
		");
		$displayorder = $result["displayorder"] + 1;
		unset($result);
	}

	$result = $vwardb->query("SELECT title FROM vwar".$n."_quickjump WHERE title = '".$title."'");
	if ($vwardb->num_rows($result) == 0)
	{
		$vwardb->query("
			INSERT INTO vwar".$n."_quickjump (title,redirectto,displayorder,activated)
			VALUES ('".$title."','".$url."','".$displayorder."','".$active."')");
	}

	return TRUE;
}
## -------------------------------------------------------------------------------------------------------------- ##
function deleteQuickJump ($id)
{
	global $n,$vwardb,$vwarmod;

	if (empty($id))
	{
		return FALSE;
	}

	// delete entry
	$vwardb->query("DELETE FROM vwar".$n."_quickjump WHERE quickjumpid = '".$id."'");

	return TRUE;
}
## -------------------------------------------------------------------------------------------------------------- ##
function checkLanguageFiles ($dir)
{
	$dirhandle = dir($dir);
	while ($currentfile = $dirhandle->read())
	{
		$filename = $dir.$currentfile;
		if (is_dir($filename))
		{
			continue;
		}

		// get first 20 bytes
		$fp = @fopen($filename,"rb");
		if (!$fp)
		{
			continue;
		}
		$content = @fread($fp,20);

		// check for vwar string
		if (strpos($content,"vwar") === FALSE)
		{
			continue;
		}
		else
		{
			if (is_writable($filename))
			{
				return TRUE;
			}
		}
		@fclose($fp);
	}
	$dirhandle->close();

	return FALSE;
}
?>