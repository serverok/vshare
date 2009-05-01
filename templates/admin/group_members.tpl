<h1>Members in Group : {$group_name}</h1>
            
{if $smarty.request.a ne "Search"}
    <p>
        Total: {$grandtotal}
    </p>
{/if}

<table cellspacing="1" cellpadding="3" width="100%" border="0">

	<tr class="tabletitle">
		<td>
			<b>ID</b>
			<a href="?group_id={$smarty.request.group_id}&a={$smarty.request.a}&status={$smarty.request.status}&sort=user_id+asc">
				<img src="{$img_css_url}/images/up.gif" border="0" alt="" />
			</a>
			<a href="?group_id={$smarty.request.group_id}&a={$smarty.request.a}&status={$smarty.request.status}&sort=user_id+desc">
				<img src="{$img_css_url}/images/down.gif" border="0" alt="" />
			</a>
		</td>
		<td>
			<b>Name</b>
			<a href="?group_id={$smarty.request.group_id}&a={$smarty.request.a}&status={$smarty.request.status}&sort=user_name+asc">
				<img src="{$img_css_url}/images/up.gif" border="0" alt="" />
			</a>
			<a href="?group_id={$smarty.request.group_id}&a={$smarty.request.a}&status={$smarty.request.status}&sort=user_name+desc">
				<img src="{$img_css_url}/images/down.gif" border="0" alt="" />
			</a>
		</td>
		<td>
			<b>Country</b>
			<a href="?group_id={$smarty.request.group_id}&a={$smarty.request.a}&status={$smarty.request.status}&sort=user_country+asc">
				<img src="{$img_css_url}/images/up.gif" border="0" alt="" />
			</a>
			<a href="?group_id={$smarty.request.group_id}&a={$smarty.request.a}&status={$smarty.request.status}&sort=user_country+desc">
				<img src="{$img_css_url}/images/down.gif" border="0" alt="" />
			</a>
		</td>
		<td>
			<b>Last Login</b>
			<a href="?group_id={$smarty.request.group_id}&a={$smarty.request.a}&status={$smarty.request.status}&sort=user_last_login_time+asc">
				<img src="{$img_css_url}/images/up.gif" border="0" alt="" />
			</a>
			<a href="?group_id={$smarty.request.group_id}&a={$smarty.request.a}&status={$smarty.request.status}&sort=user_last_login_time+desc">
				<img src="{$img_css_url}/images/down.gif" border="0" alt="" />
			</a>
		</td>
		<td>
			<b>Video</b>
		</td>
		<td>
			<b>Status</b>
			<a href="?group_id={$smarty.request.group_id}&a={$smarty.request.a}&status={$smarty.request.status}&sort=user_account_status+asc">
				<img src="{$img_css_url}/images/up.gif" border="0" alt="" />
			</a>
			<a href="?group_id={$smarty.request.group_id}&a={$smarty.request.a}&status={$smarty.request.status}&sort=user_account_status+desc">
				<img src="{$img_css_url}/images/down.gif" border="0" alt="" />
			</a>
		</td>
		<td align="center">
			<b>Action</b>
		</td>
	</tr>

	{section name=aa loop=$users}
    
        <tr bgcolor="{cycle values="#F8F8F8,#F2F2F2"}">
            <td>
                {$users[aa].user_id}
            </td>
            <td>
                <a href="user_view.php?user_id={$users[aa].user_id}">
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
            <td align="center">
                {$users[aa].user_account_status}
            </td>
            <td align="center">
                <a href="user_edit.php?action=edit&uid={$users[aa].user_id}&page={$smarty.request.page}&sort={$smarty.request.sort}">
                    <img src="{$img_css_url}/images/edit.gif" title="Edit" alt="Edit" />
                </a>
                <a href="?group_id={$smarty.request.group_id}&a={$smarty.request.a}&action=del&uid={$users[aa].user_id}&page={$smarty.request.page}&sort={$smarty.request.sort}" onclick='Javascript:return confirm("Are you sure you want to remove the member from this group?");'>
                    <img src="{$img_css_url}/images/del.gif" title="Remove" alt="Remove" />
                </a>
                <a href="mail_users.php?email={$users[aa].user_email}&uname={$users[aa].user_name}">
                    Mail
                </a>
            </td>
        </tr>
        
	{/section}

</table>

<div class="margin-tb-1em">
    {$link}
</div>