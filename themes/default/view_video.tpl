<div class="col-md-8">
        <div class="page-header">
            <h1>{$view.video_info.video_title}</h1>
        </div>

        {insert name=advertise adv_name='player_top'}

        <div class="embed-responsive embed-responsive-16by9">{$view.VSHARE_PLAYER}</div>

        {insert name=advertise adv_name='player_bottom'}

        {if $view.owner_video_info ne ''}
    	<p class="alert alert-info">
    	    <label>This is a video response to <a href="{$base_url}/view/{$view.owner_video_info.video_id}/{$view.owner_video_info.video_seo_name}/">{$view.owner_video_info.video_title}</a></label>
    	</p>
    	{/if}

        <br>

        <div class="col-md-8">
            <div class="row">
                <div class="btn-group">
                    <a class="btn btn-default" href="javascript:void(0);" onclick="video_add_favorite({$view.video_info.video_id});">
                        <span class="glyphicon glyphicon-heart"></span> Add to Favorites
                    </a>
                    <div class="btn-group" role="group">
                        <a class="btn btn-default dropdown-toggle" id="playlist-form-btn" data-toggle="dropdown" aria-expanded="false">
                            <span class="glyphicon glyphicon-play-circle"></span> Add to Playlist <span class="caret"></span>
                        </a>
                        <div id="show_playlists" class="dropdown-menu" role="menu"></div>
                    </div>
                    <a class="btn btn-default btn-video-share" href="javascript:void(0);">
                        <span class="glyphicon glyphicon-share"></span> Share
                    </a>
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <span class="glyphicon glyphicon-option-horizontal"></span> More <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <a href="javascript:void(0);" onclick="feature();">
                                    <span class="glyphicon glyphicon-star"></span> Feature this
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" onclick="inappropriate();">
                                    <span class="glyphicon glyphicon-flag"></span> Report
                                </a>
                            </li>
                            {if $allow_download == 1}
                                {if $view.video_info.video_vtype eq 0 && $view.package_allow_video_download eq '1'}
                                    <li>
                                        <a href="{$base_url}/download/{$view.video_info.video_id}/">
                                            <span class="glyphicon glyphicon-download"></span> Download
                                        </a>
                                    </li>
                                {/if}
                            {/if}
                            {if $smarty.session.UID eq $view.video_info.video_user_id}
                                <li>
                                    <a href="{$base_url}/edit/video/{$view.video_info.video_id}">
                                        <span class="glyphicon glyphicon-edit"></span> Edit
                                    </a>
                                </li>
                            {/if}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="row">
                <div id="video-rating">
                    {insert name=video_rating assign=rating id=$view.video_info.video_id}{$rating}
                </div>
            </div>
        </div>
        <div class="clearfix">&nbsp;</div>
        <p id="video-tools-result" class="text-info"></p>

        <!-- video feedback end -->

        <div id="video-tools-feedback" style="display: none;">
            <div class="page-header">
                <a class="btn btn-default pull-right" href="javascript:void(0)" onclick="inappropriate_cancel();" title="Close">
                    <span class="glyphicon glyphicon-remove"></span>
                </a>
                <h3>Report this video</h3>
            </div>
            <form id="video-report-form" name="form1" onsubmit="javascript:feedback();" method="post" action="javascript:void(0)" class="form-horizontal">
                <div class="form-group">
                    <label class="control-label col-md-2">Type of abuse</label>
                    <div class="col-md-4 col-sm-6">
                        <select name="abuse_type" id="abuse_type" class="form-control">
                            <option value="">Select a category</option>
                            <option value="porn">Porn</option>
                            <option value="racism">Racism</option>
                            <option value="prohibited">Prohibited</option>
                            <option value="violent">Violent</option>
                            <option value="copyright">Copyright</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-2">Comments</label>
                    <div class="col-md-6 col-sm-6">
                        <textarea name="abuse_comments" id="abuse_comments" rows="4" class="form-control"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-2 col-md-offset-2">
                        <button type="submit" class="btn btn-default" name="send">Send</button>
                    </div>
                </div>
                <div class="clearfix"></div>
            </form>
        </div> <!-- video-tools-feedback -->

        <!-- Video share tools -->

        <div id="video-tools-share" style="display: none;">
            <div class="page-header">
                <a class="btn btn-default pull-right btn-video-share" href="javascript:void(0)" title="Close">
                    <span class="glyphicon glyphicon-remove"></span>
                </a>
                <h3>Share Details</h3>
            </div>
            <div class="btn-group">
                <a class="btn btn-default btn-xs" href="{$base_url}/friends/recommend/{$view.video_info.video_id}/" title="Recommend Friends by E-Mail"><img src="{$baseurl}/themes/default/images/icon_mail.png" width="45" height="45" border="0" alt="Mail"></a>
                <a class="btn btn-default btn-xs" href="http://www.facebook.com/share.php?u={$base_url}/view/{$view.video_info.video_id}/{$view.video_info.video_seo_name}/&amp;t={$view.video_info.video_title}" title="FaceBook" target="_blank"><img src="{$baseurl}/themes/default/images/icon_facebook.png" width="45" height="45" border="0" alt="facebook"></a>
                <a class="btn btn-default btn-xs" href="https://plus.google.com/share?url={$base_url}/view/{$view.video_info.video_id}/{$view.video_info.video_seo_name}/" title="Google+" target="_blank"><img src="{$baseurl}/themes/default/images/icon_google-plus.png" width="45" height="45" border="0" alt="Google+"></a>
                <a class="btn btn-default btn-xs" href="http://digg.com/submit?phase=2&amp;url={$base_url}/view/{$view.video_info.video_id}/{$view.video_info.video_seo_name}/&amp;title={$view.video_info.video_title}" title="Digg It!" target="_blank"><img src="{$baseurl}/themes/default/images/icon_digg.png" width="45" height="45" border="0" alt="digg"></a>
                <a class="btn btn-default btn-xs" href="http://del.icio.us/post?url={$base_url}/view/{$view.video_info.video_id}/{$view.video_info.video_seo_name}/&amp;title={$view.video_info.video_title}" title="del.icio.us" target="_blank"><img src="{$baseurl}/themes/default/images/icon_delicious.png" width="45" height="45" border="0" alt="delicious"></a>
                <a class="btn btn-default btn-xs" href="http://newsvine.com/_tools/seed&amp;save?u={$base_url}/view/{$view.video_info.video_id}/{$view.video_info.video_seo_name}/&amp;u={$view.video_info.video_title}" title="NewsVine" target="_blank"><img src="{$baseurl}/themes/default/images/icon_newsvine.png" width="45" height="45" border="0" alt="newsvine"></a>
                <a class="btn btn-default btn-xs" href="http://reddit.com/submit?url={$base_url}/view/{$view.video_info.video_id}/{$view.video_info.video_seo_name}/&amp;title={$view.video_info.video_title}" title="reddit" target="_blank"><img src="{$baseurl}/themes/default/images/icon_reddit.png" width="45" height="45" border="0" alt="reddit"></a>
                <a class="btn btn-default btn-xs" href="http://simpy.com/simpy/LinkAdd.do?href={$base_url}/view/{$view.video_info.video_id}/{$view.video_info.video_seo_name}/&amp;title={$view.video_info.video_title}" title="Simpy" target="_blank"><img src="{$baseurl}/themes/default/images/icon_simpy.png" width="45" height="45" border="0" alt="simpy"></a>
                <a class="btn btn-default btn-xs" href="http://spurl.net/spurl.php?title={$view.video_info.title}&amp;url={$base_url}/view/{$view.video_info.video_id}/{$view.video_info.video_seo_name}/" title="Spurl" target="_blank"><img src="{$baseurl}/themes/default/images/icon_spurl.png" width="45" height="45" border="0" alt="spurl"></a>
                <a class="btn btn-default btn-xs" href="http://myweb2.search.yahoo.com/myresults/bookmarklet?u={$base_url}/view/{$view.video_info.video_id}/{$view.video_info.video_seo_name}/&amp;t={$view.video_info.video_title}" title="My Yahoo!" target="_blank"><img src="{$baseurl}/themes/default/images/icon_yahoo.png" width="45" height="45" border="0" alt="yahoo"></a>
            </div>
            <div class="clearfix">&nbsp;</div>
            <form role="form">
                <div class="form-group">
                    <label>Video URL (Permanent Link):</label>
                    <input class="form-control" value="{$base_url}/view/{$view.video_info.video_id}/{$view.video_info.video_seo_name}/" onclick="javascript:this.focus();this.select();" readonly="readonly">
                </div>
                {if $view.video_info.video_vtype eq "0" && ($view.video_info.video_type == "public" || $view.video_info.video_user_id == $smarty.session.UID)}
                    {if $view.video_info.video_allow_embed eq "enabled" && $embed_show eq 1}
                        <div class="form-group">
                            <label>Embeddable Player:</label>
                            <input class="form-control" value='{if $embed_type eq "0"}<iframe vspace="0" hspace="0" allowtransparency="true" scrolling="no" marginwidth="0" marginheight="0" frameborder="0" style="border:0px;" width="600" height="500" SRC="{$base_url}/show.php?id={$view.video_info.video_id}"></iframe>{else}<object width="560" height="340"><param name="movie" value="{$base_url}/v/{$view.video_info.video_id}&hl=en_US&fs=1&"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="{$base_url}/v/{$view.video_info.video_id}&hl=en_US&fs=1&" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="560" height="340"></embed></object>{/if}' onclick="javascript:this.focus();this.select();" readonly="readonly">
                            <div class="help-block">(Put this video on your website. Works on Friendster, eBay, Blogger, MySpace!)</div>
                        </div>
                    {/if}
                {/if}
            </form>
        </div>

        <p>
            <strong>
                Added on {$view.video_info.video_add_date|date_format}
                by
                <a class="btn bg-info" role="button" tabindex="0" data-toggle="popover">
                    <strong>{$view.user_info.user_name} <span class="caret"></span></strong>
                </a>
            </strong>
        </p>
        <script>
        $(function () {
            $('[data-toggle="popover"]').popover({
                placement: 'bottom',
                trigger: 'click',
                html: 'true',
                title: '<h4><strong>{$view.user_info.user_name}</strong></h4>',
                content: $("#user-details-container").html()
            });
            $(".btn-video-share").click(function(){
                $("#video-tools-share").slideToggle('fast');
            });
        });
        </script>
        <div class="hidden" id="user-details-container">
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
        </div>

        <p class="text-justify">{$view.video_info.video_description}</p>
        <p>
            <strong>Tags:</strong>
            {section name=j loop=$view.tags}
                <a href="{$base_url}/tag/{$view.tags[j]}/">{$view.tags[j]}</a>&nbsp;
            {/section}
        </p>
        <p>
            <strong>Length:</strong> {$view.video_info.video_length} |
            <strong>Views:</strong> {$view.video_info.video_view_number} |
            <strong>Comments:</strong> {$view.video_info.video_com_num}
        </p>
        <p>
            <strong>Channels:</strong>
            {insert name=video_channel assign=channel vid=$view.video_info.video_id}
            {section name=k loop=$channel}
                <a href="{$base_url}/channel/{$channel[k].channel_id}/{$channel[k].channel_seo_name}/">{$channel[k].channel_name}</a> &nbsp;
            {/section}
        </p>

        {insert name=video_response_count video_id=$view.video_info.video_id assign=response_count}
        <div class="page-header">
            <h2>
                Video Responses (<a href="{$base_url}/response/{$view.video_info.video_id}/videos/1">{$response_count}</a>)
                <small class="pull-right font-size-md btn">
                    <a href="{$base_url}/video_response_upload/{$view.video_info.video_id}">Post Video Response</a>
                </small>
            </h2>
        </div>

        <div class="row">
            {section name=i loop=$view.video_responses}
                <div class="col-md-4 col-sm-6">
                    <div class="thumbnail">
                        <div class="preview">
                            <a href="{$base_url}/view/{$view.video_responses[i].video_id}/{$view.video_responses[i].video_seo_name}/" title="{$view.video_responses[i].video_title}">
                                <img class="img-responsive" width="100%" src="{$view.video_responses[i].video_thumb_url}/thumb/{$view.video_responses[i].video_folder}1_{$view.video_responses[i].video_id}.jpg" alt="{$view.video_responses[i].video_title}">
                            </a>
                            <div class="badge video-time">{$view.video_responses[i].video_length}</div>
                        </div>
                        <div class="caption">
                            <h5>
                                <a href="{$base_url}/view/{$view.video_responses[i].video_id}/{$view.video_responses[i].video_seo_name}/">
                                    {$view.video_responses[i].video_title|truncate:20}
                                </a>
                            </h5>
                            {insert name=id_to_name assign=uname un=$view.video_responses[i].video_user_id}
                            <p class="text-muted small">
                                by <a href="{$base_url}/{$uname}">{$uname}</a> |
                                {$view.video_responses[i].video_view_number} views
                            </p>
                        </div>
                    </div>
                </div>
            {sectionelse}
                <center><p>Be the first to post a video response!</p></center>
            {/section}
        </div>

        <div class="page-header">
            <h2>Post Comments</h2>
        </div>

        {if $view.video_info.video_allow_comment eq "yes"}
            <div id="comment_box">
                <form name="add_comment" method="post" action="" role="form">
                    <div class="form-group">
                        <label>Comment on this video:</label>
                        <textarea name="user_comment" id="user_comment" rows="3" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <button type="button" name="post" class="btn btn-default btn-lg" onclick="video_post_comment({$view.video_info.video_id})">Post</button>
                    </div>
                </form>
            </div>
        {/if}

        <div id="comment_post_result" class="alert text-info"></div>

        <div class="page-header">
            <h2>Comments: (<span>{$view.video_info.video_com_num}</span>)</h2>
        </div>

        <div id="section_comment"></div>
