<?php

 /*----------------------------------------------------------------------------------------------------------\
 |                                                                                                            |
 |                      [ LIVE GAME SERVER LIST ] [ © RICHARD PERRY FROM GREYCUBE.COM ]                       |
 |                                                                                                            |
 |    Released under the terms and conditions of the GNU General Public License Version 3 (http://gnu.org)    |
 |                                                                                                            |
 |-------------------------------------------------------------------------------------------------------------
 |        [ EDITOR STYLE SETTINGS: LUCIDA CONSOLE, SIZE 10, TAB = 2 SPACES, BOLD GLOBALLY TURNED OFF ]        |
 \-----------------------------------------------------------------------------------------------------------*/

//------------------------------------------------------------------------------------------------------------+
//------------------------------------------------------------------------------------------------------------+

  if (!function_exists('lgsl_type_list')) {
  function lgsl_type_list()
  {
    $lgsl_type_list = array("aarmy"         => "Americas Army",
                            "arma"          => "ArmA: Armed Assault",
                            "avp2"          => "Aliens VS. Predator 2",
                            "bfvietnam"     => "Battlefield Vietnam",
                            "bf1942"        => "Battlefield 1942",
                            "bf2"           => "Battlefield 2",
                            "bf2142"        => "Battlefield 2142",
                            "callofduty"    => "Call Of Duty",
                            "callofdutyuo"  => "Call Of Duty: United Offensive",
                            "callofduty2"   => "Call Of Duty 2",
                            "callofduty4"   => "Call Of Duty 4",
                            "cncrenegade"   => "Command and Conquer: Renegade",
                            "crysis"        => "Crysis",
                            "doom3"         => "Doom 3",
                            "dh2005"        => "Deer Hunter 2005",
                            "farcry"        => "Far Cry",
                            "fear"          => "F.E.A.R.",
                            "flashpoint"    => "Operation Flashpoint",
                            "freelancer"    => "Freelancer",
                            "frontlines"    => "Frontlines: Fuel Of War",
                            "ghostrecon"    => "Ghost Recon",
                            "graw"          => "Ghost Recon: Advanced Warfighter",
                            "graw2"         => "Ghost Recon: Advanced Warfighter 2",
                            "gtr2"          => "GTR 2",
                            "had2"          => "Hidden and Dangerous 2",
                            "halflife"      => "Half-Life 1 ( Steam )",
                            "halflifewon"   => "Half-Life 1 ( WON )",
                            "halo"          => "Halo",
                            "il2"           => "IL-2 Sturmovik",
                            "jediknight2"   => "JediKnight 2",
                            "mohaa"         => "Medal of Honor: Allied Assault",
                            "mohaab"        => "Medal of Honor: Allied Assault Breakthrough",
                            "mohaas"        => "Medal of Honor: Allied Assault Spearhead",
                            "mohpa"         => "Medal of Honor: Pacific Assault",
                            "mta"           => "Multi Theft Auto",
                            "nascar2004"    => "Nascar Thunder 2004",
                            "neverwinter"   => "NeverWinter Nights",
                            "neverwinter2"  => "NeverWinter Nights 2",
                            "painkiller"    => "PainKiller",
                            "quakeworld"    => "Quake World",
                            "quakewars"     => "Enemy Territory: Quake Wars",
                            "quake2"        => "Quake 2",
                            "quake3"        => "Quake 3",
                            "quake4"        => "Quake 4",
                            "ravenshield"   => "Raven Shield",
                            "rfactor"       => "RFactor",
                            "samp"          => "San Andreas Multiplayer",
                            "savage"        => "Savage",
                            "savage2"       => "Savage 2",
                            "serioussam"    => "Serious Sam",
                            "serioussam2"   => "Serious Sam 2",
                            "sof2"          => "Soldier of Fortune 2",
                            "soldat"        => "Soldat",
                            "source"        => "Source ( Half-Life 2 )",
                            "stalker"       => "S.T.A.L.K.E.R.",
                            "startrekef"    => "StarTrek Elite-Force",
                            "swat4"         => "SWAT 4",
                            "test"          => "Test ( For PHP Developers )",
                            "ut"            => "Unreal Tournament",
                            "ut2003"        => "Unreal Tournament 2003",
                            "ut2004"        => "Unreal Tournament 2004",
                            "ut3"           => "Unreal Tournament 3",
                            "vietcong"      => "Vietcong",
                            "vietcong2"     => "Vietcong 2",
                            "warsow"        => "Warsow",
                            "wolfenstein"   => "Wolfenstein");

    return $lgsl_type_list;
  }}

//------------------------------------------------------------------------------------------------------------+
//------------------------------------------------------------------------------------------------------------+

  if (!function_exists('lgsl_protocol_list')) {
  function lgsl_protocol_list()
  {
    $lgsl_protocol_list = array("aarmy"        => "09",
                                "aarmy_"       => "03",
                                "arma"         => "09",
                                "avp2"         => "03",
                                "bfvietnam"    => "09",
                                "bf1942"       => "03",
                                "bf2"          => "06",
                                "bf2142"       => "06",
                                "callofduty"   => "02",
                                "callofdutyuo" => "02",
                                "callofduty2"  => "02",
                                "callofduty4"  => "02",
                                "cncrenegade"  => "03",
                                "crysis"       => "06",
                                "doom3"        => "10",
                                "dh2005"       => "09",
                                "had2"         => "03",
                                "halflife"     => "05",
                                "halflifewon"  => "05",
                                "halo"         => "03",
                                "il2"          => "03",
                                "farcry"       => "08",
                                "fear"         => "09",
                                "flashpoint"   => "03",
                                "freelancer"   => "14",
                                "frontlines"   => "20",
                                "ghostrecon"   => "19",
                                "graw"         => "06",
                                "graw2"        => "09",
                                "gtr2"         => "15",
                                "jediknight2"  => "02",
                                "mohaa"        => "03",
                                "mohaab"       => "03",
                                "mohaas"       => "03",
                                "mohpa"        => "03",
                                "mohaa_"       => "02",
                                "mohaab_"      => "02",
                                "mohaas_"      => "02",
                                "mohpa_"       => "02",
                                "mta"          => "08",
                                "nascar2004"   => "09",
                                "neverwinter"  => "09",
                                "neverwinter2" => "09",
                                "painkiller"   => "08",
                                "painkiller_"  => "09",
                                "quakeworld"   => "07",
                                "quakewars"    => "10",
                                "quake2"       => "02",
                                "quake3"       => "02",
                                "quake4"       => "10",
                                "ravenshield"  => "04",
                                "rfactor"      => "16",
                                "samp"         => "12",
                                "savage"       => "17",
                                "savage2"      => "18",
                                "serioussam"   => "03",
                                "serioussam2"  => "09",
                                "sof2"         => "02",
                                "soldat"       => "08",
                                "source"       => "05",
                                "stalker"      => "06",
                                "startrekef"   => "02",
                                "swat4"        => "03",
                                "test"         => "01",
                                "warsow"       => "02",
                                "ut"           => "03",
                                "ut2003"       => "13",
                                "ut2003_"      => "03",
                                "ut2004"       => "13",
                                "ut2004_"      => "03",
                                "ut3"          => "11",
                                "vietcong"     => "03",
                                "vietcong2"    => "09",
                                "wolfenstein"  => "02");

    return $lgsl_protocol_list;
  }}

//------------------------------------------------------------------------------------------------------------+
//------------------------------------------------------------------------------------------------------------+

  if (!function_exists('lgsl_software_link')) {
  function lgsl_software_link($ip, $q_port, $c_port, $s_port, $type)
  {
    $lgsl_software_link = array("aarmy"          => "qtracker://{IP}:{S_PORT}?game=ArmyOperations&amp;action=show",
                                "arma"           => "qtracker://{IP}:{S_PORT}?game=ArmedAssault&amp;action=show",
                                "avp2"           => "qtracker://{IP}:{S_PORT}?game=AliensversusPredator2&amp;action=show",
                                "bfvietnam"      => "qtracker://{IP}:{S_PORT}?game=BattlefieldVietnam&amp;action=show",
                                "bf1942"         => "qtracker://{IP}:{S_PORT}?game=Battlefield1942&amp;action=show",
                                "bf2"            => "qtracker://{IP}:{S_PORT}?game=Battlefield2&amp;action=show",
                                "bf2142"         => "qtracker://{IP}:{S_PORT}?game=Battlefield2142&amp;action=show",
                                "callofduty"     => "qtracker://{IP}:{S_PORT}?game=CallOfDuty&amp;action=show",
                                "callofdutyuo"   => "qtracker://{IP}:{S_PORT}?game=CallOfDutyUnitedOffensive&amp;action=show",
                                "callofduty2"    => "qtracker://{IP}:{S_PORT}?game=CallOfDuty2&amp;action=show",
                                "callofduty4"    => "qtracker://{IP}:{S_PORT}?game=CallOfDuty4&amp;action=show",
                                "cncrenegade"    => "qtracker://{IP}:{S_PORT}?game=CommandConquerRenegade&amp;action=show",
                                "crysis"         => "qtracker://{IP}:{S_PORT}?game=Crysis&amp;action=show",
                                "doom3"          => "qtracker://{IP}:{S_PORT}?game=Doom3&amp;action=show",
                                "dh2005"         => "http://en.wikipedia.org/wiki/Deer_Hunter_(computer_game)",
                                "farcry"         => "eye://NEW://{IP}:{S_PORT}",
                                "fear"           => "qtracker://{IP}:{S_PORT}?game=FEAR&amp;action=show",
                                "flashpoint"     => "qtracker://{IP}:{S_PORT}?game=OperationFlashpoint&amp;action=show",
                                "freelancer"     => "eye://DX://{IP}:{S_PORT}",
                                "frontlines"     => "http://en.wikipedia.org/wiki/Frontlines:_Fuel_of_War",
                                "ghostrecon"     => "eye://GR://{IP}:{S_PORT}",
                                "graw"           => "qtracker://{IP}:{S_PORT}?game=GhostRecon&action=show",
                                "graw2"          => "http://en.wikipedia.org/wiki/Tom_Clancy's_Ghost_Recon_Advanced_Warfighter_2",
                                "gtr2"           => "http://en.wikipedia.org/wiki/GTR2",
                                "had2"           => "http://en.wikipedia.org/wiki/Hidden_&_Dangerous_2",
                                "halflife"       => "qtracker://{IP}:{S_PORT}?game=HalfLife&amp;action=show",
                                "halflifewon"    => "qtracker://{IP}:{S_PORT}?game=HalfLife_WON2&amp;action=show",
                                "halo"           => "qtracker://{IP}:{S_PORT}?game=Halo&amp;action=show",
                                "il2"            => "eye://OLD://{IP}:{S_PORT}",
                                "jediknight2"    => "qtracker://{IP}:{S_PORT}?game=JediKnight2&amp;action=show",
                                "mohaa"          => "qtracker://{IP}:{S_PORT}?game=MedalofHonorAlliedAssault&amp;action=show",
                                "mohaab"         => "qtracker://{IP}:{S_PORT}?game=MedalofHonorAlliedAssaultBreakthrough&amp;action=show",
                                "mohaas"         => "qtracker://{IP}:{S_PORT}?game=MedalofHonorAlliedAssaultSpearhead&amp;action=show",
                                "mohpa"          => "qtracker://{IP}:{S_PORT}?game=MedalofHonorPacificAssault&amp;action=show",
                                "mta"            => "http://en.wikipedia.org/wiki/Multi_Theft_Auto",
                                "nascar2004"     => "http://en.wikipedia.org/wiki/NASCAR_Thunder_2004",
                                "neverwinter"    => "qtracker://{IP}:{S_PORT}?game=NeverwinterNights&amp;action=show",
                                "neverwinter2"   => "qtracker://{IP}:{S_PORT}?game=NeverwinterNights&amp;action=show",
                                "painkiller"     => "qtracker://{IP}:{S_PORT}?game=Painkiller&amp;action=show",
                                "quakeworld"     => "qtracker://{IP}:{S_PORT}?game=QuakeWorld&amp;action=show",
                                "quakewars"      => "qtracker://{IP}:{S_PORT}?game=EnemyTerritoryQuakeWars&amp;action=show",
                                "quake2"         => "qtracker://{IP}:{S_PORT}?game=Quake2&amp;action=show",
                                "quake3"         => "qtracker://{IP}:{S_PORT}?game=Quake3&amp;action=show",
                                "quake4"         => "qtracker://{IP}:{S_PORT}?game=Quake4&amp;action=show",
                                "ravenshield"    => "eye://RVS://{IP}:{S_PORT}",
                                "rfactor"        => "rfactor://{IP}:{S_PORT}",
                                "samp"           => "http://www.sa-mp.com",
                                "savage"         => "http://en.wikipedia.org/wiki/Savage:_The_Battle_for_Newerth",
                                "savage2"        => "http://en.wikipedia.org/wiki/Savage_2:_A_Tortured_Soul",
                                "serioussam"     => "qtracker://{IP}:{S_PORT}?game=SeriousSam&amp;action=show",
                                "serioussam2"    => "qtracker://{IP}:{S_PORT}?game=Serious_Sam2&amp;action=show",
                                "sof2"           => "qtracker://{IP}:{S_PORT}?game=SoldierOfFortune2&amp;action=show",
                                "soldat"         => "eye://NEW://{IP}:{S_PORT}",
                                "source"         => "qtracker://{IP}:{S_PORT}?game=HalfLife2&amp;action=show",
                                "stalker"        => "qtracker://{IP}:{S_PORT}?game=STALKER_ShadowChernobyl&amp;action=show",
                                "startrekef"     => "EYE://EF://{IP}:{S_PORT}",
                                "swat4"          => "qtracker://{IP}:{S_PORT}?game=SWAT4&amp;action=show",
                                "test"           => "http://www.greycube.com",
                                "ut"             => "qtracker://{IP}:{S_PORT}?game=UnrealTournament&amp;action=show",
                                "ut2003"         => "qtracker://{IP}:{S_PORT}?game=UnrealTournament2003&amp;action=show",
                                "ut2004"         => "qtracker://{IP}:{S_PORT}?game=UnrealTournament2004&amp;action=show",
                                "ut3"            => "qtracker://{IP}:{S_PORT}?game=UnrealTournament3&amp;action=show",
                                "vietcong"       => "qtracker://{IP}:{S_PORT}?game=Vietcong&amp;action=show",
                                "vietcong2"      => "qtracker://{IP}:{S_PORT}?game=Vietcong2&amp;action=show",
                                "warsow"         => "qtracker://{IP}:{S_PORT}?game=Warsow&amp;action=show",
                                "wolfenstein"    => "qtracker://{IP}:{S_PORT}?game=ReturntoCastleWolfenstein&amp;action=show");

    // IF THE SOFTWARE PORT IS NOT SET USE THE QUERY PORT

    if (!$s_port) { $s_port = $q_port; }

    // INSERT DATA INTO STATIC LINK AND RETURN

    return str_replace (array("{IP}", "{Q_PORT}", "{C_PORT}", "{S_PORT}"), array($ip, $q_port, $c_port, $s_port), $lgsl_software_link[$type]);
  }}

