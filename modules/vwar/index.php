<?php
/* #####################################################################################
 *
 * $Id: news.php,v 1.87 2004/09/08 20:29:50 mabu Exp $
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

if (!eregi("modules.php", $_SERVER['PHP_SELF'])) {
    die ("You can't access this file directly...");
}
// get functions
$module_name = basename(dirname(__FILE__));
$vwar_root = "modules/" . basename(dirname(__FILE__)) ."/";
$vwar_file = "index";
//if (!defined('INDEX_FILE')) {echo"no way!!";
//}

//require("mainfile.php");
require($vwar_root . "modname.php");
require($vwar_root . "includes/functions_common.php");
require($vwar_root . "includes/functions_front.php");
require($vwar_root . "includes/functions_news.php");

// do the quickjump
doQuickjump($GPC['quickjumptarget']);

// unset vars to prevent sql-injections
$whereclause		= "";
$wherecategory1	= "";
$wherecategory2 = "";
$wherenews			= "";
$squery					= "";
$wherecat				= "";
$wherekeyword		= "";
$whereusername	= "";
$wherecat				= "";
$wheredateline	= "";

// get newssettings
$row = $vwardb->query_first("SELECT * FROM vwar".$n."_newssettings");
while (list($key,$value) = each($row))
{
	$$key	= dbSelect($value);
}
$perpage = (is_numeric($newsperpage)) ?	$newsperpage : $perpage;

#########################
#### news is offline ####
#########################
if ($newsstatus == 0)
{
	$vwartpl->cache("news_offnews");
	include ( $vwar_root . "includes/get_header.php" );
	$quickjump = loadQuickjump($GPC["PURE_PHP_SELF"]);
	$newsstatusmessage = parseText($newsstatusmessage, 1);
	eval("\$vwartpl->output(\"".$vwartpl->get("news_offnews")."\");");
	include ($vwar_root . "includes/get_footer.php");
	exit();
}

####################
#### categories	####
####################
$cat = $GPC["cat"];
if (!checkCookie())
{
	// standardcat
	if (is_numeric($standardcatpublic) && empty($cat)) $cat = $standardcatpublic;

	// hidden categories
	$result = $vwardb->query("SELECT catid FROM vwar".$n."_newscat WHERE intern = '0'");
	while	($row =	$vwardb->fetch_array($result))
	{
		$categoriesarray[] = $row["catid"];
	}

	if (count($categoriesarray) > 0)
	{
		$wherecategory1	= " AND vwar".$n."_news.catid IN ('" . join("','", $categoriesarray) . "')";
	}
}
else if	( empty($cat) && is_numeric($standardcatintern) )
{
	// standardcat
	$cat = $standardcatintern;
}
// cat is selected or standardcat
if ( !empty($cat) )
{
	$wherecategory2 = " AND vwar".$n."_news.catid	= '".$cat."'";
}

// #####################################################################################
// #####################################################################################
// ################################### start news output ###############################
// #####################################################################################
// #####################################################################################

if (!isset($GPC["action"]) || $GPC["action"]=="")
{
	// single news output
	if (isset($GPC["newsid"]))
	{
		$wherenews = " AND vwar".$n."_news.newsid = '".$GPC["newsid"]."'";
		$page	= $str["ALL"];

		if ( is_numeric($searchid) )
		{
			$search = $vwardb->query_first("
				SELECT highlite
				FROM vwar".$n."_search
				WHERE searchid = '" . $searchid . "'
			");
			if ( $search["highlite"] != "" )
			{
				$highlitethis = explode("|||", $search["highlite"]);
			}
		}
	}

	// result of a search
	if (is_numeric($searchid) && !isset($GPC["newsid"]))
	{

		$searchinfo = handleSearch ();

		// count news
		$numnews = countNews ( $whereclause, 1 );

	} else {

		$whereclause = $wherecategory1 . $wherecategory2 . $wherenews;

		// count news
		$numnews = countNews ( $whereclause );

	}

	// we have no news - boring live, you know?
	if ($numnews < 0)
	{
		$vwartpl->cache("news_nonews,news_button_submit,news_catselectbit,news_catselect");
		include ( $vwar_root . "includes/get_header.php" );

		noNews();

		include ($vwar_root . "includes/get_footer.php");
		exit();
	}

	// print news
	$vwartpllist  = "news_catselectbit,news_catselectbit2,news_catselect,news_newslist_more,";
	$vwartpllist .= "news_button_saf,news_button_submit,news_linkbit,news_links,news_newslist_iconbit,news_ticker";
	$vwartpllist .= "news_ticker_bit,news_extratable,news_newslist_allowcomments,news_newslistbit,news_newslist";
	$vwartpllist .= "news_pagelinks,news_ticker,news_newslist,news_ticker_bit,news_extratable";
	$vwartpl->cache($vwartpllist);
	include ( $vwar_root . "includes/get_header.php" );
	$quickjump = loadQuickjump($GPC["PURE_PHP_SELF"]);

	$news_info = getLinksAndComments ();

	if ($allowsubmit == 1)
	{
		eval("\$news_button_submit = \"".$vwartpl->get("news_button_submit")."\";");
	}

	$catselect = getCategoriesSelect();

	$clauses = getSortClauses();

	$result = $vwardb->query("
		SELECT vwar".$n."_news.*, name,	catname, caticon
		FROM vwar".$n."_news
		LEFT JOIN vwar".$n."_member ON (vwar".$n."_news.memberid = vwar".$n."_member.memberid)
		LEFT JOIN vwar".$n."_newscat ON	(vwar".$n."_news.catid = vwar".$n."_newscat.catid)
		WHERE activated	= '1'
			$whereclause
		GROUP BY newsid
		" . $clauses["sort"] . ", vwar".$n."_news.dateline DESC
		" . $clauses["limit"]
	);
	while	($row =	$vwardb->fetch_array($result))
	{
		dbSelect($row);

		$row["dateline"] = formatdatetime($row["dateline"]);

		// check if we got a deleted member
		if ($row['name'])
		{
			$authorlink = makelink ("modules.php?name=$vwarmod&file=member&action=profile&amp;memberid=" . $row["memberid"], $row["name"], $str["PROFILEOF"] .	" " . $row["name"]);
		}
		else
		{
			$authorlink = $str['GUEST'];
		}

		// more function
		if (($usemore == 1) && !isset($GPC["newsid"]) && ($pos = strpos($row["content"], $moresign)))
		{

			$row["content"] = substr($row["content"], 0, $pos);
			eval ("\$tmp = \"".$vwartpl->get("news_newslist_more")."\";");
			$row["content"] = $row["content"].$tmp;

		} else {

			$row["content"] = str_replace($moresign, "", $row["content"]);

		}

		$row["content"]	= parseText($row["content"], 1,	$row["convertsmilies"],	1, 1, $row["converturls"]);

		// highlite
		if(isset($highlitethis))
		{
			$row["content"] = preg_replace ($highlitethis, "<font color=\"{highlightcolor}\"><b>$0</b></font>",$row["content"]);
		}

		// news links
		if ( count($news_info["links_" . $row["newsid"]]) > 0 )
		{
			foreach ($news_info["links_" . $row["newsid"]] AS $id => $link)
			{
				eval ("\$linkbit .= \"".$vwartpl->get("news_linkbit")."\";");
			}
			eval ("\$links = \"".$vwartpl->get("news_links")."\";");
		}
		else
		{
			$links = "";
		}

		// send a friend
		if ($allowsendafriend == 1)
		{
			eval("\$news_button_saf	= \"".$vwartpl->get("news_button_saf")."\";");
		}

		// print this news
		$printimg  = makeimgtag($vwar_root . "images/button_print.gif",$str["PRINT"]);
		$printlink = popupwin("modules.php?name=$vwarmod&file=popup&action=printnews&amp;newsid=" . $row["newsid"],$printimg,"",true,700,600);

		// category icon
		if ($row["caticon"] && file_exists($vwar_root . "images/newsicons/".$row["caticon"]))
		{
			$caticon = makeimgtag($vwar_root . "images/newsicons/".$row["caticon"],$row["catname"]);
			eval ("\$iconbit = \"".$vwartpl->get("news_newslist_iconbit")."\";");
		}
		else
		{
			$iconbit = "";
		}

		// news ticker
		if ($showticker == 1	&& !isset($GPC["newsid"]))
		{
			$countentries++;

			if($countentries > 1)
			{
				eval ("\$tickerbit .= \"".$vwartpl->get("news_ticker_bit")."\";");
			}	else {
				$tickerbit = makelink("modules.php?name=$vwarmod&newsid=".$row["newsid"], $row["title"]);
			}

			eval ("\$ticker =	\"".$vwartpl->get("news_ticker")."\";");

			if (!($numnews > $perpage))
			{
				eval ("\$news_extratable = \"".$vwartpl->get("news_extratable")."\";");
			}
		}

		// comments
		$news_numcomments = $news_info["comments_" . $row["newsid"]];
		$news_numcomments = (empty($news_numcomments)) ? 0 : $news_numcomments;
		if ($row["allowcomments"] ==	1 || $news_numcomments > 0)
		{
			eval ("\$allowcomments = \"".$vwartpl->get("news_newslist_allowcomments")."\";");
		} else {
			$allowcomments = "";
		}

		// update list
		eval ("\$news_newslistbit .= \"".$vwartpl->get("news_newslistbit")."\";");
		unset($authorlink, $linkbit);
	}

	// get pagelinks
	if ($numnews > $perpage)
	{
		$pagelinks = makepagelinks($numnews,$perpage,"cat=$cat&amp;sortby=$sortby&amp;sortorder=$sortorder&amp;searchid=" . $searchid);
		eval ("\$pagelinks = \"".$vwartpl->get("news_pagelinks")."\";");
		eval ("\$news_extratable = \"".$vwartpl->get("news_extratable")."\";");

		$ticker = "";
		eval ("\$news_pagelinks = \"".$vwartpl->get("news_extratable")."\";");
	}

	// final output
	eval("\$vwartpl->output(\"".$vwartpl->get("news_newslist")."\");");
	$vwardb->free_result($result);
}

// #####################################################################################
// #####################################################################################
// ####################################	start news archive #############################
// #####################################################################################
// #####################################################################################

if ($GPC["action"] == "archive")
{
	// result of a search
	if (is_numeric($searchid) && !isset($GPC["newsid"]))
	{

		// handle the search
		$searchinfo = handleSearch ();

		// count news
		$numnews = countNews ( $whereclause, 1 );

	} else {

		$whereclause = $wherecategory1 . $wherecategory2;

		// count news
		$numnews = countNews ( $whereclause, 1 );

	}

	// we have no news - boring live, you know?
	if ($numnews < 0)
	{
		$vwartpl->cache("news_nonews,news_button_submit,news_catselectbit,news_catselect");
		include ($vwar_root . "includes/get_header.php");

		noNews();

		include ($vwar_root . "includes/get_footer.php");
		exit();
	}

	// print news
	$vwartpllist	= "news_archive_allowcomments,news_archive_newslistbit,news_archive,news_button_submit,news_button_saf,news_archive_links";
	$vwartpl->cache($vwartpllist);
	include ( $vwar_root . "includes/get_header.php" );
	$quickjump = loadQuickjump($GPC["PURE_PHP_SELF"]);

	$news_info = getLinksAndComments ();

	if($allowsubmit == 1) eval("\$news_button_submit = \"".$vwartpl->get("news_button_submit")."\";");
	$catselect = getCategoriesSelect();

	$clauses = getSortClauses("dateline");
	$sortnav = getSortNav ( array("dateline", "catname", "name", "title"), "dateline" );

	$result=$vwardb->query("
		SELECT allowcomments, vwar".$n."_news.memberid,	vwar".$n."_news.title, name, catname, vwar".$n."_news.catid,
			vwar".$n."_news.memberid, vwar".$n."_news.newsid, vwar".$n."_news.dateline
		FROM vwar".$n."_news
		LEFT JOIN vwar".$n."_member ON ( vwar".$n."_news.memberid = vwar".$n."_member.memberid)
		LEFT JOIN vwar".$n."_newscat ON ( vwar".$n."_news.catid = vwar".$n."_newscat.catid )
		WHERE activated	= '1'
		$whereclause
		GROUP BY vwar".$n."_news.newsid
		" . $clauses["sort"] . ", vwar".$n."_news.dateline DESC
		" . $clauses["limit"]
	);

	while($row=$vwardb->fetch_array($result))
	{
		dbSelect($row);
		switchColors();

		// date of the news
		$row["dateline"]=formatdatetime($row["dateline"]);

		// link to our author
		$authorlink = makelink ("modules.php?name=$vwarmod&file=member&action=profile&amp;memberid=" . $row["memberid"], $row["name"], $str["PROFILEOF"] .	" " . $row["name"]);

		// send a friend
		if($allowsendafriend == 1)	eval("\$news_button_saf	= \"".$vwartpl->get("news_button_saf")."\";");

		// print this news
		$printimg  = makeimgtag($vwar_root . "images/button_print.gif",$str["PRINT"]);
		$printlink = popupwin("modules.php?name=$vwarmod&file=popup&action=printnews&amp;newsid=".$row["newsid"],$printimg,"",true,700,600);

		// news links
		$row["numlinks"] = count($news_info["links_" . $row["newsid"]]);
		if($row["numlinks"] > 0) {
			eval ("\$links = \"".$vwartpl->get("news_archive_links")."\";");
		} else {
			$links = makeimgtag($vwar_root . "images/uncheck.gif",$str["NOENTRY"]);
		}

		// comments
		$row["numcomments"] = $news_info["comments_" . $row["newsid"]];
		$row["numcomments"] = (empty($row["numcomments"])) ? 0 : $row["numcomments"];
		if($row["allowcomments"] == 1 OR $row["numcomments"] > 0) {
			eval ("\$allowcomments = \"".$vwartpl->get("news_archive_allowcomments")."\";");
		} else {
			$allowcomments = makeimgtag($vwar_root . "images/uncheck.gif",$str["NOTAVAILABLE"]);
		}

		// update list
		eval ("\$news_archive_newslistbit .= \"".$vwartpl->get("news_archive_newslistbit")."\";");
		unset($news_linkbit, $authorlink);
	}
	$vwardb->free_result($result);

	$pagelinks = makepagelinks($numnews,$perpage,"action=archive&amp;cat=$cat&amp;sortby=$sortby&amp;sortorder=$sortorder&amp;searchid=".$searchid);

	// final output
	eval("\$vwartpl->output(\"".$vwartpl->get("news_archive")."\");");
}

// #####################################################################################
// #####################################################################################
// ################################### start comment output ############################
// #####################################################################################
// #####################################################################################

if ($GPC["action"] == "comment")
{
	$checkcomments = $vwardb->query_first("
		SELECT allowcomments, COUNT(commentid) AS numcomments
		FROM vwar".$n."_news
		LEFT JOIN vwar".$n."_comments ON ( vwar".$n."_news.newsid = vwar".$n."_comments.sourceid
			AND vwar".$n."_comments.frompage = 'news' )
		WHERE newsid = '".$GPC["newsid"]."'	$wherecategory1
		GROUP BY newsid
	");
	if ($checkcomments["allowcomments"] !=	1 AND $checkcomments["numcomments"] < 1)
	{
		$vwartpl->cache ( "message_functiondisabled" );

		include ($vwar_root . "includes/get_header.php");

		eval ("\$vwartpl->output(\"" . $vwartpl->get("message_functiondisabled") . "\");");

		include ($vwar_root . "includes/get_footer.php");

		exit();
	}

	// create vars (only if comment-action != delete)
	if($GPC["cmd"] != "delete" &&	$command != "delete")
	{
		$row = $vwardb->query_first("
			SELECT title,dateline
			FROM vwar".$n."_news
			WHERE newsid = '".$GPC["newsid"]."'
		");
		$newsdate = formatdatetime($row["dateline"],$longdateformat,1);
		$row["title"] = dbSelect($row["title"]);
		eval("\$commenttitle = \"".$vwartpl->get("comment_display_commenttitle_news")."\";");
		$returntitle = $str["BACKTONEWS"];
		$returnurl	 = "modules.php?name=$vwarmod&newsid=".$GPC["newsid"];
	}

	// params
	$comments = array (
		"sourceid"	=> $GPC["newsid"],
		"frompage"	=> "news",
		"title"		=> "News",
		"commenttitle"	=> $commenttitle,
		"returntitle"	=> $returntitle,
		"returnurl"	=> $returnurl,
		"allowadd"	=> $checkcomments["allowcomments"],
		"command"	=> ""
	);
	// load engine
	include("includes/functions_comments.php");
}

// #####################################################################################
// #####################################################################################
// ####################################### send	a news #################################
// #####################################################################################
// #####################################################################################

if ($GPC["action"] == "send")
{

	if ($GPC["add"] || $GPC["add_x"])
	{
		// check for wrong data
		if(!checkMail($to) || (!checkCookie() && !checkMail($frommail)) || empty($mailtext))
		{
			$vwartpl->cache ("message_error_sendnews");

			include ( $vwar_root . "includes/get_header.php" );

			eval ("\$vwartpl->output(\"" . $vwartpl->get("message_error_sendnews") . "\");");

			include ($vwar_root . "includes/get_footer.php");

			exit();
		}

		//member sends mail
		if ($member = checkCookie())
		{
			$member	=	$vwardb->query_first("
				SELECT email, name
				FROM vwar".$n."_member
				WHERE memberid = '" . $GPC["vwarid"] . "'
			");
			$fromname	= $member["name"];
			$frommail	= $member["email"];
		}

		// get links
		$newslink =	checkUrlFormat(checkPath($urltovwar))."modules.php?name=$vwarmod&newsid=".$GPC['newsid'];
		$pagelink =	checkUrlFormat($ownhomepage);

		// get news
		$news = $vwardb->query_first("
			SELECT vwar".$n."_news.*, name,	email, catname,	COUNT(linkid) AS numlinks
			FROM vwar".$n."_news
			LEFT JOIN vwar".$n."_member ON (vwar".$n."_news.memberid = vwar".$n."_member.memberid)
			LEFT JOIN vwar".$n."_newscat ON	(vwar".$n."_news.catid = vwar".$n."_newscat.catid)
			LEFT JOIN vwar".$n."_newslink ON (vwar".$n."_news.newsid = vwar".$n."_newslink.newsid)
			WHERE activated	= '1'
				AND vwar".$n."_news.newsid = '".$GPC["newsid"]."' $wherecategory1
			GROUP BY vwar".$n."_news.newsid
		");

		// news links
		if ($news["numlinks"]	> 0)
		{
			$result2 = $vwardb->query("
				SELECT title, url
				FROM vwar".$n."_newslink
				WHERE newsid = '".$news["newsid"]."'
			");
			$links = "";
			while ($link = $vwardb->fetch_array($result2))
			{
				$links .= "\n- " . $link["title"]	. ": " . $link["url"];
			}
		}
		else
		{
			$links = $str["NOTAVAILABLESHORT"];
		}

		// create mailtext
		$news["content"] = str_replace($moresign, "", $news["content"]);
		$usertext = strip_slashes($mailtext);
		$time     = formatdatetime ( time(), $shortdateformat );
		$catlink  = checkPath ( $urltovwar ) . "modules.php?name=$vwarmod&cat=" . $news["catid"];
		eval("\$mailtext = \"".$vwartpl->get("news_sendnews_mailtext")."\";");

		$fromname = strip_slashes($GPC["fromname"]);

		sendMail( $mailtext, $to, strip_slashes($receiver), $frommail, strip_slashes($fromname), strip_slashes($subject), $format, $priority, $news["convertsmilies"], $news["converturls"] );

		$vwartpl->cache ( "message_confirmation" );
		include ( $vwar_root . "includes/get_header.php" );
		$redirecturl = "modules.php?name=$vwarmod";
		eval ("\$vwartpl->output(\"" . $vwartpl->get("message_confirmation") . "\");");
		include ($vwar_root . "includes/get_footer.php");
		exit();
	}

	//template-cache, standard-templates will be added by	script:
	$vwartpllist="smiliesoff,smilieson,htmlcodeon,htmlcodeoff,bbcodeon,bbcodeoff,bbcode_language,bbcode_javascript,bbcode";
	$vwartpllist="news_sendnews,member_formmailer_guest,member_formmailer_member";
	$vwartpl->cache($vwartpllist);
	$quickjump = loadQuickjump($GPC["PURE_PHP_SELF"]);

	// get the news
	$row = $vwardb->query_first("
		SELECT vwar".$n."_news.*,	name, catname, caticon,	COUNT(linkid) AS numlinks
		FROM vwar".$n."_news
		LEFT JOIN	vwar".$n."_member ON (vwar".$n."_news.memberid = vwar".$n."_member.memberid)
		LEFT JOIN	vwar".$n."_newscat ON (vwar".$n."_news.catid = vwar".$n."_newscat.catid)
		LEFT JOIN	vwar".$n."_newslink ON (vwar".$n."_news.newsid = vwar".$n."_newslink.newsid)
		WHERE activated =	'1'
		AND vwar".$n."_news.newsid = '" . $GPC["newsid"] . "'
		$wherecategory1
		GROUP BY vwar".$n."_news.newsid
	");
	dbSelect($row);

	// check catid
	if (!checkCookie() && !in_array($row["catid"], $categoriesarray))
	{
		header("Location: modules.php?name=$vwarmod");
		exit;
	}

	if ($allowsubmit == 1)
	{
		eval("\$news_button_submit = \"".$vwartpl->get("news_button_submit")."\";");
	}

	$authorlink = makelink ("modules.php?name=$vwarmod&file=member&action=profile&amp;memberid=" . $row["memberid"], $row["name"], $str["PROFILEOF"] .	" " . $row["name"]);

	$row["dateline"] = formatdatetime($row["dateline"]);
	$row["content"]	= parseText(str_replace($moresign, "", $row["content"]), 1, $row["convertsmilies"], 1, 1, $row["converturls"]);

	if ($row["numlinks"] >	0)
	{
		$result2 = $vwardb->query("
			SELECT title, url, target
			FROM vwar".$n."_newslink
			WHERE newsid = '".$row["newsid"]."'
		");
		while ($link = $vwardb->fetch_array($result2))
		{
			eval ("\$linkbit .= \"".$vwartpl->get("news_linkbit")."\";");
		}
		eval ("\$links = \"".$vwartpl->get("news_links")."\";");
	}

	$printimg	= makeimgtag($vwar_root . "images/button_print.gif",$str["PRINT"]);
	$printlink = popupwin("modules.php?name=$vwarmod&file=popup&action=printnews&amp;newsid=".$row["newsid"],$printimg,"",true,700,600);

	if ($row["caticon"] && file_exists($vwar_root	. "images/newsicons/".$row["caticon"]))
	{
		$caticon = makeimgtag($vwar_root . "images/newsicons/".$row["caticon"],$row["catname"]);
		eval ("\$iconbit = \"".$vwartpl->get("news_newslist_iconbit")."\";");
	}
	else
	{
		$caticon = "";
	}

	// priority
	if (empty($priority)) $priority = 3;
	$selected[$priority] = "selected";

	// format
	if ($format ==	"html")
	{
		$selected["format"]	= "selected";
		getTextRestrictions("mailform","mailtext","{secondaltcolor}",1);
	}
	else
	{
		$nextcolor[1] = "{secondaltcolor}";
	}

	// member or guest
	if (checkCookie())
	{
		$member = $vwardb->query_first("
			SELECT email,name
			FROM vwar".$n."_member
			WHERE memberid = '".$GPC["vwarid"]."'
		");
		eval("\$senderoption = \"".$vwartpl->get("member_formmailer_member")."\";");
	}
	else
	{
		eval("\$senderoption = \"".$vwartpl->get("member_formmailer_guest")."\";");
	}

	include ($vwar_root . "includes/get_header.php");
	// output
	eval("\$vwartpl->output(\"".$vwartpl->get("news_sendnews")."\");");
}

// #####################################################################################
// #####################################################################################
// ###################################### submit a news	################################
// #####################################################################################
// #####################################################################################

if ($GPC["action"] == "submit")
{
	if ($GPC["add"])
	{
		// check for correct input
		$ismember = checkCookie();
		if ( (!$ismember && ( empty($GPC["author"]) || !checkMail($GPC["email"]) || !($registered = checkRegistered($GPC["author"], $GPC["email"])) ))
				 ||	empty($GPC["title"]) ||	empty($GPC["warinfo"]) || empty($GPC["cat"]) )
		{
			if( isset($registered) AND $registered == false)
			{
				eval("\$registered = \"".$vwartpl->get("message_error_registered")."\";");
			}
			$vwartpl->cache ( "message_error_submitnews" );
			include ( $vwar_root . "includes/get_header.php" );
			eval ("\$vwartpl->output(\"" . $vwartpl->get("message_error_submitnews") . "\");");
			include ( $vwar_root . "includes/get_footer.php" );
			exit();

		}

		// insert the news into	the database and set it	to a non-active	status
		if ( $ismember == true )
		{
			$GPC["email"]	= $GPC["vwarid"];
			$GPC["author"] = $GPC["membername"];
		}
		$vwardb->query ("
			INSERT INTO vwar".$n."_news
			(
				catid, title,	memberid, content, convertsmilies, converturls,	submitname, submitinfo,
				dateline, activated
			)
			VALUES (
			'".$GPC["cat"]."',
			'".$GPC["title"]."',
			'0',
			'".$GPC["warinfo"]."',
			'".$GPC["smilies"]."',
			'".$GPC["urlsearch"]."',
			'".$GPC["author"]."',
			'".$GPC["email"]."',
			'".time()."',
			'0')
		");

		// db transaction is done, we can strip	the slashes
		dbSelect ($GPC,	1, 0);

		// prepare the mail text
		if ($ismember == true)
		{
			$result	= $vwardb->query_first ("
				SELECT name, email
				FROM vwar".$n."_member
				WHERE memberid = '".$GPC["vwarid"]."'
			");
			$GPC["author"] = $result["name"];
			$GPC["email"]  = $result["email"];
		}
		$dateline = formatdatetime ( time() );
		$category = $vwardb->query_first("
			SELECT catname
			FROM vwar".$n."_newscat
			WHERE catid = '".$GPC["cat"]."'
		");
		eval ("\$content = \"".$vwartpl->get("message_mail_submitnews")."\";");

		// send	a news to everyone who can add news or is admin
		$result	= $vwardb->query ("
			SELECT name, email
			FROM vwar".$n."_member,	vwar".$n."_accessgroup
			WHERE ismember = '1'
				AND ( canaddnews = '1' OR isadmin = '1'	)
				AND vwar".$n."_member.accessgroupid = vwar".$n."_accessgroup.accessgroupid
		");
		while ($row = $vwardb->fetch_array($result))
		{
			dbSelect ($row,	0, 0);
			sendMail ($content, $row["email"], $row["name"], "", "", "Virtual War Submit News");
		}

		$vwartpl->cache ( "message_confirmation" );
		include ( $vwar_root . "includes/get_header.php" );
		$redirecturl = "modules.php?name=$vwarmod";
		eval ("\$vwartpl->output(\"" . $vwartpl->get("message_confirmation") . "\");");
		include ( $vwar_root . "includes/get_footer.php" );
		exit();

	} else {

		// template cache
		$tpllist  = "smiliesoff,smilieson,htmlcodeon,htmlcodeoff,bbcodeon,bbcodeoff,bbcode_language,bbcode_javascript,bbcode";
		$tpllist .= "news_submitnews,news_catselectbit";
		$vwartpl->cache	($tpllist);

		// get header
		include ( $vwar_root . "includes/get_header.php" );

		// get more function
		if ( ($usemore == 1) &&	!empty($moresign) )
		{
			eval("\$moreinfo = \"".$vwartpl->get("news_moreinfo")."\";");
		}

		// get special form for	members
		if ( checkCookie() )
		{
			$result	= $vwardb->query_first ("
				SELECT name, email
				FROM vwar".$n."_member
				WHERE memberid = '".$GPC["vwarid"]."'
			");
			eval("\$userinfo = \"".$vwartpl->get("news_submitnews_member")."\";");

		} else {

			eval("\$userinfo = \"".$vwartpl->get("news_submitnews_guest")."\";");

		}

		// get quickjump
		$quickjump = loadQuickjump ($GPC["PURE_PHP_SELF"]);

		// get categories
		$catselect = getCategoriesSelect ("", 1);

		// get clickable bbcode	and smilies, get restrictions
		getTextRestrictions ();

		// get form, output
		eval ("\$vwartpl->output(\"".$vwartpl->get("news_submitnews")."\");");

	}
}

// #####################################################################################
// #####################################################################################
// ###################################### search a news	################################
// #####################################################################################
// #####################################################################################

if ($GPC["action"] == "search")
{

	// delete old search requests (older than one hour)
	$vwardb->query("DELETE FROM vwar".$n."_search	WHERE lastactivity < ".(time()-3600));

	// update the "of"-language var
	$str["OF"] = ucfirst ( $str["OF"] );

	// search form was sent
	if ($GPC["add"] || $GPC["add_x"])
	{
	// check for correct input
	if ((empty($keyword) && empty($username)) || (strlen($keyword)<3 &&	strlen($username)<3) ||	count($searchwhere) == 0)
		{
			$vwartpl->cache ( "message_error_search" );
			include ( $vwar_root . "includes/get_header.php" );
			eval ("\$vwartpl->output(\"" . $vwartpl->get("message_error_search") . "\");");
			include ( $vwar_root . "includes/get_footer.php" );
			exit();
		}

		// well then, we can move on...

		// search for a keyword
		if (!empty($keyword)) {
			$getwords			= convertSearchString ($keyword, $searchwhere);
			$wherekeyword = $getwords[1];
			$highlite			= $getwords[0];
			$searchwhere	= preg_replace( array("/content/","/vwar".$n."_news.title/"),
						array($str["CONTENT"],$str["TITLE"]),implode(" ".$str["AND"]." ",$searchwhere));
		} else {
			$keyword     = $str["NOTAVAILABLESHORT"];
			$searchwhere = $str["NOTAVAILABLESHORT"];
		}

		// search for a username
		if (!empty($username))
		{
			$whereusername .= convertSearchString ($username, array("name"), $username_how, 0);
			$username_how   = ($username_how == 1) ? $str["MATCHEXACTNAME"] : $str["MATCHPARTIALNAME"];
		}
		else
		{
			$username_how	= "";
			$username       = $str["NOTAVAILABLESHORT"];
		}

		// date of the entries
		if ($searchdate != 0 && is_numeric ($searchdate))
		{
			$sign = ($searchdate_mod == $str["NEWER"]) ? ">" : "<";
			$searchdate_mod =	$str["AND"]." ".$searchdate_mod;
			$wheredateline = " AND vwar".$n."_news.dateline ".$sign."	".(time()-$searchdate);
		}
		else
		{
			$searchdate_mod =	"";
		}
		$searchdate	= $searchdate /	86400;

		// search in
		if (in_array ("all", $searchin))
		{
			$wherecat				 = $wherecategory1;
			$searchinnames[] = $str["ALL"];
		}
		else
		{
			while (list(, $val) = each ($searchin))
			{
				$val = explode(".", $val);
				if (checkCookie()) {
					$searchinarray[] = $val[0];
					$searchinnames[] = $val[1];
				}
				elseif (in_array($val, $categoriesarray)) {
					$searchinarray[] = $val[0];
					$searchinnames[] = $val[1];
				}
			}
			$wherecat	= " AND	vwar".$n."_news.catid IN ('".join ("','", $searchinarray)."')";
		}

		// search query
		$squery = $wherekeyword.$whereusername.$wherecat.$wheredateline;

		// check for results
		$checkquery	= $vwardb->query_first("
			SELECT COUNT(newsid) AS numnews
			FROM vwar".$n."_news
			LEFT JOIN	vwar".$n."_member ON (vwar".$n."_news.memberid = vwar".$n."_member.memberid)
			WHERE activated =	'1' $squery $wherecat
		");

		// no results
		if ($checkquery["numnews"] < 1)
		{
			$vwartpl->cache ( "message_error_search_noresults" );
			include ( $vwar_root . "includes/get_header.php" );
			eval ("\$vwartpl->output(\"" . $vwartpl->get("message_error_search_noresults") . "\");");
			include ( $vwar_root . "includes/get_footer.php" );
			exit();
		}

		// sorting feature
		$sorter     = explode("X", $sortby);
		$sortby     = $sorter[1];
		$ssortby    = $str[strtoupper($sorter[0])];
		$ssortorder = ($sortorder == "ASC") ? $str["ASCENDING"] : $str["DESCENDING"];

		// insert query into database
		// the data	has to be masked with addslashes() because they	are created by script!
		$vwardb->query("
			INSERT INTO vwar".$n."_search
				( searchclause,	highlite, searchwhere, searchin, sort, daterestriction,	lastactivity, keyword, username	)
			VALUES
				(
					'".addslashes($squery)."', '".addslashes($highlite)."', '".addslashes($searchwhere)."',
					'".addslashes(implode(", ",$searchinnames))."', '".$sortby." ".$sortorder."|||".$ssortby.", ".$ssortorder."',
					'".$str["LASTDAYS$searchdate"]." $searchdate_mod', '".time()."',
					'".$keyword."', '".$username."|||$username_how'
				)
		");
		$insertid =	$vwardb->insert_id();

		if ($displaymode == 0)
		{
			$redirecturl = "modules.php?name=$vwarmod&action=archive&amp;searchid=".$insertid;
		}
		else
		{
			$redirecturl = "modules.php?name=$vwarmod&searchid=".$insertid;
		}

		$vwartpl->cache ( "message_confirmation" );
		include ( $vwar_root . "includes/get_header.php" );
		eval ("\$vwartpl->output(\"" . $vwartpl->get("message_confirmation") . "\");");

		include ($vwar_root . "includes/get_footer.php");
		exit();
	}
	// get search form
	else
	{

		// template cache
		$vwartpllist = "news_catselectbit,news_button_submit,news_search";
		$vwartpl->cache($vwartpllist);

		// header information, quickjump
		include ( $vwar_root . "includes/get_header.php" );
		$quickjump = loadQuickjump($GPC["PURE_PHP_SELF"]);

		// get categories
		$result = $vwardb->query("
			SELECT catid, catname
			FROM vwar".$n."_newscat
			" . str_replace("AND vwar".$n."_news.", "WHERE ", $wherecategory1) . "
			ORDER BY catname ASC
		");

		while ($row	= $vwardb->fetch_array($result))
		{
			$catname = dbSelectForm ($row["catname"]);
			$catid	 = $row["catid"] . "." . urlencode($catname);

			eval("\$searchin_bit .= \"".$vwartpl->get("news_catselectbit")."\";");
		}

		if ($allowsubmit == 1)
		{
			eval("\$news_button_submit = \"".$vwartpl->get("news_button_submit")."\";");
		}

		// get form
		eval("\$vwartpl->output(\"".$vwartpl->get("news_search")."\");");
	}

}

include ($vwar_root . "includes/get_footer.php");
?>
