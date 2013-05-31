<?php
/* #####################################################################################
 *
 * $Id: functions_news.php,v 1.11 2004/02/22 12:24:59 mabu Exp $
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
 * includes/functions_install.php
 * ------------------------------------------------------------------------------------
 * news functions
 * some important and frequently used functions of the news engine
*/

//include('../_header.php');
function handleSearch ()
{

 // load some global vars, so we can use/change them...
 global $vwardb, $GPC, $vwartpl, $str, $n, $maintablewidth,$vwarmod;
 global $whereclause, $highlitethis,$vwarmod;

		// update lastactivity of the search
		$vwardb->query("
			UPDATE vwar".$n."_search
			SET lastactivity = '" . time() . "'
			WHERE searchid = '" . $GPC["searchid"] . "'
		");

		// get searchquery
		$search = $vwardb->query_first("
			SELECT keyword, username, highlite, searchwhere, searchin, sort, daterestriction, searchclause
			FROM vwar".$n."_search
			WHERE searchid = '". $GPC["searchid"] ."'
		");

		// update "of"-language var (naaaasty....)
		$str_of = ucfirst ( $str["OF"] );

		// and use it...
		$sorter = explode("|||", $search["sort"]);

		if ( !isset ( $GPC["sortby"] ) )
		{
			$GPC["sortby"] = $sorter[0];
		}

		$whereclause   = $search["searchclause"] . $wherecategory1;

		if ( !empty ($search["highlite"]) )
		{
			$highlitethis  = explode("|||", $search["highlite"]);
		}

		// get search info
		$search["sort"]	    = $sorter[1];
		$search["searchin"] = urldecode($search["searchin"]);
		$searchlink         = makelink ("modules.php?name=vwar&file=news&" . ( ($GPC["action"] == "archive") ? "" : "action=archive&" ) . "searchid=" . $GPC["searchid"],
			(($GPC["action"] == "archive") ? $str["SHOWINDETAILS"] : $str["SHOWASOVERVIEW"]) );

		$username           = explode("|||", $search["username"]);
		if( $username[0] != $str["NOTAVAILABLESHORT"] )
		{
			$search["author"] = $username[0];
			$search["mode"]	  = " (" . lcfirst ($username[1]) . ")";
		}

		// strip the slashes if necessary
		dbSelect($search);

		// load the vars into the template
		eval ("\$searchinfo	= \"".$vwartpl->get("news_searchinfo")."\";");

 // return
 return $searchinfo;

}
## -------------------------------------------------------------------------------------------------------------- ##
function noNews ()
{

 // global vars
 global $vwartpl, $GPC, $maintablewidth, $str,$vwarmod;

	$action = ( !empty($GPC["action"]) ) ? $GPC["action"] : "";

	$quickjump = loadQuickjump($GPC["PURE_PHP_SELF"]);

	if (isset($GPC["cat"]))

	{
		$catselect = getCategoriesSelect( $action );
	}

	if($allowsubmit == 1)
	{
		eval("\$news_button_submit = \"".$vwartpl->get("news_button_submit")."\";");
	}

	eval("\$vwartpl->output(\"".$vwartpl->get("news_nonews")."\");");

}
## -------------------------------------------------------------------------------------------------------------- ##
function countNews ( $clause, $left_join = 0 )
{

 // global vars
 global $vwardb, $n,$vwarmod;

	$left_join = ( $left_join ) ? "LEFT JOIN vwar".$n."_member ON (vwar".$n."_news.memberid = vwar".$n."_member.memberid)" : "";

	$result = $vwardb->query_first("
		SELECT COUNT(newsid) AS numnews
		FROM vwar".$n."_news
		$left_join
		WHERE activated='1'
			$clause
	");

	$numnews = $result["numnews"];

 // return
 return $numnews;

}
## -------------------------------------------------------------------------------------------------------------- ##
function getLinksAndComments ()
{

 // global
 global $vwardb,$n,$vwarmod;

	$result = $vwardb->query ("
		SELECT title, url, target, newsid
		FROM vwar".$n."_newslink
	");
	while ( $row = $vwardb->fetch_array($result) )
	{
		$array["links_" . $row["newsid"]][] = array ("title" => $row["title"], "url" => $row["url"], "target" => $row["target"]);
	}

	$result = $vwardb->query ("
		SELECT sourceid
		FROM vwar".$n."_comments
		WHERE frompage = 'news'
	");
	while ( $row = $vwardb->fetch_array($result) )
	{
		if ( !isset($array["comments_" . $row["sourceid"]]) )
		{
			$array["comments_" . $row["sourceid"]] = 1;
		}
		else
		{
			$array["comments_" . $row["sourceid"]] = $array["comments_" . $row["sourceid"]] + 1;
		}
	}

 // return
 return $array;

}
## -------------------------------------------------------------------------------------------------------------- ##
function getCategoriesSelect($action="",$raw=0,$rawname="cat")
{
	global $vwardb,	$GPC, $n, $vwartpl, $cat, $wherecategory1, $str,$vwarmod;

	$result	= $vwardb->query("
		SELECT catid,catname
		FROM vwar".$n."_newscat
		" . str_replace("AND vwar".$n."_news.", "WHERE ", $wherecategory1) . "
		ORDER BY catname ASC
	");
	while ($category = $vwardb->fetch_array($result))
	{
		$catname  = dbSelectForm ($category["catname"]);
		$catid	  = $category["catid"];
		$selected = ifelse ($catid == $cat, "selected");

		eval("\$catselectbit .=	\"".$vwartpl->get("news_catselectbit")."\";");
	}

    if($raw == 1)
    {global $vwarmod;
        $catselect = '<select onChange="if(this.options[this.selectedIndex].value != -1)
        { document.vwarcatquickjump.submit() }" name="'.$rawname.'">'.$catselectbit.'</select>';
    }
    else
    {
        eval("\$catselect .= \"".$vwartpl->get("news_catselect")."\";");
    }

 return $catselect;

}

?>