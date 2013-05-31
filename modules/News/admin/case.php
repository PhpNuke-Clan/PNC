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

global $admin_file;
if(!$admin_file OR $admin_file == "") { $admin_file = "admin"; }
if(!defined('ADMIN_FILE')) { die("Illegal File Access Detected!!"); }
//$modname = basename(str_replace("/admin", "", dirname(__FILE__)));
$modname= "News";
if($op == "submissions") { header("Location: ".$admin_file.".php?op=NESubmissionIndex"); }
if($op == "adminStory") { header("Location: ".$admin_file.".php?op=NEStoryAdd"); }
if($op == "EditStory") { header("Location: ".$admin_file.".php?op=NEStoryEdit&sid=$sid"); }
if($op == "RemoveStory") { header("Location: ".$admin_file.".php?op=NEStoryDelete&sid=$sid"); }
if($op == "topicsmanager") { header("Location: ".$admin_file.".php?op=NETopics"); }
switch($op) {
  case "NECategoryIndex":
  case "NECategoryAdd":
  case "NECategoryAddSave":
  case "NECategoryDelete":
  case "NECategoryDeleteConf":
  case "NECategoryEdit":
  case "NECategoryEditSave":
  case "NECategoryMove":
  case "NECategoryMoveConf":
  case "NECommentIndex":
  case "NECommentDelete":
  case "NECommentDeleteConf":
  case "NECommentEdit":
  case "NECommentEditSave":
  case "NEConfig":
  case "NEConfigSave":
  case "NEMain":
  case "NEProgramedIndex":
  case "NEProgramedDelete":
  case "NEProgramedDeleteConf":
  case "NEProgramedEdit":
  case "NEProgramedEditSave":
  case "NERelatedDelete":
  case "NERelatedEdit":
  case "NERelatedSave":
  case "NEStoryIndex":
  case "NEStoryAdd":
  case "NEStoryDelete":
  case "NEStoryDeleteConf":
  case "NEStoryEdit":
  case "NEStoryEditSave":
  case "NEStoryPost":
  case "NEStoryPreview":
  case "NESubmissionDelete":
  case "NESubmissionDeleteAll":
  case "NESubmissionDisplay":
  case "NESubmissionPost":
  case "NESubmissionPreview":
  case "NESubmissionIndex":
  case "NETopicAdd":
  case "NETopicAddSave":
  case "NETopicDelete":
  case "NETopicDeleteConf":
  case "NETopicEdit":
  case "NETopicEditSave":
  case "NETopicMove":
  case "NETopicMoveConf":
  case "NETopicIndex":
  include("modules/$modname/admin/index.php");
  break;
}

?>