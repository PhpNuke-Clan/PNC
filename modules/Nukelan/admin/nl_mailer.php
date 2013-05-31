<?php
//  filename: nl_mailer.php

if (!defined('ADMIN_FILE')) {
	die ("Access Denied");
}
$result = sql_query("select radminlan_parties, radminsuper from ".$prefix."_authors where aid='$aid'", $dbi);
list($radminlan_parties, $radminsuper) = sql_fetch_row($result, $dbi);
global $db, $prefix,$admin_file;

/*********************************************************/
/* Sections Manager Functions                            */
/*********************************************************/

function newsletter($pid) {
    global $db, $prefix,$prefix, $user_prefix, $dbi, $sitename, $admin_file;
    include("header.php");
	lan_menu();
    $party = $db->sql_fetchrow($db->sql_query("SELECT * FROM nukelan_parties WHERE party_id='$pid'"));
  OpenTable();
  echo "<center><font class=\"title\"><b>"._NLLANNEWSLETTER."</b></font></center>";
  CloseTable();
  echo "<br>";
  OpenTable();
    echo "<center><font class=\"content\"><b>$party[keyword] Newsletter</b></font></center>"
        ."<br><br>"
        ."<form method=\"post\" action=\"".$admin_file.".php\">"
		."<input type=\"hidden\" name=\"op\" value=\"mass_mail\">"
        ."<input type=\"hidden\" name=\"lanop\" value=\"check_type\">"
        ."<b>"._NLFROM."</b> $sitename"
        ."<br><br>"
        ."<b>"._NLSUBJECT."</b><br><input type=\"text\" name=\"subject\" size=\"50\">"
        ."<br><br>"
        ."<b>"._NLCONTENT."</b><br><textarea name=\"content\" cols=\"50\" rows=\"10\"></textarea>"
        ."<br><br>"
        ."<b></b><br>"
		."<input type=\"hidden\" name=\"pid\" value=\"$pid\">"
        ."<input type=\"submit\" value=\""._NLPREVIEW."\">"
        ."</form>";

      CloseTable();
    include("footer.php");
}

function check_type($subject, $content, $pid) {
    global $db, $prefix,$user_prefix, $dbi, $sitename, $admin_file;
    include("header.php");
    lan_menu();
	$party = $db->sql_fetchrow($db->sql_query("SELECT * FROM nukelan_parties WHERE party_id='$pid'"));
    $srow = sql_num_rows(sql_query("select * from nukelan_signedup where lan_id='$pid'", $dbi), $dbi);
    OpenTable();
    echo "<center><font class=\"title\"><b>Lan Party Newsletter</b></font></center>";
    CloseTable();
    echo "<br>";
    OpenTable();
    $content = stripslashes($content);
        echo "<center><font class=\"content\"><b>$party[keyword] Newsletter</b></font>"
            ."<br><br>"
            ."<form action\"".$admin_file.".php\" method=\"post\">"
			."<input type=\"hidden\" name=\"op\" value=\"mass_mail\">"
            ."<input type=\"hidden\" name=\"lanop\" value=\"newsletter_send\">"
            .""._NYOUAREABOUTTOSEND."<br>"
            ."<b>$srow</b> "._NUSERWILLRECEIVE."<br><br>"
            ."<b>"._REVIEWTEXT."</b></center><br><br>"
            ."<b>"._FROM.":</b> $sitename<br><br>"
            ."<b>"._SUBJECT.":</b><br><input type=\"text\" name=\"title\" value=\"$subject\" size=\"50\"><br><br>"
            ."<b>"._CONTENT.":</b><br><textarea name=\"content\" cols=\"50\" rows=\"10\">$content</textarea><br><br><br><br>"
            ."<b>"._NAREYOUSURE2SEND."</b><br><br>"
			."<input type=\"hidden\" name=\"pid\" value=\"$pid\">"
            ."<input type=\"submit\" value=\""._SEND."\"> &nbsp;&nbsp; "._GOBACK.""
            ."</form>";
    
    CloseTable();
    include("footer.php");
}

function newsletter_send($title, $content, $pid) {
	global $db, $prefix,$user_prefix, $sitename, $dbi, $nukeurl, $adminmail;
	$party = $db->sql_fetchrow($db->sql_query("SELECT * FROM nukelan_parties WHERE party_id='$pid'"));
	$from = $adminmail;
	$subject = "[$sitename "._NLLANNEWS."]: ".stripslashes($title);"";
	$content = stripslashes($content);
	$content = "$sitename: $party[keyword] "._NLLANNEWS."\n\n\n$content\n\n- $sitename "._NLNEWSSTAFF."";
	//$result = sql_query("select email from nukelan_signedup where lan_id='$pid'", $dbi);
	$result = sql_query("select l.*, u.* from nuke_users as l left join nukelan_signedup as u on (l.user_id=u.lan_uid) where u.lan_id='$pid'", $dbi);
	while ($row = sql_fetch_array($result, $dbi)) {
		$user_email = "$row[user_email]";
		mail($user_email, $subject, $content, ""._NLFROM." $from\nX-Mailer: PHP/" . phpversion());
	}
	Header("Location: ".$admin_file.".php?op=mass_mail&lanop=newsletter_sent");
}
function newsletter_sent($pid) {
    include("header.php");
    lan_menu();
	$party = $db->sql_fetchrow($db->sql_query("SELECT * FROM nukelan_parties WHERE party_id='$pid'"));
    OpenTable();
    echo "<center><font class=\"title\"><b>"._NLPARTYNEWSLETTER."</b></font></center>";
    CloseTable();
    echo "<br>";
    OpenTable();
    echo "<center><font class=\"content\"><b>$party[keyword] "._NLNEWSLETTER."</b></font><br><br>";
    echo "<b>"._NEWSLETTERSENT."</b></center>";
    CloseTable();
    include("footer.php");
}

switch ($lanop) {

    case "newsletter":
    newsletter($pid);
    break;

    case "newsletter_send":
    newsletter_send($title, $content, $pid);
    break;

    case "newsletter_sent":
    newsletter_sent($pid);
    break;

    case "check_type":
    check_type($subject, $content, $pid);
    break;
	
	default:
	newsletter($pid);
	break;

}
?>