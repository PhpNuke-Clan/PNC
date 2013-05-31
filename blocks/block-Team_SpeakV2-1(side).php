<?php
####################################################################
#  This file is Copyright (c) 2004 Scott Benson                    #
#  fhfghost@fubarfish.com                                                  #
# Code modified to work as module and sql readable                 #
# webmaster@tdi-hq.com                                                     #
# FOR: PNC  http://www.phpnuke-clan.com                            #
# Modification from the central block to side block: CrazyCrack    #
####################################################################



if (eregi("block-TeamspeakV2.php",$_SERVER['PHP_SELF'])) {
    Header("Location: index.html");
}

global $user, $cookie, $prefix, $user_prefix, $db, $anonymous, $sitekey, $sitename, $adminmail ; 

$row = $db->sql_fetchrow($db->sql_query("SELECT * FROM ".$prefix."_teamspeak"));

$ventip =  $row['tsip'];  
$ventport = $row['tsport'];  
$ventpass = $row['tsqport']; 
$adminname = $row['adminname']; 
$tsaway = $row['tsaway']; 
$tsrule1 = $row['tsrule1']; 
$tsrule2 = $row['tsrule2']; 
$tsrule3 = $row['tsrule3']; 

$serverAddress = "$ventip";  // can be ip address or url 
$serverUDPPort = "$ventport";  // default 8767
$serverQueryPort = "$ventpass";  // default 51234, must be accessible and usable. check server.ini 
$awaychannel = "$tsaway"; //If you have a channel that is used for users that are away from there keyboard then enter the name of the channel here.  If not leave blank with quotes.
$adminsname = "$adminname"; //Enter the TS servers admin name
$adminsemail = "$adminmail"; //Enter the TS servers admin email
// The following 3 variables will allow you to show 3 server rules on your block (i.e No Soliciting, No Hot Mics, Mature Audiences Only)
$rule1 = "$tsrule1";
$rule2 = "$tsrule2";
$rule3 = "$tsrule3";
// **** end of settings **** 

//*************************************************************************************************************************
cookiedecode($user);
$username = $cookie[1];

// opens a connection to the teamspeak server 
function getSocket($host, $port, $errno, $errstr, $timeout) { 
   global $errno, $errstr; 
   @$socket = fsockopen($host, $port, $errno, $errstr, $timeout); 
        if($socket and fread($socket, 4) == "[TS]") { 
            fgets($socket, 128); 
            return $socket; 
        }// end if 
        return false; 
}// end function getSocket(...) 

// sends a query to the teamspeak server 
function sendQuery($socket, $query) { 
   fputs($socket, $query."\n"); 
} 

// answer OK? 
function getOK($socket) { 
        $result = fread($socket, 2); 
        fgets($socket, 128); 
        return($result == "OK"); 
} 

// closes the connection to the teamspeak server 
function closeSocket($socket) { 
        fputs($socket, "quit"); 
        fclose($socket); 
} 

// retrieves the next argument in a tabulator-separated string (PHP scanf function bug workaround) 
function getNext($evalString) { 
        $pos = strpos($evalString, "\t"); 
        if(is_integer($pos)) { 
      return substr($evalString, 0, $pos); 
        } 
        else { 
            return $evalString; 
        } 
} 

// removes the first argument in a tabulator-separated string (PHP scanf function bug workaround) 
function chopNext($evalString) { 
        $pos = strpos($evalString, "\t"); 
        if(is_integer($pos)) { 
      return substr($evalString, $pos + 1); 
        } 
        else { 
           return ; 
        } 
} 

// MAIN PROGRAM START 
// establish connection to teamspeak server 
$socket = getSocket($serverAddress, $serverQueryPort, $errno, $errstr, 3); 
if($socket == false) { 
        $content .= "An error connecting to the TeamSpeak server has occured!<br>\n"; 
        $content .= "Error number: ".$errno."<br>\n"; 
        $content .= "Error description: ".$errstr."<br>\n"; 
                $content .= "Please contact a the Server Admin\n";
        return; 
} 

