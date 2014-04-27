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
require 'include/settings/upload.php';
require 'include/functions_upload.php';
require 'include/class.mail.php';
require 'include/language/' . LANG . '/lang_video_response.php';

User::is_logged_in();

$video_response_added = 0;

$sql = "SELECT * FROM `videos` WHERE
       `video_id`='" . (int) $_GET['vid'] . "' AND
       `video_active`='1' AND
       `video_approve`='1'";
$result = mysql_query($sql) or mysql_die($sql);

if (mysql_num_rows($result) == 0)
{
    Http::redirect(VSHARE_URL . '/index.php');
}

$video_info = mysql_fetch_assoc($result);
$video_info['video_thumb_url'] = $servers[$video_info['video_thumb_server_id']];
$smarty->assign('video_info', $video_info);

if (isset($_POST['submit']))
{
    $sql = "DELETE FROM `video_responses` WHERE
           `video_response_video_id`='" . (int) $_POST['video_response_video_id'] . "'";
    mysql_query($sql) or mysql_die($sql);
    
    $sql = "INSERT INTO `video_responses` SET
           `video_response_video_id`='" . (int) $_POST['video_response_video_id'] . "',
           `video_response_to_video_id`='" . (int) $_POST['video_response_to_video_id'] . "',
           `video_response_add_time`='" . (int) $_SERVER['REQUEST_TIME'] . "'";
    mysql_query($sql) or mysql_die($sql);
    
    $sql = "SELECT `video_id`,`video_title`,`video_seo_name` FROM `videos` WHERE
           `video_id`='" . (int) $_POST['video_response_video_id'] . "'";
    $result = mysql_query($sql) or mysql_die($sql);
    $response_video_info = mysql_fetch_assoc($result);
    
    $data1 = 'VIDEO_RESPONSE' . $response_video_info['video_id'];
    $data2 = $video_info['video_id'];
    
    $vkey = $_SERVER['REQUEST_TIME'] . rand(1, 99999999);
    $vkey = md5($vkey);
    
    $sql = "INSERT INTO `verify_code` SET
           `vkey`='" . DB::quote($vkey) . "',
           `data1`='" . DB::quote($data1) . "',
           `data2`='" . (int) $data2 . "'";
    $result = mysql_query($sql) or mysql_die($sql);
    $verify_id = mysql_insert_id();
    
    $sql = "SELECT * FROM `email_templates` WHERE
           `email_id`='video_response_notify'";
    $result = mysql_query($sql) or mysql_die($sql);
    $tmp = mysql_fetch_assoc($result);
    $email_subject = $tmp['email_subject'];
    $email_body_tmp = $tmp['email_body'];
    
    $email_subject = str_replace('[SITE_NAME]', $config['site_name'], $email_subject);
    $email_subject = str_replace('[VIDEO_TITLE]', $video_info['video_title'], $email_subject);
    
    $video_url = VSHARE_URL . '/view/' . $video_info['video_id'] . '/' . $video_info['video_seo_name'] . '/';
    $response_video_url = VSHARE_URL . '/view/' . $response_video_info['video_id'] . '/' . $response_video_info['video_seo_name'] . '/';
    $verify_link = VSHARE_URL . '/verify/response/' . $response_video_info['video_id'] . '/' . $verify_id . '/' . $vkey . '/';
    
    $email_body_tmp = str_replace('[SITE_NAME]', $config['site_name'], $email_body_tmp);
    $email_body_tmp = str_replace('[SITE_URL]', VSHARE_URL, $email_body_tmp);
    $email_body_tmp = str_replace('[USERNAME]', $_SESSION['USERNAME'], $email_body_tmp);
    $email_body_tmp = str_replace('[VIDEO_URL]', $video_url, $email_body_tmp);
    $email_body_tmp = str_replace('[VIDEO_TITLE]', $video_info['video_title'], $email_body_tmp);
    $email_body_tmp = str_replace('[RESPONSE_VIDEO_URL]', $response_video_url, $email_body_tmp);
    $email_body_tmp = str_replace('[RESPONSE_VIDEO_TITLE]', $response_video_info['video_title'], $email_body_tmp);
    $email_body_tmp = str_replace('[VERIFY_LINK]', $verify_link, $email_body_tmp);
    
    $sql = "SELECT `user_name`,`user_email` FROM `users` WHERE
           `user_id`='" . $video_info['video_user_id'] . "'";
    $result = mysql_query($sql) or mysql_die($sql);
    $video_owner_info = mysql_fetch_assoc($result);
    
    $headers = "From: $config[site_name] <$config[admin_email]> \n";
    $headers .= "Content-Type: text/html\n";
    
    $email = array();
    $email['from_email'] = $config['admin_email'];
    $email['from_name'] = $config['site_name'];
    $email['to_email'] = $video_owner_info['user_email'];
    $email['to_name'] = $video_owner_info['user_name'];
    $email['subject'] = $email_subject;
    $email['body'] = $email_body_tmp;
    $mail = new Mail();
    $mail->send($email);
    
    $video_response_added = 1;
}

if ($video_response_added == 0)
{
    $sql = "SELECT * FROM `videos` WHERE
           `video_id`!='" . (int) $_GET['vid'] . "' AND
           `video_user_id`='" . (int) $_SESSION['UID'] . "' AND
           `video_active`='1' AND
           `video_approve`='1'
            ORDER BY `video_id` DESC";
    $result = mysql_query($sql) or mysql_die($sql);
    
    if (mysql_num_rows($result) > 0)
    {
        while ($video = mysql_fetch_assoc($result))
        {
            $video['video_already_response'] = 0;
            
            $sql = "SELECT * FROM `video_responses` WHERE
                  `video_response_video_id`='" . (int) $video['video_id'] . "'";
            $tmp = mysql_query($sql) or mysql_die($sql);
            
            $duplicate_video = 0;
            
            if (mysql_num_rows($tmp) > 0)
            {
                while ($tmp_info = mysql_fetch_assoc($tmp))
                {
                    if ($tmp_info['video_response_video_id'] == $video['video_id'])
                    {
                        $video['video_already_response'] = 1;
                    }
                    
                    if ($tmp_info['video_response_to_video_id'] == $_GET['vid'])
                    {
                        $duplicate_video = 1;
                    }
                }
            }
            
            if ($duplicate_video == 0)
            {
                $video['video_thumb_url'] = $servers[$video['video_thumb_server_id']];
                $user_videos[] = $video;
            }
        }
        
        $smarty->assign('user_videos', $user_videos);
    }
}

$smarty->assign('video_response_added', $video_response_added);
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('header.tpl');
$smarty->display('upload_video_response.tpl');
$smarty->display('footer.tpl');
DB::close();
