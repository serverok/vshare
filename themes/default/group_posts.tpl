<div id="content">

<div class="section bg2 clearfix">

    <div class="hd">
        <div class="hd-l">
            Group Posts 
            <a href="{$base_url}/group/{$group_url}/">
                {$group_info.group_name}
            </a>
        </div>
    </div>

    <div class="video-entry clearfix">
    
        <div class="box1">
            {if $topic.group_topic_video_id eq 0}
                <img class="preview" src="{$img_css_url}/images/no_videos_groups.gif" width="120" height="90" alt="" />
            {else}
                {insert name=getfield assign=seo_name field='video_seo_name' table='videos' qfield='video_id' qvalue=$topic.group_topic_video_id}
                <a href="{$base_url}/view/{$topic.group_topic_video_id}/{$seo_name}/">
                    <img class="preview" src="{$topic.video_thumb_url}/thumb/{$topic.video_folder}1_{$topic.group_topic_video_id}.jpg" width="120" height="90" alt="" />
                </a>
            {/if}
        </div>
    
        <div class="box2">
            <b>Topic:</b> {$topic.group_topic_title}<br />
            {$topic.group_topic_add_time|date_format:"%A, %B %e, %Y, %H:%M %p"}</b><br />
            {insert name=id_to_name assign=user_name un=$topic.group_topic_user_id}
            <b>Author:</b> <a href="{$base_url}/{$user_name}">{$user_name}</a>
        </div>
        
    </div>    <!-- video-entry end -->
        
    {section name=i loop=$post}
        
        <hr />

        <div class="video-entry bg2">
        
            <div class="box1">
                {if $post[i].group_topic_post_video_id ne "0"}
                    {insert name=getfield assign=title field='video_seo_name' table='videos' qfield='video_id' qvalue=$post[i].group_topic_post_video_id}
                    <a href="{$base_url}/view/{$post[i].group_topic_post_video_id}/{$title}/">
                        <img class="preview"  src="{$post[i].video_thumb_url}/thumb/{$post[i].video_folder}1_{$post[i].group_topic_post_video_id}.jpg" width="120" height="90" alt="" />
                    </a>
                {else}
                    <img class="preview" src="{$img_css_url}/images/no_videos_groups.gif" width="120" height="90" alt="" />
                {/if}
                {insert name=id_to_name assign=user_name un=$post[i].group_topic_post_user_id}
            </div>

           <div class="box2">
                {$post[i].group_topic_post_description}<br />
                <div style="margin-top:1.5em">
                    Posted by: <a href="{$base_url}/{$user_name}">{$user_name}</a>
                    On: {$post[i].group_topic_post_date|date_format:"%A, %B %e, %Y, %H:%M %p"}
                </div>
            </div>
            
        </div>   <!-- video-entry end -->
        
    {/section}


    {if $smarty.session.UID ne ""}
    
        {insert name=check_group_mem assign=checkmem gid=$group_info.group_id}
        
        {if $checkmem ne "0"}
        
            <div style="padding-left: 20px; font-weight: bold; padding-bottom: 5px; color: #444; padding-top: 8px">
                Add New Comment:
            </div>
        
            <div style="padding-left: 20px; padding-bottom: 5px">
                <form name="add_group_post" action="{$base_url}/group/{$group_url}/topic/{$group_topic_id}" method="post">
                    <textarea name="topic_title" rows="3" cols="55"></textarea>
                    <br />Attach a video:
                    <select name="topic_video">
                        {$video_ops}
                    </select>
                    <input type="submit" value="Add Comment" name="add_topic" />
                </form>
            </div>
        
        {else}
    
            <div align="center">
                <form name="Joingroup" id="Joingroup" method="GET" action="{$base_url}/group_join.php">
                    <input type="hidden" name="action" value="join" />
                    <input type="hidden" name="group_id" value="{$group_info.group_id}" />
                    <input type="submit" name="submit" value="Join this group to post comment" />
                </form>
            </div>
           
        {/if}
    
    {else}
    
       <div align="center">
          Please <a href="{$base_url}/login/">Login</a> to post your comment
       </div>
       
    {/if}

</div> <!-- section -->

</div>

<div id="sidebar">
   {insert name=advertise adv_name='wide_skyscraper'}
</div>