 <?php
// ==========================================
// PHP-NUKE: Shout Box
// ==========================
//
// Copyright (c) 2003-2005 by Aric Bolf (SuperCat)
// http://www.OurScripts.net
//
// This program is free software. You can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation
// ===========================================

if ( !defined('ADMIN_FILE') )
{
        die ("Access Denied");
}
global $prefix, $db, $admin_file;

$aid = substr("$aid", 0,25);
$row = $db->sql_fetchrow($db->sql_query("SELECT title, admins FROM ".$prefix."_modules WHERE title='Shout_Box'"));
$row2 = $db->sql_fetchrow($db->sql_query("SELECT name, radminsuper FROM ".$prefix."_authors WHERE aid='$aid'"));
$admins = explode(",", $row['admins']);
$auth_user = 0;
for ($i=0; $i < sizeof($admins); $i++) {
    if ($row2['name'] == "$admins[$i]" AND $row['admins'] != "") {
        $auth_user = 1;
    }
}

function LinkAdmin() {
        Global $admin_file;
        if ($admin_file == '') { $admin_file = 'admin'; }
        OpenTable();
        echo "<center><a href=\"".$admin_file.".php\"><span class=\"title\">Administration Menu</span></a></center>";
        CloseTable();
        echo "<br />";
}

