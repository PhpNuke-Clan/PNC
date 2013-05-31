<body>
<?php
global $n, $db, $vwarmodname, $numnextactions, $numlastactions;
$numnextactions = "5";
echo "<table id=\"hdtable\" cellpadding='0' cellspacing='0'>\n
	<tr>\n
		<td id=\"hdrow1col1\" rowspan='5'></td>\n
		<td colspan='3' rowspan='3' valign='top'><img src='themes/CS_BF2142/images/hd/header_02.gif' width='469' height='193' alt='pncimage'></td>\n
		<td colspan='3' rowspan='2'><img src='themes/CS_BF2142/images/hd/header_03.gif' width='273' height='157' alt='pncimage2'></td>\n
		<td colspan='2'><img src='themes/CS_BF2142/images/hd/header_04.gif' width='195' height='42' alt='pncimage3'></td>\n
		<td rowspan='5'><img src='themes/CS_BF2142/images/hd/header_05.gif' width='20' height='240' alt='pncimage4'></td>\n
	</tr>\n
	<tr>\n
		<td id=\"hdrow2col1\"valign='top'>\n
		<table id=\"hdtable2\">\n
		<tr><td><div align='center'><marquee behavior= 'scroll' align= 'center' direction= 'up' height='80' scrollamount= '2' scrolldelay= '90' onmouseover='this.stop()' onmouseout='this.start()'>";
include("includes/next.php");
echo "</marquee></div></td></tr></table></td>\n
		<td><img src='themes/CS_BF2142/images/hd/header_07.gif' width='35' height='113' alt='pncimage5'></td>\n
	</tr>\n
	<tr>\n
		<td id=\"hdrow3col1\" colspan='5'>$theuser</td>\n
	</tr>\n
	<tr>\n
		<td rowspan='2'><img src='themes/CS_BF2142/images/hd/header_09.gif' width='266' height='47' alt='pncimage6'></td>\n
		<td>";
		if(defined('HOME_FILE')){
			echo "<a href='index.php'><img src='themes/CS_BF2142/images/hd/header_10s.gif' alt='pncimage7' width='91' height='17' border='0'></a>";
		} else {
			echo "<a href='index.php'><img src='themes/CS_BF2142/images/hd/header_10.gif' alt='pncimage8' width='91' height='17' border='0'></a>";
		}
echo "</td>\n<td>";
		if($name == "Downloads"){
			echo "<a href='modules.php?name=Downloads'><img src='themes/CS_BF2142/images/hd/header_11s.gif' alt='pncimage9' width='112' height='17' border='0'></a>";
		} else {
			echo "<a href='modules.php?name=Downloads'><img src='themes/CS_BF2142/images/hd/header_11.gif' alt='pncimage10' width='112' height='17' border='0'></a>";
		}
echo "</td>\n<td>";
		if($name == "Forums"){
			echo "<a href='modules.php?name=Forums'><img src='themes/CS_BF2142/images/hd/header_12s.gif' alt='11' width='78' height='17' border='0'></a>";
		} else {
			echo "<a href='modules.php?name=Forums'><img src='themes/CS_BF2142/images/hd/header_12.gif' alt='12' width='78' height='17' border='0'></a>";
		}
echo "</td>\n<td>";
		if($name == "Your_Account"){
			echo "<a href='modules.php?name=Your_Account'><img src='themes/CS_BF2142/images/hd/header_13s.gif' alt='13' width='114' height='17' border='0'></a>";
		} else {
			echo "<a href='modules.php?name=Your_Account'><img src='themes/CS_BF2142/images/hd/header_13.gif' alt='14' width='114' height='17' border='0'></a>";
		}
echo "</td>\n
		<td colspan='3' rowspan='2'><img src='themes/CS_BF2142/images/hd/header_14.gif' width='276' height='47' alt='15'></td>\n
	</tr>\n
	<tr>\n
		<td colspan='4'><img src='themes/CS_BF2142/images/hd/header_15.gif' width='395' height='30' alt='16'></td>\n
	</tr>\n
	<tr>\n
		<td><img src='themes/CS_BF2142/images/hd/spacer.gif' width='23' height='0' alt='17'></td>\n
		<td><img src='themes/CS_BF2142/images/hd/spacer.gif' width='266' height='0' alt='18'></td>\n
		<td><img src='themes/CS_BF2142/images/hd/spacer.gif' width='91' height='0' alt='19'></td>\n
		<td><img src='themes/CS_BF2142/images/hd/spacer.gif' width='112' height='0' alt='20'></td>\n
		<td><img src='themes/CS_BF2142/images/hd/spacer.gif' width='78' height='0' alt='21'></td>\n
		<td><img src='themes/CS_BF2142/images/hd/spacer.gif' width='114' height='0' alt='22'></td>\n
		<td><img src='themes/CS_BF2142/images/hd/spacer.gif' width='81' height='0' alt='23'></td>\n
		<td><img src='themes/CS_BF2142/images/hd/spacer.gif' width='160' height='0' alt='24'></td>\n
		<td><img src='themes/CS_BF2142/images/hd/spacer.gif' width='35' height='0' alt='25'></td>\n
		<td><img src='themes/CS_BF2142/images/hd/spacer.gif' width='20' height='0' alt='26'></td>\n
	</tr>\n
	</table>\n";
?>