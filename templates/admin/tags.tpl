<h1>Tags ({$total})</h1>

{include file='admin/tags_menu.tpl'}

<table cellspacing="1" cellpadding="3" width="40%">

    <tr class="tabletitle">
        <td><b>Tag</b></td>
        <td align="center" width="10%"><b>Action</b></td>
    </tr>

    {section name=tag loop=$tags}

    <tr class="{cycle values="tablerow1,tablerow2"}">
        <td>
            {$tags[tag].tag}
        </td>
        <td>
            <form method="post" action="">
                <input type="hidden" name="action_tag" value="{$tags[tag].id}" />
                {if $tags[tag].active eq 1}
                    <input type="submit" name="action" value="Disable" />
                {else if $tags[tag].active eq 0}
                    <input type="submit" name="action" value="Enable" />
                {/if}
            </form>
        </td>
    </tr>

    {/section}
    
</table>

<div style="margin-top:2em;">
    {$links}
</div>
