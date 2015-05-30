
<div class="col-md-12">
    <div class="panel panel-default clearfix">
        <div class="user-page">
        <img align="left" class="profile-cover" src="{$base_url}/themes/default/images/profile-cover.jpg" alt="Profile image example"/>
        <a href="{$base_url}/{$user_info.user_name}">
        <img align="left" class="profile-pic thumbnail" src="{$photo_url}"  alt="{$user_info.user_name}">
        </a>

        <div class="userinfo">
            <h1>{$user_info.user_name}
            <span class="pull-right small">{if $user_info.user_country ne ""}
            <span class="glyphicon glyphicon-map-marker"></span>  {$user_info.user_country}
            {/if}</span></h1>

Last Login: {insert name=time_range assign=rtime time=$user_info.user_last_login_time}{$rtime}<br>
      {insert name=time_range assign=stime time=$user_info.user_join_time}
            Signed up:
            {$stime}

            <span class="pull-right">
                <ul class="user-stats">
                    <li><span class="glyphicon glyphicon-film"></span><b> {$user_info.user_video_viewed}</b> Video views</li>
                    <li><span class="glyphicon glyphicon-eye-open"></span> <b>{$user_info.user_profile_viewed}</b>  Profile views </li>
                    <li><span class="glyphicon glyphicon-user"></span> I've watched <b>{$user_info.user_watched_video}</b> videos</li>
                    <li> <span class="glyphicon glyphicon-user"></span>
                    {insert name=friends_count assign=num_friends uid=$user_info.user_id}
                    <b>{$num_friends}</b>
                    <a href="{$base_url}/{$user_info.user_name}/friends/">friends</a>
                    </li>
                </ul>
            </span>
        </div>


    <hr>
        <div class="row about-me">
            <div class="col-md-7">
            {if $user_info.user_about_me ne ""}
            <b>About Me : </b>{$user_info.user_about_me}
            {/if}
            </div>
            <div class="col-md-5 pull-right">
            {if $smarty.session.USERNAME eq $user_info.user_name}

            <ul class="user-stats">
            <li> <a  href="{$base_url}/{$user_info.user_name}/edit/">Edit Profile</a></li>
            <li> <a href="{$base_url}/user_photo_upload.php">Upload Photo</a></li>
            <li><a  href="{$base_url}/privacy/">Privacy Settings</a></li>
            {if $enable_package eq "yes"}
            <li> <a href="{$base_url}/renew_account.php?uid={$user_info.user_id}&action=upgrade">Upgrade Package</a></li>
            {/if}
            <li> <a  href="{$base_url}/user_delete.php">Delete Account</a></li>

            {/if}
            </ul>
            </div>
        </div>
    </div>
</div>
</div>

