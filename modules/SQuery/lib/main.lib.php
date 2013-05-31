<?PHP
if ( !defined('NUKE_FILE') )
{
        die ("SQuery Security ");
}
// SQuery
// Based on code by David Cramer released to the public domain.

// changes to 3.0
// Complete rewrite to make extending easier. Now using a modified version of the gsQuery game query functions (www.gsquery.org)
// Added support for a lot of games.


// changes to 2.0
// Added support for Call of Duty.
// fixed long standing bug that reported wrong # of players in SOF2.
// restructured code
// removed statistics (for now)
// removed support for skins
// created versions for PHPNuke Module and PHPNuke Blocks
/*
 $displaytips=TRUE;
// Display IP Entry Form at Top TRUE or FALSE
$show_ip_entry_form=TRUE;
$queryfromurl=FALSE;
// Here you can add or change the tips

$tipmsg = array (
"If you fire burst shots with an assault rifle, you'll greatly increase accuracy and range.",
"When you're at close range with an opponent, try to hit them with your gun instead of shooting them.",
"Listen! The sounds the enemy makes are very revealing...",
"You shouldn't make fun of nerds... you'll be working for one some day (Great Tip!)",
"Visit www.PBBans.com, The Best Anti-Cheat Punkbuster Site around!"
);
*/
global $libpath;
include_once ($libpath."config.php");

////////////////////////////////////////////////////////////////////////
//PUT THINGS WE KNOW WE ARE KEEPING HERE.
///////////////////////////////////////////////////////////////////////
// If you set this it will not display the query box, or any of your favorites, it will only show the server you put in below

function showVersion() {
	// Script version

	$version = "PG 5.0";



	return "<b class=color>&copy; SQuery $version</b>";
}

//needed to fix tiny block display issues in admin and squery module areas
include "gametable.php";
/*$gametable = array (
"Americas Army" => "armygame",
"Battlefield 2" => "gsqp2",
"Battlefield 2 SF" => "gsqp2",
"Battlefield 2142" => "gsqp3",
"BField:1942" => "gsqp",
"BField:Vietnam" => "gsqp2",
"Call of Duty" => "q3a",
"CoD:United Offensive" => "q3a",
"Call of Duty 2" => "q3a",
"Chaser" => "gsvari",
"Chrome" => "ase",
"CnC Renegade" => "rene",
"Counterstrike 15" => "hlife",
"Counterstrike" => "hlife",
"Cstrike:Source" => "hlife2",
"Descent 3" => "gsqp",
"Devastation" => "devi",
"DoD:Source" => "hlife2",
"Doom3" => "doom3",
"FarCry" => "ase",
"F.E.A.R" => "fear",
"Global Ops" => "gsqp",
"Ghost Recon AW" => "gsqp4",
"Gore" => "gore",
"Halo" => "halo",
"Heretic 2" => "q2a",
"Half-Life" => "hlife2",
"Half-Life 2" => "hlife2",
"HLife:CndZero" => "hlife2",
"HLife:Cstrike" => "hlife2",
"HLife:DMC" => "hlife2",
"HLife:DOD" => "hlife2",
"HLife:N.S." => "hlife2",
"HLife:O.F." => "hlife2",
"HLife:TFC" => "hlife2",
"IL-2 Sturmovik" => "gsqp",
"IGI2" => "igi2",
"Jedi Knight 2" => "sof2",
"Jedi Knight 3" => "sof2",
"KumaWar" => "gsqp",
"MOH:AA" => "mohaa",
"MOH:BT" => "mohaa",
"MOH:PA" => "q3a",
"MOH:SH" => "mohaa",
"MTA(GTA3)" => "ase",
"NASCAR SimRacer" => "simracer",
"NetPanzer" => "netpanzer",
"NOLF" => "gsqp",
"NOLF 2" => "gsqp",
"Op. Flshpnt" => "flashpoint",
"Painkiller" => "pkill",
"Postal 2" => "flashpoint",
"Purge Jihad" => "ase",
"Quake 2" => "q2a",
"Quake 3" => "q3a",
"Quake 4" => "q3a",
"Quake 3:UT" => "q3a",
"QuakeWorld" => "qworld",
"Rally Masters" => "flashpoint",
"RavenShield" => "rvnshld",
"RTCW" => "sof2",
"RTCW:ET" => "et",
"Rune" => "flashpoint",
"Savage" => "savage",
"Serious Sam" => "igi2",
"Serious Sam 2" => "igi2",
"Sin" => "q2a",
"SOF" => "sof1",
"SOF II" => "sof2",
"Soldat" => "ase",
"ST:Elite Force" => "q3a",
"ST:Elite Force 2" => "q3a",
"SW:Battlefront" => "gsqp2",
"Swat 4" => "swat4",
"Tactical Ops" => "gsqp",
"Unreal" => "unreal",
"Unreal 2 XMP" =>"devi",
"UT" => "ut2004",
"UT2003" => "ut2004",
"UT2004" => "ut2004",
"VietCong" => "vietcong"
);
*/

