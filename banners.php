<?php

######################################################################
# PHP-NUKE: Web Portal System
# ===========================
#
# Copyright (c) 2000 by Francisco Burzi (fburzi@ncc.org.ve)
# http://phpnuke.org
#
# This modules is to have a complete Banner Ad solution integrated
#
# This program is free software. You can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License.
######################################################################

if (!isset($config)) { include("config.php"); }
if (eregi("banners.php",$PHP_SELF)) include("mainfile.php");
dbconnect();

/********************************************/
/* Function to display banners in all pages */
/********************************************/

function viewbanner() {
    $bresult = mysql_query("select * from banner");
    $numrows = mysql_num_rows($bresult);

// Get a random banner if exist any.
// More efficient random stuff, thanks to Cristian Arroyo from http://www.planetalinux.com.ar

    if ($numrows>1) {
	$numrows = $numrows-1;
	mt_srand((double)microtime()*1000000);
	$bannum = mt_rand(0, $numrows);
    } else {
	$bannum = 0;
    }
    $bresult2 = mysql_query("select bid, imageurl from banner limit $bannum,1");
    list($bid, $imageurl) = mysql_fetch_row($bresult2);
    
    global $myIP;
    $myhost = getenv("REMOTE_ADDR");
    if($myIP==$myhost) {
    } else {
	mysql_query("update banner set impmade=impmade+1 where bid=$bid");
    }
    if($numrows>0) {
	$aborrar = mysql_query("select cid, imptotal, impmade, clicks, date from banner where bid=$bid");
	list($cid, $imptotal, $impmade, $clicks, $date) = mysql_fetch_row($aborrar);

// Check if this impression is the last one and print the banner

	if($imptotal==$impmade) {
	    mysql_query("insert into bannerfinish values (NULL, '$cid', '$impmade', '$clicks', '$date', now())");
	    mysql_query("delete from banner where bid=$bid");
	}
    echo"<center><a href=banners.php?op=click&bid=$bid target=_blank><img src=$imageurl border=1></a></center><br>";
    }
    mysql_free_result($bresult);
    mysql_free_result($bresult2);
    if($aborrar) {
	mysql_free_result($aborrar);
    }
    
}

/********************************************/
/* Function to redirect the clicks to the   */
/* correct url and add 1 click              */
/********************************************/

function clickbanner($bid) {
    $bresult = mysql_query("select clickurl from banner where bid=$bid");
    list($clickurl) = mysql_fetch_row($bresult);
    mysql_query("update banner set clicks=clicks+1 where bid=$bid");
    mysql_free_result($bresult);
    Header("Location: $clickurl");
}

/********************************************/
/* Function to let your client login to see */
/* the stats                                */
/********************************************/

function clientlogin() {
    echo"
    <html>
    <body bgcolor=AA9985 text=000000 link=006666 vlink=006666>
    <center><br><br><br><br>
    <table width=200 cellpadding=0 cellspacing=1 border=0 bgcolor=000000><tr><td>
    <table width=100% cellpadding=5 cellspacing=1 border=0 bgcolor=FFFFFF><tr><td colspan=1 bgcolor=eecfa1>
    <center><b>Advertising Statistics</b>
    </td></tr><tr><td bgcolor=fffacd>
    <form action=banners.php method=post>
    Login: <input class=textbox type=text name=login size=12 maxlength=10><br>
    Password: <input class=textbox type=password name=pass size=12 maxlength=10><br>
    <input class=textbox type=hidden name=op value=Ok>
    <input type=submit value=Login></td></tr><tr><td bgcolor=eecfa1>
    <font size=2>
    <center>Please type your client information</center>
    </td></tr></table></td></tr></table></form></font>
    </body></html>";
}

/*********************************************/
/* Function to display the banners stats for */
/* each client                               */
/*********************************************/

