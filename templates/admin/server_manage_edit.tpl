<h1>Edit Server</h1>

<form method="post" action="server_manage_edit.php">

    <input type="hidden" name="server_id" value="{$server_info.id}" />

    <div>
        <label for="server_url">Server URL</label>
        <input name="server_url" id="server_url" value="{$server_info.url}" size="50" />
        <span>No trailing slash. Eg: http://video1.site.com</span>
    </div>

    <div>
        <label for="server_ip">Server IP</label>
        <input name="server_ip" id="server_ip" value="{$server_info.ip}" size="50" />
    </div>

    <div>
        <label for="user_name">Username</label>
        <input name="user_name" id="user_name" value="{$server_info.user_name}" size="50" />
    </div>

    <div>
        <label for="password">Password</label>
        <input name="password" id="password" value="{$server_info.password}" size="50" />
    </div>

    <div>
        <label for="folder">Folder Name</label>
        <input name="folder" id="folder" value="{$server_info.folder}" size="50" />
    </div>
    
    <div>
        <label for="server_type">Server Type</label>
        {if $server_info.server_type != "1"}
            <select name="server_type" id="server_type" onchange="server_type_change(this.value);">
                <option value="0" {if $server_info.server_type == "0"}selected="selected"{/if}>VIDEO SERVER</option>
                <option value="2" {if $server_info.server_type == "2"}selected="selected"{/if}>MOD_SECDOWNLOAD (LIGHTTPD)</option>
            </select>
        {else}
            <input type="hidden" name="server_type" value="1" />
            THUMBNAIL SERVER
        {/if}
        <a href="http://labs.buyscripts.in/projects/vshare/wiki/Video_Server_Type" target="_blank">
            <img src="{$img_css_url}/images/help.png" alt="help" />
        </a>
    </div>
    
    <div {if $server_info.server_type != 2}style="display:none"{/if} id="secdownload_secret_div">
        <label for="server_secdownload_secret">secdownload.secret</label>
        <input type="text" name="server_secdownload_secret" id="server_secdownload_secret" size="50" value="{$server_info.server_secdownload_secret}" />
    </div>

    <div class="submit">
        <input type="submit" name="submit" value="Update" />
    </div>
    
</form>

{literal}
<script>
function server_type_change(value)
{
	if (value == 2)
	{
		$('#secdownload_secret_div').fadeIn('slow');
	}
	else
	{
		$('#secdownload_secret_div').fadeOut('slow');
	}
}
</script>
{/literal}