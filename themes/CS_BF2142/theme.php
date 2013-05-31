<?php

$bgcolor1 = "";
$bgcolor2 = "";
$bgcolor3 = "";
$bgcolor4 = "";
$textcolor1 = "";
$textcolor2 = "";

function OpenTable() {
   ?>
<table width="95%" border="0" align="center" cellpadding="0"
cellspacing="0" id="Table_01">
   <tr>
       <td colspan="2" background="themes/CS_BF2142/images/tables/tables_02.gif"><img src="themes/CS_BF2142/images/tables/tables_01.gif" width="70" height="29" alt=""></td>
       <td width="1189" height="29" background="themes/CS_BF2142/images/tables/tables_02.gif"></td>
       <td colspan="2" background="themes/CS_BF2142/images/tables/tables_02.gif"><div align="right"><img src="themes/CS_BF2142/images/tables/tables_03.gif" width="65" height="29" alt=""></div></td>
   </tr>
   <tr>
       <td background="themes/CS_BF2142/images/tables/tables_04.gif" width="30"></td>
       <td colspan="3" background="themes/CS_BF2142/images/tables/tables_05.gif">
<?
}
function OpenTable2() {
   global $bgcolor1, $bgcolor2;
   echo "<table width='100%' border='0' cellspacing='1'
cellpadding='0''><tr><td class=row1>\n";
   echo "<table width='100%' border='0' cellspacing='1'
cellpadding='0'><tr><td>\n";
}

function CloseTable() {
   ?>
</td>
       <td background="themes/CS_BF2142/images/tables/tables_06.gif" width="28"></td>
   </tr>
   <tr>
       <td colspan="2" background="themes/CS_BF2142/images/tables/tables_08.gif"><img src="themes/CS_BF2142/images/tables/tables_07.gif" width="70" height="49" alt=""></td>
       <td background="themes/CS_BF2142/images/tables/tables_08.gif" width="315" height="49"></td>
       <td colspan="2" background="themes/CS_BF2142/images/tables/tables_08.gif"><div align="right"><img src="themes/CS_BF2142/images/tables/tables_09.gif" width="65" height="49" alt=""></div></td>
   </tr>
   <tr>
       <td><img src="themes/CS_BF2142/images/tables/spacer.gif" width="30" height="1" alt=""></td>
       <td width="40"><img src="themes/CS_BF2142/images/tables/spacer.gif" width="40" height="1" alt=""></td>
       <td><img src="themes/CS_BF2142/images/tables/spacer.gif" height="1" alt=""></td>
       <td width="37"><img src="themes/CS_BF2142/images/tables/spacer.gif" width="37" height="1" alt=""></td>
       <td><img src="themes/CS_BF2142/images/tables/spacer.gif" width="28" height="1" alt=""></td>
   </tr>
</table>
<?
}

function CloseTable2() {
   echo "</td></tr></table></td></tr></table>\n";
}

