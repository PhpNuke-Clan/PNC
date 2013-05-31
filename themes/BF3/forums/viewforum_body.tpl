<table width="100%" border="0" cellspacing="0" cellpadding="2">
<tr>
<td valign="top"><a class="forumtitle" href="{U_VIEW_FORUM}" title="{FORUM_NAME}">{FORUM_NAME}</a><br />
{PAGINATION}</td>
<td class="gensmall" align="right" valign="bottom">{L_MODERATOR}: {MODERATORS}<br />
{LOGGED_IN_USER_LIST}<br />
<a href="{U_MARK_READ}">{L_MARK_TOPICS_READ}</a></td>
</tr>
</table>
<table width="100%" cellspacing="2" cellpadding="2" border="0">
<tr>
<td><a href="{U_POST_NEW_TOPIC}"><img src="{POST_IMG}" border="0" alt="{L_POST_NEW_TOPIC}" title="{L_POST_NEW_TOPIC}" /></a></td>
<td width="100%">&nbsp;<span class="nav"><a href="{U_INDEX}">{L_INDEX}</a></span> <img src="themes/BF3/forums/images/arrow.gif" border="0" alt="" /> <span class="nav"><a href="{U_VIEW_FORUM}" title="{FORUM_NAME}">{FORUM_NAME}</a></span></td>
</tr>
</table>
<table class="box-table">
	<thead>
		<tr>
			<th scope="col" colspan="2" align="left">&nbsp;{L_TOPICS}&nbsp;</th>
			<th scope="col" width="50" align="center">&nbsp;{L_REPLIES}&nbsp;</th>
			<th scope="col" width="100" align="center">&nbsp;{L_AUTHOR}&nbsp;</th>
			<th scope="col" width="50" align="center">&nbsp;{L_VIEWS}&nbsp;</th>
			<th scope="col" align="center">&nbsp;{L_LASTPOST}&nbsp;</th>
		</tr>
    </thead>
<!-- BEGIN topicrow -->
<!-- BEGIN divider -->
<tr>
   <td class="cat" colspan="6" height="28"><span style="font-weight: bold; font-size: 12px ; letter-spacing: 1px; color : #fff;">{topicrow.divider.L_DIV_HEADERS}</span></td>
</tr>
<!-- END divider -->
<tr>
<td height="34"><a href="{topicrow.U_VIEW_TOPIC}"><img src="{topicrow.TOPIC_FOLDER_IMG}" alt="{topicrow.L_TOPIC_FOLDER_ALT}" title="{topicrow.L_TOPIC_FOLDER_ALT}" border="0" /></a></td>
<td width="100%">{topicrow.NEWEST_POST_IMG}{topicrow.TOPIC_ATTACHMENT_IMG}<!-- span class="topictitle">{topicrow.TOPIC_TYPE}</span --><a href="{topicrow.U_VIEW_TOPIC}" class="topictitle" title="{topicrow.TOPIC_TITLE}">{topicrow.TOPIC_TITLE}</a><br />
{topicrow.GOTO_PAGE}</td>
<td align="center">{topicrow.REPLIES}</td>
<td align="center" valign="middle" nowrap="nowrap">{topicrow.TOPIC_AUTHOR}</td>
<td align="center">{topicrow.VIEWS}</td>
<td align="center" nowrap="nowrap">&nbsp;{topicrow.LAST_POST_TIME}&nbsp;<br />
{topicrow.LAST_POST_AUTHOR} {topicrow.LAST_POST_IMG}</td>
</tr>
<!-- END topicrow -->
<!-- BEGIN switch_no_topics -->
<tr>
<td class="row1" colspan="6" align="center">{L_NO_TOPICS}</td>
</tr>
<!-- END switch_no_topics -->
<tr>
<td class="foot" align="center" colspan="6">
<form method="post" action="{S_POST_DAYS_ACTION}">
<table class="inner" border="0" cellspacing="0" cellpadding="0" align="center">
	<tfoot>
    	<tr>
			<td class="inner foot">{L_DISPLAY_TOPICS}:&nbsp;</td>
			<td class="inner">{S_SELECT_TOPIC_DAYS}&nbsp;&nbsp;</td>
			<td class="inner"><input type="submit" class="catbutton" value="{L_GO}" name="submit" /></td>
		</tr>
    </tfoot>
