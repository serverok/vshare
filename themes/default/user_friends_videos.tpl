{if $total gt "0"}
	<div class="col-md-9">
        <div class="page-header">
            <h1>
                My Friends Video
                <small class="pull-right font-size-md btn">
                    Videos {$start_num}-{$end_num} of {$total}
                </small>
            </h1>
        </div>

        {section name=i loop=$videoRows}
            <div class="row">
                <div class="col-sm-6 col-md-4">
                    <div class="thumbnail">
                        <div class="preview">
                            <a href="{$base_url}/view/{$videoRows[i].video_id}/{$videoRows[i].video_seo_name}/">
                                <img class="img-responsive" width="100%" height="130" src="{$videoRows[i].video_thumb_url}/thumb/{$videoRows[i].video_folder}1_{$videoRows[i].video_id}.jpg" alt="{$videoRows[i].video_title}">
                            </a>
                            <span class="badge video-time">{$videoRows[i].video_length}</span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-8">
                    <h4>
                        <a href="{$base_url}/view/{$videoRows[i].video_id}/{$videoRows[i].video_seo_name}/">{$videoRows[i].video_title}</a>
                        <br>
                        <small>{$videoRows[i].video_description|truncate:150}</small>
                    </h4>
                    <p class="text-muted small">
                        {insert name=id_to_name assign=user_name un=$videoRows[i].video_user_id}
                        {insert name=time_range assign=added_on time=$videoRows[i].video_add_time}
                        <span class="glyphicon glyphicon-user"></span>
                        <a href="{$base_url}/{$user_name}">{$user_name}</a>,
                        {$added_on}
                        <br />
                        <span class="glyphicon glyphicon-eye-open"></span> Views {$videoRows[i].video_view_number},
                        <span class="glyphicon glyphicon-comment"></span> Comments {$videoRows[i].video_com_num},
                        <span class="text-nowrap">
                            <span class="glyphicon glyphicon-thumbs-up"></span> {$videoRows[i].video_rated_by} Likes
                        </span>
                    </p>
                </div>
                <hr>
            </div>
		{/section}

        {if $page_links ne ""}
            <div>{$page_links}</div>
        {/if}
	</div>

	<div class="col-md-3">
        <a class="btn btn-default btn-sm btn-block" href="{$base_url}/invite_friends.php">Share your videos!</a>

        <div class="page-header">
            <h2>My Tags</h2>
        </div>
        <div class="list-group">
            {section name=k loop=$view.video_keywords_array_all}
                <a class="list-group-item" href="{$base_url}/tag/{$view.video_keywords_array_all[k]}/">{$view.video_keywords_array_all[k]}</a>
            {/section}
        </div>
	</div>
{else}
	<div class="alert alert-warning">
        <p><strong>You have not invited any friends or family at this time!</strong></p>
        <p><a href="{$base_url}/invite_friends.php">Invite</a> your friends and family to start sharing videos today!</p>
    </div>
{/if}