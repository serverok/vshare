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
require 'include/language/' . LANG . '/lang_invite_members.php';

User::is_logged_in();

$_GET['group_url'] = htmlspecialchars_uni($_GET['group_url']);

$sql = "SELECT * FROM `groups` WHERE
       `group_url`='" . mysql_clean($_GET['group_url']) . "'";
$result = mysql_query($sql) or mysql_die($sql);

if (mysql_num_rows($result) < 1)
{
    redirect(VSHARE_URL . '/groups.php');
}

$group_info = mysql_fetch_assoc($result);

$smarty->assign('group_info', $group_info);

$sql = "SELECT * FROM `group_members` WHERE
       `group_member_user_id`='" . (int) $_SESSION['UID'] . "' AND
       `group_member_group_id`='" . (int) $group_info['group_id'] . "' AND
       `group_member_approved`='yes'";
$result = mysql_query($sql) or mysql_die($sql);

if (mysql_num_rows($result) > 0)
{
    if ($group_info['group_type'] == 'public' || $group_info['group_type'] == 'protected' || $group_info['group_owner_id'] == $_SESSION['UID'])
    {
        $allow_invite = 1;
    }
    else
    {
        $allow_invite = 0;
    }
}
else
{
    $allow_invite = 0;
}

$smarty->assign('allow_invite', $allow_invite);

