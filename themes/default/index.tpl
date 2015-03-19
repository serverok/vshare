<div class="col-md-9">

    <center>
        <div id="flash_recent_videos" align="center"></div>
    </center>

    <div class="row">
        <div class="col-md-4">
            <a href="{$base_url}/recent/">
                <h2>Watch <span class="glyphicon glyphicon-eye-open"></span><br>
                    <small class="font-size-md">Better than TV watch what you want when you want it!</small>
                </h2>
            </a>
        </div>
        <div class="col-md-4">
            <a href="{$base_url}/upload/">
                <h2>Upload <span class="glyphicon glyphicon-upload"></span><br>
                    <small class="font-size-md">Quickly upload and tag videos in almost any video format.</small>
                </h2>
            </a>
        </div>
        <div class="col-md-4">
            <a href="{$base_url}/friends/invite/">
                <h2>Share <span class="glyphicon glyphicon-share"></span><br>
                    <small class="font-size-md">Easily share your videos with everyone, put videos on your space or watch them here.</small>
                </h2>
            </a>
        </div>
    </div>

    <!-- new videos -->

    {if $view.new_video_total gt "0"}

    <div class="page-header">
        <h1>
            New Videos
            <small class="pull-right font-size-md">
                <a class="btn" href="{$base_url}/recent/">More Recent Videos</a>
            </small>
        </h1>
    </div>

    <div class="row">
    {section name=i loop=$view.new_videos}
        <div class="col-sm-6 col-md-4">
            <div class="thumbnail">
                <div class="preview">
                    <a href="{$base_url}/view/{$view.new_videos[i].video_id}/{$view.new_videos[i].video_seo_name}/">
                        <img class="img-responsive" width="100%" height="130" src="{$view.new_videos[i].video_thumb_url}/thumb/{$view.new_videos[i].video_folder}1_{$view.new_videos[i].video_id}.jpg" alt="{$view.new_videos[i].video_title}" />
                    </a>
                    <span class="badge video-time">{$view.new_videos[i].video_length}</span>
                </div>
                <div class="caption">
                    <h5>
                        <a href="{$base_url}/view/{$view.new_videos[i].video_id}/{$view.new_videos[i].video_seo_name}/" >
                            {$view.new_videos[i].video_title|truncate:30}
                        </a>
                    </h5>
                </div>
            </div>
        </div>
    {/section}
    </div>

    {/if}

    <!-- recent video -->

    {if $view.recent_total gt 0}

    <div class="page-header">
        <h1>
            Recently Viewed
            <small class="pull-right font-size-md">
                <a class="btn" href="{$base_url}/viewed/">More Recently Viewed</a>
            </small>
        </h1>
    </div>

    <div class="row">
    {section name=i loop=$view.recent_videos}
        <div class="col-sm-6 col-md-4">
            <div class="thumbnail">
                <div class="preview">
                    <a href="{$base_url}/view/{$view.recent_videos[i].video_id}/{$view.recent_videos[i].video_seo_name}/">
                        <img class="img-responsive" width="100%" height="130" src="{$view.recent_videos[i].video_thumb_url}/thumb/{$view.recent_videos[i].video_folder}1_{$view.recent_videos[i].video_id}.jpg" alt="{$view.recent_videos[i].video_title}" />
                    </a>
                    <span class="badge video-time">{$view.recent_videos[i].video_length}</span>
                </div>
                <div class="caption">
                    <h5>
                        <a href="{$base_url}/view/{$view.recent_videos[i].video_id}/{$view.recent_videos[i].video_seo_name}/">
                            {$view.recent_videos[i].video_title|truncate:30}
                        </a>
                    </h5>
                </div>
            </div>
        </div>
    {/section}
    </div>

    {/if}

    <!-- featured videos -->

    {$view.featured_video_block}


</div> <!--  content -->