//------------------------------------------------------------------------------------------------------------+
//------------------------------------------------------------------------------------------------------------+

  if (!function_exists('lgsl_port_conversion')) {
  function lgsl_port_conversion($q_port, $c_port, $s_port, $type)
  {
    switch ($type) // GAMES WHERE Q_PORT IS NOT EQUAL TO C_PORT
    {
      case "aarmy"       : $c_to_q = 1;     $c_def = 1716;    $q_def = 1717;    $c_to_s = 0;   break;
      case "bfvietnam"   : $c_to_q = 0;     $c_def = 15567;   $q_def = 23000;   $c_to_s = 0;   break;
      case "bf1942"      : $c_to_q = 0;     $c_def = 14567;   $q_def = 23000;   $c_to_s = 0;   break;
      case "bf2"         : $c_to_q = 0;     $c_def = 16567;   $q_def = 29900;   $c_to_s = 0;   break;
      case "bf2142"      : $c_to_q = 0;     $c_def = 17567;   $q_def = 29900;   $c_to_s = 0;   break;
      case "dh2005"      : $c_to_q = 0;     $c_def = 23459;   $q_def = 34567;   $c_to_s = 0;   break;
      case "farcry"      : $c_to_q = 123;   $c_def = 49001;   $q_def = 49124;   $c_to_s = 0;   break;
      case "flashpoint"  : $c_to_q = 1;     $c_def = 2302;    $q_def = 2303;    $c_to_s = 0;   break;
      case "frontlines"  : $c_to_q = 2;     $c_def = 5476;    $q_def = 5478;    $c_to_s = 0;   break;
      case "ghostrecon"  : $c_to_q = 2;     $c_def = 2346;    $q_def = 2348;    $c_to_s = 0;   break;
      case "gtr2"        : $c_to_q = 1;     $c_def = 34297;   $q_def = 34298;   $c_to_s = 0;   break;
      case "had2"        : $c_to_q = 3;     $c_def = 11001;   $q_def = 11004;   $c_to_s = 0;   break;
      case "mohaa"       : $c_to_q = 97;    $c_def = 12203;   $q_def = 12300;   $c_to_s = 0;   break;
      case "mohaab"      : $c_to_q = 97;    $c_def = 12203;   $q_def = 12300;   $c_to_s = 0;   break;
      case "mohaas"      : $c_to_q = 97;    $c_def = 12203;   $q_def = 12300;   $c_to_s = 0;   break;
      case "mohpa"       : $c_to_q = 97;    $c_def = 13203;   $q_def = 13300;   $c_to_s = 0;   break;
      case "mta"         : $c_to_q = 123;   $c_def = 22003;   $q_def = 22126;   $c_to_s = 0;   break;
      case "painkiller"  : $c_to_q = 123;   $c_def = 3455;    $q_def = 3578;    $c_to_s = 0;   break;
      case "ravenshield" : $c_to_q = 1000;  $c_def = 7777;    $q_def = 8777;    $c_to_s = 0;   break;
      case "rfactor"     : $c_to_q = -100;  $c_def = 34397;   $q_def = 34297;   $c_to_s = 0;   break;
      case "serioussam"  : $c_to_q = 1;     $c_def = 25600;   $q_def = 25601;   $c_to_s = 0;   break;
      case "soldat"      : $c_to_q = 123;   $c_def = 23073;   $q_def = 23196;   $c_to_s = 0;   break;
      case "stalker"     : $c_to_q = 2;     $c_def = 5447;    $q_def = 5445;    $c_to_s = 0;   break;
      case "swat4"       : $c_to_q = 1;     $c_def = 10780;   $q_def = 10781;   $c_to_s = 0;   break;
      case "ut"          : $c_to_q = 1;     $c_def = 7777;    $q_def = 7778;    $c_to_s = 0;   break;
      case "ut2003"      : $c_to_q = 1;     $c_def = 7757;    $q_def = 7758;    $c_to_s = 10;  break;
      case "ut2003_"     : $c_to_q = 10;    $c_def = 7757;    $q_def = 7767;    $c_to_s = 0;   break;
      case "ut2004"      : $c_to_q = 1;     $c_def = 7777;    $q_def = 7778;    $c_to_s = 10;  break;
      case "ut2004_"     : $c_to_q = 10;    $c_def = 7777;    $q_def = 7787;    $c_to_s = 0;   break;
      case "ut3"         : $c_to_q = 0;     $c_def = 7777;    $q_def = 6500;    $c_to_s = 0;   break;
      case "vietcong"    : $c_to_q = 10000; $c_def = 5425;    $q_def = 15425;   $c_to_s = 0;   break;
      case "vietcong2"   : $c_to_q = 0;     $c_def = 5001;    $q_def = 19967;   $c_to_s = 0;   break;
      default            : $c_to_q = 0;     $c_def = $q_port; $q_def = $c_port; $c_to_s = 0;   break;
    }

    if (!$c_port && !$q_port)
    {
      $c_port = $c_def;
      $q_port = $q_def;
    }

    if ($c_port && !$q_port)
    {
      $q_port = $c_to_q ? $c_port + $c_to_q : $q_def;
    }

    if ($q_port && !$c_port)
    {
      $c_port = $c_to_q ? $q_port - $c_to_q : $c_def;
    }

    if ($c_port && !$s_port)
    {
      $s_port = $c_to_s ? $c_port + $c_to_s : 0;
    }

    return array(intval($q_port), intval($c_port), intval($s_port));
  }}

//------------------------------------------------------------------------------------------------------------+
//------------------------------------------------------------------------------------------------------------+

  if (!function_exists('lgsl_query_live')) {
  function lgsl_query_live($ip, $q_port, $c_port, $s_port, $type, $request)
  {
//---------------------------------------------------------+

    $lgsl_protocol_list = lgsl_protocol_list();

    if (!$lgsl_protocol_list[$type])
    {
      echo "LGSL PROBLEM: ".($type ? "INVALID TYPE '$type'" : "MISSING TYPE")." FOR $ip:$q_port:$c_port:$s_port"; exit;
    }

    if (!function_exists("lgsl_query_{$lgsl_protocol_list[$type]}"))
    {
      echo "LGSL PROBLEM: FUNCTION DOES NOT EXIST FOR: $type"; exit;
    }

//---------------------------------------------------------+

    $status = 1;

    global $lgsl_config; // FEED IS CONFIGURED IN A SEPERATE FILE

    if ($lgsl_config['feed']['method'] && $lgsl_config['feed']['url'])
    {
      $server = lgsl_query_feed($ip, $q_port, $c_port, $s_port, $type, $request, $lgsl_config['feed']['method'], $lgsl_config['feed']['url']);
    }
    elseif ($type == "test")
    {
      $server = call_user_func("lgsl_query_{$lgsl_protocol_list[$type]}", $type, $request, array());
    }
    else
    {
      $server = lgsl_query_direct($ip, $q_port, $type, $request, "lgsl_query_{$lgsl_protocol_list[$type]}");
    }

//---------------------------------------------------------+

    // IF OFFLINE ARRAYS ARE SET TO TRIGGER OTHER CODE AND PREVENT FOEACH ERRORS

    if (!$server)
    {
      $status      = 0;
      $server      = array();
      $server['s'] = array();
      $server['e'] = array();
      $server['p'] = array();
    }

//---------------------------------------------------------+

    // [s] IS A CONSISTANT FORMAT EVEN IF SERVER IS OFFLINE

    if (isset($server['s']))
    {
      if (!$server['s']['game']) { $server['s']['game'] = $type; }

      $tmp = str_replace("\\", "/", $server['s']['map']); // REMOVE ANY
      $tmp = explode("/", $tmp);                          // FOLDERS
      $server['s']['map'] = array_pop($tmp);              // FROM MAP

      if (strtolower($server['s']['password']) == "false") { $server['s']['password'] = 0; }
      if (strtolower($server['s']['password']) == "true")  { $server['s']['password'] = 1; }

      $server['s']['password']   = intval($server['s']['password']);
      $server['s']['players']    = intval($server['s']['players']);
      $server['s']['playersmax'] = intval($server['s']['playersmax']);

      if ($server['s']['players']    < 0) { $server['s']['players']    = 0; }
      if ($server['s']['playersmax'] < 0) { $server['s']['playersmax'] = 0; }
    }

//---------------------------------------------------------+

    // [b] IS ALWAYS RETURNED

    $server['b']['ip']      = $ip;
    $server['b']['q_port']  = $q_port;
    $server['b']['c_port']  = $c_port;
    $server['b']['s_port']  = $s_port;
    $server['b']['type']    = $type;
    $server['b']['request'] = $request;
    $server['b']['status']  = $status;

//---------------------------------------------------------+

    return $server;
  }}

//------------------------------------------------------------------------------------------------------------+
//------------------------------------------------------------------------------------------------------------+

  if (!function_exists('lgsl_query_direct')) {
  function lgsl_query_direct($ip, $q_port, $type, $request, $function_name)
  {
//---------------------------------------------------------+

    // GAMES THAT NEED [s] QUERY TO COMPLETE [e]

    if (strpos($request, "e") !== FALSE && ($type == "halflifewon" || $type == "halflife" || $type == "source" || $type == "samp" || $type == "ut2004"))
    {
      $request .= "s";
    }

    // GAMES THAT NEED [e] QUERY TO COMPLETE [s]

    if (strpos($request, "s") !== FALSE && $type == "ut2004")
    {
      $request .= "e";
    }

    // GAMES THAT NEED [e] QUERY TO COMPLETE [p]

    if ((strpos($request, "p") !== FALSE) && $type == "bf1942")
    {
      $request .= "e";
    }

//---------------------------------------------------------+

    global $lgsl_fp;

    $lgsl_fp = @fsockopen("udp://$ip", $q_port, $errno, $errstr, 1);

    if (!$lgsl_fp) { return FALSE; }

//---------------------------------------------------------+

    global $lgsl_config;

    if ($lgsl_config['timeout'] = intval($lgsl_config['timeout']))
    {
      stream_set_timeout($lgsl_fp, $lgsl_config['timeout']);
    }
    else
    {
      stream_set_timeout($lgsl_fp, 0, 500000);
    }

    stream_set_blocking($lgsl_fp, TRUE);

//---------------------------------------------------------+

    $server = array();

    if (strpos($request, "e") !== FALSE && !isset($server['e'])) // [e] MUST GO BEFORE [s]
    {
      $server = call_user_func($function_name, $type, "e", $server);

      if (!$server) { @fclose($lgsl_fp); return FALSE; }
    }

    if (strpos($request, "s") !== FALSE && !isset($server['s']))
    {
      $e_wipe = isset($server['e']) ? FALSE : TRUE;
      $server = call_user_func($function_name, $type, "s", $server);

      if (!$server) { @fclose($lgsl_fp); return FALSE; }
      if ($e_wipe)  { unset($server['e']); } // DO NOT RETURN PARTIAL [e] GIVEN BY [s]
    }

    if (strpos($request, "p") !== FALSE && !isset($server['p']))
    {
      $e_wipe = isset($server['e']) ? FALSE : TRUE;

      if (isset($server['s']) && !$server['s']['players']) // SERVER EMPTY SO SKIP REQUESTING PLAYER DETAILS
      {
        $server['p'] = array();
      }
      else
      {
        $server = call_user_func($function_name, $type, "p", $server);
      }

      if (!$server) { @fclose($lgsl_fp); return FALSE; }
      if ($e_wipe)  { unset($server['e']); } // DO NOT RETURN PARTIAL [e] GIVEN BY [p]
    }

    @fclose($lgsl_fp);

//---------------------------------------------------------+

    return $server;
  }}

//------------------------------------------------------------------------------------------------------------+
//------------------------------------------------------------------------------------------------------------+

  if (!function_exists('lgsl_query_01')) {
  function lgsl_query_01($type, $request, $server)
  {
//---------------------------------------------------------+
//  PROTOCOL FOR DEVELOPING WITHOUT USING LIVE SERVERS TO HELP ENSURE RETURNED
//  DATA IS SANITIZED AND THAT LONG SERVER AND PLAYER NAMES ARE HANDLED PROPERLY

    $server['s'] = array ("game"       => "testgame",
                          "name"       => "testservernamethatsoften'really'longandcancontainsymbols<hr />thatwill\"screw\"uphtmlunlessentitied",
                          "map"        => "test_map",
                          "players"    => rand(0,  16),
                          "playersmax" => rand(16, 32),
                          "password"   => rand(0,  1));

//---------------------------------------------------------+

    $server['e'] = array ("testextra1" => time(),
                          "testextra2" => 123,
                          "testextra3" => "alpha",
                          "testextra4" => "",
                          "testextra5" => "<b>Charlie</b>",
                          "testextra6" => "MapCycleGolfHotelIndiaJulietKiloLimaMikeNovemberOscarPapaGolfHotelIndiaJulietKiloLimaMikeNovemberOscarPapa");

//---------------------------------------------------------+

    $server['p']['0']['name']  = "Delta";
    $server['p']['0']['score'] = "12";
    $server['p']['0']['ping']  = "34";

    $server['p']['1']['name']  = "\xc3\xa9\x63\x68\x6f\x20\xd0\xb8-d0\xb3\xd1\x80\xd0\xbe\xd0\xba"; // TEST UTF PLAYER NAMES
    $server['p']['1']['score'] = "56";
    $server['p']['1']['ping']  = "78";

    $server['p']['2']['name']  = "Foxtrot";
    $server['p']['2']['score'] = "90";
    $server['p']['2']['ping']  = "12";

    $server['p']['2']['name']  = "GolfHotelIndiaJulietKiloLimaMikeNovemberOscarPapa"; // TEST LONG PLAYER NAMES
    $server['p']['2']['score'] = "90";
    $server['p']['2']['ping']  = "12";

//---------------------------------------------------------+

    if (rand(0, 10) == 5) { $server['p'] = array(); } // TEST SERVER WITH NO PLAYERS
    if (rand(0, 10) == 5) { return FALSE; } // TEST SERVER GOING OFFLINE

//---------------------------------------------------------+

    return $server;
  }}

