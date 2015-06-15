<link rel="stylesheet" href="{$base_url}/css/offcanvas.css">
<script src="{$base_url}/js/offcanvas.js"></script>

<div class="col-xs-6 col-sm-4 col-md-3 sidebar-offcanvas">
    <div class="list-group">
        <a class="list-group-item disabled"><b>Categories</b></a>
    {section name=i loop=$channels}
        <a class="list-group-item{if $channels[i].channel_id eq $channel.channel_id} active{/if}" href="{$base_url}/channel/{$channels[i].channel_id}/{$channels[i].channel_name}/">
            {$channels[i].channel_name}
        </a>
    {/section}
    </div>
</div>
<div class="col-sm-8 col-md-9">
    <div class="page-header">
        <h1>
            <button data-toggle="offcanvas" class="btn btn-default btn-sm pull-left visible-xs" type="button" title="Categories">
                <span class="glyphicon glyphicon-menu-right"></span>
            </button>
            &nbsp;{$channel.channel_name}
        </h1>
    </div>

    {if $total gt "0"}

    <div class="page-header">
        <h2>Most active users</h2>
    </div>

    <div class="row">
        {section name=i loop=$most_active_users}
        {insert name=id_to_name assign=user_name un=$most_active_users[i].video_user_id}
        <div class="col-orient-ls col-sm-4 col-md-3">
            <div class="media">
                <a href="{$base_url}/{$user_name}">
                    <img class="media-object" width="100%" height="120" src="{insert name=member_img_url UID=$most_active_users[i].video_user_id}">
                </a>
                <h5 class="text-center">
                    <a href="{$base_url}/{$user_name}">{$user_name}</a>
                    <small>({$most_active_users[i].total})</small>
                </h5>
            </div>
        </div>
        {/section}
    </div>

    <div class="page-header">
        <h2>
            Recently added videos
            <small class="pull-right btn font-size-md">
                <a href="{$base_url}/channel/{$channel.channel_id}/{$channel.channel_seo_name}/recent/1">
                    More Videos
                </a>
            </small>
        </h2>
    </div>

    <div class="row">
    	{section name=i loop=$recent_channel_videos}
            <div class="col-orient-ls col-sm-6 col-md-4">
                <div class="thumbnail">
                    <div class="preview">
                        <a href="{$base_url}/view/{$recent_channel_videos[i].video_id}/{$recent_channel_videos[i].video_seo_name}/">
                            <img class="img-responsive" width="100%" height="130" src="{$recent_channel_videos[i].video_thumb_url}/thumb/{$recent_channel_videos[i].video_folder}1_{$recent_channel_videos[i].video_id}.jpg" alt="{$recent_channel_videos[i].video_title}">
                        </a>
                        <span class="badge video-time">{$recent_channel_videos[i].video_length}</span>
                    </div>
                    <div class="caption">
                        <h5 class="video_title">
                            <a class="text-nowrap" href="{$base_url}/view/{$recent_channel_videos[i].video_id}/{$recent_channel_videos[i].video_seo_name}/">{$recent_channel_videos[i].video_title|truncate:25:"...":true}</a>
                        </h5>
                        <p class="text-muted small">
                            {insert name=id_to_name assign=uname un=$recent_channel_videos[i].video_user_id}
                            <span class="glyphicon glyphicon-user"></span>
                            <a href="{$base_url}/{$uname}" target="_parent">{$uname}</a>
                            <span class="text-nowrap">on {$recent_channel_videos[i].video_add_time|date_format}</span>
                        </p>
                        <p class="text-muted small">
                            <span class="glyphicon glyphicon-eye-open"></span> {$recent_channel_videos[i].video_view_number} views,
                            &nbsp;
                            {insert name=comment_count assign=commentcount vid=$recent_channel_videos[i].video_id}
                            <span class="glyphicon glyphicon-comment"></span> Comments {$commentcount}
                        </p>
                        <p class="text-muted small">
                            <span class="text-nowrap">
                                <span class="glyphicon glyphicon-thumbs-up"></span> {$recent_channel_videos[i].video_rated_by} Likes
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        {/section}
    </div>

    <div class="page-header">
        <h2>
            Top watched videos
            <small class="pull-right btn font-size-md">
                <a href="{$base_url}/channel/{$channel.channel_id}/{$channel.channel_seo_name}/viewed/1">
                    More Videos
                </a>
            </small>
        </h2>
    </div>

    <div class="row">
    	{section name=i loop=$mostview}
            <div class="col-orient-ls col-sm-6 col-md-4">
                <div class="thumbnail">
                    <div class="preview">
                        <a href="{$base_url}/view/{$mostview[i].video_id}/{$mostview[i].video_seo_name}/">
                            <img class="img-responsive" width="100%" height="130" src="{$mostview[i].video_thumb_url}/thumb/{$mostview[i].video_folder}1_{$mostview[i].video_id}.jpg" alt="{$mostview[i].video_title}">
                        </a>
                        <span class="badge video-time">{$mostview[i].video_length}</span>
                    </div>
                    <div class="caption">
                        <h5 class="video_title">
                            <a class="text-nowrap" href="{$base_url}/view/{$mostview[i].video_id}/{$mostview[i].video_seo_name}/">{$mostview[i].video_title|truncate:30}</a>
                        </h5>
                        <p class="text-muted small">
                            {insert name=id_to_name assign=uname un=$mostview[i].video_user_id}
                            <span class="glyphicon glyphicon-user"></span>
                            <a href="{$base_url}/{$uname}" target="_parent">{$uname}</a>
                            <span class="text-nowrap">on {$mostview[i].video_add_time|date_format}</span>
                        </p>
                        <p class="text-muted small">
                            <span class="glyphicon glyphicon-eye-open"></span> {$mostview[i].video_view_number} views,
                            &nbsp;
                            {insert name=comment_count assign=commentcount vid=$mostview[i].video_id}
                            <span class="glyphicon glyphicon-comment"></span> Comments {$commentcount}
                        </p>
                        <p class="text-muted small">
                            <span class="text-nowrap">
                                <span class="glyphicon glyphicon-thumbs-up"></span> {$mostview[i].video_rated_by} Likes
                            </span>
                        </p>
                    </div>
                </div>
            </div>
    	{/section}

    </div> <!-- section -->

    {else}
        <div class="alert alert-danger">There is no video in this channel</div>
    {/if}
</div>