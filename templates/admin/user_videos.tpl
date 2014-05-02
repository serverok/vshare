<h1>Videos By User : {$user_name} ({$total})</h1>

{if $total > 0}

<table class="table table-striped">

<tr>
	<td>
		<b>ID</b>
		<a href="?uid={$smarty.request.uid}&a={$smarty.request.a}&status={$smarty.request.status}&sort=video_id+asc">
			<span class="glyphicon glyphicon-arrow-up"></span>
		</a>
		<a href="?uid={$smarty.request.uid}&a={$smarty.request.a}&status={$smarty.request.status}&sort=video_id+desc">
			<span class="glyphicon glyphicon-arrow-down"></span>
		</a>
	</td>

	<td>
		<b>Title</b>
		<a href="?uid={$smarty.request.uid}&a={$smarty.request.a}&status={$smarty.request.status}&sort=video_title+asc">
			<span class="glyphicon glyphicon-arrow-up"></span>
		</a>
		<a href="?uid={$smarty.request.uid}&a={$smarty.request.a}&status={$smarty.request.status}&sort=video_title+desc">
			<span class="glyphicon glyphicon-arrow-down"></span>
		</a>
	</td>
	<td>
		<b>Type</b>
		<a href="?uid={$smarty.request.uid}&a={$smarty.request.a}&status={$smarty.request.status}&sort=video_type+asc">
			<span class="glyphicon glyphicon-arrow-up"></span>
		</a>
		<a href="?uid={$smarty.request.uid}&a={$smarty.request.a}&status={$smarty.request.status}&sort=video_type+desc">
			<span class="glyphicon glyphicon-arrow-down"></span>
		</a>
	</td>
	<td>
		<b>Duration</b>
		<a href="?uid={$smarty.request.uid}&a={$smarty.request.a}&status={$smarty.request.status}&sort=video_duration+asc">
			<span class="glyphicon glyphicon-arrow-up"></span>
		</a>
		<a href="?uid={$smarty.request.uid}&a={$smarty.request.a}&status={$smarty.request.status}&sort=video_duration+desc">
			<span class="glyphicon glyphicon-arrow-down"></span>
		</a>
	</td>
	<td>
		<b>Featured</b>
		<a href="?uid={$smarty.request.uid}&a={$smarty.request.a}&status={$smarty.request.status}&sort=video_featured+asc">
			<span class="glyphicon glyphicon-arrow-up"></span>
		</a>
		<a href="?uid={$smarty.request.uid}&a={$smarty.request.a}&status={$smarty.request.status}&sort=video_featured+desc">
			<span class="glyphicon glyphicon-arrow-down"></span>
		</a>
	</td>
	<td>
		<b>Date</b>
		<a href="?uid={$smarty.request.uid}&a={$smarty.request.a}&status={$smarty.request.status}&sort=video_add_date+asc">
			<span class="glyphicon glyphicon-arrow-up"></span>
		</a>
		<a href="?uid={$smarty.request.uid}&a={$smarty.request.a}&status={$smarty.request.status}&sort=video_add_date+desc">
			<span class="glyphicon glyphicon-arrow-down"></span>
		</a>
	</td>
	<td align="center">
		<b>Action</b>
	</td>
</tr>

{foreach from=$videos item=video}
<tr>
	<td>{$video.video_id}</td>
	<td><a href="video_details.php?id={$video.video_id}">{$video.video_title}</a></td>
	<td align="center">{$video.video_type}</td>
	<td align="center">{$video.video_length}</td>
	<td align="center">{$video.video_featured}</td>
	<td align="center">{$video.video_add_date|date_format}</td>
	<td align="center">
		<a href="video_edit.php?action=edit&video_id={$video.video_id}&page={$smarty.request.page}&sort={$smarty.request.sort}">
			<span class="glyphicon glyphicon-edit"></span>
		</a> &nbsp;
		<a href="video_delete.php?id={$video.video_id}" onclick='Javascript:return confirm("Are you sure you want to delete?");'>
			<span class="glyphicon glyphicon-remove-circle"></span>
		</a>
	</td>
</tr>

{/foreach}

</table>

<div>
    {$links}
</div>

{else}

<h5>There is no video uploaded by user {$user_name}</h5>

{/if}