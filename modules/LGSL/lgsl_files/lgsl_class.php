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

  if (!function_exists('lgsl_bg')) {
  function lgsl_bg($rotation_overide = "no")
  {
    global $lgsl_config;
    global $lgsl_bg_rotate;

    if ($rotation_overide !== "no")
    {
      $lgsl_bg_rotate = $rotation_overide ? TRUE : FALSE;
    }
    else
    {
      $lgsl_bg_rotate = $lgsl_bg_rotate ? FALSE : TRUE;
    }

    $background = $lgsl_bg_rotate ? $lgsl_config['background'][1] : $lgsl_config['background'][2];

    return $background;
  }}

//------------------------------------------------------------------------------------------------------------+

  if (!function_exists('lgsl_link')) {
  function lgsl_link($s)
  {
    global $lgsl_config, $lgsl_url_path;

    if ($lgsl_config['cms'] == "sa")
    {
      if (is_numeric($s))
      {
        $link = $lgsl_url_path."../?s={$s}";
      }
      else
      {
        $link = $lgsl_url_path."../";
      }
    }
    elseif ($lgsl_config['cms'] == "e107")
    {
      if (is_numeric($s))
      {
        $link = e_PLUGIN."lgsl/?s={$s}";
      }
      else
      {
        $link = e_PLUGIN."lgsl/";
      }
    }
    elseif ($lgsl_config['cms'] == "joomla")
    {
      if (is_numeric($s))
      {
        $link = JRoute::_("index.php?option=com_lgsl&s={$s}");
      }
      else
      {
        $link = JRoute::_("index.php?option=com_lgsl");
      }
    }
    elseif ($lgsl_config['cms'] == "phpnuke")
    {
      if (is_numeric($s))
      {
        $link = "modules.php?name=LGSL&s={$s}";
      }
      else
      {
        $link = "modules.php?name=LGSL";
      }
    }

    return $link;
  }}

//------------------------------------------------------------------------------------------------------------+

  if (!function_exists('lgsl_database')) {
  function lgsl_database()
  {
    global $lgsl_config, $lgsl_database, $lgsl_file_path;

    if ($lgsl_config['cms'] == "sa" || $lgsl_config['db']['pass'])
    {
      if ($lgsl_database) { return; }
      $lgsl_config['db']['prefix'] = "";
      $lgsl_database  = mysql_connect($lgsl_config['db']['server'], $lgsl_config['db']['user'], $lgsl_config['db']['pass']) or die(mysql_error());
      $lgsl_select_db = mysql_select_db($lgsl_config['db']['db'], $lgsl_database) or die(mysql_error());
    }
    elseif ($lgsl_config['cms'] == "e107")
    {
      global $lgsl_file_path;
      @include_once $lgsl_file_path."../../../class2.php";
      $lgsl_config['db']['prefix'] = MPREFIX;
    }
    elseif ($lgsl_config['cms'] == "joomla")
    {
      $conf =& JFactory::getConfig();
      $lgsl_config['db']['prefix'] = $conf->getValue('config.dbprefix');
    }
    elseif ($lgsl_config['cms'] == "phpnuke")
    {
      global $dbhost, $dbuname, $dbpass, $prefix;
      $lgsl_config['db']['prefix'] = $prefix."_";
      if ($dbhost && $dbuname && $dbpass) { mysql_connect($dbhost, $dbuname, $dbpass); }
    }
    else
    {
      echo "LGSL PROBLEM: INVALID CMS '{$lgsl_config['cms']}' IN CONFIG"; exit;
    }
  }}