<div class="clearfix"></div>
<div class="col-md-4">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">
            <span class="glyphicon glyphicon-plus"></span> <b>More info </b>
            </h3>
        </div>
                    <ul class="list-group">
                    {if $user_info.user_first_name ne "" OR $user_info.user_last_name ne ""}
                    <li class="list-group-item">Name  <span class="pull-right">{$user_info.user_first_name} {$user_info.user_last_name}</span></li>
                    {/if}
                    {if $user_info.user_birth_date ne "0000-00-00"}
                   <li class="list-group-item">Age  <span class="pull-right">{$age} years old</span></li>
                    {/if}
                    {if $user_info.user_gender ne ""}
                    <li class="list-group-item">Sex : <span class="pull-right">{$user_info.user_gender}</span></li>
                    {/if}
                    {if $user_info.user_town ne ""}
                    <li class="list-group-item">Town  <span class="pull-right">{$user_info.user_town}</span></li>
                    {/if}
                    {if $user_info.user_city ne ""}
                    <li class="list-group-item">City  <span class="pull-right">{$user_info.user_city}</span></li>
                    {/if}
                    {if $user_info.user_country ne ""}
                    <li class="list-group-item">Country <span class="pull-right">{$user_info.user_country}</span></li>
                    {/if}

                    {if $user_info.relation ne ""}
                    <li class="list-group-item">Relation:
                    <span class="pull-right">{$user_info.relation}</span>
                    {/if}

                    {if $user_info.user_website ne ""}
                    <li class="list-group-item">Website:
                    <span class="pull-right"><a href="{$user_info.user_website}" target="_blank">{$user_info.user_website}</a></span>
                    {/if}
                    {if $user_info.user_zip ne ""}
                    <li class="list-group-item">Country ZIP:
                    <span class="pull-right">{$user_info.user_zip}</span>
                    {/if}
                    {if $user_info.user_occupation ne ""}
                    <li class="list-group-item">Occupation:
                    <span class="pull-right">{$user_info.user_occupation}</span>
                    {/if}
                    {if $user_info.user_company ne ""}
                    <li class="list-group-item">Companies:
                    <span class="pull-right">{$user_info.user_company}</span>
                    {/if}
                    {if $user_info.user_school ne ""}
                    <li class="list-group-item">Schools:
                    <span class="pull-right">{$user_info.user_school}</span>
                    {/if}
                    {if $user_info.user_interest_hobby ne ""}
                    <li class="list-group-item">Interests &amp; Hobbies:
                    <span class="pull-right">{$user_info.user_interest_hobby}</span>
                    {/if}
                    {if $user_info.user_fav_movie_show ne ""}
                    <li class="list-group-item">Favourite Movies &amp; Shows:
                    <span class="pull-right">{$user_info.user_fav_movie_show}</span>
                    {/if}
                    {if $user_info.user_fav_music ne ""}
                    <li class="list-group-item">Favourite Music:
                    <span class="pull-right">{$user_info.user_fav_music}</span>
                    {/if}
                    {if $user_info.user_fav_book ne ""}
                    <li class="list-group-item">Favourite Books:
                    <span class="pull-right">{$user_info.user_fav_book}</span>
                    {/if}
                    {if $user_info.user_friends_name ne ""}
                    <li class="list-group-item">Friends:
                    <span class="pull-right">{$user_info.user_friends_name}</span>
                    {/if}
                    </ul>

                    <div class="panel-body">
                        <script>var candidate_id = {$user_info.user_id};</script>
                        {if $chkuserflag ne "self"}
                        {if $chkuserflag eq "guest"}
                        <div class="col-md-12">
                        <div id="user_vote_result" class="row small">
                        <div>Rate me:</div>
                        <div>{insert name=user_rate user_id=$user_info.user_id}</div>
                        </div>
                        </div>
                        {/if}
                        {/if}

                        {if $smarty.session.USERNAME eq $user_info.user_name}
                        {if $enable_package eq "yes"}
                        <p>I have uploaded <b>{$u_info.total_video}</b> videos {if $pack.package_videos gt "0"} out of {$pack.package_videos} videos{/if}.</p>
                        <p>Space I have used <b>{insert name=format_size size=$u_info.used_space}</b> out of {insert name=format_size size=$pack.package_space}.</p>
                        {/if}
                        {/if}

                        {if $chkuserflag eq ""}
                        <p>
                        <a href="{$base_url}/signup/">Sign up</a> or
                        <a href="{$base_url}/login/">Log in</a> to add {$user_info.user_name} as a friend.
                        </p>
                        {/if}
                    </div>

</div>


