{if !empty($video)}

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

{if $family_filter eq "1"}
    <div>
        <label>Adult Video</label>
        {if $video.video_adult eq "1"}Yes{else}No{/if}
    </div>
{/if}

<div class="btn-group">
    {if $video_type eq "0"}
    <a href="video_rename_flv.php?id={$video.video_id}" class="btn btn-default btn-lg">Rename Video</a>
    <a href="video_thumb.php?id={$video.video_id}" class="btn btn-default btn-lg">Create Thumb</a>
    {if $reprocess eq "1"}
    <a href="./convert.php?id={$reprocess_id}&reconvert=1" class="btn btn-default btn-lg">Convert Again</a>
    {/if}
    {/if}
    <a href="video_edit.php?video_id={$video.video_id}&a={$a}&page={$smarty.request.page}" class="btn btn-default btn-lg">Edit</a>
    <a href="video_delete.php?id={$video.video_id}" onclick="Javascript:return confirm('Are you sure you want to delete?');" class="btn btn-danger btn-lg">Delete</a>
</div>

{/if}
