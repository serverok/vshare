<div class="response-body clearfix">

    <div class="video-info">
    
        <span class="video-title">{$video_info.video_title}</span>
        <div class="box1">
            <div class="preview default-img-adjust">
	            <a href="{$base_url}/view/{$video_info.video_id}/{$video_info.video_seo_name}/">
	                <img src="{$video_info.video_thumb_url}/thumb/{$video_info.video_folder}1_{$video_info.video_id}.jpg" />
	            </a>
	            <div class="video-time">{$video_info.video_length}</div>
	        </div>
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

<div>
    <center>
    <form action="" method="post">
        <input type="submit" value="Accept this video" name="action" />
        <input type=submit value="Reject this video" name="action" onclick="return confirm('Are you sure you want to reject this request?');" />
    </form>
    </center>
</div>