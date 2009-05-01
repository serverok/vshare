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
require 'include/class.cache.php';

Cache::init();

$mydate = date('Y-m-d');

$sql = "SELECT * FROM `poll_question` WHERE
       `start_date`<='$mydate' AND
       `end_date`>='$mydate'
        ORDER BY rand()
        LIMIT 1";
$result = mysql_query($sql) or mysql_die($sql);

if (mysql_num_rows($result) > 0)
{
    $tmp = mysql_fetch_assoc($result);
    $poll_answer = explode("|", $tmp['poll_answer']);
    $smarty->assign('poll_id', $tmp['poll_id']);
    $smarty->assign('poll_question', $tmp['poll_qty']);
    $smarty->assign('list', $poll_answer);
}

$cache_id = 'home_page';
$view = Cache::load($cache_id);

if (! $view)
{
    $view = array();
    
    # featured videos
    

    $sql = "SELECT * FROM `videos` WHERE
           `video_type`='public' AND
           `video_active`='1' AND
           `video_approve`='1' AND
           `video_featured`='yes'
            ORDER BY `video_add_time` DESC";
    $result = mysql_query($sql) or mysql_die($sql);
    
    if (mysql_num_rows($result) < 1)
    {
        $sql = "SELECT * FROM `videos` WHERE
               `video_type`='public' AND
               `video_active`='1' AND
               `video_approve`='1'
                LIMIT 4";
        $result = mysql_query($sql) or mysql_die($sql);
    }
    
    $featured_videos = array();
    
    while ($featured_video = mysql_fetch_assoc($result))
    {
        $featured_video['video_thumb_url'] = $servers[$featured_video['video_thumb_server_id']];
        $featured_video['video_keywords_array'] = split(' ', $featured_video['video_keywords']);
        $featured_videos[] = $featured_video;
    }
    
    if (mysql_num_rows($result) > 1)
    {
        $smarty->assign('featured_videos', $featured_videos);
        $view['featured_video_block'] = $smarty->fetch('index_featured_videos.tpl');
    }
    else
    {
        $view['featured_video_block'] = '';
    }
    
    # recent videos
    

    $sql = "SELECT * FROM `videos` WHERE
           `video_view_time`<>'0000-00-00 00:00:00' AND
           `video_type`='public' AND
           `video_active`='1' AND
           `video_approve`='1'
            ORDER BY `video_view_time` DESC
            LIMIT 0, $config[recently_viewed_video]";
    $result = mysql_query($sql) or mysql_die($sql);
    
    $recent_videos = array();
    
    while ($recent_video = mysql_fetch_assoc($result))
    {
        $recent_video['video_thumb_url'] = $servers[$recent_video['video_thumb_server_id']];
        $recent_videos[] = $recent_video;
    }
    
    $view['recent_videos'] = $recent_videos;
    $view['recent_total'] = mysql_num_rows($result);
    
    # new videos
    

    $sql = "SELECT * FROM `videos` WHERE
           `video_active`='1' AND
           `video_approve`='1' AND
           `video_type`='public'
            ORDER BY `video_id` DESC
            LIMIT $config[num_new_videos]";
    $result = mysql_query($sql) or mysql_die($sql);
    
    $new_videos = array();
    
    while ($new_video = mysql_fetch_assoc($result))
    {
        $new_video['video_thumb_url'] = $servers[$new_video['video_thumb_server_id']];
        $new_videos[] = $new_video;
    }

    $view['home_tags'] = insert_tags();
    $view['new_videos'] = $new_videos;
    $view['new_video_total'] = mysql_num_rows($result);
    $view['html_extra'] = $smarty->fetch('index_js.tpl');
    Cache::save($cache_id, $view);
}

$smarty->assign('view', $view);
$smarty->assign('html_extra', $view['html_extra']);
$smarty->assign('num_last_users_online', get_config('num_last_users_online'));
$smarty->assign('home_num_tags', get_config('home_num_tags'));
$smarty->assign('msg', $msg);
$smarty->assign('err', $err);
$smarty->assign('sub_menu', 'menu_home.tpl');
$smarty->display('header.tpl');
$smarty->display('index.tpl');
$smarty->display('footer.tpl');
db_close();
