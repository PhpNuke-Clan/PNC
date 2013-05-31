<?php
// +---------------------------------------------------------------------------+
// | Site Info Block (v2.2) to run with PhpNuke's Sentinel Module.         |
// | Block is based on Protector userblock                         |
// +---------------------------------------------------------------------------+
// | Copyright (c) Orginal Author: unknown                                     |
// | Due to its long length, the history of changes was moved below the code.  |
// |                                                                           |
// | This modified version is free software; you can redistribute it and/or    |
// | modify it under the terms of The Clarified Artistic License.              |
// |                                                                           |
// | This software is provided "AS IS" and WITHOUT ANY EXPRESSED OR IMPLIED    |
// | WARRANTIES, including, without limitation, the implied warranties of      |
// | MERCHANTIBILITY AND FITNESS FOR A PARTICULAR PURPOSE. See the enclosed    |
// | copy of the license for details.                                          |
// +---------------------------------------------------------------------------+
// | Created/Modified for PNC, http://www.phpnuke-clan.net                     |
// | BY: XenoMorpH ¤TÐI¤ webmaster@tdi-hq.com                                  |
// +---------------------------------------------------------------------------+

//$start_time = microtime();
define('_PSLOSTPASSWORD', 'Lost Password');
define('_PSWAIT', 'Waiting');
define('_PSHIDDEN', 'Hidden');
define('_PSEXCLUDED', 'Excluded');
define('_PSTODAY', 'Today');
define('_PSYESTERDAY', 'Yesterday');
define('_PSHITS', 'Hits');
define('_PSSERVDT', 'Server Date/Time');
define('_PSPOST', 'Post');
define('_PSPOSTS', 'Posts');
define('_PSANON', 'Anonymous');
//********************************  Configuration Start  ********************************

$CONF['showGuests']       = true; // display guests partial ip's to all
$CONF['showGuestsAdmin']  = true; // display guests full ip's to admins only
$CONF['showServer']       = true; // display server date/time to all
$CONF['showServerAdmin']  = true; // display server date/time to admins only
$CONF['max_length']       = 8;    // maximum character length to display for usernames
$CONF['gmt_offset']       = -8;   // desired timezone offset in hours from GMT
$CONF['max_anon']         = 50;   // maximum number of online anonymous users IPs to display
$CONF['max_users']        = 50;   // maximum number of online registered user names to display
$CONF['cache_life']       = 0;    // number of minutes before data expires and needs refreshing
                                  // if zero, no data is cached; if gt 0 then everything except
                                  // post and private message counts and server time is cached
$CONF['online_time']      = 20;    // amount of minutes a member will be shown on the online
                                  // list after the user's last page refresh

//********************************  Configuration Stop   ********************************

//*** please do not touch below this line unless you know what you are doing ***

// do not execute file if it's accessed directly
if ( !defined('BLOCK_FILE') ) {
    Header("Location: ../index.php");
    die();
}


// Nuke unique: global variables needed from main script by this block
global $db, $f, $gfx_chk, $mode, $prefix, $startdate, $t, $redirect, $admin_file, $user_prefix, $userinfo;

// function to hide last two IP octets from the general public for privacy
function hideIP($ip, $CONF)
{
    if (!$CONF['is_admin']) {
        $ip = preg_replace("/(([0-9]{1,3}\.){1,2})[0-9]{1,3}\.[0-9]{1,3}/", "\\1xxx.xxx", $ip);
    }
    return $ip;
}

