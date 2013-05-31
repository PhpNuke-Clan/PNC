<?php
####################################################################
#  This file is Copyright (c)2006 PNC phpnuke-clan.net             #
#  info@phpnuke-clan.net                                           #
#  Please keep ALL copyright information in here....			   #
####################################################################
# 	Orignial code by: http://www.ventriloservers.biz               #
####################################################################

if(!defined('ADMIN_FILE') && !defined('MODULE_FILE')) { die("Illegal File Access Detected!!"); }

global $srvdb;

function VentriloDisplayEX3( &$stat, $name2, $cid, $bgidx, $blockoption, $moduleoption, $comment_check) {
$module_name ="Ventrilo";

	// Display channel info.

	$chan = $stat->ChannelFind( $cid );

	if ( $bgidx % 2 )
		$bg = "#666666";
	else
		$bg = "#333333";

	$isopen = false;

	for ( $i = 0; $i < $stat->m_channelcount; $i++ )
	{
		if ( $stat->m_channellist[ $i ]->m_pid == $chan->m_cid )
		{
			$isopen = true;
			break;
		}
	}

	for ( $i = 0; $i < $stat->m_clientcount; $i++ )
	{
		if ( $stat->m_clientlist[ $i ]->m_cid == $chan->m_cid )
		{
			$isopen = true;
			break;
		}
	}

	if ( $cid == 0 )
	{
		$icon = "modules/$module_name/images/venticon_server.png";
		echo "<tr>";
	        echo "<td>";
	        if ($comment_check != 1)
	        {
	                echo "<table bgcolor=\"#333333\" width=\"90%\" align=\"center\" border=\"1\"\n";
	                echo "<tr>";
	                echo "<td>";
                }

                echo "<table bgcolor=\"\" width=\"100%\" align=\"center\" border=\"0\"\n";
        }
	else
	{
		if ( $chan->m_prot )
			$icon = ($isopen) ? "modules/$module_name/images/venticon_chanpassopen.png" : "modules/$module_name/images/venticon_chanpass.png";
		else
			$icon = ($isopen) ? "modules/$module_name/images/venticon_chanopen.png" : "modules/$module_name/images/venticon_chan.png";
	}

	$fg = "#FFFFFF";

	if ( $chan->m_prot )
	{
		if ( $bgidx %2 )
			$bg = "#660000";
		else
			$bg = "#330000";
	}

        if ( $cid != 0 )
        {
	        echo "<tr>";
	        echo "<td>";
	        if ($comment_check == 1)
	        {
                       echo "<table width=\"85%\" align=\"center\" border=\"0\">\n";
                }
                else echo "<table width=\"90%\" align=\"center\" border=\"0\">\n";
        }
        echo "<tr>";
	echo "<td>";
        echo "<div style=\"overflow:hidden;text-overflow:ellipsis\">";
	echo "<img src=\"$icon\" align=\"absmiddle\"></img>";
	echo "<strong>";
	echo $name2;
	echo "</strong>";
	echo "</div>";

	//echo "<table width=\"95%\" border=\"1\" align=\"right\">\n";

	// Display Client for this channel.

	for ( $i = 0; $i < count( $stat->m_clientlist ); $i++ )
	{
		$client = $stat->m_clientlist[ $i ];

		if ( $client->m_cid != $cid )
			continue;

		echo "<tr>";
                //echo "        <td bgcolor=\"#FFFFFF\">";
		echo "<td>";
		echo "<div style=\"overflow:hidden;text-overflow:ellipsis\">";

		$icon = "modules/$module_name/images/venticon_voiceoff.png";
		echo "<img src=\"$icon\" align=\"absmiddle\"></img>";

		$flags = "";

		if ( $client->m_admin )
			$flags .= "A";

		if ( $client->m_phan )
			$flags .= "P";

		if ( strlen( $flags ) )
			echo "\"$flags\" ";

		echo $client->m_name;

                if ( $client->m_comm)
                {
                	if ( $blockoption == 1 && $moduleoption == 0 && $comment_check == 1)
                           echo " ($client->m_comm)";
                        if ( $blockoption == 0 && $moduleoption == 1 && $comment_check == 0)
                           echo " ($client->m_comm)";
                        if ( $blockoption == 1 && $moduleoption == 0 && $comment_check == 2)
                           echo " ($client->m_comm)";
                        if ( $blockoption == 0 && $moduleoption == 1 && $comment_check == 2)
                           echo " ($client->m_comm)";
                        if ( $blockoption == 1 && $moduleoption == 1)
                           echo " ($client->m_comm)";
                        if ( $blockoption == 0 && $moduleoption == 0 && $comment_check == 2)
                           echo " ($client->m_comm)";
                }
                else echo "";

                echo "</div>";
		echo "</td>";
		echo "</tr>\n";
  }

  // Display sub-channels for this channel.

  for ( $i = 0; $i < count( $stat->m_channellist ); $i++ )
  {
  		if ( $stat->m_channellist[ $i ]->m_pid == $cid )
		{
			$cn = $stat->m_channellist[ $i ]->m_name;
			if ( strlen( $stat->m_channellist[ $i ]->m_comm ) )
			{
				$cn .= " (";
				$cn .= $stat->m_channellist[ $i ]->m_comm;
				$cn .= ")";
			}

			VentriloDisplayEX3( $stat, $cn, $stat->m_channellist[ $i ]->m_cid, $bgidx + 1, $blockoption, $moduleoption, $comment_check);
		}
  }

  echo "</table>";
  echo "</td>";
  echo "</tr>\n";
}

