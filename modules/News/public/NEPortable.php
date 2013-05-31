<?php

/********************************************************/
/* NSN News                                             */
/* By: NukeScripts Network (webmaster@nukescripts.net)  */
/* http://www.nukescripts.net                           */
/* Copyright © 2000-2005 by NukeScripts Network         */
/********************************************************/
/* Built with: FPDF (version 1.5)                       */
/* Copyright (C) 2002 by Olivier PLATHEY                */
/* http://atthat.com/                                   */
/********************************************************/
/* Based on: Threaded Discussion                        */
/* Copyright (C) 2000  Thatware Development Team        */
/* http://atthat.com/                                   */
/********************************************************/

if(!defined('NSNNE_PUBLIC')) { die("Illegal File Access Detected!!"); }
if(!isset($sid)) { header("Location: $nukeurl"); }
require_once("mainfile.php");

function PrintPage($sid) {
  global $site_logo, $nukeurl, $sitename, $datetime, $prefix, $db, $module_name, $module_link;
  $sid = intval($sid);
  $result = $db->sql_query("SELECT `title`, `time`, `hometext`, `bodytext`, `topic`, `notes` FROM `".$prefix."_stories` WHERE `sid`='$sid'");
  list($title, $time, $hometext, $bodytext, $topic, $notes) = $db->sql_fetchrow($result);
  $db->sql_freeresult($result);
  $result2 = $db->sql_query("SELECT `topictext` FROM `".$prefix."_topics` WHERE `topicid`='$topic'");
  list($topictext) = $db->sql_fetchrow($result2);
  $db->sql_freeresult($result2);
  //formatTimestamp($time);
  $timedate = strtotime($time);
  $datetime = strftime(_NE_DATESTRING, $timedate);
  $html = ""._NE_DATE.": ".$datetime."<br>"._TOPIC.": ".$topictext."<br><br><b>".$title."</b><br><br>".$hometext;
  if(!empty($bodytext)){ $html .= "<br><br>".$bodytext; }
  if(!empty($notes)){ $html .= "<br><br>".$notes; }
  $html .= "<br><br><br>"._NE_COMESFROM." ".$sitename.":<br><a href=\"$nukeurl\">".$nukeurl."</a><br><br>"._NE_THEURL."<br><a href=\"$nukeurl/".$module_link."op=NEArticle&sid=$sid\">$nukeurl/".$module_link."op=NEArticle&sid=$sid</a> ";
  define("FPDF_FONTPATH","modules/".$module_name."/fpdf/font/");
  require_once("modules/".$module_name."/fpdf/fpdf.php");

  class PDF extends FPDF {
    var $B;
    var $I;
    var $U;
    var $HREF;

    function PDF($orientation='P',$unit='mm',$format='A4') {
      //Call parent constructor
      $this->FPDF($orientation,$unit,$format);
      //Initialization
      $this->B=0;
      $this->I=0;
      $this->U=0;
      $this->HREF='';
    }

function WriteHTML($html) {
  //HTML parser
  $html=str_replace("\n",' ',$html);
  $a=preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE);
  foreach($a as $i=>$e) {
    if($i%2==0) {
      //Text
      if($this->HREF)
        $this->PutLink($this->HREF,$e);
      else
        $this->Write(5,$e);
    } else {
      //Tag
      if($e{0}=='/')
        $this->CloseTag(strtoupper(substr($e,1)));
      else
      {
        //Extract properties
        $a2=split(' ',$e);
        $tag=strtoupper(array_shift($a2));
        $prop=array();
        foreach($a2 as $v)
          if(ereg('^([^=]*)=["\']?([^"\']*)["\']?$',$v,$a3))
            $prop[strtoupper($a3[1])]=$a3[2];
        $this->OpenTag($tag,$prop);
      }
    }
  }
}

    function OpenTag($tag,$prop) {
      //Opening tag
      if($tag=='B' or $tag=='I' or $tag=='U')
        $this->SetStyle($tag,true);
      if($tag=='A')
        $this->HREF=$prop['HREF'];
      if($tag=='BR')
        $this->Ln(5);
    }

    function CloseTag($tag) {
      //Closing tag
      if($tag=='B' or $tag=='I' or $tag=='U')
        $this->SetStyle($tag,false);
      if($tag=='A')
        $this->HREF='';
    }

    function SetStyle($tag,$enable) {
      //Modify style and select corresponding font
      $this->$tag+=($enable ? 1 : -1);
      $style='';
      foreach(array('B','I','U') as $s)
        if($this->$s>0)
          $style.=$s;
      $this->SetFont('',$style);
    }

    function PutLink($URL,$txt) {
      //Put a hyperlink
      $this->SetTextColor(0,0,255);
      $this->SetStyle('U',true);
      $this->Write(5,$txt,$URL);
      $this->SetStyle('U',false);
      $this->SetTextColor(0);
    }

    function Footer() {
      $printpdftime = strftime(_NE_DATESTRING);
      //Position at 1.5 cm from bottom
      $this->SetY(-15);
      //Arial italic 8
      $this->SetFont('Arial','I',10);
      //Text color in gray
      $this->SetTextColor(128);
      //Page number
      $this->Cell(0,10,_NE_PAGE." ".$this->PageNo() ." "._NE_OF." {nb} "._NE_ON." ".$printpdftime."." ,0,0,"C");
    }
  }

  $pdf=new PDF();
  $pdf->Open();
  $pdf->SetTitle($title);
  $pdf->SetAuthor($nukeurl);
  $pdf->SetMargins(20,20);
  $pdf->AddPage();
  $pdf->SetFont('Arial','',20);
  $link=$pdf->AddLink();
  $pdf->SetLink($link);
  $pdf->SetFontSize(14);
  $pdf->WriteHTML($html);
  $pdf->AliasNbPages();
  $pdf->Output();
}

PrintPage($sid);

?>