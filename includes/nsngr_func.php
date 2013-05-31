<?php

/********************************************************/
/* NSN Groups                                           */
/* By: NukeScripts Network (webmaster@nukescripts.net)  */
/* http://www.nukescripts.net                           */
/* Copyright © 2000-2005 by NukeScripts Network         */
/********************************************************/
define("NSNGROUPS_IS_LOADED", TRUE);

// Load required scripts
if(defined('FORUM_ADMIN')) {
    $lang_dir = "../../../";
} elseif(defined('INSIDE_MOD')) {
    $lang_dir = "../../";
} else {
    $lang_dir = "";
}

// Load required configs
$nuke_config = $db->sql_fetchrow($db->sql_query("SELECT * FROM `".$prefix."_config`"));

// Load required lang file
if(!isset($lang)) { $lang = $nuke_config['language']; }
if(!eregi("\.","$lang") AND file_exists($lang_dir."language/groups/lang-$lang.php")) {
  require_once($lang_dir."language/groups/lang-$lang.php");
} else {
  require_once($lang_dir."language/groups/lang-english.php");
}

function in_group($gid) {
    global $prefix, $db, $user, $admin, $cookie;
    /*if(is_admin($admin)) {
        return 1;
    } else*/if(is_user($user)) {
        cookiedecode($user);
        $guid = $cookie[0];
        $currdate = time();
        $ingroup = $db->sql_numrows($db->sql_query("SELECT * FROM `".$prefix."_nsngr_users` WHERE `gid`='$gid' AND `uid`='$guid' AND (`edate`>'$currdate' OR `edate`='0')"));
        if($ingroup > 0) { return 1; }
    }
    return 0;
}

function in_groups($gids) {
    global $prefix, $db, $user, $admin, $cookie;
    if(!is_array($gids)) { $gids = explode("-",$gids); }
    /*if(is_admin($admin)) {
        return 1;
    } else*/if(is_user($user)) {
        cookiedecode($user);
        $guid = $cookie[0];
        $currdate = time();
        for($i=0; $i < count($gids); $i++) {
            $ingroup = $db->sql_numrows($db->sql_query("SELECT * FROM `".$prefix."_nsngr_users` WHERE `gid`='".$gids[$i]."' AND `uid`='$guid' AND (`edate`>'$currdate' OR `edate`='0')"));
            if($ingroup > 0) { return 1; }
        }
    }
    return 0;
}

function is_ingroup($guid,$gid) {
    global $prefix, $db;
    $isgroup = $db->sql_numrows($db->sql_query("SELECT * FROM `".$prefix."_nsngr_users` WHERE `gid`='$gid' AND `uid`='$guid'"));
    if($isgroup > 0) { return 1; }
    return 0;
}

$currdate = time ();
$result = $db->sql_query("SELECT * FROM `".$prefix."_nsngr_users` WHERE (`edate`<'$currdate' AND `edate`!='0') AND `trial`='0'");
while($row = $db->sql_fetchrow($result)) {
  list($phpBB) = $db->sql_fetchrow($db->sql_query("SELECT `phpBB` FROM `".$prefix."_nsngr_groups` WHERE `gid`='".$row['gid']."'"));
  $db->sql_query("DELETE FROM `".$prefix."_nsngr_users` WHERE (`edate`<'$currdate' AND `edate`!='0') AND `trial`='0'");
  $db->sql_query("OPTIMIZE TABLE `".$prefix."_nsngr_users`");
  $db->sql_query("DELETE FROM `".$prefix."_bbuser_group` WHERE `group_id`='$phpBB' and `user_id`='".$row['uid']."'");
  $db->sql_query("OPTIMIZE TABLE `".$prefix."_bbuser_group`");
}
$exprdate = $currdate + 604800;
$result = $db->sql_query("SELECT * FROM `".$prefix."_nsngr_users` WHERE (`edate`<'$exprdate' AND `edate`!='0') AND `notice`='0'");
while($row = $db->sql_fetchrow($result)) {
  $grsend = grget_config("send_notice");
  if($grsend > 0) {
    $row2 = $db->sql_fetchrow($db->sql_query("SELECT `username`, `user_email` FROM `".$user_prefix."_users` WHERE `user_id`='".$row['uid']."'"));
    $row3 = $db->sql_fetchrow($db->sql_query("SELECT `gname` FROM `".$prefix."_nsngr_groups` WHERE `gid`='".$row['gid']."'"));
    $from = "From: $sitename <$adminmail>\r\n";
    $subject = $row3['gname']." "._GR_MEMBERSHIP." "._GR_EXPIRESSOON;
    $body = $row2['username'].":\r\r"._GR_EXPIREEXPLAIN."\r\r$sitename "._TEAM."\r$nukeurl";
    @mail($row2['user_email'], $subject, $body, $from);
  }
  $db->sql_query("UPDATE `".$prefix."_nsngr_users` SET `notice`='1' WHERE `uid`='".$row['uid']."' AND `gid`='".$row['gid']."'");
}

