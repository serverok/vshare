<link href="{$img_css_url}/css/404.css" rel="stylesheet" type="text/css" />

<center>

	<div id="message">{$msg_404}</div>
	
	<div class="links clear">
	   <a href="{$base_url}/featured/">Featured Videos</a> |
	   <a href="{$base_url}/rated/">Top Rated Videos</a> |
	   <a href="{$base_url}/viewed/">Most Watched Videos</a>
	</div>
	
	<div class="video_section clear section">
		<div class="featured_videos clearfix hd">Featured Videos</div>
	    <div class="video_box clear">
	        {section name=i loop=$video_info}
	        <div class="featured_video_box">
	            <a href="{$base_url}/view/{$video_info[i].video_id}/{$video_info[i].video_seo_name}/">
		           <img width="140" height="90" src="{$video_info[i].video_thumb_url}/thumb/{$video_info[i].video_folder}1_{$video_info[i].video_id}.jpg" alt="{$video_info[i].video_title}" border="0" class="video_image" />
	            </a>
	            <span class="featured_video_box_span">
		            <a href="{$base_url}/view/{$video_info[i].video_id}/{$video_info[i].video_seo_name}/" style="font-weight:bold;">
		                {$video_info[i].video_title|truncate:25:'...'}
		            </a>
	            </span>
	            {insert name=time_range assign=added_on field=video_add_time IDFR=video_id id=$video_info[i].video_id tbl=videos}
	            <span class="featured_video_box_span">{$added_on}</span>
	            <span class="featured_video_box_span">{$video_info[i].video_view_number} views</span>
	            <span class="featured_video_box_span">
	            {if $video_info[i].video_rated_by gt "0"}
	                {insert name=show_rate assign=rate rte=$video_info[i].video_rate rated=$video_info[i].video_rated_by}
	                {$rate}
	            {else}
	                no rating
	            {/if}
	            </span>
	            {insert name=id_to_name assign=user_name un=$video_info[i].video_user_id}
	            <span class="featured_video_box_span">
	               <a href="{$base_url}/{$user_name}">{$user_name}</a>
	            </span>
	        </div>
			{/section}
	    </div>
    </div>
    
</center>
