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
require 'include/language/' . LANG . '/lang_add_video.php';

User::is_logged_in();

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

if ($page < 1)
{
    $page = 1;
}

$group_url = isset($_GET['group_url']) ? trim($_GET['group_url']) : '';

if (empty($group_url))
{
    redirect(VSHARE_URL);
}

$sql = "SELECT * FROM `groups` WHERE
       `group_url`='" . mysql_clean($group_url) . "'";
$result = mysql_query($sql) or mysql_die($sql);

if (mysql_num_rows($result) < 1)
{
    redirect(VSHARE_URL);
}

$group_info = mysql_fetch_assoc($result);

$smarty->assign('group_info', $group_info);

if (isset($_POST['add_video']))
{
    $sql = "SELECT * FROM `group_members` WHERE
           `group_member_group_id`='" . (int) $group_info['group_id'] . "' AND
           `group_member_user_id`='" . (int) $_SESSION['UID'] . "'";
    $result = mysql_query($sql) or mysql_die($sql);
    
    if (mysql_num_rows($result) > 0)
    {
        $approved = 'no';
        
        if ($_SESSION['UID'] == $group_info['group_owner_id'])
        {
            $approved = 'yes';
        }
        
        if ($group_info['group_upload'] == 'immediate')
        {
            $approved = 'yes';
        }
        
        $sql = "INSERT INTO `group_videos` SET
               `group_video_group_id`='" . (int) $group_info['group_id'] . "',
               `group_video_video_id`='" . (int) $_POST['video_id'] . "',
               `group_video_member_id`='" . (int) $_SESSION['UID'] . "',
               `group_video_approved`='" . mysql_clean($approved) . "'";
        mysql_query($sql) or mysql_die($sql);
        
        if ($approved == 'no')
        {
            $msg = $lang['group_video_approve'];
        }
        else
        {
            $msg = $lang['group_video_added'];
        }
        
        set_message($msg, 'success');
        $redirect_url = VSHARE_URL . '/group/' . $group_url . '/add/' . $page;
        redirect($redirect_url);
    
    }
    else
    {
        set_message($lang['group_not_member'], 'error');
        $redirect_url = VSHARE_URL . '/group/' . $group_url . '/add/' . $page;
        redirect($redirect_url);
    }
}

$sql = "SELECT COUNT(*) AS `total` FROM `videos` WHERE
       `video_user_id`='" . (int) $_SESSION['UID'] . "' AND
       `video_approve`='1' AND
       `video_active`='1'";
$result = mysql_query($sql) or mysql_die($sql);
$tmp = mysql_fetch_assoc($result);
$total = $tmp['total'];

$start_from = ($page - 1) * $config['items_per_page'];

$sql = "SELECT * FROM `videos` WHERE
       `video_user_id`=" . (int) $_SESSION['UID'] . " AND
       `video_approve`='1' AND
       `video_active`='1'
        ORDER BY `video_add_time` DESC
        LIMIT $start_from, $config[items_per_page]";
$result = mysql_query($sql) or mysql_die($sql);
$num_result = mysql_num_rows($result);

if ($num_result > 0)
{
    $group_add_video_keywords_all = '';
    
    while ($video_row = mysql_fetch_assoc($result))
    {
        $sql = "SELECT * FROM `group_videos` WHERE
               `group_video_group_id`='" . (int) $group_info['group_id'] . "' AND
               `group_video_video_id`='" . (int) $video_row['video_id'] . "'";
        $tmp = mysql_query($sql) or mysql_die($sql);
        
        if (mysql_num_rows($tmp) < 1)
        {
            $video_row['in_group'] = 0;
        }
        else
        {
            $video_row['in_group'] = 1;
        }
        
        $video_row['video_thumb_url'] = $servers[$video_row['video_thumb_server_id']];
        $video_row['video_keywords_array'] = explode(' ', $video_row['video_keywords']);
        $group_add_video_keywords_all .= $video_row['video_keywords'] . ' ';
        $videos[] = $video_row;
    }
    
    $group_video_keywords_array = explode(' ', $group_add_video_keywords_all);
    $group_video_keywords_array_new = array_remove_duplicate($group_video_keywords_array);
    
    $view = array();
    $view['group_add_video_keywords_array'] = $group_video_keywords_array_new;
    $smarty->assign('view', $view);
}
else
{
    $msg = $lang['no_videos'];
}

$start_num = $start_from + 1;
$end_num = $start_from + $num_result;

$page_links = paginate($total, $config['items_per_page'], '.', '', $page);

$smarty->assign('page', $page);
$smarty->assign('start_num', $start_num);
$smarty->assign('end_num', $end_num);
$smarty->assign('page_links', $page_links);
$smarty->assign('total', $total);

if (isset($videos))
{
    $smarty->assign('videos', $videos);
}

$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->assign('sub_menu', 'menu_add_video.tpl');
$smarty->display('header.tpl');
$smarty->display('group_add_videos.tpl');
$smarty->display('footer.tpl');
db_close();
