<?php

/********************************************************/
/* NSN News                                             */
/* By: NukeScripts Network (webmaster@nukescripts.net)  */
/* http://www.nukescripts.net                           */
/* Copyright © 2000-2005 by NukeScripts Network         */
/********************************************************/
/* Based on: Threaded Discussion                        */
/* Copyright (C) 2000  Thatware Development Team        */
/* http://atthat.com/                                   */
/********************************************************/

function ne_save_config($config_name, $config_value){
  global $prefix, $db;
  $resultnum = $db->sql_numrows($db->sql_query("SELECT * FROM `".$prefix."_nsnne_config` WHERE `config_name`='$config_name'"));
  if($resultnum < 1) {
    $db->sql_query("INSERT INTO `".$prefix."_nsnne_config` (`config_name`, `config_value`) VALUES ('$config_name', '$config_value')");
  } else {
    $db->sql_query("UPDATE `".$prefix."_nsnne_config` SET `config_value`='$config_value' WHERE `config_name`='$config_name'");
  }
}

function ne_get_configs(){
  global $prefix, $db;
  $configresult = $db->sql_query("SELECT `config_name`, `config_value` FROM `".$prefix."_nsnne_config`");
  while(list($config_name, $config_value) = $db->sql_fetchrow($configresult)) {
    $config[$config_name] = $config_value;
  }
  $db->sql_freeresult($configresult);
  return $config;
}

$neconfig = ne_get_configs();
$approved_users = explode("\r\n", $neconfig['approved_users']);
$allow_tags = explode("\r\n", $neconfig['allowed_tags']);
$allowed_tags = array();
while(list($key,$value) = each($allow_tags)) {
$value=str_replace("\"","",$value);
  $atags = explode("=>", $value);
  $allowed_tags["$atags[0]"] = $atags[1];
}

function ne_convert_text($conv_text){
  global $neconfig;
  $conv_text = stripslashes($conv_text);
  $conv_text = strtr($conv_text, "\015\012", '');
  $conv_text = str_replace("\r", "", $conv_text);
  $conv_text = str_replace("&amp;amp;", "&", $conv_text);
  $ne_fr1 = array("%25", "%00", "%01", "%02", "%03", "%04", "%05", "%06", "%07", "%08", "%09", "%0A", "%0B", "%0C", "%0D", "%0E", "%0F", "%10", "%11", "%12", "%13", "%14", "%15", "%16", "%17", "%18", "%19", "%1A", "%1B", "%1C", "%1D", "%1E", "%1F");
  $ne_to1 = array("%", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "");
  $ne_fr2 = array("%20", "%21", "%22", "%23", "%24", "%25", "%26", "%27", "%28", "%29", "%2A", "%2B", "%2C", "%2D", "%2E", "%2F", "%30", "%31", "%32", "%33", "%34", "%35", "%36", "%37", "%38", "%39", "%3A", "%3B", "%3C", "%3D", "%3E", "%3F");
  $ne_to2 = array(" ", "!", "\"", "#", "$", "%", "&", "'", "(", ")", "*", "+", ",", "-", ".", "/", "0", "1", "2", "3", "4", "5", "6", "7", "8", "9", ":", ";", "<", "=", ">", "?");
  $ne_fr3 = array("%40", "%41", "%42", "%43", "%44", "%45", "%46", "%47", "%48", "%49", "%4A", "%4B", "%4C", "%4D", "%4E", "%4F", "%50", "%51", "%52", "%53", "%54", "%55", "%56", "%57", "%58", "%59", "%5A", "%5B", "%5C", "%5D", "%5E", "%5F");
  $ne_to3 = array("@", "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z", "[", "\\", "]", "^", "_");
  $ne_fr4 = array("%60", "%61", "%62", "%63", "%64", "%65", "%66", "%67", "%68", "%69", "%6A", "%6B", "%6C", "%6D", "%6E", "%6F", "%70", "%71", "%72", "%73", "%74", "%75", "%76", "%77", "%78", "%79", "%7A", "%7B", "%7C", "%7D", "%7E", "%7F");
  $ne_to4 = array("`", "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z", "{", "|", "}", "`", "");
  $conv_text = str_replace($ne_fr1, $ne_to1, $conv_text);
  $conv_text = str_replace($ne_fr2, $ne_to2, $conv_text);
  $conv_text = str_replace($ne_fr3, $ne_to3, $conv_text);
  $conv_text = str_replace($ne_fr4, $ne_to4, $conv_text);
  $conv_text = ereg_replace("\\\\'", "'", $conv_text);
  $conv_text = str_replace("<BR>", "<br>", $conv_text);
  $conv_text = str_replace("<BR />", "<br>", $conv_text);
  $conv_text = str_replace("<br />", "<br>", $conv_text);
  $conv_text = str_replace("<br>\n", "<br>", $conv_text);
  $conv_text = str_replace("\n", "<br>", $conv_text);
  $conv_text = str_replace("''", "'", $conv_text);
  if($neconfig['censor_mode'] > 0) {
    $censorlist = explode("\r\n", $neconfig['censor_list']);
    if(is_array($censorlist)) {
      for($i = 0; $i < count($censorlist); $i++) {
        $replace = str_pad("", strlen($censorlist[$i]), $neconfig['censor_replace']);
        $conv_text = eregi_replace("$censorlist[$i]","$replace", $conv_text);
      }
    }
  }
  return $conv_text;
}

