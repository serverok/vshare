<div id="content">
	
	Sort by:
	<select name="sort" onchange="javascript:window.location.href='{$base_url}/members/' + this.value + '/';">
		<option value="recent" {if $sort eq 'recent'}selected{/if}>Most Recent</option>
		<option value="video_uploaded" {if $sort eq 'video_uploaded'}selected{/if}>Most Video Uploaded</option>
		<option value="profile_viewed" {if $sort eq 'profile_viewed'}selected{/if}>Most Profile Viewed</option>
		<option value="video_viewed" {if $sort eq 'video_viewed'}selected{/if}>Most Video Viewed</option>
		<option value="subscribed" {if $sort eq 'subscribed'}selected{/if}>Most Subscribed</option>
	</select>
	
	<br /><br />
	
    <div class="section">
        
        <div class="hd">
             <div class="hd-l">{$title} Members</div>
             <div class="hd-r">Members {$start_num}-{$end_num} of {$total}</div>
        </div>
        
        <div class="video_block clearfix">
        	
        	{section name=i loop=$members}
        	
        		<div class="watch-video-box">
        			
        			<p class="video_title">
                        <a href="{$base_url}/{$members[i].user_name}/">
                            <img class="preview" src="{$members[i].photo_url}" alt="{$members[i].user_name}" />
                        </a>
                    </p>
                    
                    <p class="video_title">
                        <a href="{$base_url}/{$members[i].user_name}/">{$members[i].user_name}</a>
                    </p>
                    
                    <p class="video_details">
                        Joined :{insert name=time_range assign=stime field=user_join_time IDFR=user_id id=$members[i].user_id tbl=users} {$stime}
                    </p>
                    
                    <p class="video_details">
                    	Last Login: {insert name=time_range assign=rtime field=user_last_login_time IDFR=user_id id=$members[i].user_id tbl=users}{$rtime}
                    </p>
                    
                    <p class="video_details">
                    	Videos Uploaded: {insert name=video_count uid=$members[i].user_id assign=video_num}<a href="{$base_url}/{$members[i].user_name}/public/1">{$video_num}</a>
                    </p>
                    
                    <p class="video_details">
                    	Favorite Videos: {insert name=favour_count assign=favour_num uid=$members[i].user_id}<a href="{$base_url}/{$members[i].user_name}/favorites/1">{$favour_num}</a>
                    </p>
                    
                    {if $sort eq "profile_viewed"}
                    	<p class="video_details">
                    		Profile Viewed: {$members[i].user_profile_viewed}
                    	</p>
                    {elseif $sort eq "video_viewed"}
                    	<p class="video_details">
                    		Video Viewed: {$members[i].user_watched_video}
                    	</p>
                    {elseif $sort eq "subscribed"}
                    	<p class="video_details">
                    		Subscribers: {$members[i].total}
                    	</p>
                    {else}
                    	<p class="video_details">
	                    	My Friends: {insert name=friends_count assign=friends_num uid=$members[i].user_id}<a href="{$base_url}/{$members[i].user_name}/friends/1">{$friends_num}</a>
	                    </p>
                    {/if}
        		</div>
        	
        	{/section}
        	
        </div>        
        
		<div class="page_links">
			Pages: &nbsp; {$page_links}
		</div>
        
	</div>
	
</div>

<div id="sidebar">
   {insert name=advertise adv_name='wide_skyscraper'}
</div>
