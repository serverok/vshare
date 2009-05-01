<h1>Channel Videos : {$channel_name}</h1>
            
<p>Total: {$grandtotal}</p>

<table cellspacing="1" cellpadding="3" width="100%" border="0">

    <tr class="tabletitle">
        <td>
            <b>ID</b>
            <a href="channel_videos.php?chid={$smarty.request.chid}&a={$smarty.request.a}&status={$smarty.request.status}&sort=video_id+asc">
                <img src="{$img_css_url}/images/up.gif" alt="" />
            </a>
            <a href="channel_videos.php?chid={$smarty.request.chid}&a={$smarty.request.a}&status={$smarty.request.status}&sort=video_id+desc">
                <img src="{$img_css_url}/images/down.gif" alt="" />
            </a>
        </td>

        <td>
            <b>Title</b>
            <a href="channel_videos.php?chid={$smarty.request.chid}&a={$smarty.request.a}&status={$smarty.request.status}&sort=video_title+asc">
                <img src="{$img_css_url}/images/up.gif" alt="" />
            </a>
            <a href="channel_videos.php?chid={$smarty.request.chid}&a={$smarty.request.a}&status={$smarty.request.status}&sort=video_title+desc">
                <img src="{$img_css_url}/images/down.gif" alt="" />
            </a>
        </td>

        <td>
            <b>Type</b>
            <a href="channel_videos.php?chid={$smarty.request.chid}&a={$smarty.request.a}&status={$smarty.request.status}&sort=video_type+asc">
                <img src="{$img_css_url}/images/up.gif" alt="" />
            </a>
            <a href="channel_videos.php?chid={$smarty.request.chid}&a={$smarty.request.a}&status={$smarty.request.status}&sort=video_type+desc">
                <img src="{$img_css_url}/images/down.gif" alt="" />
            </a>
        </td>
        <td>
            <b>Duration</b>
            <a href="channel_videos.php?chid={$smarty.request.chid}&a={$smarty.request.a}&status={$smarty.request.status}&sort=video_duration+asc">
                <img src="{$img_css_url}/images/up.gif" alt="" />
            </a>
            <a href="channel_videos.php?chid={$smarty.request.chid}&a={$smarty.request.a}&status={$smarty.request.status}&sort=video_duration+desc">
                <img src="{$img_css_url}/images/down.gif" />
            </a>
        </td>
        <td>
            <b>Featured</b>
            <a href="channel_videos.php?chid={$smarty.request.chid}&a={$smarty.request.a}&status={$smarty.request.status}&sort=video_featured+asc">
                <img src="{$img_css_url}/images/up.gif" alt="" />
            </a>
            <a href="channel_videos.php?chid={$smarty.request.chid}&a={$smarty.request.a}&status={$smarty.request.status}&sort=video_featured+desc">
                <img src="{$img_css_url}/images/down.gif" alt="" />
            </a>
        </td>
        <td>
            <b>Date</b>
            <a href="channel_videos.php?chid={$smarty.request.chid}&a={$smarty.request.a}&status={$smarty.request.status}&sort=video_add_date+asc">
                <img src="{$img_css_url}/images/up.gif" alt="" />
            </a>
            <a href="channel_videos.php?chid={$smarty.request.chid}&a={$smarty.request.a}&status={$smarty.request.status}&sort=video_add_date+desc">
                <img src="{$img_css_url}/images/down.gif" alt="" />
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
                <a href="video_details.php?id={$videos[aa].video_id}&page={$smarty.request.page}">
                    {$videos[aa].video_title}
                </a>
            </td>
            <td align="center">
                {$videos[aa].video_type}
            </td>
            <td align="center">
                {$videos[aa].video_duration|string_format:"%.2f"}
            </td>
            <td align="center">
                {$videos[aa].video_featured}
            </td>
            <td align="center">
                {$videos[aa].video_add_date|date_format}
            </td>
            <td align="center">
                <a href="video_edit.php?action=edit&video_id={$videos[aa].video_id}&page={$smarty.request.page}&sort={$smarty.request.sort}">Edit</a> |
                <a href="channel_videos.php?chid={$smarty.request.chid}&action=del&video_id={$videos[aa].video_id}" onClick="Javascript:return confirm('Are you sure you want to remove the video from this channel?');">Remove</a>
            </td>
        </tr>
    {/section}

</table>

{if $links ne ""}
    <div class="margin-tb-1em">
        {$links}
    </div>
{/if}