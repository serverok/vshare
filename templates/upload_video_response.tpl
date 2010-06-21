<h2>You are posting a video response to:</h2>
<div class="response-body clearfix">
    <div class="video-info">
        <span class="video-title">{$view.video_info.video_title}</span>
        <div class="box1">
            <a href="{$base_url}/view/{$video_info.video_id}/{$video_info.video_seo_name}/">
                <img class="preview" src="{$video_info.video_thumb_url}/thumb/{$video_info.video_folder}1_{$video_info.video_id}.jpg" width="120px" height="90" />
            </a>
        </div>
        
        <div class="box2">
            <span class="video_title">
                <a href="{$base_url}/view/{$video_info.video_id}/{$video_info.video_seo_name}/">
                    {$video_info.video_title}
                </a>
            </span>
            
            <span class="video_description">
                {$video_info.video_description}
            </span>
            
            <span class="video_details">
                Added on  {$video_info.video_add_date|date_format}
            </span>
            
            <span class="video_details">
                Time: {$video_info.video_length} |
                Views: {$video_info.video_view_number} |
                Comments: {$video_info.video_com_num} |
                Rating: {insert name=show_rate assign=rate rte=$video_info.video_rate rated=$video_info.video_rated_by}{$rate}
            </span>
        </div>
    </div>
    
    <div class="user-info">
        {insert name=id_to_name assign=uname un=$video_info.video_user_id}
        <a href="{$base_url}/{$uname}">
            {insert name=member_img UID=$video_info.video_user_id}
        </a>
        <span>From: <a href="{$base_url}/{$uname}">{$uname}</a></span>
        {insert name=video_count assign=vdo_count type=public uid=$video_info.video_user_id}
        <span>Videos: {$vdo_count}</span>
    </div>
</div>

<hr />

<div class="response-body clearfix">
    {if $video_response_added eq '0'}
    <div class="video-info" style="float: right;">
        {if $user_videos|@count gt '0'}
            <form method="post" action="">
           <select name="video_response_video_id" class="video-options" multiple="multiple">
               {section name=i loop=$user_videos}
                   <option value="{$user_videos[i].video_id}">
                      {if $user_videos[i].video_already_response eq '1'}
                      *
                      {/if}
                      {$user_videos[i].video_title}
                   </option>
               {/section}
           </select>
              <input type="hidden" name="video_response_to_video_id" value="{$video_info.video_id}" />
              <input type="submit" name="submit" class="button" value="Use the selected video" />
           </form>
        {else}
            <center><p>There is no video found.</p></center>
        {/if}
    </div>
    <div class="user-info">
        <h3>Choose one of your existing videos as a response</h3>
        <span>* Indicates the video has already been used for another video response. Selecting a video marked as already having been used will remove the old link.</span>
    </div>
    {else}
        <div class="vshare-success">
            <h3>You have successfully completed your Video Response! </h3>
            <span><small>Your video response will be posted after it has been approved by the video owner.</small></span>
        </div>
    {/if}
</div>