<h1>Upload Watermark</h1>

<p>After uploading the new watermark image, you may see OLD image due to caching.
To clear cache, open the
<a href="{$img_css_url}/images/watermark.gif" target="_blank">Watermark Image</a>
 on a new browser and refresh it, so you will be able to see the new image.</p>

<form action="" method="post" enctype="multipart/form-data">

    <div>
        <label>Watermark URL:</label>
        <input name="watermark_url" value="{$watermark_url}" size="40" />
    </div>

    <div>
        <label>Watermark:</label>
        <img src="{$img_css_url}/images/watermark.gif?{$vshare_rand}" alt="watermark" />
        <div class="indent">
            <p>Watermark should be .gif format.</p>
        </div>
    </div>

    <div class="indent">
        <input type="file" name="upfile" size="30" />
    </div>

    <div class="submit">
        <input type="submit" name="submit" value="Update Watermark" class="btn btn-primary" />
    </div>

</form>