function calcqport($port,$qgame)
{

 $porttable = array (
"Americas Army" => "+1",
"KumaWar" => "13242",
//"BField:1942" => "23000",
"BField:1942" => "+8433",
//"BField:Vietnam" => "23000",
"BField:Vietnam" => "+8433",
//"Battlefield 2" => "29900",
"Battlefield 2" => "+13333",
//"Battlefield 2 SF" => "29900",
"Battlefield 2 SF" => "+13333",
//"Battlefield 2142" => "29900",
"Battlefield 2142" => "+13333",
"Call of Duty" => "0",
"CoD:United Offensive" => "0",
"Call of Duty 2" => "0",
"Call of Duty 4" => "0",
"Chaser" => "0",
"Alien vs Predator 2" => "0",
"Chrome" => "+123",
"CnC Renegade" => "25300",
"Counterstrike 15" => "0",
"Counterstrike" => "0",
"Cstrike:Source" => "0",
"Descent 3" => "+18050",
"Devastation" => "+10",
"DoD:Source" => "0",
"Doom3" => "0",
"FarCry" => "+123",
"F.E.A.R" => "0",
"Global Ops" => "0",
"Gore" => "+1",
"Ghost Recon AW" => "15250",
"Halo" => "0",
"Heretic 2" => "0",
"Half-Life" => "0",
"Half-Life 2" => "0",
"HLife:CndZero" => "0",
"HLife:Cstrike" => "0",
"HLife:DMC" => "0",
"HLife:DOD" => "0",
"HLife:N.S." => "0",
"HLife:O.F." => "0",
"HLife:TFC" => "0",
"IL-2 Sturmovik" => "0",
"IGI2" => "0",
"Jedi Knight 2" => "0",
"Jedi Knight 3" => "0",
"MOH:AA" => "0",
"MOH:BT" => "0",
"MOH:PA" => "0",// 13300 is Gamespy
"MOH:SH" => "0",
"MTA(GTA3)" => "+123",
"NASCAR SimRacer" => "-100",
"NetPanzer" => "0",
"NOLF" => "+1",
"NOLF 2" => "+1",
"Op. Flshpnt" => "+1",
"Painkiller" => "0",
"Postal 2" => "+1",
"Purge Jihad" => "0",
"Quake 2" => "0",
"Quake 3" => "0",
"Quake 3:UT" => "0",
"Quake 4" => "0",
"QuakeWorld" => "0",
"Rally Masters" => "0",
"RavenShield" => "+1000",
"RTCW" => "0",
"RTCW:ET" => "0",
"Rune" => "+1",
"Savage" => "0",
"Serious Sam" => "+1",
"Serious Sam 2" => "+1",
"Sin" => "0",
"SOF" => "0",
"SOF II" => "0",
"Soldat" => "+123",
"ST:Elite Force" => "0",
"ST:Elite Force 2" => "0",
"SW:Battlefront" => "3658",
"Swat 4" => "+1",
"Tactical Ops" => "+1",
"Unreal" => "+1",
"Unreal 2 XMP" =>"+10",
"UT" => "+1",
"UT2003" => "+10",
"UT2004" => "+10",
"VietCong" => "+10000"
);


foreach($porttable as $key=>$value)
{
 if ($key==$qgame)
	{
	 $portdiff=$value;
	}
}

  if (!isset($portdiff))
  { trigger_error("Game Type not a vaild type", E_USER_ERROR);
    die();
  }

 // check out value: if it starts with a + or -, it's an offset. if it's 0, it means no change.  anything else is a static port.

   switch ($portdiff[0])
    {
     case '+':
        $portdiff=substr($portdiff,1);
    	$newport=$port+$portdiff;
	break;
     case '-':
		$portdiff=substr($portdiff,1);
		$newport=$port-$portdiff;
	break;
     case '0':
		$newport=$port;
	break;
     default:
		$newport=$portdiff;
	break;
    }

  return $newport;

}