function grsave_config($config_name, $config_value){
    global $prefix, $db;
    $db->sql_query("UPDATE `".$prefix."_nsngr_config` SET `config_value`='$config_value' WHERE `config_name`='$config_name'");
}

function grget_config($config_name){
    global $prefix, $db;
    $configresult = $db->sql_query("SELECT `config_value` FROM `".$prefix."_nsngr_config` WHERE `config_name`='$config_name'");
    list($config_value) = $db->sql_fetchrow($configresult);
    return $config_value;
}

function grget_configs(){
    global $prefix, $db;
    $configresult = $db->sql_query("SELECT `config_name`, `config_value` FROM `".$prefix."_nsngr_config`");
    while (list($config_name, $config_value) = $db->sql_fetchrow($configresult)) {
        $config[$config_name] = $config_value;
    }
    return $config;
}

function NSNGroupsAdmin() {
    global $db, $prefix, $admin_file;
    $grpnum = $db->sql_numrows($db->sql_query("SELECT `gname` FROM `".$prefix."_nsngr_groups`"));
    $usrnum = $db->sql_numrows($db->sql_query("SELECT `gid` FROM `".$prefix."_nsngr_users`"));
    OpenTable();
    echo "<center>\n<table cellpadding='3'>\n<tr>\n";
    echo "<td align='center' valign='top' width='150'>";
    echo "<a href='".$admin_file.".php?op=NSNGroupsAdd'>"._GR_GROUPSADD."</a><br>";
    echo "<a href='".$admin_file.".php?op=NSNGroupsView'>"._GR_GROUPSVIEW."</a> ($grpnum)<br>";
    echo "</td>\n";
    echo "<td align='center' valign='top' width='150'>";
    echo "<a href='".$admin_file.".php?op=NSNGroupsUsersEmail'>"._GR_GROUPSEMAIL."</a><br>";
    echo "<a href='".$admin_file.".php?op=NSNGroupsConfig'>"._GR_GROUPSCONFIG."</a><br>";
    echo "</td>\n";
    echo "<td align='center' valign='top' width='150'>";
    echo "<a href='".$admin_file.".php?op=NSNGroupsUsersAdd'>"._GR_GROUPSUSERSADD."</a><br>";
    echo '<a href="' . $admin_file . '.php?op=NSNGroupsSingleUserAdd">' . _GR_GROUPSSINGLEUSERADD . '</a><br />';
    echo "<a href='".$admin_file.".php?op=NSNGroupsUsersView'>"._GR_GROUPSUSERSVIEW."</a> ($usrnum)<br>";
    echo "</td>\n";
    echo "</tr>\n";
    echo "<tr>\n<td colspan='3' align='center'><a href='".$admin_file.".php'>"._MAINADMINMENU."</a></td>\n</tr>\n";
    echo "</table>\n</center>\n";
    CloseTable();
}

