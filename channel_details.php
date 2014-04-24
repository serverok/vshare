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

if (! is_numeric($_GET['id']) || $_GET['id'] < 1)
{
    $redirect_url = VSHARE_URL . '/index.php';
    redirect($redirect_url);
}

$sql = "SELECT * FROM `channels` WHERE
       `channel_id`='" . (int) $_GET['id'] . "'";
$result = mysql_query($sql) or mysql_die($sql);
$num_rows = mysql_num_rows($result);

if ($num_rows > 0)
{
    $num_channel_videos = get_config('num_channel_video');
    $channel = mysql_fetch_assoc($result);
    $sql = "SELECT count(video_id) AS `total`, `video_user_id` FROM `videos` WHERE
           `video_channels` LIKE '%|" . (int) $_GET['id'] . "|%' AND
           `video_approve`='1' AND
           `video_active`='1' AND
           `video_type`='public' AND
           `video_user_id` > '0'
            GROUP BY `video_user_id`
            ORDER BY `total` DESC
            LIMIT 5";
    $result = mysql_query($sql) or mysql_die($sql);
    $most_active_users = mysql_fetch_all($result);
    $smarty->assign('most_active_users', $most_active_users);

    $sql = "SELECT * FROM `videos` WHERE
           `video_channels` LIKE '%|" . (int) $_GET['id'] . "|%' AND
           `video_approve`='1' AND
           `video_active`='1' AND
           `video_type`='public'
            ORDER BY `video_add_time` DESC
            LIMIT $num_channel_videos";
    $result = mysql_query($sql) or mysql_die($sql);

    $recent_channel_videos = array();

    while ($recent_channel_video = mysql_fetch_assoc($result))
    {
        $recent_channel_video['video_thumb_url'] = $servers[$recent_channel_video['video_thumb_server_id']];
        $recent_channel_videos[] = $recent_channel_video;
    }
    $smarty->assign('recent_channel_videos', $recent_channel_videos);

    # find popular videos on channel


    $sql = "SELECT * FROM `videos` WHERE
           `video_channels` LIKE '%|" . (int) $_GET['id'] . "|%' AND
           `video_approve`='1' AND
           `video_active`='1' AND
           `video_type`='public'
            ORDER BY `video_view_number` DESC
            LIMIT $num_channel_videos";
    $result = mysql_query($sql) or mysql_die($sql);
    $total = mysql_num_rows($result);

    $mostview = array();

    while ($video = mysql_fetch_assoc($result))
    {
        $video['video_thumb_url'] = $servers[$video['video_thumb_server_id']];
        $mostview[] = $video;
    }

    $smarty->assign('mostview', $mostview);
    $smarty->assign('total', $total);
    $smarty->assign('channel', $channel);
}

$smarty->assign('html_title', $channel['channel_name']);
$smarty->assign('html_keywords', $channel['channel_name']);
$smarty->assign('html_description', $channel['channel_description']);
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('header.tpl');
$smarty->display('channel_details.tpl');
$smarty->display('footer.tpl');
db_close();
