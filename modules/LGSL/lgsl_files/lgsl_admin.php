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

  if (!defined("LGSL_ADMIN"))
  {
    echo "DIRECT ACCESS NOT ALLOWED"; exit;
  }

//------------------------------------------------------------------------------------------------------------+

  if (!function_exists("fsockopen"))
  {
    if (function_exists("curl_init") && function_exists("curl_setopt") && function_exists("curl_exec"))
    {
      if (!$lgsl_config['feed']['method'])
      {
        $output = "
        <div style='text-align:center'>
          <b>FSOCKOPEN IS DISABLED - YOU MUST ENABLE THE FEED OPTION</b>
          <br />
        </div>";

        return;
      }
    }
    else
    {
      $output = "
      <div style='text-align:center'>
        <b>FSOCKOPEN AND CURL ARE DISABLED - SORRY BUT LGSL WILL NOT WORK</b>
        <br />
      </div>";

      return;
    }
  }

//------------------------------------------------------------------------------------------------------------+

  require "lgsl_class.php";

  global $lgsl_config;

  lgsl_database();

  $lgsl_type_list = lgsl_type_list(); asort($lgsl_type_list);
  $lgsl_protocol_list = lgsl_protocol_list();

  $last_type = "source";

//------------------------------------------------------------------------------------------------------------+

  if ($_POST['lgsl_update'])
  {
    $mysql_result = mysql_query("TRUNCATE `{$lgsl_config['db']['prefix']}{$lgsl_config['db']['table']}`") or die(mysql_error());

    if ($_POST['lgsl_advanced'])
    {
      $form_lines = explode("\r\n", $_POST['form_list']);

      foreach ($form_lines as $form_key => $form_line)
      {
        list($_POST['form_type'][$form_key],
             $_POST['form_ip'][$form_key],
             $_POST['form_c_port'][$form_key],
             $_POST['form_q_port'][$form_key],
             $_POST['form_s_port'][$form_key],
             $_POST['form_zone'][$form_key],
             $_POST['form_disabled'][$form_key]) = explode(":", $form_line);
      }
    }

    foreach ($_POST['form_ip'] as $form_key => $not_used)
    {
      $type     = mysql_real_escape_string(       trim($_POST['form_type'][$form_key]));
      $ip       = mysql_real_escape_string(       trim($_POST['form_ip'][$form_key]));
      $c_port   = mysql_real_escape_string(intval(trim($_POST['form_c_port'][$form_key])));
      $q_port   = mysql_real_escape_string(intval(trim($_POST['form_q_port'][$form_key])));
      $s_port   = mysql_real_escape_string(intval(trim($_POST['form_s_port'][$form_key])));
      $zone     = mysql_real_escape_string(intval(trim($_POST['form_zone'][$form_key])));
      $disabled = mysql_real_escape_string(intval(trim($_POST['form_disabled'][$form_key])));

      if (!$ip) { continue; }
      list($q_port, $c_port, $s_port) = lgsl_port_conversion($q_port, $c_port, $s_port, $type);
      if (!$lgsl_protocol_list[$type])        { $disabled = 1; }
      if (strpos($ip, ":") !== FALSE)     { $disabled = 1; }
      if ($q_port < 1 || $q_port > 99999) { $disabled = 1; $q_port = ""; }
      if ($c_port < 1 || $c_port > 99999) { $disabled = 1; $c_port = ""; }

      $mysql_query  = "INSERT INTO `{$lgsl_config['db']['prefix']}{$lgsl_config['db']['table']}` (`status`,`ip`,`q_port`,`c_port`, `s_port`, `type`, `cache`, `cache_time`, `zone`,`disabled`) VALUES ('0', '$ip', '$q_port', '$c_port', '$s_port', '$type', '', '', '$zone', '$disabled')";
      $mysql_result = mysql_query($mysql_query) or die(mysql_error());
    }
  }

//------------------------------------------------------------------------------------------------------------+

  if ($_POST['lgsl_map_image_paths'])
  {
    $server_list = lgsl_query_cached_all("s");

    foreach ($server_list as $server)
    {
      if (!$server['b']['status']) { continue; }

      $image_map = lgsl_image_map($server['b']['status'], $server['b']['type'], $server['s']['game'], $server['s']['map'], FALSE);

      $output .= "
      <div>
        <a href='{$image_map}'> {$image_map} </a>
      </div>";
    }

    $output .= "
    <div>
      <br />
      <a href='{$_SERVER['PHP_SELF']}?{$_SERVER['QUERY_STRING']}'> RETURN TO ADMIN </a>
    </div>";

    return;
  }

