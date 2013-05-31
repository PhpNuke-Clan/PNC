<?php

//------------------------------------------------------------------------------------------------------------+
//[ PREPARE CONFIG - DO NOT CHANGE OR MOVE THIS ]

  global $lgsl_config; $lgsl_config = array();

//------------------------------------------------------------------------------------------------------------+
//[ BACKGROUND COLORS - CHANGE TO MATCH YOUR THEME ]

  $lgsl_config['background'][1] = "background-color:#999999";
  $lgsl_config['background'][2] = "background-color:#666666";

//------------------------------------------------------------------------------------------------------------+
//[ SHOW TOTAL SERVERS / PLAYERS / MAX PLAYERS AT BOTTOM OF THE LIST ]

  $lgsl_config['list']['totals'] = 0;

//------------------------------------------------------------------------------------------------------------+
//[ ZONE SHOWS PLAYER NAMES - OPTIONS: 0=NO 1=YES ]

  $lgsl_config['players'][1] = 1;
  $lgsl_config['players'][2] = 1;
  $lgsl_config['players'][3] = 1;
  $lgsl_config['players'][4] = 1;
  $lgsl_config['players'][5] = 1;
  $lgsl_config['players'][6] = 1;
  $lgsl_config['players'][7] = 1;
  $lgsl_config['players'][8] = 1;

//------------------------------------------------------------------------------------------------------------+
//[ ZONE RANDOMISATION - SEE README ON HOW TO USE ]

  $lgsl_config['random'][1] = 0;
  $lgsl_config['random'][2] = 0;
  $lgsl_config['random'][3] = 0;
  $lgsl_config['random'][4] = 0;
  $lgsl_config['random'][5] = 0;
  $lgsl_config['random'][6] = 0;
  $lgsl_config['random'][7] = 0;
  $lgsl_config['random'][8] = 0;

//------------------------------------------------------------------------------------------------------------+
//[ ZONE GRID WIDTH - INCREASE TO MAKE ZONES GO SIDE BY SIDE ]

  $lgsl_config['grid'][1] = 1;
  $lgsl_config['grid'][2] = 1;
  $lgsl_config['grid'][3] = 1;
  $lgsl_config['grid'][4] = 1;
  $lgsl_config['grid'][5] = 1;
  $lgsl_config['grid'][6] = 1;
  $lgsl_config['grid'][7] = 1;
  $lgsl_config['grid'][8] = 1;

//------------------------------------------------------------------------------------------------------------+
//[ ZONE SIZING ]

  $lgsl_config['zone']['width']  = "110"; // images will be fuzzy or cropped until resized to match
  $lgsl_config['zone']['height'] = "100"; // height of the zone box containing the player names

//------------------------------------------------------------------------------------------------------------+
//[ SORTING OPTIONS ]

  $lgsl_config['sort']['servers'] = "id";   // other options are "players"
  $lgsl_config['sort']['players'] = "name"; // other options are "score"

//------------------------------------------------------------------------------------------------------------+
// [ HIDE OFFLINE SERVERS ON LIST AND ZONES - OPTIONS: 0=SHOW 1=HIDE ]

  $lgsl_config['hide_offline'][0] = 0;
  $lgsl_config['hide_offline'][1] = 0;
  $lgsl_config['hide_offline'][2] = 0;
  $lgsl_config['hide_offline'][3] = 0;
  $lgsl_config['hide_offline'][4] = 0;
  $lgsl_config['hide_offline'][5] = 0;
  $lgsl_config['hide_offline'][6] = 0;
  $lgsl_config['hide_offline'][7] = 0;
  $lgsl_config['hide_offline'][8] = 0;

//------------------------------------------------------------------------------------------------------------+
//[ e107 VERSION - PAGE AND ZONE TITLES - FOR OTHER CMS USE THE ADMIN PANEL ]

  $lgsl_config['title'][0] = "Live Game Server List";
  $lgsl_config['title'][1] = "Game Server";
  $lgsl_config['title'][2] = "Game Server";
  $lgsl_config['title'][3] = "Game Server";
  $lgsl_config['title'][4] = "Game Server";
  $lgsl_config['title'][5] = "Game Server";
  $lgsl_config['title'][6] = "Game Server";
  $lgsl_config['title'][7] = "Game Server";
  $lgsl_config['title'][8] = "Game Server";