<div class="col-md-3">
    <div class="rows">
        <div align="center">
            {insert name=advertise adv_name='home_right_box'}
        </div>

        {if $home_num_tags gt 0}

        <div class="page-header">
            <h2>Recent Tags</h2>
        </div>
        <p>{$view.home_tags}</p>
        <p><a class="text-muted pull-right" href="{$base_url}/tags/"><b>See More Tags</b></a></p>

        {/if}

        <div class="clearfix"></div>

        {if $num_last_users_online ne 0}

        <div class="page-header">
            <h2>Last {$num_last_users_online} Users Online</h2>
        </div>

        {insert name=recently_active_users assign=recently_active_users}
        {section name=i loop=$recently_active_users}
        <p>
            {insert name=id_to_name assign=uname un=$recently_active_users[i].user_login_user_id}
            {insert name=video_count assign=vdocount uid=$recently_active_users[i].user_login_user_id}
            {insert name=favour_count assign=favcount uid=$recently_active_users[i].user_login_user_id}
            {insert name=friends_count assign=friends uid=$recently_active_users[i].user_login_user_id}

            <h4>
                <a href="{$base_url}/{$uname}">
                    <span class="glyphicon glyphicon-user"></span> {$uname}
                </a>
                <br>
                <small>
                    <span class="glyphicon glyphicon-facetime-video"></span>
                    <a href="{$base_url}/{$uname}/public/">({$vdocount})</a>

                    <span class="glyphicon glyphicon-heart"></span>
                    <a href="{$base_url}/{$uname}/favorites/">({$favcount})</a>

                    <span class="glyphicon glyphicon-user"></span>
                    <a href="{$base_url}/{$uname}/friends/">({$friends})</a>
                </small>
            </h4>
            <hr>
        </p>
        {/section}
        <p class="icon-key">
            <h4>Icon Key:</h4>
            <span class="text-nowrap">
                <span class="glyphicon glyphicon-facetime-video"></span> Videos
            </span> |
            <span class="text-nowrap">
                <span class="glyphicon glyphicon-heart"></span> Favorites
            </span> |
            <span class="text-nowrap">
                <span class="glyphicon glyphicon-user"></span> Friends
            </span>
        </p>
    {/if}

    {if $show_stats ne "0"}

        {insert name="show_stats" assign="stats"}
        <div class="page-header">
            <h2>Site Statistics</h2>
        </div>
        <ul class="list-group">
            <li class="list-group-item">Number of Videos: <span class="badge">{$stats.total_video}</span></li>
            <li class="list-group-item">Public Videos:<span class="badge">{$stats.total_public_video}</span></li>
            <li class="list-group-item">Private Videos:<span class="badge">{$stats.total_private_video}</span></li>
            <li class="list-group-item">Number of Users:<span class="badge">{$stats.total_users}</span></li>
            <li class="list-group-item">Number of Channels:<span class="badge">{$stats.total_channel}</span></li>
            <li class="list-group-item">Number of Groups:<span class="badge">{$stats.total_groups}</span></li>
        </ul>
    {/if}

    <!-- poll start -->

    {if $pollinganel ne 'Disable' AND $poll_question ne ""}
    <div class="page-header">
        <h2>Vote Here</h2>
    </div>

    <div id="poll_body"> <!-- poll start -->
        <div id="poll">
            <p><strong>{$poll_question}</strong></p>

            <div id="poll_answers">
                {section name=i loop=$list}
                    <label>
                        <input type="radio" name="xx" onclick="poll_vote_for('{$list[i]}','user_answer')" />
                        <span> {$list[i]}</span>
                    </label>
                    <br>
                {/section}
                <input type="hidden" id="user_answer" value="" />
                <button type="submit" class="btn btn-default" onclick="poll_vote({$poll_id})"><strong>Cast This</strong></button>
            </div>

            {if $list ne ""}
            <br>
            <div id="poll_view">
                <a href="javascript:void(0)" onclick="poll_view({$poll_id})">
                    <strong>View current status</strong>
                </a>
            </div>
            {/if}

        </div> <!-- poll -->

        <div id="poll_loading"></div>
        <div id="poll_result"></div>
    </div>  <!--  poll body -->
    {/if}

    </div>
</div> <!-- sidebar -->