function StrKey( $src, $key, &$res )
{
	$key .= " ";
	if ( strncasecmp( $src, $key, strlen( $key ) ) )
		return false;

	$res = substr( $src, strlen( $key ) );
	return true;
}




function StrSplit( $src, $sep, &$d1, &$d2 )
{
	$pos = strpos( $src, $sep );
	if ( $pos === false )
	{
		$d1 = $src;
		return;
	}

	$d1 = substr( $src, 0, $pos );
	$d2 = substr( $src, $pos + 1 );
}





function StrDecode( &$src )
{
	$res = "";

	for ( $i = 0; $i < strlen( $src ); )
	{
		if ( $src[ $i ] == '%' )
		{
			$res .= sprintf( "%c", intval( substr( $src, $i + 1, 2 ), 16 ) );
			$i += 3;
			continue;
		}

		$res .= $src[ $i ];
		$i += 1;
	}

	return( $res );
}




class CVentriloClient
{
	var	$m_uid;			// User ID.
	var	$m_admin;		// Admin flag.
	var     $m_phan;		// Phantom flag.
	var     $m_cid;			// Channel ID.
	var     $m_ping;		// Ping.
	var	$m_sec;			// Connect time in seconds.
	var	$m_name;		// Login name.
	var	$m_comm;		// Comment.

	function Parse( $str )
	{
		$ary = explode( ",", $str );

		for ( $i = 0; $i < count( $ary ); $i++ )
		{
			StrSplit( $ary[ $i ], "=", $field, $val );

			if ( strcasecmp( $field, "UID" ) == 0 )
			{
				$this->m_uid = $val;
				continue;
			}

			if ( strcasecmp( $field, "ADMIN" ) == 0 )
			{
				$this->m_admin = $val;
				continue;
			}

			if ( strcasecmp( $field, "CID" ) == 0 )
			{
				$this->m_cid = $val;
				continue;
			}

			if ( strcasecmp( $field, "PHAN" ) == 0 )
			{
				$this->m_phan = $val;
				continue;
			}

			if ( strcasecmp( $field, "PING" ) == 0 )
			{
				$this->m_ping = $val;
				continue;
			}

			if ( strcasecmp( $field, "SEC" ) == 0 )
			{
				$this->m_sec = $val;
				continue;
			}

			if ( strcasecmp( $field, "NAME" ) == 0 )
			{
				$this->m_name = StrDecode( $val );
				continue;
			}

			if ( strcasecmp( $field, "COMM" ) == 0 )
			{
				$this->m_comm = StrDecode( $val );
				continue;
			}
		}
	}
}

class CVentriloChannel
{
	var	$m_cid;		// Channel ID.
	var	$m_pid;		// Parent channel ID.
	var	$m_prot;	// Password protected flag.
	var	$m_name;	// Channel name.
	var	$m_comm;	// Channel comment.

	function Parse( $str )
	{
		$ary = explode( ",", $str );

		for ( $i = 0; $i < count( $ary ); $i++ )
		{
			StrSplit( $ary[ $i ], "=", $field, $val );

			if ( strcasecmp( $field, "CID" ) == 0 )
			{
				$this->m_cid = $val;
				continue;
			}

			if ( strcasecmp( $field, "PID" ) == 0 )
			{
				$this->m_pid = $val;
				continue;
			}

			if ( strcasecmp( $field, "PROT" ) == 0 )
			{
				$this->m_prot = $val;
				continue;
			}

			if ( strcasecmp( $field, "NAME" ) == 0 )
			{
				$this->m_name = StrDecode( $val );
				continue;
			}

			if ( strcasecmp( $field, "COMM" ) == 0 )
			{
				$this->m_comm = StrDecode( $val );
				continue;
			}
		}
	}
}


