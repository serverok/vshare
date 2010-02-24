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
require '../include/language/' . LANG . '/lang_admin_settings_signup.php';

check_admin_login();

if (isset($_POST['submit']))
{
    
    if (is_numeric($_POST['signup_dob']))
    {
        $sql = "UPDATE `config` SET
               `config_value`='" . (int) $_POST['signup_dob'] . "' WHERE
               `config_name`='signup_dob'";
        mysql_query($sql) or mysql_die($sql);
    }
    
    if (is_numeric($_POST['signup']))
    {
        $sql = "UPDATE `config` SET
               `config_value`='" . (int) $_POST['signup'] . "' WHERE
               `config_name`='signup_enable'";
        mysql_query($sql) or mysql_die($sql);
    }
    
    if (is_numeric($_POST['signup']))
    {
        $sql = "UPDATE `sconfig` SET
               `svalue`='" . (int) $_POST['signup_captcha'] . "' WHERE
               `soption`='signup_captcha'";
        mysql_query($sql) or mysql_die($sql);
        $smarty->assign('signup_captcha', $_POST['signup_captcha']);
    }
    
    if (is_numeric($_POST['signup']))
    {
        $sql = "UPDATE `sconfig` SET
               `svalue`='" . (int) $_POST['signup_verify'] . "' WHERE
               `soption`='signup_verify'";
        mysql_query($sql) or mysql_die($sql);
        $smarty->assign('signup_verify', $_POST['signup_verify']);
    }
    
    if (is_numeric($_POST['notify_signup']))
    {
        $sql = "UPDATE `sconfig` SET
               `svalue`='" . (int) $_POST['notify_signup'] . "' WHERE
               `soption`='notify_signup'";
        mysql_query($sql) or mysql_die($sql);
        $smarty->assign('notify_signup', $_POST['notify_signup']);
    }
    
    $captcha_type_all = array(
        'default',
        'recaptcha'
    );
    
    if (in_array($_POST['captcha_type'], $captcha_type_all))
    {
        $sql = "UPDATE `config` SET
               `config_value`='" . $_POST['captcha_type'] . "' WHERE
               `config_name`='captcha_type'";
        mysql_query($sql) or mysql_die($sql);
    }
    
    $signup_auto_friend = trim($_POST['signup_auto_friend']);
    
    if ($signup_auto_friend != '')
    {
        if (check_field_exists($signup_auto_friend, 'user_name', 'users'))
        {
            $sql = "UPDATE `config` SET
                   `config_value`='" . mysql_clean($signup_auto_friend) . "' WHERE
                   `config_name`='signup_auto_friend'";
            mysql_query($sql) or mysql_die($sql);
        }
        else
        {
            $err = str_replace('[USERNAME]', $signup_auto_friend, $lang['user_not_found']);
        }
    }
    
    if ($err == '')
    {
        $msg = $lang['settings_updated'];
    }
}

$smarty->assign('signup_enable', get_config('signup_enable'));
$smarty->assign('signup_auto_friend', get_config('signup_auto_friend'));
$smarty->assign('signup_dob', get_config('signup_dob'));
$smarty->assign('captcha_type', get_config('captcha_type'));
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->display('admin/header.tpl');
$smarty->display('admin/settings_signup.tpl');
$smarty->display('admin/footer.tpl');
db_close();
