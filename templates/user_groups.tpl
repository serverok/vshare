{if $total ne "0"}

    <div id="content">
    
        <div class="section bg2">
        
            <div class="hd">
                <div class="hd-l">
                    {$user_info.user_name}'s Groups
                </div>
                <div class="hd-r">
                    Results {$start_num}-{$end_num} of {$total}
                </div>
            </div>
        
            {section name=i loop=$groups}
            
                {insert name=group_image assign=group_image_info gid=$groups[i].group_id tbl=group_videos}
                {insert name=time_to_date assign=todate tm=$groups[i].group_create_time}
        
                <div class="video-entry bg2">
                
                    <div class="box1">
                        <a href="{$base_url}/group/{$groups[i].group_url}/">
                            {if $group_image_info eq "0"}
                                <img class="preview" src="{$img_css_url}/images/no_videos_groups.gif" width="120px" height="90" alt="" />
                            {else}
                                <img height="90" src="{$group_image_info.video_thumb_url}/thumb/{$group_image_info.video_folder}1_{$group_image_info.video_id}.jpg" alt="" />
                            {/if} 
                        </a>
                        {if $groups[i].group_owner_id eq $smarty.session.UID}
                             <font color="#009900"><b>(Group owner)</b></font>
                        {/if}
                    </div>
                
                    <div class="box2">
                        <p class="video-entry-title">
                            <a href="{$base_url}/group/{$groups[i].group_url}/">
                                {$groups[i].group_name}
                            </a>
                            {insert name=row_count assign=num_group_members group_id=$groups[i].group_id table=group_members field1=group_member_group_id field2=group_member_approved}
                            ({$num_group_members} members)
                        </p>
                        
                        <p class="video-entry-description">
                            {$groups[i].group_description}
                        </p>
                        
                        <p class="video-entry-details">
                            Status : {$groups[i].group_type} <br /><br />
                            Created : {$todate} <br /><br />
                        </p>
                    </div>
                    
                </div> <!-- video-entry  -->
            
            {/section}
            
            {if $page_links ne ""}
                <div class="page_links">Pages: {$page_links}</div>
            {/if}
        
        </div> <!-- section -->
        
    </div> <!-- content -->
    
    <div id="sidebar">
    
        <div class="section bg2">
            <div class="hd">
                <div class="hd-l">
                    <a href="{$base_url}/invite_friends.php">Share your videos</a>!
                </div>
            </div>
        
            <div class="tags"><b>Group Tags:</b>
                {section name=i loop=$view.user_group_keywords_array}
                <p><a href="{$base_url}/tag/{$view.user_group_keywords_array[i]}/">{$view.user_group_keywords_array[i]}</a></p>
                {/section}
            </div>
        </div> <!-- section -->
    
    </div> <!-- sidebar -->

{else}

    <div align="center">
        <p>This user is not a member of any groups.</p>
        {if $smarty.session.USERNAME == $user_info.user_name}
            <p><a href="{$base_url}/group/new/">Click here</a> to create a group now</p>
        {/if}
    </div>

{/if}