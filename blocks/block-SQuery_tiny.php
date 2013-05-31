<?
/************************************************************************/
/*  Squery 4.5 Join Block PHPNuke Block                                 */
/* =================================================                    */
/*                                                                      */
/* Copyright (c) 2006 Squery Inc. A Nevada Corporation                  */
/*   (webmaster@squery.com)                                             */
/*   http://www.squery.com	http://www.Trust-Compant.net				*/
/*									                                    */
/*					                                                    */
/* This Block requires that the  module code be in place. */
/************************************************************************/

if ( !defined('BLOCK_FILE') ) {
    Header("Location: ../index.php");
    die();
}

global $db, $nukeurl, $prefix;
//error_reporting(0);
//error_reporting(E_ALL);
$libpath="modules/SQuery/lib/";
// require our main library =)
//require_once($libpath.'config.php');
require_once($libpath.'main.lib.php');
$libpath="modules/SQuery/lib/";

if ( !class_exists("sQuery")) {
$content="";
} 

//////////////////////////////////////////////////////////

function TinyqueryServer($address, $qport, $protocol)
{
	global $libpath,$content;
  //include("modules/SQuery/lib/gsQuery.php");
  include_once($libpath."gsQuery.php");
  
  if(!$address && !$qport && !$protocol) {
    $content.="No parameters given\n";
    return FALSE;
  }

  $gameserver=gsQuery::createInstance($protocol, $address, $qport);
  if(!$gameserver) {
    $content.="Could not instantiate gsQuery class. Does the protocol you've specified exist?\n";
    return FALSE;
  }

  if(!$gameserver->query_server(TRUE, TRUE)) { // fetch everything
    // query was not succesful, dumping some debug info
    $content.="<div>Error ".$gameserver->errstr."</div>\n";
    return FALSE;
  }

  return $gameserver;
}//end function TinyqueryServer
$content="";

$content="<link rel=\"stylesheet\" type=\"text/css\" href=\"/themes/sddm.css\">";

$content.='<script language="JavaScript" src="';
$content.=$libpath;
$content.='overlib.js"><!-- overLIB (c) Erik Bosrup --></script>';

