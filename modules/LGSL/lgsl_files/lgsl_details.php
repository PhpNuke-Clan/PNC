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

  $lookup = lgsl_lookup_id($_GET['s']);

  if (!$lookup)
  {
    $output .= "<div style='text-align:center'> {$lgsl_config['text']['mid']} </div>"; return;
  }

  $server = lgsl_query_cached($lookup['ip'], $lookup['q_port'], $lookup['c_port'], $lookup['s_port'], $lookup['type'], "sep");

  $server = lgsl_sort_players($server);
  $server = lgsl_sort_extras($server);

  $misc   = lgsl_server_misc($server);
  $server = lgsl_server_html($server);

//------------------------------------------------------------------------------------------------------------+
// COLUMN NAMING AND ORDER TO SHOW ON THE PLAYER LIST

  $player_field_list = array
  (
  "name"    => "Name",
  "score"   => "Score",
  "deaths"  => "Deaths",
  "ping"    => "Ping",
  "team"    => "Team",
  "time"    => "Time",
  "bot"     => "Bot",

  "xp"      => "XP",
  "enemy"   => "Enemy",
  "goal"    => "Goal",
  "honor"   => "Honor",
  "kia"     => "K.I.A.",
  "leader"  => "Leader",
  "roe"     => "R.O.E.",
  "skill"   => "Skill",
  "skin"    => "Skin",
  "stats"   => "Stats",

  "rate"    => "Rate",
  "keyhash" => "Key Hash",
//"pid"     => "Player ID",
//"pbguid"  => "PB GUID",
  ""        => ""
  );

//------------------------------------------------------------------------------------------------------------+

  $output .= "
  <div style='text-align:center'>";

  $output .= "
  <div style='".lgsl_bg(TRUE)."; width:90%; height:6px; overflow:hidden; text-align:center; margin:auto; border:1px solid'><br /></div>
  <div style='height:20px'><br /></div>";

//------------------------------------------------------------------------------------------------------------+
// STANDARD INFO

  $output .= "
  <table cellpadding='4' cellspacing='0' style='margin:auto'>

    <tr>
      <td colspan='3' style='text-align:center'>
        <b> {$server['s']['name']} </b>
        <br /><br />
      </td>
    </tr>

    <tr>
      <td style='text-align:center'>
        <table cellpadding='4' cellspacing='2' style='margin:auto'>
          <tr style='".lgsl_bg()."'> <td> <b> {$lgsl_config['text']['sts']} </b> </td> <td style='white-space:nowrap'> {$misc['text_status']}                                   </td> </tr>
          <tr style='".lgsl_bg()."'> <td> <b> {$lgsl_config['text']['adr']} </b> </td> <td style='white-space:nowrap'> {$server['b']['ip']}                                     </td> </tr>
          <tr style='".lgsl_bg()."'> <td> <b> {$lgsl_config['text']['cpt']} </b> </td> <td style='white-space:nowrap'> {$server['b']['c_port']}                                 </td> </tr>
          <tr style='".lgsl_bg()."'> <td> <b> {$lgsl_config['text']['qpt']} </b> </td> <td style='white-space:nowrap'> {$server['b']['q_port']}                                 </td> </tr>
        </table>
      </td>
      <td style='text-align:center'>
        <table cellpadding='4' cellspacing='2' style='margin:auto'>
          <tr style='".lgsl_bg()."'> <td> <b> {$lgsl_config['text']['typ']} </b> </td> <td style='white-space:nowrap'> {$server['b']['type']}                                   </td> </tr>
          <tr style='".lgsl_bg()."'> <td> <b> {$lgsl_config['text']['gme']} </b> </td> <td style='white-space:nowrap'> {$server['s']['game']}                                   </td> </tr>
          <tr style='".lgsl_bg()."'> <td> <b> {$lgsl_config['text']['map']} </b> </td> <td style='white-space:nowrap'> {$server['s']['map']}                                    </td> </tr>
          <tr style='".lgsl_bg()."'> <td> <b> {$lgsl_config['text']['plr']} </b> </td> <td style='white-space:nowrap'> {$server['s']['players']} / {$server['s']['playersmax']} </td> </tr>
        </table>
      </td>
      <td style='text-align:center'>
        <div style='background-image:url({$misc['image_map']}); background-repeat:no-repeat; background-position:center'>
          <img alt='' style='border:none' src='{$misc['image_map_password']}' title='{$misc['text_type_game']}' />
        </div>
      </td>
    </tr>

  </table>

  <div style='height:20px'><br /></div>";

