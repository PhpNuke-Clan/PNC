<?php
/*
 *  gsQuery - Querys game servers
 *  Copyright (c) 2002-2004 Jeremias Reith <jr@terragate.net>
 *  http://gsquery.terragate.net
 *
 *  This file is part of the gsQuery library.
 *
 *  The gsQuery library is free software; you can redistribute it and/or
 *  modify it under the terms of the GNU Lesser General Public
 *  License as published by the Free Software Foundation; either
 *  version 2.1 of the License, or (at your option) any later version.
 *
 *  The gsQuery library is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 *  Lesser General Public License for more details.
 *
 *  You should have received a copy of the GNU Lesser General Public
 *  License along with the gsQuery library; if not, write to the
 *  Free Software Foundation, Inc.,
 *  59 Temple Place, Suite 330, Boston,
 *  MA  02111-1307  USA
 *
 */
//start check
if (isset($_GET['libpath']) || isset($_POST['libpath'])) {
    //tampering detected
    exit("Variable Override Detected");
}
//end check
include_once($libpath."gameSpy.php");

/**
 * @brief Uses the gameSpy protocol
 * @author Jeremias Reith (jr@terragate.net)
 * @version $Id: ut2004.php,v 1.3 2004/06/04 15:18:38 jr Exp $
 *
 * Adds UT2004 Color code support
 */
class fear extends gameSpy
{

   /**
   * @brief htmlizes all color codes
   *
   * @param string a raw string
   * @return a html version of the given string
   */
  function htmlize($string) 
  {

    return $string;
  }

  function _getClassName() 
  {
    return get_class($this);
  }
  function _processRules($rawData)
  {
    $temp=explode("\\",$rawData);
    $count=count($temp);
    for($i=1;$i<$count;$i++) { 

      if($temp[$i]!="queryid" && $temp[$i]!="final" && $temp[$i]!="password" && $temp[$i]!="gsgamename" && $temp[$i]!="options") {
// MINE	
$temp[$i]=strtolower($temp[$i]);
$this->rules[$temp[$i]]=$temp[++$i]; 
      } else {
        if($temp[$i]=="gsgamename") {
                $this->gamename=$temp[++$i];
        }
        if($temp[$i]=="options") 
        {
                $temp2 =str_replace(")(",":",$temp[++$i]);
                $temp2 =str_replace("(","",$temp2);
                $temp2 =str_replace(")","",$temp2);
                $tab = explode(";",$temp2);
                for($j=0;$j<count($tab);$j++)
                {
                        $tab2 = explode(":",$tab[$j]);
                        $this->rules[$tab2[0]]=$tab2[1];
                }
        }
	if($temp[$i]=="password") {

	  switch(strtolower($temp[++$i]))
	  {
		case "true":
		$this->password=1;
		break;
		case "false":
		$this->password=0;
		break;
		case "1":
		$this->password=1;
		break;
		case "0":
		$this->password=0;
		break;
		default:
	  }	
	  	  
	}
      }
    } 

    return TRUE;
  }
function docvars($gameserver)
{
$retval="<table cellspacing=0 cellpadding=0 width=\"100%\">"
  . "		<tr>"
  . "		<td class=\"row\">"
  . "		<table cellspacing=0 cellpadding=0>"
  . "		<tr><td style=\"padding-right: 5px;\">".checkmark()." <font class=\"color\">Dedicated:</font></td><td>".($gameserver ->rules["dedicated"] == 1 ? "Yes" : "No")."</td></tr>"
  . "		<tr><td style=\"padding-right: 5px;\">".checkmark()." <font class=\"color\">Linux:</font></td><td>".($gameserver ->rules["linux"] == 1 ? "Yes" : "No")."</td></tr>"
  . "		<tr><td style=\"padding-right: 5px;\">".checkmark()." <font class=\"color\">FriendlyFire:</font></td><td>".($gameserver ->rules["FriendlyFire"] == 1 ? "Yes" : "No")."</td></tr>"
  . "		<tr><td style=\"padding-right: 5px;\">".checkmark()." <font class=\"color\">Weapon Restrictions:</font></td><td>".($gameserver ->rules["UseWeaponRestrictions"] == 1 ? "Yes" : "No")."</td></tr>"
  . "		<tr><td style=\"padding-right: 5px;\">".checkmark()." <font class=\"color\">Punkbuster:</font></td><td>".($gameserver ->rules["punkbuster"] == 1 ? "Yes" : "No")."</td></tr>"

  . "		</table>"
  . "		</td>"
  . "		<td class=\"row\">"
  . "		<table cellspacing=0 cellpadding=0>"
  . "		<tr><td style=\"padding-right: 5px;\">".checkmark()." <font class=\"color\">Fraglimit:</font></td><td>".(isset($gameserver->rules["fraglimit"])? $gameserver->rules["fraglimit"] : "0")."</td></tr>"
  . "		<tr><td style=\"padding-right: 5px;\">".checkmark()." <font class=\"color\">Timelimit:</font></td><td>".(isset($gameserver->rules["timelimit"])? $gameserver->rules["timelimit"] : "0")."</td></tr>"
  . "		<tr><td style=\"padding-right: 5px;\">".checkmark()." <font class=\"color\">Reflect Damage:</font></td><td>".(isset($gameserver->rules["TeamReflectDamage"]) ? $gameserver->rules["TeamReflectDamage"] : "0")."</td></tr>"
  . "		<tr><td style=\"padding-right: 5px;\">".checkmark()." <font class=\"color\">Number Rounds:</font></td><td>".(isset($gameserver->rules["NumRounds"])? $gameserver->rules["NumRounds"] : "0")."</td></tr>"
  . "		<tr><td style=\"padding-right: 5px;\"><br></td></tr>"
  . "		</table>"
  . "		</td>"
  . "		</tr>"
  . "		</table>";
return $retval;
}
}
?>