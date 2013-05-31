<?php

/********************************************************/
/* Hall of Shame                                     	*/
/* By: Troy Moore (Duck@mrc.clanservers.com)			*/
/* http://mrc.clanservers.com                           */
/* Copyright © 2006-2011 by JesStep Enterprises         */
/********************************************************/
/* Hall of Shame                                        */
/* For PHP-Nuke 6.5+                                    */
/* By Troy Moore - http://mrc.clanservers.com        	*/
/********************************************************/

if ( !defined('MODULE_FILE') )
{
   die("You can't access this file directly...");
}

$pagetitle = " - "._HoS_HALLOFSHAME.": ".$hos_config['version_number'];
@include("header.php");
$prow = $hos_config['perrow'];
$prow = $prow-1;
mainheader(5, _HoS_HALLOFSHAME.": ".$hos_config['version_number'],_HoS_INDEXMESS1);
echo "<br>\n";
OpenTable();
echo "<table border='0' cellpadding='2' cellspacing='2' width='100%'>\n";
$result = $db->sql_query("SELECT * FROM ".$prefix."_hos_reasons where rpid > 0 ORDER BY title");
$count = 0;
if($db->sql_numrows($result) > 0) {
  echo "<tr><td align='center' colspan='".$hos_config['perrow']."'><b>"._HoS_REASONSBANNED."</b></td></tr>\n";
  echo "<tr><td align='center' colspan='".$hos_config['perrow']."'>&nbsp;</td></tr>\n";
  echo "<tr>";
  while($resinfo = $db->sql_fetchrow($result)) {
    $resnum = $db->sql_numrows($db->sql_query("SELECT * FROM ".$prefix."_hos_punks WHERE punkreason='".$resinfo['rid']."'"));
    if($db->sql_numrows($result) >= $prow) {$aligner="right";} else {$aligner="center";}
    echo "<td align=$aligner><a href='modules.php?name=$module_name&op=HoSReasons&rid=".$resinfo['rid']."'>".$resinfo['title']."</a> ($resnum)";
    if ($count<$prow) {
      echo "</td>\n";
    $count++;
  }
    elseif ($count==$prow) {
      echo "</td>\n</tr>\n<tr>\n";
      $count = 0;
    }
  }

    echo "</tr>\n";

}
    $resnum = $db->sql_numrows($db->sql_query("SELECT * FROM ".$prefix."_hos_punks"));
      echo "<tr><td align='center' colspan='".$hos_config['perrow']."'>&nbsp;</td></tr>\n";
echo "<tr><td align='center' colspan='".$hos_config['perrow']."'><a href='modules.php?name=$module_name&op=HoSReasons'>"._HoS_VIEWALLPUNKS."</a> ($resnum)</td></tr>\n";
echo "</table>\n";
CloseTable();
@include("footer.php");

?>