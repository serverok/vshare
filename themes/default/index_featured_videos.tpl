
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><span class="glyphicon glyphicon-film"></span> <strong>Today's Featured Videos</strong> <span class="pull-right">
        <a href="{$base_url}/featured/"> <span class="glyphicon glyphicon-plus"></span> More</a></span></h3>
    </div>
    <div class="panel-body">
        <div class="row">
        {section name=i loop=$featured_videos}
            <div class="col-sm-6 col-md-4">
                    <div class="preview">
                        <a href="{$base_url}/view/{$featured_videos[i].video_id}/{$featured_videos[i].video_seo_name}/">
                        <img class="img-responsive" width="100%" height="130" src="{$featured_videos[i].video_thumb_url}/thumb/{$featured_videos[i].video_folder}1_{$featured_videos[i].video_id}.jpg" alt="{$featured_videos[i].video_title}" />
                        </a>
                        <span class="badge video-time">{$featured_videos[i].video_length}</span>
                        <span class="btn btn-default btn-xs video-queue" id="queue_{$featured_videos[i].video_id}" data-id="{$featured_videos[i].video_id}" rel="video_queue">
                        <span class="glyphicon glyphicon-plus"></span>
                        </span>
                   </div>
                <h5><a href="{$base_url}/view/{$featured_videos[i].video_id}/{$featured_videos[i].video_seo_name}/">{$featured_videos[i].video_title|truncate:35}</a></h5>
                <small>{insert name=id_to_name assign=user_name un=$featured_videos[i].video_user_id}
                {insert name=time_range assign=added_on time=$featured_videos[i].video_add_time}
                <a href="{$base_url}/{$user_name}">{$user_name}</a>,
                {$added_on} | Views {$featured_videos[i].video_view_number}</small>
            </div>
        {/section}
        </div>
    </div>
</div>