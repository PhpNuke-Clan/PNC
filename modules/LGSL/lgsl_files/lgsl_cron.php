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

  @set_time_limit(3600);

  require "lgsl_class.php";

  lgsl_database();

  global $lgsl_config;

//------------------------------------------------------------------------------------------------------------+

  echo "<pre>STARTING ( TIME LIMIT: ".ini_get("max_execution_time")." )\r\n\r\n";

//------------------------------------------------------------------------------------------------------------+

  $mysql_query  = "SELECT `ip`,`q_port`,`c_port`,`s_port`,`type` FROM `{$lgsl_config['db']['prefix']}{$lgsl_config['db']['table']}` WHERE `disabled` = 0 ORDER BY `cache_time` ASC";
  $mysql_result = mysql_query($mysql_query) or die(mysql_error());

  while($mysql_row = mysql_fetch_array($mysql_result, MYSQL_ASSOC))
  {
    echo      str_pad(lgsl_timer("taken"),  8,  " ").":".
              str_pad($mysql_row['type'],   15, " ").":".
              str_pad($mysql_row['ip'],     30, " ").":".
              str_pad($mysql_row['c_port'], 6,  " ").":".
              str_pad($mysql_row['q_port'], 6,  " ").":".
              str_pad($mysql_row['s_port'], 12, " ")."\r\n";

    lgsl_query_cached($mysql_row['ip'], $mysql_row['q_port'], $mysql_row['c_port'], $mysql_row['s_port'], $mysql_row['type'], "sep");

    flush();
    ob_flush();
  }

//------------------------------------------------------------------------------------------------------------+

  echo "\r\nFINISHED</pre>";

//------------------------------------------------------------------------------------------------------------+

?>
