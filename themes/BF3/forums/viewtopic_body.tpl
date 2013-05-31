<table width="100%" border="0" cellspacing="0" cellpadding="2">
<tr>
<td valign="top"><a class="forumtitle" href="{U_VIEW_TOPIC}" title="{TOPIC_TITLE}">{TOPIC_TITLE}</a><br />
{PAGINATION}</td>
<td class="gensmall" align="right" valign="bottom"><a href="{U_VIEW_NEWER_TOPIC}">{L_VIEW_NEXT_TOPIC}</a><br />
<a href="{U_VIEW_OLDER_TOPIC}">{L_VIEW_PREVIOUS_TOPIC}</a><br />
<strong>{S_WATCH_TOPIC}</strong></td>
</tr>
</table>
<table width="100%" cellspacing="2" cellpadding="2" border="0">
<tr>
<td nowrap="nowrap" class="inner"><a href="{U_POST_NEW_TOPIC}"><img src="{POST_IMG}" border="0" alt="{L_POST_NEW_TOPIC}" title="{L_POST_NEW_TOPIC}"  /></a>&nbsp;&nbsp;&nbsp;<a href="{U_POST_REPLY_TOPIC}"><img src="{REPLY_IMG}" border="0" alt="{L_POST_REPLY_TOPIC}" title="{L_POST_REPLY_TOPIC}"  /></a></td>
<td width="100%">&nbsp;<span class="nav"><a href="{U_INDEX}">{L_INDEX}</a></span> <img src="themes/BF3/forums/images/arrow.gif" border="0" alt="" />  <span class="nav"><a href="{U_VIEW_FORUM}" title="{FORUM_NAME}">{FORUM_NAME}</a></span></td>
</tr>
</table>
{POLL_DISPLAY}
<table width="100%" cellspacing="1" cellpadding="3" border="0" align="center">
<tr>
<th width="150" height="28" align="center"><span class="forumstitle">{L_AUTHOR}</span></th>
<th width="100%" align="center"><span class="forumstitle">{L_MESSAGE}</span></th>
</tr>
<!-- BEGIN postrow -->
<tr>
  <td align="center" valign="top" height="28" class="{postrow.ROW_CLASS}">{postrow.POSTER_NAME}<br />
      {postrow.POSTER_RANK}<br />
        {postrow.RANK_IMAGE}<br />
        <div class="avatar-bg">{postrow.POSTER_AVATAR}</div>
        {postrow.POSTER_JOINED}<br />
        {postrow.POSTER_POSTS}<br />
        {postrow.POSTER_FROM}<br />
  <img src="themes/BF3/forums/images/spacer.gif" alt="" width="150" height="1" />


</td>
  <td class="{postrow.ROW_CLASS}" valign="top">
  
 <table width="100%" border="0" cellspacing="0" cellpadding="0" class="inner">
<tr>
<td width="100%" class="inner"><a href="{postrow.U_MINI_POST}"><img src="{postrow.MINI_POST_IMG}" width="12" height="9" alt="{postrow.L_MINI_POST_ALT}" title="{postrow.L_MINI_POST_ALT}" border="0" /></a>{L_POSTED}:
{postrow.POST_DATE}</td>
<td nowrap="nowrap" valign="top" class="inner">{postrow.QUOTE_IMG} {postrow.EDIT_IMG} {postrow.DELETE_IMG} {postrow.IP_IMG}</td>
</tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="inner">
<tr>
<td valign="top" class="inner">
<hr />
{postrow.MESSAGE}</td>
</tr>
<tr>
<td height="19" valign="bottom" class="inner">{postrow.ATTACHMENTS}{postrow.SIGNATURE}{postrow.EDITED_MESSAGE}</td>
</tr>
</table>

</td>


<tr>
  <td class="foot" colspan="2" nowrap="nowrap"> {postrow.PROFILE_IMG} {postrow.PM_IMG} {postrow.EMAIL_IMG} {postrow.WWW_IMG} {postrow.AIM_IMG} {postrow.YIM_IMG} {postrow.MSN_IMG} {postrow.ICQ_IMG}</td>
</tr>
<tr>
	<td colspan="2" class="space"></td>
