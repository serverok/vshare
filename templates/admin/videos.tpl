<h1>{$smarty.request.a|capitalize} Videos ({$total})</h1>

{if $smarty.request.a eq "inappropriate"}

    <table cellspacing="1" cellpadding="3" width="100%" border="0">

        <tr class="tabletitle">
            <td align="center">
            <b>ID</b>
                <a href="videos.php?a={$smarty.request.a}&status={$smarty.request.status}&sort=inappropriate_request_video_id+asc&page={$page}">
                    <img src="{$img_css_url}/images/up.gif" border="0" alt="" />
                </a>
                <a href="videos.php?a={$smarty.request.a}&status={$smarty.request.status}&sort=inappropriate_request_video_id+desc&page={$page}">
                    <img src="{$img_css_url}/images/down.gif" border="0" alt="" />
                </a>
            </td>
            <td align="center">
                <b>Video Title</b>
            </td>
            <td align="center">
                <b>Total Request</b>
                <a href="videos.php?a={$smarty.request.a}&status={$smarty.request.status}&sort=inappropriate_request_count+asc&page={$page}">
                    <img src="{$img_css_url}/images/up.gif" border="0" alt="" />
                </a>
                <a href="videos.php?a={$smarty.request.a}&status={$smarty.request.status}&sort=inappropriate_request_count+desc&page={$page}">
                    <img src="{$img_css_url}/images/down.gif" border="0" alt="" />
                </a>
            </td>
            <td align="center">
                <b>Last Reqeust Date</b>
                <a href="videos.php?a={$smarty.request.a}&status={$smarty.request.status}&sort=inappropriate_request_date+asc&page={$page}">
                    <img src="{$img_css_url}/images/up.gif" border="0" alt="" />
                </a>
                <a href="videos.php?a={$smarty.request.a}&status={$smarty.request.status}&sort=inappropriate_request_date+desc&page={$page}">
                    <img src="{$img_css_url}/images/down.gif" border="0" alt="" />
                </a>
            </td>
            <td align="center">
                <b>Action</b>
            </td>
        </tr>

        {section name=aa loop=$videos}
        
            {insert name=getfield assign=title field='video_title' table='videos' qfield='video_id' qvalue=$videos[aa].inappropriate_request_video_id}
            <tr class="{cycle values="tablerow1,tablerow2"}">
                <td align="center">
                    {$videos[aa].inappropriate_request_video_id}
                </td>
                <td>
                    <a href="video_details.php?id={$videos[aa].inappropriate_request_video_id}">{$title}</a>
                </td>
                <td align="center">
                    {$videos[aa].inappropriate_request_count}
                </td>
                <td align="center">
                    {$videos[aa].inappropriate_request_date|date_format}
                </td>
                <td align="center">
                    <a href="videos.php?a={$smarty.request.a}&action=del&video_id={$videos[aa].inappropriate_request_video_id}&page={$page}&sort={$smarty.request.sort}" onclick='Javascript:return confirm("Are you sure you want to delete?");'>
                        <img src="{$img_css_url}/images/del.gif" title="Delete Request" alt="Delete" />
                    </a>
                </td>
            </tr>

        {/section}

    </table>
    
    <div class="margin-tb-1em">
        {$links}
    </div>
    
    <div class="margin-tb-1em">
        <a href="videos.php?a={$smarty.request.a}&page={$page}&action=delete" onclick='Javascript:return confirm("Are you sure you want to delete?");'>Delete All Requests</a>
    </div>
    
{else}

    <table cellspacing="1" cellpadding="3"  width="100%" border="0">
        <tr class="tabletitle">
            <td>
                <b>ID</b>
                <a href="videos.php?a={$smarty.request.a}&status={$smarty.request.status}&sort=video_id+asc&page={$page}">
                    <img src="{$img_css_url}/images/up.gif" border="0" alt="" />
                </a>
                <a href="videos.php?a={$smarty.request.a}&status={$smarty.request.status}&sort=video_id+desc&page={$page}">
                    <img src="{$img_css_url}/images/down.gif" border="0" alt="" />
                </a>
            </td>

            <td>
                <b>Title</b>
                <a href="videos.php?a={$smarty.request.a}&status={$smarty.request.status}&sort=video_title+asc&page={$page}">
                    <img src="{$img_css_url}/images/up.gif" border="0" alt="" />
                </a>
                <a href="videos.php?a={$smarty.request.a}&status={$smarty.request.status}&sort=video_title+desc&page={$page}">
                    <img src="{$img_css_url}/images/down.gif" border="0" alt="" />
                </a>
            </td>
            <td>
                <b>Type</b>
                <a href="videos.php?a={$smarty.request.a}&status={$smarty.request.status}&sort=video_type+asc&page={$page}">
                    <img src="{$img_css_url}/images/up.gif" border="0" alt="" />
                </a>
                <a href="videos.php?a={$smarty.request.a}&status={$smarty.request.status}&sort=video_type+desc&page={$page}">
                    <img src="{$img_css_url}/images/down.gif" border="0" alt="" />
                </a>
            </td>
            <td>
                <b>Duration</b>
                <a href="videos.php?a={$smarty.request.a}&status={$smarty.request.status}&sort=video_duration+asc&page={$page}">
                    <img src="{$img_css_url}/images/up.gif" border="0" alt="" />
                </a>
                <a href="videos.php?a={$smarty.request.a}&status={$smarty.request.status}&sort=video_duration+desc&page={$page}">
                    <img src="{$img_css_url}/images/down.gif" border="0" alt="" />
                </a>
            </td>
            <td>
                <b>Featured</b>
                <a href="videos.php?a={$smarty.request.a}&status={$smarty.request.status}&sort=video_featured+asc&page={$page}">
                    <img src="{$img_css_url}/images/up.gif" border="0" alt="" />
                </a>
                <a href="videos.php?a={$smarty.request.a}&status={$smarty.request.status}&sort=video_featured+desc&page={$page}">
                    <img src="{$img_css_url}/images/down.gif" border="0" alt="" />
                </a>
            </td>
            <td>
                <b>Date</b>
                <a href="videos.php?a={$smarty.request.a}&status={$smarty.request.status}&sort=video_add_date+asc&page={$page}">
                    <img src="{$img_css_url}/images/up.gif" border="0" alt="" />
                </a>
                <a href="videos.php?a={$smarty.request.a}&status={$smarty.request.status}&sort=video_add_date+desc&page={$page}">
                    <img src="{$img_css_url}/images/down.gif" border="0" alt="" />
                </a>
            </td>
            <td align="center">
                <b>Action</b>
            </td>
        </tr>

        {section name=aa loop=$videos}
        
            <tr class="{cycle values="tablerow1,tablerow2"}">
                <td>{$videos[aa].video_id}</td>
                <td><a href="video_details.php?a={$a}&id={$videos[aa].video_id}&page={$page}">{$videos[aa].video_title}</a></td>
                <td align="center">{$videos[aa].video_type}</td>
                <td align="center">{$videos[aa].video_length}</td>
                <td align="center">{$videos[aa].video_featured}</td>
                <td align="center">{$videos[aa].video_add_date|date_format}</td>
                <td align="center">
                    <a href="video_edit.php?a={$a}&action=edit&video_id={$videos[aa].video_id}&page={$page}&sort={$smarty.request.sort}">
                        <img src="{$img_css_url}/images/edit.gif" title="Edit" alt="Edit" />
                    </a>
                </td>
            </tr>

        {/section}

    </table>
    
    {if $links ne ""}
    <div class="margin-tb-1em">
        {$links}
    </div>
    {/if}

{/if}