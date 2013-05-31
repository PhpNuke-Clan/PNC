<script language="javascript" type="text/javascript" src="modules/Forums/bbcode_box/bbcode_box.js"></script>
<form action="{S_POST_ACTION}" method="post" name="post" onsubmit="return checkForm(this)" {S_FORM_ENCTYPE}>
{POST_PREVIEW_BOX}
{ERROR_BOX}
<table width="100%" cellspacing="2" cellpadding="2" border="0">
<tr>
<td class="nav"><a href="{U_INDEX}">{L_INDEX}</a> 
<!-- BEGIN switch_not_privmsg -->
&raquo; <a href="{U_VIEW_FORUM}">{FORUM_NAME}</a>
<!-- END switch_not_privmsg -->
</td>
</tr>
</table>
<table border="0" cellpadding="3" cellspacing="1" width="100%" class="forumline">
<tr>
<th colspan="2">{L_POST_A}</th>
</tr>
<!-- BEGIN switch_username_select -->
<tr>
<td class="row1"><strong>{L_USERNAME}</strong></td>
<td class="row2"><input type="text" class="post" tabindex="1" name="username" size="25" maxlength="25" value="{USERNAME}" /> 
</td>
</tr>
<!-- END switch_username_select -->
<!-- BEGIN switch_privmsg -->
<tr> 
<td class="row1"><strong>{L_USERNAME}</strong></td>
<td class="row2"> <input type="text"  class="post" name="username" maxlength="25" size="25" tabindex="1" value="{USERNAME}" /> 
&nbsp; <input type="submit" name="usersubmit" value="{L_FIND_USERNAME}" class="button" onclick="window.open('{U_SEARCH_USER}', '_phpbbsearch', 'HEIGHT=250,resizable=yes,WIDTH=400');return false;" /> 
</td>
</tr>
<!-- END switch_privmsg -->
<tr>
<td class="row1" width="22%"><strong>{L_SUBJECT}</strong></td>
<td class="row2" width="78%"> <input type="text" name="subject" size="45" maxlength="60" style="width:450px" tabindex="2" class="post" value="{SUBJECT}" /> 
</td>
</tr>
<tr>
<td class="row1" valign="top">
<table width="100%" border="0" cellspacing="0" cellpadding="1">
<tr>
<td><strong>{L_MESSAGE_BODY}</strong></td>
</tr>
<tr>
<td align="center"><br />
<table width="100" border="0" cellspacing="0" cellpadding="5">
<tr align="center">
<td colspan="{S_SMILIES_COLSPAN}" class="gensmall"><strong>{L_EMOTICONS}</strong></td>
</tr>
<!-- BEGIN smilies_row -->
<tr align="center" valign="middle">
<!-- BEGIN smilies_col -->
<td><img src="{smilies_row.smilies_col.SMILEY_IMG}" border="0" onmouseover="this.style.cursor='hand';" onclick="emoticon('{smilies_row.smilies_col.SMILEY_CODE}');" alt="{smilies_row.smilies_col.SMILEY_DESC}" title="{smilies_row.smilies_col.SMILEY_DESC}" /></a></td>
<!-- END smilies_col -->
</tr>
<!-- END smilies_row -->
<!-- BEGIN switch_smilies_extra -->
<tr align="center">
<td colspan="{S_SMILIES_COLSPAN}" class="nav"><a href="{U_MORE_SMILIES}" onclick="window.open('{U_MORE_SMILIES}', '_phpbbsmilies', 'HEIGHT=325,resizable=yes,scrollbars=yes,WIDTH=800');return false;" target="_phpbbsmilies">{L_MORE_SMILIES}</a></td>
</tr>
<!-- END switch_smilies_extra -->
</table>
</td>
</tr>
</table>
</td>
<!--
//====================================================================== |
//==== Start Advanced BBCode Box MOD =================================== |
//==== v5.1.0 ========================================================== |
//====
-->
	<td class="row2" valign="top"><span class="gen"><span class="row1"></span> 
		<table id="posttable" width="100%" border="0" bordercolor="#FFFFFF" style="border-collapse: collapse;" cellspacing="0" cellpadding="0" valign="top">
		  <tr align="left" valign="middle"> 
			<td width="475" valign="center">
				<table cellpadding="3" cellspacing="0" bgcolor="#FFFFFF">
					<tr>
						<td background="modules/Forums/bbcode_box/images/bg.gif" valign="middle"><img src="modules/Forums/bbcode_box/images/dots.gif" style="padding-left: 4px;"></td>
						<td background="modules/Forums/bbcode_box/images/bg.gif">
										<select style="height: 20px;" name="ft" onChange="BBCft('[font=' + this.form.ft.options[this.form.ft.selectedIndex].value + ']', '[/font]');this.selectedIndex=0;" onMouseOver="helpline('ft')">
											<option style="font-weight : bold;" selected="selected">Font type</option>
											<option value="Arial">Default font</option>
											<option style="color:black; background-color: #FFFFFF; font-family: Arial;" value="Arial" class="genmed">Arial</option> 
											<option style="color:black; background-color: #FFFFFF; font-family: Arial Black;" value="Arial Black" class="genmed">Arial Black</option> 
											<option style="color:black; background-color: #FFFFFF; font-family: Century Gothic;" value="Century Gothic" class="genmed">Century Gothic</option>
											<option style="color:black; background-color: #FFFFFF; font-family: Comic Sans MS;" value="Comic Sans MS" class="genmed">Comic Sans MS</option> 
											<option style="color:black; background-color: #FFFFFF; font-family: Courier New;" value="Courier New" class="genmed">Courier New</option>
											<option style="color:black; background-color: #FFFFFF; font-family: Georgia;" value="Georgia" class="genmed">Georgia</option> 
											<option style="color:black; background-color: #FFFFFF; font-family: Lucida Console;"value="Lucida Console">Lucida Console</option>
											<option style="color:black; background-color: #FFFFFF; font-family: Microsoft Sans Serif;" value="Microsoft Sans Serif" class="genmed">Microsoft Sans Serif</option> 
											<option style="color:black; background-color: #FFFFFF; font-family: Symbol;" value="Symbol" class="genmed">Symbol</option> 
											<option style="color:black; background-color: #FFFFFF; font-family: Tahoma;" value="Tahoma" class="genmed">Tahoma</option>
											<option style="color:black; background-color: #FFFFFF; font-family: Trebuchet;" value="Trebuchet" class="genmed">Trebuchet</option> 
											<option style="color:black; background-color: #FFFFFF; font-family: Times New Roman;" value="Times New Roman" class="genmed">Times New Roman</option> 
											<option style="color:black; background-color: #FFFFFF; font-family: Verdana;" value="Verdana" class="genmed">Verdana</option> 
										</select>
										<select style="height: 20px;" name="fs" onChange="BBCfs('[size=' + this.form.fs.options[this.form.fs.selectedIndex].value + ']', '[/size]');this.selectedIndex=0;" onMouseOver="helpline('fs')">
											<option style="font-weight : bold;" selected="selected">Font Size</option>
											<option style="color:black; font-size: 8;" value="8" class="genmed">{L_FONT_TINY}</option>
											<option style="color:black; font-size: 10;" value="10" class="genmed">{L_FONT_SMALL}</option>
											<option style="color:black; font-size: 12;" value="12" class="genmed">{L_FONT_NORMAL}</option>
											<option style="color:black; font-size: 18;" value="18" class="genmed">{L_FONT_LARGE}</option>
											<option style="color:black; font-size: 24;" value="24" class="genmed">{L_FONT_HUGE}</option>
										</select>
										<select style="height: 20px;" name="fc" onChange="BBCfc('[color=' + this.form.fc.options[this.form.fc.selectedIndex].value + ']', '[/color]');this.selectedIndex=0;" onMouseOver="helpline('fc')">
											<option style="font-weight : bold;" selected>Font Color</option>
											<option style="color:black; value="{T_FONTCOLOR1}" value="{T_FONTCOLOR1}">{L_COLOR_DEFAULT}</option>
											<option value="darkred">{L_COLOR_DARK_RED}</option>
											<option style="color:red; background-color: {T_TD_COLOR1}" value="red" class="genmed">{L_COLOR_RED}</option>
											<option style="color:orange; background-color: {T_TD_COLOR1}" value="orange" class="genmed">{L_COLOR_ORANGE}</option>
											<option style="color:brown; background-color: {T_TD_COLOR1}" value="brown" class="genmed">{L_COLOR_BROWN}</option>
											<option style="color:yellow; background-color: {T_TD_COLOR1}" value="yellow" class="genmed">{L_COLOR_YELLOW}</option>
											<option style="color:green; background-color: {T_TD_COLOR1}" value="green" class="genmed">{L_COLOR_GREEN}</option>
											<option style="color:olive; background-color: {T_TD_COLOR1}" value="olive" class="genmed">{L_COLOR_OLIVE}</option>
											<option style="color:cyan; background-color: {T_TD_COLOR1}" value="cyan" class="genmed">{L_COLOR_CYAN}</option>
											<option style="color:blue; background-color: {T_TD_COLOR1}" value="blue" class="genmed">{L_COLOR_BLUE}</option>
											<option style="color:darkblue; background-color: {T_TD_COLOR1}" value="darkblue" class="genmed">{L_COLOR_DARK_BLUE}</option>
											<option style="color:indigo; background-color: {T_TD_COLOR1}" value="indigo" class="genmed">{L_COLOR_INDIGO}</option>
											<option style="color:violet; background-color: {T_TD_COLOR1}" value="violet" class="genmed">{L_COLOR_VIOLET}</option>
											<option style="color:white; background-color: {T_TD_COLOR1}" value="white" class="genmed">{L_COLOR_WHITE}</option>
											<option style="color:black; background-color: {T_TD_COLOR1}" value="black" class="genmed">{L_COLOR_BLACK}</option>
										</select>
						</td>
						<td background="modules/Forums/bbcode_box/images/bg.gif" align="left"><a href="http://hvmdesign.com/" class="gensmall" title="BBCode Box MOD - by Disturbed One - www.HVMDesign.com" target="blank">BBCode Box v5.1.0</a></td>
					</tr>
					<tr height="28">
						<td background="modules/Forums/bbcode_box/images/bg.gif" valign="middle"><img src="modules/Forums/bbcode_box/images/dots.gif" style="padding-left: 4px;"></td>
						<td background="modules/Forums/bbcode_box/images/bg.gif" valign="middle" colspan="2">
							<img border="0" src="modules/Forums/bbcode_box/images/justify.gif" class="postimage" name="justify" type="image" onClick="BBCjustify()" onMouseOver="helpline('justify')" style="border-style: outset; border-width: 1" alt="justify"><img border="0" src="modules/Forums/bbcode_box/images/right.gif" name="right" type="image" onClick="BBCright()" onMouseOver="helpline('right')" class="postimage" alt="right"><img border="0" src="modules/Forums/bbcode_box/images/center.gif" name="center" type="image" onClick="BBCcenter()" onMouseOver="helpline('center')" class="postimage" alt="center"><img border="0" src="modules/Forums/bbcode_box/images/left.gif" name="left" type="image" onClick="BBCleft()" onMouseOver="helpline('left')" class="postimage" alt="left"><img style="padding-left: 5px; padding-right: 5px;" src="modules/Forums/bbcode_box/images/blackdot.gif" width="1" height="100%" border="0" alt=""><img border="0" src="modules/Forums/bbcode_box/images/sup.gif" class="postimage" name="supscript" type="image" onClick="BBCsup()" onMouseOver="helpline('sup')" alt="" /><img border="0" src="modules/Forums/bbcode_box/images/sub.gif" name="subs" class="postimage" type="image" onClick="BBCsub()" onMouseOver="helpline('sub')" alt="" /><img style="padding-left: 5px; padding-right: 5px;" src="modules/Forums/bbcode_box/images/blackdot.gif" width="1" height="100%" border="0" alt=""><img border="0" src="modules/Forums/bbcode_box/images/bold.gif" name="bold" type="image" onClick="BBCbold()" onMouseOver="helpline('b')" class="postimage" alt="bold"><img border="0" src="modules/Forums/bbcode_box/images/italic.gif" name="italic" type="image" onClick="BBCitalic()" onMouseOver="helpline('i')" class="postimage" alt="italic"><img border="0" src="modules/Forums/bbcode_box/images/under.gif" name="under" type="image" onClick="BBCunder()" onMouseOver="helpline('u')" class="postimage" alt="under line"><img border="0" src="modules/Forums/bbcode_box/images/strike.gif" class="postimage" name="strik" type="image" onClick="BBCstrike()" onMouseOver="helpline('strike')" alt="" /><img style="padding-left: 5px; padding-right: 5px;" src="modules/Forums/bbcode_box/images/blackdot.gif" width="1" height="100%" border="0" alt=""><img border="0" src="modules/Forums/bbcode_box/images/fade.gif" name="fade" type="image" onClick="BBCfade()" onMouseOver="helpline('fade')" class="postimage" alt="fade"><img border="0" src="modules/Forums/bbcode_box/images/grad.gif" name="grad" type="image" onClick="BBCgrad()" onMouseOver="helpline('grad')" class="postimage" alt="gradient"><img style="padding-left: 5px; padding-right: 5px;" src="modules/Forums/bbcode_box/images/blackdot.gif" width="1" height="100%" border="0" alt=""><img border="0" src="modules/Forums/bbcode_box/images/rtl.gif" name="dirrtl" type="image" onClick="BBCdir('rtl')" onMouseOver="helpline('rtl')" class="postimage" alt="Right to Left"><img border="0" src="modules/Forums/bbcode_box/images/ltr.gif" name="dirltr" type="image" onClick="BBCdir('ltr')" onMouseOver="helpline('ltr')" class="postimage" alt="Left to Right"><img style="padding-left: 5px; padding-right: 5px;" src="modules/Forums/bbcode_box/images/blackdot.gif" width="1" height="100%" border="0" alt=""><img border="0" src="modules/Forums/bbcode_box/images/marqd.gif" name="marqd" type="image" onClick="BBCmarqd()" onMouseOver="helpline('marqd')" class="postimage" alt="Marque to down"><img border="0" src="modules/Forums/bbcode_box/images/marqu.gif" name="marqu" type="image" onClick="BBCmarqu()" onMouseOver="helpline('marqu')" class="postimage" alt="Marque to up"><img border="0" src="modules/Forums/bbcode_box/images/marql.gif" name="marql" type="image" onClick="BBCmarql()" onMouseOver="helpline('marql')" class="postimage" alt="Marque to left"><img border="0" src="modules/Forums/bbcode_box/images/marqr.gif" name="marqr" type="image" onClick="BBCmarqr()" onMouseOver="helpline('marqr')" class="postimage" alt="Marque to right">
						</td>
					</tr>
					<tr height="28">
						<td background="modules/Forums/bbcode_box/images/bg.gif" valign="middle"><img src="modules/Forums/bbcode_box/images/dots.gif" style="padding-left: 4px;"></td>
						<td background="modules/Forums/bbcode_box/images/bg.gif" valign="middle" colspan="2">
							<img border="0" src="modules/Forums/bbcode_box/images/code.gif" name="code" type="image" onClick="BBCcode()" onMouseOver="helpline('code')" class="postimage" alt="Code"><img border="0" src="modules/Forums/bbcode_box/images/quote.gif" name="quote" type="image" onClick="BBCquote()" onMouseOver="helpline('quote')" class="postimage" alt="Quote"><img border="0" src="modules/Forums/bbcode_box/images/expand.gif" class="postimage" name="expand" type="image" onClick="BBCexpand()" onMouseOver="helpline('expand')" alt="" /><img style="padding-left: 5px; padding-right: 5px;" src="modules/Forums/bbcode_box/images/blackdot.gif" width="1" height="100%" border="0" alt=""><img border="0" src="modules/Forums/bbcode_box/images/url.gif" name="url" type="image" onClick="BBCurl()" onMouseOver="helpline('url')" class="postimage" alt="URL"><img border="0" src="modules/Forums/bbcode_box/images/email.gif" name="email" type="image" onClick="BBCmail()" onMouseOver="helpline('mail')" class="postimage" alt="Email"><img style="padding-left: 5px; padding-right: 5px;" src="modules/Forums/bbcode_box/images/blackdot.gif" width="1" height="20" border="0" alt=""><img border="0" src="modules/Forums/bbcode_box/images/img.gif" name="img" type="image" onClick="BBCimg()" onMouseOver="helpline('img')" class="postimage" alt="Image"><img border="0" src="modules/Forums/bbcode_box/images/flash.gif" name="flash" type="image" onClick="BBCflash()" onMouseOver="helpline('flash')" class="postimage" alt="Flash"><img border="0" src="modules/Forums/bbcode_box/images/video.gif" name="video" type="image" onClick="BBCvideo()" onMouseOver="helpline('video')" class="postimage" alt="Video"><img border="0" src="modules/Forums/bbcode_box/images/sound.gif" name="stream" type="image" onClick="BBCstream()" onMouseOver="helpline('stream')" class="postimage" alt="Stream"><img border="0" src="modules/Forums/bbcode_box/images/googlevid.gif" name="GVideo" type="image" onClick="BBCGVideo()" onMouseOver="helpline('googlevid')" class="postimage" alt="GoogleVid"><img border="0" src="modules/Forums/bbcode_box/images/youtube.gif" name="youtube" type="image" onClick="BBCyoutube()" onMouseOver="helpline('youtube')" class="postimage" alt="Youtube"><img style="padding-left: 5px; padding-right: 5px;" src="modules/Forums/bbcode_box/images/blackdot.gif" width="1" height="100%" border="0" alt=""><img border="0" src="modules/Forums/bbcode_box/images/list.gif" name="listdf" type="image" onClick="BBClist()" onMouseOver="helpline('list')" class="postimage" alt="List" /><img border="0" src="modules/Forums/bbcode_box/images/hr.gif" name="hr" type="image" onClick="BBChr()" onMouseOver="helpline('hr')" class="postimage" alt="H-Line"><img style="padding-left: 5px; padding-right: 5px;" src="modules/Forums/bbcode_box/images/blackdot.gif" width="1" height="100%" border="0" alt=""><img border="0" src="modules/Forums/bbcode_box/images/plain.gif" name="plain" type="image" onClick="BBCplain()" onMouseOver="helpline('plain')" class="postimage" alt="Remove BBcode">
						</td> 
					</tr>
					
		<SCRIPT language=JavaScript 
		src="modules/Forums/color.js">
		</SCRIPT>

              <SCRIPT language=JavaScript>
		var height1 = 10;//define the height of the color bar
		var pas = 28;// define the number of color in the color bar
		var width1=Math.floor(-2/15*pas+6);//define the width of the color bar here automatic ajust for subsilver template.
		var text1=s_help.substring(0,search(s_help,"="));
		var text2=s_help.substring(search(s_help,"]"),search(s_help,"/"));
		</SCRIPT>

              <TR>
                <TD colSpan=12>
                  <TABLE id=ColorPanel cellSpacing=0 cellPadding=0 align=center 
                  border=0>
                    <TBODY>
                    <TR>
                      <TD id=ColorUsed onmouseover="helpline('s')" 
                      onclick="if(this.bgColor.length > 0) insertTag(this.bgColor)" 
                      vAlign=center align=middle BORDER-RIGHT: BORDER-TOP: 
                      BORDER-LEFT: ridge; CURSOR: default; BORDER-BOTTOM: 2px 
                      ridge?>
                        <SCRIPT language=JavaScript>
			document.write('<IMG height='+height1+' src="modules/Forums/templates/subSilver/images/spacer.gif" width=10 border=1></TD>');</SCRIPT>
			<TD width=5>
                        <SCRIPT language=JavaScript>
			document.write('<IMG height='+height1+' src="modules/Forums/templates/subSilver/images/spacer.gif" width=5 border=0></TD>');</SCRIPT>

			<TD id=ColorUsed1 onmouseover="helpline('s')" 
                      onclick="if(this.bgColor.length > 0) insertTag(this.bgColor)"
                      vAlign=center align=middle BORDER-RIGHT: BORDER-TOP: 
                      BORDER-LEFT: ridge; CURSOR: default; BORDER-BOTTOM: 2px 
                      ridge?>
                        <SCRIPT language=JavaScript>
			document.write('<IMG height='+height1+' src="modules/Forums/templates/subSilver/images/spacer.gif" width=10 border=1></TD>');</SCRIPT>

                      <TD width=5>
                        <SCRIPT language=JavaScript>
			document.write('<IMG height='+height1+' src="modules/Forums/templates/subSilver/images/spacer.gif" width=5 border=0></TD>');</SCRIPT>

                        <SCRIPT language=JavaScript>
                      <!--
                         rgb(pas,width1,height1,text1,text2)
                      // -->
                      </SCRIPT>
                      </TD></TR></TBODY></TABLE></TD></TR>
				</table>
