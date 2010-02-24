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

User::is_logged_in();

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

if ($page < 1)
{
    $page = 1;
}

$sql = "SELECT `friend_friend_id` FROM `friends` WHERE
       `friend_user_id`='" . (int) $_SESSION['UID'] . "' AND
       `friend_status`='Confirmed'";
$result = mysql_query($sql) or mysql_die($sql);

if (mysql_num_rows($result) > 0)
{
    while ($friend = mysql_fetch_assoc($result))
    {
        $friends[] = $friend['friend_friend_id'];
    }
    
    $my_friends = implode(',', $friends);
    
    if (isset($_REQUEST['type']) && $_REQUEST['type'] != "private")
    {
        $_REQUEST['type'] = 'public';
    }
    
    $sql = "SELECT count(*) AS `total` FROM `videos` WHERE
           `video_user_id` IN (" . mysql_clean($my_friends) . ")";
    $result = mysql_query($sql) or mysql_die($sql);
    $tmp = mysql_fetch_assoc($result);
    $total = $tmp['total'];
    
    $start_from = ($page - 1) * $config['items_per_page'];
    
    $page_links = paginate($total, $config['items_per_page'], '.', '', $page);
    
    $sql = "SELECT * FROM `videos` WHERE
           `video_user_id` IN (" . mysql_clean($my_friends) . ")
            ORDER BY `video_add_time` DESC
            LIMIT $start_from, $config[items_per_page]";
    $result = mysql_query($sql) or mysql_die($sql);
    $video_keywords_all = '';
    
    while ($videoRow = mysql_fetch_assoc($result))
    {
        $videoRow['video_thumb_url'] = $servers[$videoRow['video_thumb_server_id']];
        $videoRow['video_keywords_array'] = explode(' ', $videoRow['video_keywords']);
        $video_keywords_all .= $videoRow['video_keywords'] . ' ';
        $videoRows[] = $videoRow;
    }
    
    $view = array();
    $video_keywords_array_all = explode(' ', $video_keywords_all);
    $view['video_keywords_array_all'] = array_remove_duplicate($video_keywords_array_all);
    
    $start_num = $start_from + 1;
    $end_num = $start_from + mysql_num_rows($result);
    $smarty->assign('view', $view);
    $smarty->assign('start_num', $start_num);
    $smarty->assign('end_num', $end_num);
    $smarty->assign('total', $total);
    $smarty->assign('page_links', $page_links);
    $smarty->assign('videoRows', $videoRows);
    $smarty->assign('page', $page);
}

$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->assign('sub_menu', 'menu_friends.tpl');
$smarty->display('header.tpl');
$smarty->display('user_friends_videos.tpl');
$smarty->display('footer.tpl');
db_close();
