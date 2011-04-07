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
require '../include/class.channels.php';
require '../include/language/' . LANG . '/lang_admin_import_folder_form.php';

check_admin_login();

$num_max_channels = get_config('num_max_channels');

$todo = '';

if (isset($_POST['submit']))
{
    $err = '';
    $user = $_POST['video_user'];
    $video_title = $_POST['video_title'];
    $type = $_POST['video_privacy'];
    $video = urldecode($_POST['video_name']);
    $video_description = $_POST['video_description'];
    
    if ($user == '')
    {
        $err = $lang['user_name_null'];
    }
    else if (strlen($video_title) < 4)
    {
        $err = $lang['title_too_short'];
    }
    else if ((count($_POST['channel']) < 1) || (count($_POST['channel']) > $num_max_channels))
    {
        $err = str_replace('[NUM_MAX_CHANNELS]', $num_max_channels, $lang['channel_not_selected']);
    }
    else if (strlen($video_description) < 4)
    {
        $err = $lang['description_too_short'];
    }
    else if ($_POST['video_keywords'] == '')
    {
        $err = $lang['tags_too_short'];
    }
    
    $channel = implode('|', $_POST['channel']);
    
    if ($err == '')
    {
        $sql = "SELECT * FROM `users` WHERE
               `user_name`='" . mysql_clean($user) . "'";
        $result = mysql_query($sql) or mysql_die();
        
        if (mysql_num_rows($result) > 0)
        {
            $user_info = mysql_fetch_object($result);
            $user_id = $user_info->user_id;
        }
        else
        {
            $err = $lang['user_not_found'];
        }
        
        if ($err == '')
        {
            $file_name = basename($video);
            $pos = strrpos($file_name, '.');
            $file_extn = strtolower(substr($file_name, $pos + 1, strlen($file_name) - $pos));
            $file_no_extn = basename($file_name, ".$file_extn");
            $file_no_extn = preg_replace("/[&$#]+/", ' ', $file_no_extn);
            $file_no_extn = preg_replace("/\s+/", '-', $file_no_extn);
            $file_name = $file_no_extn . '.' . $file_extn;
            $file_path = VSHARE_DIR . '/video/' . $file_name;
            $i = 0;
            
            while (file_exists($file_path))
            {
                $i ++;
                $file_name = $file_no_extn . '_' . $i . '.' . $file_extn;
                $file_path = VSHARE_DIR . '/video/' . $file_name;
            }
            
            $source = VSHARE_DIR . '/templates_c/import/' . $video;
            copy($source, $file_path);
            unlink($source);
            
            $sql = "INSERT INTO `process_queue` SET
                   `user`='" . mysql_clean($user) . "',
                   `title`='" . mysql_clean($video_title) . "',
                   `description`='" . mysql_clean($video_description) . "',
                   `keywords`='" . mysql_clean($_POST['video_keywords']) . "',
                   `type`='" . mysql_clean($type) . "',
                   `channels`='" . mysql_clean($channel) . "',
                   `file`='" . mysql_clean($file_name) . "',
                   `status`='2'";
            $result = mysql_query($sql) or mysql_die();
            $msg = $lang['video_process'];
            $todo = 'finished';
        }
    }
}

if (isset($_GET['video']))
{
    $writable = '';
    $video = urldecode($_GET['video']);
    $video_path = VSHARE_DIR . '/templates_c/import/' . $video;
    
    if (! is_writable($video_path))
    {
        $err = $lang['file_not_writable'] . " (chmod 777 $video_path)";
        $todo = 'finished';
    }
}

$channel_checkbox = '';
$ch = channels::get_all();

for ($i = 0; $i < count($ch); $i ++)
{
    $channel_checkbox .= '<input type="checkbox" name="channel[]" value="' . $ch[$i]['channel_id'] . '" />' . htmlspecialchars($ch[$i]['channel_name'], ENT_QUOTES, 'UTF-8') . '<br />';
}

$smarty->assign('channel_checkbox', $channel_checkbox);
$smarty->assign('todo', $todo);
$smarty->assign('video_name', $video);
$smarty->assign('msg', $msg);
$smarty->assign('err', $err);
$smarty->display('admin/header.tpl');
$smarty->display('admin/import_folder_form.tpl');
$smarty->display('admin/footer.tpl');
db_close();