//------------------------------------------------------------------------------------------------------------+

  if (!function_exists('lgsl_query_cached')) {
  function lgsl_query_cached($ip, $q_port, $c_port, $s_port, $type, $request)
  {
    global $lgsl_config;

    lgsl_database();

    // ESCAPE FOR SQL QUERY

    $ip      = mysql_real_escape_string($ip);
    $q_port  = mysql_real_escape_string(intval($q_port));
    $c_port  = mysql_real_escape_string(intval($c_port));
    $s_port  = mysql_real_escape_string(intval($s_port));
    $type    = mysql_real_escape_string($type);

    // GET EXISTING CACHE

    $mysql_query  = "SELECT * FROM `{$lgsl_config['db']['prefix']}{$lgsl_config['db']['table']}` WHERE `ip` = '$ip' AND `q_port` = '$q_port' AND `type` = '$type' LIMIT 1";
    $mysql_result = mysql_query($mysql_query) or die(mysql_error());
    $mysql_row    = mysql_fetch_array($mysql_result, MYSQL_ASSOC);

    // CHECK IF SERVER IS IN THE DATABASE AND ADD IF REQUESTED

    if (!$mysql_row)
    {
      if (strpos($request, "a") !== FALSE)
      {
        $mysql_query     = "INSERT INTO `{$lgsl_config['db']['prefix']}{$lgsl_config['db']['table']}` (`ip`, `q_port`, `c_port`, `s_port`, `type`, `cache`, `cache_time`) VALUES ('$ip', '$q_port', '$c_port', '$s_port', '$type', '', '')";
        $mysql_result    = mysql_query($mysql_query) or die(mysql_error());
        $mysql_row['id'] = mysql_insert_id();
      }
      else
      {
        echo "LGSL PROBLEM: REQUESTED SERVER NOT IN DATABASE: '$ip:$q_port:$c_port:$s_port:$type:$request'"; exit;
      }
    }

    // UNPACK CACHE

    $cache         = unserialize($mysql_row['cache']);
    $cache_time    = explode("_", $mysql_row['cache_time']);
    $cache_time[0] = intval($cache_time[0]);
    $cache_time[1] = intval($cache_time[1]);
    $cache_time[2] = intval($cache_time[2]);

    // CHECK WHAT IS NEEDED

    $needed = "";

    if (strpos($request, "s") !== FALSE && gmdate("U") > ($lgsl_config['cache_time'] + $cache_time[0])) { $needed .= "s"; }
    if (strpos($request, "e") !== FALSE && gmdate("U") > ($lgsl_config['cache_time'] + $cache_time[1])) { $needed .= "e"; }
    if (strpos($request, "p") !== FALSE && gmdate("U") > ($lgsl_config['cache_time'] + $cache_time[2])) { $needed .= "p"; }

    if (!$needed) { return $cache; }

    // HANDLE EMPTY AND INCOMPLETE CACHE

    if (!isset($cache['b']))
    {
      $cache['b']['ip']      = $ip;
      $cache['b']['q_port']  = $q_port;
      $cache['b']['c_port']  = $c_port;
      $cache['b']['s_port']  = $s_port;
      $cache['b']['type']    = $type;
      $cache['b']['request'] = $request;
      $cache['b']['status']  = 0;
      $cache['b']['pending'] = 1;
      $cache['o']['id']      = $mysql_row['id'];
    }

    if (!isset($cache['s']))
    {
      $cache['s']['game']       = $type;
      $cache['s']['name']       = $lgsl_config['text']['nnm'];
      $cache['s']['map']        = $lgsl_config['text']['nmp'];
      $cache['s']['players']    = 0;
      $cache['s']['playersmax'] = 0;
      $cache['s']['password']   = 0;
    }

    if (!isset($cache['e']))
    {
      $cache['e'] = array();
    }

    if (!isset($cache['e']))
    {
      $cache['p'] = array();
    }

    // CHECK FOR CACHE ONLY REQUEST

    if (strpos($request, "c") !== FALSE) { return $cache; }

    // GET LIVE DATA

    $live = lgsl_query_live($ip, $q_port, $c_port, $s_port, $type, $needed);

    // USE CACHED VALUES IF SERVER OFFLINE

    if (!$live['b']['status'])
    {
      $live['s']['game']       = $cache['s']['game'];
      $live['s']['name']       = $cache['s']['name'];
      $live['s']['map']        = $cache['s']['map'];
      $live['s']['playersmax'] = $cache['s']['playersmax'];
      $live['s']['password']   = $cache['s']['password'];
    }

    // MERGE LIVE INTO CACHE

    if (isset($live['b'])) { $cache['b'] = $live['b']; }
    if (isset($live['s'])) { $cache['s'] = $live['s']; $cache_time[0] = gmdate("U"); }
    if (isset($live['e'])) { $cache['e'] = $live['e']; $cache_time[1] = gmdate("U"); }
    if (isset($live['p'])) { $cache['p'] = $live['p']; $cache_time[2] = gmdate("U"); }

    // PACK FOR STORAGE

    $packed_cache      = mysql_real_escape_string(serialize($cache));
    $packed_cache_time = mysql_real_escape_string(implode("_", $cache_time));

    // SAVE TO DATABASE

    $mysql_query  = "UPDATE `{$lgsl_config['db']['prefix']}{$lgsl_config['db']['table']}` SET `status` = '{$cache['b']['status']}', `cache` = '$packed_cache', `cache_time` = '$packed_cache_time' WHERE `id` = '$mysql_row[id]' LIMIT 1";
    $mysql_result = mysql_query($mysql_query) or die(mysql_error());

    // RETURN THE REQUESTED

    if (strpos($request, "s") === FALSE) { unset($cache['s']); }
    if (strpos($request, "e") === FALSE) { unset($cache['e']); }
    if (strpos($request, "p") === FALSE) { unset($cache['p']); }

    return $cache;
  }}

