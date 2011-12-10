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
require 'include/functions_video_rating.php';
require 'include/class.video_player.php';
require 'include/class.video.php';
require 'include/class.tags.php';
require 'include/class.cache.php';
require 'include/language/' . LANG . '/lang_view_video.php';

$video_id = $_GET['id'];

Cache::init();

if (! is_numeric($video_id))
{
    redirect(VSHARE_URL);
}

$video = new Video();
$video_info = $video->get_video_info($video_id);

if ($video_info == 0 || $video_info['video_user_id'] == 0)
{
    set_message($lang['video_not_found'], 'error');
    $redirect_url = VSHARE_URL . '/';
    redirect($redirect_url);
}
else
{
    $video_info['video_thumb_url'] = $servers[$video_info['video_thumb_server_id']];
}

if ($video_info['video_adult'])
{
	if (get_family_filter())
	{
		$redirect_url = VSHARE_URL . '/family_filter/';
		redirect($redirect_url);
	}
}


if ($config['guest_limit'] > 36000)
{
    $config['guest_limit'] = 0;
}

if (! isset($_SESSION['UID']) && $err == '' && $config['guest_limit'] != 0)
{
    if (isset($_COOKIE['video_watch_duration']))
    {
        $video_watch_duration = $_COOKIE['video_watch_duration'] + $video_info['video_duration'];
    }
    else
    {
        $video_watch_duration = $video_info['video_duration'];
    }
    
    /*
     * 43200 for 12 hours 60 * 60 * 12
     */
    setcookie('video_watch_duration', $video_watch_duration, time() + 43200);
    
    if ($video_watch_duration > $config['guest_limit'])
    {
        $next = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
        $_SESSION['REDIRECT'] = $next;
        redirect(VSHARE_URL . '/signup/');
    }
}

if ($err == '')
{
    if ($video_info['video_type'] == 'private')
    {
        if (isset($_SESSION['UID']) && is_numeric($_SESSION['UID']))
        {
            if ($video_info['video_user_id'] == $_SESSION['UID'])
            {
                $show_video = 1;
            }
            else
            {
                $sql = "SELECT count(*) AS `total` FROM `friends` WHERE
                       `friend_user_id`='" . (int) $_SESSION['UID'] . "' AND
                       `friend_friend_id`='" . (int) $video_info['video_user_id'] . "' AND
                       `friend_status`='Confirmed'";
                $result = mysql_query($sql) or mysql_die($sql);
                $tmp = mysql_fetch_assoc($result);
                
                if ($tmp['total'])
                {
                    $show_video = 1;
                }
                else
                {
                    $msg = $lang['friends_only'];
                }
            }
        }
        else
        {
            $show_video = 0;
            
            $_SESSION['REDIRECT'] = VSHARE_URL . '/view/' . $video_info['video_id'] . '/' . $video_info['video_seo_name'] . '/';
            
            if (get_config('signup_enable'))
            {
                $redirect_url = $config['baseurl'] . '/signup/';
            }
            else
            {
                $redirect_url = $config['baseurl'] . '/login/';
            }
            
            redirect($redirect_url);
        }
    }
    else
    {
        $show_video = 1;
    }
}

