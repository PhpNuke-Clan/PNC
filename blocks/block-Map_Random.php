<?php

/***************************************/
/* Random Map Block for Map Manager    */
/* Map Manager by gotcha  version 1.0  */
/* Copyright 2005 http://nukecoder.com */
/* You MAY NOT copy in whole or in part*/
/* or redistribute map manager without */
/* written consent from the author.    */
/* Contact and support can be found at */
/* http://nukecoder.com                */
/***************************************/
/* If you want to hide any line,        */
/* simply put // in front of the        */
/* corresponding $content variable.     */
/****************************************/

if ( !defined('BLOCK_FILE') ) {
    Header("Location: ../index.php");
    die();
}


global $prefix, $db;
//Change this value to match the name of the Map Manager module, for the links to work.
$module_name = "Maps";
//get config values
$cr3 = $db->sql_query("SELECT mval FROM ".$prefix."_mapconfig where mname='m_img'");
        list($mapimagedir) = $db->sql_fetchrow($cr3);
$cr3a = $db->sql_query("SELECT mval FROM ".$prefix."_mapconfig where mname='m_thumbw'");
        list($maptw) = $db->sql_fetchrow($cr3a);
$cr3b = $db->sql_query("SELECT mval FROM ".$prefix."_mapconfig where mname='m_thumbh'");
        list($mapth) = $db->sql_fetchrow($cr3b);
$cr3c = $db->sql_query("SELECT mval FROM ".$prefix."_mapconfig where mname='d_limit'");
        list($desclimit) = $db->sql_fetchrow($cr3c);

//get map info
$result2 = $db->sql_query("SELECT mapid, cat, title, details, image, hits FROM ".$prefix."_mapmap ORDER BY rand() ASC");
$row2 = $db->sql_fetchrow($result2);
$mapid = intval($row2['mapid']);
$mapcat = intval($row2['cat']);
$maptitle = stripslashes($row2['title']);
$mapdtl = stripslashes($row2['details']);
$mapimage = stripslashes($row2['image']);
$hits = intval($row2['hits']);
$total_maps = $db->sql_numrows($result2);

//limit details length
$mapdtls = substr($mapdtl, 0, $desclimit);

//replace spaces with _ for the url
$maptitle2 = ereg_replace(" ", "_", $maptitle);

//get cat info
$result3 = $db->sql_query("SELECT id, title FROM ".$prefix."_mapcat where id='$mapcat'");
$row3 = $db->sql_fetchrow($result3);
$catid = intval($row3['id']);
$ctitle = stripslashes($row3['title']);
//replace spaces with _ for the url
$ctitle2 = ereg_replace(" ", "_", $ctitle);


//start showing block
$content .= "<table width='100%' border='0' align='center'>\n";

//show category title with link
$content .= "<tr><td align='center'><a href='modules.php?name=Maps&amp;cat=$ctitle2&amp;id=$catid' title='$ctitle'>$ctitle</a></td></tr>\n";

//show map title with link
$content .= "<tr><td align='center'><a href='modules.php?name=Maps&amp;file=viewmap&amp;title=$maptitle2&amp;id=$mapid' title='View $maptitle'><font class='option'>$maptitle</font></a></td></tr>\n";

//if it is a hosted file, pull image from thumb folder
if (!isurlb($mapimage)){

        //show thumbnail image
        $content .= "<tr><td align='center' valign='top'><a href='modules.php?name=Maps&amp;file=viewmap&amp;title=$maptitle2&amp;id=$mapid' title='View $maptitle'><img src='$mapimagedir/thumb/$mapimage' alt='' width='$maptw' height='$mapth' border='0'></a></td></tr>\n";

//else, pull image from the url
}else{

        //show image from url
        $content .= "<tr><td align='center' valign='top'><a href='modules.php?name=Maps&amp;file=viewmap&amp;title=$maptitle2&amp;id=$mapid' title='View $maptitle'><img src='$mapimage' alt='' width='$maptw' height='$mapth' border='0'></a></td></tr>\n";

//end else
}
//show details
$content .= "<tr><td align='center' valign='top'><em>$mapdtls</em></td></tr>\n";

//show rating
list($maprating, $totalvotes) = $db->sql_fetchrow($db->sql_query("SELECT rating, totalvotes FROM ".$prefix."_mapvotes where mapid='$mapid'"));
if ($maprating) {
        $content .= "<tr><td align='center' valign='top'>Rating: <strong>$maprating/5</strong></td></tr><tr><td align='center' valign='top'>Total Votes: <strong>$totalvotes</strong></td></tr>\n";
}

//show num of hits
$content .= "<tr><td align='center' valign='top'>Hits: <strong>$hits</strong></td></tr>\n";

//show total # of maps
//$content .= "<tr><td align='center' valign='top'>Total Maps: <strong>$total_maps</strong></td></tr>\n";
$content .= "<tr><td align='center' valign='top'><a href='modules.php?name=$module_name'>Total Maps:</a> <strong>$total_maps</strong></td></tr>\n";

$content .= "</table>\n";

function isurlb($url){
        if (eregi("^((http|https|ftp)://)([[:alnum:]-])+(\.)([[:alnum:]-]){2,4}([[:alnum:]/+=%&_.~?-]*)$", $url)){
                return TRUE;
        }else{
                return FALSE;
        }
}
?>
