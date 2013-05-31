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

define('NO_EDITOR', true); // For 7.8 Patched 3.1
$advanced_editor = 0; // For 7.7 Patched 3.1
global $admin_file;
if(!$admin_file OR $admin_file == "") { $admin_file = "admin"; }
if(!defined('MODULE_FILE')) { die("Illegal File Access Detected!!"); }
$index = 1; // For < Patched 3.1
define('INDEX_FILE', true); // For Patched 3.1 +
define('NSNNE_PUBLIC', true);
require_once("mainfile.php");
$module_name = basename(dirname(__FILE__));
include_once("includes/nsnne_func.php");
$neconfig = ne_get_configs();
get_lang($module_name);
automated_news();
if(isset($sid)) $sid = intval($sid);
if(isset($tid)) $tid = intval($tid);
if(isset($pid)) { $pid = intval($pid); } else { $pid = 0; }
if(isset($mode)) { $mode = trim($mode); } else { $mode = $neconfig['default_mode']; }
setcookie("news_mode", "$mode", time()+31622400);
if(isset($order)) { $order = intval($order); } else { $order = $neconfig['default_order']; }
setcookie("news_order", "$order", time()+31622400);
if(isset($thold)) { $thold = intval($thold); } else { $thold = $neconfig['default_thold']; }
setcookie("news_thold", "$thold", time()+31622400);
if(isset($new_topic)) { $op = "NETopicList"; }
if(isset($catid)) { $op = "NECategoryList"; }
list($main_module) = $db->sql_fetchrow($db->sql_query("SELECT main_module FROM ".$prefix."_main"));
if($module_name == $main_module) {
  $module_link = "index.php?";
  $form_link = "index.php";
} else {
  $module_link = "modules.php?name=$module_name&amp;";
  $form_link = "modules.php?name=$module_name";
}
if(!isset($op)) { $op = "NEIndex"; }
switch ($op) {
  case "NEAll":include("modules/$module_name/public/NEAll.php");break;
  case "NEArchive":include("modules/$module_name/public/NEArchive.php");break;
  case "NEArticle":include("modules/$module_name/public/NEArticle.php");break;
  case "NECategoryList":include("modules/$module_name/public/NECategoryList.php");break;
  case "NEComment":include("modules/$module_name/public/NEComment.php");break;
  case "NECommentShow":include("modules/$module_name/public/NECommentShow.php");break;
  case "NEFriend":include("modules/$module_name/public/NEFriend.php");break;
  case "NEFriendSend":include("modules/$module_name/public/NEFriendSend.php");break;
  case "NEFriendSent":include("modules/$module_name/public/NEFriendSent.php");break;
  case "NEIndex":include("modules/$module_name/public/NEIndex.php");break;
  case "NEMonth":include("modules/$module_name/public/NEMonth.php");break;
  case "NEPortable":include("modules/$module_name/public/NEPortable.php");break;
  case "NEPrint":include("modules/$module_name/public/NEPrint.php");break;
  case "NERate":include("modules/$module_name/public/NERate.php");break;
  case "NERateDone":include("modules/$module_name/public/NERateDone.php");break;
  case "NERead":include("modules/$module_name/public/NERead.php");break;
  case "NEReply":include("modules/$module_name/public/NEReply.php");break;
  case "NEReplyPost":include("modules/$module_name/public/NEReplyPost.php");break;
  case "NEReplyPreview":include("modules/$module_name/public/NEReplyPreview.php");break;
  case "NESubmit":include("modules/$module_name/public/NESubmit.php");break;
  case "NESubmitPost":include("modules/$module_name/public/NESubmitPost.php");break;
  case "NESubmitPreview":include("modules/$module_name/public/NESubmitPreview.php");break;
  case "NETopicList":include("modules/$module_name/public/NETopicList.php");break;
  case "NETopicMain":include("modules/$module_name/public/NETopicMain.php");break;
  case "NETopics":include("modules/$module_name/public/NETopics.php");break;
}

?>