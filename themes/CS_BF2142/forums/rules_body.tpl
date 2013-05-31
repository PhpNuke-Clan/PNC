<style type="text/css">
<!--
.style1 {color: red}
-->
</style>
<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
	<tr>
		<td align="left" class="nav"><a href="{U_INDEX}" class="nav">{L_INDEX}</a></td>
	</tr>
</table>

<table class="forumline" width="100%" cellspacing="1" cellpadding="3" border="0" align="center">
	<tr>
		<th class="thHead">{L_FAQ_TITLE}</th>
	</tr>
	<tr>
		<td class="row1">
			<!-- BEGIN faq_block_link -->
			<span class="gen"><b>{faq_block_link.BLOCK_TITLE}</b></span><br />
			<!-- BEGIN faq_row_link -->
			<span class="gen"><a href="{faq_block_link.faq_row_link.U_FAQ_LINK}" class="postlink">{faq_block_link.faq_row_link.FAQ_LINK}</a></span><br />
			<!-- END faq_row_link -->
			<br />
			<!-- END faq_block_link -->
		</td>
	</tr>
	<tr>
		<td class="catBottom" height="28"><p><span style="color: blue;"><span style="font-weight: bold;">Welcome to Php Nuke Clan.<br>
		</span></span><span style="color: blue;"><span style="font-weight: bold;">We hope we can help you all the best we can, but there are some rules you have to follow:</span></span> <br>
          <br>
          <br>
          <span style="font-weight: bold;"><span style="font-size: 16px; line-height: normal;"><span style="color: darkblue;">1. Subject </span></span></span><br>
Define your problem  and subject as short but 
clearly as possible. <br> 
Please don't use things like:
"Help, I don't know what to do..." <br>
<br>
<br>
<span style="font-weight: bold;"><span style="font-size: 16px; line-height: normal;"><span style="color: darkblue;">2.1 Questions </span></span> </span> <br>
When posting a question, <span style="font-weight: bold;">ALWAYS</span> mention as much information as possible  which 
can contribute your problem to solve.. <br>
<br>
- Your server php version (4.x or 5.x) <br>
- Which block, module, nuke/pnc version <br>
- When the error arose and what did you do.<br>
- Quote the error <br>
- Your website URL <br>
- etc. <br>
<br>
<br>
<span style="font-weight: bold;"><span style="font-size: 16px; line-height: normal;"><span style="color: darkblue;">2.2 Questions </span></span> </span> <br>
Patience is such a clean matter. <br>
Don't be impatient, everyone get's help as fast as possibly, NOTE: we have private lives too.<br>
<br>
<br>
<span style="font-weight: bold;"><span style="font-size: 16px; line-height: normal;"><span style="color: darkblue;">2.3 Private Messages</span></span></span><br>
Sending private messages to Administrators and Moderators with questions to solve a problem, or to install a module or PNC itself is not appreciated on this site. There is a forum where everyone  can ask questions. Your question is then read moreover by more people, and possibly also answered much faster <br>
<br>
<br>
<span style="font-weight: bold;"><span style="font-size: 16px; line-height: normal;"><span style="color: darkblue;">3. Posting Language </span></span> </span> <br>
Allthough some of us can speak foreign languages, english remains the <strong>MAIN</strong> language on this site. This way more people can help which will solve your prolem much faster. <br>
<br>
<br>
          <span style="font-weight: bold;"><span style="font-size: 16px; line-height: normal;"><span style="color: darkblue;">4. Search function </span></span> </span> <br>
Use this forum as a book of references for your problem or question.. Therefore <span style="font-weight: bold;">ALWAYS</span> use the <span class="style1">searchfunction</span> on this forum.</p>
		  <p><br>
            <span style="font-weight: bold;"><span style="font-size: 16px; line-height: normal;"><span style="color: darkblue;">5. Copyrights</span></span> </span> <br>
Sites without the correct copyright will be 
given no support.. So make sure the copyright notices are visible. <br>
For further information on Php-Nuke the copyright, to see: <a href="http://phpnuke.org/modules.php?name=Commercial_License" target="_blank">http://phpnuke.org/modules.php?name=Commercial_License</a> <br>
And for the GNU/gpl licensie, to see:<a href="http://phpnuke.org/files/gpl.txt" target="_blank">http://phpnuke.org/files/gpl.txt</a> <br>

<br>
<br>
<span style="font-weight: bold;"><span style="font-size: 16px; line-height: normal;"><span style="color: darkblue;">6. <span style="font-weight: bold;"><span style="font-size: 16px; line-height: normal;"><span style="color: darkblue;">Pleasant</span></span></span></span></span> </span> <br>
Please keep this forum as pleasant as can be. The use of unnessacery words can result in a warning and even a ban. <br>
<br>
<br>
<span style="font-weight: bold;"><span style="font-size: 16px; line-height: normal;"><span style="color: darkblue;">7. Illegale stuff </span></span> </span> <br>
Do not use this forum for illegal practices. PHP 
Nuke Clan is not responsible for the contents of the posts. 
PHP Nuke Clan has the right to remove / edit and move topics. Poeple who don't comply will be bannend and their IP will be given to the proper authoroties. <br>
<br>
<br>
<span style="font-weight: bold;"><span style="font-size: 16px; line-height: normal;"><span style="color: darkblue;">8. Stupid questions...? </span></span> </span> <br>
Remember: Stupid questions don't exist, stupid 
answer all the more. </p></td>
	</tr>
</table>

<br clear="all" />

<!-- BEGIN faq_block -->
<table class="forumline" width="100%" cellspacing="1" cellpadding="3" border="0" align="center">
	<tr> 
		<td class="catHead" height="28" align="center"><span class="cattitle">{faq_block.BLOCK_TITLE}</span></td>
	</tr>
	<!-- BEGIN faq_row -->  
	<tr> 
		<td class="{faq_block.faq_row.ROW_CLASS}" align="left" valign="top"><span class="postbody"><a name="{faq_block.faq_row.U_FAQ_ID}"></a><b>{faq_block.faq_row.FAQ_QUESTION}</b></span><br /><span class="postbody">{faq_block.faq_row.FAQ_ANSWER}<br /><a class="postlink" href="#Top">{L_BACK_TO_TOP}</a></span></td>
	</tr>
	<tr>
		<td class="catBottom" height="28">&nbsp;</td>
	</tr>
	<!-- END faq_row -->
</table>

<br clear="all" />
<!-- END faq_block -->

<table width="100%" cellspacing="2" border="0" align="center">
	<tr>
		<td align="left" valign="middle" nowrap="nowrap">{JUMPBOX}</td> 
	</tr>
</table><div align="center"><span class="copyright">© Rules Hack by </span><a class="copyright" href="http://www.dseitz.de">Dwing</a></div>