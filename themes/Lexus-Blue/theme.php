<?php
$bgcolor1 = "#4E4646";
$bgcolor2 = "#4E4646";
$bgcolor3 = "#4E4646";
$bgcolor4 = "#4E4646";
$textcolor1 = "#000000";
$textcolor2 = "#000000";

function OpenTable() {
    ?>
<TABLE WIDTH=100%% BORDER=0 CELLPADDING=0 CELLSPACING=0>
	<TR>
		<TD ROWSPAN=3>
			<IMG SRC="themes/Lexus-Blue/images/center/center_01.gif" WIDTH=45 HEIGHT=59 ALT=""></TD>
		<TD ROWSPAN=3>
			<IMG SRC="themes/Lexus-Blue/images/center/center_02.gif" WIDTH=27 HEIGHT=59 ALT=""></TD>
		<TD width=100% nowrap background="themes/Lexus-Blue/images/center/center_03.gif">
			<IMG SRC="themes/Lexus-Blue/images/center/center_03.gif" width=100% HEIGHT=23 ALT=""></TD>
		<TD ROWSPAN=3>
			<IMG SRC="themes/Lexus-Blue/images/center/center_04.gif" WIDTH=29 HEIGHT=59 ALT=""></TD>
		<TD ROWSPAN=3>
			<IMG SRC="themes/Lexus-Blue/images/center/center_05.gif" WIDTH=46 HEIGHT=59 ALT=""></TD>
	</TR>
	<TR>
		<TD height="21" nowrap background="themes/Lexus-Blue/images/center/center_06.gif">&nbsp;</TD>
	</TR>
	<TR>
		<TD width=100% background="themes/Lexus-Blue/images/center/center_07.gif">
			<IMG SRC="themes/Lexus-Blue/images/center/center_07.gif" width=100% HEIGHT=15 ALT=""></TD>
	</TR>
	<TR>
		<TD width="45" height="90" nowrap background="themes/Lexus-Blue/images/center/center_08.gif"></TD>
		<TD COLSPAN=3 valign="top" bgcolor="#262626"><div align="justify"><?
}
function OpenTable2() {
    global $bgcolor1, $bgcolor2;
    ?>
<TABLE WIDTH=100% BORDER=0 CELLPADDING=0 CELLSPACING=0>
	<TR>
		<TD ROWSPAN=3>
			<IMG SRC="themes/Lexus-Blue/images/center/center_01.gif" WIDTH=45 HEIGHT=59 ALT=""></TD>
		<TD ROWSPAN=3>
			<IMG SRC="themes/Lexus-Blue/images/center/center_02.gif" WIDTH=27 HEIGHT=59 ALT=""></TD>
		<TD  nowrap background="themes/Lexus-Blue/images/center/center_03.gif">
			<IMG SRC="themes/Lexus-Blue/images/center/center_03.gif" width=100% HEIGHT=23 ALT=""></TD>
		<TD ROWSPAN=3>
			<IMG SRC="themes/Lexus-Blue/images/center/center_04.gif" WIDTH=29 HEIGHT=59 ALT=""></TD>
		<TD ROWSPAN=3>
			<IMG SRC="themes/Lexus-Blue/images/center/center_05.gif" WIDTH=46 HEIGHT=59 ALT=""></TD>
	</TR>
	<TR>
		<TD height="21" width=100% nowrap background="themes/Lexus-Blue/images/center/center_06.gif">
		<IMG SRC="themes/Lexus-Blue/images/center/center_06.gif" width=100% HEIGHT=21 ALT=""></TD>
	</TR>
	<TR>
		<TD width=100% background="themes/Lexus-Blue/images/center/center_07.gif">
			<IMG SRC="themes/Lexus-Blue/images/center/center_07.gif" width=100% HEIGHT=15 ALT=""></TD>
	</TR>
	<TR>
		<TD width="45" height="91" nowrap background="themes/Lexus-Blue/images/center/center_08.gif"></TD>
		<TD COLSPAN=3 valign="top" bgcolor="#262626"><div align="justify"><?

}

