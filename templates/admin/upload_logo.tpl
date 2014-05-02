<h1>Upload Logo</h1>

<p>
    After uploading the new logo image, you may see OLD image due to caching.
    To clear cache open the
    <a href="{$img_css_url}/images/logo.jpg" target="_blank">Logo image</a>
    on a new browser and refresh it (Press F5 on your keyboard),
    so you will be able to see the new image.
</p>

<form action='upload_logo.php?a={$smarty.request.a}&action=edit' method='post' enctype='multipart/form-data'>

    <div>
        <img src="{$img_css_url}/images/logo.jpg?{$vshare_rand}" alt="" />
    </div>

    <div>
        <input type="file" name="logo" size="30" />
    </div>

    <div>
        <input type="submit" name="submit" value="Upload" class="btn btn-primary" />
    </div>

</form>