//------------------------------------------------------------------------------------------------------------+
//------------------------------------------------------------------------------------------------------------+

  if (!function_exists('lgsl_query_02')) {
  function lgsl_query_02($type, $request, $server)
  {
//---------------------------------------------------------+

    global $lgsl_fp;

    if ($type == "mohaa_" || $type == "mohaab_" || $type == "mohaas_" || $type == "mohpa_")
    {
      fwrite($lgsl_fp, "\xFF\xFF\xFF\xFF\x02getstatus" );
    }
    elseif ($type == "quake2") { fwrite($lgsl_fp, "\xFF\xFF\xFF\xFFstatus"); }
    elseif ($type == "warsow") { fwrite($lgsl_fp, "\xFF\xFF\xFF\xFFgetinfo"); }
    else                       { fwrite($lgsl_fp, "\xFF\xFF\xFF\xFFgetstatus"); }

    $buffer = fread($lgsl_fp, 4096);

    if (!$buffer) { return FALSE; }

//---------------------------------------------------------+

    $part = explode("\n", $buffer);  // SPLIT INTO PARTS: HEADER/SETTINGS/PLAYERS/FOOTER

    array_pop($part);                // REMOVE FOOTER WHICH IS EITHER NULL OR "\challenge\"

    $item = explode("\\", $part[1]); // SPLIT PART INTO ITEMS

    foreach ($item as $item_key => $data_key)
    {
      if (!($item_key % 2)) { continue; }                                     // SKIP EVEN ITEM KEY

      $data_key               = strtolower(lgsl_parse_color($data_key, "1"));
      $server['e'][$data_key] = lgsl_parse_color($item[$item_key + 1], "1");
    }

//---------------------------------------------------------+

    $server['s']['game']       = $server['e']['gamename'];
    $server['s']['name']       = $server['e']['sv_hostname'];
    $server['s']['map']        = $server['e']['mapname'];
    $server['s']['players']    = $part['2'] ? count($part) - 2 : 0;
    $server['s']['playersmax'] = $server['e']['sv_maxclients'];
    $server['s']['password']   = $server['e']['g_needpass'];

    if (!$server['s']['name'])             { $server['s']['name']       = $server['e']['hostname'];   } // HOSTNAME ALTERNATIVE
    if (isset($server['e']['pswrd']))      { $server['s']['password']   = $server['e']['pswrd'];      } // CALL OF DUTY
    if (isset($server['e']['needpass']))   { $server['s']['password']   = $server['e']['needpass'];   } // QUAKE2
    if (isset($server['e']['maxclients'])) { $server['s']['playersmax'] = $server['e']['maxclients']; } // QUAKE2

//---------------------------------------------------------+

    array_shift($part); // REMOVE HEADER AND SHIFT KEYS
    array_shift($part); // REMOVE SETTING AND SHIFT KEYS

    $server['p'] = array();

    foreach ($part as $player_key => $data)
    {
      if (!$data) { continue; }

      if ($type == "warsow") // WARSOW: (SCORE) (PING) "(NAME)" "(TEAM)"
      {
        preg_match("/(.*) (.*) \"(.*)\" (.*)/", $data, $match);

        $server['p'][$player_key]['score'] = $match[1];
        $server['p'][$player_key]['ping']  = $match[2];
        $server['p'][$player_key]['name']  = $match[3];
        $server['p'][$player_key]['team']  = $match[4];
      }
      elseif ($type == "mohaa_" || $type == "mohaab_" || $type == "mohaas_") // MOH: (PING) "(NAME)"
      {
        preg_match("/(.*) \"(.*)\"/", $data, $match);

        $server['p'][$player_key]['ping'] = $match[1];
        $server['p'][$player_key]['name'] = $match[2];
      }
      elseif ($type == "mohpa_") // MOH: (?) (SCORE) (?) (TIME) (?) "(RANK?)" "(NAME)"
      {
        preg_match("/(.*) (.*) (.*) (.*) (.*) \"(.*)\" \"(.*)\"/", $data, $match);

        $server['p'][$player_key]['score']     = $match[2];
        $server['p'][$player_key]['deaths']    = $match[3];
        $server['p'][$player_key]['time']      = lgsl_time($match[4]);
        $server['p'][$player_key]['rank']      = $match[6];
        $server['p'][$player_key]['name']      = $match[7];
      }
      elseif ($type == "sof2") // SOF: (SCORE) (PING) (DEATHS) "(NAME)"
      {
        preg_match("/(.*) (.*) (.*) \"(.*)\"/", $data, $match);

        $server['p'][$player_key]['score']  = $match[1];
        $server['p'][$player_key]['ping']   = $match[2];
        $server['p'][$player_key]['deaths'] = $match[3];
        $server['p'][$player_key]['name']   = $match[4];
      }
      else // OTHER: (SCORE) (PING) "(NAME)"
      {
        preg_match("/(.*) (.*) \"(.*)\"/", $data, $match);

        $server['p'][$player_key]['score'] = $match[1];
        $server['p'][$player_key]['ping']  = $match[2];
        $server['p'][$player_key]['name']  = $match[3];
      }

      $server['p'][$player_key]['name'] = lgsl_parse_color($server['p'][$player_key]['name'], "1");
    }

//---------------------------------------------------------+

    return $server;
  }}

//------------------------------------------------------------------------------------------------------------+
//------------------------------------------------------------------------------------------------------------+

  if (!function_exists('lgsl_query_03')) {
  function lgsl_query_03($type, $request, $server)
  {
//---------------------------------------------------------+

    global $lgsl_fp;

        if ($type    == "cncrenegade") { fwrite($lgsl_fp, "\\status\\"                 ); $server['p'] = array(); }
    elseif ($request == "p")           { fwrite($lgsl_fp, "\\players\\"                ); $server['p'] = array(); }
    else                               { fwrite($lgsl_fp, "\\basic\\\\info\\\\rules\\" ); $server['e'] = array(); }

//---------------------------------------------------------+

    $packet1 = fread($lgsl_fp, 4096);
    if (!$packet1) { return FALSE; }

    preg_match_all("/(queryid\\\(.*)\.1|final\\\)/Us", $packet1, $match);
    if (count(array_unique($match[1])) < 2)
    {
      $packet2 = fread($lgsl_fp, 4096);
      if (!$packet2) { return FALSE; }

      preg_match_all("/(queryid\\\(.*)\.1|queryid\\\(.*)\.2|final\\\)/Us", $packet1.$packet2, $match);
      if (count(array_unique($match[1])) < 3)
      {
        $packet3 = fread($lgsl_fp, 4096);
        if (!$packet3) { return FALSE; }
      }
    }

    $buffer = $packet1.$packet2.$packet3; // JOIN ORDER DOES NOT MATTER

    if ($type == "avp2" && $request == "p") { $buffer = preg_replace("/\\\[0-9]+~/", "\\", $buffer); } // REMOVE ID PREFIX FROM NAMES

    $item = explode("\\", $buffer);     // SPLIT INTO ITEMS

//---------------------------------------------------------+

    foreach ($item as $item_key => $data_key)
    {
      if (!($item_key % 2))       { continue; }                             // SKIP EVEN ITEM KEY
      if ($data_key == "")        { continue; }                             // SKIP BLANK DATA KEY
      if ($data_key == "final")   { continue; }                             // SKIP PACKET STUFF
      if ($data_key == "queryid") { continue; }                             // SKIP PACKET STUFF

      $data_key = strtolower($data_key);                                    // LOWERCASE KEY
      $tmp = explode("_", $data_key, 2);                                    // SPLIT FOR CHECKS

      if (!isset($tmp[1]) || !is_numeric($tmp[1]) || $tmp[0] == "teamname") // EXTRA DATA
      {
        $server['e'][$data_key] = $item[$item_key + 1];
      }
      else                                                                  // PLAYER DATA
      {
            if ($tmp[0] == "player")     { $tmp[0] = "name";  }             // CONVERT KEYS TO STANDARD FIELDS
        elseif ($tmp[0] == "playername") { $tmp[0] = "name";  }
        elseif ($tmp[0] == "frags")      { $tmp[0] = "score"; }
        elseif ($tmp[0] == "ngsecret")   { $tmp[0] = "stats"; }

        $server['p'][$tmp[1]][$tmp[0]] = $item[$item_key + 1];
      }
    }

//---------------------------------------------------------+

    if ($server['e']['mapname'])
    {
      if (!$server['e']['gamename'] || $type == "bf1942") {  $server['s']['game'] = $server['e']['gameid'];      }
      else                                                {  $server['s']['game'] = $server['e']['gamename'];    }

      if (!$server['e']['sv_hostname'])                   {  $server['s']['name'] = $server['e']['hostname'];    }
      else                                                {  $server['s']['name'] = $server['e']['sv_hostname']; }

      $server['s']['name']       = lgsl_parse_color($server['s']['name'], $type);
      $server['s']['map']        = $server['e']['mapname'];
      $server['s']['players']    = $server['e']['numplayers'];
      $server['s']['playersmax'] = $server['e']['maxplayers'];
      $server['s']['password']   = $server['e']['password'];
    }

//---------------------------------------------------------+

    if ($server['p']) // NEED TO RE-SET PLAYER KEYS AS THERE MAY BE GAPS
    {
      $player_tmp = array();
      $player_key = 0;

      foreach ($server['p'] as $player)
      {
        if ($player_key >= $server['s']['players']) { continue; } // SKIP GHOST PLAYERS THAT BF1942 RETURNS
        $player_tmp[$player_key] = $player;
        $player_key++;
      }

      $server['p'] = $player_tmp;
    }

//---------------------------------------------------------+

    return $server;
  }}

//------------------------------------------------------------------------------------------------------------+
//------------------------------------------------------------------------------------------------------------+

  if (!function_exists('lgsl_query_04')) {
  function lgsl_query_04($type, $request, $server)
  {
//---------------------------------------------------------+

    global $lgsl_fp;

    fwrite($lgsl_fp, "REPORT");

    $buffer = fread($lgsl_fp, 4096);

    if (!$buffer) { return FALSE; }

//---------------------------------------------------------+

    $lgsl_ravenshield_key = array("A1" => "playersmax",
                                  "A2" => "tkpenalty",
                                  "B1" => "players",
                                  "B2" => "allowradar",
                                  "D2" => "version",
                                  "E1" => "mapname",
                                  "E2" => "lid",
                                  "F1" => "maptype",
                                  "F2" => "gid",
                                  "G1" => "password",
                                  "G2" => "hostport",
                                  "H1" => "dedicated",
                                  "H2" => "terroristcount",
                                  "I1" => "hostname",
                                  "I2" => "aibackup",
                                  "J1" => "mapcycletypes",
                                  "J2" => "rotatemaponsuccess",
                                  "K1" => "mapcycle",
                                  "K2" => "forcefirstpersonweapons",
                                  "L1" => "players_name",
                                  "L2" => "gamename",
                                  "L3" => "punkbuster",
                                  "M1" => "players_time",
                                  "N1" => "players_ping",
                                  "O1" => "players_score",
                                  "P1" => "queryport",
                                  "Q1" => "rounds",
                                  "R1" => "roundtime",
                                  "S1" => "bombtimer",
                                  "T1" => "bomb",
                                  "W1" => "allowteammatenames",
                                  "X1" => "iserver",
                                  "Y1" => "friendlyfire",
                                  "Z1" => "autobalance");

//---------------------------------------------------------+

    $item = explode("\xB6", $buffer); // SPLIT INTO ITEMS

    foreach ($item as $data_value)
    {
      $tmp = explode(" ", $data_value, 2);
      $data_key = $lgsl_ravenshield_key[$tmp[0]] ? $lgsl_ravenshield_key[$tmp[0]] : $tmp[0]; // CONVERT TO HUMAN FRIENDLY KEY
      $server['e'][$data_key] = trim($tmp[1]); // ALL VALUES NEED TRIMMING
    }

    $server['e']['mapcycle']      = str_replace("/"," ", $server['e']['mapcycle']);      // CONVERT SLASH TO SPACE SO
    $server['e']['mapcycletypes'] = str_replace("/"," ", $server['e']['mapcycletypes']); // LONG LISTS WRAP NATURALLY

//---------------------------------------------------------+

    $server['s']['game']       = $server['e']['gamename'];
    $server['s']['name']       = $server['e']['hostname'];
    $server['s']['map']        = $server['e']['mapname'];
    $server['s']['players']    = $server['e']['players'];
    $server['s']['playersmax'] = $server['e']['playersmax'];
    $server['s']['password']   = $server['e']['password'];

//---------------------------------------------------------+

    $server['p']  = array();

    $player_name  = $server['e']['players_name']  ? explode("/", substr($server['e']['players_name'],  1)) : array(); unset($server['e']['players_name']);
    $player_time  = $server['e']['players_time']  ? explode("/", substr($server['e']['players_time'],  1)) : array(); unset($server['e']['players_time']);
    $player_ping  = $server['e']['players_ping']  ? explode("/", substr($server['e']['players_ping'],  1)) : array(); unset($server['e']['players_ping']);
    $player_score = $server['e']['players_score'] ? explode("/", substr($server['e']['players_score'], 1)) : array(); unset($server['e']['players_score']);

    foreach ($player_name as $key => $name)
    {
      $server['p'][$key]['name']  = $player_name[$key];
      $server['p'][$key]['time']  = $player_time[$key];
      $server['p'][$key]['ping']  = $player_ping[$key];
      $server['p'][$key]['score'] = $player_score[$key];
    }

//---------------------------------------------------------+

    return $server;
  }}

