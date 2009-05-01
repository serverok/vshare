<h1>Channel Sort Order</h1>

<form method="post" action="channel_sort.php">

    <table cellspacing="1" cellpadding="3" width="80%">

        <tr class="tabletitle">
            <td width="10%">
                <b>ID</b>
            </td>
            <td width="70%">
                <b>Channel Name</b>
            </td>
            <td width="20%">
                <b>Sort Order</b>
                <a href="channel_sort.php?sort=asc&page={$page}">
                    <img src="{$img_css_url}/images/up.gif" border="0" alt="" />
                </a>
                <a href="channel_sort.php?sort=desc&page={$page}">
                    <img src="{$img_css_url}/images/down.gif" border="0" alt="" />
                </a>
            </td>
        </tr>

        {section name=aa loop=$channels}

        <tr class="{cycle values="tablerow1,tablerow2"}">
            <td>
                {$channels[aa].channel_id}
            </td>
            <td>
                {$channels[aa].channel_name}
            </td>
            <td align="center">
                <input type="hidden" name="id[]" value="{$channels[aa].channel_id}" />
                <input type="text" name="sortorder[]" value="{$channels[aa].channel_sort_order}" size="4" />
            </td>
        </tr>

        {/section}

    </table>
    
    <div class="margin-tb-1em">
        <input type="submit" name="submit" value="Update Sort Order" />
    </div>
    
    <div>
        {$link}
    </div>

</form>