//------------------------------------------------------------------------------------------------------------+

  if (($_POST['lgsl_advanced'] || $lgsl_config['management']) && !$_POST['lgsl_normal'])
  {
    $output .= "
    <form method='post' action='{$_SERVER['PHP_SELF']}?{$_SERVER['QUERY_STRING']}'>
      <div style='text-align:center'>
        <b>TYPE : IP : C PORT : Q PORT : S PORT : ZONE : DISABLED</b>
        <br />
        <br />
      </div>
      <div style='text-align:center'>
        <textarea name='form_list' cols='85' rows='30' wrap='off' spellcheck='false' style='width:700px; height:500px'>";

//---------------------------------------------------------+
        $mysql_result = mysql_query("SELECT * FROM `{$lgsl_config['db']['prefix']}{$lgsl_config['db']['table']}` ORDER BY `id` ASC");

        while($mysql_row = mysql_fetch_array($mysql_result, MYSQL_ASSOC))
        {
          $output .= htmlentities(str_pad($mysql_row['type'],   15, " "), ENT_QUOTES) .":";
          $output .= htmlentities(str_pad($mysql_row['ip'],     30, " "), ENT_QUOTES) .":";
          $output .= htmlentities(str_pad($mysql_row['c_port'], 6,  " "), ENT_QUOTES) .":";
          $output .= htmlentities(str_pad($mysql_row['q_port'], 6,  " "), ENT_QUOTES) .":";
          $output .= htmlentities(str_pad($mysql_row['s_port'], 12, " "), ENT_QUOTES) .":";
          $output .= htmlentities(str_pad($mysql_row['zone'],   3,  " "), ENT_QUOTES) .":";
          $output .=                      $mysql_row['disabled']                      ."\r\n";
        }
//---------------------------------------------------------+
        $output .= "
        </textarea>
      </div>
      <div style='text-align:center'>
        <br />
        <input type='hidden' name='lgsl_advanced' value='1'                              />
        <input type='submit' name='lgsl_update'   value='Update Servers and Empty Cache' />
        <br />
        <br />
        <br />
        <br />
        <input type='submit' name='lgsl_map_image_paths' value='Show Map Image Paths' />
        <br />
        <br />
        <input type='submit' name='lgsl_normal'   value='Normal Management' />
        <br />
        <br />
      </div>
    </form>";

    $output .= "
    <div style='text-align:center'>
      <table cellspacing='10' cellpadding='0' style='border:1px solid; margin:auto'>
        <tr>
          <td> <a href='http://php.net/fsockopen'>FSOCKOPEN</a>         </td>
          <td> ".(function_exists("fsockopen") ? "YES" : "NO")."        </td>
          <td> ( used for direct querying of servers and for the feed ) </td>
        </tr>
        <tr>
          <td> <a href='http://php.net/curl'>CURL</a>                                                                                </td>
          <td> ".((function_exists("curl_init") && function_exists("curl_setopt") && function_exists("curl_exec")) ? "YES" : "NO")." </td>
          <td> ( used for the feed )                                                                                                 </td>
        </tr>
        <tr>
          <td> <a href='http://php.net/mbstring'>MBSTRING</a>                          </td>
          <td> ".(function_exists("mb_convert_encoding") ? "YES" : "NO")."             </td>
          <td> ( used for source based games to correctly display UTF-8 player names ) </td>
        </tr>
        <tr>
          <td> <a href='http://php.net/bzip2'>BZIP2</a>                            </td>
          <td> ".(function_exists("bzdecompress") ? "YES" : "NO")."                </td>
          <td> ( used for source based games when server settings are compressed ) </td>
        </tr>
      </table>
      <br />
      <br />
    </div>";

    return $output;
  }

//------------------------------------------------------------------------------------------------------------+

  $output .= "
  <form method='post' action='{$_SERVER['PHP_SELF']}?{$_SERVER['QUERY_STRING']}'>

    <div style='text-align:center'>
      <br />
      - To remove a server, delete the IP, then click update.
      <br />
      <br />
      - If you enter just the connection port, LGSL will try to work out the query port for you.
      <br />
      <br />
      <br />
    </div>

    <table cellspacing='5' cellpadding='0' style='margin:auto'>

      <tr>
        <td style='white-space:nowrap'> [ ID ]              </td>
        <td style='white-space:nowrap'> [ Game Type ]       </td>
        <td style='white-space:nowrap'> [ IP ]              </td>
        <td style='white-space:nowrap'> [ Connection Port ] </td>
        <td style='white-space:nowrap'> [ Query Port ]      </td>
        <td style='white-space:nowrap'> [ Software Port ]   </td>
        <td style='white-space:nowrap'> [ Zone ]            </td>
        <td style='white-space:nowrap'> [ Disabled ]        </td>
      </tr>";

