<div id="content">

    <div class="section bg2">
    
        <div class="hd">
            <div class="hd-l">
                {$category}
            </div>
            <div class="hd-r">
                <a href="{$base_url}/recent/">
                    Groups {$start_num} - {$end_num} of {$total} 
                </a>
            </div>
        </div>
    
        {section name=i loop=$group_info}
        
            {insert name=group_image assign=group_image_info gid=$group_info[i].group_id tbl=group_videos}
            {insert name=group_info_count assign=gmemcount tbl=group_members gid=$group_info[i].group_id query="1" field1=group_member_approved field2=group_member_group_id}
            {insert name=group_info_count assign=gvdocount tbl=group_videos gid=$group_info[i].group_id query="1" field1=group_video_approved field2=group_video_group_id}

        
            <div class="video-entry bg2">

                <div class="box1">
                    <a href="{$base_url}/group/{$group_info[i].group_url}/">
                        {if $group_image_info eq "0"}
                            <img class="preview" src="{$img_css_url}/images/no_videos_groups.gif" width="120" height="90" alt="videos groups" />
                        {else}
                            <img class="preview" src="{$group_image_info.video_thumb_url}/thumb/{$group_image_info.video_folder}1_{$group_image_info.video_id}.jpg" width="120" height="90" alt="{$group_image_info.video_folder}" />
                        {/if}
                    </a>   
                </div>

                <div class="box2">
                
                    <p class="video-entry-title">
                        <a href="{$base_url}/group/{$group_info[i].group_url}/">
							{$group_info[i].group_name}
                        </a>
                    </p>

                    <p class="video-entry-description">
                        {$group_info[i].group_description}
                    </p>

                    <p class="video-entry-tags">
                        <img width="38" height="14" src="{$img_css_url}/images/tags.gif" alt="tags" />: 
                        {$group_info[i].group_keyword}
                    </p>

                    <p class="video-entry-details">
                        Status : {$group_info[i].group_type} <br />
                        {insert name=time_to_date assign=todate tm=$group_info[i].group_create_time}<br />
                        Created : {$todate}<br /><br />
                        <a href="{$base_url}/group/{$group_info[i].group_url}/members/1">{$gmemcount} Members</a> |
                        <a href="{$base_url}/group/{$group_info[i].group_url}/videos/1">{$gvdocount} Videos</a>
                    </p>
                    
                </div> 
                
            </div> <!-- video-entry -->
    
        {/section}
    
        {if $page_links ne ""}
            <div class="page_links">Pages: {$page_links}</div>
        {/if}

    </div> <!-- section -->

</div> <!-- content -->

<div id="sidebar">

    <div class="section bg2">
    
        <div class="hd">Browse Groups</div>
    
        <div class="margin-1em">
           <a href="{$base_url}/groups/featured/1">Featured</a><br />
            <a href="{$base_url}/groups/recent/1">Most Recent</a><br />
            <a href="{$base_url}/groups/members/1">Most Members</a><br />
            <a href="{$base_url}/groups/videos/1">Most Videos</a><br />
            <a href="{$base_url}/groups/topics/1">Most Topics</a>
        </div>
    
    </div> <!-- section -->

    <div class="section bg2">
    
        <div class="hd">           
                Groups By Channel
        </div>
    
        <div class="channels">
            {section name=k loop=$channels}
                {insert name=group_count assign=gcount chid=$channels[k].channel_id}
                <p><a href="{$base_url}/groups/{$channels[k].channel_id}/{$channels[k].channel_seo_name}/1">{$channels[k].channel_name_html}</a>&nbsp;({$gcount})</p>
            {/section}
        </div>
    
    </div> <!-- section -->
   
</div> <!-- sidebar -->