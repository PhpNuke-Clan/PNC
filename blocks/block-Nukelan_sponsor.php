<?php
if ( !defined('BLOCK_FILE') ) {
    Header("Location: ../index.php");
    die();
}

global $prefix, $db;
//
// The following line is for you to specify a particular party to view, just put the party_id in between the ''
//$result = $db->sql_query("SELECT * FROM nukelan_parties WHERE party_id=''");
//
// The Following line is to select the next lan party that has not ended.
$result = $db->sql_query("SELECT * FROM nukelan_parties WHERE enddate > NOW() ORDER BY date ASC");
// 
// CHOOSE A MODE
// 1 - Show one banner at a time from the list of sponsors for the upcoming party, or show all sponsors if there is no party.
// 2 - Show all banners at once from the list of sponsors for the upcoming party, or show all sponsors if there is no party.
// 3 - Show one banner at a time from a list of ALL sponsors.
// 4 - Show all sponsor banners at once.
// 
$sponsor_mode = 2;
//
// SET THE MAXIMUM PICTURE-WIDTH (Depends on block with and; If the picture is larger, it will be narrowed)
$maxwidth = 100;
//
//

$numrows = $db->sql_numrows($result);
$lan = $db->sql_fetchrow($result);
$sponsors = $db->sql_query("SELECT l.*, u.* FROM nukelan_sponsors AS l LEFT JOIN nukelan_sponsors_parties AS u ON (l.id = u.sponsor_id) WHERE u.party_id='$lan[party_id]' AND active=1");
$banners = $db->sql_query("SELECT * FROM nukelan_sponsors_banners WHERE type=1 AND active=1");
$num_sponsors = $db->sql_numrows($sponsors);
$num_banners = $db->sql_numrows($banners);
$nosponsors = $db->sql_numrows($db->sql_query("SELECT * FROM nukelan_sponsors"));