function CloseTable() {
    ?></div></TD>
		<TD width="46"  nowrap background="themes/Lexus-Blue/images/center/center_10.gif"></TD>
	</TR>
	
	<TR>
	  <TD ROWSPAN=2>
	    <IMG SRC="themes/Lexus-Blue/images/center/center_11.gif" WIDTH=45 HEIGHT=19 ALT="">
		</TD>
		<TD COLSPAN=3 background="themes/Lexus-Blue/images/center/center_14.gif">
		<IMG SRC="themes/Lexus-Blue/images/center/center_14.gif" WIDTH=100% HEIGHT=10 ALT=""></TD>
	    <TD ROWSPAN=2>
	      <IMG SRC="themes/Lexus-Blue/images/center/center_13.gif" WIDTH=46 HEIGHT=19 ALT="">
		  </TD>
	</TR>
	<TR>
		<TD COLSPAN=3 background="themes/Lexus-Blue/images/center/center_15.gif">
		<IMG SRC="themes/Lexus-Blue/images/center/center_15.gif" WIDTH=100% HEIGHT=9 ALT=""></TD>
	</TR>
</TABLE>
<?
}

function CloseTable2() {
    ?></div></TD>
		<TD width="46"  nowrap background="themes/Lexus-Blue/images/center/center_10.gif"></TD>
	</TR>
	
	<TR>
	  <TD ROWSPAN=2>
	    <IMG SRC="themes/Lexus-Blue/images/center/center_11.gif" WIDTH=45 HEIGHT=19 ALT=""></TD>
		<TD COLSPAN=3 background="themes/Lexus-Blue/images/center/center_14.gif">
		<IMG SRC="themes/Lexus-Blue/images/center/center_14.gif" WIDTH=100% HEIGHT=10 ALT=""></TD>
	    <TD ROWSPAN=2>
	      <IMG SRC="themes/Lexus-Blue/images/center/center_13.gif" WIDTH=46 HEIGHT=19 ALT="">
		  </TD>
	</TR>
	<TR>
		<TD COLSPAN=3 background="themes/Lexus-Blue/images/center/center_15.gif">
		<IMG SRC="themes/Lexus-Blue/images/center/center_15.gif" WIDTH=100% HEIGHT=9 ALT=""></TD>
	</TR>
</TABLE>
<?
}