<!--
//====
//==== End Advanced BBCode Box MOD ==================================== |
//===================================================================== |
-->

<tr>
<td colspan="9">
<input type="text" name="helpbox" size="45" maxlength="100" style="width:450px; font-size:10px" class="helpline" value="{L_STYLES_TIP}" />
</td>
</tr>
		  <!-- Canned MOD Begin -->
		  <tr>
			<td colspan="9">{S_CANNED_SELECT}</td>
		  </tr>
		  <!-- Canned MOD End -->
<tr>
<td colspan="9">
<textarea name="message" rows="15" cols="35" style="width:450px" tabindex="3" class="post" onselect="storeCaret(this);" onclick="storeCaret(this);" onkeyup="storeCaret(this);">{MESSAGE}</textarea>
</td>
</tr>
</table>
</td>
</tr>
<tr>
<td class="row1" valign="top"><strong>{L_OPTIONS}</strong><br />
<span class="gensmall">{HTML_STATUS}<br />
{BBCODE_STATUS}<br />
{SMILIES_STATUS}</span></td>
<td class="row2"> 
<table cellspacing="0" cellpadding="1" border="0">
<!-- BEGIN switch_html_checkbox -->
<tr>
<td>
<input type="checkbox" name="disable_html" {S_HTML_CHECKED} />
</td>
<td>{L_DISABLE_HTML}</td>
</tr>
<!-- END switch_html_checkbox -->
<!-- BEGIN switch_bbcode_checkbox -->
<tr>
<td>
<input type="checkbox" name="disable_bbcode" {S_BBCODE_CHECKED} />
</td>
<td>{L_DISABLE_BBCODE}</td>
</tr>
<!-- END switch_bbcode_checkbox -->
<!-- BEGIN switch_smilies_checkbox -->
<tr>
<td>
<input type="checkbox" name="disable_smilies" {S_SMILIES_CHECKED} />
</td>
<td>{L_DISABLE_SMILIES}</td>
</tr>
<!-- END switch_smilies_checkbox -->
<!-- BEGIN switch_signature_checkbox -->
<tr>
<td>
<input type="checkbox" name="attach_sig" {S_SIGNATURE_CHECKED} />
</td>
<td>{L_ATTACH_SIGNATURE}</td>
</tr>
<!-- END switch_signature_checkbox -->
<!-- BEGIN switch_notify_checkbox -->
<tr>
<td>
<input type="checkbox" name="notify" {S_NOTIFY_CHECKED} />
</td>
<td>{L_NOTIFY_ON_REPLY}</td>
</tr>
<!-- END switch_notify_checkbox -->
<!-- BEGIN switch_delete_checkbox -->
<tr>
<td>
<input type="checkbox" name="delete" />
</td>
<td>{L_DELETE_POST}</td>
</tr>
<!-- END switch_delete_checkbox -->
<!-- BEGIN switch_lock_topic -->
		  <tr> 
			<td> 
			  <input type="checkbox" name="lock" {S_LOCK_CHECKED} />
			</td>
			<td><span class="gen">{L_LOCK_TOPIC}</span></td>
		  </tr>
		  <!-- END switch_lock_topic -->
		  <!-- BEGIN switch_unlock_topic -->
		  <tr> 
			<td> 
			  <input type="checkbox" name="unlock" {S_UNLOCK_CHECKED} />
			</td>
			<td><span class="gen">{L_UNLOCK_TOPIC}</span></td>
		  </tr>
		  <!-- END switch_unlock_topic -->
