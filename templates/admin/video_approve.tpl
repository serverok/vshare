<h1>Approve Videos ({$total})</h1>

{if $total > 0}

<table cellspacing="1" cellpadding="3" width="100%" border="0">

	<tr class="tabletitle">

		<td>
			<b>ID</b>
			<a href="?sort=video_id+asc">
				<img src="{$img_css_url}/images/up.gif" border="0" alt="" />
			</a>
			<a href="?sort=video_id+desc">
				<img src="{$img_css_url}/images/down.gif" border="0" alt="" />
			</a>
		</td>

		<td>
			<b>Title</b>
			<a href="?sort=video_title+asc">
				<img src="{$img_css_url}/images/up.gif" border="0" alt="" />
			</a>
			<a href="?sort=video_title+desc">
				<img src="{$img_css_url}/images/down.gif" border="0" alt="" />
			</a>
		</td>

		<td>
			<b>Type</b>
			<a href="?sort=video_type+asc">
				<img src="{$img_css_url}/images/up.gif" border="0" alt="" />
			</a>
			<a href="?sort=video_type+desc">
				<img src="{$img_css_url}/images/down.gif" border="0" alt="" />
			</a>
		</td>

		<td>
			<b>Duration</b>
			<a href="?sort=video_duration+asc">
				<img src="{$img_css_url}/images/up.gif" border="0" alt="" />
			</a>
			<a href="?sort=video_duration+desc">
				<img src="{$img_css_url}/images/down.gif" border="0" alt="" />
			</a>
		</td>

		<td>
			<b>Featured</b>
			<a href="?sort=video_featured+asc">
				<img src="{$img_css_url}/images/up.gif" border="0" alt="" />
			</a>
			<a href="?sort=video_featured+desc">
				<img src="{$img_css_url}/images/down.gif" border="0" alt="" />
			</a>
		</td>

		<td>
			<b>Date</b>
			<a href="?sort=video_add_date+asc">
				<img src="{$img_css_url}/images/up.gif" border="0" alt="" />
			</a>
			<a href="?sort=video_add_date+desc">
				<img src="{$img_css_url}/images/down.gif" border="0" alt="" />
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