function ya_get_configs2(){

    global $prefix, $db;

    $configresult = $db->sql_query("SELECT config_name, config_value FROM ".$prefix."_cnbya_config");

    while (list($config_name, $config_value) = $db->sql_fetchrow($configresult)) {

                if (!get_magic_quotes_gpc()) { $config_value = stripslashes($config_value); }

        $config[$config_name] = $config_value;

    }

    return $config;

}
$ya_config2 = ya_get_configs2();
// function to refresh data which will be cached in the database
function getFreshData($CONF)
{
    global $db, $prefix, $admin_file, $user_prefix, $ipE;

    // retrieve last user to register
    $sql = "SELECT username, user_id FROM {$user_prefix}_users ORDER BY user_id DESC LIMIT 0,1";
    $result  = $db->sql_query($sql);
    $numrows = $db->sql_numrows($result);

    if ($numrows > 0) {
        $row = sql_fetch_array($result);
        $lastuser = $row['username'];
        $lastuid  = $row['user_id'];
        if ((strlen($lastuser) > $CONF['max_length']) && isset($CONF['max_length'])
            && ($CONF['max_length'] > 0)) {
            $short_lastuser  = substr($lastuser, 0, $CONF['max_length']);
            $short_lastuser .= '...';
        } else {
            $short_lastuser = $lastuser;
        }
        $lastuser_info = '<img src="images/userinfo/ur-moderator.gif" height="14" width="17" alt="" />&nbsp;' . _BLATEST .': <a href="modules.php?name=Your_Account&amp;op=userinfo&amp;username=' . $lastuser . '"><img src="images/userinfo/icon_mini_profile.gif" border="0" alt="PR" title="Profile of ' . $lastuser . '" /></a>&nbsp;
<a href="modules.php?name=Forums&file=profile&amp;mode=viewprofile&amp;u=' . $lastuid . '"><b>' . $short_lastuser . '</b></a><br />';
    } else {
        $lastuser_info = '';
    }


    // retrieve number of people who registered yesterday and today
    if (is_numeric($CONF['gmt_offset'])) {
        $timezone = 3600*$CONF['gmt_offset'];
    } else {
        $timezone = 0;
    }

    $todays_date     = gmdate("M d, Y", time() + $timezone);
    $yesterdays_date = gmdate("M d, Y", time() - 86400 + $timezone);
    $new_today       = 0;
    $new_yesterday   = 0;

    $sql = "SELECT COUNT(*) as count, user_regdate FROM ".$user_prefix."_users WHERE user_regdate LIKE '{$todays_date}' OR user_regdate LIKE '{$yesterdays_date}' GROUP BY user_regdate";
    $result  = $db->sql_query($sql);
    $numrows = $db->sql_numrows($result);

    if ($numrows > 0) {
        for ($i=0; $i < $numrows; $i++) {
            $row = sql_fetch_array($result);
            if ($row['user_regdate'] == $todays_date) {
                $new_today = $row['count'];
            } elseif ($row['user_regdate'] == $yesterdays_date) {
                $new_yesterday = $row['count'];
            }
        }
    }


    // retrieve number of people who have not activated their accounts yet
    $sql = "SELECT COUNT(*) as count FROM {$user_prefix}_users_temp";
    $result  = $db->sql_query($sql);
    $numrows = $db->sql_numrows($result);
    if ($numrows > 0) {
        $row = sql_fetch_array($result);
        $waiting = $row['count'];
    } else {
        $waiting = 0;
    }


    // retrieve total number of registered users
    $sql = "SELECT COUNT(*) as count FROM {$user_prefix}_users";
    $result  = $db->sql_query($sql);
    $numrows = $db->sql_numrows($result);
    if ($numrows > 0) {
        $row = sql_fetch_array($result);
        $overall = $row['count'];
    } else {
        $overall = 0;
    }

    // retrieve total number of those which are blocked
    $excluded = 0;
    $sql = "SELECT COUNT(*) as count FROM {$prefix}_blocked_robot as a, {$prefix}_session as b WHERE a.robot_ip = '$ipE'";
    $result  = $db->sql_query($sql);
    $numrows = $db->sql_numrows($result);
    if ($numrows > 0) {
        $row = sql_fetch_array($result);
        $excluded = $row['count'];
    }


$dater1= time()-$CONF['online_time']*60;
$lol=time()-$dater1;

    // retrieve total number of visitors and registered users currently online
    $visitors = 0;
    $members  = 0;
    $sql = "SELECT COUNT(*) as count, guest FROM {$prefix}_session WHERE time >'$dater1' GROUP BY guest";
    $result  = $db->sql_query($sql);
    $numrows = $db->sql_numrows($result);
    if ($numrows > 0) {
        for ($i=0; $i < $numrows; $i++) {
            $row = sql_fetch_array($result);
            if ($row['guest'] == 1) {
                if ($row['count'] >= $excluded) {
                    $visitors = $row['count'] - $excluded;
                } else {
                    $visitors = $row['count'];
                }
            } else {
                $members = $row['count'];
            }
        }
    }


    // calculate total number online
    $total = $visitors + $members;
    $totalplus = $visitors + $members + $excluded;


    // retrieve the names of registered visitors currently online
    // and a session check to show people who are online within the amount of minutes whish have been set
    $users_online = '';


    if($CONF['is_admin']) {
        $sql = "SELECT DISTINCT a.host_addr, b.user_id, b.username, b.user_allow_viewonline FROM {$prefix}_session as a, {$user_prefix}_users as b WHERE a.uname = b.username AND time >'$dater1' ORDER BY a.uname ASC LIMIT 0, {$CONF['max_users']}";
        }
     else {
        $sql = "SELECT DISTINCT a.host_addr, b.user_id, b.username FROM {$prefix}_session as a, {$user_prefix}_users as b WHERE a.uname = b.username AND time >'$dater1' AND b.user_allow_viewonline = 1 ORDER BY a.uname ASC LIMIT 0, {$CONF['max_users']}";
        }

    $result  = $db->sql_query($sql);
    $numrows = $db->sql_numrows($result);
    if ($numrows > 0) {
        $users_online .= '<hr noshade="noshade">';
        $users_online .= "Online last ". $CONF['online_time']." minutes<br>";
        for ($i=0; $i < $numrows; $i++) {
            $row = sql_fetch_array($result);
            $num = $i + 1;
            if ($num < 10) {
               $num = '0' . $num;
            }
            $remote_addr = hideIP($row['host_addr'], $CONF);
            if (strlen($row['username']) > $CONF['max_length']) {
                $short_username = substr($row['username'],0,$CONF['max_length']);
                $short_username .= '...';
            } else {
                $short_username = $row['username'];
            }
            $users_online .= $num . ': ';
            if ($CONF['is_admin']) {
                $users_online .= "<a href=\"".$admin_file.".php?op=ABSearchResults&amp;sip=" . $remote_addr . "\"><img src=\"images/userinfo/block_img.gif\" border=\"0\" alt=\"PS\" title=\"Check IP with Sentinel\" /></a>&nbsp;";
            }
            if($row['user_allow_viewonline'] == 0 && $CONF['is_admin']) {
        $users_online .= '<a href="modules.php?name=Your_Account&amp;op=userinfo&amp;username=' . $row['username'] . '"><img src="images/userinfo/icon_mini_profile.gif" border="0" alt="PR" title="Profile of ' . $row['username'] . '" /></a>&nbsp;<a href="modules.php?name=Private_Messages&amp;mode=post&amp;u=' . $row["user_id"] . '"><img src="images/userinfo/nopm.gif" border="0" alt="PM" title="Send private message to ' . $row['username'] . '" /></a>&nbsp;
<a href="modules.php?name=Forums&amp;file=profile&amp;mode=viewprofile&amp;u=' . $row['user_id'] . '">' . $short_username . '</a> [H]<br />';
        }
            else {
            $users_online .= '<a href="modules.php?name=Your_Account&amp;op=userinfo&amp;username=' . $row['username'] . '"><img src="images/userinfo/icon_mini_profile.gif" border="0" alt="PR" title="Profile of ' . $row['username'] . '" /></a>&nbsp;<a href="modules.php?name=Private_Messages&amp;mode=post&amp;u=' . $row["user_id"] . '"><img src="images/userinfo/nopm.gif" border="0" alt="PM" title="Send private message to ' . $row['username'] . '" /></a>&nbsp;
<a href="modules.php?name=Forums&amp;file=profile&amp;mode=viewprofile&amp;u=' . $row['user_id'] . '">' . $short_username . '</a><br />';
        }

    }
        }

    // retrieve a list of anonymous guests currently online
    $anon_online = '';
    if ($CONF['showGuests'] || ($CONF['showGuestsAdmin'] && $CONF['is_admin'])) {
        $sql = "SELECT DISTINCT host_addr FROM {$prefix}_session WHERE guest = 1 AND time >'$dater1' ORDER BY TIME ASC LIMIT 0, {$CONF['max_anon']}";
        
        $result  = $db->sql_query($sql);
        $numrows = $db->sql_numrows($result);
        if ($numrows > 0) {
            $anon_online .= '<hr noshade="noshade">';
            for ($i=0; $i < $numrows; $i++) {
                $row = sql_fetch_array($result);
                $num = $i + 1;
                if ($num < 10) {
                   $num = '0' . $num;
                }
                $remote_addr = hideIP($row['host_addr'], $CONF);
                $anon_online .= $num . ': ';
                if ($CONF['is_admin']) {
                    $anon_online .= "<a href=\"".$admin_file.".php?op=ABSearchResults&amp;sip=" . $remote_addr . "\">" . $remote_addr . "</a><br />";
                } else {
                    $anon_online .= $remote_addr . '<br />';
                }
            }
        }
    }

     // overall total hits to the site
    $hits_total = 0;
    $sql = "SELECT SUM(hits) as hits FROM {$prefix}_stats_year";
    $result  = $db->sql_query($sql);
    $numrows = $db->sql_numrows($result);
    if ($numrows > 0) {
       $row = sql_fetch_array($result);
       $hits_total = $row['hits'];
    }


    // total hits for today and yesterday
    // hits for today
    $hits_today = 0;
    $t_time  = time();
    $t_year  = date("Y", $t_time);
    $t_month = date("n", $t_time);
    $t_date  = date("j", $t_time);
    $sql = "SELECT hits FROM {$prefix}_stats_date WHERE year='{$t_year}' AND month='{$t_month}' AND date='{$t_date}'";
    $result  = $db->sql_query($sql);
    $numrows = $db->sql_numrows($result);

    if ($numrows > 0) {
       $row = sql_fetch_array($result);
       $hits_today = $row['hits'];
    }

    // hits for yesterday
    $hits_yesterday = 0;
    $y_time  = time() - 86400;
    $y_year  = date("Y", $y_time);
    $y_month = date("n", $y_time);
    $y_date  = date("j", $y_time);
    $sql = "SELECT hits FROM {$prefix}_stats_date WHERE year='{$y_year}' AND month='{$y_month}' AND date='{$y_date}'";
    $result  = $db->sql_query($sql);
    $numrows = $db->sql_numrows($result);
    if ($numrows > 0) {
       $row = sql_fetch_array($result);
       $hits_yesterday = $row['hits'];
    }

    // build the middle section of the block
    $block_middle = '<img src="images/userinfo/group-2.gif" height="14" width="17" alt="" />&nbsp;<b><u>' . _BMEMP . ':</u></b><br />' . $lastuser_info .
'<img src="images/userinfo/ur-author.gif" height="14" width="17" alt="" />&nbsp;' .  _PSTODAY . ': <b>' . $new_today . '</b><br />
<img src="images/userinfo/ur-admin.gif" height="14" width="17" alt="" />&nbsp;' .  _PSYESTERDAY . ': <b>' . $new_yesterday . '</b><br />
<img src="images/userinfo/ur-member.gif" height="14" width="17" alt="" />&nbsp;' . _PSWAIT . ': <b>' . $waiting . '</b><br />
<img src="images/userinfo/ur-guest.gif" height="14" width="17" alt="" />&nbsp;' . _BOVER . ': <b>' . $overall . '</b><br /><hr />
<img src="images/userinfo/group-3.gif" height="14" width="17" alt="" />&nbsp;<b><u>' . _BVISIT . ':</u></b><br />
<img src="images/userinfo/ur-anony.gif" height="14" width="17" alt="" />&nbsp;' . _BVIS . ': <b>' . $visitors . '</b><br />
<img src="images/userinfo/ur-member.gif" height="14" width="17" alt="" />&nbsp;' . _BMEM . ': <b>' . $members . '</b><br />
<img src="images/userinfo/ur-admin.gif" height="14" width="17" alt="" />&nbsp;' . _PSEXCLUDED . ': <b>(' . $excluded . ')</b><br />
<img src="images/userinfo/ur-registered.gif" height="14" width="17" alt="" />&nbsp;' . _BTT . ': <b>' . $totalplus . ' (' . $excluded . ') </b><br />' . $users_online  . $anon_online .
'<hr noshade="noshade"><div align="center"><small>' . _WERECEIVED . '</small><br />
<b><a href="modules.php?name=Statistics">' . $hits_total . '</a></b><br />
<small>' . _PAGESVIEWS . '<br />' . $CONF['startdate'] . '</small></center><hr noshade="noshade"><center>' . _PSHITS . ' ' . _PSTODAY . ": <b><a href=\"modules.php?name=Statistics&amp;op=DailyStats&amp;year=$t_year&amp;month=$t_month&amp;date=$t_date\">" . $hits_today . '</a></b><br />' . _PSHITS. ' ' . _PSYESTERDAY . ": <b><a href=\"modules.php?name=Statistics&amp;op=DailyStats&amp;year=$y_year&month=$y_month&date=$y_date\">" . $hits_yesterday . '</a></b><br /></div>';

    if (isset($CONF['cache_life']) && ($CONF['cache_life'] > 0)) {
        if ($CONF['is_admin']) {
            $bkey  = 'siadmincache';
            $title = 'Site Info Admin Cache';
        } else {
            $bkey = 'sicache';
            $title = 'Site Info Cache';
        }
//echo("func break 1...cachelife: $CONF[cache_life]<br>");
        $cachetime = time() + ($CONF['cache_life']*60);
        if (isset($CONF['noentry']) && $CONF['noentry']) {
//echo("func break 2<br>");
            $sql = "INSERT INTO {$CONF['prefix']}_blocks (bkey, title, content, bposition, active, time) VALUES ('{$bkey}', '{$title}', '{$block_middle}', 'l', '0', '{$cachetime}')";
//echo("<br>sql: $sql<br>");
            $result = $db->sql_query($sql);
        } else {
//echo("func break 3<br>");
            $sql = "UPDATE {$CONF['prefix']}_blocks SET content = '{$block_middle}', time = '{$cachetime}' WHERE bkey = '{$bkey}'";
            $result = $db->sql_query($sql);
        }
    }
    return $block_middle;

} // end function getFreshData()

