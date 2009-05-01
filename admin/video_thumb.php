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

require '../include/config.php';
require '../include/class.video_thumb.php';
require '../include/class.video_duration.php';
require '../include/class.ftp.php';
require '../include/language/' . LANG . '/lang_admin_video_thumb.php';

check_admin_login();

if (is_numeric($_GET['id']))
{
    $sql = "SELECT * FROM `videos` WHERE
           `video_id`='" . (int) $_GET['id'] . "'";
    $result = mysql_query($sql) or mysql_die($sql);
    $video_info = mysql_fetch_assoc($result);
    $video_src = VSHARE_DIR . '/video/' . $video_info['video_name'];
	$log_file_name = 're_create_thumb_' . $video_info['video_id'];
    
    if ($config['debug'])
    {
        $log_text = '<p>$video_src = ' . $video_src . '</p>';
        write_log($log_text, $log_file_name, $config['debug'], 'html');
    }
    
    if (file_exists($video_src) && is_file($video_src))
    {
        if ($config['debug'])
        {
            $log_text = '<p>File found = ' . $video_src . '</p>';
            write_log($log_text, $log_file_name, $config['debug'], 'html');
        }
        
        if ($video_info['video_folder'] != '')
        {
            if (! is_dir(VSHARE_DIR . '/thumb/' . $video_info['video_folder']))
            {
                mkdir(VSHARE_DIR . '/thumb/' . $video_info['video_folder']);
            }
        }
        
        if ($config['debug'])
        {
            $log_text = '<p>thumb_folder = ' . VSHARE_DIR . '/thumb/' . $video_info['video_folder'] . '</p>';
            write_log($log_text, $log_file_name, $config['debug'], 'html');
        }
        
        $t_info = array();
        $t_info['src'] = $video_src;
        $t_info['vid'] = (int) $_GET['id'];
        $t_info['video_folder'] = $video_info['video_folder'];
        $t_info['debug'] = $config['debug'];
        
        $video_duration_cmd = get_config('video_duration_cmd');
        
        if ($video_duration_cmd == 0)
        {
            $duration = video_duration::find_video_duration_mplayer($t_info);
            $find_with = 'mplayer';
        }
        else if ($video_duration_cmd == 1)
        {
            $duration = video_duration::find_video_duration_ffmpeg($t_info);
            $find_with = 'ffmpeg';
        }
        else
        {
            $duration = video_duration::find_video_duration_ffmpeg_php($t_info);
            $find_with = 'ffmpeg-php';
        }
        
        $t_info['duration'] = $duration;
        
        if ($video_duration_cmd == 0)
        {
            $tmp = video_thumb::create_thumb_mplayer($t_info);
            $find_with = 'mplayer';
        }
        else if ($video_duration_cmd == 1)
        {
            $tmp = video_thumb::create_thumb_ffmpeg($t_info);
            $find_with = 'ffmpeg';
        }
        else
        {
            $tmp = video_thumb::create_thumb_ffmpeg_php($t_info);
            $find_with = 'ffmpeg-php';
        }
        
        if ($video_info['video_thumb_server_id'] > 0)
        {
            if ($config['debug'])
            {
                $log_text = '<p>$video_info[\'video_thumb_server_id\'] = ' . $video_info['video_thumb_server_id'] . '</p>';
                write_log($log_text, $log_file_name, $config['debug'], 'html');
            }
            $ftp_config = array();
            $ftp_config['debug'] = $config['debug'];
            $ftp_config['video_id'] = $_GET['id'];
            $ftp_config['log_file_name'] = 'log_create_thumb';
            $ftp_config['must_upload'] = 1;
            $ftp = new Ftp();
            $ftp->upload_thumb($ftp_config);
        }
        
        $msg = str_replace('[FIND_WIDTH]', $find_with, $lang['thumb_created']);
        $smarty->assign('video_folder', $video_info['video_folder']);
        $video_thumb_url = $servers[$video_info['video_thumb_server_id']];
        $smarty->assign('video_thumb_url', $video_thumb_url);
    }
    else
    {
        $err = str_replace('[VIDEO_SRC]', $video_src, $lang['file_not_found']);
    }
}
else
{
    $err = $lang['video_id_invalid'];
}

$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('admin/header.tpl');
$smarty->display('admin/video_thumb.tpl');
$smarty->display('admin/footer.tpl');
db_close();