//------------------------------------------------------------------------------------------------------------+

  if (!function_exists('lgsl_query_cached_all')) {
  function lgsl_query_cached_all($request)
  {
    global $lgsl_config;

    lgsl_database();

    $mysql_query  = "SELECT `ip`,`q_port`,`c_port`,`s_port`,`type` FROM `{$lgsl_config['db']['prefix']}{$lgsl_config['db']['table']}` WHERE `disabled` = 0 ORDER BY `cache_time` ASC";
    $mysql_result = mysql_query($mysql_query) or die(mysql_error());

    $server_list  = array();

    while ($mysql_row = mysql_fetch_array($mysql_result, MYSQL_ASSOC))
    {
      if (strpos($request, "c") === FALSE && lgsl_timer("check")) { $request .= "c"; }

      $server = lgsl_query_cached($mysql_row['ip'], $mysql_row['q_port'], $mysql_row['c_port'], $mysql_row['s_port'], $mysql_row['type'], $request);

      if ($lgsl_config['hide_offline'][0] && !$server['b']['status']) { continue; }

      $server_list[] = $server;
    }

    return $server_list;
  }}

//------------------------------------------------------------------------------------------------------------+

  if (!function_exists('lgsl_query_cached_zone')) {
  function lgsl_query_cached_zone($request, $zone_number)
  {
    global $lgsl_config;

    lgsl_database();

    $zone_number = mysql_real_escape_string(intval($zone_number));
    $zone_random = mysql_real_escape_string(intval($lgsl_config['random'][$zone_number]));

    if ($zone_random)
    {
      $mysql_query = "SELECT `ip`,`q_port`,`c_port`,`s_port`,`type` FROM `{$lgsl_config['db']['prefix']}{$lgsl_config['db']['table']}` WHERE `zone` = '$zone_number' AND `disabled` = 0 ORDER BY rand() LIMIT $zone_random";
    }
    else
    {
      $mysql_query = "SELECT `ip`,`q_port`,`c_port`,`s_port`,`type` FROM `{$lgsl_config['db']['prefix']}{$lgsl_config['db']['table']}` WHERE `zone` = '$zone_number' AND `disabled` = 0 ORDER BY `cache_time` ASC";
    }

    $mysql_result = mysql_query($mysql_query) or die(mysql_error());

    $server_list  = array();

    while ($mysql_row = mysql_fetch_array($mysql_result, MYSQL_ASSOC))
    {
      if (strpos($request, "c") === FALSE && lgsl_timer("check")) { $request .= "c"; }

      $server = lgsl_query_cached($mysql_row['ip'], $mysql_row['q_port'], $mysql_row['c_port'], $mysql_row['s_port'], $mysql_row['type'], $request);

      if ($lgsl_config['hide_offline'][$zone_number] && !$server['b']['status']) { continue; }

      $server_list[] = $server;
    }

    return $server_list;
  }}

