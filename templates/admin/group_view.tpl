{insert name=group_info_count assign=num_group_members tbl=group_members gid=$group.group_id query="1" field1=group_member_approved field2=group_member_group_id}
{insert name=group_info_count assign=num_group_videos tbl=group_videos gid=$group.group_id query="1" field1=group_video_approved field2=group_video_group_id}
{insert name=group_info_count assign=num_group_topics tbl=group_topics gid=$group.group_id query="1" field1=group_topic_approved field2=group_topic_group_id}
{insert name=id_to_name assign=uname un=$group.group_owner_id}

<form action="" method="post">
	<div>
		{insert name=group_image assign=group_image_info gid=$group.group_id tbl=group_videos}
		{if $group_image_info eq "0"}
			<img src="{$img_css_url}/images/no_videos_groups.gif" width="120" height="90" alt="" />
		{else}
			<img src="{$group_image_info.video_thumb_url}/thumb/{$group_image_info.video_folder}1_{$group_image_info.video_id}.jpg" width="120" height="90" alt="" />
		{/if}
	</div>

	<div>
		<label>Group ID</label>
		{$group.group_id}
	</div>

	<div>
		<label>Group Name</label>
		{$group.group_name}
	</div>

	<div>
		<label>Owner</label>
		<a href="user_view.php?user_id={$group.group_owner_id}">{$uname}</a>
	</div>

	<div>
		<label>Tags</label>
		{$group.group_keyword}
	</div>

	<div>
		<label>Group Description</label>
		{$group.fname} {$group.group_description}
	</div>

	<div>
		<label>Group URL</label>
		{$group.group_url}
	</div>

	<div>
		<label>Total Video</label>
		<a href="group_videos.php?gid={$group.group_id}">
			{$num_group_videos}
		</a>
	</div>

	<div>
		<label>Total Member</label>
		<a href="group_members.php?group_id={$group.group_id}">
			{$num_group_members}
		</a>
	</div>

	<div>
		<label>Total Topics</label>
		<a href="group_topics.php?gid={$group.group_id}">
			{$num_group_topics}
		</a>
	</div>

	<div>
		<label>Group Type</label>
		{$group.group_type}
	</div>

	<div>
		<label>Upload Type</label>
		{$group.group_upload}
	</div>

	<div>
		<label>Topic Posting Type</label>
		{$group.group_posting}
	</div>

	<div>
		<label>Group Image</label>
		{$group.group_image}
	</div>

	<div>
		<label>Is Featured?</label>
		{$group.group_featured}
	</div>

	<div>
		<label>Channel</label>
		<div style="margin-left:200px;">
			{$ch_checkbox}
		</div>
	</div>

	<div style="margin-top:1em;">
		<a href="group_edit.php?action=edit&gid={$group.group_id}&page={$smarty.request.page}">
			Edit Group
		</a>
	</div>

</form>