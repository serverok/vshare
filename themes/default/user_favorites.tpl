{if $total gt "0"}
<div class="col-md-9">
    <div class="page-header">
        <h1>
            Favorites Videos of <strong>{$user_info.user_name}</strong>
            <span class="pull-right btn font-size-md">Videos {$start_num}-{$end_num} of {$total}</span>
        </h1>
    </div>

    {section name=i loop=$favVideos}
        <div class="row">
            <div class="col-sm-6 col-md-4">
                <div class="thumbnail">
                    <div class="preview">
                        <a href="{$base_url}/view/{$favVideos[i].video_id}/{$favVideos[i].video_seo_name}/">
                            <img class="img-responsive" width="100%" height="130" src="{$favVideos[i].video_thumb_url}/thumb/{$favVideos[i].video_folder}1_{$favVideos[i].video_id}.jpg" alt="{$favVideos[i].video_title}">
                        </a>
                        <span class="badge video-time">{$favVideos[i].video_length}</span>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-8">
                <h4>
                    <a href="{$base_url}/view/{$favVideos[i].video_id}/{$favVideos[i].video_seo_name}/">{$favVideos[i].video_title}</a>
                    <br>
                    <small>{$favVideos[i].video_description|truncate:80}</small>
                </h4>
                <p class="text-muted small">
                    {insert name=id_to_name assign=user_name un=$favVideos[i].video_user_id}
                    {insert name=time_range assign=added_on time=$favVideos[i].video_add_time}
                    <span class="glyphicon glyphicon-user"></span>
                    <a href="{$base_url}/{$user_name}"><strong>{$user_name}</strong></a>,
                    {$added_on}
                    <br />
                    <span class="glyphicon glyphicon-eye-open"></span> <strong>{$favVideos[i].video_view_number}</strong>  Views,
                    <span class="glyphicon glyphicon-comment"></span> <strong>{$favVideos[i].video_com_num}</strong> Comments ,
                    <span class="text-nowrap">
                    {if $favVideos[i].video_rated_by gt "0"}
                        {insert name=show_rate assign=rate rte=$favVideos[i].video_rate rated=$favVideos[i].video_rated_by}
                        {$rate}
                        ({$favVideos[i].video_rated_by} ratings)
                    {else}
                        Not yet rated
                    {/if}
                    </span>
                </p>
                {if $smarty.session.USERNAME eq $user_info.user_name}
                    <p>
                        <form name="USERFAVOUR" method="post" action="">
                            <input type="hidden" name="rvid" value="{$favVideos[i].video_id}" />
                            <button type="submit" class="btn btn-danger btn-sm" name="removfavour">
                                <span class="glyphicon glyphicon-remove"></span> Remove
                            </button>
                        </form>
                    </p>
                {/if}
            </div>
        </div>
        <hr>
	{/section}
    <div class="clearfix"></div>

    {if $page_links ne ""}
        <div>{$page_links}</div>
    {/if}
</div>

<div class="col-md-3">
    <a class="btn btn-default btn-block" href="{$base_url}/invite_friends.php">Share your videos!</a>

    <div class="page-header">
        <h2>My Tags</h2>
    </div>
    <div class="list-group">
        {section name=k loop=$view.video_keywords_all_array}
            <a class="list-group-item" href="{$base_url}/tag/{$view.video_keywords_all_array[k]}/">{$view.video_keywords_all_array[k]}</a>
        {/section}
	</div>

    <br>
    {insert name=advertise adv_name='wide_skyscraper'}
</div>
{else}
    <center><h4>There is no favorite video found</h4></center>
{/if}