<div id="page" class="upload-success">

    {if $video_processed ne 1}
        <h2>Your video was successfully added!</h2>
    {/if}

    {if $video_processed eq 1}

        <h3>
            <a href="{$base_url}/view/{$video_info.video_id}/{$video_info.video_seo_name}/">{$base_url}/view/{$video_info.video_id}/{$video_info.video_seo_name}/</a>
        </h3>

        <p>Want to upload more videos? <a href="{$base_url}/upload/">Click here</a></p>

        <p>Now that your video is uploaded, you can share it with others, embed it into your Web site (and others), and include more details.</p>

        <h3>Share your video (Optional):
            <br>
            <small>Use the share manager application below to easily share your video with friends, family, and other contacts. If that's not your thing, you can copy and paste the video url (permalink) into an e-mail.</small>
        </h3>

        <h3>Video URL (Permalink):
            <br>
            <small>Email or link it!</small>
        </h3>

        <form method="post" action="" name="linkForm">
            <div class="form-group">
                <div class="col-md-8">
                    <input onclick="javascript:document.linkForm.video_link.focus();document.linkForm.video_link.select();" readonly="readonly" value="{$base_url}/view/{$video_info.video_id}/{$video_info.video_seo_name}/" name="video_link" class="form-control">
                </div>
            </div>

            {if $embed_show eq "1" && $video_info.video_vtype == 0}
                <div class="clearfix"></div>
                <h3>Embed your video:
                    <br>
                    <small>Put this video on your Web site!, Copy and paste the code below to embed the video.</small>
                </h3>
                <div class="form-group">
                    <div class="col-md-8">
                        <input name="video_play" value='{if $embed_type eq "0"}<iframe vspace="0" hspace="0" allowtransparency="true" scrolling="no" marginwidth="0" marginheight="0" frameborder="0" style="border:0px;" width="435" height="470" src="{$base_url}/show.php?id={$video_info.video_id}"></iframe>{else}<object width="425" height="350" type="application/x-shockwave-flash" data="{$base_url}/player/player.swf"><param name="movie" value="{$base_url}/player/player.swf" /><param name="flashvars" value="&file={$flv_url}&height=350&image={$video_info.video_thumb_url}/thumb/{$video_info.video_folder}{$video_info.video_id}.jpg&width=425&location={$base_url}/player/player.swf&logo={$img_css_url}/images/watermark.gif&link={$watermark_url}&linktarget=_blank"/></object>{/if}' onclick="javascript:document.linkForm.video_play.focus();document.linkForm.video_play.select();" readonly="readonly" class="form-control">
                    </div>
                </div>
            {/if}
        </form>
        <div class="clearfix">&nbsp;</div>
        <div class="clearfix">&nbsp;</div>
        <p><a href="{$base_url}/friends/recommend/{$video_info.video_id}/">Click here</a> to share this video with your friends.</p>

    {else}
        <p class="text-muted">Your video is currently being processed and will be available to view in a few minutes.</p>
    {/if}

</div>