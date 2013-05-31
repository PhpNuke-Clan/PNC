<?php
/* #####################################################################################
 *
 * $Id: admin.php,v 1.127 2004/09/12 12:58:09 mabu Exp $
 *
 * This notice must remain untouched at all times.
 *
 * Modifications to the script, except the offricial addons or hacks,
 * without the owners permission are prohibited.
 * All rights reserved to their proper authors.
 *
 * ---------------------------------------------
 * http://www.vwar.de || Copyright (C) 2001-2004
 * ---------------------------------------------
 *
 * #####################################################################################
 */
$fs_refer= $_SERVER ['REQUEST_URI'];
$fs_refer = explode("=", $fs_refer);
if($fs_refer[0]=="/modules/vwar/admin/admin.php?vwar_root"){
echo"go away"; exit();}
//echo "$fs_refer[0] is now a URL without ?.<br />"; 
//echo "$fs_refer[1] is the bit that used to follow the =.<br />";

// get functions
$vwar_root = "./../";
require($vwar_root . "modname.php");
require($vwar_root . "includes/functions_common.php");
require($vwar_root . "includes/functions_admin.php");

// unset vars to prevent sql-injections
$show                   = "";
$showgame       = "";

// update repeating datelines
updateRepeatingDatelines("vwar".$n, "warid", "dateline", 1, $waroverlap);

if (!checkCookie())
{
        header("Location: index.php");
}

