
<div class="section bg2">
	
	<div {if $video_count gt '5'}style="height: 400px;overflow: auto;"{/if}>
	
		{section name=i loop=$user_videos}
	
			<div class="clearfix">
			
				{if $smarty.request.video_id eq $user_videos[i].video_id}
				<div class="related-video playing-bg">
                {else}
                <div class="related-video">
                {/if}
	
					<div class="box1">
						<a href="{$base_url}/view/{$user_videos[i].video_id}/{$user_videos[i].video_seo_name}/" target="_parent">
							<img class="preview" src="{$user_videos[i].video_thumb_url}/thumb/{$user_videos[i].video_folder}1_{$user_videos[i].video_id}.jpg" width="80" height="60" alt="related videos" />
						</a>
					</div>

					<div class="box2">

						<div class="moduleFrameTitle">
							<a href="{$base_url}/view/{$user_videos[i].video_id}/{$user_videos[i].video_seo_name}/" target="_parent">
								{$user_videos[i].video_title}
							</a>
						</div>

						<div class="moduleFrameDetails"></div>

						<div class="moduleFrameDetails">
							Time: {$user_videos[i].video_length}<br />
							Views: {$user_videos[i].video_view_number}<br />
							Comments: {$user_videos[i].video_com_num}
						</div>
						
						{if $smarty.request.video_id eq $user_videos[i].video_id}
	                        <div class="playing-now">
	                            &lt;&lt;&lt;NOW PLAYING!
	                        </div>
	                    {/if}

					</div>
					
				</div><!-- related video -->
			</div>
		
		{/section}
		
		{if $video_count gt '20'}
			<div align="center" style="text-align: center;margin: 10px;"><a href="{$base_url}/{$user_name}/public/1">Sell All {$video_count} videos</a></div>
		{/if}
	
	</div>
	
</div>


