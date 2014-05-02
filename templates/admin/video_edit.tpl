<form action="video_edit.php?a={$a}&video_id={$video.video_id}" method="post">

    <h1>Edit Video</h1>

    <div style="margin-top:2em;">
        <label> Video ID:</label>
        {$video.video_id}
    </div>

    {if $video.video_vtype eq "2"}

        <div>
            <label for="video_embed_code"> URL: </label>
            <input name="video_embed_code" id="video_embed_code" value="{$video.video_embed_code}" size="40" />
        </div>

    {elseif $video.video_vtype eq "6"}

        <div>
            <label for="video_embed_code">Embed:</label>{$video.video_vtype}
            <textarea name="video_embed_code" id="video_embed_code" rows="3" cols="40">{$video.video_embed_code}</textarea>
        </div>

    {/if}

    <div>
        <label for="video_title">Title:</label>
        <input name="video_title" id="video_title" value="{$video.video_title}" size="40" />
    </div>

    <div>
        <label for="video_description">Description:</label>
        <textarea name="video_description" id="video_description" rows="3" cols="40">{$video.video_description}</textarea>
    </div>

    <div>
        <label for="video_keywords">Keywords:</label>
        <textarea name="video_keywords" id="video_keywords" rows="3" cols="40">{$video.video_keywords}</textarea>
    </div>

    <div>
        <label for="video_duration">Duration:</label>
        <input type="text" name="video_duration" id="video_duration" value="{$video.video_duration}" /> (<i>in second</i>)
    </div>

    <div>
        <label>Channels:</label>
        <div style="padding-left:200px;">
            {$ch_checkbox}
        </div>
    </div>

    <div>
        <label for="video_type">Type:</label>
        <select name="video_type" id="video_type">{$type_box}</select>
    </div>

    <div>
        <label for="video_featured">Is featured?:</label>
        <select name="video_featured" id="video_featured">{$featured_box}</select>
    </div>

    <div>
        <label for="video_active">Is Active ?:</label>
        <select name="video_active" id="video_active">{$active_box}</select>
    </div>

    <div>
        <label for="video_allow_comment">Can be commented ?:</label>
        <select name="video_allow_comment" id="video_allow_comment">{$comment_box}</select>
    </div>

    <div>
        <label for="video_allow_rated">Can be rated ?:</label>
        <select name="video_allow_rated" id="video_allow_rated">{$rate_box}</select>
    </div>

    <div>
        <label for="video_allow_embed">Can be embedded ?:</label>
        <select name="video_allow_embed" id="video_allow_embed">{$embed_box}:</select>
    </div>

    {if $family_filter eq "1"}
	    <div>
	        <label for="video_adult">Adult Video ?:</label>
	        <select name="video_adult" id="video_adult">
	            <option value="0" {if $video.video_adult eq "0"}selected{/if}>No</option>
	            <option value="1" {if $video.video_adult eq "1"}selected{/if}>Yes</option>
	        </select>
	    </div>
	{else}
        <input type="hidden" name="video_adult" value="0" />
    {/if}

    <div class="submit">
        <input type="submit" name="submit" value="Save" class="btn btn-primary" />
    </div>

</form>