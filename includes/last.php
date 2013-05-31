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
global $n, $db, $vwarmodname, $numlastactions;
if(empty($n)){$n="";}
else {$n = intval($n);}
if(empty($numlastactions)){$numlastactions = 5;}
else {$numlastactions = intval($numlastactions);}
$numlastwars=$db->sql_numrows($db->sql_query("SELECT * FROM vwar".$n." WHERE status='1'"));
if($numlastwars>0) {
     $result=$db->sql_query("SELECT vwar".$n.".gameid, vwar".$n.".warid,vwar".$n.".gametypeid,vwar".$n.".matchtypeid,vwar".$n.".resultbylocations,status,dateline,oppnameshort,matchtypename,gametypename,ownnameshort FROM vwar".$n.",vwar".$n."_matchtype,vwar".$n."_gametype,vwar".$n."_opponents,vwar".$n."_settings WHERE vwar".$n.".oppid=vwar".$n."_opponents.oppid AND vwar".$n.".gametypeid=vwar".$n."_gametype.gametypeid AND vwar".$n."_matchtype.matchtypeid=vwar".$n.".matchtypeid AND dateline <= '".time()."' AND status='1' ORDER BY dateline DESC LIMIT 0,$numlastactions");
     while($row=$db->sql_fetchrow($result)) {

           $resultg = $db->sql_query("SELECT gameicon,gamenameshort FROM vwar".$n."_games WHERE gameid = '$row[gameid]'");
                  $rowg=$db->sql_fetchrow($resultg);
                  $icon= filter($rowg["gameicon"]);
                  $gname= filter($rowg["gamenameshort"]);
                         if($icon!="" && file_exists("modules/$vwarmodname/images/gameicons/$icon")){
          $gpic = "<img src=\"modules/$vwarmodname/images/gameicons/$icon\" border=\"0\" alt=\"$gname\" />";
                        }else{  $gpic = "$gname"; }

          echo"<a href=\"modules.php?name=$vwarmodname&file=war&action=details&warid=".intval($row[warid])."\">filter($row[ownnamesort]) vs. filter($row[oppnameshort])</a><br />";
                  echo"$gpic<br />";

          $total[opp]=0;
          $total[own]=0;
          $result2=$db->sql_query("SELECT ownscore,oppscore FROM vwar".$n."_scores WHERE warid='".$row[warid]."'");
          while($scores=$db->sql_fetchrow($result2)) {
               if((int)$row[resultbylocations]==0) {
                    $total[own]=(int)$total[own]+(int)$scores[ownscore];
                    $total[opp]=(int)$total[opp]+(int)$scores[oppscore];
               }elseif((int)$row[resultbylocations]==1) {
                    if((int)$scores[ownscore] < (int)$scores[oppscore]){ $total[opp]=(int)$total[opp]+1;}
                    elseif ((int)$scores[ownscore] > (int)$scores[oppscore]) {$total[own]=(int)$total[own]+1;}
               }
          }
          if((int)$total[own] > (int)$total[opp]){ $matchstatus="<img src=\"modules/$vwarmodname/images/won.gif\">\n";}
          elseif ((int)$total[own] < (int)$total[opp]) {$matchstatus="<img src=\"modules/$vwarmodname/images/lost.gif\">\n";}
          elseif ((int)$total[own] == (int)$total[opp]){ $matchstatus="<img src=\"modules/$vwarmodname/images/draw.gif\">\n";}
          echo"(int)$total[own] : (int)$total[opp]  $matchstatus";
          echo"&raquo;&nbsp;".date("m.d.Y H:i",(int)$row[dateline])."";

                $numcom=$db->sql_numrows($db->sql_query("SELECT * FROM vwar".$n."_comments WHERE frompage = 'war' AND sourceid=$row[warid]"));
                echo"&raquo;&nbsp;<a href=\"modules.php?name=$vwarmodname&file=war&action=details&amp;warid=(int)$row[warid]\">details</a>
                [$numcom&nbsp;<a href=\"modules.php?name=$vwarmodname&file=war&action=comment&amp;warid=(int)$row[warid]\"><img src=\"modules/$vwarmodname/images/comment.gif\" align=\"middle\" border=\"0\" alt=\"\"></a>]<br><br>";

     }

}else{

     echo"No Finished Matches";

}
?>