//------------------------------------------------------------------------------------------------------------+
//[ TEXT OPTIONS - 'nmp' AND 'nnm' ONLY CHANGE WHEN CACHE IS EMPTY ( CLICK UPDATE IN ADMIN PANEL ) ]

  $lgsl_config['text']['vsd'] = "CLICK TO VIEW SERVER DETAILS";
  $lgsl_config['text']['slk'] = "GAME LINK";
  $lgsl_config['text']['sts'] = "Status:";
  $lgsl_config['text']['adr'] = "Address:";
  $lgsl_config['text']['cpt'] = "Connection Port:";
  $lgsl_config['text']['qpt'] = "Query Port:";
  $lgsl_config['text']['typ'] = "Type:";
  $lgsl_config['text']['gme'] = "Game:";
  $lgsl_config['text']['map'] = "Map:";
  $lgsl_config['text']['plr'] = "Players:";
  $lgsl_config['text']['npi'] = "NO PLAYER INFO";
  $lgsl_config['text']['nei'] = "NO EXTRA INFO";
  $lgsl_config['text']['onl'] = "ONLINE";
  $lgsl_config['text']['onp'] = "ONLINE WITH PASSWORD";
  $lgsl_config['text']['nrs'] = "NO RESPONSE";
  $lgsl_config['text']['pen'] = "WAITING TO BE QUERIED";
  $lgsl_config['text']['zpl'] = "PLAYERS:";
  $lgsl_config['text']['mid'] = "MISSING OR INVALID SERVER ID";
  $lgsl_config['text']['nnm'] = "-";
  $lgsl_config['text']['nmp'] = "-";
  $lgsl_config['text']['tns'] = "Servers:";
  $lgsl_config['text']['tnp'] = "Players:";
  $lgsl_config['text']['tmp'] = "Max Players:";

//------------------------------------------------------------------------------------------------------------+
//[ STAND-ALONE VERSION - ADMIN DETAILS ]

  $lgsl_config['admin']['user'] = "admin";
  $lgsl_config['admin']['pass'] = "changeme";

//------------------------------------------------------------------------------------------------------------+
//[ DATABASE SETTINGS - USED BY THE STAND-ALONE VERSION AND SOME CMS ]

  $lgsl_config['db']['server'] = "localhost";
  $lgsl_config['db']['user']   = "root";
  $lgsl_config['db']['pass']   = "";
  $lgsl_config['db']['db']     = "lgsl";
  $lgsl_config['db']['table']  = "lgsl";

//------------------------------------------------------------------------------------------------------------+
//[ FEED METHOD - OPTIONS: 0=DISABLED 1=CURL OR FSOCKOPEN 2=FSOCKOPEN ONLY ]

  $lgsl_config['feed']['method'] = 0;
  $lgsl_config['feed']['url']    = "http://www.greycube.co.uk/lgsl/feed/lgsl_files/lgsl_feed.php";

//------------------------------------------------------------------------------------------------------------+
//[ ADVANCED SETTINGS - DO NOT TOUCH THESE UNLESS YOU REALLY KNOW WHAT YOUR DOING ]

  $lgsl_config['live_time']     = 4;           // seconds per page load allowed for live querying
  $lgsl_config['cache_time']    = 70;          // seconds before the cached information is considered old
  $lgsl_config['management']    = 0;           // 1 will show advanced management in the admin by default
  $lgsl_config['retry_offline'] = 0;           // 1 will quickly re-query offline servers
  $lgsl_config['timeout']       = 0;           // 1 will increase the query timeout
  $lgsl_config['public_feed']   = 0;           // 1 will allow anyone to add servers to your lgsl database
  $lgsl_config['cms']           = "phpnuke";   // sets which CMS specific code to use
  $lgsl_config['url_path']      = "";          // full domain path to /lgsl_files/ for when path detection fails

//------------------------------------------------------------------------------------------------------------+

?>
