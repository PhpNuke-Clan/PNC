<?php
/* #####################################################################################
 *
 * $Id: functions_textparser.php,v 1.27 2004/09/09 13:02:52 rob Exp $
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

/*
 * ------------------------------------------------------------------------------------
 * includes/functions_textparser.php
 * ------------------------------------------------------------------------------------
 * Text Parser
 * Parses all necessary codes to their equivalent (bbcode, smilies, email-protection, censor, ...)
*/


################################## MAIN FUNCTIONS ######################################

#### function 'parse' ####
// checks what to do (smilies, bbcode, censor) and calls the right functions
// if you want to use the above features without any work - just use this function!
function parse ( $text, $ismember, $dosmilies, $docensor, $dobbcode, $dourlsearch, $external, $noimage)
{

 // global variables
 global $smiliecode, $bbcode, $censor, $censorformembers,$vwarmod;	// restrictions
 global $vwar_bbcode_delimeter,$vwarmod;					// string delimeter
 global $vwar_bbcode_maximages,$vwarmod;					// max images per post
 global $vwar_bbcode_imgcounter,$vwarmod;				// current image counter

	/* #### CONFIGUARATION #### */
	// delimeter to seperate any string
	$vwar_bbcode_delimeter = "||VWAR_BBCODE_DELIMETER||";
	// max images in one text (to be defined in the settings)
	$vwar_bbcode_maximages = 20;
	/* ######################## */

	// set image-counter to 0 again
	$vwar_bbcode_imgcounter = 0;
	
	// set maximages = 0 if images aren't allowed...
	if ( $noimage == 1 )
	{
		$vwar_bbcode_maximages = 0;
	}
	
	// check smilies
	if ( $smiliecode  AND $dosmilies  )
	{
		// global variables
		global $vwar_bbcode_smilieconverted,$vwarmod;

		$vwar_bbcode_smilieconverted = true;
		$text = parse_smilies ( $text, $external );
	}

	// check bbcode
	if ( $dourlsearch )
	{
		// first check for any links...
		$text = handle_bbcode_linksearch ( $text );
	}
	if ( $bbcode AND $dobbcode AND strpos($text, "[") !== false AND strpos($text, "]") > 0 )
	{
		$text = parse_bbcode ( $text, $dourlsearch );
	}

	// check censor
	if ( $docensor AND $censor AND ( $censorformembers OR ( !$ismember OR empty($ismember) )))
	{
		$text = parse_censor ( $text );
	}

 // return
 return $text;

}

## -------------------------------------------------------------------------------------------------------------- ##