//------------------------------------------------------------------------------------------------------------+
//------------------------------------------------------------------------------------------------------------+

  if (!function_exists('lgsl_query_05')) {
  function lgsl_query_05($type, $request, $server)
  {

//---------------------------------------------------------+
// REFERENCE: http://developer.valvesoftware.com/wiki/Server_Queries

    global $lgsl_fp;

    if ($type == "halflifewon")
    {
          if ($request == "s") { fwrite($lgsl_fp, "\xFF\xFF\xFF\xFFdetails\x00"); }
      elseif ($request == "e") { fwrite($lgsl_fp, "\xFF\xFF\xFF\xFFrules\x00");   }
      elseif ($request == "p") { fwrite($lgsl_fp, "\xFF\xFF\xFF\xFFplayers\x00"); }
    }
    else
    {
      if ($request == "e" || $request == "p")
      {
        fwrite($lgsl_fp, "\xFF\xFF\xFF\xFF\x57");

        $challenge_packet = fread($lgsl_fp, 4096);

        if (!$challenge_packet) { return FALSE; }

        $challenge_code = substr($challenge_packet, 5, 4);
      }

          if ($request == "s") { fwrite($lgsl_fp, "\xFF\xFF\xFF\xFF\x54Source Engine Query\x00"); }
      elseif ($request == "e") { fwrite($lgsl_fp, "\xFF\xFF\xFF\xFF\x56{$challenge_code}");       }
      elseif ($request == "p") { fwrite($lgsl_fp, "\xFF\xFF\xFF\xFF\x55{$challenge_code}");       }
    }

//---------------------------------------------------------+

    $packet_count = 0;
    $packet_bzip2 = FALSE;

    do
    {
      $packet_count ++;
      $packet = fread($lgsl_fp, 4096);

      if (!$packet) { return FALSE; }

      if ($packet[0] != "\xFE") // SINGLE PACKET
      {
        $buffer[0] = $packet;
        break;
      }

      if ((ord($packet[8]) & 0xF) > 1) // HALF-LIFE 1 MULTI-PACKET
      {
        $packet_total = ord($packet[8]) & 0xF; // UPPER NIBBLE
        $packet_index = ord($packet[8]) >> 4;  // LOWER NIBBLE

        $buffer[$packet_index] = substr($packet, 9);
      }
      else
      {
        $packet_total = ord($packet[8]);
        $packet_index = ord($packet[9]);

        if ((ord($packet[7]) & 128)) // SOURCE BZIP2
        {
          $packet_bzip2 = TRUE;
          $buffer[$packet_index] = substr($packet, 18);
        }
        else // SOURCE MULTI-PACKET
        {
          $buffer[$packet_index] = substr($packet, 12);
        }
      }
    }
    while ($packet_count < $packet_total);

    $buffer = implode("", $buffer);

    if ($packet_bzip2) // REQUIRES http://php.net/bzip2
    {
      if (!function_exists("bzdecompress"))
      {
        $server['e']['bzip2'] = "Unavailable";
        return $server;
      }

      $buffer = bzdecompress($buffer);
    }

    $buffer = substr($buffer, 4); // REMOVE PACKET HEADER

//---------------------------------------------------------+

    $response_type = lgsl_cut_byte($buffer, 1);

    if ($response_type == "I") // SOURCE INFO ( HALF-LIFE 2 )
    {
      $server['e']['netcode']     = ord(lgsl_cut_byte($buffer, 1));
      $server['s']['name']        = lgsl_cut_string($buffer);
      $server['s']['map']         = lgsl_cut_string($buffer);
      $server['s']['game']        = lgsl_cut_string($buffer);
      $server['e']['description'] = lgsl_cut_string($buffer);
      $server['e']['appid']       = lgsl_unpack(lgsl_cut_byte($buffer, 2), "S");
      $server['s']['players']     = ord(lgsl_cut_byte($buffer, 1));
      $server['s']['playersmax']  = ord(lgsl_cut_byte($buffer, 1));
      $server['e']['bots']        = ord(lgsl_cut_byte($buffer, 1));
      $server['e']['dedicated']   = lgsl_cut_byte($buffer, 1);
      $server['e']['os']          = lgsl_cut_byte($buffer, 1);
      $server['s']['password']    = ord(lgsl_cut_byte($buffer, 1));
      $server['e']['anticheat']   = ord(lgsl_cut_byte($buffer, 1));
      $server['e']['version']     = lgsl_cut_string($buffer);
    }

    elseif ($response_type == "m") // HALF-LIFE 1 INFO
    {
      $server_ip                  = lgsl_cut_string($buffer);
      $server['s']['name']        = lgsl_cut_string($buffer);
      $server['s']['map']         = lgsl_cut_string($buffer);
      $server['s']['game']        = lgsl_cut_string($buffer);
      $server['e']['description'] = lgsl_cut_string($buffer);
      $server['s']['players']     = ord(lgsl_cut_byte($buffer, 1));
      $server['s']['playersmax']  = ord(lgsl_cut_byte($buffer, 1));
      $server['e']['netcode']     = ord(lgsl_cut_byte($buffer, 1));
      $server['e']['dedicated']   = lgsl_cut_byte($buffer, 1);
      $server['e']['os']          = lgsl_cut_byte($buffer, 1);
      $server['s']['password']    = ord(lgsl_cut_byte($buffer, 1));

      if (ord(lgsl_cut_byte($buffer, 1))) // MOD FIELDS ( OFF FOR SOME HALFLIFEWON-VALVE SERVERS )
      {
        $server['e']['mod_url_info']     = lgsl_cut_string($buffer);
        $server['e']['mod_url_download'] = lgsl_cut_string($buffer);
        $buffer = substr($buffer, 1);
        $server['e']['mod_version']      = lgsl_unpack(lgsl_cut_byte($buffer, 4), "l");
        $server['e']['mod_size']         = lgsl_unpack(lgsl_cut_byte($buffer, 4), "l");
        $server['e']['mod_server_side']  = ord(lgsl_cut_byte($buffer, 1));
        $server['e']['mod_custom_dll']   = ord(lgsl_cut_byte($buffer, 1));
      }

      $server['e']['anticheat'] = ord(lgsl_cut_byte($buffer, 1));
      $server['e']['bots']      = ord(lgsl_cut_byte($buffer, 1));
    }

    elseif ($response_type == "E") // SOURCE AND HALF-LIFE 1 RULES
    {
      $returned = lgsl_unpack(lgsl_cut_byte($buffer, 2), "S");

      while ($buffer)
      {
        $item_key   = strtolower(lgsl_cut_string($buffer));
        $item_value = lgsl_cut_string($buffer);

        $server['e'][$item_key] = $item_value;
      }
    }

    elseif ($response_type == "D") // SOURCE AND HALF-LIFE 1 PLAYERS
    {
      $returned = ord(lgsl_cut_byte($buffer, 1));

      $server['p'] = array();

      $player_key = 0;

      while ($buffer)
      {
        $server['p'][$player_key]['pid']   = ord(lgsl_cut_byte($buffer, 1));
        $server['p'][$player_key]['name']  = lgsl_cut_string($buffer);
        $server['p'][$player_key]['score'] = lgsl_unpack(lgsl_cut_byte($buffer, 4), "l");
        $server['p'][$player_key]['time']  = lgsl_time(lgsl_unpack(lgsl_cut_byte($buffer, 4), "f"));

        $player_key ++;
      }
    }

//---------------------------------------------------------+

    return $server;
  }}

//------------------------------------------------------------------------------------------------------------+
//------------------------------------------------------------------------------------------------------------+

  if (!function_exists('lgsl_query_06')) {
  function lgsl_query_06($type, $request, $server)
  {

//---------------------------------------------------------+

    global $lgsl_fp;

    if ($type == "bf2142" || $type == "stalker" || $type == "crysis")
    {
      fwrite($lgsl_fp, "\xFE\xFD\x09\x21\x21\x21\x21\xFF\xFF\xFF\x01");

      $challenge_packet = fread($lgsl_fp, 4096);

      if (!$challenge_packet) { return FALSE; }

      $challenge_code = substr($challenge_packet, 5, -1); // REMOVE PACKET HEADER AND TRAILING NULL CHARACTER

      // IF CODE IS RETURNED ( SOME STALKER SERVERS RETURN BLANK INDICATING THE CODE IS NOT NEEDED )
      // CONVERT DECIMAL |TO| HEX AS 8 CHARACTER STRING |TO| 4 PAIRS OF HEX |TO| 4 PAIRS OF DECIMAL |TO| 4 PAIRS OF ASCII

      $challenge_code = $challenge_code ? chr($challenge_code >> 24).chr($challenge_code >> 16).chr($challenge_code >> 8).chr($challenge_code >> 0) : "";
    }

    fwrite($lgsl_fp, "\xFE\xFD\x00\x21\x21\x21\x21".$challenge_code."\xFF\xFF\xFF\x01");

//---------------------------------------------------------+

    $packet_check = "/(hostname\\x00|player_\\x00|score_\\x00|ping_\\x00|deaths_\\x00|pid_\\x00|skill_\\x00|team_\\x00|team_t\\x00|score_t\\x00)/Us";

        if ($type == "bf2")     { $packet_check_expected = 10; }
    elseif ($type == "bf2124")  { $packet_check_expected = 10; }
    elseif ($type == "graw")    { $packet_check_expected = 3;  }
    elseif ($type == "stalker") { $packet_check_expected = 6;  }
    elseif ($type == "crysis")  { $packet_check_expected = 1;  }
    else                        { $packet_check_expected = 1;  }

//---------------------------------------------------------+

    $packet1 = fread($lgsl_fp, 4096);                                        // GET FIRST PACKET
    if (!trim($packet1)) { return FALSE; }                                   // DO NOT CONTINUE IF EMPTY

    preg_match_all($packet_check, $packet1, $match);                         // SCAN RETURNED DATA
    if (count(array_unique($match[1])) < $packet_check_expected)             // DATA INCOMPLETE
    {
      $packet2 = fread($lgsl_fp, 4096);                                      // GET SECOND PACKET
      if (!trim($packet2)) { return FALSE; }                                 // DO NOT CONTINUE IF EMPTY

      preg_match_all($packet_check, $packet1.$packet2, $match);              // SCAN RETURNED DATA
      if (count(array_unique($match[1])) < $packet_check_expected)           // DATA INCOMPLETE
      {
        $packet3 = fread($lgsl_fp, 4096);                                    // GET THIRD PACKET
        if (!trim($packet3)) { return FALSE; }                               // DO NOT CONTINUE IF EMPTY

        preg_match_all($packet_check, $packet1.$packet2.$packet3, $match);   // SCAN RETURNED DATA
        if (count(array_unique($match[1])) < $packet_check_expected)         // DATA INCOMPLETE
        {
          return FALSE;                                                      // DO NOT CONTINUE
        }
      }
    }

//---------------------------------------------------------+

    // SWAP PACKETS THAT ARE SENT IN THE WRONG ORDER

    if (strpos($packet3, "hostname\x00") !== FALSE ) { $tmp = $packet3; $packet3 = $packet1; $packet1 = $tmp; }
    if (strpos($packet2, "hostname\x00") !== FALSE ) { $tmp = $packet2; $packet2 = $packet1; $packet1 = $tmp; }
    if (strpos($packet2, "score_t")      !== FALSE ) { $tmp = $packet3; $packet3 = $packet2; $packet2 = $tmp; }

//---------------------------------------------------------+

    // REMOVE INCOMPLETE FIELDS FROM THE END OF MULTI-PACKETS

    if ($packet2 && substr($packet1, -1) != "\x00\x00")
    {
      $tmp = explode("\x00", $packet1); // EXPLODE INTO BITS
      array_pop($tmp);                  // REMOVE x00
      array_pop($tmp);                  // REMOVE INCOMPLETE FIELD
      $tmp = implode("\x00", $tmp);     // RE-JOIN BITS
      $tmp .= "\x00\x00";               // ADD END x00x00
      $packet1 = $tmp;                  // SET PACKET
    }

    if ($packet3 && substr($packet2, -2) != "\x00\x00")
    {
      $tmp = explode("\x00", $packet2); // EXPLODE INTO BITS
      array_pop($tmp);                  // REMOVE x00
      array_pop($tmp);                  // REMOVE INCOMPLETE FIELD
      $tmp = implode("\x00", $tmp);     // RE-JOIN BITS
      $tmp .= "\x00\x00";               // ADD END x00x00
      $packet2 = $tmp;                  // SET PACKET
    }

//---------------------------------------------------------+

    $buffer = $packet1.$packet2.$packet3;                               // JOIN PACKETS
    $buffer = substr($buffer, 16);                                      // REMOVE HEADER
    $buffer = preg_replace("/\\x00\\x00....splitnum/Us",  "", $buffer); // REMOVE MULTI-PACKET HEADERS
    $part   = explode("\x01", $buffer, 2);                              // SPLIT INTO SETTINGS/PLAYERS

//---------------------------------------------------------+

    $item = explode("\x00", $part[0]); // SPLIT PART INTO ITEMS

    foreach ($item as $item_key => $data_key)
    {
      if ($item_key % 2)   { continue; } // SKIP ODD ITEM KEY
      if ($data_key == "") { continue; } // SKIP BLANK DATA KEY

      $data_key               = strtolower($data_key); // LOWERCASE DATA KEY
      $server['e'][$data_key] = $item[$item_key + 1];
    }

//---------------------------------------------------------+

    $server['s']['game']       = $server['e']['gamename'];
    $server['s']['name']       = $server['e']['hostname'];
    $server['s']['map']        = $server['e']['mapname'];
    $server['s']['players']    = $server['e']['numplayers'];
    $server['s']['playersmax'] = $server['e']['maxplayers'];
    $server['s']['password']   = $server['e']['password'];

//---------------------------------------------------------+

    $server['p'] = array();

    if ($server['s']['players'] == 0) { return $server; } // NO PLAYERS

    $player_name      = preg_match_all("/player_\\x00.(.*)\\x00\\x00/Us", $part[1], $match);
    $player_name      = $match[1][0] ? explode( "\x00",       $match[1][0]."\x00".$match[1][1]) : "";
    $player_score     = preg_match_all( "/score_\\x00.(.*)\\x00\\x00/Us", $part[1], $match);
    $player_score     = $match[1][0] ? explode( "\x00",       $match[1][0]."\x00".$match[1][1]) : "";
    $player_ping      = preg_match_all(  "/ping_\\x00.(.*)\\x00\\x00/Us", $part[1], $match);
    $player_ping      = $match[1][0] ? explode( "\x00",       $match[1][0]."\x00".$match[1][1]) : "";
    $player_deaths    = preg_match_all("/deaths_\\x00.(.*)\\x00\\x00/Us", $part[1], $match);
    $player_deaths    = $match[1][0] ? explode( "\x00",       $match[1][0]."\x00".$match[1][1]) : "";
    $player_pid       = preg_match_all(   "/pid_\\x00.(.*)\\x00\\x00/Us", $part[1], $match);
    $player_pid       = $match[1][0] ? explode( "\x00",       $match[1][0]."\x00".$match[1][1]) : "";
    $player_skill     = preg_match_all( "/skill_\\x00.(.*)\\x00\\x00/Us", $part[1], $match);
    $player_skill     = $match[1][0] ? explode( "\x00",       $match[1][0]."\x00".$match[1][1]) : "";
    $player_team      = preg_match_all(  "/team_\\x00.(.*)\\x00\\x00/Us", $part[1], $match);
    $player_team      = $match[1][0] ? explode( "\x00",       $match[1][0]."\x00".$match[1][1]) : "";
    $player_team_name = preg_match_all( "/team_t\\x00.(.*)\\x00\\x00/Us", $part[1], $match);
    $player_team_name = $match[1][0] ? explode( "\x00",       $match[1][0]."\x00".$match[1][1]) : "";

    foreach ($player_name as $key => $name)
    {
      if (!$name) { continue; } // IGNORE EMPTY NAMES

      if ($player_name)   { $server['p'][$key]['name']   = $player_name[$key];   }
      if ($player_score)  { $server['p'][$key]['score']  = $player_score[$key];  }
      if ($player_ping)   { $server['p'][$key]['ping']   = $player_ping[$key];   }
      if ($player_deaths) { $server['p'][$key]['deaths'] = $player_deaths[$key]; }
      if ($player_pid)    { $server['p'][$key]['pid']    = $player_pid[$key];    }
      if ($player_skill)  { $server['p'][$key]['skill']  = $player_skill[$key];  }
      if ($player_team)   { $server['p'][$key]['team']   = $player_team_name ? $player_team_name[$player_team[$key] - 1] : $player_team[$key]; } // -1 BECAUSE: TEAM=1/2 TEAMNAME=0/1
    }

//---------------------------------------------------------+

    return $server;
  }}