function ne_check_html($str, $strip=0) {
  /* The core of this code has been lifted from phpslash */
  /* which is licenced under the GPL. */
  global $allowed_tags;
  if ($strip < 1) { $html_tags = array(''); } else { $html_tags = $allowed_tags; }
  $str = stripslashes($str);
  // Delete all spaces from html tags .
  $str = eregi_replace("<[[:space:]]*([^>]*)[[:space:]]*>",'<\\1>', $str);
  // Delete all attribs from Anchor, except an href, double quoted.
  $str = eregi_replace("<a[^>]*href[[:space:]]*=[[:space:]]*\"?[[:space:]]*([^\" >]*)[[:space:]]*\"?[^>]*>",'<a href="\\1">', $str);
  // Delete all img tags
  $str = eregi_replace("<[[:space:]]* img[[:space:]]*([^>]*)[[:space:]]*>", '', $str);
  // Delete javascript code from a href tags -- Zhen-Xjell @ http://nukecops.com
  $str = eregi_replace("<a[^>]*href[[:space:]]*=[[:space:]]*\"?javascript[[:punct:]]*\"?[^>]*>", '', $str);
  $tmp = "";
  while (ereg("<(/?[[:alpha:]]*)[[:space:]]*([^>]*)>",$str,$reg)) {
      $i = strpos($str,$reg[0]);
      $l = strlen($reg[0]);
      if ($reg[1][0] == "/") $tag = strtolower(substr($reg[1],1));
      else $tag = strtolower($reg[1]);
      if ($a = $html_tags[$tag]) {
          if ($reg[1][0] == "/") $tag = "</$tag>";
          elseif (($a == 1) || ($reg[2] == "")) $tag = "<$tag>";
          else {
              # Place here the double quote fix function.
              $attrb_list=delQuotes($reg[2]);
              // A VER
              $attrb_list = ereg_replace("&","&amp;",$attrb_list);
              $tag = "<$tag" . $attrb_list . ">";
          }
      } # Attribs in tag allowed
      else $tag = "";
      $tmp .= substr($str,0,$i) . $tag;
      $str = substr($str,$i+$l);
  }
  $str = $tmp . $str;
  /* Squash PHP tags unconditionally */
  $str = ereg_replace("<\?","",$str);
  //$str = addslashes($str);
  return $str;
}

