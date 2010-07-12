<div id="content">
    
    <center>
        <div id="flash_recent_videos" align="center"></div>
    </center>

    <div id="watch-uplod-share" class="clearfix">

        <div class="watch">
            <a href="{$base_url}/recent/"><span>Watch</span></a>
            Better than TV watch what you want when you want it!
        </div>

        <div class="uplod">
            <a href="{$base_url}/upload/"><span>Upload</span></a>
            Quickly upload and tag videos in almost any video format.
        </div>

        <div class="share">
            <a href="{$base_url}/friends/invite/"><span>Share</span></a>
            Easily share your videos with everyone, put videos on your space or watch them here.
        </div>
   
     </div>
    
    <!-- new videos -->
    
    {if $view.new_video_total gt "0"}
    
        <div class="section bg2 clearfix">
        
            <div class="hd">
                <div class="hd-l">New Videos</div>
                <div class="hd-r"><a href="{$base_url}/recent/">More Recent Videos</a></div>
            </div>

            {section name=i loop=$view.new_videos}
                <div class="home-video-box">
                    <div class="preview home-video-box-img-adjust">
                        <a href="{$base_url}/view/{$view.new_videos[i].video_id}/{$view.new_videos[i].video_seo_name}/">
                            <img src="{$view.new_videos[i].video_thumb_url}/thumb/{$view.new_videos[i].video_folder}1_{$view.new_videos[i].video_id}.jpg" alt="{$view.new_videos[i].video_title}" />
                        </a>
                        <div class="video-time">{$view.new_videos[i].video_length}</div>
                    </div>
                    
                    <a href="{$base_url}/view/{$view.new_videos[i].video_id}/{$view.new_videos[i].video_seo_name}/" >
                        {$view.new_videos[i].video_title|truncate:20:"...":true}
                    </a>
                </div>
            {/section}
        </div>
    
    {/if}
    
    <!-- recent video -->
    
    {if $view.recent_total gt 0}
    
        <div class="section bg2 clearfix">
        
            <div class="hd">
                <div class="hd-l">Recently Viewed</div>
                <div class="hd-r"><a href="{$base_url}/viewed/">More Recently Viewed</a></div>
            </div>
            
            {section name=i loop=$view.recent_videos}
                <div class="home-video-box">
                    <div class="preview home-video-box-img-adjust">
                        <a href="{$base_url}/view/{$view.recent_videos[i].video_id}/{$view.recent_videos[i].video_seo_name}/">
                            <img src="{$view.recent_videos[i].video_thumb_url}/thumb/{$view.recent_videos[i].video_folder}1_{$view.recent_videos[i].video_id}.jpg" alt="{$view.recent_videos[i].video_title}" />
                        </a>
                        <div class="video-time" >{$view.recent_videos[i].video_length}</div>
                    </div>
                    
                    <a href="{$base_url}/view/{$view.recent_videos[i].video_id}/{$view.recent_videos[i].video_seo_name}/">
                        {$view.recent_videos[i].video_title|truncate:20:"...":true}
                    </a>
                    
                    <p>{insert name=timediff value=var time=$view.recent_videos[i].video_view_time}</p>
                </div>
            {/section}
            
        </div>
    
    {/if}
    
    <!-- featured videos -->
    
    {$view.featured_video_block}
    
    
</div> <!--  content -->

<div id="sidebar">

        <div align="center">
            {insert name=advertise adv_name='home_right_box'}
        </div>
        
        {if $home_num_tags gt 0}
        
            <div class="section">
            
                <div class="hd">
                    <span class="margin-left-small">Recent Tags</span>
                </div>
            
                <div class="home-tags">
                    {$view.home_tags}<br />
                    <a href="{$base_url}/tags/"><b>See More Tags</b></a>
                </div>
                
            </div>
        
        {/if}
        
    {if $num_last_users_online ne 0}
    
    <div id="users-online">
    
        <div class="section">
        
            <div class="hd">
                <span class="margin-left-small">
                    Last {$num_last_users_online} Users Online
                </span>
            </div>
            
            {insert name=recently_active_users assign=recently_active_users}
            {section name=i loop=$recently_active_users}

                <p>
                    {insert name=id_to_name assign=uname un=$recently_active_users[i].user_login_user_id}
                    <a href="{$base_url}/{$uname}">{$uname}</a>
                    <br />
                    <br />

                    {insert name=video_count assign=vdocount uid=$recently_active_users[i].user_login_user_id}
                    
                    <span class="video">
                        <a href="{$base_url}/{$uname}/public/">({$vdocount})</a>
                    </span>

                    {insert name=favour_count assign=favcount uid=$recently_active_users[i].user_login_user_id}
                    
                    <span class="favorite">
                        <a href="{$base_url}/{$uname}/favorites/">
                            ({$favcount})
                        </a>
                    </span>

                    {insert name=friends_count assign=friends uid=$recently_active_users[i].user_login_user_id}
                    
                    <span class="friends">
                        <a href="{$base_url}/{$uname}/friends/">({$friends})</a>
                    </span>
                    
                </p>

            {/section}
       
        <p class="icon-key">
            <b>Icon Key:</b><br /><br />
            <span class="video">Videos</span><br /><br />
            <span class="favorite">Favorites</span><br /><br />
            <span class="friends">Friends</span><br />
        </p>

        </div> <!-- section -->
   
    </div> <!-- users-online end -->

    {/if}

    {if $show_stats ne "0"}

        {insert name="show_stats" assign="stats"}
        
        <div class="section bg2">
        
            <div class="hd">
                <span class="margin-left-small">
                    Site Statistics
                </span>
            </div>
        
            <div id="site-statistic">
                <ul>
                    <li>Number of Videos: {$stats.total_video}</li>
                    <li class="bg2">Public Videos:{$stats.total_public_video}</li>
                    <li>Private Videos:{$stats.total_private_video}</li>
                    <li class="bg2">Number of Users:{$stats.total_users}</li>
                    <li>Number of Channels:{$stats.total_channel}</li>
                    <li class="bg2">Number of Groups:{$stats.total_groups}</li>
                </ul>
            </div>
       
        </div>

    {/if}
    
    <!-- poll start -->
    
    {if $pollinganel ne 'Disable' AND $poll_question ne ""}
    
    <div class="section">
        
        <div class="hd">
            <span class="margin-left-small">Vote Here</span>
        </div>
        
        <div id="poll_body"> <!-- poll start -->
        
            <div id="poll">

                <p>
                    {$poll_question}
                </p>
                
                <div id="poll_answers">
                    {section name=i loop=$list}
                        <input type="radio" name="xx" onclick="poll_vote_for('{$list[i]}','user_answer')" />
                        <font size="2" color="#3366FF"> {$list[i]}</font><br />
                    {/section}
                    <br />
                    <input type="hidden" id="user_answer" value="" />
                    <input type="submit" class="button" value='Cast This' onclick="poll_vote({$poll_id})" />
                </div>
                
                {if $list ne ""}
                    <div id="poll_view">
                        <a href="javascript:void(0)" onclick="poll_view({$poll_id})">
                            View current status
                        </a>
                    </div>
                {/if}
                
            </div> <!-- poll -->
            
            <div id="poll_loading"></div>
            <div id="poll_result"></div>

        </div>  <!--  poll body -->

    </div>
    
    {/if}

</div> <!-- sidebar -->