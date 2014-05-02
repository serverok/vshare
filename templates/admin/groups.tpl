<h1>{ucwords($smarty.request.a)} Groups ({$total})</h1>

<table cellspacing="1" cellpadding="3" width="100%">

    <tr class="tabletitle">

        <td>
            <b>ID</b>
            <a href="groups.php?a={$smarty.request.a}&status={$smarty.request.status}&sort=group_id+asc&page={$page}">
                <span class="glyphicon glyphicon-arrow-up"></span>
            </a>
            <a href="groups.php?a={$smarty.request.a}&status={$smarty.request.status}&sort=group_id+desc&page={$page}">
                <span class="glyphicon glyphicon-arrow-down"></span>
            </a>
        </td>

        <td>
            <b>Name</b>
            <a href="groups.php?a={$smarty.request.a}&status={$smarty.request.status}&sort=group_name+asc&page={$page}">
                <span class="glyphicon glyphicon-arrow-up"></span>
            </a>
            <a href="groups.php?a={$smarty.request.a}&status={$smarty.request.status}&sort=group_name+desc&page={$page}">
                <span class="glyphicon glyphicon-arrow-down"></span>
            </a>
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
            <a href="groups.php?a={$smarty.request.a}&status={$smarty.request.status}&sort=group_type+asc&page={$page}">
                <span class="glyphicon glyphicon-arrow-up"></span>
            </a>
            <a href="groups.php?a={$smarty.request.a}&status={$smarty.request.status}&sort=group_type+desc&page={$page}">
                <span class="glyphicon glyphicon-arrow-down"></span>
            </a>
        </td>

        <td align="center">
            <b>Featured</b>
            <a href="groups.php?a={$smarty.request.a}&status={$smarty.request.status}&sort=group_featured+asc&page={$page}">
                <span class="glyphicon glyphicon-arrow-up"></span>
            </a>
            <a href="groups.php?a={$smarty.request.a}&status={$smarty.request.status}&sort=group_featured+desc&page={$page}">
                <span class="glyphicon glyphicon-arrow-down"></span>
            </a>
        </td>

        <td align="center">
            <b>Action</b>
        </td>

    </tr>

    {section name=aa loop=$groups}
        {insert name=group_info_count assign=gmemcount tbl=group_members gid=$groups[aa].group_id query="1" field1=group_member_approved field2=group_member_group_id}
        {insert name=group_info_count assign=gvdocount tbl=group_videos gid=$groups[aa].group_id query="1" field1=group_video_approved field2=group_video_group_id}
        {insert name=group_info_count assign=gtpscount tbl=group_topics gid=$groups[aa].group_id field1=group_topic_approved field2=group_topic_group_id}
        {insert name=id_to_name assign=uname un=$groups[aa].group_owner_id}

        <tr bgcolor="{cycle values="#F8F8F8,#F2F2F2"}">
            <td >
                {$groups[aa].group_id}
            </td>
            <td >
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
                {if $gvdocount ne "0"}
                    <a href="group_videos.php?gid={$groups[aa].group_id}">
                        {$gvdocount}
                    </a>
                {else}
                    {$gvdocount}
                {/if}
            </td>
            <td align="right">
                {if $gmemcount ne "0"}
                    <a href="group_members.php?group_id={$groups[aa].group_id}">
                        {$gmemcount}
                    </a>
                {else}
                    {$gmemcount}
                {/if}
            </td>
            <td align="right">
                {if $gtpscount ne "0"}
                    <a href="group_topics.php?gid={$groups[aa].group_id}">
                        {$gtpscount}
                    </a>
                {else}
                    {$gtpscount}
                {/if}
            </td>
            <td align="center">
                {$groups[aa].group_type}
            </td>
            <td align="center">
                {$groups[aa].group_featured}
            </td>
            <td align="center">
                <a href="group_edit.php?action=edit&gid={$groups[aa].group_id}&page={$smarty.request.page}&sort={$smarty.request.sort}&a={$smarty.request.a}">
                    <img src="{$img_css_url}/images/edit.gif" title="Edit" alt="Edit" />
                </a>
                <a href="groups.php?a={$smarty.request.a}&action=del&gid={$groups[aa].group_id}&page={$smarty.request.page}&sort={$smarty.request.sort}" onclick="Javascript:return confirm('Are you sure you want to delete?');">
                    <img src="{$img_css_url}/images/del.gif" title="Delete" alt="Delete" />
                </a>
            </td>
        </tr>
    {/section}

</table>

<div class="margin-tb-1em">
    {$links}
</div>