class CVentriloStatus
{
	// These need to be filled in before issuing the request.

	var	$m_cmdcode;			// Specific status request code. 1=General, 2=Detail.
	var	$m_cmdhost;			// Hostname or IP address to perform status of.
	var	$m_cmdport;			// Port number of server to status.
	var	$m_cmdpass;			// Remote status password. Not used any more but included for legacy reference.

	// Optional

	var	$m_connTimeout;			// Integer timeout value in seconds when trying to connect to the status server.
	var	$m_streamTimeout;		// Integer timeout value in seconds when waiting for the reply from status server.

	// These are the result variables that are filled in when the request is performed.

	var	$m_error;			// If the ERROR: keyword is found then this is the reason following it.
	var	$m_statserver;			// Name of the status server that we connected to.

	var	$m_name;			// Server name.
	var	$m_phonetic;			// Phonetic spelling of server name.
	var	$m_comment;			// Server comment.
	var	$m_maxclients;			// Maximum number of clients.
	var	$m_voicecodec_code;		// Voice codec code.
	var     $m_voicecodec_desc;		// Voice codec description.
	var	$m_voiceformat_code;	        // Voice format code.
	var	$m_voiceformat_desc;	        // Voice format description.
	var	$m_uptime;			// Server uptime in seconds.
	var	$m_platform;			// Platform description.
	var	$m_version;			// Version string.

	var	$m_channelcount;		// Number of channels as specified by the server.
	var	$m_channelfields;		// Channel field names.
	var	$m_channellist;			// Array of CVentriloChannel's.

	var	$m_clientcount;			// Number of clients as specified by the server.
	var	$m_clientfields;		// Client field names.
	var     $m_clientlist;			// Array of CVentriloClient's.

	function Parse( $str, &$fndend )
	{
		// Remove trailing newline.

		$pos = strpos( $str, "\n" );
		if ( $pos === false )
		{
		}
		else
		{
			$str = substr( $str, 0, $pos );
		}

		// Begin parsing for keywords.

		if ( StrKey( $str, "END:", $val ) )
		{
			$fndend = true;
			return 0;
		}

		if ( StrKey( $str, "ERROR:", $val ) )
		{
			$this->m_error = $val;
			return -100;
		}

		if ( StrKey( $str, "NAME:", $val ) )
		{
			$this->m_name = StrDecode( $val );
			return 0;
		}

		if ( StrKey( $str, "PHONETIC:", $val ) )
		{
			$this->m_phonetic = StrDecode( $val );
			return 0;
		}

		if ( StrKey( $str, "COMMENT:", $val ) )
		{
			$this->m_comment = StrDecode( $val );
			return 0;
		}

		if ( StrKey( $str, "AUTH:", $this->m_auth ) )
			return 0;

		if ( StrKey( $str, "MAXCLIENTS:", $this->m_maxclients ) )
			return 0;

		if ( StrKey( $str, "VOICECODEC:", $val ) )
		{
			StrSplit( $val, ",", $this->m_voicecodec_code, $desc );
			$this->m_voicecodec_desc = StrDecode( $desc );
			return 0;
		}

		if ( StrKey( $str, "VOICEFORMAT:", $val ) )
		{
			StrSplit( $val, ",", $this->m_voiceformat_code, $desc );
			$this->m_voiceformat_desc = StrDecode( $desc );
			return 0;
		}

		if ( StrKey( $str, "UPTIME:", $val ) )
		{
			$this->m_uptime = $val;
			return 0;
		}

		if ( StrKey( $str, "PLATFORM:", $val ) )
		{
			$this->m_platform = StrDecode( $val );
			return 0;
		}

		if ( StrKey( $str, "VERSION:", $val ) )
		{
			$this->m_version = StrDecode( $val );
			return 0;
		}

		if ( StrKey( $str, "CHANNELCOUNT:", $this->m_channelcount ) )
			return 0;

		if ( StrKey( $str, "CHANNELFIELDS:", $this->m_channelfields ) )
			return 0;

		if ( StrKey( $str, "CHANNEL:", $val ) )
		{
			$chan = new CVentriloChannel;
			$chan->Parse( $val );

			$this->m_channellist[ count( $this->m_channellist ) ] = $chan;
			return 0;
		}

		if ( StrKey( $str, "CLIENTCOUNT:", $this->m_clientcount ) )
			return 0;

		if ( StrKey( $str, "CLIENTFIELDS:", $this->m_clientfields ) )
			return 0;

		if ( StrKey( $str, "CLIENT:", $val ) )
		{
			$client = new CVentriloClient;
			$client->Parse( $val );

			$this->m_clientlist[ count( $this->m_clientlist ) ] = $client;
			return 0;
		}

		// Unknown key word. Could be a new keyword from a newer server.

		return 1;
	}

