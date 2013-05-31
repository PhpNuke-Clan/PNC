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

function thumb_img($mapimage, $mkthumb){
	global $db, $prefix, $admin_file, $module_name, $mapimagedir;
	$cr1 = $db->sql_query("SELECT mval FROM ".$prefix."_mapconfig where mname='g_thumbw'");
		list($thumbwidth) = $db->sql_fetchrow($cr1);
	$cr2 = $db->sql_query("SELECT mval FROM ".$prefix."_mapconfig where mname='g_thumbh'");
		list($thumbheight) = $db->sql_fetchrow($cr2);
	if ($mkthumb){
		include("header.php");
		OpenTable();
		echo "<center>"._THUMBSGEN."<br>";
		$handle = opendir($mapimagedir);
		while ($file = readdir($handle)){
			if ($file != "." && $file != ".."){
				if (strrpos($file, ".")){
					$tlist .= "$file ";
				}
			}
		}
		closedir($handle);
		$tlist = explode(" ", $tlist);
		sort($tlist);
		for ($i = 0; $i < sizeof($tlist); $i++){
			if($tlist[$i] != "") {
				if (!file_exists($mapimagedir."/thumb/".$tlist[$i])){
					$len = strlen($tlist[$i]);
					$pos = strpos($tlist[$i], ".");
					$type = strtolower(substr($tlist[$i], $pos + 1, $len));
					if ( $type == "jpeg" || $type == "jpg")
					{
						thumb_jpeg($tlist[$i], $thumbwidth, $thumbheight, $mapimagedir, $mapimagedir."/thumb");
					}
					else if($type == "png")
					{
						thumb_png($tlist[$i], $thumbwidth, $thumbheight, $mapimagedir, $mapimagedir."/thumb");
					}
					else if($type == "gif")
					{
						thumb_gif($tlist[$i], $thumbwidth, $thumbheight, $mapimagedir, $mapimagedir."/thumb");
					}
					echo "-&raquo; $tlist[$i]<br>";
				}
			}
		}
		echo "[ <a href='".$admin_file.".php?op=mapmain'>"._MAPADMIN."</a> ]</center>";
		CloseTable();
		include("footer.php");
	}else{
		$len = strlen($mapimage);
		$pos = strpos($mapimage, ".");
		$type = strtolower(substr($mapimage, $pos + 1, $len));
		if ( $type == "jpeg" || $type == "jpg")
		{
			thumb_jpeg($tlist[$i], $thumbwidth, $thumbheight, $mapimagedir, $mapimagedir."/thumb");
		}
		else if($type == "png")
		{
			thumb_png($tlist[$i], $thumbwidth, $thumbheight, $mapimagedir, $mapimagedir."/thumb");
		}
		else if($type == "gif")
		{
			thumb_gif($tlist[$i], $thumbwidth, $thumbheight, $mapimagedir, $mapimagedir."/thumb");
		}
		else
		{
			echo _TYPENOTSUP."<br> -&raquo; $mapimage<br>";
		}
		if (file_exists($mapimagedir."/thumb".$mapimage)){
			echo _THUMBSGEN." -&raquo; $mapimage<br>";
		}
	}

}


function thumb_jpeg($mapimage, $thumbwidth, $thumbheight, $spath, $dpath){ 
   $destimg = ImageCreateTrueColor($thumbwidth, $thumbheight); 
   $srcimg = ImageCreateFromJPEG($spath."/".$mapimage);
   if (function_exists('imagecopyresampled'))
   {
	   ImageCopyResampled($destimg, $srcimg, 0, 0, 0, 0, $thumbwidth, $thumbheight, ImageSX($srcimg), ImageSY($srcimg));
   }
   else
   {
	   ImageCopyResized($destimg, $srcimg, 0, 0, 0, 0, $thumbwidth, $thumbheight, ImageSX($srcimg), ImageSY($srcimg));
   }
   ImageJPEG($destimg, $dpath."/".$mapimage); 
} 

function thumb_png($mapimage, $thumbwidth, $thumbheight, $spath, $dpath){ 
   $destimg = ImageCreateTrueColor($thumbwidth, $thumbheight); 
   $srcimg = ImageCreateFromPNG($spath."/".$mapimage); 
   if (function_exists('imagecopyresampled'))
   {
	   ImageCopyResampled($destimg, $srcimg, 0, 0, 0, 0, $thumbwidth, $thumbheight, ImageSX($srcimg), ImageSY($srcimg));
   }
   else
   {
	   ImageCopyResized($destimg, $srcimg, 0, 0, 0, 0, $thumbwidth, $thumbheight, ImageSX($srcimg), ImageSY($srcimg));
   }
   ImagePNG($destimg, $dpath."/".$mapimage);
}

function thumb_gif($mapimage, $thumbwidth, $thumbheight, $spath, $dpath){ 
   $destimg = ImageCreateTrueColor($thumbwidth, $thumbheight); 
   $srcimg = ImageCreateFromGIF($spath."/".$mapimage); 
   if (function_exists('imagecopyresampled'))
   {
	   ImageCopyResampled($destimg, $srcimg, 0, 0, 0, 0, $thumbwidth, $thumbheight, ImageSX($srcimg), ImageSY($srcimg));
   }
   else
   {
	   ImageCopyResized($destimg, $srcimg, 0, 0, 0, 0, $thumbwidth, $thumbheight, ImageSX($srcimg), ImageSY($srcimg));
   }
   ImageGIF($destimg, $dpath."/".$mapimage); 
} 

?>