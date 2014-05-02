<h1>Approve Videos ({$total})</h1>

{if $total > 0}

<table cellspacing="1" cellpadding="3" width="100%" border="0">

	<tr class="tabletitle">

		<td>
			<b>ID</b>
			<a href="?sort=video_id+asc">
				<span class="glyphicon glyphicon-arrow-up"></span>
			</a>
			<a href="?sort=video_id+desc">
				<span class="glyphicon glyphicon-arrow-down"></span>
			</a>
		</td>

		<td>
			<b>Title</b>
			<a href="?sort=video_title+asc">
				<span class="glyphicon glyphicon-arrow-up"></span>
			</a>
			<a href="?sort=video_title+desc">
				<span class="glyphicon glyphicon-arrow-down"></span>
			</a>
		</td>

		<td>
			<b>Type</b>
			<a href="?sort=video_type+asc">
				<span class="glyphicon glyphicon-arrow-up"></span>
			</a>
			<a href="?sort=video_type+desc">
				<span class="glyphicon glyphicon-arrow-down"></span>
			</a>
		</td>

		<td>
			<b>Duration</b>
			<a href="?sort=video_duration+asc">
				<span class="glyphicon glyphicon-arrow-up"></span>
			</a>
			<a href="?sort=video_duration+desc">
				<span class="glyphicon glyphicon-arrow-down"></span>
			</a>
		</td>

		<td>
			<b>Featured</b>
			<a href="?sort=video_featured+asc">
				<span class="glyphicon glyphicon-arrow-up"></span>
			</a>
			<a href="?sort=video_featured+desc">
				<span class="glyphicon glyphicon-arrow-down"></span>
			</a>
		</td>

		<td>
			<b>Date</b>
			<a href="?sort=video_add_date+asc">
				<span class="glyphicon glyphicon-arrow-up"></span>
			</a>
			<a href="?sort=video_add_date+desc">
				<span class="glyphicon glyphicon-arrow-down"></span>
			</a>
		</td>
		<td align="center">
			<b>Action</b>
		</td>
	</tr>

	{section name=i loop=$videos}
	
	<tr class="{cycle values="tablerow1,tablerow2"}">
		<td>
			{$videos[i].video_id}
		</td>
		<td>
			<a href="video_details.php?id={$videos[i].video_id}&page={$page}">
				{$videos[i].video_title}
			</a>
		</td>
		<td align="center">
			{$videos[i].video_type}
		</td>
		<td align="center">
			{$videos[i].video_length}
		</td>
		<td align="center">
			{$videos[i].video_featured}
		</td>
		<td align="center">
			{$videos[i].video_add_date|date_format}
		</td>
		<td align="center">
			<a href="?action=approve&video_id={$videos[i].video_id}&page={$smarty.request.page}&sort={$smarty.request.sort}">Approve</a>
		</td>
	</tr>
	
	{/section}

</table>
    
<div class="margin-tb-1em">
    {$links}
</div>

<div class="margin-tb-1em">
    <a href="?action=approve_all">Approve All</a>
</div>

{else}

<h5>No videos currently awaiting approval.</p>

{/if}