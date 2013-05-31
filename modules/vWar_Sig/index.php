<?php
/******************************************************************/
/* ============================================================== */
/*         ¤ ¤ ¤ eC-Dynamic-Statistics-Signatures ¤ ¤ ¤           */
/* ============================================================== */
/*                           [ v1.0 ]                             */
/*                                                                */
/*               ¤ ¤ ¤ PHP-Nuke Statistics ¤ ¤ ¤                  */
/*                                                                */
/* -Local Site Triggered Dynamic Statistics Signature Generation  */
/*     [Single Image | Multiple Images, Random]                   */
/*                                                                */
/* -Global Sites Triggered Dynamic Statistics Signature Generation*/
/*     [Single Image | Multiple Images, Random]                   */
/*                                                                */
/* <=> "Basic" Dynamic Stats pulled out from PHP-Nuke DB ONLY     */
/*                                                                */
/*             ¤ ¤ ¤ PHP-Nuke Mod+ Statistics ¤ ¤ ¤               */
/*                                                                */
/* -Local Site Triggered Dynamic Statistics Signature Generation  */
/*     [Single Image | Multiple Images, Random]                   */
/*                                                                */
/* -Global Sites Triggered Dynamic Statistics Signature Generation*/
/*     [Single Image | Multiple Images, Random]                   */
/*                                                                */
/* <=> "Basic" Dynamic Stats pulled out from PHP-Nuke and vWar DB */
/*                                                                */
/******************************************************************/
/*                                                                */
/* by beetraham aka ZenoCide / admin@ec-clan.org (c) 2004         */
/* http://www.ec-clan.org :: Easy Company - A Finnish BF1942 Clan */
/*                                                                */
/******************************************************************/
/* This program is free software. You can redistribute it and/or  */ 
/* modify it under the terms of the GNU General Public License as */
/* published by the Free Software Foundation; either version 2 of */
/* the License.                                                   */
/******************************************************************/
/*            ¤ ¤ ¤ Credits and Acknowledgements ¤ ¤ ¤            */
/******************************************************************/
/* Following PHP-Nuke Entities have been used as a modification & */
/* enhancements basis into a great extent:                        */
/*                                                                */
/* ¤¤¤ phpBB2 Dynamic Statistics Signature ¤¤¤ (v1.0]             */
/*     - by thainuke / webmaster@thainuke.net                     */
/*     - Home Page: http://www.thainuke.net :: PHP-Nuke Thailand  */
/******************************************************************/

////////////////////////////////////////////////////////////////////
/*                                                                */
/*            ¤ ¤ ¤ IMPORTANT NOTICE - MUST READ ¤ ¤ ¤            */
/*                                                                */
/*    - - - <FILE> : signature_DSS_SINGLE_advanced.php - - -      */
/*                                                                */
/* This sig <FILE> will function ONLY if you have PHP-Nuke Add-On */
/* "Virtual War v1.4.0 PHPNuke Version (44) by EcoSys" being setup*/
/* on your web server!                                            */
/*                                                                */
/* Version v1.1 will cover more *Online Gaming Management Systems */
/* - if you are unsure whether your favourite system will be set  */
/* available as a supported system, then please contact by email  */
/* or forums - looking forward to that occasion!                  */
/*                                                                */
/* -beetraham aka ZenoCide | admin@ec-clan.org                    */
/* http://www.ec-clan.org :: Easy Company - A Finnish BF1942 Clan */
////////////////////////////////////////////////////////////////////
if ( !defined('MODULE_FILE') )
{
	die("You can't access this file directly...");
}

$index = 1;
//Right blocks to show? Set to TRUE:
define('INDEX_FILE', true);
//require_once("mainfile.php");

require_once("mainfile.php");
$module_name = basename(dirname(__FILE__));
include("header.php");
include_once("modules/vwar/includes/_config.inc.php");

