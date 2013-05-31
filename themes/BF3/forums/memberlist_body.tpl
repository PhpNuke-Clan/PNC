<form method="post" action="{S_MODE_ACTION}">

<table width="100%" cellpadding="0" cellspacing="0" border="0" class="box-table">
<tr>
<th>#</th>
<th>&nbsp;{L_PM}&nbsp;</th>
<th>&nbsp;{L_USERNAME}&nbsp;</th>
<th>&nbsp;{L_EMAIL}&nbsp;</th>
<th>{L_FROM}</th>
<th>{L_JOINED}</th>
<th>{L_POSTS}</th>
<th>{L_WEBSITE}</th>
</tr>
<!-- BEGIN memberrow -->
<tr>
<td align="center">&nbsp;{memberrow.ROW_NUMBER}&nbsp;</td>
<td align="center">&nbsp;{memberrow.PM_IMG}&nbsp;</td>
<td align="center"><a href="{memberrow.U_VIEWPROFILE}">{memberrow.USERNAME}</a></td>
<td align="center">&nbsp;{memberrow.EMAIL_IMG}&nbsp;</td>
<td align="center">{memberrow.FROM}</td>
<td align="center"><span class="gensmall">{memberrow.JOINED}</span></td>
<td align="center">{memberrow.POSTS}</td>
<td align="center">&nbsp;{memberrow.WWW_IMG}&nbsp;</td>
</tr>
<!-- END memberrow -->
<tr align="center">
<td colspan="8" class="foot">
<table class="inner" border="0" cellspacing="0" cellpadding="0">
<tr>
<td class="inner foot">{L_SELECT_SORT_METHOD}:&nbsp;</td>
<td class="inner foot">{S_MODE_SELECT}&nbsp;&nbsp;</td>
<td class="inner foot">{L_ORDER}:&nbsp;</td>
<td class="inner foot">{S_ORDER_SELECT}&nbsp;&nbsp;</td>
<td class="inner foot"><input type="submit" name="submit" value="{L_SUBMIT}" class="catbutton" /></td>
</tr>
</table>
</td>
</tr>
</table>
<table width="100%" cellspacing="2" cellpadding="2" border="0">
<tr>
<td>{PAGINATION}</td>
</tr>
</table>
</form>
<br clear="all" />
<div align="left">{JUMPBOX}</div>