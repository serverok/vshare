<div class="col-md-9">
<div class="page-header">
    <h1>
        Videos with tag <strong>{$search_string}</strong>
        <small class="pull-right font-size-md btn">Results {$start_num} - {$end_num} of {$total}</small>
        <div class="btn-group col-md-offset-1">
            <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                Sort by <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" role="menu">
                <li><a href="{$base_url}/tag/{$smarty.get.search_string}/?sort=adddate">Date added</a></li>
                <li><a href="{$base_url}/tag/{$smarty.get.search_string}/?sort=viewnum">View count</a></li>
                <li><a href="{$base_url}/tag/{$smarty.get.search_string}/?sort=rate">Rating</a></li>
            </ul>
        </div>
    </h1>
</div>

{section name=i loop=$video_info}
    <div class="row">
        <div class="col-orient-ls col-sm-6 col-md-4">
            <div class="thumbnail">
                <div class="preview">
                    <a href="{$base_url}/view/{$video_info[i].video_id}/{$video_info[i].video_seo_name}/">
                        <img class="img-responsive" width="100%" height="130" src="{$video_info[i].video_thumb_url}/thumb/{$video_info[i].video_folder}1_{$video_info[i].video_id}.jpg" alt="{$video_info[i].video_title}" />
                    </a>
                    <span class="badge video-time">{$video_info[i].video_length}</span>
                    <span class="btn btn-default btn-xs video-queue" id="queue_{$video_info[i].video_id}" data-id="{$video_info[i].video_id}" rel="video_queue">
                        <span class="glyphicon glyphicon-plus"></span>
                    </span>
                </div>
            </div>
        </div>

        <div class="col-orient-ls col-sm-6 col-md-8">
            <h4>
                <a href="{$base_url}/view/{$video_info[i].video_id}/{$video_info[i].video_seo_name}/">{$video_info[i].video_title}</a>
            </h4>

            <p>{$video_info[i].video_description|truncate:150}</p>

            <p class="text-muted small">
                {insert name=id_to_name assign=user_name un=$video_info[i].video_user_id}
                {insert name=time_range assign=added_on time=$video_info[i].video_add_time}
                <span class="glyphicon glyphicon-user"></span>
                <a href="{$base_url}/{$user_name}"><b>{$user_name}</b></a>,
                {$added_on} </p>
                 <p class="text-muted small">
                <span class="glyphicon glyphicon-eye-open"></span> Views {$video_info[i].video_view_number}&nbsp;|&nbsp;
                <span class="glyphicon glyphicon-comment"></span> Comments {$video_info[i].video_com_num} &nbsp;|&nbsp;
                <span class="text-nowrap">
                    <span class="glyphicon glyphicon-thumbs-up"></span> {$video_info[i].video_rated_by} Likes
                </span>
            </p>
        </div>

    </div>
<hr>
{/section}

{if $page_links ne ""}
    <div class="page_links">{$page_links}</div>
{/if}
</div>

<div class="col-md-3">
    {insert name=advertise adv_name='wide_skyscraper'}
</div>