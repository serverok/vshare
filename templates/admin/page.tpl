<h1>List Pages</h1>

<table cellspacing="1" cellpadding="3" width="100%">

    <tr class="tabletitle">
        <td>
            <b>Id</b>
        </td>
        <td>
            <b>Name</b>
        </td>
        <td>
            <b>Title</b>
        </td>
        <td>
            <b>Counter</b>
        </td>
        <td>
            <b>Members Only</b>
        </td>
        <td align="center">
            <b>Action</b>
        </td>
    </tr>

    {section name=i loop=$pages}

        <tr class="{cycle values='tablerow1,tablerow2'}">
            <td>
                {$pages[i].page_id}
            </td>
            <td>
                {$pages[i].page_name}
            </td>
            <td>
                {$pages[i].page_title}
            </td>
            <td>
                {$pages[i].page_counter}
            </td>

            {if $pages[i].page_members_only eq "1"}
                <td>
                    Yes
                </td>
            {else}
                <td>
                    No
                </td>
            {/if}

            <td align="center">
                <a href="{$base_url}/pages/{$pages[i].page_name}.html" target="_blank">
                    <img src="{$img_css_url}/images/page_go.png" title="View" alt="View" />
                </a>
                <a href='page_edit.php?id={$pages[i].page_id}'>
                    <img src="{$img_css_url}/images/edit.gif" title="Edit" alt="Edit" />
                </a>
                <a href='page.php?action=del&id={$pages[i].page_id}' onclick='Javascript:return confirm("Are you sure want to delete?");'>
                    <img src="{$img_css_url}/images/del.gif" title="Delete" alt="Delete" />
                </a>
            </td>
        </tr>

    {/section}

</table>