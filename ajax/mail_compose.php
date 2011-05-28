<?php

require '../include/config.php';
require '../include/class.mail.php';

User::is_logged_in();

$mail_to = isset($_GET['receiver']) ? $_GET['receiver'] : '';
$mail_subject = isset($_GET['subject']) ? $_GET['subject'] : '';
$mail_to = htmlspecialchars_uni($mail_to);
$mail_subject = htmlspecialchars_uni($mail_subject);

if (isset($_GET['action']))
{
    if ($_GET['action'] == 'send')
    {
        require '../include/language/' . LANG . '/lang_compose.php';
        
        $mail_body = htmlspecialchars_uni($_GET['mail_body']);
        
        if ($mail_to == '')
        {
            $err = $lang['receiver_null'];
        }
        else if ($mail_subject == '')
        {
            $err = $lang['subject_null'];
        }
        else if ($mail_body == '')
        {
            $err = $lang['message_null'];
        }
        
        if (empty($err))
        {
            $user_daily_mail_limit = get_config('user_daily_mail_limit');
            
            $sql = "SELECT count(*) AS `total` FROM `mail_logs` WHERE
                   `mail_log_user_id`='" . (int) $_SESSION['UID'] . "'";
            $result_log = mysql_query($sql) or mysql_die($sql);
            $mail_log_info = mysql_fetch_assoc($result_log);
            $user_mail_today = $mail_log_info['total'];
            
            $sql = "SELECT * FROM `users` WHERE
	               `user_name`='" . mysql_clean($mail_to) . "'";
            $result = mysql_query($sql) or mysql_die($sql);
            
            if (mysql_num_rows($result) < 1)
            {
                $err = str_replace("[USERNAME]", $mail_to, $lang['no_user']);
            }
            else
            {
                $user_mail_today ++;
                
                if ($user_mail_today > $user_daily_mail_limit)
                {
                    set_message($lang['email_limit_exceeded'], 'success');
                    redirect(VSHARE_URL);
                    exit();
                }
                
                $sql = "INSERT INTO `mail_logs` SET
                       `mail_log_user_id`='" . (int) $_SESSION['UID'] . "',
                       `mail_log_time`='" . time() . "'";
                mysql_query($sql) or mysql_die($sql);
                
                $user_info = mysql_fetch_assoc($result);
                
                if ($user_info['user_private_message'] == 0)
                {
                    $err = str_replace('[MAIL_TO]', $mail_to, $lang['message_disabled']);
                }
                else if ($_SESSION['USERNAME'] == $user_info['user_name'])
                {
                    $err = $lang['message_yourself'];
                }
            }
            
            if (empty($err))
            {
                $sql = "SELECT * FROM `email_templates` WHERE
                       `email_id`='pm_notify'";
                $result = mysql_query($sql) or mysql_die($sql);
                $mail_template = mysql_fetch_assoc($result);
                $email_subject = $mail_template['email_subject'];
                $email_body = $mail_template["email_body"];
                $email_subject = str_replace("[SITE_NAME]", $config['site_name'], $email_subject);
                
                $email_body = str_replace('[MESSAGE]', $mail_body, $email_body);
                $email_body = str_replace('[SITE_NAME]', $config['site_name'], $email_body);
                $email_body = str_replace('[SITE_URL]', VSHARE_URL, $email_body);
                $email_body = str_replace('[USERNAME]', $_SESSION['USERNAME'], $email_body);
                
                $name = $config['admin_name'];
                $from = $config['admin_email'];
                
                $mail_details = array();
                $mail_details['from_email'] = $config['admin_email'];
                $mail_details['from_name'] = $config['site_name'];
                $mail_details['to_email'] = $user_info['user_email'];
                $mail_details['to_name'] = $mail_to;
                $mail_details['subject'] = $email_subject;
                $mail_details['body'] = $email_body;
                $mail = new Mail();
                $mail->send($mail_details);
                
                $sql = "INSERT INTO `mails` SET
                       `mail_subject`='" . mysql_clean($mail_subject) . "',
                       `mail_body`='" . mysql_clean($mail_body) . "',
                       `mail_sender`='" . mysql_clean($_SESSION['USERNAME']) . "',
                       `mail_receiver`='" . mysql_clean($mail_to) . "',
                       `mail_date`='" . date("Y-m-d H:i:s") . "'";
                $tmp = mysql_query($sql) or mysql_die($sql);
                
                set_message($lang['message_sent'], 'success');
                
                echo "sent";
                exit();
            }
        }
    }
    else if ($_GET['action'] == 'read' && isset($_GET['mail_id']))
    {
        $sql = "UPDATE `mails` SET
               `mail_read`='1' WHERE
               `mail_id`='" . (int) $_GET['mail_id'] . "' AND
               `mail_receiver`='" . mysql_clean($_SESSION['USERNAME']) . "'";
        mysql_query($sql) or mysql_die($sql);
        exit();
    }
    else if ($_GET['action'] == 'delete' && isset($_GET['mail_ids']))
    {
        require '../include/language/' . LANG . '/lang_mail_delete.php';
        
        $mail_ids = explode(",", $_GET['mail_ids']);
        
        $mail_folder = isset($_GET['mail_folder']) ? $_GET['mail_folder'] : 'inbox';
        
        $mail_folder_types = array(
            'inbox',
            'outbox'
        );
        
        if (! in_array($mail_folder, $mail_folder_types))
        {
            $mail_folder = 'inbox';
        }
        
        $who = ($mail_folder == 'inbox') ? 'mail_receiver' : 'mail_sender';
        
        for ($i = 0; $i < count($mail_ids); $i ++)
        {
            $sql = "UPDATE `mails` SET `mail_" . $mail_folder . "_track`='1' WHERE
                   `mail_id`=" . (int) $mail_ids[$i] . " AND
                   `$who`='" . mysql_clean($_SESSION['USERNAME']) . "'";
            mysql_query($sql) or mysql_die($sql);
        }
        
        $sql = "DELETE FROM `mails` WHERE
               `mail_inbox_track`=1 AND
               `mail_outbox_track`=1";
        mysql_query($sql) or mysql_die($sql);
        
        set_message($lang['mail_delete_success'], 'success');
        exit();
    }
}

$smarty->assign('mail_to', $mail_to);
$smarty->assign('mail_subject', $mail_subject);
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('error.tpl');
$smarty->display('mail_compose_ajax.tpl');
db_close();
