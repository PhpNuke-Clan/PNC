<?php
/* #####################################################################################
 *
 * $Id: class_template.php,v 1.7 2004/02/23 16:26:33 rob Exp $
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

class vwartpl {

	var $templates = array();
	var $tploutput = array();

	var $usual_tpl = array();

	/* CACHE TEMPLATES */
	function cache($vwartpllist)
	{
		global $vwardb,$n,$admintemplates,$vwarmod;

		// prepare templatelist, add usual templates if necessary:
		if ( count($this->usual_tpl) < 1 )
		{
			$this->usual_tpl = array (
				"timezone" => 0,
				"copyright" => 0,
				"header" => 0,
				"quickjump" => 0,
				"quickjump_bit" => 0,
				"buildup_report" => 0,
				"admin_header" => 1,
			);
			foreach ($this->usual_tpl AS $tpl => $mode)
			{
				if ( strpos($vwartpllist, $tpl) === false )
				{
					if ( $mode == 0 && $admintemplates != 1 )
					{
						$vwartpllist .= "," . $tpl;
					}
					else if ( $mode == 1 && $admintemplates == 1 )
					{
						$vwartpllist .= "," . $tpl;
					}
				}
			}
		}

		// build sql list
		$vwartpllist = str_replace(",", "','", $vwartpllist);

		// get templates from database and prepare them for output
		$result = $vwardb->query("
			SELECT templatename, template, isinactive
			FROM vwar".$n."_template
			WHERE templatename IN ('$vwartpllist')
		");
		while ($row = $vwardb->fetch_array($result))
		{
			if ($row["isinactive"] == 0)
			{
				$this->templates[$row["templatename"]] = str_replace("\"", "\\\"", $row["template"]);
			}
		}
	}

	/* GET TEMPLATE */
	function get($vwartplname,$nodevmode=0)
	{
		global $devmode, $timezone, $str, $vwarmod;

		$isinactive=0;
		if (!isset($this->templates[$vwartplname]))
		{
			global $vwardb, $n,$vwarmod;

			$result = $vwardb->query_first("SELECT template, isinactive FROM vwar".$n."_template WHERE templatename = '$vwartplname'");
			$this->templates[$vwartplname] = str_replace("\"","\\\"",$result["template"]);
			$isinactive = $result["isinactive"];
		}

		if ($isinactive == 0)
		{
			/** developer only... **/
			if ($devmode == 1 && $nodevmode == 0)
			{
				return "<!-- BEGIN TEMPLATE: $vwartplname -->".$this->templates[$vwartplname]."<!-- END TEMPLATE: $vwartplname -->";
			} else {
				return $this->templates[$vwartplname];
			}
		}
	}

	/* CHECK FOR OUTPUTTED TEMPLATES */
	function tploutput ($tplname)
	{
		if ( $this->tploutput[$tplname] == 1 )
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	/* PRINT TEMPLATE */
	function output($vwartpl,$admin=0)
	{
		global $vwartpladmin,$startrendertime,$query_count,$str,$showreport,$tploutput,$vwarmod;

		$this->tploutput[$vwartpl] = 1;

		if ($showreport == 1 && isset($startrendertime) && $vwartpladmin != 1)
		{
			//make buildup-report:
			$starttime = explode(" ", $startrendertime);
			$endtime = explode(" ", microtime());
			$time = round($endtime[0] - $starttime[0] + $endtime[1] - $starttime[1], 3);
			eval("\$buildupreport = \"".$this->get("buildup_report")."\";");
			$vwartpl=str_replace("{buildup-report}", $buildupreport, $vwartpl);
		}
		else if ($vwartpladmin != 1)
		{
			$vwartpl=str_replace("{buildup-report}","",$vwartpl);
		}

		if ($admin == 0 && $vwartpladmin != 1) $vwartpl = $this->replacevars($vwartpl);
		if ($admin == 1 || $vwartpladmin == 1) $vwartpl = str_replace("=\"images/","=\"../images/", $vwartpl);

		// spam protection!
		$vwartpl = encodeMail ($vwartpl);

		echo $vwartpl;
	}

	/* REPLACE VARS */
	function replacevars($vwartpl)
	{
		global $vwardb,$n,$replacecache,$vwarmod;

		if (!isset($replacecache))
		{
			$count = 0;
			$result = $vwardb->query("SELECT findword, replaceword FROM vwar".$n."_replacement");
			while ($row = $vwardb->fetch_array($result))
			{
				$replacecache[$count] = $row;
				$count++;
			}
			$vwardb->free_result($result);
		}
		for ($i = 0; $i < count($replacecache); $i++)
		{
			$vwartpl = str_replace($replacecache[$i]["findword"],$replacecache[$i]["replaceword"],$vwartpl);
			$vwartpl = str_replace("\n","",$vwartpl);
		}

		return $vwartpl;
	}

}
?>