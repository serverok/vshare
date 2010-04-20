<html>
<head>
<title>404 Not Found</title>
<link href="{$img_css_url}/css/404.css" rel="stylesheet" type="text/css" />
</head>
<body align="center">
<center>
<div id="404" style="width:650px;">
	<div id="message" class="rounded-corner">{$msg}</div>
	<div id="search-wrapper" class="rounded-corner">
	   <div class="logo"><img src="{$img_css_url}/images/logo.jpg"></div>
	   <div style="box-sizing:border-box;float:left;padding:14px 0 0px 10px;">
		   <form method="get" action="{$base_url}/search.php">
		       <input type="text" value="" name="search" />
		       <input type="hidden" value="video" name="type">
		       <input type="submit" class="search-btn" value="Search" />
		   </form>
	   </div>
	</div>

	<div id="links">
	   <a href="{$base_url}/featured/">Featured Videos</a> |
	   <a href="{$base_url}/rated/">Top Rated Videos</a> |
	   <a href="{$base_url}/viewed/">Most Watched Videos</a>
	</div>

	   <div style="margin-top:10px;">
	       <div id="featured_box">
	           Featured Videos
	       </div>
	       <br>
		    <div id="video_box">
			   {section name=i loop=$video_info}
			       <div class="featured_video_box">
			           <a href="{$base_url}/view/{$video_info[i].video_id}/{$video_info[i].video_seo_name}/">
			           <img width="120" height="80" src="{$video_info[i].video_thumb_url}/thumb/{$video_info[i].video_folder}1_{$video_info[i].video_id}.jpg" alt="{$video_info[i].video_title}" border="0" class="video_image" />
			           </a>
			           <a href="{$base_url}/view/{$video_info[i].video_id}/{$video_info[i].video_seo_name}/" style="font-weight:bold;">
			             {$video_info[i].video_title|truncate:25:'...'}
			           </a><br />
			           {insert name=time_range assign=added_on field=video_add_time IDFR=video_id id={insert name=time_range assign=added_on field=video_add_time IDFR=video_id id=$video_info[i].video_id tbl=videos}
			           <span class="featured_video_box_span">{$added_on}</span><br />
			           <span class="featured_video_box_span">{$video_info[i].video_view_number} views</span><br />
			           <span class="featured_video_box_span">
			           {if $video_info[i].video_rated_by gt "0"}
                        {insert name=show_rate assign=rate rte=$video_info[i].video_rate rated=$video_info[i].video_rated_by}
                        {$rate}
                       {else}
                        no rating
                       {/if}
                       </span><br />
                       {insert name=id_to_name assign=user_name un=$video_info[i].video_user_id}
                       <a style="font-size : 10px;" href="{$base_url}/{$user_name}">{$user_name}</a>
			       </div>
			   {/section}
		   </div>
		   
	   </div>
	

		<div class="copy">
		    Copyright &copy; {$smarty.now|date_format:"%Y"} {$site_name}. All rights reserved.<br />
		    <!--
		    REMOVING THE LINE BELOW CONSTITUTES A VIOLATION
		    OF YOUR LICENSE AGREEMENT AND WILL RESULT IN
		    SIGNIFICANT PENALITIES IF REMOVED.
		    -->
		    Powered by <a class="copy" href="http://buyscripts.in/youtube_clone.html" target="_blank">vShare</a>
		</div>
</div>
</center>
</body>
</html>