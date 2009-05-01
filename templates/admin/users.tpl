<h1>{$smarty.request.a} Users ({$total})</h1>

{if $total > 0}

<table cellspacing="1" cellpadding="3"  width="100%" border="0">

	<tr class="tabletitle">
		<td>
			<b>ID</b>
			<a href="users.php?a={$smarty.request.a}&status={$smarty.request.status}&sort=user_id+asc&page={$page}">
				<img src="{$img_css_url}/images/up.gif" border="0" alt="" />
			</a>
			<a href="users.php?a={$smarty.request.a}&status={$smarty.request.status}&sort=user_id+desc&page={$page}">
				<img src="{$img_css_url}/images/down.gif" border="0" alt="" />
			</a>
		</td>
		<td>
			<b>Name</b>
			<a href="users.php?a={$smarty.request.a}&status={$smarty.request.status}&sort=user_name+asc&page={$page}">
				<img src="{$img_css_url}/images/up.gif" border="0" alt="" />
			</a>
			<a href="users.php?a={$smarty.request.a}&status={$smarty.request.status}&sort=user_name+desc&page={$page}">
				<img src="{$img_css_url}/images/down.gif" border="0" alt="" />
			</a>
		</td>
		<td>
			<b>Country</b>
			<a href="users.php?a={$smarty.request.a}&status={$smarty.request.status}&sort=user_country+asc&page={$page}">
				<img src="{$img_css_url}/images/up.gif" border="0" alt="" />
			</a>
			<a href="users.php?a={$smarty.request.a}&status={$smarty.request.status}&sort=user_country+desc&page={$page}">
				<img src="{$img_css_url}/images/down.gif" border="0" alt="" />
			</a>
		</td>
		<td>
			<b>Last Login</b>
			<a href="users.php?a={$smarty.request.a}&status={$smarty.request.status}&sort=user_last_login_time+asc&page={$page}">
				<img src="{$img_css_url}/images/up.gif" border="0" alt="" />
			</a>
			<a href="users.php?a={$smarty.request.a}&status={$smarty.request.status}&sort=user_last_login_time+desc&page={$page}">
				<img src="{$img_css_url}/images/down.gif" border="0" alt="" />
			</a>
		</td>
		<td>
			<b>Video</b>
		</td>
		{if $enable_package eq "yes"}
		<td>
			<b>Package</b>
		</td>
		{/if}
		<td>
			<b>Status</b>
			<a href="users.php?a={$smarty.request.a}&status={$smarty.request.status}&sort=user_account_status+asc&page={$page}">
				<img src="{$img_css_url}/images/up.gif" border="0" alt="" />
			</a>
			<a href="users.php?a={$smarty.request.a}&status={$smarty.request.status}&sort=user_account_status+desc&page={$page}">
				<img src="{$img_css_url}/images/down.gif" border="0" alt="" />
			</a>
		</td>
		<td align="center">
			<b>Action</b>
		</td>
	</tr>

	{section name=aa loop=$users}
		<tr class="{cycle values="tablerow1,tablerow2"}">
			<td>
				{$users[aa].user_id}
			</td>
			<td>
				<a href="user_view.php?user_id={$users[aa].user_id}&page={$smarty.request.page}">
					{$users[aa].user_name}
				</a>
			</td>
			<td>
				{$users[aa].user_country}
			</td>
			<td>
				{$users[aa].user_last_login_time|date_format}
			</td>
			<td align="right">
				{insert name=video_count assign=vdo uid=$users[aa].user_id}
				{if $vdo ne "0"}
					<a href="user_videos.php?uid={$users[aa].user_id}">
						{$vdo}
					</a>
				{else}
					{$vdo}
				{/if}
			</td>
			{if $enable_package eq "yes"}
			<td>
				{insert name=subscriber_info assign=pack uid=$users[aa].user_id}
				{$pack.package_name}
			</td>
			{/if}
			<td align="center">
				{$users[aa].user_account_status}
			</td>
			<td align="center">
				<a href="user_edit.php?action=edit&uid={$users[aa].user_id}&page={$smarty.request.page}&sort={$smarty.request.sort}">
                    <img src="{$img_css_url}/images/edit.gif" title="Edit User" alt="Edit User" />
                </a> |
				<a href="user_delete.php?uid={$users[aa].user_id}" onclick="Javascript:return confirm('Are you sure you want to delete?');">
                    <img src="{$img_css_url}/images/del.gif" title="Delete User" alt="Delete User" />
                </a> |
				<a href="mail_users.php?email={$users[aa].user_email}&uname={$users[aa].user_name}">Mail</a> |
				<a href="user_login.php?username={$users[aa].user_name}" target="_blank">Login</a>
			</td>
		</tr>
	{/section}

</table>

{if $links ne ""}
    <div class="margin-tb-1em">
        {$links}
    </div>
{/if}

{else}

<h5>No inactive users found.</h5>

{/if}