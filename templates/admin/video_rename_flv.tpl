{if $err eq ""}

<h1>Rename FLV Video</h1>

<div>
    <label>Video Id: </label>
    {$video_info.video_id}
</div>

<div>
    <label>Old FLV Name: </label>
    {$old_name}
</div>

<div>
    <label>New FLV Name: </label>
    {$new_flv_name}
</div>

<div>
    <label>Title: </label>
    {$video_info.video_title}
</div>

<div class="margin-tb-1em">
    <label>Type: </label>
    {$video_info.video_type}
</div>

<div align="center">
    <a href="javascript:history.go(-1);">Go Back</a>
</div>

{/if}