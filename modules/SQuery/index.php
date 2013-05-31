<?

/************************************************************************/
/*  Squery 4.6.1  PHPNuke Module                                          */
/* =================================================                    */
/*                                                                      */
/* Copyright (c) 2006 SQuery Inc A Nevada Corporation                   */
/*    (webmaster@squery.com)                                            */
/* http://www.squery.com					                            */
/*									                                    */
/*					                                                    */
/* This Module allows users to query from your PHPNuke Website.         */
/* The module is required to be present for the Block to work, however  */
/* It is not necessary that it be active                                */
/* 								                                        */
/************************************************************************/
/* ADMIN SECTION - Sql Integration - Block Modification                 */
/*                                                                      */
/* Author: XenoMorpH ¤TÐI¤ (aarvuijk@hotmail.com)                       */
/* Development Assistance: CrazyCrack (support@phpnuke-clan.net)        */
/* Made for PNC phpnuke-clan.net & SQuery.com                           */
/************************************************************************/
if(!defined('MODULE_FILE')) { die("Illegal Access Detected!!!"); }

//require_once("mainfile.php");
global $prefix,$db;
$ignoreteams = array("Call of Duty","cs-source");
$ignoregametypes = array("Deathmatch","dm","DM","Dm","deathmatch","DEATHMATCH");
$module_name = basename(dirname(__FILE__));
$numservers= $db->sql_numrows($db->sql_query("SELECT * FROM ".$prefix."_squery_servers WHERE  hideserver=2"));
// check out main.lib.php for configuration and more information
define("SQUERY_FILE", true);
error_reporting(0);

// redefine the user error constants - PHP 4 only
define("FATAL", E_ERROR);
define("ERROR", E_WARNING);
define("WARNING", E_NOTICE);
define("OTHER", E_PARSE);
// error handler function
function myErrorHandler($errno, $errstr, $errfile, $errline)
{
  echo "<!--";
switch ($errno) {
  case FATAL:
   echo "<b>FATAL</b> [$errno] $errstr<br />\n";
   echo "  Fatal error in line $errline of file $errfile";
   echo ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
   echo "</body></html>";
   die();
   break;
  case ERROR:
   echo "<b>ERROR</b> [$errno] $errstr<br />\n";
   echo "  Error in line $errline of file $errfile";
   echo ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
   break;
  case WARNING:
   echo "<b>WARNING</b> [$errno] $errstr<br />\n";
   echo "  Non-Fatal error in line $errline of file $errfile";
   echo ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
   break;
 case OTHER:
   echo "<b>PARSE</b> [$errno] $errstr<br />\n";
   echo "  Parse error in line $errline of file $errfile";
   echo ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
   break;
  default:
  echo $errno;
  break;
  }
  echo "-->";
}

// set to the user defined error handler
//$old_error_handler = set_error_handler("myErrorHandler");

$blockmode=0;
// globalize our vars :0
$ip = $_GET['ip']; $port = $_GET['port'];$qgame = $_GET['game'];
$blockmode = $_GET['block'];

//$blockmode= false;

//$libpath="./SQuery/lib/";
$libpath="modules/SQuery/lib/";

// require our main library =)
include_once($libpath.'main.lib.php');

//////////////////////////////////////////////////////////
function queryServer($address, $port, $protocol)
{
   global $libpath;
  include_once($libpath."gsQuery.php");

  if(!$address && !$port && !$protocol) {
    echo "No parameters given\n";
    return FALSE;
  }

  $gameserver=gsQuery::createInstance($protocol, $address, $port);
  if(!$gameserver) {
    echo "Could not instantiate gsQuery class. Does the protocol you've specified exist?\n";
    return FALSE;
  }

  if(!$gameserver->query_server(TRUE, TRUE)) { // fetch everything
    // query was not succesful, dumping some debug info
    echo "<div>Error ".$gameserver->errstr."</div>\n";
    return FALSE;
  }

  return $gameserver;
}

function showFavorites() {
global $ignoreteams, $ignoregametypes, $blockmode;
//$numservers= mysql_numrows(mysql_query("SELECT * FROM ".$prefix."_squery_servers WHERE  hideserver=1"));
	global $favorites,$numservers,$prefix,$db;
	//$cnt = count($favorites);
	$cnt = $numservers -1;
	echo "(";
if($numservers == 0){ echo"There are no servers active in the server list"; 		echo ")";}
else{

	$var1= 0;
while ($var1 <= $cnt){
$resultyy = $db->sql_query("SELECT * FROM ".$prefix."_squery_servers WHERE hideserver=2 ORDER BY id ASC");
while ($row = $db->sql_fetchrow($resultyy))
{
$idtt= $row['id'];
$servername1tt= $row['servername'];
$staticip1tt = $row['staticip'];
$staticport1tt = $row['staticport'];
$staticgame1tt = $row['staticgame'];
//$fav=array("$servername1,$staticip1,$staticport1,$staticgame1");

//echo " $servername1tt,$staticip1tt,$staticport1tt,$staticgame1tt <br>";
echo " <a href=\"".$_SERVER['PHP_SELF']."?name=SQuery&ip=$staticip1tt&port=$staticport1tt&game=$staticgame1tt&block=0\" class=\"link\">$servername1tt</a>&nbsp;";
if ($var1 < $cnt) echo checkmark2();
   $var1++;
   }
}
		echo ")";
}// END else $server == 0
}