function NE_Admin($netitle="") {
  global $db, $prefix, $admin_file, $ne_config;
  OpenTable();
  $num1 = $db->sql_numrows($db->sql_query("SELECT * FROM `".$prefix."_queue`"));
  $num2 = $db->sql_numrows($db->sql_query("SELECT * FROM `".$prefix."_stories`"));
  $num3 = $db->sql_numrows($db->sql_query("SELECT * FROM `".$prefix."_autonews`"));
  $num4 = $db->sql_numrows($db->sql_query("SELECT * FROM `".$prefix."_stories_cat`"));
  $num5 = $db->sql_numrows($db->sql_query("SELECT * FROM `".$prefix."_topics`"));
  $num6 = $db->sql_numrows($db->sql_query("SELECT * FROM `".$prefix."_comments`"));
  echo "<table border='0' cellpadding='3' cellspacing='3' width='100%'>\n";
  if(empty($netitle)) {
    echo "<tr><td align='center' colspan='5' class='title'>"._NE_NSNNEWS." ".$ne_config['version_number']." "._NE_ADMIN."</td></tr>\n";
  } else {
    echo "<tr><td align='center' colspan='5' class='title'>".$netitle."</td></tr>\n";
  }
  echo "<tr><td align='center' colspan='5'><a href='".$admin_file.".php?op=NEConfig'>"._NE_NSNNEWS." "._NE_CONFIG."</a></td></tr>\n";
  echo "<tr>\n<td align='center' valign='top' width='20%'>\n";
  echo "<a href='".$admin_file.".php?op=NEStoryAdd'>"._NE_STORYADD."</a><br>\n";
  echo "<a href='".$admin_file.".php?op=NEStoryIndex'>"._NE_STORIES."</a> ($num2)<br>\n";
  echo "</td>\n<td align='center' valign='top' width='20%'>\n";
  echo "<a href='".$admin_file.".php?op=NECategoryAdd'>"._NE_CATEGORYADD."</a><br>\n";
  echo "<a href='".$admin_file.".php?op=NECategoryIndex'>"._NE_CATEGORIES."</a> ($num4)<br>\n";
  echo "</td>\n<td align='center' valign='top' width='20%'>\n";
  echo "<a href='".$admin_file.".php?op=NETopicAdd'>"._NE_TOPICADD."</a><br>\n";
  echo "<a href='".$admin_file.".php?op=NETopicIndex'>"._NE_TOPICS."</a> ($num5)<br>\n";
  echo "</td>\n<td align='center' valign='top' width='20%'>\n";
  echo "<a href='".$admin_file.".php?op=NEProgramedIndex'>"._NE_PROGRAMED."</a> ($num3)<br>\n";
  echo "<a href='".$admin_file.".php?op=NESubmissionIndex'>"._NE_SUBMISSIONS."</a> ($num1)<br>\n";
  echo "</td>\n<td align='center' valign='top' width='20%'>\n";
  echo "<a href='".$admin_file.".php?op=NECommentIndex'>"._NE_COMMENTS."</a> ($num6)<br>\n";
  echo "</td>\n</tr>\n";
  echo "<tr><td align='center' colspan='5'><a href='".$admin_file.".php'>"._NE_SITEADMIN."</a></td></tr>\n";
  echo "</table>\n";
  CloseTable();
}

function nepagenums($op, $totalselected, $perpage, $max) {
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
    echo "<table align='center' border='0' cellpadding='2' cellspacing='2'>\n<tr>\n";
    echo "<form action='".$admin_file.".php?op=$op' method='post'>\n";
    echo "<input type='hidden' name='min' value='".(($max - $perpage) - $perpage)."'>\n";
    echo "<td width='33%'>";
    if($currentpage <= 1) {
      echo "&nbsp;";
    } else {
      echo "<input type='submit' value='"._NE_PREVPAGE."'>";
    }
    echo "</td>\n";
    echo "</form>\n";
    echo "<form action='".$admin_file.".php?op=$op' method='post'>\n";
    echo "<td align='center' width=34%'><nobr><b>"._NE_SELECTPAGE.":</b> <select name='min'>\n";
    while ($counter <= $pages ) {
      $cpage = $counter;
      $mintemp = ($perpage * $counter) - $perpage;
      echo "<option value='$mintemp'";
      if($counter == $currentpage) { echo " selected"; }
      echo ">$counter</option>\n";
      $counter++;
    }
    echo "</select><b> "._NE_OF." $pages "._NE_PAGES."</b> <input type='submit' value='"._NE_GO."'></nobr></td>\n";
    echo "</form>\n";
    echo "<form action='".$admin_file.".php?op=$op' method='post'>\n";
    echo "<input type='hidden' name='min' value='".($max)."'>\n";
    echo "<td align='right' width='33%'>";
    if($currentpage >= $pages) {
      echo "&nbsp;";
    } else {
      echo "<input type='submit' value='"._NE_NEXTPAGE."'>";
    }
    echo "</td>\n";
    echo "</form>\n";
    echo "</tr>\n</table>\n";
  }
}

