<?php

/********************************************************/
/* NSN Groups                                           */
/* By: NukeScripts Network (webmaster@nukescripts.net)  */
/* http://www.nukescripts.net                           */
/* Copyright © 2000-2005 by NukeScripts Network         */
/********************************************************/

if(!defined('MODULE_FILE')) { die("Illegal Access Detected!!!"); }
    $gid = intval($gid);
    include("header.php");
    title(_GR_GROUPINFO."");
    OpenTable();
    echo "<center><table border='0' cellpadding='2' cellspacing='2' bgcolor='$bgcolor1'>\n";
	$sql2 = "SELECT gid, gname, gdesc, gpublic, glimit  FROM ".$prefix."_nsngr_groups WHERE gid='$gid'";
    $result = $db->sql_query($sql2);
	$test=$db->sql_numrows($result);
    if($db->sql_numrows($result) > 0) {
      while(list($gida, $gname, $gdesc, $gpublic, $glimit ) = $db->sql_fetchrow($result)) {
		echo "<tr><td bgcolor='$bgcolor2'><b>"._GR_GRPNAME.":</b></td><td>$gname ";
        if(($glimit == 0 OR $numusers < $glimit) AND !in_group($gida) AND is_user($user) AND $gpublic == 0) {
			echo "<a href='modules.php?name=$module_name&amp;op=GRJoin&amp;gid=$gida'><img src='modules/$module_name/images/join.png' height='16' width='36' border='0' alt='"._GR_JOIN."' title='".$numusers."'></a>\n";
        } //else {
          //echo "<img src='modules/$module_name/images/blank.png' height='16' width='36' border='0'>\n";
        //}
        echo "</td></tr>\n";
        $numusers = $db->sql_numrows($db->sql_query("SELECT `uid` FROM `".$prefix."_nsngr_users` WHERE `gid`='$gida'"));
        echo "<tr><td bgcolor='$bgcolor2'><b>"._GR_NUMUSERS.":</b></td><td>$numusers</td></tr>\n";
        if($glimit == 0) {
          $gmlimit = _GR_NOLIMIT;
        } elseif($glimit <= $numusers) {
          $gmlimit = _GR_FILLED;
        } else {
          $gmlimit = $glimit;
        }
        echo "<tr><td bgcolor='$bgcolor2'><b>"._GR_LIMIT.":</b></td><td>$gmlimit</td></tr>\n";
        echo "<tr><td bgcolor='$bgcolor2' valign='top'><b>"._GR_DESCRIPTION.":</b></td><td>".nl2br($gdesc)."</td>\n";
        echo "</tr>\n";
      }
    } else {
      echo "<tr bgcolor='$bgcolor1'><td align='center' colspan='2'>".$sql2."<BR><BR><BR><BR>-".$test."-"._GR_NOPUBLICGROUP."</td></tr>\n";
    }
    echo "</table></center><br>\n";
    echo "<center>"._GOBACK."</center>\n";
    CloseTable();
    include("footer.php");

?>