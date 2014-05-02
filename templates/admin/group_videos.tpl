<h1>Videos in Group: {$group_name}</h1>

{if $smarty.request.a ne "Search"}
    <p>
        Total: {$grandtotal}
    </p>
{/if}

<table cellspacing="1" cellpadding="3" width="100%">

    <tr class="tabletitle">
        <td>
            <b>ID</b>
            <a href="group_videos.php?gid={$smarty.request.gid}&a={$smarty.request.a}&status={$smarty.request.status}&sort=video_id+asc">
                <span class="glyphicon glyphicon-arrow-up"></span>
            </a>
            <a href="group_videos.php?gid={$smarty.request.gid}&a={$smarty.request.a}&status={$smarty.request.status}&sort=video_id+desc">
                <span class="glyphicon glyphicon-arrow-down"></span>
            </a>
        </td>

        <td>
            <b>Title</b>
            <a href="group_videos.php?gid={$smarty.request.gid}&a={$smarty.request.a}&status={$smarty.request.status}&sort=video_title+asc">
                <span class="glyphicon glyphicon-arrow-up"></span>
            </a>
            <a href="group_videos.php?gid={$smarty.request.gid}&a={$smarty.request.a}&status={$smarty.request.status}&sort=video_title+desc">
                <span class="glyphicon glyphicon-arrow-down"></span>
            </a>
        </td>
        <td>
            <b>Type</b>
            <a href="group_videos.php?gid={$smarty.request.gid}&a={$smarty.request.a}&status={$smarty.request.status}&sort=video_type+asc">
                <span class="glyphicon glyphicon-arrow-up"></span>
            </a>
            <a href="group_videos.php?gid={$smarty.request.gid}&a={$smarty.request.a}&status={$smarty.request.status}&sort=video_type+desc">
                <span class="glyphicon glyphicon-arrow-down"></span>
            </a>
        </td>
        <td>
            <b>Duration</b>
            <a href="group_videos.php?gid={$smarty.request.gid}&a={$smarty.request.a}&status={$smarty.request.status}&sort=video_duration+asc">
                <span class="glyphicon glyphicon-arrow-up"></span>
            </a>
            <a href="group_videos.php?gid={$smarty.request.gid}&a={$smarty.request.a}&status={$smarty.request.status}&sort=video_duration+desc">
                <span class="glyphicon glyphicon-arrow-down"></span>
            </a>
        </td>
        <td>
            <b>Featured</b>
            <a href="group_videos.php?gid={$smarty.request.gid}&a={$smarty.request.a}&status={$smarty.request.status}&sort=video_featured+asc">
                <span class="glyphicon glyphicon-arrow-up"></span>
            </a>
            <a href="group_videos.php?gid={$smarty.request.gid}&a={$smarty.request.a}&status={$smarty.request.status}&sort=video_featured+desc">
                <span class="glyphicon glyphicon-arrow-down"></span>
            </a>
        </td>
        <td>
            <b>Date</b>
            <a href="group_videos.php?gid={$smarty.request.gid}&a={$smarty.request.a}&status={$smarty.request.status}&sort=video_add_date+asc">
                <span class="glyphicon glyphicon-arrow-up"></span>
            </a>
            <a href="group_videos.php?gid={$smarty.request.gid}&a={$smarty.request.a}&status={$smarty.request.status}&sort=video_add_date+desc">
                <span class="glyphicon glyphicon-arrow-down"></span>
            </a>
        </td>
        <td align="center">
            <b>Action</b>
        </td>
    </tr>

    {section name=aa loop=$videos}
    <tr bgcolor="{cycle values="#F8F8F8,#F2F2F2"}">
        <td>
            {$videos[aa].video_id}
        </td>
        <td>
            <a href="video_details.php?id={$videos[aa].video_id}">
                {$videos[aa].video_title}
            </a>
        </td>
        <td align="center">
            {$videos[aa].video_type}
        </td>
        <td align="center">
            {$videos[aa].video_length}
        </td>
        <td align="center">
            {$videos[aa].video_featured}
        </td>
        <td align="center">
            {$videos[aa].video_add_date|date_format}
        </td>
        <td align="center">
            <a href="video_edit.php?action=edit&video_id={$videos[aa].video_id}&page={$smarty.request.page}&sort={$smarty.request.sort}">
                Edit
            </a> |
            <a href="group_videos.php?gid={$smarty.request.gid}&action=del&video_id={$videos[aa].video_id}" onclick="Javascript:return confirm('Are you sure you want to remove the video from this group?');">
                Remove
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