//------------------------------------------------------------------------------------------------------------+

  $output .= "
  <div style='".lgsl_bg(TRUE)."; width:90%; height:6px; overflow:hidden; text-align:center; margin:auto; border:1px solid'><br /></div>
  <div style='height:20px'><br /></div>";

//------------------------------------------------------------------------------------------------------------+
// PLAYER INFO

  if (!$server['p'])
  {
    $output .= "
    <table cellpadding='4' cellspacing='2' style='margin:auto'>
      <tr style='".lgsl_bg(FALSE)."'>
        <td> {$lgsl_config['text']['npi']} </td>
      </tr>
    </table>

    <div style='height:20px'><br /></div>";
  }
  else
  {
    $used_field_list = array();

    foreach ($player_field_list as $field => $title)
    {
      foreach ($server['p'] as $player)
      {
        if (isset($player[$field]))
        {
          $used_field_list[$field] = $title;
        }
      }
    }

    $output .= "
    <table cellpadding='4' cellspacing='2' style='margin:auto'>
      <tr style='".lgsl_bg(FALSE)."'>";

      foreach ($used_field_list as $field => $title)
      {
        $output .= "
        <td> <b>{$title}</b> </td>";
      }

      $output .= "
      </tr>";

      foreach ($server['p'] as $player_key => $player)
      {
        $output .= "
        <tr style='".lgsl_bg()."'>";

        foreach ($used_field_list as $field => $title)
        {
          $output .= "<td> {$player[$field]} </td>";
        }

        $output .= "
        </tr>";
      }

    $output .= "
    </table>

    <div style='height:20px'><br /></div>";
  }

//------------------------------------------------------------------------------------------------------------+

  $output .= "
  <div style='".lgsl_bg(TRUE)."; width:90%; height:6px; overflow:hidden; text-align:center; margin:auto; border:1px solid'><br /></div>
  <div style='height:20px'><br /></div>";

//------------------------------------------------------------------------------------------------------------+
// EXTRA INFO

  if (!$server['e'])
  {
    $output .= "
    <table cellpadding='4' cellspacing='2' style='margin:auto'>
      <tr style='".lgsl_bg(FALSE)."'>
        <td> {$lgsl_config['text']['nei']} </td>
      </tr>
    </table>

    <div style='height:20px'><br /></div>";
  }
  else
  {
    $output .= "
    <table cellpadding='4' cellspacing='2' style='margin-left:auto; margin-right:auto;'>

      <tr style='".lgsl_bg(FALSE)."'>
        <td> <b>Setting</b> </td>
        <td> <b>Value  </b> </td>
      </tr>";

    foreach ($server['e'] as $field => $value)
    {
      $color = lgsl_bg();

      $output .= "
      <tr>
        <td style='{$color}'> {$field} </td>
        <td style='{$color}'> {$value} </td>
      </tr>";
    }

    $output .= "
    </table>

    <div style='height:20px'><br /></div>";
  }

//------------------------------------------------------------------------------------------------------------+

  $output .= "
  <div style='".lgsl_bg(TRUE)."; width:90%; height:6px; overflow:hidden; text-align:center; margin:auto; border:1px solid'><br /></div>
  <div style='height:20px'><br /></div>";

  $output .= "
  </div>";

//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
//------  PLEASE MAKE A DONATION OR SIGN THE GUESTBOOK AT GREYCUBE.COM IF YOU REMOVE THIS CREDIT ---------------------------------------------------------------------------------------------------+
  $output .= "<div style='text-align:center; font-family:tahoma; font-size:9px'><br /><br /><br /><a href='http://www.greycube.com' style='text-decoration:none'>".lgsl_version()."</a><br /></div>";
//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+

?>
