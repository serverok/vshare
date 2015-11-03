<div class="form-group">
    <label class="col-sm-2 control-label" for="video_user">Add Video to User:</label>
    <div class= "col-sm-5">
        <input class="form-control" type="text" name="video_user" id="video_user" value="{if isset($smarty.post.video_user)}{$smarty.post.video_user}{/if}" required>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label" for="video_title">Title:</label>
    <div class="col-sm-5">
        <input class="form-control" type="text" name="video_title" id="video_title" value="{if isset($smarty.post.video_title)}{$smarty.post.video_title}{/if}" required>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label" for="video_description">Description:</label>
    <div class="col-sm-5">
        <textarea class="form-control" name="video_description" id="video_description" rows="4" required>{if isset($smarty.post.video_description)}{$smarty.post.video_description}{/if}</textarea>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label" for="video_keywords">Tags:</label>
    <div class="col-sm-5">
        <input class="form-control" type="text" name="video_keywords" id="video_keywords" value="{if isset($smarty.post.video_keywords)}{$smarty.post.video_keywords}{/if}" required>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label" for="chlist">Video Channels:</label>
      <div class="col-sm-5">
        {foreach from=$channels item=channel}
            <div class="checkbox">
                <label for="channel-{$channel.channel_id}">
                    <input type="checkbox" name="chlist[]" value="{$channel.channel_id}" id="channel-{$channel.channel_id}"> {$channel.channel_name_html}
                </label>
            </div>
        {/foreach}
        <p class="help-block">Select between 1 to {$num_max_channels} channels that best describe your video.</p>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Video Type:</label>
    <div class="col-sm-5">
        <select class="form-control" name="video_privacy" required>
            <option value="public"{if $smarty.post.video_privacy eq 'public'} selected{/if}>Public</option>
            <option value="private"{if $smarty.post.video_privacy eq 'private'} selected{/if}>Private</option>
        </select>
    </div>
</div>