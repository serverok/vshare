<h1>Inactive Videos ({$total})</h1>

{if $answers ne ""}

    <table cellspacing="1" cellpadding="3" width="100%" border="0">

        <tr class="tabletitle">
            <td align="center">
                <b>ID</b>
                <a href="?sort=video_id+asc&a={$smarty.request.a}">
                    <span class="glyphicon glyphicon-arrow-up"></span>
                </a>
                <a href="?sort=video_id+desc&a={$smarty.request.a}">
                    <span class="glyphicon glyphicon-arrow-down"></span>
                </a>
            </td>
            <td>
                <b>Video Title</b>
            </td>
            <td align="center">
                <b>Action</b>
            </td>
        </tr>

        {section name=i loop=$answers}
        <tr class="{cycle values="tablerow1,tablerow2"}">
            <td align="center">
                {$answers[i].video_id}
            </td>
            <td>
                <a href="video_details.php?id={$answers[i].video_id}">{$answers[i].video_title}</a>
            </td>
            <td align="center">
                <a href="?video_id={$answers[i].video_id}&page={$smarty.request.page}&todo=activate">Activate</a>
            </td>
        </tr>
        {/section}

    </table>
    
    <div class="margin-tb-1em">
        {$links}
    </div>
    
    {if $total ne "0"}
        <div>
            <a href="?todo=activate_all">Activate All Videos</a>
        </div>
	{/if}

{else}

    <p>No inactive video.</p>

{/if}