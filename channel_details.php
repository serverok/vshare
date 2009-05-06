<?php
/******************************************************************************
 *
 *   COMPANY: BuyScripts.in
 *   PROJECT: vShare Youtube Clone
 *   VERSION: 2.7
 *   LISENSE: http://buyscripts.in/vshare-license.html
 *   WEBSITE: http://buyscripts.in/youtube_clone.html
 *
 *   This program is a commercial software and any kind of using it must agree 
 *   to vShare license.
 *
 ******************************************************************************/

require 'include/config.php';
require 'HTML/TagCloud.php';

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
           `video_active`='1'
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
           `video_active`='1'
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
    
    $sql = "SELECT t.* FROM
           `tag_video` AS tv,
           `tags` AS t WHERE
            tv.tag_id=t.id AND
            t.tag_count > 0 AND
            tv.chid LIKE '%|" . (int) $_GET['id'] . "|%' AND
            t.active=1
            ORDER BY t.tag_count DESC";
    $result = mysql_query($sql) or mysql_die($sql);
    
    if (mysql_num_rows($result) > 0)
    {
        $tags = array();
        $i = 0;
        $tagcloud = new HTML_TagCloud();
        while ($tag = mysql_fetch_assoc($result))
        {
            if (! in_array($tag['tag'], $tags))
            {
                $tags[] = $tag['tag'];
                $tag_url = VSHARE_URL . '/tag/' . strtolower($tag['tag']) . '/';
                $tagcloud->addElement($tag['tag'], $tag_url, $tag['tag_count'], $tag['used_on']);
                $i ++;
            }
            
            if ($i == 100)
            {
                break;
            }
        }
        $smarty->assign('tags', $tagcloud->buildHTML());
    }
    $smarty->assign('channel', $channel);
}

$smarty->assign('html_title', $channel['channel_name']);
$smarty->assign('html_keywords', $channel['channel_name']);
$smarty->assign('html_description', $channel['channel_name']);
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('header.tpl');
$smarty->display('channel_details.tpl');
$smarty->display('footer.tpl');
db_close();
