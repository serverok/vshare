{if $total gt "0"}

    <div id="content">
    
        <div class="section bg2">
        
            <div class="hd">
            
                <div class="hd-l">
                    Add Favorite Videos to Group:
                    <a href="{$base_url}/group/{$group_info.group_url}/">
                        {$group_name}
                    </a>
                </div>
                
                <div class="hd-r">
                    Videos {$start_num}-{$end_num} of {$total}
                </div>
                
            </div>

            {section name=i loop=$favorite_videos}
            
                <div class="video-entry bg2">
                
                    <div class="box1">
                        <div class="preview default-img-adjust">
	                        <a href="{$base_url}/view/{$favorite_videos[i].video_id}/{$favorite_videos[i].video_seo_name}/">
	                            <img src="{$favorite_videos[i].video_thumb_url}/thumb/{$favorite_videos[i].video_folder}1_{$favorite_videos[i].video_id}.jpg" alt="" />
	                        </a>
	                        <div class="video-time">{$favorite_videos[i].video_length}</div>
	                    </div>
                    </div>
                    
                    <div class="box2">
                        <p class="video-entry-title">
                            <a href="{$base_url}/view/{$favorite_videos[i].video_id}/{$favorite_videos[i].video_seo_name}/">
                                {$favorite_videos[i].video_title}
                            </a>
                        </p>
                        <p class="video-entry-description">
                            {$favorite_videos[i].video_description}
                        </p>
                        <p class="video-entry-tags">
                            <img width="38" height="14" src="{$img_css_url}/images/tags.gif" />:
                            {section name=j loop=$favorite_videos[i].video_keywords_array}
                                <a href="{$base_url}/tag/{$favorite_videos[i].video_keywords_array[j]}/">{$favorite_videos[i].video_keywords_array[j]}</a>&nbsp;
                            {/section}
                        </p>
                        <p class="video-entry-details">
                            {insert name=time_to_date assign=todate tm=$favorite_videos[i].video_add_time}
                            Added: {$todate} <br /><br />
                            Views: {$favorite_videos[i].video_view_number} |
                            {insert name=comment_count assign=commentcount vid=$favorite_videos[i].video_id}
                            Comments: {$commentcount}<br /><br />
                            Rating: {insert name=show_rate assign=vrate rte=$favorite_videos[i].video_rate rated=$favorite_videos[i].video_rated_by}{$vrate}
                        </p>
                        
                        {if $favorite_videos[i].in_group eq "0"}
                            <form name="addVideoForm" action="{$base_url}/group/{$group_info.group_url}/fav/{$page}" method="post">
                                <input type="hidden" value="{$favorite_videos[i].video_id}" name="video_id">
                                <input type="submit" class="button" value="Add to Group" name="add_video">
                            </form>
                        {else}
                            <font color="green"><b>ALREADY IN GROUP</b></font>
                        {/if}
                        
                    </div>
                     
                </div><!-- video-entry -->
            
            {/section}
            
            {if $page_links ne ""}
                <div class="page_links">
                    Pages: {$page_links}
                </div>
            {/if}
            
        </div> <!-- section -->
    
    </div> <!-- content-->
    
    <div id="sidebar">
    
        <div class="section bg2">
        
            <div class="hd">
                <div class="hd-l">Share your videos !</div>
            </div>
        
            <div class="tags">
                <b>My Tags :</b><br />
                {section name=i loop=$favorite_video_keywords_array}
                   <p><a href="{$base_url}/tag/{$favorite_video_keywords_array[i]|lower}/">{$favorite_video_keywords_array[i]}</a></p>
                {/section}
            </div>
            
        </div>
        
    </div>
    
{/if}