// -----------------------------------------

//functions

//------------------------------------------

function checkmark()
{
	return "";
}

function checkmark2()
{
	return "";
}


function spBytes($bytes) {

	if ($bytes > 1048576) {

		$mb = round($bytes / 1048576,2);

		return "$mb MB/sec";

	} elseif ($bytes > 1024) {

		$kb = round($bytes / 1024,2);

		return "$kb KB/sec";

	} else {

		return "$bytes B/sec";

	}

}


// nduration(unix timestamp) - returns duration in a [x]:xx format

function nduration($time) {

	$time = floor($time);

	if ($time > 60) {

		$m = floor($time / 60);

		$s = $time - ($m * 60);

		$s = substr("00".$s,-2);

		return "$m:$s";

	} else {

		$s = substr("00".$time,-2);

		return ":$s";

	}

}



function showCredits($link) {

	global $version, $libpath;

	$localpath=$libpath;

	$localpath=str_replace("/","\\\\\\",$localpath);
	return "<a href=\"javascript:void(0);\" onclick=\"return overlib('Parts Taken From Code by <font class=color>Curtis Brown</font><br>Supports: <font class=color>Too many to mention</font><br><br>Based on original code by <font class=colory>David Cramer</font> released to the public domain. Incorporates portions of the gsQuery Library (<a href=\\'http://www.gsquery.org\\' target=_new class=color>www.gsQuery.org</a>)<br><br>More info about this Tool can be found at (<a href=\\'http://www.squery.com\\' target=_new class=color>www.squery.com</a>)<br><br>Modyfied to work with PNC (<a href=\\'http://www.phpnuke-clan.net\\' target=_new class=color>www.phpnuke-clan.net</a>) by XenoMorpH<br><br> Updates by (<a href=\\'http://www.phpnuke-clan.net\\' target=_new class=color>www.phpnuke-clan.net</a>)<br>Palbin & Soloknight', STICKY, CAPTION, 'SQuery $version', CENTER);\" onmouseout=\"nd();\" class=\"link\">$link</a>";
}



function showTip() {

       global $tipmsg;

       return $tipmsg[rand(0,count($tipmsg)-1)];
}



function domappic($server)
{

	global $libpath;

 $picpath="../images/maps/".$server->gamename."/".$server->mapname.".JPG";

 $picpath=strtolower($picpath);

 $picpath=$libpath.$picpath;

 echo "<!-- ".$picpath."-->";

 if (!file_exists($picpath)) $picpath=$libpath."../images/maps/unknown.gif";

return $picpath;

}



function domappic1($server)
{

	global $libpath;

 $picpath="../images/maps/".$server->gamename."/".$server->mapname.".JPG";

 $picpath=strtolower($picpath);

 $picpath=$libpath.$picpath;

 echo "<!-- ".$picpath."-->";

 if (!file_exists($picpath)) $picpath=$libpath."../images/maps/unknown_small.gif";

return $picpath;

}



