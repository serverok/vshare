<h1>Featured Videos ({$total})</h1>

{if $answers ne ""}

<table cellspacing="1" cellpadding="3"  width="100%" border="0">
	<tr class="tabletitle">
		<td>
			<b>
				ID
			</b>
			<a href="video_featured.php?sort=video_id+asc&a={$smarty.request.a}">
				<span class="glyphicon glyphicon-arrow-up"></span>
			</a>
			<a href="video_featured.php?sort=video_id+desc&a={$smarty.request.a}">
				<span class="glyphicon glyphicon-arrow-down"></span>
			</a>
		</td>
		<td>
			<b>
				Video Title
			</b>
		</td>
		<td align="center">
			<b>
				Action
			</b>
		</td>
	</tr>

	{section name=i loop=$answers}
	
		<tr class="{cycle values="tablerow1,tablerow2"}">
			<td>
				{$answers[i].video_id}
			</td>
			<td>
				<a href="video_details.php?id={$answers[i].video_id}">
					{$answers[i].video_title}
				</a>
			</td>
			<td align="center">
				<a href="video_featured.php?video_id={$answers[i].video_id}&page={$smarty.request.page}&todo=un_feature" onclick="Javascript:return confirm('Are you sure you want to remove?');">
					Remove
				</a>
			</td>
		</tr>
		
	{/section}

</table>

{if $links ne ""}
<div class="margin-tb-1em">
    {$links}
</div>
{/if}

{if $total ne "0"}
<div style="padding-top:12px;">
    <a href="video_featured.php?todo=un_feature_all" onclick="Javascript:return confirm('Are you sure you want to remove all featured videos?');">
        Remove All Featured
    </a>
</div>
{/if}

{else}

<p>
    No video is featured. To feature a video, go to video edit page, and click
    on the "Feature a video" link at the bottom of the page.
</p>

{/if}