//---------------------------------------------------------+

  $mysql_result = mysql_query("SELECT * FROM `{$lgsl_config['db']['prefix']}{$lgsl_config['db']['table']}` ORDER BY `id` ASC");

  while($mysql_row = mysql_fetch_array($mysql_result, MYSQL_ASSOC))
  {
      $id = $mysql_row['id']; // ID USED INSTEAD OF [] BECAUSE CHECKBOXES ONLY RETURN WHEN CHECKED

      $output .= "
      <tr>
        <td> {$id} </td>
        <td>
          <select name='form_type[{$id}]'>";
//---------------------------------------------------------+
            foreach ($lgsl_type_list as $type => $description)
            {
              $output .= "<option ".($type == $mysql_row['type'] ? "selected='selected'" : "")." value='{$type}'> {$description} </option>";
            }
//---------------------------------------------------------+
            if (!$lgsl_type_list[$mysql_row['type']])
            {
              $output .= "<option selected='selected' value='".htmlentities($mysql_row['type'], ENT_QUOTES)."'> UNKNOWN ( ".htmlentities($mysql_row['type'], ENT_QUOTES)." ) </option>";
            }
//---------------------------------------------------------+
          $output .= "
          </select>
        </td>
        <td> <input type='text' name='form_ip[{$id}]'     value='{$mysql_row['ip']}'     size='15' maxlength='128' /> </td>
        <td> <input type='text' name='form_c_port[{$id}]' value='{$mysql_row['c_port']}' size='5'  maxlength='5'   /> </td>
        <td> <input type='text' name='form_q_port[{$id}]' value='{$mysql_row['q_port']}' size='5'  maxlength='5'   /> </td>
        <td> <input type='text' name='form_s_port[{$id}]' value='{$mysql_row['s_port']}' size='5'  maxlength='5'   /> </td>
        <td>
          <select name='form_zone[$id]'>";
//---------------------------------------------------------+
            for ($i=0; $i<=8; $i++)
            {
              $output .= "<option ".($mysql_row['zone'] == $i ? "selected='selected'" : "")." value='{$i}'> {$i} </option>";
            }
//---------------------------------------------------------+
            if ($mysql_row['zone'] > 8)
            {
              $output .= "<option selected='selected' value='{$mysql_row['zone']}'> {$mysql_row['zone']} </option>";
            }
//---------------------------------------------------------+
          $output .= "
          </select>
        </td>
        <td style='text-align:center'><input type='checkbox' name='form_disabled[{$id}]' value='1' ".($mysql_row['disabled'] ? "checked='checked'" : "")." /></td>
      </tr>";

      $last_type = $mysql_row['type']; // UPDATE LAST TYPE ( AS $mysql_row ONLY EXISTS WITHIN THE WHILE LOOP )
  }
//---------------------------------------------------------+
      $id ++; // NEW SERVER ID CONTINUES ON FROM LAST

      $output .= "
      <tr>
        <td>NEW</td>
        <td>
          <select name='form_type[{$id}]'>";
//---------------------------------------------------------+
            foreach ($lgsl_type_list as $type => $description)
            {
              $output .= "<option ".($type == $last_type ? "selected='selected'" : "")." value='{$type}'> {$description} </option>";
            }
//---------------------------------------------------------+
          $output .= "
          </select>
        </td>
        <td> <input type='text' name='form_ip[{$id}]'     value='{$mysql_row['ip']}'     size='15' maxlength='128' /> </td>
        <td> <input type='text' name='form_c_port[{$id}]' value='{$mysql_row['c_port']}' size='5'  maxlength='5'   /> </td>
        <td> <input type='text' name='form_q_port[{$id}]' value='{$mysql_row['q_port']}' size='5'  maxlength='5'   /> </td>
        <td> <input type='text' name='form_s_port[{$id}]' value='{$mysql_row['s_port']}' size='5'  maxlength='5'   /> </td>
        <td>
          <select name='form_zone[{$id}]'>";
//---------------------------------------------------------+
            for ($i=0; $i<=8; $i++)
            {
              $output .= "<option ".($mysql_row['zone'] == $i ? "selected='selected'" : "")." value='{$i}'> {$i} </option>";
            }
//---------------------------------------------------------+
          $output .= "
          </select>
        </td>
        <td style='text-align:center'>
          <input type='checkbox' name='form_disabled[{$id}]' value='1' ".($mysql_row['disabled'] ? "checked='checked'" : "")." />
        </td>
      </tr>
    </table>

    <div style='text-align:center'>
      <br />
      <input type='submit' name='lgsl_update'          value='Update Servers and Empty Cache' />
      <br />
      <br />
      <br />
      <br />
      <input type='submit' name='lgsl_map_image_paths' value='Show Map Image Paths' />
      <br />
      <br />
      <input type='submit' name='lgsl_advanced'        value='Advanced Management' />
      <br />
      <br />
    </div>
  </form>";


//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
//------  PLEASE MAKE A DONATION OR SIGN THE GUESTBOOK AT GREYCUBE.COM IF YOU REMOVE THIS CREDIT ---------------------------------------------------------------------------------------------------+
  $output .= "<div style='text-align:center; font-family:tahoma; font-size:9px'><br /><br /><br /><a href='http://www.greycube.com' style='text-decoration:none'>".lgsl_version()."</a><br /></div>";
//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+

?>
