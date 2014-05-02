<h1>{$smarty.request.a} Users ({$total})</h1>

{if $total > 0}

<table class="table table-striped">

	<tr class="tabletitle">
		<td>
			<b>ID</b>
			<a href="users.php?a={$smarty.request.a}&status={$smarty.request.status}&sort=user_id+asc&page={$page}">
				<span class="glyphicon glyphicon-arrow-up"></span>
			</a>
			<a href="users.php?a={$smarty.request.a}&status={$smarty.request.status}&sort=user_id+desc&page={$page}">
				<span class="glyphicon glyphicon-arrow-down"></span>
			</a>
		</td>
		<td>
			<b>Name</b>
			<a href="users.php?a={$smarty.request.a}&status={$smarty.request.status}&sort=user_name+asc&page={$page}">
				<span class="glyphicon glyphicon-arrow-up"></span>
			</a>
			<a href="users.php?a={$smarty.request.a}&status={$smarty.request.status}&sort=user_name+desc&page={$page}">
				<span class="glyphicon glyphicon-arrow-down"></span>
			</a>
		</td>
		<td>
			<b>Country</b>
			<a href="users.php?a={$smarty.request.a}&status={$smarty.request.status}&sort=user_country+asc&page={$page}">
				<span class="glyphicon glyphicon-arrow-up"></span>
			</a>
			<a href="users.php?a={$smarty.request.a}&status={$smarty.request.status}&sort=user_country+desc&page={$page}">
				<span class="glyphicon glyphicon-arrow-down"></span>
			</a>
		</td>
		<td>
			<b>Last Login</b>
			<a href="users.php?a={$smarty.request.a}&status={$smarty.request.status}&sort=user_last_login_time+asc&page={$page}">
				<span class="glyphicon glyphicon-arrow-up"></span>
			</a>
			<a href="users.php?a={$smarty.request.a}&status={$smarty.request.status}&sort=user_last_login_time+desc&page={$page}">
				<span class="glyphicon glyphicon-arrow-down"></span>
			</a>
		</td>
		<td>
			<b>Video</b>
			<a href="users.php?a={$smarty.request.a}&status={$smarty.request.status}&sort=user_videos+asc&page={$page}">
                <span class="glyphicon glyphicon-arrow-up"></span>
            </a>
            <a href="users.php?a={$smarty.request.a}&status={$smarty.request.status}&sort=user_videos+desc&page={$page}">
                <span class="glyphicon glyphicon-arrow-down"></span>
            </a>
		</td>
		{if $enable_package eq "yes"}
		<td>
			<b>Package</b>
		</td>
		{/if}
		<td>
			<b>Status</b>
			<a href="users.php?a={$smarty.request.a}&status={$smarty.request.status}&sort=user_account_status+asc&page={$page}">
				<span class="glyphicon glyphicon-arrow-up"></span>
			</a>
			<a href="users.php?a={$smarty.request.a}&status={$smarty.request.status}&sort=user_account_status+desc&page={$page}">
				<span class="glyphicon glyphicon-arrow-down"></span>
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
			{insert name=subscriber_info assign=pack uid=$users[aa].user_id}
			<td align="right">
				{if $pack.total_video gt "0"}
					<a href="user_videos.php?uid={$users[aa].user_id}">
						{$pack.total_video}
					</a>
				{else}
					0
				{/if}
			</td>
			{if $enable_package eq "yes"}
			<td>
				{$pack.package_name}
			</td>
			{/if}
			<td align="center">
				{$users[aa].user_account_status}
			</td>
			<td align="center">
				<a href="user_edit.php?action=edit&uid={$users[aa].user_id}&page={$smarty.request.page}&sort={$smarty.request.sort}">
                    <span class="glyphicon glyphicon-edit"></span>
                </a>
                &nbsp;
                <a href="user_delete.php?uid={$users[aa].user_id}&a={$smarty.get.a}&page={$smarty.get.page}&sort={$smarty.get.sort}" onclick="javascript:return confirm('Are you sure you want to delete?');">
                    <span class="glyphicon glyphicon-remove-circle"></span>
                </a>
                &nbsp;
				<a href="mail_users.php?email={$users[aa].user_email}&uname={$users[aa].user_name}">
                    <span class="glyphicon glyphicon-envelope"></span>
                </a>
                &nbsp;
				<a href="user_login.php?username={$users[aa].user_name}" target="_blank">
                    <span class="glyphicon glyphicon-log-in"></span>
                </a>
			</td>
		</tr>
	{/section}

</table>

{if $links ne ""}
    <div>
        {$links}
    </div>
{/if}

{else}

<h5>No inactive users found.</h5>

{/if}