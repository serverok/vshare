<h1>Reserved User Names</h1>

<table cellspacing="1" cellpadding="3" width="100%">

    <tr class="tabletitle">
        <td>
            <b>ID</b>
        </td>
        <td>
            <b>User Names</b>
        </td>
        <td align='center'>
            <b>ACTION</b>
        </td>
    </tr>

    {section name=i loop=$disallow}
    <tr class="{cycle values="tablerow1,tablerow2"}">
        <td>
            {$disallow[i].disallow_id}
        </td>
        <td>
            {$disallow[i].disallow_username}
        </td>
        <td align="center">
            <a href="?action=del&id={$disallow[i].disallow_id}" onClick='Javascript:return confirm("Are you sure you want to delete?");'>
                <img src="{$img_css_url}/images/del.gif" border="0" title="Delete" alt="Delete" />
            </a>
        </td>
    </tr>
    {/section}

</table>

<hr />

<form method="post" action="">

    <input type="hidden" name="action" value="add" />
    <div>
        <label for="name">Reserve a User Name:</label>
        <input type="text" size="40" name="name" id="name" />
    </div>
    <div class="submit">
        <input type="submit" name="submit" value="Submit" />
    </div> 

</form>