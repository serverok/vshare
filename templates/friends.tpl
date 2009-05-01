<div id="content">

    {if $total_friends eq "0"}

        <div class="no-friends">
            <span>You have not invited any friends or family at this time!</span>
            <p><a href="{$base_url}/invite_friends.php">Invite</a> Your friends and family to start sharing videos today!</p>
        </div>
    
    {else}
    
        <form id="friendsForm" name="friendsForm" action="" method="post">
        
            <input type="hidden" name="action_name" id="action_name" />
            <input type="hidden" name="view" />
            <input type="hidden" value="t" name="sort" />
            <input type="hidden" value="1" name="page" />
            
            <div class="section bg2">
            
                <div class="hd">
                
                    <div class="hd-l">
                        My Contacts : 
                        {if $smarty.request.view eq ""}
                            Overview
                        {else}
                            {$smarty.request.view}
                        {/if}
                    
                        {if $smarty.request.view ne "" and $smarty.request.view ne "All"}
                            &nbsp; 
                                (<a href="friends.php?del_list={$smarty.get.view}" onclick="javascript: return confirm('Are you sure you want to delete this contact group?')">
                                    Delete list
                                </a>)
                        {/if}
                    </div>
                    
                    <div class="hd-r">
                        {if $smarty.request.sort ne "name"}
                            <a href="friends.php?sort=name">Sort by Name</a> | Sort by Date Added
                        {else}
                            Sort by Name | <a href="friends.php">Sort by Date Added</a>
                        {/if}
                    </div>
                
                </div>
                
                <br />
                
                <div class="dropdownnav">
                    View:
                    <select name="view" onchange="javascript: document.location.href='{$base_url}/friends.php?view='+this.value;">
                        {$ftype_ops}
                    </select>
                
                    {if $total ne "0"}{$link}{/if}
                </div>
                
                {section name=i loop=$friends}
                
                    <div class="video-entry bg2">  
                            
                        <div class="box1">
                            {if $friends[i].friend_id ne ''}
                                <a href="{$base_url}/{$friends[i].friend_name}">
                                    {insert name=member_img UID=$friends[i].friend_friend_id}
                                </a>
                            {/if}
                        </div>
                            
                        <div class="box2">
                        
                            <p class="video-entry-title">
                                <input id="AID[]" type="checkbox" value="{$friends[i].friend_id}" name="AID[]" />
                                {if $friends[i].friend_status eq "Confirmed"}
                                    <a href="{$base_url}/{$friends[i].friend_name}">{$friends[i].friend_name}</a>
                                {else}
                                    {$friends[i].friend_name}
                                {/if}
                            </p>
                                
                            {if $friends[i].friend_status eq "Confirmed"}
                    
                                {insert name=video_count assign=video uid=$friends[i].friend_friend_id}
                                {insert name=favour_count assign=favour uid=$friends[i].friend_friend_id}
                                {insert name=friends_count assign=frnd uid=$friends[i].friend_friend_id}
                                   
                                <p class="video-entry-description">
                                    Videos: 
                                    {if $video ne "0" and $video ne ""}
                                        <a href="{$base_url}/{$friends[i].friend_name}/public/">{$video}</a>
                                    {else}
                                        0
                                    {/if}
                                    | Favorites: 
                                    {if $favour ne "0"}
                                        <a href="{$base_url}/{$friends[i].friend_name}/favorites/">
                                            {$favour}
                                        </a>
                                        {else}
                                            0
                                        {/if}
                                    | Friends: {if $frnd ne "0"}
                                    <a href="{$base_url}/{$friends[i].friend_name}/friends/">
                                        {$frnd}
                                    </a>
                                    {else}
                                        0
                                    {/if}
                                </p>
                    
                            {/if}
                            
                            {insert name=showlist assign=showlist id=$friends[i].friend_id}
                            <p class="video-entry-details">
                                Lists: {$showlist}
                                <br />
                                <br />
                                Status: {$friends[i].friend_status}
                                {if $friends[i].friend_status eq "Pending"}
                                    ({$friends[i].friend_invite_date|date_format:"%B %e, %Y"})
                                {/if}
                            </p>
                            
                        </div>
                        
                    </div>   <!-- video-entry -->
                    
                {/section}
                
                <img height="3" src="{$img_css_url}/images/spacer.gif" width="30" border="0" alt="" />
             
                <div>
                    <br />
                    <select id="action" onchange=doAction(this.value) name="action">
                        {$action_ops}
                    </select>
                    <a href="javascript:createNewList();">
                        New List
                    </a>
                </div>
                
                {if $page_links ne ""}
                    <div class="page_links">
                        Browse Pages: &nbsp;  {$page_links}
                    </div>
                {/if}
                
            </div> <!-- section -->
            
        </form>

    {/if}

</div>

<div id="sidebar">
   {insert name=advertise adv_name='wide_skyscraper'}
</div>