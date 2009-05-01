<?php

require '../include/config.php';
require '../include/class.mail.php';
require '../include/functions_ajax.php';
require '../include/language/' . LANG . '/lang_video_inappropriate.php';

$video_id = isset($_POST['vid']) ? $_POST['vid'] : '';
$abuse_type = isset($_POST['abuse_type']) ? $_POST['abuse_type'] : '';
$comment = isset($_POST['comment']) ? $_POST['comment'] : '';
$comment = strip_tags($comment);

if (! is_numeric($video_id))
{
    $err = $lang['vid_invalid'];
}

if (strlen($comment) < 5)
{
    $err = $lang['comment_short'];
}

if ($err != '')
{
    return_json($err, 'error');
    exit();
}

$sql = "SELECT count(*) AS `total` FROM `inappropriate_requests` WHERE 
       `inappropriate_request_video_id`='" . (int) $video_id . "'";
$result = mysql_query($sql) or mysql_die($sql);
$tmp = mysql_fetch_assoc($result);

if ($tmp['total'] > 0)
{
    $sql = "UPDATE `inappropriate_requests` SET 
           `inappropriate_request_count`=`inappropriate_request_count`+1,
           `inappropriate_request_date`='" . date("Y-m-d") . "' WHERE 
           `inappropriate_request_video_id`=" . (int) $video_id;
}
else
{
    $sql = "INSERT `inappropriate_requests` SET 
           `inappropriate_request_video_id`='" . (int) $video_id . "',
           `inappropriate_request_count`=1,
           `inappropriate_request_date`='" . date("Y-m-d") . "'";
}

$result = mysql_query($sql) or mysql_die($sql);

$mail_abuse_report = get_config('mail_abuse_report');

if ($mail_abuse_report == 1)
{
    $sql = "SELECT `video_id`,`video_title`,`video_seo_name` FROM `videos` WHERE 
           `video_id`='" . (int) $video_id . "'";
    $result = mysql_query($sql) or mysql_die($sql);
    $video_info = mysql_fetch_assoc($result);
    
    $sql = "SELECT * FROM `email_templates` WHERE 
           `email_id`='abuse_report'";
    $result = mysql_query($sql) or mysql_die($sql);
    $tmp = mysql_fetch_assoc($result);
    $email_body = $tmp['email_body'];
    $email_subject = $tmp['email_subject'];
    
    $user_name = isset($_SESSION['USERNAME']) ? $_SESSION['USERNAME'] : 'Guest';
    $video_url = VSHARE_URL . '/view/' . $video_id . '/' . $video_info['video_seo_name'] . '/';
    
    $email_subject = str_replace('[VIDEO_TITLE]', $video_info['video_title'], $email_subject);
    
    $email_body = str_replace('[SITE_NAME]', $config['site_name'], $email_body);
    $email_body = str_replace('[SITE_URL]', VSHARE_URL, $email_body);
    $email_body = str_replace('[USER_NAME]', $user_name, $email_body);
    $email_body = str_replace('[VID]', $video_id, $email_body);
    $email_body = str_replace('[VIDEO_TITLE]', $video_info['video_title'], $email_body);
    $email_body = str_replace('[TITLE]', $video_info['video_seo_name'], $email_body);
    $email_body = str_replace('[VIDEO_URL]', $video_url, $email_body);
    $email_body = str_replace('[TYPE_ABUSE]', $abuse_type, $email_body);
    $email_body = str_replace('[ABUSE_COMMENTS]', nl2br(stripcslashes($comment)), $email_body);
    $email_body = str_replace('[REMOTE_ADDR]', $_SERVER['REMOTE_ADDR'], $email_body);
    
    $msg = array();
    $msg['from_email'] = $config['admin_email'];
    $msg['from_name'] = $config['site_name'];
    $msg['to_email'] = $config['admin_email'];
    $msg['to_name'] = $config['admin_name'];
    $msg['subject'] = $email_subject;
    $msg['body'] = $email_body;
    $mail = new Mail();
    $mail->send($msg);
}

return_json($lang['request_sent'], 'success');
db_close();
