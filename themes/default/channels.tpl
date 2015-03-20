<div class="page-header">
    <h1>All Channels</h1>
</div>

<div class="row">
    {section name=i loop=$channels}
    <div class="col-sm-6 col-md-3">
        <div class="thumbnail">
            <div class="preview">
                <a href="{$base_url}/channel/{$channels[i].channel_id}/{$channels[i].channel_seo_name}/">
                    <img class="img-responsive" width="100%" height="130" src="{$base_url}/chimg/{$channels[i].channel_id}.jpg" alt="channel">
                </a>
            </div>
            <div class="caption">
                <h5>
                    <a href="{$base_url}/channel/{$channels[i].channel_id}/{$channels[i].channel_seo_name}/">
                        {$channels[i].channel_name_html}
                    </a>
                    <br>
                    <small>{$channels[i].channel_description|truncate:40}</small>
                </h5>
                {insert name=channel_count assign=infoch cid=$channels[i].channel_id}
                <p class="text-muted small">
                    <span class="glyphicon glyphicon-facetime-video"></span>
                    &nbsp;Today: {$infoch[0]} | Total: {$infoch[1]}
                </p>
                <p class="text-muted small">
                    <span class="glyphicon glyphicon-globe"></span>
                    Groups: {$infoch[2]}
                </p>
            </div>
        </div>
    </div>
    {/section}
</div>