function bannerstats($login, $pass) {
    if (!isset($config)) { include("config.php"); }
    $result = mysql_query("select cid, name, passwd from bannerclient where login='$login'");
    list($cid, $name, $passwd) = mysql_fetch_row($result);
    
    if($login=="" AND $pass=="" OR $pass=="") {
	echo "<center><br>Login Incorrect!!!<br><br><a href=javascript:history.go(-1)>Back to Login Screen</a></center>";
    } else {
    
    if ($pass==$passwd) {
    
    echo"
    <html>
    <body bgcolor=AA9985 text=000000 link=006666 vlink=006666>
    <center>
    <table border=0 width=100% cellpadding=0 cellspacing=1 bgcolor=000000><tr><td>
    <table border=0 width=100% cellpadding=8 cellspacing=1 bgcolor=fffacd><tr><td>
    <font size=3>
    <center><b>Current Active Banners for $name</b></center><br>
    <font size=3>
    <table width=100% border=0><tr>
    <td bgcolor=887765><font color=Black><center><b>ID</b></td>
    <td bgcolor=887765><font color=Black><center><b>Imp. Made</b></td>
    <td bgcolor=887765><font color=Black><center><b>Imp. Total</b></td>
    <td bgcolor=887765><font color=Black><center><b>Imp. Left</b></td>
    <td bgcolor=887765><font color=Black><center><b>Clicks</b></td>
    <td bgcolor=887765><font color=Black><center><b>% Clicks</b></td>
    <td bgcolor=887765><font color=Black><center><b>Functions</b></td><tr>";
    $result = mysql_query("select bid, imptotal, impmade, clicks, date from banner where cid='$cid'");
    while(list($bid, $imptotal, $impmade, $clicks, $date) = mysql_fetch_row($result)) {
        if($impmade==0) {
    	    $percent = 0;
        } else {
    	    $percent = substr(100 * $clicks / $impmade, 0, 5);
        }

        if($imptotal==0) {
    	    $left = "Unlimited";
        } else {
    	    $left = $imptotal-$impmade;
        }
        echo "
        <td bgcolor=AA9985 align=center><font color=White>$bid</td>
        <td bgcolor=AA9985 align=center><font color=White>$impmade</td>
        <td bgcolor=AA9985 align=center><font color=White>$imptotal</td>
	<td bgcolor=AA9985 align=center><font color=White>$left</td>
        <td bgcolor=AA9985 align=center><font color=White>$clicks</td>
        <td bgcolor=AA9985 align=center><font color=White>$percent%</td>
        <td bgcolor=AA9985 align=center><font color=White><a href=banners.php?op=EmailStats&login=$login&cid=$cid&bid=$bid>E-mail Stats</a></td><tr>";
    }
    echo "
    </td></tr></table>
    <center><br><br>
    Following are your running Banners in $sitename<br><br>";

    $result = mysql_query("select bid, imageurl, clickurl from banner where cid='$cid'");
    while(list($bid, $imageurl, $clickurl) = mysql_fetch_row($result)) {

	$numrows = mysql_num_rows($result);
	if ($numrows>1) {
	    echo "<hr noshade width=80%><br>";
	}

	echo "<img src=$imageurl border=1><br>
	<font size=2>Banner ID: $bid<br>
	Send <a href=banners.php?op=EmailStats&login=$login&cid=$cid&bid=$bid>E-Mail Stats</a> for this Banner<br>
	This Banners points to <a href=$clickurl>this URL</a><br>
	<form action=banners.php method=submit>
	Change URL: <input class=textbox type=text name=url size=50 maxlength=200 value=$clickurl>
	<input class=textbox type=hidden name=login value=$login>
	<input class=textbox type=hidden name=bid value=$bid>
	<input class=textbox type=hidden name=pass value=$pass>
	<input class=textbox type=hidden name=cid value=$cid>
	<input type=submit name=op value=Change></form>";
    }
    echo "
    </td></tr></table></td></tr></table>
    </font>";


// Finnished Banners
    
    echo "
    <center><br>
    <table border=0 width=100% cellpadding=0 cellspacing=1 bgcolor=000000><tr><td>
    <table border=0 width=100% cellpadding=8 cellspacing=1 bgcolor=fffacd><tr><td>
    <font size=3>
    <center><b>Banners Finished for $name</b></center><br>
    <font size=3>
    <table width=100% border=0><tr>
    <td bgcolor=887765><font color=Black><center><b>ID</b></td>
    <td bgcolor=887765><font color=Black><center><b>Impressions</b></td>
    <td bgcolor=887765><font color=Black><center><b>Clicks</b></td>
    <td bgcolor=887765><font color=Black><center><b>% Clicks</b></td>
    <td bgcolor=887765><font color=Black><center><b>Start Date</b></td>
    <td bgcolor=887765><font color=Black><center><b>End Date</b></td><tr>";
    $result = mysql_query("select bid, impressions, clicks, datestart, dateend from bannerfinish where cid='$cid'");
    while(list($bid, $impressions, $clicks, $datestart, $dateend) = mysql_fetch_row($result)) {
        $percent = substr(100 * $clicks / $impressions, 0, 5);
	echo "
        <td bgcolor=AA9985 align=center><font color=White>$bid</td>
        <td bgcolor=AA9985 align=center><font color=White>$impressions</td>
        <td bgcolor=AA9985 align=center><font color=White>$clicks</td>
	<td bgcolor=AA9985 align=center><font color=White>$percent%</td>
        <td bgcolor=AA9985 align=center><font color=White>$datestart</td>
        <td bgcolor=AA9985 align=center><font color=White>$dateend</td><tr>";
    }
echo "
</td></tr></table></td></tr></table></td></tr></table>
<br><a href=http://linuxpreview.org><img src=images/powered/phpnuke.gif border=0 Alt=\"This site Powered by PHP-Nuke\"></a>
</body></html>";
    
    } else {
    echo "<center><br>Login Incorrect!!!<br><br><a href=javascript:history.go(-1)>Back to Login Screen</a></center>";    
    }
    }

}

