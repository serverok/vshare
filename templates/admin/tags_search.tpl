<h1>Search Tags</h1>

{include file='admin/tags_menu.tpl'}
<form method="post" action="">
    <div style="padding-left:4em;">
        <b>Tag:</b>
        <input type="text" name="search_tag" />
        <input type="submit" name="submit" value="Search" />
    </div>
</form>

{if $tag ne ''}

    <table cellspacing="1" cellpadding="3" width="40%" border="0">
        <tr class="tabletitle">
            <td align="center">
                <b>ID</b>
            </td>
            <td align="center">
                <b>Tag</b>
            </td>
            <td align="center" width="10%">
                <b>Action</b>
            </td>
        </tr>

        {section name=i loop=$tag}

        <tr class="{cycle values="tablerow1,tablerow2"}">
            <td>
                {$tag[i].id}
            </td>
            <td>
                {$tag[i].tag}
            </td>
            <td>
                <form method="post" action="">
                    <input type="hidden" name="action_tag" value="{$tag[i].id}" />
                    {if $tag[i].active eq 1}
                        <input type="submit" name="action" value="Disable" />
                    {else if $tag[i].active eq 0}
                        <input type="submit" name="action" value="Activate" />
                    {/if}
                </form>
            </td>
        </tr>

        {/section}
    </table>
{/if}