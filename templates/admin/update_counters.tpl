<div class="page-header">
    <h1>Update Video Counts</h1>
</div>

<form method="get" action="" class="form-horizontal" role="form">

    <input type="hidden" name="action" value="update_video_counts">

    <p>This will recalculate all of your user's video counts based on their CURRENT videos in the database.</p>

    <div class="form-group">
        <label class="col-sm-4 control-label" for="items_per_page">Number of users to process per cycle:</label>
        <div class="col-sm-5">
            <input class="form-control" type="text" name="items_per_page" id="items_per_page" value="{$result_per_page}">
        </div>
    </div>

    <div>
        <input type="submit" name="submit" value="Update Video Counts" class="btn btn-default btn-lg" />
    </div>

</form>

<div class="page-header">
    <h1>Update Video Comments Count</h1>
</div>

<form method="get" action="" class="form-horizontal" role="form">

    <input type="hidden" name="action" value="update_video_comments_count">

    <p>This will rebuild comments count of all videos based on the CURRENT comments in the database.</p>

    <div class="form-group">
        <label class="col-sm-4 control-label" for="items_per_page">Number of videos to process per cycle:</label>
        <div class="col-sm-5">
            <input class="form-control" type="text" name=items_per_page id="items_per_page" value="{$result_per_page}">
        </div>
    </div>

    <div>
        <input type="submit" name="submit" value="Update Video Comment Counts" class="btn btn-default btn-lg" />
    </div>

</form>

<div style="margin-top:4em"></div>