function gametitle($gamename)
{

	switch (strtolower($gamename))
	{
	case "avp2":
	  $retval="Alien vs Predator 2";
	  break;
	case "call of duty":
	  $retval="Call of Duty";
	  break;
    case "battlefield2":
	  $retval="BattleField 2";
	  break;
    case "battlefield 2 SF":
	  $retval="BattleField 2: SF";
	  break;
	//case "battlefield2142":
    case "stella":
	  $retval="BattleField 2142";
	  break;
	case "cod-uo":
      $retval="CoD: United Offensive";
	  break;
	case "cod2":
	  $retval="Call of Duty 2";
	  break;
	case "cod4":
	  $retval="Call of Duty 4";
	  break;
	case "dod-source":
	  $retval="Day of Defeat:Source";
	  break;
	case "fear":
	  $retval="F.E.A.R";
	  break;
	case "sof1";
      $retval="Soldier of Fortune";
       break;
	case "ccrenegade":
      $retval="C&C Renegade";
	  break;
	case "sof2mp":
	  $retval="Soldier of Fortune II: Double Helix";
	  break;
	case "mohaa":
	  $retval="Medal of Honor";
	  break;
	case "moh-pa":
	  $retval="Medal of Honor: Pacific Assault";
	  break;
	case "chaser":
	  $retval="Chaser";
	  break;
	case "chrome":
	  $retval="Chrome";
	  break;
 	case "cs-source":
	  $retval="Counter Stike:Source";
	  break;
	case "descent3":
	  $retval="Descent 3";
	  break;
	case "basedoom-1":
	  $retval="Doom III";
	  break;
	case "devastation":
	  $retval="Devastation";
	  break;
	case "globalops":
	  $retval="Global Operations";
	  break;
	case "gore":
	  $retval="Gore";
	  break;
  	  case "graw":
	  $retval="Ghost Recon AW";
	  break;
	case "halo":
	  $retval="Halo";
	  break;
	case "heretic2":
	  $retval="Heretic II";
	  break;
	case "qworld":
	  $retval="QuakeWorld";
	  break;
	case "il2sturmovik":
	case "il2sturmovikfb":
	  $retval="IL-2 Sturmovik";
	  break;
	case "rtcw":
	  $retval="Return to Castle Wolfenstein";
	  break;
	case "netpanzer":
	  $retval="NetPanzer";
	  break;
	case "nolf":
	  $retval="NoOne Lives Forever";
	  break;
	case "nolf2":
	  $retval="NoOne Lives Forever 2";
	  break;
	case "simracer":
	  $retval="NASCAR SimRacer";
	  break;
	case "rtcw-et":
	  $retval="RTCW-Enemy Territory";
	  break;
	case "jk2":
	  $retval="JK2: Jedi Outcast";
	  break;
	case "jk3":
	  $retval="JK3: Jedi Academy";
	  break;
	case "armygame":
	  $retval="America's Army";
	  break;
	case "cstrike":
	  $retval='Half-Life:CounterStrike';
	  break;
	case "valve":
	  $retval='Half-Life';
	  break;
	case "hl2mp":
	  $retval='Half-Life 2';
	  break;
	case "czero":
	  $retval='Half-Life:Condition Zero';
	  break;
	case "nsp":
	  $retval='Half-Life:Natural Selection';
	  break;
	case "dmc":
	  $retval='Half-Life:Deathmatch Classic';
	  break;
	case "dod":
	  $retval='Half-Life:Day of Defeat';
	  break;
	case "tfc":
	  $retval='Half-Life:Team Fortress Classic';
	  break;
	case "gearbox":
	  $retval='Half-Life:Opposing Forces';
	  break;
	case "projectigi2r":
	  $retval="IGI2: Covert Strike";
	  break;
	case "opflash":
	  $retval="Operation Flashpoint";
	  break;
	case "opflashr":
	  $retval="Operation Flashpoint: Resistance";
	  break;
	case "pkill":
	  $retval="Painkiller";
	  break;
	case "postal2":
	  $retval="Postal 2";
	  break;
	case "purge":
	  $retval="Purge Jihad";
	  break;
	case "rally":
	  $retval="Rally Masters";
	  break;
	case "rune":
	  $retval="Rune";
	  break;
	case "savage":
	  $retval="Savage: Battle For Newerth";
	  break;
	case "steforce":
	  $retval="Star Trek: Elite Force";
	  break;
	case "steforce2":
	  $retval="Star Trek: Elite Force II";
	  break;
	case "swbattlefront":
	  $retval="Star Wars: Battlefront";
	  break;
	case "swat 4x":
	case "swat 4":
	  $retval="Swat 4";
	  break;
	case "unreal":
	  $retval='Unreal';
	  break;
	case "ut":
	  $retval="Unreal Tournament";
	  break;
	case "ut2":
	  $retval="Unreal Tournament 2003";
	  break;
	case "q3":
	  $retval="Quake III";
	  break;
	case "q2a":
	  $retval="Quake II";
	  break;
	case "serioussam":
	  $retval="Serious Sam";
	  break;
	case "serioussamse":
	  $retval="Serious Sam 2";
	  break;
	case "sin":
	  $retval="SiN";
	  break;
	case "soldat":
	  $retval="Soldat";
	  break;
	case "tacops":
	  $retval="Tactical Ops";
	  break;
	case "ut2004":
	  $retval="Unreal Tournament 2004";
	  break;
	case "farcry":
	  $retval="FarCry";
	  break;
	case "ravenshield":
	  $retval="Rainbow 6: Ravenshield";
	  break;
	case "bfield1942":
	  $retval="BattleField: 1942";
	  break;
	case "bfvietnam":
	  $retval="BattleField: Vietnam";
	  break;
	case "unreal2":
	  $retval="Unreal 2 XMP";
	  break;
	case "vietcong":
	  $retval="VietCong";
	  break;
	case "kumawar":
	  $retval="KumaWar";
	  break;
	default:
	  $retval="Game Status";
	  break;
	}

return $retval;
}