/************************************************************/
/* Function themeheader()                                   */
/************************************************************/
        function themeheader() {
    global $user, $name, $userinfo, $cookie, $prefix, $user_prefix, $db, $dbi, $sitekey;
    getusrinfo($user);
    cookiedecode($user);
    mt_srand ((double)microtime()*1000000);
    $maxran = 1000000;
    $random_num = mt_rand(0, $maxran);
    $datekey = date("F j");
    $rcode = hexdec(md5($_SERVER["HTTP_USER_AGENT"] . $sitekey . $random_num . $datekey));
    $code = substr($rcode, 2, 6);
    $username = $cookie[1];
    if ($username == "") {
        $username = "You are not logged in";
    }
    $public_msg = public_message(); 
    echo "$public_msg";
    $sql = "SELECT link1, link2, link3, link4, link5, link1url, link2url, link3url, link4url, link5url FROM ".$prefix."_themecp";
$result = $db->sql_query($sql);
$row = $db->sql_fetchrow($result);
$link1 = $row["link1"];
$link2 = $row["link2"];
$link3 = $row["link3"];
$link4 = $row["link4"];
$link5 = $row["link5"];
$link1url = $row["link1url"];
$link2url = $row["link2url"];
$link3url = $row["link3url"];
$link4url = $row["link4url"];
$link5url = $row["link5url"];
    $uresult = $db->sql_query("select user_id from ".$user_prefix."_users where username='$username'");
    list($uid) = $db->sql_fetchrow($uresult);
    $presult = $db->sql_query("select * from ".$prefix."_bbprivmsgs where privmsgs_to_userid='$uid' AND (privmsgs_type='0' OR privmsgs_type='1' OR privmsgs_type='3' OR privmsgs_type='5')");
    $pnumrow = $db->sql_numrows($presult);
    
        $priv_msgs = "&nbsp;<a href=\"modules.php?name=Private_Messages\"><b>$pnumrow</b></a>&nbsp;<img src=\"themes/Lexus-Blue/images/mail.gif\" border=0>";
    if ($username == "You are not logged in") {
        $theuser = "<form action=\"modules.php?name=Your_Account\" method=\"post\"><input type=\"text\" name=\"username\" value=\"username\" onFocus=\"if(this.value=='username')this.value='';\" value style=\"width:90;height:18;\">&nbsp;<input type=\"password\" name=\"user_password\" value=\"password\" onFocus=\"if(this.value=='password')this.value='';\" value style=\"width:90;height:18;\"><input type=\"hidden\" name=\"random_num\" value=\"$random_num\"><input type=\"hidden\" name=\"gfx_check\" value=\"$code\"><input type=\"hidden\" name=\"op\" value=\"login\">&nbsp;<input type=\"image\" class=\"noborder\" value=\"login\" src=\"themes/Lexus-Blue/images/login.gif\" border=\"0\"></TD></form>\n";
    
    } else {
        $theuser = "$priv_msgs&nbsp;&nbsp;<a href=\"modules.php?name=Forums&file=profile&mode=editprofile&sid=\"><img src=\"themes/Lexus-Blue/images/profile.gif\" border=0 alt=profile></a><a href=\"modules.php?name=Your_Account&op=logout\"><img src=\"themes/Lexus-Blue/images/logout.gif\" border=0 alt=logout></a></TD>\n";
    }

       
echo "<body bgcolor=\"#4E4646\" topmargin=\"0\" leftmargin=\"0\" marginwidth=\"0\" marginheight=\"0\">\n";
include("themes/Lexus-Blue/header.php");
include("includes/configtop.php"); 
echo "<table width=\"977\" align=center cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr valign=\"top\">\n";
if (($name=='Private_Messages') OR ($name=='Members_List')OR ($name=='Forums')){ 

echo"<TD WIDTH=\"0\" HEIGHT=\"100%\" valign=top bgcolor=#4E4646>\n";
} else { 

echo"<TD WIDTH=\"60\" HEIGHT=\"100%\" valign=top bgcolor=#4E4646>\n";
blocks("left"); 
} 
echo "</td><TD WIDTH=\"977\" valign=top bgcolor=#4E4646>\n";
}


/************************************************************/
/* Function themefooter()                                   */
/************************************************************/

function themefooter() {
    global $index, $banners;

    if (defined('INDEX_FILE') || ($index == 1)) {
	
	echo "</td>\n"
	    ."<td width=\"160\" valign=\"top\" bgcolor=#4E4646>\n";
	blocks("right");
    }
    echo "</td>\n"
	    ."</tr>\n"
	    ."</table>\n";
     include("themes/Lexus-Blue/footer.php");
   echo "<table width=\"977\" align=center cellpadding=\"0\" cellspacing=\"0\" border=\"0\">\n"
		."<tr valign=\"top\">\n"
    	."<TD WIDTH=\"100%\" valign=top align=center bgcolor=#4E4646>\n";
		 
echo "</td>\n"
	    ."</tr>\n"
	    ."</table>\n";
    
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
    $tmpl_file = "themes/Lexus-Blue/story_home.html";
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
    $tmpl_file = "themes/Lexus-Blue/story_page.html";
    $thefile = implode("", file($tmpl_file));
    $thefile = addslashes($thefile);
    $thefile = "\$r_file=\"".$thefile."\";";
    eval($thefile);
    print $r_file;
}

function themesidebox($title, $content) 
{
    $tmpl_file = "themes/Lexus-Blue/blocks.html";
    $thefile = implode("", file($tmpl_file));
    $thefile = addslashes($thefile);
    $thefile = "\$r_file=\"".$thefile."\";";
    eval($thefile);
    print $r_file;
}
?>