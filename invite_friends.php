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
require 'include/class.mail.php';
require 'include/class.validate.php';
require 'include/language/' . LANG . '/lang_invite_friends.php';

User::is_logged_in();

if (isset($_GET['UID']) && ($_GET['UID'] == $_SESSION['UID']))
{
    set_message($lang['invite_self'], 'success');
    $redirect_url = VSHARE_URL . '/friends.php';
    redirect($redirect_url);
}

if (isset($_POST['submit']))
{
    $first_name = htmlspecialchars_uni($_POST['first_name']);
    $recipients = htmlspecialchars_uni($_POST['recipients']);
    $message = htmlspecialchars_uni($_POST['message']);
    $smarty->assign('recipients', $recipients);
    
    if (isset($first_name) && (strlen($first_name) < 2))
    {
        $err = $lang['invite_friends_name'];
    }
    else if (($recipients == '') && ($_POST['UID'] == ''))
    {
        $err = $lang['invite_friends_email'];
    }
    else
    {
        $user_daily_mail_limit = get_config('user_daily_mail_limit');
        
        $sql = "SELECT count(*) AS `total` FROM `mail_logs` WHERE
               `mail_log_user_id`='" . (int) $_SESSION['UID'] . "'";
        $result_log = mysql_query($sql) or mysql_die($sql);
        $mail_log_info = mysql_fetch_assoc($result_log);
        $user_mail_today = $mail_log_info['total'];
        
        $sql = "UPDATE `users` SET
               `user_first_name`='" . mysql_clean($first_name) . "' WHERE
               `user_id`='" . (int) $_SESSION['UID'] . "'";
        mysql_query($sql) or mysql_die($sql);
        $sql = "SELECT * FROM `users` WHERE
               `user_id`='" . (int) $_SESSION['UID'] . "'";
        $result = mysql_query($sql) or mysql_die($sql);
        $user_info = mysql_fetch_assoc($result);
        $sender_name = $user_info['user_name'];
        $sender_fname = $user_info['user_first_name'];
        $sender_email = $user_info['user_email'];
        
        $sender_url = VSHARE_URL . '/' . $user_info['user_name'];
        
        $sql = "SELECT * FROM `email_templates` WHERE
               `email_id`='invite_friends'";
        $result = mysql_query($sql) or mysql_die($sql);
        $email_info = mysql_fetch_assoc($result);
        $email_subject = $email_info['email_subject'];
        $email_body = $email_info['email_body'];
        $email_subject = str_replace('[SENDER_NAME]', $sender_name, $email_subject);
        
        $user_id = $_POST['UID'];
        $smarty->assign('user_id', $user_id);
        
        if ($user_id == '')
        {
            $recipients = str_replace(' ', ',', $recipients);
            $emails = explode(',', $recipients);
            
            for ($i = 0; $i < count($emails); $i ++)
            {
                $friend_email = trim($emails[$i]);
                
                if ($friend_email == '')
                {
                    continue;
                }
                
                if (! validate::email($friend_email))
                {
                    $msg .= $friend_email . ' - Invalid<br />';
                    continue;
                }
                
                $sql = "SELECT * FROM `friends` WHERE
                       `friend_user_id`='" . (int) $_SESSION['UID'] . "' AND
                       `friend_name`='" . mysql_clean($friend_email) . "'";
                $result = mysql_query($sql) or mysql_die($sql);
                
                if (mysql_num_rows($result) > 0)
                {
                    $msg .= $friend_email . ' - ' . $lang['invite_friends_duplicate'] . '<br />';
                }
                else
                {
                    $user_mail_today ++;
                    
                    if ($user_mail_today > $user_daily_mail_limit)
                    {
                        $msg .= $lang['email_limit_exceeded'];
                        break;
                    }
                    
                    $sql = "INSERT INTO `mail_logs` SET
                           `mail_log_user_id`='" . (int) $_SESSION['UID'] . "',
                           `mail_log_time`='" . time() . "'";
                    mysql_query($sql) or mysql_die($sql);
                    
                    $sql = "INSERT INTO `friends` SET
                           `friend_user_id`='" . (int) $_SESSION['UID'] . "',
                           `friend_name`='" . mysql_clean($friend_email) . "',
                           `friend_type`='All|Friends',
                           `friend_invite_date`='" . date("Y-m-d") . "'";
                    mysql_query($sql) or mysql_die($sql);
                    $id = mysql_insert_id();
                    $key = $_SERVER['REQUEST_TIME'] . rand(1, 99999999);
                    $sql = "INSERT INTO `verify_code` SET
                           `vkey`='" . mysql_clean($key) . "',
                           `data1`='" . (int) $id . "'";
                    $result = mysql_query($sql) or mysql_die();
                    $id = mysql_insert_id();
                    $verify_url = VSHARE_URL . '/confirm/friend/' . base64_encode($id) . '/' . $key;
                    $email_body_tmp = $email_body;
                    $email_body_tmp = str_replace('[SITE_NAME]', $config['site_name'], $email_body_tmp);
                    $email_body_tmp = str_replace('[SITE_URL]', VSHARE_URL, $email_body_tmp);
                    $email_body_tmp = str_replace('[RECEIVER_NAME]', $friend_email, $email_body_tmp);
                    $email_body_tmp = str_replace('[SENDER_NAME]', $sender_name, $email_body_tmp);
                    $email_body_tmp = str_replace('[MESSAGE]', $message, $email_body_tmp);
                    $email_body_tmp = str_replace('[VERIFY_URL]', $verify_url, $email_body_tmp);
                    $email_body_tmp = str_replace('[SENDER_FNAME]', $sender_fname, $email_body_tmp);
                    $email_body_tmp = str_replace('[SENDER_URL]', $sender_url, $email_body_tmp);
                    
                    $email = array();
                    $email['from_email'] = $sender_email;
                    $email['from_name'] = $sender_fname;
                    $email['to_email'] = $friend_email;
                    $email['to_name'] = '';
                    $email['subject'] = $email_subject;
                    $email['body'] = $email_body_tmp;
                    $mail = new Mail();
                    $mail->send($email);
                    
                    $msg .= $friend_email . ' - ' . $lang['invite_friends_send'] . '<br />';
                }
            }
            set_message($msg, 'success');
            $redirect_url = VSHARE_URL . '/friends/invite/';
            redirect($redirect_url);
        }
        else
        {
            $sql = "SELECT * FROM `users` WHERE
                   `user_id`='" . (int) $user_id . "'";
            $result = mysql_query($sql) or mysql_die($sql);
            $user_info = mysql_fetch_assoc($result);
            
            $reciever_email = $user_info['user_email'];
            $reciever_name = $user_info['user_first_name'];
            
            if ($reciever_name == '')
            {
                $reciever_name = $user_info['user_name'];
            }
            
            $sql = "SELECT `friend_user_id`,`friend_friend_id` FROM `friends` WHERE
                   `friend_user_id`='" . (int) $_SESSION['UID'] . "' AND
                   `friend_friend_id`='" . (int) $user_id . "'";
            $result = mysql_query($sql) or mysql_die($sql);
            
            if (mysql_num_rows($result) > 0)
            {
                set_message($lang['invite_friends_duplicate'], 'success');
                $redirect_url = VSHARE_URL . '/friends/';
                redirect($redirect_url);
            }
            
            $sql = "INSERT INTO `friends` SET
                   `friend_user_id`=" . (int) $_SESSION['UID'] . ",
                   `friend_friend_id`='" . (int) $user_id . "',
                   `friend_name`='" . mysql_clean($user_info['user_name']) . "',
                   `friend_type`='All|Friends',
                   `friend_invite_date`='" . date("Y-m-d") . "'";
            $result = mysql_query($sql) or mysql_die($sql);
            $id = mysql_insert_id();
            $key = $_SERVER['REQUEST_TIME'] . rand(1, 99999999);
            $sql = "INSERT INTO `verify_code` SET
                   `vkey`='" . mysql_clean($key) . "',
                   `data1`='" . (int) $id . "'";
            $result = mysql_query($sql) or mysql_die($sql);
            $id = mysql_insert_id();
            
            $verify_url = VSHARE_URL . '/confirm/friend/' . base64_encode($id) . '/' . $key;
            
            $email_body_tmp = $email_body;
            $email_body_tmp = str_replace('[SITE_NAME]', $config['site_name'], $email_body_tmp);
            $email_body_tmp = str_replace('[SITE_URL]', VSHARE_URL, $email_body_tmp);
            $email_body_tmp = str_replace('[RECEIVER_NAME]', $reciever_name, $email_body_tmp);
            $email_body_tmp = str_replace('[SENDER_NAME]', $sender_name, $email_body_tmp);
            $email_body_tmp = str_replace('[MESSAGE]', $message, $email_body_tmp);
            $email_body_tmp = str_replace('[VERIFY_URL]', $verify_url, $email_body_tmp);
            $email_body_tmp = str_replace('[SENDER_FNAME]', $sender_fname, $email_body_tmp);
            $email_body_tmp = str_replace('[SENDER_URL]', $sender_url, $email_body_tmp);
            
            $sql = "INSERT INTO `mails` SET
                   `mail_subject`='" . mysql_clean($email_subject) . "',
                   `mail_body`='" . mysql_clean($email_body_tmp) . "',
                   `mail_sender`='" . mysql_clean($_SESSION['USERNAME']) . "',
                   `mail_receiver`='" . mysql_clean($user_info['user_name']) . "',
                   `mail_date`='" . date("Y-m-d H:i:s") . "'";
            
            mysql_query($sql) or mysql_die($sql);
            
            $email = array();
            $email['from_email'] = $sender_email;
            $email['from_name'] = $sender_fname;
            $email['to_email'] = $reciever_email;
            $email['to_name'] = $reciever_name;
            $email['subject'] = $email_subject;
            $email['body'] = $email_body_tmp;
            $mail = new Mail();
            $mail->send($email);
            $msg = $lang['invite_friends_send'];
        }
    }
}

$sql = "DELETE FROM `mail_logs` WHERE
       `mail_log_time`<'" . strtotime("last day") . "'";
mysql_query($sql) or mysql_die($sql);

$sql = "SELECT `user_first_name` FROM `users` WHERE
       `user_id`='" . (int) $_SESSION['UID'] . "'";
$result = mysql_query($sql) or mysql_die($sql);
$my_info = mysql_fetch_assoc($result);

$smarty->assign('first_name', $my_info['user_first_name']);
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->assign('sub_menu', 'menu_friends.tpl');
$smarty->display('header.tpl');
$smarty->display('invite_friends.tpl');
$smarty->display('footer.tpl');
db_close();
