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
require 'include/class.xss.php';
require 'include/language/' . LANG . '/lang_user_favorites.php';

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

if ($page < 1)
{
    $page = 1;
}

$sql = "SELECT * FROM `users` WHERE
       `user_name`='" . mysql_clean($_GET['user_name']) . "'";
$result = mysql_query($sql) or mysql_die($sql);

if (mysql_num_rows($result) != 1)
{
    set_message($lang['user_not_found'], 'error');
    $redirect_url = VSHARE_URL . '/index.php';
    redirect($redirect_url);
}

$user_info = mysql_fetch_assoc($result);
$smarty->assign('user_name', $user_info['user_name']);

if (isset($_POST['removfavour']) && is_numeric($_POST['rvid']))
{
    $sql = "DELETE FROM `favourite` WHERE
           `favourite_user_id`='" . (int) $_SESSION['UID'] . "' AND
           `favourite_video_id`='" . (int) $_POST['rvid'] . "'";
    mysql_query($sql) or mysql_die($sql);
}

$sql = "SELECT count(*) AS `total` FROM
       `videos` AS `v`,
       `favourite` AS `f` WHERE
        f.favourite_user_id='" . (int) $user_info['user_id'] . "' AND
        f.favourite_video_id=v.video_id";
$result = mysql_query($sql) or mysql_die($sql);
$tmp = mysql_fetch_assoc($result);
$total = $tmp['total'];

$start_from = ($page - 1) * $config['items_per_page'];

$sql = "SELECT * FROM
       `videos` AS `v`,
       `favourite` AS `f` WHERE
        f.favourite_user_id='" . (int) $user_info['user_id'] . "' AND
        f.favourite_video_id=v.video_id
        ORDER BY v.video_add_time DESC
        LIMIT $start_from, $config[items_per_page]";
$result = mysql_query($sql) or mysql_die($sql);
$results_on_this_page = mysql_num_rows($result);

$video_keywords_all = '';
$favorite_videos = array();
 
while ($favorite_video = mysql_fetch_assoc($result))
{
    $favorite_video['video_thumb_url'] = $servers[$favorite_video['video_thumb_server_id']];
    $favorite_video['video_keywords_array'] = split(' ',$favorite_video['video_keywords']);
    $video_keywords_all .= $favorite_video['video_keywords'] . ' ';
    $favorite_videos[] = $favorite_video;
    
}

$view = array();
$video_keywords_all = split(' ',$video_keywords_all);
$view['video_keywords_all_array'] = array_remove_duplicate($video_keywords_all);

$start_num = $start_from + 1;
$end_num = $start_from + $results_on_this_page;
$page_links = paginate($total, $config['items_per_page'], '.', '', $page);

$smarty->assign('view', $view);
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->assign('page', $page);
$smarty->assign('start_num', $start_num);
$smarty->assign('end_num', $end_num);
$smarty->assign('page_links', $page_links);
$smarty->assign('total', $total);
$smarty->assign('favVideos', $favorite_videos);
$smarty->assign('user_info', $user_info);
$smarty->assign('sub_menu', 'menu_user.tpl');
$smarty->display('header.tpl');
$smarty->display('user_favorites.tpl');
$smarty->display('footer.tpl');
db_close();