if ($row2['radminsuper'] == 1 || $auth_user == 1) {

include("config.php");

global $currentlang, $sbURL;

if ($currentlang) {
        include_once("modules/Shout_Box/lang-admin/lang-$currentlang.php");
} else {
        include_once("modules/Shout_Box/lang-admin/lang-english.php");
}

$sqlV = "select * from ".$prefix."_config";
$resultV = $db->sql_query($sqlV);
$confV = $db->sql_fetchrow($resultV);
if ($confV['Version_Num'] >= '7.6') {
        $sbURL = 'index.php?url=';
} else {
        $sbURL = '';
}

// Start 'Menu' code

function ShoutBoxAdminMenu($ShoutMenuOptionActive) {
        global $prefix, $db, $admin_file;
        OpenTable();
        echo "<br /><div align=\"center\" class=\"title\">"._SHOUTADMIN."</div><br />";
        $ThemeSel = get_theme();
        $sql = "select * from ".$prefix."_shoutbox_themes WHERE themeName='$ThemeSel'";
        $result = $db->sql_query($sql);
        $rowColor = $db->sql_fetchrow($result);

        echo "<center><table align=\"center\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"background-color: $rowColor[border];\" nowrap=\"nowrap\">";
        echo "<table align=\"center\" cellpadding=\"0\" cellspacing=\"1\" border=\"0\"><tr><td style=\"background-color: $rowColor[menuColor2];\" nowrap=\"nowrap\">";
        echo "<table align=\"center\" cellpadding=\"1\" cellspacing=\"2\" border=\"0\"><tr style=\"cursor: hand; text-align: center;\">";

        echo "<td style=\"background-color: $rowColor[border];\"><table cellpadding=\"6\" cellspacing=\"0\" border=\"0\"><tr>";
        if ($ShoutMenuOptionActive == 1) {
                echo "<td style=\"background-color: $rowColor[menuColor1]; line-height: .8em;\" onclick=\"top.location.href='".$admin_file.".php?op=shoutmodule&amp;Submit=manageShouts'\" nowrap=\"nowrap\">";
        } else {
                echo "<td style=\"background-color: $rowColor[menuColor2]; line-height: .8em;\" onclick=\"top.location.href='".$admin_file.".php?op=shoutmodule&amp;Submit=manageShouts'\" onmouseover=\"this.style.backgroundColor='$rowColor[menuColor1]';\" onmouseout=\"this.style.backgroundColor='$rowColor[menuColor2]';\" nowrap=\"nowrap\">";
        }
        echo "<b>"._MANAGESHOUTS."</b></td></tr></table></td>";

        echo "<td style=\"background-color: $rowColor[border];\"><table cellpadding=\"6\" cellspacing=\"0\" border=\"0\"><tr>";
        if ($ShoutMenuOptionActive == 7) {
                echo "<td style=\"background-color: $rowColor[menuColor1]; line-height: .8em;\" onclick=\"top.location.href='".$admin_file.".php?op=shoutmodule&amp;Submit=ShoutBoxBans'\" nowrap=\"nowrap\">";
        } else {
                echo "<td style=\"background-color: $rowColor[menuColor2]; line-height: .8em;\" onclick=\"top.location.href='".$admin_file.".php?op=shoutmodule&amp;Submit=ShoutBoxBans'\" onmouseover=\"this.style.backgroundColor='$rowColor[menuColor1]';\" onmouseout=\"this.style.backgroundColor='$rowColor[menuColor2]';\" nowrap=\"nowrap\">";
        }
        echo "<b>"._SB_BANS."</b></td></tr></table></td>";

        echo "</tr></table>\n";
        echo "</td></tr></table></td></tr></table></center>";

        CloseTable();
        echo "<br />";
}

// End 'Menu' code

// Start 'Manage Shouts' code (Default page)

function manageShouts($page) {
        global $prefix, $db, $admin, $admin_file, $sbURL, $user, $cookie;
        include ("header.php");
        LinkAdmin();
        $ShoutMenuOptionActive = 1;
        ShoutBoxAdminMenu($ShoutMenuOptionActive);
        OpenTable();
        $ThemeSel = get_theme();
        $sql = "select * from ".$prefix."_shoutbox_themes WHERE themeName='$ThemeSel'";
        $result = $db->sql_query($sql);
        $rowColor = $db->sql_fetchrow($result);

        $sql = "select * from ".$prefix."_shoutbox_conf";
        $result = $db->sql_query($sql);
        $conf = $db->sql_fetchrow($result);

        $sql = "select aCount from ".$prefix."_shoutbox_manage_count WHERE admin='$admin[0]'";
        $resultA = $db->sql_query($sql);
        $aCount = $db->sql_fetchrow($resultA);
        if ($aCount['aCount'] == '') {
                $sql = "INSERT INTO ".$prefix."_shoutbox_manage_count (admin, aCount) VALUES ('$admin[0]','10')";
                $db->sql_query($sql);
                $aCount['aCount'] = 10;
        }

        if (is_user($user)) {
                $username = $cookie[1];
                if ($username != '') {
                        $sqlF = "SELECT user_timezone, user_dateformat from ".$prefix."_users WHERE username='$username'";
                        $resultF = $db->sql_query($sqlF);
                        $userSetup = $db->sql_fetchrow($resultF);
                }
        }
        $sql = "select * from ".$prefix."_shoutbox_date";
        $resultD = $db->sql_query($sql);
        $rowD = $db->sql_fetchrow($resultD);

        echo "<form name=\"manageShouts1\" action=\"\" method=\"post\" style=\"margin-bottom: 0px;\"><div class=\"content\">";
        echo "<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"100%\"><tr><td style=\"background-color: $rowColor[border];\">";
        echo "<table cellpadding=\"3\" cellspacing=\"1\" border=\"0\" width=\"100%\"><tr style=\"background-color: $rowColor[menuColor1];\" align=\"center\">";
        echo "<td width=\"10%\"><b>"._SB_NICKNAME."</b></td>";
        echo "<td><span class=\"content\"><b>"._SB_SHOUT."</b></span></td>";
        echo "<td width=\"16%\"><b>"._SB_DATE." &amp; "._SB_TIME."</b></td>";
        echo "<td width=\"5%\"><b>"._DELETE."</b></td>";
        echo "<td width=\"5%\"><b>"._EDIT."</b></td>";
        echo "<td width=\"5%\"><b>"._BAN."</b></td>";
        echo "</tr>";

        $sql = "select id from ".$prefix."_shoutbox_shouts";
        $result = $db->sql_query($sql);
        $numrows = $db->sql_numrows($result);

        $numrows2 = $numrows;
        $shout_pages = 1;
        $shoutsViewed = $aCount['aCount'];
        while ($numrows >= $shoutsViewed) {
                $shout_pages++;
                $numrows = ($numrows - $shoutsViewed);
        }
        if ($shout_pages == 0) { $shout_pages = 1; }
        if (!$page) { $page = 1; }
        if ($page < 1) { $page = 1; }
        if ($page > $shout_pages) { $page = $shout_pages; }
        if ($page > 1) {
                $offset = ($page * $shoutsViewed);
                $offset1 = ($offset - $shoutsViewed);
        } else { $offset1 = 0; }

        $shgroup1 = ($page*$aCount['aCount']);
        $shgroup1 = ($shgroup1-$aCount['aCount']);
        $shgroup1 = ($shgroup1+1);
        if ($shgroup1 < 1) { $shgroup1 = 1; }
        $shgroup2 = ($shgroup1-1);

        $sql = "select * from ".$prefix."_shoutbox_shouts order by id DESC LIMIT ".$offset1.",$aCount[aCount]";
        $nameresult = $db->sql_query($sql);
        $x = 1;
        while ($shout = $db->sql_fetchrow($nameresult)) {
                $comment = str_replace('src=', 'src="', $shout['comment']);
                $comment = str_replace('.gif>', '.gif" alt="" />', $comment);
                $comment = str_replace('.jpg>', '.jpg" alt="" />', $comment);
                $comment = str_replace('.png>', '.png" alt="" />', $comment);
                $comment = str_replace('.bmp>', '.bmp" alt="" />', $comment);
                $comment = str_replace("http:", "".$sbURL."http:", $comment);
                $comment = str_replace("ftp:", "".$sbURL."ftp:", $comment);

                // BB code [b]word[/b] [i]word[/i] [u]word[/u]
                if ((eregi("[b]", $comment)) AND (eregi("[/b]", $comment)) AND (substr_count("$comment","[b]") == substr_count("$comment","[/b]"))) {
                        $comment = eregi_replace("\[b\]","<span style=\"font-weight: bold\">","$comment");
                        $comment = eregi_replace("\[\/b\]","</span>","$comment");
                }
                if ((eregi("[i]", $comment)) AND (eregi("[/i]", $comment)) AND (substr_count("$comment","[i]") == substr_count("$comment","[/i]"))) {
                        $comment = eregi_replace("\[i\]","<span style=\"font-style: italic\">","$comment");
                        $comment = eregi_replace("\[\/i\]","</span>","$comment");
                }
                if ((eregi("[u]", $comment)) AND (eregi("[/u]", $comment)) AND (substr_count("$comment","[u]") == substr_count("$comment","[/u]"))) {
                        $comment = eregi_replace("\[u\]","<span style=\"text-decoration: underline\">","$comment");
                        $comment = eregi_replace("\[\/u\]","</span>","$comment");
                }

                // check to see if nickname is a user in the DB
                $sql = "select * from ".$prefix."_users where username='$shout[name]'";
                $nameresult2 = $db->sql_query($sql);
                $row = $db->sql_fetchrow($nameresult2);
                if (($row) AND ($shout['name'] != "Anonymous") AND ($row['username'] != "Anonymous")) {
                        echo "<tr style=\"background-color: $rowColor[menuColor2];\" onmouseover=\"this.style.backgroundColor='$rowColor[menuColor1]';\" onmouseout=\"this.style.backgroundColor='$rowColor[menuColor2]';\"><td nowrap=\"nowrap\"><a href=\"modules.php?name=Your_Account&amp;op=userinfo&amp;username=$shout[name]\">$shout[name]</a></td><td>$comment</td>";
                } else {
                        echo "<tr style=\"background-color: $rowColor[menuColor2];\" onmouseover=\"this.style.backgroundColor='$rowColor[menuColor1]';\" onmouseout=\"this.style.backgroundColor='$rowColor[menuColor2]';\"><td nowrap=\"nowrap\">$shout[name]</td><td>$comment</td>";
                }

                echo "<td nowrap=\"nowrap\">";
                if ($shout['timestamp'] != '') {
                        // reads unix timestamp and formats it to the viewer's timezone
                        if (is_user($user)) {
                                // time adjustment for following user's timezone
                                $displayTime = $userSetup['user_timezone'] - $conf['serverTimezone'];
                                $displayTime = $displayTime * 3600;
                                $newTimestamp = $shout['timestamp'] + $displayTime;
                                $unixTime = date("$userSetup[user_dateformat]", $newTimestamp);
                                echo "$unixTime";
                        } else {
                                // adjustmet for timezone offset
                                $displayTime = $conf['timeOffset'] * 3600;
                                $newTimestamp = $shout['timestamp'] + $displayTime;
                                $unixDay = date("$rowD[date]", $newTimestamp);
                                $unixTime = date("$rowD[time]", $newTimestamp);
                                echo "$unixDay&nbsp;$unixTime";
                        }
                } else {
                        echo "$shout[date]&nbsp;$shout[time]";
                }
                echo "</td>";

                echo "<td align=\"center\"><input type=\"hidden\" name=\"sr$x\" value=\"$shout[id]\" /><input type=\"checkbox\" name=\"shr$x\" /></td><td align=\"center\"><a title=\"Edit\" href=\"".$admin_file.".php?op=shoutmodule&amp;Submit=ShoutEdit&amp;shoutID=$shout[id]&amp;page=$page\">"._EDIT."</a></td>";

                if ($shout['ip'] != 'noip') {
                        $sql = "select * from ".$prefix."_shoutbox_ipblock where name='$shout[ip]' ";
                        $nameIPresult = $db->sql_query($sql);
                        $nameIProw = $db->sql_fetchrow($nameIPresult);
                        if ($nameIProw) {
                                echo "<td><b>"._SB_BANNED."</b></td></tr>";
                        } else {
                                echo "<td align=\"center\"><a title=\""._BAN."\" href=\"".$admin_file.".php?op=shoutmodule&amp;Submit=ban&amp;bid=$shout[id]&amp;page=$page\">"._BAN."</a></td></tr>";
                        }
                } else {
                        echo "<td>&nbsp;</td></tr>";
                }
                $x++;
                $shgroup2++;
        }
        echo "</table></td></tr></table><br />";

        echo "<table cellpadding=\"3\" cellspacing=\"0\" border=\"0\" width=\"100%\"><tr>";
        echo "<td><select onchange=\"top.location.href=this.options[this.selectedIndex].value\" name=\"adminDropCount2\">";
        if ($aCount['aCount'] == '10') { $SEL1 = " selected=\"selected\""; } else { $SEL1 = ""; }
        if ($aCount['aCount'] == '15') { $SEL2 = " selected=\"selected\""; } else { $SEL2 = ""; }
        if ($aCount['aCount'] == '20') { $SEL3 = " selected=\"selected\""; } else { $SEL3 = ""; }
        if ($aCount['aCount'] == '25') { $SEL4 = " selected=\"selected\""; } else { $SEL4 = ""; }
        echo "<option value=\"".$admin_file.".php?op=shoutmodule&amp;Submit=adminDropCount&amp;aCount=10&amp;page=$page\"$SEL1>10</option><option value=\"".$admin_file.".php?op=shoutmodule&amp;Submit=adminDropCount&amp;aCount=15&amp;page=$page\"$SEL2>15</option><option value=\"".$admin_file.".php?op=shoutmodule&amp;Submit=adminDropCount&amp;aCount=20&amp;page=$page\"$SEL3>20</option><option value=\"".$admin_file.".php?op=shoutmodule&amp;Submit=adminDropCount&amp;aCount=25&amp;page=$page\"$SEL4>25</option></select></td>";

        echo "<td width=\"9%\" nowrap=\"nowrap\">"._VIEWINGSHOUTS.": $shgroup1 - $shgroup2<br />"._TOTALSHOUTS.": $numrows2</td>";

        echo "<td width=\"90%\" align=\"center\" nowrap=\"nowrap\">";
        $num1 = ($page-4);
        if ($num1 < 1) { $num1 = 1; }
        $num2 = ($num1+8);
        if ($num2 > $shout_pages) { $num2 = $shout_pages; }
        $num5 = ($num2-8);
        if ($num5 < $num1) {
                $num1 = $num5;
                if ($num1 < 1) { $num1 = 1; }
        }
        $num3 = ($page-1);
        $num4 = ($page+1);
        $menuLinks = "";

        $count = $num1;
        while ($count <= $shout_pages AND $count <= $num2) {
                if ($count == $page) {
                        $menuLinks .= "<b>$count</b>";
                } else {
                        $menuLinks .= "<a href=\"".$admin_file.".php?op=shoutmodule&Submit=manageShouts&amp;page=$count\">$count</a>";
                }
                if ($count < $num2) { $menuLinks .= "&nbsp;&nbsp;"; }
                $count++;
        }

        $menuLinks .= "<br /><br />";
        if ($page > 1) {
                $menuLinks .= "<a href=\"".$admin_file.".php?op=shoutmodule&Submit=manageShouts&amp;page=$num3\">"._PREVIOUS."</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\n";
        }
        if ($page != $shout_pages) {
                $menuLinks .= ""._PAGE." $page / <a href=\"".$admin_file.".php?op=shoutmodule&Submit=manageShouts&amp;page=$shout_pages\">$shout_pages</a>\n";
        } else {
                $menuLinks .= ""._PAGE." $page / $shout_pages\n";
        }
        if ($page < $shout_pages) {
                $menuLinks .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"".$admin_file.".php?op=shoutmodule&Submit=manageShouts&amp;page=$num4\">"._NEXT."</a>\n";
        }
        echo "$menuLinks";
        echo "</td>";

        echo "<td width=\"10%\" nowrap=\"nowrap\" align=\"right\">";
        echo "<input type=\"hidden\" name=\"listnum\" value=\"$aCount[aCount]\" /><input type=\"hidden\" name=\"Submit\" value=\"shremove\" /><input type=\"hidden\" name=\"page\" value=\"$page\" /><input type=\"submit\" name=\"button\" value=\""._REMOVECHECKEDSHOUTS."\" /></td>";
        echo "</tr></table></div></form>";
        CloseTable();
        echo "<br />";
        OpenTable();
        $sql = "select * from ".$prefix."_shoutbox_sticky where stickySlot=0";
        $stickyResult = $db->sql_query($sql);
        $stickyRow0 = $db->sql_fetchrow($stickyResult);
        $sql = "select * from ".$prefix."_shoutbox_sticky where stickySlot=1";
        $stickyResult = $db->sql_query($sql);
        $stickyRow1 = $db->sql_fetchrow($stickyResult);

        echo "<br /><div align=\"center\" class=\"title\">"._SB_STICKYSHOUTS."</div><br />";
        echo "<center><table align=\"center\" cellpadding=\"5\" cellspacing=\"0\" border=\"0\"><tr><td>$stickyRow0[name] </td><td nowrap=\"nowrap\"><form name=\"shoutAdmin20\" action=\"\" method=\"post\" style=\"margin-bottom: 0px;\"><input type=\"hidden\" name=\"page\" value=\"$page\" /><input type=\"text\" name=\"stickyShout\" value=\"$stickyRow0[comment]\" maxlength=\"150\" size=\"75\" />&nbsp;&nbsp;<input type=\"hidden\" name=\"stickyUsername\" value=\"$admin[0]\" /><input type=\"hidden\" name=\"Submit\" value=\"stickySubmit\" /><input type=\"hidden\" name=\"stickySlot\" value=\"0\" /><input type=\"submit\" name=\"button\" value=\""._SB_SUBMIT."\" /></form></td></tr><tr><td>$stickyRow1[name] </td><td nowrap=\"nowrap\"><form name=\"shoutAdmin21\" action=\"\" method=\"post\" style=\"margin-bottom: 0px;\"><input type=\"hidden\" name=\"page\" value=\"$page\" /><input type=\"text\" name=\"stickyShout\" value=\"$stickyRow1[comment]\" maxlength=\"150\" size=\"75\" />&nbsp;&nbsp;<input type=\"hidden\" name=\"stickyUsername\" value=\"$admin[0]\" /><input type=\"hidden\" name=\"Submit\" value=\"stickySubmit\" /><input type=\"hidden\" name=\"stickySlot\" value=\"1\" /><input type=\"submit\" name=\"button\" value=\""._SB_SUBMIT."\" /></form></td></tr></table></center>";
        CloseTable();
        // YOU MAY NOT REMOVE, EDIT, OR MARK OUT THE FOLLOWING PAYPAL CODE. IT IS PART OF OUR COPYRIGHT.
        echo "<br />";
        OpenTable();
        echo "<p align=\"center\" class=\"title\">OurScripts.net needs your support!</p>";
        echo "<p align=\"center\" class=\"content\">Open Source software costs money and time to develop.</p>";
        echo "<form action=\"https://www.paypal.com/cgi-bin/webscr\" method=\"post\">
        <input type=\"hidden\" name=\"cmd\" value=\"_xclick\" />
        <input type=\"hidden\" name=\"business\" value=\"donate@ourscripts.net\" />
        <input type=\"hidden\" name=\"item_name\" value=\"Donation to OurScripts.net\" />
        <input type=\"hidden\" name=\"no_shipping\" value=\"1\" />
        <input type=\"hidden\" name=\"cn\" value=\"Comments\" /><p align=\"center\">
        <input type=\"image\" src=\"modules/Shout_Box/images/paypal.gif\" name=\"submit\" title=\"Please donate. Thank you!\" /></p></form><p align=\"center\" class=\"content\">Our community appreciates your monitary support!</p><p align=\"center\" class=\"content\">Released under the <a target=\"_blank\" href=\"".$sbURL."http://www.gnu.org\">GNU/GPL license</a> and distributed by <a target=\"_blank\" href=\"".$sbURL."http://www.ourscripts.net\">OurScripts.net</a>.<br />Copyright &copy; 2002-2004 by SuiteSoft Solutions. All rights reserved.</p>";
        CloseTable();
        // END OF COPYRIGHT.
        include("footer.php");
        exit;
}

function stickySubmit($stickyShout, $stickyUsername, $stickySlot, $page) {
        global $prefix, $db, $admin_file;
        if ($stickyShout) {
                $sql = "select * from ".$prefix."_shoutbox_conf";
                $result = $db->sql_query($sql);
                $conf = $db->sql_fetchrow($result);

                $sql = "select * from ".$prefix."_shoutbox_date";
                $resultD = $db->sql_query($sql);
                $rowD = $db->sql_fetchrow($resultD);

                if ($conf['timeOffset'] == 0) {
                        $timestamp = time();
                } elseif (strstr($conf['timeOffset'], '+')) {
                        $sbTimeMultiplier = str_replace('+', '', $conf['timeOffset']);
                        $sbTimeOffset = $sbTimeMultiplier * 3600;
                        $sbTimeTemp = time();
                        $timestamp = ($sbTimeTemp + $sbTimeOffset);
                } else {
                        $sbTimeMultiplier = str_replace('-', '', $conf['timeOffset']);
                        $sbTimeOffset = $sbTimeMultiplier * 3600;
                        $sbTimeTemp = time();
                        $timestamp = ($sbTimeTemp - $sbTimeOffset);
                }

                $stickyShout = htmlspecialchars($stickyShout, ENT_QUOTES);
                $stickyShout = ereg_replace("&amp;amp;", "&amp;",$stickyShout);

                $sql = "select * from ".$prefix."_shoutbox_sticky where stickySlot='$stickySlot'";
                $stickyResult = $db->sql_query($sql);
                $stickyRow = $db->sql_fetchrow($stickyResult);
                if ($stickyRow) {
                        $sql = "UPDATE ".$prefix."_shoutbox_sticky set name='$stickyUsername', comment='$stickyShout', timestamp='$timestamp' where stickySlot='$stickySlot'";
                } else {
                        $sql = "INSERT INTO ".$prefix."_shoutbox_sticky (name,comment,timestamp,stickySlot) VALUES ('$stickyUsername','$stickyShout','$timestamp','$stickySlot')";
                }
        } else {
                $sql = "DELETE FROM ".$prefix."_shoutbox_sticky WHERE stickySlot='$stickySlot'";
        }
        $db->sql_query($sql);
        Header("Location: ".$admin_file.".php?op=shoutmodule&Submit=manageShouts&page=$page");
        exit;
}

function ShoutEdit($shoutID, $page, $ShoutError) {
        global $prefix, $db, $admin_file;
        include ("header.php");
        LinkAdmin();
        $ShoutMenuOptionActive = 1;
        ShoutBoxAdminMenu($ShoutMenuOptionActive);
        OpenTable();
        $sql = "select * from ".$prefix."_shoutbox_shouts where id='$shoutID'";
        $nameresult = $db->sql_query($sql);
        $row = $db->sql_fetchrow($nameresult);

        // strip out link code here (added back in later if saved)
        $ShoutComment = $row['comment'];
        $ShoutComment = ereg_replace("&#91;<a rel=\"nofollow\" target=\"_blank\" href=\"", "",$ShoutComment);
        $ShoutComment = ereg_replace("&#91;<a rel=\"nofollow\" href=\"", "",$ShoutComment);
        $ShoutComment = ereg_replace("&#91;<a target=\"_blank\" href=\"", "",$ShoutComment);
        $ShoutComment = ereg_replace("&#91;<a href=\"", "",$ShoutComment);
        $ShoutComment = ereg_replace("\">URL</a>&#93;", "",$ShoutComment);
        $ShoutComment = ereg_replace("\">FTP</a>&#93;", "",$ShoutComment);
        $ShoutComment = ereg_replace("\">IRC</a>&#93;", "",$ShoutComment);
        $ShoutComment = ereg_replace("\">TeamSpeak</a>&#93;", "",$ShoutComment);
        $ShoutComment = ereg_replace("\">AIM</a>&#93;", "",$ShoutComment);
        $ShoutComment = ereg_replace("\">Gopher</a>&#93;", "",$ShoutComment);
        $ShoutComment = ereg_replace("\">E-Mail</a>&#93;", "",$ShoutComment);

        $i = 0;
        $ShoutNew = '';
        $ShoutArray = explode(" ",$ShoutComment);
        foreach($ShoutArray as $ShoutPart) {
                if (eregi("mailto:", $ShoutPart)) { // find mailto:
                        $ShoutPart = eregi_replace("mailto:", "",$ShoutPart); // strip out mailto:
                        $ShoutPart = eregi_replace("%", " ",$ShoutPart);
                        $ShoutPart = trim($ShoutPart);
                        // decode address to ascii
                        $c = 0;
                        $AddyArray = explode(" ",$ShoutPart);
                        foreach($AddyArray as $AddyPart) {
                                $AddyNew[$c] = chr(hexdec($AddyPart));
                                $c++;
                        }
                        $ShoutPart = implode("",$AddyNew);
                        $ShoutNew[$i] = "mailto:$ShoutPart"; // add mailto: back in
                } else { $ShoutNew[$i] = $ShoutPart; }
                $i++;
        }
        $ShoutComment = implode(" ",$ShoutNew);

        // strip smilies code here (added back in later if saved)
        $sql = "select * from ".$prefix."_shoutbox_emoticons";
        $eresult = $db->sql_query($sql);
        while ($emoticons = $db->sql_fetchrow($eresult)) {
                $ShoutComment = str_replace($emoticons['image'],$emoticons['text'],$ShoutComment);
        }

        echo "<form name=\"adminshoutedit\" method=\"post\" action=\"\" style=\"margin-bottom: 0px;\">\n";
        echo "<table cellpadding=\"3\" cellspacing=\"0\" width=\"90%\" border=\"0\" align=\"center\">\n";
        echo "<tr><td align=\"center\"><span class=\"title\">"._EDITSHOUT."<br /><br /></span></td></tr>\n";
        if (($ShoutError) && ($ShoutError != 'none')) {
                echo "<tr><td style=\"background: #FF3333;\"><b>"._SB_NOTE.":</b> $ShoutError</td></tr>";
        }
        echo "<tr><td align=\"center\"><input type=\"hidden\" name=\"shoutID\" value=\"$shoutID\" /><input type=\"text\" name=\"ShoutComment\" size=\"70\" value=\"$ShoutComment\" maxlength=\"2500\" /><input type=\"hidden\" name=\"page\" value=\"$page\" /><input type=\"hidden\" name=\"Submit\" value=\"ShoutSave\" />&nbsp;&nbsp;<input type=\"submit\" name=\"button\" value=\""._UPDATE."\" /></td></tr><tr><td align=\"center\"><a href=\"".$admin_file.".php?op=shoutmodule&amp;Submit=manageShouts&page=$page\">"._CANCELEDIT."</a></td></tr></table></form>\n";

        CloseTable();
        include("footer.php");
        exit;
}

function ShoutSave($shoutID, $ShoutComment, $page) {
        global $prefix, $db, $admin_file;
        $sql = "select * from ".$prefix."_shoutbox_conf";
        $result = $db->sql_query($sql);
        $conf = $db->sql_fetchrow($result);

        $ShoutComment = trim($ShoutComment); // remove whitespace off ends of shout
        $ShoutComment = preg_replace('/\s+/', ' ', $ShoutComment); // convert double spaces in middle of shout to single space
        $num = strlen($ShoutComment);
        if ($num < 1) { $ShoutError = ""._SHOUTTOOSHORT.""; }
        if ($num > 2500) { $ShoutError = ""._SHOUTTOOLONG.""; }
        if (!$ShoutComment) { $ShoutError = ""._NOSHOUT.""; }
        if ($ShoutComment == ""._SB_MESSAGE."") { $ShoutError = ""._NOSHOUT.""; }
        $ShoutComment = ereg_replace(" [.] ", ".",$ShoutComment);
        if (eregi(".xxx", $ShoutComment) AND $conf['blockxxx'] == "yes") {
                $ShoutError = ""._XXXBLOCKED."";
                $ShoutComment = "";
        }
        if (eregi("javascript:(.*)", $ShoutComment)) {
                $ShoutError = ""._JSINSHOUT."";
                $ShoutComment = "";
        }

        $ShoutComment = htmlspecialchars($ShoutComment, ENT_QUOTES);
        $ShoutComment = ereg_replace("&amp;amp;", "&amp;",$ShoutComment);

        // Scan for links in the shout. If there is, replace it with [URL] or block it if disallowed
        $i = 0;
        $ShoutNew = '';
        $ShoutArray = explode(" ",$ShoutComment);
        foreach($ShoutArray as $ShoutPart) {
                if (is_array($ShoutPart) == TRUE) { $ShoutPart = $ShoutPart[0]; }
                if (eregi("http:\/\/", $ShoutPart)) {
                        if ($conf['urlonoff'] == "no") { $ShoutError = ""._URLNOTALLOWED.""; break; }
                        // fix for users adding text to the beginning of links: HACKhttp://www.website.com
                        $ShoutPartL = strtolower($ShoutPart);
                        $spot = strpos($ShoutPartL,"http://");
                        if ($spot > 0) { $ShoutPart = substr($ShoutPart, $spot); }
                        $ShoutNew[$i] = "&#91;<a rel=\"nofollow\" target=\"_blank\" href=\"$ShoutPart\">URL</a>&#93;";
                } elseif (eregi("ftp:\/\/", $ShoutPart)) {
                        if ($conf['urlonoff'] == "no") { $ShoutError = ""._URLNOTALLOWED.""; break; }
                        $ShoutPartL = strtolower($ShoutPart);
                        $spot = strpos($ShoutPartL,"ftp://");
                        if ($spot > 0) { $ShoutPart = substr($ShoutPart, $spot); }
                        $ShoutNew[$i] = "&#91;<a rel=\"nofollow\" target=\"_blank\" href=\"$ShoutPart\">FTP</a>&#93;";
                } elseif (eregi("irc:\/\/", $ShoutPart)) {
                        if ($conf['urlonoff'] == "no") { $ShoutError = ""._URLNOTALLOWED.""; break; }
                        $ShoutPartL = strtolower($ShoutPart);
                        $spot = strpos($ShoutPartL,"irc://");
                        if ($spot > 0) { $ShoutPart = substr($ShoutPart, $spot); }
                        $ShoutNew[$i] = "&#91;<a rel=\"nofollow\" href=\"$ShoutPart\">IRC</a>&#93;";
                } elseif (eregi("teamspeak:\/\/", $ShoutPart)) {
                        if ($conf['urlonoff'] == "no") { $ShoutError = ""._URLNOTALLOWED.""; break; }
                        $ShoutPartL = strtolower($ShoutPart);
                        $spot = strpos($ShoutPartL,"teamspeak://");
                        if ($spot > 0) { $ShoutPart = substr($ShoutPart, $spot); }
                        $ShoutNew[$i] = "&#91;<a rel=\"nofollow\" href=\"$ShoutPart\">TeamSpeak</a>&#93;";
                } elseif (eregi("aim:goim", $ShoutPart)) {
                        if ($conf['urlonoff'] == "no") { $ShoutError = ""._URLNOTALLOWED.""; break; }
                        $ShoutPartL = strtolower($ShoutPart);
                        $spot = strpos($ShoutPartL,"aim:goim");
                        if ($spot > 0) { $ShoutPart = substr($ShoutPart, $spot); }
                        $ShoutNew[$i] = "&#91;<a rel=\"nofollow\" href=\"$ShoutPart\">AIM</a>&#93;";
                } elseif (eregi("gopher:\/\/", $ShoutPart)) {
                        if ($conf['urlonoff'] == "no") { $ShoutError = ""._URLNOTALLOWED.""; break; }
                        $ShoutPartL = strtolower($ShoutPart);
                        $spot = strpos($ShoutPartL,"gopher://");
                        if ($spot > 0) { $ShoutPart = substr($ShoutPart, $spot); }
                        $ShoutNew[$i] = "&#91;<a rel=\"nofollow\" href=\"$ShoutPart\">Gopher</a>&#93;";
                } elseif (eregi("mailto:", $ShoutPart)) {
                        $ShoutPartL = strtolower($ShoutPart);
                        $spot = strpos($ShoutPartL,"mailto:");
                        if ($spot > 0) { $ShoutPart = substr($ShoutPart, $spot); }
                        // email encoding to stop harvesters
                        $ShoutPart = bin2hex($ShoutPart);
                        $ShoutPart = chunk_split($ShoutPart, 2, '%');
                        $ShoutPart = '%' . substr($ShoutPart, 0, strlen($ShoutPart) - 1);
                        $ShoutNew[$i] = "&#91;<a href=\"$ShoutPart\">E-Mail</a>&#93;";
                } elseif (eregi("www\.", $ShoutPart)) {
                        if ($conf['urlonoff'] == "no") { $ShoutError = ""._URLNOTALLOWED.""; break; }
                        $ShoutPartL = strtolower($ShoutPart);
                        $spot = strpos($ShoutPartL,"www.");
                        if ($spot > 0) { $ShoutPart = substr($ShoutPart, $spot); }
                        $ShoutPart = "http://" . $ShoutPart;
                        $ShoutNew[$i] = "&#91;<a rel=\"nofollow\" target=\"_blank\" href=\"$ShoutPart\">URL</a>&#93;";
                } elseif (eregi('@', $ShoutPart) AND eregi('\.', $ShoutPart)) {
                        //     \b[A-Z0-9._%-]+@[A-Z0-9._%-]+\.[A-Z]{2,4}\b

                        // email encoding to stop harvesters
                        $ShoutPart = bin2hex($ShoutPart);
                        $ShoutPart = chunk_split($ShoutPart, 2, '%');
                        $ShoutPart = '%' . substr($ShoutPart, 0, strlen($ShoutPart) - 1);
                        $ShoutNew[$i] = "&#91;<a href=\"mailto:$ShoutPart\">E-Mail</a>&#93;";
                } elseif ((eregi("\.(us|tv|cc|ws|ca|de|jp|ro|be|fm|ms|tc|ph|dk|st|ac|gs|vg|sh|kz|as|lt|to)", substr("$ShoutPart", -3,3))) OR (eregi("\.(com|net|org|mil|gov|biz|pro|xxx)", substr("$ShoutPart", -4,4))) OR (eregi("\.(info|name|mobi)", substr("$ShoutPart", -5,5))) OR (eregi("\.(co\.uk|co\.za|co\.nz|co\.il)", substr("$ShoutPart", -6,6)))) {
                        if ($conf['urlonoff'] == "no") { $ShoutError = ""._URLNOTALLOWED.""; break; }
                        $ShoutPart = "http://" . $ShoutPart;
                        $ShoutNew[$i] = "&#91;<a rel=\"nofollow\" target=\"_blank\" href=\"$ShoutPart\">URL</a>&#93;";
                } elseif (strlen(html_entity_decode($ShoutPart, ENT_QUOTES)) > 21) {
                        $ShoutNew[$i] = htmlspecialchars(wordwrap(html_entity_decode($ShoutPart, ENT_QUOTES), 21, " ", 1), ENT_QUOTES);
                        $ShoutNew[$i] = str_replace("[ b]", " [b]",$ShoutNew[$i]);
                        $ShoutNew[$i] = str_replace("[b ]", " [b]",$ShoutNew[$i]);
                        $ShoutNew[$i] = str_replace("[ /b]", "[/b] ",$ShoutNew[$i]);
                        $ShoutNew[$i] = str_replace("[/ b]", "[/b] ",$ShoutNew[$i]);
                        $ShoutNew[$i] = str_replace("[/b ]", "[/b] ",$ShoutNew[$i]);

                        $ShoutNew[$i] = str_replace("[ i]", " [i]",$ShoutNew[$i]);
                        $ShoutNew[$i] = str_replace("[i ]", " [i]",$ShoutNew[$i]);
                        $ShoutNew[$i] = str_replace("[ /i]", "[/i] ",$ShoutNew[$i]);
                        $ShoutNew[$i] = str_replace("[/ i]", "[/i] ",$ShoutNew[$i]);
                        $ShoutNew[$i] = str_replace("[/i ]", "[/i] ",$ShoutNew[$i]);

                        $ShoutNew[$i] = str_replace("[ u]", " [u]",$ShoutNew[$i]);
                        $ShoutNew[$i] = str_replace("[u ]", " [u]",$ShoutNew[$i]);
                        $ShoutNew[$i] = str_replace("[ /u]", "[/u] ",$ShoutNew[$i]);
                        $ShoutNew[$i] = str_replace("[/ u]", "[/u] ",$ShoutNew[$i]);
                        $ShoutNew[$i] = str_replace("[/u ]", "[/u] ",$ShoutNew[$i]);
                } else { $ShoutNew[$i] = $ShoutPart; }
                $i++;
        }
        if ($ShoutError == "") { $ShoutComment = implode(" ",$ShoutNew); }

        //Smilies from database
        $ShoutArrayReplace = explode(" ",$ShoutComment);
        $ShoutArrayScan = $ShoutArrayReplace;
        $sql = "select * from ".$prefix."_shoutbox_emoticons";
        $eresult = $db->sql_query($sql);
        while ($emoticons = $db->sql_fetchrow($eresult)) {
                $i = 0;
                foreach($ShoutArrayScan as $ShoutPart) {
                        if ($ShoutPart == $emoticons['text']) { $ShoutArrayReplace[$i] = $emoticons['image']; }
                        $i++;
                }
        }
        $ShoutComment = implode(" ",$ShoutArrayReplace);

        //look for bad words, then censor them.
        if($conf['censor'] == "yes") {
                $ShoutArrayReplace = explode(" ",$ShoutComment);
                $ShoutArrayScan = $ShoutArrayReplace;
                $sql = "select * from ".$prefix."_shoutbox_censor";
                $cresult = $db->sql_query($sql);
                while ($censor = $db->sql_fetchrow($cresult)) {
                        $i = 0;
                        foreach($ShoutArrayScan as $ShoutPart) {
                                $ShoutPart = strtolower($ShoutPart);
                                $censor['text'] = strtolower($censor['text']);
                                if ($ShoutPart == $censor['text']) { $ShoutArrayReplace[$i] = $censor['replacement']; }
                                $i++;
                        }
                }
                $ShoutComment = implode(" ",$ShoutArrayReplace);

                /*
                // Phrase censor - Needs work before implementing
                $sql = "select * from ".$prefix."_shoutbox_emoticons";
                $eresult = $db->sql_query($sql);
                while ($emoticons = $db->sql_fetchrow($eresult)) {
                        $ShoutComment = str_replace($emoticons[1],$emoticons[2],$ShoutComment);
                }
                */
        }

        if (!$ShoutError) {
                $sql = "UPDATE ".$prefix."_shoutbox_shouts set comment='$ShoutComment' WHERE id='$shoutID'";
                $db->sql_query($sql);
        } else {
                Header("Location: ".$admin_file.".php?op=shoutmodule&Submit=ShoutEdit&shoutID=$shoutID&page=$page&ShoutError=$ShoutError");
                exit;
        }
        Header("Location: ".$admin_file.".php?op=shoutmodule&Submit=manageShouts&page=$page");
        exit;
}

function shremove($page, $sr, $shr,$listnum) {
        global $prefix, $db, $admin_file;
        for ($x = 1; $x <= $listnum; $x++) {
                if ($shr[$x] == 'on') {
                        $sql = "DELETE FROM ".$prefix."_shoutbox_shouts WHERE id='$sr[$x]'";
                        $db->sql_query($sql);
                }
        }
        Header("Location: ".$admin_file.".php?op=shoutmodule&Submit=manageShouts&page=$page");
        exit;
}

function adminDropCount($aCount, $page) {
        global $prefix, $db, $admin_file, $admin;
        $sql = "UPDATE ".$prefix."_shoutbox_manage_count set aCount='$aCount' WHERE admin='$admin[0]'";
        $db->sql_query($sql);
        Header("Location: ".$admin_file.".php?op=shoutmodule&Submit=manageShouts&page=$page");
        exit;
}

// End 'Manage Shouts' code

// Start 'Bans' code

function ShoutBoxBans() {
        global $prefix, $db, $admin_file;
        include ("header.php");
        LinkAdmin();
        $ThemeSel = get_theme();
        $sql = "select * from ".$prefix."_shoutbox_themes WHERE themeName='$ThemeSel'";
        $result = $db->sql_query($sql);
        $rowColor = $db->sql_fetchrow($result);
        $sql = "select * from ".$prefix."_shoutbox_conf";
        $result = $db->sql_query($sql);
        $conf = $db->sql_fetchrow($result);

        $ShoutMenuOptionActive = 7;
        ShoutBoxAdminMenu($ShoutMenuOptionActive);
        OpenTable();
        echo "<table align=\"center\" width=\"95%\" cellpadding=\"3\" cellspacing=\"0\" border=\"0\">\n";

        echo "<tr style=\"background-color: $rowColor[menuColor2];\" onmouseover=\"this.style.backgroundColor='$rowColor[menuColor1]';\" onmouseout=\"this.style.backgroundColor='$rowColor[menuColor2]';\"><td width=\"70%\" valign=\"middle\">"._BANIPONOFF."</td><td width=\"30%\" valign=\"middle\"><form name=\"ipbanactive\" method=\"post\" action=\"\" style=\"margin-bottom: 0px;\"><select onchange=\"top.location.href=this.options[this.selectedIndex].value\" name=\"ipban1\" disabled=\"disabled\">";
        if ($conf['ipblock'] == 'yes') { $SEL1 = " selected=\"selected\""; } else { $SEL1 = ""; }
        if ($conf['ipblock'] == 'no') { $SEL2 = " selected=\"selected\""; } else { $SEL2 = ""; }
        echo "<option value=\"".$admin_file.".php?op=shoutmodule&amp;Submit=ipbanactive&amp;banoption=yes\"$SEL1>"._YES."</option><option value=\"".$admin_file.".php?op=shoutmodule&amp;Submit=ipbanactive&amp;banoption=no\"$SEL2>"._NO."</option>";
        echo "</select></form></td></tr>";

        echo "<tr style=\"background-color: $rowColor[menuColor2];\" onmouseover=\"this.style.backgroundColor='$rowColor[menuColor1]';\" onmouseout=\"this.style.backgroundColor='$rowColor[menuColor2]';\"><td valign=\"middle\">"._BANNAMEONOFF."</td><td valign=\"middle\"><form name=\"namebanactive\" method=\"post\" action=\"\" style=\"margin-bottom: 0px;\"><select onchange=\"top.location.href=this.options[this.selectedIndex].value\" name=\"nameban1\" disabled=\"disabled\">";
        if ($conf['nameblock'] == 'yes') { $SEL1 = " selected=\"selected\""; } else { $SEL1 = ""; }
        if ($conf['nameblock'] == 'no') { $SEL2 = " selected=\"selected\""; } else { $SEL2 = ""; }
        echo "<option value=\"".$admin_file.".php?op=shoutmodule&amp;Submit=namebanactive&amp;banoption=yes\"$SEL1>"._YES."</option><option value=\"".$admin_file.".php?op=shoutmodule&amp;Submit=namebanactive&amp;banoption=no\"$SEL2>"._NO."</option>";
        echo "</select></form></td></tr>";

        echo "</table>";
        CloseTable();
        echo "<br />";
        // BANS
        OpenTable();
        echo "<table align=\"center\" width=\"95%\" cellpadding=\"3\" cellspacing=\"0\" border=\"0\">";

        // banned IPs
        echo "<tr style=\"background-color: $rowColor[menuColor1];\"><td width=\"70%\" valign=\"middle\">"._ADDIPTOBAN."</td>
                <td width=\"30%\"  valign=\"middle\" nowrap=\"nowrap\"><form action=\"\" method=\"post\" style=\"margin-bottom: 0px;\"><input type=\"text\" name=\"banip\" value=\"\" />&nbsp;<input type=\"hidden\" name=\"Submit\" value=\"banip\" /><input type=\"submit\" name=\"button\" value=\""._ADD."\" /></form></td></tr>\n";

        $sql = "select * from ".$prefix."_shoutbox_ipblock";
        $ipresult = $db->sql_query($sql);
        $numrows = $db->sql_numrows($ipresult);
        if ($numrows > 0) {
                echo "<tr><td colspan=\"2\"><form action=\"\" method=\"post\" style=\"margin-bottom: 0px;\"><table width=\"100%\" cellpadding=\"3\" cellspacing=\"0\" border=\"0\"><tr style=\"background: $rowColor[menuColor2];\"><td width=\"70%\" valign=\"middle\">"._BANNEDIP."</td><td width=\"30%\" valign=\"middle\" nowrap=\"nowrap\">"._EDITADDRESS."</td></tr>\n";
                for ($shx = 1; $badips = $db->sql_fetchrow($ipresult); $shx++) {
                        echo "<tr style=\"background: $rowColor[menuColor2];\"><td valign=\"middle\">"._IPBANNED.":</td><td valign=\"middle\" nowrap=\"nowrap\"><input type=\"text\" name=\"ipn$shx\" value=\"$badips[name]\" />
                        <input type=\"hidden\" name=\"idn$shx\" value=\"$badips[id]\" />- <a href=\"".$admin_file.".php?op=shoutmodule&amp;Submit=ipremove&amp;ipremove=$badips[id]\">"._BBAREMOVE."</a>
                        </td></tr>\n";
                }
                $shx = $shx - 1;
                echo "<tr style=\"background-color: $rowColor[menuColor2];\"><td valign=\"middle\">"._UPDATE.":</td><td valign=\"middle\"><input type=\"hidden\" name=\"listnum\" value=\"$shx\" /><input type=\"hidden\" name=\"Submit\" value=\"updateip\" /><input type=\"submit\" name=\"button\" value=\""._UPDATEIP."\" /></td></tr></table></form></td></tr>\n";
        }

        //Banned names
        if ($numrows > 0) {
                echo "<tr style=\"background-color: $rowColor[menuColor1];\">";
        } else {
                echo "<tr style=\"background-color: $rowColor[menuColor2];\">";
        }
        echo "<td valign=\"middle\">"._ADDNAMETOBAN."</td>
                <td valign=\"middle\" nowrap=\"nowrap\"><form action=\"\" method=\"post\" style=\"margin-bottom: 0px;\"><input type=\"text\" name=\"addname\" value=\"\" />&nbsp;<input type=\"hidden\" name=\"Submit\" value=\"addname\" /><input type=\"submit\" name=\"button\" value=\""._ADD."\" /></form></td></tr>\n";

        $sql = "select * from ".$prefix."_shoutbox_nameblock";
        $nameresult = $db->sql_query($sql);
        $numrows = $db->sql_numrows($nameresult);
        if ($numrows > 0) {
                echo "<tr><td colspan=\"2\"><form action=\"\" method=\"post\" style=\"margin-bottom: 0px;\"><table width=\"100%\" cellpadding=\"3\" cellspacing=\"0\" border=\"0\"><tr style=\"background: $rowColor[menuColor2];\"><td width=\"70%\" valign=\"middle\">"._BANNEDNAMES."</td><td width=\"30%\" valign=\"middle\">"._EDITNAME."</td></tr>\n";
                for ($shx = 1; $badnames = $db->sql_fetchrow($nameresult); $shx++) {
                        echo "<tr style=\"background: $rowColor[menuColor2];\"><td valign=\"middle\">"._NAMEBANNED.":</td><td valign=\"middle\" nowrap=\"nowrap\"><input type=\"text\" name=\"namen$shx\" value=\"$badnames[name]\" />
                                <input type=\"hidden\" name=\"idn$shx\" value=\"$badnames[id]\" />
                                - <a href=\"".$admin_file.".php?op=shoutmodule&amp;Submit=nameremove&amp;nameremove=$badnames[id]\" class=\"content\">"._BBAREMOVE."</a></td></tr>\n";
                }
                $shx = $shx - 1;
                echo "<tr style=\"background: $rowColor[menuColor2];\"><td valign=\"middle\">"._UPDATE.":</td><td valign=\"middle\"><input type=\"hidden\" name=\"listnum\" value=\"$shx\" /><input type=\"hidden\" name=\"Submit\" value=\"updatename\" /><input type=\"submit\" name=\"button\" value=\""._UPDATENAME."\" /></td></tr></table></form></td></tr>\n";
        }
        echo "</table>";

        CloseTable();
        include("footer.php");
        exit;
}

function addname($addname) {
        global $prefix, $db, $admin_file;
        $sql = "INSERT INTO ".$prefix."_shoutbox_nameblock (name) VALUES ('$addname')";
        $db->sql_query($sql);
        Header("Location: ".$admin_file.".php?op=shoutmodule&Submit=ShoutBoxBans");
        exit;
}

function updatename($idn, $namen, $listnum) {
        global $prefix, $db, $admin_file;
        for ($x = 1; $x <= $listnum; $x++) {
                $sql = "UPDATE ".$prefix."_shoutbox_nameblock set id='$idn[$x]', name='$namen[$x]' where id='$idn[$x]'";
                $db->sql_query($sql);
        }
        Header("Location: ".$admin_file.".php?op=shoutmodule&Submit=ShoutBoxBans");
        exit;
}

function nameremove($nameremove) {
        global $prefix, $db, $admin_file;
        $sql = "DELETE FROM ".$prefix."_shoutbox_nameblock WHERE id='$nameremove'";
        $db->sql_query($sql);
        Header("Location: ".$admin_file.".php?op=shoutmodule&Submit=ShoutBoxBans");
        exit;
}

function banip($banip) { // From Bans tab
        global $prefix, $db, $admin_file;
        $sql = "INSERT INTO ".$prefix."_shoutbox_ipblock (name) VALUES ('$banip')";
        $db->sql_query($sql);
        Header("Location: ".$admin_file.".php?op=shoutmodule&Submit=ShoutBoxBans");
        exit;
}

function addip($addip, $page) { // From Manage shouts tab
        global $prefix, $db, $admin_file;
        $sql = "INSERT INTO ".$prefix."_shoutbox_ipblock (name) VALUES ('$addip')";
        $db->sql_query($sql);
        Header("Location: ".$admin_file.".php?op=shoutmodule&Submit=manageShouts&page=$page");
        exit;
}

function updateip($ipn, $idn, $listnum) {
        global $prefix, $db, $admin_file;
        for ($x = 1; $x <= $listnum; $x++) {
                $sql = "UPDATE ".$prefix."_shoutbox_ipblock set id='$idn[$x]', name='$ipn[$x]' where id='$idn[$x]'";
                $db->sql_query($sql);
        }
        Header("Location: ".$admin_file.".php?op=shoutmodule&Submit=ShoutBoxBans");
        exit;
}

function ipremove($ipremove) {
        global $prefix, $db, $admin_file;
        $sql = "DELETE FROM ".$prefix."_shoutbox_ipblock WHERE id='$ipremove'";
        $db->sql_query($sql);
        Header("Location: ".$admin_file.".php?op=shoutmodule&Submit=ShoutBoxBans");
        exit;
}

// End 'Bans' code

switch ($Submit) {

        case "adminDropCount":
        adminDropCount($aCount, $page);
        break;

        case "ShoutBoxBans":
        ShoutBoxBans();
        break;

        case "addname":
        addname($addname);
        break;

        case "updatename":
        for ($x = 1; $x <= $listnum; $x++) {
                $idn[$x] = ${"idn$x"};
                $namen[$x] = ${"namen$x"};
        }
        updatename($idn, $namen, $listnum);
        break;

        case "nameremove":
        nameremove($nameremove);
        break;

        case "banip":
        banip($banip);
        break;

        case "ban":
        $sql = "select ip from ".$prefix."_shoutbox_shouts where id='$bid'";
        $idresult = $db->sql_query($sql);
        $banip = $db->sql_fetchrow($idresult);
        $addip = $banip['ip'];
        addip($addip, $page);
        break;

        case "updateip":
        for ($x = 1; $x <= $listnum; $x++) {
                $idn[$x] = ${"idn$x"};
                $ipn[$x] = ${"ipn$x"};
        }
        updateip($ipn, $idn, $listnum);
        break;

        case "ipremove":
        ipremove($ipremove);
        break;

        case "shremove":
        for ($x = 1; $x <= $listnum; $x++) {
                $shr[$x] = ${"shr$x"};
                $sr[$x] = ${"sr$x"};
        }
        shremove($page, $sr, $shr, $listnum);
        break;

        case "ShoutEdit":
        if ($ShoutError == '') { $ShoutError = 'none'; }
        ShoutEdit($shoutID, $page, $ShoutError);
        break;

        case "ShoutSave":
        ShoutSave($shoutID, $ShoutComment, $page);
        break;

        case "manageShouts":
        if ($page == "") { $page = "1"; }
        manageShouts($page);
        break;

        case "stickySubmit":
        stickySubmit($stickyShout, $stickyUsername, $stickySlot, $page);
        break;

        default:
        if ($page == "") { $page = "1"; }
        manageShouts($page);
        break;

}

} else {
        include("header.php");
        LinkAdmin();
        OpenTable();
        echo "<center><b>"._ERROR."</b><br /><br />You do not have administration permission for module \"$module_name\"</center>";
        CloseTable();
        include("footer.php");
}

?>
