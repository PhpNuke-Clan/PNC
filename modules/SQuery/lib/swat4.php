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
 * @////author Jeremias Reith (jr@terragate.net)////
 * @version $Id: ut2004.php,v 1.3 2004/06/04 15:18:38 jr Exp $
 *
 * Adds Swat4 Color code support
 */
class swat4 extends gameSpy
{

   /**
   * @brief htmlizes all color codes
   *
   * @param string a raw string
   * @return a html version of the given string
   */
  function htmlize($string) 
  {
  $span=0;
  $result="";
  for($i=0;$i<strlen($string);$i++)
  {
  
	if (ereg ("\[([cC])=([A-Za-z0-9]{6})\]", substr($string,$i,10), $regs)) {
                if($span>0)
                $result .="</span>";
	  	$result .="<span style=\"color: #".$regs[2].";\">";
                $span++;
                $i+=9;
	} else {
		$result.= substr($string,$i,1);
	}
  }
   if($span>0)
   $result .="</span>";
   return $result;
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
      if($temp[$i]!="queryid" && $temp[$i]!="final" && $temp[$i]!="password" && $temp[$i]!="gamevariant") {
        // MINE	
        $temp[$i]=strtolower($temp[$i]);
        $this->rules[$temp[$i]]=$temp[++$i]; 
      } else {
      if($temp[$i]=="gamevariant") {
      $this->gamename=$temp[++$i]; //Swat 4: UT engine then swat 4 is gamevariant
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
}

?>