//******************************** Block Top **************************************

// check whether visitor is logged in as admin, user, or anonymous visitor
// also set username and security code if needed
$CONF['is_admin']  = false;
$CONF['logged_in'] = false;

if (is_admin($_COOKIE['admin'])) {
    $CONF['is_admin']  = true;
    $cookie    = $_COOKIE['admin'];
    $cookie    = base64_decode($cookie);
    $cookie    = explode(":", $cookie);
    $username  = $cookie[0];
}

if (is_user($_COOKIE['user'])) {
    $CONF['logged_in'] = true;
    $cookie    = $_COOKIE['user'];
    $cookie    = base64_decode($cookie);
    $cookie    = explode(":", $cookie);
    $username  = $cookie[1];
    $uid       = $cookie[0];
} else {
    $username  = _PSANON;
    // create security code
        if (extension_loaded("gd") AND ($ya_config2['usegfxcheck'] == 2 OR $ya_config2['usegfxcheck'] == 3)) {
        mt_srand ((double)microtime()*1000000);
        $maxran = 1000000;
        $random_num = mt_rand(0, $maxran);
        $security_code = _SECURITYCODE . ': <img src="modules.php?name=Your_Account&amp;op=gfx&amp;random_num='.$random_num.'" border="1" alt="' . _SECURITYCODE . '" title="' . _SECURITYCODE . '" /><br />' . _TYPESECCODE . ': <input type="text" name="gfx_check" size="11" maxlength="10" /><br />';
    } else {
        $random_num = '';
		$security_code = '';
    }
}


