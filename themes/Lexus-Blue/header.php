<script language="JavaScript" type="text/JavaScript">
<!--
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
//-->
</script>
<?php

global $n, $db, $vwarmodname, $numnextactions, $numlastactions;

echo"<center>"
  . ""
  . "<TABLE WIDTH=977 BORDER=0 CELLPADDING=0 CELLSPACING=0>"
  . "   <TR>"
  . "           <TD COLSPAN=11>"
  . "                   <IMG SRC=\"themes/Lexus-Blue/images/header/header_01.gif\" WIDTH=977 HEIGHT=22 ALT=\"\"></TD>"
  . "           <TD>"
  . "                   <IMG SRC=\"themes/Lexus-Blue/images/header/spacer.gif\" WIDTH=1 HEIGHT=22 ALT=\"\"></TD>"
  . "   </TR>"
  . "   <TR>"
  . "           <TD COLSPAN=6 ROWSPAN=2>"
  . "                   <IMG SRC=\"themes/Lexus-Blue/images/header/header_02.gif\" WIDTH=578 HEIGHT=95 ALT=\"\"></TD>"
  . "           <TD ROWSPAN=4>"
  . "                   <IMG SRC=\"themes/Lexus-Blue/images/header/header_03.gif\" WIDTH=90 HEIGHT=126 ALT=\"\"></TD>"
  . "           <TD COLSPAN=4>"
  . "                   <IMG SRC=\"themes/Lexus-Blue/images/header/header_04.gif\" WIDTH=309 HEIGHT=20 ALT=\"\"></TD>"
  . "           <TD>"
  . "                   <IMG SRC=\"themes/Lexus-Blue/images/header/spacer.gif\" WIDTH=1 HEIGHT=20 ALT=\"\"></TD>"
  . "   </TR>"
  . "   <TR>"
  . "           <TD width=\"138\" height=\"89\" ROWSPAN=2 nowrap bgcolor=\"#393B38\" align=\"center\">"
  . " <A name= \"scrollingCode\"></A>"
  . " <MARQUEE behavior= \"scroll\" align= \"center\" direction= \"up\" height=\"89\" scrollamount= \"2\" scrolldelay= \"25\" onmouseover='this.stop()'                         onmouseout='this.start()'>";
  $numnextactions = "5";
include("includes/next.php");
  echo" </MARQUEE>";
  echo "</TD>"
  . "           <TD ROWSPAN=2>"
  . "                   <IMG SRC=\"themes/Lexus-Blue/images/header/header_06.gif\" WIDTH=18 HEIGHT=89 ALT=\"\"></TD>"
  . "           <TD width=\"139\" height=\"89\" ROWSPAN=2 nowrap bgcolor=\"#393B38\" align=\"center\">"
  . " <A name= \"scrollingCode\"></A>"
  . " <MARQUEE behavior= \"scroll\" align= \"center\" direction= \"up\" height=\"89\" scrollamount= \"2\" scrolldelay= \"25\" onmouseover='this.stop()'                         onmouseout='this.start()'>";
  $numlastactions =        "5";
include("includes/last.php");
  echo" </MARQUEE>";
 echo"</TD>"
  . "           <TD ROWSPAN=2>"
  . "                   <IMG SRC=\"themes/Lexus-Blue/images/header/header_08.gif\" WIDTH=14 HEIGHT=89 ALT=\"\"></TD>"
  . "           <TD>"
  . "                   <IMG SRC=\"themes/Lexus-Blue/images/header/spacer.gif\" WIDTH=1 HEIGHT=75 ALT=\"\"></TD>"
  . "   </TR>"
  . "   <TR>"
  . "           <TD ROWSPAN=2>"
  . "                   <IMG SRC=\"themes/Lexus-Blue/images/header/header_09.gif\" WIDTH=3 HEIGHT=31 ALT=\"\"></TD>"
  . "           <TD ROWSPAN=2><a onmouseover=\"MM_swapImage('home','','themes/Lexus-Blue/images/header/header_over_10.gif',1)\" onmouseout=\"MM_swapImgRestore()\" href=\"index.php\">"
  . "                                    <img src=\"themes/Lexus-Blue/images/header/header_10.gif\" border=\"0\" name=\"home\" oSrc=\"themes/Lexus-Blue/images/header/header_10.gif\" width=\"115\" height=\"31\"></a></TD>"
  . "           <TD ROWSPAN=2><a href=\"modules.php?name=Forums\" onMouseOut=\"MM_swapImgRestore()\" onMouseOver=\"MM_swapImage('forums','','themes/Lexus-Blue/images/header/header_over_11.gif',1)\"><img src=\"themes/Lexus-Blue/images/header/header_11.gif\" name=\"forums\" width=\"115\" height=\"31\" border=\"0\"></a></TD>"
  . "           <TD ROWSPAN=2><a href=\"modules.php?name=Downloads\" onMouseOut=\"MM_swapImgRestore()\" onMouseOver=\"MM_swapImage('downloads','','themes/Lexus-Blue/images/header/header_over_12.gif',1)\"><img src=\"themes/Lexus-Blue/images/header/header_12.gif\" name=\"downloads\" width=\"115\" height=\"31\" border=\"0\"></a></TD>"
  . "           <TD ROWSPAN=2><a href=\"modules.php?name=vwar&file=war\" onMouseOut=\"MM_swapImgRestore()\" onMouseOver=\"MM_swapImage('vwar','','themes/Lexus-Blue/images/header/header_over_13.gif',1)\"><img src=\"themes/Lexus-Blue/images/header/header_13.gif\" name=\"vwar\" width=\"115\" height=\"31\" border=\"0\"></a></TD>"
  . "           <TD ROWSPAN=2><a href=\"modules.php?name=Your_Account\" onMouseOut=\"MM_swapImgRestore()\" onMouseOver=\"MM_swapImage('account','','themes/Lexus-Blue/images/header/header_over_14.gif',1)\"><img src=\"themes/Lexus-Blue/images/header/header_14.gif\" name=\"account\" width=\"115\" height=\"31\" border=\"0\"></a></TD>"
  . "           <TD>"
  . "                   <IMG SRC=\"themes/Lexus-Blue/images/header/spacer.gif\" WIDTH=1 HEIGHT=14 ALT=\"\"></TD>"
  . "   </TR>"
  . "   <TR>"
  . "           <TD COLSPAN=4>"
  . "                   <IMG SRC=\"themes/Lexus-Blue/images/header/header_15.gif\" WIDTH=309 HEIGHT=17 ALT=\"\"></TD>"
  . "           <TD>"
  . "                   <IMG SRC=\"themes/Lexus-Blue/images/header/spacer.gif\" WIDTH=1 HEIGHT=17 ALT=\"\"></TD>"
  . "   </TR>"
  . "   <TR>"
  . "           <TD COLSPAN=11><IMG SRC=\"themes/Lexus-Blue/images/header/header_16.gif\" WIDTH=977 HEIGHT=24 ALT=\"\"></TD>"
  . "           <TD>"
  . "                   <IMG SRC=\"themes/Lexus-Blue/images/header/spacer.gif\" WIDTH=1 HEIGHT=24 ALT=\"\"></TD>"
  . "   </TR>"
  . "</TABLE>"
  . ""
  . "  </center>"
 ."";

?>
