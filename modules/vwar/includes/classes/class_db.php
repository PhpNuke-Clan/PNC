<?php
/* #####################################################################################
 *
 * $Id: class_db.php,v 1.15 2004/03/20 18:02:23 mabu Exp $
 *
 * This notice must remain untouched at all times.
 *
 * Modifications to the script, except the official addons or hacks,
 * without the owners permission are prohibited.
 * All rights reserved to their proper authors.
 *
 * ---------------------------------------------
 * http://www.vwar.de || Copyright (C) 2001-2004
 * ---------------------------------------------
 *
 * #####################################################################################
 */

class vwardb {

	var $link_id    = 0;
	var $query_id   = 0;
	var $record     = array();

	var $errdesc    = "";
	var $errno      = 0;
	var $show_error = 1;

	var $server     = "";
	var $user       = "";
	var $password   = "";
	var $database   = "";

	function vwardb($server,$user,$password,$database)
	{
		$this->server   = $server;
		$this->user     = $user;
		$this->password = $password;
		$this->database = $database;
		$this->connect();
	}

 function gettables()
 {
	global $n,$vwarmod;

	return array(
	"vwar".$n,
	"vwar".$n."_accessgroup",
	"vwar".$n."_acpmenugroups",
	"vwar".$n."_acpmenuitems",
	"vwar".$n."_bbcode",
	"vwar".$n."_calendarevents",
	"vwar".$n."_cash",
	"vwar".$n."_cashcat",
	"vwar".$n."_challenge",
	"vwar".$n."_comments",
	"vwar".$n."_customlanguage",
	"vwar".$n."_emailgroup",
	"vwar".$n."_emailgroupmember",
	"vwar".$n."_games",
	"vwar".$n."_gametype",
	"vwar".$n."_join",
	"vwar".$n."_locations",
	"vwar".$n."_matchtype",
	"vwar".$n."_member",
	"vwar".$n."_membergames",
	"vwar".$n."_memberlocation",
	"vwar".$n."_memberprofilefield",
	"vwar".$n."_memberstatus",
	"vwar".$n."_news",
	"vwar".$n."_newscat",
	"vwar".$n."_newslink",
	"vwar".$n."_newssettings",
	"vwar".$n."_opponents",
	"vwar".$n."_participants",
	"vwar".$n."_pfield_cat",
	"vwar".$n."_profilefield",
	"vwar".$n."_quickjump",
	"vwar".$n."_replacement",
	"vwar".$n."_scores",
	"vwar".$n."_settings",
	"vwar".$n."_screen",
	"vwar".$n."_search",
	"vwar".$n."_server",
	"vwar".$n."_smilie",
	"vwar".$n."_team",
	"vwar".$n."_teammember",
	"vwar".$n."_template"
	);
 }

	function connect()
	{
		$this->link_id = mysql_connect($this->server,$this->user,$this->password);

		if (!$this->link_id)
		{
			$this->print_error("Link-ID == false, connect failed");
		}

		if ($this->database != "")
		{
			$this->select_db($this->database);
		}
	}

	function geterrdesc()
	{
		$this->error = mysql_error();
		return $this->error;
	}

	function geterrno()
	{
		$this->errno = mysql_errno();
		return $this->errno;
	}

	function select_db($database="")
	{
		if ($database != "")
		{
			$this->database = $database;
		}

		if (!@mysql_select_db($this->database, $this->link_id))
		{
			$this->print_error("cannot use database ".$this->database);
		}
	}

	function query($query_string)
	{
		global $query_count,$vwarmod;

		$query_count++;

		// only for development purposes...
		//echo "#" . $query_count . " " . $query_string . "<br />";

		$this->query_id = mysql_query($query_string,$this->link_id);
		if (!$this->query_id)
		{
			// maybe another script has changed our db-connection, so we connect again...
			$this->connect();
			$this->query_id = mysql_query($query_string,$this->link_id);
			if (!$this->query_id)
			{
				$this->print_error("Invalid SQL: ".$query_string);
			}
		}
		return $this->query_id;
	}

	function fetch_array($query_id=-1, $result_type=MYSQL_ASSOC)
	{
		if ($query_id != -1)
		{
			$this->query_id = $query_id;
		}
		$this->record = mysql_fetch_array($this->query_id, $result_type);

		return $this->record;
	}

	function free_result($query_id=-1)
	{
		if ($query_id != -1)
		{
			$this->query_id = $query_id;
		}
		return @mysql_free_result($this->query_id);
	}

	function query_first($query_string, $result_type=MYSQL_ASSOC)
	{
		$this->query($query_string);
		$returnarray = $this->fetch_array($this->query_id, $result_type);

		return $returnarray;
	}

	function num_rows($query_id=-1)
	{
		if ($query_id != -1)
		{
			$this->query_id = $query_id;
		}
		return mysql_num_rows($this->query_id);
	}

	function num_fields($query_id=-1) {
	if ($query_id != -1)
	{
		$this->query_id = $query_id;
	}
	return mysql_num_fields($this->query_id);
	}

	function field_name($query_id=-1,$num)
	{
		if ($query_id != -1)
		{
			$this->query_id = $query_id;
		}
		return mysql_field_name($this->query_id,$num);
	}

	function field_type($query_id=-1,$num)
	{
		if ($query_id != -1)
		{
			$this->query_id = $query_id;
		}
		return mysql_field_type($this->query_id,$num);
	}

	function insert_id()
	{
		return mysql_insert_id($this->link_id);
	}

 function print_error($errormsg)
 {
	 global $n,$vwarmod;

	 if($this->show_error) {
		$this->errdesc=mysql_error();
		$this->errno=mysql_errno();

		$errormsg  = "-> Database Error: " . $errormsg . "\n";
		$errormsg	.= "-> MySQL Error: " . $this->errdesc . "\n";
		$errormsg .= "-> MySQL Error Number: " . $this->errno . "\n";
		$errormsg .= "-> Date: " . date("d.m.Y @ H:i") . "\n";
		$errormsg .= "-> Script: " . getenv("REQUEST_URI") . "\n";
		$errormsg .= "-> Referer: " . getenv("HTTP_REFERER");

		echo "\n<style>P,BODY{FONT-FAMILY:verdana,tahoma,arial,sans-serif;FONT-SIZE:13px;}</style><blockquote><p>&nbsp;</p><p><b>There seems to have been a slight problem with the database.</b><br>\n";
		echo "Please try again by pressing the <a href=\"javascript:window.location=window.location;\">refresh</a> button in your browser.</p>";
		echo "<p>We apologise for any inconvenience.</p>";
		//if($isadmin==1) {
			echo "<form><textarea rows=\"12\" cols=\"40\">" . htmlspecialchars ($errormsg) . "</textarea></form>\n";
		//}
		echo "</blockquote>\n";
		exit;
	 }
 }
}
?>