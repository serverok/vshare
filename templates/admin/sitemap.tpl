<h1>Site Maps</h1>

{if $sitemap|@count ne '0'}
<span style="color:#3366FF;font-size: 13px;font-weight: bold;">
	Last Sitemap Generate:
	<span style="color:#961E3C;">
		{$sitemap[0].sitemap_name|date_format}
	</span>
</span> 
<br /><br />

<table cellspacing="1" cellpadding="3"  width="100%" border="0">
	<tr class="tabletitle">
		<td><b>Sitemap Id</b></td>
		<td><b>Sitemap Name</b></td>
		<td><b>Sitemap Date</b></td>
		<td><b>Sitemap Url Count</b></td>
		<td><b>Sitemap Last Video</b></td>
		<td><b>Sitemap Size</b></td>
		<td><b>Action</b></td>
	</tr>
	{section name=i loop=$sitemap}
		<tr class="{cycle values="tablerow1,tablerow2"}">
			<td>{$sitemap[i].sitemap_id}</td>
			<td>{$sitemap[i].sitemap_name}</td>
			<td>{$sitemap[i].sitemap_name|date_format}</td>
			<td>{$sitemap[i].sitemap_url_count}</td>
			<td>{$sitemap[i].sitemap_last_video_id}</td>
			<td>{$sitemap[i].format_size}</td>
			<td>
				<a href="{$base_url}/sitemap/{$sitemap[i].sitemap_name}" target="_blank">
					 <img src="{$img_css_url}/images/page_go.png" title="View {$sitemap[i].sitemap_name}" alt="View {$sitemap[i].sitemap_name}" />				
				</a> 
				<a href="sitemap.php?sitemap_id={$sitemap[i].sitemap_id}&action=update">
					<img src="{$img_css_url}/images/refresh.png" title="Update {$sitemap[i].sitemap_name}" alt="Update {$sitemap[i].sitemap_name}" />				
				</a> 
				<a href="sitemap.php?sitemap_id={$sitemap[i].sitemap_id}&action=delete" onclick='Javascript:return confirm("Are you sure want to delete {$sitemap[i].sitemap_name} ?");'>
					<img src="{$img_css_url}/images/del.gif" title="Delete {$sitemap[i].sitemap_name}" alt="Delete {$sitemap[i].sitemap_name}" />				
				</a>
			</td>
		</tr>
	{/section}
</table>

<br />
<a href="{$base_url}/sitemap/sitemap_index.xml" target="_blank">View Sitemap Index</a><br /><br />
<a href="http://www.google.com/webmasters/tools/ping?sitemap={$base_url}/sitemap/sitemap_index.xml" target="_blank">Submit sitemap to google</a> |
{/if}
<br /><br />
<form method="POST" action="">
	<input type="submit" name="generate_sitemap" value="Generate Sitemap" style="height: 40px;">
</form>