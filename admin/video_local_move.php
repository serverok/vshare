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
require '../include/class.ftp.php';

check_admin_login();

$err = 0;

if (isset($_POST['submit']))
{
    $videos = $_POST['local_videos'];
    $server_id = (int) $_POST['server'];
    
    $ftp_config = array();
    $ftp_config['must_upload'] = 0;
    $ftp_config['debug'] = $debug;
    $ftp = new Ftp();
    
    for ($i = 0; $i < count($videos); $i ++)
    {
        $ftp_config['server_id'] = $server_id;
        $ftp_config['video_id'] = (int) $videos[$i];
        $ftp_config['log_file_name'] = 'move_video_' . $ftp_config['video_id'];
        $ftp->upload_video($ftp_config);
        $ftp_config['log_file_name'] = 'move_video_jpg' . $ftp_config['video_id'];
        $ftp_config['server_id'] = '';
        $ftp->upload_thumb($ftp_config);
    }
}

db_close();
$redirect_url = VSHARE_URL . '/admin/video_local.php';
Http::redirect($redirect_url);
