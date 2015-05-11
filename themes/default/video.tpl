<link rel="stylesheet" href="{$base_url}/css/offcanvas.css">
<script src="{$base_url}/js/offcanvas.js"></script>
<button data-toggle="offcanvas" class="btn btn-default btn-sm pull-left visible-xs" type="button" title="Categories">
    <span class="glyphicon glyphicon-menu-right"></span>
</button>

<div class="col-xs-6 col-sm-4 col-md-3 sidebar-offcanvas">
    <div class="page-header">
        <h2>Video Categories</h2>
    </div>
    <div class="list-group">
    {section name=i loop=$view.channels}
        {insert name=channel_count assign=chinfo cid=$view.channels[i].channel_id}
        <a class="list-group-item" href="{$base_url}/channel/{$view.channels[i].channel_id}/{$view.category}/{$view.view_type}/1">
            {$view.channels[i].channel_name}
            <span class="badge">{$chinfo[1]}</span>
        </a>
    {/section}
    </div>
</div>

<div class="col-md-9">
    <div class="page-header">
        <h1>
            {$view.display_order}
            {if $channel_name ne ''}
                {$channel_name} videos
            {/if}
            <div class="pull-right">
                <div class="btn-group">
                    {if $channel_name ne ""}
                        <a class="btn btn-default{if $view.view_type eq 'basic'} disabled{/if}" href="{$base_url}/{if $channel_name ne ''}channel/{$smarty.get.chid}/{/if}{$view.category}/basic/{$view.page}" title="Grid view">
                            <span class="glyphicon glyphicon-th-large"></span>
                        </a>
                        <a class="btn btn-default{if $view.view_type eq 'detailed'} disabled{/if}" href="{$base_url}/{if $channel_name ne ''}channel/{$smarty.get.chid}/{/if}{$view.category}/detailed/{$view.page}" title="List view">
                            <span class="glyphicon glyphicon-th-list"></span>
                        </a>
                    {else}
                        <a class="btn btn-default{if $view.view_type eq 'basic'} disabled{/if}" href="{$base_url}/{$view.category}/{$view.page}" title="Grid view">
                            <span class="glyphicon glyphicon-th-large"></span>
                        </a>
                        <a class="btn btn-default{if $view.view_type eq 'detailed'} disabled{/if}" href="{$base_url}/detailed/{$view.category}/{$view.page}" title="List view">
                            <span class="glyphicon glyphicon-th-list"></span>
                        </a>
                    {/if}
                </div>
                <small class="btn disabled">Videos {$view.start_num}-{$view.end_num} of {$view.total}</small>
            </div>
        </h1>
    </div>

    <div class="video_block clearfix">

        {if $smarty.request.view_type eq "" or $smarty.request.view_type eq "basic"}
        <div class="row">
            {section name=i loop=$view.videos}
            <div class="col-sm-6 col-md-4">
                <div class="thumbnail">
                    <div class="preview">
                        <a href="{$base_url}/view/{$view.videos[i].video_id}/{$view.videos[i].video_seo_name}/">
                            <img class="img-responsive" width="100%" height="130" src="{$view.videos[i].video_thumb_url}/thumb/{$view.videos[i].video_folder}1_{$view.videos[i].video_id}.jpg" alt="{$view.videos[i].video_title}" />
                        </a>
                        <span class="badge video-time">{$view.videos[i].video_length}</span>
                        <span class="btn btn-default btn-xs video-queue" id="queue_{$view.videos[i].video_id}" data-id="{$view.videos[i].video_id}" rel="video_queue">
                            <span class="glyphicon glyphicon-plus"></span>
                        </span>
                    </div>
                    <div class="caption">
                        <h5 class="video_title">
                            <a href="{$base_url}/view/{$view.videos[i].video_id}/{$view.videos[i].video_seo_name}/">{$view.videos[i].video_title|truncate:30}</a>
                        </h5>
                        <p class="text-muted small">
                            {insert name=id_to_name assign=user_name un=$view.videos[i].video_user_id}
                            {insert name=time_range assign=added_on time=$view.videos[i].video_add_time}
                            <span class="glyphicon glyphicon-user"></span>
                            <a href="{$base_url}/{$user_name}">{$user_name}</a>,
                            {$added_on}
                        </p>
                        <p class="text-muted small">
                            <span class="glyphicon glyphicon-eye-open"></span> {$view.videos[i].video_view_number} views,
                            &nbsp;
                            {insert name=comment_count assign=commentcount vid=$view.videos[i].video_id}
                            <span class="glyphicon glyphicon-comment"></span> Comments {$commentcount}
                        </p>
                        <p class="text-muted small">
                            <span class="text-nowrap">
                                <span class="glyphicon glyphicon-thumbs-up"></span> {$view.videos[i].video_rated_by} Likes
                            </span>
                        </p>
                    </div>
                </div>
            </div>
            {sectionelse}
                <br />
                <center><p><b>There are no videos found.</b></p></center>
            {/section}
        </div>
        {else}

            {section name=i loop=$view.videos}
               <div class="row">
                    <div class="col-sm-6 col-md-4">
                        <div class="thumbnail">
                            <div class="preview">
                                <a href="{$base_url}/view/{$view.videos[i].video_id}/{$view.videos[i].video_seo_name}/">
                                    <img class="img-responsive" width="100%" height="130" src="{$view.videos[i].video_thumb_url}/thumb/{$view.videos[i].video_folder}1_{$view.videos[i].video_id}.jpg" alt="{$view.videos[i].video_title}">
                                </a>
                                <span class="badge video-time">{$view.videos[i].video_length}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-8">
                        <h4>
                            <a href="{$base_url}/view/{$view.videos[i].video_id}/{$view.videos[i].video_seo_name}/">{$view.videos[i].video_title}</a>
                            <br>
                            <small>{$view.videos[i].video_description|truncate:150}</small>
                        </h4>
                        <p class="text-muted small">
                            {insert name=id_to_name assign=user_name un=$view.videos[i].video_user_id}
                            {insert name=time_range assign=added_on time=$view.videos[i].video_add_time}
                            <span class="glyphicon glyphicon-user"></span>
                            <a href="{$base_url}/{$user_name}">{$user_name}</a>,
                            {$added_on}
                            <br />
                            <span class="glyphicon glyphicon-eye-open"></span> Views {$view.videos[i].video_view_number},
                            <span class="glyphicon glyphicon-comment"></span> Comments {$view.videos[i].video_com_num},
                            <span class="text-nowrap">
                                <span class="glyphicon glyphicon-thumbs-up"></span> {$view.videos[i].video_rated_by} Likes
                            </span>
                        </p>
                    </div>
                    <hr>
                </div>
            {sectionelse}
                <br />
                <center><p><b>There are no videos found.</b></p></center>
            {/section}

        {/if}

    </div> <!-- video_block -->

    {if $view.page_links ne ""}
        <div class="page_links">
            {$view.page_links}
        </div>
    {/if}

</div>