#### function 'parse_smilies' ####
// will parse smilie code to the right equivalent
function parse_smilies ( $text, $externail )
{

 // global variables
 global $parse_smiliesearch, $parse_smiliereplace,$vwarmod;	// smilie arrays

	// do we have to fill the smilie arrays?
	if ( !isset($parse_smiliesearch) )
	{
	 global $vwardb, $n,$vwarmod;	// db connection

		$result = $vwardb->query("
			SELECT filename, code
			FROM vwar".$n."_smilie
			WHERE deleted = '0'
				AND smilie = '1'
		");

		while ( $row = $vwardb->fetch_array($result) )
		{
			$parse_smiliesearch[] = $row["code"];

			if ( !$external )
			{

			 global $vwar_root,$vwarmod;

				$parse_smiliereplace[] = makeimgtag($vwar_root . "images/smilies/" . $row['filename']);

			} else {

			 global $urltovwar,$vwarmod;

				$parse_smiliereplace[]  = makeimgtag(checkPath(checkUrlFormat($urltovwar)) . "images/smilies/" . $row['filename']);

			}
		}
	}

	// replace smilie code with image equivalent
	if ( count($parse_smiliesearch) > 0 )
	{
		$text = str_replace ( $parse_smiliesearch, $parse_smiliereplace, $text);
	}

 // return
 return $text;
}

## -------------------------------------------------------------------------------------------------------------- ##

#### function 'parse_censor' ####
// will censor some words...
function parse_censor ( $text )
{

 // static variables
 static $parse_censorsearch, $parse_censorreplace;	// censor arrays

	// have the censor arrays already been created?
	if ( !isset($parse_censorsearch) )
	{
		global $censorwords, $censorsign,$vwarmod;	// our censor words and censor sign, set by the user

		$censorwords = dbSelect ($censorwords, 0, 0);
		$censorarray = explode ("\r\n", $censorwords);

		for ( $i=0; $i<count($censorarray); $i++ )
		{
			$current = trim ( $censorarray[$i] );

			if ( !$current )
			{
				continue;
			}

			if ( preg_match ("#\{([^=])+=([^=])+\}#siU", $current) )
			{
				$tmp                   = explode ( "=", $current );
				$tmp[0]                = substr ( $tmp[0], 1 );
				$tmp[1]                = substr ( $tmp[1], 0, -1 );
				$parse_censorsearch[]  = "#(^|\s|\r|\n|<br([^>])*>)+" . $tmp[0] . "(\s|<br([^>])*>||\r|$|\n)+#siU";
				$parse_censorreplace[] = "\\1" . $tmp[1] . "\\2";
			}
			else if ( preg_match ("#\{([^=])+\}#si", $current) )
			{
				$tmp                   = substr ( $current, 1, -1 );
				$parse_censorsearch[]  = "#(^|\s|\r|\n|<br([^>])*>)+" . $tmp . "(\s|<br([^>])*>||\r|$|\n)+#siU";
				$parse_censorreplace[] = "\\1" . str_repeat ($censorsign, strlen ($tmp)) . "\\2";
			}
			else if ( preg_match ("#([^=])=([^=])#si", $current) )
			{
				$tmp                   = explode ( "=", $current );
				$parse_censorsearch[]  = "#" . $tmp[0] . "#siU";
				$parse_censorreplace[] = $tmp[1];
			}
			else
			{
				$parse_censorsearch[]  = "#" . $current . "#siU";
				$parse_censorreplace[] = str_repeat ($censorsign, strlen ($current));
			}
		}

	}

	// replace $parse_censorsearch[] with $parse_censorreplace[]
	if ( count($parse_censorsearch) > 0 )
	{
		$text = preg_replace($parse_censorsearch, $parse_censorreplace, $text);
	}

	// return
	return $text;

}

## -------------------------------------------------------------------------------------------------------------- ##

#### function 'parse_bbcode' ####
// will parse any bbcode to the right equivalent
function parse_bbcode ( $text, $dourlsearch )
{

 // static variables
 static $parse_bbcodesearch, $parse_bbcodereplace;	// bbcode arrrays

	// check for the bbcode arrays
	if ( !isset($parse_bbcodesearch) )
	{
	 global $vwardb, $n,$vwarmod;	// db connection

		// bbcodes
		$result = $vwardb->query("
			SELECT code, replacement, usefunction, simplecode, params
			FROM vwar".$n."_bbcode
			WHERE deleted != '1'
		");

		while ( $row = $vwardb->fetch_array($result) )
		{
			// anything what's from the database has passed dbSelect(), so we
			// do this for the bbcodes (like that we find masked codes, too!)
			dbSelect( $row["code"] );
			$row["code"] = preg_quote ($row["code"], "#");

			// create search pattern
			$code        = handle_bbcode_subpatterns ( $row["params"], $row["simplecode"] );
			$contentpart = $code["contentpart"];
			$subpatterns = $code["subpatterns"];

			// create replace pattern
			if ( $row["usefunction"] != "" ) {
				$replacefunction = $row["usefunction"] . "( '$contentpart', '" . $row["replacement"] . "', '$subpatterns', '$0' )";
			} else {
				$replacefunction = "handle_bbcode_checkcensor( '$contentpart', '" . $row["replacement"] . "', '$0' )";
			}

			$parse_bbcodesearch[$row["code"].$row["params"]]   = sprintf ( $code["regex"], $row["code"], $row["code"] );
			$parse_bbcodereplace[$row["code"].$row["params"]]  = $replacefunction;

			unset ($parts);
		}
	}
	
	// replace bbcodes
	if ( count($parse_bbcodesearch) > 0 )
	{
		// let's replace them...
		foreach ( $parse_bbcodesearch AS $key => $pattern )
		{
			// check if this bbcode is in our text
			while ( preg_match( $pattern, $text ) == true )
			{
				$text = preg_replace ($pattern, $parse_bbcodereplace["$key"], $text);
			}
		}
	}

 // return
 return $text;

}

################################# HANDLER FUNCTIONS #####################################

#### handler 'handle_strip_smilies' ####
// will strip all already converted smilie
function handle_strip_smilies ( $text )
{

 // global variables
 global $vwar_bbcode_smilieconverted,$vwarmod;	// check if smilies were converted

	if ( $vwar_bbcode_smilieconverted !== true )
	{
		return $text;
	}

	// global variables
	static $parse_stripsmiliesearch, $parse_stripsmiliereplace;	// strip smilie arrays

	if ( !isset($parse_stripsmiliesearch) )
	{

	 global $parse_smiliesearch, $parse_smiliereplace,$vwarmod;	// smilie arrays

		$parse_stripsmiliesearch  = array_reverse ( $parse_smiliereplace );
		$parse_stripsmiliereplace = array_reverse ( $parse_smiliesearch );

	}

	$text = str_replace ($parse_stripsmiliesearch, $parse_stripsmiliereplace, $text);

 // return
 return $text;

}

## -------------------------------------------------------------------------------------------------------------- ##

#### handler 'handle_bbcode_checkcensor' ####
// to ensure that censored words like 'cen[b][/b]sorword' aren't fetched by bbcode
function handle_bbcode_checkcensor ( $textpart, $replacement, $fetched )
{

	if ( trim($textpart) != "" )
	{
		// global variables
		global $parse_bbcodefetchedsearch, $parse_bbcodefetchedreplace,$vwarmod;	// fetched bbcodes arrays
		
		// deslash code
		$replacement = handle_bbcode_prepare ( $replacement, 0, 0, 0 );
		
		// save this fetched bbcode
		$parse_bbcodefetchedsearch[]  = $replacement;
		$parse_bbcodefetchedreplace[] = $fetched;

		// return
		return $replacement;
	}
}

## -------------------------------------------------------------------------------------------------------------- ##

#### handler 'handle_bbcode_linksearch' ####
// searches for non-bbcode mails and urls
function handle_bbcode_linksearch ( $text )
{
 // static variables
 static $parse_linksearch, $parse_linkreplace;	// link arrays

	if ( !isset($parse_linksearch) )
	{
		//$parse_linksearch[]  = "#([^]_a-z0-9-=\"'\/])((https?|ftp|gopher|news|telnet)://|www\.)([^ \r\n\(\)\*\^\&$!`\"'\|\[\]\{\};<>]*)+(\.[a-zA-Z]{2,4})(\s|<br([^>])*>||\r|$|\n)+#esi";
		//$parse_linkreplace[] = "handle_bbcode_checkcensor( 'a', '[url]\\0[/url]', '\\0' )";
		$parse_linksearch[]  = "#(^|\s|\r|\n|<br([^>])*>)+([_a-z0-9-]+(\.[_a-z0-9-]+)*@[^\s]+(\.[a-z0-9-]+)*(\.[a-z]{2,4}))(\s|<br([^>])*>||\r|$|\n)+#esi";
		$parse_linkreplace[] = "handle_bbcode_checkcensor( 'a', '\\1[email]\\2[/email]\\3', '\\0' )";
		//$parse_linksearch[]  = "#(^|\s|\r|\n|<br([^>])*>)+([_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,4}))(\s|<br([^>])*>||\r|$|\n)+#esi";
		//$parse_linkreplace[] = "handle_bbcode_checkcensor( 'a', '[email]\\0[/email]', '\\0' )";
	}

	$text = preg_replace ( $parse_linksearch, $parse_linkreplace, $text );

 // return
 return $text;

}

## -------------------------------------------------------------------------------------------------------------- ##

#### handler 'handle_bbcode_spaces' ####
// handles spaces and tabs in a code snippet
function handle_bbcode_spaces ( $code )
{

	$findarray = array (
		"#  #",
		"#  #",
		"#\t#",
		"#^ {1}#m",
	);
	$replacearray = array (
		"&nbsp; ",
		" &nbsp;",
		"&nbsp; &nbsp;",
		"&nbsp;",
	);

	$code = preg_replace ($findarray, $replacearray, $code);

 // return
 return $code;

}

## -------------------------------------------------------------------------------------------------------------- ##

#### handler 'handle_bbcode_prepare' ####
// simply prepares the text for any highlighting
function handle_bbcode_prepare ( $code, $striphtml=0, $stripsmilies=1, $stripcodes=1, $htmlback=0, $nl2br=1 )
{

	// deslash code
	$code = str_replace('\"', '"', $code);

	// strip smilies
	if ( $stripsmilies == 1 )
	{
		$code = handle_strip_smilies ( $code );
	}

	// remove the bbcodes
	if ( $stripcodes == 1 )
	{
		$code = handle_bbcode_stripcodes ( $code );
	}
	
	// remove html
	if ( $striphtml == 1 )
	{
	  // global variables
	  global $htmlcode,$vwarmod;
	
		if ( $htmlcode == 1 )
		{
			$code = htmlspecialchars ( $code );
		}
	}
	
	// get the html back
	if ( $htmlback == 1 )
	{
		if ( $nl2br == 1 )
		{
			// handle new lines
			// some php functions do nl2br() without asking ;)
			$code = preg_replace ("#(<|&lt;)br([^>])*(>|&gt;)#siU", "", $code);
		}

		// get back html
		$code = rehtmlspecialchars ( $code );
	}

 // return
 return $code;

}

## -------------------------------------------------------------------------------------------------------------- ##

#### handler 'handle_bbcode_html' ####
// highlights html code
function handle_bbcode_html ( $code, $replacement, $subpatterns, $fetched )
{

	// check censor
	if ( trim ( $code ) == "" )
	{
		return "";
	}

	// static variables
	static $parse_htmlsearch, $parse_htmlreplace;	// html arrays

	// prepare for highlighting
	$code = handle_bbcode_prepare ( $code, 1 );
	
	if ( !isset($parse_htmlsearch) )
	{
		$parse_htmlsearch[]  = "#&lt;([^&<>]+)&gt;#";
		$parse_htmlreplace[] = "&lt;<span style='color:blue'>\\1</span>&gt;";
		$parse_htmlsearch[]  = "#&lt;([^&<>]+)=#";
		$parse_htmlreplace[] = "&lt;<span style='color:blue'>\\1</span>=";
		$parse_htmlsearch[]  = "#&lt;/([^&]+)&gt;#";
		$parse_htmlreplace[] = "&lt;/<span style='color:blue'>\\1</span>&gt;";
		$parse_htmlsearch[]  = "!=(&quot;|&#39;)(.+?)?(&quot;|&#39;)(\s|&gt;)!";
		$parse_htmlreplace[] = "=\\1<span style='color:orange'>\\2</span>\\3\\4";
		$parse_htmlsearch[]  = "!&#60;&#33;--(.+?)--&#62;!";
		$parse_htmlreplace[] = "&lt;&#33;<span style='color:red'>--\\1--</span>&gt;";
	}

	// highlight
	$code = preg_replace ($parse_htmlsearch, $parse_htmlreplace, $code);

	// spaces
	$code = handle_bbcode_spaces ( $code );
	
	// put line numbers in front of each line
	$code = handle_bbcode_linenumbers ( $code );

	// replace in template
	$code = str_replace ('{VWAR_BBCODE_FUNCTION_#1}', $code, $replacement);
	
	// strip remaining (not yet fetched) codes
	$code = handle_bbcode_stripcodes ( $code, 1 );
	
	// save this fetched bbcode
	handle_bbcode_savecodes ( $code, $fetched );

 // return
 return $code;

}

## -------------------------------------------------------------------------------------------------------------- ##

#### handler 'handle_bbcode_code' ####
// makes some basic formations to code tag
function handle_bbcode_code ( $code, $replacement, $subpatterns, $fetched )
{
	// check censor
	if ( trim ( $code ) == "" )
	{
		return "";
	}
	
	// prepare code
	$code = handle_bbcode_prepare ( $code, 1 );
	
	// we only save the spaces
	$code = handle_bbcode_spaces ( $code );
	
	// put line numbers in front of each line
	$code = handle_bbcode_linenumbers ( $code );
	
	// replace in template
	$code = str_replace ('{VWAR_BBCODE_FUNCTION_#1}', $code, $replacement);
	
	// strip remaining (not yet fetched) codes
	$code = handle_bbcode_stripcodes ( $code, 1 );

	// save this fetched bbcode
	handle_bbcode_savecodes ( $code, $fetched );

 // return
 return $code;

}

## -------------------------------------------------------------------------------------------------------------- ##

#### handler 'handle_bbcode_sql' ####
// highlights sql code
function handle_bbcode_sql ( $code, $replacement, $subpatterns, $fetched )
{

	// check censor
	if ( trim ( $code ) == "" )
	{
		return "";
	}
	
	// static variables
	static $parse_sqlsearch, $parse_sqlreplace;	// sql arrays

	// prepare for highlighting
	$code = handle_bbcode_prepare ( $code, 1 );

	if ( !isset($parse_sqlsearch) )
	{
		$parse_sqlsearch[]  = "#(=|\+|\-|&gt;|&lt;|~|==|\!=|LIKE|NOT LIKE|REGEXP)#i";
		$parse_sqlreplace[] = "<span style='color:orange'>\\1</span>";
		$parse_sqlsearch[]  = "#(MAX|AVG|SUM|COUNT|MIN)\(#i";
		$parse_sqlreplace[] = "<span style='color:blue'>\\1</span>(";
		$parse_sqlsearch[]  = "=(&quot;|&#39;|&#039;)(.+?)(&quot;|&#39;|&#039;)=i";
		$parse_sqlreplace[] = "<span style='color:red'>\\1\\2\\3</span>";
		$parse_sqlsearch[]  = "#\s{1,}(AND|OR)\s{1,}#i";
		$parse_sqlreplace[] = " <span style='color:blue'>\\1</span> ";
		$parse_sqlsearch[]  = "#(LEFT|JOIN|WHERE|MODIFY|CHANGE|AS|DISTINCT|IN|ASC|DESC|ORDER BY|ON)\s{1,}#i";
		$parse_sqlreplace[] = "<span style='color:green'>\\1</span> ";
		$parse_sqlsearch[]  = "#LIMIT\s*(\d+)\s*,\s*(\d+)#i";
		$parse_sqlreplace[] = "<span style='color:green'>LIMIT</span> <span style='color:orange'>\\1, \\2</span>";
		$parse_sqlsearch[]  = "#(FROM|INTO)\s{1,}(\S+?)\s{1,}#i";
		$parse_sqlreplace[] = "<span style='color:green'>\\1</span> <span style='color:orange'>\\2</span> ";
		$parse_sqlsearch[]  = "#(SELECT|INSERT|UPDATE|DELETE|ALTER TABLE|DROP)#i";
		$parse_sqlreplace[] = "<span style='color:blue;font-weight:bold'>\\1</span>";
	}

	// highlight
	$code = preg_replace ($parse_sqlsearch, $parse_sqlreplace, $code);

	// spaces
	$code = handle_bbcode_spaces ( $code );
	
	// put line numbers in front of each line
	$code = handle_bbcode_linenumbers ( $code );

	// replace in template
	$code = str_replace ('{VWAR_BBCODE_FUNCTION_#1}', $code, $replacement);
	
	// strip remaining (not yet fetched) codes
	$code = handle_bbcode_stripcodes ( $code, 1 );

	// save this fetched bbcode
	handle_bbcode_savecodes ( $code, $fetched );

 // return
 return $code;

}

## -------------------------------------------------------------------------------------------------------------- ##

#### handler 'handle_bbcode_php' ####
// highlights php code
// sorry, convoluted php boxes aren't possible due to the operation of the php function 'highlight_string'
function handle_bbcode_php ( $code, $replacement, $subpatterns, $fetched, $donumbers = 1 )
{
	// check censor
	if ( trim ( $code ) == "" )
	{
		return "";
	}
	
	// global variables
	global $parse_bbcodefetchedsearch, $parse_bbcodefetchedreplace,$vwarmod;	// fetched bbcodes arrays

	// check php version
	$php = phpversion ();
	if ( $php < 4 )
	{
		// prepare code
		$code = handle_bbcode_prepare ( $code, 1 );

		// we only save the spaces
		$code = handle_bbcode_spaces ( $code );

		// save in template
		$code = str_replace ('{VWAR_BBCODE_FUNCTION_#1}', $code, $replacement);
		
		// strip remaining (not yet fetched) codes
		$code = handle_bbcode_stripcodes ( $code, 1 );
		
		// save this fetched bbcode
		handle_bbcode_savecodes ( $code, $fetched );

		return $code;
	}
	
	// prepare for highlighting
	$code = handle_bbcode_prepare ( $code, 1, 1, 1, 1 );
	
	// check for an opening tag, if not, we add them temporarily
	if ( !preg_match("#^\s*<\?#si", $code) )
	{
		$code      = "<?php START_VWAR_PHP_SNIPPET $code END_VWAR_PHP_SNIPPET ?>";
		$addedtags = true;
	}
	else
	{
		$addedtags = false;
	}
	
	// let's highlight
	$oldlevel = error_reporting (0);
	if ( $php >= "4.2.0" )
	{
		$buffer = highlight_string ( $code, true );
	}
	else
	{
		ob_start ();
		highlight_string ( $code );
		$buffer = ob_get_contents ();
		ob_end_clean ();
	}

	// put line numbers in front of each line
	$code = handle_bbcode_linenumbers ( $buffer );

	// if we had to add tags we remove them now
	if ( $addedtags )
	{
		$code = preg_replace (array("#(<|&lt;)\?php( |&nbsp;)START_VWAR_PHP_SNIPPET( |&nbsp;)+#siU",
				"#END_VWAR_PHP_SNIPPET( |&nbsp;)\?(>|&gt;)#siU"),
				"",
				$code);
	}

	// replace in template
	$code = str_replace ('{VWAR_BBCODE_FUNCTION_#1}', $code, $replacement);
	
	// strip remaining (not yet fetched) codes
	$code = handle_bbcode_stripcodes ( $code, 1 );
	
	// save this fetched bbcode
	handle_bbcode_savecodes ( $code, $fetched );

 // return
 return $code;

}

## -------------------------------------------------------------------------------------------------------------- ##

#### handler 'handle_bbcode_linenumbers' ####
// puts line numbers in front of each line
function handle_bbcode_linenumbers ( $code )
{
	$code     = preg_replace ( "#<(/|)+code>#siU", "", $code );
	$new_code = explode ( "<br />", $code );
	$code     = "\r\n\t\t\t\t<code>\r\n";
	$blength  = count ($new_code);
	for ( $i=0; $i<$blength; $i++ )
	{
		$check  = strlen($blength) - strlen($i+1);
		$repeat = str_repeat ( "&nbsp;", $check );
		$code  .= "\t\t\t\t<codeboxfont>$repeat". ($i + 1) . ": </codeboxfont>" . $new_code[$i] . "\n\t\t\t\t<br />\r\n";
	}
	$code .= "\t\t\t\t</code>\r\n";

 // return
 return $code;	
}

## -------------------------------------------------------------------------------------------------------------- ##

#### handler 'handle_bbcode_savecodes' ####
// saves fetched bbcodes to an array
function handle_bbcode_savecodes ( $code, $fetched )
{

 // global variables
 global $parse_bbcodefetchedsearch, $parse_bbcodefetchedreplace,$vwarmod;	// fetched bbcodes arrays
	
	// save this fetched bbcode
	$parse_bbcodefetchedsearch[]  = $code;
	$parse_bbcodefetchedreplace[] = $fetched;
}

## -------------------------------------------------------------------------------------------------------------- ##

#### handler 'handle_bbcode_stripcodes' ####
// strips all bbcodes out of a text
function handle_bbcode_stripcodes ( $text, $mode=0 )
{

	if ( $mode == 1 )
	{
		$text = str_replace ( "[", "&#91;", $text );
		$text = str_replace ( "]", "&#93;", $text );
	}
	else
	{
	 // global variables
	 global $parse_bbcodefetchedsearch, $parse_bbcodefetchedreplace,$vwarmod;	// fetched bbcodes arrays
			
			$text = str_replace ( $parse_bbcodefetchedsearch, $parse_bbcodefetchedreplace, $text );
	}

 // return
 return $text;
}

## -------------------------------------------------------------------------------------------------------------- ##

#### handler 'handle_bbcode_img' ####
// ensures that not too much are in just one post
function handle_bbcode_img ( $code, $replacement, $subpatterns )
{

 // global variables
 global $vwar_bbcode_maximages,$vwarmod;	// max images per post
 global $vwar_bbcode_imgcount,$vwarmod;	// current image counter

	// check censor
	if ( trim ( $code ) == "" )
	{
		return "";
	}

	// update image counter
	$vwar_bbcode_imgcount++;

	// check current num of images
	if ( $vwar_bbcode_imgcount <= $vwar_bbcode_maximages )
	{
		$code = str_replace ('{VWAR_BBCODE_FUNCTION_#1}', $code, $replacement);
	}
	else
	{
		$code = "";
	}

 // return
 return $code;

}

## -------------------------------------------------------------------------------------------------------------- ##

#### handler 'handle_bbcode_list' ####
// converts a bbcode list to a html list
function handle_bbcode_list ( $text, $replacement, $subpatterns )
{
	// check censor
	if ( trim ( $text ) == "" )
	{
		return "";
	}

	$subpatterns = handle_bbcode_getpatterns ( $subpatterns );

	$list = handle_bbcode_prepare ( $subpatterns[0], 0, 0, 0 );

	$list = handle_bbcode_listitem ( $list );

	// replace in template
	$code = str_replace ('{VWAR_BBCODE_FUNCTION_#1}', $list, $replacement);

 // return
 return $code;

}

## -------------------------------------------------------------------------------------------------------------- ##

#### handler 'handle_bbcode_listitem' ####
// handles the items of a list
function handle_bbcode_listitem ( $text )
{
	// prepare text
	$text = str_replace('\"', '"', $text);

	// get right part of the list
	$firstlist = strpos($text, ']', vstripos($text, '[/list')) + 1;
	$templist  = substr($text, 0, $firstlist);
	$startlist = strlen($templist) - vstripos(strrev($templist), strrev('[list')) - strlen('[list');
	$finallist = substr($text, $startlist, ($firstlist - $startlist));

	// create list
	if ( preg_match('#\s*\[list(=(&quot;|"|\'|)([^\]]*)\\2)?\](.*)\[/list([^\]]*)\]\s*#si', $finallist, $parts) )
	{
		// whole list
		$wholelist = $parts[0];

		// list points
		$points = preg_split('#\s*\[\*\]\s*#s', strchr($parts[4], "[*]"), -1, PREG_SPLIT_NO_EMPTY);
		
		// no list points ...
		if ( empty($points) )
		{
			return preg_replace('#\s*' . preg_quote($wholelist, '#') . '\s*#s', nl2br("\n\n"), $text);
		}

		// get the list type
		switch ( $parts[3] )
		{
			case "A":
				$list     = "ol";
				$listtype = "upper-alpha";
				break;
			case "a":
				$list     = "ol";
				$listtype = "lower-alpha";
				break;
			case "I":
				$list     = "ol";
				$listtype = "upper-roman";
				break;
			case "i":
				$list     = "ol";
				$listtype = "lower-roman";
				break;
			case "1":
				$list     = "ol";
				$listtype = "decimal";
				break;
			case "circle":
				$list     = "ul";
				$listtype = "circle";
				break;
			case "square":
				$list     = "ul";
				$listtype = "square";
				break;
			case "disc":
				$list     = "ul";
				$listtype = "disc";
				break;
			default:
				$list     = "ul";
				$listtype = "";
				break;
		}

		// start list
		$thelist = '<' . $list . ' style="list-style-type: ' . $listtype . ';">';

		// create list points
		foreach($points AS $key => $point)
		{
			$start = strtolower ( substr ($point, 0, 3) );

			if ( $start === '<ul' OR $start === '<ol' OR $start === '<li' OR empty($start) )
			{
				$thelist .= $point;
			}
			else
			{
				$thelist .= '<li>' . $point . '</li>';
			}
		}

		// finish list
		$thelist .= "</$list>";

		// create output
		$output = str_replace($wholelist, $thelist, $text);

	 // return
	 return $output;
	}
}

## -------------------------------------------------------------------------------------------------------------- ##

#### handler 'handle_bbcode_getpatterns' ####
// selects all subpatterns out of a subpattern - string
function handle_bbcode_getpatterns ( $str )
{

 // global variables
 global $vwar_bbcode_delimeter,$vwarmod;

	$str = explode ( $vwar_bbcode_delimeter, $str );

 // return
 return $str;

}

## -------------------------------------------------------------------------------------------------------------- ##

#### handler 'handle_bbcode_subpatterns' ####
// handles all important stuff for subpatterns of bbcodes
function handle_bbcode_subpatterns ( $params, $simplecode )
{

 // global variables
 global $vwar_bbcode_delimeter,$vwarmod;	// string delimeter

	/* Configuration */
	// modifier for every regex
	$modifier  = "esiU";

	// define main code array
	$code = array();

	// save the whole regex
	$code["subpatterns"] = "\\0" . $vwar_bbcode_delimeter;

	// check for subpatterns
	if ( $params > 1 OR ($simplecode == 1 AND $params > 0) )
	{
		// so we have at least one subpattern...
		$addparams            = '=(&quot;|"|\'|)(.*)';
		$code["subpatterns"] .= "\\2" . $vwar_bbcode_delimeter;
		$startvalue           = ( $simplecode == 1 ) ? 2 : 3;
		for ( $i=$startvalue; $i<=$params; $i++ )
		{
			$addparams .= ",(.*)";

			// save this subpattern
			$code["subpatterns"] .= "\\$i" . $vwar_bbcode_delimeter;
		}
		$addparams .= "\\1";

		$whichpart           = $params + 1;
		$code["contentpart"] = "\\$whichpart";
	}
	else
	{
		$addparams           = "";
		$code["contentpart"] = "\\1";
	}

	// check for simple or advanced code
	if ( $simplecode == 1 )
	{
		// overwrite censor
		$code["contentpart"] = "puh, this text will pass the censor :)";

		// write regex
		$code["regex"] = "#\[%s" . $addparams . "\]#" . $modifier;
	}
	else
	{
		// write regex
		$code["regex"] = "#\[%s" . $addparams . "\](.*)\[/%s([^\]]*)\]#" . $modifier;
	}

 // return
 return $code;

}

?>