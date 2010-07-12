{if $total gt "0"}

<div class="section">

	<div class="hd" style="overflow:visible">
		<div class="hd-l">Tags for this Channel:</div>
	</div>

	<div style="padding:0.5em;">{$tags}</div>

</div>

<div class="section bg2 clearfix">

	<div class="hd">
		<div class="hd-l">Most Active Users in the Channel</div>
	</div>
    <br />
    
    {section name=i loop=$most_active_users}
        {insert name=id_to_name assign=user_name un=$most_active_users[i].video_user_id}
        <div class="channel-details-user">
            <a href="{$base_url}/{$user_name}">{insert name=member_img UID=$most_active_users[i].video_user_id}</a>
            <br />
            <a href="{$base_url}/{$user_name}">{$user_name}</a> ({$most_active_users[i].total})
        </div>
    {/section}
    
</div> <!-- section -->


<div class="section bg2 clearfix">

	<div class="hd">
		<div class="hd-l">
			Recently Added to {$channel.channel_name} Channel
		</div>
		<div class="hd-r">
			<a href="{$base_url}/channel/{$channel.channel_id}/{$channel.channel_seo_name}/recent/1">
				More Videos
			</a>
		</div>
	</div>
	
    <br />
    
	{section name=j loop=$recent_channel_videos}
        
        <div class="channel-details-video">
        
            <div class="preview channel-details-img-adjust">
	            <a href="{$base_url}/view/{$recent_channel_videos[j].video_id}/{$recent_channel_videos[j].video_seo_name}/">
	                <img src="{$recent_channel_videos[j].video_thumb_url}/thumb/{$recent_channel_videos[j].video_folder}1_{$recent_channel_videos[j].video_id}.jpg" alt="" />
	            </a>
	            <div class="video-time">{$recent_channel_videos[j].video_length}</div>
	        </div>
	        
	        <a href="{$base_url}/view/{$recent_channel_videos[j].video_id}/{$recent_channel_videos[j].video_seo_name}/">
	           {$recent_channel_videos[j].video_title}
	        </a>
    
            <p class="video_details">
                By: {insert name=id_to_name assign=user_name un=$recent_channel_videos[j].video_user_id}<a href="{$base_url}/{$user_name}">{$user_name}</a><br />
                Views: {$recent_channel_videos[j].video_view_number}<br />
                {insert name=comment_count assign=commentcount vid=$recent_channel_videos[j].video_id}
                Comments: {$commentcount}<br />
            
                {if $recent_channel_videos[j].video_rated_by gt "0"}
                    {insert name=show_rate assign=rate rte=$recent_channel_videos[j].video_rate rated=$recent_channel_videos[j].video_rated_by}{$rate}<br />
                    (rated by {$recent_channel_videos[j].video_rated_by})
               {/if}
            </p>
        </div>
        
    {/section}
	
</div> <!-- section -->

<div class="section bg2 clearfix">

	<div class="hd">
		<div class="hd-l">
			Top Watched videos in {$channel.channel_name} Channel
		</div>
		<div class="hd-r">
			<a href="{$base_url}/channel/{$channel.channel_id}/{$channel.channel_seo_name}/viewed/1">
				More Videos
			</a>
		</div>
	</div>
	
    <br />
    
	{section name=k loop=$mostview}
		
    <div class="channel-details-video">
    
        <div class="preview channel-details-img-adjust">
	        <a href="{$base_url}/view/{$mostview[k].video_id}/{$mostview[k].video_seo_name}/">
	           <img src="{$mostview[k].video_thumb_url}/thumb/{$mostview[k].video_folder}1_{$mostview[k].video_id}.jpg" alt="" />
	        </a>
	        <div class="video-time">{$mostview[k].video_length}</div>
	    </div>
        
        <a href="{$base_url}/view/{$mostview[k].video_id}/{$mostview[k].video_seo_name}/">
            {$mostview[k].video_title}
        </a>
        
        <p class="video_details">
            {insert name=id_to_name assign=user_name un=$mostview[k].video_user_id}
            By: <a href="{$base_url}/{$user_name}">{$user_name}</a><br />
            Views: {$mostview[k].video_view_number}<br />
            {insert name=comment_count assign=commentcount vid=$mostview[k].video_id}
            Comments: {$commentcount}<br />
            {if $mostview[k].video_rated_by gt "0"}
                {insert name=show_rate assign=rate rte=$mostview[k].video_rate rated=$mostview[k].video_rated_by}
                {$rate}<br />
                (rated by {$mostview[k].video_rated_by})
            {/if}
        </p>
    </div>
    
	{/section}
		
</div> <!-- section -->

{else}
    <h5>There is no video in this channel</h5>
{/if}