</table>
</form>
</td>
</tr>
</table>

<table width="100%" cellspacing="2" cellpadding="2" border="0">
<tr>
<td><a href="{U_POST_NEW_TOPIC}"><img src="{POST_IMG}" border="0" alt="{L_POST_NEW_TOPIC}" title="{L_POST_NEW_TOPIC}" /></a></td>
<td width="100%">&nbsp;<span class="nav"><a href="{U_INDEX}">{L_INDEX}</a></span> <img src="themes/BF3/forums/images/arrow.gif" border="0" alt="" /> <span class="nav"><a href="{U_VIEW_FORUM}">{FORUM_NAME}</a></span></td>
</tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="2">
<tr>
<td valign="top">{PAGINATION}<br />
<br />
{JUMPBOX}<br />
</td>
<td align="right" valign="top"><a href="{U_MARK_READ}">{L_MARK_TOPICS_READ}</a><br />
{L_MODERATOR}: {MODERATORS}<br />
{LOGGED_IN_USER_LIST}
</td>
</tr>
</table>
<table width="100%" cellspacing="0" border="0" align="center" cellpadding="0">
<tr>
<td valign="top">
<table border="0" cellspacing="3" cellpadding="0">
<tr>
<td><img src="{FOLDER_NEW_IMG}" alt="{L_NEW_POSTS}" title="{L_NEW_POSTS}"  /></td>
<td>&nbsp;{L_NEW_POSTS}</td>
<td>&nbsp;&nbsp;</td>
<td><img src="{FOLDER_IMG}" alt="{L_NO_NEW_POSTS}" title="{L_NO_NEW_POSTS}"  /></td>
<td>&nbsp;{L_NO_NEW_POSTS}</td>
<td>&nbsp;&nbsp;</td>
<td><img src="{FOLDER_ANNOUNCE_IMG}" alt="{L_ANNOUNCEMENT}" title="{L_ANNOUNCEMENT}"  /></td>
<td>{L_ANNOUNCEMENT}</td>
</tr>
<tr>
<td><img src="{FOLDER_HOT_NEW_IMG}" alt="{L_NEW_POSTS_HOT}" title="{L_NEW_POSTS_HOT}"  /></td>
<td>{L_NEW_POSTS_HOT}</td>
<td>&nbsp;</td>
<td><img src="{FOLDER_HOT_IMG}" alt="{L_NO_NEW_POSTS_HOT}" title="{L_NO_NEW_POSTS_HOT}"  /></td>
<td>{L_NO_NEW_POSTS_HOT}</td>
<td>&nbsp;</td>
<td><img src="{FOLDER_STICKY_IMG}" alt="{L_STICKY}" title="{L_STICKY}"  /></td>
<td>{L_STICKY}</td>
</tr>
<tr>
<td><img src="{FOLDER_LOCKED_NEW_IMG}" alt="{L_NEW_POSTS_LOCKED}" title="{L_NEW_POSTS_LOCKED}"  /></td>
<td>{L_NEW_POSTS_LOCKED}</td>
<td>&nbsp;</td>
<td><img src="{FOLDER_LOCKED_IMG}" alt="{L_NO_NEW_POSTS_LOCKED}" title="{L_NO_NEW_POSTS_LOCKED}"  /></td>
<td>{L_NO_NEW_POSTS_LOCKED}</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>
</table>
</td>
<td align="right" valign="top">{S_AUTH_LIST}</td>
</tr>
</table>
