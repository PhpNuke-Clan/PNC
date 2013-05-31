<script language="javascript" type="text/javascript">
//<![CDATA[
	//
	// Should really check the browser to stop this whining ...
	//
	function select_switch(status)
	{
		for (i = 0; i < document.privmsg_list.length; i++)
		{
			document.privmsg_list.elements[i].checked = status;
		}
	}
//]]>
</script>


<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
<tr>
<td align="center">{INBOX_IMG}<br /></td>

<td align="center">{SENTBOX_IMG}<br /></td>

<td align="center">{OUTBOX_IMG}<br /></td>

<td align="center">{SAVEBOX_IMG}</td>

</tr>
</table>
<br clear="all" />
<form method="post" name="privmsg_list" action="{S_PRIVMSGS_ACTION}">
<table width="100%" cellspacing="0" cellpadding="0" border="0">
<tr>
<td >{POST_PM_IMG}</td>
<td width="100%"></td>
<td align="right" nowrap="nowrap">
<table class="inner" border="0" cellspacing="0" cellpadding="0">
<tr>
<td nowrap="nowrap" class="inner">{L_DISPLAY_MESSAGES}:&nbsp;</td>
<td class="inner"><select name="msgdays">{S_SELECT_MSG_DAYS}</select>&nbsp;</td>
<td class="inner"><input type="submit" value="{L_GO}" name="submit_msgdays" class="catbutton" /></td>
</tr>
</table>
</td>
</tr>
</table>
<table class="box-table" border="0" cellpadding="3" cellspacing="1" width="100%">
<tr>
<th>&nbsp;{L_FLAG}&nbsp;</th>
<th width="55%">&nbsp;{L_SUBJECT}&nbsp;</th>
<th width="20%">&nbsp;{L_FROM_OR_TO}&nbsp;</th>
<th width="15%">&nbsp;{L_DATE}&nbsp;</th>
<th width="5%">&nbsp;{L_MARK}&nbsp;</th>
</tr>
<!-- BEGIN listrow -->
<tr>
<td align="center" height="30"><a href="{listrow.U_READ}"><img src="{listrow.PRIVMSG_FOLDER_IMG}" alt="{listrow.L_PRIVMSG_FOLDER_ALT}" title="{listrow.L_PRIVMSG_FOLDER_ALT}" border="0" /></a></td>
<td>{listrow.PRIVMSG_ATTACHMENTS_IMG}&nbsp;<a href="{listrow.U_READ}" class="topictitle">{listrow.SUBJECT}</a></td>
<td width="20%" align="center">&nbsp;<a href="{listrow.U_FROM_USER_PROFILE}" class="postdetails">{listrow.FROM}</a></td>
<td width="15%" align="center"><span class="postdetails">{listrow.DATE}</span></td>
<td width="5%" align="center"><span class="postdetails">
<input type="checkbox" name="mark[]2" value="{listrow.S_MARK_ID}" />
</span></td>
</tr>
<!-- END listrow -->
<!-- BEGIN switch_no_messages -->
<tr>
<td colspan="5" align="center"><span class="genbold">{L_NO_MESSAGES}</span></td>
</tr>
<!-- END switch_no_messages -->
<tr>
<td class="cat" colspan="5" align="right"> {S_HIDDEN_FIELDS}
<input type="submit" name="save" value="{L_SAVE_MARKED}" class="mainoption" />&nbsp;
<input type="submit" name="delete" value="{L_DELETE_MARKED}" class="button" />	&nbsp;
<input type="submit" name="deleteall" value="{L_DELETE_ALL}" class="button" />
</td>
</tr>
</table>
<table width="100%" cellspacing="2" border="0" cellpadding="2">
<tr>
<td >{POST_PM_IMG}</td>
<td class="inner" width="100%"></td>
<td class="inner" align="right" valign="top" nowrap="nowrap"><strong>
<!-- BEGIN switch_box_size_notice -->
{BOX_SIZE_STATUS} ::
<!-- END switch_box_size_notice -->
<a href="javascript:select_switch(true);">{L_MARK_ALL}</a> :: <a href="javascript:select_switch(false);">{L_UNMARK_ALL}</a></strong></td>
</tr>
<tr>
<td colspan="3" class="inner">{PAGINATION}</td>
</tr>
</table>
</form>
<br clear="all" />
<div align="left">{JUMPBOX}</div>
