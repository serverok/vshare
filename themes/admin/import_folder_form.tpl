{if $todo != "finished"}

<div class="page-header">
    <h1>Import Folder Video</h1>
</div>

<form method="post" action="import_folder_form.php" class="form-horizontal" role="form">

    <div class="form-group">
        <label for="file_name" class="control-label col-md-2">File Name:</label>
        <div class="col-md-4">
            <p class="form-control-static">{$video_name}</p>
        </div>
    </div>

    <div class="form-group">
        <label for="video_user" class="control-label col-md-2">Add Video to User:</label>
        <div class="col-md-4">
            <input maxlength="100" size="40" name="video_user" value="{$smarty.request.video_user}" class="form-control">
        </div>
    </div>

    <div class="form-group">
        <label for="video_title" class="control-label col-md-2">Title:</label>
        <div class="col-md-4">
            <input maxlength="60" size="40" name="video_title" value="{$smarty.request.video_title}" class="form-control">
        </div>
    </div>

    <div class="form-group">
        <label for="video_description" class="control-label col-md-2">Description:</label>
        <div class="col-md-5">
            <textarea name="video_description" rows="4" class="form-control">{$smarty.request.video_description}</textarea>
        </div>
    </div>

    <div class="form-group">
        <label for="video_keywords" class="control-label col-md-2">Tags:</label>
        <div class="col-md-4">
            <input maxlength="120" size="40" name="video_keywords" value="{$smarty.request.video_keywords}" class="form-control">
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-2"></label>
        <div class="col-md-offset-2 col-md-10">
            <strong>Enter one or more tags, separated by spaces.</strong><br>
            Tags are simply keywords used to describe your video so they are easily searched and organized.<br>
            For example, if you have a surfing video, you might tag it: surfing beach waves.
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-md-2">Video Channels:</label>
        <div class="col-md-4">{$channel_checkbox}</div>
    </div>

    <div class="form-group">
        <label class="col-md-2"></label>
        <div class="col-md-offset-2 col-md-10">
            <strong>Select between one to three channels that best describe your video.</strong>
            <br>
            It helps to use relevant channels so that others can find your video!.
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-md-2">Video Type:</label>
        <div class="col-md-4">
            <select name="video_privacy" class="form-control">
                <option value="public">Public</option>
                <option value="private">Private</option>
            </select>
        </div>
    </div>

    <div class="form-group">
        <input type="hidden" name="video_name" value="{$video_name}">
        <div class="col-md-2 col-md-offset-2">
            <input type="submit" name="submit" value="Import Local Video" class="btn btn-default">
        </div>
    </div>

</form>

{/if}