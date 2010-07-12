{if $total gt "0"}

<div id="content">

	<div class="section bg2">
	
        <div class="hd">
		   <div class="hd-l">Favorites Videos of {$user_info.user_name}</div>
		   <div class="hd-r">Videos {$start_num}-{$end_num} of {$total}</div>
        </div>

        {section name=i loop=$favVideos}
        
            <div class="video-entry clearfix">
                 
	           	<div class="box1">
	           	   <div class="preview default-img-adjust">
	           	       <a href="{$base_url}/view/{$favVideos[i].video_id}/{$favVideos[i].video_seo_name}/">
	           	           <img src="{$favVideos[i].video_thumb_url}/thumb/{$favVideos[i].video_folder}1_{$favVideos[i].video_id}.jpg" alt="" />
	           	       </a>
	           	       <div class="video-time">{$favVideos[i].video_length}</div>
	           	   </div>

					{if $smarty.session.USERNAME eq $user_info.user_name}
						<center>
							<form name="USERFAVOUR" method="post" action="">
								<input type="hidden" name="rvid" value="{$favVideos[i].video_id}" />
								<input type="submit" size="20" class="button" name="removfavour" value="Remove Favorites" />
							</form>
						</center>
					{/if}
				</div>

				<div class="box2">
					<p class="video-entry-title">
						<a href="{$base_url}/view/{$favVideos[i].video_id}/{$favVideos[i].video_seo_name}/">
					    {$favVideos[i].video_title}</a>
					</p>
					
					<p class="video-entry-description">{$favVideos[i].video_description}</p>
					
					<p class="video-entry-tags">
						<img width="38" height="14" src="{$img_css_url}/images/tags.gif" alt="" />
						{section name=j loop=$favVideos[i].video_keywords_array}
							<a href="{$base_url}/tag/{$favVideos[i].video_keywords_array[j]}/">{$favVideos[i].video_keywords_array[j]}</a>&nbsp;
						{/section}
					</p>
					
					<p class="video-entry-details">
						{insert name=time_to_date assign=todate tm=$favVideos[i].video_add_time}
						Added: {$todate} <br /><br />
						Views: {$favVideos[i].video_view_number} |
						{insert name=comment_count assign=commentcount vid=$favVideos[i].video_id}
						Comments: {$commentcount} <br /><br />
						Rating: {insert name=show_rate assign=vrate rte=$favVideos[i].video_rate rated=$favVideos[i].video_rated_by}{$vrate}<br />
					</p>
				</div>
				
			</div>  <!-- video-entry -->
		
		{/section}
        
        <div class="clearfix"></div>
        
		{if $page_links ne ""}
			<div class="page_links">Pages: {$page_links}</div>
		{/if}
		     
	</div> <!-- section -->
	
</div> <!-- content -->
 
<div id="sidebar">

	<div class="section bg2">
		
		<div class="hd">
			<div class="hd-l">
				<a href="{$base_url}/invite_friends.php">Share your videos !</a>
			</div>
		</div>
		
		<div class="tags">
			<b>My Tags:</b>
			{section name=k loop=$view.video_keywords_all_array}
				<p> <a href="{$base_url}/tag/{$view.video_keywords_all_array[k]}/">{$view.video_keywords_all_array[k]}</a></p>
			{/section}
		</div>
		
		<br />
        {insert name=advertise adv_name='wide_skyscraper'}
        <br />
        
	</div>

</div> <!-- sidebar -->

{else}

<h5>There is no favorite video found</h5>

{/if}