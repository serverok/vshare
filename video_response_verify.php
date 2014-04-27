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
require 'include/language/' . LANG . '/lang_video_response.php';

if (isset($_GET['k']) && isset($_GET['u']) && isset($_GET['i']))
{
    if (! is_numeric($_GET['u']))
    {
        $err = $lang['invalid_vcode'];
    }
    else if (! is_numeric($_GET['i']))
    {
        $err = $lang['invalid_vcode'];
    }
    else if (strlen($_GET['k']) > 40)
    {
        $err = $lang['invalid_vcode'];
    }
    else
    {
        $data1 = 'VIDEO_RESPONSE' . $_GET['u'];
        $sql = "SELECT * FROM `verify_code` WHERE
               `id`=" . (int) $_GET['i'] . " AND
               `vkey`='" . DB::quote($_GET['k']) . "' AND
               `data1`='" . DB::quote($data1) . "'";
        $result = mysql_query($sql) or mysql_die($sql);
        
        if (mysql_num_rows($result) == 0)
        {
            set_message($lang['invalid_vcode'], 'error');
            Http::redirect(VSHARE_URL . '/index.php');
        }
        
        $vinfo = mysql_fetch_assoc($result);
        
        $sql = "SELECT * FROM `videos` WHERE
               `video_id`='" . (int) $_GET['u'] . "'";
        $result = mysql_query($sql) or mysql_die($sql);
        $video_info = mysql_fetch_assoc($result);
        $video_info['video_thumb_url'] = $servers[$video_info['video_thumb_server_id']];
        $smarty->assign('video_info', $video_info);
        
       if (isset($_POST['action']))
       {
            if ($_POST['action'] == 'Accept this video')
            {
                $sql = "UPDATE `video_responses` SET
                       `video_response_active`='1' WHERE
                       `video_response_video_id`='" . (int) $_GET['u'] . "' AND
                       `video_response_to_video_id`='" . (int) $vinfo['data2'] . "'";
                mysql_query($sql) or mysql_die($sql);
                
                $sql = "DELETE FROM `verify_code` WHERE
                       `id`='" . (int) $_GET['i'] . "' AND
                       `vkey`='" . DB::quote($_GET['k']) . "' AND
                       `data1`='" . DB::quote($data1) . "'";
                mysql_query($sql) or mysql_die($sql);
                
                set_message($lang['video_response_activated'], 'success');
                $redirect_url = VSHARE_URL . '/response/' . $vinfo['data2'] . '/videos/1';
                Http::redirect($redirect_url);
            }
            else if ($_POST['action'] == 'Reject this video')
            {
                $sql = "DELETE FROM `verify_code` WHERE
                       `id`='" . (int) $_GET['i'] . "' AND
                       `vkey`='" . DB::quote($_GET['k']) . "' AND
                       `data1`='" . DB::quote($data1) . "'";
                mysql_query($sql) or mysql_die($sql);
                
                $sql = "DELETE FROM `video_responses` WHERE
                       `video_response_video_id`='" . (int) $_GET['u'] . "' AND
                       `video_response_to_video_id`='" . (int) $vinfo['data2'] . "'";
                mysql_query($sql) or mysql_die($sql);
                
                set_message($lang['video_response_rejected'], 'success');
                $redirect_url = VSHARE_URL . '/response/' . $vinfo['data2'] . '/videos/1';
                Http::redirect($redirect_url);
            }
       }
    }
}

$smarty->assign('err', $err);
$smarty->display('header.tpl');
$smarty->display('video_response_verify.tpl');
$smarty->display('footer.tpl');
db_close();
