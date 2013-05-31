<?php

/********************************************************/
/* Hall of Shame                                     	*/
/* By: Troy Moore (Duck@mrc.clanservers.com)			*/
/* http://mrc.clanservers.com                           */
/* Copyright © 2006-2011 by JesStep Enterprises         */
/********************************************************/
/* Hall of Shame                                        */
/* For PHP-Nuke 6.5+                                    */
/* By Troy Moore - http://mrc.clanservers.com        	*/
/********************************************************/


if ( !defined('ADMIN_FILE') ) {
	die("Illegal Admin File Access");
}


$pagetitle = " - "._HoS_HALLOFSHAME.": "._HoS_CONFIG;
@include("header.php");
adminheader(_HoS_HALLOFSHAME.": "._HoS_CONFIG);
$sortarry = array("date_add", "punkname", "punkreason", "punkbannedby");
$sortascarry = array("DESC", "ASC");
echo "<br>\n";
OpenTable();
echo "<table align='center' border='0' cellpadding='2' cellspacing='2'>\n";
echo "<tr><td colspan='2'>\n";
echo "<form method='POST' action='".$admin_file.".php'>\n";
echo "<input type='hidden' name='op' value='HoSConfigure_Save'>\n";
echo "<table align='center' border='0' cellpadding='2' cellspacing='2' width='100%'>\n";
echo "<tr><th colspan='2'><b>"._HoS_GENERALCONFIGS."</b></th></tr>\n";
echo "<tr><td bgcolor='$bgcolor2' align='left' width='40%'><b>"._HoS_DATEFORMAT.":</b></td>\n";
echo "<td width='60%'><input type='text' name='date_format' value=\"".$hos_config['date_format']."\"><br>"._HoS_DATEFORMATNOTE."</td></tr>\n";
echo "<tr><td  bgcolor='$bgcolor2' align='left'><b>"._HoS_PUNKSPERPAGE.":</b></td>\n";
echo "<td><input type='text' name='pperpage' size='8' value=\"".$hos_config['pperpage']."\"><br>"._HoS_PUNKSPERPAGENOTE."</td></tr>\n";
echo "<tr><td  bgcolor='$bgcolor2' align='left'><b>"._HoS_REASONSPERROW.":</b></td>\n";
echo "<td><input type='text' name='perrow' size='8' value=\"".$hos_config['perrow']."\"><br>"._HoS_REASONSNOTE."</td></tr>\n";
echo "<tr><td  bgcolor='$bgcolor2' align='left'><b>"._HoS_MAXSEARCH.":</b></td>\n";
echo "<td><input type='text' name='search' size='8' value=\"".$hos_config['search']."\"><br>"._HoS_MAXSEARCHNOTE."</td></tr>\n";
echo "<tr><td  bgcolor='$bgcolor2' align='left'><b>"._HoS_SORTORDERADMIN.":</b></td>\n";
echo "<td><select name='admsort'>\n";
for ($count=0; $count <=3; $count++){
if ($sortarry[$count]== $hos_config['admsort']) {
$sel1 = " selected";
}
else {$sel1 = "";
}
echo "<option value='$sortarry[$count]'$sel1>".stripslashes($sortarry[$count])."</option>\n";
}
echo "</select><br>"._HoS_SORTORDERADMINNOTE."</td></tr>\n";
echo "<tr><td  bgcolor='$bgcolor2' align='left'><b>"._HoS_RESULTSADMINASCORDESC.":</b></td>\n";
echo "<td><select name='admsortasc'>\n";
for ($count=0; $count <=1; $count++){
if ($sortascarry[$count]== $hos_config['admsortasc']) {
$sel2 = " selected";
}
else {$sel2 = "";
}
echo "<option value='$sortascarry[$count]'$sel2>".stripslashes($sortascarry[$count])."</option>\n";
}
echo "</select><br>"._HoS_RESULTSASCORDESCNOTE."</td></tr>\n";
echo "<tr><td  bgcolor='$bgcolor2' align='left'><b>"._HoS_SORTORDERPUBLIC.":</b></td>\n";
echo "<td><select name='pubsort'>\n";
for ($count=0; $count <=3; $count++){
if ($sortarry[$count]== $hos_config['pubsort']) {
$sel3 = " selected";
}
else {$sel3 = "";
}
echo "<option value='$sortarry[$count]'$sel3>".stripslashes($sortarry[$count])."</option>\n";
}
echo "</select><br>"._HoS_SORTORDERPUBLICNOTE."</td></tr>\n";
echo "<tr><td  bgcolor='$bgcolor2' align='left'><b>"._HoS_RESULTSPUBLICASCORDESC.":</b></td>\n";
echo "<td><select name='pubsortasc'>\n";
for ($count=0; $count <=1; $count++){
if ($sortascarry[$count]== $hos_config['pubsortasc']) {
$sel4 = " selected";
}
else {$sel4 = "";
}
echo "<option value='$sortascarry[$count]'$sel4>".stripslashes($sortascarry[$count])."</option>\n";
}
echo "</select><br>"._HoS_RESULTSASCORDESCNOTE."</td></tr>\n";
echo "<tr><td  bgcolor='$bgcolor2' align='left'><b>"._HoS_RIGHTSIDEBLOCKS.":</b></td>\n";
if ($hos_config['rightblocks'] == "0") {$roff = "checked"; $ron = "";
} else {$ron = "checked"; $roff = "";}