</tr>
<!-- END postrow -->
<tr>
<td class="foot" align="center" colspan="2" height="30">
<form method="post" action="{S_POST_DAYS_ACTION}">
<table class="inner" border="0" cellspacing="0" cellpadding="0" align="center">
	<tfoot>
    	<tr>
			<td class="inner foot">{L_DISPLAY_POSTS}:&nbsp;&nbsp;</td>
			<td class="inner foot">{S_SELECT_POST_DAYS}&nbsp;</td>
			<td class="inner foot">{S_SELECT_POST_ORDER}&nbsp;&nbsp;</td>
			<td class="inner foot"><input type="submit" value="{L_GO}" class="submit" name="submit" /></td>
		</tr>
    </tfoot>
</table>
</form>
</td>
</tr>
</table>
<br />
<table width="100%" cellspacing="0" cellpadding="0" border="0">
<tr>
<td nowrap="nowrap" class="inner"><a href="{U_POST_NEW_TOPIC}"><img src="{POST_IMG}" border="0" alt="{L_POST_NEW_TOPIC}" title="{L_POST_NEW_TOPIC}" /></a>&nbsp;&nbsp;&nbsp;<a href="{U_POST_REPLY_TOPIC}"><img src="{REPLY_IMG}" border="0" alt="{L_POST_REPLY_TOPIC}" title="{L_POST_REPLY_TOPIC}"  /></a></td>
<td width="100%">&nbsp;<span class="nav"><a href="{U_INDEX}">{L_INDEX}</a></span> <img src="themes/BF3/forums/images/arrow.gif" border="0" alt="" /> <span class="nav"><a href="{U_VIEW_FORUM}">{FORUM_NAME}</a></span></td>
</tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="2">
<tr>

<td valign="top">{PAGINATION}<br />
<br />
{JUMPBOX}<br />
<br />
{S_TOPIC_ADMIN}<br />
{QUICK_REPLY_FORM}</td>
<td class="gensmall" align="right" valign="top"><strong>{S_WATCH_TOPIC}</strong><br />
<a href="{U_VIEW_NEWER_TOPIC}">{L_VIEW_NEXT_TOPIC}</a><br />
<a href="{U_VIEW_OLDER_TOPIC}">{L_VIEW_PREVIOUS_TOPIC}</a><br />
{S_AUTH_LIST}</td>
</tr>
</table>

   <br />
<!-- BEGIN similar -->
<table width="100%" cellspacing="1" cellpadding="2" border="0" align="center" class="forumline">
 <tr>
  <td width="100%" class="cat" align="center" colspan="6"><span class="forumstitle">{similar.L_SIMILAR}</span></td>
 </tr>
 <tr>
  <td colspan="2" class="cat"><span class="forumstitle">{similar.L_TOPIC}</span></td>
  <td class="cat" align="center"><span class="forumstitle">{similar.L_AUTHOR}</span></td>
  <td class="cat" align="center"><span class="forumstitle">{similar.L_FORUM}</span></td>
  <td class="cat" align="center"><span class="forumstitle">{similar.L_REPLIES}</span></td>
  <td class="cat" align="center"><span class="forumstitle">{similar.L_LAST_POST}</span></td>
 </tr>
 <!-- BEGIN topics -->
 <tr>
  <td class="row1" align="center"><span class="genmed"><img src="{similar.topics.FOLDER}" border="0" alt="{similar.topics.ALT}" title="{similar.topics.ALT}" /></span></td>
  <td class="row1" width="30%">{similar.topics.NEWEST}<span class="gensmall">{similar.topics.TYPE}</span> <span class="topictitle">{similar.topics.TOPICS}</span></td>
  <td class="row1" width="10%"><span class="name">{similar.topics.AUTHOR}</span></td>
  <td class="row1"><span class="name">{similar.topics.FORUM}</span></td>
  <td class="row1" width="15%" align="center"><span class="name">{similar.topics.REPLIES}</span></td>
  <td class="row1"><span class="postdetails">{similar.topics.POST_TIME}</span> <span class="name">{similar.topics.POST_URL}</span></td>
 </tr>
 <!-- END topics -->
</table>
<!-- END similar -->
