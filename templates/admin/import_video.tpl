<script language="JavaScript" type="text/javascript" src="{$base_url}/js/jquery.validate.min.js"></script>
<script language="JavaScript" type="text/javascript" src="{$base_url}/js/import_video.js"></script>

{if $finished eq ''}

<div class="page-header">
    <h1>Import Video</h1>
</div>

<form method="post" action="import_video.php" id="import-video" name="import-video" class="form-horizontal" role="form">

    <div class="form-group">
        <label class="col-sm-2 control-label" for="video_url">URL:</label>
        <div class="col-sm-5">
            <input class="form-control" type="text" maxlength="200" name="video_url" id="video_url" value="{$smarty.post.video_url}" />
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label" for="video_user">Add Video to User:</label>
        <input class="form-control" type="text" maxlength="100" name="video_user" id="video_user" value="{$smarty.post.video_user}" />
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label" for="video_title">Title:</label>
        <input class="form-control" type="text" maxlength="40" name="video_title" id="video_title" value="{$smarty.post.video_title}" />
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label" for="video_description">Description:</label>
        <textarea name="video_description" id="video_description" rows="4">{$smarty.post.video_description}</textarea>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label" for="video_keywords">Tags:</label>
        <input class="form-control" type="text" maxlength="120" name="video_keywords" id="video_keywords" value="{$smarty.post.video_keywords}" />
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label" for="chlist">Video Channels:</label>
        <div class="col-sm-5">
            {foreach from=$channels item=channel}
                <div class="checkbox">
                    <label for="channel-{$channel.channel_id}">
                        <input type="checkbox" id="chlist" name="chlist[]" value="{$channel.channel_id}" id="channel-{$channel.channel_id}" /> {$channel.channel_name_html}
                    </label>
                </div>
            {/foreach}
            <p class="help-block">Select between 1 to {$num_max_channels} channels that best describe your video.</p>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Video Type:</label>
        <select name="video_privacy">
            <option value="public">Public</option>
            <option value="private">Private</option>
        </select>
    </div>

    <div class="submit">
        <input class="form-control" type="submit" name="submit" value="Download Video" class="btn btn-default btn-lg" />
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
    <a href="import_video.php" class="btn btn-default btn-lg">Import Another Video</a>
</center>

{/if}