<?php

/********************************************************/
/* Hall of Shame                                     	*/
/* By: Troy Moore (Duck@mrc.clanservers.com)			*/
/* http://mrc.clanservers.com                           */
/* Copyright © 2000-2005 by JesStep Enterprises         */
/********************************************************/
/* Hall of Shame 1.0.2                                  */
/* For PHP-Nuke 6.5+                                    */
/* By Troy Moore - http://mrc.clanservers.com        	*/
/********************************************************/



global $admin_file;
if(empty($admin_file)) { $admin_file= "admin"; }

$modulename = "Hall_of_Shame";

function hossize_image($image, $imagewidth, $imageheight) {
  global $new_size;
  list($im_width, $im_height, $im_type, $im_attr) = @getimagesize($image);
  if($im_width <= $imagewidth AND $im_height <= $imageheight) {
    $new_size['width'] = $im_width;
    $new_size['height'] = $im_height;
    return $new_size;
  } elseif ($im_width > $imagewidth AND $im_height <= $imageheight) {
    $diff = $imagewidth/$im_width;
    $new_size['width'] = round($im_width*$diff);
    $new_size['height'] = round($im_height*$diff);
    return $new_size;
  } elseif ($im_width <= $imagewidth AND $im_height > $imageheight) {
    $diff = $imageheight/$im_height;
    $new_size['width'] = round($im_width*$diff);
    $new_size['height'] = round($im_height*$diff);
    return $new_size;
  } elseif ($im_width > $imagewidth AND $im_height > $imageheight) {
    $hdiff = $im_height-$imageheight;
    $wdiff = $im_width-$imagewidth;
    if($hdiff > $wdiff) {
      $multiplier = $imageheight/$im_height;
    } else {
      $multiplier = $imagewidth/$im_width;
    }
    $new_size['width'] = round($im_width*$multiplier);
    $new_size['height'] = round($im_height*$multiplier);
    return $new_size;
  }
  $new_size['width'] = $imagewidth;
  $new_size['height'] = $imageheight;
  return $new_size;
}

function hossave_config($config_name, $config_value){
    global $prefix, $db;
    $db->sql_query("UPDATE ".$prefix."_hos_config SET config_value='$config_value' WHERE config_name='$config_name'");
}

function hosget_config($config_name){
    global $prefix, $db;
    list($config_value) = $db->sql_fetchrow($db->sql_query("SELECT config_value FROM ".$prefix."_hos_config WHERE config_name='$config_name'"));
    return $config_value;
}

function hosget_configs(){
    global $prefix, $db;
    $configresult = $db->sql_query("SELECT config_name, config_value FROM ".$prefix."_hos_config");
    while (list($config_name, $config_value) = $db->sql_fetchrow($configresult)) {
        $config[$config_name] = $config_value;
    }
    return $config;
}

function hosget_reason($rid){
    global $prefix, $db;
    $rid = intval($rid);
    $catinfo = $db->sql_fetchrow($db->sql_query("SELECT * FROM ".$prefix."_hos_reasons WHERE rid='$rid'"));
    return $catinfo;
}


function hosget_punk($pid){
    global $prefix, $db;
    $pid = intval($pid);
    $punkinfo = $db->sql_fetchrow($db->sql_query("SELECT * FROM ".$prefix."_hos_punks WHERE pid='$pid'"));
    return $punkinfo;
}

function extcheck($extallow, $ext) {


	$extallow = $extallow;
	$delims = ", ";
	$testext = strtok($extallow, $delims);
	while (is_string($testext)) {
		if ($testext) {
			if ($ext == $testext) {
			return "true";}
			}
			$testext = strtok($delims);
		}

	}

function adminheader($ptitle) {
global $admin, $prefix, $hos_config;
$memtable = $hos_config['membertable'];
  OpenTable();
  echo "<h1 align='center'>$ptitle</h1>";
  echo "<table border='0' cellpadding='0' cellspacing='0' width='100%'>\n";
  echo "<tr>\n";
  echo "<td align='center' valign='top' width='25%'><a href='admin.php?op=HoSReason_List'>"._HoS_REASONLIST."</a><br>\n";
  echo "<a href='admin.php?op=HoSReason_Add'>"._HoS_ADDREASON."</a></td>\n";
  echo "<td align='center' valign='top' width='25%'><a href='admin.php?op=HoSReasonCat_List'>"._HoS_CATEGORYLIST."</a><br>\n";
  echo "<a href='admin.php?op=HoSReasonCat_Add'>"._HoS_ADDCATEGORY."</a></td>\n";
  echo "<td align='center' valign='top' width='25%'><a href='admin.php?op=HoSPunk_List'>"._HoS_PUNKLIST."</a><br>\n";
  echo "<a href='admin.php?op=HoSPunk_Add'>"._HoS_ADDPUNK."</a></td>\n";
  if ($memtable == $prefix."_hos_members"){
    echo "<td align='center' valign='top' width='25%'><a href='admin.php?op=HoSMember_List'>"._HoS_MEMBERLIST."</a><br>\n";
    echo "<a href='admin.php?op=HoSMember_Add'>"._HoS_ADDMEMBER."</a></td>\n";
     }
  echo "<td align='center' valign='top' width='25%'><a href='admin.php?op=HoSConfigure'>"._HoS_CONFIG."</a><br>\n";
  echo "<a href='admin.php?op=HoSHelp'>"._HoS_HELP."</a></td>\n";
  echo "</tr>\n";
  echo "<tr><td align='center' colspan='5'><br><a href='admin.php'>"._HoS_SITEADMIN."</a></td></tr>\n";
  echo "</table>\n";
  CloseTable();
}

function mainheader($mainindex, $ptitle, $pmessage) {
  global $modulename, $admin, $hos_config, $loc;
  $platinum_url = "modules/Hall_of_Shame/images/";
	OpenTable();
  echo "<table border='0' cellpadding='0' cellspacing='0' width='100%'>\n";
    echo "<tr><td width='20%'></td><td width='60%' align='center'>\n";
  echo "<h1 align='center'>$ptitle</h1>";
  echo "<br><br>";
  echo "<h2 align='center'>$pmessage</h2>";
  if ($mainindex!=0 AND $mainindex!=5 AND $mainindex!=6 ) { echo " <p><em>"._HoS_CLICKNAME."</em></p>"; }
   echo "<br><br></td><td width='20%'>";
    echo "<img src='".$loc.$platinum_url."nocheat.gif' align='right'></td></tr></table>";
  echo "<center>[";
  if (is_admin($admin)) { echo " <a href='admin.php?op=HoSAdmin'>"._HoS_ADMIN."</a> |"; }
  if ($mainindex!=0) { echo " <a href='modules.php?name=$modulename'>"._HoS_CATEGORYINDEX."</a> |"; }
  if ($mainindex!=5) { echo " <a href='modules.php?name=$modulename&op=HoSIndexRes'>"._HoS_REASONSINDEX."</a> |"; }
  if ($mainindex!=2) {echo " <a href='modules.php?name=$modulename&op=HoSReasons'>"._HoS_LISTALLPUNKS."</a> |";}
  if ($mainindex!=3) {echo " <a href='modules.php?name=$modulename&op=HoSScreenshots'>"._HoS_LISTSS."</a> |";}
  if ($mainindex!=4) {echo " <a href='modules.php?name=$modulename&op=HoSDemo'>"._HoS_LISTDEMO."</a> |";}
  echo " <a href='modules.php?name=$modulename&op=HoSSearch'>"._HoS_SEARCH."</a> ]";
  echo "</center>";
  CloseTable();
}

?>