<div class="col-md-3">
    <div class="page-header">
        <h2>Playlists</h2>
    </div>
    <div class="list-group">
        {section name=i loop=$playlists}
            <a class="list-group-item" href="{$base_url}/{$user_info.user_name}/playlist/{$playlists[i].playlist_name}/1">
                {$playlists[i].playlist_name}
            </a>
        {/section}
    </div>
    <div class="clearfix"></div>

    {if $user_info.user_id eq $smarty.session.UID}
        <form method="post" name="pl-frm" id="pl-frm" action="">
            <div class="form-group">
                <label>Create New Playlist:</label>
                <input type="text" name="playlist_name" id="playlist_name" class="form-control" required>
            </div>
            <div class="form-group">
                <button type="submit" name="create_playlist" id="create" class="btn btn-default">Add</button>
            </div>
        </form>
    {/if}
</div>

<div class="col-md-9">
    {if $playlists|@count eq "0"}
        <center><h4>There is no playlist found.</h4></center>
    {else}
        <div class="page-header">
            <h1>
                Videos of: {$playlist_info.playlist_name}
                {if $smarty.session.UID eq $playlist_info.playlist_user_id}
                    <a class="btn btn-default col-md-offset-1" onclick="Javascript:return confirm('Are you sure you want to delete?');" href="{$base_url}/playlist_delete.php?pl_id={$playlist_info.playlist_id}&action=pl_del">
                        <span class="glyphicon glyphicon-remove"></span> Delete Playlist
                    </a>
                {/if}
                <span class="pull-right btn font-size-md">Videos {$start_num}-{$end_num} of {$total}</span>
            </h1>
        </div>

        {section name=i loop=$videos}
            <div class="row">
                <div class="col-sm-6 col-md-4">
                    <div class="thumbnail">
                        <div class="preview">
                            <a href="{$base_url}/view/{$videos[i].video_id}/{$videos[i].video_seo_name}/">
                                <img class="img-responsive" width="100%" height="130" src="{$videos[i].video_thumb_url}/thumb/{$videos[i].video_folder}1_{$videos[i].video_id}.jpg" alt="{$videos[i].video_title}">
                            </a>
                            <span class="badge video-time">{$videos[i].video_length}</span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-8">
                    <h4>
                        <a href="{$base_url}/view/{$videos[i].video_id}/{$videos[i].video_seo_name}/">{$videos[i].video_title}</a>
                        <br>
                        <small>{$videos[i].video_description|truncate:70}</small>
                    </h4>
                    <p class="text-muted small">
                        {insert name=id_to_name assign=user_name un=$videos[i].video_user_id}
                        {insert name=time_range assign=added_on time=$videos[i].video_add_time}
                        <span class="glyphicon glyphicon-user"></span>
                        <a href="{$base_url}/{$user_name}">{$user_name}</a>,
                        {$added_on}
                        <br />
                        <span class="glyphicon glyphicon-eye-open"></span> Views {$videos[i].video_view_number},
                        <span class="glyphicon glyphicon-comment"></span> Comments {$videos[i].video_com_num},
                        <span class="text-nowrap">
                        {if $videos[i].video_rated_by gt "0"}
                            {insert name=show_rate assign=rate rte=$videos[i].video_rate rated=$videos[i].video_rated_by}
                            {$rate}
                            ({$videos[i].video_rated_by} ratings)
                        {else}
                            Not yet rated
                        {/if}
                        </span>
                    </p>
                    {if $user_info.user_name eq $smarty.session.USERNAME}
                        <p>
                            <a class="btn btn-default btn-sm" href="{$base_url}/playlist_delete.php?pl_id={$playlist_info.playlist_id}&action=vdo_del&vid={$videos[i].video_id}&page={$page}" title="Remove from playlist">
                                <span class="glyphicon glyphicon-remove"></span> Remove
                            </a>
                        </p>
                    {/if}
                </div>
                <hr>
            </div>
        {sectionelse}
            <center><h4>There is no video found.</h4></center>
        {/section}

        {if $page_links ne ""}
            <div>{$page_links}</div>
        {/if}
    {/if}
</div>