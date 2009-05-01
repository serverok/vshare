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
require 'include/class.validate.php';
require 'include/language/' . LANG . '/lang_recoverpass.php';

$mail_send = 0;

if (isset($_POST['recover']))
{
    $user_name = isset($_POST['username']) ? $_POST['username'] : '';
    $user_email = isset($_POST['email']) ? $_POST['email'] : '';
    $user_name = htmlspecialchars_uni($user_name);
    $user_email = htmlspecialchars_uni($user_email);
    
    if (($user_email == '') && ($user_name == ''))
    {
        $err = $lang['fields_null'];
    }
    else
    {
        if ($user_name != '')
        {
            if (check_field_exists($user_name, 'user_name', 'users') == 1)
            {
                $query = " WHERE `user_name`='" . mysql_clean($user_name) . "'";
            }
            else
            {
                $err = $lang['user_name_not_found'];
            }
        }
        else if ($user_email != '')
        {
            if (validate::email($user_email) == 1)
            {
                if (check_field_exists($user_email, 'user_email', 'users') == 1)
                {
                    $query = " WHERE `user_email`='" . mysql_clean($user_email) . "'";
                }
                else
                {
                    $err = $lang['email_not_found'];
                }
            }
            else
            {
                $err = $lang['email_invalid'];
            }
        }
        
        if ($err == '')
        {
            $sql = "SELECT * FROM `users`" . $query;
            $result = mysql_query($sql) or mysql_die($sql);
            $num_rows = mysql_num_rows($result);
            $user_info = mysql_fetch_assoc($result);
            # print_r($user_info);exit;
            $uid = $user_info['user_id'];
            $user_email = $user_info['user_email'];
            
            $data1 = 'PWD_RESET' . $uid;
            $sql = "SELECT * FROM `verify_code` WHERE
                   `data1`='" . mysql_clean($data1) . "'";
            $result = mysql_query($sql) or mysql_die($sql);
            
            if (mysql_num_rows($result) > 0)
            {
                $myobj = mysql_fetch_assoc($result);
                $verify_id = $myobj['id'];
                $verify_vkey = $myobj['vkey'];
                $new_password = $myobj['data2'];
            }
            else
            {
                $new_password = password_generator(6);
                $verify_vkey = $_SERVER['REQUEST_TIME'] . rand(1, 99999999);
                $verify_vkey = md5($verify_vkey);
                $sql = "INSERT INTO `verify_code` SET
                       `vkey`='" . mysql_clean($verify_vkey) . "',
                       `data1`='" . mysql_clean($data1) . "',
                       `data2`='" . mysql_clean($new_password) . "'";
                $result = mysql_query($sql) or mysql_die($sql);
                $verify_id = mysql_insert_id();
            }
            
            $sql = "SELECT * FROM `email_templates` WHERE
                   `email_id`='recover_password'";
            $result = mysql_query($sql) or mysql_die($sql);
            $email_templates = mysql_fetch_assoc($result);
            $email_subject = $email_templates['email_subject'];
            $email_body = $email_templates['email_body'];
            $verify_url = VSHARE_URL . '/reset_password.php?k=' . $verify_vkey . '&i=' . $verify_id . '&u=' . $uid;
            
            $email_body_tmp = $email_body;
            $email_body_tmp = str_replace('[RECEIVER_NAME]', $user_info['user_name'], $email_body_tmp);
            $email_body_tmp = str_replace('[SITE_URL]', VSHARE_URL, $email_body_tmp);
            $email_body_tmp = str_replace('[PASSWORD]', $new_password, $email_body_tmp);
            $email_body_tmp = str_replace('[VERIFY_URL]', $verify_url, $email_body_tmp);
            $email_body_tmp = str_replace('[SITE_NAME]', $config['site_name'], $email_body_tmp);
            $email_body_tmp = str_replace('[USER_IP]', $_SERVER['REMOTE_ADDR'], $email_body_tmp);
            $email_subject = str_replace('[SITE_NAME]', $config['site_name'], $email_subject);
            
            $mail_detailes = array();
            $mail_detailes['from_email'] = $config['admin_email'];
            $mail_detailes['from_name'] = $config['site_name'];
            $mail_detailes['to_email'] = $user_email;
            $mail_detailes['to_name'] = '';
            $mail_detailes['subject'] = $email_subject;
            $mail_detailes['body'] = $email_body_tmp;
            $mail = new Mail();
            $mail->send($mail_detailes);
            $mail_send = 1;
            $msg = $lang['mail_send'];
        }
    }
}

$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->assign('sub_menu', 'menu_home.tpl');
$smarty->assign('html_title', 'Lost Password Recovery Form');
$smarty->display('header.tpl');

if ($mail_send == 0)
{
    $smarty->display('recoverpass.tpl');
}

$smarty->display('footer.tpl');
db_close();
