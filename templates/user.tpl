<div class="user-profile">

    <div class="box1">
    
        <div class="section bg2">
        
            <div class="hd">
                <div class="hd-l">{$user_info.user_name}'s Profile</div>
            </div>
        
            <div class="float-l">
                <a href="{$base_url}/{$user_info.user_name}"><img src="{$photo_url}" width="80" height="80" alt="{$user_info.user_name}" /></a>
            </div>
                
            <div class="float-r">
            
                {if $user_info.user_first_name ne "" OR $user_info.user_last_name ne ""}
                    {$user_info.user_first_name} {$user_info.user_last_name}<br />
                {/if}
                
                {if $user_info.user_birth_date ne "0000-00-00"}
                    {$age} years old<br />
                {/if}
                
                {if $user_info.user_gender ne ""}
                    {$user_info.user_gender}<br />
                {/if}
                
                {if $user_info.user_town ne ""}
                    {$user_info.user_town}<br />
                {/if}
                
                {if $user_info.user_city ne ""}
                    {$user_info.user_city}<br />
                {/if}
                
                {if $user_info.user_country ne ""}
                    {$user_info.user_country}<br />
                {/if}
                Last Login: {insert name=time_range assign=rtime field=user_last_login_time IDFR=user_id id=$user_info.user_id tbl=users}{$rtime}
            </div>
       
            <div class="clear"></div>
        
            {if $smarty.session.USERNAME eq $user_info.user_name}
                {if $enable_package eq "yes"}
                    <p>I have uploaded <b>{$u_info.total_video}</b> videos {if $pack.package_videos gt "0"} out of {$pack.package_videos} videos{/if}.<br />
                    Space I have used <b>{insert name=format_size size=$u_info.used_space}</b> out of {insert name=format_size size=$pack.package_space}</p>
                {/if}
            {/if}
            
            <!-- user rating -->
            
            <script type="text/javascript">
                var candidate_id = {$user_info.user_id};
            </script>

            {if $chkuserflag ne "self"}
            
                {if $chkuserflag eq "guest"}
                    <div id="user_vote_result">
                        <!-- <table border="0" align="center">
                        <tr>
                            <td align="center">
                                Rate Me
                                <img class="rating" src="{$img_css_url}/images/blank_star.gif" onclick="user_rate({$smarty.session.UID},{$user_info.user_id},1)" alt="" />
                                <img class="rating" src="{$img_css_url}/images/blank_star.gif" onclick="user_rate({$smarty.session.UID},{$user_info.user_id},2)" alt="" />
                                <img class="rating" src="{$img_css_url}/images/blank_star.gif" onclick="user_rate({$smarty.session.UID},{$user_info.user_id},3)" alt="" /> 
                                <img class="rating" src="{$img_css_url}/images/blank_star.gif" onclick="user_rate({$smarty.session.UID},{$user_info.user_id},4)" alt="" />
                                <img class="rating" src="{$img_css_url}/images/blank_star.gif" onclick="user_rate({$smarty.session.UID},{$user_info.user_id},5)" alt="" />
                            </td>
                        </tr>
                        </table> -->
                        Rate Me {insert name=user_rate user_id=$user_info.user_id}
                    </div>
                {/if}
                
            {/if}
            
            {if $chkuserflag eq ""}
                <div style="padding-bottom: 10px">
                    <a href="{$base_url}/signup/">Sign up</a> or
                    <a href="{$base_url}/login/">Log in</a> to add {$user_info.user_name} as a friend.
                </div>
            {/if}
            
            {if $smarty.session.USERNAME eq $user_info.user_name}
                [ <a class="submenu" href="{$base_url}/{$user_info.user_name}/edit/">Edit Profile</a> ] |
                [ <a class="submenu" href="{$base_url}/user_photo_upload.php">Upload Photo</a> ]<br /><br />
                [ <a class="submenu" href="{$base_url}/user_privacy.php">Privacy Settings</a> ] |
                {if $enable_package eq "yes"}
                    [ <a class="submenu" href="{$base_url}/renew_account.php?uid={$user_info.user_id}&action=upgrade">Upgrade Package</a> ] |
                {/if}
                [ <a class="submenu" href="{$base_url}/user_delete.php">Delete Account</a> ]<br />
            {/if}

            <!-- user details -->
           
            <div class="margin-1em">
            
                Videos Watched <b>{$user_info.user_video_viewed}</b> times<br />
                Profile viewed <b>{$user_info.user_profile_viewed}</b> times<br />
                I've watched <b>{$user_info.user_watched_video}</b> videos<br />
                {insert name=friends_count assign=num_friends uid=$user_info.user_id}
                I have <b>{$num_friends}</b> 
                <a href="{$base_url}/{$user_info.user_name}/friends/">
                    friends
                </a>
            </div>
        
            <div class="user-info"> 
                <b>Signed up :</b> {insert name=time_range assign=stime field=user_join_time IDFR=user_id id=$user_info.user_id tbl=users} {$stime}
            </div>

            {if $user_info.relation ne ""}
                <div class="user-info"><b>Relation :</b> {$user_info.relation}</div>
            {/if}
            
            {if $user_info.user_about_me ne ""}
                <div class="user-info"><b>About Me : </b>{$user_info.user_about_me}</div>
            {/if}
            
            {if $user_info.user_website ne ""}
                <div class="user-info"><b>Website :</b>
                    <a href="{$user_info.user_website}" target="_blank">{$user_info.user_website}</a>
                </div>
            {/if}
            
            {if $user_info.user_zip ne ""}
                <div class="user-info">
                    <b>Country ZIP : </b>{$user_info.user_zip}
                </div>
            {/if}
        
            {if $user_info.user_occupation ne ""}
                <div class="user-info">
                    <b>Occupation : </b>{$user_info.user_occupation}
                </div>
            {/if}
            
            {if $user_info.user_company ne ""}
                <div class="user-info">
                    <b>Companies : </b>{$user_info.user_company}
                </div>
            {/if}
            
            {if $user_info.user_school ne ""}
                <div class="user-info">
                    <b>Schools : </b>{$user_info.user_school}   
                </div>
            {/if}
            
            {if $user_info.user_interest_hobby ne ""}
                <div class="user-info"> 
                    <b>Interests &amp; Hobbies : </b>{$user_info.user_interest_hobby}
                </div>
            {/if}
            
            {if $user_info.user_fav_movie_show ne ""}
                <div class="user-info">
                    <b>Favourite Movies &amp; Shows : </b>
                    {$user_info.user_fav_movie_show}
                </div>
            {/if}
            
            {if $user_info.user_fav_music ne ""}
                <div class="user-info">
                    Favourite Music : </b> {$user_info.user_fav_music}
                </div>
            {/if}
            
            {if $user_info.user_fav_book ne ""}
                <div class="user-info">
                    <b>Favourite Books : </b>{$user_info.user_fav_book}
                </div>
            {/if}
            
            {if $user_info.user_friends_name ne ""}
                <div class="user-info"> 
                    <b>Friends : </b> {$user_info.user_friends_name}
                </div>
            {/if}
       
        </div>    <!-- section end-->    
        
        <div class="section bg2 clearfix">
        
            <div class="hd">
                <div class="hd-l">Connect with {$user_info.user_name}</div>
            </div>
            
            <div class="margin-1em">
            
                <div class="float-l">
                    <a href="{$base_url}/{$user_info.user_name}"><img src="{$photo_url}" width="80" height="80" alt="{$user_info.user_name}" /></a>
                </div>
                
                <div class="float-r">
                    {if $allow_comment eq '1'}
                    <a href="#profile-comments">
                        <img src="{$base_url}/templates/images/add-comment.gif" alt="add comments" width="20" height="17">Add Comments
                    </a>
                    {/if}
                    <br />
                    
                    {if $is_friend ne "yes"}
                        {if $allow_friend eq '1'}
                        <a href="{$base_url}/invite_friends.php?UID={$user_info.user_id}">
                            <img src="{$base_url}/templates/images/add-friends.gif" alt="add friends" width="20" height="17"/>Add as Friend 
                        </a>
                        {/if}
                        <br />
                    {/if}
                    
                    {if $allow_private_message eq '1'}
                    <a href="compose.php?receiver={$user_info.user_name}">
                        <img src="{$base_url}/templates/images/send-message.gif" width="20" height="17" alt="send message"/>Send Messages 
                    </a> 
                    {/if}
                    <br /> 
                    <br /> 
                    <!-- AddThis Button BEGIN -->
                    <script type="text/javascript">var addthis_pub="buyscripts";</script>
                    <a href="http://www.addthis.com/bookmark.php?v=20" onmouseover="return addthis_open(this, '', '[URL]', '[TITLE]')" onmouseout="addthis_close()" onclick="return addthis_sendto()"><img src="http://s7.addthis.com/static/btn/lg-share-en.gif" width="125" height="16" alt="Bookmark and Share" style="border:0"/></a><script type="text/javascript" src="http://s7.addthis.com/js/200/addthis_widget.js"></script>
                    <!-- AddThis Button END -->
                </div>
                
                <div class="clear"></div>
                
                <b>
                    {$user_info.user_name}'s Profile Url:<br /><br />
                    <a href="{$base_url}/{$user_info.user_name}">{$base_url}/{$user_info.user_name}</a>
                </b>
            </div> 
            
        </div>
    
        <div class="section bg2 clearfix">
        
            <div class="hd">
              <div class="hd-l">{$user_info.user_name}'s Groups</div>
              <div class="hd-r"><a href="{$base_url}/{$user_info.user_name}/groups/">More</a></div>
            </div>
            
            <ul id="user-groups">
                {section name=i loop=$groups start=0 max=6}
                    {insert name=group_image assign=group_image_info gid=$groups[i].group_id tbl=group_videos}
                    {insert name=time_to_date assign=todate tm=$groups[i].group_create_time}
                    <li>
                        <a href="{$base_url}/group/{$groups[i].group_url}/">
                        {if $group_image_info eq "0"}
                        <img class="preview" src="{$img_css_url}/images/no_videos_groups.gif" width="70px" height="50" alt="" />
                        {else}
                        <img class="preview" width="70px" height="50" alt="" src="{$group_image_info.video_thumb_url}/thumb/{$group_image_info.video_folder}1_{$group_image_info.video_id}.jpg" alt="" />
                        {/if} 
                        </a>
                        <a href="{$base_url}/group/{$groups[i].group_url}/">
                        {$groups[i].group_name}
                        </a><br />
                        {insert name=row_count assign=num_group_members group_id=$groups[i].group_id table=group_members field1=group_member_group_id field2=group_member_approved}
                        {insert name=group_info_count assign=num_group_videos tbl=group_videos gid=$groups[i].group_id query="1" field1=group_video_approved field2=group_video_group_id}
                            
                        {if $num_group_members gt 0}
                            <a href="{$base_url}/group/{$groups[i].group_url}/members/1">{$num_group_members}</a>
                        {else}
                            <a>{$num_group_members}</a>
                        {/if}
                        members
                        <br />
                        {if $num_group_videos gt 0}
                            <a href="{$base_url}/group/{$groups[i].group_url}/videos/1">{$num_group_videos}</a>
                        {else}
                            <a>{$num_group_videos}</a>
                        {/if}
                        Videos
                    </li>
                {sectionelse}
                
                    <div align="center">
                        <p>This user is not a member of any groups.</p>
                        {if $smarty.session.USERNAME == $user_info.user_name}
                        <p><a href="{$base_url}/group/new/">Click here</a> to create a group now</p>
                        {/if}
                    </div>
                
                {/section}
            </ul>
        </div><!-- user group end-->    

    </div>  <!-- box1 end-->

    <div class="box2">
                    <!-- NEW VIDEOS START -->
                    {if $new_video_total gt "0"}

            <div class="section bg2 clearfix">
               <div class="hd">
                  <div class="hd-l">New Videos</div>
                  <div class="hd-r">
                  <a href="{$base_url}/{$user_info.user_name}/public/">More Videos</a>
                   </div>
               </div>
                    <br />
                <ul id="user-video">
                   {section name=i loop=$new_video start=0 max=4}
                <li>
                    <a href="{$base_url}/view/{$new_video[i].video_id}/{$new_video[i].video_seo_name}/">
                    <img class="preview" src="{$new_video[i].video_thumb_url}/thumb/{$new_video[i].video_folder}1_{$new_video[i].video_id}.jpg" 
                   width="120" height="90" alt="{$new_videos[i].video_title}" /><br />
                   {$new_video[i].video_title|truncate:25:'...'}
                   </a>
                   <br />                         
                </li>
                   {/section}
                </ul>
            </div>     <!-- NEW VIDEOS ENDS -->

           <div class="section bg2 clearfix">
                   <div class="hd">
                        <div class="hd-l">Popular Videos</div>
                          <div class="hd-r">
                          <a href="{$base_url}/{$user_info.user_name}/public/">More Videos</a>
                          </div>
                        </div>
                        <br />
                   <ul id="user-video">
                        {section name=i loop=$popular start=0 max=4}
                    <li>
                        <a href="{$base_url}/view/{$popular[i].video_id}/{$popular[i].video_seo_name}/">
                        <img class="preview" src="{$popular[i].video_thumb_url}/thumb/{$popular[i].video_folder}1_{$popular[i].video_id}.jpg" width="120" height="90" alt="{$popular[i].video_title}" /><br />
                        {$popular[i].video_title|truncate:25:'...'}
                        </a>
                     </li>
                        {/section}
                   </ul>
           </div>

        {/if}
        
        <!-- user friends -->
        
        <div class="section bg2 clearfix">
            
            <div class="hd">
                <div class="hd-l">New Friends</div>
                <div class="hd-r">
                    <a href="{$base_url}/{$user_info.user_name}/friends/">More Friends</a>
                </div>
            </div>
            <br />
            
            <ul id="user-friend">
                {section name=i loop=$user_friends start=0 max=4}
                    <li>
                        <a href="{$base_url}/{$user_friends[i].friend_name}">
                        {insert name=member_img UID=$user_friends[i].friend_friend_id}<br />
                        {$user_friends[i].friend_name|truncate:25:'...'}
                        </a>                        
                    </li>
                {/section}
           </ul>
        </div>
        
        <!-- comment start -->

        <div class="section bg2">
        
            <div class="hd">
                <div class="hd-l"><a name="profile-comments">Profile Comments</a></div>
            </div>
            
            <div id="comment_box" align="center">
            {if $allow_comment eq 1}
                <form name="comment_form"  action="" method="post">
                    <textarea name="user_comment" rows="3" cols="40" id="user_comment"></textarea> <br />
                    <input type="button" value="Add Comment" name="submit"
                    onclick="post_profile_comment({$user_info.user_id})" />   
                </form>
            {/if}
            </div>
            
            <div id="comm_result"></div>
            
            <div id="user_comment_display"></div>
        
        </div>
            
    </div> <!-- box2 ends-->
    
</div> <!-- user profile end-->

<script type="text/javascript">
    var user_id = {$user_info.user_id};
    {literal}
    $(function(){
        display_user_comments(1);
    });
    {/literal}
</script>