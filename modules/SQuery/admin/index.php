<?php
//***************************************************************************
/* SQUERY 4.6                                                             */
/* Made for PNC phpnuke-clan.net & SQuery.com                               */
//***************************************************************************

if ( !defined('ADMIN_FILE') )
{
        die ("Access Denied");
}
global $prefix, $db, $admin_file;

$module_name = "SQuery";

$libpath="modules/SQuery/lib/";
// require main library
include_once($libpath.'main.lib.php');

$aid = substr("$aid", 0,25);
$row = $db->sql_fetchrow($db->sql_query("SELECT title, admins FROM ".$prefix."_modules WHERE title='SQuery'"));
$row2 = $db->sql_fetchrow($db->sql_query("SELECT name, radminsuper FROM ".$prefix."_authors WHERE aid='$aid'"));

$admins = explode(",", $row['admins']);
$auth_user = 0;

for ($i=0; $i < sizeof($admins); $i++)
{
    if ($row2['name'] == "$admins[$i]" AND $row['admins'] != "")
	{
		$auth_user = 1;
    }
}

if ($row2['radminsuper'] == 1 || $auth_user == 1)
{

	include("header.php");

	GraphicAdmin();

$check = $db->sql_fetchrow($db->sql_query("SELECT * FROM ".$prefix."_squery_options WHERE id=1"));
$install_check = $check[6];
if ($install_check != 1)
{
	//Create sql-table servers
	$db->sql_query("CREATE TABLE IF NOT EXISTS ".$prefix."_squery_servers
	(id bigint(20) unsigned NOT NULL auto_increment,
	PRIMARY KEY id (id),
	staticip varchar(100) NOT NULL default '',
	staticport varchar(50) NOT NULL default '',
	staticgame varchar(255) NOT NULL default '',
	servername varchar(255) NOT NULL default '',
	hideserver int(1) NOT NULL default '0',
	hideblock int(1) NOT NULL default '0',
	weight bigint(20) NOT NULL default '0'
	) TYPE=MyISAM;", $dbi);

	//Create sql-table options
	$db->sql_query("CREATE TABLE IF NOT EXISTS ".$prefix."_squery_options
	(id int(1) unsigned NOT NULL auto_increment,
	PRIMARY KEY id (id),
	enable_query_form int(1) NOT NULL default '1',
	enable_tips int(1) NOT NULL default '1',
	enable_xfire_tiny int(1) NOT NULL default '1',
	enable_xfire_module int(1) NOT NULL default '1',
	enable_players int(1) NOT NULL default '1',
	install_check int(1) NOT NULL default '0'
	) TYPE=MyISAM;", $dbi);

	//Create sql-table tips
	$db->sql_query("CREATE TABLE IF NOT EXISTS ".$prefix."_squery_tips
	(id bigint(20) unsigned NOT NULL auto_increment,
	PRIMARY KEY id (id),
	tips varchar(255) NOT NULL
	) TYPE=MyISAM;", $dbi);

//Insert server data

if($db->sql_numrows($db->sql_query("SELECT * FROM ".$prefix."_squery_servers"))==0)
{
	if(!$db->sql_query("INSERT INTO ".$prefix."_squery_servers VALUES
	(NULL, '66.162.37.166', '16567', 'Battlefield 2','Trust-Company.net PR Server','2','1','1'),
	(NULL, '72.20.12.139', '27015', 'Cstrike:Source','=SK= Source','1','1','2'),
	(NULL, '64.34.164.46', '20100', 'SOF II','TEAMFN SoF2','2','1','3'),
	(NULL, '83.142.49.162', '28950', 'CoD:United Offensive','{TLS} T*D*M Server','1','1','4'),
	(NULL, '195.72.152.16', '17567', 'Battlefield 2142','=LW= NORTHERN STRIKE ONLY','2','1','5')"))
	{
		OpenTable();
		echo "Can't run Query!!! (servers)";
		CloseTable();
	}
	else
	{
		OpenTable();
		print "SQuery servers table has been added to the database.";
		CloseTable();
	}
}

//Insert option data

if($db->sql_numrows($db->sql_query("SELECT * FROM ".$prefix."_squery_options"))==0)
{
	if(!$db->sql_query("INSERT INTO ".$prefix."_squery_options VALUES
	(NULL, '1', '1', '1', '1', '1', '0')"))
	{
		OpenTable();
		echo "Can't run Query!!! (options)";
		CloseTable();
	}
	else
	{
		OpenTable();
		echo "SQuery 4.0 options table has been added to the database.";
		CloseTable();
	}
}

//Insert tips data

if($db->sql_numrows($db->sql_query("SELECT * FROM ".$prefix."_squery_tips"))==0)
{
	if(!$db->sql_query("INSERT INTO $prefix"._squery_tips." VALUES
	(NULL, \"If you fire burst shots with an assault rifle, you'll greatly increase accuracy and range.\"),
	(NULL, \"When you're at close range with an opponent, try to hit them with your gun instead of shooting them.\"),
	(NULL, \"Listen! The sounds the enemy makes are very revealing...\"),
	(NULL, \"You shouldn't make fun of nerds... you'll be working for one some day (Great Tip!)\"),
	(NULL, \"Visit www.PBBans.com, The Best Anti-Cheat Punkbuster Site around!\")"))
	{
		OpenTable();
		echo "Can't run Query!!! (tips)";
		CloseTable();
	}
	else
	{
		OpenTable();
		echo "SQuery 4.0 tips table has been added to the database.";
		CloseTable();
	}
}

$db->sql_query("update ".$prefix."_squery_options set install_check='1' where id='1'");

}
// ################ END MAIN CODE #####################

// ################ START FUNCTIONS ###################

// ################ START ACTIVATE BLOCK ################

function activateBlock($active,$block,$nr){

global $prefix,$db,$admin_file;

if($active == "yes")
{
	if ($block == "tiny")
	{
		$vhideblock = 1;
	}
	else
	{
		$vhideblock = 3;
	}
}
else
{
	$vhideblock = 2;
}

if(!$db->sql_query("UPDATE ".$prefix."_squery_servers SET hideblock='$vhideblock' WHERE id=$nr"))
{
	OpenTable();
	echo "Can't run MySQL-Query!!!";
	CloseTable();
}
else
{
	Header("Location: $admin_file.php?op=squery");
}

}

// ################ END ACTIVATE BLOCK ##################

// ################ START ACTIVATE SERVER ################

function activateServer($active,$nr){

global $prefix,$db,$admin_file;

if($active == "yes")
{
	$vhideserver = 2;
}
else
{
	$vhideserver = 1;
}

if(!$db->sql_query("UPDATE ".$prefix."_squery_servers SET hideserver='$vhideserver' WHERE id=$nr"))
{
	OpenTable();
	echo "Can't run MySQL-Query!!!";
	CloseTable();
}
else
{
	Header("Location: $admin_file.php?op=squery");
}

}

// ################ END ACTIVATE SERVER #################

// ################ ADD SERVER #######################

function addserver($add_server,$staticip,$staticport,$staticgame,$servername,$hideserver,$hideblock){

global $prefix,$db,$admin_file,$gametable;

if ($add_server == "Add Server")
{
	$add_server = "";

	$numrows = $db->sql_numrows($db->sql_query("SELECT * FROM ".$prefix."_squery_servers"));
	$weight = $numrows + 1;
	$db->sql_freeresult($numrows);

$servername = trim($servername);

	if(!$db->sql_query("INSERT INTO ".$prefix."_squery_servers VALUES (NULL, \"$staticip\", '$staticport', \"$staticgame\", \"$servername\", '$hideserver', '$hideblock', '$weight')"))
	{
		OpenTable();
		echo "<br>Can't run MySQL-Query!!!";
		CloseTable();
	}
	else
	{
		Header("Location: $admin_file.php?op=squery");
	}
}
else
{
	OpenTable();

	echo"<center><img src=\"modules/SQuery/images/logo.png\"><br><br>"
		."<form method=\"post\" action=\"$admin_file.php?op=addserver\">"
		."<table  border=1 cellpadding=2 cellspacing=0>"
		."<tr><td align=\"left\">Game server name: </td><td><input type=\"text\" name=\"servername\" value=\"\">&nbsp;</td></tr>"
		."<tr><td align=\"left\">Game server ip: </td><td><input type=\"text\" name=\"staticip\" value=\"\">&nbsp;(Gameport, must be reachable)</td></tr>"
		."<tr><td align=\"left\">Game server port: </td><td><input type=\"text\" name=\"staticport\" value=\"\" >&nbsp;(Gameport, must be usable)</td></tr>\n"
		."<tr><td align=\"left\">Game name: </td><td><select size=\"1\" name=\"staticgame\" >"
		."<option selected>Select Game</otion>";

	foreach($gametable as $key=>$value)
	{
		echo "<option value=\"$key\">".$key."</option>";
	}
	echo "</select></td></tr>"
		."<tr><td  align=\"left\">Show in Favorites:</td><td><select name=\"hideserver\" size=\"1\">"
		."<option value=\"1\">No</option><option value=\"2\">Yes</option></select>"
		."</td></tr>\n"
		."<tr><td  align=\"left\">Block Active:</td><td><select name=\"hideblock\" size=\"1\">"
		."<option value=\"1\">Tiny Block</option><option value=\"3\">Center Block</option><option value=\"2\">None</option></select>"
		."</td></tr>\n"
		."</table><br><br>"
		."<input type=\"submit\" name=\"add_server\" value=\"Add Server\">"
		."</form></center>";

	CloseTable();

	include("footer.php");
}
}
// ################ END ADD SERVER #######################

// ################ DELETE GAME #######################

function deleteSQuery($nr,$vstaticip,$vstaticport,$vstaticgame,$vservername,$vhideserver,$deleteSQuery,$vhideblock){

global $prefix,$db,$admin_file;

$row = $db->sql_fetchrow($db->sql_query("SELECT * FROM ".$prefix."_squery_servers WHERE id=$nr"));

$nr =  $row['id'];  // gamelistnumber.
$staticip = $row['staticip'];
$staticport = $row['staticport'];
$staticgames = $row['staticgame'];
$servername = $row['servername'];
$weight = $row['weight'];

if ($deleteSQuery == Yes && $nr && $weight)
{
	$deleteSQuery="";

	while ($row = $db->sql_fetchrow($db->sql_query("select * from ".$prefix."_squery_servers where weight>$weight")))
	{
		$nid = intval($row['id']);
		$db->sql_query("update ".$prefix."_squery_servers set weight=$weight where id=$nid");
		$weight++;
	}

	$db->sql_query("DELETE FROM ".$prefix."_squery_servers WHERE id='$nr'");

	Header("Location: $admin_file.php?op=squery");
}

elseif ($deleteSQuery == delete && $nr)
{
	OpenTable();
	echo "<center><center><img src=\"modules/SQuery/images/logo.png\"><br><br>"
		."<table border=1 cellpadding=2 cellspacing=0 align=\"middle\" width=\"70%\"><tr>"
			//."<td align=\"middle\" width=\"5%\">#</td>"
			."<td align=\"middle\" width=\"15%\"><strong>Server Name</strong></td>"
			."<td align=\"middle\" width=\"15%\"><strong>Game</strong></td>"
			."<td align=\"middle\" width=\"15%\"><strong>Static IP</strong></td>"
			."<td align=\"middle\" width=\"15%\"><strong>Game Port</strong></td></tr>"
			//."<tr><td align=\"middle\">$nr</td>"
			."<td align=\"middle\">$servername</td>"
			."<td align=\"middle\">$staticgames</td>"
			."<td align=\"middle\">$staticip</td>"
			."<td align=\"middle\">$staticport</td>"
		."</table>"
		."<br>"
		."<table border=0><tr><td colspan=2>"
			."Are you sure you want to delete the Server shown above?"
			."</td></tr>"
			."<tr><td align=right>"
					."<form method=\"post\" action=\"$admin_file.php?op=deletesquery\">"
					."<input type=\"hidden\" name=\"nr\" value=\"$nr\">"
					."<input type=\"submit\" name=\"deleteSQuery\" value=\"Yes\">"
					."</form></td>"
					."<td align=left>"
					."<form method=\"post\" action=\"$admin_file.php?op=squery\">"
					."<input type=\"submit\" name=\"deleteSQuery\" value=\"No\">"
					."</form></td>"
			."</tr>"
		."</table></center>";
}

else
{
	echo"No Server specified!!";
}

CloseTable();

include("footer.php");
}

// ################ END DELETE GAME ###################

// ################ EDIT GAME #######################

function editsquery($nr,$vstaticip,$vstaticport,$vstaticgame,$vservername,$vhideserver,$editSQuery,$seteditSQuery,$vhideblock,$weight){

global $prefix,$db,$admin_file,$gametable;

OpenTable();

if($seteditSQuery == "Edit" && $nr)
{

$vservername = trim($vservername);

	//$sql = "DROP TABLE IF EXISTS ".$prefix."_squery_servers ";

	if(!$db->sql_query("UPDATE ".$prefix."_squery_servers SET id='$nr', staticip='$vstaticip', staticport='$vstaticport', staticgame='$vstaticgame', servername='$vservername', hideserver='$vhideserver', hideblock='$vhideblock', weight='$weight'  WHERE id=$nr"))
	{
		echo "Can't run MySQL-Query!!!";
	}
	else
	{
		Header("Location: $admin_file.php?op=squery");
	}
}

elseif($editSQuery == "Edit" && $nr)
{
	$row = $db->sql_fetchrow($db->sql_query("SELECT * FROM ".$prefix."_squery_servers WHERE id=$nr"));
	$nr =  $row['id'];  // gamelistnumber.
	$staticip = $row['staticip'];
	$staticport = $row['staticport'];
	$staticgame = $row['staticgame'];
	$servername = $row['servername'];
	$hideserver = $row['hideserver'];
	$hideblock = $row['hideblock'];
	$weight = $row['weight'];

	echo"<center><img src=\"modules/SQuery/images/logo.png\"><br><br>"
		//."Game Server no. $nr"
		."<form method=\"post\" action=\"$admin_file.php?op=editsquery\">"
		."<table  border=1 cellpadding=2 cellspacing=0>"
		."<tr><td  align=\"left\">Game server name: </td><td><input type=\"text\" name=\"vservername\" value=\"$servername\">&nbsp;</td></tr>"
		."<tr><td  align=\"left\">Game server ip: </td><td><input type=\"text\" name=\"vstaticip\" value=\"$staticip\">&nbsp;(Gameport, must be reachable)</td></tr>"
		."<tr><td  align=\"left\">Game server port: </td><td><input type=\"text\" name=\"vstaticport\" value=\"$staticport\" >&nbsp;(Gameport, must be usable)</td></tr>\n"
		."<tr><td  align=\"left\">Game name: </td><td><select size=\"1\" name=\"vstaticgame\" >";

	foreach($gametable as $key=>$value)
	{
		echo "<option ";
		if ("$key"=="$staticgame")
		{
			echo "SELECTED ";
		}
		echo "value=\"$key\">".$key."</option>";
	}
	echo "</select></td></tr>"
		."<tr><td  align=\"left\">Show in Favorites:</td><td><select name=\"vhideserver\" size=\"1\">";
		if ($hideserver=='2')
		{
			echo"<option value=\"1\">No</option><option selected value=\"2\">Yes</option></select>";
		}
		else
		{
			echo"<option selected value=\"1\">No</option><option value=\"2\">Yes</option></select>";
		}
		echo"</td></tr>\n"
		."<tr><td  align=\"left\">Block Active:</td><td><select name=\"vhideblock\" size=\"1\">";
		if ($hideblock=='1')
		{
			echo"<option selected value=\"1\">Tiny Block</option><option value=\"3\">Center Block</option><option value=\"2\">None</option></select>";
		}
		elseif ($hideblock=='3')
		{
			echo"<option value=\"1\">Tiny Block</option><option selected value=\"3\">Center Block</option><option value=\"2\">None</option></select>";
		}
		else
		{
			echo"<option value=\"1\">Tiny Block</option><option value=\"3\">Center Block</option><option selected value=\"2\">None</option></select>";
		}
		echo"</td></tr>\n"
		."<input type=\"hidden\" name=\"nr\" value=\"$nr\">"
		."<input type=\"hidden\" name=\"weight\" value=\"$weight\">"
		."</table><br><br>"
		."<input type=\"submit\" name=\"seteditSQuery\" value=\"Edit\">"
		."</form></center>";

}

else
{
	echo"No server specified!!";
}

CloseTable();

include("footer.php");

}
// ################ END EDIT GAME ######################

//################ SQUERY ############################
function squery($setSQuery,$vstaticport,$vstaticip,$vstaticgame,$vservername){

global $prefix,$db,$admin_file,$module_name;

OpenTable();

echo"<center><img src=\"modules/SQuery/images/logo.png\"><br><br>";
echo"<br><center><table border=0><tr><td>"
	.SQuery_ports()
	."<table border=1 cellpadding=2 cellspacing=0>"
    //."<tr><td align=\"middle\" width=\"5%\">#</td>"
	."<td align=\"middle\" width=\"5%\"><strong>Server Name</strong></td>"
	."<td align=\"middle\" width=\"15%\"><strong>Game</strong></td>"
	."<td align=\"middle\" width=\"15%\"><strong>Static IP</strong></td>"
	."<td align=\"middle\" width=\"10%\"><strong>Game Port</strong></td>"
	."<td align=\"middle\" width=\"5%\"><strong>Favorite</strong></td>"
	."<td align=\"middle\" width=\"5%\"><strong>Side Show</strong></td>"
	."<td align=\"middle\" width=\"5%\"><strong>Center Show</strong></td>"
	."<td colspan=2 align=\"middle\" width=\"10%\"><strong>Weight</strong></td>"
	."<td align=\"middle\" width=\"20%\"><strong>Action</strong></td></tr>";

$result = $db->sql_query("SELECT * FROM ".$prefix."_squery_servers ORDER BY weight ASC");

   while($row2=$db->sql_fetchrow($result))
   {
		$sid = $row2[0];
		$sip = $row2[1];
		$sport = $row2[2];
		$sgame = $row2[3];
		$sname = $row2[4];
		$show_fav = $row2[5];
		$show_block = $row2[6];
		$sweight = $row2[7];

		if($sip == ''){$sip = '-';}
		if($sport == ''){$sport = '-';}
		if($sgame == ''){$sgame = '-';}
		if($sname == ''){$sname = '-';}

        echo "<tr>"
			 //."<td align=\"center\">$sid</td>"
			 ."<td align=\"center\">$sname</td>"
			 ."<td align=\"center\">$sgame</td>"
			 ."<td align=\"center\">$sip</td>"
			 ."<td align=\"center\">$sport</td>"
			 ."<td align=\"center\">";



		if($show_fav==2)
		{
			$show = "<a href=\"$admin_file.php?op=activateServer&amp;nr=".$sid."&amp;active=no\"><img border=\"0\" title=\""._ACTIVE." ("._DEACTIVATE.")\" alt=\"deactivate\" src=\"images/active.gif\"></img></a>";
		}
		else
		{
			$show = "<a href=\"$admin_file.php?op=activateServer&amp;nr=".$sid."&amp;active=yes\"><img border=\"0\" title=\""._INACTIVE." ("._ACTIVATE.")\" alt=\"activate\" src=\"images/inactive.gif\"></img></a>";
		}

		echo "$show</td>"
			 ."<td align=\"center\">";

		if($show_block==1)
		{
			$show = "<a href=\"$admin_file.php?op=activateBlock&amp;nr=".$sid."&amp;active=no\"><img border=\"0\" title=\""._ACTIVE." ("._DEACTIVATE.")\" alt=\"deactivate\" src=\"images/active.gif\"></img></a>";
		}
		else
		{
			$show = "<a href=\"$admin_file.php?op=activateBlock&amp;nr=".$sid."&amp;active=yes&amp;block=tiny\"><img border=\"0\" title=\""._INACTIVE." ("._ACTIVATE.")\" alt=\"activate\" src=\"images/inactive.gif\"></img></a>";
		}

		echo "$show</td>"
			 ."<td align=\"center\">";

		if($show_block==3)
		{
			$show = "<a href=\"$admin_file.php?op=activateBlock&amp;nr=".$sid."&amp;active=no\"><img border=\"0\" title=\""._ACTIVE." ("._DEACTIVATE.")\" alt=\"deactivate\" src=\"images/active.gif\"></img></a>";
		}
		else
		{
			$show = "<a href=\"$admin_file.php?op=activateBlock&amp;nr=".$sid."&amp;active=yes&amp;block=center\"><img border=\"0\" title=\""._INACTIVE." ("._ACTIVATE.")\" alt=\"activate\" src=\"images/inactive.gif\"></img></a>";
		}

		echo "$show</td>";

		echo "<td width=\"8%\" align=\"center\" valign=\"middle\">$sweight</td>"
			."<td align=\"center\" valign=\"middle\">";

	    $weight1 = $sweight - 1;
	    $weight3 = $sweight + 1;
	    $row_res = $db->sql_fetchrow($db->sql_query("select id from ".$prefix."_squery_servers where weight='$weight1'"));
	    $id1 = intval($row_res['id']);
	    $con1 = "$id1";
	    $row_res2 = $db->sql_fetchrow($db->sql_query("select id from ".$prefix."_squery_servers where weight='$weight3'"));
	    $id2 = intval($row_res2['id']);
	    $con2 = "$id2";

		if ($con1)
		{
			echo"<a href=\"".$admin_file.".php?op=ServerOrder&amp;weight=$sweight&amp;idori=$sid&amp;weightrep=$weight1&amp;idrep=$con1\"><img src=\"images/up.gif\" alt=\""._BLOCKUP."\" title=\""._BLOCKUP."\" border=\"0\" hspace=\"3\"></a>";
	    }
	    if ($con2)
		{
			echo "<a href=\"".$admin_file.".php?op=ServerOrder&amp;weight=$sweight&amp;idori=$sid&amp;weightrep=$weight3&amp;idrep=$con2\"><img src=\"images/down.gif\" alt=\""._BLOCKDOWN."\" title=\""._BLOCKDOWN."\" border=\"0\" hspace=\"3\"></a>";
	    }

		echo "</td>";


		echo "<td align=\"center\" valign=\"middle\">"
			."<a href=\"$nukeurl/modules.php?name=".$module_name."&ip=".$sip."&port=".$sport."&game=".$sgame."&block=0\" target=\"_blank\"><img border=\"0\" title=\""._SHOW."\" alt=\""._SHOW."\" src=\"images/info.gif\"></img></a>"
			."&nbsp;&nbsp;&nbsp;<a href=\"$admin_file.php?op=editsquery&amp;nr=".$sid."&amp;editSQuery=Edit\"><img border=\"0\" title=\""._EDIT."\" alt=\""._EDIT."\" src=\"images/edit.gif\"></img></a>"
			."&nbsp;&nbsp;&nbsp;<a href=\"$admin_file.php?op=deletesquery&amp;nr=".$sid."&amp;deleteSQuery=delete\"><img border=\"0\" title=\""._DELETE."\" alt=\""._DELETE."\" src=\"images/delete.gif\"></img></a>"
			."</td></tr>";
   }

   echo"</table></td></tr>"
		//."<tr><td align=\"left\">"
		//."* Deleting ALL servers will load default servers.</td></tr>"
		."</table><br><form method=\"post\" action=\"$admin_file.php?op=addserver\">"
		."<input type=\"submit\" name=\"addserver\" value=\"Add Server\">"
		."</form>"
		."</center>";

CloseTable();
OpenTable();

$row2=$db->sql_fetchrow($db->sql_query("SELECT * FROM ".$prefix."_squery_options"));

$enable_query_form = $row2[1];
$enable_tips = $row2[2];
$enable_xfire_tiny = $row2[3];
$enable_xfire_module = $row2[4];
$enable_players = $row2[5];

//echo"<center><img src=\"modules/SQuery/images/logo.png\"><br><br>";
echo"<form method=\"post\" action=\"$admin_file.php?op=squeryoptions\">"
."<center><table border =0><tr><td>";

if($enable_query_form == 1)
{
	$ck1 = "checked";
	$ck2 = "";
}
else
{
	$ck1 = "";
	$ck2 = "checked";
}

echo"<br><table border=1 cellpadding=2 cellspacing=0 width=\"100%\"><tr><td><strong>Enable show ip entry form: </strong></td><td>"
        ."<label><input type=\"radio\" name=\"enableformv\" value=\"1\" ".$ck1.">yes</label>"
        ."<label><input type=\"radio\" name=\"enableformv\" value=\"0\" ".$ck2.">no</label>"
        ."</td></tr>";

if($enable_tips == 1 )
{
	$ck1 = "checked";
	$ck2 = "";
}
else
{
	$ck1 = "";
	$ck2 = "checked";
}

echo "<tr><td><strong>Enable Tips: </strong></td><td>"
        ."<label><input type=\"radio\" name=\"enabletipsv\" value=\"1\" ".$ck1.">yes</label>"
        ."<label><input type=\"radio\" name=\"enabletipsv\" value=\"0\" ".$ck2.">no</label>"
        ."</td></tr>";

if($enable_xfire_tiny == 1 )
{
	$ck1 = "checked";
	$ck2 = "";
}
else
{
	$ck1 = "";
	$ck2 = "checked";
}

echo "<tr><td><strong>Enable Xfire Block: </strong></td><td>"
        ."<label><input type=\"radio\" name=\"enablexfiretinyv\" value=\"1\" ".$ck1.">yes</label>"
        ."<label><input type=\"radio\" name=\"enablexfiretinyv\" value=\"0\" ".$ck2.">no</label>"
        ."</td></tr>";

if($enable_xfire_module == 1 )
{
	$ck1 = "checked";
	$ck2 = "";
}
else
{
	$ck1 = "";
	$ck2 = "checked";
}

echo "<tr><td><strong>Enable Xfire Module: </strong></td><td>"
        ."<label><input type=\"radio\" name=\"enablexfiremodulev\" value=\"1\" ".$ck1.">yes</label>"
        ."<label><input type=\"radio\" name=\"enablexfiremodulev\" value=\"0\" ".$ck2.">no</label>"
        ."</td></tr>";

if($enable_players == 1 )
{
	$ck1 = "checked";
	$ck2 = "";
}
else
{
	$ck1 = "";
	$ck2 = "checked";
}

echo "<tr><td><strong>Enable Players Block: </strong></td><td>"
    ."<label><input type=\"radio\" name=\"enableplayersv\" value=\"1\" ".$ck1.">yes</label>"
    ."<label><input type=\"radio\" name=\"enableplayersv\" value=\"0\" ".$ck2.">no</label>"
    ."</td></tr></table>"
	."</table><br>"
	."<input type=\"submit\" name=\"options\" value=\"Save Changes\">"
	."</form></center>";

//CloseTable();
//OpenTable();

/*
$tipmsg = array (
'If you fire burst shots with an assault rifle, you will greatly increase accuracy and range.',
'When you are at close range with an opponent, try to hit them with your gun instead of shooting them.',
'Listen! The sounds the enemy makes are very revealing...',
'You should not make fun of nerds... you will be working for one some day (Great Tip!).',
'Visit www.PBBans.com, The Best Anti-Cheat Punkbuster Site around!'
);
*/

$numrows = $db->sql_numrows($db->sql_query("SELECT * FROM ".$prefix."_squery_tips"));

echo"<br><center><table border=0><tr><td>"
."<form method=\"post\" action=\"$admin_file.php?op=squerytips\">"
."<table border=1 cellpadding=2 cellspacing=0><tr><td align=\"center\" colspan=2><strong>TIPS</strong></td><td align=\"center\">Delete</td></tr>";

for($i=0; $i<$numrows; $i++)
{
	$num=$i+1;
	$tipmsg = $db->sql_fetchrow($db->sql_query("SELECT * FROM ".$prefix."_squery_tips WHERE id=".$num.""));
	echo "<tr><td align=\"right\">"
	."<strong>Tip $num: </strong></td><td><input style=\"width : 400px;\" type=\"text\" name=tip$num value=\"$tipmsg[tips]\">"
	."</td><td align=\"center\">"
	."<input type=\"checkbox\" name=\"deltip$num\" value=\"yes\">"
	."</td></tr>";
};

$num=$num+1;
echo "<tr><td><strong>New Tip: </strong></td><td colspan=2><input style=\"width : 400px;\" type=\"text\" name=tip$num value=\"\"></td></td></tr>"
	."<input type=\"hidden\" name=\"numtips\" value=\"$numrows\">"
	."</table></td></tr>"
	//."<tr><td align=\"left\">* To load default tips just delete ALL tips.</td></tr>"
	."</table><br><input type=\"submit\" name=\"squerytips\" value=\"Save Changes\"></center>"
	."</form><BR><BR>";

CloseTable();

SQuery_copy();
include("footer.php");
}
// ################ END SQUERY ##########################

// ################ EDIT OPTIONS #######################

function squeryoptions($squeryoptions,$enableformv,$enabletipsv,$enablexfiretinyv,$enablexfiremodulev,$enableplayersv){

global $prefix,$db,$admin_file;

$db->sql_query("UPDATE ".$prefix."_squery_options SET enable_query_form='$enableformv', enable_tips='$enabletipsv', enable_xfire_tiny='$enablexfiretinyv',enable_xfire_module='$enablexfiremodulev',enable_players='$enableplayersv' WHERE id='1' ");

Header("Location: $admin_file.php?op=squery");
}
// ################ END EDIT OPTIONS ####################

// ################ SERVER ORDER #########################

function ServerOrder ($weight,$idori,$weightrep,$idrep) {
    global $prefix, $db, $admin_file;

	$idrep = intval($idrep);
    $idori = intval($idori);

	$db->sql_query("update ".$prefix."_squery_servers set weight='$weight' where id='$idrep'");
    $db->sql_query("update ".$prefix."_squery_servers set weight='$weightrep' where id='$idori'");

	CloseTable();

	Header("Location: ".$admin_file.".php?op=squery");
}

// ################ END SERVER ORDER ######################

// ################ EDIT TIPS ############################

function squerytips($squerytips,$numtips){

global $prefix,$db,$admin_file;

for($i=1; $i<=$numtips; $i++)
{
	global ${'deltip' . $i};
}

$numtips = $numtips + 1;
for($i=1; $i<=$numtips; $i++)
{
	global ${'tip' . $i};
}

$db->sql_query("TRUNCATE ".$prefix."_squery_tips");

$numtips = $numtips - 1;
$count = 0;
for($i=1; $i<=$numtips; $i++)
{
	$count = $count + 1;

	if (${'deltip' . $i} != "yes")
	{
		$db->sql_query("INSERT INTO ".$prefix."_squery_tips VALUES (NULL, \"${'tip' . $i}\")");
	}

	if (${'deltip' . $i} == "yes")
	{
		$count = $count - 1;
	}
	unset(${'deltip' . $i});
}

$numtips = $numtips + 1;
if (${'tip' . $numtips})
{
	$db->sql_query("INSERT INTO ".$prefix."_squery_tips VALUES (NULL, \"${'tip' . $numtips}\")");
}

Header("Location: $admin_file.php?op=squery");

}

// ################ END EDIT TIPS #########################

//################ PORTS LIST #######################
function SQuery_ports()
{
  global $module_name;
  $pcname = $module_name;
  echo "<font color = red>IMPORTANT!!!</font> Please ensure that your webhosting provider has the proper ports opened to query the game servers. For a list of ports "
  	  ."<SCRIPT language=\"JavaScript1.2\">\n"
  	  ."function openwindow()\n{\n	window.open(\"modules/$pcname/admin/portlist.php\",\"Test\",\"scrollbars=yes,resizable=yes,width=480,height=350\");\n}\n"
  	  ."</SCRIPT>\n<A href=\"javascript: openwindow()\">click here</A>";
}
//################ END PORTS LIST ###################

//################ COPYRIGHT GAME #######################
function SQuery_copy()
{
  global $module_name;
  $cpname = ereg_replace("_", " ", $module_name);
  $pcname = $module_name;
  echo "<script type=\"text/javascript\">\n"
  ."<!--\n"
  ."function ventpncwindow(){\n"
  ."  window.open (\"modules/$pcname/admin/copyright.php\",\"Copyright\",\"toolbar=no,location=no,directories=no,status=no,scrollbars=yes,resizable=no,copyhistory=no,height=200,width=420,screenX=100,left=100,screenY=100,top=100\");\n"
  ."}\n"
  ."//-->\n"
  ."</SCRIPT>\n\n"
  ."<div align=\"right\"><a href=\"javascript:ventpncwindow()\">$cpname &copy;</a></div>";
}
//################ END COPYRIGHT GAME ###################

	switch ($op)
	{
		case "activateBlock":
		activateBlock($active,$block,$nr);
		break;

		case "activateServer":
		activateServer($active,$nr);
		break;

		case "addserver":
		addserver($add_server,$staticip,$staticport,$staticgame,$servername,$hideserver,$hideblock);
		break;

		case "deletesquery":
		deletesquery($nr,$vstaticip,$vstaticport,$vstaticgame,$vservername,$vhideserver,$deleteSQuery,$vhideblock);
		break;

		case "editsquery":
		editsquery($nr,$vstaticip,$vstaticport,$vstaticgame,$vservername,$vhideserver,$editSQuery,$seteditSQuery,$vhideblock,$weight);
		break;

		case "ServerOrder":
		ServerOrder($weight,$idori,$weightrep,$idrep);
		break;

		case "squery":
		squery($setSQuery,$vstaticport,$vstaticip,$vstaticgame,$vservername);
		break;

		case "squeryoptions":
		squeryoptions($squeryoptions,$enableformv,$enabletipsv,$enablexfiretinyv,$enablexfiremodulev,$enableplayersv);
		break;

		case "squerytips":
		squerytips($squerytips,$numtips);
		break;
	}
}

else
{
	include("header.php");
	GraphicAdmin();
	OpenTable();
	echo "<center><b>"._ERROR."</b><br><br>You do not have administration permission for module \"$module_name\"</center>";
	CloseTable();
	include("footer.php");
}
?>