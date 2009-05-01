{if $todo != "finished"}

<h1>Import Folder Video</h1>
	
<form method="post" action="import_folder_form.php">
  
	<div>
		<label for="file_name">File Name:</label>
		{$video_name} 
	</div>

	<div>
		<label for="video_user">Add Video to User:</label>
		<input maxlength="100" size="40" name="video_user" value="{$smarty.request.video_user}" />
	</div>


	<div>
		<label for="video_title">Title:</label>
		<input maxlength="60" size="40" name="video_title" value="{$smarty.request.video_title}" />
	 </div>

	<div>
		<label for="video_description">Description:</label>                  
	    <textarea name="video_description" rows="4" cols="50">{$smarty.request.video_description}</textarea>
	</div>

	<div>
		<label for="video_keywords">Tags:</label>
		<input maxlength="120" size="40" name="video_keywords" value="{$smarty.request.video_keywords}" />
	</div>

	<div class="indent">
		<strong>Enter one or more tags, separated by spaces.</strong><br />
		Tags are simply keywords used to describe your video so they are easily searched and organized. 
		For example, if you have a surfing video, you might tag it: surfing beach waves.<br />
	</div>

	<div>
		<label>Video Channels:</label>
		<div style="margin-left:200px">
			{$channel_checkbox}    
		</div>
	</div>

	<div class="indent">
		<strong>Select between one to three channels that best describe your video.</strong>
		<br />It helps to use relevant channels so that others can find your video!.
	</div>

	<div>
		<label>Video Type:</label>
		<select name="video_privacy">
			<option value="public">Public</option>
			<option value="private">Private</option>
		</select>
	</div>

	<div class="submit">
		<input type="hidden" name="video_name" value="{$video_name}" />
		<input type="submit" name="submit" value="Import Local Video" /> 
	</div>
	
</form>

{/if}