if (!extension_loaded("gd")){
OpenTable();
echo"<CENTER>You don't have GD-Library installed on your server, please install this feature or ask your host about it.</CENTER>";

CloseTable();
}else{
global $prefix, $db, $admin_file, $action, $id2, $id, $startdate, $ec_signaturehits, $n;


OpenTable();


$imagetray       = "vwarsig/"; // if you alter the path, keep in mind that trailing slash is required!
$shownimage      = "modules/".$module_name."/images/signature.png";                       // PNG used as a template - you may assing any PNG TEMPLATE image accordingly.
$targetimagecopy = "modules/".$module_name."/sig/stats.png";      // This is the image that will be "left at the web server as image to be 
                                              
///////////////////////////////////////////////
// *** PHP-Nuke dedicated MySQL Queries *** //
/////////////////////////////////////////////
//

list($count) = $db->sql_fetchrow($db->sql_query("SELECT SUM(hits) as hits FROM {$prefix}_stats_year"));
list($sitename) = $db->sql_fetchrow($db->sql_query("SELECT sitename FROM ".$prefix."_config")); 
list($overall) = $db->sql_fetchrow($db->sql_query("SELECT COUNT(*) FROM ".$user_prefix."_users")); 
list($lastuser) = $db->sql_fetchrow($db->sql_query("SELECT username FROM ".$user_prefix."_users order by user_id DESC limit 0,1")); 
list($member_online_num) = $db->sql_fetchrow($db->sql_query("SELECT COUNT(*) FROM ".$prefix."_session WHERE guest = 0")); 
list($guest_online_num) = $db->sql_fetchrow($db->sql_query("SELECT COUNT(*) FROM ".$prefix."_session WHERE guest = 1")); 
$who_online_num = $guest_online_num + $member_online_num;
//
///////////////////////////////////////////
// *** vWar dedicated MySQL Queries *** //
/////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////
// + picking up only the lines (clan war items) being set visible + //
// * performing checks regarding "Clan War* classes                // 
// * - "resultbylocations==1" (wars won by rounds ownage)         //
// * - "resultbylocations==0" (wars won by sum of total scores)  //
//////////////////////////////////////////////////////////////////
//
// Note : The use of this structure assumes that you are keeping
// the *vWar BD Tables* at the same physical DB as your PHP-Nuke 
// Tables!!! Also note the standard *hardcoded* form of assigning
// the *names* for the accessed MySQL Tables, ie. (vwar; vwar_scores)
//
// first, extracting the total number of rounds being set publically visible
//
// Capturing follwowing *vWar* related information into Dynamically Generated Signature
//    - $wars_total
//    - $wars_won
//    - $wars_lost
//    - $wars_draw
//
///////////////////////////////////////////////////////////////////////
// initializing variables (used as integers in counting procedures) //
/////////////////////////////////////////////////////////////////////
//
$wars_total    =0;
$wars_won      =0;
$wars_lost     =0;
$wars_draw     =0;
$ownscorestotal =0;
$oppscorestotal =0;
//
//////////////////////////////////////////////////////////////////////
// performing the *vWar* Stats extraction related MySQL DB Queries //
////////////////////////////////////////////////////////////////////
//
list($wars_total) = $db->sql_fetchrow($db->sql_query("SELECT COUNT(warid) FROM vwar".$n." WHERE status = '1'")); 
//
$result=$db->sql_query("SELECT warid,resultbylocations FROM vwar".$n." WHERE status = '1'");
//
while($row = $db->sql_fetchrow($result)) {
    ////////////////////////////////////////////////////////////////
    // matches which END STATUS is defined by *won round counts* //
    //////////////////////////////////////////////////////////////
    if($row["resultbylocations"]==0) {
        $result2=$db->sql_query("SELECT ownscore, oppscore FROM vwar".$n."_scores WHERE warid='".$row["warid"]."'");
        while ($scores=$db->sql_fetchrow($result2)) { 
            $ownscores      =$scores["ownscore"];
            $oppscores      =$scores["oppscore"];
            $oppscorestotal =$oppscorestotal+$oppscores; // summing the round scores 
            $ownscorestotal =$ownscorestotal+$ownscores; // summing the round scores
        }
    ////////////////////////////////////////////////////////////////
    // matches which END STATUS is defined by *won round counts* //
    //////////////////////////////////////////////////////////////
    } elseif($row["resultbylocations"]==1) {
        $result2=$db->sql_query("SELECT ownscore,oppscore from vwar".$n."_scores WHERE warid='".$row["warid"]."'");
        while ($scores=$db->sql_fetchrow($result2)) { 
            if($scores["ownscore"] < $scores["oppscore"])     $oppscorestotal=$oppscorestotal+1; // summing the intermediate results
            elseif($scores["ownscore"] > $scores["oppscore"]) $ownscorestotal=$ownscorestotal+1; // summing the intermediate results
        }
    }
    ///////////////////////////////////////////
    // EVALUATING THE END RESULT OF A MATCH //
    /////////////////////////////////////////
    //
    // incrementing one by one the processed *match end-status* categories per extracted results
    //
    if    ($ownscorestotal > $oppscorestotal)  $wars_won++;  // integer incrementation in case of OWN TEAM victory
    elseif($ownscorestotal < $oppscorestotal)  $wars_lost++; // integer incrementation in case of OWN TEAM defeat
    elseif($ownscorestotal == $oppscorestotal) $wars_draw++; // integer incrementation in case of DRAW
//
unset($ownscorestotal); // unassigning the totals to perform another evaluation round
unset($oppscorestotal); // unassigning the totals to perform another evaluation round
}
///////////////////////////
// Next Action examined //
/////////////////////////
$numnextactions = "1"; // only (1) pcs of next actions shown
$numnextwars=$db->sql_numrows($db->sql_query("SELECT * FROM vwar".$n." WHERE status='0' AND dateline > '".time()."'", $dbi));
if($numnextwars>0) {
    $result=$db->sql_query("SELECT vwar.gameid, vwar.gametypeid, vwar.matchtypeid, status, dateline,oppnameshort,matchtypename,gametypename,ownnameshort FROM vwar".$n.",vwar_matchtype,vwar".$n."_gametype,vwar".$n."_opponents,vwar".$n."_settings WHERE vwar".$n.".oppid=vwar".$n."_opponents.oppid AND vwar".$n.".gametypeid=vwar".$n."_gametype.gametypeid AND vwar".$n."_matchtype.matchtypeid=vwar".$n.".matchtypeid AND status='0' AND dateline > '".time()."' ORDER BY dateline ASC LIMIT 0,$numnextactions", $dbi);
    while(list($gameid, $gametypeid,$matchtypeid,$status,$dateline,$oppname,$matchtype,$gametype,$ownname)=$db->sql_fetchrow($result)) {
        $vwaractions1 = "".date("d.m.Y H:i",$dateline)." : $ownname vs. $oppname";
        $vwaractions2 = "$matchtype : $gametype";
    }
}else{
    $vwaractions = "No Next Actions";
}

///////////////////////////
// Settings examined    //
/////////////////////////
	$resvw = $db->sql_query("SELECT ownname, ownhomepage, ownnameshort FROM vwar".$n."_settings");
	$rvw = $db->sql_fetchrow($resvw);
	$vwsigurl = $rvw['ownhomepage'];
	$vwsigurl= ereg_replace("http://", " ", $vwsigurl);
	$vwsigname = $rvw['ownname'];
	$vwsignamesh = $rvw['ownnameshort'];


///////////////////////////////////////////////////////////////////////////////////////////////////
// passing the queried information forward to be used for Dynamic Signature Generation purposes //
/////////////////////////////////////////////////////////////////////////////////////////////////
//
//////////////////////////////////////////////////////////////////////////////////////////////////
// START : performing ¤ ¤ ¤ eC-Dynamic-Statistics-Signatures ¤ ¤ ¤  totalhits fecting & update //
////////////////////////////////////////////////////////////////////////////////////////////////
//
// Q : What if I have not uploaded the required MySQL DUMP to PHP-Nuke database for these purposes?
// A : There will be a message "not enabled" in the generated signature - so, that's resolved.
//
// Note : if your database prefix ($prefix) is other that *nuke*, then change it accordingly before uploading the MySQL DUMP.
//        <=> otherwise you won't get rid of the message "not enabled"
//
// fetching *TOTAL IMPRESSIONS COUNT* information from MySQL DB
//
//$result = $db->sql_fetchrow($db->sql_query("SELECT totalhits FROM ".$prefix."_ec_signaturehits"));
//$totalhits = $result["totalhits"];
//
//If the variable has extracted content, then let's update the *Total Impressions Count*
//
//if($result){ 
//$db->sql_query("UPDATE ".$prefix."_ec_signaturehits SET totalhits=totalhits+1"); 
//}
//
// Conditional re-fetching *TOTAL IMPRESSIONS COUNT* information from MySQL DB (due to performed update, if performed)
//
//if($result){
//$result = $db->sql_fetchrow($db->sql_query("SELECT totalhits FROM ".$prefix."_ec_signaturehits"));
//$totalhits = $result["totalhits"];
//}
$totalhits=1;
//
////////////////////////////////////////////////////////////////////////////////////////////////
// END : performing ¤ ¤ ¤ eC-Dynamic-Statistics-Signatures ¤ ¤ ¤  totalhits fecting & update //
//////////////////////////////////////////////////////////////////////////////////////////////
//
// You may want to adjust the used colours and texts according to your preferences ---->
//
// Further Information on used GDLIB associated PHP functions:
//  
// imagecreatefrompng : See [ http://www.php.net/manual/en/function.imagecreatefrompng.php ] for further advice.
// imagecolorallocate : See [ http://www.php.net/manual/en/function.imagecolorallocate.php ] for further advice.
// imagestring        : See [ http://www.php.net/manual/en/function.imagestring.php ]        for further advice.
// imagepng           : See [ http://www.php.net/manual/en/function.imagepng.php ]           for further advice.
//

$image  = $shownimage;                             // initial PNG template declaration
$im     = imagecreatefrompng("$image");             // PNG template assigned to actively processed variable
$tc     = imagecolorallocate ($im, 250, 250, 250); // basic Text Colour
$now    = date("M d,Y H:i:s");                     // extracted date during processing
$orange = imagecolorallocate ($im, 250, 210, 50);  // colour #1
$green  = imagecolorallocate ($im, 0, 255, 0);     // colour #2
$red    = imagecolorallocate ($im, 255, 0, 0);     // colour #3
$blue   = imagecolorallocate ($im, 0, 0, 255);     // colour ¤4
$grey   = imagecolorallocate ($im, 120, 120, 120); // colour ¤5
$j      = strlen($lastuser);                       // string lenght of the Last Registered Member
$space  = $j*6+320;                                // assigned generic, username lenght dependent, *space*
//echo"1: $totalhits<br>, 2: $ownscorestotal<br>, 3: $vwaractions<br>, 4: $vwaractions1<br>, 5: $vwaractions2";


//
// [ See http://www.php.net/manual/en/function.imagestring.php for further advice. ] 
//
// MAIN ARCHITECTURAL STRUCTURE - TEXT RELATIVE LOCATIONS DECLARED AND ASSIGNED 
//

imagestring($im, 1, 100, 5, "*** ".$vwsigurl."  *** ", $tc); 
imagestring($im, 1, 240, 5, "[ $now ]", $tc); 
imagestring($im, 1, 100, 16, "[ ($count) page views since $startdate ]", $tc); 
imagestring($im, 2, 100, 25, "".$vwsigname." ", $tc); 
imagestring($im, 2, 265, 25, "", $orange);
imagestring($im, 1, 95, 41, " We've fought in ($wars_total) Wars, of which ", $tc);  
imagestring($im, 1, 100, 50, "($wars_won)Won, ", $green); 
imagestring($im, 1, 140, 50, "($wars_lost)Lost ", $red); 
imagestring($im, 1, 190, 50, "and ", $tc); 
imagestring($im, 1, 210, 50, "($wars_draw)Draws", $blue);
imagestring($im, 1, 100, 63, "Next Actions", $orange); 
if($numnextwars>0) {
imagestring($im, 1, 165, 63, ": [ $vwaractions1 ]", $green); 
imagestring($im, 1, 165, 73, ": [ $vwaractions2 ]", $orange);
} else {
imagestring($im, 1, 165, 63, ": [ $vwaractions ]", $red); 
}
// eC-Dynamic-Statistics-Signature MySQL DB access
if($totalhits){
	imagestring($im, 1, 100, 73, "[$totalhits]", $grey); 
} else {
	imagestring($im, 1, 100, 73, "[-]", $grey); 
}

// creating both an *online image* and a copy of it to be optionally accessed instead of *signature[xxx].php
//header("Content-Type: image/png");
//  $image = "signature.png";        
//  $img = imagecreatefrompng($image);
//imagepng($im);
//imagepng   ($im,'',100);                 // creating an online ***Up-To-Date*** PNG image out of the extracted CMS Statistics
imagepng   ($im,"".$targetimagecopy.""); //  copying an online ***Up-To-Date*** PNG image out of the extracted CMS Statistics


echo"<img src=\"".$targetimagecopy."\">";
CloseTable();
}//end else loop if GD is onstalled
include("footer.php"); 
?>