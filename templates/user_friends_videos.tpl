{if $total gt "0"}

	<div id="content">

		<div class="section bg2">
			<div class="hd">
				<div class="hd-l">My Friends Video</div>
				<div class="hd-r">Videos {$start_num}-{$end_num} of {$total}</div>
			</div>

			{section name=i loop=$videoRows}

				<div class="video-entry bg2"> 

					<div class="box1">
						<a href="{$base_url}/view/{$videoRows[i].video_id}/{$videoRows[i].video_seo_name}/">
							<img class="preview" src="{$videoRows[i].video_thumb_url}/thumb/{$videoRows[i].video_folder}1_{$videoRows[i].video_id}.jpg" width="120" height="90" alt="" />
						</a>
					</div>
							
					<div class="box2">

						<p class="video-entry-title">
							<a href="{$base_url}/view/{$videoRows[i].video_id}/{$videoRows[i].video_seo_name}/">
                                {$videoRows[i].video_title} 
							</a> 
						</p>

						<p class="video-entry-description">{$videoRows[i].video_description}</p>

						<p class="video-entry-tags">
							<img width="38" height="14" src="{$img_css_url}/images/tags.gif" />:
							{section name=j loop=$videoRows[i].video_keywords_array}
								<a href="{$base_url}/tag/{$videoRows[i].video_keywords_array[j]}/">{$videoRows[i].video_keywords_array[j]}</a>&nbsp;
							{/section}
						</p>

						<p class="video-entry-details">
							{insert name=time_to_date assign=todate tm=$videoRows[i].video_add_time}
							{insert name=id_to_name assign=uname un=$videoRows[i].video_user_id}
							Added: {$todate} by <a href="{$base_url}/{$uname}">{$uname}</a> 
							<br /><br />
							Time: {$videoRows[i].video_length} | Views: {$videoRows[i].video_view_number} |
							{insert name=comment_count assign=commentcount vid=$videoRows[i].video_id}
							Comments: {$commentcount} <br /><br />
							Rating: {insert name=show_rate assign=vrate rte=$videoRows[i].video_rate rated=$videoRows[i].video_rated_by}{$vrate} 
						</p>
		 
					</div>
					
				</div> <!-- video-entry-->
					
			{/section}

			{if $page_links ne ""}
				<div class="page_links">
					Pages: {$page_links}
				</div>
			{/if}
			
		</div><!-- section-->
		
	</div><!-- content-->

	<div id="sidebar">
	
		<div class="section  bg2">
		
			<div class="hd">
				<div class="hd-l">
					<a href="{$base_url}/invite_friends.php">Share your videos!</a>
				</div>
			</div>

			<div class="tags">
				<b>My Tags: </b>
				{section name=k loop=$view.video_keywords_array_all}
					<p> <a href="{$base_url}/tag/{$view.video_keywords_array_all[k]}/">{$view.video_keywords_array_all[k]}</a></p>
				{/section}
			</div>
			
		</div>
		
	</div>

{else}

	<div class="margin-2em" align="center">
		<p><b>You have not invited any friends or family at this time!</b></p>
		<a href="{$base_url}/invite_friends.php">Invite</a> your friends and family to start sharing videos today!
	</div>

{/if}