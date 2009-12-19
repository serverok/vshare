<?php
/******************************************************************************
 *
 *   COMPANY: BuyScripts.in
 *   PROJECT: vShare Youtube Clone
 *   VERSION: 2.8
 *   LISENSE: http://buyscripts.in/vshare-license.html
 *   WEBSITE: http://buyscripts.in/youtube_clone.html
 *
 *   This program is a commercial software and any kind of using it must agree 
 *   to vShare license.
 *
 ******************************************************************************/

require 'include/config.php';

$user_name = isset($_GET['user_name']) ? $_GET['user_name'] : '';
$user_name = trim($user_name);

$page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;

if ($page < 1)
{
    $page = 1;
}

$sql = "SELECT * FROM `users` WHERE
       `user_name`='" . mysql_clean($user_name) . "'";
$result = mysql_query($sql) or mysql_die($sql);

if (mysql_num_rows($result) < 1)
{
    redirect(VSHARE_URL);
}

$user_info = mysql_fetch_assoc($result);

$sql = "SELECT count(*) AS `total` FROM
       `videos` AS `v`,
       `playlists` AS `pl` WHERE
        pl.playlist_user_id='" . (int) $user_info['user_id'] . "' AND
        pl.playlist_video_id=v.video_id";
$result = mysql_query($sql) or mysql_die($sql);
$tmp = mysql_fetch_assoc($result);
$total = $tmp['total'];

$start_from = ($page - 1) * $config['items_per_page'];

$sql = "SELECT * FROM
       `videos` AS `v`,
       `playlists` AS `pl` WHERE
        pl.playlist_user_id='" . (int) $user_info['user_id'] . "' AND
        pl.playlist_video_id=v.video_id
        ORDER BY v.video_add_time DESC
        LIMIT $start_from, $config[items_per_page]";
$result = mysql_query($sql) or mysql_die($sql);
$results_on_this_page = mysql_num_rows($result);
$video_keywords_all = '';
$video_info = array();

while ($video = mysql_fetch_assoc($result))
{
    $video['video_thumb_url'] = $servers[$video['video_thumb_server_id']];
    $video['video_keywords_array'] = split(' ',$video['video_keywords']);
    $video_keywords_all .= $video['video_keywords'] . ' ';
    $video_info[] = $video;
}

$view = array();
$video_keywords_array_all = split(' ',$video_keywords_all);
$view['video_keywords_array_all'] = array_remove_duplicate($video_keywords_array_all);

$start_num = $start_from + 1;
$end_num = $start_from + $results_on_this_page;
$page_links = paginate($total, $config['items_per_page'], '.', '', $page);

$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->assign('page', $page);
$smarty->assign('user_info', $user_info);
$smarty->assign('start_num', $start_num);
$smarty->assign('end_num', $end_num);
$smarty->assign('page_links', $page_links);
$smarty->assign('total', $total);
$smarty->assign('videos', $video_info);
$smarty->assign('view', $view);
$smarty->assign('sub_menu', 'menu_user.tpl');
$smarty->display('header.tpl');
$smarty->display('user_playlist.tpl');
$smarty->display('footer.tpl');
db_close();
