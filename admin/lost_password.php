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
require '../include/class.mail.php';

if (isset($_POST['submit']))
{
    $data1 = 'ADMIN_PWD_CHANGE';
    
    $sql = "SELECT * FROM `verify_code` WHERE
           `data1`='$data1'";
    $result = mysql_query($sql) or mysql_die($sql);
    
    if (mysql_num_rows($result) > 0)
    {
        $tmp = mysql_fetch_assoc($result);
        $verify_vkey = $tmp['vkey'];
        $verify_id = $tmp['id'];
        $new_password = $tmp['data2'];
    
    }
    else
    {
        $new_password = password_generator(6);
        $verify_vkey = substr(time() . rand(1, 99999999), 6);
        $verify_vkey = md5($verify_vkey);
        $sql = "INSERT INTO `verify_code` SET
           `vkey`='$verify_vkey',
           `data1`='$data1',
           `data2`='" . $new_password . "'";
        $result = mysql_query($sql) or mysql_die($sql);
        $verify_id = mysql_insert_id();
    }
    
    $verify_url = VSHARE_URL . '/admin/reset_password.php?k=' . $verify_vkey . '&i=' . $verify_id;
    
    $sql = "SELECT * FROM `email_templates` WHERE
           `email_id`='password_reset_admin'";
    $result = mysql_query($sql) or mysql_die($sql);
    $email_info = mysql_fetch_assoc($result);
    $email_subject = $email_info['email_subject'];
    $email_body = $email_info['email_body'];
    
    $email_subject = str_replace('[SITE_NAME]', $config['site_name'], $email_subject);
    $email_body = str_replace('[ADMIN_NAME]', $config['admin_name'], $email_body);
    $email_body = str_replace('[PASSWORD]', $new_password, $email_body);
    $email_body = str_replace('[REMOTE_ADDR]', $_SERVER['REMOTE_ADDR'], $email_body);
    $email_body = str_replace('[VERIFY_URL]', $verify_url, $email_body);
    $email_body = str_replace('[SITE_URL]', VSHARE_URL, $email_body);
    $email_body = str_replace('[SITE_NAME]', $config['site_name'], $email_body);
    
    $mail_info = array();
    $mail_info['from_email'] = $config['admin_email'];
    $mail_info['from_name'] = $config['site_name'];
    $mail_info['to_email'] = $config['admin_email'];
    $mail_info['to_name'] = $config['admin_name'];
    $mail_info['subject'] = $email_subject;
    $mail_info['body'] = $email_body;
    $mail = new Mail();
    $mail->send($mail_info);
}
$smarty->display('admin/header.tpl');
$smarty->display('admin/lost_password.tpl');
$smarty->display('admin/footer.tpl');
db_close();