$resultyy = $db->sql_query("SELECT * FROM ".$prefix."_squery_servers WHERE hideblock=1 ORDER BY weight ASC");
while ($row = $db->sql_fetchrow($resultyy))
{
//$idtt= $row['id']; 
$ip = $row['staticip'];
$qport = $row['staticport'];
$qgame = $row['staticgame'];

include(INCLUDE_PATH."modules/SQuery/lib/gametable.php");

	foreach($gametable as $key=>$value)
	{
   	if ($key==$qgame)
	{
	 $enginetype=$value;
	}
  }
//$content.='<TR><TD align=center>';
	
        $qport=calcqport($qport,$qgame);
        /*if ($queryfromurl) {
		//include_once("modules/SQuery/lib/gsQuery.php");
		include_once($libpath."gsQuery.php");
	 $gameserver=gsQuery::unserializeFromURL("http://www.squery.com/sqserial/serializer.php?ip=$ip&port=$qport&protocol=$enginetype");
          if(!$gameserver) {
            $content.="Could not fetch the serialized object.";
          }
	}
	else */$gameserver=TinyqueryServer($ip,$qport,$enginetype);

	if ($gameserver) {

$content.='<center><strong class="nblock">';
$content.="<a href=\"modules.php?name=SQuery&ip=$ip&port=$gameserver->hostport&game=$qgame&block=0\" class=\"nblock\" target=\"_self\">";
$content.=gametitle(htmlentities($gameserver->gamename));
$content.='<font class="color"></font><br>'.$gameserver->htmlize($gameserver->servertitle).'';
$content.='</a>';
$content.='</strong><br>';
$content.='<TABLE BORDER=0 cellpadding=0 cellspacing=0 width="122">';
$content.='<tr><td valign=top><br>'; 
		$gameserver->docvars($gameserver);
		/////////////////////////////////////////////////////////
		// function is called, sees server type, creates a pathname to pictures based on mapname and server type.
		$mappic=domappic1($gameserver);
		// if the picture isn't there, sets to unknown.gif.
		///////////////////////////////////////////////////////////////////////////////////
		
		$content.="<div align=\"center\"><img src=\"$mappic\" width=\"120\" height=\"98\" style=\"border: 1px solid #FFFFFF\"></div>";
		$content.='<table BORDER=0 width="100%" cellspacing=0 cellpadding=0>'; 
		$content.='<tr><td width="100%" style="padding-left: 0px; padding-right: 0px;" valign=top>';
		$content.='<table BORDER=0 cellspacing=0 cellpadding=0>';
		 
//$content.=

//$content.='<tr>';

$row3 = $db->sql_fetchrow($db->sql_query("SELECT * FROM ".$prefix."_squery_options WHERE id=1")); 
$xfire_check = $row3['enable_xfire_tiny'];
$players_check = $row3['enable_players'];


//$content.='<img src="http://trust-company.net/xfire.jpg" width="120" height="50"</a></center><br>';
//$content.="<center>".$gameserver->htmlize($gameserver->players[$h]["name"])."<br></center>";
// Java Player START
if($players_check == 1)
{
$content.= "<script language=\"JavaScript\" type=\"text/javascript\" src=\"/includes/menu.js\"></script>";
//$content.= "<!--------Start Menu---------->";
$content.= "<tr><div align=\"center\"><div class=\"mainDiv\" state=\"0\">";
$content.= "<div class=\"topItem\" classOut=\"topItem\" classOver=\"topItemOver\" onMouseOver=\"Init(this);\" >&nbsp;Players Online ".$gameserver->numplayers.' / '.$gameserver->maxplayers." </div>";
$content.= "<div class=\"dropMenu\" >";
$content.= "	<div class=\"subMenu\" state=\"0\">";
for ($h=0;$h<$gameserver->numplayers+1;$h++) {
$content.= "<span class=\"subItem\" classOut=\"subItem\" classOver=\"subItemOver\"><div align=\"center\"><br>".$gameserver->htmlize($gameserver->players[$h]["name"])."</div></span>";
}
// Java Player END
// XFIRE START 
if($xfire_check == 1)
{
$gameserver->gamename2 = "$gameserver->gamename";
$gamename3 = "$gameserver->gamename2";

$content.="<td><tr><div align=\"center\"><a href=\"".gametitle1(htmlentities($gamename3))."".$gameserver->address.":".$gameserver->hostport."\"><br><img src=\"modules/SQuery/images/xfire.jpg\" width=\"120\" height=\"30\" border=\"0\"></a></div></tr>";
}
else
{
$content.="<td>";
}

// XFIRE END
$content.= "	</div>";
$content.= "</div>";
}
$content.= "</div></tr></td><br>";

$content.='<td class="row"><strong>IP:</strong></td><td class="row">';
$content.=$gameserver->address;

$content.='</td></tr><tr><td class="row"><strong>Port:</strong></td><td class="row">';
$content.=$gameserver->hostport;

$content.='</td></tr>
		<tr><td class="row"><font class="color">Users:</font></td><td class="row">';
$content.=$gameserver->numplayers.' / '.$gameserver->maxplayers;
$content.='</td></tr>';
$gameserver->mapname = str_replace("_", " ",  $gameserver->mapname);
$gameserver->mapname=ucwords(htmlentities($gameserver->mapname));

$content.='<tr><td class="row"><font class="color">Map:</font></td><td class="row">';
$content.=$gameserver->mapname;

$content.='</td></tr>';
$gameserver->gamename=strtoupper(htmlentities($gameserver->gamename2));

$content.='<tr><td class="row" width="35"><font class="color">Game:</font></td><td class="row">';
$content.=$gameserver->gametype;

$content.='</td></tr>';
$content.='</table>';

		if ($gameserver->numplayers == $gameserver->maxplayers)
			$content.="<center><font class=\"color\">This server is FULL</font></center>";
		elseif ($gameserver->numplayers == 0)
			$content.="<center><font class=\"color\">This server is EMPTY</font></center>";
$content.='</table></TABLE>';
   }
  $content.='<hr>';
} // end main loop
 //$content.='<center>';
 //$content.=showCredits(showVersion());
 $content.="<a href=\"http://www.squery.com\" target=\"_blank\">".showVersion()."</a>";
 $content.='</center>';
?>