//------------------------------------------------------------------------------------------------------------+
//------------------------------------------------------------------------------------------------------------+

  if (!function_exists('lgsl_query_07')) {
  function lgsl_query_07($type, $request, $server)
  {
//---------------------------------------------------------+

    global $lgsl_fp;

    fwrite($lgsl_fp, "\xFF\xFF\xFF\xFFstatus\x00");

    $buffer = fread($lgsl_fp, 4096);

    if (!$buffer) { return FALSE; }

//---------------------------------------------------------+

    $buffer = substr($buffer, 6, -2); // REMOVE PACKET HEADER AND FOOTER
    $part   = explode("\n", $buffer); // SPLIT INTO SETTINGS/PLAYER/PLAYER/PLAYER

//---------------------------------------------------------+

    $item = explode("\\", $part[0]); // SPLIT PART INTO ITEMS

    foreach ($item as $item_key => $data_key)
    {
      if ($item_key % 2) { continue; } // SKIP ODD ITEM KEY

      $data_key               = strtolower($data_key); // LOWERCASE DATA KEY
      $server['e'][$data_key] = $item[$item_key + 1];
    }

//---------------------------------------------------------+

    array_shift($part); // REMOVE SETTINGS AND SHIFT KEYS

    $server['p'] = array();

    foreach ($part as $key => $data)
    {
      preg_match("/(.*) (.*) (.*) (.*) \"(.*)\" \"(.*)\" (.*) (.*)/s", $data, $match); // GREEDY MATCH FOR SKINS

      $server['p'][$key]['pid']         = $match[1];
      $server['p'][$key]['score']       = $match[2];
      $server['p'][$key]['time']        = $match[3];
      $server['p'][$key]['ping']        = $match[4];
      $server['p'][$key]['name']        = lgsl_parse_color($match[5], $type);
      $server['p'][$key]['skin']        = $match[6];
      $server['p'][$key]['skin_top']    = $match[7];
      $server['p'][$key]['skin_bottom'] = $match[8];
    }

//---------------------------------------------------------+

    $server['s']['game']       = $server['e']['*gamedir'];
    $server['s']['name']       = $server['e']['hostname'];
    $server['s']['map']        = $server['e']['map'];
    $server['s']['players']    = $server['p'] ? count($server['p']) : 0;
    $server['s']['playersmax'] = $server['e']['maxclients'];
    $server['s']['password']   = $server['e']['needpass'] > 0 && $server['e']['needpass'] < 4 ? 1 : 0;

//---------------------------------------------------------+

    return $server;
  }}

//------------------------------------------------------------------------------------------------------------+
//------------------------------------------------------------------------------------------------------------+

  if (!function_exists('lgsl_query_08')) {
  function lgsl_query_08($type, $request, $server)
  {
//---------------------------------------------------------+

    global $lgsl_fp;

    fwrite($lgsl_fp, "s");

    $buffer = fread($lgsl_fp, 4096);

    if (!$buffer) { return FALSE; }

//---------------------------------------------------------+

    $buffer = substr($buffer, 4); // REMOVE PACKET HEADER

    $server['e']['gamename']   = lgsl_cut_pascal($buffer, 1, -1);
    $server['e']['hostport']   = lgsl_cut_pascal($buffer, 1, -1);
    $server['s']['name']       = lgsl_parse_color(lgsl_cut_pascal($buffer, 1, -1), $type);
    $server['e']['gamemode']   = lgsl_cut_pascal($buffer, 1, -1);
    $server['s']['map']        = lgsl_cut_pascal($buffer, 1, -1);
    $server['e']['version']    = lgsl_cut_pascal($buffer, 1, -1);
    $server['s']['password']   = lgsl_cut_pascal($buffer, 1, -1);
    $server['s']['players']    = lgsl_cut_pascal($buffer, 1, -1);
    $server['s']['playersmax'] = lgsl_cut_pascal($buffer, 1, -1);

    while ($buffer && $buffer[0] != "\x01")
    {
      $item_key   = strtolower(lgsl_cut_pascal($buffer, 1, -1));
      $item_value = lgsl_cut_pascal($buffer, 1, -1);

      $server['e'][$item_key] = $item_value;
    }

    $buffer = substr($buffer, 1); // REMOVE END MARKER

//---------------------------------------------------------+

    $server['p'] = array();

    while ($buffer)
    {
      $field_character = lgsl_cut_byte($buffer, 1); // BITWISE OF FIELDS ( HARD CODED BELOW BECAUSE GAMES DO NOT USE IT PROPERLY )

      if     ($field_character == "\x3D") { $field_list = array("name",                  "score", "",     "time"); } // FARCRY PLAYERS CONNECTING
      elseif ($type == "farcry")          { $field_list = array("name", "team", "",      "score", "ping", "time"); } // FARCRY PLAYERS JOINED
      elseif ($type == "mta")             { $field_list = array("name", "",     "score", "ping",  ""            ); }
      elseif ($type == "painkiller")      { $field_list = array("name", "",     "skin",  "score", "ping", ""    ); }
      elseif ($type == "soldat")          { $field_list = array("name", "team", "",      "score", "ping", "time"); }

      foreach ($field_list as $item_key)
      {
        $item_value = lgsl_cut_pascal($buffer, 1, -1);

        if (!$item_key) { continue; }

        if ($item_key == "name") { lgsl_parse_color($item_value, $type); }

        $server['p'][$player_key][$item_key] = $item_value;
      }

      $player_key ++;
    }

//---------------------------------------------------------+

    return $server;
  }}

//------------------------------------------------------------------------------------------------------------+
//------------------------------------------------------------------------------------------------------------+

  if (!function_exists('lgsl_query_09')) {
  function lgsl_query_09($type, $request, $server)
  {
//---------------------------------------------------------+

    global $lgsl_fp;

        if ($request == "s" || $request == "e") { fwrite($lgsl_fp, "\xFE\xFD\x00\x21\x21\x21\x21\xFF\x00\x00\x00"); }
    elseif ($request == "p")                    { fwrite($lgsl_fp, "\xFE\xFD\x00\x21\x21\x21\x21\x00\xFF\x00\x00"); }

    $buffer = fread($lgsl_fp, 4096);

    if (!$buffer) { return FALSE; }

//---------------------------------------------------------+

    if ($request == "s" || $request == "e")
    {
      $buffer = substr($buffer, 5, -2); // REMOVE PACKET HEADER AND FOOTER

      $item = explode("\x00", $buffer); // SPLIT INTO ITEMS

      foreach ($item as $item_key => $data_key)
      {
        if ($item_key % 2) { continue; } // SKIP EVEN ITEM KEY

        $data_key               = strtolower($data_key); // LOWERCASE DATA KEY
        $server['e'][$data_key] = $item[$item_key + 1];
      }

      $server['s']['name']       = $server['e']['hostname'];
      $server['s']['map']        = $server['e']['mapname'];
      $server['s']['players']    = $server['e']['numplayers'];
      $server['s']['playersmax'] = $server['e']['maxplayers'];
      $server['s']['password']   = $server['e']['password'];

          if ($server['e']['game_id'])    { $server['s']['game'] = $server['e']['game_id'];    } // BFVIETNAM
      elseif ($server['e']['gsgamename']) { $server['s']['game'] = $server['e']['gsgamename']; } // FEAR
      elseif ($server['e']['gamename'])   { $server['s']['game'] = $server['e']['gamename'];   } // AARMY

      if ($type == "arma")
      {
        $server['s']['map'] = $server['e']['mission'];
      }
      elseif ($type == "vietcong2")
      {
        $server['e']['extinfo_autobalance'] = ord($server['e']['extinfo'][18]) == 2 ? "off" : "on";
        // [ 13 = Vietnam and RPG Mode 19 1b 99 9b ] [ 22 23 = Mounted MG Limit ]
        // [ 27 = Idle Limit ] [ 18 = Auto Balance ] [ 55 = Chat and Blind Spectator 5a 5c da dc ]
      }
    }

//---------------------------------------------------------+

    if ($request == "p")
    {
      $buffer = substr($buffer, 7, -1); // REMOVE HEADER / PLAYER TOTAL / FOOTER

      $server['p'] = array();

      if (strpos($buffer, "\x00\x00") === FALSE) { return $server; } // NO PLAYERS

      $buffer     = explode("\x00\x00",$buffer, 2);            // SPLIT FIELDS FROM ITEMS
      $buffer[0]  = str_replace("_",      "",     $buffer[0]); // REMOVE UNDERSCORES FROM FIELDS
      $buffer[0]  = str_replace("player", "name", $buffer[0]); // CONVERT TO STANDARD
      $field_list = explode("\x00",$buffer[0]);                // SPLIT UP FIELDS
      $item       = explode("\x00",$buffer[1]);                // SPLIT UP ITEMS

      $item_position = 0;
      $item_total    = count($item);
      $player_key    = 0;

      do
      {
        foreach ($field_list as $field)
        {
          $server['p'][$player_key][$field] = $item[$item_position];

          $item_position ++; // MOVE TO NEXT ITEM
        }

        $player_key ++; // MOVE TO NEXT PLAYER
      }
      while ($item_position < $item_total);
    }

    if ($type == "serioussam2") { $server['p'] = array(); } // IGNORE "Unknown Player" THAT SERIOUS SAM 2 RETURNS

//---------------------------------------------------------+

    return $server;
  }}

//------------------------------------------------------------------------------------------------------------+
//------------------------------------------------------------------------------------------------------------+

  if (!function_exists('lgsl_query_10')) {
  function lgsl_query_10($type, $request, $server)
  {
//---------------------------------------------------------+

    global $lgsl_fp;

    if ($type == "quakewars") { fwrite($lgsl_fp, "\xFF\xFFgetInfoEX\xFF"); }
    else                      { fwrite($lgsl_fp, "\xFF\xFFgetInfo\xFF");   }

    $buffer = fread($lgsl_fp, 4096);

    if (!$buffer) { return FALSE; }

//---------------------------------------------------------+

    if ($type == "quakewars") { $buffer = substr($buffer, 33); } // REMOVE PACKET HEADER ( EXTENDED )
    else                      { $buffer = substr($buffer, 23); }

    $buffer = lgsl_parse_color($buffer, "2");

//---------------------------------------------------------+

    while ($buffer && $buffer[0] != "\x00")
    {
      $item_key   = strtolower(lgsl_cut_string($buffer));
      $item_value = lgsl_cut_string($buffer);

      $server['e'][$item_key] = $item_value;
    }

//---------------------------------------------------------+

    $buffer = substr($buffer, 2);

    $server['p'] = array();

    $player_key = 0;

//---------------------------------------------------------+

    if ($type == "quakewars")
    {
      while ($buffer && $buffer[0] != "\x20") // QUAKEWARS: (PID)(PING)(NAME)(TAGPOSITION)(TAG)(BOT)
      {
        $server['p'][$player_key]['pid']  = ord(lgsl_cut_byte($buffer, 1));
        $server['p'][$player_key]['ping'] = lgsl_unpack(lgsl_cut_byte($buffer, 2), "S");
        $player_name                      = lgsl_cut_string($buffer);
        $player_tag_position              = ord(lgsl_cut_byte($buffer, 1));
        $player_tag                       = lgsl_cut_string($buffer);
        $server['p'][$player_key]['bot']  = ord(lgsl_cut_byte($buffer, 1));

            if ($player_tag_position == "")  { $server['p'][$player_key]['name'] = $player_name; }
        elseif ($player_tag_position == "1") { $server['p'][$player_key]['name'] = $player_name." ".$player_tag; }
        else                                 { $server['p'][$player_key]['name'] = $player_tag." ".$player_name; }

        $player_key ++;
      }

      $buffer                      = substr($buffer, 1);
      $server['e']['si_osmask']    = lgsl_unpack(lgsl_cut_byte($buffer, 4), "I");
      $server['e']['si_ranked']    = ord(lgsl_cut_byte($buffer, 1));
      $server['e']['si_timeleft']  = lgsl_time(lgsl_unpack(lgsl_cut_byte($buffer, 4), "I") / 1000);
      $server['e']['si_gamestate'] = ord(lgsl_cut_byte($buffer, 1));
      $buffer                      = substr($buffer, 2);

      $player_key = 0;

      while ($buffer && $buffer[0] != "\x20") // QUAKEWARS EXTENDED: (PID)(XP)(TEAM)(KILLS)(DEATHS)
      {
        $server['p'][$player_key]['pidex']  = ord(lgsl_cut_byte($buffer, 1));
        $server['p'][$player_key]['xp']     = intval(lgsl_unpack(lgsl_cut_byte($buffer, 4), "f"));
        $server['p'][$player_key]['team']   = lgsl_cut_string($buffer);
        $server['p'][$player_key]['score']  = lgsl_unpack(lgsl_cut_byte($buffer, 4), "i");
        $server['p'][$player_key]['deaths'] = lgsl_unpack(lgsl_cut_byte($buffer, 4), "i");
        $player_key ++;
      }
    }

//---------------------------------------------------------+

    elseif ($type == "quake4") // QUAKE4: (PID)(PING)(RATE)(NULLNULL)(NAME)(TAG)
    {
      while ($buffer && $buffer[0] != "\x20")
      {
        $server['p'][$player_key]['pid']  = ord(lgsl_cut_byte($buffer, 1));
        $server['p'][$player_key]['ping'] = lgsl_unpack(lgsl_cut_byte($buffer, 2), "S");
        $server['p'][$player_key]['rate'] = lgsl_unpack(lgsl_cut_byte($buffer, 2), "S");
        $buffer                           = substr($buffer, 2);
        $player_name                      = lgsl_cut_string($buffer);
        $player_tag                       = lgsl_cut_string($buffer);
        $server['p'][$player_key]['name'] = $player_tag ? $player_tag." ".$player_name : $player_name;

        $player_key ++;
      }
    }

//---------------------------------------------------------+

    elseif ($type == "doom3") // DOOM3: (PID)(PING)(RATE)(NULLNULL)(NAME)
    {
      while ($buffer && $buffer[0] != "\x20")
      {
        $server['p'][$player_key]['pid']  = ord(lgsl_cut_byte($buffer, 1));
        $server['p'][$player_key]['ping'] = lgsl_unpack(lgsl_cut_byte($buffer, 2), "S");
        $server['p'][$player_key]['rate'] = lgsl_unpack(lgsl_cut_byte($buffer, 2), "S");
        $buffer                           = substr($buffer, 2);
        $server['p'][$player_key]['name'] = lgsl_cut_string($buffer);

        $player_key ++;
      }
    }

//---------------------------------------------------------+

    $server['s']['game']       = $server['e']['gamename'];
    $server['s']['name']       = $server['e']['si_name'];
    $server['s']['map']        = $server['e']['si_map'];
    $server['s']['players']    = $server['p'] ? count($server['p']) : 0;
    $server['s']['playersmax'] = $server['e']['si_maxplayers'];

    if ($type == "quakewars")
    {
      $server['s']['map']      = str_replace(".entities", "", $server['s']['map']);
      $server['s']['password'] = $server['e']['si_needpass'];
    }
    else
    {
      $server['s']['password'] = $server['e']['si_usepass'];
    }

//---------------------------------------------------------+

    return $server;
  }}

