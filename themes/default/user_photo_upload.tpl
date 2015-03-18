<div class="section">

	<div class="hd">
		<div class="hd-l">Upload Photo</div>
	</div>

    <form action="user_photo_upload.php" method="post" enctype="multipart/form-data" name="profile-photo-upload" id="profile-photo-upload">
    
        <div>
            <p>After uploading a new photo, refresh the page (Press F5), to see the new image.</p>
			<p><strong>Photo must be in JPG format</strong></p>
            <img src="{$photo_url}?{$vshare_rand}" alt="" />
        </div>
        
        <div>
            <input type="file" name="photo" size="30" />
        </div>
        
        <div>
            <input type="submit" name="submit" value="Upload Photo" />
        </div>
        
    </form>
    
</div>