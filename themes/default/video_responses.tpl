<div class="col-md-12">
    <div class="col-md-3">
        <div class="thumbnail">
            <div class="preview">
                <a href="{$base_url}/view/{$view.video_info.video_id}/{$view.video_info.video_seo_name}/">
                    <img class="img-response" width="100%" src="{$view.video_info.video_thumb_url}/thumb/{$view.video_info.video_folder}1_{$view.video_info.video_id}.jpg">
                </a>
                <div class="badge video-time">{$view.video_info.video_length}</div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <h5>
            <a href="{$base_url}/view/{$view.video_info.video_id}/{$view.video_info.video_seo_name}/">
                {$view.video_info.video_title}
            </a>
        </h5>
        <p class="text-muted small">{$view.video_info.video_description|truncate:160}</p>
        <p class="text-muted small">Added on  {$view.video_info.video_add_date|date_format}</p>
        <p class="text-muted small">
            Views: {$view.video_info.video_view_number} |
            Comments: {$view.video_info.video_com_num} |
            Rating: {insert name=show_rate assign=rate rte=$view.video_info.video_rate rated=$view.video_info.video_rated_by}{$rate}
        </p>
    </div>
    <div class="col-md-3">
        <div class="thumbnail">
            {insert name=id_to_name assign=uname un=$view.video_info.video_user_id}
            <a href="{$base_url}/{$uname}">
                {insert name=member_img UID=$view.video_info.video_user_id}
            </a>
            <div class="caption">
                <h5>
                    From: <a href="{$base_url}/{$uname}">{$uname}</a>
                </h5>
                {insert name=video_count assign=vdo_count type=public uid=$view.video_info.video_user_id}
                <p class="text-muted small">Videos: {$vdo_count}</p>
            </div>
        </div>
    </div>
</div>

<div class="col-md-12">
    <div class="page-header">
        <h2>
            Video Responses
            <span class="pull-right btn font-size-md">
                Videos {$view.start_num}-{$view.end_num} of {$view.total}
            </span>
        </h2>
    </div>

    <div class="row">
        {section name=i loop=$view.videos}
            <div class="col-md-3">
                <div class="thumbnail">
                    <div class="preview">
                        <a href="{$base_url}/view/{$view.videos[i].video_id}/{$view.videos[i].video_seo_name}/">
                            <img class="img-responsive" width="100%" src="{$view.videos[i].video_thumb_url}/thumb/{$view.videos[i].video_folder}1_{$view.videos[i].video_id}.jpg" alt="{$view.videos[i].video_title}">
                        </a>
                        <div class="badge video-time">{$view.videos[i].video_length}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <h5>
                    <a href="{$base_url}/view/{$view.videos[i].video_id}/{$view.videos[i].video_seo_name}/">{$view.videos[i].video_title|truncate:100}</a>
                </h5>
                <p class="text-muted small">{$view.videos[i].video_description|truncate:160}</p>
                {insert name=id_to_name assign=uname un=$view.videos[i].video_user_id}
                <p class="text-muted small">Added by: <a href="{$base_url}/{$uname}" target="_parent">{$uname}</a></p>
                {insert name=comment_count assign=commentcount vid=$view.videos[i].video_id}
                {insert name=show_rate assign=rate rte=$view.videos[i].video_rate rated=$view.videos[i].video_rated_by}
                <p class="text-muted small">
                    Views: {$view.videos[i].video_view_number} |
                    Comments: {$commentcount} |
                    {$rate}
                </p>
                <div>
                    {if $smarty.session.UID eq $view.video_info.video_user_id}
                        <form method="post" action="">
                            <input type="hidden" name="response_video_id" value="{$view.videos[i].video_id}" />
                            <button type="submit" name="remove_video" class="btn btn-default">Remove</button>
                        </form>
                    {/if}
                </div>
            </div>
            <div class="clearfix"></div>
            <hr>
        {sectionelse}
            <br />
            <center><p>There is no response video found.</p></center>
        {/section}
    </div>

    {if $view.page_links ne ""}
        <div>{$view.page_links}</div>
    {/if}
</div>