<h1>Topics in Group : {$group_name}</h1>

{if $smarty.request.a ne "Search"}
    <p>
        Total: {$grandtotal}
    </p>
{/if}

<table cellspacing="1" cellpadding="3" width="100%">

	<tr class="tabletitle">
		<td>
			<b>Topics</b>
			<a href="?gid={$smarty.request.gid}&a={$smarty.request.a}&status={$smarty.request.status}&page={$page}&sort=group_topic_title+asc">
				<img src="{$img_css_url}/images/up.gif" alt="" />
			</a>
			<a href="?gid={$smarty.request.gid}&a={$smarty.request.a}&status={$smarty.request.status}&page={$page}&sort=group_topic_title+desc">
				<img src="{$img_css_url}/images/down.gif" alt="" />
			</a>
		</td>
		<td>
			<b>Author</b>
		</td>
		<td>
			<b>Posts</b>
		</td>
		<td>
			<b>Created On</b>
			<a href="?gid={$smarty.request.gid}&a={$smarty.request.a}&status={$smarty.request.status}&page={$page}&sort=group_topic_add_time+asc">
				<img src="{$img_css_url}/images/up.gif" alt="" />
			</a>
			<a href="?gid={$smarty.request.gid}&a={$smarty.request.a}&status={$smarty.request.status}&page={$page}&sort=group_topic_add_time+desc">
				<img src="{$img_css_url}/images/down.gif" alt="" />
			</a>
		</td>
		<td>
			<b>Approved</b>
			<a href="?gid={$smarty.request.gid}&a={$smarty.request.a}&status={$smarty.request.status}&page={$page}&sort=group_topic_approved+asc">
				<img src="{$img_css_url}/images/up.gif" alt="" />
			</a>
			<a href="?gid={$smarty.request.gid}&a={$smarty.request.a}&status={$smarty.request.status}&page={$page}&sort=group_topic_approved+desc">
				<img src="{$img_css_url}/images/down.gif" alt="" />
			</a>
		</td>
		<td align="center">
			<b>Action</b>
		</td>
	</tr>

	{section name=i loop=$grptps}
    
        {insert name=id_to_name assign=uname un=$grptps[i].group_topic_user_id}
        {insert name=post_count assign=total_post TID=$grptps[i].group_topic_id}
        
        <tr bgcolor="{cycle values="#F8F8F8,#F2F2F2"}">
            <td>
                <a href="group_posts.php?gid={$grptps[i].group_topic_group_id}&TID={$grptps[i].group_topic_id}">
                    {$grptps[i].group_topic_title|truncate:40}
                </a>
            </td>
            <td>
                <a href="user_view.php?user_id={$grptps[i].group_topic_user_id}">
                    {$uname}
                </a>
            </td>
            <td align="center">
                {$total_post}
            </td>
            <td>
                {$grptps[i].group_topic_add_time|date_format}
            </td>
            <td align="center">
                {$grptps[i].group_topic_approved}
            </td>
            <td align="center">
                <a href="group_posts.php?gid={$smarty.request.gid}&action=edit&TID={$grptps[i].group_topic_id}&page={$smarty.request.page}&sort={$smarty.request.sort}">
                    <img src="{$img_css_url}/images/edit.gif" title="Edit" alt="Edit" />
                </a>
                <a href="?gid={$smarty.request.gid}&action=del&TID={$grptps[i].group_topic_id}" onclick='Javascript:return confirm("Are you sure you want to delete?");'>
                    <img src="{$img_css_url}/images/del.gif" title="Delete" alt="Delete" />
                </a>
            </td>
        </tr>

	{/section}
    
</table>

<div class="margin-tb-1em">
	$link}
</div>