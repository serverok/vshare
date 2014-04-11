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
require 'include/language/' . LANG . '/lang_playlist.php';

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

if (isset($_POST['create_playlist']) && isset($_SESSION['UID']))
{
    $playlist_name = trim($_POST['playlist_name']);
    
    if (! empty($playlist_name))
    {
       $sql = "SELECT * FROM `playlists` WHERE
              `playlist_user_id`='" . (int) $_SESSION['UID'] . "' AND
              `playlist_name`='" . mysql_clean($playlist_name) . "'";
       $result = mysql_query($sql) or mysql_die($sql);
       
       if (mysql_num_rows($result) < 1)
       {
           $sql = "INSERT INTO `playlists` SET
                  `playlist_user_id`='" . (int) $_SESSION['UID'] . "',
                  `playlist_name`='" . mysql_clean($playlist_name) . "',
                  `playlist_add_date`='" . (int) time() . "'";
           mysql_query($sql) or mysql_die($sql);
       }
       else
       {
           $err = $lang['playlist_duplicate'];
       }
       
       $_GET['playlist_id'] = $playlist_name;
    }
}

$html_playlist_name = '';

$sql = "SELECT * FROM `playlists` WHERE
       `playlist_user_id`='" . (int) $user_info['user_id'] . "'
        ORDER BY `playlist_id` ASC";
$result = mysql_query($sql) or mysql_die($sql);

if (mysql_num_rows($result) > 0)
{
    $playlists = mysql_fetch_all($result);
    $smarty->assign('playlists', $playlists);
    
    $_GET['playlist_id'] = isset($_GET['playlist_id']) ? trim($_GET['playlist_id']) : $playlists[0]['playlist_name'];
    
    $sql = "SELECT * FROM `playlists` WHERE
           `playlist_user_id`='" . (int) $user_info['user_id'] . "' AND
           `playlist_name`='" . mysql_clean($_GET['playlist_id']) . "'";
    $result = mysql_query($sql) or mysql_die($sql);
    
    if (mysql_num_rows($result) > 0)
    {
        $playlist_info = mysql_fetch_assoc($result);
        $smarty->assign('playlist_info', $playlist_info);
        $html_playlist_name = $playlist_info['playlist_name'] . ' - ';
        
        $sql = "SELECT count(*) AS `total` FROM
               `videos` AS `v`, `playlists` AS `pl`, `playlists_videos` AS `pv` WHERE
                pl.playlist_user_id='" . (int) $user_info['user_id'] . "' AND
                pl.playlist_id='" . (int) $playlist_info['playlist_id'] . "' AND
                pl.playlist_id=pv.playlists_videos_playlist_id AND
                pv.playlists_videos_video_id=v.video_id";
        $result = mysql_query($sql) or mysql_die($sql);
        $tmp = mysql_fetch_assoc($result);
        $total = $tmp['total'];
        
        $start_from = ($page - 1) * $config['items_per_page'];
        
        $sql = "SELECT * FROM
               `videos` AS `v`, `playlists` AS `pl`, `playlists_videos` AS `pv` WHERE
                pl.playlist_user_id='" . (int) $user_info['user_id'] . "' AND
                pl.playlist_id='" . (int) $playlist_info['playlist_id'] . "' AND
                pl.playlist_id=pv.playlists_videos_playlist_id AND
                pv.playlists_videos_video_id=v.video_id
                ORDER BY v.video_add_time DESC
                LIMIT $start_from, $config[items_per_page]";
        $result = mysql_query($sql) or mysql_die($sql);
        $results_on_this_page = mysql_num_rows($result);
        $video_keywords_all = '';
        $video_info = array();
        
        while ($video = mysql_fetch_assoc($result))
        {
            $video['video_thumb_url'] = $servers[$video['video_thumb_server_id']];
            $video['video_keywords_array'] = preg_split('[ ]', $video['video_keywords']);
            $video_keywords_all .= $video['video_keywords'] . ' ';
            $video_info[] = $video;
        }
        
        $start_num = $start_from + 1;
        $end_num = $start_from + $results_on_this_page;
        $page_links = paginate($total, $config['items_per_page'], '.', '', $page);
        
        $smarty->assign('start_num', $start_num);
        $smarty->assign('end_num', $end_num);
        $smarty->assign('page_links', $page_links);
        $smarty->assign('total', $total);
        $smarty->assign('videos', $video_info);
    }
}

$html_title = "$html_playlist_name $user_info[user_name]'s playlists - page $page";
$smarty->assign(array(
    'html_title' => $html_title,
    'html_description' => $html_title,
    'html_keywords' => $html_title
));
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->assign('page', $page);
$smarty->assign('user_info', $user_info);
$smarty->assign('sub_menu', 'menu_user.tpl');
$smarty->display('header.tpl');
$smarty->display('user_playlist.tpl');
$smarty->display('footer.tpl');
db_close();