<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><span class="glyphicon glyphicon-film"></span><b> Connect with {$user_info.user_name}</b>
        </h3>
    </div>

    <div class="panel-body">
        <div class="btn-group btn-group-justified">
            {if $allow_comment eq '1'}
            <a class="btn btn-default" href="#profile-comments">
            <span class="glyphicon glyphicon-comment"></span> Add Comments
            </a>
            {/if}
            {if $is_friend ne "yes"}
            {if $allow_friend eq '1'}
            <a class="btn btn-default" href="{$base_url}/invite_friends.php?UID={$user_info.user_id}">
            <span class="glyphicon glyphicon-user"></span>  Add as Friend
            </a>
            {/if}
            {/if}
        </div>
        <br>
        <div class="btn-group btn-group-justified">
            {if $allow_private_message eq '1'}
            <a class="btn btn-default" href="{$base_url}/mail.php?folder=compose&receiver={$user_info.user_name}">
            <span class="glyphicon glyphicon-send"></span> Send Messages
            </a>
            {/if}
            <!-- AddThis Button BEGIN -->
            <script type="text/javascript">var addthis_pub="buyscripts";</script>
            <a class="btn btn-default" href="http://www.addthis.com/bookmark.php?v=20" onmouseover="return addthis_open(this, '', '[URL]', '[TITLE]')" onmouseout="addthis_close()" onclick="return addthis_sendto()">
            <span class="glyphicon glyphicon-share"></span> Share Profile
            </a>
            <script type="text/javascript" src="http://s7.addthis.com/js/200/addthis_widget.js"></script>
            <!-- AddThis Button END -->
        </div>
        <div class="clearfix"></div>
        <h4>{$user_info.user_name}'s Profile Url:
        <br>
        <small>
        <a href="{$base_url}/{$user_info.user_name}">{$base_url}/{$user_info.user_name}</a>
        </small>
        </h4>
    </div>
</div><!-- Connect -->

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><span class="glyphicon glyphicon-user"></span><b>  {$user_info.user_name}'s Groups</b> <span class="pull-right">
        <a href="{$base_url}/{$user_info.user_name}/groups/"> <span class="glyphicon glyphicon-plus"></span> More</a></span>
        </h3>
    </div>

    <div class="panel-body">
        <div class="row">
            {section name=i loop=$groups start=0 max=6}
            {insert name=group_image assign=group_image_info gid=$groups[i].group_id tbl=group_videos}
            {insert name=time_to_date assign=todate tm=$groups[i].group_create_time}
            <div class="col-orient-ls col-md-6 col-sm-6">
                    <div class="thumbnail">
                        <a href="{$base_url}/group/{$groups[i].group_url}/">
                        {if $group_image_info eq "0"}
                        <img src="{$img_css_url}/images/no_videos_groups.gif" width="100%" alt="">
                        {else}
                        <img width="100%" class="preview" src="{$group_image_info.video_thumb_url}/thumb/{$group_image_info.video_folder}1_{$group_image_info.video_id}.jpg" alt="">
                        {/if}
                        </a>
                        <div class="caption">
                        <h5>
                        <a href="{$base_url}/group/{$groups[i].group_url}/">{$groups[i].group_name|truncate:20}</a>
                        </h5>
                        {insert name=row_count assign=num_group_members group_id=$groups[i].group_id table=group_members field1=group_member_group_id field2=group_member_approved}
                        {insert name=group_info_count assign=num_group_videos tbl=group_videos gid=$groups[i].group_id query="1" field1=group_video_approved field2=group_video_group_id}

                        <p class="small text-muted">
                        {if $num_group_members gt 0}
                            <a href="{$base_url}/group/{$groups[i].group_url}/members/1">{$num_group_members}</a>
                        {else}
                            <a>{$num_group_members}</a>
                        {/if}
                        members |
                        {if $num_group_videos gt 0}
                            <a href="{$base_url}/group/{$groups[i].group_url}/videos/1">{$num_group_videos}</a>
                        {else}
                            <a>{$num_group_videos}</a>
                        {/if}
                        Videos
                        </p>
                        </div>
                    </div>
            </div>
            {sectionelse}
                <div align="center">
                    <p class="lead text-muted small">This user is not a member of any groups.</p>
                    {if $smarty.session.USERNAME == $user_info.user_name}
                    <p class="lead text-muted small">
                    <a href="{$base_url}/group/new/">Click here</a> to create a group now
                    </p>
                    {/if}
                    </div>
            {/section}
            </div>
        </div>
    </div>
</div><!-- Groups End -->