if (!$blockmode) {
$pagetitle = "-.:: SQuery ".$version." ::.";
include("header.php");
}

echo "<script language=\"JavaScript\" src=\"modules/SQuery/lib/overlib.js\"><!-- overLIB (c) Erik Bosrup --></script>"
	."<STYLE>";

include($libpath."default.css");

echo "</STYLE>";

if (!$blockmode) {
OpenTable();
}

echo "<div id=\"overDiv\" style=\"position:absolute; visibility:hidden; z-index:1000;\"></div>"
	."<BR>"
	."<TABLE BORDER=\"0\" CELLSPACING=\"0\" CELLPADDING=\"3\" width=\"100%\">"
	."<TR><TD align=\"center\">";

if (!isset($static_ip)&&!$blockmode) {

	echo "<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=3 CLASS=\"main_table\">"
	."<TD align=center>"
	."<form method=get>"
	."<table width=100% cellspacing=0 cellpadding=0>"
	."<tr><td><font class=\"color\">";

	if ($show_ip_entry_form) echo "Please enter an IP Address to query:";
	   else echo "Please Choose a Favorite:";

	echo "</font></td><td align=right>".showCredits(showVersion())."</td></tr>"
	."</table><br>";

 if ($show_ip_entry_form) {
 	// Start of Form

	echo "<table><tr>"
	."<td>&nbsp;&nbsp;&nbsp;<input type=hidden name=name value=\"SQuery\"></td><td><b class=\"color\">&nbsp;&nbsp;&nbsp;Host:</b>&nbsp;&nbsp;&nbsp;<input type=text name=ip value=\"$ip\" style=\"width: 100px;\"></td><td>&nbsp;&nbsp;&nbsp;<b class=\"color\">Port:</b>&nbsp;&nbsp;&nbsp;<input type=text name=port value=\"$port\" style=\"width: 45px;\"></td><td>&nbsp;&nbsp;&nbsp;<b class=\"color\">Game:</b>&nbsp;&nbsp;&nbsp;"
	."<select name=\"game\">";


foreach($gametable as $key=>$value)
{
  echo "<OPTION ";
 if ($key==$qgame)
	{
	 echo "SELECTED ";
	 $enginetype=$value;
	}
 echo "VALUE=\"$key\">".$key;
}
//<OPTION SELECTED VALUE="igi2">IGI2
//<OPTION VALUE="sof2">SOFII

echo "</select></td><td>"
."<input type=submit value=\"Query Server\"></td>"
	."</tr>"
	."</table>"
	."</form>";

	} // END of form
	else {
	foreach($gametable as $key=>$value)
	{
  	 if ($key==$qgame) $enginetype=$value;
  	 }
	}


	echo"Choose one of the following servers for their online status:<br>";

	showFavorites();
	echo "<br>"
	."</TD>"
	."</TR>"
	."</TABLE>"
	."<br>";

} else { // doing static IP
	if (!$blockmode) {

	$ip = $static_ip;
	$port = ($static_port ? $static_port : "2302");
	$qgame = $static_game;
         }
	foreach($gametable as $key=>$value)
	{
   	if ($key==$qgame)
	{
	 $enginetype=$value;
	}
 }

}
if ($ip && $port) {

	echo "<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=3 class=\"main_table\" align=center>"
	."<TR>"
	."<TD align=center>";

        $qport=calcqport($port,$qgame);
        if ($queryfromurl) {
		include_once($libpath."gsQuery.php");
	 $gameserver=gsQuery::unserializeFromURL("http://www.squery.com/sqserial/serializer.php?ip=$ip&port=$qport&protocol=$enginetype");
          if(!$gameserver) {
            echo "Could not fetch the serialized object.";
          }
	}
	else $gameserver=queryServer($ip,$qport,$enginetype);

	if ($gameserver) {

		echo "<strong class=\"big\">".gametitle(htmlentities($gameserver->gamename))."</strong><br>"
		."<TABLE cellpadding=0 cellspacing=0 width=\"550\">"
		."<tr><td valign=top><br>"
		."<table width=\"100%\" cellspacing=0 cellpadding=3 align=\"center\">"
		."<tr><td width=\"100%\" style=\"padding-left: 10px; padding-right: 10px;\" valign=top>"
		."<table cellspacing=0 cellpadding=0>"
		."<tr><td class=\"row\"><font class=\"color\">Server name:</font></td><td class=\"row\">".$gameserver->htmlize($gameserver->servertitle)."</td></tr>"
		."<tr><td class=\"row\"><font class=\"color\">Server Address:</font></td><td class=\"row\">".$gameserver->address.":".$gameserver->hostport."&nbsp;&nbsp;&nbsp;</td></tr>"
		."<tr><td class=\"row\"><font class=\"color\">Server Version:</font></td><td class=\"row\">".htmlentities($gameserver->gameversion)."</td></tr>"
		."<tr><td class=\"row\"><font class=\"color\">Players:</font></td><td class=\"row\">".$gameserver->numplayers." / ".$gameserver->maxplayers;

		if ($gameserver->numplayers == $gameserver->maxplayers){
			echo "&nbsp;&nbsp;&nbsp;(<font class=\"color\">This server is FULL</font>)";}
		elseif ($gameserver->numplayers == 0){
			echo "&nbsp;&nbsp;&nbsp;(<font class=\"color\">This server is EMPTY</font>)"
		."</td></tr>";}

if ($gameserver->rules[".admin"]<>"")
{
echo "<tr><td class=\"row\"><font class =\"color\">Admin Name:</font></td><td class=\"row\">".$gameserver->rules[".admin"]."</td></tr>";
}
if ($gameserver->rules["admin"]<>"")
{
echo "<tr><td class=\"row\"><font class =\"color\">Admin Name:</font></td><td class=\"row\">".$gameserver->rules["admin"]."</td></tr>";
}
if ($gameserver->rules["_admin"]<>"")
{
echo "<tr><td class=\"row\"><font class =\"color\">Admin Name:</font></td><td class=\"row\">".$gameserver->rules["_admin"]."</td></tr>";
}
if ($gameserver->rules["adminname"]<>"")
{
echo "<tr><td class=\"row\"><font class =\"color\">Admin Name:</font></td><td class=\"row\">".$gameserver->rules["adminname"]."</td></tr>";
}
if ($gameserver->rules["admin name"]<>"")
{
echo "<tr><td class=\"row\"><font class =\"color\">Admin Name:</font></td><td class=\"row\">".$gameserver->rules["admin name"]."</td></tr>";
}
if ($gameserver->rules["administrator"]<>"")
{
echo "<tr><td class=\"row\"><font class =\"color\">Admin Name:</font></td><td class=\"row\">".$gameserver->rules["administrator"]."</td></tr>";
}
if ($gameserver->rules[".administrator"]<>"")
{
echo "<tr><td class=\"row\"><font class =\"color\">Admin Name:</font></td><td class=\"row\">".$gameserver->rules[".administrator"]."</td></tr>";
}
if ($gameserver->rules[".email"]<>"")
{
echo "<tr><td class=\"row\"><font class =\"color\">Admin Email:</font></td><td class=\"row\">".$gameserver->rules[".email"]."</td></tr>";
}
if ($gameserver->rules["_email"]<>"")
{
echo "<tr><td class=\"row\"><font class =\"color\">Admin Email:</font></td><td class=\"row\">".$gameserver->rules["_email"]."</td></tr>";
 }
if ($gameserver->rules["sv_contact"]<>"")
{
echo "<tr><td class=\"row\"><font class =\"color\">Admin Email:</font></td><td class=\"row\">".$gameserver->rules["sv_contact"]."</td></tr>";
 }
if ($gameserver->rules["adminemail"]<>"")
{
echo "<tr><td class=\"row\"><font class =\"color\">Admin Email:</font></td><td class=\"row\">".$gameserver->rules["adminemail"]."</td></tr>";
 }
if ($gameserver->rules["admin email"]<>"")
{
echo "<tr><td class=\"row\"><font class =\"color\">Admin Email:</font></td><td class=\"row\">".$gameserver->rules["admin email"]."</td></tr>";
 }
if ($gameserver->rules["admin e-mail"]<>"")
{
echo "<tr><td class=\"row\"><font class =\"color\">Admin Email:</font></td><td class=\"row\">".$gameserver->rules["admin e-mail"]."</td></tr>";
 }
if ($gameserver->rules[".e-mail"]<>"")
{
echo "<tr><td class=\"row\"><font class =\"color\">Admin Email:</font></td><td class=\"row\">".$gameserver->rules[".e-mail"]."</td></tr>";
 }
if ($gameserver->rules[".icq"]<>"")
{
echo "<tr><td class=\"row\"><font class =\"color\">Admin ICQ:</font></td><td class=\"row\">".$gameserver->rules[".icq"]."</td></tr>";
 }
if ($gameserver->rules["icq"]<>"")
{
echo "<tr><td class=\"row\"><font class =\"color\">Admin ICQ:</font></td><td class=\"row\">".$gameserver->rules["icq"]."</td></tr>";
 }
if ($gameserver->rules[".website"]<>"")
{
echo "<tr><td class=\"row\"><font class =\"color\">Website:</font></td><td class=\"row\">".$gameserver->rules[".website"]."</td></tr>";
 }
if ($gameserver->rules["_website"]<>"")
{
echo "<tr><td class=\"row\"><font class =\"color\">Website:</font></td><td class=\"row\">".$gameserver->rules["_website"]."</td></tr>";
 }
if ($gameserver->rules[".location"]<>"")
{
echo "<tr><td class=\"row\"><font class =\"color\">Server Location:</font></td><td class=\"row\">".$gameserver->rules[".location"]."</td></tr>";
 }
if ($gameserver->rules["_location"]<>"")
{
echo "<tr><td class=\"row\"><font class =\"color\">Server Location:</font></td><td class=\"row\">".$gameserver->rules["_location"]."</td></tr>";
 }
if ($gameserver->rules["location"]<>"")
{
echo "<tr><td class=\"row\"><font class =\"color\">Server Location:</font></td><td class=\"row\">".$gameserver->rules["location"]."</td></tr>";
 }
if ($gameserver->rules["email"]<>"")
{
echo "<tr><td class=\"row\"><font class =\"color\">Admin Email:</font></td><td class=\"row\">".$gameserver->rules["email"]."</td></tr>";
 }
if ($gameserver->rules[".url"]<>"")
{
echo "<tr><td class=\"row\"><font class =\"color\">Website:</font></td><td class=\"row\">".$gameserver->rules[".url"]."</td></tr>";
 }
if ($gameserver->rules["web"]<>"")
{
echo "<tr><td class=\"row\"><font class =\"color\">Website:</font></td><td class=\"row\">".$gameserver->rules["web"]."</td></tr>";
 }
if ($gameserver->rules["webpage"]<>"")
{
echo "<tr><td class=\"row\"><font class =\"color\">Website:</font></td><td class=\"row\">".$gameserver->rules["webpage"]."</td></tr>";
 }
if ($gameserver->rules["url"]<>"")
{
echo "<tr><td class=\"row\"><font class =\"color\">Website:</font></td><td class=\"row\">".$gameserver->rules["url"]."</td></tr>";
 }
if ($gameserver->rules[".irc"]<>"")
{
echo "<tr><td class=\"row\"><font class =\"color\">IRC Channel:</font></td><td class=\"row\">".$gameserver->rules[".irc"]."</td></tr>";
 }
if ($gameserver->rules["irc"]<>"")
{
echo "<tr><td class=\"row\"><font class =\"color\">IRC Channel:</font></td><td class=\"row\">".$gameserver->rules["irc"]."</td></tr>";
 }
 if ($gameserver->cpu <>"")
 {
 echo "<tr><td class=\"row\"><font class =\"color\">CPU:</font></td><td class=\"row\">".$gameserver->cpu."</td></tr>";
 }
if ($gameserver->rules["cpu"]<>"")
{
echo "<tr><td class=\"row\"><font class =\"color\">CPU:</font></td><td class=\"row\">".$gameserver->rules["cpu"]."</td></tr>";
 }
if ($gameserver->rules[".cpu"]<>"")
{
echo "<tr><td class=\"row\"><font class =\"color\">CPU:</font></td><td class=\"row\">".$gameserver->rules[".cpu"]."</td></tr>";
 }
if ($gameserver->rules["server spec"]<>"")
{
echo "<tr><td class=\"row\"><font class =\"color\">CPU:</font></td><td class=\"row\">".$gameserver->rules["server spec"]."</td></tr>";
 }
if ($gameserver->rules["connection"]<>"")
{
echo "<tr><td class=\"row\"><font class =\"color\">Connection:</font></td><td class=\"row\">".$gameserver->rules["connection"]."</td></tr>";
 }
if ($gameserver->rules["gamestartup"]<>"")
{
echo "<tr><td class=\"row\"><font class =\"color\">Last Boot:</font></td><td class=\"row\">".$gameserver->rules["gamestartup"]."</td></tr>";
 }
if ($gameserver->rules["gameversion"]<>"")
{
echo "<tr><td class=\"row\"><font class =\"color\">Game Ver:</font></td><td class=\"row\">".$gameserver->rules["gameversion"]."</td></tr>";
}
if ($gameserver->rules["plug"]<>"")
{
echo "<tr><td class=\"row\"><font class =\"color\">Motto:</font></td><td class=\"row\">".$gameserver->rules["plug"]."</td></tr>";
}
if ($gameserver->rules["motd"]<>"")
{
echo "<tr><td class=\"row\"><font class =\"color\">Motto:</font></td><td class=\"row\">".$gameserver->rules["motd"]."</td></tr>";
}

		echo "</table>"
		."<br>"
		."<table cellspacing=0 cellpadding=0 width=\"100%\">"
		."<tr><td class=\"row\">"
		."<font class=\"color\">";

switch($gameserver->password)
{
case "1":
echo "This server requires a password to join</font> (Private Server)";
break;
case"0":
echo "This server is open to the public </font>(No password)";
break;
default:
echo "Server Password Setting is Unknown.";
break;
}

echo "</td></tr>"
		."</table>"
		."<br>";
?>
<?$gameserver->docvars($gameserver);?>
<?
/////////////////////////////////////////////////////////
// function is called, sees server type, creates a pathname to pictures based on mapname and server type.
$mappic=domappic($gameserver);
// if the picture isnt there, sets to unknown.gif.
///////////////////////////////////////////////////////////////////////////////////

		echo "</TD><td width=\"20%\" valign=\"top\" style=\"padding-left: 10px; padding-right: 10px;\">"
		  ."<div align=\"center\"><img src=\"$mappic\" alt=\"".htmlentities($gameserver->maptitle)."\" width=\"200\" height=\"160\" style=\"border: 1px solid #000000;\"><br>";

$row3 = $db->sql_fetchrow($db->sql_query("SELECT * FROM ".$prefix."_squery_options WHERE id=1"));
$xfire_check = $row3['enable_xfire_module'];

if($xfire_check == 1 )
{
$gameserver->gamename2 = "$gameserver->gamename";
$gamename3 = "$gameserver->gamename2";

echo "<center><a href=\"".gametitle1(htmlentities($gamename3))."".$gameserver->address.":".$gameserver->hostport."\"/>"
	."<img src=\"modules/SQuery/images/xfirebig.jpg\" width=\"200\" height=\"25\" border=\"0\"></a></center>";
}

echo "<br>"
	."</div>"
	."<table width=\"100%\" cellspacing=1 cellpadding=1>";

	$gameserver->mapname = str_replace("_", " ",  $gameserver->mapname);
	$gameserver->mapname=ucwords(htmlentities($gameserver->mapname));

	echo "<tr><td><font class=\"color\">Current Map:</font></td><td>$gameserver->mapname</td></tr>";

	if ($gameserver->mapsize)
	{
		echo "<tr><td><font class=\"color\">Map Size:</font></td><td>$gameserver->mapsize</td></tr>";
		//echo "<tr><td><font class=\"color\">Gamename:</font></td><td>$gameserver->gamename</td></tr>";
	}

	$gameserver->gametype=htmlentities($gameserver->gametype);

echo "<tr><td><font class=\"color\">Game Type:</font></td><td>$gameserver->gametype</td></tr>";


if ($gameserver->rules["sv_punkbuster"]<>"")
{
echo "<tr><td><font class=\"color\">PunkBuster:</font></td><td>".($gameserver->rules["sv_punkbuster"] == 1 ? "Enabled" : "Disabled")."</td></tr>";
}

		echo "</table>"
		."</td>"
		."</tr>"
		."</table>"
		."</table>"
		."<br>";

if (!$blockmode) {

		echo "<div align=center><strong class=\"big\">Player Information</strong></div><br>"
		."<TABLE cellpadding=0 cellspacing=0 width=\"520\">";

		//if(count($gameserver->playerteams) && (!in_array($gameserver->gamename, $ignoreteams)))
if(!count($gameserver->playerteams) > 1 || in_array($gameserver->gamename, $ignoreteams) || in_array($gameserver->gametype, $ignoregametypes))
		////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		 {  // No Team Info (like COD)

		echo "<tr><td align=center valign=top>"
		."<table width=\"100%\" cellspacing=0 cellpadding=3><tr>";

if ($gameserver->playerkeys["name"]) {
echo "<td class=\"bluebox\" style=\"padding-left: 4px; border: 1px solid $col_border;\"><strong>Player Name</strong></td>";
}
if ($gameserver->playerkeys["score"]) {
echo "<td align=center class=\"bluebox\" style=\"border: 1px solid $col_border; border-left: none;\"><strong>Score</strong></td>";
}
if ($gameserver->playerkeys["goal"]) {
echo "<td align=center class=\"bluebox\" style=\"border: 1px solid $col_border; border-left: none;\"><strong>Goals</strong></td>";
}
if ($gameserver->playerkeys["leader"]) {
echo "<td align=center class=\"bluebox\" style=\"border: 1px solid $col_border; border-left: none;\"><strong>Leader</strong></td>";
}
if ($gameserver->playerkeys["enemy"]) {
echo "<td align=center class=\"bluebox\" style=\"border: 1px solid $col_border; border-left: none;\"><strong>Enemy</strong></td>";
}
if ($gameserver->playerkeys["kia"]) {
echo "<td align=center class=\"bluebox\" style=\"border: 1px solid $col_border; border-left: none;\"><strong>KIA</strong></td>";
}
if ($gameserver->playerkeys["roe"]) {
echo "<td align=center class=\"bluebox\" style=\"border: 1px solid $col_border; border-left: none;\"><strong>ROE</strong></td>";
}
if ($gameserver->playerkeys["ping"]) {
echo "<td align=center class=\"bluebox\" style=\"border: 1px solid $col_border; border-left: none;\"><strong>Ping</strong></td>";
}
if ($gameserver->playerkeys["kills"]) {
echo "<td align=center class=\"bluebox\" style=\"border: 1px solid $col_border; border-left: none;\"><strong>Kills</strong></td>";
}
if ($gameserver->playerkeys["deaths"]) {
echo "<td align=center class=\"bluebox\" style=\"border: 1px solid $col_border; border-left: none;\"><strong>Deaths</strong></td>";
}
if ($gameserver->playerkeys["skill"]) {
echo "<td align=center class=\"bluebox\" style=\"border: 1px solid $col_border; border-left: none;\"><strong>Skill</strong></td>";
}
if ($gameserver->playerkeys["time"]) {
echo "<td align=center class=\"bluebox\" style=\"border: 1px solid $col_border; border-left: none;\"><strong>Time</strong></td>";
}
echo "</tr>";

	if(!count($gameserver->players)) {
    	echo "<tr><td style=\"padding-left: 4px; border: 1px solid $col_border; border-top: none;\" class=\"bluebox\">(none)</td>"
			."<td style=\"border-bottom: 1px solid $col_border; border-right: 1px solid $col_border;\" class=\"bluebox\">&nbsp;</td>"
			."<td style=\"border-bottom: 1px solid $col_border; border-right: 1px solid $col_border;\" class=\"bluebox\">&nbsp;</td></tr>";
    	}
	else {
	for ($i=0;$i<$gameserver->numplayers;$i++) {
 echo "<tr>";
if ($gameserver->playerkeys["name"]) {
echo "<td class=\"bluebox\" style=\"padding-left: 4px; border: 1px solid $col_border; border-top: none;\">".$gameserver->htmlize($gameserver->players[$i]["name"])."</td>";
}
if ($gameserver->playerkeys["score"]) {
echo "<td align=center class=\"bluebox\" style=\"border-bottom: 1px solid $col_border; border-right: 1px solid $col_border;\">".$gameserver->players[$i]["score"]."</td>";
}
if ($gameserver->playerkeys["goal"]) {
echo "<td align=center class=\"bluebox\" style=\"border-bottom: 1px solid $col_border; border-right: 1px solid $col_border;\">".$gameserver->players[$i]["goal"]."</td>";
}
if ($gameserver->playerkeys["leader"]) {
echo "<td align=center class=\"bluebox\" style=\"border-bottom: 1px solid $col_border; border-right: 1px solid $col_border;\">".$gameserver->players[$i]["leader"]."</td>";
}
if ($gameserver->playerkeys["enemy"]) {
echo "<td align=center class=\"bluebox\" style=\"border-bottom: 1px solid $col_border; border-right: 1px solid $col_border;\">".$gameserver->players[$i]["enemy"]."</td>";
}
if ($gameserver->playerkeys["kia"]) {
echo "<td align=center class=\"bluebox\" style=\"border-bottom: 1px solid $col_border; border-right: 1px solid $col_border;\">".$gameserver->players[$i]["kia"]."</td>";
}
if ($gameserver->playerkeys["roe"]) {
echo "<td align=center class=\"bluebox\" style=\"border-bottom: 1px solid $col_border; border-right: 1px solid $col_border;\">".$gameserver->players[$i]["roe"]."</td>";
}
if ($gameserver->playerkeys["ping"]) {
echo "<td align=center class=\"bluebox\" style=\"border-bottom: 1px solid $col_border; border-right: 1px solid $col_border;\">".$gameserver->players[$i]["ping"]."</td>";
}
if ($gameserver->playerkeys["kills"]) {
echo "<td align=center class=\"bluebox\" style=\"border-bottom: 1px solid $col_border; border-right: 1px solid $col_border;\">".$gameserver->players[$i]["kills"]."</td>";
}
if ($gameserver->playerkeys["deaths"]) {
echo "<td align=center class=\"bluebox\" style=\"border-bottom: 1px solid $col_border; border-right: 1px solid $col_border;\">".$gameserver->players[$i]["deaths"]."</td>";
}
if ($gameserver->playerkeys["skill"]) {
echo "<td align=center class=\"bluebox\" style=\"border-bottom: 1px solid $col_border; border-right: 1px solid $col_border;\">".$gameserver->players[$i]["skill"]."</td>";
}
if ($gameserver->playerkeys["time"]) {
echo "<td align=center class=\"bluebox\" style=\"border-bottom: 1px solid $col_border; border-right: 1px solid $col_border;\">".$gameserver->players[$i]["time"]."</td>";
}
            echo "</tr>";
			}
		 }

		echo "</table>"
		."</td></tr>"
		."</table>";

		}
		else {
		///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		// with teams (like SOF2)

		echo "<tr><td valign=top><br>"
		."<table cellspacing=0 cellpadding=0 width=\"100%\">"
		."<tr><td align=center width=\"50%\" style=\"padding-bottom: 2px;\"><font class=\"blueteam\">".$gameserver->team1."</font>"
		."<br>"
		."<table width=\"100%\" cellspacing=0 cellpadding=0>"
		."<tr>"
		."<td style=\"padding-left: 3px;\">Players on this team: <font class=blueteam>".$gameserver->teamcnt1."</font></td>";

if ($gameserver->teamscore1) {
echo "<td align=right style=\"padding-right: 3px;\">Points scored: <font class=blueteam>".$gameserver->teamscore1."</font>";
if ($gameserver->scorelimit) {
echo " / <font class=blueteam>".$gameserver->scorelimit."</font>";
}
echo "</td>";
}
		echo "</tr>"
		."</table>"
		."</td>"
		."<td align=center width=\"50%\" style=\"padding-bottom: 2px;\"><font class=\"redteam\">".$gameserver->team2."</font>"
		."<br>"
		."<table width=\"100%\" cellspacing=0 cellpadding=0>"
		."<tr>"
		."<td style=\"padding-left: 6px;\">Players on this team: <font class=redteam>".$gameserver->teamcnt2."</font></td>";

if ($gameserver->teamscore2) {
echo "<td align=right style=\"padding-right: 3px;\">Points scored: <font class=redteam>".$gameserver->teamscore2."</font>";
if ($gameserver->scorelimit) {
echo " / <font class=redteam>".$gameserver->scorelimit."</font>";
}
echo "</td>";
}
		echo "</tr>"
		."</table>"
		."</td></tr>"
		."<tr><td align=center valign=top>"
		."<table width=\"100%\" cellspacing=0 cellpadding=3><tr>";

if ($gameserver->playerkeys["name"]) {
echo "<td class=\"bluebox\" style=\"padding-left: 4px; border: 1px solid $col_border;\"><strong>Player Name</strong></td>";
}
if ($gameserver->playerkeys["ping"]) {
echo "<td align=center class=\"bluebox\" style=\"border: 1px solid $col_border; border-left: none;\"><strong>Ping</strong></td>";
}
if ($gameserver->playerkeys["score"]) {
echo "<td align=center class=\"bluebox\" style=\"border: 1px solid $col_border; border-left: none;\"><strong>Score</strong></td>";
}
if ($gameserver->playerkeys["deaths"]) {
echo "<td align=center class=\"bluebox\" style=\"border: 1px solid $col_border; border-left: none;\"><strong>Deaths</strong></td>";
}
if ($gameserver->playerkeys["kills"]) {
echo "<td align=center class=\"bluebox\" style=\"border: 1px solid $col_border; border-left: none;\"><strong>Kills</strong></td>";
}
if ($gameserver->playerkeys["time"]) {
echo "<td align=center class=\"bluebox\" style=\"border: 1px solid $col_border; border-left: none;\"><strong>Time</strong></td>";
}
echo "</tr>";

		$o = 0;

		for ($i=0;$i<$gameserver->numplayers+1;$i++) {
			if ($gameserver->playerteams[$i] == "1") {
			$o++;
            echo "<tr>";
if ($gameserver->playerkeys["name"]) {
echo "<td class=\"bluebox\" style=\"padding-left: 4px; border: 1px solid $col_border; border-top: none;\">".$gameserver->htmlize($gameserver->players[$i]["name"])."</td>";
}
if ($gameserver->playerkeys["ping"]) {
echo "<td align=center class=\"bluebox\" style=\"border-bottom: 1px solid $col_border; border-right: 1px solid $col_border;\">".$gameserver->players[$i]["ping"]."</td>";
}
if ($gameserver->playerkeys["score"]) {
echo "<td align=center class=\"bluebox\" style=\"border-bottom: 1px solid $col_border; border-right: 1px solid $col_border;\">".$gameserver->players[$i]["score"]."</td>";
}
if ($gameserver->playerkeys["deaths"]) {
echo "<td align=center class=\"bluebox\" style=\"border-bottom: 1px solid $col_border; border-right: 1px solid $col_border;\">".$gameserver->players[$i]["deaths"]."</td>";
}
if ($gameserver->playerkeys["kills"]) {
echo "<td align=center class=\"bluebox\" style=\"border-bottom: 1px solid $col_border; border-right: 1px solid $col_border;\">".$gameserver->players[$i]["kills"]."</td>";
}
if ($gameserver->playerkeys["time"]) {
echo "<td align=center class=\"bluebox\" style=\"border-bottom: 1px solid $col_border; border-right: 1px solid $col_border;\">".$gameserver->players[$i]["time"]."</td>";
}
echo "</tr>";
			}
		}

		if ($o == 0){
			echo "<tr><td style=\"padding-left: 4px; border: 1px solid $col_border; border-top: none;\" class=\"bluebox\">(none)</td>"
				."<td style=\"border-bottom: 1px solid $col_border; border-right: 1px solid $col_border;\" class=\"bluebox\">&nbsp;</td>"
				."<td style=\"border-bottom: 1px solid $col_border; border-right: 1px solid $col_border;\" class=\"bluebox\">&nbsp;</td>"
				."<td style=\"border-bottom: 1px solid $col_border; border-right: 1px solid $col_border;\" class=\"bluebox\">&nbsp;</td></tr>";
		}

		echo "</table>"
		."</td><td align=center valign=top>"
		."<table width=\"100%\" cellspacing=0 cellpadding=3><tr>";


if ($gameserver->playerkeys["name"]) {
echo "<td class=\"redbox\" style=\"padding-left: 4px; border: 1px solid $col_border;\"><strong>Player Name</strong></td>";
}
if ($gameserver->playerkeys["ping"]) {
echo "<td align=center class=\"redbox\" style=\"border: 1px solid $col_border; border-left: none;\"><strong>Ping</strong></td>";
}
if ($gameserver->playerkeys["score"]) {
echo "<td align=center class=\"redbox\" style=\"border: 1px solid $col_border; border-left: none;\"><strong>Score</strong></td>";
}
if ($gameserver->playerkeys["deaths"]) {
echo "<td align=center class=\"redbox\" style=\"border: 1px solid $col_border; border-left: none;\"><strong>Deaths</strong></td>";
}
if ($gameserver->playerkeys["kills"]) {
echo "<td align=center class=\"bluebox\" style=\"border: 1px solid $col_border; border-left: none;\"><strong>Kills</strong></td>";
}
if ($gameserver->playerkeys["time"]) {
echo "<td align=center class=\"redbox\" style=\"border: 1px solid $col_border; border-left: none;\"><strong>Time</strong></td>";
}

echo "</tr>";

		$o = 0;
		for ($i=0;$i<$gameserver->numplayers+1;$i++) {
			if ($gameserver->playerteams[$i] == "2") {
				$o++;

echo "<tr>";
if ($gameserver->playerkeys["name"]) {
echo "<td class=\"redbox\" style=\"padding-left: 4px; border: 1px solid $col_border; border-top: none;\">".$gameserver->htmlize($gameserver->players[$i]["name"])."</td>";
}
if ($gameserver->playerkeys["ping"]) {
echo"<td align=center class=\"redbox\" style=\"border-bottom: 1px solid $col_border; border-right: 1px solid $col_border;\">".$gameserver->players[$i]["ping"]."</td>";
}
if ($gameserver->playerkeys["score"]) {
echo"<td align=center class=\"redbox\" style=\"border-bottom: 1px solid $col_border; border-right: 1px solid $col_border;\">".$gameserver->players[$i]["score"]."</td>";
}
if ($gameserver->playerkeys["deaths"]) {
echo"<td align=center class=\"redbox\" style=\"border-bottom: 1px solid $col_border; border-right: 1px solid $col_border;\">".$gameserver->players[$i]["deaths"]."</td>";
}
if ($gameserver->playerkeys["kills"]) {
echo "<td align=center class=\"bluebox\" style=\"border-bottom: 1px solid $col_border; border-right: 1px solid $col_border;\">".$gameserver->players[$i]["kills"]."</td>";
}
if ($gameserver->playerkeys["time"]) {
echo"<td align=center class=\"redbox\" style=\"border-bottom: 1px solid $col_border; border-right: 1px solid $col_border;\">".$gameserver->players[$i]["time"]."</td>";
}

echo"</tr>";
			}
		}

		if ($o == 0){
			echo "<tr><td style=\"padding-left: 4px; border: 1px solid $col_border; border-top: none;\" class=\"redbox\">(none)</td>"
				."<td style=\"border-bottom: 1px solid $col_border; border-right: 1px solid $col_border;\" class=\"redbox\">&nbsp;</td>"
				."<td style=\"border-bottom: 1px solid $col_border; border-right: 1px solid $col_border;\" class=\"redbox\">&nbsp;</td>"
				."<td style=\"border-bottom: 1px solid $col_border; border-right: 1px solid $col_border;\" class=\"redbox\">&nbsp;</td></tr>";
		}

		echo "</table>"
		."</td></tr>"
		."</table>"
		."</td></tr>"
		."</table><br>"
		."<font class=\"specteam\">Spectators:</font>";
		$o = 0;
		for ($i=0;$i<$gameserver->numplayers;$i++) {
			if ($gameserver->playerteams[$i] == "3") {
				$o++;
				echo $gameserver->htmlize($gameserver->players[$i]["name"]);
				if ($o < $gameserver->spec)
					echo "<font class=\"specteam\">,</font> ";
			}
		}
		if ($o == 0)
			echo "(none)";
		}
	  }
	}
	else {
		echo "We were unable to contact the server you requested, it is most likely <font class=red>Offline</font>";
	}

	echo "</TD>"
	."</TR>"
	."</TABLE>";

}

echo "<br>"
."<div align=center>";

if (!$blockmode) {
if ($displaytips) echo showTip();
}

echo "</div>"
."</TD></TR>"
."</TABLE>";

if (!$blockmode) {
CloseTable();
include("footer.php");
restore_error_handler();
}
?>