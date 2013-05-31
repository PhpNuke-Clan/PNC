<?
//  SQuery version 4.5 SQuery Inc. A Nevada Corporation
// Based on code by David Cramer $ Curtis Brown released to the public domain.


//########### CONFIGURATION BEGIN ############//

// Static display for Standalone and Module
// If you set this it will not display the query box, or any of your favorites, it will only show the server you put in below
 //$static_ip = "67.18.175.110";
 //$static_port = "16567"; 
 //$static_game = "Battlefield 2"; 
    
// Static display for PHPNuke Block
// This must be set for the Block to work. Add a line for each server you want displayed in the block.
// SERVER IP, PORT, GAMETYPE
 include("config.php");
/*if(!mysql_select_db($dbname, mysql_connect($dbhost, $dbuname, $dbpass)))
{echo"Couldn't connect to database!!";                                                        
exit();
}*/


/*$block_servers = array (
  
    "70.86.85.75,16567,Battlefield 2",
	"66.162.37.160,15250,Ghost Recon AW",
    "66.162.37.166,27015,Cstrike:Source",
	"70.86.85.74,29900,Battlefield 2",
    "70.86.85.76,1716,Americas Army",
    "70.86.85.76,28960,Call of Duty 2",
	);
*/
// Be sure to set this to your web site or the block won't work!
//$websiteurl ="$nukeurl";
// $websiteurl ="http://www.squery.com";

	$row3=$db->sql_fetchrow($db->sql_query("SELECT * FROM ".$prefix."_squery_options"));

	$enable_query_form = $row3[1];
	$enable_tips = $row3[2];

	if ($enable_query_form == 1)
	{
		$enable_query_form = TRUE;
	}
	else
	{
		$enable_query_form = FALSE;
	}

	if ($enable_tips == 1)
	{
		$enable_tips = TRUE;
	}
	else
	{
		$enable_tips = FALSE;
	}

	// Display tips at bottom of query TRUE or FALSE
	//$displaytips=TRUE;
	$displaytips = $enable_tips;

	// Display IP Entry Form at Top TRUE or FALSE
	//$show_ip_entry_form=FALSE;
	$show_ip_entry_form = $enable_query_form;

	// Here you can add or change the tips
	/*$tipmsg = array (
	"If you fire burst shots with an assault rifle, you'll greatly increase accuracy and range.",
	"When you're at close range with an opponent, try to hit them with your gun instead of shooting them.",
	"Listen! The sounds the enemy makes are very revealing...",
	"You shouldn't make fun of nerds... you'll be working for one some day (Great Tip!)",
	"Visit www.PBBans.com, The Best Anti-Cheat Punkbuster Site around!"
	);*/

	$numrows = $db->sql_numrows($db->sql_query("SELECT * FROM ".$prefix."_squery_tips"));
 
	unset($tipmsg); 
 
	for($i=0; $i<$numrows; $i++)
	{
		$num=$i+1;
		$row = $db->sql_fetchrow($db->sql_query("SELECT * FROM ".$prefix."_squery_tips WHERE id=".$num.""));
		$tipmsg[] = $row[tips];
	}
/* Add your favorite servers here (shows them under the form)
Use these game types:
"Americas Army"
"BField:1942"
"BField:Vietnam"
"Battlefield 2"
"Call of Duty"
"CoD:United Offensive"
"Call of Duty 2"
"Chaser"
"Chrome"
"Counterstrike"
"Cstrike:Source"
"CnC Renegade"
"Descent 3"
"DoD:Source"
"Doom3"
"Devastation"
"FarCry"
"Global Ops"
"Gore"
"Ghost Recon"
"Halo"
"Heretic 2"
"Half-Life"
"Half-Life 2"
"HLife:CndZero"
"HLife:Cstrike"
"HLife:DMC"
"HLife:DOD"
"HLife:N.S."
"HLife:O.F."
"HLife:TFC"
"IL-2 Sturmovik"
"IGI2"
"Jedi Knight 2"
"Jedi Knight 3"
"MOH:AA"
"MOH:BT"
"MOH:PA"
"MOH:SH"
"MTA(GTA3)" 
"NASCAR SimRacer"
"NetPanzer"
"NOLF"
"NOLF 2"
"Op. Flshpnt"
"Painkiller"
"Postal 2"
"Purge Jihad"
"Quake 2"
"Quake 3"
"Quake 4"
"Quake 3:UT" 
"QuakeWorld"
"Rally Masters" 
"RavenShield" 
"RTCW" 
"RTCW:ET" 
"Rune" 
"Savage"
"Serious Sam"
"Serious Sam 2" 
"Sin" 
"SOF"
"SOF II" 
"Soldat"
"ST:Elite Force"
"ST:Elite Force 2"
"SW:Battlefront"
"SWAT 4"
"Tactical Ops" 
"Unreal" 
"Unreal 2 XMP"
"UT" 
"UT2003" 
"UT2004" 
"VietCong" 
 example:  */
// Favorites...When you enable this, it will overwrite the single server input
/*$favorites = array (
	"$servername1,$staticip1,$staticport1,$staticgame1",
	"$servername2,$staticip2,$staticport2,$staticgame2",
	"$servername3,$staticip3,$staticport3,$staticgame3",
	"$servername4,$staticip4,$staticport4,$staticgame4",
	"$servername5,$staticip5,$staticport5,$staticgame5",
	"$servername6,$staticip6,$staticport6,$staticgame6",
	"$servername7,$staticip7,$staticport7,$staticgame7",
	"$servername8,$staticip8,$staticport8,$staticgame8",
	"$servername9,$staticip9,$staticport9,$staticgame9",
	"$servername10,$staticip10,$staticport10,$staticgame10",
 );
*/

//########### CONFIGURATION END ##############//
//Unsupported at this time, leave alone unless told to change it:
$queryfromurl=FALSE;

if (eregi("config.php", $_SERVER['PHP_SELF'])) {
  print_r($block_servers);
  print_r($favorites);
  echo $favorites;
  echo $static_ip;
  echo $static_port;
  echo $static_game;
  echo $websiteurl;

}