/************************************************************/
/* Function themeheader()                                   */
/************************************************************/
function themeheader() {
global $user, $userinfo, $cookie, $prefix, $user_prefix, $db, $dbi, $sitekey, $name;

	getusrinfo($user);
	cookiedecode($user);
	mt_srand ((double)microtime()*1000000);
	$maxran = 1000000;
	$random_num = mt_rand(0, $maxran);
	$datekey = date("F j");
	$rcode = hexdec(md5($_SERVER[HTTP_USER_AGENT] . $sitekey . $random_num . $datekey));
	$code = substr($rcode, 2, 6);
	$username = $cookie[1];
	if ($username == "") {
		$username = "Guest";
	}
	$public_msg = public_message();
	echo "$public_msg";


	if ($username == "Guest") {
	//OFFLINE DISPLAY
		$theuser = "<form action='modules.php?name=Your_Account' method='post' style='margin-bottom: 0;'>
					<table class='tablefullcenter'>
					  <tr>
						<td valign='bottom' width='40'><img src='themes/CS_BF2142/images/hd/user.gif' width='34' height='30' alt='user' /></td>
						<td valign='bottom' width='70'><div align='right'><font class='header'>Username&nbsp;&nbsp;</font></div></td>
						<td valign='bottom' width='90'><input type='text' name='username' value='username' onFocus='if(this.value==\"username\")this.value=\"\";' class='header'></td>
						<td valign='bottom' width='70'><div align='right'><font class='header'>Password&nbsp;&nbsp;</font></div></td>
						<td valign='bottom'><input type='password' name='user_password' value='password' onFocus='if(this.value==\"password\")this.value=\"\";' class='header'></td>
						<td valign='top'><input type='hidden' name='op' value='login' /><input type='image' value='login' src='themes/CS_BF2142/images/hd/login.gif' border='0' alt='login' /></td>
					  </tr>
					</table>
				</form>";
	} else {
	//ONLINE DISPLAY
		$theuser = "<table width='100%' border='0'>
					  <tr>
						<td width='40'><img src='themes/CS_BF2142/images/hd/user.gif' width='34' height='30' alt='user' /></td>
						<td><font class='header'>Welcome back " . $username . "!</font></td>
						<td><a href='modules.php?name=Your_Account&op=edituser'><img src='themes/CS_BF2142/images/hd/profile.gif' alt='profile' border='0' /></a></td>
						<td><a href='modules.php?name=Private_Messages&file=index&mode=post'><img src='themes/CS_BF2142/images/hd/newpm.gif' alt='newpm' border='0'/></a></td>
						<td><a href='modules.php?name=Private_Messages'><img src='themes/CS_BF2142/images/hd/inbox.gif' alt='inbox' border='0' /></a></td>
						<td><a href='modules.php?name=Your_Account&op=logout'><img src='themes/CS_BF2142/images/hd/logout.gif' alt='logout' border='0' /></a></td>
					  </tr>
					</table>";
	}

	//CODE FOR THE SCROLLING POSTS
	$count = 1;
	$amount = 10;
	$forum = "<marquee behavior= 'scroll' align= 'center' direction= 'up' height='80' scrollamount= '2' scrolldelay= '90' onmouseover='this.stop()' onmouseout='this.start()'>";
	$result1 = sql_query("SELECT topic_id, topic_last_post_id, topic_title FROM ".$prefix."_bbtopics ORDER BY topic_last_post_id DESC LIMIT $amount", $dbi);
	while(list($topic_id, $topic_last_post_id, $topic_title) = sql_fetch_row($result1, $dbi)) {
	$result3 = sql_query("SELECT username, user_id FROM ".$prefix."_users where user_id='$poster_id'", $dbi);
	list($username, $user_id)=sql_fetch_row($result3, $dbi);
	$forum .= "<a href='modules.php?name=Forums&amp;file=viewtopic&amp;p=$topic_last_post_id#$topic_last_post_id'>$count: $topic_title</a><br>";
	$count++;
	}
	$forum .= "</marquee>";


	include("themes/CS_BF2142/header.php");
	include("includes/configtop.php");
	echo "<table width='980' align='center' cellpadding='0' cellspacing='0' border='0'>\n"
		."<tr valign='top'>\n"
		."<td width='24' height='100%' valign='top' background='themes/CS_BF2142/images/lt.gif'><img src='themes/CS_BF2142/images/spacer.gif' width='24' height='1' alt='spacer' /></td>\n"
		."<td width='0' height='100%' valign='top' bgcolor='#656565'>\n";

	if (($name=='Private_Messages') OR ($name=='Members_List') OR ($name=='Forums')) {
		//REMOVE THE RIGHT BLOCKS
	} else {
		blocks(left);
	}
	echo "</td>\n"
		."<td width='100%' valign=top bgcolor='#656565'>\n";
	}


/************************************************************/
/* Function themefooter()                                   */
/************************************************************/

function themefooter() {
global $index, $user, $banners, $sitename, $slogan, $cookie, $prefix, $dbi, $foot1, $foot2, $foot3, $foot4, $total_time, $banners, $start_time, $prefix, $db;

//LOCAL VARIABLES
	$maxshow = 10;	// You can change the amount of downloads to be shown

//CODE TO SHOW LINKS IN THE FOOTER
	$a = 1;
	$result = sql_query("select lid, title, hits from ".$prefix."_links_links order by date DESC limit 0,$maxshow", $dbi);
	while(list($lid, $title, $hits) = sql_fetch_row($result, $dbi)) {
    $link_title = ereg_replace("_", " ", "$title");
    $show .= "$a: <a href=\"modules.php?name=Web_Links&amp;l_op=visit&amp;lid=$lid\">$link_title</a><br />";
        $showlinks = "<marquee behavior='scroll' direction='up' height='25' width='95%' scrollamount='1' scrolldelay='90' onmouseover='this.stop()' onmouseout='this.start()' align='center'>$show</marquee>";
    $a++;
	}

//CODE TO SHOW THE DOWNLOADS IN THE FOOTER
	$a = 1;
	$sql = "SELECT lid, title FROM ".$prefix."_downloads_downloads ORDER BY hits DESC LIMIT 0, $maxshow";
	$result = $db->sql_query($sql);
	while ($row = $db->sql_fetchrow($result)) {
    $downloads_title = ereg_replace("_", " ", $row[title]);
	$content .= "$a: <a href='modules.php?name=Downloads&amp;d_op=getit&amp;lid=$row[lid]'>$downloads_title</a><br>";
	$showdl = "<marquee behavior='scroll' direction='up' height='20' scrollamount='1' scrolldelay='90' onmouseover='this.stop()' onmouseout='this.start()' align='center'>$content";
    $a++;
	}

// If you are using PHPNUKE < 7.8 uncomment the line below and comment line 144
// if($index = 1){

//If you are using PHPNUKE >= 7.8 use this line
	if (defined('INDEX_FILE')) {
		echo "</td>\n"
			//Right Blocks
			."<td width='0' valign='top' bgcolor='#656565'>\n";

		blocks(right);
		}
		echo "</td>\n"
			."<td width='24' height='100%' valign='top' background=\"themes/CS_BF2142/images/rt.gif\"><img src='themes/CS_BF2142/images/spacer.gif' WIDTH='24' HEIGHT='1'></TD>\n"
			."</tr>\n"
			."</table>\n";
		 include("themes/CS_BF2142/footer.php");


	}