/*********************************************/
/* Function to let the client E-mail his     */
/* banner Stats                              */
/*********************************************/

function EmailStats($login, $cid, $bid, $pass) {
    if (!isset($config)) { include("config.php"); }
    $result2 = mysql_query("select name, email from bannerclient where cid='$cid'");
    list($name, $email) = mysql_fetch_row($result2);
    if ($email=="") {
	echo "
	<html>
	<body bgcolor=AA9985 text=000000 link=006666 vlink=006666>
	<center><br><br><br>
	<b>Statistics for Banner No. $bid can't be send because<br>
	there isn't an email associated with client $name<br>
	Please contact the Administrator<br><br></b>
	<a href=javascript:history.go(-1)>Back to Banners Stats</a>
	";
    } else {
	$result = mysql_query("select bid, imptotal, impmade, clicks, imageurl, clickurl, date from banner where bid='$bid' and cid='$cid'");
	list($bid, $imptotal, $impmade, $clicks, $imageurl, $clickurl, $date) = mysql_fetch_row($result);
        if($impmade==0) {
    	    $percent = 0;
        } else {
    	    $percent = substr(100 * $clicks / $impmade, 0, 5);
        }

        if($imptotal==0) {
    	    $left = "Unlimited";
	    $imptotal = "Unlimited";
        } else {
    	    $left = $imptotal-$impmade;
        }
	$fecha = date("F jS Y, h:iA.");
	$subject = "Your Banner Statistics at $sitename";
	$message = "Following are the complete stats for your advertising investment at $sitename:\n\n\nClient Name: $name\nBanner ID: $bid\nBanner Image: $imageurl\nBanner URL: $clickurl\n\nImpressions Purchased: $imptotal\nImpressions Made: $impmade\nImpressions Left: $left\nClicks Received: $clicks\nClicks Percent: $percent%\n\n\nReport Generated on: $fecha";
	$from = "$sitename";
	mail($email, $subject, $message, "From: $from\nX-Mailer: PHP/" . phpversion());

	echo "
	<html>
	<body bgcolor=AA9985 text=000000 link=006666 vlink=006666>
	<center><br><br><br>
	<b>Statistics for Banner No. $bid has been send to<br>
	<i>$email</i> of $name<br><br></b>
	<a href=javascript:history.go(-1)>Back to Banners Stats</a>
	";
    }
}

/*********************************************/
/* Function to let the client to change the  */
/* url for his banner                        */
/*********************************************/

function change_banner_url_by_client($login, $pass, $cid, $bid, $url) {
    $result = mysql_query("select passwd from bannerclient where cid='$cid'");
    list($passwd) = mysql_fetch_row($result);
    if ($pass==$passwd) {
	mysql_query("update banner set clickurl='$url' where bid='$bid'");
    }
    echo "<center><br>You changed the URL<br><br><a href=javascript:history.go(-1)>Back to Stats Page</a></center>";
}

switch($op) {

    case "click":
	clickbanner($bid);
	break;

    case "login":
	clientlogin();
	break;

    case "Ok":
	bannerstats($login, $pass);
	break;

    case "Change":
	change_banner_url_by_client($login, $pass, $cid, $bid, $url);
	break;

    case "EmailStats":
	EmailStats($login, $cid, $bid, $pass);
	break;
	
    default:
	viewbanner();
	break;
}
?>