//------------------------------------------------------------------------------------------------------------+

  if (!function_exists('lgsl_cached_totals')) {
  function lgsl_cached_totals()
  {
    global $lgsl_config;

    lgsl_database();

    $mysql_query  = "SELECT `cache` FROM `{$lgsl_config['db']['prefix']}{$lgsl_config['db']['table']}` WHERE `disabled` = 0";
    $mysql_result = mysql_query($mysql_query) or die(mysql_error());

    $total['players']         = 0;
    $total['playersmax']      = 0;
    $total['servers']         = 0;
    $total['servers_online']  = 0;
    $total['servers_offline'] = 0;

    while ($mysql_row = mysql_fetch_array($mysql_result, MYSQL_ASSOC))
    {
      $server = unserialize($mysql_row['cache']);

      $total['players']    += $server['s']['players'];
      $total['playersmax'] += $server['s']['playersmax'];

                                    $total['servers']         ++;
      if ($server['b']['status']) { $total['servers_online']  ++; }
      else                        { $total['servers_offline'] ++; }
    }

    return $total;
  }}

//------------------------------------------------------------------------------------------------------------+

  if (!function_exists('lgsl_lookup_id')) {
  function lgsl_lookup_id($id)
  {
    global $lgsl_config;

    lgsl_database();

    $id           = mysql_real_escape_string(intval($id));
    $mysql_query  = "SELECT `ip`,`q_port`,`c_port`,`s_port`,`type` FROM `{$lgsl_config['db']['prefix']}{$lgsl_config['db']['table']}` WHERE `id` = '$id' LIMIT 1";
    $mysql_result = mysql_query($mysql_query) or die(mysql_error());
    $mysql_row    = mysql_fetch_array($mysql_result, MYSQL_ASSOC);

    return $mysql_row;
  }}

//------------------------------------------------------------------------------------------------------------+

  if (!function_exists('lgsl_timer')) {
  function lgsl_timer($action)
  {
    global $lgsl_config;
    global $lgsl_timer;

    if (!$lgsl_timer)
    {
      $microtime  = microtime();
      $microtime  = explode(' ', $microtime);
      $microtime  = $microtime[1] + $microtime[0];
      $lgsl_timer = $microtime - 0.01;
    }

    $time_limit = intval($lgsl_config['live_time']);
    $time_php   = ini_get("max_execution_time");

    if ($time_limit > $time_php)
    {
      @set_time_limit($time_limit + 5);

      $time_php = ini_get("max_execution_time");

      if ($time_limit > $time_php)
      {
        $time_limit = $time_php - 5;
      }
    }

    if ($action == "limit")
    {
      return $time_limit;
    }

    $microtime  = microtime();
    $microtime  = explode(' ', $microtime);
    $microtime  = $microtime[1] + $microtime[0];
    $time_taken = $microtime - $lgsl_timer;

    if ($action == "check")
    {
      return ($time_taken > $time_limit) ? TRUE : FALSE;
    }
    else
    {
      return round($time_taken, 2);
    }
  }}