/************************************************************/
/* Function themeindex()                                    */
/* This function format the stories on the Homepage         */
/************************************************************/
function themeindex ($aid, $informant, $time, $title, $counter, $topic, $thetext, $notes, $morelink, $topicname, $topicimage, $topictext) {
global $anonymous, $tipath;

	$ThemeSel = get_theme();
		if (file_exists("themes/$ThemeSel/images/topics/$topicimage")) {
		$t_image = "themes/$ThemeSel/images/topics/$topicimage";
		} else {
		$t_image = "$tipath$topicimage";
	}
		if ($notes != "") {
			$notes = "<br><br><b>"._NOTE."</b> $notes\n";
		} else {
			$notes = "";
		}
		if ("$aid" == "$informant") {
			$content = "$thetext$notes\n";
		} else {
			if($informant != "") {
				$content = "<a href=\"modules.php?name=Your_Account&amp;op=userinfo&amp;username=$informant\">$informant</a> ";
			} else {
				$content = "$anonymous ";
			}
			$content .= ""._WRITES." \"$thetext\"$notes\n";
		}
		//Code Changed - just show posted by
		$posted = ""._POSTEDBY." ";
		$posted .= get_author($aid);
		$posted .= " "._ON." $time  ";
		//End Code Change
		$datetime = substr($morelink, 0, strpos($morelink, "|") - strlen($morelink));
		$morelink = substr($morelink, strlen($datetime) + 2);
		$tmpl_file = "themes/CS_BF2142/story_home.html";
		$thefile = implode("", file($tmpl_file));
		$thefile = addslashes($thefile);
		$thefile = "\$r_file=\"".$thefile."\";";
		eval($thefile);
		print $r_file;
}

/************************************************************/
/* Function themeindex()                                    */
/************************************************************/

function themearticle ($aid, $informant, $datetime, $title, $thetext, $topic, $topicname, $topicimage, $topictext) {
    global $admin, $sid, $tipath;
$ThemeSel = get_theme();
    if (file_exists("themes/$ThemeSel/images/topics/$topicimage")) {
	$t_image = "themes/$ThemeSel/images/topics/$topicimage";
    } else {
	$t_image = "$tipath$topicimage";
}
    $posted = ""._POSTEDON." $datetime "._BY." ";
    $posted .= get_author($aid);
    if ($notes != "") {
        $notes = "<br><br><b>"._NOTE."</b> <i>$notes</i>\n";
    } else {
        $notes = "";
    }
    if ("$aid" == "$informant") {
        $content = "$thetext$notes\n";
    } else {
        if($informant != "") {
            $content = "<a href=\"modules.php?name=Your_Account&amp;op=userinfo&amp;username=$informant\">$informant</a> ";
        } else {
            $content = "$anonymous ";
        }
        $content .= ""._WRITES." <i>\"$thetext\"</i>$notes\n";
    }
    $tmpl_file = "themes/CS_BF2142/story_page.html";
    $thefile = implode("", file($tmpl_file));
    $thefile = addslashes($thefile);
    $thefile = "\$r_file=\"".$thefile."\";";
    eval($thefile);
    print $r_file;
}

function themesidebox($title, $content) {
    $tmpl_file = "themes/CS_BF2142/blocks.html";
    $thefile = implode("", file($tmpl_file));
    $thefile = addslashes($thefile);
    $thefile = "\$r_file=\"".$thefile."\";";
    eval($thefile);
    print $r_file;
}
?>