if (isset($show_video) && $show_video == 1 && $err == '')
{
    
    $sql = "UPDATE `videos` SET
           `video_view_time`='" . mysql_clean($_SERVER['REQUEST_TIME']) . "' WHERE
           `video_id`='" . (int) $video_id . "'";
    mysql_query($sql);
    
    $sql = "UPDATE `videos` SET
           `video_view_number`=`video_view_number`+1 WHERE
           `video_id`='" . (int) $video_id . "'";
    mysql_query($sql);
    
    if (isset($_SESSION['UID']))
    {
        $sql = "UPDATE `users` SET
               `user_watched_video`=`user_watched_video`+1 WHERE
               `user_id`='" . (int) $_SESSION['UID'] . "'";
        mysql_query($sql) or mysql_die($sql);
        
        if ($_SESSION['UID'] != $video_info['video_user_id'])
        {
            $sql = "UPDATE `users` SET
                   `user_video_viewed`=`user_video_viewed`+1 WHERE
                   `user_id`='" . (int) $video_info['video_user_id'] . "'";
            mysql_query($sql) or mysql_die($sql);
        }
    }
    
    $cache_id = 'view_video_' . $video_id;
    $view = Cache::load($cache_id);
    
    if (! $view)
    {
        $view = array();
        $view['video_info'] = $video_info;
        
        $player = new video_player();
        $view['VSHARE_PLAYER'] = $player->get_player_code($video_id);
        
        $tags = explode(' ', $video_info['video_keywords']);
        $view['tags'] = $tags;
        
        # Response Videos Start
        $view['video_responses'] = $video->get_response_videos($video_id, '5');
        
        # Related Videos Start
        
		$related_video_string =  trim($video_info['video_title']) . ' ' . trim($video_info['video_description']) . ' ' . trim($video_info['video_keywords']);
        $related_videos = $video->get_related_videos($video_id, $related_video_string);
        
        $video_this = '';
        
        for ($i = 0; $i < count($related_videos); $i ++)
        {
            if ($related_videos[$i]['video_id'] == $video_id)
            {
                $video_this = $i;
                break;
            }
        }
        
        if ($video_this === '')
        {
            $num_related_videos = count($related_videos);
            if ($num_related_videos > 4)
            {
                $video_this = (int) $num_related_videos / 2;
                $related_videos[$video_this] = $video_info;
            }
            else if ($num_related_videos > 2)
            {
                $video_this = 0;
            }
        }
        
        $view['related_videos'] = $related_videos;
        $video_next = $video_this + 1;
        $video_prev = $video_this - 1;
        
        if (! isset($related_videos[$video_next]))
        {
            $view['video_next'] = 0;
        }
        else
        {
            $view['video_next'] = $related_videos["$video_next"];
        }
        
        if (! isset($related_videos[$video_prev]))
        {
            $view['video_prev'] = 0;
        }
        else
        {
            $view['video_prev'] = $related_videos["$video_prev"];
        }
        
        if (isset($_SESSION['UID']))
        {
            $sql = "SELECT * FROM  `favourite` WHERE
                   `favourite_user_id`=" . (int) $_SESSION['UID'] . " AND
                   `favourite_video_id`=" . (int) $video_id;
            $result = mysql_query($sql) or mysql_die($sql);
            if (mysql_num_rows($result) == 1)
            {
                $smarty->assign('favourite', 1);
            }
            
            if ($config['allow_download'] == 1)
            {
                $sql = "SELECT `pack_id` FROM `subscriber` WHERE
	                   `UID`='" . (int) $_SESSION['UID'] . "'";
                $result = mysql_query($sql) or mysql_die($sql);
                $subscriber_info = mysql_fetch_assoc($result);
                
                $sql = "SELECT `package_allow_download` FROM `packages` WHERE
	                   `package_id`='" . (int) $subscriber_info['pack_id'] . "'";
                $result = mysql_query($sql) or mysql_die($sql);
                $package_info = mysql_fetch_assoc($result);
                $view['package_allow_video_download'] = $package_info['package_allow_download'];
            }
        }
        
        $sql = "SELECT v.* FROM `videos` AS `v`,`video_responses` AS `vr` WHERE
                vr.video_response_video_id='" . (int) $video_id . "' AND
                vr.video_response_to_video_id=v.video_id";
        $result = mysql_query($sql) or mysql_die($sql);
        
        if (mysql_num_rows($result) > 0)
        {
            $owner_video_info = mysql_fetch_assoc($result);
            $view['owner_video_info'] = $owner_video_info;
        }
        
        $sql = "SELECT `user_name`,`user_website` FROM `users` WHERE
               `user_id`='" . (int) $video_info['video_user_id'] . "'";
        $result = mysql_query($sql) or mysql_die($sql);
        $user_info = mysql_fetch_assoc($result);
        $view['user_info'] = $user_info;
        Cache::save($cache_id, $view);
    }
    
    $html_title = htmlspecialchars_uni($video_info['video_title']);
    $html_keywords = htmlspecialchars_uni($video_info['video_keywords']);
    $html_description = htmlspecialchars_uni($video_info['video_description']);
    $html_keywords_array = explode(' ', $html_keywords);
    $html_keywords = implode(', ', $html_keywords_array);
    
    $smarty->assign('html_description', $html_description);
    $smarty->assign('html_title', $html_title);
    $smarty->assign('html_keywords', $html_keywords);
    $smarty->assign('view', $view);
}

$user_id_js = isset($_SESSION['UID']) ? (int) $_SESSION['UID'] : 0;

$html_head_extra = '
<meta name="video_type" content="application/x-shockwave-flash" />
<meta name="video_height" content="360" />
<meta name="video_width" content="640" />
<link rel="image_src" href="' . $video_info['video_thumb_url'] . '/thumb/' . $video_info['video_folder'] . $video_info['video_id'] . '.jpg" type="image/jpeg" />
<link rel="image_src" href="' . $video_info['video_thumb_url'] . '/thumb/' . $video_info['video_folder'] . '1_' . $video_info['video_id'] . '.jpg" type="image/jpeg" />
<link rel="image_src" href="' . $video_info['video_thumb_url'] . '/thumb/' . $video_info['video_folder'] . '2_' . $video_info['video_id'] . '.jpg" type="image/jpeg" />
<link rel="thumbnail" href="' . $video_info['video_thumb_url'] . '/thumb/' . $video_info['video_folder'] . '3_' . $video_info['video_id'] . '.jpg" type="image/jpeg" />
<link rel="video_src" href="' . VSHARE_URL . '/v/' . $video_info['video_id'] . '&hl=en_US&fs=1&"/>
<meta name="video_type" content="application/x-shockwave-flash" />';

$html_extra = '
<script type="text/javascript">
var vid=' . $video_id . ';
var user_id=' . $user_id_js . ';
$(function(){
    show_comments(' . $video_id . ',1);
});
</script>
<script language="JavaScript" type="text/javascript" src="' . VSHARE_URL . '/js/video_feature_request.js"></script>
<script language="JavaScript" type="text/javascript" src="' . VSHARE_URL . '/js/video_inappropriate.js"></script>
<script language="JavaScript" type="text/javascript" src="' . VSHARE_URL . '/js/video_rating.js"></script>
<script language="JavaScript" type="text/javascript" src="' . VSHARE_URL . '/js/video_comments_show.js"></script>
<script language="JavaScript" type="text/javascript" src="' . VSHARE_URL . '/js/video_comment_add.js"></script>
<script language="JavaScript" type="text/javascript" src="' . VSHARE_URL . '/js/video_add_favorite.js"></script>
<script language="JavaScript" type="text/javascript" src="' . VSHARE_URL . '/js/video_comment_delete.js"></script>
<script language="JavaScript" type="text/javascript" src="' . VSHARE_URL . '/js/user_videos.js"></script>
<script language="JavaScript" type="text/javascript" src="' . VSHARE_URL . '/js/playlist.js"></script>
';

$smarty->assign('html_head_extra', $html_head_extra);
$smarty->assign('html_extra', $html_extra);
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->assign('sub_menu', 'menu_watch.tpl');
$smarty->display('header.tpl');
$smarty->display('view_video.tpl');
$smarty->display('footer.tpl');
db_close();
