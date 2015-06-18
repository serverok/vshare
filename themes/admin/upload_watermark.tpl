<div class="page-header">
    <h1>Upload Watermark</h1>
</div>

<p>After uploading the new watermark image, you may see OLD image due to caching. To clear cache, open the <a href="{$img_css_url}/default/images/watermark.gif" target="_blank">Watermark Image</a> on a new browser and refresh it, so you will be able to see the new image.</p>

<div style="margin:2em 0em">
    <img src="{$img_css_url}/default/images/watermark.gif?{$vshare_rand}" alt="watermark" />
</div>

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
                <label for="upfile" class="col-sm-3 control-label">Select file:</label>
                <div class="col-sm-5">
                    <input class="form-control" type="file" name="upfile" id="upfile" />
                    <span class="help-block">Watermark should be .gif format.</span>
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
