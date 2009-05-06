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
require 'include/language/' . LANG . '/lang_upload_success.php';

$guest_upload = get_config('guest_upload');

if ($guest_upload == 0)
{
    User::is_logged_in();
}

$upload_id = $_GET['upload_id'];

if ($upload_id != 'remote')
{
    $id = $_GET['id'];
    if (! is_numeric($id))
    {
        echo 'Invalid id';
        exit(0);
    }
    
    $sql = "SELECT * FROM `process_queue` WHERE
           `id`='" . (int) $id . "'";
    $result = mysql_query($sql) or mysql_die($sql);
    $queue_info = mysql_fetch_assoc($result);
    $status = $queue_info['status'];
    $user = $queue_info['user'];
    
    if ($guest_upload == 0)
    {
        if ($user != $_SESSION['USERNAME'])
        {
            echo "Invalid user";
            exit(0);
        }
    }
    
    if ($status == 5)
    {
        $video_processed = 1;
        $vid = $queue_info['vid'];
        
        $sql = "SELECT * FROM `videos` WHERE
               `video_id`='" . (int) $vid . "'";
        $result = mysql_query($sql) or mysql_die();
        $video_info = mysql_fetch_assoc($result);
        $video_flv_name = $video_info['video_flv_name'];
        $video_info['video_thumb_url'] = $servers[$video_info['video_thumb_server_id']];
        
        if (mysql_num_rows($result) <= 0)
        {
            $err = $lang['video_not_found'];
        }
        
        $smarty->assign('video_info', $video_info);
    }
    else
    {
        $video_processed = 0;
    }

}
else
{
    $vid = $_GET['id'];
    
    $sql = "SELECT * FROM `videos` WHERE
           `video_id`='" . (int) $vid . "'";
    $result = mysql_query($sql) or mysql_die($sql);
    $video_info = mysql_fetch_assoc($result);
    
    $video_flv_name = $video_info['video_flv_name'];
    
    if (mysql_num_rows($result) <= 0)
    {
        $err = $lang['video_not_found'];
    }
    
    $smarty->assign('video_info', $video_info);
    $video_processed = 1;
}

if ($video_processed == 1)
{
    if ($video_info['video_vtype'] == 0)
    {
        if ($video_info['video_server_id'] == 0)
        {
            $flv_url = VSHARE_URL . '/flvideo/' . $video_info['video_folder'] . $video_info['video_flv_name'];
        }
        else
        {
            $sql = "SELECT * FROM `servers` WHERE
                   `id`='" . (int) $video_info['video_server_id'] . "'";
            $result = mysql_query($sql) or mysql_die($sql);
            $server_info = mysql_fetch_assoc($result);
            $flv_url = $server_info['url'] . '/' . $video_info['video_folder'] . $video_info['video_flv_name'];
        }
        
        $smarty->assign('flv_url', $flv_url);
    }
}

if ($upload_id != 'remote')
{
    unset($_SESSION["$upload_id"]['field_privacy']);
    unset($_SESSION["$upload_id"]['description']);
    unset($_SESSION["$upload_id"]['title']);
    unset($_SESSION["$upload_id"]['keywords']);
    unset($_SESSION["$upload_id"]['channels']);
    unset($_SESSION["$upload_id"]['adult']);
}

$smarty->assign('video_processed', $video_processed);
$smarty->assign('err', $err);
if (isset($_GET['vid'])) $smarty->assign('vidid', $_GET['vid']);
$smarty->display('header.tpl');
$smarty->display('upload_success.tpl');
$smarty->display('footer.tpl');
db_close();
