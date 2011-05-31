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
		<td><b>Sitemap Name</b></td>
		<td><b>Sitemap Date</b></td>
		<td><b>Sitemap URL Count</b></td>
		<td><b>Sitemap Last Video ID</b></td>
		<td><b>Sitemap Size</b></td>
	</tr>
	{section name=i loop=$sitemap}
		<tr class="{cycle values="tablerow1,tablerow2"}">
			<td><a href="{$base_url}/sitemap/{$sitemap[i].sitemap_name}" target="_blank">{$sitemap[i].sitemap_name}</a></td>
			<td>{$sitemap[i].sitemap_name|date_format}</td>
			<td>{$sitemap[i].sitemap_url_count}</td>
			<td>{$sitemap[i].sitemap_last_video_id}</td>
			<td>{$sitemap[i].format_size}</td>
		</tr>
	{/section}
</table>

<br />

{/if}

<form method="POST" action="">
	<input type="submit" name="generate_sitemap" value="Generate Sitemap">
</form>

<h2>Sitemap URL</h2>

<textarea rows="2" cols="80">
{$base_url}/sitemap/sitemap_index.xml.gz
</textarea>

<h2>Sitemap Help </h2>

<p><a href="http://www.google.com/support/webmasters/bin/answer.py?answer=183669" target="_blank">http://www.google.com/support/webmasters/bin/answer.py?answer=183669</a></p>
