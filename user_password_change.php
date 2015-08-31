<?php
/******************************************************************************
 *
 * COMPANY: BuyScripts.in
 * PROJECT: vShare Youtube Clone
 * VERSION: VSHARE_VERSION_NUMBER_HERE
 * LICENSE: http://buyscripts.in/vshare-license
 * WEBSITE: http://buyscripts.in/vshare-youtube-clone
 *
 * This program is a commercial software and any kind of using it must agree
 * to vShare license.
 *
 ******************************************************************************/

require 'include/config.php';
require 'include/language/' . LANG . '/lang_user_profile_edit.php';

User::is_logged_in();

$user_info = User::get_user_by_id($_SESSION['UID']);

if (isset($_POST['submit'])) {
    if ($_POST['user_password'] == '') {
        $err = $lang['password_current_null'];
    } else if ($_POST['password_new'] == '') {
        $err = $lang['password_new_null'];
    } else if ($_POST['password_confirm'] == '') {
        $err = $lang['password_confirm_null'];
    } else if (mb_strlen($_POST['password_new']) < 4) {
        $err = $lang['password_length_error'];
    } else if ($_POST['password_new'] != $_POST['password_confirm']) {
        $err = $lang['password_match_error'];
    }

    if ($err == '') {
        $password_md5 = md5($_POST['user_password']);

        if ($user_info['user_password'] != $password_md5) {
            $err = $lang['password_invalid'];
        } else {
            $password_new_md5 = md5($_POST['password_new']);

            $sql = "UPDATE `users` SET
                   `user_password`='$password_new_md5' WHERE
                   `user_id`='" . (int) $_SESSION['UID'] . "'";
            DB::query($sql);

            $token = User::getPasswordToken($_SESSION['UID']);
            $_SESSION['pwd'] = $token;

            set_message($lang['password_success'], 'success');
            $redirect_url = VSHARE_URL . '/' . $user_info['user_name'];
            Http::redirect($redirect_url);
        }
    }
}

$smarty->assign(array(
    'err' => $err,
    'msg' => $msg,
    'sub_menu' => 'menu_home.tpl',
));
$smarty->display('header.tpl');
$smarty->display('user_password_change.tpl');
$smarty->display('footer.tpl');
DB::close();
