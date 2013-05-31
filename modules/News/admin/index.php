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

define('NO_EDITOR', true);
$advanced_editor = 0;
global $prefix, $db, $admin_file;
if(!$admin_file OR $admin_file == "") { $admin_file = "admin"; }
if(!defined('ADMIN_FILE')) { die("Illegal File Access Detected!!"); }
//$modname = basename(str_replace("/admin", "", dirname(__FILE__)));
$modname= "News";
define('NSNNE_ADMIN', true);
define('INDEX_FILE', true);
$index=1;
$aid = substr("$aid", 0,25);
$row = $db->sql_fetchrow($db->sql_query("SELECT title, admins FROM ".$prefix."_modules WHERE title='$modname'"));
$row2 = $db->sql_fetchrow($db->sql_query("SELECT name, radminsuper FROM ".$prefix."_authors WHERE aid='$aid'"));
$admins = explode(",", $row['admins']);
$auth_user = 0;
$radminarticle = 0;
for($i=0; $i < sizeof($admins); $i++) { if($row2['name'] == $admins[$i] AND $row['admins'] != "") { $auth_user = 1; } }
if($auth_user == 1) { $radminarticle = 1; }
if($row2['radminsuper'] == 1) { $radminsuper = 1; }
if($radminsuper == 1 || $radminarticle == 1) {
  get_lang($modname);
  include_once("includes/nsnne_func.php");
  $ne_config = ne_get_configs();
  $perpage = 100;
  switch($op) {
    case "NECategoryAdd":include("modules/$modname/admin/NECategoryAdd.php");break;
    case "NECategoryAddSave":include("modules/$modname/admin/NECategoryAddSave.php");break;
    case "NECategoryDelete":include("modules/$modname/admin/NECategoryDelete.php");break;
    case "NECategoryDeleteConf":include("modules/$modname/admin/NECategoryDeleteConf.php");break;
    case "NECategoryEdit":include("modules/$modname/admin/NECategoryEdit.php");break;
    case "NECategoryEditSave":include("modules/$modname/admin/NECategoryEditSave.php");break;
    case "NECategoryIndex":include("modules/$modname/admin/NECategoryIndex.php");break;
    case "NECategoryMove":include("modules/$modname/admin/NECategoryMove.php");break;
    case "NECategoryMoveConf":include("modules/$modname/admin/NECategoryMoveConf.php");break;
    case "NECommentDelete":include("modules/$modname/admin/NECommentDelete.php");break;
    case "NECommentDeleteConf":include("modules/$modname/admin/NECommentDeleteConf.php");break;
    case "NECommentEdit":include("modules/$modname/admin/NECommentEdit.php");break;
    case "NECommentEditSave":include("modules/$modname/admin/NECommentEditSave.php");break;
    case "NECommentIndex":include("modules/$modname/admin/NECommentIndex.php");break;
    case "NEConfig":include("modules/$modname/admin/NEConfig.php");break;
    case "NEConfigSave":include("modules/$modname/admin/NEConfigSave.php");break;
    case "NEMain":include("modules/$modname/admin/NEMain.php");break;
    case "NEProgramedDelete":include("modules/$modname/admin/NEProgramedDelete.php");break;
    case "NEProgramedDeleteConf":include("modules/$modname/admin/NEProgramedDeleteConf.php");break;
    case "NEProgramedEdit":include("modules/$modname/admin/NEProgramedEdit.php");break;
    case "NEProgramedEditSave":include("modules/$modname/admin/NEProgramedEditSave.php");break;
    case "NEProgramedIndex":include("modules/$modname/admin/NEProgramedIndex.php");break;
    case "NERelatedDelete":include("modules/$modname/admin/NERelatedDelete.php");break;
    case "NERelatedEdit":include("modules/$modname/admin/NERelatedEdit.php");break;
    case "NERelatedSave":include("modules/$modname/admin/NERelatedSave.php");break;
    case "NEStoryIndex":include("modules/$modname/admin/NEStoryIndex.php");break;
    case "NEStoryAdd":include("modules/$modname/admin/NEStoryAdd.php");break;
    case "NEStoryDelete":include("modules/$modname/admin/NEStoryDelete.php");break;
    case "NEStoryDeleteConf":include("modules/$modname/admin/NEStoryDeleteConf.php");break;
    case "NEStoryEdit":include("modules/$modname/admin/NEStoryEdit.php");break;
    case "NEStoryEditSave":include("modules/$modname/admin/NEStoryEditSave.php");break;
    case "NEStoryPost":include("modules/$modname/admin/NEStoryPost.php");break;
    case "NEStoryPreview":include("modules/$modname/admin/NEStoryPreview.php");break;
    case "NESubmissionDelete":include("modules/$modname/admin/NESubmissionDelete.php");break;
    case "NESubmissionDeleteAll":include("modules/$modname/admin/NESubmissionDeleteAll.php");break;
    case "NESubmissionDisplay":include("modules/$modname/admin/NESubmissionDisplay.php");break;
    case "NESubmissionPost":include("modules/$modname/admin/NESubmissionPost.php");break;
    case "NESubmissionPreview":include("modules/$modname/admin/NESubmissionPreview.php");break;
    case "NESubmissionIndex":include("modules/$modname/admin/NESubmissionIndex.php");break;
    case "NETopicAdd":include("modules/$modname/admin/NETopicAdd.php");break;
    case "NETopicAddSave":include("modules/$modname/admin/NETopicAddSave.php");break;
    case "NETopicDelete":include("modules/$modname/admin/NETopicDelete.php");break;
    case "NETopicDeleteConf":include("modules/$modname/admin/NETopicDeleteConf.php");break;
    case "NETopicEdit":include("modules/$modname/admin/NETopicEdit.php");break;
    case "NETopicEditSave":include("modules/$modname/admin/NETopicEditSave.php");break;
    case "NETopicMove":include("modules/$modname/admin/NETopicMove.php");break;
    case "NETopicMoveConf":include("modules/$modname/admin/NETopicMoveConf.php");break;
    case "NETopicIndex":include("modules/$modname/admin/NETopicIndex.php");break;
  }
} else {
  die("Illegal File Access Detected!!");
}

?>