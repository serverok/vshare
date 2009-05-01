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

$page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;

if ($page < 1)
{
    $page = 1;
}

$view_type = isset($_GET['viewtype']) ? $_GET['viewtype'] : 'basic';

if ($view_type != 'basic')
{
    $view_type = 'detailed';
}

$smarty->assign('viewtype', $view_type);

$category = $_GET['category'];

$allowed_types = array(
    'random',
    'recent',
    'viewed',
    'discussed',
    'favorites',
    'rated',
    'featured'
);

if (! in_array($category, $allowed_types))
{
    $category = 'recent';
}

if (isset($_GET['chid']))
{
    $channel_sql = "AND `video_channels` LIKE '%|" . (int) $_GET['chid'] . "|%'";
    $sql = "SELECT * FROM `channels` WHERE
           `channel_id`='" . (int) $_GET['chid'] . "'";
    $result = mysql_query($sql) or mysql_die($sql);
    $tmp = mysql_fetch_assoc($result);
    $smarty->assign('channel_name', $tmp['channel_name']);
}
else
{
    $channel_sql = '';
}

if ($category == 'featured')
{
    $sql = "SELECT count(*) AS `total` FROM `videos` WHERE
           `video_type`='public' AND
           `video_featured`='yes' AND
           `video_active`='1' AND
           `video_approve`='1'
            $channel_sql";
}
else
{
    $sql = "SELECT count(*) AS `total` FROM `videos` WHERE
           `video_type`='public' AND
           `video_active`='1' AND
           `video_approve`='1'
            $channel_sql";
}

$result = mysql_query($sql) or mysql_die($sql);
$video_info = mysql_fetch_assoc($result);
$total = $video_info['total'];

$start_from = ($page - 1) * $config['num_watch_videos'];

if ($category == 'recent')
{
    $html_title = 'Most Recent Videos';
    $sql = "SELECT * FROM `videos` WHERE
           `video_type`='public' AND
           `video_active`='1' AND
           `video_approve`='1'
            $channel_sql
            ORDER BY `video_add_time` DESC
            LIMIT $start_from, $config[num_watch_videos]";
}
else if ($category == 'viewed')
{
    $html_title = 'Most Viewed Videos';
    $sql = "SELECT * FROM `videos` WHERE
           `video_type`='public' AND
           `video_active`='1' AND
           `video_approve`='1'
            $channel_sql
            ORDER BY `video_view_number` DESC
            LIMIT $start_from, $config[num_watch_videos]";
}
else if ($category == 'discussed')
{
    $html_title = 'Most Discussed Videos';
    $sql = "SELECT * FROM `videos` WHERE
           `video_type`='public' AND
           `video_active`='1' AND
           `video_approve`='1'
            $channel_sql
            ORDER BY `video_com_num` DESC
            LIMIT $start_from, $config[num_watch_videos]";
}
else if ($category == 'favorites')
{
    $html_title = 'Top Favorites Videos';
    $sql = "SELECT * FROM `videos` WHERE
           `video_type`='public' AND
           `video_active`='1' AND
           `video_approve`='1'
            $channel_sql
            ORDER BY `video_fav_num` DESC
            LIMIT $start_from,$config[num_watch_videos]";
}
else if ($category == 'rated')
{
    $html_title = 'Top Rated Videos';
    $sql = "SELECT * FROM `videos` WHERE
           `video_type`='public' AND
           `video_active`='1' AND
           `video_approve`='1'
            $channel_sql
            ORDER BY (video_rate/video_rated_by) DESC, video_rated_by DESC
            LIMIT $start_from, $config[num_watch_videos]";
}
else if ($category == 'featured')
{
    $html_title = 'Featured Videos';
    $sql = "SELECT * FROM `videos` WHERE
           `video_type`='public' AND
           `video_active`='1' AND
           `video_approve`='1'
            $channel_sql AND
           `video_featured`='yes'
            ORDER BY `video_add_time` DESC
            LIMIT $start_from, $config[num_watch_videos]";
}
else if ($category == 'random')
{
    $html_title = 'Random Videos';
    $sql = "SELECT * FROM `videos` WHERE
           `video_type`='public' AND
           `video_active`='1' AND
           `video_approve`='1'
            $channel_sql
            ORDER BY rand()
            LIMIT $start_from, $config[num_watch_videos]";
}

$result = mysql_query($sql) or mysql_die($sql);
$video_count = mysql_num_rows($result);

while ($video = mysql_fetch_assoc($result))
{
    $video['video_thumb_url'] = $servers[$video['video_thumb_server_id']];
    $videos[] = $video;
}

$start_num = $start_from + 1;
$end_num = $start_from + $video_count;

$page_links = paginate($total, $config['num_watch_videos'], '.', '', $page);

$smarty->assign('html_title', $html_title);
$smarty->assign('html_keywords', $html_title);
$smarty->assign('html_description', $html_title);
$smarty->assign('type', $category);
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->assign('page', $page);
$smarty->assign('start_num', $start_num);
$smarty->assign('end_num', $end_num);
$smarty->assign('total', $total);
$smarty->assign('videos', $videos);
$smarty->assign('page_links', $page_links);
$smarty->assign('sub_menu', 'menu_watch.tpl');
$smarty->display('header.tpl');

$smarty->display('video.tpl');
$smarty->display('footer.tpl');
db_close();