// select the one and only running server on port 8767 
sendQuery($socket, "sel ".$serverUDPPort); 

// retrieve answer "OK" 
if(!getOK($socket)) { 
   die("Server didn't answer &quot;OK&quot; after last command. Aborting."); 
}// end if 

// retrieve player list 
sendQuery($socket,"pl"); 

// read player info 
$playerList = array(); 
do { 
   $playerinfo = fscanf($socket, "%s\t%d\t%d\t%d\t%d\t%d\t%d\t%d\t%d\t%d\t%d\t%d\t%d\t%s\t%s"); 
        list($playerid, $channelid, $receivedpackets, $receivedbytes, $sentpackets, $sentbytes, $d, $d, $totaltime, $idletime, $d, $d, $d, $s, $playername) = $playerinfo; 
        if($playerid != "OK") { 
               $playerList[$playerid] = array(playerid => $playerid, 
                                           channelid => $channelid, 
                                           receivedpackets => $receivedpackets, 
                                           receivedbytes => $receivedbytes, 
                                           sentpackets => $sentpackets, 
                                           sentbytes => $sentbytes, 
                                           totaltime => $totaltime, 
                                           idletime => $idletime, 
                                           playername => $playername); 
        } 
} while($playerid != "OK"); 

// retrieve channel list 
sendQuery($socket,"cl"); 

// read channel info 
$channelList = array(); 
do { 
        $channelinfo = ""; 
        do { 
      $input = fread($socket, 1); 
      if($input != "\n" && $input != "\r") $channelinfo .= $input; 
        } while($input != "\n"); 

        $channelid = getNext($channelinfo); 
        $channelinfo = chopNext($channelinfo); 
        $codec = getNext($channelinfo); 
        $channelinfo = chopNext($channelinfo); 
        $parent = getNext($channelinfo); 
        $channelinfo = chopNext($channelinfo); 
        $d = getNext($channelinfo); 
        $channelinfo = chopNext($channelinfo); 
        $maxplayers = getNext($channelinfo); 
        $channelinfo = chopNext($channelinfo); 
        $channelname = getNext($channelinfo); 
        $channelinfo = chopNext($channelinfo); 
        $d = getNext($channelinfo); 
        $channelinfo = chopNext($channelinfo); 
        $d = getNext($channelinfo); 
        $channelinfo = chopNext($channelinfo); 
        $topic = getNext($channelinfo); 

        if($channelid != "OK") { 
      if($isdefault == "Default") $isdefault = 1; else $isdefault = 0; 

               // determine number of players in channel 
               $playercount = 0; 
               foreach($playerList as $playerInfo) { 
                   if($playerInfo[channelid] == $channelid) $playercount++; 
               } 

               $channelList[$channelid] = array(channelid => $channelid, 
                                             codec => $codec, 
                                             parent => $parent, 
                                             maxplayers => $maxplayers, 
                                             channelname => $channelname, 
                                             isdefault => $isdefault, 
                                             topic => $topic, 
                                             currentplayers => $playercount); 
   } 
} while($channelid != "OK"); 

