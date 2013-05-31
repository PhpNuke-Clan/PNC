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

include_once("mainfile.php");
include_once("includes/counter.php");
get_lang("News");
$sitename = superhtmlentities($sitename);
$backend_title = superhtmlentities($backend_title);
$last_built = date("D, d M Y H:i:s T");
$copy_year = _NE_COPYRIGHT." ".date("Y");

function superhtmlentities($text) {
  // Thanks to mirrorball_girl for this
  $entities = array(128 => 'euro', 130 => 'sbquo', 131 => 'fnof', 132 => 'bdquo', 133 => 'hellip', 134 => 'dagger', 135 => 'Dagger', 136 => 'circ', 137 => 'permil', 138 => 'Scaron', 139 => 'lsaquo', 140 => 'OElig', 145 => 'lsquo', 146 => 'rsquo', 147 => 'ldquo', 148 => 'rdquo', 149 => 'bull', 150 => '#45', 151 => 'mdash', 152 => 'tilde', 153 => 'trade', 154 => 'scaron', 155 => 'rsaquo', 156 => 'oelig', 159 => 'Yuml');
  $new_text = '';
  for($i = 0; $i < strlen($text); $i++) {
    $num = ord($text { $i });
    if(array_key_exists($num, $entities)) {
      switch ($num) {
        case 150:
        $new_text .= '-';
        break;
        case 153:
        $new_text .= '(tm)';
        break;
        default:
        $new_text .= '&'.$entities[$num].';';
      }
    } elseif($num < 127 || $num > 159) {
      $new_text .= htmlentities($text { $i });
    }
  }
  $new_text = ereg_replace("  +", " ", $new_text);
  ## remove double spaces.
  return $new_text;
}

function doti($str, $len = 500, $dots = "...") {
  // $len=max length of hometext displayed
  if(strlen($str) > $len) {
    // $dot = " whatever you want here ")
    $str = explode(".", $str);
    // Displayed at the end of hometext
    $dotlen = strlen($dots);
    $str = substr_replace($str[0].$str[1].$str[2].$str[3].$str[4], $dots, $len - $dotlen);
  }
  return $str;
}

header("Content-Type: text/xml");
$cat = intval($cat);
$topic = intval($topic);
if($cat != "") {
  $sql = "SELECT * FROM ".$prefix."_stories WHERE catid='$catid' ORDER BY sid DESC LIMIT 10";
  $result = $db->sql_query($sql);
} elseif($topic != "") {
  $sql = "SELECT * FROM ".$prefix."_stories WHERE topic='$topic' ORDER BY sid DESC LIMIT 10";
  $result = $db->sql_query($sql);
} else {
  $sql = "SELECT * FROM ".$prefix."_stories ORDER BY sid DESC LIMIT 10";
  $result = $db->sql_query($sql);
}
echo "<?xml version=\"1.0\"?>\n\n";
echo "<rss version=\"2.0\">\n\n";
echo "  <channel>\n";
echo "    <title>".htmlspecialchars($sitename)."</title>\n";
echo "    <link>$nukeurl</link>\n";
echo "    <description>".htmlspecialchars($backend_title)."</description>\n";
echo "    <copyright>$copy_year $sitename</copyright>\n";
echo "    <generator>$sitename</generator>\n";
echo "    <language>$backend_language</language>\n";
echo "    <lastBuildDate>$last_built</lastBuildDate>\n";
echo "    <managingEditor>$adminmail</managingEditor>\n";
echo "    <webMaster>$adminmail</webMaster>\n";
echo "    <ttl>60</ttl>\n\n";
echo "    <image>\n";
echo "      <title>".htmlspecialchars($sitename)."</title>\n";
echo "      <url>$nukeurl/images/powered/nukescripts.png</url>\n";
echo "      <link>$nukeurl</link>\n";
echo "      <width>94</width>\n";
echo "      <height>15</height>\n";
echo "      <description>".htmlspecialchars($backend_title)."</description>\n";
echo "    </image>\n\n";
while($row = $db->sql_fetchrow($result)) {
  $title = $row[title];
  $title = str_replace("&trade;", "(tm)", $title);
  $title = superhtmlentities($title);
  $hometext = $row[hometext];
  $hometext = check_html($hometext, "nohtml");
  $hometext = doti($hometext);
  $hometext = str_replace("&trade;", "(tm)", $hometext);
  $hometext = htmlspecialchars(superhtmlentities($hometext));
  $pubdate = date("D, d M Y H:i:s T", strtotime($row['time']));
  echo "    <item>\n";
  echo "      <title>".htmlspecialchars($title)."</title>\n";
  echo "      <link>$nukeurl/modules.php?name=News&amp;op=NEArticle&amp;sid=$row[sid]</link>\n";
  echo "      <description>$hometext</description>\n";
  echo "      <pubDate>$pubdate</pubDate>\n";
  echo "      <guid>$nukeurl/modules.php?name=News&amp;op=NEArticle&amp;sid=$row[sid]</guid>\n";
  echo "    </item>\n\n";
}
echo "    </channel>\n\n";
echo "</rss>";

?>