if (!$nosponsors) {
        $content = "Sorry, there are no sponsors.";
}
elseif (!$num_banners) {
        $content = "Sorry, there are no banners.";
}
else {
        if ($sponsor_mode == 1) {
                $sponsorlist = "0";
                while ($sponsor_row = $db->sql_fetchrow($sponsors)) {
                $sponsorlist .= ",$sponsor_row[id]";
                }
                $ifnolans = "AND cid IN ($sponsorlist)";
                if (!$numrows) {
                $ifnolans = "";
                }
                $content = "<center><a href=\"modules.php?op=modload&name=Nukelan&file=index&lanop=show_party&party_id=$lan[party_id]\"><b>$lan[keyword] Sponsor</b></a></center><br>";
                $ban_result = $db->sql_query("SELECT * FROM nukelan_sponsors_banners WHERE type=1 AND active='1' $ifnolans");
                $ban_rows = $db->sql_numrows($ban_result);
        
                if ($ban_rows>1) {
                        $ban_rows = $ban_rows-1;
                        mt_srand((double)microtime()*1000000);
                        $ban_rows = mt_rand(0, $ban_rows);
                } else {
                        $ban_rows = 0;
                }
                $ban = $db->sql_fetchrow($db->sql_query("SELECT * FROM nukelan_sponsors_banners WHERE type=1 AND active='1' $ifnolans LIMIT $ban_rows, 1"));
                $row2 = $db->sql_fetchrow($db->sql_query("SELECT * FROM nukelan_sponsors WHERE id='$ban[cid]'"));
                $bid = $ban['bid'];
                $alttext = $ban['alttext'];
                $imageurl = $ban['imageurl'];
                $imptotal = $ban['imptotal'];
                $count_url = strlen($imageurl);
                $image_check = substr($imageurl, $count_url-3);

                if ($image_check == 'swf') {
                        $size = getimagesize($imageurl);
                        $size_w = $size[0];
                        $size_h = $size[1];
                        if ($size_w > 145) {
                                $div_x = (145 / $size_w);
                                $size_w = round($div_x * $size_w, 0);
                                $size_h = round($div_x * $size_h, 0);
                        }
                        $content .= "<center><object classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=4,0,2,0\" width=\"$size_w\" height=\"$size_h\">";
                        $content .= "<param name=\"movie\" value=\"$imageurl\">";
                        $content .= "<param name=quality value=high>";
                        $content .= "<embed src=\"$imageurl\" quality=high pluginspage=\"http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash\" type=\"application/x-shockwave-flash\" width=\"100%\" height=\"100%\">";
                        $content .= "</embed></object>";
                        $content .= "<br><br>";
                        $content .= "<a href=\"lansponsors.php?op=click&amp;bid=$bid\" target=\"_blank\">$row2[sponsor_name]</a></center>";
                } else {
                        $content .= "<center><a href=\"lansponsors.php?op=click&amp;bid=$bid\" target=\"_blank\"><img src=\"$imageurl\" border=\"0\" alt=\"$alttext\" title=\"$alttext\" width=\"$maxwidth\"></a><br><br>";
                        $content .= "<a href=\"lansponsors.php?op=click&amp;bid=$bid\" target=\"_blank\">$row2[sponsor_name]</a></center>";
                }
        
                $content .= "<br><br>";
        
                // check impressions total
                if (($imptotal <= $impmade) AND ($imptotal != 0)) {
                $db->sql_query("UPDATE nukelan_sponsors_banner SET active='0' WHERE bid='$bid'");
                }
                // update table with new impression info
                $db->sql_query("UPDATE nukelan_sponsors_banners SET impmade=impmade+1 WHERE bid=$bid");
        }
        elseif ($sponsor_mode == 2) {
                $content = "<center><a href=\"modules.php?op=modload&name=Nukelan&file=index&lanop=show_party&party_id=$lan[party_id]\"><b>$lan[keyword] Sponsors</b></a></center><br>";
                while ($row3 = $db->sql_fetchrow($sponsors)) {
                        $ifnolans = "AND cid=$row3[id]";
                        if (!$numrows) {
                        $ifnolans = "";
                        }
                        $ban_result = $db->sql_query("SELECT * FROM nukelan_sponsors_banners WHERE type=1 AND active=1 $ifnolans");
                        while($ban = $db->sql_fetchrow($ban_result)){
                        $bid = $ban['bid'];
                        $alttext = $ban['alttext'];
                        $imageurl = $ban['imageurl'];
                        $imptotal = $ban['imptotal'];
                        $count_url = strlen($imageurl);
                        $image_check = substr($imageurl, $count_url-3);
                        
                        if ($image_check == 'swf') {
                                $size = getimagesize($imageurl);
                                $size_w = $size[0];
                                $size_h = $size[1];
                                if ($size_w > 145) {
                                        $div_x = (145 / $size_w);
                                        $size_w = round($div_x * $size_w, 0);
                                        $size_h = round($div_x * $size_h, 0);
                                }
                                $content .= "<center><object classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=4,0,2,0\" width=\"$size_w\" height=\"$size_h\">";
                                $content .= "<param name=\"movie\" value=\"$imageurl\">";
                                $content .= "<param name=quality value=high>";
                                $content .= "<embed src=\"$imageurl\" quality=high pluginspage=\"http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash\" type=\"application/x-shockwave-flash\" width=\"100%\" height=\"100%\">";
                                $content .= "</embed></object>";
                                $content .= "<br><br>";
                                $content .= "<a href=\"lansponsors.php?op=click&amp;bid=$bid\" target=\"_blank\">$row3[sponsor_name]</a></center>";
                        } else {
                                $content .= "<center><a href=\"lansponsors.php?op=click&amp;bid=$bid\" target=\"_blank\"><img src=\"$imageurl\" border=\"0\" alt=\"$alttext\" title=\"$alttext\" width=\"$maxwidth\"></a><br><br>";
                                $content .= "<a href=\"lansponsors.php?op=click&amp;bid=$bid\" target=\"_blank\">$row3[sponsor_name]</a></center>";
                        }
                        }
                        $content .= "<br><br>";
                
                        // update table with new impression info
                        $db->sql_query("UPDATE nukelan_sponsors_banners SET impmade=impmade+1 WHERE bid=$bid");
                        // check impressions total
                        if (($imptotal <= $impmade) AND ($imptotal != 0)) {
                        $db->sql_query("UPDATE nukelan_sponsors_banner SET active='0' WHERE bid='$bid'");
                        }
                }
        }
        elseif ($sponsor_mode == 3) {
                $sponsorlist = "0";
                $sponsor_query = $db->sql_query("SELECT * FROM nukelan_sponsors");
                while ($sponsor_row = $db->sql_fetchrow($sponsor_query)) {
                $sponsorlist .= ",$sponsor_row[id]";
                }
                $ifnolans = "AND cid IN ($sponsorlist)";
                $content = "<center><b>Lan Party Sponsor</b></center><br>";
                $ban_result = $db->sql_query("SELECT * FROM nukelan_sponsors_banners WHERE type=1 AND active='1' $ifnolans");
                $ban_rows = $db->sql_numrows($ban_result);
        
                if ($ban_rows>1) {
                        $ban_rows = $ban_rows-1;
                        mt_srand((double)microtime()*1000000);
                        $ban_rows = mt_rand(0, $ban_rows);
                } else {
                        $ban_rows = 0;
                }
                $ban = $db->sql_fetchrow($db->sql_query("SELECT * FROM nukelan_sponsors_banners WHERE type=1 AND active='1' $ifnolans LIMIT $ban_rows, 1"));
                $row2 = $db->sql_fetchrow($db->sql_query("SELECT * FROM nukelan_sponsors WHERE id='$ban[cid]'"));
                $bid = $ban['bid'];
                $alttext = $ban['alttext'];
                $imageurl = $ban['imageurl'];
                $imptotal = $ban['imptotal'];
                $count_url = strlen($imageurl);
                $image_check = substr($imageurl, $count_url-3);
        
                if ($image_check == 'swf') {
                        $size = getimagesize($imageurl);
                        $size_w = $size[0];
                        $size_h = $size[1];
                        if ($size_w > 145) {
                                $div_x = (145 / $size_w);
                                $size_w = round($div_x * $size_w, 0);
                                $size_h = round($div_x * $size_h, 0);
                        }
                        $content .= "<center><object classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=4,0,2,0\" width=\"$size_w\" height=\"$size_h\">";
                        $content .= "<param name=\"movie\" value=\"$imageurl\">";
                        $content .= "<param name=quality value=high>";
                        $content .= "<embed src=\"$imageurl\" quality=high pluginspage=\"http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash\" type=\"application/x-shockwave-flash\" width=\"100%\" height=\"100%\">";
                        $content .= "</embed></object>";
                        $content .= "<br><br>";
                        $content .= "<a href=\"lansponsors.php?op=click&amp;bid=$bid\" target=\"_blank\">$row2[sponsor_name]</a></center>";
                } else {
                        $content .= "<center><a href=\"lansponsors.php?op=click&amp;bid=$bid\" target=\"_blank\"><img src=\"$imageurl\" border=\"0\" alt=\"$alttext\" title=\"$alttext\" width=\"$maxwidth\"></a><br><br>";
                        $content .= "<a href=\"lansponsors.php?op=click&amp;bid=$bid\" target=\"_blank\">$row2[sponsor_name]</a></center>";
                }
        
                $content .= "<br><br>";
        
                // check impressions total
                if (($imptotal <= $impmade) AND ($imptotal != 0)) {
                $db->sql_query("UPDATE nukelan_sponsors_banner SET active='0' WHERE bid='$bid'");
                }
                // update table with new impression info
                $db->sql_query("UPDATE nukelan_sponsors_banners SET impmade=impmade+1 WHERE bid=$bid");
        }
        elseif ($sponsor_mode == 4) {
                $content = "<center><a href=\"modules.php?op=modload&name=Nukelan&lanop=show_party&party_id=$lan[party_id]\"><b>$lan[keyword] Sponsors</b></a></center><br>";
                $sponsor_query = $db->sql_query("SELECT * FROM nukelan_sponsors");
                $sponsor_num = $db->sql_numrows($sponsor_query);

                while ($row3 =$db->sql_fetchrow($sponsor_query)) {
                        $ifnolans = "AND cid=$row3[id]";
        
                        $ban_result = $db->sql_query("SELECT * FROM nukelan_sponsors_banners WHERE type=1 AND active=1 $ifnolans");

                        while($ban = $db->sql_fetchrow($ban_result)){
                        $bid = $ban['bid'];
                        $alttext = $ban['alttext'];
                        $imageurl = $ban['imageurl'];
                        $imptotal = $ban['imptotal'];
                        $count_url = strlen($imageurl);
                        $image_check = substr($imageurl, $count_url-3);
                        
                        if ($image_check == 'swf') {
                                $size = getimagesize($imageurl);
                                $size_w = $size[0];
                                $size_h = $size[1];
                                if ($size_w > 145) {
                                        $div_x = (145 / $size_w);
                                        $size_w = round($div_x * $size_w, 0);
                                        $size_h = round($div_x * $size_h, 0);
                                }
                                $content .= "<center><object classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=4,0,2,0\" width=\"$size_w\" height=\"$size_h\">";
                                $content .= "<param name=\"movie\" value=\"$imageurl\">";
                                $content .= "<param name=quality value=high>";
                                $content .= "<embed src=\"$imageurl\" quality=high pluginspage=\"http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash\" type=\"application/x-shockwave-flash\" width=\"100%\" height=\"100%\">";
                                $content .= "</embed></object>";
                                $content .= "<br>";
                                $content .= "<a href=\"lansponsors.php?op=click&amp;bid=$bid\" target=\"_blank\">$row3[sponsor_name]</a></center>";
                        } else {
                                $content .= "<center><a href=\"lansponsors.php?op=click&amp;bid=$bid\" target=\"_blank\"><img src=\"$imageurl\" border=\"0\" alt=\"$alttext\" title=\"$alttext\" width=\"$maxwidth\"></a><br>";
                                $content .= "<a href=\"lansponsors.php?op=click&amp;bid=$bid\" target=\"_blank\">$row3[sponsor_name]</a></center><br>";
                                }
                        }
                        $content .= "<br>";
                
                        // update table with new impression info
                        $db->sql_query("UPDATE nukelan_sponsors_banners SET impmade=impmade+1 WHERE bid=$bid");
                        // check impressions total
                        if (($imptotal <= $impmade) AND ($imptotal != 0)) {
                        $db->sql_query("UPDATE nukelan_sponsors_banner SET active='0' WHERE bid='$bid'");
                        }

                }
        }
        else {
        $content = "Unknown Sponsor Mode.";
        }
}
?>
