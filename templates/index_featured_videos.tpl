<div class="section">

    <div class="hd">
        <div class="hd-l">Today's Featured Videos</div>
        <div class="hd-r"><a href="{$base_url}/featured/">See More Videos</a></div>
    </div>
    
    {section name=i loop=$featured_videos}
    
        <div class="featured-block clearfix">

            <div class="box1">
                <div class="preview default-img-adjust">
                    <a href="{$base_url}/view/{$featured_videos[i].video_id}/{$featured_videos[i].video_seo_name}/">
                        <img src="{$featured_videos[i].video_thumb_url}/thumb/{$featured_videos[i].video_folder}1_{$featured_videos[i].video_id}.jpg" alt="{$featured_videos[i].video_title}" />
                    </a>
                    <div class="video-time">{$featured_videos[i].video_length}</div>
                </div>
            </div>
        
            <div class="box2">
            
                 <p class="video_title">
                    <a href="{$base_url}/view/{$featured_videos[i].video_id}/{$featured_videos[i].video_seo_name}/">{$featured_videos[i].video_title}</a>
                 </p>
            
                <p class="video_description">
                    {$featured_videos[i].video_description}
                </p>
            
                <p class="video_tags">
                    <img width="38" height="14" src="{$img_css_url}/images/tags.gif" alt="tags" />
                    {section name=j loop=$featured_videos[i].video_keywords_array}
                        <a href="{$base_url}/tag/{$featured_videos[i].video_keywords_array[j]}/">{$featured_videos[i].video_keywords_array[j]}</a>&nbsp;
                    {/section}
                </p>
            
                <p class="video_details">
                    {insert name=id_to_name assign=user_name un=$featured_videos[i].video_user_id}
                    {insert name=time_range assign=added_on field=video_add_time IDFR=video_id id=$featured_videos[i].video_id tbl=videos}
                    Added: {$added_on} by
                    <a href="{$base_url}/{$user_name}">
                        {$user_name}
                    </a>
                    <br />
                    Views: {$featured_videos[i].video_view_number} |
                    {insert name=comment_count assign=commentcount vid=$featured_videos[i].video_id}
                    Comments: {$commentcount}
                
                    {if $featured_videos[i].video_rated_by gt "0"}
                        {insert name=show_rate assign=rate rte=$featured_videos[i].video_rate rated=$featured_videos[i].video_rated_by}
                    {$rate}
                        ({$featured_videos[i].video_rated_by} ratings)
                    {else}
                        ( Not yet rated )
                    {/if}
                </p>
            
            </div> <!-- box2 -->

        </div>
        
    {/section}
    
</div>  <!-- section -->