<!-- BEGIN switch_type_toggle -->
<tr>
<td></td>
<td><strong>{S_TYPE_TOGGLE}</strong></td>
</tr>
<!-- END switch_type_toggle -->
</table>
</td>
</tr>
{ATTACHBOX}
{POLLBOX}
<tr>
<td class="cat" colspan="2" align="center" height="28">{S_HIDDEN_FORM_FIELDS}
<!-- Begin SpelChek™ code snippet #2 -->
<input type="button" value="SpelChek™" name="SpelChek" class="mainoption" LANGUAGE="javascript" onclick="document.send.edittext.value=''; sendtext()">
<!--  End SpelChek™ code snippet #2  -->
&nbsp;&nbsp;<input type="submit" tabindex="5" name="preview" class="mainoption" value="{L_PREVIEW}" />
&nbsp;&nbsp;<input type="submit" accesskey="s" tabindex="6" name="post" class="mainoption" value="{L_SUBMIT}" />
</td>
</tr>
</table>
</form>
{TOPIC_REVIEW_BOX} 
<table width="100%" cellspacing="2" cellpadding="2" border="0">
<tr>
<td class="nav"><a href="{U_INDEX}">{L_INDEX}</a> 
<!-- BEGIN switch_not_privmsg -->
&raquo; <a href="{U_VIEW_FORUM}">{FORUM_NAME}</a>
<!-- END switch_not_privmsg -->
</td>
</tr>
</table>
<br clear="all" />
<div align="left">{JUMPBOX}</div>