//------------------------------------------------------------------------------------------------------------+

  if (!function_exists('lgsl_server_misc')) {
  function lgsl_server_misc($server)
  {
    global $lgsl_config, $lgsl_url_path;

    $misc['icon_details']       = $lgsl_url_path."other/icon_details.gif";
    $misc['icon_game']          = lgsl_icon_game($server['b']['type'], $server['s']['game']);
    $misc['icon_status']        = lgsl_icon_status($server['b']['status'], $server['s']['password'], $server['b']['pending']);

    $misc['image_map']          = lgsl_image_map($server['b']['status'], $server['b']['type'], $server['s']['game'], $server['s']['map']);
    $misc['image_map_password'] = lgsl_image_map_password($server['b']['status'], $server['s']['password']);

    $misc['text_status']        = lgsl_text_status($server['b']['status'], $server['s']['password'], $server['b']['pending']);
    $misc['text_type_game']     = lgsl_text_type_game($server['b']['type'], $server['s']['game']);

    $misc['name_filtered']      = lgsl_name_filtered($server['s']['name']);

    $misc['software_link']      = lgsl_software_link($server['b']['ip'], $server['b']['q_port'], $server['b']['c_port'], $server['b']['s_port'], $server['b']['type']);

    return $misc;
  }}

//------------------------------------------------------------------------------------------------------------+

  if (!function_exists('lgsl_icon_game')) {
  function lgsl_icon_game($type, $game)
  {
    global $lgsl_file_path, $lgsl_url_path;

    $type = preg_replace("/[^A-Za-z0-9_]/", "_", strtolower($type));
    $game = preg_replace("/[^A-Za-z0-9_]/", "_", strtolower($game));

    if (file_exists("{$lgsl_file_path}icons/{$type}/{$game}.gif"))
    {
      return "{$lgsl_url_path}icons/{$type}/{$game}.gif";
    }

    if (file_exists("{$lgsl_file_path}icons/{$type}/{$type}.gif"))
    {
      return "{$lgsl_url_path}icons/{$type}/{$type}.gif";
    }

    return "{$lgsl_url_path}other/icon_unknown.gif";
  }}

//------------------------------------------------------------------------------------------------------------+

  if (!function_exists('lgsl_icon_status')) {
  function lgsl_icon_status($status, $password, $pending = 0)
  {
    global $lgsl_url_path;

    if ($pending)
    {
      return "{$lgsl_url_path}other/icon_unknown.gif";
    }

    if (!$status)
    {
      return "{$lgsl_url_path}other/icon_no_response.gif";
    }

    if ($password)
    {
      return "{$lgsl_url_path}other/icon_online_password.gif";
    }

    return "{$lgsl_url_path}other/icon_online.gif";
  }}

//------------------------------------------------------------------------------------------------------------+

  if (!function_exists('lgsl_image_map')) {
  function lgsl_image_map($status, $type, $game, $map, $check_exists = TRUE)
  {
    global $lgsl_file_path, $lgsl_url_path;

    if (!$status)
    {
      return "{$lgsl_url_path}other/map_no_response.jpg";
    }

    $type = preg_replace("/[^A-Za-z0-9_]/", "_", strtolower($type));
    $game = preg_replace("/[^A-Za-z0-9_]/", "_", strtolower($game));
    $map  = preg_replace("/[^A-Za-z0-9_]/", "_", strtolower($map));

    if (file_exists("{$lgsl_file_path}maps/{$type}/{$game}/{$map}.jpg") || $check_exists == FALSE)
    {
      return "{$lgsl_url_path}maps/{$type}/{$game}/{$map}.jpg";
    }

    if (file_exists("{$lgsl_file_path}maps/{$type}/{$game}/{$map}.gif"))
    {
      return "{$lgsl_url_path}maps/{$type}/{$game}/{$map}.gif";
    }

    if (file_exists("{$lgsl_file_path}maps/{$type}/{$map}.jpg"))
    {
      return "{$lgsl_url_path}maps/{$type}/{$map}.jpg";
    }

    if (file_exists("{$lgsl_file_path}maps/{$type}/{$map}.gif"))
    {
      return "{$lgsl_url_path}maps/{$type}/{$map}.gif";
    }

    return "{$lgsl_url_path}other/map_no_image.jpg";
  }}

