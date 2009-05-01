<div class="section">

    <div class="hd">
        <div class="hd-l">
            Edit Video
        </div>
        <div class="hd-r">
            <a href="{$base_url}/view/{$video_info.video_id}/{$video_info.video_seo_name}/">View Video - {$video_info.video_title}</a>
        </div>
    </div>
    
    <form action="" method="post" id="video-edit">
    
        <input type="hidden" name="video_id" value="{$video_info.video_id}" />
       
        <div>
            <h2>Video Details:</h2>
        </div>
        
        <div>
            <label>Title:</label>
            <input maxlength="60" size="40" name="video_title" value="{$video_info.video_title}" />
        </div>
        
        <div>
            <label>Description:</label>
            <textarea name="video_description" rows="4" cols="50">{$video_info.video_description}</textarea>
        </div>
        
        <div>
            <label>Tags:</label>
            <input maxlength="120" size=40 name="video_keywords" value="{$video_info.video_keywords}" />
        </div>
        
        <div class="indent">
            <strong>Enter one or more tags, separated by comma.</strong> <br />
            Tags are simply keywords used to describe your video so they are easily searched and organized.<br />
            For example, if you have a surfing video, you might tag it: surfing beach waves.<br />
        </div>
        
        <div> 
            <label>Video Channels:</label>
            <div class="indent">
                {section name=i loop=$channels_all}
                    {assign var="status" value=""}
                    {section name=j loop=$chid}
                        {if $chid[j] eq $channels_all[i].channel_id} 
                            {assign var="status" value='checked="checked"'}
                        {/if}
                    {/section}
                    <input type="checkbox" name="channel_list[]" id="channel_list" value="{$channels_all[i].channel_id}" {$status} />{$channels_all[i].channel_name_html}<br />
                {/section}
                <p>Select between 1 to {$num_max_channels} channels that best describe your video.</p>
            </div>  
        </div> 
        
        <div>
            <h2>File Details:</h2>
        </div>
        
        <div>
            <label>Broadcast:</label>
            <div class="indent">
                <input type="radio" value="public" name="video_type" {if $video_info.video_type eq "public"}checked="checked"{/if} />
                <strong>Public:</strong> Share your video with the world! (Recommended)<br />  
                <input type="radio" value="private" name="video_type" {if $video_info.video_type eq "private"}checked="checked"{/if} />
                <strong>Private:</strong> Only viewable by users in your friends list.
            </div> 
        </div>
        
        <div>
            <label>Allow Comments:</label>
            <div class="indent">
                <input type="radio" value="yes" name="video_allow_comment" {if $video_info.video_allow_comment eq "yes"}checked="checked"{/if} />&nbsp;<strong>Yes:</strong> Allow comments to be added to your video.<br />
                <input type="radio" value="no"  name="video_allow_comment" {if $video_info.video_allow_comment eq  "no"}checked="checked"{/if} />&nbsp;<strong>No:</strong> Disallow comments to be added to your video.
            </div>
        </div>
        
        <div>
            <label>Allow Ratings:</label>
            <div class="indent">
                <input type="radio" value="yes" name="video_allow_rated" {if $video_info.video_allow_rated eq "yes"}checked="checked"{/if} />&nbsp;
                <strong>Yes:</strong> Allow people to rate your video. <br />
                <input type="radio" value="no" name="video_allow_rated" {if $video_info.video_allow_rated eq "no"}checked="checked"{/if} />&nbsp;
                <strong>No:</strong> Disallow people from rating your video.
            </div>
        </div>
        
        <div>
            <label>Allow Embed This Video:</label>
            <div class="indent">
                <input type="radio" value="enabled" name="video_allow_embed" {if $video_info.video_allow_embed eq "enabled"}checked="checked"{/if} />&nbsp;
                <strong>Enabled:</strong> External sites may embed and play this video. <br />
                <input type="radio" value="disabled" name="video_allow_embed" {if $video_info.video_allow_embed eq "disabled"}checked="checked"{/if} />&nbsp;
                <strong>Disabled:</strong> External sites may NOT embed and play this video. <br />
            </div>
        </div>
        
        <div class="submit">
            <input type="submit" value="Update Video" name="submit" />
        </div>

    </form>
    
</div> <!-- section -->