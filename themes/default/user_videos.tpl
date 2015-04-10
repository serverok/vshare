{if $total gt "0"}
<div class="col-md-9">
    <div class="page-header">
        <h1>
            {if $smarty.request.type eq "private"}Private Videos
            {else}Public Videos
            {/if}
             of <strong>{$user_info.user_name}</strong>
            <small class="pull-right btn font-size-md">
                Videos {$start_num}-{$end_num} of {$total}
            </small>
        </h1>
    </div>
    {section name=i loop=$view.videos}
        <div class="row">
            <div class="col-sm-5 col-md-4">
                <div class="thumbnail">
                    <div class="preview">
                        <a href="{$base_url}/view/{$view.videos[i].video_id}/{$view.videos[i].video_seo_name}/">
                            <img class="img-responsive" width="100%" height="130" src="{$view.videos[i].video_thumb_url}/thumb/{$view.videos[i].video_folder}1_{$view.videos[i].video_id}.jpg" alt="{$view.videos[i].video_title}">
                        </a>
                        <span class="badge video-time">{$view.videos[i].video_length}</span>
                    </div>
                </div>
            </div>
            <div class="col-sm-7 col-md-8">
                <h4>
                    <a href="{$base_url}/view/{$view.videos[i].video_id}/{$view.videos[i].video_seo_name}/">{$view.videos[i].video_title}</a>
                </h4>
                <p>{$view.videos[i].video_description|truncate:80}</p>
                <span class="text-muted small">
                    <span class="glyphicon glyphicon-tag"></span>
                    {section name=j loop=$view.videos[i].video_keywords_array}
                        <a href="{$base_url}/tag/{$view.videos[i].video_keywords_array[j]}/">{$view.videos[i].video_keywords_array[j]}</a>&nbsp;
                    {/section}
                    <br>
                    {insert name=id_to_name assign=user_name un=$view.videos[i].video_user_id}
                    {insert name=time_range assign=added_on time=$view.videos[i].video_add_time}
                    <span class="glyphicon glyphicon-user"></span>
                    <a href="{$base_url}/{$user_name}"><strong>{$user_name}</a></strong>,
                    {$added_on}
                    <br />
                    <span class="glyphicon glyphicon-eye-open"></span> <strong>{$view.videos[i].video_view_number}</strong> Views ,
                    <span class="glyphicon glyphicon-comment"></span> <strong>{$view.videos[i].video_com_num}</strong>  Comments,
                    <span class="text-nowrap">
                    {if $view.videos[i].video_rated_by gt "0"}
                        {insert name=show_rate assign=rate rte=$view.videos[i].video_rate rated=$view.videos[i].video_rated_by}
                        {$rate}
                        ({$view.videos[i].video_rated_by} ratings)
                    {else}
                        Not yet rated
                    {/if}
                    </span>
                 </span>
                 {if $user_info.user_name == $smarty.session.USERNAME}
                    <div>
                        <form name="editVideoForm" action="{$base_url}/video_edit.php" method="GET" style="display: inline;">
                            <input type="hidden" value={$view.videos[i].video_id} name="video_id" />
                            <input type="hidden" value={$page} name="page" />
                            <button type="submit" class="btn btn-default btn-sm" title="Edit">
                                <span class="glyphicon glyphicon-edit"></span> Edit
                            </button>
                        </form>
                        <form name="removeVideoForm" action="" method="POST" style="display: inline;margin-left: 1em;">
                            <input type="hidden" value="1" name="remove_video" />
                            <input type="hidden" value="{$view.videos[i].video_id}" name="VID" />
                            <button type="submit" class="btn btn-danger btn-sm" title="Delete" onclick="return confirm('Are you sure you want to remove this video?');">
                                <span class="glyphicon glyphicon-remove"></span> Delete
                            </button>
                        </form>
                   </div>
                {/if}
            </div>
        </div>
        <hr>
    {/section}

    <div class="clearfix"></div>
    {if $page_links ne ""}
        <div>{$page_links}</div>
    {/if}
</div> <!-- content -->

<div class="col-md-3">
    <a class="btn btn-default btn-sm btn-block" href="{$base_url}/invite_friends.php">Share your videos!</a>

    <div class="page-header">
        <h2>My Tags:</h2>
    </div>
    <div class="list-group">
        {section name=k loop=$view.video_keywords_array_all}
            <a class="list-group-item" href="{$base_url}/tag/{$view.video_keywords_array_all[k]}/">{$view.video_keywords_array_all[k]}</a>
        {/section}
    </div>

    {insert name=advertise adv_name='wide_skyscraper'}
</div>

{else}

    <center><h4>There is no video found</h4></center>

{/if}