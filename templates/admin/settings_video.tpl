<h1>Video Settings</h1>

<form method="post" action="">

    <div>
        <label for="process_upload">Video Processing:</label>
        <select name="process_upload" id="process_upload">
            <option value="0" {if $process_upload =='0'}selected="selected"{/if}>Batch Processing</option>
            <option value="1" {if $process_upload =='1'}selected="selected"{/if}>Realtime Processing</option>
            <option value="2" {if $process_upload =='2'}selected="selected"{/if}>Background Processing</option>
        </select>
    </div>

    <div>
        <label for="tool_video_thumb">Make Video Thumbnails with:</label>
        <select name="tool_video_thumb" id="tool_video_thumb">
            <option value="mplayer" {if $tool_video_thumb =='mplayer'}selected="selected"{/if}>mplayer</option>
            <option value="ffmpeg" {if $tool_video_thumb =='ffmpeg'}selected="selected"{/if}>ffmpeg</option>
            <option value="ffmpeg-php" {if $tool_video_thumb =='ffmpeg-php'}selected="selected"{/if}>ffmpeg-php</option>
        </select>
    </div>

    <div>
       <label for="flv_metadata">Metadata:</label>
        <select name="flv_metadata" id="flv_metadata">
            <option value="yamdi" {if $flv_metadata =='yamdi'}selected="selected"{/if}>yamdi</option>
            <option value="flvtool" {if $flv_metadata =='flvtool'}selected="selected"{/if}>flvtool</option>
            <option value="none" {if $flv_metadata =='none'}selected="selected"{/if}>None</option>
        </select>
    </div>

    <div>
        <label for="process_notify_user">Notify user after processing:</label>
        <select name="process_notify_user" id="process_notify_user">
            <option value="0" {if $process_notify_user =='0'}selected="selected"{/if}>No</option>
            <option value="1" {if $process_notify_user =='1'}selected="selected"{/if}>Yes</option>
        </select>
    </div>

    <div>
        <label for="video_flv_delete">Delete FLV from Server:</label>
        <select name="video_flv_delete" id="video_flv_delete">
            <option value="0" {if $video_flv_delete =='0'}selected="selected"{/if}>No</option>
            <option value="1" {if $video_flv_delete =='1'}selected="selected"{/if}>Yes</option>
        </select>
    </div>

    <div>
        <label for="guest_upload">Allow Guest Uploads:</label>
        <select name="guest_upload" id="guest_upload">
            <option value="0" {if $guest_upload =='0'}selected="selected"{/if}>No</option>
            <option value="1" {if $guest_upload =='1'}selected="selected"{/if}>Yes</option>
        </select>
    </div>

    <div>
        <label for="guest_upload_user" >Guest Upload Added to:</label>
        <input type="text" name="guest_upload_user" id="guest_upload_user" value="{$guest_upload_user}" />
    </div>

    <div class="submit">
        <input type="submit" name="submit" value="Update" class="btn btn-primary" />
    </div>

</form>