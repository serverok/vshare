<div class="section bg2">
    <div {if $video_count gt '5'}style="height: 400px;overflow: auto;"{/if}>
    {section name=i loop=$user_videos}
        <div class="col-md-4 col-sm-6">
            <div class="row">
                <div class="thumbnail">
                    <div class="preview">
                        <a href="{$base_url}/view/{$user_videos[i].video_id}/{$user_videos[i].video_seo_name}/">
                            <img class="img-responsive" width="100%" src="{$user_videos[i].video_thumb_url}/thumb/{$user_videos[i].video_folder}1_{$user_videos[i].video_id}.jpg" alt="{$user_videos[i].video_title}">
                        </a>
                        <span class="badge video-time">{$user_videos[i].video_length}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8 col-sm-6">
            <h5>
                <a href="{$base_url}/view/{$user_videos[i].video_id}/{$user_videos[i].video_seo_name}/" target="_parent">
                    {$user_videos[i].video_title|truncate: 30}
                </a>
            </h5>
            <p class="text-muted small">
                Views: {$user_videos[i].video_view_number} |
                Comments: {$user_videos[i].video_com_num}
            </p>

            {if $smarty.request.video_id eq $user_videos[i].video_id}
                <p class="small"><strong><span class="glyphicon glyphicon-play"></span> NOW PLAYING!</strong></p>
            {/if}
        </div>
		<div class="clearfix"><hr></div>
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