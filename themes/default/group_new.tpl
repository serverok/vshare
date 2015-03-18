<div class="section">
    
	<div class="hd">
		<div class="hd-l">Create Group</div>
	</div>
	
	<form name="groups_create" method="post" action="{$base_url}/group/new/" id="create-group">
	
		<input type="hidden" value="create_group_submit" name="field_command" />
		
		<div>
			<label for="group_name">Group Name:</label>
			<input type="text" size="40" name="group_name" id="group_name" value="{$group_name}" />              
		</div>

		<div>
			<label for="tags">Tags:</label>
			<input type="text" size="40" name="tags" id="tags" value="{$tags}" />
			<div class="indent">
				Enter one or more tags, separated by comma.
			</div>
		</div>

		<div>
			<label for="description">Description:</label>
			<textarea  name="description" id="description" rows="4" cols="50">{$description}</textarea>          
		</div>

		<div>
			<label for="short_name">Choose group URL:</label>
			<div class="indent">
				{$base_url}/group/ <input  maxlength="60" name="short_name" id="short_name" value="{$short_name}"/><br />
				Enter 3-18 characters with no spaces (such as &quot; skateboarding &quot;),
				that will become part of your <br />group's web address. Please note, the group name URL you pick is permanent and can not be
				changed.
			</div> 
		</div>
		
		<div class="clearfix"></div>

		<div>
			<label>Group Channels:</label>
		     <div class="indent">
                {section name=i loop=$chinfo}
                    <input type="checkbox" name="chlist[]" value="{$chinfo[i].channel_id}" />{$chinfo[i].channel_name_html}<br />
                {/section}
                <br />
                <strong>Select between 1 to 3 channels that your group belong to.</strong>
                <br />
                It helps to use relevant channels so that others can find your group!
            </div> 
		</div> 

        <div>
            <label>Type:</label>
            <div class="indent">
            <input type="radio" value="public" name="group_type" checked />Public, anyone can join.<br />
            <input type="radio" value="protected" name="group_type" />Protected, requires founder approval to join.<br />
            <input type="radio" value="private" name="group_type" />Private, by founder invite only, only members can view group details.
            </div>
        </div>
        		
		<div>
			<label>Video Uploads:</label>
			<div class="indent">
				<input type="radio" checked value="immediate" name="video_upload_type" />Post videos immediately. <br />
				<input type="radio" value="owner_approve" name="video_upload_type" />Founder approval required before video is available. <br />
				<input type="radio" value="owner_only" name="video_upload_type" />Only Founder can add new videos.
			</div>
		</div>

		<div>
			<label>Forum Postings:</label>
			<div class="indent">
				<input type="radio" checked value="immediate" name="forum_upload_type" />Post topics immediately.<br />
				<input type="radio" value="owner_approve" name="forum_upload_type" /> Founder approval required before topic is available.<br />
				<input type="radio" value="owner_only" name="forum_upload_type" />Only Founder can create a new topic.
			</div>
		</div>

		<div>
			<label>Group Icon:</label>
			<div class="indent">
				<input type="radio" checked  value="immediate" name="group_icon" /> Automatically set group icon to last uploaded video.<br />
				<input type="radio" value="owner_only" name="group_icon" /> Let owner pick the video as group icon.
			</div>
		</div>

		<div class="submit">
			<input type="submit" value="Submit" name="submit" />
		</div>
		
	</form>
	
</div> <!-- section -->