//------------------------------------------------------------------------------------------------------------+
//------------------------------------------------------------------------------------------------------------+

  if (!function_exists('lgsl_query_11')) {
  function lgsl_query_11($type, $request, $server)
  {
//---------------------------------------------------------+
//  REFERENCE: http://wiki.unrealadmin.org/UT3_query_protocol

    global $lgsl_fp;

    fwrite($lgsl_fp, "\xFE\xFD\x09\x21\x21\x21\x21\xFF\xFF\xFF\x01");

    $challenge_packet = fread($lgsl_fp, 4096);

    if (!$challenge_packet) { return FALSE; }

    $challenge_code = substr($challenge_packet, 5, -1); // REMOVE PACKET HEADER AND TRAILING NULL CHARACTER

    // IF CODE IS RETURNED CONVERT DECIMAL |TO| HEX AS 8 CHARACTER STRING |TO| 4 PAIRS OF HEX |TO| 4 PAIRS OF DECIMAL |TO| 4 PAIRS OF ASCII

    $challenge_code = $challenge_code ? chr($challenge_code >> 24).chr($challenge_code >> 16).chr($challenge_code >> 8).chr($challenge_code >> 0) : "";

    fwrite($lgsl_fp, "\xFE\xFD\x00\x21\x21\x21\x21".$challenge_code."\xFF\xFF\xFF\x01");

    $buffer = fread($lgsl_fp, 4096);

    if (!$buffer) { return FALSE; }

//---------------------------------------------------------+

    $lgsl_ut3_key = array("s0"          => "bots_skill",
                          "s1"          => "unknown_1",
                          "s6"          => "pure",
                          "s7"          => "password",
                          "s8"          => "bots_vs",
                          "s9"          => "unknown_2",
                          "s10"         => "forcerespawn",
                          "s11"         => "unknown_3",
                          "s12"         => "unknown_4",
                          "s13"         => "unknown_5",
                          "s14"         => "unknown_6",
                          "s32779"      => "unknown_7",
                          "p268435703"  => "bots",
                          "p268435704"  => "goalscore",
                          "p268435705"  => "timelimit",
                          "p268435717"  => "mutators_default",
                          "p1073741825" => "mapname",
                          "p1073741826" => "gametype",
                          "p1073741827" => "description",
                          "p1073741828" => "mutators_custom");

//---------------------------------------------------------+

    $buffer = substr($buffer, 16);         // REMOVE PACKET HEADER
    $buffer = explode("\x01", $buffer, 2); // SPLIT SETTINGS AND PLAYERS
    $item   = explode("\x00", $buffer[0]); // SPLIT INTO ITEMS

    foreach ($item as $item_key => $data_key)
    {
      if ($item_key % 2)          { continue; } // SKIP ITEM ODD KEY
      if ($data_key == "")        { continue; } // SKIP BLANK DATA KEY
      if ($data_key == "mapname") { continue; } // SKIP AS THIS IS REALLY SCREWED UP ON THE CURRENT UT3 SERVERS

      $data_key = $lgsl_ut3_key[$data_key] ? $lgsl_ut3_key[$data_key] : strtolower($data_key); // CONVERT TO HUMAN FRIENDLY KEY

      $server['e'][$data_key] = $item[$item_key + 1];
    }

//---------------------------------------------------------+

    $tmp = $server['e']['mutators_default'];
           $server['e']['mutators_default'] = "";

    if ($tmp & 1)     { $server['e']['mutators_default'] .= " BigHead";           }
    if ($tmp & 2)     { $server['e']['mutators_default'] .= " FriendlyFire";      }
    if ($tmp & 4)     { $server['e']['mutators_default'] .= " Handicap";          }
    if ($tmp & 8)     { $server['e']['mutators_default'] .= " Instagib";          }
    if ($tmp & 16)    { $server['e']['mutators_default'] .= " LowGrav";           }
    if ($tmp & 64)    { $server['e']['mutators_default'] .= " NoPowerups";        }
    if ($tmp & 128)   { $server['e']['mutators_default'] .= " NoTranslocator";    }
    if ($tmp & 256)   { $server['e']['mutators_default'] .= " Slomo";             }
    if ($tmp & 1024)  { $server['e']['mutators_default'] .= " SpeedFreak";        }
    if ($tmp & 2048)  { $server['e']['mutators_default'] .= " SuperBerserk";      }
    if ($tmp & 8192)  { $server['e']['mutators_default'] .= " WeaponReplacement"; }
    if ($tmp & 16384) { $server['e']['mutators_default'] .= " WeaponsRespawn";    }

    $server['e']['mutators_default'] = str_replace(" ",    " / ", trim($server['e']['mutators_default']));
    $server['e']['mutators_custom']  = str_replace("\x1c", " / ",      $server['e']['mutators_custom']);

//---------------------------------------------------------+

    $server['s']['name']       = $server['e']['hostname'];
    $server['s']['map']        = $server['e']['mapname'];
    $server['s']['players']    = $server['e']['numplayers'];
    $server['s']['playersmax'] = $server['e']['maxplayers'];
    $server['s']['password']   = $server['e']['password'];

//---------------------------------------------------------+

    $server['p'] = array(); // DOES NOT RETURN PLAYER INFORMATION

//---------------------------------------------------------+

    return $server;
  }}

//------------------------------------------------------------------------------------------------------------+
//------------------------------------------------------------------------------------------------------------+

  if (!function_exists('lgsl_query_12')) {
  function lgsl_query_12($type, $request, $server)
  {
//---------------------------------------------------------+

    global $lgsl_fp;

        if ($request == "s") { fwrite($lgsl_fp, "SAMP\x21\x21\x21\x21\x00\x00i"); } // THIS SIMPLIFIED QUERY WORKS BUT INCASE
    elseif ($request == "e") { fwrite($lgsl_fp, "SAMP\x21\x21\x21\x21\x00\x00r"); } // IT BREAKS THE OFFICIAL EXAMPLE USES
    elseif ($request == "p") { fwrite($lgsl_fp, "SAMP\x21\x21\x21\x21\x00\x00d"); } // THE SERVER IP IN HEX INSTEAD OF x21

    $buffer = fread($lgsl_fp, 4096);

    if (!substr($buffer, 0, 4) == "SAMP") { return FALSE; }

//---------------------------------------------------------+

    $buffer = substr($buffer, 11); // REMOVE PACKET HEADER

//---------------------------------------------------------+

    if ($request == "s")
    {
      $server['s']['password']   = ord(lgsl_cut_byte($buffer, 1));
      $server['s']['players']    = ord(lgsl_cut_byte($buffer, 2));
      $server['s']['playersmax'] = ord(lgsl_cut_byte($buffer, 2));
      $server['s']['name']       = lgsl_cut_pascal($buffer, 4);
      $server['e']['gametype']   = lgsl_cut_pascal($buffer, 4);
      $server['s']['map']        = lgsl_cut_pascal($buffer, 4);
    }

//---------------------------------------------------------+

    if ($request == "e")
    {
      $item_total  = ord(lgsl_cut_byte($buffer, 2));

      for ($i=0; $i<$item_total; $i++)
      {
        if (!$buffer) { return FALSE; }

        $data_key   = strtolower(lgsl_cut_pascal($buffer, 1));
        $data_value = lgsl_cut_pascal($buffer, 1);

        $server['e'][$data_key] = $data_value;
      }
    }

//---------------------------------------------------------+

    if ($request == "p")
    {
      $server['p']  = array();
      $player_total = ord(lgsl_cut_byte($buffer, 2));

      for ($i=0; $i<$player_total; $i++)
      {
        if (!$buffer) { return FALSE; }

        $server['p'][$i]['pid']   = ord(lgsl_cut_byte($buffer, 1));
        $server['p'][$i]['name']  = lgsl_cut_pascal($buffer, 1);
        $server['p'][$i]['score'] = lgsl_unpack(lgsl_cut_byte($buffer, 4), "S");
        $server['p'][$i]['ping']  = lgsl_unpack(lgsl_cut_byte($buffer, 4), "S");
      }
    }

//---------------------------------------------------------+

    return $server;
  }}

//------------------------------------------------------------------------------------------------------------+
//------------------------------------------------------------------------------------------------------------+

  if (!function_exists('lgsl_query_13')) {
  function lgsl_query_13($type, $request, $server)
  {
//---------------------------------------------------------+

    global $lgsl_fp;

    fwrite($lgsl_fp, "\x79\x00\x00\x00\x00"); // REQUEST [s]
    fwrite($lgsl_fp, "\x79\x00\x00\x00\x01"); // REQUEST [e]
    fwrite($lgsl_fp, "\x79\x00\x00\x00\x02"); // REQUEST [p]

//---------------------------------------------------------+

    while ($packet = fread($lgsl_fp, 4096))
    {
          if ($packet[4] == "\x00") { $buffer_s .= substr($packet, 5); }
      elseif ($packet[4] == "\x01") { $buffer_e .= substr($packet, 5); }
      elseif ($packet[4] == "\x02") { $buffer_p .= substr($packet, 5); }
    }

    if (!$buffer_s) { return FALSE; }

//---------------------------------------------------------+

    $buffer_s = str_replace("\xa0", "\x20", $buffer_s); // REPLACE SPECIAL SPACE WITH NORMAL SPACE
    $buffer_s = substr($buffer_s, 5);
    $server['e']['hostport']   = lgsl_unpack(lgsl_cut_byte($buffer_s, 4), "S");
    $buffer_s = substr($buffer_s, 4);

    $server['s']['name']       = substr(lgsl_cut_string($buffer_s), 1); // PASCAL NOT USED HERE AS
    $server['s']['map']        = substr(lgsl_cut_string($buffer_s), 1); // ITS SOMETIMES INCORRECT
    $server['e']['gametype']   = substr(lgsl_cut_string($buffer_s), 1);
    $server['s']['players']    = lgsl_unpack(lgsl_cut_byte($buffer_s, 4), "S");
    $server['s']['playersmax'] = lgsl_unpack(lgsl_cut_byte($buffer_s, 4), "S");

//---------------------------------------------------------+

    while ($buffer_e && $buffer_e[0] != "\x00")
    {
      $item_key   = strtolower(lgsl_cut_pascal($buffer_e, 1, -1, 1));
      $item_value = lgsl_cut_pascal($buffer_e, 1, -1, 1);

      $item_key   = str_replace("\x1B\xFF\xFF\x01", "", $item_key);   // REMOVE MOD
      $item_value = str_replace("\x1B\xFF\xFF\x01", "", $item_value); // GARBAGE

      $server['e'][$item_key] = $item_value;
    }

//---------------------------------------------------------+

    $server['p'] = array();

    $player_key = 0;

    while ($buffer_p && $buffer_p[0] != "\x00")
    {
      $server['p'][$player_key]['pid']   = lgsl_unpack(lgsl_cut_byte($buffer_p, 4), "S");
      $server['p'][$player_key]['name']  = lgsl_cut_pascal($buffer_p, 1, -1, 1);
      $server['p'][$player_key]['ping']  = lgsl_unpack(lgsl_cut_byte($buffer_p, 4), "S");
      $server['p'][$player_key]['score'] = lgsl_unpack(lgsl_cut_byte($buffer_p, 4), "s");
      $tmp                               = lgsl_cut_byte($buffer_p, 4);

          if ($tmp[3] == "\x20") { $server['p'][$player_key]['team'] = 1; }
      elseif ($tmp[3] == "\x40") { $server['p'][$player_key]['team'] = 2; }

      $player_key ++;
    }

//---------------------------------------------------------+

    return $server;
  }}

//------------------------------------------------------------------------------------------------------------+
//------------------------------------------------------------------------------------------------------------+

  if (!function_exists('lgsl_query_14')) {
  function lgsl_query_14($type, $request, $server)
  {
//---------------------------------------------------------+

    global $lgsl_fp;

    fwrite($lgsl_fp, "\x00\x02\xf1\x26\x01\x26\xf0\x90\xa6\xf0\x26\x57\x4e\xac\xa0\xec\xf8\x68\xe4\x8d\x21");

    $buffer = fread($lgsl_fp, 4096);

    if (!$buffer) { return FALSE; }

//---------------------------------------------------------+

    $buffer                    = substr($buffer, 4);
    $server_name_length        = lgsl_unpack(lgsl_cut_byte($buffer, 4), "i") - 90;
    $buffer                    = substr($buffer, 1);
    $server['s']['password']   = ord(lgsl_cut_byte($buffer, 1));
    $buffer                    = substr($buffer, 10);
    $server['s']['playersmax'] = lgsl_unpack(lgsl_cut_byte($buffer, 4), "I") - 1;
    $buffer                    = substr($buffer, 4);
    $server['s']['players']    = lgsl_unpack(lgsl_cut_byte($buffer, 4), "I") - 1;
    $buffer                    = substr($buffer, 60);
    $server['s']['name']       = str_replace("\x00", "", lgsl_cut_byte($buffer, $server_name_length));
    $buffer                    = substr($buffer, 2);
    $server['e']['unknown_1']  = lgsl_cut_string($buffer, ":");
    $server['e']['unknown_2']  = lgsl_cut_string($buffer, ":");
    $server['e']['unknown_3']  = lgsl_cut_string($buffer, ":");
    $server['e']['unknown_4']  = lgsl_cut_string($buffer, ":");
    $server['e']['unknown_5']  = lgsl_cut_string($buffer, ":");
    $server['e']['motd']       = str_replace("\x00", "", $buffer);
    $server['s']['map']        = "freelancer";

    $server['p'] = array(); // DOES NOT RETURN PLAYER INFORMATION

//---------------------------------------------------------+

    return $server;
  }}

