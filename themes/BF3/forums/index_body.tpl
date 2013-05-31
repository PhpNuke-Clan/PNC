<table class="box-table">
<tr>
<th scope="col" colspan="2" align="left">&nbsp;{L_FORUM}&nbsp;</th>
<th scope="col">&nbsp;{L_TOPICS}&nbsp;</th>
<th scope="col">&nbsp;{L_POSTS}&nbsp;</th>
<th scope="col" align="center">&nbsp;{L_LASTPOST}&nbsp;</th>
</tr>
<!-- BEGIN catrow -->
<tr>
<th colspan="5" align="left"> <img src="themes/BF3/forums/images/arrow.gif" border="0" alt="" /> <a href="{catrow.U_VIEWCAT}"><span class="forumtitle">{catrow.CAT_DESC}</span></a></th>
</tr>
<!-- BEGIN forumrow -->
<tr>
<td height="45"><img src="{catrow.forumrow.FORUM_FOLDER_IMG}" alt="{catrow.forumrow.L_FORUM_FOLDER_ALT}" title="{catrow.forumrow.L_FORUM_FOLDER_ALT}" /></td>
<td width="100%"><a href="{catrow.forumrow.U_VIEWFORUM}">{catrow.forumrow.FORUM_NAME}</a><br />
<span class="genmed">{catrow.forumrow.FORUM_DESC}<br />
</span><span class="gensmall">{catrow.forumrow.L_MODERATOR} {catrow.forumrow.MODERATORS}</span></td>
<td align="center">{catrow.forumrow.TOPICS}</td>
<td align="center">{catrow.forumrow.POSTS}</td>
<td align="center" nowrap="nowrap">{catrow.forumrow.LAST_POST}</td>
</tr>
<!-- END forumrow -->
<!-- END catrow -->
</table>

<table class="box-table">
<tr>
<th align="left"><a href="{U_VIEWONLINE}">{L_WHO_IS_ONLINE}</a></th>
</tr>
<tr>
<td>{TOTAL_POSTS}<br />
{TOTAL_USERS}<br />
{NEWEST_USER}</td>
</tr>
<tr>
<td>{TOTAL_USERS_ONLINE} &nbsp; [ <strong>{L_WHOSONLINE_ADMIN}</strong>
] &nbsp; [ <strong>{L_WHOSONLINE_MOD}</strong> ]<br />
{RECORD_USERS}<br />
{LOGGED_IN_USER_LIST}</td>
</tr>
<tr>
<td class="foot">  
<!-- BEGIN switch_user_logged_in -->
{LAST_VISIT_DATE}<br />
  <!-- END switch_user_logged_in -->
  {CURRENT_TIME}<br />
  {L_ONLINE_EXPLAIN}<br />
Powered by <a href="http://www.phpbb.com/" target="_blank">phpBB</a></td>
</tr>
</table>
<!-- BEGIN switch_user_logged_out -->

<!-- END switch_user_logged_out -->

<table width="100%" align="center" cellspacing="3" border="0" cellpadding="0">
<tr>
<td align="center"><img src="themes/BF3/forums/images/folder_new.png" alt="{L_NEW_POSTS}" title="{L_NEW_POSTS}" /><br />
  <span class="gensmall">{L_NEW_POSTS}</span></td>
<td align="center"><img src="themes/BF3/forums/images/folder.png" alt="{L_NO_NEW_POSTS}" title="{L_NO_NEW_POSTS}" /><br />
  <span class="gensmall">{L_NO_NEW_POSTS}</span></td>
<td align="center"><img src="themes/BF3/forums/images/folder_lock.gif" alt="{L_FORUM_LOCKED}" title="{L_FORUM_LOCKED}" /><br />
  <span class="gensmall">{L_FORUM_LOCKED}</span></td>
</tr>
</table>
