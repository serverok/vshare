<h1>Add Package</h1>

<form method="post" action="" enctype="multipart/form-data">

    <div>
        <label for="pack_name">Package Name:</label>
        <input name="pack_name" id="pack_name" value="{$smarty.post.pack_name}" size="30" />
    </div>

    <div>
        <label for="pack_desc">Description:</label>
        <textarea name="pack_desc" id="pack_desc" rows="5" cols="30">{$smarty.post.pack_desc}</textarea>
    </div>

    <div>
        <label for="space">Space (MB):</label>
        <input name="space" id="space" value="{$smarty.post.space}" size="10" />
    </div>

    <div>
        <label for="video_limit">Video Limit:</label>
        <input name="video_limit" id="video_limit" value="{$smarty.post.video_limit}" size="10" />
        (Leave blank or enter 0 for unlimited upload)
    </div>

    <div>
        <label for="price">Price (USD):</label>
        <input name="price" id="price" value="{$smarty.post.price}" size="8" />
    </div>

    <div>
        <label for="period">Subscription Period:</label>
        <select name="period" id="period">{$period_ops}</select>
    </div>

    <div>
        <label for="status">Status:</label>
        <select name="status" id="status">{$status_ops}</select>
    </div>

    <div class="submit">
        <input type="submit" name="add_package" value="Add Package" class="btn btn-default btn-lg" />
    </div>

</form>