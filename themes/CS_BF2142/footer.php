<?php
global $n, $db, $vwarmodname, $numnextactions, $numlastactions;
?>
<table width="980" height="90" border="0" cellpadding="0" cellspacing="0" align="center">
	<tr>
		<td rowspan="2"><img src="themes/CS_BF2142/images/ft/footer_01.gif" width="78" height="90" alt=""></td>
		<td colspan="3"><img src="themes/CS_BF2142/images/ft/footer_02.gif" width="819" height="34" alt=""></td>
		<td rowspan="2"><img src="themes/CS_BF2142/images/ft/footer_03.gif" width="83" height="90" alt=""></td>
	</tr>
	<tr>
		<td width="158" background="themes/CS_BF2142/images/ft/footer_04.gif"><?php echo $showlinks; ?></td>
		<td><a href="http://playground-gfx.com"><img src="themes/CS_BF2142/images/ft/footer_05.gif" alt="" width="503" height="56" border="0"></a></td>
		<td width="158" background="themes/CS_BF2142/images/ft/footer_06.gif">
<?php
$numlastactions = "5";
echo "<marquee behavior='scroll' direction='up' height='20' scrollamount='1' scrolldelay='90' onmouseover='this.stop()' onmouseout='this.start()' align='center'>";
include("includes/last.php");
echo "<marquee>";
?>
</td>
	</tr>
</table>