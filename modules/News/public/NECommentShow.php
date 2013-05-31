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

if(!defined('NSNNE_PUBLIC')) { die("Illegal File Access Detected!!"); }
$sid = intval($sid);
$tid = intval($tid);
if($pid!=0) { include("header.php"); }
$count_times = 0;
cookiedecode($user);
$q = "SELECT * FROM `".$prefix."_comments` WHERE `sid`='$sid' AND `pid`='$pid'";
if(!empty($thold)) { $q .= " AND `score` >= '$thold'"; } else { $q .= " AND `score` >= '0'"; }
if($order==1) { $q .= " ORDER BY `date` DESC"; }
if($order==2) { $q .= " ORDER BY `score` DESC"; }
$something = $db->sql_query($q);
$num_tid = $db->sql_numrows($something);
if(($acomm == 0) AND ($neconfig['allow_comments'] == 1)) {
  echo "\n\n<!-- COMMENTS NAVIGATION BAR START -->\n\n";
  $sid = intval($sid);
  $query = $db->sql_query("SELECT * FROM `".$prefix."_comments` WHERE `sid`='$sid'");
  $count = 0;
  if($query) { $count = $db->sql_numrows($query); }
  list($untitle) = $db->sql_fetchrow($db->sql_query("SELECT `title` FROM `".$prefix."_stories` WHERE `sid`='$sid'"));
  if(!isset($order)) { $order = $neconfig['default_order']; }
  if(!isset($thold)) { $thold = $neconfig['default_thold']; }
  if(!isset($mode)) { $mode = $neconfig['default_mode']; }
  echo "<a name='comments'></a>\n";
  OpenTable();
  echo "<table width='100%' border='0' cellspacing='2' cellpadding='2'>\n";
  if($untitle) {
    echo "<tr><td bgcolor='$bgcolor2' align='center' class='content'>\"$untitle\" | ";
    if(is_user($user)) {
      echo "<a href='modules.php?name=Your_Account&amp;op=editcomm'>"._NE_CONFIG."</a>";
    } else {
      echo "<a href='modules.php?name=Your_Account'>"._NE_LOGINCREATE."</a>";
    }
    if(($count==1)) {
      echo " | <B>$count</B> "._NE_COMMENT."";
    } else {
      echo " | <B>$count</B> "._NE_COMMENTS."";
    }
    if($count > 1 AND is_active("Search")) { echo " | <a href='modules.php?name=Search&type=comments&sid=$sid'>"._NE_SEARCHDISCUSSION."</a>"; }
    echo "</td></tr>\n";
  }
  echo "<tr>\n";
  echo "<form method='post' action='$form_link'>\n";
  echo "<input type='hidden' name='pid' value='$pid'>\n";
  echo "<input type='hidden' name='sid' value='$sid'>\n";
  echo "<input type='hidden' name='op' value='NEArticle'>\n";
  echo "<td bgcolor='$bgcolor1' align='center' width='100%' class='content'>\n";
  $tsel1 = $tsel2 = $tsel3 = $tsel4 = $tsel5 = $tsel6 = $tsel7 = "";
  if($thold == -1) { $tsel1 = " selected"; }
  elseif($thold == 0) { $tsel2 = " selected"; }
  elseif($thold == 1) { $tsel3 = " selected"; }
  elseif($thold == 2) { $tsel4 = " selected"; }
  elseif($thold == 3) { $tsel5 = " selected"; }
  elseif($thold == 4) { $tsel6 = " selected"; }
  elseif($thold == 5) { $tsel7 = " selected"; }
  echo "<b>"._NE_THRESHOLD.":</b> <select name='thold'>\n";
  echo "<option value='-1'$tsel1>-1</option>\n";
  echo "<option value='0'$tsel2>0</option>\n";
  echo "<option value='1'$tsel3>1</option>\n";
  echo "<option value='2'$tsel4>2</option>\n";
  echo "<option value='3'$tsel5>3</option>\n";
  echo "<option value='4'$tsel6>4</option>\n";
  echo "<option value='5'$tsel7>5</option>\n";
  echo "</select>&nbsp;\n";
  $msel1 = $msel2 = $msel3 = $msel4 = "";
  if($mode == 'nocomments') { $msel1 = " selected"; }
  elseif($mode == 'nested') { $msel2 = " selected"; }
  elseif($mode == 'flat') { $msel3 = " selected"; }
  elseif($mode == 'thread') { $msel4 = " selected"; }
  echo " <b>"._NE_MODE.":</b> <select name='mode'>";
  echo "<option value='nocomments'$msel1>"._NE_NOCOMMENTS."</option>\n";
  echo "<option value='nested'$msel2>"._NE_NESTED."</option>\n";
  echo "<option value='flat'$msel3>"._NE_FLAT."</option>\n";
  echo "<option value='thread'$msel4>"._NE_THREAD."</option>\n";
  echo "</select>&nbsp;\n";
  $osel1 = $osel2 = $osel3 = "";
  if($order == 0) { $osel1 = " selected"; }
  elseif($order == 1) { $osel2 = " selected"; }
  elseif($order == 2) { $osel3 = " selected"; }
  echo " <b>"._NE_ORDER.":</b> <select name='order'>";
  echo "<option value='0'$osel1>"._NE_OLDEST."</option>\n";
  echo "<option value='1'$osel2>"._NE_NEWEST."</option>\n";
  echo "<option value='2'$osel3>"._NE_HIGHEST."</option>\n";
  echo "</select>\n";
  echo "<input type='hidden' name='sid' value='$sid'>\n";
  echo "<input type='submit' value='"._NE_REFRESH."'>\n";
  echo "</td>\n</form>\n";
  echo "</tr>\n";
  if($neconfig['anonymous_post']==1 OR is_user($user)) {
    echo "<tr><form action='$form_link' method='post'>\n";
    echo "<input type='hidden' name='pid' value='$pid'>";
    echo "<input type='hidden' name='sid' value='$sid'>";
    echo "<input type='hidden' name='op' value='NEReply'>";
    echo "<td bgcolor='$bgcolor1' align='center' class='content'>\n";
    echo "&nbsp;&nbsp;<input type='submit' value='"._NE_REPLYMAIN."'>";
    echo "</td>\n";
    echo "</form></tr>\n";
  } else {
    echo "<tr><td align='center' class='title'>"._NE_NOANONCOMMENTS."</td></tr>\n";
  }
  echo "</td></tr>\n";
  echo "<tr><td bgcolor='$bgcolor2' align='center'>"._NE_OWNEDBYPOSTER."</td></tr>\n";
  echo "</table>\n";
  CloseTable();
  echo "\n\n<!-- COMMENTS NAVIGATION BAR END -->\n\n";

  while($count_times < $num_tid) {
    echo "<br>\n";
    OpenTable();
    $row_q = $db->sql_fetchrow($something);
    $tid = intval($row_q['tid']);
    $pid = intval($row_q['pid']);
    $sid = intval($row_q['sid']);
    $date = $row_q['date'];
    $c_name = stripslashes($row_q['name']);
    $email = stripslashes($row_q['email']);
    $host_name = $row_q['host_name'];
    $subject = stripslashes(check_html($row_q['subject'], "nohtml"));
    $comment = stripslashes($row_q['comment']);
    $score = intval($row_q['score']);
    $reason = intval($row_q['reason']);
    if($c_name == "") { $c_name = $anonymous; }
    if($subject == "") { $subject = "["._NE_NOSUBJECT."]"; }
    echo "<a name=\"$tid\"></a>\n";
    echo "<table width=\"100%\" border=\"0\">\n<tr bgcolor=\"$bgcolor4\">\n<td>";
    formatTimestamp($date);
    echo "<b>$subject</b> ";
    if(!$cookie[7]) {
      echo "("._NE_SCORE.": $score";
      if($reason>0) echo ", $reasons[$reason]";
      echo ")";
    }
    if($email) {
      echo "<br>\n"._NE_BY." <a href=\"mailto:$email\">$c_name</a> <i>($email)</i> "._NE_ON." $datetime";
    } else {
      echo "<br>\n"._NE_BY." $c_name "._NE_ON." $datetime";
    }
    if(is_active("Journal")) {
      $row = $db->sql_fetchrow($db->sql_query("SELECT jid FROM ".$prefix."_journal WHERE aid='$c_name' AND status='yes' ORDER BY pdate,jid DESC LIMIT 0,1"));
      $jid = intval($row['jid']);
      $journal = "";
      if($jid != "" AND isset($jid)) {
        $journal = " | <a href=\"modules.php?name=Journal&amp;file=display&amp;jid=$jid\">"._JOURNAL."</a>";
      }
    }
    if($c_name != $anonymous) {
      $row2 = $db->sql_fetchrow($db->sql_query("SELECT user_id FROM ".$user_prefix."_users WHERE username='$c_name'"));
      $r_uid = intval($row2['user_id']);
      echo "<br>\n(<a href=\"modules.php?name=Your_Account&amp;op=userinfo&amp;username=$c_name\">"._NE_USERINFO."</a> | <a href=\"modules.php?name=Private_Messages&amp;mode=post&amp;u=$r_uid\">"._NE_SENDAMSG."</a>$journal) ";
    }
    $row_url = $db->sql_fetchrow($db->sql_query("SELECT user_website FROM ".$user_prefix."_users WHERE username='$c_name'"));
    $url = stripslashes($row_url['user_website']);
    if($url != "http://" AND $url != "" AND eregi("http://", $url)) { echo "<a href=\"$url\" target=\"new\">$url</a> "; }
    if(is_admin($admin)) { echo "<br>\n(IP: $host_name)"; }
    echo "</td>\n</tr>\n<tr>\n<td>";
    if(($cookie[10]) && (strlen($comment) > $cookie[10])) echo substr("$comment", 0, $cookie[10])."<br><br><b><a href=\"modules.php?name=$module_name&amp;op=NEComment&amp;sid=$sid&tid=$tid&mode=$mode&order=$order&thold=$thold\" target=\"_blank\">"._NE_READREST."</a></b><br>\n<br>\n";
    elseif(strlen($comment) > $neconfig['comment_limit']) echo substr("$comment", 0, $neconfig['comment_limit'])."<br><br><b><a href=\"modules.php?name=$module_name&amp;op=NEComment&amp;sid=$sid&tid=$tid&mode=$mode&order=$order&thold=$thold\" target=\"_blank\">"._NE_READREST."</a></b><br>\n<br>\n";
    else echo $comment."<br>\n<br>\n";
    echo "<font class=\"content\"> [ ";
    if($neconfig['anonymous_post']==1 OR is_user($user)) {
      echo "<a href=\"modules.php?name=$module_name&amp;op=NEReply&amp;pid=$tid&amp;sid=$sid&amp;mode=$mode&amp;order=$order&amp;thold=$thold\">"._NE_REPLY."</a>";
    } else {
      echo ""._NE_REPLY."";
    }
    if($pid != 0) {
      $row4 = $db->sql_fetchrow($db->sql_query("SELECT pid FROM ".$prefix."_comments WHERE tid='$pid'"));
      $erin = intval($row4['pid']);
      echo " | <a href=\"modules.php?name=$module_name&amp;op=NECommentShow&amp;sid=$sid&amp;pid=$erin&amp;mode=$mode&amp;order=$order&amp;thold=$thold\">"._NE_PARENT."</a>";
    }

    if(is_admin($admin)) {
      echo " | <a href=\"".$admin_file.".php?op=NECommentDelete&amp;tid=$tid&amp;sid=$sid\">"._NE_DELETE."</a>";
      echo " | <a href=\"".$admin_file.".php?op=NECommentEdit&amp;tid=$tid\">"._NE_EDIT."</a>";
    }
    echo " ]</font>";
    echo "</td>\n</tr>\n</table>\n\n";
    if($mode == 'nested') { echo "<br>\n\n"; }
    DisplayKids($tid, $mode, $order, $thold, $level, 0, 95);
    if($hr) { echo "<hr noshade size=\"1\">\n"; }
    $count_times += 1;
    CloseTable();
  }
} else {
  OpenTable();
  echo "<center><font class=\"content\">"._NE_NOCOMMENTSACT."</font></center>\n";
  CloseTable();
}

if($pid==0) {
  return array($sid, $pid, $subject);
} else {
  include("footer.php");
}

?>