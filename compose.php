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
require 'include/class.mail.php';
require 'include/language/' . LANG . '/lang_compose.php';

User::is_logged_in();

if (isset($_POST['send']))
{
    
    $mail_to = isset($_POST['mail_to']) ? $_POST['mail_to'] : '';
    $mail_subject = isset($_POST['mail_subject']) ? $_POST['mail_subject'] : '';
    $mail_subject = htmlspecialchars_uni($mail_subject);
    $mail_body = htmlspecialchars_uni($_POST['mail_body']);
    
    $smarty->assign('mail_to', htmlspecialchars_uni($mail_to));
    $smarty->assign('mail_body', $mail_body);
    $smarty->assign('mail_subject', $mail_subject);
    
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
    else
    {
        $sql = "SELECT * FROM `users` WHERE
               `user_name`='" . mysql_clean($mail_to) . "'";
        $result = mysql_query($sql) or mysql_die($sql);
        
        if (mysql_num_rows($result) > 0)
        {
            $user_info = mysql_fetch_assoc($result);
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
            $redirect_url = VSHARE_URL . '/mail.php';
            redirect($redirect_url);
        
        }
        else
        {
            $err = str_replace("[USERNAME]", $mail_to, $lang['no_user']);
        }
    }
}

if (isset($_GET['receiver']))
{
    $mail_to = isset($_GET['receiver']) ? $_GET['receiver'] : '';
    $mail_subject = isset($_GET['subject']) ? $_GET['subject'] : '';
    $smarty->assign('mail_to', $mail_to);
    $smarty->assign('mail_subject', $mail_subject);
}

$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->assign('sub_menu', 'menu_message.tpl');
$smarty->display('header.tpl');
$smarty->display('compose.tpl');
$smarty->display('footer.tpl');
db_close();
