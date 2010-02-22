<?php
/******************************************************************************
 *
 * COMPANY: BuyScripts.in
 * PROJECT: vShare Youtube Clone
 * VERSION: 2.8
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
$friends = array();
$friend_videos = array();

if ($page < 1)
{
    $page = 1;
}

$sql = "SELECT `friend_friend_id` FROM `friends` WHERE
       `friend_user_id`='" . (int) $_SESSION['UID'] . "' AND
       `friend_status`='Confirmed'";
$result = mysql_query($sql) or mysql_die();

while ($friend = mysql_fetch_assoc($result))
{
    $friends[] = $friend['friend_friend_id'];
}

$num_friends = count($friends);

if ($num_friends > 0)
{
    
    if ($friends[0] != '')
    {
        $my_friends = implode(',', $friends);
    }
    
    $sql = "SELECT count(*) AS `total` FROM
           `videos` AS v,
           `favourite` AS f WHERE
            f.favourite_user_id in (" . mysql_clean($my_friends) . ") AND
            f.favourite_video_id=v.video_id";
    $result = mysql_query($sql) or mysql_die();
    $tmp_result = mysql_fetch_assoc($result);
    $total = $tmp_result['total'];
    
    $start_from = ($page - 1) * $config['items_per_page'];
    
    if ($my_friends != '')
    {
        $sql = "SELECT * FROM
               `videos` AS v,
               `favourite` AS f WHERE
                f.favourite_user_id in (" . mysql_clean($my_friends) . ") AND
                f.favourite_video_id=v.video_id
                GROUP BY f.favourite_video_id
                ORDER BY v.video_add_time DESC
                LIMIT $start_from, $config[items_per_page]";
        $result = mysql_query($sql) or mysql_die();
        $num_result = mysql_num_rows($result);
        
        if ($num_result > 0)
        {
            while ($friend = mysql_fetch_assoc($result))
            {
                $friend['video_thumb_url'] = $servers[$friend['video_thumb_server_id']];
                $friend['video_keywords_array'] = preg_split('/\s+/', $friend['video_keywords']);
                $friend_videos[] = $friend;
                $favorite_video_id[] = $friend['video_id'];
            }
        }
        $start_num = $start_from + 1;
        $end_num = $start_from + $num_result;
    }
    
    $page_links = paginate($total, $config['items_per_page'], '.', '', $page);
    $smarty->assign('page_links', $page_links);
    
    /*
     * find favorited user name
     */
    
    $favorited_by = array();
    
    for ($i = 0; $i < count($favorite_video_id); $i ++)
    {
        $sql = "SELECT f.*,u.user_name FROM
               `favourite` AS f,
               `users` AS u WHERE
                f.favourite_video_id=" . (int) $favorite_video_id[$i] . " AND
                f.favourite_user_id=u.user_id";
        $result = mysql_query($sql) or mysql_die($sql);
        
        while ($tmp = mysql_fetch_assoc($result))
        {
            if (array_key_exists($tmp['favourite_video_id'], $favorited_by))
            {
                $favorited_by[$tmp['favourite_video_id']] .= ' <a href=' . VSHARE_URL . '/' . $tmp['user_name'] . '>' . $tmp['user_name'] . '</a>';
            }
            else
            {
                $favorited_by[$tmp['favourite_video_id']] = '<a href=' . VSHARE_URL . '/' . $tmp['user_name'] . '>' . $tmp['user_name'] . '</a>';
            }
        
        }
    }
    
    $smarty->assign('favorited_by', $favorited_by);
    
    $_REQUEST['UID'] = isset($_REQUEST['UID']) ? $_REQUEST['UID'] : '';
    $_REQUEST['type'] = isset($_REQUEST['type']) ? $_REQUEST['type'] : '';
}

$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->assign('page', $page);

if (count($friend_videos) > 0)
{
    $smarty->assign('start_num', $start_num);
    $smarty->assign('end_num', $end_num);
    $smarty->assign('total', $total);
    $smarty->assign('answers', $friend_videos);
}

$smarty->assign('sub_menu', 'menu_friends.tpl');
$smarty->display('header.tpl');
$smarty->display('user_friends_favourites.tpl');
$smarty->display('footer.tpl');
db_close();
