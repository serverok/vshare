<h1>Manage Server</h1>

<table cellspacing="1" cellpadding="3" width="100%">

    <tr class="tabletitle">
        <td>
            <b>Id</b>
        </td>
        <td>
            <b>Server Ip</b>
        </td>
        <td>
            <b>Server Url</b>
        </td>
        <td>
            <b>Username</b>
        </td>
        <td>
            <b>Password</b>
        </td>
        <td>
            <b>Folder Name</b>
        </td>
        <td>
            <b>Status</b>
        </td>
        <td>
            <b>Server Type</b>
        </td>
        <td>
            <b>Action</b>
        </td>
    </tr>

    {section name=i loop=$server_info}

        <tr class="{cycle values="tablerow1,tablerow2"}">
            <td align="left">
                {$server_info[i].id}
            </td>
            <td>
                {$server_info[i].ip}
            </td>
            <td>
                {$server_info[i].url}
            </td>
            <td>
                {$server_info[i].user_name}
            </td>
            <td>
                {$server_info[i].password}
            </td>
            <td>
                {$server_info[i].folder}
            </td>
            <td>
                <a href="{$base_url}/admin/server_manage_status.php?server_id={$server_info[i].id}">
                    {if $server_info[i].status == "0"}
                        Disabled
                    {elseif $server_info[i].status == "1"}
                        Enabled
                    {/if}
                </a>
            </td>
            <td>
                {if $server_info[i].server_type == "0"}
                    VIDEO SERVER
                {elseif $server_info[i].server_type == "1"}
                    THUMBNAIL SERVER
                {elseif $server_info[i].server_type == "2"}
                    SECDOWNLOAD
                {elseif $server_info[i].server_type == "3"}
                    ngx_http_secure_link_module
                {/if}
            </td>
            <td>
                <a href="{$base_url}/admin/server_manage_edit.php?id={$server_info[i].id}">
                    <img src="{$img_css_url}/images/edit.gif" title="Edit" alt="Edit" />
                </a>
                <a href="{$base_url}/admin/server_manage_delete.php?id={$server_info[i].id}" onclick="return confirm('Are you sure you want to remove ?');">
                    <span class="glyphicon glyphicon-remove-circle"></span>
                </a>
            </td>
        </tr>
    {/section}

</table>