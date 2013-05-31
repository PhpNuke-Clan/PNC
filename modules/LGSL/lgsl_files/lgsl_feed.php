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

  require "lgsl_class.php";

//------------------------------------------------------------------------------------------------------------+

  $public_feed = FALSE; // WARNING: SETTING THIS 'TRUE' WILL LET ANYONE ADD SERVERS TO DATABASE

//------------------------------------------------------------------------------------------------------------+

  $ip      = $_GET['ip'];
  $q_port  = intval($_GET['q_port']);
  $c_port  = intval($_GET['c_port']);
  $s_port  = intval($_GET['s_port']);
  $type    = $_GET['type'];
  $request = $_GET['request'];

//------------------------------------------------------------------------------------------------------------+

  if (!$ip || !$q_port || !$c_port || !$type || !$request)
  {
    echo "LGSL FEED PROBLEM: INCOMPLETE REQUEST"; exit;
  }

  if ($q_port > 99999 || $q_port < 1)
  {
    echo "LGSL FEED PROBLEM: INVALID QUERY PORT: '$q_port'"; exit;
  }

  if (preg_match("/[^\x20-\x7E]/", $ip))
  {
    echo "LGSL FEED PROBLEM: NON ASCII IP: '$ip'"; exit;
  }

  if (preg_match("/[^\x20-\x7E]/", $type))
  {
    echo "LGSL FEED PROBLEM: NON ASCII TYPE: '$type'"; exit;
  }

  if (preg_match("/[^\x20-\x7E]/", $request))
  {
    echo "LGSL FEED PROBLEM: NON ASCII REQUEST: '$request'"; exit;
  }

//------------------------------------------------------------------------------------------------------------+

  // CHECK PUBLIC FEED SETTING AND EITHER ADD [a] REQUEST OR ENSURE [a] IS REMOVED

  global $lgsl_config;

  $request = $lgsl_config['public_feed'] ? $request."a" : str_replace("a", "", $request);

//------------------------------------------------------------------------------------------------------------+

  $server = lgsl_query_cached($ip, $q_port, $c_port, $s_port, $type, $request);

//------------------------------------------------------------------------------------------------------------+

  // ADD THE FEED PROVIDER

  if ($server['e'])
  {
    $server['e']['_feed_'] = "http://{$_SERVER['HTTP_HOST']}";
  }

//------------------------------------------------------------------------------------------------------------+
// FEED USAGE LOGGING - 'logs' FOLDER MUST BE MANUALLY CREATED AND SET AS WRITABLE

  if (is_dir("logs") && is_writable("logs"))
  {
    if (filesize("logs/feed_usage.html") > 1234567)
    {
      unlink("logs/feed_usage.html");
    }

    $file_handle = fopen("logs/feed_usage.html", "a");

    $file_string  = "[ ".date("Y/m/d H:i:s")." ] ";
    $file_string .= lgsl_string_html($type)   .":";
    $file_string .= lgsl_string_html($ip)     .":";
    $file_string .= lgsl_string_html($c_port) .":";
    $file_string .= lgsl_string_html($q_port) .":";
    $file_string .= lgsl_string_html($s_port) .":";
    $file_string .= lgsl_string_html($request)." ";
    $file_string .= "[ <a href='http://".lgsl_string_html($_SERVER['REMOTE_ADDR']) ."'>".lgsl_string_html($_SERVER['REMOTE_ADDR']) ."</a> ] ";
    $file_string .= "[ <a href='"       .lgsl_string_html($_SERVER['HTTP_REFERER'])."'>".lgsl_string_html($_SERVER['HTTP_REFERER'])."</a> ] ";
    $file_string .= "<br />";

    fwrite($file_handle, $file_string);

    fclose($file_handle);
  }

//------------------------------------------------------------------------------------------------------------+

  echo "_SLGSLF_".serialize($server)."_SLGSLF_";

//------------------------------------------------------------------------------------------------------------+

?>