//------------------------------------------------------------------------------------------------------------+
//------------------------------------------------------------------------------------------------------------+

  if (!function_exists('lgsl_query_15')) {
  function lgsl_query_15($type, $request, $server)
  {
//---------------------------------------------------------+

    global $lgsl_fp;

    fwrite($lgsl_fp, "GTR2_Direct_IP_Search\x00");

    $buffer = fread($lgsl_fp, 4096);

    if (!$buffer) { return FALSE; }

//---------------------------------------------------------+

    $buffer = str_replace("\xFE", "\xFF", $buffer);
    $buffer = explode("\xFF", $buffer);

    $server['s']['name']       = $buffer[3];
    $server['s']['game']       = $buffer[7];
    $server['e']['version']    = $buffer[11];
    $server['e']['hostport']   = $buffer[15];
    $server['s']['map']        = $buffer[19];
    $server['s']['players']    = $buffer[25];
    $server['s']['playersmax'] = $buffer[27];
    $server['e']['mode']       = $buffer[31];

    $server['p'] = array(); // DOES NOT RETURN PLAYER INFORMATION

//---------------------------------------------------------+

    return $server;
  }}

//------------------------------------------------------------------------------------------------------------+
//------------------------------------------------------------------------------------------------------------+

  if (!function_exists('lgsl_query_16')) {
  function lgsl_query_16($type, $request, $server)
  {
//---------------------------------------------------------+
//  REFERENCE:
//  http://www.planetpointy.co.uk/software/rfactorsspy.shtml
//  http://users.pandora.be/viperius/mUtil/
//  USES FIXED DATA POSITIONS WITH RANDOM CHARACTERS FILLING THE GAPS

    global $lgsl_fp;

    fwrite($lgsl_fp, "rF_S");

    $buffer = fread($lgsl_fp, 4096);

    if (!$buffer) { return FALSE; }

//---------------------------------------------------------+

//  $server['e']['gamename']         = lgsl_get_string($buffer);
    $buffer = substr($buffer, 8);
//  $server['e']['fullupdate']       = lgsl_unpack($buffer[0], "C");
    $server['e']['region']           = lgsl_unpack($buffer[1] .$buffer[2],  "S");
//  $server['e']['ip']               = ($buffer[3] .$buffer[4].$buffer[5].$buffer[6]); // UNSIGNED LONG
//  $server['e']['size']             = lgsl_unpack($buffer[7] .$buffer[8],  "S");
    $server['e']['version']          = lgsl_unpack($buffer[9] .$buffer[10], "S");
//  $server['e']['version_racecast'] = lgsl_unpack($buffer[11].$buffer[12], "S");
    $server['e']['hostport']         = lgsl_unpack($buffer[13].$buffer[14], "S");
//  $server['e']['queryport']        = lgsl_unpack($buffer[15].$buffer[16], "S");
    $buffer = substr($buffer, 17);
    $server['s']['game']             = lgsl_get_string($buffer);
    $buffer = substr($buffer, 20);
    $server['s']['name']             = lgsl_get_string($buffer);
    $buffer = substr($buffer, 28);
    $server['s']['map']              = lgsl_get_string($buffer);
    $buffer = substr($buffer, 32);
    $server['e']['motd']             = lgsl_get_string($buffer);
    $buffer = substr($buffer, 96);
    $server['e']['packed_aids']      = lgsl_unpack($buffer[0].$buffer[1], "S");
//  $server['e']['ping']             = lgsl_unpack($buffer[2].$buffer[3], "S");
    $server['e']['packed_flags']     = lgsl_unpack($buffer[4],  "C");
    $server['e']['rate']             = lgsl_unpack($buffer[5],  "C");
    $server['s']['players']          = lgsl_unpack($buffer[6],  "C");
    $server['s']['playersmax']       = lgsl_unpack($buffer[7],  "C");
    $server['e']['bots']             = lgsl_unpack($buffer[8],  "C");
    $server['e']['packed_special']   = lgsl_unpack($buffer[9],  "C");
    $server['e']['damage']           = lgsl_unpack($buffer[10], "C");
    $server['e']['packed_rules']     = lgsl_unpack($buffer[11].$buffer[12], "S");
    $server['e']['credits1']         = lgsl_unpack($buffer[13], "C");
    $server['e']['credits2']         = lgsl_unpack($buffer[14].$buffer[15], "S");
    $server['e']['time']   = lgsl_time(lgsl_unpack($buffer[16].$buffer[17], "S"));
    $server['e']['laps']             = lgsl_unpack($buffer[18].$buffer[19], "s") / 16;
    $buffer = substr($buffer, 23);
    $server['e']['vehicles']         = lgsl_get_string($buffer);

//---------------------------------------------------------+

    $server['s']['password']    = ($server['e']['packed_special'] & 2)  ? 1 : 0;
    $server['e']['racecast']    = ($server['e']['packed_special'] & 4)  ? 1 : 0;
    $server['e']['fixedsetups'] = ($server['e']['packed_special'] & 16) ? 1 : 0;

    $tmp = $server['e']['packed_aids'];
    if ($tmp & 1)    { $server['e']['aids'] .= " TractionControl";  }
    if ($tmp & 2)    { $server['e']['aids'] .= " AntiLockBraking";  }
    if ($tmp & 4)    { $server['e']['aids'] .= " StabilityControl"; }
    if ($tmp & 8)    { $server['e']['aids'] .= " AutoShifting";     }
    if ($tmp & 16)   { $server['e']['aids'] .= " AutoClutch";       }
    if ($tmp & 32)   { $server['e']['aids'] .= " Invulnerability";  }
    if ($tmp & 64)   { $server['e']['aids'] .= " OppositeLock";     }
    if ($tmp & 128)  { $server['e']['aids'] .= " SteeringHelp";     }
    if ($tmp & 256)  { $server['e']['aids'] .= " BrakingHelp";      }
    if ($tmp & 512)  { $server['e']['aids'] .= " SpinRecovery";     }
    if ($tmp & 1024) { $server['e']['aids'] .= " AutoPitstop";      }

    $server['e']['aids']     = str_replace(" ", " / ", trim($server['e']['aids']));
    $server['e']['vehicles'] = str_replace("|", " / ", $server['e']['vehicles']);

    unset($server['e']['packed_aids']);
    unset($server['e']['packed_flags']);
    unset($server['e']['packed_special']);
    unset($server['e']['packed_rules']);

//---------------------------------------------------------+

    $server['p'] = array(); // DOES NOT RETURN PLAYER INFORMATION

//---------------------------------------------------------+

    return $server;
  }}


//------------------------------------------------------------------------------------------------------------+
//------------------------------------------------------------------------------------------------------------+

  if (!function_exists('lgsl_query_17')) {
  function lgsl_query_17($type, $request, $server)
  {
//---------------------------------------------------------+
//  REFERENCE: http://masterserver.savage.s2games.com/

    global $lgsl_fp;

    fwrite($lgsl_fp, "\x9e\x4c\x23\x00\x00\xce\x21\x21\x21\x21");

    $buffer = fread($lgsl_fp, 4096);

    if (!$buffer) { return FALSE; }

//---------------------------------------------------------+

    $buffer = substr($buffer, 12); // REMOVE PACKET HEADER

    while ($data_key = strtolower(lgsl_cut_string($buffer, "\xFE")))
    {
      if ($data_key == "players") { break; }

      $data_value = lgsl_cut_string($buffer, "\xFF");

      $server['e'][$data_key] = $data_value;
    }

    $server['s']['name']       = lgsl_parse_color($server['e']['name'], $type);
    $server['s']['map']        = $server['e']['world'];
    $server['s']['players']    = $server['e']['cnum'];
    $server['s']['playersmax'] = $server['e']['cmax'];
    $server['s']['password']   = $server['e']['pass'];

//---------------------------------------------------------+

    $team_list   = array("skip", $server['e']['race1'], $server['e']['race2'], "spectator");
    $server['p'] = array();
    $player_key  = 0;

    foreach ($team_list as $team)
    {
      while ($tmp = strtolower(lgsl_cut_string($buffer, "\x0a")))
      {
        if ($tmp[0] != "\x20") { break; }

        $server['p'][$player_key]['name'] = lgsl_parse_color(substr($tmp, 1), $type);
        $server['p'][$player_key]['team'] = $team;

        $player_key++;
      }
    }

//---------------------------------------------------------+

    return $server;
  }}

//------------------------------------------------------------------------------------------------------------+
//------------------------------------------------------------------------------------------------------------+

  if (!function_exists('lgsl_query_18')) {
  function lgsl_query_18($type, $request, $server)
  {
//---------------------------------------------------------+
// REFERENCE: http://masterserver.savage2.s2games.com/

    global $lgsl_fp;

    fwrite($lgsl_fp, "\x01");

    $buffer = fread($lgsl_fp, 4096);

    if (!$buffer) { return FALSE; }

//---------------------------------------------------------+

    $buffer = substr($buffer, 12); // REMOVE PACKET HEADER

    $server['s']['name']            = lgsl_cut_string($buffer);
    $server['s']['players']         = ord(lgsl_cut_byte($buffer, 1));
    $server['s']['playersmax']      = ord(lgsl_cut_byte($buffer, 1));
    $server['e']['time']            = lgsl_cut_string($buffer);
    $server['s']['map']             = lgsl_cut_string($buffer);
    $server['e']['nextmap']         = lgsl_cut_string($buffer);
    $server['e']['location']        = lgsl_cut_string($buffer);
    $server['e']['minimum_players'] = ord(lgsl_cut_string($buffer));
    $server['e']['gametype']        = lgsl_cut_string($buffer);
    $server['e']['version']         = lgsl_cut_string($buffer);
    $server['e']['minimum_level']   = ord(lgsl_cut_byte($buffer, 1));

    $server['p'] = array(); // DOES NOT RETURN PLAYER INFORMATION

//---------------------------------------------------------+

    return $server;
  }}

//------------------------------------------------------------------------------------------------------------+
//------------------------------------------------------------------------------------------------------------+

  if (!function_exists('lgsl_query_19')) {
  function lgsl_query_19($type, $request, $server)
  {
//---------------------------------------------------------+

    global $lgsl_fp;

    fwrite($lgsl_fp, "\xc0\xde\xf1\x11\x42\x06\x00\xf5\x03\x21\x21\x21\x21");

    $buffer = fread($lgsl_fp, 4096);

    if (!$buffer) { return FALSE; }

//---------------------------------------------------------+

    $buffer = substr($buffer, 25); // REMOVE PACKET HEADER

    $server['s']['name']       = lgsl_get_string(lgsl_cut_pascal($buffer, 4, 3, -3));
    $server['s']['map']        = lgsl_get_string(lgsl_cut_pascal($buffer, 4, 3, -3));
    $server['e']['nextmap']    = lgsl_get_string(lgsl_cut_pascal($buffer, 4, 3, -3));
    $server['e']['gametype']   = lgsl_get_string(lgsl_cut_pascal($buffer, 4, 3, -3));

    $buffer = substr($buffer, 1);

    $server['s']['password']   = ord(lgsl_cut_byte($buffer, 1));
    $server['s']['playersmax'] = ord(lgsl_cut_byte($buffer, 4));
    $server['s']['players']    = ord(lgsl_cut_byte($buffer, 4));

//---------------------------------------------------------+

    $server['p'] = array();

    for ($player_key = 0; $player_key < $server['s']['players']; $player_key++)
    {
     $server['p'][$player_key]['name'] = lgsl_get_string(lgsl_cut_pascal($buffer, 4, 3, -3));
    }

//---------------------------------------------------------+

    $buffer = substr($buffer, 17);

    $server['e']['version']    = lgsl_get_string(lgsl_cut_pascal($buffer, 4, 3, -3));
    $server['e']['mods']       = lgsl_get_string(lgsl_cut_pascal($buffer, 4, 3, -3));
    $server['e']['dedicated']  = ord(lgsl_cut_byte($buffer, 1));
    $server['e']['time']       = lgsl_time(lgsl_unpack(lgsl_cut_byte($buffer, 4), "f"));
    $server['e']['status']     = ord(lgsl_cut_byte($buffer, 4));
    $server['e']['gamemode']   = ord(lgsl_cut_byte($buffer, 4));
    $server['e']['motd']       = lgsl_get_string(lgsl_cut_pascal($buffer, 4, 3, -3));
    $server['e']['respawns']   = ord(lgsl_cut_byte($buffer, 4));
    $server['e']['time_limit'] = lgsl_time(lgsl_unpack(lgsl_cut_byte($buffer, 4), "f"));
    $server['e']['voting']     = ord(lgsl_cut_byte($buffer, 4));

    $buffer = substr($buffer, 2);

//---------------------------------------------------------+

    for ($player_key = 0; $player_key < $server['s']['players']; $player_key++)
    {
     $server['p'][$player_key]['team'] = ord(lgsl_cut_byte($buffer, 4));

     $unknown = ord(lgsl_cut_byte($buffer, 1));
    }

//---------------------------------------------------------+

    $buffer = substr($buffer, 7);

    $server['e']['platoon_1_color']   = ord(lgsl_cut_byte($buffer, 8));
    $server['e']['platoon_2_color']   = ord(lgsl_cut_byte($buffer, 8));
    $server['e']['platoon_3_color']   = ord(lgsl_cut_byte($buffer, 8));
    $server['e']['platoon_4_color']   = ord(lgsl_cut_byte($buffer, 8));
    $server['e']['timer_on']          = ord(lgsl_cut_byte($buffer, 1));
    $server['e']['timer_time']        = lgsl_time(lgsl_unpack(lgsl_cut_byte($buffer, 4), "f"));
    $server['e']['time_debriefing']   = lgsl_time(lgsl_unpack(lgsl_cut_byte($buffer, 4), "f"));
    $server['e']['time_respawn_min']  = lgsl_time(lgsl_unpack(lgsl_cut_byte($buffer, 4), "f"));
    $server['e']['time_respawn_max']  = lgsl_time(lgsl_unpack(lgsl_cut_byte($buffer, 4), "f"));
    $server['e']['time_respawn_safe'] = lgsl_time(lgsl_unpack(lgsl_cut_byte($buffer, 4), "f"));
    $server['e']['difficulty']        = ord(lgsl_cut_byte($buffer, 4));
    $server['e']['respawn_total']     = ord(lgsl_cut_byte($buffer, 4));
    $server['e']['random_insertions'] = ord(lgsl_cut_byte($buffer, 1));
    $server['e']['spectators']        = ord(lgsl_cut_byte($buffer, 1));
    $server['e']['arcademode']        = ord(lgsl_cut_byte($buffer, 1));
    $server['e']['ai_backup']         = ord(lgsl_cut_byte($buffer, 1));
    $server['e']['random_teams']      = ord(lgsl_cut_byte($buffer, 1));
    $server['e']['time_starting']     = lgsl_time(lgsl_unpack(lgsl_cut_byte($buffer, 4), "f"));
    $server['e']['identify_friends']  = ord(lgsl_cut_byte($buffer, 1));
    $server['e']['identify_threats']  = ord(lgsl_cut_byte($buffer, 1));

    $buffer = substr($buffer, 5);

    $server['e']['restrictions']      = lgsl_get_string(lgsl_cut_pascal($buffer, 4, 3, -3));

//---------------------------------------------------------+

    switch ($server['e']['status'])
    {
      case 3: $server['e']['status'] = "Joining"; break;
      case 4: $server['e']['status'] = "Joining"; break;
      case 5: $server['e']['status'] = "Joining"; break;
    }

    switch ($server['e']['gamemode'])
    {
      case 2: $server['e']['gamemode'] = "Co-Op"; break;
      case 3: $server['e']['gamemode'] = "Solo";  break;
      case 4: $server['e']['gamemode'] = "Team";  break;
    }

    switch ($server['e']['respawns'])
    {
      case 0: $server['e']['respawns'] = "None";       break;
      case 1: $server['e']['respawns'] = "Individual"; break;
      case 2: $server['e']['respawns'] = "Team";       break;
      case 3: $server['e']['respawns'] = "Infinite";   break;
    }

    switch ($server['e']['difficulty'])
    {
      case 0: $server['e']['difficulty'] = "Recruit"; break;
      case 1: $server['e']['difficulty'] = "Veteran"; break;
      case 2: $server['e']['difficulty'] = "Elite";   break;
    }

//---------------------------------------------------------+

    return $server;
  }}