	function ChannelFind( $cid )
	{
		for ( $i = 0; $i < count( $this->m_channellist ); $i++ )
			if ( $this->m_channellist[ $i ]->m_cid == $cid )
				return( $this->m_channellist[ $i ] );

		return NULL;
	}

	function ChannelPathName( $idx )
	{
		$chan = $this->m_channellist[ $idx ];
		$pathname = $chan->m_name;

		for(;;)
		{
			$chan = $this->ChannelFind( $chan->m_pid );
			if ( $chan == NULL )
				break;

			$pathname = $chan->m_name . "/" . $pathname;
		}

		return( $pathname );
	}

	function Request()
	{  global $srvdb;
		if ( $this->m_connTimeout == 0 )
			$this->m_connTimeout = 10;

		if ( $this->m_streamTimeout == 0 )
			$this->m_streamTimeout = 30;

		for ( $srv = $srvdb; $srv < 3; $srv++ )
		{
			$srvname = sprintf( "status%d.ventrilo.com", $srv + 1 );
			//$srvname = sprintf( "status1.ventrilo.com", $srv + 1 );

			$pipe = fsockopen( $srvname, 5100, $errno[ $srv ], $errstr[ $srv ], $this->m_connTimeout );
			if ( !$pipe )
			{
				if ( $errno[ $srv ] == 0 )
				{
					// If connection fails but errno is 0 then error string is wrong
					// by default. Set it to a value that is most likely the cause.

					$errstr[ $srv ] = "Could not resolve the status server name.";
				}
			}
			else
			{
				$this->m_statserver = $srvname;
				break;
			}
		}

		if ( !$pipe )
		{
				$this->m_error = "PHP: Unable to connect to a Ventrilo Status server.";

				for ( $srv = 0; $srv < 3; $srv++ )
				{
					$temp = sprintf( " S%d=", $srv + 1 );
					$this->m_error .= $temp;
					$this->m_error .= $errstr[ $srv ];
				}

				return -2;
		}

		$req = sprintf( "Code=%s,Host=%s,Port=%s,Pass=%s\n", $this->m_cmdcode, $this->m_cmdhost, $this->m_cmdport, $this->m_cmdpass );

		if ( fwrite( $pipe, $req ) == FALSE )
		{
			fclose( $pipe );

			$this->m_error = "PHP: Failed sending request to Ventrilo Status server.";
			return -3;
		}

		// Process the results coming from the stream.

		$cnt = 0;
		$fndend = false;

		while( !feof( $pipe ) )
		{
			stream_set_timeout( $pipe, $this->m_streamTimeout );

			$s = fgets( $pipe, 1024 );

			$info = stream_get_meta_data( $pipe );
			if ( $info[ 'timed_out' ] )
			{
				fclose( $pipe );

				$this->m_error = "PHP: Status server stream timed out.";
				return -4;
			}

			if ( strlen( $s ) == 0 )
				continue;

			$rc = $this->Parse( $s, $fndend );
			if ( $rc < 0 )
			{
				fclose( $pipe );
				return( $rc );
			}

			if ( $fndend )
				break;

			$cnt += 1;
		}

		fclose( $pipe );

		if ( $fndend == false )
		{
			$this->m_error = "PHP: Incomplete data from Ventrilo Status server.";
			return -5;
		}

		if ( $cnt == 0 )
		{
			// This should not happen because of the fndend test. But we'll check
			// for it anyway just to be sure.

			$this->m_error = "PHP: Nothing received from Ventrilo Status server.";
			return -6;
		}

		// Everything is OK and data is valid.

		return 0;
	}
};

