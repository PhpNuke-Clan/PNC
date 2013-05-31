<?php
/* #####################################################################################
 *
 * $Id: news_headlines.php,v 1.25 2004/09/12 13:02:05 mabu Exp $
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

// ####################################### CONFIGURATION  ###############################

// path to your main vwar-directory (with final ' / ')
// -> from the site, where this extra is included!
// -> use absolute path if you have it included in files with different directories!
//          (e.g. /home/www/htdocs/mysite.com/vwar/)
// -> if included in your _header.php/_footer.php, it is normally: './'
// -> if not, use: './../'
$vwar_xroot  = "./../";
include ($vwar_xroot . "modname.php");

// limit display to x headlines
$numheadlines =	10;

// after how many chars a news headline will be cut
$newslength   = 15;

// the replace sign for the headline if it is cut
$cutsign      = "...";

// include header- & footer-information (1=enabled / 0=disabled)
$include      = 0;

// ######################################################################################


##################################### display headlines ################################

// check, if we need to get some global vars or if we need to include them
if( !defined ("VWAR_COMMON_INCLUDED") )
{
	$vwar_root = $vwar_xroot;
	require_once ( $vwar_root . "includes/functions_common.php" );
}

if ( $include == 1 )
{
	include_once ( $vwar_root . "_header.php" );
}

// unset vars to prevent sql-injections
$wherecategory	= "";
?>
<table border="0" cellpadding="0" cellspacing="0" align="center">
<?php
// get only public categories if we got a guest
if (!checkCookie())
{
	$result = $vwardb->query("SELECT catid FROM vwar".$n."_newscat WHERE intern = '0'");
	while	($row =	$vwardb->fetch_array($result))
	{
		$categoriesarray[] = $row['catid'];
	}

	if (count($categoriesarray) > 0)
	{
		$wherecategory	= " AND vwar".$n."_news.catid IN ('" . join("','", $categoriesarray) . "')";
	}
}
else
{
	$wherecategory = "";
}

$result = $vwardb->query_first("
	SELECT COUNT(newsid) AS numnews
	FROM vwar".$n."_news
	WHERE activated = '1'
	$wherecategory
");
$num_news = $result['numnews'];

if ($num_news > 0)
{
	$result = $vwardb->query("
		SELECT DISTINCT(newsid), vwar".$n."_news.title, vwar".$n."_news.dateline, COUNT(sourceid) AS numcomments
		FROM vwar".$n."_news
		LEFT JOIN vwar".$n."_comments ON (newsid = sourceid AND frompage = 'news')
		WHERE activated = '1'
		$wherecategory
		GROUP BY newsid
		ORDER BY vwar".$n."_news.dateline DESC
		LIMIT 0, $numheadlines
	");
	while ($row=$vwardb->fetch_array($result))
	{
		dbSelect ($row);

		$row['title'] = (strlen($row['title'])>$newslength) ? (substr($row['title'], 0, $newslength) . $cutsign) : $row['title'];
		?>
		<tr>
			<td>
				&raquo;&nbsp;<a href="modules.php?name=<?php echo $vwarmod; ?>&newsid=<?php echo $row[newsid]; ?>"><?php echo $row['title'] ?></a>
				&nbsp;[<?php echo $row['numcomments']; ?> <a href="modules.php?name=<?php echo $vwarmod; ?>&action=comment&amp;newsid=<?php echo $row['newsid']; ?>"><img src="<?php echo $urltovwar; ?>images/comment.gif" align="middle" border="0" alt=""></a>]&nbsp;
			</td>
			<td align="center"><?php echo date($longdateformat,$row['dateline']); ?></td>
		</tr>
	 <?php
	}
	$vwardb->free_result($result);
}
else
{
	?>
	<tr>
		<td align="center">No News available</td>
	</tr>
	<?php
}
?>
</table>
<?php
if ( $include == 1 )
{
	include_once ( $vwar_root . "_footer.php" );
}
?>