// if username is greater than desired maximum length then shorten the name for display
if (!$CONF['logged_in']) {
    $short_username  = $username;
} else {
    if ((strlen($username) > $CONF['max_length']) && isset($CONF['max_length'])
        && ($CONF['max_length'] > 0)) {
        $short_username  = substr($username, 0, $CONF['max_length']);
        $short_username .= '...';
    } else {
        $short_username  = $username;
    }
}


if ($CONF['logged_in']) {
     // retrieve total number of posts made by this user
    //$sql = "SELECT COUNT(*) as count FROM {$prefix}_bbposts as a, {$prefix}_users as b WHERE a.poster_id = b.user_id";
    $sql = "SELECT COUNT(*) as count FROM {$prefix}_bbposts WHERE poster_id = '{$uid}'";
    $result  = $db->sql_query($sql);
    $numrows = $db->sql_numrows($result);

    if ($numrows > 0) {
        $row = sql_fetch_array($result);
        $total_posts = $row['count'];
    } else {
        $total_posts = 0;
    }

    if ($total_posts == 1) {
        $lang_posts = _PSPOST;
    } else {
        $lang_posts = _PSPOSTS;
    }

    // retrieve total number of private messages read and unread
$newpms_query = $db->sql_query("SELECT privmsgs_to_userid FROM ".$prefix."_bbprivmsgs WHERE privmsgs_to_userid='$uid' AND (privmsgs_type='5' OR privmsgs_type='1')");
$oldpms_query = $db->sql_query("SELECT privmsgs_to_userid FROM ".$prefix."_bbprivmsgs WHERE privmsgs_to_userid='$uid' AND privmsgs_type='0'");
$total_unread = $db->sql_numrows($newpms_query);
$total_read = $db->sql_numrows($oldpms_query);

    $sql = "SELECT user_avatar FROM {$user_prefix}_users WHERE user_id={$uid}";
    $result  = $db->sql_query($sql);
    $row = $db->sql_fetchrow($result);
        $avatarus = $row['user_avatar'];
        $avatarus1= $avatarus;
        if (ereg("http", $row['user_avatar'])) {
                        //avatarfix by menelaos dot hetnet dot nl
                        $avatarus = "".$row['user_avatar']."";
                        } else {
                        $avatarus = "modules/Forums/images/avatars/".$row['user_avatar']."";
        }
    $block_top =
'<div align="center">
<img src='.$avatarus.' alt="" /></div>
<div align="center">' . $total_posts . ' ' . $lang_posts . '</div><br />
<img src="images/userinfo/icon_members.gif" height="14" width="17">&nbsp;' ._BWEL. ', <b>' . $short_username . '</b><br />
<img src="images/arrow.gif" width="17" border="0" alt="" />&nbsp;<a href="modules.php?name=Your_Account&amp;op=logout">' . _LOGOUT . '</a>
<hr />
<img src="images/userinfo/email-y.gif" height="10" width="14" alt="" /> <a href="modules.php?name=Private_Messages"><b>' . _BPM . '</b></a><br />
<img src="images/userinfo/email-r.gif" height="10" width="14" alt="" />&nbsp;' .  _BUNREAD . ': <b>' . $total_unread . '</b><br />
<img src="images/userinfo/email-g.gif" height="10" width="14" alt="" />&nbsp;' . _BREAD . ': <b>' . $total_read . '</b><br />
<hr />';

} else {
    $block_top =
'<img src="images/userinfo/icon_members.gif" height="14" width="17" alt="" />&nbsp;' ._BWEL. ', <b>' . $short_username . '</b><hr />
<form action="modules.php?name=Your_Account" method="post">
 <table>
  <tr>
   <td>' . _NICKNAME . '</td>
   <td><input type="text" name="username" size="10" maxlength="25" /></td>
  </tr>
  <tr>
   <td>' . _PASSWORD . '</td>
   <td><input type="password" name="user_password" size="10" maxlength="20" /></td>
  </tr>
 </table>' . $security_code .
 '<input type="hidden" name="random_num" value="'.$random_num.'" />
 <input type="hidden" name="redirect" value="'.$redirect.'" />
 <input type="hidden" name="mode" value="'.$mode.'" />
 <input type="hidden" name="f" value="'.$f.'" />
 <input type="hidden" name="t" value="'.$t.'" />&nbsp;&nbsp;
 <input type="hidden" name="op" value="login" />
 <input type="submit" value="'._LOGIN.'">
 <br />&nbsp;&middot;&nbsp;<a href="modules.php?name=Your_Account&amp;op=new_user">' . _BREG . '</a><br />
 &nbsp;&middot;&nbsp;<a href="modules.php?name=Your_Account&amp;op=pass_lost">' . _PSLOSTPASSWORD . '</a>
</form><hr />';

}
//******************************** Block Middle **************************************
// initialize vars to pass into function getFreshData
$CONF['startdate'] = $startdate;
$CONF['prefix']    = $prefix;

