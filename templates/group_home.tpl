<div id="content" class="bg2">

    {if $group_info ne ""}

    <div class="section">
    
        <div class="hd">
            <div class="hd-l">
                Group : 
                <a href="{$base_url}/group/{$group_info.group_url}/">
                    {$group_info.group_name}
                </a>
            </div>
        </div>

        {if $show_group ne 1}

            <div align="center">
                Sorry! You are not allowed to view this private group.
            </div>

        {else}

            <div id="group-home-info">
            
                <h3>{$group_info.group_name}</h3>
                          
                <div class="box1">
                
                    {insert name=group_info_count assign=gmemcount tbl=group_members gid=$group_info.group_id query="1" field1=group_member_approved field2=group_member_group_id}
                    {insert name=group_info_count assign=gvdocount tbl=group_videos gid=$group_info.group_id query="1" field1=group_video_approved field2=group_video_group_id}
                    {insert name=group_info_count assign=gtpscount tbl=group_topics gid=$group_info.group_id query="1" field1=group_topic_approved field2=group_topic_group_id}
                    {insert name=check_group_mem assign=checkmem gid=$group_info.group_id}
                    {insert name=group_image assign=group_image_info gid=$group_info.group_id tbl=group_videos}
                
                    {if $group_image_info eq "0"}
                        <img class="preview" src="{$img_css_url}/images/no_videos_groups.gif" width="120" height="90" alt="" />
                    {else}
                        <img class="preview" src="{$group_image_info.video_thumb_url}/thumb/{$group_image_info.video_folder}1_{$group_image_info.video_id}.jpg" width="120" height="90" alt="" />
                    {/if}
        
                    {if $smarty.session.UID ne "" and $checkmem ne "0"}
                    
                        {if $smarty.session.UID eq $group_info.group_owner_id}
                            <a href="{$base_url}/group/{$group_info.group_url}/edit/">Edit this Group</a><br />
                            {if $smarty.session.UID eq $group_info.group_owner_id and $group_info.group_upload eq "owner_only"}
                                <a href="{$base_url}/group/{$group_info.group_url}/add/1">Add Videos</a><br />
                            {/if}
                    
                            {if $group_info.group_upload ne "owner_only"}
                                <a href="{$base_url}/group/{$group_info.group_url}/add/1">Add Videos</a><br />
                            {/if}
                            <a href="{$base_url}/group/{$group_info.group_url}/invite/">Invite Members</a><br />
                    
                        {else}

                            <div style="padding-bottom: 5px; padding-top: 5px" align="center">
                                <table cellspacing="0" cellpadding="2" width="130" align="center" border="0">
                                    <tr>
                                        {if $is_member eq "yes"}
                                            <td width="120" align="center">
                                                {if $smarty.session.UID eq $group_info.group_owner_id and $group_info.group_upload eq "owner_only"}
                                                    <a href="{$base_url}/group/{$group_info.group_url}/add/1">Add Videos</a><br />
                                                {/if}
                                                {if $group_info.group_upload ne "owner_only"}
                                                    <a href="{$base_url}/group/{$group_info.group_url}/add/1">Add Videos</a><br />
                                                {/if}

                                                {if $group_info.group_type ne "private" or $smarty.session.UID eq $group_info.group_owner_id}
                                                    <a href="{$base_url}/group/{$group_info.group_url}/invite/">Invite Members</a><br />
                                                {/if}
                                            </td>
                                        {/if}
                                    </tr>
                                </table>
                            </div>
                        {/if}
                    {/if}
                
                </div> <!-- box1 end -->

                <div class="box2">
                
                    <p class="video-entry-title">{$group_info.group_description}</p>
                    
                    <p class="video-entry-tags">
                        <img width="38" height="14" src="{$img_css_url}/images/tags.gif" alt="" />: {$group_info.group_keyword} 
                    </p>
                    
                    <p class="video-entry-details">
                        Channel:
                        {insert name=video_channel assign=grpchannel tbl=groups gid=$group_info.group_id}
                        {section name=k loop=$grpchannel}
                        <a href="{$base_url}/channel/{$grpchannel[k].channel_id}/{$grpchannel[k].channel_seo_name}/">{$grpchannel[k].channel_name}</a>&nbsp;
                        {/section}
                        <br />
                        Type:{$group_info.group_type}
                        <br />
                        Videos:
                        <a href="{$base_url}/group/{$group_info.group_url}/videos/1">{$gvdocount}</a>
                        
                        {if $smarty.session.UID eq $group_info.group_owner_id}
                            {if $total_new_video ne "0"}
                                &nbsp;&nbsp;&nbsp;<b>({$total_new_video} new)</b>
                            {/if}
                        {/if}

                        <br />
                        Members:
                        <a href="{$base_url}/group/{$group_info.group_url}/members/1">{$gmemcount}</a>
                        {if $smarty.session.UID eq $group_info.group_owner_id}
                            {if $total_new_member ne "0"}
                                &nbsp;&nbsp;&nbsp;<b>({$total_new_member} new)</b>
                            {/if}
                        {/if}
                        <br />
                        {insert name=id_to_name assign=uname un=$group_info.group_owner_id}
                        Created By:<a href="{$base_url}/{$uname}">{$uname}</a><br />
                        Membership Status: <b>
                        
                        {if $smarty.session.UID eq $group_info.group_owner_id}
                            <font color="green">You are the owner of this group.</font>
                        {elseif $is_member eq "no"}
                            <font color="#ffcc00">Your request is sent to the owner.</font>
                        {elseif $is_member eq "yes"}
                            You are member of this group.
                        {else}
                            You are not a member of this group.
                        {/if}
                        
                        </b> 
                        <br />
                        Group URL:
                        <a href="{$base_url}/group/{$group_info.group_url}/">{$base_url}/group/{$group_info.group_url}/</a>
                        <br />
                    </p>

                    <div>
                        {if $smarty.session.UID ne $group_info.group_owner_id}
                            <form method="GET" action="{$base_url}/group_join.php">
                                <input type="hidden" name="group_id" value="{$group_info.group_id}" />
                                {if $checkmem eq "0" && $group_info.group_type ne 'private'}
                                    <input type="hidden" name="action" value="join" />
                                    <input type="submit" name="submit" value="Join to this Group" />
                                {elseif $is_member eq "yes"}
                                    <input type="hidden" name="action" value="remove" />
                                    <input type="submit" name="submit" value="Leave this Group" />
                                {/if}
                            </form>
                        {/if}
                    </div>

                </div> <!-- box2 -->
    
            </div> <!-- group-home-info --> 

            <div class="clearfix"></div>

            <!--Topics  start -->             

            <!--
            
            <br />
            
            <div class="bg2">

                <div id="display_topics">&nbsp;</div>
                
                    {if $smarty.session.UID ne ""}
                        {if $smarty.session.UID eq $group_info.group_owner_id or $group_info.group_posting ne 'owner_only'}
                            {if $checkmem ne "0"}
                                {if $is_member eq "yes"}
                                    <div id="add_topic_msg">
                                        &nbsp;
                                    </div>
                                        <div id="add_topic">
                                    
                                        <div style="padding-left: 5px; font-weight: bold; padding-bottom: 5px; color: #808080; padding-top: 8px">
                                            Add New Topic:
                                        </div>
                                        
                                        <div style="padding-left: 5px; padding-bottom: 5px">

                                            <form name=add_group_topic action="javascript:void(0);" method="post">
                                                <textarea tabindex="2" name="topic_title" rows="3" cols="55"></textarea>
                                                <br />Attach a video:
                                                <select name="topic_video">{$video_ops}</select>
                                                <input type="hidden" name="group_id" value="{$group_info.group_id}" />
                                                <input type="hidden" name="group_url" value="{$group_info.group_url}" />
                                                <input type="submit" value="Add Topic" name="add_topic" onclick="add_topics();" />
                                            </form>

                                        </div>
                                    </div>
                                {/if}
                            {else}
                                <div align="center">
                                    <b>You need to join this group to post a topic.</b>
                                    <br /><br />
                                </div>
                            {/if}
                        {/if}
                    {else}
                        <br /><br />
                        <div style="padding-left: 5px; font-weight: bold; padding-bottom: 5px; color: #444;
                            padding-top: 8px" align="center">
                            Please <a href="{$base_url}/login/">Login</a> to post new topic
                        </div>
                    {/if}
                </div>
                -->
                
               <!--Topic section end-->
           
            </div> <!-- section -->

            <br />

            <div class="section bg2 clearfix">

                <div class="hd">
                    <div class="hd-l">
                        Recently Added Videos
                    </div>
                    <div class="hd-r">
                        <a href="{$base_url}/group/{$group_info.group_url}/videos/1">
                            View All Videos
                        </a>
                    </div>
                </div>
                
                <ul id="user-video">
                    {section name=i loop=$group_videos}
                    <li>
                        <a href="{$base_url}/view/{$group_videos[i].video_id}/{$group_videos[i].video_seo_name}/">
                            <img class="preview" src="{$group_videos[i].video_thumb_url}/thumb/{$group_videos[i].video_folder}1_{$group_videos[i].video_id}.jpg" width="120" height="90" alt="" />
                            <br />
                            {$group_videos[i].video_title}
                        </a>
                    </li>
                    {/section}
                </ul>

            </div> <!-- section -->

            <br />
    
            <div class="section bg2">

                <div class="hd">
                    <div class="hd-l">
                        Recent Members
                    </div>
                    <div class="hd-r">
                        <a href="{$base_url}/group/{$group_info.group_url}/members/1">
                            View All Members
                        </a>
                    </div>
                </div>

                <ul id="user-video">
                    {section name=i loop=$group_members}
                        <li>
                        {insert name=id_to_name assign=uname un=$group_members[i].user_id}
                        <a href="{$base_url}/{$uname}/">
                            {insert name=member_img UID=$group_members[i].user_id}
                            <br />
                            {$uname}
                        </a>
                        </li>
                    {/section}
                </ul>
                
            </div>
            
        {/if}
        
    {/if}

</div> <!-- content -->

<div id="sidebar">
   {insert name=advertise adv_name='wide_skyscraper'}
</div>