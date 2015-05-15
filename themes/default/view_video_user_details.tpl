<div>
    <div class="thumbnail">
        <a href="{$base_url}/{$view.user_info.user_name}">
            {insert name=member_img UID=$view.video_info.video_user_id}
        </a>
    </div>
</div>
<div>
    <h4>
        <a href="{$base_url}/{$view.user_info.user_name}">{$view.user_info.user_name}</a>
        {if $view.user_info.user_website ne ""}
            <br>
            <small>Website: <a href="{$view.user_info.user_website}" target="_blank">{$view.user_info.user_website}</a></small>
        {/if}
    </h4>
    {insert name=video_count assign=vdocount uid=$view.video_info.video_user_id}
    {insert name=favour_count assign=favcount uid=$view.video_info.video_user_id}
    {insert name=friends_count assign=friendcount uid=$view.video_info.video_user_id}

    <p class="text-muted small text-center">
        <span class="text-nowrap">{$vdocount} <a href="{$base_url}/{$view.user_info.user_name}/public/">Videos</a> |</span>
        <span class="text-nowrap">{$favcount} <a href="{$base_url}/{$view.user_info.user_name}/favorites/">Favorites</a> |</span>
        <span class="text-nowrap">{$friendcount} <a href="{$base_url}/{$view.user_info.user_name}/friends/">Friends</a></span>
    </p>
    <p class="text-muted small text-center">
        <span class="text-nowrap">
            (<a href="{$base_url}/mail.php?folder=compose&receiver={$view.user_info.user_name}">Send Me a Private Message!</a>)
        </span>
    </p>
</div>