// check whether to cache data for this block
if (isset($CONF['cache_life']) && ($CONF['cache_life'] > 0)) {
    if ($CONF['is_admin']) {
        $sql = "SELECT content, time FROM {$prefix}_blocks WHERE bkey = 'siadmincache'";
    } else {
        $sql = "SELECT content, time FROM {$prefix}_blocks WHERE bkey = 'sicache'";
    }
    $result  = $db->sql_query($sql);
    $numrows = $db->sql_numrows($result);

    if ($numrows > 0) {
        $row = sql_fetch_array($result);
//$a = time();
//$b = $row['time'];
//$c = $b - $a;
//echo("time left on cache: $c<br>");
        // if no content or unsure of cache age then update data
        if (empty($row['time']) || empty($row['content'])) {
             $block_middle = getFreshData($CONF);
        // use cached version if data's cache life is still good
        } elseif ($row['time'] >= time()) {
//echo("break 1<br>");
            $block_middle = $row['content'];
        // if cache is too old then update data
        } else {
//echo("break 2<br>");
            $block_middle = getFreshData($CONF);
        }
    // if no cache exists then retrieve current data
    } else {
//echo("break 3<br>");
        $CONF['noentry'] = true;
        $block_middle = getFreshData($CONF);
    }
// if cache is turned off then retrieve current data
} else {
//echo("break 4<br>");
    $block_middle = getFreshData($CONF);
}

