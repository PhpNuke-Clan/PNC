<?php

/***************************************/
/* Maps Manager by gotcha  version 2.0 */
/* Copyright 2006 http://nukecoder.com */
/* You MAY NOT copy in whole or in part*/
/* or redistribute map manager without */
/* written consent from the author.    */
/* Contact and support can be found at */
/* http://nukecoder.com                */
/***************************************/

if ( !defined('MODULE_FILE') )
{
	die("You can't access this file directly...");
}

/* if(!stristr($_SERVER['PHP_SELF'], "modules.php") && !stristr($_SERVER['SCRIPT_NAME'], "modules.php")) {
	die ("You can't access this file directly...");
} */

@require_once("mainfile.php");
$module_name = basename(dirname(__FILE__));
get_lang($module_name);
$pagetitle = "- $module_name - "._REVIEW." "._MAP."";

@include("header.php");
@include("modules/$module_name/functions.php");

$cr1 = $db->sql_query("SELECT mval FROM ".$prefix."_mapconfig where mname='a_review'");
	list($allowreview) = $db->sql_fetchrow($cr1);
	$mid = intval($_REQUEST['id']);
if (is_user($user) && ($allowreview)){
		$cookie = cookiedecode($user);	$voter = $cookie[0];
		$result = $db->sql_query("SELECT * FROM ".$prefix."_mapreviews where rmapid='$mid' AND ruserid='$voter'");
	if ($db->sql_numrows($result) > 0){
			OpenTable();
			echo "<center>"._CANTREVIEWTWICE."<br>"._GOBACK."</center>";
			CloseTable();
			@include("footer.php");
	}elseif (isset($_POST['submit'])){
			$rmapid = intval($_POST['revmap']);
			$result1 = $db->sql_query("SELECT * FROM ".$prefix."_mapreviews where rmapid='$rmapid' AND ruserid='$voter'");
			if ($db->sql_numrows($result1) > 0){
				OpenTable();
				echo "<center>"._CANTREVIEWTWICE."<br>[ <a href=\"modules.php?name=$module_name\">"._MAPS." "._MAIN."</a> ]</center>";
				CloseTable();
				@include("footer.php");
			}else{
				nav();
				OpenTable();
				echo "<center>";
				$rmapid = intval($_POST['revmap']);
				$cookie = cookiedecode($user);
        $revsubmitter = $cookie[0];
				$revsubmitterip = $_SERVER['REMOTE_ADDR'];
				$revdate = date("M d, Y");
				$review = htmlentities(check_html($_POST['review'], 'nohtml'), ENT_QUOTES);
				$submit = $db->sql_query("INSERT INTO ".$prefix."_mapreviews VALUES (NULL, '$rmapid', $revsubmitter, '$revsubmitterip', '$revdate', '$review', '0')");
				echo "--";
				if($submit){
					echo ""._REVSUBMITTED."<br><br>"._GOBACK."<br>\n";
				}else{
					echo "$reqmaptitle "._REVNOTSUBMITTED."<br><br>"._GOBACK."<br>\n";
				}
				echo "<br>[ <a href=\"modules.php?name=$module_name\">"._MAPS." "._MAIN."</a> ]\n"
				."</center>\n";
				CloseTable();
			}
	}else{
			nav();
			title(_REVIEW." "._MAP);
			OpenTable();
			echo "<form action='modules.php?name=$module_name&amp;file=reviewmap' method='post'>\n";
			echo "<center>"._ENTER_REVIEW."<br> <textarea name='review' cols='35' rows='6' wrap='virtual'></textarea></center>\n"
                                //."</td>\n"
				//."</tr>\n"
				//."<tr>\n"
				//."<td align='center'>\n"
				."<center>"
                                ."<input type='hidden' name='revmap' value='$mid'>"
				."<input type='hidden' name='op' value='reviewmap'>\n"
				."<input type='submit' name='submit' value='"._SUBMITREVIEW."'>\n"
				//."</td>\n"
				//."</tr>\n"
				."</center>"
				."</form>";
				//."</table>\n";
			CloseTable();
	}
}else{
	nav();
	OpenTable();
	echo "<center>"._MUSTBEREGISTERED."</center>";
	CloseTable();
}
@include("footer.php");
?>