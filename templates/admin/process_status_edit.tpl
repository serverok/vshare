<h1>Process Queue Edit</h1>

<form method="post" action="{$base_url}/admin/process_status_edit.php?page={$page}">
    
    <input type="hidden" name="id" value="{$video_info.id}" />
    
    <div>
        <label><b>Status : </b></label>
        {if $video_info.status == 0}
            Video is added to process queue, not yet processed.
        {elseif $video_info.status == 1}
            Started downloding the video.
        {elseif $video_info.status == 2}
            Video downloaded successfully.
        {elseif $video_info.status == 3}
            Error in downloading video. Check if the video exists and server firewall is not blocking the download.
        {elseif $video_info.status == 4}
            Conversion of video to FLV format started.
        {elseif $video_info.status == 5}
            Video converted and added to the site.
        {elseif $video_info.status == 6}
            Error in converting video to FLV format.
        {/if}
    </div>

    <div>
        <label>Edit Status:</label>
        
        <select name="status" id="status_value">
            <option value="{$video_info.status}">No Change</option>
            {if $video_info.url != ""}
                <option value="0">Download Again</option>
            {/if}
            <option value="2">Convert Again</option>
        </select>
        
    </div>
    
    <div class="submit">
            <input type="submit" name="submit" value="Update" />
    </div>
    
</form>