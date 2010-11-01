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
require '../include/language/' . LANG . '/lang_admin_video_user_deleted_activate.php';

check_admin_login();

if (isset($_POST['activate']))
{
    $user_name = $_POST['user_name'];
    
    if ($user_name == '')
    {
        $err = $lang['user_name_empty'];
    }
    
    if ($err == '')
    {
        $sql = "SELECT * FROM `users` WHERE
               `user_name`='" . mysql_clean($_POST['user_name']) . "'";
        $result = mysql_query($sql) or mysql_die($sql);
        
        if (mysql_num_rows($result) == 1)
        {
            $user_info = mysql_fetch_assoc($result);
            $sql = "UPDATE `videos` SET `video_user_id`=" . $user_info['user_id'] . ",
                   `video_active`='1' WHERE
                   `video_id`='" . (int) $_POST['video_id'] . "'";
            $result = mysql_query($sql) or mysql_die($sql);
            
            $sql = "SELECT * FROM `videos` WHERE
                   `video_id`='" . mysql_clean($_POST['video_id']) . "'";
            $result = mysql_query($sql) or mysql_die($sql);
            $video_info = mysql_fetch_assoc($result);
            $flv_size = $video_info['video_space'];
            $sql = "UPDATE `subscriber` SET
                   `used_space`=`used_space`+$flv_size,
                   `total_video`=`total_video`+1 WHERE
                   `UID`='" . (int) $user_info['user_id'] . "'";
            mysql_query($sql) or mysql_die($sql);
            
            update_user_video_count($user_info['user_id'], 1);
            
            require '../include/class.tags.php';
            
            $tags = new Tags($video_info['video_keywords'], $_POST['video_id'], $video_info['video_user_id'], $video_info['video_channels']);
            $tags->add();
            $msg = str_replace('[USERNAME]', $user_info['user_name'], $lang['video_activated']);
            set_message($msg, 'success');
            $redirect_url = VSHARE_URL . '/admin/video_user_deleted.php';
            redirect($redirect_url);
        }
        else
        {
            $err = $lang['user_not_found'];
        }
    }
}

if (is_numeric($_GET['id']))
{
    $sql = "SELECT * FROM `videos` WHERE
           `video_id`='" . (int) $_GET['id'] . "'";
    $result = mysql_query($sql) or mysql_die($sql);
    $video_info = mysql_fetch_assoc($result);
    $smarty->assign('video', $video_info);
}

$smarty->assign('msg', $msg);
$smarty->assign('err', $err);
$smarty->display('admin/header.tpl');
$smarty->display('admin/video_user_deleted_activate.tpl');
$smarty->display('admin/footer.tpl');
db_close();
