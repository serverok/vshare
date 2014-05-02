<h1>Add Channel</h1>

<form action="" method="post" enctype="multipart/form-data">

    <div>
        <label for="channel_name">Channel Name:</label>
        <input name="channel_name" id="channel_name" value="{$smarty.post.channel_name}" size="40" />
    </div>

    <div>
        <label for="channel_description">Channel Description:</label>
        <textarea name="channel_description" id="channel_description" rows=3 cols=40>{$smarty.post.channel_description}</textarea>
    </div>

    <div>
        <label for="channel_image">Channel Image:</label>
        <input type="file" name="channel_image" id="channel_image" size="30" />
    </div>

    <div class="submit">
        <input type="submit" name="add_channel" value="Add Channel" class="btn btn-primary" />
    </div>

</form>