//------------------------------------------------------------------------------------------------------------+
//------------------------------------------------------------------------------------------------------------+

  if (!function_exists('lgsl_query_20')) {
  function lgsl_query_20($type, $request, $server)
  {
//---------------------------------------------------------+

    global $lgsl_fp;

    fwrite($lgsl_fp, "\xFF\xFF\xFF\xFFFLSQ");

    $buffer = fread($lgsl_fp, 4096);

    if (!$buffer) { return FALSE; }

//---------------------------------------------------------+

    $buffer = substr($buffer, 6); // REMOVE PACKET HEADER

    $server['s']['name']        = lgsl_cut_string($buffer);
    $server['s']['map']         = lgsl_cut_string($buffer);
    $server['s']['game']        = lgsl_cut_string($buffer);
    $server['e']['gametype']    = lgsl_cut_string($buffer);
    $server['e']['description'] = lgsl_cut_string($buffer);
    $server['e']['version']     = lgsl_cut_string($buffer);
    $server['e']['hostport']    = lgsl_unpack(lgsl_cut_byte($buffer, 2), "n");
    $server['s']['players']     = lgsl_unpack(lgsl_cut_byte($buffer, 1), "C");
    $server['s']['playersmax']  = lgsl_unpack(lgsl_cut_byte($buffer, 1), "C");
    $server['e']['dedicated']   = lgsl_cut_byte($buffer, 1);
    $server['e']['os']          = lgsl_cut_byte($buffer, 1);
    $server['s']['password']    = lgsl_unpack(lgsl_cut_byte($buffer, 1), "C");
    $server['e']['anticheat']   = lgsl_unpack(lgsl_cut_byte($buffer, 1), "C");
    $server['e']['cpu_load']    = round(3.03 * lgsl_unpack(lgsl_cut_byte($buffer, 1), "C"))."%";
    $server['e']['round']       = lgsl_unpack(lgsl_cut_byte($buffer, 1), "C");
    $server['e']['roundsmax']   = lgsl_unpack(lgsl_cut_byte($buffer, 1), "C");
    $server['e']['timeleft']    = lgsl_time(lgsl_unpack(lgsl_cut_byte($buffer, 2), "S") / 250);

//---------------------------------------------------------+

    $server['p'] = array(); // DOES NOT RETURN PLAYER INFORMATION

//---------------------------------------------------------+

    return $server;
  }}

//------------------------------------------------------------------------------------------------------------+
//------------------------------------------------------------------------------------------------------------+

  if (!function_exists('lgsl_query_feed')) {
  function lgsl_query_feed($ip, $q_port, $c_port, $s_port, $type, $request, $lgsl_feed_method, $lgsl_feed_url)
  {
//---------------------------------------------------------+

    $host = parse_url($lgsl_feed_url);

    if (!$host['path']) { echo "LGSL FEED PROBLEM: INVALID URL"; exit; }

    $host['path'] .= "?ip={$ip}&q_port={$q_port}&c_port={$c_port}&s_port={$s_port}&type={$type}&request={$request}";

    $referrer = preg_replace("/(.*):\/\//i", "", $_SERVER['SERVER_NAME']);
    $referrer = $referrer."/".$_SERVER['PHP_SELF'];
    $referrer = str_replace("//", "/", $referrer);
    $referrer = "http://{$referrer}?{$_SERVER['QUERY_STRING']}";

//---------------------------------------------------------+

    if (function_exists('curl_init') && function_exists('curl_setopt') && function_exists('curl_exec') && $lgsl_feed_method == 1)
    {
      unset($lgsl_curl); $lgsl_curl = curl_init();

      curl_setopt($lgsl_curl, CURLOPT_HEADER, 0);
      curl_setopt($lgsl_curl, CURLOPT_HTTPGET, 1);
      curl_setopt($lgsl_curl, CURLOPT_TIMEOUT, 6);
      curl_setopt($lgsl_curl, CURLOPT_ENCODING, "");
      curl_setopt($lgsl_curl, CURLOPT_FRESH_CONNECT, 1);
      curl_setopt($lgsl_curl, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($lgsl_curl, CURLOPT_CONNECTTIMEOUT, 6);
      curl_setopt($lgsl_curl, CURLOPT_REFERER, $referrer);
      curl_setopt($lgsl_curl, CURLOPT_URL, $host['host'].$host['path']);

      $response = curl_exec($lgsl_curl);

      if (curl_error($lgsl_curl))
      {
        $lgsl_feed_error = 1;
      }

      curl_close($lgsl_curl);
    }

//---------------------------------------------------------+

    elseif (function_exists('fsockopen'))
    {
      $fp = @fsockopen($host['host'], "80", $errno, $errstr, 6);

      if (!$fp)
      {
        $lgsl_feed_error = 1;
      }
      else
      {
        stream_set_timeout($fp, 6, 0);
        stream_set_blocking($fp, TRUE);

        unset($request);
        unset($response);

        $request .= "GET $host[path] HTTP/1.0\r\n";
        $request .= "Host: $host[host]\r\n";
        $request .= "User-Agent: Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.2.1) Gecko/20021204\r\n";
        $request .= "Accept: text/xml,application/xml,application/xhtml+xml,";
        $request .= "text/html;q=0.9,text/plain;q=0.8,video/x-mng,image/png,";
        $request .= "image/jpeg,image/gif;q=0.2,text/css,*/*;q=0.1\r\n";
        $request .= "Accept-Language: en-us, en;q=0.50\r\n";
        $request .= "Accept-Encoding: \r\n";
        $request .= "Accept-Charset: ISO-8859-1, utf-8;q=0.66, *;q=0.66\r\n";
        $request .= "Referer: $referrer\r\n";
        $request .= "Cache-Control: max-age=0\r\n";
        $request .= "Connection: Close\r\n\r\n";

        fwrite($fp, $request);

        while (!feof($fp))
        {
          $response .= fread($fp, 4096);
        }

        fclose($fp);
      }
    }

//---------------------------------------------------------+

    else
    {
      echo "LGSL FEED PROBLEM: NO CURL OR FSOCKOPEN SUPPORT"; exit;
    }

//---------------------------------------------------------+

    if (!$lgsl_feed_error && strpos($response, "_SLGSLF_") === FALSE)
    {
      $lgsl_feed_error = 2;
    }

    if (!$lgsl_feed_error)
    {
      $response = explode("_SLGSLF_", $response);
      $server   = unserialize($response[1]);

      if (!$server)
      {
        $lgsl_feed_error = 3;
      }
    }

//---------------------------------------------------------+

    if ($lgsl_feed_error == "1")
    {
      // CONNECTION PROBLEM - FEED MAYBE TEMPORARLY OFFLINE

      $server['s'] = array();
      $server['e'] = array();
      $server['p'] = array();

      $server['s']['name'] = "FEED PROBLEM";
      $server['s']['map']  = "FEED PROBLEM";
    }
    elseif ($lgsl_feed_error == "2")
    {
      // NO FEED DATA - MAYBE WRONG FEED URL

      echo "<div style='width:100%;overflow:auto'>
            FEED MISSING FROM: $host[host]$host[path] RETURNED: ".lgsl_string_html($response)." :END
            </div>";
      exit;
    }
    elseif ($lgsl_feed_error == "3")
    {
      // UNABLE TO UNPACK FEED DATA - MAYBE ERRORS ON FEED

      echo "<div style='width:100%;overflow:auto'>
            FEED CORRUPTION FROM: $host[host]$host[path] RETURNED: ".lgsl_string_html($response)." :END
            </div>";
      exit;
    }
    elseif ($lgsl_feed_error == "4")
    {
      // UNABLE TO UNPACK FEED DATA - MAYBE ERRORS ON FEED

      echo "<div style='width:100%;overflow:auto'>
            FEED CORRUPTION FROM: $host[host]$host[path] RETURNED: ".lgsl_string_html($response)." :END
            </div>";
      exit;
    }

//---------------------------------------------------------+

    // PREVENT FEED CACHE MAKING SERVER LOOK LIKE ITS ONLINE

    if (!$server['b']['status'])
    {
      return FALSE;
    }

//---------------------------------------------------------+

    return $server;
  }}

//------------------------------------------------------------------------------------------------------------+
//------------------------------------------------------------------------------------------------------------+

  if (!function_exists('lgsl_parse_color')) {
  function lgsl_parse_color($string, $type)
  {
    switch($type)
    {
      case "1":
        $string = preg_replace("/\^./", "", $string);
      break;

      case "2":
        $string = preg_replace("/\^[\x20-\x7E]/", "", $string);
      break;

      case "swat4":
        $string = preg_replace("/\[c=......\]/Usi", "", $string);
      break;

      case "farcry":
        $string = preg_replace("/\\$\d/", "", $string);
      break;

      case "painkiller":
        $string = preg_replace("/#./", "", $string);
      break;

      case "savage1":
        $string = preg_replace("/\^[a-z]/",    "", $string);
        $string = preg_replace("/\^[0-9]+/",   "", $string);
        $string = preg_replace("/ lan .*\^/U", "", $string);
        $string = preg_replace("/ con .*\^/U", "", $string);
      break;

      case "quakeworld":
        $string_length = strlen($string);
        for ($char_pos=0; $char_pos<$string_length; $char_pos++)
        {
          $char = ord($string[$char_pos]);
          if ($char > 141) { $char = chr($char - 128); }
          if ($char < 32)  { $char = chr($char + 30);  }
          $string[$char_pos] = chr($char);
        }
      break;

    }
    return $string;
  }}

//---------------------------------------------------------+

  if (!function_exists('lgsl_time')) {
  function lgsl_time($seconds)
  {
    if ($seconds < 0) { return ""; }

    $h = intval(intval($seconds) / 3600);
    $m = intval(($seconds / 60) % 60);
    $s = intval($seconds % 60);

    $h = str_pad($h, "2", "0", STR_PAD_LEFT);
    $m = str_pad($m, "2", "0", STR_PAD_LEFT);
    $s = str_pad($s, "2", "0", STR_PAD_LEFT);

    return "{$h}:{$m}:{$s}";
  }}

//---------------------------------------------------------+

  if (!function_exists('lgsl_unpack')) {
  function lgsl_unpack($string, $format)
  {
    list(,$string) = unpack($format, $string);

    return $string;
  }}

//---------------------------------------------------------+

  if (!function_exists('lgsl_cut_byte')) {
  function lgsl_cut_byte(&$buffer, $length)
  {
    $string = substr($buffer, 0, $length);

    $buffer = substr($buffer, $length);

    return $string;
  }}

//---------------------------------------------------------+

  if (!function_exists('lgsl_cut_string')) {
  function lgsl_cut_string(&$buffer, $end_marker = "\x00")
  {
    $length = strpos($buffer, $end_marker);

    if ($length === FALSE)
    {
      $length = strlen($buffer);
    }

    $string = substr($buffer, 0, $length);

    $buffer = substr($buffer, $length + strlen($end_marker));

    return $string;
  }}

//---------------------------------------------------------+

  if (!function_exists('lgsl_cut_pascal')) {
  function lgsl_cut_pascal(&$buffer, $start_byte = 1, $length_adjust = 0, $end_byte = 0)
  {
    $length = ord(substr($buffer, 0, $start_byte)) + $length_adjust;

    $string = substr($buffer, $start_byte, $length);

    $buffer = substr($buffer, $start_byte + $length + $end_byte);

    return $string;
  }}

//---------------------------------------------------------+

  if (!function_exists('lgsl_get_string')) {
  function lgsl_get_string($buffer, $end_marker = "\x00")
  {
    $length = strpos($buffer, $end_marker);

    if ($length === FALSE)
    {
      $length = strlen($buffer);
    }

    $string = substr($buffer, 0, $length);

    return $string;
  }}

//------------------------------------------------------------------------------------------------------------+
//--------- PLEASE MAKE A DONATION OR SIGN THE GUESTBOOK AT GREYCUBE.COM IF YOU REMOVE THIS CREDIT -----------+

  if (!function_exists('lgsl_version')) {
  function lgsl_version()
  {
    return "LGSL 4.9 By Richard Perry";
  }}

//------------------------------------------------------------------------------------------------------------+
//------------------------------------------------------------------------------------------------------------+

?>
