<script language="JavaScript" type="text/javascript" src="{$base_url}/js/admin_multi_import.js"></script>
<script language="JavaScript" type="text/javascript" src="{$base_url}/js/jquery.validate.min.js"></script>

{if $todo eq "folder_empty"}

<h1>Multi Import</h1>

<p>To Import videos from folder, do the following</p>

<ol class="txt">
	<li>Create a folder "import" inside templates_c folder.</li>
	<li>chmod 777 import folder you just created.</li>
	<li>Upload the videos to import folder with FTP.</li>
	<li>chmod 777 all uploaded videos.</li>
</ol>

<p><b>Import Folder Path:</b> {$base_dir}/templates_c/import</p>

{elseif $todo eq ""}

<h1>Multi Import</h1>

<p>Multi import will import all videos uploaded to folder templates_c/import</p>

<form method="post" action="" id="multi-import" name="multi-import">
    
    <input type="hidden" name="video_name" value="{$video_name}" />

    <div>
        <label for="video_user">Add Video to User:</label>
        <input type="text" maxlength="100" size="40" name="video_user" id="video_user" value="{$smarty.post.video_user}" />
    </div>

    <div>
        <label for="video_title">Title:</label>
        <input type="text" maxlength="100" size="40" name="video_title" id="video_title" value="{$smarty.post.video_title}" />
    </div>

    <div>
        <label for="video_description">Description:</label>
        <textarea name="video_description" id="video_description" rows="4" cols="50">{$smarty.post.video_description}</textarea>
    </div>

    <div>
        <label for="video_keywords">Tags:</label>
        <input type="text" maxlength="120" size="40" name="video_keywords" id="video_keywords" value="{$smarty.post.video_keywords}" />
        (<i>Separate tags using a comma.</i>)
    </div>

    <div>
        <label>Video Channels:</label>
        <div style="padding-left:200px;">
            {section name=i loop=$chinfo}
              <input type="checkbox" name="chlist[]" id ="select_box" value="{$chinfo[i].channel_id}" />{$chinfo[i].channel_name_html}<br />
            {/section}
        </div>
    </div>

    <div style="padding-left:200px;">
        <i>Select between 1 to {$num_max_channels} channels that best describe your video.</i>
    </div>
    
    <div>
        <label for="video_privacy">Video Type:</label>
        <select name="video_privacy" id="video_privacy">
            <option value="public">Public</option>
            <option value="private">Private</option>
        </select>
    </div>
   
    <div class="submit">
        <input type="submit" name="submit" value="Import Videos" />
    </div>
            
</form>

{literal}
<script>
    $(function(){
        validate_multi_import_form();
    });
</script>
{/literal}

{/if}