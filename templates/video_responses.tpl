<div class="response-body clearfix">

    <div class="video-info">
        <span class="video-title">{$view.video_info.video_title}</span>
        <div class="box1">
            <a href="{$base_url}/view/{$view.video_info.video_id}/{$view.video_info.video_seo_name}/">
                <img class="preview" src="{$view.video_info.video_thumb_url}/thumb/{$view.video_info.video_folder}1_{$view.video_info.video_id}.jpg" width="120px" height="90" />
            </a>
        </div>
        
        <div class="box2">
            <span class="video_title">
                <a href="{$base_url}/view/{$view.video_info.video_id}/{$view.video_info.video_seo_name}/">
                    {$view.video_info.video_title}
                </a>
            </span>
            
            <span class="video_description">
                {$view.video_info.video_description}
            </span>
            
            <span class="video_details">
                Added on  {$view.video_info.video_add_date|date_format}
            </span>
            
            <span class="video_details">
                Time: {$view.video_info.video_length} |
                Views: {$view.video_info.video_view_number} |
                Comments: {$view.video_info.video_com_num} |
                Rating: {insert name=show_rate assign=rate rte=$view.video_info.video_rate rated=$view.video_info.video_rated_by}{$rate}
            </span>
        </div>
    </div>
    
    <div class="user-info">
        {insert name=id_to_name assign=uname un=$view.video_info.video_user_id}
        <a href="{$base_url}/{$uname}">
            {insert name=member_img UID=$view.video_info.video_user_id}
        </a>
        <span>From: <a href="{$base_url}/{$uname}">{$uname}</a></span>
        {insert name=video_count assign=vdo_count type=public uid=$view.video_info.video_user_id}
        <span>Videos: {$vdo_count}</span>
    </div>
</div>

<div class="section bg2 clearfix">

    <div class="hd">
    
        <div class="hd-l">Video Responses</div>
        
        <div style="float:right;margin-right:1em;">
            Videos {$view.start_num}-{$view.end_num} of {$view.total}
        </div>
    
    </div>

    <div class="video_block clearfix">
       {section name=i loop=$view.videos}
            
           <div class="watch-video-box">

               <p class="video_title">
                   <a href="{$base_url}/view/{$view.videos[i].video_id}/{$view.videos[i].video_seo_name}/">
                       <img class="preview" src="{$view.videos[i].video_thumb_url}/thumb/{$view.videos[i].video_folder}1_{$view.videos[i].video_id}.jpg" width="120px" height="90" alt="{$view.videos[i].video_title}" />
                   </a>
               </p>

               <p class="video_title">
                   <a href="{$base_url}/view/{$view.videos[i].video_id}/{$view.videos[i].video_seo_name}/">{$view.videos[i].video_title|truncate:20:'...':true}</a>
               </p>

               <p class="video_details">
                   Added by: {insert name=id_to_name assign=uname un=$view.videos[i].video_user_id}<a href="{$base_url}/{$uname}" target="_parent">{$uname}</a>
               </p>

               <p class="video_details">
                   Time: {$view.videos[i].video_length}<br />
                   Views: {$view.videos[i].video_view_number} | {insert name=comment_count assign=commentcount vid=$view.videos[i].video_id}Comments: {$commentcount}
               </p>

               <p class="video_details">
                   {insert name=show_rate assign=rate rte=$view.videos[i].video_rate rated=$view.videos[i].video_rated_by}{$rate}
               </p>
                
                {if $smarty.session.UID eq $view.video_info.video_user_id}
                <p>
                    <form method="post" action="">
                        <input type="hidden" name="response_video_id" value="{$view.videos[i].video_id}" />
                        <input type="submit" name="remove_video" value="Remove" />
                    </form>
                </p>
                {/if}
                
           </div>
        {sectionelse}
            <br />
            <center><p>There is no response video found.</p></center>
        {/section}
    
    </div>
    
    {if $view.page_links ne ""}
        <div class="page_links">
            Pages: &nbsp; &nbsp; {$view.page_links}
        </div>
    {/if}
    
</div>