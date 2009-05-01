<script language="JavaScript" type="text/javascript" src="{$base_url}/js/jquery.validate.min.js"></script>
<script language="JavaScript" type="text/javascript" src="{$base_url}/js/video_add_flv.js"></script>

<h1>Add FLV URL</h1>

<p>Allow you to add FLV video or stream url that is hosted (hotlinking) on remote server 
(keeping video on remote server).</p>

<form action="video_add_flv.php" id="video_add_flv" name="video_add_flv" method="post">

    <div>
        <label for="video_user">Add Video to User:</label>
        <input maxlength="100" size="40" name="video_user" id="video_user" value="{$smarty.post.video_user}" />
    </div>
    
    <div>
        <label for="video_title">Title:</label>
        <input maxlength="60" size="40" name="video_title" id="video_title" value="{$smarty.post.video_title}" />
    </div>
        
    <div>
        <label for="video_description">Description:</label>
        <textarea name="video_description" id="video_description" rows="4" cols="50">{$smarty.post.video_description}</textarea>
    </div>
        
    <div>
        <label for="video_keywords">Tags:</label>
        <input maxlength="120" size="40" name="video_keywords" id="video_keywords" value="{$smarty.post.video_keywords}" />
        (<i>Separate tags using a comma.</i>)
    </div>
        
    <div>
        <label>Video Channels:</label>
        <div class="indent">
            {$ch_checkbox}
            <i>Select between 1 to {$num_max_channels} channels that best describe your video.</i>
        </div>
    </div>

    <div>
        <label for="video_privacy">Video Type:</label>
        <select name="video_privacy" id="video_privacy">
            <option value="public">Public</option>
            <option value="private">Private</option>
        </select>
    </div>

    <div class="submit">
        <input type="submit" value="Add Flv Url" name="submit" id="submit" />
    </div>

</form>