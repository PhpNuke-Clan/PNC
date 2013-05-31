<?php
if ( !defined('BLOCK_FILE') ) {
    Header("Location: ../index.php");
    die();
}

global $user, $cookie, $prefix, $db, $user_prefix,$uname, $uid;

// # of LANS to show:
$nrlans = 2;
// The Following line is to select the next lan party that has not ended.
$result = $db->sql_query("SELECT * FROM nukelan_parties WHERE enddate > NOW() ORDER BY date ASC");
//

cookiedecode($user);
$ip = $_SERVER["REMOTE_ADDR"];
$uid = $cookie[0];
$uname = $cookie[1];
$content = "";
$numrows = $db->sql_numrows($result);
if (!$numrows) {
        $content = "Sorry, there are no parties at this time.";
}
else
{
$parties = $db->sql_query("SELECT * FROM nukelan_parties WHERE enddate > NOW() ORDER BY date ASC LIMIT ".$nrlans."");
while($row = $db->sql_fetchrow($parties)) {

        //$row = $db->sql_fetchrow($result);
        $num_signedup = $db->sql_numrows($db->sql_query("SELECT * FROM nukelan_signedup WHERE lan_id='$row[party_id]'"));
        $num_paid = $db->sql_numrows($db->sql_query("SELECT * FROM nukelan_signedup WHERE lan_id='$row[party_id]' AND lan_paid='2'"));
        $num_left = $row['max'] - $num_signedup;
				
		//content
        $content .= "<center><b>$row[keyword]</b></center>";
        $content .= "<br>";
        $content .= "&nbsp;&nbsp;&nbsp;Max:&nbsp;$row[max]<br>";
        $content .= "&nbsp;&nbsp;&nbsp;Signedup:&nbsp;$num_signedup<br>";
        $content .= "&nbsp;&nbsp;&nbsp;Paid:&nbsp;$num_paid<br>";
        if($row['stop'] == 0){
		$content .= "&nbsp;&nbsp;&nbsp;Spots Left:&nbsp;$num_left<br>";
		}else{
        $content .= "&nbsp;&nbsp;&nbsp;Spots Left:&nbsp;<font color=\"#FF0000\"><b>Closed</b></font><br>";
		}
        // if there are prizes, show the total value
        $prizes = $db->sql_query("SELECT * FROM nukelan_prizes WHERE config_id='$row[party_id]'");
        if ($db->sql_numrows($prizes)) {
                while ($prz2 = $db->sql_fetchrow($prizes)) {
                        $prizevalue = $prz2['prizevalue'];
                        if ($prz2['prizequantity'] > 1) {
                                $prizevalue = $prz2['prizevalue'] * $prz2['prizequantity'];
                        }
                        $prizequan = $prz2['prizequantity']+$prizequan;
                        $tot_prz_val = $prizevalue+$tot_prz_val;
                }
        $content .= "<br>";
        $content .= "&nbsp;&nbsp;&nbsp;<b>Prizes:</b>&nbsp;$prizequan<br>";
        $content .= "&nbsp;&nbsp;&nbsp;<b>Value:</b>&nbsp;$$tot_prz_val<br>";
        }
        // if you are not signed in as a user it will let you know.
        if (!is_user($user)) {
                $content .= "<center>";
                $content .= "<br>";
                $content .= "You are not registered for this party.";
                $content .= "</center>";
        }       
        // if you are signed in but not signedup for this lan party it will let you know.
        elseif (is_user($user)) {
                $content .= "<center>";
                $user_row = $db->sql_fetchrow($db->sql_query("SELECT * FROM ".$user_prefix."_users WHERE username='$uname'"));
                $lan_result = $db->sql_query("SELECT * FROM nukelan_signedup WHERE lan_id='$row[party_id]' AND lan_uid='$user_row[user_id]'");
                $lan_num = $db->sql_numrows($lan_result);
                $lan_user = $db->sql_fetchrow($lan_result);
                if ($lan_num) {
                        $content .= "<br>";
                        $content .= "You <font color=\"#00FF00\"><b>are</b></font> registered for this party and your status is<br>";
                        if ($lan_user['lan_paid'] == 2) {
                        $content .= "<font color=\"#00FF00\"><b>PAID</b></font><br>";
					    }
                        else {
                        $content .= "<font color=\"#FF0000\"><b>UNPAID</b></font><br>";
                        }
					//cechk if a chair has been selected
						$row1 = $db->sql_fetchrow($db->sql_query("SELECT * FROM `nukelan_signedup` WHERE lan_id='$row[party_id]' AND lan_uid='$uid'"));
				        
						if($row1['room_loc'] == 0){ 
							$content .= "You have <font color=\"#FF0000\"><b>not</b></font> selected a seat yet!!";
							}else{
						
				        $row2 = $db->sql_fetchrow($db->sql_query("SELECT * FROM `nukelan_seat_objects` WHERE id='$row1[room_loc]'"));
				        $description = $row2['description'];
						$capacity = $row2['capacity'];
						$room_id = $row2['room_id'];
						$seatname = $row2['name'];
						$content .= "You have selected seat: <b>$seatname</b>. ";
						}
                }
                else {
                        $content .= "You are <font color=\"#FF0000\"><b>not</b></font> registered for this party.";
                }
                $content .= "</center>";
        }       
        // bottom of content
        $content .= "<br>";
        $content .= "<center><a href=\"modules.php?op=modload&name=Nukelan&file=index&lanop=show_party&party_id=$row[party_id]\">Click Here to see more.</a></center>";
        $content .= "<br>";
		if($numrows > 1){
        $content .= "<hr>";
		}
  }
}

?>
