<script language="JavaScript" type="text/javascript" src="{$base_url}/js/jquery.validate.min.js"></script>
<script language="JavaScript" type="text/javascript" src="{$base_url}/js/import_video.js"></script>

{if $finished eq ''}

<h1>Import Video</h1>

<form method="post" action="import_video.php" id="import-video" name="import-video">

    <div>
        <label for="video_url">URL:</label>
        <input type="text" maxlength="200" size="40" name="video_url" id="video_url" value="{$smarty.post.video_url}" />
    </div>

    <div>
        <label for="video_user">Add Video to User:</label>
        <input type="text" maxlength="100" size="40" name="video_user" id="video_user" value="{$smarty.post.video_user}" />
    </div>

    <div>
        <label for="video_title">Title:</label>
        <input type="text" maxlength="40" size="40" name="video_title" id="video_title" value="{$smarty.post.video_title}" />
    </div>

    <div>
        <label for="video_description">Description:</label>
        <textarea name="video_description" id="video_description" rows="4" cols="40">{$smarty.post.video_description}</textarea>
    </div>

    <div>
        <label for="video_keywords">Tags:</label>
        <input type="text" maxlength="120" size="40" name="video_keywords" id="video_keywords" value="{$smarty.post.video_keywords}" />
    </div>

    <div>
        <label for="chlist">Video Channels:</label>
        <div class="indent">
            {section name=i loop=$channels}
               <input type="checkbox" id="chlist" name="chlist[]" value="{$channels[i].channel_id}" />
                {$channels[i].channel_name_html}<br />
            {/section}
            <i>Select between 1 to {$num_max_channels} channels that best describe your video.</i>
        </div>
    </div>

    <div>
        <label>Video Type:</label>
        <select name="video_privacy">
            <option value="public">Public</option>
            <option value="private">Private</option>
        </select>
    </div>

    <div class="submit">
        <input type="submit" name="submit" value="Download Video" class="btn btn-primary" />
    </div>

</form>

{literal}
<script>
$(function(){
    validate_import_video_form();
});
</script>
{/literal}

{else}

<br />
<center>
    <a href="import_video.php" class="btn btn-primary">Import Another Video</a>
</center>

{/if}