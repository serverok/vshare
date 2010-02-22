<div id="view-video-content">

    <div class="section bg2">
        <div class="hd">
            <div class="hd-l">{$view.video_info.video_title}</div>
        </div>
    </div>
    
    {insert name=advertise adv_name='player_top'}
    
    <div>{$view.VSHARE_PLAYER}</div>
    
    {insert name=advertise adv_name='player_bottom'}
    
    <div align="center">
        <a href="http://www.facebook.com/share.php?u={$base_url}/view/{$view.video_info.video_id}/{$view.video_info.video_seo_name}/&amp;title={$view.video_info.video_title}" title="FaceBook"><img src="{$img_css_url}/images/facebook.jpg" border="0" alt="facebook" /></a>&nbsp;
        <a href="http://digg.com/submit?phase=2&amp;url={$base_url}/view/{$view.video_info.video_id}/{$view.video_info.video_seo_name}/&amp;title={$view.video_info.video_title}" title="Digg It!"><img src="{$img_css_url}/images/digg.png" border="0" alt="digg" /></a>&nbsp;
        <a href="http://del.icio.us/post?url={$base_url}/view/{$view.video_info.video_id}/{$view.video_info.video_seo_name}/&amp;title={$view.video_info.video_title}" title="del.icio.us"><img src="{$img_css_url}/images/delicious.png" border="0" alt="delicious" /></a>&nbsp;
        <a href="http://newsvine.com/_tools/seed&amp;save?u={$base_url}/view/{$view.video_info.video_id}/{$view.video_info.video_seo_name}/&amp;u={$view.video_info.video_title}" title="NewsVine"><img src="{$img_css_url}/images/newsvine.png" border="0" alt="newsvine" /></a>&nbsp;
        <a href="http://reddit.com/submit?url={$base_url}/view/{$view.video_info.video_id}/{$view.video_info.video_seo_name}/&amp;title={$view.video_info.video_title}" title="reddit"><img src="{$img_css_url}/images/reddit.png"border="0" alt="reddit" /></a>&nbsp;
        <a href="http://simpy.com/simpy/LinkAdd.do?href={$base_url}/view/{$view.video_info.video_id}/{$view.video_info.video_seo_name}/&amp;title={$view.video_info.video_title}" title="Simpy"><img src="{$img_css_url}/images/simpy.png"border="0" alt="simpy" /></a>&nbsp;
        <a href="http://spurl.net/spurl.php?title={$view.video_info.title}&amp;url={$base_url}/view/{$view.video_info.video_id}/{$view.video_info.video_seo_name}/" title="Spurl"><img src="{$img_css_url}/images/spurl.png" border="0" alt="spurl" /></a>&nbsp;
        <a href="http://myweb2.search.yahoo.com/myresults/bookmarklet?u={$base_url}/view/{$view.video_info.video_id}/{$view.video_info.video_seo_name}/&amp;t={$view.video_info.video_title}" title="My Yahoo!"><img src="{$img_css_url}/images/yahoo.png" border="0" alt="yahoo" /></a>
        
        <br />
        
        <a href="javascript:void(0)" onclick="video_add_favorite({$view.video_info.video_id})"s><img src="{$img_css_url}/images/fav.gif" border="0" alt="Favorite" />&nbsp; Add to Favorites </a> &nbsp; &nbsp;
        <a href="javascript:void(0)" class="comments" onclick="feature()"><img src="{$img_css_url}/images/flag.gif" border="0" alt="Feature" />&nbsp; Feature This! </a> &nbsp; &nbsp;
        <a href="javascript:void(0)" onclick="inappropriate()"><img src="{$img_css_url}/images/flag.gif" border="0" alt="Inappropriate" />&nbsp; Inappropriate </a> &nbsp; &nbsp;
        <a href="{$base_url}/friends/recommend/{$view.video_info.video_id}/"><img src="{$img_css_url}/images/tell.gif" border="0" alt="Share" />&nbsp; Share</a>
        
        {if $allow_download == 1 && $view.video_info.video_vtype eq 0}
            &nbsp; &nbsp; 
            <a href="{$base_url}/download/{$view.video_info.video_id}/">
                <img src="{$img_css_url}/images/download.png" border="0" alt="download video" />&nbsp; Download
            </a>
        {/if}
        
        {if $smarty.session.UID eq $view.video_info.video_user_id}
            &nbsp; &nbsp; 
            <a href="{$base_url}/edit/video/{$view.video_info.video_id}">
                <img src="{$img_css_url}/images/page_edit.png" border="0" alt="edit" />&nbsp; Edit
            </a>
        {/if}
        
        <div id="video-tools-result"></div>
    
    </div>

    <div id="video-rating">
        {insert name=video_rating assign=rating id=$view.video_info.video_id}{$rating}
    </div>

    <!-- video feedback end --> 
 
    <div id="video-tools-feedback">

        <form id="video-report-form" name="form1" onsubmit="javascript:feedback();" method="post" action="javascript:void(0)">
        
            <div>Type of abuse</div>
            <div class="inapropriat">
                <select name="abuse_type" id="abuse_type">
                    <option value="">Select a category</option>
                    <option value="porn">Porn</option>
                    <option value="racism">Racism</option>
                    <option value="prohibited">Prohibited</option>
                    <option value="violent">Violent</option>
                    <option value="copyright">Copyright</option>
                </select>
            </div>
            
            <div class="inapropriat">Comments</div>
            
            <div class="inapropriat">
                <textarea name="abuse_comments" id="abuse_comments" cols="40" rows="4"></textarea>
            </div>
            
            <div class="inapropriat">
                <input type="submit" value="Send" name="send" class="button" />
            </div>
            
            <div>
                <a href="javascript:void(0)" onclick="inappropriate_cancel();">
                    <img src="{$img_css_url}/images/cancel.gif" alt="cancel" border="0" align="right" />
                </a>
            </div>
            
            <div class="clearfix"></div>
            
        </form>
        
    </div> <!-- video-tools-feedback -->

    <div class="view-video-description">
        {$view.video_info.video_description}
    </div>
    
    <div class="view-video-added-by">
        Added on  {$view.video_info.video_add_date|date_format} by <a href="{$base_url}/{$view.user_info.user_name}">{$view.user_info.user_name}</a>
    </div>

    <div class="section">
    
        <div class="hd">
            <div class="hd-l">Video Details</div>
        </div>
        
        <div id="videos-details">
            Time: {$view.video_info.video_length} | Views: {$view.video_info.video_view_number} |
            <a href="#commentview">Comments:</a>  <span>{$view.video_info.video_com_num}</span><br />
            <label>Tags:</label>&nbsp;
            {section name=j loop=$view.tags}
                <a href="{$base_url}/tag/{$view.tags[j]}/">{$view.tags[j]}</a>&nbsp;
            {/section}
            <br />
            <label>Channels:</label> &nbsp;
            {insert name=video_channel assign=channel vid=$view.video_info.video_id}
            {section name=k loop=$channel}
                <a href="{$base_url}/channel/{$channel[k].channel_id}/{$channel[k].channel_seo_name}/">{$channel[k].channel_name}</a> &nbsp;
            {/section}
        </div>
    
    </div> <!-- section -->
    
    <div class="section">
    
        <div class="hd">
            <div class="hd-l">User Details</div>
        </div>
        
        <div id="user-details" class="clearfix">

            <div class="box1">
                <a href="{$base_url}/{$view.user_info.user_name}">
                    {insert name=member_img UID=$view.video_info.video_user_id}
                </a>
            </div>
            
            <div class="box2">
            
                <div>
                    <label>Username:</label>
                    <a href="{$base_url}/{$view.user_info.user_name}" class="user-name">
                        {$view.user_info.user_name}
                    </a>
                </div>

                {if $view.user_info.user_website ne ""}
                    <div>
                        <label>Website:</label>
                        <a class="user-web-site" href="{$view.user_info.user_website}" target="_blank">{$view.user_info.user_website}</a>
                    </div>
                {/if}
                
                {insert name=video_count assign=vdocount uid=$view.video_info.video_user_id}
                {insert name=favour_count assign=favcount uid=$view.video_info.video_user_id}
                {insert name=friends_count assign=friendcount uid=$view.video_info.video_user_id}
                
                <div class="user-links">
                    <a href="{$base_url}/{$view.user_info.user_name}/public/">Videos</a>: {$vdocount} |
                    <a href="{$base_url}/{$view.user_info.user_name}/favorites/">Favorites</a>: {$favcount} |
                    <a href="{$base_url}/{$view.user_info.user_name}/friends/">Friends</a>: {$friendcount}
                </div>
                
                <div>
                    (<a href="{$base_url}/compose.php?receiver={$view.user_info.user_name}">Send Me a Private Message!</a>)
                </div>
            
            </div>
            
        </div>
        
    </div> <!-- section -->

    <div class="section">
    
        <div class="hd">
            <div class="hd-l">Share Details</div>
        </div>

        <div id="video-share-links">

            <form id="linkForm" name="linkForm" action="">

                <div>
                    <label>Video URL (Permalink):</label>
                    &nbsp;&nbsp;<br /><br />
                    <input name="video_link" value="{$base_url}/view/{$view.video_info.video_id}/{$view.video_info.video_seo_name}/" size="60" onclick="javascript:document.linkForm.video_link.focus();document.linkForm.video_link.select();" readonly="readonly" />
                    <br /><br />

                    {if $view.video_info.video_vtype eq "0" && ($view.video_info.video_type == "public" || $view.video_info.video_user_id == $smarty.session.UID)}

                        {if $view.video_info.video_allow_embed eq "enabled" && $embed_show eq 1}
                            <label>Embeddable Player:</label>
                            <br /><br />
                            <input name="video_play" value='{if $embed_type eq "0"}<iframe vspace="0" hspace="0" allowtransparency="true" scrolling="no" marginwidth="0" marginheight="0" frameborder="0" style="border:0px;" width="435" height="470" SRC="{$base_url}/show.php?id={$view.video_info.video_id}"></iframe>{else}<object width="425" height="350" type="application/x-shockwave-flash" data="{$base_url}/player/player.swf"><param name="movie" value="{$base_url}/player/player.swf"><param name="flashvars" value="&file={$base_url}/xml_playlist.php?id={$view.video_info.video_id}&height=350&image={$view.video_info.video_thumb_url}/thumb/{$view.video_info.video_folder}{$view.video_info.video_id}.jpg&width=425&location={$base_url}/player/player.swf&logo={$img_css_url}/images/watermark.gif&link={$watermark_url}&linktarget=_blank"/></object>{/if}' size="60" onclick="javascript:document.linkForm.video_play.focus();document.linkForm.video_play.select();" readonly="readonly" />
                            <div> 
                                (Put this video on your website. Works on Friendster, eBay, Blogger, MySpace!)
                            </div>
                        {/if}
                    {/if}
                </div>
                
            </form>
        
        </div>
    
    </div> <!-- section -->

    <br />

    <a name="postcomment">Post Comments</a>

    <div class="commentbox bg2">

        {if $view.video_info.video_allow_comment eq "yes"}
        
            <div id="comment_box">
                <div>Comment on this video:</div>
                <form name="add_comment" method="post" action="">
                    <textarea name="user_comment" id="user_comment" rows="5" cols="45"></textarea><br />
                    <input type="button" name="post" value="Post comment" onclick="video_post_comment({$view.video_info.video_id})" />
                </form>
            </div> <!-- comment_box -->
        
        {/if}
    
    </div> <!-- commentbox -->

    <div id="comment_post_result"></div>

    <div class="commentsTitle">Comments: (<span>{$view.video_info.video_com_num}</span>)</div>

    <div id="section_comment"></div>

