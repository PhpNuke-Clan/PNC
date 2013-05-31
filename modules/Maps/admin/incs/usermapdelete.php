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

include("header.php");
OpenTable();
echo "<center>";

$rid = intval($_POST['rid']);

if ($_POST['delete']){
  $sql = "SELECT rimage, rmapfile FROM ".$prefix."_maptemp WHERE rid='$rid'";
  $result = $db->sql_query($sql);
  $row = $db->sql_fetchrow($result);
  
	//if (file_exists($tempdir."/".$rimage)){// not needed..doesn't work like one would think
		@unlink($tempdir."/".$row['rimage']);
	//}
	//if (file_exists($rmapfile)){// not needed..doesn't work like one would think
		@unlink($tempdir."/".$row['rmapfile']);
	//}
	$result = $db->sql_query("DELETE FROM ".$prefix."_maptemp WHERE rid='$rid'");
	if ($result){
		echo _MAPDELETED."<br><br> [ <a href='".$admin_file.".php?op=mapmain'>"._MAPADMIN."</a> ] ";
	}else{
		echo _MAPNOTDELETED."<br><br> [ <a href='".$admin_file.".php?op=mapmain'>"._MAPADMIN."</a> ] ";
	}

}else{
	
	echo _AREYOUSURE." "._MAP." ?<br><br>"
		."<form action='".$admin_file.".php' method='post'>"
		."<input type='hidden' name='rid' value='$rid'>"
		."<input type='hidden' name='op' value='delusermap'>"
		."<input type='submit' name='delete' value='"._DELETE."'>"
		."</form><br> [ <a href='".$admin_file.".php?op=mapmain'>"._MAPADMIN."</a> ] ";
}

echo "</center>";
CloseTable();
include("footer.php");
?>