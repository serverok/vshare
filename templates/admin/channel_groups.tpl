<h1>Groups by Channel : {$channel_name}</h1>
    
{if $smarty.request.a ne "Search"}
    <p>Total: {$grandtotal}</p>
{/if}

<table cellspacing="1" cellpadding="3" width="100%" border="0">

    <tr class="tabletitle">
        <td>
            <b>ID</b>
            <a href="?chid={$smarty.request.chid}&a={$smarty.request.a}&status={$smarty.request.status}&sort=group_id+asc">
            <img src="{$img_css_url}/images/up.gif" border="0" alt="" /></a>
            <a href="?chid={$smarty.request.chid}&a={$smarty.request.a}&status={$smarty.request.status}&sort=group_id+desc">
            <img src="{$img_css_url}/images/down.gif" border="0" alt="" /></a>
        </td>
        <td>
            <b>Name</b>
            <a href="?chid={$smarty.request.chid}&a={$smarty.request.a}&status={$smarty.request.status}&sort=group_name+asc">
            <img src="{$img_css_url}/images/up.gif" border="0" alt="" /></a>

            <a href="?chid={$smarty.request.chid}&a={$smarty.request.a}&status={$smarty.request.status}&sort=group_name+desc">
            <img src="{$img_css_url}/images/down.gif" border="0" alt="" /></a>
        </td>
        <td>
            <b>Owner</b>
        </td>
        <td>
            <b>Video</b>
        </td>
        <td>
            <b>Member</b>
        </td>
        <td>
            <b>Topics</b>
        </td>
        <td align="center">
            <b>Type</b>
            <a href="?chid={$smarty.request.chid}&a={$smarty.request.a}&status={$smarty.request.status}&sort=group_type+asc">
            <img src="{$img_css_url}/images/up.gif" border="0" alt="" /></a>

            <a href="?chid={$smarty.request.chid}&a={$smarty.request.a}&status={$smarty.request.status}&sort=group_type+desc">
            <img src="{$img_css_url}/images/down.gif" border="0" alt="" /></a>
        </td>
        <td align="center">
            <b>Featured</b>
            <a href="?chid={$smarty.request.chid}&a={$smarty.request.a}&status={$smarty.request.status}&sort=group_featured+asc">
            <img src="{$img_css_url}/images/up.gif" border="0" alt="" /></a>

            <a href="?chid={$smarty.request.chid}&a={$smarty.request.a}&status={$smarty.request.status}&sort=group_featured+desc">
            <img src="{$img_css_url}/images/down.gif" border="0" alt="" /></a>
        </td>
        <td align="center">
            <b>Action</b>
        </td>
    </tr>

    {section name=aa loop=$groups}
    
        {insert name=group_info_count assign=gmemcount tbl=group_members gid=$groups[aa].group_id query="1" field1=group_member_approved field2=group_member_group_id}
        {insert name=group_info_count assign=gvdocount tbl=group_videos gid=$groups[aa].group_id query="1" field1=group_video_approved field2=group_video_group_id}
        {insert name=group_info_count assign=gtpscount tbl=group_topics gid=$groups[aa].group_id query="1" field1=group_topic_approved field2=group_topic_group_id}

        {insert name=id_to_name assign=uname un=$groups[aa].group_owner_id}

        <tr bgcolor="{cycle values="#F8F8F8,#F2F2F2"}">
            <td>
                {$groups[aa].group_id}
            </td>
            <td>
                <a href="group_view.php?group_id={$groups[aa].group_id}">
                    {$groups[aa].group_name}
                </a>
            </td>
            <td>
                <a href="user_view.php?user_id={$groups[aa].group_owner_id}">
                    {$uname}
                </a>
            </td>
            <td align="right">
                {$gvdocount}
            </td>
            <td align="right">
                {$gmemcount}
            </td>
            <td align="right">
                {$gtpscount}
            </td>
            <td align="center">
                {$groups[aa].group_type}
            </td>
            <td align="center">
                {$groups[aa].group_featured}
            </td>
            <td align="center">
                <a href="group_edit.php?action=edit&gid={$groups[aa].group_id}&page={$smarty.request.page}&sort={$smarty.request.sort}">
                    <img src="{$img_css_url}/images/edit.gif" title="Edit" alt="Edit" />
                </a>
                <a href="?chid={$smarty.request.chid}&action=del&gid={$groups[aa].group_id}&page={$smarty.request.page}&sort={$smarty.request.sort}" onclick="Javascript:return confirm('Are you sure you want to remove the group from this channel?');">
                     <img src="{$img_css_url}/images/del.gif" title="Remove" alt="Remove" />
                </a>
            </td>
        </tr>

    {/section}

</table>

{if $link ne ""}
    <div class="margin-tb-1em">
        {$link}
    </div>
{/if}