//------------------------------------------------------------------------------------------------------------+

  if (!function_exists('lgsl_image_map_password')) {
  function lgsl_image_map_password($status, $password)
  {
    global $lgsl_url_path;

    if (!$password || !$status)
    {
      return "{$lgsl_url_path}other/map_overlay.gif";
    }

    return "{$lgsl_url_path}other/map_overlay_password.gif";
  }}

//------------------------------------------------------------------------------------------------------------+

  if (!function_exists('lgsl_text_status')) {
  function lgsl_text_status($status, $password, $pending = 0)
  {
    global $lgsl_config;

    if ($pending)
    {
      return $lgsl_config['text']['pen'];
    }

    if (!$status)
    {
      return $lgsl_config['text']['nrs'];
    }

    if ($password)
    {
      return $lgsl_config['text']['onp'];
    }

    return $lgsl_config['text']['onl'];
  }}

//------------------------------------------------------------------------------------------------------------+

  if (!function_exists('lgsl_text_type_game')) {
  function lgsl_text_type_game($type, $game)
  {
    global $lgsl_config;

    return "[ {$lgsl_config['text']['typ']} {$type} ] [ {$lgsl_config['text']['gme']} {$game} ]";
  }}

//------------------------------------------------------------------------------------------------------------+

  if (!function_exists('lgsl_name_filtered')) {
  function lgsl_name_filtered($name)
  {
    $name = preg_replace("/[^\x20-\x7E]/", "", $name); // x20-x7E IS HEX FOR ASCII RANGE
    $name = lgsl_string_html($name);

    return $name;
  }}

//------------------------------------------------------------------------------------------------------------+

  if (!function_exists('lgsl_sort_servers')) {
  function lgsl_sort_servers($server_list)
  {
    global $lgsl_config;

    if (!is_array($server_list)) { return $server_list; }

    if ($lgsl_config['sort']['servers'] == "players")
    {
      usort($server_list, "lgsl_sort_servers_by_players");
    }
    else
    {
      usort($server_list, "lgsl_sort_servers_by_id");
    }

    return $server_list;
  }}

//------------------------------------------------------------------------------------------------------------+

  if (!function_exists('lgsl_sort_servers_by_players')) {
  function lgsl_sort_servers_by_players($server_a, $server_b)
  {
    if ($server_a['s']['players'] == $server_b['s']['players']) { return 0; }

    return ($server_a['s']['players'] < $server_b['s']['players']) ? 1 : -1;
  }}

//------------------------------------------------------------------------------------------------------------+

  if (!function_exists('lgsl_sort_servers_by_id')) {
  function lgsl_sort_servers_by_id($server_a, $server_b)
  {
    if ($server_a['o']['id'] == $server_b['o']['id']) { return 0; }

    return ($server_a['o']['id'] > $server_b['o']['id']) ? 1 : -1;
  }}

//------------------------------------------------------------------------------------------------------------+

  if (!function_exists('lgsl_sort_extras')) {
  function lgsl_sort_extras($server)
  {
    if (!is_array($server['e'])) { return $server; }

    ksort($server['e']);

    return $server;
  }}

//------------------------------------------------------------------------------------------------------------+

  if (!function_exists('lgsl_sort_players')) {
  function lgsl_sort_players($server)
  {
    global $lgsl_config;

    if (!is_array($server['p'])) { return $server; }

    if ($lgsl_config['sort']['players'] == "score")
    {
      usort($server['p'], "lgsl_sort_players_by_score");
    }
    else
    {
      usort($server['p'], "lgsl_sort_players_by_name");
    }

    return $server;
  }}

//------------------------------------------------------------------------------------------------------------+

  if (!function_exists('lgsl_sort_players_by_score')) {
  function lgsl_sort_players_by_score($player_a, $player_b)
  {
    if ($player_a['score'] == $player_b['score']) { return 0; }

    return ($player_a['score'] < $player_b['score']) ? 1 : -1;
  }}

