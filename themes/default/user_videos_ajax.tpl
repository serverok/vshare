<div class="section bg2">
    <div {if $video_count gt '5'}style="height: 400px;overflow: auto;"{/if}>
    {section name=i loop=$user_videos}
	
		<div class="clearfix">
		
			{if $smarty.request.video_id eq $user_videos[i].video_id}
			<div class="related-video playing-bg clearfix">
                {else}
                <div class="related-video clearfix">
                {/if}

				<div class="box1">
				    <div class="preview related-video-img-adjust">
				        <a href="{$base_url}/view/{$user_videos[i].video_id}/{$user_videos[i].video_seo_name}/" target="_parent">
						  <img src="{$user_videos[i].video_thumb_url}/thumb/{$user_videos[i].video_folder}1_{$user_videos[i].video_id}.jpg" alt="{$user_videos[i].video_title}" />
					   </a>
					   <div class="video-queue" id="{$user_videos[i].video_id}_user" rel="video_queue" style="width:77px;">&nbsp;</div>
					   <div class="video-time">{$user_videos[i].video_length}</div>
					</div>
				</div>

				<div class="box2">

					<div class="moduleFrameTitle">
						<a href="{$base_url}/view/{$user_videos[i].video_id}/{$user_videos[i].video_seo_name}/" target="_parent">
							{$user_videos[i].video_title}
						</a>
					</div>

					<div class="moduleFrameDetails"></div>

					<div class="moduleFrameDetails">
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
		<div align="center" style="text-align: center;margin: 10px;">
            <a href="{$base_url}/{$user_name}/public/1">Sell All {$video_count} videos</a>
		</div>
	{/if}

	</div>
	
</div>
<script language="JavaScript" type="text/javascript" src="{$base_url}/js/video_queue.js"></script>

{literal}
<script type="text/javascript">
//$(document.ready(function(){
    $('div [rel=video_queue]').each(function(){
           $(this).click(function(){
                 var myClass = new Array();
                 myClass['video-queue'] = 'video-queue-info';
                 myClass['video-queue-info'] = 'video-queue-info';
                 var video_id = $(this).attr('id');
                 var class = $(this).attr('class');
                 $("#"+video_id).removeClass(class).addClass(myClass[class]);
                 $("#"+video_id).html('Added to queue');
            });
});
//});
</script>
{/literal}