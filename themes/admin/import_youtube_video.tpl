<div class="page-header">
    <h1>Import Youtube Videos</h1>
</div>

<form method="post" action="" class="form-horizontal">
    <div class="form-group">
        <label class="control-label col-md-2">Youtube Video URL</label>
        <div class="col-md-4">
            <input type="url" name="url" id="url" class="form-control" value="{$video_url}" required placeholder="https://www.youtube.com/watch?v=SD8aha9">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-2">User</label>
        <div class="col-md-4">
            <input type="text" name="user" id="user" class="form-control" value="{$user}" required placeholder="Username">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-2">Channels</label>
        <div class="col-md-4">
            {foreach Channel::get() as $channel}
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="channels[]" value="{$channel['channel_id']}"> {$channel['channel_name']}
                </label>
            </div>
            {/foreach}
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-2">Privacy</label>
        <div class="col-md-4">
            <select name="privacy" id="privacy" class="form-control" required>
                <option value="public" selected>Public</option>
                <option value="private">Private</option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-2 col-md-offset-2">
            <input type="submit" name="submit" value="Import" class="btn btn-default btn-lg">
        </div>
    </div>
</form>