<div class="col-md-8">
    {if $new_video_total gt "0"}
        <!-- NEW VIDEOS START -->

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><span class="glyphicon glyphicon-film"></span><b> New Videos</b> <span class="pull-right">
            <a href="{$base_url}/{$user_info.user_name}/public/"> <span class="glyphicon glyphicon-plus"></span> More</a></span>
            </h3>
        </div>

        <div class="panel-body">
            <div class="row">
                {section name=i loop=$new_video start=0 max=3}
                <div class="col-orient-ls col-md-4 col-sm-6">
                    <div class="preview">
                        <a href="{$base_url}/view/{$new_video[i].video_id}/{$new_video[i].video_seo_name}/">
                        <img class="img-response" width="100%" src="{$new_video[i].video_thumb_url}/thumb/{$new_video[i].video_folder}1_{$new_video[i].video_id}.jpg" alt="{$new_videos[i].video_title}">
                        </a>
                        <div class="badge video-time">{$new_video[i].video_length}</div>
                    </div>
                    <h5>
                        <a href="{$base_url}/view/{$new_video[i].video_id}/{$new_video[i].video_seo_name}/">
                        {$new_video[i].video_title|truncate:35:'...'}
                        </a>
                    </h5>
                </div>
                {/section}
            </div>
        </div>
    </div> <!-- NEW VIDEOS ENDS -->


    <!-- POPULAR VIDEOS START -->

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><span class="glyphicon glyphicon-film"></span><b> Popular Videos</b> <span class="pull-right">
            <a href="{$base_url}/{$user_info.user_name}/public/"> <span class="glyphicon glyphicon-plus"></span> More</a></span>
            </h3>
        </div>

        <div class="panel-body">
            <div class="row">
                {section name=i loop=$popular start=0 max=3}
                <div class="col-orient-ls col-md-4 col-sm-6">
                    <div class="preview">
                        <a href="{$base_url}/view/{$popular[i].video_id}/{$popular[i].video_seo_name}/">
                        <img class="img-responsive" width="100%" src="{$popular[i].video_thumb_url}/thumb/{$popular[i].video_folder}1_{$popular[i].video_id}.jpg" alt="{$popular[i].video_title}">
                        </a>
                        <div class="badge video-time">{$popular[i].video_length}</div>
                    </div>

                    <h5>
                    <a href="{$base_url}/view/{$popular[i].video_id}/{$popular[i].video_seo_name}/">{$popular[i].video_title|truncate:35:'...'}</a>
                    </h5>
                </div>
                {/section}
            </div>
        </div>
    </div> <!-- POPULAR VIDEOS ENDS -->

    {/if}

    <!-- user friends -->

<div class="panel panel-default user-friends">
    <div class="panel-heading">
        <h3 class="panel-title"><span class="glyphicon glyphicon-film"></span><b> New Friends</b> <span class="pull-right">
        <a href="{$base_url}/{$user_info.user_name}/friends/"> <span class="glyphicon glyphicon-plus"></span> More</a></span>
        </h3>
    </div>

<div class="panel-body">
    <div class="row">
        {section name=i loop=$user_friends start=0 max=4}
            <div class="col-orient-ls col-md-3 col-sm-4">
                <div class="thumbnail">
                    <a href="{$base_url}/{$user_friends[i].friend_name}">
                        {insert name=member_img UID=$user_friends[i].friend_friend_id}
                        <h5>{$user_friends[i].friend_name|truncate:25:'...'}</h5>
                    </a>
                </div>
            </div>
        {sectionelse}
            <p class="text-center">No friends.</p>
        {/section}
    </div>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">
        <span class="glyphicon glyphicon-film"></span> <a name="profile-comments"><b>Profile Comments</b></a>
        </h3>
    </div>

    <div class="panel-body">
        <div id="comment_box">
            {if $allow_comment eq 1}
            <form name="comment_form"  action="" method="post">
                <div class="form-group">
                    <textarea name="user_comment" rows="2" id="user_comment" class="form-control" placeholder="Your comments"></textarea>
                </div>
                <div class="form-group">
                    <button type="button" name="submit" class="btn btn-default" onclick="post_profile_comment({$user_info.user_id})">Post</button>
                </div>
            </form>
            <br>
            {/if}
        </div>
        <div id="comm_result"></div>
        <div id="user_comment_display"></div>
    </div>
</div>

<script type="text/javascript">
    var user_id = {$user_info.user_id};
    {literal}
    $(function(){
        display_user_comments(1);
    });
    {/literal}
</script>