function grpagenums($op, $totalselected, $perpage, $max, $gid) {
    global $admin_file;
    $pagesint = ($totalselected / $perpage);
    $pageremainder = ($totalselected % $perpage);
    if($pageremainder != 0) {
        $pages = ceil($pagesint);
        if($totalselected < $perpage) { $pageremainder = 0; }
    } else {
        $pages = $pagesint;
    }
    if($pages != 1 && $pages != 0) {
        $counter = 1;
        $currentpage = ($max / $perpage);
        echo "<table align='center' border='0' cellpadding='2' cellspacing='2'>\n";
        echo "<tr><form action='".$admin_file.".php' method='post'>\n";
        echo "<input type='hidden' name='op' value='$op'>\n";
        echo "<input type='hidden' name='gid' value='$gid'>\n";
        echo "<td align='center'><b>"._GR_SELECTPAGE.": </b><select name='min'>\n";
        while ($counter <= $pages ) {
            $cpage = $counter;
            $mintemp = ($perpage * $counter) - $perpage;
            echo "<option value='$mintemp'";
            if($counter == $currentpage) { echo " selected"; }
            echo ">$counter</option>\n";
            $counter++;
        }
        echo "</select><b> "._GR_OF." $pages "._GR_PAGES."</b> <input type='submit' value='"._GR_GO."'></td>\n";
        echo "</form>\n</tr>\n</table>\n";
    }
}

function grformcheck($field_r, $field_d) {
  echo "<script language=\"JavaScript\">\n";
  echo "<!--\n";
  echo "function formCheck(formobj){\n";
  echo "  // name of mandatory fields\n";
  echo "  var fieldRequired = Array(".$field_r.");\n";
  echo "  // field description to appear in the dialog box\n";
  echo "  var fieldDescription = Array(".$field_d.");\n";
  echo "  // dialog message\n";
  echo "  var alertMsg = \"Please complete the following fields:\\n\";\n";
  echo "  var l_Msg = alertMsg.length;\n";
  echo "  for(var i = 0; i < fieldRequired.length; i++){\n";
  echo "    var obj = formobj.elements[fieldRequired[i]];\n";
  echo "    if(obj){\n";
  echo "      switch(obj.type){\n";
  echo "        case \"SELECT-one\":\n";
  echo "          if(obj.selectedIndex == -1 || obj.options[obj.selectedIndex].text == \"\"){\n";
  echo "            alertMsg += \" - \" + fieldDescription[i] + \"\\n\";\n";
  echo "          }\n";
  echo "          break;\n";
  echo "        case \"SELECT-multiple\":\n";
  echo "          if(obj.selectedIndex == -1){\n";
  echo "            alertMsg += \" - \" + fieldDescription[i] + \"\\n\";\n";
  echo "          }\n";
  echo "          break;\n";
  echo "        case \"text\":\n";
  echo "        case \"textarea\":\n";
  echo "          if(obj.value == \"\" || obj.value == null){\n";
  echo "            alertMsg += \" - \" + fieldDescription[i] + \"\\n\";\n";
  echo "          }\n";
  echo "          break;\n";
  echo "        default:\n";
  echo "      }\n";
  echo "      if(obj.type == undefined){\n";
  echo "        var blnchecked = false;\n";
  echo "        for(var j = 0; j < obj.length; j++){\n";
  echo "          if(obj[j].checked){\n";
  echo "            blnchecked = true;\n";
  echo "          }\n";
  echo "        }\n";
  echo "        if(!blnchecked){\n";
  echo "          alertMsg += \" - \" + fieldDescription[i] + \"\\n\";\n";
  echo "        }\n";
  echo "      }\n";
  echo "    }\n";
  echo "  }\n";
  echo "  if(alertMsg.length == l_Msg){\n";
  echo "    return true;\n";
  echo "  }else{\n";
  echo "    alert(alertMsg);\n";
  echo "    return false;\n";
  echo "  }\n";
  echo "}\n";
  echo "// -->\n";
  echo "</script>\n";
}

?>