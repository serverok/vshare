{if $total gt "0"}

<div id="content">

    <div class="section">
        
        <div class="hd">
             <div class="hd-l">Playlist of {$user_info.user_name}</div>
             <div class="hd-r">Videos {$start_num}-{$end_num} of {$total}</div>
        </div>

        {section name=i loop=$videos}
               
            <div class="video-entry bg2 clearfix">
                
                <div class="box1">
                    <a href="{$base_url}/view/{$videos[i].video_id}/{$videos[i].video_seo_name}/">
                        <img src="{$videos[i].video_thumb_url}/thumb/{$videos[i].video_folder}1_{$videos[i].video_id}.jpg" width="120px" height="90" alt="" />
                    </a>
                    {if $user_info.user_name eq $smarty.session.USERNAME}
                        <a href="{$base_url}/playlist_delete.php?vid={$videos[i].video_id}&page={$page}">
                            <img src="{$img_css_url}/images/del.gif" border="0" alt="" />
                        </a>
                    {/if}
                </div>
                                         
                <div class="box2">
                    <p class="video-entry-title">
                        <a href="{$base_url}/view/{$videos[i].video_id}/{$videos[i].video_seo_name}/">{$videos[i].video_title}</a>					
                    </p>
                    <p class="video-entry-description">{$videos[i].video_description}</p>
    
                    <p class="video-entry-tags">
                        <img width="38" height="14" src="{$img_css_url}/images/tags.gif" alt="" />:
                        {section name=j loop=$videos[i].video_keywords_array}
                            <a href="{$base_url}/tag/{$videos[i].video_keywords_array[j]}/">{$videos[i].video_keywords_array[j]}</a>&nbsp;
                        {/section}
                    </p>
                    <p class="video-entry-details">
                        {insert name=time_to_date assign=todate tm=$videos[i].video_add_time}
                        Added: {$todate}<br /><br />
                        Time: {$videos[i].video_length} | Views: {$videos[i].video_view_number} |
                        {insert name=comment_count assign=commentcount vid=$videos[i].video_id}
                        Comments: {$commentcount}<br /><br />
                        Rating: {insert name=show_rate assign=vrate rte=$videos[i].video_rate rated=$videos[i].video_rated_by}{$vrate}
                    </p>
                </div>
            </div> <!-- video-entry -->
            
        {/section}

        {if $page_links ne ""}
            <div class="page_links">Browse Pages: {$page_links}</div>
        {/if}
    
    </div> <!-- section -->
    
</div> <!-- content-->

<div id="sidebar">

    <div class="section bg2">
  
       <div class="hd">
          <div class="hd-l"><a href="{$base_url}/invite_friends.php">Share your videos !</a></div>
        </div>
    
        <div class="tags">
            <b>My Tags:</b>
            {section name=i loop=$view.video_keywords_array_all}
                <p><a href="{$base_url}/tag/{$view.video_keywords_array_all[i]}/">{$view.video_keywords_array_all[i]}</a></p>
            {/section}
        </div>
    </div>

</div> <!-- sidebar -->

{else}

<center><b>There is no playlist found</b></center>

{/if}