//New Xfire protcal>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
function gametitle1($gamename3)
{
	switch (strtolower($gamename3))
	{
	case "avp2":
	  $retval="xfire:join?game=avp2&server=";
	  break;
	case "call of duty":
	  $retval="xfire:join?game=codmp&server=";
	  break;
    case "battlefield2":
	  $retval="xfire:join?game=bf2&server=";
	  break;
    case "battlefield 2 SF":
	  $retval="xfire:join?game=bf2&server=";
	  break;
	//case "battlefield2142":
    case "stella":
	  $retval="xfire:join?game=bf2142&server=";
	  break;
	case "cod-uo":
      $retval="xfire:join?game=coduomp&server=";
	  break;
	case "cod2":
	  $retval="xfire:join?game=cod2mp&server=";
	  break;
	case "cod4":
	  $retval="xfire:join?game=cod4mp&server=";
	  break;
	case "dod-source":
	  $retval="xfire:join?game=dods&server=";
	  break;
	case "fear":
	  $retval="xfire:join?game=fearmp&server=";
	  break;
	case "sof1";
      $retval="xfire:join?game=sof&server=";
       break;
	case "ccrenegade":
      $retval="xfire:join?game=ccren&server=";
	  break;
	case "sof2mp":
	  $retval="xfire:join?game=sof2mp&server=";
	  break;
	case "mohaa":
	  $retval="xfire:join?game=mohaa&server=";
	  break;
	case "moh-pa":
	  $retval="xfire:join?game=mohpa&server=";
	  break;
	case "chaser":
	  $retval="no";
	  break;
	case "chrome":
	  $retval="xfire:join?game=chrome&server=";
	  break;
 	case "cs-source":
	  $retval="xfire:join?game=css&server=";
	  break;
	case "descent3":
	  $retval="no";
	  break;
	case "basedoom-1":
	  $retval="xfire:join?game=doom3&server=";
	  break;
	case "devastation":
	  $retval="xfire:join?game=devst&server=";
	  break;
	case "globalops":
	  $retval="no";
	  break;
	case "gore":
	  $retval="xfire:join?game=gotr&server=";
	  break;
	case "graw":
	  $retval="no";
	  break;
	case "halo":
	  $retval="xfire:join?game=halo&server=";
	  break;
	case "heretic2":
	  $retval="no";
	  break;
	case "qworld":
	  $retval="xfire:join?game=qwcl&server=";
	  break;
	case "il2sturmovik":
	case "il2sturmovikfb":
	  $retval="xfire:join?game=il2fb&server=";
	  break;
	case "rtcw":
	  $retval="xfire:join?game=rtcwmp&server=";
	  break;
	case "netpanzer":
	  $retval="no";
	  break;
	case "nolf":
	  $retval="xfire:join?game=nolf&server=";
	  break;
	case "nolf2":
	  $retval="xfire:join?game=nolf2&server=";
	  break;
	case "simracer":
	  $retval="no";
	  break;
	case "rtcw-et":
	  $retval="xfire:join?game=wet&server=";
	  break;
	case "jk2":
	  $retval="xfire:join?game=jk2mp&server=";
	  break;
	case "jk3":
	  $retval="xfire:join?game=jk3mp&server=";
	  break;
	case "armygame":
	  $retval="xfire:join?game=aao&server=";
  	  break;
	case "hlife_cstrike":
	  $retval="xfire:join?game=cs&server=";
	  break;
	case "hlife_valve":
	  $retval="xfire:join?game=hl&server=";
	  break;
    case "hl2mp":
	  $retval="xfire:join?game=hl2ctf&server=";
	  break;
	case "hlife_czero":
	  $retval="xfire:join?game=cscz&server=";
	  break;
	case "hlife_nsp":
	  $retval="xfire:join?game=ns&server=";
	  break;
	case "hlife_dmc":
	  $retval="xfire:join?game=hldmc&server=";
	  break;
	case "hlife_dod":
	  $retval="xfire:join?game=hldod15&server=";
	  break;
	case "hlife_gearbox":
	  $retval="xfire:join?game=hlof&server=";
	  break;
	case "projectigi2r":
	  $retval="no";
	  break;
	case "opflash":
	  $retval="xfire:join?game=opflsh&server=";
	  break;
	case "opflashr":
	  $retval="xfire:join?game=opflshr&server=";
	  break;
	case "pkill":
	  $retval="xfire:join?game=pnklr&server=";
	  break;
	case "postal2":
	  $retval="xfire:join?game=postal2&server=";
	  break;
	case "purge":
	  $retval="no";
	  break;
	case "rally":
	  $retval="xfire:join?game=postal2&server=";
	  break;
	case "rune":
	  $retval="xfire:join?game=runw&server=";
	  break;
	case "savage":
	  $retval="xfire:join?game=sav&server=";
	  break;
	case "steforce":
	  $retval="xfire:join?game=stet&server=";
	  break;
	case "steforce2":
	  $retval="xfire:join?game=stet2&server=";
	  break;
	case "swbattlefront":
	  $retval="no";
	  break;
	case "unreal":
	  $retval="xfire:join?game=unreal&server=";
	  break;
	case "ut":
	  $retval="xfire:join?game=ut&server=";
	  break;
	case "ut2":
	  $retval="xfire:join?game=ut2k3&server=";
	  break;
	case "q3":
	  $retval="xfire:join?game=q3&server=";
	  break;
	case "q2a":
	  $retval="xfire:join?game=q2&server=";
	  break;
	case "serioussam":
	  $retval="xfire:join?game=ssam&server=";
	  break;
	case "serioussamse":
	  $retval="xfire:join?game=ssam2&server=";
	  break;
	case "sin":
	  $retval="xfire:join?game=sinmps&server=";
	  break;
	case "soldat":
	  $retval="xfire:join?game=soldat&server=";
	  break;
	case "tacops":
	  $retval="xfire:join?game=tacops&server=";
	  break;
	case "ut2004":
	  $retval="xfire:join?game=ut2k4&server=";
	  break;
	case "farcry":
	  $retval="xfire:join?game=fc&server=";
	  break;
	case "ravenshield":
	  $retval="xfire:join?game=r63&server=";
	  break;
	case "bfield1942":
	  $retval="xfire:join?game=bf1942&server=";
	  break;
	case "bfvietnam":
	  $retval="xfire:join?game=bfv&server=";
	  break;
	case "unreal2":
	  $retval="xfire:join?game=u2xmp&server=";
	  break;
	case "vietcong":
	  $retval="xfire:join?game=vcong&server=";
	  break;
	case "kumawar":
	  $retval="xfire:join?game=kw&server=";
	  break;
	case "swat 4x":
	case "swat 4":
	  $retval="xfire:join?game=swat4&server=";
	  break;
	default:
	  $retval="No Xfire defined";
	  break;
	}
return $retval;
}

/////////////////////////////////////////////////////////////////////////
//END OF KEEPERS
////////////////////////////////////////////////////////////////////////

global $serverlist, $favorites, $col_highlight, $col_normal, $col_border, $col_background,$version;
?>