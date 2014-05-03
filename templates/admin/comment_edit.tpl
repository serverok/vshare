<h1>Edit comment</h1>

<form method="post" action="comment_edit.php?id={$comid}&page={$page}">

    <div>
        <label>Comment id:</label>
        {$comid}
    </div>

    <div>
        <label>vid:</label>
        <input type="hidden" name="vid" value="{$vid}" />
        {$vid}
    </div>

    <div>
        <label>Comment:</label>
        <textarea name="comments" rows="3" cols="50">{$comments}</textarea>
    </div>

    <div class="submit">
        <input type="submit" name="submit" value="Update" class="btn btn-default btn-lg" />
    </div>

</form>