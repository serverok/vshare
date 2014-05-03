<h1>Search Tags</h1>

{include file='admin/tags_menu.tpl'}

<form method="post" action="">
    <div>
        <b>Tag:</b>
        <input type="text" name="search_tag" />
        <input type="submit" name="submit" value="Search" class="btn btn-default btn-lg" />
    </div>
</form>

<div style="margin-bottom: 2em"></div>

{if $tag ne ''}

    <table class="table table-striped">
        <tr>
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

        <tr>
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
                        <input type="submit" name="action" value="Disable" class="btn btn-default btn-lg" />
                    {else if $tag[i].active eq 0}
                        <input type="submit" name="action" value="Activate" class="btn btn-default btn-lg" />
                    {/if}
                </form>
            </td>
        </tr>

        {/section}
    </table>
{/if}
