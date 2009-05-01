<h1>Add FTP Server</h1>

<form method="post" action="">

    <div>
        <label for="server_url">Server URL:</label>
        <input type="text" name="server_url" id="server_url" value="{$smarty.post.server_url}" size="50" />
        <span>No trailing slash. Eg: http://video1.site.com</span>
    </div>

    <div>
        <label for="server_ip">FTP Server IP:</label>
        <input type="text" name="server_ip" id="server_ip" value="{$smarty.post.server_ip}" size="50" />
    </div>

    <div>
        <label for="server_username">FTP Server Username:</label>
        <input type="text" name="server_username" id="server_username" value="{$smarty.post.server_username}" size="50" />
    </div>

    <div>
        <label for="server_password">FTP Server Password:</label>
        <input type="text" name="server_password" id="server_password" value="{$smarty.post.server_password}" size="50" />
    </div>

    <div>
        <label for="server_folder">FTP Server Folder Name:</label>
        <input type="text" name="server_folder" id="server_folder" value="{$smarty.post.server_folder}" size="50" />
    </div>

    <div>
        <label for="server_type">Server Type:</label>
        <select name="server_type" id="server_type" onchange="server_type_change(this.value);">
            <option value="0" {if $smarty.post.server_type == "0"}selected="selected"{/if}>VIDEO SERVER</option>
            <option value="1" {if $smarty.post.server_type == "1"}selected="selected"{/if}>THUMBNAIL SERVER</option>
            <option value="2" {if $smarty.post.server_type == "2"}selected="selected"{/if}>MOD_SECDOWNLOAD (LIGHTTPD)</option>
        </select>
        <a href="http://docs.buyscripts.in/Video_Server_Type" target="_blank">
            <img src="{$img_css_url}/images/help.png" alt="help" />
        </a>
    </div>

    <div {if $smarty.post.server_type != 2}style="display:none"{/if} id="secdownload_secret_div">
        <label for="server_secdownload_secret">secdownload.secret</label>
        <input type="text" name="server_secdownload_secret" id="server_secdownload_secret" size="50" value="{$smarty.post.secdownload_secret}" />
    </div>

    <div class="submit">
        <input type="submit" name="submit" value="Add Server" />
    </div>

</form>

{literal}
<script type="text/javascript">
	function server_type_change(obj_id)
	{
		if (obj_id == "2")
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
