<div class="col-md-9">
    <div class="page-header">
        <h1>
            {$title} Members
            <small class="pull-right font-size-md btn">Members {$start_num}-{$end_num} of {$total}</small>
        </h1>
    </div>
    <div class="row">
        <div class="col-md-5 pull-right">
            <div class="input-group">
                <span class="input-group-addon">Sort by</span>
                <select name="sort" onchange="javascript:window.location.href='{$base_url}/members/' + this.value + '/';" class="form-control">
                    <option value="recent" {if $sort eq 'recent'}selected{/if}>Most Recent</option>
                    <option value="video_uploaded" {if $sort eq 'video_uploaded'}selected{/if}>Most Video Uploaded</option>
                    <option value="profile_viewed" {if $sort eq 'profile_viewed'}selected{/if}>Most Profile Viewed</option>
                    <option value="video_viewed" {if $sort eq 'video_viewed'}selected{/if}>Most Video Viewed</option>
                </select>
            </div>
        </div>
    </div>
    <div class="clarfix"></div>
    <div class="clarfix">&nbsp;</div>

    <div class="row">
        {section name=i loop=$members}
            <div class="col-orient-ls col-sm-6 col-md-4">
                <div class="thumbnail">
                    <a href="{$base_url}/{$members[i].user_name}/">
                        <img class="preview" src="{$members[i].photo_url}" alt="{$members[i].user_name}" />
                    </a>
                    <div class="caption">
                        <h5>
                            <a href="{$base_url}/{$members[i].user_name}/">{$members[i].user_name}</a>
                        </h5>
                        <p class="text-muted small">
                            Joined :{insert name=time_range assign=stime time=$members[i].user_join_time} {$stime}
                        </p>
                        <p class="text-muted small">
    			             Last Login: {insert name=time_range assign=rtime time=$members[i].user_last_login_time} {$rtime}
                        </p>
                        <p class="text-muted small">
                        	Videos Uploaded: {insert name=video_count uid=$members[i].user_id assign=video_num}<a href="{$base_url}/{$members[i].user_name}/public/1">{$video_num}</a>
                        </p>
                        <p class="text-muted small">
                        	Favorite Videos: {insert name=favour_count assign=favour_num uid=$members[i].user_id}<a href="{$base_url}/{$members[i].user_name}/favorites/1">{$favour_num}</a>
                        </p>
                        {if $sort eq "profile_viewed"}
                        	<p class="text-muted small">
                        		Profile Viewed: {$members[i].user_profile_viewed}
                        	</p>
                        {elseif $sort eq "video_viewed"}
                        	<p class="text-muted small">
                        		Video Viewed: {$members[i].user_watched_video}
                        	</p>
                        {elseif $sort eq "subscribed"}
                        	<p class="text-muted small">
                        		Subscribers: {$members[i].total}
                        	</p>
                        {else}
                        	<p class="text-muted small">
    	                    	My Friends: {insert name=friends_count assign=friends_num uid=$members[i].user_id}<a href="{$base_url}/{$members[i].user_name}/friends/1">{$friends_num}</a>
    	                    </p>
                        {/if}
                    </div>
        		</div>
            </div>
        {/section}
    </div>

    {if $page_links ne ''}
    <div>{$page_links}</div>
    {/if}
</div>

<div class="col-md-3">
   {insert name=advertise adv_name='wide_skyscraper'}
</div>