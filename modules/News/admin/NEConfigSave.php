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

if(!defined('NSNNE_ADMIN')) { die("Illegal File Access Detected!!"); }
if($radminsuper == 1) {
  ne_save_config('approved_users', $xapproved_users);
  ne_save_config('posting_admin', $xposting_admin);
}
ne_save_config('allow_comments', $xallow_comments);
ne_save_config('allow_polls', $xallow_polls);
ne_save_config('allow_rating', $xallow_rating);
ne_save_config('allow_related', $xallow_related);
ne_save_config('allowed_tags', $xallowed_tags);
ne_save_config('anonymous_post', $xanonymous_post);
ne_save_config('anonymous_submit', $xanonymous_submit);
ne_save_config('censor_list', $xcensor_list);
ne_save_config('censor_mode', $xcensor_mode);
ne_save_config('censor_replace', $xcensor_replace);
ne_save_config('columns', $xcolumns);
ne_save_config('comment_limit', $xcomment_limit);
ne_save_config('default_mode', $xdefault_mode);
ne_save_config('default_order', $xdefault_order);
ne_save_config('default_thold', $xdefault_thold);
ne_save_config('homenumber', $xhomenumber);
ne_save_config('hometopic', $xhometopic);
ne_save_config('notify_admin', $xnotify_admin);
ne_save_config('notify_commenter', $xnotify_commenter);
ne_save_config('notify_informant', $xnotify_informant);
ne_save_config('notify_poster', $xnotify_poster);
ne_save_config('notifyauth', $xnotifyauth);
ne_save_config('oldnumber', $xoldnumber);
ne_save_config('readmore', $xreadmore);
ne_save_config('texttype', $xtexttype);
$db->sql_query("ALTER TABLE `".$prefix."_nsnne_config` ORDER BY `config_name` ");
$db->sql_query("OPTIMIZE TABLE `".$prefix."_nsnne_config`");
header("Location: ".$admin_file.".php?op=NEConfig");

?>