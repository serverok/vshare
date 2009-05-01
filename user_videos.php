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
require 'include/language/' . LANG . '/lang_user_videos.php';
require 'include/class.ftp.php';
require 'include/class.video.php';

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

if ($page < 1)
{
    $page = 1;
}

$type = isset($_GET['type']) ? $_GET['type'] : 'public';

$allowed_types = array(
    'public',
    'private'
);

if (! in_array($type, $allowed_types))
{
    $type = 'public';
}

$user_name = isset($_GET['user_name']) ? trim($_GET['user_name']) : '';

if ($user_name == '')
{
    set_message($lang['user_not_found'], 'error');
    $redirect_url = VSHARE_URL . '/index.php';
}

$sql = "SELECT * FROM `users` WHERE
       `user_name`='" . mysql_clean($user_name) . "'";
$result = mysql_query($sql) or mysql_die($sql);

if (mysql_num_rows($result) != 1)
{
    set_message($lang['user_not_found'], 'error');
    $redirect_url = VSHARE_URL . '/index.php';
    redirect($redirect_url);
}

$user_info = mysql_fetch_assoc($result);

if (isset($_POST['remove_video']) && is_numeric($_POST['VID']))
{
    
    $sql = "SELECT * FROM `videos` WHERE
           `video_id`='" . (int) $_POST['VID'] . "' AND
           `video_user_id`='" . (int) $_SESSION['UID'] . "'";
    $result = mysql_query($sql) or mysql_die($sql);
    $total = mysql_num_rows($result);
    
    if ($total == 1)
    {
        $msg = Video::delete($_POST['VID'], $_SESSION['UID'], 0);
        set_message($lang['video_deleted'], 'success');
        $redirect_url = VSHARE_URL . '/' . $_SESSION['USERNAME'] . '/public/';
        redirect($redirect_url);
    }
}

$show_video = 0;

if ($type == 'private')
{
    
    if (isset($_SESSION['USERNAME']))
    {
        
        if ($user_name == $_SESSION['USERNAME'])
        {
            $show_video = 1;
        }
        else
        {
            $sql = "SELECT COUNT(*) AS `friend_status` FROM `friends` WHERE
                   `friend_user_id`='" . (int) $_SESSION['UID'] . "' AND
                   `friend_name`='" . mysql_clean($user_name) . "' AND
                   `friend_status`='Confirmed'";
            $result = mysql_query($sql) or mysql_die($sql);
            $status = mysql_fetch_array($result);
            $is_friend = $status['friend_status'];
            if ($is_friend < 1)
            {
                $msg = $lang['friends_only'];
            }
            else
            {
                $show_video = 1;
            }
        }
    }
    else
    {
        $msg = $lang['friends_only'];
    }
}
else
{
    $show_video = 1;
}

if ($show_video == 1)
{
    
    $sql = "SELECT COUNT(*) AS `total` FROM `videos` WHERE
           `video_user_id`='" . (int) $user_info['user_id'] . "' AND
           `video_type`='" . mysql_clean($type) . "' AND
           `video_active`='1' AND
           `video_approve`='1'";
    $result = mysql_query($sql) or mysql_die($sql);
    $tmp = mysql_fetch_assoc($result);
    $total = $tmp['total'];
    $smarty->assign('total', $total);
    
    $start_from = ($page - 1) * $config['items_per_page'];
    
    $sql = "SELECT * FROM `videos` WHERE
           `video_user_id`='" . (int) $user_info['user_id'] . "' AND
           `video_type`='" . mysql_clean($type) . "' AND
           `video_active`='1' AND
           `video_approve`='1'
            ORDER BY `video_id` DESC
            LIMIT $start_from, $config[items_per_page]";
    $result = mysql_query($sql) or mysql_die($sql);
    $video_keywords_all = '';
    
    while ($video = mysql_fetch_assoc($result))
    {
        $video['video_thumb_url'] = $servers[$video['video_thumb_server_id']];
        $video['video_keywords_array'] = split(' ',$video['video_keywords']);
        $video_keywords_all .= $video['video_keywords'] . ' ';
        $videos[] = $video;
    }
    
    $view = array();
    $video_keywords_array_all = split(' ',$video_keywords_all);
    $view['video_keywords_array_all'] = array_remove_duplicate($video_keywords_array_all);
        
    if (isset($videos))
    {
        $view['videos'] = $videos;
    }
    
    $start_num = $start_from + 1;
    $end_num = $start_from + mysql_num_rows($result);
    $smarty->assign('start_num', $start_num);
    $smarty->assign('end_num', $end_num);
    
    $page_links = paginate($total, $config['items_per_page'], '.', '', $page);
    $smarty->assign('page_links', $page_links);
    $smarty->assign('view', $view);
}

$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->assign('page', $page);
$smarty->assign('type', $type);
$smarty->assign('user_info', $user_info);
$smarty->assign('sub_menu', 'menu_user.tpl');
$smarty->display('header.tpl');

if ($show_video == 1)
{
    $smarty->display('user_videos.tpl');
}
$smarty->display('footer.tpl');
db_close();
