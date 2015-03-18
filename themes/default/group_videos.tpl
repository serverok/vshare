{if $is_mem eq "" and $group_info.group_type eq "private"}

<h5>Sorry! You are not allowed to view this private group.</h5>

{elseif $total gt "0"}

<div id="content">

    <div class="section bg2">
        <div class="hd">
            <div class="hd-l"><a href="{$base_url}/group/{$group_info.group_url}/">{$group_info.group_name}</a> Videos</div>
            <div class="hd-r">Videos {$start_num}-{$end_num} of {$total}</div>
        </div>

        {section name=i loop=$group_videos}

            <div class="video-entry bg2">

                <div class="box1">
                    <div class="preview default-img-adjust">
	                    <a href="{$base_url}/view/{$group_videos[i].video_id}/{$group_videos[i].video_seo_name}/">
	                        <img src="{$group_videos[i].video_thumb_url}/thumb/{$group_videos[i].video_folder}1_{$group_videos[i].video_id}.jpg" alt="" />
	                    </a>
	                    <div class="video-queue" id="{$group_videos[i].video_id}" rel="video_queue">&nbsp;</div>
	                    <div class="video-time">{$group_videos[i].video_length}</div>
	                </div>

                    {if $smarty.session.UID eq $group_info.group_owner_id and $group_videos[i].group_video_approved eq "no"}
                        <form action="{$base_url}/group_videos.php?group_url={$group_info.group_url}&gid={$group_info.group_id}&page={$page}" method="post">
                            <input type="hidden" name="video_id" value="{$group_videos[i].video_id}" />
                            <input type="submit" class="button" name="approve_it" value="Approve It" />
                        </form>
                    {/if}

                    {if $smarty.session.UID eq $group_info.group_owner_id}
                        <form action="{$base_url}/group_videos.php?group_url={$group_info.group_url}&gid={$group_info.group_id}&page={$page}" method="post" onsubmit="javascript: return confirm('Are you sure to delete this video from the group?');">
                            <input type="hidden" name="video_id" value="{$group_videos[i].video_id}" />
                            <input type="submit" class="button" name="remove_image" value="Remove From Group" />
                        </form>
                        {if $group_info.group_image eq "owner_only"}
                            <form action="{$base_url}/group/{$group_info.group_url}/videos/{$page}" method="post">
                                <input type="hidden" name="video_id" value="{$group_videos[i].video_id}" />
                                <input type="submit" class="button" name="group_image" value="Make Default Image" />
                            </form>
                        {/if}
                    {/if}
                </div>

                <div class="box2">
                    <p class="video-entry-title">
                        <a href="{$base_url}/view/{$group_videos[i].video_id}/{$group_videos[i].video_seo_name}/">{$group_videos[i].video_title}</a>
                    </p>
                    <p class="video-entry-description">{$group_videos[i].video_description}</p>
                    <p class="video-entry-tags">
                        <img width="38" height="14" src="{$img_css_url}/images/tags.gif" alt="tags" />
                        {section name=j loop=$group_videos[i].group_video_keywords}
                            <a href="{$base_url}/tag/{$group_videos[i].group_video_keywords[j]}/">{$group_videos[i].group_video_keywords[j]}</a>&nbsp;
                        {/section}
                    </p>
                    <p class="video-entry-details">
                        {insert name=time_to_date assign=todate tm=$group_videos[i].video_add_time}
                        {insert name=id_to_name assign=uname un=$group_videos[i].video_user_id}
                        Added: {$todate} by <a href="{$base_url}/{$uname}">{$uname}</a><br /><br />
                        Views: {$group_videos[i].video_view_number} |
                        {insert name=comment_count assign=commentcount vid=$group_videos[i].video_id}
                        Comments: {$commentcount}<br /><br />
                        Rating: {insert name=show_rate assign=vrate rte=$group_videos[i].video_rate rated=$group_videos[i].video_rated_by}{$vrate}
                    </p>
                </div>
                
            </div> <!-- video-entry -->
            
        {/section}
        
        {if $total gt $items_per_page}
            <div class="page_links">Pages: {$page_links}</div>
        {/if}
    </div>  <!-- section -->

</div><!-- content -->

<div id="sidebar">

    <div class="section bg2">
        <div class="hd">
            <div class="hd-l"><a href="{$base_url}/invite_members.php?urlkey={$group_info.group_url}">Share your videos </a></div>
        </div>

        <div class="tags">
            <b>My Tags:</b>
            {section name=jj loop=$view.group_video_keywords_array}
                <p><a href="{$base_url}/tag/{$view.group_video_keywords_array[jj]}/">{$view.group_video_keywords_array[jj]}</a></p>
            {/section}
            
        </div>
    </div>
      
</div>

{else}

<h5>There is no video in this group</h5>

{/if}