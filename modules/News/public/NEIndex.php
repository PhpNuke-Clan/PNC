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
if(isset($cookie[3]) && $user_news == 1) { $storynum = $cookie[3]; }
elseif (isset($cookie[3]) && $user_news == 0) { $storynum = $neconfig['homenumber']; }
else { $storynum = $neconfig['homenumber']; } 

if(!isset($min)) { $min = 0; }
if(!isset($max)) { $max = $min + $storynum; }
if($multilingual == 1) {
  if($home == 1 || defined('HOME_FILE')) {
    $querylang = "WHERE (`alanguage`='$currentlang' OR `alanguage`='') AND `ihome`='0'";
  } else {
    $querylang = "WHERE (`alanguage`='$currentlang' OR `alanguage`='')";
  }
} else {
  if($home == 1 || defined('HOME_FILE')) {
    $querylang = "WHERE `ihome`='0'";
  } else {
    $querylang = "";
  }
}
include("header.php");
if($neconfig['readmore'] == 1) {
  echo "<script language='JavaScript'>\n";
  echo "<!-- Begin\n";
  echo "function NewsReadWindow(mypage, myname, w, h, scroll) {\n";
  echo "var winl = (screen.width - w) / 2;\n";
  echo "var wint = (screen.height - h) / 2;\n";
  echo "winprops = 'height='+h+',width='+w+',top='+wint+',left='+winl+',scrollbars='+scroll+''\n";
  echo "win = window.open(mypage, myname, winprops)\n";
  echo "if(parseInt(navigator.appVersion) >= 4) { win.window.focus(); }\n";
  echo "}\n";
  echo "//  End -->\n";
  echo "</script>\n";
}
if($neconfig['hometopic'] > 0 AND ($home == 1 || defined('HOME_FILE'))) { // One Topic on Home
  if(empty($querylang)) { $querylang = "WHERE `topic`='".$neconfig['hometopic']."'"; } else { $querylang .= " AND `topic`='".$neconfig['hometopic']."'"; }
}
$totalarticles = $db->sql_numrows($db->sql_query("SELECT * FROM `".$prefix."_stories` $querylang"));
if($neconfig['columns'] == 1) { // DUAL
  echo "<table border='0' cellpadding='0' cellspacing='0' width='100%'>\n";
}
$a = 0;
$result = $db->sql_query("SELECT * FROM `".$prefix."_stories` $querylang ORDER BY `sid` DESC LIMIT $min,$storynum");
while($artinfo = $db->sql_fetchrow($result)) {
  formatTimestamp($artinfo['time']);
  $subject = ne_check_html(ne_convert_text($subject, "nohtml"), 0);
  $artinfo['hometext'] = stripslashes(ne_check_html(ne_convert_text($artinfo['hometext']), 1));
  $artinfo['bodytext'] = stripslashes(ne_check_html(ne_convert_text($artinfo['bodytext']), 1));
  $artinfo['notes'] = stripslashes(ne_check_html(ne_convert_text($artinfo['notes']), 1));
  $artinfo['sid'] = intval($artinfo['sid']);
  $artinfo['catid'] = intval($artinfo['catid']);
  $artinfo['aid'] = ne_check_html(ne_convert_text($artinfo['aid']), 0);
  $artinfo['title'] = stripslashes(ne_check_html(ne_convert_text($artinfo['title']), 0));
  $artinfo['comments'] = intval($artinfo['comments']);
  $artinfo['counter'] = intval($artinfo['counter']);
  $artinfo['topic'] = intval($artinfo['topic']);
  $artinfo['informant'] = ne_check_html(ne_convert_text($artinfo['informant']), 0);
  $artinfo['acomm'] = intval($artinfo['acomm']);
  $artinfo['score'] = intval($artinfo['score']);
  $artinfo['ratings'] = intval($artinfo['ratings']);
  getTopics($artinfo['sid']);
  if($neconfig['texttype'] == 0) {
    $introcount = strlen($artinfo['hometext']);
    $fullcount = strlen($artinfo['bodytext']);
    $totalcount = $introcount + $fullcount;
  } else {
    $introcount = strlen(strip_tags($artinfo['hometext'], "<br>"));
    $ihomecount = strlen($artinfo['hometext']);
    $fullcount = strlen($artinfo['bodytext']);
    $totalcount = $ihomecount + $fullcount;
  }
  $the_icons  = "<a href='".$module_link."op=NEPrint&amp;sid=".$artinfo['sid']."' target='_blank'><img src='modules/$module_name/images/print.png' border='0' alt='"._NE_PRINTER."' title='"._NE_PRINTER."' width='16' height='16'></a>";
  $the_icons .= "&nbsp;<a href='".$module_link."op=NEPortable&amp;sid=".$artinfo['sid']."' target='_blank'><img src='modules/$module_name/images/pdf.png' border='0' alt='"._NE_PDF."' title='"._NE_PDF."' width='16' height='16'></a>";
  if(is_user($user)) {
    $the_icons .= "&nbsp;<a href='".$module_link."op=NEFriend&amp;sid=".$artinfo['sid']."'><img src='modules/$module_name/images/friend.png' border='0' alt='"._NE_FRIENDSEND."' title='"._NE_FRIENDSEND."' width='16' height='16'></a>";
  }
  if(is_admin($admin)) {
    $the_icons .= "&nbsp;<a href='".$admin_file.".php?op=EditStory&amp;sid=".$artinfo['sid']."'><img src='modules/$module_name/images/edit.png' border='0' alt='"._EDIT."' title='"._EDIT."' width='16' height='16'></a>";
    $the_icons .= "&nbsp;<a href='".$admin_file.".php?op=RemoveStory&amp;sid=".$artinfo['sid']."'><img src='modules/$module_name/images/delete.png' border='0' alt='"._DELETE."' title='"._DELETE."' width='16' height='16'></a>";
  }
  $read_link = "<a href='javascript:void()' onclick=\"NewsReadWindow('".$module_link."op=NERead&amp;sid=".$artinfo['sid']."','ReadArticle','600','400','yes');return false;\">";
  $story_link = "<a href='".$module_link."op=NEArticle&amp;sid=".$artinfo['sid']."'>";
  $morelink = "(";
  if($neconfig['texttype'] == 0) {
    if($fullcount > 0 OR $artinfo['comments'] > 0 OR $neconfig['allow_comments'] == 0 OR $artinfo['acomm'] == 1) {
      if($neconfig['readmore'] == 1) {
        $morelink .= "$read_link<b>"._NE_READMORE."</b></a> | ";
      } else {
        $morelink .= "$story_link<b>"._NE_READMORE."</b></a> | ";
      }
    } else { $morelink .= ""; }
  } else {
    if($introcount > 255 OR $fullcount > 0 OR $artinfo['comments'] > 0 OR $neconfig['allow_comments'] == 0 OR $artinfo['acomm'] == 1) {
      if($neconfig['readmore'] == 1) {
        $morelink .= "$read_link<b>"._NE_READMORE."</b></a> | ";
      } else {
        $morelink .= "$story_link<b>"._NE_READMORE."</b></a> | ";
      }
    } else { $morelink .= ""; }
    if($introcount > 255) {
      $artinfo['hometext'] = str_replace("<br>", "\n", $artinfo['hometext']);
      $artinfo['hometext'] = strip_tags($artinfo['hometext']);
      $artinfo['hometext'] = substr($artinfo['hometext'], 0, 255);
      $artinfo['hometext'] = str_replace("\n", "<br>", $artinfo['hometext'])."...";
      $artinfo['hometext'] = str_replace("<br>...", "...", $artinfo['hometext']);
    }
  }
  if($neconfig['texttype'] == 0) {
    if($fullcount > 0) { $morelink .= ($totalcount - $introcount)." "._NE_BYTESMORE." | "; }
  } else {
    if($fullcount > 0 OR $ihomecount > 0) { $morelink .= ($totalcount - $introcount)." "._NE_BYTESMORE." | "; }
  }
  if($neconfig['allow_comments'] == 1 AND $artinfo['acomm'] == 0) {
    if($artinfo['comments'] == 0) {
      $morelink .= "$story_link"._NE_QCOMMENTS."</a>";
    } elseif($artinfo['comments'] == 1) {
      $morelink .= "$story_link".$artinfo['comments']." "._NE_COMMENT."</a>";
    } elseif($artinfo['comments'] > 1) {
      $morelink .= "$story_link".$artinfo['comments']." "._NE_COMMENTS."</a>";
    }
  }
  $sid = intval($artinfo['sid']);
  if($artinfo['catid'] != 0) {
    $result3 = $db->sql_query("SELECT `title` FROM `".$prefix."_stories_cat` WHERE `catid`='".$artinfo['catid']."'");
    $catinfo = $db->sql_fetchrow($result3);
    $db->sql_freeresult($result3);
    $catinfo['title'] = ne_check_html(ne_convert_text($catinfo['title']), 0);
    $morelink .= " | <a href='".$module_link."op=NECategoryList&amp;catid=".$artinfo['catid']."'>".$catinfo['title']."</a>";
  }
  if($artinfo['score'] != 0) {
    $rated = substr($artinfo['score'] / $artinfo['ratings'], 0, 4);
  } else { $rated = 0; }
  $morelink .= " | "._NE_SCORE.": $rated)";
  $morelink .= "<br>".$the_icons;
  $morelink .= "";
  $morelink = str_replace(" |  | ", " | ", $morelink);
  if($neconfig['columns'] == 1) { // DUAL
    if($a == 0) { echo "<tr>\n"; }
    echo "<td valign='top' width='50%'>\n";
    themeindex($artinfo['aid'], $artinfo['informant'], $datetime, $artinfo['title'], $artinfo['counter'], $artinfo['topic'], $artinfo['hometext'], $artinfo['notes'], $morelink, $topicname, $topicimage, $topictext);
    echo "</td>\n";
    $a++;
    if($a == 2) { echo "</tr>\n"; $a = 0; } else { echo "<td>&nbsp;</td>\n"; }
  } else { // SINGLE
    themeindex($artinfo['aid'], $artinfo['informant'], $datetime, $artinfo['title'], $artinfo['counter'], $artinfo['topic'], $artinfo['hometext'], $artinfo['notes'], $morelink, $topicname, $topicimage, $topictext);
  }
}
$db->sql_freeresult($result);