//------------------------------------------------------------------------------------------------------------+

  if (!function_exists('lgsl_sort_players_by_name')) {
  function lgsl_sort_players_by_name($player_a, $player_b)
  {
    // FILTER NON ALPHA NUMERIC CHARACTERS FROM NAME

    $string_a = preg_replace("/[^a-z\d]/i", "", $player_a['name']);
    $string_b = preg_replace("/[^a-z\d]/i", "", $player_b['name']);

    // IF ONE OF THE NAMES IS COMPLETELY NON ALPHA NUMERIC THEN PUT IT LAST

    if (!$string_a) { return  1; }
    if (!$string_b) { return -1; }

    // IF BOTH NAMES ARE COMPLETELY NON ALPHA NUMERIC THEN FALLBACK TO UNFILTERED

    if (!$string_a && !$string_b)
    {
      $string_a = $player_a['name'];
      $string_b = $player_b['name'];
    }

    // OTHERWISE MAKE THEM LOWERCASE

    else
    {
      $string_a = strtolower($string_a);
      $string_b = strtolower($string_b);
    }

    // COMPARE EACH CHARACTER SO ITS SORTED ASCENDING ( A TO Z )

    $string_length = strlen($string_a);

    for ($i=0; $i<$string_length; $i++)
    {
      $char_a = ord($string_a[$i]);
      $char_b = ord($string_b[$i]);

      if ($char_a < $char_b) { return -1; }
      if ($char_a > $char_b) { return  1; }
    }

    // AT THIS POINT THE TWO NAMES ARE EQUAL IN ORDER

    return 0;
  }}

//------------------------------------------------------------------------------------------------------------+

  if (!function_exists('lgsl_server_html')) {
  function lgsl_server_html($server)
  {
    if (is_array($server['s']))
    {
      foreach ($server['s'] as $key => $value)
      {
        $server['s'][$key] = lgsl_string_html($value);
      }
    }

    if (is_array($server['e']))
    {
      foreach ($server['e'] as $key => $value)
      {
        $value = wordwrap($value, 90, "\x00\x01", TRUE);    // \x00\x01 PLACEHOLDER FOR <BR /> TO PREVENT IT BEING ENTITIED
        $value = lgsl_string_html($value);
        $value = str_replace("\x00\x01", "<br />", $value); // CHANGE PLACEHOLDER INTO ACTUALY <BR />

        $server['e'][$key] = $value;
      }
    }

    if (is_array($server['p']))
    {
      foreach ($server['p'] as $key => $player)
      {
        $server['p'][$key]['name'] = lgsl_string_html($player['name']);
      }
    }

    return $server;
  }}

//------------------------------------------------------------------------------------------------------------+

  if (!function_exists('lgsl_string_html')) {
  function lgsl_string_html($string)
  {
    if (function_exists("mb_convert_encoding")) // REQUIRES http://php.net/mbstring
    {
      $string = htmlspecialchars($string, ENT_QUOTES);
      $string = @mb_convert_encoding($string, "HTML-ENTITIES", "UTF-8");
    }
    else
    {
      $string = htmlentities($string, ENT_QUOTES);
    }

    return $string;
  }}

