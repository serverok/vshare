<h1>User Deleted Videos ({$total})</h1>

{if $total > 0}

<script language="JavaScript" type="text/javascript" src="{$base_url}/js/admin_user_deleted_videos.js"></script>

<table cellspacing="1" cellpadding="3"  width="100%" border="0">

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

	{section name=aa loop=$videos}
	
		<tr class="{cycle values="tablerow1,tablerow2"}">
			<td>
				{$videos[aa].video_id}
			</td>
			<td>
				<a href="video_details.php?a={$a}&id={$videos[aa].video_id}&page={$page}">{$videos[aa].video_title}</a>
			</td>
			<td align="center">
				{$videos[aa].video_type}
			</td>
			<td align="center">
				{$videos[aa].video_length}
			</td>
			<td align="center">
				{$videos[aa].video_featured}
			</td>
			<td align="center">
				{$videos[aa].video_add_date|date_format}
			</td>
			<td align="center">
				<a href="video_user_deleted_activate.php?id={$videos[aa].video_id}">Activate</a>
				<a href="video_delete.php?id={$videos[aa].video_id}" onclick='Javascript:return confirm("Are you sure want to delete?");'>
                    <img src="{$img_css_url}/images/del.gif" title="Delete" alt="Delete" />
                </a>
			</td>
		</tr>
	
	{/section}

</table>

<div class="margin-tb-1em">
	{$links}
</div>

<div class="margin-tb-1em">
    <a href="{$base_url}/admin/video_user_deleted_all.php">
    	Delete All
    </a>
</div>

{else}

<h5>There is no user deleted videos found.</h5>

{/if}