{if $total gt "0"}

<div id="content">

    <div class="section bg2">

        <div class="hd">
        
            <div class="hd-l">
                {if $smarty.request.type eq "private"}Private Videos{else}Public Videos{/if} of {$user_info.user_name}
            </div>
            
            <div class="hd-r">
                Videos {$start_num}-{$end_num} of {$total}
            </div>
            
        </div>

        {section name=i loop=$view.videos}

            <div class="video-entry bg2 clearfix">

                <div class="box1">
                
                    <div class="preview default-img-adjust">
                        <a href="{$base_url}/view/{$view.videos[i].video_id}/{$view.videos[i].video_seo_name}/">
                            <img src="{$view.videos[i].video_thumb_url}/thumb/{$view.videos[i].video_folder}1_{$view.videos[i].video_id}.jpg" alt="{$view.videos[i].video_title}" />
                        </a>
                        <div class="video-queue" id="{$view.videos[i].video_id}" rel="video_queue">&nbsp;</div>
                        <div class="video-time">{$view.videos[i].video_length}</div>
                    </div>

                    {if $user_info.user_name == $smarty.session.USERNAME}
                    
                        <div style="display: block;">
                            <form name="editVideoForm" action="{$base_url}/video_edit.php" method="GET" style="display: inline;">
                                <input type="hidden" value={$view.videos[i].video_id} name="video_id" />
                                <input type="hidden" value={$page} name="page" />
                                <input type=image  src="{$img_css_url}/images/edit.gif" title="Edit Video" />
                            </form>
                            <form name="removeVideoForm" action="" method="POST" style="display: inline;margin-left: 1em;">
                                <input type="hidden" value="1" name="remove_video" />
                                <input type="hidden" value="{$view.videos[i].video_id}" name="VID" />
                                <input type=image src="{$img_css_url}/images/del.gif" onclick="return confirm('Are you sure you want to remove this video?');" title="Delete Video" style="border:0px solid white" />
                            </form>
                       </div>
                    {/if}
                
                </div> <!-- box1 -->

                <div class="box2">

                    <p class="video-entry-title">
                        <a href="{$base_url}/view/{$view.videos[i].video_id}/{$view.videos[i].video_seo_name}/">
                            {$view.videos[i].video_title}
                        </a>
                    </p>

                    <p class="video_description">
                        {$view.videos[i].video_description}
                    </p>

                    <p class="video_tags">
                        <img width="38" height="14" src="{$img_css_url}/images/tags.gif" alt="video tags" />:
                        {section name=j loop=$view.videos[i].video_keywords_array}
                            <a href="{$base_url}/tag/{$view.videos[i].video_keywords_array[j]}/">{$view.videos[i].video_keywords_array[j]}</a>&nbsp;
                        {/section}
                    </p>

                    <p class="video_details">
                        {insert name=time_to_date assign=todate tm=$view.videos[i].video_add_time}
                        Added: {$todate} <br />
                        Views: {$view.videos[i].video_view_number} |
                        {insert name=comment_count assign=commentcount vid=$view.videos[i].video_id}
                        Comments: {$commentcount}
                        {insert name=show_rate assign=my_rate rte=$view.videos[i].video_rate rated=$view.videos[i].video_rated_by}
                        | Rating: {$my_rate}
                    </p>
                
                </div> <!-- box2 -->

            </div> <!-- video-entry -->

        {/section}

        <div class="clearfix"></div>
        
        {if $page_links ne "" }
            <div class="page_links">
                Pages:{$page_links}
            </div>
        {/if}

    </div> <!-- section -->

</div> <!-- content -->

<div id="sidebar">

    <div class="section bg2">
        <div class="hd">
            <div class="hd-l">
                <a href="{$base_url}/invite_friends.php">Share your videos!</a>
            </div>
        </div>

        <div class="tags">
            <b>My Tags: </b>
            {section name=k loop=$view.video_keywords_array_all}
                <p><a href="{$base_url}/tag/{$view.video_keywords_array_all[k]}/">{$view.video_keywords_array_all[k]}</a></p>
            {/section}
        </div>
        
        {insert name=advertise adv_name='wide_skyscraper'}
        
    </div>

</div> <!-- sidebar -->

{else}

    <h5>There is no video found</h5>
    
{/if}