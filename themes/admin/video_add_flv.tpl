<div class="page-header">
    <h1>Add FLV URL</h1>
</div>

<script language="JavaScript" type="text/javascript" src="{$base_url}/js/jquery.validate.min.js"></script>
<script language="JavaScript" type="text/javascript" src="{$base_url}/js/video_add_flv.js"></script>


<p>Allow you to add FLV video or stream url that is hosted (hotlinking) on remote server
(keeping video on remote server).</p>

<form action="video_add_flv.php" id="video_add_flv" name="video_add_flv" method="post" class="form-horizontal">

    <div class="form-group">
        <label class="col-sm-2 control-label" for="video_user">Add Video to User:</label>
        <div class="col-sm-5">
            <input class="form-control" maxlength="100" name="video_user" id="video_user" value="{$smarty.post.video_user}" />
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label" for="video_title">Title:</label>
        <div class="col-sm-5">
            <input class="form-control" maxlength="60" name="video_title" id="video_title" value="{$smarty.post.video_title}" />
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label" for="video_description">Description:</label>
        <div class="col-sm-5">
        <textarea class="form-control" name="video_description" id="video_description" rows="4">{$smarty.post.video_description}</textarea>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label" for="video_keywords">Tags:</label>
        <div class="col-sm-5">
            <input class="form-control" maxlength="120" name="video_keywords" id="video_keywords" value="{$smarty.post.video_keywords}" />
            <p class="help-block">Separate tags using a comma.</p>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Video Channels:</label>
        <div class="col-sm-5">
            <select name="channel" required="required" class="form-control">
                <option value="">--SELECT--</option>
                {foreach $channels as $channel}
                    <option value="{$channel['channel_id']}">{$channel['channel_name']}</option>
                {/foreach}
            </select>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label" for="video_privacy">Video Type:</label>
        <div class="col-sm-5">
            <select class="form-control" name="video_privacy" id="video_privacy">
                <option value="public">Public</option>
                <option value="private">Private</option>
            </select>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-5">
            <button type="submit" name="submit" class="btn btn-default btn-lg">Add Flv Url</button>
        </div>
    </div>

</form>
