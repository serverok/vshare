{if $total gt "0"}

<div id="content">

	<div class="section bg2">

		<div class="hd">
		
			<div class="hd-l">
				Members of Group: 
				<a  href="{$base_url}/group/{$group_info.group_url}/">
					{$group_info.group_name}
				</a>
			</div>
			
			<div class="hd-r">
				Members {$start_num}-{$end_num} of {$total}
			</div>
			
		</div>

		{section name=i loop=$group_members}
		
			{if $smarty.session.UID eq $group_info.group_owner_id or $group_members[i].group_member_approved eq "yes"}
		
				<div class="video-entry bg2">   
			
					<div class="box1">
						{insert name=member_img UID=$group_members[i].group_member_user_id}
					</div> 
			
					<div class="box2">
					
						<p class="video-entry-title">
							{insert name=id_to_name assign=uname un=$group_members[i].group_member_user_id}
							<a href="{$base_url}/{$uname}">{$uname}</a>
						</p>
						
						{insert name=video_count assign=video uid=$group_members[i].group_member_user_id}
						{insert name=favour_count assign=favour uid=$group_members[i].group_member_user_id}
						{insert name=friends_count assign=frnd uid=$group_members[i].group_member_user_id}

						<p class="video-entry-description">
							Videos: {if $video ne "0" and $video ne ""}<a href="{$base_url}/{$uname}/public/">{$video}</a>{else}0{/if}
							| Favorites: {if $favour ne "0"}<a href="{$base_url}/{$uname}/favorites/">{$favour}</a>{else}0{/if}
							| Friends: {if $frnd ne "0"}<a href="{$base_url}/{$uname}/friends/">{$frnd}</a>{else}0{/if}
						</p>

						<p class="video-entry-details">
							Member Since: {$group_members[i].group_member_since|date_format}
							
							{if $smarty.session.UID eq $group_info.group_owner_id and $group_members[i].group_member_approved eq "no"}
								<form action="{$base_url}/group/{$group_info.group_url}/members/{$page}" method="post" >
								<input type="hidden" name="AID" value="{$group_members[i].AID}" />
								<input type="hidden" name="MID" value="{$group_members[i].group_member_user_id}" />
								<input type="submit" class="button" name="approve_mem" value="Approve {$uname}" />
								</form>
							{/if}

							{if $smarty.session.UID eq $group_info.group_owner_id and $group_info.group_owner_id ne $group_members[i].group_member_user_id}
								<form action="{$base_url}/group/{$group_info.group_url}/members/{$page}" method="post" onsubmit="javascript: return confirm('Are you sure to delete this member from the group?');">
								<input type="hidden" name="member_id" value="{$group_members[i].group_member_user_id}" />
								<input type="submit" class="button" name="remove_mem" value="Remove From Group" />
								</form>
							{/if}
						</p>
						
					</div>
					
				</div> <!-- video-entry  -->
				
			{/if}
			
		{/section}

		{if $page_link ne ''}
			<div class="page_links">Pages: {$page_link}</div>
		{/if}

	</div> <!-- section -->

</div> <!-- content -->

{/if}

<div id="sidebar">
    {insert name=advertise adv_name='wide_skyscraper'}
</div>