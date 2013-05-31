<?php
//start check
if (isset($_GET['libpath']) || isset($_POST['libpath'])) {
    //tampering detected
    exit("Variable Override Detected");
}
//end check

if (strstr($libpath, '..'))
    $libpath = str_replace('..', '', $libpath);

  if (strstr($libpath, '@'))
    $libpath = str_replace('@', '', $libpath);

  if (strstr($libpath, ':'))
    $libpath = str_replace(':', '', $libpath);

  if (isset($libpath) &&
     file_exists($libpath) &&
     !isset($HTTP_GET_VARS['libpath']) &&
     !isset($HTTP_POST_VARS['libpath']) &&
     !isset($HTTP_COOKIE_VARS['libpath']) &&
     !isset($HTTP_SESSION_VARS['libpath']) &&
     !isset($HTTP_POST_FILES['libpath']) &&
     !isset($HTTP_ENV_VARS['libpath']))
	 {
		include_once($libpath."gameSpy.php");
	 }


class hlife2 extends gsQuery
{
function query_server($getPlayers=TRUE,$getRules=TRUE)
{      
	$this->playerkeys=array();
	$this->debug=array();
	$this->password=-1;

	// get Challenge string
	$command="\xFF\xFF\xFF\xFFW";
	if(!($result=$this->_sendCommand($this->address,$this->queryport,$command)))
	{
		return FALSE;
	}

	$i=4;// start after header
	$check_byte=ord($result[$i++]);

	if ($check_byte!=65)
	{
		echo "Bad Byte!";
		return FALSE;
	}

	// store challenge value
	$challenge=substr($result,$i++,4);
	
    $command="\xFF\xFF\xFF\xFFTSource Engine Query";
    if(!($result=$this->_sendCommand($this->address,$this->queryport,$command)))
	{
		return FALSE;
    }

	$i=4;// start after header
	
	//Source - byte - Should be equal to 'I' (0x49)
	if(substr($result,4,1) == 'I')
	{
		$this->check=substr($result,$i++,1);
		$this->rules["network"]=ord($result[$i++]);
		$this->gameversion="";
		$this->hostport.=$this->queryport;
		$this->servertitle="";
		$this->mapname="";
		$this->rules["gamedir"]="";
		$this->gametype="";

		while ($result[$i]!="\x00") $this->servertitle.=$result[$i++];
    
		$i++;

		while ($result[$i]!="\x00") $this->mapname.=$result[$i++];
    
		$i++;

		while ($result[$i]!="\x00") $this->rules["gamedir"].=$result[$i++];
    
		$i++;

    	while ($result[$i]!="\x00") $this->gametype.=$result[$i++];

		if ($this->rules["gamedir"]=="cstrike") $this->gamename="cs-source";
		else if ($this->rules["gamedir"]=="dod") $this->gamename="dod-source";
		else if ($this->rules["gamedir"]=="hl2mp") $this->gamename="hl2mp";
		else $this->gamename="Uknown";

		$i++;
		$this->rules["steamid"]=ord($result{$i}) | (ord($result{$i+1})<<8);
		$i+=2;
		$this->numplayers=ord(substr($result,$i++,1));
		$this->maxplayers=ord(substr($result,$i++,1));
		$this->rules["botplayers"]=ord(substr($result,$i++,1));
		$this->rules["dedicated"]=($result[$i++]);
		$this->rules["server_os"]=($result[$i++]);
		$this->password=ord(substr($result,$i++,1));
		$this->rules["secure"]=($result[$i++]);

		while ($result[$i]!="\x00") $this->gameversion.=$result[$i++];
	}
	
	//HL1 - byte - Should be equal to 'm' (0x6D)
	elseif(substr($result,4,1) == 'm')
	{
		$this->check=substr($result,$i++,1);
		$this->rules["network"]=ord($result[$i++]);
		$this->gameversion="";
		$this->hostport.=$this->queryport;
		$this->servertitle="";
		$this->mapname="";
		$this->rules["gamedir"]="";
		$this->gametype="";

		while ($result[$i]!="\x00") $this->junk.=$result[$i++];
		$i++;
		while ($result[$i]!="\x00") $this->servertitle.=$result[$i++];
    
		$i++;

		while ($result[$i]!="\x00") $this->mapname.=$result[$i++];
    
		$i++;

		while ($result[$i]!="\x00") $this->rules["gamedir"].=$result[$i++];
    
		$i++;

    	while ($result[$i]!="\x00") $this->gametype.=$result[$i++];

		//Set Mod/Gamename
		$this->gamename = $this->rules["gamedir"];
				
		$i++;
		//$this->rules["steamid"]=ord($result{$i}) | (ord($result{$i+1})<<8);
		//$i+=2;
		$this->numplayers=ord(substr($result,$i++,1));
		$this->maxplayers=ord(substr($result,$i++,1));
		$this->rules["botplayers"]=ord(substr($result,$i++,1));
		$this->rules["dedicated"]=($result[$i++]);
		$this->rules["server_os"]=($result[$i++]);
		$this->password=ord(substr($result,$i++,1));
		$this->rules["secure"]=($result[$i++]);

		while ($result[$i]!="\x00") $this->gameversion.=$result[$i++];
	}
	
	
	
	
	
	
	// do rules
    $command="\xFF\xFF\xFF\xFFV".$challenge;

    if(!($result=$this->_sendCommand($this->address,$this->queryport,$command)))
	{
		return FALSE;
    }

	$exploded_data = explode("\x00", $result);
	$z=count($exploded_data);

    for($i=1;$i<$z;$i++)
	{
		switch($exploded_data[$i++])
		{
			case 'deathmatch':
				if ($exploded_data[$i]=='1') $this->gametype='Deathmatch';
			break;

			case 'coop':
				if ($exploded_data[$i]=='1') $this->gametype='Cooperative';
			break;

			default:
				if(isset($exploded_data[$i-1]) && isset($exploded_data[$i]))
				{
					$this->rules[strtolower($exploded_data[$i-1])]=$exploded_data[$i];
				}
		}
    }

	if($getPlayers)
	{
		// do players
		$command="\xFF\xFF\xFF\xFFU".$challenge;

		if(!($result=$this->_sendCommand($this->address,$this->queryport,$command)))
		{
			return FALSE;
		}
		
		$j=7;
		$listedplayers=ord($result{5});// this number is not always accurate???
		$l=strlen($result);

		for ($i=0;$i<$listedplayers;$i++)
		{
			if ($j>=$l) break;
		
			while ($result[$j]!="\x00") $players[$i]["name"].=$result[$j++];

			$j++;

			$t= ord($result{$j}) | (ord($result{$j+1})<<8) | (ord($result{$j+2})<<16) | (ord($result{$j+3})<<24); 

			$players[$i]["score"]=$t;

			if($players[$i]["score"]>128)
			{
				$players[$i]["score"]-=256;
			}

			$j+=4;
			$t= unpack("ftime", substr($result, $j, 4));
			$t= mktime(0, 0, $t['time']);
			$players[$i]["time"] = date("H:i:s", $t);
			$j+=5;
			$this->playerkeys["name"]=TRUE;
			$this->playerkeys["score"]=TRUE;
			$this->playerkeys["time"]=TRUE;
		}
	}

    $this->players=$players;
    $this->online = TRUE;
    return TRUE; 
}

