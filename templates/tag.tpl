{if $total gt "0"}

<div class="tag-top-links">
    <b>Related Tags:</b>
    {section name=i loop=$tags}
        <a class="tags" href="{$base_url}/tag/{$tags[i]|lower}/">{$tags[i]}</a>&nbsp;
    {/section}
</div>

<div class="tag-top-links">
    <b>Sort by:</b>
    <a href="{$base_url}/tag/{$smarty.get.search_string}/?page={$page}&sort=adddate">Date Added</a> -
    <a href="{$base_url}/tag/{$smarty.get.search_string}/?page={$page}&sort=viewnum">View Count</a> -
    <a href="{$base_url}/tag/{$smarty.get.search_string}/?page={$page}&sort=rate">Rating</a>
</div>

<div class="section bg2">

	<div class="hd">
	
		<div class="hd-l">
			Videos with tag {$search_string}
		</div>
		
		<div class="hd-r">
			Results <b>{$start_num}</b>-<b>{$end_num}</b> of <b>{$total}</b>
		</div>
		
	</div>

	{section name=i loop=$video_info}

        <div class="tags-video-entry clearfix">
        
            <div class="box1">
				<a href="{$base_url}/view/{$video_info[i].video_id}/{$video_info[i].video_seo_name}/">
    				<img src="{$video_info[i].video_thumb_url}/thumb/{$video_info[i].video_folder}1_{$video_info[i].video_id}.jpg" width="120" height="90" alt=""  class="preview"/>
				</a>
				<a href="{$base_url}/view/{$video_info[i].video_id}/{$video_info[i].video_seo_name}/">
				    <img src="{$video_info[i].video_thumb_url}/thumb/{$video_info[i].video_folder}2_{$video_info[i].video_id}.jpg" width="120" height="90" alt=""  class="preview"/>
				</a>
				<a href="{$base_url}/view/{$video_info[i].video_id}/{$video_info[i].video_seo_name}/">
				    <img src="{$video_info[i].video_thumb_url}/thumb/{$video_info[i].video_folder}3_{$video_info[i].video_id}.jpg" width="120" height="90" alt="" class="preview"/>
				</a>
            </div>
            
            <div class="box2">
				
				<p class="video-entry-title">
					<a href="{$base_url}/view/{$video_info[i].video_id}/{$video_info[i].video_seo_name}/">
						{$video_info[i].video_title}
					</a>
				</p>

				<p class="video-entry-description">
					{$video_info[i].video_description}
				</p>

				<p class="video-entry-tags">
					<img width="38" height="14" src="{$img_css_url}/images/tags.gif" alt="tags" />
					{section name=j loop=$video_info[i].video_keywords_array}
						<a href="{$base_url}/tag/{$video_info[i].video_keywords_array[j]}/">{$video_info[i].video_keywords_array[j]}</a>&nbsp;
					{/section}
				</p>

				<p class="video-entry-details">
					Channels:
					{insert name=video_channel assign=channel vid=$video_info[i].video_id}
					{section name=k loop=$channel}
						<a href="{$base_url}/channel/{$channel[k].channel_id}/{$channel[k].channel_seo_name}/">{$channel[k].channel_name}</a>&nbsp;
					{/section}
					<br />
					<br />
					{insert name=time_range assign=rtime field=video_add_time IDFR=video_id id=$video_info[i].video_id tbl=videos}
					{insert name=id_to_name assign=uname un=$video_info[i].video_user_id}
					Added: {$rtime} by
					<a href="{$base_url}/{$uname}">
						{$uname}
					</a>
					<br /><br />
					Runtime: {$video_info[i].video_length} | 
					Views: {$video_info[i].video_view_number} |
					{insert name=comment_count assign=commentcount vid=$video_info[i].video_id}
					Comments: {$commentcount} 
					<br /><br />
			        {insert name=show_rate assign=rate rte=$video_info[i].video_rate rated=$video_info[i].video_rated_by}
				    {$rate} 
			    </p>
			</div>
        
		</div> <!-- tags-video-entry -->

	{/section}

	{if $page_links ne ""}
		<div class="page_links" align="right">
			Pages {$page_links} &nbsp;
		</div>
	{/if}

</div>  <!-- section -->

{/if}