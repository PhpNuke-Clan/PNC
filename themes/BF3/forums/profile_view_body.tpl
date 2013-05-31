
<table width="100%" cellspacing="1" cellpadding="3" border="0">
<tr>
<th colspan="2">{L_VIEWING_PROFILE}</th>
</tr>
<tr>
<th width="40%" align="center">{L_AVATAR}</th>
<th width="60%" align="center">{L_ABOUT_USER}</th>
</tr>
<tr>
<td class="row2" align="center"><div class="avatar-bg">{AVATAR_IMG}</div><br />
{POSTER_RANK}</td>
<td class="row2" rowspan="3" valign="top">
<table width="100%" border="0" cellspacing="1" cellpadding="3">
<tr>
<td align="right" nowrap="nowrap">{L_JOINED}:&nbsp;</td>
<td width="100%">{JOINED}</td>
</tr>
<tr>
<td valign="top" align="right" nowrap="nowrap">{L_TOTAL_POSTS}:&nbsp;</td>
<td valign="top">{POSTS}<br />
[{POST_PERCENT_STATS} / {POST_DAY_STATS}]<br />
<a href="{U_SEARCH_USER}">{L_SEARCH_USER_POSTS}</a></td>
</tr>
<tr>
<td align="right" nowrap="nowrap">{L_LOCATION}:&nbsp;</td>
<td>{LOCATION}</td>
</tr>
<tr>
<td align="right" nowrap="nowrap">{L_WEBSITE}:&nbsp;</td>
<td>{WWW}</td>
</tr>
<tr>
<td align="right" nowrap="nowrap">{L_OCCUPATION}:&nbsp;</td>
<td>{OCCUPATION}</td>
</tr>
<tr>
<td valign="top" align="right" nowrap="nowrap">{L_INTERESTS}:&nbsp;</td>
<td> {INTERESTS}</td>
</tr>
<!-- BEGIN switch_upload_limits -->
		<tr>
			<td valign="top" align="right" nowrap="nowrap">{L_UPLOAD_QUOTA}:</td>
			<td>
				<table width="175" cellspacing="1" cellpadding="2" border="0">
				<tr>
					<td colspan="3" width="100%" class="row2">
						<table cellspacing="0" cellpadding="1" border="0">
						<tr>
							<td><img src="themes/BF3/forums/images/spacer.gif" width="{UPLOAD_LIMIT_IMG_WIDTH}" height="8" alt="{UPLOAD_LIMIT_PERCENT}" /></td>
						</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td width="33%" class="row2">0%</td>
					<td width="34%" align="center" class="row2">50%</td>
					<td width="33%" align="right" class="row2">100%</td>
				</tr>
				</table>
				[{UPLOADED} / {QUOTA} / {PERCENT_FULL}]<br />
				<a href="{U_UACP}" class="genmed">{L_UACP}</a>
			</td>
		</tr>
<!-- END switch_upload_limits -->
</table>
</td>
</tr>
<tr>
<th align="center">{L_CONTACT} {USERNAME}</th>
</tr>
<tr>
<td class="row2" valign="top">
<table width="100%" border="0" cellspacing="1" cellpadding="3">
<tr>
<td align="right" nowrap="nowrap">{L_EMAIL_ADDRESS}:</td>
<td width="100%">{EMAIL_IMG}</td>
</tr>
<tr>
<td align="right" nowrap="nowrap">{L_PM}:</td>
<td>{PM_IMG}</td>
</tr>
<tr>
<td align="right" nowrap="nowrap">{L_MESSENGER}:</td>
<td>{MSN_IMG}</td>
</tr>
<tr>
<td align="right" nowrap="nowrap">{L_YAHOO}:</td>
<td>{YIM_IMG}</td>
</tr>
<tr>
<td align="right" nowrap="nowrap">{L_AIM}:</td>
<td>{AIM_IMG}</td>
</tr>
<tr>
<td align="right" nowrap="nowrap">{L_ICQ_NUMBER}:</td>
<td>{ICQ_IMG}</td>
</tr>
</table>
</td>
</tr>
<tr>
<td class="cat" colspan="2">&nbsp;</td>
</tr>
</table>
<br />
<div align="left">{JUMPBOX}</div>
