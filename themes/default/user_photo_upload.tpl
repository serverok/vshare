<div class="col-md-12">
	<div class="page-header">
        <h1>
            Upload Photo
        </h1>

        <p class="lead text-muted">After uploading a new photo, refresh the page (Press F5), to see the new image.</p>
	</div>

    <form action="user_photo_upload.php" method="post" enctype="multipart/form-data" name="profile-photo-upload" id="profile-photo-upload" class="form-horizontal">
        <div class="form-group">
            <div class="col-md-offset-2">
                <img class="img-responsive" src="{$photo_url}?{$vshare_rand}" alt="">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-2">File:</label>
            <div class="col-md-5">
                <input type="file" name="photo">
                <span class="help-block">Photo must be in JPG format</span>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-2 col-md-offset-2">
                <button type="submit" name="submit" class="btn btn-default btn-lg">Upload Photo</button>
            </div>
        </div>
    </form>
</div>