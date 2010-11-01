<form method="get" action="">
    
    <input type="hidden" name="action" value="update_video_counts" />
    
    <h1>Update Video Counts</h1>
    <div>This will recalculate all of your user's video counts based on their CURRENT videos in the database.</div>
    <div>
        <label for="items_per_page">Number of users to process per cycle:</label>
        <input type="text" name=items_per_page id="items_per_page" value="{$result_per_page}" />
    </div>
    
    <div class="submit">
        <input type="submit" name="submit" value="Update Video Counts" />
        <input type="reset" name="reset" value="Reset" />
    </div>
    
</form>