if($neconfig['columns'] == 1) { // DUAL
  if($a == 1) { echo "<td width='50%'>&nbsp;</td>\n</tr>\n"; }
  echo "</table>\n";
}

echo "\n<!-- PAGING -->\n";
//if ($storynum == 0){ $storynum =1;}
$articlepagesint = ($totalarticles / $storynum);
$articlepageremain = ($totalarticles % $storynum);
if($articlepageremain != 0) {
  $articlepages = ceil($articlepagesint);
  if($totalarticles < $storynum) { $articlepageremain = 0; }
} else {
  $articlepages = $articlepagesint;
}
if($articlepages!=1 && $articlepages!=0) {
  echo "<br>\n";
  OpenTable();
  $counter = 1;
  $currentpage = ($max / $storynum);
  echo "<table align='center' border='0' cellpadding='2' cellspacing='2' width='100%'>\n<tr>\n";
  echo "<form action='$form_link' method='post'>\n";
  echo "<input type='hidden' name='min' value='".($min - $storynum)."'>\n";
  echo "<td width='25%'>";
  if($currentpage <= 1) {
    echo "&nbsp;";
  } else {
    echo "<input type='submit' value='"._NE_PREVPAGE."'>";
  }
  echo "</td>\n";
  echo "</form>\n";
  echo "<form action='$form_link' method='post'>\n";
  echo "<td align='center' width='50%'><nobr><b>"._NE_SELECT."</b> <select name='min'>\n";
  while($counter <= $articlepages ) {
    $cpage = $counter;
    $mintemp = ($storynum * $counter) - $storynum;
    if($counter == $currentpage) {
      echo "<option selected>$counter</option>\n";
    } else {
      echo "<option value='$mintemp'>$counter</option>\n";
    }
    $counter++;
  }
  echo "</select><b> "._NE_OF." $articlepages "._NE_PAGES.".</b> <input type='submit' value='"._NE_GO."'></nobr></td>\n";
  echo "</form>\n";
  echo "<form action='$form_link' method='post'>\n";
  echo "<input type='hidden' name='min' value='".($min + $storynum)."'>\n";
  echo "<td align='right' width='50%'>";
  if($currentpage >= $articlepages) {
    echo "&nbsp;";
  } else {
    echo "<input type='submit' value='"._NE_NEXTPAGE."'>";
  }
  echo "</td>\n";
  echo "</form>\n";
  echo "</tr>\n</table>\n";
  CloseTable();
}
echo "<!-- CLOSE PAGING -->\n";
include("footer.php");

?>