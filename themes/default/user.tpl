<div class="col-md-4">
    <div class="page-header">
        <div class="btn-group btn-group-lg" role="group">
            <div class="btn-group btn-group-lg" role="group">
                <button class="btn disabled">
                    <strong>{$user_info.user_name}'s Profile</strong>
                </button>
            </div>
            {if $smarty.session.USERNAME eq $user_info.user_name}
                <div class="btn-group btn-group-lg" role="group">
                    <button class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false" title="Options">
                        <span class="glyphicon glyphicon-option-vertical"></span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li><a class="submenu" href="{$base_url}/{$user_info.user_name}/edit/">Edit Profile</a></li>
                        <li><a class="submenu" href="{$base_url}/user_photo_upload.php">Upload Photo</a></li>
                        <li><a class="submenu" href="{$base_url}/privacy/">Privacy Settings</a></li>
                        {if $enable_package eq "yes"}
                            <li><a class="submenu" href="{$base_url}/renew_account.php?uid={$user_info.user_id}&action=upgrade">Upgrade Package</a></li>
                        {/if}
                        <li><a class="submenu" href="{$base_url}/user_delete.php">Delete Account</a></li>
                    </ul>
                </div>
            {/if}
        </div>
    </div>

    <div class="row">
        <div class="col-md-5 col-sm-5">
            <div class="thumbnail">
                <a href="{$base_url}/{$user_info.user_name}">
                    <img src="{$photo_url}" width="100%" alt="{$user_info.user_name}">
                </a>
            </div>
        </div>
        <div class="col-md-7  col-sm-7">
            {if $user_info.user_first_name ne "" OR $user_info.user_last_name ne ""}
                <p class="small">{$user_info.user_first_name} {$user_info.user_last_name}</p>
            {/if}
            {if $user_info.user_birth_date ne "0000-00-00"}
                <p class="small">{$age} years old</p>
            {/if}
            {if $user_info.user_gender ne ""}
                <p class="small">{$user_info.user_gender}</p>
            {/if}
            {if $user_info.user_town ne ""}
                <p class="small">{$user_info.user_town}</p>
            {/if}
            {if $user_info.user_city ne ""}
                <p class="small">{$user_info.user_city}</p>
            {/if}
            {if $user_info.user_country ne ""}
                <p class="small">{$user_info.user_country}</p>
            {/if}
            <p class="small">Last Login: {insert name=time_range assign=rtime time=$user_info.user_last_login_time}{$rtime}</p>

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
        </div>
    </div>
    <div class="clearfix"></div>

    {if $smarty.session.USERNAME eq $user_info.user_name}
        {if $enable_package eq "yes"}
            <p class="small">I have uploaded <b>{$u_info.total_video}</b> videos {if $pack.package_videos gt "0"} out of {$pack.package_videos} videos{/if}.</p>
            <p class="small">Space I have used <b>{insert name=format_size size=$u_info.used_space}</b> out of {insert name=format_size size=$pack.package_space}.</p>
        {/if}
    {/if}

    {if $chkuserflag eq ""}
        <p class="small">
            <a href="{$base_url}/signup/">Sign up</a> or
            <a href="{$base_url}/login/">Log in</a> to add {$user_info.user_name} as a friend.
        </p>
    {/if}

    <div>
        <p class="small">Videos Watched <b>{$user_info.user_video_viewed}</b> times.</p>
        <p class="small">Profile viewed <b>{$user_info.user_profile_viewed}</b> times.</p>
        <p class="small">I've watched <b>{$user_info.user_watched_video}</b> videos.</p>
        <p class="small">
            {insert name=friends_count assign=num_friends uid=$user_info.user_id}
            I have <b>{$num_friends}</b>
            <a href="{$base_url}/{$user_info.user_name}/friends/">friends.</a>
        </p>
    </div>
    <div class="clearfix"></div>

    <dl class="dl-horizontal profile-details">
        {insert name=time_range assign=stime time=$user_info.user_join_time}
        <dt>Signed up:</dt>
        <dd>{$stime}</dd>

        {if $user_info.relation ne ""}
            <dt>Relation:</dt>
            <dd>{$user_info.relation}</dd>
        {/if}
        {if $user_info.user_about_me ne ""}
            <dt>About Me:</dt>
            <dd>{$user_info.user_about_me}</dd>
        {/if}
        {if $user_info.user_website ne ""}
            <dt>Website:</dt>
            <dd><a href="{$user_info.user_website}" target="_blank">{$user_info.user_website}</a></dd>
        {/if}
        {if $user_info.user_zip ne ""}
            <dt>Country ZIP:</dt>
            <dd>{$user_info.user_zip}</dd>
        {/if}
        {if $user_info.user_occupation ne ""}
            <dt>Occupation:</dt>
            <dd>{$user_info.user_occupation}</dd>
        {/if}
        {if $user_info.user_company ne ""}
            <dt>Companies:</dt>
            <dd>{$user_info.user_company}</dd>
        {/if}
        {if $user_info.user_school ne ""}
            <dt>Schools:</dt>
            <dd>{$user_info.user_school}</dd>
        {/if}
        {if $user_info.user_interest_hobby ne ""}
            <dt>Interests &amp; Hobbies:</dt>
            <dd>{$user_info.user_interest_hobby}</dd>
        {/if}
        {if $user_info.user_fav_movie_show ne ""}
            <dt>Favourite Movies &amp; Shows:</dt>
            <dd>{$user_info.user_fav_movie_show}</dd>
        {/if}
        {if $user_info.user_fav_music ne ""}
            <dt>Favourite Music:</dt>
            <dd>{$user_info.user_fav_music}</dd>
        {/if}
        {if $user_info.user_fav_book ne ""}
            <dt>Favourite Books:</dt>
            <dd>{$user_info.user_fav_book}</dd>
        {/if}
        {if $user_info.user_friends_name ne ""}
            <dt>Friends:</dt>
            <dd>{$user_info.user_friends_name}</dd>
        {/if}
    </dl>

    <div class="page-header">
        <h3>Connect with {$user_info.user_name}</h3>
    </div>

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
            <img src="http://s7.addthis.com/static/btn/lg-share-en.gif" width="125" height="16" alt="Bookmark and Share" style="border:0">
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

    <div class="page-header">
        <h3>
            {$user_info.user_name}'s Groups
            <small class="pull-right font-size-md btn">
                <a href="{$base_url}/{$user_info.user_name}/groups/">More</a>
            </small>
        </h3>
    </div>
    <div class="row">
        {section name=i loop=$groups start=0 max=6}
            {insert name=group_image assign=group_image_info gid=$groups[i].group_id tbl=group_videos}
            {insert name=time_to_date assign=todate tm=$groups[i].group_create_time}
            <div class="col-md-6 col-sm-6">
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

