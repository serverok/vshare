<?php
/******************************************************************************
 *
 * COMPANY: BuyScripts.in
 * PROJECT: vShare Youtube Clone
 * VERSION: [VSHARE_VERSION]
 * LISENSE: http://buyscripts.in/vshare-license.html
 * WEBSITE: http://buyscripts.in/youtube_clone.html
 *
 * This program is a commercial software and any kind of using it must agree
 * to vShare license.
 *
 ******************************************************************************/

require 'include/config.php';
require 'include/class.video.php';
require 'include/class.tags.php';

$video_id = $_GET['id'];

if (! is_numeric($video_id))
{
    redirect(VSHARE_URL);
}

$video_info = Video::get_video_info($video_id);

if ($video_info == 0 || $video_info['video_user_id'] == 0)
{
    set_message($lang['video_not_found'], 'error');
    $redirect_url = VSHARE_URL . '/';
    redirect($redirect_url);
}
else
{
    $redirect_url = VSHARE_URL . '/view/' . $video_info['video_id'] . '/' . $video_info['video_seo_name'] . '/';
    db_close();
    redirect($redirect_url);
}
