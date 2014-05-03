<h1>Re-generate Tags</h1>

<p>This will regenerate all the tags based on the video keywords in the database.</p>

<br />

<form method="get" action="">
    <div>
        <label for="items_per_page">Number of videos to process per cycle:</label>
        <input type="text" name=items_per_page id="items_per_page" value="{$result_per_page}" />
    </div>
    <div class="submit">
        <input type="submit" name="tags_regenerate" value="Generate" class="btn btn-default btn-lg" />
    </div>
</form>
