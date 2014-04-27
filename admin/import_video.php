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

require '../include/config.php';
require '../include/settings/upload.php';
require '../include/youtube.php';
require '../include/class.channels.php';
require '../include/language/' . LANG . '/lang_admin_import_video.php';

check_admin_login();

$num_max_channels = get_config('num_max_channels');

if (isset($_POST['submit']))
{
    $video_url = $_POST['video_url'];
    $video_title = $_POST['video_title'];
    $video_description = $_POST['video_description'];
    $video_keywords = $_POST['video_keywords'];
    
    # check if user exists
    

    $sql = "SELECT * FROM `users` WHERE
           `user_name`='" . DB::quote($_POST['video_user']) . "'";
    $result = mysql_query($sql) or mysql_die($sql);
    
    if (mysql_num_rows($result) == 1)
    {
        $user_info = mysql_fetch_assoc($result);
    }
    else
    {
        $err = $lang['user_not_found'];
    }
    
    if ($err == '')
    {
        if ($video_url == '')
        {
            $err = $lang['video_url_empty'];
        }
        else if (strlen($video_title) < 4)
        {
            $err = $lang['title_too_short'];
        }
        else if (strlen($video_description) < 4)
        {
            $err = $lang['description_too_short'];
        }
        else if (strlen($video_keywords) < 4)
        {
            $err = $lang['tags_too_short'];
        }
        else if (count($_POST['chlist']) < 1)
        {
            $err = str_replace('[NUM_MAX_CHANNELS]', $num_max_channels, $lang['channel_not_selected']);
        }
    }
    
    $listch = implode('|', $_POST['chlist']);
    
    if ($err == '')
    {
        
        if (strstr($video_url, 'youtube.com'))
        {
        }
        else if (strstr($video_url, 'dailymotion.com'))
        {
            $file = @file($video_url);
            $count = count($file);
            $flag = 0;
            for ($i = 0; $i < $count; $i ++)
            {
                if (strstr($file[$i], 'addVariable') and strstr($file[$i], '.flv') and strstr($file[$i], '"url"'))
                {
                    $main = $file[$i];
                    $flag = 1;
                    break;
                }
            }
            
            if ($flag == 1)
            {
                $parse = explode("http%3A%2F%2F", $main);
                $parse1 = explode('");', $parse[1]);
                $parse1[0] = str_replace("%2F", "/", $parse1[0]);
                $parse1[0] = str_replace("%3F", "?", $parse1[0]);
                $parse1[0] = str_replace("%3D", "=", $parse1[0]);
                $video_url = 'http://' . $parse1[0];
                $file_extn = 'flv';
            }
            
            if ($flag == 0)
            {
                $err = str_replace('[VIDEO_URL]', $video_url, $lang['download_failed_dailymotion']);
            }
        }
        else
        {
            $file_name = basename($video_url);
            $pos = strrpos($file_name, '.');
            $file_extn = strtolower(substr($file_name, $pos + 1, strlen($file_name) - $pos));
            
            if (! in_array($file_extn, $file_types))
            {
                $allowed_types = implode(',', $file_types);
                $err = str_replace('[ALLOWED_TYPES]', $allowed_types, $lang['invalid_video_format']);
            }
        }
    }
    
    if ((check_field_exists($video_url, 'url', 'process_queue') == 1))
    {
        $err = $lang['import_video_url_exist'];
    }
    
    if ($err == '')
    {
        $sql = "INSERT INTO `process_queue`SET
               `user`='" . DB::quote($_POST['video_user']) . "',
               `title`='" . DB::quote($video_title) . "',
               `description`='" . DB::quote($video_description) . "',
               `keywords`='" . DB::quote($video_keywords) . "',
               `process_queue_upload_ip`='" . User::get_ip() . "',
               `type`='" . DB::quote($_POST['video_privacy']) . "',
               `channels`='$listch',
               `status`=0,
               `url`='" . DB::quote($video_url) . "'";
        $result = mysql_query($sql) or mysql_die($sql);
        $msg = $lang['video_process'];
        $smarty->assign('finished', 1);
    }
}

$smarty->assign('num_max_channels', $num_max_channels);
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->assign('channels', channels::get_all());
$smarty->display('admin/header.tpl');
$smarty->display('admin/import_video.tpl');
$smarty->display('admin/footer.tpl');
db_close();