  /*
   * @brief Sends a rcon command to the game server
   * 
   * @param command the command to send
   * @param rcon_pwd rcon password to authenticate with
   * @return the result of the command or FALSE on failure
   */
 /*
  function rcon_query_server($command, $rcon_pwd) 
  {
	$get_challenge="\xFF\xFF\xFF\xFFchallenge rcon\n";
	
	if(!($challenge_rcon=$this->_sendCommand($this->address,$this->queryport,$get_challenge)))
	{
		$this->debug["Command send " . $command]="No challenge rcon received";
		return FALSE;
	}

	if (!ereg('challenge rcon ([0-9]+)', $challenge_rcon))
	{
		$this->debug["Command send " . $command]="No valid challenge rcon received";
		return FALSE;
	}

	$challenge_rcon=substr($challenge_rcon, 19,10);
	$command="\xFF\xFF\xFF\xFFrcon \"".$challenge_rcon."\" ".$rcon_psw." ".$command."\n";

	if(!($result=$this->_sendCommand($this->address,$this->queryport,$command))) 
	{
		$this->debug["Command send " . $command]="No reply received";
		return FALSE;
	}
	else
	{
		return substr($result, 5);
	}
  }
 */


/* this is for game specific cvar displays  */
function docvars($gameserver)
{
	switch ($gameserver->gamename)
	{
	case "cs-source":
	case "dod-source":
	case "cs-source":
	$retval="<table cellspacing=0 cellpadding=0 width=\"100%\">"
		."<tr>"
		."<td class=\"row\">"
		."<table cellspacing=0 cellpadding=0>"
		//."<tr><td style=\"padding-right: 5px;\">".checkmark()." <font class=\"color\">Check:</font></td><td>".$gameserver ->check."</td></tr>"
		//."<tr><td style=\"padding-right: 5px;\">".checkmark()." <font class=\"color\">Check:</font></td><td>".$this->rules["gamedir"]."</td></tr>"
		."<tr><td style=\"padding-right: 5px;\">".checkmark()." <font class=\"color\">TeamPlay:</font></td><td>".($gameserver ->rules["mp_teamplay"] == 1 ? "Yes" : "No")."</td></tr>"
		."<tr><td style=\"padding-right: 5px;\">".checkmark()." <font class=\"color\">Frag Limit:</font></td><td>".($gameserver ->rules["mp_fraglimit"] == 1 ? "Yes" : "No")."</td></tr>"
		."<tr><td style=\"padding-right: 5px;\">".checkmark()." <font class=\"color\">Time Limit:</font></td><td>".($gameserver ->rules["mp_timelimit"] == 1 ? "Yes" : "No")."</td></tr>"
		."<tr><td style=\"padding-right: 5px;\">".checkmark()." <font class=\"color\">Friendly Fire:</font></td><td>".($gameserver ->rules["mp_friendlyfire"] == 1 ? "Yes" : "No")."</td></tr>"
		."<tr><td style=\"padding-right: 5px;\">".checkmark()." <font class=\"color\">Flashlight:</font></td><td>".($gameserver ->rules["mp_flashlight"] == 1 ? "Yes" : "No")."</td></tr>"
		."<tr><td style=\"padding-right: 5px;\">".checkmark()." <font class=\"color\">Footsteps:</font></td><td>".($gameserver ->rules["mp_footsteps"] == 1 ? "Yes" : "No")."</td></tr>"
		."<tr><td style=\"padding-right: 5px;\">".checkmark()." <font class=\"color\">Dedicated:</font></td><td>".($gameserver ->rules["dedicated"] == "d" ? "Yes" : "No")."</td></tr>"
		."</table>"
		."</td>"
		."<td class=\"row\">"
		."<table cellspacing=0 cellpadding=0>"
		."<tr><td style=\"padding-right: 5px;\">".checkmark()." <font class=\"color\">Fall Damage:</font></td><td>".($gameserver ->rules["mp_falldamage"] == 1 ? "Yes" : "No")."</td></tr>"
		."<tr><td style=\"padding-right: 5px;\">".checkmark()." <font class=\"color\">Weapons Stay:</font></td><td>".($gameserver ->rules["mp_weaponstay"] == 1 ? "Yes" : "No")."</td></tr>"
		."<tr><td style=\"padding-right: 5px;\">".checkmark()." <font class=\"color\">Force Respawn:</font></td><td>".($gameserver ->rules["mp_forcerespawn"] == 1 ? "Yes" : "No")."</td></tr>"
		."<tr><td style=\"padding-right: 5px;\">".checkmark()." <font class=\"color\">Auto Crosshair:</font></td><td>".($gameserver ->rules["mp_autocrosshair"] == 1 ? "Yes" : "No")."</td></tr>"
		."<tr><td style=\"padding-right: 5px;\">".checkmark()." <font class=\"color\">Allow NPCs:</font></td><td>".($gameserver ->rules["mp_allownpcs"] == 1 ? "Yes" : "No")."</td></tr>"
		."<tr><td style=\"padding-right: 5px;\">".checkmark()." <font class=\"color\">BotPlayers:</font></td><td>".$gameserver ->rules["botplayers"]."</td></tr>"
		."<tr><td style=\"padding-right: 5px;\">".checkmark()." <font class=\"color\">Server OS:</font></td><td>".($gameserver ->rules["server_os"] == "w" ? "Windows" : "Linux")."</td></tr>"
		."</table>"
		."</td>"
		."</tr>"
		."</table>";
	break;
	case "gearbox":
	$retval="<table cellspacing=0 cellpadding=0 width=\"100%\">"
		."<tr>"
		."<td class=\"row\">"
		."<table cellspacing=0 cellpadding=0>"
		."<tr><td style=\"padding-right: 5px;\">".checkmark()." <font class=\"color\">Allow Spectators:</font></td><td>".($gameserver ->rules["allow_spectators"] == 1 ? "Yes" : "No")."</td></tr>"
		."<tr><td style=\"padding-right: 5px;\">".checkmark()." <font class=\"color\">Frag Limit:</font></td><td>".($gameserver ->rules["mp_fraglimit"] == 1 ? "Yes" : "No")."</td></tr>"
		."<tr><td style=\"padding-right: 5px;\">".checkmark()." <font class=\"color\">Frags Left:</font></td><td>".($gameserver ->rules["mp_fragsleft"] == 1 ? "Yes" : "No")."</td></tr>"
		."<tr><td style=\"padding-right: 5px;\">".checkmark()." <font class=\"color\">Allow Spectate:</font></td><td>".($gameserver ->rules["allow_spectators"] == 1 ? "Yes" : "No")."</td></tr>"
		."<tr><td style=\"padding-right: 5px;\">".checkmark()." <font class=\"color\">Flashlight:</font></td><td>".($gameserver ->rules["mp_flashlight"] == 1 ? "Yes" : "No")."</td></tr>"
		."<tr><td style=\"padding-right: 5px;\">".checkmark()." <font class=\"color\">Footsteps:</font></td><td>".($gameserver ->rules["mp_footsteps"] == 1 ? "Yes" : "No")."</td></tr>"
		."</table>"
		."</td>"
		."<td class=\"row\">"
		."<table cellspacing=0 cellpadding=0>"
		."<tr><td style=\"padding-right: 5px;\">".checkmark()." <font class=\"color\">Friendly Fire:</font></td><td>".($gameserver ->rules["mp_friendlyfire"] == 1 ? "Yes" : "No")."</td></tr>"
		."<tr><td style=\"padding-right: 5px;\">".checkmark()." <font class=\"color\">Reserve Slots:</font></td><td>".$gameserver ->rules["reserve_slots"]."</td></tr>"
		."<tr><td style=\"padding-right: 5px;\">".checkmark()." <font class=\"color\">Min Rate:</font></td><td>".spBytes($gameserver ->rules["sv_minrate"])."</td></tr>"
		."<tr><td style=\"padding-right: 5px;\">".checkmark()." <font class=\"color\">Max Rate:</font></td><td>".spBytes($gameserver ->rules["sv_maxrate"])."</td></tr>"
		."<tr><td style=\"padding-right: 5px;\">".checkmark()." <font class=\"color\">Time Limit:</font></td><td>".$gameserver ->rules["mp_timelimit"]."</td></tr>"
		."<tr><td style=\"padding-right: 5px;\">".checkmark()." <font class=\"color\">Time Left:</font></td><td>".nduration($gameserver ->rules["mp_timeleft"])."</td></tr>"
		."</table>"
		."</td>"
		."</tr>"
		."</table>";
	break;
	case "cstrike":
	case "czero":
	$retval="<table cellspacing=0 cellpadding=0 width=\"100%\">"
		."<tr>"
		."<td class=\"row\">"
		."<table cellspacing=0 cellpadding=0>"
		."<tr><td style=\"padding-right: 5px;\">".checkmark()." <font class=\"color\">Allow Spectators:</font></td><td>".$gameserver ->rules["allow_spectators"]."</td></tr>"
		."<tr><td style=\"padding-right: 5px;\">".checkmark()." <font class=\"color\">Auto Kick:</font></td><td>".$gameserver ->rules["mp_autokick"]."</td></tr>"
		."<tr><td style=\"padding-right: 5px;\">".checkmark()." <font class=\"color\">Team Balance:</font></td><td>".$gameserver ->rules["mp_autoteambalance"]."</td></tr>"
		."<tr><td style=\"padding-right: 5px;\">".checkmark()." <font class=\"color\">C4 Timer:</font></td><td>".$gameserver ->rules["mp_c4timer"]."</td></tr>"
		."<tr><td style=\"padding-right: 5px;\">".checkmark()." <font class=\"color\">Flashlight:</font></td><td>".$gameserver ->rules["mp_flashlight"]."</td></tr>"
		."<tr><td style=\"padding-right: 5px;\">".checkmark()." <font class=\"color\">Footsteps:</font></td><td>".$gameserver ->rules["mp_footsteps"]."</td></tr>"
		."</table>"
		."</td>"
		."<td class=\"row\">"
		."<table cellspacing=0 cellpadding=0>"
		."<tr><td style=\"padding-right: 5px;\">".checkmark()." <font class=\"color\">Friendly Fire:</font></td><td>".$gameserver ->rules["mp_friendlyfire"]."</td></tr>"
		."<tr><td style=\"padding-right: 5px;\">".checkmark()." <font class=\"color\">Hostage Penalty:</font></td><td>".$gameserver ->rules["mp_hostagepenalty"]."</td></tr>"
		."<tr><td style=\"padding-right: 5px;\">".checkmark()." <font class=\"color\">Reserve Slots:</font></td><td>".$gameserver ->rules["reserve_slots"]."</td></tr>"
		."<tr><td style=\"padding-right: 5px;\">".checkmark()." <font class=\"color\">Min Rate:</font></td><td>".spBytes($gameserver ->rules["sv_minrate"])."</td></tr>"
		."<tr><td style=\"padding-right: 5px;\">".checkmark()." <font class=\"color\">Max Rate:</font></td><td>".spBytes($gameserver ->rules["sv_maxrate"])."</td></tr>"
		."<tr><td style=\"padding-right: 5px;\">".checkmark()." <font class=\"color\">Time Limit:</font></td><td>".$gameserver ->rules["mp_timelimit"]."</td></tr>"
		."</table>"
		."</td>"
		."</tr>"
		."</table>";
	break;
	case "dmc":
	case "dod":
	case "tfc":
	case "tf2":
	$retval="<table cellspacing=0 cellpadding=0 width=\"100%\">"
		."<tr>"
		."<td class=\"row\">"
		."<table cellspacing=0 cellpadding=0>"
		."<tr><td style=\"padding-right: 5px;\">".checkmark()." <font class=\"color\">Flashlight:</font></td><td>".($gameserver ->rules["mp_flashlight"] == 1 ? "Yes" : "No")."</td></tr>"
		."<tr><td style=\"padding-right: 5px;\">".checkmark()." <font class=\"color\">Footsteps:</font></td><td>".($gameserver ->rules["mp_footsteps"] == 1 ? "Yes" : "No")."</td></tr>"
		."<tr><td style=\"padding-right: 5px;\">".checkmark()." <font class=\"color\">Friendly Fire:</font></td><td>".($gameserver ->rules["mp_friendlyfire"] == 1 ? "Yes" : "No")."</td></tr>"
		."</table>"
		."</td>"
		."<td class=\"row\">"
		."<table cellspacing=0 cellpadding=0>"
		."<tr><td style=\"padding-right: 5px;\">".checkmark()." <font class=\"color\">Min Rate:</font></td><td>".spBytes($gameserver ->rules["sv_minrate"])."</td></tr>"
		."<tr><td style=\"padding-right: 5px;\">".checkmark()." <font class=\"color\">Max Rate:</font></td><td>".spBytes($gameserver ->rules["sv_maxrate"])."</td></tr>"
		."<tr><td style=\"padding-right: 5px;\">".checkmark()." <font class=\"color\">Time Limit:</font></td><td>".$gameserver ->rules["mp_timelimit"]."</td></tr>"
		."</table>"
		."</td>"
		."</tr>"
		."</table>";
	break;
	case "nsp":
	$retval="<table cellspacing=0 cellpadding=0 width=\"100%\">"
		."<tr>"
		."<td class=\"row\">"
		."<table cellspacing=0 cellpadding=0>"
		."<tr><td style=\"padding-right: 5px;\">".checkmark()." <font class=\"color\">Allow Spectators:</font></td><td>".($gameserver ->rules["mp_allowspectators"] == 1 ? "Yes" : "No")."</td></tr>"
		."<tr><td style=\"padding-right: 5px;\">".checkmark()." <font class=\"color\">Flashlight:</font></td><td>".($gameserver ->rules["mp_flashlight"] == 1 ? "Yes" : "No")."</td></tr>"
		."<tr><td style=\"padding-right: 5px;\">".checkmark()." <font class=\"color\">Footsteps:</font></td><td>".($gameserver ->rules["mp_footsteps"] == 1 ? "Yes" : "No")."</td></tr>"
		."<tr><td style=\"padding-right: 5px;\">".checkmark()." <font class=\"color\">Force Respawn:</font></td><td>".($gameserver ->rules["mp_forcerespawn"] == 1 ? "Yes" : "No")."</td></tr>"
		."</table>"
		."</td>"
		."<td class=\"row\">"
		."<table cellspacing=0 cellpadding=0>"
		."<tr><td style=\"padding-right: 5px;\">".checkmark()." <font class=\"color\">Friendly Fire:</font></td><td>".($gameserver ->rules["mp_friendlyfire"] == 1 ? "Yes" : "No")."</td></tr>"
		."<tr><td style=\"padding-right: 5px;\">".checkmark()." <font class=\"color\">Min Rate:</font></td><td>".spBytes($gameserver ->rules["sv_minrate"])."</td></tr>"
		."<tr><td style=\"padding-right: 5px;\">".checkmark()." <font class=\"color\">Max Rate:</font></td><td>".spBytes($gameserver ->rules["sv_maxrate"])."</td></tr>"
		."<tr><td style=\"padding-right: 5px;\">".checkmark()." <font class=\"color\">Time Limit:</font></td><td>".$gameserver ->rules["mp_timelimit"]."</td></tr>"
		."</table>"
		."</td>"
		."</tr>"
		."</table>";
	break;
	default:
	$retval="Error: No gamename found.<br>".$gameserver->gamename."";
	} 
return $retval;
}
}
?>