####################################################################
# PHP-Nuke Module: Ventrilo Status                                 #
#                                                                  #
# This is a modified version of the ventrilo status script from    #
# www.ventrilo.com/download.php                                    #
#                                                                  #
# Feel free to change stuff for your own site.  Just dont remove   #
# the link to download the module! If you are a business using this#
# or a modified verion of this module you must give me a free      #
# game server or something. Seriously.                             #
####################################################################

function VentriloInfoEX1_Stripe( &$bgidx, $name, $val )
{
	if ( $bgidx % 2 )
		$bgcolname = "#666666";
	else
		$bgcolname = "#333333";

	if ( $bgidx % 2 )
                $bgcolval = "#333333";
                //$bgcolval = "#FFFFCC";
        else
                $bgcolval = "#666666";
                //$bgcolval = "#FFFFFF";

	echo "  <tr>\n";
	//echo "    <td width=\"35%\" bgcolor=\"$bgcolname\"><font color=\"#FFFFFF\">";
	echo "    <td width=\"35%\" bgcolor=\"$bgcolname\"><font color=\"#FFFFFF\">";
	echo "<strong>";
	echo $name;
	echo "</strong>";
	echo "</font></td>\n";
	//echo "    <td width=\"65%\" bgcolor=\"$bgcolval\"><font color=\"#000000\">";
	echo "    <td width=\"65%\" bgcolor=\"$bgcolval\"><font color=\"#FFFFFF\">";
        echo "<div align=\"center\">";

        if ($name == "Password" && $val == 0){
	   $val = "No";
	}
        if ($name == "Password" && $val == 1){
	   $val = "Yes";
	}
        if ($name == "Uptime"){
           $intDivide = $val / 3600;
           $hours = intval($intDivide);
           $minutes = intval(($val / 60) % 60);
           $seconds = intval($val % 60);
           $val = "$hours:$minutes:$seconds";
        }

        echo "&nbsp$val</div></font></td></tr>\n";

	$bgidx += 1;
}




function VentriloInfoEX1( &$stat )
{
	$bgidx	= 0;

	VentriloInfoEX1_Stripe( $bgidx, "Name:", $stat->m_name );
	VentriloInfoEX1_Stripe( $bgidx, "Address:", $stat->m_cmdhost );
	VentriloInfoEX1_Stripe( $bgidx, "Port:", $stat->m_cmdport );
	VentriloInfoEX1_Stripe( $bgidx, "Password:", $stat->m_auth );
    	//VentriloInfoEX1_Stripe( $bgidx, "Phonetic", $stat->m_phonetic );
	VentriloInfoEX1_Stripe( $bgidx, "Comment:", $stat->m_comment );
        VentriloInfoEX1_Stripe( $bgidx, "Client Count:", $stat->m_clientcount );
	VentriloInfoEX1_Stripe( $bgidx, "Max Clients:", $stat->m_maxclients );
        VentriloInfoEX1_Stripe( $bgidx, "Voice Codec:", $stat->m_voicecodec_desc );
	VentriloInfoEX1_Stripe( $bgidx, "Voice Format:", $stat->m_voiceformat_desc );
	VentriloInfoEX1_Stripe( $bgidx, "Uptime:", $stat->m_uptime );
	VentriloInfoEX1_Stripe( $bgidx, "Platform:", $stat->m_platform );
	VentriloInfoEX1_Stripe( $bgidx, "Version:", $stat->m_version );

}



//*********************************************************************************************************//

function vent_copy() {
  global $module_name;
  $cpname = ereg_replace("_", " ", $module_name);
  $pcname = $module_name;
  echo "<script type=\"text/javascript\">\n";
  echo "<!--\n";
  echo "function ventpncwindow(){\n";
  echo "  window.open (\"modules/$pcname/copyright.php\",\"Copyright\",\"toolbar=no,location=no,directories=no,status=no,scrollbars=yes,resizable=no,copyhistory=no,height=260,width=400,screenX=100,left=100,screenY=100,top=100\");\n";
  echo "}\n";
  echo "//-->\n";
  echo "</SCRIPT>\n\n";
  echo "<div align=\"right\"><a href=\"javascript:ventpncwindow()\">$cpname &copy;</a></div>";
}
function vent_blcopy() {
$pcname="Ventrilo";
  echo "<script type=\"text/javascript\">\n";
  echo "<!--\n";
  echo "function ventpncwindow(){\n";
  echo "  window.open (\"modules/$pcname/copyright.php\",\"Copyright\",\"toolbar=no,location=no,directories=no,status=no,scrollbars=yes,resizable=no,copyhistory=no,height=260,width=400,screenX=100,left=100,screenY=100,top=100\");\n";
  echo "}\n";
  echo "//-->\n";
  echo "</SCRIPT>\n\n";
  echo "<div align=\"right\"><a href=\"javascript:ventpncwindow()\">$cpname &copy;</a></div>";
}

