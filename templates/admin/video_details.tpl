{if $video.video_id ne ""}

<div id="video-details">

    <h1>{$video.video_title}</h1>
    
    {$VSHARE_PLAYER}

    <p class="video-link">
        <a href ="{$base_url}/view/{$video.video_id}/{$video.video_seo_name}/" target="_blank">
            {$base_url}/view/{$video.video_id}/{$video.video_seo_name}/
        </a>
    </p>

    <div>
        <label>Video ID</label>
        {$video.video_id}
    </div>

    <div>
        <label>Server ID</label>
        {$video.video_server_id}
    </div>
    
    <div>
        <label>Title</label>
        {$video.video_title}
    </div>
    
    <div>
        <label>Added by</label>
        {if $video.video_user_id eq 0}
            Deleted Video
        {else}
            {insert name=id_to_name assign=uname un=$video.video_user_id}
            <a href="user_view.php?user_id={$video.video_user_id}">{$uname}</a>
        {/if}
    </div>
    
    <div>
         <label>Description</label>
         {$video.video_description}
    </div>
    
    <div>
         <label>Tags</label>
         {$video.video_keywords}
    </div>

    <div>
        <label>Channel</label>
        {insert name=video_channel assign=channel vid=$video.video_id}
        {section name=j loop=$channel}
            {$channel[j].channel_name},
        {/section}
    </div>

    <div>
       <label>Duration</label>
       {$video.video_length}
    </div>

    <div>
       <label>Type</label>
       {$video.video_type}
    </div>

    <div>
       <label>vType</label>
       {$video.video_vtype}
    </div>
    
    <div>
       <label>Rate</label>
       {$video.video_rate}
    </div>

    <div>
       <label>Is featured ?</label>
       {$video.video_featured}
    </div>

    <div>
       <label>Can be commented ?</label>
       {$video.video_allow_comment}
    </div>

    <div>
        <label>Can be rated?</label>
        {$video.video_allow_rated}
    </div>

    <div>
        <label>Can be embaded?</label>
        {$video.video_allow_embed}
    </div>
    
    <div style="background-color:#FFFfD9;margin-top:1em;border:1px solid #FED973;padding:2px;text-align:center;">
        {if $video_type eq "0"}
        <a href="video_rename_flv.php?id={$video.video_id}">Rename FLV Video</a> &nbsp;
        <a href="video_thumb.php?id={$video.video_id}">Create Thumb</a> &nbsp;
            {if $reprocess eq "1"}
                <a href="./convert.php?id={$reprocess_id}&reconvert=1">Convert Again</a> &nbsp;
            {/if}
        {/if}
        <a href="video_edit.php?video_id={$video.video_id}&a={$a}&page={$smarty.request.page}">Edit</a> &nbsp;
        <a href="video_delete.php?id={$video.video_id}" onclick="Javascript:return confirm('Are you sure you want to delete?');">Delete</a>
    </div>

</div>

{/if}