//------------------------------------------------------------------------------------------------------------+

  if (!function_exists('lgsl_file_path')) {
  function lgsl_file_path()
  {
    // GET FILE PATHS

        if ($_SERVER['ORIG_PATH_TRANSLATED']) { $load_path = $_SERVER['ORIG_PATH_TRANSLATED']; }
    elseif ($_SERVER['PATH_TRANSLATED'])      { $load_path = $_SERVER['PATH_TRANSLATED'];      }
    else                                      { $load_path = $_SERVER['SCRIPT_FILENAME'];      }

    $lgsl_path = __FILE__;

    // TRANSLATE SYMBOLIC LINKS INTO ABSOLUTE FILE PATHS

    $load_path = realpath($load_path);
    $lgsl_path = realpath($lgsl_path);

    // SHORTEN TO JUST THE FOLDERS AND ADD TRAILING SLASH

    $load_path = dirname($load_path)."/";
    $lgsl_path = dirname($lgsl_path)."/";

    // CONVERT WINDOWS BACKSLASHES TO FORWARDSLASHES

    $load_path = str_replace("\\", "/", $load_path);
    $lgsl_path = str_replace("\\", "/", $lgsl_path);

    // SPLIT PATHS INTO BITS

    $load_bits = explode("/", $load_path);
    $lgsl_bits = explode("/", $lgsl_path);

    // COMPARE BITS TO FIND THE COMMON BASE DIRECTORY

    $base_count = 0;

    while (isset($load_bits[$base_count]) && isset($lgsl_bits[$base_count]) && $load_bits[$base_count] == $lgsl_bits[$base_count])
    {
      $base_count++;
    }

    // TOTAL BITS

    $load_count = count($load_bits) - 1;
    $lgsl_count = count($lgsl_bits) - 1;

    // CHANGE THE COUNTS INTO RELATIVE PATHS

    $path_down = "";

    for ($i=$base_count; $i<$load_count; $i++)
    {
      $path_down .= "../";
    }

    $path_up = "";

    for ($i=$base_count; $i<$lgsl_count; $i++)
    {
      $path_up .= $lgsl_bits[$i]."/";
    }

    // RETURN THE PATHS JOINED

    return $path_down.$path_up;
  }}

//------------------------------------------------------------------------------------------------------------+

  if (!function_exists('lgsl_url_path')) {
  function lgsl_url_path()
  {
    // CHECK IF PATH HAS BEEN SET IN CONFIG

    global $lgsl_config;

    if ($lgsl_config['url_path'])
    {
      return $lgsl_config['url_path'];
    }

    // USE FULL DOMAIN PATH TO AVOID ALIAS PROBLEMS

    $host_path = "http://".($_SERVER['WEBC_USER_DOMAIN_NAME'] ? $_SERVER['WEBC_USER_DOMAIN_NAME'] : $_SERVER['SERVER_NAME']);

    // GET ABSOLUTE FILE PATHS

    $base_path = realpath($_SERVER['DOCUMENT_ROOT']);
    $lgsl_path = dirname(realpath(__FILE__));

    // CONVERT WINDOWS BACKSLASHES TO FORWARDSLASHES

    $base_path = str_replace("\\", "/", $base_path);
    $lgsl_path = str_replace("\\", "/", $lgsl_path);

    // USE THE DIFFERENCE BETWEEN PATHS

    if (substr($lgsl_path, 0, strlen($base_path)) == $base_path)
    {
      $url_path = substr($lgsl_path, strlen($base_path));

      return $host_path.$url_path."/";
    }

    return "//UNKNOWN_URL_PATH/{$lgsl_path}/";
  }}

//------------------------------------------------------------------------------------------------------------+

  global $lgsl_file_path, $lgsl_url_path;

  $lgsl_file_path = lgsl_file_path();

  require $lgsl_file_path."lgsl_config.php";
  require $lgsl_file_path."lgsl_protocol.php";

  $lgsl_url_path = lgsl_url_path();

  if ($_GET['lgsl_debug'])
  {
    echo "LGSL DEBUG:
    <hr /><pre>".print_r($_SERVER, TRUE)."</pre>
    <hr />".__FILE__."
    <hr />".realpath(__FILE__)."
    <hr />".realpath($_SERVER['DOCUMENT_ROOT'])."
    <hr />{$lgsl_file_path}
    <hr />{$lgsl_url_path}
    <hr />";
  }

  if (!isset($lgsl_config['live_time']))
  {
    echo "LGSL PROBLEM: CONFIG FILE BROKEN"; exit;
  }

//------------------------------------------------------------------------------------------------------------+

?>