function VentriloInfoEX4( &$stat )
{
  // Display Client for this channel.
  echo "<tr>"
  ."<td align=\"center\"><strong>Name</strong>"
  ."</td>"
  ."<td align=\"center\"><strong>Admin</strong>"
  ."</td>"
  ."<td align=\"center\"><strong>Phantom</strong>"
  ."</td>"
  ."<td align=\"center\"><strong>Connection Time</strong>"
  ."</td>"
  ."<td align=\"center\"><strong>Ping</strong>"
  ."</td>"
  ."</tr></strong>";
  for ( $i = 0; $i < count( $stat->m_clientlist ); $i++ )
  {
  		$client = $stat->m_clientlist[ $i ];
                $admin_user = $stat->m_clientlist[ $i ];
                $phantom = $stat->m_clientlist[ $i ];
                $conn_time = $stat->m_clientlist[ $i ];
                $ping = $stat->m_clientlist[ $i ];

                $intDivide = $conn_time->m_sec / 3600;
                $hours = intval($intDivide);
                $minutes = intval(($conn_time->m_sec / 60) % 60);
                $seconds = intval($conn_time->m_sec % 60);

                if($admin_user->m_admin == 1)
                    $user1 = "Yes";
                else $user1 = "No";

                if($phantom->m_phan == 1)
                    $user2 = "Yes";
                else $user2 = "No";

                echo "<tr>"
                ."<td align=\"center\">$client->m_name</td>"
                ."<td align=\"center\">$user1</td>"
                ."<td align=\"center\">$user2</td>"
                ."<td align=\"center\">$hours:$minutes:$seconds</td>"
                ."<td align=\"center\">$ping->m_ping</td>"
                ."</tr>";
    }

}

// Display Login and Channel Menu.
function VentriloInfoEX5( &$stat, $weblink )
{
        echo "<tr><td>"
        ."<div align=\"center\">"
        ."<form action='".$weblink."' method=\"get\">"
		//."<form method=\"POST\" action=\"/modules/Ventrilo/Vent_Login.php\" >"
		."<select name=\"&channelname\" style=width:120px>"
        ."<option>Select...</option>";

		Channel_Dropdown($stat);

		echo "</select></div></td></tr>"
		//."<tr><td align=\"left\">$weblink</td></tr>"
        ."<tr><td align=\"left\">Channel Password:</td></tr>"
		."<tr><td align=\"center\"><input style=width:120px type=\"text\" name=\"channelpassword\" value=\"\"></td></tr>"
		//."<input type=\"hidden\" name=\"weblink\" value=\"$weblink\">"
        ."<tr><td><div align=\"center\" align=\"middle\"><input style=\"font-family : tahoma, verdana;font-size : 8pt;\" type=\"submit\" value=\" Login \"></div>"
        ."</td></tr></form>";
}

function Channel_Dropdown( &$stat, $cname1='', $cname2='', $cid=0, $pname='') {

	if ($cid != 0) {
		$cname3 = str_replace(' ', '%20', $cname2);
		if ($cname1 != '') {
			$pname = str_replace(' ', '%20', $pname);
			$cname3 = $pname.'/'.$cname3;
		}
		echo '<option value="'. $cname3 .'">'. $cname1 . $cname2 .'</option>\n';
	}
		
	for ( $i = 0; $i < count( $stat->m_channellist ); $i++ ) {
		if ( $stat->m_channellist[ $i ]->m_pid == $cid ) {
			if ($stat->m_channellist[ $i ]->m_pid == 0) {
				$cn1 = '';
				$cn2 = $stat->m_channellist[ $i ]->m_name;
				$pname = $stat->m_channellist[ $i ]->m_name;
				Channel_Dropdown( $stat, $cn1, $cn2, $stat->m_channellist[ $i ]->m_cid, $pname);
			} else {
				$cn1 = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
				$cn2 = $stat->m_channellist[ $i ]->m_name;
				Channel_Dropdown( $stat, $cn1, $cn2, $stat->m_channellist[ $i ]->m_cid, $pname);
			}
		}
	}
}
?>