$content .= "<!-----  drop down ----->\n";
$content .= "<table border=0 align=center target=_blank width=100% cellpadding=0 cellspacing=1>\n";
//$content .= "<table width=\"100%\">\n";
$content .= "<tr><td colspan=2><div align=\"center\"><strong><font color=orange>Active Channel Status</font></strong></div></td></tr>"; 
$counter = 0; 
foreach($channelList as $channelInfo) { 
        if ($channelInfo[isdefault] == 1) { 
    $channelname = $channelInfo[channelname]; 
    }

switch ($channelname) { 
        case "Default":
    $link = "webpost/login.php?detail=9&channel=$channelname"; 
    break; 
}
        $counter++;
                $channelInfo[channelname] = str_replace('"', '', $channelInfo[channelname]);
                if ($channelInfo[currentplayers] == 0) {
                } else {
                $content .="<tr><td colspan=\"2\"><img src=\"images/TS_Block/bullet_channel.gif\" alt=$channelInfo[topic] align=left><strong>$channelInfo[channelname]</strong> ($channelInfo[currentplayers]/$channelInfo[maxplayers])</td></tr>";
                }
                foreach ($playerList as $playerInfo) { 
           
                   if ($channelInfo[channelid] == $playerInfo[channelid]) {
                   $playerInfo[playername] = str_replace('"', '', $playerInfo[playername]);
                                if ($channelInfo[channelname] == "$awaychannel") {
                                $content .= "<tr><td width=\"1%\">&nbsp;</td><td><img src=\"images/TS_Block/bullet_away.gif\" alt=(XMT-Bytes$playerInfo[sentbytes]/RCV-Bytes$playerInfo[receivedbytes]) width=\"48\" height=\"16\" align=left>$playerInfo[playername]</td></tr>\n"; 
                                } else {
                                $content .= "<tr><td width=\"1%\">&nbsp;</td><td><img src=\"images/TS_Block/bullet_user.gif\" alt=(XMTBytes-$playerInfo[sentbytes]/RCVBytes-$playerInfo[receivedbytes]/TotalTime-$playerInfo[totaltime]/IdleTime-$playerInfo[idletime]) width=\"30\" height=\"15\" align=left>$playerInfo[playername]</td></tr>\n";
                                }
                        }
        } 
    } 

$content .= "           <table width=\"100%\"  border=\"0\" cellspacing=\"0\" cellpadding=\"1\">\n";
$content .= "             <tr>\n";
$content .= "               <div align=\"center\"><br><strong><font color=orange>TS Server Info</font></strong></div></td>\n";
$content .= "               <div align=\"center\"><strong>$sitename</strong></div></td><br>\n";
$content .= "               </tr>\n";
$content .= "             <tr>\n";
$content .= "               <div align=\"center\"><strong><font color=orange>Server IP</font></strong></div>\n";
$content .= "               <div align=\"center\"><strong>$serverAddress:$serverUDPPort</strong></div>\n";
$content .= "             </tr>\n";
$content .= "             <tr>\n";
$content .= "               <td colspan=\"2\"><div align=\"center\"><br><strong><font color=orange>Connect to our Server Now</font></strong></div></td>\n";
$content .= "               </tr>\n";
$content .= "             <tr>\n";
$content .="<td colspan=\"2\">\n";
$content  .= "<div align=\"center\"><select name=\"select15\" style=width:125px onChange=\"window.open(this.options[this.selectedIndex].value,'_blank','height=1 width=1')\">";
$content .= "<option>Select...</option>";
foreach($channelList as $channelInfo) {
	$channelInfo[channelname] = str_replace('"', '', $channelInfo[channelname]);
	if ($channelInfo[channelname] == "name") {
	} else {
		if ($channelInfo[parent] == '-1') {
			$content .= "<option value=\"teamspeak://$serverAddress:$serverUDPPort?nickname=$username?channel=$channelInfo[channelname]\">".$channelInfo[channelname]."</option>\n";
			foreach($channelList as $channelInfo2) {
				$channelInfo2[channelname] = str_replace('"', '', $channelInfo2[channelname]);
				if ($channelInfo[channelid] == $channelInfo2[parent]) {
					$content .= "<option value=\"teamspeak://$serverAddress:$serverUDPPort?nickname=$username?channel=$channelInfo[channelname]?subchannel=$channelInfo2[channelname]\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$channelInfo2[channelname]."</option>\n";
				}
			}
		}
	}
}
$content .= "</select></div></form></td>";
$content .= " </tr>\n";
$content .= "</table>\n";  
    // close connection to teamspeak server 
    closeSocket($socket); 

//-----------COPYRIGHT START----------->
//-Please dont't remove this copyright->
$content .= "<A HREF='javascript:PopupCentrer(\"blocks/copyright/fubarfish.html\",400,350,\"menubar=no,scrollbars=no,statusbar=no\")'><div align=\"right\">&copy;</div></A>\n"; 
//-----------COPYRIGHT END------------->
?>
