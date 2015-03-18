<div id="sidebar" style="float: left;">
    <div class="section bg2">
        <div class="hd">
            <div class="hd-l">Playlists</div>
        </div>
        
        <ul style="list-style-type:none;">
            {section name=i loop=$playlists}
                <li style="margin: 2px 1px 5px -25px;">
                    <a style="font-weight: normal;" href="{$base_url}/{$user_info.user_name}/playlist/{$playlists[i].playlist_name}/1">{$playlists[i].playlist_name}</a>
                </li>
            {/section}
        </ul>
        
        <div class="clearfix"></div>
        
        {if $user_info.user_id eq $smarty.session.UID}
            <form method="post" name="pl-frm" id="pl-frm" action="">
                <div>
                    <span>Create New Playlist:</span>
                    <input type="text" name="playlist_name" id="playlist_name" size="15" />
                    <input type="submit" name="create_playlist" id="create" value="Add" />
                </div>
            </form>
        {/if}
            
    </div>
</div>

<div id="content" style="float: right;">
    {if $playlists|@count eq "0"}
        <center><b>There is no playlist found.</b></center>
    {else}

    <div class="section">
        
        <div class="hd">
            <div class="hd-l">Videos of: {$playlist_info.playlist_name}</div>
            
            {if $smarty.session.UID eq $playlist_info.playlist_user_id}
            <div class="hd-l">
                &nbsp;&nbsp;&nbsp;[<small><a onclick="Javascript:return confirm('Are you sure you want to delete?');" href="{$base_url}/playlist_delete.php?pl_id={$playlist_info.playlist_id}&action=pl_del">Delete Playlist</a></small>]
            </div>
            {/if}
            
            <div class="hd-r">Videos {$start_num}-{$end_num} of {$total}</div>
        </div>

        {section name=i loop=$videos}
               
            <div class="video-entry bg2 clearfix">
                
                <div class="box1">
                    <div class="preview default-img-adjust">
                        <a href="{$base_url}/view/{$videos[i].video_id}/{$videos[i].video_seo_name}/">
                            <img src="{$videos[i].video_thumb_url}/thumb/{$videos[i].video_folder}1_{$videos[i].video_id}.jpg" alt="" />
                        </a>
                        <div class="video-queue" id="{$videos[i].video_id}" rel="video_queue">&nbsp;</div>
                        <div class="video-time">{$videos[i].video_length}</div>
                    </div>
                    
                    {if $user_info.user_name eq $smarty.session.USERNAME}
                        <a href="{$base_url}/playlist_delete.php?pl_id={$playlist_info.playlist_id}&action=vdo_del&vid={$videos[i].video_id}&page={$page}">
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
                        Views: {$videos[i].video_view_number} |
                        {insert name=comment_count assign=commentcount vid=$videos[i].video_id}
                        Comments: {$commentcount}<br /><br />
                        Rating: {insert name=show_rate assign=vrate rte=$videos[i].video_rate rated=$videos[i].video_rated_by}{$vrate}
                    </p>
                </div>
            </div> <!-- video-entry -->
        {sectionelse}
            <center><p>There is no video found.</p></center>
        {/section}

        {if $page_links ne ""}
            <div class="page_links">Browse Pages: {$page_links}</div>
        {/if}
    
    </div> <!-- section -->
    
    {/if}
    
</div> <!-- content-->

