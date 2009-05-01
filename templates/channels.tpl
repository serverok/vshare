<div class="section bg2">

    <div class="hd">
        <div class="hd-l">
            All Channels
        </div>
    </div>

    <ul id="channels">
        {section name=i loop=$channels}
            {insert name=channel_count assign=infoch cid=$channels[i].channel_id}
            <li>
                <a href="{$base_url}/channel/{$channels[i].channel_id}/{$channels[i].channel_seo_name}/">
                    <img class="preview" src="{$base_url}/chimg/{$channels[i].channel_id}.jpg" alt="channel" width="120" height="90" />
                </a>
                <br />
                <a href="{$base_url}/channel/{$channels[i].channel_id}/{$channels[i].channel_seo_name}/">
                    {$channels[i].channel_name_html}
                </a>
                <div class="channel-activity">
                    <img src="{$img_css_url}/images/star.gif" width="12" alt="star" />
                    &nbsp;Today: {$infoch[0]} | Total: {$infoch[1]} 
                </div>
                <div class="channel-groups">
                    Groups: {$infoch[2]} 
                </div>
                <div class="channel_description">
                    {$channels[i].channel_description}
                </div>
            </li>
        {/section}
    </ul>
	<div class="clearfix"></div>

</div>