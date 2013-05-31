<table width="100%" cellspacing="0" cellpadding="0" border="0">
<tr>
<td class="maintitle">{L_SEARCH_MATCHES}</td>
</tr>
</table>
<table class="box-table" width="100%" cellpadding="0" cellspacing="0" border="0">
<tr>
<th width="4%">&nbsp;</th>
<th>&nbsp;{L_FORUM}&nbsp;</th>
<th>&nbsp;{L_TOPICS}&nbsp;</th>
<th>&nbsp;{L_AUTHOR}&nbsp;</th>
<th>&nbsp;{L_REPLIES}&nbsp;</th>
<th>&nbsp;{L_VIEWS}&nbsp;</th>
<th>&nbsp;{L_LASTPOST}&nbsp;</th>
</tr>
<!-- BEGIN searchresults -->
<tr>
<td><img src="{searchresults.TOPIC_FOLDER_IMG}" alt="{searchresults.L_TOPIC_FOLDER_ALT}" title="{searchresults.L_TOPIC_FOLDER_ALT}" /></td>
<td><a href="{searchresults.U_VIEW_FORUM}">{searchresults.FORUM_NAME}</a></td>
<td>{searchresults.NEWEST_POST_IMG}{searchresults.TOPIC_TYPE}<a href="{searchresults.U_VIEW_TOPIC}">{searchresults.TOPIC_TITLE}</a><br />
{searchresults.GOTO_PAGE}</td>
<td align="center">{searchresults.TOPIC_AUTHOR}</td>
<td align="center">{searchresults.REPLIES}</td>
<td align="center">{searchresults.VIEWS}</td>
<td align="center" nowrap="nowrap">{searchresults.LAST_POST_TIME}<br />
{searchresults.LAST_POST_AUTHOR} {searchresults.LAST_POST_IMG}</td>
</tr>
<!-- END searchresults -->
<tr>
<td class="cat" colspan="7">&nbsp;</td>
</tr>
</table>
<table width="100%" cellspacing="2" cellpadding="2" border="0">
<tr>
<td>{PAGINATION}</td>
</tr>
</table>
<br clear="all" />
<div align="left">{JUMPBOX}</div>
