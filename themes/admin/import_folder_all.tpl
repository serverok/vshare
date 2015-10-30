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

<form method="post" action="" id="multi-import" name="multi-import" class="form-horizontal">

    <input type="hidden" name="video_name" value="{$video_name}" />

    <div class="form-group">
        <label for="video_user" class="control-label col-md-2">Add Video to User:</label>
        <div class="col-md-4">
            <input type="text" maxlength="100" size="40" name="video_user" id="video_user" value="{$smarty.post.video_user}" class="form-control">
        </div>
    </div>

    <div class="form-group">
        <label for="video_title" class="control-label col-md-2">Title:</label>
        <div class="col-md-4">
            <input type="text" maxlength="100" size="40" name="video_title" id="video_title" value="{$smarty.post.video_title}" class="form-control">
        </div>
    </div>

    <div class="form-group">
        <label for="video_description" class="control-label col-md-2">Description:</label>
        <div class="col-md-4">
            <textarea name="video_description" id="video_description" rows="4" cols="50" class="form-control">{$smarty.post.video_description}</textarea>
        </div>
    </div>

    <div class="form-group">
        <label for="video_keywords" class="control-label col-md-2">Tags:</label>
        <div class="col-md-4">
            <input type="text" maxlength="120" size="40" name="video_keywords" id="video_keywords" value="{$smarty.post.video_keywords}" class="form-control">
            <span class="help-block"><i>Separate tags using a comma.</i></span>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-md-2">Video Channels:</label>
        <div class="col-md-4">
            {section name=i loop=$chinfo}
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="chlist[]" id ="select_box" value="{$chinfo[i].channel_id}"> {$chinfo[i].channel_name_html}
                </label>
            </div>
            {/section}
            <span class="help-block"><i>Select between 1 to {$num_max_channels} channels that best describe your video.</i></span>
        </div>
    </div>

    <div class="form-group">
        <label for="video_privacy" class="control-label col-md-2">Video Type:</label>
        <div class="col-md-4">
            <select name="video_privacy" id="video_privacy" class="form-control">
                <option value="public">Public</option>
                <option value="private">Private</option>
            </select>
        </div>
    </div>

    <div  class="form-group">
        <div class="col-md-2 col-md-offset-2">
            <input type="submit" name="submit" value="Import Videos" class="btn btn-default btn-lg">
        </div>
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