<div id="content">

{if $total gt "0"}

	<div class="section bg2">
		<div class="hd">
			<div class="hd-l">Friends of {$user_info.user_name}</div>
			<div class="hd-r">Friends {$start_num}-{$end_num} of {$total}</div>
		</div>

    	{section name=i loop=$friends}

        <div class="video-entry bg2 clearfix">

    		<div class="box1">{insert name=member_img UID=$friends[i].friend_friend_id}</div>
    		
            <div class="box2">
		  
                <p class="video-entry-title">
                {if $friends[i].friend_status eq "Confirmed"}
                	<a href="{$base_url}/{$friends[i].friend_name}">{$friends[i].friend_name}</a>
                {else}
                	{$friends[i].friend_name}
                {/if}
			  
                {if $friends[i].friend_status eq "Confirmed"}
        			{insert name=video_count assign=video uid=$friends[i].friend_friend_id}
        			{insert name=favour_count assign=favour uid=$friends[i].friend_friend_id}
        			{insert name=friends_count assign=frnd uid=$friends[i].friend_friend_id}</li>
    
        			<p class="video-entry-description">
        				Videos: 
        				{if $video ne "0" and $video ne ""}
        				<a href="{$base_url}/{$friends[i].friend_name}/public/">{$video}</a>{else}0{/if}
        				| Favorites: {if $favour ne "0"}<a
        				href="{$base_url}/{$friends[i].friend_name}/favorites/">{$favour}</a>{else}0{/if}
        				| Friends: {if $frnd ne "0"}<a
        				href="{$base_url}/{$friends[i].friend_name}/friends/">{$frnd}</a>{else}0{/if}
        			</p>
                {/if}
                
                {insert name=showlist assign=showlist id=$friends[i].friend_id}
					
        		<p class="video-entry-details">Lists: {$showlist} <br /><br />
        			Status: {$friends[i].friend_status}<br />
        			{if $friends[i].friend_status eq "Pending"}
        			({$friends[i].friend_invite_date|date_format:"%B %e, %Y"})
        			{/if}
        		</p>

        	</div>

        </div><!-- video-entry-->

        {/section}

    	{if $page_links ne ""}
    		<div class="page_links">Pages: {$page_links}</div>
    	{/if}

    </div> <!-- section -->

{else}
	<h5>There is no friends found</h5>
{/if}

</div>

<div id="sidebar">
   {insert name=advertise adv_name='wide_skyscraper'}
</div>