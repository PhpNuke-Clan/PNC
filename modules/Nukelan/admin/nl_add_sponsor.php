<?php

/************************************************************************/
/* PHP-NUKE: Web Portal System                                          */
/* ===========================                                          */
/*                                                                      */
/* Copyright (c) 2005 by Francisco Burzi                                */
/* http://phpnuke.org                                                   */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/

if (!defined('ADMIN_FILE')) {
        die ("Access Denied");
}

global $db, $prefix, $user_prefix, $db, $admin_file;
$aid = substr("$aid", 0,25);

        /*********************************************************/
        /* Banners Administration Functions                      */
        /*********************************************************/

        function NLBannersAdmin() {
                global $db, $prefix, $user_prefix, $db, $bgcolor2, $banners, $admin_file;
                include("header.php");
                lan_menu();
                OpenTable();
                echo "<center><font class=\"title\"><b>" . _NLBANNERSADMIN . "</b></font></center>";
                CloseTable();
                echo "<br>";
                /* Banners List */
                echo "<a name=\"top\">";
                OpenTable();
                echo "<center><font class=\"option\"><b>" . _ACTIVEBANNERS . "</b></font></center><br>"
                ."<table width=100% border=1><tr>"
                ."<td bgcolor=\"$bgcolor2\" align=\"center\"><b>" . _CLIENTNAME . "</b></td>"
                ."<td bgcolor=\"$bgcolor2\" align=\"center\"><b>" . _IMPRESSIONS . "</b></td>"
                ."<td bgcolor=\"$bgcolor2\" align=\"center\"><b>" . _IMPLEFT . "</b></td>"
                ."<td bgcolor=\"$bgcolor2\" align=\"center\"><b>" . _CLICKS . "</b></td>"
                ."<td bgcolor=\"$bgcolor2\" align=\"center\"><b>" . _CLICKSPERCENT . "</b></td>"
                ."<td bgcolor=\"$bgcolor2\" align=\"center\"><b>" . _TYPE . "</b></td>"
                ."<td bgcolor=\"$bgcolor2\" align=\"center\"><b>" . _FUNCTIONS . "</b></td><tr>";
                $result = $db->sql_query("SELECT bid, cid, imptotal, impmade, clicks, imageurl, date, type, active from nukelan_sponsors_banners WHERE active='1' order by type,bid");
                while ($row = $db->sql_fetchrow($result)) {
                        $bid = intval($row['bid']);
                        $cid = intval($row['cid']);
                        $imptotal = intval($row['imptotal']);
                        $impmade = intval($row['impmade']);
                        $clicks = intval($row['clicks']);
                        $imageurl = $row['imageurl'];
                        $date = $row['date'];
                        $type = $row['type'];
                        $active = intval($row['active']);
                        $row2 = $db->sql_fetchrow($db->sql_query("SELECT id, sponsor_name from nukelan_sponsors where id='$cid'"));
                        $cid = intval($row2['id']);
                        $name = trim($row2['sponsor_name']);
                        if($impmade==0) {
                                $percent = 0;
                        } else {
                                $percent = substr(100 * $clicks / $impmade, 0, 5);
                        }
                        if($imptotal==0) {
                                $left = _UNLIMITED;
                        } else {
                                $left = $imptotal-$impmade;
                        }
                        if ($type == 0) {
                                $type = _NORMAL;
                        } else {
                                $type = _BLOCK;
                        }
                        if ($active == 1) {
                                $t_active = "<img src=\"images/active.gif\" alt=\""._ACTIVE."\" title=\""._ACTIVE."\" border=\"0\" width=\"16\" height=\"16\">";
                                $c_active = "<img src=\"images/inactive.gif\" alt=\""._DEACTIVATE."\" title=\""._DEACTIVATE."\" border=\"0\" width=\"16\" height=\"16\">";
                        } else {
                                $t_active = "<img src=\"images/inactive.gif\" alt=\""._INACTIVE."\" title=\""._INACTIVE."\" border=\"0\" width=\"16\" height=\"16\">";
                                $c_active = "<img src=\"images/active.gif\" alt=\""._ACTIVATE."\" title=\""._ACTIVATE."\" border=\"0\" width=\"16\" height=\"16\">";
                        }
                        echo "<td bgcolor=\"$bgcolor1\" align=center><a href=\"$imageurl\" target=\"new\">$name</a></td>"
                        ."<td bgcolor=\"$bgcolor1\" align=center>$impmade</td>"
                        ."<td bgcolor=\"$bgcolor1\" align=center>$left</td>"
                        ."<td bgcolor=\"$bgcolor1\" align=center>$clicks</td>"
                        ."<td bgcolor=\"$bgcolor1\" align=center>$percent%</td>"
                        ."<td bgcolor=\"$bgcolor1\" align=center>$type</td>"
                        ."<td bgcolor=\"$bgcolor1\" align=center>&nbsp;<a href=\"".$admin_file.".php?op=add_sponsor&spop=NLBannerEdit&amp;bid=$bid\"><img src=\"images/edit.gif\" alt=\""._EDIT."\" title=\""._EDIT."\" border=\"0\" width=\"17\" height=\"17\"></a>  <a href=\"".$admin_file.".php?op=add_sponsor&spop=NLBannerStatus&amp;bid=$bid&status=$active\">$c_active</a>  <a href=\"".$admin_file.".php?op=add_sponsor&spop=NLBannerDelete&amp;bid=$bid&amp;ok=0\"><img src=\"images/delete.gif\" alt=\""._DELETE."\" title=\""._DELETE."\" border=\"0\" width=\"17\" height=\"17\"></a>&nbsp;</td><tr>";
                }
                echo "</td></tr></table><br>"
                ."<center><font class=\"option\"><b>" . _INACTIVEBANNERS . "</b></font></center><br>"
                ."<table width=100% border=1><tr>"
                ."<td bgcolor=\"$bgcolor2\" align=\"center\"><b>" . _CLIENTNAME . "</b></td>"
                ."<td bgcolor=\"$bgcolor2\" align=\"center\"><b>" . _IMPRESSIONS . "</b></td>"
                ."<td bgcolor=\"$bgcolor2\" align=\"center\"><b>" . _IMPLEFT . "</b></td>"
                ."<td bgcolor=\"$bgcolor2\" align=\"center\"><b>" . _CLICKS . "</b></td>"
                ."<td bgcolor=\"$bgcolor2\" align=\"center\"><b>" . _CLICKSPERCENT . "</b></td>"
                ."<td bgcolor=\"$bgcolor2\" align=\"center\"><b>" . _TYPE . "</b></td>"
                ."<td bgcolor=\"$bgcolor2\" align=\"center\"><b>" . _FUNCTIONS . "</b></td><tr>";
                $result = $db->sql_query("SELECT bid, cid, imptotal, impmade, clicks, imageurl, date, type, active from nukelan_sponsors_banners WHERE active='0' order by type,bid");
                while ($row = $db->sql_fetchrow($result)) {
                        $bid = intval($row['bid']);
                        $cid = intval($row['cid']);
                        $imptotal = intval($row['imptotal']);
                        $impmade = intval($row['impmade']);
                        $clicks = intval($row['clicks']);
                        $imageurl = $row['imageurl'];
                        $date = $row['date'];
                        $type = $row['type'];
                        $active = intval($row['active']);
                        $row2 = $db->sql_fetchrow($db->sql_query("SELECT id, sponsor_name from nukelan_sponsors where id='$cid'"));
                        $cid = intval($row2['id']);
                        $name = trim($row2['sponsor_name']);
                        if($impmade==0) {
                                $percent = 0;
                        } else {
                                $percent = substr(100 * $clicks / $impmade, 0, 5);
                        }
                        if($imptotal==0) {
                                $left = _UNLIMITED;
                        } else {
                                $left = $imptotal-$impmade;
                        }
                        if ($type == 0) {
                                $type = _NORMAL;
                        } else {
                                $type = _BLOCK;
                        }
                        if ($active == 1) {
                                $t_active = "<img src=\"images/active.gif\" alt=\""._ACTIVE."\" title=\""._ACTIVE."\" border=\"0\" width=\"16\" height=\"16\">";
                                $c_active = "<img src=\"images/inactive.gif\" alt=\""._DEACTIVATE."\" title=\""._DEACTIVATE."\" border=\"0\" width=\"16\" height=\"16\">";
                        } else {
                                $t_active = "<img src=\"images/inactive.gif\" alt=\""._INACTIVE."\" title=\""._INACTIVE."\" border=\"0\" width=\"16\" height=\"16\">";
                                $c_active = "<img src=\"images/active.gif\" alt=\""._ACTIVATE."\" title=\""._ACTIVATE."\" border=\"0\" width=\"16\" height=\"16\">";
                        }
                        echo "<td bgcolor=\"$bgcolor1\" align=center><a href=\"$imageurl\" target=\"new\">$name</a></td>"
                        ."<td bgcolor=\"$bgcolor1\" align=center>$impmade</td>"
                        ."<td bgcolor=\"$bgcolor1\" align=center>$left</td>"
                        ."<td bgcolor=\"$bgcolor1\" align=center>$clicks</td>"
                        ."<td bgcolor=\"$bgcolor1\" align=center>$percent%</td>"
                        ."<td bgcolor=\"$bgcolor1\" align=center>$type</td>"
                        ."<td bgcolor=\"$bgcolor1\" align=center>&nbsp;<a href=\"".$admin_file.".php?op=add_sponsor&spop=NLBannerEdit&amp;bid=$bid\"><img src=\"images/edit.gif\" alt=\""._EDIT."\" title=\""._EDIT."\" border=\"0\" width=\"17\" height=\"17\"></a>  <a href=\"".$admin_file.".php?op=add_sponsor&spop=NLBannerStatus&amp;bid=$bid&status=$active\">$c_active</a>  <a href=\"".$admin_file.".php?op=add_sponsor&spop=NLBannerDelete&amp;bid=$bid&amp;ok=0\"><img src=\"images/delete.gif\" alt=\""._DELETE."\" title=\""._DELETE."\" border=\"0\" width=\"17\" height=\"17\"></a>&nbsp;</td><tr>";
                }
                echo "</td></tr></table>";
                CloseTable();
                echo "<br>";
                /* Clients List */
                OpenTable();
                echo "<center><font class=\"option\"><b>" . _ADVERTISINGCLIENTS . "</b></font></center><br>"
                ."<table width=\"100%\" border=\"1\"><tr>"
                ."<td bgcolor=\"$bgcolor2\" align=\"center\"><b>" . _CLIENTNAME . "</b></td>"
                ."<td bgcolor=\"$bgcolor2\" align=\"center\"><b>" . _ACTIVEBANNERS2 . "</b></td>"
                ."<td bgcolor=\"$bgcolor2\" align=\"center\"><b>" . _INACTIVEBANNERS . "</b></td>"
                ."<td bgcolor=\"$bgcolor2\" align=\"center\"><b>" . _CONTACTNAME . "</b></td>"
                ."<td bgcolor=\"$bgcolor2\" align=\"center\"><b>" . _CONTACTEMAIL . "</b></td>"
                ."<td bgcolor=\"$bgcolor2\" align=\"center\"><b>" . _FUNCTIONS . "</b></td><tr>";
                $result3 = $db->sql_query("SELECT id, sponsor_name, contact, email from nukelan_sponsors order by id");
                while ($row3 = $db->sql_fetchrow($result3)) {
                        $cid = intval($row3['id']);
                        $name = $row3['sponsor_name'];
                        $contact = $row3['contact'];
                        $email = $row3['email'];
                        $result4 = $db->sql_query("SELECT cid from nukelan_sponsors_banners WHERE cid='$cid' AND active='1'");
                        $numrows = $db->sql_numrows($result4);
                        $row4 = $db->sql_fetchrow($result4);
                        $rcid = intval($row4['cid']);
                        $numrows2 = $db->sql_numrows($db->sql_query("SELECT cid from nukelan_sponsors_banners WHERE cid='$cid' AND active='0'"));
                        echo "<td bgcolor=\"$bgcolor1\" align=\"center\">$name</td>"
                        ."<td bgcolor=\"$bgcolor1\" align=\"center\">$numrows</td>"
                        ."<td bgcolor=\"$bgcolor1\" align=\"center\">$numrows2</td>"
                        ."<td bgcolor=\"$bgcolor1\" align=\"center\">$contact</td>"
                        ."<td bgcolor=\"$bgcolor1\" align=\"center\"><a href=\"mailto:$email\">$email</a></td>"
                        ."<td bgcolor=\"$bgcolor1\" align=\"center\" nowrap>&nbsp;<a href=\"".$admin_file.".php?op=add_sponsor&spop=NLBannerClientEdit&amp;cid=$cid\"><img src=\"images/edit.gif\" alt=\""._EDIT."\" title=\""._EDIT."\" border=\"0\" width=\"17\" height=\"17\"></a>  <a href=\"".$admin_file.".php?op=add_sponsor&spop=NLBannerClientDelete&amp;cid=$cid\"><img src=\"images/delete.gif\" alt=\""._DELETE."\" title=\""._DELETE."\" border=\"0\" width=\"17\" height=\"17\"></a>&nbsp;</td><tr>";
                }
                echo "</td></tr></table>";
                CloseTable();
                echo "<br>";
                /* Add Banner */
                $result5 = $db->sql_query("select * from nukelan_sponsors");
                $numrows3 = $db->sql_numrows($result5);
                if($numrows3>0) {
                        OpenTable();
                        echo "<font class=\"option\"><b>" . _ADDNEWBANNER . "</b></font></center><br><br>"
                        ."<form action=\"".$admin_file.".php?op=add_sponsor\" method=\"post\">"
                        ."" . _CLIENTNAME . ": "
                        ."<select name=\"cid\">";
                        $result6 = $db->sql_query("SELECT id, sponsor_name from nukelan_sponsors ORDER BY sponsor_name");
                        while ($row6 = $db->sql_fetchrow($result6)) {
                                $cid = intval($row6['id']);
                                $name = $row6['sponsor_name'];
                                echo "<option value=\"$cid\">$name</option>";
                        }
                        echo "</select><br><br>"
                        ."" . _PURCHASEDIMPRESSIONS . ": <input type=\"text\" name=\"imptotal\" size=\"12\" maxlength=\"11\"> 0 = " . _UNLIMITED . "<br><br>"
                        ."" . _IMAGEURL . ": <input type=\"text\" name=\"imageurl\" size=\"50\" maxlength=\"100\"><br><br>"
                        ."" . _CLICKURL . ": <input type=\"text\" name=\"clickurl\" size=\"50\" maxlength=\"200\"><br><br>"
                        ."" . _ALTTEXT . ": <input type=\"text\" name=\"alttext\" size=\"50\" maxlength=\"255\"><br><br>"
                        ."" . _TYPE . ": <select name=\"type\">"
                        ."<option name=\"type\" value=\"0\">" . _NORMAL . "</option>"
                        ."<option name=\"type\" value=\"1\">" . _BLOCK . "</option>"
                        ."</select><br><br>"
                        ."" . _ACTIVATE . ": <input type=\"radio\" name=\"active\" value=\"1\">" . _YES . "&nbsp;&nbsp;<input type=\"radio\" name=\"active\" value=\"0\">" . _NO . "<br><br>"
                        ."<input type=\"hidden\" name=\"spop\" value=\"NLBannersAdd\">"
                        ."<input type=\"submit\" value=\"" . _ADDBANNER . "\">"
                        ."</form>";
                        CloseTable();
                        echo "<br>";
                }
                /* Add Client */
                OpenTable();
                echo"<font class=\"option\"><b>" . _ADDCLIENT . "</b></center><br><br>
        <form action=\"".$admin_file.".php?op=add_sponsor\" method=\"post\">
        " . _CLIENTNAME . ": <input type=\"text\" name=\"name\" size=\"30\" maxlength=\"60\"><br><br>
        " . _CONTACTNAME . ": <input type=\"text\" name=\"contact\" size=\"30\" maxlength=\"60\"><br><br>
        " . _CONTACTEMAIL . ": <input type=\"text\" name=\"email\" size=\"30\" maxlength=\"60\"><br><br>
        " . _CLIENTLOGIN . ": <input type=\"text\" name=\"login\" size=\"12\" maxlength=\"10\"><br><br>
        " . _CLIENTPASSWD . ": <input type=\"text\" name=\"passwd\" size=\"12\" maxlength=\"10\"><br><br>
        " . _EXTRAINFO . ":<br><textarea name=\"extrainfo\" cols=\"70\" rows=\"15\"></textarea><br><br>
        <input type=\"hidden\" name=\"spop\" value=\"NLBannerAddClient\">
        <input type=\"submit\" value=\"" . _ADDCLIENT2 . "\">
        </form>";
                CloseTable();
                include ("footer.php");
        }

        function NLBannerStatus($bid, $status) {
                global $db, $prefix, $user_prefix, $db, $admin_file;
                if ($status == 1) {
                        $active = 0;
                } else {
                        $active = 1;
                }
                $bid = intval($bid);
                $db->sql_query("update nukelan_sponsors_banners set active='$active' WHERE bid='$bid'");

                include("header.php");
                lan_menu();
                OpenTable();
                Header("Refresh: 0;url=".$admin_file.".php?op=add_sponsor&spop=NLBannersAdmin");
                echo "<center><font class=\"title\"><b>" . _NLCLIENTADDED . "</b></font></center>";
                CloseTable();

        }

        function NLBannersAdd($name, $cid, $imptotal, $imageurl, $clickurl, $alttext, $type, $active) {
                global $db, $prefix, $user_prefix, $db, $admin_file;
                $alttext = ereg_replace("\"", "", $alttext);
                $alttext = ereg_replace("'", "", $alttext);
                $cid = intval($cid);
                $imptotal = intval($imptotal);
                $active = intval($active);
                $db->sql_query("insert into nukelan_sponsors_banners values (NULL, '$cid', '$imptotal', '1', '0', '$imageurl', '$clickurl', '$alttext', now(), '00-00-0000 00:00:00', '$type', '$active')");
                include("header.php");
                lan_menu();
                OpenTable();
                Header("Refresh: 0;url=".$admin_file.".php?op=add_sponsor&spop=NLBannersAdmin");
                echo "<center><font class=\"title\"><b>" . _NLBANNERADDED . "</b></font></center>";
                CloseTable();
        }

        function NLBannerAddClient($name, $contact, $email, $login, $passwd, $extrainfo) {
                global $db, $prefix, $user_prefix, $db, $admin_file;
                $db->sql_query("insert into nukelan_sponsors values (NULL, '$name', '$contact', '$email', '$login', '$passwd', '$extrainfo')");
                //Header("Refresh: 0;url=".$admin_file.".php?op=add_sponsor&spop=NLBannersAdmin");
        }

        function NLBannerDelete($bid, $ok=0) {
                global $db, $prefix, $user_prefix, $db, $admin_file;
                $bid = intval($bid);
                        include("header.php");
                        lan_menu();
                        OpenTable();
                if ($ok==1) {
                        $db->sql_query("delete from nukelan_sponsors_banners where bid='$bid'");
                        Header("Refresh: 0;url=".$admin_file.".php?op=add_sponsor&spop=NLBannersAdmin");
                } else {
                        echo "<center><font class=\"title\"><b>" . _NLBANNERSADMIN . "</b></font></center>";
                        CloseTable();
                        echo "<br>";
                        $row = $db->sql_fetchrow($db->sql_query("SELECT cid, imptotal, impmade, clicks, imageurl, clickurl from nukelan_sponsors_banners where bid='$bid'"));
                        $cid = intval($row['cid']);
                        $imptotal = intval($row['imptotal']);
                        $impmade = intval($row['impmade']);
                        $clicks = intval($row['clicks']);
                        $imageurl = $row['imageurl'];
                        $clickurl = $row['clickurl'];
                        OpenTable();
                        echo "<center><b>" . _DELETEBANNER . "</b></center><br><br>"
                        ."<a href=\"$clickurl\"><img src=\"$imageurl\" border=\"1\" alt=\"\"></a><br>"
                        ."<a href=\"$clickurl\">$clickurl</a><br><br>"
                        ."<table width=\"100%\" border=\"0\"><tr>"
                        ."<td bgcolor=\"$bgcolor2\" align=\"center\"><b>" . _ID . "<b></td>"
                        ."<td bgcolor=\"$bgcolor2\" align=\"center\"><b>" . _IMPRESSIONS . "<b></td>"
                        ."<td bgcolor=\"$bgcolor2\" align=\"center\"><b>" . _IMPLEFT . "<b></td>"
                        ."<td bgcolor=\"$bgcolor2\" align=\"center\"><b>" . _CLICKS . "<b></td>"
                        ."<td bgcolor=\"$bgcolor2\" align=\"center\"><b>" . _CLICKSPERCENT . "<b></td>"
                        ."<td bgcolor=\"$bgcolor2\" align=\"center\"><b>" . _CLIENTNAME . "<b></td><tr>";
                        $row2 = $db->sql_fetchrow($db->sql_query("SELECT id, sponsor_name from nukelan_sponsors where id='$cid'"));
                        $cid = intval($row2['id']);
                        $name = $row2['sponsor_name'];
                        $percent = substr(100 * $clicks / $impmade, 0, 5);
                        if($imptotal==0) {
                                $left = _UNLIMITED;
                        } else {
                                $left = $imptotal-$impmade;
                        }
                        echo "<td bgcolor=\"$bgcolor2\" align=\"center\">$bid</td>"
                        ."<td bgcolor=\"$bgcolor2\" align=\"center\">$impmade</td>"
                        ."<td bgcolor=\"$bgcolor2\" align=\"center\">$left</td>"
                        ."<td bgcolor=\"$bgcolor2\" align=\"center\">$clicks</td>"
                        ."<td bgcolor=\"$bgcolor2\" align=\"center\">$percent%</td>"
                        ."<td bgcolor=\"$bgcolor2\" align=\"center\">$name</td><tr>";
                echo "</td></tr></table><br>";
                         echo "<center>" . _SURETODELBANNER . "<br><br>"
                ."[ <a href=\"".$admin_file.".php?op=add_sponsor&spop=NLBannersAdmin\">" . _NO . "</a> | <a href=\"".$admin_file.".php?op=add_sponsor&spop=NLBannerDelete&amp;bid=$bid&amp;ok=1\">" . _YES . "</a> ]</center><br><br>";
                }
                  echo "<center><font class=\"title\"><b>" . _NLBANNERDEL . "</b></font></center>";

                CloseTable();
                include("footer.php");
        }

        function NLBannerEdit($bid) {
                global $db, $prefix, $user_prefix, $db, $admin_file;
                include("header.php");
                lan_menu();
                OpenTable();
                echo "<center><font class=\"title\"><b>" . _NLBANNERSADMIN . "</b></font></center>";
                CloseTable();
                echo "<br>";
                $bid = intval($bid);
                $row = $db->sql_fetchrow($db->sql_query("SELECT cid, imptotal, impmade, clicks, imageurl, clickurl, alttext, type, active from nukelan_sponsors_banners where bid='$bid'"));
                $cid = intval($row['cid']);
                $imptotal = intval($row['imptotal']);
                $impmade = intval($row['impmade']);
                $clicks = intval($row['clicks']);
                $imageurl = $row['imageurl'];
                $clickurl = $row['clickurl'];
                $alttext = $row['alttext'];
                $type = $row['type'];
                $active = intval($row['active']);
                OpenTable();
                echo"<center><b>" . _EDITBANNER . "</b><br><br>"
                ."<img src=\"$imageurl\" border=\"1\" alt=\"\"></center><br><br>"
                ."<form action=\"".$admin_file.".php?op=add_sponsor&spop=NLBannerChange\" method=\"post\">"
                ."" . _CLIENTNAME . ": "
                ."<select name=\"cid\">";
                $row2 = $db->sql_fetchrow($db->sql_query("SELECT id, sponsor_name from nukelan_sponsors where id='$cid'"));
                $cid = intval($row2['id']);
                $name = $row2['sponsor_name'];
                echo "<option value=\"$cid\" selected>$name</option>";
                $result3 = $db->sql_query("SELECT id, sponsor_name from nukelan_sponsors");
                while ($row3 = $db->sql_fetchrow($result3)) {
                        $ccid = intval($row3['id']);
                        $name = $row3['sponsor_name'];
                        if($cid!=$ccid) {
                                echo "<option value=\"$ccid\">$name</option>";
                        }
                }
                echo "</select><br><br>";
                if($imptotal==0) {
                        $impressions = _UNLIMITED;
                } else {
                        $impressions = $imptotal;
                }
                if ($type == 0) {
                        $sel1 = "selected";
                        $sel2 = "";
                } else {
                        $sel1 = "";
                        $sel2 = "selected";
                }
                if ($active == 1) {
                        $check1 = "checked";
                        $check2 = "";
                } else {
                        $check1 = "";
                        $check2 = "checked";
                }
                echo "" . _ADDIMPRESSIONS . ": <input type=\"text\" name=\"impadded\" size=\"12\" maxlength=\"11\"> " . _PURCHASED . ": <b>$impressions</b> " . _MADE . ": <b>$impmade</b><br><br>"
                ."" . _IMAGEURL . ": <input type=\"text\" name=\"imageurl\" size=\"50\" maxlength=\"100\" value=\"$imageurl\"><br><br>"
                ."" . _CLICKURL . ": <input type=\"text\" name=\"clickurl\" size=\"50\" maxlength=\"200\" value=\"$clickurl\"><br><br>"
                ."" . _ALTTEXT . ": <input type=\"text\" name=\"alttext\" size=\"50\" maxlength=\"255\" value=\"$alttext\"><br><br>"
                ."" . _TYPE . ": <select name=\"type\">"
                ."<option name=\"type\" value=\"0\" $sel1>" . _NORMAL . "</option>"
                ."<option name=\"type\" value=\"1\" $sel2>" . _BLOCK . "</option>"
                ."</select><br><br>"
                ."" . _ACTIVATE . ": <input type=\"radio\" name=\"active\" value=\"1\" $check1>" . _YES . "&nbsp;&nbsp;<input type=\"radio\" name=\"active\" value=\"0\" $check2>" . _NO . "<br><br>"
                ."<input type=\"hidden\" name=\"bid\" value=\"$bid\">"
                ."<input type=\"hidden\" name=\"imptotal\" value=\"$imptotal\">"
                //."<input type=\"hidden\" name=\"spop\" value=\"NLBannerChange\">"
                ."<input type=\"submit\" value=\"" . _SAVECHANGES . "\">"
                ."</form>";
                CloseTable();
                include("footer.php");
        }

        function NLBannerChange($bid, $cid, $imptotal, $impadded, $imageurl, $clickurl, $alttext, $type, $active) {
                global $db, $prefix, $user_prefix, $db, $admin_file;
                $imp = $imptotal+$impadded;
                $alttext = ereg_replace("\"", "", $alttext);
                $alttext = ereg_replace("'", "", $alttext);
                $cid = intval($cid);
                $imp = intval($imp);
                $active = intval($active);
                $bid = intval($bid);
                include("header.php");
                lan_menu();
                OpenTable();
                echo "<center><font class=\"title\"><b>" . _NLBANNECHANGE . "</b></font></center>";
                Header("Refresh: 0;url=".$admin_file.".php?op=add_sponsor&spop=NLBannersAdmin");
                CloseTable();
                $db->sql_query("update nukelan_sponsors_banners set cid='$cid', imptotal='$imp', imageurl='$imageurl', clickurl='$clickurl', alttext='$alttext', type='$type', active='$active' where bid='$bid'");
                CloseTable();
                include("footer.php");

        }

        function NLBannerClientDelete($cid, $ok=0) {
                global $db, $prefix, $user_prefix, $db, $admin_file;
                $cid = intval($cid);
                $cid2=$cid;
                        include("header.php");
                        lan_menu();
                if ($ok==1) {
                $db->sql_query("delete from nukelan_sponsors_banners where cid='$cid'");
                        $db->sql_query("delete from nukelan_sponsors where id='$cid'");

                        Header("Refresh: 0;url=".$admin_file.".php?op=add_sponsor&spop=NLBannersAdmin");
                } else {

                        //GraphicAdmin();
                        echo "<br>";
                        $row = $db->sql_fetchrow($db->sql_query("SELECT id, name from nukelan_sponsors where id='$cid'"));
                        $cid = intval($row['id']);
                        $name = $row['sponsor_name'];
                        OpenTable();
                        echo "<center><b>" . _DELETECLIENT . ": $name</b><br><br>
                        " . _SURETODELCLIENT . "<br><br>";
                        $result2 = $db->sql_query("SELECT imageurl, clickurl from nukelan_sponsors_banners where cid='$cid'");
                        $numrows = $db->sql_numrows($result2);
                        if($numrows==0) {
                                echo "" . _CLIENTWITHOUTBANNERS . "<br><br>";
                        } else {
                                echo "<b>" . _WARNING . "!!!</b><br>
                        " . _DELCLIENTHASBANNERS . ":<br><br>";
                        }
                        while ($row2 = $db->sql_fetchrow($result2)) {
                                $imageurl = $row2['imageurl'];
                                $clickurl = $row2['clickurl'];
                                echo "<a href=\"$clickurl\"><img src=\"$imageurl\" border=\"1\" alt=\"\"></a><br>
                                <a href=\"$clickurl\">$clickurl</a><br><br>";
                        }
                                                echo"$cid";
                        echo "" . _SURETODELCLIENT . "<br><br>
        [ <a href=\"".$admin_file.".php?op=add_sponsor&spop=NLBannersAdmin\">" . _NO . "</a> | <a href=\"".$admin_file.".php?op=add_sponsor&spop=NLBannerClientDelete&amp;cid=$cid2&amp;ok=1\">" . _YES . "</a> ]</center><br><br></center>";

                }
                     CloseTable();
                include("footer.php");

        }

        function NLBannerClientEdit($cid) {
                global $db, $prefix, $user_prefix, $db, $admin_file;
                include("header.php");
                lan_menu();
                OpenTable();
                echo "<center><font class=\"title\"><b>" . _NLBANNERSADMIN . "</b></font></center>";
                CloseTable();
                echo "<br>";
                $cid = intval($cid);
                $row = $db->sql_fetchrow($db->sql_query("SELECT sponsor_name, contact, email, login, passwd, moreinfo from nukelan_sponsors where id='$cid'"));
                $name = $row['sponsor_name'];
                $contact = $row['contact'];
                $email = $row['email'];
                $login = $row['login'];
                $passwd = $row['passwd'];
                $extrainfo = $row['moreinfo'];
                OpenTable();
                echo "<center><font class=\"option\"><b>" . _EDITCLIENT . "</b></font></center><br><br>"
                ."<form action=\"".$admin_file.".php?op=add_sponsor\" method=\"post\">"
                ."" . _CLIENTNAME . ": <input type=\"text\" name=\"name\" value=\"$name\" size=\"30\" maxlength=\"60\"><br><br>"
                ."" . _CONTACTNAME . ": <input type=\"text\" name=\"contact\" value=\"$contact\" size=\"30\" maxlength=\"60\"><br><br>"
                ."" . _CONTACTEMAIL . ": <input type=\"text\" name=\"email\" size=30 maxlength=\"60\" value=\"$email\"><br><br>"
                ."" . _CLIENTLOGIN . ": <input type=\"text\" name=\"login\" size=12 maxlength=\"10\" value=\"$login\"><br><br>"
                ."" . _CLIENTPASSWD . ": <input type=\"text\" name=\"passwd\" size=12 maxlength=\"10\" value=\"$passwd\"><br><br>"
                ."" . _EXTRAINFO . "<br><textarea name=\"extrainfo\" cols=\"70\" rows=\"15\">$extrainfo</textarea><br><br>"
                ."<input type=\"hidden\" name=\"cid\" value=\"$cid\">"
                ."<input type=\"hidden\" name=\"spop\" value=\"NLBannerClientChange\">"
                ."<input type=\"submit\" value=\"" . _SAVECHANGES . "\">"
                ."</form><br><br>";
// lan party list
        echo "<center><font class=\"option\"><b>" . _EDITCLIENT2 . "</b></font></center><br><br>"
                ."<form action=\"".$admin_file.".php?op=add_sponsor&spop=NLBannerClientChangeParty\" method=\"post\">"
               // ."<input type=\"hidden\" name=\"spop\" value=\"NLBannerClientChangeParty\">"
                ."<input type=\"hidden\" name=\"cid\" value=\"$cid\">";
        echo "<table width=\"200\" border=\"0\" cellpadding=\"3\" cellspacing=\"0\">";
        $lan_result = $db->sql_query("SELECT keyword, party_id FROM nukelan_parties ORDER BY keyword");
        while ($lan = $db->sql_fetchrow($lan_result)) {
        $lan_num = $db->sql_numrows($lan_result);
                if ($lan_num >=1) {
                        $is_sponsor = $db->sql_numrows($db->sql_query("SELECT * FROM nukelan_sponsors_parties WHERE party_id='$lan[party_id]' AND sponsor_id='$cid'"));
                        $sponsor_status = "<font color=red><b>"._NLNOTSPONSOR."</b></font>";
                        if ($is_sponsor) {
                                $sponsor_status = "<font color=green><b>"._NLISSPONSOR."</b></font>";
                        }
                        echo "<tr><td><b>$lan[keyword]</b></td><td>::</td>";
                        echo "<td><input type=checkbox name=partyid[] value=\"$lan[party_id]\"></td>";
                        echo "<td>$sponsor_status</td></tr>";
                        echo "</table>";
                        echo "<input type=\"submit\" value=\"" . _SAVECHANGES . "\">"
                        ."</form>";
                } else {
                        echo "<tr><td>"._NLNOLANSTOSPONSOR."</td></tr>";
                        echo "</table>";
                }
        }

                CloseTable();
                include("footer.php");
        }

        function NLBannerClientChange($cid, $name, $contact, $email, $extrainfo, $login, $passwd) {
                global $db, $prefix, $user_prefix, $db, $admin_file;
                $cid = intval($cid);
                $db->sql_query("update nukelan_sponsors set sponsor_name='$name', contact='$contact', email='$email', login='$login', passwd='$passwd', moreinfo='$extrainfo' where id='$cid'");
                include("header.php");
                lan_menu();
                OpenTable();
                                        echo "<center><font class=\"title\"><b>" . _NLCLIENTCHANGE . "</b></font></center>";
                Header("Refresh: 0;url=".$admin_file.".php?op=add_sponsor&spop=NLBannersAdmin");
                CloseTable();
                include("footer.php");
        }
        function NLBannerClientChangeParty($cid, $partyid) {
                global $db, $prefix, $user_prefix, $db, $admin_file;
                $cid = intval($cid);
               // echo"$partyid wahaha";
                foreach ($partyid as $pid) {
                        $status = $db->sql_numrows($db->sql_query("SELECT * FROM nukelan_sponsors_parties WHERE party_id='$pid' AND sponsor_id='$cid'"));
                        if ($status) {
                        $db->sql_query("DELETE FROM nukelan_sponsors_parties WHERE party_id='$pid' AND sponsor_id='$cid'");
                        } else {
                        $db->sql_query("INSERT INTO nukelan_sponsors_parties SET party_id='$pid', sponsor_id='$cid'");
                        }
                }
                include("header.php");
                lan_menu();
                OpenTable();
                Header("Refresh: 0;url=".$admin_file.".php?op=add_sponsor");
                echo "<center><font class=\"title\"><b>" . _NLCLIENTBANCHANGE . "</b></font></center>";
                CloseTable();
        }

        switch($spop) {

                case "NLBannersAdmin":
                NLBannersAdmin();
                break;

                case "NLBannersAdd":
                NLBannersAdd($name, $cid, $imptotal, $imageurl, $clickurl, $alttext, $type, $active);
                break;

                case "NLBannerAddClient":
                NLBannerAddClient($name, $contact, $email, $login, $passwd, $extrainfo);
                break;

                case "NLBannerDelete":
                NLBannerDelete($bid, $ok);
                break;

                case "NLBannerEdit":
                NLBannerEdit($bid);
                break;

                case "NLBannerChange":
                NLBannerChange($bid, $cid, $imptotal, $impadded, $imageurl, $clickurl, $alttext, $type, $active);
                break;

                case "NLBannerClientDelete":
                NLBannerClientDelete($cid, $ok);
                break;

                case "NLBannerClientEdit":
                NLBannerClientEdit($cid);
                break;

                case "NLBannerClientChange":
                NLBannerClientChange($cid, $name, $contact, $email, $extrainfo, $login, $passwd);
                break;
                
                case "NLBannerClientChangeParty":
                NLBannerClientChangeParty($cid, $partyid);
                break;

                case "NLBannerStatus":
                NLBannerStatus($bid, $status);
                break;
                
                default:
                NLBannersAdmin();
                break;

        }

?>
