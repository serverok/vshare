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
require 'include/language/' . LANG . '/lang_login.php';

if (isset($_POST['action_login']))
{
    $user_name = htmlspecialchars_uni($_POST['user_name']);
    $smarty->assign('user_name', $user_name);
    $password = $_POST['user_password'];

    if ($user_name == '') {
        $err = $lang['user_name_empty'];
    } else if ($password == '') {
        $err = $lang['password_empty'];
    }

    if ($err == '') {
        if (get_magic_quotes_gpc()) {
            $user_name = stripslashes($user_name);
            $password = stripslashes($password);
        }

        $user_info = User::getUserByName($user_name);

        if ($user_info['user_password'] != md5($password)) {
            $err = $lang['invalid_login'];
        }
        else
        {
            if ($user_info['user_account_status'] == 'Inactive') {
                if ($config['enable_package'] == 'yes') {
                    $sql = "SELECT * FROM
                           `subscriber` AS `subs`,
                           `packages` AS `p` WHERE
                            subs.UID=" . (int) $user_info['user_id'] . " AND
                            subs.pack_id=p.package_id";
                    $result = mysql_query($sql) or mysql_die($sql);
                    $package_info = mysql_fetch_assoc($result);

                    if ($package_info['package_trial'] != 'yes') {
                        $redirect_url = $config['baseurl'] . '/renew_account.php?uid=' . $user_info['user_id'];
                        redirect($redirect_url);
                    }
                }

                if ($config['signup_verify'] == '2') {
                    $err = $lang['inactive_user_admin'];
                    $smarty->assign('inactive_user', '0');
                } else {
                    $err = $lang['inactive_user'];
                    $smarty->assign('inactive_user', '1');
                }

                $_SESSION['INACTIVE_USER'] = $user_info['user_name'];
            } else if ($user_info['user_account_status'] == 'Suspended') {
                $err = $lang['user_suspended'];
            }
        }

        if ($err == '')
        {
            if ($config['enable_package'] == 'yes') {
                $sql = "SELECT * FROM `subscriber` WHERE
                       `UID`=" . (int) $user_info['user_id'];
                $result = mysql_query($sql) or mysql_die($sql);

                if (mysql_num_rows($result) < 1) {
                    $sql = "INSERT INTO `subscriber` SET
                           `UID`=" . (int) $user_info['user_id'];
                    mysql_query($sql) or mysql_die($sql);
                    $sql = "SELECT * FROM `subscriber` WHERE
                           `UID`=" . (int) $user_info['user_id'];
                    $result = mysql_query($sql) or mysql_die($sql);
                }

                $subscription = mysql_fetch_assoc($result);

                if ($subscription['pack_id'] == 0) {
                    $sql = "SELECT * FROM `packages` WHERE
                           `package_trial`='yes'";
                    $result = mysql_query($sql) or mysql_die($sql);
                    $package_row = mysql_fetch_assoc($result);
                    $expired_time = date("Y-m-d H:i:s", strtotime("+" . $package_row['package_trial_period'] . " day"));
                    $sql = "UPDATE `subscriber` SET
                           `pack_id`='" . (int) $package_row['package_id'] . "',
                           `subscribe_time`='" . date("Y-m-d H:i:s") . "',
                           `expired_time`='$expired_time' WHERE
                           `UID`=" . (int) $user_info['user_id'];
                    mysql_query($sql) or mysql_die($sql);
                } else {
                    check_subscriber_duration($user_info['user_id']);
                }
            }

            User::login($user_name);

            if (isset($_POST['autologin'])) {
                User::set_auto_login_cookie($user_name);
            }

            if (isset($_SESSION['REDIRECT']) && $_SESSION['REDIRECT'] != '') {
                $redirect_url = $_SESSION['REDIRECT'];
                $_SESSION['REDIRECT'] = '';
            } else {
                $redirect_url = $config['baseurl'] . '/' . $user_info['user_name'];
            }

            redirect($redirect_url);
        }
    }
}

$smarty->assign(array(
    'html_title' => 'Login',
    'html_description' => 'Login'
));
$smarty->assign('err', $err);
$smarty->assign('msg', $msg);
$smarty->assign('sub_menu', 'menu_home.tpl');
$smarty->display('header.tpl');
$smarty->display('login.tpl');
$smarty->display('footer.tpl');
DB::close();
