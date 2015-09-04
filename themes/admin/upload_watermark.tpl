<div class="page-header">
    <h1>Upload Watermark</h1>
</div>

{if $watermark_file_url ne ''}
<p>After updating the new watermark image, you may see OLD image due to caching. To clear cache, open the <a href="{$watermark_file_url}" target="_blank">Watermark Image</a> on a new browser and refresh it, so you will be able to see the new image.</p>
<div style="margin:2em 0em">
    <img src="{$watermark_file_url}?{$vshare_rand}" alt="watermark">
</div>
{/if}

<div class="row">
    <div class="col-sm-8">

        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal well" role="form">

            <fieldset>

            <div class="form-group">
                <label class="col-sm-3 control-label" for="watermark_url">Watermark URL:</label>
                <div class="col-sm-5">
                    <input class="form-control" name="watermark_url" id="watermark_url" value="{$watermark_url}" />
                </div>
            </div>

            <div class="form-group">
                <label for="watermark_file_url" class="col-sm-3 control-label">Watermark File URL:</label>
                <div class="col-sm-7">
                    <input class="form-control" type="url" name="watermark_file_url" id="watermark_file_url" value="{$watermark_file_url}" required>
                    <span class="help-block">You should manually upload your watermark image file to '<b>assets</b>' folder. Then update the URL.<br>Eg: http://yoursite.com/assets/watermark.extn</span>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-5">
                    <input type="submit" name="submit" value="Update Watermark" class="btn btn-default btn-lg" />
                </div>
            </div>

            </fieldset>

        </form>

    </div>
</div>
