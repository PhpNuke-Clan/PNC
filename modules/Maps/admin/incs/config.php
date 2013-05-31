<?php

/***************************************/
/* Maps Manager by gotcha  version 2.0 */
/* Copyright 2006 http://nukecoder.com */
/* You MAY NOT copy in whole or in part*/
/* or redistribute map manager without */
/* written consent from the author.    */
/* Contact and support can be found at */
/* http://nukecoder.com                */
/***************************************/

if ($_POST['update']){
  
  $aus = intval($_POST['aus']);
  $aup = intval($_POST['aup']);
  $agdl = intval($_POST['agdl']);
  $aur = intval($_POST['aur']);
  $ano = intval($_POST['ano']);
  $are = intval($_POST['are']);
  $cimg = htmlentities($_POST['cimg'], ENT_QUOTES);
  $mimg = htmlentities($_POST['mimg'], ENT_QUOTES);
  $mfile = htmlentities($_POST['mfile'], ENT_QUOTES);
  $tmp = htmlentities($_POST['tmp'], ENT_QUOTES);
  $afiles = htmlentities($_POST['afiles'], ENT_QUOTES);
  $mpage = intval($_POST['mpage']);
  $dlim = intval($_POST['dlim']);
  $slim = intval($_POST['slim']);
  $ctw = intval($_POST['ctw']);
  $cth = intval($_POST['cth']);
  $mtw = intval($_POST['mtw']);
  $mth = intval($_POST['mth']);
  $gtw = intval($_POST['gtw']);
  $gth = intval($_POST['gth']);
  
	
	$db->sql_query("UPDATE ".$prefix."_mapconfig SET mval='$aus' WHERE mname='a_submit'");
	$db->sql_query("UPDATE ".$prefix."_mapconfig SET mval='$aup' WHERE mname='a_upload'");
	$db->sql_query("UPDATE ".$prefix."_mapconfig SET mval='$agdl' WHERE mname='a_group'");
	$db->sql_query("UPDATE ".$prefix."_mapconfig SET mval='$aur' WHERE mname='a_rate'");
	$db->sql_query("UPDATE ".$prefix."_mapconfig SET mval='$ano' WHERE mname='a_anon'");
	$db->sql_query("UPDATE ".$prefix."_mapconfig SET mval='$are' WHERE mname='a_review'");
	$db->sql_query("UPDATE ".$prefix."_mapconfig SET mval='$cimg' WHERE mname='c_img'");
	$db->sql_query("UPDATE ".$prefix."_mapconfig SET mval='$mimg' WHERE mname='m_img'");
	$db->sql_query("UPDATE ".$prefix."_mapconfig SET mval='$mfile' WHERE mname='m_file'");
	$db->sql_query("UPDATE ".$prefix."_mapconfig SET mval='$tmp' WHERE mname='temp'");
	$db->sql_query("UPDATE ".$prefix."_mapconfig SET mval='$afiles' WHERE mname='a_ftypes'");
	$db->sql_query("UPDATE ".$prefix."_mapconfig SET mval='$mpage' WHERE mname='m_page'");
	$db->sql_query("UPDATE ".$prefix."_mapconfig SET mval='$dlim' WHERE mname='d_limit'");
	$db->sql_query("UPDATE ".$prefix."_mapconfig SET mval='$slim' WHERE mname='s_limit'");
	$db->sql_query("UPDATE ".$prefix."_mapconfig SET mval='$ctw' WHERE mname='c_thumbw'");
	$db->sql_query("UPDATE ".$prefix."_mapconfig SET mval='$cth' WHERE mname='c_thumbh'");
	$db->sql_query("UPDATE ".$prefix."_mapconfig SET mval='$mtw' WHERE mname='m_thumbw'");
	$db->sql_query("UPDATE ".$prefix."_mapconfig SET mval='$mth' WHERE mname='m_thumbh'");
	$db->sql_query("UPDATE ".$prefix."_mapconfig SET mval='$gtw' WHERE mname='g_thumbw'");
	$db->sql_query("UPDATE ".$prefix."_mapconfig SET mval='$gth' WHERE mname='g_thumbh'");
	
	Header("Location: ".$admin_file.".php?op=mapconfig");
	
}else{
	include("header.php");
	OpenTable();
	echo "<center>[ <a href='".$admin_file.".php?op=mapmain'>"._MAPADMIN."</a> ] - [ <a href='".$admin_file.".php'>"._ADMINMENU."</a> ]</center>";
	CloseTable();
	echo "<br>";
	OpenTable();
	$result = $db->sql_query("SELECT mname, mval FROM ".$prefix."_mapconfig");
	while(list($mname, $mval) = $db->sql_fetchrow($result)){
		$config[$mname] = $mval;
	}
	
	echo "<form action='".$admin_file.".php?op=mapconfig' method='post'>\n"
		."<table width='100%' border='1' cellspacing='1' cellpadding='2'>\n"
		."<tr>\n"
		."<td colspan='2' align='center' bgcolor='$bgcolor2'><font class='title'>"._PERMISSIONS."</font></td>\n"
		."</tr>\n"
		
		."<tr>\n"
		."<td width='65%'>"._ALLOWUSERSUBMIT."</td>\n";
	if ($config['a_submit'] == 1){ $ck1 = "checked"; }else{ $ck2 ="checked"; }
	echo"<td><input name='aus' type='radio' value='1' $ck1> "._YES."<input name='aus' type='radio' value='0' $ck2> "._NO."</td>\n"
		."</tr>\n"
		
		."<tr>\n"
		."<td width='65%'>"._ALLOWUPLOAD."</td>\n";
	if ($config['a_upload'] == 1){ $ck3 = "checked"; }else{ $ck4 ="checked"; }
	echo "<td><input name='aup' type='radio' value='1' $ck3> "._YES."<input name='aup' type='radio' value='0' $ck4> "._NO."</td>\n"
		."</tr>\n"
		
		."<tr>\n"
		."<td width='65%'>"._ALLOWGROUPDL."</td>\n";
	if ($config['a_group'] == 1){ $ck5 = "checked"; }else{ $ck6 ="checked"; }
	echo "<td><input name='agdl' type='radio' value='1' $ck5> "._YES."<input name='agdl' type='radio' value='0' $ck6> "._NO."</td>\n"
		."</tr>\n"
		
		."<tr>\n"
		."<td width='65%'>"._ALLOWRATINGS."</td>\n";
	if ($config['a_rate'] == 1){ $ck7 = "checked"; }else{ $ck8 ="checked"; }
	echo "<td><input name='aur' type='radio' value='1' $ck7> "._YES."<input name='aur' type='radio' value='0' $ck8> "._NO."</td>\n"
		."</tr>\n"
		
		."<tr>\n"
		."<td width='65%'>"._ALLOWANON."</td>\n";
	if ($config['a_anon'] == 1){ $ck9 = "checked"; }else{ $ck10 ="checked"; }
	echo "<td><input name='ano' type='radio' value='1' $ck9> "._YES."<input name='ano' type='radio' value='0' $ck10> "._NO."</td>\n"
		."</tr>\n"
		
		."<tr>\n"
		."<td width='65%'>"._ALLOWREVIEW."</td>\n";
	if ($config['a_review'] == 1){ $ck11 = "checked"; }else{ $ck12 ="checked"; }
	echo "<td><input name='are' type='radio' value='1' $ck11> "._YES."<input name='are' type='radio' value='0' $ck12> "._NO."</td>\n"
		."</tr>\n"
		
		."<tr>\n"
		."<td colspan='2' align='center' bgcolor='$bgcolor2'><font class='title'>"._FILES."</font></td>\n"
		."</tr>\n"
		
		."<tr>\n"
		."<td width='65%'>"._CATIMAGEDIR."</td>\n"
		."<td><input type='text' size='40' name='cimg' value='".$config['c_img']."'></td>\n"
		."</tr>\n"
		
		."<tr>\n"
		."<td width='65%'>"._MAPIMAGEDIR."</td>\n"
		."<td><input type='text' size='40' name='mimg' value='".$config['m_img']."'></td>\n"
		."</tr>\n"
		
		."<tr>\n"
		."<td width='65%'>"._MAPFILEDIR."</td>\n"
		."<td><input type='text' size='40' name='mfile' value='".$config['m_file']."'></td>\n"
		."</tr>\n"
		
		."<tr>\n"
		."<td width='65%'>"._TEMPDIR."</td>\n"
		."<td><input type='text' size='40' name='tmp' value='".$config['temp']."'></td>\n"
		."</tr>\n"
		
		."<tr>\n"
		."<td width='65%'>"._ALLOWEDFILETYPES."</td>\n"
		."<td><input type='text' size='40' name='afiles' value='".$config['a_ftypes']."'></td>\n"
		."</tr>\n"
		
		."<tr>\n"
		."<td colspan='2' align='center' bgcolor='$bgcolor2'><font class='title'>"._MISCOPTIONS."</font></td>\n"
		."</tr>\n"
		
		."<tr>\n"
		."<td width='65%'>"._MAPSPERPAGE."</td>\n"
		."<td><input type='text' size='5' name='mpage' value='".$config['m_page']."'></td>\n"
		."</tr>\n"
		
		."<tr>\n"
		."<td width='65%'>"._DESCLIMIT."</td>\n"
		."<td><input type='text' size='5' name='dlim' value='".$config['d_limit']."'></td>\n"
		."</tr>\n"
		
		."<tr>\n"
		."<td width='65%'>"._SELECTLIMIT."</td>\n"
		."<td><input type='text' size='5' name='slim' value='".$config['s_limit']."'></td>\n"
		."</tr>\n"
		
		."<tr>\n"
		."<td colspan='2' align='center' bgcolor='$bgcolor2'><font class='title'>"._IMAGESIZES."</font></td>\n"
		."</tr>\n"
		
		."<tr>\n"
		."<td width='65%'>"._CATTHUMBW."</td>\n"
		."<td><input type='text' size='5' name='ctw' value='".$config['c_thumbw']."'></td>\n"
		."</tr>\n"
		
		."<tr>\n"
		."<td width='65%'>"._CATTHUMBH."</td>\n"
		."<td><input type='text' size='5' name='cth' value='".$config['c_thumbh']."'></td>\n"
		."</tr>\n"
		
		."<tr>\n"
		."<td width='65%'>"._MAPTHUMBW."</td>\n"
		."<td><input type='text' size='5' name='mtw' value='".$config['m_thumbw']."'></td>\n"
		."</tr>\n"
		
		."<tr>\n"
		."<td width='65%'>"._MAPTHUMBH."</td>\n"
		."<td><input type='text' size='5' name='mth' value='".$config['m_thumbh']."'></td>\n"
		."</tr>\n"
		."<tr>\n"
		."<td width='65%'>"._GENTHUMBW."</td>\n"
		."<td><input type='text' size='5' name='gtw' value='".$config['g_thumbw']."'></td>\n"
		."</tr>\n"
		."<tr>\n"
		."<td width='65%'>"._GENTHUMBH."</td>\n"
		."<td><input type='text' size='5' name='gth' value='".$config['g_thumbh']."'></td>\n"
		."</tr>\n"
		."</table>\n"
		."<center><input type='submit' name='update' value='"._UPDATE."'></center>"
		."</form>\n";
	CloseTable();
	include("footer.php");
}

?>