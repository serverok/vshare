
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><span class="glyphicon glyphicon-film"></span> <strong>Today's Featured Videos</strong> <span class="pull-right">
        <a href="{$base_url}/featured/"> <span class="glyphicon glyphicon-plus"></span> More</a></span></h3>
    </div>
<div class="panel-body">
{section name=i loop=$featured_videos}
    <div class="row">
        <div class="col-sm-6 col-md-4">
            <div class="thumbnail">
                <div class="preview">
                    <a href="{$base_url}/view/{$featured_videos[i].video_id}/{$featured_videos[i].video_seo_name}/">
                        <img class="img-responsive" width="100%" height="130" src="{$featured_videos[i].video_thumb_url}/thumb/{$featured_videos[i].video_folder}1_{$featured_videos[i].video_id}.jpg" alt="{$featured_videos[i].video_title}" />
                    </a>
                    <span class="badge video-time">{$featured_videos[i].video_length}</span>
                    <span class="btn btn-default btn-xs video-queue" id="queue_{$featured_videos[i].video_id}" data-id="{$featured_videos[i].video_id}" rel="video_queue">
                        <span class="glyphicon glyphicon-plus"></span>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-8">
            <h4>
                <a href="{$base_url}/view/{$featured_videos[i].video_id}/{$featured_videos[i].video_seo_name}/">{$featured_videos[i].video_title}</a>
                <br>
                <small>{$featured_videos[i].video_description|truncate:150}</small>
            </h4>
            <p class="text-muted small">
                <span class="glyphicon glyphicon-tag"></span>
                {section name=j loop=$featured_videos[i].video_keywords_array}
                    <a href="{$base_url}/tag/{$featured_videos[i].video_keywords_array[j]}/">{$featured_videos[i].video_keywords_array[j]}</a>&nbsp;
                {/section}
            </p>
            <p class="text-muted small">
                {insert name=id_to_name assign=user_name un=$featured_videos[i].video_user_id}
                {insert name=time_range assign=added_on time=$featured_videos[i].video_add_time}
                <span class="glyphicon glyphicon-user"></span>
                <a href="{$base_url}/{$user_name}">{$user_name}</a>,
                {$added_on}
                <br />
                <span class="glyphicon glyphicon-eye-open"></span> Views {$featured_videos[i].video_view_number},
                <span class="glyphicon glyphicon-comment"></span> Comments {$featured_videos[i].video_com_num},
                <span class="text-nowrap">
                {if $featured_videos[i].video_rated_by gt "0"}
                    {insert name=show_rate assign=rate rte=$featured_videos[i].video_rate rated=$featured_videos[i].video_rated_by}
                    {$rate}
                    ({$featured_videos[i].video_rated_by} ratings)
                {else}
                    Not yet rated
                {/if}
                </span>
            </p>
        </div>
    </div>
    <hr>
{/section}
</div>
</div>