function ne_format_url($comment) {
  global $nukeurl;
  unset($location);
  $links = array();
  $hrefs = array();
  $pos = 0;
  while(!(($pos = strpos($comment, "<", $pos)) === false)) {
    $pos++;
    $endpos = strpos($comment, ">", $pos);
    $tag = substr($comment, $pos, $endpos-$pos);
    $tag = trim($tag);
    if(isset($location)) {
      if(!strcasecmp(strtok($tag, " "), "/A")) {
        $link = substr($comment, $linkpos, $pos-1-$linkpos);
        $links[] = $link;
        $hrefs[] = $location;
        unset($location);
      }
      $pos = $endpos+1;
    } else {
      if(!strcasecmp(strtok($tag, " "), "A")) {
        if(eregi("HREF[ \t\n\r\v]*=[ \t\n\r\v]*\"([^\"]*)\"", $tag, $regs));
        else if(eregi("HREF[ \t\n\r\v]*=[ \t\n\r\v]*([^ \t\n\r\v]*)", $tag, $regs));
        else $regs[1] = "";
        if($regs[1]) { $location = $regs[1]; }
        $pos = $endpos+1;
        $linkpos = $pos;
      } else {
        $pos = $endpos+1;
      }
    }
  }
  for($i=0; $i<sizeof($links); $i++) {
    if(!eregi("http://", $hrefs[$i])) {
      $hrefs[$i] = $nukeurl;
    } elseif(!eregi("mailto://", $hrefs[$i])) {
      $href = explode("/", $hrefs[$i]);
      $href = " [$href[2]]";
      $comment = ereg_replace(">$links[$i]</a>", " title='$hrefs[$i]'> $links[$i]</a>$href", $comment);
    }
  }
  return($comment);
}

