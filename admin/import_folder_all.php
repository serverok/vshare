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
require '../include/class.channels.php';
require '../include/language/' . LANG . '/lang_admin_import_folder_all.php';

check_admin_login();

$import_folder = VSHARE_DIR . '/templates_c/import';
$num_max_channels = get_config('num_max_channels');

$videos = array();

$todo = '';

if (is_dir($import_folder))
{
    $import_video = dir($import_folder);
    
    while (false !== ($video = $import_video->read()))
    {
        if ($video != '.' && $video != '..')
        {
            $pos = strrpos($video, '.');
            $upload_file_extn = strtolower(substr($video, $pos + 1, strlen($video) - $pos));
            for ($i = 0; $i < count($file_types); $i ++)
            {
                if ($upload_file_extn == $file_types[$i])
                {
                    $videos[] = $video;
                }
            }
        }
    }

}
else
{
    $err = 1;
}

if (isset($_POST['submit']))
{
    $err = '';
    $user = $_POST['video_user'];
    $video_title = $_POST['video_title'];
    $type = $_POST['video_privacy'];
    $video_description = $_POST['video_description'];
    $tags = $_POST['video_keywords'];
    
    if ($user == '')
    {
        $err = $lang['user_name_null'];
    }
    else if (strlen($video_title) < 4)
    {
        $err = $lang['title_too_short'];
    }
    else if ((count($_POST['chlist']) < 1) || (count($_POST['chlist']) > $num_max_channels))
    {
        $err = str_replace('[NUM_MAX_CHANNELS]', $num_max_channels, $lang['channel_not_selected']);
    }
    else if (strlen($video_description) < 4)
    {
        $err = $lang['description_too_short'];
    }
    else if ($tags == '')
    {
        $err = $lang['tags_too_short'];
    }
    
    if ($err == '')
    {
        $channel = implode('|', $_POST['chlist']);
        $sql = "SELECT * FROM `users` WHERE
               `user_name`='" . mysql_clean($user) . "'";
        $result = mysql_query($sql) or mysql_die();
        
        if (mysql_num_rows($result) > 0)
        {
            $user_info = mysql_fetch_assoc($result);
            $user_id = $user_info['user_id'];
        }
        else
        {
            $err = $lang['user_not_found'];
        }
        
        if ($err == '')
        {
            for ($j = 0; $j < count($videos); $j ++)
            {
                $file_name = basename($videos[$j]);
                $pos = strrpos($file_name, '.');
                $file_extn = strtolower(substr($file_name, $pos + 1, strlen($file_name) - $pos));
                $file_no_extn = basename($file_name, ".$file_extn");
                $file_no_extn = ereg_replace("[&$#]+", ' ', $file_no_extn);
                $file_no_extn = ereg_replace("[ ]+", '-', $file_no_extn);
                $file_name = $file_no_extn . '.' . $file_extn;
                $file_path = VSHARE_DIR . '/video/' . $file_name;
                $i = 0;
                
                while (file_exists($file_path))
                {
                    $i ++;
                    $file_name = $file_no_extn . '_' . $i . '.' . $file_extn;
                    $file_path = VSHARE_DIR . '/video/' . $file_name;
                }
                
                $source = VSHARE_DIR . '/templates_c/import/' . $videos[$j];
                
                if (file_exists($source))
                {
                    copy($source, $file_path);
                    unlink($source);
                    
                    $sql = "INSERT INTO `process_queue` SET
                           `user`='" . mysql_clean($user) . "',
                           `title`='" . mysql_clean($video_title) . "',
                           `description`='" . mysql_clean($video_description) . "',
                           `keywords`='" . mysql_clean($tags) . "',
                           `type`='" . mysql_clean($type) . "',
                           `channels`='" . mysql_clean($channel) . "',
                           `file`='" . mysql_clean($file_name) . "',
                           `status`=2";
                    mysql_query($sql) or mysql_die();
                    $todo = 'finished';
                }
            }
            
            $msg = $lang['video_process'];
        }
    }
}

if (empty($videos))
{
    $todo = 'folder_empty';
}

$chinfo = channels::get_all();

$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->assign('num_max_channels', $num_max_channels);
$smarty->assign('todo', $todo);
$smarty->assign('chinfo', $chinfo);
$smarty->display('admin/header.tpl');
$smarty->display('admin/import_folder_all.tpl');
$smarty->display('admin/footer.tpl');
db_close();
