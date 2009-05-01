<br />

{if $total gt "0"}

<div id="content">

	<div class="section">

		<div class="hd">
			<div class="hd-l">My Friend's Favorites</div>
			<div class="hd-r">Videos {$start_num}-{$end_num} of {$total}</div>
		</div>
				
		{section name=i loop=$answers}
		
		<div class="video-entry bg2">
		   
			<div class="box1">
				<a href="{$base_url}/view/{$answers[i].video_id}/{$answers[i].video_seo_name}/">
					<img src="{$answers[i].video_thumb_url}/thumb/{$answers[i].video_folder}1_{$answers[i].video_id}.jpg" width="120" height="90" alt="" />
				</a>
			</div>
			  
			<div class="box2">
			
				<p class="video-entry-title">
					<a href="{$base_url}/view/{$answers[i].video_id}/{$answers[i].video_seo_name}/">
						{$answers[i].video_title}
					</a>
				</p>
								  
				<p class="video-entry-description">{$answers[i].video_description}</p>
							
				<p class="video-entry-tags">
					<img width="38" height="14" src="{$img_css_url}/images/tags.gif" alt="" />:
					{section name=j loop=$answers[i].video_keywords_array}
						<a href="{$base_url}/tag/{$answers[i].video_keywords_array[j]}/">{$answers[i].video_keywords_array[j]}</a>&nbsp;
					{/section}
				 </p>

				<p class="video-entry-details">
					{insert name=id_to_name assign=uname un=$answers[i].video_user_id}
					{insert name=time_to_date assign=todate tm=$answers[i].video_add_time}
					Added: {$todate} by <a href="{$base_url}/{$uname}">{$uname}</a>  <br /><br />

					{assign var="favorited_video_id" value=$answers[i].video_id}
					 favorited by {$favorited_by.$favorited_video_id}<br /><br />

					Time: {$answers[i].video_length} | Views: {$answers[i].video_view_number} |
					{insert name=comment_count assign=commentcount vid=$answers[i].video_id}
					Comments: {$commentcount} 
					Rating: {insert name=show_rate assign=vrate rte=$answers[i].video_rate rated=$answers[i].video_rated_by}{$vrate}
				</p>

			</div>
        
        </div>
        
		{/section}

    	{if $page_links ne ""}
    		<div class="page_links">Pages: {$page_links}</div>
    	{/if}
    
    </div> <!-- section -->

</div><!-- content end -->

<div id="sidebar">
    {insert name=advertise adv_name='wide_skyscraper'}
</div>

{else}

<div width="550" align="center">
	<h5>You have not invited any friends or family at this time!</h5>
	<div class="margin-bottom-large">
        <a href="{$base_url}/invite_friends.php">Invite</a> your friends and family to start sharing videos today!
    </div>
</div>

{/if}