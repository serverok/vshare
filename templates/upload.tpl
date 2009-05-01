<div class="section">

    <div class="hd"> 
        Video Upload (Step 1 of 2) 
    </div>
    
    <form id="upload" name="theForm" action="{$base_url}/upload.php" method="post">
    
        <div>
            <label>Title:</label>
            <input size="53" name="video_title" value="{$smarty.post.video_title}" />              
        </div>
        
        <div>
            <label>Description:</label>
            <textarea  name="video_description" rows="4" cols="50">{$smarty.post.video_description}</textarea>          
        </div>
              
        <div>
            <label>Tags:</label>
            <input maxlength="120" size="53" name="video_keywords" id="video_keywords" value="{$smarty.post.video_keywords}" />
        </div>
        
        <div class="indent">
            Separate tags using a comma.
        </div>
        
        <div>
            <label>Video Channels:</label>
            <div class="indent">
                {section name=i loop=$channel_info}
                    <input type="checkbox" name="chlist[]" value="{$channel_info[i].channel_id}" />{$channel_info[i].channel_name_html}<br />
                {/section}
                <br />
                <strong>Select between 1 to {$num_max_channels} channels that best describe your video.</strong>
                <br />
                It helps to use relevant channels so that others can find your video!.
            </div>
        </div>
            
        <div>
            <label>Broadcast:</label>
            <div class="indent">
                <input name="field_privacy" type="radio" value="public" checked="checked" /> <strong>Public:</strong> Share your video with the world! (Recommended)<br /> 
                <input name="field_privacy" type="radio" value="private" /> <strong>Private:</strong> Only viewable by you and those you share the video with.
            </div>
        </div>
            
        <div>
            <label>Upload From:</label>
        </div>
            
        <div class="submit">
            <input type="radio" name="upload_from" value="local" checked="checked" /> <strong>Your PC</strong><br /> 
            <input type="radio" name="upload_from" value="remote" /> <strong>Remote Server</strong>
        </div>
            
        <div class="submit">
           <input type="submit" value="UPLOAD" name="action_upload" id="upload" />
        </div>    
    </form>  
    
 </div> <!-- section -->