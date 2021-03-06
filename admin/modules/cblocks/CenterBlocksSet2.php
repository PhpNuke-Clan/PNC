<?php

/********************************************************/
/* NSN Center Blocks                                    */
/* By: NukeScripts Network (webmaster@nukescripts.net)  */
/* http://www.nukescripts.net                           */
/* Copyright � 2000-2005 by NukeScripts Network         */
/********************************************************/
/* Original by: Richard Benfield                        */
/* http://www.benfield.ws                               */
/********************************************************/

include("header.php");
title(_CB_ADMIN2);
CBMenu();
echo"<br>\n";
CBSample(2);
OpenTable();
title(_CB_CONFIG2);
$cbinfo = $db->sql_fetchrow($db->sql_query("SELECT * FROM `".$prefix."_nsncb_config` WHERE `cgid`='2'"));
echo "<center><table border='0'><tr><form action='".$admin_file.".php' method='post'>\n";
echo "<td>"._CB_ACTIVE.": <select name='xenabled'>\n";
if($cbinfo['enabled'] == 0) { $se0 = " selected"; } else { $se1 = " selected"; }
echo "<option value='0'".$se0.">"._NO."</option>\n";
echo "<option value='1'".$se1.">"._YES."</option>\n";
echo "</select></td></tr>\n";
echo "<tr><td>"._CB_NUMBER.": <select name='xcount'>\n";
if($cbinfo['count'] == 1) { $sc1 = " selected";} elseif($cbinfo['count'] == 2) { $sc2 = " selected";} elseif($cbinfo['count'] == 3) { $sc3 = " selected";} elseif($cbinfo['count'] == 4) { $sc4 = " selected";}
echo "<option value='1'".$sc1.">1</option>\n<option value='2'".$sc2.">2</option>\n";
echo "<option value='3'".$sc3.">3</option>\n<option value='4'".$sc4.">4</option>\n</select></td></tr>\n";
echo "<tr><td>"._CB_HEIGHT.": <input size='4' type='text' name='xheight' value='".$cbinfo['height']."'></td>";
echo "</tr></table></center><br><br><br>\n";
title(_CB_LIST2);
$cblocksdir = dir("blocks");
while($func=$cblocksdir->read()) { if(substr($func, 0, 6) == "block-") { $cblockslist .= "$func "; } }
closedir($cblocksdir->handle);
$cblockslist = explode(" ", $cblockslist);
sort($cblockslist);
$result2 = $db->sql_query("SELECT * FROM `".$prefix."_nsncb_blocks` WHERE `cgid`='2' ORDER BY `cbid`");
while($cbidinfo = $db->sql_fetchrow($result2)) {
  if($cbidinfo['cbid'] > 1) { echo "<br />\n"; }
  echo "<table align='center' border='0' cellpadding='2' cellspacing='2'>\n";
  echo "<tr><td align='center' bgcolor='$bgcolor2' colspan='2'><b>"._CB_BLOCK." "._CB_ID.": ".$cbidinfo['cbid']."</b></td></tr>\n";
  echo "<tr><td bgcolor='$bgcolor2' valign='top'><b>"._CB_TITLE."</b>:</td><td><input type='text' name='x".$cbidinfo['cbid']."title' value='".$cbidinfo['title']."'></td></tr>\n";
  echo "<tr><td bgcolor='$bgcolor2' valign='top'><b>"._CB_FILENAME."</b>:</td><td><select name='x".$cbidinfo['cbid']."name'>";
  echo "<option ";
  if($cbidinfo['filename']=="") { echo "selected "; }
  echo "value=''>"._CB_NONE."</option>\n";
  for($i=0; $i < sizeof($cblockslist); $i++) {
    if($cblockslist[$i]!="") {
      $bl = ereg_replace("block-","",$cblockslist[$i]);
      $bl = ereg_replace(".php","",$bl);
      $bl = ereg_replace("_"," ",$bl);
      echo "<option ";
      if($cblockslist[$i]==$cbidinfo['filename']) { echo "selected "; }
      echo "value='$cblockslist[$i]'>$bl</option>\n";
    }
  }
  echo "</select></td></tr>\n";
  echo "<tr><td bgcolor='$bgcolor2' valign='top'><b>"._CB_SPEC."</b>:</td><td><select name='x".$cbidinfo['cbid']."wtype'>";
  if($cbidinfo['wtype'] == 0) { $w1t0 = " selected"; } else { $w1t1 = " selected"; }
  echo "<option value='0'".$w1t0.">"._CB_PIX."</option>\n";
  echo "<option value='1'".$w1t1.">"._CB_PER."</option>\n";
  echo "</select></td></tr>\n";
  echo "<tr><td bgcolor='$bgcolor2'><b>"._CB_WID."</b>:</td><td><input size='4' type='text' name='x".$cbidinfo['cbid']."width' value='".$cbidinfo['width']."'></td></tr>\n";
  echo "<tr><td bgcolor='$bgcolor2' valign='top'><b>"._CB_CONTENT."</b>:</td><td><textarea name='x".$cbidinfo['cbid']."content' $textrowcol wrap='virtual'>".$cbidinfo['content']."</textarea></td></tr>\n";
  echo "<tr><td align='center' colspan='2'><input type='submit' value='"._CB_SAVE."'></td></tr>\n";
  echo "</table>\n";
}
echo "<input type='hidden' name='op' value='CenterBlocksSave2'></form>";
CloseTable();
include("footer.php");

?>