function DisplayKids ($tid, $mode, $order=0, $thold=0, $level=0, $dummy=0, $tblwidth=100) {
  global $user_prefix, $admin, $datetime, $user, $cookie, $bgcolor1, $bgcolor2, $bgcolor4, $reasons, $anonymous, $neconfig, $prefix, $textcolor2, $db, $module_name, $admin_file, $moderate, $reasons;
  $comments = 0;
  cookiedecode($user);
  $result = $db->sql_query("SELECT * FROM `".$prefix."_comments` WHERE `pid`='$tid' ORDER BY `date`, `tid`");
  if($mode == 'nested') {
    while($row = $db->sql_fetchrow($result)) {
      $r_tid = intval($row['tid']);
      $r_pid = intval($row['pid']);
      $r_sid = intval($row['sid']);
      $r_date = $row['date'];
      $r_name = ne_check_html(ne_convert_text($row['name']), 0);
      $r_email = ne_check_html(ne_convert_text($row['email']), 0);
      $r_host_name = $row['host_name'];
      $r_subject = ne_check_html(ne_convert_text($row['subject']), 0);
      $r_comment = ne_check_html(ne_convert_text($row['comment']), 1);
      $r_score = intval($row['score']);
      $r_reason = intval($row['reason']);
      if($r_score >= $thold) {
        if(isset($level)) { if(!$comments) { $tblwidth -= 5; } }
        $comments++;
        if(!eregi("[a-z0-9]",$r_name)) $r_name = $anonymous;
        if(!eregi("[a-z0-9]",$r_subject)) $r_subject = "["._NE_NOSUBJECT."]";
        $r_bgcolor = ($dummy%2)?$bgcolor4:$bgcolor2;
        echo "<a name=\"$r_tid\"></a>\n";
        echo "<table border=\"0\" width=\"100%\">\n<tr>\n";
        echo "<td width=\"".(100-$tblwidth)."%\">&nbsp;</td>\n";
        echo "<td bgcolor=\"$r_bgcolor\" width=\"".$tblwidth."%\">";
        formatTimestamp($r_date);
        echo "<b>$r_subject</b> <font class=\"content\">";
        if(!$cookie[7]) {
          echo "("._NE_SCORE.": $r_score";
          if($r_reason>0) echo ", $reasons[$r_reason]";
          echo ")";
        }
        if($r_email) {
          echo "<br>\n"._NE_BY." <a href=\"mailto:$r_email\">$r_name</a> <font class=\"content\"><b>($r_email)</b></font> "._NE_ON." $datetime";
        } else {
          echo "<br>\n"._NE_BY." $r_name "._NE_ON." $datetime";
        }
        if($r_name != $anonymous) {
          $row2 = $db->sql_fetchrow($db->sql_query("SELECT user_id FROM ".$user_prefix."_users WHERE username='$r_name'"));
          $r_uid = intval($row2['user_id']);
          echo "<br>\n(<a href=\"modules.php?name=Your_Account&amp;op=userinfo&amp;username=$r_name\">"._NE_USERINFO."</a> | <a href=\"modules.php?name=Private_Messages&amp;mode=post&amp;u=$r_uid\">"._NE_SENDAMSG."</a>) ";
        }
        $row_url = $db->sql_fetchrow($db->sql_query("SELECT user_website FROM ".$user_prefix."_users WHERE username='$r_name'"));
        $url = stripslashes($row_url['user_website']);
        if($url != "http://" AND $url != "" AND eregi("http://", $url)) { echo "<a href=\"$url\" target=\"new\">$url</a> "; }
        if(is_admin($admin)) { echo "<br>\n<b>("._NE_IP.": $r_host_name)</b>"; }
        echo "</font></td>\n</tr>\n<tr>\n";
        echo "<td width=\"".(100-$tblwidth)."%\">&nbsp;</td>\n";
        echo "<td width=\"".$tblwidth."%\">";
        if(($cookie[10]) && (strlen($r_comment) > $cookie[10])) echo substr("$r_comment", 0, $cookie[10])."<br><br><b><a href=\"modules.php?name=$module_name&amp;op=NEComment&amp;tid=$r_tid\" target=\"_blank\">"._NE_READREST."</a></b><br>\n<br>\n";
        elseif(strlen($r_comment) > $neconfig['comment_limit']) echo substr("$r_comment", 0, $neconfig['comment_limit'])."<br><br><b><a href=\"modules.php?name=$module_name&amp;op=NEComment&amp;tid=$r_tid\" target=\"_blank\">"._NE_READREST."</a></b><br>\n<br>\n";
        else echo $r_comment."<br>\n<br>\n";
        echo "<font class=\"content\"> [ ";
        if($neconfig['anonymous_post']==1 OR is_admin($admin) OR is_user($user)) {
          echo "<a href=\"modules.php?name=$module_name&amp;op=NEReply&amp;pid=$r_tid&amp;sid=$r_sid&amp;mode=$mode&amp;order=$order&amp;thold=$thold\">"._NE_REPLYTOTHIS."</a>";
        } else {
          echo ""._NE_REPLYTOTHIS."";
        }
        if(((isset($admin) && $moderate == 1) || $moderate == 2) && $user) {
          echo " | <select name=dkn$tid>";
          for($i=0; $i<sizeof($reasons); $i++) { echo "<option value=\"$score:$i\">$reasons[$i]</option>\n"; }
          echo "</select>";
        }
        if(is_admin($admin)) {
          echo " | <a href=\"".$admin_file.".php?op=NECommentDelete&amp;tid=$r_tid&amp;sid=$r_sid\">"._DELETE."</a>";
          echo " | <a href=\"".$admin_file.".php?op=NECommentEdit&amp;tid=$r_tid\">"._EDIT."</a>";
        }
        echo " ]</font>";
        echo "</td>\n</tr>\n</table>\n\n";
        echo "<br>\n\n";
        DisplayKids($r_tid, $mode, $order, $thold, $level+1, $dummy+1, $tblwidth);
      }
    }
  } elseif($mode == 'flat') {
    while($row = $db->sql_fetchrow($result)) {
      $r_tid = intval($row['tid']);
      $r_pid = intval($row['pid']);
      $r_sid = intval($row['sid']);
      $r_date = $row['date'];
      $r_name = ne_check_html(ne_convert_text($row['name']), 0);
      $r_email = ne_check_html(ne_convert_text($row['email']), 0);
      $r_host_name = $row['host_name'];
      $r_subject = ne_check_html(ne_convert_text($row['subject']), 0);
      $r_comment = ne_check_html(ne_convert_text($row['comment']), 1);
      $r_score = intval($row['score']);
      $r_reason = intval($row['reason']);
      if($r_score >= $thold) {
        if(!eregi("[a-z0-9]",$r_name)) $r_name = $anonymous;
        if(!eregi("[a-z0-9]",$r_subject)) $r_subject = "["._NE_NOSUBJECT."]";
        echo "<a name=\"$r_tid\">\n";
        echo "<hr><table width=\"100%\" border=\"0\">\n<tr bgcolor=\"$bgcolor2\">\n<td>";
        formatTimestamp($r_date);
        if($r_email) {
          echo "<b>$r_subject</b> <font class=\"content\">";
          if(!$cookie[7]) {
            echo "("._NE_SCORE.": $r_score";
            if($r_reason>0) echo ", $reasons[$r_reason]";
            echo ")";
          }
          echo "<br>\n"._NE_BY." <a href=\"mailto:$r_email\">$r_name</a> <font class=\"content\"><b>($r_email)</b></font> "._NE_ON." $datetime";
        } else {
          echo "<b>$r_subject</b> <font class=\"content\">";
          if(!$cookie[7]) {
            echo "("._NE_SCORE.": $r_score";
            if($r_reason>0) echo ", $reasons[$r_reason]";
            echo ")";
          }
          echo "<br>\n"._NE_BY." $r_name "._NE_ON." $datetime";
        }
        if($r_name != $anonymous) {
          $row3 = $db->sql_fetchrow($db->sql_query("SELECT user_id FROM ".$user_prefix."_users WHERE username='$r_name'"));
          $ruid = intval($row3['user_id']);
          echo "<br>\n(<a href=\"modules.php?name=Your_Account&amp;op=userinfo&amp;username=$r_name\">"._NE_USERINFO."</a> | <a href=\"modules.php?name=Private_Messages&amp;mode=post&amp;u=$ruid\">"._NE_SENDAMSG."</a>) ";
        }
        $row_url2 = $db->sql_fetchrow($db->sql_query("SELECT user_website FROM ".$user_prefix."_users WHERE username='$r_name'"));
        $url = stripslashes($row_url2['user_website']);
        if($url != "http://" AND $url != "" AND eregi("http://", $url)) { echo "<a href=\"$url\" target=\"new\">$url</a> "; }
        if(is_admin($admin)) { echo "<br>\n<b>("._NE_IP.": $r_host_name)</b>"; }
        echo "</font></td>\n</tr>\n<tr>\n<td>";
        if(($cookie[10]) && (strlen($r_comment) > $cookie[10])) echo substr("$r_comment", 0, $cookie[10])."<br><br><b><a href=\"modules.php?name=$module_name&amp;op=NEComment&amp;tid=$r_tid\" target=\"_blank\">"._NE_READREST."</a></b><br>\n<br>\n";
        elseif(strlen($r_comment) > $neconfig['comment_limit']) echo substr("$r_comment", 0, $neconfig['comment_limit'])."<br><br><b><a href=\"modules.php?name=$module_name&amp;op=NEComment&amp;tid=$r_tid\" target=\"_blank\">"._NE_READREST."</a></b><br>\n<br>\n";
        else echo $r_comment."<br>\n<br>\n";
        echo "<font class=\"content\"> [ ";
        if($neconfig['anonymous_post']==1 OR is_admin($admin) OR is_user($user)) {
          echo "<a href=\"modules.php?name=$module_name&amp;op=NEReply&amp;pid=$r_tid&amp;sid=$r_sid&amp;mode=$mode&amp;order=$order&amp;thold=$thold\">"._NE_REPLYTOTHIS."</a>";
        } else {
          echo ""._NE_REPLYTOTHIS."";
        }
        if((((isset($admin)) && ($moderate == 1)) || ($moderate == 2)) && ($user)) {
          echo " | <select name='dkn'$tid>";
          for($i=0; $i<sizeof($reasons); $i++) {
            echo "<option value=\"$score:$i\">$reasons[$i]</option>\n";
          }
          echo "</select>";
        }
        if(is_admin($admin)) {
          echo " | <a href=\"".$admin_file.".php?op=NECommentDelete&amp;tid=$r_tid&amp;sid=$r_sid\">"._DELETE."</a>";
          echo " | <a href=\"".$admin_file.".php?op=NECommentEdit&amp;tid=$r_tid\">"._EDIT."</a>";
        }
        echo " ]</font>";
        echo "</td>\n</tr>\n</table>\n";
        DisplayKids($r_tid, $mode, $order, $thold);
      }
    }
  } else { // threaded
    while($row = $db->sql_fetchrow($result)) {
      $r_tid = intval($row['tid']);
      $r_pid = intval($row['pid']);
      $r_sid = intval($row['sid']);
      $r_date = $row['date'];
      $r_name = ne_check_html(ne_convert_text($row['name']), 0);
      $r_email = ne_check_html(ne_convert_text($row['email']), 0);
      $r_host_name = $row['host_name'];
      $r_subject = ne_check_html(ne_convert_text($row['subject']), 0);
      $r_comment = ne_check_html(ne_convert_text($row['comment']), 1);
      $r_score = intval($row['score']);
      $r_reason = intval($row['reason']);
      if($r_score >= $thold) {
        if(isset($level)) { if(!$comments) { $tblwidth -= 5; } }
        $comments++;
        if(!eregi("[a-z0-9]",$r_name)) $r_name = $anonymous;
        if(!eregi("[a-z0-9]",$r_subject)) $r_subject = "["._NE_NOSUBJECT."]";
        formatTimestamp($r_date);
        echo "<table border=\"0\" width=\"100%\">\n<tr>\n";
        echo "<td width=\"".(100-$tblwidth)."%\">&nbsp;</td>\n";
        echo "<td width=\"".$tblwidth."%\">";
        echo "<font class=\"content\" color=\"$textcolor2\"><a href=\"modules.php?name=$module_name&amp;op=NECommentShow&amp;tid=$r_tid&amp;sid=$r_sid&amp;pid=$r_pid&amp;mode=$mode&amp;order=$order&amp;thold=$thold#$r_tid\">$r_subject</a> "._NE_BY." $r_name "._NE_ON." $datetime</font>";
        echo "</td>\n";
        echo "</tr>\n</table>\n";
        DisplayKids($r_tid, $mode, $order, $thold, $level+1, $dummy+1, $tblwidth);
      }
    }
  }
  $db->sql_freeresult($result);
}

function ne_copy() {
  global $modname;
  $cpname = ereg_replace("_", " ", $modname);
  $pcname = $modname;
  echo "<script type=\"text/javascript\">\n";
  echo "<!--\n";
  echo "function nsnnewindow(){\n";
  echo "  window.open (\"modules/$pcname/copyright.php\",\"Copyright\",\"toolbar=no,location=no,directories=no,status=no,scrollbars=yes,resizable=no,copyhistory=no,height=200,width=400,screenX=100,left=100,screenY=100,top=100\");\n";
  echo "}\n";
  echo "//-->\n";
  echo "</SCRIPT>\n\n";
  echo "<div align=\"right\"><a href=\"javascript:nsnnewindow()\">$cpname &copy;</a></div>";
}

?>