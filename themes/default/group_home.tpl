<div class="col-md-9">
{if $group_info ne ""}
    <div class="page-header">
        <h1>Group: {$group_info.group_name}</h1>
    </div>

    {if $show_group ne 1}
        <div class="alert alert-warning">Sorry! You are not allowed to view this private group.</div>
    {else}
        <div class="row">
            {insert name=group_info_count assign=gmemcount tbl=group_members gid=$group_info.group_id query="1" field1=group_member_approved field2=group_member_group_id}
            {insert name=group_info_count assign=gvdocount tbl=group_videos gid=$group_info.group_id query="1" field1=group_video_approved field2=group_video_group_id}
            {insert name=group_info_count assign=gtpscount tbl=group_topics gid=$group_info.group_id query="1" field1=group_topic_approved field2=group_topic_group_id}
            {insert name=check_group_mem assign=checkmem gid=$group_info.group_id}
            {insert name=group_image assign=group_image_info gid=$group_info.group_id tbl=group_videos}
            <div class="col-sm-6 col-md-4">
                <div class="thumbnail">
                {if $group_image_info eq "0"}
                    <img class="img-responsive" src="{$img_css_url}/images/no_videos_groups.gif" width="100%" alt="">
                {else}
                    <img class="img-responsive" src="{$group_image_info.video_thumb_url}/thumb/{$group_image_info.video_folder}1_{$group_image_info.video_id}.jpg" width="100%" alt="">
                {/if}
                </div>
            </div>
            <div class="col-sm-6 col-md-6">
                <p class="text-muted small">{$group_info.group_description}</p>
                {insert name=id_to_name assign=uname un=$group_info.group_owner_id}
                <p class="text-muted small">
                    <span class="glyphicon glyphicon-user"></span>
                    by <a href="{$base_url}/{$uname}">{$uname}</a>
                    ({if $smarty.session.UID eq $group_info.group_owner_id}
                        <font color="green">You are the owner of this group.</font>
                    {elseif $is_member eq "no"}
                        <font color="#ffcc00">Your request is sent to the owner.</font>
                    {elseif $is_member eq "yes"}
                        You are member of this group.
                    {else}
                        You are not a member of this group.
                    {/if})
                </p>
                <p class="text-muted small">
                    <span class="glyphicon glyphicon-tag"></span>
                    Tags: {$group_info.group_keyword}
                </p>
                <p class="text-muted small">
                    Type: {$group_info.group_type},&nbsp;&nbsp;
                    Channel:
                    {insert name=video_channel assign=grpchannel tbl=groups gid=$group_info.group_id}
                    {section name=k loop=$grpchannel}
                    <a href="{$base_url}/channel/{$grpchannel[k].channel_id}/{$grpchannel[k].channel_seo_name}/">{$grpchannel[k].channel_name}</a>&nbsp;
                    {/section}
                </p>
                <p class="text-muted small">
                    Videos: <a href="{$base_url}/group/{$group_info.group_url}/videos/1">{$gvdocount}</a>

                    {if $smarty.session.UID eq $group_info.group_owner_id}
                        {if $total_new_video ne "0"}
                            &nbsp;&nbsp;&nbsp;<b>({$total_new_video} new)</b>
                        {/if}
                    {/if},&nbsp;&nbsp;
                    Members:
                    <a href="{$base_url}/group/{$group_info.group_url}/members/1">{$gmemcount}</a>
                    {if $smarty.session.UID eq $group_info.group_owner_id}
                        {if $total_new_member ne "0"}
                            &nbsp;&nbsp;&nbsp;<b>({$total_new_member} new)</b>
                        {/if}
                    {/if}
                </p>
                <p class="text-muted small">
                    Group URL:
                    <a href="{$base_url}/group/{$group_info.group_url}/">{$base_url}/group/{$group_info.group_url}/</a>
                </p>
            </div>
            <div class="col-md-2">
                {if $smarty.session.UID ne $group_info.group_owner_id}
                    <form method="GET" action="{$base_url}/group_join.php">
                        <input type="hidden" name="group_id" value="{$group_info.group_id}" />
                        {if $checkmem eq "0" && $group_info.group_type ne 'private'}
                            <input type="hidden" name="action" value="join" />
                            <button type="submit" name="submit" class="btn btn-default">Join to this Group</button>
                        {elseif $is_member eq "yes"}
                            <input type="hidden" name="action" value="remove" />
                            <button type="submit" name="submit" class="btn btn-default btn-block">Leave this Group</button>
                        {/if}
                    </form>
                    <br>
                {/if}
                <div class="btn-group-vertical btn-block" role="group">
                    {if $smarty.session.UID ne "" and $checkmem ne "0"}
                        {if $smarty.session.UID eq $group_info.group_owner_id}
                            <a class="btn btn-default" href="{$base_url}/group/{$group_info.group_url}/edit/">Edit this Group</a>
                            {if $smarty.session.UID eq $group_info.group_owner_id and $group_info.group_upload eq "owner_only"}
                                <a class="btn btn-default" href="{$base_url}/group/{$group_info.group_url}/add/1">Add Videos</a>
                            {/if}

                            {if $group_info.group_upload ne "owner_only"}
                                <a class="btn btn-default" href="{$base_url}/group/{$group_info.group_url}/add/1">Add Videos</a>
                            {/if}
                            <a class="btn btn-default" href="{$base_url}/group/{$group_info.group_url}/invite/">Invite Members</a>

                        {else}

                            {if $is_member eq "yes"}
                                {if $smarty.session.UID eq $group_info.group_owner_id and $group_info.group_upload eq "owner_only"}
                                    <a class="btn btn-default" href="{$base_url}/group/{$group_info.group_url}/add/1">Add Videos</a>
                                {/if}
                                {if $group_info.group_upload ne "owner_only"}
                                    <a class="btn btn-default" href="{$base_url}/group/{$group_info.group_url}/add/1">Add Videos</a>
                                {/if}
                                {if $group_info.group_type ne "private" or $smarty.session.UID eq $group_info.group_owner_id}
                                    <a class="btn btn-default" href="{$base_url}/group/{$group_info.group_url}/invite/">Invite Members</a><br />
                                {/if}
                            {/if}
                        {/if}
                    {/if}
                </div>
            </div>
        </div>

        <div class="page-header">
            <h2>
                Recently Added Videos
                <small class="pull-right btn font-size-md">
                    <a href="{$base_url}/group/{$group_info.group_url}/videos/1">
                        View all videos
                    </a>
                </small>
            </h2>
        </div>

        <div class="row">
            {section name=i loop=$group_videos}
                <div class="col-sm-6 col-md-4">
                    <div class="thumbnail">
                        <div class="preview">
                            <a href="{$base_url}/view/{$group_videos[i].video_id}/{$group_videos[i].video_seo_name}/">
                                <img class="img-responsive" width="100%" height="130" src="{$group_videos[i].video_thumb_url}/thumb/{$group_videos[i].video_folder}1_{$group_videos[i].video_id}.jpg" alt="">
                            </a>
                            <div class="badge video-time">{$group_videos[i].video_length}</div>
                        </div>
                        <div class="caption">
                            <h5>
                                <a href="{$base_url}/view/{$group_videos[i].video_id}/{$group_videos[i].video_seo_name}/">
                                    {$group_videos[i].video_title|truncate:30}
                                </a>
                            </h5>
                        </div>
                    </div>
                </div>
            {/section}
        </div>

        <div class="page-header">
            <h2>
                Recent Members
                <small class="pull-right btn font-size-md">
                    <a href="{$base_url}/group/{$group_info.group_url}/members/1">
                        View all members
                    </a>
                </small>
            </h2>
        </div>

        <div class="row">
            {section name=i loop=$group_members}
                <div class="col-sm-6 col-md-4">
                    <div class="thumbnail">
                        {insert name=id_to_name assign=uname un=$group_members[i].user_id}
                        <a href="{$base_url}/{$uname}/">
                            {insert name=member_img UID=$group_members[i].user_id}
                        </a>
                        <div class="caption">
                            <h5><a href="{$base_url}/{$uname}/">{$uname}</a></h5>
                        </div>
                    </div>
                </div>
            {/section}
        </div>
    {/if}
{/if}
</div>
<div class="col-md-3">
{insert name=advertise adv_name='wide_skyscraper'}
</div>