<div class="col-md-8">
    {if $new_video_total gt "0"}
        <!-- NEW VIDEOS START -->
        <div class="page-header">
            <h2>
                New Videos
                <small class="pull-right font-size-md btn">
                    <a href="{$base_url}/{$user_info.user_name}/public/">More Videos</a>
                </small>
            </h2>
        </div>

        <div class="row">
            {section name=i loop=$new_video start=0 max=4}
                <div class="col-md-4 col-sm-6">
                    <div class="thumbnail">
                        <div class="preview">
                            <a href="{$base_url}/view/{$new_video[i].video_id}/{$new_video[i].video_seo_name}/">
                                <img class="img-response" width="100%" src="{$new_video[i].video_thumb_url}/thumb/{$new_video[i].video_folder}1_{$new_video[i].video_id}.jpg" alt="{$new_videos[i].video_title}">
                            </a>
                            <div class="badge video-time">{$new_video[i].video_length}</div>
                        </div>
                        <div class="caption">
                            <h5>
                                <a href="{$base_url}/view/{$new_video[i].video_id}/{$new_video[i].video_seo_name}/">
                                    {$new_video[i].video_title|truncate:25:'...'}
                                </a>
                            </h5>
                        </div>
                    </div>
                </div>
            {/section}
        </div> <!-- NEW VIDEOS ENDS -->

        <!-- POPULAR VIDEOS START -->
        <div class="page-header">
            <h2>
                Popular Videos
                <small class="pull-right font-size-md btn">
                    <a href="{$base_url}/{$user_info.user_name}/public/">More Videos</a>
                </small>
            </h2>
        </div>

        <div class="row">
            {section name=i loop=$popular start=0 max=4}
                <div class="col-md-4 col-sm-6">
                    <div class="thumbnail">
                        <div class="preview">
                            <a href="{$base_url}/view/{$popular[i].video_id}/{$popular[i].video_seo_name}/">
                                <img class="img-responsive" width="100%" src="{$popular[i].video_thumb_url}/thumb/{$popular[i].video_folder}1_{$popular[i].video_id}.jpg" alt="{$popular[i].video_title}">
                            </a>
                            <div class="badge video-time">{$popular[i].video_length}</div>
                        </div>
                        <div class="caption">
                            <h5>
                                <a href="{$base_url}/view/{$popular[i].video_id}/{$popular[i].video_seo_name}/">{$popular[i].video_title|truncate:25:'...'}</a>
                            </h5>
	                     </div>
                    </div>
                </div>
            {/section}
        </div><!-- POPULAR VIDEOS ENDS -->
    {/if}

    <!-- user friends -->
    <div class="page-header">
        <h2>
            New Friends
            <small class="pull-right font-size-md btn">
                <a href="{$base_url}/{$user_info.user_name}/friends/">More Friends</a>
            </small>
        </h2>
    </div>

    <div class="row">
        {section name=i loop=$user_friends start=0 max=4}
            <div class="col-md-3 col-sm-4">
                <div class="thumbnail">
                    <a href="{$base_url}/{$user_friends[i].friend_name}">
                        {insert name=member_img UID=$user_friends[i].friend_friend_id}
                        <h5>{$user_friends[i].friend_name|truncate:25:'...'}</h5>
                    </a>
                </div>
            </div>
        {/section}
    </div>

    <!-- comment start -->
    <div class="page-header">
        <h2><a name="profile-comments">Profile Comments</a></h2>
    </div>
    <div id="comment_box">
        {if $allow_comment eq 1}
            <form name="comment_form"  action="" method="post">
                <div class="form-group">
                    <textarea name="user_comment" rows="2" id="user_comment" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <button type="button" name="submit" class="btn btn-default" onclick="post_profile_comment({$user_info.user_id})">Add Comment</button>
                </div>
            </form>
            <br>
        {/if}
    </div>
    <div id="comm_result"></div>
    <div id="user_comment_display"></div>
</div>
<script type="text/javascript">
    var user_id = {$user_info.user_id};
    {literal}
    $(function(){
        display_user_comments(1);
    });
    {/literal}
</script>