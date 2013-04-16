{if $total gt "0"}

<div class="section">

    <div class="hd">
        <div class="hd-l">
            Search for:  {$search_string}
        </div>
        
        <div class="hd-r">
            Results <b>{$start_num}</b>-<b>{$end_num}</b> of <b>{$total}</b> for
            <b>{$search_string}</b>
        </div>
    </div>

    {section name=i loop=$video_info}

        <div class="search-videos bg2">
        
            <div class="box-1">
                <div class="preview search-videos-img-adjust">
	                <a href="{$base_url}/view/{$video_info[i].video_id}/{$video_info[i].video_seo_name}/">
	                    <img src="{$video_info[i].video_thumb_url}/thumb/{$video_info[i].video_folder}1_{$video_info[i].video_id}.jpg" alt="" />
	                </a>
	                <div class="video-queue" id="{$video_info[i].video_id}" rel="video_queue">&nbsp;</div>
	                <div class="video-time">{$video_info[i].video_length}</div>
                </div>
                
                <div class="preview search-videos-img-adjust">
	                <a href="{$base_url}/view/{$video_info[i].video_id}/{$video_info[i].video_seo_name}/">
	                    <img src="{$video_info[i].video_thumb_url}/thumb/{$video_info[i].video_folder}2_{$video_info[i].video_id}.jpg" alt="" />
	                </a>
	                <div class="video-time">{$video_info[i].video_length}</div>
	            </div>
                
                <div class="preview search-videos-img-adjust">
	                <a href="{$base_url}/view/{$video_info[i].video_id}/{$video_info[i].video_seo_name}/">
	                    <img src="{$video_info[i].video_thumb_url}/thumb/{$video_info[i].video_folder}3_{$video_info[i].video_id}.jpg" alt="" />
	                </a>
	                <div class="video-time">{$video_info[i].video_length}</div>
	            </div>
            </div>
        

            <div  class="box-2">
                
                <p class="video-entry-title">
                    <a href="{$base_url}/view/{$video_info[i].video_id}/{$video_info[i].video_seo_name}/">
                        {$video_info[i].video_title}
                    </a>
                </p>
                
                <p class="video-entry-description">
                    {$video_info[i].video_description}
                </p>
                
                <p class="video-entry-details">
                    {insert name=time_range assign=rtime field=video_add_time IDFR=video_id id=$video_info[i].video_id tbl=videos}
                    Added: {$rtime} by
                    <a href="{$base_url}/{$user_names[$video_info[i].video_user_id]}">{$user_names[$video_info[i].video_user_id]}</a>
                    <br /><br />
                    Views: {$video_info[i].video_view_number} |
                    Comments: {$video_info[i].video_com_num} |
                    {insert name=show_rate assign=rate rte=$video_info[i].video_rate rated=$video_info[i].video_rated_by}
                    {$rate}
                </p>
            </div>
        
        </div> <!-- search-videos -->
    
    {/section}
    
    <div class="clear"></div>
    
    {if $page_links ne ""}
        <div class="page_links" align="right">
            Pages: {$page_links} &nbsp;
        </div>
    {/if}

</div>  <!-- section -->

{/if}
