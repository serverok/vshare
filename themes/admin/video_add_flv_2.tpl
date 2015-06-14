<h1>Add FLV URL / Embed Code</h1>

{if $success eq 0}
<form action="video_add_flv_2.php" method="post" enctype="multipart/form-data" class="form-horizontal">
    <div role="tabpanel">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active">
                <a href="#media_flv" aria-controls="media_flv" role="tab" data-toggle="tab">FLV URL</a>
            </li>
            <li role="presentation">
                <a href="#media_embed" aria-controls="media_embed" role="tab" data-toggle="tab">Embed Code</a>
            </li>
        </ul>
        <div class="tab-content">
            <br>
            <div role="tabpanel" class="tab-pane fade in active" id="media_flv">
                <div class="form-group">
                    <div class="col-md-6">
                        <input type="text" name="flv_url" class="form-control" placeholder="Flv url">
                    </div>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane fade" id="media_embed">
                <div class="form-group">
                    <div class="col-md-6">
                        <textarea name="embed_code" rows="3" class="form-control" placeholder="Embed code"></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div role="tabpanel">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active">
                <a href="#remote_image" aria-controls="remote_image" role="tab" data-toggle="tab">Image URL</a>
            </li>
            <li role="presentation">
                <a href="#local_image" aria-controls="local_image" role="tab" data-toggle="tab">Image from your Computer</a>
            </li>
        </ul>
        <div class="tab-content">
            <br>
            <div role="tabpanel" class="tab-pane fade in active" id="remote_image">
                <div class="form-group">
                    <div class="col-md-6">
                        <input type="text" name="embedded_code_image[]" class="form-control" placeholder="Image Url 1"><br>
                        <input type="text" name="embedded_code_image[]" class="form-control" placeholder="Image Url 2"><br>
                        <input type="text" name="embedded_code_image[]" class="form-control" placeholder="Image Url 3">
                    </div>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane fade" id="local_image">
                <div class="form-group">
                    <div class="col-md-6">
                        <input type="file" name="embedded_code_image_local[]"><br>
                        <input type="file" name="embedded_code_image_local[]"><br>
                        <input type="file" name="embedded_code_image_local[]">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-6">
            <div class="clearfix">&nbsp;</div>
            <input type="submit" name="submit" value="Upload" class="btn btn-default btn-lg">
        </div>
    </div>
</form>

{/if}