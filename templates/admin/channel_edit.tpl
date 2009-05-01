<h1>Edit Channel</h1>

<form action="channel_edit.php" method="post" enctype="multipart/form-data">

    <input type="hidden" name="id" value="{$channel.channel_id}" />

    <div>
        <label for="channel_name">Channel Name:</label>
        <input name="name" id="channel_name" value="{$channel.channel_name}" size="40" />
    </div>

    <div>
        <label for="channel_description">Channel Description:</label>
        <textarea name="descrip" id="channel_description" rows="3" cols="40">{$channel.channel_description}</textarea>
    </div>

    <div>
        <label>Channel Image:</label>
        <img src="{$base_url}/chimg/{$channel.channel_id}.jpg" alt="" />   
    </div>

    <div class="indent">
        <input type="file" name="picture" size="30" />
    </div>
    
    <div class="submit">
        <input type="submit" name="edit_channel" value="Update" />
    </div>

</form>