//******************************** Block Foot **************************************

// calculate server date/time
if ($CONF['showServer'] || ($CONF['showServerAdmin'] && $CONF['is_admin'])) {
        $server_time = date("j F Y\nH:i:s T");
        $zone        = date("Z")/3600;
        if ($zone >= 0) {
                $zone = "+".$zone;
        }
    $block_foot =  '<hr noshade="noshade" /><div align="center">'
        . _PSSERVDT . ": <br />$server_time (GMT $zone)</div><br />";
} else {
    $block_foot = '';
}

//******************************* Put It All Together *******************************

$content = $block_top . $block_middle .  $block_foot;
//$end_time = microtime();
//$total_time = ($end_time - $start_time);
//$s = substr($total_time,0,7);
//$total_time = "Block loaded in: $s seconds";
//echo($total_time);
//******************************* History of Changes *******************************
/************************************************************/
/* Optimized code, significantly reduced SQL queries, and   */
/* added caching to speed up execution and lighten server   */
/* load. Added row checking to eliminate ambigious warnings */
/* when no data is returned from database. Added display of */
/* guest ips and a few more configurable settings. Merged   */
/* hidden category under visitor category                   */
/*                                                          */
/* Added Sentinel System lookup for excluded ip.               */
/* Dont show if excluded - 26 Dec 2006    XenoMorpH        */
/* website http://phpnuke-clan.net                          */
/*                                                          */
/* Modified 6 March 2004 by kipuka http://www.lavapower.com/*/
/*                                */
/* Added Protector System lookup for excluded ip.           */
/* Dont show if excluded - 23 Oct 2003 Marcus aka Mister    */
/* website http://protector.warcenter.se                    */
/*                                                          */
/* Added Check for total numbers of letters in a username   */
/* If longer then $TEXT_LEN then cut.                       */
/* Good to make the block keep it's size                    */
/* - 25 Oct 2003 Marcus aka Mister                          */
/* website http://protector.warcenter.se                    */
/*                                                          */
/* Added Protector System lookup for registered users for   */
/* Admins only (if exist)- 23 Oct 2003 Marcus aka Mister    */
/* website http://protector.warcenter.se                    */
/*                                                          */
/* Added $gfx_chk code to allow disabling as per v6.9 code. */
/* 21 October 2003  Gaylen Fraley                           */
/*                                                          */
/* Added 3 new hyperlink things :).  First off, if my block */
/* detects that you are using the Resend_Email module, it   */
/* will hyperlink the 'Waiting' text to the Resend_Email    */
/* block automatically.  Then, there is a new module        */
/* UserInfoAddons that the block will check for and if found*/
/* will hyperlink the New Today and New Yesterday text and  */
/* will display the new users from today and yesterday!     */
/* 30 Sept 2003 Gaylen Fraley                               */
/* website http://www.ravenphpscripts.com                   */
/*                                                          */
/* Added Sam Spade lookup for registered users for Admins   */
/* only - 24 Sept 2003 Gaylen Fraley                        */
/* website http://www.ravenphpscripts.com                   */
/*                                                          */
/* Added 4 user settings - 20 Sept 2003 Gaylen Fraley       */
/* Added Hidden User Count - 20 Sept 2003 Gaylen Fraley     */
/* website http://www.ravenphpscripts.com                   */
/*                                                          */
/* Added user_avatar - 18 July 2003 Gaylen Fraley           */
/* website http://www.ravenphpscripts.com                   */
/*                                                          */
/* Update for PHP-Nuke 6.5 - 30 July 2003 Gaylen Fraley     */
/* website http://www.ravenphpscripts.com                   */
/*                                                          */
/* Update for PHP-Nuke 6.5 - 05 March 2003 Gaylen Fraley    */
/* website http://www.ravenphpscripts.com                   */
/*                                                          */
/* Updated for PHP-Nuke 5.6 -  18 Jun 2002 NukeScripts      */
/* website http://www.nukescripts.com                       */
/*                                                          */
/* Updated for PHP-Nuke 5.5 - 24/03/2002 Rugeri             */
/* website http://newsportal.homip.net                      */
/*                                                          */
/* (C) 2002                                                 */
/* All rights beyond the GPL are reserved                   */
/*                                                          */
/* Please give a link back to my site somewhere in your own */
/*                                                          */
/************************************************************/
?>
