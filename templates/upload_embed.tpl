<div class="section">

    <div class="hd">
        Video Upload
    </div>

    <form id="upload" name="theForm" action="{$base_url}/upload/embed/" method="post">

        <div>
            <label>Youtube/Dailymotion Video URL:</label>
            <input size="53" name="url" value="{$smarty.post.url}" />
        </div>

        <div>
            <label>Video Channel:</label>
            <div class="indent">
                <select name="channel">
                {section name=i loop=$channel_info}
                    <option value="{$channel_info[i].channel_id}">{$channel_info[i].channel_name_html}</option>
                {/section}
                </select>
            </div>
        </div>

	<!--

        <div>
            <label>Broadcast:</label>
            <div class="indent">
                <input name="field_privacy" type="radio" value="public" checked="checked" /> <strong>Public:</strong> Share your video with the world! (Recommended)<br />
                <input name="field_privacy" type="radio" value="private" /> <strong>Private:</strong> Only viewable by you and those you share the video with.
            </div>
        </div>

	-->

        <div class="submit">
           <input type="submit" value="UPLOAD" name="action_upload" id="upload" />
        </div>
    </form>
</div>