<h1>Channels ({$total})</h1>

<table cellspacing="1" cellpadding="3" width="100%">

    <tr class="tabletitle">
    
        <td width="60">
            <b>ID</b>
            <a href="?a={$smarty.request.a}&status={$smarty.request.status}&sort=channel_id+asc&page={$page}">
                <img src="{$img_css_url}/images/up.gif" border="0" alt="" />
            </a>
            <a href="?a={$smarty.request.a}&status={$smarty.request.status}&sort=channel_id+desc&page={$page}">
                <img src="{$img_css_url}/images/down.gif" border="0" alt="" />
            </a>
        </td>
        <td>
            <b>Name</b>
            <a href="?a={$smarty.request.a}&status={$smarty.request.status}&sort=channel_name+asc&page={$page}">
                <img src="{$img_css_url}/images/up.gif" border="0" alt="" />
            </a>
            <a href="?a={$smarty.request.a}&status={$smarty.request.status}&sort=channel_name+desc&page={$page}">
                <img src="{$img_css_url}/images/down.gif" border="0" alt="" />
            </a>
        </td>
        <td>
            <b>Description</b>
        </td>
        <td align="center">
            <b>Videos</b>
        </td>
        <td align="center">
            <b>Groups</b>
        </td>
        <td width="100" align="center">
            <b>Action</b>
        </td>
    </tr>

    {section name=aa loop=$channels}
    
        {insert name=channel_count assign=count cid=$channels[aa].channel_id}

        <tr class="{cycle values="tablerow1,tablerow2"}">
            <td>{$channels[aa].channel_id}</td>
            <td><a href="channel_search.php?id={$channels[aa].channel_id}&action=search">{$channels[aa].channel_name}</a></td>
            <td>{$channels[aa].channel_description}</td>
            <td align="center">{if $count[1] ne "0"}<a href="channel_videos.php?chid={$channels[aa].channel_id}">{$count[1]}</a>{else}0{/if}</td>
            <td align="center">{if $count[2] ne "0"}<a href="channel_groups.php?chid={$channels[aa].channel_id}">{$count[2]}</a>{else}0{/if}</td>
            <td align="center">
            <a href="channel_edit.php?action=edit&chid={$channels[aa].channel_id}&page={$page}&sort={$smarty.request.sort}">
                <img src="{$img_css_url}/images/edit.gif" title="Edit" alt="Edit" />
            </a>
            <a href="?a={$smarty.request.a}&action=del&chid={$channels[aa].channel_id}&page={$page}&sort={$smarty.request.sort}" onclick="Javascript:return confirm('Are you sure you want to delete?');">
                <img src="{$img_css_url}/images/del.gif" title="Delete" alt="Delete" />
            </a>
            </td>
        </tr>

    {/section}
    
</table>

<div class="margin-tb-1em">
    {$links}
</div>