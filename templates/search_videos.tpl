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
                <a href="{$base_url}/view/{$video_info[i].video_id}/{$video_info[i].video_seo_name}/">
                    <img src="{$video_info[i].video_thumb_url}/thumb/{$video_info[i].video_folder}1_{$video_info[i].video_id}.jpg" width="120" height="90" alt="" class="preview"/>
                </a>
                
                <a href="{$base_url}/view/{$video_info[i].video_id}/{$video_info[i].video_seo_name}/">
                    <img src="{$video_info[i].video_thumb_url}/thumb/{$video_info[i].video_folder}2_{$video_info[i].video_id}.jpg" width="120" height="90" alt="" class="preview"/>
                </a>
                
                <a href="{$base_url}/view/{$video_info[i].video_id}/{$video_info[i].video_seo_name}/">
                    <img src="{$video_info[i].video_thumb_url}/thumb/{$video_info[i].video_folder}3_{$video_info[i].video_id}.jpg" width="120" height="90" alt="" class="preview"/>
                </a>
            </div>
        

              <div  class="box-2">
                
                <p class="video-entry-title">
                    <a href="{$base_url}/view/{$video_info[i].video_id}/{$video_info[i].video_seo_name}/">
                        {$video_info[i].video_title}
                    </a>
                </p>
                
                <p class="video-entry-description">
                    {$video_info[i].description}
                </p>
                
                <p class="video-entry-tags">
                    <img width="38" height="14" src="{$img_css_url}/images/tags.gif" alt="tags" />
                    {section name=j loop=$video_info[i].video_keywords_array}
                        <a href="{$base_url}/tag/{$video_info[i].video_keywords_array[j]}/">{$video_info[i].video_keywords_array[j]}</a>&nbsp;
                    {/section}
                </p>
                
                <p class="video-entry-details">
                    Channels:
                    {insert name=video_channel assign=channel vid=$video_info[i].video_id}
                    {section name=k loop=$channel}
                        <a href="{$base_url}/channel/{$channel[k].channel_id}/{$channel[k].channel_seo_name}/">{$channel[k].channel_name}</a>&nbsp;
                    {/section}
                    <br />
                    <br />
                    {insert name=time_range assign=rtime field=video_add_time IDFR=video_id id=$video_info[i].video_id tbl=videos}
                    {insert name=id_to_name assign=uname un=$video_info[i].video_user_id}
                    Added: {$rtime} by
                    <a href="{$base_url}/{$uname}">
                        {$uname}
                    </a>
                    <br /><br />
                    Runtime: {$video_info[i].video_length} | 
                    Views: {$video_info[i].video_view_number} |
                    {insert name=comment_count assign=commentcount vid=$video_info[i].video_id}
                    Comments: {$commentcount} 
                    <br /><br />
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