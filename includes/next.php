<?php
/************************************************************************/
/* By XenoMorpH ¤TÐI¤ (aarvuijk@hotmail.com) AND CrazyCrack
/* http://phpnuke-clan.net TEAM
/*
/*
/************************************************************************/
if ( !defined('NUKE_FILE') )
{
        die("You can't access this file directly...");
}
include_once("mainfile.php");
global $n, $db, $vwarmodname, $numnextactions;
if(empty($n)){$n="";}
else {$n = intval($n);}
if(empty($numnextactions)){$numnextactions = 5;}
else {$numnextactions = intval($numnextactions);}
$numnextwars=$db->sql_numrows($db->sql_query("SELECT * FROM vwar".$n." WHERE status='0' AND dateline > '".time()."'"));
if($numnextwars>0) {
   $result=$db->sql_query("SELECT vwar".$n.".gameid, vwar".$n.".gametypeid,vwar".$n.".matchtypeid,status,dateline,oppnameshort,matchtypename,gametypename,ownnameshort,warid FROM vwar".$n.",vwar".$n."_matchtype,vwar".$n."_gametype,vwar".$n."_opponents,vwar".$n."_settings WHERE vwar".$n.".oppid=vwar".$n."_opponents.oppid AND vwar".$n.".gametypeid=vwar".$n."_gametype.gametypeid AND vwar".$n."_matchtype.matchtypeid=vwar".$n.".matchtypeid AND status='0' AND dateline > '".time()."' ORDER BY dateline ASC LIMIT 0,$numnextactions");
   while(list($gameid, $gametypeid,$matchtypeid,$status,$dateline,$oppname,$matchtype,$gametype,$ownname,$warid)=$db->sql_fetchrow($result)) {
   $gameid = intval($gameid);
   $gametypeid = intval($gametypeid);
   $matchtypeid = intval($matchtypeid);
   $status = intval($status);
   $dateline = intval($dateline);
   $warid = intval($warid);
   $oppname = filter($oppname);
   $matchtype = filter($matchtype);
   $gametype = filter($gametype);
   $ownname = filter($ownname);
                         $resultg = $db->sql_query("SELECT gameicon,gamenameshort FROM vwar".$n."_games WHERE gameid = '$gameid'");
                  $rowg=$db->sql_fetchrow($resultg);
                  $icon= filter($rowg["gameicon"]);
                  $gname= filter($rowg["gamenameshort"]);
                         if($icon!="" && file_exists("modules/$vwarmodname/images/gameicons/$icon")){
          $gpic = "<img src=\"modules/$vwarmodname/images/gameicons/$icon\" border=\"0\">";
                        }else{  $gpic = "$gname: &nbsp;"; }
             echo"<a href=\"modules.php?name=$vwarmodname&amp;file=war&amp;action=nextaction&amp;formgame=#$warid\">$ownname vs. $oppname</a><br />";
             echo"$gpic<br />";
                         echo"".date("m-d-Y H:i",$dateline)."<br />";
             echo"$matchtype<br />";
             echo"$gametype<br><br>";
       }
  }else{

          echo"No Upcoming Actions";
     }
         ?>
