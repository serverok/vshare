<h1>Disabled Tags</h1>

{include file='admin/tags_menu.tpl'}

<table cellspacing="1" cellpadding="3" width="40%">

    <tr class="tabletitle">
        <td>
            <b>Tag</b>
        </td>
        <td width="15%" align="center">
            <b>Action</b>
        </td>
    </tr>

    {section name=i loop=$tags}

        <tr class="{cycle values="tablerow1,tablerow2"}">
            <td>
                {$tags[i].tag}
            </td>
            <td>
                <form method="post" action="">
                    <input type="hidden" name="action_tag" value="{$tags[i].id}" />
                    <input type="submit" name="action" value="Enable" class="btn btn-primary" />
                </form>
            </td>
        </tr>

    {/section}

</table>