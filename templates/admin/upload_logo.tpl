<div class="page-header">
    <h1>Upload Logo</h1>
</div>

<p>To clear cache open the <a href="{$img_css_url}/images/logo.jpg" target="_blank">Logo image</a> on a new browser and refresh it (Press F5 on your keyboard), so you will be able to see the new image.</p>

<img src="{$img_css_url}/images/logo.jpg?{$vshare_rand}" alt="" />

<br />

<br />

<div class="row">
    <div class="col-sm-6">
        <form action="upload_logo.php?a={$smarty.request.a}&action=edit" method="post" enctype="multipart/form-data" class="form-horizontal well" role="form">

            <fieldset>

            <div class="form-group">
                <input type="file" name="logo" />
            </div>

            <div class="form-group">
                <input type="submit" name="submit" value="Upload" class="btn btn-primary" />
            </div>

            </fieldset>

        </form>
    </div>
</div>