echo "<td><input type='radio' name='rblocks' value='0' ".$roff.">"._HoS_OFF."<input type='radio' name='rblocks' value='1' ".$ron.">"._HoS_ON."</td></tr>\n";
echo "</table><br><hr><br><br>\n";



echo "<table align='center' border='0' cellpadding='2' cellspacing='2' width='100%'>\n";
echo "<tr><th colspan='2'><b>"._HoS_SCREENSHOTCONFIGS."</b></th></tr>\n";
echo "<tr><td  bgcolor='$bgcolor2' width='40%'><b>"._HoS_SCREENSHOTPATH.":</b></td>\n";
echo "<td width='60%'><input type='text' name='punksspath' size='50' value=\"".$hos_config['punksspath']."\"><br>"._HoS_SCREENSHOTPATHNOTE."</td></tr>\n";
echo "<tr><td  bgcolor='$bgcolor2'><b>"._HoS_MAXSCREENSHOTFILESIZE.":</b></td>\n";
echo "<td><input type='text' name='maxss' size='8' value=\"".$hos_config['maxss']."\"><br>"._HoS_SSMAXNOTE."</td></tr>\n";
echo "<tr><td  bgcolor='$bgcolor2'><b>"._HoS_SCREENSHOTEXTALLOW.":</b></td>\n";
echo "<td><input type='text' name='ssextallow' size='40' value=\"".$hos_config['ssextallow']."\"><br>"._HoS_SSEXTNOTE."</td></tr>\n";
echo "<tr><td  bgcolor='$bgcolor2'><b>"._HoS_SCREENSHOTHEIGHT.":</b></td>\n";
echo "<td><input type='text' name='punkssheight' size='8' value=\"".$hos_config['punkssheight']."\"><br>"._HoS_SCREENSHOTDIMNOTE."</td></tr>\n";
echo "<tr><td  bgcolor='$bgcolor2'><b>"._HoS_SCREENSHOTWIDTH.":</b></td>\n";
echo "<td><input type='text' name='punksswidth' size='8' value=\"".$hos_config['punksswidth']."\"><br>"._HoS_SCREENSHOTDIMNOTE."</td></tr>\n";
echo "</table><br><hr><br><br>\n";