// ################################### warlist #########################################
if ($GPC['action'] == "warlist")
{
        checkPermission("canaddwar-caneditwar-candeletewar-canfinishwar");
        $vwartpl->cache("gameselectbit2,gameselectbit,admin_repeatingwarinformation,admin_warlistbit,admin_warlist");
        eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");

        if (!empty($showgame))
        {
                $result = $vwardb->query_first("SELECT COUNT(warid) AS numwars FROM vwar".$n." WHERE gameid = '".$showgame."'");
        } else {
                $result = $vwardb->query_first("SELECT COUNT(warid) AS numwars FROM vwar".$n."");
        }
        $numwars = $result['numwars'];

        $result = $vwardb->query("
                SELECT vwar".$n."_games.gameid, gamename, COUNT(warid) AS numwars
                FROM vwar".$n."_games, vwar".$n."
                WHERE vwar".$n."_games.gameid = vwar".$n.".gameid
                AND vwar".$n."_games.deleted = '0'
                GROUP BY vwar".$n."_games.gameid
                ORDER BY gamename
        ");
        while ($row = $vwardb->fetch_array($result))
        {
                if ($row['numwars'] > 0)
                {
                        $gameid = $row['gameid'];
                        $gamename = $row['gamename'] . "&nbsp;(" . $row['numwars'].")";

                        if ($showgame == $gameid)
                        {
                                eval("\$gameselectbit .= \"".$vwartpl->get("gameselectbit2")."\";");
                        } else {
                                eval("\$gameselectbit .= \"".$vwartpl->get("gameselectbit")."\";");
                        }
                }
        }

        if (!empty($showgame))
        {
                $show = "WHERE vwar".$n.".gameid='" . $showgame . "'";
        }

        $result = $vwardb->query("
                SELECT
                vwar".$n.".warid, changedtime, repeat_mod, repeat_number,       vwar".$n.".status,
                vwar".$n.".dateline,    vwar".$n.".oppid,       oppname,oppnameshort,   COUNT(partid) AS numavailable
                FROM vwar".$n."
                LEFT JOIN vwar".$n."_opponents ON (vwar".$n.".oppid = vwar".$n."_opponents.oppid)
                LEFT JOIN vwar".$n."_participants ON (vwar".$n.".warid = vwar".$n."_participants.warid)
                $show
                GROUP BY vwar".$n.".warid
                ORDER BY vwar".$n.".dateline DESC
                " . getLimitClause()
        );
        while ($row = $vwardb->fetch_array($result))
        {
                $numavailable = $row['numavailable'];
                $wardate = formatdatetime($row['dateline'], $shortdateformat);

                $result2 = $vwardb->query_first("
                        SELECT name, addedtime
                        FROM vwar".$n.", vwar".$n."_member
                        WHERE memberid = addedby
                        AND warid = '".$row['warid']."'
                ");

                $addedstring = ifelse($result2['addedtime'] != 0, $result2['name'] . ", ".formatdatetime($result2['addedtime']), "-");

                $result2 = $vwardb->query_first("
                        SELECT name, changedtime
                        FROM vwar".$n.", vwar".$n."_member
                        WHERE memberid=changedby
                        AND warid='".$row['warid']."'
                ");

                $changedstring = ifelse($result2['changedtime'] != 0, $result2['name'] . ", " . formatdatetime($result2['changedtime']), "-");

                // If war is self-repeating, make the repeat-information:
                if (!empty($row["repeat_mod"]) && !empty($row["repeat_number"]))
                {
                        $repeating = "every " . $row['repeat_number'] . " " . $row['repeat_mod'];
                        $status = makeimgtag($vwar_root . "images/repeat.gif","repeating","top") . "&nbsp;repeating<br>";
                        if ( $row["repeat_number"] == 1 )
                        {
                                switch ( $row["repeat_mod"] )
                                {
                                        case "hours":   $repeating = "every hour";
                                                        break;
                                        case "days":    $repeating = "daily";
                                                        break;
                                        case "weeks":   $repeating = "weekly";
                                                        break;
                                        case "months":  $repeating = "monthly";
                                                        break;
                                        case "years":   $repeating = "yearly";
                                                        break;
                                }
                        }
                        if ($row['repeat_mod'] == "date")
                        {
                                $repeating  = "every ";
                                if ( $row["repeat_number"] == 12 ) {
                                        $repeating .= "year ";
                                } else if ( $row["repeat_number"] == 1 ) {
                                        $repeating  = "each month ";
                                }  else {
                                        $repeating .= $row["repeat_number"] . ". month ";
                                }
                                $repeating .= "on this date";
                        }
                        eval("\$repeatinformation = \"".$vwartpl->get("admin_repeatingwarinformation")."\";");
                }

                if ($row['status'] == 1) $status .= makeimgtag($vwar_root . "images/check.gif","finished","top") . "&nbsp;finished";

                switchColors();
                eval("\$admin_warlistbit .= \"".$vwartpl->get("admin_warlistbit")."\";");

                unset($finished);
                unset($addedstring);
                unset($repeatinformation);
                unset($status);
        }
        $pagelinks = makepagelinks($numwars, $perpage,"action=warlist&amp;showgame=" . $showgame . "");

        eval("\$vwartpl->output(\"".$vwartpl->get("admin_warlist")."\");");
}

// ################################### add war #########################################
if ($GPC['action'] == "addwar")
{
        checkPermission("canaddwar");

        if (isset($gameid)) $GPC['gameid'] = $gameid;
        if (isset($gametypeid)) $GPC['gametypeid'] = $gametypeid;
        if (isset($matchtypeid)) $GPC['matchtypeid'] = $matchtypeid;

        // if added from challenges, get vars here
        if (isset($HTTP_GET_VARS['challengeid']))
        {
                $challengeinfo = $vwardb->query_first("SELECT * FROM vwar".$n."_challenge WHERE challengeid = '".$GPC['challengeid']."'");
                #dbSelect($challengeinfo);

                $GPC['gameid']                                  = $challengeinfo['gameid'];
                $GPC['gametypeid']                      = $challengeinfo['gametypeid'];
                $GPC['matchtypeid']             = $challengeinfo['matchtypeid'];
                $GPC['oppname']                                 = $challengeinfo['teamname'];
                $GPC['oppnameshort']            = $challengeinfo['teamnameshort'];
                $GPC['oppcontactname']  = $challengeinfo['contactname'];
                $GPC['oppcontactmail']  = $challengeinfo['contactemail'];
                $GPC['oppcontacticq']   = $challengeinfo['contacticq'];
                $GPC['oppcontactaim']   = $challengeinfo['contactaim'];
                $GPC['oppcontactyim']   = $challengeinfo['contactyim'];
                $GPC['oppcontactmsn']   = $challengeinfo['contactmsn'];
                $GPC['opphomepage']             = $challengeinfo['contacthomepage'];
                $GPC['oppircnetwork']   = $challengeinfo['contactircnetwork'];
                $GPC['oppircchannel']   = $challengeinfo['contactircchannel'];
                $playerperteam                                  = $challengeinfo['playerperteam'];
                $warinfo                                                                = $challengeinfo['challengeinfo'];
                $dateline                                                       = $challengeinfo['dateline'];
                $locationinfo                                   = split("\|\|", $challengeinfo['locations']);

                for ($i = 0; $i <= sizeof($locationinfo); $i++)
                {
                        $warlocation[$i+1] = $locationinfo[$i];
                }
        }

        if ($GPC['add'] || $GPC['add_x'])
        {
                // make timestamp
                list ($hour, $minute) = split("[:]", $wartime);
                $dateline = mktime( $hour, $minute, 0, $month, $day, $year);
                if ($dateline < 0 ) $dateline = 0;

                // check for wrong data
                if ($gameid == "" || $gametypeid == "" || $matchtypeid == "" || !($dateline >= 0) || (sizeof($warlocation) <= 1))
                {
                        $vwartpl->cache("admin_message_error_missingdata");
                        eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
                        eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_error_missingdata")."\");");
                        exit;
                }

                if ($GPC["makerepeat"] == 1 AND $GPC["repeat"] == 0 AND is_numeric($GPC["repeat_number"]) AND !empty($GPC["repeat_mod"]))
                {
                        $repeatmod    = $GPC["repeat_mod"];
                        $repeatnumber = $GPC["repeat_number"];
                }
                else if ($GPC["makerepeat"] == 1 AND $GPC["repeat"] == 1 AND $GPC["repeat_date"] > 0)
                {
                        if ( $GPC["repeat_date"] < 13 AND $day < 30 )
                        {
                                $repeatmod    = "date";
                                $repeatnumber = $GPC["repeat_date"];
                        }
                        else if ( $GPC["repeat_date"] == 13 )
                        {
                                $repeatmod    = "date";
                                $repeatnumber = 13;
                        }
                }
                $repeatsave = $GPC["repeat_saveas"];

                if (isset($challengeid))
                {
                        $vwardb->query("DELETE FROM vwar".$n."_challenge WHERE challengeid = '".$challengeid."'");
                }
                if ($opphomepage) $opphomepage = checkUrlFormat($opphomepage);
                if (!empty($GPC['oppid']))
                {
                        $vwardb->query("
                                UPDATE vwar".$n."_opponents
                                SET
                                oppnameshort = '".$oppnameshort."',
                                oppname = '".$oppname."',
                                oppcontactname = '$oppcontactname',
                                oppcontactmail = '$oppcontactmail',
                                oppcontacticq = '$oppcontacticq',
                                oppcontactaim = '$oppcontactaim',
                                oppcontactyim = '$oppcontactyim',
                                oppcontactmsn = '$oppcontactmsn',
                                oppircchannel = '$oppircchannel',
                                oppircnetwork = '$oppircnetwork',
                                opphomepage = '$opphomepage',
                                oppcountry = '$oppcountry'
                                WHERE oppid = '$oppid'
                        ");
                }
                else if ($oppnameshort != "" && $oppname != "")
                {
                        $vwardb->query("
                        INSERT INTO vwar".$n."_opponents
                        VALUES (
                                NULL,
                                '".$oppnameshort."',
                                '".$oppname."',
                                '".$oppcontactname."',
                                '$oppcontactmail',
                                '$oppcontacticq',
                                '$oppcontactaim',
                                '$oppcontactyim',
                                '$oppcontactmsn',
                                '$oppircchannel',
                                '$oppircnetwork',
                                '".checkUrlFormat($opphomepage)."',
                                '$oppcountry',
                                '0')
                        ");
                        $oppid = $vwardb->insert_id();
                }

                if (!empty($GPC['serverid']))
                {
                        $vwardb->query("UPDATE vwar".$n."_server SET servername = '".$servname."', serverip = '$servip' WHERE serverid = '$serverid'");
                }
                else if ($servname != "" && $servip != "")
                {
                        $vwardb->query("INSERT INTO vwar".$n."_server VALUES (NULL,'$servname','$servip','0')");
                        $serverid = $vwardb->insert_id();
                }
                $vwardb->query("
                        INSERT INTO vwar".$n."
                        (gametypeid,matchtypeid,gameid,mailgroupid,oppid,serverid,playerperteam,serverpassword,info,
                        publicinfo,dateline,repeat_mod,repeat_number,repeat_saveas,addedby,addedtime)
                        VALUES (
                        '$gametypeid',
                        '$matchtypeid',
                        '$gameid',
                        '$mailgroup',
                        '$oppid',
                        '$serverid',
                        '$playerperteam',
                        '$serverpassword',
                        '".$warinfo."',
                        '$publicinfo',
                        '$dateline',
                        '$repeatmod',
                        '$repeatnumber',
                        '".$repeatsave."',
                        '".$GPC['vwarid']."',
                        '".time()."')
                ");
                $lastinsertid = $vwardb->insert_id();

                for ($i = 1; $i < sizeof($warlocation); $i++)
                {
                        $vwardb->query("INSERT INTO vwar".$n."_scores (warid,locationid) VALUES ('$lastinsertid','$warlocation[$i]')");
                }

                // send war mail
                if ($sendwarmail && !empty($mailgroup))
                {
                        if (empty($ownmail)) $ownmail = "admin@yourdomain.com";
                        createWarMail(array($mailgroup),$lastinsertid,"new");
                }
                header("Location: admin.php?action=warlist");
        }

        //template-cache, standard-templates will be added by script:
        $vwartpllist  = "admin_selectbitdefault,gametypeselectbit2,gametypeselectbit,locationselectbit,admin_bbcodeon,";
        $vwartpllist .= "matchtypeselectbit2,matchtypeselectbit,gameselectbit2,gameselectbit,admin_opponentselectbit2,";
        $vwartpllist .= "admin_opponentselectbit,admin_serverselectbit2,admin_serverselectbit,locationselectbit2,";
        $vwartpllist .= "admin_locationselect,admin_smilieson,admin_smiliesoff,admin_htmlcodeon,admin_htmlcodeoff,";
        $vwartpllist .= "admin_bbcodeoff,admin_dateselect,admin_repeatselect,admin_addwar,admin_bbcode_language,admin_bbcode,";
        $vwartpllist .= "bbcode_javascript,admin_emailgroupselection,admin_email_selectbit,admin_email_selectbitdefault";
        $vwartpl->cache($vwartpllist);

        eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");

        //strip slashes from post vars
        dbSelectForm($GPC, 1);

        if ($oppid != $oldoppid)
        {
                $row = $vwardb->query_first("
                        SELECT oppnameshort, oppname, oppcontactname, oppcontactmail, oppcontacticq, oppcontactaim,
                                oppcontactyim, oppcontactmsn, opphomepage, oppircnetwork, oppircchannel, oppcountry
                        FROM vwar".$n."_opponents
                        WHERE oppid = '".$GPC['oppid']."'
                ");
                dbSelectForm($row);
                while (list($key, $val) = each($row))
                {
                        $GPC[$key] = $val;
                }
                $GPC['oppcontacticq'] = ifelse($GPC['oppcontacticq'], $GPC['oppcontacticq']);
        }

        if ($serverid != $oldserverid)
        {
                $row = $vwardb->query_first("
                        SELECT servername, serverip
                        FROM vwar".$n."_server
                        WHERE serverid = '".$GPC['serverid']."'
                        AND deleted='0'
                ");
                dbSelectForm($row);

                $GPC['servname'] = $row['servername'];
                $GPC['servip'] = $row['serverip'];

        }

        eval ("\$gametypeselectbit = \"".$vwartpl->get("admin_selectbitdefault")."\";");
        $result = $vwardb->query("SELECT * FROM vwar".$n."_gametype WHERE deleted = '0' ORDER BY gametypename ASC");
        while ($gametype = $vwardb->fetch_array($result))
        {
                $gametypeid = $gametype['gametypeid'];
                $gametypename = $gametype['gametypename'];

                eval("\$gametypeselectbit .= \"".$vwartpl->get(ifelse($GPC['gametypeid'] == $gametypeid, "gametypeselectbit2", "gametypeselectbit"))."\";");
        }

        eval ("\$matchtypeselectbit = \"".$vwartpl->get("admin_selectbitdefault")."\";");
        $result = $vwardb->query("SELECT * FROM vwar".$n."_matchtype WHERE deleted = '0' ORDER BY matchtypename ASC");
        while ($matchtype = $vwardb->fetch_array($result))
        {
                $matchtypeid = $matchtype['matchtypeid'];
                $matchtypename = $matchtype['matchtypename'];

                eval("\$matchtypeselectbit .= \"".$vwartpl->get(ifelse($GPC['matchtypeid'] == $matchtypeid, "matchtypeselectbit2", "matchtypeselectbit"))."\";");
        }

        eval ("\$gameselectbit = \"".$vwartpl->get("admin_selectbitdefault")."\";");
        $result = $vwardb->query("SELECT * FROM vwar".$n."_games WHERE deleted = '0' ORDER BY gamename ASC");
        while ($game = $vwardb->fetch_array($result))
        {
                $gameid = $game['gameid'];
                $gamename = dbSelectForm($game['gamename']);
                $num = $vwardb->query_first("
                        SELECT COUNT(locationid) AS numloc
                        FROM vwar".$n."_locations
                        WHERE gameid = '".$game['gameid']."'
                ");
                if ($num['numloc'] > 0)
                {
                        eval("\$gameselectbit .= \"".$vwartpl->get(ifelse($gameid == $GPC['gameid'],"gameselectbit2","gameselectbit"))."\";");
                }
        }

        eval ("\$opponentselectbit = \"".$vwartpl->get("admin_selectbitdefault")."\";");
        $result = $vwardb->query("SELECT * FROM vwar".$n."_opponents WHERE deleted = '0' ORDER BY oppname ASC");
        while ($opponent = $vwardb->fetch_array($result))
        {
                $oppid = $opponent['oppid'];
                $opponentname = $opponent['oppname'];
                if ($GPC['oppid'] == $oppid)
                {
                        eval ("\$opponentselectbit .= \"".$vwartpl->get("admin_opponentselectbit2")."\";");
                } else {
                        $oldoppid = $GPC['oppid'];
                        eval ("\$opponentselectbit .= \"".$vwartpl->get("admin_opponentselectbit")."\";");
                }
        }

        $admin_countryselectbit = doCountrySelect($GPC["oppcountry"]);

        eval ("\$serverselectbit = \"".$vwartpl->get("admin_selectbitdefault")."\";");
        $result = $vwardb->query("SELECT * FROM vwar".$n."_server WHERE deleted = '0' ORDER BY servername ASC");
        while ($server = $vwardb->fetch_array($result))
        {
                $serverid = $server['serverid'];
                $servername = $server['servername'];
                if ($GPC['serverid'] == $serverid)
                {
                        eval ("\$serverselectbit .= \"".$vwartpl->get("admin_serverselectbit2")."\";");
                } else {
                        $oldserverid = $GPC['serverid'];
                        eval ("\$serverselectbit .= \"".$vwartpl->get("admin_serverselectbit")."\";");
                }
        }

        for ($i = 0;$i <= sizeof($locationid); $i++)
        {
                switchColors();

                $locationnumber = $i+1;

                eval ("\$locationselectbit = \"".$vwartpl->get("admin_selectbitdefault")."\";");

                $result = $vwardb->query("
                        SELECT *
                        FROM vwar".$n."_locations
                        WHERE deleted = '0'
                        AND gameid = '".$GPC['gameid']."'
                        ORDER by locationname ASC
                ");
                while ($row = $vwardb->fetch_array($result))
                {
                        eval("\$locationselectbit .= \"".$vwartpl->get(ifelse($warlocation[$locationnumber] == $row['locationid'], "locationselectbit2","locationselectbit"))."\";");

                        if ($warlocation[$locationnumber] != "")
                        {
                                $locationid[$locationnumber] = $locationid;
                        }
                }
                if ($warlocation[$locationnumber] != "" || $locationnumber == 1 || $warlocation[$locationnumber-1] != "")
                {
                        eval("\$locationselect .= \"".$vwartpl->get("admin_locationselect")."\";");
                }
        }

        getTextRestrictions("vwarform","warinfo","firstalt",3);
        $nextcolor['warmailing'] = $nextcolor[3];

        if ($sendwarmail)
        {
                $result = $vwardb->query("SELECT groupid, groupname FROM vwar".$n."_emailgroup");
                eval("\$mailgroups  = \"".$vwartpl->get("admin_selectbitdefault")."\";");
                eval("\$mailgroups .= \"".$vwartpl->get("admin_email_selectbitdefault")."\";");
                while ($mail = $vwardb->fetch_array($result))
                {
                        eval("\$mailgroups .= \"".$vwartpl->get("admin_email_selectbit")."\";");
                }
                eval("\$warmailing = \"".$vwartpl->get("admin_emailgroupselection")."\";");
        }
        $publicinfo = ifelse(isset($GPC['publicinfo']), makeyesnocode("publicinfo",$GPC['publicinfo']), makeyesnocode("publicinfo",1));

        if (isset($dateline))
        {
                $month = date("m", $dateline);
                $day = date("d", $dateline);
                $year = date("Y", $dateline);
                $wartime = date("H:i", $dateline);
        }
        //if ($day < 10) $day = "0" . $day;
        if(strlen($day)==1) $day="0".$day;
        $monthselected[$month] = "selected";
        $dayselected[$day] = "selected";
        $yearselected[$year] = "selected";

        eval("\$admin_dateselect = \"".$vwartpl->get("admin_dateselect")."\";");

        if ($makerepeat == 1)
        {
                if ( $repeat == 0 ) {
                        $repeatchecked[0] = "checked";
                } else {
                        $repeatchecked[1] = "checked";
                }
                $repeatselected[1]                = "selected";
                $makerepeating                    = makeyesnocode("makerepeat",$value);
                $selected[$repeat_mod]            = "selected";
                $repeatdateselected[$repeat_date] = "selected";
                $repeat_saveas_value              = (isset($GPC["repeat_saveas"])) ? $GPC["repeat_saveas"] : 0;
                $repeat_saveas                    = makeyesnocode("repeat_saveas", $repeat_saveas_value);

                eval("\$repeatselect = \"".$vwartpl->get("admin_repeatselect")."\";");
        }
        else $repeatselected[0] = "selected";

        eval("\$vwartpl->output(\"".$vwartpl->get("admin_addwar")."\",1);");
}

// ################################### edit war ########################################
if ($GPC['action'] == "editwar")
{
        checkPermission("caneditwar");

        if ($GPC['add'] || $GPC['add_x'])
        {
                // make timestamp
                list ($hour, $minute) = split("[:]", $wartime);
                $dateline = mktime( $hour, $minute, 0, $month, $day, $year);
                if($dateline < 0 ) $dateline = 0;

                // check for wrong data
                if ($gametypeid == "" || $matchtypeid == "" || !($dateline >= 0) || (sizeof($warlocation) < 1))
                {
                        $vwartpl->cache("admin_message_error_missingdata");
                        eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
                        eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_error_missingdata")."\");");
                        exit;
                }

                if ($GPC["makerepeat"] == 1 AND $GPC["repeat"] == 0 AND is_numeric($GPC["repeat_number"]) AND !empty($GPC["repeat_mod"]))
                {
                        $repeatmod    = $GPC["repeat_mod"];
                        $repeatnumber = $GPC["repeat_number"];
                }
                else if ($GPC["makerepeat"] == 1 AND $GPC["repeat"] == 1 AND $GPC["repeat_date"] > 0)
                {
                        if ( $GPC["repeat_date"] < 13 AND $day < 30 )
                        {
                                $repeatmod    = "date";
                                $repeatnumber = $GPC["repeat_date"];
                        }
                        else if ( $GPC["repeat_date"] == 13 )
                        {
                                $repeatmod    = "date";
                                $repeatnumber = 13;
                        }
                }
                $repeatsave = $GPC["repeat_saveas"];

                $result = $vwardb->query_first("SELECT status FROM vwar".$n." WHERE warid = '".$GPC['warid']."'");
                $old_status = $result['status'];

                if ($old_status ==0 || $status == 0)
                {
                        if ($deleteparticipants == 1)
                        {
                                $result = $vwardb->query_first("SELECT dateline FROM vwar".$n." WHERE warid = '".$GPC['warid']."'");
                                if ($result['dateline'] != $dateline)
                                {
                                        $vwardb->query("DELETE FROM vwar".$n."_participants WHERE warid = '".$GPC['warid']."'");
                                }
                        }
                }

                $vwardb->query("
                        UPDATE vwar".$n."
                        SET
                        gametypeid                      = '$gametypeid',
                        matchtypeid             = '$matchtypeid',
                        gameid                                  = '$gameid',
                        mailgroupid             = '$mailgroup',
                        oppid                                   = '$oppid',
                        serverid                                = '$serverid',
                        playerperteam   = '$playerperteam',
                        serverpassword  = '$serverpassword',
                        info                                            = '$warinfo',
                        publicinfo                      = '$publicinfo',
                        status                                  = '$status',
                        dateline                                = '$dateline',
                        repeat_mod                      = '$repeatmod',
                        repeat_number   = '$repeatnumber',
                        repeat_saveas   = '$repeatsave',
                        changedby                       = '".$GPC['vwarid']."',
                        changedtime             = '".time()."'
                        WHERE warid             = '".$GPC['warid']."'
                ");

                for ($i = 1; $i <= count($warlocation); $i++)
                {
                        $vwardb->query("UPDATE vwar".$n."_scores SET locationid = '".$warlocation[$i]."' WHERE scoreid = '".$scorelist[$i]."'");
                        $vwardb->query("UPDATE vwar".$n."_screen SET locationid = '".$warlocation[$i]."' WHERE scoreid = '".$scorelist[$i]."'");
                }

                // send war mail
                if ($sendwarmail && !empty($mailgroup) && $status == 0)
                {
                        createWarMail(array($mailgroup),$warid,"changed",$n);
                }
                header("Location: admin.php?action=warlist");
        }

        //template-cache, standard-templates will be added by script:
        $vwartpllist  = "admin_selectbitdefault,gametypeselectbit2,gametypeselectbit,locationselectbit,admin_bbcodeon,";
        $vwartpllist .= "matchtypeselectbit2,matchtypeselectbit,gameselectbit2,gameselectbit,admin_opponentselectbit2,";
        $vwartpllist .= "admin_opponentselectbit,admin_serverselectbit2,admin_serverselectbit,locationselectbit2,";
        $vwartpllist .= "admin_locationselect,admin_smilieson,admin_smiliesoff,admin_htmlcodeon,admin_htmlcodeoff,";
        $vwartpllist .= "admin_bbcodeoff,admin_dateselect,admin_repeatselect,admin_editwar,admin_bbcode_language,admin_bbcode,";
        $vwartpllist .= "bbcode_javascript,admin_emailgroupselection,admin_email_selectbit,admin_email_selectbitdefault";
        $vwartpl->cache($vwartpllist);

        eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");

        $row=$vwardb->query_first("
                SELECT *
                FROM vwar".$n.", vwar".$n."_games
                WHERE vwar".$n.".gameid = vwar".$n."_games.gameid
                AND warid = '".$GPC['warid']."'
        ");

        if (!isset($playerperteam)) $playerperteam = $row['playerperteam'];
        if (!isset($warinfo)) $warinfo = $row['info'];
        if (!isset($wardate)) $wardate = date("d.m.Y",$row['dateline']);
        if (!isset($wartime)) $wartime = date("H:i",$row['dateline']);
        if (!isset($serverpassword)) $serverpassword = $row['serverpassword'];
        if (!isset($makerepeat) && !empty($row['repeat_mod']) && is_numeric($row['repeat_number'])) $makerepeat = 1;

        if ($makerepeat == 1)
        {
                if (!isset($repeat) && $row['repeat_mod'] == "date")
                {
                        $repeatchecked[1]                          = "checked";
                        $repeatdateselected[$row["repeat_number"]] = "selected";
                } else {
                        $repeatchecked[0]                          = "checked";
                        $selected[$row['repeat_mod']]              = "selected";
                        $repeat_number                             = $row['repeat_number'];
                }
                $repeat_saveas_value = (isset($GPC["repeat_saveas"])) ? $GPC["repeat_saveas"] : $row["repeat_saveas"];
                $repeat_saveas       = makeyesnocode("repeat_saveas", $repeat_saveas_value);
                $repeatselected[1]   = "selected";

                eval("\$repeatselect = \"".$vwartpl->get("admin_repeatselect")."\";");
        }
        else
        {
                $repeatselected[0]   = "selected";
        }
        $finished = makeyesnocode("status", $row['status']);
        $publicinfo = makeyesnocode("publicinfo", $row['publicinfo']);
        $gamename = $row['gamename'];
        $gameid = $row['gameid'];
        $mailgroupid = $row['mailgroupid'];
        
        
        eval ("\$matchtypeselectbit = \"".$vwartpl->get("admin_selectbitdefault")."\";");
        $result = $vwardb->query("SELECT * FROM vwar".$n."_matchtype WHERE deleted = '0' ORDER BY matchtypename ASC");
        while ($matchtype = $vwardb->fetch_array($result))
        {
                $matchtypeid = $matchtype['matchtypeid'];
                $matchtypename = $matchtype['matchtypename'];

                eval("\$matchtypeselectbit .= \"".$vwartpl->get(ifelse($matchtypeid == $row['matchtypeid'],"matchtypeselectbit2","matchtypeselectbit"))."\";");
        }

        eval ("\$gametypeselectbit = \"".$vwartpl->get("admin_selectbitdefault")."\";");
        $result = $vwardb->query("SELECT * FROM vwar".$n."_gametype WHERE deleted = '0' ORDER BY gametypename ASC");
        while ($gametype = $vwardb->fetch_array($result))
        {
                $gametypeid = $gametype['gametypeid'];
                $gametypename = $gametype['gametypename'];

                eval("\$gametypeselectbit .= \"".$vwartpl->get(ifelse($gametypeid == $row['gametypeid'],"gametypeselectbit2","gametypeselectbit"))."\";");
        }

        eval ("\$opponentselectbit = \"".$vwartpl->get("admin_selectbitdefault")."\";");
        $result = $vwardb->query("SELECT * FROM vwar".$n."_opponents WHERE deleted = '0' ORDER BY oppname ASC");
        while ($opponent = $vwardb->fetch_array($result))
        {
                $oppid = $opponent['oppid'];
                $opponentname = $opponent['oppname'];

                eval("\$opponentselectbit .= \"".$vwartpl->get(ifelse($oppid == $row['oppid'],"admin_opponentselectbit2","admin_opponentselectbit"))."\";");
        }

        eval ("\$serverselectbit = \"".$vwartpl->get("admin_selectbitdefault")."\";");
        $result = $vwardb->query("SELECT * FROM vwar".$n."_server WHERE deleted = '0' ORDER BY servername ASC");
        while ($server = $vwardb->fetch_array($result))
        {
                $serverid = $server['serverid'];
                $servername = $server['servername'];

                eval("\$serverselectbit .= \"".$vwartpl->get(ifelse($serverid == $row['serverid'],"admin_serverselectbit2","admin_serverselectbit"))."\";");
        }

        $result = $vwardb->query_first("
                SELECT COUNT(scoreid) AS scores
                FROM vwar".$n."_scores
                WHERE warid = '".$GPC['warid']."'
        ");
        $num = $result['scores'];

        $count = 0;

        $result = $vwardb->query("SELECT * FROM vwar".$n."_scores WHERE warid = '".$GPC['warid']."' ORDER BY scoreid ASC");
        while ($score = $vwardb->fetch_array($result))
        {
                $count++;
                $locationlist[$count] = $score['locationid'];
                $scores[$count] = $score['scoreid'];
        }

        for ($i = 1; $i <= $num; $i++)
        {
                switchColors();

                eval ("\$locationselectbit .= \"".$vwartpl->get("admin_selectbitdefault")."\";");
                $result = $vwardb->query("SELECT * FROM vwar".$n."_locations WHERE gameid = '$gameid' ORDER BY locationname");
                while ($row = $vwardb->fetch_array($result))
                {
                        $locationnumber = $i;
                        eval("\$locationselectbit .= \"".$vwartpl->get(ifelse($row['locationid'] == $locationlist[$i],"locationselectbit2","locationselectbit"))."\";");
                }
                eval ("\$locationselect .= \"".$vwartpl->get("admin_locationselect2")."\";");
                unset($locationselectbit);
        }

        getTextRestrictions("vwarform","warinfo","firstalt",4);
        $nextcolor['warmailing'] = $nextcolor[4];

        if ($sendwarmail)
        {
                $result = $vwardb->query("SELECT groupid, groupname FROM vwar".$n."_emailgroup");
                eval("\$mailgroups  = \"".$vwartpl->get("admin_selectbitdefault")."\";");
                eval("\$mailgroups .= \"".$vwartpl->get("admin_email_selectbitdefault")."\";");
                while ($mail = $vwardb->fetch_array($result))
                {
                        $selected = ifelse($mail['groupid'] == $mailgroupid, "selected");
                        eval("\$mailgroups .= \"".$vwartpl->get("admin_email_selectbit")."\";");
                }
                eval("\$warmailing = \"".$vwartpl->get("admin_emailgroupselection")."\";");
        }

        list ($day, $month, $year) = split("[/.-]",$wardate);
        $monthselected[$month] = "selected";
        $dayselected[$day] = "selected";
        $yearselected[$year] = "selected";
        eval("\$admin_dateselect = \"".$vwartpl->get("admin_dateselect")."\";");

        eval("\$vwartpl->output(\"".$vwartpl->get("admin_editwar")."\",1);");
}

// ################################### add location to war #############################
if ($GPC['action'] == "addlocationtowar")
{
        checkPermission("caneditwar");

        if ($GPC['add'] || $GPC['add_x'])
        {
                $vwardb->query("INSERT INTO vwar".$n."_scores (warid,locationid) VALUES ('$warid','$locationid')");
                header("Location: admin.php?action=editwar&warid=$warid");
        }

        //template-cache, standard-templates will be added by script:
        $vwartpllist="admin_selectbitdefault,locationselectbit,admin_locationselect3,admin_addlocationtowar";
        $vwartpl->cache($vwartpllist);
        eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");

        $result=$vwardb->query_first("SELECT COUNT(scoreid) AS scores FROM vwar".$n."_scores WHERE warid = '".$GPC['warid']."'");
        $locationnumber = $result['scores'] + 1;

        $result = $vwardb->query_first("SELECT gameid FROM vwar".$n." WHERE warid = '".$GPC['warid']."'");
        $gameid = $result['gameid'];

        eval ("\$locationselectbit = \"".$vwartpl->get("admin_selectbitdefault")."\";");

        $result = $vwardb->query("
                SELECT locationid, locationname
                FROM vwar".$n."_locations
                WHERE deleted = '0'
                AND gameid = '$gameid'
                ORDER by locationname ASC
        ");
        while ($row = $vwardb->fetch_array($result))
        {
                dbSelectForm($row);
                eval("\$locationselectbit .= \"".$vwartpl->get("locationselectbit")."\";");
        }
        eval("\$locationselect .= \"".$vwartpl->get("admin_locationselect3")."\";");
        eval("\$vwartpl->output(\"".$vwartpl->get("admin_addlocationtowar")."\");");
}

// ################################### delete location from war ########################
if ($GPC['action'] == "deletelocationfromwar")
{
        checkPermission("caneditwar");

        $numscreens = $vwardb->query("
                SELECT COUNT(screenid) AS screens
                FROM vwar".$n."_screen
                WHERE scoreid = '".$GPC['scoreid']."'
                AND warid = '".$GPC['warid']."'
        ");
        if ($delete && $numscreens['screens'] > 0)
        {
                $vwartpl->cache("admin_message_filesystem");
                eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
                eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_filesystem")."\");");
                exit;
        }
        else if ($delete)
        {
                $filesystem = true;
        }

        if ($filesystem)
        {
                if ($filesystem == "Yes")
                {
                        $result = $vwardb->query("
                                SELECT filename FROM vwar".$n."_screen WHERE scoreid='".$GPC['scoreid']."' AND warid='".$GPC['warid']."'
                        ");
                        while ($row = $vwardb->fetch_array($result))
                        {
                                $screenfile = $vwar_root . "images/screen/" . $row['filename'];
                                $thumbfile = $vwar_root . "images/screen/th_" . $row['filename'];

                                if(@file_exists($screenfile) && @is_file($screenfile)) @unlink($screenfile);
                                if(@file_exists($thumbfile) && @is_file($thumbfile)) @unlink($thumbfile);
                        }
                }
                $vwardb->query("DELETE FROM vwar".$n."_scores WHERE scoreid = '".$GPC['scoreid']."' AND warid = '".$GPC['warid']."'");
                $vwardb->query("DELETE FROM vwar".$n."_screen WHERE scoreid = '".$GPC['scoreid']."' AND warid = '".$GPC['warid']."'");

                header("Location: admin.php?action=editwar&warid=".$GPC['warid']."");
        }

        $vwartpl->cache("admin_message_delete");
        eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
        eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_delete")."\");");
}

// ################################### delete war ######################################
if ($GPC['action'] == "deletewar")
{
        checkPermission("candeletewar");

        $numscreens = $vwardb->query("SELECT COUNT(screenid) AS screens FROM vwar".$n."_screen WHERE warid = '".$GPC['warid']."'");
        if ($delete && $numscreens['screens'] > 0)
        {
                $vwartpl->cache("admin_message_filesystem");
                eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
                eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_filesystem")."\");");
                exit;
        }
        else if ($delete)
        {
                $filesystem = true;
        }

        if ($filesystem)
        {
                if($filesystem == "Yes")
                {
                        $result = $vwardb->query("SELECT filename FROM vwar".$n."_screen WHERE warid = '".$GPC['warid']."'");
                        while ($row = $vwardb->fetch_array($result))
                        {
                                $screenfile = $vwar_root . "images/screen/" . $row['filename'];
                                $thumbfile = $vwar_root . "images/screen/th_" . $row['filename'];

                                if(@file_exists($screenfile) && @is_file($screenfile)) @unlink($screenfile);
                                if(@file_exists($thumbfile) && @is_file($thumbfile)) @unlink($thumbfile);
                        }
                }
                $vwardb->query("DELETE FROM vwar".$n." WHERE warid = '".$GPC['warid']."'");
                $vwardb->query("DELETE FROM vwar".$n."_scores WHERE warid = '".$GPC['warid']."'");
                $vwardb->query("DELETE FROM vwar".$n."_comments WHERE frompage = 'war' AND sourceid = '".$GPC['warid']."'");
                $vwardb->query("DELETE FROM vwar".$n."_screen WHERE warid = '".$GPC['warid']."'");
                $vwardb->query("UPDATE vwar".$n."_settings SET deletedwars = deletedwars+1");

                header("Location: admin.php?action=warlist&s=$s&page=$page");
        }

        $vwartpl->cache("admin_message_delete");
        eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
        eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_delete")."\");");
}

// ################################### finish war #####################################
if ($GPC['action'] == "finishwar")
{
        checkPermission("canfinishwar");

        if ($GPC['add'] || $GPC['add_x'])
        {
                while (list($scoreid, $score) = each($ownscore))
                {
                        $vwardb->query("UPDATE vwar".$n."_scores SET ownscore='$score' WHERE warid = '".$GPC['warid']."' AND scoreid = '$scoreid'");
                }
                while (list($scoreid, $score) = each($oppscore))
                {
                        $vwardb->query("UPDATE vwar".$n."_scores SET oppscore = '$score' WHERE warid = '".$GPC['warid']."' AND scoreid = '$scoreid'");
                }
                $vwardb->query("
                        UPDATE vwar".$n."
                        SET
                        ownplayers = '".$ownplayers."',
                        opplayers = '".$opplayers."',
                        status = '1',
                        report = '".$warinfo."',
                        publicreport = '$publicreport',
                        resultbylocations = '$resultbylocations'
                        WHERE warid = '".$GPC['warid']."'
                ");

                header("Location: admin.php?action=warlist");
        }

        //template-cache, standard-templates will be added by script:
        $vwartpllist="admin_finishwar_scorebit,admin_smilieson,admin_smiliesoff,admin_htmlcodeon,admin_htmlcodeoff,";
        $vwartpllist.="admin_bbcodeon,admin_bbcodeoff,admin_bbcode_language,admin_bbcode,bbcode_javascript,admin_finishwar";
        $vwartpl->cache($vwartpllist);

        eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");

        $row = $vwardb->query_first("
                SELECT vwar".$n.".*, vwar".$n."_matchtype.*, vwar".$n."_gametype.*, vwar".$n."_games.*,vwar".$n."_opponents.*
                FROM vwar".$n."
                LEFT JOIN vwar".$n."_opponents ON (vwar".$n.".oppid = vwar".$n."_opponents.oppid)
                LEFT JOIN vwar".$n."_matchtype ON (vwar".$n.".matchtypeid = vwar".$n."_matchtype.matchtypeid)
                LEFT JOIN vwar".$n."_gametype ON (vwar".$n.".gametypeid = vwar".$n."_gametype.gametypeid)
                LEFT JOIN vwar".$n."_games ON (vwar".$n.".gameid = vwar".$n."_games.gameid)
                WHERE warid = '".$GPC['warid']."'
        ");
        dbSelectForm($row);

        $wardate = date("d.m.Y", $row['dateline']);
        $wartime = date("H:i", $row['dateline']);
        $report = $row['report'];
        $publicreport = makeyesnocode("publicreport", $row['publicreport']);
        $finalresult = makeyesnocode("resultbylocations", $row['resultbylocations']);

        $result = $vwardb->query("
                SELECT vwar".$n."_scores.*, vwar".$n."_locations.*
                FROM vwar".$n."_scores
                LEFT JOIN vwar".$n."_locations ON (vwar".$n."_scores.locationid = vwar".$n."_locations.locationid)
                WHERE warid = '".$GPC['warid']."'
                ORDER BY scoreid ASC
        ");
        while ($score = $vwardb->fetch_array($result))
        {
                switchColors();

                $scoreid                        = $score['scoreid'];
                $locationname = $score['locationname'];
                $ownscore               = $score['ownscore'];
                $oppscore               = $score['oppscore'];

                eval ("\$admin_finishwar_scorebit .= \"".$vwartpl->get("admin_finishwar_scorebit")."\";");
        }
        getTextRestrictions("vwarform","warinfo","secondalt",3);

        eval("\$vwartpl->output(\"".$vwartpl->get("admin_finishwar")."\",1);");
}

// ################################### display signed members ##########################
if ($GPC['action'] == "showsigned")
{
        checkPermission("caneditwar-canfinishwar");
        //template-cache, standard-templates will be added by script:
        $vwartpllist="admin_signedlistbit,admin_signedlist";
        $vwartpl->cache($vwartpllist);

        eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");

        $result = $vwardb->query("
                SELECT partid, name, available, dateline
                FROM vwar".$n."_member, vwar".$n."_participants
                WHERE warid = '".$GPC['warid']."'
                AND vwar".$n."_participants.memberid = vwar".$n."_member.memberid
                ORDER BY name ASC
        ");
        while ($row = $vwardb->fetch_array($result))
        {
                dbSelect($row);
                switchColors();

                $row['dateline'] = formatdatetime($row['dateline'],$longdateformat);

                if ($row['available'] == 0)
                {
                        $available = makeimgtag($vwar_root . "images/uncheck.gif","","top");
                }
                else if ($row['available'] == 1)
                {
                        $available = makeimgtag($vwar_root . "images/check.gif","","top");
                }
                else
                {
                        $available = makeimgtag($vwar_root . "images/unsure.gif","","top");
                }

                eval ("\$admin_signedlistbit .= \"".$vwartpl->get("admin_signedlistbit")."\";");
        }
        eval("\$vwartpl->output(\"".$vwartpl->get("admin_signedlist")."\");");
}

// ################################### delete signed members ###########################
if ($GPC['action'] == "deletesigned")
{
        checkPermission("caneditwar-canfinishwar");

        if ($delete)
        {
                $vwardb->query("DELETE FROM vwar".$n."_participants WHERE partid = '".$GPC['partid']."' AND warid = '".$GPC['warid']."'");
                header("Location: admin.php?action=showsigned&warid=".$GPC['warid']."");
        }
        $vwartpl->cache("admin_message_delete");
        eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
        eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_delete")."\");");
}

// ################################### display gametypes ###############################
if ($GPC['action'] == "viewgametypes")
{
        checkPermission("canaddgametype-caneditgametype-candeletegametype");
        //template-cache, standard-templates will be added by script:
        $vwartpllist="admin_gametype_listbit,admin_gametype_list";
        $vwartpl->cache($vwartpllist);

        eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");

        $result = $vwardb->query("SELECT * FROM vwar".$n."_gametype ORDER BY gametypename ASC");
        while ($row = $vwardb->fetch_array($result))
        {
                dbSelect($row);
                switchColors();

                $active = getActiveTag($row['deleted'], "Gametype");

                eval("\$admin_gametype_listbit .= \"".$vwartpl->get("admin_gametype_listbit")."\";");
        }
        eval("\$vwartpl->output(\"".$vwartpl->get("admin_gametype_list")."\");");
}

// ################################### add gametype ####################################
if ($GPC['action'] == "addgametype")
{
        checkPermission("canaddgametype");

        if ($GPC['add'] || $GPC['add_x'])
        {
                // check for wrong data
                if ($gametypename == "")
                {
                        $vwartpl->cache("admin_message_error_missingdata");
                        eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
                        eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_error_missingdata")."\");");
                        exit;
                }
                $vwardb->query("INSERT INTO vwar".$n."_gametype (gametypename) VALUES ('$gametypename')");
                header("Location: admin.php?action=viewgametypes");
        }
        $vwartpl->cache("admin_addgametype");
        eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
        eval("\$vwartpl->output(\"".$vwartpl->get("admin_addgametype")."\");");
}

// ################################### edit gametype ###################################
if ($GPC['action'] == "editgametype")
{
        checkPermission("caneditgametype");

        if ($GPC['add'] || $GPC['add_x'])
        {
                // check for wrong data
                if ($gametypename == "")
                {
                        $vwartpl->cache("admin_message_error_missingdata");
                        eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
                        eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_error_missingdata")."\");");
                        exit;
                }
                $vwardb->query("
                        UPDATE vwar".$n."_gametype
                        SET
                        gametypename = '$gametypename',
                        deleted = '$deleted'
                        WHERE gametypeid = '".$GPC['gametypeid']."'
                ");
                header("Location: admin.php?action=viewgametypes");
        }
        $row = $vwardb->query_first("SELECT * FROM vwar".$n."_gametype WHERE gametypeid = '".$GPC['gametypeid']."'");
        dbSelectForm($row);
        $deleted = makeyesnocode("deleted",$row['deleted']);

        $vwartpl->cache("admin_editgametype");
        eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
        eval("\$vwartpl->output(\"".$vwartpl->get("admin_editgametype")."\");");
}

// ################################### delete gametype #################################
if ($GPC['action'] == "deletegametype")
{
        checkPermission("candeletegametype");

        if ($delete)
        {
                $vwardb->query("DELETE FROM vwar".$n."_gametype WHERE gametypeid = '".$GPC['gametypeid']."'");
                header("Location: admin.php?action=viewgametypes&page=$page&s=$s");
        }

        $vwartpl->cache("admin_message_delete,admin_message_delete_entries");

        // check for other entries with this one
        $checkentries = $vwardb->query_first("
                SELECT COUNT(warid) AS numwars
                FROM vwar".$n."
                WHERE gametypeid = '".$GPC['gametypeid']."'
        ");
        if ($checkentries['numwars'] > 0)
        {
                $numentries = $checkentries['numwars'];
                eval("\$admin_message_delete_entries .= \"".$vwartpl->get("admin_message_delete_entries")."\";");
        }
        eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
        eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_delete")."\");");
}

// ################################### display matchtypes #############################
if ($GPC['action'] == "viewmatchtypes")
{
        checkPermission("canaddmatchtype-caneditmatchtype-candeletematchtype");
        //template-cache, standard-templates will be added by script:
        $vwartpllist="admin_matchtype_listbit,admin_matchtype_list";
        $vwartpl->cache($vwartpllist);

        $result = $vwardb->query("SELECT * FROM vwar".$n."_matchtype ORDER BY matchtypename ASC");
        while ($row = $vwardb->fetch_array($result))
        {
                dbSelect($row);
                switchColors();

                $active = getActiveTag($row['deleted'], "Matchtype");

                $public = makeimgtag($vwar_root . "images/" . ifelse($row['public'] == 1, "check.gif", "uncheck.gif"));
                eval("\$admin_matchtype_listbit .= \"".$vwartpl->get("admin_matchtype_listbit")."\";");
        }

        eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
        eval("\$vwartpl->output(\"".$vwartpl->get("admin_matchtype_list")."\");");
}

// ################################### add matchtype ###################################
if ($GPC['action']=="addmatchtype")
{
        checkPermission("canaddmatchtype");

        if ($GPC['add'] || $GPC['add_x'])
        {
                // check for wrong data
                if ($matchtypename == "")
                {
                        $vwartpl->cache("admin_message_error_missingdata");
                        eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
                        eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_error_missingdata")."\");");
                        exit;
                }
                $vwardb->query("
                        INSERT INTO vwar".$n."_matchtype (matchtypename, matchtypeurl, public)
                        VALUES (
                        '$matchtypename',
                        '".checkUrlFormat($matchtypeurl)."',
                        '$public')
                ");
                header("Location: admin.php?action=viewmatchtypes");
        }
        $vwartpl->cache("admin_addmatchtype");
        $public = makeyesnocode("public");

        eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
        eval("\$vwartpl->output(\"".$vwartpl->get("admin_addmatchtype")."\");");
}

// ################################### edit matchtype ##################################
if ($GPC['action'] == "editmatchtype")
{
        checkPermission("caneditmatchtype");

        if ($GPC['add'] || $GPC['add_x'])
        {
                // check for wrong data
                if ($matchtypename == "")
                {
                        $vwartpl->cache("admin_message_error_missingdata");
                        eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
                        eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_error_missingdata")."\");");
                        exit;
                }
                $vwardb->query("
                        UPDATE vwar".$n."_matchtype
                        SET
                        matchtypename = '$matchtypename',
                        matchtypeurl = '".checkUrlFormat($matchtypeurl)."',
                        deleted = '$deleted',
                        public = '$public'
                        WHERE matchtypeid = '".$GPC['matchtypeid']."'
                ");
                header("Location: admin.php?action=viewmatchtypes");
        }
        $row = $vwardb->query_first("SELECT * FROM vwar".$n."_matchtype WHERE matchtypeid = '".$GPC['matchtypeid']."'");
        dbSelectForm($row);

        $public = makeyesnocode("public", $row['public']);
        $deleted = makeyesnocode("deleted", $row['deleted']);

        $vwartpl->cache("admin_editmatchtype");
        eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
        eval("\$vwartpl->output(\"".$vwartpl->get("admin_editmatchtype")."\");");
}

// ################################### delete matchtype ################################
if ($GPC['action'] == "deletematchtype")
{
        checkPermission("candeletematchtype");

        if ($delete)
        {
                $vwardb->query("DELETE FROM vwar".$n."_matchtype WHERE matchtypeid = '".$GPC['matchtypeid']."'");
                header("Location: admin.php?action=viewmatchtypes&page=$page&s=$s");
        }

        $vwartpl->cache("admin_message_delete,admin_message_delete_entries");

        // check for other entries linked with this one
        $checkentries = $vwardb->query_first("
                SELECT COUNT(warid) AS numwars
                FROM vwar".$n."
                WHERE matchtypeid = '".$GPC['matchtypeid']."'
        ");
        if ($checkentries['numwars'] > 0)
        {
                $numentries = $checkentries['numwars'];
                eval("\$admin_message_delete_entries .= \"".$vwartpl->get("admin_message_delete_entries")."\";");
        }
        eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
        eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_delete")."\");");
}

// ################################### display games ###################################
if ($GPC['action'] == "viewgames")
{
        checkPermission("canaddgame-caneditgame-candeletegame");
        //template-cache, standard-templates will be added by script:
        $vwartpllist="admin_game_listbit,admin_game_list";
        $vwartpl->cache($vwartpllist);

        $result = $vwardb->query("SELECT * FROM vwar".$n."_games ORDER BY gamename ASC");
        while ($row = $vwardb->fetch_array($result))
        {
                dbSelect($row);
                switchColors();

                $active = getActiveTag($row['deleted'], "Game");

                eval("\$admin_game_listbit .= \"".$vwartpl->get("admin_game_listbit")."\";");
        }
        eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
        eval("\$vwartpl->output(\"".$vwartpl->get("admin_game_list")."\");");
}

// ################################### add games #######################################
if ($GPC['action'] == "addgame")
{
        checkPermission("canaddgame");

        if ($GPC['add'] || $GPC['add_x'])
        {
                // check for wrong data
                if ($gamename == "" || $gamenameshort == "")
                {
                        $vwartpl->cache("admin_message_error_missingdata");
                        eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
                        eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_error_missingdata")."\");");
                        exit;
                }

                if ($transfer == "local" && @file_exists($vwar_root . "images/gameicons/$image"))
                {
                        $vwardb->query("INSERT INTO vwar".$n."_games (gamename,gamenameshort,gameicon) VALUES ('$gamename','$gamenameshort','$image')");
                }
                else if ($transfer == "upload" && $HTTP_POST_FILES['filename']['name'] && $HTTP_POST_FILES['filename']['tmp_name'])
                {
                        $vwardb->query("INSERT INTO vwar".$n."_games (gamename,gamenameshort) VALUES ('$gamename','$gamenameshort')");
                        $gameid = $vwardb->insert_id();

                        $gameicon = $gameid . "_".strtolower($HTTP_POST_FILES['filename']['name']);

                        $upload->doUpload($HTTP_POST_FILES['filename'], $vwar_root . "images/gameicons/",0,0,$gameid."_");

                        $vwardb->query("UPDATE vwar".$n."_games SET gameicon='$gameicon' WHERE gameid = '$gameid'");
                }
                header("Location: admin.php?action=viewgames");
        }
        $vwartpl->cache("admin_addgame");
        eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
        eval("\$vwartpl->output(\"".$vwartpl->get("admin_addgame")."\");");
}

// ################################### edit games ######################################
if ($GPC['action'] == "editgame")
{
        checkPermission("caneditgame");

        if ($GPC['add'] || $GPC['add_x'])
        {
                // check for wrong data
                if ($gamename == "" || $gamenameshort == "")
                {
                        $vwartpl->cache("admin_message_error_missingdata");
                        eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
                        eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_error_missingdata")."\");");
                        exit;
                }

                $gameid = $GPC['gameid'];
                $result = $vwardb->query_first("SELECT gameicon FROM vwar".$n."_games WHERE gameid = '$gameid'");
                $oldicon = $result['gameicon'];
                if (!empty($HTTP_POST_FILES['filename']['name']))
                {
                        $gameicon = $gameid . "_" . strtolower($HTTP_POST_FILES['filename']['name']);
                        if ($oldicon != "") @unlink($vwar_root . "images/gameicons/$oldicon");

                        $upload->doUpload($HTTP_POST_FILES['filename'], $vwar_root . "images/gameicons/",0,0,$gameid."_");
                }
                else if ($oldicon != $gameicon && $oldicon != "")
                {
                        @unlink($vwar_root . "images/gameicons/$oldicon");
                }
                $vwardb->query("
                        UPDATE vwar".$n."_games
                        SET
                        gamename = '$gamename',
                        gamenameshort = '$gamenameshort',
                        gameicon = '$gameicon',
                        deleted = '$deleted'
                        WHERE gameid = '$gameid'
                ");
                header("Location: admin.php?action=viewgames");
        }

        $row = $vwardb->query_first("SELECT * FROM vwar".$n."_games WHERE gameid = '".$GPC['gameid']."' ORDER BY gamename ASC");
        dbSelectForm($row);

        $oldimage = ifelse($row['gameicon'], makeimgtag($vwar_root . "images/gameicons/" . $row['gameicon'] . "",$row['gamename']), "-");

        $deleted = makeyesnocode("deleted", $row['deleted']);

        $vwartpl->cache("admin_editgame");
        eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
        eval("\$vwartpl->output(\"".$vwartpl->get("admin_editgame")."\",1);");
}

// ################################### delete game #####################################
if ($GPC['action'] == "deletegame")
{
        checkPermission("candeletegame");

        if ($delete)
        {
                $vwartpl->cache("admin_message_filesystem");
                eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
                eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_filesystem")."\");");
                exit;
        }

        if ($filesystem)
        {
                if ($filesystem == "Yes")
                {
                        $result = $vwardb->query_first("SELECT gameicon FROM vwar".$n."_games WHERE gameid = '".$GPC['gameid']."'");
                        $icon = $result['gameicon'];
                        @unlink($vwar_root . "images/gameicons/$icon");
                }
                $vwardb->query("DELETE FROM vwar".$n."_games WHERE gameid = '".$GPC['gameid']."'");
                $vwardb->query("DELETE FROM vwar".$n."_memberlocation WHERE membergameid = '".$GPC['gameid']."'");

                header("Location: admin.php?action=viewgames&page=$page&s=$s");
        }

        $vwartpl->cache("admin_message_delete,admin_message_delete_entries");

        // check for other entries with this one
        $checkentries  = $vwardb->query_first("SELECT COUNT(warid) AS numa FROM vwar".$n." WHERE gameid = '".$GPC['gameid']."'");
        $checkentries2 = $vwardb->query_first("SELECT COUNT(challengeid) AS numb FROM vwar".$n."_challenge WHERE gameid = '".$GPC['gameid']."'");
        $checkentries3 = $vwardb->query_first("SELECT COUNT(joinid) AS numc FROM vwar".$n."_join WHERE gameid = '".$GPC['gameid']."'");
        $checkentries4 = $vwardb->query_first("SELECT COUNT(membergamesid) AS numd FROM vwar".$n."_membergames WHERE gameid = '".$GPC['gameid']."'");

        // locations
        if (0 < $checkentries['numa'] || $checkentries2['numb'] || $checkentries3['numc'] || $checkentries4['numd'])
        {
                $numentries = $checkentries['numa'] + $checkentries2['numb'] + $checkentries3['numc'] + $checkentries4['numd'];
                eval("\$admin_message_delete_entries .= \"".$vwartpl->get("admin_message_delete_entries")."\";");
        }

        eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
        eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_delete")."\");");
}

// ################################### display locations ###############################
if ($GPC['action'] == "viewlocations")
{
        checkPermission("canaddlocation-caneditlocation-candeletelocation");
        //template-cache, standard-templates will be added by script:
        $vwartpllist="gameselectbit2,gameselectbit,admin_location_listbit,admin_location_list";
        $vwartpl->cache($vwartpllist);

        eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");

        $result = $vwardb->query_first("
                SELECT COUNT(locationid) AS numlocs     FROM vwar".$n."_locations
                " . ifelse(!empty($showgame),   " WHERE gameid = '$showgame'") . "
        ");
        $totallocations = $result['numlocs'];

        $result = $vwardb->query("
                SELECT vwar".$n."_games.gameid, gamename, COUNT(locationid) AS numlocations
                FROM vwar".$n."_games, vwar".$n."_locations
                WHERE vwar".$n."_games.gameid = vwar".$n."_locations.gameid
                AND vwar".$n."_games.deleted = '0'
                GROUP BY vwar".$n."_games.gameid
                ORDER BY gamename
        ");
        while ($row = $vwardb->fetch_array($result))
        {
                dbSelectForm($row);

                if ($row['numlocations'] > 0)
                {
                        $gameid = $row['gameid'];
                        $gamename = $row['gamename'] . "&nbsp;(" . $row['numlocations'] . ")";

                        eval("\$gameselectbit .= \"".$vwartpl->get(ifelse(($showgame == $gameid),"gameselectbit2","gameselectbit"))."\";");
                }
        }

        if (!empty($showgame)) $show = " AND vwar".$n."_games.gameid = '".$showgame."'";

        $result = $vwardb->query("
                SELECT vwar".$n."_locations.*, vwar".$n."_games.gamename, vwar".$n."_games.gameid
                FROM vwar".$n."_locations
                LEFT JOIN vwar".$n."_games ON (vwar".$n."_locations.gameid = vwar".$n."_games.gameid)
                WHERE vwar".$n."_games.deleted = '0'
                $show
                ORDER BY gamename ASC, locationname ASC
                " . getLimitClause()
        );
        while ($row = $vwardb->fetch_array($result))
        {
                switchColors();
                dbSelect($row);

                $active = getActiveTag($row['deleted'], "Location");

                eval("\$admin_location_listbit .= \"".$vwartpl->get("admin_location_listbit")."\";");
        }

        $pagelinks = makepagelinks($totallocations,$perpage,"action=viewlocations&amp;showgame=".$showgame."");

        eval("\$vwartpl->output(\"".$vwartpl->get("admin_location_list")."\");");
}

// ################################### add location ####################################
if ($GPC['action'] == "addlocation")
{
        checkPermission("canaddlocation");

        if ($GPC['add'] || $GPC['add_x'])
        {
                // check for wrong data
                if ($locationname == "")
                {
                        $vwartpl->cache("admin_message_error_missingdata");
                        eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
                        eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_error_missingdata")."\");");
                        exit;
                }

                if ($transfer == "local" && @file_exists($vwar_root . "images/locations/$image"))
                {
                        $vwardb->query("
                                INSERT INTO vwar".$n."_locations
                                (locationname,gameid,locationpic)
                                VALUES (
                                '$locationname',
                                '$gameid',
                                '$image')
                        ");
                }
                else if ($transfer == "upload" && $HTTP_POST_FILES['filename']['name'] && $HTTP_POST_FILES['filename']['tmp_name'])
                {
                        $vwardb->query("INSERT INTO vwar".$n."_locations (locationname,gameid) VALUES ('$locationname','$gameid')");
                        $insertid = $vwardb->insert_id();

                        $filename = $insertid . "_" . strtolower($HTTP_POST_FILES['filename']['name']);
                        $upload->doUpload($HTTP_POST_FILES['filename'], $vwar_root . "images/locations/",0,0,$insertid . "_");

                        $vwardb->query("UPDATE vwar".$n."_locations SET locationpic='$filename' WHERE locationid='$insertid'");
                }
                header("Location: admin.php?action=viewlocations");
        }

        //template-cache, standard-templates will be added by script:
        $vwartpllist="gameselectbit,admin_addlocation";
        $vwartpl->cache($vwartpllist);

        eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");

        $result = $vwardb->query("SELECT * FROM vwar".$n."_games WHERE deleted = '0' ORDER BY gamename");
        while ($row = $vwardb->fetch_array($result))
        {
                $gameid = $row['gameid'];
                $gamename = $row['gamename'];

                eval("\$gameselectbit .= \"".$vwartpl->get("gameselectbit")."\";");
        }

        eval("\$vwartpl->output(\"".$vwartpl->get("admin_addlocation")."\");");
}

// ################################### edit location ###################################
if ($GPC['action'] == "editlocation")
{
        checkPermission("caneditlocation");

        if ($GPC['add'] || $GPC['add_x'])
        {
                // check for wrong data
                if ($locationname == "")
                {
                        $vwartpl->cache("admin_message_error_missingdata");
                        eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
                        eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_error_missingdata")."\");");
                        exit;
                }

                $locationid = $GPC['locationid'];
                $result = $vwardb->query_first("SELECT locationpic FROM vwar".$n."_locations WHERE locationid = '$locationid'");
                $oldpic = $result['locationpic'];

                if (!empty($HTTP_POST_FILES['filename']['name']))
                {
                        $locationpic = $locationid . "_" . strtolower($HTTP_POST_FILES['filename']['name']);

                        if ($oldpic != "") @unlink($vwar_root . "images/locations/$oldpic");

                        $upload->doUpload($HTTP_POST_FILES['filename'], $vwar_root . "images/locations/",0,0,$locationid . "_");
                }
                else if ($oldpic != $locationpic && $oldicon != "")
                {
                        @unlink($vwar_root . "images/locations/$oldpic");
                }
                $vwardb->query("
                        UPDATE vwar".$n."_locations
                        SET
                        locationname = '$locationname',
                        locationpic = '$locationpic',
                        gameid = '$gameid',
                        deleted = '$deleted'
                        WHERE locationid = '".$GPC['locationid']."'
                ");

                header("Location: admin.php?action=viewlocations");
        }

        //template-cache, standard-templates will be added by script:
        $vwartpllist="gameselectbit2,gameselectbit,admin_editlocation";
        $vwartpl->cache($vwartpllist);

        eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");

        $row = $vwardb->query_first("
                SELECT vwar".$n."_locations.*, vwar".$n."_games.gamename, vwar".$n."_games.gameid
                FROM vwar".$n."_locations
                LEFT JOIN vwar".$n."_games ON (vwar".$n."_locations.gameid = vwar".$n."_games.gameid)
                WHERE locationid = '".$GPC['locationid']."'
                AND vwar".$n."_games.deleted = '0'
        ");
        dbSelectForm($row);

        $deleted = makeyesnocode("deleted",$row['deleted']);

        $oldimage = ifelse($row['locationpic'], makeimgtag($vwar_root . "images/locations/" . $row['locationpic'] . "",$row['locationname']), "-");

        $result = $vwardb->query("SELECT * FROM vwar".$n."_games WHERE deleted = '0' ORDER BY gamename");
        while ($game = $vwardb->fetch_array($result))
        {
                dbSelectForm($game);

                $gameid = $game['gameid'];
                $gamename = $game['gamename'];

                eval("\$gameselectbit .= \"".$vwartpl->get(ifelse($gameid == $row['gameid'],"gameselectbit2","gameselectbit"))."\";");
        }

        eval("\$vwartpl->output(\"".$vwartpl->get("admin_editlocation")."\");");
}

// ################################### delete location #################################
if ($GPC['action'] == "deletelocation")
{
        checkPermission("candeletelocation");

        if ($delete)
        {
                $vwartpl->cache("admin_message_filesystem");
                eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
                eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_filesystem")."\");");
                exit;
        }

        if ($filesystem)
        {
                if ($filesystem == "Yes")
                {
                        $result = $vwardb->query_first("SELECT locationpic FROM vwar".$n."_locations WHERE locationid = '".$GPC['locationid']."'");
                        $pic = $result['locationpic'];
                        @unlink($vwar_root . "images/locations/$pic");
                }
                $vwardb->query("DELETE FROM vwar".$n."_locations WHERE locationid = '".$GPC['locationid']."'");
                $vwardb->query("DELETE FROM vwar".$n."_memberlocation WHERE locationid = '".$GPC['locationid']."'");

                header("Location: admin.php?action=viewlocations&showgame=$showgame&page=$page&s=$s");
        }
        $vwartpl->cache("admin_message_delete,admin_message_delete_entries");

        // check for other entries linked with this one
        $checkentries  = $vwardb->query_first("SELECT COUNT(screenid) AS numa FROM vwar".$n."_screen
                WHERE locationid = '".$GPC['locationid']."'");
        $checkentries2 = $vwardb->query_first("SELECT COUNT(challengeid) AS numb FROM vwar".$n."_challenge
                WHERE locations LIKE '%".$GPC['locationid']."%'");
        $checkentries3 = $vwardb->query_first("SELECT COUNT(scoreid) AS numc FROM vwar".$n."_scores
                WHERE locationid = '".$GPC['locationid']."'");
        $checkentries4 = $vwardb->query_first("SELECT COUNT(memberlocationid) AS numd FROM vwar".$n."_memberlocation
                WHERE locationid = '".$GPC['locationid']."'");

        if (0 < $checkentries['numa'] || $checkentries2['numb'] || $checkentries3['numc'] || $checkentries4['numd'])
        {
                $numentries = $checkentries['numa'] + $checkentries2['numb'] + $checkentries3['numc'] + $checkentries4['numd'];
                eval("\$admin_message_delete_entries .= \"".$vwartpl->get("admin_message_delete_entries")."\";");
        }
        eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
        eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_delete")."\");");
}

// ################################### view challenges #################################
if ($GPC['action'] == "viewchallenges")
{
        checkPermission("canaddwar");
        //template-cache, standard-templates will be added by script:
        $vwartpllist="admin_challengelistbit,admin_challengelist";
        $vwartpl->cache($vwartpllist);

        $result = $vwardb->query("
                SELECT challengeid, teamname, teamnameshort, dateline, vwar".$n."_games.gamename
                FROM vwar".$n."_challenge
                LEFT JOIN vwar".$n."_games ON (vwar".$n."_challenge.gameid = vwar".$n."_games.gameid)
                ORDER BY dateline DESC
        ");
        while ($row = $vwardb->fetch_array($result))
        {
                switchColors();
                dbSelect($row);

                $dateline = formatdatetime($row['dateline'], $longdateformat);

                $row['gamename'] = ifelse($row['gamename'],$row['gamename'],"-");

                eval("\$admin_challengelistbit .= \"".$vwartpl->get("admin_challengelistbit")."\";");
        }

        eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
        eval("\$vwartpl->output(\"".$vwartpl->get("admin_challengelist")."\");");
}

// ################################### view challengedetails ############################
if ($GPC['action'] == "challengedetails")
{

        checkPermission("canaddwar");

        if ($GPC['add'] || $GPC['add_x'])
        {
                if ($opphomepage == $notavailable) unset($opphomepage);
                if ($oppcontacticq == $notavailable) unset($oppcontacticq);
                header("Location: admin.php?action=addwar&challengeid=" . $challengeid . "");
        }

        //template-cache, standard-templates will be added by script:
        $vwartpllist="admin_challengedetails";
        $vwartpl->cache($vwartpllist);

        eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");

        $row = $vwardb->query_first("
                SELECT vwar".$n."_challenge.*, vwar".$n."_games.*, vwar".$n."_gametype.*, vwar".$n."_matchtype.*
                FROM vwar".$n."_challenge
                LEFT JOIN vwar".$n."_games ON (vwar".$n."_challenge.gameid = vwar".$n."_games.gameid)
                LEFT JOIN vwar".$n."_gametype ON (vwar".$n."_challenge.gametypeid = vwar".$n."_gametype.gametypeid)
                LEFT JOIN vwar".$n."_matchtype ON (vwar".$n."_challenge.matchtypeid = vwar".$n."_matchtype.matchtypeid)
                WHERE challengeid = '".$GPC['challengeid']."'
        ");
        dbSelect($row);

        $contacthomepage = ifelse($row['contacthomepage'] != "", makelink(checkUrlFormat($row['contacthomepage']), $row['contacthomepage']), "-");

        $row['contacticq'] = ifelse((!empty($row['contacticq']) && $row['contacticq'] != 0), $row['contacticq'], "-");
        $row['contactaim'] = ifelse(!empty($row['contactaim']), $row['contactaim'], "-");
        $row['contactyim'] = ifelse(!empty($row['contactyim']), $row['contactyim'], "-");
        $row['contactmsn'] = ifelse(!empty($row['contactmsn']), $row['contactmsn'], "-");
        $row['contactircnetwork'] = ifelse(!empty($row['contactircnetwork']), $row['contactircnetwork'], "-");
        $row['contactircchannel'] = ifelse(!empty($row['contactircchannel']), $row['contactircchannel'], "-");

        $dateline = formatdatetime($row['dateline'], $longdateformat);
        $challengeinfo = ifelse(!empty($row['challengeinfo']), (parseText($row['challengeinfo'],0)), $notavailable);

        $row['locations'] = split("\|\|",$row['locations']);
        for ($i = 0; $i < count($row['locations']); $i++)
        {
                $result = $vwardb->query_first("SELECT locationname FROM vwar".$n."_locations WHERE locationid = '".$row['locations'][$i]."'");
                $locations .= $result['locationname'] . "<br>";
        }
        eval("\$vwartpl->output(\"".$vwartpl->get("admin_challengedetails")."\");");
}

// ################################### delete challenge ################################
if ($GPC['action'] == "deletechallenge")
{
        checkPermission("candeletewar");

        if ($delete)
        {
                $vwardb->query("DELETE FROM vwar".$n."_challenge WHERE challengeid = '".$GPC['challengeid']."'");
                header("Location: admin.php?action=viewchallenges");
        }
        $vwartpl->cache("admin_message_delete");
        eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
        eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_delete")."\");");
}

// ################################### display opponents ###################################
if ($GPC['action'] == "viewopponents")
{
        checkPermission("canaddwar-candeletewar-caneditwar-canfinishwar");
        //template-cache, standard-templates will be added by script:
        $vwartpllist="admin_opponent_listbit,admin_opponent_list";
        $vwartpl->cache($vwartpllist);

        $result=$vwardb->query_first("SELECT COUNT(oppid) AS numopp FROM vwar".$n."_opponents");
        $numopponents = $result['numopp'];

        $result = $vwardb->query("
                SELECT oppid,oppname,oppnameshort,deleted
                FROM vwar".$n."_opponents
                ORDER BY oppname ASC
                " . getLimitClause()
        );
        while ($row = $vwardb->fetch_array($result))
        {
                dbSelect($row);
                switchColors();

                $active = getActiveTag($row['deleted'], "Opponent");

                eval("\$admin_opponent_listbit .= \"".$vwartpl->get("admin_opponent_listbit")."\";");
        }

        $pagelinks = makepagelinks($numopponents,$perpage,"action=viewopponents");

        eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
        eval("\$vwartpl->output(\"".$vwartpl->get("admin_opponent_list")."\");");
}

// ################################### search opponent #################################
if ($GPC['action'] == "searchopponent")
{
        checkPermission("canaddwar-candeletewar-caneditwar-canfinishwar");
        //template-cache, standard-templates will be added by script:
        $vwartpllist="admin_opponent_listbit,admin_opponent_list";
        $vwartpl->cache($vwartpllist);

        $result = $vwardb->query_first("SELECT count(oppid) AS numopp FROM vwar".$n."_opponents WHERE oppname LIKE '%$searchopponent%'");
        $numopponents = $result['numopp'];

        $result = $vwardb->query("
                SELECT *
                FROM vwar".$n."_opponents
                WHERE oppname LIKE '%$searchopponent%'
                ORDER BY oppnameshort ASC
                " . getLimitClause() . "
        ");
        while ($row = $vwardb->fetch_array($result))
        {
                switchColors();

                $active = getActiveTag($row['deleted'], "Opponent");

                // highlight search string
                $row['oppname'] = preg_replace("=".preg_quote($searchopponent,'=')."=i","<font color=\"#F00000\"><b>$0</b></font>",$row['oppname']);

                eval("\$admin_opponent_listbit .= \"".$vwartpl->get("admin_opponent_listbit")."\";");
        }

        $pagelinks = makepagelinks($numtemplates,$perpage,"action=searchopponent&amp;searchopponent=$searchopponent");

        eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
        eval("\$vwartpl->output(\"".$vwartpl->get("admin_opponent_list")."\");");
}

// ################################### add opponent #######################################
if ($GPC['action'] == "addopponent")
{
        checkPermission("canaddwar");

        if ($GPC['add'] || $GPC['add_x'])
        {
                // check for wrong data
                if (($GPC["addmode"] == "manual" && ($GPC["oppnameshort"] == "" || $GPC["oppname"] == "")) ||
            ($GPC["addmode"] == "file" && $GPC["contactfile"] == ""))
                {
                        $vwartpl->cache("admin_message_error_missingdata");
                        eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
                        eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_error_missingdata")."\");");
                        exit;
                }

                if($GPC["addmode"] == "file")
                {
            // read opponent data from contact file
            $filename = checkPath($GPC["contactfile"])."vwarcard.dat";
            $size = (int)getRemoteFilesize($filename);
            if($size > 380)
            {
                $handle = fopen($filename,"r");
                $tmp = fread($handle,$size);

                preg_match_all('/<data name="(.*)">(.*)<\/data>/isU',$tmp,$matches);
                for($item = 0; $item < sizeof($matches[0]); $item++)
                {
                    $GPC["opp".($matches[1][$item])] = addslashes($matches[2][$item]);
                }

                if($GPC["oppnameshort"] == "" || $GPC["oppname"] == "")
                {
                    $vwartpl->cache("admin_message_error_missingdata");
                    eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
                    eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_error_missingdata")."\");");
                    exit;
                }
            }
            else
            {
                $vwartpl->cache("admin_message_error_missingdata");
                eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
                eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_error_missingdata")."\");");
                exit;
            }
        }

                $vwardb->query("
                        INSERT INTO vwar".$n."_opponents
                        (oppnameshort,oppname,oppcontactname,oppcontactmail,oppcontacticq,oppcontactaim,oppcontactyim,
                                oppcontactmsn,opphomepage,oppircnetwork,oppircchannel,oppcountry)
                        VALUES (
                        '".$GPC["oppnameshort"]."',
                        '".$GPC["oppname"]."',
                        '".$GPC["oppcontactname"]."',
                        '".$GPC["oppcontactmail"]."',
                        '".$GPC["oppcontacticq"]."',
                        '".$GPC["oppcontactaim"]."',
                        '".$GPC["oppcontactyim"]."',
                        '".$GPC["oppcontactmsn"]."',
                        '".checkUrlFormat($GPC["opphomepage"])."',
                        '".$GPC["oppircnetwork"]."',
                        '".$GPC["oppircchannel"]."',
                        '".$GPC["oppcountry"]."')
                ");

                header("Location: admin.php?action=viewopponents");
        }
        $admin_countryselectbit = doCountrySelect();

        $vwartpl->cache("admin_addopponent");
        eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
        eval("\$vwartpl->output(\"".$vwartpl->get("admin_addopponent")."\");");
}

// ################################### edit opponent ######################################
if ($GPC['action'] == "editopponent")
{
        checkPermission("caneditwar-canfinishwar");

        if ($GPC['add'] || $GPC['add_x'])
        {
                // check for wrong data
                if ($GPC["oppnameshort"] == "" || $GPC["oppname"] == "")
                {
                        $vwartpl->cache("admin_message_error_missingdata");
                        eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
                        eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_error_missingdata")."\");");
                        exit;
                }

                $vwardb->query("
                        UPDATE vwar".$n."_opponents
                        SET
                        oppnameshort = '".$GPC["oppnameshort"]."',
                        oppname = '".$GPC["oppname"]."',
                        oppcontactname = '".$GPC["oppcontactname"]."',
                        oppcontactmail = '".$GPC["oppcontactmail"]."',
                        oppcontacticq = '".$GPC["oppcontacticq"]."',
                        oppcontactaim = '".$GPC["oppcontactaim"]."',
                        oppcontactyim = '".$GPC["oppcontactyim"]."',
                        oppcontactmsn = '".$GPC["oppcontactmsn"]."',
                        opphomepage = '".checkUrlFormat($GPC["opphomepage"])."',
                        oppircnetwork = '".$GPC["oppircnetwork"]."',
                        oppircchannel = '".$GPC["oppircchannel"]."',
                        oppcountry = '".$GPC["oppcountry"]."',
                        deleted = '".$GPC["deleted"]."'
                        WHERE oppid = '".$GPC['oppid']."'
                ");

                header("Location: admin.php?action=viewopponents");
        }

        $vwartpl->cache("admin_editopponent");
        eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");

        $row = $vwardb->query_first("SELECT * FROM vwar".$n."_opponents WHERE oppid = '".$GPC['oppid']."' ORDER BY oppname ASC");
        dbSelectForm($row);

        $deleted = makeyesnocode("deleted",$row['deleted']);
        $admin_countryselectbit = doCountrySelect($row['oppcountry']);
        $row['oppcontacticq'] = ifelse($row['oppcontacticq'], $row['oppcontacticq']);

        eval("\$vwartpl->output(\"".$vwartpl->get("admin_editopponent")."\",1);");
}

// ################################### delete opponent #################################
if ($GPC['action'] == "deleteopponent")
{
        checkPermission("caneditwar-candeletewar-canfinishwar");

        if ($delete)
        {
                $vwardb->query("DELETE FROM vwar".$n."_opponents WHERE oppid = '".$GPC['oppid']."'");
                header("Location: admin.php?action=viewopponents&page=$page&s=$s");
        }

        $vwartpl->cache("admin_message_delete,admin_message_delete_entries");

        // check for other entries linked with this one
        $checkentries = $vwardb->query_first("SELECT COUNT(warid) numwars FROM vwar".$n." WHERE oppid = '".$GPC['oppid']."'");
        if ($checkentries['numwars'] > 0)
        {
                $numentries = $checkentries['numwars'];
                eval("\$admin_message_delete_entries .= \"".$vwartpl->get("admin_message_delete_entries")."\";");
        }

        eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
        eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_delete")."\");");
}

// ################################### display smilies ###################################
if ($GPC['action'] == "viewsmilies")
{
        checkPermission("isadmin");
        //template-cache, standard-templates will be added by script:
        $vwartpllist="admin_smilie_listbit,admin_smilie_list";
        $vwartpl->cache($vwartpllist);

        $result = $vwardb->query_first("SELECT count(smilieid) AS numsmilies FROM vwar".$n."_smilie");
        $numsmilies = $result['numsmilies'];

        $result = $vwardb->query("
                SELECT *
                FROM vwar".$n."_smilie
                ORDER BY title ASC
                " . getLimitClause()
        );
        while ($row = $vwardb->fetch_array($result))
        {
                switchColors();
                dbSelect($row);

                $active = getActiveTag($row['deleted'], "Smilie/Icon");

                eval("\$admin_smilie_listbit .= \"".$vwartpl->get("admin_smilie_listbit")."\";");
        }

        $pagelinks = makepagelinks($numsmilies,$perpage,"action=viewsmilies");

        eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
        eval("\$vwartpl->output(\"".$vwartpl->get("admin_smilie_list")."\");");
}

// ################################### add smilie #######################################
if ($GPC['action'] == "addsmilie")
{
        checkPermission("isadmin");

        if ($GPC['add'] || $GPC['add_x'])
        {
                // check for wrong data
                if ($title == "" || $code == "" || ($transfer == "local" && ($image == ""
                        || !@file_exists($vwar_root . "images/smilies/".$image))) || ($transfer=="upload" && (!$HTTP_POST_FILES['filename']['name']
                                || !$HTTP_POST_FILES['filename']['tmp_name'])))
                {
                        $vwartpl->cache("admin_message_error_missingdata");
                        eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
                        eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_error_missingdata")."\");");
                        exit;
                }

                if ($transfer == "local")
                {
                        $vwardb->query("
                                INSERT INTO vwar".$n."_smilie
                                (title,code,filename,smilie,icon)
                                VALUES (
                                '$title',
                                '$code',
                                '$image',
                                '$smilie',
                                '$icon')
                        ");
                }
                else if ($transfer == "upload")
                {
                        $vwardb->query("INSERT INTO vwar".$n."_smilie (title,code,smilie,icon) VALUES ('$title','$code','$smilie','$icon')");
                        $insertid = $vwardb->insert_id();

                        $filename = $insertid . "_" . strtolower($HTTP_POST_FILES['filename']['name']);
                        $upload->doUpload($HTTP_POST_FILES['filename'], $vwar_root . "images/smilies/",0,0,$insertid."_");

                        $vwardb->query("UPDATE vwar".$n."_smilie SET filename='$filename' WHERE smilieid = '$insertid'");
                }
                header("Location: admin.php?action=viewsmilies");
        }
        else
        {
                $vwartpl->cache("admin_addsmilie");

                $smilie = makeyesnocode("smilie", 1);
                $icon = makeyesnocode("icon", 0);

                eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
                eval("\$vwartpl->output(\"".$vwartpl->get("admin_addsmilie")."\");");
        }
}

// ################################### edit smilie ######################################
if ($GPC['action'] == "editsmilie")
{
        checkPermission("isadmin");

        if ($GPC['add'] || $GPC['add_x'])
        {
                // check for wrong data
                if ($title == "" || $code == "" || ($filepath == "" && !@file_exists($vwar_root . "images/smilies/" . $filepath) && empty($filename))
                        || (!empty($filename) && (!$HTTP_POST_FILES['filename']['name'] || !$HTTP_POST_FILES['filename']['tmp_name'])))
                {
                        $vwartpl->cache("admin_message_error_missingdata");
                        eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
                        eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_error_missingdata")."\");");
                        exit;
                }

                $smilieid = $GPC['smilieid'];
                $result = $vwardb->query_first("SELECT filename FROM vwar".$n."_smilie WHERE smilieid = '$smilieid'");
                $oldsmilie = $result['filename'];
                if (!empty($filename))
                {
                        $filepath = $smilieid . "_" . $HTTP_POST_FILES['filename']['name'];

                        if($oldsmilie != "") @unlink($vwar_root . "images/smilies/$oldsmilie");

                        $upload->doUpload($HTTP_POST_FILES['filename'], $vwar_root . "images/smilies/",0,0,$smilieid . "_");
                }
                else if ($oldsmilie != $filepath && $oldsmilie != "")
                {
                        @unlink($vwar_root . "images/smilies/$oldsmilie");
                }

                $vwardb->query("
                        UPDATE vwar".$n."_smilie
                        SET
                        title                   =       '$title',
                        code                    =       '$code',
                        filename        =       '$filepath',
                        smilie          =       '$smilie',
                        icon                    =       '$icon',
                        deleted         =       '$deleted'
                        WHERE smilieid = '$smilieid'
                ");

                header("Location: admin.php?action=viewsmilies");
        }
        $row = $vwardb->query_first("SELECT * FROM vwar".$n."_smilie WHERE smilieid = '".$GPC['smilieid']."'");
        dbSelectForm($row);

        $filename = ifelse($row['filename'], makeimgtag($vwar_root . "images/smilies/" . $row['filename'] . "",$row['title']), "-");
        $deleted = makeyesnocode("deleted", $row['deleted']);
        $smilie = makeyesnocode("smilie", $row['smilie']);
        $icon = makeyesnocode("icon", $row['icon']);

        $vwartpl->cache("admin_editsmilie");
        eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
        eval("\$vwartpl->output(\"".$vwartpl->get("admin_editsmilie")."\",1);");
}

// ################################### delete smilie ######################################
if ($GPC['action'] == "deletesmilie")
{
        checkPermission("isadmin");

        if ($delete)
        {
                $vwartpl->cache("admin_message_filesystem");
                eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
                eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_filesystem")."\");");
                exit;
        }

        if ($filesystem)
        {
                if($filesystem == "Yes")
                {
                        $result = $vwardb->query_first("SELECT filename FROM vwar".$n."_smilie WHERE smilieid = '".$GPC['smilieid']."'");
                        $smilie = $result['filename'];

                        @unlink($vwar_root . "images/smilies/$smilie");
                }
                $vwardb->query("DELETE FROM vwar".$n."_smilie WHERE smilieid = '".$GPC['smilieid']."'");
                header("Location: admin.php?action=viewsmilies");
        }
        $vwartpl->cache("admin_message_delete");
        eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
        eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_delete")."\");");
}

// ################################### contact - vwarcard #####################################
if ($GPC['action'] == "contact")
{
    checkPermission("isadmin");

    $filename = "./../vwarcard.dat";

        if ($GPC['add'] || $GPC['add_x'])
        {
                // check for wrong data
                if($GPC["data"]["nameshort"] == "" || $GPC["data"]["name"] == "")
                {
                        $vwartpl->cache("admin_message_error_missingdata");
                        eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
                        eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_error_missingdata")."\");");
                        exit;
                }

                // save data to card
                if(is_writable($filename))
                {
            $handle = fopen($filename,"wb");

            // create string and write to file
            foreach($GPC["data"] as $field => $value)
            {
                $tmp .= '<data name="'.$field.'">'.trim($value).'</data>'."\r\n";
            }

            fwrite($handle,$tmp);
            fclose($handle);
                }
                else
                {
            $path = $filename;
                        $vwartpl->cache("admin_message_error_fileupload");
                        eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
                        eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_error_fileupload")."\");");
                        exit;
                }
        }

        // open file and get data
        $handle = @fopen($filename,"rb");
        if(!$handle)
        {
        $path = $filename;
        eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
        eval("\$vwartpl->output(\"".$vwartpl->get("admin_message_error_fileupload")."\");");
        exit;
        }

    // create data array
    unset($tmp);
    unset($data);
    $tmp = fread($handle,filesize($filename));
        fclose($handle);

        preg_match_all('/<data name="(.*)">(.*)<\/data>/isU',$tmp,$matches);
    for($item = 0; $item < sizeof($matches[0]); $item++)
    {
        $data[($matches[1][$item])] = $matches[2][$item];
    }

        $vwartpl->cache("admin_vwarcard");
    $admin_countryselectbit = doCountrySelect($data["country"]);
        eval("\$vwartpl->output(\"".$vwartpl->get("admin_header")."\");");
        eval("\$vwartpl->output(\"".$vwartpl->get("admin_vwarcard")."\");");
}
?>