if (isset($_POST['send']) && $allow_invite == 1)
{
    $sql = "SELECT `user_name`, `user_first_name`, `user_last_name` FROM `users` WHERE
           `user_id`='" . (int) $_SESSION['UID'] . "'";
    $result = mysql_query($sql) or mysql_die($sql);
    $sender_info = mysql_fetch_assoc($result);
    
    $message = htmlspecialchars_uni($_POST['message']);
    $message = nl2br($message);
    $smarty->assign('message', $message);
    
    if ($_POST['flist'][0] == '' && $_POST['recipients'] == '')
    {
        $err = $lang['to_email_null'];
    }
    else if ($message == '')
    {
        $err = $lang['invite_msg_null'];
    }
    else
    {
        if ($sender_info['user_first_name'] == '')
        {
            $sender_name = $sender_info['user_name'];
        }
        else
        {
            $sender_name = $sender_info['user_first_name'] . ' ' . $sender_info['user_last_name'];
        }
        
        $group_url = VSHARE_URL . '/group/' . $_GET['group_url'] . '/';
        $sender_url = VSHARE_URL . '/' . $sender_info['user_name'];
        $from = $_SESSION['EMAIL'];
        
        $sql = "SELECT * FROM `email_templates` WHERE
               `email_id`='invite_group_email'";
        $result = mysql_query($sql) or mysql_die($sql);
        $email_info = mysql_fetch_assoc($result);
        $subj = $email_info['email_subject'];
        $email_subj = str_replace('[SENDER_NAME]', $sender_name, $subj);
        $email_subj = str_replace('[GROUP_NAME]', $group_info['group_name'], $email_subj);
        $email_body = $email_info['email_body'];
        
        if (count($_POST['flist']) > 0)
        {
            for ($i = 0; $i < count($_POST['flist']); $i ++)
            {
                $sql = "SELECT * FROM `users` WHERE
                        `user_name`='" . mysql_clean($_POST['flist'][$i]) . "'";
                $result = mysql_query($sql) or mysql_die($sql);
                $count = mysql_num_rows($result);
                $user_info = mysql_fetch_assoc($result);
                
                $key = time() . rand(1, 99999999);
                $key = md5($key);
                $sql = "INSERT INTO `verify_code` SET
                       `vkey`='" . mysql_clean($key) . "',
                       `data1`='" . (int) $group_info['group_id'] . "'";
                $result = mysql_query($sql) or mysql_die($sql);
                
                if ($count > 0)
                {
                    $email_body_tmp = $email_body;
                    $verify_url = VSHARE_URL . '/group/' . $_GET['group_url'] . '/join/' . $key . '/';
                    
                    $email_body_tmp = str_replace('[SITE_NAME]', $config['site_name'], $email_body_tmp);
                    $email_body_tmp = str_replace('[SITE_URL]', VSHARE_URL, $email_body_tmp);
                    $email_body_tmp = str_replace('[RECEIVER_NAME]', $_POST['flist'][$i], $email_body_tmp);
                    $email_body_tmp = str_replace('[SENDER_NAME]', $sender_name, $email_body_tmp);
                    $email_body_tmp = str_replace('[SENDER_URL]', $sender_url, $email_body_tmp);
                    $email_body_tmp = str_replace('[MESSAGE]', $message, $email_body_tmp);
                    $email_body_tmp = str_replace('[VERIFY_URL]', $verify_url, $email_body_tmp);
                    $email_body_tmp = str_replace('[GROUP_URL]', $group_url, $email_body_tmp);
                    $email_body_tmp = str_replace('[GROUP_NAME]', $group_info['group_name'], $email_body_tmp);
                    
                    $sql = "INSERT INTO `mails` SET
                           `mail_subject`='" . mysql_clean($email_subj) . "',
                           `mail_body`='" . mysql_clean($email_body_tmp) . "',
                           `mail_sender`='" . mysql_clean($_SESSION['USERNAME']) . "',
                           `mail_receiver`='" . mysql_clean($_POST['flist'][$i]) . "',
                           `mail_date`='" . date("Y-m-d H:i:s") . "'";
                    $temp = mysql_query($sql) or mysql_die($sql);
                    
                    $sql = "SELECT * FROM `buddy_list` WHERE
                           `username`='" . mysql_clean($_SESSION['USERNAME']) . "' AND
                           `buddy_name`='" . mysql_clean($_POST['flist'][$i]) . "'";
                    $result = mysql_query($sql) or mysql_die($sql);
                    
                    if (mysql_num_rows($result) == 0)
                    {
                        $sql = "INSERT INTO `buddy_list` SET
                               `username`='" . mysql_clean($_SESSION['USERNAME']) . "',
                               `buddy_name`='" . mysql_clean($_POST['flist'][$i]) . "'";
                        $temp = mysql_query($sql) or mysql_die($sql);
                    }
                }
                
                $email = array();
                $email['from_email'] = $from;
                $email['from_name'] = $_SESSION['USERNAME'];
                $email['to_email'] = $user_info['user_email'];
                $email['to_name'] = '';
                $email['subject'] = $email_subj;
                $email['body'] = $email_body_tmp;
                $mail = new Mail();
                $mail->send($email);
            }
        }
        
        if ($_POST['recipients'])
        {
            $emails = htmlspecialchars_uni($_POST['recipients']);
            $emails = explode(',', $emails);
            
            for ($i = 0; $i < count($emails); $i ++)
            {
                if (validate::email($emails[$i]))
                {
                    $key = $_SERVER['REQUEST_TIME'] . rand(1, 99999999);
                    $sql = "INSERT INTO `verify_code` SET
                       `vkey`='" . mysql_clean($key) . "',
                       `data1`='" . (int) $group_info['group_id'] . "'";
                    $result = mysql_query($sql) or mysql_die($sql);
                    
                    $email_body_tmp = $email_body;
                    $verify_url = VSHARE_URL . '/group/' . $_GET['group_url'] . '/?key=' . $key;
                    $email_body_tmp = str_replace('[SITE_NAME]', $config['site_name'], $email_body_tmp);
                    $email_body_tmp = str_replace('[SITE_URL]', VSHARE_URL, $email_body_tmp);
                    $email_body_tmp = str_replace('[RECEIVER_NAME]', $emails[$i], $email_body_tmp);
                    $email_body_tmp = str_replace('[SENDER_NAME]', $sender_name, $email_body_tmp);
                    $email_body_tmp = str_replace('[SENDER_URL]', $sender_url, $email_body_tmp);
                    $email_body_tmp = str_replace('[MESSAGE]', $message, $email_body_tmp);
                    $email_body_tmp = str_replace('[VERIFY_URL]', $verify_url, $email_body_tmp);
                    $email_body_tmp = str_replace('[GROUP_NAME]', $group_info['group_name'], $email_body_tmp);
                    $email_body_tmp = str_replace('[GROUP_URL]', $group_url, $email_body_tmp);
                    
                    $email = array();
                    $email['from_email'] = $from;
                    $email['from_name'] = $_SESSION['USERNAME'];
                    $email['to_email'] = $emails[$i];
                    $email['to_name'] = '';
                    $email['subject'] = $email_subj;
                    $email['body'] = $email_body_tmp;
                    $mail = new Mail();
                    $mail->send($email);
                }
            
            }
        }
        
        set_message($lang['invite_sent'], 'success');
        $redirect_url = VSHARE_URL . '/group/' . $_GET['group_url'] . '/invite/';
        redirect($redirect_url);
    }
}

$sql = "SELECT `user_first_name` FROM `users` WHERE
       `user_id`='" . (int) $_SESSION['UID'] . "'";
$result = mysql_query($sql) or mysql_die($sql);
$fname_info = mysql_fetch_assoc($result);
$first_name = $fname_info['user_first_name'];
$smarty->assign('first_name', $first_name);

$sql = "SELECT `friend_name`, `friend_friend_id` FROM `friends` WHERE
       `friend_user_id`='" . (int) $_SESSION['UID'] . "' AND
       `friend_status`='Confirmed'";
$result = mysql_query($sql) or mysql_die($sql);

$fname = '';
$my_friends = '';

while ($friends_info = mysql_fetch_assoc($result))
{
    $my_friends[] = $friends_info['friend_name'];
    $fname .= "<option value=" . $friends_info['friend_name'] . ">" . $friends_info['friend_name'] . "</option>\n";
}

$smarty->assign('fname', $fname);
$smarty->assign('myfriends', $my_friends);
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->assign('sub_menu', 'menu_group_members.tpl');
$smarty->display('header.tpl');
$smarty->display('invite_members.tpl');
$smarty->display('footer.tpl');
db_close();
