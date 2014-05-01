{include file="admin/settings_menu.tpl"}

<h1>Miscellaneous Settings</h1>

<form method="post" action="">

    <div>
        <label for="video_rating">Rate a video:</label>
        <select name="video_rating" id="video_rating">
            <option value="Once" {if $video_rating =='Once'}selected="selected"{/if}>Once</option>
            <option value="Unlimited" {if $video_rating =='Unlimited'}selected="selected"{/if}>Unlimited</option>
        </select>
    </div>

    <div>
        <label for="admin_listing_per_page">Admin listing per page:</label>
        <input type="text" name="admin_listing_per_page" id="admin_listing_per_page" size="2" value="{$item_per_page}" />
    </div>

    <div class="clear:both;">
        <label for="num_channel_video">Number of videos in channel:</label>
        <input type="text" name="num_channel_video" id="num_channel_video" size="2" value="{$num_channel_video}" />
    </div>

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

    <div>
        <label for="php_path">PHP Path:</label>
        <input type="text" name="php_path" id="php_path" value="{$php_path}" />
    </div>

    <div>
        <label for="recommend_all">Recommend Video:</label>
        <select name="recommend_all" id="recommend_all">
            <option value="0" {if $recommend_all =='0'}selected="selected"{/if}>Members Only</option>
            <option value="1" {if $recommend_all =='1'}selected="selected"{/if}>Everyone</option>
        </select>
    </div>

    <div>
        <label for="allow_download">Allow Video Download:</label>
        <select name="allow_download" id="allow_download">
            <option value="0" {if $allow_download =='0'}selected="selected"{/if}>No</option>
            <option value="1" {if $allow_download =='1'}selected="selected"{/if}>Yes</option>
        </select>
    </div>

    <div>
        <label for="video_comments_per_page">Video Comments per page:</label>
        <input type="text" name="video_comments_per_page" id="video_comments_per_page" value="{$video_comments_per_page}" />
    </div>

    <div>
        <label for="video_comment_notify">Video Comment Notification:</label>
        <select name="video_comment_notify" id="video_comment_notify">
            <option value="0" {if $video_comment_notify =='0'}selected="selected"{/if}>No</option>
            <option value="1" {if $video_comment_notify =='1'}selected="selected"{/if}>Yes</option>
        </select>
    </div>

    <div>
        <label for="user_comments_per_page">User Comments per page:</label>
        <input type="text" name="user_comments_per_page" id="user_comments_per_page" value="{$user_comments_per_page}" /></label>
    </div>

    <div>
        <label for="editor_wysiwyg_admin">WYSIWYG Editor:</label>
        <select name="editor_wysiwyg_admin" id="editor_wysiwyg_admin">
            <option value="0" {if $editor_wysiwyg_admin =='0'}selected="selected"{/if}>Disable</option>
            <option value="1" {if $editor_wysiwyg_admin =='1'}selected="selected"{/if}>Enable</option>
        </select> (For Web Pages)
    </div>

    <div>
        <label for="editor_wysiwyg_email">WYSIWYG Editor:</label>
        <select name="editor_wysiwyg_email" id="editor_wysiwyg_email">
            <option value="0" {if $editor_wysiwyg_email =='0'}selected="selected"{/if}>Disable</option>
            <option value="1" {if $editor_wysiwyg_email =='1'}selected="selected"{/if}>Enable</option>
        </select> (For Email Templates)
    </div>

    <div>
        <label for="mail_abuse_report">Mail Admin on Abuse:</label>
        <select name="mail_abuse_report" id="mail_abuse_report">
            <option value="0" {if $mail_abuse_report =='0'}selected="selected"{/if}>No</option>
            <option value="1" {if $mail_abuse_report =='1'}selected="selected"{/if}>Yes</option>
        </select>
    </div>

    <div>
        <label for="num_max_channels">Max Channels per video:</label>
        <input type="text" name="num_max_channels" id="num_max_channels" value="{$num_max_channels}" />
    </div>

    <div>
        <label for="user_daily_mail_limit">Daily Mail Limit Per User:</label>
        <input type="text" name="user_daily_mail_limit" id="user_daily_mail_limit" value="{$user_daily_mail_limit}" />
    </div>

    <div>
        <label for="dailymotion_api_key">Dailymotion Api Key:</label>
        <input type="text" name="dailymotion_api_key" id="dailymotion_api_key" value="{$dailymotion_api_key}" /></label>
    </div>

    <div>
        <label for="dailymotion_api_secret">Dailymotion Api Secret:</label>
        <input type="text" name="dailymotion_api_secret" id="dailymotion_api_secret" value="{$dailymotion_api_secret}" /></label>
    </div>

    <div class="submit">
        <input type="submit" name="submit" value="Update" />
    </div>

</form>
