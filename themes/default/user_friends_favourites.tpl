{if $total gt "0"}
    <div class="col-md-9">
        <div class="page-header">
            <h1>
                My Friend's Favorites
                <small class="pull-right font-size-md btn">
                    Videos {$start_num}-{$end_num} of {$total}
                </small>
            </h1>
        </div>


    	{section name=i loop=$answers}
            <div class="row">
                <div class="col-sm-6 col-md-4">
                    <div class="thumbnail">
                        <div class="preview">
                            <a href="{$base_url}/view/{$answers[i].video_id}/{$answers[i].video_seo_name}/">
                                <img class="img-responsive" width="100%" height="130" src="{$answers[i].video_thumb_url}/thumb/{$answers[i].video_folder}1_{$answers[i].video_id}.jpg" alt="{$answers[i].video_title}">
                            </a>
                            <span class="badge video-time">{$answers[i].video_length}</span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-8">
                    <h4>
                        <a href="{$base_url}/view/{$answers[i].video_id}/{$answers[i].video_seo_name}/">{$answers[i].video_title}</a>
                        <br>
                        <small>{$answers[i].video_description|truncate:150}</small>
                    </h4>
                    <p class="text-muted small">
                        {insert name=id_to_name assign=user_name un=$answers[i].video_user_id}
                        {insert name=time_range assign=added_on time=$answers[i].video_add_time}
                        <span class="glyphicon glyphicon-user"></span>
                        <a href="{$base_url}/{$user_name}">{$user_name}</a>,
                        {$added_on}
                        <br />
                        <span class="glyphicon glyphicon-eye-open"></span> Views {$answers[i].video_view_number},
                        <span class="glyphicon glyphicon-comment"></span> Comments {$answers[i].video_com_num},
                        <span class="text-nowrap">
                            <span class="glyphicon glyphicon-thumbs-up"></span> {$answers[i].video_rated_by} Likes
                        </span>
                    </p>
                </div>
            </div>
            <hr>
    	{/section}

    	{if $page_links ne ""}
    		<div>{$page_links}</div>
    	{/if}
    </div>

    <div class="col-md-3">
        {insert name=advertise adv_name='wide_skyscraper'}
    </div>
{else}
    <div class="alert alert-warning">
        <p><strong>You have not invited any friends or family at this time!</strong></p>
        <p><a href="{$base_url}/invite_friends.php">Invite</a> your friends and family to start sharing videos today!</p>
    </div>
{/if}