</div> <!-- video-content --> 

<div id="view-video-sidebar">

    <div class="section bg2 clearfix">
    
        <div class="hd">
            <div class="hd-l">Watch</div>
        </div>
        
       <ul id="watch-videos">
       
            <li>
                {if $view.video_prev == 0}
                    <img src="{$img_css_url}/images/no_prev.gif" class="preview" width="60" height="45" alt="no prev" /><br />&lt; PREV
                {else}
                    <a href="{$base_url}/view/{$view.video_prev.video_id}/{$view.video_prev.video_seo_name}/">
                        <img src="{$view.video_prev.video_thumb_url}/thumb/{$view.video_prev.video_folder}1_{$view.video_prev.video_id}.jpg" class="preview" width="60" height="45" alt="Prev" />
                    </a>
            
                    <div>
                        <a href="{$base_url}/view/{$view.video_prev.video_id}/{$view.video_prev.video_seo_name}/">
                            &lt; PREV
                        </a>
                    </div>
                {/if}
           </li>

           <li>
                <img src="{$view.video_info.video_thumb_url}/thumb/{$view.video_info.video_folder}1_{$smarty.request.id}.jpg" class="preview" width="80" height="60" alt="now playing" />
                <div style="font-weight: bold; font-size: 10px; padding-top: 3px">NOW PLAYING</div>
           </li>

            <li>
                {if $view.video_next == 0}
                    <img src="{$img_css_url}/images/no_next.gif" class="preview" width="60" height="45" alt="no next" /><br />NEXT &gt;
                {else}
                    <a href="{$base_url}/view/{$view.video_next.video_id}/{$view.video_next.video_seo_name}/">
                        <img src="{$view.video_next.video_thumb_url}/thumb/{$view.video_next.video_folder}1_{$view.video_next.video_id}.jpg" class="preview" width="60" height="45" alt="related videos" />
                    </a>
                    <div>
                        <a href="{$base_url}/view/{$view.video_next.video_id}/{$view.video_next.video_seo_name}/">
                            NEXT &gt;
                        </a>
                    </div>
                {/if}
            </li>
       </ul>
       
    </div> <!-- section -->

    <div class="section bg2" style="text-align:center;padding:0.5em;">
        {insert name=advertise adv_name='video_right_single'}
    </div>
    
    <!-- User videos -->
    
    <h3>
        <a href="javascript:void(0);" onclick="show_user_videos('{$view.video_info.video_user_id}');">
            More from: {$view.user_info.user_name}
        </a>
    </h3>
    <div id="show_user_videos" style="display: none;"></div>
   
    <!-- End user videos -->
    
    <div class="section bg2">
    
        <div class="hd">
            <div class="hd-l">Related Videos</div>
        </div>
        
        <div id="related-video-box" class="clearfix">
        
            {section name=i loop=$view.related_videos}
            
                {if $smarty.request.id eq $view.related_videos[i].video_id}
                    <div class="related-video playing-bg">
                {else}
                    <div class="related-video">
                {/if}

                    <div class="box1">
                        <a href="{$base_url}/view/{$view.related_videos[i].video_id}/{$view.related_videos[i].video_seo_name}/" target="_parent">
                        <img class="preview" src="{$view.related_videos[i].video_thumb_url}/thumb/{$view.related_videos[i].video_folder}1_{$view.related_videos[i].video_id}.jpg" width="80" height="60" alt="related videos" />
                        </a>
                    </div>
                    
                    <div class="box2">
                    
                        <div class="moduleFrameTitle">
                            <a href="{$base_url}/view/{$view.related_videos[i].video_id}/{$view.related_videos[i].video_seo_name}/" target="_parent">
                                {$view.related_videos[i].video_title}
                            </a>
                        </div>

                        <div class="moduleFrameDetails">
                           {insert name=id_to_name assign=uname un=$view.related_videos[i].video_user_id}
                            by <a href="{$base_url}/{$uname}" target="_parent">{$uname}</a>
                        </div>

                        <div class="moduleFrameDetails">
                            Time: {$view.related_videos[i].video_length}<br />
                            Views: {$view.related_videos[i].video_view_number}<br />
                            Comments: {$view.related_videos[i].video_com_num}
                        </div>

                        {if $smarty.request.id eq $view.related_videos[i].video_id}
                            <div class="playing-now">
                                &lt;&lt;&lt;NOW PLAYING!
                            </div>
                        {/if}
                        
                    </div>
                
                </div> <!-- related-video -->
            
            {/section}
            
        </div> <!-- related-video-box-->
    
    </div> <!-- related-video-playing-->

</div> <!-- video-sidebar -->