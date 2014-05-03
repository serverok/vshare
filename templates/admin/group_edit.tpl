<h1>Edit Group</h1>

<form action="group_edit.php?a={$smarty.request.a}&action=edit&gid={$group.group_id}&page={$smarty.request.page}&sort={$smarty.request.sort}" method="post">

	<div>
		<label>Group ID:</label>
		{$group.group_id}
	</div>

	<div>
		<label>Group Name:</label>
		<input name="group_name" value="{$group.group_name}" size="40" />
	</div>

	<div>
		<label>Tags:</label>
		<input name="keyword" value="{$group.group_keyword}" size="40" />
	</div>

	<div>
		<label>Group Description:</label>
		<div class="indent">
			<textarea name="gdescn" rows="3" cols="40">{$group.group_description}</textarea>
		</div>
	</div>

	<div>
		<label>URL Name:</label>
		<input name="gurl" value="{$group.group_url}" size="40" />
	</div>

	<div>
        <label>Channels:</label>
		<div class="indent">
			{$ch_checkbox}
		</div>
	</div>

	<div>
		<label>Group Type:</label>
		<select name="type">{$type_box}</select>
	</div>

	<div>
		<label>Video Uploads:</label>
		<select name="gupload">{$upload_box}</select>
	</div>

	<div>
		<label>Forum Postings:</label>
		<select name="gposting">{$posting_box}</select>
	</div>

	<div>
		<label>Group Icon:</label>
		<select name="gimage">{$icon_box}</select>
	</div>

	<div>
		<label>Is Featured?:</label>
		<select name="featured">{$featured_box}</select>
	</div>

	<div class="submit">
		<input type="submit" name="submit" value="Update" class="btn btn-default btn-lg" />
	</div>

</form>