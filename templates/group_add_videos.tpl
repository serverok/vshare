{if $total gt "0"}

<div id="content">

    <div class="section">
    
        <div class="hd">
            <div class="hd-l">
                Add Videos to Group:
                <a href="{$base_url}/group/{$group_info.group_url}/">
                    {$group_info.group_name}
                </a>
            </div>
            <div class="hd-r">
                Videos {$start_num}-{$end_num} of {$total}
            </div>
        </div>
    
        {section name=i loop=$videos}
        
            <div class="video-entry bg2">
                
                <div class="box1">
                    <div class="preview default-img-adjust">
	                    <a href="{$base_url}/view/{$videos[i].video_id}/{$videos[i].video_seo_name}/">
	                        <img src="{$videos[i].video_thumb_url}/thumb/{$videos[i].video_folder}1_{$videos[i].video_id}.jpg" alt="" />
	                    </a>
	                    <div class="video-queue home-video-queue"  id="{$videos[i].video_id}_add" rel="video_queue">&nbsp;</div>
	                    <div class="video-time">{$videos[i].video_length}</div>
	                </div>
                </div>
                
                <div class="box2">
                    <p class="video-entry-title">
                        <a href="{$base_url}/view/{$videos[i].video_id}/{$videos[i].video_seo_name}/">{$videos[i].video_title}</a>
                    </p>
                    <p class="video-entry-description">
                        {$videos[i].video_description}
                    </p>
                    <p class="video-entry-tags">
                        <img src="{$img_css_url}/images/tags.gif" width="38" height="14" alt="" />:
                        {section name=j loop=$videos[i].video_keywords_array}
                            <a href="{$base_url}/tag/{$videos[i].video_keywords_array[j]}/">{$videos[i].video_keywords_array[j]}</a>&nbsp;
                        {/section}
                    </p>
                    
                    <p class="video-entry-details">
                        {insert name=time_to_date assign=todate tm=$videos[i].video_add_time}
                        Added: {$todate}<br /><br />
                        Views: {$videos[i].video_view_number} |
                        {insert name=comment_count assign=commentcount vid=$videos[i].video_id}
                        Comments: {$commentcount}
                    </p>
                    
                    {if $videos[i].in_group eq "0"}
                        <form name="addVideoForm" action="{$base_url}/group/{$group_info.group_url}/add/{$page}" method="post">
                            <input type="hidden" value="{$videos[i].video_id}" name="video_id" />
                            <input type="submit" class="button" value="Add to Group" name="add_video" />
                        </form>
                    {else}
                        <font color="green"><b>Already in group</b></font>
                    {/if}
                    
                </div>
                
            </div> <!-- video-entry -->
            
        {/section}

        {if $page_links ne ""}
            <div class="page_links">
                Pages: {$page_links}
            </div>
        {/if}

    </div> <!-- section  -->

</div> <!-- content -->

<div id="sidebar">

    <div class="section bg2">
    
        <div class="hd">
            <div class="hd-l">
                Share your videos !
            </div>
        </div>

        <div class="tags">
            My Tags:
            {section name=i loop=$view.group_add_video_keywords_array}
                <p><a href="{$base_url}/tag/{$view.group_add_video_keywords_array[i]}/">{$view.group_add_video_keywords_array[i]}</a></p>
            {/section}
        </div>
        
    </div>

</div>

{/if}