echo "<table align='center' border='0' cellpadding='2' cellspacing='2' width='100%'>\n";
echo "<tr><th colspan='2'><b>"._HoS_DEMOCONFIGS."</b></th></tr>\n";
echo "<tr><td  bgcolor='$bgcolor2' width='40%'><b>"._HoS_DEMOPATH.":</b></td>\n";
echo "<td width='60%'><input type='text' name='punkdemopath' size='50' value=\"".$hos_config['punkdemopath']."\"><br>"._HoS_DEMOPATHNOTE."</td></tr>\n";
echo "<tr><td  bgcolor='$bgcolor2'><b>"._HoS_MAXDEMOFILESIZE.":</b></td>\n";
echo "<td><input type='text' name='maxdemo' size='8' value=\"".$hos_config['maxdemo']."\"><br>"._HoS_DEMOMAXNOTE."</td></tr>\n";
echo "<tr><td  bgcolor='$bgcolor2'><b>"._HoS_DEMOEXTALLOW.":</b></td>\n";
echo "<td><input type='text' name='demoextallow' size='40' value=\"".$hos_config['demoextallow']."\"><br>"._HoS_DEMOEXTNOTE."</td></tr>\n";
echo "<tr><td  bgcolor='$bgcolor2'><b>"._HoS_DEMOHEIGHT.":</b></td>\n";
echo "<td><input type='text' name='demoheight' size='8' value=\"".$hos_config['demoheight']."\"><br>"._HoS_DEMODIMNOTE."</td></tr>\n";
echo "<tr><td  bgcolor='$bgcolor2'><b>"._HoS_DEMOWIDTH.":</b></td>\n";
echo "<td><input type='text' name='demowidth' size='8' value=\"".$hos_config['demowidth']."\"><br>"._HoS_DEMODIMNOTE."</td></tr>\n";
echo "</table><br><hr><br><br>\n";


echo "<table align='center' border='0' cellpadding='2' cellspacing='2' width='100%'>\n";
echo "<tr><th colspan='2'><b>"._HoS_MEMBERCONFIGS."</b></th></tr>\n";
echo "<tr><td  bgcolor='$bgcolor2' width='40%'><b>"._HoS_BANNEDBYTABLENAME.":</b></td>\n";
echo "<td width='60%'><input type='text' name='membertable' size='40' value=\"".$hos_config['membertable']."\"><br>"._HoS_BANNEDBYTABLENAMENOTE."</td></tr>\n";
echo "<tr><td  bgcolor='$bgcolor2'><b>"._HoS_BANNEDBYNAMEFIELD.":</b></td>\n";
echo "<td><input type='text' name='membername' size='40' value=\"".$hos_config['membername']."\"><br>"._HoS_BANNEDBYNAMEFIELDNOTE."</td></tr>\n";
echo "<tr><td  bgcolor='$bgcolor2'><b>"._HoS_BANNEDBYIDFIELD.":</b></td>\n";
echo "<td><input type='text' name='mid' size='40' value=\"".$hos_config['mid']."\"><br>"._HoS_BANNEDBYIDFIELDNOTE."</td></tr>\n";
echo "<tr><td  bgcolor='$bgcolor2'><b>"._HoS_BANNEDBYSTATUSFIELD.":</b></td>\n";
echo "<td><input type='text' name='memberstatus' size='40' value=\"".$hos_config['memberstatus']."\"><br>"._HoS_BANNEDBYSTATUSFIELDNOTE."</td></tr>\n";
echo "<tr><td  bgcolor='$bgcolor2'><b>"._HoS_BANNEDBYSTATUSFIELDDIVIDER.":</b></td>\n";
echo "<td><input type='text' name='memberstatusdivider' size='4' value=\"".$hos_config['memberstatusdivider']."\"><br>"._HoS_BANNEDBYSTATUSFIELDDIVIDERNOTE."</td></tr>\n";
echo "<tr><td  bgcolor='$bgcolor2'><b>"._HoS_BANNEDBYSTATUSFIELDOPERATOR.":</b></td>\n";
echo "<td><input type='text' name='memberstatusoperator' size='4' value=\"".$hos_config['memberstatusoperator']."\"><br>"._HoS_BANNEDBYSTATUSFIELDOPERATORNOTE."</td></tr>\n";
echo "<tr><td align='center' colspan='2'></td></tr><tr><td align='center' colspan='2'></td></tr>\n";
echo "<tr><td align='center' colspan='2'><input type='submit' value='"._HoS_SAVESETTINGS."'></td></tr>\n";
echo "</form>\n";
echo "</table>\n";
echo "</tr></td></table>\n";
CloseTable();
@include("footer.php");

?>
