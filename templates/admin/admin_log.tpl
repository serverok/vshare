{literal}
<script type="text/javascript">
	function check_all(status)
	{
		$("input[type=checkbox]").each(function(){
			$(this).attr('checked', status);
		});
	}

	function validate()
	{
		if ($("input[type=checkbox]:checked").length > 0)
		{
			return true;
		}
		else
		{
			alert('Please select fields to delete.');
			return false;
		}
	}
</script>
{/literal}

<h1>Admin Log</h1>

<form method="post" name="frm" id="frm" action="admin_log_delete.php?page={$page}&sort={$sort}" onsubmit="return validate();">

<table cellspacing="1" cellpadding="3" width="100%" border="0">
	<tr class="tabletitle">
	    <td align="center" width="15%">
		<b>USERNAME</b>
	    </td>
	    <td align="center" width="15%">
	        <b>USER IP</b>
		<a href="admin_log.php?sort=admin_log_ip+asc&page={$page}">
			<img src="{$img_css_url}/images/up.gif" border="0" alt="" />
	        </a>
	        <a href="admin_log.php?sort=admin_log_ip+desc&page={$page}">
	            <img src="{$img_css_url}/images/down.gif" border="0" alt="" />
	        </a>
	    </td>
	    <td align="center" width="20%">
	        <b>TIME</b>
	        <a href="admin_log.php?sort=admin_log_time+asc&page={$page}">
			<img src="{$img_css_url}/images/up.gif" border="0" alt="" />
	        </a>
	        <a href="admin_log.php?sort=admin_log_time+desc&page={$page}">
	            <img src="{$img_css_url}/images/down.gif" border="0" alt="" />
	        </a>
	    </td>
	    <td align="center">
	        <b>ACTION</b>
	    </td>
	    <td align="center" width="10%">
	        <b>DELETE</b>
	    </td>
	</tr>

	{section name=i loop=$admin_log_info}
	<tr class="{cycle values="tablerow1,tablerow2"}">
		<td>
		{if $admin_log_info[i].admin_log_user_id eq '0'}
			Admin
		{else}
			{insert name=id_to_name un=$admin_log_info[i].admin_log_user_id assign=user_name}
			<a href="user_view.php?user_id={$admin_log_info[i].admin_log_user_id}">{$user_name}</a>
		{/if}
		</td>
		<td align="center">{$admin_log_info[i].admin_log_ip}</td>
		<td align="center">{$admin_log_info[i].admin_log_time|date_format:"%B %e, %Y %H:%M:%S"}</td>
		<td>{$admin_log_info[i].admin_log_script}{if $admin_log_info[i].admin_log_extra ne ''}?{$admin_log_info[i].admin_log_extra}{/if}</td>
		<td align="center"><input type="checkbox" name="delete_log[]" id="delete_log" value="{$admin_log_info[i].admin_log_id}" /></td>
	</tr>
	{/section}
	<tr>
		<td colspan="3">
			<div class="margin-tb-1em">
				{$links}
			</div>
		</td>
		<td align="right">
			<a href="Javascript:void(0);" onclick="check_all(true);">Check All</a>&nbsp; / &nbsp;
			<a href="Javascript:void(0);" onclick="check_all(false);">Uncheck All</a>
		</td>
		<td align="center"><input type="submit" name="submit" value="Delete" /></td>
	</tr>
	<tr>
		<td colspan="5">
			<a href="{$base_url}/admin/admin_log_delete.php?delete_all=1">Delete All</a>
		</td>
	</tr>
</table>
</form>