</div>

<div class="col-md-4">
    <div class="page-header">
        <h2>Watch</h2>
    </div>
    <div class="row">
        <div class="col-md-4 col-sm-4">
            {if $view.video_prev == 0}
            <div class="preview thumbnail">
                <img src="{$img_css_url}/images/no_prev.gif" class="img-responsive" width="100% "alt="no prev">
                <div>
                    <small><span class="glyphicon glyphicon-step-backward"></span> Prev</small>
                </div>
            </div>

        {else}
        <div class="preview thumbnail">
            <a href="{$base_url}/view/{$view.video_prev.video_id}/{$view.video_prev.video_seo_name}/">
            <img class="img-responsive" src="{$view.video_prev.video_thumb_url}/thumb/{$view.video_prev.video_folder}1_{$view.video_prev.video_id}.jpg" alt="Prev" width="100%">
            </a>
                 <div>
                    <a href="{$base_url}/view/{$view.video_prev.video_id}/{$view.video_prev.video_seo_name}/">
                    <small><span class="glyphicon glyphicon-step-backward"></span> Prev</small>
                    </a>
                </div>
            </div>
        {/if}
        </div>

        <div class="col-md-4 col-sm-4">
            <div class="preview thumbnail">
                <img class="img-responsive" src="{$view.video_info.video_thumb_url}/thumb/{$view.video_info.video_folder}1_{$smarty.request.id}.jpg" alt="now playing">

                <div class="text-center">
                    <small><span class="glyphicon glyphicon-play"></span> Now Playing</small>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-sm-4">
            {if $view.video_next == 0}
            <div class="preview thumbnail">
                <img src="{$img_css_url}/images/no_next.gif" class="img-responsive" width="100%" alt="no next">

                <div class="text-right">
                <small>Next <span class="glyphicon glyphicon-step-forward"></span></small>
                </div>
            </div>

        {else}

            <div class="preview thumbnail">
            <a href="{$base_url}/view/{$view.video_next.video_id}/{$view.video_next.video_seo_name}/">
            <img class="img-responsive" src="{$view.video_next.video_thumb_url}/thumb/{$view.video_next.video_folder}1_{$view.video_next.video_id}.jpg" width="100%" alt="related videos">
            </a>

                <div class="text-right">
                <a href="{$base_url}/view/{$view.video_next.video_id}/{$view.video_next.video_seo_name}/">
                <small>Next <span class="glyphicon glyphicon-step-forward"></span></small>
                </a>
                </div>
            </div>
        {/if}
        </div>
    </div>


    <div class="section bg2">
        {insert name=advertise adv_name='video_right_single'}
    </div>
    <div class="clearfix"></div>

    <!-- user videos -->

    <h3>
        <a href="javascript:void(0);" class="btn btn-default btn-block" onclick="show_user_videos('{$view.video_info.video_user_id}');">
            More from: {$view.user_info.user_name} <span class="caret"></span>
        </a>
    </h3>
    <div id="show_user_videos" style="display: none;"></div>

    <!-- end user videos -->

    <div class="page-header">
        <h2>Related Videos</h2>
    </div>

    {section name=i loop=$view.related_videos}
    <div class="row">
        <div class="col-md-4 col-sm-6">
                    <div class="preview">
                        <a href="{$base_url}/view/{$view.related_videos[i].video_id}/{$view.related_videos[i].video_seo_name}/">
                            <img class="img-responsive" width="100%" src="{$view.related_videos[i].video_thumb_url}/thumb/{$view.related_videos[i].video_folder}1_{$view.related_videos[i].video_id}.jpg" alt="{$view.related_videos[i].video_title}">
                        </a>
                        <span class="badge video-time">{$view.related_videos[i].video_length}</span>
                    </div>
        </div>
        <div class="col-md-8 col-sm-6">
                <a href="{$base_url}/view/{$view.related_videos[i].video_id}/{$view.related_videos[i].video_seo_name}/" target="_parent">
                   <strong>{$view.related_videos[i].video_title|truncate: 50}</strong>
                </a>
            <br>
            <span class="text-muted small">
               {insert name=id_to_name assign=uname un=$view.related_videos[i].video_user_id}
                <span class="glyphicon glyphicon-user"></span> by <strong><a href="{$base_url}/{$uname}" target="_parent">{$uname}</a></strong>
            <br>
                <span class="glyphicon glyphicon-eye-open"></span> Views: <strong>{$view.related_videos[i].video_view_number}</strong> |
               <span class="glyphicon glyphicon-comment"></span> Comments: <strong>{$view.related_videos[i].video_com_num}</strong>
            </span>
        </div>
    </div>
    <hr>
    {/section}

</div> <!-- video-sidebar -->
