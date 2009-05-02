<div class="section bg2">

    <div class="hd">
    
        <div class="hd-l">
            {$view.display_order}
            {if $channel_name ne ''}
                {$channel_name} videos
            {/if}
        </div>
        
        <div style="float:right;margin-right:1em;">
            Videos {$view.start_num}-{$view.end_num} of {$view.total}
        </div>
    
        <div class="hd-r" style="width:120px;">
            {if $channel_name eq ''}
                
                {if $view.view_type eq "detailed"}
                   <a  href="{$base_url}/{$view.category}/{$view.page}">Basic View</a>
                {else}
                    <a  href="{$base_url}/detailed/{$view.category}/{$view.page}">Detailed View</a>
                {/if}
            {/if}
        </div>
    
    </div>

    <div class="video_block clearfix">
    
        {if $smarty.request.view_type eq "" or $smarty.request.view_type eq "basic"}
        
            {section name=i loop=$view.videos}
            
                <div class="watch-video-box">
                
                    <p class="video_title">
                        <a href="{$base_url}/view/{$view.videos[i].video_id}/{$view.videos[i].video_seo_name}/">
                            <img class="preview" src="{$view.videos[i].video_thumb_url}/thumb/{$view.videos[i].video_folder}1_{$view.videos[i].video_id}.jpg" width="120px" height="90" alt="{$view.videos[i].video_title}" />
                        </a>
                    </p>
                
                    <p class="video_title">
                        <a href="{$base_url}/view/{$view.videos[i].video_id}/{$view.videos[i].video_seo_name}/">{$view.videos[i].video_title}</a>
                    </p>
                
                    <p class="video_details">
                        Added by: {insert name=id_to_name assign=uname un=$view.videos[i].video_user_id}<a href="{$base_url}/{$uname}" target="_parent">{$uname}</a>
                    </p>
                
                    <p class="video_details">
                        Time: {$view.videos[i].video_length}<br />
                        Views: {$view.videos[i].video_view_number} | {insert name=comment_count assign=commentcount vid=$view.videos[i].video_id}Comments: {$commentcount}
                    </p>
                
                    <p class="video_details">
                        {if $view.videos[i].video_rated_by gt "0"}
                            {insert name=show_rate assign=rate rte=$view.videos[i].video_rate rated=$view.videos[i].video_rated_by}
                            {$rate}
                        {else}
                            (not yet rated)
                        {/if}
                    </p>
                </div>
                
            {/section}
      
        {else}
            
            {section name=i loop=$view.videos}
            
               <div class="watch-detailed clearfix">
    
                    <div class="box1">
                        <a href="{$base_url}/view/{$view.videos[i].video_id}/{$view.videos[i].video_seo_name}/"><img class="preview" src="{$view.videos[i].video_thumb_url}/thumb/{$view.videos[i].video_folder}1_{$view.videos[i].video_id}.jpg" width="120px" height="90" alt="" /></a>
                        <a href="{$base_url}/view/{$view.videos[i].video_id}/{$view.videos[i].video_seo_name}/"><img class="preview" src="{$view.videos[i].video_thumb_url}/thumb/{$view.videos[i].video_folder}2_{$view.videos[i].video_id}.jpg" width="120px" height="90" alt="" /></a>
                        <a href="{$base_url}/view/{$view.videos[i].video_id}/{$view.videos[i].video_seo_name}/"><img class="preview" src="{$view.videos[i].video_thumb_url}/thumb/{$view.videos[i].video_folder}3_{$view.videos[i].video_id}.jpg" width="120px" height="90" alt="" /></a>
                    </div>
    
                    <div class="box2">
    
                        <p class="video_title">
                            <a href="{$base_url}/view/{$view.videos[i].video_id}/{$view.videos[i].video_seo_name}/">
                                {$view.videos[i].video_title}
                            </a>
                        </p>
    
                        <p class="video_description">
                            {$view.videos[i].video_description}
                        </p>
                        
                        <p class="video_details">
                            Added by: {insert name=id_to_name assign=user_name un=$view.videos[i].video_user_id}
                            <a href="{$base_url}/{$uname}" target="_parent">{$user_name}</a>
                        </p>
    
                        <p class="video_details">
                            Time: {$view.videos[i].video_length}<br />
                            Views: {$view.videos[i].video_view_number} |
                            {insert name=comment_count assign=commentcount vid=$view.videos[i].video_id}
                            Comments: {$commentcount}
                        </p>
                        
                        {if $view.videos[i].ratedby gt "0"}
                            {insert name=show_rate assign=rate rte=$view.videos[i].video_rate rated=$view.videos[i].video_rated_by}
                            {$rate}
                        {/if}
                        
                    </div>
                    
                </div> <!--watch-detailed-->
             
            {/section}
        
        {/if}
        
    </div> <!-- video_block -->
   
    {if $view.page_links ne ""}
        <div class="page_links">
            Pages: &nbsp; &nbsp; {$view.page_links}
        </div>
    {/if}

</div> <!-- section -->