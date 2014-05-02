<h1>Video Feature Requests ({$total})</h1>

{if $total > 0}

    <table cellspacing="1" cellpadding="3"  width="100%" border="0">
    
        <tr class="tabletitle">
            <td align="center">
                <b>ID</b>
                <a href="?sort=feature_request_video_id+asc">
                    <span class="glyphicon glyphicon-arrow-up"></span>
                </a>
                <a href="?sort=feature_request_video_id+desc">
                    <span class="glyphicon glyphicon-arrow-down"></span>
                </a>
            </td>
            <td align="center">
                <b>Video Title</b>
            </td>
            <td align="center">
                <b>Total Request</b>
                <a href="?sort=feature_request_count+asc">
                    <span class="glyphicon glyphicon-arrow-up"></span>
                </a>
                <a href="?sort=feature_request_count+desc">
                    <span class="glyphicon glyphicon-arrow-down"></span>
                </a>
            </td>
            <td align="center">
                <b>
                    Last Reqeust Date
                </b>
                <a href="?sort=feature_request_date+asc">
                    <span class="glyphicon glyphicon-arrow-up"></span>
                </a>
                <a href="?sort=feature_request_date+desc">
                    <span class="glyphicon glyphicon-arrow-down"></span>
                </a>
            </td>
            <td align="center">
                <b>Action</b>
            </td>
        </tr>

        {section name=aa loop=$videos}
        
            {insert name=getfield assign=title field='video_title' table='videos' qfield='video_id' qvalue=$videos[aa].feature_request_video_id}
            
            <tr class="{cycle values="tablerow1,tablerow2"}">
                <td align="center">
                    {$videos[aa].feature_request_video_id}
                </td>
                <td>
                    <a href="video_details.php?a={$a}&id={$videos[aa].feature_request_video_id}&page={$page}">{$title|replace:'\\':''}</a>
                </td>
                <td align="center">
                    {$videos[aa].feature_request_count}
                </td>
                <td align="center">
                    {$videos[aa].feature_request_date|date_format}
                </td>
                <td align="center">
                    <a href="?vid={$videos[aa].feature_request_video_id}&page={$page}&action=approve">Approve</a>
                    <a href="?vid={$videos[aa].feature_request_video_id}&page={$page}&action=del" onclick="Javascript:return confirm('Are you sure you want to deny?');">Deny</a>
                </td>
            </tr>
            
        {/section}

    </table>
    
    <div class="margin-tb-1em">
        {$links}
    </div>

    <div class="margin-tb-1em">
        <a href="?page={$page}&action=delete_all" onclick="javascript:return confirm('Are you sure you want to remove?');">
            Remove All Requests
        </a>
    </div>

{else}
    <h5>No feature requests found.</h5>
{/if}